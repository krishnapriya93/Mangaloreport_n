<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = "banners";

    protected $fillable = ['status_id','userid','delet_flag','sbutype_id','url'];

    public function banner_sub()
    {
        return $this->hasMany(Banner_sub::class, 'bannerid', 'id');
    }
}
