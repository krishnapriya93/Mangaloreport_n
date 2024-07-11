<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicrelation extends Model
{
    use HasFactory;
    protected $table = "publicrelations";

    protected $guarded = [];

    public function publicrel_sub()
    {
        return $this->hasMany(Publicrelation_sub::class, 'publicrelationid', 'id');
    }

    public function publicrel_items()
    {
        return $this->hasMany(Publicrelationitem::class, 'publicrelationid', 'id');
    }
}
