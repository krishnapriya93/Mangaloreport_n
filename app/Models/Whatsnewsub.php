<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Whatsnewsub extends Model
{
    use HasFactory;

    protected $table = "whatsnewsubs";

    protected $fillable = ['whatsnewid','languageid','status_id','subtitle','title','content'];

    public function whatsnew()
    {
        return $this->belongsTo(Whatsnew::class, 'whatsnewid', 'id');
    }
}
