<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designationsub extends Model
{
    use HasFactory;

    protected $table = "designationsubs";

    protected $fillable = ['alternatetext','designationid','delet_flag','languageid','poster','status_id','title','userid'];

    public function desig()
    {
        return $this->belongsTo(Designation::class, 'designationid', 'id');
    }
}
