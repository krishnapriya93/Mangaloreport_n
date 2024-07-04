<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api_daily_collection_abstract extends Model
{
    use HasFactory;

    protected $table = "api_daily_collection_abstracts";

    protected $fillable = [
        'source', 'txn_month', 'coll_ason_date', 'section_code', 'receipt_type', 'total_coll_cnt', 'total_coll_amt'
    ]; 
}
