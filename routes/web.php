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


//widgetpositions
Route::get('/widgetpositions', [App\Http\Controllers\AdminController::class, 'widgetpositions'])->name('widgetpositions');
Route::post('/storewidget', [App\Http\Controllers\AdminController::class, 'storewidget'])->name('storewidget');
Route::get('/editwidget/{id}', [App\Http\Controllers\AdminController::class, 'editwidget'])->name('editwidget');
Route::post('/updatewidget', [App\Http\Controllers\AdminController::class, 'updatewidget'])->name('updatewidget');
Route::get('/deletewidget/{id}',[App\Http\Controllers\AdminController::class, 'deletewidget'])->name('deletewidget');
Route::get('/statuswidgetpost/{id}', [App\Http\Controllers\AdminController::class, 'statuswidgetpost'])->name('statuswidgetpost');

});

Route::group(['middleware'=>['auth','App\Http\Middleware\Siteadmin']],function()
{
   //Dashboard
   Route::get('siteadminhome', [App\Http\Controllers\SiteadminController::class, 'siteadminhome'])->name('siteadminhome');

   //article 
   Route::get('/siteadmin/articlelist', [App\Http\Controllers\SiteadminController::class, 'articlelist'])->name('articlelist');
   Route::get('/siteadmin/createarticle', [App\Http\Controllers\SiteadminController::class, 'createarticle'])->name('createarticle');
   Route::post('/siteadmin/storearticle', [App\Http\Controllers\SiteadminController::class, 'storearticle'])->name('storearticle');
   Route::get('/siteadmin/editarticle/{id}', [App\Http\Controllers\SiteadminController::class, 'editarticle'])->name('editarticle');
   Route::post('/siteadmin/updatearticle', [App\Http\Controllers\SiteadminController::class, 'updatearticle'])->name('updatearticle');
   Route::get('/siteadmin/deletearticle/{id}',[App\Http\Controllers\SiteadminController::class, 'deletearticle'])->name('deletearticle');


   //Banner
   Route::get('/siteadmin/banner', [App\Http\Controllers\SiteadminController::class, 'banner'])->name('banner');
   Route::get('/siteadmin/createbanner', [App\Http\Controllers\SiteadminController::class, 'createbanner'])->name('createbanner');
   Route::post('/siteadmin/storebanner', [App\Http\Controllers\SiteadminController::class, 'storebanner'])->name('storebanner');
   Route::get('/siteadmin/editbanner/{id}', [App\Http\Controllers\SiteadminController::class, 'editbanner'])->name('editbanner');
   Route::post('/siteadmin/updatebanner', [App\Http\Controllers\SiteadminController::class, 'updatebanner'])->name('updatebanner');
   Route::get('/siteadmin/deleteBanner/{id}',[App\Http\Controllers\SiteadminController::class, 'deleteBanner'])->name('deleteBanner');
   Route::get('/siteadmin/statusbanner/{id}', [App\Http\Controllers\SiteadminController::class, 'statusbanner'])->name('statusbanner');

   //Contact us
   Route::get('/siteadmin/contactus', [App\Http\Controllers\SiteadminController::class, 'contactus'])->name('contactus');
   Route::get('/siteadmin/createcontactus', [App\Http\Controllers\SiteadminController::class, 'createcontactus'])->name('createcontactus');
   Route::post('/siteadmin/storecontactus', [App\Http\Controllers\SiteadminController::class, 'storecontactus'])->name('storecontactus');
   Route::get('/siteadmin/editcontactus/{id}', [App\Http\Controllers\SiteadminController::class, 'editcontactus'])->name('editcontactus');
   Route::post('/siteadmin/updatecontactus', [App\Http\Controllers\SiteadminController::class, 'updatecontactus'])->name('updatecontactus');
   Route::get('/siteadmin/deletecontactus/{id}',[App\Http\Controllers\SiteadminController::class, 'deletecontactus'])->name('deletecontactus');

   //Gallery
   Route::get('/siteadmin/gallerylist', [App\Http\Controllers\SiteadminController::class, 'gallery'])->name('gallerylist');
   Route::get('/siteadmin/creategallery', [App\Http\Controllers\SiteadminController::class, 'creategallery'])->name('creategallery');
   Route::post('/siteadmin/storegallery', [App\Http\Controllers\SiteadminController::class, 'storegallery'])->name('storegallery');
   Route::post('/galitemstore/{id}', [App\Http\Controllers\SiteadminController::class,'galitemstore'])->name('galitemstore');
   Route::get('/siteadmin/editgallery/{id}', [App\Http\Controllers\SiteadminController::class, 'editgallery'])->name('editgallery');
   Route::post('/siteadmin/updategallery', [App\Http\Controllers\SiteadminController::class, 'updategallery'])->name('updategallery');
   Route::get('/siteadmin/deletegallery/{id}',[App\Http\Controllers\SiteadminController::class, 'deletegallery'])->name('deletegallery');
   Route::post('/siteadmin/galitemstoreuppy/{id}',[App\Http\Controllers\SiteadminController::class, 'galitemstoreuppy'])->name('galitemstoreuppy');
   Route::get('/viewgallarypics/{id}',[App\Http\Controllers\SiteadminController::class, 'viewgallarypics'])->name('viewgallarypics');
   Route::get('/galitemdel/{id}', [App\Http\Controllers\SiteadminController::class, 'galitemdel']);
   Route::get('/siteadmin/statusgallery/{id}', [App\Http\Controllers\SiteadminController::class, 'statusgallery'])->name('statusgallery');

   //Mainmenu
   Route::get('/siteadmin/mainmenu', [App\Http\Controllers\SiteadminController::class, 'mainmenu'])->name('mainmenu');
   Route::get('/siteadmin/createmainmenu', [App\Http\Controllers\SiteadminController::class, 'createmainmenu'])->name('createmainmenu');
   Route::post('/siteadmin/storeMainmenu', [App\Http\Controllers\SiteadminController::class, 'storeMainmenu'])->name('storeMainmenu');
   Route::get('/siteadmin/editmainmenu/{id}', [App\Http\Controllers\SiteadminController::class, 'editmainmenu'])->name('editmainmenu');
   Route::post('/siteadmin/updateMainmenu', [App\Http\Controllers\SiteadminController::class, 'updateMainmenu'])->name('updateMainmenu');
   Route::get('/siteadmin/deletemainmenu/{id}',[App\Http\Controllers\SiteadminController::class, 'deletemainmenu'])->name('deletemainmenu');
   Route::get('/siteadmin/statusmainmenu/{id}', [App\Http\Controllers\SiteadminController::class, 'statusmainmenu'])->name('statusmainmenu');
   Route::get('/siteadmin/createmainmenu', [App\Http\Controllers\SiteadminController::class, 'createmainmenu'])->name('createmainmenu');
   Route::get('/siteadmin/admin/articleload', [App\Http\Controllers\SiteadminController::class, 'articleload'])->name('admin.articleload');
   Route::get('/siteadmin/admin/downloadtypeload', [App\Http\Controllers\SiteadminController::class, 'downloadtypeload'])->name('admin.downloadtypeload');
   Route::get('/siteadmin/OrderchangeMainmenu_form', [App\Http\Controllers\SiteadminController::class, 'OrderchangeMainmenu_form'])->name('OrderchangeMainmenu_form');
   Route::get('/siteadmin/ordernumbercheckmainmenu',[App\Http\Controllers\SiteadminController::class, 'ordernumbercheckmainmenu'])->name('admin.ordernumbercheckmainmenu');

   //Submenu 
   Route::get('/siteadmin/submenu', [App\Http\Controllers\SiteadminController::class, 'submenu'])->name('submenu');
   Route::get('/siteadmin/createsubmenu', [App\Http\Controllers\SiteadminController::class, 'createsubmenu'])->name('createsubmenu');
   Route::post('/siteadmin/storesubmenu', [App\Http\Controllers\SiteadminController::class, 'storesubmenu'])->name('storesubmenu');
   Route::get('/siteadmin/editsubmenu/{id}', [App\Http\Controllers\SiteadminController::class, 'editsubmenu'])->name('editsubmenu');
   Route::post('/siteadmin/updatesubmenu', [App\Http\Controllers\SiteadminController::class, 'updatesubmenu'])->name('updatesubmenu');
   Route::get('/siteadmin/deletesubmenu/{id}',[App\Http\Controllers\SiteadminController::class, 'deletesubmenu'])->name('deletesubmenu');
   Route::get('/siteadmin/statussubmenu/{id}', [App\Http\Controllers\SiteadminController::class, 'statussubmenu'])->name('statussubmenu');
   Route::get('/siteadmin/sbuwisemainmenu', [App\Http\Controllers\SiteadminController::class, 'sbuwisemainmenu'])->name('admin.sbuwisemainmenu');
   Route::get('/siteadmin/ordernumberchecksubmenu',[App\Http\Controllers\SiteadminController::class, 'ordernumberchecksubmenu'])->name('admin.ordernumberchecksubmenu');


});


