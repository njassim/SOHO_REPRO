<?php
include './config.php';
include './auth.php';

//$sort_pn            = ($_REQUEST['sort'] == 'pna') ? 'pnd' : 'pna';
//$sort_pn_img        = ($_REQUEST['sort'] == 'pna') ? 'down' : 'up';

$sort_sku = ($_REQUEST['sort'] == 'pea') ? 'ped' : 'pea';
$sort_sku_img = ($_REQUEST['sort'] == 'pea') ? 'down' : 'up';

$sort_price = ($_REQUEST['sort'] == 'pda') ? 'pdd' : 'pda';
$sort_price_img = ($_REQUEST['sort'] == 'pda') ? 'down' : 'up';


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

$users = getusers_list_temp($_REQUEST['sort'], $start, $limit);


$filter_by_customer     = $_GET["cus_type_fil"];
$admin_added            = ($_GET["admin_added"] != '') ? $_GET["admin_added"] : '';
$filtered_customer = FilterByCustomer($filter_by_customer, $admin_added, $start, $limit);


//$rows= '4273';
$rows = ($filter_by_customer != '') ? count(FilterByCustomerCount($filter_by_customer)) : count(CustomersCount());

$last_element = $_GET['page'];

if ($_GET['delete_id']) {

    $delete_id = $_GET['delete_id'];
    /* $sql = "UPDATE sohorepro_company
      SET     status = '0',
      archive = '1'
      WHERE comp_id= '" . $delete_id . "' "; */

    $sql_user = "DELETE FROM sohorepro_customers WHERE cus_compname = '" . $delete_id . "'";
    mysql_query($sql_user);

    $sql = "DELETE FROM sohorepro_company WHERE comp_id = " . $delete_id . " ";
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
    $sql = "UPDATE sohorepro_company
			SET    status     = '" . $change_status . "' WHERE comp_id= '" . $status_id . "'";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_status";
    } else {
        $result = "failure_status";
    }
}
?>

