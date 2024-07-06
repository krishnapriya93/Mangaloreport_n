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
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Customer services</div>
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
                    <form id="formid" method="POST" action="{{ route('updatecustservice') }}" enctype="multipart/form-data">
                    @else
                    <form id="formid" method="POST" action="{{ route('storecustservice') }}" enctype="multipart/form-data">
                    @endif
    
                    @csrf 
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">

                        <div class="row mb-3 card-header card-main">
                            @php 
                            $i=0;
                            @endphp

                            @foreach($language as $langs)
                             <input type="hidden"  value="{{$langs->id ?? ''}}" id="sel_lang{{$langs->id}}" name="sel_lang[]">

                                <div class="col-sm-6 mb-btm" id="div{{$langs->id}}"> 
                                     <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Customer services in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$langs->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="" required autocomplete="title" placeholder="Enter {{$langs->name}} here" autofocus  >
                                </div>

                            @php 
                            $i++;
                            @endphp
                            @endforeach
                            <div class="row pt-3">                 
                                <div class="col-sm-12">
                                <label for="menulinktype" class="my-1 mr-2">Menulink type<span class="redalert"> *</span></label>
                                 <select class="form-control select2 formselect" name="menulinktype" id="menulinktype" required>
                                    <option value="">Select</option>
                                @foreach($Menulinktype as $Menulinktypes)
                                    <option value="{{$Menulinktypes->id}}" rel="{{$Menulinktypes->name}}" @if(isset($edit_f))  {{($Menulinktypes->id == $keydata->Menulinktype) ? 'selected' : ''}} @endif >{{$Menulinktypes->name}}</option>
                                @endforeach
                                </select>    
                                <span class="ErrP alert-danger menuerr redalert" style="display: none;">Please Check the Menulinktype Entered</span>
                                <span class="redalert">@error('Menulinktype'){{$message}} @enderror</span>
                                </div>
                            </div><br>
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
                              <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" autocomplete="url" placeholder="Eg: /example"  @if(isset($edit_f)) @if($keydata->menulinktype_id == 12)  value="{{ $keydata->menulinktype_data}}" @endif @endif>
                            <span class="ErrP alert-danger urlerr redalert" style="display: none;">Please Check the url Entered</span>
                            <span class="redalert">@error('url'){{$message}} @enderror</span>
                            </div>
                        </div>

                        <!-- MenuType File -->
                         <div class="row mb-3" id="div_file" style="display:none;">
                            <label for="div_file" class="col-sm-2 col-form-label">File<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                              <input id="file_type" type="file" class="form-control @error('file_type') is-invalid @enderror" name="file_type" value="" autocomplete="file_type" placeholder="Eg: /example" enctype = "multipart/form-data">
                            <span class="ErrP alert-danger fileerr redalert" style="display: none;">Please Check the file Entered</span>
                            <span class="redalert">@error('file'){{$message}} @enderror</span>
                            </div>
                        </div>

                         <!-- MenuType Article -->
                         <div class="row mb-3" id="div_article" style="display:none;">
                            <label for="div_article" class="col-sm-2 col-form-label">Article<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                              <input id="articletype" type="text" class="form-control @error('articletype') is-invalid @enderror" name="articletype" value="" autocomplete="file" placeholder="Eg: /example">
                            <span class="ErrP alert-danger articleerr redalert" style="display: none;">Please Check the Article type Entered</span>
                            <span class="redalert">@error('articletype'){{$message}} @enderror</span>
                            </div>
                        </div>

                        <!-- MenuType Form -->
                         <div class="row mb-3" id="div_form" style="display:none;">
                            <label for="Form" class="col-sm-2 col-form-label">Form<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                              <input id="forms" type="text" class="form-control @error('forms') is-invalid @enderror" name="forms" value="" autocomplete="forms" placeholder="Eg: /example">
                            <span class="ErrP alert-danger formerr redalert" style="display: none;">Please Check the forms type Entered</span>
                            <span class="redalert">@error('forms'){{$message}} @enderror</span>
                            </div>
                        </div>
                          
                            <div class="row mb-1 pt-3">
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



//menu link type
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
    }
    else if(menutype =='Sub'){
        $('#div_anchor').hide();
        $('#div_url').hide();
        $('#div_file').hide();
        $('#div_form').hide();
        $('#div_article').hide();
    }
    });   

</script>
@endsection
