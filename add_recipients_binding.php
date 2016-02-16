<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);
if($_SESSION['sohorepro_companyid']  == '')
{
  header("Location:index.php");
  exit;
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

 
 <link href="style/popup_style.css" rel="stylesheet" type="text/css" media="all" />
 <!--<link rel="shortcut icon" href="http://soho.thinkdesign.com/favicon.ico" type="image/x-icon">-->
 <link rel="stylesheet" type="text/css" href="store_files/style_layout.css">
 <!--[if IE 7]>
 <link rel="stylesheet" type="text/css" href="css/ie_7_hacks.css" />
 <![endif]-->
 <script src="store_files/jquery.min.js"></script>
 <script type="text/javascript" src="js/jquery.timepicker.js"></script>
 <link rel="stylesheet" href="js/jquery-ui.css" />
<script src="js/jquery-ui_service.js"></script>
<link rel="stylesheet" type="text/css" href="js/jquery.timepicker.css" media="screen" />
<script src="js/jquery.maskedinput.js" type="text/javascript" ></script>
<script>
function show_time(ID)
{
    //alert(ID);
    
    $('#time_picker_icon_'+ID).timepicker({
        'minTime': '8:00am',
        'maxTime': '7:00pm',
        'showDuration': true
    });
}

function show_time_return()
{
    $('#time_picker_icon').timepicker({
        'minTime': '8:00am',
        'maxTime': '7:00pm',
        'showDuration': true
    });
}
    
    
function dtls_reveal(ID)
{
    var slide_up = $("#slide_id").val();
    $("#plotting_details_"+ID).slideToggle();
    if(slide_up != ID){
    $("#plotting_details_"+slide_up).slideUp();
    }
    $("#slide_id").val(ID);
}

function delete_plot(ID)
{
    //alert(ID);
}

 $(document).ready(function() {
var top = $('#fixed_header').offset().top - parseFloat($('#fixed_header').css('marginTop').replace(/auto/, 100));
$(window).scroll(function(event) {
    // what the y position of the scroll is
    var y = $(this).scrollTop();

    // whether that's below the form
    if (y >= top) {
        // if so, ad the fixed class
        $('#fixed_header').addClass('fixed_1');
    } else {
        // otherwise remove it
        $('#fixed_header').removeClass('fixed_1');
    }
});

});




$(window).load(function() {
    var entered_plot_already = $("#entered_plot_already").val();
    if(entered_plot_already > 0){
        document.getElementById('del_type_multi').checked = true;
        multiple_recipient();
    }    
    
    });


</script>


 <style>
     .fixed_1{border-style:solid;border-width:0px; position: fixed; width: 761px; top: 0; z-index: 1; background: #DFDFDF;}
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
    right: 0;
    text-align: left;
    top: 19px;
    width: 185px;
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
.none{
    display: none;
}
.progress { position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
.bar { background-color: #F99B3E; width:0%; height:20px; border-radius: 3px; }
.percent { position:absolute; display:inline-block; top:3px; left:48%; }
.upload_file_prog{
width: 30% !important;
padding: 1.5px;
-webkit-border-radius: 5px;
border: 1px solid #8f8f8f !important;
}
.arch_radio li{
list-style: none;
padding: 0px !important;
padding-left: 0px !important;
padding-bottom: 0px !important;
}
.increse_act{width: 12px;float: left;}
.increse_act img{width: 12px;float: left;}

.time_picker_icon {
    background: #FFFFFF url(images/clock.png) no-repeat 4px 4px;
    padding: 5px 5px 5px 30px;
    /*height: 18px;*/
    cursor: pointer;
    width: 50px;
    width: 75px !important;
}
.shaddows{
        background: white;
        border-radius: 10px;
        -webkit-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
        -moz-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
        box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
        position: relative;
        z-index: 90;
}

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

#asap_popup{
    display: none;
    font-size: 15px;
    position: fixed !important;
    top: 150px;
    left: 40%;
    padding: 5px;
    z-index: 10;
    position: absolute;
    z-index: 1000;
    width: 25%;
    background: white;
    border-bottom: 1px solid #aaa;
    border-radius: 4px;
    box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
    border: 1px solid rgba(0, 0, 0, 0.1);
    background-clip: padding-box;
}

.asap_orange{
    cursor: pointer;
    display: inline-block;
    background: #F99B3E;
    color: #FFF;
    padding: 5px 20px;
    border-radius: 5px;
    margin-top: 3px;
    font-weight: bold;
}

.asap_green{
    cursor: pointer;
    display: inline-block;
    background: #019E59;
    color: #FFF;
    padding: 5px 20px;
    border-radius: 5px;
    margin-top: 3px;
    font-weight: bold;
}

.select-dash { border-bottom: 1px dotted #000; }

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

#address_container li label{
    width: 25%;
    float: left;
    margin-left: 35px;
    font-weight: bold;
}

#address_container li{
        padding-bottom: 10px;
}
 </style>
 
 </head>
 <body>
    <div id="loading" class="none"  style="position: fixed;top: 10%;left: 40%;padding: 5px;z-index: 1002;">
         <img src="admin/images/loading_rainbow.gif" border="0" style="width: 200px;height: 200px;" />
    </div>
    <div id="asap_popup">
        <div style="width: 96%;float:left;text-align: center;background-color: #EEE;padding: 1%;font-weight: bold;font-size: 18px;padding-top: 10px;">
            Edit Recipient Address
        </div>
        <div id="recipient_address" style="width: 96%;padding: 2%;float: left;font-size: 14px;line-height: 18px;text-align: justify;">
            
        </div>
        <div style="float: right;width: 98%;background-color: #EEE;padding: 1%;">
            <span style="float: left;border: 1px solid #BBB;padding: 3px 10px;border-radius: 3px;cursor: pointer;" onclick="return save_recipient_address();">Save</span>
            <span style="float: right;border: 1px solid #BBB;padding: 3px 10px;border-radius: 3px;cursor: pointer;" onclick="return close_asap();">Close</span>
        </div>
    </div>
 <div id="body_container">
 <div id="body_content" class="body_wrapper">
 <div id="body_content-inner" class="body_wrapper-inner">

<?php include "includes/header_sidebar.php"; ?>
 
 <div id="content_output">

<?php include "includes/top_nav.php"; ?>
 
 <div id="content_output-data" style="margin-bottom:20px;">  
<!--- TABLE START -->
<?php // include "./service_nav.php"; ?>
<div id="orderWapper">
  <!-- 
<div class="orderBreadCrumb">
</div>
-->

<div style="width: 100%;float: left;font-size: 35px;font-weight: bold;border: 1px solid #ff7e00;border-top: 0px;border-right: 0px; border-left: 0px;" class="orange">
    Delivery Job Reference: <span style="text-transform: uppercase;font-size: 35px;font-weight: bold;"><?php echo $_SESSION['ref_val']; ?></span>
</div>

<?php
$number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid']);
$cust_original_order    = EnteredPlotRecipientsMulti($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid'], $_SESSION['ref_val']);
$bindin_options = AllBindingOptions($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid'], $_SESSION['ref_val']);
//echo '<pre>';
//print_r($bindin_options);
?>

<div style="background-color:#FFFFFF;margin-top: 20px;border-bottom: 1px solid #ff7e00;">                            
    <div style="padding-top: 10px;margin-top: 40px;">
        <input type="radio" name="del_type" id="everything_return" value="1" style="width: 15% !important;" onclick="return everything_return_binding();" /><span style="text-transform: uppercase;font-weight: bold;">Return everything to my office</span>
    </div>
    <div>
        <input type="radio" name="del_type" id="send_everything_to" value="1" style="width: 15% !important;" onclick="return send_everything_to();" /><span style="text-transform: uppercase;font-weight: bold;">Send everything to :</span>                                
        <select  name="address_book_se" id="address_book_se" style="width: 20% !important;" onchange="return send_everything_to();">
            <option value="0">Address Book</option>
            <?php
            $address_book = AddressBookCompanyService($_SESSION['sohorepro_companyid']);
            foreach ($address_book as $address) { ?>                                                                                        
            <option value="<?php echo $address['id']; ?>"><?php echo $address['company_name']; ?></option>
            <?php
            }
            ?>
        </select>
        &nbsp;&nbsp; <span style="text-transform: uppercase;"><a href="service_add_address.php?serivice_plotting=1" style="color: #0001fc;" >Add entry</a>&nbsp;|&nbsp;<a href="service_address_book.php" style="color: #0001fc;">EDIT</a>&nbsp; to address book</span>
    </div>
    <div>
        <input type="radio" name="del_type" id="del_type_multi" value="1" style="width: 15% !important;" onclick="return multiple_recipient();"  /><span style="text-transform: uppercase;font-weight: bold;">Distribute to one or more locations</span>
    </div>
    <div style="margin-bottom: 10px;">
        <input type="radio" name="del_type" id="pickup_soho" value="1" style="width: 15% !important;" onclick="return pickup_soho();" /><span style="text-transform: uppercase;font-weight: bold;">WILL PICKUP FROM SOHO REPRO</span>                                
        <select style="width: 20% !important;" id="pickup_soho_add" name="pickup_soho_add" onchange="return pickup_soho();">
            <option value="1" selected="selected">381 Broome St</option>
            <option value="2" >307 7th Ave, 5th Floor</option>
        </select>
    </div>
</div>



<div id="main_body" style="width: 100%;float: left;border: 1px solid #FF7E00;margin-top: 10px;display: none;">
    <ul style="list-style: none;padding:10px;">
        <?php
        foreach ($bindin_options as $binding){
            
            $main_binding           = ($binding['binding'] == '7') ? "Velo Bind" : "";
            $main_binding_option    = ($binding['binding_option'] == '11') ? "White" : "";
            
            $front_cover            = ($binding['front_cover'] == '101') ? "Clear Cover" : "";
            
            $back_cover             =  ($binding['back_cover'] == '203') ? "Frosted Cover" : "";
        ?>
        <li style="margin-top: 3px;"><label style="font-weight: bold;width: 203px;float: left;">Binding:</label><?php echo $main_binding; ?></li>
        <li style="margin-top: 3px;"><label style="font-weight: bold;width: 203px;float: left;">Binding Option:</label><?php echo $main_binding_option; ?></li>
        <li style="margin-top: 3px;"><label style="font-weight: bold;width: 203px;float: left;">Front Cover:</label><?php echo $front_cover; ?></li>
        <li style="margin-top: 3px;"><label style="font-weight: bold;width: 203px;float: left;">Front Cover Option:</label><?php echo $binding['front_cover_option']; ?></li>
        <li style="margin-top: 3px;"><label style="font-weight: bold;width: 203px;float: left;">Back Cover:</label><?php echo $back_cover; ?></li>
        <li style="margin-top: 3px;"><label style="font-weight: bold;width: 203px;float: left;">Back Cover Option:</label><?php echo $binding['back_cover_option']; ?></li>
        <li style="margin-top: 3px;"><label style="font-weight: bold;width: 203px;float: left;">Number of Book Binding:</label><?php echo $binding['number_of_book_bind']; ?></li>
        <li style="margin-top: 3px;"><label style="font-weight: bold;width: 203px;float: left;">Cutting:</label><?php echo $binding['cutting']; ?></li>
        <li style="margin-top: 3px;"><label style="font-weight: bold;width: 203px;float: left;">Cutting Instruction:</label><?php echo $binding['cutting_instruction']; ?></li>
        <li style="margin-top: 3px;"><label style="font-weight: bold;width: 203px;float: left;">Size:</label><?php echo $binding['size']; ?></li>
        <li style="margin-top: 3px;"><label style="font-weight: bold;width: 203px;float: left;">Custom Size:</label><?php echo $binding['size_custome']; ?></li>
        <li style="margin-top: 3px;"><label style="font-weight: bold;width: 203px;float: left;">Special Instruction:</label><?php echo $binding['special_instruction']; ?></li>
        <?php } ?>
    </ul>
</div>


<div id="go_to_next_section" style="float:right;margin-top: 10px;display: none;">
    <!--<input class="addNewOrderSet" value="Add Set" style="float:right;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="button" onclick="return validate_plotting();" />-->
    <input class="addproductActionLink" value="Continue" style="cursor: pointer;font-size: 12px; padding: 1.5px; width: 135px; margin-right: 14px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;margin-top: -0px !important;" type="button" onclick="return continue_recipient();">
</div>


</div>  
</div>
     
     


 <div class="login_loader"></div>
 <div id="backgroundPopup"></div>

<?php
//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>';  
     ?>
     
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


 <script>    
 
 function multiple_recipient()
 {
     var multi = document.getElementById('del_type_multi').checked;
     if(multi == true){ 
          $.ajax
                ({
                    type: "POST",
                    url: "get_recipients.php",
                    data: "recipients=1",
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {  
                        var options_divide = option.split('~');
                        $('#multi_recipients').slideDown();
                        $('#multi_recipients').html(options_divide[0]);
                        $('.addproductActionLink').hide();
                        //$('#remain_options').html(options_divide[1]);
                        //$('#add_recipients').slideDown();
                    }
                });
     }else{
         alert('Mohamed');
     }
 }
 
 function everything_return_binding()
 {
     //$("body").append("<div class='modal-overlay'></div>");
     var everything_return = document.getElementById('everything_return').checked;
     if(everything_return == true){ 
         $.ajax
                ({
                    type: "POST",
                    url: "everything_return.php",
                    data: "everything_return=1",
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {  
                       $("#main_body").fadeIn();
                       $("go_to_next_section").fadeIn();
                       //$("body").hide("<div class='modal-overlay'></div>");
                    }
                });
     }else{
         $('#multi_recipients').slideUp();
         $('#add_recipients').slideUp();
     }
 }
 
 function continue_recipient_everyting_return()
 {
     var pickup_soho_chk        = document.getElementById('pickup_soho').checked;
     var shipping_id_pre        = $("#address_book_rp").val();
     var shipping_id            = (pickup_soho_chk == true) ? 'P'+shipping_id_pre : shipping_id_pre;
     var user_session           = $("#user_session").val(); 
     var user_session_comp      = $("#user_session_comp").val(); 
     var delivery_type_option   = $("#delivery_type_option").val();
     var delivery_type          = $("#delivery_comp").val();
     
     var avl_sets_1             = $("#avl_sets_1").val();
     var need_sets_1            = $("#need_sets_1").val();
     var size_sets_1            = $("#size_sets_1").val();
     var output_sets_1          = $("#output_sets_1").val();
     var media_sets_1           = $("#media_sets_1").val();
     var binding_sets_1_pre     = $("#binding_sets_1").val();
     var folding_sets_1         = $("#folding_sets_1").val();
     var binding_sets_1         = (binding_sets_1_pre != '') ? binding_sets_1_pre : '0' ;
     
     var avl_sets_2             = $("#avl_sets_2").val();
     var need_sets_2            = $("#need_sets_2").val();
     var size_sets_2            = $("#size_sets_2").val();
     var output_sets_2          = $("#output_sets_2").val();
     var binding_sets_2_pre     = $("#binding_sets_2").val();
     var binding_sets_2         = (binding_sets_2_pre != '') ? binding_sets_2_pre : '0' ;
     var folding_sets_2         = $("#folding_sets_2").val();
     var date_needed            = $("#date_needed").val();
     var time_needed            = $("#time_picker_icon").val();
     var spl_recipient          = $("#spl_recipient").val();
     var contact_ph             = $("#contact_ph").val();
     
     var shipp_att              = $("#shipp_att").val();
     
     var option_id              =   $("#option_id").val();
     
     var size_custom_details    = (size_sets_1 == 'Custom') ? document.getElementById("size_custom_details").value : '0';
     
     var output_page_details    = (output_sets_1 == 'Both') ? document.getElementById("output_page_details").value : '0';
     
     var preffer_del            = document.getElementById('preffer_del').checked;  
     
     var arrange_del            = document.getElementById('arrange_del').checked;
     
     var delivery_type          = (arrange_del == false) ? $("#delivery_comp").val() : '0';
     
     var delivery_comp          = (arrange_del == false) ? document.getElementById("delivery_comp").value : '0';
     var bill_number            = (arrange_del == false) ? document.getElementById("bill_number").value : '0';
     if(arrange_del == false)
     {
        var shipp_comp_1        =   document.getElementById('shipp_comp_1').checked;
            var shipp_comp_1_f  =   (shipp_comp_1 == true) ? document.getElementById("shipp_comp_1").value : '0';
        var shipp_comp_2        =   document.getElementById('shipp_comp_2').checked;
            var shipp_comp_2_f  =   (shipp_comp_2 == true) ? document.getElementById("shipp_comp_2").value : '0';
        var shipp_comp_3        =   document.getElementById('shipp_comp_3').checked;
            var shipp_comp_3_f  =   (shipp_comp_3 == true) ? document.getElementById("other_shipp_type").value : '0';
     }else{
            var shipp_comp_1_f  =   '0';
            var shipp_comp_2_f  =   '0';
            var shipp_comp_3_f  =   '0';
     }      
     
     
     if(shipping_id == '0'){
         alert('Please select send to address');
         $("#address_book_rp").focus();
         return false;
     }
     
//     if(shipp_att == ''){
//         alert('Please enter the attention to');
//         $("#shipp_att").focus();
//         return false;
//     }
     
     if(date_needed == ''){
         alert('Please select when needed');
         $("#date_needed").focus();
         return false;
     }
     
     $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=4_4&shipping_id_rec="+encodeURIComponent(shipping_id)+"&avl_sets_1="+encodeURIComponent(avl_sets_1)+"&need_sets_1="+encodeURIComponent(need_sets_1)+"&size_sets_1="+encodeURIComponent(size_sets_1)+"&output_sets_1="+encodeURIComponent(output_sets_1)+"&binding_sets_1="+encodeURIComponent(binding_sets_1)+"&avl_sets_2="+encodeURIComponent(avl_sets_2)+"&need_sets_2="+encodeURIComponent(need_sets_2)+"&size_sets_2="+encodeURIComponent(size_sets_2)+"&output_sets_2="+encodeURIComponent(output_sets_2)+"&binding_sets_2="+encodeURIComponent(binding_sets_2)+"&user_session="+encodeURIComponent(user_session)+"&user_session_comp="+encodeURIComponent(user_session_comp)+"&date_needed="+encodeURIComponent(date_needed)+"&spl_recipient="+encodeURIComponent(spl_recipient)+"&folding_sets_1="+encodeURIComponent(folding_sets_1)+"&folding_sets_2="+encodeURIComponent(folding_sets_2)+"&time_needed="+encodeURIComponent(time_needed)+"&size_custom_details="+encodeURIComponent(size_custom_details)+"&output_page_details="+encodeURIComponent(output_page_details)+"&attention_to="+encodeURIComponent(shipp_att)+"&media_sets_1="+encodeURIComponent(media_sets_1)+"&contact_ph="+encodeURIComponent(contact_ph)+"&option_id="+encodeURIComponent(option_id)+"&delivery_type_option="+encodeURIComponent(delivery_type_option)+"&bill_number="+encodeURIComponent(bill_number)+"&shipp_comp_1_f="+encodeURIComponent(shipp_comp_1_f)+"&shipp_comp_2_f="+encodeURIComponent(shipp_comp_2_f)+"&shipp_comp_3_f="+encodeURIComponent(shipp_comp_3_f)+"&delivery_type="+encodeURIComponent(delivery_type),
            beforeSend: loadStart,
            complete: loadStop,
            success: function(option)
            {  
                if(option == '1'){
                    window.location = "view_all_recipients.php";
                }
            }
        });
 }
 
 function everything_return_arch()
 {
     var everything_return = document.getElementById('everything_return').checked;
     if(everything_return == true){ 
         $.ajax
                ({
                    type: "POST",
                    url: "everything_return.php",
                    data: "everything_return=1_99",
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {  
                        $('#multi_recipients').slideDown();
                        $('#multi_recipients').html(option);
                        $('#add_recipients').slideUp();
                    }
                });
     }else{
         $('#multi_recipients').slideUp();
         $('#add_recipients').slideUp();
     }
 }
 
 function send_everything_to()
 {
     var send_everything_to = document.getElementById('send_everything_to').checked;
     var address_book_se    = document.getElementById('address_book_se').value;
     if(send_everything_to == true){
         if(address_book_se != '0'){
             $.ajax
                ({
                    type: "POST",
                    url: "everything_return_to.php",
                    data: "everything_return_to=1&address_book_se="+address_book_se,
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {  
                        $('#multi_recipients').slideDown();
                        $('#multi_recipients').html(option);
                        $('#add_recipients').slideDown();
                        $('.addrecipientActionLink').hide();
                        $(".addproductActionLink").hide();
                    }
                });
         }else{
            alert("Select the address.");
            document.getElementById('address_book_se').focus();
            document.getElementById('send_everything_to').checked = false;
         }
     }else{
         $('#multi_recipients').slideUp();
         $('#add_recipients').slideUp();
     }
 }
 
 function pickup_soho()
 {
     // $("body").append("<div class='modal-overlay'></div>");
     var pickup_soho             = document.getElementById('pickup_soho').checked;
     var pickup_from_soho_add    = document.getElementById('pickup_soho_add').value;
     if(pickup_soho == true){
         $.ajax
                ({
                    type: "POST",
                    url: "pickup_from_soho.php",
                    data: "pickup_from_soho=1&pickup_from_soho_add="+pickup_from_soho_add,
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {  
                        $('#multi_recipients').slideDown();
                        $('#multi_recipients').html(option);
                        $('#add_recipients').slideDown();
                        $('.addrecipientActionLink').hide();
                        $(".addproductActionLink").hide();
                        //$( ".modal-overlay" ).remove();
                    }
                });
     }else{
         $('#multi_recipients').slideUp();
         $('#add_recipients').slideUp();
     }
 }
 
 function pickup_soho_p()
 {
     var pickup_soho             = document.getElementById('pickup_soho').checked;
     var pickup_from_soho_add    = document.getElementById('address_book_rp').value;
     if(pickup_soho == true){
         $.ajax
                ({
                    type: "POST",
                    url: "pickup_from_soho.php",
                    data: "pickup_from_soho=1&pickup_from_soho_add="+pickup_from_soho_add,
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {  
                        $('#multi_recipients').slideDown();
                        $('#multi_recipients').html(option);
                        $('#add_recipients').slideDown();
                    }
                });
     }else{
         $('#multi_recipients').slideUp();
         $('#add_recipients').slideUp();
     }
 }
 
 function add_recipients(){
     
     var pickup_soho_chk        = document.getElementById('pickup_soho').checked;
     var shipping_id_pre        = $("#address_book_rp").val();
     var shipping_id            = (pickup_soho_chk == true) ? 'P'+shipping_id_pre : shipping_id_pre;
     var user_session           = $("#user_session").val(); 
     var user_session_comp      = $("#user_session_comp").val(); 
     
     var avl_sets_1             = $("#avl_sets_1").val();
     var need_sets_1            = $("#need_sets_1").val();
     var size_sets_1            = $("#size_sets_1").val();
     var output_sets_1          = $("#output_sets_1").val();
     var media_sets_1           = $("#media_sets_1").val();
     var binding_sets_1_pre     = $("#binding_sets_1").val();
     var folding_sets_1         = $("#folding_sets_1").val();
     var binding_sets_1         = (binding_sets_1_pre != '') ? binding_sets_1_pre : '0' ;
     
     var avl_sets_2             = $("#avl_sets_2").val();
     var need_sets_2            = $("#need_sets_2").val();
     var size_sets_2            = $("#size_sets_2").val();
     var output_sets_2          = $("#output_sets_2").val();
     var binding_sets_2_pre     = $("#binding_sets_2").val();
     var binding_sets_2         = (binding_sets_2_pre != '') ? binding_sets_2_pre : '0' ;
     var folding_sets_2         = $("#folding_sets_2").val();
     var date_needed            = $("#date_needed").val();
     var time_needed            = $("#time_picker_icon").val();
     var spl_recipient          = $("#spl_recipient").val();
     var contact_ph             = $("#contact_ph").val();
     
     var shipp_att              = $("#shipp_att").val();
     
     var option_id              =   $("#option_id").val();
     
     var size_custom_details    = (size_sets_1 == 'Custom') ? document.getElementById("size_custom_details").value : '0';
     
     var output_page_details    = (output_sets_1 == 'Both') ? document.getElementById("output_page_details").value : '0';
     
     var preffer_del            = document.getElementById('preffer_del').checked;  
     
     var arrange_del            = document.getElementById('arrange_del').checked;
     var delivery_comp          = (arrange_del == false) ? document.getElementById("delivery_comp").value : '0';
     var bill_number            = (arrange_del == false) ? document.getElementById("bill_number").value : '0';
     if(arrange_del == false)
     {
        var shipp_comp_1        =   document.getElementById('shipp_comp_1').checked;
            var shipp_comp_1_f  =   (shipp_comp_1 == true) ? document.getElementById("shipp_comp_1").value : '0';
        var shipp_comp_2        =   document.getElementById('shipp_comp_2').checked;
            var shipp_comp_2_f  =   (shipp_comp_2 == true) ? document.getElementById("shipp_comp_2").value : '0';
        var shipp_comp_3        =   document.getElementById('shipp_comp_3').checked;
            var shipp_comp_3_f  =   (shipp_comp_3 == true) ? document.getElementById("other_shipp_type").value : '0';
     }else{
            var shipp_comp_1_f  =   '0';
            var shipp_comp_2_f  =   '0';
            var shipp_comp_3_f  =   '0';
     }      
     
     
     if(shipping_id == '0'){
         alert('Please select send to address');
         $("#address_book_rp").focus();
         return false;
     }
     
//     if(shipp_att == ''){
//         alert('Please enter the attention to');
//         $("#shipp_att").focus();
//         return false;
//     }
     
     if(date_needed == ''){
         alert('Please select when needed');
         $("#date_needed").focus();
         return false;
     }
           
     if(preffer_del == true){
        var bill_number = $("#bill_number").val(); 
        if(bill_number ==''){
        alert('Please enter the account number');
        $("#bill_number").focus();
        return false;
        }
    }
     
     $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=9&shipping_id_rec="+encodeURIComponent(shipping_id)+"&avl_sets_1="+encodeURIComponent(avl_sets_1)+"&need_sets_1="+encodeURIComponent(need_sets_1)+"&size_sets_1="+encodeURIComponent(size_sets_1)+"&output_sets_1="+encodeURIComponent(output_sets_1)+"&binding_sets_1="+encodeURIComponent(binding_sets_1)+"&avl_sets_2="+encodeURIComponent(avl_sets_2)+"&need_sets_2="+encodeURIComponent(need_sets_2)+"&size_sets_2="+encodeURIComponent(size_sets_2)+"&output_sets_2="+encodeURIComponent(output_sets_2)+"&binding_sets_2="+encodeURIComponent(binding_sets_2)+"&user_session="+encodeURIComponent(user_session)+"&user_session_comp="+encodeURIComponent(user_session_comp)+"&date_needed="+encodeURIComponent(date_needed)+"&spl_recipient="+encodeURIComponent(spl_recipient)+"&delivery_type="+encodeURIComponent(delivery_comp)+"&bill_number="+encodeURIComponent(bill_number)+"&shipp_comp_1_f="+encodeURIComponent(shipp_comp_1_f)+"&shipp_comp_2_f="+encodeURIComponent(shipp_comp_2_f)+"&shipp_comp_3_f="+encodeURIComponent(shipp_comp_3_f)+"&folding_sets_1="+encodeURIComponent(folding_sets_1)+"&folding_sets_2="+encodeURIComponent(folding_sets_2)+"&time_needed="+encodeURIComponent(time_needed)+"&size_custom_details="+encodeURIComponent(size_custom_details)+"&output_page_details="+encodeURIComponent(output_page_details)+"&attention_to="+encodeURIComponent(shipp_att)+"&media_sets_1="+encodeURIComponent(media_sets_1)+"&contact_ph="+encodeURIComponent(contact_ph)+"&option_id="+encodeURIComponent(option_id),
            beforeSend: loadStart,
            complete: loadStop,
            success: function(option)
            {  
                var element = option.split("~");
                if(element[0] == element[1]){
                window.location = "view_all_recipients.php";  
                }else{
                $('#multi_recipients').slideDown();
                $('#multi_recipients').html(element[2]);
//                $('#remain_options').html(element[3]);
//                $('#add_recipients').slideDown();
                }
            }
        });
 }
 
 
 function add_recipients_dynamic(OPTION_ID,ID){
     
     var pickup_soho_chk        = document.getElementById('pickup_soho').checked;
     var shipping_id_pre        = $("#address_book_rp_"+OPTION_ID).val();
     var shipping_id            = (pickup_soho_chk == true) ? 'P'+shipping_id_pre : shipping_id_pre;
     var user_session           = $("#user_session").val(); 
     var user_session_comp      = $("#user_session_comp").val(); 
     
     var avl_sets_1             = $("#avl_sets_"+OPTION_ID).val();
     var need_sets_1            = $("#need_sets_"+OPTION_ID).val();
     var size_sets_1            = $("#size_sets_1").val();
     var output_sets_1          = $("#output_sets_1").val();
     var media_sets_1           = $("#media_sets_1").val();
     var binding_sets_1_pre     = $("#binding_sets_1").val();
     var folding_sets_1         = $("#folding_sets_1").val();
     var binding_sets_1         = (binding_sets_1_pre != '') ? binding_sets_1_pre : '0' ;
     
     var avl_sets_2             = $("#avl_sets_2").val();
     var need_sets_2            = $("#need_sets_2").val();
     var size_sets_2            = $("#size_sets_2").val();
     var output_sets_2          = $("#output_sets_2").val();
     var binding_sets_2_pre     = $("#binding_sets_2").val();
     var binding_sets_2         = (binding_sets_2_pre != '') ? binding_sets_2_pre : '0' ;
     var folding_sets_2         = $("#folding_sets_2").val();
     var date_needed            = $("#date_needed_"+OPTION_ID).val();
     var time_needed            = $("#time_picker_icon_"+OPTION_ID).val();
     var spl_recipient          = $("#spl_recipient_"+OPTION_ID).val();
     var contact_ph             = $("#contact_ph_"+OPTION_ID).val();
     var option_type            = $("#option_type_"+OPTION_ID).val();
     
     var shipp_att              = $("#shipp_att_"+OPTION_ID).val();
     
     var option_id              =   $("#option_id_"+OPTION_ID).val();
     
     var size_custom_details    = (size_sets_1 == 'Custom') ? document.getElementById("size_custom_details").value : '0';
     
     var output_page_details    = (output_sets_1 == 'Both') ? document.getElementById("output_page_details").value : '0';
     
     var preffer_del            = document.getElementById("preffer_del_"+OPTION_ID).checked;  
     
     var arrange_del            = document.getElementById("arrange_del_"+OPTION_ID).checked;
     
     var delivery_comp          = (arrange_del == false) ? document.getElementById("delivery_comp_"+OPTION_ID).value : '0';
     var bill_number            = (arrange_del == false) ? document.getElementById("bill_number_"+OPTION_ID).value : '0';
     if(arrange_del == false)
     {
        var shipp_comp_1        =   document.getElementById("shipp_comp_1_"+OPTION_ID).checked;
            var shipp_comp_1_f  =   (shipp_comp_1 == true) ? document.getElementById("shipp_comp_1_"+OPTION_ID).value : '0';
        var shipp_comp_2        =   document.getElementById("shipp_comp_2_"+OPTION_ID).checked;
            var shipp_comp_2_f  =   (shipp_comp_2 == true) ? document.getElementById("shipp_comp_2_"+OPTION_ID).value : '0';
        var shipp_comp_3        =   document.getElementById("shipp_comp_3_"+OPTION_ID).checked;
            var shipp_comp_3_f  =   (shipp_comp_3 == true) ? document.getElementById("other_shipp_type_"+OPTION_ID).value : '0';
     }else{
            var shipp_comp_1_f  =   '0';
            var shipp_comp_2_f  =   '0';
            var shipp_comp_3_f  =   '0';
     }          
     
     
     if(shipping_id == '0'){
         alert('Please select send to address');
         $("#address_book_rp").focus();
         return false;
     }
     
//     if(shipp_att == ''){
//         alert('Please enter the attention to');
//         $("#shipp_att").focus();
//         return false;
//     }
     
     if(date_needed == ''){
         alert('Please select when needed');
         $("#date_needed").focus();
         return false;
     }
           
     if(preffer_del == true){
        var bill_number = $("#bill_number_"+OPTION_ID).val(); 
        if(bill_number ==''){
        alert('Please enter the account number');
        $("#bill_number_"+OPTION_ID).focus();
        return false;
        }
    }
     
    if(avl_sets_1 == '1'){
        one_more_set(ID);
        top_order_summary(OPTION_ID);
       // return false;
    }
     $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=22&shipping_id_rec="+encodeURIComponent(shipping_id)+"&avl_sets_1="+encodeURIComponent(avl_sets_1)+"&need_sets_1="+encodeURIComponent(need_sets_1)+"&size_sets_1="+encodeURIComponent(size_sets_1)+"&output_sets_1="+encodeURIComponent(output_sets_1)+"&binding_sets_1="+encodeURIComponent(binding_sets_1)+"&avl_sets_2="+encodeURIComponent(avl_sets_2)+"&need_sets_2="+encodeURIComponent(need_sets_2)+"&size_sets_2="+encodeURIComponent(size_sets_2)+"&output_sets_2="+encodeURIComponent(output_sets_2)+"&binding_sets_2="+encodeURIComponent(binding_sets_2)+"&user_session="+encodeURIComponent(user_session)+"&user_session_comp="+encodeURIComponent(user_session_comp)+"&date_needed="+encodeURIComponent(date_needed)+"&spl_recipient="+encodeURIComponent(spl_recipient)+"&delivery_type="+encodeURIComponent(delivery_comp)+"&bill_number="+encodeURIComponent(bill_number)+"&shipp_comp_1_f="+encodeURIComponent(shipp_comp_1_f)+"&shipp_comp_2_f="+encodeURIComponent(shipp_comp_2_f)+"&shipp_comp_3_f="+encodeURIComponent(shipp_comp_3_f)+"&folding_sets_1="+encodeURIComponent(folding_sets_1)+"&folding_sets_2="+encodeURIComponent(folding_sets_2)+"&time_needed="+encodeURIComponent(time_needed)+"&size_custom_details="+encodeURIComponent(size_custom_details)+"&output_page_details="+encodeURIComponent(output_page_details)+"&attention_to="+encodeURIComponent(shipp_att)+"&media_sets_1="+encodeURIComponent(media_sets_1)+"&contact_ph="+encodeURIComponent(contact_ph)+"&option_id="+encodeURIComponent(option_id)+"&option_type="+encodeURIComponent(option_type),
            beforeSend: loadStart,
            complete: loadStop,
            success: function(option)
            {  
//                var element = option.split("~");
//                if(element[0] == element[1]){
//                window.location = "view_all_recipients.php";  
//                }else{                
//                //$('#optiond_dynamic_'+OPTION_ID).html(element[2]);
//                $('#multi_recipients').slideDown();
//                $('#multi_recipients').html(element[2]);
//                }
                  multiple_recipient_nmjk();
                  
            }
        });
 }
 
 function one_more_set(ID)
 {
     $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=95&one_more_set_id="+encodeURIComponent(ID),
            beforeSend: loadStart,
            complete: loadStop,
            success: function(option)
            {  
                
            }
        });
 }
 
 function add_recipients_dynamic_go_next()
 {
     window.location = "view_all_recipients.php"; 
 }
 
 function add_recipients_dynamic_go_next_jk(OPTION_ID)
 {
     
     var pickup_soho_chk        = document.getElementById('pickup_soho').checked;
     var shipping_id_pre        = $("#address_book_rp_"+OPTION_ID).val();
     var shipping_id            = (pickup_soho_chk == true) ? 'P'+shipping_id_pre : shipping_id_pre;
     var user_session           = $("#user_session").val(); 
     var user_session_comp      = $("#user_session_comp").val(); 
     
     var avl_sets_1             = $("#avl_sets_"+OPTION_ID).val();
     var need_sets_1            = $("#need_sets_"+OPTION_ID).val();
     var size_sets_1            = $("#size_sets_"+OPTION_ID).val();
     var output_sets_1          = $("#output_sets_"+OPTION_ID).val();
     var media_sets_1           = $("#media_sets_"+OPTION_ID).val();
     var binding_sets_1_pre     = $("#binding_sets_"+OPTION_ID).val();
     var folding_sets_1         = $("#folding_sets_"+OPTION_ID).val();
     var binding_sets_1         = (binding_sets_1_pre != '') ? binding_sets_1_pre : '0' ;
     
     var avl_sets_2             = $("#avl_sets_2").val();
     var need_sets_2            = $("#need_sets_2").val();
     var size_sets_2            = $("#size_sets_2").val();
     var output_sets_2          = $("#output_sets_2").val();
     var binding_sets_2_pre     = $("#binding_sets_2").val();
     var binding_sets_2         = (binding_sets_2_pre != '') ? binding_sets_2_pre : '0' ;
     var folding_sets_2         = $("#folding_sets_2").val();
     var date_needed            = $("#date_needed_"+OPTION_ID).val();
     var time_needed            = $("#time_picker_icon_"+OPTION_ID).val();
     var spl_recipient          = $("#spl_recipient_"+OPTION_ID).val();
     var contact_ph             = $("#contact_ph_"+OPTION_ID).val();
     var option_type            = $("#option_type_"+OPTION_ID).val();
     
     var shipp_att              = $("#shipp_att_"+OPTION_ID).val();
     
     var option_id              =   $("#option_id_"+OPTION_ID).val();
     
     var size_custom_details    = (size_sets_1 == 'Custom') ? document.getElementById("size_custom_details").value : '0';
     
     var output_page_details    = (output_sets_1 == 'Both') ? document.getElementById("output_page_details").value : '0';
     
     var preffer_del            = document.getElementById("preffer_del_"+OPTION_ID).checked;  
     
     var arrange_del            = document.getElementById("arrange_del_"+OPTION_ID).checked;
     
     var delivery_comp          = (arrange_del == false) ? document.getElementById("delivery_comp_"+OPTION_ID).value : '0';
     var bill_number            = (arrange_del == false) ? document.getElementById("bill_number_"+OPTION_ID).value : '0';
     if(arrange_del == false)
     {
        var shipp_comp_1        =   document.getElementById("shipp_comp_1_"+OPTION_ID).checked;
            var shipp_comp_1_f  =   (shipp_comp_1 == true) ? document.getElementById("shipp_comp_1_"+OPTION_ID).value : '0';
        var shipp_comp_2        =   document.getElementById("shipp_comp_2_"+OPTION_ID).checked;
            var shipp_comp_2_f  =   (shipp_comp_2 == true) ? document.getElementById("shipp_comp_2_"+OPTION_ID).value : '0';
        var shipp_comp_3        =   document.getElementById("shipp_comp_3_"+OPTION_ID).checked;
            var shipp_comp_3_f  =   (shipp_comp_3 == true) ? document.getElementById("other_shipp_type_"+OPTION_ID).value : '0';
     }else{
            var shipp_comp_1_f  =   '0';
            var shipp_comp_2_f  =   '0';
            var shipp_comp_3_f  =   '0';
     }          
     
     
     if(shipping_id == '0'){
         alert('Please select send to address');
         $("#address_book_rp").focus();
         return false;
     }
     
//     if(shipp_att == ''){
//         alert('Please enter the attention to');
//         $("#shipp_att").focus();
//         return false;
//     }
     
     if(date_needed == ''){
         alert('Please select when needed');
         $("#date_needed").focus();
         return false;
     }
           
     if(preffer_del == true){
        var bill_number = $("#bill_number_"+OPTION_ID).val(); 
        if(bill_number ==''){
        alert('Please enter the account number');
        $("#bill_number_"+OPTION_ID).focus();
        return false;
        }
    }
    
     $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=22&shipping_id_rec="+encodeURIComponent(shipping_id)+"&avl_sets_1="+encodeURIComponent(avl_sets_1)+"&need_sets_1="+encodeURIComponent(need_sets_1)+"&size_sets_1="+encodeURIComponent(size_sets_1)+"&output_sets_1="+encodeURIComponent(output_sets_1)+"&binding_sets_1="+encodeURIComponent(binding_sets_1)+"&avl_sets_2="+encodeURIComponent(avl_sets_2)+"&need_sets_2="+encodeURIComponent(need_sets_2)+"&size_sets_2="+encodeURIComponent(size_sets_2)+"&output_sets_2="+encodeURIComponent(output_sets_2)+"&binding_sets_2="+encodeURIComponent(binding_sets_2)+"&user_session="+encodeURIComponent(user_session)+"&user_session_comp="+encodeURIComponent(user_session_comp)+"&date_needed="+encodeURIComponent(date_needed)+"&spl_recipient="+encodeURIComponent(spl_recipient)+"&delivery_type="+encodeURIComponent(delivery_comp)+"&bill_number="+encodeURIComponent(bill_number)+"&shipp_comp_1_f="+encodeURIComponent(shipp_comp_1_f)+"&shipp_comp_2_f="+encodeURIComponent(shipp_comp_2_f)+"&shipp_comp_3_f="+encodeURIComponent(shipp_comp_3_f)+"&folding_sets_1="+encodeURIComponent(folding_sets_1)+"&folding_sets_2="+encodeURIComponent(folding_sets_2)+"&time_needed="+encodeURIComponent(time_needed)+"&size_custom_details="+encodeURIComponent(size_custom_details)+"&output_page_details="+encodeURIComponent(output_page_details)+"&attention_to="+encodeURIComponent(shipp_att)+"&media_sets_1="+encodeURIComponent(media_sets_1)+"&contact_ph="+encodeURIComponent(contact_ph)+"&option_id="+encodeURIComponent(option_id)+"&option_type="+encodeURIComponent(option_type),
            beforeSend: loadStart,
            complete: loadStop,
            success: function(option)
            {  
//                var element = option.split("~");
//                if(element[0] == element[1]){
//                window.location = "view_all_recipients.php";  
//                }else{                
//                //$('#optiond_dynamic_'+OPTION_ID).html(element[2]);
//                $('#multi_recipients').slideDown();
//                $('#multi_recipients').html(element[2]);
//                }
                  multiple_recipient_nmjk();
                  //top_order_summary(OPTION_ID);
            }
        });
     
 }
 
 function multiple_recipient_nmjk(){
        
    var multi = document.getElementById("del_type_multi").checked;         
     if(multi == true){
		$.ajax
                ({
                    type: "POST",
                    url: "get_recipients.php",
                    data: "recipients=234",
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {  
					var element = option.split("~");
					if(element[0] == element[1]){
					window.location = "view_all_recipients.php";  
					}else{
					$('#multi_recipients').slideDown();
					$('#multi_recipients').html(element[7]);
                                        $("#entered_sets").slideDown();
					$("#entered_sets").html(element[3]);  
                                        
                                        $(".all_are_done").show();    
                                        $(".all_are_done").attr('onclick', 'return add_recipients_dynamic_go_next('+element[2]+');');
					}
				}
                });
	}
 }
 
 function top_order_summary(OPTION_ID)
 {
     var current_sets = $("#available_"+OPTION_ID).html();
     $("#available_"+OPTION_ID).html((Number(current_sets) + 1));
 }
 
 function asap_dynamic(OPTION_ID)
{
    var current_status  =   $("#asap_status_"+OPTION_ID).attr('class');
    var change_status   =   (current_status == "asap_orange") ? 'asap_green' : 'asap_orange';    
    
    var current_dte_neede    = $("#date_needed_"+OPTION_ID).val();
    var current_time_neede   = $("#time_picker_icon_"+OPTION_ID).val();
    var change_date          = (current_dte_neede == 'ASAP') ? '' : 'ASAP';
    var change_time          = (current_time_neede == 'ASAP') ? '' : 'ASAP';
       
    
    if(OPTION_ID != '0'){
        
     var pickup_soho_chk        = document.getElementById('pickup_soho').checked;
     var shipping_id_pre        = $("#address_book_rp_"+OPTION_ID).val();
     var shipping_id            = (pickup_soho_chk == true) ? 'P'+shipping_id_pre : shipping_id_pre;
     var user_session           = $("#user_session").val(); 
     var user_session_comp      = $("#user_session_comp").val(); 
     
     var avl_sets_1             = $("#avl_sets_"+OPTION_ID).val();
     var need_sets_1            = $("#need_sets_"+OPTION_ID).val();
     var size_sets_1            = $("#size_sets_"+OPTION_ID).val();
     var output_sets_1          = $("#output_sets_"+OPTION_ID).val();
     var media_sets_1           = $("#media_sets_"+OPTION_ID).val();
     var binding_sets_1_pre     = $("#binding_sets_"+OPTION_ID).val();
     var folding_sets_1         = $("#folding_sets_"+OPTION_ID).val();
     var binding_sets_1         = (binding_sets_1_pre != '') ? binding_sets_1_pre : '0' ;
     
     var avl_sets_2             = $("#avl_sets_2").val();
     var need_sets_2            = $("#need_sets_2").val();
     var size_sets_2            = $("#size_sets_2").val();
     var output_sets_2          = $("#output_sets_2").val();
     var binding_sets_2_pre     = $("#binding_sets_2").val();
     var binding_sets_2         = (binding_sets_2_pre != '') ? binding_sets_2_pre : '0' ;
     var folding_sets_2         = $("#folding_sets_2").val();
     var date_needed            = $("#date_needed_"+OPTION_ID).val();
     var time_needed            = $("#time_picker_icon_"+OPTION_ID).val();
     var spl_recipient          = $("#spl_recipient_"+OPTION_ID).val();
     var contact_ph             = $("#contact_ph_"+OPTION_ID).val();
     var option_type            = $("#option_type_"+OPTION_ID).val();
     
     var shipp_att              = $("#shipp_att_"+OPTION_ID).val();
     
     var option_id              =   $("#option_id_"+OPTION_ID).val();
     
     var size_custom_details    = (size_sets_1 == 'Custom') ? document.getElementById("size_custom_details").value : '0';
     
     var output_page_details    = (output_sets_1 == 'Both') ? document.getElementById("output_page_details").value : '0';
     
     //var preffer_del            = document.getElementById("preffer_del_"+OPTION_ID).checked;  
     
     var arrange_del            = document.getElementById("arrange_del_"+OPTION_ID).checked;
     
     var delivery_comp          = (arrange_del == false) ? document.getElementById("delivery_comp_"+OPTION_ID).value : '0';
     var bill_number            = (arrange_del == false) ? document.getElementById("bill_number_"+OPTION_ID).value : '0';
     if(arrange_del == false)
     {
        var shipp_comp_1        =   document.getElementById("shipp_comp_1_"+OPTION_ID).checked;
            var shipp_comp_1_f  =   (shipp_comp_1 == true) ? document.getElementById("shipp_comp_1_"+OPTION_ID).value : '0';
        var shipp_comp_2        =   document.getElementById("shipp_comp_2_"+OPTION_ID).checked;
            var shipp_comp_2_f  =   (shipp_comp_2 == true) ? document.getElementById("shipp_comp_2_"+OPTION_ID).value : '0';
        var shipp_comp_3        =   document.getElementById("shipp_comp_3_"+OPTION_ID).checked;
            var shipp_comp_3_f  =   (shipp_comp_3 == true) ? document.getElementById("other_shipp_type_"+OPTION_ID).value : '0';
     }else{
            var shipp_comp_1_f  =   '0';
            var shipp_comp_2_f  =   '0';
            var shipp_comp_3_f  =   '0';
     }      
     
     $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=31&shipping_id_rec="+encodeURIComponent(shipping_id)+"&avl_sets_1="+encodeURIComponent(avl_sets_1)+"&need_sets_1="+encodeURIComponent(need_sets_1)+"&size_sets_1="+encodeURIComponent(size_sets_1)+"&output_sets_1="+encodeURIComponent(output_sets_1)+"&binding_sets_1="+encodeURIComponent(binding_sets_1)+"&avl_sets_2="+encodeURIComponent(avl_sets_2)+"&need_sets_2="+encodeURIComponent(need_sets_2)+"&size_sets_2="+encodeURIComponent(size_sets_2)+"&output_sets_2="+encodeURIComponent(output_sets_2)+"&binding_sets_2="+encodeURIComponent(binding_sets_2)+"&user_session="+encodeURIComponent(user_session)+"&user_session_comp="+encodeURIComponent(user_session_comp)+"&date_needed="+encodeURIComponent(date_needed)+"&spl_recipient="+encodeURIComponent(spl_recipient)+"&delivery_type="+encodeURIComponent(delivery_comp)+"&bill_number="+encodeURIComponent(bill_number)+"&shipp_comp_1_f="+encodeURIComponent(shipp_comp_1_f)+"&shipp_comp_2_f="+encodeURIComponent(shipp_comp_2_f)+"&shipp_comp_3_f="+encodeURIComponent(shipp_comp_3_f)+"&folding_sets_1="+encodeURIComponent(folding_sets_1)+"&folding_sets_2="+encodeURIComponent(folding_sets_2)+"&time_needed="+encodeURIComponent(time_needed)+"&size_custom_details="+encodeURIComponent(size_custom_details)+"&output_page_details="+encodeURIComponent(output_page_details)+"&attention_to="+encodeURIComponent(shipp_att)+"&media_sets_1="+encodeURIComponent(media_sets_1)+"&contact_ph="+encodeURIComponent(contact_ph)+"&option_id="+encodeURIComponent(option_id)+"&option_type="+encodeURIComponent(option_type),           
            success: function(option)
            {  
                //console.log('Added Previous!!!');
                $("#asap_status_"+OPTION_ID).removeClass(current_status);
                $("#asap_status_"+OPTION_ID).addClass(change_status);
                
                $("#date_needed_"+OPTION_ID).val(change_date);
                $("#time_picker_icon_"+OPTION_ID).val(change_time);
                
            }
        });
            
        }else{
            //console.log('Mohamed')
        }

}
 
 function update_current_option(OPTION_ID){
  
     var pickup_soho_chk        = document.getElementById('pickup_soho').checked;
     var shipping_id_pre        = $("#address_book_rp_"+OPTION_ID).val();
     var shipping_id            = (pickup_soho_chk == true) ? 'P'+shipping_id_pre : shipping_id_pre;
     var user_session           = $("#user_session").val(); 
     var user_session_comp      = $("#user_session_comp").val(); 
     
     var avl_sets_1             = $("#avl_sets_"+OPTION_ID).val();
     var need_sets_1            = $("#need_sets_"+OPTION_ID).val();
     var size_sets_1            = $("#size_sets_"+OPTION_ID).val();
     var output_sets_1          = $("#output_sets_"+OPTION_ID).val();
     var media_sets_1           = $("#media_sets_"+OPTION_ID).val();
     var binding_sets_1_pre     = $("#binding_sets_"+OPTION_ID).val();
     var folding_sets_1         = $("#folding_sets_"+OPTION_ID).val();
     var binding_sets_1         = (binding_sets_1_pre != '') ? binding_sets_1_pre : '0' ;
     
     var avl_sets_2             = $("#avl_sets_2").val();
     var need_sets_2            = $("#need_sets_2").val();
     var size_sets_2            = $("#size_sets_2").val();
     var output_sets_2          = $("#output_sets_2").val();
     var binding_sets_2_pre     = $("#binding_sets_2").val();
     var binding_sets_2         = (binding_sets_2_pre != '') ? binding_sets_2_pre : '0' ;
     var folding_sets_2         = $("#folding_sets_2").val();
     var date_needed            = $("#date_needed_"+OPTION_ID).val();
     var time_needed            = $("#time_picker_icon_"+OPTION_ID).val();
     var spl_recipient          = $("#spl_recipient_"+OPTION_ID).val();
     var contact_ph             = $("#contact_ph_"+OPTION_ID).val();
     var option_type            = $("#option_type_"+OPTION_ID).val();
     
     var shipp_att              = $("#shipp_att_"+OPTION_ID).val();
     
     var option_id              =   $("#option_id_"+OPTION_ID).val();
     
     var size_custom_details    = (size_sets_1 == 'Custom') ? document.getElementById("size_custom_details").value : '0';
     
     var output_page_details    = (output_sets_1 == 'Both') ? document.getElementById("output_page_details").value : '0';
     
     //var preffer_del            = document.getElementById("preffer_del_"+OPTION_ID).checked;  
     
     var arrange_del            = document.getElementById("arrange_del_"+OPTION_ID).checked;
     
     var delivery_comp          = (arrange_del == false) ? document.getElementById("delivery_comp_"+OPTION_ID).value : '0';
     var bill_number            = (arrange_del == false) ? document.getElementById("bill_number_"+OPTION_ID).value : '0';
     if(arrange_del == false)
     {
        var shipp_comp_1        =   document.getElementById("shipp_comp_1_"+OPTION_ID).checked;
            var shipp_comp_1_f  =   (shipp_comp_1 == true) ? document.getElementById("shipp_comp_1_"+OPTION_ID).value : '0';
        var shipp_comp_2        =   document.getElementById("shipp_comp_2_"+OPTION_ID).checked;
            var shipp_comp_2_f  =   (shipp_comp_2 == true) ? document.getElementById("shipp_comp_2_"+OPTION_ID).value : '0';
        var shipp_comp_3        =   document.getElementById("shipp_comp_3_"+OPTION_ID).checked;
            var shipp_comp_3_f  =   (shipp_comp_3 == true) ? document.getElementById("other_shipp_type_"+OPTION_ID).value : '0';
     }else{
            var shipp_comp_1_f  =   '0';
            var shipp_comp_2_f  =   '0';
            var shipp_comp_3_f  =   '0';
     } 
     
      $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=40&shipping_id_rec="+encodeURIComponent(shipping_id)+"&avl_sets_1="+encodeURIComponent(avl_sets_1)+"&need_sets_1="+encodeURIComponent(need_sets_1)+"&size_sets_1="+encodeURIComponent(size_sets_1)+"&output_sets_1="+encodeURIComponent(output_sets_1)+"&binding_sets_1="+encodeURIComponent(binding_sets_1)+"&avl_sets_2="+encodeURIComponent(avl_sets_2)+"&need_sets_2="+encodeURIComponent(need_sets_2)+"&size_sets_2="+encodeURIComponent(size_sets_2)+"&output_sets_2="+encodeURIComponent(output_sets_2)+"&binding_sets_2="+encodeURIComponent(binding_sets_2)+"&user_session="+encodeURIComponent(user_session)+"&user_session_comp="+encodeURIComponent(user_session_comp)+"&date_needed="+encodeURIComponent(date_needed)+"&spl_recipient="+encodeURIComponent(spl_recipient)+"&delivery_type="+encodeURIComponent(delivery_comp)+"&bill_number="+encodeURIComponent(bill_number)+"&shipp_comp_1_f="+encodeURIComponent(shipp_comp_1_f)+"&shipp_comp_2_f="+encodeURIComponent(shipp_comp_2_f)+"&shipp_comp_3_f="+encodeURIComponent(shipp_comp_3_f)+"&folding_sets_1="+encodeURIComponent(folding_sets_1)+"&folding_sets_2="+encodeURIComponent(folding_sets_2)+"&time_needed="+encodeURIComponent(time_needed)+"&size_custom_details="+encodeURIComponent(size_custom_details)+"&output_page_details="+encodeURIComponent(output_page_details)+"&attention_to="+encodeURIComponent(shipp_att)+"&media_sets_1="+encodeURIComponent(media_sets_1)+"&contact_ph="+encodeURIComponent(contact_ph)+"&option_id="+encodeURIComponent(option_id)+"&option_type="+encodeURIComponent(option_type),           
            success: function(option)
            {  
                //console.log('Added Previous!!!');  
            }
        });
 }
 
 
 
 function update_current_option_jk(OPTION_ID)
 {
     if(OPTION_ID != '0'){
        
     var pickup_soho_chk        = document.getElementById('pickup_soho').checked;
     var shipping_id_pre        = $("#address_book_rp_"+OPTION_ID).val();
     var shipping_id            = (pickup_soho_chk == true) ? 'P'+shipping_id_pre : shipping_id_pre;
     var user_session           = $("#user_session").val(); 
     var user_session_comp      = $("#user_session_comp").val(); 
     
     var avl_sets_1             = $("#avl_sets_"+OPTION_ID).val();
     var need_sets_1            = $("#need_sets_"+OPTION_ID).val();
     var size_sets_1            = $("#size_sets_"+OPTION_ID).val();
     var output_sets_1          = $("#output_sets_"+OPTION_ID).val();
     var media_sets_1           = $("#media_sets_"+OPTION_ID).val();
     var binding_sets_1_pre     = $("#binding_sets_"+OPTION_ID).val();
     var folding_sets_1         = $("#folding_sets_"+OPTION_ID).val();
     var binding_sets_1         = (binding_sets_1_pre != '') ? binding_sets_1_pre : '0' ;
     
     var avl_sets_2             = $("#avl_sets_2").val();
     var need_sets_2            = $("#need_sets_2").val();
     var size_sets_2            = $("#size_sets_2").val();
     var output_sets_2          = $("#output_sets_2").val();
     var binding_sets_2_pre     = $("#binding_sets_2").val();
     var binding_sets_2         = (binding_sets_2_pre != '') ? binding_sets_2_pre : '0' ;
     var folding_sets_2         = $("#folding_sets_2").val();
     var date_needed            = $("#date_needed_"+OPTION_ID).val();
     var time_needed            = $("#time_picker_icon_"+OPTION_ID).val();
     var spl_recipient          = $("#spl_recipient_"+OPTION_ID).val();
     var contact_ph             = $("#contact_ph_"+OPTION_ID).val();
     var option_type            = $("#option_type_"+OPTION_ID).val();
     
     var shipp_att              = $("#shipp_att_"+OPTION_ID).val();
     
     var option_id              =   $("#option_id_"+OPTION_ID).val();
     
     var size_custom_details    = (size_sets_1 == 'Custom') ? document.getElementById("size_custom_details").value : '0';
     
     var output_page_details    = (output_sets_1 == 'Both') ? document.getElementById("output_page_details").value : '0';
     
     //var preffer_del            = document.getElementById("preffer_del_"+OPTION_ID).checked;  
     
     var arrange_del            = document.getElementById("arrange_del_"+OPTION_ID).checked;
     
     var delivery_comp          = (arrange_del == false) ? document.getElementById("delivery_comp_"+OPTION_ID).value : '0';
     var bill_number            = (arrange_del == false) ? document.getElementById("bill_number_"+OPTION_ID).value : '0';
     if(arrange_del == false)
     {
        var shipp_comp_1        =   document.getElementById("shipp_comp_1_"+OPTION_ID).checked;
            var shipp_comp_1_f  =   (shipp_comp_1 == true) ? document.getElementById("shipp_comp_1_"+OPTION_ID).value : '0';
        var shipp_comp_2        =   document.getElementById("shipp_comp_2_"+OPTION_ID).checked;
            var shipp_comp_2_f  =   (shipp_comp_2 == true) ? document.getElementById("shipp_comp_2_"+OPTION_ID).value : '0';
        var shipp_comp_3        =   document.getElementById("shipp_comp_3_"+OPTION_ID).checked;
            var shipp_comp_3_f  =   (shipp_comp_3 == true) ? document.getElementById("other_shipp_type_"+OPTION_ID).value : '0';
     }else{
            var shipp_comp_1_f  =   '0';
            var shipp_comp_2_f  =   '0';
            var shipp_comp_3_f  =   '0';
     }      
     
     $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=31&shipping_id_rec="+encodeURIComponent(shipping_id)+"&avl_sets_1="+encodeURIComponent(avl_sets_1)+"&need_sets_1="+encodeURIComponent(need_sets_1)+"&size_sets_1="+encodeURIComponent(size_sets_1)+"&output_sets_1="+encodeURIComponent(output_sets_1)+"&binding_sets_1="+encodeURIComponent(binding_sets_1)+"&avl_sets_2="+encodeURIComponent(avl_sets_2)+"&need_sets_2="+encodeURIComponent(need_sets_2)+"&size_sets_2="+encodeURIComponent(size_sets_2)+"&output_sets_2="+encodeURIComponent(output_sets_2)+"&binding_sets_2="+encodeURIComponent(binding_sets_2)+"&user_session="+encodeURIComponent(user_session)+"&user_session_comp="+encodeURIComponent(user_session_comp)+"&date_needed="+encodeURIComponent(date_needed)+"&spl_recipient="+encodeURIComponent(spl_recipient)+"&delivery_type="+encodeURIComponent(delivery_comp)+"&bill_number="+encodeURIComponent(bill_number)+"&shipp_comp_1_f="+encodeURIComponent(shipp_comp_1_f)+"&shipp_comp_2_f="+encodeURIComponent(shipp_comp_2_f)+"&shipp_comp_3_f="+encodeURIComponent(shipp_comp_3_f)+"&folding_sets_1="+encodeURIComponent(folding_sets_1)+"&folding_sets_2="+encodeURIComponent(folding_sets_2)+"&time_needed="+encodeURIComponent(time_needed)+"&size_custom_details="+encodeURIComponent(size_custom_details)+"&output_page_details="+encodeURIComponent(output_page_details)+"&attention_to="+encodeURIComponent(shipp_att)+"&media_sets_1="+encodeURIComponent(media_sets_1)+"&contact_ph="+encodeURIComponent(contact_ph)+"&option_id="+encodeURIComponent(option_id)+"&option_type="+encodeURIComponent(option_type),           
            success: function(option)
            {  
                //console.log('Added Previous!!!');
//                $("#asap_status_"+OPTION_ID).removeClass(current_status);
//                $("#asap_status_"+OPTION_ID).addClass(change_status);
//                
//                $("#date_needed_"+OPTION_ID).val(change_date);
//                $("#time_picker_icon_"+OPTION_ID).val(change_time);
                
            }
        });
            
        }else{
            //console.log('Mohamed')
        }
 }
 
 
 
 function add_prvious_dis(OPTION_ID){
     
     if(OPTION_ID != '0'){
        
     var pickup_soho_chk        = document.getElementById('pickup_soho').checked;
     var shipping_id_pre        = $("#address_book_rp_"+OPTION_ID).val();
     var shipping_id            = (pickup_soho_chk == true) ? 'P'+shipping_id_pre : shipping_id_pre;
     var user_session           = $("#user_session").val(); 
     var user_session_comp      = $("#user_session_comp").val(); 
     
     var avl_sets_1             = $("#avl_sets_"+OPTION_ID).val();
     var need_sets_1            = $("#need_sets_"+OPTION_ID).val();
     var size_sets_1            = $("#size_sets_1").val();
     var output_sets_1          = $("#output_sets_1").val();
     var media_sets_1           = $("#media_sets_1").val();
     var binding_sets_1_pre     = $("#binding_sets_1").val();
     var folding_sets_1         = $("#folding_sets_1").val();
     var binding_sets_1         = (binding_sets_1_pre != '') ? binding_sets_1_pre : '0' ;
     
     var avl_sets_2             = $("#avl_sets_2").val();
     var need_sets_2            = $("#need_sets_2").val();
     var size_sets_2            = $("#size_sets_2").val();
     var output_sets_2          = $("#output_sets_2").val();
     var binding_sets_2_pre     = $("#binding_sets_2").val();
     var binding_sets_2         = (binding_sets_2_pre != '') ? binding_sets_2_pre : '0' ;
     var folding_sets_2         = $("#folding_sets_2").val();
     var date_needed            = $("#date_needed_"+OPTION_ID).val();
     var time_needed            = $("#time_picker_icon_"+OPTION_ID).val();
     var spl_recipient          = $("#spl_recipient_"+OPTION_ID).val();
     var contact_ph             = $("#contact_ph_"+OPTION_ID).val();
     var option_type            = $("#option_type_"+OPTION_ID).val();
     
     var shipp_att              = $("#shipp_att_"+OPTION_ID).val();
     
     var option_id              =   $("#option_id_"+OPTION_ID).val();
     
     var size_custom_details    = (size_sets_1 == 'Custom') ? document.getElementById("size_custom_details").value : '0';
     
     var output_page_details    = (output_sets_1 == 'Both') ? document.getElementById("output_page_details").value : '0';
     
     //var preffer_del            = document.getElementById("preffer_del_"+OPTION_ID).checked;  
     
     var arrange_del            = document.getElementById("arrange_del_"+OPTION_ID).checked;
     
     var delivery_comp          = (arrange_del == false) ? document.getElementById("delivery_comp_"+OPTION_ID).value : '0';
     var bill_number            = (arrange_del == false) ? document.getElementById("bill_number_"+OPTION_ID).value : '0';
     if(arrange_del == false)
     {
        var shipp_comp_1        =   document.getElementById("shipp_comp_1_"+OPTION_ID).checked;
            var shipp_comp_1_f  =   (shipp_comp_1 == true) ? document.getElementById("shipp_comp_1_"+OPTION_ID).value : '0';
        var shipp_comp_2        =   document.getElementById("shipp_comp_2_"+OPTION_ID).checked;
            var shipp_comp_2_f  =   (shipp_comp_2 == true) ? document.getElementById("shipp_comp_2_"+OPTION_ID).value : '0';
        var shipp_comp_3        =   document.getElementById("shipp_comp_3_"+OPTION_ID).checked;
            var shipp_comp_3_f  =   (shipp_comp_3 == true) ? document.getElementById("other_shipp_type_"+OPTION_ID).value : '0';
     }else{
            var shipp_comp_1_f  =   '0';
            var shipp_comp_2_f  =   '0';
            var shipp_comp_3_f  =   '0';
     }      
     
     $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=31&shipping_id_rec="+encodeURIComponent(shipping_id)+"&avl_sets_1="+encodeURIComponent(avl_sets_1)+"&need_sets_1="+encodeURIComponent(need_sets_1)+"&size_sets_1="+encodeURIComponent(size_sets_1)+"&output_sets_1="+encodeURIComponent(output_sets_1)+"&binding_sets_1="+encodeURIComponent(binding_sets_1)+"&avl_sets_2="+encodeURIComponent(avl_sets_2)+"&need_sets_2="+encodeURIComponent(need_sets_2)+"&size_sets_2="+encodeURIComponent(size_sets_2)+"&output_sets_2="+encodeURIComponent(output_sets_2)+"&binding_sets_2="+encodeURIComponent(binding_sets_2)+"&user_session="+encodeURIComponent(user_session)+"&user_session_comp="+encodeURIComponent(user_session_comp)+"&date_needed="+encodeURIComponent(date_needed)+"&spl_recipient="+encodeURIComponent(spl_recipient)+"&delivery_type="+encodeURIComponent(delivery_comp)+"&bill_number="+encodeURIComponent(bill_number)+"&shipp_comp_1_f="+encodeURIComponent(shipp_comp_1_f)+"&shipp_comp_2_f="+encodeURIComponent(shipp_comp_2_f)+"&shipp_comp_3_f="+encodeURIComponent(shipp_comp_3_f)+"&folding_sets_1="+encodeURIComponent(folding_sets_1)+"&folding_sets_2="+encodeURIComponent(folding_sets_2)+"&time_needed="+encodeURIComponent(time_needed)+"&size_custom_details="+encodeURIComponent(size_custom_details)+"&output_page_details="+encodeURIComponent(output_page_details)+"&attention_to="+encodeURIComponent(shipp_att)+"&media_sets_1="+encodeURIComponent(media_sets_1)+"&contact_ph="+encodeURIComponent(contact_ph)+"&option_id="+encodeURIComponent(option_id)+"&option_type="+encodeURIComponent(option_type),           
            success: function(option)
            {  
                console.log('Added Previous!!!');
            }
        });
            
        }else{
            //console.log('Mohamed')
        }
 }
 
 function continue_recipient(){
     
     var pickup_soho_chk        = document.getElementById('pickup_soho').checked;
     var shipping_id_pre        = $("#address_book_rp").val();
     var shipping_id            = (pickup_soho_chk == true) ? 'P'+shipping_id_pre : shipping_id_pre;
     var user_session           = $("#user_session").val(); 
     var user_session_comp      = $("#user_session_comp").val(); 
     
     var avl_sets_1             = $("#avl_sets_1").val();
     var need_sets_1            = $("#need_sets_1").val();
     var size_sets_1            = $("#size_sets_1").val();
     var output_sets_1          = $("#output_sets_1").val();
     var media_sets_1           = $("#media_sets_1").val();
     var binding_sets_1_pre     = $("#binding_sets_1").val();
     var folding_sets_1         = $("#folding_sets_1").val();
     var binding_sets_1         = (binding_sets_1_pre != '') ? binding_sets_1_pre : '0' ;
     
     var avl_sets_2             = $("#avl_sets_2").val();
     var need_sets_2            = $("#need_sets_2").val();
     var size_sets_2            = $("#size_sets_2").val();
     var output_sets_2          = $("#output_sets_2").val();
     var binding_sets_2_pre     = $("#binding_sets_2").val();
     var binding_sets_2         = (binding_sets_2_pre != '') ? binding_sets_2_pre : '0' ;
     var folding_sets_2         = $("#folding_sets_2").val();
     var media_sets_2           = $("#media_sets_2").val();
     var date_needed            = $("#date_needed").val();
     var time_needed            = $("#time_picker_icon").val();
     var spl_recipient          = $("#spl_recipient").val();
     
     var shipp_att              = $("#shipp_att").val();
     var contact_ph             = $("#contact_ph").val();
     
     var size_custom_details    = (size_sets_1 == 'Custom') ? document.getElementById("size_custom_details").value : '0';
     
     var output_page_details    = (output_sets_1 == 'Both') ? document.getElementById("output_page_details").value : '0';
     
     var need_sets              =   $(".need_sets").val();
     var avl_sets               =   $(".avl_sets").val();
     var arch_exist             =   $("#arch_exist").val();     
    
     var tot_avl_options        =   $("#tot_avl_options").val();
     var rem_avl_options        =   $("#rem_avl_options").val();
     
     var option_id              =   $("#option_id").val();
     
     var preffer_del            = document.getElementById('preffer_del').checked;  
         
     var arrange_del            = document.getElementById('arrange_del').checked;
     var delivery_comp          = (arrange_del == false) ? document.getElementById("delivery_comp").value : '0';
     var bill_number            = (arrange_del == false) ? document.getElementById("bill_number").value : '0';
     if(arrange_del == false)
     {
        var shipp_comp_1        =   document.getElementById('shipp_comp_1').checked;
            var shipp_comp_1_f  =   (shipp_comp_1 == true) ? document.getElementById("shipp_comp_1").value : '0';
        var shipp_comp_2        =   document.getElementById('shipp_comp_2').checked;
            var shipp_comp_2_f  =   (shipp_comp_2 == true) ? document.getElementById("shipp_comp_2").value : '0';
        var shipp_comp_3        =   document.getElementById('shipp_comp_3').checked;
            var shipp_comp_3_f  =   (shipp_comp_3 == true) ? document.getElementById("other_shipp_type").value : '0';
     }else{
            var shipp_comp_1_f  =   '0';
            var shipp_comp_2_f  =   '0';
            var shipp_comp_3_f  =   '0';
     }      
     
     //alert(tot_avl_options+' '+rem_avl_options);
     if(shipping_id == '0'){
         alert('Please select send to address');
         $("#address_book_rp").focus();
         return false;
     }
     
//      if(shipp_att == ''){
//         alert('Please enter the attention to');
//         $("#shipp_att").focus();
//         return false;
//     }
     
     if(date_needed == ''){
         alert('Please select when needed');
         $("#date_needed").focus();
         return false;
     }
     
     if(need_sets != avl_sets){
         add_recipients();
         return false;
     }
     
     if(tot_avl_options != rem_avl_options){       
         add_recipients();
         return false;
     }else{
         return true;
     }
     
     if(preffer_del == true){
        var bill_number = $("#bill_number").val(); 
        if(bill_number ==''){
        alert('Please enter the account number');
        $("#bill_number").focus();
        return false;
        }
    }
     
     $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=9&shipping_id_rec="+encodeURIComponent(shipping_id)+"&avl_sets_1="+encodeURIComponent(avl_sets_1)+"&need_sets_1="+encodeURIComponent(need_sets_1)+"&size_sets_1="+encodeURIComponent(size_sets_1)+"&output_sets_1="+encodeURIComponent(output_sets_1)+"&binding_sets_1="+encodeURIComponent(binding_sets_1)+"&avl_sets_2="+encodeURIComponent(avl_sets_2)+"&need_sets_2="+encodeURIComponent(need_sets_2)+"&size_sets_2="+encodeURIComponent(size_sets_2)+"&output_sets_2="+encodeURIComponent(output_sets_2)+"&binding_sets_2="+encodeURIComponent(binding_sets_2)+"&user_session="+encodeURIComponent(user_session)+"&user_session_comp="+encodeURIComponent(user_session_comp)+"&date_needed="+encodeURIComponent(date_needed)+"&spl_recipient="+encodeURIComponent(spl_recipient)+"&delivery_type="+encodeURIComponent(delivery_comp)+"&bill_number="+encodeURIComponent(bill_number)+"&shipp_comp_1_f="+encodeURIComponent(shipp_comp_1_f)+"&shipp_comp_2_f="+encodeURIComponent(shipp_comp_2_f)+"&shipp_comp_3_f="+encodeURIComponent(shipp_comp_3_f)+"&folding_sets_1="+encodeURIComponent(folding_sets_1)+"&folding_sets_2="+encodeURIComponent(folding_sets_2)+"&time_needed="+encodeURIComponent(time_needed)+"&size_custom_details="+encodeURIComponent(size_custom_details)+"&output_page_details="+encodeURIComponent(output_page_details)+"&attention_to="+encodeURIComponent(shipp_att)+"&media_sets_1="+encodeURIComponent(media_sets_1)+"&contact_ph="+encodeURIComponent(contact_ph)+"&option_id="+encodeURIComponent(option_id),
            beforeSend: loadStart,
            complete: loadStop,
            success: function(option)
            {  
                window.location = "view_all_recipients.php";
            }
        });
 }
 
 
 
 function increase_qty(ID){
     
     var need_sets      =   $("#need_sets_"+ID).val();
     var avl_sets       =   $("#avl_sets_"+ID).val();
     
        need_sets++;
        if(need_sets <= avl_sets){
        $('#need_sets_'+ID).val(need_sets);
        }
 }
 
  function increase_qty_dy(OPTION_ID){
     
     var need_sets      =   $("#need_sets_"+OPTION_ID).val();
     var avl_sets       =   $("#avl_sets_"+OPTION_ID).val();
     
        need_sets++;
        if(need_sets <= avl_sets){
        $('#need_sets_'+OPTION_ID).val(need_sets);
        }
 }
 
 function decrease_qty_dy(ID)
 {
     var need_sets      =   $("#need_sets_"+ID).val();
     var avl_sets       =   $("#avl_sets_"+ID).val();
     
        need_sets--;
        if(need_sets != '0')
        {
        $('#need_sets_'+ID).val(need_sets);
        }
 }
 
 
 function decrease_qty_return(ID)
 {
     var need_sets      =   $("#need_sets_"+ID).val();
     var avl_sets       =   $("#avl_sets_"+ID).val();
     
        need_sets--;
        if(need_sets != '0')
        {
        $('#need_sets_'+ID).val(need_sets);
        }
 }
 
 function increase_qty_avl(ID,USR_ID,COMP_ID,TYPE,REC_ID)
{   
    var avl_sets       =   $("#avl_sets_"+ID).val();
    var need_sets_1    =   $("#need_sets_1").val();
    var need_sets_2    =   $("#need_sets_2").val();
    avl_sets++;
    if(avl_sets != '0'){    
        $('#avl_sets_'+ID).val(avl_sets);
        $.ajax
            ({
                type: "POST",
                url: "get_recipients.php",
                data: "recipients=5&inc_avl_user_id="+USR_ID+"&inc_avl_comp_id="+COMP_ID+"&inc_avl_type="+TYPE+"&inc_avl_rec_id="+REC_ID+"&need_sets_current_1="+need_sets_1+"&need_sets_current_2="+need_sets_2+"&need_sets_avl_sets="+avl_sets,
                success: function(option)
                {                    
                    $('#sets_grid_new').html(option);                             
                }
            });
    }
}
 
 function increase_qty_avl_copies(ID,USR_ID,COMP_ID,TYPE)
 {
     var avl_sets       =   $("#avl_sets_"+ID).val();
    avl_sets++;
    if(avl_sets != '0'){    
        $('#avl_sets_'+ID).val(avl_sets);
        $.ajax
            ({
                type: "POST",
                url: "get_recipients.php",
                data: "recipients=55&inc_avl_user_id="+USR_ID+"&inc_avl_comp_id="+COMP_ID+"&inc_avl_type="+TYPE,
                success: function(option)
                {                    
                    $('#sets_grid_new').html(option);                             
                }
            });
    }
 }
 
 function increase_qty_avl_plot(ID,USR_ID,COMP_ID,TYPE,OPTION_ID)
 {
     var avl_sets       =   $("#avl_sets_"+OPTION_ID).val();
    avl_sets++;
    if(avl_sets != '0'){    
        $('#avl_sets_'+ID).val(avl_sets);
        $.ajax
            ({
                type: "POST",
                url: "get_recipients.php",
                data: "recipients=55&inc_avl_user_id="+USR_ID+"&inc_avl_comp_id="+COMP_ID+"&inc_avl_type="+TYPE+"&option_id="+OPTION_ID+"&available_sets="+avl_sets,
                success: function(option)
                {                    
                    //$('#sets_grid_new').html(option); 
                    $("#avl_sets_"+OPTION_ID).val(avl_sets);
                    $("#available_"+OPTION_ID).html(avl_sets);
                }
            });
    }
     
 }
 
 function decrease_qty_avl(ID,USR_ID,COMP_ID,TYPE,REC_ID,OPTION_ID)
 {
     var avl_sets       =   $("#avl_sets_"+OPTION_ID).val();
     var need_sets_1    =   $("#need_sets_1").val();
     var need_sets_2    =   $("#need_sets_2").val();
     
        avl_sets--;
        if(avl_sets != '0')
        {
            $('#avl_sets_'+ID).val(avl_sets);
            $.ajax
            ({
                type: "POST",
                url: "get_recipients.php",
                data: "recipients=4&inc_avl_user_id="+USR_ID+"&inc_avl_comp_id="+COMP_ID+"&inc_avl_type="+TYPE+"&inc_avl_rec_id="+REC_ID+"&need_sets_current_1="+need_sets_1+"&need_sets_current_2="+need_sets_2+"&decrese_avl_sets="+avl_sets+"&option_id="+OPTION_ID,
                success: function(option)
                {                    
                    //$('#sets_grid_new').html(option); 
                    $("#avl_sets_"+OPTION_ID).val(avl_sets);
                    $("#available_"+OPTION_ID).html(avl_sets);
                }
            });
        
        }
 }
 
 function delete_recipient(ID)
 {  
    var are_you_sure           = confirm("Are you sure.");    
    var user_session           = $("#user_session").val(); 
    var user_session_comp      = $("#user_session_comp").val(); 
     
    if(are_you_sure == true){
    $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=8&delete_rec_id="+encodeURIComponent(ID)+"&user_session="+encodeURIComponent(user_session)+"&user_session_comp="+encodeURIComponent(user_session_comp),
            beforeSend: loadStart,
            complete: loadStop,
            success: function(option)
            {  
                $('#multi_recipients').slideDown();
                $('#multi_recipients').html(option);
                $('#add_recipients').slideDown();
            }
        });
    }
 } 
 
 function edit_recipient(ID)
 {    
    var are_you_sure           = confirm("Are you sure.");    
    var user_session           = $("#user_session").val(); 
    var user_session_comp      = $("#user_session_comp").val(); 
     
    if(are_you_sure == true){
    $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=7&edit_rec_id="+encodeURIComponent(ID)+"&user_session="+encodeURIComponent(user_session)+"&user_session_comp="+encodeURIComponent(user_session_comp),
            beforeSend: loadStart,
            complete: loadStop,
            success: function(option)
            {  
                $('#multi_recipients').slideDown();
                $('#multi_recipients').html(option);
                $('#add_recipients').slideDown();
            }
        });
    }
 }
 
 
 function edit_recipient_dynamic(ID)
 {
     //alert(ID+"_EDIT");
     $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=501&edit_rec_id="+encodeURIComponent(ID),
            beforeSend: loadStart,
            complete: loadStop,
            success: function(option)
            {  
                //$('#multi_recipients').slideDown();
                $('#dynamic_edit_'+ID).html(option);
                //$('#add_recipients').slideDown();
            }
        });
 }
 
 function update_recipient(ID)
 {
     var shipping_id            = $("#address_book_rp").val();
     var user_session           = $("#user_session").val(); 
     var user_session_comp      = $("#user_session_comp").val(); 
     
     var avl_sets_1             = $("#avl_sets_1").val();
     var need_sets_1            = $("#need_sets_1").val();
     var size_sets_1            = $("#size_sets_1").val();
     var output_sets_1          = $("#output_sets_1").val();
     var binding_sets_1_pre     = $("#binding_sets_1").val();
     var binding_sets_1         = (binding_sets_1_pre != '') ? binding_sets_1_pre : '0' ;
     var folding_sets_1         = $("#folding_sets_1").val();
     
     var avl_sets_2             = $("#avl_sets_2").val();
     var need_sets_2            = $("#need_sets_2").val();
     var size_sets_2            = $("#size_sets_2").val();
     var output_sets_2          = $("#output_sets_2").val();
     var binding_sets_2_pre     = $("#binding_sets_2").val();
     var binding_sets_2         = (binding_sets_2_pre != '') ? binding_sets_2_pre : '0' ;
     var folding_sets_2         = $("#folding_sets_2").val();
     var date_needed            = $("#date_needed").val();
     var time_needed            = $("#time_picker_icon").val();
     var spl_recipient          = $("#spl_recipient").val();
     
     var shipp_att              = $("#shipp_att").val();
     
     var size_custom_details    = (size_sets_1 == 'Custom') ? document.getElementById("size_custom_details").value : '0';
     
     var arrange_del            = document.getElementById('arrange_del').checked;
     var delivery_comp          = (arrange_del == false) ? document.getElementById("delivery_comp").value : '0';
     var bill_number            = (arrange_del == false) ? document.getElementById("bill_number").value : '0';
     if(arrange_del == false)
     {
        var shipp_comp_1        =   document.getElementById('shipp_comp_1').checked;
            var shipp_comp_1_f  =   (shipp_comp_1 == true) ? document.getElementById("shipp_comp_1").value : '0';
        var shipp_comp_2        =   document.getElementById('shipp_comp_2').checked;
            var shipp_comp_2_f  =   (shipp_comp_2 == true) ? document.getElementById("shipp_comp_2").value : '0';
        var shipp_comp_3        =   document.getElementById('shipp_comp_3').checked;
            var shipp_comp_3_f  =   (shipp_comp_3 == true) ? document.getElementById("other_shipp_type").value : '0';
     }else{
            var shipp_comp_1_f  =   '0';
            var shipp_comp_2_f  =   '0';
            var shipp_comp_3_f  =   '0';
     }      
     
     
     if(shipping_id == '0'){
         alert('Please select send to address');
         $("#address_book_rp").focus();
         return false;
     }
     
     if(date_needed == ''){
         alert('Please select when needed');
         $("#date_needed").focus();
         return false;
     }
     
     $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=6&shipping_id_rec="+encodeURIComponent(shipping_id)+"&avl_sets_1="+encodeURIComponent(avl_sets_1)+"&need_sets_1="+encodeURIComponent(need_sets_1)+"&size_sets_1="+encodeURIComponent(size_sets_1)+"&output_sets_1="+encodeURIComponent(output_sets_1)+"&binding_sets_1="+encodeURIComponent(binding_sets_1)+"&avl_sets_2="+encodeURIComponent(avl_sets_2)+"&need_sets_2="+encodeURIComponent(need_sets_2)+"&size_sets_2="+encodeURIComponent(size_sets_2)+"&output_sets_2="+encodeURIComponent(output_sets_2)+"&binding_sets_2="+encodeURIComponent(binding_sets_2)+"&user_session="+encodeURIComponent(user_session)+"&user_session_comp="+encodeURIComponent(user_session_comp)+"&date_needed="+encodeURIComponent(date_needed)+"&spl_recipient="+encodeURIComponent(spl_recipient)+"&edit_recipient_id="+ID+"&delivery_type="+encodeURIComponent(delivery_comp)+"&bill_number="+encodeURIComponent(bill_number)+"&shipp_comp_1_f="+encodeURIComponent(shipp_comp_1_f)+"&shipp_comp_2_f="+encodeURIComponent(shipp_comp_2_f)+"&shipp_comp_3_f="+encodeURIComponent(shipp_comp_3_f)+"&folding_sets_1="+encodeURIComponent(folding_sets_1)+"&folding_sets_2="+encodeURIComponent(folding_sets_2)+"&time_needed="+encodeURIComponent(time_needed)+"&size_custom_details="+encodeURIComponent(size_custom_details)+"&attention_to="+encodeURIComponent(shipp_att),
            beforeSend: loadStart,
            complete: loadStop,
            success: function(option)
            {  
                $('#multi_recipients').slideDown();
                $('#multi_recipients').html(option);
                $('#add_recipients').slideDown();
            }
        });
 }
 
 function uncheck_delivery()
 {
     var arrange_del = document.getElementById('arrange_del').checked;     
     if(arrange_del == false){          
     $('#preffered_info').slideDown();      
     document.getElementById("preffer_del").checked = true;
    }else{
     $('#preffered_info').slideUp();  
     document.getElementById("preffer_del").checked = false;
    }    
 }
 
 function check_prefer_delivery()
 {
     var preff_del = document.getElementById('preffer_del').checked;     
     if(preff_del == true){          
     $('#preffered_info').slideDown(); 
     $('#delivery_info').slideUp();
     document.getElementById("arrange_del").checked = false;
    }else{
     $('#preffered_info').slideUp();        
     $('#delivery_info').slideDown();
     document.getElementById("arrange_del").checked = true;
    }    
 }
 
 
 function uncheck_delivery_dynamic(option_id)
 {
     var arrange_del = document.getElementById('arrange_del_'+option_id).checked;     
     if(arrange_del == false){          
     $('#preffered_info_'+option_id).slideDown();      
     document.getElementById("preffer_del_"+option_id).checked = true;
    }else{
     $('#preffered_info_'+option_id).slideUp();  
     document.getElementById("preffer_del_"+option_id).checked = false;
    }    
 }
 
 function check_prefer_delivery_dynamic(option_id)
 {
     var preff_del = document.getElementById("preffer_del_"+option_id).checked;     
     if(preff_del == true){          
     $('#preffered_info_'+option_id).slideDown(); 
     $('#delivery_info_'+option_id).slideUp();
     document.getElementById("arrange_del_"+option_id).checked = false;
    }else{
     $('#preffered_info_'+option_id).slideUp();        
     $('#delivery_info_'+option_id).slideDown();
     document.getElementById("arrange_del_"+option_id).checked = true;
    }    
 }
 
 
 
 
 
 function delete_recipient_empty()
 {
     alert('Empty');
 }
 
 function loadStart() {
$('#loading').show();
}

