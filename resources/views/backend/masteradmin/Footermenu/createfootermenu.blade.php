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
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Footermenu</div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                        
                            {!! implode(' ', $errors->all('<li><span class="text-danger">:message</span></li>')) !!}
                        </div> <!-- ./alert -->
                    @endif
                    
                   @if(isset($edit_f))
                    <form id="formiid" method="POST" action="{{ route('updatefootermenu') }}" enctype="multipart/form-data">
                    @else
                    <form id="formiid" method="POST" action="{{ route('storefootermenu') }}" enctype="multipart/form-data">
                    @endif
                    @php $i=0; @endphp
                    @csrf 
                        <input type="hidden" name="hidden_id" class="hidden_id" value="{{$keydata->id ?? ''}}">
                        <input type="hidden" name="edit_id" class="edit_id" value="{{$edit_f ?? ''}}">
                        <div class="row mb-3 card-header card-main">
                        <label class="my-1 mr-2"><span class="redalert">* Please fill data</span></label><br>
                        @if(isset($edit_f)) 
                        
                            @if(isset($keydata->id)) @foreach(($keydata->footermenu_sub) as $footermenu_sub)
                       
                            <div class="col-sm-12 card-header card-custm-header"><label for="path" class="col-sm-2 col-form-label" >Title {{$footermenu_sub->name}} </label>
                            <input type="hidden" id="sel_lang{{$footermenu_sub->languageid}}" name="sel_lang[]" class="form-check-input radioval" value="{{$footermenu_sub->languageid}}" @if(isset($keydata->id)){{ $keydata->id != 'null' ? 'checked' : null }}@endif ></div><br/>
                                <div class="row div_lan1">

                                 <div class="col-sm-6 mb-btm" id="div{{$footermenu_sub->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Title in {{$footermenu_sub->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$footermenu_sub->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="{{$footermenu_sub->title}}" required autocomplete="title" placeholder="Enter main {{$footermenu_sub->name}} here" autofocus  >
                                 </div><br/>


                                <div class="col-sm-6 mb-btm" id="div_alt{{$footermenu_sub->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Alternative title in {{$footermenu_sub->name}}</label>
                                    <input id="alt_title{{$footermenu_sub->id}}" type="text" class="form-control @error('alt_title') is-invalid @enderror" name="alt_title[]" value="{{ $footermenu_sub->alternatetext ?? old('alt_title')}}" required autocomplete="language" placeholder="Enter Alternative {{$footermenu_sub->name}} here" autofocus >
                                </div><br/>

                                <div class="row div_lan1 mb-3">
                                    <div class="col-sm-6 mb-btm" id="div_poster{{$footermenu_sub->id}}"> 
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Poster in {{$footermenu_sub->name}}</label>
                                        <input id="poster{{$footermenu_sub->id}}" type="file" rel="{{$footermenu_sub->id}}" class="poster form-control @error('poster') is-invalid @enderror" name="poster[]" value="{{ $keydata->poster ?? old('poster')}}" autocomplete="poster" placeholder="Enter poster {{$footermenu_sub->name}} here" accept=".jpg,.jpeg,.png"  autofocus >
                                    </div>

                                    <div class="col-sm-6 mb-btm mb-3 preview_poster" style="display: none;"> 
                                    <img src="{{asset('uploads/Footermenu/'.$footermenu_sub->poster)}}" id="preview-image-before-upload{{$footermenu_sub->id}}" rel="{{$footermenu_sub->id}}" class="preview-image-before-upload imgstamp" alt="preview image">
                                    <!-- <br><span class="redalert">selected image</span> -->
                                </div><br/>
                               </div>
                               <div class="row div_lan1 mb-3 pt-5">
                                <div class="col-sm-12 mb-btm" id="div_cont{{$footermenu_sub->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Content title in {{$footermenu_sub->name}}</label>
                                    <textarea id="content{{$footermenu_sub->id}}" class="form-control ckeditor @error('content') is-invalid @enderror" name="content[]" value="{{ $footermenu_sub->content ?? old('content.'.$i)}}" required autocomplete="language" placeholder="Enter Content in {{$footermenu_sub->name}} here" autofocus >{{ $footermenu_sub->content}}</textarea>
                                </div><br/>

                                </div>

                                </div>


                            </div>    
                            @endforeach @endif
                        @else
                         @foreach($language as $langs)
                        
                        <div class="col-sm-12 card-header card-custm-header"><label for="path" class="col-sm-2 col-form-label" >Title {{$langs->name}} </label>
                           <input type="hidden" id="sel_lang{{$langs->id}}" name="sel_lang[]" class="form-check-input radioval" value="{{$langs->id}}" @if(isset($keydata->id)){{ $keydata->id != 'null' ? 'checked' : null }}@endif ></div><br/>
                        <div class="row div_lan1">
                            <div class="col-sm-6 mb-btm" id="div{{$langs->id}}"> 
                                 <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Title in {{$langs->name}} <span class="redalert"> *</span></label>
                                <input id="title{{$langs->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="" required autocomplete="title" placeholder="Enter main {{$langs->name}} here" autofocus  >
                            </div><br/>

                              <div class="col-sm-6 mb-btm" id="div_alt{{$langs->id}}"> 
                                 <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Alternative title in {{$langs->name}}</label>
                                <input id="alt_title{{$langs->id}}" type="text" class="form-control @error('alt_title') is-invalid @enderror" name="alt_title[]" value="{{ $keydata->title ?? old('alt_title')}}" required autocomplete="language" placeholder="Enter Alternative {{$langs->name}} here" autofocus >
                            </div><br/>

                        </div><br>

                        <div class="row div_lan1 mb-3">
                            <div class="col-sm-6 mb-btm" id="div_poster{{$langs->id}}"> 
                                 <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Poster in {{$langs->name}}</label>
                                <input id="poster{{$langs->id}}" type="file" rel="{{$langs->id}}" class="poster form-control @error('poster') is-invalid @enderror" name="poster[]" value="{{ $keydata->title ?? old('alt_title')}}" required autocomplete="poster" placeholder="Enter poster {{$langs->name}} here" accept=".jpg,.jpeg,.png"  autofocus >
                            </div>

                            <div class="col-sm-6 mb-btm mb-3 preview_poster" style="display: none;"> 
                             <img id="preview-image-before-upload{{$langs->id}}" rel="{{$langs->id}}" class="preview-image-before-upload imgstamp" src="" alt="preview image">
                             <!-- <br><span class="redalert">selected image</span> -->
                           </div><br/>

                        </div>

                        <div class="row div_lan1 mb-3 pt-5">

                            <div class="col-sm-12 mb-btm" id="div_cont{{$langs->id}}"> 
                                 <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Content title in {{$langs->name}}</label>
                                 <textarea id="content{{$langs->id}}" class="form-control ckeditor @error('content') is-invalid @enderror" name="content[]" value="{{ $keydata->content ?? old('content.'.$i)}}" required autocomplete="language" placeholder="Enter Content in {{$langs->name}} here" autofocus ></textarea>

                                <!-- <textarea id="content{{$langs->id}}" class="ckeditor @error('content') is-invalid @enderror" name="content[]" value="{{ $keydata->content ?? old('content')}}" required autocomplete="content" placeholder="Enter {{$langs->name}} content here" autofocus ></textarea> -->
                            </div><br/>

                        </div>
                        @php $i++; @endphp
                         @endforeach @endif
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12 mb-btm" id=""> 
                                 <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Icon class</label>
                                <input id="iconclass" type="text" class="form-control @error('iconclass') is-invalid @enderror" name="iconclass" value="{{ $keydata->iconclass ?? old('iconclass')}}" required autocomplete="iconclass" placeholder="Enter iconclass here" autofocus >
                            </div><br/>
                        </div>

                        <div class="row">
                            <div class="col-sm-10 offset-sm-2">
                               @if($edit_f ?? '')
                                <button type="submit" class="btn btn-warning">Update</button>
                               @else
                               <button type="submit" class="btn btn-primary">Add </button>
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
    $('.preview_poster').hide();   
   $('.poster').change(function(){
   var i =$(this).attr('rel');

   var value = '#preview-image-before-upload'+i;

        $('.preview_poster').show();    
            let reader = new FileReader();
         
            reader.onload = (e) => { 
         
              $(value).attr('src', e.target.result); 
            }

            reader.readAsDataURL(this.files[0]); 
            $(".poster")[0].reset();
           });
    var edit=$('.edit_id').val();

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
            $(".poster")[0].reset();
        $('.preview_poster').show();
    }

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
