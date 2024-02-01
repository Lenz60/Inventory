<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Furniture extends Model
{
    use HasFactory;
    protected $table = 'furniture';
    protected $primaryKey = 'uuid';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'code',
        'description',
        'category',
        'wood_type',
        'width',
        'depth',
        'height',
        'price',
    ];

    // $table->string('uuid')->primary();
    //         $table->string('image');
    //         $table->string('code');
    //         $table->string('description');
    //         $table->enum('category',array('Indoor','Outdoor','Handicraft','Root'));
    //         $table->enum('wood_type',array('Teak wood','Tiger wood','Mahogany wood','Root'));
    //         $table->string('width');
    //         $table->string('depth');
    //         $table->string('height');
    //         $table->float('price');
    //         $table->timestamps();
}
