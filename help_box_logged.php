<?php
include './admin/config.php';
include './admin/db_connection.php';
$_SESSION['job'] = $_REQUEST['jobref'];
$_SESSION['qty'] = $_REQUEST['quantity'];
$comp_id = $_SESSION['sohorepro_companyid'];
$user_id = $_SESSION['sohorepro_userid'];

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

    

//    echo '<pre>';

//    print_r($user_login);

//    echo '</pre>';

//    exit;

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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
 <!-- Mirrored from buckart.com/srsite/SoHoRepro-WebsitePages/store/store.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 21 Sep 2013 08:44:50 GMT -->
 <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
 <head>
 <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
 <title>SohoRepro Help Box</title>

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
 <script type="text/javascript" src="store_files/scripts.js"></script>
 <script src="store_files/jquery.min.js"></script>
 <style type="text/css">
.btn_shopping{background:url(images/button.jpg) no-repeat right; width:154px; height:28px; float: right; font-family:Arial; font-size:11px; font-weight:bold; color:#ffffff; border:0px; cursor:pointer; text-transform:uppercase;}
.product_table{font-family:Arial; font-size:13px; line-height:20px; color:#59432d; border:1px solid #ffc68f; border-right:0px;}
.product_table td{ padding:5PX;}
.product_table .h1{ color:#fff; font-size:14px; text-transform:uppercase;}
.product_table input[type="text"]{ width:20px; height:20px; line-height:20px; padding:0px 5px; border:1px solid #999999; color:#59432d;}
.product_table .brdr_1{ border-top:1px solid #fff; border-right:1px solid #ffc68f;}
.product_table .brdr_2{ border-right:1px solid #ffc68f;}
.product_table .brdr_3{ border-top:1px solid #ffc68f; border-right:1px solid #ffc68f;}
.product_table input[type="button"]{ background:url(images/remove_btn1.png) no-repeat center; width:72px; height:23px; border:0px; 
font-size:0px; cursor:pointer; line-height:16px;}
.first{font-family:Arial; font-size:14px; line-height:26px; color:#0b0b0b;}
.first .brdr_4{ padding-right:20px;}
.product_table .pad_none{ padding:2px !important;}
.product_table .pad_none td{ padding:3px 5px !important;}
.last_btn{width:250px; border-right:1px solid #ffc68f;}
.last_btn input[type="button"]{ background:url(images/placeholder.png) no-repeat; width:123px; height:28px; border:0px; color:#ffffff; font-size:11px;}
.clearart{font-family:Arial; font-size:11px; font-weight:bold; color:#ffffff; border:0px; cursor:pointer; text-transform:uppercase;}
.first .grand_total{ padding-left:20px !important;}
.increse_act{width: 12px;float: right;}
.increse_act img{width: 12px;float: left;}
.address{cursor:pointer;}
.str{font-weight: bold;}
#errmsg
{
color: red;
}
</style>

 <link rel="shortcut icon" href="http://soho.thinkdesign.com/favicon.ico" type="image/x-icon">
 <link rel="stylesheet" type="text/css" href="store_files/style_layout.css">
 <!--[if IE 7]>
 <link rel="stylesheet" type="text/css" href="css/ie_7_hacks.css" />
 <![endif]-->
 <script type="text/javascript" charset="utf-8">

 </script>
 </head>
 <body>
     <div id="loading" style="display: none;position: fixed;top: 35%;left: 48%;padding: 5px;z-index: 10;">
         <img src="admin/images/login_loader.gif" border="0" />
    </div>
     
 <div id="body_container">
 <div id="body_content" class="body_wrapper">
 <div id="body_content-inner" class="body_wrapper-inner">

<?php include "includes/header_sidebar.php"; ?>
 
 <div id="content_output">

<?php include "includes/top_nav.php"; ?>
 
 <div id="content_output-data" style="margin-bottom:20px;">
<!--- TABLE START -->
<div id="cart_tabl">
    <?php
    if ($result == "success") {
        ?>
        <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Shipping Address Deleted Successfully</div>
        <script>setTimeout("location.href=\'addressbook.php\'", 1000);</script>
        <?php
    } elseif ($result == "failure") {
        ?>
        <div style="color:#F00; text-align:center; padding-bottom:10px;">Shipping Address Not Deleted</div>
        <script>setTimeout("location.href=\'addressbook.php\'", 1000);</script>       
        <?php
    }
    ?> 
        
        <div style="float: left;width: 100%;">
            <div style="color: #ff7e00 !important;margin-bottom: 20px;"><h2 style="color: #ff7e00 !important;">Ask Your Question</h2></div>
            <div style="color: #007F2A !important;margin-bottom: 20px;display: none;" id="feed_succ">Successfully submitted your question.</div>
            
            <?php
            if ($_GET['success'] == "1") {
            ?>
            <div style="color: #007F2A !important;margin-bottom: 20px;" id="feed_succ">Successfully submitted your question.</div>
            <?php
            }
            ?>
            
            <input type="hidden" name="succ_id" id="succ_id" value="<?php echo $_GET['success']; ?>" />
            
            <span id="errmsg"></span>
<!--            <form method="post" action="" name="feedback_form" id="feedback_form">-->
                <input type="hidden" name="comp_id" id="comp_id" value="<?php echo $comp_id; ?>" /> 
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
            <table width="740">
                <tr>
                    <td valign="top"><span style="font-weight: bold;">Ask Your Question</span><span style="color: red;">*</span></td>
                    <td>
                        <textarea name="feedback" id="feedback" style="height: 150px;width: 500px;"></textarea>
                    </td>
                </tr>
                <tr style="padding: 10px;">
                    <td><input type="hidden" name="feedback_id" value="1" /></td>
                    <td>
                        <input type="submit" class="btn_shopping" onclick="return submit_feedback();" style="margin-top: 20px;float: left !important;" value="Submit" />
                    </td>
                </tr>
            </table>
<!--            </form>-->
        </div>

</div>


     
     
     
<!-----TABLE END--->     
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

function submit_feedback()
{
 var feedback_input = document.getElementById('feedback').value;
 var comp_id        = document.getElementById('comp_id').value;
 var user_id        = document.getElementById('user_id').value;
 var succ_id            = document.getElementById('succ_id').value;
 
 if(feedback_input == '')
     {
        document.getElementById('feedback').focus();
        $("#errmsg").html("Please enter you question.").show();
        return false;
     }
     if (feedback_input != '')
    {
        $.ajax
                ({
                    type: "POST",
                    url: "get_recipients.php",
                    data: "recipients=feedback_1&feedback_input_logged="+encodeURIComponent(feedback_input)+"&comp_id_logged="+comp_id+"&user_id_logged="+user_id,
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {  
                        if(succ_id != '1'){
                        $("#feed_succ").slideDown();   
                        }
                        setTimeout("location.href=\'help_box_logged.php?success=1\'", 1000);
                    }
                });
    }
 
}
function loadStart() {
$('#loading').show();
}

function loadStop() {
$('#loading').hide();
}
</script>