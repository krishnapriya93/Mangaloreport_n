<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    use HasFactory;

    protected $table = "contactuses";

    protected $fillable = ['status_id','userid','delet_flag','contactphone','contactemail','map','website','created_at','updated_at','viewer_id','sbutype_id'];

    public function contact_sub()
    {
        return $this->hasMany(Contactus_sub::class, 'contactusid', 'id');
    }
}
