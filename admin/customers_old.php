<?php
include './config.php';
$Super = getSuperCategory();

//$sort_pn            = ($_REQUEST['sort'] == 'pna') ? 'pnd' : 'pna';
//$sort_pn_img        = ($_REQUEST['sort'] == 'pna') ? 'down' : 'up';

$sort_sku           = ($_REQUEST['sort'] == 'pea') ? 'ped' : 'pea';    
$sort_sku_img       = ($_REQUEST['sort'] == 'pea') ? 'down' : 'up';

$sort_price         = ($_REQUEST['sort'] == 'pda') ? 'pdd' : 'pda';
$sort_price_img     = ($_REQUEST['sort'] == 'pda') ? 'down' : 'up';

$users = getusers_list($_REQUEST['sort']);

$active_category = getCategoryActive();


if ($_GET['delete_id']) {

    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM sohorepro_customers WHERE cus_id = " . $delete_id . " ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_del";
    } else {
        $result = "failure_del";
    }
}

if ($_GET['delete_product_id']) {

    $delete_id = $_GET['delete_product_id'];
    $sql = "DELETE FROM sohorepro_special_pricing WHERE sp_id = " . $delete_id . " ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_del_cus";
    } else {
        $result = "failure_del_cus";
    }
}
?>
<?php
if ($_GET['status_id']) {

    $change_status = ($_GET['change_id'] == 1) ? '0' : '1';
    $status_id = $_GET['status_id'];
    $sql = "UPDATE sohorepro_customers
			SET    cus_status     = '" . $change_status . "' WHERE cus_id= '" . $status_id . "'";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_status";
    } else {
        $result = "failure_status";
    }
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Soho-repro</title>
        
    </head>
