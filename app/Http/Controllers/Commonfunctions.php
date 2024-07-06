<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Component;
use App\Models\Componentpermission;

class Commonfunctions extends Controller
{

    /*for setting component permission*/
    public function userinfo()
    {
        $role_id = Auth::user()->id;
       
        $user=user::where('id',$role_id)->first();

        return $user;
    }

  /*User informations*/
    public function componentpermissionsetng()
    {
       $role_id = Auth::user()->id;

    //    $data=Componentpermission::with(['component' => function($query){
    //         $query->where('delet_flag',0);             
    //         $query->orderBy('name'); // Changed to ascending order
    //     }])->with(['usertype' => function($query1){
    //       $query1->where('delet_flag',0);
    //     }])->where('delet_flag',0)->where('status_id',1)
    //     ->where('role_id', Auth::user()->role_id)
    //     ->get();
    $data = Componentpermission::with(['component' => function($query) {
        $query->where('delet_flag', 0);
    }, 'usertype' => function($query1) {
        $query1->where('delet_flag', 0);
    }])->where('delet_flag', 0)
      ->where('status_id', 1)
      ->where('role_id', Auth::user()->role_id)
      ->orderBy(Component::select('name')
      ->whereColumn('components.id', 'componentpermissions.componentid'))
      ->get();

        return $data;
    }

    public  function bread_crump_maker($breadcrump)
    {
        $bread_crump_data = "";
        if (isset($breadcrump) && !empty($breadcrump)) {
            if (is_array($breadcrump)) {
                foreach ($breadcrump as $crump) {
                    if (isset($crump['link']) && !empty($crump['link'])) {
                        $bread_crump_data = $bread_crump_data . '<li class="breadcrumb-item"><a href = "' . $crump['link'] . '">' . $crump['title'] . '</a></li>';
                    } else if (isset($crump['function']) && !empty($crump['function'])) {
                        $bread_crump_data = $bread_crump_data . '<li class="breadcrumb-item"><a href = "javascript:void(0);" onclick="' . $crump['function'] . '">' . $crump['title'] . '</a></li>';
                    } else {
                        $bread_crump_data = $bread_crump_data . '<li class="breadcrumb-item active">' . $crump['title'] . '</li>';
                    }
                }
            } else {
                $bread_crump_data = $breadcrump;
            }
        }
        return $bread_crump_data;
    }
    public function mobileNum_check()
    {

        $mobileNum = 'required|min:3|max:50|regex:/' . '^[0-9]{10}$' . '/';
        return $mobileNum;
    }
    public function rating_check()
    {

        $mobileNum = 'required|min:1|max:1|regex:/' . '^[0-5]{1}$' . '/';
        return $mobileNum;
    }
    public function mobileNum_check_sometimes()
    {

        $mobileNum = 'sometimes|nullable|min:3|max:50|regex:/' . '^[0-9]{10}$' . '/';
        return $mobileNum;
    }
    public function officenumber_check()
    {
        $mobileNum = 'required|min:3|max:150|regex:/' . '^[0-9-]{1,15}$' . '/';
        return $mobileNum;
    }
    public function age_check($age)
    {
        return $age;
    }
    public function dob_check($dob)
    {
        return $dob;
    }
    public function pan_check($pan)
    {
        return $pan;
    }
    public function aadhar_check($aadhar)
    {
        return $aadhar;
    }
    public function digit_check($digit)
    {
        return $digit;
    }
    public function emailId_check()
    {
        $emailId = 'required|min:3|max:50|regex:/' . '^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,50}$' . '/';
        return $emailId;
    }
    public function titletextEng_check($titletextEng)
    {
        return $titletextEng;
    }
    public function titletextareaEng_check($titletextareaEng)
    {
        return $titletextareaEng;
    }
    public function titletextMal_check($titletextMal)
    {
        return $titletextMal;
    }
    public function titletextareaMal_check($titletextareaMal)
    {
        return $titletextareaMal;
    }
    public function getsitesettingsval()
    {
        $sitesettreg = 'required|min:1|max:1|regex:/' . '^[0-1]+$' . '/';
        return $sitesettreg;
    }
    public function getEntitleregmin2()
    {
        $langtitle = array('required', 'min:2', 'max:200', 'not_regex:/[#$^=]|\.\.\//');
        return $langtitle;
    }
    public function keywordurl()
    {
        $urlreg = array('required', 'min:2', 'max:50');
  
        return $urlreg;
    }
    public function getEntitlereg_ckedit()
    {
        $langtitle = array('required', 'min:2', 'max:1000000', 'not_regex:/\.\.\//');
        return $langtitle;
    }
    
