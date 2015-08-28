<?php

include './admin/config.php';
include './admin/db_connection.php';


if (isset($_POST['product_id']) && $_POST['product_id'] != '') {
    
    unset($_SESSION['session_cart']);
    unset($_SESSION['session_order']);
    
    $product_id         =       $_POST['product_id'];
    $user_id            =       $_POST['user_id'];
    $query = "DELETE FROM sohorepro_checkout WHERE product_id = '" . $product_id . "' AND user_id = '" . $user_id . "'";
    mysql_query($query);
    $checkout_product = checkOut($user_id);
    $company_id       = COMPID($user_id);
    $shipping_address = ShippingAddress($company_id);
    $primary_shipping = PrimaryShipping($company_id);
    $comp_name = companyName($company_id);
    $reference        = $checkout_product[0]['reference'];
    $shipping_size    = count($shipping_address);
    $address_shipp = ($shipping_size == 1) ? $shipping_address[0]['id'] : '0' ;
    
    $current_ord = CurrentOrder($user_id);
    $current_cart = CurrentCart($user_id);
    
    $_SESSION['session_cart'] = ($current_cart != '') ? $current_cart : '0';
    $_SESSION['session_order'] = ($current_ord != '') ? $current_ord : '0.00';
    
    echo 'Remove the product successfully~';
}

