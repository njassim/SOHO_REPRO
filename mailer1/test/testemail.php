<?php
/**
* Simple example script using PHPMailer with exceptions enabled
* @package phpmailer
* @version $Id$
*/

require '../class.phpmailer.php';
        $mail = new PHPMailer(true); //New instance, with exceptions enabled

        $message  .='<html>';
        $message .='<head>';
        $message .='<title></title>';
        $message .='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
        $message .='</head>';
        $message .='<body>';
        $message .='<table width="100%" border="0" cellspacing="0" cellpadding="0">';
        $message .='<tr>';
        $message .='<td width="5%"  style="font-weight:bold;">S.N</td>';
        $message .='<td width="20%" style="font-weight:bold;">Provider</td>';
        $message .='<td width="20%" style="font-weight:bold;">Contact</td>';
        $message .='<td width="8%"  style="font-weight:bold;">1st Req</td>';
        $message .='<td width="8%"  style="font-weight:bold;">2nd Req</td>';
        $message .='<td width="6%"  style="font-weight:bold;">Amt</td>';
        $message .='<td width="8%"  style="font-weight:bold;">DateRec</td>';
        $message .='<td width="8%"  style="font-weight:bold;">DateSnt</td>';
        $message .='<td width="8%"  style="font-weight:bold;">RcRd</td>';
        $message .='<td width="10%" style="font-weight:bold;">Comment</td>';
        $message .='</tr>';
        $message .='<tr>';
        $message .='<td width="5%">1</td>';
        $message .='<td width="20%">Jassim</td>';
        $message .='<td width="20%"></td>';
        $message .='<td width="8%">4534</td>';
        $message .='<td width="8%">56536</td>';
        $message .='<td width="6%">$12</td>';
        $message .='<td width="8%">5764</td>';
        $message .='<td width="8%">6576</td>';
        $message .='<td width="8%">6756</td>';
        $message .='<td width="10%">Cogfhmment</td>';
        $message .='</tr>';
        $message .='</tr>';    
        $message .='</table>';
        $message .='</body>';
        $message .='</html>';
	$body             = preg_replace('/\\\\/','', $message); //Strip backslashes

//	$mail->IsSMTP();                           // tell the class to use SMTP
//	$mail->SMTPAuth   = true;                  // enable SMTP authentication
//	$mail->Port       = 25;                    // set the SMTP server port
//	$mail->Host       = "mail.yourdomain.com"; // SMTP server
//	$mail->Username   = "name@domain.com";     // SMTP server username
//	$mail->Password   = "password";            // SMTP server password

	$mail->IsSendmail();  // tell the class to use Sendmail

	$mail->AddReplyTo("name@domain.com","First Last");

	$mail->From       = "name@domain.com";
	$mail->FromName   = "First Last";
        $mail->Subject  = "First PHPMailer Message";
        $mail->MsgHTML($body);
        $mail->AddAttachment('test.png');      // attachment      
        $mail->IsHTML(true); // send as HTML
        
	$to = array('mohamedjassim5@gmail.com','mohamedjassim5@outlook.com','jasim@colanonline.com');
        foreach ($to as $add){
	$mail->AddAddress($add);	
        }
        $result = $mail->Send();
        if($result){
	echo 'Message has been sent.';
        } 
        else
        {
        echo 'Message has been not sent.';    
        }
        
        
?>
