<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

      protected $table = "downloads";

    protected $fillable = ['status_id','userid','delet_flag','downloadtypeid','documentno','date','sbutype_id','viewpermission','usertype','main_website_status','homePage_status','urlkeyid'];


    public function download_sub()
    {
        return $this->hasMany(Downloadsub::class, 'downloadid', 'id');
    }

    public function download_items()
    {
        return $this->hasMany(Downloaditems::class,'download_id','id');
    }
}
