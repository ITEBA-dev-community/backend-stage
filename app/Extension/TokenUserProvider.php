<?php 

namespace App\Extension;

use App\Models\User;
use App\Models\user_active;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as Auth;

class TokenUserProvider implements UserProvider
{
	private $user;
    private $user_active;

	public function __construct (User $user, user_active $user_active) 
    {
		$this->user = $user;
		$this->user_active = $user_active;
	}

	public function retrieveById($identifier)
    {
		// in case if we want to use the nim as indetifier, just implement this method on apitokenguard
		$user = $this->user_active->where('nim',$identifier)->first();
		if($user){
			return $user->nim;
		} 
		
		return null;
	}

	public function retrieveByToken($field, $value)
    {
		// this function is for validate the user token and function is called from ApiTokenGuard func user()
		$token = $this->user_active->with('users')
		->where($field[0], $value['api_token'])
		->where($field[1], $value['nim'])->first();

		return $token ? $token  : null;
	}

	public function updateRememberToken(Auth $user, $token) 
    {
		// bcs we implementes UserProvider, we need to declare this method, we can empty it if we don't want to use it
	}

	public function retrieveByCredentials(array $credentials)
	{ 
		// This function is for validation the credentials, used by apitokenguard
		//  we can use this function to validate the user login
		
		$user = $this->user;
		// find the user data at user table
		if(!is_null($credentials['nim']) && !is_null($credentials['username'])){
			$user = $user->where('nim', $credentials['nim'])
			->where('username', $credentials['username'])
			->first();
			return $user;
		}

		return false;
	}

	public function validateCredentials(Auth $user, array $credentials): bool
	{
		// Cek the user password
		$plain = $credentials['password'];

		return app('hash')->check($plain, $user->getAuthPassword());
	}
}



?>