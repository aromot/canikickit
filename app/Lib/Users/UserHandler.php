<?php

namespace App\Lib\Users;

use App\User;
use CikiLib\IdGenerator;
use DateTime;
use Exception;

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

  static public function generatePassResetKey(): string
  {
    return md5(IdGenerator::generate(10));
  }

  static public function setApiKeyCookie(User $user): void
  {
    $expire = (new DateTime('+ 13 months'))->format('U');
    setcookie(UserHandler::getApiKeyToken(), $user->api_key, $expire, '/');
  }

  static public function getApiKeyToken(): string
  {
    return env('APP_KEY_TOKEN');
  }

  static public function authenticate(string $usernameOrEmail, string $pass): User
  {
    $user = User::where('email', $usernameOrEmail)
      ->orWhere('username', $usernameOrEmail)
      ->first();

    if(empty($user))
      throw new Exception("User not found.");

    if( ! $user->isActive())
      throw new Exception("User account is not active.");

    if( ! $user->isConfirmed())
      throw new Exception("User account is not confirmed.");

    if( ! self::checkPassword($user->password, $pass))
      throw new Exception("Wrong password.");

    return $user;
  }

  static public function checkPassword(string $storedPass, string $clearPass): bool
  {
    return password_verify(base64_encode(hash('sha256', $clearPass, true)), $storedPass);
  }
}