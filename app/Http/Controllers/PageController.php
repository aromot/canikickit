<?php

namespace App\Http\Controllers;

use App\Lib\Apps\MainAppHandler;

class PageController extends Controller
{
  public function homepage()
  {
    return MainAppHandler::render();
  }
}