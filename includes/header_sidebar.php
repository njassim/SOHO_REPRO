<?php
$page_names = explode("/", $_SERVER['SCRIPT_NAME']);
$pagename_pos = count($page_names) - 1;
$page_name_new = $page_names[$pagename_pos];
?>
<div id="content_usermeta">
    <div id="site-logo">
        <h1 class="site-logo"><a href="index.php" class="site-logo"><span>SOHO Repro Graphics</span><img src="store_files/logo-SOHO_Repro.gif" alt="SOHO Repro Graphics" height="182" width="205"></a></h1>
        <input type="hidden" name="usr_id" id="usr_id" value="<?php echo $_SESSION['sohorepro_userid']; ?>" />
    </div>

    <div style="border-top: 1px solid #EEEEEE;height:20px;padding-top:5px;font-size: 20px;color: #5C5C5C;font-weight: bold;"> 
        &nbsp;&nbsp;Existing Users   
    </div>
    <div id="user-status">        
        <div>
            <form action="" id="login_form" name="login_form" enctype="application/x-www-form-urlencoded" method="post">
                <input intvalue="Email Address" class="required logininput" name="email_id" id="email_id" placeholder="Email Address"
                       type="text" value="<?php
                       if (isset($_COOKIE['ck_sohorepro_email'])) {
                           echo $_COOKIE['ck_sohorepro_email'];
                       }
                       ?>" /><input intvalue="Password" class="required logininput" style="font-style:italic;" name="password" id="password" type="password" placeholder="Password" value="<?php
                       if (isset($_COOKIE['ck_sohorepro_pass'])) {
                           echo $_COOKIE['ck_sohorepro_pass'];
                       }
                       ?>"/><br />

                <div style="margin-left:14px;margin-top:-2px;font-size:11px;">
                    <a style="color:#e4e4e4" href="javascript:void(0);" onclick="show_forgot(0);">forgot my password</a>
                </div>

                <div style="margin: 9px 14px">
                    <input style="width: 12px;color: #fff;border:1px solid #8f8f8f;" name="rememberme" id="rememberme" type="checkbox" value="1" <?php if (isset($_COOKIE['ck_sohorepro_userid'])) { ?> checked="checked" <?php } ?> /><label style="font-size:11px; padding-left:4px;" for="rememberme" >Remember me on
                        this computer</label>
                </div><input style=
                             "font-size:12px; padding:1.5px; width: 100px;margin-left:14px;margin-top:5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;"
                             value="Sign in" type="submit" name="login_submit"/>
            </form>                                                                         
            <form action="" id="forgot_form" name="forgot_form" enctype="application/x-www-form-urlencoded" method="post" style="display:none;">
                <input intvalue="Email Address" class="required logininput" name="email_id" id="email_id" placeholder="Email Address"
                       type="text" />

                <input style="font-size:12px; padding:1.5px; width: 75px;margin-left:14px;margin-top:5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;"
                       value="Submit" type="submit" name="forgot_submit"/>

                <input style="font-size:12px; padding:1.5px; width: 75px;margin-left:14px;margin-top:5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;"
                       value="Cancel" type="button" name="cancel" onclick="show_forgot(1);"/>
            </form>
        </div>
        <div id="panalLoginHelp">
            <div class="sideheadline">                
                &nbsp;<a href="existing_customer.php" style="color: #853E00  !important;font-weight: bold;font-size: 17px;">Existing Account -<br>
                    &nbsp;New User Setup</a>
            </div>
            <div class="sideheadline" style="margin-top: 10px;">
                <!--                <a href="new_account_add.php" style="color: #853E00  !important;font-weight: bold;font-size: 17px;">
                                    &nbsp;Request New Account</a>                -->
                <span onclick="return check_log();" style="color: #853E00  !important;font-weight: bold;font-size: 17px;cursor: pointer;">&nbsp;Request New Account</span>
            </div>
<!--            <p style="margin-top:10px!important;">
                If you've ordered products or services with us, you have an account.
                If you don't remember your username or password, please feel free
                to call us at (212) 268-6522 or email us at support@sohorepro.com
            </p>
            <div class="sideheadline">New to Soho Repro?</div>
            <p style="margin-top:-5px!important;">
                <a href="sign_up.php">Sign up here</a> for a free account.
            </p>-->
        </div>

    </div>
    <div>
        <a href="http://sohorepro.com/plotter-equipment-maintenance-and-supplies/" target="_blank"><img src="./images/plotters.gif" style="border: 0px;width: 100%;" /></a>
    </div>
    <?php
    $specials       = Specials('3');
    if($specials == '1'){
    ?>
    <div style="background-color: #fff;border: 1px solid #000;border-bottom: 0px;text-align: center;padding-top: 15px;padding-bottom: 15px;">
        <a href="http://sohorepro.com/specials/" target="_blank" style="text-decoration: none;background: #009D59;padding: 10px;padding-left: 60px;padding-right: 60px;border-radius: 8px;color: #FFF;font-weight: bold;font-size: 17px;">SPECIALS</a>
    </div>
    <?php
    }
    ?>
</div>
<script>
    function check_log()
    {
        var usr_id = document.getElementById('usr_id').value;
        if (usr_id == '') {
            window.location = "new_account_add.php";
        } else {
            alert("Not permitted.");
            return false;
        }
    }
</script>