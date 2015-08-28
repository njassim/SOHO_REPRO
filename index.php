<?php

$current_host =  $_SERVER['HTTP_HOST'];
if($current_host == 'sohorepro.com'){    
header("Location:http://supply.sohorepro.com/web/");
}

include './admin/config.php';
include './admin/db_connection.php';
include './admin/include/class.phpmailer.php';
error_reporting(0);

$Super = getSuperCategory();

if (isset($_REQUEST['forgot_submit'])) {
    //print_r($_REQUEST);
    $emailid = mysql_real_escape_string($_POST['email_id']);

    $check_user_count = mysql_query("select * from sohorepro_customers where cus_email='" . $emailid . "' ");

    if (mysql_num_rows($check_user_count) > 0) {
        $check_fth_user = mysql_fetch_array($check_user_count);
        $message = '<link href="mail_css.css" media="screen" rel="stylesheet" type="text/css" />';
        $message .= '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
        $message .= '<table width="550" border="0" cellspacing="0" cellpadding="0">';
        $message .= '<tr bgcolor="#ff7e00">';
        $message .= '<td width="10" height="10" align="left" valign="top"></td>';
        $message .= '<td height="10" align="left" valign="top"></td>';
        $message .= '<td width="10" height="10" align="left" valign="top"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
        $message .= '<td align="left" valign="top"><table width="530" border="0" cellspacing="0" cellpadding="0">';
        $message .= '<tr>';
        $message .= '<td width="20" height="20" align="left" valign="top"></td>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= '<td width="20" height="20" align="left" valign="top"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td width="20" align="left" valign="top"></td>';
        $message .= '<td align="left" valign="top"><table width="490" border="0" cellspacing="0" cellpadding="0">';
        $message .= '<tr>';
        $message .= '<td width="140" align="left" valign="top"><img src="' . $base_url . '/store_files/soho_logo.jpg" width="126" height="115" alt=""/></td>';
        $message .= '<td align="left" valign="top"><table width="200" border="0" cellspacing="0" cellpadding="0">';
        $message .= '<tr>';

        $message .= '</table></td>';
        $message .= '</tr>';
        $message .= '</table></td>';
        $message .= '<td width="20" align="left" valign="top"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td width="20" align="left" valign="top"></td>';
        $message .= '<td align="left" valign="top">';
        $message .= '<table width="490" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';

        $message .="<tr>
 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;'>Dear " . ucfirst($check_fth_user['cus_fname'] . " " . $check_fth_user['cus_lname']) . ",</td>
 </tr>";
        $message .="<tr>
 <td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'> Please note down the login details for your account. <span style='color:#0b7abf; text-decoration:underline;'></span></td>
 </tr>";

        $message .="<tr>
 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#5f5f5f; font-weight:bold; padding-top:20px;'>Email id : " . ($check_fth_user['cus_email']) . "</td>
 </tr>";

        $message .="<tr>
 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#5f5f5f; font-weight:bold; padding-top:20px; padding-bottom:10px;'>Password : " . $check_fth_user['cus_pass'] . "</td>
 </tr>";

        $message .="<tr>
 <td height='30' align='left' valign='middle' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'><a href='" . $base_url . "/index.php' style='color:#0b7abf; text-decoration:underline;' target='_blank'>Click here </a>to login into our SohoRepro System.</td>
 </tr>";

        $message .="<tr><td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444; padding-top:10px;'>Thanks,</td></tr><tr><td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'>The SohoRepro Team</td></tr>";

        $message .= '</table></td>';
        $message .= '<td width="20" align="left" valign="top"></td>';
        $message .= '</tr>';
        $message .= '<tr>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= '<td height="20" align="left" valign="top"></td>';
        $message .= ' </tr>';
        $message .= '</table></td>';
        $message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
        $message .= '</tr>';
        $message .= '<tr bgcolor="#ff7e00">';
        $message .= '<td width="10" height="10" align="left" valign="top"></td>';
        $message .= '<td height="10" align="left" valign="top"></td>';
        $message .= '<td width="10" height="10" align="left" valign="top"></td>';
        $message .= ' </tr>';
        $message .= '</table>';

        //echo $message;
        // exit;
// $to = $check_fth_user['cus_email'];
// $subject = 'SohoRepro - Login credentials';
// $headers = 'From: "SohoRepro" <no-reply@sohorepro.com>' . "\r\n";
// // Always set content-type when sending HTML email
// $headers = "MIME-Version: 1.0" . "\r\n";
// $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
// 
// $forgot_result = mail($to, $subject, $message, $headers);
        $to = $check_fth_user['cus_email'];
        $mail = new PHPMailer();
        $mail->SetFrom('noreply@new-sohorepro.com', "SohoRepro");
        $mail->AddAddress($to, $to);
        $mail->Subject = 'SohoRepro - Login credentials';
        $mail->IsHTML(true);
        $mail->Body = $message;
        $forgot_result = $mail->Send();


        if ($forgot_result) {
            header("Location:index.php?for_succ=1");
        }
    } else {
        header("Location:index.php?for_err=1");
        exit;
    }
}


