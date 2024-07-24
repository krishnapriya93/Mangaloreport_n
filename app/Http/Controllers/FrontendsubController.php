<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

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
}
