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
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Submenu</div>

                <div class="card-body">
                  @if(session('success'))
                      <div class="alert alert-success" role="alert">
                           {{ session('success') }}
                       </div>
                   @endif

                    @if(session('error'))
                      <div class="alert alert-warning" role="alert">
                           {{ session('error') }}
                       </div>
                   @endif

                   @if(isset($edit_f))
                    <form id="formiid" method="POST" action="{{ route('updatesubmenu') }}" enctype="multipart/form-data">
                    @else
                    <form id="formiid" method="POST" action="{{ route('storesubmenu') }}" enctype="multipart/form-data">
                    @endif

                    @csrf
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                        <input type="hidden" name="edit_id"  id="edit_id" value="{{$edit_f ?? ''}}">
                        <input type="hidden" id="mainmenu_edit" name="mainmenu_edit" value="{{$keydata->mainmenu_id ?? ''}}">
                        <input type="hidden" id="article_id_edit" name="article_id_edit" value="{{$keydata->articletype_id ?? ''}}">
                        <input type="hidden" id="download_id_edit" name="download_id_edit" value="{{$keydata->menulinktype_data ?? ''}}">
                        <input type="hidden" name="menulinktype_id_edit" id="menulinktype_id_edit" value="{{$keydata->menulinktype_id ?? ''}}">
                        <div class="row mb-3">

                           @if(isset($edit_f))

                           @if(isset($keydata->id)) @foreach(($keydata->submenusub) as $submenusub)
                           <input type="hidden"  value="{{$submenusub->languageid ?? ''}}" id="sel_lang{{$submenusub->languageid}}" name="sel_lang[]">
                                <div class="col-sm-6 mb-btm" id="div{{$submenusub->id}}">
                                     <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Submenu title <span class="redalert"> *</span></label>

                                    <input id="title{{$submenusub->id}}" type="text" class="form-control title @error('title') is-invalid @enderror" name="title[]"  rel="{{$submenusub->id}}" value="{{$submenusub->title}}" required autocomplete="title" placeholder="Enter  here" autofocus  >
                                      <span class="ErrP alert-danger redalert titleerr1" style="display: none;">Please Check the {{$submenusub->title}} title Entered</span>
                                     <span class="ErrP alert-danger redalert titleerr2" style="display: none;">Please Check the {{$submenusub->title}} title Entered</span>
                                </div>
                           @endforeach @endif
                           @else
                           @foreach($language as $langs)

                            <input type="hidden"  value="{{$langs->id ?? ''}}" id="sel_lang{{$langs->id}}" name="sel_lang[]">
                              <div class="col-sm-6 mb-btm" id="div{{$langs->id}}">
                                     <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Submenu title in {{$langs->name}} <span class="redalert"> *</span></label>

                                    <input id="title{{$langs->id}}" type="text" class="form-control title @error('title') is-invalid @enderror" name="title[]"  rel="{{$langs->id}}" value="" required autocomplete="title" placeholder="Enter {{$langs->name}} here" autofocus  >
                                     <span class="ErrP alert-danger redalert titleerr1" style="display: none;">Please Check the {{$langs->name}} title Entered</span>
                                     <span class="ErrP alert-danger redalert titleerr2" style="display: none;">Please Check the {{$langs->name}} title Entered</span>
                                </div>
                             @endforeach
                             @endif

                        </div><br>

                         <div class="row mb-3">
                            <label for="mainmenuid" class="col-sm-2 col-form-label">Main menu<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                             <select class="form-control select2 formselect" name="mainmenuid" id="mainmenuid" required>
                                <option value="">Select</option>



                            @foreach($mainmenu as $mainmenus)

                            <option value="">Select</option>
                            <option value="{{$mainmenus->id}}" rel="{{$mainmenus->title}}" {{ (old('mainmenuid', isset($keydata->mainmenu_id) ? $keydata->mainmenu_id :old('mainmenu_id'))==$mainmenus->id) ? 'selected':'' }} >{{$mainmenus->mainmenu_sub[0]->title}}</option>
                            @endforeach

                            </select>
                            <span class="ErrP alert-danger menuerr redalert" style="display: none;">Please Check the mainmenuid Entered</span>
                            <span class="redalert">@error('mainmenuid'){{$message}} @enderror</span>
                            </div>
                        </div>

                           <div class="row mb-3">
                            <label for="icon_class" class="col-sm-2 col-form-label">Icon Class</label>
                            <div class="col-sm-10">
                            <input id="icon_class" type="text" class="form-control @error('icon_class') is-invalid @enderror" name="icon_class" value="{{ $keydata->iconclass ?? old('iconclass')}}" autocomplete="icon_class" placeholder="Eg: lni lni-search-alt" autofocus>
                            <span class="ErrP alert-danger redalert iconerr" style="display: none;">Please Check the icon_class Entered</span>
                            <span class="redalert">@error('icon_class'){{$message}} @enderror</span>
                            </div>
                        </div>

                         <div class="row mb-3">
                            <label for="menulinktype" class="col-sm-2 col-form-label">Menulink Type<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                             <select class="form-control select2 formselect" name="menulinktype" id="menulinktype" required>
                                <option value="">Select</option>
                            @foreach($Menulinktype as $Menulinktypes)
                                <option value="{{$Menulinktypes->id}}" rel="{{$Menulinktypes->name}}" {{ (old('menulinktype', isset($keydata->menulinktype_id) ? $keydata->menulinktype_id :old('menulinktype'))==$Menulinktypes->id) ? 'selected':'' }}  >{{$Menulinktypes->name}}</option>
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

                        <!-- MenuType Urlddd -->
                         <div class="row mb-3" id="div_url"  @if(isset($edit_f)) @if($keydata->menulinktype_id == 12) class="hhhhhhhh"  style="display:show;"   @else style="display:none;"  @endif @endif>
                            <label for="div_url" class="col-sm-2 col-form-label">URL<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                              <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" autocomplete="url" placeholder="Eg: /example"  @if(isset($edit_f)) @if($keydata->menulinktype_id == 12)  value="{{ $keydata->menulinktype_data}}" @endif @endif>
                            <span class="ErrP alert-danger urlerr redalert" style="display: none;">Please Check the url Entered</span>
                            <span class="redalert">@error('url'){{$message}} @enderror</span>
                            </div>
                        </div>

                        <!-- MenuType File -->
                         <div class="row mb-3" id="div_file" @if(isset($edit_f)) @if($keydata->menulinktype_id == 13) class="hhhhhhhh"  style="display:show;"   @else style="display:none;"  @endif @endif>
                            <label for="div_file" class="col-sm-2 col-form-label">File<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                              <input id="file_type" type="file" class="form-control @error('file_type') is-invalid @enderror" name="file_type" accept="aapplication/pdf" autocomplete="file_type" placeholder="Eg: /example" enctype = "multipart/form-data"  @if(isset($edit_f)) @if($keydata->menulinktype_id == 13)  value="{{ $keydata->menulinktype_data}}" @endif @endif>
                            <span class="ErrP alert-danger fileerr redalert" style="display: none;">Please Check the file Entered</span>
                            <span class="redalert">@error('file'){{$message}} @enderror</span>
                            </div>
                            <div class="col-sm-2">
                               @if(isset($edit_f))  @if($keydata->menulinktype_id == 13) <div> <a target="_blank" href="{{asset('uploads/Submenu/'.$keydata->menulinktype_data)}}">View uploaded File</a> </div> @endif @endif
                            </div>
                        </div>

                         <!-- MenuType Article -->
                         <div class="row mb-3" id="div_article" style="display:none;">
                            <label for="div_article" class="col-sm-2 col-form-label">Article<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                            <select class="form-control select2 formselect" name="articletype" id="articletype">
                                    <option value="" rel="" ></option>
                              </select>
                              <!-- <input id="articletype" type="text" class="form-control @error('articletype') is-invalid @enderror" name="articletype" value="" autocomplete="file" placeholder="Eg: /example"  @if(isset($edit_f)) @if($keydata->menulinktype_id == 14)  value="{{ $keydata->menulinktype_data}}" @endif @endif> -->
                            <span class="ErrP alert-danger articleerr redalert" style="display: none;">Please Check the Article type Entered</span>
                            <span class="redalert">@error('articletype'){{$message}} @enderror</span>
                            </div>
                        </div>
                        <!-- MenuType Downloads -->
                        <div class="row mb-3" id="div_download"   @if(isset($keydata->menulinktype_id)) @if($keydata->menulinktype_id) != 21) style="display:none;" @endif @endif>
                        <label for="div_download" class="col-sm-2 col-form-label">Download type<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                                <select class="form-control select2 formselect" name="downloadtype" id="downloadtype">
                                </select>
                                    <!-- <input id="articletype" type="text" class="form-control @error('articletype') is-invalid @enderror" name="articletype"  autocomplete="file" placeholder="Eg: /example" @if(isset($edit_f)) @if($keydata->menulinktype_id == 14)  value="{{ $keydata->menulinktype_data}}" @endif @endif> -->
                                    <span class="ErrP alert-danger downloaderr redalert" style="display: none;">Please Check the download type Entered</span>
                                    <span class="redalert">@error('downloadtype'){{$message}} @enderror</span>
                            </div>
                        </div>
                        <!-- MenuType Form -->
                         <div class="row mb-3" id="div_form" style="display:none;">
                            <label for="Form" class="col-sm-2 col-form-label">Form<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                              <input id="forms" type="text" class="form-control @error('forms') is-invalid @enderror" name="forms" value="" autocomplete="forms" placeholder="Eg: /example"  @if(isset($edit_f)) @if($keydata->menulinktype_id == 15)  value="{{ $keydata->menulinktype_data}}" @endif @endif>
                            <span class="ErrP alert-danger formerr redalert" style="display: none;">Please Check the forms type Entered</span>
                            <span class="redalert">@error('forms'){{$message}} @enderror</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="ord_num" class="col-sm-2 col-form-label">Order number<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                                <input id="ord_num" type="text" class="form-control @error('ord_num') is-invalid @enderror" name="ord_num" value="{{ $keydata->orderno ?? $orderno_val }}" required autocomplete="ord_num" placeholder="enter order number here" autofocus>
                                <span class="ErrP article-poster-img keyiderr" style="display: none;"> <i class="lni lni-warning redalert"></i> Same Order number Already exist </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-10 offset-sm-2">
                               @if($edit_f ?? '')
                                <button type="submit" class="btn btn-warning submitBtn">Update</button>
                               @else
                               <button type="submit" class="btn btn-primary submitBtn">Add </button>
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
    $( "#ord_num" ).on( "keyup", function() {
    var orderno = $(this).val();

    $('.keyiderr').hide();
    $.ajax({
        url: "{{route('admin.ordernumberchecksubmenu')}}",
        type : 'GET',
        data: {'orderno':orderno,'sbutype_id':sbutype_id,'viewer_id':viewer_id},
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

    var edit=$('#edit_id').val();
    // alert(edit);
    var sbu_view_edit=$('#sbu_view_edit').val();
    // alert(sbu_view_edit);
         $('#div_anchor').hide();
         $('#div_url').hide();
         $('#div_file').hide();
         $('#div_article').hide();
         $('#div_form').hide();
         $('.div_lan1').hide();
         $('.div_lan2').hide();
         $('#div_route').hide();
         $('#div_download').hide();
//SORT SUB MENU WISE

    if(sbu_view_edit==2){
        $(".usertype_div").show();
        if(edit=='E')
        {
        var sbu_id =$('#sbu_type_edit').val();
        var mainmenu_edit =$('#mainmenu_edit').val();

        $.ajax({
        url: "{{route('admin.sbuwisemainmenu')}}",
        type : 'GET',
        data: {'sbu_id':sbu_id,'mainmenu_edit':mainmenu_edit},
        success: function(response){
        // console.log(response);
          // $('#unit').append(unit);
          var length = response.length;
        //   alert(mainmenu_edit);
          $('#mainmenuid').empty();
            // $('#mainmenuid').append($('<option></option>').val('').html('Select'));
            // $('.degree').val(data.degree).attr('selected',true);
            $.each(response, function(index, element) {
                // console.log(element.mainmenu_sub);
                $.each(element.mainmenu_sub, function(index1, element1) {
                    // console.log(element1);

                    if(mainmenu_edit==element1.mainmenuid){
                        $('#mainmenuid').append(
                    $('<option></option>').val(element1.mainmenuid).html(element1.title).attr('selected','selected')
                );
                    }else{

                        $('#mainmenuid').append(
                    $('<option></option>').val(element1.mainmenuid).html(element1.title)
                );
                    }

                })

            })

    }});
        }
    }
//SORT SUB MENU WISE-END



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
         $('#div_download').hide();
    }else if (menulinktype_id_edit == 12){
        $('#div_anchor').hide();
        $('#div_url').show();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }else if(menulinktype_id_edit ==13){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').show();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }else if((menulinktype_id_edit ==14) || (menulinktype_id_edit == 20)){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').show();
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


                var length = response.length;
        //   alert(mainmenu_edit);
          $('#articletype').empty();
            // $('#mainmenuid').append($('<option></option>').val('').html('Select'));
            // $('.degree').val(data.degree).attr('selected',true);
            $.each(response, function(index, element) {
                // console.log(element.mainmenu_sub);
                $.each(element.articletype_sub, function(index1, element1) {

                    if(article_id_edit==element1.articletypeid){
                        $('#articletype').append(
                    $('<option></option>').val(element1.articletypeid).html(element1.title).attr('selected','selected')
                );
                    }else{

                        $('#articletype').append(
                    $('<option></option>').val(element1.articletypeid).html(element1.title)
                );
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
        $('#div_download').hide();
    }
    else if(menulinktype_id_edit ==16){
        $('#div_anchor').hide();
        $('#div_url').show();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    } else if(menulinktype_id_edit ==17){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }  else if(menulinktype_id_edit == 21){

        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_route').hide();
        $('#div_download').show();

        var sbu_user=$('#sbu_user').val();
        var download_id_edit =$('#download_id_edit').val();
            // alert(download_id_edit);
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
    else if(menulinktype_id_edit ==22){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }else if(menulinktype_id_edit ==23){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }else if(menulinktype_id_edit ==24){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }else if(menulinktype_id_edit ==25){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }else if(menulinktype_id_edit ==26){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }
    $('.card-main').hide();

    }else{
 $('.card-main').show();
    }
$('.div_lan1').hide();
$('.div_lan2').hide();
    // validation in LAng.
    $('.title').on('keyup', function(e) {

        if($(this).attr('rel')==1)
        {
              var testres = engtitle('.title', this.value);
                if (!testres) {
                    // alert($(this).parent().find( ".titleerr1" ).html());
                    $(this).find( ".titleerr1" ).text("Not Allowed / only english ");
                    // $('.titleerr1').text("Not Allowed1 ");
                    $('.titleerr2').hide();
                    $(this).parent().find( ".titleerr1" ).show();
                    // $('.titleerr1').show();

                } else {
                    $('.titleerr1').hide();
                    $('.titleerr2').hide();
                }
            }else if($(this).attr('rel')==2)
            {
                 var testres = maltitle('.title', this.value);
                if (!testres) {
                    // $('.titleerr2').text("Not Allowed2");
                      $(this).find( ".titleerr2" ).text("Not Allowed/ only malayalam ");
                    $('.titleerr1').hide();
                    // $(this).parent().find( ".titleerr2" ).show();
                    // $('.titleerr2').show();

                } else {
                    $('.titleerr2').hide();
                    $('.titleerr1').hide();
                }
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
   $(".radioval").click(function () {

    var val=$(this).attr('value');
    var check =  $(this).prop('checked');

    if(check)
    {

        if($(this).attr('value') != '') {
            $('.div_lan1').show();
            $('.div_lan2').show();
            $('#div'+val).show();
            $('#div_alt'+val).show();
            $('#div_poster'+val).show();
            $('#div_sub'+val).show();
            $('#div_cont'+val).show();
       }

       else {

            $('#div'+val).hide();
            $('#div_poster'+val).hide();
            $('#div_sub'+val).hide();
            $('#div_alt'+val).hide();
            $('#div_cont'+val).hide();
       }

    }else{

         $('#div'+val).hide();
         $('#div_sub'+val).hide();
         $('#div_poster'+val).hide();
         $('.div_lan1').hide();
         $('.div_lan2').hide();
         $('#div_alt').hide();
         $('#div_cont'+val).hide();
         $("#sel_lang"+val).prop('checked', false);
    }


   });



//menu link type
  $('#menulinktype').on('change ', function(e) {
    var menutype = $("#menulinktype option:selected").attr('rel');

    if (menutype == 'Anchor') {
         $('#div_anchor').show();
         $('#div_url').hide();
         $('#div_file').hide();
         $('#div_article').hide();
         $('#div_form').hide();
         $('#div_download').hide();
    }else if (menutype == 'URL'){
        $('#div_anchor').hide();
        $('#div_url').show();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }else if(menutype =='File'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').show();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }else if((menutype =='Article') || (menutype == 'Multiple Article')){
        // alert("sss");
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').show();
        $('#div_download').hide();
        //SORT ARTICLE

        if((menutype =='Article') || (menutype == 'Multiple Article'))
        {
            var sbu_user=$('#sbu_user').val();
                // alert(sbu_user);
                $.ajax({
                url: "{{route('admin.articleload')}}",
                type : 'GET',
                data: {'sbu_user':sbu_user},
                success: function(response){
                // console.log(response);
                // $('#unit').append(unit);
                var length = response.length;

                $('#articletype').empty();
                    $('#articletype').append($('<option></option>').val('').html('Select'));
                    $.each(response, function(index, element) {

                        // console.log(element.articletype_sub);
                        $.each(element.articletype_sub, function(index1, element1) {
                            // console.log(element1);
                            $('#articletype').append(
                            $('<option></option>').val(element1.articletypeid).html(element1.title)
                        );
                        })

                    })
            }});
        }
//SORT ARTICLE End

    }else if(menutype =='Form'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').show();
        $('#div_article').hide();
        $('#div_download').hide();
    }else if(menutype =='Sub'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }
    else if(menutype =='Route'){
        $('#div_anchor').hide();
        $('#div_url').show();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }else if(menutype =='Downloads'){
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
    else if(menutype =='Milestone'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }else if(menutype =='BOD'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }else if(menutype =='Whoswho'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }else if(menutype =='Whatweoffer'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }else if(menutype =='Chief-officers'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
        $('#div_download').hide();
    }

    });



});
</script>
@endsection
