<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BOD_sub extends Model
{
    use HasFactory;
    protected $fillable=[
        'bod_main_id',
        'name',
        'languageid',
        'description',
        'desig_id',
        'alt'
    ];
    public function bod_main()
    {
        return $this->belongsTo(BOD::class, 'bod_main_id', 'id');
    }
    public function lang_sel()
    {
        return $this->belongsTo(Language::class, 'languageid', 'id');
    }
}
