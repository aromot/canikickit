<?php

namespace App\Http\Controllers;

use App\Lib\Apps\MainAppHandler;
use App\Lib\Roles\RoleHandler;
use App\Lib\Users\UserHandler;
use App\Mail\UserPasswordReset;
use App\Mail\UserRegistration;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  public function register(Request $request)
  {
    $inputs = $request->all();

    // @todo validation

    if(Role::count() === 0) {
      RoleHandler::installRoles();
    }

    $user = User::make($inputs['username'], $inputs['email'], $inputs['password']);
    $role = Role::where('name', 'member')->first();
    
    DB::transaction(function() use ($user, $role) {
      $user->save();
      $user->roles()->save($role);
    });

    $email = new UserRegistration($user);
    $this->sendEmail($email, $user);

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

    return MainAppHandler::render(['userConfirm' => true]);
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
  }

  public function logout(Request $request)
  {
    setcookie(UserHandler::getApiKeyToken(), '', time() - 99999, '/');  // delete cookie
    return ['user' => null];
  }

  public function sendPasswordReset(Request $request)
  {
    $inputs = $request->all();

    // @todo validation

    $user = User::where('email', $inputs['email'])->first();

    if(empty($user)) {
      return [];
    }

    $user->setPassReset();
    $user->save();

    $email = new UserPasswordReset($user);
    $this->sendEmail($email, $user);

    return [];
  }

  public function formResetPassword($pass_reset_key)
  {
    return MainAppHandler::render(['resetPass' => true, 'pass_reset_key' => $pass_reset_key]);
  }

  public function resetPassword(Request $request)
  {
    $inputs = $request->all();

    // @todo validation

    if($inputs['new_password'] !== $inputs['new_password_confirmation'])
      return ['error' => "Wrong password confirmation", 'field' => 'new_password_confirmation'];

    $user = User::where('pass_reset_key', $inputs['resetKey'])->first();

    if(empty($user))
      return ['error' => 'Error resetting the password.'];

    $user->resetPassword($inputs['new_password']);
    $user->save();

    return [];
  }

  private function sendEmail(Mailable $email, User $user): void
  {
    if(isDev()) {
      $dumpFile = storage_path('email_dumps/'. date('Y-m-d__His') . '.html');
      makePathDir($dumpFile);
      file_put_contents($dumpFile, $email->render());
    } else {
      // Mail::to('somebody@example.org')->send(new MyEmail());
    }
  }
}