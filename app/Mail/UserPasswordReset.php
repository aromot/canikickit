<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPasswordReset extends Mailable
{
  use Queueable, SerializesModels;

  private $user;

  function __construct(User $user)
  {
    $this->user = $user;
  }

  public function build() {
    $urlResetPass = route('users.formResetPassword', ['pass_reset_key' => $this->user->pass_reset_key]);

    return $this->view('emails.users.resetPassword')
      ->with('urlResetPass', $urlResetPass)
      ->with('user', $this->user);
  }
}