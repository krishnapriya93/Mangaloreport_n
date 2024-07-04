<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // protected $table = "articles";
    protected $fillable=['articletype_id',
'users_id',
'delet_flag',
'status_id',
'widgetposition_id',
'homePage_status','sbutype_id','sbu_id','usertype','viewpermission','sbu_type','viewer_id','main_website_status','urlkeyid'];

    
        public function articleval_sub()
        {
            return $this->hasMany(Articlesub::class, 'articleid', 'id');
        }

        public function sbutypeval()
        {
            return $this->belongsTo(Sbutype::class, 'sbutype_id', 'id');
        }

}
