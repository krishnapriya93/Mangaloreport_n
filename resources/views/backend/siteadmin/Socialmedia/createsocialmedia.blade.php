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
            <div class="card">
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Social media</div>

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
             
                   @if(isset($edit_f))
                    <form id="formiid" method="POST" action="{{ route('updatesocialmedia') }}" enctype="multipart/form-data">
                    @else
                    <form id="formiid" method="POST" action="{{ route('storesocialmedia') }}" enctype="multipart/form-data">
                    @endif
    
                    @csrf 
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                        <input type="hidden" name="edit_id" value="{{$edit_f ?? ''}}">
                        <div class="row mb-3 card-header card-main">
                        <label class="my-1 mr-2"><span class="redalert">* Please select language and fill data</span></label><br>
                            @php 
                              $i=0;
                             
                            @endphp

                            @if(isset($edit_f)) 
                            @if(isset($keydata->id)) @foreach(($keydata->socialmedia_sub) as $socialmediasub)
                            <div class="col-sm-12 card-header card-custm-header"><label for="path" class="col-sm-2 col-form-label" >Title {{$socialmediasub->name}} </label>
                           <input type="hidden" id="sel_lang{{$socialmediasub->id}}" name="sel_lang[]" value="{{$socialmediasub->id}}" ></div><br/>
                                <div class="row div_lan1">
                                    <div class="col-sm-6 mb-btm" id="div{{$socialmediasub->id}}"> 
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Title in {{$socialmediasub->name}} <span class="redalert"> *</span></label>
                                        <input id="title{{$socialmediasub->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="{{ $socialmediasub->title ?? old('title')}}" required autocomplete="title" placeholder="Enter main {{$socialmediasub->name}} here" autofocus  >
                                    </div><br/>

                                    <div class="col-sm-6 mb-btm" id="div_alt{{$socialmediasub->id}}"> 
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Alternative title in {{$socialmediasub->name}}</label>
                                        <input id="alt_title{{$socialmediasub->id}}" type="text" class="form-control @error('alt_title') is-invalid @enderror" name="alt_title[]" value="{{ $socialmediasub->alternatetext ?? old('alternatetext')}}" required autocomplete="language" placeholder="Enter Alternative {{$socialmediasub->name}} here" autofocus >
                                    </div><br/>

                                </div><br>

                        <div class="row div_lan1 mb-3"></div>                   
                            @endforeach @endif
                            @else

                         @foreach($language as $langs)
                            <div class="col-sm-12 card-header card-custm-header"><label for="path" class="col-sm-2 col-form-label" >Title {{$langs->name}} </label>
                            <input type="hidden" id="sel_lang{{$langs->id}}" name="sel_lang[]" value="{{$langs->id}}" ></div><br/>
                            <div class="row div_lan1">
                                <div class="col-sm-6 mb-btm" id=""> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Title in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$langs->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="" required autocomplete="title" placeholder="Enter main {{$langs->name}} here" autofocus  >
                                </div><br/>

                                <div class="col-sm-6 mb-btm" id=""> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Alternative title in {{$langs->name}}</label>
                                    <input id="alt_title{{$langs->id}}" type="text" class="form-control @error('alt_title') is-invalid @enderror" name="alt_title[]" value="{{ $keydata->title ?? old('alt_title')}}" required autocomplete="language" placeholder="Enter Alternative {{$langs->name}} here" autofocus >
                                </div><br/>

                            </div><br>

                            <div class="row div_lan1 mb-3"></div>
                         @endforeach  @endif
                        </div>
                                                 
                          <div class="row mb-3">
                            <label for="path" class="col-sm-2 col-form-label">URL<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                            <input id="path" type="text" class="form-control @error('path') is-invalid @enderror" name="path" value="{{ $keydata->url ?? old('path')}}" required autocomplete="path" placeholder="Enter path here" autofocus>
                            <span class="ErrP alert-danger patherr redalert" style="display: none;">Please Check the URL Entered</span>
                            <span class="redalert">@error('path'){{$message}} @enderror</span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="path" class="col-sm-2 col-form-label">Icon Class<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                            <input id="iconclass" type="text" class="form-control @error('iconclass') is-invalid @enderror" name="iconclass" value="{{ $keydata->url ?? old('iconclass')}}" required autocomplete="iconclass" placeholder="Enter path here" autofocus>
                            <span class="ErrP alert-danger patherr redalert" style="display: none;">Please Check the classicon Entered</span>
                            <span class="redalert">@error('iconclass'){{$message}} @enderror</span>
                            </div>
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

@section('mainscript')
<script>  
 $( document ).ready(function() {
    var edit=$('.edit_id').val();
//     if(edit=='E')
//     {
//         $('.card-main').hide();
//     }else{
//  $('.card-main').show();
//     }
// $('.div_lan1').hide();
// $('.div_lan2').hide();
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
//             $('#div_icon'+val).show(); 
//             $('#div_sub'+val).show();        
//        }

//        else {
        
//             $('#div'+val).hide();  
//             $('#div_icon'+val).hide(); 
//             $('#div_sub'+val).hide(); 
//             $('#div_alt'+val).hide();  
//        }

//     }else{
        
//          $('#div'+val).hide();
//          $('#div_sub'+val).hide();   
//          $('#div_icon'+val).hide(); 
//          $('.div_lan1').hide();
//          $('.div_lan2').hide();
//          $('#div_alt').hide();
//          $("#sel_lang"+val).prop('checked', false);
//     }

   
//    });

});
</script>
@endsection
@include('layouts.commonscript')