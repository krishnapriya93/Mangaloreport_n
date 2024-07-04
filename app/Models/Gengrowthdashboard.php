<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gengrowthdashboard extends Model
{
    use HasFactory;

    protected $table = 'gengrowthdashboards';
    protected $fillable = ['sbutype_id','dashboard_cat_id','year','ICMW_Hydro','ICMW_Wind','ICMW_Solar','ICMW_Thermal','ICMW_Diesel','ICMW_Total','GPAMU_Hydro','GPAMU_Wind','GPAMU_Solar','GPAMU_Thermal','GPAMU_Diesel','GPAMU_Total','CPUIncludInterest','CPUExludeInterest','users_id'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'das_cat_id', 'dashboard_cat_id');
    }

    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }

}
