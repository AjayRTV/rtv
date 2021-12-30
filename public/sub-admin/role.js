$(document).ready(function(){
    /*------------- UserRoleList Table ------------------*/
         var table = $('#role-table').DataTable({
         processing: true,
         serverSide: false,
         ajax: "get-tableRole",
         columns: [
            { data: 'id', name: 'id',},
            { data: 'name', name: 'name',},
         ],
         order: [[ 0, 'ASC' ]],
         responsive: true
       });
    //*----------------EditForm show click function -------------------*
       $("#role-table").on('click', 'td', function (){
        var data =  table.row( this ).data();
        $('#animateDataTable').animate({width: "50%"});
        $('#MyForm-InsertData').show();
        $.ajax({
            url: "edit-userRole",
            type: "get",
            dataType: 'json',
            data: data,
            success: function(response){
                if( $.each(response.data, function( index, value ) {
                    $('#roleId').val(value.id);
                    $('#first-name').val(value.name);
                }));
            }
        });
    });
    //*----------------InsertForm Back Button -------------------*
    $('#back-btn').click(function(event){
        event.preventDefault();
        $('#animateDataTable').animate({width: "100%"});
        $('#MyForm-InsertData').hide();
    });
    /*------------- InsertForm Show Click Function -----------------*/
    $('#Mybtn').click(function(e){
        $('#animateDataTable').animate({width: "50%"});
        $('#MyForm-InsertData').show(100);
        $("#first-name").val('');
        $("#roleId").val('');
    });
    /*-------------InsertForm Validation Hide Click Function -----------------*/
    const fname = document.querySelector('#first-name');
    const form = document.querySelector('#userRole-data');
        /*---------------- First Name -------------*/
        const checkfName = () => {
            let valid = false;
            const min = 3;
            const max = 15;
            const name = fname.value.trim();
            if(!isRequired(name)) {
                showError(fname, '* First Name is required.');
            }else if (!isBetween(name.length, min, max)) {
                showError(fname, `* First Name must be between ${min} and ${max} characters.`)
            } else if(!isLetters(name)){
                showError(fname, '* Only characters are allowed!');
            }else {
                showSuccess(fname);
                valid = true;
            }
            return valid;
        };
        const isRequired = value => value === '' ? false : true;
        const isBetween = (length, min, max) => length < min || length > max ? false : true;
        const isLetters = (name) => {
            const re = /^[a-zA-Z]*$/g;
            return re.test(name);
        };
        const showError = (input, message) => {
            const formField = input.parentElement;
            formField.classList.remove('success');
            formField.classList.add('error');
            const error = formField.querySelector('small');
            error.textContent = message;
        };
        const showSuccess = (input) => {
            const formField = input.parentElement;
            formField.classList.remove('error');
            formField.classList.add('success');
            const error = formField.querySelector('small');
            error.textContent = '';
        };
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            let isfNameValid = checkfName();
            let isFormValid = isfNameValid;
            var userIds = $('#roleId').val().length;
            var userId = $('#roleId').val();
            if(userIds > 0){
                if (isFormValid) {
                    var data = $(this).serialize()+"&id="+userId;
                    console.log(data);
                    $.ajax({
                        url: "update-userRole",
                        data: data,
                        dataType: "json",
                        success:function(data){
                            $('#animateDataTable').animate({width: "100%"});
                            $('#MyForm-InsertData').hide();
                            $('#role-table').DataTable().ajax.reload();
                            $("#userRole-data")[0].reset();
                            $("#first-name").val('');
                            toastr.options ={
                                "closeButton" : true,
                            }
                            toastr.success("Data is Updated successfully");
                        },
                        error: function(data){
                            toastr.options ={
                                "closeButton" : true,
                                "progressBar" : true
                            }
                            toastr.error("Data is not Updated");
                        }
                    });
                }
            }
            else{
                if (isFormValid) {
                    var data = $(this).serialize();
                    console.log(data);
                    $.ajax({
                        url: "insert-userRole",
                        data: data,
                        dataType: "json",
                        success:function(data){
                            $('#animateDataTable').animate({width: "100%"});
                            $('#MyForm-InsertData').hide();
                            $('#role-table').DataTable().ajax.reload();
                            $("#userRole-data")[0].reset();
                            toastr.options ={
                                "closeButton" : true,
                            }
                            toastr.success("Data is Inserted successfully");
                        },
                        error: function(data){
                            toastr.options ={
                                "closeButton" : true,
                                "progressBar" : true
                            }
                            toastr.error("Data is not Inserted");
                        }
                    });
                }
            }
        });
        const debounce = (fn, delay = 500) => {
                let timeoutId;
                return (...args) => {
                    if (timeoutId) {
                        clearTimeout(timeoutId);
                    }
                    timeoutId = setTimeout(() => {
                        fn.apply(null, args)
                    }, delay);
                };
            };
            form.addEventListener('input', debounce(function (e) {
                switch (e.target.id) {
                    case 'first-name':
                        checkfName();
                        break;
                }
            }));
});
