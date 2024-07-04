<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard_annual_generation extends Model
{
    use HasFactory;

    protected $table = "dashboard_annual_generations";

    protected $fillable = ['sbutype_id','dashboard_cat_id','users_id','Year','annual_generation _mu','status_id'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'dashboard_cat_id', 'id');
    }
    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }
}
