<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socialmedia extends Model
{
    use HasFactory;

    protected $table = "socialmedias";

    protected $fillable = ['iconclass','url','status_id','userid','delet_flag'];

    public function socialmedia_sub()
    {
        return $this->hasMany(Socialmedia_sub::class, 'socialmediaid', 'id');
    }
}
