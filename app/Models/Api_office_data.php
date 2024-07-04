<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api_office_data extends Model
{
    use HasFactory;
    protected $table = "api_office_data";

    protected $fillable = [
        'office_code', 'office_name', 'office_id', 'parent_office_id', 'parent_office_code', 'sbu_id', 'sbu_name', 'office_group_id', 'office_group_name'
    ]; 


    public function childs() {
        return $this->hasMany('App\Models\Api_office_data','parent_office_code','office_code') ;
    }

    public function dash_consumer_childs() {
        return $this->hasMany('App\Models\Api_office_data','parent_office_code','office_code') ;
    }
}
