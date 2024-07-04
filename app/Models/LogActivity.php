<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class LogActivity extends Model
{
    use HasFactory;

    protected $table = "log_activities";

    protected $fillable = [
        'subject', 'url', 'method', 'ip', 'agent', 'user_id'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
