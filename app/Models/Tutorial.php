<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    use HasFactory;

    protected $table = "tutorials";

    protected $fillable = ['status_id','users_id','viewer_id','sbutype_id','multi_sbu'];

    public function tutorial_sub()
    {
        return $this->hasMany(Tutorialsub::class, 'tutorialid', 'id');
    }

}
