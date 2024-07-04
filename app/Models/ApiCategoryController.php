<?php

namespace App\Http\Controllers;

use App\Category;
use App\Video;
use App\Question;
use App\Answer;
use App\Answerlog;
use App\Volunteer;
use App\District;
use App\Volunteervideo;
use App\User;
use App\Answerhistory;
use App\Event;
use App\Eventparticipation;
use App\Level;
use App\Liveevent;
use App\Liveeventparticipation;
use App\Notifytype;
use App\Notification;
use App\Survey;
use App\Surveyquestion;
use App\Surveyoption;
use App\Surveyanswer;
use App\SkillCategory;
use App\SkillVolunteerRelations;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;
use BigBlueButton\Parameters\CreateMeetingParameters;
use Illuminate\Support\Facades\Hash;

use DataTables;
use Validator;
use DB;
use Auth;
use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Mail;
use Storage;
use Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Crypt;

class ApiCategoryController extends Controller
{
    public function getCategories() {
        $categories = Category::get()->toJson(JSON_PRETTY_PRINT); //no need of prettyprint when response is json
      return response($categories, 200);
    }

    public function getVideos() {
        $videos = DB::table('videos')
        ->join('categories','categories.id','videos.categories_id')
        ->select('videos.id','videos.file','categories.name as category')
        ->get()->toJson(JSON_PRETTY_PRINT);
      return response($videos, 200);
    }

    public function getAnswers() {
        $listdata = DB::table('categories')
        ->join('videos','categories.id','videos.categories_id')
        ->join('questions','videos.id','questions.videos_id')
        ->join('answers','questions.id','answers.questions_id')
        ->select('videos.id','videos.file','categories.name as category','questions.name as question','answers.name as answers')
        ->get()->toJson(JSON_PRETTY_PRINT);
      return response($listdata, 200);
    }

    public function getQuesanswers() {
      $display = array();
      $video_res = 5;
      $questions = Question::where('videos_id','=',$video_res)->get();
        foreach($questions as $ques_res){
          $answers = Answer::where('questions_id','=',$ques_res->id)->get();
          $display[] = array('question' => $ques_res->name , 'answers' => $answers);
        }
        return response()->json(['catg' => $display, 200]);
    }

    public function getvideoanswers() {
      $videoarray = array();
      $category = 1;

      $videos = Video::where('categories_id','=',$category)->get();
      foreach($videos as $video_res){
        $questions = Question::where('videos_id','=',$video_res->id)->get();
        $answerarray = array();
        foreach($questions as $ques_res){
          $answers = Answer::where('questions_id','=',$ques_res->id)->select('id','name')->get();
          $answerarray[] = array('question_id' => $ques_res->id,'question_name' => $ques_res->name, 'options' => $answers);
        }
        $videoarray [] = array('videofile' => $video_res->file,'video_id' => $video_res->id, 'questions' =>  $answerarray);
      }

    return response()->json(['list' => $videoarray, 200]);
    }

    public function getanswerlog() {

    $videoarray = array();
    $volunteer = 7;

    $watchedvideo = Answerhistory::where('volunteers_id','=',$volunteer)->get();
    $qstnarray = array();
    foreach($watchedvideo as $watchedvideos)
    {
        $videosdetail = Video::whereId($watchedvideos->videos_id)->get();
        foreach($videosdetail as $videosdetails)
        {
          $question = Question::where('videos_id','=',$videosdetails->id)->get();
          $answerarray = array();

          foreach ($question as $questions)
          {
            $answerlog = Answerlog::where('questions_id','=',$questions->id)->where('volunteers_id','=',$volunteer)->first();
            $correctanswer = Answer::where('questions_id','=',$questions->id)->where('iscorrect','=',1)->first();
            $voluntranswer = Answer::where('id','=',$answerlog->answers_id)->first();
            $answerarray[] = array('question_id' => $questions->id, 'question_name' => $questions->name,'curanswer' => $correctanswer->name, 'volanswer' => $voluntranswer->name);
          }
          $qstnarray[] = array('videofile' => $videosdetails->file, 'videoid' => $videosdetails->id,'videoname' => $videosdetails->name, 'answers' => $answerarray);
        }
    }
    return response()->json(['list' => $qstnarray, 200]);
    }

    public function getvideolog() {

      $answerarray = array();
      $videoarray = array();
      $qstnarray = array();

      $volunteer = 7;
      $videoarg =11;

      $videosdetail = Video::whereId($videoarg)->first();

      $question = Question::where('videos_id','=',$videosdetail->id)->get();
      foreach ($question as $questions)
      {
        $answerlog = Answerlog::where('questions_id','=',$questions->id)->where('volunteers_id','=',$volunteer)->first();
        $correctanswer = Answer::where('questions_id','=',$questions->id)->where('iscorrect','=',1)->first();
        $voluntranswer = Answer::where('id','=',$answerlog->answers_id)->first();
        $answerarray[] = array('question_id' => $questions->id, 'question_name' => $questions->name,'curanswer' => $correctanswer->name, 'volanswer' => $voluntranswer->name);
      }
      $qstnarray[] = array('videofile' => $videosdetail->file, 'videoid' => $videosdetail->id,'videoname' => $videosdetail->name, 'answers' => $answerarray);

      return response()->json(['list' => $qstnarray, 200]);
    }

    public function getvideologarg($volid, $vid) {

      $answerarray = array();
      $videoarray = array();
      $qstnarray = array();

      $volunteer = $volid;
      $videoarg = $vid;

      $videosdetail = Video::whereId($videoarg)->first();

      $question = Question::where('videos_id','=',$videosdetail->id)->get();
      foreach ($question as $questions)
      {
        $answerlog = Answerlog::where('questions_id','=',$questions->id)->where('volunteers_id','=',$volunteer)->first();
        $correctanswer = Answer::where('questions_id','=',$questions->id)->where('iscorrect','=',1)->first();
        $voluntranswer = Answer::where('id','=',$answerlog->answers_id)->first();
        $answerarray[] = array('question_id' => $questions->id, 'question_name' => $questions->name,'curanswer' => $correctanswer->name, 'volanswer' => $voluntranswer->name);
      }
      $qstnarray[] = array('videofile' => $videosdetail->file, 'videoid' => $videosdetail->id,'videoname' => $videosdetail->name, 'answers' => $answerarray);

      return response()->json(['list' => $qstnarray, 200]);
    }

    public function getanswerlogarg($volid) {

    $videoarray = array();
    $volunteer = $volid;

    $watchedvideo = Answerhistory::where('volunteers_id','=',$volunteer)->get();
    $qstnarray = array();
    foreach($watchedvideo as $watchedvideos)
    {
        $videosdetail = Video::whereId($watchedvideos->videos_id)->get();
        foreach($videosdetail as $videosdetails)
        {
          $question = Question::where('videos_id','=',$videosdetails->id)->get();
          $answerarray = array();

          foreach ($question as $questions)
          {
            $answerlog = Answerlog::where('questions_id','=',$questions->id)->where('volunteers_id','=',$volunteer)->first();
            $correctanswer = Answer::where('questions_id','=',$questions->id)->where('iscorrect','=',1)->first();
            $voluntranswer = Answer::where('id','=',$answerlog->answers_id)->first();
            $answerarray[] = array('question_id' => $questions->id, 'question_name' => $questions->name,'curanswer' => $correctanswer->name, 'volanswer' => $voluntranswer->name);
          }
          $qstnarray[] = array('videofile' => $videosdetails->file, 'videoid' => $videosdetails->id,'videoname' => $videosdetails->name, 'answers' => $answerarray);
        }
    }
    return response()->json(['list' => $qstnarray, 200]);
    }

    public function getvideoanswersarg($volid) {

      $videoarray = array();
      $vol = Volunteer::where('uid','=',$volid)->first();
      $category = $vol->categories_id;

      $videos = Video::where('categories_id','=',$category)->get();
      foreach($videos as $video_res){
        $questions = Question::where('videos_id','=',$video_res->id)->get();
        $answerarray = array();
        foreach($questions as $ques_res){
          $answers = Answer::where('questions_id','=',$ques_res->id)->select('id','name')->get();
          $answerarray[] = array('question_id' => $ques_res->id,'question_name' => $ques_res->name, 'options' => $answers);
        }
        $videoarray [] = array('videofile' => $video_res->file,'video_id' => $video_res->id, 'questions' =>  $answerarray);
      }
    }

    public function getotp($no,Request $request)
    {
      $msg_send=0;

        $checkvolunteerexist = Volunteer::where('mobile',$no)->where('status',1)->exists() ? 1 : 0;
       
        if($checkvolunteerexist==1){
          $volunterIdPick = Volunteer::where('mobile',$no)->where('status',1)->first();
          // Encrypting the ID
                  // Hash the string (to get a fixed length)
          $hashedString = hash('sha256', $volunterIdPick->id);

          // Take the first 10 characters of the hashed string
          $limitedHashedString = substr($hashedString, 0, 10);

          $encryptedtoken = $this->encrptt_fun($limitedHashedString);
          //for google checking - updated on 14-06-2024
          if($no == 7736205554)
          {
            $otp =  1234;
            $otptimestamp = Carbon::now();
                      $form_data = array(
                          'otp'          => $otp,
                          'otptimestamp' => $otptimestamp,
                          'token_api'    => $encryptedtoken,
                      );
                      
                      Volunteer::where('mobile',$no)->update($form_data);
                      
            $message = "Volunteer registration OTP for SSSena Sannadhasena Portal is ".$otp;
                        $number = $no;
                        // dd($number);
                        // $number = 9567420761;
                        $link = curl_init();
                        curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=sannadham-portal&password=Sann@1234&message=".$message."&numbers=".$number."&senderid=SSSENA");
                        curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($link , CURLOPT_HEADER, 0);
                        curl_exec($link);
                        curl_close($link );

                      if($link)
                      {
                        $msg_send=1;
                      }else{
                        $msg_send=0;
                      }
                      return response()->json(['otp' => $otp,'msg_send'=> $msg_send,'token_api'=>$encryptedtoken, 200]);
          }else{
                  //end  google checking


                      $otp =  app('App\Http\Controllers\BaseController')->generateotp();
                      // $token = Str::random(60); // Generate a random token

                      $otptimestamp = Carbon::now();
                      $form_data = array(
                          'otp'          => $otp,
                          'otptimestamp' => $otptimestamp,
                          'token_api'    => $encryptedtoken,
                      );
                      
                      Volunteer::where('mobile',$no)->update($form_data);

                        /* -------------------------------------------- Send Custom SMS (start) --------------------------------- */
                        $message = "Volunteer registration OTP for SSSena Sannadhasena Portal is ".$otp;
                        $number = $no;
                        // dd($number);
                        // $number = 9567420761;
                        $link = curl_init();
                        curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=sannadham-portal&password=Sann@1234&message=".$message."&numbers=".$number."&senderid=SSSENA");
                        curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($link , CURLOPT_HEADER, 0);
                        curl_exec($link);
                        curl_close($link );

                      if($link)
                      {
                        $msg_send=1;
                      }else{
                        $msg_send=0;
                      }
                  /* -------------------------------------------- Send Custom SMS (end) --------------------------------- */

                      return response()->json(['otp' => $otp,'msg_send'=> $msg_send,'token_api'=>$encryptedtoken, 200]);
          }
          
        }else {
      
          $otp =  app('App\Http\Controllers\BaseController')->generateotp();
          
                // $otp =  123;
                $otptimestamp = Carbon::now();
   
                /* -------------------------------------------- Send Custom SMS (start) --------------------------------- */
                $message = "Volunteer registration OTP for SSSena Sannadhasena Portal is ".$otp;
                $number = $no;
                $link = curl_init();
                curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=sannadham-portal&password=Sann@1234&message=".$message."&numbers=".$number."&senderid=SSSENA");
                curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($link , CURLOPT_HEADER, 0);
                curl_exec($link);
                curl_close($link );
    
         /* -------------------------------------------- Send Custom SMS (end) --------------------------------- */
                return response()->json(['otp' => $otp,'msg_send'=> $msg_send, 200]);
            // return response()->json(['otp' => '0','msg_send'=> $msg_send, 200]);
        }

    }

    public function getlogincheck($no,$otp)
    {
      $volunteersid = Volunteer::where('mobile',$no)->first();


        $checkvolunteerexist = Volunteer::where('mobile', $no)->where('status',1)->exists() ? 1 : 0;
       
        if ($checkvolunteerexist == 1) {
            $checkotpexist = Volunteer::where('mobile', $no)->where('otp',$otp)->where('status',1)->exists() ? 1 : 0;
          
            
            if($checkotpexist == 1)
             {

              $specialflagexist = Category::where('specialflag', 1)->exists() ? 1 : 0 ;
            if($specialflagexist==1){
                $categories = Category::where('specialflag', 1)->get();
            } else{
                $specialflag = array();
            }

           
            if(isset($volunteersid->photograph)){
              $userphoto    = $volunteersid->photograph;
              $path=public_path().'/profile/'.$userphoto;
              $userphotoencode    = file_get_contents($path);
              $base64dataphoto=base64_encode($userphotoencode);
            }else{
              $base64dataphoto='No image added';
            }
          
           
            $dobyear = Carbon::parse($volunteersid->dob)->year;
            $SocialCredits = $volunteersid->SocialCredits;
            $now = Carbon::now();
            $criteria = $now->year-$dobyear;
             
            if($criteria >= 20 && $criteria <=40)
              {
                $surveyexist = Survey::where('status',1)->exists() ? 1 : 0;
                if($surveyexist==1){
                    $surveyflag = Survey::where('status',1)->get();
                } else{
                    $surveyflag = array();
                }
              }
              else
                $surveyflag = array();
            $name = $volunteersid->firstname." ".$volunteersid->lastname;
               
                return response()->json(['specialflag' => $categories,'base64datauserphoto'=>$base64dataphoto,'SocialCredits' =>$SocialCredits, 'surveyflag' => $surveyflag , 'name' => $name,'volunteersid' =>$volunteersid,  200]);
             }
             else {
                return response()->json(['specialflag' =>'2',  200]); //invalid otp
             }

        } else {
            return response()->json(['specialflag' => '0', 200]); //invalid user
        }
    }

    public function SocialCreditUpdate(Request $request,$id){

            $request->validate([
              'SocialCredits' => 'required',
            ]);
        try {
          DB::beginTransaction();
              $SocialCredits = $request->SocialCredits;
              $volidd = Volunteer::where('mobile', $id)->first(); 

              $TokenRecvd =$request->token_api;
              $encryptedtoken = $volidd->token_api;
           
              if($encryptedtoken == $TokenRecvd)
              {
                $formdata = array('SocialCredits' => $SocialCredits);
             
              $userdata = Volunteer::where('mobile',$id)
                                   ->update($formdata);
                                
   
              if($userdata){
    
              DB::commit();
              $message = "Volunter details updated Sucessfully";
      
              return response()->json(['message' => $message,  200]);
           } else {
            DB::rollback();
            return response()->json(['error'=>'Not updated.error found']);
           }

              }else{
                return response()->json(['error' => 'Unauthorized'], 401);
              }              }catch (\Exception $e) {
                DB::rollback();
                return response()->json(['error'=>'Not updated.error found']);
          // something went wrong
          }
              
    
  }

  public function fireBaseId(Request $request,$id){

    $request->validate([
      'fireBaseId' => 'required',
      'token_api'  => 'required',
    ]);

    $listdata = Volunteer::where('mobile',$id)->first();
    $TokenRecvd =$request->token_api;
    $encryptedtoken = $listdata->token_api;

    if($encryptedtoken == $TokenRecvd){
    try {
      DB::beginTransaction();
          $fireBaseId = $request->fireBaseId;
          $formdata = array('fireBaseId' => $fireBaseId);
        
          $userdata = Volunteer::where('mobile',$id)
                              ->update($formdata);
                            

          if($userdata){

          DB::commit();
          $message = "Volunter details updated Sucessfully";

          return response()->json(['message' => $message,  200]);
      } else {
        DB::rollback();
        return response()->json(['error'=>'Not updated.error found1']);
      }
    }catch (\Exception $e) {
      DB::rollback();
      return response()->json(['error'=>'Not updated.error found2']);
    // something went wrong
    }
  }else{
    return response()->json(['error' => 'Unauthorized'], 401);

  }

}

