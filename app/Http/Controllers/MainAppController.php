<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MainAppController extends Controller
{
  public function init()
  {
    $routes = [
      'homepage' => route('homepage')
    ];
    $user = Auth::user();

    return compact('routes', 'user');
  }
}