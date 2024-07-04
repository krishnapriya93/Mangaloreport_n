<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaCategory extends Model
{
    use HasFactory;
    protected $fillable=[
        'homepage_status',
        'color_class',
        'icon_class',
        'status_id',
        'order_num',
        'user_id',
        'link',
        'media_categories_id'
    ];
    public function media_category_langs(){
        return $this->hasMany(MediaCategoryLang::class,'media_categories_id','id');
    }
    public function publicrelations(){
        return $this->hasMany(Publicrelation::class,'media_categories_id','id');

    }
}
