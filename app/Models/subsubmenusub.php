<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subsubmenusub extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = "subsubmenusubs";

    protected $fillable = ['title','languageid','subsubmenu_id'];

    public function subsubmenusub()
    {
        return $this->belongsTo(subsubmenu::class, 'subsubmenu_id', 'id');
    }

    public function lang_sel()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }
    
   
}
