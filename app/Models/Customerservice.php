<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customerservice extends Model
{
    use HasFactory;

    protected $table = "customerservices";

    protected $fillable = ['status_id','users_id','delet_flag','menulinktype_id','menulinktype_data'];

    public function custservices_sub()
    {
        return $this->hasMany(Customerservicesub::class, 'customerserviceid', 'id');
    }
}
