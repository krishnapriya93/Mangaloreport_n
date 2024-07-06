<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediaadminController extends Controller
{
    public function index()
    {
       $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
       $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
       return view('backend.mediaadmin.mediahome',compact('navbar','user'));
    }
}
