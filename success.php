<?php
include './admin/config.php';
include './admin/db_connection.php';
include './admin/include/class.phpmailer.php';

if(isset($_REQUEST['login_submit']))
{ 
    unset($_SESSION['sohorepro_userid']);
    unset($_SESSION['sohorepro_companyid']);
    unset($_SESSION['sohorepro_username']); 
    $emailid= mysql_real_escape_string($_POST['email_id']);
    $pass= mysql_real_escape_string($_POST['password']);
    $rememberme= mysql_real_escape_string($_POST['rememberme']);

    $user_login = UserLogin($emailid,$pass); 
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
   
    if((count($user_login) > 0)){       
        $_SESSION['sohorepro_userid']      =$user_login[0]['cus_id'];
        $_SESSION['sohorepro_companyid']   =$user_login[0]['cus_compname'];
        $_SESSION['sohorepro_username']    =$user_login[0]['cus_contact_name'];
        header("Location:index.php"); 
    }  else {
        header("Location:index.php?err=incorrect"); 
    } 
}


if(isset($_REQUEST['forgot_submit']))
{ 
 //print_r($_REQUEST);
 $emailid= mysql_real_escape_string($_POST['email_id']);
 
 $check_user_count = mysql_query("select * from sohorepro_customers where cus_email='".$emailid."' ");

 if(mysql_num_rows($check_user_count)>0)
 { 
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
 $message .= '<td width="140" align="left" valign="top"><img src="'.$base_url.'/store_files/soho_logo.jpg" width="126" height="115" alt=""/></td>';
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
 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;'>Dear ".ucfirst($check_fth_user['cus_fname']." ".$check_fth_user['cus_lname']).",</td>
 </tr>";
 $message .="<tr>
 <td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'> Please note down the login details for your account. <span style='color:#0b7abf; text-decoration:underline;'></span></td>
 </tr>";
 
 $message .="<tr>
 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#5f5f5f; font-weight:bold; padding-top:20px;'>Email id : ".($check_fth_user['cus_email'])."</td>
 </tr>";
 
 $message .="<tr>
 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#5f5f5f; font-weight:bold; padding-top:20px; padding-bottom:10px;'>Password : ".$check_fth_user['cus_pass']."</td>
 </tr>";
 
 $message .="<tr>
 <td height='30' align='left' valign='middle' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'><a href='".$base_url ."/index.php' style='color:#0b7abf; text-decoration:underline;' target='_blank'>Click here </a>to login into our SohoRepro System.</td>
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
$mail->SetFrom('no-reply@sohorepro.com', "SohoRepro");
$mail->AddAddress($to, $to);
$mail->Subject = 'SohoRepro - Login credentials';
$mail->IsHTML(true);
$mail->Body = $message;
$forgot_result = $mail->Send(); 
 
 
 if($forgot_result){
 header("Location:success.php?for_succ=1"); 
 } 
}  else {
header("Location:success.php?for_err=1");
exit;   
}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <!-- Mirrored from buckart.com/srsite/SoHoRepro-WebsitePages/store/store.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 21 Sep 2013 08:44:50 GMT -->
    <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
    <head>
                <script>             
                    function show_forgot(str)
                    {
                    if(str==0)
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
        </script>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
            <title> SohoRepro </title>

            <!-- base href="http://soho.thinkdesign.com/" -->

            <link rel="stylesheet" href="store_files/style.css" type="text/css" media="screen"> 
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



                                                        <script type="text/javascript" src="store_files/scripts.js"></script>


                                                        <link rel="shortcut icon" href="http://soho.thinkdesign.com/favicon.ico" type="image/x-icon">
                                                            <link rel="stylesheet" type="text/css" href="store_files/style_layout.css">
                                                              </head>
                                                                <body>
                                                                    <div id="body_container">
                                                                        <div id="body_content" class="body_wrapper">
                                                                            <div id="body_content-inner" class="body_wrapper-inner">

                                                                                <?php include "includes/header_sidebar.php"; ?>

                                                                                <div id="content_output">

                                                                                    <?php include "includes/top_nav.php"; ?>

                                                                                    <div id="content_output-data" style="margin-bottom:20px;">


                                                                                        <?php if (isset($_GET['new_company']) == 'succ') { ?>
                                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">New User Added Successfully</div>
                                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Pending Approval From Administrator</div>
                                                                                            <script>setTimeout("location.href=\'new_account_add.php\'", 1000);</script> 
                                                                                        <?php } ?>
                                                                                        <?php
                                                                                        if($_GET['for_succ'] == '1'){
                                                                                        ?>
                                                                                        <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Password sent successfully.</div> 
                                                                                        <?php 
                                                                                        }
                                                                                        if($_GET['for_err'] == '1'){
                                                                                        ?>
                                                                                        <div style="color:#F00; text-align:center; padding-bottom:10px;">Email ID does not exist.</div>
                                                                                        <?php
                                                                                        } 
                                                                                        ?>
                                                                                            <div style="float: left;margin-left: 30px;margin-top: 50px;height: 428px;">
                                                                                                <h2 style="color: #009D59;">Thank you for providing your information. We will contact you soon.</h2>
                                                                                            </div>
                                                                                            

                                                                                        
                                                                                        <!--<div class="bkgd-stripes-orange">&nbsp;</div>-->

                                                                                        <!--<div style="margin-bottom:0;" class="bkgd-stripes-orange">&nbsp;</div>-->
                                                                                        <div style="clear:both;"></div>


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

                                                                    <div id="dynamicAppender" style="postion:absolute;top:-5000px"></div>






                                                                    <div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all ui-helper-hidden-accessible"></div><ul style="z-index: 4; top: 0px; left: 0px; display: none;" aria-activedescendant="ui-active-menuitem" role="listbox" class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all"></ul></body>
                                                                <!-- Mirrored from buckart.com/srsite/SoHoRepro-WebsitePages/store/store.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 21 Sep 2013 08:45:26 GMT -->
                                                                </html>

