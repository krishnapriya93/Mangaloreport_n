<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardCpuExchargeFinance extends Model
{
    use HasFactory;
    protected $table = "dashboard_cpu_excharge_finance";

    protected $fillable = ['sbutype_id','dashboard_cat_id','users_id','year','generation_ex_charges','transmission_ex_charges','distribution_ex_charges','status_id'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'dashboard_cat_id', 'id');
    }
    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }
}
