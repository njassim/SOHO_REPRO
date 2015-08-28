<?php
include './include/class.phpmailer.php';
include './db_connection.php';

function mail_exist($mail)
{
    $select_mail = "SELECT * FROM sohorepro_users WHERE email = '".$mail."' AND status = '1'";
    $mail        = mysql_query($select_mail);
    $object      = mysql_fetch_assoc($mail);
    $mail_id     = $object['email']; 
    return $mail_id;
}

function mail_exist_ap($mail)
{
    $select_mail = "SELECT * FROM sohorepro_customers WHERE cus_email = '".$mail."' AND cus_status = '1'";
    $mail        = mysql_query($select_mail);
    $object      = mysql_fetch_assoc($mail);
    $mail_id     = $object['cus_email']; 
    return $mail_id;
}

function Crederntials($mail_id) {
    $select_details  = "SELECT * FROM sohorepro_users WHERE email = '$mail_id'";
    $details            = mysql_query($select_details);
    while ($object = mysql_fetch_assoc($details)):
        $value[] = $object;
    endwhile;
    return $value;
}

function CrederntialsAP($mail_id) {
    $select_details  = "SELECT * FROM sohorepro_customers WHERE cus_email = '$mail_id'";
    $details            = mysql_query($select_details);
    while ($object = mysql_fetch_assoc($details)):
        $value[] = $object;
    endwhile;
    return $value;
}


function forgot_mail_ap($mail_id)
{
    $details    = CrederntialsAP($mail_id);
    $user_name  = $details[0]['cus_email'];
    $pass       = $details[0]['cus_pass'];
    $type       = 'A/P User';
    
    $message  ='<html>';
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
    $message .='<td width="100" align="left" valign="top"><img src="http://cipldev.com/soho-repro/supply.sohorepro.com/store_files/soho_logo.jpg" width="126" height="115" alt=""/></td>';
    $message .='<td width="40" align="left" valign="top"></td>';
    $message .='<td width="350" align="left" valign="top">';
    $message .='<table width="350" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';
    $message .='<tr>';
    $message .='<td height="25" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;">Dear '.$type.',</br></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">';
    $message .='<table>';
    $message .='<tr>';
    $message .='<td>Username : </td>';
    $message .='<td><span style="font-family:Arial, Helvetica, sans-serif;font-weight:bold;">'.$user_name.'</span></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td>Password :</td>';
    $message .='<td><span style="font-family:Arial, Helvetica, sans-serif;font-weight:bold;">'.$pass.'</span></br></td>';
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
    $final_html = html_entity_decode($message);
        
    $subject = 'SohoRepro - Login credentials';
    $headers = 'From: "SohoRepro" <noreply@new-sohorepro.com>' . "\r\n";
    // Always set content-type when sending HTML email
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";    
    $result = mail($mail_id, $subject, $final_html, $headers);
    
    if($result){
        return '1';
    }  else {
    return  '0';
    }
    
}


function forgot_mail($mail_id)
{
    $details    = Crederntials($mail_id);
    $user_name  = $details[0]['user_name'];
    $pass       = base64_decode($details[0]['password']);
    $type       = ($details[0]['type'] == '2') ? 'Staff User' : 'User';
    
    $message  ='<html>';
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
    $message .='<td width="100" align="left" valign="top"><img src="http://cipldev.com/soho-repro/supply.sohorepro.com/store_files/soho_logo.jpg" width="126" height="115" alt=""/></td>';
    $message .='<td width="40" align="left" valign="top"></td>';
    $message .='<td width="350" align="left" valign="top">';
    $message .='<table width="350" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';
    $message .='<tr>';
    $message .='<td height="25" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;">Dear '.$type.',</br></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">';
    $message .='<table>';
    $message .='<tr>';
    $message .='<td>Username : </td>';
    $message .='<td><span style="font-family:Arial, Helvetica, sans-serif;font-weight:bold;">'.$user_name.'</span></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td>Password :</td>';
    $message .='<td><span style="font-family:Arial, Helvetica, sans-serif;font-weight:bold;">'.$pass.'</span></br></td>';
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
    $final_html = html_entity_decode($message);
        
    $subject = 'SohoRepro - Login credentials';
    $headers = 'From: "SohoRepro" <noreply@new-sohorepro.com>' . "\r\n";
    // Always set content-type when sending HTML email
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";    
    $result = mail($mail_id, $subject, $final_html, $headers);
    
    if($result){
        return '1';
    }  else {
    return  '0';
    }
    
}



