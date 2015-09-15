<?php

include './config.php';
include './mail_template.php';

if (isset($_POST['pc_id']) && $_POST['pc_id'] != '') {
    $pc_id = $_POST['pc_id'];
    $pc_id = mysql_real_escape_string($pc_id);
    $query = "select * from sohorepro_category where parent_id ='" . $pc_id . "'";
    $res = mysql_query($query);
    if (mysql_num_rows($res)) {
        echo "<option value='0'>Select Sub Category</option>";
        while ($row = mysql_fetch_array($res)) {
            echo "<option value='" . $row['id'] . "'>" . ucfirst($row['category_name']) . "</option>";
        }
    }
}


if (isset($_POST['pcj_id']) && $_POST['pcj_id'] != '') {
    $pc_id = $_POST['pcj_id'];
    $pc_id = mysql_real_escape_string($pc_id);
    $query = "select * from sohorepro_category where parent_id ='" . $pc_id . "'";
    $res = mysql_query($query);
    if (mysql_num_rows($res)) {
        echo "<option value='0'>Select Sub Category</option>";
        while ($row = mysql_fetch_array($res)) {
            echo "<option value='" . $row['id'] . "'>" . ucfirst($row['category_name']) . "</option>";
        }
    }
}


if (isset($_POST['super_id']) && $_POST['super_id'] != '') {
    $super_id = $_POST['super_id'];
    $id = mysql_real_escape_string($super_id);
    $query = "select * from sohorepro_category where super_id ='" . $id . "' AND parent_id = '0'";
    $res = mysql_query($query);
    if (mysql_num_rows($res)) {
        while ($row = mysql_fetch_array($res)) {
            echo "<option value='" . $row['id'] . "'>" . ucfirst($row['category_name']) . "</option>";
        }
    }
}

if (isset($_POST['super_id_prod']) && $_POST['super_id_prod'] != '') {
    $super_id = $_POST['super_id_prod'];
    $id = mysql_real_escape_string($super_id);
    $query = "select * from sohorepro_category where super_id ='" . $id . "' AND parent_id = '0'";
    $res = mysql_query($query);
    if (mysql_num_rows($res)) {
        echo "<option value='0'>Select Category</option>";
        while ($row = mysql_fetch_array($res)) {
            echo "<option value='" . $row['id'] . "'>" . ucfirst($row['category_name']) . "</option>";
        }
    }
//  $queryP = "SELECT * FROM sohorepro_products WHERE supercategory_id = '".$id."' AND category_id = '0' AND subcategory_id = '0'";
//  $resP = mysql_query($queryP);
//  if(mysql_num_rows($resP))
//  {    
//        
//    while($row = mysql_fetch_array($resP))
//	{	
//        echo "#<option value='".$row['id']."'>".ucfirst($row['product_name'])."</option>".'#'."<option value='".$row['price']."'>".ucfirst($row['price'])."</option>";
//	}    
//  }
//  else
//  {
//      echo "#<option value='0'>Select Product</option>#<option value='0'>Select Price</option>"; 
//  }
}

if (isset($_POST['super_id_sub_prod']) && $_POST['super_id_sub_prod'] != '') {
    $super_id = $_POST['super_id_sub_prod'];
    $cate_id = $_POST['cate_id'];
    $id = mysql_real_escape_string($super_id);
    $query = "select * from sohorepro_category where super_id ='" . $id . "' AND parent_id = '" . $cate_id . "'";
    $res = mysql_query($query);
    if (mysql_num_rows($res)) {
        echo "<option value='0'>Select Subcategory</option>";
        while ($row = mysql_fetch_array($res)) {
            echo "<option value='" . $row['id'] . "'>" . ucfirst($row['category_name']) . "</option>";
        }
    }
}

if (isset($_POST['scate_id']) && $_POST['scate_id'] != '') {
    $super_id = $_POST['super_id_j'];
    $cate_id = $_POST['category_j'];
    $scate_id = $_POST['scate_id'];
    $id = mysql_real_escape_string($super_id);
    $queryj = "SELECT * FROM sohorepro_products WHERE supercategory_id = '" . $id . "' AND category_id= '" . $cate_id . "' AND subcategory_id = '" . $scate_id . "'";
    $resj = mysql_query($queryj);
    if (mysql_num_rows($resj)) {

        while ($row = mysql_fetch_array($resj)) {
            echo "#<option value='" . $row['id'] . "'>" . ucfirst($row['product_name']) . "</option>" . '#' . "<option value='" . $row['price'] . "'>" . ucfirst($row['price']) . "</option>";
        }
    }
}


