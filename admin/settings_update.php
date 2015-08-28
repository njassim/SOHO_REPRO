<?php
include './config.php';
include './auth.php';
$Email = getEmailactive();
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
            .switch {
            position: relative;
            display: inline-block;
            vertical-align: top;
            width: 56px;
            height: 20px;
            padding: 3px;
            background-color: white;
            border-radius: 18px;
            box-shadow: inset 0 -1px white, inset 0 1px 1px rgba(0, 0, 0, 0.05);
            cursor: pointer;
            background-image: -webkit-linear-gradient(top, #eeeeee, white 25px);
            background-image: -moz-linear-gradient(top, #eeeeee, white 25px);
            background-image: -o-linear-gradient(top, #eeeeee, white 25px);
            background-image: linear-gradient(to bottom, #eeeeee, white 25px);
            }

            .switch-input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            }

            .switch-label {
            position: relative;
            display: block;
            height: inherit;
            font-size: 10px;
            text-transform: uppercase;
            background: #eceeef;
            border-radius: inherit;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.12), inset 0 0 2px rgba(0, 0, 0, 0.15);
            -webkit-transition: 0.15s ease-out;
            -moz-transition: 0.15s ease-out;
            -o-transition: 0.15s ease-out;
            transition: 0.15s ease-out;
            -webkit-transition-property: opacity background;
            -moz-transition-property: opacity background;
            -o-transition-property: opacity background;
            transition-property: opacity background;
            }
            .switch-label:before, .switch-label:after {
            position: absolute;
            top: 50%;
            margin-top: -.5em;
            line-height: 1;
            -webkit-transition: inherit;
            -moz-transition: inherit;
            -o-transition: inherit;
            transition: inherit;
            }
            .switch-label:before {
            content: attr(data-off);
            right: 11px;
            color: #aaa;
            text-shadow: 0 1px rgba(255, 255, 255, 0.5);
            }
            .switch-label:after {
            content: attr(data-on);
            left: 11px;
            color: white;
            text-shadow: 0 1px rgba(0, 0, 0, 0.2);
            opacity: 0;
            }
            .switch-input:checked ~ .switch-label {
            background: #47a8d8;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), inset 0 0 3px rgba(0, 0, 0, 0.2);
            }
            .switch-input:checked ~ .switch-label:before {
            opacity: 0;
            }
            .switch-input:checked ~ .switch-label:after {
            opacity: 1;
            }

            .switch-handle {
            position: absolute;
            top: 4px;
            left: 4px;
            width: 18px;
            height: 18px;
            background: white;
            border-radius: 10px;
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
            background-image: -webkit-linear-gradient(top, white 40%, #f0f0f0);
            background-image: -moz-linear-gradient(top, white 40%, #f0f0f0);
            background-image: -o-linear-gradient(top, white 40%, #f0f0f0);
            background-image: linear-gradient(to bottom, white 40%, #f0f0f0);
            -webkit-transition: left 0.15s ease-out;
            -moz-transition: left 0.15s ease-out;
            -o-transition: left 0.15s ease-out;
            transition: left 0.15s ease-out;
            }
            .switch-handle:before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -6px 0 0 -6px;
            width: 12px;
            height: 12px;
            background: #f9f9f9;
            border-radius: 6px;
            box-shadow: inset 0 1px rgba(0, 0, 0, 0.02);
            background-image: -webkit-linear-gradient(top, #eeeeee, white);
            background-image: -moz-linear-gradient(top, #eeeeee, white);
            background-image: -o-linear-gradient(top, #eeeeee, white);
            background-image: linear-gradient(to bottom, #eeeeee, white);
            }
            .switch-input:checked ~ .switch-handle {
            left: 40px;
            box-shadow: -1px 1px 5px rgba(0, 0, 0, 0.2);
            }

            .switch-green > .switch-input:checked ~ .switch-label {
            background: #F99B3E;
            }            
        </style>

        <script type="text/javascript">
            $(document).ready(function() {
                /**  Simple image gallery. Uses default settings*/
                $('.fancybox').fancybox();

                /**  Different effects */
            });

            function Orders_Active(ID)
            {
                //var order_notification = confirm('Are you sure ?');
                if (ID != '') { 
                    $.ajax
                        ({
                            type: "POST",
                            url: "get_child.php",
                            data: "order_notification=1&order_notification_id="+ID,
                            beforeSend: loadStart,
                            complete: loadStop,
                            success: function(option)
                            {
                               if(option == '1')
                               {
                                   window.location = "settings_update.php?val=success";
                               }
                            }
                        });
                    
                }else{
                    return false;
                }
            }
            
            function Accounts_Active(ID)
            {
                //var account_notification = confirm('Are you sure ?');
                if (ID != '') { 
                    $.ajax
                        ({
                            type: "POST",
                            url: "get_child.php",
                            data: "account_notification=1&account_notification_id="+ID,
                            beforeSend: loadStart,
                            complete: loadStop,
                            success: function(option)
                            {
                               if(option == '1')
                               {
                                   window.location = "settings_update.php?val=success";
                               }
                            }
                        });
                    
                }else{
                    return false;
                }
            }
            
            function Help_Active(ID)
            {
                //var account_notification = confirm('Are you sure ?');
                if (ID != '') { 
                    $.ajax
                        ({
                            type: "POST",
                            url: "get_child.php",
                            data: "help_notification=1&help_notification_id="+ID,
                            beforeSend: loadStart,
                            complete: loadStop,
                            success: function(option)
                            {
                               if(option == '1')
                               {
                                   window.location = "settings_update.php?val=success";
                               }
                            }
                        });
                    
                }else{
                    return false;
                }
            }
            
        </script>
        <!--End -->       
    </head>

    <body>
        <div id="loading" style="position: fixed;top: 35%;left: 48%;padding: 5px;z-index: 10;display: none;">
            <img src="images/login_loader.gif" border="0" />
        </div>
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
                                            SETTINGS UPDATE
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
                                        <td height="14" align="center" valign="middle">
                                            <?php
                                             if ($_GET['val'] == "success") {
                                            ?>
                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Updated successfully</div>
                                            <script>setTimeout("location.href=\'settings_update.php\'", 1000);</script>
                                            <?php
                                            } elseif ($result == "failure") {
                                            ?>
                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Updated not successfully</div>
                                            <script>setTimeout("location.href=\'settings_update.php\'", 1000);</script>       
                                            <?php
                                            }
                                            ?>
                                        </td>                                       
                                    </tr>    
                                    <tr>
                                         <td align="right">
                                             <a href="email_settings.php"><span class="archive" style="float:right; margin-left: 5px;margin-top: 5px;">BACK</span></a>
                                         </td>
                                    </tr>

                                    <tr>
                                        <td align="right" valign="top">                                           

                                    <!-- Products Start -->                                           
                                        <table width="759" border="0" cellspacing="0" cellpadding="0">

                                                <tr>
                                                    <td width="10" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>
                                                    <td width="100" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Name</td>
                                                    <td width="100" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Email id</td>
                                                    <td width="150" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">
                                                        <table style="width: 100%;">
                                                            <tr style="text-align: center;">
                                                                <td colspan="3">RECEIVE NOTIFICATIONS</td>                                                               
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight: bold;">ORDERS</td>
                                                                <td style="font-weight: bold;padding-left: 5px;padding-right: 5px;">ACCOUNTS</td>
                                                                <td style="font-weight: bold;">HELP BOX</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                if (count($Email) > 0) {
                                                    foreach ($Email as $Mail) {
                                                        $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                        $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                        $status = ($Mail['status'] == 1) ? 'active' : 'de-active';
                                                        $id = $Mail['id'];
                                                        $orders = $Mail['orders'];
                                                        $accounts = $Mail['accounts'];
                                                        $help = $Mail['help'];
                                                        ?>
                                                        <tr>
                                                            <td width="49"  align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="pad_btm"><?php echo $i; ?></td>
                                                            <td width="150" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm"><?php echo $Mail['name']; ?></td>
                                                            <td width="60" align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="pad_btm"><?php echo $Mail['email_id']; ?></td>
                                                            <td width="60"  align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="pad_btm">
                                                            <table style="width: 100%;">
                                                                <tr style="text-align: center;">
                                                                    <td>
                                                                        <label class="switch switch-green">                                                                            
                                                                            <input type="checkbox" class="switch-input" name="orders" id="orders" onclick="return Orders_Active('<?php echo $id; ?>');" <?php if ($orders == '1') { ?> checked <?php } ?> />
                                                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                                                            <span class="switch-handle"></span>
                                                                        </label>
                                                                    </td>
                                                                    <td style="padding-left: 5px;padding-right: 5px;">
                                                                        <label class="switch switch-green">
                                                                            <input type="checkbox" class="switch-input" name="accounts" id="accounts" onclick="return Accounts_Active('<?php echo $id; ?>');" <?php if ($accounts == '1') { ?> checked <?php } ?> />
                                                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                                                            <span class="switch-handle"></span>
                                                                        </label>
                                                                    </td>
                                                                    <td>
                                                                        <label class="switch switch-green">
                                                                            <input type="checkbox" class="switch-input" name="help" id="accounts" onclick="return Help_Active('<?php echo $id; ?>');" <?php if ($help == '1') { ?> checked <?php } ?> />
                                                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                                                            <span class="switch-handle"></span>
                                                                        </label>
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
                                                        <td colspan="8">There is no mail id's</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>

                                            </table>
                                            
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

    $(document).ready(function() {
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
            Update_Info_Popup(); // function show popup 
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

    function Update_Info_Popup() {
        closeloading(); // fadeout loading
        $("#update_info").fadeIn(0500); // fadein popup div
        $("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
        $("#backgroundPopup").fadeIn(0001);
    }

    function disablePopup() {
        $("#update_info").fadeOut("normal");
        $("#backgroundPopup").fadeOut("normal");
        $('#Contact_Name').html("");
        $('#Contact_Email').html("");
        $('#Company_Name').html("");
        $('#Company_Phone').html("");
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

    function loadStart() {
        $('#loading').show();
    }

    function loadStop() {
        $('#loading').hide();
    }
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
        var mail_name = document.getElementById('name').value;
        if (input_mail != '')
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "get_child.php",
                        data: "mail_id=" + input_mail + "&mail_name=" + mail_name,
                        success: function(option)
                        {
                            if (option == 'EXIST') {
                                document.getElementById("msg4").innerHTML = "Email id already exist.";
                            } else {
                                document.getElementById("msg4").innerHTML = "";
                                window.location = "email_settings.php?val=success";
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


</script>