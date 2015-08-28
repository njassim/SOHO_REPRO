<?php
$to = "mohamedjassim5@gmail.com";
$subject = "Test subject";
$txt = "Hello world!";
$headers = "From: webmaster@example.com" . "\r\n" .
"CC: somebodyelse@example.com";

$result = mail($to,$subject,$txt,$headers);

if($result){
    echo 'Message sent';
}  else {
    echo 'Message not sent'; 
}

