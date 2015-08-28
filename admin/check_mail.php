<?php
include './config.php';;
$comp_id = '2';
$mail_id = getActiveEmail();
$customer_email = array('email_id' => CompanyMail($comp_id));
array_push($mail_id, $customer_email);

foreach ($mail_id as $mails_sent) {
    $pre_filt[] = $mails_sent['email_id'];
}

$final_list = array_unique($pre_filt);


echo '<pre>';
print_r($final_list);
echo '</pre>';