function loadStop() {
$('#loading').hide();
}

function show_address()
{
    var shipping_id     = $("#address_book_rp").val();
    if(shipping_id == "P1"){
       $("#show_address").html("381 Broome Street New York, NY 10013"); 
       $("#shipp_att").val("");
    }else if(shipping_id == "P2"){
       $("#show_address").html("307 7th Ave, 5th Floor New York, NY 10013"); 
       $("#shipp_att").val("");
    }else{
        $.ajax
            ({
                type: "POST",
                url: "shipping_address_rec.php",
                data: "shipping_id_rp=" + shipping_id,
                success: function(option)
                {  
                    var myarr = option.split("~");
                    $("#show_address").html(myarr[0]);
                    $("#shipp_att").val(myarr[1]);
                }
            });
    }
}



function show_address_dynamic(option_id)
{
    var shipping_id     = $("#address_book_rp_"+option_id).val();
    if(shipping_id == "P1"){
       $("#show_address").html("381 Broome Street New York, NY 10013"); 
       $("#shipp_att_"+option_id).val("");
    }else if(shipping_id == "P2"){
       $("#show_address").html("307 7th Ave, 5th Floor New York, NY 10013"); 
       $("#shipp_att_"+option_id).val("");
    }else if(shipping_id == "NEW"){
       window.location = "service_add_address.php?serivice_plotting=1"; 
    }else if(shipping_id == "NEW-MULTI"){
       window.location = "service_add_address.php?serivice_plotting=1&multi=1"; 
    }else{
        $.ajax
            ({
                type: "POST",
                url: "shipping_address_rec.php",
                data: "shipping_id_rp=" + shipping_id,
                success: function(option)
                {  
                    var myarr = option.split("~");
                    $("#show_address_"+option_id).html(myarr[0]);
                    $("#shipp_att_"+option_id).val(myarr[1]);
                    $("#edit_address_"+option_id).fadeIn();
                }
            });
    }
}


