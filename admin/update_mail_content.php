<?php
include './config.php';

$order_id = $_POST['order_id'];
?>

<div style="width: 100%;float: left;">
    <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>" />
    <ul>
        <li>
            <label>Enter the Message</label>
            <textarea id="upt_mail_msg" name="upt_mail_msg"  style="margin: 0px; height: 60px; width: 250px; margin-bottom: 15px;"></textarea>
        </li>
        <li>
            <label>&nbsp;</label>
            <span onclick="return send_upt_mail('<?php echo $order_id; ?>');" style="cursor: pointer;background: #F99B3E;color: #FFF;float: left;padding: 5px 20px;border-radius: 5px;margin-bottom: 10px;">Send Mail</span>
        </li>
    </ul>    
</div>

<?php
//$order_id =  $_POST['order_id'];
//$sql_order_id_mail      = mysql_query("SELECT id,order_id,created_date,order_number,customer_name,customer_company,deleivery_date,order_comment FROM sohorepro_order_master WHERE id = '".$order_id."' ORDER BY id DESC LIMIT 1");
//$object                 = mysql_fetch_assoc($sql_order_id_mail);
//$customer_email_main    = UserMail($object['customer_name']);
//$Order_id               = $object['order_id'];
//
//
//$sql_order_id_mail_con  = mysql_query("SELECT id,order_id,created_date,order_number,customer_name,customer_company,deleivery_date,order_comment FROM sohorepro_order_master WHERE id = '".$order_id."' ORDER BY id DESC LIMIT 1");
//$object_con             = mysql_fetch_assoc($sql_order_id_mail_con);
//$user_mail_id_txt       = UserMail($object_con['customer_name']);
//$user_mail              = array('email_id' => UserMail($object_con['customer_name']));
//$user_name              = UserName($object_con['customer_name']);
//$company_name           = companyName($object_con['customer_company']);
//$phone                  = companyphone($object_con['customer_company']);
//$billing_address        = BillingAddressShippId($object_con['customer_company']);
//$shipp_address          = CompanyAddressMail($billing_address);
//$prop                   = PropTest($shipping_id);
//$id                     = $Order_Id;
////$Order_id               = $object_con['order_id'];
//$Order_number           = $object_con['order_number'];
//$deleivery_date         = $object_con['deleivery_date'];
//$comp_id                = $object_con['customer_company'];
//$order_comm             = $object_con['order_comment'];
////$current_time           = date("Y-m-d h:i:s");
//$current_time = $object['created_date'];
//$datew = new DateTime($current_time, new DateTimeZone('America/New_York'));
//date_default_timezone_set('America/New_York');
//$temp_times =  date("Y-m-d h:iA", $datew->format('U'));        
////$Date = date("m-d-Y", strtotime(date('Y-m-d h:i:s', time()))). ' ' .date("h:iA",strtotime("-0 minutes",strtotime($temp_times)));
//$Date                   = date('Y-m-d h:i A', time());                            
//$view_orders            = viewOrders($order_id);
//$pick_up                = $view_orders[0]['shipping_add_id'];
//$mail_id                = getActiveEmail();
//$returnValue            = html_entity_decode('Your Soho Reprographics order has been received and will be processed promptly.', ENT_COMPAT, 'ISO-8859-1');
//$customer_email         = array('email_id' => CompanyMail($comp_id));
//array_push($mail_id, $user_mail, $customer_email);
//$comment                = 'Comment :';
//$address_3 = ($shipp_address['address_3'] != '') ? $shipp_address['address_3'].'<br>' : '';
////$mail = new PHPMailer();
//
//$message  ='<html>';
//$message .='<head>';
//$message .='<title></title>';
//$message .='<meta content="text/html;charset=iso-8859-1" http-equiv="Content-Type">';
//$message .= '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
//$message .='<style type="text/css">';
//$message .='body {margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;font-family:Arial, sans-serif;font-size:14px;}';
//$message .='div, p, a, li, td { -webkit-text-size-adjust:none; }'; 
//$message .='.padd-fix td{padding:5px 0px;}';
//$message .='</style>';
//$message .='</head>';
//$message .='<body>';
//$message .= '<table width="780" border="0" cellspacing="0" cellpadding="0" class="padd">';
//$message .= '<tr><td>'.$short_msg.'</td></tr>';
//$message .= '</table>';
//$message .= '<table width="780" border="0" cellspacing="0" cellpadding="0" class="padd">';
//$message .= '<tr bgcolor="#ff7e00">';
//$message .= '<td width="10" height="10" align="left" valign="top"></td>';
//$message .= '<td height="10" align="left" valign="top"></td>';
//$message .= '<td width="10" height="10" align="left" valign="top"></td>';
//$message .= '</tr>';
//$message .= '<tr>';
//$message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
//$message .= '<td align="left" valign="top"><table width="760" border="0" cellspacing="0"  cellpadding="0">';
//$message .= '<tr>';
//$message .= '<td width="20" height="20" align="left" valign="top"></td>';
//$message .= '<td height="20" align="left" valign="top"></td>';
//$message .= '<td width="20" height="20" align="left" valign="top"></td>';
//$message .= '</tr>';
//$message .= '<tr>';
//$message .= '<td width="20" align="left" valign="top"></td>';
//$message .= '<td align="left" valign="top"><table width="740" border="0" cellspacing="0" class="padd-fix" cellpadding="0">';
//$message .= '<tr>';
//$message .= '<td>'.$returnValue.'</br></td>';
//$message .= '</tr>';
//$message .= '<tr>';
//$message .= '<td>&nbsp;</td>';
//$message .= '</tr>';
//$message .= '<tr height="30px">';
//$message .= '<td><span style="font-weight:bold;">Customer Reference :</span> ' . $Order_id . '</td>';
//$message .= '</tr>';
//$message .= '<tr height="25px">';
//$message .= '<td><span style="font-weight:bold;">Date :</span> '.$Date.'</td>';
//$message .= '</tr>';
//$message .= '<tr height="25px">';
//$message .= '<td><span style="font-weight:bold;">Name :</span> '.$user_name.'</td>';
//$message .= '</tr>';
//$message .= '<tr height="25px">';
//$message .= '<td><span style="font-weight:bold;">Company :</span> ' .$company_name. '</td>';
//$message .= '</tr>';
//$message .= '<tr height="25px">';
//$message .= '<td><span style="font-weight:bold;">Email :</span> ' .$user_mail_id_txt. '</td>';
//$message .= '</tr>';
//$message .= '<tr height="25px">';
//$message .= '<td><span style="font-weight:bold;">Phone :</span> ' .$phone. '</td>';
//$message .= '</tr>';
//if($pick_up == 'P'){
//$message .= '<tr height="30px">';
//$message .= '<td><span style="font-weight:bold;">Pickup Address: </span></td>';
//$message .= '</tr>';
//$message .= '<tr>';
//$message .= '<td style="padding-bottom:7px;">Soho Reprographics<br>381 Broome Street<br>New York, NY 10013</td>';
//$message .= '</tr>';
//}else{
//$message .= '<tr height="30px">';
//$message .= '<td><span style="font-weight:bold;">Billing Address: </span></td>';
//$message .= '</tr>';
//$message .= '<tr>';
//$message .= '<td style="padding-bottom:7px;">'.$shipp_address['company_name'].'<br>'.$shipp_address['address_1'].'<br>'.$shipp_address['address_2'].'<br>'.$address_3.$shipp_address['city'].',&nbsp;'.StateName($shipp_address['state']).'&nbsp;'.$shipp_address['zip'].'</td>';
//$message .= '</tr>';
//
//$message .= '<tr height="25px">';
//$message .= '<td><span style="font-weight:bold;">Multiple Shipping Addresses: </span></td>';
//$message .= '</tr>';
//$multi              = MultiShippingAddress($order_id);
//$pick_up_multi      =   Pickup();
//foreach ($multi as $multi_shipp){
//$address_multi_pre    = SelectIdAddress($multi_shipp['shipping_id']);
//$address_multi_1    =  ($address_multi_pre[0]['address_1'] != '')  ? $address_multi_pre[0]['address_1'].'<br>' : '';
//$address_multi_2    =  ($address_multi_pre[0]['address_2'] != '')  ? $address_multi_pre[0]['address_2'].'<br>' : '';
//$address_multi_3    =  ($address_multi_pre[0]['address_3'] != '')  ? $address_multi_pre[0]['address_3'].'<br>' : '';
//$check_item_id      =   explode(",", $multi_shipp['item_id']);   
//$items_tag          =  ($check_item_id[1] != '') ? '<span style="font-weight:bold;">Items&nbsp;:&nbsp;'.$multi_shipp['item_id'].'<br>' : '<span style="font-weight:bold;">Item&nbsp;:&nbsp;'.$multi_shipp['item_id'].'<br>';
//$address_for_items_pre[] = ($multi_shipp['shipping_id'] != 'P') ? $items_tag.'</span><span style="font-weight:bold;">Shipping Address: </span><br>'.$address_multi_pre[0]['company_name'].'<br>'.$address_multi_1.$address_multi_2.$address_multi_pre[0]['city'].',&nbsp;'.StateName($address_multi_pre[0]['state']).'&nbsp;'.$address_multi_pre[0]['zip'].'<br><br><span style="font-weight:bold;">Delivery Date :</span>'.$deleivery_date : $items_tag.'</span><span style="font-weight:bold;">Pickup Address: </span><br>'.$pick_up_multi.'<br><br><br><span style="font-weight:bold;">Delivery Date :</span>'.$deleivery_date;
//}
//$message .= '<tr><td >';
//$message .= '<table width="100%" border="0">';
//for ($m = 0; $m<count($address_for_items_pre); $m+=3)
//{
//    $message.= '<tr>
//                <td style="margin-right:10px;" valign="top" width="33%" align="left">'.$address_for_items_pre[$m].'</td>
//                <td style="margin-right:10px;" valign="top" width="33%" align="left">'.$address_for_items_pre[$m+1].'</td>
//                <td style="margin-right:10px;" valign="top" width="33%" align="left">'.$address_for_items_pre[$m+2].'</td>
//            </tr>';
//    $message.= '<tr><td>&nbsp;</td></tr>';
//}
//$message .= '</table>';
//$message .= '</td></tr>';
//
//}
//
//$message .= '</table></td>';
//$message .= '<td height="25" width="20" align="left" valign="top"></td>';
//$message .= '</tr>';
//$message .= '<tr>';
//$message .= '<td width="20" align="left" valign="top"></td>';
//$message .= '<td align="left" valign="top">';
//$message .= '<table width="740" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';
//$message .= '<tr style="color:#fff; text-transform:uppercase;">';
//$message .= '<td width="40" align="center" valign="middle" bgcolor="#f68210" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">Item</td>';
//$message .= '<td width="400" align="center" valign="middle" bgcolor="#f68210" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">Description</td>';
//$message .= '<td width="80" align="center" valign="middle" bgcolor="#f68210" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">Quantity</td>';
//$message .= '<td width="100" align="center" valign="middle" bgcolor="#f68210" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">Unit Price</td>';
//$message .= '<td width="110" align="center" valign="middle" bgcolor="#f68210" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">Total</td>';
//$message .= '</tr>';
//$total = 0;
//$i = 1;
//foreach ($view_orders as $ord) {
//$rowColor   = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
//$rowColor1  = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
//$prod_id    = $ord['product_id'];
//$shipping   = SelectAllAddress($ord['shipping_add_id']);
//$id = $ord['id']; 
//$super_id           = getsuper($prod_id);
//$cat_id             = getcat($prod_id);
//$sub_id             = getsub($prod_id);
//$super_name         = (getsuperN($super_id) != '') ? getsuperN($super_id) : '';        
//$cat_name_pre       = (getcatN($cat_id) != '') ? getcatN($cat_id) : '';
//$cat_name           = ($cat_name_pre != '') ? '>>'.$cat_name_pre : $cat_name_pre ;        
//$sub_name_pre       = (getsubN($sub_id) != '') ? getsubN($sub_id):'';
//$sub_name           = ($sub_name != '')  ? '>>'.$sub_name_pre : $sub_name_pre;
//$message .= '<tr>';
//$message .= '<td width="40" align="left" valign="middle" bgcolor="'.$rowColor1.'" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-left:20px;">'.$i.'</td>';
//$message .= '<td width="400" align="center" valign="middle" bgcolor="'.$rowColor.'" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">'.getorderProd($prod_id).'<div>';
//$message .= '<span style="font-size: 11px;color: #2a9be3;">'.$super_name.$cat_name.$sub_name.'</span></div></td>';
//$message .= '<td width="80" align="right" valign="middle" bgcolor="'.$rowColor1.'" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">'.$ord['product_quantity'].'</td>';
//$message .= '<td width="100" align="right" valign="middle" bgcolor="'.$rowColor.'" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">'.'$' . $ord['product_price'].'</td>';
//$message .= '<td width="110" align="right" valign="middle" bgcolor="'.$rowColor1.'" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">'.'$' . number_format(($ord['product_quantity'] * $ord['product_price']), 2, '.','').'</td>';
//$message .= '</tr>';
//$sub_tot = $ord['product_quantity'] * $ord['product_price'];
//$tax_status = getTaxStatusChk($comp_id);
//$tax_value = TaxValue();
//if($tax_status == '1')
//{
//$tax_line = '0';     
//}  else {                    
//$tax_line = $tax_value;  
//}
//$total = $total + $sub_tot;
//$tax         = ($tax_line * ($total/100));
//$i++;
//}
//$message .= '<tr>';
//$message .= '<td colspan="2" rowspan="3" bgcolor="#eeeeee" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;">Comment:</span><br>'.$order_comm.'</td>';
//$message .= '<td colspan="2" align="right" bgcolor="#eeeeee" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;">Subtotal</span></td>';
//$message .= '<td bgcolor="#eeeeee" align="right" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">'.'$' .number_format($total, 2, '.', '').'</td>';
//$message .= '</tr>';
//$message .= '<tr>';
//$message .= '<td colspan="2" align="right" bgcolor="#dfdfdf" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;">Tax</span></td>';
//$message .= '<td bgcolor="#dfdfdf" align="right" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">'.'$' .number_format($tax, 2, '.', '').'</td>';
//$message .= '</tr>';
//$message .= '<tr>';
//$message .= '<td colspan="2" align="right" bgcolor="#eeeeee" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;"><span style="font-weight:bold;">Total*</span></td>';
//$message .= '<td bgcolor="#eeeeee" align="right" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-right:15px;">'.'$' .number_format(($total + $tax), 2, '.', '').'</td>';
//$message .= '</tr>';
//$message .= '</table></td>';
//$message .= '<td width="20" align="left" valign="top"></td>';
//$message .= '</tr>';
//$message .= '<tr>';
//$message .= '<td width="20" height="20" align="left" valign="top"></td>';
//$message .= '<td height="20" align="left" valign="top"></td>';
//$message .= '<td width="20" height="20" align="left" valign="top"></td>';
//$message .= '</tr>';
//$message .= '<tr>';
//$message .= '<td height="20" align="left" valign="top"></td>';
//$message .= '<td height="20" align="left" valign="top" style="padding-bottom:5px;font-size:12px;">*Delivery charges to be applied as necessary</td>';
//$message .= '<td height="20" align="left" valign="top"></td>';
//$message .= ' </tr>';
//$message .= '</table></td>';
//$message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
//$message .= '</tr>';
//$message .= '<tr bgcolor="#ff7e00">';
//$message .= '<td width="10" height="10" align="left" valign="top"></td>';
//$message .= '<td height="10" align="left" valign="top"></td>';
//$message .= '<td width="10" height="10" align="left" valign="top"></td>';
//$message .= ' </tr>';
//$message .= '</table>';
//$message .='</table>';
//$message .='</body>';
//$message .='</html>';
//$final_html = html_entity_decode($message);
//
//$myfile = fopen("./mail_inv.html", "w") or die("Unable to open file!");
//fwrite($myfile, $message);
//fclose($myfile);
//
//$body = file_get_contents("./mail_inv.html");
//
//$mail_id_all   = getActiveEmailOrder();
//foreach ($mail_id_all as $admin_mail){
//    $admin[] = $admin_mail['email_id'];
//}
//
//$admin_tail = implode(';', $admin);
//
//
//echo "mailto:".$customer_email_main."?subject=Order Changed by Admin for Job:".$Order_id."&cc=".$admin_tail; 
?>


