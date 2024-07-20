<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

use App\Models\Articletype;
use App\Models\usertype;
use App\Models\Language;
use App\Models\Componentpermission;
use App\Models\Articletypesub;
use App\Models\BOD;
use App\Models\BOD_sub;
use App\Models\Designation;
use App\Models\Milestone;
use App\Models\Footermenu;
use App\Models\Gallerytype;
use App\Models\Logotype;
use App\Models\Menulinktype;
use App\Models\Publicrelationtype;
use App\Models\PublicrelationtypSub;
use App\Models\Linktype;
use App\Models\Linktypesub;
use App\Models\TenderType;
use App\Models\TenderTypeSub;
use Illuminate\Support\Facades\Storage;

use \Crypt;
use DB;
use Redirect;

class MasterController extends Controller
{
   public function index(Request $request)
   {
      $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
      $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
      $userIp   = $request->ip();
      $carddata = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
      return view('backend.masteradmin.masterhome',compact('navbar','user','userIp','carddata'));
   }

   /*Article type*/
   public function articletype()
   {
       $data = Articletype::with(['article_sub' =>function($query){
           $query->where('delet_flag',0);
       }])->where('delet_flag',0)->get();


       $breadcrumb = array(
           0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masterhome'),
           1 => array('title' => 'Article type', 'message' => 'Article type', 'status' => 1)
        );
       $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
       $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
       $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

       $usertype=usertype::get();

       return view('backend.masteradmin.Articletype.articletypelist',compact('data','breadcrumbarr','usertype','navbar','user'));
   }


/*Article type create*/
   public function createarticletype()
   {

       $language = Language::where('delet_flag',0)->orderBy('name')->get();

       $breadcrumb = array(
           0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masterhome'),
           1 => array('title' => 'Articletype', 'message' => 'Articletype', 'status' => 0, 'link' => '/masteradmin/articletype'),
           2 => array('title' => 'Create article type', 'message' => 'Create article type', 'status' => 1)
        );
       $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
       $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
       $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
       $url = url()->previous();
       $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
       $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();

       return view('backend.masteradmin.Articletype.createarticletype',compact('breadcrumbarr','language','navbar','user','Navid'));
   }

/*Store Article type*/

   public function storearticletype(Request $request)
   {
       // dd($request->all());
       $validator = Validator::make(
           $request->all(),
           [
               'sel_lang.*'=>app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
               'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
           ],[
               'title.required' => 'Title is required',
               'title.min' => 'Title  minimum lenght is 2',
               'title.max' => 'Title  maximum lenght is 50',
               'title.regex' => 'Invalid characters not allowed for Title',

           ]);
           if ($validator->fails()) {
               // dd($validator->errors());
               return back()->withInput()->withErrors($validator->errors());
           }
       try{
           $role_id = Auth::user()->id;

           $leng=count($request->sel_lang);
           // dd($leng);
           if($request->sbu_user==null)
           {
               $sbu_user= 0;
           }else{
               $sbu_user= $request->sbu_user;
           }
           $storeinfo=new Articletype([
                               'userid'=>Auth::user()->id,
                               'delet_flag'=>0,
                               'status_id'=>1,
                           ]);
// dd($storeinfo);
           $res = $storeinfo->save();
           $Articletypeid = DB::getPdo()->lastInsertId();

           for($i=0;$i<$leng;$i++){


               if($Articletypeid){

                       $store_sub_info=new Articletypesub([
                                   'languageid'=>$request->sel_lang[$i],
                                   'title' =>$request->title[$i],
                                   'articletypeid' => $Articletypeid,
                                   'userid' => $role_id,
                                   'delet_flag'=>0,
                                   'status_id'=>1,
                               ]);
                        $storedetails_sub=$store_sub_info->save();
               }
               // dd($path);
           }//forloopend

           return redirect()->route('articletype')->with('success','created successfully');

       } catch (ModelNotFoundException $exception) {
           \LogActivity::addToLog($exception->getMessage(),'error');
           $data = \LogActivity::logLatestItem();
           return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
       }

   }

