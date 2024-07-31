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
            <div class="card" id="entry_div">
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Public relation</div>
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
                    <form id="formid" method="POST" action="{{ route('updatepublicrelation') }}" enctype="multipart/form-data">
                        @else
                        <form id="formid" method="POST" action="{{ route('storepublicrelation') }}" enctype="multipart/form-data">
                            @endif


                            @csrf
                            <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">

                            <div class="row mb-3 card-header card-main">
                                @php
                                $i=0;
                                @endphp

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="publicrelid" class="my-1 mr-2">Public relation type<span class="redalert"> *</span></label>
                                        <select class="form-control" id="publicrelid" name="publicrelid" required>
                                            <option>Select Public relation Type</option>

                                            @foreach($pulicreltype as $ptype)

                                                @foreach($ptype->ptypesub as $psub)
                                                    <option value="{{$ptype->id}}" @if(isset($edit_f)) {{ $ptype->id == $keydata->publicreltypeid ? 'selected' : '' }} @endif  >{{$psub->title}}</option>
                                                @endforeach

                                            @endforeach
                                        </select>

                                        <span class="ErrP alert-danger menuerr redalert" style="display: none;">Please Check the downloadtype Entered</span>
                                        <span class="redalert">@error('pulicreltype'){{$message}} @enderror</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="departmentid" class="my-1 mr-2">Department<span class="redalert"> *</span></label>
                                        <select class="form-control formselect" name="departmentid" id="departmentid" required>
                                            <option value="">Select</option>

                                            @foreach($departments as $department)
                                            <option value="{{$department->tid}}" @if(isset($edit_f)) {{ $department->tid == $keydata->departmentid ? 'selected' : '' }} @endif>{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="ErrP alert-danger menuerr redalert" style="display: none;">Please Check the downloadtype Entered</span>
                                        <span class="redalert">@error('pulicreltype'){{$message}} @enderror</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-btm" id="div">
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref"> Last Date <span class="redalert"> *</span></label>
                                        <input id="date" type="date" class="form-control date  @error('date') is-invalid @enderror" name="date" value="{{ $keydata->date ?? old('date')}}" rel="" required autocomplete="date" placeholder="Enter main here" autofocus>
                                        <span class="ErrP redalert titleerr1 display_status">Please Check the Entered</span>
                                        <span class="ErrP redalert titleerr2 display_status">Please Check Entered</span>
                                    </div>


                                </div>

                                @if(isset($edit_f))

                                @if(isset($keydata->id)) @foreach(($keydata->publicrelsub) as $publicrel_sub)
                                <input type="hidden" value="{{$publicrel_sub->languageid ?? ''}}" id="sel_lang{{$publicrel_sub->languageid}}" name="sel_lang[]">
                                <div class="row div_lan1 mb-3 pt-3">
                                    <div class="col-sm-12 mb-btm" id="div{{$publicrel_sub->id}}">
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$publicrel_sub->lang->name}} <span class="redalert"> *</span></label>
                                        <input id="title{{$publicrel_sub->id}}" type="text" class="form-control title title_validation @error('title') is-invalid @enderror" name="title[]" value="{{ $publicrel_sub->title ?? old('title.'.$i)}}" rel="{{$publicrel_sub->id}}" required autocomplete="title" placeholder="Enter main {{$publicrel_sub->name}} here" autofocus>
                                        <span class="ErrP redalert titleerr1 display_status">Please Check the {{$publicrel_sub->name}} title Entered</span>
                                        <span class="ErrP redalert titleerr2 display_status">Please Check the {{$publicrel_sub->name}} title Entered</span>
                                    </div><br />
                                </div><br>

                                <div class="row div_lan1 mb-3">

                                    <div class="col-sm-12 mb-btm" id="div_content{{$publicrel_sub->languageid}}">
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Content in {{$publicrel_sub->lang->name}} <span class="redalert"> *</span></label>
                                        <textarea id="con_title[{{$publicrel_sub->languageid}}]" class="form-control con_title ckeditorarticle @error('con_title') is-invalid @enderror" name="con_title[]" required autocomplete="language" placeholder="Enter Content in {{$publicrel_sub->languageid}} here" autofocus>
                                        {{ $publicrel_sub->content ?? old('con_title.'.$i)}}
                                        </textarea>
                                    </div><br />
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 mb-btm" id="div_poster{{$publicrel_sub->lang->name}}">
                                        <div class="col-sm-6"> <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Poster {{$publicrel_sub->lang->name}}</label>
                                            <input id="poster{{$publicrel_sub->languageid}}" type="file" class="form-control poster @error('poster') is-invalid @enderror" name="poster[]" rel="{{$publicrel_sub->languageid}}" value="" autocomplete="language" placeholder="Enter main {{$publicrel_sub->languageid}} here" autofocus accept="image/png, image/jpeg, image/jpg">
                                            <img id="img_show" src="" class="img-thumbnail" alt="..." style="display: none;" width="120px" height="100px">
                                            <span class="redalert postererr{{$publicrel_sub->languageid}}"></span>

                                        </div>
                                        <div class="col-sm-3 mb-btm mb-3 preview_poster">
                                            <img id="preview-image-before-upload{{$publicrel_sub->id}}" src="{{ asset('/assets/backend/uploads/publicrelation/'.$publicrel_sub->image) }}" rel="{{$publicrel_sub->id}}" class="preview-image-before-upload imgstamp" alt="preview image">
                                            <!-- <br><span class="redalert">selected image</span> -->
                                        </div><br />

                                    </div><br />
                                </div>


                                @endforeach @endif
                                @else
                                @foreach($language as $langs)

                                <input type="hidden" value="{{$langs->id ?? ''}}" id="sel_lang{{$langs->id}}" name="sel_lang[]">
                                <div class="three">
                                    <h1>{{$langs->name}}</h1>
                                </div>
                                <div class="row div_lan1 mb-3 pt-3">
                                    <div class="col-sm-12 mb-btm" id="div{{$langs->id}}">
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$langs->name}} <span class="redalert"> *</span></label>
                                        <input id="title{{$langs->id}}" type="text" class="form-control title title_validation @error('title') is-invalid @enderror" name="title[]" value="{{ $keydata->title ?? old('title.'.$i)}}" rel="{{$langs->id}}" required autocomplete="title" placeholder="Enter main {{$langs->name}} here" autofocus>
                                        <span class="ErrP redalert titleerr1 display_status">Please Check the {{$langs->name}} title Entered</span>
                                        <span class="ErrP redalert titleerr2 display_status">Please Check the {{$langs->name}} title Entered</span>
                                    </div><br />
                                </div><br>

                                <div class="row div_lan1 mb-3">

                                    <div class="col-sm-12 mb-btm" id="div_content{{$langs->id}}">
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Content in {{$langs->name}} <span class="redalert"> *</span></label>
                                        <textarea id="con_title[{{$langs->id}}]" class="form-control ckeditorarticle con_title @error('con_title') is-invalid @enderror" name="con_title[]" required autocomplete="language" placeholder="Enter Content in {{$langs->name}} here" autofocus>
                                        </textarea>
                                    </div><br />
                                </div>


                                <div class="row">
                                    <div class="col-sm-12 mb-btm" id="div_poster{{$langs->id}}">
                                        <div class="col-sm-6"> <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Poster {{$langs->name}}</label>
                                            <input id="poster{{$langs->id}}" type="file" class="form-control poster @error('poster') is-invalid @enderror" name="poster[]" rel="{{$langs->id}}" value=""  autocomplete="language" placeholder="Enter main {{$langs->name}} here" autofocus accept="image/png, image/jpeg, image/jpg">
                                            <img id="img_show" src="" class="img-thumbnail" alt="..." style="display: none;" width="120px" height="100px">
                                            <span class="redalert postererr{{$langs->id}}"></span>

                                        </div>
                                        <div class="col-sm-3 mb-btm mb-3 preview_poster" style="display: none;">
                                            <img id="preview-image-before-upload{{$langs->id}}" rel="{{$langs->id}}" class="preview-image-before-upload imgstamp" src="" alt="preview image">
                                            <!-- <br><span class="redalert">selected image</span> -->
                                        </div><br />
                                    </div><br />
                                </div>

                                @php
                                $i++;
                                @endphp
                                @endforeach
                                @endif

                                <div class="row">
                                    <div class="col-sm-6 mb-btm mt-2" id="div">
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref"> </label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Home page status
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">

                            </div>
                            <!-- ./inner-card-iterate -->
                            <div><br /></div>


                            <div class="row mb-1 pt-3">
                                <div class="col-sm-10 offset-sm-2">
                                    @if($edit_f ?? '')
                                    <button type="submit" class="btn btn-warning">Update and Upload images</button>
                                    @else
                                    <button type="submit" class="btn btn-primary">Save and Upload images</button>
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
    $(document).ready(function() {
        // if($('#Errval').val()!=1){
        //     $("#entry_div").hide();

        // }
            // Iterate over each input with the class 'poster'
    $('.con_title').each(function() {
        var elementId = $(this).attr('id');

        // Destroy any existing CKEditor instances with the same ID
        if (CKEDITOR.instances[elementId]) {
            CKEDITOR.instances[elementId].destroy(true);
        }

        // Initialize CKEditor on the element
        CKEDITOR.replace(elementId);
    });
});
        $('.postererr1').hide();
        $('.postererr2').hide();


        //poster view
        $('.poster').change(function() {
            var i = $(this).attr('rel');

            var value = '#preview-image-before-upload' + i;

            $('.preview_poster').show();
            let reader = new FileReader();

            reader.onload = (e) => {

                $(value).attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
            // $(".poster")[0].reset();
        });


    //image prevew

    // $('.preview-image-before-upload').on('load', function(e) {
    //     var image = new Image();
    //     // $('.postererr1').hide();
    //     // $('.postererr2').hide();
    //     image.src = $(this).attr("src");
    //     var rel_id = $(this).attr('rel');
    //     var value = '#preview-image-before-upload' + rel_id;
    //     // alert(value);
    //     // if(rel_id==1)
    //     // {
    //     var testres = imageheightwidth(value, image.width, image.height);
    //     // alert(testres);

    //     if (testres == 'true') { //okay
    //         $('.postererr' + rel_id).hide();
    //         // $('.postererr2').hide();

    //     } else { //error
    //         $('.postererr' + rel_id).append(' ' + testres);
    //         $('.postererr' + rel_id).show();


    //     }



    // });

    // validation in LAng.
    $('.title_validation').on('keyup', function(e) {

        if ($(this).attr('rel') == 1) {
            var testres = engtitle('.title', this.value);

            if (!testres) {
                // alert($(this).parent().find( ".titleerr1" ).html());
                $(this).find(".titleerr1").text("Not Allowed / only english ");
                // $('.titleerr1').text("Not Allowed1 ");
                $('.titleerr2').hide();
                $(this).parent().find(".titleerr1").show();
                // $('.titleerr1').sh
            } else {
                $('.titleerr1').hide();
                $('.titleerr2').hide();
            }
            var testres1 = engtitle('.sub_title', this.value);
            if (!testres) {
                // alert($(this).parent().find( ".titleerr1" ).html());
                $(this).find(".titleerr3").text("Not Allowed / only english ");
                // $('.titleerr1').text("Not Allowed1 ");
                $('.titleerr4').hide();
                $(this).parent().find(".titleerr3").show();
                // $('.titleerr1').sh
            } else {
                $('.titleerr3').hide();
                $('.titleerr4').hide();
            }
            var testres2 = engtitle('.alt_title', this.value);
            if (!testres) {
                // alert($(this).parent().find( ".titleerr1" ).html());
                $(this).find(".titleerr5").text("Not Allowed / only english ");
                // $('.titleerr1').text("Not Allowed1 ");
                $('.titleerr6').hide();
                $(this).parent().find(".titleerr5").show();
                // $('.titleerr1').sh
            } else {
                $('.titleerr5').hide();
                $('.titleerr6').hide();
            }
        } else if ($(this).attr('rel') == 2) {
            var testres = maltitle('.title', this.value);

            if (!testres) {
                $(this).find(".titleerr2").text("Not Allowed/ only malayalam ");
                $('.titleerr1').hide();
            } else {
                $('.titleerr2').hide();
                $('.titleerr1').hide();
            }

            var testres1 = maltitle('.sub_title', this.value);
            if (!testres) {
                $(this).find(".titleerr4").text("Not Allowed/ only malayalam ");
                $('.titleerr3').hide();

            } else {
                $('.titleerr4').hide();
                $('.titleerr3').hide();
            }

            var testres1 = maltitle('.alt_title', this.value);
            if (!testres) {
                $(this).find(".titleerr6").text("Not Allowed/ only malayalam ");
                $('.titleerr5').hide();

            } else {
                $('.titleerr6').hide();
                $('.titleerr5').hide();
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


    function img_preview() {

        // cropper.destroy();
        // $('.cropper-hide').attr('src','');
        // $('.cropper-view-box img').attr('src','');
        var imageFiles = document.getElementById("photo"),
            files = imageFiles.files;

        var image = document.querySelector('#image');

        var testres = imageval_cropper('#photo', imageFiles.files[0], '#img_show');
        // var testres = 'false';
        // alert(testres);
        if (testres == 'true') {
            $('.postererr').html('');
            $('.postererr').hide();

            // var crpperDDivv=`<div id="crpImg" class="col-md-12 d-flex justify-content-md-start">

            // <img id="image"  src="" class="img-thumbnail" alt="...">

            // </div>`;

            // $("#crpImg").load(location.href + " #crpImg>*", crpperDDivv);

            const [file] = photo.files

            if (file) {
                // alert(URL.createObjectURL(file));

                image.src = URL.createObjectURL(file);
                // var MyBlob = new Blob([URL.createObjectURL(file)], {type : 'text/plain'});
                var MyBlob = new Blob([URL.createObjectURL(file)], {
                    type: 'text/plain'
                });
                console.log(MyBlob instanceof Blob) // true
                // document.body.innerHTML = MyBlob instanceof Blob;
                // console.log(URL.createObjectURL(file)+":::::"+MyBlob instanceof Blob);
            }

            $('#CropDiv').show();

            $('#image').show();
            $('#poster_div').hide();
        } else {
            $('.postererr').html('');
            $('.postererr').html(testres);
            $('.postererr').show();

        }

    }

    function imageval_cropper(id, testval) {
        var file = testval;
        var fileType = file["type"];
        var filesize = file["size"];
        //alert(filesize);

        var validImageTypes = ["image/jpeg", "image/jpg"];
        if ($.inArray(fileType, validImageTypes) < 0) {
            return 'Only file type: webp/jpeg/png/jpg is acceptable';
        } else {

            if (filesize > 10000000) {

                return 'Size should be less than 10 MB';
            } else {
                return 'true';
            }


        }
    }

    function showCropper() {
        var width_Image = $('#width_Image').val();
        var height_Image = $('#height_Image').val();
        var testres = imgWidthHeight_Crop_val('#height_Image', height_Image);
        if (this.value == '') {

            $('.height_Imageerror').show();
        } else {
            $('.height_Imageerror').hide();

        }
        if (!testres) {
            $('.height_Imageerror').text("Digits Only");
            $('#hiddenval').val('mdj');
            $('.height_Imageerror').show();
            $('#poster_div').hide();
        } else {
            $('.height_Imageerror').hide();
            if ((width_Image != '') && (height_Image != '')) {

                $('#poster_div').show();
            } else {
                $('#poster_div').hide();
                // swal("Warning", "Both height and Width needed", "warning");
            }
        }
        var testres = imgWidthHeight_Crop_val('#width_Image', width_Image);
        if (this.value == '') {

            $('.width_Imageerror').show();
            $('#poster_div').hide();
        } else {
            $('.width_Imageerror').hide();
            if ((width_Image != '') && (height_Image != '')) {

                $('#poster_div').show();
            } else {
                $('#poster_div').hide();
                // swal("Warning", "Both height and Width needed", "warning");
            }

        }
        if (!testres) {
            $('.width_Imageerror').text("Digits Only");
            $('#hiddenval').val('mdj');
            $('.width_Imageerror').show();
            $('#poster_div').hide();
        } else {
            $('.width_Imageerror').hide();
            if ((width_Image != '') && (height_Image != '')) {

                $('#poster_div').show();
            } else {
                $('#poster_div').hide();
                // swal("Warning", "Both height and Width needed", "warning");
            }
        }


    }

</script>
@endsection
