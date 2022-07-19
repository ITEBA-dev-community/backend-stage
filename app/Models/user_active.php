<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_active extends Model
{
    use HasFactory;
    protected $table = 'user_active';
    protected $fillable = ['nim','api_token'];
}
