<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Midwidgetsub extends Model
{
    use HasFactory;

    protected $table = "midwidgetsubs";

    protected $fillable = ['content','widgetid','languageid','title','userid','subtitle'];

}