function show_address_dynamic_nmjk(option_id)
{
    var shipping_id     = $("#address_book_rp_"+option_id).val();
    if(shipping_id == "P1"){
       $("#show_address").html("381 Broome Street New York, NY 10013"); 
       $("#shipp_att_"+option_id).val("");
    }else if(shipping_id == "P2"){
       $("#show_address").html("307 7th Ave, 5th Floor New York, NY 10013"); 
       $("#shipp_att_"+option_id).val("");
    }else if(shipping_id == "NEW"){
       window.location = "service_add_address.php?serivice_plotting=1"; 
    }else if(shipping_id == "NEW-MULTI"){
       window.location = "service_add_address.php?serivice_plotting=1&multi=1"; 
    }else{
        $.ajax
            ({
                type: "POST",
                url: "shipping_address_rec_nmjk.php",
                data: "shipping_id_rp="+shipping_id+"&option_id="+option_id,
                success: function(option)
                {  
                    var myarr = option.split("~");
                    $("#show_address_"+option_id).html(myarr[0]);
                    $("#shipp_att_"+option_id).val(myarr[1]);
                    $("#edit_address_"+option_id).fadeIn();
                    $("."+myarr[2]).hide();
                    $(".all_are_done").show();    
                    $(".all_are_done").attr('onclick', 'return add_recipients_dynamic_go_next_jk('+myarr[2]+');');
                }
            });
    }
}

