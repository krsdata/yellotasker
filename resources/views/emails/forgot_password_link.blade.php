<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reset password Password</title>
<style type="text/css">
  table {
    border-collapse: collapse;
    border-color:#ccc;
     font-family:Arial, Helvetica, sans-serif ;
}
</style>
</head>
<body>
 
  <table width="600" border="1" align="center" cellpadding="0" cellspacing="1" bgcolor="#971800" style="background-color:#fff;">
      <tr>
          <td align="center" valign="top" bgcolor="#ffffff" >
            <table width="90%" border="0" cellspacing="0" cellpadding="10" style="margin-bottom:10px;">
              <tr>
                <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000;"> 
                  <div>
                  <p>Dear {{$content['first_name']}},</p>
                  <p>Looks like you need to reset your password. Please click the link below on.
                  </p>
                      <p> <a href="{{ url('admin/password/reset?token='.$content['temp_password'].'&key='.$content['encrypt_key']) }} ">Reset Your Password</a>
                    <br>
                     <br> or copy & paste this link into your mobile browser <br>
                    <a href="{{ url('admin/password/reset?token='.$content['temp_password'].'&key='.$content['encrypt_key']) }} ">{{ url('admin/password/reset?token='.$content['temp_password'].'&key='.$content['encrypt_key']) }}</a>
                   
                  </p> 
                  <p> Regards, </p>
                  <p>Team {{$content['greeting']}}</p>
                  </div>
                </td>
              </tr>
            </table> 
        </td>
      </tr>
  </table>
</body>
</html>
