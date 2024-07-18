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
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} History</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                           {{ session('success') }}
                        </div>
                    @endif
                    <input type="hidden" name="Errval" id="Errval" value="{{($errors->any()) ? '1':'2'}}"> 
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                        
                            {!! implode(' ', $errors->all('<li><span class="text-danger">:message</span></li>')) !!}
                        </div> <!-- ./alert -->
                    @endif
                  
                    @if(Auth::user()->role_id=3)
                    @if(isset($edit_f))
                    <form id="formid" method="POST" action="{{ route('planning.updatemilestone') }}" enctype="multipart/form-data">
                    @else
                    <form id="formid" method="POST" action="{{ route('planning.storemilestone') }}" enctype="multipart/form-data">
                    @endif
    
                    @else if(Auth::user()->role_id=5)
                    @if(isset($edit_f))
                    <form id="formid" method="POST" action="{{ route('sbu.updatemilestone') }}" enctype="multipart/form-data">
                    @else
                    <form id="formid" method="POST" action="{{ route('sbu.storemilestone') }}" enctype="multipart/form-data">
                    @endif
    
                    @endif

                    @csrf 
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                        <input type="hidden" name="edit_id" class="edit_id" value="{{$edit_f ?? ''}}">
                        <div class="row mb-3 card-header card-main">
                            @php 
                            $i=0;
                            @endphp
                            @if(isset($edit_f)) 
                        
                             @if(isset($keydata->id)) @foreach(($keydata->milestonesub) as $historysub)
                             <input type="hidden"  value="{{$historysub->languageid ?? ''}}" id="sel_lang{{$historysub->languageid}}" name="sel_lang[]">
                            <div class="col-sm-12 card-header card-custom-header bg-secondary text-white mb-3"><label for="path" class="col-sm-2 col-form-label" >{{$historysub->name}}</label></div><br/>                  
                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-12 mb-btm" id="div{{$historysub->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$historysub->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$historysub->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="{{ $historysub->title ?? old('title.'.$i)}}" required autocomplete="title" placeholder="Enter main title {{$historysub->name}} here" autofocus >
                                </div><br/>

                            </div><br>
                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-12 mb-btm" id="div_content{{$historysub->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Description in {{$historysub->name}} <span class="redalert"> *</span></label>
                                    <textarea id="description{{$historysub->id}}" class="form-control ckeditormilestone @error('description') is-invalid @enderror" name="description[{{$i}}]" value="" required autocomplete="language" placeholder="Enter Content in {{$historysub->name}} here" autofocus >{{strip_tags(htmlspecialchars_decode($historysub->description))}}</textarea>
                                </div><br/>
                            </div>
                            <div class="row div_lan1 mb-3">

                                <div class="col-sm-12 mb-btm" id="div_content{{$historysub->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Content in {{$historysub->name}} <span class="redalert"> *</span></label>
                                    <textarea id="con_title{{$historysub->id}}" class="form-control ckeditormilestone @error('con_title') is-invalid @enderror" name="con_title[{{$i}}]" required autocomplete="language" placeholder="Enter Content in {{$historysub->name}} here" autofocus >{{strip_tags(htmlspecialchars_decode($historysub->content))}}</textarea>
                                </div><br/>
                            </div>

                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-6 mb-btm" id="div_poster{{$historysub->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Poster in {{$historysub->name}}</label>
                                    <input id="poster{{$historysub->id}}" type="file" rel="{{$historysub->id}}" class="poster form-control @error('poster') is-invalid @enderror" name="poster[]" value="{{ $historysub->poster ?? old('poster')}}"  autocomplete="poster" placeholder="Enter poster {{$historysub->name}} here" accept=".jpg,.jpeg,.png"  autofocus >
                                </div>
                               
                                <div class="col-sm-6 mb-btm mb-3 preview_poster" style="display: none;"> 
                                    <img id="preview-image-before-upload{{$historysub->id}}" rel="{{$historysub->id}}" class="preview-image-before-upload imgstamp" src="{{asset('uploads/Milestone/'.$historysub->poster)}}" alt="preview image">
                                    <!-- <br><span class="redalert">selected image</span> -->
                                </div><br/>
                            </div>
                            @php $i++; @endphp
                             @endforeach
                             @endif
                             @else

                            @foreach($language as $langs)
                             <input type="hidden"  value="{{$langs->id ?? ''}}" id="sel_lang{{$langs->id}}" name="sel_lang[]">
                            <div class="col-sm-12 card-header card-custom-header bg-secondary text-white mb-3"><label for="path" class="col-sm-2 col-form-label" >{{$langs->name}}</label></div><br/>                  
                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-12 mb-btm" id="div{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$langs->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="{{ $keydata->title ?? old('title.'.$i)}}" required autocomplete="title" placeholder="Enter main title {{$langs->name}} here" autofocus >
                                </div><br/>

                            </div><br>
                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-12 mb-btm" id="div_content{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Description in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <textarea id="description{{$langs->id}}" class="form-control ckeditormilestone @error('description') is-invalid @enderror" name="description[{{$i}}]" value="{{ $keydata->title ?? old('description.'.$i)}}" required autocomplete="language" placeholder="Enter Content in {{$langs->name}} here" autofocus ></textarea>
                                </div><br/>
                            </div>
                            <div class="row div_lan1 mb-3">

                                <div class="col-sm-12 mb-btm" id="div_content{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Content in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <textarea id="con_title{{$langs->id}}" rel="{{$langs->id}}" class="form-control con_title ckeditormilestone @error('con_title') is-invalid @enderror" name="con_title[{{$i}}]" value="{{ $keydata->title ?? old('con_title.'.$i)}}" required autocomplete="language" placeholder="Enter Content in {{$langs->name}} here" autofocus ></textarea>
                                </div><br/>
                            </div>

                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-6 mb-btm" id="div_poster{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Poster in {{$langs->name}}</label>
                                    <input id="poster{{$langs->id}}" type="file" rel="{{$langs->id}}" class="poster form-control @error('poster') is-invalid @enderror" name="poster[]" value="{{ $keydata->title ?? old('alt_title')}}"  autocomplete="poster" placeholder="Enter poster {{$langs->name}} here" accept=".jpg,.jpeg,.png"  autofocus >
                                </div>
                               
                                <div class="col-sm-6 mb-btm mb-3 preview_poster" style="display: none;"> 
                                    <img id="preview-image-before-upload{{$langs->id}}" rel="{{$langs->id}}" class="preview-image-before-upload imgstamp" src="" alt="preview image">
                                    <!-- <br><span class="redalert">selected image</span> -->
                                </div><br/>
                            </div>

                            @php $i++; @endphp
                            @endforeach  @endif
                            <div class="row div_lan1 mb-3">
                            
                                <div class="col-sm-6 mb-btm" id=""> 
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Year</label>
                                        <select class="form-control select2 formselect" name="year" id="year" required>
                                            <option value="">Select</option>
                                            @foreach($years as $year)
                                                <option value="{{$year}}"  {{ (isset($edit_f) && $keydata->year == $year) ? 'selected' : '' }}> {{$year}}</option>
                                            @endforeach
                                        </select>    
                                </div><br/>

                                <div class="col-sm-6 mb-btm" id=""> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Date <span class="redalert"> *</span></label>
                                    <input type="date" id="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ $keydata->date ?? old('date')}}" required autocomplete="date" placeholder="" autofocus >
                                </div><br/>
                            </div>  
                            <div class="row div_lan1 mb-3">
                                    <div class="col-sm-6 mb-btm" id=""> 
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Icon class</label>
                                        <input id="iconclass" type="text" class="form-control @error('iconclass') is-invalid @enderror" name="iconclass" value="{{ $keydata->icon_class ?? old('icon_class')}}"  autocomplete="iconclass" placeholder="Enter iconclass here" autofocus >
                                    </div><br/>

                                <div class="col-sm-6 mb-btm" id=""> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Link </label>
                                    <input type="text" id="link" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ $keydata->link ?? old('link')}}"  autocomplete="link" placeholder="" autofocus >
                                </div><br/>
                            </div>                     
                            </div>
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

    $('.preview_poster').hide();
    var edit=$('.edit_id').val();

   $('.poster').change(function(){
   var i =$(this).attr('rel');
  

// alert(i);
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
</script>
@endsection