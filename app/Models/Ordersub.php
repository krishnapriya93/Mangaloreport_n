<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordersub extends Model
{
    use HasFactory;

    protected $table = "ordersubs";

    protected $fillable = ['content','orderid','languageid','title','userid','subtitle'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderid', 'id');
    }
}
