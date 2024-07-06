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
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Downloads</div>
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
                    <form id="formid" method="POST" action="{{ route('sbu.updatedownload') }}" enctype="multipart/form-data">
                    @else
                    <form id="formid" method="POST" action="{{ route('sbu.storedownload') }}" enctype="multipart/form-data">
                    @endif
    
                    @csrf 

                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                        <input type="hidden" name="viewpermission" id="viewpermission" value="{{$keydata->viewpermission ?? ''}}">
                        <input type="hidden" id="edit_id" name="edit_id" value="{{$edit_f ?? ''}}">

                        <div class="row mt-2">
                            <div class="col-sm-6 mb-btm" id=""> 
                                <label class="my-1 mr-2" for="downloadtype">Download Type<span class="redalert"> *</span></label>
                                <select class="form-control select2 formselect" name="downloadtype" id="downloadtype" required>
                                  <option value="">Select</option>
                                    @foreach($download as $downloads)
                                        <option value="{{$downloads->id}}" @if(isset($edit_f))  {{($downloads->id == $keydata->downloadtypeid) ? 'selected' : ''}} @endif >{{$downloads->downloadtype_sub[0]->title}}</option>
                                    @endforeach
                                </select>    
                                <span class="ErrP alert-danger menuerr redalert" style="display: none;">Please Check the downloadtype Entered</span>
                                <span class="redalert">@error('downloadtype'){{$message}} @enderror</span>
                            </div>
                            
                            <div class="col-sm-6 mb-btm" >
                                 <input class="" type="radio" id="publicview" name="viewtype" value="1" @if(isset($edit_f)){{ ($keydata->viewpermission == 1)   ? 'checked' : '' }}  @else @endif>
                                 <label for="View Publicly">View Publicly</label>&nbsp;&nbsp;
                                 <input class="" type="radio" id="restricted" name="viewtype" value="2" @if(isset($edit_f)){{ ($keydata->viewpermission == 2)  ? 'checked' : '' }}  @else @endif>
                                 <label for="Restricted">Restricted</label>&nbsp;&nbsp;
                       
                                 <select style="display: none;" class="usertype_div form-control_edited" id="usertype" name="usertype">
                                    <option selected value="">Select user Type</option>
                                    @foreach($usertype as $usertypes)
                                            <option value="{{\Crypt::encryptString($usertypes->id)}}"  @if(isset($edit_f))   {{($usertypes->id == $keydata->usertype) ? 'selected' : ''}} @endif>{{$usertypes->usertype}}</option>
                                    @endforeach
                               </select>
                            
                           </div> 

                        </div>

                        <div class="row mt-2">
                            <div class="col-sm-6 mb-btm" id=""> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Date<span class="redalert"> *</span></label>
                                    <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ $keydata->date ?? old('date')}}" required autocomplete="date" placeholder="date  here" autofocus >
                                </div><br/>
                        <div class="col-sm-6 mb-btm" id=""> 
                              <label class="my-1 mr-2" for="documentno">Document No/Order No<span class="redalert"> *</span></label>
                              <input id="documentno" type="text" class="form-control @error('documentno') is-invalid @enderror" name="documentno" value="{{ $keydata->documentno ?? old('documentno')}}" required autocomplete="documentno" placeholder="Enter Document/ Order number here" autofocus >
                              <span class="ErrP alert-danger documentnoerr redalert" style="display: none;">Please Check the documentno Entered</span>
                              <span class="redalert">@error('documentno'){{$message}} @enderror</span>
                        </div>    
                        </div>

               
                          <div class="row mb-3 card-header card-main">
                            @php 
                            $i=0;
                            @endphp
                            <!-- edit start -->
                            @if(isset($edit_f)) 

                                @if(isset($keydata->id)) @foreach(($keydata->download_sub) as $download_sub)
                                <input type="hidden"  value="{{$download_sub->languageid ?? ''}}" id="sel_lang{{$download_sub->languageid}}" name="sel_lang[]">
                                <div class="col-sm-12 card-header card-custom-header bg-secondary text-white mb-3"><label for="path" class="col-sm-2 col-form-label" >{{$download_sub->name}}</label></div><br/>                  
                                <div class="row div_lan1 mb-3">
                                    <div class="col-sm-6 mb-btm" id="div{{$download_sub->id}}"> 
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$download_sub->name}} <span class="redalert"> *</span></label>
                                        <input id="title{{$download_sub->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="{{ $download_sub->title ?? old('title.'.$i)}}" required autocomplete="title" placeholder="Enter main {{$download_sub->name}} here" autofocus >
                                    </div><br/>

                                    <div class="col-sm-6 mb-btm" id="div_sub{{$download_sub->id}}"> 
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Sub title in {{$download_sub->name}} </label>
                                        <input id="sub_title{{$download_sub->id}}" type="text" class="form-control @error('sub_title') is-invalid @enderror" name="sub_title[]" value="{{ $download_sub->alternatetext ?? old('sub_title.'.$i)}}" autocomplete="sub_title" placeholder="Enter sub {{$download_sub->name}} here" autofocus >
                                    </div><br/>


                                    <div class="col-sm-12 mb-btm mt-3" id="div_sub{{$download_sub->id}}"> 
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Description in {{$download_sub->name}}</label>
                                    <textarea id="descrptn{{$download_sub->id}}" class="form-control ckeditor @error('descrptn') is-invalid @enderror" name="descrptn[]" value="{{ $download_sub->description ?? old('descrptn.'.$i)}}" autocomplete="language" placeholder="Enter Content in {{$download_sub->name}} here" autofocus ></textarea>
                                    </div><br/>

                                </div><br>

                                @endforeach @endif 
                               <!-- edit end -->    
                                @else
                            @foreach($language as $langs)
                             <input type="hidden"  value="{{$langs->id ?? ''}}" id="sel_lang{{$langs->id}}" name="sel_lang[]">
                            <div class="col-sm-12 card-header card-custom-header bg-secondary text-white mb-3"><label for="path" class="col-sm-2 col-form-label" >{{$langs->name}}</label></div><br/>                  
                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-6 mb-btm" id="div{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$langs->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="{{ $keydata->title ?? old('title.'.$i)}}" required autocomplete="title" placeholder="Enter main {{$langs->name}} here" autofocus >
                                </div><br/>

                                <div class="col-sm-6 mb-btm" id="div_sub{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Sub title in {{$langs->name}} </label>
                                    <input id="sub_title{{$langs->id}}" type="text" class="form-control @error('sub_title') is-invalid @enderror" name="sub_title[]" value="{{ $keydata->sub_title ?? old('sub_title.'.$i)}}" autocomplete="sub_title" placeholder="Enter sub {{$langs->name}} here" autofocus >
                                </div><br/>


                                <div class="col-sm-12 mb-btm mt-3" id="div_sub{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Description in {{$langs->name}}</label>
                                   <textarea id="descrptn{{$langs->id}}" class="form-control ckeditor @error('descrptn') is-invalid @enderror" name="descrptn[]" value="{{ $keydata->title ?? old('descrptn.'.$i)}}" autocomplete="language" placeholder="Enter Content in {{$langs->name}} here" autofocus ></textarea>
                                </div><br/>

                            </div><br>
                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-12 mb-btm" id="div_tags{{$langs->id}}"> 
                                    <div class="form-group">
                                            <label for="exampleFormControlSelect2">Tags in {{$langs->name}} <span class="redalert"> *</span></label>
                                            <select multiple="multiple" class="form-control select2 selecttag" id="tags_id{{$langs->id}}" required name="tags_id[]">
                                                
                                                @php 
                                                    $k=1;
                                                @endphp
                                                @foreach($keywordtags as $keytag)
                                                    @foreach($keytag->keytag_sub as $tagg)
                                                        @if($k==$langs->id)
                                                            <option  value="{{\Crypt::encryptString($keytag->id)}}">{{$tagg->title}}</option>
                                                        @endif
                                                        @php 
                                                    $k++;
                                                @endphp
                                                    @endforeach
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                            </div>
                            @php 
                            $i++;
                            @endphp
                            @endforeach
                            @endif
                            <br>
                            <div class="row mb-1">

                            @if(Auth::user()->role_id!=2) 
                            <div class="col-sm-6 mb-btm d-flex" > 
                                    <input type="checkbox" class="form-check-input" id="homePage_status" name="homePage_status"  @if(isset($edit_f))  @if($keydata->homePage_status==1)}} checked @endif @endif value="1">&nbsp;&nbsp;
                                    <label class="form-check-label" for="exampleCheck1">Featured Article </label>&nbsp;
                                    
                            </div>
                            <div class="col-sm-6 mb-btm d-flex" > 
                                    <input type="checkbox" class="form-check-input" id="main_website_view" name="main_website_view"   @if(isset($edit_f))  @if($keydata->main_website_status==1)}} checked @endif @endif value="1">&nbsp;&nbsp;
                                    <label class="form-check-label" for="exampleCheck1">View in main website </label>&nbsp;<i class="lni lni-invention invention_alert"></i>&nbsp;&nbsp;
                                    
                            </div>
                           @endif
                            </div><br/> 


                            <div class="row mb-1 pt-3">
                                <div class="col-sm-10 offset-sm-2">
                                  @if($edit_f ?? '')
                                    <button type="submit" class="btn btn-warning">Update and Upload images</button>
                                   @else
                                   <button type="submit" class="btn btn-primary">Save and Upload images</button>
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
$("#restricted").click(function () {
    $(".usertype_div").show();
});
var edit=$('#edit_id').val();
// alert(edit);
if(edit)
{
    var viewpermission=$('#viewpermission').val();
    if(viewpermission==2)
    {
        $(".usertype_div").show();
    }
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
