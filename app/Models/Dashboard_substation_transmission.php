<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard_substation_transmission extends Model
{
    use HasFactory;
    protected $table = "dashboard_substation_transmissions";

    protected $fillable = ['sbutype_id','dashboard_cat_id','users_id','type','total','gen_switchyard','mvacapacity','htfeeders','status_id'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'dashboard_cat_id', 'id');
    }
    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }
}
