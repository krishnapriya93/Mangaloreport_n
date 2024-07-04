<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    use HasFactory;
    protected $fillable=[
        'order_num',
        'status',
        'widgetposition_id',
        'homePage_status',
        'user_id'
    ];
    public function generation_sub(){
        return $this->hasMany(Generationsub::class,'generation_main_id','id');
    }
}
