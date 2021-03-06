<?php

namespace App;

use App\Lib\Users\UserHandler;
use App\Models\Role;
use CikiLib\IdGenerator;
use DateTime;
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
		'password', 'activation_key', 'active', 'confirmed_at', 'api_key', 
		'created_at', 'date_pass_reset_limit', 'pass_reset_key', 'status'
	];

	/**
	 * The roles that belong to the user.
	 */
	public function roles()
	{
			return $this->belongsToMany(Role::class);
	}

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
		$this->activation_key = null;
		$this->status = self::STATUS_CONFIRMED;
		$this->confirmed_at = Carbon::create()->now();
	}

	public function setPassReset()
	{
		$this->pass_reset_key = UserHandler::generatePassResetKey();
    $this->date_pass_reset_limit = (new DateTime('+ 24 hours'))->format('Y-m-d H:i:s');
	}

	public function resetPassword(string $newPass)
	{
		$this->pass_reset_key = null;
		$this->date_pass_reset_limit = null;
		$this->password = UserHandler::hashPassword($newPass);
	}

	public function isActive(): bool
	{
		if(is_bool($this->active))
			return $this->active;

		if(is_numeric($this->active))
			return $this->active === 1;

		return (string) $this->active === '1';
	}

	public function isConfirmed(): bool
	{
		return $this->status === self::STATUS_CONFIRMED;
	}
}
