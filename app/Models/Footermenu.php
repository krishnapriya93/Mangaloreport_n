<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footermenu extends Model
{
    use HasFactory;

    protected $table = "footermenus";

    protected $fillable = ['status_id','userid','delet_flag','iconclass'];

    public function footermenu_sub()
    {
        return $this->hasMany(Footermenusub::class, 'footermenuid', 'id');
    }

}
