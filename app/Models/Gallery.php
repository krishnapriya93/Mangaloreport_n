<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $table = "galleries";

    protected $guarded = [];

    public function gallery_sub()
    {
        return $this->hasMany(GallerySub::class, 'galleryid', 'id');
    }
    public function gallery_item()
    {
        return $this->hasMany(GallerySubItems::class, 'galleryid', 'id');
    }
}
