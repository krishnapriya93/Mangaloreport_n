<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard_comparison_puc_sr_finance extends Model
{
    use HasFactory;
    protected $table = "dashboard_comparison_puc_sr_finance";

    protected $fillable = ['sbutype_id','dashboard_cat_id','users_id','year','avg_cost_of_supply_rs','avg_revenue_realizedin_rs','gap','status_id'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'dashboard_cat_id', 'id');
    }
    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }
}
