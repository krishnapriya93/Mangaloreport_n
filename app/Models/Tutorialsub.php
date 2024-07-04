<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutorialsub extends Model
{
    use HasFactory;

    protected $table = "tutorialsubs";

    protected $fillable = ['tutorialid','languageid','title','description'];

    public function lang_sel()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }
}
