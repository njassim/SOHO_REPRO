<?php
include './config.php';
include './auth.php';
$id = $_GET['id'];
$editMail = editEmail($id);
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
            <form name="new_email" id="new_email" method="post" action="" onsubmit="return validate()" >
            <input type="hidden" name="edi_mail" value="1" />       
            <input type="hidden" name="edi_mail_id" id="edi_mail_id" value="<?php echo $editMail[0]['id']; ?>" />     
                <ul>                    
                    <li><label>Name</label><input type="text" autocomplete="off" name="name" id="name" value="<?php echo $editMail[0]['name']; ?>" class="input_text" ></li>
                    <span class="check" style="color:#FF0000;padding-left:35px;font-size: 13px;"  ></span>
                    <div id="msg1" style="color:#FF0000;padding-left:35px;font-size: 12px;"></div>
                    <div>&nbsp;</div> 
                    <li><label>Email ID</label><input type="text" autocomplete="off" name="email" id="email" value="<?php echo $editMail[0]['email_id']; ?>" class="input_text" ></li>
                    <span class="check" style="color:#FF0000;padding-left:35px;font-size: 13px;"  ></span>  
                    <div id="msg2" style="color:#FF0000;padding-left:35px;font-size: 12px;"></div>
                    <div id="msg3" style="color:#FF0000;padding-left:35px;font-size: 12px;"></div>
                    <div>&nbsp;</div> 
                    <li><label>Status</label>
                        <div style="float:left; margin-top:5px;">
                            <input type="radio" name="status" id="status" value="1" <?php if($editMail[0]['status'] =='1') echo 'checked'; ?>><p>Active</p><input type="radio" name="status" id="status" value="0" <?php if($editMail[0]['status'] =='0') echo 'checked'; ?>><p>Deactive</p>			
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
    var name    = document.getElementById('name').value;   
    var email   = document.getElementById('email').value;  
    var status  = $('#status:checked').val();
    var id = document.getElementById('edi_mail_id').value;
	if(name != '')  
	 {
	  $.ajax
	  ({
	     type: "POST",
		 url: "update_category.php",
		 data: "name="+ name+"&email="+email+"&status="+status+"&id="+id,
		 success: function(option)
		 {
		   $("#msg").html(option);
                   window.top.location = "email_settings.php";
		 }
	  });
	 }
	 else
	 {
	   //alert('test');
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
    
       
  function validate()
{

    if (document.new_email.name.value == '')
    {
        document.getElementById("msg1").innerHTML = "Enter the name";
        return false;
    }
    else
    {
        document.getElementById("msg1").innerHTML = "";
    }
    if (document.new_email.email.value == '')
    {
        document.getElementById("msg2").innerHTML = "Enter the email id";
        return false;
    }
    else
    {
        document.getElementById("msg2").innerHTML = "";
    }
    var input = document.getElementById('email').value;
    var expr = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if ( !expr.test(input)) 
    {  
     document.getElementById("msg3").innerHTML = "Enter the valid email id";
     return false; 
    }
    else
    {
        document.getElementById("msg3").innerHTML = "";
    }
    return true;

}      
</script>