    public function getspecialvideo($no,$cid){
        $videoexist = Video::where('categories_id', '=', $cid)->exists() ? 1 : 0;
        $categoryval = Category::whereId($cid)->first();
        $volunteerval = Volunteer::where('mobile',$no)->first(); // 7 for insertion volunteer->id
        $volunteers_id = $volunteerval->uid;
        if ($videoexist == 1) {
            $totalvideo = Video::where('categories_id', '=', $cid)->count();
            $answerhisexists = Answerhistory::where('categories_id', '=', $cid)->where('volunteers_id', '=', $volunteers_id)->exists() ? 1 : 0;
            if ($answerhisexists == 1) {
                $answerhiscount = Answerhistory::where('categories_id', '=', $cid)->where('volunteers_id','=',$volunteers_id)->count();
                $nextvideocnt = $answerhiscount + 1;
                $answerhis = Answerhistory::where('categories_id', '=', $cid)->where('volunteers_id', '=', $volunteers_id)->latest()->first();
                $videoorder = Video::whereId($answerhis->videos_id)->first();
                $videovalexist =  Video::where('categories_id', '=', $cid)->where('order', '>', $videoorder->order)->exists() ? 1 : 0;
                if ($videovalexist == 1) {
                    $videoval = Video::where('categories_id', '=', $cid)->where('order', '>', $videoorder->order)->orderBy('order', 'asc')->first();
                    return response()->json(['videoval' => $videoval, 'totalvideo' => $totalvideo, 'nextvideo' => $nextvideocnt,  200]); //next video in this category
                } else {
                    $videoval = array();
                    return response()->json(['videoval' => '1',  200]); //No more videos
                }
            } else {
                $nextvideocnt = 0;
                $videoval = Video::where('categories_id', '=', $cid)->orderBy('order', 'asc')->first();
                return response()->json(['videoval' => $videoval, 'totalvideo' => $totalvideo, 'nextvideo' => $nextvideocnt,  200]); //first video in this category
            }
        } else {
            $nextvideocnt = 0;
            $totalvideo = 0;
            $videoval = array();
            return response()->json(['videoval' => '2',  200]);//No Video exists for this category
        }
    }

    public function getnextspecialvideo($no,$id){
        $videoval = Video::whereId($id)->first();
        $volunteerval = Volunteer::where('mobile', $no)->first(); // 7 for insertion volunteer->id
        $volunteers_id = $volunteerval->uid;

        $form_data2 = array(
            'volunteers_id'    =>  $volunteers_id,
            'categories_id' => $videoval->categories_id,
            'videos_id' => $id
        );
        
        Answerhistory::firstOrCreate($form_data2);
        $totalvideo = Video::where('categories_id', '=', $videoval->categories_id)->count();
        $answerhiscount = Answerhistory::where('categories_id', '=', $videoval->categories_id)->where('volunteers_id','=',$volunteers_id)->count();
        $nextvideocnt = $answerhiscount + 1;
        $lastvideo = Volunteervideo::where([['categories_id', $videoval->categories_id], ['volunteers_id', $volunteers_id]])->exists() ? 1 : 0;

        if ($lastvideo == 0) {
            $form_data1 = array(
                'volunteers_id'    =>  $volunteers_id,
                'categories_id' => $videoval->categories_id,
                'currentvideo' => $id
            );
            $form_data = Volunteervideo::firstOrCreate($form_data1);
            Volunteervideo::whereId($form_data->id)->increment('totalvideos', 1);

            $videovalexist =  Video::where('categories_id', '=', $videoval->categories_id)->where('order', '>', $videoval->order)->exists() ? 1 : 0;
            if ($videovalexist == 1) {
                $videovalue = Video::where('categories_id', '=', $videoval->categories_id)->where('order', '>', $videoval->order)->orderBy('order', 'asc')->first();
                return response()->json(['videoval' => $videovalue, 'totalvideo' => $totalvideo, 'nextvideo' => $nextvideocnt,  200]); //next video in this category
            } else {
                $videovalue = array();
                return response()->json(['videoval' => '1',  200]); //No more videos
            }
        } else {
            Volunteervideo::where('volunteers_id', $volunteers_id)
                ->where('categories_id', $videoval->categories_id)
                ->update(['currentvideo' => $id]);

            Volunteervideo::where('volunteers_id', $volunteers_id)
                ->where('categories_id', $videoval->categories_id)
                ->increment('totalvideos', 1);

            $videovalexist =  Video::where('categories_id', '=', $videoval->categories_id)->where('order', '>', $videoval->order)->exists() ? 1 : 0;
            if ($videovalexist == 1) {
                $videovalue = Video::where('categories_id', '=', $videoval->categories_id)->where('order', '>', $videoval->order)->orderBy('order', 'asc')->first();
                return response()->json(['videoval' => $videovalue, 'totalvideo' => $totalvideo, 'nextvideo' => $nextvideocnt,  200]); //next video in this category
            } else {
                $videovalue = array();
                return response()->json(['videoval' => '1',  200]); //No more videos
            }
        }

    }

     public function getspecialhistorylist($no){
        $volunteerval = Volunteer::where('mobile', $no)->first(); // 7 for insertion volunteer->id
        $volunteers_id = $volunteerval->uid;
        $volexist = DB::table('volunteervideos')->where('volunteervideos.volunteers_id', $volunteers_id)->exists() ? 1 : 0;
        if($volexist == 1)
        {
        $specialcatglist = DB::table('volunteervideos')
        ->join('categories','categories.id', 'volunteervideos.categories_id')
        ->where('categories.specialflag',1)
        ->where('volunteervideos.volunteers_id', $volunteers_id)
        ->select('categories.name','categories.id')
        ->get();
         
         return response()->json(['specialcatglist' => $specialcatglist,  200]); //next video in this category
       }
       else
       {
         return response()->json(['specialcatglist' => '0',  200]);
       }
    }

     public function getspecialhistory($no,$id){
        $volunteerval = Volunteer::where('mobile', $no)->first(); // 7 for insertion volunteer->id
        $volunteers_id = $volunteerval->uid;

        $volexist = DB::table('answerhistories')->where('answerhistories.volunteers_id', $volunteers_id)->where('answerhistories.categories_id', '=', $id)->exists() ? 1 : 0;
        if($volexist == 1)
        {
        $categoryval = Category::whereId($id)->first();
        $volhistory = DB::table('answerhistories')
            ->join('videos', 'answerhistories.videos_id', '=', 'videos.id')
            ->join('categories', 'answerhistories.categories_id', '=', 'categories.id')
            ->where('answerhistories.categories_id', '=', $id)
            ->where('answerhistories.volunteers_id', '=', $volunteers_id)
            ->select('videos.id', 'videos.file', 'videos.name as videoname', 'categories.name as category')
            ->get();
            return response()->json(['specialcatgvideolist' => $volhistory,  200]); //next video in this category
            }
       else
       {
         return response()->json(['specialcatgvideolist' => '0',  200]);
       }

    }

    public function getvolunteernotification($no){
      $volunteerval = Volunteer::where('mobile', $no)->first(); 
      $volunteers_id = $volunteerval->uid;

      $displayoptions=array();
           
      $voldata = DB::table('users')
            ->join('volunteers','users.id','=','volunteers.uid')
            ->select('volunteers.id','volunteers.districts_id')
            ->where('users.id',$volunteers_id)
            ->first();

      $eventdata = DB::table('events')
                ->join('eventdistricts','events.id','=','eventdistricts.events_id')
                ->join('districts','events.districts_id','=','districts.id')
                ->join('eventtypes','events.eventtypes_id','=','eventtypes.id')
                ->join('venues','events.venues_id','=','venues.id')
                ->select('events.id','events.name','eventtypes.name as eventtype','events.startdate','events.enddate','events.starttime','events.endtime','events.districts_id','districts.name as district','venues.name as venue','venues.location as location','venues.landmark as landmark','venues.geolocation as geolocation')
                ->where('eventdistricts.districts_id',$voldata->districts_id)
                ->orderBy('events.created_at','desc')
                ->get();

        foreach($eventdata as $eventdatas){

          

            $participation = DB::table('eventparticipations')
            ->select('status','events_id','qrcode')
            ->where('volunteers_id',$volunteers_id)
            ->where('events_id',$eventdatas->id)
            ->first();

            $new_startdate = Carbon::parse($eventdatas->startdate)->format('d-m-Y');
            $new_enddate = Carbon::parse($eventdatas->enddate)->format('d-m-Y');

            if($participation!='')
            {
              $actualpath = "http://sannadhasena.kerala.gov.in/qrcodes/".$participation->qrcode.".png";
              

              $displayoptions[] = array('maintypeid' => '1','subtype'=> $eventdatas->eventtype, 'maintype' => 'Event', 'id' => $eventdatas->id, 'name' => $eventdatas->name, 'startdate' => $new_startdate, 'enddate' => $new_enddate, 'starttime' => $eventdatas->starttime, 'endtime' => $eventdatas->endtime, 'district' => $eventdatas->district, 'location' => $eventdatas->location, 'landmark' => $eventdatas->landmark, 'geolocation' => $eventdatas->geolocation,'status'=> $participation->status, 'part_id' => $participation->events_id, 'qrcode'=>$actualpath);
            }
            else 
            {  
              $displayoptions[] = array('maintypeid' => '1','subtype'=> $eventdatas->eventtype, 'maintype' => 'Event', 'id' => $eventdatas->id, 'name' => $eventdatas->name, 'startdate' => $new_startdate, 'enddate' => $new_enddate, 'starttime' => $eventdatas->starttime, 'endtime' => $eventdatas->endtime, 'district' => $eventdatas->district, 'location' => $eventdatas->location, 'landmark' => $eventdatas->landmark, 'geolocation' => $eventdatas->geolocation,'status'=> '2', 'part_id' => 0, 'qrcode'=>'0');
            }
         }
         
        $taskdata = DB::table('tasks')
                ->join('taskdistricts','tasks.id','=','taskdistricts.tasks_id')
                ->join('districts','tasks.districts_id','=','districts.id')
                ->select('tasks.id','tasks.name','tasks.startdate','tasks.enddate','tasks.starttime','tasks.endtime','tasks.districts_id','districts.name as district','tasks.location as location','tasks.landmark as landmark','tasks.geolocation as geolocation')
                ->where('taskdistricts.districts_id',$voldata->districts_id)
                ->orderBy('tasks.created_at','desc')
                ->get();

          foreach($taskdata as $taskdatas){
            $new_startdate = Carbon::parse($taskdatas->startdate)->format('d-m-Y');
            $new_enddate = Carbon::parse($taskdatas->enddate)->format('d-m-Y');

          $displayoptions[] = array('maintypeid' => '2','subtype'=> 0,'maintype' => 'Task', 'id' => $taskdatas->id, 'name' => $taskdatas->name, 'startdate' => $new_startdate, 'enddate' => $new_enddate, 'starttime' => $taskdatas->starttime, 'endtime' => $taskdatas->endtime, 'district' => $taskdatas->district, 'location' => $taskdatas->location, 'landmark' => $taskdatas->landmark, 'geolocation' => $taskdatas->geolocation,'status'=> '2', 'part_id' => 0, 'qrcode'=>'0');
         }


         return response()->json(['notificationlist' => $displayoptions,  200]);
    }


    public function getvolunteerconfirmation($no,$maintypeid,$id){

      $volunteerval = Volunteer::where('mobile', $no)->first(); 
      $volunteers_id = $volunteerval->uid;

      if($maintypeid==1){
        $evntexist = Eventparticipation::where('volunteers_id',$volunteers_id)->where('events_id',$id)->exists() ? 1 : 0;
        if($evntexist){
          $updqry = Eventparticipation::where('volunteers_id',$volunteers_id)->where('events_id',$id)->update(['status' => 1]);
          Event::whereId($id)->increment('confirmedvolunteers',1);
          Event::whereId($id)->decrement('deniedvolunteers',1);
          $eventdet = DB::table('eventparticipations')->where('volunteers_id',$volunteers_id)->where('events_id',$id)->first();
          do{
             $idlink =  app('App\Http\Controllers\BaseController')->urlcode();
             $ecode = Eventparticipation::where('qrcode',$idlink)->exists() ? 1 : 0;
             if($ecode == 0)
                Eventparticipation::whereId($eventdet->id)->update(['qrcode' => $idlink]);
          }
          while($ecode == 1);
          /*---------------- send mail to all volunteers satisfying participant criteria ( start )-----------------*/

          $filepath = $idlink.'.png';
          $imagefile = QrCode::format('png')->size(300)->backgroundColor(215, 224, 184)->color(65, 66, 148)->generate($idlink,'../public/qrcodes/'.$filepath);
          $actualpath = "http://sannadhasena.kerala.gov.in/qrcodes/".$filepath;
          $eventdetails = Event::whereId($id)->first();
          $volunteerlst = Volunteer::where('uid',$volunteers_id)->first();
          $name = $volunteerlst->firstname." ".$volunteerlst->lastname;
          $inner_data = array('emailText'=>$eventdetails->emailtext, 'startdate'=> $eventdetails->startdate, 'volname' => $name, 'qrc' => $actualpath );
          $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
          $beautymail->send('email.eventsunny', $inner_data,   function($message )  use ($volunteerlst)
          {

              $message
                  ->from('dmvtfkerala@gmail.com')
                  ->to($volunteerlst->email,$volunteerlst->firstname)
                  ->subject('Notification from Directorate of Sannadha Sena');

          });
   

        /*---------------- send mail to all volunteers satisfying participant criteria ( end )-----------------*/

        /* -------------------------------------------- Send Custom SMS (start) --------------------------------- */
        /* $message = "You have confirmed your participation for the event. Check App/Email for more details";
            $number = $no;
            $link = curl_init();
            curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=sannadham-portal&password=Prtl@Mdns20&message=".$message."&numbers=".$number."&senderid=KLMGOV");
            curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($link , CURLOPT_HEADER, 0);
            curl_exec($link);
            curl_close($link );*/

         /* -------------------------------------------- Send Custom SMS (end) --------------------------------- */

        } else {
          $eventpart = new Eventparticipation([
                    'volunteers_id'          =>  $volunteers_id,
                    'events_id'         =>  $id,
                    'status'  =>  1
                ]);
          $eventpart->save();
          Event::whereId($id)->increment('confirmedvolunteers',1);
          //dd($eventpart);
          //$qrcodeval = base62_encode($evenpart->id);
          do{
             $idlink =  app('App\Http\Controllers\BaseController')->urlcode();
             $ecode = Eventparticipation::where('qrcode',$idlink)->exists() ? 1 : 0;
             if($ecode == 0)
                Eventparticipation::whereId($eventpart->id)->update(['qrcode' => $idlink]);
          }
          while($ecode == 1);
          //$updqrcode = Eventparticipation::where('id',$evenpart->id)->update(['qrcode' => $qrcodeval]);

          //Event::where('id',$event->id)->update(['eventcode' => $idlink]);

          /*---------------- send mail to all volunteers satisfying participant criteria ( start )-----------------*/

          $filepath = $idlink.'.png';
          $imagefile = QrCode::format('png')->size(300)->backgroundColor(215, 224, 184)->color(65, 66, 148)->generate($idlink,'../public/qrcodes/'.$filepath);

          $eventdetails = Event::whereId($id)->first();
          $volunteerlst = Volunteer::where('uid',$volunteers_id)->first();
          $actualpath = "http://sannadhasena.kerala.gov.in/qrcodes/".$filepath;
          $name = $volunteerlst->firstname." ".$volunteerlst->lastname;
          $inner_data = array('emailText'=>$eventdetails->emailtext, 'startdate'=> $eventdetails->startdate, 'volname' => $name, 'qrc' => $actualpath );
          $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
          $beautymail->send('email.eventsunny', $inner_data,   function($message )  use ($volunteerlst)
          {

              $message
                  ->from('dmvtfkerala@gmail.com')
                  ->to($volunteerlst->email,$volunteerlst->firstname)
                  ->subject('Notification from Directorate of Sannadha Sena');

          });


        /*---------------- send mail to all volunteers satisfying participant criteria ( end )-----------------*/
         /* -------------------------------------------- Send Custom SMS (start) --------------------------------- */
           /* $message = "You have confirmed your participation for the event. Check App/Email for more details";
            $number = $no;
            $link = curl_init();
            curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=sannadham-portal&password=Prtl@Mdns20&message=".$message."&numbers=".$number."&senderid=KLMGOV");
            curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($link , CURLOPT_HEADER, 0);
            curl_exec($link);
            curl_close($link );*/

         /* -------------------------------------------- Send Custom SMS (end) --------------------------------- */

        }
      } else {
        //Task Actions
      }

      return response()->json(['notifystatus' => "1",  200]);

    }


