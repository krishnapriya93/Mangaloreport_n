<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicrelation_sub extends Model
{
    use HasFactory;

    protected $table = "publicrelation_subs";

    protected $guarded = [];

  
    public function lang()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }
}
