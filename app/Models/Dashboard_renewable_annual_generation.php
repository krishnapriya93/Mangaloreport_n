<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard_renewable_annual_generation extends Model
{
    use HasFactory;

    protected $table = "dashboard_renewable_annual_generations";

    protected $fillable = ['sbutype_id','dashboard_cat_id','users_id','year','sh_ksebtotal','sh_cpptotal','sh_ipptotal','w_ksebkanjikode','w_ipptotal','total_s_kseb','total_s_ci','total_solar','grand_total'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'dashboard_cat_id', 'id');
    }
    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }
}
