<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dashboardcategory extends Model
{
    use HasFactory;

    protected $table = "dashboardcategories";

    protected $fillable = ['status_id','users_id','sbutype_id','tablename','upload_temp','org_name'];

    public function dashboardcategorie_sub()
    {
        return $this->hasMany(dashboardcategorysub::class, 'das_cat_id', 'id');
    }
    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'sbutype_id');
    }

    //pp
    public function sbutype()
    {
        return $this->belongsTo(Sbutype::class, 'sbutype_id', 'id');
    }
}
