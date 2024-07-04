<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sectioncontact extends Model
{
    use HasFactory;


    protected $table = "sectioncontacts";

    protected $fillable = ['status_id','users_id','languageid','section_code','section_name','office_CUG','phone_number_sec_office','emailID_sec_office','Sub_division','emailID_sub_division','division','phone_number_division','emailID_division','circle','phone_number_circle','emailID_circle','region'];


}
