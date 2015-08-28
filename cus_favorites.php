<?php
include './admin/config.php';
include './admin/db_connection.php';
$user_id = $_SESSION['sohorepro_companyid'];
$id_user = $_SESSION['sohorepro_userid'];

if($_SESSION['sohorepro_companyid']  == '')
{
  header("Location:index.php");
  exit;
}

$delete_fav = "UPDATE sohorepro_favorites SET delete_id = '0' WHERE comp_id = '".$_SESSION['sohorepro_companyid']."' ";
mysql_query($delete_fav); 



$favorites = ALLFAV($user_id);

if ($_GET['delete_id']) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM sohorepro_favorites WHERE id = " . $delete_id . " ";
    $sql_result = mysql_query($sql);
    if ($sql_result) {
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



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
 <!-- Mirrored from buckart.com/srsite/SoHoRepro-WebsitePages/store/store.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 21 Sep 2013 08:44:50 GMT -->
 <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
 <head>
 <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
 <title>SohoRepro Favorites</title>

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
.favorites{
font-size: 22px;
font-weight: bold;
color: #ff7e00;
}
.favorites_del{
padding: 4px 10px;
line-height: 15px;
border-radius: 6px;
font-weight: bold;
background: #FF7E00;
color: #FFF;
margin-bottom: 5px;
cursor:pointer;
}

.checkout_fav{
    cursor: pointer;
    float:right;
    font-size:12px;
    padding:1.5px;
    width: 100px;
    margin-top:11px;
    margin-bottom:11px; 
    -moz-border-radius: 5px; 
    -webkit-border-radius: 5px;
    border:1px solid #8f8f8f;
}

.checkout_fav_del{
    cursor: pointer;
    text-align: center;
    background-color: #e5e5e5;
    float:left;
    font-size:12px;
    padding:1.5px;
    width: 100px;
    margin-top:11px;
    margin-bottom:11px; 
    -moz-border-radius: 5px; 
    -webkit-border-radius: 5px;
    border:1px solid #8f8f8f;
    font-weight: bold;
}

.continue_shopp_fav{
    background-color: #e5e5e5;
    border: 1px solid #8f8f8f;
    color: #000;
    cursor: pointer;
    float: right;
    font-size: 12px;
    padding: 1.5px;
    text-align: center;
    width: 108px;
    -moz-border-radius: 5px; 
    -webkit-border-radius: 5px;
    
}


.tot_cart {
text-align: right;
color: #5C5C5C;
font-size: 18px;
font-weight: bold;
}
.curr_tot_div {
text-align: right;
color: #5C5C5C;
font-weight: bold;
font-size: 18px;
padding-right: 0px;
}
.ref_div{
position: relative;
}
.ref_span{
font-size:22px; font-weight:bold;
}
.ref_div_star{
color:red; margin-top: -5px;font-size: 16px;font-weight: bold;
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
    text-align: left;
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
 <div id="loading" class="none"  style="position: fixed;top: 35%;left: 48%;padding: 5px;z-index: 10;">
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
    if ($_GET['dele_succ'] == "1") {
        ?>
        <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Favorites item Deleted Successfully</div>
        <script>setTimeout("location.href=\'cus_favorites.php\'", 1000);</script>
        <?php
    } elseif ($result == "failure") {
        ?>
        <div style="color:#F00; text-align:center; padding-bottom:10px;">Favorites item Not Deleted</div>
        <script>setTimeout("location.href=\'cus_favorites.php\'", 1000);</script>       
        <?php
    }
    ?>
        <form method="post" action="shoppingcart.php" onsubmit="return fav_cart_submit();">
            <input type="hidden" name="order_val" value="1" id="order_val" />
        <table width="100%" style="margin-bottom: 15px;">
            <tr align="right">
        <td>
            <div class="ref_div">
                <span class="ref_span">Job Reference<span class="ref_div_star">*</span> :</span> 
                <input aria-haspopup="true" aria-autocomplete="list" role="textbox" autocomplete="off" class="ui-autocomplete-input dec" style="padding:3px;width: 195px;" name="jobref" id="jobref" type="text" value="<?php echo ($_SESSION['ref_val'] != '') ? $_SESSION['ref_val'] : ''; ?>" onblur="return dummy_reference_1();" />
                <div id="result_ref">
                </div>
            </div>
            <input type="hidden" name="user_session" id="user_session" value="<?php echo $_SESSION['sohorepro_userid']; ?>" />
            <input type="hidden" name="user_session_comp" id="user_session_comp" value="<?php echo $_SESSION['sohorepro_companyid']; ?>" />
        </td>
    </tr>
        </table>
<table width="100%" >    
    <tr>
        <td> 
            <div class="tot_cart" id="fav_total_cart">Total Items in Cart : <?php echo ($_SESSION['session_cart'] != '') ? $_SESSION['session_cart'] : '0'; ?></div>
            <input type="hidden" name="fav_total_car_dummy" id="fav_total_car_dummy" value="<?php echo ($_SESSION['session_cart'] != '') ? $_SESSION['session_cart'] : '0'; ?>" />
            <input type="hidden" name="fav_total_car_dummy" id="fav_total_car_dummy_cs" value="<?php echo ($_SESSION['session_cart'] != '') ? $_SESSION['session_cart'] : '0'; ?>" />
            
            <div class="curr_tot_div" id="fav_total_order">Current Order Total : <?php echo ($_SESSION['session_order'] != '') ? number_format($_SESSION['session_order'], 2, '.', '') : '$0.00'; ?></div>
            <input type="hidden" name="fav_total_ord_dummy" id="fav_total_ord_dummy" value="<?php echo ($_SESSION['session_order'] != '') ? number_format($_SESSION['session_order'], 2, '.', '') : '0'; ?>" />
            <input type="hidden" name="fav_total_ord_dummy" id="fav_total_ord_dummy_cs" value="<?php echo ($_SESSION['session_order'] != '') ? number_format($_SESSION['session_order'], 2, '.', '') : '0'; ?>" />
            <input type="hidden" name="fav_total_car_dummy_validat" id="fav_total_car_dummy_validat" value="0" />            
        </td>
    </tr>
</table>
            <form name="new_email" id="new_email" method="post" action="" >
<table width="740" border="0" cellspacing="0" cellpadding="0">
  <tr>
      <td align="left" valign="top">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" >
              <tr>
                  <td align="left" class="favorites">Favorites</td>
                  <input type="hidden" name="fav_dummy" id="fav_dummy" value="" />
                  <input type="hidden" name="fav_to_delete" id="fav_to_delete" value="" />                  
              </tr>
          </table>
      </td>
  </tr>
  <tr>
  <td align="left" valign="top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="product_table" >
  <tr bgcolor="#ff7e00" class="h1">
    <td width="5%" align="center" valign="middle" class="brdr_2" >&nbsp;</td>
    <td width="5%" align="center" valign="middle" class="brdr_2" >No</td>
    <td width="45%" align="center" valign="middle" class="brdr_2" >Product Name</td>    
    <td width="8%" align="center" valign="middle" class="brdr_2">Price</td>
    <td width="9%" align="center" valign="middle" class="brdr_2">Quantity</td>
    <td width="13%" align="center" valign="middle" class="brdr_2">Sub Total</td>
    <td width="10%" align="center" valign="middle" class="brdr_2">&nbsp;</td>
  </tr>
      <?php 
      if(count($favorites) > 0){
          $i = 1;
          for ($x = 2; $x <= (count($favorites) - 1); $x++) {
                $series[] = $x;
            }
//            echo '<pre>';
//            print_r($series);
//            echo '</pre>';
          foreach ($favorites as $fav){
            $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
            $id           =   $fav['id'];
            $product_name = getProName($fav['product_id']);
            $super_id = getsuper($fav['product_id']);
            $cat_id = getcat($fav['product_id']);
            $sub_id = getsub($fav['product_id']);
            $super_name         = (getsuperN($super_id) != '') ? getsuperN($super_id) : '';        
            $cat_name_pre       = (getcatN($cat_id) != '') ? getcatN($cat_id) : '';
            $cat_name           = ($cat_name_pre != '') ? '>>'.$cat_name_pre : $cat_name_pre ;        
            $sub_name_pre       = (getsubN($sub_id) != '') ? getsubN($sub_id):'';
            $sub_name           = ($sub_name_pre != '')  ? '>>'.$sub_name_pre : $sub_name_pre;            
            $spl_price          = GetSplFav($_SESSION['sohorepro_companyid'],$fav['product_id']);
            $price              = $fav['sell_price'];
            $ip                 = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
            $exist_qty          = ExistQuantityGuest($fav['product_id'], $ip);
            $exist_list         = ExistUnitGuest($fav['product_id'], $ip);
            $qty_entered        = ($exist_qty != '') ? $exist_qty : '' ;
            $price_pre          = ($qty_entered * $exist_list);
            $price_fav          = ($price_pre != '') ? $price_pre : '0.00';
            $totalAddedCart     =  totalCartfav($ip);
            $totalAddedord      =  totalOrderfav($ip);
            
//            echo '<pre>';
//            print_r($spl_price);
//            echo '</pre>';
//            echo '<pre>';
//            print_r($_SESSION);
//            echo '</pre>';
      ?>
      <tr bgcolor="<?php echo $rowColor; ?>">
          <td align="center" valign="middle" class="brdr_1"><input type="checkbox" name="fav_check[]" value="<?php echo $id; ?>" onclick="return add_to_delete_list('<?php echo $id; ?>');" /></td>
          <td align="center" valign="middle" class="brdr_1"><?php echo $i; ?></td>
          <td align="left" valign="middle" class="brdr_1" style="font-size: 15px;">
            <?php echo $product_name.'<br>'; ?>
          <span class="trail" style="font-size: 11px;color: #2a9be3;"><?php echo $super_name.$cat_name.$sub_name;  ?></span>  
          </td>
          <td align="center" valign="middle" class="brdr_1">
              <?php echo $price; ?>
              <input type="hidden" name="fav_price_<?php echo $id; ?>" id="fav_price_<?php echo $id; ?>" value="<?php echo $price; ?>" />
          </td>
          <td align="center" valign="middle" class="brdr_1">
              <input type="text" style="width: 30px;" name="fav_qty_<?php echo $id; ?>" class="qty_dum" id="fav_qty_<?php echo $id; ?>" onkeyup="return qty_fav('<?php echo $fav['product_id']; ?>','<?php echo $price; ?>', '<?php echo $id; ?>')" value="<?php echo $qty_entered; ?>" />
          </td>
          <td align="center" valign="middle" class="brdr_1">
              <span id="sub_tot_fav_<?php echo $id; ?>"><?php echo $price_fav; ?></span>
              <input type="hidden" id="sub_tot_fav_dummy_<?php echo $id; ?>" class="sub_fav_dummy" value="<?php echo $price_fav; ?>" />
          </td>
          <td align="center" valign="middle" class="brdr_1">
              <div class="btn_addcart" <?php if(count($series) > 0){ if (in_array($i, $series)) { ?>style="display: none;"<?php }} ?>>
              <img src="images/add_cart_bg.png" onclick="return add_cart_fav_('<?php echo $src['id']; ?>', '<?php echo $prd_id; ?>');" class="bottom_add_cart" id="addAll" style="cursor: pointer;" />
              </div>
          </td>
      </tr>
      <?php 
      $i++;
          }          
          }else{ ?>
      <tr bgcolor="<?php echo $rowColor; ?>">
          <td colspan="7" align="center" valign="middle" class="brdr_1"></td> 
      </tr>
      <?php } ?>
      <input type="hidden" name="enterd_cart_tot" id="entered_cart_tot" value="<?php echo $totalAddedCart; ?>" />
      <input type="hidden" name="enterd_ord_tot" id="entered_ord_tot" value="<?php echo $totalAddedord; ?>" />
    </table>
      <table width="100%">
          <tr>
              <td align="left" class="checkout_fav_del" onclick="return delete_fav_items('<?php echo $_SESSION['sohorepro_companyid']; ?>');">Delete</td>
              <td align="right" style="padding-top: 10px;">
                  <div class="curr_tot_div" id="fav_total_order_bottom">Current Order Total : <?php echo ($_SESSION['session_order'] != '') ? number_format($_SESSION['session_order'], 2, '.', '') : '$0.00'; ?></div>
              </td>
          </tr>
      </table>
    <table width="100%">
        <tr>            
            <td align="right" width="86%" valign="middle">
                <span class="continue_shopp_fav" onclick="return continue_shopping_fav('<?php echo $id_user; ?>')">Continue Shopping</span> 
            </td>
            <td align="right" width="14%">               
                    <input class="checkout_fav" value="Checkout" type="submit"  /> 
            </td>
        </tr>                
    </table>
</td>
  </tr>
</table>
            </form>
    </form>
</div>
<!--<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jQuery/jquery-1.4.2.min.js"></script>-->
<script>
function qty_fav(PROD_ID, SPL_PRC, ID){
    var fav_spl_prc = document.getElementById("fav_price_"+ID).value;
    var fav_spl_qty = document.getElementById("fav_qty_"+ID).value;
    var fav_dummy_cart   = document.getElementById("fav_dummy").value;
    var sub_tot     = (Number(fav_spl_prc) * Number(fav_spl_qty));
    $("#sub_tot_fav_"+ID).html(sub_tot.toFixed(2));
    $("#sub_tot_fav_dummy_"+ID).val(sub_tot.toFixed(2));
    $("#fav_dummy").val(Number(fav_dummy_cart) + Number(fav_spl_qty));  
    $.ajax
    ({
        type: "POST",
        url: "admin/get_child.php",
        data: "id_fav=" + PROD_ID + "&guest_qty_fav=" + fav_spl_qty + "&guest_price_fav=" + SPL_PRC,
        success: function(option)
        {

        }
    });
}

function fav_cart_submit() {
    var fav_total_car_dummy   = document.getElementById("fav_total_car_dummy_validat").value;
    var fav_ref               = document.getElementById("jobref").value;
    if(fav_total_car_dummy == '0')
    {
        alert('You must enter the quantity any one product.');
        return false;
    }
    if(fav_ref == ''){
        alert('You must enter the reference.');
        document.getElementById("jobref").focus();
        return false;
    }    
}

function add_cart_fav(){
    var fav_dummy_cart   = document.getElementById("fav_dummy").value;
    alert(fav_dummy_cart)
    $("#fav_total_cart").html("Total Items in Cart : "+fav_dummy_cart);
    $("#fav_total_car_dummy").val(fav_dummy_cart);  
    
}



$(function() {
    $(".bottom_add_cart").click(function() {
        
        var fav_total_car_dummy   = document.getElementById("fav_total_car_dummy").value;
        var fav_total_ord_dummy   = document.getElementById("fav_total_ord_dummy").value;
        
        var fav_total_car_entered = document.getElementById("entered_cart_tot").value;
        var fav_total_ord_entered = document.getElementById("entered_ord_tot").value;
        
        var add = 0;
        $(".qty_dum").each(function() {
            add += Number($(this).val());
        });
        
        var add_sub = 0;
        $(".sub_fav_dummy").each(function() {
            add_sub += Number($(this).val());
        });        
        
        
        
        var pre_order   =   add_sub.toFixed(2);
        var total_order = ((Number(pre_order) + Number(fav_total_ord_dummy)) - Number(fav_total_ord_entered));
        
        //alert(add_sub.toFixed(2));
        
        $("#fav_total_cart").html("Total Items in Cart : "+((add + Number(fav_total_car_dummy)) - Number(fav_total_car_entered)));
        $("#fav_total_car_dummy").val((add + Number(fav_total_car_dummy)) - Number(fav_total_car_entered)); 

        $("#fav_total_order").html("Current Order Total : $"+ total_order.toFixed(2));
        $("#fav_total_order_bottom").html("Current Order Total : $"+ total_order.toFixed(2));
        $("#fav_total_ord_dummy").val(total_order.toFixed(2)); 
        
        $("#fav_total_ord_dummy").val('0'); 
        $("#fav_total_car_dummy").val('0');
        
        $("#entered_cart_tot").val('0'); 
        $("#entered_ord_tot").val('0');
        
        $("#fav_total_ord_dummy_cs").val(total_order.toFixed(2)); 
        $("#fav_total_car_dummy_cs").val((add + Number(fav_total_car_dummy)) - Number(fav_total_car_entered));
        
        $("#fav_total_car_dummy_validat").val(add);
        
        $.ajax
        ({
            type: "POST",
            url: "admin/get_child.php",
            data: "session_cart=" + add + "&session_order=" + add_sub.toFixed(2),
            success: function(option)
            {

            }
        });
        
        
    });
});


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
 });
 
 function get_reference(auto_ref)
    {
        //alert(auto_ref);
        $("#jobref").val(auto_ref);
        $("#result_ref").hide();
        $.ajax
        ({
        type: "POST",
        url: "admin/get_child.php",
        data: "referece_set_fav=" + auto_ref,
        success: function(option)
        {

        }
        });
    }
    
