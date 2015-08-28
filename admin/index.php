<?php 
include './config.php';
include './mail_template.php';

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
            <td width="218" height="226" align="center" valign="middle"><img src="images/logo_admin.jpg" width="198" height="181"  alt=""/></td>
            <td width="502" align="center" valign="top">
            <table width="502" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="42" align="left" valign="top">
                    <!--  Login Section Start -->
                    <?php 
                        if ($_REQUEST['user_cred'] == '1')
                        {
                            extract($_POST);    
                            $user = mysql_real_escape_string($username);
                            $pass = base64_encode($password);
                            if($user != '' && $pass != ''){
                            $check_user = CheckUser($user,$pass);
                            if(count($check_user) > 0)
                                {
                                $_SESSION['admin_user_id']   = $check_user[0]['id'];
                                $_SESSION['admin_user_name'] = $check_user[0]['user_name']; 
                                $_SESSION['admin_user_type'] = $check_user[0]['type']; 
                                header("Location:open_orders_service.php");
                                exit;
                                }
                            else 
                                {
                            ?>
                                <div id="alert1" class="alert">Username and password are mismatch.</div>      
                            <?php
                                }
                                }  
                            else 
                                {                                
                                ?>
                                <div id="alert1" class="alert">Username and password should not empty.</div>      
                                <?php
                                }
                         }
                    ?>
                      <!--  Login Section End -->          
                      <!--  Forgot Section Start -->          
                      <?php
                      if ($_REQUEST['e_mail'] == '1')
                      {
                          extract($_POST);
                          //Check Mail Exist or not
                          $mail_id = mail_exist($email);
                          if(count($mail_id) != ''){
                              $send_mail = forgot_mail($mail_id);
                              if($send_mail == '1'){
                                  ?>                                
                                <div class="alert">Login details sent successfully</div> 
                                <script>setTimeout("location.href=\'index.php\'", 1000);</script>
                    <?php
                      }
                      }  else {                          
                      ?>
                         <div class="alert">Email not found</div> 
                         <script>setTimeout("location.href=\'index.php\'", 1000);</script>       
                    <?php
                      }
                      }
                      ?>
                      <!--  Forgot Section End -->  
                    <div id="alert1" class="alert"></div>                    
                </td>
              </tr>
              <tr>
                <td align="center" valign="top">                  
                 <!-- Login Section Start -->
                 <div id="login_section">
                     <form name="login" id="login" method="post" action=""  onsubmit="return validate();">
                                <input type="hidden" name="user_cred" value="1" />       
                                <table width="456" border="0" cellspacing="0" cellpadding="0" class="login_box">
                              <tr>
                                <td width="120" height="48" align="left" valign="middle" class="login_box_label">User Name</td>
                                <td height="48" align="left" valign="middle" class="login_box_cont" ><input type="text" name="username" id="username" autocomplete="off" ></td>
                              </tr>
                              <tr>
                                <td height="1" align="left" valign="middle"></td>
                                <td height="1"></td>
                              </tr>
                              <tr>
                                  <td height="48" align="left" valign="middle" class="login_box_label">Password</td>
                                <td height="48" align="left" valign="middle" class="login_box_cont" ><input type="password" name="password" id="password" ></td>
                              </tr>
                              <tr>
                                <td height="1" align="left" valign="middle"></td>
                                <td height="1"></td>
                              </tr>
                              <tr>
                                <td height="48" align="left" valign="middle" class="login_box_btn"></td>
                                <td height="48" align="left" valign="middle" class="login_box_cont">
                                    <input type="submit" value="Login">
                                    <span class="forgot">Forgot Password?</span>
                                </td>
                              </tr>
                              <tr>
                                <td height="1" align="left" valign="middle"></td>
                                <td height="1"></td>
                              </tr>
                            </table>
                         </form>                     
                </div>
                <!-- Login Section End -->    
                
                <!-- Forgot Password Start -->
                <div id="forgotpass_section" style="display: none;">
                    <form name="forgot" id="forgot" method="post" action=""  onsubmit="return validate_forgot();">
                        <input type="hidden" name="e_mail" value="1" /> 
                <table width="456" border="0" cellspacing="0" cellpadding="0" class="login_box">
              <tr>
                <td width="120" height="48" align="left" valign="middle" class="login_box_label">Email Id</td>
                <td height="48" align="left" valign="middle" class="login_box_cont" ><input type="text" name="email" id="email" /></td>
              </tr>
              <tr>
                <td height="1" align="left" valign="middle"></td>
                <td height="1"></td>
              </tr>
              
              <tr>
                <td height="48" align="left" valign="middle" class="login_box_btn"></td>
                <td height="48" align="left" valign="middle" class="login_box_cont">
                    <input type="submit" value="Submit">
                    <input type="submit" class="cancel_forgot" value="Cancel" style="margin-left: 10px;">
                </td>
              </tr>
              <tr>
                <td height="1" align="left" valign="middle"></td>
                <td height="1"></td>
              </tr>
            </table>
                    </form>
                </div>
                 <!-- Forgot Password End -->       
                    
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
$(document).ready(function()
{
    $('.forgot').click(function()
    {        
        $('#forgotpass_section').css("display","inline-block");
        $('#login_section').css("display","none");
    });
    
    $('.cancel_forgot').click(function()
    {  
        $('#forgotpass_section').css("display","none");
        $('#login_section').css("display","inline-block");
    });
    
});

function validate()
{
    if (document.login.username.value == '')
    {
        document.getElementById("alert1").innerHTML = "Please Enter the Username";
        document.getElementById("username").focus();
        return false;
    }
    else
    {
        document.getElementById("alert1").innerHTML = "";
    }
    if (document.login.password.value == '')
    {
        document.getElementById("alert1").innerHTML = "Please Enter the Password";
        document.getElementById("password").focus();
        return false;
    }
    else
    {
        document.getElementById("alert1").innerHTML = "";
    }
    return true;

}


function validate_forgot()
{
    if (document.forgot.email.value == '')
    {
        document.getElementById("alert1").innerHTML = "Please Enter the Mail id";
        document.getElementById("email").focus();
        return false;
    }
    else
    {
        document.getElementById("alert1").innerHTML = "";
    }
    
    var x       =   document.forgot.email.value;
    var atpos   =   x.indexOf("@");
    var dotpos  =   x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
    {
    document.getElementById("alert1").innerHTML = "Not a valid e-mail address";        
    document.getElementById("email").focus();
    return false;
    }
    return true;

}


</script>   
  
    
</body>
</html>
