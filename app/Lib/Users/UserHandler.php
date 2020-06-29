<?php

namespace App\Lib\Users;

use CikiLib\IdGenerator;

class UserHandler
{
  static public function hashPassword(string $pass): string
  {
    return password_hash(
      base64_encode(
          hash('sha256', $pass, true)
      ),
      PASSWORD_DEFAULT
    );
  }

  static public function generateApiKey(): string
  {
    return IdGenerator::generate(7);
  }

  static public function generateActivationKey(): string
  {
    return md5(IdGenerator::generate(10));
  }
}