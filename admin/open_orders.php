<?php
include './config.php';
include './auth.php';
$sort_date = ($_REQUEST['sort'] == 'a') ? 'd' : 'a';
$sort_date_img = ($_REQUEST['sort'] == 'a') ? 'down' : 'up';

$sort_jrn = ($_REQUEST['sort'] == 'jna') ? 'jnd' : 'jna';
$sort_jrn_img = ($_REQUEST['sort'] == 'jna') ? 'down' : 'up';

$sort_prc = ($_REQUEST['sort'] == 'pa') ? 'pd' : 'pa';
$sort_prc_img = ($_REQUEST['sort'] == 'pa') ? 'down' : 'up';


$page = 1; //Default page
$limit = 25; //Records per page
$start = 0; //starts displaying records from 0
if (isset($_GET['page']) && $_GET['page'] != '') {
    $page = $_GET['page'];
}
$start = ($page - 1) * $limit;
if ($_GET['limite']) {
    $limit = $_GET['limite'];
}

$Orders = getOrdersAll($_REQUEST['sort'], $start, $limit);
$rows = count(OrdersCount());


if ($_GET['tax_status']) {

    $tax_id = $_GET['tax_status'];
    $sql = "UPDATE sohorepro_product_master SET tax_status = '0' WHERE order_id = " . $tax_id . " ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_tax";
    } else {
        $result = "failure_tax";
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
        <!-- Add fancyBox main JS and CSS files -->
        <!--<script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery.fancybox.css?v=2.1.5" media="screen" />
        <script type="text/javascript" src="js/jquery.fancyboxc.js?v=2.1.5"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery.fancyboxc.css?v=2.1.5" media="screen" />
        <script type="text/javascript">
            $(document).ready(function() {
                /**  Simple image gallery. Uses default settings*/
                $('.fancybox').fancybox();
                $('.fancyboxc').fancyboxc();
                /**  Different effects */
            });
        </script>-->
        <!--End -->
        <link href="../style/popup_style.css" rel="stylesheet" type="text/css" media="all" />
        <style>
            .fancybox-inner{ width:644px !important; float:left !important; height:500px !important;}
            .fancybox-wrap {left: 360px !important;}
            .fancyboxc-inner{ width:300px !important; float:left !important; height:260px !important;}
            .fancyboxc-wrap {left: 360px !important;}
            .fancyboxc-skin {
                border: 3px solid #F99B3E !important;
                -webkit-border-radius: 5px !important;
                -moz-border-radius: 5px !important;
                border-radius: 5px !important;
            }
            .pad_lft_j{ padding-left:20px; }
            .pad_rght_j{ padding-right:15px; }
            .brdr1{ border:1px solid #e1e1e1;}
            .brdr-top_j{ border-top:0px !important;}
            .brdr-lft_j{ border-left:0px !important;}
            .add_pro{font-size: 14px;color: #ff9600;font-weight: bold;text-decoration: none;}
            .close_order {
                -moz-box-shadow: 0px 0px 0px 0px #3dc21b;
                -webkit-box-shadow: 0px 0px 0px 0px #3dc21b;
                box-shadow: 0px 0px 0px 0px #3dc21b;
                background-color:#44c767;
                -moz-border-radius:11px;
                -webkit-border-radius:11px;
                border-radius:11px;
                border:1px solid #18ab29;
                display:inline-block;
                cursor:pointer;
                color:#ffffff;
                font-family:arial;
                font-size:17px;
                font-weight:bold;
                padding:5px 24px;
                text-decoration:none;
                text-shadow:1px 2px 2px #2f6627;
                float: right;
                margin-top: 25px;
            }
            .close_order:hover {
                background-color:#5cbf2a;
            }
            .close_order:active {
                position:relative;
                top:1px;
            }
            .pointer{cursor: pointer;}
            /* .trail:hover {font-size: 16px; cursor: pointer;} */

            .none{display: none;}

            .modal-overlay {
                opacity: 0.7;
                filter: alpha(opacity=0);
                position: fixed;
                top: 0;
                left: 0;
                z-index: 900;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.3) !important;
            }

            .customer_auto { 
                border-color:#cccccc; 
                padding:10px; 
                font-size:20px; 
                border-radius:6px; 
                border-width:2px; 
                border-style:groove; 
                background-color:#ffffff; 
                text-shadow:0px 0px 0px rgba(42,42,42,.75);  
                width: 275px;
            } 
            .customer_auto:focus { outline:none; } 

            .auto_reference{
                cursor: pointer;
                list-style-type: none;
            }

            .auto_reference li:hover
            {
                background:#FF7E00;
                color:#FFF;
                cursor:pointer;
            }
            .auto_reference li
            {
                border-bottom: 1px #999 dashed;
            }
            .auto_reference span{
                font-size: 18px;
            }

            #result_ref
            {
                background-color: #f3f3f3;
                border-top: 0 none;
                box-shadow: 0 0 5px #ccc;
                display: none;
                margin-top: 0;
                overflow: hidden;
                padding: 10px;
                position: fixed;
                /* right: 650px; */
                text-align: left;
                /* top: 186px; */
                width: 260px;
                height: 120px;
                overflow-y: auto;
                left: 45%;
            }
            .inv_desc span{               
                float: left;
                margin-top: 10px;
            }
        </style>
        <!-- Add fancyBox main JS and CSS files -->
        <script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery.fancybox.css?v=2.1.5" media="screen" />



        <script type="text/javascript">
            $(document).ready(function() {
                /**  Simple image gallery. Uses default settings*/
                $('.fancybox').fancybox();

                /**  Different effects */
            });


            function change_customer(CUS_ID)
            {     
                $("#current_cus_id").val(CUS_ID);
                $("body").append("<div class='modal-overlay js-modal-close'></div>");
                $("#asap_popup").slideDown("slow");
            }

            function close_change_customer()
            {
                $("#current_cus_id").val();
                $(".modal-overlay").fadeOut();
                $("#asap_popup").slideUp("slow");
            }
            
            
            
            
        </script>
        <!--End -->
    </head>
    <body>
        <div id="loading" class="none"  style="position: fixed;top: 35%;left: 48%;padding: 5px;z-index: 9999;">
            <img src="images/login_loader.gif" border="0" />
        </div>

        <div id="asap_popup" style="display: none;font-size: 15px;position: fixed;top: 35%;left: 40%;padding: 5px;z-index: 10;position: absolute;z-index: 1000;width: 30%;background: white;border-bottom: 1px solid #aaa;border-radius: 4px;box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);border: 1px solid rgba(0, 0, 0, 0.1);background-clip: padding-box;">
            <div style="width: 96%;padding: 2%;float: left;font-size: 14px;line-height: 18px;text-align: center;">
                <h1 style="padding-bottom: 7px;">Select Customer</h1>
                <input type="hidden" name="current_cus_id" id="current_cus_id" value="" />
                <input type="text" class="customer_auto" id="customer_auto" value="" placeholder="Customer Name" onkeyup="return autosuggession();">
                <div id="result_ref">
                </div>
            </div>
            <div style="float: right;width: 98%;background-color: #EEE;padding: 1%;">               
                <span style="float: left;border: 1px solid #BBB;padding: 3px 10px;border-radius: 3px;cursor: pointer;" onclick="return assign_customer();">Assign</span>
                <span style="float: right;border: 1px solid #BBB;padding: 3px 10px;border-radius: 3px;cursor: pointer;" onclick="return close_change_customer();">Close</span>
            </div>
        </div>
        
        <div id="invoice_template" style="display: none;height: 485px;font-size: 15px;position: fixed;top: 400px;left: 29%;padding: 5px;z-index: 10;position: absolute;z-index: 1000;width: 56%;background: white;border-bottom: 1px solid #aaa;border-radius: 4px;box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);border: 1px solid rgba(0, 0, 0, 0.1);background-clip: padding-box;">
            <div id="invoice_template_content" style="width: 96%;padding: 2%;float: left;font-size: 14px;line-height: 18px;height: 410px;overflow-y: scroll;">
                
            </div>
            <div style="float: right;width: 98%;background-color: #EEE;padding: 1%;">               
                <span style="float: left;border: 1px solid #BBB;padding: 3px 10px;border-radius: 3px;cursor: pointer;" onclick="return generate_as_pdf();">Generate as PDF</span>
                <span style="float: right;border: 1px solid #BBB;padding: 3px 10px;border-radius: 3px;cursor: pointer;" onclick="return close_invoice_template();">Close</span>
            </div>
        </div>
        

        <?php
        if ($_GET['ord_id'] != '') {
            $order_id = $_GET['ord_id'];
            ?>
            <input type="hidden" name="ord_id" id="ord_id" value="<?php echo $order_id; ?>" />
            <script type="text/javascript">
                $(document).ready(function()
                {
                    var val = document.getElementById('ord_id').value;
                    $(".trigger").next(".test_" + val).fadeToggle('slow').siblings(".test_" + val).hide();
                });
            </script>
            <?php
        }
        ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center" valign="top">
                    <table width="960" border="0" cellspacing="0" cellpadding="0" style="min-width:760px;">
                        <tr>
                            <td width="198" align="left" valign="top" bgcolor="#464646"><table width="198" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="181" align="left" valign="top"><img src="images/logo.jpg" width="198" height="181"  alt=""/></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <?php include "sidebar_menu.php"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle" style="min-height:280px; float:left;"></td>
                                    </tr>
                                </table></td>
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
                                            SUPPLY ORDERS
                                            <span style="float: right;padding-right: 5px;">Welcome <?php
                                                if ($_SESSION['admin_user_type'] == '1') {
                                                    echo 'admin';
                                                } if ($_SESSION['admin_user_type'] == '2') {
                                                    echo 'Staff User';
                                                }
                                                ?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                            if ($_GET['delete_id']) {
                                                $delete_id = $_GET['delete_id'];
                                                $ord_id = $_GET['ord_id'];
                                                $sql = "DELETE FROM sohorepro_product_master WHERE id = " . $delete_id . " ";
                                                $sql_result = mysql_query($sql);
                                                if ($sql_result) {
                                                    $result = "success_del";
                                                } else {
                                                    $result = "failure_del";
                                                }
                                                if ($result == "success_del") {
                                                    ?>
                                                    <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Deleted Successfully</div>
                                                    <script>setTimeout("location.href=\'open_orders.php?ord_id=<?php echo $delete_id; ?>&ord_id=<?php echo $ord_id; ?>\'", 1000);</script>
                                                    <?php
                                                } elseif ($result == "failure_del") {
                                                    ?>
                                                    <div style="color:#F00; text-align:center; padding-bottom:10px;">Not Deleted</div>
                                                    <script>setTimeout("location.href=\'open_orders.php?ord_id=<?php echo $delete_id; ?>&ord_id=<?php echo $ord_id; ?>\'", 1000);</script>       
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            if ($result == "success_tax") {
                                                ?>
                                                <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Tax has been removed in this order</div>
                                                <script>setTimeout("location.href=\'open_orders.php\'", 1000);</script>
                                                <?php
                                            } elseif ($result == "failure_tax") {
                                                ?>
                                                <div style="color:#F00; text-align:center; padding-bottom:10px;">Tax has been not removed in this order</div>
                                                <script>setTimeout("location.href=\'open_orders.php\'", 1000);</script>       
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top"><table width="759" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="258" valign="middle" height="28" bgcolor="#f99b3e" align="center" class="td_brdr"><a style="text-decoration: none; color: #fff;" href="open_orders.php?sort=<?php echo $sort_jrn; ?>">ORDER NUMBER&nbsp;<img src="images/<?php echo $sort_jrn_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>
                                                    <td width="120" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="open_orders.php?sort=<?php echo $sort_date; ?>">DATE &nbsp;<img src="images/<?php echo $sort_date_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>                
                                                    <td width="189" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="open_orders.php?sort=<?php echo $sort_prc; ?>">Customer&nbsp;<img src="images/<?php echo $sort_prc_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>
                                                    <td width="258" valign="middle" height="28" bgcolor="#f99b3e" align="center" class="td_brdr"><a style="text-decoration: none; color: #fff;" href="open_orders.php?sort=<?php echo $sort_jrn; ?>">JOB REFERENCE&nbsp;<img src="images/<?php echo $sort_jrn_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>                
                                                </tr>
                                                <?php
                                                $i = 1;
                                                if (count($Orders) > 0) {
                                                    foreach ($Orders as $order) {
                                                        $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                        $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                        $id = $order['id'];
                                                        $orderser_id = $order['id'];
                                                        $order_id = $order['order_id'];
                                                        $order_numer = $order['order_number'];
                                                        //$date = date("m-d-Y h:m A", strtotime($order['created_date']));
                                                        $order_close_status = $order['closed_status'];
                                                        $current_time = $order['created_date'];
                                                        $datew = new DateTime($current_time, new DateTimeZone('America/New_York'));
                                                        date_default_timezone_set('America/New_York');
                                                        $temp_times = date("Y-m-d h:iA", $datew->format('U'));
                                                        $date = date("m/d/Y", strtotime($order['created_date'])) . ' ' . date("h:iA", strtotime("-0 minutes", strtotime($temp_times)));
                                                        $customer = ($order['customer_company_name'] != '') ? $order['customer_company_name'] : 'Guest User';
                                                        $price = getPrice($id);
                                                        $tax_status = getTaxStatusChk($order['customer_company']);
                                                        $cas_customer = $order['cash_customer'];
                                                        $tax_value = TaxValue();
                                                        if ($tax_status == '1') {
                                                            $tax_line = '0';
                                                        }
                                                        //               elseif($cas_customer == '1')
                                                        //                {
                                                        //                 $tax_line = '8.875';      
                                                        //                 }
                                                        else {

                                                            $tax_line = $tax_value;
                                                        }
                                                        $tax = ($tax_line * ($price[0]['sub_total'] / 100));
                                                        $grand_tot = ($price[0]['sub_total'] + $tax);
                                                        ?>

                                                        <tr class="trigger"  id="<?php echo $id; ?>"> 
                                                            <td width="210" height="36" align="center" bgcolor="<?php echo $rowColor; ?>"   valign="middle"><?php echo $order_numer; ?></td>             
                                                            <td width="176" height="36" align="center" bgcolor="<?php echo $rowColor1; ?>"  valign="middle"><?php echo $date; ?></td>                                    
                                                            <td width="109" height="36" align="center" bgcolor="<?php echo $rowColor; ?>"   valign="middle"><span id="customer_name_<?php echo $id; ?>"><?php echo $customer; ?></span></td>                
                                                            <td width="210" height="36" align="center" bgcolor="<?php echo $rowColor1; ?>"  valign="middle"><span class="refj_<?php echo $id; ?>" id="<?php echo $id; ?>"><?php echo $order_id; ?></span></td>
                                                            </t>
                                                            <?php
                                                            $toggle_id = viewOrders($id);
                                                            $ord_id = $toggle_id[0]['order_id'];
                                                            ?>           
                                                        <tr class="toggle test_<?php echo $ord_id; ?>">
                                                            <td colspan="4" align="center">                      
                                                                <table width="755" align="center" cellspacing="0" cellpadding="0" style="margin:10px 0px; padding: 10px; border: 2px solid #F99B3E;">
                                                                    <?php
                                                                    $sql_id = mysql_query("SELECT id,order_id,created_date,order_number,customer_name,customer_company,staff_id,cash_customer FROM sohorepro_order_master WHERE id = '" . $ord_id . "'");
                                                                    $object = mysql_fetch_assoc($sql_id);
                                                                    $Order_id = $object['order_id'];
                                                                    $ref_serial = $object['id'];
                                                                    $Order_number = $object['order_number'];
                                                                    $cust_dtls = customerName($object['customer_name']);
                                                                    $staf_init = CusInit($object['staff_id']);
                                                                    $company_name = companyName($cust_dtls[0]['cus_compname']);
                                                                    $cus_name = $cust_dtls[0]['cus_contact_name'];
                                                                    $cash_customer = $object['cash_customer'];

                                                                    $cus_add_1 = ($cust_dtls[0]['cus_bill_address1'] != '') ? $cust_dtls[0]['cus_bill_address1'] : '';
                                                                    $cus_add_2 = ($cust_dtls[0]['cus_bill_address2'] != '') ? $cust_dtls[0]['cus_bill_address2'] : '';
                                                                    $cus_city = ($cust_dtls[0]['cus_bill_city'] != '') ? $cust_dtls[0]['cus_bill_city'] . ',&nbsp;' : '';
                                                                    $cus_state = (StateName($cust_dtls[0]['cus_bill_state']) != '') ? StateName($cust_dtls[0]['cus_bill_state']) . '&nbsp;' : '';
                                                                    $cus_zip = ($cust_dtls[0]['cus_bill_zipcode'] != '0') ? $cust_dtls[0]['cus_bill_zipcode'] : '';
                                                                    $cus_mail = ($cust_dtls[0]['cus_email'] != '') ? $cust_dtls[0]['cus_email'] : '';
                                                                    $cus_phone = ($cust_dtls[0]['cus_contact_phone'] != '') ? $cust_dtls[0]['cus_contact_phone'] : '';

                                                                    $current_timne = $object['created_date'];
                                                                    $dateF = new DateTime($current_timne, new DateTimeZone('America/New_York'));
                                                                    date_default_timezone_set('America/New_York');
                                                                    $temp_time1 = date("Y-m-d h:iA", $dateF->format('U'));
                                                                    $Date = date("m/d/Y", strtotime($object['created_date'])) . ' ' . date("h:iA", strtotime("-0 minutes", strtotime($temp_time1)));
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <table width="755" border="0" align="center" cellspacing="0" cellpadding="0" >
                                                                                <tr align="left">
                                                                                    <td width="35%">
                                                                                        <table align="center" cellspacing="0" cellpadding="0" >
                                                                                            <tr> 
                                                                                            <span class="jass2" id="<?php echo $id; ?>" style="display: none;"></span>
                                                                                            <?php
                                                                                            $Order_id_trim = trim($Order_id);
                                                                                            $inline_edit_ref = ($Order_id_trim != '') ? $Order_id : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                                                                            ?>
                                                                                            <td align="left" valign="middle" style="font-size:14px; color:#ff9600; text-transform:uppercase;">Job Ref</td>   
                                                                                            <td align="left" valign="middle" style="font-size:14px; color:#ff9600; text-transform:uppercase;">:</td>   
                                                                                            <td align="left" valign="middle" style="color:#202020;"><span style="cursor: pointer;" class="reference ref_<?php echo $id; ?>" id="<?php echo $id; ?>"><?php echo $inline_edit_ref; ?></span>
                                                                                                <div style="float: left;"><input type="text" class="inline-text-prod-ref reference_txt_<?php echo $id; ?>" id="reference_txt_<?php echo $id; ?>" value="<?php echo $inline_edit_ref; ?>" style="display: none; text-transform: uppercase;width: 70px;"></div>
                                                                                                <div style="float: left; margin-left: 5px;"><img src="images/like_icon.png"  alt="Update" title="Update" width="22" height="22" class="refupdate ref_update_<?php echo $id; ?>" style="display: none; cursor: pointer;"/></div>
                                                                                                <div style="float: left; margin-left: 5px;"><img src="images/cancel_icon.png"  alt="Cancel" title="Cancel" width="22" height="22" class="refcancel ref_cancel_<?php echo $id; ?>" style="display: none; cursor: pointer;"/></div></td>
                                                                                </tr>

                                                                                <tr>                            
                                                                                    <td align="left" valign="middle" style="font-size:14px; color:#ff9600; text-transform:uppercase;">Order Number</td>                            
                                                                                    <td align="left" valign="middle" style="font-size:14px; color:#ff9600; text-transform:uppercase;">:</td>
                                                                                    <td align="left" valign="middle" style="color:#202020;"><?php echo $Order_number; ?></td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td align="left"  valign="middle" style="font-size:14px; color:#ff9600; text-transform:uppercase;">Date/Time</td>                            
                                                                                    <td align="left" valign="middle" style="font-size:14px; color:#ff9600; text-transform:uppercase;">:</td>
                                                                                    <td  align="left" valign="middle" style="color:#202020;"><?php echo $Date; ?></td>
                                                                                </tr>                            
                                                                            </table>
                                                                        </td>
                                                                        <td width="30%" align="center">
                                                                        <span style="cursor: pointer;background: #F99B3E;color: #FFF;float: left;padding: 5px 20px;margin-top: 5px;border-radius: 5px;text-decoration: none;margin-right: 15px;margin-left: 5px;" onclick="return change_customer('<?php echo $object['id']; ?>');">
                                                                                CHANGE COMPANY
                                                                        </span>
                                                                        </td>
                                                                        <td width="35%">
                                                                            <span style="font-size:14px; color:#ff9600; text-transform:uppercase;">Order placed by:</span>
                                                                            <table align="center" cellspacing="0" cellpadding="0" >
                                                                                <tr> 
                                                                                    <td><?php echo $cus_name; ?></td>
                                                                                </tr>                            
                                                                                <tr> 
                                                                                    <td><?php echo $cus_phone; ?></td>
                                                                                </tr>                            
                                                                                <tr> 
                                                                                    <td><?php echo $cus_mail; ?></td>
                                                                                </tr>                           
                                                                            </table>

                                                                        </td>
                                                                    </tr>
                                                                </table>  
                                                            </td>

                                                        </tr>

                                                        <tr><td align="left" valign="top" style="padding-top:10px">
                                                                <div id="inline_edit">                                        
                                                                    <table width="735" align="center" cellspacing="0" cellpadding="0" border="0">
                                                                        <tr style="color:#fff;">                               
                                                                            <td width="285" align="left" valign="middle" bgcolor="#f68210" class="brdr pad_lft">Product Detail</td>
                                                                            <td width="50" align="center" valign="middle" bgcolor="#f68210"  class="brdr">Quantity</td>
                                                                            <td width="75" align="center" valign="middle" bgcolor="#f68210"  class="brdr pad_rght">Unit Cost</td>
                                                                            <td width="85" align="center" valign="middle" bgcolor="#f68210" class="brdr pad_rght">Line Cost</td>                                
                                                                            <td width="15" align="center" valign="middle" bgcolor="#f68210"  class="brdr pad_rght">Action</td>
                                                                        </tr>
                                                                        <?php
                                                                        $view_orders = viewOrders($id);
                                                                        $j = 1;
                                                                        foreach ($view_orders as $ord) {
                                                                            $rowColor = ($j % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                                            $rowColor1 = ($j % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                                            $prod_id = $ord['product_id'];
                                                                            $id = $ord['id'];
                                                                            $ord_id_t = $ord['order_id'];
                                                                            $ship_id = $ord['shipping_add_id'];
                                                                            $super_id = getsuper($ord['product_id']);
                                                                            $cat_id = getcat($ord['product_id']);
                                                                            $sub_id = getsub($ord['product_id']);
                                                                            $super_name = (getsuperN($super_id) != '') ? getsuperN($super_id) : '';
                                                                            $cat_name_pre = (getcatN($cat_id) != '') ? getcatN($cat_id) : '';
                                                                            $cat_name = ($cat_name_pre != '') ? '>>' . $cat_name_pre : $cat_name_pre;
                                                                            $sub_name_pre = (getsubN($sub_id) != '') ? getsubN($sub_id) : '';
                                                                            $sub_name = ($sub_name != '') ? '>>' . $sub_name_pre : $sub_name_pre;
                                                                            ?>
                                                                            <tr class="inline" id="<?php echo $id; ?>" onclick="return inline_prod_edit('<?php echo $id . '_' . $ord_id; ?>');">
                                                                            <span class="jass" id="<?php echo $id; ?>" style="display: none;"></span>
                                                                            <span class="order_id_t_<?php echo $id; ?>" id="<?php echo $ord_id_t; ?>" style="display: none;"></span>
                                                                            <input type="text" id="h_<?php echo $id; ?>_<?php echo $ord_id; ?>" style="display: none;" value="<?php echo getpid($prod_id, $ord_id); ?>" />                                
                                                                            <td width="285" align="left" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="brdr pad_lft">
                                                                                <span class="product_<?php echo $id; ?>_<?php echo $ord_id; ?>"><?php echo $ord['product_name']; ?></span><input type="text" class="inline-text-prod product_txt_<?php echo $id; ?>_<?php echo $ord_id; ?>" id="product_txt_<?php echo $id; ?>_<?php echo $ord_id; ?>" value="<?php echo str_replace('"', "''", $ord['product_name']); ?>" style="display: none;" /></br>
                                                                                <span class="trail" style="font-size: 11px;color: #2a9be3;"><?php echo $super_name . $cat_name . $sub_name; ?></span>
                                                                            </td>
                                                                            <td width="50" align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="brdr"><span class="quantity_<?php echo $id; ?>_<?php echo $ord_id; ?>"><?php echo $ord['product_quantity']; ?></span><input type="text" class="inline-text quantity_txt_<?php echo $id; ?>_<?php echo $ord_id; ?>" id="quantity_txt_<?php echo $id; ?>_<?php echo $ord_id; ?>" value="<?php echo $ord['product_quantity']; ?>" style="display: none;"/></td>
                                                                            <td width="75" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="brdr pad_rght"><span class="price_<?php echo $id; ?>_<?php echo $ord_id; ?>"><?php echo '$' . $ord['product_price']; ?></span><input type="text" class="inline-text price_txt_<?php echo $id; ?>_<?php echo $ord_id; ?>" id="price_txt_<?php echo $id; ?>_<?php echo $ord_id; ?>" value="<?php echo $ord['product_price']; ?>" style="display: none;"/></td>                                
                                                                            <td width="85" align="left" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="brdr pad_rght"><span class="line_cost_<?php echo $id; ?>_<?php echo $ord_id; ?>"><?php echo '$' . number_format(($ord['product_quantity'] * $ord['product_price']), 2, '.', ''); ?></span></td>                                                                                                
                                                                            <td width="15" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="brdr pad_rght"><img src="images/like_icon.png"  alt="Update" title="Update" width="22" height="22" class="mar_lft updater update_<?php echo $id; ?>_<?php echo $ord_id; ?>" onclick="return update_dedails('<?php echo $id; ?>', '<?php echo $ord_id; ?>');"  style="display: none; margin-left: 0px;"/><a href="open_orders.php?delete_id=<?php echo $id; ?>&ord_id=<?php echo $ref_serial; ?>" onclick="return confirm('Are you delete this product of this order?');"><img src="images/del.png" class="delete_<?php echo $id; ?>_<?php echo $ord_id; ?>"  alt="Delete Product" title="Delete Product" width="22" height="22" class="mar_lft"/></a></td>
                                                                            </tr> 


                                                                            <?php
                                                                            $j++;
                                                                        }
                                                                        ?> 
                                                                        <!-- Add Product  Button Start -->
                                                                        <tr> 
                                                                            <td colspan="5" style="padding-top: 5px;"><a class="add_pro" href="aptor.php?ord_id=<?php echo $ref_serial; ?>&ship_id=<?php echo $ship_id ?>" style="cursor: pointer;"><b>+</b>Add Products</a></td> 
                                                                        </tr>                            
                                                                        <!-- Add Product  Button End -->
                                                                        <!---TAX START-->
                                                                        <tr>
                                                                            <td height="35" colspan="6" align="center">
                                                                                <div class="error" style="color:#FF0000;padding-left:35px;font-size: 12px;"></div>
                                                                                <div class="msg" style="color:#007F2A; font-size: 13px;"></div>
                                                                            </td>

                                                                        </tr>
                                                                        <tr>
                                                                            <!-- Comments Table Start -->
                                                                            <?php
                                                                            $comment = OrderComment($ref_serial);
                                                                            ?>
                                                                            <td colspan="3" valign="top">
                                                                                <table style="width: 100%;">
                                                                                    <tr>
                                                                                        <td class="add_cmmt">
                                                                                            Customer Comment
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <table style="padding: 10px;border: 2px solid #F99B3E;width: 100%;height: 75px;" align="center" cellspacing="0" cellpadding="0" >
                                                                                                <tr onclick="return edit_commt('<?php echo $customer_id; ?>', '<?php echo $Order_id; ?>');">
                                                                                                    <td>
                                                                                                        <span id="cus_commt_span_<?php echo $customer_id; ?>" class="cus_commt_span_<?php echo $customer_id; ?>_<?php echo $Order_id; ?>"><?php echo $comment[0]['order_comment']; ?></span>
                                                                                                        <!--<textarea name="cus_commt_txt_<?php echo $customer_id; ?>_<?php echo $Order_id; ?>" id="cus_commt_txt_<?php echo $customer_id; ?>_<?php echo $Order_id; ?>"  class="cus_commt_txt_<?php echo $customer_id; ?>_<?php echo $Order_id; ?>" autofocus="autofocus" style="width: 96%;padding: 5px;height: 35px;display: none;"><?php echo $comment[0]['comment']; ?></textarea>-->
                                                                                                    </td>
                                                                                                </tr>
                                                        <!--                                        <tr align="right">
                                                                                                    <td>
                                                                                                        <input style="display: none;" id="cus_commt_upt_<?php echo $customer_id; ?>_<?php echo $Order_id; ?>"  class="cus_commt_upt_<?php echo $customer_id; ?>_<?php echo $Order_id; ?>" type="button" name="update_commt" id="cus_commt_upt_<?php echo $customer_id; ?>" value="Update" onclick="return update_commt('<?php echo $customer_id; ?>','<?php echo $Order_id; ?>')" />
                                                                                                    </td>
                                                                                                </tr>-->
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>                                    
                                                                            </td>                    
                                                                            <!-- Comments Table End -->
                                                                            <td>&nbsp;</td>
                                                                            <td height="20" align="right" valign="top">

                                                                                <table align="right" width="240" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr>
                                                                                        <td height="30" align="left" valign="middle" class="pad_lft_j brdr1">Sub Total</td>
                                                                                        <td width="100" height="30" align="right" valign="middle" bgcolor="#FAFAFA" class="pad_rght_j brdr1  brdr-lft_j"><span class="line_<?php echo $ord_id; ?>" ><?php echo '$' . number_format($price[0]['sub_total'], 2, '.', ''); ?></span></td>
                                                                                        <td>&nbsp;</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td height="30" align="left" valign="middle" class="pad_lft_j brdr1 brdr-top_j">Tax</td>
                                                                                        <td width="100" height="30" align="right" valign="middle" bgcolor="#FAFAFA" class="pad_rght_j brdr1 brdr-top_j brdr-lft_j"><span class="tax_<?php echo $ord_id; ?>"><?php echo '$' . number_format($tax, 2, '.', ''); ?></span></td>
                                                                                        <td><?php if ($tax_status == '1') { ?><a href="open_orders.php?tax_status=<?php echo $ord_id; ?>" onclick="return confirm('Are you remove the tax in this order?');"><img src="images/del.png"  alt="Remove Tax" title="Remove Tax" width="22" height="22" class="mar_lft"/></a><?php } ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td height="30" align="left" valign="middle" class="pad_lft_j brdr1 brdr-top">Total</td>
                                                                                        <td width="100" height="30" align="right" valign="middle" bgcolor="#FAFAFA" class="pad_rght_j brdr1 brdr-top_j brdr-lft_j"><span class="lineJassim_<?php echo $ord_id; ?>"><?php echo '$' . number_format(($price[0]['sub_total'] + $tax), 2, '.', ''); ?></span></td>
                                                                                        <td>&nbsp;</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td> 
                                                                            <td>&nbsp;</td>
                                                                        </tr>
                                                                        <!---TAX START-->
                                                                        <tr>
                                                                            <td colspan="6">
                                                                                <div style="width:100%;float:left;">
                                                                                <span style="cursor: pointer;background: #F99B3E;color: #FFF;float: left;padding: 5px 20px;margin-top: 5px;border-radius: 5px;" onclick="return send_mail_update_order('<?php echo $ref_serial; ?>', '<?php echo $ship_id; ?>');">Email Updated Order</span>
                                                                                <!--<span class="confirm_mail_<?php echo $ref_serial; ?> none" id="mail_to_<?php echo $ref_serial; ?>" style="float: left;margin-top: 10px;margin-left: 10px;color: #029F5A;"><a href="" class="mail_to_<?php echo $ref_serial; ?>" >Go to Email Application</a></span>-->
                                                                                <span class="confirm_mail_<?php echo $ref_serial; ?> none" id="confirm_mail_<?php echo $ref_serial; ?>" style="float: left;margin-top: 10px;margin-left: 10px;color: #029F5A;">New order email sent..</span>

                                                                                <!--<a class="fancybox fancybox.iframe fav_button" href="view_sets.php?order_id=<?php echo $ref_serial; ?>" style="cursor: pointer;background: #F99B3E;color: #FFF;float: left;padding: 5px 20px;margin-top: 5px;border-radius: 5px;text-decoration: none;margin-right: 15px;margin-left:5px;">View Sets</a>-->                                    
                                                                                
                                                                                <!--<span onclick="return open_invoice_type('<?php echo $ref_serial; ?>');" style="cursor: pointer;background: #F99B3E;color: #FFF;float: right;padding: 5px 20px;margin-top: 5px;border-radius: 5px;text-decoration: none;margin-right: 15px;margin-left:5px;margin-bottom: 15px;">Close Order</span>-->
                                                                                <?php 
                                                                                $close_lable    = ($order_close_status == '1') ? 'Ready to Invoice' : 'Close Order';
                                                                                $close_lable_bg = ($order_close_status == '1') ? 'background: #DA4530;' : 'background: #F99B3E;';                                                                                
                                                                                ?>
                                                                                <span id="close_status_<?php echo $ref_serial; ?>" onclick="return close_order_now('<?php echo $ref_serial; ?>');" style="<?php echo $close_lable_bg; ?>;cursor: pointer;color: #FFF;float: right;padding: 5px 20px;margin-top: 5px;border-radius: 5px;text-decoration: none;margin-right: 15px;margin-left:5px;margin-bottom: 15px;font-weight: bold;"><?php echo $close_lable; ?></span>
                                                                                
                                                                                
                                                                                </div>
                                                                                
                                                                                <!--<div id="invoice_section_<?php echo $ref_serial; ?>" onchange="return gererate_invoice('<?php echo $ref_serial; ?>','<?php echo $order['customer_company'] ?>');" style="float: right;margin-right: 30px;margin-top: -10px;display:none;">
                                                                                    <select name="invoice_freq" class="invoice_freq_type" id="invoice_freq_<?php echo $ref_serial; ?>">
                                                                                        <option value="0">Select Type</option>
                                                                                        <option value="week">Weekly</option>
                                                                                        <option value="semi">Semi-Weekly</option>
                                                                                        <option value="month">Monthly</option>
                                                                                    </select>                                                                                           
                                                                                </div>-->                                                                                
                                                                            </td>                                                                            
                                                                        </tr>
                                                                    </table>
                                                                </div>  
                                                            </td>
                                                        </tr>
                                                    </table>                        
                                                </td>
                                            </tr>  

                                            <?php
                                            $i++;
                                        }
                                    } else {
                                        ?>
                                        <tr  bgcolor="<?php echo $rowColor; ?>">
                                            <td colspan="4" align="center">There is no orders</td>
                                        </tr>              
                                    <?php } ?>

                                </table></td>
                        </tr>
                        <tr align="right">
                            <td><?php echo Paginations($limit, $page, 'open_orders.php?page=', $rows); ?></td>
                        </tr>
                    </table></td>
            </tr>
        </table></td>
</tr>  
<tr>
    <td style="background:#464646; text-align:center; color:#fff; line-height:30px;" height="30p">© <?php echo date('Y'); ?> sohorepro.com</td>
</tr>
</table>



<div id="update_email_order" style="width: 450px; left: 40%; top: 25%;">    	
    <div class="close"></div>
    <span class="ecs_tooltip">Press Esc to close <span class="arrow"></span></span>
    <div id="popup_content_em_upt" >            
        <div style="padding: 10px;text-align: center;font-size: 22px;">Email Updated Order</div>
        <div id="update_mail_dynamic">

        </div>            
    </div>
</div>
<div class="login_loader"></div>
<div id="backgroundPopup"></div>



</body>
</html>
<script type="text/javascript">
//    
//    function edit_commt(CUS_ID,ORD_ID)
//    {
//        $(".cus_commt_span_"+CUS_ID+'_'+ORD_ID).hide(); 
//        $(".cus_commt_txt_"+CUS_ID+'_'+ORD_ID).show();  
//        $(".cus_commt_upt_"+CUS_ID+'_'+ORD_ID).show();    
//    }   
//    
//    function update_commt(CUS_ID,ORD_ID)
//    {
//         var cus_commt = $("#cus_commt_txt_"+CUS_ID+'_'+ORD_ID).val();  
//         if(cus_commt != '')  
//            {
//             $.ajax
//             ({
//                type: "POST",
//                    url: "get_child.php",
//                    data: "cus_commt="+cus_commt+"&cus_commt_id="+CUS_ID,
//                    beforeSend: loadStart,
//                    complete: loadStop,
//                    success: function(option)
//                    {
//                        if(option == '1'){
//                        $(".cus_commt_span_"+CUS_ID+'_'+ORD_ID).html(cus_commt); 
//                        $(".cus_commt_span_"+CUS_ID+'_'+ORD_ID).show(); 
//                        $(".cus_commt_txt_"+CUS_ID+'_'+ORD_ID).hide();  
//                        $(".cus_commt_upt_"+CUS_ID+'_'+ORD_ID).hide();   
//                        }
//                    }
//             });
//            }
//    }

    function logingAlertPop()
    {
        closeloading(); // fadeout loading
        $("#update_email_order").fadeIn(0500); // fadein popup div
        $("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
        $("#backgroundPopup").fadeIn(0001);
    }

    function loading() {
        $("div.login_loader").show();
    }

    function closeloading() {
        $("div.login_loader").fadeOut('normal');
    }

    function disablePopup()
    {
        $("#update_email_order").fadeOut("normal");
        $("#backgroundPopup").fadeOut("normal");
    }

    $(document).ready(function()
    {
        $('.trigger').click(function()
        {
            var val = $(this).attr('id');
            if ($(this).is(':visible'))
            {
                $(this).next(".test_" + val).fadeToggle('slow').siblings(".test_" + val).hide();
            }
        });

//    $('.inline').click(function()
//    {
//        var ID      =$(this).attr('id'); 
//        $(".product_"+ID).hide(); 
//        $(".quantity_"+ID).hide(); 
//        $(".price_"+ID).hide(); 
//        $(".delete_"+ID).hide();        
//        $(".product_txt_"+ID).show(); 
//        $(".quantity_txt_"+ID).show(); 
//        $(".price_txt_"+ID).show(); 
//        $(".update_"+ID).show();         
//        $(".jass").attr("id",ID);        
//    });
//    


//    $(document).mouseup(function()
//    {
//        var ID = $('.jass').attr('id');
//        $(".product_"+ID).show(); 
//        $(".quantity_"+ID).show(); 
//        $(".price_"+ID).show(); 
//        $(".delete_"+ID).show();  
//        $(".product_txt_"+ID).hide(); 
//        $(".quantity_txt_"+ID).hide(); 
//        $(".price_txt_"+ID).hide(); 
//        $(".update_"+ID).hide(); 
//    });

        $('.reference').click(function()
        {
            var OR_ID = $(this).attr('id');
            $(".ref_" + OR_ID).hide();
            $(".reference_txt_" + OR_ID).show();
            $(".ref_update_" + OR_ID).show();
            $(".ref_cancel_" + OR_ID).show();
            $(".jass2").attr("id", OR_ID);
        });

        $('.refcancel').click(function()
        {
            var OR_ID = $('.jass2').attr('id');
            $(".ref_" + OR_ID).show();
            $(".reference_txt_" + OR_ID).hide();
            $(".ref_update_" + OR_ID).hide();
            $(".ref_cancel_" + OR_ID).hide();
        });

        $(function() {
            var ID = $('.jass').attr('id');
            $("#quantity_txt_" + ID).keydown(function(event) {

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

        $(function() {
            var ID = $('.jass').attr('id');
            $("#price_txt_" + ID).keydown(function(event) {

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


    });

    function send_mail_update_order(order_id, ship_id)
    {
        var mail_confirm = confirm('Are you sure ?');

        if (mail_confirm == true) {
            if (order_id != '')
            {
                       //loading(); // loading
                         setTimeout(function(){ // then show popup, deley in .5 second
                            logingAlertPop(); // function show popup 
                            }, 500); // .5 second
                $.ajax
                        ({
                            type: "POST",
                            url: "update_mail_content.php",
                            data: "order_id=" + order_id,
                            beforeSend: loadStart,
                            complete: loadStop,
                            success: function(option)
                            {
                                    // var subject_to = option;
                                    // var subject_to_body = option.split("~");
                                    // var body_content            = encodeURIComponent(subject_to_body[1]);
                                    // $("#mail_to_"+order_id).show();
                                    // $(".mail_to_"+order_id).attr("href", subject_to_body[0]+'?body='+subject_to_body[1]);
                                //document.location.href = option;
                                $("#update_mail_dynamic").html(option);
                            }
                        });


//                    $.ajax
//                    ({
//                       type: "POST",
//                           url: "get_child.php",
//                           data: "update_email_ord_id="+order_id+"&update_email_ship_id="+ship_id,
//                           beforeSend: loadStart,
//                           complete: loadStop,
//                           success: function(option)
//                           {
//                               if(option != ''){
//                               $(".confirm_mail_"+order_id).show();               
//                               $(".confirm_mail_"+order_id).fadeOut(2500);               
//                               }
//                           }
//                    });
            }
        }
        else
        {
            return false;
        }

    }


    function view_order_set(ORDER_ID)
    {
        //alert(ORDER_ID);
        if (ORDER_ID != '')
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "update_mail_content.php",
                        data: "order_id=" + order_id,
                        beforeSend: loadStart,
                        complete: loadStop,
                        success: function(option)
                        {
                            document.location.href = option;
                        }
                    });
        }
    }

    function send_upt_mail(order_id)
    {
        var short_msg = document.getElementById('upt_mail_msg').value;
        $.ajax
                ({
                    type: "POST",
                    url: "get_child.php",
                    data: "update_email_ord_id=" + order_id + "&short_msg=" + encodeURIComponent(short_msg),
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {
                        if (option != '') {
                            disablePopup()
                            $(".confirm_mail_" + order_id).show();
                            $(".confirm_mail_" + order_id).fadeOut(2500);
                        }
                    }
                });
    }

    $(document).ready(function()
    {
        $("div.close").hover(
                function() {
                    $('span.ecs_tooltip').show();
                },
                function() {
                    $('span.ecs_tooltip').hide();
                }
        );

        $("div.close").click(function() {
            disablePopup();  // function close pop up
        });

        $(this).keyup(function(event) {
            if (event.which == 27) { // 27 is 'Ecs' in the keyboard
                disablePopup();  // function close pop up
            }
        });

        $("div#backgroundPopup").click(function() {
            disablePopup();  // function close pop up
        });

    });

</script>

<script type="text/javascript">

    function inline_prod_edit(id_val)
    {
        var ID = id_val.split("_");
        $(".product_" + ID[0] + '_' + ID[1]).hide();
        $(".quantity_" + ID[0] + '_' + ID[1]).hide();
        $(".price_" + ID[0] + '_' + ID[1]).hide();
        $(".delete_" + ID[0] + '_' + ID[1]).hide();
        $(".product_txt_" + ID[0] + '_' + ID[1]).show();
        $(".quantity_txt_" + ID[0] + '_' + ID[1]).show();
        $(".price_txt_" + ID[0] + '_' + ID[1]).show();
        $(".update_" + ID[0] + '_' + ID[1]).show();
        $(".jass").attr("id", ID[0]);
    }

    function update_dedails(ID, ord_id)
    {
        //alert(ID+' '+ord_id);
        var order_id = $('.order_id_t_' + ID).attr('id');
        var IID = document.getElementById('h_' + ID + '_' + ord_id).value;
        var product = document.getElementById('product_txt_' + ID + '_' + ord_id).value;
        var qty = document.getElementById('quantity_txt_' + ID + '_' + ord_id).value;
        var price = document.getElementById('price_txt_' + ID + '_' + ord_id).value;

        if (price != '' && qty != '')
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "get_child.php",
                        data: "product=" + product + "&qty=" + qty + "&price=" + price + "&id=" + ID + "&iid=" + IID + "&order_id=" + order_id,
                        success: function(option)
                        {
                            var myarr = option.split("~");

                            var line = (myarr[1] * myarr[2]);
                            $(".product_" + ID + '_' + ord_id).html(myarr[0]);
                            $(".quantity_" + ID + '_' + ord_id).html(myarr[1]);
                            $(".price_" + ID + '_' + ord_id).html("$" + myarr[2]);
                            $(".tax_" + ord_id).html("$" + myarr[5]);
                            $(".line_cost_" + ID + '_' + ord_id).html(myarr[7]);
                            $(".line_" + ord_id).html("$" + myarr[6]);
                            $(".lineJassim_" + ord_id).html("$" + myarr[4]);
                            $(".jassim_" + order_id).html("$" + myarr[4]);
                            $(".product_" + ID + '_' + ord_id).show();
                            $(".quantity_" + ID + '_' + ord_id).show();
                            $(".price_" + ID + '_' + ord_id).show();
                            $(".delete_" + ID + '_' + ord_id).show();
                            $(".product_txt_" + ID + '_' + ord_id).hide();
                            $(".quantity_txt_" + ID + '_' + ord_id).hide();
                            $(".price_txt_" + ID + '_' + ord_id).hide();
                            $(".update_" + ID + '_' + ord_id).hide();
                        }
                    });
        }
        else
        {
            $(".error").html("Please fill the all fields");
        }
        return false;
    }

    $(document).ready(function()
    {
//  $('.updater').click(function()
//    {
//       
//        var ID                   = $('.jass').attr('id');          
//        var order_id             = $('.order_id_t_'+ID).attr('id');
//        var IID                  = document.getElementById('h_'+ID).value;        
//        var product              = document.getElementById('product_txt_'+ID).value;
//        var qty                  = document.getElementById('quantity_txt_'+ID).value;
//        var price                = document.getElementById('price_txt_'+ID).value;
//        
//            if(price != '' && qty != '')  
//     {
//      $.ajax
//      ({
//         type: "POST",
//             url: "get_child.php",
//             data: "product="+product+"&qty="+qty+"&price="+price+"&id="+ID+"&iid="+IID+"&order_id="+order_id,
//             success: function(option)
//             {
//                 var myarr = option.split("~");
//
//                 var line = (myarr[1] * myarr[2]);
//                 $(".product_"+ID).html(myarr[0]); 
//                 $(".quantity_"+ID).html(myarr[1]); 
//                 $(".price_"+ID).html("$"+myarr[2]); 
//                 $(".tax_"+ID).html("$"+myarr[5]); 
//                 $(".line_cost_"+ID).html(myarr[7]); 
//                 $(".line_"+ID).html("$"+myarr[6]);
//                 $(".lineJassim_"+ID).html("$"+myarr[4]); 
//                 $(".jassim_"+order_id).html("$"+myarr[4]); 
//             }
//      });
//     }
//	 else
//	 {
//	   $(".error").html("Please fill the all fields"); 
//	 }
//	return false;
//        
//    });
        

        $('.refupdate').click(function()
        {
            var ID = $('.jass2').attr('id');
            var reference = document.getElementById('reference_txt_' + ID).value;

            if (reference != '')
            {
                $.ajax
                        ({
                            type: "POST",
                            url: "get_child.php",
                            data: "reference=" + reference + "&id=" + ID,
                            success: function(option)
                            {
                                $(".ref_" + ID).html(option);
                                $(".refj_" + ID).html(option);
                                $(".ref_" + ID).show();
                                $(".reference_txt_" + ID).hide();
                                $(".ref_update_" + ID).hide();
                                $(".ref_cancel_" + ID).hide();
                            }
                        });
            }
            else
            {
                $(".error").html("Please fill the all fields");
            }
            return false;

        });


    });

    

    function autosuggession()
    {
        var searc_name = $("#customer_auto").val();
        var dataString = 'search=' + encodeURIComponent(searc_name);
        if (searc_name != '')
        {
            $.ajax({
                type: "POST",
                url: "auto_customer_fill.php",
                data: dataString,
                cache: false,
                success: function(html)
                {
                    if (html != '') {
                        $("#result_ref").html(html).show();
                    } else {
                        $("#result_ref").hide();
                    }
                }
            });
        } else {
            $("#result_ref").hide();
        }
    }

    function get_customer_name(CUS_NAME)
    {
        $("#customer_auto").val(CUS_NAME);
        var search_val = $("#customer_auto").val();

        if (search_val != '') {
            $("#result_ref").hide();            
        }

    }
    
    function assign_customer()
    {
        var searc_name = $("#customer_auto").val();
        var current_cus_id = $("#current_cus_id").val();
        if(searc_name != ''){
        $.ajax
               ({
                   type: "POST",
                   url: "get_child.php",
                   data: "change_cus_order=1&customer_name="+encodeURIComponent(searc_name)+"&current_cus_id="+current_cus_id,
                   beforeSend: loadStart,
                   complete: loadStop,
                   success: function(option)
                   {
                       if (option != '') {
                           $(".modal-overlay").fadeOut();
                           $("#asap_popup").slideUp("slow");
                           $("#customer_name_"+current_cus_id).html(searc_name);
                       }
                   }
               }); 
        }else{
           $("#customer_auto").focus();
           return false;
        }
    }
    
    function loadStart() {
        $('#loading').show();
    }

    function loadStop() {
        $('#loading').hide();
    }
    
    function open_invoice_type(ORD_ID)
    {
        $('#invoice_section_'+ORD_ID).slideDown();
        $('#invoice_section_'+ORD_ID).addClass("inv_section");
    }   
    
    function gererate_invoice(ORD_ID,COMP_ID)
    {
        $("body").append("<div class='modal-overlay js-modal-close'></div>");
        $("#invoice_template").slideDown('slow');             
        var frequency_value = $('#invoice_freq_'+ORD_ID).val();
        var scrol_pos = $("body").scrollTop();
        var extra_pos = Number(scrol_pos) + Number(10);
        $("#invoice_template").css('top', extra_pos+'px');
        
        if(ORD_ID != ''){
        $.ajax
               ({
                   type: "POST",
                   url: "generate_invoice.php",
                   data: "invoice_type="+frequency_value+"&invoice_order_id="+ORD_ID+"&invoice_comp_id="+COMP_ID,
                   beforeSend: loadStart,
                   complete: loadStop,
                   success: function(option)
                   {
                       $("#invoice_template_content").html(option);
                   }
               }); 
        }
    }
     
     
    function close_invoice_template()
            {                
                $(".modal-overlay").fadeOut();
                $("#invoice_template").slideUp("slow");
                $(".invoice_freq_type").val('0');
            }
            
    function close_order_now(ORD_ID){
        var ays         =  confirm('Are you sure?');
        if(ays == true){
        if(ORD_ID != ''){
        $.ajax
               ({
                   type: "POST",
                   url: "get_child.php",
                   data: "order_closed_now_id="+ORD_ID,
                   beforeSend: loadStart,
                   complete: loadStop,
                   success: function(option)
                   {    
                       //alert(option);
                       if(option == true){
                        $("#close_status_"+ORD_ID).html("Ready to Invoice");
                        $("#close_status_"+ORD_ID).css("background", "#DA4530");                      
                        }else{
                        $("#close_status_"+ORD_ID).html("Close Order");
                        $("#close_status_"+ORD_ID).css("background", "#F99B3E");     
                        }
                   }
               }); 
        }
        }else{
            return false;
        }
    }
</script>