<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderPac extends Model
{
    use HasFactory;

    protected $table = "tender_pacs";

    protected $fillable = ['status_id','user_id'];

    public function tender_pac_sub()
    {
        return $this->hasMany(TenderPacSub::class, 'tenderpacid', 'id');
    }
}
