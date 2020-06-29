<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistration extends Mailable
{
  use Queueable, SerializesModels;

  private $user;

  function __construct(User $user)
  {
    $this->user = $user;
  }

  public function build() {
    $urlConfirm = route('users.confirm', ['activation_key' => $this->user->activation_key]);

    return $this->view('emails.users.registration')
      ->with('urlConfirm', $urlConfirm)
      ->with('user', $this->user);
  }
}