function ExtraProductsInOrder($Order_Id,$shipp_add_id,$short_msg)
{       
        $sql_order_id_mail      = mysql_query("SELECT id,order_id,created_date,order_number,customer_name,customer_company,deleivery_date,order_comment FROM sohorepro_order_master WHERE id = '".$Order_Id."' ORDER BY id DESC LIMIT 1");
        $object                 = mysql_fetch_assoc($sql_order_id_mail);
        $user_mail_id_txt       = UserMail($object['customer_name']);
        $user_mail              = array('email_id' => UserMail($object['customer_name']));
        $user_name              = UserName($object['customer_name']);
        $company_name           = companyName($object['customer_company']);
        $phone                  = companyphone($object['customer_company']);
        $billing_address        = BillingAddressShippId($object['customer_company']);
        $shipp_address          = CompanyAddressMail($billing_address);
        $prop                   = PropTest($shipping_id);
        $id                     = $Order_Id;
        $Order_id               = $object['order_id'];
        $Order_number           = $object['order_number'];
        $deleivery_date         = $object['deleivery_date'];
        $comp_id                = $object['customer_company'];
        $order_comm             = $object['order_comment'];
        //$current_time           = date("Y-m-d h:i:s");
        $current_time = $object['created_date'];
        $datew = new DateTime($current_time, new DateTimeZone('America/New_York'));
        date_default_timezone_set('America/New_York');
        $temp_times =  date("Y-m-d h:iA", $datew->format('U'));        
        //$Date = date("m-d-Y", strtotime(date('Y-m-d h:i:s', time()))). ' ' .date("h:iA",strtotime("-0 minutes",strtotime($temp_times)));
        $Date                   = date('Y-m-d h:i A', time());                            
        $view_orders            = viewOrders($id);
        $pick_up                = $view_orders[0]['shipping_add_id'];
        $mail_id                = getActiveEmail();
        $returnValue            = html_entity_decode('Your Soho Repro graphics order has been received and will be processed promptly.', ENT_COMPAT, 'ISO-8859-1');
        $customer_email         = array('email_id' => CompanyMail($comp_id));
        array_push($mail_id, $user_mail, $customer_email);
        $comment                = 'Comment :';
        $address_3 = ($shipp_address['address_3'] != '') ? $shipp_address['address_3'].'<br>' : '';
        $mail = new PHPMailer();

        $message  ='<html>';
        $message .='<head>';
        $message .='<title></title>';
        $message .='<meta content="text/html;charset=iso-8859-1" http-equiv="Content-Type">';
        $message .='</head>';
        $message .='<body>';
        $message .= '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
        $message .= '<table width="780" border="0" cellspacing="0" cellpadding="0" class="padd">';
        $message .= '<tr><td>'.$short_msg.'</td></tr>';
        $message .= '</table>';
        $message .= '<table width="780" border="0" cellspacing="0" cellpadding="0" class="padd">';
        $message .= '<tr bgcolor="#ff7e00">';
        $message .= '<td width="10" height="10" align="left" valign="top"></td>';
        $message .= '<td height="10" align="left" valign="top"></td>';
        $message .= '<td width="10" height="10" align="left" valign="top"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
        $message .= '<td align="left" valign="top"><table width="760" border="0" cellspacing="0" cellpadding="0">';
        $message .= '<tr>';
        $message .= '<td width="20" height="20" align="left" valign="top"></td>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= '<td width="20" height="20" align="left" valign="top"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td width="20" align="left" valign="top"></td>';
        $message .= '<td align="left" valign="top"><table width="740" border="0" cellspacing="0" cellpadding="0">';
        $message .= '<tr>';
        $message .= '<td>'.$returnValue.'</br></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td>&nbsp;</td>';
        $message .= '</tr>';
        $message .= '<tr height="30px">';
        $message .= '<td><span style="font-weight:bold;">Customer Reference :</span> ' . $Order_id . '</td>';
        $message .= '</tr>';
        $message .= '<tr height="25px">';
        $message .= '<td><span style="font-weight:bold;">Date :</span> '.$Date.'</td>';
        $message .= '</tr>';
        $message .= '<tr height="25px">';
        $message .= '<td><span style="font-weight:bold;">Name :</span> '.$user_name.'</td>';
        $message .= '</tr>';
        $message .= '<tr height="25px">';
        $message .= '<td><span style="font-weight:bold;">Company :</span> ' .$company_name. '</td>';
        $message .= '</tr>';
        $message .= '<tr height="25px">';
        $message .= '<td><span style="font-weight:bold;">Email :</span> ' .$user_mail_id_txt. '</td>';
        $message .= '</tr>';
        $message .= '<tr height="25px">';
        $message .= '<td><span style="font-weight:bold;">Phone :</span> ' .$phone. '</td>';
        $message .= '</tr>';
        if($pick_up == 'P'){
        $message .= '<tr height="30px">';
        $message .= '<td><span style="font-weight:bold;">Pickup Address: </span></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td style="padding-bottom:7px;">Soho Reprographics<br>381 Broome Street<br>New York, NY 10013</td>';
        $message .= '</tr>';
        }else{
        $message .= '<tr height="30px">';
        $message .= '<td><span style="font-weight:bold;">Billing Address: </span></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td style="padding-bottom:7px;">'.$shipp_address['company_name'].'<br>'.$shipp_address['address_1'].'<br>'.$shipp_address['address_2'].'<br>'.$address_3.$shipp_address['city'].',&nbsp;'.StateName($shipp_address['state']).'&nbsp;'.$shipp_address['zip'].'</td>';
        $message .= '</tr>';

        $message .= '<tr height="25px">';
        $message .= '<td><span style="font-weight:bold;">Multiple Shipping Addresses: </span></td>';
        $message .= '</tr>';
        $multi              = MultiShippingAddress($Order_Id);
        $pick_up_multi      =   Pickup();
        foreach ($multi as $multi_shipp){
        $address_multi_pre    = SelectIdAddress($multi_shipp['shipping_id']);
        $address_multi_1    =  ($address_multi_pre[0]['address_1'] != '')  ? $address_multi_pre[0]['address_1'].'<br>' : '';
        $address_multi_2    =  ($address_multi_pre[0]['address_2'] != '')  ? $address_multi_pre[0]['address_2'].'<br>' : '';
        $address_multi_3    =  ($address_multi_pre[0]['address_3'] != '')  ? $address_multi_pre[0]['address_3'].'<br>' : '';
        $check_item_id      =   explode(",", $multi_shipp['item_id']);   
        $items_tag          =  ($check_item_id[1] != '') ? '<span style="font-weight:bold;">Items&nbsp;:&nbsp;'.$multi_shipp['item_id'].'<br>' : '<span style="font-weight:bold;">Item&nbsp;:&nbsp;'.$multi_shipp['item_id'].'<br>';
        $address_for_items_pre[] = ($multi_shipp['shipping_id'] != 'P') ? $items_tag.'</span><span style="font-weight:bold;">Shipping Address: </span><br>'.$address_multi_pre[0]['company_name'].'<br>'.$address_multi_1.$address_multi_2.$address_multi_pre[0]['city'].',&nbsp;'.StateName($address_multi_pre[0]['state']).'&nbsp;'.$address_multi_pre[0]['zip'].'<br><br><span style="font-weight:bold;">Delivery Date :</span>'.$deleivery_date : $items_tag.'</span><span style="font-weight:bold;">Pickup Address: </span><br>'.$pick_up_multi.'<br><br><br><span style="font-weight:bold;">Delivery Date :</span>'.$deleivery_date;
        }
        $message .= '<tr><td>';
        $message .= '<table align="left">';
        for ($m = 0; $m<count($address_for_items_pre); $m+=3)
        {
        $message.= '<tr>
                <td>'.$address_for_items_pre[$m].'</td>
                <td>'.$address_for_items_pre[$m+1].'</td>
                <td>'.$address_for_items_pre[$m+2].'</td>
            </tr>';
        $message.= '<tr><td>&nbsp;</td></tr>';
        }
        $message .= '</table>';
        $message .= '</td></tr>';

        }

        $message .= '</table></td>';
        $message .= '<td height="25" width="20" align="left" valign="top"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td width="20" align="left" valign="top"></td>';
        $message .= '<td align="left" valign="top">';
        $message .= '<table width="740" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';
        $message .= '<tr style="color:#fff; text-transform:uppercase;">';
        $message .= '<td width="40" align="center" valign="middle" bgcolor="#f68210" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">Item</td>';
        $message .= '<td width="400" align="center" valign="middle" bgcolor="#f68210" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">Description</td>';
        $message .= '<td width="80" align="center" valign="middle" bgcolor="#f68210" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">Quantity</td>';
        $message .= '<td width="100" align="center" valign="middle" bgcolor="#f68210" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">Unit Price</td>';
        $message .= '<td width="110" align="center" valign="middle" bgcolor="#f68210" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">Total</td>';
        $message .= '</tr>';
        $total = 0;
        $i = 1;
        foreach ($view_orders as $ord) {
        $rowColor   = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
        $rowColor1  = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
        $prod_id    = $ord['product_id'];
        $shipping   = SelectAllAddress($ord['shipping_add_id']);
        $id = $ord['id'];    
        $message .= '<tr>';
        $message .= '<td width="40" align="left" valign="middle" bgcolor="'.$rowColor1.'" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-left:20px;">'.$i.'</td>';
        $message .= '<td width="400" align="center" valign="middle" bgcolor="'.$rowColor.'" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">'.getorderProd($prod_id).'</td>';
        $message .= '<td width="80" align="right" valign="middle" bgcolor="'.$rowColor1.'" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">'.$ord['product_quantity'].'</td>';
        $message .= '<td width="100" align="right" valign="middle" bgcolor="'.$rowColor.'" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">'.'$' . $ord['product_price'].'</td>';
        $message .= '<td width="110" align="right" valign="middle" bgcolor="'.$rowColor1.'" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">'.'$' . number_format(($ord['product_quantity'] * $ord['product_price']), 2, '.','').'</td>';
        $message .= '</tr>';
        $sub_tot = $ord['product_quantity'] * $ord['product_price'];
        $tax_status = getTaxStatusChk($comp_id);
        $tax_value = TaxValue();
        if($tax_status == '1')
        {
        $tax_line = '0';     
        }  else {                    
        $tax_line = $tax_value;  
        }
        $total = $total + $sub_tot;
        $tax         = ($tax_line * ($total/100));
        $i++;
        }
        $message .= '<tr>';
        $message .= '<td colspan="2" rowspan="3" bgcolor="#eeeeee" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;">Comment:</span><br>'.$order_comm.'</td>';
        $message .= '<td colspan="2" align="right" bgcolor="#eeeeee" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;">Subtotal</span></td>';
        $message .= '<td bgcolor="#eeeeee" align="right" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">'.'$' .number_format($total, 2, '.', '').'</td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td colspan="2" align="right" bgcolor="#dfdfdf" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;">Tax</span></td>';
        $message .= '<td bgcolor="#dfdfdf" align="right" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">'.'$' .number_format($tax, 2, '.', '').'</td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td colspan="2" align="right" bgcolor="#eeeeee" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;">Total*</span></td>';
        $message .= '<td bgcolor="#eeeeee" align="right" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">'.'$' .number_format(($total + $tax), 2, '.', '').'</td>';
        $message .= '</tr>';
        $message .= '</table></td>';
        $message .= '<td width="20" align="left" valign="top"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td width="20" height="20" align="left" valign="top"></td>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= '<td width="20" height="20" align="left" valign="top"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= '<td height="20" align="left" valign="top" style="padding-bottom:5px;font-size:12px;">*Delivery charges to be applied as necessary</td>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= ' </tr>';
        $message .= '</table></td>';
        $message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
        $message .= '</tr>';
        $message .= '<tr bgcolor="#ff7e00">';
        $message .= '<td width="10" height="10" align="left" valign="top"></td>';
        $message .= '<td height="10" align="left" valign="top"></td>';
        $message .= '<td width="10" height="10" align="left" valign="top"></td>';
        $message .= ' </tr>';
        $message .= '</table>';
        $message .='</table>';
        $message .='</body>';
        $message .='</html>';
        $final_html = html_entity_decode($message);
        
//        foreach ($mail_id as $to){
//        $subject    = "Soho Reprographic Order Acknowledgement with Extra Products";
//        $headers    = 'From: "SohoRepro" <no-reply@sohorepro.com>' . "\r\n";
//        $headers   .= 'MIME-Version: 1.0' . "\n";
//        $headers   .= 'Content-Type: text/html; charset=utf-8\r\n';
//        $headers   .= 'Content-Transfer-Encoding: 8bit\r\n\r\n';        
//        $to         = $to['email_id'];
//        //echo $to, $subject, $message, $headers;
//        $result = mail($to, $subject, $message, $headers);
//        }
        
        foreach ($mail_id as $mails_sent)
        {
            $pre_filt[] = $mails_sent['email_id'];
        }

        $final_list = array_unique($pre_filt);

//        foreach ($final_list as $to){
//        $subject  = "Order Changed by Admin for Job:".$Order_id;
//        $headers  = 'From: "SohoRepro" <noreply@sohorepro.com>' . "\r\n";
//        $headers .= 'MIME-Version: 1.0' . "\n";
//        $headers .= 'Content-Type: text/html; charset=utf-8\r\n'."X-Mailer: PHP";
//        $headers .= 'Content-Transfer-Encoding: 8bit\r\n\r\n';
//        //$to       = $to['email_id'];
//        //echo $to, $subject, $message, $headers;
//        $result = mail($to, $subject, $final_html, $headers);
//        }
        
        
        $subject  = "Order Changed by Admin for Job:".$Order_id;
        $headers  = 'From: "SohoRepro" <noreply@sohorepro.com>' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\n";
        $headers .= 'Content-Type: text/html; charset=utf-8\r\n'."X-Mailer: PHP";
        $headers .= 'Content-Transfer-Encoding: 8bit\r\n\r\n';
        $to       = "Chief@pillarsupport.com";
        //echo $to, $subject, $message, $headers;
        $result = mail($to, $subject, $final_html, $headers);
        
        
        if($result){
        return '1';
        }  else {
        return  '0';
        }
}