<link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="style/customer-css.css" rel="stylesheet" type="text/css" media="all" />  
        <script src="../js/jquery.js" type="text/javascript" ></script>
        <script language="javascript" src="../store_files/script.js"></script> 
        <script type="text/javascript" src="../store_files/scripts.js"></script>
        <script language="javascript" src="js/value.js"></script>
        <script language="javascript" src="js/customer.js"></script>
    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center" valign="top">
                    <table width="960" border="0" cellspacing="0" cellpadding="0" style="min-width:760px;">
                        <tr>
                            <td width="198" align="left" valign="top" bgcolor="#464646"><table width="198" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="185" align="left" valign="top"><img src="images/logo.jpg" width="198" height="181"  alt=""/></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <?php include "sidebar_menu.php"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle" style="height:280px; float:left;"></td>
                                    </tr>
                                </table></td>
                            <td width="3" align="left" valign="top" bgcolor="#FFFFFF"></td>
                            <td width="759" align="left" valign="top" bgcolor="#FFFFFF"><table width="759" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="48" align="center" valign="middle" bgcolor="#5f5f5f" class="heading">
                                            ADMINISTRATOR PAGE
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="38" align="center" valign="middle" bgcolor="#8b8b8b" class="sub_heading">
                                            CUSTOMERS
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="14" align="left" valign="middle"></td>
                                    </tr> 
                                    <tr>
                                        <td align="right" valign="top"><table width="759" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="38" align="left" valign="middle" class="add_title">Search</td>
                                                </tr>
                                                <tr>
                                                    <td height="60" align="left" valign="top" bgcolor="#f6f6f6" class="form_bg">
                                                        <form name="new_supercategory" id="new_supercategory" method="post" action=""  onsubmit="return validate()" >
                                                            <input type="hidden" name="new_cat" value="1" />       
                                                            <table width="600" border="0" cellspacing="0" cellpadding="0" >
                                                                <tr style="float:left;">
                                                                    <td width="160" height="60" align="right" valign="middle">
                                                                    <input class="input_text" type="text" name="search_val" id="search_val" type="text" placeholder="Seach Company" onkeydown="load_userinfo();" style="width:300px !important; margin-left: 25px;" ></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="9" style="color:#F00; text-align:center; font-size: 12px;">
                                                                        <?php
                                                                        if ($result == "success") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Inserted Successfully</div>
                                                                            <script>setTimeout("location.href=\'customers.php\'", 1000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Not Successfully</div>
                                                                            <script>setTimeout("location.href=\'customers.php\'", 1000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($result == "success_del") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Deleted Successfully</div>
                                                                            <script>setTimeout("location.href=\'customers.php\'", 1000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_del") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Not Deleted</div>
                                                                            <script>setTimeout("location.href=\'customers.php\'", 1000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                         <?php
                                                                        if ($result == "success_del_cus") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Deleted Successfully</div>
                                                                            <script>setTimeout("location.href=\'customers.php\'", 1000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_del_cus") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Not Deleted</div>
                                                                            <script>setTimeout("location.href=\'customers.php\'", 1000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($result == "success_status") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Status change successfully</div>
                                                                            <script>setTimeout("location.href=\'customers.php\'", 1000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_status") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Status change not successfully</div>
                                                                            <script>setTimeout("location.href=\'customers.php\'", 1000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>   
                                                                        <div id="msg1" style="color:#FF0000;padding-left:35px;font-size: 12px;"></div>
                                                                        <div id="msg2" style="color:#FF0000;padding-left:35px;font-size: 12px; display: none;"></div>
                                                                        <div id="msg" style="color:#007F2A; font-size: 13px;"></div>
                                                                        <span class="check" style="color:#FF0000;padding-left:35px;font-size: 12px;"  ></span>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </form>   
                                                    </td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top">
                                            
                                             
                                                <table width="759" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td width="36" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>                                                        
                                                        <td width="100" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="customers.php?sort=<?php echo $sort_sku; ?>">Company Name&nbsp;<img src="images/<?php echo $sort_sku_img ; ?>.png"  alt="" width="10px" height="5px"/></a></td>
                                                        <td width="85" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="customers.php?sort=<?php echo $sort_price; ?>">Reg Date&nbsp;<img src="images/<?php echo $sort_price_img ; ?>.png"  alt="" width="10px" height="5px"/></a></td>
                                                        <td width="20" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">status</td>
                                                        <td width="64" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                    </tr>
                                                </table>
                                            <div id="load_userdata">
                                                <table width="759" border="0" cellspacing="0" cellpadding="0" class="tbl_repeatpro">
                                                    <?php
                                                    $i = 1;
                                                    if (count($users) > 0) {
                                                        foreach ($users as $Prod) {
                                                            $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                            $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                            $id = $Prod['cus_id'];
                                                            $cumpony_id = $Prod['comp_id'];
                                                            $cus_email = $Prod['cus_email'];
                                                            $cus_regdate= date("m-d-Y", strtotime($Prod['cus_regdate']));   
                                                            $company_name= $Prod['comp_name'];                                                           
                                                            $user_address1 = $Prod['comp_business_address1'];
                                                            $user_address2 = $Prod['comp_business_address2'];
                                                            $user_room = $Prod['comp_room'];
                                                            $tax = ($Prod['cus_tax_exe'] == 1) ? 'Yes' : 'No';
                                                            $status = ($Prod['cus_status'] == 1) ? 'active' : 'de-active';
                                                            ?>                                                
                                                            <tr class="trigger" id="<?php echo $id; ?>">
                                                                <td width="49"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>                                                                
                                                                <td width="100" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="pad_btm"><?php echo $company_name; ?></td>
                                                                <td width="85"  align="left" valign="middle" bgcolor="<?php echo $rowColor; ?>" style="padding-left: 50px;" class="pad_btm"><?php echo $cus_regdate; ?></td>
                                                                <td width="60"  align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><a href="customers.php?status_id=<?php echo $id; ?>&change_id=<?php echo $Prod['cus_status']; ?>" onclick="return confirm('Are you sure want to change the status?');"><img src="images/<?php echo $status; ?>.png" width="22" height="22"  alt="Status" title="Status"/></a></td>
                                                                <td width="80"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><a href="edit_user.php?id=<?php echo $id; ?>"><img src="images/edit.png"  alt="Edit" title="Edit" width="22" height="22"/></a><a href="customers.php?delete_id=<?php echo $id; ?>" onclick="return confirm('Are you sure want to delete this user?');"><img src="images/del.png"  alt="Delete" title="Delete" width="22" height="22" class="mar_lft"/></a></td>
                                                            </tr>
                                                            <tr class="test_<?php echo $id; ?>" style="display: none;">
                                                                <td colspan="5">
                                                                    
                                                                    <!--Section 1--->
                                                                    <table width="755" border="0">
                                                                        <tr align="left">
                                                                            <td class="inf" style="padding-left: 3px;">Business Information</td>
                                                                            <td class="inf" style="padding-left: 2px;">User Information</td>
                                                                        </tr>
                                                                        <tr>                                                                           
                                                                            <!--Business Table Start-->
                                                                            <td align="left">
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
                                                                            <?php $customer_per_company = custPerComp($cumpony_id);?>
                                                                            <!--Personal Table Start-->
                                                                            <td align="left">
                                                                                <table border="0" width="280">
                                                                                    <tr>
                                                                                        <td class="inf">Select User</td>
                                                                                        <td align="left" style="padding-right: 35px;">
                                                                                            <span class="cus_id none" id="<?php echo $customer_per_company[0]['cus_id']; ?>"></span> 
                                                                                            <div id="user_select_box_<?php echo $cumpony_id; ?>_<?php echo $customer_per_company[0]['cus_id']; ?>">
                                                                                            <select name="customer_name" id="<?php echo $cumpony_id; ?>" class="customer_name_<?php echo $cumpony_id; ?> select_customer">
                                                                                                <option value="0">--Customers--</option>                                                                                                
                                                                                                <?php foreach ($customer_per_company as $customers) { ?>
                                                                                                <option value="<?php echo $customers['cus_id'];?>"><?php echo $customers['cus_contact_name']; ?></option>
                                                                                                    <?php } ?>                                                                                               
                                                                                            </select>                                                                                            
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="2" height="70">
<!--                                                                                            <div id="jassim"></div>-->
                                                                                            <div id="customer_dtls_<?php echo $cumpony_id; ?>">
                                                                                            
                                                                                            </div> 
                                                                                            <div id="jass">
                                                                                                
                                                                                            </div>
                                                                                        </td>                                                                                           
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                            <!--Personal Table Start End-->
                                                                        </tr>
                                                                    </table>
                                                                    <!--Section 1 END--->
                                                                    
                                                                    
                                                                    <!--Section 2 Start--->
                                                                    <span class="succ" id="succ" style="color:#007F2A;font-size: 12px;"  ></span>
                                                                    <div id="mas_<?php echo $cumpony_id; ?>">
                                                                    <div id="spl_<?php echo $cumpony_id; ?>">
                                                                    <table id="spl" width="755" align="center" cellspacing="0" cellpadding="0" style="margin:10px 0px; border: 2px solid #F99B3E; font-family:arial">
                                                                        <tr>
                                                                            <td bgcolor="#f1f1f1" height="38" align="left" valign="middle"><h3 style="padding-left:12px; font-weight: normal; font-size: 16px; color:#f68210;">Specific Pricing</h3></td>
                                                                        </tr>                                                                  
                                                                        <tr>
                                                                            <td height="30" align="left" valign="middle" class="content_1">
                                                                                
                                                                                <!---Special Pricing Start --->   
                                                                                   
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
                                                                            }
                                                                            else
                                                                            {
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
                                                                    </div>
                                                                    <!--Section 2 END--->    
                                                                    
                                                                    <!--Section 3 Start--->
                                                                    <table width="755" align="center" cellspacing="0" cellpadding="0" style="margin:10px 0px; border: 2px solid #F99B3E; font-family:arial">
                                                                        <tr>
                                                                            <td bgcolor="#f1f1f1" height="38" align="left" valign="middle"><h3 style="padding-left:12px; font-weight: normal; font-size: 16px; color:#f68210;">Master Price List</h3></td>
                                                                        </tr> 
                                                                        
                                                                        <tr>
                                                                            <td height="30" align="left" valign="middle">
                                                                            <!-- Category Section Start -->  
                                                                            <?php
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

                                                                            <?php foreach ($ProductsUser as $Product) { 
                                                                                $price_product  =   in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][2] : $Product['list_price'];
                                                                                $discount       =   in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][1] : "0.00";
                                                                                $special_price  =   in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][0] : $Product['list_price'];
                                                                                ?> 
                                                                            <tr style="background-color: #F9F2DE;" class="inline" id="<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>">
                                                                            <span class="jass_p" id="<?php echo $Product['id']; ?>" style="display: none;"></span>                                                                             
                                                                            <td style="text-align: center;"><?php echo $Product['product_name']; ?> </td>
                                                                            <td style="text-align:right;padding-right: 35px"><span class="list_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="list_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $price_product; ?></span><input type="text" class="inline-text list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> list_list" id="list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $price_product; ?>" onkeypress="changeList(<?php echo $cumpony_id; ?>,'<?php echo $Product['id']; ?>')" style="display: none;"/></td>
                                                                            <td style="text-align: center;"><span class="discount_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="discount_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $discount; ?></span><input type="text" class="inline-text discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> discount_discount" id="discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $discount; ?>" style="display: none;"/></td>
                                                                            <td style="text-align:center;"><span class="special_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="special_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $special_price; ?></span><input type="text" class="inline-text special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> special_special" id="special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $special_price; ?>" style="display: none;"/></td> 
                                                                            <td style="width:80px" align="center" valign="middle"><img src="images/like_icon.png" onclick="update_sprice(<?php echo $cumpony_id; ?>,'<?php echo $Product['id']; ?>');"  alt="Update" title="Update" width="22" height="22" class="mar_lft updater_c update_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" style="margin-left: 23px; display: none;"/><img src="images/edit.png" alt="Edit" style="margin-left: 23px;" title="Edit" width="22" height="22" class="edit_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" /></td>
                                                                            </tr>
                                                                            <?php } ?>

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

                                                                                   <?php foreach ($super_subcatProductsUser as $Product) { 
                                                                                    $price_product  =   in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][2] : $Product['list_price'];      
                                                                                    $discount       =   in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][1] : "0.00";
                                                                                    $special_price  =   in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][0] : $Product['list_price'];
                                                                                    ?> 
                                                                                    <tr style="background-color: #F9F2DE;" class="inline" id="<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>">
                                                                                    <span class="jass_p" id="<?php echo $Product['id']; ?>" style="display: none;"></span>                                                                             
                                                                                    <td style="text-align: center;"><?php echo $Product['product_name']; ?> </td>
                                                                                    <td style="text-align:right;padding-right: 35px"><span class="list_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="list_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $price_product; ?></span><input type="text" class="inline-text list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> list_list" id="list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $price_product; ?>" onkeypress="changeList(<?php echo $cumpony_id; ?>,'<?php echo $Product['id']; ?>')" style="display: none;"/></td>
                                                                                    <td style="text-align: center;"><span class="discount_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="discount_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $discount; ?></span><input type="text" class="inline-text discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> discount_discount" id="discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $discount; ?>" style="display: none;"/></td>
                                                                                    <td style="text-align:center;"><span class="special_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="special_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $special_price; ?></span><input type="text" class="inline-text special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> special_special" id="special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $special_price; ?>" style="display: none;"/></td> 
                                                                                    <td style="width:80px" align="center" valign="middle"><img src="images/like_icon.png" onclick="update_sprice(<?php echo $cumpony_id; ?>,'<?php echo $Product['id']; ?>');"  alt="Update" title="Update" width="22" height="22" class="mar_lft updater_c update_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" style="margin-left: 23px; display: none;"/><img src="images/edit.png" alt="Edit" style="margin-left: 23px;" title="Edit" width="22" height="22" class="edit_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" /></td>
                                                                                    </tr>
                                                                                   <?php } ?>

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
                                                                            <?php foreach ($superProductsUser as $Product) { 
                                                                                $special_price=in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][0] : $Product['list_price'];
                                                                                $price_product=in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][2] : $Product['list_price'];
                                                                                $discount = in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']][1] : "0.00";
                                                                                ?> 
                                                                            <tr style="background-color: #F9F2DE;" class="inline" id="<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>">
                                                                            <span class="jass_p" id="<?php echo $Product['id']; ?>" style="display: none;"></span>                                                                             
                                                                            <td style="text-align: center;"><?php echo $Product['product_name']; ?> </td>
                                                                            <td style="text-align:right;padding-right: 35px"><span class="list_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="list_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $price_product; ?></span><input type="text" class="inline-text list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> list_list" id="list_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $price_product; ?>" onkeypress="changeList(<?php echo $cumpony_id; ?>,'<?php echo $Product['id']; ?>')" style="display: none;"/></td>
                                                                            <td style="text-align: center;"><span class="discount_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="discount_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $discount; ?></span><input type="text" class="inline-text discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> discount_discount" id="discount_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $discount; ?>" style="display: none;"/></td>
                                                                            <td style="text-align:center;"><span class="special_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>" id="special_price_c_<?php echo $Product['id'];?>_<?php echo $cumpony_id; ?>"><?php echo $special_price; ?></span><input type="text" class="inline-text special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?> special_special" id="special_price_txt_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" value="<?php echo $special_price; ?>" style="display: none;"/></td> 
                                                                            <td style="width:80px" align="center" valign="middle"><img src="images/like_icon.png" onclick="update_sprice(<?php echo $cumpony_id; ?>,'<?php echo $Product['id']; ?>');"  alt="Update" title="Update" width="22" height="22" class="mar_lft updater_c update_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" style="margin-left: 23px; display: none;"/><img src="images/edit.png" alt="Edit" style="margin-left: 23px;" title="Edit" width="22" height="22" class="edit_c_<?php echo $Product['id']; ?>_<?php echo $cumpony_id; ?>" /></td>
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
                                                                    </div>
                                                                </td>  
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr align="center">
                                                            <td colspan="8">There is no products</td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                               
                                            <?php


?>
<!--Pagination End-->
                                         </table>
                                            </div>   
                                            </td>
                                    </tr>
                                    
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td style="background:#464646; text-align:center; color:#fff; line-height:30px;" height="30p">© 2013 sohorepro.com</td>
            </tr>
        </table>
                    </body>
                    </html>
                    
                    


<script type="text/javascript">
   
$(document).ready(function()
{

     $('.trigger').click(function()
    {
        var val  = $(this).attr('id');        
        if ($(this).is(':visible')) 
        {            
            $(this).next(".test_"+val).fadeToggle('slow').siblings(".test_"+val).hide(); 
        }
    });
    
    $('.inline').click(function()
    {
        var ID      = $(this).attr('id');
        //alert(ID);
        $(".list_price_c_"+ID).hide(); 
        $(".discount_price_c_"+ID).hide();
        $(".special_price_c_"+ID).hide();
        $(".edit_c_"+ID).hide();  
        $(".list_price_txt_c_"+ID).show(); 
        $(".discount_price_txt_c_"+ID).show();
        $(".special_price_txt_c_"+ID).show();        
        $(".update_c_"+ID).show();  
        $(".jass_p").attr("id",ID);        
    });
    
    $('.list_list').keydown(function (event) {

            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

            } else {
                event.preventDefault();
            }
            
            if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                event.preventDefault();

        });
        
    $('.special_special').keydown(function (event) {

            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

            } else {
                event.preventDefault();
            }
            
            if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                event.preventDefault();

        });
        
    $('.special_special').keyup(function (event){
        var ID              = $(".jass_p").attr("id"); 
        var list            = document.getElementById('list_price_txt_c_'+ID).value;
        var special         = document.getElementById('special_price_txt_c_'+ID).value;        
        var discount        = (((list - special) / list)*100);
        $(".discount_price_txt_c_"+ID).val(discount);
        $(".special_price_txt_c_"+ID).val(special);
    });
    
    $('.discount_discount').keyup(function (event){
        var ID              = $(".jass_p").attr("id"); 
        //alert(ID);
        var list            = document.getElementById('list_price_txt_c_'+ID).value;
        var discount        = document.getElementById('discount_price_txt_c_'+ID).value;
        var price           = (discount * (list/100));
        var special         = (list - price);
        $(".discount_price_txt_c_"+ID).val(discount);
        $(".special_price_txt_c_"+ID).val(special);
    });
    
    $('.discount_discount').keydown(function (event) {

            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

            } else {
                event.preventDefault();
            }
            
            if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                event.preventDefault();

        });
    
       
    $(document).mouseup(function()
    {
        var ID = $('.jass_p').attr('id');
        $(".list_price_c_"+ID).show(); 
        $(".discount_price_c_"+ID).show();
        $(".special_price_c_"+ID).show();
        $(".edit_c_"+ID).show(); 
        $(".list_price_txt_c_"+ID).hide(); 
        $(".discount_price_txt_c_"+ID).hide();
        $(".special_price_txt_c_"+ID).hide();     
        $(".update_c_"+ID).hide(); 
    });
 
 $(".select_customer").change(function()
        {
           var ID       =  $(this).attr('id');           
           var cust_id  =  $(".customer_name_"+ID).val();
           //alert(ID);
           if(cust_id != ''){
           
                $.ajax
	  ({
                 type: "POST",
		 url: "customers_edit.php",
		 data: "id="+ID+"&cust_id="+cust_id,
		 success: function(option)
                                {                                              
                                    $('#customer_dtls_'+ID).html(option);                     
                                }
                        });
           
           
           }
           
        });
});

    
    function update_sprice(str,str1)
    {
        var ID                   = str1; 
        var list_price           = document.getElementById('list_price_txt_c_'+str1+'_'+str).value;
        var discount             = document.getElementById('discount_price_txt_c_'+str1+'_'+str).value; 
        var special              = document.getElementById('special_price_txt_c_'+str1+'_'+str).value;
        var user_id              = str; 
        //alert(str1+' AND'+list_price+' AND'+discount+' AND'+user_id);
        
             if(list_price != '' && discount != '')  
	 {
	  $.ajax
	  ({
	     type: "POST",
		 url: "special_set.php",
		 data: "id="+ID+"&list_price_c="+list_price+"&discount_c="+discount+"&user_id="+user_id+"&special="+special,
		 success: function(option)
		 {
		     var myarr              = option.split("~");
                     var list_price         = myarr[0];
                     var discount_price     = myarr[1];
                     var special_price      = myarr[2];
                     var spl_prc            = myarr[3];
                     
                     $(".list_price_c_"+str1+'_'+str).html(list_price); 
                     $(".discount_price_c_"+str1+'_'+str).html(discount_price); 
                     $(".special_price_c_"+str1+'_'+str).html(special_price);
                     $(".list_price_txt_c_"+str1+'_'+str).hide(); 
                     $(".discount_price_txt_c_"+str1+'_'+str).hide();
                     $(".special_price_txt_c_"+str1+'_'+str).hide();
                     $(".update_c_"+str1+'_'+str).hide(); 
                     $(".list_price_c_"+str1+'_'+str).show(); 
                     $(".discount_price_c_"+str1+'_'+str).show(); 
                     $(".special_price_c_"+str1+'_'+str).show();
                     $(".edit_c_"+str1+'_'+str).show();                     
                     $('#spl_'+str).html(spl_prc);                     
		 }
	  });
	 }
	 else
	 {
	   $(".error").html("Please fill the all fields"); 
	 }
	return false;
        

    }


    function delete_special(special_id,cid)
    {
        var con                   = confirm("Are you sure you want to delete this special price.");
        var sp_id                 = special_id;
        var user_id               = cid;
        if (con == true)
            {
                if(sp_id != ''){
                    
        $.ajax
	  ({
	     type: "POST",
		 url: "delete_spl.php",
		 data: "sp_id="+sp_id+"&user_id="+user_id,
		 success: function(option)
		 {
                     var myarr              = option.split("~");
                     var succ               = myarr[0];
                     var special_price      = myarr[1];
                     $(".succ").html(succ);
                     $('#mas_'+user_id).html(special_price);             
		 }
	  });
                    
                }
                
            }
    }


