<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleLang extends Model
{
    use HasFactory;
    protected $fillable=[
            'title',
            'description',
            'poster',
            'alt',
            'article_id',
            'lang_id',
    ];
}
