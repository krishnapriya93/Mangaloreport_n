@extends('layouts.htmlheader')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb justify-content-center">
        {!!$breadcrumbarr!!}
    </ol>
</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                @if(Session::get('success')!='')
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong>   {{Session::get('success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif
                @if(session('delete'))
                    <div class="alert alert-warning" role="alert">
                       {{ session('delete') }}
                       <strong>Success!</strong>   {{Session::get('success')}}
                           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            <div class="card @if($errors->any()) @else  @endif" id="entry_div" >
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Banner</div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {!! implode(' ', $errors->all('<span class="text-danger">:message</span>')) !!}
                        </div> <!-- ./alert -->
                    @endif
                    <input type="hidden" name="Errval" value="{{($errors->any()) ? '1':'2'}}"> 
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                        
                            {!! implode(' ', $errors->all('<span class="text-danger">:message</span>')) !!}
                        </div> <!-- ./alert -->
                    @endif
                    @if(Auth::user()->role_id=2)
                    @if(isset($edit_f))
                    <form id="formid" method="POST" action="{{ route('siteadmin.updatebanner') }}" enctype="multipart/form-data">
                    @else
                    <form id="formid" method="POST" action="{{ route('siteadmin.storebanner') }}" enctype="multipart/form-data">
                    @endif
                    @else if(Auth::user()->role_id=5)
                    @if(isset($edit_f))
                    <form id="formid" method="POST" action="{{ route('sbu.updatebanner') }}" enctype="multipart/form-data">
                    @else
                    <form id="formid" method="POST" action="{{ route('sbu.storebanner') }}" enctype="multipart/form-data">
                    @endif
                    @endif
                    
    
                    @csrf 
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                        <input type="hidden" name="role_id" id="role_id" value="{{ Auth::user()->id}}">

                        <div class="row mb-3 card-header card-main">
                            @php $i=0; @endphp
                   @if(isset($edit_f)) 
                   <input type="hidden"  value="{{$edit_f}}" id="edit_f"  name="edit_f">
                    @if(isset($keydata->id)) @foreach(($keydata->banner_sub) as $bannersub)
               
                    <input type="hidden"  value="{{$bannersub->languageid ?? ''}}" id="sel_lang{{$bannersub->id}}" name="sel_lang[]">
                        <div class="col-sm-12 card-header card-custom-header bg-secondary text-white mb-3"><label for="path" class="col-sm-2 col-form-label" >Banner title</label></div><br/>  
                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-6 mb-btm" id="div{{$bannersub->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$bannersub->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$bannersub->id}}" type="text" class="form-control title title_validation @error('title') is-invalid @enderror" name="title[]" value="{{ $bannersub->title ?? old('title.'.$i)}}" rel="{{$bannersub->id}}" required autocomplete="title" placeholder="Enter main {{$bannersub->name}} here" autofocus >
                                    <span class="ErrP redalert titleerr1 display_status">Please Check the {{$bannersub->name}} title Entered</span>
                                     <span class="ErrP redalert titleerr2 display_status">Please Check the {{$bannersub->name}} title Entered</span>
                                </div><br/>
                             <div class="col-sm-6 mb-btm" id="div_sub{{$bannersub->id}}"> 
                                 <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Sub title in {{$bannersub->name}} </label>
                                <input id="sub_title{{$bannersub->id}}" type="text" class="form-control sub_title title_validation @error('sub_title') is-invalid @enderror" name="sub_title[]" value="{{ $bannersub->subtitle ?? old('sub_title')}}"  rel="{{$bannersub->id}}" autocomplete="language" placeholder="Enter sub {{$bannersub->name}} here" autofocus >
                                <span class="ErrP redalert titleerr3 display_status">Please Check the {{$bannersub->name}} title Entered</span>
                                <span class="ErrP redalert titleerr4 display_status">Please Check the {{$bannersub->name}} title Entered</span>
                             </div><br/>

                         </div><br><!--row end--->
                           <div class="row mb-3">

                             <div class="col-sm-6 mb-btm" id="div_alt{{$bannersub->id}}"> 
                                 <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Alternative titl in {{$bannersub->name}}</label>
                                <input id="alt_title{{$bannersub->id}}" type="text" class="form-control alt_title title_validation @error('alt_title') is-invalid @enderror" name="alt_title[]" value="{{ $bannersub->alternatetext ?? old('alt_title')}}"  rel="{{$bannersub->id}}" autocomplete="language" placeholder="Enter Alternative {{$bannersub->name}} here" autofocus >
                                <span class="ErrP redalert titleerr5 display_status">Please Check the {{$bannersub->name}} title Entered</span>
                                <span class="ErrP redalert titleerr6 display_status">Please Check the {{$bannersub->name}} title Entered</span>
                            </div><br/>

                            <div class="col-sm-6 mb-btm" id="div_poster{{$bannersub->id}}"> 
                            <div class="col-sm-5 mb-btm" id=""> 
                                 <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Poster {{$bannersub->name}}</label>
                                <input id="poster{{$bannersub->id}}" type="file" class="form-control poster @error('poster') is-invalid @enderror" name="poster[]" value="{{ $bannersub->poster ?? old('poster')}}" autocomplete="language" placeholder="Enter main {{$bannersub->name}} here" autofocus  accept="image/png, image/jpeg, image/jpg" >
                                <span class="redalert postererr1"></span>
                                <span class="redalert postererr2"></span>
                            </div>
                            <div class="col-sm-3 mb-btm mb-3 preview_poster" style="display: none;"> 
                                    <img id="preview-image-before-upload{{$bannersub->id}}" src="{{asset('uploads/Banner/'.$bannersub->poster)}}" rel="{{$bannersub->id}}" class="preview-image-before-upload imgstamp" alt="preview image">
                                    <!-- <br><span class="redalert">selected image</span> -->
                                </div><br/>
                            </div><br/>
                        </div>
                      @endforeach @endif 
                    @else
                      @foreach($language as $langs)
                             <input type="hidden"  value="{{$langs->id ?? ''}}" id="sel_lang{{$langs->id}}" name="sel_lang[]">
                            <div class="col-sm-12 card-header card-custom-header bg-secondary text-white mb-3"><label for="path" class="col-sm-2 col-form-label" >{{$langs->name}}</label></div><br/>                  
                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-6 mb-btm" id="div{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$langs->id}}" type="text" class="form-control title title_validation @error('title') is-invalid @enderror" name="title[]" value="{{ $keydata->title ?? old('title.'.$i)}}" rel="{{$langs->id}}" required autocomplete="title" placeholder="Enter main {{$langs->name}} here" autofocus >
                                    <span class="ErrP redalert titleerr1 display_status">Please Check the {{$langs->name}} title Entered</span>
                                     <span class="ErrP redalert titleerr2 display_status">Please Check the {{$langs->name}} title Entered</span>
                                </div><br/>
                            <div class="col-sm-6 mb-btm" id="div_sub{{$langs->id}}"> 
                                 <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Sub title in {{$langs->name}} </label>
                                <input id="sub_title{{$langs->id}}" type="text" class="form-control sub_title title_validation @error('sub_title') is-invalid @enderror" name="sub_title[]" value="{{ $keydata->sub_title ?? old('sub_title')}}"  rel="{{$langs->id}}" autocomplete="language" placeholder="Enter sub {{$langs->name}} here" autofocus >
                                <span class="ErrP redalert titleerr3 display_status">Please Check the {{$langs->name}} title Entered</span>
                                <span class="ErrP redalert titleerr4 display_status">Please Check the {{$langs->name}} title Entered</span>
                            </div><br/>

                            </div><br>

                        <div class="row mb-3">

                             <div class="col-sm-6 mb-btm" id="div_alt{{$langs->id}}"> 
                                 <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Alternative titl in {{$langs->name}}</label>
                                <input id="alt_title{{$langs->id}}" type="text" class="form-control alt_title title_validation @error('alt_title') is-invalid @enderror" name="alt_title[]" value="{{ $keydata->title ?? old('alt_title')}}"  rel="{{$langs->id}}"  autocomplete="language" placeholder="Enter Alternative {{$langs->name}} here" autofocus >
                                <span class="ErrP redalert titleerr5 display_status">Please Check the {{$langs->name}} title Entered</span>
                                <span class="ErrP redalert titleerr6 display_status">Please Check the {{$langs->name}} title Entered</span>
                            </div><br/>

                            <div class="col-sm-6 mb-btm" id="div_poster{{$langs->id}}"> 
                            <div class="col-sm-6"> <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Poster {{$langs->name}}</label>
                                <input id="poster{{$langs->id}}" type="file" class="form-control poster @error('poster') is-invalid @enderror" name="poster[]" rel="{{$langs->id}}" value="" required autocomplete="language" placeholder="Enter main {{$langs->name}} here" autofocus  accept="image/png, image/jpeg, image/jpg">
                                <img  id="img_show" src="" class="img-thumbnail" alt="..." style="display: none;" width="120px" height="100px"> 
                                <span class="redalert postererr{{$langs->id}}"></span>

                            </div>  
                                <div class="col-sm-3 mb-btm mb-3 preview_poster" style="display: none;"> 
                                    <img id="preview-image-before-upload{{$langs->id}}" rel="{{$langs->id}}" class="preview-image-before-upload imgstamp" src="" alt="preview image">
                                    <!-- <br><span class="redalert">selected image</span> -->
                                </div><br/>
                            </div><br/>
                        </div>
                        

                            @php 
                            $i++;
                            @endphp
                            @endforeach
                            @endif
                            <div></div>

                            <div class="row mt-1">

                                <div class="col-sm-12 mb-btm" id=""> 
                                <label for="url" class="col-sm-2 col-form-label">URL</label>
                                        <div class="col-sm-10">
                                            <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ $keydata->url ?? old('url')}}" autocomplete="url" placeholder="Eg: test" autofocus>
                                            <span class="ErrP alert-danger redalert url" style="display: none;">Please Check the url Entered</span>
                                            <span class="redalert">@error('url'){{$message}} @enderror</span>
                                        </div>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-10 offset-sm-2">
                                   @if($edit_f ?? '')
                                    <button type="submit" class="btn btn-warning">Update</button>
                                   @else
                                   <button type="submit" class="btn btn-primary">Add </button>
                                   @endif
                                   @if(Auth::user()->role_id=2)
                                    <a type="submit" class="btn btn-success" href="{{route('siteadmin.banner')}}">Refresh</a>
                                   @elseif(Auth::user()->role_id=5)
                                    <a type="submit" class="btn btn-success" href="{{route('sbu.banner')}}">Refresh</a>
                                   @endif
                                  
                                </div>
                            </div>
                        </div><!-- .row -->
                    </form>
                </div><!-- .card-body -->
            </div><!-- .card -->
            
        </div><!-- .col-12 -->
    </div><!-- .row -->
