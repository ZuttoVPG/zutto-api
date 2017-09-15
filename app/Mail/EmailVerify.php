<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerify extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    } // end __construct

    public function build()
    {
        return $this->view('mail.email-verify')
            ->subject('Zuttopets - Verify Email')
            ->with([
                'username' => $this->user->username,
                'id' => $this->user->id,
                'verifyToken' => $this->user->emailVerifyToken,
            ]);
    } // end build
} // end EmailVerify
