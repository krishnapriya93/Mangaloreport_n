<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usertype extends Model
{
    use HasFactory;
    protected $table = 'userstype';
    protected $fillable = ['usertype','delet_flag','status_id'];

    public function componentpermission_usertype()
    {
        return $this->hasMany(Componentpermission::class, 'userid', 'id');
    }
}
