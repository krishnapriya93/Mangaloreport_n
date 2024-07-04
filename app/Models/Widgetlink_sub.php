<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widgetlink_sub extends Model
{
    use HasFactory;

    protected $table = "widgetlink_subs";

    protected $fillable = ['mainmenulink_id','menulink_data','widgetlink_id','status_id','userid','delet_flag','alternatetext','title','subtitle','language_id','poster'];

    public function widgetlink()
    {
        return $this->belongsTo(Widgetlink::class, 'widgetlink_id', 'id');
    }
}
