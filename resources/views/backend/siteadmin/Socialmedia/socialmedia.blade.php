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
            
            <div class="card">
                <div class="card-header text-white card-header-main">{{ __('List of Social media') }}</div>
       
                <div class="row"><div class="col-sm-9"></div><div class="col-sm-3 mt-3"><a href="{{route('createsocialmedia')}}" id="addlogobtn" class="btn btn-flat btn-point btn-sm btn-success"><i class="fas fa-plus"></i>&nbsp;Add New Record</a></div> </div>
                <div class="card-body">
                    <table id="datatable_view" class="table table-striped">
                    <thead>    
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>URL</th>
                        <th>Icon</th>
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
                        <td>{{$result->socialmedia_sub[0]->title ?? ''}}</td>
                        <td>{{$result->url}}</td>
                        <td>{{$result->iconclass}}</td>
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
$('.div_lan1').hide();
$('.div_lan2').hide();
    // validation in LAng.
    $('#language').on('keyup', function(e) {
        var testres = engtitle('#language', this.value);
        if (!testres) {
            $('.titleerr').text("Not Allowed ");

            $('.titleerr').show();

        } else {
            $('.titleerr').hide();
        }
     });

    // validation in class icon
    $('#icon_class').on('keyup', function(e) {
        var testres = iconclasscheck('#icon_class', this.value);
        if (!testres) {
            $('.iconerr').text("Not Allowed ");

            $('.iconerr').show();

        } else {
            $('.iconerr').hide();
        }
     });


//append lang
   $(".radioval").click(function () {

    var val=$(this).attr('value');
    var check =  $(this).prop('checked');
 
    if(check)
    {

        if($(this).attr('value') != '') {
            $('.div_lan1').show();
            $('.div_lan2').show();
            $('#div'+val).show();
            $('#div_alt'+val).show();
            $('#div_icon'+val).show(); 
            $('#div_sub'+val).show();        
       }

       else {
        
            $('#div'+val).hide();  
            $('#div_icon'+val).hide(); 
            $('#div_sub'+val).hide(); 
            $('#div_alt'+val).hide();  
       }

    }else{
        
         $('#div'+val).hide();
         $('#div_sub'+val).hide();   
         $('#div_icon'+val).hide(); 
         $('.div_lan1').hide();
         $('.div_lan2').hide();
         $('#div_alt').hide();
         $("#sel_lang"+val).prop('checked', false);
    }

   
   });

});
</script>
