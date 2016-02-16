<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);


if (isset($_POST['shipping_id_rp_1']) && $_POST['shipping_id_rp_1'] != '') {
    
    $shipp_address_id = $_POST['shipping_id_rp_1'];
    
    if(($shipp_address_id != 'P1') && ($shipp_address_id != "P2")){
        $cust_add = getCustomeInfo($shipp_address_id);        
        $cust_add_2 = ($cust_add[0]['comp_business_address2'] != '') ? $cust_add[0]['comp_business_address2']. '<br>'  : '';                    
        echo $cust_add[0]['comp_name'] . '<br>' . $cust_add[0]['comp_business_address1'] . '<br>' . $cust_add_2 . $cust_add[0]['comp_city'] . '&nbsp;' . $cust_add[0]['comp_state'] . '&nbsp;' . $cust_add[0]['comp_zipcode'].'<br>'.$cust_add[0]['comp_contact_phone']."~".$cust_add[0]['comp_contact_name'];
    }  else {
        $pic_address = AddressBookPickupSohoCap($shipp_address_id);  
        echo $pic_address[0]['address'];
    }
    
}elseif (isset($_POST['shipping_id_rp_2']) && $_POST['shipping_id_rp_2'] != '') {
    
    $shipp_address_id = $_POST['shipping_id_rp_2'];
    
    if(($shipp_address_id != 'P1') && ($shipp_address_id != "P2")){
        $cust_add = AddressBookCompanyService_option2($shipp_address_id);        
        $cust_add_2 = ($cust_add[0]['address_2'] != '') ? $cust_add[0]['address_2']. '<br>'  : '';    
        $cust_add_3 = ($cust_add[0]['address_3'] != '') ? $cust_add[0]['address_3']. '<br>'  : '';   
        echo $cust_add[0]['address_1'] . '<br>' . $cust_add_2.$cust_add_2 . $cust_add[0]['city'] . '&nbsp;' . StateName($cust_add[0]['state']) . '&nbsp;' . $cust_add[0]['zip'].'<br>'.$cust_add[0]['phone']."~".$cust_add[0]['attention_to'];
    }  else {
        $pic_address = AddressBookPickupSohoCap($shipp_address_id);  
        echo $pic_address[0]['address'];
    }
}

