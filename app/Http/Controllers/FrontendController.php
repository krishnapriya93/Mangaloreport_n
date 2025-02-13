<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\FrontendController;

use Illuminate\Http\Request;
use Session;
use App\Models\Mainmenu;
use App\Models\Article;
use App\Models\Language;
use App\Models\Socialmedia;
use App\Models\Banner;
use App\Models\Publicrelation;
use App\Models\Link;
use App\Models\BOD;
use App\Models\Tender;
use App\Models\Gallery;
use App\Models\Milestone;

class FrontendController extends Controller
{
    //
    public function index($langid = null)
    {
        if (!Session::has('bilingual')) {
            Session::put('bilingual', 1);
        }

        if ($langid == null) {
            $sessionbil = Session::get('bilingual');
        } else {
            $sessionbil = 2;
        }

        $mainsubmenus = $this->mainmenu($sessionbil);

        $mainbanner = $this->mainbanner($sessionbil);
        $circulartrades = $this->circulartrade($sessionbil);

        $whatwedo = $this->whatwedo($sessionbil);
        $relatedlinks = $this->relatedlinks($sessionbil);
        $socialmedia = $this->socialmedia($sessionbil);
        $bod = $this->bod($sessionbil);
        $whatsnew = $this->whatsnew($sessionbil);
        $tender = $this->tender($sessionbil);
        $gallery = $this->gallery($sessionbil);
        $midwidget = $this->midwidget($sessionbil);

        return view('frontend.main.mainpage', compact('sessionbil', 'mainsubmenus', 'mainbanner', 'circulartrades', 'whatwedo', 'relatedlinks', 'socialmedia', 'bod', 'tender', 'whatsnew', 'gallery', 'midwidget'));
    }
    public function setbilingualvalmal(Request $request)
    {
        if ($request->ajax()) {
            Session::forget('bilingual');
            Session::put('bilingual', 2);
            return response()->json(['success' => 'successfully set']);
        }
    }
    public function setbilingualval(Request $request)
    {
        if ($request->ajax()) {
            Session::forget('bilingual');
            Session::put('bilingual', 1);
            return response()->json(['success' => 'successfully set']);
        }
    }

