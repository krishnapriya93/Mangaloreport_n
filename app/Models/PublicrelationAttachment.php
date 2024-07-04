<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicrelationAttachment extends Model
{
    use HasFactory;
    protected $table='publicrelation_attachments';

    protected $fillable=[
        'publicrelations_id',
        'status_id',
        'user_id',
    ];
    public function publicrelation_attachments_langs(){
        return $this->hasMany(PublicrelationAttachmentLang::class,'publicrelation_attachments_id','id');
    }
}
