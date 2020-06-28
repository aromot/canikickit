<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
  public function homepage()
  {
    $inputs = [
      'initRoute' => route('main_app.init')
    ];
    $initScript = "<script>var CIKI_inputs = ".json_encode($inputs, JSON_PRETTY_PRINT)."</script>";

    return view('main', compact('initScript'));
  }
}