    // public function mainarticle($articlename,$enarticletypeid)
    public function mainarticle($articletypeid,$enarticletypeid)
    {
        try {
            $articletypeid = Crypt::decryptString($enarticletypeid);
            if (!Session::has('bilingual')) {
                Session::put('bilingual', 1);
            }
            $sessionbil = Session::get('bilingual');
            $language = Language::where('delet_flag', 0)->orderBy('name')->get();

            //social media
            $socialmedia = $this->socialmedia($sessionbil);

            $mainsubmenus = $this->mainmenu($sessionbil);
            // $footerquicklinks       = $this->footerQuickLinks($sessionbil);
            // $footerimportantlinks   = $this->footerImportantLinks($sessionbil);
            // $sitecontrollabels      = $this->siteControlLables($sessionbil);
            //article details
            $articledetails = Article::with([
                'articleval_sub' => function ($query) use ($sessionbil) {
                    $query->where('languageid', $sessionbil);
                },
            ])
                ->where('status_id', '1')
                ->where('articletype_id', $articletypeid)
                ->orderBy('id', 'DESC')
                ->first();

            return view(
                'frontend.main.mainarticle',
                compact(
                    'sessionbil',
                    'language',
                    'socialmedia',
                    'mainsubmenus',
                    'articledetails',
                    // 'mainbanner',
                    // 'footerquicklinks',
                    // 'footerimportantlinks',
                    // 'sitecontrollabels',
                ),
            );
        } catch (ModelNotFoundException $exception) {
            \LogActivity::addToLog($exception->getMessage(), 'error');
            $data = \LogActivity::logLatestItem();
            return Redirect::back()
                ->withInput()
                ->withErrors('Please contact admin; the error code is ERROR' . $data->id);
        }
    }
    public function mainmenu($sessionbil)
    {
        $sessionbil = $sessionbil;
        $mainsubmenu = Mainmenu::with([
            'sub_menu' => function ($query) use ($sessionbil) {
                $query->with([
                    'submenusub' => function ($query1) use ($sessionbil) {
                        $query1->where('languageid', $sessionbil);
                    },
                ]);

                $query->with([
                    'subsubmenu' => function ($query3) use ($sessionbil) {
                        $query3->with([
                            'subsubmenusub' => function ($query4) use ($sessionbil) {
                                $query4->where('languageid', $sessionbil);
                            },
                        ]);
                        $query3->orderBy('orderno', 'asc');
                    },
                ]);
                $query->where('status_id', 1);
                $query->orderBy('orderno', 'asc');
            },
        ])

            ->with([
                'mainmenu_sub' => function ($query2) use ($sessionbil) {
                    $query2->where('languageid', $sessionbil);
                },
            ])
            ->where('status_id', 1)
            ->orderBy('orderno', 'asc')
            ->get();

        return $mainsubmenu;
    }
    public function mainbanner($sessionbil)
    {
        $mainbanner = Banner::with([
            'banner_sub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->where('delet_flag', 0)
            ->where('status_id', 1)
            ->orderBy('id', 'DESC')
            ->limit(6)
            ->get();

        return $mainbanner;
    }

    public function circulartrade($sessionbil)
    {
        $circulartrade = publicrelation::with([
            'publicrelsub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->with([
                'publicrelationtype' => function ($query2) {
                    $query2->where('id', 2);
                },
            ])
            ->where('delet_flag', 0)
            ->where('status_id', 1)
            ->where('publicreltypeid', 1)
            ->orderBy('id', 'DESC')
            ->limit(6)
            ->get();

        return $circulartrade;
    }

    public function whatwedo($sessionbil)
    {
        $sessionbil = 1;
        $whatwedo = Link::with([
            'link_sub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->where('delet_flag', 0)
            ->where('status_id', 1)
            ->orderBy('orderno', 'asc')
            ->where('linktypeid', 10)
            ->get();

        return $whatwedo;
    }
    public function relatedlinks($sessionbil)
    {
        $sessionbil = 1;
        $relatedlinks = Link::with([
            'link_sub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->where('delet_flag', 0)
            ->where('status_id', 1)
            ->orderBy('orderno', 'asc')
            ->where('linktypeid', 5)
            ->get();

        return $relatedlinks;
    }
    public function socialmedia($sessionbil)
    {
        $sessionbil = 1;
        $socialmedia = Link::with([
            'link_sub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->where('delet_flag', 0)
            ->where('status_id', 1)
            ->orderBy('orderno', 'asc')
            ->where('linktypeid', 11)
            ->get();

        return $socialmedia;
    }
    public function midwidget($sessionbil)
    {
        $sessionbil = 1;
        $midwidget = Link::with([
            'link_sub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->where('delet_flag', 0)
            ->where('status_id', 1)
            ->orderBy('orderno', 'asc')
            ->where('linktypeid', 12)
            ->get();

        return $midwidget;
    }

    public function bod($sessionbil)
    {
        $bod = BOD::with([
            'bodsub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        return $bod;
    }

    public function tender($sessionbil)
    {
        $tender = Tender::with([
            'tender_sub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->where('status_id', 1)
            ->orderBy('id', 'DESC')
            ->limit(2)
            ->get();

        return $tender;
    }

    public function whatsnew($sessionbil)
    {
        $whatsnew = Publicrelation::with([
            'publicrelsub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->where('publicreltypeid', 2)
            ->where('status_id', 1)
            ->orderBy('id', 'DESC')
            ->limit(2)
            ->get();

        return $whatsnew;
    }

    public function gallery($sessionbil)
    {
        $gallery = Gallery::with([
            'gallery_sub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            // ->where('sbutype_id', "")
            ->orderBy('date', 'DESC')
            ->where('status_id', 1)
            ->where('userid', 2)
            ->where('gallerytypeid', 3)
            ->get();

        return $gallery;
    }

    public function milestoneview()
    {
        if (!Session::has('bilingual')) {
            Session::put('bilingual', 1);
        }
        $sessionbil = Session::get('bilingual');
        $mainsubmenus = $this->mainmenu($sessionbil);

        $mainbanner = $this->mainbanner($sessionbil);
        $circulartrades = $this->circulartrade($sessionbil);

        $whatwedo = $this->whatwedo($sessionbil);
        $relatedlinks = $this->relatedlinks($sessionbil);
        $socialmedia = $this->socialmedia($sessionbil);
        $bod = $this->bod($sessionbil);
        $whatsnew = $this->whatsnew($sessionbil);
        $tender = $this->tender($sessionbil);
        $gallery = $this->gallery($sessionbil);

        $milestone = Milestone::with([
            'milestonesub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->orderBy('date', 'DESC')
            ->where('status_id', 1)
            ->get();

        return view('frontend.main.milestone', compact('sessionbil', 'mainsubmenus', 'mainbanner', 'circulartrades', 'whatwedo', 'relatedlinks', 'socialmedia', 'bod', 'tender', 'whatsnew', 'gallery', 'milestone'));
    }

    public function bodview()
    {
        if (!Session::has('bilingual')) {
            Session::put('bilingual', 1);
        }
        $sessionbil = Session::get('bilingual');
        $mainsubmenus = $this->mainmenu($sessionbil);

        $mainbanner = $this->mainbanner($sessionbil);
        $circulartrades = $this->circulartrade($sessionbil);

        $whatwedo = $this->whatwedo($sessionbil);
        $relatedlinks = $this->relatedlinks($sessionbil);
        $socialmedia = $this->socialmedia($sessionbil);
        $bod = $this->bod($sessionbil);
        $whatsnew = $this->whatsnew($sessionbil);
        $tender = $this->tender($sessionbil);
        $gallery = $this->gallery($sessionbil);

        //BOARD OF DIRECTORS
        $bod = BOD::with([
            'bodsub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->orderBy('order_num', 'DESC')
            ->where('status', 1)
            ->get();

        return view('frontend.main.bodview', compact('sessionbil', 'mainsubmenus', 'mainbanner', 'circulartrades', 'whatwedo', 'relatedlinks', 'socialmedia', 'bod', 'tender', 'whatsnew', 'gallery', 'bod'));
    }
    public function whoswhoview()
    {
        if (!Session::has('bilingual')) {
            Session::put('bilingual', 1);
        }
        $sessionbil = Session::get('bilingual');
        $mainsubmenus = $this->mainmenu($sessionbil);

        $mainbanner = $this->mainbanner($sessionbil);
        $circulartrades = $this->circulartrade($sessionbil);

        $whatwedo = $this->whatwedo($sessionbil);
        $relatedlinks = $this->relatedlinks($sessionbil);
        $socialmedia = $this->socialmedia($sessionbil);
        $bod = $this->bod($sessionbil);
        $whatsnew = $this->whatsnew($sessionbil);
        $tender = $this->tender($sessionbil);
        $gallery = $this->gallery($sessionbil);

        //BOARD OF DIRECTORS
        $bod = BOD::with([
            'bodsub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->orderBy('order_num', 'DESC')
            ->where('status', 1)
            ->get();

        return view('frontend.main.whoswhoview', compact('sessionbil', 'mainsubmenus', 'mainbanner', 'circulartrades', 'whatwedo', 'relatedlinks', 'socialmedia', 'bod', 'tender', 'whatsnew', 'gallery', 'bod'));
    }
    public function chiefofficers()
    {
        if (!Session::has('bilingual')) {
            Session::put('bilingual', 1);
        }
        $sessionbil = Session::get('bilingual');
        $mainsubmenus = $this->mainmenu($sessionbil);

        $mainbanner = $this->mainbanner($sessionbil);
        $circulartrades = $this->circulartrade($sessionbil);

        $whatwedo = $this->whatwedo($sessionbil);
        $relatedlinks = $this->relatedlinks($sessionbil);
        $socialmedia = $this->socialmedia($sessionbil);
        $bod = $this->bod($sessionbil);
        $whatsnew = $this->whatsnew($sessionbil);
        $tender = $this->tender($sessionbil);
        $gallery = $this->gallery($sessionbil);

        //BOARD OF DIRECTORS
        $bod = BOD::with([
            'bodsub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->orderBy('order_num', 'DESC')
            ->where('status', 1)
            ->get();

        return view('frontend.main.chiefofficers', compact('sessionbil', 'mainsubmenus', 'mainbanner', 'circulartrades', 'whatwedo', 'relatedlinks', 'socialmedia', 'bod', 'tender', 'whatsnew', 'gallery', 'bod'));
    }
    public function sitemap()
    {
        if (!Session::has('bilingual')) {
            Session::put('bilingual', 1);
        }
        $sessionbil = Session::get('bilingual');
        $mainsubmenus = $this->mainmenu($sessionbil);

        $mainbanner = $this->mainbanner($sessionbil);
        $circulartrades = $this->circulartrade($sessionbil);

        $whatwedo = $this->whatwedo($sessionbil);
        $relatedlinks = $this->relatedlinks($sessionbil);
        $socialmedia = $this->socialmedia($sessionbil);
        $bod = $this->bod($sessionbil);
        $whatsnew = $this->whatsnew($sessionbil);
        $tender = $this->tender($sessionbil);
        $gallery = $this->gallery($sessionbil);

        //BOARD OF DIRECTORS
        $bod = BOD::with([
            'bodsub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->orderBy('order_num', 'DESC')
            ->where('status', 1)
            ->get();

        return view('frontend.main.sitemap', compact('sessionbil', 'mainsubmenus', 'mainbanner', 'circulartrades', 'whatwedo', 'relatedlinks', 'socialmedia', 'bod', 'tender', 'whatsnew', 'gallery', 'bod'));
    }
    public function screenreader()
    {
        if (!Session::has('bilingual')) {
            Session::put('bilingual', 1);
        }
        $sessionbil = Session::get('bilingual');
        $mainsubmenus = $this->mainmenu($sessionbil);

        $mainbanner = $this->mainbanner($sessionbil);
        $circulartrades = $this->circulartrade($sessionbil);

        $whatwedo = $this->whatwedo($sessionbil);
        $relatedlinks = $this->relatedlinks($sessionbil);
        $socialmedia = $this->socialmedia($sessionbil);
        $bod = $this->bod($sessionbil);
        $whatsnew = $this->whatsnew($sessionbil);
        $tender = $this->tender($sessionbil);
        $gallery = $this->gallery($sessionbil);

        //BOARD OF DIRECTORS
        $bod = BOD::with([
            'bodsub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->orderBy('order_num', 'DESC')
            ->where('status', 1)
            ->get();

        return view('frontend.main.screenreader', compact('sessionbil', 'mainsubmenus', 'mainbanner', 'circulartrades', 'whatwedo', 'relatedlinks', 'socialmedia', 'bod', 'tender', 'whatsnew', 'gallery', 'bod'));
    }
    public function feedback()
    {
        if (!Session::has('bilingual')) {
            Session::put('bilingual', 1);
        }
        $sessionbil = Session::get('bilingual');
        $mainsubmenus = $this->mainmenu($sessionbil);

        $mainbanner = $this->mainbanner($sessionbil);
        $circulartrades = $this->circulartrade($sessionbil);

        $whatwedo = $this->whatwedo($sessionbil);
        $relatedlinks = $this->relatedlinks($sessionbil);
        $socialmedia = $this->socialmedia($sessionbil);
        $bod = $this->bod($sessionbil);
        $whatsnew = $this->whatsnew($sessionbil);
        $tender = $this->tender($sessionbil);
        $gallery = $this->gallery($sessionbil);

        //BOARD OF DIRECTORS
        $bod = BOD::with([
            'bodsub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            ->orderBy('order_num', 'DESC')
            ->where('status', 1)
            ->get();

        return view('frontend.main.feedback', compact('sessionbil', 'mainsubmenus', 'mainbanner', 'circulartrades', 'whatwedo', 'relatedlinks', 'socialmedia', 'bod', 'tender', 'whatsnew', 'gallery', 'bod'));
    }
    public function projects()
    {
        if (!Session::has('bilingual')) {
            Session::put('bilingual', 1);
        }
        $sessionbil = Session::get('bilingual');
        $mainsubmenus = $this->mainmenu($sessionbil);

        $mainbanner = $this->mainbanner($sessionbil);
        $circulartrades = $this->circulartrade($sessionbil);

        $whatwedo = $this->whatwedo($sessionbil);
        $relatedlinks = $this->relatedlinks($sessionbil);
        $socialmedia = $this->socialmedia($sessionbil);
        $bod = $this->bod($sessionbil);
        $whatsnew = $this->whatsnew($sessionbil);
        $tender = $this->tender($sessionbil);
        $gallery = $this->gallery($sessionbil);
$keyword='';
        $projects = publicrelation::with([
            'publicrelsub' => function ($query) use ($sessionbil) {
                $query->where('languageid', $sessionbil);
            },
        ])
            // ->with([
            //     // 'publicrelationtype' => function ($query2) {
            //     //     $query2->where('id', 3);
            //     // },
            // ])
            ->where('delet_flag', 0)
            ->where('status_id', 1)
            ->where('publicreltypeid', 3)
            ->orderBy('id', 'DESC')
            ->limit(6)
            ->get();

        return view('frontend.main.projectview', compact('sessionbil', 'mainsubmenus', 'mainbanner', 'circulartrades', 'whatwedo', 'relatedlinks', 'socialmedia', 'bod', 'tender', 'whatsnew', 'gallery', 'projects','keyword'));
    }
    public function projectdetailview($id)
    {
        if (!Session::has('bilingual')) {
            Session::put('bilingual', 1);
        }

        $sessionbil = Session::get('bilingual');
        $mainsubmenus = $this->mainmenu($sessionbil);
        $projectid = Crypt::decryptString($id);

        $mainbanner = $this->mainbanner($sessionbil);
        $circulartrades = $this->circulartrade($sessionbil);

        $whatwedo = $this->whatwedo($sessionbil);
        $relatedlinks = $this->relatedlinks($sessionbil);
        $socialmedia = $this->socialmedia($sessionbil);
        $bod = $this->bod($sessionbil);
        $whatsnew = $this->whatsnew($sessionbil);
        $tender = $this->tender($sessionbil);
        $gallery = $this->gallery($sessionbil);

        $projects = publicrelation::with(['publicrelationitem' =>function($q2) use ($projectid){
            $q2->where('publicrelationid', $projectid);
        }])->with([
                'publicrelsub' => function ($query) use ($sessionbil, $projectid) {
                    $query->where('languageid', $sessionbil);
                }])->with([
                    'publicreldep' => function ($query) use ($sessionbil, $projectid) {
                        $query->where('langcode', $sessionbil);
                    }])
                ->where('id', $projectid)->first();

        return view('frontend.main.projectdetailview', compact('sessionbil', 'mainsubmenus', 'mainbanner', 'circulartrades', 'whatwedo', 'relatedlinks', 'socialmedia', 'bod', 'tender', 'whatsnew', 'gallery', 'projects'));
    }
}
