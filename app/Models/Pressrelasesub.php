<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pressrelasesub extends Model
{
    use HasFactory;

    protected $table = "pressrelasesubs";

    protected $fillable = ['pressrelaseid','languageid','title','file','description','alt_title'];

    public function pressrelase()
    {
        return $this->belongsTo(Pressrelase::class, 'pressrelaseid', 'id');
    }
}
