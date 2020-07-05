<?php

namespace App\Lib\Apps;

use App\Models\Role;
use CikiLib\Apps\FrontendApp;

class MainAppHandler {
  static public function render(array $payload = [])
  {
    $feApp = new FrontendApp('main_app');
    $mainAppScripts = $feApp->getSmartScripts();

    $initScript = $feApp->getInitScript($payload + [
      'rolesInstalled' => Role::count() > 0
    ]);

    return view('main', compact('initScript', 'mainAppScripts'));
  }
}