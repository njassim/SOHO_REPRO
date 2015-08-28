<?php
include './config.php';
include './auth.php';
$id = $_GET['id'];
$editProducts = edituser($id);
if ($_REQUEST['edi_prod'] == '1') {
    extract($_POST);
    $sql = "UPDATE sohorepro_customers
			SET     cus_fname    = '" . mysql_real_escape_string($user_fname) . "',
                                cus_lname    = '" . mysql_real_escape_string($user_lname) . "',
                                cus_email           = '" . mysql_real_escape_string($user_email) . "',   
				cus_status          = '" . $status . "' WHERE cus_id = " . $id . " ";

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
                                        <td align="left" valign="top"><table width="198" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#7a7878" class="lft_menu"><a href="index.php">Orders</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#A6A6A6" class="lft_menu "><a href="supercategory.php">Super category</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#aeaeae" class="lft_menu "><a href="category.php">category</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#9d9c9c" class="lft_menu "><a href="subcategory.php">Sub category</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#8b8b8b" class="lft_menu"><a href="products.php">ProductS</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#7e7e7e" class="lft_menu active"><a href="customers.php">Customers</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#7a7878" class="lft_menu"><a href="email_settings.php">Email Settings</a></td>
                                                </tr>
                                            </table></td>
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
                                        <td height="38" align="center" valign="middle" bgcolor="#8b8b8b" class="sub_heading">EDIT USER</td>
                                    </tr>


                                    <tr>
                                        <td height="30" align="center" valign="top">
                                            <?php
                                            if ($result == "success") {
                                                ?>
                                                <div style="color:#007F2A; text-align:center; padding-bottom:10px;">User Successfully Updated</div>
                                                <script>setTimeout("location.href=\'customers.php\'", 1000);</script>
                                                <?php
                                            } elseif ($result == "failure") {
                                                ?>
                                                <div style="color:#F00; text-align:center; padding-bottom:10px;">User Not Updated Successfully</div>
                                                <script>setTimeout("location.href=\'customers.php\'", 1000);</script>       
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
                                                        <td height="1" align="left" valign="middle"></td>
                                                        <td height="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="48" align="left" valign="middle" class="add_prod_label">First Name</td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont"><input type="text" name="user_fname" id="user_fname" autocomplete="off" value="<?php echo $editProducts[0]['cus_fname']; ?>" ><div id="msg3" style="color:#FF0000"></div> </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td height="48" align="left" valign="middle" class="add_prod_label">Last Name</td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont"><input type="text" name="user_lname" id="user_lname" autocomplete="off" value="<?php echo $editProducts[0]['cus_lname']; ?>" ><div id="msg3" style="color:#FF0000"></div> </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="1" align="left" valign="middle"></td>
                                                        <td height="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="48" align="left" valign="middle" class="add_prod_label">Email id</td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont"><input type="text" name="user_email" id="user_email" autocomplete="off" value="<?php echo $editProducts[0]['cus_email']; ?>" ><div id="msg4" style="color:#FF0000"></div> </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="1" align="left" valign="middle"></td>
                                                        <td height="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="48" align="left" valign="middle" class="add_prod_label">Status</td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont">
                                                            <div style="float:left; margin-top:5px;"><input type="radio" name="status" value="1" <?php if ($editProducts[0]['cus_status'] == '1') echo 'checked'; ?> ><p>Active</p><input type="radio" name="status" value="0" <?php if ($editProducts[0]['cus_status'] == '0') echo 'checked'; ?>><p>Inactive</p>			
                                                            </div><div id="msg5" style="color:#FF0000"></div> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="1" align="left" valign="middle"></td>
                                                        <td height="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="48" align="left" valign="middle" class="add_produ_btn"></td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont"><input type="submit" name="submit" id="submit" value="Save" /> <input type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:window.location='<?php echo 'customers.php';?>'" style="margin-left:15px;" /></td>
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
                                                       
                                                        if (document.edit_products.user_name.value == '')
                                                        {
                                                            document.getElementById("msg3").innerHTML = "Enter the User Name";
                                                            str = false;
                                                        }
                                                        if (document.edit_products.user_email.value == '')
                                                        {
                                                            document.getElementById("msg4").innerHTML = "Enter the Email id";
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
                                $("#category_name").html(option);
                                $("#subcategory_name").html("<option value='0'>Select Sub Category</option>");
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
});
</script>