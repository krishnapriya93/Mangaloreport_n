<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api_getconsumerbill_abstract extends Model
{
    use HasFactory;
    protected $table = "api_getconsumerbill_abstract";

    protected $fillable = [
        'source', 'txn_month', 'section_code', 'tariff_code', 'acc_cat_name', 'live_cons_cnt', 'bill_cons_cnt', 'consumption', 'demand'
    ]; 
}
