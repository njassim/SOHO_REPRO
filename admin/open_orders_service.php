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

$Orders = getOrdersAllServices($_REQUEST['sort'], $start, $limit);
$rows = count(SeriviceOrdersCount());

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
            
            .service_ref li label{
                width: 45%;
                float: left;
                font-size: 14px;
                color: #ff9600;
                text-transform: uppercase;
            }
            
            
            .shaddows{
        background: white;
        border-radius: 10px;
        -webkit-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
        -moz-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
        box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
        position: relative;
        z-index: 90;
        margin-bottom: 10px;
}

// Ribbon Style

#ribbon_final{
  position: absolute !important;
  left: -5px !important; 
  top: -5px !important;
  z-index: 1 !important;
  overflow: hidden !important;
  width: 75px !important;
  height: 75px !important;
  text-align: right !important;  
}

.ribbon {
  position: absolute !important;
  left: -5px !important; 
  top: -5px !important;
  z-index: 1 !important;
  overflow: hidden !important;
  width: 75px !important;
  height: 75px !important;
  text-align: right !important;
}
.ribbon span {
  font-size: 10px;
  font-weight: bold;
  color: #FFF;
  text-transform: uppercase;
  text-align: center;
  line-height: 20px;
  transform: rotate(-45deg);
  width: 100px;
  display: block;
  background: #79A70A;
  background: linear-gradient(#BFC5CD 0%, #83878C 100%);
  box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
  position: absolute;
  top: 19px; left: -21px;
}
.ribbon span::before {
  content: "";
  position: absolute; left: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid #83878C;
  border-right: 3px solid transparent;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #83878C;
}
.ribbon span::after {
  content: "";
  position: absolute; right: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid transparent;
  border-right: 3px solid #83878C;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #83878C;
}

.details_div{
    float: left;
}
#multi_recipients{
    margin-top: 5px;
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
                                            SERVICE ORDERS
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
                                                    <td width="258" valign="middle" height="28" bgcolor="#f99b3e" align="center" class="td_brdr"><a style="text-decoration: none; color: #fff;" href="open_orders_service.php?sort=<?php echo $sort_jrn; ?>">ORDER NUMBER&nbsp;<img src="images/<?php echo $sort_jrn_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>
                                                    <td width="120" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="open_orders_service.php?sort=<?php echo $sort_date; ?>">DATE &nbsp;<img src="images/<?php echo $sort_date_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>                
                                                    <td width="189" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="open_orders_service.php?sort=<?php echo $sort_prc; ?>">Customer&nbsp;<img src="images/<?php echo $sort_prc_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>
                                                    <td width="258" valign="middle" height="28" bgcolor="#f99b3e" align="center" class="td_brdr"><a style="text-decoration: none; color: #fff;" href="open_orders_service.php?sort=<?php echo $sort_jrn; ?>">JOB REFERENCE&nbsp;<img src="images/<?php echo $sort_jrn_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>                
                                                </tr>
                                                <?php
                                                $i = 1;
                                                if (count($Orders) > 0) {
                                                    foreach ($Orders as $order) {
                                                        $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                        $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                        $id = $order['id'];
                                                        $customer = $order['customer_company_name'];
                                                        $order_numer = $order['order_sequence'];
                                                        $cas_customer = $order['cash_customer'];
                                                        
                                                        $current_time = $order['created_date'];
                                                        $datew = new DateTime($current_time, new DateTimeZone('America/New_York'));
                                                        date_default_timezone_set('America/New_York');
                                                        $temp_times = date("Y-m-d h:iA", $datew->format('U'));
                                                        $date = date("m/d/Y", strtotime($order['created_date'])) . ' ' . date("h:iA", strtotime("-0 minutes", strtotime($temp_times)));
                                                        
                                                        $entered_needed_sets = ServiceSets($id);
                                                        $cust_dtls = customerName($order['user_id']);
                                                        $customer_name = $cust_dtls[0]['cus_contact_name'];
                                                        $customer_phone = $cust_dtls[0]['cus_contact_phone'];
                                                        $customer_mail  = $cust_dtls[0]['cus_email'];
                                                        ?>

                                                        <tr class="trigger"  id="<?php echo $id; ?>"> 
                                                            <td width="210" height="36" align="center" bgcolor="<?php echo $rowColor; ?>"   valign="middle"><?php echo $order_numer; ?></td>             
                                                            <td width="176" height="36" align="center" bgcolor="<?php echo $rowColor1; ?>"  valign="middle"><?php echo $date; ?></td>                                    
                                                            <td width="109" height="36" align="center" bgcolor="<?php echo $rowColor; ?>"   valign="middle"><span id="customer_name_<?php echo $id; ?>"><?php echo $customer; ?></span></td>                
                                                            <td width="210" height="36" align="center" bgcolor="<?php echo $rowColor1; ?>"  valign="middle"><span class="refj_<?php echo $id; ?>" id="<?php echo $id; ?>"><?php echo $order['reference']; ?></span></td>
                                                        </tr>
                                                        <tr class="toggle test_<?php echo $id; ?>">
                                                            <td colspan="4">
                                                                <div style="width:99%;float:left;margin:4px 0px;border: 2px solid #F99B3E;">
                                                                    
                                                                    <div style="width:100%;float:left;padding: 5px;">
                                                                        
                                                                        <div style="width:40%;float:left;border: 0px solid #F99B3E;margin-right: 15px;margin-left: 10px;margin-top: 10px;">
                                                                            <ul class="service_ref">
                                                                                <li>
                                                                                    <label>JOB REF</label>
                                                                                    <span>:&nbsp;&nbsp;&nbsp;<?php echo $order['reference']; ?></span>
                                                                                </li>
                                                                                <li>
                                                                                    <label>ORDER NUMBER</label>
                                                                                    <span>:&nbsp;&nbsp;&nbsp;<?php echo $order_numer; ?></span>
                                                                                </li>
                                                                                <li>
                                                                                    <label>DATE/TIME</label>
                                                                                    <span>:&nbsp;&nbsp;&nbsp;07/06/2015 05:43PM</span>
                                                                                </li>
                                                                            </ul> 
                                                                        </div>
                                                                        <div style="width:20%;float:left;border: 0px solid #F99B3E;margin-right: 15px;">&nbsp;</div>
                                                                        <div style="width:30%;float:left;border: 0px solid #F99B3E;">
                                                                            <div style="float:left;width: 100%;font-size: 14px;color: #ff9600;text-transform: uppercase;">ORDER PLACED BY:</div>
                                                                            <div style="float:left;width: 100%;">
                                                                                <span style="float:left;width: 100%;"><?php echo $customer_name; ?></span>
                                                                                <span style="float:left;width: 100%;"><?php echo $customer_phone; ?></span>
                                                                                <span style="float:left;width: 100%;"><?php echo $customer_mail; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div style="width:97%;float:left;padding: 5px;border: 0px solid #F99B3E;margin-top: 10px;">
                                                                            <?php
                                                                            $r = 1;
                                                                                    foreach ($entered_needed_sets as $entered_sets){
                                                                                        if(($entered_sets['shipp_id'] == 'P1') && ($entered_sets['shipp_id'] == 'P2')){
                                                                                            $shipp_add = AddressBookPickupSohoCap($entered_sets['shipp_id']);
                                                                                        }else{
                                                                                            $shipp_add = SelectIdAddress($entered_sets['shipp_id']);  
                                                                                        }
                                                                                    $needed_sets  = ($entered_sets['plot_needed'] != '0') ? $entered_sets['plot_needed'] : $entered_sets['arch_needed'];
                                                                                    $order_type   = ($entered_sets['arch_needed'] != '0') ? 'Copies' : 'Plotting on Bond';
                                                                                    $plot_binding = ($entered_sets['binding'] == '0') ? '' : ','.$entered_sets['binding'];
                                                                                    $plot_folding = ($entered_sets['folding'] == '0') ? '' : ','.$entered_sets['folding'];
                                                                                    $arch_binding = ($entered_sets['arch_binding'] == '0') ? '' : ','.$entered_sets['arch_binding'];
                                                                                    $arch_folding = ($entered_sets['arch_folding'] == '0') ? '' : ','.$entered_sets['arch_folding'];
                                                                                ?> 

                                                                                    <div style="float: left;" class="shaddows">
                                                                                        <div class="ribbon" id="ribbon_final"><span>RECIPIENT <?php echo $r; ?></span></div>
                                                                                    <div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;">                            
                                                                                        <div style="float: right;">
                                                                                            <span title="Edit Recipient" alt="Edit Recipient" style="" onclick="return edit_recipient('<?php echo $entered_sets['id']; ?>');">&nbsp;</span>                               
                                                                                        </div>
                                                                                        <div class="details_div">
                                                                                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 10px;font-weight: bold;">Send to :</div>
                                                                            <div style="float: left;width: 33%;margin-left: 30px;">  
                                                                                <?php
                                                                                if(($entered_sets['shipp_id'] != 'P1') && ($entered_sets['shipp_id'] != 'P2')){
                                                                                $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . ',<br>';
                                                                                echo $shipp_add[0]['company_name'] . '<br>' . $shipp_add[0]['address_1'] . ',<br>' . $add_2 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'];
                                                                                }  else {                    //echo $shipp_add[0]['address'];                        
                                                                                $shipp_add_p = AddressBookPickupSohoCap($entered_sets['shipp_id']);
                                                                                echo $shipp_add_p[0]['address'];   
                                                                                }
                                                                                ?>                   
                                                                            </div>
                                                                            <!-- Address Show End -->

                                                                            <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>
                                                                            <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">

                                                                                <table border="0" style="width: 100%;">
                                                                                    <tr bgcolor="#BFC5CD">
                                                                                        <td style="font-weight: bold;">Sets</td> 
                                                                                        <td style="font-weight: bold;">Order Type</td>                            
                                                                                        <td style="font-weight: bold;">Size</td>
                                                                                        <td style="font-weight: bold;">Output</td>
                                                                                        <td style="font-weight: bold;">Binding</td>
                                                                                        <td style="font-weight: bold;">Folding</td>
                                                                                    </tr>
                                                                                    <tr bgcolor="#F8F8F8">
                                                                                        <td><?php echo $needed_sets; ?></td>
                                                                                        <td><?php echo $order_type; ?></td>                            
                                                                                        <td><?php echo $entered_sets['size']; ?></td>
                                                                                        <td><?php echo $entered_sets['output']; ?></td>
                                                                                        <td><?php echo $entered_sets['binding']; ?></td>
                                                                                        <td><?php echo $entered_sets['folding']; ?></td>
                                                                                    </tr>
                                                                                </table>

                                                                                <!--   1. <?php // echo $entered_sets['plot_needed'] . '&nbsp;Sets Plotting on Bond,' . $entered_sets['size'] . ',' . $entered_sets['output'] . $plot_binding . $plot_folding; ?></br>-->
                                                                                <!--   2. <?php // echo  $entered_sets['arch_needed'].'&nbsp;Sets Plotting on Bond,'. $entered_sets['arch_size'].','.$entered_sets['arch_output'].$arch_binding.$arch_folding;   ?> -->
                                                                            </div>
                                                                            <?php 
                                                                            if($entered_sets['size'] == 'Custom'){
                                                                            ?>
                                                                            <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                                                                                <div style="font-weight: bold;width: 100%;float: left;">
                                                                                    Custom Size Details :
                                                                                </div>
                                                                                <div style="padding-top: 3px;">                    
                                                                                    <?php echo $entered_sets['custome_details']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <?php } ?>
                                                                            
                                                                            <?php 
                                                                            if($entered_sets['output'] == 'Both'){
                                                                            ?>
                                                                            <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                                                                                <div style="font-weight: bold;width: 100%;float: left;">
                                                                                    Page Number :
                                                                                </div>
                                                                                <div style="padding-top: 3px;">                    
                                                                                    <?php echo $entered_sets['output_page_number']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <?php } ?>
                                                                            
                                                                            <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;">
                                                                                <?php
                                                                                $date_asap  = ($entered_sets['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_sets['shipp_time'] : '';
                                                                                ?>
                                                                                <span style="font-weight: bold;">When Needed : </span><?php echo $entered_sets['shipp_date'].$date_asap; ?>            
                                                                            </div>        
                                                                            <?php
                                                                            if ($entered_sets['delivery_type'] != '0') {
                                                                                ?>
                                                                                <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                                                                                    <span style="font-weight: bold;">Send Via :</span>
                                                                                </div>
                                                                                <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                                                                                    <?php
                                                                                    if ($entered_sets['delivery_type'] == '1') {
                                                                                        $delivery_type = 'Next Day Air';
                                                                                    } elseif ($entered_sets['delivery_type'] == '2') {
                                                                                        $delivery_type = 'Two Day Air';
                                                                                    } elseif ($entered_sets['delivery_type'] == '3') {
                                                                                        $delivery_type = 'Three Day Air';
                                                                                    } elseif ($entered_sets['delivery_type'] == '4') {
                                                                                        $delivery_type = 'Ground';
                                                                                    }

                                                                                    $ship_type_1 = ($entered_sets['shipp_comp_1'] == '0') ? '' : $entered_sets['shipp_comp_1'];
                                                                                    $ship_type_2 = ($entered_sets['shipp_comp_2'] == '0') ? '' : $entered_sets['shipp_comp_2'];
                                                                                    $ship_type_3 = ($entered_sets['shipp_comp_3'] == '0') ? '' : $entered_sets['shipp_comp_3'];

                                                                                    echo $ship_type_1 . $ship_type_2 . $ship_type_3 . ',&nbsp;' . $delivery_type . ',&nbsp;Account # ' . $entered_sets['billing_number'];
                                                                                    ?>
                                                                                </div>
                                                                            <?php } else { ?>                            
                                                                                <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                                                                                    <span style="font-weight: bold;">Send Via :</span>
                                                                                </div>
                                                                                <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                                                                                    SOHO TO ARRANGE DELIVERY
                                                                                </div>    
                                                                            <?php } ?> 
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php 
                                                                                $r++;
                                                                                } 
                                                                                ?>                                                                            
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    
                                                                </div>                                                            
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
                            <td><?php echo Paginations($limit, $page, 'open_orders_service.php?page=', $rows); ?></td>
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
               // $('.toggle').hide('slow');
                $(this).next(".test_" + val).fadeToggle('slow');
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
                //       loading(); // loading
//         setTimeout(function(){ // then show popup, deley in .5 second
//            logingAlertPop(); // function show popup 
//            }, 500); // .5 second
                $.ajax
                        ({
                            type: "POST",
                            url: "update_mail_content.php",
                            data: "order_id=" + order_id,
                            beforeSend: loadStart,
                            complete: loadStop,
                            success: function(option)
                            {
                                //var subject_to = option;
//                    var subject_to_body = option.split("~");
//                    var body_content            = encodeURIComponent(subject_to_body[1]);
//                    $("#mail_to_"+order_id).show();
//                    $(".mail_to_"+order_id).attr("href", subject_to_body[0]+'?body='+subject_to_body[1]);
                                document.location.href = option;
                                //$("#update_mail_dynamic").html(option);
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
                    data: "update_email_ord_id=" + order_id + "&short_msg=" + short_msg,
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

</script>