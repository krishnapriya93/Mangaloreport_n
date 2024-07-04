<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardRevenueGapFinance extends Model
{
    use HasFactory;

    protected $table = "dashboard_revenue_gap_finances";

    protected $fillable = ['sbutype_id','dashboard_cat_id','users_id','year','income_tariff','income_non_tariff','income_total','expenditure','revenue_gap','status_id'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'dashboard_cat_id', 'id');
    }
    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }
}
