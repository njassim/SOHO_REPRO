<?php
include "./admin/config.php";

$_SESSION['job'] = $_REQUEST['jobref'];

$_SESSION['qty'] = $_REQUEST['quantity'];

$user_id = $_SESSION['sohorepro_userid'];

$company_id = company_id($user_id);

$state_all = StateAll();

if ($_REQUEST['new_address'] == '1') {    

    extract($_POST);    

    $sql = "INSERT INTO sohorepro_address_service

			SET     comp_id         = '". $company_id ."',

                                company_name    = '". $comp ."',

                                address_1       = '". $add1 ."',                        

                                address_2       = '". $add2 . "',  

                                address_3       = '". $add3 . "',  

                                city            = '". $city ."',

                                state           = '". $state."',   

				zip             = '". $zip ."',

                                zip_ext         = '" . $zipext."',

                                phone           = '". $phone ."',

                                extension       = '". $ext ."',

                                attention_to    = '". $attention."' ";

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

.addinput

 {

 margin: 0 14px;

 width: 166px;

 border: 1px solid #e4e4e4;

 padding: 3.5px;

 margin-bottom: 15px;

 font-size: 11px;

 font-weight: bold;

 color: #717171;

 float: left;

 }

.address

{

    cursor:pointer;

}

.lable

{

    padding-bottom: 15px;

}

.address_add

{

    background:url(admin/images/btn_save.png) no-repeat;

    width:92px;

    height:34px;

    font-size:14px;

    font-weight:bold;

    text-transform: uppercase;

    color: #fff;

    border:0px;

    cursor:pointer;

}

</style>



 <link rel="shortcut icon" href="http://soho.thinkdesign.com/favicon.ico" type="image/x-icon">

 <link rel="stylesheet" type="text/css" href="store_files/style_layout.css">

 <!--[if IE 7]>

 <link rel="stylesheet" type="text/css" href="css/ie_7_hacks.css" />

 <![endif]-->

<script type="text/javascript" src="admin/js/phnovalid.js"></script>

<script type="text/javascript">

jQuery(function($){

   $("#zip").mask("99999");

   $("#zipext").mask("9999");

   $("#phone").mask("999-999-9999");

   $("#ext").mask("9999");

});

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
        if($_GET['serivice_plotting'] == '1'){
            $redirect = 'serivce_recipient';
        }
        ?>

        <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Shipping Address Inserted Successfully</div>

        <script>setTimeout("location.href=\'service_address_book.php\'", 1000);</script>

        <?php

    } elseif ($result == "failure") {

        ?>

        <div style="color:#F00; text-align:center; padding-bottom:10px;">Shipping Address Not Successfully</div>

        <script>setTimeout("location.href=\'service_address_book.php\'", 1000);</script>       

        <?php

    }

    ?>

