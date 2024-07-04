<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardTdLossFinance extends Model
{
    use HasFactory;

    protected $table = "dashboard_td_loss_finances";

    protected $fillable = ['sbutype_id','dashboard_cat_id','users_id','year','energy_sold','energy_input',
    'td_loss','yearly_redcution','cumulative_reduction',
    'energy_saved','avg_revenue_realized','cost_savings_cr','cummulative_saving','status_id'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'dashboard_cat_id', 'id');
    }
    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }
}
