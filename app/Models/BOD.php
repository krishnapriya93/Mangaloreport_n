<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BOD extends Model
{
    use HasFactory;
    protected $fillable=[
        'officenumber',
        'mobilenumber',
        'email',
        'photo',
        'order_num',
        'desig_flag',
        'status',        
        'user_id'
    ];
    public function bodsub(){
        return $this->hasMany(BOD_sub::class, 'bod_main_id', 'id');
    }
}
