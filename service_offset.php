<?php
include './admin/config.php';
include './admin/db_connection.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Offset - Services</title>

        <link rel="stylesheet" href="services_support/style.css" type="text/css" media="screen">

        <link rel="stylesheet" href="services_support/theme.css" type="text/css" media="screen">

        <link rel="stylesheet" href="services_support/jquery.css" type="text/css" media="screen">

        <link rel="stylesheet" href="services_support/tiptip.css" type="text/css" media="screen">

        <link rel="stylesheet" type="text/css" href="services_support/style_layout.css">

    </head>
    <body>
        <div id="body_container">
            <div id="body_content" class="body_wrapper">
                <div id="body_content-inner" class="body_wrapper-inner">

                    <?php include "includes/header_sidebar.php"; ?>

                    <div id="content_output">

                        <?php include "includes/top_nav.php"; ?>

                        <div id="content_output-data" style="margin-bottom:20px;">  
                            <!--- TABLE START -->
                            <?php include "./service_nav.php"; ?>
                            <div id="orderWapper">
                                <h2 class="headline-interior orange" style="text-transform: uppercase;">Offset Printing</h2>
                                <div class="bkgd-stripes-orange">&nbsp;</div>
                                <p style="margin-bottom:10px!important;">
                                    Offset printing is a widely used printing technique where the inked image is transferred (or â&#8364;&#339;offsetâ&#8364;&#157;)
                                    from a plate to a rubber blanket, then to the printing surface...(more) Logout </p>
                                <p>
                                    Please upload your file to our FTP (maximum file size is 20 MB) and then call us at (212) 925-7575
                                    x211 and speak to Sonny Ko to discuss your order.
                                </p>
                                <form id="offsetprinting" enctype="application/x-www-form-urlencoded" action="view/mailoffset/" method="post" class="systemForm validate orderform"><ul>
                                        <li class="clear"><label style="font-weight: bold;" for="jobref" class="optional">Job Reference Number</label>
                                            <span>
                                                <input aria-haspopup="true" aria-autocomplete="list" role="textbox" autocomplete="off" class="ui-autocomplete-input" name="jobref" id="jobref" type="text"><div style="clear:both;"></div></span></li>
                                        <li class="clear"><label style="font-weight: bold;" for="clientname" class="required">Your Name <span style="font-sixe:16px;font-weight:bold;">*</span> </label>
                                            <span>
                                                <input name="clientname" id="clientname" type="text"><div style="clear:both;"></div></span></li>
                                        <li class="clear"><label style="font-weight: bold;" for="company" class="required">Your Company <span style="font-sixe:16px;font-weight:bold;">*</span> </label>
                                            <span>
                                                <input name="company" id="company" type="text"><div style="clear:both;"></div></span></li>
                                        <li class="clear"><label style="font-weight: bold;" for="email" class="required">Your Email <span style="font-sixe:16px;font-weight:bold;">*</span> </label>
                                            <span>
                                                <input name="email" id="email" type="text"><div style="clear:both;"></div></span></li>
                                        <li style="width: 575px;" class="clear"><label style="font-weight: bold;" for="phone" class="required">Your Phone <span style="font-sixe:16px;font-weight:bold;">*</span> </label>
                                            <span>
                                                <input style="margin-top:5px;width:70%;float:left;margin-right:15px;" id="phonePstnNum" name="phone[pstnnum]" type="text"><input style="margin-top:5px;width:22%;float:left;" id="phoneExtNum" name="phone[extnum]" type="text"><div style="clear:both"></div><label style="padding-left:0;padding-right:0;margin-right:4%;font-weight:normal;font-size:10px;color:#666;font-family:arial;width:320px;float:left;"></label><label class="extensionsublabel" style="margin-left:13%;padding-left:0;padding-right:0;font-weight:normal;font-size:10px;color:#666;font-family:arial;width:100px;float:left;">Ext</label><div style="clear:both"></div><div style="clear:both;"></div></span></li>
                                        <li class="clear"><span>
                                                <div style="height:29px;">&nbsp;</div><input class="addproductActionLink" value="Submit" style="cursor: pointer;float:right;font-size:12px; padding:1.5px; width: 100px;margin-right:14px;margin-top:15px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="submit"><div style="clear:both"></div><div style="clear:both;"></div></span></li></ul></form>      
                            </div>

                            <div style="clear:both;">
                            </div>

                        </div>
                        <!-- Main Content End -->
                        <div class="clear">
                        </div>
                    </div>
                    <div class="clear">
                    </div>

                    <!-- Footer Start -->
                    <?php include "./service_footer.php"; ?>
                    <!-- Footer End -->
                </div>
            </div>
            <div class="clear">
            </div>



        </div>
    </body>
</html>
