<?php

namespace App\Jobs;

use App\Mail\ResetPasswordMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailResetJob implements ShouldQueue
{
    use Queueable,InteractsWithQueue,SerializesModels;
    public $resetUrl;
    public $email;

    /**
     * Create a new job instance.
     */
    public function __construct($resetUrl, $email)
    {
        $this->resetUrl = $resetUrl;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new ResetPasswordMail($this->resetUrl));
    }
}