function AdminAlert($reg_compname,$reg_contactname)
{
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
    $message .='<td height="25" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;">Dear Admin,</br></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">';
    $message .='<table>';
    $message .='<tr>';
    $message .='<td>New user has been registered</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td>Company Name : '.$reg_compname.'</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td>Contact Name : '.$reg_contactname.'</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td><a href="http://supply.sohorepro.com/admin/new_accounts.php" target="_blank">http://supply.sohorepro.com/admin/new_accounts.php</a></td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
    $message .='</tr>';    
    $message .='</table>';
    $message .='</td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
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
    $final_html = html_entity_decode($message);

    $mail_id  = getActiveEmail();
    
    echo '<pre>';
    print_r($mail_id);
    echo '</pre>';
   
    foreach ($mail_id as $to){
    $subject = 'New Account Created by '.$reg_compname;
    $headers = 'From: "SohoRepro" <noreply@new-sohorepro.com>' . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $to = $to['email_id'];
    //$mail_id = 'n.mohamedjassim@gmail.com';
    if($reg_compname != ''){
    $result_mail = mail($to, $subject, $final_html, $headers);
    }
    }
    if($result_mail){
        return '1';
    }  else {
        return  '0';
    }
}


function CreateUsrNotiAdmin($reg_compname, $cus_contact_name, $reg_email_id)
{
    $comp_name = getCompName($reg_compname);
    $mail_id  = getActiveEmail();
    $customer_email         = array('email_id' => CompanyMail($reg_compname));
    array_push($mail_id, $customer_email);
    
    $message = '<html>';
    $message .='<head>';
    $message .='<title></title>';
    $message .='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
    $message .='</head>';
    $message .='<body>';
    $message .='<table width="575" border="0" cellspacing="0" cellpadding="0">';
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
    $message .='<td height="25" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;">Dear Admin,</br></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">';
    $message .='<table>';
    $message .='<tr>';
    $message .='<td>New user has been registered by the following company:</td>';
//    $message .='<td>New User has been registered:</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td>Company Name : '.$comp_name.'</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td>Contact Name : '.$cus_contact_name.'</td>';
    $message .='</tr>'; 
    $message .='<tr>';
    $message .='<td>User Mail ID : '.$reg_email_id.'</td>';
    $message .='</tr>'; 
    $message .='</table>';
    $message .='</td>';
    $message .='</tr>';    
    $message .='</table>';
    $message .='</td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
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
    $final_html = html_entity_decode($message);
    
    foreach ($mail_id as $mails_sent)
    {
        $pre_filt[] = $mails_sent['email_id'];
    }

    $final_list = array_unique($pre_filt);
    
    foreach ($final_list as $to){
    $subject = 'New User Registered by '.$comp_name;
    $headers = 'From: "SohoRepro" <noreply@new-sohorepro.com>' . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";    
    //$mail_id = 'n.mohamedjassim@gmail.com';
        if($comp_name != ''){
        $result_mail = mail($to, $subject, $final_html, $headers);
        }
    }
    if($result_mail){
        return '1';
    }  else {
        return  '0';
    }
}



