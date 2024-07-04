<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sectionoffice extends Model
{
    use HasFactory;

    protected $table = "sectionoffices";

    protected $fillable = ['status_id','userid','delet_flag'];

    public function sectionoffice_sub()
    {
        return $this->hasMany(Sectionofficesub::class, 'sectionofficeid', 'id');
    }
}
