<?php
include './config.php';
//$comp_id = '17';
//$customer_info = getCustomeInfo($comp_id);   
//$customer_info[0]['comp_name'];


//    $message = '<html>';
//    $message .='<head>';
//    $message .='<title></title>';
//    $message .='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
//    $message .='</head>';
//    $message .='<body>';
//    $message .='<table width="550" border="0" cellspacing="0" cellpadding="0">';
//    $message .='<tr bgcolor="#ff7e00">';
//    $message .='<td width="10" height="10" align="left" valign="top"></td>';
//    $message .='<td height="10" align="left" valign="top"></td>';
//    $message .='<td width="10" height="10" align="left" valign="top"></td>';
//    $message .='</tr>';
//    $message .='<tr>';
//    $message .='<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
//    $message .='<td align="left" valign="top">';
//    $message .='<table width="530" border="0" cellspacing="0" cellpadding="0">';
//    $message .='<tr>';
//    $message .='<td width="20" height="20" align="left" valign="top"></td>';
//    $message .='<td height="20" align="left" valign="top"></td>';
//    $message .='<td width="20" height="20" align="left" valign="top"></td>';
//    $message .='</tr>';
//    $message .='<tr>';
//    $message .='<td width="20" align="left" valign="top"></td>';
//    $message .='<td align="left" valign="top">';
//    $message .='<table width="490" border="0" cellspacing="0" cellpadding="0">';
//    $message .='<tr>';
//    $message .='<td width="100" align="left" valign="top"><img src="http://supply.sohorepro.com/store_files/soho_logo.jpg" width="126" height="115" alt=""/></td>';
//    $message .='<td width="40" align="left" valign="top"></td>';
//    $message .='<td width="350" align="left" valign="top">';
//    $message .='<table width="350" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';
//    $message .='<tr>';
//    $message .='<td height="25" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;">Dear ' . $customer_info[0]['comp_name'] . ',</br></td>';
//    $message .='</tr>';
//    $message .='<tr>';
//    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">';
//    $message .='<table>';
//    $message .='<tr>';
//    $message .='<td>Please Add the users in your account Use the below link</td>';
//    $message .='</tr>';
//    $message .='<tr>';
//    $message .='<td><a href="http://supply.sohorepro.com/existing_customer.php" target="_blank">http://supply.sohorepro.com/existing_customer.php</a></td>';
//    $message .='</tr>';
//    $message .='</table>';
//    $message .='</td>';
//    $message .='</tr>';
//    $message .='<tr>';
//    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444; padding-top:10px;">Thanks</td>';
//    $message .='</tr>';
//    $message .='<tr>';
//    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">The SohoRepro Team</td>';
//    $message .='</tr>';
//    $message .='</table>';
//    $message .='</td>';
//    $message .='</tr>';
//    $message .='</table>';
//    $message .='</td>';
//    $message .='<td width="20" align="left" valign="top"></td>';
//    $message .='</tr>';
//    $message .='<tr>';
//    $message .='<td height="20" align="left" valign="top"></td>';
//    $message .='<td height="20" align="left" valign="top"></td>';
//    $message .='<td height="20" align="left" valign="top"></td>';
//    $message .='</tr>';
//    $message .='</table>';
//    $message .='</td>';
//    $message .='<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
//    $message .='</tr>';
//    $message .='<tr bgcolor="#ff7e00">';
//    $message .='<td width="10" height="10" align="left" valign="top"></td>';
//    $message .='<td height="10" align="left" valign="top"></td>';
//    $message .='<td width="10" height="10" align="left" valign="top"></td>';
//    $message .='</tr>';
//    $message .='</table>';
//    $message .='</body>';
//    $message .='</html>';
//    
//    
//    $subject = 'Add new user in your account - SohoRepro';
//    $headers = 'From: "SohoRepro" <no-reply@sohorepro.com>' . "\r\n";
//    $headers .= "MIME-Version: 1.0" . "\r\n";
//    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n"; 
//    $mail_id = 'n.mohamedjassim@gmail.com';
//    $result = mail($mail_id, $subject, $message, $headers);
//    if($result == TRUE){
//        echo 'Mail Sent';
//    }  else {
//        echo 'Mail Not sent';
//}



