<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderCategory extends Model
{
    use HasFactory;

    protected $table = "tender_categories";

    protected $fillable = ['status_id','user_id'];

    public function tender_categories_sub()
    {
        return $this->hasMany(TenderCategorySub::class, 'tendercategoryid', 'id');
    }

}
