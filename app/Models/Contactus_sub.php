<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactus_sub extends Model
{
    use HasFactory;

    protected $table = "contactus_subs";

    protected $fillable = ['address','contactusid','delet_flag','languageid','status_id','title','created_at','updated_at'];

 
}
