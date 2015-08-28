<?php
include './config.php';
$Super = getSuperCategory();
$cumpony_id = $_POST['company_id'];
$special_pricelist=get_special_price($cumpony_id);                                                                                                                                                     
$sprice_product=array();
$sprice_dprice=array();                                                                            
foreach($special_pricelist as $newprice)
{
    $sprice_product[]=$newprice['sp_product_id'];
    $sprice_dprice[$newprice['sp_product_id']]=array();
    $sprice_dprice[$newprice['sp_product_id']][]=$newprice['sp_special_price'];                                                                                
    $sprice_dprice[$newprice['sp_product_id']][]=$newprice['sp_discount'];
    $sprice_dprice[$newprice['sp_product_id']][]=$newprice['sp_list_price']; 
    $sprice_dprice[$newprice['sp_product_id']][]=$newprice['sp_id']; 
}

$user_fav_product = get_fav_item($cumpony_id);
//print_r($user_fav_product);
$fav_product = array();
foreach ($user_fav_product as $fav) {
    $fav_product[$fav['product_id']] = $fav['product_id'];
}

foreach($Super as $super){ 
$c_id = $super['id'];
$Category = getCategoryU($c_id); 
?>
<div class="super_cat" style="clear:both;" id="acc"><h1  title="Super Category" alt="Super Category"><?php echo $super['category_name']; ?></h1></div>
<ul class="acc sub_cat" id="acc" style="display:none;">
<?php
foreach ($Category as $Cat) {
$s_id = $Cat['id'];
$SubCategory = getSubCategoryU($s_id);
?>
<li class="parent"> 
<h2><div style="width:25px; margin-left:45px; float:left;"></div><div id="title_name" class="main_catg"><h2  title="Category" alt="Category"><?php echo $Cat['category_name']; ?></h2></div>                                                                           
</h2>

<div class="acc-section" style="margin-bottom: 10px; display: none;">
<div class="acc-content">
<ul class="acc" id="nested108">
<?php
foreach ($SubCategory as $Subc) {
$su_id = $Subc['id'];
$ProductsUser = getProductsU($c_id,$s_id,$su_id);
?>    
<li>
<h3><div style="width:25px;margin-left:65px; float:left;"></div><div><h3 class="sub_catg" title="Sub Category" alt="Sub Category"><?php echo $Subc['category_name']; ?></h3></div><div class="oline"></div>                                                                            
</h3>
<?php if(count($ProductsUser)>0) { ?>  

<table width="100%" style="display: none;" class="acc-section"> 
<tbody>
<tr style="background-color: #F9F2DE;border-bottom: 1px solid #FF7E00; color:#fff;">                                                                            
<td align="center" height="30" valign="middle" bgcolor="#f68210"  class="brdr pad_lft">Product Name</td>
<td align="center" valign="middle" bgcolor="#f68210"  class="brdr pad_lft">List Price</td>
<td align="center" valign="middle" bgcolor="#f68210"  class="brdr pad_lft">Discount(%)</td>
<td align="center" valign="middle" bgcolor="#f68210"  class="brdr pad_lft">Selling Price</td>                                                                            
<td align="center" valign="middle" width="80" bgcolor="#f68210"  class="brdr">Action</td>
</tr>

<?php 
    $i = 1;
    foreach ($ProductsUser as $Product) { 
    $price_product  =   in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][2] : $Product['list_price'];
    $discount       =   in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][1] : $Product['discount'];
    $special_price  =   in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][0] : $Product['price'];
    $rowColor = ($i % 2 != 0) ? '#F9F2DE' : '#eeeeee';
    $fav_pro = in_array($Product['id'], $fav_product) ? 'fav' : 'un-fav';
    $pulse  =  in_array($Product['id'], $fav_product) ? 'pulse' : '';
    $fav_title = in_array($Product['id'], $fav_product) ? 'Click here to Un-favorites' : 'Click here to Favorites';
    ?> 
<tr style="background-color: <?php echo $rowColor; ?>;" class="inline" onclick="return inline_edit('<?php echo $Product['id']; ?>','<?php echo $cumpony_id; ?>');" id="<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>">
<span class="jass_p" id="<?php echo $Product['id']; ?>" style="display: none;"></span>                                                                             
<td style="text-align: center;"><div style="margin-left: 10px;float: left;" id="fav_id_<?php echo $Product['id']; ?>"><img src="images/<?php echo $fav_pro; ?>.png" border="0px" class="<?php echo $pulse; ?>" style="cursor: pointer;" title="<?php echo $fav_title; ?>" onclick="return add_favorites('<?php echo $Product['id']; ?>', '<?php echo $cumpony_id; ?>');" /></div><?php echo $Product['product_name']; ?> </td>
<td style="text-align:right;padding-right: 35px">
    <span class="list_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="list_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $price_product; ?></span>
    <input type="text" class="inline-text list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> list_list" id="list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $price_product; ?>" onkeypress="changeList(<?php echo $cumpony_id; ?>,'<?php echo $Product['id']; ?>')" style="display: none;"/>
</td>
<td style="text-align: center;">
    <span class="discount_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="discount_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $discount; ?></span>
    <input type="text" class="inline-text discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> discount_discount" id="discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $discount; ?>" onkeyup="return discount_change('<?php echo $Product['id']; ?>','<?php echo $cumpony_id; ?>');" style="display: none;"/>
</td>
<td style="text-align:center;">
    <span class="special_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="special_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $special_price; ?></span>
    <input type="text" class="inline-text special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> special_special" id="special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $special_price; ?>" onkeyup="return special_change('<?php echo $Product['id']; ?>','<?php echo $cumpony_id; ?>');" onkeydown="return discount_key($this);" style="display: none;"/>
</td>
<td style="width:80px" align="center" valign="middle"><img src="images/like_icon.png" onclick="update_sprice(<?php echo $cumpony_id; ?>,'<?php echo $Product['id']; ?>');"  alt="Update" title="Update" width="22" height="22" class="mar_lft updater_c update_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" style="margin-left: 23px; display: none;"/><img src="images/edit.png" alt="Edit" style="margin-left: 23px;" title="Edit" width="22" height="22" class="edit_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" /></td>
</tr>
<?php 
    $i++;
    } 
    ?>

</tbody>
</table>

<?php } ?>     

