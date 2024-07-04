<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subsubmenu extends Model
{
    use HasFactory;

    protected $table = "subsubmenus";

    protected $fillable = ['iconclass','menulinktype_id','menulinktype_data','status_id','users_id','delet_flag','mainmenu_id','submenu_id','sbu_type','viewer_id','articletype_id','orderno'];


    public function lang_sel()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }
    public function menu_link_types()
    {
        return $this->belongsTo(Menulinktype::class, 'menulinktype_id', 'id');
    }
    public function submenusub()
    {
        return $this->hasMany(Submenusub::class, 'submenuid', 'id');
    }
    public function subsubmenusub()
    {
        return $this->hasMany(subsubmenusub::class, 'subsubmenu_id', 'id');
    }
    public function sbu_type_user()
    {
        return $this->hasMany(Sbutype::class, 'id', 'sbu_type');
    }
    public function mainmenu_selected()
    {
        return $this->hasMany(Mainmenu::class, 'id', 'mainmenu_id');
    }
    public function mainmenu_sub_selected()
    {
        return $this->hasMany(Mainmenusub::class, 'mainmenuid', 'mainmenu_id');
    }
    public function submenu_selected()
    {
        return $this->hasMany(Submenusub::class, 'submenuid', 'submenu_id');
    }
}
