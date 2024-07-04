<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainSlider extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','url','uploadtype','upload','upload'];

    public function mainslider_sub()
    {
        return $this->hasMany(MainSliderSub::class, 'maninslider_id', 'id');
    }
}
