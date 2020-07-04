<?php

namespace App\Lib\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleHandler
{
  static public function installRoles()
  {
    return DB::transaction(function() {
      $roleNames = ['member', 'admin'];
      foreach($roleNames as $roleName) {
        $role = Role::make($roleName);
        $role->save();
      }
    });
  }
}