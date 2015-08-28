<?php
include './admin/config.php';
include './admin/db_connection.php';

if (isset($_POST['user_cart_id'])) {
    
$sql_order_id = mysql_query("SELECT order_number FROM sohorepro_order_master ORDER BY id DESC LIMIT 1");
$object_order = mysql_fetch_assoc($sql_order_id);

        if (count($object_order['order_number']) > 0) {
            $order_id = ($object_order['order_number'] + 1);
        } 
        else{
            $order_id = '101';
        }
    
   
        
$user_id          =       $_POST['user_cart_id'];
$company_id       =       $_POST['company_id'];
$referece         =       $_POST['reference']  ;
$sql = "INSERT INTO sohorepro_order_master SET order_number = '".$order_id."', order_id     = '" . $referece . "', customer_company = '".$company_id."', customer_name = '".$user_id."', created_date = now()";
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
$id                     = $object['id'];
$Order_id               = $object['order_id'];
$Order_number           = $object['order_number'];
$Date                   = date("m-d-Y h:m:s", strtotime($object['created_date']));                            
$view_orders            = viewOrders($id);
$mail_id                = getActiveEmail();
unset($_SESSION['job']);
$sql                    = "DELETE FROM sohorepro_checkout WHERE user_id = " . $user_id . " ";
mysql_query($sql);

$message  = '<style>';
$message  .= 'body {margin: 0px;font-family:Arial, sans-serif;font-size:14px;color:#5d5d5d;}';
$message  .= '.brdr{ border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;}';
$message  .= '.pad_lft{ padding-left:20px; }';
$message  .= '.pad_rght{ padding-right:15px; }';
$message  .= '.brdr1{ border:1px solid #e1e1e1;}';
$message  .= '.brdr-top{ border-top:0px !important;}';
$message  .= '.brdr-lft{ border-left:0px !important;}';
$message  .= '</style>';
$message .= '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
$message .= '<table width="780" border="0" cellspacing="0" cellpadding="0">';
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
$message .= '<td align="left" valign="top"><table width="710" border="0" cellspacing="0" cellpadding="0">';
$message .= '<tr>';
$message .= '<td width="140" align="left" valign="top"><img src="http://cipldev.com/soho-repro/store_files/soho_logo.jpg" width="126" height="115"  alt=""/></td>';
$message .= '<td align="left" valign="top"><table width="520" border="0" cellspacing="0" cellpadding="0">';
$message .= '<tr>';
$message .= '<td width="90" align="left" valign="middle" style="font-size:18px; color:#ff9600; text-transform:uppercase;">JOB REF</td>';
$message .= '<td width="15" align="left" valign="middle" style="color:#202020;">:</td>';
$message .= '<td align="left" valign="middle" style="color:#202020;">' . $Order_id . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td width="90" align="left" valign="middle" style="font-size:18px; color:#ff9600; text-transform:uppercase;">Order Number</td>';
$message .= '<td width="15" align="left" valign="middle" style="color:#202020;">:</td>';
$message .= '<td align="left" valign="middle" style="color:#202020;">' . $Order_number . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td width="90" align="left" valign="middle" style="font-size:18px; color:#ff9600; text-transform:uppercase;">Date</td>';
$message .= '<td width="15" align="left" valign="middle" style="color:#202020;">:</td>';
$message .= '<td align="left" valign="middle" style="color:#202020;">' . $Date . '</td>';
$message .= '</tr>';
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
$message .= '<table width="740" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';
$message .= '<tr style="color:#fff; text-transform:uppercase;">';
$message .= '<td width="250" align="center" valign="middle" bgcolor="#f68210" class="brdr">Product Detail</td>';
$message .= '<td width="90" align="center" valign="middle" bgcolor="#f68210" class="brdr">Quantity</td>';
$message .= '<td width="90" align="center" valign="middle" bgcolor="#f68210" class="brdr">Unit Cost</td>';
$message .= '<td width="90" align="center" valign="middle" bgcolor="#f68210" class="brdr">Line Cost</td>';
$message .= '<td width="220" align="center" valign="middle" bgcolor="#f68210" class="brdr">Shipping Address</td>';
$message .= '</tr>';
$total = 0;
$i = 0;
foreach ($view_orders as $ord) {
    $rowColor   = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
    $rowColor1  = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
    $prod_id    = $ord['product_id'];
    $shipping   = SelectAllAddress($ord['shipping_add_id']);
    $id = $ord['id'];    
$message .= '<tr>';
$message .= '<td width="250" align="left" valign="middle" bgcolor="'.$rowColor1.'" class="brdr pad_lft">'.getorderProd($prod_id).'</td>';
$message .= '<td width="90" align="center" valign="middle" bgcolor="'.$rowColor.'" class="brdr">'.$ord['product_quantity'].'</td>';
$message .= '<td width="90" align="right" valign="middle" bgcolor="'.$rowColor1.'" class="brdr pad_rght">'.'$' . $ord['product_price'].'</td>';
$message .= '<td width="90" align="right" valign="middle" bgcolor="'.$rowColor.'" class="brdr pad_rght">'.'$' . ($ord['product_quantity'] * $ord['product_price']).'.00</td>';
$message .= '<td width="190" align="left" valign="middle" bgcolor="'.$rowColor1.'" class="brdr pad_lft pad_rght">'.$shipping[0]['company_name'].'</br>'.$shipping[0]['attention_to'].'</br>'.$shipping[0]['address_1'].'</br>'.$shipping[0]['address_2'].'</br>'.$shipping[0]['address_3'].'</br>'.$shipping[0]['city'].','.StateName($shipping[0]['state']).','.$shipping[0]['zip'].'</td>';
$message .= '</tr>';
$sub_tot = $ord['product_quantity'] * $ord['product_price'];
$total = $total + $sub_tot;
$tax         = (8.875 * ($total/100));
$i++;
}
$message .= '</table></td>';
$message .= '<td width="20" align="left" valign="top"></td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td width="20" height="20" align="left" valign="top"></td>';
$message .= '<td height="20" align="left" valign="top"></td>';
$message .= '<td width="20" height="20" align="left" valign="top"></td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td width="20" align="left" valign="top"></td>';
$message .= '<td align="right" valign="top"><table width="240" border="0" cellspacing="0" cellpadding="0">';
$message .= '<tr>';
$message .= '<td height="30" align="left" valign="middle" class="pad_lft brdr1">Sub Total</td>';
$message .= '<td width="100" height="30" align="right" valign="middle" bgcolor="#FAFAFA" class="pad_rght brdr1  brdr-lft">'.'$' .number_format($total, 2, '.', '').'</td>';
$message .= '</tr>';

$message .= '<tr>';
$message .= '<td height="30" align="left" valign="middle" class="pad_lft brdr1 brdr-top">Tax</td>';
$message .= '<td width="100" height="30" align="right" valign="middle" bgcolor="#FAFAFA" class="pad_rght brdr1 brdr-top brdr-lft">'.'$' .number_format($tax, 2, '.', '').'</td>';
$message .= '</tr>';

$message .= '<tr>';
$message .= '<td height="30" align="left" valign="middle" class="pad_lft brdr1 brdr-top">Total</td>';
$message .= '<td width="100" height="30" align="right" valign="middle" bgcolor="#FAFAFA" class="pad_rght brdr1 brdr-top brdr-lft">'.'$' .number_format(($total + $tax), 2, '.', '').'</td>';
$message .= '</tr>';


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


foreach ($mail_id as $to){
$subject = "TEST-SOHO REPRO ORDER";
$headers = 'MIME-Version: 1.0' . "\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
$headers .= "From:sohorepro.com" . "\n";
$to = $to['email_id'];
//echo $to, $subject, $message, $headers;
$result = mail($to, $subject, $message, $headers);
}
mail($user_mail, $subject, $message, $headers);
if($result){
    echo  '1';
}  else {
    echo  '0';
}

}

?>
