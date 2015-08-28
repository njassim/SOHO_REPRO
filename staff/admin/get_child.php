<?php
include './config.php';

if(isset($_POST['pc_id']) && $_POST['pc_id'] != '')
{
  $pc_id = $_POST['pc_id'];
  $pc_id = mysql_real_escape_string($pc_id);
  $query = "select * from sohorepro_category where parent_id ='".$pc_id."'";
  $res = mysql_query($query);
  if(mysql_num_rows($res))
  {       
        echo "<option value='0'>Select Sub Category</option>"; 
    while($row = mysql_fetch_array($res))
	{	
        echo "<option value='".$row['id']."'>".ucfirst($row['category_name'])."</option>";
	}
  }
}


if(isset($_POST['pcj_id']) && $_POST['pcj_id'] != '')
{
  $pc_id = $_POST['pcj_id'];
  $pc_id = mysql_real_escape_string($pc_id);
  $query = "select * from sohorepro_category where parent_id ='".$pc_id."'";
  $res = mysql_query($query);
  if(mysql_num_rows($res))
  {      
        echo "<option value='0'>Select Sub Category</option>"; 
    while($row = mysql_fetch_array($res))
	{	
        echo "<option value='".$row['id']."'>".ucfirst($row['category_name'])."</option>";
	}
  }
}


if(isset($_POST['super_id']) && $_POST['super_id'] != '')
{
  $super_id = $_POST['super_id'];
  $id = mysql_real_escape_string($super_id);
  $query = "select * from sohorepro_category where super_id ='".$id."' AND parent_id = '0'";
  $res = mysql_query($query);
  if(mysql_num_rows($res))
  {       
    while($row = mysql_fetch_array($res))
	{	
        echo "<option value='".$row['id']."'>".ucfirst($row['category_name'])."</option>";
	}
  }
}

