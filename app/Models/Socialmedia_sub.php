<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socialmedia_sub extends Model
{
    use HasFactory;

    protected $table = "socialmedia_subs";

    protected $fillable = ['alternatetext','title','languageid','socialmediaid','status_id','userid','delet_flag'];

    public function socialmedia_main()
    {
        return $this->belongsTo(Socialmedia::class, 'socialmediaid', 'id');
    }
}
