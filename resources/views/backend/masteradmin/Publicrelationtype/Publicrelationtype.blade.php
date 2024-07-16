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
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Press relation</div>

                <div class="card-body">
                  @if(session('success'))
                      <div class="alert alert-success" role="alert">
                           {{ session('success') }}
                       </div>
                   @endif

                   @if(isset($edit_f))
                    <form id="formiid" method="POST" action="{{ route('updatepublicrelationtype') }}" enctype="multipart/form-data">
                    @else
                    <form id="formiid" method="POST" action="{{ route('storepublicrelationtype') }}" enctype="multipart/form-data">
                    @endif

                    @csrf
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                        <div class="row mb-3">
                            @if(isset($edit_f))

                                @if(isset($keydata->id)) @foreach(($keydata->article_sub) as $article_sub)

                                <input type="hidden"  value="{{$article_sub->languageid ?? ''}}" id="sel_lang{{$article_sub->languageid}}" name="sel_lang[]">

                                <div class="col-sm-6 mb-btm" id="div{{$article_sub->id}}">
                                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Public relation type in {{$article_sub->name}} <span class="redalert"> *</span></label>
                                <input id="title{{$article_sub->id}}" type="text" class="form-control title_validation @error('title') is-invalid @enderror" name="title[]" value="{{ $article_sub->title ?? old('title.'.$i)}}" rel="{{$article_sub->id}}" required autocomplete="title" placeholder="Enter {{$article_sub->name}} here" autofocus  >
                                <span class="ErrP redalert titleerr1" style="display: none;">Please Check the {{$article_sub->title}} title Entered</span>
                                <span class="ErrP redalert titleerr2" style="display: none;">Please Check the {{$article_sub->title}} title Entered</span>
                                </div>
                                @endforeach @endif

                                <!-- EDiting End -->
                                @else
                                @foreach($language as $langs)

                                <input type="hidden"  value="{{$langs->id ?? ''}}" id="sel_lang{{$langs->id}}" name="sel_lang[]">

                                    <div class="col-sm-6 mb-btm" id="div{{$langs->id}}">
                                         <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Public relation type in {{$langs->name}} <span class="redalert"> *</span></label>
                                        <input id="title{{$langs->id}}" type="text" class="form-control title_validation @error('title') is-invalid @enderror" rel="{{$langs->id}}" name="title[]" value="" required autocomplete="title" placeholder="Enter {{$langs->name}} here" autofocus  >
                                        <span class="ErrP redalert titleerr1" style="display: none;">Please Check the {{$langs->title}} title Entered</span>
                                        <span class="ErrP redalert titleerr2" style="display: none;">Please Check the {{$langs->title}} title Entered</span>
                                    </div>

                                @endforeach @endif

                            </div><br>

                        <div class="row">
                            <div class="col-sm-10 offset-sm-2">
                               @if($edit_f ?? '')
                                <button type="submit" class="btn btn-warning">Update</button>
                               @else
                               <button type="submit" class="btn btn-primary">Add </button>
                               @endif
                               <a type="submit" class="btn btn-success" href="{{route('component')}}">Refresh</a>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
       <br>
            <div class="card">
                <div class="card-header text-white card-header-main">{{ __('List of Press relation type') }}</div>

                <div class="card-body">
                    <table id="datatable_view" class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th width="280px">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($data as $key => $result)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $result->ptypesub[0]->title}}</td>
                        <td>
                            @if(($result->status_id)==1)
                            <a class="main-btn info-btn rounded-full btn-hover btn-sm-default" href="{{ route('statuswidgetpost',\Crypt::encryptString($result->id)) }}">Active</a>
                            @else
                            <a class="main-btn deactive-btn rounded-full btn-hover btn-sm-default" href="{{ route('statuswidgetpost',\Crypt::encryptString($result->id)) }}">Deactive</a>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('editwidget',\Crypt::encryptString($result->id)) }}">Edit</a>
                            <a class="btn btn-danger btn-sm" href="{{ route('deletewidget',\Crypt::encryptString($result->id)) }}">Delete</a>
                        </td>
                    </tr>
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
 $( document ).ready(function() {
    $('#component').on('keyup', function(e) {
        var testres = engtitle('#component', this.value);
        if (!testres) {
            $('.titleerr').text("Not Allowed ");

            $('.titleerr').show();

        } else {
            $('.titleerr').hide();
        }
    });
  });
</script>
@endsection
