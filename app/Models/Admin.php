<?php

namespace App\Models;

// use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $guard = "admin";

    protected $table = 'admin';
    protected $primaryKey = 'uuid';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'password' => 'hashed',
    ];

protected $fillable = [
        'uuid',
        'username',
        'password',
        'name',
        'role',
    ];

    protected $hidden = [
        'password',
    ];


}
