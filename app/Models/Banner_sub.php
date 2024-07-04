<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner_sub extends Model
{
    use HasFactory;

    protected $table = "banner_subs";

    protected $fillable = ['alternatetext','bannerid','delet_flag','languageid','poster','status_id','subtitle','title'];

    public function banner()
    {
        return $this->belongsTo(Banner::class, 'bannerid', 'id');
    }
}
