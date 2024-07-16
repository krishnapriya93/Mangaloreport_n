<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Publicrelation;
use App\Models\Language;
use App\Models\usertype;
use App\Models\Componentpermission;
use App\Models\user;
use App\Models\Publicrelationtype;
use App\Models\Department;
use App\Models\publicrelationsub;
use App\Models\Publicrelationitem;
use App\Models\Tender;
use App\Models\TenderSub;
use App\Models\TenderType;
use App\Models\TenderItem;
use App\Models\Whatwedo;
use App\Models\WhatwedoSub;
use App\Models\Whatwedotype;
use App\Models\Whatwedoitems;
use App\Models\Linktype;

use \Crypt;
use DB;
use Redirect;

class MediaadminController extends Controller
{
    public function index()
    {
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.mediaadmin.mediahome', compact('navbar', 'user'));
    }

    /*Public relation*/
    public function publicrelation()
    {
        $role = Auth::user()->role_id;
        // dd($role);
        $user = Auth::user()->id;

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
            1 => array('title' => 'Public Relation', 'message' => 'Public Relation', 'status' => 1)
        );

        $data = Publicrelation::with(['publicrelsub' => function ($query) {
            // $query->select('alternatetext','subtitle','title')->where('delet_flag',0);
        }])->with(['publicrelationtype' => function ($query1){
            $query1->with(['ptypesub' => function ($query) {
                // $query->select('alternatetext','subtitle','title')->where('delet_flag',0);
            }]);
        }])->where('delet_flag', 0)->where('userid', $user)->get();
        // dd($data);
        $language = Language::where('delet_flag', 0)->orderBy('name')->get();

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);


        $usertype = usertype::get();

        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.mediaadmin.publicrelation.publicrelationlist', compact('data', 'breadcrumbarr', 'usertype', 'language', 'navbar', 'user', 'role'));
    }

    /*Status Status*/
    public function statusgallery($id)
    {
        $id = Crypt::decryptString($id);
        $status = Galleries::where('id', $id)->value('status_id');

        DB::beginTransaction();
        if ($status == 1) {
            $uparr = array(
                'status_id' => 0,
            );
        } else {
            $uparr = array(
                'status_id' => 1,
            );
        }

        $res = Galleries::where('id', $id)->update($uparr);

        $edit_f = '';
        if ($res) {
            DB::commit();
            if (Auth::user()->role_id == 5) //SBU admin
            {
                return redirect()->route('sbu.gallerylist')->with('success', 'status change successfully');
            } else if (Auth::user()->role_id == 2) { //Site admin
                return redirect()->route('siteadmin.gallerylist')->with('success', 'status change successfully');
            }
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }
    /*Gallery create*/
    public function createpublicrelation()
    {

        $language = Language::where('delet_flag', 0)->orderBy('name')->get();
        $pulicreltype = Publicrelationtype::with(['ptypesub' => function ($query) {
            $query->where('languageid', 1)->orderBy('title');
        }])->where('delet_flag', 0)->get();


        $departments = Department::where('langcode', 1)->where('status', 1)->where('vid', 'departments')->orderBy('name')->get();


        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
            1 => array('title' => 'List Publicrelation', 'message' => 'List Publicrelation', 'status' => 0, 'link' => '/mediaadmin/publicrelation'),
            2 => array('title' => 'Upload Publicrelation Item', 'message' => 'Upload Publicrelation Item', 'status' => 2)
        );

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid = Componentpermission::where('url', '/' . $route)->select('id')->first();

        //  dd($route);
        return view('backend.mediaadmin.publicrelation.createpublicrelation', compact('breadcrumbarr', 'language', 'navbar', 'user', 'pulicreltype', 'Navid', 'departments'));
    }

    /*Store Gallery*/
    public function storepublicrelation(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'publicrelid'   => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'departmentid'  => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
            ],
            [
                'publicrelid.required' => 'Public relation id is required',
                'departmentid.required' => 'Department id is required',
            ]
        );
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        DB::beginTransaction();

        try {

            $role = Auth::user()->role_id;
            $leng = count($request->sel_lang);

            $storeinfo = new Publicrelation([
                'userid' => Auth::user()->id,
                'delet_flag' => 0,
                'status_id' => 1,
                'departmentid' => $request->departmentid,
                'date' => $request->date,
                'publicreltypeid' => $request->publicrelid,
            ]);

            $res = $storeinfo->save();
            $publicrel_id = DB::getPdo()->lastInsertId();

            if ($publicrel_id) {
                $date = date('dmYH:i:s');
                $j = 1;
                $filename = array();
                if (isset($request->poster)) {
                    foreach ($request->poster as $filep) {

                        if ($j < count($request->poster)) {
                            $date = date('dmYH:i:s');
                            $imageName = 'publicrelation' . $j . $date . '.' . $filep->extension();
                            $filename[] = $imageName;
                            $path = $request->file('poster')[$j]->storeAs('/assets/backend/uploads/publicrelation/', $imageName, 'myfile');

                            $j++;
                        }
                    }
                    for ($i = 0; $i < $leng; $i++) {
                        $store_sub_info = new publicrelationsub([
                            'languageid' => $request->sel_lang[$i],
                            'title' => $request->title[$i],
                            'content' => $request->con_title[$i],
                            'image' => $request->poster[$i],
                            'publicrelationid' => $publicrel_id,

                        ]);
                        $storedetails_sub = $store_sub_info->save();
                    } //forloop
                } else {
                    for ($i = 0; $i < $leng; $i++) {
                        $store_sub_info = new publicrelationsub([
                            'languageid' => $request->sel_lang[$i],
                            'title' => $request->title[$i],
                            'content' => $request->con_title[$i],
                            'publicrelationid' => $publicrel_id,

                        ]);
                        $storedetails_sub = $store_sub_info->save();
                    } //forloop
                }

                // dd($path);
            } //ifend
            if ($storedetails_sub) {
                DB::commit();
                $breadcrumb = array(
                    0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
                    1 => array('title' => 'List Publicrelation', 'message' => 'List Publicrelation', 'status' => 0, 'link' => '/mediaadmin/publicrelation'),
                    2 => array('title' => 'Upload Publicrelation Item', 'message' => 'Upload Publicrelation Item', 'status' => 2)
                );
                $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
                $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
                $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
                $galdet = Publicrelation::whereId($storeinfo->id)->first();
                // dd($galdet);
                $galitem = Publicrelationitem::where('publicrelationid', $publicrel_id)->where('status_id', 1)->get();
                $galitemcnt = count($galitem);
                $usertype_id = Auth::user()->role_id;
                return view('backend.mediaadmin.publicrelation.uploadpublication', compact('breadcrumbarr', 'navbar', 'user', 'publicrel_id', 'galitem', 'galdet', 'galitemcnt', 'usertype_id'));
            } else {
                DB::rollback();
                return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*Gallery item uppy upload */
    public function pressrelstoreuppy(Request $request, $encid)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'file' => 'required|mimes:jpg,jpeg,png,pdf,webp',
            ],
            [



                'file.dimensions' => 'Image resolution does not meet the requirement. Size of the image should be 1090 x 400 (w x h). ',
                'file.mimes'   => 'Invalid image format',
            ]
        );

        if ($validator->fails()) {
            // dd($validator->errors());
            return back()->withInput()->withErrors($validator->errors());
        }
        $id = Crypt::decrypt($encid);
        $usertype_id = Auth::user()->role_id;
        $pgmdet = Publicrelation::where('id', $id)->first();

        $files = $request->file;
        $imageName = time() . rand() . '.' . $files->extension();
        $request->file('file')->storeAs('/assets/backend/uploads/publicrelationitems', $imageName, 'myfile');

        $formdata = array(
            'publicrelationid' => $id,
            'image' => $imageName,
            'alternate_text' => 'Upload',
            'status_id' => 1,
            'user_id'  => Auth::user()->id

        );

        $res = Publicrelationitem::create($formdata);
        $resusertype = $usertype_id;
        // dd($res->id."");

        if ($res) {
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
                1 => array('title' => 'List Publicrelation', 'message' => 'List Publicrelation', 'status' => 0, 'link' => '/mediaadmin/publicrelation'),
                2 => array('title' => 'Upload Publicrelation Item', 'message' => 'Upload Publicrelation Item', 'status' => 2)
            );

            $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
            $galdet = Publicrelationitem::whereId($res->id)->first();
            $galitem = Publicrelationitem::where('publicrelationid', $id)->where('status_id', 1)->get();
            // dd($galitem);
            $galitemcnt = count($galitem);

            // dd($galitemcnt);
            $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
            $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

            return view('backend.mediaadmin.publicrelation.uploadpublication', compact('breadcrumbarr', 'resusertype', 'galdet', 'galitem', 'galitemcnt', 'navbar', 'user', 'usertype_id'));
        } else {
            return back()->withInput()->withErrors('error', 'Not added');
        }
    }
    public function deletepublicrelation(Request $request, $id)
    {

        $id= Crypt::decryptString($id);

        DB::beginTransaction();
       $imageName = Publicrelationitem::where('publicrelationid', $id)->select('image')->get();

        foreach($imageName as $img){
                Storage::disk('myfile')->delete('/assets/backend/uploads/publicrelationitems/' . $img->file);
            }
         $res_sub= publicrelationsub::where('publicrelationid',$id)->delete();

        if($res_sub)
        {
         $res= Publicrelation::where('id',$id)->delete();
        }

             if($res){
                DB::commit();
                return redirect()->route('publicrelation')->with('success','Deleted successfully');

             }else{
                DB::rollback();
                 return back()->withErrors('Not deleted ');
             }


    }

    /*Uppy view images */
    public function viewpressrelpics(Request $request, $encid)
    {
        // dd(true);
        $id = Crypt::decrypt($encid);
        $resusertype = User::where('id', Auth::user()->id)->first();
        $usertype_id = Auth::user()->role_id;
        $usertype = Auth::user()->role_id;
        //return redirect('festmanager/listFilm')->with('msg','Film updated successfully.');
        $resusertype = User::where('id', Auth::user()->id)->first();
        $usertype_id = Auth::user()->usertype_id;

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadmin/publicrelation'),
            1 => array('title' => 'Upload Publicrelation Item', 'message' => 'Upload Publicrelation Item', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        $galdet = Publicrelation::whereId($id)->first();
        $galitem = Publicrelationitem::where('publicrelationid', $id)->where('status_id', 1)->get();
        $galitemcnt = count($galitem);


        $usertype_id = $usertype;
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.mediaadmin.publicrelation.uploadpublication', compact('user', 'navbar', 'breadcrumbarr', 'resusertype', 'galdet', 'galitem', 'galitemcnt', 'usertype_id'));


        // return view('Festmanager.film.uploadfilmstills', compact('breadcrumbarr', 'resusertype', 'pgmdet', 'pgmalbum', 'pgmalbumcnt'));
    }

    /*gallery delete*/
    public function deletegallery($id)
    {
        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        $imageName = Galleryitem1::where('gallery_id', $id)->select('image')->get();

        foreach ($imageName as $img) {
            Storage::disk('myfile')->delete('/uploads/Galleryitemsuppy/' . $img->file);
        }
        $res_sub = Gallery_sub::where('galleryid', $id)->delete();

        if ($res_sub) {
            $res = Galleries::findOrFail($id)->delete();
        }
        $edit_f = '';
        if ($res_sub) {
            DB::commit();
            return redirect()->route('sbu.gallerylist')->with('success', 'status change successfully');
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }


    public function editpublicrelation(Request $request, $encid)
    {

        $edit_f = 'E';

        try {
            $id = Crypt::decryptString($encid);
            $usertype_id = Auth::user()->role_id;
            $resusertype = User::where('id', Auth::user()->id)->first();
            //  dd($id);
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
                1 => array('title' => 'List Publicrelation', 'message' => 'List Publicrelation', 'status' => 0, 'link' => '/mediaadmin/publicrelation'),
                2 => array('title' => 'Upload Publicrelation Item', 'message' => 'Upload Publicrelation Item', 'status' => 2)
            );

            // dd($usertype_id);

            $pulicreltype = Publicrelationtype::where('delet_flag', 0)->orderBy('name')->get();
            $departments = Department::where('langcode', 1)->where('status', 1)->where('vid', 'departments')->orderBy('name')->get();

            $keydata = Publicrelation::with(['publicrelsub' => function ($query) {
                $query->with(['lang' => function ($query) {
                }]);
            }])->where('delet_flag', 0)->where('id', $id)->first();
        } catch (\Illuminate\Database\QueryException $exception) {
        }

        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        return view('backend.mediaadmin.publicrelation.createpublicrelation', compact('breadcrumbarr', 'pulicreltype', 'departments', 'resusertype', 'edit_f', 'keydata', 'navbar', 'user', 'usertype_id', 'usertype_id'));
    }

    public function updatepublicrelation(Request $request)
    {

        $usertype = Auth::user()->role_id;

        $validator = Validator::make(
            $request->all(),
            [
                'title.*'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'publicrelid'   => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'departmentid'  => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
            ],
            [
                'publicrelid.required' => 'Public relation id is required',
                'departmentid.required' => 'Department id is required',
            ]
        );
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        DB::beginTransaction();
        try {
            $date = date('dmYH:i:s');

            $id = $request->hidden_id;

            $storeinfo = array(
                'departmentid' => $request->departmentid,
                'date' => $request->date,
                'publicreltypeid' => $request->publicrelid,
            );

            $res_main_table = Publicrelation::where('id', $id)->update($storeinfo);
            //maintable end
            $leng = count($request->sel_lang);
            $date = date('dmYH:i:s');
            $j = 1;
            $filename = array();
            if (isset($request->poster)) {
                foreach ($request->poster as $filep) {

                    if ($j < count($request->poster)) {
                        $date = date('dmYH:i:s');
                        $imageName = 'publicrelation' . $j . $date . '.' . $filep->extension();
                        $filename[] = $imageName;
                        $path = $request->file('poster')[$j]->storeAs('/assets/backend/uploads/publicrelation/', $imageName, 'myfile');

                        $j++;
                    }
                }
                for ($i = 0; $i < $leng; $i++) {
                    $store_sub_info = array(
                        'languageid' => $request->sel_lang[$i],
                        'title' => $request->title[$i],
                        'content' => $request->con_title[$i],
                        'image' => $request->poster[$i],
                        'publicrelationid' =>  $request->hidden_id,
                    );
                    $storedetails_sub = publicrelationsub::where('publicrelationid', $id)->where('languageid', $request->sel_lang[$i])->update($store_sub_info);
                } //forloop
            } else {
                for ($i = 0; $i < $leng; $i++) {
                    $store_sub_info = array(
                        'languageid' => $request->sel_lang[$i],
                        'title' => $request->title[$i],
                        'content' => $request->con_title[$i],
                        'publicrelationid' => $request->hidden_id,
                    );
                    $storedetails_sub = publicrelationsub::where('publicrelationid', $id)->where('languageid', $request->sel_lang[$i])->update($store_sub_info);
                } //forloop
            }


            if ($storedetails_sub) {
                DB::commit();
                $breadcrumb = array(
                    0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
                    1 => array('title' => 'List Publicrelation', 'message' => 'List Publicrelation', 'status' => 0, 'link' => '/mediaadmin/publicrelation'),
                    2 => array('title' => 'Upload Publicrelation Item', 'message' => 'Upload Publicrelation Item', 'status' => 2)
                );


                $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
                $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
                $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
                $galdet = Publicrelation::whereId($id)->first();
                // dd($usertype_id);
                $galitem = Publicrelationitem::where('publicrelationid', $id)->where('status_id', 1)->get();
                $galitemcnt = count($galitem);
                $gallery_id = $id;
                $usertype_id = $usertype;
                return view('backend.mediaadmin.publicrelation.uploadpublication', compact('breadcrumbarr', 'navbar', 'user', 'gallery_id', 'galitem', 'galdet', 'galitemcnt', 'usertype_id'));
            } else {
                DB::rollback();
                $data = \LogActivity::logLatestItem();
                return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    public function tenderlist()
    {
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
            1 => array('title' => 'Tender', 'message' => 'Tender', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        $usertype = usertype::get();

        $data = Tender::with(['tender_sub' => function ($query) {
        }])->get();

        return view('backend.mediaadmin.tender.tenderlist', compact('breadcrumbarr', 'data', 'navbar', 'user', 'usertype'));
    }
    public function createtender()
    {
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
            1 => array('title' => 'Tender list', 'message' => 'Tender list', 'status' => 1, 'link' => '/mediaadmin/tenderlist'),
            2 => array('title' => 'Tender', 'message' => 'Tender', 'status' => 2)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        $usertype = usertype::get();
        $departments = Department::where('langcode', 1)->where('status', 1)->where('vid', 'departments')->orderBy('name')->get();

        $language = Language::where('delet_flag', 0)->orderBy('name')->get();

        $TenderType = TenderType::with(['tender_type_sub' => function () {
        }])->get();

        $departments = Department::where('langcode', 1)->where('status', 1)->where('vid', 'departments')->orderBy('name')->get();
        return view('backend.mediaadmin.tender.createtender', compact('breadcrumbarr', 'navbar', 'user', 'usertype', 'language', 'TenderType', 'departments'));
    }
    public function storetender(Request $request)
    {

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'descrptn.*'        => 'sometimes',
                    'title.*'           => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                    'tentype'            => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    'department'           => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    's_date'              => 'required',
                    'e_date'              => 'required',
                    'documentno'        => 'required',
                    'usertype'          => 'sometimes',
                    'emd'          => 'sometimes',
                    'corrigendum'          => 'sometimes',
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


            $role = Auth::user()->role_id;
            $leng = count($request->sel_lang);

            $storeinfo = new Tender([
                'user_id' => Auth::user()->id,
                'status_id' => 1,
                'tendertype' => $request->tentype,
                'tenderstartdate' => $request->s_date,
                'tenderenddate' => $request->e_date,
                'tendertype' => $request->tentype,
                'tenderno' => $request->documentno,
                'emd'      => $request->emd,
                'corrigendum'  => $request->corrigendum,
                'department'  => $request->department,
            ]);

            $res = $storeinfo->save();
            $tenderid = DB::getPdo()->lastInsertId();


            if ($tenderid) {

                for ($i = 0; $i < $leng; $i++) {
                    $store_sub_info = new TenderSub([
                        'languageid' => $request->sel_lang[$i],
                        'title' => $request->title[$i],
                        'tenderid' => $tenderid,
                        'description' => $request->descrptn[$i],

                    ]);
                    $storedetails_sub = $store_sub_info->save();
                } //forloop
                // dd($path);
            } //ifend
            if ($storedetails_sub) {
                $breadcrumb = array(
                    0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
                    1 => array('title' => 'Tender list', 'message' => 'Tender list', 'status' => 1, 'link' => '/mediaadmin/tenderlist'),
                    2 => array('title' => 'Tender', 'message' => 'Tender', 'status' => 2)
                );
                $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
                $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
                $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
                $galdet = Tender::whereId($storeinfo->id)->first();
                // dd($galdet);
                $galitem = TenderItem::where('tenderid', $tenderid)->where('status_id', 1)->get();
                $galitemcnt = count($galitem);
                $user_role = Auth::user()->role_id;
                $roletype_id = $user_role;
                return view('backend.mediaadmin.tender.uploadtender', compact('breadcrumbarr', 'navbar', 'user', 'tenderid', 'galitem', 'galdet', 'galitemcnt', 'roletype_id'));
            } else {
                return back()->withInput()->withErrors('error', 'Not added');
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*tender uppy delete*/
    public function tenderitemdel(Request $request, $id)
    {
        // dd(true);
        if ($request->ajax()) {

            // if($usertype_id==4){
            $galitem = TenderItem::whereId($id)->first();
            $galitemimg = public_path('uploads/TenderItem/') . $galitem->image;
            if (file_exists($galitemimg)) {
                @unlink($galitemimg);
            }

            TenderItem::findOrFail($id)->delete();
            // }else

            return response()->json(['success' => 'Data Updated successfully.']);
        }
    }

    /*Uppy view images */
    public function viewtenderpics(Request $request, $encid)
    {
        //    dd(true);
        $id = Crypt::decrypt($encid);
        //    dd($id);
        $resusertype = User::where('id', Auth::user()->id)->first();
        $usertype_id = Auth::user()->usertype_id;
        $usertype = Auth::user()->usertype_id;
        $user_role = Auth::user()->role_id;

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
            1 => array('title' => 'Tender list', 'message' => 'Tender list', 'status' => 1, 'link' => '/mediaadmin/tenderlist'),
            2 => array('title' => 'Tender', 'message' => 'Tender', 'status' => 2)
        );

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $galdet = Tender::whereId($id)->first();
        $galitem = TenderItem::where('tenderid', $id)->where('status_id', 1)->get();
        $galitemcnt = count($galitem);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        $roletype_id = $user_role;
        return view('backend.mediaadmin.tender.uploadtender', compact('user', 'navbar', 'breadcrumbarr', 'resusertype', 'galdet', 'galitem', 'galitemcnt', 'roletype_id'));


        // return view('Festmanager.film.uploadfilmstills', compact('breadcrumbarr', 'resusertype', 'pgmdet', 'pgmalbum', 'pgmalbumcnt'));
    }


    /*tender item uppy upload */
    public function tenderstoreuppy(Request $request, $encid)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'file' => 'required|mimes:jpg,jpeg,png,pdf,webp',
            ],
            [
                // 'file.dimensions' => 'Image resolution does not meet the requirement. Size of the image should be 1090 x 400 (w x h). ',
                'file.mimes'   => 'Invalid image format',
            ]
        );

        if ($validator->fails()) {
            // dd($validator->errors());
            return back()->withInput()->withErrors($validator->errors());
        }

        $id = Crypt::decrypt($encid);

        $usertype_id = Auth::user()->role_id;
        $pgmdet = Tender::where('id', $id)->first();
        $img_org_name = explode(".", $request->name);

        $files = $request->file;
        $imageName = $img_org_name[0] . '-' . time() . rand() . '.' . $files->extension();
        $request->file('file')->storeAs('/assets/backend/uploads/tenderItem', $imageName, 'myfile');

        $formdata = array(
            'tenderid' => $id,
            'image' => $imageName,
            'alternate_text' => $request->name,
            'status_id' => 1,
            'user_id'  => Auth::user()->id

        );

        $res = TenderItem::create($formdata);
        //  dd($res);
        $resusertype = $usertype_id;
        // dd($res->id."");

        if ($res) {
            $user_role = Auth::user()->role_id;
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
                1 => array('title' => 'Tender list', 'message' => 'Tender list', 'status' => 1, 'link' => '/mediaadmin/tenderlist'),
                2 => array('title' => 'Tender', 'message' => 'Tender', 'status' => 2)
            );

            $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
            $galdet = TenderItem::whereId($res->id)->first();
            $galitem = TenderItem::where('tenderid', $id)->where('status_id', 1)->get();
            // dd($galitem);
            $galitemcnt = count($galitem);

            //  dd($galitemcnt);
            $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
            $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

            return view('backend.mediaadmin.tender.uploadtender', compact('breadcrumbarr', 'resusertype', 'galdet', 'galitem', 'galitemcnt', 'navbar', 'user', 'user_role'));
        } else {
            return back()->withInput()->withErrors('error', 'Not added');
        }
    }
    public function edittender($id)
    {
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
            1 => array('title' => 'Tender list', 'message' => 'Tender list', 'status' => 1, 'link' => '/mediaadmin/tenderlist'),
            2 => array('title' => 'Tender', 'message' => 'Tender', 'status' => 2)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        $usertype = usertype::get();

        $language = Language::where('delet_flag', 0)->orderBy('name')->get();

        $departments = Department::where('langcode', 1)->where('status', 1)->where('vid', 'departments')->orderBy('name')->get();

        $language = Language::where('delet_flag', 0)->orderBy('name')->get();

        $TenderType = TenderType::with(['tender_type_sub' => function () {
        }])->get();

        $id = Crypt::decryptString($id);
        $edit_f = 'E';

        $keydata = Tender::with(['tender_sub' => function ($query) {
            $query->with(['lang' => function ($query) {
            }]);
        }])->where('id', $id)->first();

        return view('backend.mediaadmin.tender.createtender', compact('departments', 'breadcrumbarr', 'navbar', 'user', 'usertype', 'language', 'TenderType', 'edit_f', 'keydata'));
    }
    public function updatetender(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'descrptn.*'        => 'sometimes',
                    'title.*'           => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                    'tentype'            => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    'department'           => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    's_date'              => 'required',
                    'e_date'              => 'required',
                    'documentno'        => 'required',
                    'usertype'          => 'sometimes',
                    'emd'          => 'sometimes',
                    'corrigendum'          => 'sometimes',
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

            $role = Auth::user()->role_id;
            $leng = count($request->sel_lang);

            $id = $request->hidden_id;

            $storeinfo = array(
                'tendertype' => $request->tentype,
                'tenderstartdate' => $request->s_date,
                'tenderenddate' => $request->e_date,
                'tenderno' => $request->documentno,
                'emd'      => $request->emd,
                'corrigendum'  => $request->corrigendum,
                'department'  => $request->department,
            );

            $res = Tender::where('id', $id)->update($storeinfo);

            $tenderid = $request->hidden_id;
            // dd($tenderid);

            if ($tenderid) {

                for ($i = 0; $i < $leng; $i++) {
                    $store_sub_info = array(
                        'languageid' => $request->sel_lang[$i],
                        'title' => $request->title[$i],
                        'tenderid' => $tenderid,
                        'description' => $request->descrptn[$i],

                    );
                    //   dd($store_sub_info);
                    $storedetails_sub = TenderSub::where('tenderid', $tenderid)->where('languageid', $request->sel_lang[$i])->update($store_sub_info);
                } //forloop
                // dd($path);
            } //ifend
            if ($storedetails_sub) {
                $breadcrumb = array(
                    0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
                    1 => array('title' => 'Tender list', 'message' => 'Tender list', 'status' => 1, 'link' => '/mediaadmin/tenderlist'),
                    2 => array('title' => 'Tender', 'message' => 'Tender', 'status' => 2)
                );
                $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
                $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
                $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
                $galdet = Tender::whereId($id)->first();
                // dd($galdet);
                $tenderid = $id;
                $galitem = TenderItem::where('tenderid', $tenderid)->where('status_id', 1)->get();
                $galitemcnt = count($galitem);
                $user_role = Auth::user()->role_id;
                $roletype_id = $user_role;
                return view('backend.mediaadmin.tender.uploadtender', compact('breadcrumbarr', 'navbar', 'user', 'tenderid', 'galitem', 'galdet', 'galitemcnt', 'roletype_id'));
            } else {
                return back()->withInput()->withErrors('error', 'Not added');
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*Tender delete*/
    public function deletetender($id)
    {
        $id = Crypt::decryptString($id);
        // dd($id);
        DB::beginTransaction();
        $imageName = TenderItem::where('tenderid', $id)->select('image')->get();
        $user_role = Auth::user()->role_id;
        foreach ($imageName as $img) {
            \Storage::disk('myfile')->delete('/uploads/TenderItem/' . $img->image);
        }
        $res_sub = TenderSub::where('tenderid', $id)->delete();

        if ($res_sub) {
            $res = Tender::findOrFail($id)->delete();
        }
        $edit_f = '';
        if ($res_sub) {
            DB::commit();
            return Redirect('/mediaadmin/tenderlist')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
            //  return Redirect('/planning/downloads')->with('success','Deleted successfully',['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }

    //What we do
    public function whatwedo()
    {
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
            1 => array('title' => 'Tender', 'message' => 'Tender', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        $usertype = usertype::get();

        $data = Whatwedo::with(['whatwedo_sub' => function ($query) {
        }])->get();

        return view('backend.mediaadmin.whatwedo.whatwedolist', compact('breadcrumbarr', 'data', 'navbar', 'user', 'usertype'));
    }

    public function createwhatwedo()
    {
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
            1 => array('title' => 'What we do list', 'message' => 'What we do list', 'status' => 1, 'link' => '/mediaadmin/whatwedo'),
            2 => array('title' => 'What we do', 'message' => 'What we do', 'status' => 2)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        $usertype = usertype::get();
        $departments = Department::where('langcode', 1)->where('status', 1)->where('vid', 'departments')->orderBy('name')->get();

        $language = Language::where('delet_flag', 0)->orderBy('name')->get();

        $Whatwedotypes = Whatwedotype::with(['whatwedotype_sub' => function () {
        }])->get();

        $linktypes = Linktype::with(['linktype_sub' => function () {
        }])->get();
        $departments = Department::where('langcode', 1)->where('status', 1)->where('vid', 'departments')->orderBy('name')->get();
        return view('backend.mediaadmin.whatwedo.createwhatwedo', compact('breadcrumbarr', 'navbar', 'user', 'usertype', 'language', 'Whatwedotypes', 'departments','linktypes'));
    }

    public function storewhatwedo(Request $request)
    {

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'descrptn.*'        => 'sometimes',
                    'title.*'           => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                    'linktypeid'            => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    'e_date'              => 'sometimes',
                    'usertype'          => 'sometimes',
                    'a_eobd'          => 'sometimes',
                    'trade_border'          => 'sometimes',
                    'digi_initi'          => 'sometimes',
                    'media'          => 'sometimes',
                    'eodb_in'          => 'sometimes',
                    'contactus'          => 'sometimes',
                    'e_date'          => 'sometimes',
                    'env_type'          => 'sometimes',
                    'url'          => 'sometimes',
                    'iconupload'          => 'required',
                ],
                [
                    'title.required' => 'Title is required',
                    'title.min' => 'Title  minimum lenght is 2',
                    'title.max' => 'Title  maximum lenght is 50',
                    'title.regex' => 'Invalid characters not allowed for Title',

                    'linktypeid.required' => 'Title is required',

                ]
            );
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }

            $role = Auth::user()->role_id;
            $leng = count($request->sel_lang);

            if ($request->env_type) {
                $env_type = $request->env_type;
            } else {
                $env_type = 0;
            }
            if ($request->url) {
                $url = $request->url;
            } else {
                $url = 0;
            }
            $date = date('dmYH:i:s');
if($request->whatwedotype)
{
    $whatwedotype=$request->whatwedotype;
}else{
    $whatwedotype=0;
}
            if ($request->iconupload) {
                $date = date('dmYH:i:s');
                $imageName = 'iconwhatdo' . $date . '.' . $request->iconupload->extension();
                $filename = $imageName;
                $path = $request->file('iconupload')->storeAs('/assets/backend/uploads/whatwedoicon/', $imageName, 'myfile');
                if ($request->e_date) {
                    $storeinfo = new Whatwedo([
                        'userid' => Auth::user()->id,
                        'status_id' => 1,
                        'linktypeid'=>$request->linktype,
                        'whatwedotypeid' => $whatwedotype,
                        'e_date' => $request->e_date,
                        'env_type' => $env_type,
                        'url' => $url,
                        'iconupload'      => $filename,
                        'delet_flag' => 0,
                    ]);
                } else {
                    $storeinfo = new Whatwedo([
                        'userid' => Auth::user()->id,
                        'status_id' => 1,
                        'linktypeid'=>$request->linktype,
                        'whatwedotypeid' => $whatwedotype,
                        'env_type' => $env_type,
                        'url' => $url,
                        'iconupload'      => $filename,
                        'delet_flag' => 0,
                    ]);
                }

            }else{
                $storeinfo = new Whatwedo([
                    'userid' => Auth::user()->id,
                    'status_id' => 1,
                    'whatwedotypeid' => $request->whatwedotype,
                    'env_type' => $env_type,
                    'url' => $url,
                    'delet_flag' => 0,
                ]);
            }


            $res = $storeinfo->save();
            $whatweid = DB::getPdo()->lastInsertId();


            if ($whatweid) {

                for ($i = 0; $i < $leng; $i++) {
                    if ($request->whatwedotype == 1) {
                        $store_sub_info = new WhatwedoSub([
                            'languageid' => $request->sel_lang[$i],
                            'title' => $request->title[$i],
                            'whatwedoid' => $whatweid,
                            'description' => $request->descrptn[$i],
                            // 'a_eobd'=> $request->a_eobd[$i],
                            // 'trade_border' =>  $request->trade_border[$i],
                            // 'digi_initi' =>  $request->digi_initi[$i],
                            // 'media' =>  $request->media[$i],
                            // 'eodb_in' =>  $request->eodb_in[$i],
                            // 'contactus' =>  $request->contactus[$i],
                        ]);
                    } else if ($request->whatwedotype == 6) {
                        $store_sub_info = new WhatwedoSub([
                            'languageid' => $request->sel_lang[$i],
                            'title' => $request->title[$i],
                            'whatwedoid' => $whatweid,
                            'description' => $request->descrptn[$i],
                            'e_date' => $request->e_date[$i],
                        ]);
                    } else if ($request->whatwedotype == 12) {
                        $store_sub_info = new WhatwedoSub([
                            'languageid' => $request->sel_lang[$i],
                            'title' => $request->title[$i],
                            'whatwedoid' => $whatweid,
                            'description' => $request->descrptn[$i],
                            'env_type' => $request->env_type[$i],
                        ]);
                    } else {
                        $store_sub_info = new WhatwedoSub([
                            'languageid' => $request->sel_lang[$i],
                            'title' => $request->title[$i],
                            'whatwedoid' => $whatweid,
                            'description' => $request->descrptn[$i],
                        ]);
                    }

                    $storedetails_sub = $store_sub_info->save();
                } //forloop
                // dd($path);
            } //ifend
            if ($storedetails_sub) {
                $breadcrumb = array(
                    0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
                    1 => array('title' => 'What we do list', 'message' => 'What we do list', 'status' => 1, 'link' => '/mediaadmin/whatwedo'),
                    2 => array('title' => 'What we do', 'message' => 'What we do', 'status' => 2)
                );
                $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
                $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
                $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
                $galdet = Whatwedo::whereId($storeinfo->id)->first();
                // dd($galdet);
                $galitem = Whatwedoitems::where('whatwedoid', $whatweid)->where('status_id', 1)->get();
                $galitemcnt = count($galitem);
                $user_role = Auth::user()->role_id;
                $roletype_id = $user_role;
                return view('backend.mediaadmin.whatwedo.uploadwhatwedo', compact('breadcrumbarr', 'navbar', 'user', 'whatweid', 'galitem', 'galdet', 'galitemcnt', 'roletype_id'));
            } else {
                return back()->withInput()->withErrors('error', 'Not added');
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }
    /* uppy delete*/
    public function whatwedoitemdel(Request $request, $id)
    {
        // dd(true);
        if ($request->ajax()) {

            // if($usertype_id==4){
            $galitem = Whatwedoitems::whereId($id)->first();
            $galitemimg = public_path('assets/backend/uploads/whatwedoicon/') . $galitem->image;
            if (file_exists($galitemimg)) {
                @unlink($galitemimg);
            }

            Whatwedoitems::findOrFail($id)->delete();
            // }else

            return response()->json(['success' => 'Data Updated successfully.']);
        }
    }

    /*Uppy view images */
    public function viewwhatwedostorepics(Request $request, $encid)
    {
        //    dd(true);
        $id = Crypt::decrypt($encid);
        //    dd($id);
        $resusertype = User::where('id', Auth::user()->id)->first();
        $usertype_id = Auth::user()->usertype_id;
        $usertype = Auth::user()->usertype_id;
        $user_role = Auth::user()->role_id;

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
            1 => array('title' => 'What we do list', 'message' => 'What we do list', 'status' => 1, 'link' => '/mediaadmin/whatwedo'),
            2 => array('title' => 'What we do', 'message' => 'What we do', 'status' => 2)
        );

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $galdet = Whatwedo::whereId($id)->first();
        $galitem = Whatwedoitems::where('whatwedoid', $id)->where('status_id', 1)->get();
        $galitemcnt = count($galitem);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        $roletype_id = $user_role;
        return view('backend.mediaadmin.whatwedo.uploadwhatwedo', compact('user', 'navbar', 'breadcrumbarr', 'resusertype', 'galdet', 'galitem', 'galitemcnt', 'roletype_id'));


        // return view('Festmanager.film.uploadfilmstills', compact('breadcrumbarr', 'resusertype', 'pgmdet', 'pgmalbum', 'pgmalbumcnt'));
    }


    /* item uppy upload */
    public function whatwedostoreuppy(Request $request, $encid)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'file' => 'required|mimes:jpg,jpeg,png,pdf,webp',
            ],
            [
                // 'file.dimensions' => 'Image resolution does not meet the requirement. Size of the image should be 1090 x 400 (w x h). ',
                'file.mimes'   => 'Invalid image format',
            ]
        );

        if ($validator->fails()) {
            // dd($validator->errors());
            return back()->withInput()->withErrors($validator->errors());
        }

        $id = Crypt::decrypt($encid);

        $usertype_id = Auth::user()->role_id;
        $pgmdet = Whatwedo::where('id', $id)->first();
        $img_org_name = explode(".", $request->name);

        $files = $request->file;
        $imageName = $img_org_name[0] . '-' . time() . rand() . '.' . $files->extension();
        $request->file('file')->storeAs('assets/backend/uploads/whatwedoicon/', $imageName, 'myfile');

        $formdata = array(
            'whatwedoid' => $id,
            'image' => $imageName,
            'alternate_text' => $request->name,
            'status_id' => 1,
            'user_id'  => Auth::user()->id

        );

        $res = Whatwedoitems::create($formdata);
        //  dd($res);
        $resusertype = $usertype_id;
        // dd($res->id."");

        if ($res) {
            $user_role = Auth::user()->role_id;
            $breadcrumb = array(
                0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
                1 => array('title' => 'What we do list', 'message' => 'What we do list', 'status' => 1, 'link' => '/mediaadmin/whatwedo'),
                2 => array('title' => 'What we do', 'message' => 'What we do', 'status' => 2)
            );

            $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
            $galdet = Whatwedoitems::whereId($res->id)->first();
            $galitem = Whatwedoitems::where('whatwedoid', $id)->where('status_id', 1)->get();
            // dd($galitem);
            $galitemcnt = count($galitem);

            //  dd($galitemcnt);
            $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
            $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

            return view('backend.mediaadmin.whatwedo.uploadwhatwedo', compact('breadcrumbarr', 'resusertype', 'galdet', 'galitem', 'galitemcnt', 'navbar', 'user', 'user_role'));
        } else {
            return back()->withInput()->withErrors('error', 'Not added');
        }
    }
    public function editwhatwedo($id)
    {
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
            1 => array('title' => 'What we do list', 'message' => 'What we do list', 'status' => 1, 'link' => '/mediaadmin/whatwedo'),
            2 => array('title' => 'What we do', 'message' => 'What we do', 'status' => 2)
        );

        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        $usertype = usertype::get();

        $language = Language::where('delet_flag', 0)->orderBy('name')->get();

        $Whatwedotypes = Whatwedotype::with(['whatwedotype_sub' => function () {
        }])->get();

        $id = Crypt::decryptString($id);
        $edit_f = 'E';

        $keydata = Whatwedo::with(['whatwedo_sub' => function ($query) {
            $query->with(['lang' => function ($query) {
            }]);
        }])->where('id', $id)->first();

        return view('backend.mediaadmin.whatwedo.createwhatwedo', compact('breadcrumbarr', 'navbar', 'user', 'usertype', 'language', 'Whatwedotypes', 'edit_f', 'keydata'));
    }
    public function updatewhatwedo(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'descrptn.*'        => 'sometimes',
                    'title.*'           => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                    'whatwedotype'            => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    'e_date'              => 'sometimes',
                    'usertype'          => 'sometimes',
                    'a_eobd'          => 'sometimes',
                    'trade_border'          => 'sometimes',
                    'digi_initi'          => 'sometimes',
                    'media'          => 'sometimes',
                    'eodb_in'          => 'sometimes',
                    'contactus'          => 'sometimes',
                    'e_date'          => 'sometimes',
                    'env_type'          => 'sometimes',
                    'url'          => 'sometimes',
                ],
                [
                    'title.required' => 'Title is required',
                    'title.min' => 'Title  minimum lenght is 2',
                    'title.max' => 'Title  maximum lenght is 50',
                    'title.regex' => 'Invalid characters not allowed for Title',

                    'whatwedotype.required' => 'Title is required',

                ]
            );
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }

            $role = Auth::user()->role_id;
            $leng = count($request->sel_lang);

            $id = $request->hidden_id;
            if ($request->env_type) {
                $env_type = $request->env_type;
            } else {
                $env_type = 0;
            }
            if ($request->url) {
                $url = $request->url;
            } else {
                $url = 0;
            }
            if($request->whatwedotype)
            {
                $whatwedotype=$request->whatwedotype;
            }else{
                $whatwedotype=0;
            }
