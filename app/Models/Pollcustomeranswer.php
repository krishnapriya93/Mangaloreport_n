<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pollcustomeranswer extends Model
{
    use HasFactory;

    protected $fillable = ['pollquestion_id','pollanswer_id', 'session_id', 'client_ip'];

    public function pollanswersub()
    {
        return $this->hasMany(Pollanswersub::class, 'answer_mainid', 'id');
    }
}
