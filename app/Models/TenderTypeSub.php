<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderTypeSub extends Model
{
    use HasFactory;
    protected $table = "tender_type_subs";

    protected $fillable = ['tendertypeid','languageid','title'];
}
