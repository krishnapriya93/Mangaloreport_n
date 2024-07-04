<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    use HasFactory;

    protected $table = "purposes";

    protected $fillable = ['status_id','userid','delet_flag','title'];
}
