<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderCategorySub extends Model
{
    use HasFactory;

    protected $table = "tender_category_subs";

    protected $fillable = ['tendercategoryid','languageid','title'];
}
