<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class Playground extends Command
{
  protected $signature = 'playground';
  protected $description = "Playground script";

  public function handle()
  {
    $user = User::find('42oecqk');

    $this->line(print_r($user->toArray(), 1));
  }
}