<?php

namespace App\Botman;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Http\Controllers\QuestionController;

class OnboardingConversation extends Conversation
{
    protected $name;

    protected $email;

    protected $query;
    
    protected $json_data;

    protected $g_data;


    protected  $count=1;

    public function askName()
    {
        $this->ask("hi what is your name", function(Answer $answer) {
            // Save result
            $this->name = $answer->getText();
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('Nice to meet you '.strval($this->name).' what is your email address?', function(Answer $answer) {
            // Save result
            $this->email = $answer->getText();
            $this->json_data=json_decode(file_get_contents(storage_path() . "/data.json"), true);
            $this->say('Great- that is all we need,  ');
            $this->askHelp($this->json_data);
        });
    }

    public function askHelp($data)
    {
        
        
        $buttons=[];
        $this->g_data=$data;
    
        for($i=0;$i<sizeof($data);$i++){
            if(!is_null($data[$i]['name'])){
           // $this->say('Great- that is all we need,  '.$data[$i]['name']);
           array_push($buttons,Button::create($data[$i]['name'])->value($data[$i]['name']));
            
            }
            
        }
        
        $question = Question::create($this->count.' What kind of problem do you have ?')
        ->addButtons($buttons);
        $this->count++;

        $this->ask($question, function (Answer $answer) {
        // Detect if button was clicked:
            
        if ($answer->isInteractiveMessageReply()) {
            $selectedValue = $answer->getValue(); 
            $selectedText = $answer->getText(); // will be either 'Of course' or 'Hell no!'
            
            for($i=0;$i<sizeof($this->g_data);$i++){
                if(!is_null($this->g_data[$i]['name'])){
               // $this->say('Great- that is all we need,  '.$data[$i]['name']);
               $buttons=[];
               array_push($buttons,Button::create($this->g_data[$i]['name'])->value($this->g_data[$i]['name']));
               if($this->g_data[$i]['name']==$selectedText){
                $newdata=$this->g_data[$i]['subCategories'];
                //$this->say('Great- that is all we need,  '. strval($newdata));
                //if(sizeof($newdata)!=0)
                
                if(sizeof($newdata)!=0){
                    $this->say("move to next question");
                    $this->askHelp($newdata);

                }
                else{
                    $this->say("response is:");
                    $this->say($this->g_data[$i]['response']);
                    $this->askQuit();
                }
                //(sizeof($newdata)!=0)?$this->askHelp($newdata):$this->say($this->g_data[$i]['response']);
               
                        break;
               }
               
                
                }
                
            }  
        }
         });
         
    }  
 
    public function askQuit()
    {
       
            
            $this->ask(' this response meet your needs??Y/N ', function(Answer $answer) {
                if( $answer->getText()=='Y')
                $this->say("thanks");
                else if( $answer->getText()=='N'){
                    $this->ask("please write your exact question",function(Answer $answer){
                        $q = new QuestionController;
                        $q->store($this->name,$this->email,$answer->getText(),"open");
                    });
                    
                }
                

            });
          
    }
    public function run()
    {
        // This will be called immediately
        
        $this->askName();
    }
}
