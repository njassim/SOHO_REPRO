<?php
include './config.php';
include './auth.php';

$id = $_GET['id'];
$editProducts = editPdoructs($id);
$active_super_category = getSuperCategoryActiveA();
$active_category = getCategoryActive();
$super_id = $editProducts[0]['supercategory_id'];
$ca_id = $editProducts[0]['category_id'];
$active_sub_category = getSubCategoryActive($super_id,$ca_id);
if ($_REQUEST['edi_prod'] == '1') {
    extract($_POST);
    $sql = "UPDATE sohorepro_products
			SET     supercategory_id = '".$supercategory_name."', 
                                category_id     = '" . $category_name . "',
                                subcategory_id  = '" . $subcategory_name . "',                               
                                product_name    = '" . mysql_real_escape_string($product_name) . "',
                                list_price      = '" . $price. "',
                                discount        = '" . $discount. "',   
                                price           = '" . $sell_price . "',  
				status          = '" . $status . "' WHERE id = " . $id . " ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success";
    } else {
        $result = "failure";
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
                                        <td height="38" align="center" valign="middle" bgcolor="#8b8b8b" class="sub_heading">EDIT PRODUCTS
                                        <span style="float: right;padding-right: 5px;">Welcome <?php if($_SESSION['admin_user_type'] == '1'){echo 'admin';} if($_SESSION['admin_user_type'] == '2'){echo 'Staff User';}?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td height="30" align="center" valign="top">
                                            <?php
                                            if($_GET['page'] != ''){
                                                    $page1 = 'page='.$_GET['page'];
                                                }
                                            if($_GET['filter'] == '1'){
                                                    $super_id_f = $_GET['superc_id'];
                                                    $cat_id_f = $_GET['cat_id'];
                                                    $sub_id_f = $_GET['sub_id'];
                                                    $page_f   = $_GET['page_filter'];
                                                    $page_filter = 'filter=1&superc_id='.$super_id_f.'&cat_id='.$cat_id_f.'&sub_id='.$sub_id_f.'&page_filter='.$page_f;
                                                }
                                            if($_GET['search'] != ''){
                                                    $search      = $_GET['search'];
                                                    $page_search = $_GET['page_search'];
                                                    $search_link = 'search='.$search.'&page_search='.$page_search;
                                                }   
                                            if ($result == "success") {                                                
                                                ?>
                                                <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Product Successfully Updated</div>
                                                <script>setTimeout("location.href=\'products.php?<?php echo $page1.$page_filter.$search_link; ?>\'", 1000);</script>
                                                <?php
                                            } elseif ($result == "failure") {
                                                ?>
                                                <div style="color:#F00; text-align:center; padding-bottom:10px;">Product Not Updated Successfully</div>
                                                <script>setTimeout("location.href=\'products.php?<?php echo $page1.$page_filter.$search_link; ?>\'", 1000);</script>       
                                                <?php
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <form name="edit_products" id="edit_products" method="post" action=""  onsubmit="return validate()" >
                                                <input type="hidden" name="edi_prod" value="1" />  
                                                <input type="hidden" name="edi_prod_id" id="edi_prod_id" value="<?php echo $editProducts[0]['id']; ?>" />        
                                                <table width="759" border="0" cellspacing="0" cellpadding="0" class="add_product">
                                                    <tr>
                                                        <td width="180" height="48" align="left" valign="middle" class="add_prod_label">Super Category Name</td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont">
                                                            <select name="supercategory_name" id="supercategory_name" class="select_text" >                                                               
                                                                <?php 
                                                                foreach ($active_super_category as $categ) { 
                                                                   if ($categ['id'] == $editProducts[0]['supercategory_id']) {
                                                                        ?>
                                                                        <option value="<?php echo $categ['id'] ?>" selected="selected"><?php echo $categ['category_name']; ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $categ['id']; ?>"><?php echo $categ['category_name']; ?></option>
                                                                    <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select><div id="msg6" style="color:#FF0000"></div> 
                                                    </tr>                                               
                                                    
                                                    <tr>
                                                        <td width="180" height="48" align="left" valign="middle" class="add_prod_label">Category Name</td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont">
                                                            <select name="category_name" id="category_name" class="select_text" >                    
                                                                <?php
                                                                if($editProducts[0]['category_id'] == '0'){?>
                                                                       <option value='0'>Select Category</option> 
                                                                <?php }
                                                                if($editProducts[0]['category_id'] != '0'){
                                                                foreach ($active_category as $categ) {
                                                                    if ($categ['id'] == $editProducts[0]['category_id']) {
                                                                        ?>
                                                                        <option value="<?php echo $categ['id'] ?>" selected="selected"><?php echo $categ['category_name']; ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $categ['id']; ?>"><?php echo $categ['category_name']; ?></option>
                                                                    <?php
                                                                    }
                                                                }
                                                                }
                                                                ?>
                                                            </select><div id="msg1" style="color:#FF0000"></div> 
                                                    </tr>
                                                    <tr>
                                                        <td height="1" align="left" valign="middle"></td>
                                                        <td height="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="48" align="left" valign="middle" class="add_prod_label">Sub Category Name</td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont">
                                                            <select name="subcategory_name" id="subcategory_name" class="select_text" />                
                                                            <?php
                                                            if($editProducts[0]['subcategory_id'] == '0'){?>
                                                                       <option value='0'>Select Sub-Category</option> 
                                                                <?php }
                                                            if($editProducts[0]['subcategory_id'] != '0'){
                                                            foreach ($active_sub_category as $subcateg) {
                                                                if ($subcateg['id'] == $editProducts[0]['subcategory_id']) {
                                                                    ?>               
                                                            <option value="<?php echo $subcateg['id'] ?>" selected="selected"><?php echo $subcateg['category_name']; ?></option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $subcateg['id'] ?>"><?php echo $subcateg['category_name']; ?></option>
                                                        <?php }
                                                    }
                                                            }
                                                    ?>
                                                    </select><div id="msg2" style="color:#FF0000"></div> 
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="1" align="left" valign="middle"></td>
                                                        <td height="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="48" align="left" valign="middle" class="add_prod_label">Product Name</td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont"><input type="text" name="product_name" id="product_name" autocomplete="off" value="<?php echo htmlentities(stripslashes($editProducts[0]['product_name']));?>" ><div id="msg3" style="color:#FF0000"></div> </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="1" align="left" valign="middle"></td>
                                                        <td height="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="48" align="left" valign="middle" class="add_prod_label">List Price</td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont"><input type="text" name="price" id="price" autocomplete="off" value="<?php echo $editProducts[0]['list_price']; ?>" ><div id="msg4" style="color:#FF0000"></div> </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="1" align="left" valign="middle"></td>
                                                        <td height="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="48" align="left" valign="middle" class="add_prod_label">Discount(%)</td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont"><input type="text" name="discount" id="discount" autocomplete="off" class="discount_key" value="<?php echo $editProducts[0]['discount']; ?>" ><div id="msg8" style="color:#FF0000"></div> </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="1" align="left" valign="middle"></td>
                                                        <td height="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="48" align="left" valign="middle" class="add_prod_label">Sell Price</td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont"><input type="text" name="sell_price" id="sell_price" autocomplete="off" class="selling_key" value="<?php echo $editProducts[0]['price']; ?>" ><div id="msg9" style="color:#FF0000"></div> </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="1" align="left" valign="middle"></td>
                                                        <td height="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="48" align="left" valign="middle" class="add_prod_label">Status</td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont">
                                                            <div style="float:left; margin-top:5px;"><input type="radio" name="status" value="1" <?php if ($editProducts[0]['status'] == '1') echo 'checked'; ?> ><p>Active</p><input type="radio" name="status" value="0" <?php if ($editProducts[0]['status'] == '0') echo 'checked'; ?>><p>Inactive</p>			
                                                            </div><div id="msg5" style="color:#FF0000"></div> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="1" align="left" valign="middle"></td>
                                                        <td height="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="48" align="left" valign="middle" class="add_produ_btn"></td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont"><input type="submit" name="submit" id="submit" value="Save" /> <input type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:window.location='<?php echo 'products.php?'.$page1.$page_filter.$search_link;?>';" style="margin-left:15px;" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="1" align="left" valign="middle"></td>
                                                        <td height="1"></td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td style="background:#464646; text-align:center; color:#fff; line-height:30px;" height="30p">© 2013 sohorepro.com</td>
            </tr>
        </table>
    </body>
</html>

<script language="javascript">
                                                    function validate()
                                                    {
                                                        var str = true;
                                                        document.getElementById("msg1").innerHTML = "";
                                                        document.getElementById("msg2").innerHTML = "";
                                                        document.getElementById("msg3").innerHTML = "";
                                                        document.getElementById("msg4").innerHTML = "";
                                                        document.getElementById("msg5").innerHTML = "";
                                                        document.getElementById("msg5").innerHTML = "";
                                                        
                                                        if (document.new_products.supercategory_name.value == '0')
                                                        {
                                                            document.getElementById("msg6").innerHTML = "Select the Super Category Name";
                                                            str = false;
                                                        }
                                                        if (document.edit_products.category_name.value == '0')
                                                        {
                                                            document.getElementById("msg1").innerHTML = "Select the Category Name";
                                                            str = false;
                                                        }
                                                        if (document.edit_products.subcategory_name.value == '0')
                                                        {
                                                            document.getElementById("msg2").innerHTML = "Select the Sub-Category Name";
                                                            str = false;
                                                        }
                                                        if (document.edit_products.product_name.value == '')
                                                        {
                                                            document.getElementById("msg3").innerHTML = "Enter the Product Name";
                                                            str = false;
                                                        }
                                                        if (document.edit_products.price.value == '')
                                                        {
                                                            document.getElementById("msg4").innerHTML = "Enter the Price";
                                                            str = false;
                                                        }

                                                        if ((document.edit_products.status[0].checked == '') && (document.new_products.status[1].checked == ''))
                                                        {
                                                            document.getElementById("msg5").innerHTML = "Select the Status";
                                                            str = false;
                                                        }

                                                        return str;

                                                    }
</script>


<script type="text/javascript">
$(document).ready(function()
{
   $("#supercategory_name").change(function()
        {
            var super_id_prod = $(this).val();  
            if (super_id_prod != '0')
            {
                $.ajax
                        ({
                            type: "POST",
                            url: "get_child.php",
                            data: "super_id_prod=" + super_id_prod,
                            success: function(option)
                            {
                                if(option != ''){
                                $("#category_name").html(option);
                                $("#subcategory_name").html("<option value='0'>Select Sub Category</option>");
                                }else{
                                $("#category_name").html("<option value='0'>Select Category</option>");
                                $("#subcategory_name").html("<option value='0'>Select Sub Category</option>");   
                                }
                            }
                        });
            }
            else
            {
                $("#category_name").html("<option value='0'>Select Category Name</option>"); 
                $("#subcategory_name").html("<option value='0'>Select Sub Category</option>");
            }
            return false;
        });
        
$("#category_name").change(function()
  {
    var pc_id = $(this).val();
	if(pc_id != '0')  
	 {
	  $.ajax
	  ({
	     type: "POST",
		 url: "get_child.php",
		 data: "pc_id="+ pc_id,
		 success: function(option)
		 {
                   if(option != ''){  
		   $("#subcategory_name").html(option);
                   }else{
                   $("#subcategory_name").html("<option value='0'>Select Sub Category</option>");      
                   }
		 }
	  });
	 }
	 else
	 {
	   $("#subcategory_name").html("<option value=''>-- No sub category selected --</option>");
	 }
	return false;
  });
  
  
   $('.discount_key').keyup(function (event){ 
            var list            = document.getElementById('price').value;
            var discount        = document.getElementById('discount').value;
            var price           = (discount * (list/100));
            var sell_price      = (list - price);
            $("#discount").val(discount);
            $("#sell_price").val(sell_price.toFixed(2));
            if(discount < 0){
                $("#discount").css('color','#F00');
            }else{
                $("#discount").css('color','#000');
            }
        });
    
        $('.selling_key').keyup(function (event){       
            var list            = document.getElementById('price').value;
            var selling         = document.getElementById('sell_price').value;        
            var discount        = (((list - selling) / list)*100);
            $("#discount").val(discount.toFixed(2));
            $("#sell_price").val(selling);
            if(discount < 0){
                $("#discount").css('color','#F00');
            }else{
                $("#discount").css('color','#000');
            }
        });
  
  
  
  
});
</script>