<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class footer extends Model
{
    use HasFactory;
    protected $fillable=[
        'order_num',
        'status_id',
        'user_id',
        'footer_categories_id',
        'poster',
        'link',
        'icon_class',
        'menulinktype_id'
    ];
    public function footer_langs(){
        return $this->hasMany(FooterLang::class,'footers_id','id');
    }
}
