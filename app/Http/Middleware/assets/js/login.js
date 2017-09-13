var formValidate = function() {

    var handleformValidate = function() {

        $('.user-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                 name: {
                    required: true
                },
                email: {
                    required: true
                },
                password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },

            messages: {
                 name: {
                    required: "Please enter your name."
                },
                email: {
                    required: "Please enter your email."
                },
                password: {
                    required: "Please enter your password."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.user-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('.user-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.user-form').validate().form()) {
                    $('.user-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }

    
 

    return {
        //main function to initiate the module
        init: function() {

            handleformValidate();
          //  handleForgetPassword();
          //  handleRegister();

        }

    };

}();

jQuery(document).ready(function() {
    formValidate.init();
});