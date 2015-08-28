<?php
include './config.php';
include './auth.php';
$UsersAll = NewUserList();

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




if ($_GET['status_id']) {

    $change_status = ($_GET['change_id'] == 1) ? '0' : '1';
    $status_id = $_GET['status_id'];
    $sql = "UPDATE sohorepro_company
			SET     status     = '" . $change_status . "' WHERE comp_id= '" . $status_id . "'";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_status";
    } else {
        $result = "failure_status";
    }
}


if ($_GET['archive_id']) {
    
    $archive_id = $_GET['archive_id'];

    $customer_info = getCustomeInfo($archive_id);

    $message = '<html>';
    $message .='<head>';
    $message .='<title></title>';
    $message .='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
    $message .='</head>';
    $message .='<body>';
    $message .='<table width="550" border="0" cellspacing="0" cellpadding="0">';
    $message .='<tr bgcolor="#ff7e00">';
    $message .='<td width="10" height="10" align="left" valign="top"></td>';
    $message .='<td height="10" align="left" valign="top"></td>';
    $message .='<td width="10" height="10" align="left" valign="top"></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
    $message .='<td align="left" valign="top">';
    $message .='<table width="530" border="0" cellspacing="0" cellpadding="0">';
    $message .='<tr>';
    $message .='<td width="20" height="20" align="left" valign="top"></td>';
    $message .='<td height="20" align="left" valign="top"></td>';
    $message .='<td width="20" height="20" align="left" valign="top"></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td width="20" align="left" valign="top"></td>';
    $message .='<td align="left" valign="top">';
    $message .='<table width="490" border="0" cellspacing="0" cellpadding="0">';
    $message .='<tr>';
    $message .='<td width="100" align="left" valign="top"><img src="http://supply.sohorepro.com/store_files/soho_logo.jpg" width="126" height="115" alt=""/></td>';
    $message .='<td width="40" align="left" valign="top"></td>';
    $message .='<td width="350" align="left" valign="top">';
    $message .='<table width="350" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';
    $message .='<tr>';
    $message .='<td height="25" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;">Dear ' . $customer_info[0]['comp_name'] . ',</br></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">';
    $message .='<table>';
    $message .='<tr>';
    $message .='<td>Your account has been deactivated, Please contact admin</td>';
    $message .='</tr>';    
    $message .='</table>';
    $message .='</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444; padding-top:10px;">Thanks</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">The SohoRepro Team</td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
    $message .='<td width="20" align="left" valign="top"></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td height="20" align="left" valign="top"></td>';
    $message .='<td height="20" align="left" valign="top"></td>';
    $message .='<td height="20" align="left" valign="top"></td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
    $message .='<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
    $message .='</tr>';
    $message .='<tr bgcolor="#ff7e00">';
    $message .='<td width="10" height="10" align="left" valign="top"></td>';
    $message .='<td height="10" align="left" valign="top"></td>';
    $message .='<td width="10" height="10" align="left" valign="top"></td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</body>';
    $message .='</html>';


    $subject = 'Your account has been deactivated - SohoRepro';
    $headers = 'From: "SohoRepro" <no-reply@sohorepro.com>' . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $mail_id = $customer_info[0]['comp_contact_email'];
    //$mail_id = 'n.mohamedjassim@gmail.com';
    $result = mail($mail_id, $subject, $message, $headers);

    $sql = "UPDATE sohorepro_company
			SET     archive     = '1' WHERE comp_id= '" . $archive_id . "'";
    $sql_result = mysql_query($sql);
    
//    $sql_delete_shipp = "DELETE FROM sohorepro_address WHERE comp_id = " . $archive_id . " ";
//    mysql_query($sql_delete_shipp);
    
    if ($sql_result) {
        $result = "success_status";
    } else {
        $result = "failure_status";
    }
}


