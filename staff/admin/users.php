<?php
include './config.php';
include './mail_template.php';
include './auth.php';
$all_users  = AllUsers();

if ($_REQUEST['new_usr'] == '1') {
    extract($_POST); 
    $init = strtoupper($initials);
    $sql = "INSERT INTO sohorepro_users
			SET     user_name   = '" . $user_name . "',
                                password    = '" . base64_encode($pass_word) . "',
                                initials    = '" . $init."',
				email       = '" . $user_name . "',
                                type        = '" . $user_type . "',
                                status      = '1' ";

    $sql_result = mysql_query($sql);
    $send_mail = forgot_mail($user_name);
    if ($sql_result) {
        $result = "success";
    } else {
        $result = "failure";
    }
}
//Status Change Start
if ($_GET['status_id']) {

    $change_status = ($_GET['change_id'] == 1) ? '0' : '1';
    $status_id = $_GET['status_id'];
    $sql = "UPDATE sohorepro_users
			SET     status     = '" . $change_status . "' WHERE id= '" . $status_id . "'";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_status";
    } else {
        $result = "failure_status";
    }
}
//Status Change End

//Delete Start
if ($_GET['delete_id']) {

    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM sohorepro_users WHERE id = " . $delete_id . " ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_del";
    } else {
        $result = "failure_del";
    }
}
//Delete End


