<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
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


}
