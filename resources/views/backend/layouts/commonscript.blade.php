

<script>
	//  $('input').on("change",function(){
	// 	alert();
	//  });
	
/*Submit*/
$('img').on('load',function(e){
    var dataURL_img1=$(this).attr('src');
    var url = dataURL_img1;

if(url.search('blob:') == -1){
  //do something
  console.log("####"+dataURL_img1);
  return false;
}else{
    console.log("******"+dataURL_img1); 
}

    // var base64Matcher = new RegExp("^(?:[data]{4}:(text|image|application)\/[a-z]*)");
    //  if (base64Matcher.test(dataURL_img1)) {
    //                     console.log("******"+dataURL_img1);

    //                     }else{
    //                         console.log("####"+dataURL_img1);
    //                         return false;
    //                     }
	// 	console.log($(this).attr('src'));
	});
$('.form-control').on('keyup',function(e){
// var test=field_hidden('id',$(this).val());
var test=$(this).val();

if(test){
// console.log($(this).nextAll('.errorSpan').attr('class'));
// $(this).nextAll('.errorSpan').find('.class');
$(this).nextAll('.errorSpan').remove();
}else{
// $('<span class="text-danger">Not valid</span>').insertAfter($(this));
$(this).nextAll('.errorSpan').remove();
$(this).after('<span class="text-danger errorSpan">Invalid character</span>');
e.preventDefault();
}
});


$('textarea').on('keyup',function(e){
var test=field_hidden('id',$(this).val());
// alert(test);
if(test){
// console.log($(this).nextAll('.errorSpan').attr('class'));
// $(this).nextAll('.errorSpan').find('.class');
$(this).nextAll('.errorSpan').remove();
}else{
// $('<span class="text-danger">Not valid</span>').insertAfter($(this));
$(this).nextAll('.errorSpan').remove();
$(this).after('<span class="text-danger errorSpan">Invalid character</span>');
e.preventDefault();
}
});
$('input').on('keyup',function(e){

var test=field_hidden('id',$(this).val());

if(test){
// console.log($(this).nextAll('.errorSpan').attr('class'));
// $(this).nextAll('.errorSpan').find('.class');
$(this).nextAll('.errorSpan').remove();
}else{
// $('<span class="text-danger">Not valid</span>').insertAfter($(this));
$(this).nextAll('.errorSpan').remove();
$(this).after('<span class="text-danger errorSpan">Invalid character</span>');
e.preventDefault();
}
});
$('form').on('submit',function(e){
var lenErr=$(".errorSpan" ).length;
if( lenErr > 0 ) {

e.preventDefault();
return false;
$('form').submit(false);
}
});
/*Submit*/   


