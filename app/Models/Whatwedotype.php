<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Whatwedotype extends Model
{
    use HasFactory;

    protected $table = "whatwedotypes";

    protected $guarded = [];

    public function whatwedotype_sub()
    {
        return $this->hasMany(Whatwedotypesub::class, 'whatwedotypeid', 'id');
    }

}
