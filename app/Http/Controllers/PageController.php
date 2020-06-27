<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
  public function homepage()
  {
    return view('main');
  }
}