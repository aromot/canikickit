<?php

namespace App\Lib\Users;

use App\User;
use CikiLib\IdGenerator;
use DateTime;

class UserHandler
{
  // https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
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

  static public function setApiKeyCookie(User $user): void
  {
    $expire = (new DateTime('+ 13 months'))->format('U');
    setcookie('canikeykit', $user->api_key, $expire, '/');
  }
}