<?php
include './config.php';
$active_category = getSuperCategoryActive();
$id = $_GET['id'];
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Add Product For Customer</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <style>.fancybox-inner{height:375px !important;}</style>
    </head>
    <body>

        <div id="popup_content"> <!--your content start-->
               <div id="msg" style="color:#007F2A; font-size: 13px;"></div>
            <form name="new_prod_cus" id="new_prod_cus" method="post" action="">
                <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $id; ?>" />  
                <input type="hidden" name="edi_sub_cat_id" id="edi_sub_cat_id" value="<?php echo $editSubCategory[0]['id']; ?>" />  
                <div>&nbsp;</div>  
            <div>&nbsp;</div> 
                <ul>
                    <?php
                    if ($result == "success") {
                        ?>
                        <div style="color:#16F20F; text-align:center; padding-bottom:10px; display: none;">Sub-category updated successfully</div>
                        <script>setTimeout("location.href=\'subcategory.php\'", 2000);</script>
                        <?php
                    } elseif ($result == "failure") {
                        ?>
                        <div style="color:#F00; text-align:center; padding-bottom:10px; display: none;">Sub-category updated not successfully</div>
                        <script>setTimeout("location.href=\'subcategory.php\'", 2000);</script>       
                        <?php
                    }
                    ?>                       
                    <li><label>Super Category</label>
                    <select name="supercategory_name" id="supercategory_name" class="select_text" >
                        <option value="0">Select Super Category</option>
                        <?php foreach ($active_category as $categ) { ?>
                            <option value="<?php echo $categ['id'] ?>"><?php echo $categ['category_name']; ?></option>
                        <?php } ?>
                    </select><div id="msg6" style="color:#FF0000"></div>
                    </li>
                    <li><label>Category Name</label>
                        <select name="category_name" id="category_name" class="select_text" /> 
                            <option value="0">Select Category</option>
                        </select><div id="msg1" style="color:#FF0000"></div> 
                    </li>                    
                    <li><label>Sub Category Name</label>
                        <select name="subcategory_name" id="subcategory_name" class="select_text" /> 
                        <option value="0">Select Sub Category</option>
                        </select><div id="msg2" style="color:#FF0000"></div> 
                    </li>
                    <li><label>Product Name</label>
                        <select name="product_name" id="product_name" class="select_text" /> 
                        <option value="0">Select Product</option>
                        </select><div id="msg2" style="color:#FF0000"></div> 
                    </li>
                    <li><label>List Price</label>
                        <select name="list_price" id="list_price" class="select_text" /> 
                        <option value="0">Select Price</option>
                        </select><div id="msg2" style="color:#FF0000"></div> 
                    </li>
                    <li><label>Discount(%)</label>
                        <input type="text" name="discount" id="discount" class="input_text" />                            
                        <div id="msg2" style="color:#FF0000"></div> 
                    </li>
                    <li><input type="submit" id="edit_sub" value=""  class="add_btn"></li>

                </ul>
            </form>
        </div>
    </body>
</html>

<script type="text/javascript">
$(document).ready(function()
{
  $("form").submit(function()
  {      
    
    var customer_id        = document.getElementById('customer_id').value;
    var product_name       = document.getElementById('product_name').value;
    var list_price         = document.getElementById('list_price').value;
    var discount           = document.getElementById('discount').value;
    //alert(customer_id+'AND'+product_name+'AND'+list_price+'AND'+discount);
    
	if(discount != '')  
	 {
	  $.ajax
	  ({
	     type: "POST",
		 url: "update_category.php",
		 data: "customer_id="+ customer_id+"&product_name="+ product_name+"&list_price="+list_price+"&discount="+discount,
		 success: function(option)
		 {
		   $("#msg").html(option);
                   window.top.location = "customers.php";
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
                            data: "super_id_prod=" + super_id_prod+"&jassim="+super_id_prod,
                            success: function(option)
                            {
                                var myarr       = option.split("#");
                                var category    = myarr[0];
                                var product     = myarr[1];
                                var price       = myarr[2];
                                $("#category_name").html(category);
                                $("#subcategory_name").html("<option value='0'>Select Sub Category</option>");
                                $("#product_name").html(product);
                                $("#list_price").html(price);                             
                            }
                        });
            }
            else
            {
                $("#category_name").html("<option value='0'>Select Category Name</option>"); 
                $("#subcategory_name").html("<option value='0'>Select Sub Category</option>");
                $("#product_name").html("<option value='0'>Select Product</option>");
                $("#list_price").html("<option value='0'>Select Price</option>");
            }
            return false;
        });
        
        
       $("#category_name").change(function()
        {
            var cate_id = $(this).val();
            var super_id_sub_prod      = $('#supercategory_name').val();
            if (super_id_sub_prod != '0')
            {
                $.ajax
                        ({
                            type: "POST",
                            url: "get_child.php",
                            data: "cate_id=" +cate_id+"&super_id_sub_prod=" + super_id_sub_prod,
                            success: function(option)
                            {
                                var myarr = option.split("#");                               
                                $("#subcategory_name").html(myarr[0]);
                                $("#product_name").html(myarr[1]);
                                $("#list_price").html(myarr[2]);   
                            }
                        });
            }
            else
            {
                $("#subcategory_name").html("<option value='0'>Select Subcategory</option>");               
            }
            return false;
        });
        
        
        $("#subcategory_name").change(function()
        {
            var scate_id = $(this).val();
            var super_id_sub_prod      = $('#supercategory_name').val();
            var super_id_sub_c_prod      = $('#category_name').val();
            if (super_id_sub_prod != '0')
            {
                $.ajax
                        ({
                            type: "POST",
                            url: "get_child.php",
                            data: "scate_id=" +scate_id+"&super_id_j=" + super_id_sub_prod+"&category_j="+super_id_sub_c_prod,
                            success: function(option)
                            {   
                                var myarr       = option.split("#");
                                var product     = myarr[1];
                                var price       = myarr[2];
                                $("#product_name").html(product);
                                $("#list_price").html(price);        
                            }
                        });
            }
            else
            {
                $("#subcategory_name").html("<option value='0'>Select Subcategory</option>");               
            }
            return false;
        });
        
        
        
        
    });
</script>

