<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sbutype extends Model
{
    use HasFactory;

    protected $table = "sbutypes";

    protected $fillable = ['status_id','userid','delet_flag','title','iconclass','iconimage','url','viewer_id','orderno','dashboard_view'];

    public function sbutypeval_sub()
    {
        return $this->hasMany(Article::class, 'sbutype_id', 'id');
    }

    public function sbutypesub()
    {
        return $this->hasMany(sbutypesub::class, 'sbutypeid', 'id');
    }

    //pp
    public function dash_catogary()
    {
        return $this->hasMany(dashboardcategory::class, 'sbutype_id', 'id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'sbutype_id', 'id');
    }

    public function milestone()
    {
        return $this->hasMany(Milestone::class, 'sbutype_id', 'id');
    }

    public function download()
    {
        return $this->hasMany(Download::class, 'sbutype_id', 'id');
    }

    public function history()
    {
        return $this->hasMany(History::class, 'sbutype_id', 'id');
    }

    public function galleries()
    {
        return $this->hasMany(Galleries::class, 'sbutype_id', 'id');
    }
}