function CreateUsrNotiUser($reg_compname, $cus_contact_name, $reg_email_id, $reg_password)
{
    $comp_name = getCompName($reg_compname);   
    
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
    $message .='<td height="25" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;">Dear '.$cus_contact_name.',</br></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">';
    $message .='<table>';
    $message .='<tr>';
    $message .='<td>Your account has been successfully dreated by '.$comp_name.' </td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td><b>User Credentials :</b></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td>User Name : '.$reg_email_id.'</td>';
    $message .='</tr>'; 
    $message .='<tr>';
    $message .='<td>Password : '.$reg_password.'</td>';
    $message .='</tr>'; 
    $message .='</table>';
    $message .='</td>';
    $message .='</tr>';    
    $message .='</table>';
    $message .='</td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
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
    $final_html = html_entity_decode($message);
    
   
    $subject = 'Account has been created by '.$comp_name;
    $headers = 'From: "SohoRepro" <noreply@new-sohorepro.com>' . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";    
    //$mail_id = 'n.mohamedjassim@gmail.com';
    if($comp_name != ''){
    $result_mail = mail($reg_email_id, $subject, $final_html, $headers);
    }
    if($result_mail){
        return '1';
    }  else {
        return  '0';
    }
}



function GetCredentials($id) {
    $select_users = "SELECT * FROM sohorepro_customers WHERE cus_id = '".$id."'";
    $users_details = mysql_query($select_users);
    while ($object = mysql_fetch_assoc($users_details)):
        $value[] = $object;
    endwhile;
    return $value;
}

