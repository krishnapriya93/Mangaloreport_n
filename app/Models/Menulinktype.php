<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menulinktype extends Model
{
    use HasFactory;
    protected $table = 'menulinktypes';
    protected $fillable = ['name','delet_flag','status_id','userid'];

    public function menu_link_type()
    {
        return $this->hasMany(Mainmenu::class, 'menulinktype_id', 'id');
    }
}
