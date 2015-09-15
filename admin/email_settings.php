<?php
include './config.php';
include './auth.php';
$Email = getEmail();

if ($_REQUEST['new_mail'] == '1') {
    extract($_POST);
    $sql = "INSERT INTO sohorepro_email
			SET     name = '" . $name . "',
                                email_id = '" . $email . "',
				status = '" . $status . "' ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success";
    } else {
        $result = "failure";
    }
}

if ($_GET['delete_id']) {

    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM sohorepro_email WHERE id = " . $delete_id . " ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_del";
    } else {
        $result = "failure_del";
    }
}



if ($_GET['status_id']) {

    $change_status = ($_GET['change_id'] == 1) ? '0' : '1';
    $status_id = $_GET['status_id'];
    $sql = "UPDATE sohorepro_email
			SET     status     = '" . $change_status . "' WHERE id= '" . $status_id . "'";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_status";
    } else {
        $result = "failure_status";
    }
}

$sql_order_sequence = mysql_query("SELECT id,order_sequence FROM sohorepro_order_master ORDER BY id DESC LIMIT 1");
$object_order_sequence = mysql_fetch_assoc($sql_order_sequence);
$sequence_id = $object_order_sequence['id'];
$sequence = $object_order_sequence['order_sequence'];


$sql_tax_rate = mysql_query("SELECT tax_rate FROM sohorepro_tax_rate");
$object_tax_rate = mysql_fetch_assoc($sql_tax_rate);
$tax_rate = $object_tax_rate['tax_rate'];
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Soho-repro</title>
        <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>

        <!-- Add fancyBox main JS and CSS files -->
        <script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery.fancybox.css?v=2.1.5" media="screen" />

        <link rel="stylesheet" href="../js/jquery-ui.css" />
        <script src="../js/jquery-ui_service.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                /**  Simple image gallery. Uses default settings*/
                $('.fancybox').fancybox();

                /**  Different effects */
            });
            
            $(function() {
            var all_exist_date       = $("#all_exist_date").val();
            var split_element        = all_exist_date.split(","); 
            var disabledSpecificDays = [split_element[0],split_element[1],split_element[2],split_element[3],split_element[4],split_element[5],split_element[6],split_element[7],split_element[8],split_element[8],split_element[9],split_element[10],split_element[11],split_element[12],split_element[13],split_element[14],split_element[15],split_element[16],split_element[17],split_element[18],split_element[19]];
            
            function disableSpecificDaysAndWeekends(date) {
            var m = date.getMonth();
            var d = date.getDate();
            var y = date.getFullYear();

            for (var i = 0; i < disabledSpecificDays.length; i++) {
            if ($.inArray((m + 1) + '-' + d + '-' + y, disabledSpecificDays) != -1 ) {
            return [false];
            }
            }

            var noWeekend = $.datepicker.noWeekends(date);
            return !noWeekend[0] ? noWeekend : [true];
            }
            $( "#date_off" ).datepicker({minDate: 0,
            dateFormat: 'm/d/yy',
            inline: true,
            dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            beforeShowDay: disableSpecificDaysAndWeekends});
            });
            
            function set_off_days()
            {
               var date_off = $("#date_off").val();
               if(date_off != ''){                   
                    $.ajax
                    ({
                        type: "POST",
                        url: "days_off_set.php",
                        data: "off_day_insert=" + date_off,
                        beforeSend: loadStart,
                        complete: loadStop,
                        success: function(option)
                            {
                                if(option != ''){
                                 var all_offdate_list = option.split("~"); 
                                 $('#days_off_succ').html(all_offdate_list[0]);
                                 $('#view_days_off').html(all_offdate_list[1]);
                                 $('#insert_days_off').html(all_offdate_list[2]);
                                 $('#days_off_succ').fadeOut(1000);
                                }else{
                                    alert("That date already set;");
                                }
                            }
                        });               
               }else{
                   alert('Select the date.');
                   $("#date_off").focus();
               }
            }
            
            function off_days_delete(ID)
            {
                var ok_to_proceed = confirm('Are you sure?');
                if(ok_to_proceed == true){
                $.ajax
                    ({
                        type: "POST",
                        url: "days_off_delete.php",
                        data: "off_day_delete_id=" + ID,
                        beforeSend: loadStart,
                        complete: loadStop,
                        success: function(option)
                            {
                                if(option != ''){
                                 var all_offdate_list = option.split("~"); 
                                 $('#days_off_succ').html(all_offdate_list[0]);
                                 $('#view_days_off').html(all_offdate_list[1]);
                                 $('#insert_days_off').html(all_offdate_list[2]);
                                 $('#days_off_succ').fadeOut(1000);
                                }else{
                                    alert("That date already set;");
                                }
                            }
                        }); 
                }else{
                    return false;
                }
            }
        </script>
        <!--End -->
        <style>
            .pointer{
                cursor: pointer;
            }
            .none{
                display: none;
            }
            .picker_icon{
            background : #FFFFFF url(../images/datepicker-20.png) no-repeat 4px 4px;
            padding: 5px 5px 5px 25px;
            height:18px;
            cursor: pointer;
            }
        </style>
    </head>

    <body>
        <div id="loading" class="none"  style="position: fixed;top: 35%;left: 48%;padding: 5px;z-index: 10;">
            <img src="images/login_loader.gif" border="0" />
        </div>
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
                                            SETTINGS
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
                                        <td align="right" valign="top">
                                            <table width="759" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="38" align="left" valign="middle" class="add_title">Add email id's</td>
                                                </tr>
                                                <tr>
                                                    <td height="60" align="right" valign="top" bgcolor="#f6f6f6" class="form_bg">
                                                        <form name="new_email" id="new_subcategory" method="post" action=""  onsubmit="return validate();" >

                                                            <input type="hidden" name="new_mail" value="1" />  
                                                            <input type="hidden" name="mail_temp" id="mail_temp" value="0" />  
                                                            <table width="759" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td width="125" height="60" align="right" style="font-size:12px;" valign="middle">Enter Name</td>
                                                                    <td width="160" height="60" align="right" valign="middle"><input type="text" autocomplete="off" name="name" id="name" class="input_text" ></td>
                                                                    <td width="172" height="60" align="left" valign="middle"><input type="text" autocomplete="off" name="email" id="email" value="Enter email id" onfocus="if (this.value == 'Enter email id') {
                                                                                this.value = '';
                                                                            }" onblur="if (this.value == '') {
                                                                                        this.value = 'Enter email id';
                                                                                    }" class="input_text" ></td>
                                                                    <td width="60" height="60" align="right" style="font-size:12px;" valign="middle">Status&nbsp;</td>
                                                                    <td width="20" height="60" align="left" valign="middle"><input type="radio" name="status" value="1" checked="checked" ></td>
                                                                    <td width="50" height="60" align="left" style="font-size:12px;" valign="middle">Active</td>
                                                                    <td width="20" height="60" align="left"  valign="middle"><input type="radio" name="status" value="0"  ></td>
                                                                    <td width="70" height="60" align="left" style="font-size:12px;" valign="middle">InActive</td>
                                                                    <td width="90" height="60" align="left" valign="middle"><input type="submit" value="" id="submit" class="add_btn"></td>
                                                                </tr>                                                                 
                                                                <tr>
                                                                    <td colspan="9" height="38" style="color:#F00; text-align:center; padding-bottom:10px; font-size: 12px;">

                                                                        <?php
                                                                        if ($result == "success") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Email id inserted successfully</div>
                                                                            <script>setTimeout("location.href=\'email_settings.php\'", 2000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Email id insert not successfully</div>
                                                                            <script>setTimeout("location.href=\'email_settings.php\'", 2000);</script>       
                                                                            <?php
                                                                        }


                                                                        if ($_GET['val'] == "success") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Email id inserted successfully</div>
                                                                            <script>setTimeout("location.href=\'email_settings.php\'", 2000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Email id insert not successfully</div>
                                                                            <script>setTimeout("location.href=\'email_settings.php\'", 2000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($result == "success_del") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Deleted successfully</div>
                                                                            <script>setTimeout("location.href=\'email_settings.php\'", 2000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_del") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Not deleted</div>
                                                                            <script>setTimeout("location.href=\'email_settings.php\'", 2000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($result == "success_status") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Status change successfully</div>
                                                                            <script>setTimeout("location.href=\'email_settings.php\'", 2000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_status") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Status change not successfully</div>
                                                                            <script>setTimeout("location.href=\'email_settings.php\'", 2000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>                                                                            


                                                                        <div id="msg1" style="color:#FF0000;padding-left:12px;font-size: 12px;"></div>
                                                                        <div id="msg2" style="color:#FF0000;padding-left:12px;font-size: 12px;"></div>
                                                                        <div id="msg3" style="color:#FF0000;padding-left:12px;font-size: 12px;"></div>
                                                                        <div id="msg4" style="color:#FF0000;padding-left:12px;font-size: 12px;"></div>
                                                                        <span id="msg5" style="color:#FF0000;padding-left:12px;font-size: 12px;"></span>
                                                                        <span id="msg6" style="color:#007F2A;padding-left:12px;font-size: 12px;"></span>
                                                                        <span class="check" style="color:#FF0000;padding-left:12px;font-size: 12px; display: none;"  ></span>
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
                                                    <td width="736" align="left" valign="middle" style="padding-left:20px;"> 

                                                    </td>
                                                    <td height="25" align="right" valign="middle">                                                        
                                                    </td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top">                                           

                                            <!-- Products Start -->
                                            <table width="759" border="0" cellspacing="0" cellpadding="0">

                                                <tr>
                                                    <td width="20" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>
                                                    <td width="150" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Name</td>
                                                    <td width="120" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Email id</td>
                                                    <td width="40" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">status</td>
                                                    <td width="40" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                if (count($Email) > 0) {
                                                    foreach ($Email as $Mail) {
                                                        $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                        $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                        $status = ($Mail['status'] == 1) ? 'active' : 'de-active';
                                                        $id = $Mail['id'];
                                                        ?>
                                                        <tr>
                                                            <td width="49"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>
                                                            <td width="150" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><?php echo $Mail['name']; ?></td>
                                                            <td width="60" align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="pad_btm"><?php echo $Mail['email_id']; ?></td>
                                                            <td width="60"  align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><img id="status_change_<?php echo $id; ?>" src="images/<?php echo $status; ?>.png" width="22" height="22" onclick="return change_status('<?php echo $id; ?>');"  alt="" style="cursor: pointer;"/></td>
                                                            <!--<td width="60"  align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><a href="email_settings.php?status_id=<?php echo $id; ?>&change_id=<?php echo $Mail['status']; ?>" onclick="return confirm('Are you sure?');"><img src="images/<?php echo $status; ?>.png" width="22" height="22"  alt=""/></a></td>-->
                                                            <td width="80"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm">
                                                                <a class="fancybox fancybox.iframe" href="edit_email.php?id=<?php echo $id; ?>"><img src="images/edit.png"  alt="" width="22" height="22"/></a><a href="email_settings.php?delete_id=<?php echo $id; ?>" onclick="return confirm('Are you sure?');"><img src="images/del.png"  alt="" width="22" height="22" class="mar_lft"/></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    ?>
                                                    <tr align="center">
                                                        <td colspan="8">There is no mail id's</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>

                                            </table></td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <a href="settings_update.php"><span class="upt_sett" style="float:left; margin-left: 5px;margin-top: 5px;">Notification Settings</span></a>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                                    <td height="38" align="left" valign="middle" class="add_title">Change Order Number Sequence</td>
                                                </tr>
                                                <tr>
                                                    <td height="60" align="right" valign="top" bgcolor="#f6f6f6" class="form_bg">
                                                        <form name="new_email" id="new_subcategory" method="post" action="">

                                                            <input type="hidden" name="new_mail" value="1" />  
                                                            <input type="hidden" name="mail_temp" id="mail_temp" value="0" />  
                                                            <table width="759" border="0" cellspacing="0" cellpadding="0">                                                                 
                                                                <tr>
                                                                    <td width="125" height="60" align="right" style="font-size:12px;" valign="middle">Order Number Sequence</td>
                                                                    <td width="160" height="60" align="right" valign="middle"><input type="text" autocomplete="off" name="sequence_id" id="sequence_id" class="input_text" value="<?php echo $sequence; ?>" ></td>                                                                    
                                                                    <td width="172"><img src="images/btn_setorder.png" title="Set Order Sequence" alt="Set Order Sequence" onclick="return order_seq(<?php echo $sequence_id; ?>);" style="cursor: pointer;margin-left: 10px;" /></td>                                                                    
                                                                </tr>                                                                
                                                            </table>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td height="38" align="left" valign="middle" class="add_title">Tax Configurations</td>
                                                </tr>
                                                <tr>
                                                    <td height="60" align="right" valign="top" bgcolor="#f6f6f6" class="form_bg">
                                                        <form name="new_email" id="new_subcategory" method="post" action="">

                                                            <input type="hidden" name="new_mail" value="1" />  
                                                            <input type="hidden" name="mail_temp" id="mail_temp" value="0" />  
                                                            <table width="759" border="0" cellspacing="0" cellpadding="0">                                                                 
                                                                <tr>
                                                                    <td width="125" height="60" align="right" style="font-size:12px;" valign="middle"> NYC Tax Rate</td>
                                                                    <td width="160" height="60" align="right" valign="middle"><input type="text" autocomplete="off" name="tax_id" id="tax_id" class="input_text" value="<?php echo $tax_rate; ?>" ></td>                                                                    
                                                                    <td width="172"><span class="upt_sett" style="float:left; margin-left: 5px;margin-top: 5px;" onclick="return tax_rate('<?php echo $tax_rate; ?>');">SET TAX RATE</span></td>                                                                    
                                                                </tr>                                                                
                                                            </table>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td height="38" align="left" valign="middle" class="add_title">Define Weekdays Off</td>
                                                </tr>
                                                <tr>
                                                    <td><div id="days_off_succ" style="color:#007F2A;"></div></td>
                                                </tr>
                                                <tr>
                                                    <td bgcolor="#f6f6f6" class="form_bg">
                                                        <?php
                                                        $all_days_off = AllDayOff();
                                                        
                                                        foreach ($all_days_off as $days_off_split){
                                                            $all_days_in[]  = $days_off_split['date'];
                                                        }    
//                                                        echo '<pre>';
//                                                        print_r($all_days_in);
//                                                        echo '</pre>';
                                                        $all_date  = implode(",", $all_days_in);                                                        
                                                        $all_date_exist = str_replace("/", "-", $all_date);
                                                        ?>
                                                        <table style="width:100%;height: 100px;" border="0" >
                                                            <tr>
                                                                <td style="width:50%;" valign="top">
                                                                    <div id="insert_days_off">
                                                                    <input type="hidden" name="all_exist_date" id="all_exist_date" value="<?php echo $all_date_exist; ?>" />
                                                                    <div style="float:left;width:100%;font-weight: bold;">Pick the Date for Off:</div>
                                                                    <div style="float:left;width:100%;"><input type="text" name="date_off" id="date_off" class="picker_icon" /></div>
                                                                    <div style="float:left;width:100%;margin-top:5px;"><span name="submit_off" style="background: none repeat scroll 0 0 #f99b3e;border-radius: 5px;color: #fff;cursor: pointer;float: left;padding: 2px 8px;" onclick="return set_off_days();" />Set Days Off</span></div>
                                                                    </div>
                                                                </td>
                                                                <td style="width:50%;" valign="top">
                                                                     <div style="float:left;width:100%;font-weight: bold;">Date Show :</div>
                                                                     <div id="view_days_off">
                                                                     <?php  
                                                                     $n = 1;
                                                                     foreach ($all_days_off as $days_off){
                                                                     ?>
                                                                     <div style="float:left;width:100%;padding-top: 3px;">
                                                                         <div style="float: left;width: 5%;"><?php echo $n.'.'; ?></div>
                                                                         <div style="float: left;width: 20%;"><?php echo $days_off['date']; ?></div>
                                                                         <div style="float: left;width: 20%;"><span style="background: none repeat scroll 0 0 #f99b3e;border-radius: 3px;color: #fff;cursor: pointer;padding: 0px 5px;" onclick="return off_days_delete('<?php echo $days_off['id']; ?>');">Delete</span></div>
                                                                     </div>
                                                                     <?php $n++;} ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td height="38" align="left" valign="middle" class="add_title">Specials Button settings</td>
                                                </tr>
                                                <tr>
                                                    <td><div id="days_off_succ" style="color:#007F2A;"></div></td>
                                                </tr>
                                                <tr>
                                                    <td bgcolor="#f6f6f6" class="form_bg">
                                                        <?php 
                                                            $specials       = Specials('3');
                                                            $close_lable    = ($specials == '1') ? 'SPECIALS ON' : 'SPECIALS OFF';
                                                            $close_lable_bg = ($specials == '1') ? 'background: #009D59;' : 'background: #D3412C;';                                                                                
                                                        ?>
                                                        <span id="special_status_3" onclick="return specials_on_off('3');" style="<?php echo $close_lable_bg; ?>;cursor: pointer;color: #FFF;float: left;padding: 5px 20px;margin-top: 10px;border-radius: 5px;text-decoration: none;margin-right: 15px;margin-left:5px;margin-bottom: 15px;font-weight: bold;"><?php echo $close_lable; ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td style="background:#464646; text-align:center; color:#fff; line-height:30px;" height="30p">© <?php echo date('Y'); ?> sohorepro.com</td>
            </tr>
        </table>
    </body>
</html>

<script type="text/javascript">
    $(document).ready(function()
    {
        $("#category_name").change(function()
        {
            var pc_id = $(this).val();
            if (pc_id != '0')
            {
                $.ajax
                        ({
                            type: "POST",
                            url: "get_child.php",
                            data: "pc_id=" + pc_id,
                            success: function(option)
                            {
                                $("#subcategory_name").html(option);
                            }
                        });
            }
            else
            {
                $("#subcategory_name").html("<option value=''>-- No subcategory selected --</option>");
            }
            return false;
        });
    });

    $(document).ready(function() {
        /**  Simple image gallery. Uses default settings*/
        $('.fancybox').fancybox();

        /**  Different effects */
        $("div.close").hover(
                function() {
                    $('span.ecs_tooltip').show();
                },
                function() {
                    $('span.ecs_tooltip').hide();
                }
        );
        $("div.close").click(function() {
            disablePopup(); // function close pop up
        });

        $("div#backgroundPopup").click(function() {
            disablePopup(); // function close pop up
        });

        $(this).keyup(function(event) {
            if (event.which == 27) { // 27 is 'Ecs' in the keyboard
                disablePopup(); // function close pop up
            }
        });
    });

    function get_info(ID)
    {
        loading(); // loading
        setTimeout(function() { // then show popup, deley in .5 second
            Update_Info_Popup(); // function show popup 
        }, 500); // .5 second 
        $.ajax
                ({
                    type: "POST",
                    url: "get_customer_informations.php",
                    data: "customer_id=" + ID,
                    beforeSend: loading,
                    complete: closeloading,
                    success: function(option)
                    {
                        var res = option.split("~");
                        $('#Contact_Name').html(res[0]);
                        $('#Contact_Email').html(res[1]);
                        $('#Company_Name').html(res[2]);
                        $('#Company_Phone').html(res[3]);
                        $('#Address_1').html(res[4]);
                        $('#Address_2').html(res[5]);
                        $('#Room').html(res[6]);
                        $('#City').html(res[7]);
                        $('#State').html(res[8]);
                        $('#Zip').html(res[9]);
                        $('#Phone_1').html(res[10]);
                        $('#Phone_2').html(res[11]);
                        $('#Phone_3').html(res[12]);
                        $('#Phone_4').html(res[13]);
                        $('#resale_certificate').html(res[14]);
                        $('#exempt_use_certificate').html(res[15]);
                    }
                });
    }

    function Update_Info_Popup() {
        closeloading(); // fadeout loading
        $("#update_info").fadeIn(0500); // fadein popup div
        $("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
        $("#backgroundPopup").fadeIn(0001);
    }

    function disablePopup() {
        $("#update_info").fadeOut("normal");
        $("#backgroundPopup").fadeOut("normal");
        $('#Contact_Name').html("");
        $('#Contact_Email').html("");
        $('#Company_Name').html("");
        $('#Company_Phone').html("");
        $('#Address_1').html("");
        $('#Address_2').html("");
        $('#Room').html("");
        $('#City').html("");
        $('#State').html("");
        $('#Zip').html("");
        $('#Phone_1').html("");
        $('#Phone_2').html("");
        $('#Phone_3').html("");
        $('#Phone_4').html("");
        $('#resale_certificate').html("");
        $('#exempt_use_certificate').html("");
    }

    function loading() {
        $("div.login_loader").show();
    }

    function closeloading() {
        $("div.login_loader").fadeOut('normal');
    }
</script>

<script language="javascript">
    function validate()
    {
        var mail_name = document.getElementById('name').value;
        var input_mail = document.getElementById('email').value;    
        //alert(mail_name);
        if (mail_name == '')
        {
            document.getElementById("msg1").innerHTML = "Enter the name";
            document.getElementById('name').focus();
            return false;
        }
        else
        {
            document.getElementById("msg1").innerHTML = "";
        }
        if (input_mail == 'Enter email id')
        {
            document.getElementById("msg2").innerHTML = "Enter the email id";
            document.getElementById('email').focus();
            return false;
        }
        else
        {
            document.getElementById("msg2").innerHTML = "";
        }

        var input = document.getElementById('email').value;
        var expr = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (!expr.test(input))
        {
            document.getElementById("msg3").innerHTML = "Enter the valid email id";
            document.getElementById('email').focus();
            return false;
        }
        else
        {
            document.getElementById("msg3").innerHTML = "";
        }
            
        if (input_mail != '')
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "get_child.php",
                        data: "mail_id=" + input_mail + "&mail_name=" + mail_name,
                        success: function(option)
                        {
                            if (option == 'EXIST') {
                                document.getElementById("msg4").innerHTML = "Email id already exist.";
                                document.getElementById('email').focus();
                            } else {
                                document.getElementById("msg4").innerHTML = "";
                                window.location = "email_settings.php?val=success";
                            }
                        }

                    });
            return false;
        }
        return true;

    }


    function order_seq(sequence_id)
    {
        var sequence = document.getElementById('sequence_id').value;
        if (sequence != '')
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "get_child.php",
                        data: "sequence_id=" + sequence_id + "&sequence=" + sequence,
                        success: function(option)
                        {
                            var order_result = option.split("~");
                            $("#sequence_id").val(order_result[1]);
                            document.getElementById("msg6").innerHTML = order_result[0];
                            $('#msg6').hide(3000);
                        }
                    });
        }
        else
        {
            document.getElementById("msg5").innerHTML = "Order number should not be empty";
        }

    }


    function tax_rate(tax_val)
    {
        var tax_id = document.getElementById('tax_id').value;
      
        if (tax_id != '')
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "get_child.php",
                        data: "tax_val_fix=" + tax_id,
                        beforeSend: loadStart,
                        complete: loadStop,
                        success: function(option)
                        {
                            var order_result = option.split("~");
                            $("#tax_id").val(order_result[1]);
                            document.getElementById("msg6").innerHTML = order_result[0];
                            $('#msg6').hide(3000);
                        }
                    });
        }
        else
        {
            document.getElementById("msg5").innerHTML = "Tax rate should not be empty";
        }

    }
    
    function loadStart() {
$('#loading').show();
}

