<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mainmenusub extends Model
{
    use HasFactory;

    protected $table = "mainmenusubs";

    protected $fillable = ['alternatetext','mainmenuid','delet_flag','languageid','status_id','title','userid'];

    public function Footermenu()
    {
        return $this->belongsTo(Footermenu::class, 'footermenuid', 'id');
    }
    public function Mainmenu()
    {
        return $this->belongsTo(Mainmenu::class, 'mainmenuid', 'id');
    }
}
