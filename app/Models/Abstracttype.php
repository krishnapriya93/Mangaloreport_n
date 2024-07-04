<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abstracttype extends Model
{
    use HasFactory;

    protected $table = "abstracttype";

    protected $fillable=[
        'name',
        'status',        
    ];

}