function loadStop() {
$('#loading').hide();
}


function change_status(status_id)
{
    var confirm_status  = confirm("Are you sure?");
    
    if(confirm_status == true){
    if (status_id != '') 
    {
        $.ajax
            ({
                type: "POST",
                url: "suspend.php",
                data: "status_change_id=" + status_id,
                beforeSend: loadStart,
                complete: loadStop,
                success: function(option)
                {                   
                    $('#status_change_'+status_id).attr("src",option);
                }
            });
    }
    }else{
        return false;
    }
}


 function specials_on_off(SPL_ID){
        var ays         =  confirm('Are you sure?');
        if(ays == true){
        if(SPL_ID != ''){
        $.ajax
               ({
                   type: "POST",
                   url: "get_child.php",
                   data: "specials_on_off="+SPL_ID,
                   beforeSend: loadStart,
                   complete: loadStop,
                   success: function(option)
                   {    
                       //alert(option);
                       if(option == true){
                        $("#special_status_"+SPL_ID).html("SPECIALS ON");
                        $("#special_status_"+SPL_ID).css("background", "#009D59");                      
                        }else{
                        $("#special_status_"+SPL_ID).html("SPECIALS OFF");
                        $("#special_status_"+SPL_ID).css("background", "#D3412C");     
                        }
                   }
               }); 
        }
        }else{
            return false;
        }
    }
</script>