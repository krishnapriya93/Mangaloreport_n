<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stationmaster extends Model
{
    use HasFactory;

    protected $table = "stationmasters";

    protected $fillable = ['status_id','user_id','groupid','total'];

    public function stationsub()
    {
        return $this->hasMany(Stationmastersub::class, 'stationmasterid', 'id');
    }
    public function group()
    {
        return $this->hasMany(Groupmaster::class, 'id', 'groupid');
    }
    public function groupsub()
    {
        return $this->hasMany(Groupmastersub::class, 'groupmasterid', 'groupid');
    }


}
