<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Udex Interview Notification</title>
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
                      <p>Dear {{ucfirst($content['name'])}},</p>
                      <p> {{ ucwords($content['interview_created_by'])}} has added you to a Udex evaluation. You'll
be evaluating  {{ $content['condidate_name']}}.</p>
                      <p>Enjoy! <p> 
                      <p>Team</p>
                  </div>
                </td>
              </tr>
            </table> 
        </td>
      </tr>
  </table>
</body>
</html>
