<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Midwidget extends Model
{
    use HasFactory;

    protected $table = "midwidgets";

    protected $fillable = ['status_id','userid','delet_flag','value'];

    public function midwiget_sub()
    {
        return $this->hasMany(Midwidgetsub::class, 'widgetid', 'id');
    }
}