    public function NotgetEntitleregmin2()
    {
        $langtitle = array('sometimes', 'nullable', 'min:2', 'max:200', 'not_regex:/[#$^=]|\.\.\//');
        return $langtitle;
    }
    public function getEntitlereg()
    {
        $langtitle = array('required', 'min:3', 'max:200', 'not_regex:/[#$^=]|\.\.\//');
        return $langtitle;
    }


    public function getEntitleSearch()
    {
        $langtitle = array('min:2', 'max:50', 'sometimes', 'nullable' , 'not_regex:/[#$^=]|\.\.\/|http/');
        return $langtitle;
    }

    public function getSearchType()
    {
        $langtitle = array('min:2', 'max:200', 'sometimes', 'nullable' , 'not_regex:/[#$^=]|\.\.\/|http/');
        return $langtitle;
    }


    public function getEntitleregLink()
    {
        $langtitle = array('required', 'min:3', 'max:200', 'not_regex:/[#$^=]|\.\.\/|http/');
        return $langtitle;
    }

    public function getEntitleregfilm()
    {
        $langtitle = array('required', 'min:3', 'max:3000', 'not_regex:/[#$^=]|\.\.\//');
        return $langtitle;
        // $entitlereg = 'required|min:3|max:30000|regex:/' . '^[a-zA-Z0-9 \\@\\&\\`,\\:\\[\\]\\\\(\\)\\.\\_\\-\\"\\\'\/\s]+$' . '/';
        // return $entitlereg;
    }
    public function getEntitlereg250size_quiz()
    {
        $langtitle = array('required', 'min:1', 'max:1000', 'not_regex:/[#$^=]|\.\.\//');
        return $langtitle;
        // $entitlereg = 'required|min:3|max:50|regex:/' . '^[a-zA-Z0-9 \\@\\&\\`,\\(\\)\\.\\_\\-\\"\\\'\/\s]+$' . '/';
        // return $entitlereg;
    }
    public function getEncryptIdEntitleregsize()
    {
        $langtitle = array('required', 'min:1', 'max:2000', 'not_regex:/[#$^=]|\.\.\//');
        return $langtitle;
        // $entitlereg = 'required|min:3|max:50|regex:/' . '^[a-zA-Z0-9 \\@\\&\\`,\\(\\)\\.\\_\\-\\"\\\'\/\s]+$' . '/';
        // return $entitlereg;
    }
    public function getEntitlereg250size()
    {
        $langtitle = array('required', 'min:3', 'max:250', 'not_regex:/[#$^=]|\.\.\//');
        return $langtitle;
        // $entitlereg = 'required|min:3|max:50|regex:/' . '^[a-zA-Z0-9 \\@\\&\\`,\\(\\)\\.\\_\\-\\"\\\'\/\s]+$' . '/';
        // return $entitlereg;
    }
    public function getEntitlereg50size()
    {
        $langtitle = array('required', 'min:3', 'max:50', 'not_regex:/[#$^=]|\.\.\//');
        return $langtitle;
        // $entitlereg = 'required|min:3|max:50|regex:/' . '^[a-zA-Z0-9 \\@\\&\\`,\\(\\)\\.\\_\\-\\"\\\'\/\s]+$' . '/';
        // return $entitlereg;
    }
    public function getEntitlereg100size()
    {
        $langtitle = array('required', 'min:3', 'max:100', 'not_regex:/[#$^=]|\.\.\//');
        return $langtitle;
    }
    public function getAddressreg()
    {
        $langtitle = array('required', 'min:3', 'max:500', 'not_regex:/[#$^=]|\.\.\//');
        return $langtitle;
        // $addressreg = 'required|min:3|max:500|regex:/' . '^[a-zA-Z0-9 \\@\\&\\`,\\(\\)\\.\\_\\-\\"\\\'\/\s]{2,500}$' . '/';
        // return $addressreg;
    }
    public function getstringnotreqreg()
    {
        $addressreg = 'min:3|max:500|regex:/' . '^[a-zA-Z0-9 \s]+$' . '/';
        return $addressreg;
    }
    public function getEntitleregtxt()
    {
        $langtitle = array('required', 'min:3', 'max:2000', 'regex:/^(?![\!-\/@\'\"\,&_.])(?!.*[\!-\/@\'\"\,&_.]{2})(?!.*[-\/@\'\"\,&_.]$)[a-zA-Z0-9\!\.\_\-\/\s@\'\"\,&]+$/');
        return $langtitle;
        // $entitlereg = 'required|min:3|max:2000|regex:/' . '^[a-zA-Z0-9 \\@\\&\\`,\\(\\)\\.\\_\\-\\"\\\'\/\s]+$' . '/';
        // return $entitlereg;
    }
    public function getNotEntitleregtxt()
    {
        $langtitle = array('sometimes', 'nullable', 'min:3', 'max:2000', 'regex:/^(?![\!-\/@\'\"\,&_.])(?!.*[\!-\/@\'\"\,&_.]{2})(?!.*[-\/@\'\"\,&_.]$)[a-zA-Z0-9\!\.\_\-\/\s@\'\"\,&]+$/');
        return $langtitle;
        
    }
    public function getNotMaltitlereg()
    {
        $maltitlereg = array('sometimes', 'nullable', 'min:3', 'max:2000', 'not_regex:/[#$^=]|\.\.\//');
        return $maltitlereg;
    }
    public function getMaltitlereg()
    {
        $maltitlereg = array('required', 'min:3', 'max:2000', 'not_regex:/[#$^=]|\.\.\//');
        return $maltitlereg;
    }
    public function getMaltitlereg50size()
    {
        $maltitlereg = array('required', 'min:3', 'max:50', 'not_regex:/[#$^=]|\.\.\//');
        return $maltitlereg;
    }
    public function getMaltitlereg100size()
    {
        $maltitlereg = array('required', 'min:3', 'max:100', 'not_regex:/[#$^=]|\.\.\//');
        return $maltitlereg;
    }
    public function getMaltitleregtxt()
    {
        $maltitlereg = array('required', 'min:3', 'max:2000', 'not_regex:/[#$^=]|\.\.\//');
        return $maltitlereg;
    }
    public function getUpdateMaltitlereg()
    {
        $maltitlereg = array('sometimes', 'nullable', 'min:3', 'max:1000', 'not_regex:/[#$^=]|\.\.\//');
        return $maltitlereg;
    }
    public function getSumtitlereg()
    {
        $summernotereg = 'required|min:3|max:300000';
        return $summernotereg;
    }

