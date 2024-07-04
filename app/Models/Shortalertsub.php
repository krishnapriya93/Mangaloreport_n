<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shortalertsub extends Model
{
    use HasFactory;

    protected $table = "shortalertsubs";

    protected $fillable = ['shortalertid','languageid','content','status_id','title'];

    public function shortalert()
    {
        return $this->belongsTo(Shortalert::class, 'shortalertid', 'id');
    }
}
