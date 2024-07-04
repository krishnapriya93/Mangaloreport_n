<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    protected $table = "milestones";

    protected $fillable = ['status_id','user_id','link','icon_class','date','sbutype_id','year','content'];

    public function milestonesub()
    {
        return $this->hasMany(Milestonesub::class, 'milestoneid', 'id');
    }
}
