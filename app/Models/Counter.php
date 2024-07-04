<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;


    protected $table = "counters";

    protected $fillable = ['status_id','userid','delet_flag','iconclass','countervalue'];

    public function counter_sub()
    {
        return $this->hasMany(Countersub::class, 'counterid', 'id');
    }
}
