<?php

namespace App\Http\Controllers;

use App\Jobs\Email\EmailJob;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function test()
    {

        $user = User::find(2);

        $link =  "https://google.com";
        EmailJob::dispatch($user, "App\Mail\WelcomeUserMail", ["user" => $user, "link" => $link]);

        // Mail::to($user->email)->send(new WelcomeUserMail($user, "https://google.com"));
    }
}
