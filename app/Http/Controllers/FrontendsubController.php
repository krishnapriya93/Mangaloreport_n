<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\Feedback;
use App\Models\Publicrelation;

use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;

class FrontendsubController extends Controller
{
   public function feedbacksubmit(Request $request)
   {

    try{

      $validator = Validator::make(
      $request->all(),
      [
          'inputName'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
          'inputsubject'    => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
          'inputEmail'      => 'required|regex:/(.+)@(.+)\.(.+)/i',
          'inputMessage'    => 'required|min:3|max:1000',
      ],[
          'inputName.required' => 'Title is required',
          'inputName.min' => 'Title  minimum lenght is 2',
          'inputName.max' => 'Title  maximum lenght is 50',
          'inputName.regex' => 'Invalid characters not allowed for Title',

      ]);
      if ($validator->fails()) {
          dd($validator->errors());
          return back()->withInput()->withErrors($validator->errors());
      }
      $ip= $request->ip();

      $position = Location::get($ip);

      if($position == "false")
      {
         $countryName = $position->countryName;
         $cityName    = $position->cityName;
      }else{
         $countryName ='';
         $cityName    ='';
      }

         $storeinfo=new Feedback([
             'userName'=>$request->inputName,
             'subject'=>$request->inputName,
             'email'=>$request->inputName,
             'suggesition'=>$request->inputName,
             'ip'=>$ip,
             'countryName'=>$request->countryName,
             'cityName'=>$request->cityName,
         ]);

         $storedetails=$storeinfo->save();
         return redirect()->route('feedback')->with('success','created successfully');

  } catch (ModelNotFoundException $exception) {
      \LogActivity::addToLog($exception->getMessage(),'error');
      $data = \LogActivity::logLatestItem();
      return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
  }
   }

   public function search(Request $request,$id)
   {

    try{

      $validator = Validator::make(
      $request->all(),
      [
          'searchkeyword'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
      ],[
          'searchkeyword.required' => 'Title is required',
          'searchkeyword.min' => 'Title  minimum lenght is 2',
          'searchkeyword.max' => 'Title  maximum lenght is 50',
          'searchkeyword.regex' => 'Invalid characters not allowed for Title',

      ]);
      if ($validator->fails()) {
          return back()->withInput()->withErrors($validator->errors());
      }
      if (!Session::has('bilingual')) {
        Session::put('bilingual', 1);
    }

    $sessionbil = Session::get('bilingual');
    $mainsubmenus = app('App\Http\Controllers\FrontendController')->mainmenu($sessionbil);
    $projectid = Crypt::decryptString($id);

    $mainbanner = app('App\Http\Controllers\FrontendController')->mainbanner($sessionbil);
    $circulartrades = app('App\Http\Controllers\FrontendController')->circulartrade($sessionbil);

    $whatwedo = app('App\Http\Controllers\FrontendController')->whatwedo($sessionbil);
    $relatedlinks = app('App\Http\Controllers\FrontendController')->relatedlinks($sessionbil);
    $socialmedia = app('App\Http\Controllers\FrontendController')->socialmedia($sessionbil);
    $bod = app('App\Http\Controllers\FrontendController')->bod($sessionbil);
    $whatsnew = app('App\Http\Controllers\FrontendController')->whatsnew($sessionbil);
    $tender = app('App\Http\Controllers\FrontendController')->tender($sessionbil);
    $gallery = app('App\Http\Controllers\FrontendController')->gallery($sessionbil);

      $id = Crypt::decryptString($id);
      $keyword=$request->searchkeyword;
      if($id==1)//project
      {
        $projects = publicrelation::with(['publicrelationitem', 'publicrelsub'])
        ->where('publicreltypeid', 3)
        ->where(function ($query) use ($keyword) {
            $query->whereHas('publicrelationitem', function ($q2) use ($keyword) {
                $q2->where('alternate_text', 'like', "%{$keyword}%");
            })
            ->orWhereHas('publicrelsub', function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                      ->orWhere('content', 'like', "%{$keyword}%");
            });
        })
        ->orderBy('id', 'DESC')
        ->get();
        return view('frontend.main.projectview', compact('sessionbil', 'mainsubmenus', 'mainbanner', 'circulartrades', 'whatwedo', 'relatedlinks', 'socialmedia', 'bod', 'tender', 'whatsnew', 'gallery', 'projects','keyword'));

      }

  } catch (ModelNotFoundException $exception) {
      \LogActivity::addToLog($exception->getMessage(),'error');
      $data = \LogActivity::logLatestItem();
      return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
  }
   }
}