</div><!-- .container -->
@endsection
@section('page_scripts')
<script>  
 $( document ).ready(function() {
    var edit=$('#edit_f').val();
    $('.postererr1').hide();
    $('.postererr2').hide();

    if(edit=='E')
    {
        var hidden_id =$('.radioval').val();
        var value = '#preview-image-before-upload'+hidden_id;
        // alert(value);
        $('.preview_poster').show();    
            let reader = new FileReader();
         
            reader.onload = (e) => { 
         
              $(value).attr('src', e.target.result); 
            }

            reader.readAsDataURL(this.files[0]); 
            // $(".poster")[0].reset();
        $('.preview_poster').show();
    }else{

        $('.preview_poster').hide(); 
    }

    $('.poster').change(function(){
   var i =$(this).attr('rel');

   var value = '#preview-image-before-upload'+i;

        $('.preview_poster').show();    
            let reader = new FileReader();
         
            reader.onload = (e) => { 
         
              $(value).attr('src', e.target.result); 
            }

            reader.readAsDataURL(this.files[0]); 
            // $(".poster")[0].reset();
           });

    // if($('#Errval').val()!=1){
    //     $("#entry_div").hide();

    // }     
});
//image prevew

//  function img_preview() {
//   $('.poster_view').each(function(index, value) {
//    const [file] = value.files
//    alert(file);
//    if(file!= "undefined")
//    {
//      if (file) {
//         img_show.src = URL.createObjectURL(file);
//     }
//     $('#img_show').show();
//    }
   
