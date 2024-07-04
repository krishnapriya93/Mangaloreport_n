<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordertypesub extends Model
{
    use HasFactory;

    protected $table = "ordertypesubs";

    protected $fillable = ['ordertypeid','delet_flag','languageid','status_id','title','userid'];

    public function Ordertype()
    {
        return $this->belongsTo(Ordertype::class, 'ordertypeid', 'id');
    }
}
