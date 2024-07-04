<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Downloadsub extends Model
{
    use HasFactory;

     protected $table = "downloadsubs";

    protected $fillable = ['description','downloadid','alternatetext','languageid','title'];

    public function download()
    {
        return $this->belongsTo(Download::class, 'downloadid', 'id');
    }
    public function lang()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }
}
