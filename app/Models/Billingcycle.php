<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billingcycle extends Model
{
    use HasFactory;

     protected $table = "billingcycles";

    protected $fillable = ['status_id','userid','delet_flag','title'];
}
