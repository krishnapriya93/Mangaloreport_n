<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicrelationitem extends Model
{
    use HasFactory;

    protected $table = "publicrelationitems";

    protected $fillable = ['publicrelationid', 'image', 'alternate_text', 'status_id', 'user_id'];

    public function publicrelation()
    {
        return $this->belongsTo(publicrelation::class, 'publicrelationid');
    }
}
