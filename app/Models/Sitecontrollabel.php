<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sitecontrollabel extends Model
{
    use HasFactory;

    protected $table = "sitecontrollabels";

    protected $fillable = ['status_id','users_id','keyid'];

    public function sitelcontrollabel_sub()
    {
        return $this->hasMany(Sitecontrollabelsub::class, 'sitelabelid', 'id');
    }

}
