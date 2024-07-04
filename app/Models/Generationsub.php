<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generationsub extends Model
{
    use HasFactory;
    protected $fillables=[
        'name',
        'generation_main_id',
        'article',
        'poster',
        'tags_id',
        'languageid'
    ];
    protected $guarded = [];  
    public function generation_main(){
        return $this->hasMany(Generation::class,'id','generation_main_id');
    }
    public function lang()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }
}
