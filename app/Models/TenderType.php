<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderType extends Model
{
    use HasFactory;

    protected $table = "tender_types";

    protected $fillable = ['status_id','user_id'];

    public function tender_type_sub()
    {
        return $this->hasMany(TenderTypeSub::class, 'tendertypeid', 'id');
    }
}
