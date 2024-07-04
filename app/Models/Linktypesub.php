<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linktypesub extends Model
{
    use HasFactory;

    protected $table = "linktypesubs";

    protected $fillable = ['alternatetext','linktypeid','delet_flag','languageid','poster','status_id','title','userid'];

    public function linktype()
    {
        return $this->belongsTo(Linktype::class, 'linktypeid', 'id');
    }
}
