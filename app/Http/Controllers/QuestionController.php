<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function store($name,$email,$quest,$status)
    {
        // Validate the request...
 
        $question = new Question;
 
        $question->name = $name;
        $question->email = $email;
        $question->question = $quest;
        $question->status= $status;

        $question->save();
    }
    public function allQuestions()
    {   $questions= Question::all();
        return view("admin",[

        'questions' => $questions
        ]);
    }
    public function updateStatus(Request $request)
    {
        // Validate the request...
 
        $question = Question::find($request->id);

        $question->status= $request->status==1?"open":"closed";

        $question->save();
        return redirect('/admin');
    }
}