</li>
<?php } ?>
<li>
     <?php $super_subcatProductsUser = getsuper_subcatProducts($c_id,$s_id);

       if(count($super_subcatProductsUser)>0) {
       ?>

       <table width="100%"> 
       <tbody>
        <tr style="background-color: #F9F2DE;border-bottom: 1px solid #FF7E00;color:#fff;">                                                                            
        <td align="center" height="30" valign="middle" bgcolor="#f68210"  class="brdr pad_lft">Product Name</td>
        <td align="center" valign="middle" bgcolor="#f68210"  class="brdr pad_lft">List Price</td>
        <td align="center" valign="middle" bgcolor="#f68210"  class="brdr pad_lft">Discount(%)</td>
        <td align="center" valign="middle" bgcolor="#f68210"  class="brdr pad_lft">Selling Price</td>                                                                            
        <td align="center" valign="middle" width="80" bgcolor="#f68210"  class="brdr">Action</td>
        </tr>

       <?php 
        $j = 1;
        foreach ($super_subcatProductsUser as $Product) { 
        $price_product  =   in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][2] : $Product['list_price'];      
        $discount       =   in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][1] : $Product['discount'];
        $special_price  =   in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][0] : $Product['price'];
        $rowColor = ($j % 2 != 0) ? '#F9F2DE' : '#eeeeee';
        $fav_pro = in_array($Product['id'], $fav_product) ? 'fav' : 'un-fav';
        $pulse  =  in_array($Product['id'], $fav_product) ? 'pulse' : '';
        $fav_title = in_array($Product['id'], $fav_product) ? 'Click here to Un-favorites' : 'Click here to Favorites';
        ?> 
        <tr style="background-color: <?php echo $rowColor; ?>;" class="inline" onclick="return inline_edit('<?php echo $Product['id']; ?>','<?php echo $cumpony_id; ?>');" id="<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>">
        <span class="jass_p" id="<?php echo $Product['id']; ?>" style="display: none;"></span>                                                                             
        <td style="text-align: center;"><div style="margin-left: 10px;float: left;" id="fav_id_<?php echo $Product['id']; ?>"><img src="images/<?php echo $fav_pro; ?>.png" border="0px" style="cursor: pointer;" class="<?php echo $pulse; ?>" title="<?php echo $fav_title; ?>" onclick="return add_favorites('<?php echo $Product['id']; ?>', '<?php echo $cumpony_id; ?>');" /></div><?php echo $Product['product_name']; ?></td>
        <td style="text-align:right;padding-right: 35px">
            <span class="list_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="list_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $price_product; ?></span>
            <input type="text" class="inline-text list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> list_list" id="list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $price_product; ?>" onkeypress="changeList(<?php echo $cumpony_id; ?>,'<?php echo $Product['id']; ?>')" style="display: none;"/>
        </td>
        <td style="text-align: center;">
            <span class="discount_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="discount_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $discount; ?></span>
            <input type="text" class="inline-text discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> discount_discount" id="discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $discount; ?>" onkeyup="return discount_change('<?php echo $Product['id']; ?>','<?php echo $cumpony_id; ?>');" style="display: none;"/>
        </td>
        <td style="text-align:center;">
            <span class="special_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="special_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $special_price; ?></span>
            <input type="text" class="inline-text special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> special_special" id="special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $special_price; ?>" onkeyup="return special_change('<?php echo $Product['id']; ?>','<?php echo $cumpony_id; ?>');" onkeydown="return discount_key($this);" style="display: none;"/>
        </td> 
        <td style="width:80px" align="center" valign="middle"><img src="images/like_icon.png" onclick="update_sprice(<?php echo $cumpony_id; ?>,'<?php echo $Product['id']; ?>');"  alt="Update" title="Update" width="22" height="22" class="mar_lft updater_c update_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" style="margin-left: 23px; display: none;"/><img src="images/edit.png" alt="Edit" style="margin-left: 23px;" title="Edit" width="22" height="22" class="edit_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" /></td>
        </tr>
       <?php 
       $j++;
        }
        ?>

       </tbody></table>
        <?php } ?> 

    </li> 
