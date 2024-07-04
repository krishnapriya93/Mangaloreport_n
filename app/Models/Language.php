<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $table = 'languages';
    protected $fillable = ['name','delet_flag','status_id','userid'];

    public function mainmenu_lan()
    {
        return $this->hasMany(Mainmenu::class, 'language_id', 'id');
    }
}
