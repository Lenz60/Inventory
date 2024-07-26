<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersInfo extends Model
{
    use HasFactory;
    protected $table = 'orders_info';
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'order_id',
        'phone_number',
        'address',
        'country',
        'region',
        'zip',
    ];
}
