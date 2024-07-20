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

//Front end - start
Route::get('/', [FrontendController::class, 'index'])->name('main.index');
Route::get('/setbilingualval', [FrontendController::class, 'setbilingualval'])->name('setbilingualval');
Route::get('/setbilingualvalmal', [App\Http\Controllers\FrontendController::class, 'setbilingualvalmal'])->name('setbilingualvalmal');

// Route::get('mainarticle/{title}/{id}', [FrontendController::class, 'mainarticle'])->name('mainarticle');
Route::get('mainarticle/{articletypeid}', [App\Http\Controllers\FrontendController::class, 'mainarticle'])->name('mainarticle');
Route::get('milestoneview', [App\Http\Controllers\FrontendController::class, 'milestoneview'])->name('milestoneview');
Route::get('bodview', [App\Http\Controllers\FrontendController::class, 'bodview'])->name('bodview');
Route::get('whoswhoview', [App\Http\Controllers\FrontendController::class, 'whoswhoview'])->name('whoswhoview');
Route::get('chiefofficers', [App\Http\Controllers\FrontendController::class, 'chiefofficers'])->name('chiefofficers');

//Front end - end

Route::get('loginview', [App\Http\Controllers\Auth\LoginController::class, 'loginview'])->name('loginview');
Route::post('checklogins', [App\Http\Controllers\Auth\LoginController::class, 'checklogin'])->name('checklogins');
Route::get('refreshCaptcha', [App\Http\Controllers\Auth\LoginController::class, 'refreshCaptcha'])->name('refreshCaptcha');
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::post('/articleckimageupload', [App\Http\Controllers\CkeditorController::class, 'articleckimageupload'])->name('articleckimageupload');

Route::group(['middleware' => ['auth', 'App\Http\Middleware\Adminlogin','prevent-back-history', 'CORS', 'XSS']], function () {
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
    Route::get('/deletecomponentper/{id}', [App\Http\Controllers\AdminController::class, 'deletecomponentper'])->name('deletecomponentper');
    Route::get('/statuscomperm/{id}', [App\Http\Controllers\AdminController::class, 'statuscomperm'])->name('statuscomperm');

    //Language
    Route::get('/language', [App\Http\Controllers\AdminController::class, 'language'])->name('language');
    Route::post('/storelanguage', [App\Http\Controllers\AdminController::class, 'storelanguage'])->name('storelanguage');
    Route::get('/editlanguage/{id}', [App\Http\Controllers\AdminController::class, 'editlanguage'])->name('editlanguage');
    Route::post('/updatelanguage', [App\Http\Controllers\AdminController::class, 'updatelanguage'])->name('updatelanguage');
    Route::get('/deletelanguage/{id}', [App\Http\Controllers\AdminController::class, 'deletelanguage'])->name('deletelanguage');
    Route::get('/statuslanguage/{id}', [App\Http\Controllers\AdminController::class, 'statuslanguage'])->name('statuslanguage');

    //Menulinktype
    Route::get('/menulinktype', [App\Http\Controllers\AdminController::class, 'menulinktype'])->name('menulinktype');
    Route::post('/storemenulinktype', [App\Http\Controllers\AdminController::class, 'storemenulinktype'])->name('storemenulinktype');
    Route::get('/editMenulinktype/{id}', [App\Http\Controllers\AdminController::class, 'editMenulinktype'])->name('editMenulinktype');
    Route::post('/updateMenulinktype', [App\Http\Controllers\AdminController::class, 'updateMenulinktype'])->name('updateMenulinktype');
    Route::get('/deleteMenulinktype/{id}', [App\Http\Controllers\AdminController::class, 'deleteMenulinktype'])->name('deleteMenulinktype');
    Route::get('/statusmenutype/{id}', [App\Http\Controllers\AdminController::class, 'statusmenutype'])->name('statusmenutype');

    //Link type
    Route::get('/admin/linktype', [App\Http\Controllers\AdminController::class, 'linktype'])->name('admin.linktype');
    Route::get('/admin/createlinktype', [App\Http\Controllers\AdminController::class, 'createlinktype'])->name('admin.createlinktype');
    Route::post('/admin/storelinktype', [App\Http\Controllers\AdminController::class, 'storelinktype'])->name('admin.storelinktype');
    Route::get('/admin/editlinktype/{id}', [App\Http\Controllers\AdminController::class, 'editlinktype'])->name('admin.editlinktype');
    Route::post('/admin/updatelinktype', [App\Http\Controllers\AdminController::class, 'updatelinktype'])->name('admin.updatelinktype');
    Route::get('/admin/deletelinktype/{id}', [App\Http\Controllers\AdminController::class, 'deletelinktype'])->name('admin.deletelinktype');
});

