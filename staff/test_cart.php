<?php
include './admin/config.php';
include './admin/db_connection.php';

$current_timne = date("Y-m-d h:i:s");
$date = new DateTime($current_timne, new DateTimeZone('America/New_York'));
date_default_timezone_set('America/New_York');
$temp_time1 =  date("Y-m-d h:iA", $date->format('U'));
$datetime_from = date("h:i",strtotime("+240 minutes",strtotime($temp_time1)));


//echo $datetime_from;

$sql_order_id = mysql_query("SELECT order_number FROM sohorepro_order_master ORDER BY id DESC LIMIT 1");
$object_order = mysql_fetch_assoc($sql_order_id);

        if (count($object_order['order_number']) > 0) {
            $order_id = ($object_order['order_number'] + 1);
        } 
        else{
            $order_id = '101';
        }
    
   
        
$user_id          =       $_GET['user_cart_id'];
$company_id       =       $_GET['company_id'];
$referece         =       $_GET['reference']  ;
$deleivery_date   =       $_GET['date'];
$sql = "INSERT INTO sohorepro_order_master SET order_number = '".$order_id."',order_sequence = '".$order_id."', order_id     = '" . $referece . "', customer_company = '".$company_id."', customer_name = '".$user_id."', deleivery_date = '".$deleivery_date."', created_date = now()";
mysql_query($sql);
$order_id_pro = mysql_insert_id();
$product = checkOut($user_id);

if($order_id_pro != ''){
foreach ($product as $pro)
    {
    $product_id       = $pro['product_id'];
    $product_price    = $pro['unit_price'];
    $product_quantity = $pro['quantity'];
    $shipping_id      = $pro['shipping_add_id'];
    $product_name     = mysql_real_escape_string(getProName($product_id));
    $query = "INSERT INTO sohorepro_product_master SET product_id     = '" . $product_id . "', product_price = '" . $product_price . "', product_quantity = '" . $product_quantity . "', product_name = '".$product_name."', order_id = '" .$order_id_pro. "', shipping_add_id ='" .$shipping_id. "' ";
    mysql_query($query);
    } 
}


//Order to Email
$sql_order_id_mail      = mysql_query("SELECT id,order_id,created_date,order_number FROM sohorepro_order_master ORDER BY id DESC LIMIT 1");
$object                 = mysql_fetch_assoc($sql_order_id_mail);
$user_mail              = UserMail($user_id);
$user_name              = UserName($user_id);
$company_name           = companyName($user_id);
$phone                  = companyphone($company_id);
$shipp_address          = CompanyAddressMail($shipping_id);
$prop                   = PropTest($shipping_id);
$id                     = $object['id'];
$Order_id               = $object['order_id'];
$Order_number           = $object['order_number'];
$current_time           = date("Y-m-d h:i:s");
$Date                   = $datetime_from;                            
$view_orders            = viewOrders($id);
$mail_id                = getActiveEmail();
unset($_SESSION['job']);
$sql                    = "DELETE FROM sohorepro_checkout WHERE user_id = " . $user_id . " ";
mysql_query($sql);

$message  = '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
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
$message .= '<td><span style="font-weight:bold;">Date :</span> '.$Date.'</td>';
$message .= '</tr>';
$message .= '<tr height="25px">';
$message .= '<td><span style="font-weight:bold;">Name :</span> '.$user_name.'</td>';
$message .= '</tr>';
$message .= '<tr height="25px">';
$message .= '<td><span style="font-weight:bold;">Company :</span> ' .$company_name. '</td>';
$message .= '</tr>';
$message .= '<tr height="25px">';
$message .= '<td><span style="font-weight:bold;">Email :</span> ' .$user_mail. '</td>';
$message .= '</tr>';
$message .= '<tr height="25px">';
$message .= '<td><span style="font-weight:bold;">Phone :</span> ' .$phone. '</td>';
$message .= '</tr>';
if($prop != ''){
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
$message .= '<td style="padding-bottom:7px;">'.$shipp_address['address_1'].'<br>'.$shipp_address['address_2'].'<br>'.$shipp_address['address_3'].'<br>'.$shipp_address['city'].','.StateName($shipp_address['state']).','.$shipp_address['zip'].'</td>';
$message .= '</tr>';
$message .= '<tr height="25px">';
$message .= '<td><span style="font-weight:bold;">Shipping Address: </span></td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td>'.$shipp_address['address_1'].'<br>'.$shipp_address['address_2'].'<br>'.$shipp_address['address_3'].'<br>'.$shipp_address['city'].','.StateName($shipp_address['state']).','.$shipp_address['zip'].'</td>';
$message .= '</tr>';    
}
$message .= '<tr height="30px">';
$message .= '<td><span style="font-weight:bold;">Customer Reference :</span> ' . $Order_id . '</td>';
$message .= '</tr>';
$message .= '<tr height="30px">';
$message .= '<td><span style="font-weight:bold;">Deleivery Date :</span> ' . $deleivery_date . '</td>';
$message .= '</tr>';
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
$message .= '<td width="110" align="right" valign="middle" bgcolor="'.$rowColor1.'" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">'.'$' . ($ord['product_quantity'] * $ord['product_price']).'</td>';
$message .= '</tr>';
$sub_tot = $ord['product_quantity'] * $ord['product_price'];
$total = $total + $sub_tot;
$tax         = (8.875 * ($total/100));
$i++;
}
$message .= '<tr>';
$message .= '<td colspan="4" align="right" bgcolor="#eeeeee" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;">Subtotal</span></td>';
$message .= '<td bgcolor="#eeeeee" align="right" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">'.'$' .number_format($total, 2, '.', '').'</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td colspan="4" align="right" bgcolor="#dfdfdf" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;">Tax</span></td>';
$message .= '<td bgcolor="#dfdfdf" align="right" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">'.'$' .number_format($tax, 2, '.', '').'</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td colspan="4" align="right" bgcolor="#eeeeee" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;">Total*</span></td>';
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


foreach ($mail_id as $to){
$subject = "Soho Reprographic Order Acknowledgement";
$headers = 'MIME-Version: 1.0' . "\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
$headers .= "From:sohorepro.com" . "\n";
$to = $to['email_id'];
echo $to, $subject, $message, $headers;
$result = mail($to, $subject, $message, $headers);
}
//echo $user_mail, $subject, $message, $headers;
//if($result){
//    echo  '1';
//}  else {
//    echo  '0';
//}


?>
