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
            <div class="card" id="entry_div" @if($errors->any()) style="display: inline;" @lese style="display: none;" @endif>
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Link</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                           {{ session('success') }}
                        </div>
                    @endif
                    <input type="hidden" name="Errval" id="Errval" value="{{($errors->any()) ? '1':'2'}}"> 
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                        
                            {!! implode(' ', $errors->all('<span class="text-danger">:message</span>')) !!}
                        </div> <!-- ./alert -->
                    @endif
                    @if(Auth::user()->role_id=2)
                    
                    @if(isset($edit_f))
                    <form id="formid" method="POST" action="{{ route('siteadmin.updatepressrel') }}" enctype="multipart/form-data">
                    @else
                    <form id="formid" method="POST" action="{{ route('siteadmin.storepressrel') }}" enctype="multipart/form-data">
                    @endif
    
                    @else if(Auth::user()->role_id=5)
                    
                    @if(isset($edit_f))
                    <form id="formid" method="POST" action="{{ route('sbu.updatepressrel') }}" enctype="multipart/form-data">
                    @else
                    <form id="formid" method="POST" action="{{ route('sbu.storepressrel') }}" enctype="multipart/form-data">
                    @endif
                    @endif

    
                    @csrf 
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">


                        <div class="row mb-3 card-header card-main">
                            @php 
                            $i=0;
                            @endphp
                            @if(isset($edit_f))
                            <input type="hidden"  value="{{$edit_f}}" id="edit_f"  name="edit_f">
                            @if(isset($keydata->id)) @foreach(($keydata->pressrel_sub) as $pressrel_sub)
                            <input type="hidden"  value="{{$pressrel_sub->languageid ?? ''}}" id="sel_lang{{$pressrel_sub->languageid}}" name="sel_lang[]">
                            <div class="col-sm-12 card-header card-custom-header bg-secondary text-white mb-3"><label for="path" class="col-sm-2 col-form-label" >{{$pressrel_sub->name}}</label></div><br/>                  
                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-6 mb-btm" id="div{{$pressrel_sub->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$pressrel_sub->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$pressrel_sub->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="{{ $pressrel_sub->title ?? old('title.'.$i)}}" required autocomplete="title" placeholder="Enter main {{$pressrel_sub->name}} here" autofocus >
                                </div><br/>

                                <div class="col-sm-6 mb-btm" id="div{{$pressrel_sub->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Sub title in {{$pressrel_sub->name}} <span class="redalert"> *</span></label>
                                    <input id="alt_text{{$pressrel_sub->id}}" type="text" class="form-control @error('alt_text') is-invalid @enderror" name="alt_text[]" value="{{ $pressrel_sub->alt_title ?? old('alt_text.'.$i)}}" required autocomplete="alt_text" placeholder="Enter main {{$pressrel_sub->name}} here" autofocus >
                                </div><br/>


                                <div class="col-sm-12 mb-btm" id="div_sub{{$pressrel_sub->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Content in {{$pressrel_sub->name}} <span class="redalert"> *</span></label>
                                   <textarea id="con_title{{$pressrel_sub->id}}" class="form-control ckeditor12 @error('con_title') is-invalid @enderror" name="con_title[{{$i}}]" value="{{ $pressrel_sub->description ?? old('con_title.'.$i)}}" required  placeholder="Enter Content in {{$pressrel_sub->name}} here" autofocus >{{ $pressrel_sub->description}}</textarea>
                                </div><br/>

                               <div class="col-sm-12 mb-btm" id="div{{$pressrel_sub->id}}"> 
                                    <div class="col-sm-9 mb-btm" id="div_poster{{$pressrel_sub->id}}">
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Poster in {{$pressrel_sub->name}} <span class="redalert"> *</span></label>
                                        <input id="file{{$pressrel_sub->id}}" rel="{{$pressrel_sub->id}}" type="file" class="form-control poster @error('file') is-invalid @enderror" name="file[]" value="{{ $pressrel_sub->file ?? old('file.'.$i)}}" autocomplete="file" placeholder="Enter main {{$pressrel_sub->name}} here" autofocus >
                                        <span class="redalert postererr{{$pressrel_sub->id}}"></span>
                                    </div><br/>
                                    <div class="col-sm-3 mb-btm mb-3 preview_poster" style="display: none;"> 
                                        <img id="preview-image-before-upload{{$pressrel_sub->id}}" rel="{{$pressrel_sub->id}}" class="preview-image-before-upload imgstamp" src="{{asset('uploads/Pressrelase/'.$pressrel_sub->file)}}" alt="preview image">
                                        
                                    </div><br/>
                                </div>
                            </div><br><hr>
                            @php 
                            $i++;
                            @endphp
                            @endforeach @endif
                            @else

                            @foreach($language as $langs)
                             <input type="hidden"  value="{{$langs->id ?? ''}}" id="sel_lang{{$langs->id}}" name="sel_lang[]">
                            <div class="col-sm-12 card-header card-custom-header bg-secondary text-white mb-3"><label for="path" class="col-sm-2 col-form-label" >{{$langs->name}}</label></div><br/>                  
                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-6 mb-btm" id="div{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$langs->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="{{ $keydata->title ?? old('title.'.$i)}}" required autocomplete="title" placeholder="Enter main {{$langs->name}} here" autofocus >
                                </div><br/>

                                <div class="col-sm-6 mb-btm" id="div{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Sub title in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="alt_text{{$langs->id}}" type="text" class="form-control @error('alt_text') is-invalid @enderror" name="alt_text[]" value="{{ $keydata->alt_text ?? old('alt_text.'.$i)}}" required autocomplete="alt_text" placeholder="Enter main {{$langs->name}} here" autofocus >
                                </div><br/>


                                <div class="col-sm-12 mb-btm" id="div_sub{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Content in {{$langs->name}} <span class="redalert"> *</span></label>
                                   <textarea id="con_title{{$langs->id}}" class="form-control ckeditor12 @error('con_title') is-invalid @enderror" name="con_title[{{$i}}]" value="{{ $keydata->title ?? old('con_title.'.$i)}}" required  placeholder="Enter Content in {{$langs->name}} here" autofocus ></textarea>
                                </div><br/>

                               <div class="col-sm-12 mb-btm" id="div{{$langs->id}}"> 
                                    <div class="col-sm-9 mb-btm" id="div_poster{{$langs->id}}">
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Poster in {{$langs->name}} <span class="redalert"> *</span></label>
                                        <input id="file{{$langs->id}}" rel="{{$langs->id}}" type="file" class="form-control poster @error('file') is-invalid @enderror" name="file[]" value="{{ $keydata->file ?? old('file.'.$i)}}" required autocomplete="file" placeholder="Enter main {{$langs->name}} here" autofocus >
                                        <span class="redalert postererr{{$langs->id}}"></span>
                                    </div><br/>
                                    <div class="col-sm-3 mb-btm mb-3 preview_poster" style="display: none;"> 
                                        <img id="preview-image-before-upload{{$langs->id}}" rel="{{$langs->id}}" class="preview-image-before-upload imgstamp" src="" alt="preview image">
                                        
                                    </div><br/>
                                </div>
                            </div><br><hr>

                            @php 
                            $i++;
                            @endphp
                            @endforeach
                            @endif
                            <div class="row">
                               <div class="col-sm-6 mb-btm"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">URL<span class="redalert"> *</span></label>
                                    <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ $keydata->url ?? old('url')}}" required autocomplete="url" placeholder="Enter url here" autofocus >
                                </div><br/>
                     
                               <div class="col-sm-6 mb-btm"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Date</label>
                                        <!-- <span class="redalert"> *</span> -->
                                    <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ $keydata->date ?? old('date')}}" autocomplete="date" placeholder="Enter date here" autofocus >
                                </div><br/>
                            </div><br/>

                            <div><br/></div>
                            <div class="row mb-1">
                                <div class="col-sm-10 offset-sm-2">
                                   @if($edit_f ?? '')
                                    <button type="submit" class="btn btn-warning">Update</button>
                                   @else
                                   <button type="submit" class="btn btn-primary">Add </button>
                                   @endif
                                   <a type="submit" class="btn btn-success" href="{{route('planning.articlelist')}}">Refresh</a>
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
// if($('#Errval').val()!=1){
//     $("#entry_div").hide();

// }
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


    // validation in LAng.
    $('#language').on('keyup', function(e) {
        var testres = engtitle('#language', this.value);
        if (!testres) {
            $('.titleerr').text("Not Allowed ");

            $('.titleerr').show();

        } else {
            $('.titleerr').hide();
        }
     });
    // $('#addarticle').on('click', function(e) { 
    //     if ($('#entry_div').css('display') == 'none') {
    //         $('#entry_div').show();
    //     } else {
    //         $('#entry_div').hide();
    //     }
        
        
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
$('.preview-image-before-upload').on('load',function(e){    
        var image = new Image();
        var role_id =$('#role_id').val();
      
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
                var testres=imageheightwidth_pressrelase(value,image.width,image.height);
            }else{
                var testres=imageheightwidth_pressrelase(value,image.width,image.height);
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
</script>
@endsection