//if (isset($_POST['user_id_clear']) && $_POST['user_id_clear'] != '') {
//    $product_id         =       $_POST['product_id_clear'];
//    $user_id            =       $_POST['user_id_clear'];
//    $query = "DELETE FROM sohorepro_checkout WHERE user_id = '" . $user_id . "'";
//    mysql_query($query);
//    $checkout_product = checkOut($user_id);
//    echo 'Removed the all products successfully~';
//}
?>
<table width="740" border="0" cellspacing="0" cellpadding="0">  
  <tr>
  <td align="left" valign="top">
  <table width="740" border="0" cellspacing="0" cellpadding="0">
  <tr>
      <td align="left" valign="middle" height="55" >
          <span id="loading" class="none"><img src="images/loading.gif" /></span>
          <div class="none order_placing" id="order_placing"><p>Order has been successfully placed</p><a href="index.php"><img src="images/btn_ok.png" title="OK" alt="OK"/></a></div>
          <input type="button" onclick="return continue_shopping('<?php echo $user_id; ?>');" class="btn_shopping" value="Contiune Shopping" />
      </td>
  </tr>
  <tr>
  <td align="left" valign="top">
  <table width="740" border="0" cellspacing="0" cellpadding="0" class="product_table" >
  <tr bgcolor="#ff7e00" class="h1">    
      <input type="hidden" name="ref" id="ref" value="<?php echo $reference; ?>" />    
    <td width="246" align="left" valign="middle" class="brdr_2">Product Name</td>
    <td width="78" align="center" valign="middle" class="brdr_2">Unit Price</td>
    <td width="50" align="center" valign="middle" class="brdr_2">Qty</td>
    <td width="76" align="center" valign="middle" class="brdr_2">Line Price</td>
    <td width="183" align="left" valign="middle" class="brdr_2">Shipping Address</td>
    <td width="90" align="center" valign="middle" class="brdr_2">Option</td>
  </tr>
      <?php
            $i = 1;
            if (count($checkout_product) > 0) {
                foreach ($checkout_product as $chk) {
                    $rowColor   = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                    $id         = $chk['id'];
                    $user_id    = $chk['user_id'];
                    $comp_id    = COMPID($user_id);
                    $super_id = getsuper($chk['product_id']);
                    $cat_id = getcat($chk['product_id']);
                    $sub_id = getsub($chk['product_id']);
                    $super_name = getsuperN($super_id);
                    $cat_name = getcatN($cat_id);
                    $sub_name = getsubN($sub_id);
                    $product_id = $chk['product_id'];
                    $_SESSION['product_id'] = $chk['product_id'];
                    $sku_id = getSku($chk['product_id']);
                    $product_name = getProName($chk['product_id']);
                    $tail         = $product_name;
                    $quantity = $chk['quantity'];
                    $unit_price = $chk['unit_price'];
                    $price = getPriceCkt($user_id);
                    $cart_val = totalCart($user_id);
                    $tax_status = getTaxStatusChk($comp_id);
                    if($tax_status == '1')
                    {
                    $tax_line = '8.875';    
                    }  else {
                    $tax_line = '0';       
                    }
                    $tax         = ($tax_line * ($price[0]['sub_total']/100));
                    $grand_tot   = ($price[0]['sub_total'] + $tax);                     
                    ?>
  <tr bgcolor="<?php echo $rowColor; ?>">
    <span class="user_id" id="<?php echo $user_id; ?>" style="display: none;"></span>
    <span class="product_id" id="<?php echo $product_id; ?>" style="display: none;"></span> 
    <td width="246" align="left" valign="top" class="brdr_1"><span class="pointer south" title="<?php echo $super_name.'->'.$cat_name.'->'.$sub_name.'->';  ?><?php echo $sku_id.'-'.str_replace('"',"'",$tail); ?>" alt="<?php echo $super_name.'->'.$cat_name.'->'.$sub_name;  ?>"><?php echo $product_name; ?></span></td>
    <td width="78" align="right" valign="top" class="brdr_1"><?php echo $unit_price; ?></td>
    <td width="50" align="center" valign="top" class="brdr_1"><input type="text" class="qty_txt" id="qty_val_<?php echo $id; ?>" value="<?php echo $quantity; ?>"><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo $id; ?>','<?php echo $unit_price; ?>','<?php echo $price[0]['sub_total']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo $id; ?>','<?php echo $unit_price; ?>','<?php echo $price[0]['sub_total']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div>
    <td width="76" align="right" valign="top" class="brdr_1"><span id="line_prc_<?php echo $id; ?>"><?php echo number_format(($quantity * $unit_price), 2, '.', ''); ?></span></td>
    <td width="183" align="left" valign="top" class="brdr_1">
        <select name="shipping" id="shipping_<?php echo $product_id ?>" class="add_select shipping_<?php echo $product_id ?>" onchange="select_address('<?php echo $product_id ?>','<?php echo $user_id ?>');">
            <option value="0" >Select Shipping Address</option>
            <?php foreach ($shipping_address as $address) { 
                if($shipping_size == 1){ ?>
                  <option value="<?php echo $address['id'] ?>" selected="selected"><?php echo $address['company_name']; ?></option>  
                <?php }  else {    
                if ($address['id'] == $chk['shipping_add_id']) {
                ?>
                <option value="<?php echo $address['id'] ?>" selected="selected"><?php echo $address['company_name']; ?></option>
            <?php }else{ ?>
                <option value="<?php echo $address['id'] ?>" ><?php echo $address['company_name']; ?></option>
            <?php 
            }            
                }                
            } 
            ?><option value="N" >Enter a new address</option>
        </select></br>   
        <?php $select_address = SelectIdAddress($chk['shipping_add_id']);
        if(count($select_address) == '1'){
        echo $select_address[0]['company_name'].'</br>'.$select_address[0]['attention_to'].'</br>'.$select_address[0]['address_1'].'</br>'.$select_address[0]['address_2'].'</br>'.$select_address[0]['address_3'].'</br>'.$select_address[0]['city'].',  '.StateName($select_address[0]['state']).',  '.$select_address[0]['zip']; 
        }
        ?>
        <!--<span id="shipping_select_<?php echo $product_id ?>" class="jass none shipping_select_<?php echo $product_id ?>"><?php //echo $comp_name.'</br>'.$primary_shipping[0]['attention_to'].'</br>'.$primary_shipping[0]['address_1'].'</br>'.$primary_shipping[0]['address_2'].'</br>'.$primary_shipping[0]['address_3'].'</br>'.$primary_shipping[0]['city'].',  '.StateName($primary_shipping[0]['state']).',  '.$primary_shipping[0]['zip']; ?></span>-->        
    </td>
    <td width="90" align="center" valign="top" class="brdr_1"><input type="button" onclick="delete_product(<?php echo $product_id; ?>,<?php echo $user_id; ?>);" /></td>
  </tr>
  <?php
                    $i++;
                }
            }
 else {         ?>
      <tr align="center" bgcolor="#fff6f0">
          <td colspan="6" class="brdr_1">No Products Found</td>
      </tr> 
 <?php } ?>
  <tr bgcolor="#ffeee1">    
    <td colspan="4" align="right" valign="top" class="brdr_3 pad_none">
        <table width="210" border="0" cellspacing="0" cellpadding="0" class="first">
      <tr>
            <td width="85" valign="top" align="right" >Sub Total</td>
            <td width="40" align="right" class="brdr_4 pad_none"><span id="sub_total"><?php echo '$'.number_format($price[0]['sub_total'], 2, '.', ''); ?></span><input type="hidden" id="sub_total_txt" value="<?php echo number_format($price[0]['sub_total'], 2, '.', ''); ?>" /></td>
     </tr>
      <tr>
            <td width="40" valign="top" align="right" bgcolor="" class="tax">Tax</td>
            <td width="20" align="right" class="new"><span id="tax"><?php echo '$' .number_format($tax, 2, '.', ''); ?></span></td>
        </tr>
     <tr>
        <td width="74" valign="top" align="right" bgcolor="">Grand Total</td>
        <td width="40" align="right" class="grand_total" align="center"><span id="grand"><?php echo '$' . number_format(($price[0]['sub_total'] + $tax), 2, '.',''); ?></span></td>
      </tr>
    </table></td>
    <td colspan="2" align="center" valign="center" class="brdr_3 last_btn">
    <input type="submit" id="date_deli" class="btn_shopping trigger" value="PICKUP / DELIVERY DATE" style="float: left;" onclick="return open_date();" />        
    <input type="button" class="clearart cartattr" value="Checkout" onclick="finalize('<?php echo $user_id; ?>','<?php echo $comp_id; ?>','<?php echo $reference; ?>');" />   
    <!--<a href="test_cart.php?user_cart_id=<?php //echo $user_id; ?>&company_id=<?php //echo $comp_id; ?>&reference=<?php //echo $job_reference; ?>">Test Cart</a>-->
    <input type="hidden" name="cart_val" id="cart_val" value="<?php echo $cart_val; ?>"/>
    </td>
    </tr>
    </table>
</td>
  </tr>
  <tr>
        <td align="right" style="color: #FF9833;font-size: 11px;">
            Delivery charges to be applied as necessary
        </td>
    </tr>
</table>
</td>
  </tr>
</table>