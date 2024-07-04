<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linksub extends Model
{
    use HasFactory;

    protected $table = "linksubs";

    protected $fillable = ['alternatetext','linkid','languageid','title'];

    public function link()
    {
        return $this->belongsTo(Link::class, 'linkid', 'id');
    }
    public function lang_sel()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }
}
