<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemStatistics extends Model
{
    use HasFactory;

    protected $table = "system_statistics";

    protected $fillable = ['groupid','stationid','group','station','user_id','daygen','monthlycum','dailyavg','maxidemandmw','maxidemandtime','shutdownplanned','shutdownforced','availabilityavble','availabilitymp','availabilityep','date_on','total'];

    public function groupsub()
    {
        return $this->hasMany(Groupmastersub::class, 'groupmasterid', 'groupid');
    }

    public function stationsub()
    {
        return $this->hasMany(Stationmastersub::class, 'stationmasterid', 'stationid');
    }
}
