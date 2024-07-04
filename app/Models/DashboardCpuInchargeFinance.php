<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardCpuInchargeFinance extends Model
{
    use HasFactory;
    protected $table = "dashboard_cpu_incharge_finance";

    protected $fillable = ['sbutype_id','dashboard_cat_id','users_id','year','generation_in_charges','transmission_in_charges','distribution_in_charges','status_id'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'dashboard_cat_id', 'id');
    }
    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }
}
