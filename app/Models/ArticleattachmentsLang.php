<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleattachmentsLang extends Model
{
    use HasFactory;
    protected $fillable=[
        'articleattachments_id',
        'alt',
        'file',
        'size',
        'title',
        'description',
        'lang_id',
    ];

}
