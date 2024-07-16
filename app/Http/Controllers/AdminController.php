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
use App\Models\Publicrelationtype;
use App\Models\Gallerytype;
use App\Models\Articletype;
use App\Models\Articletypesub;
use App\Models\TenderType;
use App\Models\TenderTypeSub;
use App\Models\Whatwedotype;
use App\Models\Whatwedotypesub;
use App\Models\Linktype;
use App\Models\Linktypesub;

use \Crypt;
use DB;
use Redirect;

class AdminController extends Controller
{

    /*master dashboard*/
    public function masteradminhome()
    {
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.admin.masterhome', compact('navbar', 'user'));
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
        $logs = LogActivity::with(['users' => function ($query) {
            $query->select('id', 'name');
        }])->orderBy('id', 'DESC')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'LogActivity', 'message' => 'LogActivity', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('Master.Logoactivity.logActivity', compact('logs', 'breadcrumbarr', 'navbar'));
    }

    /*Usertype view */
    public function usertype()
    {
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Usertype', 'message' => 'Usertype', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        $data = usertype::where('delet_flag', 0)->get();
        return view('backend.admin.Usertype.usertype', compact('data', 'breadcrumbarr', 'navbar', 'user'));
    }

    /*Usertype add*/
    public function storeusertype(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'usertype'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),

                ],
                [
                    'usertype.required' => 'Title is required',
                    'usertype.min' => 'Title  minimum lenght is 2',
                    'usertype.max' => 'Title  maximum lenght is 50',
                    'usertype.regex' => 'Invalid characters not allowed for Title',
                ]
            );
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }

            $storeinfo = new usertype([
                'usertype' => $request->usertype,
                'delet_flag' => 0,
                'status_id' => 1,
            ]);

            $storedetails = $storeinfo->save();
            return redirect()->route('usertype')->with('success', 'created successfully');
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*user type edit*/
    public function editusertype($id)
    {
        $id = Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = usertype::where('id', $id)->first();
        $error = '';
        $data = usertype::where('delet_flag', 0)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Usertype', 'message' => 'Usertype', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.admin.Usertype.usertype', compact('data', 'edit_f', 'error', 'keydata', 'breadcrumbarr', 'navbar', 'user'));
    }

    /*user type  update*/
    public function updateusertype(Request $request)
    {
        try {
            $request->validate([
                'usertype' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            ]);
            $request->input();

            $uparr = array(
                'usertype' => $request->usertype,
            );

            $res = usertype::where('id', $request->hidden_id)->update($uparr);
            $edit_f = 'U';
            if ($res) {
                return Redirect('usertype')->with('success', 'Updated successfully', ['edit_f' => $edit_f]);
            } else {
                return back()->withErrors('Not Updated ');
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*user type delete*/
    public function deleteusertype($id)
    {
        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        // $uparr=array(
        //     'delet_flag'=>1,
        //      );
        $res = Usertype::findOrFail($id)->delete();
        // $res=usertype::where('id',$id)->update($uparr);
        $edit_f = '';
        if ($res) {
            DB::commit();
            return Redirect('usertype')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }

    /*Usertype Status*/
    public function statususertype($id)
    {
        // dd($id);
        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        $keydata = Usertype::where('id', $id)->select('status_id')->first();
        // dd($keydata);
        if (($keydata->status_id == 1)) {
            $uparr = array(
                'status_id' => 0,
            );
        } else {

            $uparr = array(
                'status_id' => 1,
            );
        }
        $res = Usertype::where('id', $id)->update($uparr);

        $edit_f = '';
        if ($res) {
            DB::commit();
            return Redirect('usertype')->with('success', 'Status updated successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }


    /*user*/
    public function user()
    {
        $data = User::with(['role_users' => function () {
        }])->where('delet_flag', 0)->get();

        $usertype = usertype::where('delet_flag', 0)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'User', 'message' => 'User', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.admin.Users.user', compact('data', 'usertype', 'navbar', 'user'));
    }

    /*storeuser*/
    public function storeuser(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'usertype'  => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'username'  => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'email'     => app('App\Http\Controllers\Commonfunctions')->emailId_check(),
                'password'  => 'required | min:8',
                'mobile'    => app('App\Http\Controllers\Commonfunctions')->mobileNum_check(),
                'fullname' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            ], [
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
                return redirect()->back()->withInput()->with('error', 'User email already used');
            } else {
                if ($request->usertype == 5) {
                    $storeinfo = new user([
                        'name' => $request->username,
                        'fullname' => $request->fullname,
                        'mobile' => $request->mobile,
                        'email' => $request->email,
                        'role_id' => $request->usertype,
                        'password' => Hash::make($request->password),
                        'status_id' => 1,
                        'sbutype' => $request->sbutype,
                    ]);
                } else {
                    $storeinfo = new user([
                        'name' => $request->username,
                        'fullname' => $request->fullname,
                        'mobile' => $request->mobile,
                        'email' => $request->email,
                        'role_id' => $request->usertype,
                        'password' => Hash::make($request->password),
                        'status_id' => 1,
                    ]);
                }


                $storedetails = $storeinfo->save();

                return redirect()->route('user')->with('success', 'created successfully');
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*user edit*/
    public function edituser($id)
    {

        $id = Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = User::where('id', $id)->first();
        $error = '';
        $usertype = usertype::where('delet_flag', 0)->get();
        $data = User::where('delet_flag', 0)->get();
        $sbutype = Sbutype::where('delet_flag', 0)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'edituser', 'message' => 'edituser', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        // dd($keydata);
        return view('backend.admin.Users.user', compact('data', 'edit_f', 'error', 'keydata', 'breadcrumbarr', 'navbar', 'user', 'usertype', 'sbutype'));
    }

    /*user type  update*/
    public function updateuser(Request $request)
    {

        try {
            $request->validate([
                'usertype'  => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'username'  => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'email'     => app('App\Http\Controllers\Commonfunctions')->emailId_check(),
                'password'  => 'required | min:8',
                'mobile'    => app('App\Http\Controllers\Commonfunctions')->mobileNum_check(),
                'fullname' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            ], [
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
            if ($request->usertype == 5) {

                $uparr = array(
                    'name' => $request->username,
                    'fullname' => $request->fullname,
                    'mobile' => $request->mobile,
                    'email' => $request->email,
                    'role_id' => $request->usertype,
                    'sbutype' => $request->sbutype,
                    'password' => Hash::make($request->password),
                );
            } else {
                $uparr = array(
                    'name' => $request->username,
                    'fullname' => $request->fullname,
                    'mobile' => $request->mobile,
                    'email' => $request->email,
                    'role_id' => $request->usertype,
                    'password' => Hash::make($request->password),
                );
            }


            $res = User::where('id', $request->hidden_id)->update($uparr);
            $edit_f = 'U';
            if ($res) {
                return Redirect('user')->with('success', 'Updated successfully', ['edit_f' => $edit_f]);
            } else {
                return back()->withErrors('Not Updated ');
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*User delete*/
    public function deleteuser($id)
    {

        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        // $uparr=array(
        //     'delet_flag'=>1,
        //      );

        // $res=User::where('id',$id)->update($uparr);
        $res = User::findOrFail($id)->delete();
        $edit_f = '';
        if ($res) {
            DB::commit();
            return Redirect('user')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }

    /*User Status*/
    public function statususer($id)
    {

        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        $keydata = User::where('id', $id)->select('status_id')->first();
        if (($keydata->status_id == 1)) {
            $uparr = array(
                'status_id' => 0,
            );
        } else {

            $uparr = array(
                'status_id' => 1,
            );
        }

        $res = User::where('id', $id)->update($uparr);

        $edit_f = '';
        if ($res) {
            DB::commit();
            return Redirect('user')->with('success', 'Status updated successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }

    /*component*/
    public function component()
    {
        $data = Component::where('delet_flag', 0)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Component', 'message' => 'Component', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.admin.Component.component', compact('data', 'breadcrumbarr', 'navbar', 'user'));
    }

    /*store component*/
    public function storecomponent(Request $request)
    {
        $role_id = Auth::user()->id;
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'component'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                ],
                [
                    'component.required' => 'Title is required',
                    'component.min' => 'Title  minimum lenght is 2',
                    'component.max' => 'Title  maximum lenght is 50',
                    'component.regex' => 'Invalid characters not allowed for Title',

                ]
            );
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }

            $storeinfo = new Component([
                'name' => $request->component,
                'delet_flag' => 0,
                'status_id' => 1,
                'userid' => $role_id
            ]);

            $storedetails = $storeinfo->save();
            return redirect()->route('component')->with('success', 'created successfully');
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*edit component*/
    public function editcomponent($id)
    {
        $id = Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = Component::where('id', $id)->first();
        $error = '';
        $data = Component::where('delet_flag', 0)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Component', 'message' => 'Component', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();


        return view('backend.admin.Component.component', compact('data', 'edit_f', 'error', 'keydata', 'breadcrumbarr', 'navbar', 'user'));
    }

    /*component update*/
    public function updatecomponent(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'component'       => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                ],
                [
                    'component.required' => 'Title is required',
                    'component.min' => 'Title  minimum lenght is 2',
                    'component.max' => 'Title  maximum lenght is 50',
                    'component.regex' => 'Invalid characters not allowed for Title',

                ]
            );
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }

            $uparr = array(
                'name' => $request->component,
            );

            $res = Component::where('id', $request->hidden_id)->update($uparr);
            $edit_f = '';
            if ($res) {
                return Redirect('component')->with('success', 'Updated successfully', ['edit_f' => $edit_f]);
            } else {
                return back()->withErrors('Not Updated ');
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }
    /*Component delete*/
    public function deletecomponent($id)
    {
        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        // $uparr=array(
        //     'delet_flag'=>1,
        //      );
        // $res=Component::where('id',$id)->update($uparr);
        $res = Component::findOrFail($id)->delete();
        $edit_f = '';
        if ($res) {
            DB::commit();
            return Redirect('component')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }

    /*Component Status*/
    public function statuscomponent($id)
    {
        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        $uparr = array(
            'status_id' => 0,
        );
        $res = Component::where('id', $id)->update($uparr);

        $edit_f = '';
        if ($res) {
            DB::commit();
            return Redirect('component')->with('success', 'Status updated successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }

    /*component permissions*/
    public function componentpermissions()
    {
        // $data = Componentpermission::where('delet_flag',0)->get();
        $data = Componentpermission::with(['component' => function ($query) {
            $query->select('id', 'name');
        }])->with(['usertype' => function ($query1) {
            $query1->select('id', 'usertype');
        }])->where('delet_flag', 0)->get();


        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Component permissions', 'message' => 'Component permissions', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        $component = Component::where('delet_flag', 0)->get();

        $usertype = usertype::get();

        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.admin.Componentpermission.componentpermission', compact('data', 'breadcrumbarr', 'component', 'usertype', 'navbar', 'user'));
    }

    /*store componentpermission*/
    public function storecomponentpermi(Request $request)
    {

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'component' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    'usertype' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    'path' => app('App\Http\Controllers\Commonfunctions')->getPath(),
                ],
                [
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

                ]
            );
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

            $storeinfo = new Componentpermission([
                'componentid' => $request->component,
                'url' => $request->path,
                'delet_flag' => 0,
                'status_id' => 1,
                'role_id' => $request->usertype
            ]);

            $storedetails = $storeinfo->save();
            return redirect()->route('componentpermi')->with('success', 'created successfully');
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*edit componentpermission*/
    public function editcomponentper($id)
    {
        $id = Crypt::decryptString($id);
        $edit_f = 'E';
        // $keydata = Componentpermission::where('id',$id)->first();
        $error = '';
        $data = Componentpermission::with(['component' => function ($query) {
            $query->select('id', 'name');
        }])->with(['usertype' => function ($query1) {
            $query1->select('id', 'usertype');
        }])->where('delet_flag', 0)->get();

        $keydata = Componentpermission::with(['component' => function ($query) {
            $query->select('id', 'name');
        }])->with(['usertype' => function ($query1) {
            $query1->select('id', 'usertype');
        }])->where('id', $id)->where('delet_flag', 0)->first();

        $component = Component::where('delet_flag', 0)->get();

        $usertype = usertype::get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Component', 'message' => 'Component', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.admin.Componentpermission.componentpermission', compact('data', 'edit_f', 'error', 'keydata', 'breadcrumbarr', 'component', 'usertype', 'user', 'navbar'));
    }

    /*update componentperm */
    public function updatecomponentperm(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'component' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    'usertype' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                    'path' => app('App\Http\Controllers\Commonfunctions')->getPath(),
                ],
                [
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

                ]
            );
            if ($validator->fails()) {
                // dd($validator->errors());
                return back()->withInput()->withErrors($validator->errors());
            }


            $uparr = array(
                'componentid' => $request->component,
                'url' => $request->path,
                'role_id' => $request->usertype
            );

            $res = Componentpermission::where('id', $request->hidden_id)->update($uparr);
            $edit_f = '';
            if ($res) {
                return Redirect('componentpermi')->with('success', 'Updated successfully', ['edit_f' => $edit_f]);
            } else {
                return back()->withErrors('Not Updated ');
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*delete componentpermn */
    public function deletecomponentper($id)
    {
        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        // $uparr=array(
        //     'delet_flag'=>1,
        //      );
        // $res=Componentpermission::where('id',$id)->update($uparr);

        $res = Componentpermission::findOrFail($id)->delete();
        $edit_f = '';
        if ($res) {
            DB::commit();
            return Redirect('componentpermi')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }

    /*Component permissions Status*/
    public function statuscomperm($id)
    {
        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        $keydata = Componentpermission::where('id', $id)->select('status_id')->first();
        // dd($keydata);
        if (($keydata->status_id == 1)) {
            $uparr = array(
                'status_id' => 0,
            );
        } else {

            $uparr = array(
                'status_id' => 1,
            );
        }
        $edit_f = '';
        $res = Componentpermission::where('id', $id)->update($uparr);
        if ($res) {
            DB::commit();
            return Redirect('componentpermi')->with('success', 'Status updated successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }


    /*language*/
    public function language()
    {
        $data = Language::where('delet_flag', 0)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Language', 'message' => 'Language', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.admin.Language.language', compact('data', 'breadcrumbarr', 'navbar', 'user'));
    }

    /*Store language*/
    public function storelanguage(Request $request)
    {
        $role_id = Auth::user()->id;
        try {


            $validator = Validator::make(
                $request->all(),
                [
                    'language' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
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


            $storeinfo = new Language([
                'name' => $request->language,
                'delet_flag' => 0,
                'status_id' => 1,
                'userid' => $role_id
            ]);

            $storedetails = $storeinfo->save();
            return redirect()->route('language')->with('success', 'created successfully');
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*edit language*/
    public function editlanguage($id)
    {
        $id = Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = Language::where('id', $id)->first();
        $error = '';
        $data = Language::where('delet_flag', 0)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Language', 'message' => 'Language', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('backend.admin.Language.language', compact('data', 'edit_f', 'error', 'keydata', 'breadcrumbarr', 'navbar', 'user'));
    }

    /*language update*/

    public function updatelanguage(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'language' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
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


            $uparr = array(
                'name' => $request->language,
            );

            $res = Language::where('id', $request->hidden_id)->update($uparr);
            $edit_f = '';
            if ($res) {
                return Redirect('language')->with('success', 'Updated successfully', ['edit_f' => $edit_f]);
            } else {
                return back()->withErrors('Not Updated ');
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*language delete*/

    public function deletelanguage($id)
    {
        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        // $uparr=array(
        //     'delet_flag'=>1,
        //      );
        // $res=Language::where('id',$id)->update($uparr);
        $res = Language::findOrFail($id)->delete();
        $edit_f = '';
        if ($res) {

            DB::commit();
            return Redirect('language')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }

    /*LAng Status*/
    public function statuslanguage($id)
    {
        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        $uparr = array(
            'status_id' => 0,
        );
        $res = Language::where('id', $id)->update($uparr);

        $edit_f = '';
        if ($res) {
            DB::commit();
            return Redirect('language')->with('success', 'Status updated successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }







    /*Subsub menu*/
    public function subsubmenu()
    {


        $data = subsubmenu::with(['lang_sel' => function ($query) {
            // $query->where('delet_flag',0);
        }])->with(['subsubmenusub' => function ($query1) {
            // $query1->where('delet_flag',0);
        }])->with(['menu_link_types' => function ($query2) {
            $query2->where('delet_flag', 0)->get();
        }])->with(['sbu_type_user' => function ($query3) {
            $query3->where('delet_flag', 0);
        }])->with(['mainmenu_sub_selected' => function ($query3) {
            $query3->where('languageid', 1);
        }])->with(['submenu_selected' => function ($query3) {
            $query3->where('languageid', 1);
        }])->orderBy('orderno', 'asc')->get();


        $lang = Language::where('delet_flag', 0)->orderBy('name')->get();
        $Menulinktype = Menulinktype::where('delet_flag', 0)->orderBy('name')->get();
        $Mainmenu = Mainmenu::where('delet_flag', 0)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Sub sub menu', 'message' => 'Sub sub menu', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.admin.Subsubmenu.subsubmenu', compact('data', 'breadcrumbarr', 'lang', 'Menulinktype', 'Mainmenu', 'navbar', 'user'));
    }

    /*Create sub sub menu*/
    public function createsubsubmenu()
    {

        $language = Language::where('delet_flag', 0)->orderBy('name')->get();
        $Menulinktype = Menulinktype::where('delet_flag', 0)->orderBy('name')->get();
        $mainmenu = Mainmenu::with(['mainmenu_sub' => function ($query) {
            $query->where('languageid', 1);
        }])->where('delet_flag', 0)->where('viewer_id', 1)->get();
        // dd($mainmenu);
        $user_s = Sbutype::where('delet_flag', 0)->where('status_id', 1)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Sub sub menu', 'message' => 'Sub sub menu', 'status' => 0, 'link' => '/admin/subsubmenu'),
            2 => array('title' => 'Create Sub sub menu', 'message' => 'Create Sub sub enu', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid = Componentpermission::where('url', '/' . $route)->select('id')->first();

        $arttype =   Articletype::with(['articletype_sub' => function ($query) {
            $query->where('languageid', 1);
        }])->where('status_id', 1)->where('delet_flag', 0)->get();


        return view('backend.admin.Subsubmenu.createsubsubmenu', compact('breadcrumbarr', 'language', 'navbar', 'user', 'Menulinktype', 'mainmenu', 'Navid', 'user_s', 'arttype'));
    }
    /*mainmenusbuwise */
    public function mainmenusbuwise(Request $request)
    {
        $mainmenuid = $request->mainmenuid;

        $Submenu = Submenu::with(['lang_sel' => function ($query) {
            $query->where('delet_flag', 0);
        }])->with(['submenusub' => function ($query1) {
            $query1->where('languageid', 1);
        }])->where('mainmenu_id', $mainmenuid)->where('delet_flag', 0)->orderBy('orderno', 'asc')->get();

        // dd($arttype);
        return response()->json($Submenu);
    }
    /*stationtype*/

    /*store subsubmenu*/
    public function storesubsubmenu(Request $request)
    {
        //   dd($request->all());
        try {

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
            } elseif (($request->menulinktype == 14) || ($request->menulinktype == 20)) {
                $menulinktype_data = $request->articletype;
                $article_id = $request->articletype;
                // $url_name='/planning/articledetail/';
                // $menulinktype_data=$url_name.$request->articletype;
            } elseif ($request->menulinktype == 21) {
                $menulinktype_data = $request->downloadtype;
            }
            // dd($request->all());
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


            if ($request->menulinktype != 13) //Anchor|| URL || Form || Article
            {
                $leng = count($request->sel_lang);

                $storeinfo = new subsubmenu([
                    'users_id' => $role_id,
                    'mainmenu_id' => $request->mainmenuid,
                    'submenu_id' => $request->submenuid,
                    'iconclass' => $icon_class,
                    'orderno' => $request->ord_num,
                    'menulinktype_id' => $request->menulinktype,
                    'menulinktype_data' => $menulinktype_data,
                    'viewer_id' => $request->sbu_id,
                    'sbu_type' => $sbu_user,
                    'articletype_id' => $article_id,
                    'delet_flag' => 0,
                    'status_id' => 1,
                ]);
                // dd($storeinfo);
                $res = $storeinfo->save();
                $Subsubmenusub = DB::getPdo()->lastInsertId();

                $leng = count($request->sel_lang);

                if ($res) {
                    for ($i = 0; $i < $leng; $i++) {

                        $storeinfo_sub = new subsubmenusub([
                            'userid' => $role_id,
                            'languageid' => $request->sel_lang[$i],
                            'title' => $request->title[$i],
                            'subsubmenu_id' => $Subsubmenusub,

                        ]);
                        //   dd($storeinfo_sub);
                        $res_su = $storeinfo_sub->save();
                        DB::commit();
                    } //endfor
                } //ifres


            } //endif 13!=
            else if ($request->menulinktype == 13) {
                // dd($request->all());
                $leng = count($request->sel_lang);

                for ($i = 0; $i < $leng; $i++) {

                    $date = date('dmYH:i:s');

                    if (isset($request->file_type)) {

                        $imageName = $request->title[0] . $date . '.' . $request->file_type->extension();
                        $path = $request->file('file_type')->storeAs('/uploads/Subsubmenu', $imageName, 'myfile');
                    } //endisset
                    // dd($imageName);
                    $storeinfo = new subsubmenu([
                        'users_id' => $role_id,
                        'iconclass' => $icon_class,
                        'submenu_id' => $request->submenuid,
                        'orderno' => $request->ord_num,
                        'mainmenu_id' => $request->mainmenuid,
                        'menulinktype_id' => $request->menulinktype,
                        'menulinktype_data' => $imageName,
                        'viewer_id' => $request->sbu_id,
                        'sbu_type' => $sbu_user,
                        'articletype_id' => $article_id,
                        'delet_flag' => 0,
                        'status_id' => 1,
                    ]);
                    // dd($storeinfo);
                    $res = $storeinfo->save();
                    $Subsubmenusub = DB::getPdo()->lastInsertId();

                    $leng = count($request->sel_lang);

                    if ($res) {

                        for ($i = 0; $i < $leng; $i++) {

                            $storeinfo_sub = new subsubmenusub([
                                'userid' => $role_id,
                                'languageid' => $request->sel_lang[$i],
                                'title' => $request->title[$i],
                                'subsubmenu_id' => $Subsubmenusub,

                            ]);
                            //   dd($storeinfo_sub);
                            $res_su = $storeinfo_sub->save();
                            DB::commit();
                        } //endfor
                    } //ifres


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

                } //enffor
            }


            // $storedetails=$storeinfo->save();
            return redirect()->route('admin.subsubmenu')->with('success', 'created successfully');
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }
    /*edit editsubsubmenu*/

    public function editsubsubmenu($id)
    {

        $id = Crypt::decryptString($id);
        // dd($id);
        $edit_f = 'E';

        $error = '';

        $data = subsubmenu::with(['lang_sel' => function ($query) {
            // $query->where('delet_flag',0);
        }])->with(['subsubmenusub' => function ($query1) {
            // $query1->where('delet_flag',0);
        }])->with(['menu_link_types' => function ($query2) {
            $query2->where('delet_flag', 0)->get();
        }])->with(['sbu_type_user' => function ($query3) {
            $query3->where('delet_flag', 0);
        }])->with(['mainmenu_sub_selected' => function ($query3) {
            $query3->where('languageid', 1);
        }])->get();

        $keydata = subsubmenu::with(['lang_sel' => function ($query) {
            // $query->where('delet_flag',0);
        }])->with(['subsubmenusub' => function ($query1) {
            // $query1->where('delet_flag',0);
        }])->with(['menu_link_types' => function ($query2) {
            $query2->where('delet_flag', 0)->get();
        }])->with(['sbu_type_user' => function ($query3) {
            $query3->where('delet_flag', 0);
        }])->with(['mainmenu_sub_selected' => function ($query3) {
            $query3->where('languageid', 1);
        }])->where('id', $id)->first();


        // dd($data);
        // $user_s = User::where('delet_flag',0)->whereIn('role_id',[5])->where('status_id',1)->get();
        $user_s = Sbutype::where('delet_flag', 0)->where('status_id', 1)->get();

        $language = Language::where('delet_flag', 0)->orderBy('name')->get();
        $Menulinktype = Menulinktype::where('delet_flag', 0)->orderBy('name')->get();
        $mainmenu = Mainmenu::with(['mainmenu_sub' => function ($query) {
            $query->where('languageid', 1);
        }])->where('delet_flag', 0)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Sub sub menu', 'message' => 'Sub sub menu', 'status' => 0, 'link' => '/admin/subsubmenu'),
            2 => array('title' => 'Edit Sub menu', 'message' => 'Edit Sub menu', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        $arttype =   Articletype::with(['articletype_sub' => function ($query) {
            $query->where('languageid', 1);
        }])->where('status_id', 1)->where('delet_flag', 0)->get();
        // dd($keydata);
        return view('backend.admin.Subsubmenu.createsubsubmenu', compact('arttype', 'data', 'edit_f', 'error', 'keydata', 'breadcrumbarr', 'language', 'Menulinktype', 'navbar', 'user', 'user_s', 'mainmenu'));
    }

    /*Subsubmenu update*/

    public function updatesubsubmenu(Request $request)
    {
        //    dd($request->all());
        try {

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


            $article_id = 0;
            $role_id = Auth::user()->id;
            $date = date('dmYH:i:s');

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
            } elseif (($request->menulinktype == 14) || ($request->menulinktype == 20)) {
                $menulinktype_data = $request->articletype;
                $article_id = $request->articletype;
                // $url_name='/planning/articledetail/';
                // $menulinktype_data=$url_name.$request->articletype;
            } elseif ($request->menulinktype == 21) {
                $menulinktype_data = $request->downloadtype;
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

            // dd($sbu_user);
            if ($request->menulinktype != 13) //Anchor|| URL || Form || Article
            {

                $uparr = array(
                    'users_id' => $role_id,
                    'mainmenu_id' => $request->mainmenuid,
                    'submenu_id' => $request->submenuid,
                    'iconclass' => $icon_class,
                    'orderno' => $request->ord_num,
                    'menulinktype_id' => $request->menulinktype,
                    'menulinktype_data' => $menulinktype_data,
                    'viewer_id' => $request->sbu_id,
                    'sbu_type' => $sbu_user,
                    'articletype_id' => $article_id,
                );

                $res = subsubmenu::where('id', $request->hidden_id)->update($uparr);

                // dd($request->sel_lang);
                $leng = count($request->sel_lang);
                $role_id = Auth::user()->id;
                if ($res) {
                    for ($i = 0; $i < $leng; $i++) {

                        $storeinfo_sub = array(
                            'languageid' => $request->sel_lang[$i],
                            'title' => $request->title[$i],
                            'subsubmenu_id' => $request->hidden_id
                        );
                        // dd($storeinfo_sub);
                        $res = subsubmenusub::where('subsubmenu_id', $request->hidden_id)->where('languageid', $request->sel_lang[$i])->update($storeinfo_sub);
                        DB::commit();
                    } //endfor
                } //ifres



            } //endif 13!=
            else {
                if (isset($request->file_type)) {
                    $date = date('dmYH:i:s');
                    $imageName = $request->title[0] . $date . '.' . $request->file_type->extension();
                    $filename = $imageName;
                    $path = $request->file('file_type')->storeAs('/uploads/Subsubmenu/', $imageName, 'myfile');
                    $menulinktype_data = $filename;
                    $uparr = array(
                        'users_id' => $role_id,
                        'mainmenu_id' => $request->mainmenuid,
                        'submenu_id' => $request->submenuid,
                        'iconclass' => $icon_class,
                        'orderno' => $request->ord_num,
                        'menulinktype_id' => $request->menulinktype,
                        'menulinktype_data' => $filename,
                        'viewer_id' => $request->sbu_id,
                        'sbu_type' => $sbu_user,
                        'articletype_id' => $article_id,
                    );
                } else {
                    $uparr = array(
                        'users_id' => $role_id,
                        'mainmenu_id' => $request->mainmenuid,
                        'submenu_id' => $request->submenuid,
                        'iconclass' => $icon_class,
                        'orderno' => $request->ord_num,
                        'menulinktype_id' => $request->menulinktype,
                        'viewer_id' => $request->sbu_id,
                        'sbu_type' => $sbu_user,
                        'articletype_id' => $article_id,
                    );
                }



                $res = subsubmenu::where('id', $request->hidden_id)->update($uparr);
                //    dd($res);
                // dd($request->sel_lang);
                $leng = count($request->sel_lang);
                $role_id = Auth::user()->id;
                if ($res) {
                    for ($i = 0; $i < $leng; $i++) {

                        $storeinfo_sub = array(
                            'languageid' => $request->sel_lang[$i],
                            'title' => $request->title[$i],
                            'subsubmenu_id' => $request->hidden_id

                        );
                        // dd($storeinfo_sub);
                        $res = subsubmenusub::where('subsubmenu_id', $request->hidden_id)->where('languageid', $request->sel_lang[$i])->update($storeinfo_sub);
                        DB::commit();
                    } //endfor
                } //ifres

            }
            // $storedetails=$storeinfo->save();
            $edit_f = '';
            if ($res) {
                return Redirect('/admin/subsubmenu')->with('success', 'Updated successfully', ['edit_f' => $edit_f]);
            } else {
                return back()->withErrors('Not Updated ');
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*Subsub menu Status*/
    public function statussubsubmenu($id)
    {
        // dd($id);
        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        $keydata = subsubmenu::where('id', $id)->select('status_id')->first();
        // dd($keydata);
        if (($keydata->status_id == 1)) {
            $uparr = array(
                'status_id' => 0,
            );
        } else {

            $uparr = array(
                'status_id' => 1,
            );
        }
        $res = subsubmenu::where('id', $id)->update($uparr);

        $edit_f = '';
        if ($res) {
            DB::commit();
            return Redirect('/admin/subsubmenu')->with('success', 'Status updated successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }
    /*Sub sub menu delete*/
    public function deletesubsubmenu($id)
    {

        $id = Crypt::decryptString($id);

        DB::beginTransaction();

        $res_sub = subsubmenusub::where('subsubmenu_id', $id)->delete();

        if ($res_sub) {
            $res = subsubmenu::findOrFail($id)->delete();
        }
        $edit_f = '';
        if ($res_sub) {
            DB::commit();
            return Redirect('/admin/subsubmenu')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }
    public function OrderchangeSubSubmenu_form(Request $request)
    {
        try {
            $id = Crypt::decryptString($request->id); //dd($id);
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
        $data = Stationtype::where('delet_flag', 0)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Station type', 'message' => 'Station type', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);


        $usertype = usertype::get();
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.admin.Stationtype.stationtype', compact('data', 'breadcrumbarr', 'usertype', 'navbar', 'user'));
    }

    /*Store station type*/
    public function storestationtype(Request $request)
    {

        try {
            $request->validate([
                'stationname' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            ]);
            $request->input();
            $role_id = Auth::user()->id;

            $storeinfo = new Stationtype([
                'name' => $request->stationname,
                'delet_flag' => 0,
                'status_id' => 1,
                'userid' => $role_id
            ]);

            $storedetails = $storeinfo->save();
            return redirect()->route('stationtype')->with('success', 'created successfully');
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*edit stationtype*/
    public function editstationtype($id)
    {
        $id = Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = Stationtype::where('id', $id)->first();
        $error = '';
        $data = Stationtype::where('delet_flag', 0)->get();
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Station type', 'message' => 'Station type', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);

        return view('backend.admin.Stationtype.stationtype', compact('data', 'edit_f', 'error', 'keydata', 'breadcrumbarr', 'navbar', 'user'));
    }

    /*Station type update*/

    public function updatestationtype(Request $request)
    {
        try {
            $request->validate([
                'stationname' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            ]);
            $request->input();

            $uparr = array(
                'name' => $request->stationname,
            );

            $res = Stationtype::where('id', $request->hidden_id)->update($uparr);
            $edit_f = '';
            if ($res) {
                return Redirect('stationtype')->with('success', 'Updated successfully', ['edit_f' => $edit_f]);
            } else {
                return back()->withErrors('Not Updated ');
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*Station type delete*/

    public function deletestationtype($id)
    {
        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        // $uparr=array(
        //     'delet_flag'=>1,
        //      );
        // $res=Stationtype::where('id',$id)->update($uparr);
        $res = Stationtype::findOrFail($id)->delete();
        $edit_f = '';
        if ($res) {
            DB::commit();
            return Redirect('stationtype')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }

    /*Stationtype Status*/
    public function statusstationtype($id)
    {
        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        $uparr = array(
            'status_id' => 0,
        );
        $res = Stationtype::where('id', $id)->update($uparr);

        $edit_f = '';
        if ($res_sub) {
            DB::commit();
            return Redirect('stationtype')->with('success', 'Status updated successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }





    /*Gallerytype*/
    public function gallerytype()
    {
        $data = Gallerytype::where('delet_flag', 0)->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Gallery type', 'message' => 'Gallery type', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

        $usertype = usertype::get();

        return view('backend.admin.Gallerytype.gallerytype', compact('data', 'breadcrumbarr', 'usertype', 'navbar', 'user'));
    }

    /*Store gallery type*/
    public function storegallerytype(Request $request)
    {

        try {
            $request->validate([
                'gallery_type' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            ]);
            $request->input();
            $role_id = Auth::user()->id;

            $storeinfo = new Gallerytype([
                'name' => $request->gallery_type,
                'delet_flag' => 0,
                'status_id' => 1,
                'userid' => $role_id
            ]);

            $storedetails = $storeinfo->save();
            return redirect()->route('gallerytype')->with('success', 'created successfully');
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*Gallery type delete*/
    public function deletegaltype($id)
    {
        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        // $uparr=array(
        //     'delet_flag'=>1,
        //      );
        $res = Gallerytype::findOrFail($id)->delete();
        // $res=usertype::where('id',$id)->update($uparr);
        $edit_f = '';
        if ($res) {
            DB::commit();
            return Redirect('gallerytype')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }

    /*gallery type edit*/
    public function editgaltype($id)
    {
        $id = Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = Gallerytype::where('id', $id)->first();
        $error = '';
        $data = Gallerytype::where('delet_flag', 0)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Gallerytype', 'message' => 'Gallerytype', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        return view('backend.admin.Gallerytype.gallerytype', compact('data', 'edit_f', 'error', 'keydata', 'breadcrumbarr', 'navbar', 'user'));
    }


    /*gallery type  update*/
    public function updategallerytype(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'gallery_type' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
            ]);
            $request->input();

            $uparr = array(
                'name' => $request->gallery_type,
            );
            // dd($uparr);
            $res = Gallerytype::where('id', $request->hidden_id)->update($uparr);
            //  dd($res);
            $edit_f = 'U';
            if ($res) {
                return Redirect('gallerytype')->with('success', 'Updated successfully', ['edit_f' => $edit_f]);
            } else {
                return back()->withErrors('Not Updated ');
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }


    /*Article type*/
    public function articletype()
    {
        $data = Articletype::with(['article_sub' => function ($query) {
            $query->where('delet_flag', 0);
        }])->with(['sbu_type_user' => function ($query3) {
            $query3->where('delet_flag', 0);
        }])->where('delet_flag', 0)->get();


        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Article type', 'message' => 'Article type', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

        $usertype = usertype::get();

        return view('Master.Articletype.articletypelist', compact('data', 'breadcrumbarr', 'usertype', 'navbar', 'user'));
    }


    /*Article type create*/
    public function createarticletype()
    {

        $language = Language::where('delet_flag', 0)->orderBy('name')->get();

        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Articletype', 'message' => 'Articletype', 'status' => 0, 'link' => '/articletype'),
            2 => array('title' => 'Create article type', 'message' => 'Create article type', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $Navid = Componentpermission::where('url', '/' . $route)->select('id')->first();
        $user_s = Sbutype::where('delet_flag', 0)->where('status_id', 1)->get();
        return view('Master.Articletype.createarticletype', compact('breadcrumbarr', 'language', 'navbar', 'user', 'Navid', 'user_s'));
    }

    /*Store Article type*/
    public function urlkeycheckarticletype(Request $request)
    {
        $keyid = $request->urlkey;
        $keyid_status = Articletype::where('urlkeyid', $keyid)->pluck('urlkeyid');
        $keyid_count = count($keyid_status);
        return response()->json($keyid_count);
    }
    public function storearticletype(Request $request)
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
            $role_id = Auth::user()->id;

            $leng = count($request->sel_lang);
            // dd($leng);
            if ($request->sbu_user == null) {
                $sbu_user = 0;
            } else {
                $sbu_user = $request->sbu_user;
            }
            $storeinfo = new Articletype([
                'userid' => Auth::user()->id,
                'delet_flag' => 0,
                'status_id' => 1,
            ]);
            // dd($storeinfo);
            $res = $storeinfo->save();
            $Articletypeid = DB::getPdo()->lastInsertId();

            for ($i = 0; $i < $leng; $i++) {


                if ($Articletypeid) {

                    $store_sub_info = new Articletypesub([
                        'languageid' => $request->sel_lang[$i],
                        'title' => $request->title[$i],
                        'articletypeid' => $Articletypeid,
                        'userid' => $role_id,
                        'delet_flag' => 0,
                        'status_id' => 1,
                    ]);
                    $storedetails_sub = $store_sub_info->save();
                }
                // dd($path);
            } //forloopend

            return redirect()->route('articletype')->with('success', 'created successfully');
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /*edit Article type*/
    public function editarticletype($id)
    {

        $id = Crypt::decryptString($id);
        $edit_f = 'E';
        $keydata = Articletype::with(['article_sub' => function ($query) {
            $query->where('delet_flag', 0);
        }])->with(['sbu_type_user' => function ($query3) {
            $query3->where('delet_flag', 0);
        }])->where('delet_flag', 0)->where('id', $id)->first();
        $error = '';
        $data = Articletype::with(['article_sub' => function ($query) {
            $query->where('delet_flag', 0);
        }])->with(['sbu_type_user' => function ($query3) {
            $query3->where('delet_flag', 0);
        }])->where('delet_flag', 0)->get();

        $language = Language::where('delet_flag', 0)->orderBy('name')->get();
        $user_s = Sbutype::where('delet_flag', 0)->where('status_id', 1)->get();
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
            1 => array('title' => 'Articletype', 'message' => 'Articletype', 'status' => 0, 'link' => '/articletype'),
            2 => array('title' => 'Edit article type', 'message' => 'Edit article type', 'status' => 1)
        );
        $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
        $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
        $user = app('App\Http\Controllers\Commonfunctions')->userinfo();

        return view('Master.Articletype.createarticletype', compact('data', 'edit_f', 'error', 'keydata', 'breadcrumbarr', 'navbar', 'language', 'user', 'user_s'));
    }

    /*Articletype  update*/
    public function updatearticletype(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'sel_lang.*' => app('App\Http\Controllers\Commonfunctions')->getsel2valreq(),
                'title.*' => app('App\Http\Controllers\Commonfunctions')->getEntitlereg(),
                'urlkey'        => 'required|min:2|max:50'
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
            if ($request->sbu_user == null) {
                $sbu_user = 0;
            } else {
                $sbu_user = $request->sbu_user;
            }
            $storeinfo = Articletype::where('id', $request->hidden_id)->update([
                'viewer_id' => $request->sbu_id,
                'sbu_type' => $sbu_user,
                'urlkeyid' => $request->urlkey,
                'multi_sbu' => $request->moresbuuser, //user table id
            ]);
            if ($storeinfo) {
                for ($i = 0; $i < count($request->title); $i++) {
                    $res = Articletypesub::where('articletypeid', $request->hidden_id)->where('languageid', $request->sel_lang[$i])
                        ->update([
                            'title' => $request->title[$i],
                        ]);
                    // dd($request->sel_lang[$i]);

                } //forloopend
            }

            if ($res) {
                DB::commit();
                return Redirect('articletype')->with('success', 'Updated successfully');
            } else {
                DB::rollback();
                return back()->withErrors('Not Updated ');
            }
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }

    /* Article delete*/
    public function deletearticletype($id)
    {
        $id = Crypt::decryptString($id);
        // dd($id);
        DB::beginTransaction();

        $res_sub = Articletypesub::where('articletypeid', $id)->delete();

        if ($res_sub) {
            $res = Articletype::findOrFail($id)->delete();
        }
        $edit_f = '';
        if ($res_sub) {
            DB::commit();
            return Redirect('articletype')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }
    /*Articletype Status*/
    public function statusarticletype($id)
    {
        $id = Crypt::decryptString($id);
        $status = Articletype::where('id', $id)->value('status_id');

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


        $res = Articletype::where('id', $id)->update($uparr);

        $edit_f = '';
        if ($res) {
            DB::commit();
            return Redirect('articletype')->with('success', 'Status updated successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }


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
        return view('backend.admin.TenderType.tendertypelist', compact('datas', 'breadcrumbarr', 'navbar', 'user'));
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

        return view('backend.admin.TenderType.createtendertype', compact('breadcrumbarr', 'navbar', 'user', 'usertype', 'language'));
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

            return redirect()->route('admin.tendertypelist')->with('success', 'Created successfully');
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

        return view('backend.admin.TenderType.createtendertype', compact('breadcrumbarr', 'navbar', 'user', 'language', 'edit_f', 'keydata'));
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

            return redirect()->route('admin.tendertypelist')->with('success', 'Updated successfully');
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
            return Redirect('/admin/tendertypelist')->with('success', 'Deleted successfully', ['edit_f' => $edit_f]);
        } else {
            DB::rollback();
            return back()->withErrors('Not deleted ');
        }
    }
   /*Tender type*/
   public function whatwedotypelist()
   {
           $datas = Whatwedotype::with(['whatwedotype_sub' => function ($query) {
            }])->get();
       $breadcrumb = array(
           0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/masteradminhome'),
           1 => array('title' => 'What we do type', 'message' => 'What we do type', 'status' => 1)
       );
       $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
       $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
       $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
       return view('backend.admin.whatwedotype.whatwedotypelist', compact('datas', 'breadcrumbarr', 'navbar', 'user'));
   }
   public function createwhatwedotype()
   {
        $breadcrumb = array(
            0 => array('title' => 'Home', 'message' => 'Home', 'status' => 0, 'link' => '/adminhome'),
            1 => array('title' => 'What we do type', 'message' => 'What we do type', 'status' => 1)
        );

       $breadcrumbarr = app('App\Http\Controllers\Commonfunctions')->bread_crump_maker($breadcrumb);
       $navbar = app('App\Http\Controllers\Commonfunctions')->componentpermissionsetng();
       $user = app('App\Http\Controllers\Commonfunctions')->userinfo();
       $usertype = usertype::get();

       $language = Language::where('delet_flag', 0)->orderBy('name')->get();

       return view('backend.admin.whatwedotype.createwhatwedotype', compact('breadcrumbarr', 'navbar', 'user', 'usertype', 'language'));
   }
   public function storewhatwedotype(Request $request)
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

           $storeinfo = new Whatwedotype([
               'userid' => Auth::user()->id,
               'status_id' => 1,
               'delet_flag' => 0,
           ]);

           $res = $storeinfo->save();
           $whatwedotypeid = DB::getPdo()->lastInsertId();

           for ($i = 0; $i < $leng; $i++) {


               if ($whatwedotypeid) {

                   $store_sub_info = new Whatwedotypesub([
                       'languageid' => $request->sel_lang[$i],
                       'title' => $request->title[$i],
                       'whatwedotypeid' => $whatwedotypeid,
                   ]);
                   $storedetails_sub = $store_sub_info->save();
               }
               // dd($path);
           } //forloopend

           return redirect()->route('admin.whatwedotype')->with('success', 'Created successfully');
       } catch (ModelNotFoundException $exception) {
           \LogActivity::addToLog($exception->getMessage(), 'error');
           $data = \LogActivity::logLatestItem();
           return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
       }
   }
   public function editwhatwedotype($id)
   {

       $id = Crypt::decryptString($id);

       $edit_f = 'E';

       $keydata = Whatwedotype::with(['whatwedotype_sub' => function ($query) {
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

       return view('backend.admin.whatwedotype.createwhatwedotype', compact('breadcrumbarr', 'navbar', 'user', 'language', 'edit_f', 'keydata'));
   }
   public function updatewhatwedotype(Request $request)
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

           $res = Whatwedotype::where('id', $request->hidden_id)->update($storeinfo);
           $whatwedotypeid = $request->hidden_id;

           for ($i = 0; $i < $leng; $i++) {


               if ($whatwedotypeid) {

                   $store_sub_info = array(
                       'languageid' => $request->sel_lang[$i],
                       'title' => $request->title[$i],
                       'whatwedotypeid' => $whatwedotypeid,
                   );
                   $storedetails_sub = Whatwedotypesub::where('whatwedotypeid', $request->hidden_id)->where('languageid', $request->sel_lang[$i])->update($store_sub_info);
               }
               // dd($path);
           } //forloopend

           return redirect()->route('admin.whatwedotype')->with('success', 'Updated successfully');
       } catch (ModelNotFoundException $exception) {
           \LogActivity::addToLog($exception->getMessage(), 'error');
           $data = \LogActivity::logLatestItem();
           return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
       }
   }


   public function deletewhatwedotype($id)
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

}
