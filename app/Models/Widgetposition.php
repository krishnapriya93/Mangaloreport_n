<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widgetposition extends Model
{
    use HasFactory;

    protected $table = 'widgetpositions';
    protected $fillable = ['name','delet_flag','status_id','userid'];
}
