<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pollanswersub extends Model
{
    use HasFactory;

    protected $table = "pollanswersubs";

    protected $fillable = ['languageid','answer','answer_mainid'];
}
