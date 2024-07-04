<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = ['status_id','userid','delet_flag','size','downloadscnt','file'];

    public function order_sub()
    {
        return $this->hasMany(Ordersub::class, 'orderid', 'id');
    }
}