    public function getEnSumtitlereg()
    {
        $summernotereg = array('required', 'min:3', 'max:10000', 'not_regex:/[#$^=]|\.\.\//');
        return $summernotereg;
    }
    public function getMalSumtitlereg()
    {
        $summernotereg = 'required|min:3|max:20000|not_regex:/[+%!*#~\=\[\]\^]|(\.\.\/\S)/';
        return $summernotereg;
    }

    public function getEnSumBriefreg()
    {
        $summernotereg = array('required', 'min:3', 'max:5000', 'not_regex:/[#$^=]/');
        return $summernotereg;
    }
    public function getMalSumBriefreg()
    {
        $summernotereg = array('required', 'min:3', 'max:10000', 'not_regex:/[#$^=]|\.\.\//');
        return $summernotereg;
    }

    public function getUpdateMalSumtitlereg()
    {
        $summernotereg = array('required', 'min:3', 'max:2000', 'not_regex:/[#$^=]|\.\.\//');
        return $summernotereg;
    }

    public function getNumsizedurareg()
    {
        $sizedurareg = 'required|min:3|max:10|regex:/' . '^[0-9. \s]+$' . '/';
        return $sizedurareg;
    }
    public function getMalKeywordreg()
    {
        $summernotereg = array('required', 'min:3', 'max:2000', 'not_regex:/[#$^=]|\.\.\//');
        return $summernotereg;
    }
    public function getEnKeywordreg()
    {
        $summernotereg = array('sometimes', 'nullable', 'min:3', 'max:20000', 'not_regex:/[#$^=]|\.\.\//');
        return $summernotereg;
    }
    public function getTimeDuraReg()
    {
        $sizedurareg = 'sometimes|min:3|max:10|regex:/' . '^[0-9. \s]+$' . '/';
        return $sizedurareg;
    }
    public function getTimeDuramin1Reg()
    {
        $sizedurareg = 'sometimes|min:1|max:10|regex:/' . '^[0-9. \s]+$' . '/';
        return $sizedurareg;
    }
    public function geturlslashonlyReg()
    {
        $urlreg = 'sometimes|nullable|min:3|max:100|regex:/' . '^[A-Za-z0-9\/\. \s]+$' . '/';
        return $urlreg;
    }
    public function getIconregtxt()
    {
        $langtitle = array('required', 'min:2', 'max:150', 'not_regex:/[#$^=]|\.\.\//');
        return $langtitle;
        // $entitlereg = 'required|min:3|max:150|regex:/' . '^[a-zA-Z0-9 \\@\\&\\`,\\(\\)\\.\\_\\-\\"\\\'\/\s]+$' . '/';
        // return $entitlereg;
    }
    public function getsomtimEntitleregtxt()
    {
        $langtitle = array('sometimes', 'nullable', 'min:1', 'max:300', 'not_regex:/[#$^=]|\.\.\//');
        return $langtitle;
        // $entitlereg = 'sometimes|nullable|min:3|max:300|regex:/' . '^[a-zA-Z0-9 \\@\\&\\`,\\(\\)\\.\\_\\-\\"\\\'\/\s]+$' . '/';
        // return $entitlereg;
    }
    public function getsomtimEntitleregtxt_trailer()
    {
        $langtitle = array('sometimes', 'nullable', 'min:3', 'max:200', 'not_regex:/[#$^=]|\.\.\//');
        // $langtitle = array('sometimes', 'nullable', 'min:1', 'max:20', 'not_regex:/[#$^=]|\.\.\//');
        return $langtitle;
        // $entitlereg = 'sometimes|nullable|min:3|max:300|regex:/' . '^[a-zA-Z0-9 \\@\\&\\`,\\(\\)\\.\\_\\-\\"\\\'\/\s]+$' . '/';
        // return $entitlereg;
    }
    public function NotshortCode()
    {
        $langtitle = array('sometimes','nullable', 'min:2', 'max:20', 'regex:/^[a-zA-Z0-9 \s]+$/');
        return $langtitle;
        // $entitlereg = 'required|min:3|max:10|regex:/' . '^[a-zA-Z0-9\\@\\&\\`,\\(\\)\\.\\_\\-\\"\\\']+$' . '/';
        // return $entitlereg;
    }
    public function shortCode()
    {
        $langtitle = array('required', 'min:2', 'max:20', 'regex:/^[a-zA-Z0-9 \s]+$/');
        return $langtitle;
        // $entitlereg = 'required|min:3|max:10|regex:/' . '^[a-zA-Z0-9\\@\\&\\`,\\(\\)\\.\\_\\-\\"\\\']+$' . '/';
        // return $entitlereg;
    }
    public function getdigitsonly()
    {
        $digitsonly = 'required|min:1|max:10|regex:/' . '^[0-9]+$' . '/';
        return $digitsonly;
    }
    public function encryptstring($string_id)
    {
        $encrypted = Crypt::encrypt($string_id);
        return $encrypted;
    }
    public function decryptstring($string_id)
    {
        $decrypted = Crypt::decrypt($string_id);
        return $decrypted;
    }
    public function urlcheck()
    {
        $urlstring = 'min:1|max:500|url';
        return $urlstring;
    }
    public function getIconClass()
    {
        $iconclassreg = 'required|min:2|max:150|regex:/' . '^[a-zA-Z0-9 \s\-]+$' . '/';
        return $iconclassreg;
    }
    public function getIconClass_notreq()
    {
        $iconclassreg = 'sometimes|nullable|min:2|max:50|regex:/' . '^[a-zA-Z \s\-]+$' . '/';
        return $iconclassreg;
    }
    public function getPath()
    {
        $path = array('required', 'min:3', 'max:100', "regex:/^[a-zA-Z\/]+$/");
        //'required|min:3|max:50|regex:/' . '^[a-zA-Z\/\]+$' . '/';
        return $path;
    }
    public function getdateddmmyyyy()
    {
        // dd("d");
        // $date = 'required|date';
        $date='required|date_format:d/m/Y|after_or_equal:'. '01/01/2020' ;
        //  $date = array('required', 'min:3', 'max:10', "regex:/^(0[1-9]|[12][0-9]|3[01])[- \\\/\.](0[1-9]|1[012])[- \\\/\.](19|20)\d\d$/");
        return $date;
        // '^(0[1-9]|[12][0-9]|3[01])[- \\\/\.](0[1-9]|1[012])[- \\\/\.](19|20)\d\d$'
    }
    public function Nogetdateddmmyyyy()
    {
        // dd("d");
        // $date = 'required|date';
        $date='sometimes|nullable|date_format:d/m/Y|after_or_equal:'. '01/01/2020' ;
        //  $date = array('required', 'min:3', 'max:10', "regex:/^(0[1-9]|[12][0-9]|3[01])[- \\\/\.](0[1-9]|1[012])[- \\\/\.](19|20)\d\d$/");
        return $date;
        // '^(0[1-9]|[12][0-9]|3[01])[- \\\/\.](0[1-9]|1[012])[- \\\/\.](19|20)\d\d$'
    }

