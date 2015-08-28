<?php
include './config.php';

//Retrive the company name using search field
if (isset($_GET['q'])) {
    $search = $_GET['q'];

    if ($_GET['q'] != '') {
        $select_user = mysql_query("select * from sohorepro_company where (comp_name like '$search%') order by comp_name ");


        while ($fth_user = mysql_fetch_array($select_user)) {
            echo $fth_user['comp_name'] . "\n";
        }
    }
}



//Retrive the company data to load the form
if (isset($_REQUEST['search_val'])) {
    $search = $_REQUEST['search_val'];

    if (strlen($search) > 1) {
        $select_users = mysql_query("select * from sohorepro_company where (comp_name like '%$search%') ");
    } else {
        $select_users = mysql_query("select * from sohorepro_company ");
    }
    ?>
    <table width="759" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="36" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">NO.</td>                                                        
            <td width="100" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="customers.php?sort=<?php echo $sort_sku; ?>">Company Name&nbsp;<img src="images/<?php echo $sort_sku_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>                                                                   
            <td width="64" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>    
        </tr>    
    <?php
    $i = 1;
    if (mysql_num_rows($select_users) > 0) {
        while ($fth_userss = mysql_fetch_array($select_users)) {
            $id = $fth_userss['cus_id'];
            $cumpony_id = $fth_userss['comp_id'];
            $company_name = $fth_userss['comp_name'];
            $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
            $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
            $status = ($fth_userss['cus_status'] == 1) ? 'active' : 'de-active';
            $cus_email = $fth_userss['cus_email'];
            $cus_regdate = date("m-d-Y", strtotime($fth_userss['cus_regdate']));
            $user_name = $fth_userss['cus_fname'];
            $user_phone = $fth_userss['cus_contact_phone'];
            $user_fname = $fth_userss['cus_fname'];
            $user_lname = $fth_userss['cus_lname'];
            $user_address1 = $fth_userss['cus_bill_address1'];
            $user_address2 = $fth_userss['cus_bill_address2'];
            $user_room = $fth_userss['cus_bill_room'];
            $tax = ($fth_userss['cus_tax_exe'] == 1) ? 'Yes' : 'No';


            $Super = getSuperCategory($sorting);
            ?>

                <tr class="trigger" id="<?php echo $id; ?>">
                    <td width="49"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>
                    <td width="100" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="pad_btm"><?php echo $company_name; ?></td>
                    <td width="80"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><a href="edit_user.php?id=<?php echo $id; ?>"><img src="images/edit.png"  alt="Edit" title="Edit" width="22" height="22"/></a><a href="customers.php?delete_id=<?php echo $id; ?>" onclick="return confirm('Are you sure want to delete this user?');"><img src="images/del.png"  alt="Delete" title="Delete" width="22" height="22" class="mar_lft"/></a></td>
                </tr>
                <tr class="test_<?php echo $id; ?>" style="display: none;">
                    <td colspan="5">
                        <table width="755" border="0">
                            <tr align="center">
                                <td class="inf"> &nbsp;</td>
                                <td class="inf" height="35">Business Information</td>
                            </tr>
                            <tr>
                                <!--Personal Table Start-->
                                <td align="center">
                                    <table border="0" width="260">
                                        <tr>
                                            <td class="inf"> &nbsp;</td>
                                            <td><?php //echo $user_fname;  ?></td>
                                        </tr>
                                        <tr>
                                            <td class="inf"> &nbsp;</td>
                                            <td><?php //echo $user_lname;  ?></td>
                                        </tr>
                                        <tr>
                                            <td class="inf"> &nbsp;</td>
                                            <td><?php //echo $cus_email;  ?></td>
                                        </tr>
                                        <tr>
                                            <td class="inf"> &nbsp;</td>
                                            <td><?php //echo $user_phone;  ?></td>
                                        </tr>
                                    </table>
                                </td>
                                <!--Personal Table Start End-->
                                <!--Business Table Start-->
                                <td align="center">
                                    <table border="0" width="250">
                                        <tr>
                                            <td class="inf">Company Name</td>
                                            <td><?php echo $company_name; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="inf">Business address 1</td>
                                            <td><?php echo $user_address1; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="inf">Business address 2</td>
                                            <td><?php echo $user_address2; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="inf">Room Number</td>
                                            <td><?php echo $user_room; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="inf">Tax Exemption</td>
                                            <td><?php echo $tax; ?></td>
                                        </tr>
                                    </table>
                                </td>
                                <!--Business Table Start End-->
                            </tr>
                        </table>

                        <table width="755" align="center" cellspacing="0" cellpadding="0" style="margin:10px 0px; border: 2px solid #F99B3E; font-family:arial">
                            <tr>
                                <td bgcolor="#f1f1f1" height="38" align="left" valign="middle"><h3 style="padding-left:12px; font-weight: normal; font-size: 16px; color:#f68210;">Specific Pricing</h3></td>
                            </tr> 
                            <span class="succ" style="color:#007F2A;font-size: 12px;"  ></span>
                            <tr>
                                <td height="30" align="left" valign="middle">

                                    <!---Special Pricing Start --->   

                                    <table width="100%"> 
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
            $special_price = getSpecialProduct($cumpony_id);
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
                                                    <tr style="background-color: #F9F2DE;" id="test_jass">                                                                                                                                                        
                                                        <td style="text-align: center;"><?php echo $k; ?> </td>
                                                        <td style="text-align: center;"><?php echo $super_name; ?> </td>
                                                        <td style="text-align: center;"><?php echo $cat_name; ?> </td>
                                                        <td style="text-align: center;"><?php echo $sub_name; ?> </td>
                                                        <td style="text-align: center;"><?php echo $product_name; ?></td>
                                                        <td style="text-align: center;"><?php echo $list_price; ?></td>
                                                        <td style="text-align: center;"><?php echo $discount_price; ?></td>
                                                        <td style="text-align: center;"><?php echo $selling_price; ?></td> 
                                                        <td style="width:80px" align="center" valign="middle"><img src="images/like_icon_down.png" onclick="delete_special(<?php echo $special_id; ?>);"  alt="Delete Specific Price" title="Delete Specific Price" width="22" height="22" class="mar_lft"/></td>
                                                    </tr>
                                                    <?php
                                                    $k++;
                                                }
                                            } else {
                                                ?>
                                                <tr style="background-color: #F9F2DE;">
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

                        <table width="755" align="center" cellspacing="0" cellpadding="0" style="margin:10px 0px; border: 2px solid #F99B3E; font-family:arial">
                            <tr>
                                <td bgcolor="#f1f1f1" height="38" align="left" valign="middle"><h3 style="padding-left:12px; font-weight: normal; font-size: 16px; color:#f68210;">Master Price List</h3></td>
                            </tr> 

                            <tr>
                                <td height="30" align="left" valign="middle">
                                    <!-- Category Section Start -->  
            <?php
            $special_pricelist = get_special_price($cumpony_id);
//                                                                                                                                                     
            $sprice_product = array();
            $sprice_dprice = array();
            $sprice_discount = array();
            foreach ($special_pricelist as $newprice) {
                $sprice_product[] = $newprice['sp_product_id'];
                $sprice_dprice[$newprice['sp_product_id']] = array();
                $sprice_dprice[$newprice['sp_product_id']][] = $newprice['sp_special_price'];
                $sprice_dprice[$newprice['sp_product_id']][] = $newprice['sp_discount'];
                $sprice_dprice[$newprice['sp_product_id']][] = $newprice['sp_list_price'];
                $sprice_dprice[$newprice['sp_product_id']][] = $newprice['sp_id'];
            }
            foreach ($Super as $super) {
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
                                            <?php
                                            foreach ($SubCategory as $Subc) {
                                                $su_id = $Subc['id'];
                                                $ProductsUser = getProductsU($c_id, $s_id, $su_id);
                                                ?>
                                                        <div class="acc-section" style="margin-bottom: 10px; display: none;">
                                                            <div class="acc-content">
                                                                <ul class="acc" id="nested108">
                                                                    <li>
                                                                        <h3><div style="width:25px;margin-left:65px; float:left;"></div><div><h3 class="sub_catg" title="Sub Category" alt="Sub Category"><?php echo $Subc['category_name']; ?></h3></div><div class="oline"></div>                                                                            
                                                                        </h3>
                                                    <?php if (count($ProductsUser) > 0) { ?>  

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
                            foreach ($ProductsUser as $Product) {
                                $price_product = in_array($Product['id'], $sprice_product) ? $sprice_dprice[$Product['id']][2] : $Product['price'];
                                $discount = in_array($Product['id'], $sprice_product) ? $sprice_dprice[$Product['id']][1] : '00.00';
                                $special_price = in_array($Product['id'], $sprice_product) ? $sprice_dprice[$Product['id']][0] : '00.00';
                                ?> 
                                                                                        <tr style="background-color: #F9F2DE;" class="inline" id="<?php echo $Product['id']; ?>_<?php echo $id; ?>">
                                                                                    <span class="jass_p" id="<?php echo $Product['id']; ?>" style="display: none;"></span>                                                                             
                                                                                    <td style="text-align: center;"><?php echo $Product['product_name']; ?> </td>
                                                                                    <td style="text-align:right;padding-right: 35px"><span class="list_price_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" id="list_price_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>"><?php echo $price_product; ?></span><input type="text" class="inline-text list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $id; ?> list_list" id="list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" value="<?php echo $price_product; ?>" style="display: none;"/></td>
                                                                                    <td style="text-align: center;"><span class="discount_price_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" id="discount_price_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>"><?php echo $discount; ?></span><input type="text" class="inline-text discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $id; ?> discount_discount" id="discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" value="<?php echo $discount; ?>" style="display: none;"/></td>
                                                                                    <td style="text-align:center;"><span class="special_price_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" id="special_price_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>"><?php echo $special_price; ?></span><input type="text" class="inline-text special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $id; ?> special_special" id="special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" value="<?php echo $special_price; ?>" style="display: none;"/></td> 
                                                                                    <td style="width:80px" align="center" valign="middle"><img src="images/like_icon.png" onclick="update_sprice(<?php echo $cumpony_id; ?>, '<?php echo $Product['id']; ?>');"  alt="Update" title="Update" width="22" height="22" class="mar_lft updater_c update_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" style="display: none;"/><img src="images/edit.png" alt="Edit" style="margin-left: 0px;" title="Edit" width="22" height="22" class="edit_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" /></td>
                                                                                    </tr>
                            <?php } ?>

                                                                                </tbody>
                                                                            </table>

                                                                                <?php } ?>     

                                                                    </li>
                                                                    <li>
                        <?php
                        $super_subcatProductsUser = getsuper_subcatProducts($c_id, $s_id);

                        if (count($super_subcatProductsUser) > 0) {
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
                                                                            foreach ($super_subcatProductsUser as $Product) {
                                                                                $price_product = in_array($Product['id'], $sprice_product) ? $sprice_dprice[$Product['id']][2] : $Product['price'];
                                                                                $discount = in_array($Product['id'], $sprice_product) ? $sprice_dprice[$Product['id']][1] : '00.00';
                                                                                $special_price = in_array($Product['id'], $sprice_product) ? $sprice_dprice[$Product['id']][0] : '00.00';
                                                                                ?> 
                                                                                        <tr style="background-color: #F9F2DE;" class="inline" id="<?php echo $Product['id']; ?>_<?php echo $id; ?>">
                                                                                    <span class="jass_p" id="<?php echo $Product['id']; ?>" style="display: none;"></span>                                                                             
                                                                                    <td style="text-align: center;"><?php echo $Product['product_name']; ?> </td>
                                                                                    <td style="text-align:right;padding-right: 35px"><span class="list_price_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" id="list_price_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>"><?php echo $price_product; ?></span><input type="text" class="inline-text list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $id; ?> list_list" id="list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" value="<?php echo $price_product; ?>" style="display: none;"/></td>
                                                                                    <td style="text-align: center;"><span class="discount_price_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" id="discount_price_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>"><?php echo $discount; ?></span><input type="text" class="inline-text discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $id; ?> discount_discount" id="discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" value="<?php echo $discount; ?>" style="display: none;"/></td>
                                                                                    <td style="text-align:center;"><span class="special_price_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" id="special_price_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>"><?php echo $special_price; ?></span><input type="text" class="inline-text special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $id; ?> special_special" id="special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" value="<?php echo $special_price; ?>" style="display: none;"/></td> 
                                                                                    <td style="width:80px" align="center" valign="middle"><img src="images/like_icon.png" onclick="update_sprice(<?php echo $cumpony_id; ?>, '<?php echo $Product['id']; ?>');"  alt="Update" title="Update" width="22" height="22" class="mar_lft updater_c update_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" style="margin-left: 0px; display: none;"/><img src="images/edit.png" alt="Edit" style="margin-left: 0px;" title="Edit" width="22" height="22" class="edit_c_<?php echo $Product['id']; ?>_<?php echo $id; ?>" /></td>
                                                                                    </tr>
                                                                                    <?php } ?>

                                                                                </tbody></table>
                                                                                <?php } ?> 

                                                                    </li> 
                                                                </ul>

                                                            </div>
                                                        </div>
                    <?php } ?>
                                                </li> 
                                                                    <?php } ?>
                                            <li>

                                                                <?php
                                                                $product_id = getProductId($id);
                                                                $superProductsUser = getsuperProducts($c_id, $product_id['sp_product_id']);
                                                                if (count($superProductsUser) > 0) {
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
                                                    foreach ($superProductsUser as $Product) {
                                                        $special_price = in_array($Product['id'], $sprice_product) ? $sprice_dprice[$Product['id']][0] : '00.00';
                                                        $price_product = in_array($Product['id'], $sprice_product) ? $sprice_dprice[$Product['id']][2] : $Product['price'];
                                                        $discount = in_array($Product['id'], $sprice_product) ? $sprice_dprice[$Product['id']][1] : '00.00';
                                                        ?> 
                                                                <tr style="background-color: #F9F2DE;" class="inline" id="<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>">
                                                            <span class="jass_p" id="<?php echo $Product['id']; ?>" style="display: none;"></span>                                                                             
                                                            <td style="text-align: center;"><?php echo $Product['product_name']; ?> </td>
                                                            <td style="text-align:right;padding-right: 35px"><span class="list_price_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" id="list_price_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>"><?php echo $price_product; ?></span><input type="text" class="inline-text list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> list_list" id="list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $price_product; ?>" onkeypress="changeList(<?php echo $cumpony_id; ?>, '<?php echo $Product['id']; ?>')" style="display: none;"/></td>
                                                            <td style="text-align: center;"><span class="discount_price_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" id="discount_price_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>"><?php echo $discount; ?></span><input type="text" class="inline-text discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> discount_discount" id="discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $discount; ?>" style="display: none;"/></td>
                                                            <td style="text-align:center;"><span class="special_price_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" id="special_price_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>"><?php echo $special_price; ?></span><input type="text" class="inline-text special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> special_special" id="special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $special_price; ?>" style="display: none;"/></td> 
                                                            <td style="width:80px" align="center" valign="middle"><img src="images/like_icon.png" onclick="update_sprice(<?php echo $cumpony_id; ?>, '<?php echo $Product['id']; ?>');"  alt="Update" title="Update" width="22" height="22" class="mar_lft updater_c update_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" style="margin-left: 23px; display: none;"/><img src="images/edit.png" alt="Edit" style="margin-left: 23px;" title="Edit" width="22" height="22" class="edit_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" /></td>
                                                            </tr>
                                                                <?php
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

                    </td>  
                </tr>

                                            <?php $i++;
                                        }
                                    } else { ?>

            <tr align="center">
                <td colspan="8">There is no users</td>
            </tr>
    <?php } ?>                                                       
    </table>



    <?php } ?>
<script language="javascript" src="js/value.js"></script> 
<script language="javascript" src="../store_files/script.js"></script> 
<script type="text/javascript" src="../store_files/scripts.js"></script>

