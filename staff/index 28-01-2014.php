<?php
include './admin/config.php';
include './admin/db_connection.php';

$Super = getSuperCategory();

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
 
 
 $to = $check_fth_user['cus_email'];
 $subject = 'SohoRepro - Login credentials';
 $headers = 'From: "SohoRepro" <no-reply@sohorepro.com>' . "\r\n";
 // Always set content-type when sending HTML email
 $headers = "MIME-Version: 1.0" . "\r\n";
 $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
 
 mail($to, $subject, $message, $headers);
 
 header("Location:index.php");
 exit;
 }
 else
 {
 header("Location:index.php?err");
 exit;
 }
}




if(isset($_REQUEST['login_submit']))
{ 
 //print_r($_REQUEST);
 //exit;
 $emailid= mysql_real_escape_string($_POST['email_id']);
 $pass= mysql_real_escape_string($_POST['password']);
 $rememberme= mysql_real_escape_string($_POST['rememberme']);
 
 $check_user_count = mysql_query("select * from sohorepro_customers where cus_email='".$emailid."' ");

 if(mysql_num_rows($check_user_count)>0)
 {
 $check_fth_user = mysql_fetch_array($check_user_count);
 $_SESSION['sohorepro_userid']      =$check_fth_user['cus_id'];
 $_SESSION['sohorepro_companyid']   =$check_fth_user['cus_compname'];
 $_SESSION['sohorepro_username']    =$check_fth_user['cus_contact_name'];
 
 if(isset($_REQUEST['rememberme']) && $rememberme!='')
 {
 setcookie("ck_sohorepro_userid", $check_fth_user['cus_id']);
 setcookie("ck_sohorepro_email", $emailid);
 setcookie("ck_sohorepro_pass", $pass);
 }
 else
 {
 $expire_ck= time()-3600;
 setcookie("ck_sohorepro_userid", "", $expire_ck);
 setcookie("ck_sohorepro_email", "", $expire_ck);
 setcookie("ck_sohorepro_pass", "", $expire_ck);
 }
 
 header("Location:index.php");
 exit;
 }
 else
 {
 header("Location:index.php?err");
 exit;
 }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
 <!-- Mirrored from buckart.com/srsite/SoHoRepro-WebsitePages/store/store.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 21 Sep 2013 08:44:50 GMT -->
 <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
 <head>
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
 <script src="store_files/jquery.min.js"></script>
 <script>
 $(document).ready(function(){
 $(".super_cat").click(function(){
 $(this).next(".sub_cat").toggle(); 
 });
 }); 
 
 </script>

 <link rel="shortcut icon" href="http://soho.thinkdesign.com/favicon.ico" type="image/x-icon">
 <link rel="stylesheet" type="text/css" href="store_files/style_layout.css">
 <!--[if IE 7]>
 <link rel="stylesheet" type="text/css" href="css/ie_7_hacks.css" />
 <![endif]-->
 <script type="text/javascript" charset="utf-8">

 </script>
 

<!-- Validation script starts here -->

<style type="text/css">
 label.error{
 color: red !important;
 
 }
 
 input.error,select.error{
 border: 1px solid red !important;
 }
 span:hover {font-size: 16px; cursor: pointer;}
 .fixed_1{border-style:solid;border-width:0px; position: fixed; width: 750px; top: 0; z-index: 1; background: #fff;}
 #to_tal{ display:block !important;}
</style>
<script src="js/jquery.js" type="text/javascript" ></script>
<script src="js/jquery.validate.js" type="text/javascript" ></script>
<script src="js/jquery.maskedinput.js" type="text/javascript" ></script>

<!--scroll set to top--->
<script type="text/javascript"> 
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
</script>
<script type="text/javascript">

 $(document).ready(function() { 
 

 
 var validation_obj = {
 rules: {email_id:{
 
 required:true,
 email:true
 } },
 messages: {
 email_id: {
 required: '',
 email:true
 },
 password : {
 required: ''
 
 }
 
 }
 };
 
 
 $("#login_form").validate(validation_obj);
 
 
 
 var validation_reg = {
 rules: {reg_email_id:{
 
 required:true,
 email:true
 },
 reg_password:{
 
 required:true,
 rangelength: [6, 8]
 } },
 messages: {
 reg_name : {
 required: ''
 
 },
 reg_email_id: {
 required: '',
 email:true
 },
 reg_password : {
 required: ''
 
 },
 reg_cpassword : {
 required: ''
 
 }
 
 }
 };
 
 
 $("#reg_form").validate(validation_reg);
 
 
 var validation_forgot = {
 rules: {email_id:{
 
 required:true,
 email:true
 } },
 messages: {
 email_id: {
 required: '',
 email:true
 }
 
 }
 };
 
 
 $("#forgot_form").validate(validation_forgot);
 
 
 
 });
 
 
 function show_reg(str)
 {
 if(str==0)
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
 
 
 function change_txt(tid,val)
 {
 var txt_val=$(tid).val();
 //alert(txt_val);
 if(txt_val==val)
 {
 $(tid).val('');
 }
 }
 
 function change_dtxt(tid,val)
 {
 var txt_val=$(tid).val();
 //alert(txt_val);
 
 if(txt_val=='')
 {
 $(tid).val('');
 }
 }
 
</script>
<!-- Validation script ends here --> 

 
 </head>
 <body>
     <input type="hidden" name="user_session" id="user_session" value="<?php echo $_SESSION['sohorepro_userid']; ?>" />
 <div id="body_container">
 <div id="body_content" class="body_wrapper">
 <div id="body_content-inner" class="body_wrapper-inner">

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
} 
else{
    $order_id = '101';
}

if ($_REQUEST['order_val'] == '1') {
    for($j= 0; $j < count($_REQUEST['product_id']); $j++){
       if ($_REQUEST['quantity'][$j] != '') {
           $place_order = '1';
       }
    }
    if($place_order == '1'){
    $job_ref = $_REQUEST['jobref'];
    $sql = "INSERT INTO sohorepro_order_master SET order_number = '".$order_id."', order_id     = '" . $job_ref . "', customer_company = '".$_SESSION['sohorepro_companyid']."', customer_name = '".$_SESSION['sohorepro_userid']."', created_date = now()";
    mysql_query($sql);
    }
    $order_id_pro = mysql_insert_id();
    if($order_id_pro != ''){
    for ($i = 0; $i < count($_REQUEST['product_id']); $i++) {
        if ($_REQUEST['quantity'][$i] != '') {

           $query = "INSERT INTO sohorepro_product_master SET product_id     = '" . $_REQUEST['product_id'][$i] . "', product_price = '" . $_REQUEST['price'][$i] . "', product_quantity = '" . $_REQUEST['quantity'][$i] . "', product_name = '".$_REQUEST['product_name'][$i]."', order_id = '" .$order_id_pro. "'";
           mysql_query($query);
           
        }
    }
    $result = "success";
    }  else {
    $result = "failure";   
    }
}
    

$special_pricelist=get_special_price($_SESSION['sohorepro_companyid']);

//print_r($special_pricelist);
$sprice_product=array();
$sprice_dprice=array();
foreach($special_pricelist as $newprice)
{
    $sprice_product[]=$newprice['sp_product_id'];
    $sprice_dprice[$newprice['sp_product_id']]=$newprice['sp_special_price'];
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
?> 

 <form id="supplystoreform" name="supplystoreform" action="shoppingcart.php" method="post" onsubmit="return validate()">
 <input type="hidden" name="order_val" value="1" id="order_val" /> 
 <div id="supply_hdr">
     <div>
 <h2 class="headline-interior orange">SUPPLY STORE </h2>
 <div class="bkgd-stripes-orange">&nbsp;</div>
 </div>
     <div>
 <div style="float:right;margin-top:-63px;">
 <span style="font-size:22px; font-weight:bold;">Job Reference<span style="color:red; margin-top: -5px;font-size: 16px;font-weight: bold;">*</span> :</span> 
 <input aria-haspopup="true" aria-autocomplete="list" role="textbox" autocomplete="off" onkeypress="return chk_login_();" class="ui-autocomplete-input dec" style="padding:3px;" name="jobref" id="jobref" type="text" value="<?php echo $_SESSION['job']; ?>" />
 </div> 
        
         <div style="text-align: right;color:#5C5C5C;font-size:18px;font-weight:bold;">Total Items in Cart : <span style="text-align: right;color:#5C5C5C;font-size:18px;font-weight:bold;" class="total_cart"><?php if($_GET['cart'] !=''){ echo $_GET['cart'];}else{ ?>0<?php } ?></span><input type="hidden" class="total_cart_txt" id="total_cart_val" value="<?php echo $_GET['cart']; ?>"/></div>
 <div class="inPageCartBlock" style="color:#5C5C5C;font-weight:bold;font-size:18px;padding-right:0px;">

     Current Order Total : $<span id="" class="total_order" style="font-size: 18px;font-weight:bold;"><?php if($_GET['sub'] !=''){ echo $_GET['sub'];}else{ ?>0.00<?php } ?></span><input type="hidden" class="total_order_txt" id="total_order_val" value="<?php echo $_GET['sub']; ?>"/>
     
 </div>
          </div>
 </div>

 <?php
 foreach($Super as $super){ 
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
<input class="set_val" id="set_val" type="hidden" value="0" />
<input class="dummy" id="dummy" type="hidden" value="" />
<input class="dummy2" id="dummy2" type="hidden" value="0" />
<input class="dummy5" id="dummy5" type="hidden" value="<?php echo $_GET['cart']; ?>" />   
<input class="dummy6" id="dummy6" type="hidden" value="0" />   
<input class="dummy7" id="dummy7" type="hidden" value="<?php echo $_GET['sub']; ?>" />   
<input class="dummy8" id="dummy8" type="hidden" value="0" />   
 <?php
 foreach ($SubCategory as $Subc) {
 $su_id = $Subc['id'];
 $ProductsUser = getProductsU($c_id,$s_id, $su_id);
 ?>    
 <li>
 <h3><div style="width:25px;margin-left:65px; float:left;"><img src="store_files/r2.png"></div><div><h3 style="border:none;padding-top:0px;padding-bottom:0px;width:100%;text-align:left;text-transform: uppercase"><?php echo $Subc['category_name']; ?></h3></div><div class="oline"></div>
 <!--<div class="eachlistTotal" sectotal="" style="float: right; margin-top: -12px;"></div>-->
 </h3>
 <div style="display: none;" class="acc-section">
 
 <?php if(count($ProductsUser)>0) { ?>  
 <div class="acc-content">  
 <table> 
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
 foreach ($ProductsUser as $Product) {      
 $price_product=in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']] : $Product['price']; 
 $rowColor = ($i % 2 != 0) ? '#fcd9a9' : '#f9f2de';
 $rowColor1 = ($i % 2 != 0) ? '#fde8cb' : '#fbf7eb';
 ?>

 <tr style="background-color: #F9F2DE;">        
<td bgcolor="<?php echo $rowColor; ?>" style="width:50px"><div id="j"></div></td>
<td bgcolor="<?php echo $rowColor; ?>" style="text-align: left;" width="300" height="25"><span><?php echo $Product['product_name']; ?></span></td>
<td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 35px"><?php echo $price_product; ?><input type="hidden" id="product_id_<?php echo $Product['id']; ?>" name="price[]" value="<?php echo $price_product; ?>" /></td>
<td bgcolor="<?php echo $rowColor; ?>"><input class="proquan" onchange="return myFunction('<?php echo $Product['id']; ?>');" onkeyup="return quantity_val('<?php echo $Product['id']; ?>');" price="<?php echo $price_product; ?>" productid="<?php echo $Product['sku_id']; ?>" name="quantity[]" id="quantity_<?php echo $Product['id']; ?>" style="text-align: right;padding:1px;width:64px;border:1px solid #CCC;" type="text"></td>
<td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 10px"><div class="sub_total_<?php echo $Product['id']; ?>">0.00</div><input class="sub_total_txt_<?php echo $Product['id']; ?>" id="sub_total_txt_id_<?php echo $Product['id']; ?>" type="hidden" value="" /><input class="dummy1" id="dummy1" type="hidden" value="" /></td>
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
    <div style="font-size:12px;text-align: right; font-weight: bold;width:566px; float: left;">&nbsp;</div> 
    <div id="s_total1" style="font-size:13px;text-align: left;width: 66px;font-weight: bold;float:left;">&nbsp;</div>
    <div class="btn_addcart"><img src="images/add_cart_bg.png" onclick="return add_cart('<?php echo $Product['id']; ?>','<?php echo $prd_id; ?>');" class="click_<?php echo $Product['id']; ?>" id="click_<?php echo $Product['id']; ?>" style="cursor: pointer;" /><img class="click_i_<?php echo $Product['id']; ?>" src="images/add_to_cart.png" style="display: none;"/></div>
</div> 
     
 </div>
 <?php } ?>     
     
 </div>
 </li>
 <?php } ?>
     
     
     
     
     <li>
      <?php $super_subcatProductsUser = getsuper_subcatProducts($c_id,$s_id);
        foreach ($super_subcatProductsUser as $get_id){
                 $id_array[] = $get_id['id'] ;
        }
        $sub_price_id = sizeof($id_array);
        if(count($super_subcatProductsUser)>0) { 
        ?>

        <table width="100%"> 
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
        $price_product=in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']] : $Product['price'];    
        
        ?>
            
        <tr style="background-color: #F9F2DE;">        
        <td bgcolor="<?php echo $rowColor; ?>" style="width:50px"><div id="j"></div></td>
        <td bgcolor="<?php echo $rowColor; ?>" style="text-align: left;" width="300" height="25"><span><?php echo $Product['product_name']; ?></span></td>
        <td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 35px"><?php echo $price_product; ?><input type="hidden" id="product_id_<?php echo $Product['id']; ?>" name="price[]" value="<?php echo $price_product; ?>" /></td>
        <td bgcolor="<?php echo $rowColor; ?>"><input class="proquan"  onchange="return myFunction('<?php echo $Product['id']; ?>');" onkeyup="return quantity_val('<?php echo $Product['id']; ?>','<?php echo $sub_price_id; ?>');" price="<?php echo $price_product; ?>" productid="<?php echo $Product['sku_id']; ?>" name="quantity[]" id="quantity_<?php echo $Product['id']; ?>"  style="text-align: right;padding:1px;width:64px;border:1px solid #CCC;" type="text"></td>
        <td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 10px"><div class="sub_total_<?php echo $Product['id']; ?>">0.00</div><input class="sub_total_txt_<?php echo $Product['id']; ?>" id="sub_total_txt_id_<?php echo $Product['id']; ?>" type="hidden" value="" /><input class="dummy" id="dummy" type="hidden" value="" /><input class="dummy1" id="dummy1" type="hidden" value="" /></td>
        <td bgcolor="<?php echo $rowColor; ?>" style="width:50px"></td>
        
        <input type="hidden" id="product_id" name="product_id[]" value="<?php echo $Product['id']; ?>" />
        <input type="hidden" id="product_name" name="product_name[]" value="<?php echo mysql_escape_string(htmlentities(stripcslashes($Product['product_name']))); ?>" />
        <input type="hidden" id="super_category_id" name="super_category_id[]" value="<?php echo $c_id; ?>" />
        <input type="hidden" id="category_id" name="category_id[]" value="<?php echo $s_id; ?>" />
        <input type="hidden" id="sub_category_id" name="sub_category_id[]" value="<?php echo $su_id; ?>" /> 

        </tr>
        <?php
        $i++;
        $product_id_array[] = $Product['id'] ;
        }
        $prd_id =  implode(",",$product_id_array);
        
        ?>
            <input type="hidden" name="count_pro" id="count_pro" value="<?php echo $count; ?>" />
        </tbody></table>
            
         
         <div id="to_tal" style="border-top:1px solid #FF7E00;background-color: #F9F2DE; display:block !important;">
         <div class="sectionTotal" style="float:right;height:25px;margin-bottom:6px;border-bottom:1px solid #F9E7B2;background-color: #F9F2DE;width:98.6%; padding-right: 0px;">
             <div style="font-size:12px;text-align: right; font-weight: bold;width:566px; float: left;">&nbsp;</div>
             <div id="s_total1" class="sub_id_1_<?php echo $Product['id']; ?>" style="font-size:13px;text-align: left;width: 66px;font-weight: bold;float:left;">&nbsp;<input type="hidden" id="sub_id_txt_<?php echo $Product['id']; ?>" value="" /></div>
             <div class="btn_addcart"><img src="images/add_cart_bg.png" onclick="return add_cart('<?php echo $Product['id']; ?>','<?php echo $prd_id; ?>');" class="click_<?php echo $Product['id']; ?>" id="click_<?php echo $Product['id']; ?>" style="cursor: pointer;" /><img class="click_i_<?php echo $Product['id']; ?>" src="images/add_to_cart.png" style="display: none;"/></div>
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
         
 <?php $superProductsUser = getsuperProducts($c_id);
 
 if(count($superProductsUser)>0) {
  
     
 ?>
 
 <table width="100%"> 
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
 $price_product=in_array($Product['id'],$sprice_product) ? $sprice_dprice[$Product['id']] : $Product['price'];
 ?> 
 <tr style="background-color: #F9F2DE;">        
<td bgcolor="<?php echo $rowColor; ?>" style="width:50px"><div id="j"></div></td>
<td bgcolor="<?php echo $rowColor; ?>" style="text-align: left;" width="300" height="25"><span><?php echo $Product['product_name']; ?></span></td>
<td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 35px"><?php echo $price_product; ?><input type="hidden" id="product_id_<?php echo $Product['id']; ?>" name="price[]" value="<?php echo $price_product; ?>" /></td>
<td bgcolor="<?php echo $rowColor; ?>"><input class="proquan" onchange="return myFunction('<?php echo $Product['id']; ?>');" onkeyup="return quantity_val('<?php echo $Product['id']; ?>');" price="<?php echo $price_product; ?>" productid="<?php echo $Product['sku_id']; ?>" name="quantity[]" id="quantity_<?php echo $Product['id']; ?>" style="text-align: right;padding:1px;width:64px;border:1px solid #CCC;" type="text"></td>
<td bgcolor="<?php echo $rowColor1; ?>" style="text-align:right;padding-right: 10px"><div class="sub_total_<?php echo $Product['id']; ?>">0.00</div><input class="sub_total_txt_<?php echo $Product['id']; ?>" id="sub_total_txt_id_<?php echo $Product['id']; ?>" type="hidden" value="" /><input class="dummy" id="dummy" type="hidden" value="" /><input class="dummy1" id="dummy1" type="hidden" value="" /></td>
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
        <div style="font-size:12px;text-align: right; font-weight: bold;width:566px; float: left;">&nbsp;</div> <div id="s_total1" style="font-size:13px;text-align: left;width: 66px;font-weight: bold;float:left;">&nbsp;</div><div class="btn_addcart"><img src="images/add_cart_bg.png" onclick="return add_cart('<?php echo $Product['id']; ?>','<?php echo $prd_id; ?>');" class="click_<?php echo $Product['id']; ?>" id="click_<?php echo $Product['id']; ?>" style="cursor: pointer;" /><img class="click_i_<?php echo $Product['id']; ?>" src="images/add_to_cart.png" style="display: none;"/></div>
        </div>
        </div>      
 <?php } ?>        
         
     </li>    
     
     
     
 </ul>
 
 

 
 
 
 
 <?php } ?>
 </form>

 
 <!--<div class="bkgd-stripes-orange">&nbsp;</div>-->
 <div class="inPageCartBlock" style="color:#5C5C5C;font-weight:bold;font-size:18px;margin-top:10px;padding-right:0px;">

 Current Order Total : $<span id="" class="total_order" style="font-size: 18px;font-weight:bold;"><?php if($_GET['sub'] !=''){ echo $_GET['sub'];}else{ ?>0.00<?php } ?></span><input type="hidden" class="total_order_txt" id="total_order_val" value="<?php echo $_GET['sub']; ?>"/>
 
 </div>
 <!--<div style="margin-bottom:0;" class="bkgd-stripes-orange">&nbsp;</div>-->
 <div style="clear:both;"></div>
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
 });

 function validate()
 {
 if (document.getElementById('jobref').value == '')
 {
 alert("Please enter the job reference number");
 document.getElementById('jobref').focus;
 return false;
 } 
var user_log = $(".dummy5").val();
if(user_log == ''){
        alert("You must enter the quantity any one product.");
        return false;
    }
 return true;
 }

function set_val(str){
    //alert(str);
    $(".set_val").val(str);    

}

function myFunction(id)
{
//alert('1');
var total_cart_val  = document.getElementById('total_cart_val').value;
var quantity        = document.getElementById('quantity_'+id).value;
var cart_val        = document.getElementById('dummy5').value;
var jass            = document.getElementById('dummy7').value;
var total_order_val = document.getElementById('dummy').value;

var dummy7 = (Number(total_order_val) + Number(jass));
$(".dummy5").val(Number(cart_val)+Number(quantity));

$(".total_cart_val").val(cart_val); 
$(".dummy6").val(total_order_val); 
$(".dummy7").val(dummy7); 
}

function quantity_val(str,sub_id)
{  
          //return str;
          var quantity        = document.getElementById('quantity_'+str).value;
          var price           = document.getElementById('product_id_'+str).value;
          var user_log        = document.getElementById('user_session').value; 
          var jobref          = document.getElementById('jobref').value;
          var sub_total       = (quantity * price);
          if(user_log != '')
          {
          $(".sub_total_"+str).html(sub_total.toFixed(2)); 
          $(".sub_total_txt_"+str).val(sub_total.toFixed(2));  
          $(".dummy").val(sub_total.toFixed(2));
          $(".dummy1").val(str);
          $(".sub_id_"+sub_id).html(sub_total.toFixed(2)); 
          $(".sub_id_txt_"+sub_id).val(sub_total.toFixed(2)); 
          }
          else
            {
                alert("You must login in order to Checkout.");
//                alert('Please enter the Job Reference');
                document.getElementById('quantity_'+str).value = '';
//                document.getElementById('jobref').focus();
            }
    }




function add_cart(str,prd)
{
    var quantity        = document.getElementById('quantity_'+str).value;
    var total_cart_val  = document.getElementById('dummy5').value;
    var sub_total_val   = document.getElementById('sub_total_txt_id_'+str).value;
    var total_order_val = document.getElementById('total_order_val').value;
    var count_pro       = document.getElementById('count_pro').value;
    var test            = document.getElementById('dummy1').value;
    var jass            = document.getElementById('dummy6').value;
    var jobref          = document.getElementById('jobref').value;

var total       = (Number(total_cart_val));
var dummy_tot   = document.getElementById('dummy7').value;
var dummy_id    = document.getElementById('dummy1').value;
var dummy_id1    = document.getElementById('dummy2').value;
var dummy8    = document.getElementById('dummy8').value;
var total_order = (Number(dummy_tot));

//alert(dummy8);

$(".dummy2").val(dummy_id1+','+dummy_id);

String.prototype.containsWord = function(word) {

    var regex = new RegExp('\\b' + word + '\\b');

    return regex.test(this);

};

//var myString = 'This is some random string.';

var check_in = dummy_id1.containsWord(test);

if(jobref != ''){

if(check_in == false){
    
$(".total_cart").html(total);
$(".total_cart_txt").val(total);
$(".total_order").html(total_order.toFixed(2));
$(".total_order_txt").val(total_order); 
$(".dummy8").val(dummy_tot); 
    
}else{
    return false;
}

}
else
    {
        alert('Please Enter the Job Reference Number')
        document.getElementById('jobref').focus();   
        return false; 
    }

}

function chk_login()
{
    var user_log = document.getElementById('user_session').value; 
    if(user_log == ''){
        alert("You must login in order to Checkout.");
        return false;
    }
    else
        {
        return true;
        }
    //alert(user_log);
}
    

 </script>
 <!--<div class="continute_service_shopping" style="margin-top:5px;">
 Add <select name="redirect_to" id="redirect_to">
 <option value="plotting">Plotting</option>
 <option value="copyshop">Copy Shop</option>
 </select> to my order &nbsp;&nbsp;&nbsp;
 <input class="continute_service_shopping_link" type="submit" value="Go >" style="cursor: pointer;font-size:12px; padding:1.5px; width: 50px;margin-right:14px;margin-top:5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;"/> 
 </div>-->
 <input class="addstroeproductActionLink" <?php if($_SESSION['job'] == ''){echo 'disabled="disabled"';}?> value="Checkout" style="cursor: pointer;float:right;font-size:12px; padding:1.5px; width: 100px;margin-top:11px;margin-bottom:20px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="submit" /> 
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
<!--<script>
function qty_emty()
{
    var user_log = $(".dummy5").val();
    if(user_log == ''){
        alert("You must enter the quantity any one product.");
        return false;
    }
    else
        {
        return true;
        }
}
</script>-->
<!--<script type="text/javascript">
$(document).ready(function()
{
 $("form").submit(function()
 { 
 
 var allCurrentOrderTotal = $('span#allCurrentOrderTotal').text();
 var product_id = document.getElementsByName('product_id').value;
 if(allCurrentOrderTotal != '') 
 {
 $.ajax
 ({
 type: "POST",
 url: "get_order.php",
 data: "allCurrentOrderTotal="+ allCurrentOrderTotal+"&product_id="+product_id,
 success: function(option)
 {
 //$("#msg").html(option);
 //window.top.location = "subcategory.php";
 }
 });
 }
 else
 {
 alert('test');
 }
 return false;
 });
});


</script>-->