<?php
require_once "Mail.php";
$from = "Yello tasker <hr@yellotasker.com>";
$to = "Tech Support <hazmi@rocksoft.com.my>";
$subject = "Hi!";
$body = "Hi,\n\nHow are you?";
$host = "ssl://6668.smtp.antispamcloud.com";
$port = "465";
$username = "smtp@yellotasker.com";
$password = "xw3ooIXBXKBrMqy";
$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'port' => $port,
    'auth' => true,
    'username' => $username,
    'password' => $password));
$mail = $smtp->send($to, $headers, $body);
if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
 } else {
  echo("<p>Message successfully sent!</p>");
 }
?>
