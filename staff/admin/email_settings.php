<?php
include './config.php';
include './auth.php';
$Email = getEmail();

if ($_REQUEST['new_mail'] == '1') {
    extract($_POST);    
    $sql = "INSERT INTO sohorepro_email
			SET     name = '" . $name . "',
                                email_id = '" . $email . "',
				status = '" . $status . "' ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success";
    } else {
        $result = "failure";
    }
}

if ($_GET['delete_id']) {

    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM sohorepro_email WHERE id = " . $delete_id . " ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_del";
    } else {
        $result = "failure_del";
    }
}



if ($_GET['status_id']) {

    $change_status = ($_GET['change_id'] == 1) ? '0' : '1';
    $status_id = $_GET['status_id'];
    $sql = "UPDATE sohorepro_email
			SET     status     = '" . $change_status . "' WHERE id= '" . $status_id . "'";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_status";
    } else {
        $result = "failure_status";
    }
}

$sql_order_sequence     = mysql_query("SELECT id,order_sequence FROM sohorepro_order_master ORDER BY id DESC LIMIT 1");
$object_order_sequence  = mysql_fetch_assoc($sql_order_sequence);
$sequence_id            = $object_order_sequence['id'];
$sequence               = $object_order_sequence['order_sequence'];
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Soho-repro</title>
        <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>

        <!-- Add fancyBox main JS and CSS files -->
        <script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery.fancybox.css?v=2.1.5" media="screen" />



        <script type="text/javascript">
            $(document).ready(function() {
                /**  Simple image gallery. Uses default settings*/
                $('.fancybox').fancybox();

                /**  Different effects */
            });
        </script>
        <!--End -->
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
                                            SETTINGS
                                            <span style="float: right;padding-right: 5px;">Welcome <?php if($_SESSION['admin_user_type'] == '1'){echo 'admin';} if($_SESSION['admin_user_type'] == '2'){echo 'Staff User';}?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="14" align="left" valign="middle"></td>
                                    </tr>                                    
                                    <tr>
                                        <td align="right" valign="top">
                                            <table width="759" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="38" align="left" valign="middle" class="add_title">Add email id's</td>
                                                </tr>
                                                <tr>
                                                    <td height="60" align="right" valign="top" bgcolor="#f6f6f6" class="form_bg">
                                                        <form name="new_email" id="new_subcategory" method="post" action=""  onsubmit="return validate();" >

                                                            <input type="hidden" name="new_mail" value="1" />  
                                                            <input type="hidden" name="mail_temp" id="mail_temp" value="0" />  
                                                            <table width="759" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td width="125" height="60" align="right" style="font-size:12px;" valign="middle">Enter Name</td>
                                                                    <td width="160" height="60" align="right" valign="middle"><input type="text" autocomplete="off" name="name" id="name" class="input_text" ></td>
                                                                    <td width="172" height="60" align="left" valign="middle"><input type="text" autocomplete="off" name="email" id="email" value="Enter email id" onfocus="if(this.value == 'Enter email id'){this.value = '';}" onblur="if(this.value == ''){this.value='Enter email id';}" class="input_text" ></td>
                                                                    <td width="60" height="60" align="right" style="font-size:12px;" valign="middle">Status&nbsp;</td>
                                                                    <td width="20" height="60" align="left" valign="middle"><input type="radio" name="status" value="1" checked="checked" ></td>
                                                                    <td width="50" height="60" align="left" style="font-size:12px;" valign="middle">Active</td>
                                                                    <td width="20" height="60" align="left"  valign="middle"><input type="radio" name="status" value="0"  ></td>
                                                                    <td width="70" height="60" align="left" style="font-size:12px;" valign="middle">InActive</td>
                                                                    <td width="90" height="60" align="left" valign="middle"><input type="submit" value="" id="submit" class="add_btn"></td>
                                                                </tr> 
                                                                <tr>
                                                                    <td width="125" height="60" align="right" style="font-size:12px;" valign="middle">Order Number Sequence</td>
                                                                    <td width="160" height="60" align="right" valign="middle"><input type="text" autocomplete="off" name="sequence_id" id="sequence_id" class="input_text" value="<?php echo $sequence; ?>" ></td>                                                                    
                                                                    <td width="172"><img src="images/btn_setorder.png" title="Set Order Sequence" alt="Set Order Sequence" onclick="return order_seq(<?php echo $sequence_id; ?>);" style="cursor: pointer;margin-left: 10px;" /></td>                                                                    
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="9" height="38" style="color:#F00; text-align:center; padding-bottom:10px; font-size: 12px;">

                                                                        <?php
                                                                        if ($result == "success") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Email id inserted successfully</div>
                                                                            <script>setTimeout("location.href=\'email_settings.php\'", 2000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Email id insert not successfully</div>
                                                                            <script>setTimeout("location.href=\'email_settings.php\'", 2000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($result == "success_del") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Deleted successfully</div>
                                                                            <script>setTimeout("location.href=\'email_settings.php\'", 2000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_del") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Not deleted</div>
                                                                            <script>setTimeout("location.href=\'email_settings.php\'", 2000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($result == "success_status") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Status change successfully</div>
                                                                            <script>setTimeout("location.href=\'email_settings.php\'", 2000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_status") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Status change not successfully</div>
                                                                            <script>setTimeout("location.href=\'email_settings.php\'", 2000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>                                                                            


                                                                        <div id="msg1" style="color:#FF0000;padding-left:12px;font-size: 12px;"></div>
                                                                        <div id="msg2" style="color:#FF0000;padding-left:12px;font-size: 12px;"></div>
                                                                        <div id="msg3" style="color:#FF0000;padding-left:12px;font-size: 12px;"></div>
                                                                        <div id="msg4" style="color:#FF0000;padding-left:12px;font-size: 12px;"></div>
                                                                        <span id="msg5" style="color:#FF0000;padding-left:12px;font-size: 12px;"></span>
                                                                        <span id="msg6" style="color:#007F2A;padding-left:12px;font-size: 12px;"></span>
                                                                        <span class="check" style="color:#FF0000;padding-left:12px;font-size: 12px; display: none;"  ></span>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </form>
                                                    </td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top">
                                            <table width="759" border="0" cellspacing="0" cellpadding="0">

                                                <tr>
                                                    <td width="736" align="left" valign="middle" style="padding-left:20px;"> 

                                                    </td>
                                                    <td height="15" align="right" valign="middle">&nbsp;</td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top">                                           

                                            <!-- Products Start -->
                                            <table width="759" border="0" cellspacing="0" cellpadding="0">

                                                <tr>
                                                    <td width="20" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>
                                                    <td width="150" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Name</td>
                                                    <td width="120" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Email id</td>
                                                    <td width="40" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">status</td>
                                                    <td width="40" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                if (count($Email) > 0) {
                                                    foreach ($Email as $Mail) {
                                                        $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                        $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                        $status = ($Mail['status'] == 1) ? 'active' : 'de-active';
                                                        $id = $Mail['id'];
                                                        ?>
                                                        <tr>
                                                            <td width="49"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>
                                                            <td width="150" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><?php echo $Mail['name']; ?></td>
                                                            <td width="60" align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="pad_btm"><?php echo $Mail['email_id']; ?></td>
                                                            <td width="60"  align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><a href="email_settings.php?status_id=<?php echo $id; ?>&change_id=<?php echo $Mail['status']; ?>" onclick="return confirm('Are you sure?');"><img src="images/<?php echo $status; ?>.png" width="22" height="22"  alt=""/></a></td>
                                                            <td width="80"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm">
                                                                <a class="fancybox fancybox.iframe" href="edit_email.php?id=<?php echo $id; ?>"><img src="images/edit.png"  alt="" width="22" height="22"/></a><a href="email_settings.php?delete_id=<?php echo $id; ?>" onclick="return confirm('Are you sure?');"><img src="images/del.png"  alt="" width="22" height="22" class="mar_lft"/></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    ?>
                                                    <tr align="center">
                                                        <td colspan="8">There is no mail id's</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>

                                            </table></td>
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

                            if (document.new_email.name.value == '')
                            {
                                document.getElementById("msg1").innerHTML = "Enter the name";
                                return false;
                            }
                            else
                            {
                                document.getElementById("msg1").innerHTML = "";
                            }
                            if (document.new_email.email.value == 'Enter email id')
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
                            var input_mail = document.getElementById('email').value;
                            if (input_mail != '')
                            {                               
                                $.ajax
                                        ({
                                            type: "POST",
                                            url: "get_child.php",
                                            data: "mail_id=" + input_mail,
                                            success: function(option)
                                            {
                                                if(option == '1'){
                                                document.getElementById("msg4").innerHTML = "Email id already exist."; 
                                                }                                               
                                                  
                                            }
                                        });
                                 return false;        
                            }
                            
                            return true; 
                            
                        }
                        
                        
                        function order_seq(sequence_id)
                        {
                            var sequence    = document.getElementById('sequence_id').value; 
                            if (sequence != '')
                                {                               
                                $.ajax
                                    ({
                                        type: "POST",
                                        url: "get_child.php",
                                        data: "sequence_id=" + sequence_id+"&sequence="+sequence,
                                        success: function(option)
                                        {
                                             var order_result = option.split("~");                                            
                                             $("#sequence_id").val(order_result[1]);
                                             document.getElementById("msg6").innerHTML = order_result[0];
                                             $('#msg6').hide(3000);
                                        }
                                    });
                                }
                                else
                                {
                                             document.getElementById("msg5").innerHTML = "Order number should not be empty";                                              
                                }
                        
                        }
                        
                        
                    </script>