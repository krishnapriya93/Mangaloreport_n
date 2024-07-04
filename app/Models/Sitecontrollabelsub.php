<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sitecontrollabelsub extends Model
{
    use HasFactory;

    protected $table = "sitecontrollabelsubs";

    protected $fillable = ['sitelabelid','languageid','title','alternatetext'];

    public function lang_sel()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }
}
