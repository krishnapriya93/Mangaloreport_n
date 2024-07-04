<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryOtherType extends Model
{
    use HasFactory;
    public function gallery_other_type_langs(){
        return $this->hasMany(GalleryOtherTypeLang::class,'gallery_other_types_id','id');

    }
}
