<?php
include './config.php';
if($_GET['Jassim']=="0"){ echo $_REQUEST[''];}


$sort_pn            = ($_REQUEST['sort'] == 'pna') ? 'pnd' : 'pna';
$sort_pn_img        = ($_REQUEST['sort'] == 'pna') ? 'down' : 'up';

$sort_sku           = ($_REQUEST['sort'] == 'psa') ? 'psd' : 'psa';    
$sort_sku_img       = ($_REQUEST['sort'] == 'psa') ? 'down' : 'up';

$sort_price         = ($_REQUEST['sort'] == 'ppa') ? 'ppd' : 'ppa';
$sort_price_img     = ($_REQUEST['sort'] == 'ppa') ? 'down' : 'up';





$page=1;//Default page
$limit=20;//Records per page
$start=0;//starts displaying records from 0
if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
}
	$start=($page-1)*$limit;
if($_GET['limite']){
    $limit = $_GET['limite'];
} 

$Products = getProducts($_REQUEST['sort'],$start,$limit);
$rows= count(ProductsCount());
$super_category  = getSuperCat();
$active_category = getCategoryActive();
$categoryLoad = CategoryLoad($_GET['superc_id']);
$subcategoryLoad = SubCategoryLoad($_GET['superc_id'],$_GET['cat_id']);
//print_r($categoryLoad);
if ($_GET['delete_id']) {

    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM sohorepro_products WHERE id = " . $delete_id . " ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success";
    } else {
        $result = "failure";
    }
}
?>
<?php
if ($_GET['status_id']) {

    $change_status = ($_GET['change_id'] == 1) ? '0' : '1';
    $status_id = $_GET['status_id'];
    $sql = "UPDATE sohorepro_products
			SET     status     = '" . $change_status . "' WHERE id= '" . $status_id . "'";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_status";
    } else {
        $result = "failure_status";
    }
}
$last_element        = $_GET['page'];
$last_element_filter = $_GET['page_filter'];
$last_element_search = $_GET['page_search'];
?>



