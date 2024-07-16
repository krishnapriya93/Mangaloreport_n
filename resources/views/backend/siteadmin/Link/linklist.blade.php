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
                <div class="card-header text-white card-header-main">{{ __('List of Links') }}</div>
                @if($errors->any())
                        <div class="alert alert-danger" role="alert">

                            {!! implode(' ', $errors->all('<li><span class="text-danger">:message</span></li>')) !!}
                        </div> <!-- ./alert -->
                @endif
                <div class="row"><div class="col-sm-9"></div><div class="col-sm-3 mt-3"><a href="{{route('createlinks')}}" id="addlogobtn" class="btn btn-flat btn-point btn-sm btn-success"><i class="fas fa-plus"></i>&nbsp;Add New Record</a></div> </div>
                <div class="card-body">
                    <table id="datatable_view3" class="drag_tab table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>URL</th>
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
                        <td name="{{$result->link_sub[0]->title}} ?? ''" id="{{\Crypt::encryptString($result->id)}}" class="SNum3 sortnum_{{$i}} officer_id-{{\Crypt::encryptString($result->id)}}">{{ $loop->iteration }}</td>
                        <td>{{$result->link_sub[0]->title ?? ''}}</td>
                        <td>{{$result->url ?? ''}}</td>
                        <td>
                            @if(($result->status_id)==1)
                            <a class="main-btn info-btn rounded-full btn-hover btn-sm-default" href="{{ route('statuslink',\Crypt::encryptString($result->id)) }}">Active</a>
                            @else
                            <a class="main-btn deactive-btn rounded-full btn-hover btn-sm-default" href="{{ route('statuslink',\Crypt::encryptString($result->id)) }}">Deactive</a>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm-default" href="{{ route('editlinks',\Crypt::encryptString($result->id)) }}">Edit</a>
                            <a class="btn btn-danger btn-sm-default" href="{{ route('deletelink',\Crypt::encryptString($result->id)) }}">Delete</a>
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
@include('backend.layouts.commonscript')
@section('page_scripts')
<script>
 $( document ).ready(function() {
  //common alert display time set

  $(".alert").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert").slideUp(500);
    });

});
 ////
     /*alert($(".drag_tab").attr('class'));*/
     $(".drag_tab").sortable({
         handle: function(e) {
      console.log('Handled');
    },
    items: 'tr:not(:first)',
    connectWith: 'div.bin',
    helper: 'clone',
    start: function (e, ui) {
       $(this).addClass('draggigtr3');
    },
    stop: function (e, ui) {
        $(this).removeClass('draggigtr3');
        var rowCount3 = $('#datatable_view3 tr').length;
        var num3 =$('.SNum3').text();
        var digits3 = num3.toString().split('');
        var realDigits3 = digits3.map(Number);
        var movement3 = ui.position.top - ui.originalPosition.top > 0 ? "down" : "up";
        console.log("Stopped"+movement3+realDigits3+' '+rowCount3);
        realDigits3.sort(function(a, b) {
            return a - b;
        });
        var m=0;
        var officer_id3=0;
        var names3='';

        var action_url3='';
        // if(usern==3){
        //     action_url="{{ url('OrderchangeJury_form') }}";
        // }else if(usern==5){
        //     action_url="{{ url('articlemanager/OrderchangeJury_form') }}";
        // }else if(usern==6){
        //     action_url="{{ url('mediamanager/OrderchangeJury_form') }}";
        // }
        var usertype=$("#usertype_id").val();
        var action_url3 = "/Orderchangelinklist_form";

        $('.SNum3').each(function () {
            officer_id3=$(this).attr('id');
            names3=$(this).attr('name');
            m++;
            $.ajax({
                url: action_url3,
                type: 'get',
                data: {
                    'id': officer_id3,
                    'val':m,
                    'names':names3
                },
                dataType: 'json',
                success: function(result) {
                    /* alert(result);*/
                            window.location.reload();



                }
            });

            $(this).text(m);
            console.log(officer_id3+' id');
        });


    }
});
</script>
@endsection