//Master Admin Start
Route::group(['middleware'=>['auth','App\Http\Middleware\Masteradminlogin']],function()
{
   //Dashboard
   Route::get('masterhome', [App\Http\Controllers\MasterController::class, 'index'])->name('masterhome');

   //Article Type
   Route::get('/masteradmin/articletype', [App\Http\Controllers\MasterController::class, 'articletype'])->name('articletype');
   Route::get('/masteradmin/createarticletype', [App\Http\Controllers\MasterController::class, 'createarticletype'])->name('createarticletype');
   Route::post('/masteradmin/storearticletype', [App\Http\Controllers\MasterController::class, 'storearticletype'])->name('storearticletype');
   Route::get('/masteradmin/editarticletype/{id}', [App\Http\Controllers\MasterController::class, 'editarticletype'])->name('editarticletype');
   Route::post('/masteradmin/updatearticletype', [App\Http\Controllers\MasterController::class, 'updatearticletype'])->name('updatearticletype');
   Route::get('/masteradmin/deletearticletype/{id}',[App\Http\Controllers\MasterController::class, 'deletearticletype'])->name('deletearticletype');
   Route::get('/masteradmin/statusarticletype/{id}',[App\Http\Controllers\MasterController::class, 'statusarticletype'])->name('statusarticletype');

   // BOD
   Route::get('/masteradmin/BODlist', [App\Http\Controllers\MasterController::class, 'BODlist'])->name('BODlist');
   Route::post('/masteradmin/storeBOD', [App\Http\Controllers\MasterController::class, 'storeBOD'])->name('storeBOD');
   Route::get('/masteradmin/editBOD/{id}', [App\Http\Controllers\MasterController::class, 'editBOD'])->name('editBOD');
   Route::post('/masteradmin/updateBOD', [App\Http\Controllers\MasterController::class, 'updateBOD'])->name('updateBOD');
   Route::get('/masteradmin/deleteBOD/{id}',[App\Http\Controllers\MasterController::class, 'deleteBOD'])->name('deleteBOD');

      //Milestone
   Route::get('/masteradmin/milestonelist', [App\Http\Controllers\MasterController::class, 'milestonelist'])->name('milestonelist');
   Route::get('/masteradmin/createmilestone', [App\Http\Controllers\MasterController::class, 'createmilestone'])->name('createmilestone');
   Route::post('/masteradmin/storemilestone', [App\Http\Controllers\MasterController::class, 'storemilestone'])->name('storemilestone');
   Route::get('/masteradmin/editmilestone/{id}', [App\Http\Controllers\MasterController::class, 'editmilestone'])->name('editmilestone');
   Route::post('/masteradmin/updatemilestone', [App\Http\Controllers\MasterController::class, 'updatemilestone'])->name('updatemilestone');
   Route::get('/masteradmin/deletemilestone/{id}',[App\Http\Controllers\MasterController::class, 'deletemilestone'])->name('deletemilestone');
   Route::get('//masteradmin/statusmilestone/{id}',[App\Http\Controllers\MasterController::class, 'statusmilestone'])->name('statusmilestone');

   //Gallery type
   Route::get('/masteradmin/gallerytype', [App\Http\Controllers\MasterController::class, 'gallerytype'])->name('gallerytype');
   Route::post('/masteradmin/storegallerytype', [App\Http\Controllers\MasterController::class, 'storegallerytype'])->name('storegallerytype');

   //Footermenu
   Route::get('/masteradmin/footermenu', [App\Http\Controllers\MasterController::class, 'footermenu'])->name('footermenu');
   Route::get('/masteradmin/createfootermenu', [App\Http\Controllers\MasterController::class, 'createfootermenu'])->name('createfootermenu');
   Route::post('/masteradmin/storefootermenu', [App\Http\Controllers\MasterController::class, 'storefootermenu'])->name('storefootermenu');
   Route::get('/masteradmin/editfootermenu/{id}', [App\Http\Controllers\MasterController::class, 'editfootermenu'])->name('editfootermenu');
   Route::post('/masteradmin/updatefootermenu', [App\Http\Controllers\MasterController::class, 'updatefootermenu'])->name('updatefootermenu');
   Route::get('/masteradmin/deletefootermenu/{id}',[App\Http\Controllers\MasterController::class, 'deletefootermenu'])->name('deletefootermenu');

   //Logo type
   Route::get('/masteradmin/logotype', [App\Http\Controllers\MasterController::class, 'logotype'])->name('logotype');
   Route::post('/masteradmin/storelogotype', [App\Http\Controllers\MasterController::class, 'storelogotype'])->name('storelogotype');
   Route::get('/masteradmin/editlogotype/{id}', [App\Http\Controllers\MasterController::class, 'editlogotype'])->name('editlogotype');
   Route::post('/masteradmin/updatelogotype', [App\Http\Controllers\MasterController::class, 'updatelogotype'])->name('updatelogotype');
   Route::get('/masteradmin/deletelogotype/{id}',[App\Http\Controllers\MasterController::class, 'deletelogotype'])->name('deletelogotype');

   //Menulinktype
   Route::get('/masteradmin/menulinktype', [App\Http\Controllers\MasterController::class, 'menulinktype'])->name('menulinktype');
   Route::post('/masteradmin/storemenulinktype', [App\Http\Controllers\MasterController::class, 'storemenulinktype'])->name('storemenulinktype');
   Route::get('/masteradmin/editMenulinktype/{id}', [App\Http\Controllers\MasterController::class, 'editMenulinktype'])->name('editMenulinktype');
   Route::post('/masteradmin/updateMenulinktype', [App\Http\Controllers\MasterController::class, 'updateMenulinktype'])->name('updateMenulinktype');
   Route::get('/masteradmin/deleteMenulinktype/{id}',[App\Http\Controllers\MasterController::class, 'deleteMenulinktype'])->name('deleteMenulinktype');
   Route::get('/masteradmin/statusmenutype/{id}', [App\Http\Controllers\MasterController::class, 'statusmenutype'])->name('statusmenutype');

   //Milestone
   Route::get('/masteradmin/milestonelist', [App\Http\Controllers\MasterController::class, 'milestonelist'])->name('milestone');
   Route::get('/masteradmin/createmilestone', [App\Http\Controllers\MasterController::class, 'createmilestone'])->name('createmilestone');
   Route::post('/masteradmin/storemilestone', [App\Http\Controllers\MasterController::class, 'storemilestone'])->name('storemilestone');
   Route::get('/masteradmin/editmilestone/{id}', [App\Http\Controllers\MasterController::class, 'editmilestone'])->name('editmilestone');
   Route::post('/masteradmin/updatemilestone', [App\Http\Controllers\MasterController::class, 'updatemilestone'])->name('updatemilestone');
   Route::get('/masteradmin/deletemilestone/{id}',[App\Http\Controllers\MasterController::class, 'deletemilestone'])->name('deletemilestone');
   Route::get('/masteradmin/statusmilestone/{id}',[App\Http\Controllers\MasterController::class, 'statusmilestone'])->name('statusmilestone');

});
//Master Admin End

//Media Admin Start
Route::group(['middleware'=>['auth','App\Http\Middleware\Mediaadminlogin']],function()
{
   //Dashboard
   Route::get('mediaadminhome', [App\Http\Controllers\MediaadminController::class, 'index'])->name('mediaadminhome');
});