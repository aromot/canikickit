<?php

namespace App\Http\Controllers;

use App\Lib\Roles\RoleHandler;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
  public function install()
  {
    $roleNb = Role::count();

    if($roleNb > 0)
      return ['error' => "Roles are already installed."];

    RoleHandler::installRoles();

    $roles = Role::all();

    return compact('roles');
  }
}