function continue_shopping_fav(ID){
    var reference_val_fav       = $("#jobref").val(); 
    var fav_total_car_dummy     = $("#fav_total_car_dummy_cs").val(); 
    var fav_total_ord_dummy     = $("#fav_total_ord_dummy_cs").val();        
    {
        $.ajax
            ({
                type: "POST",
                url: "admin/get_child.php",
                data: "session_cart=" + fav_total_car_dummy+"&session_order="+fav_total_ord_dummy,
                success: function(option)
                {                            
                    window.location = "index.php?id="+ID+"&sub="+fav_total_ord_dummy+"&cart="+fav_total_car_dummy+"&refere="+reference_val_fav;

                }
            });
    }
}

function add_to_delete_list(ID){
    var fav_id = ID;
    var comp_id = document.getElementById("user_session_comp").value;
    if(fav_id != ''){        
        $.ajax
            ({
                type: "POST",
                url: "admin/get_child.php",
                data: "del_fav_front_id=" + fav_id+"&del_fav_front_comp_id="+comp_id,
                success: function(option)
                {   
                    if(option == true){
                    $("#fav_to_delete").val('1');
                    }else{
                    $("#fav_to_delete").val('0');   
                    }
                }
            });
    
    }
}

function delete_fav_items(COMP_ID)
{   
    var proceed_to_delete = document.getElementById('fav_to_delete').value;
    if(proceed_to_delete == '1'){
    var ok_to_delete = confirm("Are you sure?");
    if(ok_to_delete == true){
    $.ajax
        ({
            type: "POST",
            url: "admin/get_child.php",
            data: "fav_item_delete_comp=" + COMP_ID,
            beforeSend: loadStart,
            complete: loadStop,
            success: function(option)
            {                            
                window.location = "cus_favorites.php?dele_succ=1";

            }
        });
    }else{
        return false;
    }
    }
}

function loadStart() {
$('#loading').show();
}

function loadStop() {
$('#loading').hide();
}
</script>
     
     
     
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