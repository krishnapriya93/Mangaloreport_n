<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestonesub extends Model
{
    use HasFactory;

    protected $table = "milestonesubs";

    protected $fillable = ['languageid','milestoneid','title','poster','description','content'];


    public function milestone()
    {
        return $this->hasMany(Milestone::class, 'milestoneid', 'id');
    }
}
