<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api_solar_abstract extends Model
{
    use HasFactory;

    protected $table = "api_solar_abstracts";

    protected $fillable = [
        'source', 'txn_month', 'section_code', 'acc_cat_name', 'group_name', 'model_name', 'cons_count', 'plant_cap_kw', 'generation_kwh'
    ]; 
}
