
$(function() {
     
/* 
Method : Delete particulare record
@param : id,status
Author : Kundan Roy
Description : delete particular record from dataBase
*/
$('button[name="remove_levels"]').on('click', function(e){
//    bootbox.confirm('hello');
     var self = $(this);   
    var form = $(this).closest('form'); 
    e.preventDefault(); 
    
   bootbox.confirm('<b><h3>Are you sure?</h3></b>',function(result){
	if(result)
	{
         var id = self.attr('id');
         
	    $('#deleteForm_'+id).submit();
	}   
 	
   });
});
                                    
	 	 

    

});
/* 
Method : changeStatus
@param : id,controllerName (example user)
Author : Kundan Roy
Description : Change the status of record to activate or deactivate
*/
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
            
	  //bootbox.alert('Activated');            
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
/* 
Method : changeAllStatus
@param : id,controllerName (example user)
Author : Kundan Roy
Description : Change the status of all record to activate or deactivate
*/

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
/************28/12/2015[Ismael]***************/
var Title1='This field is required';
$(document).ready(function(){
$("#group_title").validate({          
        errorClass: 'error', // default input error message class        
        rules: {
            Title: {
                required: true,                    
            }
        },
        // Specify the validation error messages
        messages: {
            Title: {
                required: Title1               
                },           
        },
        submitHandler: function(event) {
             $("#group_title").submit();
         }
    });

/***********for users**************/
var firstname_msg="First Name is required."; 
var email_msg="Email Should be Validate.";
var pwd_msg="Password is required.";

$('#saveBtn').click(function(){
	//alert('saveBtn');
});


$("#users_form1").validate({          
        errorClass: 'error', // default input error message class        
        rules: {
            first_name: {
                required: true,                    
            },
            
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
           	first_name: {
                required: firstname_msg               
                },  
            email: {
                required: email_msg               
                },
            password: {
                required: pwd_msg,
                },     
        },
        submitHandler: function(event) {
	    
             $("#users_form").submit();
             return false;
         }
    });

/***************for package*******************/
var namefr="NameFR Should be filled.";
var nameen="NameEN Should be filled.";
var price="Price Should be filled and must be numeric";
var month="Month Should be filled.";
$("#package").validate({          
        errorClass: 'error', // default input error message class        
        rules: {
            NameFR: {
                required: true,                    
            },
            NameEN: {
                required: true,                    
            }
            ,
            Price: {
                required: true, 
                            
            }
            ,
            Month: {
                required: true,                    
            }
        },
        // Specify the validation error messages
        messages: {
            NameFR: {
                required: namefr               
                }, 
            NameEN: {
                required: nameen               
                }, 
            Price: {
                required: price 
                             
                },
            Month: {
                required: month               
                },           
        },
        submitHandler: function(event) {
             $("#package").submit();
         }
    });
/*****************building**********************/
var Title_img="Title Should be filled.";
var file_name="File name Should be filled.";
$("#building").validate({          
        errorClass: 'error', // default input error message class        
        rules: {
            Title: {
                required: true,                    
            },
            File_name: {
                required: true,                    
            }                    
        },
        // Specify the validation error messages
        messages: {
            Title: {
                required: Title_img               
                }, 
            File_name: {
                required: file_name               
                }       
        },
        submitHandler: function(event) {
             $("#building").submit();
         }
    });

var price_by_month1="Price by month Should be filled.";
$("#building_rent").validate({          
        errorClass: 'error', // default input error message class        
        rules: {
            price_by_month: {
                required: true,                    
            }                  
        },
        // Specify the validation error messages
        messages: {
            price_by_month: {
                required: price_by_month1               
                }      
        },
        submitHandler: function(event) {
             $("#building_rent").submit();
         }
    });
var inclusion="Inclusion Should be filled.";
$("#building_inc").validate({          
        errorClass: 'error', // default input error message class        
        rules: {
            Inclusion: {
                required: true,                    
            }                  
        },
        // Specify the validation error messages
        messages: {
            Inclusion: {
                required: inclusion               
                }      
        },
        submitHandler: function(event) {
             $("#building_inc").submit();
         }
    });

var exclusion="Exclusion Should be filled.";
$("#building_exc").validate({          
        errorClass: 'error', // default input error message class        
        rules: {
            Exclusion: {
                required: true,                    
            }                  
        },
        // Specify the validation error messages
        messages: {
            Exclusion: {
                required: exclusion               
                }      
        },
        submitHandler: function(event) {
             $("#building_exc").submit();
         }
    });

});


$(function(){
    

    $('form.forget-form').on('submit',function(){
       
        e.preventDefault(); 

        var email =  $('#email').val(); 

        var url =  $('form.forget').attr('data');

        alert('url');
        $.ajax({
            type: "GET",
            data: {emailemail: email},
            url: url+'/forgetPwd',
            beforeSend: function() {
               $('#'+id).html('Processing');
            },
              success: function(response) {
                
          //bootbox.alert('Activated');            
            if(response==1)
                {
                     
                }else
                {
                    
                }
            }
        });

    });

});