if (isset($_REQUEST['login_submit'])) {
    unset($_SESSION['sohorepro_userid']);
    unset($_SESSION['sohorepro_companyid']);
    unset($_SESSION['sohorepro_username']);
    $emailid = mysql_real_escape_string($_POST['email_id']);
    $pass = mysql_real_escape_string($_POST['password']);

    $user_login = UserLogin($emailid, $pass);
    $chk_cus_status = CheckCusStatus($user_login[0]['cus_compname']);

//    
//   
//    
//    foreach ($user_login as $login_pre){
//        $check_status[] =  StatusCheckComp($login_pre['cus_compname']);
//    }
//    
//    
//    $cus_details = CustomerDetails($check_status[0]);

    if ((count($user_login) > 0)) {
        $_SESSION['sohorepro_userid'] = $user_login[0]['cus_id'];
        $_SESSION['sohorepro_companyid'] = $user_login[0]['cus_compname'];
        $_SESSION['sohorepro_username'] = $user_login[0]['cus_contact_name'];
        header("Location:index.php");
    } else {
        header("Location:index.php?err=incorrect");
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <!-- Mirrored from buckart.com/srsite/SoHoRepro-WebsitePages/store/store.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 21 Sep 2013 08:44:50 GMT -->
    <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
    <head>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
            <title> SohoRepro </title>

            <!-- base href="http://soho.thinkdesign.com/" -->

            <link rel="stylesheet" href="store_files/style.css" type="text/css" media="screen"> 
                <link rel="stylesheet" href="style/pulse.css" type="text/css" media="screen"> 
                <link rel="stylesheet" href="store_files/theme.css" type="text/css" media="screen"> 
                    <link rel="stylesheet" href="store_files/jquery.css" type="text/css" media="screen"> 
                        <link rel="stylesheet" href="store_files/tiptip.css" type="text/css" media="screen"> 
                            <link rel="stylesheet" href="store_files/ajaxLoader.css" type="text/css" media="screen"> 
                                <link rel="stylesheet" href="store_files/flexigrid.css" type="text/css" media="screen"> 
                                    <link rel="stylesheet" href="store_files/ui.css" type="text/css" media="screen"> 
                                        <link rel="stylesheet" href="store_files/slick.css" type="text/css" media="screen"> 
                                            <link rel="stylesheet" href="store_files/kendo.css" type="text/css" media="screen"> 
                                                <link rel="stylesheet" href="store_files/kendo_002.css" type="text/css" media="screen"> 
                                                    <link rel="stylesheet" href="store_files/style_002.css" type="text/css" media="screen"> 
                                                        <script language="javascript" src="store_files/jquery_003.js"></script> 
                                                        <script language="javascript" src="store_files/ui_002.js"></script> 
                                                        <script language="javascript" src="store_files/jgrowl.js"></script> 
                                                        <script language="javascript" src="store_files/jquery_005.js"></script> 
                                                        <script language="javascript" src="store_files/ajaxLoader.js"></script> 
                                                        <script language="javascript" src="store_files/flexigrid.js"></script> 
                                                        <script language="javascript" src="store_files/maskedinput.js"></script> 
                                                        <script language="javascript" src="store_files/gps.js"></script> 
                                                        <script language="javascript" src="store_files/jquery_004.js"></script> 
                                                        <script language="javascript" src="store_files/ui.js"></script> 
                                                        <script language="javascript" src="store_files/slick_010.js"></script> 
                                                        <script language="javascript" src="store_files/slick_008.js"></script> 
                                                        <script language="javascript" src="store_files/slick_003.js"></script> 
                                                        <script language="javascript" src="store_files/slick.js"></script> 
                                                        <script language="javascript" src="store_files/slick_004.js"></script> 
                                                        <script language="javascript" src="store_files/slick_011.js"></script> 
                                                        <script language="javascript" src="store_files/slick_007.js"></script> 
                                                        <script language="javascript" src="store_files/slick_006.js"></script> 
                                                        <script language="javascript" src="store_files/slick_002.js"></script> 
                                                        <script language="javascript" src="store_files/jquery.js"></script> 
                                                        <script language="javascript" src="store_files/slick_009.js"></script> 
                                                        <script language="javascript" src="store_files/slick_005.js"></script> 
                                                        <script language="javascript" src="store_files/jquery_002.js"></script> 
                                                        <script language="javascript" src="store_files/sohorepro.js"></script> 
                                                        <script language="javascript" src="store_files/kendo.js"></script> 
                                                        <script language="javascript" src="store_files/script.js"></script> 
                                                        <script language="javascript" src="store_files/storecart.js"></script> 
                                                        <script language="javascript" src="store_files/interface.js"></script> 

  <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->


                                                        <script type="text/javascript" src="store_files/scripts.js"></script>
                                                        <script src="store_files/jquery.min.js"></script>
                                                        <script type="text/javascript" src="jquery.sticky.js"></script>
                                                        <script>
                                                            $(window).load(function() {
                                                                $("#supply_hdr").sticky({topSpacing: 0});
                                                            });
                                                        </script>
                                                        <link href="style/popup_style.css" rel="stylesheet" type="text/css" media="all" />
                                                        <script>
                                                            $(document).ready(function() {
                                                                
                                                                $(".super_cat").click(function() {
                                                                    $(this).next(".sub_cat").slideToggle("slow");
                                                                });                                                              
                                                                
                                                            });
                                                        </script>

                                                        <link rel="shortcut icon" href="http://soho.thinkdesign.com/favicon.ico" type="image/x-icon">
                                                            <link rel="stylesheet" type="text/css" href="store_files/style_layout.css">
                                                                <!--[if IE 7]>
                                                                <link rel="stylesheet" type="text/css" href="css/ie_7_hacks.css" />
                                                                <![endif]-->



                                                                <!-- Validation script starts here -->

                                                                <style type="text/css">
                                                                    label.error{
                                                                        color: red !important; 
                                                                    }
                                                                    .super_cat{
                                                                        margin: 15px;
                                                                    }

                                                                    input.error,select.error{
                                                                        border: 1px solid red !important;
                                                                    }
                                                                    .cat_products span:hover {font-size: 16px; cursor: pointer;}
                                                                    #search span:hover {font-size: 16px; cursor: pointer;}
                                                                    .fixed_1{border-style:solid;border-width:0px; position: fixed; width: 740px; top: 0; z-index: 1; background: #fff;}
                                                                    #to_tal{ display:block !important;}
                                                                    .pointer{cursor: pointer;}
                                                                    .ref_div{
                                                                        float:right;margin-top:-63px;position: relative;
                                                                    }
                                                                    .ref_span{
                                                                        font-size:22px; font-weight:bold;
                                                                    }

                                                                    .ref_div_star{
                                                                        color:red; margin-top: -5px;font-size: 16px;font-weight: bold;
                                                                    }
                                                                    .favorites{float: left;font-size: 16px;font-weight: bold;cursor:pointer;}
                                                                </style>
                                                                <script src="js/jquery.js" type="text/javascript" ></script>
                                                                <script src="js/jquery.validate.js" type="text/javascript" ></script>
                                                                <script src="js/jquery.maskedinput.js" type="text/javascript" ></script>

                                                                <!--scroll set to top--->
                                                                <!--<script type="text/javascript"> 
                                                                //STICKY NAV
                                                                $(document).ready(function () {  
                                                                  var top = $('#supply_hdr').offset().top - parseFloat($('#supply_hdr').css('marginTop').replace(/auto/, 100));
                                                                  $(window).scroll(function (event) {
                                                                    // what the y position of the scroll is
                                                                    var y = $(this).scrollTop();
                                                                
                                                                    // whether that's below the form
                                                                    if (y >= top) {
                                                                      // if so, ad the fixed class
                                                                      $('#supply_hdr').addClass('fixed_1');
                                                                    } else {
                                                                      // otherwise remove it
                                                                      $('#supply_hdr').removeClass('fixed_1');
                                                                    }
                                                                  });
                                                                });
                                                                </script>-->

                                                                <script src="waypoints.js"></script>
                                                                <script src="waypoints-sticky.js"></script>
                                                                <script type="text/javascript">
                                                                     $(document).ready(function() {
                                                                         $('.sticky-navigation').waypoint('sticky');
                                                                     });
                                                                </script>
                                                                <style>
                                                                    .sticky-navigation
                                                                    {
                                                                        padding: 10px;
                                                                        background: #FFF;   
                                                                        font-size: 18px;
                                                                        width: 720px;   
                                                                    }
                                                                    .sticky-navigation.stuck
                                                                    {
                                                                        position: fixed;
                                                                        top: 0;
                                                                        box-shadow: 0 2px 4px rgba(0, 0, 0, .2);
                                                                        z-index: 1;
                                                                    }

                                                                    #result_ref
                                                                    {
                                                                        position: absolute;
                                                                        width: 185px;
                                                                        padding: 10px;
                                                                        display: none;
                                                                        margin-top: 2px;
                                                                        border-top: 0px;
                                                                        overflow: hidden;
                                                                        background-color: #F3f3f3;
                                                                        box-shadow: 0px 0px 5px #ccc;
                                                                        position: absolute;
                                                                        right: 2px;
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

                                                                    .tot_cart{
                                                                        text-align: right;color:#5C5C5C;font-size:18px;font-weight:bold;
                                                                    }
                                                                    .tot_cart_spm{
                                                                        text-align: right;color:#5C5C5C;font-size:18px;font-weight:bold;
                                                                    }
                                                                    .curr_tot_div{
                                                                        color:#5C5C5C;font-weight:bold;font-size:18px;padding-right:0px;padding-bottom: 0px;;
                                                                    }
                                                                    .curr_tot_div1
                                                                    {
                                                                        color:#5C5C5C;font-weight:bold;font-size:18px;margin-top:10px;padding-right:0px;
                                                                    }
                                                                    .curr_ord_tot{
                                                                        font-size: 18px;font-weight:bold;
                                                                    }
                                                                </style>
                                                                <script type="text/javascript">

                                                                    $(document).ready(function() {



                                                                        var validation_obj = {
                                                                            rules: {email_id: {
                                                                                    required: true,
                                                                                    email: true
                                                                                }},
                                                                            messages: {
                                                                                email_id: {
                                                                                    required: '',
                                                                                    email: true
                                                                                },
                                                                                password: {
                                                                                    required: ''

                                                                                }

                                                                            }
                                                                        };


                                                                        $("#login_form").validate(validation_obj);



                                                                        var validation_reg = {
                                                                            rules: {reg_email_id: {
                                                                                    required: true,
                                                                                    email: true
                                                                                },
                                                                                reg_password: {
                                                                                    required: true,
                                                                                    rangelength: [6, 8]
                                                                                }},
                                                                            messages: {
                                                                                reg_name: {
                                                                                    required: ''

                                                                                },
                                                                                reg_email_id: {
                                                                                    required: '',
                                                                                    email: true
                                                                                },
                                                                                reg_password: {
                                                                                    required: ''

                                                                                },
                                                                                reg_cpassword: {
                                                                                    required: ''

                                                                                }

                                                                            }
                                                                        };


                                                                        $("#reg_form").validate(validation_reg);


                                                                        var validation_forgot = {
                                                                            rules: {email_id: {
                                                                                    required: true,
                                                                                    email: true
                                                                                }},
                                                                            messages: {
                                                                                email_id: {
                                                                                    required: '',
                                                                                    email: true
                                                                                }

                                                                            }
                                                                        };


                                                                        $("#forgot_form").validate(validation_forgot);



                                                                    });


                                                                    function show_reg(str)
                                                                    {
                                                                        if (str == 0)
                                                                        {
                                                                            $("#reg_form").show();
                                                                            $("#login_form").hide();
                                                                        }
                                                                        else
                                                                        {
                                                                            $("#reg_form").hide();
                                                                            $("#login_form").show();
                                                                        }
                                                                    }


                                                                    function show_forgot(str)
                                                                    {
                                                                        if (str == 0)
                                                                        {
                                                                            $("#forgot_form").show();
                                                                            $("#login_form").hide();
                                                                        }
                                                                        else
                                                                        {
                                                                            $("#forgot_form").hide();
                                                                            $("#login_form").show();
                                                                        }
                                                                    }


                                                                    function change_txt(tid, val)
                                                                    {
                                                                        var txt_val = $(tid).val();
                                                                        //alert(txt_val);
                                                                        if (txt_val == val)
                                                                        {
                                                                            $(tid).val('');
                                                                        }
                                                                    }

                                                                    function change_dtxt(tid, val)
                                                                    {
                                                                        var txt_val = $(tid).val();
                                                                        //alert(txt_val);

                                                                        if (txt_val == '')
                                                                        {
                                                                            $(tid).val('');
                                                                        }
                                                                    }

                                                                </script>
                                                                <!-- Validation script ends here --> 


                                                                </head>
                                                                <body onload="return clear_cach_index();">
                                                                    <input type="hidden" name="user_session" id="user_session" value="<?php echo $_SESSION['sohorepro_userid']; ?>" />
                                                                    <input type="hidden" name="user_session_comp" id="user_session_comp" value="<?php echo $_SESSION['sohorepro_companyid']; ?>" />
                                                                    <div id="body_container">

                                                                        <div id="body_content" class="body_wrapper">
                                                                            <div id="body_content-inner" class="body_wrapper-inner">
                                                                                <div class="responsive_container"> 
<?php include "includes/header_sidebar.php"; ?>

                                                                                    <div id="content_output">

<?php include "includes/top_nav.php"; ?>

                                                                                        <div id="content_output-data" style="margin-bottom:20px;">


                                                                                            <script type="text/javascript" src="store_files/script.html"></script>
                                                                                            <script>
                                                                                                $(document).ready(function() {
                                                                                                    $('.continute_service_shopping_link').click(function() {

                                                                                                        var value = $('#redirect_to').val();
                                                                                                        //alert(value);

                                                                                                        $('#supplystoreform').append('<input type="hidden" value="' + value + '" name="redirect_to" />');
                                                                                                        $('#supplystoreform').submit();

                                                                                                        /* $('#supplystoreform').submit(function(e){
                                                                                                         alert("Submitted");
                                                                                                         }); */

                                                                                                    });
                                                                                                    $('.addstroeproductActionLink').click(function() {
                                                                                                        //alert('hello');

                                                                                                        setInterval(function() {
                                                                                                            if ($('#action').val() == "pp") {
                                                                                                                $('#store').submit();
                                                                                                            }
                                                                                                        }, 250);

                                                                                                        $.post("user/checksignin", function(data) {
                                                                                                            var obj = jQuery.parseJSON(data);
                                                                                                            //console.log(obj.u_id);
                                                                                                            if (obj.u_id != 'unlogged') {
                                                                                                                $('#action').val() == "pp";
                                                                                                                $('#store').submit();
                                                                                                            } else {
                                                                                                                //alert('kk');
                                                                                                                $.post("view/supplystore", $("#store").serialize());
                                                                                                                var url = 'user/signin';
                                                                                                                var holderID = Math.floor(Math.random() * 1000001) + '_dialog';
                                                                                                                //console.log(holderID);
                                                                                                                $('#dynamicAppender').append('<div id="' + holderID + '" class="sdialog-Box"></div>');
                                                                                                                $('#' + holderID).load(url, function() {
                                                                                                                    $(".ui-dialog:hidden, .ui-dialog:hidden div").remove();
                                                                                                                    $("#" + holderID).dialog("destroy");
                                                                                                                    $("#" + holderID).dialog({
                                                                                                                        height: 284,
                                                                                                                        modal: true,
                                                                                                                        width: 348,
                                                                                                                        resizable: false
                                                                                                                    });
                                                                                                                    $(".ui-dialog-content").css({'background-color': '#F9F2DE', 'box-shadow': 'none'});
                                                                                                                    $("div.ui-dialog").css('box-shadow', 'none');
                                                                                                                    $(".ui-dialog-titlebar").hide();
                                                                                                                    $(".ui-widget-content").css('border', 'none');
                                                                                                                    $("img#closeit").click(function() {
                                                                                                                        $(".sdialog-Box").dialog('close');
                                                                                                                    });


                                                                                                                    /////new-s/////

                                                                                                                    $("#registering").click(function() {
                                                                                                                        var url = 'user/userregister';
                                                                                                                        var holderID = Math.floor(Math.random() * 1000001) + '_dialog';
                                                                                                                        $('#dynamicAppender').append('<div id="' + holderID + '" class="rdialog-Box"></div>');
                                                                                                                        $('#' + holderID).load(url, function() {
                                                                                                                            $(".ui-dialog:hidden, .ui-dialog:hidden div").remove();
                                                                                                                            $("#" + holderID).dialog("destroy");
                                                                                                                            $("#" + holderID).dialog({
                                                                                                                                height: 415,
                                                                                                                                modal: true,
                                                                                                                                width: 350,
                                                                                                                                resizable: false
                                                                                                                            });
                                                                                                                            $(".ui-dialog-content").css({'background-color': '#F9F2DE', 'box-shadow': 'none'});
                                                                                                                            $("div.ui-dialog").css('box-shadow', 'none');
                                                                                                                            $(".ui-dialog-titlebar").hide();
                                                                                                                            $(".ui-widget-content").css('border', 'none');
                                                                                                                            $("img#closeit").click(function() {
                                                                                                                                $(".rdialog-Box").dialog('close');
                                                                                                                            });

                                                                                                                            $("#registering").click(function() {

                                                                                                                            });

                                                                                                                        });

                                                                                                                        $(".sdialog-Box").dialog('close');
                                                                                                                        return false;
                                                                                                                    });

                                                                                                                    /////new-e/////
                                                                                                                });


                                                                                                            }


                                                                                                        });

                                                                                                        return false;
                                                                                                    });
                                                                                                    return false;
                                                                                                });



                                                                                            </script>
<?php
$sql_order_id = mysql_query("SELECT order_number FROM sohorepro_order_master ORDER BY id DESC LIMIT 1");
$object = mysql_fetch_assoc($sql_order_id);

if (count($object['order_number']) > 0) {
    $order_id = ($object['order_number'] + 1);
} else {
    $order_id = '101';
}

if ($_REQUEST['order_val'] == '1') {
    for ($j = 0; $j < count($_REQUEST['product_id']); $j++) {
        if ($_REQUEST['quantity'][$j] != '') {
            $place_order = '1';
        }
    }
    if ($place_order == '1') {
        $job_ref = $_REQUEST['jobref'];
        $sql = "INSERT INTO sohorepro_order_master SET order_number = '" . $order_id . "', order_id     = '" . $job_ref . "', customer_company = '" . $_SESSION['sohorepro_companyid'] . "', customer_name = '" . $_SESSION['sohorepro_userid'] . "', created_date = now()";
        mysql_query($sql);
    }
    $order_id_pro = mysql_insert_id();
    if ($order_id_pro != '') {
        for ($i = 0; $i < count($_REQUEST['product_id']); $i++) {
            if ($_REQUEST['quantity'][$i] != '') {

                $query = "INSERT INTO sohorepro_product_master SET product_id     = '" . $_REQUEST['product_id'][$i] . "', product_price = '" . $_REQUEST['price'][$i] . "', product_quantity = '" . $_REQUEST['quantity'][$i] . "', product_name = '" . $_REQUEST['product_name'][$i] . "', order_id = '" . $order_id_pro . "'";
                mysql_query($query);
            }
        }
        $result = "success";
    } else {
        $result = "failure";
    }
}


$special_pricelist = get_special_price($_SESSION['sohorepro_companyid']);

//print_r($special_pricelist);
$sprice_product = array();
$sprice_dprice = array();
foreach ($special_pricelist as $newprice) {
    $sprice_product[] = $newprice['sp_product_id'];
    $sprice_dprice[$newprice['sp_product_id']] = $newprice['sp_special_price'];
}


$user_checked_product = get_checked_item($_SESSION['sohorepro_userid']);

//print_r($special_pricelist);
$checked_product = array();
$checked_price = array();
foreach ($user_checked_product as $checked) {
    $checked_product[] = $checked['product_id'];
    $checked_price[$checked['product_id']] = $checked['quantity'];
    $checked_sub[$checked['product_id']] = $checked['sub_total'];
}

$user_fav_product = get_fav_item($_SESSION['sohorepro_companyid']);
//print_r($user_fav_product);
$fav_product = array();
foreach ($user_fav_product as $fav) {
    $fav_product[$fav['product_id']] = $fav['product_id'];
}
?>


                                                                                            <?php
                                                                                            if ($result == "success") {
                                                                                                ?>
                                                                                                <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Your order is placing</div>
                                                                                                <script>setTimeout("location.href=\'get_order.php\'", 1000);</script>
                                                                                                <?php
                                                                                            } elseif ($result == "failure") {
                                                                                                ?>
                                                                                                <div style="color:#F00; text-align:center; padding-bottom:10px;">Your order is not placing</div>
                                                                                                <script>setTimeout("location.href=\'get_order.php\'", 1000);</script> 
                                                                                                <?php
                                                                                            }
                                                                                            if ($_GET['err'] == 'incorrect') {
                                                                                                ?> 
                                                                                                <div style="color:#F00; text-align:center; padding-bottom:10px;font-size: 16px;font-weight: bold;">INVALID LOGIN</div>
                                                                                                <!--<script>setTimeout("location.href=\'index.php\'", 1000);</script>--> 
    <?php
}
if ($_GET['for_succ'] == '1') {
    ?>
                                                                                                <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Password sent successfully.</div> 
    <?php
}
if ($_GET['for_err'] == '1') {
    ?>
                                                                                                <div style="color:#F00; text-align:center; padding-bottom:10px;">Email ID does not exist.</div>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                            <!-- Header Start --> 
                                                                                            <div id="supply_hdr" class="sticky-navigation">
                                                                                                <div>
                                                                                                    <h2 class="headline-interior orange">SUPPLY STORE </h2>
                                                                                                    <div class="bkgd-stripes-orange">&nbsp;</div>
                                                                                                </div>

                                                                                                <form name="search" action="" method="post" onsubmit="return search_test_r();">
                                                                                                    <div>
                                                                                                        <div class="ref_div">
                                                                                                            <span class="ref_span">Job Reference<span class="ref_div_star">*</span> :</span> 
                                                                                                            <input aria-haspopup="true" aria-autocomplete="list" role="textbox" autocomplete="off" class="ui-autocomplete-input dec" style="padding:3px;width: 195px;" name="jobref" id="jobref" type="text" value="<?php if ($_GET['refere'] != '') {
                                                                                                echo $_GET['refere'];
                                                                                            } else {
                                                                                                echo ($_REQUEST['jobref'] != '') ? $_REQUEST['jobref'] : $_SESSION['ref_val'];
                                                                                            } ?>" onblur="return dummy_reference_1();" />
                                                                                                            <div id="result_ref">
                                                                                                            </div>
                                                                                                        </div> 

                                                                                                        <div class="tot_cart">Total Items in Cart : 
                                                                                                            <span style="" class="total_cart tot_cart_spm"><?php if ($_SESSION['session_cart'] == '') {
                                                                                                if ($_GET['cart'] != '') {
                                                                                                    echo $_GET['cart'];
                                                                                                } else { ?><?php if ($_REQUEST['total_cart_count'] != '') {
                                                                                                        echo $_REQUEST['total_cart_count'];
                                                                                                    } else { ?>0<?php } ?><?php }
                                                                                            } else {
                                                                                                echo $_SESSION['session_cart'];
                                                                                            } ?></span>
                                                                                                            <input type="hidden" class="total_cart_txt" id="total_cart_val" name="total_cart_count" value="<?php if ($_SESSION['session_cart'] == '') {
                                                                                                echo ($_GET['cart'] != '') ? $_GET['cart'] : $_REQUEST['total_cart_count'];
                                                                                            } else {
                                                                                                echo $_SESSION['session_cart'];
                                                                                            } ?>"/></div>
                                                                                                        
                                                                                                        
                                                                                                        <div class="inPageCartBlock curr_tot_div">

                                                                                                            Current Order Total : $<span id="" class="total_order curr_ord_tot"><?php if ($_SESSION['session_order'] == '') {
                                                                                                if ($_GET['sub'] != '') {
                                                                                                    echo $_GET['sub'];
                                                                                                } else { ?><?php if ($_REQUEST['all_total'] != '') {
                                                                                                        echo number_format($_REQUEST['all_total'], 2, '.', '');
                                                                                                    } else { ?>0.00<?php }
                                                                                                }
                                                                                            } else {
                                                                                                echo number_format($_SESSION['session_order'], 2, '.', '');
                                                                                            } ?></span>
                                                                                                            <input type="hidden" class="total_order_txt" id="total_order_val" name="all_total" value="<?php if ($_SESSION['session_order'] == '') {
                                                                                                            echo ($_GET['sub'] != '') ? $_GET['sub'] : $_REQUEST['all_total'];
                                                                                                        } else {
                                                                                                            echo number_format($_SESSION['session_order'], 2, '.', '');
                                                                                                        } ?>"/>

                                                                                                        </div>
                                                                                                        <div class="orange favorites" style="float:left;width: 100%;text-transform: uppercase;border:0px #5C5C5C solid;" onclick="view_favorites('<?php echo $_SESSION['sohorepro_userid']; ?>')">
                                                                                                        Favorites
                                                                                                    </div>
                                                                                                        
                                                                                                    </div>
                                                                                                    
                                                                                                    <!--<div style="float:left;width: 83%;height: 1px;background: #000;margin-top: 10px;margin-bottom: 15px;"></div>-->
                                                                                                    <div>
                                                                                                        <input type="hidden" name="search_state" value="1"/>
<?php if ($_REQUEST['search_state'] == '1') { ?>
                                                                                                            <a href="index.php?refere=<?php echo $_REQUEST['jobref']; ?>" style="text-transform: uppercase;color: #FF7E00;font-size: 14px;font-weight: bold;text-decoration: none;line-height: 26px;"><img src="images/back.png" border="0" style="margin-right: 5px;margin-top: 6px;float: left;"/>Return to all Products</a>
<?php } ?>
                                                                                                        <div style="float: right;">         
                                                                                                            <input type="text" class="dec_search" name="search_val" id="search_val" value="<?php echo htmlentities($_POST['search_val']); ?>" placeholder="Search Products" onfocus="this.placeholder = '';" autocomplete="off" id="search_val"/>
                                                                                                            <input type="submit" class="button_search"  value="Search" />        
                                                                                                        </div> 
                                                                                                    </div>
                                                                                                </form>        
                                                                                            </div>
                                                                                            <!-- Header End -->
                                                                                            <form id="supplystoreform" name="supplystoreform" action="shoppingcart.php" method="post" onsubmit="return validate()">
                                                                                                <input type="hidden" name="dummy_reference" id="dummy_reference" value="" /> 
                                                                                                <input type="hidden" name="order_val" value="1" id="order_val" />  
                                                                                                <input class="set_val" id="set_val" type="hidden" value="0" />
                                                                                                <input class="dummy" id="dummy" type="hidden" value="" />
                                                                                                <input class="dummy2" id="dummy2" type="hidden" value="0" />
                                                                                                <input class="dummy5" id="dummy5" type="hidden" value="<?php if ($_SESSION['session_cart'] == '') {
    echo ($_GET['cart'] != '') ? $_GET['cart'] : $_REQUEST['total_cart_count'];
} else {
    echo $_SESSION['session_cart'];
} ?>" />   
                                                                                                <input class="dummy6" id="dummy6" type="hidden" value="0" />   
                                                                                                <input class="dummy7" id="dummy7" type="hidden" value="<?php if ($_SESSION['session_order'] == '') {
    echo ($_GET['sub'] != '') ? $_GET['sub'] : $_REQUEST['all_total'];
} else {
    echo number_format($_SESSION['session_order'], 2, '.', '');
} ?>" />   
                                                                                                <input class="dummy8" id="dummy8" type="hidden" value="0" />  
                                                                                                        <?php
                                                                                                        if ($_REQUEST['search_state'] == '1') {
//     echo '<pre>';
//     print_r($_REQUEST);
//     echo '</pre>';
//     exit;
                                                                                                            $search_val = trim($_REQUEST['search_val']);
                                                                                                            $search = SearchUserEnd($search_val);
                                                                                                            $search_cat = SearchUserEndCat($search_val);
                                                                                                            ?>
                                                                                                    <div class="result_section">
                                                                                                        <span style="font-weight:bold;text-transform: uppercase;">Search Results : <?php echo $_REQUEST['search_val']; ?></span>     
                                                                                                        <table style="width: 100%;" id="search">
                                                                                                            <tr style="background-color: #F9F2DE;border-bottom: 1px solid #FF7E00;">
                                                                                                                <td style="width:70px"></td>
                                                                                                                <td style="padding:8px;font-weight:bold;width:160px;text-align: center;">Product</td>
                                                                                                                <td style="padding:8px;font-weight:bold;width:30px;text-align: center;">Price</td>
                                                                                                                <td style="padding:8px;font-weight:bold;width:40px;padding-right:14px;">Quantity</td>
                                                                                                                <td style="padding:8px;font-weight:bold;width:50px;text-align: center;padding-right:1px;">Sub Total</td>
                                                                                                                <td style="padding:8px;font-weight:bold;width:75px;text-align: center;padding-right:1px;"></td>
                                                                                                            </tr>
                                                                                                            <?php
                                                                                                            if (count($search_cat) > 0) {
                                                                                                                foreach ($search_cat as $src_temp) {
                                                                                                                    $select_items = SelectCatItem($src_temp['id']);
                                                                                                                    $i = 1;
                                                                                                                    for ($x = 2; $x <= (count($select_items) - 0); $x++) {
                                                                                                                        $series[] = $x;
                                                                                                                    }
                                                                                                                    foreach ($select_items as $src) {
                                                                                                                        $rowColor = ($i % 2 != 0) ? '#fcd9a9' : '#f9f2de';
                                                                                                                        $rowColor1 = ($i % 2 != 0) ? '#fde8cb' : '#fbf7eb';
                                                                                                                        $checked_quantity = '';
                                                                                                                        $checked_total = '0.00';
                                                                                                                        $super_id = getsuper($src['id']);
                                                                                                                        $cat_id = getcat($src['id']);
                                                                                                                        $sub_id = getsub($src['id']);
                                                                                                                        $super_name = (getsuperN($super_id) != '') ? getsuperN($super_id) : '';
                                                                                                                        $cat_name_pre = (getcatN($cat_id) != '') ? getcatN($cat_id) : '';
                                                                                                                        $cat_name = ($cat_name_pre != '') ? '>>' . $cat_name_pre : $cat_name_pre;
                                                                                                                        $sub_name_pre = (getsubN($sub_id) != '') ? getsubN($sub_id) : '';
                                                                                                                        $sub_name = ($sub_name != '') ? '>>' . $sub_name_pre : $sub_name_pre;


                                                                                                                        //$series = array(2, 3, 4, 5);
                                                                                                                        ?>
                                                                                                                        <tr>
                                                                                                                            <input type="hidden" name="count_pro" id="count_pro" value="<?php echo count($search); ?>" />
                                                                                                                            <td bgcolor="<?php echo $rowColor; ?>" style="width:50px"><div id="j"></div></td>
                                                                                                                            <td bgcolor="<?php echo $rowColor; ?>" style="text-align: left;" width="300" height="25">
                                                                                                                                <span><?php echo stripslashes($src['product_name']); ?></span></br>
                                                                                                                                <span class="trail" style="font-size: 11px;color: #2a9be3;"><?php echo $super_name . $cat_name . $sub_name; ?></span>    
                                                                                                                            </td>
                                                                                                                            <td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 35px"><?php echo $src['price']; ?><input type="hidden"  id="product_id_<?php echo $src['id']; ?>" name="price[]" value="<?php echo $src['price']; ?>" /></td>
                                                                                                                            <td bgcolor="<?php echo $rowColor; ?>"><input class="proquan quantity_check" onchange="return myFunction('<?php echo $src['id']; ?>');" onkeyup="return quantity_val('<?php echo $src['id']; ?>');" price="<?php echo $src['price']; ?>" productid="<?php echo $src['sku_id']; ?>" name="quantity[]" id="quantity_<?php echo $src['id']; ?>"  value="" style="text-align: right;padding:1px;width:64px;border:1px solid #CCC;" type="text"></td>
                                                                                                                            <td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 10px"><div class="sub_total_<?php echo $src['id']; ?>"><?php echo $checked_total; ?></div><input class="sub_total_txt_<?php echo $src['id']; ?>" id="sub_total_txt_id_<?php echo $src['id']; ?>" type="hidden" value="" /><input class="dummy1" id="dummy1" type="hidden" value="" /></td>
                                                                                                                            <td align="center" bgcolor="<?php echo $rowColor; ?>" style="width:50px">
                                                                                                                                <div id="supply_hdr" class="btn_addcart button_fixed" <?php if (in_array($i, $series)) { ?>style="display: none;"<?php } ?> >
                                                                                                                                    <img src="images/add_cart_bg.png" onclick="return add_cart('<?php echo $src['id']; ?>', '<?php echo $prd_id; ?>');" class="click_<?php echo $src['id']; ?>" id="click_<?php echo $src['id']; ?>" style="cursor: pointer;" /><img class="click_i_<?php echo $src['id']; ?>" src="images/add_to_cart.png" style="display: none;"/>
                                                                                                                                </div>
                                                                                                                            </td>             
                                                                                                                            <input type="hidden" id="product_id" name="product_id[]" value="<?php echo $src['id']; ?>" />
                                                                                                                            <input type="hidden" id="product_name" name="product_name[]" value="<?php echo mysql_escape_string(htmlentities($src['product_name'], ENT_QUOTES)); ?>" />                
                                                                                                                        </tr>
                                                                                                                        <?php
                                                                                                                        $i++;
                                                                                                                    }
                                                                                                                }
                                                                                                            } elseif (count($search) > 0) {
                                                                                                                $i = 1;
                                                                                                                for ($x = 2; $x <= (count($search) - 1); $x++) {
                                                                                                                    $series[] = $x;
                                                                                                                }
                                                                                                                foreach ($search as $src) {
                                                                                                                    $rowColor = ($i % 2 != 0) ? '#fcd9a9' : '#f9f2de';
                                                                                                                    $rowColor1 = ($i % 2 != 0) ? '#fde8cb' : '#fbf7eb';
                                                                                                                    $checked_quantity = '';
                                                                                                                    $checked_total = '0.00';
                                                                                                                    $super_id = getsuper($src['id']);
                                                                                                                    $cat_id = getcat($src['id']);
                                                                                                                    $sub_id = getsub($src['id']);
                                                                                                                    $super_name = (getsuperN($super_id) != '') ? getsuperN($super_id) . ' >> ' : '';
                                                                                                                    $cat_name = (getcatN($cat_id) != '') ? getcatN($cat_id) : '';
                                                                                                                    $sub_name = (getsubN($sub_id) != '') ? ' >>' . getsubN($sub_id) : '';
                                                                                                                    ?> 
                                                                                                                    <tr>
                                                                                                                        <input type="hidden" name="count_pro" id="count_pro" value="<?php echo count($search); ?>" />
                                                                                                                        <td bgcolor="<?php echo $rowColor; ?>" style="width:50px"><div id="j"></div></td>
                                                                                                                        <td bgcolor="<?php echo $rowColor; ?>" style="text-align: left;" width="300" height="25">
                                                                                                                            <span><?php echo stripslashes($src['product_name']); ?></span></br>
                                                                                                                            <span class="trail" style="font-size: 11px;color: #2a9be3;"><?php echo $super_name . $cat_name . $sub_name; ?></span>    
                                                                                                                        </td>
                                                                                                                        <td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 35px"><?php echo $src['price']; ?><input type="hidden"  id="product_id_<?php echo $src['id']; ?>" name="price[]" value="<?php echo $src['price']; ?>" /></td>
                                                                                                                        <td bgcolor="<?php echo $rowColor; ?>"><input class="proquan quantity_check" onchange="return myFunction('<?php echo $src['id']; ?>');" onkeyup="return quantity_val('<?php echo $src['id']; ?>');" price="<?php echo $src['price']; ?>" productid="<?php echo $src['sku_id']; ?>" name="quantity[]" id="quantity_<?php echo $src['id']; ?>"  value="" style="text-align: right;padding:1px;width:64px;border:1px solid #CCC;" type="text"></td>
                                                                                                                        <td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 10px"><div class="sub_total_<?php echo $src['id']; ?>"><?php echo $checked_total; ?></div><input class="sub_total_txt_<?php echo $src['id']; ?>" id="sub_total_txt_id_<?php echo $src['id']; ?>" type="hidden" value="" /><input class="dummy1" id="dummy1" type="hidden" value="" /></td>
                                                                                                                        <td align="center" bgcolor="<?php echo $rowColor; ?>" style="width:50px">
                                                                                                                            <div id="supply_hdr" class="btn_addcart button_fixed"  >
                                                                                                                                <img src="images/add_cart_bg.png" onclick="return add_cart('<?php echo $src['id']; ?>', '<?php echo $prd_id; ?>');" class="click_<?php echo $src['id']; ?>" id="click_<?php echo $src['id']; ?>" style="cursor: pointer;" /><img class="click_i_<?php echo $src['id']; ?>" src="images/add_to_cart.png" style="display: none;"/>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <input type="hidden" id="product_id" name="product_id[]" value="<?php echo $src['id']; ?>" />
                                                                                                                        <input type="hidden" id="product_name" name="product_name[]" value="<?php echo mysql_escape_string(htmlentities($src['product_name'], ENT_QUOTES)); ?>" />                
                                                                                                                    </tr>
                                                                                                            <?php
                                                                                                            $i++;
                                                                                                        }
                                                                                                    } else {
                                                                                                        ?>
                                                                                                                <tr>
                                                                                                                    <td bgcolor="#fcd9a9" colspan="6" align="center">There is no products.</td>             
                                                                                                                </tr>
                                                                                                            <?php
                                                                                                        }
                                                                                                        ?>
                                                                                                        </table>

                                                                                                    </div>
<?php
} else {
    foreach ($Super as $super) {
        $c_id = $super['id'];
        $Category = getCategoryU($c_id);
        ?>
                                                                                                        <div class="super_cat" style="clear:both;" id="acc"><h1 style="text-align: left; text-transform:uppercase; line-height:22px !important; cursor: pointer; width: 744px; font-size:22px;"><div style="width:25px; float:left;"><img src="store_files/r1.png"></div><?php echo $super['category_name']; ?></h1></div>
                                                                                                        <ul class="acc sub_cat" id="acc" style="display:none;">
                                                                                                                            <?php
                                                                                                                            foreach ($Category as $Cat) {
                                                                                                                                $s_id = $Cat['id'];
                                                                                                                                $SubCategory = getSubCategoryU($s_id);
                                                                                                                                ?>
                                                                                                                <li class="parent"> 
                                                                                                                    <h2><div style="width:25px; margin-left:45px; float:left;"><img src="store_files/r1.png"></div><div id="title_name"><h2 style="border:none;padding-top: 0px; font-size:18px !important; width:100%;text-align:left;text-transform: uppercase"><?php echo $Cat['category_name']; ?></h2></div>
                                                                                                                        <!--<div class="eachlistfullTotal" catotal="" style="float: right; font-size: 18px;font-weight: bold;margin-top: -33px;"></div>-->
                                                                                                                    </h2>

                                                                                                                    <div class="acc-section" style="margin-bottom: 10px; display: none;">
                                                                                                                        <div class="acc-content">

                                                                                                                            <ul class="acc" id="nested108"> 
            <?php
            foreach ($SubCategory as $Subc) {
                $su_id = $Subc['id'];
                $ProductsUser = getProductsU($c_id, $s_id, $su_id);
                ?>    
                                                                                                                                    <li>
                                                                                                                                        <h3><div style="width:25px;margin-left:65px; float:left;"><img src="store_files/r2.png"></div><div><h3 style="border:none;padding-top:0px;padding-bottom:0px;width:100%;text-align:left;text-transform: uppercase"><?php echo $Subc['category_name']; ?></h3></div><div class="oline"></div>
                                                                                                                                            <!--<div class="eachlistTotal" sectotal="" style="float: right; margin-top: -12px;"></div>-->
                                                                                                                                        </h3>
                                                                                                                                        <div style="display: none;" class="acc-section">

                                                                                                                                                        <?php if (count($ProductsUser) > 0) { ?>  
                                                                                                                                                <div class="acc-content">  
                                                                                                                                                    <table class="cat_products"> 
                                                                                                                                                        <tbody>
                                                                                                                                                            <tr style="background-color: #F9F2DE;border-bottom: 1px solid #FF7E00;">
                                                                                                                                                                <td style="width:70px"></td>
                                                                                                                                                                <td style="padding:8px;font-weight:bold;width:160px;text-align: center;">Product</td>
                                                                                                                                                                <td style="padding:8px;font-weight:bold;width:30px;text-align: center;">Price</td>
                                                                                                                                                                <td style="padding:8px;font-weight:bold;width:40px;padding-right:14px;">Quantity</td>
                                                                                                                                                                <td style="padding:8px;font-weight:bold;width:50px;text-align: center;padding-right:1px;">Sub Total</td>
                                                                                                                                                                <td style="padding:8px;font-weight:bold;width:75px;text-align: center;padding-right:1px;"></td>
                                                                                                                                                            </tr>

                    <?php
                    $i = 1;
                    foreach ($ProductsUser as $Product) {
                        $rowColor = ($i % 2 != 0) ? '#fcd9a9' : '#f9f2de';
                        $rowColor1 = ($i % 2 != 0) ? '#fde8cb' : '#fbf7eb';
                        $price_product = in_array($Product['id'], $sprice_product) ? $sprice_dprice[$Product['id']] : $Product['price'];
                        $checked_quantity = in_array($Product['id'], $checked_product) ? $checked_price[$Product['id']] : '';
                        $checked_total = in_array($Product['id'], $checked_product) ? $checked_sub[$Product['id']] : '0.00';
                        $fav_pro = in_array($Product['id'], $fav_product) ? 'fav' : 'un-fav';
                        $pulse  =  in_array($Product['id'], $fav_product) ? 'pulse' : '';
                        $fav_title = in_array($Product['id'], $fav_product) ? 'Click here to Un-favorites' : 'Click here to Favorites';
                        ?>

<tr style="background-color: #F9F2DE;">        
    <td bgcolor="<?php echo $rowColor; ?>" style="width:50px"><div style="margin-left: 25px;" id="fav_id_<?php echo $Product['id']; ?>"><img src="images/<?php echo $fav_pro; ?>.png" class="<?php echo $pulse; ?>" border="0px" style="cursor: pointer;" title="<?php echo $fav_title; ?>" onclick="return add_favorites('<?php echo $Product['id']; ?>', '<?php echo $_SESSION['sohorepro_userid']; ?>');" /></div></td>
    <td bgcolor="<?php echo $rowColor; ?>" style="text-align: left;" width="300" height="25"><span><?php echo stripslashes($Product['product_name']); ?></span></td>
    <td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 35px"><?php echo $price_product; ?><input type="hidden" id="product_id_<?php echo $Product['id']; ?>" name="price[]" value="<?php echo $price_product; ?>" /></td>
    <td bgcolor="<?php echo $rowColor; ?>"><input class="proquan quantity_check" onchange="return myFunction('<?php echo $Product['id']; ?>');" onkeyup="return quantity_val('<?php echo $Product['id']; ?>');" price="<?php echo $price_product; ?>" productid="<?php echo $Product['sku_id']; ?>" name="quantity[]" id="quantity_<?php echo $Product['id']; ?>" <?php if ($checked_quantity != '') {
echo 'readonly="readonly"';
} ?> value="<?php echo $checked_quantity; ?>" style="text-align: right;padding:1px;width:64px;border:1px solid #CCC;" type="text"></td>
    <td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 10px"><div class="sub_total_<?php echo $Product['id']; ?>"><?php echo $checked_total; ?></div><input class="sub_total_txt_<?php echo $Product['id']; ?>" id="sub_total_txt_id_<?php echo $Product['id']; ?>" type="hidden" value="" /><input class="dummy1" id="dummy1" type="hidden" value="" /></td>
    <td bgcolor="<?php echo $rowColor; ?>" style="width:50px"></td>
    <input type="hidden" id="product_id" name="product_id[]" value="<?php echo $Product['id']; ?>" />
    <input type="hidden" id="product_name" name="product_name[]" value="<?php echo mysql_escape_string(htmlentities($Product['product_name'], ENT_QUOTES)); ?>" />
    <input type="hidden" id="super_category_id" name="super_category_id[]" value="<?php echo $c_id; ?>" />
    <input type="hidden" id="category_id" name="category_id[]" value="<?php echo $s_id; ?>" />
    <input type="hidden" id="sub_category_id" name="sub_category_id[]" value="<?php echo $su_id; ?>" /> 

                                                                                                                                                                </tr>
                        <?php
                        $i++;
                    }
                    ?>

                                                                                                                                                        </tbody>
                                                                                                                                                    </table>



                                                                                                                                                    <div id="to_tal" style="border-top:1px solid #FF7E00;background-color: #F9F2DE; display:block !important;">
                                                                                                                                                        <div class="sectionTotal" style="float:right;height:25px;margin-bottom:6px;border-bottom:1px solid #F9E7B2;background-color: #F9F2DE;width:98.6%; padding-right: 0px;">
                                                                                                                                                            <div style="font-size:12px;text-align: right; font-weight: bold;width:566px; float: left;" class="add_cart_rm">&nbsp;</div> 
                                                                                                                                                            <div id="s_total1" style="font-size:13px;text-align: left;width: 66px;font-weight: bold;float:left;" >&nbsp;</div>
                                                                                                                                                            <div class="btn_addcart"><img src="images/add_cart_bg.png" onclick="return add_cart('<?php echo $Product['id']; ?>', '<?php echo $prd_id; ?>');" class="click_<?php echo $Product['id']; ?>" id="click_<?php echo $Product['id']; ?>" style="cursor: pointer;" /><img class="click_i_<?php echo $Product['id']; ?>" src="images/add_to_cart.png" style="display: none;"/></div>
                                                                                                                                                        </div> 

                                                                                                                                                    </div>
                <?php } ?>     

                                                                                                                                            </div>
                                                                                                                                    </li>
            <?php } ?>




<li>
            <?php
            $super_subcatProductsUser = getsuper_subcatProducts($c_id, $s_id);
            foreach ($super_subcatProductsUser as $get_id) {
                $id_array[] = $get_id['id'];
            }
            $sub_price_id = sizeof($id_array);
            if (count($super_subcatProductsUser) > 0) {
                ?>

        <table width="100%" class="cat_products"> 
            <tbody><tr style="background-color: #F9F2DE;border-bottom: 1px solid #FF7E00;">
                    <td style="width:70px"></td>
                    <td style="padding:8px;font-weight:bold;width:160px;text-align: center;">Product</td>
                    <td style="padding:8px;font-weight:bold;width:30px;text-align: center;">Price</td>
                    <td style="padding:8px;font-weight:bold;width:40px;padding-right:14px;">Quantity</td>
                    <td style="padding:8px;font-weight:bold;width:50px;text-align: center;padding-right:1px;">Sub Total</td>
                    <td style="padding:8px;font-weight:bold;width:75px;text-align: center;padding-right:1px;"></td>
                </tr>

<?php
$i = 1;
$count = count($super_subcatProductsUser);

foreach ($super_subcatProductsUser as $Product) {
$rowColor = ($i % 2 != 0) ? '#fcd9a9' : '#f9f2de';
$rowColor1 = ($i % 2 != 0) ? '#fde8cb' : '#fbf7eb';
$price_product = in_array($Product['id'], $sprice_product) ? $sprice_dprice[$Product['id']] : $Product['price'];
$checked_quantity = in_array($Product['id'], $checked_product) ? $checked_price[$Product['id']] : '';
$checked_total = in_array($Product['id'], $checked_product) ? $checked_sub[$Product['id']] : '0.00';
$fav_pro = in_array($Product['id'], $fav_product) ? 'fav' : 'un-fav';
$pulse  =  in_array($Product['id'], $fav_product) ? 'pulse' : '';
$fav_title = in_array($Product['id'], $fav_product) ? 'Click here to Un-favorites' : 'Click here to Favorites';
?>

<tr style="background-color: #F9F2DE;">        
    <td bgcolor="<?php echo $rowColor; ?>" style="width:50px"><div style="margin-left: 25px;" id="fav_id_<?php echo $Product['id']; ?>"><img src="images/<?php echo $fav_pro; ?>.png" class="<?php echo $pulse; ?>" border="0px" style="cursor: pointer;" title="<?php echo $fav_title; ?>" onclick="return add_favorites('<?php echo $Product['id']; ?>', '<?php echo $_SESSION['sohorepro_userid']; ?>');" /></div></td>
    <td bgcolor="<?php echo $rowColor; ?>" style="text-align: left;" width="300" height="25"><span><?php echo stripslashes($Product['product_name']); ?></span></td>
    <td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 35px"><?php echo $price_product; ?><input type="hidden" id="product_id_<?php echo $Product['id']; ?>" name="price[]" value="<?php echo $price_product; ?>" /></td>
    <td bgcolor="<?php echo $rowColor; ?>"><input class="proquan quantity_check"  onchange="return myFunction('<?php echo $Product['id']; ?>');" onkeyup="return quantity_val('<?php echo $Product['id']; ?>', '<?php echo $sub_price_id; ?>');" price="<?php echo $price_product; ?>" productid="<?php echo $Product['sku_id']; ?>" name="quantity[]" id="quantity_<?php echo $Product['id']; ?>" <?php if ($checked_quantity != '') {
echo 'readonly="readonly"';
} ?> value="<?php echo $checked_quantity; ?>"  style="text-align: right;padding:1px;width:64px;border:1px solid #CCC;" type="text"></td>
    <td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 10px"><div class="sub_total_<?php echo $Product['id']; ?>"><?php echo $checked_total; ?></div><input class="sub_total_txt_<?php echo $Product['id']; ?>" id="sub_total_txt_id_<?php echo $Product['id']; ?>" type="hidden" value="" /><input class="dummy" id="dummy" type="hidden" value="" /><input class="dummy1" id="dummy1" type="hidden" value="" /></td>
    <td bgcolor="<?php echo $rowColor; ?>" style="width:50px"></td>

    <input type="hidden" id="product_id" name="product_id[]" value="<?php echo $Product['id']; ?>" />
    <input type="hidden" id="product_name" name="product_name[]" value="<?php echo $Product['product_name']; ?>" />
    <input type="hidden" id="super_category_id" name="super_category_id[]" value="<?php echo $c_id; ?>" />
    <input type="hidden" id="category_id" name="category_id[]" value="<?php echo $s_id; ?>" />
    <input type="hidden" id="sub_category_id" name="sub_category_id[]" value="<?php echo $su_id; ?>" /> 

</tr>
<?php
$i++;
$product_id_array[] = $Product['id'];
}
$prd_id = implode(",", $product_id_array);
?>
                <input type="hidden" name="count_pro" id="count_pro" value="<?php echo $count; ?>" />
            </tbody></table>


                                                                                                                                        <div id="to_tal" style="border-top:1px solid #FF7E00;background-color: #F9F2DE; display:block !important;">
                                                                                                                                            <div class="sectionTotal" style="float:right;height:25px;margin-bottom:6px;border-bottom:1px solid #F9E7B2;background-color: #F9F2DE;width:98.6%; padding-right: 0px;">
                                                                                                                                                <div style="font-size:12px;text-align: right; font-weight: bold;width:566px; float: left;" class="add_cart_rm">&nbsp;</div>
                                                                                                                                                <div id="s_total1" class="sub_id_1_<?php echo $Product['id']; ?>" style="font-size:13px;text-align: left;width: 66px;font-weight: bold;float:left;">&nbsp;<input type="hidden" id="sub_id_txt_<?php echo $Product['id']; ?>" value="" /></div>
                                                                                                                                                <div class="btn_addcart"><img src="images/add_cart_bg.png" onclick="return add_cart('<?php echo $Product['id']; ?>', '<?php echo $prd_id; ?>');" class="click_<?php echo $Product['id']; ?>" id="click_<?php echo $Product['id']; ?>" style="cursor: pointer;" /><img class="click_i_<?php echo $Product['id']; ?>" src="images/add_to_cart.png" style="display: none;"/></div>
                                                                                                                                            </div>
                                                                                                                                        </div>  
                                                                                                                    <?php } ?> 

                                                                                                                                </li>     





                                                                                                                            </ul>

                                                                                                                        </div>
                                                                                                                    </div>

                                                                                                                </li> 
        <?php } ?>





                                                                                                            <li>

                                                                                                                        <?php
                                                                                                                        $superProductsUser = getsuperProducts($c_id);

                                                                                                                        if (count($superProductsUser) > 0) {
                                                                                                                            ?>

                                                                                                                    <table width="100%" class="cat_products"> 
                                                                                                                        <tbody><tr style="background-color: #F9F2DE;border-bottom: 1px solid #FF7E00;">
                                                                                                                                <td style="width:70px"></td>
                                                                                                                                <td style="padding:8px;font-weight:bold;width:160px;text-align: center;">Product</td>
                                                                                                                                <td style="padding:8px;font-weight:bold;width:30px;text-align: center;">Price</td>
                                                                                                                                <td style="padding:8px;font-weight:bold;width:40px;padding-right:14px;">Quantity</td>
                                                                                                                                <td style="padding:8px;font-weight:bold;width:50px;text-align: center;padding-right:1px;">Sub Total</td>
                                                                                                                                <td style="padding:8px;font-weight:bold;width:75px;text-align: center;padding-right:1px;"></td>
                                                                                                                            </tr>

            <?php
            $i = 1;
            foreach ($superProductsUser as $Product) {
                $rowColor = ($i % 2 != 0) ? '#fcd9a9' : '#f9f2de';
                $rowColor1 = ($i % 2 != 0) ? '#fde8cb' : '#fbf7eb';
                $price_product = in_array($Product['id'], $sprice_product) ? $sprice_dprice[$Product['id']] : $Product['price'];
                $checked_quantity = in_array($Product['id'], $checked_product) ? $checked_price[$Product['id']] : '';
                $checked_total = in_array($Product['id'], $checked_product) ? $checked_sub[$Product['id']] : '0.00';
                $fav_pro = in_array($Product['id'], $fav_product) ? 'fav' : 'un-fav';
                $pulse  =  in_array($Product['id'], $fav_product) ? 'pulse' : '';
                $fav_title = in_array($Product['id'], $fav_product) ? 'Click here to Un-favorites' : 'Click here to Favorites';
                ?> 
<tr style="background-color: #F9F2DE;">        
    <td bgcolor="<?php echo $rowColor; ?>" style="width:50px"><div style="margin-left: 25px;" id="fav_id_<?php echo $Product['id']; ?>"><img src="images/<?php echo $fav_pro; ?>.png" class="<?php echo $pulse; ?>" border="0px" style="cursor: pointer;" title="<?php echo $fav_title; ?>" onclick="return add_favorites('<?php echo $Product['id']; ?>', '<?php echo $_SESSION['sohorepro_userid']; ?>');" /></div></td>
    <td bgcolor="<?php echo $rowColor; ?>" style="text-align: left;" width="300" height="25"><span><?php echo str_replace("'", '"', stripslashes($Product['product_name'])); ?></span></td>
    <td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 35px"><?php echo $price_product; ?><input type="hidden" id="product_id_<?php echo $Product['id']; ?>" name="price[]" value="<?php echo $price_product; ?>" /></td>
    <td bgcolor="<?php echo $rowColor; ?>"><input class="proquan quantity_check"  onchange="return myFunction('<?php echo $Product['id']; ?>');" onkeyup="return quantity_val('<?php echo $Product['id']; ?>', '<?php echo $sub_price_id; ?>');" price="<?php echo $price_product; ?>" productid="<?php echo $Product['sku_id']; ?>" name="quantity[]" id="quantity_<?php echo $Product['id']; ?>" <?php if ($checked_quantity != '') {
echo 'readonly="readonly"';
} ?> value="<?php echo $checked_quantity; ?>"  style="text-align: right;padding:1px;width:64px;border:1px solid #CCC;" type="text"></td>
    <td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 10px"><div class="sub_total_<?php echo $Product['id']; ?>"><?php echo $checked_total; ?></div><input class="sub_total_txt_<?php echo $Product['id']; ?>" id="sub_total_txt_id_<?php echo $Product['id']; ?>" type="hidden" value="" /><input class="dummy" id="dummy" type="hidden" value="" /><input class="dummy1" id="dummy1" type="hidden" value="" /></td>
    <td bgcolor="<?php echo $rowColor; ?>" style="width:50px"></td>
    <input type="hidden" id="product_id" name="product_id[]" value="<?php echo $Product['id']; ?>" />
    <input type="hidden" id="product_name" name="product_name[]" value="<?php echo mysql_escape_string(htmlentities($Product['product_name'], ENT_QUOTES)); ?>" />
    <input type="hidden" id="super_category_id" name="super_category_id[]" value="<?php echo $c_id; ?>" />
    <input type="hidden" id="category_id" name="category_id[]" value="<?php echo $s_id; ?>" />
    <input type="hidden" id="sub_category_id" name="sub_category_id[]" value="<?php echo $su_id; ?>" /> 

</tr>
                <?php
                $i++;
            }
            ?>

                                                                                                                        </tbody></table>


                                                                                                                    <div id="to_tal" style="border-top:1px solid #FF7E00;background-color: #F9F2DE; display:block !important;">
                                                                                                                        <div class="sectionTotal" style="float:right;height:25px;margin-bottom:6px;border-bottom:1px solid #F9E7B2;background-color: #F9F2DE;width:98.6%; padding-right: 0px;">
                                                                                                                            <div style="font-size:12px;text-align: right; font-weight: bold;width:566px; float: left;" class="add_cart_rm">&nbsp;</div> <div id="s_total1" style="font-size:13px;text-align: left;width: 66px;font-weight: bold;float:left;">&nbsp;</div><div class="btn_addcart"><img src="images/add_cart_bg.png" onclick="return add_cart('<?php echo $Product['id']; ?>', '<?php echo $prd_id; ?>');" class="click_<?php echo $Product['id']; ?>" id="click_<?php echo $Product['id']; ?>" style="cursor: pointer;" /><img class="click_i_<?php echo $Product['id']; ?>" src="images/add_to_cart.png" style="display: none;"/></div>
                                                                                                                        </div>
                                                                                                                    </div>      
        <?php } ?>        

                                                                                                            </li>    



                                                                                                        </ul>







        <?php
    }
}
?>
                                                                                            </form>


                                                                                            <!--<div class="bkgd-stripes-orange">&nbsp;</div>-->
                                                                                            <div class="inPageCartBlock curr_tot_div1">

                                                                                                Current Order Total : $<span id="" class="total_order curr_ord_tot"><?php if ($_SESSION['session_order'] == '') {
    if ($_GET['sub'] != '') {
        echo $_GET['sub'];
    } else { ?><?php if ($_REQUEST['all_total'] != '') {
            echo number_format($_REQUEST['all_total'], 2, '.', '');
        } else { ?>0.00<?php }
    }
} else {
    echo number_format($_SESSION['session_order'], 2, '.', '');
} ?></span>
                                                                                                <input type="hidden" class="total_order_txt" id="total_order_val" name="all_total" value="<?php if ($_SESSION['session_order'] == '') {
    echo ($_GET['sub'] != '') ? $_GET['sub'] : $_REQUEST['all_total'];
} else {
    echo number_format($_SESSION['session_order'], 2, '.', '');
} ?>"/>

                                                                                            </div>
