<?php

include('km_smtp_class.php');

/* $mail = new KM_Mailer(server, port, username, password, secure); */
/* secure can be: null, tls or ssl */
$mail = new KM_Mailer("smtp.sohorepro.com", "110", "richard@sohorepro.com", "Password1", "tls");

if($mail->isLogin) {
  /* for localhost server no login is required: */
  /* $mail = new KM_Mailer('localhost', '25'); */

  /* $mail->send(from, to, subject, body, headers = optional) */
  $mail->send('jassim.colan@gmail.com', 'richard@sohorepro.com', 'test email 1', 'This is a <b>multipart email</b>!');

  /* more emails can be sent on the same connection: */
  $mail->send('UserName <username@mydomain.com>', 'Recipient <recipent@somedomain.com>', 'test email 2', 'This is a <b>multipart email</b>!');

  /* add more recipients */
  $mail->addRecipient('New Recipient <newrecipient@somedomain.com>');

  /* add CC recipient */
  $mail->addCC('CC Recipient <ccrecipient@somedomain.com>');

  /* add BCC recipient */
  $mail->addBCC('CC Recipient <bccrecipient@somedomain.com>');

  /* add attachment */
  $mail->addAttachment('pathToFileToAttach');

  /* send multipart email with different plain text part */
  $mail->altBody = "This is an alternate body for multiipart emails.";
  $mail->send('UserName <username@mydomain.com>', 'Recipient <recipent@somedomain.com>', 'test email 3', 'This is a multipart email with a <b>different plain text part</b>!');

  /* send just a plain text email and test if it was sent successfully */
  $mail->contentType = "text/plain";
  if(!$mail->send('username@mydomain.com', 'recipent@somedomain.com', 'test email 4', 'This is a plain text email.')) {
    echo "Failed to send email";
  } else {
    echo "Email sent successfully";
  }

  /* clear recipients and attachments */
  $mail->clearRecipients();
  $mail->clearCC();
  $mail->clearBCC();
  $mail->clearAttachments();
} else {
  echo "Login failed <br>";
}

?>
