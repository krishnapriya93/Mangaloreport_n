<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Session;
use App\Models\Mainmenu;
use App\Models\Article;
use App\Models\Language;
use App\Models\Socialmedia;
use App\Models\Banner;
use App\Models\Publicrelation;

class FrontendController extends Controller
{
//
        public function index()
        {
            if (!Session::has('bilingual')) {
                Session::put('bilingual', 1);
            }
            $sessionbil = Session::get('bilingual');
            $mainsubmenus = $this->mainmenu($sessionbil);

            $mainbanner = $this->mainbanner($sessionbil);
            $circulartrades = $this->circulartrade($sessionbil);

            return view('frontend.main.mainpage',compact('sessionbil','mainsubmenus','mainbanner','circulartrades'));
        }

    public function mainarticle($articlename,$enarticletypeid)
    {
        try{

            $articletypeid =  Crypt::decryptString($enarticletypeid);
            if (!Session::has('bilingual')) {
                Session::put('bilingual', 1);
            }
            $sessionbil = Session::get('bilingual');
            $language   = Language::where('delet_flag',0)->orderBy('name')->get();

            //social media
            $socialmedia    =   Socialmedia::with(['socialmedia_sub' =>function($query) use($sessionbil){
                $query->where('delet_flag',0)->where('languageid',$sessionbil);
                }])->where('delet_flag',0)->get();

            $mainsubmenus = $this->mainmenu($sessionbil);
            // $footerquicklinks       = $this->footerQuickLinks($sessionbil);
            // $footerimportantlinks   = $this->footerImportantLinks($sessionbil);
            // $sitecontrollabels      = $this->siteControlLables($sessionbil);
            //article details
            $articledetails =  Article::with(['articleval_sub' =>function($query) use($sessionbil){
                $query->where('languageid',$sessionbil);
            }])
            ->where('status_id', '1')
            ->where('articletype_id', $articletypeid)
            ->orderBy('id', 'DESC')
            ->first();

            return view('frontend.main.mainarticle',compact(
                    'sessionbil',
                    'language',
                    'socialmedia',
                    'mainsubmenus',
                    'articledetails',
                    // 'mainbanner',
                    // 'footerquicklinks',
                    // 'footerimportantlinks',
                    // 'sitecontrollabels',
            ));

        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(),'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()->withInput()->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }
    private function mainmenu($sessionbil)
    {
        $sessionbil   = 1;
        $mainsubmenu  = Mainmenu::with(['sub_menu' => function ($query) use($sessionbil){
                $query->with(['submenusub' => function ($query1) use($sessionbil) {
                    $query1->where('languageid',$sessionbil);

                }]);

                $query->with(['subsubmenu' => function ($query3) use($sessionbil) {
                    $query3->with(['subsubmenusub' => function ($query4) use($sessionbil) {
                        $query4->where('languageid',$sessionbil);

                    }]);
                    $query3->orderBy('orderno','asc');
                }]);
                $query->where('status_id',1);
                $query->orderBy('orderno','asc');
            }])

            ->with(['mainmenu_sub' => function ($query2) use($sessionbil){
                $query2->where('languageid',$sessionbil);
            }])
            ->where('status_id',1)
            ->where('viewer_id',1)
            ->orderBy('orderno', 'asc')
            ->get();

            return $mainsubmenu;
    }
    private function mainbanner($sessionbil)
    {

        $mainbanner =  Banner::with(['banner_sub' =>function($query) use($sessionbil){
            $query->where('languageid',$sessionbil);
        }])
        ->where('delet_flag',0)
        ->where('status_id',1)
        ->orderBy('id',  'DESC')
        ->limit(6)->get();

        return $mainbanner;
    }

    private function circulartrade($sessionbil)
    {

        $circulartrade =  publicrelation::with(['publicrelsub' =>function($query) use($sessionbil){
            $query->where('languageid',$sessionbil);
        }])->with(['publicrelationtype' => function($query2){
            $query2->where('id',2);
        }])
        ->where('delet_flag',0)
        ->where('status_id',1)
        ->orderBy('id',  'DESC')
        ->limit(6)->get();

        return $circulartrade;
    }
}