    public function getvolunteerdecline($no,$maintypeid,$id){

      $volunteerval = Volunteer::where('mobile', $no)->first(); 
      $volunteers_id = $volunteerval->uid;

      if($maintypeid==1){
        $evntexist = Eventparticipation::where('volunteers_id',$volunteers_id)->where('events_id',$id)->exists() ? 1 : 0;
        if($evntexist){
          $eventdet = Eventparticipation::where('volunteers_id',$volunteers_id)->where('events_id',$id);
          $updqry = Eventparticipation::where('volunteers_id',$volunteers_id)->where('events_id',$id)->update(['status' => 0]);
          Event::whereId($id)->decrement('confirmedvolunteers',1);
          Event::whereId($id)->increment('deniedvolunteers',1);

        } else {
          $eventpart = new Eventparticipation([
                    'volunteers_id'          =>  $volunteers_id,
                    'events_id'         =>  $id,
                    'status'  =>  0
                ]);
          $eventpart->save();
          Event::whereId($id)->increment('deniedvolunteers',1);

        }

          /* $message = "You have declined your participation for the event. You can confirm your participation by visiting the app.";
            $number = $no;
            $link = curl_init();
            curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=sannadham-portal&password=Prtl@Mdns20&message=".$message."&numbers=".$number."&senderid=KLMGOV");
            curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($link , CURLOPT_HEADER, 0);
            curl_exec($link);
            curl_close($link ); */

      } else {

      }

      return response()->json(['notifystatus' => "1",  200]);
    }

  public function getmessagelog($no,$type) {

           $date = \Carbon\Carbon::today()->subDays(30);

           if($type == 4){
            $volunteerval = Volunteer::where('mobile', $no)->first(); 
            $volunteers_id = $volunteerval->uid;
            
            $voldstval = DB::table('volunteers')->where('uid',$volunteers_id)->select('districts_id','categories_id', 'level')->first();
            $volvidcntexist = DB::table('volunteervideos')->where('volunteers_id', $volunteers_id)->exists() ? 1 : 0;
            if($volvidcntexist == 1){
            $volvidcnt = DB::table('volunteervideos')->where('volunteers_id', $volunteers_id)->select('totalvideos')->first();
            $volvidcntval = $volvidcnt->totalvideos;
            }else {
                $volvidcntval = 0;
            }

            $listdata = DB::table('notifications')
                ->join('notifytypes', 'notifytypes.id', '=', 'notifications.notifytypes_id')
                ->join('usertypes', 'usertypes.id', '=', 'notifications.usertypes_id')
                ->whereRaw('FIND_IN_SET(?,notifications.volunteerdistricts)', [$voldstval->districts_id])
                ->orWhere('notifications.volunteerdistricts',0)
                ->whereRaw('FIND_IN_SET(?,notifications.volunteercategories)', [$voldstval->categories_id])
                ->orWhere('notifications.volunteercategories', 0)
                ->whereRaw('FIND_IN_SET(?,notifications.volunteerlevels)', [$voldstval->level])
                ->orWhere('notifications.volunteerlevels', 0)
                ->where('notifications.volminvideos', '<=', $volvidcntval)
                ->where('notifications.usertypes_id', 4)
                ->where('notifications.created_at', '>=', $date)
                ->select('notifications.created_at', 'notifications.id', 'notifications.name', 'notifications.content','notifications.attachments', 'notifytypes.name as notifytype', 'usertypes.name as usertype')
                ->orderBy('notifications.created_at', 'desc')
                ->get();

           } else if ($type == 5) {

            $voldstval = DB::table('ddmas')->where('id', $useruid)->select('districts_id')->first();


            $listdata = DB::table('notifications')
                ->join('notifytypes', 'notifytypes.id', '=', 'notifications.notifytypes_id')
                ->join('usertypes', 'usertypes.id', '=', 'notifications.usertypes_id')
                ->whereRaw('FIND_IN_SET(?,notifications.ddmadistricts)', [$voldstval->districts_id])
                ->orWhere('notifications.ddmadistricts', 0)
                ->where('notifications.usertypes_id', 5)
                ->where('notifications.created_at', '>=', $date)
                ->select('notifications.created_at', 'notifications.id', 'notifications.name', 'notifications.content', 'notifications.attachments', 'notifytypes.name as notifytype', 'usertypes.name as usertype')
                ->orderBy('notifications.created_at', 'desc')
                ->get();
        } else if ($type == 6) {

            $voldstval = DB::table('iags')->where('id', $useruid)->select('districts_id')->first();


            $listdata = DB::table('notifications')
                ->join('notifytypes', 'notifytypes.id', '=', 'notifications.notifytypes_id')
                ->join('usertypes', 'usertypes.id', '=', 'notifications.usertypes_id')
                ->whereRaw('FIND_IN_SET(?,notifications.iagdistricts)', [$voldstval->districts_id])
                ->orWhere('notifications.iagdistricts', 0)
                ->where('notifications.usertypes_id', 6)
                ->where('notifications.created_at', '>=', $date)
                ->select('notifications.created_at', 'notifications.id', 'notifications.name', 'notifications.content', 'notifications.attachments', 'notifytypes.name as notifytype', 'usertypes.name as usertype')
                ->orderBy('notifications.created_at', 'desc')
                ->get();
        }
        if ($type == 5)
        {
        $sentdata = DB::table('notifications')
            ->join('notifytypes', 'notifytypes.id', '=', 'notifications.notifytypes_id')
            ->join('usertypes', 'usertypes.id', '=', 'notifications.usertypes_id')
            ->where('notifications.created_at', '>=', $date)
            ->where('notifications.users_id', '=', $userid)
            ->select('notifications.created_at', 'notifications.id', 'notifications.name', 'notifications.content', 'notifications.created_at', 'notifications.attachments', 'notifytypes.name as notifytype', 'usertypes.name as usertype')
            ->orderBy('notifications.created_at', 'desc')
            ->get();

        $draftdata = DB::table('tempuploads')->where('users_id', $userid)->get();
        }
        else {
            $sentdata =  array();
            $draftdata =  array();
        }

        return response()->json(['inboxdata' =>$listdata, 'sentdata' => $sentdata, 'draftdata' => $draftdata,  200]);
            
  }

  public function getmessageview($id){

        $notfn = Notification::whereId($id)->first();

        return response()->json(['name' => $notfn->name, 'content' => $notfn->content]);

  }

  public function getmessageattachment($id){
      $notattachexist = DB::table('notifyattachments')->where('notifications_id',$id)->exists() ? 1 : 0;
        if($notattachexist==1){
            $notfnattach = DB::table('notifyattachments')->where('notifications_id',$id)->get();
            return response()->json(['notifiedvalues' => $notfnattach]);
         }

  }

  public function getvolunteerdetails(Request $request,$no)
    { 
      // dd(phpinfo());
      //  echo phpinfo();

      $listdata = Volunteer::where('mobile',$no)->first();
      $listdata1 = Volunteer::with(['skill'=>function(){

      }])->where('mobile',$no)->first();

      $skillsArray = $listdata1->skill->toArray();
     
      $TokenRecvd =$request->token_api;
      $encryptedtoken = $listdata->token_api;
  
              //  // Hash the string (to get a fixed length)
              //  $hashedString = hash('sha256', $listdata->id);

              //  // Take the first 10 characters of the hashed string
              //  $limitedHashedString = substr($hashedString, 0, 10);
       
              //  $encryptedtoken = $this->encrptt_fun($limitedHashedString);

         // Display the decrypted string
        if($encryptedtoken == $TokenRecvd){
 
          // $checkvolunteerexist = Volunteer::where('mobile',$no)->where('status',1)->exists() ? 1 : 0;
          if(isset($listdata->photograph))
          {
            $userphoto    = $listdata->photograph;
            $path=public_path().'/profile/'.$userphoto;
            $userphotoencode    = file_get_contents($path);
            $base64dataphoto=base64_encode($userphotoencode);
          }else{
            $base64dataphoto='No image added';
          }
          return response()->json(['voldata' => $listdata,'skillsArray'=> $skillsArray,'base64dataphoto'=>$base64dataphoto]);

          }else{
            return response()->json(['error' => 'Unauthorized'], 401);

          }

     
 
      // ->select('id','firstname','lastname','email','mobile','address','dob','districts_id','lsgtype','lsg','photograph','idcard','bloodgroups_id','palliativestatus')->first();
      // dd($listdata);
      // $district = DB::table('districts')->orderBy('id','asc')->get();
      // $lsgtype = DB::table('lsgtype')->where('id' ,'>', 2)->orderBy('id','asc')->get();
      // $lsg = DB::table('lsg')->orderBy('intLBID','asc')->get();
      // $pincode = DB::table('pincodes')->get();
      // $bloodgroup = DB::table('bloodgroups')->get();
     
      // return response()->json(['voldata' => $listdata, 'district' => $district, 'lsgtype' => $lsgtype, 'lsg' => $lsg,'pincode'=>$pincode, 'bloodgroup'=>$bloodgroup]);
    }

    public function getvolunteerupdate(Request $request,$no)
    {
    //   $request->validate([
    //     'district' => 'required',
    //     'lsgtype'  => 'required',
    //     'lsg'      => 'required',
    //     // 'dob'      => 'required',
    //     'gender'   => 'required',
    //     'ward'     => 'required',
    //     'email'    => 'required',
    //     'firstname' =>'required',


    // ]);
  
    $rules = [
        'district' => 'required',
        // 'lsgtype'  => 'required',
        // 'lsg'      => 'required',
        // 'dob'      => 'required',
        // 'gender'   => 'required',
        // 'ward'     => 'required',
        // 'email'    => 'required',
        'firstname' =>'required',
        'token_api' =>'required',
  ];

  // Create a validator instance
  $validator = Validator::make($request->all(), $rules);

  // Check if validation fails
  if ($validator->fails()) {
      // Return a JSON response with validation errors
      return response()->json([
          'message' => 'Validation error',
          'errors' => $validator->errors(),
      ], 422);
  }



      $volunteerval = Volunteer::where('mobile', $no)->first(); 
      $TokenRecvd =$request->token_api;
      $encryptedtoken = $volunteerval->token_api;
   
      if($encryptedtoken == $TokenRecvd){
       
        $volunteers_id = $volunteerval->uid;

        if($request->photograph == 'null')
        {
          $img_update_flag = 0;
        }else{
          $img_update_flag = 1;
        }
       
      if($img_update_flag == 1)
      {
        if(isset($request->photograph))
        {
          $base64dataphoto=base64_decode($request->photograph);
          // if (preg_match('/^data:image\/(\w+);base64,/', $base64dataphoto))
          // {
            $fname = 'p'.$volunteerval->id.'.jpg';
            
            $imageName      =$fname;
           
            file_put_contents('profile/'.$fname, $base64dataphoto);
          // }
         
        }
      }else{
        $imageName ='';
      }
    
      if($request->idcardfile == 'null')
      {
        $idcard_update_flag = 0;
      }else{
        $idcard_update_flag = 1;
      }

      if($idcard_update_flag == 1)
      {
        
        if(isset($request->idcardfile))
        {
           
        $base64dataid=base64_decode($request->idcardfile);
      
        $fnameid = 'c'.$volunteerval->id.'.jpg';
         
        $imageName1      =$fnameid;
        file_put_contents('profile/'.$fname, $base64dataphoto);
        
        }
      }else{
        $imageName1 ='';
      }
    
      
      // if(isset($request->idcardfile))
      // {
        
      //   $base64dataid=base64_decode($request->idcardfile);

      //     $fnameid = 'c'.$volunteerval->id.'.jpg';
           
      //     $imageName1      =$fnameid;
      //     file_put_contents('profile/'.$fname, $base64dataphoto);
      
      // }
     

      $fireBaseId = $request->fireBaseId;
     
      if($request->get('dob') != '')
      {
        // $dob1 = date('Y-m-d', strtotime(str_replace('/','-', $request->get('dob'))));
        // $dob = Carbon::parse($dob1);
        $formdatadob = array(
          'dob' => $request->get('dob'),
        );
        Volunteer::where('uid',$volunteers_id)->update($formdatadob);
      }
    
      if(isset($request->disablestatus)){$disabled=1;} else{$disabled=0;}
     
      $palliativestatus  = $request->palliativestatus;
    
      // if($imageName !='')//photo
     
      if($img_update_flag == 1)
      {
        $formdata = array(
          'email'  => $request->email,
          'districts_id' => $request->district,
          'address' => $request->address,
          'firstname' => $request->firstname,
          'lastname' => $request->lastname,
          'lsgtype' => $request->lsgtype,
          'lsg' => $request->lsg,
          'palliativestatus' => $palliativestatus,
          'palliative_catg' =>$request->palliative_catg,
          'pincodes_id' => $request->pincode,
          'ward' => $request->ward,
          'photograph' => $imageName,
          'gender' => $request->gender,
          'disabled' => $disabled,
          'idcardno' => $request->idcardnumber,
          'idcardtype' => 1,
          'bloodgroups_id' => $request->bloodgroup,
          'fireBaseId'  => $fireBaseId,
          'mobile_api'  =>1
        );
      } elseif($idcard_update_flag == 1){//idcard
        $formdata = array(
          'email'  => $request->email,
          'districts_id' => $request->district,
          'address' => $request->address,
          'firstname' => $request->firstname,
          'lastname' => $request->lastname,
          'lsgtype' => $request->lsgtype,
          'lsg' => $request->lsg,
          'palliativestatus' => $palliativestatus,
          'pincodes_id' => $request->pincode,
          'ward' => $request->ward,
          'idcard' => $imageName1,
          'gender' => $request->gender,
          'disabled' => $disabled,
          'idcardno' => $request->idcardnumber,
          'idcardtype' => 1,
          'bloodgroups_id' => $request->bloodgroup,
          'fireBaseId'  => $fireBaseId,
          'mobile_api'  =>1
        );
      }else{
        $formdata = array(
          'email'  => $request->email,
          'districts_id' => $request->district,
          'address' => $request->address,
          'firstname' => $request->firstname,
          'lastname' => $request->lastname,
          'lsgtype' => $request->lsgtype,
          'lsg' => $request->lsg,
          'palliativestatus' => $palliativestatus,
          'pincodes_id' => $request->pincode,
          'ward' => $request->ward,
          'gender' => $request->gender,
          'disabled' => $disabled,
          'idcardno' => $request->idcardnumber,
          'idcardtype' => 1,
          'bloodgroups_id' => $request->bloodgroup,
          'fireBaseId'  => $fireBaseId,
          'mobile_api'  =>1
        );
      }
  
      $volunteerUpdate = Volunteer::where('uid',$volunteers_id)->update($formdata);

 
      if($volunteerUpdate)
      {
      
        $volunteersid = $volunteerval->id;

        if(isset($request->skillsid))
        {
          $skill_count = count($request->skillsid);
                   
          $skillchecks   = DB::table('skill_volunteer_relations')
                          ->where('volunteer_id',$volunteersid)
                          ->get();

            foreach($skillchecks as $skillcheck)  
            {
              $id = $skillcheck->id;
              $VolunDel = SkillVolunteerRelations::find($id);
              $VolunDel->delete();
            }    
       
          foreach($request->skillsid as $skill)
          {     
      
            $len_skill_vol = count($skillchecks);
            $skilldata_details = [ 'volunteer_id' => $volunteersid,
            'skill_id'     => $skill];
            
              $skilldata = new SkillVolunteerRelations([ 'volunteer_id' => $volunteersid,
                              'skill_id'     => $skill]);
                              $skillUpdate =$skilldata->save();


              // $skillUpdate = SkillVolunteerRelations::create($skilldata);
         
              $skilldata_details[] =   "New skill added"; 
 
          }
   
        } 
      }
  
      $message = "Volunter details updated Sucessfully";
      
     
      return response()->json(['message' => $message,'data' => $formdata,'dob' => $formdatadob,'skilldata'=>$skilldata_details,  200]);
      }else{
        return response()->json(['error' => 'Unauthorized'], 401);
  
      }

      
    }

