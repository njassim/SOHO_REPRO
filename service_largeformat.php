<?php
include './admin/config.php';
include './admin/db_connection.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Large Format - Services</title>

        <link rel="stylesheet" href="services_support/style.css" type="text/css" media="screen">

        <link rel="stylesheet" href="services_support/theme.css" type="text/css" media="screen">

        <link rel="stylesheet" href="services_support/jquery.css" type="text/css" media="screen">

        <link rel="stylesheet" href="services_support/tiptip.css" type="text/css" media="screen">

        <link rel="stylesheet" type="text/css" href="services_support/style_layout.css">
        <style>
            .upload_file_prog{
            width: 40% !important;
            padding: 1.5px;
            -webkit-border-radius: 5px;
            border: 1px solid #8f8f8f !important;
}
        </style>
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
                                <h2 class="headline-interior orange" style="text-transform: uppercase;">Large Format Color &amp; Bw
                                </h2>
                                <div class="bkgd-stripes-orange">&nbsp;</div>
                                <p style="margin-bottom:10px!important;">SoHo Repro has Hewlett-Packardâ&#8364;&#8482;s latest full color printers. These postscript devices produce high
                                    quality graphics at 2400dpi...(more)
                                </p>
                                <form id="largeformat" enctype="application/x-www-form-urlencoded" action="service/largeformat/" method="post" class="systemForm validate orderform"><ul>
                                        <li class="clear"><label style="font-weight: bold;" for="jobref" class="optional">Job Reference Number</label>
                                            <span style="position: relative;">                        
                                                <input aria-haspopup="true" aria-autocomplete="list" role="textbox" autocomplete="off" class="ui-autocomplete-input dec" style="padding:3px;width: 195px;text-transform: uppercase;" name="jobref" id="jobref" type="text" value="<?php echo $_SESSION['ref_val']; ?>" />
                                                <div id="result_ref">
                                                </div>
                                                <input type="hidden" name="user_session" id="user_session" value="<?php echo $_SESSION['sohorepro_userid']; ?>" />
                                                <input type="hidden" name="user_session_comp" id="user_session_comp" value="<?php echo $_SESSION['sohorepro_companyid']; ?>" />
                                                <input type="hidden" name="jobref_id" id="jobref_id" value="" />
                                                <input type="hidden" name="company_id" id="company_id" value="" />                        
                                            </span>
                                        </li>
                                        <li class="clear"><span>
                                                <div class="serviceOrderSetHolder"><div style="background-color:#FFFFFF" class="serviceOrderSetWapper" setindex="0"><div class="serviceOrderSetWapperInternal"><div class="serviceOrderSetDIV"><div><label>Originals</label><input class="order_0_set1_0_original k-input kdText " style="width:70px;" id="order_0_set1_0_original" name="order[0][set1][0][original]" type="text"></div><div><label># Sets<span style="font-weight:bold;color:#cc0000">*</span></label><input class="ymlrequired order_0_set1_0_printOfEach k-input kdText " style="width:70px;" id="order_0_set1_0_printOfEach" name="order[0][set1][0][printOfEach]" type="text"></div><div><label>Size</label><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set1_0_size kdSelect " style="width: 85px;" id="order_0_set1_0_size" name="order[0][set1][0][size]"><option selected="selected" value="100%">100%</option><option value="Custom">Custom</option> </select></div><div class="dropdown_selector"></div></div></div><div><label>Output</label><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set1_0_output kdSelect " style="width: 95px;" id="order_0_set1_0_output" name="order[0][set1][0][output]"><option selected="selected" value="Color">Color</option><option value="B/W">B/W</option> </select></div><div class="dropdown_selector"></div></div></div><div><label>Media</label><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set1_0_media kdSelect " style="width: 155px;" id="order_0_set1_0_media" name="order[0][set1][0][media]"><option selected="selected" value="3498">Presentation Bond</option><option value="3499">Heavy Weight Bond</option><option value="3500">Vellum</option><option value="3501">Matte Mylar</option><option value="3502">Photo Satin</option><option value="3503">Photo Gloss</option><option value="3504">Clear Film</option><option value="3510">Scrim Vinyl</option><option value="3513">Standard Bond</option> </select></div><div class="dropdown_selector"></div></div></div><div style="clear:both;"><label>Mounting</label><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set1_0_mounting kdSelect " style="width: 155px;" id="order_0_set1_0_mounting" name="order[0][set1][0][mounting]"><option value="none" selected="selected">None</option><option value="3308">FoamBoard 3/16 White</option><option value="3309">FoamBoard 3/16 Black</option><option value="3315">FoamBoard 1/2 White</option><option value="3316">FoamBoard 1/2 Black</option><option value="3311">GatorBoard 3/16 White</option><option value="3312">GatorBoard 3/16 Black</option><option value="3317">GatorBoard 1/2 White</option><option value="3318">GatorBoard 1/2 Black</option><option value="3313">Illustration Board 1/8 White</option><option value="3319">Plasti-Cor  WHITE</option> </select></div><div class="dropdown_selector"></div></div></div><div><label>Lamination</label><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set1_0_lamination kdSelect " style="width: 155px;" id="order_0_set1_0_lamination" name="order[0][set1][0][lamination]"><option value="none" selected="selected">None</option><option value="3323">Satin</option><option value="3324">Gloss</option> </select></div><div class="dropdown_selector"></div></div></div><div style="width:728px;"><br>
                                                                    <label style="font-weight: bold;">Upload a File</label>                   

                                                                    <div class="uploadfile" style="border-top: 1px solid #FF7E00;width:730px;margin-top:4px;min-height:20px;"> 
                                                                        <div style="border-right: 1px solid #CCCCCC;width:167px; height:110px;float:left;display:none;">                             
                                                                        </div>
                                                                        <div style="width: 300px; height: 40px; float: left; margin-left: -5px;">
                                                                            <div id="nn" class="optionwapper">
                                                                                <div><br>
                                                                                    <div class="k-widget k-upload"><div class="k-dropzone"><div class="k-button k-upload-button"><input autocomplete="off" multiple="multiple" name="jobfile" id="order_0_set1_0_jobfiles" class="addFileToOrder" type="file"></div><input type="button" value="Upload File" class="upload_file_prog" onclick="return upload_file(1)"></div></div>
                                                                                    <!--<input name="jobfile" id="" class="addFileToOrder" type="file" />-->
                                                                                </div>  
                                                                            </div>

                                                                        </div>

                                                                        <div style="clear:both;"></div>

                                                                    </div>
                                                                    <div style="width:730px;border-bottom: 1px solid #CCCCCC;"><label style="font-weight: bold;height:28px">Alternative File Options</label>               
                                                                        <div class="check" style="width:730px;border-top: 1px solid #FF7E00;margin-top:-13px;">
                                                                            <div style="width:222px;">
                                                                                <label for="pick" style="float:left;margin-left:2px;margin-top:10px;height:10px;">Schedule a pick up</label>
                                                                                <input class="filetrigger" name="order[0][set1][0][jobfiles][filesubmissionmode]" value="pickUp" id="pick" style="margin-top: 10px ! important; margin-left: 5px; float: left; width: 10px;" type="checkbox">
                                                                            </div>
                                                                            <div style="float:left;">                          
                                                                                <label for="drop" style="float:left;margin-left:2px;margin-top:10px;height:10px;">Drop off at Soho Repro</label>
                                                                                <input class="filetrigger" name="order[0][set1][0][jobfiles][filesubmissionmode]" value="dropOff" id="drop" style="margin-top: 10px ! important; margin-left: 5px; float: left; width: 10px;" type="checkbox">
                                                                            </div>
                                                                            <br>
                                                                            <div id="nn1" style="margin-left:10px;display:none" class="optionwapper man">

                                                                                <div id="kk" style="margin-top:10px;display:block">
                                                                                    <label for="file" style="margin-left: -416px;margin-top:20px;">Pick-up address:</label><br>
                                                                                    <textarea name="order[0][set1][0][jobfiles][pickupadd]" id="order_0_set1_0_jobfiles" rows="3" cols="18" style="float:left;margin-left: -417px;margin-top: -13px;"></textarea> 
                                                                                </div>

                                                                                <div style="width:600px;margin-bottom:0px;display:none"><div style="margin-bottom:0px;"><div style="float:left;margin-right:0px;"><select class="addressnameselect" name="address_name" style="width:150px;" id="namesel">			     
                                                                                                <option selected="selected">a</option>       
                                                                                            </select></div><div class="dropdown_selector"></div></div>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    <div style="margin-bottom:0px;"><div style="float:left;margin-right:0px;"><select class="addressselect" name="address_name" style="width:150px;" id="addsel">			     
                                                                                                <option selected="selected">b</option>       
                                                                                            </select></div><div class="dropdown_selector"></div></div>
                                                                                    <a href="http://soho.thinkdesign.com/user/addresslist" id="dialogload">add entry</a> &nbsp;to address book
                                                                                    <br>
                                                                                    <div style="float:left;margin-left: -342px; margin-top: 17px;"><label style="margin-left: -11px; margin-top: 5px;">When needed:</label> &nbsp; &nbsp;<input name="timereq" style="width:120px;height:22px;margin-left:-19px;" value="ASAP" type="text"></div>
                                                                                </div>
                                                                            </div> 
                                                                            <div style="margin-bottom:10px;">

                                                                                <div id="nn2" style="display:none" class="optionwapper">
                                                                                    <label for="file">Drop-off address:</label><br>
                                                                                    <textarea rows="3" name="order[0][set1][0][jobfiles][dropoffadd]" id="order_0_set1_0_jobfiles" cols="20">160 Water Street,New York,USA</textarea>	             
                                                                                </div> 
                                                                            </div>
                                                                        </div>
                                                                        <br>

                                                                        <br>
                                                                        <div id="sp_inst" style="margin-top:10px;">
                                                                            <label style="font-weight: bold;margin-bottom: -4px; margin-top: -10px;">Special Instructions</label><br>
                                                                            <textarea class="splins" rows="4" cols="60" style="margin-top:-5px;margin-bottom:10px;"></textarea>
                                                                        </div>                       
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </span>
                                        </li>
                                        <li class="clear"><span>
                                                <div style="float:left;width:100%;text-align:right;">
                                                    <input class="addNewOrderSet" value="Add Set" style="float:right;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="button" onclick="return validate_plotting();" />
                                                    <input class="addproductActionLink" value="Save and Continue" style="cursor: pointer; float: right; font-size: 12px; padding: 1.5px; width: 135px; margin-right: 14px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;margin-top: -0px !important;" type="button" onclick="return validate_plotting_cont();" />
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
