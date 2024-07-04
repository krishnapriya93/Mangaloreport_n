<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard_networkgrowth_distribution extends Model
{
    use HasFactory;
    protected $table = "dashboard_network_growth_distribution";

    protected $fillable = ['sbutype_id','dashboard_cat_id','users_id','year','d_22kV_cir_km','d_11kV_cir_km','LT_cir_km','DTRNos','status_id'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'dashboard_cat_id', 'id');
    }
    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }
}
