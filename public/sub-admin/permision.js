
// ---------------- [ Show Permision Form ] ----------------
$(document).ready(function(){ 
    $('#createPermision').click(function () {
        $('#permisiontable').animate({ width: "50%" });
        $('#form1').show();
    });

 // ---------------- [ Permision Back ] ----------------
 $('#permisionBack').click(function(e){
        $('#permisiontable').animate({width: "100%"});
        $('#form1').hide();
    });

 

// -------------- [' Toogle Form '] -----------------
    $('.toggle-class').change(function() { 
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var user_id = $(this).data('id'); 
       
    })    
})

$(function() {
    $('.toggle-class').change(function() { 
         // $(".toggle-class").on('click', 'td', function (){
    
        var status = $(this).prop('checked') == true ? 1 : 0;  
     
        var user_id = $(this).data('id');  
         
        var roleid = $(this).val(); 
      
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/givePermision',
            data: {'status': status, 'user_id': user_id , 'roleid':roleid},
            success: function(data){  
              console.log(data.success)
            }
        });
    })
 
//  ---------------- [' Add Permision '] ----------------------

$('#addPermision').click(function(e){  
        // var name = $('#permisionName').val();
        var data = $('form').serialize();
        jQuery.ajax({
            url:"userPermision",
            type: "get",
            data: data,
            success:function(response){  
                $('#permisiontable').animate({width: "100%"});  
                $('#form1').hide();
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true
                }
                    toastr.success("Add Permision Success..!!!!");
            } 
        });
        e.preventDefault();
    });



});    