if (isset($_POST['c_id']) && $_POST['c_id'] != '') {
    $ca_id = $_POST['c_id'];
    $sc_id = $_POST['sc_id'];
    $su_id = $_POST['su_id'];
    $c_id = mysql_real_escape_string($ca_id);
    $s_id = mysql_real_escape_string($sc_id);
    $super_id = mysql_real_escape_string($su_id);
    $query = "SELECT product_name,id FROM `sohorepro_products` where subcategory_id = '" . $s_id . "'";
    $res = mysql_query($query);
    if (mysql_num_rows($res)) {

        while ($row = mysql_fetch_array($res)) {
            echo "<option value='" . $row['id'] . "'>" . ucfirst($row['product_name']) . "</option>";
        }
    }
}




if (isset($_POST['price']) && $_POST['price'] != '') {

    $product_test = str_replace("''", '"', $_POST['product']);
    $product = mysql_real_escape_string($product_test);
    $qty = $_POST['qty'];
    $price = $_POST['price'];
    $id = $_POST['id'];
    $iid = $_POST['iid'];
    $order_id = $_POST['order_id'];
    $query = "UPDATE sohorepro_product_master
			SET     product_name            = '" . $product . "',                               
				product_quantity        = '" . $qty . "',
                                product_price           = '" . $price . "' WHERE id = '" . $id . "' AND product_id = '" . $iid . "'";
    $sql_result = mysql_query($query);
    $sql_data = mysql_query("SELECT product_name,product_quantity,product_price,tax_status,order_id FROM sohorepro_product_master WHERE id = '" . $id . "' AND product_id = '" . $iid . "'");
    $object = mysql_fetch_assoc($sql_data);
    $select_price = "SELECT sum(product_price * product_quantity) as sub_total FROM sohorepro_product_master WHERE order_id = '" . $order_id . "'";
    $price_order = mysql_query($select_price);
    $object_tot = mysql_fetch_assoc($price_order);
    $comp_id = CompIdWithOrder($object['order_id']);
    $tax_status = getTaxStatusChk($comp_id);
    $tax_value = TaxValue();
    if ($tax_status == '1') {
        $tax_line = '0';
    } else {
        $tax_line = $tax_value;
    }
    $tax = number_format(($tax_line * ($object_tot['sub_total'] / 100)), 2, '.', '');
    $grand_tot = number_format(($object_tot['sub_total'] + $tax), 2, '.', '');
    $sub_total = number_format($object_tot['sub_total'], 2, '.', '');
    $line = number_format(($object['product_quantity'] * $object['product_price']), 2, '.', '');
    if ($sql_result) {
        echo $object['product_name'] . '~' . $object['product_quantity'] . '~' . $object['product_price'] . '~' . $object['tax_status'] . '~' . $grand_tot . '~' . $tax . '~' . $sub_total . '~' . '$' . $line;
    } else {
        echo "Order changed not successfully";
    }
}



if (isset($_POST['reference']) && $_POST['reference'] != '') {

    $reference = strtoupper($_POST['reference']);
    $id = $_POST['id'];
    $query = "UPDATE sohorepro_order_master
			SET     order_id = '" . $reference . "' WHERE id = '" . $id . "'";
    $sql_result = mysql_query($query);
    if ($sql_result) {
        echo $reference;
    } else {
        echo "Order changed not successfully";
    }
}

if (isset($_POST['list_price']) && $_POST['list_price'] != '') {
    $id = $_POST['id'];
    $list_price = $_POST['list_price'];
    $discount = $_POST['discount'];
    $price = number_format(($discount * ($list_price / 100)), 2, '.', '');
    $special_price = ($list_price - $price);
    $special = number_format(($special_price), 2, '.', '');
    $discount_return = number_format(($_POST['discount']), 2, '.', '');
    $query = "UPDATE sohorepro_special_pricing
			SET     sp_list_price       = '" . $list_price . "',
                                sp_discount         = '" . $discount . "',
                                sp_special_price    = '" . $special . "'
                            WHERE sp_id = '" . $id . "'";
    $sql_result = mysql_query($query);
    if ($sql_result) {
        echo $list_price . '#' . $discount_return . '#' . $special;
    } else {
        echo "Product changed not successfully";
    }
}