$(function() {
    var all_exist_date_needed      = $("#all_exist_date").val();
    var split_element_needed       = all_exist_date_needed.split(","); 
    var disabledSpecificDays_needed = [split_element_needed[0],split_element_needed[1],split_element_needed[2],split_element_needed[3],split_element_needed[4],split_element_needed[5],split_element_needed[6],split_element_needed[7],split_element_needed[8],split_element_needed[8],split_element_needed[9],split_element_needed[10],split_element_needed[11],split_element_needed[12],split_element_needed[13],split_element_needed[14],split_element_needed[15],split_element_needed[16],split_element_needed[17],split_element_needed[18],split_element_needed[19]];

    function disableSpecificDaysAndWeekends(date) {
    var m = date.getMonth();
    var d = date.getDate();
    var y = date.getFullYear();

    for (var i = 0; i < disabledSpecificDays_needed.length; i++) {
    if ($.inArray((m + 1) + '-' + d + '-' + y, disabledSpecificDays_needed) != -1 ) {
    return [false];
    }
    }

    var noWeekend = $.datepicker.noWeekends(date);
    return !noWeekend[0] ? noWeekend : [true];
    } 
}); 

function date_reveal(ID)
{    
    var all_exist_date_needed      = $("#all_exist_date").val();
    var split_element_needed       = all_exist_date_needed.split(","); 
    var disabledSpecificDays_needed = [split_element_needed[0],split_element_needed[1],split_element_needed[2],split_element_needed[3],split_element_needed[4],split_element_needed[5],split_element_needed[6],split_element_needed[7],split_element_needed[8],split_element_needed[8],split_element_needed[9],split_element_needed[10],split_element_needed[11],split_element_needed[12],split_element_needed[13],split_element_needed[14],split_element_needed[15],split_element_needed[16],split_element_needed[17],split_element_needed[18],split_element_needed[19]];

    function disableSpecificDaysAndWeekends(date) {
    var m = date.getMonth();
    var d = date.getDate();
    var y = date.getFullYear();

    for (var i = 0; i < disabledSpecificDays_needed.length; i++) {
    if ($.inArray((m + 1) + '-' + d + '-' + y, disabledSpecificDays_needed) != -1 ) {
    return [false];
    }
    }

    var noWeekend = $.datepicker.noWeekends(date);
    return !noWeekend[0] ? noWeekend : [true];
    } 
$("#date_needed_"+ID).datepicker({minDate: 0,
            dateFormat: 'mm/dd/yy',
            inline: true,
            dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            beforeShowDay: disableSpecificDaysAndWeekends}); 
$("#date_needed_"+ID).focus();
}


