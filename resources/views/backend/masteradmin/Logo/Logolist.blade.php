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
                <div class="card-header text-white card-header-main">{{ __('List of Logo') }}</div>
       
                <div class="row"><div class="col-sm-9"></div><div class="col-sm-3 mt-3"><a href="{{route('createlogo')}}" id="addlogobtn" class="btn btn-flat btn-point btn-sm btn-success"><i class="fas fa-plus"></i>&nbsp;Add New Record</a></div> </div>
                <div class="card-body">
                    <table id="datatable_view" class="table table-striped">
                    <thead>    
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Alternate text</th>
                        <!-- <th>Logotype</th> -->
                        <th width="280px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php 
                    $i=0;
                    @endphp 
                    @foreach ($data as $key => $result)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$result->logo_sub[0]->title ?? ''}}</td>
                        <td>{{$result->logo_sub[0]->alternatetext ?? ''}}</td>
                        <!-- <td>{{$result->logo_type[0]->name ?? ''}}</td> -->
                        <td>
                            <a class="btn btn-primary btn-sm-default" href="{{ route('editsocialmedia',\Crypt::encryptString($result->id)) }}">Edit</a>
                            <a class="btn btn-danger btn-sm-default" href="{{ route('deletesocialmedia',\Crypt::encryptString($result->id)) }}">Delete</a>
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
@include('layouts.commonscript')
<script>  
 $( document ).ready(function() {


});
</script>
