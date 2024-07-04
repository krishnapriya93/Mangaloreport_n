<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pollquestionsub extends Model
{
    use HasFactory;

    protected $table = "pollquestionsubs";

    protected $fillable = ['languageid','question','question_mainid'];
}
