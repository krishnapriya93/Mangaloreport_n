<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupmastersub extends Model
{
    use HasFactory;

    protected $table = "groupmastersubs";

    protected $fillable = ['groupmasterid','languageid','name'];
}
