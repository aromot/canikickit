<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
  public function register()
  {


    $user = new User();

    return compact('user');
  }
}