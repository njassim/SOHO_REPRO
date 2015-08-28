<?php
include './admin/config.php';
include './admin/db_connection.php';
include './admin/include/class.phpmailer.php';

//$current_timne = date("Y-m-d h:i:s");
//$date = new DateTime($current_timne, new DateTimeZone('America/New_York'));
//date_default_timezone_set('America/New_York');
//$temp_time1 =  date("Y-m-d h:iA", $date->format('U'));
//$datetime_from = date("h:iP",strtotime("+240 minutes",strtotime($temp_time1)));


if (isset($_POST['user_cart_id'])) {
    
$sql_order_id = mysql_query("SELECT order_sequence FROM sohorepro_order_master ORDER BY id DESC LIMIT 1");
$object_order = mysql_fetch_assoc($sql_order_id);

        if (count($object_order['order_sequence']) > 0) {
            $order_id = ($object_order['order_sequence'] + 1);
        } 
        else{
            $order_id = '900100101';
        }
    
   
        
$user_id          =       $_POST['user_cart_id'];
$company_id       =       $_POST['company_id'];
$company_name     =       getCompName($company_id);
$referece         =       strtoupper($_POST['reference']);
$deleivery_date   =       $_POST['date'];
$comment_ord      =       mysql_real_escape_string($_POST['comment_ord']);

//Funcionality for Auto Load Reference Start.
    $chk_reference    = CheckReference($company_id,$referece);
    if(count($chk_reference) == 0){
    $ref_sql = "INSERT INTO sohorepro_reference SET company_id = '".$company_id."', user_id = '".$user_id."', reference = '".$referece."' ";
    mysql_query($ref_sql);
    }
//Funcionality for Auto Load Reference End.


$sql = "INSERT INTO sohorepro_order_master SET order_number = '".$order_id."',order_sequence = '".$order_id."', order_id     = '" . $referece . "', customer_company = '".$company_id."', customer_company_name = '".$company_name."' , customer_name = '".$user_id."', deleivery_date = '".$deleivery_date."', order_comment = '".$comment_ord."', created_date = now()";
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
    $last_ord_multi = mysql_insert_id();
    } 
}

$order_multi_shipp  = GetOrdIdfromProdMast($last_ord_multi);

$insert_multi_ship   =   SelectProMast($order_multi_shipp);

$nj = 1;
foreach ($insert_multi_ship as $multi_shipp){
    $chech_already_exist = checkMulti($multi_shipp['order_id'],$multi_shipp['shipping_add_id']);
    if(count($chech_already_exist) == '1'){
    $query = "UPDATE sohorepro_multi_shipping SET order_id     = '" . $multi_shipp['order_id'] . "', shipping_id = '" . $multi_shipp['shipping_add_id'] . "', product_id = '" . $multi_shipp['product_id'] . "', item_id = '".$chech_already_exist[0]['item_id'].','.$nj."' WHERE order_id = '".$multi_shipp['order_id']."' AND shipping_id = '".$multi_shipp['shipping_add_id']."' ";   
    mysql_query($query);   
    }  else {
    $query = "INSERT INTO sohorepro_multi_shipping SET order_id     = '" . $multi_shipp['order_id'] . "', shipping_id = '" . $multi_shipp['shipping_add_id'] . "', product_id = '" . $multi_shipp['product_id'] . "', item_id = '".$nj."' ";   
    mysql_query($query);
    }
 $nj++;   
}


//Order to Email
$sql_order_id_mail      = mysql_query("SELECT id,order_id,created_date,order_number,order_comment FROM sohorepro_order_master ORDER BY id DESC LIMIT 1");
$object                 = mysql_fetch_assoc($sql_order_id_mail);
//$user_mail              = UserMail($user_id);
$user_mail_id_txt       = UserMail($user_id);

