<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Mainmenu;

class FrontendController extends Controller
{
//    
        public function index()
        {
            if (!Session::has('bilingual')) {
                Session::put('bilingual', 1);
            }
            $sessionbil = Session::get('bilingual');

            return view('frontend.main.mainpage',compact('bilingual')); 
        }
    
        
        private function mainmenu($sessionbil)
        {
                $sessionbil = 1;
                $mainsubmenus      = Mainmenu::with(['sub_menu' => function ($query) use($sessionbil){
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

                return $mainsubmenus;
            }
}
