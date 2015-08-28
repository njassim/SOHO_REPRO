<?php
include './config.php';

if (isset($_POST['sub_category_name']) && $_POST['sub_category_name'] != '') {
    $sub_category_name = $_POST['sub_category_name'];
    $id = mysql_real_escape_string($_POST['id']);
    $status = $_POST['status'];
    $category_id = $_POST['category_id'];

    $query = "UPDATE sohorepro_category
			SET     category_name = '" . $sub_category_name . "',
                                parent_id     = '" . $category_id . "',
				status = '" . $status . "' WHERE id = " . $id . "";
    $sql_result = mysql_query($query);
    if ($sql_result) {
        echo "Sub category updated successfully";
    } else {
        echo "Sub category updated not successfully";
    }
}

if (isset($_POST['category_name']) && $_POST['category_name'] != '') {
    $category_name = $_POST['category_name'];
    $id = mysql_real_escape_string($_POST['id']);
    $status = $_POST['status'];    

    $query = "UPDATE sohorepro_category
			SET     category_name = '" . $category_name . "',                               
				status = '" . $status . "' WHERE id = " . $id . "";
    $sql_result = mysql_query($query);
    if ($sql_result) {
        echo "Category updated successfully";
    } else {
        echo "Category updated not successfully";
    }
}

if (isset($_POST['name']) && $_POST['name'] != '') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $id = mysql_real_escape_string($_POST['id']);
    $status = $_POST['status'];    

    $query = "UPDATE sohorepro_email
			SET     name = '" . $name . "',
                                email_id = '" . $email . "',
				status = '" . $status . "' WHERE id = " . $id . "";
    $sql_result = mysql_query($query);
    if ($sql_result) {
        echo "Email details updated successfully";
    } else {
        echo "Email details updated not successfully";
    }
}

if (isset($_POST['discount']) && $_POST['discount'] != '') {
    $customer_id        = $_POST['customer_id'];
    $product_name       = $_POST['product_name'];
    $list_price         = $_POST['list_price'];
    $discount           = $_POST['discount'];
    $price              = number_format(($discount * ($list_price/100)), 2, '.', ''); 
    $special            = number_format(($list_price - $price), 2, '.', '');      
    
    $query = "INSERT INTO sohorepro_special_pricing
			SET     sp_user_id          = '" . $customer_id . "',
                                sp_product_id       = '" . $product_name . "',
				sp_list_price       = '" . $list_price . "',
                                sp_discount         = '" . $discount . "',
                                sp_special_price    = '" . $special . "'";
    $sql_result = mysql_query($query);
    if ($sql_result) {
        echo "Customer product insert successfully";
    } else {
        echo "Customer product insert not successfully";
    }
}


if (isset($_POST['user_name']) && $_POST['user_name'] != '') {
    $name       = $_POST['user_name'];
    $type       = $_POST['type'];
    $status     = $_POST['staus'];
    $initials   = strtoupper($_POST['initials']);
    $id     = mysql_real_escape_string($_POST['id']);    
    $query = "UPDATE sohorepro_users
			SET     user_name   = '" . $name . "',
                                email       = '" . $name . "',
                                initials    = '".  $initials . "',
                                type        = '" . $type . "',    
				status      = '" . $status . "' WHERE id = " . $id . "";
    $sql_result = mysql_query($query);
    if ($sql_result) {
        echo "Users details updated successfully";
    } else {
        echo "Users details updated not successfully";
    }
}


?>