<table width="740" border="0" cellspacing="0" cellpadding="0">

  <tr height="30px"></tr>

  <tr>

  <td align="center">

      <form name="new_address" id="new_address" method="post" action=""  onsubmit="return validate();" >

          <input type="hidden" name="new_address" value="1" />        

      <table>

          <tr>

              <td colspan="2" align="center" valign="middle" height="35" style="font-weight: bold !important;color: #000 !important; font-size: 16px;">Add New Shipping Address</td>

          </tr>

          <tr>

              <td class="lable">Company</td>

              <td><textarea class="addinput" name="comp" id="comp"></textarea><div id="msg1" style="color:#FF0000;padding-left: 50px;"></div></td>

          </tr>

          <tr>

              <td class="lable">Attention to</td>

              <td><input type="text" class="addinput" name="attention" id="attention" /><div id="msg2" style="color:#FF0000;padding-left: 50px;"></div></td>

          </tr>

          <tr>

              <td class="lable">Address 1</td>

              <td><textarea class="addinput" name="add1" id="add1"></textarea><div id="msg3" style="color:#FF0000;padding-left: 50px;"></div></td>

          </tr>

          <tr>

              <td class="lable">Address 2</td>

              <td><textarea class="addinput" name="add2" id="add2"></textarea><div id="msg4" style="color:#FF0000;padding-left: 50px;"></div></td>

          </tr>

          <tr>

              <td class="lable">Address 3</td>

              <td><textarea class="addinput" name="add3" id="add3"></textarea><div id="msg5" style="color:#FF0000;padding-left: 50px;"></div></td>

          </tr>

          <tr>

              <td class="lable">City</td>

              <td><input type="text" class="addinput" name="city" id="city" /><div id="msg6" style="color:#FF0000;padding-left: 50px;"></div></td>

          </tr>

          <tr>

              <td class="lable">State</td>

              <td>                  

                <select name="state" id="state" class="addinput" style="width: 175px !important;">

                    <option value="0">Select state</option>

               <?php foreach ($state_all as $state) { ?>

                        <option value="<?php echo $state['state_id'] ?>"><?php echo $state['state_abbr']; ?></option>

                    <?php } ?>

               </select>

              <div id="msg7" style="color:#FF0000;padding-left: 50px;"></div>

              </td>

          </tr>

          <tr>

              <td class="lable">Zip</td>

              <td><input type="text" class="addinput" name="zip" id="zip" /><div id="msg8" style="color:#FF0000;padding-left: 50px;"></div></td>

              <td class="lable">+4</td>

              <td><input type="text" class="addinput" name="zipext" id="zipext" /></td>

          </tr>       

          <tr>

              <td class="lable">Phone</td>

              <td><input type="text" class="addinput" name="phone" id="phone" /><div id="msg9" style="color:#FF0000;padding-left: 50px;"></div></td>

              <td class="lable">Ext</td>

              <td><input type="text" class="addinput" name="ext" id="ext" /></td>

          </tr>

          <tr>

              <td>&nbsp;</td>

              <td>

                  <input type="submit" class="address_add" name="submit" id="submit" value="Save" /><input type="button" name="cancel" id="cancel" class="address_add" value="Cancel" onClick="javascript:window.location = '<?php echo 'add_recipients.php'; ?>'" style="margin-left:15px;" />

              </td>

          </tr>

      </table>

    </form>

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

function validate()

{

    var str = true;

    document.getElementById("msg1").innerHTML = "";

    document.getElementById("msg2").innerHTML = "";    

    document.getElementById("msg3").innerHTML = "";    

    document.getElementById("msg4").innerHTML = "";

    document.getElementById("msg5").innerHTML = "";

    document.getElementById("msg6").innerHTML = "";

    document.getElementById("msg7").innerHTML = "";

    document.getElementById("msg8").innerHTML = "";

    document.getElementById("msg9").innerHTML = "";

     if (document.new_address.comp.value == '')

    {

        document.getElementById("msg1").innerHTML = "Enter the company name";

        str = false;

    }

//    if (document.new_address.attention.value == '')

//    {

//        document.getElementById("msg2").innerHTML = "Enter the attention_to";

//        str = false;

//    }  

    if (document.new_address.add1.value == '')

    {

        document.getElementById("msg3").innerHTML = "Enter the address1";

        str = false;

    }  

//    if (document.new_address.add2.value == '')

//    {

//        document.getElementById("msg4").innerHTML = "Enter the address2";

//        str = false;

//    }

//    if (document.new_address.add3.value == '')

//    {

//        document.getElementById("msg5").innerHTML = "Enter the address3";

//        str = false;

//    }

    if (document.new_address.city.value == '')

    {

        document.getElementById("msg6").innerHTML = "Enter the city";

        str = false;

    }

    if (document.new_address.state.value == '0')

    {

        document.getElementById("msg7").innerHTML = "Select the State";

        str = false;

    }

    if (document.new_address.zip.value == '')

    {

        document.getElementById("msg8").innerHTML = "Enter the zip";

        str = false;

    }

    if (document.new_address.phone.value == '')

    {

        document.getElementById("msg9").innerHTML = "Enter the phone";

        str = false;

    }

    return str;



}



</script>