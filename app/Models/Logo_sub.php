<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo_sub extends Model
{
    use HasFactory;
    protected $table = "logo_subs";

    protected $fillable = ['alternatetext','logoid','delet_flag','languageid','poster','status_id','title','userid'];

    public function logo()
    {
        return $this->belongsTo(Logo::class, 'logoid', 'id');
    }
}
