<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faqattachment extends Model
{
    use HasFactory;

    protected $table = "faqattachments";

    protected $fillable = ['faqid','languageid','uploads','orgname'];

    public function lang_sel()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }
}