function date_reveal_return()
{    
    var all_exist_date_needed      = $("#all_exist_date").val();
    var split_element_needed       = all_exist_date_needed.split(","); 
    var disabledSpecificDays_needed = [split_element_needed[0],split_element_needed[1],split_element_needed[2],split_element_needed[3],split_element_needed[4],split_element_needed[5],split_element_needed[6],split_element_needed[7],split_element_needed[8],split_element_needed[8],split_element_needed[9],split_element_needed[10],split_element_needed[11],split_element_needed[12],split_element_needed[13],split_element_needed[14],split_element_needed[15],split_element_needed[16],split_element_needed[17],split_element_needed[18],split_element_needed[19]];

    function disableSpecificDaysAndWeekends(date) {
    var m = date.getMonth();
    var d = date.getDate();
    var y = date.getFullYear();

    for (var i = 0; i < disabledSpecificDays_needed.length; i++) {
    if ($.inArray((m + 1) + '-' + d + '-' + y, disabledSpecificDays_needed) != -1 ) {
    return [false];
    }
    }

    var noWeekend = $.datepicker.noWeekends(date);
    return !noWeekend[0] ? noWeekend : [true];
    } 
$("#date_needed").datepicker({minDate: 0,
            dateFormat: 'mm/dd/yy',
            inline: true,
            dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            beforeShowDay: disableSpecificDaysAndWeekends}); 
$("#date_needed").focus();
}


