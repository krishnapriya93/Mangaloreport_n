<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pressrelase extends Model
{
    use HasFactory;

    protected $table = "pressrelases";

    protected $fillable = ['status_id','users_id','delet_flag','userid','date','url'];

    public function pressrel_sub()
    {
        return $this->hasMany(Pressrelasesub::class, 'pressrelaseid', 'id');
    }
}
