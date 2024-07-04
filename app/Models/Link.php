<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $table = "links";

    protected $fillable = ['url','iconclass','status_id','userid','delet_flag','linktypeid','file',
    'menulinktype_id',
    'menulinktype_data','orderno'
    ];

    public function link_sub()
    {
        return $this->hasMany(Linksub::class, 'linkid', 'id');
    }
}