function other_shipp_type()
{
    $("#shipp_comp_3").attr("checked", true);
}

function field_color()
{
    $("#bill_number").css("background-color", "#F3FA2F");
    $("#bill_number").focus();
}

function field_color_dynamic(OPTION_ID)
{
    $("#bill_number_"+OPTION_ID).css("background-color", "#F3FA2F");
    $("#bill_number_"+OPTION_ID).focus();
}

function asap()
{
    var current_status  =   $("#asap_status").attr('class');
    var change_status   =   (current_status == "asap_orange") ? 'asap_green' : 'asap_orange';
    $("#asap_status").removeClass(current_status);
    $("#asap_status").addClass(change_status);
    
    var current_dte_neede    = $("#date_needed").val();
    var current_time_neede   = $("#time_picker_icon").val();
    var change_date          = (current_dte_neede == 'ASAP') ? '' : 'ASAP';
    var change_time          = (current_time_neede == 'ASAP') ? '' : 'ASAP';
    $("#date_needed").val(change_date);
    $("#time_picker_icon").val(change_time);

}

function close_asap()
{
    //$("body").append("<div class='modal-overlay js-modal-close'></div>");
    $(".modal-overlay").fadeOut();
    $("#asap_popup").slideUp("slow"); 
}


function edit_recipient_address(option_id)
{  
    var shipping_id     = $("#address_book_rp_"+option_id).val();
    if(shipping_id != ''){
        $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",
            data: "recipients=77&address_book_id="+shipping_id+"&option_id="+option_id,
            beforeSend: loadStart,
            complete: loadStop,
            success: function(option)
            {  
                $("body").append("<div class='modal-overlay'></div>");
                $("#asap_popup").show();
                $("#recipient_address").html(option);
            }
        });    
    }
    
}

