<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countersub extends Model
{
    use HasFactory;

    protected $table = "countersubs";

    protected $fillable = ['counterid','languageid','title'];

    public function counter()
    {
        return $this->belongsTo(Counter::class, 'counterid', 'id');
    }
}
