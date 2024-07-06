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
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Logo Type</div>

                <div class="card-body">
                  @if(session('success'))
                      <div class="alert alert-success" role="alert">
                           {{ session('success') }}
                       </div>
                   @endif
                    
                   @if(isset($edit_f))
                    <form id="formiid" method="POST" action="{{ route('updatelogotype') }}" enctype="multipart/form-data">
                    @else
                    <form id="formiid" method="POST" action="{{ route('storelogotype') }}" enctype="multipart/form-data">
                    @endif
    
                    @csrf 
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                        <div class="row mb-3">
                            <label for="component" class="col-sm-2 col-form-label">Logotype Name <span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                            <input id="logotype" type="text" class="form-control @error('component') is-invalid @enderror" name="logotype" value="{{ $keydata->name ?? old('name')}}" required autocomplete="logotype" placeholder="Enter logotype here" autofocus>
                            <span class="ErrP alert-danger titleerr redalert" style="display: none;">Please Check the Logotype Entered</span>
                            <span class="redalert">@error('logotype'){{$message}} @enderror</span>
                            </div>
                        </div>
                        
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
                <div class="card-header text-white card-header-main">{{ __('List of Logotype') }}</div>
                 
                <div class="card-body">
                    <table id="datatable_view" class="table table-striped">
                    <thead>    
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th width="280px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $result)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $result->name }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('editlogotype',\Crypt::encryptString($result->id)) }}">Edit</a>
                            <a class="btn btn-danger btn-sm" href="{{ route('deletelogotype',\Crypt::encryptString($result->id)) }}">Delete</a>
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