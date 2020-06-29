<?php

namespace App;

use App\Lib\Users\UserHandler;
use CikiLib\IdGenerator;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
	use Authenticatable, Authorizable;

	const STATUS_TO_CONFIRM = 'to_confirm';
	const STATUS_CONFIRMED = 'confirmed';

	const UPDATED_AT = null;

	/**
	 * Indicates if the IDs are auto-incrementing.
	 *
	 * @var bool
	 */
	public $incrementing = false;

	/**
	 * The "type" of the auto-incrementing ID.
	 *
	 * @var string
	 */
	protected $keyType = 'string';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id', 'username', 'email', 'password', 'status', 'active', 'api_key', 'activation_key'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
	];

	static public function make(string $username, string $email, string $pass): self
	{
		$user = new self([
			'id' => IdGenerator::generate(7),
			'username' => $username,
			'email' => $email,
			'password' => UserHandler::hashPassword($pass),
			'status' => self::STATUS_TO_CONFIRM,
			'active' => 1,
			'api_key' => UserHandler::generateApiKey(),
			'activation_key' => UserHandler::generateActivationKey()
		]);

		return $user;
	}

	public function confirm()
	{
		$this->status = self::STATUS_CONFIRMED;
		$this->confirmed_at = Carbon::create()->now();
	}
}
