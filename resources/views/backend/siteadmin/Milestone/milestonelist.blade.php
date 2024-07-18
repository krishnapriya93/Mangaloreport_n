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
                <div class="card-header text-white card-header-main">{{ __('List of Milestone') }}</div>

                @if(Auth::user()->role_id==3)
                <div class="row"><div class="col-sm-9"></div><div class="col-sm-3 mt-3"><a href="{{route('planning.createmilestone')}}" id="addlogobtn" class="btn btn-flat btn-point btn-sm btn-success"><i class="fas fa-plus"></i>&nbsp;Add New Record</a></div> </div>
                @elseif(Auth::user()->role_id==5)
                <div class="row"><div class="col-sm-9"></div><div class="col-sm-3 mt-3"><a href="{{route('sbu.createmilestone')}}" id="addlogobtn" class="btn btn-flat btn-point btn-sm btn-success"><i class="fas fa-plus"></i>&nbsp;Add New Record</a></div> </div>
                @endif

                <div class="card-body">
                    <table id="datatable_view" class="table table-striped">
                    <thead>    
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Status</th>
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
                        <td>{{$result->date ?? ''}}</td>
                        <td>{{$result->milestonesub[0]->title ?? ''}}</td>
                        <td>
                        @if(Auth::user()->role_id==3)
                          @if(($result->status_id)==1)
                            <a class="main-btn info-btn rounded-full btn-hover btn-sm-default" href="{{ route('planning.statusmilestone',\Crypt::encryptString($result->id)) }}">Active</a>
                            @else
                            <a class="main-btn deactive-btn rounded-full btn-hover btn-sm-default" href="{{ route('planning.statusmilestone',\Crypt::encryptString($result->id)) }}">Deactive</a>
                            @endif
                        @elseif(Auth::user()->role_id==5)
                           @if(($result->status_id)==1)
                            <a class="main-btn info-btn rounded-full btn-hover btn-sm-default" href="{{ route('sbu.statusmilestone',\Crypt::encryptString($result->id)) }}">Active</a>
                            @else
                            <a class="main-btn deactive-btn rounded-full btn-hover btn-sm-default" href="{{ route('sbu.statusmilestone',\Crypt::encryptString($result->id)) }}">Deactive</a>
                            @endif
                        @endif
                            
                        </td>
                        <td>
                        @if(Auth::user()->role_id==3)
                            <a class="btn btn-primary btn-sm-default" href="{{ route('planning.editmilestone',\Crypt::encryptString($result->id)) }}">Edit</a>
                            <a class="btn btn-danger btn-sm-default" href="{{ route('planning.deletemilestone',\Crypt::encryptString($result->id)) }}">Delete</a>
                        @elseif(Auth::user()->role_id==5)
                            <a class="btn btn-primary btn-sm-default" href="{{ route('sbu.editmilestone',\Crypt::encryptString($result->id)) }}">Edit</a>
                            <a class="btn btn-danger btn-sm-default" href="{{ route('sbu.deletemilestone',\Crypt::encryptString($result->id)) }}">Delete</a>
                        @endif
                           
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
 $( document ).ready(function() {

//common alert display time set

    $(".alert").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert").slideUp(500);
    });
   
    $('.alert').alert();
  });    
</script>
@endsection