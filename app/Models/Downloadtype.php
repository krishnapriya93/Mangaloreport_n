<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Downloadtype extends Model
{
    use HasFactory;

    protected $table = "downloadtypes";

    protected $fillable = ['status_id','userid','delet_flag','viewer_id','sbu_type','multi_sbu','sbu_maindashboard','urlkeyid'];

    public function downloadtype_sub()
    {
        return $this->hasMany(Downloadtypesub::class, 'downloadtypeid', 'id');
    }
    public function sbu_type_user()
    {
        return $this->hasMany(Sbutype::class, 'id', 'sbu_type');
    }
}
