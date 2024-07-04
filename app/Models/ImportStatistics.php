<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportStatistics extends Model
{
    use HasFactory;

    protected $table = "import_statistics";

    protected $fillable = ['user_id','date_on','interstate_feeder','days_import','monthly_cum','daily_avg','max_demand','frequency','status_id'];

}
