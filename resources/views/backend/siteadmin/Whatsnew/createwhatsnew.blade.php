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
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Article</div>
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
                    <form id="formid" method="POST" action="{{ route('siteadmin.updatewhatsnew') }}" enctype="multipart/form-data">
                    @else
                    <form id="formid" method="POST" action="{{ route('siteadmin.storewhatsnew') }}" enctype="multipart/form-data">
                    @endif
                    @elseif(Auth::user()->role_id=5)
                    @if(isset($edit_f))
                    <form id="formid" method="POST" action="{{ route('sbu.updatewhatsnew') }}" enctype="multipart/form-data">
                    @else
                    <form id="formid" method="POST" action="{{ route('sbu.storewhatsnew') }}" enctype="multipart/form-data">
                    @endif
                    @endif

                    @csrf 
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">

                        <div class="row mb-3 card-header card-main">
                            @php 
                            $i=0;
                            @endphp
                            @if(isset($edit_f)) 
                        
                                @if(isset($keydata->id)) @foreach(($keydata->whats_sub) as $whats_sub)
                                    <input type="hidden"  value="{{$whats_sub->languageid ?? ''}}" id="sel_lang{{$whats_sub->languageid}}" name="sel_lang[]">
                                <div class="col-sm-12 card-header card-custom-header bg-secondary text-white mb-3"><label for="path" class="col-sm-2 col-form-label" >{{$whats_sub->name}}</label></div><br/>                  
                                <div class="row div_lan1 mb-3">
                                    <div class="col-sm-6 mb-btm" id="div{{$whats_sub->id}}"> 
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$whats_sub->name}} <span class="redalert"> *</span></label>
                                        <input id="title{{$whats_sub->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="{{ $whats_sub->title ?? old('title.'.$i)}}" required autocomplete="title" placeholder="Enter main {{$whats_sub->name}} here" autofocus >
                                    </div><br/>

                                    <div class="col-sm-6 mb-btm" id="div_sub{{$whats_sub->id}}"> 
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Sub title in {{$whats_sub->name}} <span class="redalert"> *</span></label>
                                        <input id="sub_title{{$whats_sub->id}}" type="text" class="form-control @error('sub_title') is-invalid @enderror" name="sub_title[]" value="{{ $whats_sub->subtitle ?? old('subtitle.'.$i)}}" required autocomplete="sub_title" placeholder="Enter sub {{$whats_sub->name}} here" autofocus >
                                    </div><br/>

                                </div><br>
                                <div class="row div_lan1 mb-3">

                                    <div class="col-sm-12 mb-btm" id="div_content{{$whats_sub->id}}"> 
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Content in {{$whats_sub->name}} <span class="redalert"> *</span></label>
                                        <textarea id="con_title{{$whats_sub->id}}" class="form-control ckeditor @error('con_title') is-invalid @enderror" name="con_title[]" value="{{ $whats_sub->content ?? old('con_title.'.$i)}}" required autocomplete="language" placeholder="Enter Content in {{$whats_sub->name}} here" autofocus >{{$whats_sub->content}}</textarea>
                                    </div><br/>
                                </div>

                                @endforeach
                                @endif @else
                            @foreach($language as $langs)
                             <input type="hidden"  value="{{$langs->id ?? ''}}" id="sel_lang{{$langs->id}}" name="sel_lang[]">
                            <div class="col-sm-12 card-header card-custom-header bg-secondary text-white mb-3"><label for="path" class="col-sm-2 col-form-label" >{{$langs->name}}</label></div><br/>                  
                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-6 mb-btm" id="div{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$langs->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="{{ $keydata->title ?? old('title.'.$i)}}" required autocomplete="title" placeholder="Enter main {{$langs->name}} here" autofocus >
                                </div><br/>

                                <div class="col-sm-6 mb-btm" id="div_sub{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Sub title in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="sub_title{{$langs->id}}" type="text" class="form-control @error('sub_title') is-invalid @enderror" name="sub_title[]" value="{{ $keydata->sub_title ?? old('sub_title.'.$i)}}" required autocomplete="sub_title" placeholder="Enter sub {{$langs->name}} here" autofocus >
                                </div><br/>

                            </div><br>
                            <div class="row div_lan1 mb-3">

                                <div class="col-sm-12 mb-btm" id="div_content{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Content in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <textarea id="con_title{{$langs->id}}" class="form-control ckeditor @error('con_title') is-invalid @enderror" name="con_title[]" value="{{ $keydata->title ?? old('con_title.'.$i)}}" required autocomplete="language" placeholder="Enter Content in {{$langs->name}} here" autofocus ></textarea>
                                </div><br/>
                            </div>

                            @php 
                            $i++;
                            @endphp
                            @endforeach
                            @endif
                            <div class="row mb-1">
                                <div class="col-sm-10 offset-sm-2">
                                   @if($edit_f ?? '')
                                    <button type="submit" class="btn btn-warning">Update</button>
                                   @else
                                   <button type="submit" class="btn btn-primary">Add </button>
                                   @endif
                                   @if(Auth::user()->role_id=2)
                                    <a type="submit" class="btn btn-success" href="{{route('siteadmin.createwhatsnew')}}">Refresh</a>
                                   @elseif(Auth::user()->role_id=5)
                                    <a type="submit" class="btn btn-success" href="{{route('sbu.createwhatsnew')}}">Refresh</a>
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
// if($('#Errval').val()!=1){
//     $("#entry_div").hide();

// }
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