function save_recipient_address()
{
    var address_1               = $("#address_1").val();
    var address_2               = $("#address_2").val();
    var address_3               = $("#address_3").val();
    var edit_city               = $("#edit_city").val();
    var edit_state              = $("#edit_state").val();
    var edit_zip                = $("#edit_zip").val();
    var edit_address_id         = $("#edit_address_id").val();
    var edit_address_option_id  = $("#edit_option_id").val();
    
    //console.log(address_1+' '+address_2+' '+address_3+' '+edit_city+' '+edit_state+' '+edit_zip);
    
    if(edit_zip != ''){
        $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",
            data: "recipients=78&edit_address_1="+encodeURIComponent(address_1)+"&edit_address_2="+encodeURIComponent(address_2)+
                  "&edit_address_3="+encodeURIComponent(address_3)+"&edit_city="+encodeURIComponent(edit_city)+"&edit_state="+encodeURIComponent(edit_state)+
                  "&edit_zip="+encodeURIComponent(edit_zip)+"&edit_address_id="+encodeURIComponent(edit_address_id)+"&edit_address_option_id="+edit_address_option_id,
            beforeSend: loadStart,
            complete: loadStop,
            success: function(option)
            {                  
                $("#show_address_"+edit_address_option_id).html(option);
                $("#asap_popup").hide();
                $(".modal-overlay").fadeOut();
            }
        });    
    }
    
}


