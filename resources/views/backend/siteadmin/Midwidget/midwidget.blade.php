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
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Mid widget</div>

                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger" role="alert">

                        {!! implode(' ', $errors->all('<li><span class="text-danger">:message</span></li>')) !!}
                    </div> <!-- ./alert -->
                    @endif
                    @if(isset($edit_f))
                    <form id="formiid" method="POST" action="{{ route('siteadmin.updatemidwidget') }}" enctype="multipart/form-data">
                        @else
                        <form id="formiid" method="POST" action="{{ route('siteadmin.storemidwidget') }}" enctype="multipart/form-data">
                            @endif

                            @csrf
                            <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                            <input type="hidden" name="edit_id" value="{{$edit_f ?? ''}}">
                            <div class="row mb-1">
                                @php
                                $i=0;
                                @endphp
                                <!-- EDiting Start -->
                                @if(isset($edit_f))

                                @if(isset($keydata->id)) @foreach(($keydata->tender_type_sub) as $tender_type_sub)

                                <input type="hidden" value="{{$tender_type_sub->languageid ?? ''}}" id="sel_lang{{$tender_type_sub->languageid}}" name="sel_lang[]">

                                <div class="col-sm-6 mb-btm" id="div{{$tender_type_sub->id}}">
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Tender type in {{$tender_type_sub->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$tender_type_sub->id}}" type="text" class="form-control title_validation @error('title') is-invalid @enderror" name="title[]" value="{{ $tender_type_sub->title ?? old('title.'.$i)}}" rel="{{$tender_type_sub->id}}" required autocomplete="title" placeholder="Enter {{$tender_type_sub->name}} here" autofocus>
                                    <span class="ErrP redalert titleerr1" style="display: none;">Please Check the {{$tender_type_sub->title}} title Entered</span>
                                    <span class="ErrP redalert titleerr2" style="display: none;">Please Check the {{$tender_type_sub->title}} title Entered</span>
                                </div>
                                @endforeach @endif

                                <!-- EDiting End -->
                                @else
                                @foreach($language as $langs)

                                <input type="hidden" value="{{$langs->id ?? ''}}" id="sel_lang{{$langs->id}}" name="sel_lang[]">

                                <div class="col-sm-6 mb-btm" id="div{{$langs->id}}">
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Tender type in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$langs->id}}" type="text" class="form-control title_validation @error('title') is-invalid @enderror" name="title[]" value="{{ $keydata->title ?? old('title.'.$i)}}" rel="{{$langs->id}}" required autocomplete="title" placeholder="Enter {{$langs->name}} here" autofocus>
                                    <span class="ErrP redalert titleerr1" style="display: none;">Please Check the {{$langs->title}} title Entered</span>
                                    <span class="ErrP redalert titleerr2" style="display: none;">Please Check the {{$langs->title}} title Entered</span>
                                </div>
                                @php
                                $i++;
                                @endphp
                                @endforeach
                                @endif
                            </div><br>

                            <div class="row mb-1">
                            
                                <div class="col-sm-6 mb-btm" id="div">
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Value <span class="redalert"> *</span></label>
                                    <input id="value" type="text" class="form-control title_validation @error('valuedata') is-invalid @enderror" name="valuedata" value="{{ $keydata->value ?? old('valuedata')}}"  required autocomplete="title" placeholder="Enter value here" autofocus>
                                    <span class="ErrP redalert titleerr1" style="display: none;">Please Check Entered</span>
                                    <span class="ErrP redalert titleerr2" style="display: none;">Please Check the Entered</span>
                                </div>
                      
                            </div><br>

                            <div class="row">
                                <div class="col-sm-10 offset-sm-2">
                                    @if($edit_f ?? '')
                                    <button type="submit" class="btn btn-warning">Update</button>
                                    @else
                                    <button type="submit" class="btn btn-primary">Add </button>
                                    @endif
                                </div>
                            </div>
                        </form>


                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header text-white card-header-main">{{ __('List of Mid widget') }}</div>

                <div class="row">
                    <div class="col-sm-9"></div>
                    <div class="col-sm-3 mt-3"><a href="{{route('admin.createtendertype')}}" id="addlogobtn" class="btn btn-flat btn-point btn-sm btn-success"><i class="fas fa-plus"></i>&nbsp;Add New Record</a></div>
                </div>


                <div class="card-body">
                    <table id="datatable_view" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=0;
                            @endphp
                            @foreach ($datas as $key => $result)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$result->midwiget_sub[0]->title ?? ''}}</td>

                                <td>
                                    <a class="btn btn-primary btn-sm-default" href="{{ route('admin.edittendertype',\Crypt::encryptString($result->id)) }}">Edit</a>
                                    <!-- <a class="btn btn-danger btn-sm-default" href="{{ route('admin.deletetendertype',\Crypt::encryptString($result->id)) }}">Delete</a> -->
                                </td>
                            </tr>
                            <!-- $i++; -->
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div> <!--card2 -->

        </div>
    </div>
</div>
@endsection
@section('page_scripts')
<script>
    $(document).ready(function() {


        ///tittle validation
        $('.title_validation').on('keyup', function(e) {

            if ($(this).attr('rel') == 1) {
                var testres = engtitle('.title_validation', this.value);

                if (!testres) {
                    // alert($(this).parent().find( ".titleerr1" ).html());
                    $(this).find(".titleerr1").text("Not Allowed / only english ");
                    // $('.titleerr1').text("Not Allowed1 ");
                    //  $('.titleerr2').hide();
                    $(this).parent().find(".titleerr1").show();
                    $('.submitBtn').prop('disabled', true);
                    // $('.titleerr1').sh
                } else {
                    $('.titleerr1').hide();
                    $('.titleerr2').hide();
                    $('.submitBtn').prop('disabled', false);
                }


            } else if ($(this).attr('rel') == 2) {
                var testres = maltitle('.title', this.value);

                if (!testres) {

                    $(this).find(".titleerr2").text("Not Allowed/ only malayalam ");
                    //    $('.titleerr1').hide();
                    $('.submitBtn').prop('disabled', true);
                } else {

                    $('.titleerr2').hide();
                    $('.titleerr1').hide();
                    $('.submitBtn').prop('disabled', false);
                }

            }

        });


    });
</script>
@endsection