function ResendCredentials($customer_id)
{
        $credentials = GetCredentials($customer_id);
    
        $message = '<link href="mail_css.css" media="screen" rel="stylesheet" type="text/css" />';
        $message .= '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
        $message .= '<table width="550" border="0" cellspacing="0" cellpadding="0">';
        $message .= '<tr bgcolor="#ff7e00">';
        $message .= '<td width="10" height="10" align="left" valign="top"></td>';
        $message .= '<td height="10" align="left" valign="top"></td>';
        $message .= '<td width="10" height="10" align="left" valign="top"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
        $message .= '<td align="left" valign="top"><table width="530" border="0" cellspacing="0" cellpadding="0">';
        $message .= '<tr>';
        $message .= '<td width="20" height="20" align="left" valign="top"></td>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= '<td width="20" height="20" align="left" valign="top"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td width="20" align="left" valign="top"></td>';
        $message .= '<td align="left" valign="top"><table width="490" border="0" cellspacing="0" cellpadding="0">';
        $message .= '<tr>';        
        $message .= '<td align="left" valign="top"><table width="200" border="0" cellspacing="0" cellpadding="0">';
        $message .= '<tr>';
        $message .= '</table></td>';
        $message .= '</tr>';
        $message .= '</table></td>';
        $message .= '<td width="20" align="left" valign="top"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td width="20" align="left" valign="top"></td>';
        $message .= '<td align="left" valign="top">';
        $message .= '<table width="490" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';

        $message .="<tr>
        <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;'>Dear ".ucfirst($credentials[0]['cus_fname']." ".$credentials[0]['cus_lname']).",</td>
        </tr>";
        $message .="<tr>
        <td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'> Please note down the login details for your account. <span style='color:#0b7abf; text-decoration:underline;'></span></td>
        </tr>";

        $message .="<tr>
        <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#5f5f5f; font-weight:bold; padding-top:20px;'>User Name : ".($credentials[0]['cus_email'])."</td>
        </tr>";

        $message .="<tr>
        <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#5f5f5f; font-weight:bold; padding-top:20px; padding-bottom:10px;'>Password : ".$credentials[0]['cus_pass']."</td>
        </tr>";

        $message .="<tr>
        <td height='30' align='left' valign='middle' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'><a href='http://".$_SERVER['SERVER_NAME']."/supply.sohorepro.com/index.php' style='color:#0b7abf; text-decoration:underline;' target='_blank'>Click here </a>to login into our SohoRepro System.</td>
        </tr>";

        $message .="<tr><td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444; padding-top:10px;'>Thanks,</td></tr><tr><td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'>The SohoRepro Team</td></tr>";

        $message .= '</table></td>';
        $message .= '<td width="20" align="left" valign="top"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= ' </tr>';
        $message .= '</table></td>';
        $message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
        $message .= '</tr>';
        $message .= '<tr bgcolor="#ff7e00">';
        $message .= '<td width="10" height="10" align="left" valign="top"></td>';
        $message .= '<td height="10" align="left" valign="top"></td>';
        $message .= '<td width="10" height="10" align="left" valign="top"></td>';
        $message .= ' </tr>';
        $message .= '</table>';
        $final_html = html_entity_decode($message);
        
        $subject  = "SohoRepro - Login credentials";
        $headers  = 'From: "SohoRepro" <noreply@new-sohorepro.com>' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\n";
        $headers .= 'Content-Type: text/html; charset=utf-8\r\n';
        $headers .= 'Content-Transfer-Encoding: 8bit\r\n\r\n';
        $to       = $credentials[0]['cus_email'];        
        $result_mail = mail($to, $subject, $final_html, $headers);
        if($result_mail){
        return '1';
        }  else {
        return  '0';
        }
}
?>
