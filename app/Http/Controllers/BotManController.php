<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Botman\OnboardingConversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;



class BotManController extends Controller
{
    function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function ($botman, $message) {

            $botman->startConversation(new OnboardingConversation);
        });

        $botman->listen();

    }
}