?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Soho-repro</title>
        <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
        <!-- Add fancyBox main JS and CSS files -->
        <script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>

        <!-- Add fancyBox main JS and CSS files -->
        <script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery.fancybox.css?v=2.1.5" media="screen" />
        <style>
            .textbox{border:1px solid #aeaeae; width:100px; height:30px; float:left; background:#fff; -webkit-border-radius: 5px}
            .textbox_initals{border:1px solid #aeaeae; width:35px; height:30px; text-transform: uppercase; float:left; background:#fff; -webkit-border-radius: 5px}
            .select_text_box{ border:1px solid #aeaeae; width:100px; height:30px; float:left; background:#fff; -webkit-border-radius: 5px;}
            .usr_tbl{font-size: 14px;}
        </style>


        <script type="text/javascript">
            $(document).ready(function() {
                /**  Simple image gallery. Uses default settings*/
                $('.fancybox').fancybox();

                /**  Different effects */
            });
        </script>
        <!--End -->       
        <script src="js/jquery.tablednd_0_5.js" type="text/javascript"></script>
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
                                            USERS
                                            <span style="float: right;padding-right: 5px;">Welcome <?php if($_SESSION['admin_user_type'] == '1'){echo 'admin';} if($_SESSION['admin_user_type'] == '2'){echo 'Staff User';}?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="14" align="left" valign="middle"></td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><table width="759" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="38" align="left" valign="middle" class="add_title">Add new user</td>
                                                </tr>
                                                <tr>
                                                    <td height="60" align="center" valign="middle" bgcolor="#f6f6f6" class="form_bg">
                                                        <form name="new_user" id="new_user" method="post" action=""  onsubmit="return validate();" >
                                                            <input type="hidden" name="new_usr" value="1" />       
                                                            <table border="0" style="margin-left: 5px;" width="750" border="0" cellspacing="0" cellpadding="0">
                                                                <tr align="left">
                                                                    <td style="font-size: 13px;">User Name :</td>
                                                                    <td align="left"><input type="text" name="user_name" id="user_name" class="textbox" onblur="return usr_chk();" /></td>
                                                                    <td style="font-size: 13px;">Password :</td>
                                                                    <td align="left"><input type="password" name="pass_word" id="pass_word" class="textbox" /></td>
                                                                    <td style="font-size: 13px;">Initials :</td>
                                                                    <td align="left"><input type="text" name="initials" id="initials" class="textbox_initals" /></td>
                                                                    <td style="font-size: 13px;">User Type :</td>
                                                                    <td style="font-size: 13px;" align="left">
                                                                        <select name="user_type" id="user_type" class="select_text_box" >
                                                                            <option value="0">Select Type</option>                                                                            
                                                                            <option value="2">Staff User</option>                                                                            
                                                                        </select>
                                                                    </td>
                                                                    <td align="left"><input type="submit" id="submit" value=" " class="add_btn"></td>
                                                                </tr>                                                                
                                                                <tr align="center" width="20px">
                                                                    <td colspan="7">
                                                                        <div id="msg1" style="color:#FF0000;font-size: 12px;"></div>
                                                                         <?php
                                                                        if ($result == "success") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">User Inserted Successfully</div>
                                                                            <script>setTimeout("location.href=\'users.php\'", 1000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">User Not Add Successfully</div>
                                                                            <script>setTimeout("location.href=\'users.php\'", 1000);</script>       
                                                                            <?php
                                                                        }
                                                                        //Status Aler Start
                                                                        if ($result == "success_status") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Status change successfully</div>
                                                                            <script>setTimeout("location.href=\'users.php\'", 1000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_status") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Status change not successfully</div>
                                                                            <script>setTimeout("location.href=\'users.php\'", 1000);</script>       
                                                                            <?php
                                                                        }
                                                                        //Status Aler End                                                                        
                                                                        //Delete Alert Start
                                                                        if ($result == "success_del") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Deleted Successfully</div>
                                                                            <script>setTimeout("location.href=\'users.php\'", 1000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_del") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Not Deleted</div>
                                                                            <script>setTimeout("location.href=\'users.php\'", 1000);</script>       
                                                                            <?php
                                                                        }
                                                                        //Delete Alert End
                                                                        ?>
                                                                    </td>                                                                        
                                                                </tr>
                                                            </table>                                                            
                                                        </form>   
                                                    </td>
                                                </tr> 
                                                
                                            </table></td>
                                    </tr>
                                    <tr>
                                        <td height="15" align="left" valign="top"></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <table width="759" border="0" cellspacing="0" cellpadding="0" class="usr_tbl">
                                                <tr>
                                                    <td width="80" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>
                                                    <td width="339" colspan="2" valign="middle" height="28" bgcolor="#f99b3e" align="left" class="td_brdr pad_lft">User Name&nbsp;</td>
                                                    <td width="200" colspan="2" valign="middle" height="28" bgcolor="#f99b3e" align="left" class="td_brdr pad_lft">Initials&nbsp;</td>
                                                    <td width="339" colspan="2" valign="middle" height="28" bgcolor="#f99b3e" align="left" class="td_brdr pad_lft">User Type&nbsp;</td>
                                                    <td width="100" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">status</td>
                                                    <td width="140" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                if(count($all_users) > 0){
                                                foreach ($all_users as $users)
                                                {
                                                    $rowColor   = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                    $rowColor1  = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                    $id         = $users['id'];
                                                    $init       = $users['initials'];;
                                                    $name       = $users['user_name'];
                                                    $type       = $users['type'];
                                                    $status     = ($users['status'] == 1) ? 'active' : 'de-active';
                                                        ?>
                                                        <tr>
                                                            <td width="80" height="36" align="center" bgcolor="<?php echo $rowColor; ?>" valign="middle"><?php echo $i; ?></td>
                                                            <td width="339" colspan="2" height="36" bgcolor="<?php echo $rowColor1; ?>" align="left" class="pad_lft" valign="middle"><?php echo $name; ?></td>
                                                            <td width="200" colspan="2" height="36" bgcolor="<?php echo $rowColor; ?>" align="left" class="pad_lft" valign="middle"><?php echo $init; ?></td>
                                                            <td width="339" colspan="2" height="36" bgcolor="<?php echo $rowColor1; ?>" align="left" class="pad_lft" valign="middle"><?php if($type == '2'){echo 'Staff User';} ?></td>
                                                            <td width="100" height="36" align="center" bgcolor="<?php echo $rowColor; ?>" valign="middle"><a href="users.php?status_id=<?php echo $id; ?>&change_id=<?php echo $users['status']; ?>" onclick="return confirm('Are you sure?');"><img src="images/<?php echo $status; ?>.png" width="22" height="22"  alt="Status" title="Status"/></a></td>
                                                            <td width="140" height="36" align="center" bgcolor="<?php echo $rowColor1; ?>" valign="middle">
                                                                <a class="fancybox fancybox.iframe" href="usr_edit.php?id=<?php echo $id; ?>"><img src="images/edit.png"  alt="Edit" title="Edit" width="22" height="22"/></a><a style="text-decoration: none;color:#000;" href="users.php?delete_id=<?php echo $id; ?>" onclick="return confirm('Are you sure?');"><img src="images/del.png"  alt="Delete" title="Delete" width="22" height="22" class="mar_lft"/></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                }
                                                }  else {                                                    
                                                    ?>
                                                    <tr>
                                                        <td bgcolor="#dfdfdf" colspan="9" align="center">There is no users</td>
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

<script language="javascript">
function validate()
{
    if (document.new_user.user_name.value == '')
    {
        document.getElementById("msg1").innerHTML = "Enter user mail id";
        document.getElementById("user_name").focus();
        return false;
    }
    else
    {
        document.getElementById("msg1").innerHTML = "";
    }
    
    var x       =   document.new_user.user_name.value;
    var atpos   =   x.indexOf("@");
    var dotpos  =   x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
    {
    document.getElementById("msg1").innerHTML = "Not a valid e-mail address";
    document.getElementById("user_name").value="";
    document.getElementById("user_name").focus();
    return false;
    }
    
    if (document.new_user.pass_word.value == '')
    {
        document.getElementById("msg1").innerHTML = "Enter the password";
        document.getElementById("pass_word").focus();        
        return false;
    }
    else
    {
        document.getElementById("msg1").innerHTML = "";
    }
    
    if (document.new_user.initials.value == '')
    {
        document.getElementById("msg1").innerHTML = "Enter the initials";
        document.getElementById("initials").focus();        
        return false;
    }
    else
    {
        document.getElementById("msg1").innerHTML = "";
    }    
    
    if (document.new_user.user_type.value == '0')
    {
        document.getElementById("msg1").innerHTML = "Select the user type";
        document.getElementById("user_type").focus();
        return false;
    }
    else
    {
        document.getElementById("msg1").innerHTML = "";
    }

    return true;

}

function usr_chk()
{
   var user_name =  document.getElementById("user_name").value;
   if(user_name != '')  
                    {
                     $.ajax
                     ({
                        type: "POST",
                            url: "get_child.php",
                            data: "user_name_ext="+ user_name,
                            success: function(option)
                            {
                                if(option == '1')
                                    {
                                        document.getElementById("msg1").innerHTML = "User mail id already exist";
                                        document.getElementById("user_name").focus();
                                        return false;
                                    }else{
                                        document.getElementById("msg1").innerHTML = "";
                                        return true;
                                    }                              
                            }
                     });
                    }
                    else
                    {
                        document.getElementById("msg1").innerHTML = "Enter user mail id";
                        document.getElementById("user_name").focus();
                        return false;
                    }
                    
}

</script>