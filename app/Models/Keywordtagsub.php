<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keywordtagsub extends Model
{
    use HasFactory;

    protected $table = "keywordtagsubs";

    protected $fillable = ['title','keywordtagid','languageid','status_id'];

    public function keytag()
    {
        return $this->belongsTo(Keywordtag::class, 'keywordtagid', 'id');
    }
}
