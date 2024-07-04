<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submenusub extends Model
{
    use HasFactory;

    protected $table = "submenusubs";

    protected $fillable = ['title','mainmenu_id','languageid','title','submenuid'];

    public function submenu()
    {
        return $this->belongsTo(Submenu::class, 'submenuid', 'id');
    }
}
