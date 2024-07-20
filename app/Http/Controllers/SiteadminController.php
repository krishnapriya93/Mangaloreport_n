<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Component;
use App\Models\Componentpermission;
use App\Models\user;
use App\Models\Banner;
use App\Models\Banner_sub;
use App\Models\Language;
use App\Models\Gallery;
use App\Models\usertype;
use App\Models\Socialmedia;
use App\Models\Socialmedia_sub;
use App\Models\Contactus;
use App\Models\Contactus_sub;
use App\Models\Whatsnew;
use App\Models\Whatsnewsub;
use App\Models\Functionalunit;
use App\Models\Functionalunitsub;
use App\Models\Sectionoffice;
use App\Models\Sectionofficesub;
use App\Models\Shortalert;
use App\Models\Shortalertsub;
use App\Models\Download;
use App\Models\Downloadsub;
use App\Models\Downloadtype;
use App\Models\Counter;
use App\Models\Countersub;
use App\Models\Gallerytype;
use App\Models\Menulinktype;
use App\Models\Customerservice;
use App\Models\Customerservicesub;
use App\Models\Link;
use App\Models\Linksub;
use App\Models\Linktype;
use App\Models\Pressrelase;
use App\Models\Pressrelasesub;
use App\Models\Logotype;
use App\Models\Logo;
use App\Models\Logo_sub;
use App\Models\Downloaditems;
use App\Models\Sbutype;
use App\Models\mainbackground;
use App\Models\Keywordtag;
use App\Models\Sitecontrollabel;
use App\Models\Sitecontrollabelsub;
use App\Models\Mainmenusub;
use App\Models\Article;
use App\Models\Widgetposition;
use App\Models\Articletype;
use App\Models\Articlesub;
use App\Models\Submenu;
use App\Models\Mainmenu;
use App\Models\GallerySub;
use App\Models\GallerySubItems;
use App\Models\Midwidget;
use App\Models\Midwidgetsub;
use App\Models\Submenusub;
use \Crypt;
use DB;
use Redirect;

class SiteadminController extends Controller
{

      /*Siteadmin dashboard*/
    public function siteadminhome(Request $request)
    {
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $role_id = Auth::user()->id;
        $userIp   = $request->ip();
        $carddata = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();

        return view('backend.siteadmin.siteadminhome',compact('navbar','user','userIp','carddata'));
    }


    public function articlelist(Request $request, $encid=null)
    {
        // $id=\Crypt::decryptString($encid);
        $id=$encid;
        $role_type=Auth::user()->role_id;
    //  dd($role_type);
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Article', 'message' => 'Article', 'status' => 1,'id'=>$id)
        );

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar     = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        // $navid=$request->navid;
        // dd($navid);
        $role_id    = Auth::user()->id;
        $user       = app('App\Http\Controllers\Commonfunctions')->userinfo();


        $language   = Language::where('delet_flag',0)->orderBy('name')->get();
    //     $resultdata = Logo::with(['logotypes' => function($query){
    //         $query->select('id','title');
    //    }])->get();
        $data       = Article::with(['articleval_sub'=>function($query){

        }])->get();
        // $widgetPosition=Widgetposition::get();
        $keywordtags=Keywordtag::with(['keytag_sub'=>function($query){}])->get();
        $usertype = usertype::where('delet_flag',0)->whereIn('id',[8,9])->where('status_id',1)->get();
        // $keywordtags=array();

        // dd($sbu_type);
        $role_id_multi =Auth::user()->id;

        $arttype =   Articletype::with(['articletype_sub'=>function($query){
            $query->where('languageid', 1);
        }])->where('status_id',1)->where('delet_flag',0)->get();

        return view('backend.siteadmin.Article.article',compact('breadcrumbarr','navbar','user','language','data','arttype','keywordtags','usertype'));
    }
    public function createarticle(Request $request, $encid=null)
    {
        // $id=\Crypt::decryptString($encid);
        $id=$encid;
        $role_type=Auth::user()->role_id;
    //  dd($role_type);
    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
        1 => array('title' => 'Article list', 'message' => 'Article list', 'status' => 0, 'link' => '/siteadmin/articlelist'),
        2 => array('title' => 'Article', 'message' => 'Article', 'status' => 1,'id'=>$id)
    );

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar     = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        // $navid=$request->navid;
        // dd($navid);
        $role_id    = Auth::user()->id;
        $user       = app('App\Http\Controllers\Commonfunctions')->userinfo();


        $language   = Language::where('delet_flag',0)->orderBy('name')->get();
    //     $resultdata = Logo::with(['logotypes' => function($query){
    //         $query->select('id','title');
    //    }])->get();
        $data       = Article::with(['articleval_sub'=>function($query){

        }])->where('users_id',Auth::user()->id)->get();
        // $widgetPosition=Widgetposition::get();
        $keywordtags=Keywordtag::with(['keytag_sub'=>function($query){}])->get();
        $usertype = usertype::where('delet_flag',0)->whereIn('id',[8,9])->where('status_id',1)->get();
        // $keywordtags=array();
        // $sbu_type=Auth::user()->sbutype;
        // dd($sbu_type);


        $arttype =   Articletype::with(['articletype_sub'=>function($query){
            $query->where('languageid', 1);
        }])->where('status_id',1)->where('delet_flag',0)->get();



        // $editF='A';
        return view('backend.siteadmin.Article.createarticle',compact('breadcrumbarr','navbar','user','language','data','arttype','keywordtags','usertype'));
    }


    public function storearticle(Request $request)
    {
        // dd($request->all());
        $role_type=Auth::user()->role_id;

            $validator = Validator::make(
                $request->all(),
                [
                    'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                    'sub_title.*'   => 'sometimes',
                    'con_title.*'   => app('App\Http\Controllers\Commonfunctions')->getEntitlereg_ckedit(),
                    // 'poster.*'      => app('App\Http\Controllers\Commonfunctions')->article_imgae_upload(),
                    'poster'      =>'sometimes',
                    'usertype'      =>'sometimes',
                    'alt_title.*'   => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),

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

                    'con_title.required' => 'Content is required',
                    'con_title.regex'    => 'The Content format is invalid',
                    'con_title.min'      => 'Content  minimum length is 3',
                    'con_title.max'      => 'Content  maximum length is 3000',

                    'poster.dimensions' => 'Image resolution does not meet the requirement. Size of the image should be 960 x 960 (w x h). ',
                    'poster.mimes'   => 'Invalid image format',

                ]
            );

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        try{
           if($request->usertype == null)
           {
            $usertype=0;
           }else{
            $usertype=\Crypt::decryptString($request->usertype);
           }

        $i=0;
        $filename=array();


                if(isset($request->poster)){

                    foreach($request->poster as $filep){

                        if($i<count($request->poster)){
                            $date = date('dmYH:i:s');
                            $imageName = 'articles'.$i. $date . '.' .$filep->extension();
                            $filename[]=$imageName;
                            $path = $request->file('poster')[$i]->storeAs('/assets/backend/uploads/articles/', $imageName, 'myfile');
                            $i++;
                        }
                    }
                }


                $dataarr=new Article([
                    'articletype_id'=>\Crypt::decryptString($request->articleType),
                    'usertype'=>$usertype,
                    'users_id'=>Auth::user()->id,
                    'delet_flag'=>0,
                    'status_id'=>1
                ]);
                // dd($dataarr);
                $res=$dataarr->save();
                if($res){
                    $art_id=$dataarr->id;
                    $lang=Language::where('status_id',1)->get();
                    $i=0;
                    // dd($request->con_title);
                    foreach($lang as $lng){

                            if(isset($filename[$i])){
                                $dataarr1=new Articlesub([
                                    'articleid'=>$art_id,
                                    'file'=>$filename[$i],
                                    'languageid'=>$lng->id,
                                    'title'=>$request->title[$i],
                                    'tags_id'=>\Crypt::decryptString($request->tags_id[$i]),
                                    'subtitle'=>$request->sub_title[$i],
                                    'content'=>$request->con_title[$lng->id],
                                    'alt'=>$request->alt_title[$i]
                                ]);
                            }else{
                                $dataarr1=new Articlesub([
                                    'articleid'=>$art_id,
                                    'languageid'=>$lng->id,
                                    'title'=>$request->title[$i],
                                    'tags_id'=>\Crypt::decryptString($request->tags_id[$i]),
                                    'subtitle'=>$request->sub_title[$i],
                                    'content'=>$request->con_title[$lng->id],
                                    'alt'=>$request->alt_title[$i]
                                ]);
                            }

                            $res1=$dataarr1->save();
                            if($i<count($lang)){
                                $i++;
                            }
                        // }else{
                        //     return back()->withInput()->with('error',"Already existing");

                        // }



                    }
                    $success="Saved successfully";

                         return redirect('/siteadmin/articlelist')->with(['success' => $success]);




                }else{
                    return back()->withInput()->with('error',"Error while saving");
                }
            // }
        }catch(Exception $e){
            return back()->withInput()->with('error',$e);
        }


    }
    public function deletearticle(Request $request,$encid){
        $id=\Crypt::decryptString($encid);
        try{
            $imageName = Articlesub::where('articleid', $id)->select('file')->get();
            foreach($imageName as $img){
                Storage::disk('myfile')->delete('/uploads/articles/' . $img->file);
            }

            $dataartSub=Articlesub::where('articleid',$id)->delete();
            $dataEdit=Article::destroy($id);
            $msg="Deleted successfully";

            return redirect('/siteadmin/articlelist')->with(['delete' => $msg]);


        }catch(Exception $e){
            return back()->withInput()->with('error',$e);
        }

    }
    public function editarticle(Request $request, $encid=null)
    {
        $id=\Crypt::decryptString($encid);
        // $id=$encid;
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Article list', 'message' => 'Article list', 'status' => 0, 'link' => '/siteadmin/articlelist'),
            2 => array('title' => 'Article', 'message' => 'Article', 'status' => 1,'id'=>$id)
        );

        $usertype = usertype::where('delet_flag',0)->whereIn('id',[8,9])->where('status_id',1)->get();
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar     = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        // $navid=$request->navid;
        // dd($navid);
        $role_id    = Auth::user()->role_id;
        $user       = app('App\Http\Controllers\Commonfunctions')->userinfo();


        $language   = Language::where('delet_flag',0)->orderBy('name')->get();
    //     $resultdata = Logo::with(['logotypes' => function($query){
    //         $query->select('id','title');
    //    }])->get();
        $dataEdit       = Article::with(['articleval_sub'=>function($query){

            }])->where('id',$id)->first();
            // dd($dataEdit);
        $data       = Article::with(['articleval_sub'=>function($query){

        }])->get();

        $editF='E';

        $keywordtags=Keywordtag::with(['keytag_sub'=>function($query){}])->get();

        $role_type=Auth::user()->role_id;

        $arttype =   Articletype::with(['articletype_sub'=>function($query){
            $query->where('languageid', 1);
        }])->where('status_id',1)->where('delet_flag',0)->get();


        return view('backend.siteadmin.Article.createarticle',compact('breadcrumbarr','navbar','user','language','data','arttype','usertype','keywordtags','dataEdit','editF'));
    }
    public function updatearticle(Request $request)
    {
        // dd($request->all());
        $id=\Crypt::decryptString($request->EditId);
        $role_type=Auth::user()->role_id;

            $validator = Validator::make(
                $request->all(),
                [
                    'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                    'sub_title.*'   => 'sometimes',
                    'con_title.*'   => app('App\Http\Controllers\Commonfunctions')->getEntitlereg_ckedit(),
                    // 'poster.*'      => app('App\Http\Controllers\Commonfunctions')->article_imgae_upload(),
                    'poster'      =>'sometimes',
                    'usertype'      =>'sometimes',
                    'alt_title.*'   => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),

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

                    'con_title.required' => 'Content is required',
                    'con_title.regex'    => 'The Content format is invalid',
                    'con_title.min'      => 'Content  minimum length is 3',
                    'con_title.max'      => 'Content  maximum length is 3000',

                    'poster.dimensions' => 'Image resolution does not meet the requirement. Size of the image should be 960 x 960 (w x h). ',
                    'poster.mimes'   => 'Invalid image format',

                ]
            );


        if ($validator->fails()) {
            // dd($validator->errors());
            return back()->withInput()->withErrors($validator->errors());
        }
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
                                $imageName = 'articles'.$i. $date . '.' .$filep->extension();
                                $filename[]=$imageName;
                                $path = $request->file('poster')[$i]->storeAs('/assets/backend/uploads/articles/', $imageName, 'myfile');
                            }else{
                                $j=$i+1;
                                $date = date('dmYH:i:s');
                                $imageName = 'articles'.$i. $date . '.' .$filep->extension();
                                $filename[]=$imageName;
                                $path = $request->file('poster')[$j]->storeAs('/assets/backend/uploads/articles/', $imageName, 'myfile');
                            }



                            $i++;
                        }

                        // echo 'hi'.$i;
                        // $i++;
                    }
                }

            // dd($homePage_status);
                $dataarr=array(


                    'articletype_id'=>\Crypt::decryptString($request->articleType),
                    'users_id'=>Auth::user()->id,
                    'delet_flag'=>1,
                    'status_id'=>1
                );
                // dd($dataarr);
                $res=Article::where('id','=',$id)->update($dataarr);
                if($res){
                    $art_id=$id;
                    $lang=Language::where('status_id',1)->get();
                    $i=0;
                    foreach($lang as $lng){
                        // dd(count($lang));
                        $chekrows = Articlesub::where('articleid','=', $id)->exists() ? 1 : 0;
                        $countart=Articlesub::where('articleid','=',$id)->count();
                        $artsubval=Articlesub::where('articleid','=',$id)->where('languageid','=',$lng->id)->first();

                        // dd( $artsubval->languageid);
                        // dd($id);
                        // if($chekrows==0){
                            if($chekrows==1){
                            // if(!isset($artsubval->languageid)){
                                // echo $i.' :: lang '.$lng->id.' :::: '.$filename[$i];
                                if(!empty($filename[$i])){
                                    $dataarr1=array(
                                        // 'articleid'=>$art_id,
                                        'file'=>$filename[$i],
                                        'languageid'=>$lng->id,
                                        'title'=>$request->title[$i],
                                        'tags_id'=>\Crypt::decryptString($request->tags_id[$i]),
                                        'subtitle'=>$request->sub_title[$i],
                                        'content'=>$request->con_title[$lng->id],
                                        'alt'=>$request->alt_title[$i]
                                    );
                                }else{
                                    $dataarr1=array(
                                        // 'articleid'=>$art_id,
                                        // 'file'=>$filename[$i],
                                        'languageid'=>$lng->id,
                                        'title'=>$request->title[$i],
                                        'tags_id'=>\Crypt::decryptString($request->tags_id[$i]),
                                        'subtitle'=>$request->sub_title[$i],
                                        'content'=>$request->con_title[$lng->id],
                                        'alt'=>$request->alt_title[$i]
                                    );
                                }

                                $res1=Articlesub::where('articleid','=',$id)->where('languageid','=',$lng->id)->update($dataarr1);
                                if($i<count($lang)){
                                    $i++;
                                }


                        }else{
                            return back()->withInput()->with('error',"Already existing");

                        }



                    }
                    // dd(true);
                    $success="Saved successfully";
                    return redirect('/siteadmin/articlelist')->with(['success' => $success]);


                }else{
                    return back()->withInput()->with('error',"Error while saving");
                }
            // }
        }catch(Exception $e){
            return back()->withInput()->with('error',$e);
        }


    }
    /*Banner*/
    public function banner()
    {
        $role_id=Auth::user()->role_id;

        if($role_id==5)//SBU admin
        {
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
                1 => array('title' => 'Banner', 'message' => 'Banner', 'status' => 1)
             );
        }else if($role_id==2){//Site admin
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
                1 => array('title' => 'Banner', 'message' => 'Banner', 'status' => 1)
             );
        }
        $data = Banner::with(['banner_sub' =>function($query){
            // $query->select('alternatetext','subtitle','title')->where('delet_flag',0);
        }])->where('userid',Auth::user()->id)->get();
        // dd($data);

        $language = Language::where('delet_flag',0)->orderBy('name')->get();


        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.siteadmin.Banner.banner',compact('data','breadcrumbarr','language','navbar','user'));
    }

    /*Banner create*/
    public function createbanner()
    {
        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        // $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();

        $role_id=Auth::user()->role_id;

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Banner', 'message' => 'Banner', 'status' => 0, 'link' => '/siteadmin/banner'),
            2 => array('title' => 'Create Banner', 'message' => 'Create Banner', 'status' => 1)
         );

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        return view('backend.siteadmin.Banner.createbanner',compact('breadcrumbarr','language','navbar','user','Navid'));
    }

    /*Store banner*/
      public function storebanner(Request $request)
    {

        $role_id = Auth::user()->id;
        // dd($role_id);

        try{

                $validator = Validator::make(
                    $request->all(),
                    [
                        'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                        'sub_title.*'   => 'sometimes',
                        'alt_title.*'   => 'sometimes',
                        'poster.*'      => 'required',
                   ],[
                        'title.required' => 'Title is required',
                        'title.min' => 'Title  minimum lenght is 2',
                        'title.max' => 'Title  maximum lenght is 50',
                        'title.regex' => 'Invalid characters not allowed for Title',

                        'sub_title.required' => 'Sub title text is required',
                        'sub_title.min' => 'Sub title text  minimum lenght is 2',
                        'sub_title.max' => 'Sub title text  maximum lenght is 50',
                        'sub_title.regex' => 'Invalid characters not allowed for Sub title text',

                        'alt_title.required' => 'Alternative text is required',
                        'alt_title.min' => 'Alternative text  minimum lenght is 2',
                        'alt_title.max' => 'Alternative text  maximum lenght is 50',
                        'alt_title.regex' => 'Invalid characters not allowed for alternative text',

                        // 'poster.dimensions' => 'Image resolution does not meet the requirement. Size of the image should be 1090 x 400 (w x h). ',
                        // 'poster.mimes'   => 'Invalid image format',
                        'poster.required'   => ' image required',

                    ]);


            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }


            $leng=count($request->sel_lang);
            $filename=array();

            $storeinfo=new Banner([
                                'userid'=>Auth::user()->id,
                                'sbutype_id'=>Auth::user()->sbutype,
                                'url' =>$request->url,
                                'delet_flag'=>0,
                                'status_id'=>1,
                           ]);

            $res = $storeinfo->save();
            $banner_id = DB::getPdo()->lastInsertId();



                if($banner_id){
                     $date = date('dmYH:i:s');
                        $j=0;
                        $filename=array();
                        foreach($request->poster as $filep){


                            // print_r($request->file('poster')[$i]);
                        //    dd($filep->poster[$i]->extension());
                        // dd(count($request->poster));
                            // $imageName = 'logo' . $date . '.' .$filep->poster->extension();
                            if($j<count($request->poster)){
                                $date = date('dmYH:i:s');
                                $imageName = 'Banner'.$j. $date . '.' .$filep->extension();
                                $filename[]=$imageName;
                                $path = $request->file('poster')[$j]->storeAs('/assets/backend/uploads/banner/', $imageName, 'myfile');

                                $j++;

                            }
                        }

                for($i=0;$i<$leng;$i++){
                        $store_sub_info=new Banner_sub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'subtitle' =>$request->sub_title[$i],
                                    'alternatetext' =>$request->alt_title[$i],
                                    'poster' => $filename[$i],
                                    'bannerid' => $banner_id,
                                    'delet_flag'=>0,
                                    'status_id'=>1,
                                ]);
                         $storedetails_sub=$store_sub_info->save();
                }//forloop
                // dd($path);
            }//bannerid
            return redirect()->route('banner')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

