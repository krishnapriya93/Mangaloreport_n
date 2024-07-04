<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerationType extends Model
{
    use HasFactory;
    protected $fillable=[
        'status',
        'order_num'
    ];
    public function generationtype_sub()
    {
        return $this->hasMany(GenerationTypesub::class, 'generationType_main_id', 'id');
    }
}
