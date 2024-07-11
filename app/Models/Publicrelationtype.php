<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicrelationtype extends Model
{
    use HasFactory;

    protected $table = 'publicrelationtypes';
    protected $fillable = ['name','delet_flag','status_id','userid'];
}