// dd($request->all());
            if ($request->iconupload) {

                $date = date('dmYH:i:s');
                $imageName = 'iconwhatdo' . $date . '.' . $request->iconupload->extension();
                $filename = $imageName;
                $path = $request->file('iconupload')->storeAs('/assets/backend/uploads/whatwedoicon/', $imageName, 'myfile');

                $storeinfo = array(
                    'whatwedotypeid' => $whatwedotype,
                    'e_date' => $request->e_date,
                    'env_type' => $env_type,
                    'url' => $url,
                    'linktypeid'=>$request->linktype,
                    'iconupload'      => $filename,
                );
            } else {

                $storeinfo = array(
                    'whatwedotypeid' => $whatwedotype,
                    'e_date' => $request->e_date,
                    'env_type' => $env_type,
                    'linktypeid'=>$request->linktype,
                    'url' => $url,

                );
            }



            $res = Whatwedo::where('id', $id)->update($storeinfo);

            $whatwedoid = $request->hidden_id;
            // dd($tenderid);

            if ($whatwedoid) {

                for ($i = 0; $i < $leng; $i++) {
                    if ($request->whatwedotype == 1) {
                        $store_sub_info = array(
                            'languageid' => $request->sel_lang[$i],
                            'title' => $request->title[$i],
                            'whatwedoid' => $whatwedoid,
                            'description' => $request->descrptn[$i],
                            // 'a_eobd'=> $request->a_eobd[$i],
                            // 'trade_border' =>  $request->trade_border[$i],
                            // 'digi_initi' =>  $request->digi_initi[$i],
                            // 'media' =>  $request->media[$i],
                            // 'eodb_in' =>  $request->eodb_in[$i],
                            // 'contactus' =>  $request->contactus[$i],
                        );
                    } else if ($request->whatwedotype == 6) {
                        $store_sub_info = array(
                            'languageid' => $request->sel_lang[$i],
                            'title' => $request->title[$i],
                            'whatwedoid' => $whatwedoid,
                            'description' => $request->descrptn[$i],
                            'e_date' => $request->e_date[$i],
                        );
                    } else if ($request->whatwedotype == 12) {
                        $store_sub_info = array(
                            'languageid' => $request->sel_lang[$i],
                            'title' => $request->title[$i],
                            'whatwedoid' => $whatwedoid,
                            'description' => $request->descrptn[$i],
                            'env_type' => $request->env_type[$i],
                        );
                    } else {
                        $store_sub_info = array(
                            'languageid' => $request->sel_lang[$i],
                            'title' => $request->title[$i],
                            'whatwedoid' => $whatwedoid,
                            'description' => $request->descrptn[$i],
                        );
                    }

                    //   dd($store_sub_info);
                    $storedetails_sub = WhatwedoSub::where('whatwedoid', $whatwedoid)->where('languageid', $request->sel_lang[$i])->update($store_sub_info);
                } //forloop
                // dd($path);
            } //ifend
            if ($storedetails_sub) {
                $breadcrumb = array(
                    0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/mediaadminhome'),
                    1 => array('title' => 'What we do list', 'message' => 'What we do list', 'status' => 1, 'link' => '/mediaadmin/whatwedo'),
                    2 => array('title' => 'What we do', 'message' => 'What we do', 'status' => 2)
                );
                $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
                $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
                $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
                $galdet = Tender::whereId($id)->first();
                // dd($galdet);
                $whatwedoid = $id;
                $galitem = Whatwedoitems::where('whatwedoid', $whatwedoid)->where('status_id', 1)->get();
                $galitemcnt = count($galitem);
                $user_role = Auth::user()->role_id;
                $roletype_id = $user_role;
                return view('backend.mediaadmin.whatwedo.uploadwhatwedo', compact('breadcrumbarr', 'navbar', 'user', 'whatwedoid', 'galitem', 'galdet', 'galitemcnt', 'roletype_id'));
            } else {
                return back()->withInput()->withErrors('error', 'Not added');
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*Tender delete*/
    public function deletewhatwedo($id)
    {
        $id = Crypt::decryptString($id);
        // dd($id);
        DB::beginTransaction();
        $imageName = TenderItem::where('tenderid', $id)->select('image')->get();
        $user_role = Auth::user()->role_id;
        foreach ($imageName as $img) {
            \Storage::disk('myfile')->delete('/uploads/TenderItem/' . $img->image);
        }
        $res_sub = TenderSub::where('tenderid', $id)->delete();

        if ($res_sub) {
            $res = Tender::findOrFail($id)->delete();
        }
        $edit_f = '';
        if ($res_sub) {
            DB::commit();
            return Redirect('/mediaadmin/tenderlist')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
            //  return Redirect('/planning/downloads')->with('success','Deleted successfully',['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }


}
