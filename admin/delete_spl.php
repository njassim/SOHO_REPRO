<?php
include './config.php';

if(isset($_POST['sp_id']) && $_POST['sp_id'] != '')
{ 
  $id                   = $_POST['sp_id'];
  $cumpony_id           = $_POST['user_id'];
  $query                = "DELETE FROM sohorepro_special_pricing WHERE sp_id = '" . $id . "' " ;
  mysql_query($query); 
  echo 'Special price deleted successfully'.'~';
 ?>
<div id="spl_<?php echo $cumpony_id; ?>">
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
    $special_price = getSpecialProduct($cumpony_id);
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
    <tr class="spl_tr_in" id="test_<?php echo $cumpony_id; ?>_<?php echo $special_id; ?>">                                                                                                                                                        
    <td class="spl_td_in"><?php echo $k; ?> </td>
    <td class="spl_td_in"><?php echo $super_name; ?> </td>
    <td class="spl_td_in"><?php echo $cat_name; ?> </td>
    <td class="spl_td_in"><?php echo $sub_name; ?> </td>
    <td class="spl_td_in"><?php echo $product_name; ?></td>
    <td class="spl_td_in"><?php echo $list_price; ?></td>
    <td class="spl_td_in"><?php echo $discount_price; ?></td>
    <td class="spl_td_in"><?php echo $selling_price; ?></td> 
    <td class="spl_td_action" align="center" valign="middle"><img src="images/like_icon_down.png" onclick="delete_special(<?php echo $special_id; ?>,<?php echo $cumpony_id; ?>);"  alt="Delete Specific Price" title="Delete Specific Price" width="22" height="22" class="mar_lft"/></td>
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

<table class="spl_tbl" width="755" align="center" cellspacing="0" cellpadding="0">
<tr>
    <td class="spl_h3_td" height="38" align="left" valign="middle">
        <!--<h3 class="mas_h3">Master Price List</h3>-->
        <span style="padding-left:12px; font-weight: normal; font-size: 16px; color:#f68210;">Master Price List</span>
        <a class="fav_button" href="edit_fav.php?comp_id=<?php echo $cumpony_id; ?>&page=<?php echo $page; ?>" style="float:right;text-decoration: none;margin-right: 15px;">FAVORITES</a>
    </td>
</tr> 

<tr>
    <td height="30" align="left" valign="middle">
    <!-- Category Section Start -->  
    <?php
    $Super = getSuperCategory();
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
    <div class="super_cat" id="acc"><h1  title="Super Category" alt="Super Category"><?php echo $super['category_name']; ?></h1></div>
    <ul class="acc sub_cat none" id="acc">
    <?php
    foreach ($Category as $Cat) {
    $s_id = $Cat['id'];
    $SubCategory = getSubCategoryU($s_id);
    ?>
    <li class="parent"> 
        <h2><div class="div1"></div><div id="title_name" class="main_catg"><h2  title="Category" alt="Category"><?php echo $Cat['category_name']; ?></h2></div>                                                                           
    </h2>
    
    <div class="acc-section">
    <div class="acc-content">
    <ul class="acc" id="nested108">
     <?php
    foreach ($SubCategory as $Subc) {
    $su_id = $Subc['id'];
    $ProductsUser = getProductsU($c_id,$s_id,$su_id);
    ?>   
    <li>
        <h3><div class="div2"></div><div><h3 class="sub_catg" title="Sub Category" alt="Sub Category"><?php echo $Subc['category_name']; ?></h3></div><div class="oline"></div>                                                                            
    </h3>
    <?php if(count($ProductsUser)>0) { ?>  

    <table width="100%" class="acc-section none"> 
    <tbody>
    <tr class="tr1">                                                                            
    <td align="center" height="30" valign="middle" class="brdr pad_lft tr1bg">Product Name</td>
    <td align="center" valign="middle" class="brdr pad_lft tr1bg">List Price</td>
    <td align="center" valign="middle" class="brdr pad_lft tr1bg">Discount(%)</td>
    <td align="center" valign="middle" class="brdr pad_lft tr1bg">Selling Price</td>                                                                            
    <td align="center" valign="middle" width="80" class="brdr tr1bg">Action</td>
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
    <td style="text-align: center;"><div style="margin-left: 10px;float: left;" id="fav_id_<?php echo $Product['id']; ?>"><img src="images/<?php echo $fav_pro; ?>.png" border="0px" style="cursor: pointer;" title="<?php echo $fav_title; ?>" class="<?php echo $pulse; ?>" onclick="return add_favorites('<?php echo $Product['id']; ?>', '<?php echo $cumpony_id; ?>');" /></div><?php echo $Product['product_name']; ?> </td>
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
    <tr class="tr1">                                                                            
    <td align="center" height="30" valign="middle" class="brdr pad_lft tr1bg">Product Name</td>
    <td align="center" valign="middle" class="brdr pad_lft tr1bg">List Price</td>
    <td align="center" valign="middle" class="brdr pad_lft tr1bg">Discount(%)</td>
    <td align="center" valign="middle" class="brdr pad_lft tr1bg">Selling Price</td>                                                                            
    <td align="center" valign="middle" width="80" class="brdr tr1bg">Action</td>
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
            <td style="text-align: center;"><div style="margin-left: 10px;float: left;" id="fav_id_<?php echo $Product['id']; ?>"><img src="images/<?php echo $fav_pro; ?>.png" border="0px" style="cursor: pointer;" title="<?php echo $fav_title; ?>" class="<?php echo $pulse; ?>" onclick="return add_favorites('<?php echo $Product['id']; ?>', '<?php echo $cumpony_id; ?>');" /></div><?php echo $Product['product_name']; ?> </td>
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

    </tbody>
           </table>
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
    <tr class="tr1">                                                                            
    <td align="center" height="30" valign="middle" class="brdr pad_lft tr1bg">Product Name</td>
    <td align="center" valign="middle" class="brdr pad_lft tr1bg">List Price</td>
    <td align="center" valign="middle" class="brdr pad_lft tr1bg">Discount(%)</td>
    <td align="center" valign="middle" class="brdr pad_lft tr1bg">Selling Price</td>                                                                            
    <td align="center" valign="middle" width="80" class="brdr tr1bg">Action</td>
    </tr>

    <?php 
    $k = 1;
    foreach ($superProductsUser as $Product) {     
    $price_product=in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][2] : $Product['list_price'];
    $discount = in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][1] : $Product['discount'];
    $special_price=in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][0] : $Product['price'];
    $rowColor = ($k % 2 != 0) ? '#F9F2DE' : '#eeeeee';
    $fav_pro = in_array($Product['id'], $fav_product) ? 'fav' : 'un-fav';
    $pulse  =  in_array($Product['id'], $fav_product) ? 'pulse' : '';
    $fav_title = in_array($Product['id'], $fav_product) ? 'Click here to Un-favorites' : 'Click here to Favorites';
    ?>  
    <tr style="background-color: <?php echo $rowColor; ?>;" class="inline" onclick="return inline_edit('<?php echo $Product['id']; ?>','<?php echo $cumpony_id; ?>');" id="<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>">
    <span class="jass_p" id="<?php echo $Product['id']; ?>" style="display: none;"></span>                                                                             
    <td style="text-align: center;"><div style="margin-left: 10px;float: left;" id="fav_id_<?php echo $Product['id']; ?>"><img src="images/<?php echo $fav_pro; ?>.png" border="0px" style="cursor: pointer;" title="<?php echo $fav_title; ?>" class="<?php echo $pulse; ?>" onclick="return add_favorites('<?php echo $Product['id']; ?>', '<?php echo $cumpony_id; ?>');" /></div><?php echo $Product['product_name']; ?> </td>
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
       <!-- Category Section End -->
    </td>                                                                            
</tr> 
</table>


<?php 
}
?>
<script language="javascript" src="js/value.js"></script> 
<script language="javascript" src="../store_files/script.js"></script> 
<!--<script type="text/javascript" src="../store_files/scripts.js"></script>-->
<!--<script src="../js/jquery.js" type="text/javascript" ></script>-->
