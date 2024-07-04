<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pollquestion extends Model
{
    use HasFactory;

    protected $table = "pollquestions";

    protected $fillable = ['status_id','user_id','multi_choice_flag','order'];

    public function Pollquestionsub()
    {
        return $this->hasMany(Pollquestionsub::class, 'question_mainid', 'id');
    }

    public function pollanswers()
    {
        return $this->hasMany(Pollanswer::class, 'question_mainid', 'id');
    }

    public function custpollanswers()
    {
        return $this->hasMany(Pollcustomeranswer::class, 'pollquestion_id', 'id');
    }
}
