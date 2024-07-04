<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faqsub extends Model
{
    use HasFactory;

    protected $table = "faqsubs";

    protected $fillable = ['faqid','status_id','userid','languageid','question','answer','poster'];

    public function lang_sel()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }
}
