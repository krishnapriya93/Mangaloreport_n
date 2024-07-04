<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footermenusub extends Model
{
    use HasFactory;

    protected $table = "footermenusubs";

    protected $fillable = ['alternatetext','footermenuid','delet_flag','languageid','poster','status_id','title','userid','content'];

    public function Footermenu()
    {
        return $this->belongsTo(Footermenu::class, 'footermenuid', 'id');
    }
}
