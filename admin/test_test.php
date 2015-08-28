<?php
include './config.php';

$pro = get_spl_prod();
$user_id = '13';

foreach ($pro as $p)
{
   $product_id      = $p['sp_product_id'];
   $list_price      = $p['sp_list_price'];
   $discount        = $p['sp_discount'];
   $special_price   = $p['sp_special_price'];
   
   $query = "INSERT INTO sohorepro_special_pricing SET
             sp_user_id         = '".$user_id."',
             sp_product_id      = '".$product_id."',
             sp_list_price      = '".$list_price."',
             sp_discount        = '".$discount."',
             sp_special_price   = '".$special_price."'";
   $ok = mysql_query($query); 
}

if($ok)
   {
       echo 'Successfully Inserted for user id : '.$user_id;
   }
 else
    {
 
     echo 'Not Inserted';
 }

?>
