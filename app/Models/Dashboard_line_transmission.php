<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard_line_transmission extends Model
{
    use HasFactory;
    protected $table = "dashboard_line_transmissions";

    protected $fillable = ['sbutype_id','dashboard_cat_id','users_id','year','d_400kV_cir_km','d_220kV_cir_km','d_110kV_cir_km','d_66kV_cir_km','d_33kV_cir_km'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'das_cat_id', 'dashboard_cat_id');
    }
    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }
}
