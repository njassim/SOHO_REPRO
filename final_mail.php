<?php

$mail_id                = getActiveEmailOrder();


//$customer_email = CompanyMail($company_id);
$customer_email         = array('email_id' => CompanyMail($company_id));
array_push($mail_id, $user_mail, $customer_email);


foreach ($mail_id as $mails_sent)
{
    $pre_filt[] = $mails_sent['email_id'];
}

$final_list = array_unique($pre_filt);

foreach ($final_list as $to){
$subject = "Soho Repro Order ".$Order_id;
$headers = 'From: "SohoRepro" <noreply@new-sohorepro.com>' . "\r\n";
$headers .= 'MIME-Version: 1.0' . "\n";
$headers .= 'Content-Type: text/html; charset=utf-8\r\n'."X-Mailer: PHP";
$headers .= 'Content-Transfer-Encoding: 8bit\r\n\r\n';
//$to = $to['email_id'];
//echo $to, $subject, $message, $headers;
$result = mail($to, $subject, $final_html, $headers);
}
//mail($user_mail, $subject, $message, $headers);
//mail($customer_email, $subject, $message, $headers);
if($result){
    echo  $order_id_ret;
}  else {
    echo  '0';
}

