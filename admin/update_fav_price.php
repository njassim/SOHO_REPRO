<?php
include './config.php';


function FavItems() {
    $select_category = "SELECT * FROM sohorepro_favorites";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}


$all_faverites = FavItems();


//echo '<pre>';
//print_r($all_faverites);
//echo '</pre>';


foreach ($all_faverites as $fav){       
    
    $list_price     = editPdoructs($fav['product_id']);
    $discoutn_price = editPdoructs($fav['product_id']);
    $sell_price     = editPdoructs($fav['product_id']);
    
    //echo $fav['product_id'].'&nbsp;LIST PRICE :'.$list_price[0]['list_price'].'&nbsp;DISCOUNT PRICE :'.$discoutn_price[0]['discount'].'&nbsp;SELL PRICE :'.$sell_price[0]['price'].'<br>';
    
    
    $spl_check_fav  =   checkSpecial($fav['comp_id'], $fav['product_id']);
    $spl_prod_fav   =   editPdoructs($fav['product_id']);

    $list_price_fav = (count($spl_check_fav) > 0) ? $spl_check_fav[0]['sp_list_price'] : $spl_prod_fav[0]['list_price'];
    $disc_price_fav = (count($spl_check_fav) > 0) ? $spl_check_fav[0]['sp_discount'] : $spl_prod_fav[0]['discount'];
    $sell_price_fav = (count($spl_check_fav) > 0) ? $spl_check_fav[0]['sp_special_price'] : $spl_prod_fav[0]['price'];
    
    
    
    $query = "UPDATE sohorepro_favorites
			SET     list_price = '" . $list_price_fav . "', discount_price = '" . $disc_price_fav . "', sell_price = '" . $sell_price_fav . "' WHERE product_id = '".$fav['product_id']."' AND comp_id = '".$fav['comp_id']."' ";
    $result = mysql_query($query);  
    
}

if($result){
        echo 'Updated Successfully';
    }