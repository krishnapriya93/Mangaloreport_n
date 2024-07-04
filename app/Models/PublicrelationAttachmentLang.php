<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicrelationAttachmentLang extends Model
{
    use HasFactory;
    protected $table='publicrelation_attachments_langs';
    protected $fillable=[
        'publicrelation_attachments_id',
        'alt',
        'file',
        'size',
        'title',
        'description',
        'lang_id',
    ];
}
