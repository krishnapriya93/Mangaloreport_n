<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mainmenu extends Model
{
    use HasFactory;

    protected $table = "mainmenus";

    protected $fillable = ['iconclass','menulinktype_id','file','status_id','users_id','delet_flag','menulinktype_data','orderno','sbu_type','viewer_id','articletype_id'];

    public function lang_sel()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
    public function menu_link_type()
    {
        return $this->belongsTo(Menulinktype::class, 'menulinktype_id', 'id');
    }
    public function sub_menu()
    {
        return $this->hasMany(Submenu::class, 'mainmenu_id', 'id');
    }
    public function mainmenu_sub()
    {
        return $this->hasMany(Mainmenusub::class, 'mainmenuid', 'id');
    }
    public function sbu_type_user()
    {
        return $this->hasMany(Sbutype::class, 'id', 'sbu_type');
    }
    public function article_type()
    {
        return $this->hasMany(Articletype::class, 'id', 'articletype_id');
    }
}
