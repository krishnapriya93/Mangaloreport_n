<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderSub extends Model
{
    use HasFactory;

    protected $table = "tender_subs";

    protected $fillable = ['tenderid','languageid','title','description'];

    public function lang()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }
}
