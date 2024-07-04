<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sectionofficesub extends Model
{
    use HasFactory;

    protected $table = "sectionofficesubs";

    protected $fillable = ['sectionofficeid','languageid','subtitle','status_id','title'];

    public function sectionoffice()
    {
        return $this->belongsTo(Sectionoffice::class, 'sectionofficeid', 'id');
    }
}
