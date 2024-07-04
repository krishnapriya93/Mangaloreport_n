<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pollanswer extends Model
{
    use HasFactory;

    protected $table = "pollanswers";

    protected $fillable = ['user_id','question_mainid','order','status_id'];

    public function pollanswersub()
    {
        return $this->hasMany(Pollanswersub::class, 'answer_mainid', 'id');
    }
}
