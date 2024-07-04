<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districtsub extends Model
{
    use HasFactory;

    protected $table = "districtsubs";

    protected $fillable = ['title','districtid','languageid','status_id'];

    public function district()
    {
        return $this->belongsTo(District::class, 'districtid', 'id');
    }
}
