<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerLang extends Model
{
    use HasFactory;
    protected $fillable=[
            'poster',
            'alt',
            'title',
            'subtitle',
            'banners_id',
            'lang_id',
    ];
}
