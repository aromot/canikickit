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

    $updateInputs = function(array $inputs, string $token, $expected) use ($request) {
      $input = $request->input($token);
      if( ! is_null($input))
        $inputs[$token] = $input === $expected;
      return $inputs;
    };

    $inputs = $updateInputs($inputs, 'userConfirm', '1');
    $inputs = $updateInputs($inputs, 'logout', '1');

    $initScript = "<script>var CIKI_inputs = ".json_encode($inputs, JSON_PRETTY_PRINT)."</script>";

    return view('main', compact('initScript'));
  }
}