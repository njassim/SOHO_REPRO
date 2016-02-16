<?php

include './admin/config.php';

include './admin/mail_template.php';


if (isset($_REQUEST['new_company_add']) == '1') {
    extract($_POST);
    $comp_name_exist = checkcomp($reg_compname);
    if (count($comp_name_exist) > 0) {
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
        $message .='<td height="25" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;">Dear ' . $reg_contactname . ',</br></td>';
        $message .='</tr>';
        $message .='<tr>';
        $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">';
        $message .='<table>';
        $message .='<tr>';
        $message .='<td>You have entered company name <b>'.$reg_compname.'</b> is already exist please try another name.</td>';
        $message .='</tr>';
        $message .='</table>';
        $message .='</td>';
        $message .='</tr>';
        $message .='<tr>';
        $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444; padding-top:10px;">Thanks';
        $message .='</td></tr><tr>';
        $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">SohoRepro';
        $message .='</td></tr></table></td></tr></table></td>';      
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

        $subject = 'Company name '.$reg_compname.' is already exist - SohoRepro';
        $headers = 'From: "SohoRepro" <noreply@new-sohorepro.com>' . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        $mail_id = $reg_contactmail;
        $result_mail = mail($mail_id, $subject, $message, $headers);
        if ($result_mail) {
           header("Location:success.php");
        }
    } else {
        move_uploaded_file($_FILES["file"]["tmp_name"], "tax_form/" . $_FILES["file"]["name"]);
        $tax_file_name = $_FILES["file"]["name"];
        $sql = "INSERT INTO sohorepro_company SET 
             comp_contact_name = '" . mysql_real_escape_string($reg_contactname) . "',
             comp_contact_email = '" . mysql_real_escape_string($reg_contactmail) . "',
             comp_name = '" . mysql_real_escape_string($reg_compname) . "',   
             comp_contact_phone = '" . mysql_real_escape_string($reg_contphone1) . "',
             comp_contact_fax   = '". mysql_real_escape_string($reg_busifax) ."',
             comp_business_address1 = '" . mysql_real_escape_string($address1) . "',
             comp_business_address2 = '" . mysql_real_escape_string($address2) . "',
             comp_business_address3 = '" . mysql_real_escape_string($address3) . "',
             comp_room = '" . mysql_real_escape_string($reg_busiroom) . "',
             comp_suite = '" . mysql_real_escape_string($reg_busisuite) . "',
             comp_floor = '" . mysql_real_escape_string($reg_busifloor) . "',
             comp_city = '" . mysql_real_escape_string($reg_busicity) . "',
             comp_state = '" . mysql_real_escape_string($state) . "',
             comp_zipcode = '" . mysql_real_escape_string($reg_busizip) . "',
             comp_zipcode_ext   =   '" . mysql_real_escape_string($reg_busizip_ext) . "',    
             comp_phone1 = '" . mysql_real_escape_string($reg_phone1) . "',
             comp_phone2 = '" . mysql_real_escape_string($reg_phone2) . "',
             comp_phone3 = '" . mysql_real_escape_string($reg_phone3) . "',
             comp_phone4 = '" . mysql_real_escape_string($reg_phone4) . "',
             tax_form_resale = '" . mysql_real_escape_string($tax_file_name) . "',   
             tax_exe  = '" . mysql_real_escape_string($reg_tax) . "',
             cus_type  = '1' ";
        $result = mysql_query($sql);        

        //Insert the Primari Billing address for New Company Start

        $comp_id = mysql_insert_id();
        $shipp_state_id = StateId($state);
        $shipp_sql = "INSERT INTO sohorepro_address SET 
             comp_id = '" . $comp_id . "',
             company_name = '" . mysql_real_escape_string($reg_compname) . "',
             contact_name = '" . mysql_real_escape_string($reg_contactname) . "', 
             address_1 = '" . mysql_real_escape_string($address1) . "',
             address_2 = '" . mysql_real_escape_string($address2) . "',
             suite = '" . mysql_real_escape_string($reg_busiroom) ."',            
             city = '" . mysql_real_escape_string($reg_busicity) . "',
             state = '" . mysql_real_escape_string($shipp_state_id) . "',
             zip = '" . mysql_real_escape_string($reg_busizip) . "',
             zip_ext = '". mysql_real_escape_string($reg_busizip_ext) ."',
             phone = '" . mysql_real_escape_string($reg_contphone1) . "',
             attention_to = '" . mysql_real_escape_string($reg_contactname) . "',
             type = '1',
             prop = '0'";
        mysql_query($shipp_sql);        

        //Insert the Primari Billing address for New Company End



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
        $message .='<td height="25" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;">Dear ' . $reg_contactname . ',</br></td>';
        $message .='</tr>';
        $message .='<tr>';
        $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">';
        $message .='<table>';
        $message .='<tr>';
        $message .='<td>Thank you for your request, your application is under review. You will be contacted by a representative after your application has been approved.</td>';
        $message .='</tr>';
        $message .='</table>';
        $message .='</td>';
        $message .='</tr>';
        $message .='<tr>';
        $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444; padding-top:10px;">Thanks</td>';
        $message .='</tr>';
        $message .='<tr>';
        $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">SohoRepro</td>';
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

        $subject = 'New Account Created - SohoRepro';
        $headers = 'From: "SohoRepro" <no-reply@sohorepro.com>' . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        $mail_id = $reg_contactmail;
        //$mail_id = 'n.mohamedjassim@gmail.com';
        $result_mail = mail($mail_id, $subject, $message, $headers);
        $admin_alert = AdminAlert($reg_compname,$reg_contactname);

        //echo $admin_alert;

        if ($result_mail) {
           header("Location:success.php");
        }

    }

}