    public function getvolunteersurvey($no,$sid){

      $surveyid = Survey::whereId($sid)->first();
      $volunteersid = Volunteer::where('mobile', $no)->first();
      $volanscountexist = Surveyanswer::where('surveys_id',$sid)->where('volunteers_id',$volunteersid->id)->exists() ? 1 : 0;
      if($volanscountexist == 1)
      { 
        $volanscount = Surveyanswer::where('surveys_id',$sid)->where('volunteers_id',$volunteersid->id)->count();
        if($volanscount != $surveyid->count)
        {
          Surveyanswer::where('surveys_id',$sid)->where('volunteers_id',$volunteersid->id)->delete();
          $volanscount = 0;
        }
        else
          $volanscount = 1;
  }
  else
      $volanscount = 0;
  if($volanscount == 0){
     $questions = Surveyquestion::where('surveys_id',$sid)->orderBy('id','asc')->first();
       $answers = Surveyoption::where('surveyquestions_id',$questions->id)->get();
       $more  = 1;
       return response()->json(['questions' => $questions,'answers'=> $answers, 'more' => $more ]);
  }
  else
    $more = 0;
     
        return response()->json(['more' => $more ]);
    }


    public function getsurveyanswerlist($no,$qid,$ansid){


      $surveyqstncheckid = Surveyquestion::whereId($qid)->first();
      
      $surveycheckid = Survey::whereId($surveyqstncheckid->surveys_id)->first();

      if($surveycheckid->correctreqd == 1)
      {
        $dbcorrect = Surveyoption::where([['surveyquestions_id',$qid],['correct','1']])->first();
        if($dbcorrect->id == $ansid)
          $answercorrect = 1;
        else
          $answercorrect = 0;
      }
      else
      {
          $answercorrect = 0;
      }
       
       $questions = Surveyquestion::find($qid);
       $surveys = Survey::find($questions->surveys_id);

       $volunteersid = Volunteer::where('mobile',$no)->first();
       
       $already_answered = Surveyanswer::where('surveyquestions_id',$qid)->where('volunteers_id',$volunteersid->id)->exists() ? 1 : 0;
      


       if ($already_answered == 0)
       {
             $form_data = array(
                  'volunteers_id'      =>  $volunteersid->id,
                  'surveys_id'         =>  $surveyqstncheckid->surveys_id,
                  'surveyquestions_id' =>  $qid,
                  'answer'             =>  $ansid,
                  'status'             =>  $answercorrect
              );
            $insertid =  Surveyanswer::create($form_data);
       }
       else
       {
              Surveyanswer::where('volunteers_id', $volunteersid->id)
              ->where('surveyquestions_id', $qid)
              ->update(['answer' => $ansid],['status' => $answercorrect]);
       }
      
      $questions2 = Surveyquestion::where('surveys_id',$surveyqstncheckid->surveys_id)->where('id','>',$qid)->exists() ? 1 : 0;
      
      
      if($questions2 == 1)
      {
          $questions1 = Surveyquestion::where('surveys_id','=',$surveyqstncheckid->surveys_id)->where('id','>',$qid)->orderBy('id','asc')->first();
          
          $answers1 = Surveyoption::where('surveyquestions_id',$questions1->id)->get();
          
          return response()->json(['questions1' => $questions1,'answers1' => $answers1,'more' => 1]);
      }
      else
      {
         return response()->json(['more' => 0]);
      }
             
}

public function getvolunteereditdetails(Request $request){

    $volunteerval = Volunteer::where('mobile',$request->old_phone_no)->first();
    $volunteers_id = $volunteerval->uid;
    $vol_photo = $volunteerval->photograph;
    $vol_idcard = $volunteerval->idcard;

    $dob1 = date('Y-m-d', strtotime(str_replace('/','-', $request->dob)));
    $dob = Carbon::parse($dob1);

   ///////////////////////////////////////////////////--photo

    if($request->photo==''){
      $imageName = $vol_photo;
    } else {
      $op=base64_decode($request->photo);
      $imgsize=getImageSizeFromString($op);
    // $ext=substring($imgsize["mime"],6);
      $imagetyp = explode('image/',$imgsize['mime']);
    //file_put_contents("1.jpg",$op);
      $ext=$imagetyp[1];
      $imageName = 'p'.$volunteerval->id.'.'.$ext;
      if(file_exists(public_path().'/profile/'.$imageName))
      {
        unlink(public_path().'/profile/'.$imageName);
      }

     \File::put(public_path('profile'). '/' . $imageName, $op);
      
    }

    /*-----------------------------------------------------------------*/
 
 
 /////////////////////////////////////////////--idcard  

    if($request->idcard==''){
      $imageName1 = $vol_idcard;
    } else {
      $op1=base64_decode($request->idcard);
      $imgsize1=getImageSizeFromString($op1);
    // $ext=substring($imgsize["mime"],6);
      $imagetyp1 = explode('image/',$imgsize1['mime']);
    //file_put_contents("1.jpg",$op);
      $ext1=$imagetyp1[1];
      $imageName1 = 'c'.$volunteerval->id.'.'.$ext1;
      if(file_exists(public_path().'/profile/'.$imageName1))
      {
        unlink(public_path().'/profile/'.$imageName1);
      }
     \File::put(public_path('profile'). '/' . $imageName1, $op1);
      
    } 




    /*---------------------------------------------------------------*/

    $nameexplode = explode(' ',$request->name);
    if(count($nameexplode)>1){
      $firstname = $nameexplode[0];
      $lastname = $nameexplode[1];
    } else {
      $firstname = $request->name;
      $lastname = '';
    }

    if(isset($request->presentstatus)){$presentlsgval = $request->presentlsg1; } else { $presentlsgval = $request->presentlsg;}
    if(isset($request->sixmonthstatus)){$sixmonthstatus = 1; } else { $sixmonthstatus = 0;}
    if(isset($request->criminalcasedetails)){$criminalcasedetails = $request->criminalcasedetails; } else { $criminalcasedetails = $listdata->criminalcasedetails;}
    if(isset($request->interestedwards)){$interestedwards = $request->interestedwards; } else { $interestedwards = $listdata->interestedwards;}
    if(isset($request->sssstatus)){$sssstatus = 1; } else { $sssstatus =0;}
    if(isset($request->sssdetails)){$sssdetails = $request->sssdetails; } else { $sssdetails = $listdata->sssdetails;}
    if(isset($request->vehiclestatus)){$vehiclestatus =1; } else { $vehiclestatus = 0;}
    if(isset($request->phonestatus)){$phonestatus =1; } else { $phonestatus = 0;}

    $imageName3='';
    $vehiclelist = array();
    $vehicleimplist='';
    if(isset($request->vehiclestatus)){
        $vehicle1 = $request->vehicle;
        $vehiclecnt = count($vehicle1);
        for($i=0;$i<$vehiclecnt;$i++){
            $vehiclelist[] = $vehicle1[$i];
        }
        $vehicleimplist = implode( ', ', $vehiclelist );
    }
    
    /*$formdata = array(
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email'  => $request->email,
        'mobile' => $request->phone_no,
        'address' => $request->address,
        'dob' => $dob,
        'districts_id' => $request->district_id,
        'lsgtype' => $request->lsgtype_id,
        'lsg' => $request->lsg_id,
        'photograph' => $imageName,
        'idcard' => $imageName1,
        'update_device' => 1
      );*/
    $formdata = array(
          'mobile' => $request->mobile,
          'email'  => $request->email,
          'districts_id' => $request->district,
          'presentdistricts_id' => $request->presentdistrict,
          'address' => $request->permanentaddress,
          'presentaddress' => $request->presentaddress,
          'lsgtype' => $request->lsgtype,
          'presentlsgtype' => $request->presentlsgtype,
          'lsg' => $request->lsg,
          'presentlsg' => $presentlsgval,
          'pincodes_id' => $request->pincode,
          'presentpincodes_id' => $request->pincode1,
          'ward' => $request->ward,
          'presentward' => $request->presentward,
          'dob' => $dob,
          'photograph' => $imageName,
          'idcard' => $imageName1,
          'sixmonthstatus'=>$sixmonthstatus,
          'disabledcert'=>$imageName3,
          'criminalcasedetails'=>$criminalcasedetails,
          'interestedwards'=>$interestedwards,
          'sssstatus'=>$sssstatus,
          'sssdetails'=>$sssdetails,
            'phonestatus' => $phonestatus,
            'vehiclestatus' => $vehiclestatus,
            'vehicles' => $vehicleimplist,
            'bloodgroups_id' => $request->bloodgroup,
            'update_device' => 1
        );//dd($formdata);

    Volunteer::where('uid',$volunteers_id)->update($formdata);
    /*$formdata1 = array(
        'name' => $request->name,
        'uid'  => $request->phone_no,
        'email' => $request->phone_no
      );*/
      $formdata1 = array(
        'email' => $request->phone_no
      );
    User::where('id',$volunteers_id)->update($formdata1);
    
    $message = "Details updated successfully. ";  
    return response()->json(['message' => $message, 200]);

  } 
/* -------------------------------------- APIs for https://dashboard.kerala.gov.in/ --------------------------------------*/
  public function gettotalvolunteers()
  {
    $count = Volunteer::whereNotNull('volunteers.uid')->where('volunteers.uid','!=',2)->where('status',1)->count();
    $fcount = Volunteer::whereNotNull('volunteers.uid')->where('volunteers.uid','!=',2)->where('status',1)->where('gender',1)->count();
    $mcount = Volunteer::whereNotNull('volunteers.uid')->where('volunteers.uid','!=',2)->where('status',1)->where('gender',2)->count();
    $tcount = Volunteer::whereNotNull('volunteers.uid')->where('volunteers.uid','!=',2)->where('status',1)->where('gender',3)->count();
    return response()->json(['totalcount' => $count,'female' => $fcount,'male' => $mcount,'trans' => $tcount, 200]);
  } //end of gettotalvolunteers

  public function getagevolunteers()
  {
    $now = Carbon::now();
  // 1. Between 20 to 30, 31 to 40, 41 to 50 and 51 to 65

  $agefrom = 20;
  $ageto = 30;
  $startyear = $now->year - $agefrom;
  $endyear = $now->year - $ageto;
  $startdate = $endyear."-01-01";
  $enddate = $startyear."-12-31";
    $age1count = Volunteer::whereNotNull('volunteers.uid')->where('volunteers.uid','!=',2)->where('status',1)->whereBetween(\DB::raw('DATE(volunteers.dob)'), [$startdate, $enddate])->count();

  $agefrom = 31;
  $ageto = 40;
  $startyear = $now->year - $agefrom;
  $endyear = $now->year - $ageto;
  $startdate = $endyear."-01-01";
  $enddate = $startyear."-12-31";
    $age2count = Volunteer::whereNotNull('volunteers.uid')->where('volunteers.uid','!=',2)->where('status',1)->whereBetween(\DB::raw('DATE(volunteers.dob)'), [$startdate, $enddate])->count();

  $agefrom = 41;
  $ageto = 50;
  $startyear = $now->year - $agefrom;
  $endyear = $now->year - $ageto;
  $startdate = $endyear."-01-01";
  $enddate = $startyear."-12-31";
    $age3count = Volunteer::whereNotNull('volunteers.uid')->where('volunteers.uid','!=',2)->where('status',1)->whereBetween(\DB::raw('DATE(volunteers.dob)'), [$startdate, $enddate])->count();

  $agefrom = 51;
  $ageto = 65;
  $startyear = $now->year - $agefrom;
  $endyear = $now->year - $ageto;
  $startdate = $endyear."-01-01";
  $enddate = $startyear."-12-31";
  
  $age4count = Volunteer::whereNotNull('volunteers.uid')->where('volunteers.uid','!=',2)->where('status',1)->whereBetween(\DB::raw('DATE(volunteers.dob)'), [$startdate, $enddate])->count();

  $agefrom = 16;
  $ageto = 19;
  $startyear = $now->year - $agefrom;
  $endyear = $now->year - $ageto;
  $startdate = $endyear."-01-01";
  $enddate = $startyear."-12-31";
  
  $age5count = Volunteer::whereNotNull('volunteers.uid')->where('volunteers.uid','!=',2)->where('status',1)->whereBetween(\DB::raw('DATE(volunteers.dob)'), [$startdate, $enddate])->count();


 return response()->json(['20to30' => $age1count,'31to40' => $age2count,'41to50' => $age3count,'51to65' => $age4count, '16to19' => $age5count, 200]);

} // end of getage volunteer function
public function getdistrictvolunteer()
{
      $district  = District::orderBy('id','asc')->get();
      $districtcount = array();
      foreach ($district as $districts) {
        $districtvol = Volunteer::where('districts_id',$districts->id)->whereNotNull('volunteers.uid')->where('volunteers.uid','!=',2)->where('status',1)->count();
        $districtcount[] = array('districid' => $districts->id,'districtname' => $districts->name, 'districtlocalname' => $districts->local, 'districtvolcount' => $districtvol);
      }
      return response()->json(['districtcount' => $districtcount, 200]);
}
public function getactivityvolunteercount()
{
      $activitylist = DB::table('activities')->whereIn('id',[2, 3, 5, 12, 17])->get();
      foreach($activitylist as $activitylists)
      {
          $listdata = DB::table('volunteers')
          ->join('volunteeractivities','volunteers.id','volunteeractivities.volunteers_id')
          ->where('volunteeractivities.activities_id',$activitylists->id)
          ->whereNotNull('volunteers.uid')
          ->where('volunteers.uid','!=',2) 
          ->where('volunteers.status',1) 
          ->count();
          $activityarray[] = array('aid' => $activitylists->id, 'activityname' => $activitylists->name, 'totalcount' => $listdata);
      } //activitylist foreach

      return response()->json(['activitycount' => $activityarray, 200]);
}

public function getcovidvolunteercount()
{
      $activitylist = DB::table('surveyquestions')->where('surveys_id',2)->get();
      foreach($activitylist as $activitylists)
      {
          $listdata = DB::table('volunteers')
          ->join('surveyanswers','volunteers.id','surveyanswers.volunteers_id')
          ->where('surveyanswers.surveyquestions_id',$activitylists->id)
          ->where('surveyanswers.answer','!=',0)
          ->whereNotNull('volunteers.uid')
          ->where('volunteers.uid','!=',2)    
          ->where('volunteers.status',1)         
          ->count();
          $activityarray[] = array('aid' => $activitylists->id, 'activityname' => $activitylists->name, 'totalcount' => $listdata);
      } //activitylist foreach

      return response()->json(['covidcount' => $activityarray, 200]);
}
/* -------------------------------------- APIs for https://dashboard.kerala.gov.in/ --------------------------------------*/


  public function todo($meetingid)

