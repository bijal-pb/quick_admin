<?php

namespace App\Jobs\Email;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $cls, $arguments, $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $cls, $arguments)
    {
        $this->user = $user;
        $this->cls = $cls;
        $this->arguments = $arguments;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(new $this->cls($this->arguments));
    }
}
