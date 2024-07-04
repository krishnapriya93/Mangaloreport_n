<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articleattachments extends Model
{
    use HasFactory;
    protected $fillable=[
        'article_id',
        'status_id',
        'user_id',
     ];
    public function articleattachments_langs(){
        return $this->hasMany(ArticleattachmentsLang::class,'articleattachments_id','id');
    }
}
