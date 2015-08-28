<?php
include './config.php';

$sort_date      = ($_REQUEST['sort'] == 'a') ? 'd' : 'a';
$sort_date_img  = ($_REQUEST['sort'] == 'a') ? 'down' : 'up';

$sort_jrn   = ($_REQUEST['sort'] == 'jna') ? 'jnd' : 'jna';
$sort_jrn_img  = ($_REQUEST['sort'] == 'jna') ? 'down' : 'up';

$sort_prc   = ($_REQUEST['sort'] == 'pa') ? 'pd' : 'pa';
$sort_prc_img  = ($_REQUEST['sort'] == 'pa') ? 'down' : 'up';

$Orders = getOrdersAll($_REQUEST['sort']);

if ($_GET['delete_id']) {

    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM sohorepro_product_master WHERE id = " . $delete_id . " ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_del";
    } else {
        $result = "failure_del";
    }
}

if ($_GET['tax_status']) {

    $tax_id = $_GET['tax_status'];
    $sql = "UPDATE sohorepro_product_master SET tax_status = '0' WHERE order_id = " . $tax_id . " ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_tax";
    } else {
        $result = "failure_tax";
    }
}
          
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Soho-repro</title>
<link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
<style>
.pad_lft_j{ padding-left:20px; }
.pad_rght_j{ padding-right:15px; }
.brdr1{ border:1px solid #e1e1e1;}
.brdr-top_j{ border-top:0px !important;}
.brdr-lft_j{ border-left:0px !important;}
</style>
</head>
<body>    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top">
    <table width="960" border="0" cellspacing="0" cellpadding="0" style="min-width:760px;">
      <tr>
        <td width="198" align="left" valign="top" bgcolor="#464646"><table width="198" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="181" align="left" valign="top"><img src="images/logo.jpg" width="198" height="181"  alt=""/></td>
          </tr>
          <tr>
            <td align="left" valign="top">
                <?php include "sidebar_menu.php"; ?>
            </td>
          </tr>
          <tr>
            <td align="left" valign="middle" style="min-height:280px; float:left;"></td>
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
            OPEN ORDERS
            </td>
          </tr>
          <tr>
              <td>
                  <?php
                    if ($result == "success_del") {
                        ?>
                        <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Deleted Successfully</div>
                        <script>setTimeout("location.href=\'index.php\'", 1000);</script>
                        <?php
                    } elseif ($result == "failure_del") {
                        ?>
                        <div style="color:#F00; text-align:center; padding-bottom:10px;">Not Deleted</div>
                        <script>setTimeout("location.href=\'index.php\'", 1000);</script>       
                        <?php
                    }
                    ?>
                      <?php
                    if ($result == "success_tax") {
                        ?>
                        <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Tax has been removed in this order</div>
                        <script>setTimeout("location.href=\'index.php\'", 1000);</script>
                        <?php
                    } elseif ($result == "failure_tax") {
                        ?>
                        <div style="color:#F00; text-align:center; padding-bottom:10px;">Tax has been not removed in this order</div>
                        <script>setTimeout("location.href=\'index.php\'", 1000);</script>       
                        <?php
                    }
                    ?>
              </td>
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
    $('.trigger').click(function()
    {
        var val  = $(this).attr('id');
        if ($(this).is(':visible')) 
        {            
            $(this).next(".test_"+val).fadeToggle('slow').siblings(".test_"+val).hide(); 
        }
    });
    
    $('.inline').click(function()
    {
        var ID      =$(this).attr('id'); 
        $(".product_"+ID).hide(); 
        $(".quantity_"+ID).hide(); 
        $(".price_"+ID).hide(); 
        $(".delete_"+ID).hide();        
        $(".product_txt_"+ID).show(); 
        $(".quantity_txt_"+ID).show(); 
        $(".price_txt_"+ID).show(); 
        $(".update_"+ID).show();         
        $(".jass").attr("id",ID);        
    });
    
    $(document).mouseup(function()
    {
        var ID = $('.jass').attr('id');
        $(".product_"+ID).show(); 
        $(".quantity_"+ID).show(); 
        $(".price_"+ID).show(); 
        $(".delete_"+ID).show();  
        $(".product_txt_"+ID).hide(); 
        $(".quantity_txt_"+ID).hide(); 
        $(".price_txt_"+ID).hide(); 
        $(".update_"+ID).hide(); 
    });
    
    $('.reference').click(function()
    {               
        var OR_ID   = $(this).attr('id');        
        $(".ref_"+OR_ID).hide(); 
        $(".reference_txt_"+OR_ID).show();
        $(".ref_update_"+OR_ID).show();
        $(".ref_cancel_"+OR_ID).show();
        $(".jass2").attr("id",OR_ID);
    });
    
    $('.refcancel').click(function()
    {               
        var OR_ID   = $('.jass2').attr('id');       
        $(".ref_"+OR_ID).show(); 
        $(".reference_txt_"+OR_ID).hide();
        $(".ref_update_"+OR_ID).hide();
        $(".ref_cancel_"+OR_ID).hide();
    });
    
    $(function () {
        var ID = $('.jass').attr('id');    
        $("#quantity_txt_"+ID).keydown(function (event) {

            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

            } else {
                event.preventDefault();
            }
            
            if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                event.preventDefault();

        });
    });
    
    $(function () {
        var ID = $('.jass').attr('id');    
        $("#price_txt_"+ID).keydown(function (event) {

            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

            } else {
                event.preventDefault();
            }
            
            if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                event.preventDefault();

        });
    });


});
</script>

