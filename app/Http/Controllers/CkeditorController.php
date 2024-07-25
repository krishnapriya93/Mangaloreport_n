<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CkeditorController extends Controller
{
   //ck editior file upload
   public function articleckimageupload(Request $request)
   {

    try{
        $validator = Validator::make(
            $request->all(),
            [
                'upload'      => 'required|mimes:jpg,png,jpeg',
           ],[
                'upload.dimensions' => 'Image resolution does not meet the requirement.',
                'upload.mimes'   => 'Invalid image format required format:jpg,jpeg,png',

            ]);
// return info($validator);
            // dd($validator->fails());
            // dd($validator->fails());
            if ($validator->fails()) {
                // $originName = $request->file('upload')->getClientOriginalName();
                // $fileName = pathinfo($originName, PATHINFO_FILENAME);
                // $extension = $request->file('upload')->getClientOriginalExtension();
                // $fileName = $fileName.'_'.time().'.'.$extension;
                // $request->file('upload')->move(public_path('ckupload'), $fileName);
                // $CKEditorFuncNum = $request->input('CKEditorFuncNum');
                // $url = asset('ckupload/'.$fileName);
                //  $msg = 'Invalid image format required format:webp,jpg,jpeg,png';
                // $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                // echo $response;
                // return false;
                $msg = 'Invalid image format required format:jpg,jpeg,png';
                return $msg;

            }


            if($request->hasFile('upload')) {
                $originName = $request->file('upload')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('upload')->getClientOriginalExtension();
                $fileName = $fileName.'_'.time().'.'.$extension;
                $request->file('upload')->move(public_path('ckupload'), $fileName);
                $CKEditorFuncNum = $request->input('CKEditorFuncNum');
                $url = asset('ckupload/'.$fileName);
                $msg = 'Image uploaded successfully';
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                @header('Content-type: text/html; charset=utf-8');
                return $response;
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }


   }
}
