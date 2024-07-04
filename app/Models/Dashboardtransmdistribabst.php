<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboardtransmdistribabst extends Model
{
    use HasFactory;

    protected $table = 'dashboardtransmdistabst';
    protected $fillable = ['sbutype_id','dashboard_cat_id','year','400kv','220kv','110kv','66kv','33kv','22kv','11kv','LT','users_id'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'das_cat_id', 'dashboard_cat_id');
    }

    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }
}
