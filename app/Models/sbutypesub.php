<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sbutypesub extends Model
{
    use HasFactory;


    protected $table = "sbutypesubs";

    protected $fillable = ['languageid','sbutypeid','title'];


    public function lang()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }
}
