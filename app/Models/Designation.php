<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $table = "designations";

    protected $fillable = ['status_id','userid','delet_flag'];

    public function des_sub()
    {
        return $this->hasMany(Designationsub::class, 'designationid', 'id');
    }
}
