<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;
     
    protected $table = "tariffs";

    protected $fillable = ['status_id','userid','delet_flag','title'];

}
