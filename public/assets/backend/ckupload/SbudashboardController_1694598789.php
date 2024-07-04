<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

use App\Imports\Importgengrowth;
use App\Imports\Importtransmdistabst;
use App\Imports\Importsectioncontactus;

use App\Models\dashboardcategory;
use App\Models\Sbutype;
use App\Models\usertype;
use App\Models\Language;
use App\Models\Componentpermission;
use App\Models\dashboardcategorysub;
use App\Models\Sectioncontact;
use App\Models\Dashboardtransmdistribabst;

use \Crypt;
use DB;
use Redirect;

class SbudashboardController extends Controller
{
     /** Dashboard category start */
     public function dashboardcategory()
     {
         $data = dashboardcategory::with(['dashboardcategorie_sub' =>function($query){
             
         }])->with(['sbutypesub' => function($query){

         }])->get();
 
 
         $breadcrumb = array(
             0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
             1 => array('title' => 'Dashboard category type', 'message' => 'Dashboard category type', 'status' => 1)
          );
         $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
         $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
         $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        
         $usertype=usertype::get();
 
         return view('Planning.Dashboardcategory.dashboardcategorylist',compact('data','breadcrumbarr','usertype','navbar','user'));
     }
     
 
     /*Dashboard cate create*/
     public function createdashboardcategory()
     {
 
         $language = Language::where('delet_flag',0)->orderBy('name')->get();
 
         $breadcrumb = array(
             0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
             1 => array('title' => 'Dashboard category', 'message' => 'Dashboard category', 'status' => 0, 'link' => '/planning/dashboardcategory'),
             2 => array('title' => 'Create Dashboard category', 'message' => 'Create Dashboard category', 'status' => 1)
          );
         $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
         $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
         $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
         $url = url()->previous();
         $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
         $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
         
         $Sbu_s = Sbutype::with(['sbutypesub' =>function($query){
             
         }])->where('dashboard_view',1)->get();
 // dd($Sbu_s);
         return view('Planning.Dashboardcategory.createdashboardcategory',compact('breadcrumbarr','language','navbar','user','Navid','Sbu_s'));
     }
 
