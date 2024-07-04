<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articletypesub extends Model
{
    use HasFactory;

    protected $table = "articletypesubs";

    protected $fillable = ['articletypeid','delet_flag','languageid','status_id','title','userid'];

    public function articletype()
    {
        return $this->belongsTo(Articletype::class, 'articletypeid', 'id');
    }
}
