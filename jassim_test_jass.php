<?php
include './admin/config.php';
include './admin/db_connection.php';


$_SESSION['job'] = $_REQUEST['jobref'];

$_SESSION['qty'] = $_REQUEST['quantity'];

$user_id = $_SESSION['sohorepro_companyid'];

$id_user = $_SESSION['sohorepro_userid'];



$shipping_address = ShippingAddress($user_id);

$primary_shipping = PrimaryShipping($user_id);

$user_manager = CheckManager($id_user);


if($_GET['redirect'] == 'serivce_recipient'){
?>
<script>setTimeout("location.href=\'add_recipients.php?address_ste=1\'", 1000);</script>
<?php
}

if ($_GET['delete_id']) {

    $delete_id = $_GET['delete_id'];

    $sql = "DELETE FROM sohorepro_address WHERE id = " . $delete_id . " ";

    $sql_result = mysql_query($sql);

    if ($sql_result) {

        $result = "success";

    } else {

        $result = "failure";

    }

}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

 <!-- Mirrored from buckart.com/srsite/SoHoRepro-WebsitePages/store/store.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 21 Sep 2013 08:44:50 GMT -->

 <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

 <head>

 <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">

 <title>SohoRepro Address Book</title>



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

<table width="740" border="0" cellspacing="0" cellpadding="0">

  <tr>

      <td align="right" valign="middle" height="55" ><a href="add_address.php"><img class="address" src="images/add_address.jpg"  alt="Add Shipping Address" title="Add Shipping Address" /></a></td>

  </tr>

  <tr>

  <td align="left" valign="top">

  <table width="740" border="0" cellspacing="0" cellpadding="0" class="product_table" >

  <tr bgcolor="#ff7e00" class="h1">

    <td width="48" align="center" valign="middle" class="brdr_2" >No.</td>

    <td width="46" align="center" valign="middle" class="brdr_2" >Shipping Address</td>    

    <td width="97" align="center" valign="middle" class="brdr_2">Actions</td>

  </tr>

      <?php

      if(count($primary_shipping) > 0){

      $j = 1;

      foreach ($primary_shipping as $primary) {

                    $rowColor = ($j % 2 != 0) ? '#ffeee1' : '#fff6f0';  

                    $id        = $primary['id'];

                    $comp_id   = $primary['comp_id'];

                    $comp_name = ($primary['company_name'] != '') ? $primary['company_name'].'</br>' : '' ;            

                    $address_1 = ($primary['address_1'] != '') ? $primary['address_1'].'</br>' : '';

                    $address_2 = ($primary['address_2'] != '') ? $primary['address_2'].'</br>' : '';  

                    $address_3 = ($primary['address_3'] != '') ? $primary['address_3'].'</br>' : ''; 

                    $city      = $primary['city'];

                    $state     = StateName($primary['state']);                    

                    $zip       = $primary['zip'];

                    $zip_ext   = $primary['zip_ext'];

                    $zip_e     = ($primary['zip_ext'] != '')? '+':'';

                    $attention = ($primary['attention_to'] != '') ? $primary['attention_to'].'</br>' : '';

                    $phone     = ($primary['phone']) ? $primary['phone'] : '' ;      

                    $type      = $primary['type'] ;

      ?>

  <tr bgcolor="<?php echo $rowColor; ?>">

    <td width="48" align="center" valign="middle" class="brdr_1"><?php echo $j;?></td>

    <td width="243" align="left" valign="middle" class="brdr_1"><?php echo $comp_name.$attention.$address_1.$address_2.$address_3.$city.',  '.$state.'&nbsp;'.$zip.$zip_e.$zip_ext.'</br>'.$phone; ?></td>

    <td width="97" align="center" valign="middle" class="brdr_1"><?php if($type == '1'){?><span style="font-weight: bold !important;">Primary Shipping Address</span></br></br><?php }if($user_manager == '1'){?><a href="edit_address.php?id=<?php echo $id; ?>"><img src="admin/images/edit.png"  alt="Edit Shipping Address" title="Edit Shipping Address" width="22" height="22"/></a><?php } ?></td>

  </tr>

      <?php

      }

      }

            if(count($shipping_address) > 0){

            $i = 2;

                foreach ($shipping_address as $address) {

                    $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';  

                    $id        = $address['id'];

                    $comp_id   = $address['comp_id'];

                    $comp_name = ($address['company_name'] != '') ? $address['company_name'].'</br>' : '';

                    $attention = ($address['attention_to'] != '') ? $address['attention_to'].'</br>' : '';

                    $address_1 = ($address['address_1'] != '') ? $address['address_1'].'</br>' : '';

                    $address_2 = ($address['address_2'] != '') ? $address['address_2'].'</br>' : '' ;  

                    $address_3 = ($address['address_3'] != '') ? $address['address_3'].'</br>' : '' ; 

                    $city      = $address['city'];

                    $state     = StateName($address['state']);                    

                    $zip       = $address['zip'];

                    $zip_ext   = $address['zip_ext'];

                    $zip_e     = ($address['zip_ext'] != '')? '+':'';                    

                    $phone     = ($address['phone'] != '') ? $address['phone'] : '' ;  

                    $ext       = ($address['extension'] != '') ? $address['extension'] : '';  

                    $type      = $address['type'] ;

                    ?>

  <tr bgcolor="<?php echo $rowColor; ?>">    

    <td width="48" align="center" valign="middle" class="brdr_1"><?php echo $i; ?></td>

    <td width="243" align="left" valign="middle" class="brdr_1"><?php echo $comp_name.$attention.$address_1.$address_2.$address_3.$city.',  '.$state.'&nbsp;'.$zip.$zip_e.$zip_ext.'</br>'.$phone.'</br>'.$ext; ?></td>

    <td width="97" align="center" valign="middle" class="brdr_1"><a href="edit_address.php?id=<?php echo $id; ?>"><img src="admin/images/edit.png"  alt="Edit Shipping Address" title="Edit Shipping Address" width="22" height="22"/></a>&nbsp;&nbsp;<a href="addressbook.php?delete_id=<?php echo $id; ?>" onclick="return confirm('Are you sure?');"><img src="admin/images/del.png"  alt="Delete Shipping Address" title="Delete Shipping Address" width="22" height="22" class="mar_lft"/></a></td>

  </tr>

  <?php

    $i++;

    } 

    }

     ?>

    </table>

</td>

  </tr>

</table>

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



</script>