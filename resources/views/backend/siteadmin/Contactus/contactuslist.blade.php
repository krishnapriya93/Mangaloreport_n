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
                <div class="card-header text-white card-header-main">{{ __('List of Contactus') }}</div>
               
                <div class="row"><div class="col-sm-9"></div><div class="col-sm-3 mt-3"><a href="{{route('siteadmin.createcontactus')}}" id="addlogobtn" class="btn btn-flat btn-point btn-sm btn-success"><i class="fas fa-plus"></i>&nbsp;Add New Record</a></div> </div>

                <div class="card-body">
                    <table id="datatable_view" class="table drag_tab table-striped">
                    <thead>    
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Address</th>
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
                        <td>{{$result->contact_sub[0]->title ?? ''}}</td>
                        <td>{{strip_tags($result->contact_sub[0]->address ?? '')}}</td>
                        <!-- <td>{{$result->logo_type[0]->name ?? ''}}</td> -->
                        <td>

                        <a class="btn btn-primary btn-sm-default" href="{{ route('siteadmin.editcontactus',\Crypt::encryptString($result->id)) }}">Edit</a>
                            <a class="btn btn-danger btn-sm-default" href="{{ route('siteadmin.deletecontactus',\Crypt::encryptString($result->id)) }}">Delete</a>
                       
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
    $(".alert").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert").slideUp(500);
    });
   
    $('.alert').alert();
});

//ORDER CHNAGE
$(".drag_tab").sortable({
         handle: function(e) {
      console.log('Handled');
    },
    items: 'tr:not(:first)',
    connectWith: 'div.bin',
    helper: 'clone',
    start: function (e, ui) {
       $(this).addClass('draggigtr');
    },
    stop: function (e, ui) {
        $(this).removeClass('draggigtr');
        var rowCount = $('#datatable_view tr').length;
        var num =$('.SNum').text();
        var digits = num.toString().split('');
        var realDigits = digits.map(Number);
        var movement = ui.position.top - ui.originalPosition.top > 0 ? "down" : "up";
        console.log("Stopped"+movement+realDigits+' '+rowCount);
        realDigits.sort(function(a, b) {
            return a - b;
        });
        var j=0;
        var officer_id=0;
        var names='';
       
        var action_url='';

        var usertype=$("#usertype_id").val(); 
        
        var action_url = "/OrderchangeContactus_form"; 
        
        $('.SNum').each(function () {
            officer_id=$(this).attr('id');
            names=$(this).attr('name');
            j++;
            $.ajax({
                url: action_url,
                type: 'get',
                data: {
                    'id': officer_id,
                    'val':j,
                    'names':names
                },
                dataType: 'json',
                success: function(result) {
                    /* alert(result);*/
                            window.location.reload();
                    


                }
            });
            
            $(this).text(j);
            console.log(officer_id+' id');
        });

        
    }
});
</script>
@endsection
