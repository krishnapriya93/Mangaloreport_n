<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//krishnapriya
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FrontendController::class, 'index'])->name('main.index');
Route::get('loginview', [App\Http\Controllers\Auth\LoginController::class, 'loginview'])->name('loginview');
Route::post('checklogins', [App\Http\Controllers\Auth\LoginController::class, 'checklogin'])->name('checklogins'); 
Route::get('refreshCaptcha', [App\Http\Controllers\Auth\LoginController::class, 'refreshCaptcha'])->name('refreshCaptcha');
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::post('/articleckimageupload', [App\Http\Controllers\CkeditorController::class, 'articleckimageupload'])->name('articleckimageupload');

Route::group(['middleware'=>['auth','App\Http\Middleware\Adminlogin']],function()
{
//Dashboard
Route::get('masteradminhome', [App\Http\Controllers\AdminController::class, 'masteradminhome'])->name('masteradminhome'); 

//UserType
Route::get('/usertype', [App\Http\Controllers\AdminController::class, 'usertype'])->name('usertype');
Route::post('/storeusertype', [App\Http\Controllers\AdminController::class, 'storeusertype'])->name('storeusertype');
Route::get('/editusertype/{id}', [App\Http\Controllers\AdminController::class, 'editusertype'])->name('editusertype');
Route::post('/updateusertype', [App\Http\Controllers\AdminController::class, 'updateusertype'])->name('updateusertype');
Route::get('/deleteusertype/{id}', [App\Http\Controllers\AdminController::class, 'deleteusertype'])->name('deleteusertype');
Route::get('/statususertype/{id}', [App\Http\Controllers\AdminController::class, 'statususertype'])->name('statususertype');

//user
Route::get('/user', [App\Http\Controllers\AdminController::class, 'user'])->name('user');
Route::post('/storeuser', [App\Http\Controllers\AdminController::class, 'storeuser'])->name('storeuser');
Route::get('/edituser/{id}', [App\Http\Controllers\AdminController::class, 'edituser'])->name('edituser');
Route::post('/updateuser', [App\Http\Controllers\AdminController::class, 'updateuser'])->name('updateuser');
Route::get('/deleteuser/{id}', [App\Http\Controllers\AdminController::class, 'deleteuser'])->name('deleteuser');
Route::get('/statususer/{id}', [App\Http\Controllers\AdminController::class, 'statususer'])->name('statususer');

//Component
Route::get('/component', [App\Http\Controllers\AdminController::class, 'component'])->name('component');
Route::post('/storecomponent', [App\Http\Controllers\AdminController::class, 'storecomponent'])->name('storecomponent');
Route::get('/editcomponent/{id}', [App\Http\Controllers\AdminController::class, 'editcomponent'])->name('editcomponent');
Route::post('/updatecomponent', [App\Http\Controllers\AdminController::class, 'updatecomponent'])->name('updatecomponent');
Route::get('/deletecomponent/{id}', [App\Http\Controllers\AdminController::class, 'deletecomponent'])->name('deletecomponent');
Route::get('/statuscomponent/{id}', [App\Http\Controllers\AdminController::class, 'statuscomponent'])->name('statuscomponent');


//Component permissions
Route::get('/componentpermi', [App\Http\Controllers\AdminController::class, 'componentpermissions'])->name('componentpermi');
Route::post('/storecomponentpermi', [App\Http\Controllers\AdminController::class, 'storecomponentpermi'])->name('storecomponentpermi');
Route::get('/editcomponentper/{id}', [App\Http\Controllers\AdminController::class, 'editcomponentper'])->name('editcomponentper');
Route::post('/updatecomponentperm', [App\Http\Controllers\AdminController::class, 'updatecomponentperm'])->name('updatecomponentperm');
Route::get('/deletecomponentper/{id}',[App\Http\Controllers\AdminController::class, 'deletecomponentper'])->name('deletecomponentper');
Route::get('/statuscomperm/{id}', [App\Http\Controllers\AdminController::class, 'statuscomperm'])->name('statuscomperm');

//Language
Route::get('/language', [App\Http\Controllers\AdminController::class, 'language'])->name('language');
Route::post('/storelanguage', [App\Http\Controllers\AdminController::class, 'storelanguage'])->name('storelanguage');
Route::get('/editlanguage/{id}', [App\Http\Controllers\AdminController::class, 'editlanguage'])->name('editlanguage');
Route::post('/updatelanguage', [App\Http\Controllers\AdminController::class, 'updatelanguage'])->name('updatelanguage');
Route::get('/deletelanguage/{id}',[App\Http\Controllers\AdminController::class, 'deletelanguage'])->name('deletelanguage');
Route::get('/statuslanguage/{id}', [App\Http\Controllers\AdminController::class, 'statuslanguage'])->name('statuslanguage');

//Menulinktype
Route::get('/menulinktype', [App\Http\Controllers\AdminController::class, 'menulinktype'])->name('menulinktype');
Route::post('/storemenulinktype', [App\Http\Controllers\AdminController::class, 'storemenulinktype'])->name('storemenulinktype');
Route::get('/editMenulinktype/{id}', [App\Http\Controllers\AdminController::class, 'editMenulinktype'])->name('editMenulinktype');
Route::post('/updateMenulinktype', [App\Http\Controllers\AdminController::class, 'updateMenulinktype'])->name('updateMenulinktype');
Route::get('/deleteMenulinktype/{id}',[App\Http\Controllers\AdminController::class, 'deleteMenulinktype'])->name('deleteMenulinktype');
Route::get('/statusmenutype/{id}', [App\Http\Controllers\AdminController::class, 'statusmenutype'])->name('statusmenutype');

//Mainmenu
Route::get('/mainmenu', [App\Http\Controllers\AdminController::class, 'mainmenu'])->name('mainmenu');
Route::get('/createmainmenu', [App\Http\Controllers\AdminController::class, 'createmainmenu'])->name('createmainmenu');
Route::post('/storeMainmenu', [App\Http\Controllers\AdminController::class, 'storeMainmenu'])->name('storeMainmenu');
Route::get('/editmainmenu/{id}', [App\Http\Controllers\AdminController::class, 'editmainmenu'])->name('editmainmenu');
Route::post('/updateMainmenu', [App\Http\Controllers\AdminController::class, 'updateMainmenu'])->name('updateMainmenu');
Route::get('/deletemainmenu/{id}',[App\Http\Controllers\AdminController::class, 'deletemainmenu'])->name('deletemainmenu');
Route::get('/statusmainmenu/{id}', [App\Http\Controllers\AdminController::class, 'statusmainmenu'])->name('statusmainmenu');
Route::get('/createmainmenu', [App\Http\Controllers\AdminController::class, 'createmainmenu'])->name('createmainmenu');
Route::get('/admin/articleload', [App\Http\Controllers\AdminController::class, 'articleload'])->name('admin.articleload');
Route::get('/admin/downloadtypeload', [App\Http\Controllers\AdminController::class, 'downloadtypeload'])->name('admin.downloadtypeload');
Route::get('/OrderchangeMainmenu_form', [App\Http\Controllers\AdminController::class, 'OrderchangeMainmenu_form'])->name('OrderchangeMainmenu_form');
Route::get('/admin/ordernumbercheckmainmenu',[App\Http\Controllers\AdminController::class, 'ordernumbercheckmainmenu'])->name('admin.ordernumbercheckmainmenu');

//Submenu 
Route::get('/submenu', [App\Http\Controllers\AdminController::class, 'submenu'])->name('submenu');
Route::get('/createsubmenu', [App\Http\Controllers\AdminController::class, 'createsubmenu'])->name('createsubmenu');
Route::post('/storesubmenu', [App\Http\Controllers\AdminController::class, 'storesubmenu'])->name('storesubmenu');
Route::get('/editsubmenu/{id}', [App\Http\Controllers\AdminController::class, 'editsubmenu'])->name('editsubmenu');
Route::post('/updatesubmenu', [App\Http\Controllers\AdminController::class, 'updatesubmenu'])->name('updatesubmenu');
Route::get('/deletesubmenu/{id}',[App\Http\Controllers\AdminController::class, 'deletesubmenu'])->name('deletesubmenu');
Route::get('/statussubmenu/{id}', [App\Http\Controllers\AdminController::class, 'statussubmenu'])->name('statussubmenu');
Route::get('/sbuwisemainmenu', [App\Http\Controllers\AdminController::class, 'sbuwisemainmenu'])->name('admin.sbuwisemainmenu');
Route::get('/admin/ordernumberchecksubmenu',[App\Http\Controllers\AdminController::class, 'ordernumberchecksubmenu'])->name('admin.ordernumberchecksubmenu');

});