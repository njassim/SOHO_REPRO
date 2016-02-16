<?php
include './config.php';
include './auth.php';
include './mail_template.php';
//if($_GET['Jassim']=="0"){ echo $_REQUEST[''];}


$sort_pn = ($_REQUEST['sort'] == 'pna') ? 'pnd' : 'pna';
$sort_pn_img = ($_REQUEST['sort'] == 'pna') ? 'down' : 'up';

$sort_sku = ($_REQUEST['sort'] == 'psa') ? 'psd' : 'psa';
$sort_sku_img = ($_REQUEST['sort'] == 'psa') ? 'down' : 'up';

$sort_price = ($_REQUEST['sort'] == 'ppa') ? 'ppd' : 'ppa';
$sort_price_img = ($_REQUEST['sort'] == 'ppa') ? 'down' : 'up';





$page = 1; //Default page
$limit = 20; //Records per page
$start = 0; //starts displaying records from 0
if (isset($_GET['page']) && $_GET['page'] != '') {
    $page = $_GET['page'];
}
$start = ($page - 1) * $limit;
if ($_GET['limite']) {
    $limit = $_GET['limite'];
}

$Products = getProducts($_REQUEST['sort'], $start, $limit);
$rows = count(ProductsCount());
$super_category = getSuperCat();
$active_category = getCategoryActive();
$categoryLoad = CategoryLoad($_GET['superc_id']);
$subcategoryLoad = SubCategoryLoad($_GET['superc_id'], $_GET['cat_id']);
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
$order_id = $_GET['ord_id'];
$ship_id = $_GET['ship_id'];
$last_element = $_GET['page'];
$last_element_filter = $_GET['page_filter'];
$last_element_search = $_GET['page_search'];



if ($_REQUEST['checkbox']) {

//    for($i=0;$i<count($_REQUEST['qty']);$i++){
//            if ($_REQUEST['qty'][$i] != '0') {
//            $qty_array[] = $_REQUEST['qty'][$i];
//            }
//    }
//    for($i=0;$i<count($_REQUEST['checkbox']);$i++){
//        $product_id     = $_REQUEST['checkbox'][$i];
//        $product_qty    = $qty_array[$i];
//        $order_id       = $_REQUEST['od_id'];
//        $product_name   = mysql_real_escape_string(ProdNameForAdd($product_id));
//        $product_price  = ProdPriceForAdd($product_id);
//        $chk_piod       = checkPIOD($order_id,$product_id);
//        $shipp_add_id   = GetShippforAddProd($order_id);
//        if (count($chk_piod) < 1) {
//        $sql = "INSERT INTO sohorepro_product_master SET product_id = '$product_id', product_price = '$product_price', product_quantity = '" . $product_qty . "', product_name = '$product_name', order_id = '$order_id', shipping_add_id = '$shipp_add_id'";
//        $sql_result = mysql_query($sql);
//            }
//        if ($sql_result) {
//            $result = "success_addprod";
//        } else {
//            $result = "failure_addprod";
//        }
//    }



    $additional_products = AdditionalProduct($order_id);

//    echo '<pre>';
//    print_r($additional_products);
//    echo '</pre>';
//    exit;

    foreach ($additional_products as $additional) {
        $product_id = $additional['product_id'];
        $product_qty = $additional['product_quantity'];
        $order_id = $additional['order_id'];
        $product_name = mysql_real_escape_string(ProdNameForAdd($product_id));
        $product_price = ProdPriceForAdd($product_id);
        $shipp_add_id = GetShippforAddProd($order_id);
        $sql = "INSERT INTO sohorepro_product_master SET product_id = '$product_id', product_price = '$product_price', product_quantity = '" . $product_qty . "', product_name = '$product_name', order_id = '$order_id', shipping_add_id = '$shipp_add_id'";
        mysql_query($sql);
    }
    $query = "DELETE FROM sohorepro_products_order_temp WHERE order_id = '" . $order_id . "' ";
    $sql_result = mysql_query($query);
    if ($sql_result) {
        $result = "success_addprod";
    } else {
        $result = "failure_addprod";
    }
}


