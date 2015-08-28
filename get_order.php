<style>
    body{
         background-color: #BFC5CD; 
    }
</style>
<title>Sohorepro-Order</title>
<?php
include './admin/config.php';
include './admin/db_connection.php';
$user_id                = $_SESSION['sohorepro_userid'];
$sql                    = "DELETE FROM sohorepro_checkout WHERE user_id = " . $user_id . " ";
mysql_query($sql);
$sql_order_id           = mysql_query("SELECT id,order_id,created_date,order_number FROM sohorepro_order_master ORDER BY id DESC LIMIT 1");
$object                 = mysql_fetch_assoc($sql_order_id);
$id                     = $object['id'];
$Order_id               = $object['order_id'];
$Order_number           = $object['order_number'];
$Date                   = date("m-d-Y h:m:s", strtotime($object['created_date']));                            
$view_orders            = viewOrders($id);
$mail_id                = getActiveEmail();

$message  = '<link href="mail_css.css" media="screen" rel="stylesheet" type="text/css" />';
$message .= '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
$message .= '<table width="750" border="0" cellspacing="0" cellpadding="0">';
$message .= '<tr bgcolor="#ff7e00">';
$message .= '<td width="10" height="10" align="left" valign="top"></td>';
$message .= '<td height="10" align="left" valign="top"></td>';
$message .= '<td width="10" height="10" align="left" valign="top"></td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
$message .= '<td align="left" valign="top"><table width="730" border="0" cellspacing="0" cellpadding="0">';
$message .= '<tr>';
$message .= '<td width="20" height="20" align="left" valign="top"></td>';
$message .= '<td height="20" align="left" valign="top"></td>';
$message .= '<td width="20" height="20" align="left" valign="top"></td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td width="20" align="left" valign="top"></td>';
$message .= '<td align="left" valign="top"><table width="690" border="0" cellspacing="0" cellpadding="0">';
$message .= '<tr>';
$message .= '<td width="140" align="left" valign="top"><img src="http://cipldev.com/soho-repro/store_files/soho_logo.jpg" width="126" height="115"  alt=""/></td>';
$message .= '<td align="left" valign="top"><table width="500" border="0" cellspacing="0" cellpadding="0">';
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
$message .= '<table width="690" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';
$message .= '<tr style="color:#fff; text-transform:uppercase;">';
$message .= '<td width="260" align="center" valign="middle" bgcolor="#f68210" class="brdr">Product Detail</td>';
$message .= '<td width="110" align="center" valign="middle" bgcolor="#f68210" class="brdr">Quantity</td>';
$message .= '<td width="110" align="center" valign="middle" bgcolor="#f68210" class="brdr">Unit Cost</td>';
$message .= '<td width="110" align="center" valign="middle" bgcolor="#f68210" class="brdr">Line Cost</td>';
$message .= '</tr>';
$total = 0;
$i = 0;
foreach ($view_orders as $ord) {
    $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
    $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
    $prod_id = $ord['product_id'];
    $id = $ord['id'];    
$message .= '<tr>';
$message .= '<td width="260" align="left" valign="middle" bgcolor="'.$rowColor1.'" class="brdr pad_lft">'.getorderProd($prod_id).'</td>';
$message .= '<td width="110" align="center" valign="middle" bgcolor="'.$rowColor.'" class="brdr">'.$ord['product_quantity'].'</td>';
$message .= '<td width="110" align="right" valign="middle" bgcolor="'.$rowColor1.'" class="brdr pad_rght">'.'$' . $ord['product_price'].'</td>';
$message .= '<td width="110" align="right" valign="middle" bgcolor="'.$rowColor.'" class="brdr pad_rght">'.'$' . ($ord['product_quantity'] * $ord['product_price']).'.00</td>';
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
$subject = "SOHO-REPRO-ORDER";
$headers = 'MIME-Version: 1.0' . "\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
$headers .= "From:sohorepro.com" . "\n";
$to = $to['email_id'];
//echo $to, $subject, $message, $headers;
$result = mail($to, $subject, $message, $headers);
}

if($result){
    $res = 'success';
}  else {
    $res = 'failure';
}

if ($res == "success") {
    ?>
<div style="color:#007F2A; text-align:center;padding-bottom:10px;"><h3>Order placed successfully</h3></div>
    <script>setTimeout("location.href=\'index.php\'", 2000);</script>
    <?php
} elseif ($res == "failure") {
    ?>
    <div style="color:#F00; text-align:center;padding-bottom:10px;"><h3>Order not placed successfully</h3></div>
    <script>setTimeout("location.href=\'index.php\'", 2000);</script>       
    <?php
}

?>
