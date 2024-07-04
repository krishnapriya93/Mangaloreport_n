<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Whatsnew extends Model
{
    use HasFactory;

    protected $table = "whatsnews";

    protected $fillable = ['status_id','userid','delet_flag','sbutype_id','sbu_id'];

    public function whats_sub()
    {
        return $this->hasMany(Whatsnewsub::class, 'whatsnewid', 'id');
    }
}