</ul>

</div>
</div>

</li> 
<?php } ?>
    <li>

<?php 
$product_id = getProductId($id);                                                                            
$superProductsUser = getsuperProducts($c_id,$product_id['sp_product_id']);
if(count($superProductsUser)>0) {
?>
<table width="100%"> 
<tbody>
<tr style="background-color: #F9F2DE;border-bottom: 1px solid #FF7E00;color:#fff;">                                                                            
<td align="center" height="30" valign="middle" bgcolor="#f68210"  class="brdr pad_lft">Product Name</td>
<td align="center" valign="middle" bgcolor="#f68210"  class="brdr pad_lft">List Price</td>
<td align="center" valign="middle" bgcolor="#f68210"  class="brdr pad_lft">Discount(%)</td>
<td align="center" valign="middle" bgcolor="#f68210"  class="brdr pad_lft">Selling Price</td>                                                                            
<td align="center" valign="middle" width="80" bgcolor="#f68210"  class="brdr">Action</td>
</tr>
<?php 
    $k = 1;
    foreach ($superProductsUser as $Product) { 
    $special_price=in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][0] : $Product['price'];
    $price_product=in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][2] : $Product['list_price'];
    $discount = in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][1] : $Product['discount'];
    $rowColor = ($k % 2 != 0) ? '#F9F2DE' : '#eeeeee';
    $fav_pro = in_array($Product['id'], $fav_product) ? 'fav' : 'un-fav';
    $pulse  =  in_array($Product['id'], $fav_product) ? 'pulse' : '';
    $fav_title = in_array($Product['id'], $fav_product) ? 'Click here to Un-favorites' : 'Click here to Favorites';
    ?> 
<tr style="background-color: <?php echo $rowColor; ?>;" class="inline" onclick="return inline_edit('<?php echo $Product['id']; ?>','<?php echo $cumpony_id; ?>');" id="<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>">
<span class="jass_p" id="<?php echo $Product['id']; ?>" style="display: none;"></span>                                                                             
<td style="text-align: center;"><div style="margin-left: 10px;float: left;" id="fav_id_<?php echo $Product['id']; ?>"><img src="images/<?php echo $fav_pro; ?>.png" border="0px" style="cursor: pointer;" class="<?php echo $pulse; ?>" title="<?php echo $fav_title; ?>" onclick="return add_favorites('<?php echo $Product['id']; ?>', '<?php echo $cumpony_id; ?>');" /></div><?php echo $Product['product_name']; ?> </td>
<td style="text-align:right;padding-right: 35px">
    <span class="list_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="list_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $price_product; ?></span>
    <input type="text" class="inline-text list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> list_list" id="list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $price_product; ?>" onkeypress="changeList(<?php echo $cumpony_id; ?>,'<?php echo $Product['id']; ?>')" style="display: none;"/>
</td>
<td style="text-align: center;">
    <span class="discount_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="discount_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $discount; ?></span>
    <input type="text" class="inline-text discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> discount_discount" id="discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $discount; ?>" onkeyup="return discount_change('<?php echo $Product['id']; ?>','<?php echo $cumpony_id; ?>');" style="display: none;"/>
</td>
<td style="text-align:center;">
    <span class="special_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="special_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $special_price; ?></span>
    <input type="text" class="inline-text special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> special_special" id="special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $special_price; ?>" onkeyup="return special_change('<?php echo $Product['id']; ?>','<?php echo $cumpony_id; ?>');" onkeydown="return discount_key($this);" style="display: none;"/>
</td>
<td style="width:80px" align="center" valign="middle"><img src="images/like_icon.png" onclick="update_sprice(<?php echo $cumpony_id; ?>,'<?php echo $Product['id']; ?>');"  alt="Update" title="Update" width="22" height="22" class="mar_lft updater_c update_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" style="margin-left: 23px; display: none;"/><img src="images/edit.png" alt="Edit" style="margin-left: 23px;" title="Edit" width="22" height="22" class="edit_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" /></td>
</tr>
<?php 
$k++;
}
?>
</tbody>
</table>                                             
<?php } ?>  
    </li> 
</ul>
<?php } ?>
  
<script src="../js/jquery.js" type="text/javascript" ></script>
<script language="javascript" src="../store_files/script.js"></script> 
<script type="text/javascript" src="../store_files/scripts.js"></script>
<script language="javascript" src="js/value.js"></script>
<script language="javascript" src="js/customer.js"></script>