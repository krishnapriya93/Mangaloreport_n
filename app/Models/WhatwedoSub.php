<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatwedoSub extends Model
{
    use HasFactory;

     protected $table = "whatwedotypes";

     protected $guarded = [];

  
    public function lang()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }
}