//$message ='<html>';
//$message .='<head>';
//$message .='<title></title>';
//$message .='<style type="text/css">';
//$message .='div, p, a, li, td { -webkit-text-size-adjust:none; }';
//$message .='table {border-collapse: collapse;}';
//$message .='</style>';
//$message .='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
//$message .='</head>';
//$message .='<body>';
//$message .='<div style="width: 530px;border: 9px solid #ff7e00;margin: 5px;float: left">';
//$message .='<div style="float: left;padding: 10px 5px 10px 10px;">';
//$message .='<img src="http://supply.sohorepro.com/store_files/soho_logo.jpg" width="126" height="115" alt=""/>';
//$message .='</div>';
//$message .='<div style="float: right;padding: 16px 0px 0px 0px;width: 70%;">';
//$message .='<span style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;width: 100%;float: left;margin-bottom: 5px;">Dear Admin,</span>';
//$message .='<span style="width: 100%;float: left;margin-bottom: 5px;">Company Name : '.$reg_compname.'</span>';
//$message .='<span style="width: 100%;float: left;margin-bottom: 10px;">Contact Name : '.$reg_contactname.'</span>';
//$message .='<span style="width: 100%;float: left;margin-bottom: 5px;"><a href="http://supply.sohorepro.com/admin/new_accounts.php" target="_blank">http://supply.sohorepro.com/admin/new_accounts.php</a></span>';
//$message .='</div>';
//$message .='</div>';
//$message .='</body>';
//$message .='</html>';
//    
//echo $message;
 
$Order_Id = $_SESSION['final_ord_id'];


$sql_order_id_mail      = mysql_query("SELECT id,order_id,created_date,order_number,customer_name,customer_company,deleivery_date,order_comment FROM sohorepro_order_master WHERE id = '".$Order_Id."' ORDER BY id DESC LIMIT 1");
$object                 = mysql_fetch_assoc($sql_order_id_mail);
$user_mail_id_txt       = UserMail($object['customer_name']);
$user_mail              = array('email_id' => UserMail($object['customer_name']));
$user_name              = UserName($object['customer_name']);
$company_name           = companyName($object['customer_company']);

$phone_1                = companyphone($object['customer_company']);
$phone                  = CompanyPhoneNumber($user_mail_id_txt);


$billing_address        = BillingAddressShippId($object['customer_company']);
$company_bill_address   = getCustomeInfo($object['customer_company']);
$shipp_address          = CompanyAddressMail($billing_address);
$prop                   = PropTest($shipp_add_id);
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
$temp_times =  date("m-d-Y h:iA", $datew->format('U'));
//$Date = date("m/d/Y", strtotime($object['created_date'])). ' ' .date("h:iA",strtotime("-180 minutes",strtotime($temp_times)));
$Date                   = date('m-d-Y h:i A', time());                            
$view_orders            = viewOrders($id);
$pick_up                = $view_orders[0]['shipping_add_id'];
$mail_id                = getActiveEmail();
$customer_email         = array('email_id' => CompanyMail($comp_id));
array_push($mail_id, $user_mail, $customer_email);
$comment                = 'Comment :';
$address_3              = ($shipp_address['address_3'] != '') ? $shipp_address['address_3'].'<br>' : '';
$billing_address_1      = ($company_bill_address[0]['comp_business_address1'] != '') ? $company_bill_address[0]['comp_business_address1'].'<br>' : '';
$billing_address_2      = ($company_bill_address[0]['comp_business_address2'] != '') ? $company_bill_address[0]['comp_business_address2'].'<br>' : '';
$billing_address_3      = ($company_bill_address[0]['comp_business_address3'] != '') ? $company_bill_address[0]['comp_business_address3'].'<br>' : '';
//$mail = new PHPMailer();

