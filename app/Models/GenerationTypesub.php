<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerationTypesub extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'description',
        'generationType_main_id',
        'languageid'
    ];
    public function generationtype_main()
    {
        return $this->hasMany(GenerationTypesub::class,  'id','generationType_main_id');
    }
}
