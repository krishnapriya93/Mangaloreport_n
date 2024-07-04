<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;
    protected $table = "logos";

    protected $fillable = ['status_id','userid','delet_flag','logotypeid'];

    public function logo_sub()
    {
        return $this->hasMany(Logo_sub::class, 'logoid', 'id');
    }

    public function logo_type()
    {
        return $this->belongsTo(Logotype::class, 'logotypeid', 'id');
    }
}
