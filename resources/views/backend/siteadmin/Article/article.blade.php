@extends('backend.layouts.htmlheader')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb justify-content-center">
        {!!$breadcrumbarr!!}
    </ol>
</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 pb-5">
        <div class="row"><div class="col-sm-9"></div><div class="col-sm-3 mt-3"><a href="{{route('createarticle')}}" id="addlogobtn" class="btn btn-flat btn-point btn-sm btn-success"><i class="fas fa-plus"></i>&nbsp;Add New Record</a></div> </div>
        
<div class="card" id="datatable_div">
 <div class="card-header text-white card-header-main">{{ __('List of Article') }}</div>             
    <div class="card-body">
        <div class="row">
            <div class="col-12 py-3">
                <div class="table-reponsive">
                    <table id="datatable_view" class="table  table-striped h6" style="width:100%">
                                <thead>    
                                    <tr class="tablehead py-1 ">
                                        <th class="tabsm">No</th>
                                        <th class="tabsm">Title</th>
                                        <th class="tabsm">Subtitle</th>
                                        <th class="tabsm" width="280px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $key => $result)
                                    <tr class="table-sm">
                                            <td class="tabsm">{{ $loop->iteration }}</td>
                                            <td class="tabsm">@foreach( $result->articleval_sub as $dt){{ $dt->title }}<br>@endforeach</td>
                                            <td class="tabsm">@foreach( $result->articleval_sub as $dt1){{ strip_tags($dt1->subtitle) }}<br>@endforeach</td>
                                            <td class="tabsm">
                                                <a class="btn btn-primary btn-sm" href="{{ route('editarticle',\Crypt::encryptString($result->id)) }}">Edit</a>
                                                <a class="btn btn-danger btn-sm" href="{{ route('deletearticle',\Crypt::encryptString($result->id)) }}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                              
                                            </td>
                                    </tr>   
                                @endforeach    
                                </tbody>    
                    </table>    
                </div><!--reponsive -->
            </div><!--col-12 -->
        </div><!--row -->
    </div><!--card body -->
</div> <!--card header -->
</div><!-- card -->
    </div><!-- .row -->
</div><!-- .container -->
@endsection
@section('page_scripts')
<script>  

 $( document ).ready(function() {

    var sbu_view_edit=$('#sbu_view_edit').val();
 
    if(sbu_view_edit==2){
        $(".usertype_div").show();
    }
    

    $(".selecttag").select2({
      width: '100%',
      tags:true,
    });
   
    if($('#EditF').val()=='E'){
        $("#entry_div").show();
        $("#datatable_div").hide();
        

    }else{
        if($('#Errval').val()!=1 && $('#EditF').val()!='E')
        {
            $("#entry_div").hide();
        }
    }
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
    $('#addarticle').on('click', function(e) { 
        if ($('#entry_div').css('display') == 'none') {
            $('#entry_div').show();
        } else {
            $('#entry_div').hide();
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
     var edit=$('#edit_f').val();
    $('.postererr1').hide();
    $('.postererr2').hide();

    if(edit=='E')
    {
        var hidden_id =$('.radioval').val();
        $('#datatable_div').hide();
        var value = '#preview-image-before-upload'+hidden_id;
        // alert(value);
        $('.preview_poster').show();    
            let reader = new FileReader();
         
            reader.onload = (e) => { 
         
              $(value).attr('src', e.target.result); 
            }

            reader.readAsDataURL(this.files[0]); 
            // $(".poster")[0].reset();
        $('.preview_poster').show();
    }else{

        $('.preview_poster').hide(); 
    }
     //poster view
     $('.poster').change(function(){
       
   var i =$(this).attr('rel');

   var value = '#preview-image-before-upload'+i;
//    alert(value);
        $('.preview_poster').show();    
            let reader = new FileReader();
         
            reader.onload = (e) => { 
         
              $(value).attr('src', e.target.result); 
            }

            reader.readAsDataURL(this.files[0]); 
            // $(".poster")[0].reset();
           });
//Restricted
$("#restricted").click(function () {
    $(".usertype_div").show();
});
//append lang
  /* $(".radioval").click(function () {

    var val=$(this).attr('value');
    var check =  $(this).prop('checked');
 
    if(check)
    {

        if($(this).attr('value') != '') {
            $('.div_lan1').show();
            $('.div_lan2').show();
            $('#div'+val).show();
            $('#div_alt'+val).show()
            $('#div_poster'+val).show(); 
            $('#div_sub'+val).show();        
            $('#div_content'+val).show();        
       }

       else {
        
            $('#div'+val).hide();  
            $('#div_poster'+val).hide(); 
            $('#div_sub'+val).hide(); 
            $('#div_content'+val).hide(); 
            $('#div_alt'+val).hide();   
       }

    }else{
        
         $('#div'+val).hide();
         $('#div_sub'+val).hide();   
         $('#div_poster'+val).hide(); 
         $('.div_lan1').hide();
         $('.div_lan2').hide();
         $('#div_alt').hide()
         $('#div_content').hide()
         $("#sel_lang"+val).prop('checked', false);
    }

   
   });*/
   $(".alert").fadeTo(5000, 5000).slideUp(5000, function() {
      $(".alert").slideUp(10000);
    });
   
    $('.alert').alert();
});
</script>
@endsection