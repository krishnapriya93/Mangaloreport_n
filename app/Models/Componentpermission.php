<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Componentpermission extends Model
{
    use HasFactory;
    protected $table = 'componentpermissions';
    protected $fillable = ['componentid','delet_flag','status_id','role_id','url'];

    public function component()
    {
        return $this->belongsTo(Component::class, 'componentid', 'id');
    }

     public function usertype()
    {
        return $this->belongsTo(usertype::class, 'role_id', 'id');
    }
}