$message  ='<html>';
$message .='<head>';
$message .='<title></title>';
$message .='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
$message .='<style type="text/css">';
$message .='body {margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;font-family:Arial, sans-serif;font-size:14px;}';
$message .='div, p, a, li, td { -webkit-text-size-adjust:none; }';  
$message .='.padd-fix td{padding:5px 0px;}';
$message .='</style>';
$message .='<meta content="text/html;charset=UTF-8" http-equiv="Content-Type">';
$message .='</head>';
$message .='<body>';
$message .= '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
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
$message .= '<td align="left" valign="top"><table width="740" border="0" cellspacing="0" class="padd-fix"  cellpadding="0">';
$message .= '<tr>';
$message .= '<td>Your Soho Reprographics order has been received and will be processed promptly.</br></br></td>';
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
$message .= '<td><span style="font-weight:bold;">Billing Address: </span></td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td style="padding-bottom:7px;">'.$shipp_address['company_name'].'<br>'.$shipp_address['address_1'].'<br>'.$shipp_address['address_2'].'<br>'.$address_3.$shipp_address['city'].',&nbsp;'.StateName($shipp_address['state']).'&nbsp;'.$shipp_address['zip'].'</td>';
$message .= '</tr>';
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
$message .= '<td style="padding-bottom:7px;">'.$company_bill_address[0]['comp_name'].'<br>'.$billing_address_1.$billing_address_2.$billing_address_3.$company_bill_address[0]['comp_city'].',&nbsp;'.$company_bill_address[0]['comp_state'].'&nbsp;'.$company_bill_address[0]['comp_zipcode'].'</td>';
$message .= '</tr>';

