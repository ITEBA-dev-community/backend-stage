<?php 


namespace App\Guard;

use Illuminate\Http\Request;
use Illuminate\Auth\GuardHelpers;
use App\Extension\TokenUserProvider;
use Illuminate\Contracts\Auth\Guard;

class ApiTokenGuard implements Guard
{
    use GuardHelpers;

	private $inputKey = '';
	private $field_key = '';
	private $request;

	public function __construct (TokenUserProvider $TokenUserProvider,Request $request, $configuration) 
    {
		$this->provider = $TokenUserProvider;
		$this->request = $request;
        
		// if the configuration is not empty, we will set the input key and field key
		// but if empty we will use the default api_token
		$this->inputKey = isset($configuration['input_key']) ? $configuration['input_key'] : 'api_token';
		$this->field_key = isset($configuration['storage_key']) ? $configuration['storage_key'] : 'api_token';
	}

	public function user(): ?object
    {
		if (!is_null($this->user)) {
			return $this->user;
		}

		$user = null;

		// cek token input from header or request or query param, **for now we will use header to pass the token
		$token = $this->getTokenForRequest();

		if (!empty($token)) {
            // check the token in user_active table is valid or not
			$user = $this->provider->retrieveByToken($this->field_key, $token);
		}
	
		return $this->user = $user;
	}

	public function getTokenForRequest(): ?string
    {
        // find token in query params (if we sometimes we want to use query param to send token
		$token = $this->request->query($this->inputKey);

        // or if we want to  use body request for the token, we can use this
        if(empty($token)){
            $token = $this->request->input($this->inputKey);
        }

        // bcs for now we always use header, so we can skip first step and do if condition
        // find the header with Authorization key and Bearer token
		if(empty($token)) {
			$token = $this->request->bearerToken();
		}
		
		return $token;
	}

	public function validate(array $credentials = []): bool
    {

		// if (empty($credentials[$this->inputKey])) {
		// 	return false;
		// }

        // validate user datas from user table
		$data = [
            'nim' => $credentials['nim'],
            'username' => $credentials['username'],
            'password' => $credentials['password'],
        ];

		if ($this->provider->retrieveByCredentials($data)) {

			$user = $this->provider->retrieveByCredentials($data);

			return $this->provider->validateCredentials($user, $data);
		}

		return false;
	}
}





?>