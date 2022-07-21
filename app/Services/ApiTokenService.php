<?php 

namespace App\Services;

use Carbon\Carbon;
use App\Models\user_active;
use Illuminate\Support\Str;
use App\Guard\ApiTokenGuard;

class ApiTokenService
{    
    // Credentials for make the token
    private $first_key = 'mvndjf72Nldsadl';
    private $iv = '0o9i8u7y6tsddf2l';
    private $cipher = "aes-256-cbc";  

    public function getActiveToken(string $nim,string $username): string
    {
        // create the token
        $rand = Str::random(30);
        $data = base64_encode($rand.$nim.$username);
        $token = $this->SafeToken($data);

        $data = user_active::create([
            'nim' => $nim,
            'username' => $username,
            'api_token' => $token
        ])->id;
        
        // id Token + User Nim + The Active Token
        return $data.'|'.$nim.'|'.$token;
    }

    public function SafeToken(string $data): string
    {
        $key = base64_encode($this->first_key);
     
        $encrypted = openssl_encrypt($data, $this->cipher, $key, OPENSSL_RAW_DATA ,$this->iv);   
                
        $output = base64_encode($this->iv.$encrypted);   
        return $output;  
    }

         
}



?>