if(isset($_POST['super_id_prod']) && $_POST['super_id_prod'] != '')
{
  $super_id = $_POST['super_id_prod'];
  $id = mysql_real_escape_string($super_id);
  $query = "select * from sohorepro_category where super_id ='".$id."' AND parent_id = '0'";
  $res = mysql_query($query);
  if(mysql_num_rows($res))
  {     
        echo "<option value='0'>Select Category</option>"; 
    while($row = mysql_fetch_array($res))
	{	
        echo "<option value='".$row['id']."'>".ucfirst($row['category_name'])."</option>";
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

if(isset($_POST['super_id_sub_prod']) && $_POST['super_id_sub_prod'] != '')
{
  $super_id = $_POST['super_id_sub_prod'];
  $cate_id  = $_POST['cate_id'];
  $id = mysql_real_escape_string($super_id);
  $query = "select * from sohorepro_category where super_id ='".$id."' AND parent_id = '".$cate_id."'";
  $res = mysql_query($query);
  if(mysql_num_rows($res))
  {     
        echo "<option value='0'>Select Subcategory</option>"; 
    while($row = mysql_fetch_array($res))
	{	
        echo "<option value='".$row['id']."'>".ucfirst($row['category_name'])."</option>";
	}
  }
  
//  $queryP = "SELECT * FROM sohorepro_products WHERE supercategory_id = '".$id."' AND category_id= '".$cate_id."' AND subcategory_id = '0'";
//  $resP = mysql_query($queryP);
//  if(mysql_num_rows($resP))
//  {    
//        
//    while($row = mysql_fetch_array($resP))
//	{	
//        echo "#<option value='".$row['id']."'>".ucfirst($row['product_name'])."</option>".'#'."<option value='".$row['price']."'>".ucfirst($row['price'])."</option>";
//	}
//  }  else {
//       echo "#<option value='0'>Select Product</option>#<option value='0'>Select Price</option>"; 
//  }
//  
  
}

if(isset($_POST['scate_id']) && $_POST['scate_id'] != '')
{
  $super_id = $_POST['super_id_j'];
  $cate_id  = $_POST['category_j'];
  $scate_id = $_POST['scate_id'];
  $id = mysql_real_escape_string($super_id);  
  $queryj = "SELECT * FROM sohorepro_products WHERE supercategory_id = '".$id."' AND category_id= '".$cate_id."' AND subcategory_id = '".$scate_id."'";
  $resj = mysql_query($queryj);
  if(mysql_num_rows($resj))
  {    
        
    while($row = mysql_fetch_array($resj))
	{	
        echo "#<option value='".$row['id']."'>".ucfirst($row['product_name'])."</option>".'#'."<option value='".$row['price']."'>".ucfirst($row['price'])."</option>";
	}
  }
  
  
}


if(isset($_POST['c_id']) && $_POST['c_id'] != '')
{
  $ca_id = $_POST['c_id'];
  $sc_id = $_POST['sc_id'];
  $su_id = $_POST['su_id'];
  $c_id = mysql_real_escape_string($ca_id);
  $s_id = mysql_real_escape_string($sc_id);
  $super_id = mysql_real_escape_string($su_id);
  $query = "SELECT product_name,id FROM `sohorepro_products` where subcategory_id = '".$s_id."'";
  $res = mysql_query($query);
  if(mysql_num_rows($res))
  {
        
    while($row = mysql_fetch_array($res))
	{	
          echo "<option value='".$row['id']."'>".ucfirst($row['product_name'])."</option>";
	}
  }
}




if(isset($_POST['price']) && $_POST['price'] != '')
{
  
  $product          = str_replace("'",'"',$_POST['product']);
  $qty              = $_POST['qty'];  
  $price            = $_POST['price'];  
  $id               = $_POST['id'];  
  $iid              = $_POST['iid'];
  $order_id         = $_POST['order_id'];
  $query = "UPDATE sohorepro_product_master
			SET     product_name            = '" . $product . "',                               
				product_quantity        = '" . $qty . "',
                                product_price           = '" . $price . "' WHERE id = '".$id."' AND product_id = '" . $iid . "'"; 
    $sql_result = mysql_query($query);
    $sql_data = mysql_query("SELECT product_name,product_quantity,product_price,tax_status FROM sohorepro_product_master WHERE id = '".$id."' AND product_id = '" . $iid . "'");
    $object = mysql_fetch_assoc($sql_data);
    $select_price = "SELECT sum(product_price * product_quantity) as sub_total FROM sohorepro_product_master WHERE order_id = '".$order_id."'" ;
    $price_order  = mysql_query($select_price);
    $object_tot = mysql_fetch_assoc($price_order);    
               if($object['tax_status'] == '1')
               {
               $tax_line = '8.875';    
               }  else {
               $tax_line = '0';       
               }
               $tax         = number_format(($tax_line * ($object_tot['sub_total']/100)), 2, '.', '');  
               $grand_tot   = number_format(($object_tot['sub_total'] + $tax), 2, '.', '');  
               $sub_total   = number_format($object_tot['sub_total'], 2, '.', '');  
               $line        = number_format(($object['product_quantity'] * $object['product_price']), 2, '.', '');  
    if ($sql_result) {
        echo $object['product_name'].'~'.$object['product_quantity'].'~'.$object['product_price'].'~'.$object['tax_status'].'~'.$grand_tot.'~'.$tax.'~'.$sub_total.'~'.'$'.$line;
    } else {
        echo "Order changed not successfully";
    }    
}



if(isset($_POST['reference']) && $_POST['reference'] != '')
{
  
  $reference            = $_POST['reference'];  
  $id                   = $_POST['id'];    
  $query = "UPDATE sohorepro_order_master
			SET     order_id = '" . $reference . "' WHERE id = '".$id."'";
    $sql_result = mysql_query($query);    
    if ($sql_result) {
        echo $reference;
    } else {
        echo "Order changed not successfully";
    }    
}

if(isset($_POST['list_price']) && $_POST['list_price'] != '')
{ 
  $id                   = $_POST['id']; 
  $list_price           = $_POST['list_price'];
  $discount             = $_POST['discount'];
  $price                = number_format(($discount * ($list_price/100)), 2, '.', ''); 
  $special_price        = ($list_price - $price); 
  $special              = number_format(($special_price), 2, '.', ''); 
  $discount_return      = number_format(($_POST['discount']), 2, '.', ''); 
  $query = "UPDATE sohorepro_special_pricing
			SET     sp_list_price       = '" . $list_price . "',
                                sp_discount         = '" . $discount . "',
                                sp_special_price    = '" . $special . "'
                            WHERE sp_id = '".$id."'";
    $sql_result = mysql_query($query);    
    if ($sql_result) {
        echo $list_price.'#'.$discount_return.'#'.$special;
    } else {
        echo "Product changed not successfully";
    }    
}


if(isset($_POST['mail_id']) && !empty($_POST['mail_id'])){     
      $mail_id  = $_POST['mail_id'];
      $query="select * from sohorepro_email where email_id = '$mail_id'";
      $val_mail = mysql_query($query);
      echo $res=  count($val_mail);
//      if($res>0)
//      {
//          echo '1';
//      }
//      else 
//      {
//          echo '0';
//      }

}


if(isset($_POST['sequence_id']) && $_POST['sequence_id'] != '')
{ 
  $id           = $_POST['sequence_id'];   
  $sequence     = $_POST['sequence'];
  $query = "UPDATE sohorepro_order_master
			SET     order_sequence       = '" . $sequence . "'
                                WHERE id = '".$id."'";
    $sql_result = mysql_query($query);    
    if ($sql_result) {
        echo 'Order Sequence Successfully Changed'.'~'.$sequence;
    } else {
        echo "Order Sequence not changed";
    }    
}

if(isset($_POST['super_id_filter']) && $_POST['super_id_filter'] != '')
{   
echo '1';     
}

if(isset($_POST['search_prod']) && $_POST['search_prod'] != '')
{   
echo '1';     
}


if(isset($_POST['list_price_product']) && $_POST['list_price_product'] != '')
{ 
  $id           = $_POST['id'];   
  $list         = $_POST['list_price_product'];
  $discount     = $_POST['discount_product'];
  $selling      = $_POST['selling_product'];
  $prod_name    = mysql_real_escape_string($_POST['prd_name']);
  $query = "UPDATE sohorepro_products
			SET     product_name     = '".$prod_name."',
                                list_price       = '" . $list . "',
                                discount         = '".$discount."',
                                price            = '".$selling."'
                                WHERE id         = '$id' ";  
    $sql_result = mysql_query($query);
    
    $select_prd = "SELECT product_name,discount FROM sohorepro_products WHERE id = '".$id."'" ;
    $prd  = mysql_query($select_prd);
    $object_prd = mysql_fetch_assoc($prd);    
    
    
    if ($sql_result) {
        echo 'Successfully updated'.'~'.'$'.$list.'~'.$object_prd['discount'].'~'.'$'.$selling.'~'.$object_prd['product_name'];
    } else {
        echo "Updated not successfully";
    }    
}


if(isset($_POST['product_qty']) && $_POST['product_qty'] != '')
{ 
  $product_id    = $_POST['id'];   
  $order_id      = $_POST['order_id']; 
  $exist_qty     = ExistQuantity($product_id,$order_id);
  $quantity      = ($_POST['product_qty'] > $exist_qty)? $_POST['product_qty'] : $exist_qty ; 
  $exist_product = ExistProductOrder($product_id,$order_id);
  if($exist_product < 1){
  $query = "INSERT INTO sohorepro_products_order_temp
			SET     product_id       = '" . $product_id . "',
                                product_quantity  = '" . $quantity . "',
                                order_id         = '" . $order_id . "' ";
  $query_delete = "DELETE FROM sohorepro_product_master WHERE product_id = '".$product_id."' AND order_id = '".$order_id."' ";
  mysql_query($query_delete);
  }  else {
  $query = "UPDATE sohorepro_products_order_temp
			SET     product_quantity  = '" . $quantity . "' WHERE
                                product_id       = '".$product_id."'  AND 
                                order_id         = '".$order_id."' "; 
  //$query_delete = "DELETE FROM sohorepro_product_master WHERE product_id = '".$product_id."' AND order_id = '".$order_id."' ";
  }
    $sql_result = mysql_query($query);    
    if ($sql_result) {
        echo '1';
    } else {
        echo '0';
    }    
}


if(isset($_POST['delete_order_id']) && $_POST['delete_order_id'] != '')
{ 
  $order_id   = $_POST['delete_order_id']; 
  $query      = "DELETE FROM sohorepro_products_order_temp WHERE order_id = '".$order_id."' ";
    $sql_result = mysql_query($query);    
    if ($sql_result) {
        echo '1';
    } else {
        echo '0';
    }    
}


if(isset($_POST['guest_qty']) && $_POST['guest_qty'] != '')
{ 
  $product_id    = $_POST['id'];   
  $qty           = $_POST['guest_qty']; 
  $ip            = $_SERVER["REMOTE_ADDR"]; 
  $exist_qty     = ExistQuantityGuest($product_id,$ip);
  $quantity      = ($_POST['guest_qty'] > $exist_qty)? $_POST['guest_qty'] : $exist_qty ; 
  $exist_product = ExistProductOrderGuest($product_id,$ip);
  if($exist_product < 1){
  $query = "INSERT INTO sohorepro_checkout_guest
			SET     product_id       = '" . $product_id . "',
                                quantity         = '" . $qty . "',
                                ip               = '" . $ip . "' ";   
  }  else {
  $query = "UPDATE sohorepro_checkout_guest
			SET     quantity         = '" . $quantity . "' WHERE
                                product_id       = '".$product_id."'  AND 
                                ip               = '".$ip."' ";   
  }
    $sql_result = mysql_query($query);    
    if ($sql_result) {
        echo '1';
    } else {
        echo '0';
    }    
}



//Supply Store Order Making
if(isset($_POST['supply_qty']) && $_POST['supply_qty'] != '')
{ 
  $product_id    = $_POST['id'];   
  $qty           = $_POST['supply_qty']; 
  $ip            = $_SERVER["REMOTE_ADDR"]; 
  $staff_id      = $_POST['user_log']; 
  $exist_qty     = ExistQuantityGuest($product_id,$ip);
  $quantity      = ($_POST['supply_qty'] > $exist_qty)? $_POST['supply_qty'] : $exist_qty ; 
  $exist_product = ExistProductOrderGuest($product_id,$ip);
  if($exist_product < 1){
  $query = "INSERT INTO sohorepro_checkout_guest
			SET     product_id       = '" . $product_id . "',
                                quantity         = '" . $qty . "',
                                ip               = '" . $ip . "',
                                staff_id         = '" . $staff_id . "'  ";   
  }  else {
  $query = "UPDATE sohorepro_checkout_guest
			SET     quantity         = '" . $quantity . "' WHERE
                                product_id       = '".$product_id."'  AND 
                                staff_id         = '".$staff_id."' ";   
  }
    $sql_result = mysql_query($query);    
    if ($sql_result) {
        echo '1';
    } else {
        echo '0';
    }    
}



//User name Check for Users Tab
if(isset($_POST['user_name_ext']) && $_POST['user_name_ext'] != '')
{ 
  $user_name       = $_POST['user_name_ext']; 
  $query      = "SELECT cus_email FROM sohorepro_customers WHERE cus_email = '".$user_name."' ";
  $sql_result = mysql_query($query);    
    if (mysql_num_rows($sql_result) > 0) {
        echo '1';
    } else {
        echo '0';
    }    
}



//Select User for supply Store
if(isset($_POST['customer_id_select']) && $_POST['customer_id_select'] != '')
{
  $company_name = $_POST['customer_id_select'];
  $comp_id      = compName($company_name);
  $query = "select * from sohorepro_customers where cus_compname ='".$comp_id."' AND cus_status = '1'";
  $res = mysql_query($query);
  if(mysql_num_rows($res))
  {       
    while($row = mysql_fetch_array($res))
	{
        if($row['cus_id'] == $_SESSION['supply_usr_id'])
        {
         echo "<option value='".$row['cus_id']."' selectet='selected'>".ucfirst($row['cus_contact_name'])."</option>";      
        }
        else
        {
         echo "<option value='".$row['cus_id']."'>".ucfirst($row['cus_contact_name'])."</option>";   
        }        
	}
         echo "<option value='N' onclick='user_select();'>New User</option>";
  }
}




//Checout The cash_customer User from guest
if(isset($_POST['cash_customer']) && $_POST['cash_customer'] != '')
{
  
  
  $staff_id     = $_POST['staff_id'];
  $reference    = $_POST['reference']; 
  $cash_customer= $_POST['cash_customer'];
  $items_guest  = GuestItems($staff_id);
  foreach ($items_guest as $items){
            $unit_prc = ProdPriceForAdd($items['product_id']);
            $query  = "INSERT INTO sohorepro_checkout SET product_id     = '" . $items['product_id'] . "', quantity = '" . $items['quantity'] . "', unit_price = '" . $unit_prc . "', user_id = '" . $user_id . "', staff_id = '".$staff_id."', company_id = '" . $company_id . "', reference = '" . $reference . "', shipping_add_id = '0', cash_customer = '".$cash_customer."' ";
            $result = mysql_query($query);
  }   
  $query      = "DELETE FROM sohorepro_checkout_guest WHERE staff_id = '".$staff_id."' ";
  mysql_query($query);
  unset($_SESSION['new_user_session']);
  if($result){
      echo '1'.'~'.$company_id;
  }  else {
      echo '0';
  }
  
}


//Checout The Supply User from guest
if(isset($_POST['supply_usr_id']) && $_POST['supply_usr_id'] != '')
{
  
  $user_id      = $_POST['supply_usr_id'];
  $company_id   = COMPID($user_id);
  $staff_id     = $_POST['staff_id'];
  $reference    = $_POST['reference'];
  $company_name = $_POST['company_name'];
  $contact_name = $_POST['contact_name'];
  $phone        = $_POST['phone'];
  $email        = $_POST['email'];
  $add1         = $_POST['add1'];
  $add2         = $_POST['add2'];
  $city         = $_POST['city'];
  $state        = $_POST['state'];
  $zip          = $_POST['zip'];
  $cash_customer= $_POST['cash_customer'];
  $items_guest  = GuestItems($staff_id);
  foreach ($items_guest as $items){
            $unit_prc = ProdPriceForAdd($items['product_id']);
            $query  = "INSERT INTO sohorepro_checkout SET product_id     = '" . $items['product_id'] . "', quantity = '" . $items['quantity'] . "', unit_price = '" . $unit_prc . "', user_id = '" . $user_id . "', staff_id = '".$staff_id."', company_id = '" . $company_id . "', reference = '" . $reference . "', shipping_add_id = '0', cash_customer = '".$cash_customer."' ";
            $result = mysql_query($query);
  }
  if($add1 != ''){
  $address_insert = "INSERT INTO sohorepro_address SET comp_id = '".$user_id."', company_name = 'Guest User Shipping', contact_name= '".$contact_name."', email = '".$email."', address_1 = '".$add1."', address_2= '".$add2."', city = '".$city."', state = '".$state."', zip = '".$zip."', phone = '".$phone."' ";
  mysql_query($address_insert);   
  }
  $update_add_id = "UPDATE sohorepro_address SET comp_id = '".$user_id."' WHERE prop = '9'";
  mysql_query($update_add_id);   
  $query      = "DELETE FROM sohorepro_checkout_guest WHERE staff_id = '".$staff_id."' ";
  mysql_query($query);
  unset($_SESSION['new_user_session']);
  if($result){
      echo '1'.'~'.$company_id;
  }  else {
      echo '0';
  }
  
}

//Create New User if Staff Admin Side
if(isset($_POST['new_usr_customer']) && $_POST['new_usr_customer'] != '')
{
    $compa_name     = $_POST['new_usr_customer'];
    $user_name_new  = $_POST['new_usr_user'];
    $user_name_mail  = $_POST['new_usr_mail'];
    $new_usr_phone  = $_POST['new_usr_phone'];
    $company_id     = compName($compa_name);
    if($company_id != ''){
    $address_insert = "INSERT INTO sohorepro_customers SET cus_contact_name = '".$user_name_new."', cus_email = '".$user_name_mail."', cus_compname= '".$company_id."', cus_contact_phone = '".$new_usr_phone."' ";
    $result = mysql_query($address_insert);
    //$_SESSION['new_user_session'] =  mysql_insert_id();
    }
    if($result){
      echo mysql_insert_id();
    }  else {
      echo '0';
    }
}


//User name Check for Users Tab
if (isset($_POST['session_cart']) && $_POST['session_cart'] != '') {
$session_cart = $_POST['session_cart'];
$session_order = $_POST['session_order'];
$_SESSION['session_cart'] = $session_cart;
$_SESSION['session_order'] = $session_order;
echo $_SESSION['session_cart'];
}


if (isset($_POST['cus_commt']) &&!empty($_POST['cus_commt'])) {
$cus_commt      = mysql_real_escape_string($_POST['cus_commt']);
$cus_commt_id   = $_POST['cus_commt_id'];
$ip             = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
$exist_comment  = OrderCommentShopp($cus_commt_id,$ip);
if ($exist_comment < 1) {
$query = "INSERT INTO sohorepro_cust_commt
			SET     cus_id       = '" . $cus_commt_id . "',
                                ip           = '" . $ip . "',
                                comment      = '" . $cus_commt . "',
                                status       = '1' ";
} else {
$query = "UPDATE sohorepro_cust_commt
			SET     comment      = '" . $cus_commt ."', 
                                status       = '1' WHERE 
                                cus_id       = '" . $cus_commt_id . "' AND ip = '".$ip."' ";
}
$res = mysql_query($query);
if ($res) {
echo '1';
} else {
echo '0';
}
}
?>