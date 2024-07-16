<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicrelationtype extends Model
{
    use HasFactory;

    protected $table = 'publicrelationtypes';
    protected $guarded = [];
    public function ptypesub()
    {
        return $this->hasMany(PublicrelationtypSub::class, 'publicrelationtypeid', 'id');
    }
}
