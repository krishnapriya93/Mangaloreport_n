<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdlUser extends Model
{
    use HasFactory;

    protected $table = "mdl_user";

    protected $fillable = ['username','firstname','lastname','birth_date','join_date','retirement_date','gender_id',
    'designation_id','office_id','office_code','confirmed'];
}
