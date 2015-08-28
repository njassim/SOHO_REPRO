<?php
include './config.php';
$Order_Id               = '198';
$shipp_add_id           = '2';
$sql_order_id_mail      = mysql_query("SELECT id,order_id,created_date,order_number,customer_name,customer_company,deleivery_date,order_comment FROM sohorepro_order_master WHERE id = '".$Order_Id."' ORDER BY id DESC LIMIT 1");
$object                 = mysql_fetch_assoc($sql_order_id_mail);
$user_mail              = UserMail($object['customer_name']);
$user_name              = UserName($object['customer_name']);
$company_name           = companyName($object['customer_company']);
$phone                  = companyphone($object['customer_company']);
$shipp_address          = CompanyAddressMail($shipp_add_id);
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
$temp_times =  date("Y-m-d h:iA", $datew->format('U'));
$Date = date("m-d-Y", strtotime($object['created_date'])). ' ' .date("h:iA",strtotime("-180 minutes",strtotime($temp_times)));
//$Date                   = date('m-d-y').' '.$datetime_from;                              
$view_orders            = viewOrders($id);
$pick_up                = $view_orders[0]['shipping_add_id'];
$mail_id                = getActiveEmail();


$user_session_comp      = $_SESSION['sohorepro_companyid'];
$user_session           = $_SESSION['sohorepro_userid'];

$entered_needed_sets = NeededSetsOrdered($user_session_comp, $user_session, $Order_Id);

$message  ='<html>';
$message .='<head>';
$message .='<title></title>';
$message .='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
$message .='<link href="http://supply.sohorepro.com/admin/style/mail_style.css" rel="stylesheet" type="text/css" media="all" />';
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
$message .= '<td align="left" valign="top"><table width="740" border="0" cellspacing="0" cellpadding="0">';
$message .= '<tr >';
$message .= '<td>Your Soho Repro graphics order has been received and will be processed promptly.</br></br></td>';
$message .= '</tr>';
$message .= '<tr height="25px">';
$message .= '<td><span>Date :</span> '.$Date.'</td>';
$message .= '</tr>';
$message .= '<tr height="25px">';
$message .= '<td><span>Name :</span> '.$user_name.'</td>';
$message .= '</tr>';
$message .= '<tr height="25px">';
$message .= '<td><span>Company :</span> ' .$company_name. '</td>';
$message .= '</tr>';
$message .= '<tr height="25px">';
$message .= '<td><span>Email :</span> ' .$user_mail. '</td>';
$message .= '</tr>';
$message .= '<tr height="25px">';
$message .= '<td><span>Phone :</span> ' .$phone. '</td>';
$message .= '</tr>';
if($pick_up == 'P'){
$message .= '<tr height="30px">';
$message .= '<td><span>Pickup Address: </span></td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td >Soho Reprographics<br>381 Broome Street<br>New York, NY 10013</td>';
$message .= '</tr>';
}else{
$message .= '<tr height="30px">';
$message .= '<td><span class="bold">Billing Address: </span></td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td>'.$shipp_address['address_1'].'<br>'.$shipp_address['address_2'].'<br>'.$shipp_address['address_3'].'<br>'.$shipp_address['city'].','.StateName($shipp_address['state']).','.$shipp_address['zip'].'</td>';
$message .= '</tr>';
$message .= '<tr height="25px">';
$message .= '<td><span >Shipping Address: </span></td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td>'.$shipp_address['address_1'].'<br>'.$shipp_address['address_2'].'<br>'.$shipp_address['address_3'].'<br>'.$shipp_address['city'].','.StateName($shipp_address['state']).','.$shipp_address['zip'].'</td>';
$message .= '</tr>';    
}
$message .= '<tr height="30px">';
$message .= '<td><span >Customer Reference :</span> ' . $Order_id . '</td>';
$message .= '</tr>';
$message .= '<tr height="30px">';
$message .= '<td><span>Deleivery Date :</span> ' . $deleivery_date . '</td>';
$message .= '</tr>';
$message .= '</table></td>';
$message .= '<td height="25" width="20" align="left" valign="top"></td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td width="20" align="left" valign="top"></td>';
$message .= '<td align="left" valign="top">';
$message .= '<table width="740" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';
$message .= '<tr>';
$message .= '<td>Item</td>';
$message .= '<td>Description</td>';
$message .= '<td>Quantity</td>';
$message .= '<td>Unit Price</td>';
$message .= '<td>Total</td>';
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
$message .= '<td>'.$i.'</td>';
$message .= '<td>'.getorderProd($prod_id).'</td>';
$message .= '<td>'.$ord['product_quantity'].'</td>';
$message .= '<td>'.'$' . $ord['product_price'].'</td>';
$message .= '<td>'.'$' . ($ord['product_quantity'] * $ord['product_price']).'</td>';
$message .= '</tr>';
$sub_tot = $ord['product_quantity'] * $ord['product_price'];
$tax_status = getTaxStatusChk($comp_id);
if($tax_status == '1')
{
$tax_line = '0';    
}  else {
$tax_line = '8.875';       
}
$total = $total + $sub_tot;
$tax         = ($tax_line * ($total/100));
$i++;
}
$message .= '<tr>';
$message .= '<td colspan="2" rowspan="3"><span>Comment:</span><br>'.$order_comm.'</td>';
$message .= '<td colspan="2" align="right"><span>Subtotal</span></td>';
$message .= '<td>'.'$' .number_format($total, 2, '.', '').'</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td colspan="2" align="right"><span style="font-weight:bold;">Tax</span></td>';
$message .= '<td align="right">'.'$' .number_format($tax, 2, '.', '').'</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td colspan="2" align="right"><span style="font-weight:bold;">Total*</span></td>';
$message .= '<td align="right">'.'$' .number_format(($total + $tax), 2, '.', '').'</td>';
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

$from     = 'noreply@sohorepro.com';


$subject    = "Soho Reprographic Order Acknowledgement with Extra Products";
$headers   .= 'From: "SohoRepro" <no-reply@sohorepro.com>' . "\r\n";
$headers   .= "MIME-Version: 1.0\r\n";
$headers   .= "Content-Type: text/html; charset=ISO-8859-1\r\n";        
$to         = 'jassim.colan@gmail.com';
$result = mail($to, $subject, $message, $headers);

if($result == TRUE){
    echo 'Sent Success';
}  else {
    echo 'Not Sent';
}

echo $user_mail, $subject, $message, $headers;
