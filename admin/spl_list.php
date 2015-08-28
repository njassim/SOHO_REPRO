<?php
include './config.php';
$company_id = $_POST['company_id'];
?>
<table width="100%" > 
<tbody>
    <tr style="background-color: #F9F2DE;border-bottom: 1px solid #FF7E00; color:#fff;">                                                                            
        <td align="center" height="30" bgcolor="#f68210"  class="brdr">S.NO</td>
        <td align="center" valign="middle" bgcolor="#f68210"  class="brdr">Super Category</td>
        <td align="center" valign="middle" bgcolor="#f68210"  class="brdr">Category</td>
        <td align="center" valign="middle" bgcolor="#f68210"  class="brdr">Sub Category</td>
        <td align="center" valign="middle" bgcolor="#f68210"  class="brdr">Product Name</td>
        <td align="center" valign="middle" bgcolor="#f68210"  class="brdr">List Price</td>
        <td align="center" valign="middle" bgcolor="#f68210"  class="brdr">Discount(%)</td>
        <td align="center" valign="middle" bgcolor="#f68210"  class="brdr">Selling Price</td>                                                                            
        <td align="center" valign="middle" bgcolor="#f68210"  class="brdr">Action</td>
    </tr>

    <?php
    $special_price = getSpecialProduct($company_id);
    if (count($special_price) > 0) {
        $k = 1;
        foreach ($special_price as $Special_Product) {
            $super_id = getsuper($Special_Product['sp_product_id']);
            $cat_id = getcat($Special_Product['sp_product_id']);
            $sub_id = getsub($Special_Product['sp_product_id']);
            $super_name = getsuperN($super_id);
            $cat_name = getcatN($cat_id);
            $sub_name = getsubN($sub_id);
            $special_id = $Special_Product['sp_id'];
            $product_name = getorderProd($Special_Product['sp_product_id']);
            $list_price = $Special_Product['sp_list_price'];
            $discount_price = $Special_Product['sp_discount'];
            $selling_price = $Special_Product['sp_special_price'];
            ?> 

            <tr style="background-color: #F9F2DE;" id="test_<?php echo $cumpony_id; ?>_<?php echo $special_id; ?>">                                                                                                                                                        
                <td style="text-align: center;"><?php echo $k; ?> </td>
                <td style="text-align: center;"><?php echo $super_name; ?> </td>
                <td style="text-align: center;"><?php echo $cat_name; ?> </td>
                <td style="text-align: center;"><?php echo $sub_name; ?> </td>
                <td style="text-align: center;"><?php echo $product_name; ?></td>
                <td style="text-align: center;"><?php echo $list_price; ?></td>
                <td style="text-align: center;"><?php echo $discount_price; ?></td>
                <td style="text-align: center;"><?php echo $selling_price; ?></td> 
                <td style="width:80px" align="center" valign="middle"><img src="images/like_icon_down.png" onclick="delete_special(<?php echo $special_id; ?>,<?php echo $cumpony_id; ?>);"  alt="Delete Specific Price" title="Delete Specific Price" width="22" height="22" class="mar_lft"/></td>
            </tr>

            <?php
            $k++;
        }
    } else {
        ?>


        <tr style="background-color: #F9F2DE;">
            <td colspan="10" align="center">There is no specific price products.</td>
        </tr>
<?php
}
?>
</tbody>
</table>
  
<script src="../js/jquery.js" type="text/javascript" ></script>
<script language="javascript" src="../store_files/script.js"></script> 
<script type="text/javascript" src="../store_files/scripts.js"></script>
<script language="javascript" src="js/value.js"></script>
<script language="javascript" src="js/customer.js"></script>