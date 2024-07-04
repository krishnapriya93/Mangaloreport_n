<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;

    protected $table = "tenders";

    protected $fillable = ['user_id','status_id','tendercat','tenderdate','tendertype','pac_slabs','functional_unit','tenderno','viewpermission'];

    public function tender_sub()
    {
        return $this->hasMany(TenderSub::class, 'tenderid', 'id');
    }

    public function tender_category()
    {
        return $this->belongsTo(TenderCategory::class, 'tendercat', 'id');
    }

    public function tender_type()
    {
        return $this->belongsTo(TenderType::class, 'tendertype', 'id');
    }

    public function tender_pac()
    {
        return $this->belongsTo(TenderPac::class, 'pac_slabs', 'id');
    }

    public function tender_items()
    {
        return $this->hasMany(TenderItem::class,'tenderid','id');
    }
}
