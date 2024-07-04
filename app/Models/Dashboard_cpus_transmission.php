<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard_cpus_transmission extends Model
{
    use HasFactory;

    protected $table = "dashboard_cpus_transmissions";

    protected $fillable = ['sbutype_id','dashboard_cat_id','users_id','year','cpus_in_ic','cpus_ex_ic'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'dashboard_cat_id', 'id');
    }
    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }
}
