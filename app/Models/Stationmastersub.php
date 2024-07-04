<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stationmastersub extends Model
{
    use HasFactory;

    protected $table = "stationmastersubs";

    protected $fillable = ['languageid','name','stationmasterid'];

}