if (isset($_POST['mail_id']) && !empty($_POST['mail_id'])) {
    $mail_id = $_POST['mail_id'];
    $mail_name = $_POST['mail_name'];
    $query = "select * from sohorepro_email where email_id = '$mail_id'";
    $val_mail = mysql_query($query);
    $num_rows = mysql_num_rows($val_mail);
    if ($num_rows > 0) {
        echo 'EXIST';
    } else {
        $sql = "INSERT INTO sohorepro_email
			SET     name = '" . $mail_name . "',
                                email_id = '" . $mail_id . "',
				status = '1' ";

        $sql_result = mysql_query($sql);
        echo 'INSERTED';
    }
}

if (isset($_POST['reg_email_id']) && !empty($_POST['reg_email_id'])) {
    $mail_id = $_POST['reg_email_id'];
    $query = "select * from sohorepro_customers where cus_email = '$mail_id'";
    $val_mail = mysql_query($query);

    $object_customer = mysql_fetch_assoc($val_mail);
    $comp_id = $object_customer['cus_compname'];

    $query_company = "SELECT * FROM sohorepro_company WHERE comp_id = '" . $comp_id . "' AND status = '1'";
    $val_company = mysql_query($query_company);
    $num_company = mysql_num_rows($val_company);

    $num_rows = mysql_num_rows($val_mail);


    $query_comp = "select * from sohorepro_company where comp_contact_email = '$mail_id'";
    $val_mail_comp = mysql_query($query_comp);
    $num_rows_comp = mysql_num_rows($val_mail_comp);

    if ($num_rows == 0) {
        echo 'true';
    } else {
        echo 'false';
    }
}

if (isset($_POST['reg_contactmail']) && !empty($_POST['reg_contactmail'])) {
    $mail_id = $_POST['reg_contactmail'];
    $query = "select * from sohorepro_customers where cus_email = '$mail_id'";
    $val_mail = mysql_query($query);
    $num_rows = mysql_num_rows($val_mail);

    $query_comp = "select * from sohorepro_company where comp_contact_email = '$mail_id'";
    $val_mail_comp = mysql_query($query_comp);
    $num_rows_comp = mysql_num_rows($val_mail_comp);

    if (($num_rows_comp == 0)) {
        echo 'true';
    } else {
        echo 'false';
    }
}



if (isset($_POST['sequence_id']) && $_POST['sequence_id'] != '') {
    $id = $_POST['sequence_id'];
    $sequence = $_POST['sequence'];
    $query = "UPDATE sohorepro_order_master
			SET     order_sequence       = '" . $sequence . "'
                                WHERE id = '" . $id . "'";
    $sql_result = mysql_query($query);
    if ($sql_result) {
        echo 'Order Sequence Successfully Changed' . '~' . $sequence;
    } else {
        echo "Order Sequence not changed";
    }
}


if (isset($_POST['tax_val_fix']) && $_POST['tax_val_fix'] != '') {
    $tax_val = $_POST['tax_val_fix'];
    $query = "UPDATE sohorepro_tax_rate
			SET     tax_rate       = '" . $tax_val . "'
                                WHERE id = '1' ";
    $sql_result = mysql_query($query);
    if ($sql_result) {
        echo 'Tax Rate Successfully Changed' . '~' . $tax_val;
    } else {
        echo "Tax Rate not changed";
    }
}



if (isset($_POST['super_id_filter']) && $_POST['super_id_filter'] != '') {
    echo '1';
}

if (isset($_POST['search_prod']) && $_POST['search_prod'] != '') {
    echo '1';
}


