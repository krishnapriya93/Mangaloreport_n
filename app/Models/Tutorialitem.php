<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutorialitem extends Model
{
    use HasFactory;

    protected $table = "tutorialitems";

    protected $fillable = ['tutorialid','uploads','alternate_text'];
}
