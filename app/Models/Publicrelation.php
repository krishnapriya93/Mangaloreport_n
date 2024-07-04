<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicrelation extends Model
{
    use HasFactory;
    protected $fillable=[
        'color_class',
        'homepage_status',
        'newscategory_id',
        'icon_class',
        'link',
        'submitdate',
        'lastdate',
        'status_id',
        'order_num',
        'user_id',
        'approve_status',
        'scervices_id',
        'schemes_id',
        'media_categories_id'
    ];

    public function publicrelation_langs(){
        return $this->hasMany(PublicrelationLang::class,'publicrelations_id','id');
    }
    public function publicrelationsattachments(){
        return $this->hasMany(PublicrelationAttachment::class,'publicrelations_id','id');
    }
    public function media_categories(){
        return $this->hasMany(MediaCategory::class,'id','media_categories_id');
    }
    public function media_categoriestake6(){
        return $this->belongsTo(MediaCategory::class,'media_categories_id','id')->limit(6);
    }
}
