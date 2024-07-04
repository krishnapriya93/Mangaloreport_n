<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallerytype extends Model
{
    use HasFactory;

    protected $table = 'gallerytypes';
    protected $fillable = ['name','delet_flag','status_id','userid'];
}
