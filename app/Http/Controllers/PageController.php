<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
  public function homepage(Request $request)
  {
    $inputs = [
      'initRoute' => route('main_app.init')
    ];
    
    $userConfirm = $request->input('userConfirm');
    if( ! is_null($userConfirm))
      $inputs['userConfirm'] = $userConfirm === '1';

    $initScript = "<script>var CIKI_inputs = ".json_encode($inputs, JSON_PRETTY_PRINT)."</script>";

    return view('main', compact('initScript'));
  }
}