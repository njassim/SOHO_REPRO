<?php
include './config.php';

if(isset($_POST['list_price_c']) && $_POST['list_price_c'] != '')
{ 
  $id                   = $_POST['id']; 
  $list_price           = $_POST['list_price_c'];
  $discount             = $_POST['discount_c'];  
  $special              = number_format(($_POST['special']), 2, '.', '');  
  $user_id              = $_POST['user_id'];
  $discount_return      = number_format(($_POST['discount_c']), 2, '.', ''); 
  $check                = checkSpecial($user_id,$id);
  //echo count($check);
  if(count($check) <= 0){
    $query = "INSERT INTO sohorepro_special_pricing
			SET     sp_user_id          = '" .$user_id."',
                                sp_product_id       = '" .$id."',
                                sp_list_price       = '" . $list_price . "',
                                sp_discount         = '" . $discount . "',
                                sp_special_price    = '" . $special . "' ";
    $sql_result = mysql_query($query); 
    
    $query_fav = "UPDATE sohorepro_favorites
			SET     list_price      = '" . $list_price . "',
                                discount_price  = '" . $discount . "',
                                sell_price      = '" . $special . "'
                            WHERE comp_id = '".$user_id."' AND product_id = '".$id."' ";
    mysql_query($query_fav);
    
    if ($sql_result) {
        echo $list_price.'~'.$discount_return.'~'.$special.'~';
    } else {
        echo "Product changed not successfully";
    }  
  } 
  else 
  {
      $query = "UPDATE sohorepro_special_pricing
			SET     sp_list_price       = '" . $list_price . "',
                                sp_discount         = '" . $discount . "',
                                sp_special_price    = '" . $special . "'
                            WHERE sp_product_id = '".$id."' AND sp_user_id = '".$user_id."' ";
      mysql_query($query); 
      
      $query_fav = "UPDATE sohorepro_favorites
			SET     list_price      = '" . $list_price . "',
                                discount_price  = '" . $discount . "',
                                sell_price      = '" . $special . "'
                            WHERE comp_id = '".$user_id."' AND product_id = '".$id."' ";
    mysql_query($query_fav);
      
      
        echo $list_price.'~'.$discount_return.'~'.$special.'~';    
  }
  ?>
<div id="spl_<?php echo $user_id; ?>">
<table class="spl_tbl" id="spl" width="755" align="center" cellspacing="0" cellpadding="0">
<tr>
    <td class="spl_h3_td" height="38" align="left" valign="middle">
        <h3 class="spl_h3">Specific Pricing</h3></td>
</tr> 
<span class="succ spl_span" id="succ"></span>

<tr>
    <td height="30" align="left" valign="middle" class="content_1">

        <!---Special Pricing Start --->   

    <table width="100%"> 
    <tbody>
    <tr class="spl_tr">                                                                            
    <td height="30" class="brdr spl_td">S.NO</td>
    <td valign="middle" class="brdr spl_td">Super Category</td>
    <td valign="middle" class="brdr spl_td">Category</td>
    <td valign="middle" class="brdr spl_td">Sub Category</td>
    <td valign="middle" class="brdr spl_td">Product Name</td>
    <td valign="middle" class="brdr spl_td">List Price</td>
    <td valign="middle" class="brdr spl_td">Discount(%)</td>
    <td valign="middle" class="brdr spl_td">Selling Price</td>                                                                            
    <td valign="middle" class="brdr spl_td">Action</td>
    </tr>

    <?php 
    $special_price = getSpecialProduct($user_id);
    if(count($special_price) > 0)
    {
    $k = 1;
    foreach ($special_price as $Special_Product) { 
        $super_id               =   getsuper($Special_Product['sp_product_id']);
        $cat_id                 =   getcat($Special_Product['sp_product_id']);
        $sub_id                 =   getsub($Special_Product['sp_product_id']);
        $super_name             =   getsuperN($super_id);
        $cat_name               =   getcatN($cat_id);
        $sub_name               =   getsubN($sub_id);
        $special_id             =   $Special_Product['sp_id'];
        $product_name           =   getorderProd($Special_Product['sp_product_id']);
        $list_price             =   $Special_Product['sp_list_price'];
        $discount_price         =   $Special_Product['sp_discount'];
        $selling_price          =   $Special_Product['sp_special_price'];
    ?> 
    <tr class="spl_tr_in" id="test_<?php echo $user_id; ?>_<?php echo $special_id; ?>">                                                                                                                                                        
    <td class="spl_td_in"><?php echo $k; ?> </td>
    <td class="spl_td_in"><?php echo $super_name; ?> </td>
    <td class="spl_td_in"><?php echo $cat_name; ?> </td>
    <td class="spl_td_in"><?php echo $sub_name; ?> </td>
    <td class="spl_td_in"><?php echo $product_name; ?></td>
    <td class="spl_td_in"><?php echo $list_price; ?></td>
    <td class="spl_td_in"><?php echo $discount_price; ?></td>
    <td class="spl_td_in"><?php echo $selling_price; ?></td> 
    <td class="spl_td_action" align="center" valign="middle"><img src="images/like_icon_down.png" onclick="delete_special(<?php echo $special_id; ?>,<?php echo $user_id; ?>);"  alt="Delete Specific Price" title="Delete Specific Price" width="22" height="22" class="mar_lft"/></td>
    </tr>
    <?php 
    $k++;
    } 
    }
    else
    {
    ?>
    <tr class="spl_tr_in">
        <td colspan="9" align="center">There is no specific price products.</td>
    </tr>
    <?php 
    }
    ?>
    </tbody>
    </table>                                                                             
   <!---Special Pricing End --->     


    </td>                                                                            
</tr> 
</table>
</div>
  <?php
}
?>
