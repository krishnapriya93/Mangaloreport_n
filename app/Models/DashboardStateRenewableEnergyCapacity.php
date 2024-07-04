<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardStateRenewableEnergyCapacity extends Model
{
    use HasFactory;

    protected $table = "dashboard_state_renewable_energy_capacities";

    protected $fillable = ['sbutype_id','dashboard_cat_id','users_id','title','value','status_id','created_at','updated_at'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'dashboard_cat_id', 'id');
    }
    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }
}
