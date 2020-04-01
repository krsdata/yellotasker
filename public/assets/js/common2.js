$(function() {
     var d = new Date(); // for now
     console.log(d.getDate());
    
    $('.datepicker').datepicker({
        dateFormat: 'yy-dd-mm',
        onSelect: function(datetext){

            datetext=datetext+" "+d.getHours()+": "+d.getMinutes()+": "+d.getSeconds();
            $('.datepicker').val(datetext);
        },
    });  

//     $( ".datepicker" ).datepicker({
//      //changeMonth: true,//this option for allowing user to select month
//      //changeYear: true //this option for allowing user to select from year range
//      minDate: new Date(),
//      onSelect : function(selected_date){
//        var selectedDate = new Date(selected_date);
//        var msecsInADay = 86400000;
//        var endDate = new Date(selectedDate.getTime() + msecsInADay);
//        
//         $(".datepicker").datepicker( "option", "minDate", endDate );
//      }
//    });
    
    $('#dropoff_date').datepicker({});

    $('.email-error').css('width', '100%');

    $("#user_login").validate({
        errorLabelContainer: '.error-loc',
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
            }
        },
        // Specify the validation error messages
        messages: {
            email: {
                required: email_req},
            password: {
                required: password_req,
            },
        },
        submitHandler: function(event) {
            $("#user_login").submit();
        }
    });




});

function changeStatus(id,method)
{
    var status =  $('#'+id).attr('data');
     
    $.ajax({
        type: "GET",
        data: {id: id,status:status},
        url: url+'/'+method,
        beforeSend: function() {
           $('#'+id).html('Processing');
        },
        success: function(response) {
            
            if(response==1)
            {
                $('#'+id).html('Active'); 
                $('#'+id).attr('data',response);
                $('#'+id).removeClass('label label-warning status').addClass('label label-success status');
                
                 console.log(response);
                 $('#btn'+id).removeAttr('disabled');
            }else
            {
                $('#'+id).html('Inactive'); 
                $('#'+id).attr('data',response);
                $('#'+id).removeClass('label label-success status').addClass('label label-warning status');
                $('#btn'+id).attr('disabled','disabled');
            }
        }
    });
}


function changeAllStatus(id,method,status)
{
    //var status =  $('#'+id).attr('data');
    //alert(url); return false;
    $.ajax({
        type: "GET",
        data: {id: id,status:status},
        url: url+'/'+method,
        beforeSend: function() {
           $('#'+id).html('Processing')
        },
        success: function(response) {
            
            if(response==1)
            {
                $('#'+id).html('Approved'); 
                $('#'+id).attr('data',response);
                $('#'+id).removeClass('label label-warning status').addClass('label label-success status');
                
                  
                
            }else if(response==2)
            {
                $('#'+id).html('Not Approve'); 
                $('#'+id).attr('data',response);
                $('#'+id).removeClass('label label-success status').addClass('label label-warning status');
                
            }
            else
            {
                $('#'+id).html('Yet not Approve'); 
                $('#'+id).attr('data',response);
                $('#'+id).removeClass('label label-success status').addClass('label label-warning status');
                
            }
        }
    });
}
