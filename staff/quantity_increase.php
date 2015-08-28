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
    $line_price     = number_format(($quantity * $unit_price), 2, '.', '');
    $price = getPriceCkt($user_id);
    $sub_total      = '$'.number_format($price[0]['sub_total'], 2, '.', '');
    $tax_status = getTaxStatusChk($user_id);
    if($tax_status == '1')
    {
    $tax_line = '8.875';    
    }  else {
    $tax_line = '0';       
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



if (isset($_POST['staff_id_del']) && $_POST['staff_id_del'] != '') {
    $id             =  $_POST['staff_id_del'];
    $sql            = "DELETE FROM sohorepro_checkout WHERE staff_id = " . $id . " ";
    $result         = mysql_query($sql);
    if($result){
        echo '1';
    }  else {
        echo '0';
    }
    
}


?>