$user_checked_product = CheckedOrderProduct($order_id);
if (count($user_checked_product) > 0) {
    $checked_product = array();
    $checked_quantity = array();
    foreach ($user_checked_product as $checked) {
        $checked_product[] = $checked['product_id'];
        $checked_quantity[$checked['product_id']] = $checked['product_quantity'];
    }
}
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
        <script type="text/javascript" src="js/jquery.inputlimiter.1.3.1.min.js"></script>
        <!--<script src="js/core.js" type="text/javascript"></script>-->
        <style>
            .filter_box td{ padding: 3px 10px;}
            .filter_box td .select_text{float: left;}
            .none{display: none;}
            .fixed_1{border-style:solid;border-width:0px; position: fixed; width: 761px; top: 0; z-index: 1; background: #DFDFDF;}
        </style> 
        <!--scroll set to top--->
        <script type="text/javascript">
            //STICKY NAV
            $(document).ready(function() {
                var top = $('#btn_tdr').offset().top - parseFloat($('#btn_tdr').css('marginTop').replace(/auto/, 100));
                $(window).scroll(function(event) {
                    // what the y position of the scroll is
                    var y = $(this).scrollTop();

                    // whether that's below the form
                    if (y >= top) {
                        // if so, ad the fixed class
                        $('#btn_tdr').addClass('fixed_1');
                    } else {
                        // otherwise remove it
                        $('#btn_tdr').removeClass('fixed_1');
                    }
                });

                $('.qty').inputlimiter({
                    limit: 3,
                    remText: '',
                    remFullText: '',
                    limitText: ''
                });

            });
        </script>

    </head>

    <body>

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>" />
            <input type="hidden" name="ship_id" id="ship_id" value="<?php echo $ship_id; ?>" />
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
<?php include "sidebar_menu_dummy.php"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle" style="height:280px; float:left;"></td>
                                    </tr>
                                </table>

                            </td>
                            <td width="3" align="left" valign="top" bgcolor="#FFFFFF"></td>
                            <td width="759" align="left" valign="top" bgcolor="#FFFFFF">
                                <form name="form1" method="post" action="">
                                    <table width="759" border="0" cellspacing="0" cellpadding="0">

                                        <tr>
                                            <td height="48" align="center" valign="middle" bgcolor="#5f5f5f" class="heading">
                                                ADMINISTRATOR PAGE
                                                <?php //echo $date = date('Y-m-d h:i:s', time()); ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td height="38" align="center" valign="middle" bgcolor="#8b8b8b" class="sub_heading">
                                                ADD PRODUCTS TO OPEN ORDER
                                                <span style="float: right;padding-right: 5px;">Welcome <?php if ($_SESSION['admin_user_type'] == '1') {
    echo 'admin';
} if ($_SESSION['admin_user_type'] == '2') {
    echo 'Staff User';
} ?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
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
                                                                                    <option value="<?php echo $supcat['id']; ?>" <?php if ($_GET['superc_id'] == $supcat['id']) {
                                                                                    echo 'selected=select';
                                                                                } ?>><?php echo $supcat['category_name']; ?></option>
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
                                                                        <option value="<?php echo $cat['id']; ?>" <?php if ($_GET['cat_id'] == $cat['id']) {
        echo 'selected=select';
    } ?>><?php echo $cat['category_name']; ?></option>
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
                                                                        <option value="<?php echo $cat['id']; ?>" <?php if ($_GET['sub_id'] == $cat['id']) {
        echo 'selected=select';
    } ?>><?php echo $cat['category_name']; ?></option>
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
                                                                            <input type="text" name="search_products" id="search_products" value="<?php echo htmlentities($_GET['search']); ?>" placeholder="Search Products" class="input_text" style="float: left;width:165px !important;" />
                                                                        </td>
                                                                        <td width="180" height="60" align="left" valign="middle"><span class="btn_filter" onclick="return search_test();">Search</span></td>
                                                                        <td width="200" height="60" align="left" style="font-size:14px;" valign="middle"><span class="btn_filter" onclick="return reset_filter();">Reset</span></td>
                                                                    </tr>


                                                                    <!-- Search Section End-->
                                                                    <tr>
                                                                        <td colspan="5" height="auto" style="color:#F00; text-align:center; padding-bottom:10px; font-size: 12px;">
                                                                            <div id="msg1" style="color:#FF0000;padding-left:38px;font-size: 13px;"></div>
                                                                            <div id="msg2" style="color:#FF0000;padding-left:5px;font-size: 13px; "></div>  
                                                                            <div id="msg" style="color:#007F2A; font-size: 13px;"></div>
                                                                            <div id="search_alert" style="color:#FF0000; font-size: 13px;"></div> 

                                                                            <?php
                                                                            if ($result == "success_addprod") {
                                                                                ?>
                                                                                <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Products added to order successfully</div>
                                                                                <script>setTimeout("location.href=\'open_orders.php?ord_id=<?php echo $order_id; ?>\'", 1000);</script>
                                                                                <?php
                                                                            } elseif ($result == "failure_addprod") {
                                                                                ?>
                                                                                <div style="color:#F00; text-align:center; padding-bottom:10px;">Products added to order not successfully</div>
                                                                                <script>setTimeout("location.href=\'open_orders.php?ord_id=<?php echo $order_id; ?>\'", 1000);</script>       
                                                                                <?php
                                                                            }
                                                                            if ($alert == "check") {
                                                                                ?>
                                                                                <div style="color:#F00; text-align:center; padding-bottom:10px;">Select the check box some products</div>
                                                                                <script>setTimeout("location.href=\'open_orders.php?ord_id=<?php echo $order_id; ?>\'", 1000);</script>       
                                                                                <?php
                                                                            }
                                                                            ?>

                                                                            <?php
                                                                            if ($_GET['page'] != '') {
                                                                                $page1 = 'ord_id=' . $order_id . '&page=' . $_GET['page'];
                                                                            }
                                                                            if ($_GET['filter'] == '1') {
                                                                                $super_id_f = $_GET['superc_id'];
                                                                                $cat_id_f = $_GET['cat_id'];
                                                                                $sub_id_f = $_GET['sub_id'];
                                                                                $page_f = $_GET['page_filter'];
                                                                                $page_filter = 'ord_id=' . $order_id . '&filter=1&superc_id=' . $super_id_f . '&cat_id=' . $cat_id_f . '&sub_id=' . $sub_id_f . '&page_filter=' . $page_f;
                                                                            }
                                                                            if ($_GET['search'] != '') {
                                                                                $search = $_GET['search'];
                                                                                $page_search = $_GET['page_search'];
                                                                                $search_link = 'ord_id=' . $order_id . '&search=' . $search . '&page_search=' . $page_search;
                                                                            }
                                                                            if ($result == "success") {
                                                                                ?>
                                                                                <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Deleted successfully</div>
                                                                                <script>setTimeout("location.href=\'products.php?<?php echo $page1 . $page_filter . $search_link; ?>\'", 1000);</script>
                                                                                <?php
                                                                            } elseif ($result == "failure") {
                                                                                ?>
                                                                                <div style="color:#F00; text-align:center; padding-bottom:10px;">Deleted not successfully</div>
                                                                                <script>setTimeout("location.href=\'products.php?<?php echo $page1 . $page_filter . $search_link; ?>\'", 1000);</script>       
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                            <?php
                                                                            if ($_GET['page'] != '') {
                                                                                $page1 = 'page=' . $_GET['page'];
                                                                            }
                                                                            if ($_GET['filter'] == '1') {
                                                                                $super_id_f = $_GET['superc_id'];
                                                                                $cat_id_f = $_GET['cat_id'];
                                                                                $sub_id_f = $_GET['sub_id'];
                                                                                $page_f = $_GET['page_filter'];
                                                                                $page_filter = 'filter=1&superc_id=' . $super_id_f . '&cat_id=' . $cat_id_f . '&sub_id=' . $sub_id_f . '&page_filter=' . $page_f;
                                                                            }
                                                                            if ($_GET['search'] != '') {
                                                                                $search = $_GET['search'];
                                                                                $page_search = $_GET['page_search'];
                                                                                $search_link = 'search=' . $search . '&page_search=' . $page_search;
                                                                            }
                                                                            if ($result == "success_status") {
                                                                                ?>
                                                                                <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Status change successfully</div>
                                                                                <script>setTimeout("location.href=\'products.php?<?php echo $page1 . $page_filter . $search_link; ?>\'", 1000);</script>
                                                                                <?php
                                                                            } elseif ($result == "failure_status") {
                                                                                ?>
                                                                                <div style="color:#F00; text-align:center; padding-bottom:10px;">Status change not successfully</div>
                                                                                <script>setTimeout("location.href=\'products.php?<?php echo $page1 . $page_filter . $search_link; ?>\'", 1000);</script>       
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
                                            <td align="right" valign="top" >
                                                <div id="btn_tdr">
                                                    <table width="759" border="0" cellspacing="0" cellpadding="0">                                               
                                                        <tr>
                                                            <td  align="left" valign="middle" style="padding-left:20px;" width="180"></td>
                                                            <td height="60" width="170" align="right" valign="middle" width="100"></td>
                                                            <td height="60" align="right" valign="middle" width="100"></td>
                                                            <td height="60" align="right" valign="middle" class="product" width="380"><span class="btn_filter_red" onclick="return cancel_addprod();" style="float:right; margin-left: 5px;">Cancel</span><input type="image" name="add_prod" src="images/btn_save_red.png" width="123" height="34" id="add_prod" style="float:right"/></td>
                                                        </tr>                                               
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="right" valign="top">
<?php
if ($_GET['filter'] == '1') {
    $super_name = getsuperN($_GET['superc_id']);
    $cat_name = getcatN($_GET['cat_id']);
    $sub_name = getsubN($_GET['sub_id']);
    ?> 
                                                    <!-- Filter Start -->
                                                    <table width="759" border="0" cellspacing="0" cellpadding="0" >
                                                        <tr>
                                                            <td height="38" colspan="7" align="left" valign="middle" class="add_title">Filtered Results : <?php echo $super_name ?><span>  &raquo;  </span><?php echo $cat_name; ?><span>  &raquo;  </span><?php echo $sub_name; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="20" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>
                                                            <td width="355" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="products.php?sort=<?php echo $sort_pn; ?>">Product Name&nbsp;<img src="images/<?php echo $sort_pn_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>                                                        
                                                            <td width="101" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="products.php?sort=<?php echo $sort_price; ?>">List Price&nbsp;</a></td>
                                                            <td width="101" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="products.php?sort=<?php echo $sort_price; ?>">Discount&nbsp;</a></td>
                                                            <td width="101" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="products.php?sort=<?php echo $sort_price; ?>">Sell Price&nbsp;</a></td>                                                                                                                
                                                            <td width="81" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                        </tr>

                                                        <?php
                                                        $su_file_id = $_GET['superc_id'];
                                                        $c_fil_id = $_GET['cat_id'];
                                                        $sc_fil_id = $_GET['sub_id'];
                                                        $page_filter = 1; //Default page
                                                        $limit_filter = 20; //Records per page
                                                        $start_filter = 0;
                                                        if (isset($_GET['page_filter']) && $_GET['page_filter'] != '') {
                                                            $page_filter = $_GET['page_filter'];
                                                        }
                                                        $start_filter = ($page_filter - 1) * $limit_filter;
                                                        $ProductsFilter = getProductsFilter($su_file_id, $c_fil_id, $sc_fil_id, $start_filter, $limit_filter);
                                                        $count_filter = CountFilter($su_file_id, $c_fil_id, $sc_fil_id);
                                                        $rows_page = count($count_filter);
                                                        $i = 1;
                                                        if (count($ProductsFilter) > 0) {
                                                            if ($last_element_filter != '') {
                                                                $i = ((($last_element_filter * 20) - 20) + 1);
                                                            } else {
                                                                $i = 1;
                                                            }
                                                            foreach ($ProductsFilter as $Prod) {
                                                                $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                                $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                                $id = $Prod['id'];
                                                                $category_id = $Prod['category_id'];
                                                                $sub_category_id = $Prod['subcategory_id'];
                                                                $sku_id = $Prod['sku_id'];
                                                                $list_price = $Prod['list_price'];
                                                                $discount = $Prod['discount'];
                                                                $disc_val = explode(".", $discount);
                                                                $sell_price = $Prod['price'];
                                                                $product_name = $Prod['product_name'];
                                                                $status = ($Prod['status'] == 1) ? 'active' : 'de-active';
                                                                $page_id = ($_GET['page_filter'] == '') ? '1' : $_GET['page_filter'];
                                                                $quantity_selected = in_array($Prod['id'], $checked_product) ? $checked_quantity[$Prod['id']] : '';
                                                                ?>

                                                                <tr class="T_inline" id="<?php echo $id; ?>">
                                                                <span class="inline_dummy none" id="<?php echo $id; ?>"></span> 
                                                                <td width="20"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>
                                                                <td width="355" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><?php echo $product_name; ?></td>                                                               
                                                                <td width="101" align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="pad_btm"><span class="list_span_<?php echo $id; ?>" id="list_span_<?php echo $id; ?>"><?php echo "$" . $list_price; ?></span><input type="text" class="none list_key inline-text list_txt_<?php echo $id; ?>" id="list_txt_<?php echo $id; ?>" value="<?php echo $list_price; ?>"/></td>
                                                                <td width="101" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="pad_btm"><span class="discount_span_<?php echo $id; ?>" id="discount_span_<?php echo $id; ?>"><?php echo $discount; ?></span><input type="text" class="none discount_key inline-text discount_txt_<?php echo $id; ?>" id="discount_txt_<?php echo $id; ?>" value="<?php echo $disc_val[0]; ?>"/></td>
                                                                <td width="101" align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="pad_btm"><span class="selling_span_<?php echo $id; ?>" id="selling_span_<?php echo $id; ?>"><?php echo "$" . $sell_price; ?></span><input type="text" class="none selling_key inline-text selling_txt_<?php echo $id; ?>" id="selling_txt_<?php echo $id; ?>" value="<?php echo $sell_price; ?>"/></td>                                                                
                                                                <td width="81"  align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm">
                                                                    <input type="hidden" name="od_id" id="od_id" value="<?php echo $order_id; ?>" />
                                                                    <input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $id; ?>" <?php if ($quantity_selected != '') { ?> checked="checked" <?php } ?>>
            <!--                                                                    <select name="qty[]" id="qty_<?php echo $id; ?>" onchange="return select_qty('<?php echo $id; ?>',<?php echo $order_id; ?>);" > 
                                                                        <option value="0">0</option>
                                                                        <option value="1" <?php if ($quantity_selected == '1') { ?>selected="selected"<?php } ?>>1</option>
                                                                        <option value="2" <?php if ($quantity_selected == '2') { ?>selected="selected"<?php } ?>>2</option>
                                                                        <option value="3" <?php if ($quantity_selected == '3') { ?>selected="selected"<?php } ?>>3</option>
                                                                        <option value="4" <?php if ($quantity_selected == '4') { ?>selected="selected"<?php } ?>>4</option>
                                                                        <option value="5" <?php if ($quantity_selected == '5') { ?>selected="selected"<?php } ?>>5</option>
                                                                        <option value="6" <?php if ($quantity_selected == '6') { ?>selected="selected"<?php } ?>>6</option>
                                                                        <option value="7" <?php if ($quantity_selected == '7') { ?>selected="selected"<?php } ?>>7</option>
                                                                        <option value="8" <?php if ($quantity_selected == '8') { ?>selected="selected"<?php } ?>>8</option>
                                                                        <option value="9" <?php if ($quantity_selected == '9') { ?>selected="selected"<?php } ?>>9</option>
                                                                        <option value="10" <?php if ($quantity_selected == '10') { ?>selected="selected"<?php } ?>>10</option>
                                                                    </select>-->
                                                                    <input type="text" name="qty" class="qty" id="qty_<?php echo $id; ?>" style="width: 30px;" value="<?php echo $quantity_selected; ?>" onblur="return select_qty('<?php echo $id; ?>', '<?php echo $order_id; ?>');" />
                                                                </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            } else {
                                                ?>
                                                <tr align="center">
                                                    <td colspan="7">There is no products</td>
                                                </tr>
        <?php
    }
    ?>
                                            <tr align="right">
                                                <td colspan="7">
                                                    <!--                                                            <div style="float: left; margin-top: 20px;">
                                                                                                                    <form method="post">
                                                                                                                        <select class="sel_limite" name="sortOrder" id="sortOrder" onchange="autosubmit();">                                                    
                                                                                                                            <option value="0">--</option>
                                                                                                                            <option value="50"  <?php if ($_GET['limite'] == '50') {
        echo 'selected=select';
    } ?>>50</option>
                                                                                                                            <option value="75"  <?php if ($_GET['limite'] == '75') {
                                                    echo 'selected=select';
                                                } ?>>75</option>
                                                                                                                            <option value="100" <?php if ($_GET['limite'] == '100') {
                                                    echo 'selected=select';
                                                } ?>>100</option>
                                                                                                                        </select>
                                                                                                                    </form>
                                                                                                                </div>-->
                                        <?php echo Paginations($limit_filter, $page_filter, 'aptor.php?ord_id=' . $order_id . '&filter=1&superc_id=' . $su_file_id . '&cat_id=' . $c_fil_id . '&sub_id=' . $sc_fil_id . '&page_filter=', $rows_page); ?>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Filter End -->                                                
    <?php
} elseif ($_GET['search'] != '') {
    $search_values = $_GET['search'];
    ?>
                                        <!-- Search Start -->
                                        <table width="759" border="0" cellspacing="0" cellpadding="0" >
                                            <tr>
                                                <td height="38" colspan="7" align="left" valign="middle" class="add_title">SEARCH RESULTS : <?php echo $search_values; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="20" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>
                                                <td width="355" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="products.php?sort=<?php echo $sort_pn; ?>">Product Name&nbsp;<img src="images/<?php echo $sort_pn_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>                                                        
                                                <td width="101" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="products.php?sort=<?php echo $sort_price; ?>">List Price&nbsp;</a></td>
                                                <td width="101" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="products.php?sort=<?php echo $sort_price; ?>">Discount&nbsp;</a></td>
                                                <td width="101" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="products.php?sort=<?php echo $sort_price; ?>">Sell Price&nbsp;</a></td>                                                                                                                
                                                <td width="81" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                            </tr>

                                            <?php
                                            $search_val = $_GET['search'];
                                            $page_search = 1; //Default page
                                            $limit_search = 20; //Records per page
                                            $start_search = 0;
                                            if (isset($_GET['page_search']) && $_GET['page_search'] != '') {
                                                $page_search = $_GET['page_search'];
                                            }
                                            $start_search = ($page_search - 1) * $limit_search;
                                            
											$ProductsFilterScheck	= getProductsFilterScheck($search_val);
											$ProductsFilterScheckSC	= getProductsFilterScheckSC($search_val);
											if(count($ProductsFilterScheck) > 0){
											$ProductsFilterS = getProductsFilterS($search_val, $start_search, $limit_search);
											}elseif(count($ProductsFilterScheckSC) > 0){
												$super_cat_id =  $ProductsFilterScheckSC[0]['id'];
											$ProductsFilterScheck	= getProductsFilterScheckScProds($search_val);	
											}else{
											echo 'Mohamed';
											}
                                            $count_search = CountSearch($search_val);
                                            $rows_search = count($count_search);
                                            $i = 1;
                                            if (count($ProductsFilterS) > 0) {
                                                if ($last_element_search != '') {
                                                    $i = ((($last_element_search * 20) - 20) + 1);
                                                } else {
                                                    $i = 1;
                                                }
                                                foreach ($ProductsFilterS as $Prod) {
                                                    $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                    $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                    $id = $Prod['id'];
                                                    $category_id = $Prod['category_id'];
                                                    $sub_category_id = $Prod['subcategory_id'];
                                                    $sku_id = $Prod['sku_id'];
                                                    $list_price = $Prod['list_price'];
                                                    $discount = $Prod['discount'];
                                                    $disc_val = explode(".", $discount);
                                                    $sell_price = $Prod['price'];
                                                    $product_name = $Prod['product_name'];
                                                    $status = ($Prod['status'] == 1) ? 'active' : 'de-active';
                                                    $search_page_id = ($_GET['page_search'] == '') ? '1' : $_GET['page_search'];
                                                    $quantity_selected = in_array($Prod['id'], $checked_product) ? $checked_quantity[$Prod['id']] : '';
                                                    ?>

                                                    <tr class="T_inline" id="<?php echo $id; ?>">
                                                    <span class="inline_dummy none" id="<?php echo $id; ?>"></span> 
                                                    <td width="20"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>
                                                    <td width="355" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><?php echo $product_name; ?></td>                                                               
                                                    <td width="101" align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="pad_btm"><span class="list_span_<?php echo $id; ?>" id="list_span_<?php echo $id; ?>"><?php echo "$" . $list_price; ?></span><input type="text" class="none list_key inline-text list_txt_<?php echo $id; ?>" id="list_txt_<?php echo $id; ?>" value="<?php echo $list_price; ?>"/></td>
                                                    <td width="101" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="pad_btm"><span class="discount_span_<?php echo $id; ?>" id="discount_span_<?php echo $id; ?>"><?php echo $discount; ?></span><input type="text" class="none discount_key inline-text discount_txt_<?php echo $id; ?>" id="discount_txt_<?php echo $id; ?>" value="<?php echo $disc_val[0]; ?>"/></td>
                                                    <td width="101" align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="pad_btm"><span class="selling_span_<?php echo $id; ?>" id="selling_span_<?php echo $id; ?>"><?php echo "$" . $sell_price; ?></span><input type="text" class="none selling_key inline-text selling_txt_<?php echo $id; ?>" id="selling_txt_<?php echo $id; ?>" value="<?php echo $sell_price; ?>"/></td>                                                                
                                                    <td width="81"  align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm">
                                                        <input type="hidden" name="od_id" id="od_id" value="<?php echo $order_id; ?>" />
                                                        <input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $id; ?>" <?php if ($quantity_selected != '') { ?> checked="checked" <?php } ?>>
            <!--                                                                    <select name="qty[]" id="qty_<?php echo $id; ?>" onchange="return select_qty('<?php echo $id; ?>',<?php echo $order_id; ?>);" > 
                                                            <option value="0">0</option>
                                                            <option value="1" <?php if ($quantity_selected == '1') { ?>selected="selected"<?php } ?>>1</option>
                                                            <option value="2" <?php if ($quantity_selected == '2') { ?>selected="selected"<?php } ?>>2</option>
                                                            <option value="3" <?php if ($quantity_selected == '3') { ?>selected="selected"<?php } ?>>3</option>
                                                            <option value="4" <?php if ($quantity_selected == '4') { ?>selected="selected"<?php } ?>>4</option>
                                                            <option value="5" <?php if ($quantity_selected == '5') { ?>selected="selected"<?php } ?>>5</option>
                                                            <option value="6" <?php if ($quantity_selected == '6') { ?>selected="selected"<?php } ?>>6</option>
                                                            <option value="7" <?php if ($quantity_selected == '7') { ?>selected="selected"<?php } ?>>7</option>
                                                            <option value="8" <?php if ($quantity_selected == '8') { ?>selected="selected"<?php } ?>>8</option>
                                                            <option value="9" <?php if ($quantity_selected == '9') { ?>selected="selected"<?php } ?>>9</option>
                                                            <option value="10" <?php if ($quantity_selected == '10') { ?>selected="selected"<?php } ?>>10</option>
                                                        </select>-->
                                                        <input type="text" name="qty" class="qty" id="qty_<?php echo $id; ?>" style="width: 30px;" value="<?php echo $quantity_selected; ?>" onblur="return select_qty('<?php echo $id; ?>', '<?php echo $order_id; ?>');" />
                                                    </td>
                                                    </tr>
            <?php
            $i++;
        }
    } else {
        ?>
                                                <tr align="center">
                                                    <td colspan="7">There is no products</td>
                                                </tr>
        <?php
    }
    ?>
                                            <tr align="right">
                                                <td colspan="7">
                                                    <!--                                                            <div style="float: left; margin-top: 20px;">
                                                                                                                    <form method="post">
                                                                                                                        <select class="sel_limite" name="sortOrder" id="sortOrder" onchange="autosubmit();">                                                    
                                                                                                                            <option value="0">--</option>
                                                                                                                            <option value="50"  <?php if ($_GET['limite'] == '50') {
        echo 'selected=select';
    } ?>>50</option>
                                                                                                                            <option value="75"  <?php if ($_GET['limite'] == '75') {
        echo 'selected=select';
    } ?>>75</option>
                                                                                                                            <option value="100" <?php if ($_GET['limite'] == '100') {
        echo 'selected=select';
    } ?>>100</option>
                                                                                                                        </select>
                                                                                                                    </form>
                                                                                                                </div>-->
    <?php echo Paginations($limit_search, $page_search, 'aptor.php?ord_id=' . $order_id . '&search=' . $search_val . '&page_search=', $rows_search); ?>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Search End -->
                                        <?php } else { ?>
                                        <!-- Products Start -->
                                        <table width="759" border="0" cellspacing="0" cellpadding="0" class="t_tbl_repeatpro">
                                            <tr>
                                                <td width="20" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>
                                                <td width="355" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="products.php?sort=<?php echo $sort_pn; ?>">Product Name&nbsp;<img src="images/<?php echo $sort_pn_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>                                                        
                                                <td width="101" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="products.php?sort=<?php echo $sort_price; ?>">List Price&nbsp;</a></td>
                                                <td width="101" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="products.php?sort=<?php echo $sort_price; ?>">Discount&nbsp;</a></td>
                                                <td width="101" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="products.php?sort=<?php echo $sort_price; ?>">Sell Price&nbsp;</a></td>                                                                                                                
                                                <td width="81" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                            </tr>                                                
                                            <?php
                                            $i = 1;
                                            if (count($Products) > 0) {

                                                if ($last_element != '') {
                                                    $i = ((($last_element * 20) - 20) + 1);
                                                } else {
                                                    $i = 1;
                                                }
                                                foreach ($Products as $Prod) {
                                                    $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                    $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                    $id = $Prod['id'];
                                                    $category_id = $Prod['category_id'];
                                                    $sub_category_id = $Prod['subcategory_id'];
                                                    $sku_id = $Prod['sku_id'];
                                                    $list_price = $Prod['list_price'];
                                                    $discount = $Prod['discount'];
                                                    $disc_val = explode(".", $discount);
                                                    $sell_price = $Prod['price'];
                                                    $product_name = $Prod['product_name'];
                                                    $status = ($Prod['status'] == 1) ? 'active' : 'de-active';
                                                    $page_id = ($_GET['page'] == '') ? '1' : $_GET['page'];
                                                    if (count($user_checked_product) > 0) {
                                                        $quantity_selected = in_array($Prod['id'], $checked_product) ? $checked_quantity[$Prod['id']] : '';
                                                    }
                                                    ?>

                                                    <tr class="T_inline" id="<?php echo $id; ?>">
                                                    <span class="inline_dummy none" id="<?php echo $id; ?>"></span> 
                                                    <td width="20"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>
                                                    <td width="355" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><?php echo $product_name; ?></td>                                                               
                                                    <td width="101" align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="pad_btm"><span class="list_span_<?php echo $id; ?>" id="list_span_<?php echo $id; ?>"><?php echo "$" . $list_price; ?></span><input type="text" class="none list_key inline-text list_txt_<?php echo $id; ?>" id="list_txt_<?php echo $id; ?>" value="<?php echo $list_price; ?>"/></td>
                                                    <td width="101" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="pad_btm"><span class="discount_span_<?php echo $id; ?>" id="discount_span_<?php echo $id; ?>"><?php echo $discount; ?></span><input type="text" class="none discount_key inline-text discount_txt_<?php echo $id; ?>" id="discount_txt_<?php echo $id; ?>" value="<?php echo $disc_val[0]; ?>"/></td>
                                                    <td width="101" align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="pad_btm"><span class="selling_span_<?php echo $id; ?>" id="selling_span_<?php echo $id; ?>"><?php echo "$" . $sell_price; ?></span><input type="text" class="none selling_key inline-text selling_txt_<?php echo $id; ?>" id="selling_txt_<?php echo $id; ?>" value="<?php echo $sell_price; ?>"/></td>                                                                
                                                    <td width="81"  align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm">
                                                        <input type="hidden" name="od_id" id="od_id" value="<?php echo $order_id; ?>" />
                                                        <input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $id; ?>" <?php if ($quantity_selected != '') { ?> checked="checked" <?php } ?>>
            <!--                                                                    <select name="qty[]" id="qty_<?php echo $id; ?>" onchange="return select_qty('<?php echo $id; ?>',<?php echo $order_id; ?>);" > 
                                                            <option value="0">0</option>
                                                            <option value="1" <?php if ($quantity_selected == '1') { ?>selected="selected"<?php } ?>>1</option>
                                                            <option value="2" <?php if ($quantity_selected == '2') { ?>selected="selected"<?php } ?>>2</option>
                                                            <option value="3" <?php if ($quantity_selected == '3') { ?>selected="selected"<?php } ?>>3</option>
                                                            <option value="4" <?php if ($quantity_selected == '4') { ?>selected="selected"<?php } ?>>4</option>
                                                            <option value="5" <?php if ($quantity_selected == '5') { ?>selected="selected"<?php } ?>>5</option>
                                                            <option value="6" <?php if ($quantity_selected == '6') { ?>selected="selected"<?php } ?>>6</option>
                                                            <option value="7" <?php if ($quantity_selected == '7') { ?>selected="selected"<?php } ?>>7</option>
                                                            <option value="8" <?php if ($quantity_selected == '8') { ?>selected="selected"<?php } ?>>8</option>
                                                            <option value="9" <?php if ($quantity_selected == '9') { ?>selected="selected"<?php } ?>>9</option>
                                                            <option value="10" <?php if ($quantity_selected == '10') { ?>selected="selected"<?php } ?>>10</option>
                                                        </select>-->
                                                        <input type="text" name="qty" class="qty" id="qty_<?php echo $id; ?>" style="width: 30px;" value="<?php echo $quantity_selected; ?>" onblur="return select_qty('<?php echo $id; ?>', '<?php echo $order_id; ?>');" />
                                                    </td>
                                                    </tr>

            <?php
            $i++;
        }
    } else {
        ?>
                                                <tr align="center">
                                                    <td colspan="7">There is no products</td>
                                                </tr>
    <?php } ?>
                                            <tr align="right">
                                                <td colspan="7">
                                                    <!--                                                            <div style="float: left; margin-top: 20px;">
                                                                                                                    <form method="post">
                                                                                                                        <select class="sel_limite" name="sortOrder" id="sortOrder" onchange="autosubmit();">                                                    
                                                                                                                            <option value="0">--</option>
                                                                                                                            <option value="50"  <?php if ($_GET['limite'] == '50') {
        echo 'selected=select';
    } ?>>50</option>
                                                                                                                            <option value="75"  <?php if ($_GET['limite'] == '75') {
        echo 'selected=select';
    } ?>>75</option>
                                                                                                                            <option value="100" <?php if ($_GET['limite'] == '100') {
        echo 'selected=select';
    } ?>>100</option>
                                                                                                                        </select>
                                                                                                                    </form>
                                                                                                                </div>-->
    <?php echo Paginations($limit, $page, 'aptor.php?ord_id=' . $order_id . '&page=', $rows); ?>
                                                </td>
                                            </tr>

                                        </table>  
                                        <!-- Products End -->
<?php } ?>
                                    <!--Pagination Start-->


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
    <td style="background:#464646; text-align:center; color:#fff; line-height:30px;" height="30p">© <?php echo date('Y'); ?> sohorepro.com</td>
</tr>
</table>


<script type="text/javascript">

    $(document).ready(function() {
        //called when key is pressed in textbox
        $(".qty").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#errmsg").html("Digits Only").show().fadeOut("slow");
                return false;
            }
        });
    });

    function select_cate()
    {
        var super_id = document.getElementById("supercategory_name").value;
        var order_id = document.getElementById("order_id").value;
        var ship_id = document.getElementById("ship_id").value;
        if (super_id != 0)
        {
            window.location = "aptor.php?ord_id=" + order_id + "&ship_id=" + ship_id + "&superc_id=" + super_id;
        }
    }

    function select_sub_cate()
    {
        var super_id = document.getElementById("supercategory_name").value;
        var cat_id = document.getElementById("category_name").value;
        var order_id = document.getElementById("order_id").value;
        var ship_id = document.getElementById("ship_id").value;
        if (cat_id != 0)
        {
            window.location = "aptor.php?ord_id=" + order_id + "&ship_id=" + ship_id + "&superc_id=" + super_id + "&cat_id=" + cat_id;
        }
    }

    function reset_filter()
    {
        var order_id = document.getElementById("order_id").value;
        var ship_id = document.getElementById("ship_id").value;
        window.location = "aptor.php?ord_id=" + order_id + "&ship_id=" + ship_id;

    }
    function cancel_addprod()
    {
        var order_id = document.getElementById("order_id").value;
        $.ajax
                ({
                    type: "POST",
                    url: "get_child.php",
                    data: "delete_order_id=" + order_id,
                    success: function(option)
                    {
                        if (option == true) {
                            window.location = "open_orders.php?ord_id=" + order_id;
                        }
                    }
                });
    }

    function select_qty(id, order_id)
    {
        var qty = document.getElementById("qty_" + id).value;
        if (qty != '')
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "get_child.php",
                        data: "id=" + id + "&product_qty=" + qty + "&order_id=" + order_id,
                        success: function(option)
                        {

                        }
                    });
        }
    }

