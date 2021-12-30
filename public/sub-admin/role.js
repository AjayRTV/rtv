$(document).ready(function(){
    /*------------- UserRole Table ------------------*/
        $(function() {
         var table = $('#role-table').DataTable({
         processing: true,
         serverSide: false,
         ajax: "get-tableRole",
         columns: [
             {
                data: 'name',
                name: 'name',
            },
        ],
        //  order: [[ 0, 'ASC' ]],
        responsive: true
       });
     });
    /*------------- Show Click Function -----------------*/
    $('#Mybtn').click(function(){
        $('#animateDataTable').animate({width: "50%"});
        $('#MyForm-data').show(100);
    });
    /*------------- Hide Click Function -----------------*/
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
            if (isFormValid) {
                // var data = $(this).serialize();
                var data = $('form').serialize();
                console.log(data);
                $.ajax({
                    url: "insert-userRole",
                    data: data,  
                    dataType: "json",  
                    success:function(data){
                        $('#animateDataTable').animate({width: "100%"});
                        $('#MyForm-data').hide();
                        $('#role-table').DataTable().ajax.reload();
                        $("#userRole-data")[0].reset();
                        // For Tostore notify
                        toastr.options =
                        {
                            "closeButton" : true,
                        }
                          toastr.success("Data is Inserted successfully");
                    },
                    error: function(data){
                        // $('#emails').text('Duplicate EMail');
                        toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                            toastr.error("Data is not Inserted");
                      }
                });
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