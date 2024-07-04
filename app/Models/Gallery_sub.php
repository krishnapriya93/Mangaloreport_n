<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery_sub extends Model
{
    use HasFactory;

    protected $table = "gallery_subs";

    protected $fillable = ['galleryid','languageid','title'];

    public function counter()
    {
        return $this->belongsTo(Galleries::class, 'galleryid', 'id');
    }
    public function lang()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }
}
