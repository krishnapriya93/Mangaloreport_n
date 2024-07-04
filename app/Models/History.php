<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = "histories";

    protected $fillable = ['status_id','user_id','link','icon_class','date','year','sbutype_id'];

    public function historysub()
    {
        return $this->hasMany(Historysub::class, 'historyid', 'id');
    }
}
