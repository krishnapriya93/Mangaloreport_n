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
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Contact us</div>

                <div class="card-body">
                  @if(session('success'))
                      <div class="alert alert-success" role="alert">
                           {{ session('success') }}
                       </div>
                   @endif
                   @if(isset($edit_f))
                    <form id="formiid" method="POST" action="{{ route('siteadmin.updatecontactus') }}" enctype="multipart/form-data">
                    @else
                    <form id="formiid" method="POST" action="{{ route('siteadmin.storecontactus') }}" enctype="multipart/form-data">
                    @endif

                    @csrf 
                    <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                    <input type="hidden" name="edit_id" id="edit_id" value="{{$edit_f ?? ''}}">
                    <input type="hidden" name="dashboard_id" id="dashboard_id" value="{{$keydata->viewer_id ?? ''}}">
            
                    <div class="row mb-3 card-header card-main">

                        @php $i=0; @endphp

                        @if(isset($edit_f)) 

                    @if(isset($keydata->id)) @foreach(($keydata->contact_sub) as $contact_sub)
                    <input type="hidden"  value="{{$contact_sub->languageid ?? ''}}" id="sel_lang{{$contact_sub->languageid}}" name="sel_lang[]">
                            <div class="row div_lan1 mb-3 pt-3">
                                <div class="col-sm-12 mb-btm" id="div{{$contact_sub->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$contact_sub->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$contact_sub->id}}" type="text" class="form-control title title_validation @error('title') is-invalid @enderror" name="title[]" value="{{ $contact_sub->title ?? old('title.'.$i)}}" rel="{{$contact_sub->id}}" required autocomplete="title" placeholder="Enter main {{$contact_sub->name}} here" autofocus >
                                    <span class="ErrP redalert titleerr1 display_status">Please Check the {{$contact_sub->name}} title Entered</span>
                                     <span class="ErrP redalert titleerr2 display_status">Please Check the {{$contact_sub->name}} title Entered</span>
                                </div><br/>
                            </div><br>
                            <div class="row div_lan2 mb-3">
                                <div class="col-sm-12 mb-btm" id="div_add{{$contact_sub->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Address in {{$contact_sub->name}}</label>
                                    <textarea id="address{{$contact_sub->id}}" type="text" class="form-control ckeditor @error('address') is-invalid @enderror" name="address[{{$i}}]" value="{{ $contact_sub->address ?? old('address')}}" required autocomplete="address" placeholder="Enter address {{$contact_sub->address}} here" autofocus >{{ $contact_sub->address  }}</textarea>
                                </div><br/>
                            </div>
                            @php  $i++; @endphp
                      @endforeach @endif 
                    @else
                      @foreach($language as $langs)
                             <input type="hidden"  value="{{$langs->id ?? ''}}" id="sel_lang{{$langs->id}}" name="sel_lang[]">
                            <!-- <div class="col-sm-12 card-header card-custom-header bg-secondary text-white mb-3"><label for="path" class="col-sm-2 col-form-label" >{{$langs->name}}</label></div><br/>                   -->
                            <div class="row div_lan1 mb-3 pt-3">
                                <div class="col-sm-12 mb-btm" id="div{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Contact title in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$langs->id}}" type="text" class="form-control title title_validation @error('title') is-invalid @enderror" name="title[]" value="{{ $keydata->title ?? old('title.'.$i)}}" rel="{{$langs->id}}" required autocomplete="title" placeholder="Enter main {{$langs->name}} here" autofocus >
                                    <span class="ErrP redalert titleerr1 display_status">Please Check the {{$langs->name}} title Entered</span>
                                     <span class="ErrP redalert titleerr2 display_status">Please Check the {{$langs->name}} title Entered</span>
                                </div><br/>
                            </div><br>

                           
                            <div class="row div_lan2 mb-3">
                                <div class="col-sm-12 mb-btm" id="div_add{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Address in {{$langs->name}}</label>
                                    <textarea id="address{{$langs->id}}" type="text" class="form-control ckeditor @error('address') is-invalid @enderror" name="address[{{$i}}]" value="{{ $keydata->title ?? old('alt_title')}}" required autocomplete="address" placeholder="Enter address {{$langs->name}} here" autofocus ></textarea>
                                </div><br/>
                            </div>

                            @php 
                            $i++;
                            @endphp
                            @endforeach
                            @endif

                  
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12 mb-btm" id="email"> 
                                 <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Email <span class="redalert"> *</span></label>
                                <textarea id="emails" class="form-control ckeditor @error('email') is-invalid @enderror" name="emails" value="{{ $keydata->contactemail ?? old('emails')}}" required placeholder="Enter email here" autofocus >{{ $keydata->contactemail ?? old('contactemail') }}</textarea>
                                <span class="ErrP contact_emailerr display_status">Please Check the inputEmail Entered</span>
                            </div><br/>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12 mb-btm" id="phone1"> 
                                 <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Phone Number </label>
                                <textarea id="phone1s" class="form-control ckeditor @error('phone1s') is-invalid @enderror" name="phone1s" value="{{ $keydata->contactphone ?? old('phone1s')}}" required placeholder="Enter phone here" autofocus >{{ $keydata->contactphone  ?? old('phone1s') }}</textarea>
                                <span class="ErrP  contact_phoneerr1 display_status">Please Check the inputPhone number Entered. 10 Digits only</span>
                            </div><br/>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-12 mb-btm" id="map"> 
                                 <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Map </label>
                                <input id="map" type="text" class="form-control @error('map') is-invalid @enderror" name="map" value="{{ $keydata->map ?? old('map')}}"  autocomplete="map" placeholder="Enter map here" autofocus >
                                <span class="ErrP  maperr display_status">Please Check the input Entered</span>
                            </div><br/>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12 mb-btm" id="website"> 
                                 <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Websites </label>
                                <textarea id="website" type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ $keydata->website ?? old('website')}}" required autocomplete="website" placeholder="Enter website here" autofocus >{{ $keydata->website ?? old('website')}}</textarea>
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
    $(window).on('load', function (){
    $( '.ckeditor12' ).ckeditor();
});
   
   
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


    });

    //email validation
    $('#email').on('keyup', function(e) {
        var testres = emailval('#contact_email', this.value);
        if (!testres) {
            $('.contact_emailerr').text('must be like abc123@abc123.com');

            $('.contact_emailerr').show();
        } else {
            $('.contact_emailerr').hide();
        }
    });


 //map validation
$('#map').on('keyup', function(e) {
        var testres = mapval('#map', this.value);
        if (!testres) {
            $('.maperr').text('only url format ');

            $('.maperr').show();
        } else {
            // $('#mapsrc').attr('src',this.value);
            $('.maperr').hide();
        }
    });

    //Sbu

</script>
@endsection
