<?php

include './admin/config.php';
include './admin/db_connection.php';

if (isset($_POST['user_id_clear']) && $_POST['user_id_clear'] != '') {
    $product_id         =       $_POST['product_id_clear'];
    $user_id            =       $_POST['user_id_clear'];
    $query = "DELETE FROM sohorepro_checkout WHERE user_id = '" . $user_id . "'";
    mysql_query($query);
    $checkout_product = checkOut($user_id);
    echo 'Removed the all products successfully~';
}
?>
<table width="740" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right" valign="middle" height="55" ><input type="button" onclick="return continue_shopping('<?php echo $user_id; ?>');" class="btn_shopping" value="Contiune Shopping"></td>
  </tr>
  <tr>
  <td align="left" valign="top">
  <table width="740" border="0" cellspacing="0" cellpadding="0" class="product_table" >
  <tr bgcolor="#ff7e00" class="h1">
    <td width="48" align="center" valign="middle" class="brdr_2" >S.NO</td>
    <td width="46" align="center" valign="middle" class="brdr_2" >SKU Id</td>
    <td width="115" align="left" valign="middle" class="brdr_2">Product Name</td>
    <td width="66" align="center" valign="middle" class="brdr_2">Unit Price</td>
    <td width="44" align="center" valign="middle" class="brdr_2">Qty</td>
    <td width="64" align="center" valign="middle" class="brdr_2">Line Price</td>
    <td width="243" align="left" valign="middle" class="brdr_2">Shipping Address</td>
    <td width="97" align="center" valign="middle" class="brdr_2">Option</td>
  </tr>
      <?php
            $i = 1;
            if (count($checkout_product) > 0) {
                foreach ($checkout_product as $chk) {
                    $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                    $id       = $chk['id'];
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
                    $quantity = $chk['quantity'];
                    $unit_price = $chk['unit_price'];
                    $price = getPriceCkt($user_id);
                    $tax_status = getTaxStatusChk($user_id);
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
    <td width="48" align="center" valign="top" class="brdr_1"><?php echo $i; ?></td>
    <td width="46" align="center" valign="top" class="brdr_1"><?php echo $sku_id; ?></td>
    <td width="115" align="left" valign="top" class="brdr_1"><?php echo $product_name; ?></td>
    <td width="66" align="right" valign="top" class="brdr_1"><?php echo $unit_price; ?></td>
    <td width="44" align="center" valign="top" class="brdr_1"><input type="text" class="qty_txt" id="qty_val_<?php echo $id; ?>" value="<?php echo $quantity; ?>"><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo $id; ?>','<?php echo $unit_price; ?>','<?php echo $price[0]['sub_total']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo $id; ?>','<?php echo $unit_price; ?>','<?php echo $price[0]['sub_total']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div>
    <td width="64" align="right" valign="top" class="brdr_1"><span id="line_prc_<?php echo $id; ?>"><?php echo number_format(($quantity * $unit_price), 2, '.', ''); ?></span></td>
    <td width="243" align="left" valign="top" class="brdr_1">&nbsp;</td>
    <td width="97" align="center" valign="top" class="brdr_1"><input type="button" onclick="delete_product(<?php echo $product_id; ?>,<?php echo $user_id; ?>);" /></td>
  </tr>
  <?php
                    $i++;
                }
            }
 else {         ?>
      <tr align="center" bgcolor="#fff6f0">
          <td colspan="8">There is no products</td>
      </tr> 
 <?php } ?>
  <tr bgcolor="#ffeee1">
    <td colspan="3" align="left" valign="top" class="brdr_3 pad_none" >
      <table width="220" border="0" cellspacing="0" cellpadding="0" class="first">
        <tr>
          <td width="85" valign="top" align="center" bgcolor="#ffffff">Sub Total</td>
          <td width="40" class="brdr_4 pad_none"><span id="sub_total"><?php echo '$'.number_format($price[0]['sub_total'], 2, '.', ''); ?></span><input type="hidden" id="sub_total_txt" value="" /></td>
          <td width="40" valign="top" align="center" bgcolor="#ffffff" class="tax">Tax</td>
          <td width="20" class="new"><span id="tax"><?php echo '$' .number_format($tax, 2, '.', ''); ?></span></td>
        </tr>
      </table></td>
    <td colspan="3" align="left" valign="top" class="brdr_3 pad_none"><table width="210" border="0" cellspacing="0" cellpadding="0" class="first">
      <tr>
        <td width="74" valign="top" align="center" bgcolor="#ffffff">Grand Total</td>
        <td width="40" class="grand_total" align="center"><span id="grand"><?php echo '$' . number_format(($price[0]['sub_total'] + $tax), 2, '.',''); ?></span></td>
      </tr>
    </table></td>
    <td colspan="2" align="left" valign="top" class="last_btn"><input type="button" class="clearart" value="Clear Cart" onclick="clear_cart(<?php echo $product_id; ?>,<?php echo $user_id; ?>);">
    <input type="button" class="clearart" value="Finalize">
   
  </td>
    </tr>
    </table>
</td>
  </tr>
</table>