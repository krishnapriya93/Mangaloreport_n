<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogoLang extends Model
{
    use HasFactory;
    protected $fillable=[
        'poster',
        'alt',
        'title',
        'description',
        'logos_id',
        'lang_id',
    ];
}