<?php
$state_all = StateAll();
?>
                                                                                            <!--<div style="margin-bottom:0;" class="bkgd-stripes-orange">&nbsp;</div>-->
                                                                                            <div style="clear:both;"></div>
                                                                                            <div id="login_window">    	
                                                                                                <div class="close"></div>
                                                                                                <span class="ecs_tooltip">Press Esc to close <span class="arrow"></span></span>
                                                                                                <div id="popup_content" class="checkout_login"> <!--your content start-->
                                                                                                    <h1>Sign In With Your Account</h1>
                                                                                                    <span id="alert_msg" style="color:#FF0000;font-size: 12px;"></span>
                                                                                                    <ul>
                                                                                                        <li><label>User name</label><input name="usr_name" id="usr_name" type="text" /></li> 
                                                                                                        <li><label>Password</label><input name="usr_pass" id="usr_pass" type="password" /></li> 
                                                                                                        <li><input type="submit" value="LOGIN" onclick="return login_checkout();" /></li> 
                                                                                                        <li > <a onclick="return goto_new_new_exist();" class="account_link" style="cursor: pointer;" >CREATE AN ACCOUNT</a> | <a onclick="return goto_new_checkout();" class="pointer">GUEST CHECKOUT</a></li>
                                                                                                    </ul>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div id="login_shipp_window" style="width: 644px;left: 26%;">    	
                                                                                                <div class="close"></div>
                                                                                                <span class="ecs_tooltip">Press Esc to close <span class="arrow"></span></span>
                                                                                                <div id="popup_content" >
                                                                                                    <div class="shipp_window">

                                                                                                        <!--your content start-->
                                                                                                        <h1>Enter the Shipping Address</h1>
                                                                                                        <span id="alert_msg" style="color:#FF0000;font-size: 12px;"></span>
                                                                                                        <ul>
                                                                                                            <li style="margin-top: 37px;"><label>Address 1</label>
                                                                                                                <textarea class="select_text" name="add1" id="add1"></textarea>
                                                                                                            </li> 
                                                                                                            <li><label>Address 2</label>
                                                                                                                <textarea class="select_text" name="add2" id="add2"></textarea>
                                                                                                            </li>                    
                                                                                                            <li><label>City</label>
                                                                                                                <input type="text" class="text_shipp" name="city" id="city" />
                                                                                                            </li>
                                                                                                            <li><label>State</label>
                                                                                                                <select name="state" id="state" class="select_text">
                                                                                                                    <option value="0">Select state</option>
                                                                                                                    <?php foreach ($state_all as $state) { ?>
                                                                                                                        <?php if ($state['state_id'] == '33') { ?>
                                                                                                                            <option value="<?php echo $state['state_id'] ?>" selected="selected"><?php echo $state['state_abbr']; ?></option>
    <?php } else { ?>
                                                                                                                            <option value="<?php echo $state['state_id'] ?>"><?php echo $state['state_abbr']; ?></option>
    <?php }
} ?>
                                                                                                                </select>
                                                                                                            </li>
                                                                                                            <li><label>Zip</label>
                                                                                                                <input type="text" class="text_shipp" name="zip" id="zip" />
                                                                                                            </li>                   
                                                                                                        </ul>
                                                                                                    </div>


                                                                                                    <div class="shipp_window" style="border-right: 0px;margin-top: -20px;">

                                                                                                        <!--your content start-->
                                                                                                        <h1>Enter the Billing Address</h1>
                                                                                                        <span id="alert_msg" style="color:#FF0000;font-size: 12px;"></span>
                                                                                                        <ul>
                                                                                                            <li><input type="checkbox" name="shipp_check" id="shipp_check" onchange="return clone();"/>&nbsp;Same as Shipping</li>
                                                                                                            <li><label>Address 1</label>
                                                                                                                <textarea class="select_text" name="bill_add1" id="bill_add1"></textarea>
                                                                                                            </li> 
                                                                                                            <li><label>Address 2</label>
                                                                                                                <textarea class="select_text" name="bill_add2" id="bill_add2"></textarea>
                                                                                                            </li>                    
                                                                                                            <li><label>City</label>
                                                                                                                <input type="text" class="text_shipp" name="bill_city" id="bill_city" />
                                                                                                            </li>
                                                                                                            <li><label>State</label>
                                                                                                                <select name="bill_state" id="bill_state" class="select_text">
                                                                                                                    <option value="0">Select state</option>
