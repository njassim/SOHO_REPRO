<?php

include './config.php';

if (isset($_POST['customer_id']) && $_POST['customer_id'] != '') {
    $customer_id = $_POST['customer_id'];
    $customer_info = getCustomeInfo($customer_id);
    $state = StateName($customer_info[0]['comp_state']);
    echo $customer_info[0]['comp_contact_name'] . '~' . $customer_info[0]['comp_contact_email'] .
    '~' . $customer_info[0]['comp_name'] . '~' . $customer_info[0]['comp_contact_phone'] .
    '~' . $customer_info[0]['comp_business_address1'] . '~' . $customer_info[0]['comp_business_address2'] .
    '~' . $customer_info[0]['comp_room'] . ' ' . $customer_info[0]['comp_suite'] . ' ' . $customer_info[0]['comp_floor'] . '~' . $customer_info[0]['comp_city'] .
    '~' . $customer_info[0]['comp_state'] . '~' . $customer_info[0]['comp_zipcode'] .
    '~' . $customer_info[0]['comp_phone1'] . '~' . $customer_info[0]['comp_phone2'] .
    '~' . $customer_info[0]['comp_phone3'] . '~' . $customer_info[0]['comp_phone4'] .
    '~<a href="../tax_form/'.$customer_info[0]['tax_form_resale'].'" target="_blank">' . $customer_info[0]['tax_form_resale'] . '</a>~<a href="../tax_form/'.$customer_info[0]['tax_form_excempt'].'" target="_blank">' . $customer_info[0]['tax_form_excempt'].'</a>~'.$customer_info[0]['comp_contact_fax'] ;
}

if (isset($_POST['invite_user_id']) && $_POST['invite_user_id'] != '') {
    
    $comp_id = $_POST['invite_user_id'];
    $customer_info = getCustomeInfo($comp_id);    

    $message = '<html>';
    $message .='<head>';
    $message .='<title></title>';
    $message .='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
    $message .='</head>';
    $message .='<body>';
    $message .='<table width="550" border="0" cellspacing="0" cellpadding="0">';
    $message .='<tr bgcolor="#ff7e00">';
    $message .='<td width="10" height="10" align="left" valign="top"></td>';
    $message .='<td height="10" align="left" valign="top"></td>';
    $message .='<td width="10" height="10" align="left" valign="top"></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
    $message .='<td align="left" valign="top">';
    $message .='<table width="530" border="0" cellspacing="0" cellpadding="0">';
    $message .='<tr>';
    $message .='<td width="20" height="20" align="left" valign="top"></td>';
    $message .='<td height="20" align="left" valign="top"></td>';
    $message .='<td width="20" height="20" align="left" valign="top"></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td width="20" align="left" valign="top"></td>';
    $message .='<td align="left" valign="top">';
    $message .='<table width="490" border="0" cellspacing="0" cellpadding="0">';
    $message .='<tr>';
    $message .='<td width="100" align="left" valign="top"><img src="http://supply.sohorepro.com/store_files/soho_logo.jpg" width="126" height="115" alt=""/></td>';
    $message .='<td width="40" align="left" valign="top"></td>';
    $message .='<td width="350" align="left" valign="top">';
    $message .='<table width="350" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';
    $message .='<tr>';
    $message .='<td height="25" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;">Dear ' . $customer_info[0]['comp_name'] . ',</br></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">';
    $message .='<table>';
    $message .='<tr>';
    $message .='<td>Please Add the users in your account Use the below link</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td><a href="http://supply.sohorepro.com/existing_customer.php" target="_blank">http://supply.sohorepro.com/existing_customer.php</a></td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444; padding-top:10px;">Thanks</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">The SohoRepro Team</td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
    $message .='<td width="20" align="left" valign="top"></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td height="20" align="left" valign="top"></td>';
    $message .='<td height="20" align="left" valign="top"></td>';
    $message .='<td height="20" align="left" valign="top"></td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
    $message .='<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
    $message .='</tr>';
    $message .='<tr bgcolor="#ff7e00">';
    $message .='<td width="10" height="10" align="left" valign="top"></td>';
    $message .='<td height="10" align="left" valign="top"></td>';
    $message .='<td width="10" height="10" align="left" valign="top"></td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</body>';
    $message .='</html>';
    
    
    $subject = 'Add new user in your account - SohoRepro';
    $headers = 'From: "SohoRepro" <no-reply@sohorepro.com>' . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n"; 
    $mail_id = $customer_info[0]['comp_contact_email'];
    $result = !mail($mail_id, $subject, $message, $headers);
    
    if($result){
        echo '1';
    }  else {
        echo  '0';
    }
}


