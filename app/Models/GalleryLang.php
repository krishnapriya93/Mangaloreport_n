<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryLang extends Model
{
    use HasFactory;
    protected $fillable=[
        'gallery_id',
        'title',
        'description',
        'poster',
        'alt',
        'lang_id',
    ];
}
