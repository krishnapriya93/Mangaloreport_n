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
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Component permissions</div>

                <div class="card-body">
                   @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {!! implode(' ', $errors->all('<span class="text-danger">:message</span>')) !!}
                        </div> <!-- ./alert -->
                    @endif


                   @if(isset($edit_f))
                    <form id="formiid" method="POST" action="{{ route('updatecomponentperm') }}" enctype="multipart/form-data">
                    @else
                    <form id="formiid" method="POST" action="{{ route('storecomponentpermi') }}" enctype="multipart/form-data">
                    @endif

                    @csrf
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                        <div class="alerts-wrapper">
                            <div class="card-style mb-30">
                                <span class="redalert"> * This module used to allow module permission to user.</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="component" class="col-sm-2 col-form-label">Component Type<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                             <select class="form-control select2 formselect" name="component" id="component" required>
                                <option value="">Select</option>
                            @foreach($component as $components)
                                <option value="{{$components->id}}" @if(isset($edit_f))  {{($components->id == $keydata->component->id) ? 'selected' : ''}} @endif>{{$components->name}}</option>
                            @endforeach
                            </select>
                            <span class="ErrP alert-danger titleerr redalert" style="display: none;">Please Check the Component Entered</span>
                            <span class="redalert">@error('usertype'){{$message}} @enderror</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="usertype" class="col-sm-2 col-form-label">User Type<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                             <select class="form-control select2" name="usertype" id="usertype" required>
                                 <option value="">Select</option>
                            @foreach($usertype as $usertypes)
                                <option value="{{$usertypes->id}}" @if(isset($edit_f))  {{($usertypes->id == $keydata->usertype->id) ? 'selected' : ''}} @endif>{{$usertypes->usertype}}</option>
                            @endforeach
                            </select>
                            <span class="ErrP alert-danger titleerr redalert" style="display: none;">Please Check the usertype Entered</span>
                            <span class="redalert">@error('usertype'){{$message}} @enderror</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="path" class="col-sm-2 col-form-label">Path<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                            <input id="path" type="text" class="form-control @error('path') is-invalid @enderror" name="path" value="{{ $keydata->url ?? old('path')}}" required autocomplete="path" placeholder="Eg:/example" autofocus>
                            <span class="ErrP alert-danger patherr redalert" style="display: none;">Please Check the URL Entered</span>
                            <span class="redalert">@error('path'){{$message}} @enderror</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-10 offset-sm-2">
                               @if($edit_f ?? '')
                                <button type="submit" class="btn btn-warning">Update</button>
                               @else
                               <button type="submit" class="btn btn-primary">Add </button>
                               @endif
                               <a type="submit" class="btn btn-success" href="{{route('componentpermi')}}">Refresh</a>
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
                        <th>Component</th>
                        <th>User type</th>
                        <th>URL</th>
                        <th>Status</th>
                        <th width="280px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $result)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$result->component->name ?? ''}}</td>
                        <td>{{$result->usertype->usertype ?? ''}}</td>
                        <td>{{ $result->url }}</td>
                        <td>
                            @if(($result->status_id)==1)
                            <a class="main-btn info-btn rounded-full btn-hover btn-sm-default" href="{{ route('statuscomperm',\Crypt::encryptString($result->id)) }}">Active</a>
                            @else
                            <a class="main-btn deactive-btn rounded-full btn-hover btn-sm-default" href="{{ route('statuscomperm',\Crypt::encryptString($result->id)) }}">Deactive</a>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('editcomponentper',\Crypt::encryptString($result->id)) }}">Edit</a>
                            <a class="btn btn-danger btn-sm" href="{{ route('deletecomponentper',\Crypt::encryptString($result->id)) }}"  onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
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

 //PATH

        $('.formselect').on('keyup',function(e){
        var testres=pathcheck('#path',this.value);
        if(!testres){
            $('.patherr').text('Allowed only Alphabets and /');
            $('.patherr').show();
        }else{
            $('.patherr').hide();
        }
    });

});
</script>
@endsection
