<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderItem extends Model
{
    use HasFactory;

    protected $table = "tender_items";

    protected $fillable = ['tenderid', 'image', 'alternate_text', 'status_id', 'user_id'];

}