<script type="text/javascript">
$(document).ready(function()
{   
  $('.updater').click(function()
    {
       
        var ID                   = $('.jass').attr('id');          
        var order_id             = $('.order_id_t_'+ID).attr('id');
        var IID                  = document.getElementById('h_'+ID).value;        
        var product              = document.getElementById('product_txt_'+ID).value;
        var qty                  = document.getElementById('quantity_txt_'+ID).value;
        var price                = document.getElementById('price_txt_'+ID).value;
        
                if(price != '' && qty != '')  
	 {
	  $.ajax
	  ({
	     type: "POST",
		 url: "get_child.php",
		 data: "product="+product+"&qty="+qty+"&price="+price+"&id="+ID+"&iid="+IID+"&order_id="+order_id,
		 success: function(option)
		 {
		     var myarr = option.split("~");
                     
                     var line = (myarr[1] * myarr[2]);
                     $(".product_"+ID).html(myarr[0]); 
                     $(".quantity_"+ID).html(myarr[1]); 
                     $(".price_"+ID).html("$"+myarr[2]); 
                     $(".tax_"+ID).html("$"+myarr[5]); 
                     $(".line_cost_"+ID).html(myarr[7]); 
                     $(".line_"+ID).html("$"+myarr[6]);
                     $(".lineJassim_"+ID).html("$"+myarr[4]); 
                     $(".jassim_"+order_id).html("$"+myarr[4]); 
		 }
	  });
	 }
	 else
	 {
	   $(".error").html("Please fill the all fields"); 
	 }
	return false;
        
    });
  
  
  $('.refupdate').click(function()
    {
        var ID                      = $('.jass2').attr('id');  
        var reference               = document.getElementById('reference_txt_'+ID).value;
       
         if(reference != '')  
	 {
	  $.ajax
	  ({
	     type: "POST",
		 url: "get_child.php",
		 data: "reference="+reference+"&id="+ID,
		 success: function(option)
		 {
                    $(".ref_"+ID).html(option); 
                    $(".refj_"+ID).html(option); 
                    $(".ref_"+ID).show(); 
                    $(".reference_txt_"+ID).hide();
                    $(".ref_update_"+ID).hide();
                    $(".ref_cancel_"+ID).hide();
		 }
	  });
	 }
	 else
	 {
	   $(".error").html("Please fill the all fields"); 
	 }
	return false;
        
    });
  
  
});

</script>