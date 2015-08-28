<?php
include './admin/config.php';
include './admin/db_connection.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register - Services</title>

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


                    <!-- Login Section Start -->

                    <?php include "includes/header_sidebar.php"; ?>

                    <!-- Login Section End --> 
                    <div id="content_output">
                        
                        <?php include "includes/top_nav.php"; ?>
                        
                        <!-- Top Navigation Start -->

                        <?php include "./service_nav.php"; ?>

                        <!-- Top Navigation End -->
                        <!-- Main Content Start -->
                        <div id="content_output-data" style="margin-bottom:20px;">
                            <div id="loginWapper">
                                <h2 class="headline-interior orange">Soho Repro Registration Form</h2>
                                <div class="bkgd-stripes-orange">&nbsp;</div>

                                <form id="searchcom" enctype="application/x-www-form-urlencoded" action="authenticate/searchcom/" method="post" class="systemForm validate"><ul>
                                        <li class="clear"><label for="phone" class="required">Enter your firm's main phone number <span style="font-sixe:16px;font-weight:bold;">*</span> </label>
                                            <span>
                                                <input name="phone" id="phone" type="text"></span></li>
                                        <li class="clear"><span>
                                                <div style="height:29px;">&nbsp;</div><input class="addproductActionLink" value="Continue" style="cursor: pointer;float:right;font-size:12px; padding:1.5px; width: 100px;margin-right:14px;margin-top:15px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="submit"><div style="clear:both"></div></span></li></ul></form>
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
