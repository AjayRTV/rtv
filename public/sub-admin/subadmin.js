$(document).ready(function () {

    $("#formButton").click(function () {
        $("#hideform").toggle();
    });
     

    // ----------------------  [ Data Table ] --------------------
    var table = $('#data-table').DataTable({
        processing: false,
        serverSide: false,
        ajax: "get-userRole",
        columns: [
            {data: 'id', name: 'id',
            "visible": false,
            // "searchable": false
            },
            {
                render: function ( data, type, row ) {
                return row.firstName + ' ' + row.lastName + ' ';
            }
        },
        
        {
            data: 'contact',
        },
        {
            data: 'email',
        },
        
        {
            data: 'role',
        },
        ]
    });
   
    // ----------------------  [ user Role ] ----------------------
    $('#Mybtn').click(function () {
        $('#animateTable').animate({ width: "50%" });
        // $("#Mybtn").load(location.href + " #userroleForm");
        $('#MyForm').show();
        $("#first-name").val("");
        $("#last-name").val("");
        $("#contact").val("");
        $("#password").val("");
        $("#email").val("");
        $("#userID").val("");
        // $("#selectRole").val("userRole");
 
        setTimeout(function() {
            window.location.reload();
       },1000000000);
    });

    //  ------------------- [ user back ] -------------------------
    $('#User_Back').click(function () { 
        $('#animateTable').animate({ width: "100%" });
        $("#MyForm").hide();
        $('#fstname').text(''); 
        $('#lstname').text('');
        $('#contacts').text('');
        $('#emails').text('');
        $('#passwords').text(''); 

    });
    
    //  ------------------- [ Update Data user role] -------------------------
     $("#addroleuser").on('click', function (e) { 
    //  $('input').keyup(function () { 
        e.preventDefault();
        var data = $('form').serialize();
        var fname = $("#first-name").val();
        var lname = $("#last-name").val();
        var contacts = $("#contact").val();
        var contact = $("#contact").val().length;
        var email = $("#email").val();
        var regExp = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var password = $("#password").val();
        var passwords = $("#password").val().length;
        
        var userrole = $('#userRole :selected').text();
    //    alert(userrole);    
        // var firstname = jQuery(this).val(); alert(firstname);
        

        var userid = $("#userID").val().length;
        var userIds = $("#userID").val();

      
        // ---------------- ['update_user Role'] --------------------
        if(userid > 0){
            if( fname == "" || lname =="" || contact == "" || email =="" || password == "" || !email.match(regExp) || contact < 10   ){
                if (fname == "") {
                    $('#fstname').text('*Enter First-Name');
                }
                if (lname == "") {
                    $('#lstname').text('*Enter Last-Name');
                }
                if (contact == 0) {
                    $('#contacts').text('*Enter Contact');
                } 
                if (email == "") {
                    $('#emails').text('*Enter mail');
                }
                if (password == 0) {
                    $('#passwords').text('*Enter Password');
                }
                 
                    
                $('input').keyup(function () {
                    var fname = $("#first-name").val().length;
                    if (fname == 0) {
                        $("#fstname").text("* Enter Name ");
                        // return false;
                    }
                    else if (fname < 3) {
                        $("#fstname").text("* Enter Minumum 3 charactor ");
                    }
                    else if (fname > 2) {
                        $("#fstname").text(" ");
                    }
                    var lname = $("#last-name").val().length;
                    if (lname == 0) {
                        $("#lstname").text(" *Enter Minumum 3 charactor ");
                    }
                    else if (lname < 3) {
                        $("#lstname").text(" *Enter Minumum 3 charactor ");
                    }
                    else if (fname > 2) {
                        $("#lstname").text(" ");
                    }
                    var contact = $("#contact").val().length;
                    if (contact == 0) {
                        $("#contacts").text(" *Enter Contact Number ");
                    } else if (contact < 10 && contact > 0) {
                        $("#contacts").text("* Minimum 10 Numner ");
                    } else if (contact > 12) {
                        $("#contacts").text("*Maximum 12 charator");
                    } else if (contact == 10 && contact < 13) {
                        $("#contacts").text("");
                    }

                    var emails = $("#email").val().length;
                    var email = $("#email").val();
                    var regExp = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

                    if(emails == 0   )
                    {
                        $('#emails').text('*Email is Required'); 
                    }
                    else if (!email.match(regExp)) {
                        $('#emails').text('*Invalid Email');
                    }
                    else if (email != "" && email.match(regExp)) {
                        $('#emails').text(''); 
                    }
                    var password = $("#password").val().length;
                    if (password == 0) {
                        $("#passwords").text(" *Enter password ");
                        return false;
                    }
                    else if (password < 6 && password > 0) {
                        $('#passwords').text('*Enter password Min 6 Charactor');
                        return false;
                    }
                    else if (password > 15) {
                        $('#passwords').text('*Enter Max  12 Charactor');
                        return false;

                    }
                    else if (password == 6 && password <= 15) {
                        $('#passwords').text('');
                    }
                    
                });    
            }    
            else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "roleUpdate",
                    type: "get",
                    dataType: "json",
                    data: data+"&userID="+userIds,
                    
                    success: function (data) {
                            $("#saveRoleData")[0].reset(); 
                            $('#animateTable').animate({ width: "100%" });
                            $('#data-table').DataTable().ajax.reload();
                            $('#MyForm').hide();
                            $('.setpostion').hide();
                            $('#emails').val('');
                            toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                                toastr.success("Update User Data");
                    },
                    error: function(data){
                        $('#emails').text('Duplicate EMail');
                        toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                            toastr.error("Duplicate Mail");
                    
                    }
                
                });
            }
        }
        // ------------------- ['User Role Insert] ---------------------
        else{
           
            if( fname == "" || lname =="" || contact == "" || email =="" || password == "" || !email.match(regExp) || contact < 10 || passwords < 6 || userrole == Select-Role  ){
                if (fname == "") {
                    $('#fstname').text('*Enter First-Name');
                }
                if (lname == "") {
                    $('#lstname').text('*Enter Last-Name');
                }
                if (contact == 0) {
                    $('#contacts').text('*Enter Contact');
                } 
                if (email == "") {
                    $('#emails').text('*Enter mail');
                }
                if (password == 0) {
                    $('#passwords').text('*Enter Password');
                }
                if(userrole == Select-Role){
                    $('userroles').text("*Select Role")
                }

                $('input').keyup(function () {
                    var fname = $("#first-name").val().length;
                    if (fname == 0) {
                        $("#fstname").text("*Enter Name ");
                        // return false;
                    }
                    else if (fname < 3) {
                        $("#fstname").text("*Enter Minumum 3 charactor ");
                    }
                    else if (fname > 2) {
                        $("#fstname").text(" ");
                    }
                    var lname = $("#last-name").val().length;
                    if (lname == 0) {
                        $("#lstname").text("*Enter Minumum 3 charactor ");
                    }
                    else if (lname < 3) {
                        $("#lstname").text("*Enter Minumum 3 charactor ");
                    }
                    else if (fname > 2) {
                        $("#lstname").text(" ");
                    }
                    var contact = $("#contact").val().length;
                    if (contact == 0) {
                        $("#contacts").text("*Enter Contact Number ");
                    } else if (contact < 10 && contact > 0) {
                        $("#contacts").text("*Minimum 10 Numner ");
                    } else if (contact > 12) {
                        $("#contacts").text("*Maximum 12 charator");
                    } else if (contact == 10 && contact < 13) {
                        $("#contacts").text("");
                    }

                    var emails = $("#email").val().length;
                    var email = $("#email").val();
                    var regExp = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

                    if(emails == 0   )
                    {
                        $('#emails').text('*Email is Required'); 
                    }
                    else if (!email.match(regExp)) {
                        $('#emails').text('*Invalid Email');
                    }
                    else if (email != "" && email.match(regExp)) {
                        $('#emails').text(''); 
                    }
                    var password = $("#password").val().length;
                    if (password == 0) {
                        $("#passwords").text("*Enter password ");
                        return false;
                    }
                    else if (password < 6 && password > 0) {
                        $('#passwords').text('*Enter password Min 6 Charactor');
                        return false;
                    }
                    else if (password > 15) {
                        $('#passwords').text('*Enter Max  12 Charactor');
                        return false;

                    }
                    else if (password == 6 && password <= 15) {
                        $('#passwords').text('');
                    }
                    
                });    
            }    
            else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "roleEdit",
                    type: "get",
                    dataType: "json",
                    data: data,
                    success: function (data) {
                            // $("#saveRoleData")[0].reset(); 
                            $('#animateTable').animate({ width: "100%" });
                            $('#data-table').DataTable().ajax.reload();
                            $('#MyForm').hide();
                            $('.setpostion').hide();
                            // $('#emails').val('');
                            $("#addroleuser").load(location.href + " #addroleuser");
                            toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                                toastr.success("SuccessFully Insert");
                    },
                    error: function(data){
                        $('#emails').text('Duplicate EMail');
                        toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                            toastr.error("Duplicate Mail");
                    
                    }
                
                });
            }
        }    
    });

    // ---------------- ['Eit_user Role'] --------------------
    $("#data-table").on('click', 'td', function (){
        var data =  table.row( this ).data();
        $("#fstname").text(" ");
        $("#lstname").text(" ");
        $('#emails').text(''); 
        $('#passwords').text('');
        $("#contacts").text("");
   
        $('#user-Role > option[data="'+ userrole +'"]').prop('selected', true);
        $('#animateTable').animate({ width: "50%" });
        $('#MyForm').show();
        $.ajax({
            url: "edit_user",
            type: "get",
            dataType: 'json',
            data: data,
            success: function(response){
                if( $.each(response.data, function( index, value ) {
                    var role = value.role;
                    $("#userID").val(value.id);
                    $("#first-name").val(value.firstName);
                    $("#last-name").val(value.lastName);
                    $("#contact").val(value.contact);
                    $("#email").val(value.email);
                    $("#password").val(value.password);
                    $("#userRole").val(value.role).change();
                })); 
            }
        });
    });



    
    // ---------------------------- ['  End For Document Class '] ---------------------------
});

