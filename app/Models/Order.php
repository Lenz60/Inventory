<?php

namespace App\Models;

use App\Models\OrdersPayment;
use App\Models\OrdersProduction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'total_price',
        'track_code',
    ];

    public function ordersPayment(){
        $this->hasOne(OrdersPayment::class);
    }

    public function ordersProduction(){
        $this->hasOne(OrdersProduction::class);
    }
    public function ordersAddress(){
        $this->hasOne(OrdersAddress::class);
    }
}
