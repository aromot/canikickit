<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function register(Request $request)
  {
    $inputs = $request->all();
    $user = User::make($inputs['username'], $inputs['email'], $inputs['password']);

    $user->save();

    return compact('inputs', 'user');
  }
}