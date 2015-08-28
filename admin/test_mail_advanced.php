<html>
<head>
<title>PHPMailer - Mail() advanced test</title>
</head>
<body>

<?php
require_once './mailer1/class.phpmailer.php';

$mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch
$mail_ids[] = array('mohamedjassim5@outlook.com', 'jassim.colan@gmail.com', 'jasim@colanonline.com'); 
try {
    
  $mail->AddReplyTo('name@yourdomain.com', 'First Last');
  foreach ($mail_ids as $id => $name){
  $mail->AddAddress($id, $name);
  }
  $mail->SetFrom('noreply@sohorepro.com', 'First Last');
  $mail->AddReplyTo('noreply@sohorepro.com', 'First Last');
  $mail->Subject = 'PHPMailer Test Subject via mail(), advanced';
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML(file_get_contents('./mailer1/examples/mail_template.html'));
//  $mail->AddAttachment('images/phpmailer.gif');      // attachment
//  $mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
?>
</body>
</html>
