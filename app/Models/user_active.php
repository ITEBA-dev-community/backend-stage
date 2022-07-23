<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_active extends Model
{
    use HasFactory;
    protected $table = 'user_active';
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'nim', 'nim');
    }

    public function scopeCheckToken($query, $token)
    {
        $token = explode(' ', $token);
        return $query->where('api_token', $token[1]);
    }

    public static function deleteToken($nim)
    {
        user_active::where('nim', $nim)->delete();
    }
}