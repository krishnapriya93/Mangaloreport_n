<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shortalert extends Model
{
    use HasFactory;

    protected $table = "shortalerts";

    protected $fillable = ['status_id','userid','delet_flag','colorclass'];

    public function shortalert_sub()
    {
        return $this->hasMany(Shortalertsub::class, 'shortalertid', 'id');
    }
}
