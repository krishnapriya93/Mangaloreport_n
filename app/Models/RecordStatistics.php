<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordStatistics extends Model
{
    use HasFactory;
    
    protected $table = "record_statistics";

    protected $fillable = ['status_id','user_id','date_on','item','generationmu','gendate','importmu','importdate','timefrom',
    'timeto','consumpmu','consumpdate','maxdemand','demanddate','status_id'];

}
