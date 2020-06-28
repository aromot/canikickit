<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MainAppController extends Controller
{
  public function init()
  {
    $routes = [
      'homepage' => route('homepage'),
      'users.register' => route('users.register')
    ];
    $user = Auth::user();

    return compact('routes', 'user');
  }
}