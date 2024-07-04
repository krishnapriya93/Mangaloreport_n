<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordertype extends Model
{
    use HasFactory;

    protected $table = "ordertypes";

    protected $fillable = ['status_id','userid','delet_flag','footermenuid'];

    public function ordertype_sub()
    {
        return $this->hasMany(Ordertypesub::class, 'ordertypeid', 'id');
    }
}