function field_hidden(id, testval) {
		var flag = '';
		var flag1 = '';
		var flag2 = '';
		console.log(" In entitle--- "+testval);
		// \\\$^*#~\
		var specialChars = "^\=\:"
		var check = function(string) {
			for (i = 0; i < specialChars.length; i++) {

				if (string.indexOf(specialChars[i]) > -1) {

					return 0;
				}
			}
			return 1;



		}
		if (testval.includes("&gt;") || testval.includes("&lt;") || testval.includes("../") || testval.includes("&lt;" + "script" + "&gt;") || testval.includes("<" + "script" + ">") || testval.includes("&lt;" + "/script" + "&gt;") || testval.includes("</" + "script" + ">")) {
			return false;
		} else {
			var res = check(testval);
			if (res == 1) {
				// if((testval.length<3) || (testval.length>20000)){
				// 	return false;
				// }else{
					return true;
				// }
			} else {
				return false;
			}
		}
	}

 $(document).ready(function() {
    $( ".activesideNav" ).trigger( "focus" );
// document.querySelectorAll(".nav-item").forEach((ele) =>
//   ele.addEventListener("click", function (event) {
//     event.preventDefault();
//     document
//       .querySelectorAll(".nav-item")
//       .forEach((ele) => ele.classList.remove("active"));
//     this.classList.add("active")
//   })
// );
    // $('#datepicker').datepicker();
    //CKeditor
// $('.ckeditor').ckeditor();

 

var ckkseb = $('.ckeditor').each(function() {

	// var base64Matcher = new RegExp("^(?:[data]{4}:(text|image|application)\/[a-z]*)");
    //                 console.log(base64Matcher.test($this.attr('upload'))+":;;;;;:::");

		CKEDITOR.replace(this.name, {
			filebrowserUploadUrl: "{{route('articleckimageupload', ['_token' => csrf_token() ])}}",
			filebrowserUploadMethod: 'form',
			extraPlugins: 'colorbutton,font,justify,print,tableresize,liststyle,pagebreak,widget,image',
			bodyClass: 'document-editor',
			height: 250,
			allowedContent: true,
			filebrowserImageUploadAllowedExtensions: ['jpg', 'jpeg', 'png'],
			fileInputSetAttribute :['accept', '.jpg, .jpeg, .png'],
			types: ['jpeg', 'png'],
			// removeButtons: 'PasteFromWord'
		});
		
	});
    var ckkseb = $('.ckeditor1').each(function() {
		CKEDITOR.replace(this.name, {
			filebrowserUploadUrl: "{{route('articleckimageupload', ['_token' => csrf_token() ])}}",
			filebrowserUploadMethod: 'form',
			extraPlugins: 'colorbutton,font,justify,print,tableresize,liststyle,pagebreak,widget,image',
			bodyClass: 'document-editor',
			height: 250,
			allowedContent: true,
			filebrowserImageUploadAllowedExtensions: ['jpg', 'jpeg', 'png'],
			fileInputSetAttribute :['accept', '.jpg, .jpeg, .png'],
			types: ['jpeg', 'png'],

			// removeButtons: 'PasteFromWord'
		});
	});
    var ckkseb = $('.ckeditor12').each(function() {
		CKEDITOR.replace(this.name, {
			filebrowserUploadUrl: "{{route('articleckimageupload', ['_token' => csrf_token() ])}}",
			filebrowserUploadMethod: 'form',
			extraPlugins: 'colorbutton,font,justify,print,tableresize,liststyle,pagebreak,widget,image',
			bodyClass: 'document-editor',
			height: 250,
			allowedContent: true,
			filebrowserImageUploadAllowedExtensions: ['jpg', 'jpeg', 'png'],
			fileInputSetAttribute :['accept', '.jpg, .jpeg, .png'],
			types: ['jpeg', 'png'],

			// removeButtons: 'PasteFromWord'
		});
		console.log($("input[name='upload']").attr('src'));
	});
	var ckkseb = $('.ckeditorarticle').each(function() {
		CKEDITOR.replace(this.name, {
			filebrowserUploadUrl: "{{route('articleckimageupload', ['_token' => csrf_token() ])}}",
			filebrowserUploadMethod: 'form',
			extraPlugins: 'colorbutton,font,justify,print,tableresize,liststyle,pagebreak,widget,image',
			bodyClass: 'document-editor',
			height: 250,
			allowedContent: true,
			filebrowserImageUploadAllowedExtensions: ['jpg', 'jpeg', 'png'],
			fileInputSetAttribute :['accept', '.jpg, .jpeg, .png'],
			types: ['jpeg', 'png'],
			// removeButtons: 'PasteFromWord'
		});
	});
	var ckkseb = $('.ckeditormilestone').each(function() {
		CKEDITOR.replace(this.name, {
			filebrowserUploadUrl: "{{route('articleckimageupload', ['_token' => csrf_token() ])}}",
			filebrowserUploadMethod: 'form',
			extraPlugins: 'colorbutton,font,justify,print,tableresize,liststyle,pagebreak,widget,image',
			bodyClass: 'document-editor',
			height: 250,
			allowedContent: true,
			filebrowserImageUploadAllowedExtensions: ['jpg', 'jpeg', 'png'],
			fileInputSetAttribute :['accept', '.jpg, .jpeg, .png'],
			types: ['jpeg', 'png'],
			// removeButtons: 'PasteFromWord'
		});
	});
$('.setting_components').on('click',function(e){
    // alert($(this).parent().html());
   
$(this).parent().parent().addClass('show');
// e.preventDefault();
// alert($(this).parent().parent().attr('class'));
});

$('#datatable_view').DataTable();
$('#datatable_view1').DataTable();
$('#datatable_view2').DataTable();
$('#datatable_view3').DataTable();
$('#datatable_view4').DataTable();

    $(".select2").select2({
        //   tags: true
        placeholder: 'Select option',
        allowClear: true
    });

    $(".TEST").select2({
        //   tags: true
        placeholder: 'Select',
        allowClear: true
    });
    $(".selecttag").select2({
      width: '100%',
      tags:true,
    });
    
});
//english title validation    
        // function engtitle(id, testval) {
        //         var tested = new RegExp('^[a-zA-Z0-9 -\ \s]+$');

        //         if (!tested.test(testval)) {
        //             return false;

        //         } else {
        //             return true;
        //         }
        //     }
        function engtitle(id, testval) {
		var flag = '';
		var flag1 = '';
		var flag2 = '';

		var specialChars = "\\\$^*#~\^\=\:"
		var check = function(string) {
			for (i = 0; i < specialChars.length; i++) {

				if (string.indexOf(specialChars[i]) > -1) {
					return 0;
				}
			}
			return 1;



		}
		if (testval.includes("&gt;") || testval.includes("&lt;") || testval.includes("../") || testval.includes("&lt;" + "script" + "&gt;") || testval.includes("<" + "script" + ">") || testval.includes("&lt;" + "/script" + "&gt;") || testval.includes("</" + "script" + ">")) {
			return false;
		} else {
			var res = check(testval);
			if (res == 1) {
				return true;
			} else {
				return false;
			}
		}
	}

