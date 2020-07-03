<?php

namespace App\Http\Controllers;

use App\Lib\Users\UserHandler;
use App\Mail\UserRegistration;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

  public function edit(Request $request)
  {
    $inputs = $request->all();
    
    // @todo validation
    if($inputs['new_password'] !== $inputs['new_password_confirm'])
      return ['error' => "Wrong password confirmation."];

    $user = Auth::user();

    if( ! UserHandler::checkPassword($user->password, $inputs['password']))
      return ['error' => "Wrong password.", 'field' => 'password'];
    
    $user->username = $inputs['username'];
    $user->email = $inputs['email'];
    if( ! empty($inputs['new_password']))
      $user->password = UserHandler::hashPassword($inputs['new_password']);
    $user->save();

    return compact('user');
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

    if( ! $request->hasCookie( UserHandler::getApiKeyToken() )) {
      UserHandler::setApiKeyCookie($user);
    }

    return redirect()->route('homepage', ['userConfirm' => true]);
  }

  public function login(Request $request)
  {
    $inputs = $request->all();

    // @todo validation

    try {
      $user = UserHandler::authenticate($inputs['usernameEmail'], $inputs['password']);
    } catch (\Throwable $th) {
      return [
        'error' => $th->getMessage()
      ];
    }

    UserHandler::setApiKeyCookie($user);
    return compact('user');
    // return redirect()->route('homepage');
  }

  public function logout(Request $request)
  {
    setcookie(UserHandler::getApiKeyToken(), '', time() - 99999, '/');  // delete cookie
    return ['user' => null];
    // return redirect()->route('homepage', ['logout' => true]);
  }
}