    {
      $payload = '';
      $contentType = 'application/xml';
        $url = "https://bbb.cdit.org/bigbluebutton/api/create?allowStartStopRecording=true&attendeePW=ap&autoStartRecording=false&meetingID=random-8647139&moderatorPW=mp&name=random-8647139&record=false&voiceBridge=77868&welcome=%3Cbr%3EWelcome+to+%3Cb%3E%25%25CONFNAME%25%25%3C%2Fb%3E%21&checksum=82120c72abc1ac95ab9636a4bdd326cd05763b58";
        if (extension_loaded('curl')) {
            $ch = curl_init();
            if (!$ch) {
                throw new \RuntimeException('Unhandled curl error: ' . curl_error($ch));
            }
            $timeout = 10;

            // Needed to store the JSESSIONID
            $cookiefile     = tmpfile();
            $cookiefilepath = stream_get_meta_data($cookiefile)['uri'];

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefilepath);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefilepath);
            if (!empty($payload)) {
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-type: ' . $contentType,
                    'Content-length: ' . mb_strlen($payload),
                ]);
            }
            $data = curl_exec($ch);
            if ($data === false) {
                throw new \RuntimeException('Unhandled curl error: ' . curl_error($ch));
            }
            curl_close($ch);

            $cookies = file_get_contents($cookiefilepath);
            if (strpos($cookies, 'JSESSIONID') !== false) {
                preg_match('/(?:JSESSIONID\s*)(?<JSESSIONID>.*)/', $cookies, $output_array);
                $this->setJSessionId($output_array['JSESSIONID']);
            }

            dd($data);

            return new SimpleXMLElement($data);
        } else {
            throw new \RuntimeException('Post XML data set but curl PHP module is not installed or not enabled.');
        }
    }
	
	////New Apis for Live Event Notifications(start)
	
	public function getvolunteerliveeventnotifications($no)
    {
      $displayoptions=array();
      $partstatarray=array();
      $volunteerval = Volunteer::where('mobile', $no)->first(); 
      $volunteers_id = $volunteerval->uid;
           
      $voldata = DB::table('users')
            ->join('volunteers','users.id','=','volunteers.uid')
            ->select('volunteers.id','volunteers.districts_id')
            ->where('users.id',$volunteers_id)
            ->first();
            
      

      $eventdata = DB::table('liveevents')->where('status',0)->get();
      if(!$eventdata->isEmpty())
       { 
      foreach($eventdata as $eventdatas){
       $participation = DB::table('liveeventparticipations')
              ->select('status','events_id')
            ->where('volunteers_id',$volunteers_id)
            ->where('events_id',$eventdatas->id)
            ->first();
            
            if($participation!=''){
             $status=$participation->status;///confirm=1 deny=0
              $part=1;
            } else {  
              $part=0; ///not in liveeventparticipation
              $status=2;///so no status
            }  
			$partstatarray[] = array('id' => $eventdatas->id, 'part' => $part, 'status' => $status);
      }
      } else {
        $eventdata=0;///no live event
        $part=0;
        $status=0;
		$partstatarray[] = array('id' => 0, 'part' => $part, 'status' => $status);

      } 
   	  return response()->json(['eventdata' => $eventdata, 'partstatarray' => $partstatarray , 200]);
          
    }
	
	public function getliveeventvolunteerconfirmation($no,$id){
		
		$volunteerval = Volunteer::where('mobile', $no)->first(); 
      $volunteers_id = $volunteerval->uid;
     
        
        $liveeventexist = DB::table('liveeventparticipations')->where('volunteers_id',$volunteers_id)->where('events_id',$id)->exists() ? 1 : 0;


        if($liveeventexist){
          $eventconfirmedchk = Liveevent::whereId($id)->first();
          if(($eventconfirmedchk->maxparticipants)>($eventconfirmedchk->confirmedvolunteers))
           {
          $updqry = DB::table('liveeventparticipations')->where('volunteers_id',$volunteers_id)->where('events_id',$id)->update(['status' => 1]);
          
             Liveevent::whereId($id)->increment('confirmedvolunteers',1);
            Liveevent::whereId($id)->decrement('deniedvolunteers',1);
           } 
          
          

        } else {
          $eventpart = new Liveeventparticipation([
                    'volunteers_id'          =>  $volunteers_id,
                    'events_id'         =>  $id,
                    'status'  =>  1
                ]);
          $eventpart->save();
          Liveevent::whereId($id)->increment('confirmedvolunteers',1);
          //dd($eventpart);
          //$qrcodeval = base62_encode($evenpart->id);
          

        }
        //return redirect('/volunteer/notifications')->with('success', 'Confirmed Successfully!');
        
		 
		 $message = "Please wait for SMS with details of the event in your registered mobile number, 1 hour before the event starts.! ";  
    return response()->json(['message' => $message, 200]);
    


    }
	
	 public function getliveeventvolunteerdeny($no,$id){
		 
		 $volunteerval = Volunteer::where('mobile', $no)->first(); 
      $volunteers_id = $volunteerval->uid;
      
        $liveeventexist = DB::table('liveeventparticipations')->where('volunteers_id',$volunteers_id)->where('events_id',$id)->exists() ? 1 : 0;
        if($liveeventexist){
            $updqry = DB::table('liveeventparticipations')->where('volunteers_id',$volunteers_id)->where('events_id',$id)->update(['status' => 0]);
          //Liveevent::whereId($id)->decrement('confirmedvolunteers',1);
          Liveevent::whereId($id)->increment('deniedvolunteers',1);

        } else {
          $eventpart = new Liveeventparticipation([
                    'volunteers_id'          =>  $volunteers_id,
                    'events_id'         =>  $id,
                    'status'  =>  0
                ]);
          $eventpart->save();
          Liveevent::whereId($id)->increment('deniedvolunteers',1);

        }

        //return redirect('/volunteer/notifications')->with('success', 'Denied Successfully!');
       
     	$message = "Denied Successfully!";  
    return response()->json(['message' => $message, 200]);


    }
   ////Login Live Event Checking function for volunteer
   public function getliveeventvolunteerlogincheck($no){
	  $volunteerval = Volunteer::where('mobile', $no)->first(); 
	  if($volunteerval != ''){
      $volunteers_id = $volunteerval->uid;  
	 $live = Liveevent::where('status', 1)->select('id')->first();
          if(isset($live)){
              if($live != ''){

                
                ////commented for testing(start)
                $is_available = Liveeventparticipation::where('events_id', $live->id)
                                        ->where('volunteers_id', $volunteers_id)
                                        ->where('status', 1)
                                        ->count();

                  if($is_available != 0){
                    
					 return response()->json(['status' => 1, 200]);///redirect to embedvideo==return redirect('volunteer/embedvideo');
                  } else {
					  return response()->json(['status' => 0, 200]);///redirect to volunteerlogin==return redirect('/volunteerlogin');
				  }
              }
          } else {
			  return response()->json(['status' => 0, 200]);///redirect to volunteerlogin==return redirect('/volunteerlogin');
		  }
		} else {
			  return response()->json(['status' => 0, 200]);///redirect to volunteerlogin==return redirect('/volunteerlogin');
		  }  
   }
   
   public function getvolunteerpreviousliveevents($no)
    {
      $displayoptions=array();
      
      $volunteerval = Volunteer::where('mobile', $no)->first(); 
	  $volunteers_id = $volunteerval->uid; 


      $embedlogs = DB::table('embedvideologs')->where('volunteers_id',$volunteers_id)->get(); 
      
      if(!$embedlogs->isEmpty())
      { 
        foreach($embedlogs as $embedlogsres) {
          $displayoptions[] = DB::table('liveevents')->whereId($embedlogsres->events_id)->where('status',2)->first();

        }  
        //dd($displayoptions);
      }  
      
		return response()->json(['displayoptions' => $displayoptions, 200]);
      
      
    }
	////New Apis for Live Event Notifications(end)
	

    /// New Apis 25.11.2021(volunteers,beneficiaries,volunteerduties) (start)

    public function getvolunteersdet(){
        $volunteeroptions=array();
        $volunteerval = DB::table('volunteers')->select('mobile','email','firstname','lastname','address','lsg','lsgtype','districts_id','ward')->get();
        if(!$volunteerval->isEmpty())
        { 
            foreach($volunteerval as $volunteervalres) {
                $volunteeroptions[] = array('mobile' => $volunteervalres->mobile, 'email' => $volunteervalres->email, 'firstname' => $volunteervalres->firstname, 'lastname' => $volunteervalres->lastname, 'address' => $volunteervalres->address, 'lsg' => $volunteervalres->lsg, 'lsgtype' => $volunteervalres->lsgtype, 'districts_id' => $volunteervalres->districts_id, 'ward' => $volunteervalres->ward); 

            }  
        //dd($volunteeroptions);
        } 
        return response()->json(['volunteeroptions' => $volunteeroptions, 200]);
        
    }

    public function getbeneficiarydet(){
        $benefoptions=array();
        $benefval = DB::table('beneficiaries')->select('beneficiaryno','districts_id','lsgtype_id','lsg_id','wardno','name','age','categories_id','phoneno','aadharno')->get();
        if(!$benefval->isEmpty())
        { 
            foreach($benefval as $benefvalres) {
                $benefoptions[] = array('beneficiaryno' => $benefvalres->beneficiaryno, 'districts_id' => $benefvalres->districts_id, 'lsgtype' => $benefvalres->lsgtype_id, 'lsg' => $benefvalres->lsg_id, 'ward' => $benefvalres->wardno, 'name' => $benefvalres->name, 'age' => $benefvalres->age, 'categories_id' => $benefvalres->categories_id, 'phoneno' => $benefvalres->phoneno, 'aadharno' => $benefvalres->aadharno); 

            }  
        //dd($volunteeroptions);
        } 
        return response()->json(['benefoptions' => $benefoptions, 200]);
        
    }

    public function getvathilpadivoldet(){
        $vathilpadivoloptions=array();
        $vathilvolval = DB::table('volunteers')
                    ->join('volunteerduties','volunteerduties.volunteers_id','volunteers.id')
                    ->select('volunteers.mobile','volunteers.email','volunteers.firstname','volunteers.lastname','volunteers.address','volunteers.lsg','volunteers.lsgtype','volunteers.districts_id','volunteers.ward')
                    ->where('volunteerduties.duty_id',1)
                    ->get();
        if(!$vathilvolval->isEmpty())
        { 
            foreach($vathilvolval as $vathilvolvalres) {
                $vathilpadivoloptions[] = array('mobile' => $vathilvolvalres->mobile, 'email' => $vathilvolvalres->email, 'firstname' => $vathilvolvalres->firstname, 'lastname' => $vathilvolvalres->lastname, 'address' => $vathilvolvalres->address, 'lsg' => $vathilvolvalres->lsg, 'lsgtype' => $vathilvolvalres->lsgtype, 'districts_id' => $vathilvolvalres->districts_id, 'ward' => $vathilvolvalres->ward); 

            }  
        //dd($volunteeroptions);
        } 
        return response()->json(['vathilpadivoloptions' => $vathilpadivoloptions, 200]);
        
    }

    public function getadhidaridryamvoldet(){
        $adhivoloptions=array();
        $adhivolval = DB::table('volunteers')
                    ->join('volunteerduties','volunteerduties.volunteers_id','volunteers.id')
                    ->select('volunteers.mobile','volunteers.email','volunteers.firstname','volunteers.lastname','volunteers.address','volunteers.lsg','volunteers.lsgtype','volunteers.districts_id','volunteers.ward')
                    ->where('volunteerduties.duty_id',2)
                    ->get();
        if(!$adhivolval->isEmpty())
        { 
            foreach($adhivolval as $adhivolvalres) {
                $adhivoloptions[] = array('mobile' => $adhivolvalres->mobile, 'email' => $adhivolvalres->email, 'firstname' => $adhivolvalres->firstname, 'lastname' => $adhivolvalres->lastname, 'address' => $adhivolvalres->address, 'lsg' => $adhivolvalres->lsg, 'lsgtype' => $adhivolvalres->lsgtype, 'districts_id' => $adhivolvalres->districts_id, 'ward' => $adhivolvalres->ward); 

            }  
        //dd($volunteeroptions);
        } 
        return response()->json(['adhivoloptions' => $adhivoloptions, 200]);
        
    }

    public function getdistricts(Request $request)
    {
            // $encryptedrequestid = 'xbOsLb72OAwWBc1F';
            $encryptedrequestid = $request->token_api;
            $decryption_iv = 'abcklm35620123a1';
             // Store the decryption key
             $decryption_key = "cditAdmin";
             $ciphering = "AES-128-CTR";
             $options = 0;
             
             // Use open_decrypt() function to decrypt the data
             $decryption=openssl_decrypt ($encryptedrequestid, $ciphering,
             $decryption_key, $options, $decryption_iv);
             
              // Display the decrypted string
              if($decryption=='adminNr#12*s'){
                $district = array();
                $districttval = DB::table('districts')->orderBy('id','asc')->get();
                foreach($districttval as $districttvalres) {
                    $district[] = array('id'=>  $districttvalres->id,'name'=> $districttvalres->name);
                }
                return response()->json(['district' => $district, 200]);
              }else{
                return response()->json(['msg_send'=> 'Error!!! Key token mismatch']);
              }

    }


    public function getcategory(Request $request){
            // $encryptedrequestid = 'xbOsLb72OAwWBc1F';
            $encryptedrequestid = $request->token_api;
            $decryption_iv = 'abcklm35620123a1';
             // Store the decryption key
             $decryption_key = "cditAdmin";
             $ciphering = "AES-128-CTR";
             $options = 0;
             
             // Use open_decrypt() function to decrypt the data
             $decryption=openssl_decrypt ($encryptedrequestid, $ciphering,
             $decryption_key, $options, $decryption_iv);
             
              // Display the decrypted string
              if($decryption=='adminNr#12*s'){
                $Category = array();
                $Categoryval = Category::orderBy('id','asc')->get();
                foreach($Categoryval as $Categoryvalres) {
                    $Category[] = array('id'=>  $Categoryvalres->id,'name'=> $Categoryvalres->name);
                }
          
                return response()->json(['Category' => $Category, 200]);
              }else{
                return response()->json(['msg_send'=> 'Error!!! Key token mismatch']);
              }
              
    
      
  }
  public function getlevels(Request $request){
    // dd(true);
          // $encryptedrequestid = 'xbOsLb72OAwWBc1F';
          $encryptedrequestid = $request->token_api;
          $decryption_iv = 'abcklm35620123a1';
           // Store the decryption key
           $decryption_key = "cditAdmin";
           $ciphering = "AES-128-CTR";
           $options = 0;
           
           // Use open_decrypt() function to decrypt the data
           $decryption=openssl_decrypt ($encryptedrequestid, $ciphering,
           $decryption_key, $options, $decryption_iv);
           
            // Display the decrypted string
            if($decryption=='adminNr#12*s'){
                          
              $Level = array();
              $Levelval = Level::orderBy('id','asc')->get();
              foreach($Levelval as $Levelvals) {
                  $Level[] = array('id'=>  $Levelvals->id,'name'=> $Levelvals->name);
              }

              return response()->json(['Level' => $Level, 200]);
            }else{
              return response()->json(['msg_send'=> 'Error!!! Key token mismatch']);
            }

    
}