Route::group(['middleware' => ['auth', 'App\Http\Middleware\Siteadmin','prevent-back-history', 'CORS', 'XSS']], function () {
    //Dashboard
    Route::get('siteadminhome', [App\Http\Controllers\SiteadminController::class, 'siteadminhome'])->name('siteadminhome');

    //article
    Route::get('/siteadmin/articlelist', [App\Http\Controllers\SiteadminController::class, 'articlelist'])->name('articlelist');
    Route::get('/siteadmin/createarticle', [App\Http\Controllers\SiteadminController::class, 'createarticle'])->name('createarticle');
    Route::post('/siteadmin/storearticle', [App\Http\Controllers\SiteadminController::class, 'storearticle'])->name('storearticle');
    Route::get('/siteadmin/editarticle/{id}', [App\Http\Controllers\SiteadminController::class, 'editarticle'])->name('editarticle');
    Route::post('/siteadmin/updatearticle', [App\Http\Controllers\SiteadminController::class, 'updatearticle'])->name('updatearticle');
    Route::get('/siteadmin/deletearticle/{id}', [App\Http\Controllers\SiteadminController::class, 'deletearticle'])->name('deletearticle');

    //Banner
    Route::get('/siteadmin/banner', [App\Http\Controllers\SiteadminController::class, 'banner'])->name('banner');
    Route::get('/siteadmin/createbanner', [App\Http\Controllers\SiteadminController::class, 'createbanner'])->name('createbanner');
    Route::post('/siteadmin/storebanner', [App\Http\Controllers\SiteadminController::class, 'storebanner'])->name('storebanner');
    Route::get('/siteadmin/editbanner/{id}', [App\Http\Controllers\SiteadminController::class, 'editbanner'])->name('editbanner');
    Route::post('/siteadmin/updatebanner', [App\Http\Controllers\SiteadminController::class, 'updatebanner'])->name('updatebanner');
    Route::get('/siteadmin/deleteBanner/{id}', [App\Http\Controllers\SiteadminController::class, 'deleteBanner'])->name('deleteBanner');
    Route::get('/siteadmin/statusbanner/{id}', [App\Http\Controllers\SiteadminController::class, 'statusbanner'])->name('statusbanner');

    //Contact us
    Route::get('/siteadmin/contactus', [App\Http\Controllers\SiteadminController::class, 'contactus'])->name('siteadmin.contactus');
    Route::get('/siteadmin/createcontactus', [App\Http\Controllers\SiteadminController::class, 'createcontactus'])->name('siteadmin.createcontactus');
    Route::post('/siteadmin/storecontactus', [App\Http\Controllers\SiteadminController::class, 'storecontactus'])->name('siteadmin.storecontactus');
    Route::get('/siteadmin/editcontactus/{id}', [App\Http\Controllers\SiteadminController::class, 'editcontactus'])->name('siteadmin.editcontactus');
    Route::post('/siteadmin/updatecontactus', [App\Http\Controllers\SiteadminController::class, 'updatecontactus'])->name('siteadmin.updatecontactus');
    Route::get('/siteadmin/deletecontactus/{id}', [App\Http\Controllers\SiteadminController::class, 'deletecontactus'])->name('siteadmin.deletecontactus');

    //Mainmenu
    Route::get('/siteadmin/mainmenu', [App\Http\Controllers\SiteadminController::class, 'mainmenu'])->name('mainmenu');
    Route::get('/siteadmin/createmainmenu', [App\Http\Controllers\SiteadminController::class, 'createmainmenu'])->name('createmainmenu');
    Route::post('/siteadmin/storeMainmenu', [App\Http\Controllers\SiteadminController::class, 'storeMainmenu'])->name('storeMainmenu');
    Route::get('/siteadmin/editmainmenu/{id}', [App\Http\Controllers\SiteadminController::class, 'editmainmenu'])->name('editmainmenu');
    Route::post('/siteadmin/updateMainmenu', [App\Http\Controllers\SiteadminController::class, 'updateMainmenu'])->name('updateMainmenu');
    Route::get('/siteadmin/deletemainmenu/{id}', [App\Http\Controllers\SiteadminController::class, 'deletemainmenu'])->name('deletemainmenu');
    Route::get('/siteadmin/statusmainmenu/{id}', [App\Http\Controllers\SiteadminController::class, 'statusmainmenu'])->name('statusmainmenu');
    Route::get('/siteadmin/createmainmenu', [App\Http\Controllers\SiteadminController::class, 'createmainmenu'])->name('createmainmenu');
    Route::get('/siteadmin/admin/articleload', [App\Http\Controllers\SiteadminController::class, 'articleload'])->name('admin.articleload');
    Route::get('/siteadmin/admin/downloadtypeload', [App\Http\Controllers\SiteadminController::class, 'downloadtypeload'])->name('admin.downloadtypeload');
    Route::get('/siteadmin/OrderchangeMainmenu_form', [App\Http\Controllers\SiteadminController::class, 'OrderchangeMainmenu_form'])->name('OrderchangeMainmenu_form');
    Route::get('/siteadmin/ordernumbercheckmainmenu', [App\Http\Controllers\SiteadminController::class, 'ordernumbercheckmainmenu'])->name('admin.ordernumbercheckmainmenu');

    //Submenu
    Route::get('/siteadmin/submenu', [App\Http\Controllers\SiteadminController::class, 'submenu'])->name('submenu');
    Route::get('/siteadmin/createsubmenu', [App\Http\Controllers\SiteadminController::class, 'createsubmenu'])->name('createsubmenu');
    Route::post('/siteadmin/storesubmenu', [App\Http\Controllers\SiteadminController::class, 'storesubmenu'])->name('storesubmenu');
    Route::get('/siteadmin/editsubmenu/{id}', [App\Http\Controllers\SiteadminController::class, 'editsubmenu'])->name('editsubmenu');
    Route::post('/siteadmin/updatesubmenu', [App\Http\Controllers\SiteadminController::class, 'updatesubmenu'])->name('updatesubmenu');
    Route::get('/siteadmin/deletesubmenu/{id}', [App\Http\Controllers\SiteadminController::class, 'deletesubmenu'])->name('deletesubmenu');
    Route::get('/siteadmin/statussubmenu/{id}', [App\Http\Controllers\SiteadminController::class, 'statussubmenu'])->name('statussubmenu');
    Route::get('/siteadmin/sbuwisemainmenu', [App\Http\Controllers\SiteadminController::class, 'sbuwisemainmenu'])->name('admin.sbuwisemainmenu');
    Route::get('/siteadmin/ordernumberchecksubmenu', [App\Http\Controllers\SiteadminController::class, 'ordernumberchecksubmenu'])->name('admin.ordernumberchecksubmenu');

    //Gallery
    Route::get('/siteadmin/gallerylist', [App\Http\Controllers\SiteadminController::class, 'gallery'])->name('siteadmin.gallerylist');
    Route::get('/siteadmin/creategallery', [App\Http\Controllers\SiteadminController::class, 'creategallery'])->name('siteadmin.creategallery');
    Route::post('/siteadmin/storegallery', [App\Http\Controllers\SiteadminController::class, 'storegallery'])->name('siteadmin.storegallery');
    Route::post('/galitemstore/{id}', [App\Http\Controllers\SiteadminController::class, 'galitemstore'])->name('galitemstore');
    Route::get('/siteadmin/editgallery/{id}', [App\Http\Controllers\SiteadminController::class, 'editgallery'])->name('siteadmin.editgallery');
    Route::post('/siteadmin/updategallery', [App\Http\Controllers\SiteadminController::class, 'updategallery'])->name('siteadmin.updategallery');
    Route::get('/siteadmin/deletegallery/{id}', [App\Http\Controllers\SiteadminController::class, 'deletegallery'])->name('siteadmin.deletegallery');
    Route::post('/siteadmin/galitemstoreuppy/{id}', [App\Http\Controllers\SiteadminController::class, 'galitemstoreuppy'])->name('siteadmin.galitemstoreuppy');
    Route::get('/viewgallarypics/{id}', [App\Http\Controllers\SiteadminController::class, 'viewgallarypics'])
        ->name('viewgallarypics')
        ->middleware('auth');
    Route::get('/siteadmin/galitemdel/{id}', [App\Http\Controllers\SiteadminController::class, 'galitemdel'])->middleware('auth');
    Route::get('/siteadmin/statusgallery/{id}', [App\Http\Controllers\SiteadminController::class, 'statusgallery'])->name('siteadmin.statusgallery');

    //Link type
    Route::get('/siteadmin/midwidget', [App\Http\Controllers\SiteadminController::class, 'midwidget'])->name('siteadmin.midwidget');
    Route::post('/siteadmin/storemidwidget', [App\Http\Controllers\SiteadminController::class, 'storemidwidget'])->name('siteadmin.storemidwidget');
    Route::get('/siteadmin/editmidwidget/{id}', [App\Http\Controllers\SiteadminController::class, 'editmidwidget'])->name('siteadmin.editmidwidget');
    Route::post('/siteadmin/updatemidwidget', [App\Http\Controllers\SiteadminController::class, 'updatemidwidget'])->name('siteadmin.updatemidwidget');
    Route::get('/siteadmin/deletemidwidget/{id}', [App\Http\Controllers\SiteadminController::class, 'deletemidwidget'])->name('siteadmin.deletemidwidget');

    //Links
    Route::get('/siteadmin/links', [App\Http\Controllers\SiteadminController::class, 'links'])->name('links');
    Route::get('/siteadmin/createlinks', [App\Http\Controllers\SiteadminController::class, 'createlinks'])->name('createlinks');
    Route::post('/siteadmin/storelink', [App\Http\Controllers\SiteadminController::class, 'storelink'])->name('storelink');
    Route::get('/siteadmin/editlinks/{id}', [App\Http\Controllers\SiteadminController::class, 'editlinks'])->name('editlinks');
    Route::post('/siteadmin/updatelink', [App\Http\Controllers\SiteadminController::class, 'updatelink'])->name('updatelink');
    Route::get('/siteadmin/deletelink/{id}', [App\Http\Controllers\SiteadminController::class, 'deletelink'])->name('deletelink');
    Route::get('/siteadmin/statuslink/{id}', [App\Http\Controllers\SiteadminController::class, 'statuslink'])->name('statuslink');
    Route::get('/siteadmin/Orderchangelinklist_form', [App\Http\Controllers\SiteadminController::class, 'Orderchangelinklist_form'])->name('Orderchangelinklist_form');

    //Milestone
    Route::get('/siteadmin/milestone', [App\Http\Controllers\SiteadminController::class, 'milestonelist'])->name('milestone');
    Route::get('/siteadmin/createmilestone', [App\Http\Controllers\SiteadminController::class, 'createmilestone'])->name('createmilestone');
    Route::post('/siteadmin/storemilestone', [App\Http\Controllers\SiteadminController::class, 'storemilestone'])->name('storemilestone');
    Route::get('/siteadmin/editmilestone/{id}', [App\Http\Controllers\SiteadminController::class, 'editmilestone'])->name('editmilestone');
    Route::post('/siteadmin/updatemilestone', [App\Http\Controllers\SiteadminController::class, 'updatemilestone'])->name('updatemilestone');
    Route::get('/siteadmin/deletemilestone/{id}', [App\Http\Controllers\SiteadminController::class, 'deletemilestone'])->name('deletemilestone');
    Route::get('/siteadmin/statusmilestone/{id}', [App\Http\Controllers\SiteadminController::class, 'statusmilestone'])->name('statusmilestone');

    //Logo
    Route::get('/siteadmin/logo', [App\Http\Controllers\SiteadminController::class, 'logo'])->name('logo');
    Route::get('/siteadmin/createlogo', [App\Http\Controllers\SiteadminController::class, 'createlogo'])->name('createlogo');
    Route::post('/siteadmin/storelogo', [App\Http\Controllers\SiteadminController::class, 'storelogo'])->name('storelogo');
    Route::get('/siteadmin/editlogo/{id}', [App\Http\Controllers\SiteadminController::class, 'editlogo'])->name('editlogo');
    Route::post('/siteadmin/updatelogo', [App\Http\Controllers\SiteadminController::class, 'updatelogo'])->name('updatelogo');
    Route::get('/siteadmin/deletelogo/{id}', [App\Http\Controllers\SiteadminController::class, 'deletelogo'])->name('deletelogo');
});

