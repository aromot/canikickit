<?php

namespace App\Http\Controllers;

use App\Lib\Users\UserHandler;
use App\Mail\UserRegistration;
use App\User;
use DateTime;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function register(Request $request)
  {
    $inputs = $request->all();

    // @todo validation

    $user = User::make($inputs['username'], $inputs['email'], $inputs['password']);
    $user->save();

    $email = new UserRegistration($user);
    if(isDev()) {
      $dumpFile = storage_path('email_dumps/'. date('H-m-d__his') . '.html');
      makePathDir($dumpFile);
      file_put_contents($dumpFile, $email->render());
    } else {
      // Mail::to('somebody@example.org')->send(new MyEmail());
    }

    UserHandler::setApiKeyCookie($user);

    return compact('inputs', 'user');
  }

  public function confirm($activation_key, Request $request)
  {
    $user = User::where('activation_key', $activation_key)->first();

    if(empty($user)) {
      // abort(500, "Could not find the user.");  // NON, on ne veut pas afficher d'erreur dans ce cas.
      return redirect()->route('homepage'); // simple redirection (warning silencieux à logger)
    }

    $user->confirm();
    $user->save();

    if( ! $request->hasCookie('canikeykit')) {
      UserHandler::setApiKeyCookie($user);
    }

    return redirect()->route('homepage', ['userConfirm' => true]);
  }
}