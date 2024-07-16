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
                        <input type="hidden" id="edit_id" name="edit_id" value="{{$edit_f ?? ''}}">
                        <input type="hidden" name="menulinktype_id_edit" id="menulinktype_id_edit" value="{{$keydata->menulinktype_id ?? ''}}">

                        <div class="row pt-3">
                            <label for="linktype" class="col-sm-2 col-form-label">Link Type<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                             <select class="form-control select2 formselect" name="linktype" id="linktype" required>
                                <option value="">Select</option>
                            @foreach($linktype as $linktypes)
                                <option value="{{$linktypes->id}}" @if(isset($edit_f))  {{($linktypes->id == $keydata->linktypeid) ? 'selected' : ''}} @endif >{{$linktypes->linktype_sub[0]->title}}</option>
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
                            @if(isset($edit_f))

                            @if(isset($keydata->id)) @foreach(($keydata->link_sub) as $link_sub)
                            <input type="hidden"  value="{{$link_sub->languageid ?? ''}}" id="sel_lang{{$link_sub->languageid}}" name="sel_lang[]">
                                    <div class="row div_lan1 mb-3 pt-3">
                                        <div class="col-sm-6 mb-btm" id="div{{$link_sub->id}}">
                                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$link_sub->lang_sel->name}}<span class="redalert"> *</span></label>
                                            <input id="title{{$link_sub->id}}" type="text" class="form-control title title_validation @error('title') is-invalid @enderror" name="title[]" value="{{ $link_sub->title ?? old('title.'.$i)}}" rel="{{$link_sub->id}}" required autocomplete="title" placeholder="Enter main {{$link_sub->name}} here" autofocus >
                                            <span class="ErrP redalert titleerr1 display_status">Please Check the {{$link_sub->name}} title Entered</span>
                                            <span class="ErrP redalert titleerr2 display_status">Please Check the {{$link_sub->name}} title Entered</span>
                                        </div><br/>

                                        <div class="col-sm-6 mb-btm" id="div{{$link_sub->id}}">
                                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Alternative text in {{$link_sub->lang_sel->name}} <span class="redalert"> *</span></label>
                                            <input id="alt_text{{$link_sub->id}}" type="text" class="form-control @error('alt_text') is-invalid @enderror" name="alt_text[]" value="{{ $link_sub->alternatetext ?? old('alt_text.'.$i)}}" required autocomplete="alt_text" placeholder="Enter main {{$link_sub->name}} here" autofocus >
                                        </div><br/>
                                    </div><br>

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
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Alternative text in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="alt_text{{$langs->id}}" type="text" class="form-control @error('alt_text') is-invalid @enderror" name="alt_text[]" value="{{ $keydata->alt_text ?? old('alt_text.'.$i)}}" required autocomplete="alt_text" placeholder="Enter main {{$langs->name}} here" autofocus >
                                </div><br/>

                            </div><br><hr>

                            @php
                            $i++;
                            @endphp
                            @endforeach
                            @endif

                            <div class="row mb-3">
                            <label for="menulinktype" class="col-sm-2 col-form-label">Menulink Type<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                             <select class="form-control select2 formselect" name="menulinktype" id="menulinktype" required>
                                <option value="">Select</option>
                            @foreach($Menulinktype as $Menulinktypes)
                                <option value="{{$Menulinktypes->id}}" rel="{{$Menulinktypes->name}}" @if(isset($edit_f))  {{($Menulinktypes->id == $keydata->menulinktype_id) ? 'selected' : ''}} @endif >{{$Menulinktypes->name}}</option>
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
                         <div class="row mb-3" id="div_article"   @if(isset($keydata->menulinktype_id)) @if($keydata->menulinktype_id) != 14) style="display:none;" @endif @endif>
                         <label for="div_article" class="col-sm-2 col-form-label">Article<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                            <select class="form-control select2 formselect" name="articletype" id="articletype">

                            @foreach($arttype as $arttypeon)

                                @foreach($arttypeon->articletype_sub as $artsub)

                                    <option value="{{$artsub->id}}" rel="{{$artsub->title}}" @if(isset($edit_f))  {{($keydata->menulinktype_data == $artsub->articletypeid) ? 'selected' : ''}} @endif >{{$artsub->title}}</option>
                                @endforeach
                            @endforeach
                            </select>
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
                              <!-- MenuType route -->
                              <div class="row mb-3" id="div_route"   @if(isset($keydata->menulinktype_id)) @if($keydata->menulinktype_id) != 16) style="display:none;" @endif @endif>
                            <label for="div_route" class="col-sm-2 col-form-label">Route<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                              <input id="route" type="text" class="form-control @error('route') is-invalid @enderror" name="route"  autocomplete="route" placeholder="Eg:example" @if(isset($edit_f)) @if($keydata->menulinktype_id == 16)  value="{{ $keydata->menulinktype_data}}" @endif @endif enctype = "multipart/form-data" >
                            <span class="ErrP alert-danger routeerr redalert" style="display: none;">Please Check the filroutee Entered</span>
                            <span class="redalert">@error('route'){{$message}} @enderror</span>
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
                                    <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ $keydata->file ?? old('file')}}" autocomplete="file" placeholder="Enter file here" accept="image/png, image/jpeg" autofocus >
                                </div><br/>
                                <div class="col-sm-3 mb-btm" id="div_file">
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref"> <span class="redalert"> </span></label>
                                    @if(isset($edit_f))  @if($keydata->file) <img src="{{asset('/assets/backend/uploads/Linkicon/'.$keydata->file)}}" class="imgstamp preview-image-before-upload">@endif @endif
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
$('#div_anchor').hide();
         $('#div_url').hide();
         $('#div_file').hide();
         $('#div_article').hide();
         $('#div_form').hide();
         $('#div_route').hide();

