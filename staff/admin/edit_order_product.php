<?php

include './config.php';
include './auth.php';
$id = $_GET['id'];
$can_id = $_GET['can_id'];
$ord_id = $_GET['ord_id'];


$active_super_category = getSuperCategoryActive();
$editProductsName = editPdoructs($id);
$editProducts = editPdoructsOrder($id,$ord_id);
$active_category = getCategoryActive();
$ca_id = $editProducts[0]['category_id'];
$super_id = $editProducts[0]['supercategory_id'];
$active_sub_category = getSubCategoryActive($super_id,$ca_id);
$qty = getQty($id,$ord_id);
$price = getPriceE($id,$ord_id);
?> 
<!DOCTYPE html>
<html>
    <head>
        <title>Edit Sub Category</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        
    </head>
    <body>
 <div id="popup_content"> <!--your content start-->
               <div id="msg" style="color:#007F2A; font-size: 13px;"></div>
<form name="edit_products" id="edit_products" method="post" action="" >
<input type="hidden" name="edi_prod" value="1" />  
<input type="hidden" name="edi_order_prod_id" id="edi_order_prod_id" value="<?php echo $id; ?>" /> 
<input type="hidden" name="edi_order_j" id="edi_order_j" value="<?php echo $ord_id; ?>" /> 
<ul>
    <li><label>Super Category Name</label>
                            <select name="supercategory_name" id="supercategory_name" class="select_text" >                    
                            <option value="0" selected="selected">Select Super Category</option>
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
                            </select>
    </li>
    <li><label>Category Name</label>
                            <select name="category_name" id="category_name" class="select_text" >                    
                            <option value="0" selected="selected">Select Category</option>
                                <?php
                                foreach ($active_category as $categ) {
                                    if ($categ['id'] == $editProducts[0]['category_id']) {
                                        ?>
                                        <option value="<?php echo $categ['id'] ?>" selected="selected"><?php echo $categ['category_name']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $categ['id']; ?>"><?php echo $categ['category_name']; ?></option>
                                    <?php
                                    }
                                }
                                ?>
                            </select>
    </li>                    
    <li><label>Sub Category Name</label>                        
                            <select name="subcategory_name" id="subcategory_name" class="select_text" />                
                            <option value="0" selected="selected">Select Sub Category</option>
                            <?php
                            foreach ($active_sub_category as $subcateg) {
                                if ($subcateg['id'] == $editProducts[0]['subcategory_id']) {
                                    ?>               
                            <option value="<?php echo $subcateg['id'] ?>" selected="selected"><?php echo $subcateg['category_name']; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $subcateg['id'] ?>"><?php echo $subcateg['category_name']; ?></option>
                        <?php }
                    }
                    ?>
                    </select>
    </li>
    <li><label>Product Name</label>
                            <select name="product_name" id="product_name" class="select_text" />  
                            <option value="<?php echo $editProductsName[0]['id']; ?>" selected="selected"><?php echo $editProductsName[0]['product_name']; ?></option>                                                          
                            </select>
    </li>
    <li><label>Quantity</lable>
                       <input type="text" name="qty" id="qty" value="<?php echo $qty; ?>"/>
    </li>
    <li><label>Price</lable>
                       <input type="text" name="price" id="price" value="<?php echo $price; ?>"/>
    </li>
    <li><input type="submit" name="submit" id="submit" value="Save" /><!--<input type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:window.top.location='<?php //echo 'view_orders.php?id='.$can_id;?>'" style="margin-left:15px;" />-->
    </li>                                                                                                                                                                 
</ul>
</form>
</div>


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
                                $("#category_name").html(option);
                                $("#subcategory_name").html("<option value='0'>Select Sub Category</option>");
                                $("#product_name").html("<option value='0'>Select Products</option>");
                            }
                        });
            }
            else
            {
                $("#category_name").html("<option value='0'>Select Category Name</option>"); 
                $("#subcategory_name").html("<option value='0'>Select Sub Category</option>");
                $("#product_name").html("<option value='0'>Select Products</option>");
            }
            return false;
        });
        
$("#category_name").change(function()
  {
    var pcj_id = $(this).val();
	if(pcj_id != '0')  
	 {
	  $.ajax
	  ({
	     type: "POST",
		 url: "get_child.php",
		 data: "pcj_id="+ pcj_id,
		 success: function(option)
		 {
		   $("#subcategory_name").html(option);
		 }
	  });
	 }
	 else
	 {
	   $("#subcategory_name").html("<option value=''>-- No sub category selected --</option>");
	 }
	return false;
  });
  
  $("#subcategory_name").change(function()
  {
        var su_id = $('#supercategory_name').val();
        var c_id = $('#category_name').val();
        var sc_id = $(this).val();
	if(sc_id != '0')  
	 {
	  $.ajax
	  ({
	     type: "POST",
		 url: "get_child.php",
		 data: "c_id="+ c_id+"&sc_id="+sc_id+"&su_id="+su_id,
		 success: function(option)
		 {
		   $("#product_name").html(option);
		 }
	  });
	 }
	 else
	 {
	   $("#product_name").html("<option value=''>-- No sub category selected --</option>");
	 }
	return false;
  });
  
  
  $("form").submit(function()
  { 
    var product_id            = document.getElementById('product_name').value;
    var qty                   = document.getElementById('qty').value;
    var price                 = document.getElementById('price').value;
    var edi_order_j           = document.getElementById('edi_order_j').value;    
    var id                    = document.getElementById('edi_order_prod_id').value;   
    
	if(product_id != '')  
	 {
	  $.ajax
	  ({
	     type: "POST",
		 url: "get_child.php",
		 data: "product_id="+ product_id+"&qty="+ qty+"&id="+id+"&price="+price+"&edi_order_j="+edi_order_j,
		 success: function(option)
		 {
		   $("#msg").html(option);
                   window.top.location = "index.php";
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

</script>