//Master Admin Start
Route::group(['middleware' => ['auth', 'App\Http\Middleware\Masteradminlogin','prevent-back-history', 'CORS', 'XSS']], function () {
    //Dashboard
    Route::get('masterhome', [App\Http\Controllers\MasterController::class, 'index'])->name('masterhome');

    //Article Type
    Route::get('/masteradmin/articletype', [App\Http\Controllers\MasterController::class, 'articletype'])->name('articletype');
    Route::get('/masteradmin/createarticletype', [App\Http\Controllers\MasterController::class, 'createarticletype'])->name('createarticletype');
    Route::post('/masteradmin/storearticletype', [App\Http\Controllers\MasterController::class, 'storearticletype'])->name('storearticletype');
    Route::get('/masteradmin/editarticletype/{id}', [App\Http\Controllers\MasterController::class, 'editarticletype'])->name('editarticletype');
    Route::post('/masteradmin/updatearticletype', [App\Http\Controllers\MasterController::class, 'updatearticletype'])->name('updatearticletype');
    Route::get('/masteradmin/deletearticletype/{id}', [App\Http\Controllers\MasterController::class, 'deletearticletype'])->name('deletearticletype');
    Route::get('/masteradmin/statusarticletype/{id}', [App\Http\Controllers\MasterController::class, 'statusarticletype'])->name('statusarticletype');

    // BOD
    Route::get('/masteradmin/BODlist', [App\Http\Controllers\MasterController::class, 'BODlist'])->name('BODlist');
    Route::post('/masteradmin/storeBOD', [App\Http\Controllers\MasterController::class, 'storeBOD'])->name('storeBOD');
    Route::get('/masteradmin/editBOD/{id}', [App\Http\Controllers\MasterController::class, 'editBOD'])->name('editBOD');
    Route::post('/masteradmin/updateBOD', [App\Http\Controllers\MasterController::class, 'updateBOD'])->name('updateBOD');
    Route::get('/masteradmin/deleteBOD/{id}', [App\Http\Controllers\MasterController::class, 'deleteBOD'])->name('deleteBOD');

    //Footermenu
    Route::get('/masteradmin/footermenu', [App\Http\Controllers\MasterController::class, 'footermenu'])->name('footermenu');
    Route::get('/masteradmin/createfootermenu', [App\Http\Controllers\MasterController::class, 'createfootermenu'])->name('createfootermenu');
    Route::post('/masteradmin/storefootermenu', [App\Http\Controllers\MasterController::class, 'storefootermenu'])->name('storefootermenu');
    Route::get('/masteradmin/editfootermenu/{id}', [App\Http\Controllers\MasterController::class, 'editfootermenu'])->name('editfootermenu');
    Route::post('/masteradmin/updatefootermenu', [App\Http\Controllers\MasterController::class, 'updatefootermenu'])->name('updatefootermenu');
    Route::get('/masteradmin/deletefootermenu/{id}', [App\Http\Controllers\MasterController::class, 'deletefootermenu'])->name('deletefootermenu');

    //Logo type
    Route::get('/masteradmin/logotype', [App\Http\Controllers\MasterController::class, 'logotype'])->name('logotype');
    Route::post('/masteradmin/storelogotype', [App\Http\Controllers\MasterController::class, 'storelogotype'])->name('storelogotype');
    Route::get('/masteradmin/editlogotype/{id}', [App\Http\Controllers\MasterController::class, 'editlogotype'])->name('editlogotype');
    Route::post('/masteradmin/updatelogotype', [App\Http\Controllers\MasterController::class, 'updatelogotype'])->name('updatelogotype');
    Route::get('/masteradmin/deletelogotype/{id}', [App\Http\Controllers\MasterController::class, 'deletelogotype'])->name('deletelogotype');

    //Menulinktype
    Route::get('/masteradmin/menulinktype', [App\Http\Controllers\MasterController::class, 'menulinktype'])->name('menulinktype');
    Route::post('/masteradmin/storemenulinktype', [App\Http\Controllers\MasterController::class, 'storemenulinktype'])->name('storemenulinktype');
    Route::get('/masteradmin/editMenulinktype/{id}', [App\Http\Controllers\MasterController::class, 'editMenulinktype'])->name('editMenulinktype');
    Route::post('/masteradmin/updateMenulinktype', [App\Http\Controllers\MasterController::class, 'updateMenulinktype'])->name('updateMenulinktype');
    Route::get('/masteradmin/deleteMenulinktype/{id}', [App\Http\Controllers\MasterController::class, 'deleteMenulinktype'])->name('deleteMenulinktype');
    Route::get('/masteradmin/statusmenutype/{id}', [App\Http\Controllers\MasterController::class, 'statusmenutype'])->name('statusmenutype');

    //pressrelase type
    Route::get('/masteradmin/publicrelationtype', [App\Http\Controllers\MasterController::class, 'publicrelationtype'])->name('publicrelationtype');
    Route::post('/storepublicrelationtype', [App\Http\Controllers\MasterController::class, 'storepublicrelationtype'])->name('storepublicrelationtype');
    Route::get('/editwidget/{id}', [App\Http\Controllers\MasterController::class, 'editwidget'])->name('editwidget');
    Route::post('/updatepublicrelationtype', [App\Http\Controllers\MasterController::class, 'updatpublicrelationtype'])->name('updatepublicrelationtype');
    Route::get('/deletewidget/{id}', [App\Http\Controllers\MasterController::class, 'deletewidget'])->name('deletewidget');
    Route::get('/statuswidgetpost/{id}', [App\Http\Controllers\MasterController::class, 'statuswidgetpost'])->name('statuswidgetpost');

    //Linked item
    Route::get('masteradmin/linktype', [App\Http\Controllers\MasterController::class, 'linktype'])->name('masteradmin.linktype');
    Route::get('/masteradmin/createlinktype', [App\Http\Controllers\MasterController::class, 'createlinktype'])->name('masteradmin.createlinktype');
    Route::post('/masteradmin/storelinktype', [App\Http\Controllers\MasterController::class, 'storelinktype'])->name('masteradmin.storelinktype');
    Route::get('/masteradmin/editlinktype/{id}', [App\Http\Controllers\MasterController::class, 'editlinktype'])->name('masteradmin.editlinktype');
    Route::post('/masteradmin/updatelinktype', [App\Http\Controllers\MasterController::class, 'updatelinktype'])->name('masteradmin.updatelinktype');
    Route::get('/masteradmin/deletelinktype/{id}', [App\Http\Controllers\MasterController::class, 'deletelinktype'])->name('masteradmin.deletelinktype');

    //Tender type
    Route::get('/masteradmin/tendertypelist', [App\Http\Controllers\MasterController::class, 'tendertypelist'])->name('masteradmin.tendertype');
    Route::get('/masteradmin/createtendertype', [App\Http\Controllers\MasterController::class, 'createtendertype'])->name('masteradmin.createtendertype');
    Route::post('/masteradmin/storetendertype', [App\Http\Controllers\MasterController::class, 'storetendertype'])->name('masteradmin.storetendertype');
    Route::get('/masteradmin/edittendertype/{id}', [App\Http\Controllers\MasterController::class, 'edittendertype'])->name('masteradmin.edittendertype');
    Route::post('/masteradmin/updatetendertype', [App\Http\Controllers\MasterController::class, 'updatetendertype'])->name('masteradmin.updatetendertype');
    Route::get('/masteradmin/deletetendertype/{id}', [App\Http\Controllers\MasterController::class, 'deletetendertype'])->name('masteradmin.deletetendertype');
});
//Master Admin End