if (isset($_POST['list_price_product']) && $_POST['list_price_product'] != '') {
    $id = $_POST['id'];
    $list = $_POST['list_price_product'];
    $discount = $_POST['discount_product'];
    $selling = $_POST['selling_product'];
    $prod_name = mysql_real_escape_string($_POST['prd_name']);
    $query = "UPDATE sohorepro_products
			SET     product_name     = '" . $prod_name . "',
                                list_price       = '" . $list . "',
                                discount         = '" . $discount . "',
                                price            = '" . $selling . "'
                                WHERE id         = '$id' ";
    $sql_result = mysql_query($query);

    $select_prd = "SELECT product_name,discount FROM sohorepro_products WHERE id = '" . $id . "'";
    $prd = mysql_query($select_prd);
    $object_prd = mysql_fetch_assoc($prd);


    if ($sql_result) {
        echo 'Successfully updated' . '~' . '$' . $list . '~' . $object_prd['discount'] . '~' . '$' . $selling . '~' . $object_prd['product_name'];
    } else {
        echo "Updated not successfully";
    }
}


if (isset($_POST['product_qty']) && $_POST['product_qty'] != '') {
    $product_id = $_POST['id'];
    $order_id = $_POST['order_id'];
    $exist_qty = ExistQuantity($product_id, $order_id);
    $quantity = ($_POST['product_qty'] + $exist_qty);
    $exist_product = ExistProductOrder($product_id, $order_id);
    if ($exist_product < 1) {
        $query = "INSERT INTO sohorepro_products_order_temp
			SET     product_id       = '" . $product_id . "',
                                product_quantity  = '" . $quantity . "',
                                order_id         = '" . $order_id . "' ";
        $query_delete = "DELETE FROM sohorepro_product_master WHERE product_id = '" . $product_id . "' AND order_id = '" . $order_id . "' ";
        mysql_query($query_delete);
    } else {
        $query = "UPDATE sohorepro_products_order_temp
			SET     product_quantity  = '" . $quantity . "' WHERE
                                product_id       = '" . $product_id . "'  AND 
                                order_id         = '" . $order_id . "' ";
//$query_delete = "DELETE FROM sohorepro_product_master WHERE product_id = '".$product_id."' AND order_id = '".$order_id."' ";
    }
    $sql_result = mysql_query($query);
    if ($sql_result) {
        echo '1';
    } else {
        echo '0';
    }
}


if (isset($_POST['delete_order_id']) && $_POST['delete_order_id'] != '') {
    $order_id = $_POST['delete_order_id'];
    $query = "DELETE FROM sohorepro_products_order_temp WHERE order_id = '" . $order_id . "' ";
    $sql_result = mysql_query($query);
    if ($sql_result) {
        echo '1';
    } else {
        echo '0';
    }
}