<?php foreach ($state_all as $state) { ?>                        
                                                                                                                        <option value="<?php echo $state['state_id'] ?>"><?php echo $state['state_abbr']; ?></option>
<?php } ?>
                                                                                                                </select>
                                                                                                            </li>
                                                                                                            <li><label>Zip</label>
                                                                                                                <input type="text" class="text_shipp" name="bill_zip" id="bill_zip" />
                                                                                                            </li>
                                                                                                            <li><input type="submit" style="margin-top: 5px;" value="NEXT" onclick="return goto_test_checkout();" /></li>                     
                                                                                                        </ul>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="login_loader"></div>
                                                                                            <div id="backgroundPopup"></div>
                                                                                            <script type="text/javascript">
                                                                                                $(document).ready(function()
                                                                                                {
                                                                                                    $(".ui-autocomplete-input").keyup(function()
                                                                                                    {
                                                                                                        var check = $(this).val;
                                                                                                        if (check != '')
                                                                                                        {
                                                                                                            //alert(check);
                                                                                                            $('.addstroeproductActionLink').attr('disabled', false);
                                                                                                        } else {
                                                                                                            $('.addstroeproductActionLink').attr('disabled', true);
                                                                                                        }
                                                                                                    });


                                                                                                    $('.quantity_check').keydown(function(event) {

                                                                                                        if (event.shiftKey == true) {
                                                                                                            event.preventDefault();
                                                                                                        }

                                                                                                        if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46) {

                                                                                                        } else {
                                                                                                            event.preventDefault();
                                                                                                        }

                                                                                                        if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                                                                                                            event.preventDefault();
                                                                                                        if ($(this).length >= 3) {
                                                                                                            alert('jass');
                                                                                                        }
                                                                                                    });

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

                                                                                                function validate()
                                                                                                {
                                                                                                    var reference_v = document.getElementById('jobref').value;
                                                                                                    var trim_v = reference_v.trim();
                                                                                                    if (trim_v == '')
                                                                                                    {
                                                                                                        alert("Please enter the job reference number");
                                                                                                        document.getElementById('jobref').focus();
                                                                                                        return false;
                                                                                                    }

                                                                                                    var user_log = $(".dummy5").val();
                                                                                                    if (user_log == '') {
                                                                                                        alert("You must enter the quantity any one product.");
                                                                                                        return false;
                                                                                                    }

                                                                                                    var user_log = document.getElementById('user_session').value;
                                                                                                    if (user_log == '') {

                                                                                                        loading(); // loading
                                                                                                        setTimeout(function() { // then show popup, deley in .5 second
                                                                                                            loginPopup(); // function show popup 
                                                                                                        }, 500); // .5 second
                                                                                                        return false;
                                                                                                    }
                                                                                                    var jobref = document.getElementById('jobref').value;
                                                                                                    if (jobref != '') {
                                                                                                        $("#dummy_reference").val(jobref);
                                                                                                    }
                                                                                                    return true;
                                                                                                }

                                                                                                function search_test_r()
                                                                                                {
                                                                                                    var search_val = document.getElementById('search_val').value;
                                                                                                    if (search_val == '') {
                                                                                                        alert('Please put any word in search box.');
                                                                                                        document.getElementById('search_val').focus();
                                                                                                        return false;
                                                                                                    }
                                                                                                    return true;
                                                                                                }


                                                                                                function loading_supply() {
                                                                                                    $("#login_window").fadeOut("normal");
                                                                                                    $("#backgroundPopup").css("opacity", "0.7");
                                                                                                    $("div.login_loader").show();
                                                                                                }

                                                                                                function loading() {
                                                                                                    $("div.login_loader").show();
                                                                                                }

                                                                                                function loginPopup() {
                                                                                                    closeloading(); // fadeout loading
                                                                                                    $("#login_window").fadeIn(0500); // fadein popup div
                                                                                                    $("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
                                                                                                    $("#backgroundPopup").fadeIn(0001);
                                                                                                }

                                                                                                function loginShippPopup() {
                                                                                                    closeloading(); // fadeout loading
                                                                                                    $("#login_shipp_window").fadeIn(0500); // fadein popup div
                                                                                                    $("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
                                                                                                    $("#backgroundPopup").fadeIn(0001);
                                                                                                }

                                                                                                function closeloading() {
                                                                                                    $("div.login_loader").fadeOut('normal');
                                                                                                }

                                                                                                function disablePopup() {
                                                                                                    $("#login_window").fadeOut("normal");
                                                                                                    $("#login_shipp_window").fadeOut("normal");
                                                                                                    $("#backgroundPopup").fadeOut("normal");
                                                                                                }


                                                                                                function set_val(str) {
                                                                                                    //alert(str);
                                                                                                    $(".set_val").val(str);

                                                                                                }

                                                                                                function dummy_reference()
                                                                                                {
                                                                                                    var jobref = document.getElementById('jobref').value;
                                                                                                    $("#dummy_reference").val(jobref);
                                                                                                }

                                                                                                function goto_new_checkout()
                                                                                                {
                                                                                                    loading(); // loading
                                                                                                    $("#login_window").fadeOut("normal");
                                                                                                    setTimeout(function() { // then show popup, deley in .5 second
                                                                                                        loginShippPopup(); // function show popup 
                                                                                                    }, 500); // .5 second 
                                                                                            //             $.ajax
                                                                                            //             ({
                                                                                            //                type: "POST",
                                                                                            //                    url: "admin/get_child.php",
                                                                                            //                    data: "supply_usr_id="+user_id+"&staff_id="+staff_id+"&reference="+jobref,
                                                                                            //                    beforeSend: loading_supply,
                                                                                            //                    complete: closeloading,
                                                                                            //                    success: function(option)
                                                                                            //                    {
                                                                                            //                      if(option = '1'){ 
                                                                                            //                           window.location="shoppingcart.php?usr_id="+user_id;
                                                                                            //                      }
                                                                                            //                    }
                                                                                            //             });

                                                                                                }

                                                                                                function goto_new_new_exist()
                                                                                                {
                                                                                                    var ref = document.getElementById('jobref').value;
                                                                                                    loading(); // loading
                                                                                                    window.location = "existing_customer.php?ref=" + ref;
                                                                                                }


                                                                                                function login_checkout()
                                                                                                {
                                                                                                    var jobref = document.getElementById('jobref').value;
                                                                                                    var usr_name = document.getElementById('usr_name').value;
                                                                                                    var usr_pass = document.getElementById('usr_pass').value;

                                                                                                    if (usr_pass != '')
                                                                                                    {
                                                                                                        $.ajax
                                                                                                                ({
                                                                                                                    type: "POST",
                                                                                                                    url: "admin/get_child.php",
                                                                                                                    data: "reference_login=" + jobref +
                                                                                                                            "&usr_name_chk=" + usr_name +
                                                                                                                            "&usr_pass_chk=" + usr_pass,
                                                                                                                    beforeSend: loading_supply,
                                                                                                                    complete: closeloading,
                                                                                                                    success: function(option)
                                                                                                                    {
                                                                                                                        if (option == true) {
                                                                                                                            window.location = "shoppingcart.php";
                                                                                                                        }
                                                                                                                        else {
                                                                                                                            loading(); // loading
                                                                                                                            setTimeout(function() { // then show popup, deley in .5 second
                                                                                                                                loginPopup(); // function show popup 
                                                                                                                            }, 500); // .5 second
                                                                                                                            document.getElementById("alert_msg").innerHTML = "User Credentials In-Correct";
                                                                                                                            return false;
                                                                                                                        }
                                                                                                                    }
                                                                                                                });

                                                                                                    }
                                                                                                    else {
                                                                                                        document.getElementById("alert_msg").innerHTML = "Enter the user name and password";
                                                                                                        document.getElementById("usr_name").focus();
                                                                                                        return false;
                                                                                                    }
                                                                                                }


                                                                                                function myFunction(id)
                                                                                                {
                                                                                                    var total_cart_val = document.getElementById('total_cart_val').value;
                                                                                                    var quantity = document.getElementById('quantity_' + id).value;
                                                                                                    var cart_val = document.getElementById('dummy5').value;
                                                                                                    var jass = document.getElementById('dummy7').value;
                                                                                                    var total_order_val = document.getElementById('dummy').value;

                                                                                                    var dummy7 = (Number(total_order_val) + Number(jass));
                                                                                                    $(".dummy5").val(Number(cart_val) + Number(quantity));

                                                                                                    $(".total_cart_val").val(cart_val);
                                                                                                    $(".dummy6").val(total_order_val);
                                                                                                    $(".dummy7").val(dummy7);
                                                                                                }

                                                                                                function quantity_val(str, sub_id)
                                                                                                {
                                                                                                    //return str;
                                                                                                    var count = "2";
                                                                                                    var quantity = document.getElementById('quantity_' + str).value;
                                                                                                    var price = document.getElementById('product_id_' + str).value;
                                                                                                    var user_log = document.getElementById('user_session').value;
                                                                                                    var jobref = document.getElementById('jobref').value;
                                                                                                    var sub_total = (quantity * price);

                                                                                                    var len = quantity.length;
                                                                                                    if (len > count) {
                                                                                                        quantity = quantity.substring(0, count);
                                                                                                        document.getElementById('quantity_' + str).value = quantity;
                                                                                                        return false;
                                                                                                    }
                                                                                                    $(".sub_total_" + str).html(sub_total.toFixed(2));
                                                                                                    $(".sub_total_txt_" + str).val(sub_total.toFixed(2));
                                                                                                    $(".dummy").val(sub_total.toFixed(2));
                                                                                                    $(".dummy1").val(str);
                                                                                                    $(".sub_id_" + sub_id).html(sub_total.toFixed(2));
                                                                                                    $(".sub_id_txt_" + sub_id).val(sub_total.toFixed(2));
                                                                                                    $("#dummy_reference").val(jobref);
                                                                                                    $.ajax
                                                                                                            ({
                                                                                                                type: "POST",
                                                                                                                url: "admin/get_child.php",
                                                                                                                data: "id=" + str + "&guest_qty=" + quantity + "&guest_price=" + price,
                                                                                                                success: function(option)
                                                                                                                {

                                                                                                                }
                                                                                                            });
                                                                                                }




                                                                                                function add_cart(str, prd)
                                                                                                {
                                                                                                    var quantity = document.getElementById('quantity_' + str).value;
                                                                                                    var total_cart_val = document.getElementById('dummy5').value;
                                                                                                    var sub_total_val = document.getElementById('sub_total_txt_id_' + str).value;
                                                                                                    var total_order_val = document.getElementById('total_order_val').value;
                                                                                                    var count_pro = document.getElementById('count_pro').value;
                                                                                                    var test = document.getElementById('dummy1').value;
                                                                                                    var jass = document.getElementById('dummy6').value;
                                                                                                    var jobref = document.getElementById('jobref').value;
                                                                                                    var user_log = document.getElementById('user_session').value;
                                                                                                    var session_cart = document.getElementById('total_cart_val').value;
                                                                                                    var session_order = document.getElementById('total_order_val').value;

                                                                                                    var total = (Number(total_cart_val));
                                                                                                    var dummy_tot = document.getElementById('dummy7').value;
                                                                                                    var dummy_id = document.getElementById('dummy1').value;
                                                                                                    var dummy_id1 = document.getElementById('dummy2').value;
                                                                                                    var dummy8 = document.getElementById('dummy8').value;
                                                                                                    var total_order = (Number(dummy_tot));

                                                                                            //alert(dummy8);

                                                                                                    $(".dummy2").val(dummy_id1 + ',' + dummy_id);

                                                                                                    String.prototype.containsWord = function(word) {

                                                                                                        var regex = new RegExp('\\b' + word + '\\b');

                                                                                                        return regex.test(this);

                                                                                                    };

                                                                                            //var myString = 'This is some random string.';

                                                                                                    var check_in = dummy_id1.containsWord(test);

                                                                                            //if(user_log != ''){

                                                                                                    if (check_in == false) {

                                                                                                        $(".total_cart").html(total);
                                                                                                        $(".total_cart_txt").val(total);
                                                                                                        $(".total_order").html(total_order.toFixed(2));
                                                                                                        $(".total_order_txt").val(total_order);
                                                                                                        $(".dummy8").val(dummy_tot);

                                                                                                    } else {
                                                                                                        return false;
                                                                                                    }

                                                                                                    $.ajax
                                                                                                            ({
                                                                                                                type: "POST",
                                                                                                                url: "admin/get_child.php",
                                                                                                                data: "session_cart=" + total + "&session_order=" + total_order,
                                                                                                                success: function(option)
                                                                                                                {

                                                                                                                }
                                                                                                            });

                                                                                                }

                                                                                                function chk_login()
                                                                                                {
                                                                                                    var user_log = document.getElementById('user_session').value;
                                                                                                    if (user_log == '') {
                                                                                                        alert("You must login in order to Checkout.");
                                                                                                        return false;
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        return true;
                                                                                                    }

                                                                                                }

                                                                                                function clear_cach_index()
                                                                                                {
                                                                                                    $("#email_id").val('');
                                                                                                    $("#password").val('');
                                                                                                }

                                                                                                function search_test()
                                                                                                {
                                                                                                    var search_prod = document.getElementById("search_val").value;
                                                                                                    window.location = "index.php?search=" + search_prod;

                                                                                                }

                                                                                            </script>
<script type="text/javascript">
    $(function() {
        $("#jobref").keyup(function()
        {
            var searchid = $(this).val();
            var user_id = document.getElementById("user_session").value;
            var comp_id = document.getElementById("user_session_comp").value;
            var dataString = 'search=' + searchid + '&user_id=' + user_id + '&comp_id=' + comp_id;
            if (searchid != '')
            {
                $.ajax({
                    type: "POST",
                    url: "auto_reference.php",
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
            }
            return false;
        });

        jQuery("#result").live("click", function(e) {
            var $clicked = $(e.target);
            var $name = $clicked.find('.name').html();
            var decoded = $("<div/>").html($name).text();
            $('#searchid').val(decoded);
        });
        jQuery(document).live("click", function(e) {
            var $clicked = $(e.target);
            if (!$clicked.hasClass("search")) {
                jQuery("#result").fadeOut();
            }
        });
        $('#searchid').click(function() {
            jQuery("#result").fadeIn();
        });
    });
</script>
<script>
    function get_reference(auto_ref)
    {
        //alert(auto_ref);
        $("#jobref").val(auto_ref);
        $("#result_ref").hide();
    }

    function add_favorites(PROD_ID, USR_ID)
    {
        if (USR_ID != '') {       
            $("#fav_id_"+PROD_ID).html('<img src="images/loading_fav.gif" height="18px" width="18px" />');
            $.ajax
                    ({
                        type: "POST",
                        url: "favorites.php",
                        data: "fav_prod_id=" + PROD_ID + "&fav_usr_id=" + USR_ID,                        
                        success: function(option)
                        {
                            var pulse_class = (option == 'fav.png') ? 'pulse' : 'pulse_1';
                            $("#fav_id_"+PROD_ID).html('');
                            $("#fav_id_"+PROD_ID).html('<img src="images/'+option+'" border="0px" style="cursor: pointer;" class="'+pulse_class+'" onclick="return add_favorites('+PROD_ID+', '+USR_ID+');" />');                                                  
                        }
                    });
        } else {
            alert('You must login to make as favorites.');
        }
    }
    
    function view_favorites(USR_ID)
    {
        if(USR_ID != ''){
            window.location = "cus_favorites.php";
        }else{
            alert('You must login to view the favorites.');
        }
    }
    
    function help_box_logged()
    {
        alert('Logged Help Box');
    }
    
    function help_box()
    {
        alert('Help Box');
    }
</script>
                                                                                            <input class="addstroeproductActionLink"  value="Checkout" style="cursor: pointer;float:right;font-size:12px; padding:1.5px; width: 100px;margin-top:11px;margin-bottom:20px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="submit"  /> 
                                                                                            <!--</form> -->
                                                                                            <div style="clear:both;"></div>

                                                                                        </div>

                                                                                        <div class="clear"></div>
                                                                                    </div>
                                                                                    <div class="clear"></div>

                                                                                    <div class="footerSRwapper" style="margin:auto;height:61px;">
                                                                                        <div id="body_footer-inner" class="body_wrapper-inner">
                                                                                            <ul class="navigation footer">
                                                                                                <li><a href="#"><span>About SohoRepro</span></a></li>
                                                                                                <li><a href="#"><span>FAQs</span></a></li>
                                                                                                <li><a href="#"><span>Privacy Policy</span></a></li>
                                                                                                <li><a href="#"><span>Security</span></a></li>
                                                                                                <li><a href="#"><span>Terms of Use</span></a></li>
                                                                                                <li><a href="#"><span>Contact</span></a></li>
                                                                                                <div class="clear"></div>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div class="clear"></div>


                                                                        </div>
                                                                    </div>

                                                                    <div id="dynamicAppender" style="postion:absolute;top:-5000px"></div>






                                                                    <div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all ui-helper-hidden-accessible"></div><ul style="z-index: 4; top: 0px; left: 0px; display: none;" aria-activedescendant="ui-active-menuitem" role="listbox" class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all"></ul></body>
                                                                <!-- Mirrored from buckart.com/srsite/SoHoRepro-WebsitePages/store/store.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 21 Sep 2013 08:45:26 GMT -->
                                                                </html>