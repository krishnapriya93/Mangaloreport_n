<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmenuLang extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'submenu_id',
        'lang_id',
    ];
}
