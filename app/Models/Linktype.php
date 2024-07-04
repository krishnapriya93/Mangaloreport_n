<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linktype extends Model
{
    use HasFactory;

    protected $table = "linktypes";

    protected $fillable = ['status_id','userid','delet_flag'];

    public function linktype_sub()
    {
        return $this->hasMany(Linktypesub::class, 'linktypeid', 'id');
    }
}