</script>  

<!-- Inline Edit For Products Details Start -->
<script type="text/javascript">
    $(document).ready(function()
    {

        $('.inline').click(function()
        {
            var ID = $(this).attr('id');
            $(".list_span_" + ID).hide();
            $(".discount_span_" + ID).hide();
            $(".selling_span_" + ID).hide();
            $(".edit_" + ID).hide();
            $(".list_txt_" + ID).show();
            $(".discount_txt_" + ID).show();
            $(".selling_txt_" + ID).show();
            $(".update_" + ID).show();
            document.getElementById("list_txt_" + ID).select();
            $(".inline_dummy").attr("id", ID);
        });

        $(document).mouseup(function()
        {
            var ID = $('.inline_dummy').attr('id');
            $(".list_span_" + ID).show();
            $(".discount_span_" + ID).show();
            $(".selling_span_" + ID).show();
            $(".edit_" + ID).show();
            $(".list_txt_" + ID).hide();
            $(".discount_txt_" + ID).hide();
            $(".selling_txt_" + ID).hide();
            $(".update_" + ID).hide();
        });

        $('.discount_key').keyup(function(event) {
            var ID = $(".inline_dummy").attr("id");
            var list = document.getElementById('list_txt_' + ID).value;
            var discount = document.getElementById('discount_txt_' + ID).value;
            var price = (discount * (list / 100));
            var sell_price = (list - price);
            $(".discount_txt_" + ID).val(discount);
            $(".selling_txt_" + ID).val(sell_price.toFixed(2));
        });

        $('.selling_key').keyup(function(event) {
            var ID = $(".inline_dummy").attr("id");
            var list = document.getElementById('list_txt_' + ID).value;
            var selling = document.getElementById('selling_txt_' + ID).value;
            var discount = (((list - selling) / list) * 100);
            $(".discount_txt_" + ID).val(discount.toFixed(2));
            $(".selling_txt_" + ID).val(selling);
        });

        $('.list_key').keydown(function(event) {

            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

            } else {
                event.preventDefault();
            }

            if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                event.preventDefault();

        });

        $('.discount_key').keydown(function(event) {

            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

            } else {
                event.preventDefault();
            }

            if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                event.preventDefault();

        });

        $('.selling_key').keydown(function(event) {

            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

            } else {
                event.preventDefault();
            }

            if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                event.preventDefault();
        });
    });

    function update_details(str)
    {
        var list_price = document.getElementById('list_txt_' + str).value;
        var discount = document.getElementById('discount_txt_' + str).value;
        var sell = document.getElementById('selling_txt_' + str).value;
        var product_id = str;
        // alert(str);
        if (list_price != '' && discount != '')
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "get_child.php",
                        data: "id=" + product_id + "&list_price_product=" + list_price + "&discount_product=" + discount + "&selling_product=" + sell,
                        success: function(option)
                        {
                            var myarr = option.split("~");
                            var list_price = myarr[1];
                            var discount_price = myarr[2];
                            var selling_price = myarr[3];

                            $(".list_span_" + str).html(list_price);
                            $(".discount_span_" + str).html(discount_price);
                            $(".selling_span_" + str).html(selling_price);
                            $(".list_span_" + str).show();
                            $(".discount_span_" + str).show();
                            $(".selling_span_" + str).show();
                            $(".edit_" + str).show();
                            $(".list_txt_" + str).hide();
                            $(".discount_txt_" + str).hide();
                            $(".selling_txt_" + str).hide();
                            $(".update_" + str).hide();
                            $(".msg").html(myarr[0]);
                            $(".msg").hide(2000);
                        }
                    });
        }
        else
        {
            $(".error").html("Please fill the all fields");
        }
        return false;


    }

