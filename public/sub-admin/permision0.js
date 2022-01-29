$(document).ready(function(){  
    $('#addPermision').on('submit',function(e){  
        // var name = $('#permisionName').val();
        var data = $('form').serialize();
        jQuery.ajax({
            url:"userPermision",
            type: "get",
            data: data,
            success:function(response){    
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
})

 $('#showtable').click(function () {   alert(1);
        $('#editAdmin').animate({ width: "50%" });
        $('#admineditform').show();
    });
    

  $('#createPermision').click(function(e){ alert(1);
        
    });

    $('#permisionBack').click(function(e){
        $('#permisionTable').animate({width: "100%"});
        $('#form1').hide();
    });
