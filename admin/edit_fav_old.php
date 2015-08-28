<?php
include './config.php';
include './auth.php';
$comp_id = $_GET['comp_id'];
$editfav = ALLFAV($comp_id);

if (isset($_REQUEST['Delete'])) {
    $cnt = array();
    $cnt = count($_POST['delete_val']);
    for ($i = 0; $i < $cnt; $i++) {
        $id = $_POST['delete_val'][$i];
        $query = "DELETE FROM sohorepro_favorites WHERE id = '" . $id . "'";
        $result = mysql_query($query);
        if ($result) {
            ?>
            <script> window.top.location = "customers.php";</script>
            <?php
        }
    }
}
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
            <div style="float: left;width: 100%;text-align: right;padding-bottom: 10px;"><input type="submit" name="Delete" value="REMOVE" style="background: #00979D;color: #FFF;padding: 5px 10px;border-radius: 7px;font-weight: bold;cursor: pointer;" /></div>
            <table align="left" width="100%">
                <tr bgcolor="#ff7e00">
                    <td>Product Name</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <?php
                $i = 1;
                foreach ($editfav as $fav){ 
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
                ?>
                <tr bgcolor="<?php echo $rowColor; ?>">
                    <td align="left" valign="middle" class="brdr_1" style="font-size: 15px;">
                        <?php echo $product_name.'<br>'; ?>
                        <span class="trail" style="font-size: 11px;color: #2a9be3;"><?php echo $super_name.$cat_name.$sub_name;  ?></span>  
                    </td>
                    <td align="center"><input class="check_val" type="checkbox" name="delete_val[]" value="<?php echo $id; ?>" /></td>
                </tr>
                <?php } ?>
            </table>
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