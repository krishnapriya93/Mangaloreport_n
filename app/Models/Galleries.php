<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galleries extends Model
{
    use HasFactory;
    protected $table = "galleries";

    protected $fillable = ['status_id','userid','delet_flag','date','gallerytypeid','file','sbutype_id'];

    public function gallery_sub()
    {
        return $this->hasMany(Gallery_sub::class, 'galleryid', 'id');
    }

    public function gallery_items()
    {
        return $this->hasMany(Galleryitem1::class, 'gallery_id', 'id');
    }
}
