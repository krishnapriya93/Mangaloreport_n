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
                    @if(isset($edit_f))
                    <form id="formid" method="POST" action="{{ route('updatelink') }}" enctype="multipart/form-data">
                    @else
                    <form id="formid" method="POST" action="{{ route('storelink') }}" enctype="multipart/form-data">
                    @endif
    
                    @csrf 
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                        <div class="row pt-3">
                            <label for="linktype" class="col-sm-2 col-form-label">Link Type<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                             <select class="form-control select2 formselect" name="linktype" id="linktype" required>
                                <option value="">Select</option>
                            @foreach($linktype as $linktypes)
                                <option value="{{$linktypes->id}}" @if(isset($edit_f))  {{($linktypes->id == $keydata->download->id) ? 'selected' : ''}} @endif >{{$linktypes->linktype_sub[0]->title}}</option>
                            @endforeach
                            </select>    
                            <span class="ErrP alert-danger menuerr redalert" style="display: none;">Please Check the downloadtype Entered</span>
                            <span class="redalert">@error('downloadtype'){{$message}} @enderror</span>
                            </div>
                        </div>

                        <div class="row mb-3 card-header card-main">
                            @php 
                            $i=0;
                            @endphp
                             
                            @foreach($language as $langs)
                             <input type="hidden"  value="{{$langs->id ?? ''}}" id="sel_lang{{$langs->id}}" name="sel_lang[]">
                            <div class="col-sm-12 card-header card-custom-header bg-secondary text-white mb-3"><label for="path" class="col-sm-2 col-form-label" >{{$langs->name}}</label></div><br/>                  
                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-6 mb-btm" id="div{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$langs->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="{{ $keydata->title ?? old('title.'.$i)}}" required autocomplete="title" placeholder="Enter main {{$langs->name}} here" autofocus >
                                </div><br/>

                                <div class="col-sm-6 mb-btm" id="div{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Alternative text in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="alt_text{{$langs->id}}" type="text" class="form-control @error('alt_text') is-invalid @enderror" name="alt_text[]" value="{{ $keydata->alt_text ?? old('alt_text.'.$i)}}" required autocomplete="alt_text" placeholder="Enter main {{$langs->name}} here" autofocus >
                                </div><br/>

                            </div><br><hr>

                            @php 
                            $i++;
                            @endphp
                            @endforeach
                            <div class="row mb-3">
                            <label for="menulinktype" class="col-sm-2 col-form-label">Menulink Type<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                             <select class="form-control select2 formselect" name="menulinktype" id="menulinktype" required>
                                <option value="">Select</option>
                            @foreach($Menulinktype as $Menulinktypes)
                                <option value="{{$Menulinktypes->id}}" rel="{{$Menulinktypes->name}}" @if(isset($edit_f))  {{($Menulinktypes->id == $keydata->menu_link_type->id) ? 'selected' : ''}} @endif >{{$Menulinktypes->name}}</option>
                            @endforeach
                            </select>    
                            <span class="ErrP alert-danger menuerr redalert" style="display: none;">Please Check the menulinktype Entered</span>
                            <span class="redalert">@error('menulinktype'){{$message}} @enderror</span>
                            </div>
                        </div>

                        <!-- MenuType Anchor -->
                         <div class="row mb-3" id="div_anchor" @if(isset($edit_f)) @if($keydata->menulinktype_id == 11)  style="display:show;"  @endif @else style="display:none;"  @endif>
                            <label for="div_anchor" class="col-sm-2 col-form-label">Anchor<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                              <input id="Anchor" type="text" class="form-control @error('Anchor') is-invalid @enderror" name="Anchor" autocomplete="Anchor" placeholder="Eg: https://example.com"   @if(isset($edit_f)) @if($keydata->menulinktype_id == 11)  value="{{ $keydata->menulinktype_data}}" @endif @endif>
                            <span class="ErrP alert-danger Ancherr redalert" style="display: none;">Please Check the Anchor Entered</span>
                            <span class="redalert">@error('Anchor'){{$message}} @enderror</span>
                            </div>
                        </div>
                        
                        <!-- MenuType Url -->
                         <div class="row mb-3" id="div_url"  @if(isset($edit_f)) @if($keydata->menulinktype_id == 12)  style="display:show;"  @endif @else style="display:none;"  @endif>
                            <label for="div_url" class="col-sm-2 col-form-label">URL<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                              <input id="url_menu" type="text" class="form-control @error('url_menu') is-invalid @enderror" name="url_menu" autocomplete="url_menu" placeholder="Eg: /example"  @if(isset($edit_f)) @if($keydata->menulinktype_id == 12)  value="{{ $keydata->menulinktype_data}}" @endif @endif>
                            <span class="ErrP alert-danger urlerr redalert" style="display: none;">Please Check the url Entered</span>
                            <span class="redalert">@error('url'){{$message}} @enderror</span>
                            </div>
                        </div>

                        <!-- MenuType File -->
                         <div class="row mb-3" id="div_file"  @if(isset($edit_f)) @if($keydata->menulinktype_id == 13)  style="display:show;"  @endif @else style="display:none;"  @endif>
                            <label for="div_file" class="col-sm-2 col-form-label">File<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                              <input id="file_type" type="file" class="form-control @error('file_type') is-invalid @enderror" name="file_type" value="" autocomplete="file_type" placeholder="Eg: /example" enctype = "multipart/form-data">
                            <span class="ErrP alert-danger fileerr redalert" style="display: none;">Please Check the file Entered</span>
                            <span class="redalert">@error('file'){{$message}} @enderror</span>
                            </div>
                        </div>

                         <!-- MenuType Article -->
                         <div class="row mb-3" id="div_article"  @if(isset($edit_f)) @if($keydata->menulinktype_id == 14)  style="display:show;"  @endif @else style="display:none;"  @endif>
                            <label for="div_article" class="col-sm-2 col-form-label">Article<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                              <input id="articletype" type="text" class="form-control @error('articletype') is-invalid @enderror" name="articletype" value="" autocomplete="file" placeholder="Eg: /example">
                            <span class="ErrP alert-danger articleerr redalert" style="display: none;">Please Check the Article type Entered</span>
                            <span class="redalert">@error('articletype'){{$message}} @enderror</span>
                            </div>
                        </div>

                        <!-- MenuType Form -->
                         <div class="row mb-3" id="div_form"  @if(isset($edit_f)) @if($keydata->menulinktype_id == 15)  style="display:show;"  @endif @else style="display:none;"  @endif>
                            <label for="Form" class="col-sm-2 col-form-label">Form<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                              <input id="forms" type="text" class="form-control @error('forms') is-invalid @enderror" name="forms" value="" autocomplete="forms" placeholder="Eg: /example">
                            <span class="ErrP alert-danger formerr redalert" style="display: none;">Please Check the forms type Entered</span>
                            <span class="redalert">@error('forms'){{$message}} @enderror</span>
                            </div>
                        </div>
                        <!-- MenuType Route -->
                        <div class="row mb-3" id="div_route"  @if(isset($edit_f)) @if($keydata->menulinktype_id == 15)  style="display:show;"  @endif @else style="display:none;"  @endif>
                            <label for="Form" class="col-sm-2 col-form-label">Form<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                              <input id="route" type="text" class="form-control @error('route') is-invalid @enderror" name="route" value="" autocomplete="forms" placeholder="Eg: /example">
                            <span class="ErrP alert-danger formerr redalert" style="display: none;">Please Check the forms type Entered</span>
                            <span class="redalert">@error('forms'){{$message}} @enderror</span>
                            </div>
                        </div>
                            <div class="row">
                               <div class="col-sm-6 mb-btm"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">URL</label>
                                    <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ $keydata->url ?? old('url')}}"  autocomplete="url" placeholder="Enter url here" autofocus >
                                </div><br/>
                     
                               <div class="col-sm-6 mb-btm"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Icon class</label>
                                        <!-- <span class="redalert"> *</span> -->
                                    <input id="iconclass" type="text" class="form-control @error('iconclass') is-invalid @enderror" name="iconclass" value="{{ $keydata->iconclass ?? old('iconclass')}}" autocomplete="iconclass" placeholder="Enter iconclass here" autofocus >
                                </div><br/>
                            </div><br/>

                            <div class="row pt-3">
                               <div class="col-sm-6 mb-btm"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">File</label>
                                    <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ $keydata->file ?? old('file')}}" autocomplete="file" placeholder="Enter file here" autofocus >
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
$('#menulinktype').on('change ', function(e) {
    var menutype = $("#menulinktype option:selected").attr('rel');

    if (menutype == 'Anchor') {
         $('#div_anchor').show();
         $('#div_url').hide();
         $('#div_file').hide();
         $('#div_article').hide();
         $('#div_form').hide();
    }else if (menutype == 'URL'){
        $('#div_anchor').hide();
        $('#div_url').show();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
    }else if(menutype =='File'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').show();
        $('#div_form').hide();
        $('#div_article').hide();
    }else if(menutype =='Article'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').show();
    }else if(menutype =='Form'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').show();
        $('#div_article').hide();
    }else if(menutype =='Route'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_route').show();
        $('#div_article').hide();
    }
    else if(menutype =='Sub'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
    }
    }); 
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