$user_name              = UserName($user_id);
$comp_id                = COMPID($user_id);               
$company_name           = companyName($comp_id);
$phone                  = companyphone($company_id);
$billing_address        = BillingAddressShippId($comp_id);
$shipp_address          = CompanyAddressMail($billing_address);
$prop                   = PropTest($shipping_id);
$id                     = $object['id'];
$order_id_ret           = $object['id'];  
$Order_id               = $object['order_id'];
$Order_number           = $object['order_number'];
$order_comm             = $object['order_comment'];
//$current_time           = date("Y-m-d h:i:s");
$current_time = $object['created_date'];
$datew = new DateTime($current_time, new DateTimeZone('America/New_York'));
date_default_timezone_set('America/New_York');
$temp_times =  date("Y-m-d h:iA", $datew->format('U'));
//$Date = date("m/d/Y", strtotime($object['created_date'])). ' ' .date("h:iA",strtotime("-0 minutes",strtotime($temp_times)));
$Date                   = date('Y-m-d h:i A', time());              
$view_orders            = viewOrders($id);
$pick_up                = $view_orders[0]['shipping_add_id'];

$returnValue            = html_entity_decode('Your Soho Repro graphics order has been received and will be processed promptly.', ENT_COMPAT, 'ISO-8859-1');

//Add Favorites
$select_pro_fav = checkOut($user_id);


       
foreach ($select_pro_fav as $fav_prod){
    $fav_comp_id = $fav_prod['company_id'];
    $fav_prod_id = $fav_prod['product_id'];
    $check_fav = CHECKFAVEXIXT($fav_comp_id, $fav_prod_id);
    if(count($check_fav) == '0'){
        
        $sql_sort_id        = mysql_query("SELECT sort_id FROM sohorepro_favorites WHERE comp_id = '".$comp_id."' ORDER BY sort_id DESC LIMIT 1");
        $object_order_sort  = mysql_fetch_assoc($sql_sort_id);

        if (count($object_order_sort['sort_id']) > 0) {
            $order_sort_id = ($object_order_sort['sort_id'] + 1);
        } 
        else{
            $order_sort_id = '0';
        }
        
        //$query_fav = mysql_query("INSERT INTO sohorepro_favorites SET usr_id = '".$user_id."', comp_id = '".$fav_comp_id."', product_id = '".$fav_prod_id."', sort_id = '" . $order_sort_id . "' ");
        
        
        $spl_check_fav  =   checkSpecial($fav_cmp_id, $fav_prod_id);
        $spl_prod_fav   =   editPdoructs($fav_prod_id);
        
        $list_price_fav = (count($spl_check_fav) > 0) ? $spl_check_fav[0]['sp_list_price'] : $spl_prod_fav[0]['list_price'];
        $disc_price_fav = (count($spl_check_fav) > 0) ? $spl_check_fav[0]['sp_discount'] : $spl_prod_fav[0]['discount'];
        $sell_price_fav = (count($spl_check_fav) > 0) ? $spl_check_fav[0]['sp_special_price'] : $spl_prod_fav[0]['price'];
        
        $query_fav_list = "INSERT INTO sohorepro_favorites
                                SET     usr_id       = '" . $user_id . "',
                                        comp_id      = '" . $fav_comp_id . "',
                                        product_id   = '" . $fav_prod_id . "',
                                        list_price          = '" . $list_price_fav ."', 
                                        discount_price      = '" . $disc_price_fav ."', 
                                        sell_price          = '" . $sell_price_fav ."',     
                                        sort_id             = '" . $order_sort_id . "'" ;  
        
        $query_fav = mysql_query($query_fav_list);
    }
}



unset($_SESSION['job']);
unset($_SESSION['session_cart']);
unset($_SESSION['session_order']);
unset($_SESSION['cus_count']);
unset($_SESSION['datepicker1']);
unset($_SESSION['ref_val']);
$_SESSION['order_number'] = $Order_number;
$sql                    = "DELETE FROM sohorepro_checkout WHERE user_id = '" . $user_id . "' ";
mysql_query($sql);

