@extends('backend.layouts.htmlheader')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb justify-content-center">
        <li class="breadcrumb-item"><a href="{{route('masteradminhome')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">User</li>
    </ol>
</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Usertype</div>

                <div class="card-body">
                  @if(session('success'))
                      <div class="alert alert-success" role="alert">
                           {{ session('success') }}
                       </div>
                   @endif

                  @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                       {{ session('error') }}
                    </div>
                 @endif

                   @if(isset($edit_f))
                    <form id="formiid" method="POST" action="{{ route('updateuser') }}" enctype="multipart/form-data">
                    @else
                    <form id="formiid" method="POST" action="{{ route('storeuser') }}" enctype="multipart/form-data">
                    @endif

                    @csrf
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                        <input type="hidden" id="role_id" name="role_id" value="{{$keydata->role_id ?? ''}}">
                        <input type="hidden" id="edit_id" name="edit_id" value="{{$edit_f ?? ''}}">
                        <div class="row mb-3">
                            <label for="username" class="col-sm-2 col-form-label">User Name <span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $keydata->name ?? old('username')}}" required autocomplete="username" placeholder="Enter username here">
                            <span class="ErrP usernameerr redalert" style="display: none;">Please Check the username Entered</span>
                            <span class="redalert">@error('name'){{$message}} @enderror</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fullname" class="col-sm-2 col-form-label">Full name <span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                            <input id="fullname" type="text" class="form-control @error('fullname') is-invalid @enderror" name="fullname" value="{{ $keydata->fullname ?? old('fullname')}}" required autocomplete="fullname" placeholder="Enter fullname here">
                            <span class="ErrP fullnameerr redalert" style="display: none;">Please Check the fullname Entered</span>
                            <span class="redalert">@error('fullname'){{$message}} @enderror</span>
                            </div>
                        </div>

                          <div class="row mb-3">
                            <label for="usertype" class="col-sm-2 col-form-label">User Type<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                             <select class="form-control select2" name="usertype" id="usertype">
                            @foreach($usertype as $usertypes)
                                <option @if(isset($edit_f))  {{($usertypes->id == $keydata->role_id) ? 'selected' : ''}} @endif   value="{{$usertypes->id}}">{{$usertypes->usertype}}</option>
                            @endforeach
                            </select>
                            <span class="ErrP alert-danger titleerr redalert" style="display: none;">Please Check the usertype Entered</span>
                            <span class="redalert">@error('usertype'){{$message}} @enderror</span>
                            </div>
                        </div>




                        <div class="row mb-3">
                            <label for="mobile" class="col-sm-2 col-form-label">Mobile number <span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                            <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ $keydata->mobile ?? old('mobile')}}" required autocomplete="mobile" placeholder="Enter mobile here">
                            <span class="ErrP mobileerr redalert" style="display: none;">Please Check the mobile Entered</span>
                            <span class="redalert">@error('mobile'){{$message}} @enderror</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-sm-2 col-form-label">Email<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $keydata->email ?? old('email')}} " required autocomplete="email" placeholder="Enter email here" >
                            <span class="ErrP alert-danger titleerr redalert" style="display: none;">Please Check the email Entered</span>
                            <span class="redalert">@error('email'){{$message}} @enderror</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-sm-2 col-form-label">Password<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="" required autocomplete="password" placeholder="Enter password here" >
                            <span class="ErrP  passworderr redalert" style="display: none;">Please Check the password Entered</span>
                            <span class="redalert">@error('usertype'){{$message}} @enderror</span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-10 offset-sm-2">
                               @if($edit_f ?? '')
                                <button type="submit" class="btn btn-warning">Update</button>
                               @else
                               <button type="submit" class="btn btn-primary" id="savbtn">Add </button>
                               @endif
                               <a type="submit" class="btn btn-success" href="{{route('user')}}">Refresh</a>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
       <br>
            <div class="card">
                <div class="card-header text-white card-header-main">{{ __('List of User') }}</div>

                <div class="card-body">
                    <table id="datatable_view" class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>User name</th>
                        <th>email</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th width="280px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $result)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $result->name }}</td>
                        <td>{{ $result->email }}</td>
                        <td>{{$result->role_users->usertype ?? ''}}</td>
                        <td>
                            @if(($result->status_id)==1)
                            <a class="main-btn info-btn rounded-full btn-hover btn-sm-default" href="{{ route('statususer',\Crypt::encryptString($result->id)) }}">Active</a>
                            @else
                            <a class="main-btn deactive-btn rounded-full btn-hover btn-sm-default" href="{{ route('statususer',\Crypt::encryptString($result->id)) }}">Deactive</a>
                            @endif
                        </td>
                        <td>
                              <a class="btn btn-primary btn-sm" href="{{ route('edituser',\Crypt::encryptString($result->id)) }}">Edit</a>
                            <a class="btn btn-danger btn-sm" href="{{ route('deleteuser',\Crypt::encryptString($result->id)) }}">Delete</a>
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
    var edit=$('#edit_id').val();
    $('.ErrP').hide();
        $('#subtype_div').hide();
if(edit)
{
    var role_id=$('#role_id').val();

    if(role_id==5)
    {
        $('#subtype_div').show();
    }
}


        //sbutype
        $('#usertype').on('change',function(e){
           var subid= this.value;
           if(subid==5)
           {
            $('#subtype_div').show();
           }else{
            $('#subtype_div').hide();
           }
        })
//password

    $('#password').on('keyup',function(e){
        var testres=passwordcheck('#password',this.value);

        if (testres!='true') {
            $('.passworderr').html('');
            $('.passworderr').html(testres);
            $('.passworderr').show();

        } else {
            $('.passworderr').hide();
            var testres=confirmpass('password','cnfpassword');

            if (testres!='true') {
                $('.cnfpassworderr').html('');
                $('.cnfpassworderr').html(testres);
                $('.cnfpassworderr').show();

            } else {
                $('.cnfpassworderr').hide();
            }
        }

    });

//fullname
        $('#fullname').on('keyup', function(e) {
        var testres = engtitle('#fullname', this.value);
        if (!testres) {
            $('.fullnameerr').text("Characters allowed: Alphabets, numbers and special characters such as spaces . , / - _ & @ '\" ? % ! ( ) ; < >  [ ] . No consecutive special characters are allowed except for the combination of space with . , /. ");

            $('.fullnameerr').show();

        } else {
            $('.fullnameerr').hide();
        }
    });

//mobile

    $('#mobile').on('keyup', function(e) {
        var testres = mobileval('#mobile', this.value);
        if (!testres) {
            $('.mobileerr').text('Only numbres and must be 10 digits');

            $('.mobileerr').show();

        } else {
            $('.mobileerr').hide();
        }
    });

//username
    $('#username').on('keyup', function(e) {
        var testres = engtitle('#username', this.value);
        if (!testres) {
            $('.usernameerr').text('Not Allowed');
            $('.usernameerr').show();

        } else {
            $('.usernameerr').hide();
        }
    });

     $('#savbtn').on('click',function(e){
        var flag=0;
        $( ".ErrP" ).each(function( index ) {
            if($( this ).css('display')=='inline'){
                flag=1;
            }
        });
        if(flag==1){
            e.preventDefault();
            return false;
        }else{

        }
    });

    });

</script>
@endsection
