<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historysub extends Model
{
    use HasFactory;

    protected $table = "historysubs";

    protected $fillable = ['languageid','historyid','title','poster','description','content'];


    public function history()
    {
        return $this->hasMany(History::class, 'historyid', 'id');
    }
}
