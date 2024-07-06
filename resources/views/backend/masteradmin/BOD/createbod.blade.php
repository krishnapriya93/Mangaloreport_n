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
            <!-- <div><a class="btn btn-primary btn-sm" id="addarticle">Add BOD</a></div> -->
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
            <div class="card" id="entry_div" >
                <!-- <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} BOD</div> -->
                <div class="card-body">
                   
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                           {{ session('error') }}
                        </div>
                    @endif
                    
                    <input type="hidden" name="Errval" id="Errval" value="{{($errors->any()) ? '1':'2'}}"> 
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                        
                            {!! implode(' ', $errors->all('<span class="text-danger">:message</span>')) !!}
                        </div> <!-- ./alert -->
                    @endif
                   
                    <form id="formid" method="POST" action="{{ route('planning.updateBOD') }}" enctype="multipart/form-data">
              
    
                    @csrf 
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                       
                        <div class="row mb-3 card-header card-main">
                            @php 
                            $i=0;
                            @endphp
                            @foreach(($keydata->bodsub) as $bodsub)
                            
                            <div class="col-sm-12">
                                <div class="row card-header card-custom-header bg-secondary text-white mb-3 mt-2">
                                    <div class="col-sm-6 mb-btm"> 
                                      <input type="hidden"  value="{{$bodsub->languageid ?? ''}}" id="sel_lang{{$bodsub->languageid}}" name="sel_lang[]">
                                        <label for="path" class="col-sm-5 col-form-label" >Details in {{$bodsub->lang_sel->name}}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 mb-btm" id="div{{$bodsub->id}}"> 
                                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Name in {{$bodsub->lang_sel->name}} <span class="redalert"> *</span></label>
                                            <input id="name{{$bodsub->id}}" type="text" class="form-control @error('name') is-invalid @enderror" name="name[]" value="{{ $bodsub->name ?? old('name.'.$i)}}" required autocomplete="name" placeholder="Enter name {{$bodsub->name}} here" autofocus >
                                        </div><br/>

                                        
                                        <div class="col-sm-6 mb-btm" id="div_description{{$bodsub->id}}"> 
                                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Description in {{$bodsub->lang_sel->name}}</label>
                                            <textarea id="description{{$bodsub->id}}" class="form-control ckeditor @error('description') is-invalid @enderror" name="description[]" value="{{ $keydata->description ?? old('description.'.$i)}}" autocomplete="language" placeholder="Enter description in {{$bodsub->name}} here" autofocus >{{ $bodsub->description}}</textarea>
                                        </div><br/>
                                </div>
                                <div class="col-sm-6 mb-btm" > 
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect2">Designation  in {{$bodsub->lang_sel->name}}</label>
                                        <select class="form-control" id="desig_id{{$bodsub->id}}" name="desig_id[]">
                                            <option selected>Select Designation</option>
                                                @php 
                                                    $k=1;
                                                @endphp
                                            @foreach($designation as $desig)
                                           
                                                @foreach($desig->des_sub as $desigsub)
                                                  
                                                        <option value="{{\Crypt::encryptString($desigsub->id)}}" @if(isset($editF)) {{ $desigsub->id == $bodsub->desig_id ? 'selected' : '' }} @endif >{{$desigsub->title}}</option>
                                                   
                                                @endforeach
                                                @php 
                                                        $k++;
                                                    @endphp
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 mb-btm" id="div{{$bodsub->id}}"> 
                                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Alternative title in {{$bodsub->lang_sel->name}} <span class="redalert"> *</span></label>
                                            <input id="alt{{$bodsub->id}}" type="text" class="form-control @error('alt') is-invalid @enderror" name="alt[]" value="{{ $bodsub->alt ?? old('alt.'.$i)}}" required autocomplete="alt" placeholder="Enter alt {{$bodsub->name}} here" autofocus >
                                    </div><br/>
                                </div>
                               

                            </div>                               
                            
                            @php 
                            $i++;
                            @endphp
                            @endforeach
                            <div class="row card-header card-custom-header bg-secondary text-white mb-3 mt-2">
                                    <div class="col-sm-6 mb-btm"> 
                                        <label for="path" class="col-sm-2 col-form-label" >Common</label>
                                    </div>
                            </div>
                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-6 mb-btm" > 
                                    <div class="form-group">
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Mobile Number </label>
                                            <input id="mobilenumber" type="text" class="form-control @error('mobilenumber') is-invalid @enderror" name="mobilenumber" value="{{ $keydata->mobilenumber ?? old('mobilenumber')}}" autocomplete="mobilenumber" placeholder="Enter Mobile number here" autofocus >
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-btm" > 
                                    <div class="form-group">
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Office Number <span class="redalert"> *</span></label>
                                            <input id="officenumber" type="text" class="form-control @error('officenumber') is-invalid @enderror" name="officenumber" value="{{ $keydata->officenumber ?? old('officenumber')}}" required autocomplete="officenumber" placeholder="Enter Office Number here" autofocus >
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-btm" > 
                                    <div class="form-group">
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Email <span class="redalert"> *</span></label>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $keydata->email ?? old('email')}}" required autocomplete="email" placeholder="Enter Email here" autofocus >
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-btm" > 
                                    <div class="form-group">
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Photo </label>
                                            <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" value="{{ $keydata->photo ?? old('photo')}}" autocomplete="photo" placeholder="Enter Photo here" autofocus >
                                    </div>
                                    <div class="col-sm-3 mb-btm" id=""> 
                                        <img id="preview-image-before-upload" rel="" class="preview-image-before-upload imgstamp" src="{{asset('uploads/bod/'.$keydata->photo)}}" alt="preview image">
                                   </div><br/>
                                </div>                                
                                <div class="col-sm-6 mb-btm" > 
                                        <div class="form-group form-check">
                                        <label for="exampleFormControlSelect2"></label>
                                        <br>
                                            <input type="checkbox" class="form-check-input" name="desig_flag" id="desig_flag" value="1">
                                            <label class="form-check-label" for="exampleCheck1">Minister</label>
                                        </div>
                                </div>
                                <br/>
                            </div>
                         
                           
                            <div class="row mb-1">
                                <div class="col-sm-10 offset-sm-2">
                                   @if($editF ?? '')
                                    <button type="submit" class="btn btn-warning">Update</button>
                                   @else
                                   <button type="submit" class="btn btn-primary">Add </button>
                                   @endif
                                   <!-- <a type="submit" class="btn btn-success" href="{{route('planning.articlelist')}}">Refresh</a> -->
                                </div>
                            </div>
                        </div><!-- .row -->
                    </form>
                </div><!-- .card-body -->
            </div><!-- .card -->
          
    </div><!-- .row -->
</div><!-- .container -->
@endsection
@section('page_scripts')
<script>  
 $( document ).ready(function() {
    $(".selecttag").select2({
      width: '100%',
      tags:true,
    });


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
    // $('#addarticle').on('click', function(e) { 
    //     if ($('#entry_div').css('display') == 'none') {
    //         $('#entry_div').show();
    //     } else {
    //         $('#entry_div').hide();
    //     }
        
        
    // });
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
   $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
      $(".alert").slideUp(2000);
    });
   
    $('.alert').alert();
});
</script>
@endsection