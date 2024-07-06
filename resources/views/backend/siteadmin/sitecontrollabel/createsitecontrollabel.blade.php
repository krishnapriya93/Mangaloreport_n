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
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Site label control</div>
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
                   
                    @if(isset($edit_f))
                    <form id="formid" method="POST" action="{{ route('siteadmin.updatesitecontrollabel') }}" enctype="multipart/form-data">
                    @else
                    <form id="formid" method="POST" action="{{ route('siteadmin.storesitecontrollabel') }}" enctype="multipart/form-data">
                    @endif
                  

                    @csrf 
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">

                        <div class="row mb-3 card-header card-main">
                            @php 
                            $i=0;
                            @endphp
                            @if(isset($edit_f)) 
                        
                                @if(isset($keydata->id)) @foreach(($keydata->sitelcontrollabel_sub) as $sitelcontrollabel_sub)
                                    <input type="hidden"  value="{{$sitelcontrollabel_sub->languageid ?? ''}}" id="sel_lang{{$sitelcontrollabel_sub->languageid}}" name="sel_lang[]">
                                <div class="col-sm-12 card-header card-custom-header bg-secondary text-white mb-3"><label for="path" class="col-sm-2 col-form-label" >{{$sitelcontrollabel_sub->name}}</label></div><br/>                  
                                <div class="row div_lan1 mb-3">
                                    <div class="col-sm-6 mb-btm" id="div{{$sitelcontrollabel_sub->id}}"> 
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$sitelcontrollabel_sub->name}} <span class="redalert"> *</span></label>
                                        <input id="title{{$sitelcontrollabel_sub->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="{{ $sitelcontrollabel_sub->title ?? old('title.'.$i)}}" required autocomplete="title" placeholder="Enter main {{$sitelcontrollabel_sub->name}} here" autofocus >
                                    </div><br/>

                                    <div class="col-sm-6 mb-btm" id="div_sub{{$sitelcontrollabel_sub->id}}"> 
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Sub title in {{$sitelcontrollabel_sub->name}}</label>
                                        <input id="sub_title{{$sitelcontrollabel_sub->id}}" type="text" class="form-control @error('sub_title') is-invalid @enderror" name="sub_title[]" value="{{ $sitelcontrollabel_sub->alternatetext ?? old('alternatetext.'.$i)}}" autocomplete="sub_title" placeholder="Enter sub {{$sitelcontrollabel_sub->name}} here" autofocus >
                                    </div><br/>

                                </div><br>
        

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
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Alternative title in {{$langs->name}} </label>
                                    <input id="sub_title{{$langs->id}}" type="text" class="form-control @error('sub_title') is-invalid @enderror" name="sub_title[]" value="{{ $keydata->sub_title ?? old('sub_title.'.$i)}}" autocomplete="sub_title" placeholder="Enter sub {{$langs->name}} here" autofocus >
                                </div><br/>

                            </div><br>
                       
      

                            @php 
                            $i++;
                            @endphp
                            @endforeach
                            @endif
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-btm" id="div_key"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Key id <span class="redalert"> *</span></label>
                                    <input id="keyid" type="text" class="form-control @error('keyid') is-invalid @enderror" name="keyid" value="{{ $keydata->keyid ?? old('keyid.'.$i)}}" required autocomplete="keyid" placeholder="Enter key id here" autofocus >
                                    <span class="ErrP article-poster-img keyiderr" style="display: none;"> <i class="lni lni-warning redalert"></i> Same key id Already exist </span>
                                </div><br/>

                            </div><br>
                            <div class="row mb-1">
                                <div class="col-sm-10 offset-sm-2">
                                   @if($edit_f ?? '')
                                    <button type="submit" class="btn btn-warning submitBtn">Update</button>
                                   @else
                                   <button type="submit" class="btn btn-primary submitBtn">Add </button>
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

//check key have or not
$( "#keyid" ).on( "keyup", function() {
    var keyid = $(this).val(); 
    $('.keyiderr').hide();
    $.ajax({
        url: "{{route('siteadmin.keyidchecksitecontrollabel')}}", 
        type : 'GET',
        data: {'keyid':keyid},
        success: function(response){
        console.log(response);
        
          if(response==0)
          {
            $('.keyiderr').hide();
            $('.submitBtn').prop('disabled', false);
          }else{
            $('.keyiderr').show();
            $('.submitBtn').prop('disabled', true);
          }
    }});
} );
</script>
@endsection