</script>
<!-- Inline Edit For Products Details End -->

<script type="text/javascript">
    function filter_test()
    {
        var super_id = document.getElementById("supercategory_name").value;
        var cat_id = document.getElementById("category_name").value;
        var sub_id = document.getElementById("sub_category_name").value;
        var order_id = document.getElementById("order_id").value;
        var ship_id = document.getElementById("ship_id").value;
        //alert(super_id+' '+cat_id+' '+sub_id);
        if (super_id != '0')
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "get_child.php",
                        data: "super_id_filter=" + super_id,
                        success: function(option)
                        {
                            if (option = '1') {
                                window.location = "aptor.php?ord_id=" + order_id + "&ship_id=" + ship_id + "&filter=1&superc_id=" + super_id + "&cat_id=" + cat_id + "&sub_id=" + sub_id;
                            }
                        }
                    });
        }

    }

    function search_test()
    {
        var search_prod = document.getElementById("search_products").value;
        var order_id = document.getElementById("order_id").value;
        var ship_id = document.getElementById("ship_id").value;
        //alert(search_prod);
        if (search_prod != '')
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "get_child.php",
                        data: "search_prod=" + search_prod,
                        success: function(option)
                        {
                            if (option = '1') {
                                window.location = "aptor.php?ord_id=" + order_id + "&ship_id=" + ship_id + "&search=" + search_prod;
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
    $(function() {
        $(".tbl_repeatpro tbody").tableDnD({
            onDrop: function(table, row) {
                var orders = $.tableDnD.serialize();
                $.post('orderpro.php', {orders: orders});
                if (true) {
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