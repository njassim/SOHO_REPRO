<?php
include 'admin/config.php';
//Select Staff User For Drop Down
$select_staff = StaffUser();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Soho-repro</title>
<link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-family:Gotham, Helvetica, Arial, sans-serif;
	color:#5f5f5f; font-size:14px;
}
table, tr, td, th { margin:0px; padding:0px;}
img{ display:block;}
.login_box input[type="text"], .login_box input[type="password"]{ border:1px solid #aeaeae; width:270px; height:30px; float:left; background:#fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;}
.login_box input[type="submit"]{ background:url(images/btn_save.png) no-repeat; width:92px; height:34px; font-size:14px; border:0px; cursor:pointer; color:#fff; text-transform:uppercase; font-weight:bold;}
.login_box_label{ background:#fff; border:1px solid #d0d0d0; border-right:0px !important; padding-left:20px;}
.login_box_cont{ background:#f4f4f4; border:1px solid #d0d0d0; border-left:0px !important; padding: 0px 20px;}
.login_box_btn{ background:#f4f4f4; border:1px solid #d0d0d0; border-right:0px !important; padding-left:20px;}
.login_box_cont a{ float:right; color:#ff7e00; text-decoration:none; line-height: 34px;}
.login_box_cont a:hover{ text-decoration:underline;}
.login_box_cont span{ float:right; color:#ff7e00; text-decoration:none; line-height: 34px;}
.login_box_cont span:hover{ text-decoration:underline;cursor: pointer;}
.select_text_box{ border:1px solid #aeaeae; width:120px; height:30px; float:left; background:#fff; -webkit-border-radius: 5px;}
.alert {float:left; margin-left: 24px; line-height: 30px; color:#f00; margin-top:10px;}
.succ { float:left; margin-left: 24px; line-height: 30px; color:#007F2A; margin-top:10px;}
</style>
<script type="text/javascript" src="js/jquery.js"></script>
</head>

<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="640" align="center" valign="middle" style="background:url(images/bg_pattern.png) repeat">
    <table width="720" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="720" align="left" valign="top"><img src="images/login_box_top_crve.png" width="720" height="6" alt=""/></td>
      </tr>
      <tr>
        <td width="720" align="left" valign="top" style="background:url(images/login_box_cent_bg.png) repeat-y">
        <table width="720" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="218" height="226" align="center" valign="middle"><img src="images/logo_staff.jpg" width="198" height="181"  alt=""/></td>
            <td width="502" align="center" valign="top">
            <table width="502" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="42" align="left" valign="top">
                    <!--  Login Section Start -->
                    <?php 
                            if ($_REQUEST['type'] == '1')
                            {                            
                            extract($_POST);
                            $select_staff_details = StaffDetails($users);     
                            $_SESSION['supply_user_id']   = $select_staff_details[0]['id'];
                            $_SESSION['supply_user_name'] = $select_staff_details[0]['initials']; 
                            $_SESSION['supply_user_type'] = $select_staff_details[0]['type']; 
                            header("Location:supply_store.php");
                            exit;
                            }
                    ?>
                      <!--  Login Section End -->  
                    <div id="alert1" class="alert"></div>                    
                </td>
              </tr>
              <tr>
                <td align="center" valign="top">  
                     <form name="user_type" id="user_type" method="post" action=""  onsubmit="return validate();">
                                <input type="hidden" name="type" value="1" />   
                                <table width="456" border="0" cellspacing="0" cellpadding="0" class="login_box">
                              <tr>
                                <td width="120" height="48" align="left" valign="middle" class="login_box_label">Select Staff User</td>
                                <td height="48" align="left" valign="middle" class="login_box_cont" >
                                    <select name="users" id="users" class="select_text_box" >
                                        <option value="0">--Select User--</option> 
                                        <?php foreach ($select_staff as $staff){?>
                                        <option value="<?php echo $staff['id']; ?>"><?php echo $staff['initials']; ?></option>
                                        <?php } ?>
                                    </select> 
                                </td>
                              </tr>
                              <tr>
                                <td height="1" align="left" valign="middle"></td>
                                <td height="1"></td>
                              </tr>                              
                              <tr>
                                <td height="48" align="left" valign="middle" class="login_box_btn"></td>
                                <td height="48" align="left" valign="middle" class="login_box_cont">
                                    <input type="submit" value="Submit"></td>
                              </tr>
                              <tr>
                                <td height="1" align="left" valign="middle"></td>
                                <td height="1"></td>
                              </tr>
                            </table>
                         </form> 
                </td>
              </tr>
            </table>

            
            
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td width="720" align="left" valign="top"><img src="images/login_box_btm_crve.png" width="720" height="6" alt=""/></td>
      </tr>
    </table></td>
  </tr>
</table>
<script language="javascript">
function validate()
{
    if (document.user_type.users.value == '0')
    {
        document.getElementById("alert1").innerHTML = "Please Select the User";
        document.getElementById("users").focus();
        return false;
    }
    else
    {
        document.getElementById("alert1").innerHTML = "";
    }    
    return true;

}
</script>    
</body>
</html>