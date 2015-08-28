<?php
include './config.php';

$Order_Id = $_SESSION['final_ord_id'];


$sql_order_id_mail = mysql_query("SELECT id,order_id,created_date,order_number,customer_name,customer_company,deleivery_date,order_comment FROM sohorepro_order_master WHERE id = '" . $Order_Id . "' ORDER BY id DESC LIMIT 1");
$object = mysql_fetch_assoc($sql_order_id_mail);
$user_mail_id_txt = UserMail($object['customer_name']);
$user_mail = array('email_id' => UserMail($object['customer_name']));
$user_name = UserName($object['customer_name']);
$company_name = companyName($object['customer_company']);
$phone = companyphone($object['customer_company']);
$billing_address = BillingAddressShippId($object['customer_company']);
$shipp_address = CompanyAddressMail($billing_address);
$prop = PropTest($shipp_add_id);
$id = $Order_Id;
$Order_id = $object['order_id'];
$Order_number = $object['order_number'];
$deleivery_date = $object['deleivery_date'];
$comp_id = $object['customer_company'];
$order_comm = $object['order_comment'];
//$current_time           = date("Y-m-d h:i:s");
$current_time = $object['created_date'];
$datew = new DateTime($current_time, new DateTimeZone('America/New_York'));
date_default_timezone_set('America/New_York');
$temp_times = date("Y-m-d h:iA", $datew->format('U'));
//$Date = date("m/d/Y", strtotime($object['created_date'])). ' ' .date("h:iA",strtotime("-180 minutes",strtotime($temp_times)));
$Date = date('Y-m-d h:i A', time());
$view_orders = viewOrders($id);
$pick_up = $view_orders[0]['shipping_add_id'];
$mail_id = getActiveEmail();
$customer_email = array('email_id' => CompanyMail($comp_id));
array_push($mail_id, $user_mail, $customer_email);
$comment = 'Comment :';
$address_3 = ($shipp_address['address_3'] != '') ? $shipp_address['address_3'] . '<br>' : '';
//$mail = new PHPMailer();
?>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta content="text/html;charset=iso-8859-1" http-equiv="Content-Type">
        <style type="text/css">
            body {
                margin-left: 0px;
                margin-top: 0px;
                margin-right: 0px;
                margin-bottom: 0px;
                font-family:Arial, sans-serif;
                font-size:14px;
            }
        </style>
    </head>
    <body>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <table width="780" border="0" cellspacing="0" cellpadding="0" class="padd">
            <tr bgcolor="#ff7e00">
                <td width="10" height="10" align="left" valign="top"></td>
                <td height="10" align="left" valign="top"></td>
                <td width="10" height="10" align="left" valign="top"></td>
            </tr>
            <tr>
                <td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>
                <td align="left" valign="top"><table width="760" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="20" height="20" align="left" valign="top"></td>
                            <td height="20" align="left" valign="top"></td>
                            <td width="20" height="20" align="left" valign="top"></td>
                        </tr>
                        <tr>
                            <td width="20" align="left" valign="top"></td>
                            <td align="left" valign="top"><table width="740" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td>Your Soho Repro graphics order has been received and will be processed promptly.</br></br></td>
                                    </tr>
                                    <tr height="30px">
                                        <td><span style="font-weight:bold;">Customer Reference :</span><?php echo $Order_id; ?></td>
                                    </tr>
                                    <tr height="25px">
                                        <td><span style="font-weight:bold;">Date :</span><?php echo $Date; ?></td>
                                    </tr>
                                    <tr height="25px">
                                        <td><span style="font-weight:bold;">Name :</span><?php echo $user_name; ?></td>
                                    </tr>
                                    <tr height="25px">
                                        <td><span style="font-weight:bold;">Company :</span><?php echo $company_name ;?></td>
                                    </tr>
                                    <tr height="25px">
                                        <td><span style="font-weight:bold;">Email :</span><?php echo $user_mail_id_txt; ?></td>
                                    </tr>
                                    <tr height="25px">
                                        <td><span style="font-weight:bold;">Phone :</span><?php echo $phone ; ?></td>
                                    </tr>
                                    <?php 
                                    if($pick_up == 'P'){
                                    ?>
                                    <tr height="30px">
                                        <td><span style="font-weight:bold;">Billing Address: </span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom:7px;"><?php echo $shipp_address['company_name'].'<br>'.$shipp_address['address_1'].'<br>'.$shipp_address['address_2'].'<br>'.$address_3.$shipp_address['city'].',&nbsp;'.StateName($shipp_address['state']).'&nbsp;'.$shipp_address['zip']; ?></td>
                                    </tr>
                                    <tr height="30px">
                                        <td><span style="font-weight:bold;">Pickup Address: </span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom:7px;">Soho Reprographics<br>381 Broome Street<br>New York, NY 10013</td>
                                    </tr>
                                    <?php }else{ ?>
                                    <tr height="30px">
                                        <td><span style="font-weight:bold;">Billing Address: </span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom:7px;"><?php echo $shipp_address['company_name'].'<br>'.$shipp_address['address_1'].'<br>'.$shipp_address['address_2'].'<br>'.$address_3.$shipp_address['city'].',&nbsp;'.StateName($shipp_address['state']).'&nbsp;'.$shipp_address['zip'] ; ?></td>
                                    </tr>
                                    <tr height="25px">
                                        <td><span style="font-weight:bold;">Multiple Shipping Addresses: </span></td>
                                    </tr>
                                    <?php
                                    $multi      = MultiShippingAddress($Order_Id);
                                    $pick_up_multi    =   Pickup();
                                    foreach ($multi as $multi_shipp){
                                    $address_multi_pre    = SelectIdAddress($multi_shipp['shipping_id']);
                                    $address_multi_1    =  ($address_multi_pre[0]['address_1'] != '')  ? $address_multi_pre[0]['address_1'].'<br>' : '';
                                    $address_multi_2    =  ($address_multi_pre[0]['address_2'] != '')  ? $address_multi_pre[0]['address_2'].'<br>' : '';
                                    $address_multi_3    =  ($address_multi_pre[0]['address_3'] != '')  ? $address_multi_pre[0]['address_3'].'<br>' : '';
                                    $check_item_id      =   explode(",", $multi_shipp['item_id']);   
                                    $items_tag          =   ($check_item_id[1] != '') ? '<span style="font-weight:bold;">Items&nbsp;:&nbsp;'.$multi_shipp['item_id'].'<br>' : '<span style="font-weight:bold;">Item&nbsp;:&nbsp;'.$multi_shipp['item_id'].'<br>';
                                    $address_for_items_pre[] = ($multi_shipp['shipping_id'] != 'P') ? '<div style="float:left;width:100%;">'.$items_tag.'</span><span style="font-weight:bold;">Shipping Address: </span><br>'.$address_multi_pre[0]['company_name'].'<br>'.$address_multi_1.$address_multi_2.$address_multi_3.$address_multi_pre[0]['city'].',&nbsp;'.StateName($address_multi_pre[0]['state']).'&nbsp;'.$address_multi_pre[0]['zip'].'<br><br><span style="font-weight:bold;">Delivery Date :</span></div><div style="float:left;width:100%;">'.$deleivery_date.'</div>' : '<div style="float:left;width:100%;">'.$items_tag.'</span><span style="font-weight:bold;">Pickup Address: </span><br>'.$pick_up_multi.'<br><br><span style="font-weight:bold;">Delivery Date :</span></div><div style="float:left;width:100%;">'.$deleivery_date.'</div>';
                                    }
                                    ?>
                                    <tr>
                                        
                                        <td>
                                            <table align="left" border="0">
                                                <?php
                                                for ($m = 0; $m<count($address_for_items_pre); $m+=3)
                                                    {
                                                    ?>
                                                    <tr>
                                                    <td><?php echo $address_for_items_pre[$m]; ?></td>
                                                    <td><?php echo $address_for_items_pre[$m+1]; ?></td>
                                                    <td><?php echo $address_for_items_pre[$m+2]; ?></td>
                                                    </tr> 
                                                    <tr><td>&nbsp;</td></tr>
                                                    <?php
                                                    }
                                                    ?>
                                            </table>
                                        </td>
                                    </tr>
                            <?php
                                }
                            ?>
                                </table></td>
                            <td height="25" width="20" align="left" valign="top"></td>
                        </tr>
                        <tr>
                            <td width="20" align="left" valign="top"></td>
                            <td align="left" valign="top">
                                <table width="740" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">
                                    <tr style="color:#fff; text-transform:uppercase;">
                                        <td width="40" align="center" valign="middle" bgcolor="#f68210" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">Item</td>
                                        <td width="400" align="center" valign="middle" bgcolor="#f68210" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">Description</td>
                                        <td width="80" align="center" valign="middle" bgcolor="#f68210" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">Quantity</td>
                                        <td width="100" align="center" valign="middle" bgcolor="#f68210" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">Unit Price</td>
                                        <td width="110" align="center" valign="middle" bgcolor="#f68210" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">Total</td>
                                    </tr>
                                    <?php 
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
                                    ?>
                                    <tr>
                                        <td width="40" align="left" valign="middle" bgcolor="<?php echo $rowColor1; ?>" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-left:20px;"><?php echo $i; ?></td>
                                        <td width="400" align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;"><?php echo getorderProd($prod_id); ?></td>                                        
                                        <td width="80" align="right" valign="middle" bgcolor="<?php echo $rowColor1; ?>" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><?php echo $ord['product_quantity']; ?></td>
                                        <td width="100" align="right" valign="middle" bgcolor="<?php echo $rowColor; ?>" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">$<?php echo $ord['product_price']; ?></td>
                                        <td width="110" align="right" valign="middle" bgcolor="<?php echo $rowColor1; ?>" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">$<?php echo number_format(($ord['product_quantity'] * $ord['product_price']), 2, '.',''); ?></td>
                        </tr>
                        <?php
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
                        ?>
                        <tr>
                            <td colspan="2" rowspan="3" bgcolor="#eeeeee" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;"><?php echo $comment; ?></span><br><?php echo $order_comm; ?></td>
                            <td colspan="2" align="right" bgcolor="#eeeeee" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;">Subtotal</span></td>
                            <td bgcolor="#eeeeee" align="right" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"> $ <?php echo number_format($total, 2, '.', ''); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right" bgcolor="#dfdfdf" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;">Tax</span></td>
                            <td bgcolor="#dfdfdf" align="right" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">$ <?php echo number_format($tax, 2, '.', ''); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right" bgcolor="#eeeeee" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;">Total*</span></td>
                            <td bgcolor="#eeeeee" align="right" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">$ <?php echo number_format(($total + $tax), 2, '.', ''); ?></td>
                        </tr>
                    </table></td>
                <td width="20" align="left" valign="top"></td>
            </tr>
            <tr>
                <td width="20" height="20" align="left" valign="top"></td>
                <td height="20" align="left" valign="top"></td>
                <td width="20" height="20" align="left" valign="top"></td>
            </tr>
            <tr>
                <td height="20" align="left" valign="top"></td>
                <td height="20" align="left" valign="top" style="padding-bottom:5px;font-size:12px;">*Delivery charges to be applied as necessary</td>
                <td height="20" align="left" valign="top"></td>
            </tr>
        </table></td>
<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>
</tr>
<tr bgcolor="#ff7e00">
    <td width="10" height="10" align="left" valign="top"></td>
    <td height="10" align="left" valign="top"></td>
    <td width="10" height="10" align="left" valign="top"></td>
</tr>
</table>
</table>
</body>
</html>

<?php
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
//$headers .= 'Content-Transfer-Encoding: 8bit\r\n\r\n
////$to       = $to['email_id'];
////echo $to, $subject, $message, $headers;
//$result = mail($to, $subject, $message, $headers);
//}
//$final_html = html_entity_decode($message);
//
//$primary_mail_var = $final_html;
//$students = Array('S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'S7', 'S8', 'S9', 'S10');
//$html = '<table border="1">
//for ($i = 0; $i<count($students); $i+=3)
//{
//    $html.= '<tr>
//                <td>'.$students[$i].'</td>
//                <td>'.$students[$i+1].'</td>
//                <td>'.$students[$i+2].'</td>
//            </tr>
//    $html.= '<tr><td>&nbsp;</td></tr>
//}
//$html.= '</table>
//echo $html;
?>
 
