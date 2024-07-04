<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waterlevel extends Model
{
    use HasFactory;

    protected $table = "waterlevels";

    protected $fillable = ['users_id','dam','master_id','date_on','todaywaterlevel','Todaylivestorage','perwrtliveStorage','previousyearwtrlevel','previousyearlivestorage','Inflow','rainfall','remark','status_id'];

}
