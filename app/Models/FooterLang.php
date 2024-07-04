<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLang extends Model
{
    use HasFactory;
    protected $fillable=[
        'subtitle',
        'title',
        'footers_id',
        'lang_id',
    ];
}
