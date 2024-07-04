<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainmenuLang extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        
        'alt',
        'mainmenu_id',
        'lang_id',
    ];
}