$('#menulinktype').on('change ', function(e) {

    var menutype = $("#menulinktype option:selected").attr('rel');

    if (menutype == 'Anchor') {
         $('#div_anchor').show();
         $('#div_url').hide();
         $('#div_file').hide();
         $('#div_article').hide();
         $('#div_form').hide();
         $('#div_route').hide();

    }else if (menutype == 'URL'){
        $('#div_anchor').hide();
        $('#div_url').show();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_route').hide();

    }else if(menutype =='File'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').show();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_route').hide();

    }else if(menutype =='Article'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').show();
        $('#div_route').hide();

    }else if(menutype =='Form'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').show();
        $('#div_article').hide();
        $('#div_route').hide();

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
        $('#div_route').hide();

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

     //Edit
     var edit=$('#edit_id').val();
    //  alert(edit);


     if(edit=='E')
    {
        var menulinktype_id_edit=$('#menulinktype_id_edit').val();
        // alert(menulinktype_id_edit);
        if (menulinktype_id_edit == 11) {
         $('#div_anchor').show();
         $('#div_url').hide();
         $('#div_file').hide();
         $('#div_article').hide();
         $('#div_form').hide();
         $('#div_route').hide();
         $('#div_download').hide();
    }else if (menulinktype_id_edit == 12){
        $('#div_anchor').hide();
        $('#div_url').show();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_route').hide();
        $('#div_download').hide();
    }else if(menulinktype_id_edit ==13){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').show();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_route').hide();
        $('#div_download').hide();
    }else if((menulinktype_id_edit ==14)  || (menulinktype_id_edit == 20)){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').show();
        $('#div_route').hide();
        $('#div_download').hide();
                 //SORT ARTICLE

            var sbu_user=$('#sbu_user').val();
            var article_id_edit =$('#article_id_edit').val();
            // alert(article_id_edit);
                $.ajax({
                url: "{{route('admin.articleload')}}",
                type : 'GET',
                data: {'sbu_user':sbu_user},
                success: function(response){
                // console.log(response);
                // $('#unit').append(unit);
                var length = response.length;

                $('#articletype').empty();
                    // $('#articletype').append($('<option></option>').val('').html('Select'));
                    $.each(response, function(index, element) {
                        console.log(element.articletype_sub);
                        $.each(element.articletype_sub, function(index1, element1) {
                            console.log(element1);
                            if(article_id_edit==element1.articletypeid){
                                $('#articletype').append(
                            $('<option></option>').val(element1.articletypeid).html(element1.title) ).attr('selected','selected');
                            }else{
                                $('#articletype').append(
                            $('<option></option>').val(element1.articletypeid).html(element1.title) );
                            }

                        })

                    })
            }});

    }else if(menulinktype_id_edit ==15){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').show();
        $('#div_article').hide();
        $('#div_route').hide();
        $('#div_download').hide();
    }
    else if(menulinktype_id_edit ==16){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_route').show();
        $('#div_download').hide();
    }
    else if(menulinktype_id_edit ==17){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_route').hide();
        $('#div_download').hide();
    }else if(menulinktype_id_edit ==21){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_route').hide();
        $('#div_download').show();

            var sbu_user=$('#sbu_user').val();
            var download_id_edit =$('#article_id_edit').val();
            // alert(article_id_edit);
                $.ajax({
                url: "{{route('admin.downloadtypeload')}}",
                type : 'GET',
                data: {'sbu_user':sbu_user},
                success: function(response){
                // console.log(response);
                // $('#unit').append(unit);
                var length = response.length;


                var length = response.length;
        //   alert(mainmenu_edit);
          $('#downloadtype').empty();

            $.each(response, function(index, element) {

                $.each(element.downloadtype_sub, function(index1, element1) {

                    if(download_id_edit==element1.downloadtypeid){
                        console.log(element1.downloadtypeid);
                        $('#downloadtype').append(
                    $('<option></option>').val(element1.downloadtypeid).html(element1.title).attr('selected','selected')
                );
                    }else{

                        $('#downloadtype').append(
                    $('<option></option>').val(element1.downloadtypeid).html(element1.title)
                );
                    }

                })

            })
            }});

    }

        // $('.card-main').hide();
    }else{
//  $('.card-main').show();
    }
</script>
@endsection
