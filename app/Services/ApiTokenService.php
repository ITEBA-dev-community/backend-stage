<?php 

namespace App\Services;

use Carbon\Carbon;
use App\Models\user_active;
use App\Guard\ApiTokenGuard;

class ApiTokenService
{    
    private $first_key = 'mvn12903IASJnsadjf72Nldsadl';
    private $second_key = 'Kjaklsdf89we12erQW9UDsadjwjfsdad9wersdf/qwefw2qwe';
    private $iv = '0o9i8u7y6tlkJHGF';
    private $cipher = "aes-256-cbc";  

    public function getToken(string $nim,string $username): string
    {
        $data = base64_encode(Carbon::now().$nim.$username);
        $token = $this->SafeToken($data);
        return $token;
    }

    public function SafeToken(string $data): string
    {
        $first_key = base64_decode($this->first_key);
        $second_key = base64_decode($this->second_key);   
        
        $first_encrypted = openssl_encrypt($data, $this->cipher, $first_key, OPENSSL_RAW_DATA ,$this->iv);   
        
            
        $first_encrypted = openssl_encrypt($data,$this->cipher,$first_key, OPENSSL_RAW_DATA ,$this->iv);   
        $second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
                
        $output = base64_encode($this->iv.$second_encrypted.$first_encrypted);   
        return $output;  
     
    }

         
}



?>