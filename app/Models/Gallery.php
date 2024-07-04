<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $fillable=[
        'date',
        'gallarycategory_id',
        'gallerytype_id',
        'order_num',
        'status_id',
        'user_id',
        'homepage_status',
        'scervices_id',
        'schemes_id',
    ];

    public function delete()
    {

        $this->gallery_langs()->delete();
        $this->gallerycategories()->delete();
        $this->gallerytypes()->delete();
        $this->galleryattachments()->delete();


        return parent::delete();
    }

    // public function schemes(){
    //     return $this->hasMany(Scheme::class,'id','schemes_id');
    // }
    // public function services(){
    //     return $this->hasMany(Service::class,'id','scervices_id');
    // }
    public function gallery_langs(){
        return $this->hasMany(GalleryLang::class,'gallery_id','id');
    }
    public function gallerycategories(){
        return $this->hasMany(GalleryCategory::class,'id','gallarycategory_id');
    }
    public function gallerytypes(){
        return $this->hasMany(Articletype::class,'id','gallerytype_id');
    }
    public function galleryattachments(){
        return $this->hasMany(Galleryattachments::class,'gallery_id','id');
    }
    public function gallery_other_types(){
        return $this->hasMany(GalleryOtherType::class,'id','scervices_id');
    }
}
