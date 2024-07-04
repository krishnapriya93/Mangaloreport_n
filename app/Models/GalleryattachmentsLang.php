<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryattachmentsLang extends Model
{
    use HasFactory;
    protected $fillable=[
        'galleryattachments_id',
        'alt',
        'file',
        'size',
        'title',
        'description',
        'lang_id',
    ];
}