/*Banner delete*/
    public function deleteBanner($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
           $imageName = Banner_sub::where('bannerid', $id)->select('poster')->get();

            foreach($imageName as $img){
                    Storage::disk('myfile')->delete('/assets/backend/uploads/banner/' . $img->file);
                }
             $res_sub= Banner_sub::where('bannerid',$id)->delete();

            if($res_sub)
            {
             $res= Banner::findOrFail($id)->delete();
            }
            $edit_f ='';
                 if($res_sub){
                    DB::commit();
                    return redirect()->route('banner')->with('success','Deleted successfully');
                 }else{
                    DB::rollback();
                     return back()->withErrors('Not deleted ');
                 }
    }

    /*edit Banner*/

    public function editbanner($id)
    {
        $id= Crypt::decryptString($id);

        $edit_f = 'E';

        $error = '';

        $data = Banner::with(['banner_sub' =>function($query){
            // $query->select('alternatetext','subtitle','title')->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

        $keydata = Banner::with(['banner_sub' =>function($query){
            // $query->select('alternatetext','subtitle','title')->where('delet_flag',0);
        }])->where('delet_flag',0)->where('id',$id)->first();


// dd($keydata);
        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Banner', 'message' => 'Banner', 'status' => 0, 'link' => '/banner'),
            2 => array('title' => 'Edit Banner', 'message' => 'Edit Banner', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.siteadmin.Banner.createbanner', compact('data','edit_f', 'error','keydata','breadcrumbarr','language','navbar','user'));
    }

        /*Banner update*/

    public function updatebanner(Request $request)
    {
        // dd($request->all());
        $role_id = Auth::user()->id;
        // dd($role_id);

        try{
                $validator = Validator::make(
                    $request->all(),
                    [
                        'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                        'sub_title.*'   => 'sometimes',
                        'alt_title.*'   => 'sometimes',
                        'poster.*'      => 'required',
                   ],[
                        'title.required' => 'Title is required',
                        'title.min' => 'Title  minimum lenght is 2',
                        'title.max' => 'Title  maximum lenght is 50',
                        'title.regex' => 'Invalid characters not allowed for Title',

                        'sub_title.required' => 'Sub title text is required',
                        'sub_title.min' => 'Sub title text  minimum lenght is 2',
                        'sub_title.max' => 'Sub title text  maximum lenght is 50',
                        'sub_title.regex' => 'Invalid characters not allowed for Sub title text',

                        'alt_title.required' => 'Alternative text is required',
                        'alt_title.min' => 'Alternative text  minimum lenght is 2',
                        'alt_title.max' => 'Alternative text  maximum lenght is 50',
                        'alt_title.regex' => 'Invalid characters not allowed for alternative text',

                        // 'poster.dimensions' => 'Image resolution does not meet the requirement. Size of the image should be 1090 x 400 (w x h). ',
                        'poster.required'   => 'required image ',
                    ]);

            $leng=count($request->sel_lang);
// dd($request->all());
            for ($i=0; $i<count($request->sel_lang); $i++) {
                $res=Banner_sub::where('bannerid',$request->hidden_id)->where('languageid',$request->sel_lang[$i])
                    ->update([
                        'title' =>$request->title[$i],
                        'subtitle' =>$request->sub_title[$i],
                        'alternatetext' =>$request->alt_title[$i],
           ]);
        }

                 $edit_f ='';
                 if($res){
                    return redirect()->route('banner')->with('success','Updated successfully');
                 }else{
                     return back()->withErrors('Not Updated ');
                 }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }


/*Status Status*/
public function statusbanner($id)
{
    $id= Crypt::decryptString($id);
    $status=Banner::where('id',$id)->value('status_id');

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

    $res=Banner::where('id',$id)->update($uparr);

    $edit_f ='';
        if($res){
            DB::commit();
            if(Auth::user()->role_id==5)//SBU admin
            {
                return redirect()->route('sbu.banner')->with('success','status change successfully');
            }else if(Auth::user()->role_id==2){//Site admin
                return redirect()->route('siteadmin.banner')->with('success','status change successfully');
            }
        }else{
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
}
/*Contact us*/
public function contactus()
{
    $user=Auth::user()->id;
    $data = Contactus::with(['contact_sub' =>function($query){
        $query->where('languageid',1);
    }])->where('delet_flag',0)->where('userid',$user)->get();

    $language = Language::where('delet_flag',0)->orderBy('name')->get();

    $role=Auth::user()->role_id;
    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
        1 => array('title' => 'contactus', 'message' => 'contactus', 'status' => 1)
     );

    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
    $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

    return view('backend.siteadmin.Contactus.contactuslist',compact('data','breadcrumbarr','language','navbar','user'));
}

/*store contact us*/
public function createcontactus()
{
    $language = Language::where('delet_flag',0)->orderBy('name')->get();

    $role=Auth::user()->role_id;
    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
        1 => array('title' => 'Contactus', 'message' => 'Contactus', 'status' => 0, 'link' => '/contactus'),
        2 => array('title' => 'Contactus', 'message' => 'Contactus', 'status' => 2)
     );

    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
    $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
    return view('backend.siteadmin.Contactus.createcontactus',compact('breadcrumbarr','language','navbar','user'));
}
/**store contactus */
public function storecontactus(Request $request)
{

    try{
    $validator = Validator::make(
        $request->all(),
        [
            'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            'address.*'     => app('App\Http\Controllers\Commonfunctions')->getEntitlereg_ckedit(),
            'emails'         => app('App\Http\Controllers\Commonfunctions')->getEntitlereg_ckedit(),
            'phone1s'         => app('App\Http\Controllers\Commonfunctions')->getEntitlereg_ckedit(),
            'map'           => 'sometimes',
            'website'       => 'required',
       ],[
            'title.required' => 'Title is required',
            'title.min' => 'Title  minimum lenght is 2',
            'title.max' => 'Title  maximum lenght is 50',
            'title.regex' => 'Invalid characters not allowed for Title',

            // 'poster.dimensions' => 'Image resolution does not meet the requirement. Size of the image should be 500 x 500 (w x h). ',
            // 'poster.mimes'   => 'Invalid image format',

            // 'date.min' => 'gallery_date  minimum length is 2',
            // 'date.max' => 'gallery_date  maximum length is 20',
            // 'date.regex' => 'Invalid characters not allowed for gallery_date',

        ]);
        if ($validator->fails()) {
            // dd($validator->errors());
            return back()->withInput()->withErrors($validator->errors());
        }
        // dd($request->all());
        // $role_id = Auth::user()->id;
        $role=Auth::user()->role_id;
        $leng=count($request->sel_lang);
        if($request->map){
            $map=$request->map;
        }else{
            $map=0;
        }

        $storeinfo=new Contactus([
                            'userid'        =>Auth::user()->id,
                            'delet_flag'    =>0,
                            'status_id'     =>1,
                            'contactemail'  =>$request->emails,
                            'contactphone'  =>$request->phone1s,
                            'map'           => $map,
                            'website'       =>$request->website
                       ]);

        $res = $storeinfo->save();
        $contactusid = DB::getPdo()->lastInsertId();


    if($contactusid){

        for($i=0;$i<$leng;$i++){
                    $store_sub_info=new Contactus_sub([
                                'languageid'=>$request->sel_lang[$i],
                                'title' =>$request->title[$i],
                                'address' =>$request->address[$i],
                                'contactusid' => $contactusid,
                                'delet_flag'=>0,
                                'status_id'=>1,
                            ]);
                     $storedetails_sub=$store_sub_info->save();
            }//forloop
            // dd($path);
        }//ifend

        $role=Auth::user()->role_id;

        if($role==5)//sbu user
        {
            return redirect()->route('sbu.contactus')->with('success','created successfully');
        }else if($role==2)//siteadmin
        {
            return redirect()->route('siteadmin.contactus')->with('success','created successfully');
        }




    } catch (ModelNotFoundException $exception) {
        \LogActivity::addToLog($exception->getMessage(),'error');
        $data = \LogActivity::logLatestItem();
        return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
    }

}

 /*edit contactus*/
 public function editcontactus($id)
 {

     $id= Crypt::decryptString($id);//History::with(['historysub
     $edit_f = 'E';
     $keydata = Contactus::with(['contact_sub' =>function($query){
         // $query->where('delet_flag',0);
     }])->where('id',$id)->first();
     $error = '';
     $data = Contactus::with(['contact_sub' =>function($query){
         // $query->where('delet_flag',0);
     }])->get();
     $language = Language::where('delet_flag',0)->orderBy('name')->get();
     $role_id = Auth::user()->id;

     $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
        1 => array('title' => 'Contactus', 'message' => 'Contactus', 'status' => 0, 'link' => '/siteadmin/contactus'),
        2 => array('title' => 'Contactus', 'message' => 'Contactus', 'status' => 2)
     );

     $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
     $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
     $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
     $url = url()->previous();
     $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
     $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
//  dd($keydata);sssss
     return view('backend.siteadmin.Contactus.createcontactus', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user','language','Navid'));
 }

/*update contactus*/
 public function updatecontactus(Request $request)
 {
//  dd($request->all());
     $usertype = Auth::user()->role_id;

     $validator = Validator::make(
        $request->all(),
        [
            'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            'address.*'     => app('App\Http\Controllers\Commonfunctions')->getEntitlereg_ckedit(),
            'emails'         => app('App\Http\Controllers\Commonfunctions')->getEntitlereg_ckedit(),
            'phone1s'         => app('App\Http\Controllers\Commonfunctions')->getEntitlereg_ckedit(),
            'map'           => 'sometimes',
            'website'       => 'required',
       ],[
            'title.required' => 'Title is required',
            'title.min' => 'Title  minimum lenght is 2',
            'title.max' => 'Title  maximum lenght is 50',
            'title.regex' => 'Invalid characters not allowed for Title',

            // 'poster.dimensions' => 'Image resolution does not meet the requirement. Size of the image should be 500 x 500 (w x h). ',
            // 'poster.mimes'   => 'Invalid image format',

            // 'date.min' => 'gallery_date  minimum length is 2',
            // 'date.max' => 'gallery_date  maximum length is 20',
            // 'date.regex' => 'Invalid characters not allowed for gallery_date',

        ]);
        if ($validator->fails()) {
            // dd($validator->errors());
            return back()->withInput()->withErrors($validator->errors());
        }

     try{
     $date = date('dmYH:i:s');
    // dd($request->all());
        if($request->map){
            $map=$request->map;
        }else{
            $map=0;
        }
     $id=$request->hidden_id;
     $storeinfo=array(
        'contactemail'  =>$request->emails,
        'contactphone'  =>$request->phone1s,
        'map'           => $map,
        'website'       =>$request->website
   );
 $res_main_table = Contactus::where('id',$id)->update($storeinfo);
     //maintable end

     if($res_main_table)
     {
         $galdate =$date;
         $leng=count($request->sel_lang);

             $chkrws = Contactus_sub::where('contactusid', '=', $id)->exists() ? 1 : 0;
             // dd($request->all());
             if($chkrws)
             {
                 for($i=0;$i<$leng;$i++){

                     $store_sub_info=array(
                        'languageid'=>$request->sel_lang[$i],
                        'title' =>$request->title[$i],
                        'address' =>$request->address[$i],
                        'contactusid' => $id,
                        'delet_flag'=>0,
                        'status_id'=>1,
                     );

                 $storedetails_sub=Contactus_sub::where('contactusid',$id)->where('languageid',$request->sel_lang[$i])->update($store_sub_info);
           }


            }else{
             return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' );
            }

     }//if


     $role=Auth::user()->role_id;
     return redirect()->route('siteadmin.contactus')->with('success','Updated successfully');

 } catch (ModelNotFoundException $exception) {
     \LogActivity::addToLog($exception->getMessage(),'error');
     $data = \LogActivity::logLatestItem();
     return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
 }


 }

   /*Contactus delete*/
public function deletecontactus($id)
{
     $id= Crypt::decryptString($id);

        DB::beginTransaction();


         $res_sub= Contactus_sub::where('contactusid',$id)->delete();

        if($res_sub)
        {
         $res= Contactus::findOrFail($id)->delete();
        }
        $edit_f ='';
        $role_id = Auth::user()->role_id;
        // dd($role_id);
             if($res_sub){
                DB::commit();

                return redirect()->route('siteadmin.contactus')->with('success','Deleted successfully');


             }else{
                DB::rollback();
                 return back()->withErrors('Not deleted ');
             }
}

/*Gallery*/
public function gallery()
{
    $role=Auth::user()->role_id;
        // dd($role);
        $user=Auth::user()->id;
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Gallery', 'message' => 'Gallery', 'status' => 1)
         );
        $data = Gallery::with(['gallery_sub' =>function($query){
            // $query->select('alternatetext','subtitle','title')->where('delet_flag',0);
        }])->where('delet_flag',0)->where('userid',$user)->get();
        // dd($data);
        $language=Language::where('delet_flag',0)->orderBy('name')->get();


        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);


        $usertype=usertype::get();

        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.siteadmin.Gallery.gallery',compact('data','breadcrumbarr','usertype','language','navbar','user','role'));
    }
/*Status Status*/
public function statusgallery($id)
{
    $id= Crypt::decryptString($id);
    $status=Gallery::where('id',$id)->value('status_id');

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

    $res=Gallery::where('id',$id)->update($uparr);

    $edit_f ='';
        if($res){
            DB::commit();
            return redirect()->route('siteadmin.gallerylist')->with('success','status change successfully');
        }else{
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
}
        /*Gallery create*/
    public function creategallery()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        $Gallerytype= Gallerytype::where('delet_flag',0)->orderBy('name')->get();


        if(Auth::user()->role_id==2)//siteadmin
            {
                $breadcrumb = array(
                    0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
                    1 => array('title' => 'List Gallery', 'message' => 'List Gallery', 'status' => 0, 'link' => '/siteadmin/gallerylist'),
                    2 => array('title' => 'Upload Gallery Item', 'message' => 'Upload Gallery Item', 'status' => 2)
                );

            }else if(Auth::user()->role_id==5)//sbuadmin
            {
                $breadcrumb = array(
                    0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
                    1 => array('title' => 'List Gallery', 'message' => 'List Gallery', 'status' => 0, 'link' => '/sbu/gallerylist'),
                    2 => array('title' => 'Upload Gallery Item', 'message' => 'Upload Gallery Item', 'status' => 2)
                );

            }
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();

        //  dd($route);
        return view('backend.siteadmin.Gallery.creategallery',compact('breadcrumbarr','language','navbar','user','Gallerytype','Navid'));
    }

   /*Store Gallery*/
      public function storegallery(Request $request)
    {
// dd($request->all());
        try{
        $validator = Validator::make(
            $request->all(),
            [
                'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                // 'date'          => app('App\Http\Controllers\Commonfunctions')->Nogetdateddmmyyyy1(),//not req

                'gallerytype'   => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'photo'        => 'required',
           ],[
                'title.required' => 'Title is required',
                'title.min' => 'Title  minimum lenght is 2',
                'title.max' => 'Title  maximum lenght is 50',
                'title.regex' => 'Invalid characters not allowed for Title',

                // 'poster.dimensions' => 'Image resolution does not meet the requirement. Size of the image should be 500 x 500 (w x h). ',
                // 'poster.mimes'   => 'Invalid image format',

                // 'date.min' => 'gallery_date  minimum length is 2',
                // 'date.max' => 'gallery_date  maximum length is 20',
                // 'date.regex' => 'Invalid characters not allowed for gallery_date',

            ]);
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }
            // dd($request->all());
            // $role_id = Auth::user()->id;
            $role=Auth::user()->role_id;
            $leng=count($request->sel_lang);

            $date = date('dmYH:i:s');

                // print_r($request->file('poster')[$i]);
            //    dd($filep->poster[$i]->extension());
            // dd(count($request->poster));
                // $imageName = 'logo' . $date . '.' .$filep->poster->extension();
//////////////////////////////////\
//     if ($request->hiddenval == 'mdj') {

//         return Redirect::back()->withInput()->withErrors('Please crop before save. Only jpg, png, jpeg, webp and svg is accepted');
//     }
//     $image_64 = $request->hiddenval; //your base64 encoded data

//     $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
//     $valiimgarray = array('jpg', 'png', 'jpeg', 'webp');
//     if (!(in_array($extension, $valiimgarray))) {
//         return Redirect::back()->withInput()->withErrors('Only jpg, png, jpeg, webp and svg is accepted');
//     }
//     if ($validator->fails()) {
//         return Redirect::back()->withInput()->withErrors($validator->errors());
//     }


//     $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

//     // find substring fro replace here eg: data:image/png;base64,

//     $image = str_replace($replace, '', $image_64);
//     $date = date('dmYH:i:s');
//     $image = str_replace(' ', '+', $image);

//     $imageName =  'Gallerymain' . $date . '.' . $extension;

//     Storage::disk('myfile')->put('/assets/backend/uploads/Gallerymain/' . $imageName,  base64_decode($image));
//     $im = imagecreatefromjpeg(public_path('/assets/backend/uploads/Gallerymain/' . $imageName));
//     chmod(public_path('/assets/backend/uploads/Gallerymain/' . $imageName), 0777);

//         imagejpeg($im, public_path('/assets/backend/uploads/Gallerymain/'. $imageName));
// ////////////////////////////////////

// dd($imageName);

                if($request->photo){
                    $date = date('dmYH:i:s');
                    $imageName = 'Gallerymain'. $date . '.' .$request->photo->extension();
                    $filename=$imageName;
                    $path = $request->file('photo')->storeAs('/assets/backend/uploads/Gallerymain/', $imageName, 'myfile');

                }
            $storeinfo=new Gallery([
                                'userid'=>Auth::user()->id,
                                'delet_flag'=>0,
                                'status_id'=>1,
                                'gallerytypeid'=>$request->gallerytype,
                                'date'=>$request->date,
                                'file' => $imageName,
                           ]);

            $res = $storeinfo->save();
            $gallery_id = DB::getPdo()->lastInsertId();


        if($gallery_id){

            for($i=0;$i<$leng;$i++){
                        $store_sub_info=new GallerySub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'galleryid' => $gallery_id,
                                    'delet_flag'=>0,
                                    'status_id'=>1,
                                ]);
                         $storedetails_sub=$store_sub_info->save();
                }//forloop
                // dd($path);
            }//ifend
// dd($storeinfo->id);
            // return redirect()->route('gallery')->with('success','created successfully');
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
                1 => array('title' => 'List Gallery', 'message' => 'List Gallery', 'status' => 0, 'link' => '/siteadmin/gallerylist'),
                2 => array('title' => 'Upload Gallery Item', 'message' => 'Upload Gallery Item', 'status' => 2)
            );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $galdet = Gallery::whereId($storeinfo->id)->first();
        // dd($galdet);
        $galitem = GallerySubItems::where('gallery_id', $gallery_id)->where('status_id', 1)->get();
        $galitemcnt = count($galitem);

        return view('backend.siteadmin.Gallery.uploadgallery',compact('breadcrumbarr','navbar','user','gallery_id','galitem','galdet','galitemcnt'));

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

    /*Gallery item uppy upload */
    public function galitemstoreuppy(Request $request, $encid)
    {

        $id = Crypt::decrypt($encid);
        $usertype_id = Auth::user()->role_id;
        $pgmdet = Gallery::where('id', $id)->first();

        $files = $request->file;
        $imageName = time() . rand() . '.' . $files->extension();
        $request->file('file')->storeAs('/assets/backend/uploads/Galleryitem', $imageName, 'myfile');

        $formdata = array(
            'gallery_id' => $id,
            'image' => $imageName,
            'alternate_text' => 'Upload',
            'status_id' => 1,
            'user_id'  => Auth::user()->id

        );

        $res=GallerySubItems::create($formdata);
        $resusertype=$usertype_id;
// dd($res->id."");

        if ($res) {
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
                1 => array('title' => 'Upload Gallery Item', 'message' => 'Upload Gallery Item', 'status' => 1)
            );

            $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
            $galdet = GallerySubItems::whereId($res->id)->first();
            $galitem = GallerySubItems::where('gallery_id', $id)->where('status_id', 1)->get();
            // dd($galitem);
            $galitemcnt = count($galitem);

            // dd($galitemcnt);
            $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
            $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

            return view('backend.siteadmin.Gallery.uploadgallery', compact('breadcrumbarr', 'resusertype', 'galdet', 'galitem', 'galitemcnt','navbar','user'));
        }else{
            return back()->withInput()->withErrors('error', 'Not added');
        }

    }
    public function galitemdel(Request $request, $id)
    {
        // dd(true);
        if ($request->ajax()) {

                // if($usertype_id==4){
                    $galitem = GallerySubItems::whereId($id)->first();
                    $galitemimg = public_path('/assets/backend/uploads/Galleryitem/') . $galitem->image;
                    if (file_exists($galitemimg)) {
                        @unlink($galitemimg);
                    }

                    GallerySubItems::findOrFail($id)->delete();
                // }else

            return response()->json(['success' => 'Data Updated successfully.']);
        }
    }

    /*Uppy view images */
    public function viewgallarypics(Request $request, $encid)
    {
        // dd(true);
        $id = Crypt::decrypt($encid);
        $resusertype = User::where('id', Auth::user()->id)->first();
        $usertype_id = Auth::user()->usertype_id;
        $usertype = Auth::user()->usertype_id;
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'List Gallery', 'message' => 'List Gallery', 'status' => 0, 'link' => '/siteadmin/gallerylist'),
            2 => array('title' => 'Upload Gallery Item', 'message' => 'Upload Gallery Item', 'status' => 2)
        );
                $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
            // $galdet = ArchiveGallery::whereId($id)->first();
            // $galitem = ArchiveGallerySubItems::where('gallery_id', $id)->where('status_id', 1)->get();
            // $galitemcnt = count($galitem);

            //changed sabitha 07062022
            $galdet = Gallery::whereId($id)->first();
            $galitem = GallerySubItems::where('gallery_id', $id)->where('status_id', 1)->get();
            $galitemcnt = count($galitem);


        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.siteadmin.Gallery.uploadgallery', compact('user','navbar','breadcrumbarr', 'resusertype', 'galdet', 'galitem', 'galitemcnt'));


        // return view('Festmanager.film.uploadfilmstills', compact('breadcrumbarr', 'resusertype', 'pgmdet', 'pgmalbum', 'pgmalbumcnt'));
    }

    /*gallery delete*/
    public function deletegallery($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
           $imageName = GallerySubItems::where('gallery_id', $id)->select('image')->get();

            foreach($imageName as $img){
                    Storage::disk('myfile')->delete('/assets/backend/uploads/Galleryitem' . $img->file);
                }
             $res_sub= GallerySub::where('galleryid',$id)->delete();

            if($res_sub)
            {
             $res= Gallery::findOrFail($id)->delete();
            }
            $edit_f ='';
                 if($res_sub){
                    DB::commit();
                    return redirect()->route('siteadmin.gallerylist')->with('success','status change successfully');
                 }else{
                    DB::rollback();
                     return back()->withErrors('Not deleted ');
                 }
    }


    public function editgallery(Request $request, $encid)
    {

        $edit_f = 'E';

        try {
            $id= Crypt::decryptString($encid);
            $usertype_id=Auth::user()->role_id;
            $resusertype = User::where('id', Auth::user()->id)->first();
        //  dd($id);
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'List Gallery', 'message' => 'List Gallery', 'status' => 0, 'link' => '/siteadmin/gallerylist'),
            2 => array('title' => 'Upload Gallery Item', 'message' => 'Upload Gallery Item', 'status' => 2)
        );
            // dd($usertype_id);


                $Gallerytype = Gallerytype::where('status_id', 1)->get();
                $keydata = Gallery::with(['gallery_sub' =>function($query){
                    $query->with(['lang' => function($query){

                    }]);
                }])->where('delet_flag',0)->where('id', $id)->first();



        } catch (\Illuminate\Database\QueryException $exception) {

        }

        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        return view('backend.siteadmin.Gallery.creategallery', compact( 'breadcrumbarr', 'Gallerytype', 'resusertype', 'edit_f', 'keydata','navbar','user'));
    }

    public function updategallery(Request $request)
    {
// dd($request->all());
        $usertype = Auth::user()->role_id;

            $validator = Validator::make(
                $request->all(),
                [
                    'title.*'    => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                    'gallerytype'    => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    // 'date'    => app('App\Http\Controllers\Commonfunctions')->getdateddmmyyyy(), //dd/mm/yyyy format
                    'date' =>'required',
                ],
                [
                    'title.required' => 'Title is required',
                    'title.min' => 'Title  minimum length is 2',
                    'title.max' => 'Title  maximum length is 250',
                    'title.regex' => 'Invalid characters not allowed for Title',

                    'gallerytype.required' => 'gallerytype is required',
                    'gallerytype.min' => 'gallerytype  minimum length is 2',
                    'gallerytype.max' => 'gallerytype  maximum length is 20',
                    'gallerytype.regex' => 'Invalid characters not allowed for gallerytype',


                    'date.required' => 'Gallery Date is required',
                    // 'date.min' => 'gallery_date  minimum length is 2',
                    // 'date.max' => 'gallery_date  maximum length is 20',
                    // 'date.regex' => 'Invalid characters not allowed for gallery_date',

                ]
            );


        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        try{
        $date = date('dmYH:i:s');
    //    dd($request->all());

        $id=$request->hidden_id;

        // if(isset($request->hiddenval)){
        //     //maintable start
        //     $date = date('dmYH:i:s');
        //     if($request->hiddenval){
                // $date = date('dmYH:i:s');
                // $imageName = 'Gallerymain'. $date . '.' .$request->photo->extension();
                // $filename=$imageName;
                // $path = $request->file('photo')->storeAs('/uploads/Gallerymain/', $imageName, 'myfile');
                //////////////////////////////////\
    // if ($request->hiddenval == 'mdj') {
    //     $storeinfo=array(
    //         'gallerytypeid'=>$request->gallerytype,
    //         'date'=>$request->date,
    //         'sbutype_id'=>Auth::user()->sbutype,
    //    );
    //     // return Redirect::back()->withInput()->withErrors('Please crop before save. Only jpg, png, jpeg, webp and svg is accepted');
    // }else{
    //     $image_64 = $request->hiddenval; //your base64 encoded data

    //     $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
    //     $valiimgarray = array('jpg', 'png', 'jpeg', 'webp');
    //     if (!(in_array($extension, $valiimgarray))) {
    //         return Redirect::back()->withInput()->withErrors('Only jpg, png, jpeg, webp and svg is accepted');
    //     }
    //     if ($validator->fails()) {
    //         return Redirect::back()->withInput()->withErrors($validator->errors());
    //     }


    //     $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

    //     // find substring fro replace here eg: data:image/png;base64,

    //     $image = str_replace($replace, '', $image_64);

    //     $image = str_replace(' ', '+', $image);

    //     // $imageName =  'Gallerymain' . '.' . $extension;

    //     $imageName =  'Gallerymain' . $date . '.' . $extension;
    //     // dd($imageName);
    //     Storage::disk('myfile')->put('/assets/backend/uploads/Gallerymain/' . $imageName,  base64_decode($image));
    //     $im = imagecreatefromjpeg(public_path('/assets/backend/uploads/Gallerymain/' . $imageName));
    //     chmod(public_path('/assets/backend/uploads/Gallerymain/' . $imageName), 0777);
    //         // dd($imageName);
    //         imagejpeg($im, public_path('/assets/backend/uploads/Gallerymain'. $imageName));
    ////////////////////////////////////
    if($request->photo){
        $date = date('dmYH:i:s');
        $imageName = 'Gallerymain'. $date . '.' .$request->photo->extension();
        $filename=$imageName;
        $path = $request->file('photo')->storeAs('/assets/backend/uploads/Gallerymain/', $imageName, 'myfile');
        $storeinfo=array(
            'gallerytypeid'=>$request->gallerytype,
            'date'=>$request->date,
            'file' => $imageName,
        );
    }else{
        $storeinfo=array(
            'gallerytypeid'=>$request->gallerytype,
            'date'=>$request->date,
        );
    }

// }
    // }


        // }
        // else{
        //     $storeinfo=array(
        //         'gallerytypeid'=>$request->gallerytype,
        //         'date'=>$request->date,
        //         'sbutype_id'=>Auth::user()->sbutype,
        //    );
        // }
    $res_main_table = Gallery::where('id',$id)->update($storeinfo);
        //maintable end

        if($res_main_table)
        {
            $galdate =$date;
            $leng=count($request->sel_lang);

                $chkrws = GallerySub::where('galleryid', '=', $id)->exists() ? 1 : 0;
                // dd($request->all());
                if($chkrws)
                {
                    for($i=0;$i<$leng;$i++){

                        $store_sub_info=array(
                            'languageid'=>$request->sel_lang[$i],
                            'title' =>$request->title[$i],
                            'galleryid' => $id,
                        );

                    $storedetails_sub=GallerySub::where('galleryid',$id)->where('languageid',$request->sel_lang[$i])->update($store_sub_info);
              }


               }else{
                return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' );
               }

        }//if



        if($storedetails_sub)
                {

                    $breadcrumb = array(
                        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
                        1 => array('title' => 'List Gallery', 'message' => 'List Gallery', 'status' => 0, 'link' => '/siteadmin/gallerylist'),
                        2 => array('title' => 'Upload Gallery Item', 'message' => 'Upload Gallery Item', 'status' => 2)
                    );


                    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
                    $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
                    $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
                    $galdet = Gallery::whereId($id)->first();
                    // dd($galdet);
                    $galitem = GallerySubItems::where('gallery_id', $id)->where('status_id', 1)->get();
                    $galitemcnt = count($galitem);
                $gallery_id=$id;
                    return view('backend.siteadmin.Gallery.uploadgallery',compact('breadcrumbarr','navbar','user','gallery_id','galitem','galdet','galitemcnt'));

                }

    } catch (ModelNotFoundException $exception) {
        \LogActivity::addToLog($exception->getMessage(),'error');
        $data = \LogActivity::logLatestItem();
        return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
    }


    }


       /*multiple image Store Gallery*/

    public function galitemstore(Request $request, $encid)
    {
        //dd($id);
        $id = Crypt::decrypt($encid);
        $usertype_id = Auth::user()->usertype_id;

        $validator = Validator::make(
            $request->all(),
            [
                //'file' => 'required|mimes:pdf,doc,docx,odt,jpeg,png,jpg,gif,svg|max:5000000|dimensions:max_width=500,max_height=500',
                'file' => 'required|mimes:pdf,doc,docx,odt,jpeg,png,jpg,gif,svg|max:5000000',

            ],
            [
                'file.required' => 'File is required. ',
                'file.mimes'   => 'Invalid image format.',
                'file.max'   => 'Max size of 5MB.',
                //'file.dimensions' => 'Image resolution does not meet the requirement. Size of the image should be 500 x 500 (w x h). ',


            ]
        );

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }

            $pgmdet = Gallery::where('id', $id)->first();

            $files = $request->file;
            $imageName = time() . rand() . '.' . $files->extension();
            $files->move(public_path('uploads/Galleryitems/'), $imageName);

            $formdata = array(
                'gallery_id' => $id,
                'image' => $imageName,
                'alternate_text' => 'Upload',
                'status_id' => 1,
                'user_id'  => Auth::user()->id

            );
            GallerySubItems::create($formdata);


    }





