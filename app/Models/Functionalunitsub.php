<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Functionalunitsub extends Model
{
    use HasFactory;

    protected $table = "functionalunitsubs";

    protected $fillable = ['functionalunitid','languageid','subtitle','status_id','title'];

    public function func()
    {
        return $this->belongsTo(Functionalunit::class, 'functionalunitid', 'id');
    }
}
