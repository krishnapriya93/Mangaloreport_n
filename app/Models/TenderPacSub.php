<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderPacSub extends Model
{
    use HasFactory;


    protected $table = "tender_pac_subs";

    protected $fillable = ['tenderpacid','languageid','title'];
}
