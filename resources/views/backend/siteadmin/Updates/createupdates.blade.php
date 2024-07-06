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
            <div class="card" id="entry_div" @if($errors->any()) style="display: inline;" @lese style="display: none;" @endif>
                <div class="card-header text-white card-header-main">{{isset($edit_f) ? 'Update' : 'Add'}} Link</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                           {{ session('success') }}
                        </div>
                    @endif
                    <input type="hidden" name="Errval" id="Errval" value="{{($errors->any()) ? '1':'2'}}"> 
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                        
                            {!! implode(' ', $errors->all('<span class="text-danger">:message</span>')) !!}
                        </div> <!-- ./alert -->
                    @endif
                    @if(isset($edit_f))
                    <form id="formid" method="POST" action="{{ route('updatelink') }}" enctype="multipart/form-data">
                    @else
                    <form id="formid" method="POST" action="{{ route('storelink') }}" enctype="multipart/form-data">
                    @endif
    
                    @csrf 
                        <input type="hidden" name="hidden_id" value="{{$keydata->id ?? ''}}">
                        <div class="row pt-3">
                            <label for="linktype" class="col-sm-2 col-form-label">Link Type<span class="redalert"> *</span></label>
                            <div class="col-sm-10">
                             <select class="form-control select2 formselect" name="linktype" id="linktype" required>
                                <option value="">Select</option>
                            @foreach($linktype as $linktypes)
                                <option value="{{$linktypes->id}}" @if(isset($edit_f))  {{($linktypes->id == $keydata->download->id) ? 'selected' : ''}} @endif >{{$linktypes->linktype_sub[0]->title}}</option>
                            @endforeach
                            </select>    
                            <span class="ErrP alert-danger menuerr redalert" style="display: none;">Please Check the downloadtype Entered</span>
                            <span class="redalert">@error('downloadtype'){{$message}} @enderror</span>
                            </div>
                        </div>

                        <div class="row mb-3 card-header card-main">
                            @php 
                            $i=0;
                            @endphp
                             
                            @foreach($language as $langs)
                             <input type="hidden"  value="{{$langs->id ?? ''}}" id="sel_lang{{$langs->id}}" name="sel_lang[]">
                            <div class="col-sm-12 card-header card-custom-header bg-secondary text-white mb-3"><label for="path" class="col-sm-2 col-form-label" >{{$langs->name}}</label></div><br/>                  
                            <div class="row div_lan1 mb-3">
                                <div class="col-sm-6 mb-btm" id="div{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Main Title in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="title{{$langs->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title[]" value="{{ $keydata->title ?? old('title.'.$i)}}" required autocomplete="title" placeholder="Enter main {{$langs->name}} here" autofocus >
                                </div><br/>

                                <div class="col-sm-6 mb-btm" id="div{{$langs->id}}"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Alternative text in {{$langs->name}} <span class="redalert"> *</span></label>
                                    <input id="alt_text{{$langs->id}}" type="text" class="form-control @error('alt_text') is-invalid @enderror" name="alt_text[]" value="{{ $keydata->alt_text ?? old('alt_text.'.$i)}}" required autocomplete="alt_text" placeholder="Enter main {{$langs->name}} here" autofocus >
                                </div><br/>

                            </div><br><hr>

                            @php 
                            $i++;
                            @endphp
                            @endforeach
                            <div class="row">
                               <div class="col-sm-6 mb-btm"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">URL<span class="redalert"> *</span></label>
                                    <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ $keydata->url ?? old('url')}}" required autocomplete="url" placeholder="Enter url here" autofocus >
                                </div><br/>
                     
                               <div class="col-sm-6 mb-btm"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Icon class</label>
                                        <!-- <span class="redalert"> *</span> -->
                                    <input id="iconclass" type="text" class="form-control @error('iconclass') is-invalid @enderror" name="iconclass" value="{{ $keydata->iconclass ?? old('iconclass')}}" autocomplete="iconclass" placeholder="Enter iconclass here" autofocus >
                                </div><br/>
                            </div><br/>

                            <div class="row pt-3">
                               <div class="col-sm-6 mb-btm"> 
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">File<span class="redalert"> *</span></label>
                                    <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ $keydata->file ?? old('file')}}" required autocomplete="file" placeholder="Enter file here" autofocus >
                                </div><br/>
                     
                            </div><br/>

                            <div><br/></div>
                            <div class="row mb-1">
                                <div class="col-sm-10 offset-sm-2">
                                   @if($edit_f ?? '')
                                    <button type="submit" class="btn btn-warning">Update</button>
                                   @else
                                   <button type="submit" class="btn btn-primary">Add </button>
                                   @endif
                                   <a type="submit" class="btn btn-success" href="{{route('planning.articlelist')}}">Refresh</a>
                                </div>
                            </div>
                        </div><!-- .row -->
                    </form>
                </div><!-- .card-body -->
            </div><!-- .card -->
            
        </div><!-- .col-12 -->
    </div><!-- .row -->
</div><!-- .container -->
@endsection
@section('page_scripts')
<script>  
 $( document ).ready(function() {
// if($('#Errval').val()!=1){
//     $("#entry_div").hide();

// }
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

// });
</script>
@endsection
