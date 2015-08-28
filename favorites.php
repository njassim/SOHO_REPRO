<?php
include './admin/config.php';

if (isset($_POST['fav_prod_id']) &&!empty($_POST['fav_prod_id'])) {
$fav_prod_id =  $_POST['fav_prod_id'];
$fav_cmp_id =   $_POST['fav_usr_id'];
$comp_id    =   COMPID($fav_cmp_id);
$check_fav  =   CHECKFAV($comp_id, $fav_prod_id);
if(count($check_fav) > 0){
$query = "DELETE FROM sohorepro_favorites WHERE comp_id = '".$comp_id."' AND product_id = '".$fav_prod_id."' ";
}  else {
    
    $sql_order_id = mysql_query("SELECT sort_id FROM sohorepro_favorites WHERE comp_id = '".$comp_id."' ORDER BY sort_id DESC LIMIT 1");
    $object_order = mysql_fetch_assoc($sql_order_id);

        if (count($object_order['sort_id']) > 0) {
            $order_id = ($object_order['sort_id'] + 1);
        } 
        else{
            $order_id = '0';
        }
       
        $spl_check_fav  =   checkSpecial($fav_cmp_id, $fav_prod_id);
        $spl_prod_fav   = editPdoructs($fav_prod_id);
        
        $list_price_fav = (count($spl_check_fav) > 0) ? $spl_check_fav[0]['sp_list_price'] : $spl_prod_fav[0]['list_price'];
        $disc_price_fav = (count($spl_check_fav) > 0) ? $spl_check_fav[0]['sp_discount'] : $spl_prod_fav[0]['discount'];
        $sell_price_fav = (count($spl_check_fav) > 0) ? $spl_check_fav[0]['sp_special_price'] : $spl_prod_fav[0]['price'];
        
$query = "INSERT INTO sohorepro_favorites
			SET     usr_id       = '" . $fav_cmp_id . "',
                                comp_id      = '" . $comp_id . "',
                                product_id   = '" . $fav_prod_id . "',
                                list_price          = '" . $list_price_fav ."', 
                                discount_price      = '" . $disc_price_fav ."', 
                                sell_price          = '" . $sell_price_fav ."',     
                                sort_id             = '" . $order_id . "'" ;  

}


$res_fav = mysql_query($query);   
if($res_fav){
$check_fav_af  =   CHECKFAV($comp_id, $fav_prod_id);
$fav_img = (count($check_fav_af) == '1') ? 'fav.png' : 'un-fav.png';
echo $fav_img;
} else {
echo '0';
}
}

