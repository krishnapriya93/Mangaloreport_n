<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widgetlink extends Model
{
    use HasFactory;

    protected $table = "widgetlinks";

    protected $fillable = ['iconclass','menulinktypeid','widgetpositionid','status_id','userid','delet_flag'];

     public function widgetlinksub()
    {
        return $this->hasMany(Widgetlink_sub::class, 'widgetlink_id', 'id');
    }

}
