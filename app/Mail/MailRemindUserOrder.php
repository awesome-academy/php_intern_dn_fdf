<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailRemindUserOrder extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.mail-remind-user', [
            'user' => $this->user,
            'message_remind' => $this->message
        ]);
    }
}
