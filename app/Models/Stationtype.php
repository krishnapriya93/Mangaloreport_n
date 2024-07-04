<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stationtype extends Model
{
    use HasFactory;

    protected $table = 'stationtypes';
    protected $fillable = ['name','delet_flag','status_id','userid'];

}
