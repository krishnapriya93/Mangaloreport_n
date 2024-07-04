<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Downloaditems extends Model
{
    use HasFactory;
    protected $table = "downloaditem";

    protected $fillable = ['download_id', 'image', 'alternate_text', 'status_id', 'user_id'];

    public function download()
    {
        return $this->belongsTo(Download::class,'download_id','id');
    }
}