// });
    
// }

// $(".poster_view").on('change', function () {

//         if (typeof (FileReader) != "undefined") {

//             var image_holder = $("#img_show");
//             alert(image_holder);
//             image_holder.empty();

//             var reader = new FileReader();
//             reader.onload = function (e) {
//                 $("<img />", {
//                     "src": e.target.result,
//                     "class": "thumb-image"
//                 }).appendTo(image_holder);

//             }
//             image_holder.show();
//             reader.readAsDataURL($(this)[0].files[0]);
//         } else {
//             alert("This browser does not support FileReader.");
//         }
//     });

// validation in LAng.
$('.title_validation').on('keyup', function(e) {

    if($(this).attr('rel')==1)
    {
       var testres = engtitle('.title', this.value);

         if (!testres) {
             // alert($(this).parent().find( ".titleerr1" ).html());
             $(this).find( ".titleerr1" ).text("Not Allowed / only english ");
             // $('.titleerr1').text("Not Allowed1 ");
             $('.titleerr2').hide();
             $(this).parent().find( ".titleerr1" ).show();
             // $('.titleerr1').sh
         } else {
             $('.titleerr1').hide();
             $('.titleerr2').hide();
         }
        var testres1 = engtitle('.sub_title', this.value);
         if (!testres) {
             // alert($(this).parent().find( ".titleerr1" ).html());
             $(this).find( ".titleerr3" ).text("Not Allowed / only english ");
             // $('.titleerr1').text("Not Allowed1 ");
             $('.titleerr4').hide();
             $(this).parent().find( ".titleerr3" ).show();
             // $('.titleerr1').sh
         } else {
             $('.titleerr3').hide();
             $('.titleerr4').hide();
         }
        var testres2 = engtitle('.alt_title', this.value);
         if (!testres) {
             // alert($(this).parent().find( ".titleerr1" ).html());
             $(this).find( ".titleerr5" ).text("Not Allowed / only english ");
             // $('.titleerr1').text("Not Allowed1 ");
             $('.titleerr6').hide();
             $(this).parent().find( ".titleerr5" ).show();
             // $('.titleerr1').sh
         } else {
             $('.titleerr5').hide();
             $('.titleerr6').hide();
         }
       }else if($(this).attr('rel')==2)
       {
        var testres = maltitle('.title', this.value);
 
           if (!testres) {
               $(this).find( ".titleerr2" ).text("Not Allowed/ only malayalam ");
               $('.titleerr1').hide();
           } else {
               $('.titleerr2').hide();
               $('.titleerr1').hide();
           }

        var testres1 = maltitle('.sub_title', this.value);
           if (!testres) {
               $(this).find( ".titleerr4" ).text("Not Allowed/ only malayalam ");
               $('.titleerr3').hide();

           } else {
                $('.titleerr4').hide();
                $('.titleerr3').hide();
           }

        var testres1 = maltitle('.alt_title', this.value);
           if (!testres) {
               $(this).find( ".titleerr6" ).text("Not Allowed/ only malayalam ");
               $('.titleerr5').hide();

           } else {
                $('.titleerr6').hide();
                $('.titleerr5').hide();
           }
        }


      
     });
    // validation in class icon
    $('#icon_class').on('keyup', function(e) {
        var testres = iconclasscheck('#icon_class', this.value);
        if (!testres) {
            $('.iconerr').text("Not Allowed ");

            $('.iconerr').show();

        } else {
            $('.iconerr').hide();
        }
     });    
     
     //Banner Size : 1920px*400px
    // $('.poster').on('keyup', function(e) {
    //     var testres = imageheightwidth_mainslider();
    //     if (!testres) {
    //         $('.postererr1').html('');
    //     $('.postererr2').hide();

    //     } else {
    //         $('.postererr1').html('');
    //     }
    //  });

    //Banner validation 
