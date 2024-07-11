<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Whatwedo extends Model
{
    use HasFactory;

      protected $table = "downloads";

      protected $guarded = [];


    public function whatwedo_sub()
    {
        return $this->hasMany(WhatwedoSub::class, 'downloadid', 'id');
    }

    public function whatwedo_items()
    {
        return $this->hasMany(Whatwedoitems::class,'download_id','id');
    }
}
