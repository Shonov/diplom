<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use ProfPlatforma\Users\Models\User;

class RegistrationComplited extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var User
     */
    private $user;
    /**
     * @var string
     */
    private $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.registration', [
            'user' => $this->user,
            'password' => $this->password,
        ]);
    }
}
