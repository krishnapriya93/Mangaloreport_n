<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galleryattachments extends Model
{
    use HasFactory;
    protected $fillable=[
        'gallery_id',
        'status_id',
        'user_id',
    ];
    public function galleryattachments_langs(){
        return $this->hasMany(GalleryattachmentsLang::class,'galleryattachments_id','id');
    }
}
