<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;

    protected $table = "tenders";

    protected $fillable = ['user_id','status_id','tenderdate','tendertype','tenderenddate','tenderno','tenderstartdate','department','emd','corrigendum'];

    public function tender_sub()
    {
        return $this->hasMany(TenderSub::class, 'tenderid', 'id');
    }


    public function tender_type()
    {
        return $this->belongsTo(TenderType::class, 'tendertype', 'id');
    }


    public function tender_items()
    {
        return $this->hasMany(TenderItem::class,'tenderid','id');
    }
}
