<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupmaster extends Model
{
    use HasFactory;

    protected $table = "groupmasters";

    protected $fillable = ['status_id','user_id'];

    public function groupsub()
    {
        return $this->hasMany(Groupmastersub::class, 'groupmasterid', 'id');
    }

    public function stastics()
    {
        return $this->hasMany(SystemStatistics::class, 'groupid', 'id');
    }

}
