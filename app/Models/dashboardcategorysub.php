<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dashboardcategorysub extends Model
{
    use HasFactory;


    protected $table = "dashboardcategorysubs";

    protected $fillable = ['das_cat_id','languageid','title'];

    public function lang_sel()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }

}
