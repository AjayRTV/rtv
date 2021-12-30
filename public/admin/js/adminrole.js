$(document).ready(function() {
    $("#usersupdates").click(function() {
    $("#UpdateData").toggle();
    });
});

// $("#admin-table").on('click', 'td', function (){
//     $("#hideform").toggle();
// });


$(document).ready(function(){ 
   var table = $('#admin-table').DataTable({
        ajax: "admindata",
        columns: [ 
            {
                data: 'name',
                name: 'name' 
            },
            {
                data: 'email',
                name: 'email'
            },
        ]
    });

    $('#showtable').click(function () {   ;
        $('#editAdmin').animate({ width: "50%" });
        $('#admineditform').show();
    });
    
    $('#AdminBack').click(function (e) { 
        e.preventDefault()
        $('#editAdmin').animate({ width: "100%" });
        $("#admineditform").hide(); 
        $('#userroleForm').hide();
        $('#imgInp').val("");
        $('#blah').ajaxForm({target: '.preview'}).submit();
         
        
    });

      // $("#editAdmin").click(function(stay){  
        $("#admin-table").on('click', 'td', function (stay){
        var data =  table.row( this ).data();
        // console.log(data);    
        jQuery.ajax({
            url:"editAdmin",
            type: "get",
            data: data,
            success:function(data){    
                //$('#editAdmin').animate({ width: "50%" });
                $(".UpdateAdminData").show();
                $('#userroleForm').show();
              
            } 
        });
        stay.preventDefault(); 
    });
   
    // =-=-=-=-=-=-=-=-=-=-=-=-=-= [ For Image ] =-=-=-=-=-=-=-=-=--=-=-=-=
    // $('#image').change(function(){
    //     let reader = new FileReader();
    //     reader.onload = (e) => { 
    //         $('#image_preview_container').attr('src', e.target.result); 
    //     }
    //     reader.readAsDataURL(this.files[0]); 
    // });

    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
          blah.src = URL.createObjectURL(file)
        }
      }

    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-[ Update Admin Data ] =-=-======-==--=-=-=-=-= 
    $('.UpdateAdminData').submit(function(e) {   
        e.preventDefault();      
        var formData = new FormData(this);
        var adminname = $('#username').val();  
        var adminEmail = $('#adminemail').val();
        var regExp = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
       
        if( adminname == "" || adminEmail =="" || !adminEmail.match(regExp)  )
        { 
            var adminname = $('#username').val().length;
            if (adminname == 0) {  
                $('#adminName').text('Enter Name ');
            }   
            var emails = $("#adminemail").val().length;
            if (emails < 0) { 
                $('#adminEmail').text('Enter Email ');
            }  
            var email = $("#adminemail").val();
            var regExp = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (!email.match(regExp)) {
                $('#adminEmail').text('Invalid Email');
            }
            else if (email != "" && email.match(regExp)) {
                $('#adminEmail').text(''); 
            }
            $('input').keyup(function () {
                var adminname = $("#username").val().length;
                if (adminname < 3) {
                    $("#adminName").text("Enter Minumum 3 charactor ");
                    // return false;
                }else if (adminname > 2) {
                    $("#adminName").text(" ");
                }
                var email = $("#adminemail").val();
                var regExp = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (!email.match(regExp)) {
                    $('#adminEmail').text('Invalid Email');
                }
                else if (email != "" && email.match(regExp)) {
                    $('#adminEmail').text(''); 
                }
            });    
        }
        else{
            $.ajax({
                type:'post',
                url: "updateAdmin",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function (response) {     
                console.log(response.value);    
                   if( $.each(response.data, function( index, value ) {  
                        $("#admineditform").hide(); 
                        $("#userroleForm").hide();
                        $("#data-table").show();
                        $('#editAdmin').animate({ width: "100%" });
                        // $("#adminname").text(value.name);
                        
                        // $('#adminemail').text(value.email); 
                        $("#imgInp").val("");
                        $('#admin-table').DataTable().ajax.reload();
                        toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success("Update  Data");
                    })); 
                  else{
                        toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.error(" Fill Image Type ");
                  }   
                      
                },
              });   
          }    
    }); 

    //  ==-----------------= [End Doccument] =------------------=
});       

 