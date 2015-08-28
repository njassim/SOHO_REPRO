<?php
include './config.php';
include './auth.php';
$id = $_GET['id'];
$editSubCategory = editCategory($id);
$active_category = getCategoryActive();

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Edit Sub Category</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <style>.fancybox-inner{height:375px !important;}</style>
    </head>
    <body>

        <div id="popup_content"> <!--your content start-->
               <div id="msg" style="color:#007F2A; font-size: 13px;"></div>
            <form name="new_subcategory" id="new_subcategory" method="post" action="">
                <input type="hidden" name="edi_subcat" value="1" />  
                <input type="hidden" name="edi_sub_cat_id" id="edi_sub_cat_id" value="<?php echo $editSubCategory[0]['id']; ?>" />  
                <div>&nbsp;</div>  
            <div>&nbsp;</div> 
                <ul>
                    <?php
                    if ($result == "success") {
                        ?>
                        <div style="color:#16F20F; text-align:center; padding-bottom:10px;">Sub-category updated successfully</div>
                        <script>setTimeout("location.href=\'subcategory.php\'", 2000);</script>
                        <?php
                    } elseif ($result == "failure") {
                        ?>
                        <div style="color:#F00; text-align:center; padding-bottom:10px;">Sub-category updated not successfully</div>
                        <script>setTimeout("location.href=\'subcategory.php\'", 2000);</script>       
                        <?php
                    }
                    ?>
                        <div>&nbsp;</div> 
                    <li><label>Sub Category</label><input type="text" autocomplete="off" name="subcategory_name" id="subcategory_name" class="input_text" value="<?php echo $editSubCategory[0]['category_name']; ?>" /></li>                    
                    <span class="check" style="color:#FF0000;padding-left:35px;font-size: 13px;"  ></span> 
                    <li><label>Category Name</label>
                        <select name="category_name" id="category_name" class="select_text" >
                            <?php
                            foreach ($active_category as $categ) {
                                if ($categ['id'] == $editSubCategory[0]['parent_id']) {
                                    ?>
                                    <option value="<?php echo $categ['id']; ?>" selected="selected"><?php echo $categ['category_name']; ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $categ['id']; ?>"><?php echo $categ['category_name']; ?></option>
                                <?php }
                            }
                            ?>
                        </select>
                    </li>
                    <div>&nbsp;</div> 
                    <li><label>Status</label>
                        <div style="float:left; margin-top:5px;">
                            <input type="radio" name="status" id="status" value="1" <?php if($editSubCategory[0]['status'] =='1') echo 'checked'; ?>><p>Active</p><input type="radio" name="status" id="status" value="0" <?php if($editSubCategory[0]['status'] =='0') echo 'checked'; ?>><p>Deactive</p>			
                        </div>
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
    //var pc_id = $(this).val();
    var sub_category_name   = document.getElementById('subcategory_name').value;
    var category_id         = document.getElementById('category_name').value;
    var status              = $('#status:checked').val();
    var id = document.getElementById('edi_sub_cat_id').value;
	if(sub_category_name != '')  
	 {
	  $.ajax
	  ({
	     type: "POST",
		 url: "update_category.php",
		 data: "sub_category_name="+ sub_category_name+"&category_id="+ category_id+"&status="+status+"&id="+id,
		 success: function(option)
		 {
		   $("#msg").html(option);
                   window.top.location = "subcategory.php";
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
    $(function()
    {
        $('#subcategory_name').bind('keyup', function()
        {
            var edit_subcategory_name = trim($(this).val());
            var id = document.getElementById('edi_sub_cat_id').value;
            if (edit_subcategory_name != '')
            {
                var dataString = 'edit_subcategory_name=' + edit_subcategory_name+'&id='+id;
                $.ajax({
                    type: "POST",
                    url: "check_catename_exist.php",
                    data: dataString,
                    cache: false,
                    success: function(result)
                    {
                        var result = trim(result);
                        if (result == '1')
                        {
                            $('.check').html('sub category name already exist');
                            $('#edit_sub').attr('disabled', true);
                            //$('#submit').attr('value', 'Deactive');
                            $('#titleExist').attr("value", "1");
                        }
                        else
                        {
                            $('#titleExist').attr("value", "0");
                            $('.check').html('');
                            $('#submit').attr('disabled', false);
                            //$('#submit').attr('value', 'Active');
                        }
                    }
                });
            }
        });
    });
    function trim(str) {
        var str = str.replace(/^\s+|\s+$/, '');
        return str;
    }
</script>

<!--<script language="javascript">
                                                                            function validate()
                                                                            {
                                                                                var str = true;
                                                                                document.getElementById("msg1").innerHTML = "";
                                                                                document.getElementById("msg2").innerHTML = "";
                                                                                document.getElementById("msg3").innerHTML = "";

                                                                                if (document.new_subcategory.category_name.value == '0')
                                                                                {
                                                                                    document.getElementById("msg1").innerHTML = "Select the category name";
                                                                                    str = false;
                                                                                }
                                                                                if (document.new_subcategory.subcategory_name.value == '')
                                                                                {
                                                                                    document.getElementById("msg2").innerHTML = "Enter the sub category name";
                                                                                    str = false;
                                                                                }

                                                                                if ((document.new_subcategory.status[0].checked == '') && (document.new_subcategory.status[1].checked == ''))
                                                                                {
                                                                                    document.getElementById("msg3").innerHTML = "Select the status";
                                                                                    str = false;
                                                                                }

                                                                                return str;

                                                                            }
</script>-->