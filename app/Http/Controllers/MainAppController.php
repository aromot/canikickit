<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MainAppController extends Controller
{
  public function init()
  {
    $routes = [
      'homepage' => route('homepage'),
      'users.register' => route('users.register'),
      'users.login' => route('users.login'),
      'users.logout' => route('users.logout'),
      'users.edit' => route('users.edit'),
    ];
    $user = Auth::user();

    return compact('routes', 'user');
  }
}