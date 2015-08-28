<?php
include './config.php';
include './auth.php';
$id = $_GET['id'];
$editCategory = editCategory($id);

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Edit Category</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <style>.fancybox-inner{ width:288px !important; float:left !important; height:270px !important;}</style>
    </head>
    <body>

        <div id="popup_content"> <!--your content start-->
            <div id="msg" style="color:#007F2A; font-size: 13px;"></div>
            <div>&nbsp;</div>  
            <div>&nbsp;</div>              
            <form name="new_category" id="new_category" method="post" action="" >
            <input type="hidden" name="edi_cat" value="1" />       
            <input type="hidden" name="edi_cat_id" id="edi_cat_id" value="<?php echo $editCategory[0]['id']; ?>" />     
                <ul>                    
                    <li><label>Category</label><input type="text" autocomplete="off" name="category_name" id="category_name" value="<?php echo $editCategory[0]['category_name']; ?>" class="input_text" ></li>
                    <span class="check" style="color:#FF0000;padding-left:35px;font-size: 13px;"  ></span>  
                    <div>&nbsp;</div> 
                    <li><label>Status</label>
                        <div style="float:left; margin-top:5px;">
                            <input type="radio" name="status" id="status" value="1" <?php if($editCategory[0]['status'] =='1') echo 'checked'; ?>><p>Active</p><input type="radio" name="status" id="status" value="0" <?php if($editCategory[0]['status'] =='0') echo 'checked'; ?>><p>Deactive</p>			
                        </div>
                    </li>
                    <li><input type="submit" id="submit" value="" class="add_btn"></li>

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
    var category_name   = document.getElementById('category_name').value;    
    var status              = $('#status:checked').val();
    var id = document.getElementById('edi_cat_id').value;
	if(category_name != '')  
	 {
	  $.ajax
	  ({
	     type: "POST",
		 url: "update_category.php",
		 data: "category_name="+ category_name+"&status="+status+"&id="+id,
		 success: function(option)
		 {
		   $("#msg").html(option);
                   window.top.location = "category.php";
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
        $('#category_name').bind('keyup', function()
        {
            var edit_category_name = trim($(this).val());
            var id = document.getElementById('edi_cat_id').value;
            if (edit_category_name != '')
            {
                var dataString = 'edit_category_name=' + edit_category_name+'&id='+id;
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
                            $('.check').html('Category name already exist');
                            $('#submit').attr('disabled', true);
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