$message .= '<tr height="25px">';
$message .= '<td><span style="font-weight:bold;">Multiple Shipping Addresses: </span></td>';
$message .= '</tr>';
$multi      = MultiShippingAddress($Order_Id);
$pick_up_multi    =   Pickup();
foreach ($multi as $multi_shipp){
$address_multi_pre    = SelectIdAddress($multi_shipp['shipping_id']);
$address_multi_1    =  ($address_multi_pre[0]['address_1'] != '')  ? $address_multi_pre[0]['address_1'].'<br>' : '';
$address_multi_2    =  ($address_multi_pre[0]['address_2'] != '')  ? $address_multi_pre[0]['address_2'].'<br>' : '';
$address_multi_3    =  ($address_multi_pre[0]['address_3'] != '')  ? $address_multi_pre[0]['address_3'].'<br>' : '';
$check_item_id      =   explode(",", $multi_shipp['item_id']);   
$items_tag          =   ($check_item_id[1] != '') ? '<span style="font-weight:bold;">Items&nbsp;:&nbsp;'.$multi_shipp['item_id'].'<br>' : '<span style="font-weight:bold;">Item&nbsp;:&nbsp;'.$multi_shipp['item_id'].'<br>';
$address_for_items_pre[] = ($multi_shipp['shipping_id'] != 'P') ? '<div style="float:left;width:100%;">'.$items_tag.'</span><span style="font-weight:bold;">Shipping Address: </span><br>'.$address_multi_pre[0]['company_name'].'<br>'.$address_multi_1.$address_multi_2.$address_multi_3.$address_multi_pre[0]['city'].',&nbsp;'.StateName($address_multi_pre[0]['state']).'&nbsp;'.$address_multi_pre[0]['zip'].'<br><br><span style="font-weight:bold;">Delivery Date :</span></div><div style="float:left;width:100%;">'.$deleivery_date.'</div>' : '<div style="float:left;width:100%;">'.$items_tag.'</span><span style="font-weight:bold;">Pickup Address: </span><br><div style="width: 100%;float: left;margin-bottom: 30px;">'.$pick_up_multi.'</div><span style="font-weight:bold;">Delivery Date :</span></div><div style="float:left;width:100%;">'.$deleivery_date.'</div>';
    
}
$message .= '<tr><td width="100%">';
$message .= '<table border="0">';
for ($m = 0; $m<count($address_for_items_pre); $m+=3)
{
    $message.= '<tr>
                <td style="margin-right:10px;" valign="top" width="33%" align="left">'.$address_for_items_pre[$m].'</td>
                <td style="margin-right:10px;" valign="top" width="33%" align="left">'.$address_for_items_pre[$m+1].'</td>
                <td style="margin-right:10px;" valign="top" width="33%" align="left">'.$address_for_items_pre[$m+2].'</td>
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
    $super_id           = getsuper($prod_id);
    $cat_id             = getcat($prod_id);
    $sub_id             = getsub($prod_id);
    $super_name         = (getsuperN($super_id) != '') ? getsuperN($super_id) : '';        
    $cat_name_pre       = (getcatN($cat_id) != '') ? getcatN($cat_id) : '';
    $cat_name           = ($cat_name_pre != '') ? '>>'.$cat_name_pre : $cat_name_pre ;        
    $sub_name_pre       = (getsubN($sub_id) != '') ? getsubN($sub_id):'';
    $sub_name           = ($sub_name != '')  ? '>>'.$sub_name_pre : $sub_name_pre;
$message .= '<tr>';
$message .= '<td width="40" align="left" valign="middle" bgcolor="'.$rowColor1.'" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-left:20px;">'.$i.'</td>';
$message .= '<td width="400" align="center" valign="middle" bgcolor="'.$rowColor.'" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">'.getorderProd($prod_id).'<div>';
$message .= '<span style="font-size: 11px;color: #2a9be3;">'.$super_name.$cat_name.$sub_name.'</span></div></td>';
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
$message .= '<td colspan="2" rowspan="3" bgcolor="#eeeeee" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;">'.$comment.'</span><br>'.$order_comm.'</td>';
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
$message .= '<td height="20" align="left" valign="top">*Delivery charges to be applied as necessary</td>';
$message .= '<td height="20" align="left" valign="top"></td>';
$message .= '</tr>';
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


//foreach ($mail_id as $mails_sent)
//{
//    $pre_filt[] = $mails_sent['email_id'];
//}
//
//$final_list = array_unique($pre_filt);
//
//foreach ($final_list as $to){
//$subject  = "Order Changed by Admin for Job:".$Order_id;
//$headers  = 'From: "SohoRepro" <no-reply@sohorepro.com>' . "\r\n";
//$headers .= 'MIME-Version: 1.0' . "\n";
//$headers .= 'Content-Type: text/html; charset=utf-8\r\n'."X-Mailer: PHP";
//$headers .= 'Content-Transfer-Encoding: 8bit\r\n\r\n';
////$to       = $to['email_id'];
////echo $to, $subject, $message, $headers;
//$result = mail($to, $subject, $message, $headers);
//}

$final_html = $message;

echo $primary_mail_var = $final_html;

//$myfile = fopen("./mail_inv.html", "w") or die("Unable to open file!");
//fwrite($myfile, $message);
//fclose($myfile);

//$url  = 'http://cipldev.com/supply.sohorepro.com/admin/mail_inv.html';
//$path = 'E:\mail_order_template\mail_inv.html';
//
////file_put_contents('E:/mail_order_template/mail_inv.html', file_get_contents('http://cipldev.com/supply.sohorepro.com/admin/mail_inv.html'));
//
//file_put_contents($path, file_get_contents($url));

//
//$rd = fopen("http://cipldev.com/supply.sohorepro.com/admin/mail_inv.html", 'r');
//$wt = fopen("E:/mail_order_template/mail_inv.html", "w");
//// read a line from the url (8192 is a standard chunk size)
//while( FALSE !== ( $ln = fread( $rd, 8192 ) ) )
//{
//    // write it locally
//    fwrite( $wt, $ln );
//    // rinse, repeat until file is done
//}
//fclose( $wt ); // close the local file.
//fclose( $rd ); // close the remote stream
//
//
//$students = Array('S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'S7', 'S8', 'S9', 'S10');
//$html = '<table border="1">';
//for ($i = 0; $i<count($students); $i+=3)
//{
//    $html.= '<tr>
//                <td>'.$students[$i].'</td>
//                <td>'.$students[$i+1].'</td>
//                <td>'.$students[$i+2].'</td>
//            </tr>';
//    $html.= '<tr><td>&nbsp;</td></tr>';
//}
//$html.= '</table>';
//echo $html;



    ?>
 
    