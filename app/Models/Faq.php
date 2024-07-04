<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = "faqs";

    protected $fillable = ['status_id','users_id','sbutype_id'];


    public function faq_sub()
    {
        return $this->hasMany(Faqsub::class, 'faqid', 'id');
    }

    public function faq_attachement()
    {
        return $this->hasMany(Faqattachment::class, 'faqid', 'id');
    }

}
