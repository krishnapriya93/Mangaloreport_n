@extends('template.master')
@section('title','Student list')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Students list</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Students list</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @if(session('hh'))
      <div class="alert alert-success mr-3 ml-3" role="alert">
        {{session('hh')}}
      </div>
    @endif
    @if(session('msg'))
    <div class="alert alert-success mr-3 ml-3" role="alert">
      {{session('msg')}}
    </div>
  @endif
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-3">
      <div class="col-md-12">
        <div class="col-md-6  mt-3">
          <a href="{{route('student.addnew')}}" class="btn btn-primary">Add new</a>
        </div>
        <div class="col-md-6  mt-3">
          <button class="btn btn-info" id="ajaxcall" action="{{ route('getstudent')}}">Ajax</button>
        </div>
      </div>
      </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><h3>{{__('auth.studentname')}}</h3>
              </div>
              <form action="{{ route('student.list')}}" method="GET">
                @csrf
              <div class="row mt-3 ">
                <div class="col-md-6 px-3">
                  <div class="input-group mb-3 text-right">
                    <div class="input-group-prepend">
                      <button  type="submit" class="input-group-text" id="inputGroup-sizing-default">Search</button>
                    </div>
                    <input type="text" class="form-control" aria-label="Default" name="serach" aria-describedby="inputGroup-sizing-default">
                  </div>
                </div>

                <div class="col-md-6 px-3">
                  <div class="input-group mb-3 text-right">
                  <select class="form-control" name="statuscheck">
                    <option selected>Select</option>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                  </select>
                  </div>
                </div>

              </div>
              </form>

              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Parent name</th>
                      <th>District</th>
                      <th>Mobile Number</th>
                      <th>DOB</th>
                      <th>Approved by</th>
                      <th>Status</th>
                      <th>Action</th>
                      <th>Download</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($students as  $student)
                                  <tr>
                                    {{-- <td>{{$loop->iteration}}</td>
                                     --}}
                                     <td>{{($loop->iteration + $students->firstItem() - 1)}}</td>
                                    <td>{{ $student->fullname }}</td>
                                    <td>{{$student->parentrelation->username ?? ''}}</td>
                                    <td>{{$student->district}}</td>
                                    <td>{{$student->mobile_no}}</td>
                                    <td>{{date('d-m-Y',strtotime($student->dob))}}</td>
                                    <td>{{ $student[0]->post->aprovedbyrelation->name ?? ''}}</td>
                                    {{-- <td> @foreach ( $student->posts as $post)
                                      {{$post->aprovedbyrelation->name ?? ''}}
                                    @endforeach</td> --}}
                                    <td> {{$student->status_text}}</td>
                                    <td><a href="{{ route('student.edit',['id'=>encrypt($student->id) ]) }}"><span class="btn btn-warning btn-sm">Edit </span></a>
                                      <a href="{{ route('student.delete',['id'=>encrypt($student->id)]) }}"><span class="btn btn-danger btn-sm">Delete</span></a>
                                      <button class="btn btn-info btn-sm ajaxcall" id="{{$student->id}}" action="{{ route('studentsorted')}}">Ajax</button>
                                    </td>
                                    <td>
                                      <a href="{{ route('student.generatepdf',['id'=>encrypt($student->id)]) }}"><span class="btn btn-info btn-sm">Generate pdf</span></a>
                                      <a href="{{ route('student.generateexcel',['id'=>encrypt($student->id)]) }}"><span class="btn btn-primary btn-sm">Generate excel</span></a>
                                    </td>
                                  </tr>
                    @endforeach



                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                {{$students->links('pagination::bootstrap-5')}}
                {{-- <ul class="pagination pagination-sm m-0 float-right"> --}}

                  {{-- <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li> --}}
                {{-- </ul> --}}
              </div>
            </div>
            <!-- /.card -->


            <!-- /.card -->
          </div>
          <!-- /.col -->

          <!-- /.col -->
        </div>
        <!-- /.row -->







      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@push('js')
<script src="{{ asset('js/custome.js') }}"></script>
@endpush
