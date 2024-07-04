<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicrelationLang extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'file',
        'poster',
        'subtitle',
        'description',
        'publicrelations_id',
        'lang_id',
    ];
}
