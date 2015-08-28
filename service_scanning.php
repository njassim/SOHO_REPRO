<?php
include './admin/config.php';
include './admin/db_connection.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Scanning - Services</title>

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
                                <h2 class="headline-interior orange" style="text-transform: uppercase;">Scanning</h2>
                                <div class="bkgd-stripes-orange">&nbsp;</div>
                                <p style="margin-bottom:10px!important;">
                                    Large Format or Vector Scanning:<br>
                                    Our 36â&#8364;&#157; scanner can convert your drawing to a raster format: PDF or TIFF format. This electronic
                                    file can be burned to a CD, placed onto your USB drive or emailed...(more)

                                </p>

                                <form id="scanning" enctype="application/x-www-form-urlencoded" action="service/scanning/" method="post" class="systemForm validate orderform"><ul>
                                        <li class="clear"><label for="jobref" class="optional">Job Reference Number</label>
                                            <span>
                                                <input aria-haspopup="true" aria-autocomplete="list" role="textbox" autocomplete="off" class="ui-autocomplete-input" name="jobref" id="jobref" type="text"></span></li>
                                        <li class="clear"><span>
                                                <div class="serviceOrderSetHolder"><div style="background-color:#FFFFFF" class="serviceOrderSetWapper" setindex="0"><div class="serviceOrderSetWapperInternal"><div class="serviceOrderSetDIV"><div><label>File Format</label><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set1_0_format kdSelect " style="width:260px;" id="order_0_set1_0_format" name="order[0][set1][0][format]"><option selected="selected" value="JPG">JPG</option><option value="TIFF">TIFF</option><option value="PDF">PDF</option><option value="AutoCAD DWG">AutoCAD DWG</option><option value="VectorWorks MCD">VectorWorks MCD</option> </select></div><div class="dropdown_selector"></div></div></div><div><label>AutoCAD/ VectorWorks Version #</label><input class="order_0_set1_0_Version  k-input kdText " style="width:290px;" id="order_0_set1_0_Version #" name="order[0][set1][0][Version]" type="text"></div><div><label>Scan Type</label><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set1_0_ScanType kdSelect " style="width:400px;" id="order_0_set1_0_ScanType" name="order[0][set1][0][ScanType]"><option selected="selected" value="Architectural Drawing (Convert to Vector File)">Architectural Drawing (Convert to Vector File)</option><option value="Flat Art">Flat Art</option><option value="4 x 5 Chrome">4 x 5 Chrome</option><option value="2 1/4 Chrome">2 1/4 Chrome</option><option value="35 mm Slide">35 mm Slide</option><option value="Other">Other</option> </select></div><div class="dropdown_selector"></div></div></div><div><label>Resolution (DPI)</label><input class="order_0_set1_0_resolution k-input kdText " style="width:130px;" id="order_0_set1_0_resolution" name="order[0][set1][0][resolution]" type="text"></div><div><label>Name of Scanned File</label><input class="ymlrequired order_0_set1_0_filename k-input kdText " style="width:350px;" id="order_0_set1_0_filename" name="order[0][set1][0][filename]" type="text"></div></div></div><div style="clear:both;"></div></div></div><div style="width:auto;text-align:right"><input class="addNewOrderSet" value="Add Set" style="float:right;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px;margin-right:130px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="submit"></div>
                                                <script> $(document).ready(function() {
                                                    });</script></span></li>
                                        <li class="clear"><label for="emailaddress" class="optional">Mail Scanned File To</label>
                                            <span>
                                                <input name="emailaddress" id="emailaddress" style="width:350px;height:25px;" type="text"></span></li>
                                        <li class="clear"><label for="instruction" class="optional">Special Instructions</label>
                                            <span>
                                                <textarea name="instruction" id="instruction" cols="60" rows="4"></textarea></span></li>
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