public function getgender(Request $request){
      // $encryptedrequestid = 'xbOsLb72OAwWBc1F';
      $encryptedrequestid = $request->token_api;
      $decryption_iv = 'abcklm35620123a1';
       // Store the decryption key
       $decryption_key = "cditAdmin";
       $ciphering = "AES-128-CTR";
       $options = 0;
       
       // Use open_decrypt() function to decrypt the data
       $decryption=openssl_decrypt ($encryptedrequestid, $ciphering,
       $decryption_key, $options, $decryption_iv);
       
        // Display the decrypted string
        if($decryption=='adminNr#12*s'){ 
          $gender = array();
  
          $genderval = DB::table('gender')->orderBy('id','asc')->get();
        
          // foreach($genderval as $gendervals) {
          //     $gender[] = array('id'=>  $gendervals->id,'engname'=> $gendervals->engname,'malname'->$gendervals->malname);
          // }
        
          return response()->json(['gender' => $genderval, 200]);
         }else{
          return response()->json(['msg_send'=> 'Error!!! Key token mismatch']);
        }

  
}
public function pincodes(Request $request){
        // $encryptedrequestid = 'xbOsLb72OAwWBc1F';
        $encryptedrequestid = $request->token_api;
        $decryption_iv = 'abcklm35620123a1';
        // Store the decryption key
        $decryption_key = "cditAdmin";
        $ciphering = "AES-128-CTR";
        $options = 0;
        
        // Use open_decrypt() function to decrypt the data
        $decryption=openssl_decrypt ($encryptedrequestid, $ciphering,
        $decryption_key, $options, $decryption_iv);
        
          // Display the decrypted string
        if($decryption=='adminNr#12*s'){
            $pincodes = array();
  
            $pincodeval = DB::table('pincodes')->orderBy('id','asc')->get();
          
            // foreach($genderval as $gendervals) {
            //     $gender[] = array('id'=>  $gendervals->id,'engname'=> $gendervals->engname,'malname'->$gendervals->malname);
            // }
          
            return response()->json(['pincodes' => $pincodeval, 200]);
        }else{
          return response()->json(['msg_send'=> 'Error!!! Key token mismatch']);
        }

  
}
public function wards(Request $request){
// $encryptedrequestid = 'xbOsLb72OAwWBc1F';
$encryptedrequestid = $request->token_api;
$decryption_iv = 'abcklm35620123a1';
 // Store the decryption key
 $decryption_key = "cditAdmin";
 $ciphering = "AES-128-CTR";
 $options = 0;
 
 // Use open_decrypt() function to decrypt the data
 $decryption=openssl_decrypt ($encryptedrequestid, $ciphering,
 $decryption_key, $options, $decryption_iv);
 
  // Display the decrypted string
  if($decryption=='adminNr#12*s'){
    $wards = array();
  
    $wardsval = DB::table('wards')->orderBy('id','asc')->get();
  
    // foreach($genderval as $gendervals) {
    //     $gender[] = array('id'=>  $gendervals->id,'engname'=> $gendervals->engname,'malname'->$gendervals->malname);
    // }
  
    return response()->json(['wards' => $wardsval, 200]);
  }else{
    return response()->json(['msg_send'=> 'Error!!! Key token mismatch']);
  }
 
  
}
public function bloodgroups(Request $request){
      // $encryptedrequestid = 'xbOsLb72OAwWBc1F';
      $encryptedrequestid = $request->token_api;
      $decryption_iv = 'abcklm35620123a1';
       // Store the decryption key
       $decryption_key = "cditAdmin";
       $ciphering = "AES-128-CTR";
       $options = 0;
       
       // Use open_decrypt() function to decrypt the data
       $decryption=openssl_decrypt ($encryptedrequestid, $ciphering,
       $decryption_key, $options, $decryption_iv);
       
        // Display the decrypted string
        if($decryption=='adminNr#12*s'){
          $bloodgroups = array();
  
          $bloodgroupsval = DB::table('bloodgroups')->orderBy('id','asc')->get();
        
          return response()->json(['bloodgroups' => $bloodgroupsval, 200]);
        }else{
          return response()->json(['msg_send'=> 'Error!!! Key token mismatch']);
        }

  
}
public function activitytypes(Request $request){
      // $encryptedrequestid = 'xbOsLb72OAwWBc1F';
      $encryptedrequestid = $request->token_api;
      $decryption_iv = 'abcklm35620123a1';
       // Store the decryption key
       $decryption_key = "cditAdmin";
       $ciphering = "AES-128-CTR";
       $options = 0;
       
       // Use open_decrypt() function to decrypt the data
       $decryption=openssl_decrypt ($encryptedrequestid, $ciphering,
       $decryption_key, $options, $decryption_iv);
       
        // Display the decrypted string
        if($decryption=='adminNr#12*s'){
          $activitytypes = array();
  
          $activitytypesval = DB::table('activitytypes')->orderBy('id','asc')->get();
        
          return response()->json(['activitytypes' => $activitytypesval, 200]);
        }else{
          return response()->json(['msg_send'=> 'Error!!! Key token mismatch']);
        }
 
  
}
public function activities(Request $request){
      // $encryptedrequestid = 'xbOsLb72OAwWBc1F';
      $encryptedrequestid = $request->token_api;
      $decryption_iv = 'abcklm35620123a1';
       // Store the decryption key
       $decryption_key = "cditAdmin";
       $ciphering = "AES-128-CTR";
       $options = 0;
       
       // Use open_decrypt() function to decrypt the data
       $decryption=openssl_decrypt ($encryptedrequestid, $ciphering,
       $decryption_key, $options, $decryption_iv);
       
        // Display the decrypted string
        if($decryption=='adminNr#12*s'){
          $activitiess = array();
  
          $activitiesval = DB::table('activities')->orderBy('id','asc')->get();
        
          return response()->json(['activities' => $activitiesval, 200]);
        }else{
          return response()->json(['msg_send'=> 'Error!!! Key token mismatch']);
        }

  
}
    public function getlsgtype(Request $request){
        // $encryptedrequestid = 'xbOsLb72OAwWBc1F';
        $encryptedrequestid = $request->token_api;
        $decryption_iv = 'abcklm35620123a1';
         // Store the decryption key
         $decryption_key = "cditAdmin";
         $ciphering = "AES-128-CTR";
         $options = 0;
         
         // Use open_decrypt() function to decrypt the data
         $decryption=openssl_decrypt ($encryptedrequestid, $ciphering,
         $decryption_key, $options, $decryption_iv);
         
          // Display the decrypted string
          if($decryption=='adminNr#12*s'){
            $lsgtype = array();
            $lsgtypeval = DB::table('lsgtype')->orderBy('id','asc')->get();
            foreach($lsgtypeval as $lsgtypevalres) {
                $lsgtype[] = array('id'=>  $lsgtypevalres->id,'name'=> $lsgtypevalres->name);
            }
    
            return response()->json(['lsgtype' => $lsgtype, 200]);
            
          }else{
            return response()->json(['msg_send'=> 'Error!!! Key token mismatch']);
          }
       
    }

    public function getlsg(Request $request){

          // $encryptedrequestid = 'xbOsLb72OAwWBc1F';
      $encryptedrequestid = $request->token_api;
      $decryption_iv = 'abcklm35620123a1';
       // Store the decryption key
       $decryption_key = "cditAdmin";
       $ciphering = "AES-128-CTR";
       $options = 0;
       
       // Use open_decrypt() function to decrypt the data
       $decryption=openssl_decrypt ($encryptedrequestid, $ciphering,
       $decryption_key, $options, $decryption_iv);
       
        // Display the decrypted string
        if($decryption=='adminNr#12*s'){
          $lsg = array();
          $lsgval = DB::table('lsg')->get();
          foreach($lsgval as $lsgvalres) {
              $lsg[] = array('id'=>  $lsgvalres->intLBID,'code'=> $lsgvalres->vchLBCode,'name'=> $lsgvalres->vchLBName, 'lsgtype_id'=> $lsgvalres->tnyLBTypeID,'district_id'=> $lsgvalres->intDistrictID);
          }
 
          return response()->json(['lsg' => $lsg, 200]);
        }else{
          return response()->json(['msg_send'=> 'Error!!! Key token mismatch']);
        }
    }

    public function getbenefcategory(){
        $benfcatgoptions = array();
        $benefcatgval = DB::table('beneficiarycategories')->orderBy('id','asc')->get();
        foreach($benefcatgval as $benefcatgvalres) {
            $benfcatgoptions[] = array('id'=>  $benefcatgvalres->id,'name'=> $benefcatgvalres->name);
        }

        return response()->json(['benfcatgoptions' => $benfcatgoptions, 200]);
        
    }

    // new volunteerlogin blade 29.01.2022

    public function getnewvolunteerlogin($no){

        $pwdresetflag = User::where('email',$no)->where('password_reset','>', 0)->exists() ? 1 : 0;
        $volunteerval = Volunteer::where('mobile', $no)->first(); 
        if($volunteerval != ''){
            $volunteers_id = $volunteerval->uid;  
            //new active status
            $volactstatus = $volunteerval->voluntary_activestatus;
            $phonestatus = $volunteerval->phonestatus;
            $wardno = $volunteerval->ward;

            $edn = DB::table('volunteerqualifications')->where('qualificationtypes_id',2)->where('volunteers_id',$volunteers_id)->select('qualifications_id')->first();
            if(($edn!='')||($edn!=NULL)){
                $ednval = $edn->qualifications_id;
            } else {
                $ednval=0;
            }
            $catg = Category::where('id','=', $volunteerval->categories_id)->first();

            $specialflagexist = Category::where('specialflag', 1)->where('id','=', $volunteerval->categories_id)->exists() ? 1 : 0 ;
            if($specialflagexist==1){
                //$specialflag = Category::where('specialflag', 1)->get();
                $specialflag = Category::where('id','=', $volunteerval->categories_id)->get();
            } else{
                //$specialflag = array();
                $specialflag = Category::where('specialflag', 0)->where('id','=', $volunteerval->categories_id)->get();
            }

            $dob = Carbon::parse($volunteerval->dob)->year;
            $newdob = $dob."-01-01";
            $criteria = Carbon::parse($newdob)->age;

            if($criteria >= 20 && $criteria <=40)
            {
                $surveyexist = Survey::where('status',1)->exists() ? 1 : 0;
                if($surveyexist==1){
                    $surveyflag = Survey::where('status',1)->get();
                } else{
                    $surveyflag = array();
                }
            }
            else
            $surveyflag = array();

            $activeevent = DB::table('liveevents')
            ->join('liveeventparticipations', 'liveeventparticipations.events_id', '=', 'liveevents.id')
            ->where('liveevents.status', '=', 1)//ongoing events
            ->where('liveeventparticipations.volunteers_id', '=', $volunteerval->uid)
            ->select('liveevents.id', 'liveevents.name')
            ->get();  
            $activeeventcount =count($activeevent);//dd($activeeventcount);

            if($criteria >= 18 && $criteria <=50 && $ednval>=4)
            {
                $vathilpadi=1;
            } else {
                $vathilpadi=0;
            }

            if($criteria >= 18 && $criteria <=50 && $ednval>4 && $phonestatus==1)
            {
                $extremepoverty=1;
            } else {
                $extremepoverty=0;
            }

            if($volunteerval->criminalcase==0){
                $criminal=0;
            }else if(($volunteerval->criminalcase==1)&&($volunteerval->criminalcasedetails==NULL)){
                $criminal=1;
            }else if(($volunteerval->criminalcase==1)&&($volunteerval->criminalcasedetails!=NULL)){
                $criminal=2;
            }
        
            if($volunteerval->sssstatus==0){
                $sss=0;
            }else if(($volunteerval->sssstatus==1)&&($volunteerval->sssdetails==NULL)){
                $sss=1;
            }else if(($volunteerval->sssstatus==1)&&($volunteerval->sssdetails!=NULL)){
                $sss=2;
            }

            if(($volunteerval->address!=NULL)&&($volunteerval->presentaddress!=NULL))
            { 
                if(($volunteerval->ward!=0)&&($volunteerval->presentward!=0))
                {
                    if(($volunteerval->idcardno!=NULL)&&($volunteerval->idcard!=NULL))
                    {
                        if(($volunteerval->sixmonthstatus==1)&&($criminal==0)&&($volunteerval->interestedwards!=NULL)){
                            $apply=1;
                        } else {
                            $apply=0;
                        }
                    } else {
                            $apply=0;
                    }
                } else {
                            $apply=0;
                }
                
            } else {
                $apply=0;
            }

            $benflist = DB::table('beneficiaries')->where('wardno',$wardno)->where('status',1)->get();
            return response()->json(['specialflag' => $specialflag, 'surveyflag' => $surveyflag, 'pwdresetflag' => $pwdresetflag, 'activeeventcount' => $activeeventcount, 'vathilpadi' => $vathilpadi, 'apply' => $apply, 'volactstatus' => $volactstatus, 'extremepoverty' => $extremepoverty, 'benflist' => $benflist, 200]);
        }
         
    }

    //survey response

    public function getvolunteerloginsurvey($no,$val){ 
        $volunteerval = Volunteer::where('mobile', $no)->first(); 
        if($volunteerval != ''){
            $volunteers_id = $volunteerval->uid;
            $formdata = array(
            'voluntary_activestatus' => $val,
            'voluntary_active_ts' => date('Y-m-d H:i:s')
            );

            $updatestatus = Volunteer::where('uid',$volunteers_id)->update($formdata);
            $message = "Updated Successfully!";  
            return response()->json(['message' => $message, 200]);
        } else {
            $message = "Error in updation!";
            return response()->json(['message' => $message, 404]);
        }
        
       
        


    }

    //vathilpadisevanam

    public function getvathilpadisevanam($no){

     $volunteerval = Volunteer::where('mobile', $no)->first(); 
        if($volunteerval != ''){
            $volunteers_id = $volunteerval->uid;
            $listdata = Volunteer::where('uid',$volunteers_id)->select('id','email','mobile','districts_id','presentdistricts_id','address','presentaddress','lsg','presentlsg','lsgtype','presentlsgtype','pincodes_id','presentpincodes_id','ward','presentward','dob','photograph','idcard','sixmonthstatus','disabled','disabledcert','criminalcase','criminalcasedetails','interestedwards','sssstatus','sssdetails','phonestatus','vehiclestatus','vehicles','doorstepstatus')->first();
            $district = DB::table('districts')->orderBy('id','asc')->get();
            $lsgtype = DB::table('lsgtype')->whereIn('id', [3, 4, 5])->orderBy('id','asc')->get();
            $pincode = DB::table('pincodes')->get();
            $vollsg = DB::table('lsg')->where('intLBID',$listdata->lsg)->first();
            $lsg = DB::table('lsg')->orderBy('intLBID','asc')->get();
            $volvathilpadi = DB::table('volunteerduties')->where('volunteers_id',$listdata->id)->where('duty_id',1)->count();
            if($volvathilpadi>0){
                $doorstepstatus=1;
            } else{
                $doorstepstatus=0;
            }

              
            return response()->json(['listdata' => $listdata, 'district' => $district, 'lsgtype' => $lsgtype, 'vollsg' => $vollsg, 'pincode' => $pincode, 'lsg' => $lsg, 'doorstepstatus' => $doorstepstatus, 200]);
        }   

    }

    //Absolute Poverty Survey

    public function getabsolutepovertysurvey($no){

     $volunteerval = Volunteer::where('mobile', $no)->first(); 
        if($volunteerval != ''){
            $volunteers_id = $volunteerval->uid;
            $listdata = Volunteer::where('uid',$volunteers_id)->select('id','email','mobile','districts_id','presentdistricts_id','address','presentaddress','lsg','presentlsg','lsgtype','presentlsgtype','pincodes_id','presentpincodes_id','ward','presentward','dob','photograph','idcard','sixmonthstatus','disabled','disabledcert','criminalcase','criminalcasedetails','interestedwards','sssstatus','sssdetails','phonestatus','vehiclestatus','vehicles','doorstepstatus','bloodgroups_id')->first();
            $district = DB::table('districts')->orderBy('id','asc')->get();
            $lsgtype = DB::table('lsgtype')->whereIn('id', [3, 4, 5])->orderBy('id','asc')->get();
            $pincode = DB::table('pincodes')->get();
            $vollsg = DB::table('lsg')->where('intLBID',$listdata->lsg)->first();
            $lsg = DB::table('lsg')->orderBy('intLBID','asc')->get();
            
            $bloodgroup = DB::table('bloodgroups')->get();
            $volextpverty = DB::table('volunteerduties')->where('volunteers_id',$listdata->id)->where('duty_id',2)->count();
            if($volextpverty>0){
                $extpoverty=1;
            } else{
                $extpoverty=0;
            }
            $edn = DB::table('volunteerqualifications')->where('qualificationtypes_id',2)->where('volunteers_id',$volunteers_id)->select('qualifications_id')->first();
            $qual = DB::table('qualifications')->where('qualificationtypes_id',2)->select('id','name')->get();
            
            return response()->json(['listdata' => $listdata, 'district' => $district, 'lsgtype' => $lsgtype, 'vollsg' => $vollsg, 'pincode' => $pincode, 'lsg' => $lsg, 'extpoverty' => $extpoverty, 'bloodgroup' => $bloodgroup, 'edn' => $edn, 'qual' => $qual, 200]);
        }   

    }

    //Beneficiary List

    public function getbeneflist($no){

     $volunteerval = Volunteer::where('mobile', $no)->first(); 
        if($volunteerval != ''){
            $volunteers_id = $volunteerval->uid;
            $wardno = $volunteerval->ward;
            $benflist = DB::table('beneficiaries')
            ->join('districts','districts.id','beneficiaries.districts_id')
            ->join('lsgtype','lsgtype.id','beneficiaries.lsgtype_id')
            ->join('lsg','lsg.intLBID','beneficiaries.lsg_id')
            ->join('beneficiarycategories','beneficiarycategories.id','beneficiaries.categories_id')
            ->select('beneficiaries.id','beneficiaries.beneficiaryno','beneficiaries.wardno','beneficiaries.name','beneficiaries.age','beneficiaries.phoneno','beneficiaries.aadharno','districts.name as district','lsgtype.name as lsgtype','lsg.vchLBName as lsg','beneficiarycategories.name as category')
            ->where('beneficiaries.wardno',$wardno)->where('beneficiaries.status',1)->get();
            
            return response()->json(['benflist' => $benflist, 200]);
        }   

    }

    //Service List

    public function getservicelist($no){

     $volunteerval = Volunteer::where('mobile', $no)->first(); 
        if($volunteerval != ''){
            $volunteers_id = $volunteerval->uid;
            $listdata = DB::table('services')
            ->select('id','name')
            ->where('status',1)
            ->get();
            
            return response()->json(['listdata' => $listdata, 200]);
        }   

    }

    //provide service List

    public function getprovideservicelist($no){

     $volunteerval = Volunteer::where('mobile', $no)->first(); 
        if($volunteerval != ''){
            $volunteers_id = $volunteerval->uid;
            $serviceavailed= DB::table('volunteeravailedservices')
            ->join('beneficiaries','beneficiaries.id','volunteeravailedservices.beneficiary_id')
            ->join('services','services.id','volunteeravailedservices.service_id')
            ->join('servicestatus','servicestatus.id','volunteeravailedservices.status_id')
            ->select('volunteeravailedservices.id','beneficiaries.name as beneficiary','beneficiaries.beneficiaryno as beneficiaryno','services.name as service','volunteeravailedservices.referenceno','volunteeravailedservices.requested_ts','servicestatus.name as status')
            ->where('volunteeravailedservices.volunteers_id',$volunteers_id)->get();

            return response()->json(['serviceavailed' => $serviceavailed, 200]);
        }   

    }

    //Avail service 

    public function getavailservice($no){

     $volunteerval = Volunteer::where('mobile', $no)->first(); 
        if($volunteerval != ''){
            $volunteers_id = $volunteerval->uid;
            $wardno = $volunteerval->ward;
            $benef = DB::table('beneficiaries')->where('wardno',$wardno)->where('status',1)->get();
            $serv = DB::table('services')->select('id','name')->where('status',1)->get();
            $servicestatus = DB::table('servicestatus')->where('status',1)->get();
            return response()->json(['beneficiary' => $benef, 'services' => $serv,'servicestatus'=>$servicestatus, 200]);
        }   

    }

    //volu submt