//malayalam title validation            
        // function maltitle(id, testval) {

        //     var tested = new RegExp('^[a-zA-Z -\ \s]+$');
        //     if (!tested.test(testval)) {
        //         return false;

        //     } else {
        //         return true;
        //     }
	        // }
            function maltitle(id, testval) {
		var flag = '';
		var flag1 = '';
		var flag2 = '';

		var specialChars = "/\/\/\\\>\<\?@%$^*#~\[\]\^\=\:"
		var check = function(string) {
			for (i = 0; i < specialChars.length; i++) {

				if (string.indexOf(specialChars[i]) > -1) {
					return 0;
				}
			}
			return 1;



		}
		if (testval.includes("../") || testval.includes("&lt;" + "script" + "&gt;") || testval.includes("<" + "script" + ">") || testval.includes("&lt;" + "/script" + "&gt;") || testval.includes("</" + "script" + ">")) {
			return false;
		} else {
			var res = check(testval);
			if (res == 1) {
				return true;
			} else {
				return false;
			}
		}


	}
//Form reset
            function resetForm() 
            {
            document.getElementById("formiid").reset();
            }
//Path validation
        function pathcheck(id, testval) {

            var tested = new RegExp('^[a-zA-Z\/\]+$');

            if (!tested.test(testval)) {
                return false;
            } else {
                return true;
            }
        }
    //key url validation
	function urlkeycheck(id, testval) {

		var tested = new RegExp('^[0-9a-zA-Z\_\]+$');

		if (!tested.test(testval)) {
			return false;
		} else {
			return true;
		}
		}    
//Icon class
        function iconclasscheck(id, testval) {
            var tested = new RegExp('^[a-zA-Z \s\-]+$');
            if (!tested.test(testval)) {
                return false;
            } else {
                return true;
            }
        }

