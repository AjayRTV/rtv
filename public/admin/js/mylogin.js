/******************************************
 * My Login
 *
 * Bootstrap 4 Login Page
 *
 * @author          Muhamad Nauval Azhar
 * @uri 			https://nauval.in
 * @copyright       Copyright (c) 2018 Muhamad Nauval Azhar
 * @license         My Login is licensed under the MIT license.
 * @github          https://github.com/nauvalazhar/my-login
 * @version         1.2.0
 *
 * Help me to keep this project alive
 * https://www.buymeacoffee.com/mhdnauvalazhar
 * 
 ******************************************/

'use strict';
$(function() {
 
     $("#loginbtn").click(function(e){  
        
        var email = $("#userName").val();
        var password =$("#adminpassword").val();
        var regExp = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        
        // var href = $(this).attr("http://127.0.0.1:8000/home");
        // +++++++++ For Email +++++++++++
        if(email == ""){  
            $('#adminEmail').text('Please Enter mail');
        }
        else if (!email.match(regExp)){
            $('#adminEmail').text('Invalid Email');
            return false;
        }else{
            $('#adminEmail').text('');                
        }
       // +++++++++ For Password +++++++++++
        if( password == "" )
        {
            $('#adminpasswords').text('Please Enter password');
            return false;
        }
        else if(password.length < 6)
        {
          $('#adminpasswords').text('Please Enter password Min 6 Charactor');
          return false;
        }
        else if(passwords.length > 13)
        {
          $('#adminpasswords').text('Please Enter Max  12 Charactor');
          return false;  
        }
        
        else{
            // return true;
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:'get',
                uploadUrl: '{{route("product/create")}}',
                // data: {'viewmonth': date},
                success: function (response) {
                    // alert("hear");
                    // window.location.href = "http://127.0.0.1:8000/home
                    // window.location = '{{ route('product.list.cats') }}';
                    $(".content-container").load('http://127.0.0.1:8000/home');
                }
            });
        }
    });
    

});
 