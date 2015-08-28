<?php
include './admin/config.php';
include './admin/db_connection.php';

if (isset($_POST['quantity']) && $_POST['quantity'] != '') {
    $id                 =       $_POST['id'];
    $quantity           =       $_POST['quantity'];
    $query = "UPDATE sohorepro_checkout SET quantity = '".$quantity."' WHERE id = '" . $id . "'";
    mysql_query($query);
    $select         = "SELECT * FROM sohorepro_checkout WHERE id = '".$id."' ";
    $res            = mysql_query($select);
    $object         = mysql_fetch_assoc($res);
    $unit_price     = $object['unit_price'];
    $user_id        = $object['user_id'];
    $comp_id        = $object['company_id'];
    $line_price     = number_format(($quantity * $unit_price), 2, '.', '');
    $price = getPriceCkt($user_id);
    $sub_total      = '$'.number_format($price[0]['sub_total'], 2, '.', '');
    $tax_status = getTaxStatusChk($comp_id);
    $tax_value = TaxValue();
    if($tax_status == '1')
    {
    $tax_line = '0'; 
    }  else {    
    $tax_line = $tax_value; 
    }
    $tax_cal             = ($tax_line * ($price[0]['sub_total']/100));
    $tax                 = '$' .number_format($tax_cal, 2, '.', '');    
    $grand_tot_cal       = ($price[0]['sub_total'] + $tax_cal); 
    $grand_tot           = '$' .number_format($grand_tot_cal, 2, '.', '');
    $cart_val            = totalCart($user_id);
    echo $line_price.'~'.$sub_total.'~'.$tax.'~'.$grand_tot.'~'.$cart_val;
}


if (isset($_POST['address_id']) && $_POST['address_id'] != '') {
    $id             =  $_POST['address_id'];  
    $product_id     =  $_POST['product_id'];
    $user_id        =  $_POST['user_id'];
    
    $select_comp_id = "SELECT * FROM sohorepro_checkout WHERE user_id = '".$user_id."'";
    $res_add_id     = mysql_query($select_comp_id);
    $object_add     = mysql_fetch_assoc($res_add_id); 
    $add_id         = $object_add['shipping_add_id'];  
    $comp_id        = $object_add['company_id']; 
    
    if($add_id != '0') {
    $update_address =  "UPDATE sohorepro_checkout SET shipping_add_id = '".$id."' WHERE product_id = '".$product_id."'";
    mysql_query($update_address);   
    }else{
     $update_address =  "UPDATE sohorepro_checkout SET shipping_add_id = '".$id."' WHERE user_id = '".$user_id."'";
    mysql_query($update_address);   
    }
    $select         = "SELECT * FROM sohorepro_address WHERE id = '".$id."' ";
    $res            = mysql_query($select);
    $object         = mysql_fetch_assoc($res); 
    $comp_name      = $object['company_name'];
    $shipping_address = ShippingAddressAll($comp_id);
    $shipping_size    = count($shipping_address);
    echo $comp_name.'</br>'.$object['attention_to'].'</br>'.$object['address_1'].'</br>'.$object['address_2'].'</br>'.$object['address_3'].'</br>'.$object['city'].',  '.StateName($object['state']).',  '.$object['zip'].'~';
}


if (isset($_POST['usr_name_chk']) && $_POST['usr_name_chk'] != '') {
    
    $reference    = $_POST['reference'];
    $user_name    = $_POST['usr_name_chk'];
    $user_pass    = $_POST['usr_pass_chk'];
    
    $check_user = CheckCusUser($user_name,$user_pass);
    if(count($check_user) > 0)
    {
    $_SESSION['sohorepro_userid']       = $check_user[0]['cus_id'];
    $_SESSION['sohorepro_companyid']    = $check_user[0]['cus_compname']; 
    $_SESSION['sohorepro_username']     = $check_user[0]['cus_contact_name']; 
    $ip                                 = md5($_SERVER['HTTP_USER_AGENT'] .  $_SERVER['REMOTE_ADDR']);
    $items_guest  = ItemsTemp($ip);
    foreach ($items_guest as $items){
            $unit_prc = ProdPriceForAdd($items['product_id']);
            $query  = "INSERT INTO sohorepro_checkout SET product_id     = '" . $items['product_id'] . "', quantity = '" . $items['quantity'] . "', unit_price = '" . $unit_prc . "', user_id = '" . $check_user[0]['cus_id'] . "', staff_id = '0', company_id = '" . $check_user[0]['cus_compname'] . "', reference = '" . $reference . "', shipping_add_id = '0' ";
            mysql_query($query);
            }            
    $query      = "DELETE FROM sohorepro_checkout_guest WHERE ip = '".$ip."' ";
    $res = mysql_query($query);       
        if($res){
        echo '1';
        }
    }  else {
    echo '0';    
    }
    
    
}
?>