  /*edit Article type*/
   public function editarticletype($id)
   {

       $id= Crypt::decryptString($id);
       $edit_f = 'E';
       $keydata = Articletype::with(['article_sub' =>function($query){
           $query->where('delet_flag',0);
       }])->where('delet_flag',0)->where('id',$id)->first();
       $error = '';
       $data = Articletype::with(['article_sub' =>function($query){
           $query->where('delet_flag',0);
       }])->where('delet_flag',0)->get();

       $language = Language::where('delet_flag',0)->orderBy('name')->get();
       $breadcrumb = array(
          0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
           1 => array('title' => 'Articletype', 'message' => 'Articletype', 'status' => 0, 'link' => '/articletype'),
           2 => array('title' => 'Edit article type', 'message' => 'Edit article type', 'status' => 1)
        );
       $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
       $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
       $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

       return view('backend.masteradmin.Articletype.createarticletype', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','language','user'));
   }

   /*Articletype  update*/
   public function updatearticletype(Request $request)
   {
       // dd($request->all());
       $validator = Validator::make(
           $request->all(),
           [
               'sel_lang.*'=>app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
               'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
           ],[
               'title.required' => 'Title is required',
               'title.min' => 'Title  minimum lenght is 2',
               'title.max' => 'Title  maximum lenght is 50',
               'title.regex' => 'Invalid characters not allowed for Title',

           ]);
           if ($validator->fails()) {
               // dd($validator->errors());
               return back()->withInput()->withErrors($validator->errors());
           }
       try{
           if($request->sbu_user==null)
           {
               $sbu_user= 0;
           }else{
               $sbu_user= $request->sbu_user;
           }
           $storeinfo=Articletype::where('id',$request->hidden_id) ->update([
               'viewer_id'=>$request->sbu_id,
               'sbu_type'=>$sbu_user,
               'multi_sbu'=>$request->moresbuuser,//user table id
           ]);
       if($storeinfo)
       {
           for ($i=0; $i<count($request->title); $i++) {
               $res=Articletypesub::where('articletypeid',$request->hidden_id)->where('languageid',$request->sel_lang[$i])
                   ->update([
               'title' =>$request->title[$i],
       ]);
       // dd($request->sel_lang[$i]);

       } //forloopend
       }

       if($res){
           DB::commit();
           return Redirect('articletype')->with('success','Updated successfully');
       }else{
           DB::rollback();
           return back()->withErrors('Not Updated ');
       }

       } catch (ModelNotFoundException $exception) {
           \LogActivity::addToLog($exception->getMessage(),'error');
           $data = \LogActivity::logLatestItem();
           return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
       }

   }

     /* Article delete*/
     public function deletearticletype($id)
     {
         $id= Crypt::decryptString($id);
         // dd($id);
             DB::beginTransaction();

              $res_sub= Articletypesub::where('articletypeid',$id)->delete();

             if($res_sub)
             {
              $res= Articletype::findOrFail($id)->delete();

             }
             $edit_f ='';
                  if($res_sub){
                     DB::commit();
                      return Redirect('articletype')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                  }else{
                     DB::rollback();
                      return back()->withErrors('Not deleted ');
                  }
     }
         /*Articletype Status*/
   public function statusarticletype($id)
   {
       $id= Crypt::decryptString($id);
       $status=Articletype::where('id',$id)->value('status_id');

       DB::beginTransaction();
       if($status==1)
       {
           $uparr=array(
               'status_id'=>0,
                );
       }else{
           $uparr=array(
               'status_id'=>1,
                );
       }


           $res=Articletype::where('id',$id)->update($uparr);

           $edit_f ='';
                if($res){
                   DB::commit();
                    return Redirect('articletype')->with('success','Status updated successfully',['edit_f' => $edit_f]);
                }else{
                   DB::rollback();
                    return back()->withErrors('Not deleted ');
                }
   }

   /*Sbu milestonelis */
   public function milestonelist()
   {
       $role_id = Auth::user()->id;
     $data = Milestone::with(['milestonesub' =>function($query){
       // $query->where('delet_flag',0);
   }])->where('user_id',$role_id)->get();

     $language = Language::where('delet_flag',0)->orderBy('name')->get();

     $role_type=Auth::user()->role_id;
    if($role_type==3){//planning office
         $breadcrumb = array(
             0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masterhome'),
             1 => array('title' => 'Milestone', 'message' => 'Milestone', 'status' => 1)
          );
     }

     $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
     $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
     $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

   return view('backend.masteradmin.Milestone.milestonelist',compact('data','breadcrumbarr','language','navbar','user'));
   }

   /*Milestone create*/
   public function createmilestone()
   {

       $language = Language::where('delet_flag',0)->orderBy('name')->get();
       $role_id=Auth::user()->role_id;

      if($role_id==3){//planning office
           $breadcrumb = array(
               0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masterhome'),
               1 => array('title' => 'Milestone', 'message' => 'Milestone', 'status' => 0, 'link' => '/planning/milestonelist'),
               2 => array('title' => 'Create Milestone', 'message' => 'Create Milestone', 'status' => 1)
            );
        }

       $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
       $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
       $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
       $url = url()->previous();
       $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
       $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();

       $years = range(Carbon::now()->year, 1920);
       //  dd($Navid->id);
       return view('backend.masteradmin.Milestone.createmilestone',compact('breadcrumbarr','language','navbar','user','Navid','years'));
   }

   /*store Milestone*/
   public function storemilestone(Request $request)
   {
       // dd($request->all());
       try{
         $request->validate([
               'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
               'con_title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg_ckedit(),
          ],
           [
               'title.required' => 'Title is required',
               'title.min' => 'Title  minimum lenght is 2',
               'title.max' => 'Title  maximum lenght is 50',
               'title.regex' => 'Invalid characters not allowed for Title',
           ]);
           $request->input();
           $role_id = Auth::user()->id;
           DB::beginTransaction();
           $leng=count($request->sel_lang);
           // dd($leng);
           $link=$request->link;
           if($link=='')
           {
             $link='';
           }else{
             $link=$link;
           }
           $iconclass=$request->iconclass;
           if($iconclass=='')
           {
             $iconclass='';
           }else{
             $iconclass=$iconclass;
           }
           $storeinfo=new Milestone([
                               'user_id'=>$role_id,
                               'status_id'=>1,
                               'date'=>$request->date,
                               'link'=>$request->link,
                               'year'=>$request->year,
                               'icon_class'=>$request->iconclass,
                               'sbutype_id'=>Auth::user()->sbutype,
                           ]);

           $res = $storeinfo->save();
           $milestoneid = DB::getPdo()->lastInsertId();
// dd($milestoneid);
           for($i=0;$i<$leng;$i++){

              // dd($request->sel_lang[$i]);
               if($milestoneid){
                   if(isset($request->poster))
                   {
                       foreach($request->file('poster') as $key => $file)
                       {
                         $date = date('dmYH:i:s');
                         if($request->file('poster'))
                         {
                           $imageName = 'Milestone' .$request->sel_lang[$i]. $date . '.' . $file->extension();
                           $filename[]=$imageName;
                           $path = $request->file('poster')[$i]->storeAs('/uploads/Milestone/', $imageName, 'myfile');
                         }else{

                         }
                           // else{
                           //   $imageName='';
                           //

                       }//foreach
                   }
                   else{
                       $imageName='';
                   }

                       $store_sub_info=new Milestonesub([
                                   'languageid'=>$request->sel_lang[$i],
                                   'title' =>$request->title[$i],
                                   'milestoneid' => $milestoneid,
                                   'description'=>$request->description[$i],
                                   'content'=>$request->con_title[$i],
                                   'poster'=>$imageName
                               ]);

                        $storedetails_sub=$store_sub_info->save();
               }
               // dd($path);
           }//forloopend

           if($storedetails_sub)
           {
               $role_type=Auth::user()->role_id;

               if($role_type==5)//SBU admin
               {
                   DB::commit();
                   return redirect()->route('milestonelist')->with('success','created successfully');
               }else if($role_type==3){//Site admin

                   DB::commit();
                   return redirect()->route('planning.milestonelist')->with('success','created successfully');
               }

           }else{
               DB::rollback();
               return back()->withErrors('Not created ');
           }



       } catch (ModelNotFoundException $exception) {
           \LogActivity::addToLog($exception->getMessage(),'error');
           $data = \LogActivity::logLatestItem();
           return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
       }

   }


   /*edit milestone*/
   public function editmilestone($id)
   {
       $id= Crypt::decryptString($id);//History::with(['historysub
       $edit_f = 'E';
       $keydata = Milestone::with(['milestonesub' =>function($query){
           // $query->where('delet_flag',0);
       }])->where('id',$id)->first();
       $error = '';
       $data = Milestone::with(['milestonesub' =>function($query){
           // $query->where('delet_flag',0);
       }])->get();

       $language = Language::where('delet_flag',0)->orderBy('name')->get();
       $years = range(Carbon::now()->year, 1920);


        $role_id=Auth::user()->role_id;

      if($role_id==3){//planning office
           $breadcrumb = array(
               0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masterhome'),
               1 => array('title' => 'Milestone', 'message' => 'Milestone', 'status' => 0, 'link' => '/planning/milestonelist'),
               2 => array('title' => 'Edit Milestone', 'message' => 'Edit Milestone', 'status' => 1)
            );
        }

       $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
       $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
       $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
       $url = url()->previous();
       $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
       $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();

// dd($keydata);
       return view('backend.masteradmin.Milestone.createmilestone', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user','language','Navid','years'));
   }


/*milestone delete*/
public function deletemilestone($id)
{
   $id= Crypt::decryptString($id);

       DB::beginTransaction();
      $imageName = Milestonesub::where('milestoneid', $id)->select('poster')->get();

       foreach($imageName as $img){
               Storage::disk('myfile')->delete('/uploads/Milestone/' . $img->file);
           }
        $res_sub= Milestonesub::where('milestoneid',$id)->delete();

       if($res_sub)
       {
        $res= Milestone::findOrFail($id)->delete();
       }
       $edit_f ='';
            if($res_sub){

               $role_type=Auth::user()->role_id;
               if($role_type==5)//SBU admin
               {
                   DB::commit();
                   return redirect()->route('milestonelist')->with('success','Deleted successfully');
               }else if($role_type==3){//planning admin
                   DB::commit();
                   return redirect()->route('planning.milestonelist')->with('success','Deleted successfully');
               }

            }else{
               DB::rollback();
                return back()->withErrors('Not deleted ');
            }
}
/**update Milestone */
public function updatemilestone(Request $request)
{
// dd($request->all());
   $id=$request->hidden_id;
   $validator = Validator::make(
       $request->all(),
       [
           'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
           'con_title.*'   => app('App\Http\Controllers\Commonfunctions')->getEntitlereg_ckedit(),
           // 'description.*'   => app('App\Http\Controllers\Commonfunctions')->getEntitlereg_ckedit(),
           //'poster.*'      => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
           'alt_title.*'      => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),

       ],
       [
           'title.required' => 'Title is required',
           'title.regex'    => 'The title format is invalid',
           'title.min'      => 'Title  minimum length is 3',
           'title.max'      => 'Title  maximum length is 150',

           'sub_title.required' => 'Sub Title is required',
           'sub_title.regex'    => 'The Sub Title format is invalid',
           'sub_title.min'      => 'Sub Title  minimum length is 3',
           'sub_title.max'      => 'Sub Title  maximum length is 150',
       ]
   );
   //

   if ($validator->fails()) {
       // dd($validator->errors());
       return back()->withInput()->withErrors($validator->errors());
   }

   try{
       // dd($request->subtitle);

       // dd($request->poster);
       $i=0;
       $filename=array();
       if(isset($request->poster)){
           foreach($request->poster as $filep){
               // echo $i.':::'.count($request->poster);
               if($i<=count($request->poster)){
                   // dd('d');
                   // echo $i;
                   if(isset($request->file('poster')[$i])){
                       $date = date('dmYH:i:s');
                       $imageName = 'Milestone'.$i. $date . '.' .$filep->extension();
                       $filename[]=$imageName;
                       $path = $request->file('poster')[$i]->storeAs('/uploads/Milestone/', $imageName, 'myfile');
                   }else{
                       $j=$i+1;
                       $date = date('dmYH:i:s');
                       $imageName = 'Milestone'.$i. $date . '.' .$filep->extension();
                       $filename[]=$imageName;
                       $path = $request->file('poster')[$j]->storeAs('/uploads/Milestone/', $imageName, 'myfile');
                   }



                   $i++;
               }
               // dd($filename);
           }
       }

       $leng=count($request->sel_lang);
// dd($request->all());
     $main_update=  Milestone::where('id',$request->hidden_id)
                             ->update([
                               'date'=>$request->date,
                               'link'=>$request->link,
                               'icon_class'=>$request->iconclass,
                               'year'=>$request->year,
                             ]);
     if($main_update)
     {
       for($i=0;$i<$leng;$i++){
         // dd(count($lang));
         $chekrows = Milestonesub::where('milestoneid','=', $request->hidden_id)->exists() ? 1 : 0;
// dd($chekrows);
         if($chekrows==1){
             // if(!isset($artsubval->languageid)){
                 // echo $i.' :: lang '.$lng->id.' :::: '.$filename[$i];
                 if(!empty($filename[$i])){
                     $dataarr1=array(
                       'languageid'=>$request->sel_lang[$i],
                       'title' =>$request->title[$i],
                       'milestoneid' => $request->hidden_id,
                       'description'=>$request->description[$i],
                       'content'=>$request->con_title[$i],
                       'poster'=>$imageName
                     );
                 }else{
                     $dataarr1=array(
                       'languageid'=>$request->sel_lang[$i],
                       'title' =>$request->title[$i],
                       'description'=>$request->description[$i],
                       'content'=>$request->con_title[$i],
                       'milestoneid' => $request->hidden_id
                     );
                 }

                 $res1=Milestonesub::where('milestoneid','=',$request->hidden_id)->where('languageid','=',$request->sel_lang[$i])->update($dataarr1);


         }else{
             return back()->withInput()->with('error',"Already existing");

         }



     }
     }

               // dd(true)
               $role_type=Auth::user()->role_id;
               if($role_type==5)//SBU admin
               {
                   return redirect()->route('milestonelist')->with('success','Updated successfully');
               }else if($role_type==3){//Site admin
                   return redirect()->route('planning.milestonelist')->with('success','Updated successfully');
               }


       // }
   }catch(Exception $e){
       return back()->withInput()->with('error',$e);
   }


}


/*Milestone Status*/
public function statusmilestone($id)
   {
       $id= Crypt::decryptString($id);
       $status=Milestone::where('id',$id)->value('status_id');

       DB::beginTransaction();
       if($status==1)
       {
           $uparr=array(
               'status_id'=>0,
           );
           }else{
           $uparr=array(
               'status_id'=>1,
           );
       }
       $res=Milestone::where('id',$id)->update($uparr);

       $edit_f ='';
       if($res){
           DB::commit();
           $role_type=Auth::user()->role_id;
           if($role_type==5)//SBU admin
           {
               return redirect()->route('milestonelist')->with('success','Status change successfully');
           }else if($role_type==3){//Site admin
               return redirect()->route('planning.milestonelist')->with('success','Status change successfully');
           }

       }else{
           DB::rollback();
           return back()->withErrors('Not deleted ');
       }
   }

   //BOD
   public function BODlist(Request $request)
   {
       $breadcrumb = array(
           0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masterhome'),
           1 => array('title' => 'BOD', 'message' => 'BOD', 'status' => 1)
       );
       $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
       $navbar     = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
       $role_id    = Auth::user()->id;
       $user       = app('App\Http\Controllers\Commonfunctions')->userinfo();


       $language   = Language::where('delet_flag',0)->orderBy('name')->get();

       $data       = BOD::with(['bodsub'=>function($query){

       }])->get();

       $designation=Designation::with(['des_sub'=>function($query){

       }])->get();
       // dd();


       return view('backend.masteradmin.BOD.bod',compact('breadcrumbarr','navbar','user','language','data','designation'));
   }

   public function storeBOD(Request $request)
   {
       $validator = Validator::make(
        $request->all(),
        [
            'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            'con_title.*'   => app('App\Http\Controllers\Commonfunctions')->getEntitlereg_ckedit(),
            // 'description.*'   => app('App\Http\Controllers\Commonfunctions')->getEntitlereg_ckedit(),
            //'poster.*'      => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            'alt_title.*'      => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),

        ],
        [
            'title.required' => 'Title is required',
            'title.regex'    => 'The title format is invalid',
            'title.min'      => 'Title  minimum length is 3',
            'title.max'      => 'Title  maximum length is 150',

            'sub_title.required' => 'Sub Title is required',
            'sub_title.regex'    => 'The Sub Title format is invalid',
            'sub_title.min'      => 'Sub Title  minimum length is 3',
            'sub_title.max'      => 'Sub Title  maximum length is 150',
        ]
    );
    //

    if ($validator->fails()) {
        // dd($validator->errors());
        return back()->withInput()->withErrors($validator->errors());
    }
       try{
        DB::beginTransaction();

           if(empty($request->desig_flag)){
               $desig_flag=0;
                }else{
                    $desig_flag=1;
            }
        $chekrows_bod = BOD::where('email', $request->email)->orWhere('mobilenumber',$request->mobilenumber)->exists() ? 1 : 0;

        $leng=count($request->sel_lang);

        if(isset($request->photo))
        {
            $date = date('dmYH:i:s');
            $imageName = 'bod'.$date . '.' .$request->photo->extension();
            $path = $request->file('photo')->storeAs('/assets/backend/uploads/bod/', $imageName, 'myfile');
            if($chekrows_bod==0){
                $dataarr=new BOD([
                    'email'=>$request->email,
                    'officenumber'=>$request->officenumber,
                    'mobilenumber'=>$request->mobilenumber,
                    'desig_flag'=>$desig_flag,
                    'photo'=>$imageName,
                    'user_id'=>Auth::user()->id,
                    'status'=>1
                ]);

            $res=$dataarr->save();
            if($res){
                $bod_main_id=$dataarr->id;
                $lang=Language::where('status_id',1)->get();
                $i=0;
                // foreach($lang as $lng){
                    for($i=0;$i<$leng;$i++){
                    // dd(count($lang));
                    $chekrows = BOD_sub::where('name', $request->name[$i])->exists() ? 1 : 0;
                    if($chekrows==0){
                        $dataarr1=new BOD_sub([
                            'bod_main_id'=>$bod_main_id,
                            'name'=>$request->name[$i],
                            'languageid'=>$request->sel_lang[$i],
                            'description'=>$request->description[$i],
                            'alt'=>$request->alt[$i],
                            'desig_id'=>$request->desig_id[$i]

                        ]);
                        $res1=$dataarr1->save();
                        // if($i<count($lang)){
                        //     $i++;
                        // }
                    }else{
                        DB::rollback();

                        return back()->withInput()->with('error',"Already existing");

                    }



                }

                $success="Saved successfully";
                DB::commit();

                return redirect('masteradmin/BODlist')->with(['success' => $success]);


            }else{
                DB::rollback();

                return back()->withInput()->with('error',"Error while saving");
            }
        }else{
            DB::rollback();

            return back()->withInput()->with('error',"Email/Mobile already existing");
        }
        }else{
            if($chekrows_bod==0){
                $dataarr=new BOD([
                    'email'=>$request->email,
                    'officenumber'=>$request->officenumber,
                    'mobilenumber'=>$request->mobilenumber,
                    'desig_flag'=>$desig_flag,
                    'user_id'=>Auth::user()->id,
                    'status'=>1
                ]);

            $res=$dataarr->save();
            if($res){
                $bod_main_id=$dataarr->id;
                $lang=Language::where('status_id',1)->get();
                $i=0;
                // foreach($lang as $lng){
                    for($i=0;$i<$leng;$i++){
                    // dd(count($lang));
                    $chekrows = BOD_sub::where('name', $request->name[$i])->exists() ? 1 : 0;
                    if($chekrows==0){
                        $dataarr1=new BOD_sub([
                            'bod_main_id'=>$bod_main_id,
                            'name'=>$request->name[$i],
                            'languageid'=>$request->sel_lang[$i],
                            'description'=>$request->description[$i],
                            'alt'=>$request->alt[$i],
                            'desig_id'=>$request->desig_id[$i]

                        ]);
                        $res1=$dataarr1->save();
                        // if($i<count($lang)){
                        //     $i++;
                        // }
                    }else{
                        DB::rollback();

                        return back()->withInput()->with('error',"Already existing");

                    }



                }
                DB::commit();

                $success="Saved successfully";
                return redirect('masteradmin/BODlist')->with(['success' => $success]);


            }else{
                DB::rollback();

                return back()->withInput()->with('error',"Error while saving");
            }
        }else{
            DB::rollback();

            return back()->withInput()->with('error',"Email/Mobile already existing");
        }
        }







           // }
       }catch(Exception $e){
           return back()->withInput()->with('error',$e);
       }


   }

     /*edit BOD*/
     public function editBOD($id)
     {
       // dd(true);
        $id=\Crypt::decryptString($id);
        $editF='E';
         $keydata = BOD::with(['bodsub' =>function($query){
             $query->with(['lang_sel' =>function($query){

             }]);
         }])->where('id',$id)->first();
         $error = '';
         $data = BOD::with(['bodsub' =>function($query){
             // $query->where('delet_flag',0);
         }])->get();

         $language = Language::where('delet_flag',0)->orderBy('name')->get();
         $designation=Designation::with(['des_sub'=>function($query){

         }])->get();
       //   dd($keydata);
         $role_id = Auth::user()->id;
         $breadcrumb = array(
           0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masterhome'),
           1 => array('title' => 'Edit BOD', 'message' => 'Edit BOD', 'status' => 1)
       );

         $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
         $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
         $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
         $url = url()->previous();
         $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
         $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
//   dd($keydata);
       return view('backend.masteradmin.BOD.createbod',compact('breadcrumbarr','navbar','user','language','data','designation','editF','keydata'));

     }

     public function updateBOD(Request $request)
     {
         $validator = Validator::make(
             $request->all(),
             [
                 'name.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                 'description.*'   => 'sometimes|nullable',
                 'desig_id1.*'   => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                 'alt.*'      => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                 'mobilenumber'=> app('App\Http\Controllers\Commonfunctions')->mobileNum_check_sometimes(),
                 'officenumber' => app('App\Http\Controllers\Commonfunctions')->officenumber_check(),
                 'email' => app('App\Http\Controllers\Commonfunctions')->emailId_check(),
                 'photo'      => app('App\Http\Controllers\Commonfunctions')->getImageLTAval(),


             ],
             [
                 'name.required' => 'name is required',
                 'name.regex'    => 'The name format is invalid',
                 'name.min'      => 'name  minimum length is 3',
                 'name.max'      => 'name  maximum length is 150',

                 'description.required' => 'description is required',
                 'description.regex'    => 'The description format is invalid',
                 'description.min'      => 'description  minimum length is 3',
                 'description.max'      => 'description  maximum length is 150',

                 'mobilenumber' => 'mobilenumber is required',
                 'mobilenumber.regex'    => 'The mobilenumber format is invalid',
                 'mobilenumber.min'      => 'mobilenumber  minimum length is 3',
                 'mobilenumber.max'      => 'mobilenumber  maximum length is 150',

                 'officenumber'=> 'officenumber is required',
                 'officenumber.regex'    => 'The officenumber format is invalid',
                 'officenumber.min'      => 'officenumber  minimum length is 3',
                 'officenumber.max'      => 'officenumber  maximum length is 150',

                 'email' => 'email is required',
                 'email.regex'    => 'The email format is invalid',
                 'email.min'      => 'email  minimum length is 3',
                 'email.max'      => 'email  maximum length is 150',

                 'photo' => 'photo is required',
                 'photo.regex'    => 'The photo format is invalid',
                 'photo.min'      => 'photo  minimum length is 3',
                 'photo.max'      => 'photo  maximum length is 150',

             ]
         );
         //
       //   dd($request->all());
         if ($validator->fails()) {
             // dd($validator->errors());
             return back()->withInput()->withErrors($validator->errors());
         }
         try{
                   if(empty($request->desig_flag)){
                       $desig_flag=0;
                   }else{
                       $desig_flag=1;
                   }


                   $lang=Language::where('status_id',1)->get();
                   $i=0;
                   $leng=count($request->sel_lang);
                   $chekrows = BOD_sub::where('bod_main_id', $request->hidden_id)->exists() ? 1 : 0;

                   if($chekrows==1){
                       for($i=0;$i<$leng;$i++){

                               $data_sub=array(
                                   'bod_main_id'=>$request->hidden_id,
                                   'name'=>$request->name[$i],
                                   'languageid'=>$request->sel_lang[$i],
                                   'description'=>$request->description[$i],
                                   'alt'=>$request->alt[$i],
                                   'desig_id'=>$request->desig_id[$i]

                               );
                               $res=BOD_sub::where('bod_main_id','=',$request->hidden_id)->where('languageid',$request->sel_lang[$i])->update($data_sub);

                           }
                   }
                   // dd($res);
                   $chekrows_bod = BOD::where('id', $request->hidden_id)->exists() ? 1 : 0;
                  if($chekrows_bod)
                  {
                   if(isset($request->photo)){
                       $date = date('dmYH:i:s');
                       $imageName = 'bod'.$date . '.' .$request->photo->extension();
                       $path = $request->file('photo')->storeAs('/assets/backend/uploads/bod/', $imageName, 'myfile');
                       $data_main=array(
                           'email'=>$request->email,
                           'officenumber'=>$request->officenumber,
                           'mobilenumber'=>$request->mobilenumber,
                           'desig_flag'=>$desig_flag,
                           'photo'=>$imageName,
                       );
                       $res_main=BOD::where('id','=',$request->hidden_id)->update($data_main);


                   }else{//check row not existing
                       $data_main=array(
                           'email'=>$request->email,
                           'officenumber'=>$request->officenumber,
                           'mobilenumber'=>$request->mobilenumber,
                           'desig_flag'=>$desig_flag,
                       );
                       $res_main=BOD::where('id','=',$request->hidden_id)->update($data_main);

                       }

                       $success="Updated successfully";
                       return redirect('/masteradmin/BODlist')->with(['success' => $success]);
                   }
         }catch(Exception $e){
             return back()->withInput()->with('error',$e);
         }


     }


   public function deleteBOD(Request $request,$encid){
       $id=\Crypt::decryptString($encid);
       try{
           $imageName = BOD::where('id', $id)->select('photo')->first();
           // foreach($imageName as $img){
               Storage::disk('myfile')->delete('/assets/backend/uploads/bod/' . $imageName->photo);
           // }

           $dataartSub=BOD_sub::where('bod_main_id',$id)->delete();
           $dataEdit=BOD::destroy($id);
           $msg="Deleted successfully";
           return redirect('masteradmin/BODlist')->with(['delete' => $msg ]);
       }catch(Exception $e){
           return back()->withInput()->with('error',$e);
       }

}

    /*Footermenu*/
    public function footermenu()
    {
        $data = Footermenu::with(['footermenu_sub' =>function($query){
            $query->where('delet_flag',0)->where('languageid',1);
        }])->where('delet_flag',0)->get();

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Footer menu', 'message' => 'Footer menu', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.masteradmin.Footermenu.footermenulist',compact('data','breadcrumbarr','language','navbar','user'));
    }

