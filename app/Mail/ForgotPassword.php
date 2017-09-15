<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    } // end __construct

    public function build()
    {
        return $this->view('mail.forgot-password')
            ->subject('Zuttopets - Password Reset')
            ->with([
                'username' => $this->user->username,
                'id' => $this->user->id,
                'passwordResetToken' => $this->user->password_reset_token,
            ]);
    } // end build
} // end EmailVerify
