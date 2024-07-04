<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articletype extends Model
{
    use HasFactory;

    protected $table = "articletypes";

    protected $fillable = ['status_id','userid','delet_flag','sbu_type','viewer_id','multi_sbu','urlkeyid'];

    public function articletype_sub()
    {
        return $this->hasMany(Articletypesub::class, 'articletypeid', 'id');
    }
    public function article_sub()
    {
        return $this->hasMany(Articletypesub::class, 'articletypeid', 'id');
    }
    public function sbu_type_user()
    {
        return $this->hasMany(Sbutype::class, 'id', 'sbu_type');
    }
    public function multi_user()
    {
        return $this->hasMany(User::class, 'id', 'multi_sbu');
    }
}
