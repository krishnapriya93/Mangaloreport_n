<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaCategoryLang extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'media_categories_id',
        'lang_id',
    ];
}