//     public function volunteersubmit(Request $request)
//     {

//             $request->validate([
//             'firstname' => 'required',
//             'lastname' => 'required',
//             'mobile' => 'required|numeric',
//             'districts_id' => 'required|numeric',
//             // 'checkotp' => 'required',
//             // 'checkotptime' => 'required',
//             // 'newpassword' => 'required',
//             // 'confirmpassword' => 'required',
//             // 'lsgtype' => 'required',
//             // 'lsg' => 'required',
//             // 'fireBaseId'=>'required'
           
     
//         ]);
        
//         // DB::beginTransaction();
// dd(true);
//         try {
//               $fullname = $request->firstname." ".$request->lastname;
//               $mobilenumber = $request->mobile;
//               $fireBaseId = $request->fireBaseId;
//               if(isset($request->palliativestatus)){$palliativestatus=1;} else{$palliativestatus=0;}
//               $formdata = array(
//                 'firstname' => $request->firstname,
//                 'lastname' => $request->lastname,
//                 'mobile' => $mobilenumber,
//                 'uniqid' => $mobilenumber,
//                 'email' => $request->email,
//                 'districts_id' => $request->district,
//                 'lsgtype' => $request->lsgtype,
//                 'lsg' => $request->lsg,
//                 // 'otp' => $request->checkotp,
//                 'otp' =>5432,
//                 'otptimestamp' => 0,
//                 'categories_id' => 1,
//                 'status' => 1,
//                 'palliativestatus' => $palliativestatus,
//                 'fireBaseId'=>$fireBaseId,
//                 'mobile_api'  =>1

//             ); 
// dd($formdata);
//              $volunteerdet = Volunteer::firstOrCreate($formdata);

           
             
//              $fullname = $request->firstname." ".$request->lastname; 
//              //$givenpassword = '123';
//              $givenpassword = $request->newpassword;
//              $formdata7 = array(
//                 'uid' => $request->mobile,
//                 'name' => $fullname,
//                 'usertypes_id' => 4,
//                 'email' => $request->email,
//                 'password' => Hash::make($givenpassword),
//              );

//               $userdata = User::create($formdata7);

//               if(isset($userdata)){