    /*Footer menu create*/
     public function createfootermenu()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Footer menu list', 'message' => 'Footer menu list', 'status' => 1, 'link' => '/footermenu'),
            2 => array('title' => 'Footer menu create', 'message' => 'Footer menu create', 'status' => 2)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        return view('backend.masteradmin.Footermenu.createfootermenu',compact('breadcrumbarr','language','navbar','user','Navid'));
    }

     /*Store logo*/

    public function storefootermenu(Request $request)
    {
        // dd($request->poster);
        try{
          $request->validate([
                'sel_lang.*'=>app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'alt_title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'iconclass.*'=>app('App\Http\Controllers\Commonfunctions')->getIconClass(),
           ],
            [
                'title.required' => 'Title is required',
                'title.min' => 'Title  minimum lenght is 2',
                'title.max' => 'Title  maximum lenght is 50',
                'title.regex' => 'Invalid characters not allowed for Title',

                'alt_title.required' => 'Alternate text is required',
                'alt_title.min' => 'Alternate text  minimum lenght is 2',
                'alt_title.max' => 'Alternate text  maximum lenght is 100',
                'alt_title.regex' => 'Invalid characters not allowed for Alternate text',

            ]);
            $request->input();
            $role_id = Auth::user()->id;

            $leng=count($request->sel_lang);
            // dd($leng);
//
                        $storeinfo=new Footermenu([
                                'userid'=>Auth::user()->id,
                                'delet_flag'=>0,
                                'iconclass'=>$request->iconclass,
                                'status_id'=>1,
                            ]);

            $res = $storeinfo->save();
            $footermenuid = DB::getPdo()->lastInsertId();


            // for($i=0;$i<$leng;$i++){


                if($footermenuid){
                    $j=0;
                        $filename=array();
                        foreach($request->poster as $filep){


                            // print_r($request->file('poster')[$i]);
                        //    dd($filep->poster[$i]->extension());
                        // dd(count($request->poster));
                            // $imageName = 'logo' . $date . '.' .$filep->poster->extension();
                            if($j<count($request->poster)){
                                $date = date('dmYH:i:s');
                                $imageName = 'Footermenu'.$j. $date . '.' .$filep->extension();
                                $filename[]=$imageName;
                                $path = $request->file('poster')[$j]->storeAs('/uploads/Footermenu/', $imageName, 'myfile');

                                $j++;

                            }
                        }
// dd($i);
                    //  $date = date('dmYH:i:s');
                    //    foreach($request->file('poster') as $key => $file)
                    //     {
                    //          $imageName = $i . $date . '.' . $file->extension();

                    //          $path=$file->storeAs('/uploads/Footermenu', $imageName,'myfile');

                    //     }
                    for($i=0;$i<$leng;$i++){
                        $store_sub_info=new Footermenusub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'alternatetext' =>$request->alt_title[$i],
                                    'poster' => $filename[$i],
                                    'footermenuid' => $footermenuid,
                                    'userid' => $role_id,
                                    'content'=>$request->content[$i],
                                    'delet_flag'=>0,
                                    'status_id'=>1,
                                ]);

                                // dd($store_sub_info);
                         $storedetails_sub=$store_sub_info->save();

                }
                // dd($path);
            }//forloopend

            return redirect()->route('footermenu')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }


    /*edit Footermenu*/
    public function editfootermenu($id)
    {
        $id= Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = Footermenu::with(['footermenu_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->where('id',$id)->first();
        $error = '';
        $data = Footermenu::with(['footermenu_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Footermenu', 'message' => 'Footermenu', 'status' => 1, 'link' => '/footermenu'),
            2 => array('title' => 'Edit Footermenu', 'message' => 'Edit Footermenu', 'status' => 2)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
// dd($keydata);
        return view('backend.masteradmin.Footermenu.createfootermenu', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user','language','Navid'));
    }

/**update Footermenu */
public function updatefootermenu(Request $request)
{
// dd($request->all());
    $id=$request->hidden_id;
    $validator = Validator::make(
        $request->all(),
        [
            'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            'alt_title.*'      => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
        ],
        [
            'title.required' => 'Title is required',
            'title.regex'    => 'The title format is invalid',
            'title.min'      => 'Title  minimum length is 3',
            'title.max'      => 'Title  maximum length is 150',

            'alt_title.required' => 'Sub Title is required',
            'alt_title.regex'    => 'The Alternative Title format is invalid',
            'alt_title.min'      => 'Alternative Title  minimum length is 3',
            'alt_title.max'      => 'Alternative Title  maximum length is 150',
        ]
    );


    if ($validator->fails()) {
        // dd($validator->errors());
        return back()->withInput()->withErrors($validator->errors());
    }
    // dd($request->all());
    try{

        $i=0;
        $filename=array();
        if(isset($request->poster)){
            foreach($request->poster as $filep){
                // echo $i.':::'.count($request->poster);
                if($i<=count($request->poster)){
                    // dd('d');
                    // echo $i;
                    if(isset($request->file('poster')[$i])){
                        $date = date('dmYH:i:s');
                        $imageName = 'Footermenu'.$i. $date . '.' .$filep->extension();
                        $filename[]=$imageName;
                        $path = $request->file('poster')[$i]->storeAs('/uploads/Footermenu/', $imageName, 'myfile');
                    }else{
                        $j=$i+1;
                        $date = date('dmYH:i:s');
                        $imageName = 'Footermenu'.$i. $date . '.' .$filep->extension();
                        $filename[]=$imageName;
                        $path = $request->file('poster')[$j]->storeAs('/uploads/Footermenu/', $imageName, 'myfile');
                    }
                    $i++;
                }
                // dd($filename);
            }
        }
// dd($request->hidden_id);
        $leng=count($request->sel_lang);

      $main_update=  Footermenu::where('id',$request->hidden_id)
                              ->update([
                                'iconclass'=>$request->iconclass,
                              ]);
      if($main_update)
      {
        for($i=0;$i<$leng;$i++){
          // dd(count($lang));
          $chekrows = Footermenusub::where('title', $request->title[$i])->where('footermenuid','!=', $request->hidden_id)->exists() ? 1 : 0;

          if($chekrows==0){
              // if(!isset($artsubval->languageid)){
                  // echo $i.' :: lang '.$lng->id.' :::: '.$filename[$i];
                  if(!empty($filename[$i])){
                      $dataarr1=array(
                        'languageid'=>$request->sel_lang[$i],
                        'title' =>$request->title[$i],
                        'alternatetext' =>$request->alt_title[$i],
                        'poster' => $filename[$i],
                        'footermenuid' => $request->hidden_id,
                        'content'=>$request->content[$i],
                      );
                  }else{
                      $dataarr1=array(
                        'languageid'=>$request->sel_lang[$i],
                        'title' =>$request->title[$i],
                        'alternatetext' =>$request->alt_title[$i],
                        'footermenuid' => $request->hidden_id,
                        'content'=>$request->content[$i],
                      );
                  }

                  $res1=Footermenusub::where('footermenuid','=',$request->hidden_id)->where('languageid','=',$request->sel_lang[$i])->update($dataarr1);


          }else{
              return back()->withInput()->with('error',"Already existing");

          }
      }
      }
                return redirect()->route('footermenu')->with('success','Updated successfully');


        // }
    }catch(Exception $e){
        return back()->withInput()->with('error',$e);
    }


}


    /*Footermenu delete*/
    public function deletefootermenu($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
             $res_sub= Footermenusub::where('footermenuid',$id)->delete();

            if($res_sub)
            {
             $res= Footermenu::findOrFail($id)->delete();
            }
            $edit_f ='';
                 if($res_sub){
                    DB::commit();
                     return Redirect('footermenu')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback();
                     return back()->withErrors('Not deleted ');
                 }
}
/*Gallerytype*/
public function gallerytype()
{
    $data = Gallerytype::where('delet_flag',0)->get();

    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
        1 => array('title' => 'Gallery type', 'message' => 'Gallery type', 'status' => 1)
     );
    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
    $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

    $usertype=usertype::get();

    return view('backend.masteradmin.Gallerytype.gallerytype',compact('data','breadcrumbarr','usertype','navbar','user'));
}

   /*Store gallery type*/
public function storegallerytype(Request $request)
{

    try{
        $request->validate([
            'gallery_type' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
       ]);
           $request->input();
           $role_id = Auth::user()->id;

           $storeinfo=new Gallerytype([
               'name'=>$request->gallery_type,
               'delet_flag'=>0,
               'status_id'=>1,
               'userid'=>$role_id
           ]);

           $storedetails=$storeinfo->save();
           return redirect()->route('gallerytype')->with('success','created successfully');

    } catch (ModelNotFoundException $exception) {
        \LogActivity::addToLog($exception->getMessage(),'error');
        $data = \LogActivity::logLatestItem();
        return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
    }

}

/*Gallery type delete*/
public function deletegaltype($id)
{
    $id= Crypt::decryptString($id);

        DB::beginTransaction();
        // $uparr=array(
        //     'delet_flag'=>1,
        //      );
         $res= Gallerytype::findOrFail($id)->delete();
        // $res=usertype::where('id',$id)->update($uparr);
        $edit_f ='';
             if($res){
                DB::commit();
                 return Redirect('gallerytype')->with('success','Deleted successfully',['edit_f' => $edit_f]);
             }else{
                DB::rollback();
                 return back()->withErrors('Not deleted ');
             }
}

/*gallery type edit*/
public function editgaltype($id)
{
    $id= Crypt::decryptString($id);
    $edit_f = 'E';
    $keydata = Gallerytype::where('id',$id)->first();
    $error = '';
    $data = Gallerytype::where('delet_flag',0)->get();
    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
        1 => array('title' => 'Gallerytype', 'message' => 'Gallerytype', 'status' => 1)
     );
    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
    $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
    return view('backend.masteradmin.Gallerytype.gallerytype', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user'));
}


/*gallery type  update*/
public function updategallerytype(Request $request)
{
// dd($request->all());
try{
    $request->validate([
        'gallery_type'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
   ]);
       $request->input();

       $uparr=array(
        'name'=>$request->gallery_type,
         );
// dd($uparr);
         $res=Gallerytype::where('id',$request->hidden_id)->update($uparr);
        //  dd($res);
         $edit_f ='U';
         if($res){
             return Redirect('gallerytype')->with('success','Updated successfully',['edit_f' => $edit_f]);
         }else{
             return back()->withErrors('Not Updated ');
         }
} catch (ModelNotFoundException $exception) {
    \LogActivity::addToLog($exception->getMessage(),'error');
    $data = \LogActivity::logLatestItem();
    return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
}

}

/*Logo type*/
public function logotype()
{
    $data = Logotype::where('delet_flag',0)->get();

    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
        1 => array('title' => 'Logo type', 'message' => 'Logo type', 'status' => 1)
     );
    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

    $usertype=usertype::get();

    $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
    return view('backend.masteradmin.Logo.logotype',compact('data','breadcrumbarr','usertype','navbar','user'));
}

/*store logo type*/
public function storelogotype(Request $request)
{
     $role_id = Auth::user()->id;
    try{
        $request->validate([
            'logotype'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
       ]);
           $request->input();

           $storeinfo=new Logotype([
               'name'=>$request->logotype,
               'delet_flag'=>0,
               'status_id'=>1,
               'userid'=>$role_id
           ]);

           $storedetails=$storeinfo->save();
           return redirect()->route('logotype')->with('success','created successfully');

    } catch (ModelNotFoundException $exception) {
        \LogActivity::addToLog($exception->getMessage(),'error');
        $data = \LogActivity::logLatestItem();
        return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
    }

}

 /*edit Logotype*/
public function editlogotype($id)
{
    $id= Crypt::decryptString($id);
    $edit_f = 'E';
    $keydata = Logotype::where('id',$id)->first();
    $error = '';
    $data = Logotype::where('delet_flag',0)->get();
    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
        1 => array('title' => 'Logotype', 'message' => 'Logotype', 'status' => 1)
     );
    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
    $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

    return view('backend.masteradmin.Logo.logotype', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user'));
}

 /*Logotype update*/
public function updatelogotype(Request $request)
{
    try{
        $request->validate([
            'logotype'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
       ]);
           $request->input();

           $uparr=array(
              'name'=>$request->logotype,
             );

             $res=Logotype::where('id',$request->hidden_id)->update($uparr);
             $edit_f ='';
             if($res){

                 return redirect()->route('logotype')->with('success','Updated successfully',['edit_f' => $edit_f]);
             }else{
                 return back()->withErrors('Not Updated ');
             }
    } catch (ModelNotFoundException $exception) {
        \LogActivity::addToLog($exception->getMessage(),'error');
        $data = \LogActivity::logLatestItem();
        return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
    }

}


/*Logotype delete*/
public function deletelogotype($id)
{
    $id= Crypt::decryptString($id);

        DB::beginTransaction();
        // $uparr=array(
        //     'delet_flag'=>1,
        //      );
        // $res=Logotype::where('id',$id)->update($uparr);
         $res= Logotype::findOrFail($id)->delete();
        $edit_f ='';
             if($res){
                DB::commit();
                return redirect()->route('logotype')->with('success','Deleted successfully',['edit_f' => $edit_f]);
             }else{
                DB::rollback();
                 return back()->withErrors('Not deleted ');
             }
}
 /*Link list*/
 public function Menulinktype()
 {
     $data = Menulinktype::where('delet_flag',0)->get();
     $breadcrumb = array(
         0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
         1 => array('title' => 'Menulinktypes', 'message' => 'Menulinktypes', 'status' => 1)
      );
     $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

     $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
     $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
     return view('backend.admin.Menulinktype.menulinktype',compact('data','breadcrumbarr','navbar','user'));
 }

 /*store menulink type*/
 public function storemenulinktype(Request $request)
 {
     try{

         $validator = Validator::make(
             $request->all(),
             [
                 'Menulinktype'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            ],[
                 'title.required' => 'Title is required',
                 'title.min' => 'Title  minimum lenght is 2',
                 'title.max' => 'Title  maximum lenght is 50',
                 'title.regex' => 'Invalid characters not allowed for Title',
             ]);
             if ($validator->fails()) {
                 // dd($validator->errors());
                 return back()->withInput()->withErrors($validator->errors());
             }

            $storeinfo=new Menulinktype([
                'name'=>$request->Menulinktype,
                'delet_flag'=>0,
                'status_id'=>1,
            ]);

            $storedetails=$storeinfo->save();
            return redirect()->route('menulinktype')->with('success','created successfully');

     } catch (ModelNotFoundException $exception) {
         \LogActivity::addToLog($exception->getMessage(),'error');
         $data = \LogActivity::logLatestItem();
         return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
     }

 }

 /*edit Menulinktype*/
 public function editMenulinktype($id)
 {
     $id= Crypt::decryptString($id);
     $edit_f = 'E';
     $keydata = Menulinktype::where('id',$id)->first();
     $error = '';
     $data = Menulinktype::where('delet_flag',0)->get();
     $breadcrumb = array(
         0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
         1 => array('title' => 'Menulinktype', 'message' => 'Menulinktype', 'status' => 1)
      );
     $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
     $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
     $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

     return view('backend.admin.Menulinktype.menulinktype', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user'));
 }

  /*component update*/
 public function updateMenulinktype(Request $request)
 {
     try{
         $request->validate([
             'Menulinktype'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
        ]);
            $request->input();

            $uparr=array(
               'name'=>$request->Menulinktype,
              );

              $res=Menulinktype::where('id',$request->hidden_id)->update($uparr);
              $edit_f ='';
              if($res){
                  return Redirect('menulinktype')->with('success','Updated successfully',['edit_f' => $edit_f]);
              }else{
                  return back()->withErrors('Not Updated ');
              }
     } catch (ModelNotFoundException $exception) {
         \LogActivity::addToLog($exception->getMessage(),'error');
         $data = \LogActivity::logLatestItem();
         return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
     }

 }

    /*Menue link type delete*/
 public function deleteMenulinktype($id)
 {
     $id= Crypt::decryptString($id);

         DB::beginTransaction();
         // $uparr=array(
         //     'delet_flag'=>1,
         //      );
         // $res=Menulinktype::where('id',$id)->update($uparr);
          $res= Menulinktype::findOrFail($id)->delete();
         $edit_f ='';
              if($res){
                 DB::commit();
                  return Redirect('menulinktype')->with('success','Deleted successfully',['edit_f' => $edit_f]);
              }else{
                 DB::rollback();
                  return back()->withErrors('Not deleted ');
              }
 }

     /*Menutype Status*/
 public function statusmenutype($id)
 {
     $id= Crypt::decryptString($id);

         DB::beginTransaction();
         $uparr=array(
             'status_id'=>0,
              );
         $res=Menulinktype::where('id',$id)->update($uparr);

         $edit_f ='';
              if($res){
                 DB::commit();
                  return Redirect('menulinktype')->with('success','Status updated successfully',['edit_f' => $edit_f]);
              }else{
                 DB::rollback();
                  return back()->withErrors('Not deleted ');
              }
 }
 /*publicrelationtype*/
 public function publicrelationtype()
 {
     $data = Publicrelationtype::with(['ptypesub' => function ($query) {
        $query->where('languageid', 1);
    }])->where('delet_flag', 0)->get();

     $breadcrumb = array(
         0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
         1 => array('title' => 'Widgetposition', 'message' => 'Widgetposition', 'status' => 1)
     );
     $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
     $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
     $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
     $language = Language::where('delet_flag',0)->orderBy('name')->get();

     return view('backend.masteradmin.Publicrelationtype.Publicrelationtype', compact('data', 'breadcrumbarr', 'navbar','language','user'));
 }


 /*Store widget positions*/
 public function storepublicrelationtype(Request $request)
 {

     $role_id = Auth::user()->id;
     try {
        $validator = Validator::make(
            $request->all(),
            [

                'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),

            ],
            [
                'title.required' => 'Title is required',
                'title.regex'    => 'The title format is invalid',
                'title.min'      => 'Title  minimum length is 3',
                'title.max'      => 'Title  maximum length is 150',

            ]
        );
        //

        if ($validator->fails()) {
            // dd($validator->errors());
            return back()->withInput()->withErrors($validator->errors());
        }
         $storeinfo = new Publicrelationtype([
             'userid' => Auth::user()->id,
             'delet_flag' => 0,
             'status_id' => 1,
         ]);
         // dd($storeinfo);
         $res = $storeinfo->save();
         $typeid = DB::getPdo()->lastInsertId();
         $leng = count($request->sel_lang);

         for ($i = 0; $i < $leng; $i++) {


             if ($typeid) {

                 $store_sub_info = new PublicrelationtypSub([
                     'languageid' => $request->sel_lang[$i],
                     'title' => $request->title[$i],
                     'publicrelationtypeid' => $typeid,
                 ]);
                 $storedetails_sub = $store_sub_info->save();
             }
             // dd($path);
         } //forloopend


         return redirect()->route('publicrelationtype')->with('success', 'created successfully');
     } catch (ModelNotFoundException $exception) {
         \LogActivity::addToLog($exception->getMessage(), 'error');
         $data = \LogActivity::logLatestItem();
         return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
     }
 }

 /*edit widget positions*/
 public function editwidget($id)
 {
     $id = Crypt::decryptString($id);
     $edit_f = 'E';
     $keydata = Publicrelationtype::where('id', $id)->first();
     $error = '';
     $data = Publicrelationtype::where('delet_flag', 0)->get();
     $breadcrumb = array(
         0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
         1 => array('title' => 'Widgetposition', 'message' => 'Widgetposition', 'status' => 1)
     );
     $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
     $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
     $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
     return view('backend.admin.Widgetpostion.widgetposition', compact('data', 'edit_f', 'error', 'keydata', 'breadcrumbarr', 'navbar', 'user'));
 }



 /*widget positions update*/

 public function updatepublicrelationtype(Request $request)
 {
     try {
         $request->validate([
             'widget' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
         ]);
         $request->input();

         $uparr = array(
             'name' => $request->widget,
         );

         $res = Publicrelationtype::where('id', $request->hidden_id)->update($uparr);
         $edit_f = '';
         if ($res) {
             return Redirect('widgetpositions')->with('success', 'Updated successfully', ['edit_f' => $edit_f]);
         } else {
             return back()->withErrors('Not Updated ');
         }
     } catch (ModelNotFoundException $exception) {
         \LogActivity::addToLog($exception->getMessage(), 'error');
         $data = \LogActivity::logLatestItem();
         return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
     }
 }

 /*widget positions delete*/

 public function deletewidget($id)
 {
     $id = Crypt::decryptString($id);

     DB::beginTransaction();
     // $uparr=array(
     //     'delet_flag'=>1,
     //      );
     // $res=Widgetposition::where('id',$id)->update($uparr);
     $res = Publicrelationtype::findOrFail($id)->delete();
     $edit_f = '';
     if ($res) {
         DB::commit();
         return Redirect('widgetpositions')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
     } else {
         DB::rollback();
         return back()->withErrors('Not deleted ');
     }
 }

 /*Widget postion Status*/
 public function statuswidgetpost($id)
 {
     $id = Crypt::decryptString($id);

     DB::beginTransaction();
     $uparr = array(
         'status_id' => 0,
     );
     $res = Publicrelationtype::where('id', $id)->update($uparr);

     $edit_f = '';
     if ($res_sub) {
         DB::commit();
         return Redirect('widgetpositions')->with('success', 'Status updated successfully', ['edit_f' => $edit_f]);
     } else {
         DB::rollback();
         return back()->withErrors('Not deleted ');
     }
 }

 /*widget link*/

  /*Link type type*/
  public function linktype()
  {
          $datas = Linktype::with(['linktype_sub' => function ($query) {
           }])->get();
      $breadcrumb = array(
          0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
          1 => array('title' => 'Link type', 'message' => 'Link type', 'status' => 1)
      );
      $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
      $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
      $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
      return view('backend.masteradmin.linktype.linktypelist', compact('datas', 'breadcrumbarr', 'navbar', 'user'));
  }
  public function createlinktype()
  {
    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
        1 => array('title' => 'Link type', 'message' => 'Link type', 'status' => 1)
    );

      $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
      $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
      $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
      $usertype = usertype::get();

      $language = Language::where('delet_flag', 0)->orderBy('name')->get();

      return view('backend.masteradmin.linktype.createlinktype', compact('breadcrumbarr', 'navbar', 'user', 'usertype', 'language'));
  }
  public function storelinktype(Request $request)
   {
       // dd($request->all());

       $validator = Validator::make(
           $request->all(),
           [
               'sel_lang.*' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
               'title.*' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
           ],
           [
               'title.required' => 'Title is required',
               'title.min' => 'Title  minimum lenght is 2',
               'title.max' => 'Title  maximum lenght is 50',
               'title.regex' => 'Invalid characters not allowed for Title',

           ]
       );
       if ($validator->fails()) {
           // dd($validator->errors());
           return back()->withInput()->withErrors($validator->errors());
       }
       try {

           $request->input();
           $role_id = Auth::user()->id;

           $leng = count($request->sel_lang);

           $storeinfo = new Linktype([
               'userid' => Auth::user()->id,
               'status_id' => 1,
               'delet_flag' => 0,
           ]);

           $res = $storeinfo->save();
           $linktypeid = DB::getPdo()->lastInsertId();

           for ($i = 0; $i < $leng; $i++) {


               if ($linktypeid) {

                   $store_sub_info = new Linktypesub([
                       'languageid' => $request->sel_lang[$i],
                       'title' => $request->title[$i],
                       'linktypeid' => $linktypeid,
                   ]);
                   $storedetails_sub = $store_sub_info->save();
               }
               // dd($path);
           } //forloopend

           return redirect()->route('masteradmin.linktype')->with('success', 'Created successfully');
       } catch (ModelNotFoundException $exception) {
           \LogActivity::addToLog($exception->getMessage(), 'error');
           $data = \LogActivity::logLatestItem();
           return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
       }
   }
   public function editlinktype($id)
   {

       $id = Crypt::decryptString($id);

       $edit_f = 'E';

       $keydata = Linktype::with(['linktype_sub' => function ($query) {
    }])->where('id', $id)->first();
       $error = '';


       $language = Language::orderBy('name')->get();

       $breadcrumb = array(
           0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masterhome'),
           1 => array('title' => 'Tender category', 'message' => 'Tender category', 'status' => 0, 'link' => '/masteradmin/linktype'),
           2 => array('title' => 'Edit Tender category', 'message' => 'Edit Tender category', 'status' => 1)
       );
       $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
       $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
       $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

       return view('backend.masteradmin.linktype.createlinktype', compact('breadcrumbarr', 'navbar', 'user', 'language', 'edit_f', 'keydata'));
   }
   public function updatelinktype(Request $request)
   {
       // dd($request->all());

       $validator = Validator::make(
           $request->all(),
           [
               'sel_lang.*' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
               'title.*' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
           ],
           [
               'title.required' => 'Title is required',
               'title.min' => 'Title  minimum lenght is 2',
               'title.max' => 'Title  maximum lenght is 50',
               'title.regex' => 'Invalid characters not allowed for Title',

           ]
       );
       if ($validator->fails()) {
           // dd($validator->errors());
           return back()->withInput()->withErrors($validator->errors());
       }
       try {

           $request->input();
           $role_id = Auth::user()->id;

           $leng = count($request->sel_lang);
           // dd($leng);

           $storeinfo = array(
               'userid' => Auth::user()->id,
           );

           $res = Linktype::where('id', $request->hidden_id)->update($storeinfo);
           $linktypeid = $request->hidden_id;

           for ($i = 0; $i < $leng; $i++) {


               if ($linktypeid) {

                   $store_sub_info = array(
                       'languageid' => $request->sel_lang[$i],
                       'title' => $request->title[$i],
                       'linktypeid' => $linktypeid,
                   );
                   $storedetails_sub = Linktypesub::where('linktypeid', $request->hidden_id)->where('languageid', $request->sel_lang[$i])->update($store_sub_info);
               }
               // dd($path);
           } //forloopend

           return redirect()->route('mediaadmin.linktype')->with('success', 'Updated successfully');
       } catch (ModelNotFoundException $exception) {
           \LogActivity::addToLog($exception->getMessage(), 'error');
           $data = \LogActivity::logLatestItem();
           return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
       }
   }


//    public function deletelinktype($id)
//    {
//        $id = Crypt::decryptString($id);
//        // dd($id);
//        DB::beginTransaction();

//        $res_sub = TenderTypeSub::where('tendertypeid', $id)->delete();

//        // if($res_sub)
//        // {
//        $res = TenderType::findOrFail($id)->delete();

//        // }
//        $edit_f = '';
//        if ($res_sub) {
//            DB::commit();
//            return Redirect('/mediaadmin/tendertypelist')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
//        } else {
//            DB::rollback();
//            return back()->withErrors('Not deleted ');
//        }
//    }
/*Tender type*/
public function tendertypelist()
{
    $datas = TenderType::where('delet_flag', 0)->get();

    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
        1 => array('title' => 'Tender type', 'message' => 'Tender type', 'status' => 1)
    );
    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
    $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
    return view('backend.masteradmin.TenderType.tendertypelist', compact('datas', 'breadcrumbarr', 'navbar', 'user'));
}
public function createtendertype()
{
    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
        1 => array('title' => 'Tender type', 'message' => 'Tender type', 'status' => 1)
    );

    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
    $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
    $usertype = usertype::get();

    $language = Language::where('delet_flag', 0)->orderBy('name')->get();

    return view('backend.masteradmin.TenderType.createtendertype', compact('breadcrumbarr', 'navbar', 'user', 'usertype', 'language'));
}
public function storetendertype(Request $request)
{
    // dd($request->all());

    $validator = Validator::make(
        $request->all(),
        [
            'sel_lang.*' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
            'title.*' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
        ],
        [
            'title.required' => 'Title is required',
            'title.min' => 'Title  minimum lenght is 2',
            'title.max' => 'Title  maximum lenght is 50',
            'title.regex' => 'Invalid characters not allowed for Title',

        ]
    );
    if ($validator->fails()) {
        // dd($validator->errors());
        return back()->withInput()->withErrors($validator->errors());
    }
    try {

        $request->input();
        $role_id = Auth::user()->id;

        $leng = count($request->sel_lang);
        // dd($leng);

        $storeinfo = new TenderType([
            'user_id' => Auth::user()->id,
            'status_id' => 1,
        ]);

        $res = $storeinfo->save();
        $tendertypeid = DB::getPdo()->lastInsertId();

        for ($i = 0; $i < $leng; $i++) {


            if ($tendertypeid) {

                $store_sub_info = new TenderTypeSub([
                    'languageid' => $request->sel_lang[$i],
                    'title' => $request->title[$i],
                    'tendertypeid' => $tendertypeid,
                ]);
                $storedetails_sub = $store_sub_info->save();
            }
            // dd($path);
        } //forloopend

        return redirect()->route('masteradmin.tendertype')->with('success', 'Created successfully');
    } catch (ModelNotFoundException $exception) {
        \LogActivity::addToLog($exception->getMessage(), 'error');
        $data = \LogActivity::logLatestItem();
        return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
    }
}
public function edittendertype($id)
{

    $id = Crypt::decryptString($id);

    $edit_f = 'E';

    $keydata = TenderType::with(['tender_type_sub' => function ($query) {
    }])->where('id', $id)->first();

    $error = '';


    $language = Language::orderBy('name')->get();

    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
        1 => array('title' => 'Tender category', 'message' => 'Tender category', 'status' => 0, 'link' => '/admin/tendercategory'),
        2 => array('title' => 'Edit Tender category', 'message' => 'Edit Tender category', 'status' => 1)
    );
    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
    $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

    return view('backend.masteradmin.TenderType.createtendertype', compact('breadcrumbarr', 'navbar', 'user', 'language', 'edit_f', 'keydata'));
}
public function updatetendertype(Request $request)
{
    // dd($request->all());

    $validator = Validator::make(
        $request->all(),
        [
            'sel_lang.*' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
            'title.*' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
        ],
        [
            'title.required' => 'Title is required',
            'title.min' => 'Title  minimum lenght is 2',
            'title.max' => 'Title  maximum lenght is 50',
            'title.regex' => 'Invalid characters not allowed for Title',

        ]
    );
    if ($validator->fails()) {
        // dd($validator->errors());
        return back()->withInput()->withErrors($validator->errors());
    }
    try {

        $request->input();
        $role_id = Auth::user()->id;

        $leng = count($request->sel_lang);
        // dd($leng);

        $storeinfo = array(
            'user_id' => Auth::user()->id,
        );

        $res = TenderType::where('id', $request->hidden_id)->update($storeinfo);
        $tendertypeid = $request->hidden_id;

        for ($i = 0; $i < $leng; $i++) {


            if ($tendertypeid) {

                $store_sub_info = array(
                    'languageid' => $request->sel_lang[$i],
                    'title' => $request->title[$i],
                    'tendertypeid' => $tendertypeid,
                );
                $storedetails_sub = TenderTypeSub::where('tendertypeid', $request->hidden_id)->where('languageid', $request->sel_lang[$i])->update($store_sub_info);
            }
            // dd($path);
        } //forloopend

        return redirect()->route('masteradmin.tendertypelist')->with('success', 'Updated successfully');
    } catch (ModelNotFoundException $exception) {
        \LogActivity::addToLog($exception->getMessage(), 'error');
        $data = \LogActivity::logLatestItem();
        return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
    }
}


public function deletetendertype($id)
{
    $id = Crypt::decryptString($id);
    // dd($id);
    DB::beginTransaction();

    $res_sub = TenderTypeSub::where('tendertypeid', $id)->delete();

    // if($res_sub)
    // {
    $res = TenderType::findOrFail($id)->delete();

    // }
    $edit_f = '';
    if ($res_sub) {
        DB::commit();
        return Redirect('/masteradmin/tendertypelist')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
    } else {
        DB::rollback();
        return back()->withErrors('Not deleted ');
    }
}
/*Tender type*/
}
