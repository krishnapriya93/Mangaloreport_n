<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard_inst_cap_GKPS extends Model
{
    use HasFactory;

    protected $table = "dashboard_inst_cap__g_k_p_s";

    protected $fillable = ['sbutype_id','dashboard_cat_id','users_id','Year','hydro','wind','solar','thermal','diesel','total','installed_capacity_in_mw'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'dashboard_cat_id', 'id');
    }
    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }
}
