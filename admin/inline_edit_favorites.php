<?php
include './config.php';
include './db_connection.php';
error_reporting(0);


if ($_POST['inline_edit_fav'] == '1') {
    
    $list_amount        = number_format(($_POST['list_amount']), 2, '.', ''); ;
    $discount_amount    = number_format(($_POST['discount_amount']), 2, '.', ''); 
    $sell_amount        = $_POST['sell_amount'];
    $id                 = $_POST['product_id'];  
    
    
    
    $query = "UPDATE sohorepro_favorites
			SET     list_price         = '" . $list_amount . "',
                                discount_price     = '" . $discount_amount . "',
                                sell_price         = '" . $sell_amount . "' WHERE id = '" . $id . "' ";
    $sql_result = mysql_query($query);
    
    $product_details    = GetFavProductDetails($id);    
    $fav_comp_id        = $product_details[0]['comp_id'];
    $fav_product_id     = $product_details[0]['product_id'];
    
    $fav_list_price     = $product_details[0]['list_price'];
    $fav_discount_price = $product_details[0]['discount_price'];
    $fav_sell_price     = $product_details[0]['sell_price'];
    
    $query_spl = "UPDATE sohorepro_special_pricing
			SET     sp_list_price    = '" . $fav_list_price . "',
                                sp_discount      = '" . $fav_discount_price . "',
                                sp_special_price = '" . $fav_sell_price . "' WHERE sp_user_id = '" . $fav_comp_id . "' AND sp_product_id = '". $fav_product_id ."' ";
    $sql_result_spl = mysql_query($query_spl);
    
    if($sql_result){
        echo $discount_amount;
    }else{
        echo '0';
    }
}