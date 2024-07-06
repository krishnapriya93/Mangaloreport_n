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
            @if(Session::get('success')!='')
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong>   {{Session::get('success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif
                @if(session('delete'))
                    <div class="alert alert-warning" role="alert">
                       {{ session('delete') }}
                       <strong>Success!</strong>   {{Session::get('success')}}
                           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            <div class="card">
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Component</div>

                <div class="card-body">

                   @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {!! implode(' ', $errors->all('<span class="text-danger">:message</span>')) !!}
                        </div> <!-- ./alert -->
                    @endif
                    
                   @if(isset($edit_f))
                    <form id="formiid" method="POST" action="{{ route('updatecomponent') }}" enctype="multipart/form-data">
                    @else
                    <form id="formiid" method="POST" action="{{ route('storecomponent') }}" enctype="multipart/form-data">
                    @endif
    
                    @csrf 
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                        <div class="row mb-3">
                            <label for="component" class="col-sm-2 col-form-label">Component Name <span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                            <input id="component" type="text" class="form-control @error('component') is-invalid @enderror" name="component" value="{{ $keydata->name ?? old('name')}}" required autocomplete="component" placeholder="Enter component here" autofocus>
                            <span class="ErrP titleerr redalert" style="display: none;">Please Check the component Entered</span>
                            <span class="redalert">@error('component'){{$message}} @enderror</span>
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
                <div class="card-header text-white card-header-main">{{ __('List of Component') }}</div>
                 
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
                        <td>{{ $result->name }}</td>
                        <td>
                            @if(($result->status_id)==1)
                            <a class="main-btn info-btn rounded-full btn-hover btn-sm-default" href="{{ route('statuscomponent',\Crypt::encryptString($result->id)) }}">Active</a>
                            @else
                            <a class="main-btn deactive-btn rounded-full btn-hover btn-sm-default" href="{{ route('statuscomponent',\Crypt::encryptString($result->id)) }}">Deactive</a>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('editcomponent',\Crypt::encryptString($result->id)) }}">Edit</a>
                            <a class="btn btn-danger btn-sm" href="{{ route('deletecomponent',\Crypt::encryptString($result->id)) }}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
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
@section('mainscript')
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

//common alert display time set

    $(".alert").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert").slideUp(500);
    });
   
    $('.alert').alert();
  });    
</script>
@endsection
