<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Agent\Agent;

use App\Models\LogActivity;
use App\Models\usertype;
use App\Models\User;
use App\Models\Component;
use App\Models\Componentpermission;
use App\Models\Language;
use App\Models\Menulinktype;
use App\Models\Mainmenu;
use App\Models\Submenu;
use App\Models\Submenusub;
use App\Models\Stationtype;
use App\Models\Widgetposition;
use App\Models\Widgetlink;
use App\Models\Widgetlink_sub;
use App\Models\Banner_sub;
use App\Models\Gallerytype;
use App\Models\Logotype;
use App\Models\Logo;
use App\Models\Logo_sub;
use App\Models\Contactus;
use App\Models\Footermenu;
use App\Models\Footermenusub;
use App\Models\Designation;
use App\Models\Designationsub;
use App\Models\Ordertype;
use App\Models\Ordertypesub;
use App\Models\Tariff;
use App\Models\Purpose;
use App\Models\Billingcycle;
use App\Models\Phase;
use App\Models\Pricingtype; 
use App\Models\Downloadtype;
use App\Models\Downloadtypesub;
use App\Models\Articletype;
use App\Models\Articletypesub;
use App\Models\Linktype;
use App\Models\Linktypesub;
use App\Models\Mainmenusub;
use App\Models\District;
use App\Models\Districtsub;
use App\Models\Sbutype;
use App\Models\Keywordtag;
use App\Models\Keywordtagsub;
use App\Models\Whatsnew;
use App\Models\Article;
use App\Models\Articlesub;
use App\Models\Feedback;
use App\Models\subsubmenu;
use App\Models\subsubmenusub;
use App\Models\sbutypesub;

use \Crypt;
use DB;
use Redirect;

class AdminController extends Controller
{

/*master dashboard*/
    public function masteradminhome()
    {
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.admin.masterhome',compact('navbar','user'));
        
    }

/*Log activites*/
    public function myTestAddToLog()
    {
        \LogActivity::addToLog('My Testing Add To Log.');
        dd('log insert successfully.');
    }

