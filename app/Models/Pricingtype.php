<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricingtype extends Model
{
    use HasFactory;

    protected $table = "pricingtypes";

    protected $fillable = ['status_id','userid','delet_flag','title'];
}