     /*store dashboardcategory*/
     public function storedashboardcategory(Request $request)
     {

         try{
           $request->validate([
                 'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                 'tablename'=>app('App\Http\Controllers\Commonfunctions')->tablenameval(),
                 
            ],
             [
                 'title.required' => 'Title is required',
                 'title.min' => 'Title  minimum lenght is 2',
                 'title.max' => 'Title  maximum lenght is 50',
                 'title.regex' => 'Invalid characters not allowed for Title',

                 'tablename.required' => 'tablename is required',
                 'tablename.regex' => 'Invalid characters not allowed for tablename',
             ]);
             $request->input();
             $role_id = Auth::user()->id;
             DB::beginTransaction();
             $leng=count($request->sel_lang);
      
                if($request->upload_temp){
                    $date = date('dmYH:i:s');
                    $imageName = 'upload_temp'. $date . '.' .$request->upload_temp->extension();
                    $filename=$imageName;
                    $path = $request->file('upload_temp')->storeAs('/uploads/Exceldashboard/', $imageName, 'myfile');
                    $orgName = $request->file('upload_temp')->getClientOriginalName() ;
                }
          
             $storeinfo=new dashboardcategory([
                                 'users_id'=>$role_id,
                                 'status_id'=>1,
                                 'sbutype_id'=>$request->sbu,
                                 'tablename'=>$request->tablename,
                                 'upload_temp' => $filename,
                                 'org_name'=>$orgName,
                             ]);

 
             $res = $storeinfo->save(); 
             $cat_id = DB::getPdo()->lastInsertId();
 // dd($milestoneid);
             for($i=0;$i<$leng;$i++){
               
                 if($cat_id){
             
                         $store_sub_info=new dashboardcategorysub([
                                     'languageid'=>$request->sel_lang[$i],
                                     'title' =>$request->title[$i],
                                     'das_cat_id' => $cat_id,
                                 ]);
                       
                          $storedetails_sub=$store_sub_info->save();
                 }
                 // dd($path);
             }//forloopend


             if($storedetails_sub)
             {
                DB::commit();
                return redirect()->route('planning.dashboardcategory')->with('success','created successfully');
               
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


    /*edit Dashboard catgry*/
    public function editdashboardcatgry($id)
    {
        $id= Crypt::decryptString($id);//History::with(['historysub
        $edit_f = 'E';
        $keydata = dashboardcategory::with(['dashboardcategorie_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->where('id',$id)->first();
        $error = '';
        $data = dashboardcategory::with(['dashboardcategorie_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->get();

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Dashboardcategory', 'message' => 'Dashboardcategory', 'status' => 0, 'link' => '/planning/dashboardcategory'),
            2 => array('title' => 'Edit Dashboardcategory', 'message' => 'Edit Dashboardcategory', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
                 
        $Sbu_s = Sbutype::with(['sbutypesub' =>function($query){
             
        }])->where('dashboard_view',1)->get();
// dd($keydata);
        return view('Planning.Dashboardcategory.createdashboardcategory', compact('Sbu_s','data','edit_f', 'error','keydata','breadcrumbarr','navbar','user','language','Navid'));
    }

 /*update dashboardcategory*/
 public function updatdashboardcategory(Request $request)
 {
// dd($request->all());
     try{
       $request->validate([
             'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
             'tablename'=>app('App\Http\Controllers\Commonfunctions')->tablenameval(),
        ],
         [
             'title.required' => 'Title is required',
             'title.min' => 'Title  minimum lenght is 2',
             'title.max' => 'Title  maximum lenght is 50',
             'title.regex' => 'Invalid characters not allowed for Title',

             'tablename.required' => 'tablename is required',
             'tablename.regex' => 'Invalid characters not allowed for tablename',
         ]);
         $request->input();
         $role_id = Auth::user()->id;
         DB::beginTransaction();
         $leng=count($request->sel_lang);
      
         if(isset($request->upload_temp)){
            $date = date('dmYH:i:s');
            $imageName = 'upload_temp'. $date . '.' .$request->upload_temp->extension();
            $filename=$imageName;
            $path = $request->file('upload_temp')->storeAs('/uploads/Exceldashboard/', $imageName, 'myfile');
            $orgName = $request->file('upload_temp')->getClientOriginalName() ;

            $storeinfo=array(
                'users_id'=>$role_id,
                'status_id'=>1,
                'sbutype_id'=>$request->sbu,
                'tablename'=>$request->tablename,
                'upload_temp' => $filename,
                'org_name'=>$orgName,
            );

        }else{
            $storeinfo=array(
                'users_id'=>$role_id,
                'status_id'=>1,
                'sbutype_id'=>$request->sbu,
                'tablename'=>$request->tablename,
            );
        }
        

                         $res1=dashboardcategory::where('id','=',$request->hidden_id)->update($storeinfo);

// dd($milestoneid);
         for($i=0;$i<$leng;$i++){
           
             if($res1){
         
                     $store_sub_info=array(
                                 'languageid'=>$request->sel_lang[$i],
                                 'title' =>$request->title[$i],
                                 'das_cat_id' => $request->hidden_id,
                             );
                             $storedetails_sub=dashboardcategorysub::where('das_cat_id','=',$request->hidden_id)->where('languageid','=',$request->sel_lang[$i])->update($store_sub_info);

             }
             // dd($path);
         }//forloopend
         
         if($storedetails_sub)
         {
            DB::commit();
            return redirect()->route('planning.dashboardcategory')->with('success','created successfully');
           
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

 /*Dashboard catgry Status*/
public function statusdashboardcatgry($id)
{
    $id= Crypt::decryptString($id);
    $status=dashboardcategory::where('id',$id)->value('status_id');
  
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
    $res=dashboardcategory::where('id',$id)->update($uparr);
  
    $edit_f ='';
    if($res){
        DB::commit();
        return redirect()->route('planning.dashboardcategory')->with('success','created successfully');
      
    }else{
        DB::rollback(); 
        return back()->withErrors('Not deleted ');
    }
      }

      /*deletedashboardcatgry delete*/
public function deletedashboardcatgry($id)
{
    $id= Crypt::decryptString($id);

        DB::beginTransaction();

         $res_sub= dashboardcategorysub::where('das_cat_id',$id)->delete();
      
        if($res_sub)
        {
         $res= dashboardcategory::findOrFail($id)->delete();
        }
        $edit_f ='';
             if($res){
                DB::commit();
                return redirect()->route('planning.dashboardcategory')->with('success','created successfully');

              
             }else{
                DB::rollback(); 
                 return back()->withErrors('Not deleted ');
             }
}
     /** Dashboard category end */


    /*Dashboard start */

    public function sbudashboard(Request $request)
    {
        $breadcrumb = array(
             0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
             1 => array('title' => 'Dashboard', 'message' => 'Dashboard', 'status' => 1)
          );
        // $data = Dashboardtransmdistribabst::with(['dashboardcategorie_sub' =>function($query){
        //     $query->where('languageid',1);
        // }])->with(['sbutypesub' => function($query1){
        //     $query1->where('languageid',1);
        // }])->get();  
        $org_table_details_collection=array();
        $tablename = dashboardcategory::select('tablename')->get();
        foreach($tablename as $tablenames){
           
            $org_table_name =$tablenames->tablename;
 
            $org_table_details=DB::table($org_table_name)
            ->join('sbutypesubs','sbutypesubs.sbutypeid',$org_table_name.'.sbutype_id')
            ->join('dashboardcategorysubs','dashboardcategorysubs.das_cat_id',$org_table_name.'.dashboard_cat_id')
            ->join('dashboardcategories','dashboardcategories.id',$org_table_name.'.dashboard_cat_id')
            ->where('sbutypesubs.languageid',1)
            ->where('dashboardcategorysubs.languageid',1)
            ->select('sbutypesubs.title as sbuname','dashboardcategorysubs.title as dascatgry','year',$org_table_name.'.id as id','tablename')
            ->get();
        $org_table_details_collection[]=$org_table_details;
           
        }

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $usertype=usertype::get();

        return view('Planning.Dashboard.dashboardlist',compact('breadcrumbarr','navbar','user','usertype','org_table_details','org_table_details_collection'));
    }

    public function details_dashboard_catgry(Request $request)
    { 
      $id=$request->id;
      $org_table_name=$request->tablename;
    //   $data=DB::table($org_table_name)
    //         ->join('sbutypesubs','sbutypesubs.sbutypeid',$org_table_name.'.sbutype_id')
    //         ->join('dashboardcategorysubs','dashboardcategorysubs.das_cat_id',$org_table_name.'.dashboard_cat_id')
    //         ->join('dashboardcategories','dashboardcategories.id',$org_table_name.'.dashboard_cat_id')
    //         ->where('sbutypesubs.languageid',1)
    //         ->where('dashboardcategorysubs.languageid',1)
    //         ->where($org_table_name.'.id',$id)->first();

      if($org_table_name='dashboardtransmdistabst')
      {
        $data=Dashboardtransmdistribabst::with(['dashboardcategorie_sub' =>function($query){
                $query->where('languageid',1);
            }])->with(['sbutypesub' => function($query1){
                $query1->where('languageid',1);
                // $query1->select('title as sbuname');
            }])->where('id',$id)->get();
      }else if($org_table_name='gengrowthdashboards'){
        $data=Gengrowthdashboard::with(['dashboardcategorie_sub' =>function($query){
                $query->where('languageid',1);
            }])->with(['sbutypesub' => function($query1){
                $query1->where('languageid',1);
            }])->where('id',$id)->first();
      }
        return response()->json($data);
    }

    public function createdashboard()
     {
 
         $language = Language::where('delet_flag',0)->orderBy('name')->get();
 
         $breadcrumb = array(
             0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
             1 => array('title' => 'Dashboard', 'message' => 'Dashboard', 'status' => 0, 'link' => '/planning/sbudashboard'),
             2 => array('title' => 'Create Dashboard', 'message' => 'Create Dashboard', 'status' => 1)
          );
         $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
         $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
         $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
         $url = url()->previous();
         $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
         $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
         
         $Sbu_s = Sbutype::with(['sbutypesub' =>function($query){
             
         }])->where('dashboard_view',1)->get();
 // dd($Sbu_s);
         return view('Planning.Dashboard.createdashboard',compact('breadcrumbarr','language','navbar','user','Navid','Sbu_s'));
     }

     public function sbuwisedashboardcategory(Request $request)
     { 
        $sbutype_id=$request->sbutype_id;
        $sbutype_id=$request->sbutype_id;
        $dashborad_cat = dashboardcategory::with(['dashboardcategorie_sub' =>function($query){
            $query->where('languageid',1);
        }])->where('sbutype_id',$sbutype_id)->get();
   
       return response()->json($dashborad_cat);
     }


     public function growth_kerala_gen_import(Request $request)
     { //dd($request->all());
        if($request->sel_table=='dashboardtransmdistabst'){
            Excel::import(new Importtransmdistabst, request()->file('excel_imp'));
        } else {
            Excel::import(new Importgengrowth, request()->file('excel_imp'));
        }
        
            
        //return back();
     }

     public function detailscategorydashboard(Request $request)
     {
        
        $sbutype_id=$request->sbutype_id;
        $dash_cat_id=$request->dash_cat_id;
        $dashborad_cat = dashboardcategory::with(['dashboardcategorie_sub' =>function($query) use ($dash_cat_id){
            $query->where('languageid',1);
            
        }])->where('sbutype_id',$sbutype_id)->where('das_cat_id',$dash_cat_id)->where('status_id',1)->first();
   
       return response()->json($dashborad_cat);
     }
     
     /*Dashboard end */

/** Section contact us start */
public function sectioncontactus()
{
    $data = Sectioncontact::get();


    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/planninghome'),
        1 => array('title' => 'Section contact us', 'message' => 'Section contact us', 'status' => 1)
     );
    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
    $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
   
    $usertype=usertype::get();

    return view('Planning.Sectioncontactus.sectioncontactuslist',compact('data','breadcrumbarr','usertype','navbar','user'));
}

public function createsectioncontactus()
{

    $language = Language::where('delet_flag',0)->orderBy('name')->get();

    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/planninghome'),
        1 => array('title' => 'Section contact us', 'message' => 'Section contact us', 'status' => 0, 'link' => '/planning/sectioncontactus'),
        2 => array('title' => 'Create Section contact us', 'message' => 'Create Section contact us', 'status' => 1)
     );
    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
    $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
    $url = url()->previous();
    $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
    $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
    
    $Sbu_s = Sbutype::with(['sbutypesub' =>function($query){
        
    }])->where('dashboard_view',1)->get();
// dd($Sbu_s);
    return view('Planning.Sectioncontactus.createsectioncontactus',compact('breadcrumbarr','language','navbar','user','Navid','Sbu_s'));
}


public function store_sectioncontactus(Request $request)
{ //dd($request->all());
   
    Excel::import(new Importsectioncontactus, $request->file('excel_imp')->store('excel_imp'));
    // return redirect()->back(); 
    return redirect()->route('planning.sectioncontactus')->with('success','created successfully');
   //return back();
}


public function details_section(Request $request)
{
    $data = Sectioncontact::where('id',$request->id)->first();
  return response()->json($data);
}
public function editsectioncontactus($id)
{
    
    $id= Crypt::decryptString($id);
    $edit_f = 'E';
    $keydata = Sectioncontact::where('id',$id)->first();
    $error = '';
    $data = Sectioncontact::get();

    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/planninghome'),
        1 => array('title' => 'Section contact us', 'message' => 'Section contact us', 'status' => 0, 'link' => '/planning/sectioncontactus'),
        2 => array('title' => 'Edit Section contact us', 'message' => 'Edit Section contact us', 'status' => 1)
     );

    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
    $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
    return view('Planning.Sectioncontactus.editsectioncontactus', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user'));
}
/*section contact us  update*/
public function updatesectioncontactus(Request $request)
{
    // dd($request->all());
    try{
        $validator = Validator::make(
            $request->all(),
            [
            'section_code' =>'required'
       ],
        [
            'section_code.required' => 'Section code is required',
        ]);
        if ($validator->fails()) {
            // dd($validator->errors());
            return back()->withInput()->withErrors($validator->errors());
        }
           $uparr=array(
              'section_code'=>$request->section_code,
              'section_name'=>$request->section_name,
              'office_CUG'=>$request->office_CUG,
              'phone_number_sec_office'=>$request->phone_number_sec_office,
              'emailID_sec_office'=>$request->emailID_sec_office,
              'Sub_division'=>$request->Sub_division,
              'emailID_sub_division'=>$request->emailID_sub_division,
              'division'=>$request->division,
              'phone_number_division'=>$request->phone_number_division,
              'emailID_division'=>$request->emailID_division,
              'circle'=>$request->circle,
              'phone_number_circle'=>$request->phone_number_circle,
              'emailID_circle'=>$request->emailID_circle,
              'region'=>$request->region,
             );

             $res=Sectioncontact::where('id',$request->hidden_id)->update($uparr);
             $edit_f ='U';
             if($res){
                 return Redirect('/planning/sectioncontactus')->with('success','Updated successfully',['edit_f' => $edit_f]);
             }else{
                 return back()->withErrors('Not Updated ');
             }
    } catch (ModelNotFoundException $exception) {
        \LogActivity::addToLog($exception->getMessage(),'error');
        $data = \LogActivity::logLatestItem();
        return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
    }
   
}
/** Section contact us end */
}