    public function logActivitylist()
    {
        // $logs = LogActivity::get();
        $logs = LogActivity::with(['users'=>function ($query){
            $query->select('id','name');
        }]) ->orderBy('id','DESC')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'LogActivity', 'message' => 'LogActivity', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('Master.Logoactivity.logActivity',compact('logs','breadcrumbarr','navbar'));
    }

/*Usertype view */
    public function usertype()
    {
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Usertype', 'message' => 'Usertype', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $data = usertype::where('delet_flag',0)->get();
        return view('backend.admin.Usertype.usertype',compact('data','breadcrumbarr','navbar','user'));
    }

/*Usertype add*/
    public function storeusertype(Request $request)
    {
        try{
            $validator = Validator::make(
            $request->all(),
            [
                'usertype'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
              
           ],[
                'usertype.required' => 'Title is required',
                'usertype.min' => 'Title  minimum lenght is 2',
                'usertype.max' => 'Title  maximum lenght is 50',
                'usertype.regex' => 'Invalid characters not allowed for Title',
            ]);
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }
           
               $storeinfo=new usertype([
                   'usertype'=>$request->usertype,
                   'delet_flag'=>0,
                   'status_id'=>1,
               ]);
      
               $storedetails=$storeinfo->save();
               return redirect()->route('usertype')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

/*user type edit*/
    public function editusertype($id)
    {
        $id= Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = usertype::where('id',$id)->first();
        $error = '';
        $data = usertype::where('delet_flag',0)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Usertype', 'message' => 'Usertype', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.admin.Usertype.usertype', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user'));
    }

/*user type  update*/
    public function updateusertype(Request $request)
    {
        try{
            $request->validate([
                'usertype'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
           ]);
               $request->input();
           
               $uparr=array(
                  'usertype'=>$request->usertype,
                 );

                 $res=usertype::where('id',$request->hidden_id)->update($uparr);
                 $edit_f ='U';
                 if($res){
                     return Redirect('usertype')->with('success','Updated successfully',['edit_f' => $edit_f]);
                 }else{
                     return back()->withErrors('Not Updated ');
                 }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
       
    }

/*user type delete*/
    public function deleteusertype($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            // $uparr=array(
            //     'delet_flag'=>1,
            //      );
             $res= Usertype::findOrFail($id)->delete();
            // $res=usertype::where('id',$id)->update($uparr);
            $edit_f ='';
                 if($res){
                    DB::commit();
                     return Redirect('usertype')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }

    /*Usertype Status*/
    public function statususertype($id)
    {
        // dd($id);
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            $keydata = Usertype::where('id',$id)->select('status_id')->first();
            // dd($keydata);
            if(($keydata->status_id==1))
            {
                $uparr=array(
                    'status_id'=>0,
                     );
            }else{

                $uparr=array(
                    'status_id'=>1,
                     );            }
            $res=Usertype::where('id',$id)->update($uparr);

            $edit_f ='';
                 if($res){
                    DB::commit();
                     return Redirect('usertype')->with('success','Status updated successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }

    
/*user*/
    public function user()
    {
        $data = User::with(['role_users'=> function(){

        }])->where('delet_flag',0)->get();
      
        $usertype=usertype::where('delet_flag',0)->get();
        $sbutype=Sbutype::where('delet_flag',0)->get();
           $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
                1 => array('title' => 'User', 'message' => 'User', 'status' => 1)
             );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.admin.Users.user',compact('data','usertype','navbar','user','sbutype'));
    }

/*storeuser*/
    public function storeuser(Request $request)
    {
  // dd($request->all()); 
        try{
            $request->validate([
            'usertype'  => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
            'username'  => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            'email'     => app('App\Http\Controllers\Commonfunctions')->emailId_check(),
            'password'  => 'required | min:8',
            'mobile'    => app('App\Http\Controllers\Commonfunctions')->mobileNum_check(),
            'fullname' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            ],[
                'fullname.required' => 'Name is required',
                'fullname.min' => 'Name  minimum length is 2',
                'fullname.max' => 'Name  maximum length is 50',
                'fullname.regex' => 'Invalid characters not allowed for name',

                'mobile.required' => 'Mobile number is required',
                'mobile.min' => 'Mobile number  minimum length is 2',
                'mobile.max' => 'Mobile number  maximum length is 10',
                'mobile.regex' => 'Invalid characters not allowed for Mobile number',

                'usertype'   => 'User type is required',
                'usertype.min' => 'usertype_id  minimum length is 2',
                'usertype.max' => 'usertype_id  maximum length is 50',
                'usertype.regex' => 'Invalid characters not allowed for usertype_id',

                'username.required' => 'Username is required',
                'username.min' => 'Username  minimum length is 2',
                'username.max' => 'Username  maximum length is 50',

            ]);

            $request->input();
              $userchecklisttitle =  User::where('email', $request->email)->exists() ? 1 : 0;;
              if ($userchecklisttitle   != 0) {
                $error = "This Title is already existing";
                 return redirect()->back()->withInput()->with('error','User email already used');
            }else{
                if($request->usertype==5){
                    $storeinfo=new user([
                   'name'=>$request->username,
                   'fullname'=>$request->fullname,
                   'mobile'=>$request->mobile,
                   'email'=>$request->email,
                   'role_id'=>$request->usertype,
                   'password' => Hash::make($request->password),
                   'status_id'=>1,
                   'sbutype'=>$request->sbutype,
               ]);
            
                }else{
                    $storeinfo=new user([
                   'name'=>$request->username,
                   'fullname'=>$request->fullname,
                   'mobile'=>$request->mobile,
                   'email'=>$request->email,
                   'role_id'=>$request->usertype,
                   'password' => Hash::make($request->password),
                   'status_id'=>1,
               ]);
            
                }

      
               $storedetails=$storeinfo->save();
             
               return redirect()->route('user')->with('success','created successfully');
            }



        }catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

/*user edit*/
    public function edituser($id)
    {

        $id= Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = User::where('id',$id)->first();
        $error = '';
        $usertype=usertype::where('delet_flag',0)->get();
        $data = User::where('delet_flag',0)->get();
        $sbutype=Sbutype::where('delet_flag',0)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'edituser', 'message' => 'edituser', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        // dd($keydata);
        return view('backend.admin.Users.user', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user','usertype','sbutype'));
    }

/*user type  update*/
    public function updateuser(Request $request)
    {

        try{
           $request->validate([
            'usertype'  => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
            'username'  => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            'email'     => app('App\Http\Controllers\Commonfunctions')->emailId_check(),
            'password'  => 'required | min:8',
            'mobile'    => app('App\Http\Controllers\Commonfunctions')->mobileNum_check(),
            'fullname' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            ],[
                'fullname.required' => 'Name is required',
                'fullname.min' => 'Name  minimum length is 2',
                'fullname.max' => 'Name  maximum length is 50',
                'fullname.regex' => 'Invalid characters not allowed for name',

                'mobile.required' => 'Mobile number is required',
                'mobile.min' => 'Mobile number  minimum length is 2',
                'mobile.max' => 'Mobile number  maximum length is 10',
                'mobile.regex' => 'Invalid characters not allowed for Mobile number',

                'usertype'   => 'User type is required',
                'usertype.min' => 'usertype_id  minimum length is 2',
                'usertype.max' => 'usertype_id  maximum length is 50',
                'usertype.regex' => 'Invalid characters not allowed for usertype_id',

                'username.required' => 'Username is required',
                'username.min' => 'Username  minimum length is 2',
                'username.max' => 'Username  maximum length is 50',

            ]);
               $request->input();
           if($request->usertype==5){

                $uparr=array(
                   'name'=>$request->username,
                   'fullname'=>$request->fullname,
                   'mobile'=>$request->mobile,
                   'email'=>$request->email,
                   'role_id'=>$request->usertype,
                    'sbutype'=>$request->sbutype,
                   'password' => Hash::make($request->password),
                 );
            
                }else{
                  $uparr=array(
                   'name'=>$request->username,
                   'fullname'=>$request->fullname,
                   'mobile'=>$request->mobile,
                   'email'=>$request->email,
                   'role_id'=>$request->usertype,
                   'password' => Hash::make($request->password),
                 );
               
                }
              

                 $res=User::where('id',$request->hidden_id)->update($uparr);
                 $edit_f ='U';
                 if($res){
                     return Redirect('user')->with('success','Updated successfully',['edit_f' => $edit_f]);
                 }else{
                     return back()->withErrors('Not Updated ');
                 }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
       
    }

/*User delete*/
    public function deleteuser($id)
    {

        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            // $uparr=array(
            //     'delet_flag'=>1,
            //      );
             
            // $res=User::where('id',$id)->update($uparr);
            $res= User::findOrFail($id)->delete();
            $edit_f ='';
                 if($res){
                    DB::commit();
                     return Redirect('user')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }

    /*User Status*/
    public function statususer($id)
    {
        
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            $keydata = User::where('id',$id)->select('status_id')->first();
            if(($keydata->status_id==1))
            {
                $uparr=array(
                    'status_id'=>0,
                     );
            }else{

                $uparr=array(
                    'status_id'=>1,
                     );            }
          
            $res=User::where('id',$id)->update($uparr);

            $edit_f ='';
                 if($res){
                    DB::commit();
                     return Redirect('user')->with('success','Status updated successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }

/*component*/
    public function component()
    {
        $data = Component::where('delet_flag',0)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Component', 'message' => 'Component', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
       
        return view('backend.admin.Component.component',compact('data','breadcrumbarr','navbar','user'));
    }

/*store component*/
    public function storecomponent(Request $request)
    {
         $role_id = Auth::user()->id;
        try{

            $validator = Validator::make(
            $request->all(),
            [
                'component'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            ],[
                'component.required' => 'Title is required',
                'component.min' => 'Title  minimum lenght is 2',
                'component.max' => 'Title  maximum lenght is 50',
                'component.regex' => 'Invalid characters not allowed for Title',

            ]);
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }
           
               $storeinfo=new Component([
                   'name'=>$request->component,
                   'delet_flag'=>0,
                   'status_id'=>1,
                   'userid'=>$role_id
               ]);
      
               $storedetails=$storeinfo->save();
               return redirect()->route('component')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

/*edit component*/
    public function editcomponent($id)
    {
        $id= Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = Component::where('id',$id)->first();
        $error = '';
        $data = Component::where('delet_flag',0)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Component', 'message' => 'Component', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
       

        return view('backend.admin.Component.component', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user'));
    }

/*component update*/
    public function updatecomponent(Request $request)
    {
        try{
            $validator = Validator::make(
            $request->all(),
            [
                'component'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            ],[
                'component.required' => 'Title is required',
                'component.min' => 'Title  minimum lenght is 2',
                'component.max' => 'Title  maximum lenght is 50',
                'component.regex' => 'Invalid characters not allowed for Title',

            ]);
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }
           
               $uparr=array(
                  'name'=>$request->component,
                 );

                 $res=Component::where('id',$request->hidden_id)->update($uparr);
                 $edit_f ='';
                 if($res){
                     return Redirect('component')->with('success','Updated successfully',['edit_f' => $edit_f]);
                 }else{
                     return back()->withErrors('Not Updated ');
                 }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
       
    }
/*Component delete*/
    public function deletecomponent($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            // $uparr=array(
            //     'delet_flag'=>1,
            //      );
            // $res=Component::where('id',$id)->update($uparr);
             $res= Component::findOrFail($id)->delete();
            $edit_f ='';
                 if($res){
                    DB::commit();
                     return Redirect('component')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }

        /*Component Status*/
    public function statuscomponent($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            $uparr=array(
                'status_id'=>0,
                 );
            $res=Component::where('id',$id)->update($uparr);

            $edit_f ='';
                 if($res){
                    DB::commit();
                     return Redirect('component')->with('success','Status updated successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }

/*component permissions*/
    public function componentpermissions()
    {
        // $data = Componentpermission::where('delet_flag',0)->get();
        $data=Componentpermission::with(['component' => function($query){
            $query->select('id','name');
        }])->with(['usertype' => function($query1){
            $query1->select('id','usertype');
        }])->where('delet_flag',0)->get();


        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Component permissions', 'message' => 'Component permissions', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        $component=Component::where('delet_flag',0)->get();

        $usertype=usertype::get();

        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.admin.Componentpermission.componentpermission',compact('data','breadcrumbarr','component','usertype','navbar','user'));
    }

/*store componentpermission*/
    public function storecomponentpermi(Request $request)
    {

        try{
            $validator = Validator::make(
            $request->all(),
            [
                'component' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'usertype' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'path' => app('App\Http\Controllers\Commonfunctions')->getPath(),
            ],[
                'component.required' => 'Title is required',
                'component.min' => 'Title  minimum lenght is 2',
                'component.max' => 'Title  maximum lenght is 50',
                'component.regex' => 'Invalid characters not allowed for Title',

                'usertype.required'   => 'User type is required',
                'usertype.regex'    => 'The usertype_id format is invalid',
                'usertype.min'      => 'usertype_id  minimum length is 3',
                'usertype.max'      => 'usertype_id  maximum length is 100',

                'path.required' => 'Path is required',
                'path.regex'    => 'The path format is invalid',
                'path.min'      => 'Path  minimum length is 3',
                'path.max'      => 'Path  maximum length is 100',

            ]);
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }
           
            $request->validate([
                'component' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'usertype' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'path' => app('App\Http\Controllers\Commonfunctions')->getPath(),
           ]);
               $request->input();
           
               $storeinfo=new Componentpermission([
                   'componentid'=>$request->component,
                   'url'=>$request->path,
                   'delet_flag'=>0,
                   'status_id'=>1,
                   'role_id'=>$request->usertype
               ]);
      
               $storedetails=$storeinfo->save();
               return redirect()->route('componentpermi')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

    /*edit componentpermission*/
    public function editcomponentper($id)
    {
        $id= Crypt::decryptString($id);
        $edit_f = 'E';
        // $keydata = Componentpermission::where('id',$id)->first();
        $error = '';
        $data=Componentpermission::with(['component' => function($query){
            $query->select('id','name');
        }])->with(['usertype' => function($query1){
            $query1->select('id','usertype');
        }])->where('delet_flag',0)->get();

        $keydata=Componentpermission::with(['component' => function($query){
            $query->select('id','name');
        }])->with(['usertype' => function($query1){
            $query1->select('id','usertype');
        }])->where('id',$id)->where('delet_flag',0)->first();

        $component=Component::where('delet_flag',0)->get();

        $usertype=usertype::get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Component', 'message' => 'Component', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.admin.Componentpermission.componentpermission', compact('data','edit_f', 'error','keydata','breadcrumbarr','component','usertype','user','navbar'));
    }

      /*update componentperm */
    public function updatecomponentperm(Request $request)
    {
        try{
            $validator = Validator::make(
            $request->all(),
            [
                'component' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'usertype' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'path' => app('App\Http\Controllers\Commonfunctions')->getPath(),
            ],[
                'component.required' => 'Title is required',
                'component.min' => 'Title  minimum lenght is 2',
                'component.max' => 'Title  maximum lenght is 50',
                'component.regex' => 'Invalid characters not allowed for Title',

                'usertype.required'   => 'User type is required',
                'usertype.regex'    => 'The usertype_id format is invalid',
                'usertype.min'      => 'usertype_id  minimum length is 3',
                'usertype.max'      => 'usertype_id  maximum length is 100',

                'path.required' => 'Path is required',
                'path.regex'    => 'The path format is invalid',
                'path.min'      => 'Path  minimum length is 3',
                'path.max'      => 'Path  maximum length is 100',

            ]);
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }
           
           
               $uparr=array(
                   'componentid'=>$request->component,
                   'url'=>$request->path,
                   'role_id'=>$request->usertype
                 );

                 $res=Componentpermission::where('id',$request->hidden_id)->update($uparr);
                 $edit_f ='';
                 if($res){
                     return Redirect('componentpermi')->with('success','Updated successfully',['edit_f' => $edit_f]);
                 }else{
                     return back()->withErrors('Not Updated ');
                 }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
       
    }

         /*delete componentpermn */
    public function deletecomponentper($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            // $uparr=array(
            //     'delet_flag'=>1,
            //      );
            // $res=Componentpermission::where('id',$id)->update($uparr);

            $res= Componentpermission::findOrFail($id)->delete();
            $edit_f ='';
                 if($res){
                    DB::commit();
                     return Redirect('componentpermi')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }

        /*Component permissions Status*/
    public function statuscomperm($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            $keydata = Componentpermission::where('id',$id)->select('status_id')->first();
            // dd($keydata);
            if(($keydata->status_id==1))
            {
                $uparr=array(
                    'status_id'=>0,
                     );
            }else{

                $uparr=array(
                    'status_id'=>1,
                     );    
                    }
            $edit_f ='';
            $res=Componentpermission::where('id',$id)->update($uparr);
                 if($res){
                    DB::commit();
                     return Redirect('componentpermi')->with('success','Status updated successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }

   
     /*language*/
    public function language()
    {
        $data = Language::where('delet_flag',0)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Language', 'message' => 'Language', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.admin.Language.language',compact('data','breadcrumbarr','navbar','user'));
    }

    /*Store language*/
    public function storelanguage(Request $request)
    {
        $role_id = Auth::user()->id;
        try{


            $validator = Validator::make(
                $request->all(),
                [
                     'language'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                ],
                [
                    'language.required' => 'Path is required',
                    'language.regex'    => 'The path format is invalid',
                    'language.min'      => 'Path  minimum length is 3',
                    'language.max'      => 'Path  maximum length is 100',

                ]
            );
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->errors());
        }

           
               $storeinfo=new Language([
                   'name'=>$request->language,
                   'delet_flag'=>0,
                   'status_id'=>1,
                   'userid'=>$role_id
               ]);
      
               $storedetails=$storeinfo->save();
               return redirect()->route('language')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

    /*edit language*/
    public function editlanguage($id)
    {
        $id= Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = Language::where('id',$id)->first();
        $error = '';
        $data = Language::where('delet_flag',0)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Language', 'message' => 'Language', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.admin.Language.language', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user'));
    }

     /*language update*/

    public function updatelanguage(Request $request)
    {
        try{

            $validator = Validator::make(
                $request->all(),
                [
                     'language'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                ],
                [
                    'language.required' => 'Path is required',
                    'language.regex'    => 'The path format is invalid',
                    'language.min'      => 'Path  minimum length is 3',
                    'language.max'      => 'Path  maximum length is 100',

                ]
            );
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->errors());
        }

           
               $uparr=array(
                  'name'=>$request->language,
                 );

                 $res=Language::where('id',$request->hidden_id)->update($uparr);
                 $edit_f ='';
                 if($res){
                     return Redirect('language')->with('success','Updated successfully',['edit_f' => $edit_f]);
                 }else{
                     return back()->withErrors('Not Updated ');
                 }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
       
    }

      /*language delete*/

    public function deletelanguage($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            // $uparr=array(
            //     'delet_flag'=>1,
            //      );
            // $res=Language::where('id',$id)->update($uparr);
            $res= Language::findOrFail($id)->delete();
            $edit_f ='';
                 if($res){

                    DB::commit();
                     return Redirect('language')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }

        /*LAng Status*/
    public function statuslanguage($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            $uparr=array(
                'status_id'=>0,
                 );
            $res=Language::where('id',$id)->update($uparr);
        
            $edit_f ='';
                 if($res){
                    DB::commit();
                     return Redirect('language')->with('success','Status updated successfully',['edit_f' => $edit_f]);
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


    /*mainmenu*/
    public function mainmenu()
    {

        $user=Auth::user()->id;
        // dd($user);

        if(Auth::user()->role_id==1){//admin

            $data = Mainmenu::with(['lang_sel' => function($query){
                $query->where('delet_flag',0);
            }])->with(['menu_link_type' => function($query1){
                $query1->where('delet_flag',0);
            }])->with(['mainmenu_sub' => function($query2){
                $query2->where('delet_flag',0);
            }])->with(['sbu_type_user' => function($query3){
                $query3->where('delet_flag',0);
            }])->where('delet_flag',0)->orderBy('orderno','asc')->get();

            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
                1 => array('title' => 'Mainmenu', 'message' => 'Mainmenu', 'status' => 1)
             );
        }else if(Auth::user()->role_id==5){//sbu

            $data = Mainmenu::with(['lang_sel' => function($query){
                $query->where('delet_flag',0);
            }])->with(['menu_link_type' => function($query1){
                $query1->where('delet_flag',0);
            }])->with(['mainmenu_sub' => function($query2){
                $query2->where('delet_flag',0);
            }])->with(['sbu_type_user' => function($query3){
                $query3->where('delet_flag',0);
            }])->with(['article_type' => function($query4){
                $query3->where('delet_flag',0);
            }])->where('delet_flag',0)->where('sbu_type',$user)->orderBy('orderno','asc')->get();

            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
                1 => array('title' => 'Main menu', 'message' => 'Main menu', 'status' => 1)
            );
        }
        
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $orderno = Mainmenu::max('orderno');

        $orderno_val ='';
        if($orderno == NULL)
        {
          
           $orderno_val =1;
        }else{
           $orderno_val =$orderno+1;
        }
        return view('backend.admin.Mainmenu.mainmenu',compact('data','breadcrumbarr','navbar','user','orderno_val'));
    }
/*Mainmenu create*/
    public function createmainmenu(Request $request)
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();
        // $user_s = User::where('delet_flag',0)->whereIn('role_id',[5])->where('status_id',1)->get();
        $user_s = Sbutype::where('delet_flag',0)->where('status_id',1)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Mainmenu', 'message' => 'Mainmenu', 'status' => 0, 'link' => '/mainmenu'),
            2 => array('title' => 'Create Mainmenu', 'message' => 'Create Mainmenu', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();


        // $article       = Article::with(['articleval_sub'=>function($query){
        //     $query->where('languageid',1);
        // }])->get();

        $arttype =   Articletype::with(['articletype_sub'=>function($query){
            $query->where('languageid', 1);
        }])->where('status_id',1)->where('delet_flag',0)->where('viewer_id',1)->get();

        $downloadtype = Downloadtype::with(['downloadtype_sub' =>function($query){
            $query->where('delet_flag',0);
            $query->where('languageid', 1);
        }])->where('status_id',1)->where('delet_flag',0)->where('viewer_id',1)->get();
// dd($arttype);
        return view('backend.admin.Mainmenu.createMainmenue',compact('breadcrumbarr','language','navbar','user','Menulinktype','Navid','user_s','arttype','downloadtype'));
    }

    /*store Mainmenu*/
    public function storeMainmenu(Request $request)
    {
     
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg250size(),
                    // 'icon_class'    => app('App\Http\Controllers\Commonfunctions')->getIconClass(),
                    'menulinktype'  => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    'sbu_user'      => 'sometimes',
                    'sbu_type'        => 'sometimes',
                ],
                [
                    'title.required' => 'Title is required',
                    'title.regex'    => 'The title format is invalid',
                    'title.min'      => 'Title  minimum length is 3',
                    'title.max'      => 'Title  maximum length is 150',
    
                    // 'icon_class.required' => 'Icon Class is required',
                    // 'icon_class.regex'    => 'The icon class format is invalid',
                    // 'icon_class.min'      => 'Icon Class  minimum length is 3',
                    // 'icon_class.max'      => 'Icon Class  maximum length is 30',
    
                    'menulinktype.required'  => 'menu type reuired',
                    'menulinktype.regex'    => 'menu type format is invalid',
                    'menulinktype.min'      => 'menu type  minimum length is 3',
                    'menulinktype.max'      => 'menu type  maximum length is 30',
                ]
            );
    
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator->errors());
            }
            $article_id=0;
            $download_type=0;
            $role_id = Auth::user()->id;
            $date = date('dmYH:i:s');

                    if($request->Anchor)
                    {
                        $menulinktype_data=$request->Anchor;
                    }
                    elseif($request->url)
                    {
                        $menulinktype_data=$request->url;
                    }
                    elseif($request->route)
                    {
                        $menulinktype_data=$request->route;
                    }
                    elseif($request->forms)
                    {
                        $menulinktype_data=$request->forms;
                    }  elseif($request->menulinktype==17)
                    {
                        $menulinktype_data='';
                    }elseif(($request->menulinktype==14) || ($request->menulinktype==20))
                    {
                        $menulinktype_data=$request->articletype;
                        $article_id=$request->articletype;
                        // $url_name='/planning/articledetail/';
                        // $menulinktype_data=$url_name.$request->articletype;
                    } elseif($request->menulinktype==21)
                    {
                        $menulinktype_data=$request->downloadtype;
                    }
                if($request->sbu_user==null)
                {
                    $sbu_user= 0;
                }else{
                    $sbu_user= $request->sbu_user;
                }
                   
// dd($menulinktype_data);
              if ($request->menulinktype != 13) //Anchor|| URL || Form || Article
                {


                            $storeinfo=new Mainmenu([
                                'users_id'=>$role_id,
                                'iconclass'=>$request->icon_class,
                                'menulinktype_id'=>$request->menulinktype,
                                'menulinktype_data'=>$menulinktype_data,
                                // 'viewer_id'=>$request->sbu_id,
                                'orderno'=>$request->ord_num,
                                // 'sbu_type'=>$sbu_user,
                                'articletype_id'=>$article_id,
                                'file'=>0,
                                'delet_flag'=>0,
                                'status_id'=>1,                
                            ]);
                 
                        $res = $storeinfo->save();
                        $mainmenuid = DB::getPdo()->lastInsertId();

                        $leng=count($request->sel_lang);

                     if($res)
                     {
                       for($i=0;$i<$leng;$i++){

                            $storeinfo_sub=new Mainmenusub([
                                'userid'=>$role_id,
                                'languageid'=>$request->sel_lang[$i],
                                'title' =>$request->title[$i],
                                'mainmenuid'=>$mainmenuid,
                                'delet_flag'=>0,
                                'status_id'=>1,
                            ]);
                            $res_su = $storeinfo_sub->save();
                                DB::commit();

                          }//endfor
                     }//ifres


   
                }//endif 13!=
                else if($request->menulinktype == 13)
                 {

                    if (isset($request->file_type)) {   
                        $imageName = 'mainmenu' . $date . '.' . $request->file_type->extension();
                        $path = $request->file('file_type')->storeAs('/uploads/Mainmenu', $imageName,'myfile');
                       
                            $storeinfo=new Mainmenu([
                                'users_id'=>$role_id,
                                'iconclass'=>$request->icon_class,
                                'menulinktype_id'=>$request->menulinktype,
                                'menulinktype_data'=>$imageName,
                                'orderno'=>$request->ord_num,
                                // 'viewer_id'=>$request->sbu_id,
                                // 'sbu_type'=>$sbu_user,
                                'file'=>$imageName,
                                'delet_flag'=>0,
                                'status_id'=>1,                
                            ]);
                     }//endisset
                    
                        $res = $storeinfo->save();
                        $mainmenuid = DB::getPdo()->lastInsertId();
                     $leng=count($request->sel_lang);

                    if($res)
                    {
                         for($i=0;$i<$leng;$i++){

                        $date = date('dmYH:i:s');
                       

                                 $storeinfo_sub=new Mainmenusub([
                                    'userid'=>$role_id,
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'mainmenuid'=>$mainmenuid,
                                    'delet_flag'=>0,
                                    'status_id'=>1,
                                ]);
                     

                                $res_sub = $storeinfo_sub->save();
                                DB::commit(); 
                            // }

                     }//enffor
            }

                 }   
           // }else{
           //    DB::rollback();
           //   return redirect()->back()->withInput()->with('error','Not valid');
           // }

               // $storedetails=$storeinfo->save();
               if($res_sub)
               {
                return redirect()->route('mainmenu')->with('success','created successfully');
               }else{
                DB::rollback();
               }

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

    /*edit mainmenu*/

    public function editmainmenu($id)
    {
        $id= Crypt::decryptString($id);
      
        $edit_f = 'E';
     
        $error = '';

        $data = Mainmenu::with(['lang_sel' => function($query){
            $query->where('delet_flag',0);
        }])->with(['menu_link_type' => function($query1){
            $query1->where('delet_flag',0);
        }])->with(['mainmenu_sub' => function($query2){
            $query2->where('delet_flag',0);
        }])->with(['sbu_type_user' => function($query3){
            $query3->where('delet_flag',0);
        }])->with(['article_type' => function($query4){
            $query4->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

        $keydata = Mainmenu::with(['lang_sel' => function($query){
            $query->where('delet_flag',0);
        }])->with(['menu_link_type' => function($query1){
            $query1->where('delet_flag',0);
        }])->with(['mainmenu_sub' => function($query2){
            $query2->where('delet_flag',0);
        }])->with(['sbu_type_user' => function($query3){
            $query3->where('delet_flag',0);
        }])->with(['article_type' => function($query4){
            $query4->where('delet_flag',0);
        }])->where('id',$id)->where('delet_flag',0)->first();
        $downloadtype = Downloadtype::with(['downloadtype_sub' =>function($query){
            $query->where('delet_flag',0);
            $query->where('languageid', 1);
        }])->where('status_id',1)->where('delet_flag',0)->get();
        // dd($keydata);
        // $user_s = User::where('delet_flag',0)->whereIn('role_id',[5])->where('status_id',1)->get();
        $user_s = Sbutype::where('delet_flag',0)->where('status_id',1)->get();

        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Mainmenu', 'message' => 'Mainmenu', 'status' => 0, 'link' => '/mainmenu'),
            2 => array('title' => 'Edit Mainmenu', 'message' => 'Edit Mainmenu', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        // $article       = Article::with(['articleval_sub'=>function($query){
        //     $query->where('languageid',1);
        // }])->get();

        $arttype =   Articletype::with(['articletype_sub'=>function($query){
            $query->where('languageid', 1);
        }])->where('status_id',1)->where('delet_flag',0)->where('viewer_id',0)->get();


        return view('backend.admin.Mainmenu.createMainmenue', compact('data','edit_f', 'error','keydata','breadcrumbarr','language','Menulinktype','navbar','user','user_s','arttype','downloadtype'));
    }
/**articleload */
public function articleload(Request $request){

 
   
    // $article       = Article::with(['articleval_sub'=>function($query){

    // }])->where('sbutype_id',$request->sbu_user)->get();

  if(($request->sbu_user)==''){
    $arttype =   Articletype::with(['articletype_sub'=>function($query){
        $query->where('languageid', 1);
    }])->where('status_id',1)->where('delet_flag',0)->where('viewer_id','!=',2)->get();
  }else{
    $sbu_user=$request->sbu_user;

    $arttype =   Articletype::with(['articletype_sub'=>function($query){
        $query->where('languageid', 1);
    }])->where('status_id',1)->where('delet_flag',0)->where('viewer_id',2)->where('sbu_type',$sbu_user)->get();
  }


    // dd($arttype);
    return response()->json($arttype);

}

/**downloadload */
public function downloadtypeload(Request $request){


  if(($request->sbu_user)==''){
    $downloadtype = Downloadtype::with(['downloadtype_sub' =>function($query){
        $query->where('delet_flag',0);
        $query->where('languageid', 1);
    }])->where('status_id',1)->where('delet_flag',0)->where('viewer_id','!=',2)->orWhere('viewer_id',1)->orWhere('sbu_maindashboard',1)->groupBy('id')->get();
   
  }else{
    $sbu_user=$request->sbu_user;
    $downloadtype = Downloadtype::with(['downloadtype_sub' =>function($query){
        $query->where('delet_flag',0);
        $query->where('languageid', 1);
    }])->where('status_id',1)->where('delet_flag',0)->where('viewer_id',2)->where('sbu_type',$sbu_user)->get();
 
  }

    return response()->json($downloadtype);

}

    /*Mainmenu update*/

    public function updateMainmenu(Request $request)
    {
        // dd($request->all());
        try{
      
            $validator = Validator::make(
                $request->all(),
                [
                    'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg250size(),
                    // 'icon_class'    => app('App\Http\Controllers\Commonfunctions')->getIconClass(),
                    'menulinktype'  => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    'ord_num'       =>'required',
                ],
                [
                    'title.required' => 'Title is required',
                    'title.regex'    => 'The title format is invalid',
                    'title.min'      => 'Title  minimum length is 3',
                    'title.max'      => 'Title  maximum length is 150',
    
                    // 'icon_class.required' => 'Icon Class is required',
                    // 'icon_class.regex'    => 'The icon class format is invalid',
                    // 'icon_class.min'      => 'Icon Class  minimum length is 3',
                    // 'icon_class.max'      => 'Icon Class  maximum length is 30',
    
                    'menulinktype.required'  => 'menu type reuired',
                    'menulinktype.regex'    => 'menu type format is invalid',
                    'menulinktype.min'      => 'menu type  minimum length is 3',
                    'menulinktype.max'      => 'menu type  maximum length is 30',
                ]
            );
    
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator->errors());
            }
 

            $article_id=0;
            $role_id = Auth::user()->id;
            $date = date('dmYH:i:s');

                    if($request->Anchor)
                    {
                        $menulinktype_data=$request->Anchor;
                    }
                    elseif($request->url)
                    {
                        $menulinktype_data=$request->url;
                    }
                    elseif($request->route)
                    {
                        $menulinktype_data=$request->route;
                    }
                    elseif($request->forms)
                    {
                        $menulinktype_data=$request->forms;
                    }  elseif($request->menulinktype==17)
                    {
                        $menulinktype_data='';
                    }elseif(($request->menulinktype==14) || ($request->menulinktype==20))
                    {
                        // $url_name='/planning/articledetail/';
                        // $menulinktype_data=$url_name.$request->articletype;
                        $menulinktype_data=$request->articletype;
                        $article_id=$request->articletype;
                    }elseif($request->menulinktype==21)
                    {
                        $menulinktype_data=$request->downloadtype;
                    }
                if($request->sbu_user==null)
                {
                    $sbu_user= 0;
                }else{
                    $sbu_user= $request->sbu_user;
                }
                   
// dd($sbu_user);
              if ($request->menulinktype != 13) //Anchor|| URL || Form || Article
                {
 
                    $uparr=array(
                                'iconclass'=>$request->icon_class,
                                'menulinktype_id'=>$request->menulinktype,
                                'menulinktype_data'=>$menulinktype_data,
                               
                                'orderno'=>$request->ord_num,
                                
                                'articletype_id'=>$article_id,
                                'file'=>0,
                                  
                       );
      
                       $res=Mainmenu::where('id',$request->hidden_id)->update($uparr);

// dd($request->sel_lang);
                        $leng=count($request->sel_lang);

                     if($res)
                     {
                       for($i=0;$i<$leng;$i++){

                            $storeinfo_sub=array(
                                'userid'=>$role_id,
                                'languageid'=>$request->sel_lang[$i],
                                'title' =>$request->title[$i],
                                'mainmenuid'=>$request->hidden_id

                            );
                            // dd($storeinfo_sub);
                            $res=Mainmenusub::where('mainmenuid',$request->hidden_id)->where('languageid',$request->sel_lang[$i])->update($storeinfo_sub);
                                DB::commit();

                          }//endfor
                     }//ifres


   
                }//endif 13!=
            //     else if($request->menulinktype == 13)
            //      {

            //         if (isset($request->file_type)) {   
            //             $imageName = 'mainmenu' . $date . '.' . $request->file_type->extension();
            //             $path = $request->file('file_type')->storeAs('/uploads/Mainmenu', $imageName,'myfile');
                    
            //                 $storeinfo=new Mainmenu([
            //                     'users_id'=>$role_id,
            //                     'iconclass'=>$request->icon_class,
            //                     'menulinktype_id'=>$request->menulinktype,
            //                     'menulinktype_data'=>$imageName,
            //                     'viewer_id'=>$request->sbu_id,
            //                     'sbu_type'=>$sbu_user,
            //                     'file'=>0,
            //                     'delet_flag'=>0,
            //                     'status_id'=>1,                
            //                 ]);
            //          }//endisset
            //             $res = $storeinfo->save();
            //             $mainmenuid = DB::getPdo()->lastInsertId();
            //          $leng=count($request->language);
      
            //         if($res)
            //         {
            //              for($i=0;$i<$leng;$i++){

            //             $date = date('dmYH:i:s');
                       

            //                      $storeinfo_sub=new Mainmenusub([
            //                         'userid'=>$role_id,
            //                         'languageid'=>$request->sel_lang[$i],
            //                         'title' =>$request->title[$i],
            //                         'mainmenuid'=>$mainmenuid,
            //                         'delet_flag'=>0,
            //                         'status_id'=>1,
            //                     ]);
                     

            //                     $res_sub = $storeinfo_sub->save();
            //                     DB::commit(); DB::rollback();
            //                 // }

            //          }//enffor
            // }

            //      }   
           // }else{
           //    DB::rollback();
           //   return redirect()->back()->withInput()->with('error','Not valid');
           // }

               // $storedetails=$storeinfo->save();
                 $edit_f ='';
                 if($res){
                     return Redirect('mainmenu')->with('success','Updated successfully',['edit_f' => $edit_f]);
                 }else{
                     return back()->withErrors('Not Updated ');
                 }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
       
    }

/*Mainmenu delete*/
    public function deletemainmenu($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            // $uparr=array(
            //     'delet_flag'=>1,
            //      );
            // $res=Mainmenu::where('id',$id)->update($uparr);
             $res_sub= Mainmenusub::where('mainmenuid',$id)->delete();
          
            if($res_sub)
            {
             $res= Mainmenu::findOrFail($id)->delete();
                // $res_sub=Mainmenusub::where('mainmenuid',$id)->update($uparr);
            }
            $edit_f ='';
                 if($res_sub){
                    DB::commit();
                     return Redirect('mainmenu')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }
    /*Mainmenu Status*/
    public function statusmainmenu($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
              $keydata = Mainmenu::where('id',$id)->select('status_id')->first();
        
            if(($keydata->status_id==1))
            {
                $uparr=array(
                    'status_id'=>0,
                     );
            }else{

                $uparr=array(
                    'status_id'=>1,
                     );    
            }
            $res=Mainmenu::where('id',$id)->update($uparr);
          
            $edit_f ='';
                 if($res){
                    DB::commit();
                     return Redirect('mainmenu')->with('success','Status updated successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not updated ');
                 }
    }

    public function OrderchangeMainmenu_form(Request $request)
    {
        try {
            $id= Crypt::decryptString($request->id);
            $res = Mainmenu::where('id', '=', $id)->update(['orderno' => $request->val]);
            // 
        } catch (\Exception $exception) {
            /*\LogActivity::addToLog($exception->getMessage());
            $data = \LogActivity::logLatestItem();
            $error = array('er' => 'Please contact admin; the error code is ERROR' . $data->id);
            return view('Siteadmin.dashboard', compact('error'));*/
        } catch (\Throwable $exception) {
            /*\LogActivity::addToLog($exception->getMessage());
            $data = \LogActivity::logLatestItem();
            $error = array('er' => 'Please contact admin; the error code is ERROR' . $data->id);
            return view('Siteadmin.dashboard', compact('error'));*/
        } catch (\Illuminate\Database\QueryException $exception) {

            /*\LogActivity::addToLog($exception->getMessage());
            $data = \LogActivity::logLatestItem();
            return back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);*/
        }
        if ($res) {
            $success = "Status Updated!";
            return response()->json(['html' => $success]);
        } else {
            $error = 'Not updated status';
            return response()->json(['html' => $error]);
        }
    }

    /*Submenu*/
    public function submenu()
    {

    
        $data = Submenu::with(['lang_sel' => function($query){
            $query->where('delet_flag',0);
        }])->with(['submenusub' =>function($query1){
            // $query1->where('delet_flag',0);
        }])->with(['menu_link_types' =>function($query2){
            $query2->where('delet_flag',0)->get();
        }])->with(['sbu_type_user' => function($query3){
            $query3->where('delet_flag',0);
        }])->with(['mainmenu_sub_selected' => function($query3){
            $query3->where('languageid',1);
        }])->where('delet_flag',0)->orderBy('orderno','asc')->get();
// dd($data[0]->mainmenu_sub_selected[0]->title);
        
        $lang = Language::where('delet_flag',0)->orderBy('name')->get();
        $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();
        // $Mainmenu=Mainmenu::where('delet_flag',0)->get();
        $Mainmenu = Mainmenu::with(['mainmenu_sub' => function($query){
            $query->where('languageid',1);
        }])->where('viewer_id',1)->where('delet_flag',0)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Submenu', 'message' => 'Submenu', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.admin.Submenu.submenu',compact('data','breadcrumbarr','lang','Menulinktype','Mainmenu','navbar','user'));
    }

    
    /*Submenu create*/
    public function createsubmenu()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();
        $mainmenu = Mainmenu::with(['mainmenu_sub' => function($query){
            $query->where('languageid',1);
        }])->where('viewer_id',1)->where('delet_flag',0)->get();
        $user_s = Sbutype::where('delet_flag',0)->where('status_id',1)->get();
// dd($mainmenu);
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Submenu', 'message' => 'Submenu', 'status' => 0, 'link' => '/submenu'),
            2 => array('title' => 'Create Submenu', 'message' => 'Create Submenu', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();

        $arttype =   Articletype::with(['articletype_sub'=>function($query){
            $query->where('languageid', 1);
        }])->where('status_id',1)->where('delet_flag',0)->get();


        return view('backend.admin.Submenu.createsubmenu',compact('breadcrumbarr','language','navbar','user','Menulinktype','mainmenu','Navid','user_s','arttype'));
    }
    
    /**=sbuwisemainmenu */
    public function sbuwisemainmenu(Request $request)
    {
        // dd($request->all());
        $mainmenu_sbu = Mainmenu::with(['mainmenu_sub' => function($query){
              $query->where('languageid',1);
        }])->where('sbu_type',$request->sbu_id)->where('delet_flag',0)->get();
// dd($mainmenu_sbu);

        return response()->json($mainmenu_sbu);
    }

    /*store submenu*/
    public function storesubmenu(Request $request)
    {
    
        $validator = Validator::make(
            $request->all(),
            [
                'icon_class'    => 'sometimes',
                'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'menulinktype'  => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'mainmenuid'    => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'file_type'     => app('App\Http\Controllers\Commonfunctions')->getFileval()
                
            ],
            [
                'title.required' => 'Title is required',
                'title.regex'    => 'The title format is invalid',
                'title.min'      => 'Title  minimum length is 3',
                'title.max'      => 'Title  maximum length is 150',  

                'file_type.mimes'   => 'Invalid image format',     

            ]
        );
        // 

        if ($validator->fails()) {
            // dd($validator->errors());
            return back()->withInput()->withErrors($validator->errors());
        }
       
        try{
               $request->input();
               $article_id=0;
            $role_id = Auth::user()->id;
             if($request->Anchor)
                    {
                        $menulinktype_data=$request->Anchor;
                    }
                    elseif($request->url)
                    {
                        $menulinktype_data=$request->url;
                    }
                    elseif($request->forms)
                    {
                        $menulinktype_data=$request->forms;
                    }  elseif($request->menulinktype==17)
                    {
                        $menulinktype_data='';
                        $article_id=0;
                    }elseif(($request->menulinktype==14) || ($request->menulinktype==20))
                    {
                        $menulinktype_data=$request->articletype;
                        $article_id=$request->articletype;
                        // $url_name='/planning/articledetail/';
                        // $menulinktype_data=$url_name.$request->articletype;
                    }elseif($request->menulinktype==13){

                                $date = date('dmYH:i:s');
                                $imageName = $request->title[0]. $date . '.' .$request->file_type->extension();
                                $filename=$imageName;
                                $path = $request->file('file_type')->storeAs('/uploads/Submenu/', $imageName, 'myfile');
                                $menulinktype_data=$filename;
                       
                    }elseif($request->menulinktype==21)
                    {
                        $menulinktype_data=$request->downloadtype;
                    }
 
                        if($request->sbu_user==null)
                        {
                            $sbu_user= 0;
                        }else{
                            $sbu_user= $request->sbu_user;
                        }
                        if($request->icon_class==null)
                        {
                            $icon_class= 0;
                        }else{
                            $icon_class= $request->icon_class;
                        }
                            
    
             if ($request->menulinktype != 13) //Anchor|| URL || Form || Article
                {
                        $leng=count($request->sel_lang);

                        $storeinfo=new Submenu([
                                'users_id'=>$role_id,
                                'mainmenu_id'=>$request->mainmenuid,
                                'iconclass'=>$icon_class,
                                'orderno'=>$request->ord_num,
                                'menulinktype_id'=>$request->menulinktype,
                                'menulinktype_data'=>$menulinktype_data,
                                'articletype_id'=>$article_id,
                                'delet_flag'=>0,
                                'status_id'=>1,                
                            ]);
                 // dd($storeinfo);
                        $res = $storeinfo->save();
                        $Submenusub = DB::getPdo()->lastInsertId();

                        $leng=count($request->sel_lang);

                     if($res)
                     {
                       for($i=0;$i<$leng;$i++){

                            $storeinfo_sub=new Submenusub([
                                'userid'=>$role_id,
                                'languageid'=>$request->sel_lang[$i],
                                'title' =>$request->title[$i],
                                'submenuid'=>$Submenusub,
                       
                            ]);
                            // dd($storeinfo_sub);
                            $res_su = $storeinfo_sub->save();
                                DB::commit();

                          }//endfor
                     }//ifres

   
                }//endif 13!=
                else if($request->menulinktype == 13)
                 {
                    // dd(true);
                    $leng=count($request->sel_lang);

                    $storeinfo=new Submenu([
                            'users_id'=>$role_id,
                            'mainmenu_id'=>$request->mainmenuid,
                            'iconclass'=>$icon_class,
                            'orderno'=>$request->ord_num,
                            'menulinktype_id'=>$request->menulinktype,
                            'menulinktype_data'=>$menulinktype_data,
                            'articletype_id'=>$article_id,
                            'delet_flag'=>0,
                            'status_id'=>1,                
                        ]);
             // dd($storeinfo);
                    $res = $storeinfo->save();
                    $Submenusub = DB::getPdo()->lastInsertId();
// dd($Submenusub);
                    $leng=count($request->sel_lang);

                 if($res)
                 {
                   for($i=0;$i<$leng;$i++){

                        $storeinfo_sub=new Submenusub([
                            'userid'=>$role_id,
                            'languageid'=>$request->sel_lang[$i],
                            'title' =>$request->title[$i],
                            'submenuid'=>$Submenusub,
                   
                        ]);
                        // dd($storeinfo_sub);
                        $res_su = $storeinfo_sub->save();
                            DB::commit();

                      }//endfor
                 }//ifres


                 }   
                
      
               // $storedetails=$storeinfo->save();
               return redirect()->route('submenu')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }



    /*edit mainmenu*/

    public function editsubmenu($id)
    {
      
        $id= Crypt::decryptString($id);
        // dd($id);
        $edit_f = 'E';
     
        $error = '';

        $data = Submenu::with(['lang_sel' => function($query){
            $query->where('delet_flag',0);
        }])->with(['submenusub' =>function($query1){
            // $query1->where('delet_flag',0);
        }])->with(['menu_link_types' =>function($query2){
            $query2->where('delet_flag',0)->get();
        }])->with(['sbu_type_user' => function($query3){
            $query3->where('delet_flag',0);
        }])->with(['mainmenu_sub_selected' => function($query3){
            $query3->where('languageid',1);
        }])->where('delet_flag',0)->get();

        $keydata = Submenu::with(['lang_sel' => function($query){
            $query->where('delet_flag',0);
        }])->with(['submenusub' =>function($query1){
            // $query1->where('delet_flag',0);
        }])->with(['menu_link_types' =>function($query2){
            $query2->where('delet_flag',0)->get();
        }])->with(['sbu_type_user' => function($query3){
            $query3->where('delet_flag',0);
        }])->with(['mainmenu_sub_selected' => function($query3){
            $query3->where('languageid',1);
        }])->where('id',$id)->where('delet_flag',0)->first();


        // dd($keydata);
        // $user_s = User::where('delet_flag',0)->whereIn('role_id',[5])->where('status_id',1)->get();
        $user_s = Sbutype::where('delet_flag',0)->where('status_id',1)->get();

        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();
        $mainmenu = Mainmenu::with(['mainmenu_sub' => function($query){
            $query->where('languageid',1);
        }])->where('viewer_id',1)->where('delet_flag',0)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Sub menu', 'message' => 'Sub menu', 'status' => 0, 'link' => '/submenu'),
            2 => array('title' => 'Edit Sub menu', 'message' => 'Edit Sub menu', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $arttype =   Articletype::with(['articletype_sub'=>function($query){
            $query->where('languageid', 1);
        }])->where('status_id',1)->where('delet_flag',0)->get();
        // dd($arttype);
        return view('backend.admin.Submenu.createsubmenu', compact('arttype','data','edit_f', 'error','keydata','breadcrumbarr','language','Menulinktype','navbar','user','user_s','mainmenu'));
    }


    /*Submenu update*/

    public function updatesubmenu(Request $request)
    {
        // dd($request->all());
        try{
      
            $validator = Validator::make(
                $request->all(),
                [
                    'icon_class'    => 'sometimes',
                    'menulinktype' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    'mainmenuid' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    'file_type'     => app('App\Http\Controllers\Commonfunctions')->getFileval(),
                    'sbu_user'      => 'sometimes',
                    'sbu_type'        => 'sometimes',
                ],
                [
                    'title.required' => 'Title is required',
                    'title.regex'    => 'The title format is invalid',
                    'title.min'      => 'Title  minimum length is 3',
                    'title.max'      => 'Title  maximum length is 150',
    
                    'icon_class.required' => 'Icon Class is required',
                    'icon_class.regex'    => 'The icon class format is invalid',
                    'icon_class.min'      => 'Icon Class  minimum length is 3',
                    'icon_class.max'      => 'Icon Class  maximum length is 30',
    
                    'menulinktype.required'  => 'menu type reuired',
                    'menulinktype.regex'    => 'menu type format is invalid',
                    'menulinktype.min'      => 'menu type  minimum length is 3',
                    'menulinktype.max'      => 'menu type  maximum length is 30',
                ]
            );
    
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator->errors());
            }
            // dd($request->all());

            $role_id = Auth::user()->id;
            $date = date('dmYH:i:s');
            $article_id=0;
                    if($request->Anchor)
                    {
                        $menulinktype_data=$request->Anchor;
                    }
                    elseif($request->url)
                    {
                        $menulinktype_data=$request->url;
                    }
                    elseif($request->route)
                    {
                        $menulinktype_data=$request->route;
                    }
                    elseif($request->forms)
                    {
                        $menulinktype_data=$request->forms;
                    }  elseif($request->menulinktype==17)
                    {
                        $menulinktype_data='';
                       
                    }elseif(($request->menulinktype==14) || ($request->menulinktype==20))
                    {
                        $menulinktype_data=$request->articletype;
                        $article_id=$request->articletype;
                        // $url_name='/planning/articledetail/';
                        // $menulinktype_data=$url_name.$request->articletype;
                    }elseif($request->menulinktype==21)
                    {
                        $menulinktype_data=$request->downloadtype;
                    }
                if($request->sbu_user==null)
                {
                    $sbu_user= 0;
                }else{
                    $sbu_user= $request->sbu_user;
                }
                if($request->icon_class==null)
                {
                    $icon_class= 0;
                }else{
                    $icon_class= $request->icon_class;
                }
                       
// dd($sbu_user);
              if ($request->menulinktype != 13) //Anchor|| URL || Form || Article
                {
 
                    $uparr=array(
                               'users_id'=>$role_id,
                                'mainmenu_id'=>$request->mainmenuid,
                                'iconclass'=>$icon_class,
                                'orderno'=>$request->ord_num,
                                'menulinktype_id'=>$request->menulinktype,
                                'menulinktype_data'=>$menulinktype_data,
                                'viewer_id'=>$request->sbu_id,
                                'sbu_type'=>$sbu_user,   
                                'articletype_id'=>$article_id,
                       );
                     
      
                       $res=Submenu::where('id',$request->hidden_id)->update($uparr);
                    //    dd($res);
// dd($request->sel_lang);
                        $leng=count($request->sel_lang);
                        $role_id = Auth::user()->id;
                     if($res)
                     {
                       for($i=0;$i<$leng;$i++){

                            $storeinfo_sub=array(
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'submenuid'=>$request->hidden_id
                                    
                            );
                            // dd($storeinfo_sub);
                            $res=Submenusub::where('submenuid',$request->hidden_id)->where('languageid',$request->sel_lang[$i])->update($storeinfo_sub);
                                DB::commit();

                          }//endfor
                     }//ifres


   
                }else{
                    if(isset($request->file_type)){
                        $date = date('dmYH:i:s');
                        $imageName = $request->title[0]. $date . '.' .$request->file_type->extension();
                        $filename=$imageName;
                        $path = $request->file('file_type')->storeAs('/uploads/Submenu/', $imageName, 'myfile');
                        $menulinktype_data=$filename;
                        $uparr=array(
                            'users_id'=>$role_id,
                             'mainmenu_id'=>$request->mainmenuid,
                             'iconclass'=>$icon_class,
                             'orderno'=>$request->ord_num,
                             'menulinktype_id'=>$request->menulinktype,
                             'menulinktype_data'=>$menulinktype_data,
                             'viewer_id'=>$request->sbu_id,
                             'sbu_type'=>$sbu_user,   
                    );
                    }else{
                        $uparr=array(
                            'users_id'=>$role_id,
                             'mainmenu_id'=>$request->mainmenuid,
                             'iconclass'=>$icon_class,
                             'orderno'=>$request->ord_num,
                             'menulinktype_id'=>$request->menulinktype,
                             'viewer_id'=>$request->sbu_id,
                             'sbu_type'=>$sbu_user,   
                    );
                    }
                   
              

                $res=Submenu::where('id',$request->hidden_id)->update($uparr);
             //    dd($res);
// dd($request->sel_lang);
                 $leng=count($request->sel_lang);
                 $role_id = Auth::user()->id;
              if($res)
              {
                for($i=0;$i<$leng;$i++){

                     $storeinfo_sub=array(
                             'languageid'=>$request->sel_lang[$i],
                             'title' =>$request->title[$i],
                             'submenuid'=>$request->hidden_id
                             
                     );
                     // dd($storeinfo_sub);
                     $res=Submenusub::where('submenuid',$request->hidden_id)->where('languageid',$request->sel_lang[$i])->update($storeinfo_sub);
                         DB::commit();

                   }//endfor
              }//ifres

                }
            //     else if($request->menulinktype == 13)
            //      {

            //         if (isset($request->file_type)) {   
            //             $imageName = 'mainmenu' . $date . '.' . $request->file_type->extension();
            //             $path = $request->file('file_type')->storeAs('/uploads/Mainmenu', $imageName,'myfile');
                    
            //                 $storeinfo=new Mainmenu([
            //                     'users_id'=>$role_id,
            //                     'iconclass'=>$request->icon_class,
            //                     'menulinktype_id'=>$request->menulinktype,
            //                     'menulinktype_data'=>$imageName,
            //                     'viewer_id'=>$request->sbu_id,
            //                     'sbu_type'=>$sbu_user,
            //                     'file'=>0,
            //                     'delet_flag'=>0,
            //                     'status_id'=>1,                
            //                 ]);
            //          }//endisset
            //             $res = $storeinfo->save();
            //             $mainmenuid = DB::getPdo()->lastInsertId();
            //          $leng=count($request->language);
      
            //         if($res)
            //         {
            //              for($i=0;$i<$leng;$i++){

            //             $date = date('dmYH:i:s');
                       

            //                      $storeinfo_sub=new Mainmenusub([
            //                         'userid'=>$role_id,
            //                         'languageid'=>$request->sel_lang[$i],
            //                         'title' =>$request->title[$i],
            //                         'mainmenuid'=>$mainmenuid,
            //                         'delet_flag'=>0,
            //                         'status_id'=>1,
            //                     ]);
                     

            //                     $res_sub = $storeinfo_sub->save();
            //                     DB::commit(); DB::rollback();
            //                 // }

            //          }//enffor
            // }

            //      }   
           // }else{
           //    DB::rollback();
           //   return redirect()->back()->withInput()->with('error','Not valid');
           // }

               // $storedetails=$storeinfo->save();
                 $edit_f ='';
                 if($res){
                     return Redirect('submenu')->with('success','Updated successfully',['edit_f' => $edit_f]);
                 }else{
                     return back()->withErrors('Not Updated ');
                 }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
       
    }

    /*Submenu delete*/
    public function deletesubmenu($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            // $uparr=array(
            //     'delet_flag'=>1,
            //      );
            // $res=Mainmenu::where('id',$id)->update($uparr);
             $res_sub= Submenusub::where('submenuid',$id)->delete();
          
            if($res_sub)
            {
             $res= Submenu::findOrFail($id)->delete();
                // $res_sub=Mainmenusub::where('mainmenuid',$id)->update($uparr);
            }
            $edit_f ='';
                 if($res_sub){
                    DB::commit();
                     return Redirect('submenu')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }

    

    /*Subnmenu Status*/
    public function statussubmenu($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            $status=Submenu::where('id',$id)->value('status_id');

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

           
            $res=Submenu::where('id',$id)->update($uparr);
            // dd($res);
            $edit_f ='';
                 if($res){
                    DB::commit();
                     return Redirect('submenu')->with('success','Status updated successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }

    public function OrderchangeSubmenu_form(Request $request)
    {
        try {
            $id= Crypt::decryptString($request->id);/*dd($request->val);*/
            $res = Submenu::where('id', '=', $id)->update(['orderno' => $request->val]);
            // 
        } catch (\Exception $exception) {
            /*\LogActivity::addToLog($exception->getMessage());
            $data = \LogActivity::logLatestItem();
            $error = array('er' => 'Please contact admin; the error code is ERROR' . $data->id);
            return view('Siteadmin.dashboard', compact('error'));*/
        } catch (\Throwable $exception) {
            /*\LogActivity::addToLog($exception->getMessage());
            $data = \LogActivity::logLatestItem();
            $error = array('er' => 'Please contact admin; the error code is ERROR' . $data->id);
            return view('Siteadmin.dashboard', compact('error'));*/
        } catch (\Illuminate\Database\QueryException $exception) {

            /*\LogActivity::addToLog($exception->getMessage());
            $data = \LogActivity::logLatestItem();
            return back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);*/
        }
        if ($res) {
            $success = "Status Updated!";
            return response()->json(['html' => $success]);
        } else {
            $error = 'Not updated status';
            return response()->json(['html' => $error]);
        }
    }


    /*Subsub menu*/
    public function subsubmenu()
    {

    
        $data = subsubmenu::with(['lang_sel' => function($query){
            // $query->where('delet_flag',0);
        }])->with(['subsubmenusub' =>function($query1){
            // $query1->where('delet_flag',0);
        }])->with(['menu_link_types' =>function($query2){
            $query2->where('delet_flag',0)->get();
        }])->with(['sbu_type_user' => function($query3){
            $query3->where('delet_flag',0);
        }])->with(['mainmenu_sub_selected' => function($query3){
            $query3->where('languageid',1);
        }])->with(['submenu_selected' => function($query3){
            $query3->where('languageid',1);
        }])->orderBy('orderno','asc')->get();


        $lang = Language::where('delet_flag',0)->orderBy('name')->get();
        $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();
        $Mainmenu=Mainmenu::where('delet_flag',0)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Sub sub menu', 'message' => 'Sub sub menu', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.admin.Subsubmenu.subsubmenu',compact('data','breadcrumbarr','lang','Menulinktype','Mainmenu','navbar','user'));
    }

    /*Create sub sub menu*/
    public function createsubsubmenu()
    {
    
            $language = Language::where('delet_flag',0)->orderBy('name')->get();
            $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();
            $mainmenu = Mainmenu::with(['mainmenu_sub' => function($query){
                    $query->where('languageid',1);
                }])->where('delet_flag',0)->where('viewer_id',1)->get();
// dd($mainmenu);
            $user_s = Sbutype::where('delet_flag',0)->where('status_id',1)->get();
  
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
                1 => array('title' => 'Sub sub menu', 'message' => 'Sub sub menu', 'status' => 0, 'link' => '/admin/subsubmenu'),
                2 => array('title' => 'Create Sub sub menu', 'message' => 'Create Sub sub enu', 'status' => 1)
             );
            $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
            $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
            $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
            $url = url()->previous();
            $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
            $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
    
            $arttype =   Articletype::with(['articletype_sub'=>function($query){
                $query->where('languageid', 1);
            }])->where('status_id',1)->where('delet_flag',0)->get();
    
    
            return view('backend.admin.Subsubmenu.createsubsubmenu',compact('breadcrumbarr','language','navbar','user','Menulinktype','mainmenu','Navid','user_s','arttype'));
        } 
    /*mainmenusbuwise */
    public function mainmenusbuwise(Request $request)
    {
        $mainmenuid=$request->mainmenuid;

        $Submenu = Submenu::with(['lang_sel' => function($query){
            $query->where('delet_flag',0);
        }])->with(['submenusub' =>function($query1){
            $query1->where('languageid',1);
        }])->where('mainmenu_id',$mainmenuid)->where('delet_flag',0)->orderBy('orderno','asc')->get();

    // dd($arttype);
    return response()->json($Submenu);
    }
    /*stationtype*/

  /*store subsubmenu*/
  public function storesubsubmenu(Request $request)
  {
    //   dd($request->all());
      try{

         $validator = Validator::make(
            $request->all(),
            [
                'icon_class'    => 'sometimes',
                'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'menulinktype'  => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'mainmenuid'    => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'sbu_user'      => 'sometimes',
                'sbu_type'      => 'sometimes',
                'file_type'     => app('App\Http\Controllers\Commonfunctions')->getFileval()
                
            ],
            [
                'title.required' => 'Title is required',
                'title.regex'    => 'The title format is invalid',
                'title.min'      => 'Title  minimum length is 3',
                'title.max'      => 'Title  maximum length is 150',  

                'file_type.mimes'   => 'Invalid image format',     

            ]
        );
        // 

        if ($validator->fails()) {
            // dd($validator->errors());
            return back()->withInput()->withErrors($validator->errors());
        }
             $article_id=0;
          $role_id = Auth::user()->id;
           if($request->Anchor)
                  {
                      $menulinktype_data=$request->Anchor;
                  }
                  elseif($request->url)
                  {
                      $menulinktype_data=$request->url;
                  }
                  elseif($request->forms)
                  {
                      $menulinktype_data=$request->forms;
                  }  elseif($request->menulinktype==17)
                  {
                      $menulinktype_data='';
                  }elseif(($request->menulinktype==14) || ($request->menulinktype==20) )
                  {
                      $menulinktype_data=$request->articletype;
                      $article_id=$request->articletype;
                      // $url_name='/planning/articledetail/';
                      // $menulinktype_data=$url_name.$request->articletype;
                  }elseif($request->menulinktype==21)
                  {
                      $menulinktype_data=$request->downloadtype;
                  }
// dd($request->all());
                      if($request->sbu_user==null)
                      {
                          $sbu_user= 0;
                      }else{
                          $sbu_user= $request->sbu_user;
                      }
                      if($request->icon_class==null)
                      {
                          $icon_class= 0;
                      }else{
                          $icon_class= $request->icon_class;
                      }
                          
  
           if ($request->menulinktype != 13) //Anchor|| URL || Form || Article
              {
                      $leng=count($request->sel_lang);

                      $storeinfo=new subsubmenu([
                              'users_id'=>$role_id,
                              'mainmenu_id'=>$request->mainmenuid,
                              'submenu_id'=>$request->submenuid,
                              'iconclass'=>$icon_class,
                              'orderno'=>$request->ord_num,
                              'menulinktype_id'=>$request->menulinktype,
                              'menulinktype_data'=>$menulinktype_data,
                              'viewer_id'=>$request->sbu_id,
                              'sbu_type'=>$sbu_user,
                              'articletype_id'=>$article_id,
                              'delet_flag'=>0,
                              'status_id'=>1,                
                          ]);
               // dd($storeinfo);
                      $res = $storeinfo->save();
                      $Subsubmenusub = DB::getPdo()->lastInsertId();

                      $leng=count($request->sel_lang);

                   if($res)
                   {
                     for($i=0;$i<$leng;$i++){

                          $storeinfo_sub=new subsubmenusub([
                              'userid'=>$role_id,
                              'languageid'=>$request->sel_lang[$i],
                              'title' =>$request->title[$i],
                              'subsubmenu_id'=>$Subsubmenusub,
                     
                          ]);
                        //   dd($storeinfo_sub);
                          $res_su = $storeinfo_sub->save();
                              DB::commit();

                        }//endfor
                   }//ifres

 
              }//endif 13!=
              else if($request->menulinktype == 13)
               {
                // dd($request->all());
                   $leng=count($request->sel_lang);

                   for($i=0;$i<$leng;$i++){

                      $date = date('dmYH:i:s');
                      
                       if (isset($request->file_type)) {   
                     
                              $imageName = $request->title[0] . $date . '.' . $request->file_type->extension();
                              $path = $request->file('file_type')->storeAs('/uploads/Subsubmenu', $imageName,'myfile');

                        }//endisset
                        // dd($imageName);
                      $storeinfo=new subsubmenu([
                              'users_id'=>$role_id,
                              'iconclass'=>$icon_class,
                              'submenu_id'=>$request->submenuid,
                              'orderno'=>$request->ord_num,
                              'mainmenu_id'=>$request->mainmenuid,
                              'menulinktype_id'=>$request->menulinktype,
                              'menulinktype_data'=>$imageName,
                              'viewer_id'=>$request->sbu_id,
                              'sbu_type'=>$sbu_user,
                              'articletype_id'=>$article_id,
                              'delet_flag'=>0,
                              'status_id'=>1,                
                          ]);
        // dd($storeinfo);
                      $res = $storeinfo->save();
                      $Subsubmenusub = DB::getPdo()->lastInsertId();

                      $leng=count($request->sel_lang);

                       if($res)
                       {
                        
                         for($i=0;$i<$leng;$i++){

                              $storeinfo_sub=new subsubmenusub([
                                  'userid'=>$role_id,
                                  'languageid'=>$request->sel_lang[$i],
                                  'title' =>$request->title[$i],
                                  'subsubmenu_id'=>$Subsubmenusub,
                                  
                              ]);
                            //   dd($storeinfo_sub);
                              $res_su = $storeinfo_sub->save();
                                  DB::commit();

                            }//endfor
                       }//ifres
                    

                       // $chkfilmrws = Submenu::where('title', $request->language[$i])->exists() ? 1 : 0;
                       //    // dd($chkfilmrws);
                       //    if ($chkfilmrws == 0) {
                       //        $res = $storeinfo->save();
                       //        DB::commit();
                       //    } else {
                       //        $res = false;
                       //        $msg = "This Title is already existing";
                       //        DB::rollback();
                       //    }

                   }//enffor
               }   
              
    
             // $storedetails=$storeinfo->save();
             return redirect()->route('admin.subsubmenu')->with('success','created successfully');

      } catch (ModelNotFoundException $exception) {
          \LogActivity::addToLog($exception->getMessage(),'error');
          $data = \LogActivity::logLatestItem();
          return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
      }

  }
    /*edit editsubsubmenu*/

    public function editsubsubmenu($id)
    {
      
        $id= Crypt::decryptString($id);
        // dd($id);
        $edit_f = 'E';
     
        $error = '';

        $data = subsubmenu::with(['lang_sel' => function($query){
            // $query->where('delet_flag',0);
        }])->with(['subsubmenusub' =>function($query1){
            // $query1->where('delet_flag',0);
        }])->with(['menu_link_types' =>function($query2){
            $query2->where('delet_flag',0)->get();
        }])->with(['sbu_type_user' => function($query3){
            $query3->where('delet_flag',0);
        }])->with(['mainmenu_sub_selected' => function($query3){
            $query3->where('languageid',1);
        }])->get();

        $keydata = subsubmenu::with(['lang_sel' => function($query){
            // $query->where('delet_flag',0);
        }])->with(['subsubmenusub' =>function($query1){
            // $query1->where('delet_flag',0);
        }])->with(['menu_link_types' =>function($query2){
            $query2->where('delet_flag',0)->get();
        }])->with(['sbu_type_user' => function($query3){
            $query3->where('delet_flag',0);
        }])->with(['mainmenu_sub_selected' => function($query3){
            $query3->where('languageid',1);
        }])->where('id',$id)->first();


        // dd($data);
        // $user_s = User::where('delet_flag',0)->whereIn('role_id',[5])->where('status_id',1)->get();
        $user_s = Sbutype::where('delet_flag',0)->where('status_id',1)->get();

        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();
        $mainmenu = Mainmenu::with(['mainmenu_sub' => function($query){
                $query->where('languageid',1);
            }])->where('delet_flag',0)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Sub sub menu', 'message' => 'Sub sub menu', 'status' => 0, 'link' => '/admin/subsubmenu'),
            2 => array('title' => 'Edit Sub menu', 'message' => 'Edit Sub menu', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $arttype =   Articletype::with(['articletype_sub'=>function($query){
            $query->where('languageid', 1);
        }])->where('status_id',1)->where('delet_flag',0)->get();
        // dd($keydata);
        return view('backend.admin.Subsubmenu.createsubsubmenu', compact('arttype','data','edit_f', 'error','keydata','breadcrumbarr','language','Menulinktype','navbar','user','user_s','mainmenu'));
    }

   /*Subsubmenu update*/

   public function updatesubsubmenu(Request $request)
   {
    //    dd($request->all());
       try{
     
           $validator = Validator::make(
               $request->all(),
               [
                'icon_class'    => 'sometimes',
                'menulinktype' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'mainmenuid' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'submenuid' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'sbu_user'      => 'sometimes',
                'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'sbu_type'        => 'sometimes',
               ],
               [
                   'title.required' => 'Title is required',
                   'title.regex'    => 'The title format is invalid',
                   'title.min'      => 'Title  minimum length is 3',
                   'title.max'      => 'Title  maximum length is 150',
   
                   'icon_class.required' => 'Icon Class is required',
                   'icon_class.regex'    => 'The icon class format is invalid',
                   'icon_class.min'      => 'Icon Class  minimum length is 3',
                   'icon_class.max'      => 'Icon Class  maximum length is 30',
   
                   'menulinktype.required'  => 'menu type reuired',
                   'menulinktype.regex'    => 'menu type format is invalid',
                   'menulinktype.min'      => 'menu type  minimum length is 3',
                   'menulinktype.max'      => 'menu type  maximum length is 30',
               ]
           );
   
           if ($validator->fails()) {
               return back()->withInput()->withErrors($validator->errors());
           }


           $article_id=0;
           $role_id = Auth::user()->id;
           $date = date('dmYH:i:s');

                   if($request->Anchor)
                   {
                       $menulinktype_data=$request->Anchor;
                   }
                   elseif($request->url)
                   {
                       $menulinktype_data=$request->url;
                   }
                   elseif($request->route)
                   {
                       $menulinktype_data=$request->route;
                   }
                   elseif($request->forms)
                   {
                       $menulinktype_data=$request->forms;
                   }  elseif($request->menulinktype==17)
                   {
                       $menulinktype_data='';
                   }elseif(($request->menulinktype==14) || ($request->menulinktype==20) )
                   {
                       $menulinktype_data=$request->articletype;
                       $article_id=$request->articletype;
                       // $url_name='/planning/articledetail/';
                       // $menulinktype_data=$url_name.$request->articletype;
                   }elseif($request->menulinktype==21)
                   {
                       $menulinktype_data=$request->downloadtype;
                   }
               if($request->sbu_user==null)
               {
                   $sbu_user= 0;
               }else{
                   $sbu_user= $request->sbu_user;
               }
               if($request->icon_class==null)
               {
                   $icon_class= 0;
               }else{
                   $icon_class= $request->icon_class;
               }
                      
// dd($sbu_user);
             if ($request->menulinktype != 13) //Anchor|| URL || Form || Article
               {

                   $uparr=array(
                              'users_id'=>$role_id,
                               'mainmenu_id'=>$request->mainmenuid,
                               'submenu_id'=>$request->submenuid,
                               'iconclass'=>$icon_class,
                               'orderno'=>$request->ord_num,
                               'menulinktype_id'=>$request->menulinktype,
                               'menulinktype_data'=>$menulinktype_data,
                               'viewer_id'=>$request->sbu_id,
                               'sbu_type'=>$sbu_user,   
                               'articletype_id'=>$article_id,
                      );
     
                      $res=subsubmenu::where('id',$request->hidden_id)->update($uparr);

// dd($request->sel_lang);
                       $leng=count($request->sel_lang);
                       $role_id = Auth::user()->id;
                    if($res)
                    {
                      for($i=0;$i<$leng;$i++){

                           $storeinfo_sub=array(
                                   'languageid'=>$request->sel_lang[$i],
                                   'title' =>$request->title[$i],
                                   'subsubmenu_id'=>$request->hidden_id
                           );
                           // dd($storeinfo_sub);
                           $res=subsubmenusub::where('subsubmenu_id',$request->hidden_id)->where('languageid',$request->sel_lang[$i])->update($storeinfo_sub);
                               DB::commit();

                         }//endfor
                    }//ifres


  
               }//endif 13!=
               else{
                if(isset($request->file_type)){
                    $date = date('dmYH:i:s');
                    $imageName = $request->title[0]. $date . '.' .$request->file_type->extension();
                    $filename=$imageName;
                    $path = $request->file('file_type')->storeAs('/uploads/Subsubmenu/', $imageName, 'myfile');
                    $menulinktype_data=$filename;
                    $uparr=array(
                        'users_id'=>$role_id,
                        'mainmenu_id'=>$request->mainmenuid,
                        'submenu_id'=>$request->submenuid,
                        'iconclass'=>$icon_class,
                        'orderno'=>$request->ord_num,
                        'menulinktype_id'=>$request->menulinktype,
                        'menulinktype_data'=>$filename,
                        'viewer_id'=>$request->sbu_id,
                        'sbu_type'=>$sbu_user,   
                        'articletype_id'=>$article_id,
                );
                }else{
                    $uparr=array(
                        'users_id'=>$role_id,
                        'mainmenu_id'=>$request->mainmenuid,
                        'submenu_id'=>$request->submenuid,
                        'iconclass'=>$icon_class,
                        'orderno'=>$request->ord_num,
                        'menulinktype_id'=>$request->menulinktype,
                        'viewer_id'=>$request->sbu_id,
                        'sbu_type'=>$sbu_user,   
                        'articletype_id'=>$article_id,
                );
                }
               
          

            $res=subsubmenu::where('id',$request->hidden_id)->update($uparr);
         //    dd($res);
// dd($request->sel_lang);
             $leng=count($request->sel_lang);
             $role_id = Auth::user()->id;
          if($res)
          {
            for($i=0;$i<$leng;$i++){

                 $storeinfo_sub=array(
                    'languageid'=>$request->sel_lang[$i],
                    'title' =>$request->title[$i],
                    'subsubmenu_id'=>$request->hidden_id
                         
                 );
                 // dd($storeinfo_sub);
                 $res=subsubmenusub::where('subsubmenu_id',$request->hidden_id)->where('languageid',$request->sel_lang[$i])->update($storeinfo_sub);
                     DB::commit();

               }//endfor
          }//ifres

            }
              // $storedetails=$storeinfo->save();
                $edit_f ='';
                if($res){
                    return Redirect('/admin/subsubmenu')->with('success','Updated successfully',['edit_f' => $edit_f]);
                }else{
                    return back()->withErrors('Not Updated ');
                }
       } catch (ModelNotFoundException $exception) {
           \LogActivity::addToLog($exception->getMessage(),'error');
           $data = \LogActivity::logLatestItem();
           return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
       }
      
   }

        /*Subsub menu Status*/
        public function statussubsubmenu($id)
        {
         // dd($id);
         $id= Crypt::decryptString($id);
 
             DB::beginTransaction();
             $keydata = subsubmenu::where('id',$id)->select('status_id')->first();
             // dd($keydata);
             if(($keydata->status_id==1))
             {
                 $uparr=array(
                     'status_id'=>0,
                      );
             }else{
 
                 $uparr=array(
                     'status_id'=>1,
                      );            }
             $res=subsubmenu::where('id',$id)->update($uparr);
 
             $edit_f ='';
                  if($res){
                     DB::commit();
                      return Redirect('/admin/subsubmenu')->with('success','Status updated successfully',['edit_f' => $edit_f]);
                  }else{
                     DB::rollback(); 
                      return back()->withErrors('Not deleted ');
                  }
     }
/*Sub sub menu delete*/
public function deletesubsubmenu($id)
{
   
             $id= Crypt::decryptString($id);

             DB::beginTransaction();

              $res_sub= subsubmenusub::where('subsubmenu_id',$id)->delete();
           
             if($res_sub)
             {
              $res= subsubmenu::findOrFail($id)->delete();
         
             }
             $edit_f ='';
                  if($res_sub){
                     DB::commit();
                      return Redirect('/admin/subsubmenu')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                  }else{
                     DB::rollback(); 
                      return back()->withErrors('Not deleted ');
                  }
}
  public function OrderchangeSubSubmenu_form(Request $request)
  {
      try {
          $id= Crypt::decryptString($request->id);//dd($id);
          $res = subsubmenu::where('id', '=', $id)->update(['orderno' => $request->val]);
          // 
      } catch (\Exception $exception) {
          /*\LogActivity::addToLog($exception->getMessage());
          $data = \LogActivity::logLatestItem();
          $error = array('er' => 'Please contact admin; the error code is ERROR' . $data->id);
          return view('Siteadmin.dashboard', compact('error'));*/
      } catch (\Throwable $exception) {
          /*\LogActivity::addToLog($exception->getMessage());
          $data = \LogActivity::logLatestItem();
          $error = array('er' => 'Please contact admin; the error code is ERROR' . $data->id);
          return view('Siteadmin.dashboard', compact('error'));*/
      } catch (\Illuminate\Database\QueryException $exception) {

          /*\LogActivity::addToLog($exception->getMessage());
          $data = \LogActivity::logLatestItem();
          return back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);*/
      }
      if ($res) {
          $success = "Status Updated!";
          return response()->json(['html' => $success]);
      } else {
          $error = 'Not updated status';
          return response()->json(['html' => $error]);
      }
  }

    public function stationtype()
    {
        $data = Stationtype::where('delet_flag',0)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Station type', 'message' => 'Station type', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);


         $usertype=usertype::get();
         $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
         $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.admin.Stationtype.stationtype',compact('data','breadcrumbarr','usertype','navbar','user'));
    }

    /*Store station type*/
    public function storestationtype(Request $request)
    {

        try{
            $request->validate([
                'stationname' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
           ]);
               $request->input();
               $role_id = Auth::user()->id;
           
               $storeinfo=new Stationtype([
                   'name'=>$request->stationname,
                   'delet_flag'=>0,
                   'status_id'=>1,
                   'userid'=>$role_id
               ]);
      
               $storedetails=$storeinfo->save();
               return redirect()->route('stationtype')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

    /*edit stationtype*/
    public function editstationtype($id)
    {
        $id= Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = Stationtype::where('id',$id)->first();
        $error = '';
        $data = Stationtype::where('delet_flag',0)->get();
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Station type', 'message' => 'Station type', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        return view('backend.admin.Stationtype.stationtype', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user'));
    }

    /*Station type update*/

    public function updatestationtype(Request $request)
    {
        try{
            $request->validate([
                'stationname' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
           ]);
               $request->input();
           
               $uparr=array(
                  'name'=>$request->stationname,
                 );

                 $res=Stationtype::where('id',$request->hidden_id)->update($uparr);
                 $edit_f ='';
                 if($res){
                     return Redirect('stationtype')->with('success','Updated successfully',['edit_f' => $edit_f]);
                 }else{
                     return back()->withErrors('Not Updated ');
                 }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
       
    }

      /*Station type delete*/

    public function deletestationtype($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            // $uparr=array(
            //     'delet_flag'=>1,
            //      );
            // $res=Stationtype::where('id',$id)->update($uparr);
             $res= Stationtype::findOrFail($id)->delete();
            $edit_f ='';
                 if($res){
                    DB::commit();
                     return Redirect('stationtype')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }

        /*Stationtype Status*/
        public function statusstationtype($id)
        {
            $id= Crypt::decryptString($id);
    
                DB::beginTransaction();
                $uparr=array(
                    'status_id'=>0,
                     );
                $res=Stationtype::where('id',$id)->update($uparr);
      
                $edit_f ='';
                     if($res_sub){
                        DB::commit();
                         return Redirect('stationtype')->with('success','Status updated successfully',['edit_f' => $edit_f]);
                     }else{
                        DB::rollback(); 
                         return back()->withErrors('Not deleted ');
                     }
        }

    /*widgetpositions*/
    public function widgetpositions()
    {
        $data = Widgetposition::where('delet_flag',0)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Widgetposition', 'message' => 'Widgetposition', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.admin.Widgetpostion.widgetposition',compact('data','breadcrumbarr','navbar','user'));
    }


    /*Store widget positions*/
    public function storewidget(Request $request)
    {
        $role_id = Auth::user()->id;
        try{
            $request->validate([
                'widget'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
           ]);
               $request->input();
           
               $storeinfo=new Widgetposition([
                   'name'=>$request->widget,
                   'delet_flag'=>0,
                   'status_id'=>1,
                   'userid'=>$role_id
               ]);
      
               $storedetails=$storeinfo->save();
               return redirect()->route('widgetpositions')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

   /*edit widget positions*/
    public function editwidget($id)
    {
        $id= Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = Widgetposition::where('id',$id)->first();
        $error = '';
        $data = Widgetposition::where('delet_flag',0)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Widgetposition', 'message' => 'Widgetposition', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.admin.Widgetpostion.widgetposition', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user'));
    }

    

    /*widget positions update*/

    public function updatewidget(Request $request)
    {
        try{
            $request->validate([
                'widget'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
           ]);
               $request->input();
           
               $uparr=array(
                  'name'=>$request->widget,
                 );

                 $res=Widgetposition::where('id',$request->hidden_id)->update($uparr);
                 $edit_f ='';
                 if($res){
                     return Redirect('widgetpositions')->with('success','Updated successfully',['edit_f' => $edit_f]);
                 }else{
                     return back()->withErrors('Not Updated ');
                 }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
       
    }

      /*widget positions delete*/

    public function deletewidget($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            // $uparr=array(
            //     'delet_flag'=>1,
            //      );
            // $res=Widgetposition::where('id',$id)->update($uparr);
             $res= Widgetposition::findOrFail($id)->delete();
            $edit_f ='';
                 if($res){
                    DB::commit();
                     return Redirect('widgetpositions')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }

    /*Widget postion Status*/
public function statuswidgetpost($id)
{
    $id= Crypt::decryptString($id);

        DB::beginTransaction();
        $uparr=array(
            'status_id'=>0,
             );
        $res=Widgetposition::where('id',$id)->update($uparr);

        $edit_f ='';
             if($res_sub){
                DB::commit();
                 return Redirect('widgetpositions')->with('success','Status updated successfully',['edit_f' => $edit_f]);
             }else{
                DB::rollback(); 
                 return back()->withErrors('Not deleted ');
             }
}

    /*widget link*/

    public function widgetlink()
    {
        // $data = Widgetlink::where('delet_flag',0)->get();
        $data = Widgetlink::with(['widgetlinksub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();
        $language=Language::where('delet_flag',0)->orderBy('name')->get();
        $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();
        $Widgetposition = Widgetposition::where('delet_flag',0)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Widgetlink list', 'message' => 'Widgetlink', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.admin.Widgetlink.widgetlink',compact('data','breadcrumbarr','language','Menulinktype','Widgetposition','navbar','user'));
    }
    
    /*Widget create*/
    public function createwidgetlink()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();
        $Widgetposition = Widgetposition::where('delet_flag',0)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Widgetlink', 'message' => 'Widgetlink', 'status' => 0, 'link' => '/widgetlink'),
            2 => array('title' => 'Create Widgetlink', 'message' => 'Create Widgetlink', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        return view('backend.admin.Widgetlink.createwidgetlink',compact('breadcrumbarr','language','navbar','user','Menulinktype','Widgetposition','Navid'));
    }

    /*store widgetlink*/
     public function storewidgetlink(Request $request)
    {
        // dd($request->all());
        try{
            $request->validate([
                'icon_class'    => app('App\Http\Controllers\Commonfunctions')->getIconClass(),
                'menulinktype' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'widgetpostn' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'poster.*' =>    app('App\Http\Controllers\Commonfunctions')->getImageLTAval(),
           ]);
               $request->input();

            $role_id = Auth::user()->id;
            
            $date = date('dmYH:i:s');

             if ($request->menulinktype != 13) //Anchor|| URL || Form || Article
                {
                   
                    if($request->Anchor)
                    {
                        $menulinktype_data=$request->Anchor;
                    }
                    elseif($request->url)
                    {
                        $menulinktype_data=$request->url;
                    }
                    elseif($request->articletype)
                    {
                        $menulinktype_data=$request->articletype;
                    }
                    elseif($request->forms)
                    {
                        $menulinktype_data=$request->forms;
                    }

                        $leng=count($request->language);

                     

                            $storeinfo=new Widgetlink([
                                'userid'=>Auth::user()->id,
                                'widgetpositionid' =>$request->widgetpostn,
                                'iconclass'=>$request->icon_class,
                                'menulinktypeid'=>$request->menulinktype,
                                'menulink_data'=>$menulinktype_data,
                                'delet_flag'=>0,
                                'status_id'=>1,
                            ]);

                            $res = $storeinfo->save();
                            $wid_id = DB::getPdo()->lastInsertId();
                            // dd($wid_id);
         
                                if($res)
                                {
                                $date = date('dmYH:i:s');
   for($i=0;$i<$leng;$i++){
                                if (isset($request->poster[$i])) {   
                       
                                // $imageName = 'widget' . $date . '.' . $request->poster[$i]->extension();
                                foreach($request->file('poster') as $key => $file)
                                {
                                    
                                     $imageName = 'widgetlink'.$request->sel_lang[$i].'' . $date . '.' . $file->extension();

                                     // $path = $request->file('file')->storeAs('/uploads/Widgetlink_sub', $imageName,'myfile');
                                     $path=$file->storeAs('/uploads/Widgetlink', $imageName,'myfile');
                                     // $files[]['name'] = $path;
                                }
                                
                                
                                $store_sub_info=new Widgetlink_sub([
                                    'language_id'=>$request->sel_lang[$i],
                                    'title' =>$request->language[$i],
                                    'subtitle' =>$request->sub_title[$i],
                                    'alternatetext' =>$request->alt_title[$i],
                                    'poster' => $imageName,
                                    'userid'=>Auth::user()->id,
                                    'widgetlink_id' => $wid_id,
                                    'delet_flag'=>0,
                                    'status_id'=>1,
                                ]);
                                // dd($store_sub_info);
                                $storedetails_sub=$store_sub_info->save();
                                }

                                }
                                DB::commit();
                            // } else {
                            //     $res = false;
                            //     $msg = "This Title is already existing";
                            //     DB::rollback();
                            // }
                                    // $storedetails=$storeinfo->save();
                          }//endfor
   
                }//endif 13!=
                else if($request->menulinktype == 13)
                 {
                     $leng=count($request->language);

                     for($i=0;$i<$leng;$i++){

                        $date = date('dmYH:i:s');
                        
                         if (isset($request->file_type)) {   
                                $imageName = 'Widgetlink' . $date . '.' . $request->poster->extension();
                                $path = $request->file('poster')->storeAs('/uploads/Widgetlink_sub', $imageName,'myfile');
                                $imageName1 = 'Widgetlinksub' . $date . '.' . $request->file_type->extension();
                                $path1 = $request->file('file_type')->storeAs('/uploads/Widgetlink_sub', $imageName,'myfile');
                                 $storeinfo=new Widgetlink([
                                    'widgetpositionid' =>$request->widgetpostn,
                                    'iconclass'=>$request->icon_class,
                                    'menulinktypeid'=>$request->menulinktype,
                                    'menulink_data'=>$imageName1,
                                    'userid'=>Auth::user()->id,
                                    'delet_flag'=>0,
                                    'status_id'=>1,
                                ]);
                         }//endisset

                         // $chkfilmrws = Mainmenu::where('title', $request->language[$i])->exists() ? 1 : 0;
                         //    // dd($chkfilmrws);
                         //    if ($chkfilmrws == 0) {
                                $res = $storeinfo->save();
                                 if($res)
                                {
                                $store_sub_info=new Widgetlink_sub([
                                'users_id'=>$role_id,
                                'language_id'=>$request->sel_lang[$i],
                                'title' =>$request->language[$i],
                                'subtitle' =>$request->sub_title[$i],
                                'alternatetext' =>$request->alt_title,
                                'menulinktype_data'=>$imageName1,
                                'delet_flag'=>0,
                                'status_id'=>1,
                               ]);
                            $storedetails_sub=$store_sub_info->save();
                                }
                                DB::commit();
                            // } else {
                            //     $res = false;
                            //     $msg = "This Title is already existing";
                            //     DB::rollback();
                            // }

                     }//enffor
                 }   
                
               // $storedetails=$storeinfo->save();
               return redirect()->route('widgetlink')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

  /*Widgetlink Edit*/
    public function editwidgetlink($id)
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();
        $Widgetposition = Widgetposition::where('delet_flag',0)->get();

        $id= Crypt::decryptString($id);
        $edit_f = 'E';

        $data = Widgetlink::with(['widgetlinksub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

        $keydata = Widgetlink::with(['widgetlinksub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->where('id',$id)->first();
// dd($keydata);
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Widgetlink', 'message' => 'Widgetlink', 'status' => 0, 'link' => '/widgetlink'),
            2 => array('title' => 'Create Widgetlink', 'message' => 'Create Widgetlink', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.admin.Widgetlink.createwidgetlink',compact('breadcrumbarr','language','navbar','user','Menulinktype','Widgetposition','data','keydata'));
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

        return view('backend.admin.Gallerytype.gallerytype',compact('data','breadcrumbarr','usertype','navbar','user'));
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
        return view('backend.admin.Gallerytype.gallerytype', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user'));
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
        return view('backend.admin.Logo.logotype',compact('data','breadcrumbarr','usertype','navbar','user'));
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

        return view('backend.admin.Logo.logotype', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user'));
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
                     return Redirect('logotype')->with('success','Updated successfully',['edit_f' => $edit_f]);
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
                     return Redirect('logotype')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
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
        return view('backend.admin.Footermenu.footermenulist',compact('data','breadcrumbarr','language','navbar','user'));
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
        return view('backend.admin.Footermenu.createfootermenu',compact('breadcrumbarr','language','navbar','user','Navid'));
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
        return view('backend.admin.Footermenu.createfootermenu', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user','language','Navid'));
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

    /*Designation*/
    public function designation()
    {

        $data = Designation::with(['des_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();
        // dd($data);

        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Designation', 'message' => 'Designation', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.admin.Designation.designation',compact('data','breadcrumbarr','navbar','language','user'));
    }

    /*Store Designation*/
    public function storedesignation(Request $request)
    {

        try{

             $validator = Validator::make(
            $request->all(),
             [
                'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
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
          

               $leng=count($request->sel_lang);
           
                $storeinfo=new Designation([
                   'delet_flag'=>0,
                   'status_id'=>1,
                   'userid'=>Auth::user()->id
               ]);
                $res = $storeinfo->save();
                $des_id = DB::getPdo()->lastInsertId();
                if($res)
                {
                 for($i=0;$i<$leng;$i++){
                 $storeinfo_sub=new Designationsub([
                   'languageid'=>$request->sel_lang[$i],
                   'title' =>$request->title[$i],
                   'designationid' =>$des_id,
                   'delet_flag'=>0,
                   'status_id'=>1,
                   'userid'=>Auth::user()->id
                 ]);
                  $storedetails_sub=$storeinfo_sub->save();
                 }
                
                 if($storedetails_sub){
                    DB::commit();
                     return Redirect('designation')->with('success','created successfully');
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not  ');
                 }
                }
    

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }


   /*edit Designation*/
   public function editdesignation($id)
   {

       $id= Crypt::decryptString($id);
       $edit_f = 'E';
       $keydata = Designation::with(['des_sub' =>function($query){
           $query->where('delet_flag',0);
       }])->where('delet_flag',0)->where('id',$id)->first();
       $error = '';
       $data = Designation::with(['des_sub' =>function($query){
           $query->where('delet_flag',0);
       }])->where('delet_flag',0)->get();

       $language = Language::where('delet_flag',0)->orderBy('name')->get();

       $breadcrumb = array(
          0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
           1 => array('title' => 'Designation', 'message' => 'Designation', 'status' => 0, 'link' => '/designation'),
           2 => array('title' => 'Edit Designation', 'message' => 'Edit Designation', 'status' => 1)
        );
       $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
       $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
       $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

       return view('backend.admin.Designation.designation', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','language','user'));
   }
   
     /*Designation  update*/
     public function updatedesignation(Request $request)
     {
        //  dd($request->all());
         $validator = Validator::make(
             $request->all(),
             [
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
 
           for ($i=0; $i<count($request->title); $i++) {
                  $res=Designationsub::where('designationid',$request->hidden_id)->where('languageid',$request->sel_lang[$i])
                      ->update([
                    'title' =>$request->title[$i],
             ]);
             // dd($request->sel_lang[$i]);
 
           } //forloopend
 
         if($res){
             DB::commit();
             return Redirect('designation')->with('success','Updated successfully');
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
     
/*Designation Status*/
public function statusdesignation($id)
{
    $id= Crypt::decryptString($id);
    $status=Designation::where('id',$id)->value('status_id');
      
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
      
    $res=Designation::where('id',$id)->update($uparr);
      
    $edit_f ='';
        if($res){
            DB::commit();
            return Redirect('designation')->with('success','Status updated successfully',['edit_f' => $edit_f]);
        }else{
            DB::rollback(); 
            return back()->withErrors('Not deleted ');
        }
}


/* Designation delete*/
public function deletedesignation($id)
{
    $id= Crypt::decryptString($id);
          // dd($id);
    DB::beginTransaction();
  
    $res_sub= Designationsub::where('designationid',$id)->delete();
            
    if($res_sub)
    {
    $res= Designation::findOrFail($id)->delete();
    }
    $edit_f ='';
    if($res_sub){
        DB::commit();
        return Redirect('designation')->with('success','Deleted successfully',['edit_f' => $edit_f]);
    }else{
        DB::rollback(); 
        return back()->withErrors('Not deleted ');
    }
}
           
 /*Order type*/
    public function ordertype()
    {
        $data = Ordertype::with(['ordertype_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();


        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Order type', 'message' => 'Order type', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        $usertype=usertype::get();
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.admin.Ordertype.ordertypelist',compact('data','breadcrumbarr','usertype','navbar','user'));
    }



/*Order type create*/
    public function createordertype()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Order type', 'message' => 'Order type', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        return view('backend.admin.Ordertype.createordertype',compact('breadcrumbarr','language','navbar','user','Navid'));
    }

/*Store ordertype*/
    
    public function storeordertype(Request $request)
    {
        // dd($request->all());
        try{
          $request->validate([
                'sel_lang.*'=>app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
           ],
            [
                'title.required' => 'Title is required',
                'title.min' => 'Title  minimum lenght is 2',
                'title.max' => 'Title  maximum lenght is 50',
                'title.regex' => 'Invalid characters not allowed for Title',

            ]);
            $request->input();
            $role_id = Auth::user()->id;

            $leng=count($request->sel_lang);
            // dd($leng);

            $storeinfo=new Ordertype([
                                'userid'=>Auth::user()->id,
                                'delet_flag'=>0,
                                'status_id'=>1,
                            ]);

            $res = $storeinfo->save(); 
            $orderid = DB::getPdo()->lastInsertId();

            for($i=0;$i<$leng;$i++){
              
               
                if($orderid){

                        $store_sub_info=new Ordertypesub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'ordertypeid' => $orderid,
                                    'userid' => $role_id,
                                    'delet_flag'=>0,
                                    'status_id'=>1,
                                ]);
                         $storedetails_sub=$store_sub_info->save();
                }
                // dd($path);
            }//forloopend

            return redirect()->route('ordertype')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }    
/*edit ordertype*/
    public function editordertype($id)
    {

        $id= Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = Ordertype::with(['ordertype_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->where('id',$id)->first();
        $error = '';
        $data = Ordertype::with(['ordertype_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Order type', 'message' => 'Order type', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.admin.Ordertype.createordertype', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user'));
    }


  /*Ordertype  update*/
  public function updateordertype(Request $request)
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

        for ($i=0; $i<count($request->title); $i++) {
               $res=Ordertypesub::where('ordertypeid',$request->hidden_id)->where('languageid',$request->sel_lang[$i])
                   ->update([
                 'title' =>$request->title[$i],
          ]);
          // dd($request->sel_lang[$i]);

        } //forloopend

      if($res){
          DB::commit();
          return Redirect('ordertype')->with('success','Updated successfully');
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

 /*Ordertype Status*/
public function statusordertype($id)
{
    $id= Crypt::decryptString($id);
    $status=Ordertype::where('id',$id)->value('status_id');
  
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
    $res=Ordertype::where('id',$id)->update($uparr);
  
    $edit_f ='';
    if($res){
        DB::commit();
        return Redirect('ordertype')->with('success','Status updated successfully',['edit_f' => $edit_f]);
    }else{
        DB::rollback(); 
        return back()->withErrors('Not deleted ');
    }
}
  


/*Download type*/
    public function downloadtype()
    {
        $data = Downloadtype::with(['downloadtype_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->with(['sbu_type_user' => function($query1){
            $query1->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Download type', 'message' => 'Download type', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $usertype=usertype::get();

        return view('Master.Downloadtype.downloadtypelist',compact('data','breadcrumbarr','usertype','navbar','user'));
    }

/*Download type create*/
    public function createdownloadtype()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        $role_id = Auth::user()->role_id;
        if($role_id==5){
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
                1 => array('title' => 'Download type', 'message' => 'Download type', 'status' => 0, 'link' => '/sbu/downloadtype'),
                2 => array('title' => 'Create Download type', 'message' => 'Create Download type', 'status' => 1)
             );
        }else{
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/sbuhome'),
                1 => array('title' => 'Download type', 'message' => 'Download type', 'status' => 0, 'link' => '/admin/downloadtype'),
                2 => array('title' => 'Create Download type', 'message' => 'Create Download type', 'status' => 1)
             );
        }
        
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        $user_s = Sbutype::where('delet_flag',0)->where('status_id',1)->get();

        return view('Master.Downloadtype.createdownloadtype',compact('breadcrumbarr','language','navbar','user','Navid','user_s'));
    }

    public function moresbuuser(Request $request)
    {

        $user_s_sbu = User::where('delet_flag',0)->where('status_id',1)->where('sbutype',$request->sbu_user)->where('status_id',1)->get();
        return response()->json($user_s_sbu);
    }

         /*Store Downloadtype*/
    
    public function storedownloadtype(Request $request)
    {
        // dd($request->all());
        try{
          $request->validate([
                'sel_lang.*'    =>  app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'title.*'       =>  app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'urlkey'        => 'required|min:2|max:50|unique:downloadtypes,urlkeyid'
           ],
            [
                'title.required' => 'Title is required',
                'title.min' => 'Title  minimum lenght is 2',
                'title.max' => 'Title  maximum lenght is 50',
                'title.regex' => 'Invalid characters not allowed for Title',
            ]);
            $request->input();
            $role_id = Auth::user()->id;

            $leng=count($request->sel_lang);
            // dd($leng);
            if(empty($request->sbu_main_dashboard)){
                $sbu_main_dashboard=0;
            }else{
                $sbu_main_dashboard=1;
            }
            $storeinfo=new Downloadtype([
                                'userid'=>Auth::user()->id,
                                'delet_flag'=>0,
                                'sbu_maindashboard'=>$sbu_main_dashboard,
                                'viewer_id'=>$request->sbu_id,
                                'sbu_type'=>$request->sbu_user,
                                'urlkeyid'=>$request->urlkey,
                                'multi_sbu'=>$request->moresbuuser,//user table id
                                'status_id'=>1,
                            ]);
// dd($storeinfo);
            $res = $storeinfo->save(); 
            $downloadtypeid = DB::getPdo()->lastInsertId();

            for($i=0;$i<$leng;$i++){
              
               
                if($downloadtypeid){

                        $store_sub_info=new Downloadtypesub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'downloadtypeid' => $downloadtypeid,
                                    'userid' => $role_id,
                                    'delet_flag'=>0,
                                    'status_id'=>1,
                                ]);
                         $storedetails_sub=$store_sub_info->save();
                }
                // dd($path);
            }//forloopend
            $role_id = Auth::user()->role_id;
           if($role_id==5){
            return redirect()->route('sbu.downloadtype')->with('success','created successfully');
           }else{
            return redirect()->route('admin.downloadtype')->with('success','created successfully');
           }
            

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

 /*edit Download type*/
    public function editdownloadtype($id)
    {

        $id= Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = Downloadtype::with(['downloadtype_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->where('id',$id)->first();
        // dd($keydata);
        $error = '';
        $data = Downloadtype::with(['downloadtype_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

        $language = Language::where('delet_flag',0)->orderBy('name')->get();
// dd($keydata);
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Download type List', 'message' => 'Download type List', 'status' => 0, 'link' => '/admin/downloadtype'),
            2 => array('title' => 'Create Download type', 'message' => 'Create Download type', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $user_s = Sbutype::where('delet_flag',0)->where('status_id',1)->get();
        return view('Master.Downloadtype.createdownloadtype', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','language','user','user_s'));
    }
    /*Downloadtype  update*/
    public function updatedownloadtype(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'sel_lang.*'    =>app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'title.*'       =>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'urlkey'        => 'required|min:2|max:50'
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
            if(empty($request->sbu_main_dashboard)){
                $sbu_main_dashboard=0;
            }else{
                $sbu_main_dashboard=1;
            }
            $storeinfo=array(
                'viewer_id'=>$request->sbu_id,
                'sbu_type'=>$request->sbu_user,
                'sbu_maindashboard'=>$sbu_main_dashboard,
                'urlkeyid'=>$request->urlkey,
                'multi_sbu'=>$request->moresbuuser,//user table id
            );
            $res1=Downloadtype::where('id',$request->hidden_id)->update($storeinfo);
            if($res1)
            {
                for ($i=0; $i<count($request->title); $i++) {
                    $res=Downloadtypesub::where('downloadtypeid',$request->hidden_id)->where('languageid',$request->sel_lang[$i])
                        ->update([
                    'title' =>$request->title[$i],
            ]);
            // dd($request->sel_lang[$i]);

            } //forloopend

            }
        
        if($res){
            DB::commit();
            $role_id = Auth::user()->role_id;
           if($role_id==5){
            return redirect()->route('sbu.downloadtype')->with('success','created successfully');
           }else{
            return redirect()->route('admin.downloadtype')->with('success','created successfully');
           }
            // return Redirect('downloadtype')->with('success','Updated successfully');
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
    public function urlkeycheckdownloadtype(Request $request)
    {
      $keyid=$request->urlkey;
      $keyid_status = Downloadtype::where('urlkeyid',$keyid)->pluck('urlkeyid');
      $keyid_count=count($keyid_status);
      return response()->json($keyid_count);
    }
          /* Downloadtype delete*/
    public function deletedownloadtype($id)
     {
        $id= Crypt::decryptString($id);
              // dd($id);
                  DB::beginTransaction();
      
                   $res_sub= Downloadtypesub::where('downloadtypeid',$id)->delete();
                
                  if($res_sub)
                  {
                   $res= Downloadtype::findOrFail($id)->delete();
      
                  }
       $edit_f ='';
        if($res_sub){
            DB::commit();
            $role_id = Auth::user()->role_id;
            if($role_id==5){
             return redirect()->route('sbu.downloadtype')->with('success','created successfully');
            }else{
             return redirect()->route('admin.downloadtype')->with('success','created successfully');
            }
             
        }else{
            DB::rollback(); 
            return back()->withErrors('Not deleted ');
        }     
    }


     /*Downloadtype Status*/
     public function statusdownloadtype($id)
     {
         $id= Crypt::decryptString($id);
         $status=Downloadtype::where('id',$id)->value('status_id');
 
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
 
           
             $res=Downloadtype::where('id',$id)->update($uparr);
 
             $edit_f ='';
                  if($res){
                     DB::commit();
                     $role_id = Auth::user()->role_id;
                     if($role_id==5){
                      return redirect()->route('sbu.downloadtype')->with('success','created successfully');
                     }else{
                      return redirect()->route('admin.downloadtype')->with('success','created successfully');
                     }
                  }else{
                     DB::rollback(); 
                      return back()->withErrors('Not deleted ');
                  }
 }
 /*Article type*/
    public function articletype()
    {
        $data = Articletype::with(['article_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->with(['sbu_type_user' => function($query3){
            $query3->where('delet_flag',0);
        }])->where('delet_flag',0)->get();


        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Article type', 'message' => 'Article type', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
       
        $usertype=usertype::get();

        return view('Master.Articletype.articletypelist',compact('data','breadcrumbarr','usertype','navbar','user'));
    }


/*Article type create*/
    public function createarticletype()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Articletype', 'message' => 'Articletype', 'status' => 0, 'link' => '/articletype'),
            2 => array('title' => 'Create article type', 'message' => 'Create article type', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        $user_s = Sbutype::where('delet_flag',0)->where('status_id',1)->get();
        return view('Master.Articletype.createarticletype',compact('breadcrumbarr','language','navbar','user','Navid','user_s'));
    }

/*Store Article type*/
public function urlkeycheckarticletype(Request $request)
{
  $keyid=$request->urlkey;
  $keyid_status = Articletype::where('urlkeyid',$keyid)->pluck('urlkeyid');
  $keyid_count=count($keyid_status);
  return response()->json($keyid_count);
}
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
        }])->with(['sbu_type_user' => function($query3){
            $query3->where('delet_flag',0);
        }])->where('delet_flag',0)->where('id',$id)->first();
        $error = '';
        $data = Articletype::with(['article_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->with(['sbu_type_user' => function($query3){
            $query3->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        $user_s = Sbutype::where('delet_flag',0)->where('status_id',1)->get();
        $breadcrumb = array(
           0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Articletype', 'message' => 'Articletype', 'status' => 0, 'link' => '/articletype'),
            2 => array('title' => 'Edit article type', 'message' => 'Edit article type', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('Master.Articletype.createarticletype', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','language','user','user_s'));
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
                'urlkey'        => 'required|min:2|max:50'
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
                'urlkeyid'=>$request->urlkey,
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

 /*link type*/
    public function linktype()
    {
        $data = Linktype::with(['linktype_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();


        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Link type', 'message' => 'Link type', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        $usertype=usertype::get();

        return view('Master.Linktype.linktypelist',compact('data','breadcrumbarr','usertype','navbar','user'));
    }

/*Link type create*/
    public function createlinktype()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Linktype', 'message' => 'Linktype', 'status' => 0, 'link' => '/linktype'),
            2 => array('title' => 'Create link type', 'message' => 'Create link type', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();


        return view('Master.Linktype.createlinktype',compact('breadcrumbarr','language','navbar','user','Navid'));
    }


/*Store Linktype*/
    
    public function storelinktype(Request $request)
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

            $request->input();
            $role_id = Auth::user()->id;

            $leng=count($request->sel_lang);
            // dd($leng);

            $storeinfo=new Linktype([
                                'userid'=>Auth::user()->id,
                                'delet_flag'=>0,
                                'status_id'=>1,
                            ]);

            $res = $storeinfo->save(); 
            $linkid = DB::getPdo()->lastInsertId();

            for($i=0;$i<$leng;$i++){
              
               
                if($linkid){

                        $store_sub_info=new Linktypesub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'linktypeid' => $linkid,
                                    'userid' => $role_id,
                                    'delet_flag'=>0,
                                    'status_id'=>1,
                                ]);
                         $storedetails_sub=$store_sub_info->save();
                }
                // dd($path);
            }//forloopend

            return redirect()->route('linktype')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }    


/*edit Linktype*/
    public function editlinktype($id)
    {

        $id= Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = Linktype::with(['linktype_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->where('id',$id)->first();
        $error = '';
        $data = Linktype::with(['linktype_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Linktype', 'message' => 'Linktype', 'status' => 0, 'link' => '/linktype'),
            2 => array('title' => 'Edit link type', 'message' => 'Edit link type', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('Master.Linktype.createlinktype', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user','language'));
    }

    /*linktype  update*/
    public function updatelinktype(Request $request)
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

          for ($i=0; $i<count($request->title); $i++) {
                 $res=Linktypesub::where('linktypeid',$request->hidden_id)->where('languageid',$request->sel_lang[$i])
                     ->update([
                   'title' =>$request->title[$i],
            ]);
            // dd($request->sel_lang[$i]);

          } //forloopend

        if($res){
            DB::commit();
            return Redirect('linktype')->with('success','Updated successfully');
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

    /* linktype delete*/
    public function deletelinktype($id)
    {
        $id= Crypt::decryptString($id);
        // dd($id);
            DB::beginTransaction();

             $res_sub= Linktypesub::where('linktypeid',$id)->delete();
          
            if($res_sub)
            {
             $res= Linktype::findOrFail($id)->delete();

            }
            $edit_f ='';
                 if($res_sub){
                    DB::commit();
                     return Redirect('linktype')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }
          /*Linktype Status*/
          public function statuslinktype($id)
          {
              $id= Crypt::decryptString($id);
              $status=Linktype::where('id',$id)->value('status_id');
            //   dd($status);
      
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
      
                
                  $res=Linktype::where('id',$id)->update($uparr);
      
                  $edit_f ='';
                       if($res){
                          DB::commit();
                           return Redirect('linktype')->with('success','Status updated successfully',['edit_f' => $edit_f]);
                       }else{
                          DB::rollback(); 
                           return back()->withErrors('Not deleted ');
                       }
          }
      
/*district*/
    public function district()
    {
        $data = District::with(['district_sub' =>function($query){

        }])->where('delet_flag',0)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'District', 'message' => 'District', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $usertype=usertype::get();

        return view('Master.District.districtlist',compact('data','breadcrumbarr','usertype','navbar','user'));
    }

/*District create*/
    public function createdistrict()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'District list', 'message' => 'District list', 'status' => 1, 'link' => '/district'),
            2 => array('title' => 'Create District', 'message' => 'Create District', 'status' => 2)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        return view('Master.District.createdistrict',compact('breadcrumbarr','language','navbar','user','Navid'));
    }    


         /*Store District*/
    
    public function storedistrict(Request $request)
    {
        // dd($request->all());
        try{

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

            $request->input();
            $role_id = Auth::user()->id;

            $leng=count($request->sel_lang);
            // dd($leng);

            $storeinfo=new District([
                                'userid'=>Auth::user()->id,
                                'delet_flag'=>0,
                                'status_id'=>1,
                            ]);

            $res = $storeinfo->save(); 
            $districtid = DB::getPdo()->lastInsertId();

            for($i=0;$i<$leng;$i++){
              
               
                if($districtid){

                        $store_sub_info=new Districtsub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'districtid' => $districtid,
                                ]);
                         $storedetails_sub=$store_sub_info->save();
                }
                // dd($path);
            }//forloopend

            return redirect()->route('district')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

 /*edit District*/
    public function editdistrict($id)
    {

        $id= Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = District::with(['district_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->where('delet_flag',0)->where('id',$id)->first();
        $error = '';
        $data = District::with(['district_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
           0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'District list', 'message' => 'District list', 'status' => 1, 'link' => '/district'),
            2 => array('title' => 'Edit District', 'message' => 'Edit District', 'status' => 2)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('Master.District.createdistrict', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','language','user'));
    }
/*District  update*/
    public function updatedistrict(Request $request)
    {
        
        try{
             $request->validate([
                'title.*'=>'required',
            ],
            [
                // 'title.required' => 'Title is required',
                // 'title.min' => 'Title  minimum lenght is 2',
                // 'title.max' => 'Title  maximum lenght is 50',
                // 'title.regex' => 'Invalid characters not allowed for Title',
            ]);
           
            $request->input();


          for ($i=0; $i<count($request->title); $i++) {

           
                 $res=Districtsub::where('districtid',$request->hidden_id)->where('languageid',$request->sel_lang[$i])
                     ->update([
                   'title' =>$request->title[$i],
            ]);

          } //forloopend

        if($res){
            DB::commit();
            return Redirect('district')->with('success','Updated successfully');
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

  /*District delete*/
    public function deletdistrict($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            $res_sub=Districtsub::where('districtid',$id)->delete();
            
             if($res_sub)
             {
                $res= District::findOrFail($id)->delete();
             }
               
            $edit_f ='';
                 if($res){
                    DB::commit();
                     return Redirect('district')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }

    /*Sbu type*/
public function sbutype()
    {
        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        
        $data = Sbutype::where('delet_flag',0)->orderBy('orderno','asc')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Sbutype', 'message' => 'Sbutype', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
       
        $usertype=usertype::get();

        return view('Master.Sbutype.sbutype',compact('data','breadcrumbarr','usertype','navbar','user','language'));
    }

/*store purpose*/
public function storesbutype(Request $request)
    {

        $role_id = Auth::user()->id;
        try{
            $validator = Validator::make(
                $request->all(),
                [
                'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'icon_class' => 'sometimes',
                'url' => 'sometimes',
                'poster' =>app('App\Http\Controllers\Commonfunctions')->getImageNot_sbuposter_val(),
           ],
            [
                'title.required' => 'Title is required',
                'title.max' => 'Title  maximum lenght is 50',
                'title.regex' => 'Invalid characters not allowed for Title',
                'title.exists:\App\Models\Sbutype' => 'unique',

                'poster.dimensions' => 'Image resolution does not meet the requirement. Size of the image should be 640 x 640 (w x h). ',
                'poster.mimes'   => 'Invalid image format',
            ]);
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }
     
            DB::beginTransaction();
            $date = date('dmYH:i:s');
            if(empty($request->Dashboard_view)){
                $Dashboard_view=0;
            }else{
                $Dashboard_view=1;
            }
            $leng=count($request->sel_lang);
            if($request->poster){
                $date = date('dmYH:i:s');
                $imageName = 'Sbutype'. $date . '.' .$request->poster->extension();
                $filename=$imageName;
                $path = $request->file('poster')->storeAs('/uploads/Sbutype/', $imageName, 'myfile');

            }
   
               $storeinfo=new Sbutype([
                   'title'=>$request->title[0],
                   'delet_flag'=>0,
                   'status_id'=>1,
                   'userid'=>$role_id,
                   'iconimage' => $filename,
                   'url'=>$request->url,
                   'iconclass'=>$request->icon_class,
                   'dashboard_view'=>$Dashboard_view,
               ]);
 
               $storedetails=$storeinfo->save();
               $sbutype_id = DB::getPdo()->lastInsertId();
            if( $sbutype_id)
            {
                for($i=0;$i<$leng;$i++){
                    $store_sub_info=new sbutypesub([
                                'languageid'=>$request->sel_lang[$i],
                                'title' =>$request->title[$i],
                                'sbutypeid' => $sbutype_id,
                            ]);
                     $storedetails_sub=$store_sub_info->save();
            }//forloop
            }
            if($storedetails_sub)
            { 
                DB::commit();
                return redirect()->route('sbutype')->with('success','created successfully');
            }else{
               DB::rollback(); 
                return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR');
            }
              
              
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

  /*edit subtype*/
    public function editsbutype($id)
    {
        $id= Crypt::decryptString($id);
    
        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        
        $edit_f = 'E';
        // $keydata = Sbutype::where('id',$id)->first();
        $error = '';
        // $data = Sbutype::where('delet_flag',0)->get();
        $data = Sbutype::with(['sbutypesub' =>function($query){
            // $query->select('alternatetext','subtitle','title')->where('delet_flag',0);
        }])->where('delet_flag',0)->get();
        $keydata = Sbutype::with(['sbutypesub' =>function($query){
            // $query->select('alternatetext','subtitle','title')->where('delet_flag',0);
            $query->with(['lang' => function($query1){

            }]);
        }])->where('delet_flag',0)->where('id',$id)->first();
        // dd($keydata);
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Sbutype', 'message' => 'Sbutype', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
            $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('Master.Sbutype.sbutype', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user','language'));
    }

/*subtype update*/
    public function updatesbutype(Request $request)
    {
        
        try{
            $validator = Validator::make(
                $request->all(),
                [
                'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'icon_class' => 'sometimes',
                'url' => 'sometimes',
                'poster' =>app('App\Http\Controllers\Commonfunctions')->getImageNot_sbuposter_edit_val(),
           ],
            [
                'title.required' => 'Title is required',
                'title.max' => 'Title  maximum lenght is 50',
                'title.regex' => 'Invalid characters not allowed for Title',
                'title.exists:\App\Models\Sbutype' => 'unique',

                'poster.dimensions' => 'Image resolution does not meet the requirement. Size of the image should be 640 x 640 (w x h). ',
                'poster.mimes'   => 'Invalid image format',
            ]);
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }
            // dd($request->all());
            DB::beginTransaction();
            $date = date('dmYH:i:s');
            if(empty($request->Dashboard_view)){
                $Dashboard_view=0;
            }else{
                $Dashboard_view=1;
            }
            $leng=count($request->sel_lang);
            if($request->poster){
                $date = date('dmYH:i:s');
                $imageName = 'Sbutype'. $date . '.' .$request->poster->extension();
                $filename=$imageName;
                $path = $request->file('poster')->storeAs('/uploads/Sbutype/', $imageName, 'myfile');

                $uparr=array(
                    'title'=>$request->title[0],
                    'iconimage' => $filename,
                    'url'=>$request->url,
                    'iconclass'=>$request->icon_class,
                    'dashboard_view'=>$Dashboard_view,
                   );
            }else{
                $uparr=array(
                    'title'=>$request->title[0],
                    'url'=>$request->url,
                    'iconclass'=>$request->icon_class,
                    'dashboard_view'=>$Dashboard_view,
                   );
            }
          
               $res=Sbutype::where('id',$request->hidden_id)->update($uparr);

             
            if($res)
            {
                
                $row_check=Sbutypesub::where('sbutypeid',$request->hidden_id)->first();
                // dd($row_check);
                if($row_check=='')
                {
                    for($i=0;$i<$leng;$i++){
                        $store_sub_info=new sbutypesub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'sbutypeid' => $request->hidden_id,
                                ]);
                         $res2=$store_sub_info->save();
                }//forloop
                }else{
                    for($i=0;$i<$leng;$i++){
                        $update_sub_info=array(
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'sbutypeid' => $request->hidden_id,
                                );
                               
                                $res2=Sbutypesub::where('sbutypeid',$request->hidden_id)->where('languageid',$request->sel_lang[$i])->update($update_sub_info);
                }//forloop
                }
       
            }
            // dd($res2);
            if($res2)
            { 
                DB::commit();
                return redirect()->route('sbutype')->with('success','created successfully');
            }else{
               DB::rollback(); 
                return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR');
            }

               $uparr=array(
                  'title'=>$request->sbutype,
                 );

                 $res=Sbutype::where('id',$request->hidden_id)->update($uparr);
                 $edit_f ='';
                 if($res){
                     return Redirect('sbutype')->with('success','Updated successfully',['edit_f' => $edit_f]);
                 }else{
                     return back()->withErrors('Not Updated ');
                 }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
       
    }
          /*Sbu Status*/
          public function statussbutype($id)
          {
              $id= Crypt::decryptString($id);
              $status=Sbutype::where('id',$id)->value('status_id');
            //   dd($status);
      
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
      
                
                  $res=Sbutype::where('id',$id)->update($uparr);
      
                  $edit_f ='';
                       if($res){
                          DB::commit();
                           return Redirect('sbutype')->with('success','Status updated successfully',['edit_f' => $edit_f]);
                       }else{
                          DB::rollback(); 
                           return back()->withErrors('Not deleted ');
                       }
          }
      /*SBU delete*/
      public function deletesbutype($id)
      {
          $id= Crypt::decryptString($id);

              DB::beginTransaction();
              $imageName = Sbutype::where('id', $id)->select('iconimage')->first();
//    dd($imageName->img);
            //    foreach($imageName as $img){('/uploads/Sbutype/',
                       Storage::disk('myfile')->delete('/uploads/Sbutype/'.$imageName->iconimage);
                //    }
                $res_sub= Sbutypesub::where('sbutypeid',$id)->delete();
             
               if($res_sub)
               {
                $res= Sbutype::findOrFail($id)->delete();
               }

              $edit_f ='';
                   if($res){
                      DB::commit();
                       return Redirect('sbutype')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                   }else{
                      DB::rollback(); 
                       return back()->withErrors('Not deleted ');
                   }
      }

      public function Orderchangesbutypelist_form(Request $request)
    {
        try {
            $id= Crypt::decryptString($request->id);
            $res = Sbutype::where('id', '=', $id)->update(['orderno' => $request->val]);/*dd($request->val);*/
            // 
        } catch (\Exception $exception) {
            /*\LogActivity::addToLog($exception->getMessage());
            $data = \LogActivity::logLatestItem();
            $error = array('er' => 'Please contact admin; the error code is ERROR' . $data->id);
            return view('Siteadmin.dashboard', compact('error'));*/
        } catch (\Throwable $exception) {
            /*\LogActivity::addToLog($exception->getMessage());
            $data = \LogActivity::logLatestItem();
            $error = array('er' => 'Please contact admin; the error code is ERROR' . $data->id);
            return view('Siteadmin.dashboard', compact('error'));*/
        } catch (\Illuminate\Database\QueryException $exception) {

            /*\LogActivity::addToLog($exception->getMessage());
            $data = \LogActivity::logLatestItem();
            return back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);*/
        }
        if ($res) {
            $success = "Status Updated!";
            return response()->json(['html' => $success]);
        } else {
            $error = 'Not updated status';
            return response()->json(['html' => $error]);
        }
    }

    /*keywordtag*/
    public function keywordtag()
    {
        $data = Keywordtag::with(['keytag_sub' =>function($query){

        }])->where('delet_flag',0)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'keywordtag', 'message' => 'keywordtag', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $usertype=usertype::get();

        return view('Master.Keywordtags.keywordtaglist',compact('data','breadcrumbarr','usertype','navbar','user'));
    }

/*Keywordtag create*/
    public function createkeywordtag()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Keywordtag list', 'message' => 'Keywordtag list', 'status' => 1, 'link' => '/keywordtag'),
            2 => array('title' => 'Create Keywordtag', 'message' => 'Create Keywordtag', 'status' => 2)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        return view('Master.Keywordtags.createkeywordtag',compact('breadcrumbarr','language','navbar','user','Navid'));
    }    


        /*Store Keywordtag*/
    
    public function storekeywordtag(Request $request)
    {
        // dd($request->all());
        try{
          $request->validate([
                'sel_lang.*'=>app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'title.*'=>'required',
           ],
            [
                'title.required' => 'Title is required',
                // 'title.min' => 'Title  minimum lenght is 2',
                // 'title.max' => 'Title  maximum lenght is 50',
                // 'title.regex' => 'Invalid characters not allowed for Title',
            ]);
            $request->input();
            $role_id = Auth::user()->id;

            $leng=count($request->sel_lang);
            // dd($leng);

            $storeinfo=new Keywordtag([
                                'userid'=>Auth::user()->id,
                                'delet_flag'=>0,
                                'status_id'=>1,
                            ]);

            $res = $storeinfo->save(); 
            $keyid = DB::getPdo()->lastInsertId();

            for($i=0;$i<$leng;$i++){
              
               
                if($keyid){

                        $store_sub_info=new Keywordtagsub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'keywordtagid' => $keyid,
                                ]);
                         $storedetails_sub=$store_sub_info->save();
                }
                // dd($path);
            }//forloopend

            return redirect()->route('keywordtag')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

 /*edit Keywordtag*/
    public function editkeywordtag($id)
    {

        $id= Crypt::decryptString($id);
        // dd($id);
        $edit_f = 'E';
        $keydata = Keywordtag::with(['keytag_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->where('delet_flag',0)->where('id',$id)->first();
        $error = '';
        $data = Keywordtag::with(['keytag_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
           0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Keywordtag list', 'message' => 'Keywordtag list', 'status' => 1, 'link' => '/keywordtag'),
            2 => array('title' => 'Edit Keywordtag', 'message' => 'Edit Keywordtag', 'status' => 2)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('Master.Keywordtags.createkeywordtag', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','language','user'));
    }

    /*Keyword  update*/
    public function updatekeywordtag(Request $request)
    {
        
        try{
             $request->validate([
                'title.*'=>'required',
            ],
            [
                // 'title.required' => 'Title is required',
                // 'title.min' => 'Title  minimum lenght is 2',
                // 'title.max' => 'Title  maximum lenght is 50',
                // 'title.regex' => 'Invalid characters not allowed for Title',
            ]);
           
            $request->input();


          for ($i=0; $i<count($request->title); $i++) {

           
                 $res=Keywordtagsub::where('keywordtagid',$request->hidden_id)->where('languageid',$request->sel_lang[$i])
                     ->update([
                   'title' =>$request->title[$i],
            ]);

          } //forloopend

        if($res){
            DB::commit();
            return Redirect('keywordtag')->with('success','Updated successfully');
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

      /*Keywordtag delete*/
    public function deletkeywordtag($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
            $res_sub=Keywordtagsub::where('keywordtagid',$id)->delete();
            
             if($res_sub)
             {
                $res= Keywordtag::findOrFail($id)->delete();
             }
               
            $edit_f ='';
                 if($res){
                    DB::commit();
                     return Redirect('keywordtag')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback(); 
                     return back()->withErrors('Not deleted ');
                 }
    }
/**main menu order check */
    public function ordernumbercheckmainmenu(Request $request)
    {
        // dd($request->all());
      $orderno=$request->orderno;
      $viewer_id=$request->viewer_id;
      $sbutype_id=$request->sbutype_id;
      if($viewer_id==1)
      {
        $orderno_status = Mainmenu::where('orderno',$orderno)->where('viewer_id',1)->pluck('orderno');
      }else{
        $orderno_status = Mainmenu::where('orderno',$orderno)->where('viewer_id',2)->where('sbu_type',$sbutype_id)->pluck('orderno');
      }

      $orderno_count=count($orderno_status);
      return response()->json($orderno_count);
    }
/**Sub menu order check */
public function ordernumberchecksubmenu(Request $request)
{
  $orderno=$request->orderno;
  $viewer_id=$request->viewer_id;
  $sbutype_id=$request->sbutype_id;
  if($viewer_id==1)
  {
    $orderno_status = Submenu::where('orderno',$orderno)->where('viewer_id',1)->pluck('orderno');
  }else{
    $orderno_status = Submenu::where('orderno',$orderno)->where('viewer_id',2)->where('sbu_type',$sbutype_id)->pluck('orderno');
  }

  $orderno_count=count($orderno_status);
  return response()->json($orderno_count);
}  
/**Sub sub menu order check */
public function ordernumberchecksubsubmenu(Request $request)
{
  $orderno=$request->orderno;
  $viewer_id=$request->viewer_id;
  $sbutype_id=$request->sbutype_id;
  if($viewer_id==1)
  {
    $orderno_status = subsubmenu::where('orderno',$orderno)->where('viewer_id',1)->pluck('orderno');
  }else{
    $orderno_status = subsubmenu::where('orderno',$orderno)->where('viewer_id',2)->where('sbu_type',$sbutype_id)->pluck('orderno');
  }
  $orderno_count=count($orderno_status);
  return response()->json($orderno_count);
}  

/*Public feedback*/
public function publicfeedback(Request $request)
{
    // $data = Componentpermission::where('delet_flag',0)->get();
    $data=Feedback::get();

    $agent = new Agent;

    $mobileResult = $agent->isMobile();
    if ($mobileResult) {
      $result = 'Mobile';
    }

    $desktopResult= $agent->isDesktop();
    if ($desktopResult) {
      $result = 'Desktop';
    }

    $tabletResult= $agent->isTablet();
    if ($tabletResult) {
      $result = 'isTablet';
    }

    $tabletResult= $agent->isPhone();
    if ($tabletResult) {
      $result = 'isPhone';
    }

    $clientIpAddress = $this->getIp();
    // dd($clientIpAddress);
    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
        1 => array('title' => 'Feed back', 'message' => 'Feed back', 'status' => 1)
     );
    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

    $component=Component::where('delet_flag',0)->get();

    $usertype=usertype::get();

    $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
    
    $count_rating   = Feedback::groupBy('rating')
            ->selectRaw('rating as name, count(rating) as value')
            ->where('closed' ,0)->get()->toArray();
            // ->where('closed' ,0)->get();
             

    return view('Master.Feedback.feedbacklist',compact('data','breadcrumbarr','component','usertype','navbar','user','count_rating'));
}
public function feedbackresponsechart()
{
    $count_rating   = Feedback::groupBy('rating')
    ->selectRaw('rating as name, count(rating) as value')
    ->where('closed' ,0)->get();
    // $datas=Feedback::get();
    // $data = Feedback::get()->groupBy('rating');
    // $count_rating   = Feedback::groupBy('rating')
    //     ->selectRaw('rating, count(rating) as rating')
    //     ->where('closed' ,0)->get();

    return response()->json($count_rating);
}
}