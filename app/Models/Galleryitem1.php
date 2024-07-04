<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galleryitem1 extends Model
{
    use HasFactory;

    protected $table = "galleryitem1s";

    protected $fillable = ['gallery_id', 'image', 'alternate_text', 'status_id', 'user_id'];

    public function galleries()
    {
        return $this->belongsTo(Gallery::class,'gallery_id','id');
    }
}
