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
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} What we do </div>

                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger" role="alert">

                        {!! implode(' ', $errors->all('<li><span class="text-danger">:message</span></li>')) !!}
                    </div> <!-- ./alert -->
                    @endif
                    @if(isset($edit_f))
                    <form id="formiid" method="POST" action="{{ route('mediaadmin.updatewhatwedo') }}" enctype="multipart/form-data">
                        @else
                        <form id="formiid" method="POST" action="{{ route('mediaadmin.storewhatwedo') }}" enctype="multipart/form-data">
                            @endif

                            @csrf
                            <input type="hidden" name="iconimage" id="iconimage" value="{{$keydata->iconupload ?? ''}}">
                            <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                            <input type="hidden" name="edit_id" id="edit_f" value="{{$edit_f ?? ''}}">
                            <div class="row mt-2">

                                <div class="col-sm-6 mb-btm" id="div_linktype">
                                    <label class="my-1 mr-2" for="linktype">Link Type<span class="redalert"> *</span></label>
                                    <select class="form-control formselect" name="linktype" id="linktype" required>
                                        <option value="">Select</option>
                                        @foreach($linktypes as $linktype)
                                        <option value="{{$linktype->id}}" @if(isset($edit_f)) {{($linktype->id == $keydata->linktype) ? 'selected' : ''}} @endif>{{$linktype->linktype_sub[0]->title}}</option>
                                        @endforeach
                                    </select>
                                    <span class="ErrP alert-danger menuerr redalert" style="display: none;">Please Check the downloadtype Entered</span>
                                    <span class="redalert">@error('tentype'){{$message}} @enderror</span>
                                </div>
                
                                <div class="col-sm-6 mb-btm div_whatwedo" id="div_whatwedo">
                                    <label class="my-1 mr-2" for="whatwedotype">What we do type<span class="redalert"> *</span></label>
                                    <select class="form-control formselect" name="whatwedotype" id="whatwedotype" required>
                                        <option value="">Select</option>
                                        @foreach($Whatwedotypes as $Whatwedotype)
                                        <option value="{{$Whatwedotype->id}}" @if(isset($edit_f)) {{($Whatwedotype->id == $keydata->whatwedotypeid) ? 'selected' : ''}} @endif>{{$Whatwedotype->whatwedotype_sub[0]->title}}</option>
                                        @endforeach
                                    </select>
                                    <span class="ErrP alert-danger menuerr redalert" style="display: none;">Please Check the downloadtype Entered</span>
                                    <span class="redalert">@error('tentype'){{$message}} @enderror</span>
                                </div>

                            </div>


                            <div class="row mb-3 mt-2">
                                @php
                                $i=0;
                                @endphp
                                <!-- EDiting Start -->
                                @if(isset($edit_f))

                                @if(isset($keydata->id)) @foreach(($keydata->whatwedo_sub) as $whatwedo_sub)

                                <input type="hidden" value="{{$whatwedo_sub->languageid ?? ''}}" id="sel_lang{{$whatwedo_sub->languageid}}" name="sel_lang[]">
                                <div class="three">
                                    <h1>{{$whatwedo_sub->lang->name}}</h1>
                                </div>
                                <div class="col-sm-12 mb-btm mt-3" id="div{{$whatwedo_sub->id}}">
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Tender category in {{$whatwedo_sub->lang->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$whatwedo_sub->id}}" type="text" class="form-control title_validation @error('title') is-invalid @enderror" name="title[]" value="{{ $whatwedo_sub->title ?? old('title.'.$i)}}" rel="{{$whatwedo_sub->id}}" required autocomplete="title" placeholder="Enter {{$whatwedo_sub->name}} here" autofocus>
                                    <span class="ErrP redalert titleerr1" style="display: none;">Please Check the {{$whatwedo_sub->title}} title Entered</span>
                                    <span class="ErrP redalert titleerr2" style="display: none;">Please Check the {{$whatwedo_sub->title}} title Entered</span>
                                </div>

                                <div class="col-sm-12 mb-btm mt-3" id="div_sub{{$whatwedo_sub->id}}">
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Description in {{$whatwedo_sub->lang->name}}</label>
                                    <textarea id="descrptn{{$whatwedo_sub->id}}" class="form-control ckeditor @error('descrptn') is-invalid @enderror" name="descrptn[]" value="" autocomplete="language" placeholder="Enter Content in {{$whatwedo_sub->name}} here" autofocus>{{ $whatwedo_sub->description ?? old('description.'.$i)}}</textarea>
                                </div><br />
                                @endforeach @endif

                                <!-- EDiting End -->
                                @else
                                @foreach($language as $langs)

                                <input type="hidden" value="{{$langs->id ?? ''}}" id="sel_lang{{$langs->id}}" name="sel_lang[]">
                                <div class="three mt-3">
                                    <h1>{{$langs->name}}</h1>
                                </div>
                                <div class="col-sm-12 mb-btm mt-3" id="div{{$langs->id}}">
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Tender title in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$langs->id}}" type="text" class="form-control title_validation @error('title') is-invalid @enderror" name="title[]" value="{{ $keydata->title ?? old('title.'.$i)}}" rel="{{$langs->id}}" required autocomplete="title" placeholder="Enter {{$langs->name}} here" autofocus>
                                    <span class="ErrP redalert titleerr1" style="display: none;">Please Check the {{$langs->title}} title Entered</span>
                                    <span class="ErrP redalert titleerr2" style="display: none;">Please Check the {{$langs->title}} title Entered</span>
                                </div>


                                <div class="col-sm-12 mb-btm mt-3" id="div_sub{{$langs->id}}">
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Description in {{$langs->name}}</label>
                                    <textarea id="descrptn{{$langs->id}}" class="form-control ckeditor @error('descrptn') is-invalid @enderror" name="descrptn[]" value="" autocomplete="language" placeholder="Enter Content in {{$langs->name}} here" autofocus></textarea>
                                </div><br />

                                <div class="mt-2 mb-3 display_status div_ease">
                                    <div class="row">
                                        <div class="col-sm-6" id="">
                                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">About EoDB</label>
                                            <input id="a_eobd{{$langs->id}}" type="text" class="form-control @error('a_eobd') is-invalid @enderror" name="a_eobd[]" value="{{$keydata->a_eobd ?? old('a_eobd')}}" autocomplete="a_eobd" placeholder="Enter a_eobd in {{$langs->name}}  here" autofocus>
                                        </div>
                                        <div class="col-sm-6" id="">
                                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Trading Across Borders</label>
                                            <input id="trade_border{{$langs->id}}" type="text" class="form-control @error('trade_border') is-invalid @enderror" name="trade_border[]" value="{{$keydata->trade_border ?? old('trade_border')}}" autocomplete="trade_border" placeholder="Enter Trading boarder in {{$langs->name}}here" autofocus>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6" id="">
                                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Digital initiatives</label>
                                            <input id="digi_initi{{$langs->id}}" type="text" class="form-control @error('digi_initi') is-invalid @enderror" name="digi_initi[]" value="{{$keydata->digi_initi ?? old('digi_initi')}}" autocomplete="digi_initi" placeholder="Enter digi initi in {{$langs->name}}  here" autofocus>
                                        </div>
                                        <div class="col-sm-6" id="">
                                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Media</label>
                                            <input id="media{{$langs->id}}" type="text" class="form-control @error('media') is-invalid @enderror" name="media[]" value="{{$keydata->media ?? old('media')}}" autocomplete="media" placeholder="Enter Media in {{$langs->name}}here" autofocus>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6" id="">
                                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">EoDB India</label>
                                            <input id="eodb_in{{$langs->id}}" type="text" class="form-control @error('eodb_in') is-invalid @enderror" name="eodb_in[]" value="{{$keydata->eodb_in ?? old('eodb_in')}}" autocomplete="eodb_in" placeholder="Enter eodb india in {{$langs->name}}  here" autofocus>
                                        </div>
                                        <div class="col-sm-6" id="">
                                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Contactus</label>
                                            <input id="contactus{{$langs->id}}" type="text" class="form-control @error('contactus') is-invalid @enderror" name="contactus[]" value="{{$keydata->contactus ?? old('contactus')}}" autocomplete="contactus" placeholder="Enter contactus in {{$langs->name}}here" autofocus>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 mb-3 display_status div_career">
                                    <div class="row">
                                        <div class="col-sm-6 mb-btm" id="">
                                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Last date<span class="redalert"> *</span></label>
                                            <input id="e_date" type="datetime-local" class="form-control @error('e_date') is-invalid @enderror" name="e_date" value="{{$keydata->tenderenddate ?? old('e_date')}}" autocomplete="e_date" placeholder="date  here" autofocus>
                                        </div><br />
                                    </div>
                                </div>
                                <div class="mt-2 mb-3 display_status div_env">
                                    <div class="row">
                                        <div class="col-sm-6 mb-btm" id="">
                                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Environment type<span class="redalert"> *</span></label>
                                            <input id="env_type" type="text" class="form-control @error('env_type') is-invalid @enderror" name="env_type" value="{{$keydata->tenderenddate ?? old('env_type')}}" autocomplete="env_type" placeholder="env type  here" autofocus>
                                        </div><br />
                                    </div>
                                </div>

                                @php
                                $i++;
                                @endphp
                                @endforeach
                                @endif
                            </div><br>

                            <div class="row mt-2">
                                <div class="col-sm-12 mb-btm" id="">
                                    <label class="my-1 mr-2" for="url">URL</label>
                                    <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ $keydata->url ?? old('url')}}" autocomplete="url" placeholder="Enter URL number here" autofocus>
                                    <span class="ErrP alert-danger documentnoerr redalert" style="display: none;">Please Check the url Entered</span>
                                    <span class="redalert">@error('documentno'){{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-12 mb-btm" id="">
                                    <label class="my-1 mr-2" for="iconupload">Icon Upload</label>
                                    <input id="iconupload" type="file" class="form-control @error('iconupload') is-invalid @enderror" name="iconupload" value="{{ $keydata->iconupload ?? old('iconupload')}}" autocomplete="iconupload" placeholder="Enter URL number here" autofocus>
                                    <span class="ErrP alert-danger documentnoerr redalert" style="display: none;">Please Check the iconupload Entered</span>
                                    <span class="redalert">@error('iconupload'){{$message}} @enderror</span>
                                    <div class="col-sm-3 mb-btm" id="div_poster">
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref"> <span class="redalert"> </span></label>
                                        <img id="preview_poster" rel="" class="preview_poster imgstamp" @if(isset($edit_f)) @if(isset($keydata->iconupload)) src="{{asset('/assets/backend/uploads/whatwedoicon/'.$keydata->iconupload)}}" @else src="" @endif @endif alt="preview image">
                                    </div><br />
                                </div><br />
                            </div>
                </div>



                <div class="row mb-4">
                    <div class="col-sm-10 offset-sm-2">
                        @if($edit_f ?? '')
                        <button type="submit" class="btn btn-warning">Update and Upload documents</button>
                        @else
                        <button type="submit" class="btn btn-primary">Save and Upload documents</button>
                        @endif
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
    $(document).ready(function() {
        // $('#preview_poster').hide();
        $(".alert").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert").slideUp(500);
        });

        $('.alert').alert();
        $('.div_whatwedo').hide();

    });
    var edit_f = $('#edit_f').val();
    var iconimage = $('#iconimage').val();
    if (edit_f == 'E') {
        $('#div_poster').show();
        if (iconimage = '') {
            $('#preview_poster').hide();
        } else {
            $('#preview_poster').show();
        }
        // alert(edit_f);

    }
    //on change what we do items

    $('#whatwedotype').on('change', function() {
        var whatwedotype = this.value;
        if (whatwedotype == 1) {
            $('.div_ease').show();
            $('.div_career').hide();
            $('.div_env').hide();
        } else if (whatwedotype == 6) {
            $('.div_career').show();
            $('.div_ease').hide();
            $('.div_env').hide();
        } else if (whatwedotype == 12) {
            $('.div_env').show();
            $('.div_ease').hide();
            $('.div_career').hide();
        } else {
            $('.div_env').hide();
            $('.div_ease').hide();
            $('.div_career').hide();
        }
    });
    $('#linktype').on('change', function() {
        var linktype = this.value;
 
        if (linktype == 1) {
            $('.div_whatwedo').show();
        }else{
            $('.div_whatwedo').hide();
        }
 
    });
    
    //icon preview 
    //poster view
    $('#iconupload').change(function() {
        $('#div_poster').show();
        $('#preview_poster').show();
        let reader = new FileReader();

        reader.onload = (e) => {

            $('#preview_poster').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);

    });
</script>
@endsection