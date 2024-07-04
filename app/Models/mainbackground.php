<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mainbackground extends Model
{
    use HasFactory;

    protected $table = "mainbackgrounds";

    protected $fillable = ['poster','status_id','users_id'];
}