/*Social media*/
    public function socialmedia()
    {
        $data = Socialmedia::with(['socialmedia_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

        $language=Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Socialmedia', 'message' => 'Socialmedia', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $usertype=usertype::get();

        return view('Siteadmin.Socialmedia.socialmedia',compact('data','breadcrumbarr','usertype','language','navbar','user'));
    }
    /*Create social media*/
    public function createsocialmedia()
    {
     $language=Language::where('delet_flag',0)->orderBy('name')->get();
     $usertype=usertype::get();
     $edit_f='';
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Socialmedia List', 'message' => 'Socialmedia List', 'status' => 1, 'link' => '/socialmedia'),
            2 => array('title' => 'Socialmedia create', 'message' => 'Socialmedia create', 'status' => 2)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();

        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('Siteadmin.Socialmedia.createsocialmedia',compact('usertype','language','breadcrumbarr','navbar','user','Navid'));
    }
    /*Store social media*/
    public function storesocialmedia(Request $request)
    {

        $role_id = Auth::user()->id;
// dd($request->all());
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'sel_lang.*'=>app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                    'path.*'=>app('App\Http\Controllers\Commonfunctions')->urlcheck(),
                    'alt_title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                    'iconclass.*'=>app('App\Http\Controllers\Commonfunctions')->getIconClass(),

               ],[
                'title.required' => 'Title is required',
                'title.min' => 'Title  minimum lenght is 2',
                'title.max' => 'Title  maximum lenght is 50',
                'title.regex' => 'Invalid characters not allowed for Title',

                'iconclass.required' => 'Iconclass is required',
                'iconclass.min' => 'Iconclass  minimum lenght is 2',
                'iconclass.max' => 'Iconclass  maximum lenght is 50',
                'iconclass.regex' => 'Invalid characters not allowed for Iconclass',

                'alt_title.required' => 'Alternate text is required',
                'alt_title.min' => 'Alternate text  minimum lenght is 2',
                'alt_title.max' => 'Alternate text  maximum lenght is 100',
                'alt_title.regex' => 'Invalid characters not allowed for Alternate text',

                'path.required' => 'url is required',
                'path.min' => 'url  minimum lenght is 2',
                'path.max' => 'url  maximum lenght is 100',
                'path.regex' => 'Invalid characters not allowed for url',
                ]);
                if ($validator->fails()) {
                    // dd($validator->errors());
                    return back()->withInput()->withErrors($validator->errors());
                }
               $leng=count($request->title);
            //    dd($request->all());
                   $storeinfo=new Socialmedia([
                                'userid'=>$role_id,
                                'iconclass'=>$request->iconclass,
                                'url'=>$request->path,
                                'delet_flag'=>0,
                                'status_id'=>1,
                            ]);

                    $storedetails=$storeinfo->save();
                    $socialmediaid = DB::getPdo()->lastInsertId();

                for($i=0;$i<$leng;$i++){

                    if($storedetails)
                    {
                        $store_sub_info=new Socialmedia_sub([
                                'alternatetext'=>$request->alt_title[$i],
                                'title'=>$request->title[$i],
                                'languageid'=>$request->sel_lang[$i],
                                'socialmediaid'=>$socialmediaid,
                                'userid'=>$role_id,
                                'delet_flag'=>0,
                                'status_id'=>1,
                            ]);
                        $storedetails_sub=$store_sub_info->save();
                        DB::commit();
                    }else{
                        DB::rollback();
                    }
                }



               return redirect()->route('socialmedia')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

/*socialmedia update*/
    public function updatesocialmedia(Request $request)
    {
        // dd($request->all());
        try{
            $validator = Validator::make(
            $request->all(),
            [
            'sel_lang.*'=>app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
            'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            'path.*'=>app('App\Http\Controllers\Commonfunctions')->urlcheck(),
            'alt_title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            'iconclass.*'=>app('App\Http\Controllers\Commonfunctions')->getIconClass(),

           ],[
            'title.required' => 'Title is required',
            'title.min' => 'Title  minimum lenght is 2',
            'title.max' => 'Title  maximum lenght is 50',
            'title.regex' => 'Invalid characters not allowed for Title',

            'iconclass.required' => 'Iconclass is required',
            'iconclass.min' => 'Iconclass  minimum lenght is 2',
            'iconclass.max' => 'Iconclass  maximum lenght is 50',
            'iconclass.regex' => 'Invalid characters not allowed for Iconclass',

            'alt_title.required' => 'Alternate text is required',
            'alt_title.min' => 'Alternate text  minimum lenght is 2',
            'alt_title.max' => 'Alternate text  maximum lenght is 100',
            'alt_title.regex' => 'Invalid characters not allowed for Alternate text',

            'path.required' => 'url is required',
            'path.min' => 'url  minimum lenght is 2',
            'path.max' => 'url  maximum lenght is 100',
            'path.regex' => 'Invalid characters not allowed for url',
            ]);
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }
            // dd($request->all());
            // $leng=count($request->title);
            // // dd($leng);
            // $uparr=array();
            // for($i=0;$i<$leng;$i++){


            //     $uparr[]=array(
            //         'alternatetext'=>$request->alt_title[$i],
            //         'title'=>$request->title[$i],
            //         'languageid'=>$request->sel_lang[$i],
            //       );

            //     //   dd($uparr);
            //    }

               $i=0;
               foreach($request->sel_lang as $lng){
                   // dd(count($lang));
                   $chekrows = Socialmedia_sub::where('title', $request->title[$i])->where('socialmediaid',$request->hidden_id)->exists() ? 1 : 0;
                //    dd($chekrows);
                   if($chekrows==0){

                           $dataarr1=array(
                                    'alternatetext'=>$request->alt_title[$i],
                                    'title'=>$request->title[$i],
                                    'languageid'=>$request->sel_lang[$i],
                           );


                       $res1=Socialmedia_sub::where('socialmediaid','=',$request->hidden_id)->where('languageid','=',$request->sel_lang[$i])->update($dataarr1);

                    }
                }
            //   $res=Socialmedia_sub::where('socialmediaid',$request->hidden_id)->update($uparr);


                  if($dataarr1){
                    dd(true);
                      return Redirect('socialmedia')->with('success','Updated successfully');
                  }else{
                    dd(false);
                      return back()->withErrors('Not Updated ');
                  }

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }


    }
    /*edit socialmedia*/
    public function editsocialmedia($id)
    {
        $id= Crypt::decryptString($id);

        $edit_f = 'E';

        $error = '';

        $data = Socialmedia::with(['socialmedia_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

        $keydata = Socialmedia::with(['socialmedia_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->where('id',$id)->where('delet_flag',0)->first();

// dd($keydata);
        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Socialmedia List', 'message' => 'Socialmedia List', 'status' => 1, 'link' => '/socialmedia'),
            2 => array('title' => 'Edit Socialmedia', 'message' => 'Edit Socialmedia ', 'status' => 2)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('Siteadmin.Socialmedia.createsocialmedia', compact('data','edit_f', 'error','keydata','breadcrumbarr','language','navbar','user'));
    }
   /*Social media delete*/
    public function deletesocialmedia($id)
    {

        $id= Crypt::decryptString($id);
        // dd($id);
            DB::beginTransaction();

             $res_sub= Socialmedia_sub::where('socialmediaid',$id)->delete();

            if($res_sub)
            {
             $res= Socialmedia::findOrFail($id)->delete();

            }
            $edit_f ='';
                 if($res_sub){
                    DB::commit();
                     return Redirect('socialmedia')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback();
                     return back()->withErrors('Not deleted ');
                 }
    }


    /*Whatsnew*/
    public function whatsnew()
    {
        $role=Auth::user()->role_id;
        $user=Auth::user()->id;
        $data = Whatsnew::with(['whats_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->where('delet_flag',0)->where('userid',$user)->get();

// dd($data);
        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        if($role==5)//SBU admin
        {
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
                1 => array('title' => 'whatsnew', 'message' => 'whatsnew', 'status' => 1)
             );
        }else if($role==2){//Site admin
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
                1 => array('title' => 'whatsnew', 'message' => 'whatsnew', 'status' => 1)
             );
        }


        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('Siteadmin.Whatsnew.whatsnewlist',compact('data','breadcrumbarr','language','navbar','user'));
    }
/*Milestone Status*/
public function statuswhatsnew($id)
    {
        $id= Crypt::decryptString($id);
        $status=Whatsnew::where('id',$id)->value('status_id');

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
        $res=Whatsnew::where('id',$id)->update($uparr);

        $edit_f ='';

        if($res){
            if(Auth::user()->role_id==5){
                DB::commit();
                 return Redirect('/sbu/whatsnew')->with('success','Status updated successfully',['edit_f' => $edit_f]);
            }else{
                DB::commit();
                return Redirect('/siteadmin/whatsnew')->with('success','Status updated successfully',['edit_f' => $edit_f]);
            }

        }else{
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
          }
    /*Whatsnew create*/
    public function createwhatsnew()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Whatsnew', 'message' => 'Whatsnew', 'status' => 0, 'link' => '/siteadminhome'),
            2 => array('title' => 'Create Whatsnew', 'message' => 'Create Whatsnew', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        if(Auth::user()->role_id==5){
            $Navid=Componentpermission::where('id',53)->select('id')->first();
        }else{
            $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        }

        //  dd($Navid->id);
        return view('Siteadmin.Whatsnew.createwhatsnew',compact('breadcrumbarr','language','navbar','user','Navid'));
    }
    /*store whatsnew*/

    public function storewhatsnew(Request $request)
    {
        // dd($request->all());
        try{
          $request->validate([
                'sub_title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'con_title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg_ckedit(),
           ],
            [
                'title.required' => 'Title is required',
                'title.min' => 'Title  minimum lenght is 2',
                'title.max' => 'Title  maximum lenght is 200',
                'title.regex' => 'Invalid characters not allowed for Title',
            ]);
            $request->input();
            $role_id = Auth::user()->id;

            $leng=count($request->sel_lang);
            // dd($leng);

            $storeinfo=new Whatsnew([
                                'userid'=>Auth::user()->id,
                                'delet_flag'=>0,
                                'status_id'=>1,
                                'sbutype_id'=>Auth::user()->role_id,
                                'sbu_id'=>Auth::user()->sbutype,
                            ]);

            $res = $storeinfo->save();
            $whatsnewid = DB::getPdo()->lastInsertId();

            for($i=0;$i<$leng;$i++){

               // dd($request->sel_lang[$i]);
                if($whatsnewid){

                        $store_sub_info=new Whatsnewsub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'whatsnewid' => $whatsnewid,
                                    'subtitle' =>$request->sub_title[$i],
                                    'content'=>$request->con_title[$i],
                                ]);

                         $storedetails_sub=$store_sub_info->save();
                }
                // dd($path);
            }//forloopend
            if(Auth::user()->role_id==5)//SBU admin
            {
                return redirect()->route('sbu.whatsnew')->with('success','created successfully');
            }else if(Auth::user()->role_id==2){//Site admin
                return redirect()->route('siteadmin.whatsnew')->with('success','created successfully');
            }

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }
    /*edit whatsnew*/
    public function editwhatsnew($id)
    {
        $id= Crypt::decryptString($id);//History::with(['historysub
        $edit_f = 'E';
        $keydata = Whatsnew::with(['whats_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->where('id',$id)->first();
        $error = '';
        $data = Whatsnew::with(['whats_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->get();

        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        $role_id = Auth::user()->id;
        if(Auth::user()->role_id==5)//sbu
            {
                $breadcrumb = array(
                    0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
                    1 => array('title' => 'Whatsnew', 'message' => 'Whatsnew', 'status' => 0, 'link' => '/whatsnew'),
                    2 => array('title' => 'Edit Whatsnew', 'message' => 'Edit Whatsnew', 'status' => 1)
                   );

            }else if(Auth::user()->role_id==2){
                $breadcrumb = array(
                    0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
                    1 => array('title' => 'Whatsnew', 'message' => 'Whatsnew', 'status' => 0, 'link' => '/whatsnew'),
                    2 => array('title' => 'Edit Whatsnew', 'message' => 'Edit Whatsnew', 'status' => 1)
                   );
            }

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
// dd($keydata);
        return view('Siteadmin.Whatsnew.createwhatsnew', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user','language','Navid'));
    }


    /**update whatsnew */
public function updatewhatsnew(Request $request)
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
            'sub_title.*'      => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),

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
    // dd($request->all());
    try{

        $i=0;
        $filename=array();

        $leng=count($request->sel_lang);

        for($i=0;$i<$leng;$i++){
          // dd(count($lang));
          $chekrows = Whatsnewsub::where('whatsnewid','=', $request->hidden_id)->exists() ? 1 : 0;
// dd($chekrows);
          if($chekrows==1){

                      $dataarr1=array(
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'whatsnewid' => $request->hidden_id,
                                    'subtitle' =>$request->sub_title[$i],
                                    'content'=>$request->con_title[$i],
                      );


                    //   dd($request->sel_lang[$i]);
                    // dd($dataarr1);
                  $res1=Whatsnewsub::where('whatsnewid','=',$request->hidden_id)->where('languageid','=',$request->sel_lang[$i])->update($dataarr1);

                  if($res1){
                    if(Auth::user()->role_id==5)//SBU admin
                    {
                        return redirect()->route('sbu.whatsnew')->with('success','created successfully');
                    }else if(Auth::user()->role_id==2){//Site admin
                        return redirect()->route('siteadmin.whatsnew')->with('success','created successfully');
                    }

                }

          }else{
              return back()->withInput()->with('error',"Already existing");

          }


      }


        // }
    }catch(Exception $e){
        return back()->withInput()->with('error',$e);
    }


}



    /*whatsnew delete*/
public function deletewhatsnew($id)
{
    $id= Crypt::decryptString($id);

        DB::beginTransaction();

        $res_sub= Whatsnewsub::where('whatsnewid',$id)->delete();

        if($res_sub)
        {
         $res= Whatsnew::findOrFail($id)->delete();
        }
        $edit_f ='';
             if($res_sub){
                DB::commit();
                if(Auth::user()->role_id==5)//SBU admin
                {
                    return redirect()->route('sbu.whatsnew')->with('success','created successfully');
                }else if(Auth::user()->role_id==2){//Site admin
                    return redirect()->route('siteadmin.whatsnew')->with('success','created successfully');
                }
             }else{
                DB::rollback();
                 return back()->withErrors('Not deleted ');
             }
}

        /*Functional unit*/
    public function functionalunit()
    {
        $data = Functionalunit::with(['func_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

// dd($data);
        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Functional unit', 'message' => 'Functional unit', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('Siteadmin.Functionalunit.functionalunitlist',compact('data','breadcrumbarr','language','navbar','user'));
    }

        /*Functionalunit  create*/
    public function createfunctionalunit()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'createfunctionalunit', 'message' => 'createfunctionalunit', 'status' => 0, 'link' => '/functionalunit'),
            2 => array('title' => 'Create createfunctionalunit', 'message' => 'Create createfunctionalunit', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        return view('Siteadmin.Functionalunit.createfunctionalunit',compact('breadcrumbarr','language','navbar','user','Navid'));
    }
   /*store functionalunit*/

    public function storefunctionalunit(Request $request)
    {
        // dd($request->all());
        try{
          $request->validate([
                'sub_title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'con_title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
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

            $storeinfo=new Functionalunit([
                                'userid'=>Auth::user()->id,
                                'delet_flag'=>0,
                                'status_id'=>1,
                            ]);

            $res = $storeinfo->save();
            $functionid = DB::getPdo()->lastInsertId();
// dd($functionid );
            for($i=0;$i<$leng;$i++){

               // dd($request->sel_lang[$i]);
                if($functionid){

                        $store_sub_info=new Functionalunitsub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'functionalunitid' => $functionid,
                                    'subtitle' =>$request->sub_title[$i],
                                ]);
                      // dd($store_sub_info);
                         $storedetails_sub=$store_sub_info->save();
                }
                // dd($path);
            }//forloopend

            return redirect()->route('functionalunit')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

            /*Sectionofficers*/
    public function sectionofficers()
    {
        $data = Sectionoffice::with(['sectionoffice_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

// dd($data);
        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Functional unit', 'message' => 'Functional unit', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('Siteadmin.Sectionofficer.sectionofficerlist',compact('data','breadcrumbarr','language','navbar','user'));
    }

            /*Sectionoffice  create*/
    public function createsectionoffice()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'createsectionoffice', 'message' => 'createsectionoffice', 'status' => 0, 'link' => '/sectionoffice'),
            2 => array('title' => 'Create sectionoffice', 'message' => 'Create sectionoffice', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        return view('Siteadmin.Sectionofficer.createsectionofficer',compact('breadcrumbarr','language','navbar','user','Navid'));
    }

    /*store sectionoffice*/

    public function storesectionoffice(Request $request)
    {
        // dd($request->all());
        try{
          $request->validate([
                'sub_title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
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

            $storeinfo=new Sectionoffice([
                                'userid'=>Auth::user()->id,
                                'delet_flag'=>0,
                                'status_id'=>1,
                            ]);

            $res = $storeinfo->save();
            $sec_off_id = DB::getPdo()->lastInsertId();
// dd($functionid );
            for($i=0;$i<$leng;$i++){

               // dd($request->sel_lang[$i]);
                if($sec_off_id){

                        $store_sub_info=new Sectionofficesub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'sectionofficeid' => $sec_off_id,
                                    'subtitle' =>$request->sub_title[$i],
                                ]);
                      // dd($store_sub_info);
                         $storedetails_sub=$store_sub_info->save();
                }
                // dd($path);
            }//forloopend

            return redirect()->route('sectionofficers')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

    /*Section office delete*/
    public function deletesectionoffice($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();

             $res_sub= Sectionofficesub::where('Sectionofficesub',$id)->delete();

            if($res_sub)
            {
             $res= Sectionoffice::findOrFail($id)->delete();

            }
            $edit_f ='';
                 if($res_sub){
                    DB::commit();
                     return Redirect('sectionofficers')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback();
                     return back()->withErrors('Not deleted ');
                 }
    }


    /*Shortalert*/
    public function shortalert()
    {
        $data = Shortalert::with(['shortalert_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

        $language=Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'shortalert', 'message' => 'shortalert', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $usertype=usertype::get();

        return view('Siteadmin.Shortalert.shortalertlist',compact('data','breadcrumbarr','usertype','language','navbar','user'));
    }

            /*Shortalert  create*/
    public function createshortalert()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'create Shortalert', 'message' => 'create Shortalert', 'status' => 0, 'link' => '/shortalert'),
            2 => array('title' => 'Create  Shortalert', 'message' => 'Create  Shortalert', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        return view('Siteadmin.Shortalert.createshortalert',compact('breadcrumbarr','language','navbar','user','Navid'));
    }


     /*store Shortalert*/

    public function storeshortslert(Request $request)
    {
        // dd($request->all());
        try{
          $request->validate([
                'con_title.*'=>app('App\Http\Controllers\Commonfunctions')->get_ckeditor_val_req(),
                'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'colorclass'    => app('App\Http\Controllers\Commonfunctions')->get_Color_hex_codeval(),
           ],
            [
                'title.required' => 'Title is required',
                'title.min' => 'Title  minimum lenght is 2',
                'title.max' => 'Title  maximum lenght is 50',
                'title.regex' => 'Invalid characters not allowed for Title',

                'colorclass.required' => 'Color Class is required',
                'colorclass.min' => 'Color Class  minimum length is 2',
                'colorclass.max' => 'Color Class  maximum length is 50',
                'colorclass.regex' => 'Invalid characters not allowed for Color Class',
            ]);
            $request->input();
            $role_id = Auth::user()->id;

            $leng=count($request->sel_lang);
            // dd($leng);

            $storeinfo=new Shortalert([
                                'userid'=>Auth::user()->id,
                                'delet_flag'=>0,
                                'status_id'=>1,
                                'colorclass'=>$request->colorclass,
                            ]);

            $res = $storeinfo->save();
            $Short_id = DB::getPdo()->lastInsertId();
// dd($functionid );
            for($i=0;$i<$leng;$i++){

               // dd($request->sel_lang[$i]);
                if($Short_id){

                        $store_sub_info=new Shortalertsub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'shortalertid' => $Short_id,
                                    'content' =>$request->con_title[$i],
                                ]);
                      // dd($store_sub_info);
                         $storedetails_sub=$store_sub_info->save();
                }
                // dd($path);
            }//forloopend

            return redirect()->route('shortalert')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

        /*Shortalert delete*/
    public function deleteshortalert($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();

             $res_sub= Shortalertsub::where('shortalertid',$id)->delete();

            if($res_sub)
            {
             $res= Shortalert::findOrFail($id)->delete();

            }
            $edit_f ='';
                 if($res_sub){
                    DB::commit();
                     return Redirect('shortalert')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback();
                     return back()->withErrors('Not deleted ');
                 }
    }

    /*Downloads*/
    public function downloads()
    {
        $user=Auth::user()->id;
        // $data = Download::with(['download_sub' =>function($query){

        // }])->where('delet_flag',0)->get();
        $role=Auth::user()->role_id;
        // dd($role);
        $user=Auth::user()->id;
        // dd($user);

        if($role==5)//sbu user
        {
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
                1 => array('title' => 'Download', 'message' => 'Download', 'status' => 1)
             );
        }else if($role==2)//siteadmin
        {
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
                1 => array('title' => 'Download', 'message' => 'Download', 'status' => 1)
             );
        } else if($role==3)//planning
        {
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/planninghome'),
                1 => array('title' => 'Download', 'message' => 'Download', 'status' => 1)
             );
            }
        $data = Download::with(['download_sub' =>function($query){
            // $query->select('alternatetext','subtitle','title')->where('delet_flag',0);
        }])->where('delet_flag',0)->where('userid',$user)->get();

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $usertype=usertype::get();

        return view('Siteadmin.Download.downloadlist',compact('data','breadcrumbarr','usertype','navbar','user'));

    }
    /*Download create*/
    public function createdownload()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();




        $usertype = usertype::where('delet_flag',0)->whereIn('id',[8,9])->where('status_id',1)->get();

        $role=Auth::user()->role_id;
        // dd($role);
        $role_type=Auth::user()->role_id;
        // dd($user);

        if($role_type==5)//sbu user
        {
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
                1 => array('title' => 'Download list', 'message' => 'Download list', 'status' => 1, 'link' => '/sbu/downloads'),
                2 => array('title' => 'Download', 'message' => 'Download', 'status' => 1)
             );
        }else if($role_type==2)//siteadmin
        {
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
                1 => array('title' => 'Download list', 'message' => 'Download list', 'status' => 1, 'link' => '/siteadmin/downloads'),
                2 => array('title' => 'Download', 'message' => 'Download', 'status' => 2)
             );
        }else if($role_type==3)//siteadmin
        {
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/planninghome'),
                1 => array('title' => 'Download list', 'message' => 'Download list', 'status' => 1, 'link' => '/planning/downloads'),
                2 => array('title' => 'Download', 'message' => 'Download', 'status' => 2)
             );
        }

        // $download = Downloadtype::with(['downloadtype_sub' =>function($query){
        //     $query->where('delet_flag',0);
        // }])->where('delet_flag',0)->get();
        $keywordtags=Keywordtag::with(['keytag_sub'=>function($query){}])->get();
        $sbu_type=Auth::user()->sbutype;
        // dd($sbu_type);
        $role_id_multi =Auth::user()->id;
        // dd($role_id_multi);
        $check_multi_sbu1=Downloadtype::with(['downloadtype_sub'=>function($query){
            $query->where('languageid', 1);
        }])->where('status_id',1)->where('delet_flag',0)->where('multi_sbu',$role_id_multi)->where('sbu_type',$sbu_type)->where('viewer_id',1)->get();
        $check_multi_sbu=count($check_multi_sbu1);
            if($check_multi_sbu>0)
            {
                if($role_type==11)
                {
                    $download =   Downloadtype::with(['downloadtype_sub'=>function($query){
                        $query->where('languageid', 1);
                    }])->where('status_id',1)->whereIn('id',[111,6])->where('delet_flag',0)->get();
                }else{
                    $download =   Downloadtype::with(['downloadtype_sub'=>function($query){
                        $query->where('languageid', 1);
                    }])->where('status_id',1)->where('delet_flag',0)->where('multi_sbu',$role_id_multi)->get();
                }

            }else{
                if($role_type==5)//sbu
                        {
                            $download =   Downloadtype::with(['downloadtype_sub'=>function($query){
                                                $query->where('languageid', 1);
                                            }])->where('status_id',1)->where('delet_flag',0)->where('sbu_type',$sbu_type)->get();
                        }else if($role_type==2){//siteadmin
                            $download =   Downloadtype::with(['downloadtype_sub'=>function($query){
                                            $query->where('languageid', 1);
                                        }])->where('status_id',1)->where('delet_flag',0)->get();
                        }else if($role_type==3){//planning
                            $download =   Downloadtype::with(['downloadtype_sub'=>function($query){
                                            $query->where('languageid', 1);
                                        }])->where('viewer_id',1)->where('status_id',1)->where('delet_flag',0)->get();
                        }
            }


        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        return view('Siteadmin.Download.createdownload',compact('keywordtags','breadcrumbarr','language','navbar','user','download','Navid','usertype'));
    }


     /*store Downloads*/

    public function storedownload(Request $request)
    {
//  dd($request->all());
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'descrptn.*'        =>'sometimes',
                    'title.*'           =>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                    'sub_title.*'       =>'sometimes',
                    'downloadtype'      => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    'date'              =>'required',
                    'documentno'        =>'required',
                    'usertype'      =>'sometimes',
                    'viewtype'      =>'sometimes',
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


                $role=Auth::user()->role_id;
                $leng=count($request->sel_lang);
                    if($request->usertype == null)
                    {
                        $usertype=0;
                    }else{
                        $usertype=\Crypt::decryptString($request->usertype);
                    }
                    if(empty($request->homePage_status)){
                        $homePage_status=0;
                    }else{
                        $homePage_status=1;
                    }
                    if(empty($request->main_website_view)){
                        $main_website_view=0;
                    }else{
                        $main_website_view=1;
                    }
                $storeinfo=new Download([
                                    'userid'=>Auth::user()->id,
                                    'sbutype_id'=>Auth::user()->sbutype,
                                    'delet_flag'=>0,
                                    'status_id'=>1,
                                    'downloadtypeid'=>$request->downloadtype,
                                    'date'=>$request->date,
                                    'documentno'=>$request->documentno,
                                    'usertype'=>$usertype,
                                    'viewpermission'=>$request->viewtype,//restricted-2,publicview-1
                                    'homePage_status'=>$homePage_status,
                                    'main_website_status'=>$main_website_view,
                               ]);

                $res = $storeinfo->save();
                $Download_id = DB::getPdo()->lastInsertId();


            if($Download_id){

                for($i=0;$i<$leng;$i++){
                            $store_sub_info=new Downloadsub([
                                        'languageid'=>$request->sel_lang[$i],
                                        'title' =>$request->title[$i],
                                        'downloadid' => $Download_id,
                                        'description' => $request->descrptn[$i],
                                        'alternatetext'=> $request->sub_title[$i],
                                    ]);
                             $storedetails_sub=$store_sub_info->save();
                    }//forloop
                    // dd($path);
                }//ifend
             if($storedetails_sub)
             {
                $user_role = Auth::user()->role_id;

                    if($user_role==5)//sbu user
                    {
                        $breadcrumb = array(
                            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
                            1 => array('title' => 'Download', 'message' => 'Download', 'status' => 0, 'link' => '/sbu/downloads'),
                            2 => array('title' => 'Upload Download', 'message' => 'Upload Download', 'status' => 1)
                         );
                    }else if($user_role==2)//siteadmin
                    {
                        $breadcrumb = array(
                            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
                            1 => array('title' => 'Download', 'message' => 'Download', 'status' => 0, 'link' => '/sbu/downloads'),
                            2 => array('title' => 'Upload Download', 'message' => 'Upload Download', 'status' => 1)
                         );
                    }else if($user_role==3)//planning
                    {
                        $breadcrumb = array(
                            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/planninghome'),
                            1 => array('title' => 'Download list', 'message' => 'Download list', 'status' => 1, 'link' => '/planning/downloads'),
                            2 => array('title' => 'Download Upload', 'message' => 'Download Upload', 'status' => 2)
                         );
                    }
             }

            $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
            $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
            $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
            $galdet = Download::whereId($storeinfo->id)->first();
            // dd($galdet);
            $galitem = Downloaditems::where('download_id', $Download_id)->where('status_id', 1)->get();
            $galitemcnt = count($galitem);

            return view('Siteadmin.Download.uploaddownload',compact('breadcrumbarr','navbar','user','Download_id','galitem','galdet','galitemcnt'));

            } catch (ModelNotFoundException $exception) {
                \LogActivity::addToLog($exception->getMessage(),'error');
                $data = \LogActivity::logLatestItem();
                return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
            }
    }


 /*Download item uppy upload */
 public function downloadstoreuppy(Request $request, $encid)
 {
    // dd($request->name);
     $id = Crypt::decrypt($encid);
     $usertype_id = Auth::user()->role_id;
     $pgmdet = Download::where('id', $id)->first();
     $img_org_name= explode(".",$request->name);

     $files = $request->file;
     $imageName = $img_org_name[0] .'-'. time() . rand() . '.' . $files->extension();
     $request->file('file')->storeAs('/uploads/Downloadtemsuppy', $imageName, 'myfile');

     $formdata = array(
         'download_id' => $id,
         'image' => $imageName,
         'alternate_text' => $request->name,
         'status_id' => 1,
         'user_id'  => Auth::user()->id

     );

     $res=Downloaditems::create($formdata);
     $resusertype=$usertype_id;
// dd($res->id."");

     if ($res) {
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
            1 => array('title' => 'Download', 'message' => 'Download', 'status' => 0, 'link' => '/sbu/downloads'),
            2 => array('title' => 'Upload Download', 'message' => 'Upload Download', 'status' => 1)
         );

         $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
         $galdet = Downloaditems::whereId($res->id)->first();
         $galitem = Downloaditems::where('download_id', $id)->where('status_id', 1)->get();
         // dd($galitem);
         $galitemcnt = count($galitem);

        //  dd($galitemcnt);
         $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
         $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

         return view('Siteadmin.Download.uploaddownload', compact('breadcrumbarr', 'resusertype', 'galdet', 'galitem', 'galitemcnt','navbar','user'));
     }else{
         return back()->withInput()->withErrors('error', 'Not added');
     }

 }


/*Downloads uppy delete*/
    public function downloaditemdel(Request $request, $id)
    {
        // dd(true);
        if ($request->ajax()) {

                // if($usertype_id==4){
                    $galitem = Downloaditems::whereId($id)->first();
                    $galitemimg = public_path('uploads/Downloadtemsuppy/') . $galitem->image;
                    if (file_exists($galitemimg)) {
                        @unlink($galitemimg);
                    }

                    Downloaditems::findOrFail($id)->delete();
                // }else

            return response()->json(['success' => 'Data Updated successfully.']);
        }
    }


    /*Uppy view images */
    public function viewdownloadpics(Request $request, $encid)
    {
        // dd(true);
        $id = Crypt::decrypt($encid);
        $resusertype = User::where('id', Auth::user()->id)->first();
        $usertype_id = Auth::user()->usertype_id;
        $usertype = Auth::user()->usertype_id;
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
            1 => array('title' => 'Download', 'message' => 'Download', 'status' => 0, 'link' => '/sbu/downloads'),
            2 => array('title' => 'Upload Download', 'message' => 'Upload Download', 'status' => 1)
         );


        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $galdet = Download::whereId($id)->first();
        $galitem = Downloaditems::where('download_id', $id)->where('status_id', 1)->get();
        $galitemcnt = count($galitem);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('Siteadmin.Download.uploaddownload', compact('user','navbar','breadcrumbarr', 'resusertype', 'galdet', 'galitem', 'galitemcnt'));


        // return view('Festmanager.film.uploadfilmstills', compact('breadcrumbarr', 'resusertype', 'pgmdet', 'pgmalbum', 'pgmalbumcnt'));
    }

// Edit downloads
    public function editdownloads(Request $request, $encid)
    {

        $edit_f = 'E';

        try {
            $id= Crypt::decryptString($encid);
            $usertype_id=Auth::user()->role_id;
            $resusertype = User::where('id', Auth::user()->id)->first();

            $usertype = usertype::where('delet_flag',0)->whereIn('id',[8,9])->where('status_id',1)->get();

            if($usertype_id == 5 ){//sbu admin
                $breadcrumb = array(
                    0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
                    1 => array('title' => 'Download', 'message' => 'Download', 'status' => 0, 'link' => '/sbu/downloads'),
                    2 => array('title' => 'Upload Download', 'message' => 'Upload Download', 'status' => 1)
                 );
            } else if($usertype_id == 2 ){//siteadmin
                $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
                1 => array('title' => 'List Gallery', 'message' => 'List Gallery', 'status' => 1, 'link' => '/gallerylist'),
                2 => array('title' => 'Edit Gallery', 'message' => 'Edit Gallery', 'status' => 2)
            );
            }else if($usertype_id==3)//planning
            {
                $breadcrumb = array(
                    0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/planninghome'),
                    1 => array('title' => 'Download list', 'message' => 'Download list', 'status' => 1, 'link' => '/planning/downloads'),
                    2 => array('title' => 'Download Upload', 'message' => 'Download Upload', 'status' => 2)
                 );
            }
            // dd($usertype_id);

                $download = Downloadtype::with(['downloadtype_sub' =>function($query){
                    $query->where('delet_flag',0);
                }])->where('delet_flag',0)->get();

                $keywordtags=Keywordtag::with(['keytag_sub'=>function($query){}])->get();
                $keydata = Download::with(['download_sub' =>function($query){
                    $query->with(['lang' => function($query){

                    }]);
                }])->where('delet_flag',0)->where('id', $id)->first();

// dd($keydata);

        } catch (\Illuminate\Database\QueryException $exception) {

        }

        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        return view('Siteadmin.Download.createdownload', compact( 'keywordtags','breadcrumbarr', 'download', 'resusertype', 'edit_f', 'keydata','navbar','user','usertype'));
    }


/**update download */
    public function updatedownload(Request $request)
    {
// dd($request->all());


        $validator = Validator::make(
            $request->all(),
            [
                'descrptn.*'        =>'sometimes',
                'title.*'           =>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'sub_title.*'       =>'sometimes',
                'downloadtype'      => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'date'              =>'required',
                'documentno'        =>'required',
                'usertype'      =>'sometimes',
                'viewtype'      =>'sometimes',
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
        $date = date('dmYH:i:s');
    //    dd($request->all());

        $id=$request->hidden_id;
        if($request->usertype == null)
        {
            $usertype=0;
        }else{
            $usertype=\Crypt::decryptString($request->usertype);
        }
        if(empty($request->homePage_status)){
            $homePage_status=0;
        }else{
            $homePage_status=1;
        }
        if(empty($request->main_website_view)){
            $main_website_view=0;
        }else{
            $main_website_view=1;
        }
        $storeinfo=array(
            'downloadtypeid'=>$request->downloadtype,
            'date'=>$request->date,
            'documentno'=>$request->documentno,
            'sbutype_id'=>Auth::user()->sbutype,
            'usertype'=>$usertype,
            'viewpermission'=>$request->viewtype,//restricted-2,publicview-1
            'homePage_status'=>$homePage_status,
            'main_website_status'=>$main_website_view,
       );
    $res_main_table = Download::where('id',$id)->update($storeinfo);
        //maintable end

        if($res_main_table)
        {
            $galdate =$date;
            $leng=count($request->sel_lang);
            // for($i=0;$i<$leng;$i++){
                $chkrws = Downloadsub::where('downloadid', '=', $id)->exists() ? 1 : 0;
                // dd($chkrws);
                if($chkrws)
               {
            //     $storeinfo=array(
            //         'gallerytypeid'=>$request->gallerytype,
            //         'date'=>$request->date
            //    );


            //    $main_update = Gallery::where('id',$id)->update($storeinfo);

               for($j=0;$j<$leng;$j++){
            //    if($main_update)
            //    {
                $store_sub_info=array(
                    'languageid'=>$request->sel_lang[$j],
                    'title' =>$request->title[$j],
                    'downloadid' => $id,
                    'description' => $request->descrptn[$j],
                    'alternatetext'=> $request->sub_title[$j],
                );

                $storedetails_sub=Downloadsub::where('downloadid',$id)->where('languageid',$request->sel_lang[$j])->update($store_sub_info);
              }//j incre
            }   // if chkrws
        }else{

        }
            $user_role = Auth::user()->role_id;
                if($storedetails_sub)
                {

                    if($user_role==5)//sbu user
                    {
                        $breadcrumb = array(
                            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
                            1 => array('title' => 'Download', 'message' => 'Download', 'status' => 0, 'link' => '/sbu/downloads'),
                            2 => array('title' => 'Upload Download', 'message' => 'Upload Download', 'status' => 1)
                         );
                    }else if($user_role==2)//siteadmin
                    {
                        $breadcrumb = array(
                            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
                            1 => array('title' => 'Download', 'message' => 'Download', 'status' => 0, 'link' => '/sbu/downloads'),
                            2 => array('title' => 'Upload Download', 'message' => 'Upload Download', 'status' => 1)
                         );
                    }else if($user_role==3)//planning
                    {
                        $breadcrumb = array(
                            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/planninghome'),
                            1 => array('title' => 'Download list', 'message' => 'Download list', 'status' => 1, 'link' => '/planning/downloads'),
                            2 => array('title' => 'Download Upload', 'message' => 'Download Upload', 'status' => 2)
                         );
                    }


                    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
                    $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
                    $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
                    $galdet = Download::whereId($id)->first();
                    // dd($galdet);
                    $galitem = Downloaditems::where('download_id', $id)->where('status_id', 1)->get();
                    $galitemcnt = count($galitem);
                $downloadid=$id;
                    return view('Siteadmin.Download.uploaddownload',compact('breadcrumbarr','navbar','user','downloadid','galitem','galdet','galitemcnt'));

                }//if sub strore


            // }//endfor




    } catch (ModelNotFoundException $exception) {
        \LogActivity::addToLog($exception->getMessage(),'error');
        $data = \LogActivity::logLatestItem();
        return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
    }


    }



/*Downloads delete*/
    public function deletedownloads($id)
    {
        $id= Crypt::decryptString($id);
// dd($id);
            DB::beginTransaction();
           $imageName = Downloaditems::where('download_id', $id)->select('image')->get();
           $user_role=Auth::user()->role_id;
            foreach($imageName as $img){
                    Storage::disk('myfile')->delete('/uploads/Downloadtemsuppy/' . $img->image);
                }
             $res_sub= Downloadsub::where('downloadid',$id)->delete();

            if($res_sub)
            {
             $res= Download::findOrFail($id)->delete();
            }
            $edit_f ='';
                 if($res_sub){
                    DB::commit();
                    if($user_role==5)//sbu user
                    {
                        return Redirect('/sbu/downloads')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                    }else if($user_role==2)//siteadmin
                    {
                        return Redirect('/siteadmin/downloads')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                    }else if($user_role==3)//planning
                    {
                        return Redirect('/planning/downloads')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                    }
                    //  return Redirect('/planning/downloads')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback();
                     return back()->withErrors('Not deleted ');
                 }
    }

  /*counters*/
    public function counters()
    {
        $data = Counter::with(['counter_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

// dd($data);
        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Counters', 'message' => 'Counters', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('Siteadmin.Counter.counterlist',compact('data','breadcrumbarr','language','navbar','user'));
    }

        /*create counters*/
    public function createcounters()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'counters list', 'message' => 'counters list', 'status' => 1, 'link' => '/counters'),
            2 => array('title' => 'Create counters', 'message' => 'Create counters', 'status' => 2)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        return view('Siteadmin.Counter.createcounter',compact('breadcrumbarr','language','navbar','user','Navid'));
    }

 /*store Counter*/

    public function storecounterval(Request $request)
    {
        // dd($request->all());
        try{
          $request->validate([
                'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                // 'counterval'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                // 'iconclass'    => app('App\Http\Controllers\Commonfunctions')->getIconClass(),
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

                    $storeinfo=new Counter([
                        'iconclass'=>$request->iconclass,
                        'countervalue'=>$request->counterval,
                        'userid'=>Auth::user()->id,
                        'delet_flag'=>0,
                        'status_id'=>1,
                    ]);
                                   $res = $storeinfo->save();
                                $counterid = DB::getPdo()->lastInsertId();
                     for($i=0;$i<$leng;$i++){



                                 if($res)
                                {
                                $store_sub_info=new Countersub([
                                'languageid'=>$request->sel_lang[$i],
                                'title' =>$request->title[$i],
                                'counterid'=>$counterid,
                               ]);
                            $storedetails_sub=$store_sub_info->save();


                                }
                                                    DB::commit();
                     }//enffor

            return redirect()->route('counters')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }
/*Counter delete*/
    public function deletecounter($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();

             $res_sub= Countersub::where('counterid',$id)->delete();

            if($res_sub)
            {
             $res= Counter::findOrFail($id)->delete();
            }
            $edit_f ='';
                 if($res_sub){
                    DB::commit();
                     return Redirect('counters')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                 }else{
                    DB::rollback();
                     return back()->withErrors('Not deleted ');
                 }
    }


  /*Customerservices*/
    public function customerservices()
    {
        $data = Customerservice::with(['custservices_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

// dd($data);
        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Customer services', 'message' => 'Customer services', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('Siteadmin.Customerservices.customerserviceslist',compact('data','breadcrumbarr','language','navbar','user'));
    }

            /*create Customer service*/
    public function createcustomerservice()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Customer service  list', 'message' => 'Customer service  list', 'status' => 1, 'link' => '/customerservices'),
            2 => array('title' => 'Create Customer service ', 'message' => 'Create Customer service ', 'status' => 2)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        return view('Siteadmin.Customerservices.createcustomerservices',compact('breadcrumbarr','language','navbar','user','Menulinktype','Navid'));
    }

  /*Store Custservice*/
      public function storecustservice(Request $request)
    {

        try{
            $request->validate([
                'menulinktype' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'sel_lang.*'=>app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
           ],[
                'title.required' => 'Title is required',
                'title.min' => 'Title  minimum lenght is 2',
                'title.max' => 'Title  maximum lenght is 50',
                'title.regex' => 'Invalid characters not allowed for Title',
            ]);
               $request->input();

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
                    elseif($request->articletype)
                    {
                        $menulinktype_data=$request->articletype;
                    }
                    elseif($request->forms)
                    {
                        $menulinktype_data=$request->forms;
                    }  elseif($request->menulinktype==17)
                    {
                        $menulinktype_data='';
                    }



              if ($request->menulinktype != 13) //Anchor|| URL || Form || Article
                {


                            $storeinfo=new Customerservice([
                                'users_id'=>$role_id,
                                'menulinktype_id'=>$request->menulinktype,
                                'menulinktype_data'=>$menulinktype_data,
                                'file'=>0,
                                'delet_flag'=>0,
                                'status_id'=>1,
                            ]);

                        $res = $storeinfo->save();
                        $cust_ser_id = DB::getPdo()->lastInsertId();

                        $leng=count($request->sel_lang);

                     if($res)
                     {
                       for($i=0;$i<$leng;$i++){

                            $storeinfo_sub=new Customerservicesub([
                                'languageid'=>$request->sel_lang[$i],
                                'title' =>$request->title[$i],
                                'customerserviceid'=>$cust_ser_id,
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
                        $imageName = 'customerservice' . $date . '.' . $request->file_type->extension();
                        $path = $request->file('file_type')->storeAs('/uploads/Customerservice', $imageName,'myfile');

                            $storeinfo=new Customerservice([
                                'users_id'=>$role_id,
                                'menulinktype_id'=>$request->menulinktype,
                                'menulinktype_data'=>$imageName,
                                'delet_flag'=>0,
                                'status_id'=>1,
                            ]);
                     }//endisset
                        $res = $storeinfo->save();
                        $cust_ser_id = DB::getPdo()->lastInsertId();
                     $leng=count($request->language);

                    if($res)
                    {
                         for($i=0;$i<$leng;$i++){

                        $date = date('dmYH:i:s');


                                 $storeinfo_sub=new Customerservicesub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'customerserviceid'=>$cust_ser_id,
                                    'delet_flag'=>0,
                                    'status_id'=>1,
                                ]);


                                $res_sub = $storeinfo_sub->save();
                                DB::commit(); DB::rollback();
                            // }

                     }//enffor
            }

                 }
           // }else{
           //    DB::rollback();
           //   return redirect()->back()->withInput()->with('error','Not valid');
           // }

               // $storedetails=$storeinfo->save();
               return redirect()->route('customerservices')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }


  /*Press relase*/
    public function pressreleaselist()
    {
        $data = Pressrelase::with(['pressrel_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

// dd($data);
        $language = Language::where('delet_flag',0)->orderBy('name')->get();


         $role_type=Auth::user()->role_id;
         if($role_type==5)//SBU admin
         {
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
                1 => array('title' => 'Pressrelase', 'message' => 'Pressrelase', 'status' => 1)
             );
         }else if($role_type==2){//siteadmin
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
                1 => array('title' => 'Pressrelase', 'message' => 'Pressrelase', 'status' => 1)
             );
         }

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('Siteadmin.Pressrelase.pressrelaselist',compact('data','breadcrumbarr','language','navbar','user'));
    }

    /*create Pressrelase*/
    public function createpressrel()
    {
        $language = Language::where('delet_flag',0)->orderBy('name')->get();

         $role_type=Auth::user()->role_id;
        //  dd($role_type);
         if($role_type==5)//SBU admin
         {
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
                1 => array('title' => 'Pressrelase list', 'message' => 'Pressrelase list', 'status' => 1, 'link' => '/sbu/pressreleaselist'),
                2 => array('title' => 'Create Pressrelase', 'message' => 'Create Pressrelase', 'status' => 2)
             );
         }else if($role_type==2){//siteadmin
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
                1 => array('title' => 'Pressrelase list', 'message' => 'Pressrelase list', 'status' => 1, 'link' => '/siteadmin/pressreleaselist'),
                2 => array('title' => 'Create Pressrelase', 'message' => 'Create Pressrelase', 'status' => 2)
             );
         }

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
        return view('Siteadmin.Pressrelase.createpressrelase',compact('breadcrumbarr','language','navbar','user','Navid'));
    }

 /*Store Pressrelase*/
      public function storepressrel(Request $request)
    {

        try{
        $validator = Validator::make(
            $request->all(),
            [
                'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'alt_text.*'    => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'file.*'        => app('App\Http\Controllers\Commonfunctions')->article_imgae_upload(),
           ],[
                'title.required' => 'Title is required',
                'title.min' => 'Title  minimum lenght is 2',
                'title.max' => 'Title  maximum lenght is 50',
                'title.regex' => 'Invalid characters not allowed for Title',

                'alt_text.required' => 'Alternative text is required',
                'alt_text.min' => 'Alternative text  minimum lenght is 2',
                'alt_text.max' => 'Alternative text  maximum lenght is 50',
                'alt_text.regex' => 'Invalid characters not allowed for alternative text',

                'file.mimes'   => 'Invalid image format',
                'file.mimes'   => 'Invalid file format',
            ]);
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }
            // dd($request->all());
            $role_id = Auth::user()->id;
            $filename=array();
            $leng=count($request->sel_lang);



                                $storeinfo=new Pressrelase([
                                    'userid'=>Auth::user()->id,
                                    'url'=>$request->url,
                                    'date'=>$request->date,
                                    'delet_flag'=>0,
                                    'status_id'=>1,
                                ]);


            $res = $storeinfo->save();
            $presrelase_id = DB::getPdo()->lastInsertId();

            for($i=0;$i<$leng;$i++){

                if($presrelase_id){
                      $date = date('dmYH:i:s');
                       foreach($request->file('file') as $key => $file)
                        {
                             $imageName = 'Pressrelase' .$request->sel_lang[$i]. $date . '.' . $file->extension();
                             $filename[]=$imageName;
                             $path = $request->file('file')[$i]->storeAs('/uploads/Pressrelase/', $imageName, 'myfile');


                        }
                        $store_sub_info=new Pressrelasesub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'alt_title' =>$request->alt_text[$i],
                                    'description' =>$request->con_title[$i],
                                    'pressrelaseid' => $presrelase_id,
                                    'file' => $filename[$i],
                                    'delet_flag'=>0,
                                    'status_id'=>1,
                                ]);
                         $storedetails_sub=$store_sub_info->save();
                }
                // dd($path);
            }//forloopend
            $role_type=Auth::user()->role_id;
            if($role_type==5)//SBU admin
            {
                return redirect()->route('sbu.pressreleaselist')->with('success','created successfully');
            }else if($role_type==3){//Site admin
                return redirect()->route('siteadmin.pressreleaselist')->with('success','created successfully');
            }



        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }

    public function editpressrelase($id)
    {
        $id= Crypt::decryptString($id);

        $edit_f = 'E';

        $error = '';


        $data = Pressrelase::with(['pressrel_sub' =>function($query){
            // $query->where('delet_flag',0);
        }])->where('delet_flag',0)->get();


        $keydata = Pressrelase::with(['pressrel_sub' =>function($query){
            // $query->select('alternatetext','subtitle','title')->where('delet_flag',0);
        }])->where('delet_flag',0)->where('id',$id)->first();


// dd($keydata);
        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $role_type=Auth::user()->role_id;
        //  dd($role_type);
         if($role_type==5)//SBU admin
         {
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/Sbuadminhome'),
                1 => array('title' => 'Pressrelase list', 'message' => 'Pressrelase list', 'status' => 1, 'link' => '/sbu/pressreleaselist'),
                2 => array('title' => 'Edit Pressrelase', 'message' => 'Edit Pressrelase', 'status' => 2)
             );
         }else if($role_type==2){//siteadmin
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
                1 => array('title' => 'Pressrelase list', 'message' => 'Pressrelase list', 'status' => 1, 'link' => '/siteadmin/pressreleaselist'),
                2 => array('title' => 'Edit Pressrelase', 'message' => 'Edit Pressrelase', 'status' => 2)
             );
         }
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('Siteadmin.Pressrelase.createpressrelase', compact('data','edit_f', 'error','keydata','breadcrumbarr','language','navbar','user'));
    }

        /*Pressrelase update*/

        public function updatepressrel(Request $request)
        {
            // dd($request->all());
            $role_id = Auth::user()->id;
            // dd($role_id);

            try{
                $validator = Validator::make(
                    $request->all(),
                    [
                        'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                        'alt_text.*'    => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                        'file.*'        => app('App\Http\Controllers\Commonfunctions')->article_imgae_upload(),
                   ],[
                        'title.required' => 'Title is required',
                        'title.min' => 'Title  minimum lenght is 2',
                        'title.max' => 'Title  maximum lenght is 50',
                        'title.regex' => 'Invalid characters not allowed for Title',

                        'alt_text.required' => 'Alternative text is required',
                        'alt_text.min' => 'Alternative text  minimum lenght is 2',
                        'alt_text.max' => 'Alternative text  maximum lenght is 50',
                        'alt_text.regex' => 'Invalid characters not allowed for alternative text',

                        'file.mimes'   => 'Invalid image format',
                        'file.mimes'   => 'Invalid file format',
                    ]);
                    if ($validator->fails()) {
                        // dd($validator->errors());
                        return back()->withInput()->withErrors($validator->errors());
                    }

                $leng=count($request->sel_lang);
    // dd($request->all());
            $res_main=Pressrelase::where('id',$request->hidden_id)->update([
                'url'=>$request->url,
                'date'=>$request->date,
            ]);
            if($res_main){
                for ($i=0; $i<count($request->sel_lang); $i++) {
                    if(isset($request->file)){
                        $date = date('dmYH:i:s');
                        foreach($request->file('file') as $key => $file)
                         {
                              $imageName = 'Pressrelase' .$request->sel_lang[$i]. $date . '.' . $file->extension();
                              $filename[]=$imageName;
                              $path = $request->file('file')[$i]->storeAs('/uploads/Pressrelase/', $imageName, 'myfile');


                         }
                        $res=Pressrelasesub::where('pressrelaseid',$request->hidden_id)->where('languageid',$request->sel_lang[$i])
                        ->update([
                            'languageid'=>$request->sel_lang[$i],
                            'title' =>$request->title[$i],
                            'alt_title' =>$request->alt_text[$i],
                            'description' =>$request->con_title[$i],
                            'pressrelaseid' => $request->hidden_id,
                            'file' => $filename[$i],
                  ]);

                    }else{

                         $res=Pressrelasesub::where('pressrelaseid',$request->hidden_id)->where('languageid',$request->sel_lang[$i])
                         ->update([
                             'languageid'=>$request->sel_lang[$i],
                             'title' =>$request->title[$i],
                             'alt_title' =>$request->alt_text[$i],
                             'description' =>$request->con_title[$i],
                             'pressrelaseid' => $request->hidden_id,

                   ]);

                    }
            }
            }


                     $edit_f ='';
                     if($res){
                        $role_type=Auth::user()->role_id;
                        if($role_type==5)//SBU admin
                        {
                            return redirect()->route('sbu.pressreleaselist')->with('success','created successfully');
                        }else if($role_type==3){//Site admin
                            return redirect()->route('siteadmin.pressreleaselist')->with('success','created successfully');
                        }
                     }else{
                         return back()->withErrors('Not Updated ');
                     }
            } catch (ModelNotFoundException $exception) {
                \LogActivity::addToLog($exception->getMessage(),'error');
                $data = \LogActivity::logLatestItem();
                return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
            }

        }
/*Pressrelase Status*/
public function statuspressrelase($id)
{
    $id= Crypt::decryptString($id);
    $status=Pressrelase::where('id',$id)->value('status_id');

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

    $res=Pressrelase::where('id',$id)->update($uparr);

    $edit_f ='';
        if($res){
            DB::commit();
            $role_type=Auth::user()->role_id;
            if($role_type==5)//SBU admin
            {
                return redirect()->route('sbu.pressreleaselist')->with('success','Status updated successfully');
            }else if($role_type==3){//Site admin
                return redirect()->route('siteadmin.pressreleaselist')->with('success','Status updated successfully');
            }
        }else{
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
}
    /*Press relase delete*/
    public function deletepressrelase($id)
    {
        $id= Crypt::decryptString($id);

            DB::beginTransaction();
           $imageName = Pressrelasesub::where('pressrelaseid', $id)->select('file')->get();

            foreach($imageName as $img){
                    Storage::disk('myfile')->delete('/uploads/Pressrelase/' . $img->file);
                }
             $res_sub= Pressrelasesub::where('pressrelaseid',$id)->delete();

            if($res_sub)
            {
             $res= Pressrelase::findOrFail($id)->delete();
            }
            $edit_f ='';
                 if($res_sub){
                    DB::commit();
                    $role_type=Auth::user()->role_id;
                    if($role_type==5)//SBU admin
                    {
                        return redirect()->route('sbu.pressreleaselist')->with('success','created successfully');
                    }else if($role_type==3){//Site admin
                        return redirect()->route('siteadmin.pressreleaselist')->with('success','created successfully');
                    }
                 }else{
                    DB::rollback();
                     return back()->withErrors('Not deleted ');
                 }
    }


     /*Logo*/
    public function logo()
    {
        $data = Logo::with(['logo_sub' =>function($query){
            $query->where('delet_flag',0);
        }])->with(['logo_type' => function($query1){
            $query1->where('delet_flag',0);
        }])->where('delet_flag',0)->get();

// dd($data);//
        $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Logo', 'message' => 'Logo', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.siteadmin.Logo.Logolist',compact('data','breadcrumbarr','language','navbar','user'));
    }

    /*create logo*/
    public function createlogo()
    {

        $language = Language::where('delet_flag',0)->orderBy('name')->get();
        $logotype=Logotype::where('delet_flag',0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Logo', 'message' => 'Logo', 'status' => 1)
         );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();

        return view('Siteadmin.Logo.createlogo',compact('logotype','breadcrumbarr','language','navbar','user','Navid'));
    }

    /*Store logo*/

    public function storelogo(Request $request)
    {
        // dd($request->all());
        try{
          $request->validate([
                'sel_lang.*'=>app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'alt_title.*'=>app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'logotype.*'=>app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
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

            $storeinfo=new Logo([
                                'userid'=>Auth::user()->id,
                                'logotypeid'=>$request->logotype,
                                'delet_flag'=>0,
                                'status_id'=>1,
                            ]);

            $res = $storeinfo->save();
            $logo_id = DB::getPdo()->lastInsertId();

            for($i=0;$i<$leng;$i++){


                if($logo_id){
                     $date = date('dmYH:i:s');
                       foreach($request->file('poster') as $key => $file)
                        {
                             $imageName = 'logo' . $date . '.' . $file->extension();

                             $path=$file->storeAs('/uploads/Logo', $imageName,'myfile');

                        }
                        $store_sub_info=new Logo_sub([
                                    'languageid'=>$request->sel_lang[$i],
                                    'title' =>$request->title[$i],
                                    'alternatetext' =>$request->alt_title[$i],
                                    'poster' => $imageName,
                                    'logoid' => $logo_id,
                                    'userid' => $role_id,
                                    'delet_flag'=>0,
                                    'status_id'=>1,
                                ]);
                         $storedetails_sub=$store_sub_info->save();
                }
                // dd($path);
            }//forloopend

            return redirect()->route('logo')->with('success','created successfully');

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }

    }
    public function updateslist(){
        $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

        $role_id = Auth::user()->id;
        return view('Siteadmin.siteadminhome',compact('navbar','user'));
    }

    /*Site control labels */
    public function sitecontrollabellist()
    {
        $role_id = Auth::user()->id;
      $data = Sitecontrollabel::with(['sitelcontrollabel_sub' =>function($query){
        // $query->where('delet_flag',0);
    }])->where('users_id',$role_id)->get();

      $language = Language::where('delet_flag',0)->orderBy('name')->get();

      $role_type=Auth::user()->role_id;

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
            1 => array('title' => 'Site control labels ', 'message' => 'Site control labels ', 'status' => 1)
        );


      $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
      $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
      $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

    return view('Siteadmin.sitecontrollabel.sitecontrollabellist',compact('data','breadcrumbarr','language','navbar','user'));
    }

  /*sitecontrol create*/
  public function createsitecontrollabel()
  {

      $language = Language::where('delet_flag',0)->orderBy('name')->get();
      $role_id=Auth::user()->role_id;

          $breadcrumb = array(
              0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
              1 => array('title' => 'Site control label', 'message' => 'Site control label', 'status' => 0, 'link' => '/siteadmin/createsitecontrollabel'),
              2 => array('title' => 'Create Site control label', 'message' => 'Create Site control label', 'status' => 1)
           );

      $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
      $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
      $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
      $url = url()->previous();
      $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
      $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();

      return view('Siteadmin.sitecontrollabel.createsitecontrollabel',compact('breadcrumbarr','language','navbar','user','Navid'));
  }

  /*store Site control label*/
  public function storesitecontrollabel(Request $request)
  {

      try{
        $request->validate([
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
          DB::beginTransaction();
          $leng=count($request->sel_lang);
          // dd($leng);

          $storeinfo=new Sitecontrollabel([
                              'users_id'=>$role_id,
                              'status_id'=>1,
                              'keyid'=>$request->keyid,
                          ]);

          $res = $storeinfo->save();
          $sitelabelid = DB::getPdo()->lastInsertId();
// dd($milestoneid);
          for($i=0;$i<$leng;$i++){

             // dd($request->sel_lang[$i]);
              if($sitelabelid){

                      $store_sub_info=new Sitecontrollabelsub([
                                  'languageid'=>$request->sel_lang[$i],
                                  'title' =>$request->title[$i],
                                  'sitelabelid' => $sitelabelid,
                                  'alternatetext'=>$request->sub_title[$i],
                              ]);

                       $storedetails_sub=$store_sub_info->save();
              }
              // dd($path);
          }//forloopend

          if($storedetails_sub)
          {
            DB::commit();
            return redirect()->route('siteadmin.sitecontrollabellist')->with('success','created successfully');

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

   /*edit site label control*/
   public function editsitecontrollabel($id)
   {
       $id= Crypt::decryptString($id);//History::with(['historysub
       $edit_f = 'E';
       $keydata = Sitecontrollabel::with(['sitelcontrollabel_sub' =>function($query){
           // $query->where('delet_flag',0);
       }])->where('id',$id)->first();
       $error = '';
       $data = Sitecontrollabel::with(['sitelcontrollabel_sub' =>function($query){
           // $query->where('delet_flag',0);
       }])->get();

       $language = Language::where('delet_flag',0)->orderBy('name')->get();

        $role_id=Auth::user()->role_id;

           $breadcrumb = array(
               0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
               1 => array('title' => 'Site label control', 'message' => 'Site label control', 'status' => 0, 'link' => '/siteadmin/sitecontrollabellist'),
               2 => array('title' => 'Edit Site label control', 'message' => 'Edit Site label control', 'status' => 1)
            );


       $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
       $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
       $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
       $url = url()->previous();
       $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
       $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();

// dd($keydata);
       return view('Siteadmin.sitecontrollabel.createsitecontrollabel', compact('data','edit_f', 'error','keydata','breadcrumbarr','navbar','user','language','Navid'));
   }

   /*update Site control label*/
  public function updatesitecontrollabel(Request $request)
  {

      try{
        $request->validate([
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
          DB::beginTransaction();
          $leng=count($request->sel_lang);
          // dd($leng);

          $storeinfo=array(
                              'users_id'=>$role_id,
                              'status_id'=>1,
                              'keyid'=>$request->keyid,
                          );

        $res1=Sitecontrollabel::where('id','=',$request->hidden_id)->update($storeinfo);


// dd($milestoneid);
          for($i=0;$i<$leng;$i++){

             // dd($request->sel_lang[$i]);
              if($res1){

                      $store_sub_info=array(
                                  'languageid'=>$request->sel_lang[$i],
                                  'title' =>$request->title[$i],
                                  'sitelabelid' =>$request->hidden_id,
                                  'alternatetext'=>$request->sub_title[$i],
                              );

                $res_sub=Sitecontrollabelsub::where('sitelabelid','=',$request->hidden_id)->where('languageid','=',$request->sel_lang[$i])->update($store_sub_info);

              }
              // dd($path);
          }//forloopend

          if($res_sub)
          {
            DB::commit();
            return redirect()->route('siteadmin.sitecontrollabellist')->with('success','Updated successfully');

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

  public function keyidchecksitecontrollabel(Request $request)
  {
    $keyid=$request->keyid;
    $keyid_status = Sitecontrollabel::where('keyid',$keyid)->pluck('keyid');
    $keyid_count=count($keyid_status);
    return response()->json($keyid_count);
  }

  /*sITE LABEL delete*/
public function deletesitecontrollabel($id)
{
    $id= Crypt::decryptString($id);

        DB::beginTransaction();

         $res_sub= SitecontrollabelSUB::where('sitelabelid',$id)->delete();

        if($res_sub)
        {
         $res= Sitecontrollabel::findOrFail($id)->delete();
        }
        $edit_f ='';
             if($res_sub){
                DB::commit();
                return redirect()->route('siteadmin.sitecontrollabellist')->with('success','Updated successfully');

             }else{
                DB::rollback();
                 return back()->withErrors('Not deleted ');
             }
}

/*sitecontrol label Status*/
public function statussitecontrollabel($id)
    {
        $id= Crypt::decryptString($id);
        $status=Sitecontrollabel::where('id',$id)->value('status_id');

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
        $res=Sitecontrollabel::where('id',$id)->update($uparr);

        $edit_f ='';
        if($res){
            DB::commit();
            return redirect()->route('siteadmin.sitecontrollabellist')->with('success','Updated successfully');

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

    $data = Mainmenu::with(['lang_sel' => function($query){
        $query->where('delet_flag',0);
    }])->with(['menu_link_type' => function($query1){
        $query1->where('delet_flag',0);
    }])->with(['mainmenu_sub' => function($query2){
        $query2->where('delet_flag',0);
    }])->with(['article_type' => function($query4){
        $query4->where('delet_flag',0);
    }])->where('delet_flag',0)->orderBy('orderno','asc')->get();

    $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
        1 => array('title' => 'Main menu', 'message' => 'Main menu', 'status' => 1)
    );

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
    return view('backend.siteadmin.Mainmenu.mainmenu',compact('data','breadcrumbarr','navbar','user','orderno_val'));
}
/*Mainmenu create*/
public function createmainmenu(Request $request)
{

    $language = Language::where('delet_flag',0)->orderBy('name')->get();
    $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();
    // $user_s = User::where('delet_flag',0)->whereIn('role_id',[5])->where('status_id',1)->get();
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

   $orderno =  Mainmenu::max('orderno');
// dd($arttype);
    return view('backend.siteadmin.Mainmenu.createMainmenue',compact('breadcrumbarr','language','navbar','user','Menulinktype','Navid','arttype','orderno'));
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
                        $res_sub = $storeinfo_sub->save();
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
    }])->with(['article_type' => function($query4){
        $query4->where('delet_flag',0);
    }])->where('delet_flag',0)->get();

    $keydata = Mainmenu::with(['lang_sel' => function($query){
        $query->where('delet_flag',0);
    }])->with(['menu_link_type' => function($query1){
        $query1->where('delet_flag',0);
    }])->with(['mainmenu_sub' => function($query2){
        $query2->where('delet_flag',0);
    }])->with(['article_type' => function($query4){
        $query4->where('delet_flag',0);
    }])->where('id',$id)->where('delet_flag',0)->first();

    // dd($keydata);
    // $user_s = User::where('delet_flag',0)->whereIn('role_id',[5])->where('status_id',1)->get();

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


    return view('backend.siteadmin.Mainmenu.createMainmenue', compact('data','edit_f', 'error','keydata','breadcrumbarr','language','Menulinktype','navbar','user','arttype'));
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
                 return Redirect('siteadmin/mainmenu')->with('success','Updated successfully',['edit_f' => $edit_f]);
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
    $data = Submenu::with([
        'lang_sel' => function ($query) {
            $query->where('delet_flag', 0);
        },
    ])
        ->with([
            'submenusub' => function ($query1) {
                // $query1->where('delet_flag',0);
            },
        ])
        ->with([
            'menu_link_types' => function ($query2) {
                $query2->where('delet_flag', 0)->get();
            },
        ])
        ->with([
            'mainmenu_sub_selected' => function ($query3) {
                $query3->where('languageid', 1);
            },
        ])
        ->where('delet_flag', 0)
        ->orderBy('orderno', 'asc')
        ->get();
    // dd($data[0]->mainmenu_sub_selected[0]->title);

    $lang = Language::where('delet_flag', 0)->orderBy('name')->get();
    $Menulinktype = Menulinktype::where('delet_flag', 0)->orderBy('name')->get();
    // $Mainmenu=Mainmenu::where('delet_flag',0)->get();
    $Mainmenu = Mainmenu::with([
        'mainmenu_sub' => function ($query) {
            $query->where('languageid', 1);
        },
    ])
        ->where('delet_flag', 0)
        ->get();

    $breadcrumb = [
        0 => ['title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'],
        1 => ['title' => 'Submenu', 'message' => 'Submenu', 'status' => 1],
    ];
    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
    $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
    return view('backend.siteadmin.Submenu.submenu', compact('data', 'breadcrumbarr', 'lang', 'Menulinktype', 'Mainmenu', 'navbar', 'user'));
}

/*Submenu create*/
public function createsubmenu()
{
    $language = Language::where('delet_flag', 0)->orderBy('name')->get();
    $Menulinktype = Menulinktype::where('delet_flag', 0)->orderBy('name')->get();
    $mainmenu = Mainmenu::with([
        'mainmenu_sub' => function ($query) {
            $query->where('languageid', 1);
        },
    ])
        ->where('delet_flag', 0)
        ->get();
    // dd($mainmenu);
    $breadcrumb = [
        0 => ['title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'],
        1 => ['title' => 'Submenu', 'message' => 'Submenu', 'status' => 0, 'link' => '/siteadmin/submenu'],
        2 => ['title' => 'Create Submenu', 'message' => 'Create Submenu', 'status' => 1],
    ];
    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
    $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
    $url = url()->previous();
    $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
    $Navid = Componentpermission::where('url', '/' . $route)
        ->select('id')
        ->first();

    $arttype = Articletype::with([
        'articletype_sub' => function ($query) {
            $query->where('languageid', 1);
        },
    ])
        ->where('status_id', 1)
        ->where('delet_flag', 0)
        ->get();
    $orderno = Submenu::max('orderno');

    $orderno_val = '';
    if ($orderno == null) {
        $orderno_val = 1;
    } else {
        $orderno_val = $orderno + 1;
    }

    return view('backend.siteadmin.Submenu.createsubmenu', compact('breadcrumbarr', 'language', 'navbar', 'user', 'Menulinktype', 'mainmenu', 'Navid', 'arttype', 'orderno_val'));
}

/**=sbuwisemainmenu */
public function sbuwisemainmenu(Request $request)
{
    // dd($request->all());
    $mainmenu_sbu = Mainmenu::with([
        'mainmenu_sub' => function ($query) {
            $query->where('languageid', 1);
        },
    ])
        ->where('sbu_type', $request->sbu_id)
        ->where('delet_flag', 0)
        ->get();
    // dd($mainmenu_sbu);

    return response()->json($mainmenu_sbu);
}

/*store submenu*/
public function storesubmenu(Request $request)
{
    $validator = Validator::make(
        $request->all(),
        [
            'icon_class' => 'sometimes',
            'title.*' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            'menulinktype' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
            'mainmenuid' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
            'file_type' => app('App\Http\Controllers\Commonfunctions')->getFileval(),
        ],
        [
            'title.required' => 'Title is required',
            'title.regex' => 'The title format is invalid',
            'title.min' => 'Title  minimum length is 3',
            'title.max' => 'Title  maximum length is 150',

            'file_type.mimes' => 'Invalid image format',
        ],
    );
    //

    if ($validator->fails()) {
        // dd($validator->errors());
        return back()->withInput()->withErrors($validator->errors());
    }

    try {
        $request->input();
        $article_id = 0;
        $role_id = Auth::user()->id;
        if ($request->Anchor) {
            $menulinktype_data = $request->Anchor;
        } elseif ($request->url) {
            $menulinktype_data = $request->url;
        } elseif ($request->forms) {
            $menulinktype_data = $request->forms;
        } elseif ($request->menulinktype == 17) {
            $menulinktype_data = '';
            $article_id = 0;
        } elseif ($request->menulinktype == 14 || $request->menulinktype == 20) {
            $menulinktype_data = $request->articletype;
            $article_id = $request->articletype;
            // $url_name='/planning/articledetail/';
            // $menulinktype_data=$url_name.$request->articletype;
        } elseif ($request->menulinktype == 13) {
            $date = date('dmYH:i:s');
            $imageName = $request->title[0] . $date . '.' . $request->file_type->extension();
            $filename = $imageName;
            $path = $request->file('file_type')->storeAs('/uploads/Submenu/', $imageName, 'myfile');
            $menulinktype_data = $filename;
        } elseif ($request->menulinktype == 21) {
            $menulinktype_data = $request->downloadtype;
        } elseif ($request->menulinktype == 22) {
            $menulinktype_data = '';
        }elseif ($request->menulinktype == 23) {
            $menulinktype_data = '';
        }elseif ($request->menulinktype == 24) {
            $menulinktype_data = '';
        }elseif ($request->menulinktype == 25) {
            $menulinktype_data = '';
        }

        if ($request->sbu_user == null) {
            $sbu_user = 0;
        } else {
            $sbu_user = $request->sbu_user;
        }
        if ($request->icon_class == null) {
            $icon_class = 0;
        } else {
            $icon_class = $request->icon_class;
        }

        if ($request->menulinktype != 13) {
            //Anchor|| URL || Form || Article
            $leng = count($request->sel_lang);

            $storeinfo = new Submenu([
                'users_id' => $role_id,
                'mainmenu_id' => $request->mainmenuid,
                'iconclass' => $icon_class,
                'orderno' => $request->ord_num,
                'menulinktype_id' => $request->menulinktype,
                'menulinktype_data' => $menulinktype_data,
                'articletype_id' => $article_id,
                'delet_flag' => 0,
                'status_id' => 1,
            ]);
            // dd($storeinfo);
            $res = $storeinfo->save();
            $Submenusub = DB::getPdo()->lastInsertId();

            $leng = count($request->sel_lang);

            if ($res) {
                for ($i = 0; $i < $leng; $i++) {
                    $storeinfo_sub = new Submenusub([
                        'userid' => $role_id,
                        'languageid' => $request->sel_lang[$i],
                        'title' => $request->title[$i],
                        'submenuid' => $Submenusub,
                    ]);
                    // dd($storeinfo_sub);
                    $res_su = $storeinfo_sub->save();
                    DB::commit();
                } //endfor
            } //ifres
        }
        //endif 13!=
        elseif ($request->menulinktype == 13) {
            // dd(true);
            $leng = count($request->sel_lang);

            $storeinfo = new Submenu([
                'users_id' => $role_id,
                'mainmenu_id' => $request->mainmenuid,
                'iconclass' => $icon_class,
                'orderno' => $request->ord_num,
                'menulinktype_id' => $request->menulinktype,
                'menulinktype_data' => $menulinktype_data,
                'articletype_id' => $article_id,
                'delet_flag' => 0,
                'status_id' => 1,
            ]);
            // dd($storeinfo);
            $res = $storeinfo->save();
            $Submenusub = DB::getPdo()->lastInsertId();
            // dd($Submenusub);
            $leng = count($request->sel_lang);

            if ($res) {
                for ($i = 0; $i < $leng; $i++) {
                    $storeinfo_sub = new Submenusub([
                        'userid' => $role_id,
                        'languageid' => $request->sel_lang[$i],
                        'title' => $request->title[$i],
                        'submenuid' => $Submenusub,
                    ]);
                    // dd($storeinfo_sub);
                    $res_su = $storeinfo_sub->save();
                    DB::commit();
                } //endfor
            } //ifres
        }

        // $storedetails=$storeinfo->save();
        return redirect()->route('submenu')->with('success', 'created successfully');
    } catch (ModelNotFoundException $exception) {
        \LogActivity::addToLog($exception->getMessage(), 'error');
        $data = \LogActivity::logLatestItem();
        return Redirect::back()
            ->withInput()
            ->withErrors('Please contact admin; the error code is ERROR' . $data->id);
    }
}

/*edit mainmenu*/

public function editsubmenu($id)
{
    $id = Crypt::decryptString($id);
    // dd($id);
    $edit_f = 'E';

    $error = '';

    $data = Submenu::with([
        'lang_sel' => function ($query) {
            $query->where('delet_flag', 0);
        },
    ])
        ->with([
            'submenusub' => function ($query1) {
                // $query1->where('delet_flag',0);
            },
        ])
        ->with([
            'menu_link_types' => function ($query2) {
                $query2->where('delet_flag', 0)->get();
            },
        ])
        ->with([
            'mainmenu_sub_selected' => function ($query3) {
                $query3->where('languageid', 1);
            },
        ])
        ->where('delet_flag', 0)
        ->get();

    $keydata = Submenu::with([
        'lang_sel' => function ($query) {
            $query->where('delet_flag', 0);
        },
    ])
        ->with([
            'submenusub' => function ($query1) {
                // $query1->where('delet_flag',0);
            },
        ])
        ->with([
            'menu_link_types' => function ($query2) {
                $query2->where('delet_flag', 0)->get();
            },
        ])
        ->with([
            'mainmenu_sub_selected' => function ($query3) {
                $query3->where('languageid', 1);
            },
        ])
        ->where('id', $id)
        ->where('delet_flag', 0)
        ->first();

    $language = Language::where('delet_flag', 0)->orderBy('name')->get();
    $Menulinktype = Menulinktype::where('delet_flag', 0)->orderBy('name')->get();
    $mainmenu = Mainmenu::with([
        'mainmenu_sub' => function ($query) {
            $query->where('languageid', 1);
        },
    ])
        ->where('delet_flag', 0)
        ->get();

    $breadcrumb = [
        0 => ['title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'],
        1 => ['title' => 'Sub menu', 'message' => 'Sub menu', 'status' => 0, 'link' => '/siteadmin/submenu'],
        2 => ['title' => 'Edit Sub menu', 'message' => 'Edit Sub menu', 'status' => 1],
    ];
    $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

    $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
    $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
    $arttype = Articletype::with([
        'articletype_sub' => function ($query) {
            $query->where('languageid', 1);
        },
    ])
        ->where('status_id', 1)
        ->where('delet_flag', 0)
        ->get();
    // dd($arttype);
    return view('backend.siteadmin.Submenu.createsubmenu', compact('arttype', 'data', 'edit_f', 'error', 'keydata', 'breadcrumbarr', 'language', 'Menulinktype', 'navbar', 'user', 'mainmenu'));
}

/*Submenu update*/

public function updatesubmenu(Request $request)
{
    // dd($request->all());
    try {
        $validator = Validator::make(
            $request->all(),
            [
                'icon_class' => 'sometimes',
                'menulinktype' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'mainmenuid' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'file_type' => app('App\Http\Controllers\Commonfunctions')->getFileval(),
            ],
            [
                'title.required' => 'Title is required',
                'title.regex' => 'The title format is invalid',
                'title.min' => 'Title  minimum length is 3',
                'title.max' => 'Title  maximum length is 150',

                'icon_class.required' => 'Icon Class is required',
                'icon_class.regex' => 'The icon class format is invalid',
                'icon_class.min' => 'Icon Class  minimum length is 3',
                'icon_class.max' => 'Icon Class  maximum length is 30',

                'menulinktype.required' => 'menu type reuired',
                'menulinktype.regex' => 'menu type format is invalid',
                'menulinktype.min' => 'menu type  minimum length is 3',
                'menulinktype.max' => 'menu type  maximum length is 30',
            ],
        );

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        // dd($request->all());

        $role_id = Auth::user()->id;
        $date = date('dmYH:i:s');
        $article_id = 0;
        if ($request->Anchor) {
            $menulinktype_data = $request->Anchor;
        } elseif ($request->url) {
            $menulinktype_data = $request->url;
        } elseif ($request->route) {
            $menulinktype_data = $request->route;
        } elseif ($request->forms) {
            $menulinktype_data = $request->forms;
        } elseif ($request->menulinktype == 17) {
            $menulinktype_data = '';
        } elseif ($request->menulinktype == 14 || $request->menulinktype == 20) {
            $menulinktype_data = $request->articletype;
            $article_id = $request->articletype;
            // $url_name='/planning/articledetail/';
            // $menulinktype_data=$url_name.$request->articletype;
        } elseif ($request->menulinktype == 21) {
            $menulinktype_data = $request->downloadtype;
        } elseif ($request->menulinktype == 22) {
            $menulinktype_data = '';
        }elseif ($request->menulinktype == 23) {
            $menulinktype_data = '';
        }elseif ($request->menulinktype == 24) {
            $menulinktype_data = '';
        }elseif ($request->menulinktype == 25) {
            $menulinktype_data = '';
        }


        if ($request->icon_class == null) {
            $icon_class = 0;
        } else {
            $icon_class = $request->icon_class;
        }

        // dd($sbu_user);
        if ($request->menulinktype != 13) {
            //Anchor|| URL || Form || Article
            $uparr = [
                'users_id' => $role_id,
                'mainmenu_id' => $request->mainmenuid,
                'iconclass' => $icon_class,
                'orderno' => $request->ord_num,
                'menulinktype_id' => $request->menulinktype,
                'menulinktype_data' => $menulinktype_data,
                'articletype_id' => $article_id,
            ];

            $res = Submenu::where('id', $request->hidden_id)->update($uparr);
            //    dd($res);
            // dd($request->sel_lang);
            $leng = count($request->sel_lang);
            $role_id = Auth::user()->id;
            if ($res) {
                for ($i = 0; $i < $leng; $i++) {
                    $storeinfo_sub = [
                        'languageid' => $request->sel_lang[$i],
                        'title' => $request->title[$i],
                        'submenuid' => $request->hidden_id,
                    ];
                    // dd($storeinfo_sub);
                    $res = Submenusub::where('submenuid', $request->hidden_id)
                        ->where('languageid', $request->sel_lang[$i])
                        ->update($storeinfo_sub);
                    DB::commit();
                } //endfor
            } //ifres
        } else {
            if (isset($request->file_type)) {
                $date = date('dmYH:i:s');
                $imageName = $request->title[0] . $date . '.' . $request->file_type->extension();
                $filename = $imageName;
                $path = $request->file('file_type')->storeAs('/uploads/Submenu/', $imageName, 'myfile');
                $menulinktype_data = $filename;
                $uparr = [
                    'users_id' => $role_id,
                    'mainmenu_id' => $request->mainmenuid,
                    'iconclass' => $icon_class,
                    'orderno' => $request->ord_num,
                    'menulinktype_id' => $request->menulinktype,
                    'menulinktype_data' => $menulinktype_data,
                    'viewer_id' => $request->sbu_id,
                ];
            } else {
                $uparr = [
                    'users_id' => $role_id,
                    'mainmenu_id' => $request->mainmenuid,
                    'iconclass' => $icon_class,
                    'orderno' => $request->ord_num,
                    'menulinktype_id' => $request->menulinktype,
                ];
            }

            $res = Submenu::where('id', $request->hidden_id)->update($uparr);
            //    dd($res);
            // dd($request->sel_lang);
            $leng = count($request->sel_lang);
            $role_id = Auth::user()->id;
            if ($res) {
                for ($i = 0; $i < $leng; $i++) {
                    $storeinfo_sub = [
                        'languageid' => $request->sel_lang[$i],
                        'title' => $request->title[$i],
                        'submenuid' => $request->hidden_id,
                    ];
                    // dd($storeinfo_sub);
                    $res = Submenusub::where('submenuid', $request->hidden_id)
                        ->where('languageid', $request->sel_lang[$i])
                        ->update($storeinfo_sub);
                    DB::commit();
                } //endfor
            } //ifres
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
        $edit_f = '';
        if ($res) {
            return Redirect('/siteadmin/submenu')->with('success', 'Updated successfully', ['edit_f' => $edit_f]);
        } else {
            return back()->withErrors('Not Updated ');
        }
    } catch (ModelNotFoundException $exception) {
        \LogActivity::addToLog($exception->getMessage(), 'error');
        $data = \LogActivity::logLatestItem();
        return Redirect::back()
            ->withInput()
            ->withErrors('Please contact admin; the error code is ERROR' . $data->id);
    }
}

/*Submenu delete*/
public function deletesubmenu($id)
{
    $id = Crypt::decryptString($id);

    DB::beginTransaction();
    // $uparr=array(
    //     'delet_flag'=>1,
    //      );
    // $res=Mainmenu::where('id',$id)->update($uparr);
    $res_sub = Submenusub::where('submenuid', $id)->delete();

    if ($res_sub) {
        $res = Submenu::findOrFail($id)->delete();
        // $res_sub=Mainmenusub::where('mainmenuid',$id)->update($uparr);
    }
    $edit_f = '';
    if ($res_sub) {
        DB::commit();
        return Redirect('submenu')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
    } else {
        DB::rollback();
        return back()->withErrors('Not deleted ');
    }
}

/*Subnmenu Status*/
public function statussubmenu($id)
{
    $id = Crypt::decryptString($id);

    DB::beginTransaction();
    $status = Submenu::where('id', $id)->value('status_id');

    if ($status == 1) {
        $uparr = [
            'status_id' => 0,
        ];
    } else {
        $uparr = [
            'status_id' => 1,
        ];
    }

    $res = Submenu::where('id', $id)->update($uparr);
    // dd($res);
    $edit_f = '';
    if ($res) {
        DB::commit();
        return Redirect('submenu')->with('success', 'Status updated successfully', ['edit_f' => $edit_f]);
    } else {
        DB::rollback();
        return back()->withErrors('Not deleted ');
    }
}

public function OrderchangeSubmenu_form(Request $request)
{
    try {
        $id = Crypt::decryptString($request->id); /*dd($request->val);*/
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
        $success = 'Status Updated!';
        return response()->json(['html' => $success]);
    } else {
        $error = 'Not updated status';
        return response()->json(['html' => $error]);
    }
}

 /*midwidget */
 public function midwidget()
 {
         $datas = Midwidget::with(['midwiget_sub' => function ($query) {
          }])->get();
     $breadcrumb = array(
         0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
         1 => array('title' => 'Mid widget', 'message' => 'Mid widget', 'status' => 1)
     );
     $language = Language::where('delet_flag', 0)->orderBy('name')->get();

     $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
     $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
     $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
     return view('backend.siteadmin.Midwidget.midwidget', compact('datas', 'breadcrumbarr', 'navbar', 'user','language'));
 }
 public function storemidwidget(Request $request)
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

          $storeinfo = new Midwidget([
              'userid' => Auth::user()->id,
              'status_id' => 1,
              'value'    =>$request->valuedata,
              'delet_flag' => 0,
          ]);

          $res = $storeinfo->save();
          $widgetid = DB::getPdo()->lastInsertId();

          for ($i = 0; $i < $leng; $i++) {
              if ($widgetid) {
                  $store_sub_info = new Midwidgetsub([
                      'languageid' => $request->sel_lang[$i],
                      'title' => $request->title[$i],
                      'widgetid' => $widgetid,
                  ]);
                  $storedetails_sub = $store_sub_info->save();
              }
              // dd($path);
          } //forloopend

          return redirect()->route('siteadmin.midwidget')->with('success', 'Created successfully');
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
          0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/adminhome'),
          1 => array('title' => 'Tender category', 'message' => 'Tender category', 'status' => 0, 'link' => '/admin/whatwedotype'),
          2 => array('title' => 'Edit Tender category', 'message' => 'Edit Tender category', 'status' => 1)
      );
      $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
      $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
      $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

      return view('backend.admin.linktype.createlinktype', compact('breadcrumbarr', 'navbar', 'user', 'language', 'edit_f', 'keydata'));
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

          return redirect()->route('admin.linktype')->with('success', 'Updated successfully');
      } catch (ModelNotFoundException $exception) {
          \LogActivity::addToLog($exception->getMessage(), 'error');
          $data = \LogActivity::logLatestItem();
          return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
      }
  }


  public function deletelinktype($id)
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
          return Redirect('/admin/tendertypelist')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
      } else {
          DB::rollback();
          return back()->withErrors('Not deleted ');
      }
  }

  /*Links*/
  public function links()
  {
      $data = Link::with(['link_sub' =>function($query){
          // $query->where('delet_flag',0);
      }])->where('delet_flag',0)->orderBy('orderno','asc')->get();

// dd($data);
      $language = Language::where('delet_flag',0)->orderBy('name')->get();

      $breadcrumb = array(
          0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
          1 => array('title' => 'Links', 'message' => 'Links', 'status' => 1)
       );
      $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
      $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
      $user=app('App\Http\Controllers\Commonfunctions')->userinfo();

      return view('backend.siteadmin.Link.linklist',compact('data','breadcrumbarr','language','navbar','user'));
  }


          /*create Link*/
  public function createlinks()
  {

      $language = Language::where('delet_flag',0)->orderBy('name')->get();
      $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();
      $linktype = Linktype::with(['linktype_sub' =>function($query){
          // $query->where('delet_flag',0);
      }])->where('delet_flag',0)->get();
      $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();
      $breadcrumb = array(
        0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
        1 => array('title' => 'Link  list', 'message' => 'Link  list', 'status' => 1, 'link' => '/siteadmin/links'),
        2 => array('title' => 'Edit Link ', 'message' => 'Edit Link ', 'status' => 2)
     );
      $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
      $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
      $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
      $url = url()->previous();
      $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
      $Navid=Componentpermission::where('url','/'.$route)->select('id')->first();
      $arttype =   Articletype::with(['articletype_sub'=>function($query){
          $query->where('languageid', 1);
      }])->where('status_id',1)->where('delet_flag',0)->where('sbu_type',['NULL',0])->get();

      return view('backend.siteadmin.Link.createlink',compact('arttype','breadcrumbarr','language','navbar','user','Menulinktype','linktype','Navid','Menulinktype'));
  }

  /*Store Link*/
    public function storelink(Request $request)
  {
      // dd($request->all());
      try{
      $validator = Validator::make(
          $request->all(),
          [
              'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
              'alt_text.*'   => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
              'file.*'        => 'sometimes|nullable|mimes:jpg,jpeg,png',
         ],[
              'title.required' => 'Title is required',
              'title.min' => 'Title  minimum lenght is 2',
              'title.max' => 'Title  maximum lenght is 50',
              'title.regex' => 'Invalid characters not allowed for Title',

              'alt_text.required' => 'Alternative text is required',
              'alt_text.min' => 'Alternative text  minimum lenght is 2',
              'alt_text.max' => 'Alternative text  maximum lenght is 50',
              'alt_text.regex' => 'Invalid characters not allowed for alternative text',

              'file.mimes'   => 'Invalid image format',
              'file.mimes'   => 'Invalid file format',
          ]);
          if ($validator->fails()) {
              // dd($validator->errors());
              return back()->withInput()->withErrors($validator->errors());
          }
          // dd($request->all());
          $role_id = Auth::user()->id;
          if($request->Anchor)
          {
              $menulinktype_data=$request->Anchor;
          }
          elseif($request->url_menu)
          {
              $menulinktype_data=$request->url_menu;
          }
          elseif($request->articletype)
          {
              $menulinktype_data=$request->articletype;
          }elseif($request->route)
          {
              $menulinktype_data=$request->route;
          }
          elseif($request->forms)
          {
              $menulinktype_data=$request->forms;
          }  elseif($request->menulinktype==17)
          {
              $menulinktype_data='';
          }


          $leng=count($request->sel_lang);
          if(empty($request->url)){
              $url=$request->url;
          }else{
              $url=1;
          }

          $date = date('dmYH:i:s');

                       if (isset($request->file)) {
                              $imageName = 'Linkicon' . $date . '.' . $request->file->extension();
                              $path = $request->file('file')->storeAs('/assets/backend/uploads/Linkicon', $imageName,'myfile');
                       }else{
                          $imageName=0;
                       }
                       $storeinfo=new Link([
                          'userid'=>Auth::user()->id,
                          'iconclass'=>$request->iconclass,
                          'url'=>$url,
                          'file'=>$imageName,
                          'menulinktype_id'=>$request->menulinktype,
                          'menulinktype_data'=>$menulinktype_data,
                          'linktypeid'=>$request->linktype,
                          'delet_flag'=>0,
                          'status_id'=>1,
                      ]);

          $res = $storeinfo->save();
          $link_id = DB::getPdo()->lastInsertId();

          for($i=0;$i<$leng;$i++){

              if($link_id){

                      $store_sub_info=new Linksub([
                                  'languageid'=>$request->sel_lang[$i],
                                  'title' =>$request->title[$i],
                                  'alternatetext' =>$request->alt_text[$i],
                                  'linkid' => $link_id,
                                  'delet_flag'=>0,
                                  'status_id'=>1,
                              ]);
                       $storedetails_sub=$store_sub_info->save();
              }
              // dd($path);
          }//forloopend

          return redirect()->route('links')->with('success','created successfully');

      } catch (ModelNotFoundException $exception) {
          \LogActivity::addToLog($exception->getMessage(),'error');
          $data = \LogActivity::logLatestItem();
          return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
      }

  }

      /*edit Link*/

      public function editlinks($id)
      {

          $id= Crypt::decryptString($id);

          $edit_f = 'E';

          $error = '';

          $data = Link::with(['link_sub' =>function($query){
              $query->with(['lang_sel' => function($query){

              }]);
              // $query->select('alternatetext','subtitle','title')->where('delet_flag',0);
          }])->where('delet_flag',0)->get();

          $keydata = Link::with(['link_sub' =>function($query){
              $query->with(['lang_sel' => function($query){

              }]);
              // $query->select('alternatetext','subtitle','title')->where('delet_flag',0);
          }])->where('delet_flag',0)->where('id',$id)->first();

          $linktype = Linktype::with(['linktype_sub' =>function($query){
              // $query->where('delet_flag',0);
          }])->where('delet_flag',0)->get();
          $Menulinktype= Menulinktype::where('delet_flag',0)->orderBy('name')->get();
  // dd($keydata);
          $language = Language::where('delet_flag',0)->orderBy('name')->get();

          $breadcrumb = array(
              0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/siteadminhome'),
              1 => array('title' => 'Link  list', 'message' => 'Link  list', 'status' => 1, 'link' => '/siteadmin/links'),
              2 => array('title' => 'Edit Link ', 'message' => 'Edit Link ', 'status' => 2)
           );
          $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

          $navbar=app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
          $user=app('App\Http\Controllers\Commonfunctions')->userinfo();
          $arttype =   Articletype::with(['articletype_sub'=>function($query){
              $query->where('languageid', 1);
          }])->where('status_id',1)->where('delet_flag',0)->where('sbu_type',['NULL',0])->get();


          return view('backend.siteadmin.Link.createlink', compact('arttype','data','edit_f', 'error','keydata','breadcrumbarr','language','navbar','user','linktype','Menulinktype'));
      }
  /*Edit Link*/
  public function updatelink(Request $request)
  {
  //    dd($request->all());
      try{
      $validator = Validator::make(
          $request->all(),
          [
              'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
              'alt_text.*'   => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
              'file.*'        => 'sometimes|nullable|mimes:jpg,jpeg,png',
         ],[
              'title.required' => 'Title is required',
              'title.min' => 'Title  minimum lenght is 2',
              'title.max' => 'Title  maximum lenght is 50',
              'title.regex' => 'Invalid characters not allowed for Title',

              'alt_text.required' => 'Alternative text is required',
              'alt_text.min' => 'Alternative text  minimum lenght is 2',
              'alt_text.max' => 'Alternative text  maximum lenght is 50',
              'alt_text.regex' => 'Invalid characters not allowed for alternative text',

              'file.mimes'   => 'Invalid image format',
              'file.mimes'   => 'Invalid file format',
          ]);
          if ($validator->fails()) {
              // dd($validator->errors());
              return back()->withInput()->withErrors($validator->errors());
          }
          // dd($request->all());
          $role_id = Auth::user()->id;
          if($request->Anchor)
          {
              $menulinktype_data=$request->Anchor;

          }
          elseif($request->url_menu)
          {
              $menulinktype_data=$request->url_menu;

          }
          elseif($request->menulinktype==16)
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
          // dd($menulinktype_data);

          $leng=count($request->sel_lang);

          if(empty($request->url)){
              $url='';
          }else{
              $url=$request->url;
          }

          $date = date('dmYH:i:s');

                       if (isset($request->file)) {
                              $imageName = 'Linkicon' . $date . '.' . $request->file->extension();
                              $path = $request->file('file')->storeAs('/assets/backend/uploads/Linkicon', $imageName,'myfile');
                              $storeinfo=array(
                                  'iconclass'=>$request->iconclass,
                                  'url'=>$url,
                                  'file'=>$imageName,
                                  'menulinktype_id'=>$request->menulinktype,
                                  'menulinktype_data'=>$menulinktype_data,
                                  'linktypeid'=>$request->linktype,
                              );
                       }else{
                          $storeinfo=array(
                              'iconclass'=>$request->iconclass,
                              'url'=>$url,
                              'menulinktype_id'=>$request->menulinktype,
                              'menulinktype_data'=>$menulinktype_data,
                              'linktypeid'=>$request->linktype,
                          );
                       }

                      $res=Link::where('id',$request->hidden_id)->update($storeinfo);
          if($res){
          for($i=0;$i<$leng;$i++){
                      $store_sub_info=array(
                                  'languageid'=>$request->sel_lang[$i],
                                  'title' =>$request->title[$i],
                                  'alternatetext' =>$request->alt_text[$i],
                                  'linkid' =>$request->hidden_id,
                              );
                       $storedetails_sub=Linksub::where('id',$request->hidden_id)->where('languageid',$request->sel_lang[$i])->update($store_sub_info);
              }
              // dd($path);
          }//forloopend

          return redirect()->route('links')->with('success','Updated successfully');

      } catch (ModelNotFoundException $exception) {
          \LogActivity::addToLog($exception->getMessage(),'error');
          $data = \LogActivity::logLatestItem();
          return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
      }

  }
/*Link delete*/
  public function deletelink($id)
  {

      $id= Crypt::decryptString($id);

          DB::beginTransaction();
         $imageName = Link::where('id', $id)->select('file')->get();
         $res_sub= Linksub::where('linkid',$id)->delete();
      //    dd($res_sub);

                      if($res_sub)
                      {
                      $res= Link::findOrFail($id)->delete();
                      }
                      $edit_f ='';
                          if($res_sub){
                              DB::commit();
                              return Redirect('links')->with('success','Deleted successfully',['edit_f' => $edit_f]);
                          }else{
                              DB::rollback();
                              return back()->withErrors('Not deleted ');
                          }


  }

/*Link Status*/
public function statuslink($id)
  {
      $id= Crypt::decryptString($id);
      $status=Link::where('id',$id)->value('status_id');

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
      $res=Link::where('id',$id)->update($uparr);

      $edit_f ='';
      if($res){
          DB::commit();
          return redirect()->route('links')->with('success','Status updated successfully',['edit_f' => $edit_f]);
      }else{
          DB::rollback();
          return back()->withErrors('Not deleted ');
      }
        }

public function Orderchangelinklist_form(Request $request)
  {
      try {
          $id= Crypt::decryptString($request->id);/*dd($request->val);*/
          $res = Link::where('id', '=', $id)->update(['orderno' => $request->val]);
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

}
