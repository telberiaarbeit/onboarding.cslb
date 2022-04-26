<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // use HasFactory;
    // protected $table = 'users';
    // protected $guarded = [];
    public $timestamps = false;
    protected $fillable = [
        'is_admin', 'name', 'full_name', 'abbreviations','position','manager','group_id','email','password'
    ];
}
