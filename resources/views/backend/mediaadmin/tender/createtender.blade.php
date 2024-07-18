@extends('backend.layouts.htmlheader')


@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center">
            {!! $breadcrumbarr !!}
        </ol>
    </nav>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-white card-header-main">{{ isset($edit_f) ? 'Update' : 'Add' }} Tender
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">

                                {!! implode(' ', $errors->all('<li><span class="text-danger">:message</span></li>')) !!}
                            </div> <!-- ./alert -->
                        @endif
                        @if (isset($edit_f))
                            <form id="formiid" method="POST" action="{{ route('mediaadmin.updatetender') }}"
                                enctype="multipart/form-data">
                            @else
                                <form id="formiid" method="POST" action="{{ route('mediaadmin.storetender') }}"
                                    enctype="multipart/form-data">
                        @endif

                        @csrf
                        <input type="hidden" name="hidden_id" value="{{ $keydata->id ?? '' }}">
                        <input type="hidden" name="edit_id" value="{{ $edit_f ?? '' }}">

                        <div class="row mt-2">
                            <div class="col-sm-6 mb-btm" id="">
                                <label class="my-1 mr-2" for="tentype">Tender type<span class="redalert"> *</span></label>
                                <select class="form-control formselect" name="tentype" id="tentype" required>
                                    <option value="">Select</option>
                                    @foreach ($TenderType as $TenderTypes)
                                        <option value="{{ $TenderTypes->id }}"
                                            @if (isset($edit_f)) {{ $TenderTypes->id == $keydata->tendertype ? 'selected' : '' }} @endif>
                                            {{ $TenderTypes->tender_type_sub[0]->title }}</option>
                                    @endforeach
                                </select>
                                <span class="ErrP alert-danger menuerr redalert" style="display: none;">Please Check the
                                    downloadtype Entered</span>
                                <span class="redalert">
                                    @error('tentype')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-sm-6 mb-btm" id="">
                                <label class="my-1 mr-2" for="department">Department<span class="redalert"> *</span></label>
                                <select class="form-control formselect" name="department" id="department" required>
                                    <option value="">Select</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->tid }}"
                                            @if (isset($edit_f)) {{ $department->tid == $keydata->department ? 'selected' : '' }} @endif>
                                            {{ $department->name }}</option>
                                    @endforeach
                                </select>
                                <span class="ErrP alert-danger menuerr redalert" style="display: none;">Please Check the
                                    downloadtype Entered</span>
                                <span class="redalert">
                                    @error('tentype')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        @if (isset($edit_f))
                            @php
                                $carbonDate = \Carbon\Carbon::parse($keydata->tenderdate);
                                $formattedDate = $carbonDate->format('d/m/Y');
                            @endphp
                        @endif
                        <div class="row mt-2">
                            <div class="col-sm-6 mb-btm" id="">
                                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Tender start date<span
                                        class="redalert"> *</span></label>
                                <input id="s_date" type="datetime-local"
                                    class="form-control @error('s_date') is-invalid @enderror" name="s_date"
                                    value="{{ $keydata->tenderstartdate ?? old('date') }}" required autocomplete="s_date"
                                    placeholder="date  here" autofocus>
                            </div><br />
                            <div class="col-sm-6 mb-btm" id="">
                                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Tender end date<span
                                        class="redalert"> *</span></label>
                                <input id="e_date" type="datetime-local"
                                    class="form-control @error('e_date') is-invalid @enderror" name="e_date"
                                    value="{{ $keydata->tenderenddate ?? old('e_date') }}" required autocomplete="e_date"
                                    placeholder="date  here" autofocus>
                            </div><br />
                        </div>

                        <div class="row mt-4">
                            <div class="col-sm-12 mb-btm" id="">
                                <label class="my-1 mr-2" for="documentno">Tender No<span class="redalert"> *</span></label>
                                <input id="documentno" type="text"
                                    class="form-control @error('documentno') is-invalid @enderror" name="documentno"
                                    value="{{ $keydata->tenderno ?? old('documentno') }}" required
                                    autocomplete="documentno" placeholder="Enter Document/ Order number here" autofocus>
                                <span class="ErrP alert-danger documentnoerr redalert" style="display: none;">Please Check
                                    the documentno Entered</span>
                                <span class="redalert">
                                    @error('documentno')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="row mt-2 mb-3">
                            <div class="col-sm-6 mb-btm" id="">
                                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">EMD</label>
                                <input id="emd" type="text" class="form-control @error('emd') is-invalid @enderror"
                                    name="emd" value="{{ $keydata->emd ?? old('emd') }}" autocomplete="emd"
                                    placeholder="Enter EMD  here" autofocus>
                            </div><br />
                            <div class="col-sm-6 mb-btm" id="">
                                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Corrigendum</label>
                                <input id="corrigendum" type="text"
                                    class="form-control @error('corrigendum') is-invalid @enderror" name="corrigendum"
                                    value="{{ $keydata->corrigendum ?? old('corrigendum') }}" autocomplete="corrigendum"
                                    placeholder="Enter corrigendum here" autofocus>
                            </div><br />
                        </div>
                        <div class="row mb-3 mt-2">
                            @php
                                $i = 0;
                            @endphp
                            <!-- EDiting Start -->
                            @if (isset($edit_f))

                                @if (isset($keydata->id))
                                    @foreach ($keydata->tender_sub as $tender_sub)
                                        <input type="hidden" value="{{ $tender_sub->languageid ?? '' }}"
                                            id="sel_lang{{ $tender_sub->languageid }}" name="sel_lang[]">
                                        <div class="three">
                                            <h1>{{ $tender_sub->lang->name }}</h1>
                                        </div>
                                        <div class="col-sm-12 mb-btm mt-3" id="div{{ $tender_sub->id }}">
                                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Tender category in
                                                {{ $tender_sub->lang->name }} <span class="redalert"> *</span></label>
                                            <input id="title{{ $tender_sub->id }}" type="text"
                                                class="form-control title_validation @error('title') is-invalid @enderror"
                                                name="title[]" value="{{ $tender_sub->title ?? old('title.' . $i) }}"
                                                rel="{{ $tender_sub->id }}" required autocomplete="title"
                                                placeholder="Enter {{ $tender_sub->name }} here" autofocus>
                                            <span class="ErrP redalert titleerr1" style="display: none;">Please Check the
                                                {{ $tender_sub->title }} title Entered</span>
                                            <span class="ErrP redalert titleerr2" style="display: none;">Please Check the
                                                {{ $tender_sub->title }} title Entered</span>
                                        </div>

                                        <div class="col-sm-12 mb-btm mt-3" id="div_sub{{ $tender_sub->id }}">
                                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Description in
                                                {{ $tender_sub->lang->name }}</label>
                                            <textarea id="descrptn{{ $tender_sub->id }}" class="form-control ckeditor @error('descrptn') is-invalid @enderror"
                                                name="descrptn[]" value="" autocomplete="language"
                                                placeholder="Enter Content in {{ $tender_sub->name }} here" autofocus>{{ $tender_sub->description ?? old('description.' . $i) }}</textarea>
                                        </div><br />
                                    @endforeach
                                @endif

                                <!-- EDiting End -->
                            @else
                                @foreach ($language as $langs)
                                    <input type="hidden" value="{{ $langs->id ?? '' }}"
                                        id="sel_lang{{ $langs->id }}" name="sel_lang[]">
                                    <div class="three mt-3">
                                        <h1>{{ $langs->name }}</h1>
                                    </div>
                                    <div class="col-sm-12 mb-btm mt-3" id="div{{ $langs->id }}">
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Tender title in
                                            {{ $langs->name }} <span class="redalert"> *</span></label>
                                        <input id="title{{ $langs->id }}" type="text"
                                            class="form-control title_validation @error('title') is-invalid @enderror"
                                            name="title[]" value="{{ $keydata->title ?? old('title.' . $i) }}"
                                            rel="{{ $langs->id }}" required autocomplete="title"
                                            placeholder="Enter {{ $langs->name }} here" autofocus>
                                        <span class="ErrP redalert titleerr1" style="display: none;">Please Check the
                                            {{ $langs->title }} title Entered</span>
                                        <span class="ErrP redalert titleerr2" style="display: none;">Please Check the
                                            {{ $langs->title }} title Entered</span>
                                    </div>


                                    <div class="col-sm-12 mb-btm mt-3" id="div_sub{{ $langs->id }}">
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Description in
                                            {{ $langs->name }}</label>
                                        <textarea id="descrptn{{ $langs->id }}" class="form-control ckeditor @error('descrptn') is-invalid @enderror"
                                            name="descrptn[]" value="" autocomplete="language"
                                            placeholder="Enter Content in {{ $langs->name }} here" autofocus></textarea>
                                    </div><br />
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            @endif
                        </div><br>



                        <div class="row">
                            <div class="col-sm-10 offset-sm-2">
                                @if ($edit_f ?? '')
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
            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });

            $('.alert').alert();

            flatpickr("#s_date", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });


            flatpickr("#e_date", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });
        });
    </script>
@endsection
