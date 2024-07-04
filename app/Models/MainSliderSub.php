<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainSliderSub extends Model
{
    use HasFactory;

    protected $fillable = ['maninslider_id','languageid','title','description','content','pdf'];

    public function lang_sel()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
