<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthorInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $accept_link, $reject_link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($arguments)
    {
        $this->user = $arguments['user'];
        $this->accept_link = $arguments['accept_link'];
        $this->reject_link = $arguments['reject_link'];
        $this->subject = "You are invited as Co-Author";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.author_invite');
    }
}
