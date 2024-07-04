<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Functionalunit extends Model
{
    use HasFactory;

    protected $table = "functionalunits";

    protected $fillable = ['status_id','userid','delet_flag'];

    public function func_sub()
    {
        return $this->hasMany(Functionalunitsub::class, 'functionalunitid', 'id');
    }
}
