<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keywordtag extends Model
{
    use HasFactory;

    protected $table = "keywordtags";

    protected $fillable = ['status_id','userid','delet_flag'];

    public function keytag_sub()
    {
        return $this->hasMany(Keywordtagsub::class, 'keywordtagid', 'id');
    }
}
