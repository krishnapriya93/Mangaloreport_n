<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Downloadtypesub extends Model
{
    use HasFactory;

    protected $table = "downloadtypesubs";

    protected $fillable = ['alternatetext','downloadtypeid','delet_flag','languageid','status_id','title','userid'];

    public function downloadtype()
    {
        return $this->belongsTo(Downloadtype::class, 'downloadtypeid', 'id');
    }
}
