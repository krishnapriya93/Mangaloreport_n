<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articlesub extends Model
{
    use HasFactory;
    protected $fillable=['articleid',
    'languageid',
    'title',
    'subtitle',
    'content',
    'file',
    'alt',
    'tags_id'
];
    public function articleval()
    {
        return $this->belongsTo(Article::class, 'articleid', 'id');
    }
}