//Media Admin Start
Route::group(['middleware' => ['auth', 'App\Http\Middleware\Mediaadminlogin','prevent-back-history', 'CORS', 'XSS']], function () {
    //Dashboard
    Route::get('mediaadminhome', [App\Http\Controllers\MediaadminController::class, 'index'])->name('mediaadminhome');

    //Gallery
    Route::get('/mediaadmin/publicrelation', [App\Http\Controllers\MediaadminController::class, 'publicrelation'])->name('publicrelation');
    Route::get('/mediaadmin/createpublicrelation', [App\Http\Controllers\MediaadminController::class, 'createpublicrelation'])->name('createpublicrelation');
    Route::post('/mediaadmin/storepublicrelation', [App\Http\Controllers\MediaadminController::class, 'storepublicrelation'])->name('storepublicrelation');
    Route::post('/mediaadmin/galitemstore/{id}', [App\Http\Controllers\MediaadminController::class, 'galitemstore'])->name('galitemstore');
    Route::get('/mediaadmin/editpublicrelation/{id}', [App\Http\Controllers\MediaadminController::class, 'editpublicrelation'])->name('editpublicrelation');
    Route::post('/mediaadmin/updatepublicrelation', [App\Http\Controllers\MediaadminController::class, 'updatepublicrelation'])->name('updatepublicrelation');
    Route::get('/mediaadmin/deletepublicrelation/{id}', [App\Http\Controllers\MediaadminController::class, 'deletepublicrelation'])->name('deletepublicrelation');
    Route::post('/mediaadmin/pressrelitemstoreuppy/{id}', [App\Http\Controllers\MediaadminController::class, 'pressrelstoreuppy'])->name('pressrelstoreuppy');
    Route::get('/mediaadmin/viewpressrelpics/{id}', [App\Http\Controllers\MediaadminController::class, 'viewpressrelpics'])
        ->name('viewpressrelpics')
        ->middleware('auth');
    Route::get('/mediaadmin/publicrelitemdel/{id}', [App\Http\Controllers\MediaadminController::class, 'galitemdel'])->name('galitemdel');
    Route::get('/mediaadmin/statuspublicrelation/{id}', [App\Http\Controllers\MediaadminController::class, 'statuspublicrelation'])->name('statuspublicrelation');

    Route::get('/mediaadmin/tenderlist', [App\Http\Controllers\MediaadminController::class, 'tenderlist'])->name('mediaadmin.tenderlist');
    Route::get('/mediaadmin/createtender', [App\Http\Controllers\MediaadminController::class, 'createtender'])->name('mediaadmin.createtender');
    Route::post('/mediaadmin/storetender', [App\Http\Controllers\MediaadminController::class, 'storetender'])->name('mediaadmin.storetender');
    Route::post('/mediaadmin/updatetender', [App\Http\Controllers\MediaadminController::class, 'updatetender'])->name('mediaadmin.updatetender');
    Route::post('/mediaadmin/tenderstoreuppy/{id}', [App\Http\Controllers\MediaadminController::class, 'tenderstoreuppy'])->name('mediaadmin.tenderstoreuppy');
    Route::get('/mediaadmin/viewtenderpics/{id}', [App\Http\Controllers\MediaadminController::class, 'viewtenderpics'])
        ->name('mediaadmin.viewtenderpics')
        ->middleware('auth');
    Route::get('/mediaadmin/tenderitemdel/{id}', [App\Http\Controllers\MediaadminController::class, 'tenderitemdel'])->middleware('auth');
    Route::get('/mediaadmin/edittender/{id}', [App\Http\Controllers\MediaadminController::class, 'edittender'])
        ->name('mediaadmin.edittender')
        ->middleware('auth');
    Route::get('/mediaadmin/deletetender/{id}', [App\Http\Controllers\MediaadminController::class, 'deletetender'])
        ->name('mediaadmin.deletetender')
        ->middleware('auth');

    Route::get('/mediaadmin/whatwedo', [App\Http\Controllers\MediaadminController::class, 'whatwedo'])->name('mediaadmin.whatwedo');
    Route::get('/mediaadmin/createwhatwedo', [App\Http\Controllers\MediaadminController::class, 'createwhatwedo'])->name('mediaadmin.createwhatwedo');
    Route::post('/mediaadmin/storewhatwedo', [App\Http\Controllers\MediaadminController::class, 'storewhatwedo'])->name('mediaadmin.storewhatwedo');
    Route::get('/mediaadmin/editwhatwedo', [App\Http\Controllers\MediaadminController::class, 'editwhatwedo'])->name('mediaadmin.editwhatwedo');
    Route::post('/mediaadmin/updatewhatwedo', [App\Http\Controllers\MediaadminController::class, 'updatewhatwedo'])->name('mediaadmin.updatewhatwedo');
    Route::post('/mediaadmin/whatwedostoreuppy/{id}', [App\Http\Controllers\MediaadminController::class, 'whatwedostoreuppy'])->name('mediaadmin.whatwedostoreuppy');
    Route::get('/mediaadmin/viewwhatwedostorepics/{id}', [App\Http\Controllers\MediaadminController::class, 'viewwhatwedostorepics'])
        ->name('mediaadmin.viewwhatwedostorepics')
        ->middleware('auth');
    Route::get('/mediaadmin/whatwedoitemdel/{id}', [App\Http\Controllers\MediaadminController::class, 'whatwedoitemdel'])->middleware('auth');
    Route::get('/mediaadmin/editwhatwedo/{id}', [App\Http\Controllers\MediaadminController::class, 'editwhatwedo'])
        ->name('mediaadmin.editwhatwedo')
        ->middleware('auth');
    Route::get('/mediaadmin/deletewhatwedo/{id}', [App\Http\Controllers\MediaadminController::class, 'deletewhatwedo'])
        ->name('mediaadmin.deletewhatwedo')
        ->middleware('auth');
});
