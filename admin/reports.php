<?php
include './config.php';

$page=1;//Default page
$limit=25;//Records per page
$start=0;//starts displaying records from 0
if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
}
	$start=($page-1)*$limit;
if($_GET['limite']){
    $limit = $_GET['limite'];
}        
$order_report = getOrderReport($start,$limit);
$rows= count(ProductsCount());
$last_element = $_GET['page'];

?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Soho-repro</title>
        <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="style/pagination.css" rel="stylesheet" type="text/css" media="all" />
        <script src="../js/jquery.js" type="text/javascript" ></script>
        <!--<script src="js/core.js" type="text/javascript"></script>-->
    </head>

    <body>
        
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
                                            ORDER REPORT
                                            <span style="float: right;padding-right: 5px;">Welcome <?php if($_SESSION['admin_user_type'] == '1'){echo 'admin';} if($_SESSION['admin_user_type'] == '2'){echo 'Staff User';}?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
                                        </td>
                                    </tr>
                                    
                                    
                                  <tr>
                                        <td align="right" valign="top">
                                            
                                             
                                                <table width="759" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td width="35" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>
                                                        <td width="85" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Super category&nbsp;</td>
                                                        <td width="85" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Category&nbsp;</td>
                                                        <td width="85" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Sub category&nbsp;</td>
                                                        <td width="75" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Product name</td>
                                                        <td width="45" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Price</td>
                                                        <td width="45" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">SKU ID</td>
                                                    </tr>
                                                </table>
                                            <div id="load_userdata">
                                                <table width="759" border="0" cellspacing="0" cellpadding="0" class="tbl_repeatpro">
                                                    <?php
                                                    $i = 1;
                                                    if (count($order_report) > 0) {
                                                        if($last_element != '')
                                                            {
                                                              $i = ((($last_element*25) - 25)+1);                                                            
                                                            }  
                                                            else 
                                                            {
                                                              $i = 1 ; 
                                                            }
                                                        foreach ($order_report as $Prod) {
                                                            $cat_colspan=1;
                                                            $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                            $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                            $id = $Prod['cus_id'];
                                                            $report_supercat = $Prod['supercategory_id'];
                                                            $report_cat= $Prod['category_id'];
                                                            if($report_cat==0)
                                                            {
                                                                $cat_colspan=2;
                                                            }
                                                            $report_subcat = $Prod['subcategory_id'];
                                                            if($report_subcat==0 && $report_cat==0)
                                                            {
                                                                $cat_colspan=3;
                                                            }
                                                            $sku_id = $Prod['sku_id'];
                                                            $report_productname=$Prod['product_name'];
                                                            $report_productprice=$Prod['price'];
                                                            ?>
                                                    
                                                            <?php /* if($cat_colspan!=1) { ?> colspan="<?php echo $cat_colspan; ?>" <?php } */ ?>
                                                
                                                            <tr id="order_<?php echo $id; ?>">
                                                                <td width="35"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>
                                                                <td width="85" align="left" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm" style="padding-left: 5px;"><?php echo getSuperCategoryName($report_supercat); ?></td>
                                                                <td width="85" align="left" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="pad_btm" style="padding-left: 5px;"><?php echo getCategoryName($report_cat); ?></td>
                                                                <td width="85" style="padding-left: 5px;" align="left" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="pad_btm"><?php echo getSuperCategoryName($report_subcat); ?></td>
                                                                <td width="75"  align="left" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm" style="padding-left: 5px;"><?php echo $report_productname; ?></td>
                                                                <td width="24"  align="left" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm" style="padding-left: 5px;">$<?php echo $report_productprice; ?></td>                                                                
                                                                <td width="24"  align="left" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $sku_id; ?></td>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr align="center">
                                                            <td colspan="8">There is no orders</td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                               
                                            <?php


?>
<!--Pagination End-->
                                         </table>
                                            </div>   
                                            </td>
                                    </tr>
                                    <tr>
                                        <td><div style="float: left; margin-top: 20px;"><form method="post">
                                                    <select class="sel_limite" name="sortOrder" id="sortOrder" onchange="autosubmit();">                                                    
                                                        <option value="0">--</option>
                                                        <option value="50"  <?php if($_GET['limite'] == '50') { echo 'selected=select';} ?>>50</option>
                                                        <option value="75"  <?php if($_GET['limite'] == '75') { echo 'selected=select';} ?>>75</option>
                                                        <option value="100" <?php if($_GET['limite'] == '100'){ echo 'selected=select';} ?>>100</option>
                                                    </select>
                                                </form>
                                            </div>
                                            <?php echo Paginations($limit,$page,'reports.php?page=',$rows);?></td>
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
    function autosubmit()
    {
        var page = document.getElementById("sortOrder").value;
        if(page != 0)
        {
            window.location="reports.php?limite="+document.getElementById("sortOrder").value;
        }
    }
  </script>                


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
                    </script>

                    <script language="javascript">
                        function validate()
                        {

                            if (document.filter.category_name.value == '0')
                            {
                                document.getElementById("msg1").innerHTML = "Select category name";
                                return false;
                            }
                            else
                            {
                                document.getElementById("msg1").innerHTML = "";
                            }

                            return true;

                        }
                        
                        
                        
 $(function (){
      $(".tbl_repeatpro tbody").tableDnD({
		onDrop: function(table, row) {
			var orders = $.tableDnD.serialize();
			$.post('orderpro.php', { orders : orders });
                        if(true){
                            alert('Products order sorting');
                            $("#msg").html('Products order sorted successfully');
                            window.location = "products.php";
                        }
                }
	}); 
     
 });
                        
                    </script>
                                  
<script type="text/javascript" src="js/jquery.autocomplete.js"></script>
<link rel="stylesheet" href="js/jquery.autocomplete.css" type="text/css" />

<script type="text/javascript">
 

  function load_userinfo()
  {      	
        var cname = $( "#search_val" ).val();
        
        //alert(cname);
        var request = $.ajax({
          url: "load_user.php",
          type: "POST",
          data: { cid : cname },
          dataType: "html"
        });

        request.done(function( msg ) {
          //alert( msg );
          if(msg!='')
              {
                $('#load_userdata').html(msg);
              }
          else
              {
                $('#load_userdata').html(msg);    
              }
        });

        request.fail(function( jqXHR, textStatus ) {
            
        });
    
  }
 
    
  function findValue(li) {
  	if( li == null ) return alert("No match!");

  	// if coming from an AJAX call, let's use the CityId as the value
  	if( !!li.extra ) var sValue = li.extra[0];

  	// otherwise, let's just display the value in the text box
  	else var sValue = li.selectValue;

  	//alert("The value you selected was: " + sValue);
  }

  function selectItem(li) {
    	findValue(li);
  }

  function formatItem(row) {
    	return row[0];
  }

  function lookupAjax(){
  	var oSuggest = $("#search_val")[0].autocompleter;
    oSuggest.findValue();
  	return false;
  }
   

$( "#search_val" ).keypress(function() {
 
 var phoneval=$( "#search_val" ).val();
 //var test=phoneval.indexOf('_');
 //console.log( test );
    
//alert(phoneval.length);    
//console.log( phoneval.length );
$("#search_val").autocomplete(
      "load_user.php",
      {
  			delay:5,
  			minChars:1,
  			matchSubset:1,
  			matchContains:1,
  			cacheLength:10,
  			onItemSelect:selectItem,
  			onFindValue:findValue,
  			formatItem:formatItem,
  			autoFill:true
  		}
    );

    
});



  
</script>                    