function get_client_ip() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if ($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if ($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if ($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if ($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if ($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

if (isset($_POST['guest_qty']) && $_POST['guest_qty'] != '') {
    $product_id = $_POST['id'];
    $qty = ($_POST['guest_qty'] == '') ? '0' : $_POST['guest_qty'];
    $guest_price = $_POST['guest_price'];
    $ip = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
//$ip            = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $exist_qty = ExistQuantityGuest($product_id, $ip);
    $quantity = $qty;
    $query_jas = "DELETE FROM sohorepro_checkout_guest WHERE ip = '" . $ip . "' AND product_id = '" . $product_id . "' ";
    mysql_query($query_jas);
    $exist_product = ExistProductOrderGuest($product_id, $ip);
    if ($exist_product < 1) {
        $query = "INSERT INTO sohorepro_checkout_guest
			SET     product_id       = '" . $product_id . "',
                                quantity         = '" . $qty . "',
                                unit_price       = '" . $guest_price . "',
                                ip               = '" . $ip . "' ";
    } else {
        $query = "UPDATE sohorepro_checkout_guest
			SET     quantity         = '" . $quantity . "',
                                unit_price       = '" . $guest_price . "' WHERE
                                product_id       = '" . $product_id . "'  AND 
                                ip               = '" . $ip . "' ";
    }
    $sql_result = mysql_query($query);
    if ($sql_result) {
        echo '1';
    } else {
        echo '0';
    }
}


if (isset($_POST['guest_qty_fav']) && $_POST['guest_qty_fav'] != '') {
    $product_id = $_POST['id_fav'];
    $qty = ($_POST['guest_qty_fav'] == '') ? '0' : $_POST['guest_qty_fav'];
    $guest_price = $_POST['guest_price_fav'];
    $ip = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
//$ip            = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $exist_qty = ExistQuantityGuest($product_id, $ip);
    $quantity = (count($exist_qty) > 0) ? ($exist_qty + $qty) : $exist_qty;
    $exist_product = ExistProductOrderGuest($product_id, $ip);
    if ($exist_product < 1) {
        $query = "INSERT INTO sohorepro_checkout_guest
			SET     product_id       = '" . $product_id . "',
                                quantity         = '" . $qty . "',
                                unit_price       = '" . $guest_price . "',
                                ip               = '" . $ip . "' ";
    } else {
        $query = "UPDATE sohorepro_checkout_guest
			SET     quantity         = '" . $quantity . "',
                                unit_price       = '" . $guest_price . "' WHERE
                                product_id       = '" . $product_id . "'  AND 
                                ip               = '" . $ip . "' ";
    }
    $sql_result = mysql_query($query);
    if ($sql_result) {
        echo '1';
    } else {
        echo '0';
    }
}


//if ($_POST['guest_qty'] == '') {    
//$product_id = $_POST['id'];
//$ip = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']); 
//$query = "DELETE FROM sohorepro_checkout_guest WHERE ip = '" . $ip . "' AND product_id = '" . $product_id . "' ";     
//$sql_result = mysql_query($query);
//if ($sql_result) {
//echo '1';
//} else {
//echo '0';
//}   
//}
//User name Check for Users Tab
if (isset($_POST['user_name_ext']) && $_POST['user_name_ext'] != '') {
    $user_name = $_POST['user_name_ext'];
    $query = "SELECT user_name FROM sohorepro_users WHERE user_name = '" . $user_name . "' ";
    $sql_result = mysql_query($query);
    if (mysql_num_rows($sql_result) > 0) {
        echo '1';
    } else {
        echo '0';
    }
}

//Reference Value Set
if (isset($_POST['referece_set_fav']) && $_POST['referece_set_fav'] != '') {
    $_SESSION['ref_val'] = $_POST['referece_set_fav'];
}

if (isset($_POST['usr_name_chk']) && $_POST['usr_name_chk'] != '') {

    $reference = $_POST['reference_login'];
    $user_name = $_POST['usr_name_chk'];
    $user_pass = $_POST['usr_pass_chk'];


    $user_login = UserLogin($user_name, $user_pass);
    $chk_cus_status = CheckCusStatus($user_login[0]['cus_compname']);


    if ((count($user_login[0]) > 0)) {
        $_SESSION['sohorepro_userid'] = $user_login[0]['cus_id'];
        $_SESSION['sohorepro_companyid'] = $user_login[0]['cus_compname'];
        $_SESSION['sohorepro_username'] = $user_login[0]['cus_contact_name'];
        $ip = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
        $items_guest = ItemsTemp($ip);
        foreach ($items_guest as $items) {
            $check_spl_price = GetSplPriceProduct($items['product_id'], $user_login[0]['cus_compname']);
            $unit_prc = (count($check_spl_price) == '') ? ProdPriceForAdd($items['product_id']) : GetSplPriceProduct($items['product_id'], $user_login[0]['cus_compname']);

            $query = "INSERT INTO sohorepro_checkout SET product_id     = '" . $items['product_id'] . "', quantity = '" . $items['quantity'] . "', unit_price = '" . $unit_prc . "', user_id = '" . $user_login[0]['cus_id'] . "', staff_id = '0', company_id = '" . $user_login[0]['cus_compname'] . "', reference = '" . $reference . "', shipping_add_id = '0' ";
            $res = mysql_query($query);
        }
        $query = "DELETE FROM sohorepro_checkout_guest WHERE ip = '" . $ip . "' ";
        mysql_query($query);
        if ($res) {
            echo '1';
        }
    } else {
        
    }
}


if (isset($_POST['order_notification']) && !empty($_POST['order_notification'])) {
    $order_notification_id = $_POST['order_notification_id'];
    $query = "select * from sohorepro_email where id = '$order_notification_id'";
    $val_order = mysql_query($query);
    $object = mysql_fetch_assoc($val_order);
    $orders_val = ($object['orders'] == '1') ? '0' : '1';
    $sql = "UPDATE sohorepro_email
			SET    orders = '" . $orders_val . "' WHERE id = '" . $order_notification_id . "' ";
    $res = mysql_query($sql);
    if ($res) {
        echo '1';
    } else {
        echo '0';
    }
}


if (isset($_POST['account_notification']) && !empty($_POST['account_notification'])) {
    $account_notification_id = $_POST['account_notification_id'];
    $query = "select * from sohorepro_email where id = '$account_notification_id'";
    $val_account = mysql_query($query);
    $object = mysql_fetch_assoc($val_account);
    $accounts_val = ($object['accounts'] == '1') ? '0' : '1';
    $sql = "UPDATE sohorepro_email
			SET   accounts = '" . $accounts_val . "' WHERE id = '" . $account_notification_id . "' ";
    $res = mysql_query($sql);
    if ($res) {
        echo '1';
    } else {
        echo '0';
    }
}


if (isset($_POST['help_notification']) && !empty($_POST['help_notification'])) {
    $help_notification_id = $_POST['help_notification_id'];
    $query = "select * from sohorepro_email where id = '$help_notification_id'";
    $val_account = mysql_query($query);
    $object = mysql_fetch_assoc($val_account);
    $help_val = ($object['help'] == '1') ? '0' : '1';
    $sql = "UPDATE sohorepro_email
			SET   help = '" . $help_val . "' WHERE id = '" . $help_notification_id . "' ";
    $res = mysql_query($sql);
    if ($res) {
        echo '1';
    } else {
        echo '0';
    }
}


if (isset($_POST['cus_commt']) && !empty($_POST['cus_commt'])) {
    $cus_commt = mysql_real_escape_string($_POST['cus_commt']);
    $cus_commt_id = $_POST['cus_commt_id'];
    $_SESSION['cus_count'] = $_POST['cus_count'];
    $ip = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
    $exist_comment = OrderCommentShopp($cus_commt_id, $ip);
    if ($exist_comment < 1) {
        $query = "INSERT INTO sohorepro_cust_commt
			SET     cus_id       = '" . $cus_commt_id . "',
                                ip           = '" . $ip . "',
                                comment      = '" . $cus_commt . "',
                                status       = '1' ";
    } else {
        $query = "UPDATE sohorepro_cust_commt
			SET     comment      = '" . $cus_commt . "', 
                                status       = '1' WHERE 
                                cus_id       = '" . $cus_commt_id . "' AND ip = '" . $ip . "' ";
    }
    $res = mysql_query($query);
    if ($res) {
        echo '1';
    } else {
        echo '0';
    }
}

if (isset($_POST['datepicker1']) && $_POST['datepicker1'] != '') {

    $_SESSION['datepicker1'] = $_POST['datepicker1'];
}


//User name Check for Users Tab
if (isset($_POST['session_cart']) && $_POST['session_cart'] != '') {
    unset($_SESSION['session_cart']);
    unset($_SESSION['session_order']);
    $session_cart = $_POST['session_cart'];
    $session_order = $_POST['session_order'];
    $_SESSION['session_cart'] = ($session_cart != '') ? $session_cart : '0';
    $_SESSION['session_order'] = ($session_order != '') ? $session_order : '0.00';
    echo $_SESSION['session_cart'];
}



//Updated Email Send
if (isset($_POST['update_email_ord_id']) && $_POST['update_email_ord_id'] != '') {
    $update_email_ord_id = $_POST['update_email_ord_id'];
    $update_email_ship_id = $_POST['update_email_ship_id'];
    $short_msg = mysql_real_escape_string($_POST['short_msg']);
    $mail_alert = ExtraProductsInOrder($update_email_ord_id, $update_email_ship_id, $short_msg);
    if ($mail_alert) {
        echo '1';
    } else {
        echo '';
    }
}



//Select User for supply Store
if (isset($_POST['customer_id_select']) && $_POST['customer_id_select'] != '') {
    $company_name = $_POST['customer_id_select'];
    $comp_id = compName($company_name);
    $query = "select * from sohorepro_customers where cus_compname ='" . $comp_id . "' AND cus_status = '1'";
    $res = mysql_query($query);
    if (mysql_num_rows($res)) {
        while ($row = mysql_fetch_array($res)) {
            if ($row['cus_id'] == $_SESSION['supply_usr_id']) {
                echo "<option value='" . $row['cus_id'] . "' selectet='selected'>" . ucfirst($row['cus_contact_name']) . "</option>";
            } else {
                echo "<option value='" . $row['cus_id'] . "'>" . ucfirst($row['cus_contact_name']) . "</option>";
            }
        }
        echo "<option value='N'>New User</option>";
    }
}



//Close the Order
if (isset($_POST['customer_id_edit']) && $_POST['customer_id_edit'] != '') {
    $company_name = $_POST['customer_id_edit'];
    $user_id = $_POST['user_id_edit'];
    $order_id = $_POST['order_id_edit'];
    $company_id = compName($company_name);
    $query = "UPDATE sohorepro_order_master SET customer_name = '" . $user_id . "', customer_company = '" . $company_id . "', time = NOW()  WHERE id = '" . $order_id . "' ";
    $sql_result = mysql_query($query);
    if ($sql_result) {
        echo '1';
    } else {
        echo '0';
    }
}

if (isset($_POST['admin_add1']) && $_POST['admin_add1'] != '') {
    $add1 = $_POST['admin_add1'];
    $add2 = $_POST['add2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $comp_id = $_POST['comp_ID'];
    $comp_id_check = ShippingAddressAllForGuest($comp_id);
    if ($comp_id_check > 0) {
        $address_insert = "UPDATE sohorepro_address SET address_1 = '" . $add1 . "', address_2= '" . $add2 . "', city = '" . $city . "', state = '" . $state . "', zip = '" . $zip . "' WHERE comp_id = '" . $comp_id . "' ";
        $result = mysql_query($address_insert);
    } else {
        $address_insert = "INSERT INTO sohorepro_address SET address_1 = '" . $add1 . "', address_2= '" . $add2 . "', city = '" . $city . "', state = '" . $state . "', zip = '" . $zip . "', comp_id = '" . $comp_id . "' ";
        $result = mysql_query($address_insert);
    }
    if ($result) {
        echo '1';
    } else {
        echo '0';
    }
}


//Unlink Invoice
if (isset($_POST['unlink_order_id']) && $_POST['unlink_order_id'] != '') {
    $order_id = $_POST['unlink_order_id'];
    $file_location = './cart_invoice_tmpl/invoice_' . $order_id . '.html';
    $result = unlink($file_location);
    if ($result) {
        echo '1';
    } else {
        echo '0';
    }
}


//Unlink Invoice
if (isset($_POST['del_fav_front_id']) && $_POST['del_fav_front_id'] != '') {
    $del_fav_front_id = $_POST['del_fav_front_id'];
    $del_fav_front_comp_id = $_POST['del_fav_front_comp_id'];
    $check_del_item = CheckDelItem($del_fav_front_id);
    $del_value = ($check_del_item == '1') ? '0' : '1';
    $delete_fav = "UPDATE sohorepro_favorites SET delete_id = '" . $del_value . "' WHERE id = '" . $del_fav_front_id . "' ";
    $result = mysql_query($delete_fav);
    $count_fav_comp = CountFavComp($del_fav_front_comp_id);
    if (count($count_fav_comp) > 0) {
        echo '1';
    } else {
        echo '0';
    }
}


//Delete Favorites
if (isset($_POST['fav_item_delete_comp']) && $_POST['fav_item_delete_comp'] != '') {
    $fav_item_delete_comp = $_POST['fav_item_delete_comp'];
    $delete_fav = "DELETE FROM sohorepro_favorites WHERE comp_id = '" . $fav_item_delete_comp . "' AND delete_id = '1' ";
    $result = mysql_query($delete_fav);
    if ($result) {
        echo '1';
    } else {
        echo '0';
    }
}

//Assign Order To Another Customer
if (isset($_POST['change_cus_order']) && $_POST['change_cus_order'] != '') {
    $Customer_name_orders = $_POST['customer_name'];
    $customer_id = compName($Customer_name_orders);
    $current_cus_id = $_POST['current_cus_id'];
    $cus_manager = GetCusManager($customer_id);
    $delete_fav = "UPDATE sohorepro_order_master SET customer_company = '" . $customer_id . "', customer_name = '" . $cus_manager . "', customer_company_name = '" . $Customer_name_orders . "' WHERE id = '" . $current_cus_id . "' ";
    $result = mysql_query($delete_fav);
    if ($result) {
        echo '1';
    } else {
        echo '0';
    }
}


//Close the Order
if (isset($_POST['order_closed_now_id']) && $_POST['order_closed_now_id'] != '') {
    $order_closed_now_id = $_POST['order_closed_now_id'];

    $current_status = OrderComment($order_closed_now_id);
    $close_status = ($current_status[0]['closed_status'] == '1') ? '0' : '1';

    $order_close = "UPDATE sohorepro_order_master SET closed_status = '" . $close_status . "' WHERE id = '" . $order_closed_now_id . "' ";
    mysql_query($order_close);

    $orders_details = viewOrders($order_closed_now_id);

    $check_order_exist = CheckOrderidInvoice($order_closed_now_id);

    if (count($check_order_exist) > 0) {
        $order_close = "UPDATE sohorepro_invoice SET inv_status     = '" . $close_status . "',
                                                     created_date   = now()   WHERE order_id = '" . $order_closed_now_id . "' ";
        mysql_query($order_close);
    } else {
        foreach ($orders_details as $details) {
            $sql = "INSERT INTO sohorepro_invoice
			SET     order_id        = '" . $details['order_id'] . "',
                                order_sequence  = '" . $current_status[0]['order_number'] . "',
                                job_reference   = '" . $current_status[0]['order_id'] . "',
                                customer_id     = '" . $current_status[0]['customer_company'] . "',
                                user_id         = '" . $current_status[0]['customer_name'] . "',
                                company_name    = '" . $current_status[0]['customer_company_name'] . "',
                                product_id      = '" . $details['product_id'] . "',
                                product_price   = '" . number_format($details['product_price'], 2, '.', '') . "',
                                product_qty     = '" . $details['product_quantity'] . "',
                                line_cost       = '" . number_format(($details['product_price'] * $details['product_quantity']), 2, '.', '') . "',    
                                product_name    = '" . mysql_real_escape_string($details['product_name']) . "',
                                inv_status      = '" . $close_status . "',
                                created_date    = now()     ";
            $sql_result = mysql_query($sql);
        }
    }

    $after_status = OrderComment($order_closed_now_id);
    echo $after_status[0]['closed_status'];
}


//Close the Order
if (isset($_POST['specials_on_off']) && $_POST['specials_on_off'] != '') {

    $specials_on_off_id = $_POST['specials_on_off'];
    $specials           = Specials($specials_on_off_id);
    $specials_on_off    = ($specials == '1') ? '0' : '1';

    $specials_update  = "UPDATE sohorepro_pickup_add SET caption = '" . $specials_on_off . "' WHERE id = '" . $specials_on_off_id . "' ";
    mysql_query($specials_update);    
    echo $specials_on_off;
}



//Invoice Type Set
if (isset($_POST['invoice_type']) && $_POST['invoice_type'] != '') {
    $invoice_type = $_POST['invoice_type'];
    $invoice_comp_id = $_POST['invoice_comp_id'];

    $invoice_change = "UPDATE sohorepro_company SET invoice_type = '" . $invoice_type . "' WHERE comp_id = '" . $invoice_comp_id . "' ";
    mysql_query($invoice_change);

    if ($invoice_type == '7') {
        echo 'Weekly';
    } elseif ($invoice_type == '14') {
        echo 'Semi-Weekly';
    } elseif ($invoice_type == '30') {
        echo 'Monthly';
    }
}

//Binding Details Update

if (isset($_POST['binding_id']) && $_POST['binding_id'] != '') {
    $binding_id = $_POST['binding_id'];
    $binding_dtls = strtoupper($_POST['binding_dtls']);

    $invoice_change = "UPDATE sohorepro_sets_needed SET binding = '" . $binding_dtls . "' WHERE id = '" . $binding_id . "' ";
    $result = mysql_query($invoice_change);

    if ($result) {
        echo '1';
    } else {
        echo '0';
    }
}



//Folding Details Update

if (isset($_POST['folding_id']) && $_POST['folding_id'] != '') {
    $folding_id = $_POST['folding_id'];
    $folding_dtls = strtoupper($_POST['folding_dtls']);

    $invoice_change = "UPDATE sohorepro_sets_needed SET folding = '" . $folding_dtls . "' WHERE id = '" . $folding_id . "' ";
    $result = mysql_query($invoice_change);

    if ($result) {
        echo '1';
    } else {
        echo '0';
    }
}
?>


