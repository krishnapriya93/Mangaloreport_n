<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicrelation extends Model
{
    use HasFactory;

    protected $table = "publicrelations";

    protected $guarded = [];

    public function publicrelsub()
    {
        return $this->hasMany(publicrelationsub::class, 'publicrelationid', 'id');
    }

    public function publicrelationtype()
    {
        return $this->belongsTo(Publicrelationtype::class, 'publicreltypeid', 'id');
    }
}