//               $updatevolunteer = Volunteer::whereId($volunteerdet->id)->update(['uid' => $userdata->id]);
//               // DB::commit();
//              return response()->json(['mobilenumber' => $mobilenumber,'fullname' => $fullname, 200]);
//            } else {
//             DB::rollback();
//             return response()->json(['error'=>'Not updated.error found']);
//            }
//        }catch (\Exception $e) {
//           // DB::rollback();
//           return response()->json(['error'=>'Not updated.error found']);
//     // something went wrong
// }

               
//     } 
    public function volunteersubmit(Request $request)
    {
     
        $rules = [
          'firstname' => 'required',
          'lastname' => 'required',
          'mobile' => 'required|numeric',
          'district' => 'required',
          'checkotp' => 'required',
          'checkotptime' => 'required',
          'newpassword' => 'required',
          'confirmpassword' => 'required',
          'lsgtype' => 'required',
          'lsg' => 'required',  
          'email' => 'required',  
      ];

      // Create a validator instance
      $validator = Validator::make($request->all(), $rules);
     
      // Check if validation fails
      if ($validator->fails()) {
          // Return a JSON response with validation errors
          return response()->json([
              'message' => 'Validation error',
              'errors' => $validator->errors(),
          ], 422);
      }
        DB::beginTransaction();

          $mobilenumber = $request->mobile;
          $checkvolunteerexist = Volunteer::where('mobile',$mobilenumber)->where('status',1)->exists() ? 1 : 0;

          if($checkvolunteerexist==0)
          {
            try {
                $fullname = $request->firstname." ".$request->lastname;
               
                if(isset($request->palliativestatus)){$palliativestatus=1;} else{$palliativestatus=0;}
                if($palliativestatus==1){
                  $palliative_catg = $request->palliative_catg;
                } else {
                  $palliative_catg = 0;
                }
                $formdata = array(
                  'firstname' => $request->firstname,
                  'lastname' => $request->lastname,
                  'mobile' => $mobilenumber,
                  'uniqid' => $mobilenumber,
                  'email' => $request->email,
                  'districts_id' => $request->district,
                  'lsgtype' => $request->lsgtype,
                  'lsg' => $request->lsg,
                  'otp' => $request->checkotp,
                  'otptimestamp' => $request->checkotptime,
                  'categories_id' => 1,
                  'status' => 1,
                  'palliativestatus' => $palliativestatus,
                  'palliative_catg' => $palliative_catg,
              ); 
             
              $volunteerdet = Volunteer::firstOrCreate($formdata);     
            
              $fullname = $request->firstname." ".$request->lastname; 
              //$givenpassword = '123';
              $givenpassword = $request->newpassword;
              $formdataa = array(
                  'uid' => $request->mobile,
                  'name' => $fullname,
                  'usertypes_id' => 4,
                  'email' => $mobilenumber,
                  'password' => Hash::make($givenpassword),
              );
            
                $userdata = User::create($formdataa);
                
                if(isset($userdata)){

                $updatevolunteer = Volunteer::whereId($volunteerdet->id)->update(['uid' => $userdata->id]);
                    DB::commit();
                    return response()->json(['mobilenumber' => $mobilenumber,'fullname' => $fullname,'msg'=>'created']);
                  } else {
                    return response()->json(['error'=>'Not updated.error found']);
                  }
              }catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            }
          }else{
            return response()->json(['error'=>'same mobilen number exist']);
          }
             

    }
        
    public function generatevolunteerpwd($mob,Request $request)
    {
   
        $mobilenumber = $mob;
        $checkvolunteerexist = Volunteer::where('mobile',$mobilenumber)->where('status',1)->exists() ? 1 : 0;
        
        $volidd = Volunteer::where('mobile', $mobilenumber)->first(); 
        
        $TokenRecvd =$request->token_api;
        $encryptedtoken = $volidd->token_api;
    
        if($encryptedtoken == $TokenRecvd)
        {
          if($checkvolunteerexist==1){
            //$givenpassword =  app('App\Http\Controllers\BaseController')->passcode();
            $givenpassword =  app('App\Http\Controllers\BaseController')->passcodenew();
            
            $pwdtimestamp = Carbon::now();
            // dd(Hash::make($givenpassword));
            $form_data = array(
                'password' => Hash::make($givenpassword),
                'passwordtimestamp' => $pwdtimestamp
            );
            
            $flagvalue=1;
            User::where('email',$mobilenumber)->update($form_data);
            /* -------------------------------------------- Send Custom SMS (start) --------------------------------- */
            $message = "Password for login to SSSena Sannadhasena Portal is ".$givenpassword;
            $number = $mobilenumber;
            $link = curl_init();
            curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=sannadham-portal&password=Sann@1234&message=".$message."&numbers=".$number."&senderid=SSSENA");
            curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($link , CURLOPT_HEADER, 0);
            curl_exec($link);
            curl_close($link );
         /* -------------------------------------------- Send Custom SMS (end) --------------------------------- */
        }else {
            $flagvalue=0;
        }
        return response()->json(['flagvalue' => $flagvalue]);
        }else{
          return response()->json(['error' => 'Unauthorized'], 401);
        }
 
       
    }
    public function getTopSocialCreadits(Request $request)
    {
           // $encryptedrequestid = 'xbOsLb72OAwWBc1F';
      $encryptedrequestid = $request->token_api;
      $decryption_iv = 'abcklm35620123a1';
       // Store the decryption key
       $decryption_key = "cditAdmin";
       $ciphering = "AES-128-CTR";
       $options = 0;
       
       // Use open_decrypt() function to decrypt the data
       $decryption=openssl_decrypt ($encryptedrequestid, $ciphering,
       $decryption_key, $options, $decryption_iv);
   
        // Display the decrypted string
        if($decryption=='adminNr#12*s'){
          $checkvolunteerexist = Volunteer::orderByDesc('SocialCredits')
        ->take(3) // Adjust the number according to your needs
        ->get();
        // $base64dataphoto  = array();
        $base64dataphotodetails = array();
       
        foreach($checkvolunteerexist as $checkvolunteerexists)
        {
          $volunteerId        =  $checkvolunteerexists->id;
          if(isset($checkvolunteerexists->photograph)){
            $userphoto          =  $checkvolunteerexists->photograph;
            $path               =  public_path().'/profile/'.$userphoto;
            $userphotoencode    =  file_get_contents($path);
            $base64dataphoto  =  base64_encode($userphotoencode);
          }else{
            $base64dataphoto = 'No image added';
          }
           $base64dataphotodetails[] =  array('volunteerId'=>$volunteerId,'base64dataphoto'=>$base64dataphoto);
        }
       
        if($checkvolunteerexist){    
          return response()->json(['volunteerdetails' => $checkvolunteerexist,'base64dataphoto'=>$base64dataphotodetails]);
        }
        return response()->json(['error' => 'No data found']);
        }else{
          return response()->json(['msg_send'=> 'Error!!! Key token mismatch']);
        }
        
    }

    public function skillmaster(Request $request)
    {

      // $skillmaster = DB::table('skillcategories')
      //                   ->join('skillsmasters','skillsmasters.category_id','skillcategories.id')
      //                   ->orderBy('skillcategories.id','asc')->get();
           // $encryptedrequestid = 'xbOsLb72OAwWBc1F';
           $encryptedrequestid = $request->token_api;
           $decryption_iv = 'abcklm35620123a1';
            // Store the decryption key
            $decryption_key = "cditAdmin";
            $ciphering = "AES-128-CTR";
            $options = 0;
            
            // Use open_decrypt() function to decrypt the data
            $decryption=openssl_decrypt ($encryptedrequestid, $ciphering,
            $decryption_key, $options, $decryption_iv);
            
             // Display the decrypted string
             if($decryption=='adminNr#12*s'){
              $skillmaster = SkillCategory::with('skill')->get();

              return response()->json(['skillmaster' => $skillmaster, 200]);
             }else{
              return response()->json(['msg_send'=> 'Error!!! Key token mismatch']);
            }
   
    }

     //certificate list
     public function volunteercertificatelist(Request $request,$mob)
     {
   
       $displayoptions=array();
      
       $volidd = Volunteer::where('mobile', $mob)->first(); 

       $TokenRecvd =$request->token_api;
       $encryptedtoken = $volidd->token_api;

       if($encryptedtoken == $TokenRecvd)
       {

        $volid = $volidd->uid;//uid
 
        $eventdata = DB::table('liveexternalevents')->where('status',0)->get();
    
          foreach($eventdata as $eventres1){
            $id = $eventres1->id;
            $name = $eventres1->name;
        
            $liveeventexist = DB::table('liveexteventparticipations')->where('volunteers_id',$volidd->id)->where('events_id',$id)->where('status',2)->exists() ? 1 : 0;
        
            if($liveeventexist==1){
              $getvolunteercertf = DB::table('volunteerextcertificates')->where('events_id',$id)->where('volunteers_id',$volid)->count();
      
              if($getvolunteercertf>0){
                $printed=1;
                $copiescnt=$getvolunteercertf;
              } else {
                $printed=0;
                $copiescnt=0;
              }
              $listdata= DB::table('volunteers')
              ->join('districts','districts.id','volunteers.districts_id')
              ->where('uid',$volid)
              ->select('volunteers.firstname as fname','volunteers.lastname as lname','volunteers.mobile','districts.name as district')
              ->first();
              $volname = $listdata->fname.' '.$listdata->lname;

            $displayoptions[]=array('eventid' => $id, 'event' => $name,'volname' => $volname, 'uid' => $volid, 'rate' => '', 'printed' => $printed,'copiescnt' =>$copiescnt);
            }
          }
       return response()->json(['displayoptions' => $displayoptions, 200]);
     }else{
      return response()->json(['error' => 'Unauthorized'], 401);
    }
  }
 //certificate with parameter
 public function extgenerateCertificatePDFWdata(Request $request)
 {

      try {
        $validatedData = $request->validate([
          'volid'          => 'required',
          'voluid'          => 'required',
          'volname'         => 'required|string|max:255',
          'eventid'         => 'required',
          'eventname'       => 'required',
          'organizer'       => 'required',
          'asstorganizer'   => 'nullable',
          'eventdate'      => 'required'
        ]); 

        $date=date('d/m/Y');
        $volidd = Volunteer::where('uid', $request->voluid)->first(); 

        $TokenRecvd =$request->token_api;
        $encryptedtoken = $volidd->token_api;

        if($encryptedtoken == $TokenRecvd)
        {
          //designed certificate picture
          
          $image =public_path('certificate/extcertificateinput1.png');
          $cerimageencode    =  file_get_contents($image);
          $base64datacerttemp  =  base64_encode($cerimageencode); // certificate picture bas 64 converstn

          $imagesign =public_path('certificate/extcertificateinputsign.png');
          $signimageencode    =  file_get_contents($imagesign);
          $base64datasign  =  base64_encode($signimageencode); // sign picture bas 64 converstn
          
          $createimgsign = imagecreatefrompng($imagesign);
          imagesavealpha($createimgsign, true);

          $createimage = imagecreatefrompng($image);
          $filedate=date('dmY');
          $filename = "extcertificate_".$request->volid."_".$request->eventid."_".$filedate.".png";
          
          //this is going to be created once the generate button is clicked
          $output = public_path('certificate/'.$filename);
          // $outputimageencode    =  file_get_contents($output);
          // $base64dataoutput  =  base64_encode($outputimageencode); // Output picture bas 64 converstn
         
          //then we make use of the imagecolorallocate inbuilt php function which i used to set color to the text we are displaying on the image in RGB format
          $blue = imagecolorallocate($createimage, 32, 55, 1);

          //Then we make use of the angle since we will also make use of it when calling the imagettftext function below
          $rotation = 0;

          //we then set the x and y axis to fix the position of our text name

          if(($request->asstorganizer) === null)
          {
    
            // The input named 'input_name' is either not present or empty
            $certificate_text = "For participating in '".$request->eventname."' organized by Samoohika Sannadhasena, Government of Kerala on ".$request->eventdate."." ;    
            $lines = explode("\n", wordwrap($certificate_text, 70));
            $line1 = $lines[0];
            $line2 = $lines[1];
            $line3 = '';

          } else {
           
            // The input named 'input_name' is present and not empty
            $certificate_text = "For participating in '".$request->eventname."' organized by Samoohika Sannadhasena, Government of Kerala in association with the ".$request->district." District Administration on ".$request->eventdate."." ;
            $lines = explode("\n", wordwrap($certificate_text, 70));
            $line1 = $lines[0];
            $line2 = $lines[1];
            $line3 = $lines[2];
          }
       
          //font directory for name
          $drFont = public_path('font/arial.ttf');

          $origin_x = 580;
          $origin_y=600;
          
          $font_size = 50;#00053c
          $font_size1 = 30;#00053c
          $volname = $request->volname;
          //function to display name on certificate picture
          $text1 = imagettftext($createimage, $font_size, $rotation, $origin_x, $origin_y, $blue, $drFont, $volname);
          
          $origin_yy=700;

          $text5 = imagettftext($createimage, $font_size1, $rotation, $origin_x, $origin_yy, $blue, $drFont, $line1);

          $origin_yyy=760;

          $text6 = imagettftext($createimage, $font_size1, $rotation, $origin_x, $origin_yyy, $blue, $drFont, $line2);

          $origin_yyy=820;

          $text7 = imagettftext($createimage, $font_size1, $rotation, $origin_x, $origin_yyy, $blue, $drFont, $line3);

          $origin_x2 = 850;
          $origin_y2=1720;
         
          //$certificate_text1 = "Your willingness to prepare and plan for protecting the society is appreciated." ;
          

          //$text2 = imagettftext($createimage, $font_size, $rotation, $origin_x2, $origin_y2, $blue, $drFont, $certificate_text1);

          

          /*$origin_x3 = 540;
          $origin_y1=1815;

          $certificate_text2 = " the community.";

          $text3 = imagettftext($createimage, $font_size, $rotation, $origin_x3, $origin_y1, $blue, $drFont, $certificate_text2);*/

          $origin_x1 = 700;
          $origin_y3=2075;
          
          $font_size1 = 37;#00053c
          
          $certificate_text3 = $date;
          $text4 = imagettftext($createimage, $font_size1, $rotation, $origin_x1, $origin_y3, $blue, $drFont, $certificate_text3);

          $origin_x4 = 1670;
          $origin_y4=1900;
          
          $font_size1 = 37;#00053c
        
          // imagecopymerge($createimage, $createimgsign, $origin_x4, $origin_y4, 0, 0, 700, 170, 60);
          // $result = imagepng($createimage,$output,3);
          //       // $outputimageencode    =  file_get_contents($output);
          // // $base64dataoutput  =  base64_encode($outputimageencode); // Output picture bas 64 converstn
       
          // header("Content-type: image/png");
          // imagepng($createimage);
          // Create an output buffer to capture the image data
ob_start();
// Output the image to the buffer
imagepng($createimage);
// Get the contents of the output buffer
$imageData = ob_get_clean();

// Encode the image data to base64
$base64dataoutput = base64_encode($imageData);

// Now $base64Image contains the base64-encoded representation of the image


        $response=array();
          if(isset($base64dataoutput)){
            $insert_data = array(
              'volunteers_id' =>$request->voluid,
              'events_id' =>$request->eventid,
              'date' => date('Y-m-d'),
              'entereduserid' =>$request->voluid,
            );
          
            $res = DB::table('volunteerextcertificates')->insert($insert_data);
          }
        //  dd($base64dataoutput);
          $response = [
            'success' => true,
            'certificate' => $base64dataoutput, // Base64-encoded certificate image
            'insert_data' => $insert_data,
        ];
    
          return response()->json($response, 200);





        }else{
          return response()->json(['error' => 'Unauthorized'], 401);
        }
   

      } catch (ModelNotFoundException $e) {
          // Handle model not found exception
          return response()->json(['error' => 'User not found'], 404);
      } catch (ValidationException $e) {
          // Handle validation exception
          return response()->json(['error' => 'Validation failed'], 422);
      } catch (Exception $e) {
          // Catch any other exceptions
          return response()->json(['error' => 'Something went wrong'], 500);
      }
 }
  //certificate PDF download
  public function extgenerateCertificatePDF($eventid,$volid)
  {
    $date=date('d/m/Y');
  
    $listdata= DB::table('volunteers')
              ->join('districts','districts.id','volunteers.districts_id')
              ->where('uid',$volid)
              ->select('volunteers.firstname as fname','volunteers.lastname as lname','volunteers.mobile','districts.name as district')
              ->first();
                     
    $volname = $listdata->fname.' '.$listdata->lname;
    
    $mobile = $listdata->mobile;
  
    $district = $listdata->district;
   
    $listevent= DB::table('liveexternalevents')
                  ->join('districts','districts.id','liveexternalevents.districtid')
                  ->where('liveexternalevents.id',$eventid)
                  ->select('liveexternalevents.name','liveexternalevents.startdate','districts.name as district')
                  ->first();
                      
    $event = $listevent->name;
    
    $district = $listevent->district;
    
    //$eventdate = date('dth M Y', strtotime($listevent->startdate));
    $eventdate = date('jS F Y', strtotime($listevent->startdate));

    /*$name = strtoupper($_POST['name']);*/
        
   //designed certificate picture
          
          $image =public_path('certificate/extcertificateinput1.png');
          $cerimageencode    =  file_get_contents($image);
          $base64datacerttemp  =  base64_encode($cerimageencode); // certificate picture bas 64 converstn

          $imagesign =public_path('certificate/extcertificateinputsign.png');
    
          $signimageencode    =  file_get_contents($imagesign);
          $base64datasign  =  base64_encode($signimageencode); // sign picture bas 64 converstn

          $createimgsign = imagecreatefrompng($imagesign);
          imagesavealpha($createimgsign, true);

         // $image =public_path('login_img/certificatetest.png');

          $createimage = imagecreatefrompng($image);
          $filedate=date('dmY');
          $filename = "extcertificate_".$volid."_".$eventid."_".$filedate.".png";
          //this is going to be created once the generate button is clicked
          $output = public_path('certificate/'.$filename);
  
          $outputimageencode    =  file_get_contents($output);
         
          $base64dataoutput  =  base64_encode($outputimageencode); // Output picture bas 64 converstn
          dd($base64dataoutput); 
          //then we make use of the imagecolorallocate inbuilt php function which i used to set color to the text we are displaying on the image in RGB format
          //$white = imagecolorallocate($createimage, 205, 245, 255);
          $blue = imagecolorallocate($createimage, 32, 55, 1);

          //Then we make use of the angle since we will also make use of it when calling the imagettftext function below
          $rotation = 0;

          //we then set the x and y axis to fix the position of our text name
         
          
          //$certificate_text = "This is to certify that ".$volname.", volunteer registered in Samoohika Sannadhasena with mobile number ".$mobile.", has successfully completed the pre monsoon training on landslide preparedness conducted by the Directorate in association with KSDMA." ;
          //$certificate_text = "This is to certify that ".$volname.", volunteer registered in Samoohika Sannadhasena with mobile number ".$mobile.", has successfully completed two-days Taluk-level Refresher Training conducted by the Directorate in association with KSDMA." ;
          $certificate_text = "For participating in '".$event."' organized by Samoohika Sannadhasena, Government of Kerala in association with the ".$district." District Administration on ".$eventdate."." ;
          //$newtext = wordwrap($certificate_text, 85, "\n",true);
          $lines = explode("\n", wordwrap($certificate_text, 70));
          //dd(count($lines));

          $line1 = $lines[0];
          $line2 = $lines[1];
          $line3 = $lines[2];

          //font directory for name
          $drFont = public_path('font/arial.ttf');

          $origin_x = 580;
          $origin_y=600;
          
          $font_size = 50;#00053c
          $font_size1 = 30;#00053c

          //function to display name on certificate picture
          $text1 = imagettftext($createimage, $font_size, $rotation, $origin_x, $origin_y, $blue, $drFont, $volname);

          $origin_yy=700;

          $text5 = imagettftext($createimage, $font_size1, $rotation, $origin_x, $origin_yy, $blue, $drFont, $line1);

          $origin_yyy=760;

          $text6 = imagettftext($createimage, $font_size1, $rotation, $origin_x, $origin_yyy, $blue, $drFont, $line2);

          $origin_yyy=820;

          $text7 = imagettftext($createimage, $font_size1, $rotation, $origin_x, $origin_yyy, $blue, $drFont, $line3);

          $origin_x2 = 850;
          $origin_y2=1720;

          //$certificate_text1 = "Your willingness to prepare and plan for protecting the society is appreciated." ;
          

          //$text2 = imagettftext($createimage, $font_size, $rotation, $origin_x2, $origin_y2, $blue, $drFont, $certificate_text1);

          

          /*$origin_x3 = 540;
          $origin_y1=1815;

          $certificate_text2 = " the community.";

          $text3 = imagettftext($createimage, $font_size, $rotation, $origin_x3, $origin_y1, $blue, $drFont, $certificate_text2);*/

          $origin_x1 = 700;
          $origin_y3=2075;
          
          $font_size1 = 37;#00053c
          
          $certificate_text3 = $date;
          $text4 = imagettftext($createimage, $font_size1, $rotation, $origin_x1, $origin_y3, $blue, $drFont, $certificate_text3);

          $origin_x4 = 1670;
          $origin_y4=1900;
          
          $font_size1 = 37;#00053c
          
          //$certificate_text4 = imagecreatefrompng($imagesign);
          //$text5 = imagettftext($createimage, $font_size1, $rotation, $origin_x4, $origin_y4, $blue, $drFont, $certificate_text4);
          //$text5 = imagecopy($createimage, $createimgsign, 700, 700, $origin_x4, $origin_y4, 500, 500);
           imagecopymerge($createimage, $createimgsign, $origin_x4, $origin_y4, 0, 0, 700, 170, 60);

          // Generate output image
          $filedate = date('dmY');
          $filename = "extcertificate_" . $volid . "_" . $eventid . "_" . $filedate . ".png";
            
          $output = public_path('certificate/' . $filename);
          $outputImageData = file_get_contents($output);
          $base64dataoutput = base64_encode($outputImageData);
         
          // imagepng($createimage, $output, 3);

          // Encode output image to base64
         

       
          // header("Content-type: image/png");
          // $finaloutput = imagepng($createimage);
        $response=array();
          if(isset($base64dataoutput)){
            $insert_data = array(
              'volunteers_id' =>$volid,
              'events_id' =>$eventid,
              'date' => date('Y-m-d'),
              'entereduserid' =>$volid,
            );
          
            $res = DB::table('volunteerextcertificates')->insert($insert_data);
          }
         
          $response = [
            'success' => true,
            'certificate' => $base64dataoutput, // Base64-encoded certificate image
            'insert_data' => $insert_data,
        ];
    
          return response()->json($response, 200);
        }
public function encrptt_fun($id)
{
          // Generate a random 4-character string
      $randomString = Str::random(4);

      // Encode the random string using Base64 encoding
      $encodedString = base64_encode($randomString);

        $simple_string = "adminNr#12*s".$id.$encodedString;
        $cleanString = preg_replace('/[^A-Za-z0-9]/', '', $simple_string);

        $sessionId = Session::getId();
     
        // Display the original string
        // echo "Original String: " . $simple_string;

        // Store the cipher method
        $ciphering = "AES-128-CTR";
 
        // Use Open Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
 
        $options = 0;

        // Non-NULL Initialization Vector for encryption
        $encryption_iv = 'abcklm35620123a1';//16 must

        // Store the encryption key
        $encryption_key = "cditAdmin";
       
        // Use open_encrypt() function to encrypt the data
    
        $encryption = openssl_encrypt($cleanString, $ciphering,
                    $encryption_key, $options, $encryption_iv);
      
        return $encryption;         
    }
    public function getotptoken(Request $request,$no)
    {
      $msg_send=0;
      // $encryptedrequestid = 'xbOsLb72OAwWBc1F';
      $encryptedrequestid = $request->token;
      $decryption_iv = 'abcklm35620123a1';
       // Store the decryption key
       $decryption_key = "cditAdmin";
       $ciphering = "AES-128-CTR";
       $options = 0;
       
       // Use open_decrypt() function to decrypt the data
       $decryption=openssl_decrypt ($encryptedrequestid, $ciphering,
       $decryption_key, $options, $decryption_iv);
       
        // Display the decrypted string
        if($decryption=='adminNr#12*s'){
          $checkvolunteerexist = Volunteer::where('mobile',$no)->where('status',1)->exists() ? 1 : 0;
       
        
        
          if($checkvolunteerexist==1){
              $otp =  app('App\Http\Controllers\BaseController')->generateotp();
              $token = Str::random(60); // Generate a random token
      
              $otptimestamp = Carbon::now();
              $form_data = array(
                  'otp'          => $otp,
                  'otptimestamp' => $otptimestamp,
                  'token_api'    =>  Hash::make($token)
              );
              
              Volunteer::where('mobile',$no)->update($form_data);
          
                /* -------------------------------------------- Send Custom SMS (start) --------------------------------- */
                $message = "Volunteer registration OTP for SSSena Sannadhasena Portal is ".$otp;
                $number = $no;
                // dd($number);
                // $number = 9567420761;
                $link = curl_init();
                curl_setopt($link , CURLOPT_URL, "http://api.esms.kerala.gov.in/fastclient/SMSclient.php?username=sannadham-portal&password=Sann@1234&message=".$message."&numbers=".$number."&senderid=SSSENA");
                curl_setopt($link , CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($link , CURLOPT_HEADER, 0);
                curl_exec($link);
                curl_close($link );
  
              if($link)
              {
                $msg_send=1;
              }else{
                $msg_send=0;
              }
           /* -------------------------------------------- Send Custom SMS (end) --------------------------------- */
       
              return response()->json(['otp' => $otp,'msg_send'=> $msg_send,  200]);
          }else {
              return response()->json(['otp' => '0','msg_send'=> $msg_send, 200]);
          }
        }else{
          return response()->json(['msg_send'=> 'Error!!! Key token mismatch']);
        }
        

    }

}// end of class