$ip = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
$sql_ip = "DELETE FROM sohorepro_checkout_guest WHERE ip = '" . $ip . "' ";
mysql_query($sql_ip);

$sql_cmmt = "DELETE FROM sohorepro_cust_commt WHERE ip = '". $ip . "' ";
$delete_cmmt = mysql_query($sql_cmmt);
$_SESSION['final_ord_id'] = $order_id_ret;

//$query_plotting = "UPDATE sohorepro_plotting_set SET order_id     = '" . $order_id_ret . "', set_serial = '0' WHERE user_id = '".$user_id."' AND company_id = '".$company_id."' AND order_id = '0' ";   
//mysql_query($query_plotting);   
//
//$query_plotting_sets_needed = "UPDATE sohorepro_sets_needed SET order_id     = '" . $order_id_ret . "', ordered = '1', ordered_status = 'Y' WHERE usr_id = '".$user_id."' AND comp_id = '".$company_id."' AND ordered_status = 'N'";   
//mysql_query($query_plotting_sets_needed);   

if($delete_cmmt){
    echo $company_id.'~'.$user_id.'~'.$order_id_ret;
}



$address_3 = ($shipp_address['address_3'] != '') ? $shipp_address['address_3'].'<br>' : '';
$mail = new PHPMailer();

//$message  ='<html>';
//$message .='<head>';
//$message .='<title></title>';
//$message .='<meta content="text/html;charset=iso-8859-1" http-equiv="Content-Type">';
//$message .='</head>';
//$message .='<body>';
//$message .= '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
//$message .= '<table width="780" border="0" cellspacing="0" cellpadding="0">';
//$message .= '<tr><td style="color:#FFF;" bgcolor="#FFF">Sohorepro ACK</td></tr>';
//$message .= '</table>';
//$message .= '<table width="780" border="0" cellspacing="0" cellpadding="0" class="padd">';
//$message .= '<tr bgcolor="#ff7e00">';
//$message .= '<td width="10" height="10" align="left" valign="top"></td>';
//$message .= '<td height="10" align="left" valign="top"></td>';
//$message .= '<td width="10" height="10" align="left" valign="top"></td>';
//$message .= '</tr>';
//$message .= '<tr>';
//$message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
//$message .= '<td align="left" valign="top"><table width="760" border="0" cellspacing="0" cellpadding="0">';
//$message .= '<tr>';
//$message .= '<td width="20" height="20" align="left" valign="top"></td>';
//$message .= '<td height="20" align="left" valign="top"></td>';
//$message .= '<td width="20" height="20" align="left" valign="top"></td>';
//$message .= '</tr>';
//$message .= '<tr>';
//$message .= '<td width="20" align="left" valign="top"></td>';
//$message .= '<td align="left" valign="top"><table width="740" border="0" cellspacing="0" cellpadding="0">';
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
//$multi              = MultiShippingAddress($order_id_ret);
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
//$message .= '<tr><td>';
//$message .= '<table align="left">';
//for ($m = 0; $m<count($address_for_items_pre); $m+=3)
//{
//    $message.= '<tr>
//                <td>'.$address_for_items_pre[$m].'</td>
//                <td>'.$address_for_items_pre[$m+1].'</td>
//                <td>'.$address_for_items_pre[$m+2].'</td>
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
//    $rowColor   = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
//    $rowColor1  = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
//    $prod_id    = $ord['product_id'];
//    $shipping   = SelectAllAddress($ord['shipping_add_id']);
//    $id = $ord['id'];    
//$message .= '<tr>';
//$message .= '<td width="40" align="left" valign="middle" bgcolor="'.$rowColor1.'" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;padding-left:20px;">'.$i.'</td>';
//$message .= '<td width="400" align="center" valign="middle" bgcolor="'.$rowColor.'" style="border-right:1px solid #fff; border-bottom:1px solid #fff; padding:7px 0px;">'.getorderProd($prod_id).'</td>';
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
//echo $final_html;



}

