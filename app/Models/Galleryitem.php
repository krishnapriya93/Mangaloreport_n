<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Galleryitem extends Model
{
    protected $table = "galleryitems";
    
    protected $fillable = ['gallery_id', 'image', 'alternate_text', 'status_id', 'user_id'];

  
}