<!DOCTYPE html>
<html >
    <head>
        <meta charset="utf-8">
        <title>Soho-repro</title>

    </head>
    <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="style/customer-css.css" rel="stylesheet" type="text/css" media="all" />
    <link href="style/pagination.css" rel="stylesheet" type="text/css" media="all" />
    <style type="text/css">            
        option.select_customer1 { font-weight: bold !important;}
        .subcat {  
            color: #000000;            
        }
        .action_rein{
            background: #009D59;
            color: #FFF;
            padding: 5px 10px;
            text-transform: uppercase;
            border-radius: 7px;
            font-weight: bold;
            cursor: pointer;
        }
        .fav_button{
            background: #00979D;
            color: #FFF;
            padding: 5px 10px;
            text-transform: uppercase;
            border-radius: 7px;
            font-weight: bold;
            cursor: pointer;
        }

        .action_sus{
            background: #D3412C;
            color: #FFF;
            padding: 5px 10px;
            text-transform: uppercase;
            border-radius: 7px;
            font-weight: bold;
            cursor: pointer;
        }
        .pointer{
            cursor: pointer;
        }

        .pulse {
            -webkit-animation: pulse 1s linear infinite;
            -moz-animation: pulse 1s linear infinite;
            -ms-animation: pulse 1s linear infinite;
            animation: pulse 1s linear infinite;
        }

        @keyframes "pulse" {
            0% {
                -webkit-transform: scale(1.0);
                -moz-transform: scale(1.0);
                -o-transform: scale(1.0);
                -ms-transform: scale(1.0);
                transform: scale(1.0);
            }
            50% {
                -webkit-transform: scale(0.8);
                -moz-transform: scale(0.8);
                -o-transform: scale(0.8);
                -ms-transform: scale(0.8);
                transform: scale(0.8);
            }
            100% {
                -webkit-transform: scale(1);
                -moz-transform: scale(1);
                -o-transform: scale(1);
                -ms-transform: scale(1);
                transform: scale(1);
            }

        }

        @-moz-keyframes pulse {
            0% {
                -moz-transform: scale(1.1);
                transform: scale(1.1);
            }
            50% {
                -moz-transform: scale(0.8);
                transform: scale(0.8);
            }
            100% {
                -moz-transform: scale(1);
                transform: scale(1);
            }

        }

        @-webkit-keyframes "pulse" {
            0% {
                -webkit-transform: scale(1.1);
                transform: scale(1.1);
            }
            50% {
                -webkit-transform: scale(0.8);
                transform: scale(0.8);
            }
            100% {
                -webkit-transform: scale(1);
                transform: scale(1);
            }

        }

        @-ms-keyframes "pulse" {
            0% {
                -ms-transform: scale(1.1);
                transform: scale(1.1);
            }
            50% {
                -ms-transform: scale(0.8);
                transform: scale(0.8);
            }
            100% {
                -ms-transform: scale(1);
                transform: scale(1);
            }

        }

    </style>
    <script src="../js/jquery.js" type="text/javascript" ></script>
    <script language="javascript" src="../store_files/script.js"></script> 
    <script type="text/javascript" src="../store_files/scripts.js"></script>
    <script language="javascript" src="js/value.js"></script>
    <script language="javascript" src="js/customer.js"></script>
    <script language="javascript" src="js/phnovalid.js"></script>
    <script>
        jQuery(function($) {
            //var ID = $(".main_id").attr("id");
            $(".comp_phone").mask("999-999-9999");
            $(".comp_fax").mask("999-999-9999");
            $(".adb_phone").mask("999-999-9999");
            $(".comp_zip").mask("99999");
            $(".comp_zip_ext").mask("9999");
            $(".comp_zip_del_ext").mask("9999");
            $(".del_comp_zip ").mask("99999");
        });
    </script>
    <!-- Add fancyBox main JS and CSS files -->
    <script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="js/jquery.fancybox.css?v=2.1.5" media="screen" />



    <script type="text/javascript">
        $(document).ready(function() {
            /**  Simple image gallery. Uses default settings*/
            $('.fancybox').fancybox();

            /**  Different effects */
        });


    </script>
    <!--End -->
    <style>

        #result_ref
        {
            background-color: #f3f3f3;
            border-top: 0 none;
            box-shadow: 0 0 5px #ccc;
            display: none;
            margin-top: 0;
            overflow: hidden;
            padding: 10px;
            position: absolute;
            right: 650px;
            text-align: left;
            top: 186px;
            width: 280px;
            height: 200px;
            overflow-y: auto;
        }

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

    </style>
    <body>
        <div id="loading" class="none"  style="position: fixed;top: 35%;left: 48%;padding: 5px;z-index: 10;">
            <img src="images/login_loader.gif" border="0" />
        </div>
        <?php
        if ($_GET['cus_id'] != '') {
            $customer_acc_id = $_GET['cus_id'];
            ?>
            <input type="hidden" name="cus_acc_id" id="cus_acc_id" value="<?php echo $customer_acc_id; ?>" />
            <script type="text/javascript">

                $(document).ready(function()
                {
                    var val = document.getElementById('cus_acc_id').value;
                    $(".trigger").next(".test_" + val).fadeToggle('slow').siblings(".test_" + val).hide();
                    // $("#msg").html('Deletet Successfully');
                    $("#msg").fadeOut(2500);
                    // $("#new_supercategory").submit();
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
                            <td width="759" align="left" valign="top" bgcolor="#FFFFFF">
                                <table width="759" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="48" align="center" valign="middle" bgcolor="#5f5f5f" class="heading">
                                            ADMINISTRATOR PAGE
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="38" align="center" valign="middle" bgcolor="#8b8b8b" class="sub_heading">
                                            CUSTOMERS
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
                                        <td height="14" align="left" valign="middle"></td>
                                    </tr> 
                                    <tr>
                                        <td align="right" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="38" align="left" valign="middle" class="add_title">Search</td>
                                                </tr>
                                                <tr>
                                                    <td height="60" align="left" valign="top" bgcolor="#f6f6f6" class="form_bg">
                                                        <?php
                                                        $search_values = ($_GET['cus_id'] != '') ? getCompName($_GET['cus_id']) : $_REQUEST['search_val'];
                                                        ?>
                                                        <form name="new_supercategory" id="new_supercategory" method="post" action=""  onsubmit="return load_userinfo()" >
                                                            <input type="hidden" name="search_cus" value="1" />
                                                            <input type="hidden" name="new_cat" value="1" />       
                                                            <table  border="0" cellspacing="0" cellpadding="0" >
                                                                <tr style="float:left;">
                                                                    <td width="160" height="60" align="right" valign="middle">
                                                                        <input class="input_text" type="text" name="search_val" id="search_val" autocomplete="off" onkeyup="return autosuggession();" type="text" value="<?php echo $search_values; ?>" placeholder="Company Name/Email ID" style="width:300px !important; margin-left: 25px;" >
                                                                        <div id="result_ref">
                                                                        </div>
                                                                    </td>
                                                                    <td width="210" height="60" align="center" valign="middle" style="padding-left: 10px;">
                                                                        <input type="submit" name="search" class="search_cus" id="search_cus" value="Search" />
                                                                        <?php if (($_REQUEST['search_cus'] != '') || ($_GET['cus_type_fil'] != '')) { ?>
                                                                            <span class="search_cus" style="margin-left: 20px;" onclick="return reset_filter();">Reset</span>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td style="font-size: 14px;padding-right: 10px;">
                                                                        Filter By :
                                                                    </td>
                                                                    <td>
                                                                        <select style="webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;padding: 5px;" name="filter_by_type" id="filter_by_type" onchange="return filter_by_type_change();" >
                                                                            <option value="0">Select Type</option>
                                                                            <option value="type_0" <?php if($_GET['cus_type_fil'] == '0'){ ?> selected="selected" <?php } ?>>Customers</option>
                                                                            <option value="type_1" <?php if($_GET['cus_type_fil'] == '1'){ ?> selected="selected" <?php } ?>>Cash</option>
                                                                            <!--<option value="type_2" <?php if($_GET['cus_type_fil'] == '2'){ ?> selected="selected" <?php } ?>>Admin Added</option>-->
                                                                        </select>
                                                                    </td>
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
                                                                            <script>setTimeout("location.href=\'customers.php?page=<?php echo $last_element; ?>\'", 1000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_del") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Not Deleted</div>
                                                                            <script>setTimeout("location.href=\'customers.php?page=<?php echo $last_element; ?>\'", 1000);</script>       
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
                                        <td>
                                            <table>
                                                <tr>
                                                    <td style="width: 44%;">
                                                        <!--<input type="button" name="add_new_customer" title="Add New Customer" alt="Add New Customer" class="search_cus" value="Add New" onclick="return add_new_customer();" />-->
                                                        <a href="add_new_customer.php" style="float: left;"><img src="images/add_new_customer.png" style="cursor:pointer;" alt="Add New Customer" title="Add New Customer"/></a>
                                                    </td>
                                                    <td height="45" align="right" valign="middle" style="padding: 5px;">
                                                        <a href="import_customers.php" style="float: right;"><img src="images/btn_import_customer.png" style="cursor:pointer;" alt="Import Customers" title="Import Customers"/></a><span style="width: 215px;float: right;margin-right: 10px;font-size: 12px;text-align: left;">Please use this Excel file as a template or else your import may not work <a href="excel_template/customer_template.xls">Download Template</a></span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td align="right" valign="top">                                            


                                            <div id="load_userdata">
                                                <?php
                                                //Search Results
                                                if ($_REQUEST['search_cus'] != '') {
                                                    $search_val = $_REQUEST['search_val'];
                                                    $users_search_pre = getusers_list_search_user($_REQUEST['sort'], $start, $limit, $search_val);
                                                    if (count($users_search_pre) > 0) {
                                                        $users_search = getusers_list_search_user($_REQUEST['sort'], $start, $limit, $search_val);
                                                    } else {
                                                        $search_val_com_id = getCompId($_REQUEST['search_val']);
                                                        if (count($search_val_com_id) > 0) {
                                                            foreach ($search_val_com_id as $comp_val) {
                                                                $search_by_comp = getCompNameStatus($comp_val['cus_compname']);
                                                            }
                                                        }
                                                        if (count($search_by_comp) > 0) {
                                                            $search_by_usr_comp = trim($search_by_comp);
                                                            //$search_by_comp = getCompName($search_val_com_id);
                                                            $users_search = getusers_list_search_user_cus($_REQUEST['sort'], $start, $limit, $search_by_usr_comp);
                                                        }
                                                    }
                                                    ?>
                                                    <table width="759" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="36" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">NO.</td>                                                        
                                                            <td width="100" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="customers.php?sort=<?php echo $sort_sku; ?>">Company Name&nbsp;<img src="images/<?php echo $sort_sku_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>                                                                                                                
                                                            <?php if ($_SESSION['admin_user_type'] == '1') { ?>
                                                                <td width="64" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                            <?php } ?>
                                                        </tr>                                                
                                                        <?php
                                                        $i = 1;
                                                        if (count($users_search) > 0) {
                                                            if ($last_element != '') {
                                                                $i = ((($last_element * 25) - 25) + 1);
                                                            } else {
                                                                $i = 1;
                                                            }
                                                            foreach ($users_search as $Prod) {
                                                                $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                                $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                                $id = $Prod['cus_id'];
                                                                $cumpony_id = $Prod['comp_id'];
                                                                $cus_email = $Prod['cus_email'];
                                                                $cus_regdate = date("m-d-Y", strtotime($Prod['cus_regdate']));
                                                                $company_name = $Prod['comp_name'];
                                                                $cust_id = ($Prod['cust_id'] != '') ? $Prod['cust_id'] : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                                                $user_address1 = $Prod['comp_business_address1'];
                                                                $user_address2 = $Prod['comp_business_address2'];
                                                                $user_address3 = $Prod['comp_business_address3'];
                                                                $user_suit     = ($Prod['comp_room'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $Prod['comp_room'];
                                                                $company_phone = $Prod['comp_contact_phone'];
                                                                $company_fax = $Prod['comp_contact_fax'];
                                                                $company_city = $Prod['comp_city'];
                                                                $state_abbr = ($Prod['comp_state'] != '') ? $Prod['comp_state'] : '---';
                                                                $company_zip = $Prod['comp_zipcode'];
                                                                $company_zip_ext = $Prod['comp_zipcode_ext'];
                                                                $tax_excempt_number = $Prod['tax_exempt_number'];
                                                                $tax = ($Prod['tax_exe'] == 1) ? 'Yes' : 'No';
                                                                $status = ($Prod['status'] == 1) ? 'active' : 'de-active';
                                                                $deleivery_address = ShippingAddressAllInfo($cumpony_id);
                                                                $deleivery_state = ($deleivery_address[0]['state'] != '') ? $deleivery_address[0]['state'] : '---';
                                                                if (($_SESSION['admin_user_type'] == '2') && ($Prod['status'] == 1)) {
                                                                    $staff_prev = '';
                                                                } else {
                                                                    $staff_prev = 'status';
                                                                }
                                                                ?>                                                
                                                                <tr class="trigger" id="<?php echo $Prod['comp_id']; ?>">
                                                                    <td width="49"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>                                                                
                                                                    <td width="100" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="pad_btm"><span class="company_name_<?php echo $cumpony_id; ?>"><?php echo $company_name; ?></span></td>                                                                
                                                                    <?php if ($_SESSION['admin_user_type'] == '1') { ?>
                                                                        <td width="80"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm">
                                                                            <a href="#edit_user.php?id=<?php echo $id; ?>"><img src="images/edit.png"  alt="Edit" title="Edit" width="22" height="22"/></a>
                                                                            <a href="customers.php?delete_id=<?php echo $cumpony_id; ?>" onclick="return confirm('Are you sure?');"><img src="images/del.png"  alt="Delete" title="Delete" width="22" height="22" class="mar_lft"/></a></td>
                                                                    <?php } ?>
                                                                </tr>
                                                                <tr class="test_<?php echo $Prod['comp_id']; ?>" style="display: none;">
                                                                    <td colspan="<?php echo ($_SESSION['admin_user_type'] == '1') ? '3' : '2'; ?>">
                                                                        <table width="100%" border="0">
                                                                            <tr>
                                                                                <td colspan="3" align="center">
                                                                                    <span id="succ_resend_<?php echo $cumpony_id; ?>" style="color:#007F2A;"></span> 
                                                                                    <span id="fail_alert_<?php echo $cumpony_id; ?>" style="color:#F00;"></span> 
                                                                                </td>
                                                                            </tr>

                                                                            <tr valign="top">
                                                                                <td width="33%" style="height: 30px;text-align: left;padding-left: 2px;">
                                                                                    <span style="font-weight: bold;float:left;">Cust. ID :&nbsp;&nbsp;</span>
                                                                                    <span style="cursor: pointer;" class="cust_inline cust_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $cust_id; ?></span>
                                                                                    <span style="float:left;" class="none cust_comp_lbl_<?php echo $cumpony_id; ?>"></span><input style="float:left;width: 110px;" type="text" class="none cust_inline_txt_<?php echo $cumpony_id; ?>" id="cust_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $cust_id; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="cust_update cust_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="cust_cancel cust_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>   
                                                                                </td>
                                                                                <td width="33%" style="text-align: left;">
                                                                                    <span style="font-weight: bold;float:left;">Company :&nbsp;&nbsp;</span>
                                                                                    <span style="cursor: pointer;" class="bus_inline bus_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_name; ?></span>
                                                                                    <span style="float:left;" class="none bus_comp_lbl_<?php echo $cumpony_id; ?>"></span><input style="float:left;width: 110px;" type="text" class="none bus_inline_txt_<?php echo $cumpony_id; ?>" id="bus_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_name; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="cn_update cn_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="cn_cancel cn_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                    
                                                                                </td>
                                                                                <?php
                                                                                if($Prod['cus_type'] == '0'){
                                                                                $cus_type = 'Customers';
                                                                                }elseif ($Prod['cus_type'] == '1') {
                                                                                $cus_type = 'Cash Customer';
                                                                                }elseif($Prod['cus_type'] == '2'){
                                                                                $cus_type = 'Customers';   
                                                                                }
                                                                                ?>
                                                                                <td width="34%"><span style="font-weight: bold;">Cust. Type :</span> <?php echo $cus_type; ?></td>
                                                                            </tr>

                                                                            <tr align="left" style="text-align: left;">
                                                                                <td width="33%" class="inf" style="font-weight: bold;padding-left: 2px;">Business Info</td>
                                                                                <td width="33%" class="inf" style="font-weight: bold;padding-left: 2px;">Delivery Info</td>
                                                                                <td width="34%" class="inf" style="font-weight: bold;padding-left: 2px;">User Info</td>
                                                                            </tr>
                                                                            <tr valign="top">                                                                         
                                                                                <!--Business Table Start-->
                                                                                <td align="left" width="250" style="text-align: left;">
                                                                                    <table border="0" width="325">
                                                                                        <tr>                                                                                       
                                                                                            <td>
                                                                                                <strong style="float:left;">A1 :&nbsp;</strong><span style="cursor: pointer;" class="bus_add1_inline bus_add1_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_address1; ?></span>
                                                                                                <span style="float:left;" class="none bus_add1_lbl_<?php echo $cumpony_id; ?>"></span><input style="float:left;width: 150px;" type="text" class="none bus_add1_inline_txt_<?php echo $cumpony_id; ?>" id="bus_add1_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_address1; ?>" />
                                                                                                <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad1_update ad1_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                                <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad1_cancel ad1_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <?php
                                                                                        $user_address2_ori = ($user_address2 == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $user_address2;
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td align="left">
                                                                                                <strong style="float:left;">A2 :&nbsp;</strong><span style="cursor: pointer;" class="bus_add2_inline bus_add2_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_address2_ori; ?></span>
                                                                                                <span style="float:left;" class="none bus_add2_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none bus_add2_inline_txt_<?php echo $cumpony_id; ?>" id="bus_add2_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_address2_ori; ?>" />
                                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad2_update ad2_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad2_cancel ad2_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                            </td>
                                                                                        </tr>
                                                                                        <?php
                                                                                        $user_address3_ori = ($user_address3 == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $user_address3;
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td align="left">
                                                                                                <strong style="float:left;">A3 :&nbsp;</strong><span style="cursor: pointer;" class="bus_add3_inline bus_add3_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_suit; ?></span>
                                                                                                <span style="float:left;" class="none bus_add3_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none bus_add3_inline_txt_<?php echo $cumpony_id; ?>" id="bus_add3_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_suit; ?>" />
                                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad3_update ad3_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad3_cancel ad3_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!--<tr>
                                                                                            <td align="left">
                                                                                                <strong style="float:left;">S# :&nbsp;</strong><span style="cursor: pointer;" class="bus_suit_inline bus_suit_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_suit; ?></span>
                                                                                                <span style="float:left;" class="none bus_suit_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none bus_suit_inline_txt_<?php echo $cumpony_id; ?>" id="bus_suit_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_suit; ?>" />
                                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="suit_update suit_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="suit_cancel suit_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                            </td>
                                                                                        </tr>-->
                                                                                        <tr>                                                                                        
                                                                                            <td align="left" width="500">
                                                                                                <table>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <table>
                                                                                                                <tr>
                                                                                                                    <td>
                                                                                                                        <span style="cursor: pointer;" class="bus_city_inline bus_city_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_city; ?>,&nbsp;</span>
                                                                                                                        <input style="float:left; width: 60px;" type="text" class="none bus_city_inline_txt_<?php echo $cumpony_id; ?>" id="bus_city_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_city; ?>" />
                                                                                                                        <span style="float:left; margin:0 0px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="city_update city_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                        <span style="float:left;  margin:0 0px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="city_cancel city_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <span style="cursor: pointer;margin-left: -2px;" class="bus_stat_inline bus_stat_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $state_abbr; ?></span>&nbsp;
                                                                                                                        <select name="state" id="<?php echo $cumpony_id; ?>" class="none bus_state bus_stat_inline_txt_<?php echo $cumpony_id; ?>" >                    
                                                                                                                            <?php
                                                                                                                            $state = StateAll();
                                                                                                                            if ($state_abbr == "---") {
                                                                                                                                ?>
                                                                                                                                <option value="<?php echo $state_abbr; ?>" selected="selected"><?php echo $state_abbr; ?></option>
                                                                                                                            <?php
                                                                                                                            }
                                                                                                                            foreach ($state as $state_val) {
                                                                                                                                if ($state_val['state_abbr'] == $state_abbr) {
                                                                                                                                    ?>
                                                                                                                                    <option value="<?php echo $state_val['state_abbr'] ?>" selected="selected"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                                                <?php } else { ?>
                                                                                                                                    <option value="<?php echo $state_val['state_abbr']; ?>"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                                                    <?php
                                                                                                                                }
                                                                                                                            }
                                                                                                                            ?>
                                                                                                                        </select>
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <span>
                                                                                                                            <span style="cursor: pointer;margin-left: -5px;" class="bus_zip_inline bus_zip_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_zip; ?></span>
                                                                                                                            <input style="width: 40px;" type="text" class="none comp_zip bus_zip_inline_txt_<?php echo $cumpony_id; ?>" id="bus_zip_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_zip; ?>" />
                                                                                                                            <span style="float:right; margin:0 0px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_cancel zip_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                            <span style="float:right;"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="zip_update zip_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                        </span>
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <?php
                                                                                                                        $company_zip_ext_ori = ($company_zip_ext == '0') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : '-' .$company_zip_ext;
                                                                                                                        ?>
                                                                                                                        <span>
                                                                                                                            <span style="cursor: pointer;margin-left: 0px;" class="bus_zip_inline_ext bus_zip_inline_span_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_zip_ext_ori; ?></span>
                                                                                                                            <input style="width: 40px;" type="text" class="none comp_zip_ext bus_zip_inline_txt_ext_<?php echo $cumpony_id; ?>" id="bus_zip_inline_txt_ext_<?php echo $cumpony_id; ?>" value="<?php echo $company_zip_ext_ori; ?>" />
                                                                                                                            <span style="float:right; margin:0 0px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_cancel_ext zip_cancel_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                            <span style="float:right;"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="zip_update_ext zip_update_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                        </span>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table> 
                                                                                            </td>
                                                                                        </tr>                                                                                     
                                                                                        <tr>                                                                                        
                                                                                            <td>
                                                                                                <span style="float:left;"><strong>P : </strong></span>
                                                                                                <span style="cursor: pointer;" class="bus_phone_inline bus_phone_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_phone; ?></span>
                                                                                                <input style="width: 80px;" type="text" class="none comp_phone bus_phone_inline_txt_<?php echo $cumpony_id; ?>" id="bus_phone_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_phone; ?>" />
                                                                                                <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="phone_update phone_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                                <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="phone_cancel phone_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                            </td>
                                                                                        </tr> 
                                                                                        <tr>                                                                                        
                                                                                            <td>                                                                                           
                                                                                                <span style="float:left;"><strong>F : </strong></span>                                                                                            
                                                                                                <span style="cursor: pointer;" class="bus_fax_inline bus_fax_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_fax; ?></span>
                                                                                                <input style="width: 80px;" type="text" class="none comp_fax bus_fax_inline_txt_<?php echo $cumpony_id; ?>" id="bus_fax_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_fax; ?>" />
                                                                                                <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="fax_update fax_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                                <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="fax_cancel fax_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                            </td>
                                                                                        </tr> 
                                                                                        <tr>
                                                                                            <td class="inf">Tax Exemption&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                                                                            
                                                                                                <span style="cursor: pointer;" class="bus_tax_inline bus_tax_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $tax; ?></span>
                                                                                                <select name="tax" id="<?php echo $cumpony_id; ?>" class="none bus_tax bus_tax_inline_txt_<?php echo $cumpony_id; ?>" >                                                                                                                   
                                                                                                    <option value="1" <?php if ($tax == 'Yes') { ?> selected="selected" <?php } ?>>Yes</option>                                                                                                    
                                                                                                    <option value="0" <?php if ($tax == 'No') { ?> selected="selected" <?php } ?>>No</option>                                                                                                    
                                                                                                </select>

                                                                                            </td>                                                                                            
                                                                                        </tr>
                                                                                        <?php if ($Prod['tax_exe'] == '1') { ?>                                                                                        
                                                                                            <tr class="tax_exempt_number_row_view_<?php echo $cumpony_id; ?>">
                                                                                                <td>Tax ID : &nbsp;
                                                                                                    <span class="tax_exempt_number_span_<?php echo $cumpony_id ?>"><?php echo $tax_excempt_number; ?></span>                                                                                                
                                                                                                </td>                                                                                             
                                                                                            </tr> 
                                                                                        <?php } ?>
                                                                                        <tr class="none tax_exempt_number_row_<?php echo $cumpony_id; ?>">
                                                                                            <td>
                                                                                                <span style="float: left;">Tax ID : &nbsp;</span>
                                                                                                <span class="tax_exempt_number_span_<?php echo $cumpony_id ?>"><?php //echo $tax_excempt_number;     ?></span>
                                                                                                <input type="text" name="tax_exempt_number" class="tax_exempt_number_<?php echo $cumpony_id; ?>" id="tax_exempt_number_<?php echo $cumpony_id; ?>" style="float: left;width: 90px;" autofocus="autofocus" value="<?php echo $tax_form_excempt; ?>" />
                                                                                                <div style="float:left; margin:0 4px">
                                                                                                    <img src="images/like_icon.png" style="margin-top:-3px;" alt="Update" title="Update" width="22" height="22" class="tax_exempt_update tax_exempt_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" />
                                                                                                </div>
                                                                                            </td>                                                                                             
                                                                                        </tr>                                                                                    
                                                                                    </table>
                                                                                </td>
                                                                                <!--Business Table End-->
                                                                                <!--Delivery Address Start-->
                                                                                <td width="250" style="text-align: left;">
                                                                                    <table border="0" width="300"> 
                                                                                        <tr>                                                                                       
                                                                                            <td>
                                                                                                <?php
                                                                                                $del_add_1 = ($deleivery_address[0]['address_1'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['address_1'];
                                                                                                ?>
                                                                                                <span style="float:left;"><strong>A1 :&nbsp;</strong></span><span style="cursor: pointer;" class="del_add1_inline del_add1_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_add_1; ?></span>                                                                                                                                                                        
                                                                                                <input style="float:left;width:140px;" type="text" class="none del_add1_inline_txt_<?php echo $cumpony_id; ?>" id="del_add1_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $del_add_1; ?>" />
                                                                                                <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad1_del_update ad1_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                                <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad1_del_cancel ad1_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                            </td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td align="left">
                                                                                                <?php
                                                                                                $del_add_2 = ($deleivery_address[0]['address_2'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['address_2'];
                                                                                                ?>
                                                                                                <span style="float:left;"><strong>A2 :&nbsp;</strong></span><span style="cursor: pointer;" class="del_add2_inline del_add2_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_add_2; ?></span>   
                                                                                                <input style="float:left; width: 140px;" type="text" class="none del_add2_inline_txt_<?php echo $cumpony_id; ?>" id="del_add2_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $del_add_2; ?>" />
                                                                                                <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad2_del_update ad2_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                                <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad2_del_cancel ad2_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                            </td>
                                                                                        </tr>
                                                                                        <?php
                                                                                        $suite_del = ($deleivery_address[0]['suite'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['suite'];
                                                                                        ?>
                                                                                        <tr>                                                                                       
                                                                                            <td>
                                                                                                <span style="float:left;"><strong>A3 :&nbsp;</strong></span><span style="cursor: pointer;" class="del_add3_inline del_add3_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $suite_del; ?></span>                                                                                                                                                                        
                                                                                                <input style="float:left;width: 140px;" type="text" class="none del_add3_inline_txt_<?php echo $cumpony_id; ?>" id="del_add3_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $suite_del; ?>" />
                                                                                                <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad3_del_update ad3_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                                <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad3_del_cancel ad3_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <?php
                                                                                        //$suite_del = ($deleivery_address[0]['suite'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['suite'];
                                                                                        ?>
                                                                                        <!--<tr>
                                                                                            <td align="left">
                                                                                                <strong style="float:left;">S# :&nbsp;</strong><span style="cursor: pointer;" class="del_suit_inline del_suit_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $suite_del; ?></span>
                                                                                                <span style="float:left;" class="none del_suit_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none del_suit_inline_txt_<?php echo $cumpony_id; ?>" id="del_suit_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $suite_del; ?>" />
                                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="suit_update_del suit_update_del_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="suit_cancel_del suit_cancel_del_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                            </td>
                                                                                        </tr>-->
                                                                                        <tr>                                                                                        
                                                                                            <td align="left" width="500">
                                                                                                <table align="left">
                                                                                                    <tr align="left">
                                                                                                        <td align="left">
                                                                                                            <table border="0">
                                                                                                                <tr>
                                                                                                                    <td>
                                                                                                                        <span style="cursor: pointer;" class="del_city_inline del_city_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_city =  ($deleivery_address[0]['city'] != '') ? $deleivery_address[0]['city'] : 'CITY'; ?></span>,
                                                                                                                        <input style="float:left; width: 60px;" type="text" class="none del_city_inline_txt_<?php echo $cumpony_id; ?>" id="del_city_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $deleivery_address[0]['city']; ?>" />
                                                                                                                        <span style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="city_del_update city_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                        <span style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="city_del_cancel city_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <span style="cursor: pointer;margin-left: -17px;" class="del_stat_inline del_stat_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_state = ($deleivery_address[0]['state'] != '') ? StateName($deleivery_address[0]['state']) : '---'; ?></span>&nbsp;
                                                                                                                        <select name="state" id="<?php echo $cumpony_id; ?>" class="none del_state del_stat_inline_txt_<?php echo $cumpony_id; ?>" >                    
                                                                                                                            <?php
                                                                                                                            $state = StateAll();
                                                                                                                if ($deleivery_state == "---") {
                                                                                                                    ?>
                                                                                                                    <option value="<?php echo $deleivery_address[0]['state']; ?>" selected="selected"><?php echo $deleivery_address[0]['state']; ?></option>
                                                                                                                <?php
                                                                                                                }
                                                                                                                            foreach ($state as $state_val) {
                                                                                                                                if ($state_val['state_abbr'] == $state_abbr) {
                                                                                                                                    ?>
                                                                                                                                    <option value="<?php echo $state_val['state_abbr'] ?>" selected="selected"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                                                <?php } else { ?>
                                                                                                                                    <option value="<?php echo $state_val['state_abbr']; ?>"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                                                    <?php
                                                                                                                                }
                                                                                                                            }
                                                                                                                            ?>
                                                                                                                        </select>
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <span style="cursor: pointer;margin-left: -5px;" class="del_zip_inline del_zip_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_zip = ($deleivery_address[0]['zip'] != '') ? '&nbsp;'.$deleivery_address[0]['zip'] : '&nbsp;&nbsp;ZIP'; ?></span>
                                                                                                                        <input style="width: 40px;" type="text" class="none del_comp_zip del_zip_inline_txt_<?php echo $cumpony_id; ?>" id="del_zip_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $deleivery_address[0]['zip']; ?>" />
                                                                                                                        <span style="float:right; margin:0 0px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_del_cancel zip_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                        <span style="float:right;  margin: 0 0px 0 0px;"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="zip_del_update zip_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <?php
                                                                                                                        $devilery_zip_ext = ($deleivery_address[0]['zip_ext'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : '-'.$deleivery_address[0]['zip_ext'];
                                                                                                                        ?>
                                                                                                                        <span>
                                                                                                                            <span style="cursor: pointer;margin-left: 0px;" class="zip_inline_del_ext zip_inline_span_del_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $devilery_zip_ext; ?></span>
                                                                                                                            <input style="width: 40px;" type="text" class="none comp_zip_del_ext zip_inline_txt_del_ext_<?php echo $cumpony_id; ?>" id="zip_inline_txt_del_ext_<?php echo $cumpony_id; ?>" value="<?php echo $devilery_zip_ext; ?>" />
                                                                                                                            <span style="float:right; margin:0 0px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_cancel_del_ext zip_cancel_del_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                            <span style="float:right;"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="zip_update_del_ext zip_update_del_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                        </span>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                            <?php //echo $deleivery_address[0]['city'].','.StateName($deleivery_address[0]['state']).'&nbsp;'.$deleivery_address[0]['zip'];    ?>                                                                                                
                                                                                                        </td> 
                                                                                                    </tr>
                                                                                                </table> 
                                                                                            </td>
                                                                                        </tr>                                                                                     
                                                                                        <tr>                                                                                        
                                                                                            <td>
                                                                                                <?php $del_phone = ($deleivery_address[0]['phone'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['phone']; ?>
                                                                                                <span class="del_phone_head_inline_span_<?php echo $cumpony_id; ?>"><strong>P : </strong></span>
                                                                                                <span style="cursor: pointer;" class="del_phone_inline del_phone_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_phone; ?></span>
                                                                                                <input style="width: 80px;" type="text" class="none comp_phone del_phone_inline_txt_<?php echo $cumpony_id; ?>" id="del_phone_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $deleivery_address[0]['phone']; ?>" />
                                                                                                <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="phone_del_update phone_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                                <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="phone_del_cancel phone_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                            </td>
                                                                                        </tr> 
                        <!--                                                                            <tr>                                                                                        
                                                                                            <td>                                                                                           
                                                                                                <span class="<?php echo $cumpony_id; ?>"><strong>F : </strong></span>                                                                                            
                                                                                                <span style="cursor: pointer;" class="bus_fax_inline_span_del_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_fax; ?></span>                                                                                    
                                                                                            </td>
                                                                                        </tr>-->
                                                                                        <tr>                                                                                        
                                                                                            <td>&nbsp;</td>
                                                                                        </tr>

                                                                                    </table>
                                                                                </td>
                                                                                <!--Delivery Address End -->                                                                    
                                                                                <?php $customer_per_company = custPerComp($cumpony_id); ?>
                                                                                <!--Personal Table Start-->
                                                                                <td align="left" style="text-align: left;">
                                                                                    <table border="0" width="265">
                                                                                        <tr>
                                                                                            <td class="inf">Select User</td>
                                                                                            <td align="left" style="padding-right: 60px;">
                                                                                                <span class="cus_id none" id="<?php echo $customer_per_company[0]['cus_id']; ?>"></span> 
                                                                                                <div id="user_select_box_<?php echo $cumpony_id; ?>_<?php echo $customer_per_company[0]['cus_id']; ?>">
                                                                                                    <select  name="customer_name" id="<?php echo $cumpony_id; ?>" class="customer_name_<?php echo $cumpony_id; ?> select_customer">
                                                                                                        <option value="0">--Customers--</option>                                                                                                
                                                                                                        <?php
                                                                                                        foreach ($customer_per_company as $customers) {
                                                                                                            $bold = ($customers['cus_manager'] == '1') ? 'select_customer1' : '';
                                                                                                            ?>
                                                                                                            <option value="<?php echo $customers['cus_id']; ?>" class="<?php echo $bold; ?>"><?php echo $customers['cus_contact_name']; ?></option>                                                                                                 <?php } ?>                                                                                               
                                                                                                    </select>                                                                                            
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2" height="70">
                                                                                                <!--                                                                                            <div id="jassim"></div>-->
                                                                                                <div id="msg_<?php echo $cumpony_id; ?>" class="cus_adm_succ_j"></div>
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
                                                                            <tr>
                                                                                <?php 
                                                                    if($Prod['invoice_type'] == '7'){
                                                                    $invoice_type_set = "Weekly";
                                                                    }elseif ($Prod['invoice_type'] == '14') {
                                                                    $invoice_type_set = "Semi-Monthly";
                                                                    }elseif($Prod['invoice_type'] == '30'){
                                                                    $invoice_type_set = "Monthly";
                                                                    }elseif ($Prod['invoice_type'] == '0') {
                                                                    $invoice_type_set = "Select Type";
                                                                    }
                                                                    ?>
                                                                    <td align="left" width="30%" class="inf">
                                                                        <div style="width: 100%;float: left;margin-bottom: 3px;"> 
                                                                            <ul>
                                                                                <li>
                                                                                    <label style="font-weight: bold;">Invoice Frequency :</label>
                                                                                    <span style="cursor: pointer;" id="inv_type_<?php echo $cumpony_id; ?>" onclick="return select_inv_type('<?php echo $cumpony_id; ?>');"><?php echo $invoice_type_set; ?></span>
                                                                                    <select name="invoice_freq" class="invoice_freq_type none" id="invoice_freq_<?php echo $cumpony_id; ?>" onchange="return set_invoice_type('<?php echo $cumpony_id; ?>');">                                                                                        
                                                                                        <option value="0"  <?php if($Prod['invoice_type'] == '0'){ ?>selected="selected"<?php } ?>>Select Type</option>
                                                                                        <option value="7"  <?php if($Prod['invoice_type'] == '7'){ ?>selected="selected"<?php } ?>>Weekly</option>
                                                                                        <option value="14" <?php if($Prod['invoice_type'] == '14'){ ?>selected="selected"<?php } ?>>Semi-Weekly</option>
                                                                                        <option value="30" <?php if($Prod['invoice_type'] == '30'){ ?>selected="selected"<?php } ?>>Monthly</option>
                                                                                    </select>
                                                                                </li>
                                                                            </ul>
                                                                        </div>                                                                        
                                                                    </td>

                                                                                <td width="40%" class="inf">
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <select  name="address_book" id="<?php echo $cumpony_id; ?>" class="address_book_<?php echo $cumpony_id; ?> select_address">
                                                                                                    <option value="0">Address Book</option>
                                                                                                    <?php
                                                                                                    $address_book = AddressBookCompany($cumpony_id);
                                                                                                    foreach ($address_book as $address) {
                                                                                                        ?>                                                                                        
                                                                                                        <option value="<?php echo $address['id']; ?>"><?php echo $address['company_name']; ?></option>
                                                                                                        <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="padding-top: 5px;">
                                                                                                <div id="addressbook_info_<?php echo $cumpony_id; ?>">

                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>                                                                                
                                                                                </td>
                                                                                <td width="30%" class="inf" style="font-weight: bold;padding-left: 2px;">&nbsp;</td>
                                                                            </tr>



                                                                            <?php
                                                                            $status_class = ($Prod['status'] == '1') ? 'action_sus' : 'action_rein';
                                                                            $status_text = ($Prod['status'] == '1') ? 'SUSPEND' : 'REINSTATE';
                                                                            ?>
                                                                            <tr>
                                                                                <td colspan="3">
                                                                                    <span class="<?php echo $status_class; ?>" id="action_<?php echo $cumpony_id; ?>" onclick="return sus_reiv('<?php echo $cumpony_id; ?>');"><?php echo $status_text; ?></span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="3">
                                                                                    <div style="float:left;width:50%;font-weight: bold;">Customer Notes: </div>
                                                                                        <div style="float:left;width:50%;border:2px solid #F99B3E;height: 110px;">
                                                                                            <div id="cus_notes_<?php echo $cumpony_id; ?>" onclick="return edit_cus_notes('<?php echo $cumpony_id; ?>');" style="float:left;width:98%;margin-left: 3px;height: 75px;cursor: pointer;">
                                                                                                <?php echo $Prod['customer_notes']; ?>
                                                                                            </div>
                                                                                            <form name="myform">
                                                                                                <div id="cus_notes_edit_<?php echo $cumpony_id; ?>" style="float:left;width:98%;margin-left: 3px;margin-top: 5px;display: none;">
                                                                                                    <textarea class="cus_notes_edit_txt_<?php echo $cumpony_id; ?>" id="cust_notes" style="width:98%;height: 75px;margin-left: 3px;" onKeyDown="limitText(this.form.cust_notes,this.form.countdown,256);" onKeyUp="limitText(this.form.cust_notes,this.form.countdown,256);"><?php echo $Prod['customer_notes']; ?></textarea>                                                                                
                                                                                                    <div style="float:left;width:98%;margin-left: 3px;margin-bottom: 5px;margin-top: 3px;">
                                                                                                        <div style="float:left;width: 49%;text-align: left;">
                                                                                                           <input readonly type="text" name="countdown" size="5" id="countdown" value="256" style="width: 35px;border:1px solid #000;" />
                                                                                                        </div>
                                                                                                        <div style="float:left;width: 49%;text-align: right;">
                                                                                                            <span id="cus_notes_edit_can_<?php echo $cumpony_id; ?>"  onclick="return cancel_cust_notes('<?php echo $cumpony_id; ?>');" style="background: #D3412C;color: #FFF;padding: 2px 5px;text-transform: uppercase;border-radius: 5px;font-weight: bold;font-size: 11px;cursor: pointer;">CANCEL</span>
                                                                                                            <span id="cus_notes_edit_save_<?php echo $cumpony_id; ?>" onclick="return save_cust_notes('<?php echo $cumpony_id; ?>');" style="background: #009D59;color: #FFF;padding: 2px 5px;text-transform: uppercase;border-radius: 5px;font-weight: bold;font-size: 11px;cursor: pointer;">SAVE</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <span class="succ" id="succ" style="color:#007F2A;font-size: 12px;"  ></span>
                                                                        <div id="mas_<?php echo $cumpony_id; ?>">
                                                                            <div id="spl_<?php echo $cumpony_id; ?>">
                                                                                <table id="spl" width="755" align="center" cellspacing="0" cellpadding="0" style="margin:10px 0px; border: 2px solid #F99B3E; font-family:arial">
                                                                                    <tr>
                                                                                        <td bgcolor="#f1f1f1" height="38" align="left" valign="middle">
                                                                                            <span style="padding-left:12px; font-weight: normal; font-size: 16px; color:#f68210;">Specific Pricing</span>
                                                                                            <a href="print_special_proce.php?comp_id=<?php echo $cumpony_id; ?>" target="_blank" class="action_rein" style="float:right;text-decoration: none;margin-right: 15px;">PRINT</a>
                                                                                        </td>
                                                                                    </tr>                                                                  
                                                                                    <tr>
                                                                                        <td height="30" align="left" valign="middle" class="content_1">

                                                                                            <!---Special Pricing Start --->   
                        <!--                                                                                            <span class="acc-spl click_close_special_<?php //echo $cumpony_id;      ?>" id="<?php //echo $cumpony_id;      ?>" style="cursor: pointer;">Click Here to load the Special Price List..</span>
                                                                                            <div id="spl_price_list_<?php //echo $cumpony_id;      ?>">
                                                                                            
                                                                                            </div>                                                                                                                                                                         -->
                                                                                            <!---Special Pricing End --->     
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

                                                                                        </td>                                                                             
                                                                                    </tr> 
                                                                                </table>
                                                                            </div>
                                                                            <table width="755" align="center" cellspacing="0" cellpadding="0" style="margin:10px 0px; border: 2px solid #F99B3E; font-family:arial">
                                                                                <tr>
                                                                                    <td bgcolor="#f1f1f1" height="38" align="left" valign="middle">
                                                                                        <span style="padding-left:12px; font-weight: normal; font-size: 16px; color:#f68210;">Master Price List</span>
                                                                                        <!--<span onclick="return view_favorites('<?php echo $cumpony_id; ?>');" class="fav_button" style="float:right;text-decoration: none;margin-right: 15px;">FAVORITES</span>-->
                                                                                        <a class="fav_button" href="edit_fav.php?comp_id=<?php echo $cumpony_id; ?>&page=<?php echo $page; ?>" style="float:right;text-decoration: none;margin-right: 15px;">FAVORITES</a>
                                                                                    </td>
                                                                                </tr> 

                                                                                <tr>
                                                                                    <td height="30" align="left" valign="middle">
                                                                                        <span class="acc-cat click_close_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>">Click Here to load the Master Price List..</span>
                                                                                        <div id="cateacc_<?php echo $cumpony_id; ?>">

                                                                                        </div>                                                                            
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
                                                        <!--Pagination End-->
                                                    </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php //echo Paginations($limit, $page, 'customers.php?page=', $rows);     ?>
                                            </td>
                                        </tr>       
                                        <?php
                                    } elseif ($_GET['cus_add_id'] != '') {
                                        $address_users = Get_users_add($_GET['cus_add_id']);
                                        ?>

                                        <table width="759" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="36" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">NO.</td>                                                        
                                                <td width="100" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="customers.php?sort=<?php echo $sort_sku; ?>">Company Name&nbsp;<img src="images/<?php echo $sort_sku_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>                                                                                                                
                                                <?php if ($_SESSION['admin_user_type'] == '1') { ?>
                                                    <td width="64" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                <?php } ?>
                                            </tr>                                                
                                            <?php
                                            $i = 1;
                                            if (count($address_users) > 0) {
                                                if ($last_element != '') {
                                                    $i = ((($last_element * 25) - 25) + 1);
                                                } else {
                                                    $i = 1;
                                                }
                                                foreach ($address_users as $Prod) {
                                                    $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                    $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                    $id = $Prod['cus_id'];
                                                    $cumpony_id = $Prod['comp_id'];
                                                    $cus_email = $Prod['cus_email'];
                                                    $cus_regdate = date("m-d-Y", strtotime($Prod['cus_regdate']));
                                                    $company_name = $Prod['comp_name'];
                                                    $cust_id = ($Prod['cust_id'] != '') ? $Prod['cust_id'] : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                                    $user_address1 = ($Prod['comp_business_address1'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $Prod['comp_business_address1'];
                                                    $user_address2 = ($Prod['comp_business_address2'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $Prod['comp_business_address2'];
                                                    $user_address3 = ($Prod['comp_business_address3'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $Prod['comp_business_address3'];
                                                    $user_suit     = ($Prod['comp_room'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $Prod['comp_room'];
                                                    $company_phone = $Prod['comp_contact_phone'];
                                                    $company_fax = $Prod['comp_contact_fax'];
                                                    $company_city = $Prod['comp_city'];
                                                    $state_abbr = ($Prod['comp_state'] != '') ? $Prod['comp_state'] : '---';
                                                    $company_zip = $Prod['comp_zipcode'];
                                                    $tax = ($Prod['tax_exe'] == 1) ? 'Yes' : 'No';
                                                    $tax_excempt_number = $Prod['tax_exempt_number'];
                                                    $status = ($Prod['status'] == 1) ? 'active' : 'de-active';
                                                    if (($_SESSION['admin_user_type'] == '2') && ($Prod['status'] == 1)) {
                                                        $staff_prev = '';
                                                    } else {
                                                        $staff_prev = 'status';
                                                    }
                                                    $deleivery_address = ShippingAddressAllInfo($cumpony_id);
                                                    $deleivery_state = ($deleivery_address[0]['state'] != '') ? $deleivery_address[0]['state'] : '---';
                                                    ?>                                                
                                                    <tr class="trigger" id="<?php echo $Prod['comp_id']; ?>">
                                                        <td width="49"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>                                                                
                                                        <td width="100" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="pad_btm"><span class="company_name_<?php echo $cumpony_id; ?>"><?php echo $company_name; ?></span></td>                                                                
                                                        <?php if ($_SESSION['admin_user_type'] == '1') { ?>
                                                            <td width="80"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm">
                                                                <a href="#edit_user.php?id=<?php echo $id; ?>"><img src="images/edit.png"  alt="Edit" title="Edit" width="22" height="22"/></a>
                                                                <a href="customers.php?delete_id=<?php echo $cumpony_id; ?>" onclick="return confirm('Are you sure?');"><img src="images/del.png"  alt="Delete" title="Delete" width="22" height="22" class="mar_lft"/></a></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr class="test_<?php echo $Prod['comp_id']; ?>" style="display: none;">
                                                        <td colspan="<?php echo ($_SESSION['admin_user_type'] == '1') ? '3' : '2'; ?>">
                                                            <table width="100%" border="0">
                                                                <tr>
                                                                    <td colspan="3" align="center">
                                                                        <span id="succ_resend_<?php echo $cumpony_id; ?>" style="color:#007F2A;"></span> 
                                                                        <span id="fail_alert_<?php echo $cumpony_id; ?>" style="color:#F00;"></span> 
                                                                    </td>
                                                                </tr>

                                                                <tr valign="top">
                                                                    <td width="33%" style="height: 30px;text-align: left;padding-left: 2px;">
                                                                        <span style="font-weight: bold;float:left;">Cust. ID :&nbsp;&nbsp;</span>
                                                                        <span style="cursor: pointer;" class="cust_inline cust_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $cust_id; ?></span>
                                                                        <span style="float:left;" class="none cust_comp_lbl_<?php echo $cumpony_id; ?>"></span><input style="float:left;width: 110px;" type="text" class="none cust_inline_txt_<?php echo $cumpony_id; ?>" id="cust_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $cust_id; ?>" />
                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="cust_update cust_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="cust_cancel cust_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>   
                                                                    </td>
                                                                    <td width="33%" style="text-align: left;padding-left: 2px;">
                                                                        <span style="font-weight: bold;float:left;">Company :&nbsp;&nbsp;</span>
                                                                        <span style="cursor: pointer;" class="bus_inline bus_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_name; ?></span>
                                                                        <span style="float:left;" class="none bus_comp_lbl_<?php echo $cumpony_id; ?>"></span><input style="float:left;width: 110px;" type="text" class="none bus_inline_txt_<?php echo $cumpony_id; ?>" id="bus_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_name; ?>" />
                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="cn_update cn_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="cn_cancel cn_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                    
                                                                    </td>
                                                                    <?php
                                                                    if($Prod['cus_type'] == '0'){
                                                                    $cus_type = 'Customers';
                                                                    }elseif ($Prod['cus_type'] == '1') {
                                                                    $cus_type = 'Cash Customer';
                                                                    }elseif($Prod['cus_type'] == '2'){
                                                                    $cus_type = 'Customers';   
                                                                    }
                                                                    ?>
                                                                    <td width="34%"><span style="font-weight: bold;">Cust. Type :</span> <?php echo $cus_type; ?></td>
                                                                </tr>

                                                                <tr align="left" style="text-align: left;">
                                                                    <td width="33%" class="inf" style="font-weight: bold;padding-left: 2px;">Business Info</td>
                                                                    <td width="33%" class="inf" style="font-weight: bold;padding-left: 2px;">Delivery Info</td>
                                                                    <td width="34%" class="inf" style="font-weight: bold;padding-left: 2px;">User Info</td>
                                                                </tr>
                                                                <tr valign="top">                                                                        
                                                                    <!--Business Table Start-->
                                                                    <td align="left" width="250" style="text-align: left;">
                                                                        <table border="0" width="325"> 
                                                                            <tr>                                                                                       
                                                                                <td>
                                                                                    <strong style="float:left;">A1 :&nbsp;</strong><span style="cursor: pointer;" class="bus_add1_inline bus_add1_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_address1; ?></span>
                                                                                    <span style="float:left;" class="none bus_add1_lbl_<?php echo $cumpony_id; ?>"></span><input style="float:left;width: 150px;" type="text" class="none bus_add1_inline_txt_<?php echo $cumpony_id; ?>" id="bus_add1_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_address1; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad1_update ad1_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad1_cancel ad1_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                            $user_address2_ori = ($user_address2 == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $user_address2;
                                                                            ?>
                                                                            <tr>
                                                                                <td align="left">
                                                                                    <strong style="float:left;">A2 :&nbsp;</strong><span style="cursor: pointer;" class="bus_add2_inline bus_add2_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_address2_ori; ?></span>
                                                                                    <span style="float:left;" class="none bus_add2_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none bus_add2_inline_txt_<?php echo $cumpony_id; ?>" id="bus_add2_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_address2_ori; ?>" />
                                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad2_update ad2_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad2_cancel ad2_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                            $user_address3_ori = ($user_address3 == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $user_address3;
                                                                            ?>
                                                                            <tr>
                                                                                <td align="left">
                                                                                    <strong style="float:left;">A3 :&nbsp;</strong><span style="cursor: pointer;" class="bus_add3_inline bus_add3_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_suit; ?></span>
                                                                                    <span style="float:left;" class="none bus_add3_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none bus_add3_inline_txt_<?php echo $cumpony_id; ?>" id="bus_add3_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_suit; ?>" />
                                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad3_update ad3_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad3_cancel ad3_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                </td>
                                                                            </tr>
                                                                            <!--<tr>
                                                                                <td align="left">
                                                                                    <strong style="float:left;">S# :&nbsp;</strong><span style="cursor: pointer;" class="bus_suit_inline bus_suit_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_suit; ?></span>
                                                                                    <span style="float:left;" class="none bus_suit_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none bus_suit_inline_txt_<?php echo $cumpony_id; ?>" id="bus_suit_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_suit; ?>" />
                                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="suit_update suit_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="suit_cancel suit_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                </td>
                                                                            </tr>-->
                                                                            <tr>                                                                                        
                                                                                <td align="left" width="420">
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <span style="cursor: pointer;" class="bus_city_inline bus_city_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_city; ?></span>,
                                                                                                <input style="float:left; width: 60px;" type="text" class="none bus_city_inline_txt_<?php echo $cumpony_id; ?>" id="bus_city_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_city; ?>" />
                                                                                                <span style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="city_update city_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                <span style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="city_cancel city_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                <span style="cursor: pointer;margin-left: -2px;" class="bus_stat_inline bus_stat_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $state_abbr; ?></span>&nbsp;
                                                                                                <select name="state" id="<?php echo $cumpony_id; ?>" class="none bus_state bus_stat_inline_txt_<?php echo $cumpony_id; ?>" >                    
                                                                                                    <?php
                                                                                                    $state = StateAll();
                                                                                                    if ($state_abbr == "---") {
                                                                                                        ?>
                                                                                                        <option value="<?php echo $state_abbr; ?>" selected="selected"><?php echo $state_abbr; ?></option>
                                                                                                    <?php
                                                                                                    }
                                                                                                    foreach ($state as $state_val) {
                                                                                                        if ($state_val['state_abbr'] == $state_abbr) {
                                                                                                            ?>
                                                                                                            <option value="<?php echo $state_val['state_abbr'] ?>" selected="selected"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                        <?php } else { ?>
                                                                                                            <option value="<?php echo $state_val['state_abbr']; ?>"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                            <?php
                                                                                                        }
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                                <span style="cursor: pointer;margin-left: -5px;" class="bus_zip_inline bus_zip_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_zip; ?></span>
                                                                                                <input style="width: 40px;" type="text" class="none comp_zip bus_zip_inline_txt_<?php echo $cumpony_id; ?>" id="bus_zip_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_zip; ?>" />
                                                                                                <span style="float:right; margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_cancel zip_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                <span style="float:right;  margin: 0 0px 0 -10px;"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="zip_update zip_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table> 
                                                                                </td>
                                                                            </tr>                                                                                     
                                                                            <tr>                                                                                        
                                                                                <td>
                                                                                    <span style="float:left;"><strong>P : </strong></span>
                                                                                    <span style="cursor: pointer;" class="bus_phone_inline bus_phone_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_phone; ?></span>
                                                                                    <input style="width: 80px;" type="text" class="none comp_phone bus_phone_inline_txt_<?php echo $cumpony_id; ?>" id="bus_phone_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_phone; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="phone_update phone_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="phone_cancel phone_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr> 
                                                                            <tr>                                                                                        
                                                                                <td>                                                                                           
                                                                                    <span style="float:left;"><strong>F : </strong></span>                                                                                            
                                                                                    <span style="cursor: pointer;" class="bus_fax_inline bus_fax_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_fax; ?></span>
                                                                                    <input style="width: 80px;" type="text" class="none comp_fax bus_fax_inline_txt_<?php echo $cumpony_id; ?>" id="bus_fax_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_fax; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="fax_update fax_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="fax_cancel fax_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr> 
                                                                            <tr>
                                                                                <td class="inf">Tax Exemption&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                                                                            
                                                                                    <span style="cursor: pointer;" class="bus_tax_inline bus_tax_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $tax; ?></span>
                                                                                    <select name="tax" id="<?php echo $cumpony_id; ?>" class="none bus_tax bus_tax_inline_txt_<?php echo $cumpony_id; ?>" >                                                                                                                   
                                                                                        <option value="1" <?php if ($tax == 'Yes') { ?> selected="selected" <?php } ?>>Yes</option>                                                                                                    
                                                                                        <option value="0" <?php if ($tax == 'No') { ?> selected="selected" <?php } ?>>No</option>                                                                                                    
                                                                                    </select>

                                                                                </td>                                                                                            
                                                                            </tr>
                                                                            <?php if ($Prod['tax_exe'] == '1') { ?>                                                                                        
                                                                                <tr class="tax_exempt_number_row_view_<?php echo $cumpony_id; ?>">
                                                                                    <td>Tax ID : &nbsp;
                                                                                        <span class="tax_exempt_number_span_<?php echo $cumpony_id ?>"><?php echo $tax_excempt_number; ?></span>                                                                                                
                                                                                    </td>                                                                                             
                                                                                </tr> 
                                                                            <?php } ?>
                                                                            <tr class="none tax_exempt_number_row_<?php echo $cumpony_id; ?>">
                                                                                <td>
                                                                                    <span style="float: left;">Tax ID : &nbsp;</span>
                                                                                    <span class="tax_exempt_number_span_<?php echo $cumpony_id ?>"><?php //echo $tax_excempt_number;     ?></span>
                                                                                    <input type="text" name="tax_exempt_number" class="tax_exempt_number_<?php echo $cumpony_id; ?>" id="tax_exempt_number_<?php echo $cumpony_id; ?>" style="float: left;width: 90px;" autofocus="autofocus" value="<?php echo $tax_form_excempt; ?>" />
                                                                                    <div style="float:left; margin:0 4px">
                                                                                        <img src="images/like_icon.png" style="margin-top:-3px;" alt="Update" title="Update" width="22" height="22" class="tax_exempt_update tax_exempt_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" />
                                                                                    </div>
                                                                                </td>                                                                                             
                                                                            </tr>                                                                                    
                                                                        </table>
                                                                    </td>
                                                                    <!--Business Table End-->
                                                                    <!--Delivery Address Start-->
                                                                    <td width="240" style="text-align: left;">
                                                                        <table border="0" width="240">


                                                                            <tr>                                                                                       
                                                                                <td>
                                                                                    <?php
                                                                                    $del_add_1 = ($deleivery_address[0]['address_1'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['address_1'];
                                                                                    ?>
                                                                                    <span style="float:left;"><strong>A1 :&nbsp;</strong></span><span style="cursor: pointer;" class="del_add1_inline del_add1_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_add_1; ?></span>                                                                                                                                                                        
                                                                                    <input style="float:left;width:140px;" type="text" class="none del_add1_inline_txt_<?php echo $cumpony_id; ?>" id="del_add1_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $del_add_1; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad1_del_update ad1_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad1_del_cancel ad1_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td align="left">
                                                                                    <?php
                                                                                    $del_add_2 = ($deleivery_address[0]['address_2'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['address_2'];
                                                                                    ?>
                                                                                    <span style="float:left;"><strong>A2 :&nbsp;</strong></span><span style="cursor: pointer;" class="del_add2_inline del_add2_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_add_2; ?></span>   
                                                                                    <input style="float:left; width: 140px;" type="text" class="none del_add2_inline_txt_<?php echo $cumpony_id; ?>" id="del_add2_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $del_add_2; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad2_del_update ad2_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad2_del_cancel ad2_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                </td>
                                                                            </tr>                                                                                   
                                                                            <tr>                                                                                       
                                                                                <td>
                                                                                    <?php
                                                                                    $suite_del = ($deleivery_address[0]['suite'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['suite'];
                                                                                    ?>
                                                                                    <span style="float:left;"><strong>A3 :&nbsp;</strong></span><span style="cursor: pointer;" class="del_add3_inline del_add3_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $suite_del; ?></span>                                                                                                                                                                        
                                                                                    <input style="float:left;width: 140px;" type="text" class="none del_add3_inline_txt_<?php echo $cumpony_id; ?>" id="del_add3_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $suite_del; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad3_del_update ad3_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad3_del_cancel ad3_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                            //$suite_del = ($deleivery_address[0]['suite'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['suite'];
                                                                            ?>
                                                                            <!--<tr>
                                                                                <td align="left">
                                                                                    <strong style="float:left;">S# :&nbsp;</strong><span style="cursor: pointer;" class="del_suit_inline del_suit_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $suite_del; ?></span>
                                                                                    <span style="float:left;" class="none del_suit_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none del_suit_inline_txt_<?php echo $cumpony_id; ?>" id="del_suit_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $suite_del; ?>" />
                                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="suit_update_del suit_update_del_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="suit_cancel_del suit_cancel_del_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                </td>
                                                                            </tr>-->

                                                                            <tr>                                                                                        
                                                                                <td align="left" width="420">
                                                                                    <table align="left">
                                                                                        <tr align="left">
                                                                                            <td align="left">
                                                                                                <span style="cursor: pointer;" class="del_city_inline del_city_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_city =  ($deleivery_address[0]['city'] != '') ? $deleivery_address[0]['city'] : 'CITY'; ?></span>,
                                                                                                <input style="float:left; width: 60px;" type="text" class="none del_city_inline_txt_<?php echo $cumpony_id; ?>" id="del_city_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $deleivery_address[0]['city']; ?>" />
                                                                                                <span style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="city_del_update city_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                <span style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="city_del_cancel city_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>

                                                                                                <span style="cursor: pointer;margin-left: -2px;" class="del_stat_inline del_stat_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_state = ($deleivery_address[0]['state'] != '') ? StateName($deleivery_address[0]['state']) : '---'; ?></span>&nbsp;
                                                                                                <select name="state" id="<?php echo $cumpony_id; ?>" class="none del_state del_stat_inline_txt_<?php echo $cumpony_id; ?>" >                    
                                                                                                    <?php
                                                                                                    $state = StateAll();
                                                                                                                if ($deleivery_state == "---") {
                                                                                                                    ?>
                                                                                                                    <option value="<?php echo $deleivery_address[0]['state']; ?>" selected="selected"><?php echo $deleivery_address[0]['state']; ?></option>
                                                                                                                <?php
                                                                                                                }
                                                                                                    foreach ($state as $state_val) {
                                                                                                        if ($state_val['state_abbr'] == $state_abbr) {
                                                                                                            ?>
                                                                                                            <option value="<?php echo $state_val['state_abbr'] ?>" selected="selected"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                        <?php } else { ?>
                                                                                                            <option value="<?php echo $state_val['state_abbr']; ?>"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                            <?php
                                                                                                        }
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                                <span style="cursor: pointer;margin-left: -5px;" class="del_zip_inline del_zip_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_zip = ($deleivery_address[0]['zip'] != '') ? '&nbsp;'.$deleivery_address[0]['zip'] : '&nbsp;&nbsp;ZIP'; ?></span>
                                                                                                <input style="width: 40px;" type="text" class="none del_comp_zip del_zip_inline_txt_<?php echo $cumpony_id; ?>" id="del_zip_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $deleivery_address[0]['zip']; ?>" />
                                                                                                <span style="float:right; margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_del_cancel zip_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                <span style="float:right;  margin: 0 0px 0 -10px;"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="zip_del_update zip_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>


                                                                                                <?php //echo $deleivery_address[0]['city'].','.StateName($deleivery_address[0]['state']).'&nbsp;'.$deleivery_address[0]['zip'];    ?>                                                                                                
                                                                                            </td> 
                                                                                        </tr>
                                                                                    </table> 
                                                                                </td>
                                                                            </tr>                                                                                     
                                                                            <tr>                                                                                        
                                                                                <td>
                                                                                    <?php $del_phone = ($deleivery_address[0]['phone'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['phone']; ?>
                                                                                    <span class="del_phone_head_inline_span_<?php echo $cumpony_id; ?>"><strong>P : </strong></span>
                                                                                    <span style="cursor: pointer;" class="del_phone_inline del_phone_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_phone; ?></span>
                                                                                    <input style="width: 80px;" type="text" class="none comp_phone del_phone_inline_txt_<?php echo $cumpony_id; ?>" id="del_phone_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $deleivery_address[0]['phone']; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="phone_del_update phone_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="phone_del_cancel phone_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr> 
            <!--                                                                            <tr>                                                                                        
                                                                                <td>                                                                                           
                                                                                    <span class="<?php echo $cumpony_id; ?>"><strong>F : </strong></span>                                                                                            
                                                                                    <span style="cursor: pointer;" class="bus_fax_inline_span_del_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_fax; ?></span>                                                                                    
                                                                                </td>
                                                                            </tr>-->
                                                                            <tr>                                                                                        
                                                                                <td>&nbsp;</td>
                                                                            </tr>

                                                                        </table>
                                                                    </td>
                                                                    <!--Delivery Address End -->
                                                                    <!--Business Table Start End-->
                                                                    <?php $customer_per_company = custPerComp($cumpony_id); ?>
                                                                    <!--Personal Table Start-->
                                                                    <td align="left" style="text-align: left;">
                                                                        <table border="0" width="265">
                                                                            <tr>
                                                                                <td class="inf">Select User</td>
                                                                                <td align="left" style="padding-right: 60px;">
                                                                                    <span class="cus_id none" id="<?php echo $customer_per_company[0]['cus_id']; ?>"></span> 
                                                                                    <div id="user_select_box_<?php echo $cumpony_id; ?>_<?php echo $customer_per_company[0]['cus_id']; ?>">
                                                                                        <select  name="customer_name" id="<?php echo $cumpony_id; ?>" class="customer_name_<?php echo $cumpony_id; ?> select_customer">
                                                                                            <option value="0">--Customers--</option>                                                                                                
                                                                                            <?php
                                                                                            foreach ($customer_per_company as $customers) {
                                                                                                $bold = ($customers['cus_manager'] == '1') ? 'select_customer1' : '';
                                                                                                ?>
                                                                                                <option value="<?php echo $customers['cus_id']; ?>" class="<?php echo $bold; ?>"><?php echo $customers['cus_contact_name']; ?></option>                                                                                                 <?php } ?>                                                                                               
                                                                                        </select>                                                                                            
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" height="70">
                                                                                    <!--                                                                                            <div id="jassim"></div>-->
                                                                                    <div id="msg_<?php echo $cumpony_id; ?>" class="cus_adm_succ_j"></div>
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

                                                                <tr>
                                                                    <?php 
                                                                    if($Prod['invoice_type'] == '7'){
                                                                    $invoice_type_set = "Weekly";
                                                                    }elseif ($Prod['invoice_type'] == '14') {
                                                                    $invoice_type_set = "Semi-Monthly";
                                                                    }elseif($Prod['invoice_type'] == '30'){
                                                                    $invoice_type_set = "Monthly";
                                                                    }elseif ($Prod['invoice_type'] == '0') {
                                                                    $invoice_type_set = "Select Type";
                                                                    }
                                                                    ?>
                                                                    <td align="left" width="30%" class="inf">
                                                                        <div style="width: 100%;float: left;margin-bottom: 3px;"> 
                                                                            <ul>
                                                                                <li>
                                                                                    <label style="font-weight: bold;">Invoice Frequency :</label>
                                                                                    <span style="cursor: pointer;" id="inv_type_<?php echo $cumpony_id; ?>" onclick="return select_inv_type('<?php echo $cumpony_id; ?>');"><?php echo $invoice_type_set; ?></span>
                                                                                    <select name="invoice_freq" class="invoice_freq_type none" id="invoice_freq_<?php echo $cumpony_id; ?>" onchange="return set_invoice_type('<?php echo $cumpony_id; ?>');">                                                                                        
                                                                                        <option value="0"  <?php if($Prod['invoice_type'] == '0'){ ?>selected="selected"<?php } ?>>Select Type</option>
                                                                                        <option value="7"  <?php if($Prod['invoice_type'] == '7'){ ?>selected="selected"<?php } ?>>Weekly</option>
                                                                                        <option value="14" <?php if($Prod['invoice_type'] == '14'){ ?>selected="selected"<?php } ?>>Semi-Weekly</option>
                                                                                        <option value="30" <?php if($Prod['invoice_type'] == '30'){ ?>selected="selected"<?php } ?>>Monthly</option>
                                                                                    </select>
                                                                                </li>
                                                                            </ul>
                                                                        </div>                                                                        
                                                                    </td>
                                                                    <td width="40%" class="inf">
                                                                        <table>
                                                                            <tr>
                                                                                <td style="padding-top: 5px;">
                                                                                    <select  name="address_book" id="<?php echo $cumpony_id; ?>" class="address_book_<?php echo $cumpony_id; ?> select_address">
                                                                                        <option value="0">Address Book</option>
                                                                                        <?php
                                                                                        $address_book = AddressBookCompany($cumpony_id);
                                                                                        foreach ($address_book as $address) {
                                                                                            ?>                                                                                        
                                                                                            <option value="<?php echo $address['id']; ?>"><?php echo $address['company_name']; ?></option>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding-top: 5px;">
                                                                                    <div id="addressbook_info_<?php echo $cumpony_id; ?>">

                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>                                                                                
                                                                    </td>
                                                                    <td width="30%" class="inf" style="font-weight: bold;padding-left: 2px;">&nbsp;</td>
                                                                </tr>

                                                                <?php
                                                                $status_class = ($Prod['status'] == '1') ? 'action_sus' : 'action_rein';
                                                                $status_text = ($Prod['status'] == '1') ? 'SUSPEND' : 'REINSTATE';
                                                                ?>
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <span class="<?php echo $status_class; ?>" id="action_<?php echo $cumpony_id; ?>" onclick="return sus_reiv('<?php echo $cumpony_id; ?>');"><?php echo $status_text; ?></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                                <td colspan="3">
                                                                                    <div style="float:left;width:50%;font-weight: bold;">Customer Notes: </div>
                                                                                    <div style="float:left;width:50%;border:2px solid #F99B3E;height: 110px;">
                                                                                        <div id="cus_notes_<?php echo $cumpony_id; ?>" onclick="return edit_cus_notes('<?php echo $cumpony_id; ?>');" style="float:left;width:98%;margin-left: 3px;height: 75px;cursor: pointer;">
                                                                                            <?php echo $Prod['customer_notes']; ?>
                                                                                        </div>
                                                                                        <form name="myform">
                                                                                            <div id="cus_notes_edit_<?php echo $cumpony_id; ?>" style="float:left;width:98%;margin-left: 3px;margin-top: 5px;display: none;">
                                                                                                <textarea class="cus_notes_edit_txt_<?php echo $cumpony_id; ?>" id="cust_notes" style="width:98%;height: 75px;margin-left: 3px;" onKeyDown="limitText(this.form.cust_notes,this.form.countdown,256);" onKeyUp="limitText(this.form.cust_notes,this.form.countdown,256);"><?php echo $Prod['customer_notes']; ?></textarea>                                                                                
                                                                                                <div style="float:left;width:98%;margin-left: 3px;margin-bottom: 5px;margin-top: 3px;">
                                                                                                    <div style="float:left;width: 49%;text-align: left;">
                                                                                                       <input readonly type="text" name="countdown" size="5" id="countdown" value="256" style="width: 35px;border:1px solid #000;" />
                                                                                                    </div>
                                                                                                    <div style="float:left;width: 49%;text-align: right;">
                                                                                                        <span id="cus_notes_edit_can_<?php echo $cumpony_id; ?>"  onclick="return cancel_cust_notes('<?php echo $cumpony_id; ?>');" style="background: #D3412C;color: #FFF;padding: 2px 5px;text-transform: uppercase;border-radius: 5px;font-weight: bold;font-size: 11px;cursor: pointer;">CANCEL</span>
                                                                                                        <span id="cus_notes_edit_save_<?php echo $cumpony_id; ?>" onclick="return save_cust_notes('<?php echo $cumpony_id; ?>');" style="background: #009D59;color: #FFF;padding: 2px 5px;text-transform: uppercase;border-radius: 5px;font-weight: bold;font-size: 11px;cursor: pointer;">SAVE</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                            </table>
                                                            <span class="succ" id="succ" style="color:#007F2A;font-size: 12px;"  ></span>
                                                            <div id="mas_<?php echo $cumpony_id; ?>">
                                                                <div id="spl_<?php echo $cumpony_id; ?>">
                                                                    <table id="spl" width="755" align="center" cellspacing="0" cellpadding="0" style="margin:10px 0px; border: 2px solid #F99B3E; font-family:arial">
                                                                        <tr>
                                                                            <td bgcolor="#f1f1f1" height="38" align="left" valign="middle">
                                                                                <span style="padding-left:12px; font-weight: normal; font-size: 16px; color:#f68210;">Specific Pricing</span>
                                                                                <a href="print_special_proce.php?comp_id=<?php echo $cumpony_id; ?>" target="_blank" class="action_rein" style="float:right;text-decoration: none;margin-right: 15px;">PRINT</a>
                                                                            </td>
                                                                        </tr>                                                                  
                                                                        <tr>
                                                                            <td height="30" align="left" valign="middle" class="content_1">

                                                                                <!---Special Pricing Start --->   
            <!--                                                                                            <span class="acc-spl click_close_special_<?php //echo $cumpony_id;      ?>" id="<?php //echo $cumpony_id;      ?>" style="cursor: pointer;">Click Here to load the Special Price List..</span>
                                                                                <div id="spl_price_list_<?php //echo $cumpony_id;      ?>">
                                                                                
                                                                                </div>                                                                                                                                                                         -->
                                                                                <!---Special Pricing End --->     
                                                                                <table width="100%" > 
                                                                                    <tbody>
                                                                                        <tr style="background-color: #F9F2DE;border-bottom: 1px solid #FF7E00; color:#fff;">                                                                            
                                                                                            <td align="center" bgcolor="#f68210"  class="brdr">S.NO</td>
                                                                                            <td align="center" width="25%" valign="middle" bgcolor="#f68210"  class="brdr">Super Category</td>
                                                                                            <td align="center" width="5%" valign="middle" bgcolor="#f68210"  class="brdr">Category</td>
                                                                                            <td align="center" width="20%" valign="middle" bgcolor="#f68210"  class="brdr">Sub Category</td>
                                                                                            <td align="center" width="20%" valign="middle" bgcolor="#f68210"  class="brdr">Product Name</td>
                                                                                            <td align="center" width="15%" valign="middle" bgcolor="#f68210"  class="brdr">List Price</td>
                                                                                            <td align="center" width="5%" valign="middle" bgcolor="#f68210"  class="brdr">Discount(%)</td>
                                                                                            <td align="center" width="35%" valign="middle" bgcolor="#f68210"  class="brdr">Selling Price</td>                                                                            
                                                                                            <td align="center" width="" valign="middle" bgcolor="#f68210"  class="brdr">Action</td>
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

                                                                            </td>                                                                            
                                                                        </tr> 
                                                                    </table>
                                                                </div>
                                                                <table width="755" align="center" cellspacing="0" cellpadding="0" style="margin:10px 0px; border: 2px solid #F99B3E; font-family:arial">
                                                                    <tr>
                                                                        <td bgcolor="#f1f1f1" height="38" align="left" valign="middle">
                                                                            <span style="padding-left:12px; font-weight: normal; font-size: 16px; color:#f68210;">Master Price List</span>
                                                                            <a class="fav_button" href="edit_fav.php?comp_id=<?php echo $cumpony_id; ?>&page=<?php echo $page; ?>" style="float:right;text-decoration: none;margin-right: 15px;">FAVORITES</a>
                                                                        </td>
                                                                    </tr> 

                                                                    <tr>
                                                                        <td height="30" align="left" valign="middle">
                                                                            <span class="acc-cat click_close_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>">Click Here to load the Master Price List..</span>
                                                                            <div id="cateacc_<?php echo $cumpony_id; ?>">

                                                                            </div>                                                                            
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
                                            <!--Pagination End-->
                                        </table>
                                    <?php }elseif($_GET["cus_type_fil"] != ''){
                                        
                                    ?>
                                        <!-- Customer Filter By Start -->
                                        <table width="800" border="0" cellspacing="0" cellpadding="0" >
                                            <tr>
                                                <td colspan="3" style="border-top: 1px solid #cecece;border-left: 1px solid #cecece;border-right: 1px solid #cecece; padding: 10px;text-transform: uppercase;font-size: 16px;">                                                  
                                                    <?php
                                                    if($_GET['cus_type_fil'] == '0'){
                                                        echo 'Imported Customers';
                                                    }elseif ($_GET['cus_type_fil'] == '1') {
                                                        echo 'Cash Customers';    
                                                    }elseif ($_GET['cus_type_fil'] == '2') {
                                                        echo 'Admin Added Customers';      
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="36" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">NO.</td>                                                        
                                                <td width="100" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="customers.php?sort=<?php echo $sort_sku; ?>">Company Name&nbsp;<img src="images/<?php echo $sort_sku_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>                                                                                                                
                                                <?php if ($_SESSION['admin_user_type'] == '1') { ?>
                                                    <td width="64" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                <?php } ?>
                                            </tr>                                                
                                            <?php
                                            $i = 1;
                                            if (count($users) > 0) {
                                                if ($last_element != '') {
                                                    $i = ((($last_element * 25) - 25) + 1);
                                                } else {
                                                    $i = 1;
                                                }
                                                foreach ($filtered_customer as $Prod) {
                                                    $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                    $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                    $id = $Prod['cus_id'];
                                                    $cumpony_id = $Prod['comp_id'];
                                                    $cus_email = $Prod['cus_email'];
                                                    $cus_regdate = date("m-d-Y", strtotime($Prod['cus_regdate']));
                                                    $company_name = $Prod['comp_name'];
                                                    $cust_id = ($Prod['cust_id'] != '') ? $Prod['cust_id'] : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                                    $user_address1 = ($Prod['comp_business_address1'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $Prod['comp_business_address1'];
                                                    $user_address2 = ($Prod['comp_business_address2'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $Prod['comp_business_address2'];
                                                    $user_address3 = ($Prod['comp_business_address3'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $Prod['comp_business_address3'];
                                                    $user_suit     = ($Prod['comp_room'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $Prod['comp_room'];
                                                    $company_phone = ($Prod['comp_contact_phone'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $Prod['comp_contact_phone'];
                                                    $company_fax = $Prod['comp_contact_fax'];
                                                    $company_city = $Prod['comp_city'];
                                                    $state_abbr = ($Prod['comp_state'] != '') ? $Prod['comp_state'] : '---';
                                                    
                                                    $company_zip = $Prod['comp_zipcode'];
                                                    $company_zip_ext = $Prod['comp_zipcode_ext'];
                                                    $tax = ($Prod['tax_exe'] == 1) ? 'Yes' : 'No';
                                                    $tax_excempt_number = $Prod['tax_exempt_number'];
                                                    $status = ($Prod['status'] == 1) ? 'active' : 'de-active';
                                                    if (($_SESSION['admin_user_type'] == '2') && ($Prod['status'] == 1)) {
                                                        $staff_prev = '';
                                                    } else {
                                                        $staff_prev = 'status';
                                                    }
                                                    $deleivery_address = ShippingAddressAllInfo($cumpony_id);
                                                    $deleivery_state = ($deleivery_address[0]['state'] != '') ? $deleivery_address[0]['state'] : '---';
                                                    ?>                                                
                                                    <tr class="trigger" id="<?php echo $Prod['comp_id']; ?>">
                                                        <td width="49"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>                                                                
                                                        <td width="100" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="pad_btm"><span class="company_name_<?php echo $cumpony_id; ?>"><?php echo $company_name; ?></span></td>                                                                
                                                        <?php if ($_SESSION['admin_user_type'] == '1') { ?>
                                                            <td width="80"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm">
                                                                <a href="#edit_user.php?id=<?php echo $id; ?>"><img src="images/edit.png"  alt="Edit" title="Edit" width="22" height="22"/></a>
                                                                <a href="customers.php?delete_id=<?php echo $cumpony_id; ?>&page=<?php echo $last_element; ?>" onclick="return confirm('Are you sure?');"><img src="images/del.png"  alt="Delete" title="Delete" width="22" height="22" class="mar_lft"/></a></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr class="test_<?php echo $Prod['comp_id']; ?>" style="display: none;">
                                                        <td colspan="<?php echo ($_SESSION['admin_user_type'] == '1') ? '3' : '2'; ?>">
                                                            <table width="100%" border="0">
                                                                <tr>
                                                                    <td colspan="3" align="center">
                                                                        <span id="succ_resend_<?php echo $cumpony_id; ?>" style="color:#007F2A;"></span> 
                                                                        <span id="fail_alert_<?php echo $cumpony_id; ?>" style="color:#F00;"></span> 
                                                                    </td>
                                                                </tr>
                                                                <tr valign="top">
                                                                    <td width="33%" style="height: 30px;text-align: left;padding-left: 2px;">
                                                                        <span style="font-weight: bold;float:left;">Cust. ID :&nbsp;&nbsp;</span>
                                                                        <span style="cursor: pointer;" class="cust_inline cust_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $cust_id; ?></span>
                                                                        <span style="float:left;" class="none cust_comp_lbl_<?php echo $cumpony_id; ?>"></span><input style="float:left;width: 110px;" type="text" class="none cust_inline_txt_<?php echo $cumpony_id; ?>" id="cust_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $cust_id; ?>" />
                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="cust_update cust_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="cust_cancel cust_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>   
                                                                    </td>
                                                                    <td width="33%" style="text-align: left;padding-left: 2px;">
                                                                        <span style="font-weight: bold;float:left;">Company :&nbsp;&nbsp;</span>
                                                                        <span style="cursor: pointer;" class="bus_inline bus_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_name; ?></span>
                                                                        <span style="float:left;" class="none bus_comp_lbl_<?php echo $cumpony_id; ?>"></span><input style="float:left;width: 110px;" type="text" class="none bus_inline_txt_<?php echo $cumpony_id; ?>" id="bus_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_name; ?>" />
                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="cn_update cn_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="cn_cancel cn_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                    
                                                                    </td>
                                                                    <?php
                                                                    if($Prod['cus_type'] == '0'){
                                                                    $cus_type = 'Customers';
                                                                    }elseif ($Prod['cus_type'] == '1') {
                                                                    $cus_type = 'Cash Customer';
                                                                    }elseif($Prod['cus_type'] == '2'){
                                                                    $cus_type = 'Customers';   
                                                                    }
                                                                    ?>
                                                                    <td width="34%"><span style="font-weight: bold;">Cust. Type :</span> <?php echo $cus_type; ?></td>
                                                                </tr>
                                                                <tr align="left" style="text-align: left;">
                                                                    <td width="33%" class="inf" style="font-weight: bold;padding-left: 2px;">Business Info</td>
                                                                    <td width="33%" class="inf" style="font-weight: bold;padding-left: 2px;">Delivery Info</td>
                                                                    <td width="34%" class="inf" style="font-weight: bold;padding-left: 2px;">User Info</td>
                                                                </tr>
                                                                <tr valign="top">                                                                        
                                                                    <!--Business Table Start-->
                                                                    <td align="left" width="250" style="text-align: left;">
                                                                        <table border="0" width="325"> 
                                                                            <tr>                                                                                       
                                                                                <td>
                                                                                    <strong style="float:left;">A1 :&nbsp;</strong><span style="cursor: pointer;" class="bus_add1_inline bus_add1_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_address1; ?></span>
                                                                                    <span style="float:left;" class="none bus_add1_lbl_<?php echo $cumpony_id; ?>"></span><input style="float:left;width: 150px;" type="text" class="none bus_add1_inline_txt_<?php echo $cumpony_id; ?>" id="bus_add1_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_address1; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad1_update ad1_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad1_cancel ad1_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                            $user_address2_ori = ($user_address2 == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $user_address2;
                                                                            ?>
                                                                            <tr>
                                                                                <td align="left">
                                                                                    <strong style="float:left;">A2 :&nbsp;</strong><span style="cursor: pointer;" class="bus_add2_inline bus_add2_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_address2_ori; ?></span>
                                                                                    <span style="float:left;" class="none bus_add2_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none bus_add2_inline_txt_<?php echo $cumpony_id; ?>" id="bus_add2_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_address2_ori; ?>" />
                                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad2_update ad2_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad2_cancel ad2_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                            $user_address3_ori = ($user_address3 == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $user_address3;
                                                                            ?>
                                                                            <tr>
                                                                                <td align="left">
                                                                                    <strong style="float:left;">A3 :&nbsp;</strong><span style="cursor: pointer;" class="bus_add3_inline bus_add3_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_suit; ?></span>
                                                                                    <span style="float:left;" class="none bus_add3_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none bus_add3_inline_txt_<?php echo $cumpony_id; ?>" id="bus_add3_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_suit; ?>" />
                                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad3_update ad3_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad3_cancel ad3_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                </td>
                                                                            </tr>                                                                            
                                                                            <!--<tr>
                                                                                <td align="left">
                                                                                    <strong style="float:left;">S# :&nbsp;</strong><span style="cursor: pointer;" class="bus_suit_inline bus_suit_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_suit; ?></span>
                                                                                    <span style="float:left;" class="none bus_suit_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none bus_suit_inline_txt_<?php echo $cumpony_id; ?>" id="bus_suit_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_suit; ?>" />
                                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="suit_update suit_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="suit_cancel suit_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                </td>
                                                                            </tr>-->
                                                                            <tr>                                                                                        
                                                                                <td align="left" width="500">
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <table>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <span style="cursor: pointer;" class="bus_city_inline bus_city_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_city; ?>,&nbsp;</span>
                                                                                                            <input style="float:left; width: 60px;" type="text" class="none bus_city_inline_txt_<?php echo $cumpony_id; ?>" id="bus_city_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_city; ?>" />
                                                                                                            <span style="float:left; margin:0 0px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="city_update city_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                            <span style="float:left;  margin:0 0px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="city_cancel city_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <span style="cursor: pointer;margin-left: -2px;" class="bus_stat_inline bus_stat_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $state_abbr; ?></span>&nbsp;
                                                                                                            <select name="state" id="<?php echo $cumpony_id; ?>" class="none bus_state bus_stat_inline_txt_<?php echo $cumpony_id; ?>" >                    
                                                                                                                <?php
                                                                                                                $state = StateAll();
                                                                                                                if ($state_abbr == "---") {
                                                                                                                    ?>
                                                                                                                    <option value="<?php echo $state_abbr; ?>" selected="selected"><?php echo $state_abbr; ?></option>
                                                                                                                <?php
                                                                                                                }
                                                                                                                foreach ($state as $state_val) {
                                                                                                                    if ($state_val['state_abbr'] == $state_abbr) {
                                                                                                                        ?>
                                                                                                                        <option value="<?php echo $state_val['state_abbr'] ?>" selected="selected"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                                    <?php } else { ?>
                                                                                                                        <option value="<?php echo $state_val['state_abbr']; ?>"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                                        <?php
                                                                                                                    }
                                                                                                                }
                                                                                                                ?>
                                                                                                            </select>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <span>
                                                                                                                <span style="cursor: pointer;margin-left: -5px;" class="bus_zip_inline bus_zip_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_zip; ?></span>
                                                                                                                <input style="width: 40px;" type="text" class="none comp_zip bus_zip_inline_txt_<?php echo $cumpony_id; ?>" id="bus_zip_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_zip; ?>" />
                                                                                                                <span style="float:right; margin:0 0px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_cancel zip_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                <span style="float:right;"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="zip_update zip_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                            </span>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <?php
                                                                                                            $company_zip_ext_ori = ($company_zip_ext == '0') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : '-' .$company_zip_ext;
                                                                                                            ?>
                                                                                                            <span>
                                                                                                                <span style="cursor: pointer;margin-left: 0px;" class="bus_zip_inline_ext bus_zip_inline_span_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_zip_ext_ori; ?></span>
                                                                                                                <input style="width: 40px;" type="text" class="none comp_zip_ext bus_zip_inline_txt_ext_<?php echo $cumpony_id; ?>" id="bus_zip_inline_txt_ext_<?php echo $cumpony_id; ?>" value="<?php echo $company_zip_ext_ori; ?>" />
                                                                                                                <span style="float:right; margin:0 0px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_cancel_ext zip_cancel_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                <span style="float:right;"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="zip_update_ext zip_update_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                            </span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table> 
                                                                                </td>
                                                                            </tr>                                                                                     
                                                                            <tr>                                                                                        
                                                                                <td>
                                                                                    <span style="float:left;"><strong>P : </strong></span>
                                                                                    <span style="cursor: pointer;" class="bus_phone_inline bus_phone_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_phone; ?></span>
                                                                                    <input style="width: 80px;" type="text" class="none comp_phone bus_phone_inline_txt_<?php echo $cumpony_id; ?>" id="bus_phone_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_phone; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="phone_update phone_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="phone_cancel phone_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr> 
                                                                            <tr>                                                                                        
                                                                                <td>                                                                                           
                                                                                    <span style="float:left;"><strong>F : </strong></span>                                                                                            
                                                                                    <span style="cursor: pointer;" class="bus_fax_inline bus_fax_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_fax; ?></span>
                                                                                    <input style="width: 80px;" type="text" class="none comp_fax bus_fax_inline_txt_<?php echo $cumpony_id; ?>" id="bus_fax_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_fax; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="fax_update fax_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="fax_cancel fax_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr> 
                                                                            <tr>
                                                                                <td class="inf">Tax Exemption&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                                                                            
                                                                                    <span style="cursor: pointer;" class="bus_tax_inline bus_tax_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $tax; ?></span>
                                                                                    <select name="tax" id="<?php echo $cumpony_id; ?>" class="none bus_tax bus_tax_inline_txt_<?php echo $cumpony_id; ?>" >                                                                                                                   
                                                                                        <option value="1" <?php if ($tax == 'Yes') { ?> selected="selected" <?php } ?>>Yes</option>                                                                                                    
                                                                                        <option value="0" <?php if ($tax == 'No') { ?> selected="selected" <?php } ?>>No</option>                                                                                                    
                                                                                    </select>

                                                                                </td>                                                                                            
                                                                            </tr>
            <?php if ($Prod['tax_exe'] == '1') { ?>                                                                                        
                                                                                <tr class="tax_exempt_number_row_view_<?php echo $cumpony_id; ?>">
                                                                                    <td>Tax ID : &nbsp;
                                                                                        <span class="tax_exempt_number_span_<?php echo $cumpony_id ?>"><?php echo $tax_excempt_number; ?></span>                                                                                                
                                                                                    </td>                                                                                             
                                                                                </tr> 
            <?php } ?>
                                                                            <tr class="none tax_exempt_number_row_<?php echo $cumpony_id; ?>">
                                                                                <td>
                                                                                    <span style="float: left;">Tax ID : &nbsp;</span>
                                                                                    <span class="tax_exempt_number_span_<?php echo $cumpony_id ?>"><?php //echo $tax_excempt_number;     ?></span>
                                                                                    <input type="text" name="tax_exempt_number" class="tax_exempt_number_<?php echo $cumpony_id; ?>" id="tax_exempt_number_<?php echo $cumpony_id; ?>" style="float: left;width: 90px;" autofocus="autofocus" value="<?php echo $tax_form_excempt; ?>" />
                                                                                    <div style="float:left; margin:0 4px">
                                                                                        <img src="images/like_icon.png" style="margin-top:-3px;" alt="Update" title="Update" width="22" height="22" class="tax_exempt_update tax_exempt_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" />
                                                                                    </div>
                                                                                </td>                                                                                             
                                                                            </tr>                                                                                    
                                                                        </table>
                                                                    </td>
                                                                    <!--Business Table END-->
                                                                    <!--Delivery Address Start-->
                                                                    <td width="250" style="text-align: left;">
                                                                        <table border="0" width="300"> 
                                                                            <tr>                                                                                       
                                                                                <td>
                                                                                    <?php
                                                                                    $del_add_1 = ($deleivery_address[0]['address_1'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['address_1'];
                                                                                    ?>
                                                                                    <span style="float:left;"><strong>A1 :&nbsp;</strong></span><span style="cursor: pointer;" class="del_add1_inline del_add1_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_add_1; ?></span>                                                                                                                                                                        
                                                                                    <input style="float:left;width:140px;" type="text" class="none del_add1_inline_txt_<?php echo $cumpony_id; ?>" id="del_add1_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $del_add_1; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad1_del_update ad1_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad1_del_cancel ad1_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td align="left">
                                                                                    <?php
                                                                                    $del_add_2 = ($deleivery_address[0]['address_2'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['address_2'];
                                                                                    ?>
                                                                                    <span style="float:left;"><strong>A2 :&nbsp;</strong></span><span style="cursor: pointer;" class="del_add2_inline del_add2_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_add_2; ?></span>   
                                                                                    <input style="float:left; width: 140px;" type="text" class="none del_add2_inline_txt_<?php echo $cumpony_id; ?>" id="del_add2_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $del_add_2; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad2_del_update ad2_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad2_del_cancel ad2_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                            $suite_del = ($deleivery_address[0]['suite'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['suite'];
                                                                            ?>
                                                                            <tr>                                                                                       
                                                                                <td>
                                                                                    <span style="float:left;"><strong>A3 :&nbsp;</strong></span><span style="cursor: pointer;" class="del_add3_inline del_add3_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $suite_del; ?></span>                                                                                                                                                                        
                                                                                    <input style="float:left;width: 140px;" type="text" class="none del_add3_inline_txt_<?php echo $cumpony_id; ?>" id="del_add3_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $suite_del; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad3_del_update ad3_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad3_del_cancel ad3_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                            //$suite_del = ($deleivery_address[0]['suite'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['suite'];
                                                                            ?>
                                                                            <!--<tr>
                                                                                <td align="left">
                                                                                    <strong style="float:left;">S# :&nbsp;</strong><span style="cursor: pointer;" class="del_suit_inline del_suit_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $suite_del; ?></span>
                                                                                    <span style="float:left;" class="none del_suit_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none del_suit_inline_txt_<?php echo $cumpony_id; ?>" id="del_suit_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $suite_del; ?>" />
                                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="suit_update_del suit_update_del_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="suit_cancel_del suit_cancel_del_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                </td>
                                                                            </tr>-->
                                                                            <tr>                                                                                        
                                                                                <td align="left" width="500">
                                                                                    <table align="left">
                                                                                        <tr align="left">
                                                                                            <td align="left">
                                                                                                <table border="0">
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <span style="cursor: pointer;" class="del_city_inline del_city_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $deleivery_address[0]['city']; ?></span>,
                                                                                                            <input style="float:left; width: 60px;" type="text" class="none del_city_inline_txt_<?php echo $cumpony_id; ?>" id="del_city_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $deleivery_address[0]['city']; ?>" />
                                                                                                            <span style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="city_del_update city_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                            <span style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="city_del_cancel city_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <span style="cursor: pointer;margin-left: -17px;" class="del_stat_inline del_stat_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_state = ($deleivery_address[0]['state'] != '') ? StateName($deleivery_address[0]['state']) : '---'; ?></span>&nbsp;
                                                                                                            <select name="state" id="<?php echo $cumpony_id; ?>" class="none del_state del_stat_inline_txt_<?php echo $cumpony_id; ?>" >                    
                                                                                                                <?php
                                                                                                                $state = StateAll();
                                                                                                                if ($deleivery_state == "---") {
                                                                                                                    ?>
                                                                                                                    <option value="<?php echo $deleivery_state; ?>" selected="selected"><?php echo $deleivery_state; ?></option>
                                                                                                                <?php
                                                                                                                }
                                                                                                                foreach ($state as $state_val) {
                                                                                                                    if ($state_val['state_id'] == $deleivery_address[0]['state']) {
                                                                                                                        ?>
                                                                                                                        <option value="<?php echo $state_val['state_abbr'] ?>" selected="selected"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                                    <?php } else { ?>
                                                                                                                        <option value="<?php echo $state_val['state_abbr']; ?>"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                                        <?php
                                                                                                                    }
                                                                                                                }
                                                                                                                ?>
                                                                                                            </select>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <span style="cursor: pointer;margin-left: -5px;" class="del_zip_inline del_zip_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_zip = ($deleivery_address[0]['zip'] != '') ? '&nbsp;'.$deleivery_address[0]['zip'] : '&nbsp;&nbsp;ZIP'; ?></span>
                                                                                                            <input style="width: 40px;" type="text" class="none del_comp_zip del_zip_inline_txt_<?php echo $cumpony_id; ?>" id="del_zip_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $deleivery_address[0]['zip']; ?>" />
                                                                                                            <span style="float:right; margin:0 0px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_del_cancel zip_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                            <span style="float:right;  margin: 0 0px 0 0px;"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="zip_del_update zip_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <?php
                                                                                                            $devilery_zip_ext = ($deleivery_address[0]['zip_ext'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : '-' .$deleivery_address[0]['zip_ext'];
                                                                                                            ?>
                                                                                                            <span>
                                                                                                                <span style="cursor: pointer;margin-left: 0px;" class="zip_inline_del_ext zip_inline_span_del_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $devilery_zip_ext; ?></span>
                                                                                                                <input style="width: 40px;" type="text" class="none comp_zip_del_ext zip_inline_txt_del_ext_<?php echo $cumpony_id; ?>" id="zip_inline_txt_del_ext_<?php echo $cumpony_id; ?>" value="<?php echo $devilery_zip_ext; ?>" />
                                                                                                                <span style="float:right; margin:0 0px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_cancel_del_ext zip_cancel_del_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                <span style="float:right;"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="zip_update_del_ext zip_update_del_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                            </span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
            <?php //echo $deleivery_address[0]['city'].','.StateName($deleivery_address[0]['state']).'&nbsp;'.$deleivery_address[0]['zip'];    ?>                                                                                                
                                                                                            </td> 
                                                                                        </tr>
                                                                                    </table> 
                                                                                </td>
                                                                            </tr>                                                                                     
                                                                            <tr>                                                                                        
                                                                                <td>
            <?php $del_phone = ($deleivery_address[0]['phone'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['phone']; ?>
                                                                                    <span class="del_phone_head_inline_span_<?php echo $cumpony_id; ?>"><strong>P : </strong></span>
                                                                                    <span style="cursor: pointer;" class="del_phone_inline del_phone_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_phone; ?></span>
                                                                                    <input style="width: 80px;" type="text" class="none comp_phone del_phone_inline_txt_<?php echo $cumpony_id; ?>" id="del_phone_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $deleivery_address[0]['phone']; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="phone_del_update phone_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="phone_del_cancel phone_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr> 
            <!--                                                                            <tr>                                                                                        
                                                                                <td>                                                                                           
                                                                                    <span class="<?php echo $cumpony_id; ?>"><strong>F : </strong></span>                                                                                            
                                                                                    <span style="cursor: pointer;" class="bus_fax_inline_span_del_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_fax; ?></span>                                                                                    
                                                                                </td>
                                                                            </tr>-->
                                                                            <tr>                                                                                        
                                                                                <td>&nbsp;</td>
                                                                            </tr>

                                                                        </table>
                                                                    </td>
                                                                    <!--Delivery Address End -->
                                                                    <!--Business Table Start End-->
            <?php $customer_per_company = custPerComp($cumpony_id); ?>
                                                                    <!--Personal Table Start-->
                                                                    <td align="left" style="text-align: left;">
                                                                        <table border="0" width="265">
                                                                            <tr>
                                                                                <td class="inf">Select User</td>
                                                                                <td align="left" style="padding-right: 60px;">
                                                                                    <span class="cus_id none" id="<?php echo $customer_per_company[0]['cus_id']; ?>"></span> 
                                                                                    <div id="user_select_box_<?php echo $cumpony_id; ?>_<?php echo $customer_per_company[0]['cus_id']; ?>">
                                                                                        <select  name="customer_name" id="<?php echo $cumpony_id; ?>" class="customer_name_<?php echo $cumpony_id; ?> select_customer">
                                                                                            <option value="0">--Customers--</option>                                                                                                
                                                                                            <?php
                                                                                            foreach ($customer_per_company as $customers) {
                                                                                                $bold = ($customers['cus_manager'] == '1') ? 'select_customer1' : '';
                                                                                                ?>
                                                                                                <option value="<?php echo $customers['cus_id']; ?>" class="<?php echo $bold; ?>"><?php echo $customers['cus_contact_name']; ?></option>                                                                                                 <?php } ?>                                                                                               
                                                                                        </select>                                                                                            
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" height="70">
                                                                                    <!--                                                                                            <div id="jassim"></div>-->
                                                                                    <div id="msg_<?php echo $cumpony_id; ?>" class="cus_adm_succ_j"></div>
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

                                                                <tr>
                                                                    <?php 
                                                                    if($Prod['invoice_type'] == '7'){
                                                                    $invoice_type_set = "Weekly";
                                                                    }elseif ($Prod['invoice_type'] == '14') {
                                                                    $invoice_type_set = "Semi-Monthly";
                                                                    }elseif($Prod['invoice_type'] == '30'){
                                                                    $invoice_type_set = "Monthly";
                                                                    }elseif ($Prod['invoice_type'] == '0') {
                                                                    $invoice_type_set = "Select Type";
                                                                    }
                                                                    ?>
                                                                    <td align="left" width="30%" class="inf">
                                                                        <div style="width: 100%;float: left;margin-bottom: 3px;"> 
                                                                            <ul>
                                                                                <li>
                                                                                    <label style="font-weight: bold;">Invoice Frequency :</label>
                                                                                    <span style="cursor: pointer;" id="inv_type_<?php echo $cumpony_id; ?>" onclick="return select_inv_type('<?php echo $cumpony_id; ?>');"><?php echo $invoice_type_set; ?></span>
                                                                                    <select name="invoice_freq" class="invoice_freq_type none" id="invoice_freq_<?php echo $cumpony_id; ?>" onchange="return set_invoice_type('<?php echo $cumpony_id; ?>');">                                                                                        
                                                                                        <option value="0"  <?php if($Prod['invoice_type'] == '0'){ ?>selected="selected"<?php } ?>>Select Type</option>
                                                                                        <option value="7"  <?php if($Prod['invoice_type'] == '7'){ ?>selected="selected"<?php } ?>>Weekly</option>
                                                                                        <option value="14" <?php if($Prod['invoice_type'] == '14'){ ?>selected="selected"<?php } ?>>Semi-Weekly</option>
                                                                                        <option value="30" <?php if($Prod['invoice_type'] == '30'){ ?>selected="selected"<?php } ?>>Monthly</option>
                                                                                    </select>
                                                                                </li>
                                                                            </ul>
                                                                        </div>                                                                        
                                                                    </td>
                                                                    
                                                                    <td width="40%" class="inf">
                                                                        <table border="0">
                                                                            <tr>
                                                                                <td style="padding-top: 5px;">
                                                                                    <select  name="address_book" id="<?php echo $cumpony_id; ?>" class="address_book_<?php echo $cumpony_id; ?> select_address">
                                                                                        <option value="0">Address Book</option>
                                                                                        <?php
                                                                                        $address_book = AddressBookCompany($cumpony_id);
                                                                                        foreach ($address_book as $address) {
                                                                                            ?>                                                                                        
                                                                                            <option value="<?php echo $address['id']; ?>"><?php echo $address['company_name']; ?></option>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding-top: 5px;">
                                                                                    <div id="addressbook_info_<?php echo $cumpony_id; ?>">

                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>                                                                                
                                                                    </td>
                                                                    <td width="30%" class="inf" style="font-weight: bold;padding-left: 2px;">&nbsp;</td>
                                                                </tr>

                                                                <?php
                                                                $status_class = ($Prod['status'] == '1') ? 'action_sus' : 'action_rein';
                                                                $status_text = ($Prod['status'] == '1') ? 'SUSPEND' : 'REINSTATE';
                                                                ?>
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <span class="<?php echo $status_class; ?>" id="action_<?php echo $cumpony_id; ?>" onclick="return sus_reiv('<?php echo $cumpony_id; ?>');"><?php echo $status_text; ?></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                                <td colspan="3">
                                                                                    <div style="float:left;width:50%;font-weight: bold;">Customer Notes: </div>
                                                                                    <div style="float:left;width:50%;border:2px solid #F99B3E;height: 110px;">
                                                                                        <div id="cus_notes_<?php echo $cumpony_id; ?>" onclick="return edit_cus_notes('<?php echo $cumpony_id; ?>');" style="float:left;width:98%;margin-left: 3px;height: 75px;cursor: pointer;">
                                                                                            <?php echo $Prod['customer_notes']; ?>
                                                                                        </div>
                                                                                        <form name="myform">
                                                                                            <div id="cus_notes_edit_<?php echo $cumpony_id; ?>" style="float:left;width:98%;margin-left: 3px;margin-top: 5px;display: none;">
                                                                                                <textarea class="cus_notes_edit_txt_<?php echo $cumpony_id; ?>" id="cust_notes" style="width:98%;height: 75px;margin-left: 3px;" onKeyDown="limitText(this.form.cust_notes,this.form.countdown,256);" onKeyUp="limitText(this.form.cust_notes,this.form.countdown,256);"><?php echo $Prod['customer_notes']; ?></textarea>                                                                                
                                                                                                <div style="float:left;width:98%;margin-left: 3px;margin-bottom: 5px;margin-top: 3px;">
                                                                                                    <div style="float:left;width: 49%;text-align: left;">
                                                                                                       <input readonly type="text" name="countdown" size="5" id="countdown" value="256" style="width: 35px;border:1px solid #000;" />
                                                                                                    </div>
                                                                                                    <div style="float:left;width: 49%;text-align: right;">
                                                                                                        <span id="cus_notes_edit_can_<?php echo $cumpony_id; ?>"  onclick="return cancel_cust_notes('<?php echo $cumpony_id; ?>');" style="background: #D3412C;color: #FFF;padding: 2px 5px;text-transform: uppercase;border-radius: 5px;font-weight: bold;font-size: 11px;cursor: pointer;">CANCEL</span>
                                                                                                        <span id="cus_notes_edit_save_<?php echo $cumpony_id; ?>" onclick="return save_cust_notes('<?php echo $cumpony_id; ?>');" style="background: #009D59;color: #FFF;padding: 2px 5px;text-transform: uppercase;border-radius: 5px;font-weight: bold;font-size: 11px;cursor: pointer;">SAVE</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                            </table>
                                                            <span class="succ" id="succ" style="color:#007F2A;font-size: 12px;"  ></span>
                                                            <div id="mas_<?php echo $cumpony_id; ?>">
                                                                <div id="spl_<?php echo $cumpony_id; ?>">
                                                                    <table id="spl" width="755" align="center" cellspacing="0" cellpadding="0" style="margin:10px 0px; border: 2px solid #F99B3E; font-family:arial">
                                                                        <tr>
                                                                            <td bgcolor="#f1f1f1" height="38" align="left" valign="middle">
                                                                                <span style="padding-left:12px; font-weight: normal; font-size: 16px; color:#f68210;">Specific Pricing</span>
                                                                                <a href="print_special_proce.php?comp_id=<?php echo $cumpony_id; ?>" target="_blank" class="action_rein" style="float:right;text-decoration: none;margin-right: 15px;">PRINT</a>
                                                                            </td>
                                                                        </tr>                                                                  
                                                                        <tr>
                                                                            <td height="30" align="left" valign="middle" class="content_1">

                                                                                <!---Special Pricing Start --->   
            <!--                                                                                            <span class="acc-spl click_close_special_<?php //echo $cumpony_id;      ?>" id="<?php //echo $cumpony_id;      ?>" style="cursor: pointer;">Click Here to load the Special Price List..</span>
                                                                                <div id="spl_price_list_<?php //echo $cumpony_id;      ?>">
                                                                                
                                                                                </div>                                                                                                                                                                         -->
                                                                                <!---Special Pricing End --->     
                                                                                <table width="100%" > 
                                                                                    <tbody>
                                                                                        <tr style="background-color: #F9F2DE;border-bottom: 1px solid #FF7E00; color:#fff;">                                                                            
                                                                                            <td align="center" bgcolor="#f68210"  class="brdr">S.NO</td>
                                                                                            <td align="center" width="25%" valign="middle" bgcolor="#f68210"  class="brdr">Super Category</td>
                                                                                            <td align="center" width="5%" valign="middle" bgcolor="#f68210"  class="brdr">Category</td>
                                                                                            <td align="center" width="20%" valign="middle" bgcolor="#f68210"  class="brdr">Sub Category</td>
                                                                                            <td align="center" width="20%" valign="middle" bgcolor="#f68210"  class="brdr">Product Name</td>
                                                                                            <td align="center" width="15%" valign="middle" bgcolor="#f68210"  class="brdr">List Price</td>
                                                                                            <td align="center" width="5%" valign="middle" bgcolor="#f68210"  class="brdr">Discount(%)</td>
                                                                                            <td align="center" width="35%" valign="middle" bgcolor="#f68210"  class="brdr">Selling Price</td>                                                                            
                                                                                            <td align="center" width="" valign="middle" bgcolor="#f68210"  class="brdr">Action</td>
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

                                                                            </td>                                                                            
                                                                        </tr> 
                                                                    </table>
                                                                </div>
                                                                <table width="755" align="center" cellspacing="0" cellpadding="0" style="margin:10px 0px; border: 2px solid #F99B3E; font-family:arial">
                                                                    <tr>
                                                                        <td bgcolor="#f1f1f1" height="38" align="left" valign="middle">
                                                                            <span style="padding-left:12px; font-weight: normal; font-size: 16px; color:#f68210;">Master Price List</span>
                                                                            <a class="fav_button" href="edit_fav.php?comp_id=<?php echo $cumpony_id; ?>&page=<?php echo $page; ?>" style="float:right;text-decoration: none;margin-right: 15px;">FAVORITES</a>
                                                                        </td>
                                                                    </tr> 

                                                                    <tr>
                                                                        <td height="30" align="left" valign="middle">
                                                                            <span class="acc-cat click_close_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>">Click Here to load the Master Price List..</span>
                                                                            <div id="cateacc_<?php echo $cumpony_id; ?>">

                                                                            </div>                                                                            
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
                                            
                                        </table>
                                        
                                        <?php echo Paginations($limit, $page, 'customers.php?cus_type_fil='.$_GET['cus_type_fil'].'&admin_added='.$_GET['admin_added'].'&page=', $rows); ?>
                                        <!-- Customer Filter By End -->                                        
                                    <?php
                                    }else { ?>
                                        <table width="800" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="36" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">NO.</td>                                                        
                                                <td width="100" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="customers.php?sort=<?php echo $sort_sku; ?>">Company Name&nbsp;<img src="images/<?php echo $sort_sku_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>                                                                                                                
                                                <?php if ($_SESSION['admin_user_type'] == '1') { ?>
                                                    <td width="64" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                <?php } ?>
                                            </tr>                                                
                                            <?php
                                            $i = 1;
                                            if (count($users) > 0) {
                                                if ($last_element != '') {
                                                    $i = ((($last_element * 25) - 25) + 1);
                                                } else {
                                                    $i = 1;
                                                }
                                                foreach ($users as $Prod) {
                                                    $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                    $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                    $id = $Prod['cus_id'];
                                                    $cumpony_id = $Prod['comp_id'];
                                                    $cus_email = $Prod['cus_email'];
                                                    $cus_regdate = date("m-d-Y", strtotime($Prod['cus_regdate']));
                                                    $company_name = $Prod['comp_name'];
                                                    $cust_id = ($Prod['cust_id'] != '') ? $Prod['cust_id'] : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                                    $user_address1 = ($Prod['comp_business_address1'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $Prod['comp_business_address1'];
                                                    $user_address2 = ($Prod['comp_business_address2'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $Prod['comp_business_address2'];
                                                    $user_address3 = ($Prod['comp_business_address3'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $Prod['comp_business_address3'];
                                                    $user_suit     = ($Prod['comp_room'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $Prod['comp_room'];
                                                    $company_phone = ($Prod['comp_contact_phone'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $Prod['comp_contact_phone'];
                                                    $company_fax = $Prod['comp_contact_fax'];
                                                    $company_city = $Prod['comp_city'];
                                                    $state_abbr = ($Prod['comp_state'] != '') ? $Prod['comp_state'] : '---';
                                                    
                                                    $company_zip = $Prod['comp_zipcode'];
                                                    $company_zip_ext = $Prod['comp_zipcode_ext'];
                                                    $tax = ($Prod['tax_exe'] == 1) ? 'Yes' : 'No';
                                                    $tax_excempt_number = $Prod['tax_exempt_number'];
                                                    $status = ($Prod['status'] == 1) ? 'active' : 'de-active';
                                                    if (($_SESSION['admin_user_type'] == '2') && ($Prod['status'] == 1)) {
                                                        $staff_prev = '';
                                                    } else {
                                                        $staff_prev = 'status';
                                                    }
                                                    $deleivery_address = ShippingAddressAllInfo($cumpony_id);
                                                    $deleivery_state = ($deleivery_address[0]['state'] != '') ? $deleivery_address[0]['state'] : '---';
                                                    ?>                                                
                                                    <tr class="trigger" id="<?php echo $Prod['comp_id']; ?>">
                                                        <td width="49"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>                                                                
                                                        <td width="100" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="pad_btm"><span class="company_name_<?php echo $cumpony_id; ?>"><?php echo $company_name; ?></span></td>                                                                
                                                        <?php if ($_SESSION['admin_user_type'] == '1') { ?>
                                                            <td width="80"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm">
                                                                <a href="#edit_user.php?id=<?php echo $id; ?>"><img src="images/edit.png"  alt="Edit" title="Edit" width="22" height="22"/></a>
                                                                <a href="customers.php?delete_id=<?php echo $cumpony_id; ?>&page=<?php echo $last_element; ?>" onclick="return confirm('Are you sure?');"><img src="images/del.png"  alt="Delete" title="Delete" width="22" height="22" class="mar_lft"/></a></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr class="test_<?php echo $Prod['comp_id']; ?>" style="display: none;">
                                                        <td colspan="<?php echo ($_SESSION['admin_user_type'] == '1') ? '3' : '2'; ?>">
                                                            <table width="100%" border="0">
                                                                <tr>
                                                                    <td colspan="3" align="center">
                                                                        <span id="succ_resend_<?php echo $cumpony_id; ?>" style="color:#007F2A;"></span> 
                                                                        <span id="fail_alert_<?php echo $cumpony_id; ?>" style="color:#F00;"></span> 
                                                                    </td>
                                                                </tr>
                                                                <tr valign="top">
                                                                    <td width="33%" style="height: 30px;text-align: left;padding-left: 2px;">
                                                                        <span style="font-weight: bold;float:left;">Cust. ID :&nbsp;&nbsp;</span>
                                                                        <span style="cursor: pointer;" class="cust_inline cust_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $cust_id; ?></span>
                                                                        <span style="float:left;" class="none cust_comp_lbl_<?php echo $cumpony_id; ?>"></span><input style="float:left;width: 110px;" type="text" class="none cust_inline_txt_<?php echo $cumpony_id; ?>" id="cust_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $cust_id; ?>" />
                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="cust_update cust_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="cust_cancel cust_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>   
                                                                    </td>
                                                                    <td width="33%" style="text-align: left;padding-left: 2px;">
                                                                        <span style="font-weight: bold;float:left;">Company :&nbsp;&nbsp;</span>
                                                                        <span style="cursor: pointer;" class="bus_inline bus_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_name; ?></span>
                                                                        <span style="float:left;" class="none bus_comp_lbl_<?php echo $cumpony_id; ?>"></span><input style="float:left;width: 110px;" type="text" class="none bus_inline_txt_<?php echo $cumpony_id; ?>" id="bus_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_name; ?>" />
                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="cn_update cn_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="cn_cancel cn_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                    
                                                                    </td>
                                                                    <?php
                                                                    if($Prod['cus_type'] == '0'){
                                                                    $cus_type = 'Customers';
                                                                    }elseif ($Prod['cus_type'] == '1') {
                                                                    $cus_type = 'Cash Customer';
                                                                    }elseif($Prod['cus_type'] == '2'){
                                                                    $cus_type = 'Customers';   
                                                                    }
                                                                    ?>
                                                                    <td width="34%"><span style="font-weight: bold;">Cust. Type :</span> <?php echo $cus_type; ?></td>
                                                                </tr>
                                                                <tr align="left" style="text-align: left;">
                                                                    <td width="33%" class="inf" style="font-weight: bold;padding-left: 2px;">Business Info</td>
                                                                    <td width="33%" class="inf" style="font-weight: bold;padding-left: 2px;">Delivery Info</td>
                                                                    <td width="34%" class="inf" style="font-weight: bold;padding-left: 2px;">User Info</td>
                                                                </tr>
                                                                <tr valign="top">                                                                        
                                                                    <!--Business Table Start-->
                                                                    <td align="left" width="250" style="text-align: left;">
                                                                        <table border="0" width="325"> 
                                                                            <tr>                                                                                       
                                                                                <td>
                                                                                    <strong style="float:left;">A1 :&nbsp;</strong><span style="cursor: pointer;" class="bus_add1_inline bus_add1_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_address1; ?></span>
                                                                                    <span style="float:left;" class="none bus_add1_lbl_<?php echo $cumpony_id; ?>"></span><input style="float:left;width: 150px;" type="text" class="none bus_add1_inline_txt_<?php echo $cumpony_id; ?>" id="bus_add1_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_address1; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad1_update ad1_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad1_cancel ad1_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                            $user_address2_ori = ($user_address2 == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $user_address2;
                                                                            ?>
                                                                            <tr>
                                                                                <td align="left">
                                                                                    <strong style="float:left;">A2 :&nbsp;</strong><span style="cursor: pointer;" class="bus_add2_inline bus_add2_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_address2_ori; ?></span>
                                                                                    <span style="float:left;" class="none bus_add2_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none bus_add2_inline_txt_<?php echo $cumpony_id; ?>" id="bus_add2_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_address2_ori; ?>" />
                                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad2_update ad2_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad2_cancel ad2_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                            $user_address3_ori = ($user_address3 == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $user_address3;
                                                                            ?>
                                                                            <tr>
                                                                                <td align="left">
                                                                                    <strong style="float:left;">A3 :&nbsp;</strong><span style="cursor: pointer;" class="bus_add3_inline bus_add3_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_suit; ?></span>
                                                                                    <span style="float:left;" class="none bus_add3_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none bus_add3_inline_txt_<?php echo $cumpony_id; ?>" id="bus_add3_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_suit; ?>" />
                                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad3_update ad3_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad3_cancel ad3_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                </td>
                                                                            </tr>                                                                            
                                                                            <!--<tr>
                                                                                <td align="left">
                                                                                    <strong style="float:left;">S# :&nbsp;</strong><span style="cursor: pointer;" class="bus_suit_inline bus_suit_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $user_suit; ?></span>
                                                                                    <span style="float:left;" class="none bus_suit_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none bus_suit_inline_txt_<?php echo $cumpony_id; ?>" id="bus_suit_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $user_suit; ?>" />
                                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="suit_update suit_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="suit_cancel suit_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                </td>
                                                                            </tr>-->
                                                                            <tr>                                                                                        
                                                                                <td align="left" width="500">
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <table>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <span style="cursor: pointer;" class="bus_city_inline bus_city_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_city; ?>,&nbsp;</span>
                                                                                                            <input style="float:left; width: 60px;" type="text" class="none bus_city_inline_txt_<?php echo $cumpony_id; ?>" id="bus_city_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_city; ?>" />
                                                                                                            <span style="float:left; margin:0 0px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="city_update city_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                            <span style="float:left;  margin:0 0px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="city_cancel city_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <span style="cursor: pointer;margin-left: -2px;" class="bus_stat_inline bus_stat_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $state_abbr; ?></span>&nbsp;
                                                                                                            <select name="state" id="<?php echo $cumpony_id; ?>" class="none bus_state bus_stat_inline_txt_<?php echo $cumpony_id; ?>" >                    
                                                                                                                <?php
                                                                                                                $state = StateAll();
                                                                                                                if ($state_abbr == "---") {
                                                                                                                    ?>
                                                                                                                    <option value="<?php echo $state_abbr; ?>" selected="selected"><?php echo $state_abbr; ?></option>
                                                                                                                <?php
                                                                                                                }
                                                                                                                foreach ($state as $state_val) {
                                                                                                                    if ($state_val['state_abbr'] == $state_abbr) {
                                                                                                                        ?>
                                                                                                                        <option value="<?php echo $state_val['state_abbr'] ?>" selected="selected"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                                    <?php } else { ?>
                                                                                                                        <option value="<?php echo $state_val['state_abbr']; ?>"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                                        <?php
                                                                                                                    }
                                                                                                                }
                                                                                                                ?>
                                                                                                            </select>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <span>
                                                                                                                <span style="cursor: pointer;margin-left: -5px;" class="bus_zip_inline bus_zip_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_zip; ?></span>
                                                                                                                <input style="width: 40px;" type="text" class="none comp_zip bus_zip_inline_txt_<?php echo $cumpony_id; ?>" id="bus_zip_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_zip; ?>" />
                                                                                                                <span style="float:right; margin:0 0px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_cancel zip_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                <span style="float:right;"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="zip_update zip_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                            </span>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <?php
                                                                                                            $company_zip_ext_ori = ($company_zip_ext == '0') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : '-' .$company_zip_ext;
                                                                                                            ?>
                                                                                                            <span>
                                                                                                                <span style="cursor: pointer;margin-left: 0px;" class="bus_zip_inline_ext bus_zip_inline_span_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_zip_ext_ori; ?></span>
                                                                                                                <input style="width: 40px;" type="text" class="none comp_zip_ext bus_zip_inline_txt_ext_<?php echo $cumpony_id; ?>" id="bus_zip_inline_txt_ext_<?php echo $cumpony_id; ?>" value="<?php echo $company_zip_ext_ori; ?>" />
                                                                                                                <span style="float:right; margin:0 0px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_cancel_ext zip_cancel_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                <span style="float:right;"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="zip_update_ext zip_update_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                            </span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table> 
                                                                                </td>
                                                                            </tr>                                                                                     
                                                                            <tr>                                                                                        
                                                                                <td>
                                                                                    <span style="float:left;"><strong>P : </strong></span>
                                                                                    <span style="cursor: pointer;" class="bus_phone_inline bus_phone_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_phone; ?></span>
                                                                                    <input style="width: 80px;" type="text" class="none comp_phone bus_phone_inline_txt_<?php echo $cumpony_id; ?>" id="bus_phone_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_phone; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="phone_update phone_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="phone_cancel phone_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr> 
                                                                            <tr>                                                                                        
                                                                                <td>                                                                                           
                                                                                    <span style="float:left;"><strong>F : </strong></span>                                                                                            
                                                                                    <span style="cursor: pointer;" class="bus_fax_inline bus_fax_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_fax; ?></span>
                                                                                    <input style="width: 80px;" type="text" class="none comp_fax bus_fax_inline_txt_<?php echo $cumpony_id; ?>" id="bus_fax_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $company_fax; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="fax_update fax_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="fax_cancel fax_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr> 
                                                                            <tr>
                                                                                <td class="inf">Tax Exemption&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                                                                            
                                                                                    <span style="cursor: pointer;" class="bus_tax_inline bus_tax_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $tax; ?></span>
                                                                                    <select name="tax" id="<?php echo $cumpony_id; ?>" class="none bus_tax bus_tax_inline_txt_<?php echo $cumpony_id; ?>" >                                                                                                                   
                                                                                        <option value="1" <?php if ($tax == 'Yes') { ?> selected="selected" <?php } ?>>Yes</option>                                                                                                    
                                                                                        <option value="0" <?php if ($tax == 'No') { ?> selected="selected" <?php } ?>>No</option>                                                                                                    
                                                                                    </select>

                                                                                </td>                                                                                            
                                                                            </tr>
            <?php if ($Prod['tax_exe'] == '1') { ?>                                                                                        
                                                                                <tr class="tax_exempt_number_row_view_<?php echo $cumpony_id; ?>">
                                                                                    <td>Tax ID : &nbsp;
                                                                                        <span class="tax_exempt_number_span_<?php echo $cumpony_id ?>"><?php echo $tax_excempt_number; ?></span>                                                                                                
                                                                                    </td>                                                                                             
                                                                                </tr> 
            <?php } ?>
                                                                            <tr class="none tax_exempt_number_row_<?php echo $cumpony_id; ?>">
                                                                                <td>
                                                                                    <span style="float: left;">Tax ID : &nbsp;</span>
                                                                                    <span class="tax_exempt_number_span_<?php echo $cumpony_id ?>"><?php //echo $tax_excempt_number;     ?></span>
                                                                                    <input type="text" name="tax_exempt_number" class="tax_exempt_number_<?php echo $cumpony_id; ?>" id="tax_exempt_number_<?php echo $cumpony_id; ?>" style="float: left;width: 90px;" autofocus="autofocus" value="<?php echo $tax_form_excempt; ?>" />
                                                                                    <div style="float:left; margin:0 4px">
                                                                                        <img src="images/like_icon.png" style="margin-top:-3px;" alt="Update" title="Update" width="22" height="22" class="tax_exempt_update tax_exempt_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" />
                                                                                    </div>
                                                                                </td>                                                                                             
                                                                            </tr>                                                                                    
                                                                        </table>
                                                                    </td>
                                                                    <!--Business Table END-->
                                                                    <!--Delivery Address Start-->
                                                                    <td width="250" style="text-align: left;">
                                                                        <table border="0" width="300"> 
                                                                            <tr>                                                                                       
                                                                                <td>
                                                                                    <?php
                                                                                    $del_add_1 = ($deleivery_address[0]['address_1'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['address_1'];
                                                                                    ?>
                                                                                    <span style="float:left;"><strong>A1 :&nbsp;</strong></span><span style="cursor: pointer;" class="del_add1_inline del_add1_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_add_1; ?></span>                                                                                                                                                                        
                                                                                    <input style="float:left;width:140px;" type="text" class="none del_add1_inline_txt_<?php echo $cumpony_id; ?>" id="del_add1_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $del_add_1; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad1_del_update ad1_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad1_del_cancel ad1_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td align="left">
                                                                                    <?php
                                                                                    $del_add_2 = ($deleivery_address[0]['address_2'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['address_2'];
                                                                                    ?>
                                                                                    <span style="float:left;"><strong>A2 :&nbsp;</strong></span><span style="cursor: pointer;" class="del_add2_inline del_add2_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_add_2; ?></span>   
                                                                                    <input style="float:left; width: 140px;" type="text" class="none del_add2_inline_txt_<?php echo $cumpony_id; ?>" id="del_add2_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $del_add_2; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad2_del_update ad2_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad2_del_cancel ad2_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                            $suite_del = ($deleivery_address[0]['suite'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['suite'];
                                                                            ?>
                                                                            <tr>                                                                                       
                                                                                <td>
                                                                                    <span style="float:left;"><strong>A3 :&nbsp;</strong></span><span style="cursor: pointer;" class="del_add3_inline del_add3_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $suite_del; ?></span>                                                                                                                                                                        
                                                                                    <input style="float:left;width: 140px;" type="text" class="none del_add3_inline_txt_<?php echo $cumpony_id; ?>" id="del_add3_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $suite_del; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="ad3_del_update ad3_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="ad3_del_cancel ad3_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                            //$suite_del = ($deleivery_address[0]['suite'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['suite'];
                                                                            ?>
                                                                            <!--<tr>
                                                                                <td align="left">
                                                                                    <strong style="float:left;">S# :&nbsp;</strong><span style="cursor: pointer;" class="del_suit_inline del_suit_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $suite_del; ?></span>
                                                                                    <span style="float:left;" class="none del_suit_lbl_<?php echo $cumpony_id; ?>"><input style="float:left; width: 150px;" type="text" class="none del_suit_inline_txt_<?php echo $cumpony_id; ?>" id="del_suit_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $suite_del; ?>" />
                                                                                        <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="suit_update_del suit_update_del_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                        <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="suit_cancel_del suit_cancel_del_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>                                                                                             
                                                                                </td>
                                                                            </tr>-->
                                                                            <tr>                                                                                        
                                                                                <td align="left" width="500">
                                                                                    <table align="left">
                                                                                        <tr align="left">
                                                                                            <td align="left">
                                                                                                <table border="0">
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <span style="cursor: pointer;" class="del_city_inline del_city_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $deleivery_address[0]['city']; ?></span>,
                                                                                                            <input style="float:left; width: 60px;" type="text" class="none del_city_inline_txt_<?php echo $cumpony_id; ?>" id="del_city_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $deleivery_address[0]['city']; ?>" />
                                                                                                            <span style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="city_del_update city_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                            <span style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="city_del_cancel city_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <span style="cursor: pointer;margin-left: -17px;" class="del_stat_inline del_stat_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_state = ($deleivery_address[0]['state'] != '') ? StateName($deleivery_address[0]['state']) : '---'; ?></span>&nbsp;
                                                                                                            <select name="state" id="<?php echo $cumpony_id; ?>" class="none del_state del_stat_inline_txt_<?php echo $cumpony_id; ?>" >                    
                                                                                                                <?php
                                                                                                                $state = StateAll();
                                                                                                                if ($deleivery_state == "---") {
                                                                                                                    ?>
                                                                                                                    <option value="<?php echo $deleivery_state; ?>" selected="selected"><?php echo $deleivery_state; ?></option>
                                                                                                                <?php
                                                                                                                }
                                                                                                                foreach ($state as $state_val) {
                                                                                                                    if ($state_val['state_id'] == $deleivery_address[0]['state']) {
                                                                                                                        ?>
                                                                                                                        <option value="<?php echo $state_val['state_abbr'] ?>" selected="selected"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                                    <?php } else { ?>
                                                                                                                        <option value="<?php echo $state_val['state_abbr']; ?>"><?php echo $state_val['state_abbr']; ?></option>
                                                                                                                        <?php
                                                                                                                    }
                                                                                                                }
                                                                                                                ?>
                                                                                                            </select>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <span style="cursor: pointer;margin-left: -5px;" class="del_zip_inline del_zip_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_zip = ($deleivery_address[0]['zip'] != '') ? '&nbsp;'.$deleivery_address[0]['zip'] : '&nbsp;&nbsp;ZIP'; ?></span>
                                                                                                            <input style="width: 40px;" type="text" class="none del_comp_zip del_zip_inline_txt_<?php echo $cumpony_id; ?>" id="del_zip_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $deleivery_address[0]['zip']; ?>" />
                                                                                                            <span style="float:right; margin:0 0px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_del_cancel zip_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                            <span style="float:right;  margin: 0 0px 0 0px;"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="zip_del_update zip_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <?php
                                                                                                            $devilery_zip_ext = ($deleivery_address[0]['zip_ext'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : '-' .$deleivery_address[0]['zip_ext'];
                                                                                                            ?>
                                                                                                            <span>
                                                                                                                <span style="cursor: pointer;margin-left: 0px;" class="zip_inline_del_ext zip_inline_span_del_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $devilery_zip_ext; ?></span>
                                                                                                                <input style="width: 40px;" type="text" class="none comp_zip_del_ext zip_inline_txt_del_ext_<?php echo $cumpony_id; ?>" id="zip_inline_txt_del_ext_<?php echo $cumpony_id; ?>" value="<?php echo $devilery_zip_ext; ?>" />
                                                                                                                <span style="float:right; margin:0 0px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_cancel_del_ext zip_cancel_del_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                                <span style="float:right;"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="zip_update_del_ext zip_update_del_ext_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></span>
                                                                                                            </span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
            <?php //echo $deleivery_address[0]['city'].','.StateName($deleivery_address[0]['state']).'&nbsp;'.$deleivery_address[0]['zip'];    ?>                                                                                                
                                                                                            </td> 
                                                                                        </tr>
                                                                                    </table> 
                                                                                </td>
                                                                            </tr>                                                                                     
                                                                            <tr>                                                                                        
                                                                                <td>
            <?php $del_phone = ($deleivery_address[0]['phone'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $deleivery_address[0]['phone']; ?>
                                                                                    <span class="del_phone_head_inline_span_<?php echo $cumpony_id; ?>"><strong>P : </strong></span>
                                                                                    <span style="cursor: pointer;" class="del_phone_inline del_phone_inline_span_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $del_phone; ?></span>
                                                                                    <input style="width: 80px;" type="text" class="none comp_phone del_phone_inline_txt_<?php echo $cumpony_id; ?>" id="del_phone_inline_txt_<?php echo $cumpony_id; ?>" value="<?php echo $deleivery_address[0]['phone']; ?>" />
                                                                                    <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="phone_del_update phone_del_update_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                    <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="phone_del_cancel phone_del_cancel_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>" /></div>
                                                                                </td>
                                                                            </tr> 
            <!--                                                                            <tr>                                                                                        
                                                                                <td>                                                                                           
                                                                                    <span class="<?php echo $cumpony_id; ?>"><strong>F : </strong></span>                                                                                            
                                                                                    <span style="cursor: pointer;" class="bus_fax_inline_span_del_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>"><?php echo $company_fax; ?></span>                                                                                    
                                                                                </td>
                                                                            </tr>-->
                                                                            <tr>                                                                                        
                                                                                <td>&nbsp;</td>
                                                                            </tr>

                                                                        </table>
                                                                    </td>
                                                                    <!--Delivery Address End -->
                                                                    <!--Business Table Start End-->
            <?php $customer_per_company = custPerComp($cumpony_id); ?>
                                                                    <!--Personal Table Start-->
                                                                    <td align="left" style="text-align: left;">
                                                                        <table border="0" width="265">
                                                                            <tr>
                                                                                <td class="inf">Select User</td>
                                                                                <td align="left" style="padding-right: 60px;">
                                                                                    <span class="cus_id none" id="<?php echo $customer_per_company[0]['cus_id']; ?>"></span> 
                                                                                    <div id="user_select_box_<?php echo $cumpony_id; ?>_<?php echo $customer_per_company[0]['cus_id']; ?>">
                                                                                        <select  name="customer_name" id="<?php echo $cumpony_id; ?>" class="customer_name_<?php echo $cumpony_id; ?> select_customer">
                                                                                            <option value="0">--Customers--</option>                                                                                                
                                                                                            <?php
                                                                                            foreach ($customer_per_company as $customers) {
                                                                                                $bold = ($customers['cus_manager'] == '1') ? 'select_customer1' : '';
                                                                                                ?>
                                                                                                <option value="<?php echo $customers['cus_id']; ?>" class="<?php echo $bold; ?>"><?php echo $customers['cus_contact_name']; ?></option>                                                                                                 <?php } ?>                                                                                               
                                                                                        </select>                                                                                            
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" height="70">
                                                                                    <!--                                                                                            <div id="jassim"></div>-->
                                                                                    <div id="msg_<?php echo $cumpony_id; ?>" class="cus_adm_succ_j"></div>
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

                                                                <tr>
                                                                    <?php 
                                                                    if($Prod['invoice_type'] == '7'){
                                                                    $invoice_type_set = "Weekly";
                                                                    }elseif ($Prod['invoice_type'] == '14') {
                                                                    $invoice_type_set = "Semi-Monthly";
                                                                    }elseif($Prod['invoice_type'] == '30'){
                                                                    $invoice_type_set = "Monthly";
                                                                    }elseif ($Prod['invoice_type'] == '0') {
                                                                    $invoice_type_set = "Select Type";
                                                                    }
                                                                    ?>
                                                                    <td align="left" width="30%" class="inf">
                                                                        <div style="width: 100%;float: left;margin-bottom: 3px;"> 
                                                                            <ul>
                                                                                <li>
                                                                                    <label style="font-weight: bold;">Invoice Frequency :</label>
                                                                                    <span style="cursor: pointer;" id="inv_type_<?php echo $cumpony_id; ?>" onclick="return select_inv_type('<?php echo $cumpony_id; ?>');"><?php echo $invoice_type_set; ?></span>
                                                                                    <select name="invoice_freq" class="invoice_freq_type none" id="invoice_freq_<?php echo $cumpony_id; ?>" onchange="return set_invoice_type('<?php echo $cumpony_id; ?>');">                                                                                        
                                                                                        <option value="0"  <?php if($Prod['invoice_type'] == '0'){ ?>selected="selected"<?php } ?>>Select Type</option>
                                                                                        <option value="7"  <?php if($Prod['invoice_type'] == '7'){ ?>selected="selected"<?php } ?>>Weekly</option>
                                                                                        <option value="14" <?php if($Prod['invoice_type'] == '14'){ ?>selected="selected"<?php } ?>>Semi-Weekly</option>
                                                                                        <option value="30" <?php if($Prod['invoice_type'] == '30'){ ?>selected="selected"<?php } ?>>Monthly</option>
                                                                                    </select>
                                                                                </li>
                                                                            </ul>
                                                                        </div>                                                                        
                                                                    </td>
                                                                    
                                                                    <td width="40%" class="inf">
                                                                        <table border="0">
                                                                            <tr>
                                                                                <td style="padding-top: 5px;">
                                                                                    <select  name="address_book" id="<?php echo $cumpony_id; ?>" class="address_book_<?php echo $cumpony_id; ?> select_address">
                                                                                        <option value="0">Address Book</option>
                                                                                        <?php
                                                                                        $address_book = AddressBookCompany($cumpony_id);
                                                                                        foreach ($address_book as $address) {
                                                                                            ?>                                                                                        
                                                                                            <option value="<?php echo $address['id']; ?>"><?php echo $address['company_name']; ?></option>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding-top: 5px;">
                                                                                    <div id="addressbook_info_<?php echo $cumpony_id; ?>">

                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>                                                                                
                                                                    </td>
                                                                    <td width="30%" class="inf" style="font-weight: bold;padding-left: 2px;">&nbsp;</td>
                                                                </tr>

                                                                <?php
                                                                $status_class = ($Prod['status'] == '1') ? 'action_sus' : 'action_rein';
                                                                $status_text = ($Prod['status'] == '1') ? 'SUSPEND' : 'REINSTATE';
                                                                ?>
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <span class="<?php echo $status_class; ?>" id="action_<?php echo $cumpony_id; ?>" onclick="return sus_reiv('<?php echo $cumpony_id; ?>');"><?php echo $status_text; ?></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3">                                                                        
                                                                        <div style="float:left;width:50%;font-weight: bold;">Customer Notes: </div>
                                                                        <div style="float:left;width:50%;border:2px solid #F99B3E;height: 110px;">
                                                                            <div id="cus_notes_<?php echo $cumpony_id; ?>" onclick="return edit_cus_notes('<?php echo $cumpony_id; ?>');" style="float:left;width:98%;margin-left: 3px;height: 75px;cursor: pointer;">
                                                                                <?php echo $Prod['customer_notes']; ?>
                                                                            </div>
                                                                            <form name="myform">
                                                                                <div id="cus_notes_edit_<?php echo $cumpony_id; ?>" style="float:left;width:98%;margin-left: 3px;margin-top: 5px;display: none;">
                                                                                    <textarea class="cus_notes_edit_txt_<?php echo $cumpony_id; ?>" id="cust_notes" style="width:98%;height: 75px;margin-left: 3px;" onKeyDown="limitText(this.form.cust_notes,this.form.countdown,256);" onKeyUp="limitText(this.form.cust_notes,this.form.countdown,256);"><?php echo $Prod['customer_notes']; ?></textarea>                                                                                
                                                                                    <div style="float:left;width:98%;margin-left: 3px;margin-bottom: 5px;margin-top: 3px;">
                                                                                        <div style="float:left;width: 49%;text-align: left;">
                                                                                           <input readonly type="text" name="countdown" size="5" id="countdown" value="256" style="width: 35px;border:1px solid #000;" />
                                                                                        </div>
                                                                                        <div style="float:left;width: 49%;text-align: right;">
                                                                                            <span id="cus_notes_edit_can_<?php echo $cumpony_id; ?>"  onclick="return cancel_cust_notes('<?php echo $cumpony_id; ?>');" style="background: #D3412C;color: #FFF;padding: 2px 5px;text-transform: uppercase;border-radius: 5px;font-weight: bold;font-size: 11px;cursor: pointer;">CANCEL</span>
                                                                                            <span id="cus_notes_edit_save_<?php echo $cumpony_id; ?>" onclick="return save_cust_notes('<?php echo $cumpony_id; ?>');" style="background: #009D59;color: #FFF;padding: 2px 5px;text-transform: uppercase;border-radius: 5px;font-weight: bold;font-size: 11px;cursor: pointer;">SAVE</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <span class="succ" id="succ" style="color:#007F2A;font-size: 12px;"  ></span>
                                                            <div id="mas_<?php echo $cumpony_id; ?>">
                                                                <div id="spl_<?php echo $cumpony_id; ?>">
                                                                    <table id="spl" width="755" align="center" cellspacing="0" cellpadding="0" style="margin:10px 0px; border: 2px solid #F99B3E; font-family:arial">
                                                                        <tr>
                                                                            <td bgcolor="#f1f1f1" height="38" align="left" valign="middle">
                                                                                <span style="padding-left:12px; font-weight: normal; font-size: 16px; color:#f68210;">Specific Pricing</span>
                                                                                <a href="print_special_proce.php?comp_id=<?php echo $cumpony_id; ?>" target="_blank" class="action_rein" style="float:right;text-decoration: none;margin-right: 15px;">PRINT</a>
                                                                            </td>
                                                                        </tr>                                                                  
                                                                        <tr>
                                                                            <td height="30" align="left" valign="middle" class="content_1">

                                                                                <!---Special Pricing Start --->   
            <!--                                                                                            <span class="acc-spl click_close_special_<?php //echo $cumpony_id;      ?>" id="<?php //echo $cumpony_id;      ?>" style="cursor: pointer;">Click Here to load the Special Price List..</span>
                                                                                <div id="spl_price_list_<?php //echo $cumpony_id;      ?>">
                                                                                
                                                                                </div>                                                                                                                                                                         -->
                                                                                <!---Special Pricing End --->     
                                                                                <table width="100%" > 
                                                                                    <tbody>
                                                                                        <tr style="background-color: #F9F2DE;border-bottom: 1px solid #FF7E00; color:#fff;">                                                                            
                                                                                            <td align="center" bgcolor="#f68210"  class="brdr">S.NO</td>
                                                                                            <td align="center" width="25%" valign="middle" bgcolor="#f68210"  class="brdr">Super Category</td>
                                                                                            <td align="center" width="5%" valign="middle" bgcolor="#f68210"  class="brdr">Category</td>
                                                                                            <td align="center" width="20%" valign="middle" bgcolor="#f68210"  class="brdr">Sub Category</td>
                                                                                            <td align="center" width="20%" valign="middle" bgcolor="#f68210"  class="brdr">Product Name</td>
                                                                                            <td align="center" width="15%" valign="middle" bgcolor="#f68210"  class="brdr">List Price</td>
                                                                                            <td align="center" width="5%" valign="middle" bgcolor="#f68210"  class="brdr">Discount(%)</td>
                                                                                            <td align="center" width="35%" valign="middle" bgcolor="#f68210"  class="brdr">Selling Price</td>                                                                            
                                                                                            <td align="center" width="" valign="middle" bgcolor="#f68210"  class="brdr">Action</td>
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

                                                                            </td>                                                                            
                                                                        </tr> 
                                                                    </table>
                                                                </div>
                                                                <table width="755" align="center" cellspacing="0" cellpadding="0" style="margin:10px 0px; border: 2px solid #F99B3E; font-family:arial">
                                                                    <tr>
                                                                        <td bgcolor="#f1f1f1" height="38" align="left" valign="middle">
                                                                            <span style="padding-left:12px; font-weight: normal; font-size: 16px; color:#f68210;">Master Price List</span>
                                                                            <a class="fav_button" href="edit_fav.php?comp_id=<?php echo $cumpony_id; ?>&page=<?php echo $page; ?>" style="float:right;text-decoration: none;margin-right: 15px;">FAVORITES</a>
                                                                        </td>
                                                                    </tr> 

                                                                    <tr>
                                                                        <td height="30" align="left" valign="middle">
                                                                            <span class="acc-cat click_close_<?php echo $cumpony_id; ?>" id="<?php echo $cumpony_id; ?>">Click Here to load the Master Price List..</span>
                                                                            <div id="cateacc_<?php echo $cumpony_id; ?>">

                                                                            </div>                                                                            
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
                                            <!--Pagination End-->
                                        </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
    <?php echo Paginations($limit, $page, 'customers.php?page=', $rows); ?>
                                </td>
                            </tr>  
                            <?php
                        }
                        ?>
                        </div>   


                    </table>
                </td>
            </tr>
        </table></td>
</tr>
<tr>
    <td style="background:#464646; text-align:center; color:#fff; line-height:30px;" height="30p">© <?php echo date("Y"); ?> sohorepro.com</td>
</tr>
</table>

</body>
</html>




<script type="text/javascript">


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

        $('.inline').click(function()
        {
            var ID = $(this).attr('id');
            //alert(ID);
            $(".list_price_c_" + ID).hide();
            $(".discount_price_c_" + ID).hide();
            $(".special_price_c_" + ID).hide();
            $(".edit_c_" + ID).hide();
            $(".list_price_txt_c_" + ID).show();
            $(".discount_price_txt_c_" + ID).show();
            $(".special_price_txt_c_" + ID).show();
            $(".update_c_" + ID).show();
            $(".jass_p").attr("id", ID);
        });

<?php if ($_SESSION['admin_user_type'] == '1') { ?>

            $('.bus_inline').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".bus_inline_span_" + ID).hide();
                $(".bus_inline_txt_" + ID).css("display", "inline-block");
                $(".bus_comp_lbl_" + ID).css("display", "inline-block");
                $(".cn_update_" + ID).css("display", "inline-block");
                $(".cn_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });

            $('.cn_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_inline_span_" + ID).show();
                $(".bus_inline_txt_" + ID).hide();
                $(".bus_comp_lbl_" + ID).hide();
                $(".cn_update_" + ID).hide();
                $(".cn_cancel_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });

            $('.cn_update').click(function()
            {
                var ID = $(this).attr('id');
                var cname_val = $(".bus_inline_txt_" + ID).val();
                var cname_val_rep = (cname_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : cname_val;
                if (cname_val_rep != '') {

                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&bus_company_name="+encodeURIComponent(cname_val_rep),
                                success: function(option)
                                {
                                    $(".bus_inline_span_" + ID).html(option);
                                    $(".company_name_" + ID).html(option);
                                    $(".bus_inline_span_" + ID).css("display", "inline-block");
                                    $(".bus_inline_txt_" + ID).hide();
                                    $(".cn_update_" + ID).hide();
                                    $(".cn_cancel_" + ID).hide();
                                }
                            });

                }

            });


            //Cust ID Inline Edit Start

            $('.cust_inline').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".cust_inline_span_" + ID).hide();
                $(".cust_inline_txt_" + ID).css("display", "inline-block");
                $(".cust_comp_lbl_" + ID).css("display", "inline-block");
                $(".cust_update_" + ID).css("display", "inline-block");
                $(".cust_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });

            $('.cust_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".cust_inline_span_" + ID).show();
                $(".cust_inline_txt_" + ID).hide();
                $(".cust_comp_lbl_" + ID).hide();
                $(".cust_update_" + ID).hide();
                $(".cust_cancel_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });

            $('.cust_update').click(function()
            {
                var ID = $(this).attr('id');
                var cname_val = $(".cust_inline_txt_" + ID).val();
                var cname_val_rep = (cname_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : cname_val;
                if (cname_val_rep != '') {

                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&cust_company_name="+encodeURIComponent(cname_val_rep),
                                success: function(option)
                                {
                                    $(".cust_inline_span_" + ID).html(option);
                                    $(".cust_inline_span_" + ID).css("display", "inline-block");
                                    $(".cust_inline_txt_" + ID).hide();
                                    $(".cust_update_" + ID).hide();
                                    $(".cust_cancel_" + ID).hide();
                                }
                            });

                }

            });


            //Cust ID Inline End


            //Devivary Address  Comp Name Inline Edit Start

            $('.del_inline').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".del_inline_span_" + ID).hide();
                $(".del_inline_txt_" + ID).css("display", "inline-block");
                $(".del_inline_lbl_" + ID).css("display", "inline-block");
                $(".cn_del_update_" + ID).css("display", "inline-block");
                $(".cn_del_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });

            $('.cn_del_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".del_inline_span_" + ID).show();
                $(".del_inline_txt_" + ID).hide();
                $(".del_inline_lbl_" + ID).hide();
                $(".cn_del_update_" + ID).hide();
                $(".cn_del_cancel_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });

            $('.cn_del_update').click(function()
            {
                var ID = $(this).attr('id');
                var cname_val = $(".del_inline_txt_" + ID).val();
                var cname_val_rep = (cname_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : cname_val;
                //alert(cname_val);        
                if (cname_val_rep != '') {

                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&del_company_name="+encodeURIComponent(cname_val_rep),
                                success: function(option)
                                {
                                    $(".del_inline_span_" + ID).html(option);
                                    $(".del_inline_span_" + ID).css("display", "inline-block");
                                    $(".del_inline_txt_" + ID).hide();
                                    $(".cn_del_update_" + ID).hide();
                                    $(".cn_del_cancel_" + ID).hide();
                                }
                            });

                }

            });
            //Devivary Address Comp Name Inline Edit End

            //Bussiness Address1 Inline Edit Start

            $('.bus_add1_inline').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".bus_add1_inline_span_" + ID).hide();
                $(".bus_add1_inline_txt_" + ID).css("display", "inline-block");
                $(".bus_add1_lbl_" + ID).css("display", "inline-block");
                $(".ad1_update_" + ID).css("display", "inline-block");
                $(".ad1_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });

            $('.ad1_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_add1_inline_span_" + ID).show();
                $(".bus_add1_inline_txt_" + ID).hide();
                $(".bus_add1_lbl_" + ID).hide();
                $(".ad1_update_" + ID).hide();
                $(".ad1_cancel_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });

            $('.ad1_update').click(function()
            {
                var ID = $(this).attr('id');
                var ad1_val = $(".bus_add1_inline_txt_" + ID).val();
                var ad1_val_fnl = (ad1_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : ad1_val;
                $.ajax
                        ({
                            type: "POST",
                            url: "customers_edit_inline.php",
                            data: "id=" + ID + "&bus_address_1=" + encodeURIComponent(ad1_val_fnl),
                            success: function(option)
                            {
                                $(".bus_add1_inline_span_" + ID).html(option);
                                $(".bus_add1_inline_span_" + ID).css("display", "inline-block");
                                $(".bus_add1_inline_txt_" + ID).hide();
                                $(".ad1_update_" + ID).hide();
                                $(".ad1_cancel_" + ID).hide();
                            }
                        });

            });

            //Bussiness Address1 Inline Edit End 

            //Delivary Address1 Inline Edit Start

            $('.del_add1_inline').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".del_add1_inline_span_" + ID).hide();
                $(".del_add1_inline_txt_" + ID).css("display", "inline-block");
                $(".del_add1_lbl_" + ID).css("display", "inline-block");
                $(".ad1_del_update_" + ID).css("display", "inline-block");
                $(".ad1_del_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });

            $('.ad1_del_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".del_add1_inline_span_" + ID).show();
                $(".del_add1_inline_txt_" + ID).hide();
                $(".del_add1_lbl_" + ID).hide();
                $(".ad1_del_update_" + ID).hide();
                $(".ad1_del_cancel_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });

            $('.ad1_del_update').click(function()
            {
                var ID = $(this).attr('id');
                var ad1_val = $(".del_add1_inline_txt_" + ID).val();
                var ad1_val_fnl = (ad1_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : ad1_val;
                $.ajax
                        ({
                            type: "POST",
                            url: "customers_edit_inline.php",
                            data: "id=" + ID + "&del_address_1=" + encodeURIComponent(ad1_val_fnl),
                            success: function(option)
                            {
                                $(".del_add1_inline_span_" + ID).html(option);
                                $(".del_add1_inline_span_" + ID).css("display", "inline-block");
                                $(".del_add1_inline_txt_" + ID).hide();
                                $(".ad1_del_update_" + ID).hide();
                                $(".ad1_del_cancel_" + ID).hide();
                            }
                        });

            });

            //Delivary Address1 Inline Edit End

            //Bussiness Address2 Inline Edit Start

            $('.bus_add2_inline').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".bus_add2_inline_span_" + ID).hide();
                $(".bus_add2_inline_txt_" + ID).css("display", "inline-block");
                $(".bus_add2_lbl_" + ID).css("display", "inline-block");
                $(".ad2_update_" + ID).css("display", "inline-block");
                $(".ad2_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });

            $('.ad2_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_add2_inline_span_" + ID).show();
                $(".bus_add2_inline_txt_" + ID).hide();
                $(".bus_add2_lbl_" + ID).hide();
                $(".ad2_update_" + ID).hide();
                $(".ad2_cancel_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });


            $('.ad2_update').click(function()
            {
                var ID = $(this).attr('id');
                var ad2_val = $(".bus_add2_inline_txt_" + ID).val();
                var ad2_val_fnl = (ad2_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : ad2_val;
                //alert(cname_val);        

                $.ajax
                        ({
                            type: "POST",
                            url: "customers_edit_inline.php",
                            data: "id=" + ID + "&bus_address_2="+encodeURIComponent(ad2_val_fnl),
                            success: function(option)
                            {
                                $(".bus_add2_inline_span_" + ID).html(option);
                                $(".bus_add2_inline_span_" + ID).css("display", "inline-block");
                                $(".bus_add2_inline_txt_" + ID).hide();
                                $(".ad2_update_" + ID).hide();
                                $(".ad2_cancel_" + ID).hide();
                            }
                        });



            });
            //Bussiness Address2 Inline Edit End 



            //Delivery Address2 Inline Edit Start

            $('.del_add2_inline').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".del_add2_inline_span_" + ID).hide();
                $(".del_add2_inline_txt_" + ID).css("display", "inline-block");
                $(".del_add2_lbl_" + ID).css("display", "inline-block");
                $(".ad2_del_update_" + ID).css("display", "inline-block");
                $(".ad2_del_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });

            $('.ad2_del_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".del_add2_inline_span_" + ID).show();
                $(".del_add2_inline_txt_" + ID).hide();
                $(".del_add2_lbl_" + ID).hide();
                $(".ad2_del_update_" + ID).hide();
                $(".ad2_del_cancel_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });


            $('.ad2_del_update').click(function()
            {
                var ID = $(this).attr('id');
                var ad2_val = $(".del_add2_inline_txt_" + ID).val();
                var ad2_val_fnl = (ad2_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : ad2_val;
                //alert(cname_val);        


                $.ajax
                        ({
                            type: "POST",
                            url: "customers_edit_inline.php",
                            data: "id=" + ID + "&del_address_2="+encodeURIComponent(ad2_val_fnl),
                            success: function(option)
                            {
                                $(".del_add2_inline_span_" + ID).html(option);
                                $(".del_add2_inline_span_" + ID).css("display", "inline-block");
                                $(".del_add2_inline_txt_" + ID).hide();
                                $(".ad2_del_update_" + ID).hide();
                                $(".ad2_del_cancel_" + ID).hide();
                            }
                        });



            });

            //Delivery Address2 Inline Edit End 



            //Bussiness Address3 Inline Edit Start

            $('.bus_add3_inline').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".bus_add3_inline_span_" + ID).hide();
                $(".bus_add3_inline_txt_" + ID).css("display", "inline-block");
                $(".bus_add3_lbl_" + ID).css("display", "inline-block");
                $(".ad3_update_" + ID).css("display", "inline-block");
                $(".ad3_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });

            $('.ad3_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_add3_inline_span_" + ID).show();
                $(".bus_add3_inline_txt_" + ID).hide();
                $(".bus_add3_lbl_" + ID).hide();
                $(".ad3_update_" + ID).hide();
                $(".ad3_cancel_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });


            $('.ad3_update').click(function()
            {
                var ID = $(this).attr('id');
                var ad3_val = $(".bus_add3_inline_txt_" + ID).val();
                var ad3_val_fnl = (ad3_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : ad3_val;

                $.ajax
                        ({
                            type: "POST",
                            url: "customers_edit_inline.php",
                            data: "id=" + ID + "&bus_address_3="+encodeURIComponent(ad3_val_fnl),
                            success: function(option)
                            {
                                $(".bus_add3_inline_span_" + ID).html(option);
                                $(".bus_add3_inline_span_" + ID).css("display", "inline-block");
                                $(".bus_add3_inline_txt_" + ID).hide();
                                $(".ad3_update_" + ID).hide();
                                $(".ad3_cancel_" + ID).hide();
                            }
                        });

            });
            //Bussiness Address3 Inline Edit End 

            
            //Delivery Address3 Inline Edit Start

            $('.del_add3_inline').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".del_add3_inline_span_" + ID).hide();
                $(".del_add3_inline_txt_" + ID).css("display", "inline-block");
                $(".del_add3_lbl_" + ID).css("display", "inline-block");
                $(".ad3_del_update_" + ID).css("display", "inline-block");
                $(".ad3_del_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });

            $('.ad3_del_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".del_add3_inline_span_" + ID).show();
                $(".del_add3_inline_txt_" + ID).hide();
                $(".del_add3_lbl_" + ID).hide();
                $(".ad3_del_update_" + ID).hide();
                $(".ad3_del_cancel_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });


            $('.ad3_del_update').click(function()
            {
                var ID = $(this).attr('id');
                var ad2_val = $(".del_add3_inline_txt_" + ID).val();
                var ad2_val_fnl = (ad2_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : ad2_val;
                //alert(cname_val);        


                $.ajax
                        ({
                            type: "POST",
                            url: "customers_edit_inline.php",
                            data: "id=" + ID + "&del_address_3="+encodeURIComponent(ad2_val_fnl),
                            success: function(option)
                            {
                                $(".del_add3_inline_span_" + ID).html(option);
                                $(".del_add3_inline_span_" + ID).css("display", "inline-block");
                                $(".del_add3_inline_txt_" + ID).hide();
                                $(".ad3_del_update_" + ID).hide();
                                $(".ad3_del_cancel_" + ID).hide();

                            }
                        });



            });
            //Delivery Address3 Inline Edit End 

            //Bussiness Suit Inline Edit Start

            $('.bus_suit_inline').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".bus_suit_inline_span_" + ID).hide();
                $(".bus_suit_inline_txt_" + ID).css("display", "inline-block");
                $(".bus_suit_lbl_" + ID).css("display", "inline-block");
                $(".suit_update_" + ID).css("display", "inline-block");
                $(".suit_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });

            $('.suit_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_suit_inline_span_" + ID).show();
                $(".bus_suit_inline_txt_" + ID).hide();
                $(".bus_suit_lbl_" + ID).hide();
                $(".suit_update_" + ID).hide();
                $(".suit_cancel_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });


            $('.suit_update').click(function()
            {
                var ID = $(this).attr('id');
                var suit_val = $(".bus_suit_inline_txt_" + ID).val();
                var suit_val_fnl = (suit_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : suit_val;

                $.ajax
                        ({
                            type: "POST",
                            url: "customers_edit_inline.php",
                            data: "id=" + ID + "&bus_suit="+encodeURIComponent(suit_val_fnl),
                            success: function(option)
                            {
                                $(".bus_suit_inline_span_" + ID).html(option);
                                $(".bus_suit_inline_span_" + ID).css("display", "inline-block");
                                $(".bus_suit_inline_txt_" + ID).hide();
                                $(".suit_update_" + ID).hide();
                                $(".suit_cancel_" + ID).hide();
                            }
                        });

            });
            //Bussiness Suit Inline Edit End
            
            
            //Delivery Suit Inline Edit Start

            $('.del_suit_inline').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".del_suit_inline_span_" + ID).hide();
                $(".del_suit_inline_txt_" + ID).css("display", "inline-block");
                $(".del_suit_lbl_" + ID).css("display", "inline-block");
                $(".suit_update_del_" + ID).css("display", "inline-block");
                $(".suit_cancel_del_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });

            $('.suit_cancel_del').click(function()
            {
                var ID = $(this).attr('id');
                $(".del_suit_inline_span_" + ID).show();
                $(".del_suit_inline_txt_" + ID).hide();
                $(".del_suit_lbl_" + ID).hide();
                $(".suit_update_del_" + ID).hide();
                $(".suit_cancel_del_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });


            $('.suit_update_del').click(function()
            {
                var ID = $(this).attr('id');
                var suit_val = $(".del_suit_inline_txt_" + ID).val();
                var suit_val_fnl = (suit_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : suit_val;

                $.ajax
                        ({
                            type: "POST",
                            url: "customers_edit_inline.php",
                            data: "id=" + ID + "&del_suit="+encodeURIComponent(suit_val_fnl),
                            success: function(option)
                            {
                                $(".del_suit_inline_span_" + ID).html(option);
                                $(".del_suit_inline_span_" + ID).css("display", "inline-block");
                                $(".del_suit_inline_txt_" + ID).hide();
                                $(".suit_update_del_" + ID).hide();
                                $(".suit_cancel_del_" + ID).hide();
                            }
                        });

            });
            //Delivery Suit Inline Edit End
            
            
            
            
            //Bussiness city Inline Edit Start

            $('.bus_city_inline').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".bus_city_inline_span_" + ID).hide();
                $(".bus_city_inline_txt_" + ID).css("display", "inline-block");
                $(".city_update_" + ID).css("display", "inline-block");
                $(".city_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });

            $('.city_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_city_inline_span_" + ID).show();
                $(".bus_city_inline_txt_" + ID).hide();
                $(".city_update_" + ID).hide();
                $(".city_cancel_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });


            $('.city_update').click(function()
            {
                var ID = $(this).attr('id');
                var city_val = $(".bus_city_inline_txt_" + ID).val();
                //alert(cname_val);        
                if (city_val != '') {

                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&bus_city=" + city_val,
                                success: function(option)
                                {
                                    $(".bus_city_inline_span_" + ID).html(option);
                                    $(".bus_city_inline_span_" + ID).css("display", "inline-block");
                                    $(".bus_city_inline_txt_" + ID).hide();
                                    $(".city_update_" + ID).hide();
                                    $(".city_cancel_" + ID).hide();
                                }
                            });

                }

            });


            //Bussiness city Inline Edit End 



            //Delivery city Inline Edit Start

            $('.del_city_inline').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".del_city_inline_span_" + ID).hide();
                $(".del_city_inline_txt_" + ID).css("display", "inline-block");
                $(".city_del_update_" + ID).css("display", "inline-block");
                $(".city_del_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });

            $('.city_del_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".del_city_inline_span_" + ID).show();
                $(".del_city_inline_txt_" + ID).hide();
                $(".city_del_update_" + ID).hide();
                $(".city_del_cancel_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });


            $('.city_del_update').click(function()
            {
                var ID = $(this).attr('id');
                var city_val = $(".del_city_inline_txt_" + ID).val();
                //alert(cname_val);        
                if (city_val != '') {

                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&del_city=" + city_val,
                                success: function(option)
                                {
                                    $(".del_city_inline_span_" + ID).html(option);
                                    $(".del_city_inline_span_" + ID).css("display", "inline-block");
                                    $(".del_city_inline_txt_" + ID).hide();
                                    $(".city_del_update_" + ID).hide();
                                    $(".city_del_cancel_" + ID).hide();
                                }
                            });

                }

            });


            //Delivery city Inline Edit End 


            //Bussiness State Inline Edit Start

            $('.bus_stat_inline').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_stat_inline_span_" + ID).hide();
                $(".bus_stat_inline_txt_" + ID).css("display", "inline-block");
                $(".stat_update_" + ID).css("display", "inline-block");
                $(".stat_cancel_" + ID).css("display", "inline-block");
            });

            $('.stat_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_stat_inline_span_" + ID).show();
                $(".bus_stat_inline_txt_" + ID).hide();
                $(".stat_update_" + ID).hide();
                $(".stat_cancel_" + ID).hide();
            });



            $('.bus_state').change(function()
            {
                var ID = $(this).attr('id');
                var state_val = $(this).val();
                //alert(cname_val);        
                if (state_val != '') {

                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&state_val=" + state_val,
                                success: function(option)
                                {
                                    $(".bus_stat_inline_span_" + ID).html(option);
                                    $(".bus_stat_inline_span_" + ID).css("display", "inline-block");
                                    $(".bus_stat_inline_txt_" + ID).hide();
                                }
                            });

                }

            });
            //Bussiness State Inline Edit End 


            //Delevivery State Inline Edit Start

            $('.del_stat_inline').click(function()
            {
                var ID = $(this).attr('id');
                $(".del_stat_inline_span_" + ID).hide();
                $(".del_stat_inline_txt_" + ID).css("display", "inline-block");
                $(".del_update_" + ID).css("display", "inline-block");
                $(".del_cancel_" + ID).css("display", "inline-block");
            });

            $('.del_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".del_stat_inline_span_" + ID).show();
                $(".del_stat_inline_txt_" + ID).hide();
                $(".del_update_" + ID).hide();
                $(".del_cancel_" + ID).hide();
            });



            $('.del_state').change(function()
            {
                var ID = $(this).attr('id');
                var state_val = $(this).val();
                //alert(cname_val);        
                if (state_val != '') {

                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&del_state_val=" + state_val,
                                success: function(option)
                                {
                                    $(".del_stat_inline_span_" + ID).html(option);
                                    $(".del_stat_inline_span_" + ID).css("display", "inline-block");
                                    $(".del_stat_inline_txt_" + ID).hide();
                                }
                            });

                }

            });
            //Delivery State Inline Edit End 



            //Bussiness Zip Inline Edit Start

            $('.bus_zip_inline').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_zip_inline_span_" + ID).hide();
                $(".bus_zip_inline_txt_" + ID).css("display", "inline-block");
                $(".zip_update_" + ID).css("display", "inline-block");
                $(".zip_cancel_" + ID).css("display", "inline-block");
            });

            $('.zip_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_zip_inline_span_" + ID).show();
                $(".bus_zip_inline_txt_" + ID).hide();
                $(".zip_update_" + ID).hide();
                $(".zip_cancel_" + ID).hide();
            });


            $('.zip_update').click(function()
            {
                var ID = $(this).attr('id');
                var zip_val = $(".bus_zip_inline_txt_" + ID).val();

                var zip_val_fnl = (zip_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : zip_val;

                if (zip_val != '') {

                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&bus_zip=" + zip_val_fnl,
                                success: function(option)
                                {
                                    $(".bus_zip_inline_span_" + ID).html(option);
                                    $(".bus_zip_inline_span_" + ID).css("display", "inline-block");
                                    $(".bus_zip_inline_txt_" + ID).hide();
                                    $(".zip_update_" + ID).hide();
                                    $(".zip_cancel_" + ID).hide();
                                }
                            });

                }

            });


            //Bussiness Zip Inline Edit End 



            //Delivery Zip Inline Edit Start

            $('.del_zip_inline').click(function()
            {
                var ID = $(this).attr('id');
                $(".del_zip_inline_span_" + ID).hide();
                $(".del_zip_inline_txt_" + ID).css("display", "inline-block");
                $(".zip_del_update_" + ID).css("display", "inline-block");
                $(".zip_del_cancel_" + ID).css("display", "inline-block");
            });

            $('.zip_del_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".del_zip_inline_span_" + ID).show();
                $(".del_zip_inline_txt_" + ID).hide();
                $(".zip_del_update_" + ID).hide();
                $(".zip_del_cancel_" + ID).hide();
            });


            $('.zip_del_update').click(function()
            {
                var ID = $(this).attr('id');
                var zip_val = $(".del_zip_inline_txt_" + ID).val();
                //alert(cname_val);        
                if (zip_val != '') {

                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&bus_del_zip=" + zip_val,
                                success: function(option)
                                {
                                    $(".del_zip_inline_span_" + ID).html(option);
                                    $(".del_zip_inline_span_" + ID).css("display", "inline-block");
                                    $(".del_zip_inline_txt_" + ID).hide();
                                    $(".zip_del_update_" + ID).hide();
                                    $(".zip_del_cancel_" + ID).hide();
                                }
                            });

                }

            });


            //Delevery Zip Inline Edit End 




            //Bussiness Phone Inline Edit Start

            $('.bus_phone_inline').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_phone_inline_span_" + ID).hide();
                $(".bus_phone_inline_txt_" + ID).css("display", "inline-block");
                $(".phone_update_" + ID).css("display", "inline-block");
                $(".phone_cancel_" + ID).css("display", "inline-block");
                $(".bus_phone_head_inline_span_" + ID).css("float", "left");
                $(".bus_phone_inline_txt_" + ID).css("float", "left");
            });

            $('.phone_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_phone_inline_span_" + ID).show();
                $(".bus_phone_inline_txt_" + ID).hide();
                $(".phone_update_" + ID).hide();
                $(".phone_cancel_" + ID).hide();
            });


            $('.phone_update').click(function()
            {
                var ID = $(this).attr('id');
                var phone_val = $(".bus_phone_inline_txt_" + ID).val();
                //alert(cname_val);        
                if (phone_val != '') {

                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&bus_phone=" + phone_val,
                                success: function(option)
                                {
                                    $(".bus_phone_inline_span_" + ID).html(option);
                                    $(".bus_phone_inline_span_" + ID).css("display", "inline-block");
                                    $(".bus_phone_inline_txt_" + ID).hide();
                                    $(".phone_update_" + ID).hide();
                                    $(".phone_cancel_" + ID).hide();
                                }
                            });

                }

            });


            //Bussiness Phone Inline Edit End 


            //Deleivery Phone Inline Edit Start

            $('.del_phone_inline').click(function()
            {
                var ID = $(this).attr('id');
                $(".del_phone_inline_span_" + ID).hide();
                $(".del_phone_inline_txt_" + ID).css("display", "inline-block");
                $(".phone_del_update_" + ID).css("display", "inline-block");
                $(".phone_del_cancel_" + ID).css("display", "inline-block");
                $(".del_phone_head_inline_span_" + ID).css("float", "left");
                $(".del_phone_inline_txt_" + ID).css("float", "left");
            });

            $('.phone_del_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".del_phone_inline_span_" + ID).show();
                $(".del_phone_inline_txt_" + ID).hide();
                $(".phone_del_update_" + ID).hide();
                $(".phone_del_cancel_" + ID).hide();
            });


            $('.phone_del_update').click(function()
            {
                var ID = $(this).attr('id');
                var phone_val = $(".del_phone_inline_txt_" + ID).val();
                //alert(cname_val);        
                if (phone_val != '') {

                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&bus_del_phone=" + phone_val,
                                success: function(option)
                                {
                                    $(".del_phone_inline_span_" + ID).html(option);
                                    $(".del_phone_inline_span_" + ID).css("display", "inline-block");
                                    $(".del_phone_inline_txt_" + ID).hide();
                                    $(".phone_del_update_" + ID).hide();
                                    $(".phone_del_cancel_" + ID).hide();
                                }
                            });

                }

            });


            //Bussiness Phone Inline Edit End 



            //Bussiness Fax Inline Edit Start

            $('.bus_fax_inline').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_fax_inline_span_" + ID).hide();
                $(".bus_fax_inline_txt_" + ID).css("display", "inline-block");
                $(".fax_update_" + ID).css("display", "inline-block");
                $(".fax_cancel_" + ID).css("display", "inline-block");
                $(".bus_fax_head_inline_span_" + ID).css("float", "left");
                $(".bus_fax_inline_txt_" + ID).css("float", "left");
            });

            $('.fax_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_fax_inline_span_" + ID).show();
                $(".bus_fax_inline_txt_" + ID).hide();
                $(".fax_update_" + ID).hide();
                $(".fax_cancel_" + ID).hide();
            });


            $('.fax_update').click(function()
            {
                var ID = $(this).attr('id');
                var fax_val = $(".bus_fax_inline_txt_" + ID).val();
                //alert(cname_val);        
                if (fax_val != '') {

                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&bus_fax=" + fax_val,
                                success: function(option)
                                {
                                    $(".bus_fax_inline_span_" + ID).html(option);
                                    $(".bus_fax_inline_span_" + ID).css("display", "inline-block");
                                    $(".bus_fax_inline_txt_" + ID).hide();
                                    $(".fax_update_" + ID).hide();
                                    $(".fax_cancel_" + ID).hide();
                                }
                            });

                }

            });


            //Bussiness Fax Inline Edit End 


            //Bussiness Tax Inline Edit Start

            $('.bus_tax_inline').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_tax_inline_span_" + ID).hide();
                $(".bus_tax_inline_txt_" + ID).css("display", "inline-block");
            });

            $('.tax_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_tax_inline_span_" + ID).show();
                $(".bus_tax_inline_txt_" + ID).hide();
            });



            $('.bus_tax').change(function()
            {
                var confirm_tax = confirm("Are you sure ?");

                var ID = $(this).attr('id');
                var tax_val = $(this).val();
                //alert(tax_val); 
                if (confirm_tax == true) {
                    if (tax_val != '') {

                        $.ajax
                                ({
                                    type: "POST",
                                    url: "customers_edit_inline.php",
                                    data: "id=" + ID + "&tax_val=" + tax_val,
                                    success: function(option)
                                    {
                                        if (option == 'Yes') {
                                            $(".tax_exempt_number_row_" + ID).css("display", "inline-block");
                                        } else {
                                            $(".tax_exempt_number_row_view_" + ID).css("display", "none");
                                            $(".tax_exempt_number_row_" + ID).css("display", "none");
                                            $(".tax_exempt_number_span_" + ID).html('');
                                            $(".tax_exempt_number_" + ID).css("display", "inline-block");
                                            $(".tax_exempt_number_" + ID).val("");
                                            $(".tax_exempt_number_" + ID).focus();
                                            $(".tax_exempt_update_" + ID).css("display", "inline-block");
                                        }
                                        $(".bus_tax_inline_span_" + ID).html(option);
                                        $(".bus_tax_inline_span_" + ID).css("display", "inline-block");
                                        $(".bus_tax_inline_txt_" + ID).hide();
                                    }
                                });

                    }
                } else {
                    return false;
                }

            });

            $('.tax_exempt_update').click(function()
            {
                var ID = $(this).attr('id');
                var exempt_val = $(".tax_exempt_number_" + ID).val();
                //alert(cname_val);        
                if (exempt_val != '') {

                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&tax_exempt_number=" + exempt_val,
                                success: function(option)
                                {
                                    $(".tax_exempt_number_span_" + ID).html(option);
                                    $(".tax_exempt_number_" + ID).css("display", "none");
                                    $(".tax_exempt_update_" + ID).css("display", "none");
                                }
                            });

                }

            });


<?php } ?>
        //Bussiness Tax Inline Edit End 


        $('.status').click(function()
        {
            var ID = $(this).attr('id');
            var trigger_id = $(".trigger").attr('id');
            var fields = ID.split(/_/);
            var copmany_id = fields[0];
            var status_id = fields[1];
            var check_ok = confirm($('#active_user').attr('checked') ? "Are you sure?" : "Are you sure?");
            var imd_val = (status_id == '0') ? "images/active.png" : "images/de-active.png";
            var status_val = (status_id == '0') ? 1 : 0;
<?php if ($_SESSION['admin_user_type'] == '2') { ?>
                var staff_prev = (status_id == '1') ? "1" : "";
<?php } else { ?>
                var staff_prev = (status_id == '1') ? "0" : "";
<?php } ?>
            if (staff_prev == '1')
            {
                return false;
            }
            else
            {
                $.ajax
                        ({
                            type: "POST",
                            url: "customers_edit_inline.php",
                            data: "copmany_id=" + copmany_id + "&status=" + status_val,
                            success: function(option)
                            {
                                $('.change_status_' + copmany_id).attr("src", imd_val);
                                $(".status").attr("id", copmany_id + '_' + status_val);
                                $(".trigger").next(".test_" + trigger_id).fadeToggle('slow').siblings(".test_" + trigger_id).hide();
                            }
                        });
            }
        });


        $('.list_list').keydown(function(event) {

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

        $('.special_special').keydown(function(event) {

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

        $('.special_special').keyup(function(event) {
            var ID = $(".jass_p").attr("id");
            var list = document.getElementById('list_price_txt_c_' + ID).value;
            var special = document.getElementById('special_price_txt_c_' + ID).value;
            var discount = (((list - special) / list) * 100);
            $(".discount_price_txt_c_" + ID).val(discount);
            $(".special_price_txt_c_" + ID).val(special);
        });

        $('.discount_discount').keyup(function(event) {
            var ID = $(".jass_p").attr("id");
            //alert(ID);            
            var list = document.getElementById('list_price_txt_c_' + ID).value;
            var discount = document.getElementById('discount_price_txt_c_' + ID).value;
            var price = (discount * (list / 100));
            var special = (list - price);
            $(".discount_price_txt_c_" + ID).val(discount);
            $(".special_price_txt_c_" + ID).val(special);
        });

        $('.discount_discount').keydown(function(event) {


            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 46 || event.keyCode == 190) {

            } else {
                event.preventDefault();
            }

            if ($(this).val().indexOf('.') !== -1 && event.keyCode == 110)
                event.preventDefault();

        });


        $(document).mouseup(function()
        {
            var ID = $('.jass_p').attr('id');
            $(".list_price_c_" + ID).show();
            $(".discount_price_c_" + ID).show();
            $(".special_price_c_" + ID).show();
            $(".edit_c_" + ID).show();
            $(".list_price_txt_c_" + ID).hide();
            $(".discount_price_txt_c_" + ID).hide();
            $(".special_price_txt_c_" + ID).hide();
            $(".update_c_" + ID).hide();
        });

        $(".select_customer").change(function()
        {
            var ID = $(this).attr('id');
            var cust_id = $(".customer_name_" + ID).val();
            //alert(ID);
            if (cust_id != '') {

                $.ajax
                        ({
                            type: "POST",
                            url: "customers_edit.php",
                            data: "id=" + ID + "&cust_id=" + cust_id,
                            success: function(option)
                            {
                                $('#customer_dtls_' + ID).html(option);
                            }
                        });


            }

        });

        $(".select_address").change(function()
        {
            var ID = $(this).attr('id');
            var add_bk_id = $(".address_book_" + ID).val();
            //alert(cust_id);
            if (add_bk_id != '') {
                $.ajax
                        ({
                            type: "POST",
                            url: "address_book_edit.php",
                            data: "id=" + ID + "&address_book_id=" + add_bk_id,
                            success: function(option)
                            {
                                $('#addressbook_info_' + ID).html(option);
                            }
                        });
            }
        });



    });


    function update_sprice(str, str1)
    {
        var ID = str1;
        var list_price = document.getElementById('list_price_txt_c_' + str1 + '_' + str).value;
        var discount = document.getElementById('discount_price_txt_c_' + str1 + '_' + str).value;
        var special = document.getElementById('special_price_txt_c_' + str1 + '_' + str).value;
        var user_id = str;
        //alert(str1+' AND'+list_price+' AND'+discount+' AND'+user_id);

        if (list_price != '' && discount != '')
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "special_set.php",
                        data: "id=" + ID + "&list_price_c=" + list_price + "&discount_c=" + discount + "&user_id=" + user_id + "&special=" + special,
                        success: function(option)
                        {
                            var myarr = option.split("~");
                            var list_price = myarr[0];
                            var discount_price = myarr[1];
                            var special_price = myarr[2];
                            var spl_prc = myarr[3];

                            $(".list_price_c_" + str1 + '_' + str).html(list_price);
                            $(".discount_price_c_" + str1 + '_' + str).html(discount_price);
                            $(".special_price_c_" + str1 + '_' + str).html(special_price);
                            $(".list_price_txt_c_" + str1 + '_' + str).hide();
                            $(".discount_price_txt_c_" + str1 + '_' + str).hide();
                            $(".special_price_txt_c_" + str1 + '_' + str).hide();
                            $(".update_c_" + str1 + '_' + str).hide();
                            $(".list_price_c_" + str1 + '_' + str).show();
                            $(".discount_price_c_" + str1 + '_' + str).show();
                            $(".special_price_c_" + str1 + '_' + str).show();
                            $(".edit_c_" + str1 + '_' + str).show();
                            $('#spl_' + str).html(spl_prc);
                        }
                    });
        }
        else
        {
            $(".error").html("Please fill the all fields");
        }
        return false;


    }


    function delete_special(special_id, cid)
    {
        var con = confirm("Are you sure you want to delete this special price.");
        var sp_id = special_id;
        var user_id = cid;
        if (con == true)
        {
            if (sp_id != '') {

                $.ajax
                        ({
                            type: "POST",
                            url: "delete_spl.php",
                            data: "sp_id=" + sp_id + "&user_id=" + user_id,
                            success: function(option)
                            {
                                var myarr = option.split("~");
                                var succ = myarr[0];
                                var special_price = myarr[1];
                                $(".succ").html(succ);
                                $('.succ').delay(3000).fadeOut('slow');
                                $('#mas_' + user_id).html(special_price);
                            }
                        });

            }

        }
    }


    $('.acc-cat').click(function()
    {
        var company_id = $(this).attr('id');
        //alert(company_id);  

        if (company_id != '') {

            $.ajax
                    ({
                        type: "POST",
                        url: "category_acc.php",
                        data: "company_id=" + company_id,
                        beforeSend: loadStart,
                        complete: loadStop,
                        success: function(option)
                        {
                            $(".click_close_" + company_id).hide();
                            $('#cateacc_' + company_id).html(option);
                        }
                    });

        }

    });

    function view_favorites(COMP_ID)
    {
        // alert(COMP_ID);
        $.ajax
                ({
                    type: "POST",
                    url: "category_acc.php",
                    data: "company_id=" + COMP_ID,
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {

                    }
                });
    }

    $('.acc-spl').click(function()
    {
        var company_id = $(this).attr('id');
        //alert(company_id);  

        if (company_id != '') {

            $.ajax
                    ({
                        type: "POST",
                        url: "spl_list.php",
                        data: "company_id=" + company_id,
                        success: function(option)
                        {
                            $('#spl_price_list_' + company_id).html(option);
                            $(".click_close_special_" + company_id).hide();
                        }
                    });

        }

    });


    function loadStart() {
        $('#loading').show();
    }

    function loadStop() {
        $('#loading').hide();
    }



    function sus_reiv(company_id)
    {
        var sus_confirm = confirm('Are you sure?');

        if (sus_confirm == true) {
            if (company_id != '') {
                $.ajax
                        ({
                            type: "POST",
                            url: "suspend.php",
                            data: "company_id=" + company_id,
                            beforeSend: loadStart,
                            complete: loadStop,
                            success: function(option)
                            {
                                var class_change = option.split("~");
                                $("#action_" + company_id).removeClass(class_change[1]);
                                $("#action_" + company_id).addClass(class_change[0]);
                                $("#action_" + company_id).html(class_change[2]);
                            }
                        });

            }
        }
        else {
            return false;
        }
    }


 function filter_by_type_change()
    {
        var filter_type = $("#filter_by_type").val();
        if(filter_type == 'type_0'){
        window.location = "customers.php?cus_type_fil=0&admin_added=2";
        }else if(filter_type == 'type_1'){
        window.location = "customers.php?cus_type_fil=1";      
        }else if(filter_type == 'type_2'){
        window.location = "customers.php?cus_type_fil=2";
        }else{
        window.location = "customers.php";    
        }
    }
</script>



<script type="text/javascript" src="js/jquery.autocomplete.js"></script>
<link rel="stylesheet" href="js/jquery.autocomplete.css" type="text/css" />

<script type="text/javascript">

    /*
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
     
     */

    function load_userinfo()
    {
        //alert('Jassim');
        var search_val = $("#search_val").val();
        if (search_val == '') {
            document.getElementById('search_val').focus();
            $("#msg1").html('Enter the search value');
            return false;
        }
        //return true;

//    var search_val = $( "#search_val" ).val();
//    
//    if(search_val != '')  
//     {
//      $.ajax
//      ({
//         type: "POST",
//             url: "load_user.php",
//             data: "search_val="+search_val,
//             success: function(option)
//             {
//                 $('#load_userdata').html(option);
//             }
//      });
//     }
    }



    function findValue(li) {
        if (li == null)
            return alert("No match!");

        // if coming from an AJAX call, let's use the CityId as the value
        if (!!li.extra)
            var sValue = li.extra[0];

        // otherwise, let's just display the value in the text box
        else
            var sValue = li.selectValue;

        //alert("The value you selected was: " + sValue);
    }

    function selectItem(li) {
        findValue(li);
    }

    function formatItem(row) {
        return row[0];
    }

    function lookupAjax() {
        var oSuggest = $("#search_val")[0].autocompleter;
        oSuggest.findValue();
        return false;
    }


    /*
     
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
     
     */


    //Bussiness Zip Ext Inline Edit Start

    $('.bus_zip_inline_ext').click(function()
    {
        var ID = $(this).attr('id');
        $(".bus_zip_inline_span_ext_" + ID).hide();
        $(".bus_zip_inline_txt_ext_" + ID).css("display", "inline-block");
        $(".zip_update_ext_" + ID).css("display", "inline-block");
        $(".zip_cancel_ext_" + ID).css("display", "inline-block");
    });

    $('.zip_cancel_ext').click(function()
    {
        var ID = $(this).attr('id');
        $(".bus_zip_inline_span_ext_" + ID).show();
        $(".bus_zip_inline_txt_ext_" + ID).hide();
        $(".zip_update_ext_" + ID).hide();
        $(".zip_cancel_ext_" + ID).hide();
    });


    $('.zip_update_ext').click(function()
    {
        var ID = $(this).attr('id');
        var zip_val = $(".bus_zip_inline_txt_ext_" + ID).val();
        var zip_val_fnl = (zip_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : zip_val;

        if (zip_val != '') {

            $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit_inline.php",
                        data: "id=" + ID + "&bus_zip_ext=" + zip_val_fnl,
                        success: function(option)
                        {
                            $(".bus_zip_inline_span_ext_" + ID).html(option);
                            $(".bus_zip_inline_span_ext_" + ID).css("display", "inline-block");
                            $(".bus_zip_inline_txt_ext_" + ID).hide();
                            $(".zip_update_ext_" + ID).hide();
                            $(".zip_cancel_ext_" + ID).hide();
                        }
                    });

        }

    });


    //Bussiness Zip Ext Inline Edit End 

    //Delivery Zip Ext Inline Edit Start

    $('.zip_inline_del_ext').click(function()
    {
        var ID = $(this).attr('id');
        $(".zip_inline_span_del_ext_" + ID).hide();
        $(".zip_inline_txt_del_ext_" + ID).css("display", "inline-block");
        $(".zip_update_del_ext_" + ID).css("display", "inline-block");
        $(".zip_cancel_del_ext_" + ID).css("display", "inline-block");
    });

    $('.zip_cancel_del_ext').click(function()
    {
        var ID = $(this).attr('id');
        $(".zip_inline_span_del_ext_" + ID).show();
        $(".zip_inline_txt_del_ext_" + ID).hide();
        $(".zip_update_del_ext_" + ID).hide();
        $(".zip_cancel_del_ext_" + ID).hide();
    });


    $('.zip_update_del_ext').click(function()
    {
        var ID = $(this).attr('id');
        var zip_val = $(".zip_inline_txt_del_ext_" + ID).val();
        var zip_val_fnl = (zip_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : zip_val;
        if (zip_val != '') {

            $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit_inline.php",
                        data: "id=" + ID + "&bus_zip_del_ext=" + zip_val_fnl,
                        success: function(option)
                        {
                            $(".zip_inline_span_del_ext_" + ID).html(option);
                            $(".zip_inline_span_del_ext_" + ID).css("display", "inline-block");
                            $(".zip_inline_txt_del_ext_" + ID).hide();
                            $(".zip_update_del_ext_" + ID).hide();
                            $(".zip_cancel_del_ext_" + ID).hide();
                        }
                    });

        }

    });


    //Delivery Zip Ext Inline Edit End 

    function reset_filter()
    {
        window.location = "customers.php";

    }

    function add_new_customer()
    {
        window.location = "add_new_customer.php";
    }

    function autosuggession()
    {
        var searc_name = $("#search_val").val();
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
        $("#search_val").val(CUS_NAME);
        var search_val = $("#search_val").val();

        if (search_val != '') {
            $("#result_ref").hide();
            $("#new_supercategory").submit();
        }

    }
    
    function select_inv_type(COMP_ID)
    {
        $("#invoice_freq_"+COMP_ID).show();
        $("#inv_type_"+COMP_ID).hide();
    }
    
    function set_invoice_type(COMP_ID)
    {
        var frequency_value = $('#invoice_freq_'+COMP_ID).val();
                
        if(COMP_ID != ''){
        $.ajax
               ({
                   type: "POST",
                   url: "get_child.php",
                   data: "invoice_type="+frequency_value+"&invoice_comp_id="+COMP_ID,
                   beforeSend: loadStart,
                   complete: loadStop,
                   success: function(option)
                   {
                       $("#inv_type_"+COMP_ID).html(option);
                       $("#inv_type_"+COMP_ID).show();
                       $("#invoice_freq_"+COMP_ID).hide();
                   }
               }); 
        }
        
    }
    
    function edit_cus_notes(COM_ID){        
        $("#cus_notes_"+COM_ID).hide();
        $("#cus_notes_edit_"+COM_ID).fadeIn();
        $(".cus_notes_edit_txt_"+COM_ID).focus();
    }
    
    function cancel_cust_notes(COM_ID){
        $("#cus_notes_"+COM_ID).fadeIn();
        $("#cus_notes_edit_"+COM_ID).hide();
    }
    
    function save_cust_notes(COM_ID){
        var cus_notes = $(".cus_notes_edit_txt_"+COM_ID).val();
        //alert(cus_notes);
        if(COM_ID != ''){
        $.ajax
               ({
                   type: "POST",
                   url: "get_child.php",
                   data: "customer_notes="+encodeURIComponent(cus_notes)+"&notes_comp_id="+COM_ID,
                   beforeSend: loadStart,
                   complete: loadStop,
                   success: function(option)
                   {
                       $("#cus_notes_"+COM_ID).fadeIn();
                       $("#cus_notes_"+COM_ID).html(option);
                       $("#cus_notes_edit_"+COM_ID).hide();
                   }
               }); 
        }
    }
    
    
    function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}
</script>                    

