<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard_renewable_installed_capacity extends Model
{
    use HasFactory;

    protected $table = "dashboard_renewable_installed_capacities";

    protected $fillable = ['sbutype_id','dashboard_cat_id','users_id','item','value'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'dashboard_cat_id', 'id');
    }
    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }
}