//Password
    function passwordcheck(id, testval) {
        // At least 1 alphabet

        // At least 1 digit

        // Contains no space

        // Optional special characters e.g. @$!%*#?&^_-

        // Minimum 8 characters long        

        var tested = /^(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z\d@$!%*#?&^_-]{8,}$/;
        if (testval.search(tested) != 0) {
            return 'Please enter valid password At least 1 alphabet,At least 1 digit, Contains no space,Optional special characters e.g. @$!%*#?&^_- Minimum 8 characters long';
        } else {
            return 'true';
        }
    }

//mobile
    function mobileval(id, testval) {
        var tested = /^[0-9]{10}$/;
        if (testval.search(tested) != 0) {
            // $('#Savebtn').attr('disabled','disabled');
            return false;

        } else {
            //  $('#Savebtn').removeAttr('disabled');
            return true;
        }

    }

//image
    function imageval_question(id, testval) {
        var file = testval;
        var fileType = file["type"];
        var filesize = file["size"];
        console.log(fileType + 'fileType');
        // if( document.getElementById(id).files.length == 0 && ($('#edit_or').val() !='E') ){
        // swal("No poster file selected"); //write another function..
        // e.preventDefault();
        // }  
        // console.log(filesize + 'filesize');
        var validImageTypes = ["image/webp", "image/jpeg", "image/png", "image/jpg","audio/mpeg","video/mp4"];
        if ($.inArray(fileType, validImageTypes) < 0) {
            return 'Only file type: webp/jpeg/png/jpg/mp3/mp4 is acceptable';
        } else {
            if (filesize > 10000000) {

                return 'Size should be less than 10 MB';
            } else {
                return 'true';
            }

        }
    }

//image height
    function imageheightwidth(id, width, height) {
        if ((width == 500) && (height == 500)) {
            return 'true';
        } else {
            return 'File dimention 500x500 only';
        }
    }   
	
//Pressrealse image height
function pressrelaseimage(id, width, height) {
        if ((width == 960) && (height == 900)) {
            return 'true';
        } else {
            return 'File dimention 960x900 only';
        }
    }   	
	//image Generation
    function generationimage(id, width, height) {
        if ((width == 300) && (height == 300)) {
            return 'true';
        } else {
            return 'File dimention 300x300 only';
        }
    }  
//Main slider Size : 1920px*480px -sbu
function imageheightwidth_mainbackground(id, width, height) {
alert(width);
if ((width == 1920) && (height == 480)) {
	return 'true';
} else {
	return 'File dimention 1920x480 only';
}
}	

//Banner Size : 1920px*400px -sbu
function imageheightwidth_mainslider_sbu(id, width, height) {

		if ((width == 1920) && (height == 400)) {
			return 'true';
		} else {
			return 'File dimention 1920x400 only';
		}
	}
//Banner Size : 1280px*512px	
function imageheightwidth_mainslider(id, width, height) {

if ((width == 1280) && (height == 512)) {
	return 'true';
} else {
	return 'File dimention 1280*512 only';
}
}	

//logo Size :  200px84px	
function imageheightwidth_logo(id, width, height) {

if ((width == 200) && (height == 84)) {
	return 'true';
} else {
	return 'File dimention  200px*84px only';
}
}	

//Sbu Size : 640px*640px
function sbu_image_size(id, width, height) {
if ((width == 640) && (height == 640)) {
	return 'true';
} else {
	return 'Poster dimention 640x4640 only';
}
}
//mainbackground	1920*440px
function mainbackground(id, width, height) {

if ((width == 1920) && (height == 440)) {
	return 'true';
} else {
	return 'File dimention 1920*440 only';
}
}	
//banner
function imageval(id, testval) {

		var file = testval;
		var fileType = file["type"];
		var filesize = file["size"];

		// if( document.getElementById(id).files.length == 0 && ($('#edit_or').val() !='E') ){
		// swal("No poster file selected"); //write another function..
		// e.preventDefault();
		// }  
		console.log(filesize + 'filesize');
		var validImageTypes = ["image/webp", "image/jpeg", "image/png", "image/jpg" ,"image/gif"];
		if ($.inArray(fileType, validImageTypes) < 0) {
			return false;
		} else {
		    return true;
		}
	}    

//email validation
function emailval(id, testval) {
		var tested = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,50}$/;
		if (testval.search(tested) != 0) {
			// $('#Savebtn').attr('disabled','disabled');
			return false;

		} else {
			//  $('#Savebtn').removeAttr('disabled');
			return true;
		}
	}
</script>
  

