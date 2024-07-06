@extends('backend.layouts.htmlheader')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb justify-content-center">
        {!!$breadcrumbarr!!}
    </ol>
</nav> 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Article type</div>

                <div class="card-body">
                @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                        
                            {!! implode(' ', $errors->all('<li><span class="text-danger">:message</span></li>')) !!}
                        </div> <!-- ./alert -->
                    @endif
                    
                   @if(isset($edit_f))
                    <form id="formiid" method="POST" action="{{ route('updatearticletype') }}" enctype="multipart/form-data">
                    @else
                    <form id="formiid" method="POST" action="{{ route('storearticletype') }}" enctype="multipart/form-data">
                    @endif
    
                    @csrf 
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                        <input type="hidden" id="edit_id" name="edit_id" value="{{$edit_f ?? ''}}">

                        <div class="row mb-3">
                        @if(isset($edit_f)) 

                            @if(isset($keydata->id)) @foreach(($keydata->article_sub) as $article_sub)

                            <input type="hidden"  value="{{$article_sub->languageid ?? ''}}" id="sel_lang{{$article_sub->languageid}}" name="sel_lang[]">

                            <div class="col-sm-6 mb-btm" id="div{{$article_sub->id}}"> 
                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Link type in {{$article_sub->name}} <span class="redalert"> *</span></label>
                            <input id="title{{$article_sub->id}}" type="text" class="form-control title_validation @error('title') is-invalid @enderror" name="title[]" value="{{ $article_sub->title ?? old('title.'.$i)}}" rel="{{$article_sub->id}}" required autocomplete="title" placeholder="Enter {{$article_sub->name}} here" autofocus  >
                            <span class="ErrP redalert titleerr1" style="display: none;">Please Check the {{$article_sub->title}} title Entered</span>
                            <span class="ErrP redalert titleerr2" style="display: none;">Please Check the {{$article_sub->title}} title Entered</span>
                            </div>
                            @endforeach @endif

                            <!-- EDiting End -->
                            @else
                            @foreach($language as $langs)

                            <input type="hidden"  value="{{$langs->id ?? ''}}" id="sel_lang{{$langs->id}}" name="sel_lang[]">

                                <div class="col-sm-6 mb-btm" id="div{{$langs->id}}"> 
                                     <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Article type in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$langs->id}}" type="text" class="form-control title_validation @error('title') is-invalid @enderror" rel="{{$langs->id}}" name="title[]" value="" required autocomplete="title" placeholder="Enter {{$langs->name}} here" autofocus  >
                                    <span class="ErrP redalert titleerr1" style="display: none;">Please Check the {{$langs->title}} title Entered</span>
                                    <span class="ErrP redalert titleerr2" style="display: none;">Please Check the {{$langs->title}} title Entered</span>
                                </div>

                            @endforeach @endif

                        </div><br>


                        <div class="row">
                            <div class="col-sm-10 offset-sm-2">
                               @if($edit_f ?? '')
                                <button type="submit" id="submitBtn" class="btn btn-warning">Update</button>
                               @else
                               <button type="submit" id="submitBtn" class="btn btn-primary">Add </button>
                               @endif
                               <a type="submit" class="btn btn-success" href="{{route('mainmenu')}}">Refresh</a>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
       <br>


        </div>
    </div>
</div>
@endsection
@section('page_scripts')
<script>  
 $( document ).ready(function() {
///tittle validation
var edit=$('#edit_id').val();
// alert(edit);


var flag=0;
$('.title_validation').on('keyup', function(e) {

if($(this).attr('rel')==1)
{
   var testres = engtitle('.title_validation', this.value);
  
     if (!testres) {
         // alert($(this).parent().find( ".titleerr1" ).html());
         $(this).find( ".titleerr1" ).text("Not Allowed / only english ");
         // $('.titleerr1').text("Not Allowed1 ");
        //  $('.titleerr2').hide();
         $(this).parent().find( ".titleerr1" ).show();
         $('#submitBtn').prop('disabled', true);
        flag=1;
         // $('.titleerr1').sh
     } else {
    
         $('.titleerr1').hide();
         flag=0;
        //  $('.titleerr2').hide();
          $('#submitBtn').prop('disabled', false);
     }
    
   
   }else if($(this).attr('rel')==2)
   {
    var testres = maltitle('.title', this.value);

       if (!testres) {
    
           $(this).find( ".titleerr2" ).text("Not Allowed/ only malayalam ");
           $(this).parent().find( ".titleerr2" ).show();
        //    $('.titleerr1').hide();
           $('.submitBtn').prop('disabled', true);
           flag=1;
       } else {
    
           $('.titleerr2').hide();
           flag=0;

        //    $('.titleerr1').hide();
            $('.submitBtn').prop('disabled', false);
       }

    }


 });


// //append lang
//    $(".radioval").click(function () {

//     var val=$(this).attr('value');
//     var check =  $(this).prop('checked');
 
//     if(check)
//     {

//         if($(this).attr('value') != '') {
//             $('.div_lan1').show();
//             $('.div_lan2').show();
//             $('#div'+val).show();
//             $('#div_alt'+val).show();
//             $('#div_poster'+val).show(); 
//             $('#div_sub'+val).show(); 
//             $('#div_cont'+val).show();       
//        }

//        else {
        
//             $('#div'+val).hide();  
//             $('#div_poster'+val).hide(); 
//             $('#div_sub'+val).hide(); 
//             $('#div_alt'+val).hide();  
//             $('#div_cont'+val).hide();   
//        }

//     }else{
        
//          $('#div'+val).hide();
//          $('#div_sub'+val).hide();   
//          $('#div_poster'+val).hide(); 
//          $('.div_lan1').hide();
//          $('.div_lan2').hide();
//          $('#div_alt').hide();
//          $('#div_cont'+val).hide(); 
//          $("#sel_lang"+val).prop('checked', false);
//     }

   
//    });

});
 

</script>
@endsection