if ($_GET['active_id']) {

    $active_id = $_GET['active_id'];

    $customer_info = getCustomeInfo($active_id);

    $message = '<html>';
    $message .='<head>';
    $message .='<title></title>';
    $message .='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
    $message .='</head>';
    $message .='<body>';
    $message .='<table width="550" border="0" cellspacing="0" cellpadding="0">';
    $message .='<tr bgcolor="#ff7e00">';
    $message .='<td width="10" height="10" align="left" valign="top"></td>';
    $message .='<td height="10" align="left" valign="top"></td>';
    $message .='<td width="10" height="10" align="left" valign="top"></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
    $message .='<td align="left" valign="top">';
    $message .='<table width="530" border="0" cellspacing="0" cellpadding="0">';
    $message .='<tr>';
    $message .='<td width="20" height="20" align="left" valign="top"></td>';
    $message .='<td height="20" align="left" valign="top"></td>';
    $message .='<td width="20" height="20" align="left" valign="top"></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td width="20" align="left" valign="top"></td>';
    $message .='<td align="left" valign="top">';
    $message .='<table width="490" border="0" cellspacing="0" cellpadding="0">';
    $message .='<tr>';
    $message .='<td width="100" align="left" valign="top"><img src="http://supply.sohorepro.com/store_files/soho_logo.jpg" width="126" height="115" alt=""/></td>';
    $message .='<td width="40" align="left" valign="top"></td>';
    $message .='<td width="350" align="left" valign="top">';
    $message .='<table width="350" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';
    $message .='<tr>';
    $message .='<td height="25" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;">Dear ' . $customer_info[0]['comp_contact_name'] . ',</br></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">';
    $message .='<table>';
    $message .='<tr>';
    $message .='<td>Your account has been approved. You must add at least one user to your account by clicking on the link below:</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td><a href="http://cipldev.com/supply.sohorepro.com/existing_customer.php" target="_blank">http://cipldev.com/supply.sohorepro.com/existing_customer.php</a></td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444; padding-top:10px;">Thanks,</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">SohoRepro</td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
    $message .='<td width="20" align="left" valign="top"></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td height="20" align="left" valign="top"></td>';
    $message .='<td height="20" align="left" valign="top"></td>';
    $message .='<td height="20" align="left" valign="top"></td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
    $message .='<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
    $message .='</tr>';
    $message .='<tr bgcolor="#ff7e00">';
    $message .='<td width="10" height="10" align="left" valign="top"></td>';
    $message .='<td height="10" align="left" valign="top"></td>';
    $message .='<td width="10" height="10" align="left" valign="top"></td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</body>';
    $message .='</html>';


    $subject = 'Account Approved - Soho Repro';
    $headers = 'From: "SohoRepro" <no-reply@sohorepro.com>' . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $mail_id = $customer_info[0]['comp_contact_email'];
    //$mail_id = 'n.mohamedjassim@gmail.com';
    $result = mail($mail_id, $subject, $message, $headers);


    $sql = "UPDATE sohorepro_company
			SET     status = '1' WHERE comp_id= '" . $active_id . "'";
    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_status_active";
    } else {
        $result = "failure_status_active";
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
        <script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>

        <!-- Add fancyBox main JS and CSS files -->
        <script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery.fancybox.css?v=2.1.5" media="screen" />
        <style>
            .pointer{
                cursor: pointer;
            }

            div.close {
                background: url("../img/closebox.png") no-repeat scroll 0 0 transparent;
                bottom: 24px;
                cursor: pointer;
                float: right;
                height: 30px;
                left: 27px;
                position: relative;
                width: 30px;
            }

            span.ecs_tooltip {
                background: none repeat scroll 0 0 #000000;
                border-radius: 2px 2px 2px 2px;
                color: #FFFFFF;
                display: none;
                font-size: 11px;
                height: 16px;
                opacity: 0.7;
                padding: 4px 3px 2px 5px;
                position: absolute;
                right: -62px;
                text-align: center;
                top: -51px;
                width: 93px;
            }

            div.login_loader {
                background: url("../img/login_loader.gif") no-repeat scroll 0 0 transparent;
                height: 100px;
                width: 100px;
                display: none;
                z-index: 1000;
                top: 45%;
                left: 45%;
                position:absolute;
            }

            #backgroundPopup {
                z-index:1;
                position: fixed;
                display:none;
                height:100%;
                width:100%;
                background:#000000;
                top:0px;
                left:0px;
            }

            #about_info{
                font-family: "lucida grande",tahoma,verdana,arial,sans-serif;
                background: none repeat scroll 0 0 #FFFFFF;
                border: 3px solid #F99B3E;
                border-radius: 3px 3px 3px 3px;
                color: #333333;
                display: none;
                font-size: 14px;
                left: 37%;
                position: fixed;
                top: 20%;
                width: 325px;
                z-index: 2;
            }
             .comp_dtls_arc span{
                float: left;
                width: 100%;
            }
        </style>


        <script type="text/javascript">
            $(document).ready(function() {
                
                 $('.trigger').click(function()
                {                   
                    var val  = $(this).attr('id');
                    if ($(this).is(':visible')) 
                    {               
                    $(this).next(".test_"+val).fadeToggle('slow').siblings(".test_"+val).hide(); 
                }
                });
                
                
                
                /**  Simple image gallery. Uses default settings*/
                $('.fancybox').fancybox();

                /**  Different effects */
                $("div.close").hover(
                        function() {
                            $('span.ecs_tooltip').show();
                        },
                        function() {
                            $('span.ecs_tooltip').hide();
                        }
                );
                $("div.close").click(function() {
                    disablePopup(); // function close pop up
                });

                $("div#backgroundPopup").click(function() {
                    disablePopup(); // function close pop up
                });

                $(this).keyup(function(event) {
                    if (event.which == 27) { // 27 is 'Ecs' in the keyboard
                        disablePopup(); // function close pop up
                    }
                });
            });

            function get_info(ID)
            {
                loading(); // loading
                setTimeout(function() { // then show popup, deley in .5 second
                    About_Info_Popup(); // function show popup 
                }, 500); // .5 second 
                $.ajax
                        ({
                            type: "POST",
                            url: "get_customer_informations.php",
                            data: "customer_id=" + ID,
                            beforeSend: loading,
                            complete: closeloading,
                            success: function(option)
                            {
                                var res = option.split("~");
                                $('#Contact_Name').html(res[0]);
                                $('#Contact_Email').html(res[1]);
                                $('#Company_Name').html(res[2]);
                                $('#Company_Phone').html(res[3]);
                                $('#Company_Fax').html(res[16]);
                                $('#Address_1').html(res[4]);
                                $('#Address_2').html(res[5]);
                                $('#Room').html(res[6]);
                                $('#City').html(res[7]);
                                $('#State').html(res[8]);
                                $('#Zip').html(res[9]);
                                $('#Phone_1').html(res[10]);
                                $('#Phone_2').html(res[11]);
                                $('#Phone_3').html(res[12]);
                                $('#Phone_4').html(res[13]);
                                $('#resale_certificate').html(res[14]);
                                $('#exempt_use_certificate').html(res[15]);
                            }
                        });
            }

            function Invite_User(ID)
            {
                $.ajax
                        ({
                            type: "POST",
                            url: "get_customer_informations.php",
                            data: "invite_user_id=" + ID,
                            beforeSend: loading,
                            complete: closeloading,
                            success: function(option)
                            {
                                if (option == '1') {
                                    alert("User invitation sent");
                                } else {
                                    alert("User invitation not sent");
                                }
                            }
                        });
            }

            function About_Info_Popup() {
                closeloading(); // fadeout loading
                $("#about_info").fadeIn(0500); // fadein popup div
                $("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
                $("#backgroundPopup").fadeIn(0001);
            }

            function disablePopup() {
                $("#about_info").fadeOut("normal");
                $("#backgroundPopup").fadeOut("normal");
                $('#Contact_Name').html("");
                $('#Contact_Email').html("");
                $('#Company_Name').html("");
                $('#Company_Phone').html("");
                $('#Company_Fax').html("");
                $('#Address_1').html("");
                $('#Address_2').html("");
                $('#Room').html("");
                $('#City').html("");
                $('#State').html("");
                $('#Zip').html("");
                $('#Phone_1').html("");
                $('#Phone_2').html("");
                $('#Phone_3').html("");
                $('#Phone_4').html("");
                $('#resale_certificate').html("");
                $('#exempt_use_certificate').html("");
            }

            function loading() {
                $("div.login_loader").show();
            }

            function closeloading() {
                $("div.login_loader").fadeOut('normal');
            }

            function archive()
            {
                window.location = "archive.php";
            }
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
                                            NEW ACCOUNTS
                                            <span style="float: right;padding-right: 5px;">Welcome <?php
                                                if ($_SESSION['admin_user_type'] == '1') {
                                                    echo 'admin';
                                                } if ($_SESSION['admin_user_type'] == '2') {
                                                    echo 'Staff User';
                                                }
                                                ?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="14" align="left" valign="middle"></td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="right" valign="top">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="38" align="left" valign="middle" class="add_title">Search</td>
                                                </tr>
                                                <tr>
                                                    <td height="60" align="left" valign="top" bgcolor="#f6f6f6" class="form_bg">
                                                        <form name="new_supercategory" id="new_supercategory" method="post" action=""  onsubmit="return load_userinfo()" >
                                                            <input type="hidden" name="search_cus" value="1" />
                                                            <input type="hidden" name="new_cat" value="1" />       
                                                            <table width="600" border="0" cellspacing="0" cellpadding="0" >
                                                                <tr style="float:left;">
                                                                    <td width="160" height="60" align="right" valign="middle">
                                                                        <input class="input_text" type="text" name="search_val" id="search_val" type="text" value="<?php echo $_REQUEST['search_val']; ?>" placeholder="Company Name/Email ID" style="width:300px !important; margin-left: 25px;" >
                                                                    </td>
                                                                    <td width="250" height="60" align="center" valign="middle" style="padding-left: 10px;">
                                                                        <input type="submit" name="search" class="search_cus" value="Search" />
                                                                        <?php if ($_REQUEST['search_cus'] != '') { ?>
                                                                            <span class="search_cus" style="margin-left: 20px;" onclick="return reset_filter();">Reset</span>
<?php } ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="9" style="color:#F00; text-align:center; font-size: 12px;">
                                                                        <?php
                                                                        if ($result == "success") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Inserted Successfully</div>
                                                                            <script>setTimeout("location.href=\'customers.php\'", 1000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Not Successfully</div>
                                                                            <script>setTimeout("location.href=\'customers.php\'", 1000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($result == "success_del") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Deleted Successfully</div>
                                                                            <script>setTimeout("location.href=\'archive.php\'", 1000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_del") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Not Deleted</div>
                                                                            <script>setTimeout("location.href=\'archive.php\'", 1000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($result == "success_del_cus") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Deleted Successfully</div>
                                                                            <script>setTimeout("location.href=\'customers.php\'", 1000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_del_cus") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Not Deleted</div>
                                                                            <script>setTimeout("location.href=\'customers.php\'", 1000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>                                                                       
                                                                        <div id="msg1" style="color:#FF0000;padding-left:35px;font-size: 12px;"></div>
                                                                        <div id="msg2" style="color:#FF0000;padding-left:35px;font-size: 12px; display: none;"></div>
                                                                        <div id="msg" style="color:#007F2A; font-size: 13px;"></div>
                                                                        <span class="check" style="color:#FF0000;padding-left:35px;font-size: 12px;"  ></span>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </form>   
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="right" valign="top">
                                            <table width="759" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="736" align="left" valign="middle" style="padding-left:20px;">
                                                        <?php
                                                        if ($result == "success") {
                                                            ?>
                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Email id inserted successfully</div>
                                                            <script>setTimeout("location.href=\'new_accounts.php\'", 1000);</script>
                                                            <?php
                                                        } elseif ($result == "failure") {
                                                            ?>
                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Email id insert not successfully</div>
                                                            <script>setTimeout("location.href=\'new_accounts.php\'", 1000);</script>       
                                                            <?php
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($result == "success_del") {
                                                            ?>
                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Deleted successfully</div>
                                                            <script>setTimeout("location.href=\'new_accounts.php\'", 1000);</script>
                                                            <?php
                                                        } elseif ($result == "failure_del") {
                                                            ?>
                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Not deleted</div>
                                                            <script>setTimeout("location.href=\'new_accounts.php\'", 1000);</script>       
                                                            <?php
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($result == "success_status") {
                                                            ?>
                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">User account removed successfully</div>
                                                            <script>setTimeout("location.href=\'new_accounts.php\'", 1000);</script>
                                                            <?php
                                                        } elseif ($result == "failure_status") {
                                                            ?>
                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">User account not successfully</div>
                                                            <script>setTimeout("location.href=\'new_accounts.php\'", 1000);</script>       
                                                            <?php
                                                        }
                                                        ?> 
                                                        <?php
                                                        if ($result == "success_status_active") {
                                                            ?>
                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">User account active successfully</div>
                                                            <script>setTimeout("location.href=\'new_accounts.php\'", 1000);</script>
                                                            <?php
                                                        } elseif ($result == "failure_status_active") {
                                                            ?>
                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">User account active not successfully</div>
                                                            <script>setTimeout("location.href=\'new_accounts.php\'", 1000);</script>       
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td height="15" align="right" valign="middle">
                                                        <span class="archive" onclick="return archive();" style="float:right; margin-left: 5px;margin-top: 5px;">ARCHIVE</span>                                                        
                                                    </td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top">                                           
                                             <?php
                                            //Search Results
                                            if ($_REQUEST['search_cus'] != '') {
                                                $search_val = $_REQUEST['search_val'];
                                                $users_search_pre = getusers_list_search_user_NewAcc($search_val);
                                                if(count($users_search_pre) > 0){
                                                $users_search = getusers_list_search_user_NewAcc($search_val);   
                                                }else{
                                                $search_val_com_id = getCompId($_REQUEST['search_val']);
                                                if(count($search_val_com_id) > 0){
                                                foreach ($search_val_com_id as $comp_val){
                                                    $search_by_comp = getCompNameStatusNewAccount($comp_val['cus_compname']);
                                                }
                                                }
                                                if(count($search_by_comp) > 0){
                                                $search_by_usr_comp = trim($search_by_comp);
                                                //$search_by_comp = getCompName($search_val_com_id);
                                                $users_search = getusers_list_search_user_cus_NewAccount($search_by_usr_comp);   
                                                }
                                                }
                                                ?>
                                            <!-- Products Start -->
                                            <table width="759" border="0" cellspacing="0" cellpadding="0">

                                                <tr>
                                                    <td width="20" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>
                                                    <td width="150" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Date</td>
                                                    <td width="120" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Company Name</td>
                                                    <td width="40" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                if (count($users_search) > 0) {
                                                    foreach ($users_search as $users) {
                                                        $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                        $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                        $id = $users['comp_id'];
                                                        $comp_name = $users['comp_name'];
                                                        $create_date = explode(" ", $users['cus_regdate']);
                                                        $status = ($users['status'] == 1) ? 'active' : 'de-active';
                                                        $title = ($users['status'] == 1) ? 'Approved' : 'Denied';
                                                        $user_exist = (count(userExist($id)) > 0) ? count(userExist($id)) : 'No Users';
                                                        ?>
                                                        <tr class="trigger"  id="<?php echo $id; ?>">
                                                            <td width="49"  align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><?php echo $i; ?></td>
                                                            <td width="60" align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="pad_btm"><?php echo $create_date[0]; ?></td>
                                                            <td width="150" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm pointer" onclick="return get_info_1('<?php echo $id; ?>');"><?php echo $comp_name; ?></td>                                                            
        <!--                                                            <td width="60"  align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm">
        <?php echo $user_exist; ?>   
                                                            </td>-->
                                                            <td width="80"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm">                                                                                                                             
                                                                <a href="archive.php?archive_id=<?php echo $id; ?>" onclick="return confirm('Are you sure?');"><img src="images/like_icon.png" title="Restore Users"  alt="Restore Users" /></a>                                                               
                                                                <a href="archive.php?delete_id=<?php echo $id; ?>" onclick="return confirm('Are you sure?');"><img src="images/del.png" title="Delete"  alt="Delete" style="cursor: pointer;" /></a>
                                                            </td>
                                                        </tr>
                                                        <tr class = "toggle test_<?php echo $id; ?>">
                                                            <td colspan="4" align="center">
                                                                <table width="100%" align="center" cellspacing="0" cellpadding="0" border="0" style="margin:10px 0px; padding: 10px; border: 2px solid #F99B3E;">
                                                                    <tr align="center">
                                                                        <td align="center" width="50%">
                                                                            <table align="center" width="100%" border="0">
                                                                                <tr>
                                                                                    <td width="40%" bgcolor="#f68210" align="center" style="color: #FFF;">Company Informations</td>
                                                                                    <td width="60%" bgcolor="#f68210" align="center" style="color: #FFF;">User Informations</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td bgcolor="#F6F2F2">
                                                                                        <?php $CustomerDtlsArchive = CustomerDtlsArchive($id); ?>
                                                                                        <table>
                                                                                            <tr>
                                                                                                <td class="comp_dtls_arc" style="padding-left: 10px;">                                                                                                    
                                                                                                    <span style="font-size: 18px;font-weight: bold;"><?php echo $CustomerDtlsArchive[0]['comp_name']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_contact_email']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_contact_phone']; ?></span>
                                                                                                    <span style="font-size: 14px;font-weight: bold;">Address: </span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_business_address1']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_business_address2']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_business_address3']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_room']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_suite']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_floor']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_city']; ?>,<?php echo $CustomerDtlsArchive[0]['comp_state']; ?>&nbsp;<?php echo $CustomerDtlsArchive[0]['comp_zipcode']; ?></span>
                                                                                                    <?php if(($CustomerDtlsArchive[0]['comp_phone1'] != '') || ($CustomerDtlsArchive[0]['comp_phone2'] != '') || ($CustomerDtlsArchive[0]['comp_phone3'] != '')){ ?>
                                                                                                    <span style="font-size: 14px;font-weight: bold;">Phone Numbers: </span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_phone1']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_phone2']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_phone3']; ?></span>
                                                                                                    <?php } ?>
                                                                                                    <span>Resale Certificate:</span>
                                                                                                    <span><a href="../tax_form/<?php echo $CustomerDtlsArchive[0]['tax_form_resale']; ?>" target="_blank"><?php echo $CustomerDtlsArchive[0]['tax_form_resale']; ?></a></span>
                                                                                                    <span>Exempt Use Certificate:</span>                                                                                                    
                                                                                                    <span><a href="../tax_form/<?php echo $CustomerDtlsArchive[0]['tax_form_excempt']; ?>" target="_blank"><?php echo $CustomerDtlsArchive[0]['tax_form_excempt']; ?></a></span>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                    <td bgcolor="#F6F2F2" valign="top">
                                                                                        <?php $UserDtlsArchive = UserDtlsArchive($id); ?>
                                                                                        <table width="100%" align="center" border="0" valign="top" style="padding-top: 5px;">
                                                                                            <tr>
                                                                                                <td width="40%" align="center" style="font-size: 14px;font-weight: bold;">User Name</td>
                                                                                                <td width="60%" align="center" style="font-size: 14px;font-weight: bold;">Email ID</td>
                                                                                            </tr>
                                                                                            <?php
                                                                                            if(count($UserDtlsArchive) > 0){
                                                                                            foreach ($UserDtlsArchive as $userDtls){
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td align="center"><?php echo $userDtls['cus_fname'].'&nbsp;'.$userDtls['cus_lname']; ?></td>
                                                                                                <td align="center"><?php echo $userDtls['cus_email']; ?></td>
                                                                                            </tr>
                                                                                            <?php                                                                                             
                                                                                            }
                                                                                            }else{
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td align="center" colspan="2">There is no users.</td>
                                                                                            </tr>
                                                                                            <?php } ?>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>                                                                        
                                                                    </tr>                                                                   
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        
        <?php
        $i++;
    }
} else {
    ?>
                                                    <tr align="center">
                                                        <td colspan="8"></td>
                                                    </tr>
    <?php
}
?>

                                            </table>
                                            <?php }else{ ?>
                                            <!-- Products Start -->
                                            <table width="759" border="0" cellspacing="0" cellpadding="0">

                                                <tr>
                                                    <td width="20" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>
                                                    <td width="150" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Date</td>
                                                    <td width="120" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Company Name</td>
<!--                                                    <td width="40" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">users</td>-->
                                                    <td width="40" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                if (count($UsersAll) > 0) {
                                                    foreach ($UsersAll as $users) {
                                                        $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                        $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                        $id = $users['comp_id'];
                                                        $comp_name = $users['comp_name'];
                                                        $create_date = explode(" ", $users['cus_regdate']);
                                                        $status = ($users['status'] == 1) ? 'active' : 'de-active';
                                                        $title = ($users['status'] == 1) ? 'Approved' : 'Denied';
                                                        $user_exist = (count(userExist($id)) > 0) ? count(userExist($id)) : 'No Users';
                                                        ?>
                                                        <tr class="trigger"  id="<?php echo $id; ?>">
                                                            <td width="49"  align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><?php echo $i; ?></td>
                                                            <td width="60" align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="pad_btm"><?php echo date("m-d-Y", strtotime($create_date[0])); ?></td>
                                                            <td width="150" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm pointer" onclick="return get_info('<?php echo $id; ?>');"><?php echo $comp_name; ?></td>                                                            
        <!--                                                            <td width="60"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm">
                                                            <?php echo $user_exist; ?>   
                                                            </td>-->
                                                            <td width="80"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm">  
                                                                <a href="new_accounts.php?active_id=<?php echo $id; ?>" onclick="return confirm('Are you sure?');"><img class="pointer" src="images/like_icon.png" title="Invite Users" alt="Invite Users" /></a>
                                                                <a href="new_accounts.php?archive_id=<?php echo $id; ?>" onclick="return confirm('Are you sure?');"><img src="images/like_icon_down.png" title="Remove Account"  alt="Remove Account" /></a>                                                               
                                                            </td>
                                                        </tr>
                                                        <tr class = "toggle test_<?php echo $id; ?>">
                                                            <td colspan="4" align="center">
                                                                <table width="100%" align="center" cellspacing="0" cellpadding="0" border="0" style="margin:10px 0px; padding: 10px; border: 2px solid #F99B3E;">
                                                                    <tr align="center">
                                                                        <td align="center" width="50%">
                                                                            <table align="center" width="100%" border="0">
                                                                                <tr>
                                                                                    <td width="40%" bgcolor="#f68210" align="center" style="color: #FFF;">Company Informations</td>
                                                                                    <td width="60%" bgcolor="#f68210" align="center" style="color: #FFF;">User Informations</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td bgcolor="#F6F2F2">
                                                                                        <?php $CustomerDtlsArchive = CustomerDtlsArchive($id); ?>
                                                                                        <table>
                                                                                            <tr>
                                                                                                <td class="comp_dtls_arc" style="padding-left: 10px;">                                                                                                    
                                                                                                    <span style="font-size: 18px;font-weight: bold;"><?php echo $CustomerDtlsArchive[0]['comp_name']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_contact_email']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_contact_phone']; ?></span>
                                                                                                    <span style="font-size: 14px;font-weight: bold;">Address: </span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_business_address1']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_business_address2']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_business_address3']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_room']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_suite']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_floor']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_city']; ?>,<?php echo $CustomerDtlsArchive[0]['comp_state']; ?>&nbsp;<?php echo $CustomerDtlsArchive[0]['comp_zipcode']; ?></span>
                                                                                                    <?php if(($CustomerDtlsArchive[0]['comp_phone1'] != '') || ($CustomerDtlsArchive[0]['comp_phone2'] != '') || ($CustomerDtlsArchive[0]['comp_phone3'] != '')){ ?>
                                                                                                    <span style="font-size: 14px;font-weight: bold;">Phone Numbers: </span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_phone1']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_phone2']; ?></span>
                                                                                                    <span><?php echo $CustomerDtlsArchive[0]['comp_phone3']; ?></span>
                                                                                                    <?php } ?>
                                                                                                    <span>Resale Certificate:</span>
                                                                                                    <span><a href="../tax_form/<?php echo $CustomerDtlsArchive[0]['tax_form_resale']; ?>" target="_blank"><?php echo $CustomerDtlsArchive[0]['tax_form_resale']; ?></a></span>
                                                                                                    <span>Exempt Use Certificate:</span>                                                                                                    
                                                                                                    <span><a href="../tax_form/<?php echo $CustomerDtlsArchive[0]['tax_form_excempt']; ?>" target="_blank"><?php echo $CustomerDtlsArchive[0]['tax_form_excempt']; ?></a></span>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                    <td bgcolor="#F6F2F2" valign="top">
                                                                                        <?php $UserDtlsArchive = UserDtlsArchive($id); ?>
                                                                                        <table width="100%" align="center" border="0" valign="top" style="padding-top: 5px;">
                                                                                            <tr>
                                                                                                <td width="40%" align="center" style="font-size: 14px;font-weight: bold;">User Name</td>
                                                                                                <td width="60%" align="center" style="font-size: 14px;font-weight: bold;">Email ID</td>
                                                                                            </tr>
                                                                                            <?php
                                                                                            if(count($UserDtlsArchive) > 0){
                                                                                            foreach ($UserDtlsArchive as $userDtls){
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td align="center"><?php echo $userDtls['cus_fname'].'&nbsp;'.$userDtls['cus_lname']; ?></td>
                                                                                                <td align="center"><?php echo $userDtls['cus_email']; ?></td>
                                                                                            </tr>
                                                                                            <?php                                                                                             
                                                                                            }
                                                                                            }else{
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td align="center" colspan="2">There is no users.</td>
                                                                                            </tr>
                                                                                            <?php } ?>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>                                                                        
                                                                    </tr>                                                                   
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    ?>
                                                    <tr align="center">
                                                        <td colspan="8"></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>

                                            </table>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td style="background:#464646; text-align:center; color:#fff; line-height:30px;" height="30p">© <?php echo date('Y'); ?> sohorepro.com</td>
            </tr>
        </table>




        <div id="about_info">    	
            <div class="close"></div>
            <span class="ecs_tooltip">Press Esc to close <span class="arrow"></span></span>        
            <div>
                <span>Account Details</span>
                <table border="1" style="width: 325px;">
                    <tr>
                        <td style="width: 110px;">Contact Name</td>
                        <td style="width: 215px;"><span id="Contact_Name"></span></td>
                    </tr>
                    <tr>
                        <td>Contact Email</td>
                        <td><span id="Contact_Email"></span></td>
                    </tr>
                    <tr>
                        <td>Company Name</td>
                        <td><span id="Company_Name"></span></td>
                    </tr>
                    <tr>
                        <td>Company Phone</td>
                        <td><span id="Company_Phone"></span></td>
                    </tr>
                    <tr>
                        <td>Company Fax</td>
                        <td><span id="Company_Fax"></span></td>
                    </tr>
                    <tr>
                        <td>Address1 </td>
                        <td><span id="Address_1"></span></td>
                    </tr>
                    <tr>
                        <td>Address2</td>
                        <td><span id="Address_2"></span></td>
                    </tr>
                    <tr>
                        <td>Room/Flr/Suite</td>
                        <td><span id="Room"></span></td>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td><span id="City"></span></td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td><span id="State"></span></td>
                    </tr>
                    <tr>
                        <td>Zip</td>
                        <td><span id="Zip"></span></td>
                    </tr>
                    <tr>
                        <td>Phone 2</td>
                        <td><span id="Phone_1"></span></td>
                    </tr>
                    <tr>
                        <td>Phone 3</td>
                        <td><span id="Phone_2"></span></td>
                    </tr>
                    <tr>
                        <td>Phone 4</td>
                        <td><span id="Phone_3"></span></td>
                    </tr>
<!--                    <tr>
                        <td>Phone 4</td>
                        <td><span id="Phone_4"></span></td>
                    </tr>-->
                    <tr>
                        <td>Resale Certificate</td>
                        <td><span id="resale_certificate"></span></td>
                    </tr>
                    <tr>
                        <td>Exempt Use Certificate</td>
                        <td><span id="exempt_use_certificate"></span></td>
                    </tr>
                </table>
            </div>            
        </div>

        <div class="login_loader"></div>
        <div id="backgroundPopup"></div>









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
                if (!expr.test(input))
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
                                    if (option == '1') {
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
                var sequence = document.getElementById('sequence_id').value;
                if (sequence != '')
                {
                    $.ajax
                            ({
                                type: "POST",
                                url: "get_child.php",
                                data: "sequence_id=" + sequence_id + "&sequence=" + sequence,
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

             function reset_filter()
            {
                window.location = "new_accounts.php";

            }
            function load_userinfo()
            {
                //alert('Jassim');
                var search_val = $("#search_val").val();
                if (search_val == '') {
                    document.getElementById('search_val').focus();
                    $("#msg1").html('Enter the search value');
                    return false;
                }
                return true;

        //    var search_val = $( "#search_val" ).val();
        //    
        //    if(search_val != '')  
        //     {
        //      $.ajax
        //      ({
        //         type: "POST",
        //             url: "load_user.php",
        //             data: "search_val="+search_val,
        //             success: function(option)
        //             {
        //                 $('#load_userdata').html(option);
        //             }
        //      });
        //     }
            }
        </script>

    </body>
</html>