</script>

                  
                                  
<script type="text/javascript" src="js/jquery.autocomplete.js"></script>
<link rel="stylesheet" href="js/jquery.autocomplete.css" type="text/css" />

<script type="text/javascript">
 

  function load_userinfo()
  {      	
        var cname = $( "#search_val" ).val();
        
        //alert(cname);
        var request = $.ajax({
          url: "load_user.php",
          type: "POST",
          data: { cid : cname },
          dataType: "html"
        });

        request.done(function( msg ) {
          //alert( msg );
          if(msg!='')
              {
                $('#load_userdata').html(msg);
              }
          else
              {
                $('#load_userdata').html(msg);    
              }
        });

        request.fail(function( jqXHR, textStatus ) {
            
        });
    
  }
 
    
  function findValue(li) {
  	if( li == null ) return alert("No match!");

  	// if coming from an AJAX call, let's use the CityId as the value
  	if( !!li.extra ) var sValue = li.extra[0];

  	// otherwise, let's just display the value in the text box
  	else var sValue = li.selectValue;

  	//alert("The value you selected was: " + sValue);
  }

  function selectItem(li) {
    	findValue(li);
  }

  function formatItem(row) {
    	return row[0];
  }

  function lookupAjax(){
  	var oSuggest = $("#search_val")[0].autocompleter;
    oSuggest.findValue();
  	return false;
  }
   

$( "#search_val" ).keypress(function() {
 
 var phoneval=$( "#search_val" ).val();
 //var test=phoneval.indexOf('_');
 //console.log( test );
    
//alert(phoneval.length);    
//console.log( phoneval.length );
$("#search_val").autocomplete(
      "load_user.php",
      {
  			delay:5,
  			minChars:3,
                        maxChars:15,
  			matchSubset:1,
  			matchContains:1,
  			cacheLength:10,
  			onItemSelect:selectItem,
  			onFindValue:findValue,
  			formatItem:formatItem,
  			autoFill:true
  		}
    );

    
});



  
</script>                    