    public function Nogetdateddmmyyyy1()
    {
        // dd("d");
        // $date = 'required|date';
        $date='sometimes|nullable|date_format:d-m-Y|after_or_equal:'. '01/01/2020' ;
        //  $date = array('required', 'min:3', 'max:10', "regex:/^(0[1-9]|[12][0-9]|3[01])[- \\\/\.](0[1-9]|1[012])[- \\\/\.](19|20)\d\d$/");
        return $date;
        // '^(0[1-9]|[12][0-9]|3[01])[- \\\/\.](0[1-9]|1[012])[- \\\/\.](19|20)\d\d$'
    }
    public function getdate_fest()
    {
        //, 'regex:/^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/'
        // $date = array('required', 'min:3', 'max:10','after_or_equal:01-01-2020');
        // return $date;
        $date='required|date_format:d/m/Y|after_or_equal:'. '01/01/2020' ;
        //  $date = array('required', 'min:3', 'max:10', "regex:/^(0[1-9]|[12][0-9]|3[01])[- \\\/\.](0[1-9]|1[012])[- \\\/\.](19|20)\d\d$/");
        return $date;
        // $date = 'required|min:3|max:10|regex:/' . '^(19|20)\[0-9]{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$' . '/';
        // return $date;
    }
    public function getNotdate_fest()
    {
      
        $date='sometimes|nullable|date_format:d/m/Y|after_or_equal:'. '01/01/2020' ;       
        return $date;
       
    }
    public function getNotdate_archivefest()
    {
      
        $date='sometimes|nullable|date_format:d/m/Y|after_or_equal:'. '01-01-1996' ;       
        return $date;
       
    }
    public function getdate()
    {
        //, 'regex:/^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/'
        // $date = array('required', 'min:3', 'max:10','after_or_equal:01-01-2020');
        // return $date;
        $date='required|date_format:d/m/Y|after_or_equal:'. '01/01/2020' ;

        //  $date = array('required', 'min:3', 'max:10', "regex:/^(0[1-9]|[12][0-9]|3[01])[- \\\/\.](0[1-9]|1[012])[- \\\/\.](19|20)\d\d$/");
        return $date;
        // $date = 'required|min:3|max:10|regex:/' . '^(19|20)\[0-9]{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$' . '/';
        // return $date;
    }
    public function getpassword()
    {
        // At least 1 alphabet

        // At least 1 digit

        // Contains no space

        // Optional special characters e.g. @$!%*#?&^_-

        // Minimum 8 characters long
        $pass = array('required', 'min:8', 'max:50', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&^_-]{8,}$/');
        // $path = 'required|min:8|max:50|regex:/' . '^[a-zA-Z0-9-@#_. \s]{8,50}+$' . '/';
        return $pass;
    }
    public function get_pass_val()
    {
        //min:6|required_with:cnfpassword|same:cnfpassword
        $pass = array('required', 'min:6', 'max:50', 'required_with:cnfpassword', 'same:cnfpassword', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&^_-]{8,}$/');
        // $path = 'required|min:8|max:50|regex:/' . '^[a-zA-Z0-9-@#_. \s]{8,50}+$' . '/';
        return $pass;
    }
    public function get_confrm_pass_val()
    {
        //min:6|required_with:cnfpassword|same:cnfpassword
        $pass = array('required', 'min:6', 'max:50', 'required_with:password', 'same:password', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&^_-]{8,}$/');
        // $path = 'required|min:8|max:50|regex:/' . '^[a-zA-Z0-9-@#_. \s]{8,50}+$' . '/';
        return $pass;
    }
    public function get_not_req_pass_val()
    {
        //min:6|required_with:cnfpassword|same:cnfpassword
        $pass = array('sometimes', 'nullable', 'min:6', 'max:50', 'required_with:cnfpassword', 'same:cnfpassword', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&^_-]{8,}$/');
        // $path = 'required|min:8|max:50|regex:/' . '^[a-zA-Z0-9-@#_. \s]{8,50}+$' . '/';
        return $pass;
    }
    public function get_not_req_confrm_pass_val()
    {
        //min:6|required_with:cnfpassword|same:cnfpassword
        $pass = array('sometimes', 'nullable', 'min:6', 'max:50', 'required_with:password', 'same:password', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&^_-]{8,}$/');
        // $path = 'required|min:8|max:50|regex:/' . '^[a-zA-Z0-9-@#_. \s]{8,50}+$' . '/';
        return $pass;
    }
    public function getsel2valreq()
    {
        $digit='required|min:1|max:20|regex:/^[0-9]{1,20}$/' ;
        // $digit = array('required', 'min:1', 'max:20', 'regex:/^[0-9]{1,20}$/');
        return $digit;
    }
    public function getsel2valreqYr()
    {
        $digit = array('required', 'min:1', 'max:20', 'regex:/^[0-9]{1,20}$/');
        return $digit;
    }
    public function getNotsel2valreqYr()
    {
        $digit = array('sometimes','nullable', 'min:1', 'max:20', 'regex:/^[0-9]{1,20}$/');
        return $digit;
    }
    public function getsel2valreqFesttype()
    {
        $digit = array('required', 'min:1', 'max:20', 'regex:/^[0-9]{1,20}$/');
        return $digit;
    }
    public function getsel2valNotreq()
    {
        $digit = array('sometimes', 'nullable', 'min:1', 'max:20', 'regex:/^[0-9]{1,20}$/');
        return $digit;
    }
    public function passwordmatch($pass, $confirm)
    {
        if ($pass == $confirm) {
            return true;
        } else {
            return false;
        }
    }
    public function getname()
    {
        $path = 'required|min:8|max:50|regex:/' . '^[a-zA-Z .\s]+$' . '/';
        return $path;
    }
    public function getusername()
    {
        $path = 'required|min:8|max:50|regex:/' . '^[a-zA-Z -_.\s]{8,50}+$' . '/';
        return $path;
    }
    public function getseat()
    {
        $digitsonly = 'required|min:1|max:3|regex:/' . '^[0-9]{1,3}+$' . '/';
        return $digitsonly;
    }
    public function alpha_comma_space()
    {
        $string = 'required|min:3|max:500|regex:/' . '^[a-zA-Z0-9 ,\s]+$' . '/';
        return $string;
    }
    public function tablenameval()
    {
        $digit = array('required', 'min:1', 'max:50', 'regex:/^[a-zA-Z0-9_]+$/');
        return $digit;
    }
    public function Notalpha_comma_space()
    {
        $string = 'sometimes|nullable|min:3|max:500|regex:/' . '^[a-zA-Z0-9 ,\s]+$' . '/';
        return $string;
    }
    public function getImageLTAval()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png';
        return $img;
    }
    public function getImage_mainslider_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=1280,height=512';
        return $img;
    }
    public function getImage_mainslider_val_sbu()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=1920,height=400';
        return $img;
    }

    public function getImage_banner_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=1050,height=250';
        return $img;
    }
    public function getImage_festivalaward_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=300,height=300';
        return $img;
    }
    public function getImage_film_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=900,height=900';
        return $img;
    }
    public function getImage_mediaalert_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=750,height=400';
        return $img;
    }
    public function getImage_dailybulletin_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=400,height=300';
        return $img;
    }
    public function getImage_galleryposter_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=300,height=600';
        return $img;
    }
    public function generation()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=300,height=300';
        return $img;
    }
    public function article_imgae_upload()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=960,height=960';
        return $img;
    }
    public function getImageNot_galleryposter_quiz()
    {
        $img = 'nullable|mimes:webp,jpg,jpeg,png,mp3,mp4';
        return $img;
    }public function getImageNot_galleryposter_ansimg()
    {
        $img = 'nullable|mimes:webp,jpg,jpeg,png,mp3,mp4';
        return $img;
    }
    public function getImageNot_galleryposter_val()
    {
        $img = 'nullable|mimes:webp,jpg,jpeg,png|dimensions:width=300,height=600';
        return $img;
    }
    public function getImageNot_sbuposter_val()
    {
        $img = 'required|mimes:webp,jpg,jpeg,png,gif|dimensions:width=640,height=640';
        return $img;
    }
    public function main_background_img()
    {
     
        $img = 'required|mimes:webp,jpg,jpeg,png,gif,application/octet-stream|dimensions:width=1920,height=440';
        return $img;
    }
    public function getImageNot_sbuposter_edit_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png,gif|dimensions:width=640,height=640';
        return $img;
    }
    public function getImage_jury_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=150,height=150';
        return $img;
    }
    public function getImage_programs_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=900,height=600';
        return $img;
    }
    public function getImage_other_logo_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=115,height=80';
        return $img;
    }
    public function getImage_officers_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=300,height=300';
        return $img;
    }
    public function getImage_award_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=800,height=600';
        return $img;
    }
    public function getImage_AML_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=150,height=150';
        return $img;
    }
    public function getImage_AML2_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=150,height=150';
        return $img;
    }
    public function getImage_Gallery_item_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=400,height=400';
        return $img;
    }
    public function getImage_venue_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=300,height=300';
        return $img;
    }
    public function getImage_Size_type_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|max:1024';
        return $img;
    }
    public function getImage_200x100_val()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:width=200,height=100';
        return $img;
    }
    public function getImageval()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:max_width=500,max_height=500';
        return $img;
    }
    public function getImageAllval()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png,pdf,docx,doc,application/pdf|max:500000';
        return $img;
    }
    public function getmedia_Imageval()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:max_width=700,max_height<=500';
        return $img;
    }
    public function getImageGifval()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png,gif|dimensions:max_width=500,max_height=500';
        return $img;
    }
    public function getImageGifval_img()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png,gif';
        return $img;
    }
    public function getImageminmax()
    {
        $img = 'sometimes|nullable|mimes:webp,jpg,jpeg,png|dimensions:min_width<=100,min_height<=100|dimensions:max_width<=2000,max_height<=1100';
        return $img;
    }
    public function getFileval()
    {
        $img = 'sometimes|nullable|mimes:webp,pdf,docx,doc,application/pdf';
        return $img;
    }
    public function ckeditorupload()
    {
        // dd(true);
        $img = 'required|mimes:webp,jpg,jpeg,png';
        return $img;
    }
    public function get_Color_hex_codeval()
    {
        $color = array('sometimes', 'nullable', 'min:3', 'max:7', 'regex:/^#{1}([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/');
        return $color;
    }
    public function get_validateYouTubeUrl()
    {
        $color = array('required', 'min:2', 'max:100', 'regex:/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/');
        return $color;
    }

    public function urlencrypt($string)
    {
        $id = (float)$string * 525325.24;
        return base64_encode($id);
    }

    public function urldecrypt($string)
    {
        $url_id = base64_decode($string);
        $id = (float)$url_id / 525325.24;
        return $id;
    }
    public function get_ckeditor_val_req_sometyms()
    {
        //to check 'not_regex:/(?:..\/)+/'
        //tags stripped at XSS -> kernal. Here only validation , 'not_regex:/[*#~\^]+|(\.\.\/\S)/'
        $ckval =  array('sometimes', 'min:3', 'max:10000', 'not_regex:/[#$^=]|\.\.\//');
        return $ckval;
    }
    public function get_ckeditor_val_req()
    {
        //to check 'not_regex:/(?:..\/)+/'
        //tags stripped at XSS -> kernal. Here only validation , 'not_regex:/[*#~\^]+|(\.\.\/\S)/'
        $ckval =  array('required', 'min:3', 'max:10000', 'not_regex:/[#$^=]|\.\.\//');
        return $ckval;
    }
    /*public function get_ckeditor_val_not_req()
    {
        $ckval = array('sometimes', 'nullable', 'min:3', 'max:3000', 'not_regex:/[#$^]|\.\.\//');
        //ckval stripped at XSS -> kernal. Here only validation
        // $ckval = array('required', 'min:3', 'max:2000', 'not_regex:/[#$^]|\.\.\//');
        return $ckval;
    }*/
    //anchor tag <a.*(?=href=\"([^\"]*)\")[^>]*>([^\s+]+|[^\S+]+|\w*)<\/a>|<a.*(?=name=\"([^\"]*)\")[^>]*>(\s*\S+.*)<\/a>
    public function get_anchor_val_req()
    {
        //tags stripped at XSS -> kernal. Here only validation

        $ancval = array('required', 'min:1', 'max:500', 'regex:/^[a-zA-Z0-9\s#]+$/');
        return $ancval;
    }
    public function get_anchor_val_not_req()
    {
        //tags stripped at XSS -> kernal. Here only validation

        $ancval = array('sometimes', 'nullable', 'min:1', 'max:500', 'regex:/^[a-zA-Z0-9\s#]+$/');
        return $ancval;
    }
    public function get_engtitle_awards_req()
    {
        //tags stripped at XSS -> kernal. Here only validation 'regex:/^[a-zA-Z0-9 :\-\s]+$/'
        $ancval = array('required', 'min:3', 'max:500', 'not_regex:/[#$^=]|\.\.\//');
        return $ancval;
    }
    public function random_strings($length_of_string)
    {

        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shuffle the $str_result and returns substring
        // of specified length
        return substr(
            str_shuffle($str_result),
            0,
            $length_of_string
        );
    }
    public function get_duration_check(){
        //^([0-1]?[0-9]?[0-9]|3[0-3]):[0-9][0-9]$
        $duration = array('required', 'min:5', 'max:6', 'regex:/^([0-1]?[0-9]?[0-9]|3[0-3]):[0-9][0-9]$/');
        return $duration;
    }
    public function getsel2valreqFilm_id()
    {
        $digit = array('sometimes', 'nullable', 'min:1', 'max:20', 'regex:/^[0-9]{1,20}$/');
        return $digit;
    }
    public function get_film_name()
    {
        $ancval = array('sometimes', 'nullable', 'min:3', 'max:500', 'not_regex:/[#$^=]|\.\.\//');
        return $ancval;
    }
    public function getEntitleNotreg()
    {
        $langtitle = array('sometimes', 'nullable', 'min:3', 'max:200', 'not_regex:/[#$^=]|\.\.\//');
        return $langtitle;
    }
    public function get_ckeditor_val_not_req()
    {
    
        $ckval =  array('sometimes', 'nullable', 'min:3', 'max:10000', 'not_regex:/[#$^=]|\.\.\//');
        return $ckval;
    }

    /*public function getsel2valNotreq()
    {
        $digit = array('sometimes', 'nullable', 'min:1', 'max:20', 'regex:/^[0-9]{1,20}$/');
        return $digit;
    }*/

    public function getdateddmmyyyyNotReg()
    {
       
        $date='sometimes|nullable|date_format:d/m/Y|after_or_equal:'. '01-01-1996' ;
      
        return $date;
    }
    public function getEcryptedString()
    {
        $langtitle = array('sometimes','nullable','min:3','max:5000', 'not_regex:/[#$^=]|\.\.\//');
        return $langtitle;
      
    }

    public function mainslideratta()
    {
        $img = 'sometimes|nullable|mimes:pdf,application/pdf';
        return $img;
    }
    public function mainslideruploadposter()
    {
        $img = 'required|mimes:mp4,webp,jpg,jpeg,png';
        return $img;
    }
}