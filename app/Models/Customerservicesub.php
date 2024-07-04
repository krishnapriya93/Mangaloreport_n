<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customerservicesub extends Model
{
    use HasFactory;

    protected $table = "customerservicesubs";

    protected $fillable = ['customerserviceid','languageid','title'];

    public function customerservice()
    {
        return $this->belongsTo(Customerservice::class, 'customerserviceid', 'id');
    }
}
