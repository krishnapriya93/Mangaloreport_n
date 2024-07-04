<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;
    protected $table = 'components';
    protected $fillable = ['name','delet_flag','status_id','userid'];

    public function componentpermission_usertype()
    {
        return $this->hasMany(Componentpermission::class, 'componentid', 'id');
    }
}