<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Soho-repro</title>
        <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="style/pagination.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
        <script src="js/jquery.tablednd_0_5.js" type="text/javascript"></script>
        <!--<script src="js/core.js" type="text/javascript"></script>-->
        <style>
            .filter_box td{ padding: 3px 10px;}
            .filter_box td .select_text{float: left;}
        </style> 
    </head>

    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            
            <tr>
                <td align="center" valign="top">
                    <table width="960" border="0" cellspacing="0" cellpadding="0" style="min-width:760px;">
                        <tr>
                            <td width="198" align="left" valign="top" bgcolor="#464646">
                                <table width="198" border="0" cellspacing="0" cellpadding="0">
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
                                </table>
                                
                            </td>
                            <td width="3" align="left" valign="top" bgcolor="#FFFFFF"></td>
                            <td width="759" align="left" valign="top" bgcolor="#FFFFFF">
                            <table width="759" border="0" cellspacing="0" cellpadding="0">
                                    
                                    <tr>
                                        <td height="48" align="center" valign="middle" bgcolor="#5f5f5f" class="heading">
                                            ADMINISTRATOR PAGE
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td height="38" align="center" valign="middle" bgcolor="#8b8b8b" class="sub_heading">
                                            PRODUCTS
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td height="14" align="left" valign="middle"></td>
                                    </tr>  
                                    
                                    <tr>
                                        <td align="right" valign="top">
                                            <table width="759" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="38" align="left" valign="middle" class="add_title">Filter</td>
                                                </tr>
                                                <tr>
                                                    <td height="60" align="right" valign="top" bgcolor="#f6f6f6" class="form_bg">
                                                        <form method="post">
                                                            <input type="hidden" name="filter" value="1" />   
                                                            <table width="759" border="0" cellspacing="0" cellpadding="0" class="product filter_box">
                                                               
                                                                <tr>
                                                                     <!-- Super Category Filter Section Start-->                                                                     
                                                                    <td width="180" height="60" align="left" style="font-size:14px;" valign="middle">Select Super Category</td>
                                                                    <td width="200" height="60" align="left" valign="middle">
                                                                        <select name="supercategory_name" id="supercategory_name" class="select_text" onchange="return select_cate();" >
                                                                            <option value="0">Select Super Category</option>
                                                                            <?php foreach ($super_category as $supcat) { ?>
                                                                                <option value="<?php echo $supcat['id'];?>" <?php if($_GET['superc_id'] == $supcat['id']) { echo 'selected=select';} ?>><?php echo $supcat['category_name']; ?></option>
                                                                                    <?php } ?>
                                                                        </select>
                                                                    </td>
                                                                    <!-- Super Category Filter Section End-->
                                                                    
                                                                    <!-- Category Filter Section Start-->
                                                                    <td width="180" height="60" align="left" style="font-size:14px;" valign="middle">Select Category</td>
                                                                    <td width="200" height="60" align="left" style="float: none;" valign="middle">
                                                                        <select name="category_name" id="category_name" class="select_text" onchange="return select_sub_cate();" /> 
                                                                        <option value="0">Select Category</option>
                                                                            <?php foreach ($categoryLoad as $cat) { ?>
                                                                                <option value="<?php echo $cat['id'];?>" <?php if($_GET['cat_id'] == $cat['id']) { echo 'selected=select';} ?>><?php echo $cat['category_name']; ?></option>
                                                                                    <?php } ?>
                                                                        </select>
                                                                    </td>  
                                                                    <!-- Category Filter Section End-->
                                                                    
                                                                </tr>
                                                                
                                                                
                                                                <!-- Sub Category Filter Section Start-->
                                                                <tr>
                                                                    <td width="180" height="60" align="left" style="font-size:14px;" valign="middle">Select Sub Category</td>
                                                                    <td width="200" height="60" align="left" valign="middle">
                                                                        <select name="sub_category_name" id="sub_category_name" class="select_text" /> 
                                                                        <option value="0">Select Sub Category</option>
                                                                            <?php foreach ($subcategoryLoad as $cat) { ?>
                                                                                <option value="<?php echo $cat['id'];?>" <?php if($_GET['sub_id'] == $cat['id']) { echo 'selected=select';} ?>><?php echo $cat['category_name']; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </td>
                                                                    <td width="180" height="60" align="left" valign="middle"><span class="btn_filter" onclick="return filter_test();">Filter</span></td>
                                                                    <td width="200" height="60" align="left" style="font-size:14px;" valign="middle"></td>
                                                                </tr>
                                                                <!-- Sub Category Filter Section End-->
                                                                <!-- Search Section Start-->
                                                                <tr style="background: #fcd9a9;">
                                                                    <td width="180" height="60" align="left" style="font-size:14px;" valign="middle">Quick Search</td>
                                                                    <td width="200" height="60" align="left" valign="middle">
                                                                        <input type="text" name="search_products" id="search_products" value="<?php echo $_GET['search']; ?>" placeholder="Search Products" class="input_text" style="float: left;width:165px !important;" />
                                                                    </td>
                                                                    <td width="180" height="60" align="left" valign="middle"><span class="btn_filter" onclick="return search_test();">Search</span></td>
                                                                    <td width="200" height="60" align="left" style="font-size:14px;" valign="middle"></td>
                                                                </tr>
                                                                
                                                                    
                                                                <!-- Search Section End-->
                                                                <tr>
                                                                    <td colspan="5" height="auto" style="color:#F00; text-align:center; padding-bottom:10px; font-size: 12px;">
                                                                        <div id="msg1" style="color:#FF0000;padding-left:38px;font-size: 13px;"></div>
                                                                        <div id="msg2" style="color:#FF0000;padding-left:5px;font-size: 13px; "></div>  
                                                                        <div id="msg" style="color:#007F2A; font-size: 13px;"></div>
                                                                        <div id="search_alert" style="color:#FF0000; font-size: 13px;"></div> 
                                                                        <?php
                                                        if($_GET['page'] != ''){
                                                            $page1 = 'page='.$_GET['page'];
                                                       }
                                                       if($_GET['filter'] == '1'){
                                                           $super_id_f = $_GET['superc_id'];
                                                           $cat_id_f = $_GET['cat_id'];
                                                           $sub_id_f = $_GET['sub_id'];
                                                           $page_f   = $_GET['page_filter'];
                                                           $page_filter = 'filter=1&superc_id='.$super_id_f.'&cat_id='.$cat_id_f.'&sub_id='.$sub_id_f.'&page_filter='.$page_f;
                                                       }
                                                       if($_GET['search'] != ''){
                                                           $search      = $_GET['search'];
                                                           $page_search = $_GET['page_search'];
                                                           $search_link = 'search='.$search.'&page_search='.$page_search;
                                                       }   
                                                        if ($result == "success") {
                                                            ?>
                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Deleted successfully</div>
                                                            <script>setTimeout("location.href=\'products.php?<?php echo $page1.$page_filter.$search_link; ?>\'", 1000);</script>
                                                            <?php
                                                        } elseif ($result == "failure") {
                                                            ?>
                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Deleted not successfully</div>
                                                            <script>setTimeout("location.href=\'products.php?<?php echo $page1.$page_filter.$search_link; ?>\'", 1000);</script>       
                                                            <?php
                                                        }
                                                        ?>
                                                        <?php
                                                        if($_GET['page'] != ''){
                                                            $page1 = 'page='.$_GET['page'];
                                                       }
                                                       if($_GET['filter'] == '1'){
                                                           $super_id_f = $_GET['superc_id'];
                                                           $cat_id_f = $_GET['cat_id'];
                                                           $sub_id_f = $_GET['sub_id'];
                                                           $page_f   = $_GET['page_filter'];
                                                           $page_filter = 'filter=1&superc_id='.$super_id_f.'&cat_id='.$cat_id_f.'&sub_id='.$sub_id_f.'&page_filter='.$page_f;
                                                       }
                                                       if($_GET['search'] != ''){
                                                           $search      = $_GET['search'];
                                                           $page_search = $_GET['page_search'];
                                                           $search_link = 'search='.$search.'&page_search='.$page_search;
                                                       }  
                                                        if ($result == "success_status") {
                                                            ?>
                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Status change successfully</div>
                                                            <script>setTimeout("location.href=\'products.php?<?php echo $page1.$page_filter.$search_link; ?>\'", 1000);</script>
                                                            <?php
                                                        } elseif ($result == "failure_status") {
                                                            ?>
                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Status change not successfully</div>
                                                            <script>setTimeout("location.href=\'products.php?<?php echo $page1.$page_filter.$search_link; ?>\'", 1000);</script>       
                                                            <?php
                                                        }
                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </form>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="right" valign="top">
                                            <table width="759" border="0" cellspacing="0" cellpadding="0">

                                                <tr>
                                                    <td  align="left" valign="middle" style="padding-left:20px;">         
                                                    </td>
                                                    <td height="60" width="170" align="left" valign="middle"><a href="import_products.php"><img src="images/btn_importproducts.png" style="cursor:pointer;padding-right: 12px;" alt="Import Products" title="Import Products"/></a></td>
                                                    <td height="60" align="left" valign="middle"><span style="width: 215px;float: left;font-size: 12px;">Please use this Excel file as a template or else your import may not work <a href="excel_template/product_template.xlsx">Download Template</a></span></td>
                                                    <td height="60" align="right" valign="middle"><a href="add_new_products.php"><img src="images/btn_addproducts.png" width="123" height="34"  alt="Add Product" title="Add Product"/></a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="right" valign="top">
                                            <?php
                                            if ($_GET['filter'] == '1') {
                                                $super_name = getsuperN($_GET['superc_id']);
                                                $cat_name   = getcatN($_GET['cat_id']);
                                                $sub_name   = getsubN($_GET['sub_id']);
                                                ?> 
                                                <!-- Filter Start -->
                                                <table width="759" border="0" cellspacing="0" cellpadding="0" >
                                                    <tr>
                                                        <td height="38" colspan="6" align="left" valign="middle" class="add_title">Filtered Results : <?php echo $super_name.' -> '.$cat_name.' -> '.$sub_name; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="36" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>
                                                        <td width="110" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="product.php?sort=<?php echo $sort_sc; ?>">Product Name</a></td>                                                       
                                                        <td width="51" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Price</td>
                                                        <td width="20" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">status</td>
                                                        <td width="64" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                    </tr>
                                               
                                                    <?php
                                                    $su_file_id     = $_GET['superc_id'];
                                                    $c_fil_id       = $_GET['cat_id'];
                                                    $sc_fil_id      = $_GET['sub_id'];
                                                    $page_filter    =   1;//Default page
                                                    $limit_filter   =   20;//Records per page
                                                    $start_filter   =   0;
                                                    if(isset($_GET['page_filter']) && $_GET['page_filter']!=''){
                                                    $page_filter=$_GET['page_filter'];
                                                                    }
                                                    $start_filter=($page_filter-1)*$limit_filter;
                                                    $ProductsFilter = getProductsFilter($su_file_id, $c_fil_id, $sc_fil_id,$start_filter,$limit_filter);                                                    
                                                    $count_filter   = CountFilter($su_file_id, $c_fil_id, $sc_fil_id);
                                                    $rows_page      = count($count_filter);
                                                    $i = 1;
                                                    if (count($ProductsFilter) > 0) {
                                                        if($last_element_filter != '')
                                                            {
                                                              $i = ((($last_element_filter*20) - 20)+1);                                                            
                                                            }  
                                                            else 
                                                            {
                                                              $i = 1 ; 
                                                            }   
                                                        foreach ($ProductsFilter as $Prod) {
                                                            $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                            $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                            $id = $Prod['id'];
                                                            $category_id = $Prod['category_id'];
                                                            $sub_category_id = $Prod['subcategory_id'];
                                                            $sku_id = $Prod['sku_id'];
                                                            $price = $Prod['price'];
                                                            $product_name = $Prod['product_name'];
                                                            $status = ($Prod['status'] == 1) ? 'active' : 'de-active';
                                                            $page_id = ($_GET['page_filter'] == '')? '1': $_GET['page_filter'];
                                                            ?>
                                                
                                                            <tr id="order_<?php echo $id; ?>">
                                                                <td width="49"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>
                                                                <td width="150" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><?php echo $product_name; ?></td>                                                                
                                                                <td width="10" style="padding-left: 50px;" align="left" valign="middle"  bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo "$" . $price; ?></td>
                                                                <td width="60"  align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="pad_btm"><a href="products.php?filter=1&superc_id=<?php echo $su_file_id; ?>&cat_id=<?php echo $c_fil_id; ?>&sub_id=<?php echo $sc_fil_id; ?>&page_filter=<?php echo $page_id; ?>&status_id=<?php echo $id; ?>&change_id=<?php echo $Prod['status']; ?>" onclick="return confirm('Are you change the status in this product?');"><img src="images/<?php echo $status; ?>.png" width="22" height="22"  alt=""/></a></td>
                                                                <td width="80"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><a href="edit_products.php?filter=1&superc_id=<?php echo $su_file_id; ?>&cat_id=<?php echo $c_fil_id; ?>&sub_id=<?php echo $sc_fil_id; ?>&page_filter=<?php echo $page_id; ?>&id=<?php echo $id; ?>"><img src="images/edit.png"  alt="Edit" title="Edit" width="22" height="22"/></a><a href="products.php?filter=1&superc_id=<?php echo $su_file_id; ?>&cat_id=<?php echo $c_fil_id; ?>&sub_id=<?php echo $sc_fil_id; ?>&page_filter=<?php echo $page_id; ?>&delete_id=<?php echo $id; ?>" onclick="return confirm('Are you delete this product?');"><img src="images/del.png"  alt="Delete" title="Delete" width="22" height="22" class="mar_lft"/></a></td>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr align="center">
                                                            <td colspan="5">There is no products</td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                        <tr align="right">
                                                        <td colspan="5">
<!--                                                            <div style="float: left; margin-top: 20px;">
                                                                <form method="post">
                                                                    <select class="sel_limite" name="sortOrder" id="sortOrder" onchange="autosubmit();">                                                    
                                                                        <option value="0">--</option>
                                                                        <option value="50"  <?php if($_GET['limite'] == '50') { echo 'selected=select';} ?>>50</option>
                                                                        <option value="75"  <?php if($_GET['limite'] == '75') { echo 'selected=select';} ?>>75</option>
                                                                        <option value="100" <?php if($_GET['limite'] == '100'){ echo 'selected=select';} ?>>100</option>
                                                                    </select>
                                                                </form>
                                                            </div>-->
                                                            <?php echo Paginations($limit_filter,$page_filter,'products.php?filter=1&superc_id='.$su_file_id.'&cat_id='.$c_fil_id.'&sub_id='.$sc_fil_id.'&page_filter=',$rows_page);?>
                                                        </td>
                                                        </tr>
                                                </table>

                                                <!-- Filter End -->                                                
                                                <?php 
                                                }                                                
                                                elseif ($_GET['search'] != ''){
                                                    $search_values = $_GET['search'];
                                                ?>
                                                <!-- Search Start -->
                                                <table width="759" border="0" cellspacing="0" cellpadding="0" >
                                                    <tr>
                                                        <td height="38" colspan="6" align="left" valign="middle" class="add_title">SEARCH RESULTS : <?php echo $search_values; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="36" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>
                                                        <td width="110" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="product.php?sort=<?php echo $sort_sc; ?>">Product Name</a></td>                                                        
                                                        <td width="51" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Price</td>
                                                        <td width="20" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">status</td>
                                                        <td width="64" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                    </tr>
                                               
                                                    <?php
                                                    $search_val     = $_GET['search'];                                                    
                                                    $page_search    =   1;//Default page
                                                    $limit_search   =   20;//Records per page
                                                    $start_search   =   0;
                                                    if(isset($_GET['page_search']) && $_GET['page_search']!=''){
                                                    $page_search    =   $_GET['page_search'];
                                                                    }
                                                    $start_search=($page_search-1)*$limit_search;
                                                    $ProductsFilterS = getProductsFilterS($search_val,$start_search,$limit_search);                                                    
                                                    $count_search    = CountSearch($search_val);
                                                    $rows_search    = count($count_search);
                                                    $i = 1;
                                                    if (count($ProductsFilterS) > 0) {
                                                        if($last_element_search != '')
                                                            {
                                                              $i = ((($last_element_search*20) - 20)+1);                                                            
                                                            }  
                                                            else 
                                                            {
                                                              $i = 1 ; 
                                                            }                                                        
                                                        foreach ($ProductsFilterS as $Prod) {
                                                            $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                            $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                            $id = $Prod['id'];
                                                            $category_id = $Prod['category_id'];
                                                            $sub_category_id = $Prod['subcategory_id'];
                                                            $sku_id = $Prod['sku_id'];
                                                            $price = $Prod['price'];
                                                            $product_name = $Prod['product_name'];
                                                            $status = ($Prod['status'] == 1) ? 'active' : 'de-active';
                                                            $search_page_id = ($_GET['page_search'] == '')? '1': $_GET['page_search'];
                                                            ?>
                                                
                                                            <tr id="order_<?php echo $id; ?>">
                                                                <td width="49"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>
                                                                <td width="150" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><?php echo $product_name; ?></td>                                                               
                                                                <td width="10" style="padding-left: 50px;" align="left" valign="middle"  bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo "$" . $price; ?></td>
                                                                <td width="60"  align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="pad_btm"><a href="products.php?search=<?php echo $search_val ?>&page_search=<?php echo $search_page_id; ?>&status_id=<?php echo $id; ?>&change_id=<?php echo $Prod['status']; ?>" onclick="return confirm('Are you change the status in this product?');"><img src="images/<?php echo $status; ?>.png" width="22" height="22"  alt=""/></a></td>
                                                                <td width="80"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><a href="edit_products.php?search=<?php echo $search_val ?>&page_search=<?php echo $search_page_id; ?>&id=<?php echo $id; ?>"><img src="images/edit.png"  alt="Edit" title="Edit" width="22" height="22"/></a><a href="products.php?search=<?php echo $search_val ?>&page_search=<?php echo $search_page_id; ?>&delete_id=<?php echo $id; ?>" onclick="return confirm('Are you delete this product?');"><img src="images/del.png"  alt="Delete" title="Delete" width="22" height="22" class="mar_lft"/></a></td>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr align="center">
                                                            <td colspan="5">There is no products</td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                        <tr align="right">
                                                        <td colspan="5">
<!--                                                            <div style="float: left; margin-top: 20px;">
                                                                <form method="post">
                                                                    <select class="sel_limite" name="sortOrder" id="sortOrder" onchange="autosubmit();">                                                    
                                                                        <option value="0">--</option>
                                                                        <option value="50"  <?php if($_GET['limite'] == '50') { echo 'selected=select';} ?>>50</option>
                                                                        <option value="75"  <?php if($_GET['limite'] == '75') { echo 'selected=select';} ?>>75</option>
                                                                        <option value="100" <?php if($_GET['limite'] == '100'){ echo 'selected=select';} ?>>100</option>
                                                                    </select>
                                                                </form>
                                                            </div>-->
                                                            <?php echo Paginations($limit_search,$page_search,'products.php?search='.$search_val.'&page_search=',$rows_search);?>
                                                        </td>
                                                        </tr>
                                                </table>
                                                
                                                 <!-- Search End -->
                                                <?php }else { ?>
                                                <!-- Products Start -->
                                                <table width="759" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td width="36" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>
                                                        <td width="110" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="products.php?sort=<?php echo $sort_pn; ?>">Product Name&nbsp;<img src="images/<?php echo $sort_pn_img ; ?>.png"  alt="" width="10px" height="5px"/></a></td>                                                        
                                                        <td width="51" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="products.php?sort=<?php echo $sort_price; ?>">Price&nbsp;<img src="images/<?php echo $sort_price_img ; ?>.png"  alt="" width="10px" height="5px"/></a></td>
                                                        <td width="20" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">status</td>
                                                        <td width="64" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                    </tr>
                                                </table>
                                                
                                                
                                                <table width="759" border="0" cellspacing="0" cellpadding="0" class="tbl_repeatpro">
                                                    <?php
                                                    $i = 1;
                                                        if (count($Products) > 0) {
                                                            
                                                            if($last_element != '')
                                                            {
                                                              $i = ((($last_element*20) - 20)+1);                                                            
                                                            }  
                                                            else 
                                                            {
                                                              $i = 1 ; 
                                                            }
                                                        foreach ($Products as $Prod) { 
                                                            $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                            $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                            $id = $Prod['id'];
                                                            $category_id = $Prod['category_id'];
                                                            $sub_category_id = $Prod['subcategory_id'];
                                                            $sku_id = $Prod['sku_id'];
                                                            $price = $Prod['price'];
                                                            $product_name = $Prod['product_name'];
                                                            $status = ($Prod['status'] == 1) ? 'active' : 'de-active';
                                                            $page_id = ($_GET['page'] == '')? '1': $_GET['page'];
                                                            ?>
                                                
                                                            <tr id="order_<?php echo $id; ?>">
                                                                <td width="49"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>
                                                                <td width="150" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><?php echo $product_name; ?></td>                                                               
                                                                <td width="10" style="padding-left: 50px;" align="left" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="pad_btm"><?php echo "$" . $price; ?></td>
                                                                <td width="60"  align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><a href="products.php?page=<?php echo $page_id; ?>&status_id=<?php echo $id; ?>&change_id=<?php echo $Prod['status']; ?>" onclick="return confirm('Are you change the status in this product?');"><img src="images/<?php echo $status; ?>.png" width="22" height="22"  alt="Status" title="Status"/></a></td>
                                                                <td width="80"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><a href="edit_products.php?page=<?php echo $page_id; ?>&id=<?php echo $id; ?>"><img src="images/edit.png"  alt="Edit" title="Edit" width="22" height="22"/></a><a href="products.php?page=<?php echo $page_id; ?>&delete_id=<?php echo $id; ?>" onclick="return confirm('Are you delete this product?');"><img src="images/del.png"  alt="Delete" title="Delete" width="22" height="22" class="mar_lft"/></a></td>
                                                            </tr>
                                                            
                                                            <?php
                                                            $i++;
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr align="center">
                                                            <td colspan="5">There is no products</td>
                                                        </tr>
                                                        <?php } ?>
                                                <tr align="right">
                                                        <td colspan="5">
<!--                                                            <div style="float: left; margin-top: 20px;">
                                                                <form method="post">
                                                                    <select class="sel_limite" name="sortOrder" id="sortOrder" onchange="autosubmit();">                                                    
                                                                        <option value="0">--</option>
                                                                        <option value="50"  <?php if($_GET['limite'] == '50') { echo 'selected=select';} ?>>50</option>
                                                                        <option value="75"  <?php if($_GET['limite'] == '75') { echo 'selected=select';} ?>>75</option>
                                                                        <option value="100" <?php if($_GET['limite'] == '100'){ echo 'selected=select';} ?>>100</option>
                                                                    </select>
                                                                </form>
                                                            </div>-->
                                                            <?php echo Paginations($limit,$page,'products.php?page=',$rows);?>
                                                        </td>
                                                </tr>

                                             </table>  
                                                <!-- Products End -->
                                            <?php } ?>
                                                 <!--Pagination Start-->
                                          
                                        
                                        </td>
                                    </tr>
                            </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td style="background:#464646; text-align:center; color:#fff; line-height:30px;" height="30p">© <?php echo date('Y'); ?> sohorepro.com</td>
            </tr>
        </table>
    
                    
<script type="text/javascript">
    function autosubmit()
    {
        var page = document.getElementById("sortOrder").value;
        if(page != 0)
        {
            window.location="products.php?limite="+document.getElementById("sortOrder").value;
        }
    }
    
    function select_cate()
    {
        var super_id = document.getElementById("supercategory_name").value;
        if(super_id != 0)
        {
            window.location="products.php?superc_id="+super_id;
        }
    }
    
    function select_sub_cate()
    {
        var super_id = document.getElementById("supercategory_name").value;
        var cat_id = document.getElementById("category_name").value;
        if(cat_id != 0)
        {
            window.location="products.php?superc_id="+super_id+"&cat_id="+cat_id;
        }
    }
    
    
    
  </script>  


<script type="text/javascript">
$(document).ready(function()
{
//   $("#supercategory_name").change(function()
//        {
//            var super_id_prod = $(this).val();  
//            if (super_id_prod != '0')
//            {
//                $.ajax
//                        ({
//                            type: "POST",
//                            url: "get_child.php",
//                            data: "super_id_prod=" + super_id_prod,
//                            success: function(option)
//                            {
//                                if(option != ''){
//                                $("#category_name").html(option);
//                                $("#subcategory_name").html("<option value='0'>Select Sub Category</option>");
//                                }else{
//                                $("#category_name").html("<option value='0'>Select Category</option>");
//                                $("#subcategory_name").html("<option value='0'>Select Sub Category</option>");   
//                                }
//                            }
//                        });
//            }
//            else
//            {
//                $("#category_name").html("<option value='0'>Select Category Name</option>"); 
//                $("#subcategory_name").html("<option value='0'>Select Sub Category</option>");
//            }
//            return false;
//        });
        
$("#category_name").change(function()
  {
    var pc_id = $(this).val();
	if(pc_id != '0')  
	 {
	  $.ajax
	  ({
	     type: "POST",
		 url: "get_child.php",
		 data: "pc_id="+ pc_id,
		 success: function(option)
		 {
                   if(option != ''){  
		   $("#sub_category_name").html(option);
                   }else{
                   $("#sub_category_name").html("<option value='0'>Select Sub Category</option>");      
                   }
		 }
	  });
	 }
	 else
	 {
	   $("#subcategory_name").html("<option value=''>Select Sub Category</option>");
	 }
	return false;
  });
});
</script>

                    <script type="text/javascript">
                        function filter_test()
                        {
                            var super_id = document.getElementById("supercategory_name").value;
                            var cat_id   = document.getElementById("category_name").value;
                            var sub_id   = document.getElementById("sub_category_name").value;
                            //alert(super_id+' '+cat_id+' '+sub_id);
                            if(super_id != '0')  
                                        {
                                         $.ajax
                                         ({
                                            type: "POST",
                                                url: "get_child.php",
                                                data: "super_id_filter="+ super_id,
                                                success: function(option)
                                                {
                                                  if(option = '1'){ 
                                                       window.location="products.php?filter=1&superc_id="+super_id+"&cat_id="+cat_id+"&sub_id="+sub_id;
                                                  }
                                                }
                                         });
                                        }
                           
                            }
                            
                            function search_test()
                        {
                            var search_prod = document.getElementById("search_products").value;
                            //alert(search_prod);
                            if(search_prod != '')  
                                        {
                                         $.ajax
                                         ({
                                            type: "POST",
                                                url: "get_child.php",
                                                data: "search_prod="+ search_prod,
                                                success: function(option)
                                                {
                                                  if(option = '1'){ 
                                                       window.location="products.php?search="+search_prod;
                                                  }
                                                }
                                         });
                                        }
                                        else
                                        {
                                        $("#search_alert").html("Enter the product in search field");
                                        }
                           
                            }                            
                        
                    </script>  
 <script language="javascript">                       
 $(function (){
      $(".tbl_repeatpro tbody").tableDnD({
		onDrop: function(table, row) {
			var orders = $.tableDnD.serialize();
			$.post('orderpro.php', { orders : orders });
                        if(true){
                            alert('Products order sorting');
                            $("#msg").html('Products order sorted successfully');
                            window.location = "products.php";
                        }
                }
	}); 
     
 });
                        
                    </script>
                    
</body>
</html>