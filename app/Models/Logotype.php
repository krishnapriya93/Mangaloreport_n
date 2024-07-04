<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logotype extends Model
{
    use HasFactory;
    protected $table = 'logotypes';
    protected $fillable = ['name','delet_flag','status_id','userid'];

    
    public function logo()
    {
        return $this->hasMany(Logo::class, 'logotypeid', 'id');
    }
}
