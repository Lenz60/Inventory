<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class Furniture extends Model
{
    use HasFactory;
    protected $table = 'furniture';
    protected $primaryKey = 'uuid';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $fillable = [
        'uuid',
        'image',
        'code',
        'description',
        'category',
        'wood_type',
        'width',
        'color',
        'length',
        'height',
        'price',
        'stock'
    ];

    //? Don't need this because the UUID need to be check when saving image for the import from excel
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $faker = Faker::create();
    //         $model->uuid = $faker->uuid;
    //     });
    // }
}
