<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicrelation extends Model
{
    use HasFactory;

    protected $table = "publicrelations";

    protected $guarded = [];


    public function publicrelationtype()
    {
        return $this->belongsTo(Publicrelationtype::class, 'publicreltypeid', 'id');
    }
    public function publicrelationitem()
    {
        return $this->hasMany(Publicrelationitem::class, 'publicrelationid');
    }

    public function publicrelsub()
    {
        return $this->hasMany(publicrelationsub::class, 'publicrelationid');
    }

    public function publicreldep()
    {
        return $this->hasMany(Department::class, 'tid', 'departmentid');
    }
}