//     $('.poster').on('change',function(e){ 
//         var testres=imageval('#poster',this.files[0],'#img_show');
//     // $('.postererr').html(testres);
//     if(testres=='true'){
//         $('.postererr1').html('');
//         $('.postererr2').hide();
//     }else{
//         $('.postererr1').html('');
//         $('.postererr1').html(testres);
//         $('.postererr').show();
    
//     }
// });

$('.preview-image-before-upload').on('load',function(e){    
        var image = new Image();
        var role_id =$('#role_id').val();
        // alert(role_id);
        // $('.postererr1').hide();
        // $('.postererr2').hide();
        image.src = $(this).attr("src");
        var rel_id=$(this).attr('rel');
        var value = '#preview-image-before-upload'+rel_id;
        // alert(value);
        // if(rel_id==1)
        // {
            if(role_id==2)
            {
                var testres=imageheightwidth_mainslider(value,image.width,image.height);
            }else{
                var testres=imageheightwidth_mainslider_sbu(value,image.width,image.height);
            }
      
        // alert(testres);

        if(testres=='true'){//okay
            $('.postererr'+rel_id).hide();
            // $('.postererr2').hide();
          
        }else{//error
            $('.postererr'+rel_id).append(' '+testres);
            $('.postererr'+rel_id).show();
          

        }
       
    
        
    });
//append lang
  /* $(".radioval").click(function () {

    var val=$(this).attr('value');
    var check =  $(this).prop('checked');
 
    if(check)
    {

        if($(this).attr('value') != '') {
            $('.div_lan1').show();
            $('.div_lan2').show();
            $('#div'+val).show();
            $('#div_alt'+val).show()
            $('#div_poster'+val).show(); 
            $('#div_sub'+val).show();        
            $('#div_content'+val).show();        
       }

       else {
        
            $('#div'+val).hide();  
            $('#div_poster'+val).hide(); 
            $('#div_sub'+val).hide(); 
            $('#div_content'+val).hide(); 
            $('#div_alt'+val).hide();   
       }

    }else{
        
         $('#div'+val).hide();
         $('#div_sub'+val).hide();   
         $('#div_poster'+val).hide(); 
         $('.div_lan1').hide();
         $('.div_lan2').hide();
         $('#div_alt').hide()
         $('#div_content').hide()
         $("#sel_lang"+val).prop('checked', false);
    }

   
   });*/

// });
</script>
@endsection