function ste_function(){
        //alert('jassim');
        document.getElementById("send_everything_to").checked = true;
        $('#address_book_se option:last-child').attr('selected', 'selected');
        var send_everything_to = document.getElementById('send_everything_to').checked;
        var address_book_se    = document.getElementById('address_book_se').value;
        if(send_everything_to == true){            
                $.ajax
                   ({
                       type: "POST",
                       url: "everything_return_to.php",
                       data: "everything_return_to=1&address_book_se="+address_book_se,
                       beforeSend: loadStart,
                       complete: loadStop,
                       success: function(option)
                       {  
                           $('#multi_recipients').slideDown();
                           $('#multi_recipients').html(option);
                           $('#add_recipients').slideDown();
                       }
                   });            
        }else{
            $('#multi_recipients').slideUp();
            $('#add_recipients').slideUp();
        }
 }
 
 function edit_binding(ID)
 {
     $("#binding_select_"+ID).show();
     $("#binding_"+ID).hide();
 }
 
 function change_binding(ID)
 {
    var binding_dtls    = $("#binding_select_"+ID).val(); 
    var binding_caps    = binding_dtls.toUpperCase();
    $.ajax
    ({
       type: "POST",
       url: "admin/get_child.php",
       data: "binding_id="+ID+"&binding_dtls="+binding_dtls,
       beforeSend: loadStart,
       complete: loadStop,
       success: function(option)
       {  
           if(option == true){
               $("#binding_"+ID).html(binding_caps);
               $("#binding_select_"+ID).hide();
               $("#binding_"+ID).show();
           }
       }
    });  
 }
 
 function edit_folding(ID)
 {
     $("#folding_select_"+ID).show();
     $("#folding_"+ID).hide();
 }
 
  function change_folding(ID)
 {
    var folding_dtls = $("#folding_select_"+ID).val();    
    var folding_caps    = folding_dtls.toUpperCase();
    $.ajax
    ({
       type: "POST",
       url: "admin/get_child.php",
       data: "folding_id="+ID+"&folding_dtls="+folding_dtls,
       beforeSend: loadStart,
       complete: loadStop,
       success: function(option)
       {  
           if(option == true){
               $("#folding_"+ID).html(folding_caps);
               $("#folding_select_"+ID).hide();
               $("#folding_"+ID).show();
           }
       }
    });  
 }
 
 function contact_phone(){
 $("#contact_ph").mask("999-999-9999");
 }
 
 function contact_phone_dynamic(OPTION_ID){
 $("#contact_ph_"+OPTION_ID).mask("999-999-9999");
 }
 
 function contact_phone_dynamic_1(){
 $(".contact_ph").mask("999-999-9999");
 }
 
 
 function show_address_recipient_1(ID)
 {
     $("#address_1_span_"+ID).hide();
     $("#address_1_"+ID).show();
     $("#address_1_buttons_"+ID).show();
     $("#show_address_buttons_to_"+ID).slideDown();
 }
 
  function cancel_address_1(ID)
 {
     $("#address_1_span_"+ID).show();
     $("#address_1_"+ID).hide();
     $("#address_1_buttons_"+ID).hide();     
 }
 

 
 function show_address_recipient_2(ID)
 {
     $("#address_2_span_"+ID).hide();
     $("#address_2_"+ID).show();
     $("#address_2_buttons_"+ID).show();
     $("#show_address_buttons_to_"+ID).slideDown();
 }
 
  function cancel_address_2(ID)
 {
     $("#address_2_span_"+ID).show();
     $("#address_2_"+ID).hide();
     $("#address_2_buttons_"+ID).hide();
 }
 
 function show_address_recipient_3(ID)
 {
     $("#address_3_span_"+ID).hide();
     $("#address_3_"+ID).show();
     $("#address_3_buttons_"+ID).show();
     $("#show_address_buttons_to_"+ID).slideDown();
 }
 
  function cancel_address_3(ID)
 {
     $("#address_3_span_"+ID).show();
     $("#address_3_"+ID).hide();
     $("#address_3_buttons_"+ID).hide();
 }
 
 function show_address_recipient_city(ID)
 {
     $("#address_city_span_"+ID).hide();
     $("#address_city_"+ID).show();
     $("#address_city_buttons_"+ID).show();
     $("#show_address_buttons_to_"+ID).slideDown();
 }
 
  function cancel_address_city(ID)
 {
     $("#address_city_span_"+ID).show();
     $("#address_city_"+ID).hide();
     $("#address_city_buttons_"+ID).hide();
 }
 
 function show_address_recipient_state(ID)
 {
     $("#address_state_span_"+ID).hide();
     $("#address_state_select_"+ID).show();   
     $("#show_address_buttons_to_"+ID).slideDown();
 }
 
 
 function show_address_recipient_zip(ID)
 {
     $("#address_zip_span_"+ID).hide();
     $("#address_zip_"+ID).show();
     $("#address_zip_"+ID).mask("99999");
     $("#address_zip_buttons_"+ID).show();
     $("#show_address_buttons_to_"+ID).slideDown();
 }
 
 function cancel_address_zip(ID)
 {
     $("#address_zip_span_"+ID).show();
     $("#address_zip_"+ID).hide();
     $("#address_zip_buttons_"+ID).hide();
 }
 
 function show_address_recipient_phone(ID)
 {
     $("#address_phone_span_"+ID).hide();
     $("#address_phone_"+ID).show();
     $("#address_phone_"+ID).mask("999-999-9999");
     $("#address_phone_buttons_"+ID).show();
     $("#show_address_buttons_to_"+ID).slideDown();
 }
 
 function cancel_address_phone(ID)
 {
     $("#address_phone_span_"+ID).show();
     $("#address_phone_"+ID).hide();
     $("#address_phone_buttons_"+ID).hide();
 }
 
 function update_exist_address(ID)
 {
     var address_1                  = $("#address_1_"+ID).val();
     var address_2                  = $("#address_2_"+ID).val();
     var address_3                  = $("#address_3_"+ID).val();
     var address_city               = $("#address_city_"+ID).val();
     var address_state_select       = $("#address_state_select_"+ID).val();
     var address_zip                = $("#address_zip_"+ID).val();
     var address_phone              = $("#address_phone_"+ID).val();
     
     $.ajax
        ({
           type: "POST",
           url: "get_recipients.php",
           data: "recipients=85&address_1="+encodeURIComponent(address_1)+"&address_2="+encodeURIComponent(address_2)+"&address_3="+encodeURIComponent(address_3)+"&address_city="+encodeURIComponent(address_city)+"&address_state_select="+address_state_select+"&address_zip="+encodeURIComponent(address_zip)+"&address_phone="+encodeURIComponent(address_phone)+"&address_id="+ID,
           beforeSend: loadStart,
           complete: loadStop,
           success: function(option)
           {  
               if(option == true){
                   
                   $("#address_1_"+ID).hide();
                   $("#address_1_span_"+ID).html(address_1);
                   $("#address_1_span_"+ID).show();
                   $("#address_1_buttons_"+ID).hide();
                   
                   $("#address_2_"+ID).hide();
                   $("#address_2_span_"+ID).html(address_2);
                   $("#address_2_span_"+ID).show();
                   $("#address_2_buttons_"+ID).hide();
                   
                   $("#address_3_"+ID).hide();
                   $("#address_3_span_"+ID).html(address_3);
                   $("#address_3_span_"+ID).show();
                   $("#address_3_buttons_"+ID).hide();
                   
                   $("#address_city_"+ID).hide();
                   $("#address_city_span_"+ID).html(address_city+",&nbsp;");
                   $("#address_city_span_"+ID).show();
                   $("#address_city_buttons_"+ID).hide();
                   
                   $("#address_state_select_"+ID).hide(); 
                   $("#address_state_span_"+ID).html(address_state_select);
                   $("#address_state_span_"+ID).show();
                   
                   
                   $("#address_zip_"+ID).hide();
                   $("#address_zip_span_"+ID).html(address_zip);
                   $("#address_zip_span_"+ID).show();
                   $("#address_zip_buttons_"+ID).hide();
                   
                   $("#address_phone_"+ID).hide();
                   $("#address_phone_span_"+ID).html(address_phone);
                   $("#address_phone_span_"+ID).show();
                   $("#address_phone_buttons_"+ID).hide();
                   
                   $("#show_address_buttons_to_"+ID).slideUp();
               }
           }
        }); 
 }
 
 function save_new_address(ID, OPTION_ID)
 {  
    $.ajax
        ({
           type: "POST",
           url: "add_new_address_closer.php",
           data: "address_closer=1_1&address_id="+ID,
           beforeSend: loadStart,
           complete: loadStop,
           success: function(option)
           {  
               $("#show_address_"+OPTION_ID).css("height", "125px");
               $("#jumbalakka_nmj_"+OPTION_ID).css("margin-top", "85px");
               $("#show_address_inside_"+OPTION_ID).html(option);
               $("#company_phone_closer").mask("999-999-9999");
               $("#company_zip_closer").mask("99999");
               $("#save_only_"+OPTION_ID).hide();
               $("#show_save_new_"+OPTION_ID).hide();
               $("#save_new_"+OPTION_ID).show();
               $("#show_save_new_cancel_"+OPTION_ID).show();               
           }
        });     
         
 }
 
 function save_new_address_to(ID, OPTION_ID)
 {  
    $.ajax
        ({
           type: "POST",
           url: "add_new_address_closer.php",
           data: "address_closer=1_1&address_id="+ID,
           beforeSend: loadStart,
           complete: loadStop,
           success: function(option)
           {  
               $("#show_address").css("height", "125px");
               //$("#jumbalakka_nmj_"+OPTION_ID).css("margin-top", "85px");
               $("#show_address").html(option);
               $("#company_phone_closer").mask("999-999-9999");
               $("#company_zip_closer").mask("99999");
               $("#save_only").hide();
               $("#show_save_new").hide();
               $("#save_new").show();
               $("#show_save_new_cancel").show();               
           }
        });     
         
 }
 
 function save_new_address_cancel(ID, option_id)
 {  
     var shipping_id     = ID;
    if(shipping_id == "P1"){
       $("#show_address").html("381 Broome Street New York, NY 10013"); 
       $("#shipp_att_"+option_id).val("");
    }else if(shipping_id == "P2"){
       $("#show_address").html("307 7th Ave, 5th Floor New York, NY 10013"); 
       $("#shipp_att_"+option_id).val("");
    }else if(shipping_id == "NEW"){
       window.location = "service_add_address.php?serivice_plotting=1"; 
    }else if(shipping_id == "NEW-MULTI"){
       window.location = "service_add_address.php?serivice_plotting=1&multi=1"; 
    }else{
        $.ajax
            ({
                type: "POST",
                url: "shipping_address_rec_nmjk.php",
                data: "shipping_id_rp="+shipping_id+"&option_id="+option_id,
                success: function(option)
                {  
                    var myarr = option.split("~");
                    $("#show_address_"+option_id).html(myarr[0]);
                    $("#shipp_att_"+option_id).val(myarr[1]);
                    $("#edit_address_"+option_id).fadeIn();
                }
            });
    }    
 }
 
 function save_new_address_cancel_to(ID)
 {  
    var send_everything_to = document.getElementById('send_everything_to').checked;
     var address_book_se    = document.getElementById('address_book_se').value;
     if(send_everything_to == true){
         if(address_book_se != '0'){
             $.ajax
                ({
                    type: "POST",
                    url: "everything_return_to.php",
                    data: "everything_return_to=1&address_book_se="+address_book_se,
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {  
                        $('#multi_recipients').slideDown();
                        $('#multi_recipients').html(option);
                        $('#add_recipients').slideDown();
                        $('.addrecipientActionLink').hide();
                        $(".addproductActionLink").hide();
                    }
                });
         }else{
            alert("Select the address.");
            document.getElementById('address_book_se').focus();
            document.getElementById('send_everything_to').checked = false;
         }
     }else{
         $('#multi_recipients').slideUp();
         $('#add_recipients').slideUp();
     } 
 }
 
 function save_new_record(ID,OPTION_ID)
 {
     var company_name               = $("#company_name_closer_"+ID).val();
     var attention_to               = $("#attention_to_closer_"+ID).val();
     var address_1                  = $("#address_1_closer_"+ID).val();
     var address_2                  = $("#address_2_closer_"+ID).val();
     var address_3                  = $("#address_3_closer_"+ID).val();
     var address_city               = $("#city_closer_"+ID).val();
     var address_state_select       = $("#state_closer_"+ID).val();
     var address_zip                = $("#company_zip_closer_"+ID).val();
     var phone                      = $("#company_phone_closer_"+ID).val();
     
     if(company_name == ''){
         $("#company_name_closer_"+ID).css("border", "1px solid #EA4335");
         $("#company_name_closer_"+ID).focus();
         return false;
     }else{
         $("#company_name_closer_"+ID).css("border", "1px solid #ccc");        
     }
     
     if(attention_to == ''){
         $("#attention_to_closer_"+ID).css("border", "1px solid #EA4335");
         $("#attention_to_closer_"+ID).focus();
         return false;
     }else{
         $("#attention_to_closer_"+ID).css("border", "1px solid #ccc");
     }
     
     if(address_1 == ''){
         $("#address_1_closer_"+ID).css("border", "1px solid #EA4335");
         $("#address_1_closer_"+ID).focus();
         return false;
     }else{
         $("#address_1_closer_"+ID).css("border", "1px solid #ccc");
     }
          
     if(address_city == ''){
         $("#city_closer_"+ID).css("border", "1px solid #EA4335");
         $("#city_closer_"+ID).focus();
         return false;
     }else{
         $("#city_closer_"+ID).css("border", "1px solid #ccc");
     }
     
     if(address_state_select == '0'){
         $("#state_closer_"+ID).css("border", "1px solid #EA4335");
         $("#state_closer_"+ID).focus();
         return false;
     }else{
         $("#state_closer_"+ID).css("border", "1px solid #ccc");
     }
     
     if(address_zip == ''){
         $("#company_zip_closer_"+ID).css("border", "1px solid #EA4335");
         $("#company_zip_closer_"+ID).focus();
         return false;
     }else{
         $("#company_zip_closer_"+ID).css("border", "1px solid #ccc");
     }
     
     if(phone == ''){
         $("#company_phone_closer_"+ID).css("border", "1px solid #EA4335");
         $("#company_phone_closer_"+ID).focus();
         return false;
     }else{
         $("#company_phone_closer_"+ID).css("border", "1px solid #ccc");
     }
     
     $.ajax
        ({
           type: "POST",
           url: "get_recipients.php",
           data: "recipients=86&company_name="+encodeURIComponent(company_name)+"&attention_to="+encodeURIComponent(attention_to)+"&address_1="+encodeURIComponent(address_1)+"&address_2="+encodeURIComponent(address_2)+"&address_3="+encodeURIComponent(address_3)+"&address_city="+encodeURIComponent(address_city)+"&address_state_select="+encodeURIComponent(address_state_select)+"&address_zip="+encodeURIComponent(address_zip)+"&phone="+phone+"&address_id="+ID,
           beforeSend: loadStart,
           complete: loadStop,
           success: function(option)
           {  
               var options_divide = option.split('~');
               $("#address_book_rp").html(options_divide[3]);
               if(OPTION_ID != ''){
               $("#address_book_rp_"+OPTION_ID).html(options_divide[3]);
               }
               if(options_divide[0] == true){
                   
                   $("#add_new_address_block_"+ID).hide();
                   $("#show_address_inside_"+OPTION_ID).html(options_divide[1]);
                   $("#shipp_att_"+OPTION_ID).val(options_divide[2]);
                   $("#show_address_buttons_to_"+ID).slideUp();
                   $("#show_address").css("height", "80px");
                   $("#save_new_"+OPTION_ID).hide();
                   $("#show_save_new_"+OPTION_ID).show();
                   var drop_down_val    = $("#last_entered_add_id").val();
                   $("#show_save_new_"+OPTION_ID).attr("onclick", "save_new_address("+drop_down_val+","+OPTION_ID+");");
                   $("#save_new_"+OPTION_ID).attr("onclick", "save_new_record("+drop_down_val+","+OPTION_ID+");");
               }else{
                   alert('Company Name Already Exist.');
                   $("#company_name_closer_"+ID).focus();
               }
           }
        }); 
 }
 
 function save_new_record_to(ID,OPTION_ID)
 {
     var company_name               = $("#company_name_closer_"+ID).val();
     var attention_to               = $("#attention_to_closer_"+ID).val();
     var address_1                  = $("#address_1_closer_"+ID).val();
     var address_2                  = $("#address_2_closer_"+ID).val();
     var address_3                  = $("#address_3_closer_"+ID).val();
     var address_city               = $("#city_closer_"+ID).val();
     var address_state_select       = $("#state_closer_"+ID).val();
     var address_zip                = $("#company_zip_closer_"+ID).val();
     var phone                      = $("#company_phone_closer_"+ID).val();
     
     if(company_name == ''){
         $("#company_name_closer_"+ID).css("border", "1px solid #EA4335");
         $("#company_name_closer_"+ID).focus();
         return false;
     }else{
         $("#company_name_closer_"+ID).css("border", "1px solid #ccc");        
     }
     
     if(attention_to == ''){
         $("#attention_to_closer_"+ID).css("border", "1px solid #EA4335");
         $("#attention_to_closer_"+ID).focus();
         return false;
     }else{
         $("#attention_to_closer_"+ID).css("border", "1px solid #ccc");
     }
     
     if(address_1 == ''){
         $("#address_1_closer_"+ID).css("border", "1px solid #EA4335");
         $("#address_1_closer_"+ID).focus();
         return false;
     }else{
         $("#address_1_closer_"+ID).css("border", "1px solid #ccc");
     }
          
     if(address_city == ''){
         $("#city_closer_"+ID).css("border", "1px solid #EA4335");
         $("#city_closer_"+ID).focus();
         return false;
     }else{
         $("#city_closer_"+ID).css("border", "1px solid #ccc");
     }
     
     if(address_state_select == '0'){
         $("#state_closer_"+ID).css("border", "1px solid #EA4335");
         $("#state_closer_"+ID).focus();
         return false;
     }else{
         $("#state_closer_"+ID).css("border", "1px solid #ccc");
     }
     
     if(address_zip == ''){
         $("#company_zip_closer_"+ID).css("border", "1px solid #EA4335");
         $("#company_zip_closer_"+ID).focus();
         return false;
     }else{
         $("#company_zip_closer_"+ID).css("border", "1px solid #ccc");
     }
     
     if(phone == ''){
         $("#company_phone_closer_"+ID).css("border", "1px solid #EA4335");
         $("#company_phone_closer_"+ID).focus();
         return false;
     }else{
         $("#company_phone_closer_"+ID).css("border", "1px solid #ccc");
     }
     
     $.ajax
        ({
           type: "POST",
           url: "get_recipients.php",
           data: "recipients=86&company_name="+encodeURIComponent(company_name)+"&attention_to="+encodeURIComponent(attention_to)+"&address_1="+encodeURIComponent(address_1)+"&address_2="+encodeURIComponent(address_2)+"&address_3="+encodeURIComponent(address_3)+"&address_city="+encodeURIComponent(address_city)+"&address_state_select="+encodeURIComponent(address_state_select)+"&address_zip="+encodeURIComponent(address_zip)+"&phone="+phone+"&address_id="+ID,
           beforeSend: loadStart,
           complete: loadStop,
           success: function(option)
           {  
               var options_divide = option.split('~');
               $("#address_book_rp").html(options_divide[3]);
               if(OPTION_ID != ''){
               $("#address_book_rp_"+OPTION_ID).html(options_divide[3]);
               }
               if(options_divide[0] == true){
                   
                   $("#add_new_address_block_"+ID).hide();
                   $("#show_address").html(options_divide[1]);
                   $("#shipp_att").val(options_divide[2]);
                   $("#show_address_buttons_to").slideUp();
                   $("#show_address").css("height", "80px");
                   
               }else{
                   alert('Company Name Already Exist.');
                   $("#company_name_closer_"+ID).focus();
               }
           }
        }); 
 }
 
 function update_recipient_dynamic(ID)
 {
     var shipping_id            = $("#address_book_rp_"+ID).val();
     var user_session           = $("#user_session").val(); 
     var user_session_comp      = $("#user_session_comp").val(); 
     
     var avl_sets_1             = $("#avl_sets_1").val();
     var need_sets_1            = $("#need_sets_1").val();
     var size_sets_1            = $("#size_sets_1").val();
     var output_sets_1          = $("#output_sets_1").val();
     var binding_sets_1_pre     = $("#binding_sets_1").val();
     var binding_sets_1         = (binding_sets_1_pre != '') ? binding_sets_1_pre : '0' ;
     var folding_sets_1         = $("#folding_sets_1").val();
     
     var avl_sets_2             = $("#avl_sets_2").val();
     var need_sets_2            = $("#need_sets_2").val();
     var size_sets_2            = $("#size_sets_2").val();
     var output_sets_2          = $("#output_sets_2").val();
     var binding_sets_2_pre     = $("#binding_sets_2").val();
     var binding_sets_2         = (binding_sets_2_pre != '') ? binding_sets_2_pre : '0' ;
     var folding_sets_2         = $("#folding_sets_2").val();
     var date_needed            = $("#date_needed").val();
     var time_needed            = $("#time_picker_icon").val();
     var spl_recipient          = $("#spl_recipient").val();
     
     var shipp_att              = $("#shipp_att").val();
     
     var size_custom_details    = (size_sets_1 == 'Custom') ? document.getElementById("size_custom_details").value : '0';
     
     var arrange_del            = document.getElementById('arrange_del_'+ID).checked;
     var delivery_comp          = (arrange_del == false) ? document.getElementById("delivery_comp").value : '0';
     var bill_number            = (arrange_del == false) ? document.getElementById("bill_number").value : '0';
     if(arrange_del == false)
     {
        var shipp_comp_1        =   document.getElementById('shipp_comp_1').checked;
            var shipp_comp_1_f  =   (shipp_comp_1 == true) ? document.getElementById("shipp_comp_1").value : '0';
        var shipp_comp_2        =   document.getElementById('shipp_comp_2').checked;
            var shipp_comp_2_f  =   (shipp_comp_2 == true) ? document.getElementById("shipp_comp_2").value : '0';
        var shipp_comp_3        =   document.getElementById('shipp_comp_3').checked;
            var shipp_comp_3_f  =   (shipp_comp_3 == true) ? document.getElementById("other_shipp_type").value : '0';
     }else{
            var shipp_comp_1_f  =   '0';
            var shipp_comp_2_f  =   '0';
            var shipp_comp_3_f  =   '0';
     }      
     
     
     if(shipping_id == '0'){
         alert('Please select send to address');
         $("#address_book_rp").focus();
         return false;
     }
     
     if(date_needed == ''){
         alert('Please select when needed');
         $("#date_needed").focus();
         return false;
     }
     
     $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=502&shipping_id_rec="+encodeURIComponent(shipping_id)+"&avl_sets_1="+encodeURIComponent(avl_sets_1)+"&need_sets_1="+encodeURIComponent(need_sets_1)+"&size_sets_1="+encodeURIComponent(size_sets_1)+"&output_sets_1="+encodeURIComponent(output_sets_1)+"&binding_sets_1="+encodeURIComponent(binding_sets_1)+"&avl_sets_2="+encodeURIComponent(avl_sets_2)+"&need_sets_2="+encodeURIComponent(need_sets_2)+"&size_sets_2="+encodeURIComponent(size_sets_2)+"&output_sets_2="+encodeURIComponent(output_sets_2)+"&binding_sets_2="+encodeURIComponent(binding_sets_2)+"&user_session="+encodeURIComponent(user_session)+"&user_session_comp="+encodeURIComponent(user_session_comp)+"&date_needed="+encodeURIComponent(date_needed)+"&spl_recipient="+encodeURIComponent(spl_recipient)+"&edit_recipient_id="+ID+"&delivery_type="+encodeURIComponent(delivery_comp)+"&bill_number="+encodeURIComponent(bill_number)+"&shipp_comp_1_f="+encodeURIComponent(shipp_comp_1_f)+"&shipp_comp_2_f="+encodeURIComponent(shipp_comp_2_f)+"&shipp_comp_3_f="+encodeURIComponent(shipp_comp_3_f)+"&folding_sets_1="+encodeURIComponent(folding_sets_1)+"&folding_sets_2="+encodeURIComponent(folding_sets_2)+"&time_needed="+encodeURIComponent(time_needed)+"&size_custom_details="+encodeURIComponent(size_custom_details)+"&attention_to="+encodeURIComponent(shipp_att)+"&jumbalakka_id="+ID,
            beforeSend: loadStart,
            complete: loadStop,
            success: function(option)
            {  
                $('#dynamic_edit_'+ID).html(option);
            }
        });
 }
 
 
 function continue_recipient_everyting_return_4()
 {  
     var pickup_soho_add        = $("#pickup_soho_add").val();  
     var date_needed            = $("#date_needed").val();
     var time_needed            = $("#time_picker_icon").val();
     var spl_recipient          = $("#spl_recipient").val();
     
     if(date_needed == ''){
         alert('Please select when needed');
         $("#date_needed").focus();
         return false;
     }
     
     $.ajax
        ({
            type: "POST",
            url: "get_recipients.php",                  
            data: "recipients=786&date_needed="+encodeURIComponent(date_needed)+"&spl_recipient="+encodeURIComponent(spl_recipient)+"&time_needed="+encodeURIComponent(time_needed)+"&pickup_soho_add="+pickup_soho_add+"&delivery_type_option=3",
            beforeSend: loadStart,
            complete: loadStop,
            success: function(option)
            {  
                if(option == '1'){
                    window.location = "view_all_recipients.php";
                }
            }
        });
 }
 
 
 </script>


<?php
if($_GET['address_ste'] == '1'){      
?>
<script>
ste_function();
</script>
<?php
}
?>

 </body>
 <!-- Mirrored from buckart.com/srsite/SoHoRepro-WebsitePages/store/store.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 21 Sep 2013 08:45:26 GMT -->
 </html>
