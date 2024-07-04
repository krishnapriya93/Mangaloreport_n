<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbstractStatistics extends Model
{
    use HasFactory;

    protected $table = "abstract_statistics";

    protected $fillable = [
        'schedule', 'mw', 'seltype', 'timestart', 'timeend', 'freq', 'date_on', 'status_id', 'user_id','demandtype','absrttype'
    ]; 

    public function demandtypedata()
    {
        return $this->hasMany(Demandtype::class, 'id', 'demandtype');
    }
    public function abstracttype()
    {
        return $this->hasMany(Abstracttype::class, 'id', 'absrttype');
    }
    public function scheduletype()
    {
        return $this->hasMany(Scheduletype::class, 'id', 'schedule');
    }
}
