<?php
include './admin/config.php';
include './admin/db_connection.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Copy Shop - Services</title>

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
                                <!--  <div class="orderBreadCrumb"></div> -->
                                <h2 class="headline-interior orange" style="text-transform: uppercase;">Copy Shop
                                </h2>
                                <div class="bkgd-stripes-orange">&nbsp;</div>
                                <p style="margin-bottom:10px!important;">
                                    Xerox duplication is a quick way of copying and collating originals from letter to legal to tabloid. Our
                                    standard paper is Recycled Bond with 30% post-consumer waste; 92 bright, 20lb...(more)
                                </p>



                                <form id="copyshop" enctype="application/x-www-form-urlencoded" action="service/copyshop/" method="post" class="systemForm validate orderform"><ul>
                                        <li class="clear"><label style="font-weight: bold;" for="jobref" class="optional">Job Reference Number</label>
                                            <span>
                                                <input aria-haspopup="true" aria-autocomplete="list" role="textbox" autocomplete="off" class="ui-autocomplete-input" name="jobref" id="jobref" type="text"></span></li>
                                        <li class="clear"><span>
                                                <div class="serviceOrderSetHolder"><div style="background-color:#FFFFFF" class="serviceOrderSetWapper" setindex="0"><div class="serviceOrderSetWapperInternal"><h2>OUTPUT</h2><table class="serviceOrderSetTable"><tbody><tr><th></th><th>Originals</th><th></th><th>Print of Ea.<span style="color:red">*</span></th><th>Size</th><th>Print Media</th><th></th></tr><tr class="odd"><td><input class="order_0_set1_0_bw kdChekbox " style="font-weight: bold; width: 10px;" id="order_0_set1_0_bw" name="order[0][set1][0][bw]" value="bw" type="checkbox"><label style="width:50px;float:left;font-weight:normal;">BW</label></td><td><input class="order_0_set1_0_original k-input kdText " style="width:60px;" id="order_0_set1_0_original" name="order[0][set1][0][original]" type="text"></td><td><input value="single-sided" class="order_0_set1_0_sided kdRadio " style="width: 10px;" id="order_0_set1_0_sided" name="order[0][set1][0][sided]" type="radio"> single-sided<br><input value="double-sided" class="order_0_set1_0_sided kdRadio " style="width: 10px;" id="order_0_set1_0_sided" name="order[0][set1][0][sided]" type="radio"> double-sided<br></td><td><input class="ymlrequired order_0_set1_0_printOfEach k-input kdText " style="width:60px;" id="order_0_set1_0_printOfEach" name="order[0][set1][0][printOfEach]" type="text"></td><td><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set1_0_size kdSelect size" style="width: 93px; margin-left: 5px; margin-right: -20px;" id="order_0_set1_0_size" name="order[0][set1][0][size]"><option selected="selected" value="8.5 x 11">8.5 x 11</option><option value="8.5 x 14">8.5 x 14</option><option value="11 x 17">11 x 17</option> </select></div><div style="margin-right: 14px;" class="dropdown_selector"></div></div></td><td><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float: left; margin-right: 20px; width: 15px;"><select class="order_0_set1_0_printMedia kdSelect " style="width: 152px;" id="order_0_set1_0_printMedia" name="order[0][set1][0][printMedia]"><option selected="selected" value="3162">Standard 20 lb</option><option value="3163">Color 20 lb</option><option value="3180">Laser Paper 28 lb</option><option value="3181">Laser Cover 60 lb</option><option value="3182">Laser Cover 80 lb</option><option value="3183">65 lb Card Stock</option><option value="3195">Photo Paper</option><option value="3196">Strathmore 24 lb</option><option value="3257">Acetate</option><option value="3261">Vellum</option> </select></div><div style="margin-right: 14px;" class="dropdown_selector"></div></div></td><td><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float: left; margin-right: 0px; width: 15px;"><select class="order_0_set1_0_variations kdSelect variations" style="width: 87px;" id="order_0_set1_0_variations" name="order[0][set1][0][variations]"><option selected="selected" value="N/A">N/A</option> </select></div><div style="margin-right: 14px;" class="dropdown_selector"></div></div></td></tr><tr class="even"><td><input class="order_0_set1_1_color kdChekbox " style="width: 10px;" id="order_0_set1_1_color" name="order[0][set1][1][color]" value="color" type="checkbox"><label style="width:50px;float:left;font-weight:normal;">Color</label></td><td><input class="order_0_set1_1_original k-input kdText " style="width:60px;" id="order_0_set1_1_original" name="order[0][set1][1][original]" type="text"></td><td><input value="single-sided" class="order_0_set1_1_sided kdRadio " style="width: 10px;" id="order_0_set1_1_sided" name="order[0][set1][1][sided]" type="radio"> single-sided<br><input value="double-sided" class="order_0_set1_1_sided kdRadio " style="width: 10px;" id="order_0_set1_1_sided" name="order[0][set1][1][sided]" type="radio"> double-sided<br></td><td><input class="ymlrequired order_0_set1_1_printOfEach k-input kdText " style="width:60px;" id="order_0_set1_1_printOfEach" name="order[0][set1][1][printOfEach]" type="text"></td><td><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set1_1_size kdSelect " style="width: 93px; margin-left: 5px;" id="order_0_set1_1_size" name="order[0][set1][1][size]"><option selected="selected" value="8.5 x 11">8.5 x 11</option><option value="11 x 17">11 x 17</option> </select></div><div style="margin-right: 14px;" class="dropdown_selector"></div></div></td><td><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float: left; margin-right: 0px; width: 134px;"><select class="order_0_set1_1_printMedia kdSelect " style="width: 148px;" id="order_0_set1_1_printMedia" name="order[0][set1][1][printMedia]"><option selected="selected" value="3442">Color Laser-8-1/2x11</option><option value="3444">Acetate</option><option value="3447">Color Laser Card-8-1/2x11</option> </select></div><div style="margin-right: 14px;" class="dropdown_selector"></div></div></td><td><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set1_1_variations kdSelect variatons" style="width: 85px;" id="order_0_set1_1_variations" name="order[0][set1][1][variations]"><option selected="selected" value="N/A">N/A</option> </select></div><div style="margin-right: 14px;" class="dropdown_selector"></div></div></td></tr></tbody></table></div><div style="clear:both;"></div><div class="serviceOrderSetWapperInternal"><h2>FINISHING</h2><ul class="serviceOrderSetUL"><li style="width: 355px; margin-right: 5px;"><label>Binding</label><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set2_0_binding kdSelect " style="width: 345px;" id="order_0_set2_0_binding" name="order[0][set2][0][binding]"><option value="none" selected="selected">None</option><option value="3290">Wire-O</option><option value="3295">Perfect</option><option value="3288">Screw Post</option><option value="3287">ACCO</option><option value="3271">Staple</option><option value="3285">GBC</option><option value="3283">Velo Binding </option><option value="3291">FastBack</option><option value="3294">Coil</option> </select></div><div style="margin-right: 20px;" class="dropdown_selector"></div></div></li><li style="width: 330px;"><label>Binding Option</label><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set2_0_bindingVariation kdSelect " style="width: 345px;" id="order_0_set2_0_bindingVariation" name="order[0][set2][0][bindingVariation]"><option value="none" selected="selected">None</option><option value="N/A">N/A</option> </select></div><div style="margin-right: 20px;" class="dropdown_selector"></div></div></li><li style="width: 355px; margin-right: 5px;"><label>Front Cover</label><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set2_0_frontCover kdSelect " style="width: 345px;" id="order_0_set2_0_frontCover" name="order[0][set2][0][frontCover]"><option value="none" selected="selected">None</option><option value="3300">Clear Cover</option><option value="3303">Opaque Cover</option><option value="3306">Double Black</option> </select></div><div style="margin-right: 20px;" class="dropdown_selector"></div></div></li><li style="width: 330px;"><label>Back Cover</label><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set2_0_backCover kdSelect " style="width: 345px;" id="order_0_set2_0_backCover" name="order[0][set2][0][backCover]"><option value="none" selected="selected">None</option><option value="3300">Clear Cover</option><option value="3303">Opaque Cover</option><option value="3306">Double Black</option> </select></div><div style="margin-right: 20px;" class="dropdown_selector"></div></div></li><li><label>Folding</label><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set2_0_folding kdSelect " style="width: 225px;" id="order_0_set2_0_folding" name="order[0][set2][0][folding]"><option value="none" selected="selected">None</option><option value="C">C</option><option value="Z">Z</option><option value="Fold in Half">Fold in Half</option> </select></div><div style="margin-right: 14px;" class="dropdown_selector"></div></div></li><li><label>Mounting</label><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set2_0_mounting kdSelect " style="width: 225px;" id="order_0_set2_0_mounting" name="order[0][set2][0][mounting]"><option value="none" selected="selected">None</option><option value="3308">FoamBoard 3/16 White</option><option value="3311">GatorBoard 3/16 White</option><option value="3313">Illustration Board 1/8 White</option><option value="3315">FoamBoard 1/2 White</option><option value="3317">GatorBoard 1/2 White</option> </select></div><div style="margin-right: 14px;" class="dropdown_selector"></div></div></li><li><label>Lamination</label><div class="drop" style="margin-right:0px;margin-left:0px;height:2px;"><div style="float:left;margin-right:0px;"><select class="order_0_set2_0_lamination kdSelect " style="width: 225px;" id="order_0_set2_0_lamination" name="order[0][set2][0][lamination]"><option value="none" selected="selected">None</option><option value="3323">Satin</option><option value="3324">Gloss</option> </select></div><div style="margin-right: 14px;" class="dropdown_selector"></div></div></li><li class="uploadfileholder"><br>
                                                                    <label style="font-weight: bold;">Upload a File</label>                   

                                                                    <div class="uploadfile" style="border-top: 1px solid #FF7E00;width:730px;margin-top:4px;min-height:20px;"> 
                                                                        <div style="border-right: 1px solid #CCCCCC;width:167px; height:110px;float:left;display:none;">                             
                                                                        </div>
                                                                        <div style="width: 300px; height: 100px; float: left; margin-left: -200px; margin-bottom: 20px;">
                                                                            <div id="nn" class="optionwapper">
                                                                                <div><br>
                                                                                    <div class="k-widget k-upload"><div class="k-dropzone"><div class="k-button k-upload-button"><input autocomplete="off" multiple="multiple" name="jobfile" id="order_0_set2_0_jobfiles" class="addFileToOrder" type="file"><span>Upload File</span></div><em>drop files here to upload</em></div></div>
                                                                                    <!--<input name="jobfile" id="" class="addFileToOrder" type="file" />-->
                                                                                </div>  
                                                                            </div>

                                                                        </div>

                                                                        <div style="clear:both;"></div>

                                                                    </div>
                                                                    <div style="width:730px;border-bottom: 1px solid #CCCCCC;"><label style="font-weight: bold; height: 28px; margin-left: -300px; margin-top: -20px;">Alternative File Options</label>               
                                                                        <div class="check" style="width:730px;border-top: 1px solid #FF7E00;margin-top:-13px;">
                                                                            <div style="width:222px;">
                                                                                <label for="pick" style="float:left;margin-left:2px;margin-top:10px;height:10px;">Schedule a pick up</label>
                                                                                <input class="filetrigger" name="order[0][set2][0][jobfiles][filesubmissionmode]" value="pickUp" id="pick" style="margin-top: 10px ! important; margin-left: 5px; float: left; width: 10px;" type="checkbox">
                                                                            </div>
                                                                            <div style="float:left;">                          
                                                                                <label for="drop" style="float:left;margin-left:2px;margin-top:10px;height:10px;">Drop off at Soho Repro</label>
                                                                                <input class="filetrigger" name="order[0][set2][0][jobfiles][filesubmissionmode]" value="dropOff" id="drop" style="margin-top: 10px ! important; margin-left: 5px; float: left; width: 10px;" type="checkbox">
                                                                            </div>
                                                                            <br>
                                                                            <div id="nn1" style="margin-left:10px;display:none" class="optionwapper man">

                                                                                <div id="kk" style="margin-top:10px;display:block">
                                                                                    <label for="file" style="margin-left: -416px;margin-top:20px;">Pick-up address:</label><br>
                                                                                    <textarea name="order[0][set2][0][jobfiles][pickupadd]" id="order_0_set2_0_jobfiles" rows="3" cols="18" style="float:left;margin-left: -417px;margin-top: -13px;"></textarea> 
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
                                                                                    <textarea rows="3" name="order[0][set2][0][jobfiles][dropoffadd]" id="order_0_set2_0_jobfiles" cols="20">160 Water Street,New York,USA</textarea>	             
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

                                                                    <script>
                                                                        $(document).ready(function() {
                                                                            $('#nn1').hide();

                                                                            $('.filetrigger').click(function() {

                                                                                /* if($(this).is(':checked')) {
                                                                                 //alert($(this).val());
                                                                                 $('#drop').removeAttr('checked');                               
                                                                                 //$('#nn1').show();
                                                                                 $(this).parent().parent().children('.man').show();
                                                                                 } else {
                                                                                 $(this).parent().parent().children('.man').hide();
                                                                                 }*/

                                                                                if ($(this).val() == 'pickUp') {

                                                                                    $('#drop').removeAttr('checked');
                                                                                    if ($(this).is(':checked'))
                                                                                    {
                                                                                        $('#nn1').show();
                                                                                    } else {
                                                                                        $('#nn1').hide();
                                                                                    }

                                                                                    //$('#nn1').show();                             
                                                                                }
                                                                                if ($(this).val() == 'dropOff') {
                                                                                    $('#pick').removeAttr('checked');
                                                                                    $('#nn1').hide();
                                                                                }

                                                                            });
                                                                            $('#namesel').change(function(elem) {
                                                                                var option = $('#namesel').val();
                                                                                //alert(option);
                                                                                $.get('/user/getnewaddress/name/' + option, function(data) {
                                                                                    $('#addsel').html(data);
                                                                                });
                                                                            });

                                                                            $('#dialogload').click(function() {
                                                                                var url = $(this).attr('href');
                                                                                var holderID = Math.floor(Math.random() * 1000001) + '_dialog';
                                                                                $('#dynamicAppender').append('<div id=\"' + holderID + '\" class=\"dialog-Box\"></div>');
                                                                                $('#' + holderID).load(url, function() {
                                                                                    $('.ui-dialog:hidden, .ui-dialog:hidden div').remove();
                                                                                    $('#' + holderID).dialog('destroy');
                                                                                    $('#' + holderID).dialog({
                                                                                        height: 535,
                                                                                        modal: true,
                                                                                        width: 509
                                                                                    });

                                                                                });
                                                                                return false;
                                                                            });
                                                                            return false;


                                                                        });
                                                                    </script><script>$(document).ready(function() {

                                                                            $("#order_0_set2_0_jobfiles").kendoUpload({
                                                                                async: {
                                                                                    saveUrl: "service/fileupload",
                                                                                    removeUrl: "service/fileupload",
                                                                                    autoUpload: true
                                                                                },
                                                                                complete: releaseform,
                                                                                upload: blockform,
                                                                                localization: {
                                                                                    select: "Upload File"
                                                                                }



                                                                            });

                                                                        });</script></li></ul></div><div style="clear:both;"></div></div></div><div style="width:auto;text-align:right"><input class="addNewOrderSet" value="Add Set" style="float:right;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px;margin-right:130px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="submit"></div><script> $(document).ready(function() {
                                                                                $('.order_0_set1_0_bw').removeAttr('disabled');
                                                                                $('.order_0_set1_0_original').change(function() {
                                                                                    $('.order_0_set1_0_bw').attr('checked', 'checked');
                                                                                })
                                                                                $('.order_0_set1_0_sided').change(function() {
                                                                                    $('.order_0_set1_0_bw').attr('checked', 'checked');
                                                                                })
                                                                                $('.order_0_set1_0_printOfEach').change(function() {
                                                                                    $('.order_0_set1_0_bw').attr('checked', 'checked');
                                                                                })
                                                                                $('.order_0_set1_0_size').change(function() {
                                                                                    $('.order_0_set1_0_bw').attr('checked', 'checked');
                                                                                })
                                                                                $('.order_0_set1_0_printMedia').change(function() {
                                                                                    $('.order_0_set1_0_bw').attr('checked', 'checked');
                                                                                })
                                                                                $('.order_0_set1_0_size').change(function() {
                                                                                    updateCombinedSource({"sided": "order_0_set1_0_sided", "size": "order_0_set1_0_size", "output": "order_0_set1_0_bw"}, "order_0_set1_0_printMedia");
                                                                                })
                                                                                $('.order_0_set1_0_sided').change(function() {
                                                                                    updateCombinedSource({"sided": "order_0_set1_0_sided", "size": "order_0_set1_0_size", "output": "order_0_set1_0_bw"}, "order_0_set1_0_printMedia");
                                                                                })
                                                                                $('.order_0_set1_0_printMedia').change(function() {
                                                                                    updateVariations(this, 'order_0_set1_0_variations');
                                                                                })
                                                                                $('.order_0_set1_1_original').change(function() {
                                                                                    $('.order_0_set1_1_color').attr('checked', 'checked');
                                                                                })
                                                                                $('.order_0_set1_1_sided').change(function() {
                                                                                    $('.order_0_set1_1_color').attr('checked', 'checked');
                                                                                })
                                                                                $('.order_0_set1_1_printOfEach').change(function() {
                                                                                    $('.order_0_set1_1_color').attr('checked', 'checked');
                                                                                })
                                                                                $('.order_0_set1_1_size').change(function() {
                                                                                    $('.order_0_set1_1_color').attr('checked', 'checked');
                                                                                })
                                                                                $('.order_0_set1_1_printMedia').change(function() {
                                                                                    $('.order_0_set1_1_color').attr('checked', 'checked');
                                                                                })
                                                                                $('.order_0_set1_1_size').change(function() {
                                                                                    updateCombinedSource({"sided": "order_0_set1_1_sided", "size": "order_0_set1_1_size", "output": "order_0_set1_1_color"}, "order_0_set1_1_printMedia");
                                                                                })
                                                                                $('.order_0_set1_1_sided').change(function() {
                                                                                    updateCombinedSource({"sided": "order_0_set1_1_sided", "size": "order_0_set1_1_size", "output": "order_0_set1_1_color"}, "order_0_set1_1_printMedia");
                                                                                })
                                                                                $('.order_0_set1_1_printMedia').change(function() {
                                                                                    updateVariations(this, 'order_0_set1_1_variations');
                                                                                })
                                                                                $('.order_0_set2_0_binding').change(function() {
                                                                                    updateVariations(this, 'order_0_set2_0_bindingVariation');
                                                                                })
                                                                            });</script></span></li>
                                        <li class="clear"><span>
                                                <div style="height:29px;">&nbsp;</div><input class="addproductActionLink" value="Continue" style="cursor: pointer;float:right;font-size:12px; padding:1.5px; width: 100px;margin-right:14px;margin-top:15px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="submit"><div style="clear:both"></div></span></li></ul></form>           <!--  <div class="continute_service_shopping">
                                                                    Add <select name="redirect_to" id="redirect_to">
                                                                        <option value="plotting">Plotting</option>
                                                                        <option value="view/store">Supplies</option>
                                                                        <option value="service/scanning">Scanning</option>
                                                                    </select> to my order &nbsp;&nbsp;&nbsp;
                                                                    <input class="continute_service_shopping_link" type="submit" value="Go >" style="cursor: pointer;font-size:12px; padding:1.5px; width: 50px;margin-right:14px;margin-top:5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;"/>               
                                                                </div>
                                                            </div>
                                -->


                                <!-- #######modified #######-->

                                <input id="action" value="qq" type="hidden">
                                <div id="terms" style="display:none;margin-left: -20px;margin-top: -37px;">

                                    <div style="margin-top:2px;width:300px;height:177px;background-color:#F9F2DE;padding:5px 34px 0px 34px;">
                                        <img id="closeit" style="height:15px;margin-left: 305px;margin-top:-30px;" src="SohoRepro-copyshop_files/rr.png"><br><br>
                                        <h2 class="headline-interior orange">
                                            REGISTER
                                        </h2>

                                        <hr style="margin-top:10px;margin-bottom: 4px;" color="#FF7E00">

                                        <!--<form style="padding-top: 12px;" id="signup" enctype="application/x-www-form-urlencoded" method="post" action="user/sortregistration">-->
                                        <form style="padding-top: 5px;" id="chkuserregister" enctype="application/x-www-form-urlencoded"> 

                                            <label style="padding:0px 2px 2px 0;">               
                                                <span style="font-size:11px;">Are you from :</span>
                                            </label><br><br>
                                            <label style="padding:2px 2px 2px 0;">               
                                                <span id="userchk" style="font-size:16px;font-weight:bold;" tvalue=""> </span>
                                            </label><br>

                                            <span>                
                                                <input id="cls_yes" class="subNewOrderSet1" style="margin-left:245px;cursor: pointer;font-size:12px; padding:1.5px; width: 60px;margin-top:24px;margin-right:25px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" value="Yes" type="submit">
                                            </span>
                                            <div style="margin-top:-28px;">                
                                                <input id="cls_no" class="subNewOrderSet1" style="margin-left:172px;cursor: pointer;font-size:12px; padding:1.5px; width: 60px;margin-top:8px;margin-right:15px;; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" value="No" type="submit">
                                            </div>
                                            <input id="list" name="list" value="" type="hidden">

                                        </form>


                                    </div>    

                                </div>
                                <!--- No --->

                                <div id="optionno" style="display:none;margin-left: -20px;margin-top: -37px;">

                                    <div style="margin-top:2px;width:302px;height:558px;background-color:#F9F2DE;padding:5px 34px 0px 34px;">
                                        <img id="closeit" style="height:15px;margin-left: 305px;margin-top:-30px;" src="SohoRepro-copyshop_files/rr.png"><br><br>
                                        <h2 class="headline-interior orange">
                                            REGISTER
                                        </h2>

                                        <hr style="margin-top:10px;margin-bottom: 4px;" color="#FF7E00">

                                        <form style="padding-top: 5px;" id="chkuserregister" enctype="application/x-www-form-urlencoded" method="post" action="user/sortregistration"> 

                                            <ul style="list-style: none">
                                                <li>
                                                    <input id="status" name="status" value="long" type="hidden">
                                                </li>
                                                <li>
                                                    <input id="phoneno" name="phoneno" value="" type="hidden">
                                                </li>
                                                <li>
                                                    <label style="padding:2px 2px 2px 0;">               
                                                        <span style="font-sixe:16px;">Name</span>
                                                    </label><br>
                                                    <span>
                                                        <input id="firstname" class="ui-autocomplete-input" name="name" style="border:1px solid #CCCCCC;margin-top:8px; width: 65%;margin-bottom:6px;height:20px;" type="text">
                                                    </span>
                                                </li>

                                                <li>
                                                    <label style="padding:2px 2px 2px 0;">               
                                                        <span style="font-sixe:16px;">Email</span>
                                                    </label><br>
                                                    <span>
                                                        <input id="email" class="ui-autocomplete-input" name="email" style="border:1px solid #CCCCCC;margin-top:8px; width: 65%;margin-bottom:6px;height:20px;" type="text">
                                                    </span>
                                                </li>
                                                <li>
                                                    <label style="padding:2px 2px 2px 0;">               
                                                        <span style="font-sixe:16px;">Company Name</span>
                                                    </label><br>
                                                    <span>
                                                        <input id="companyname" class="ui-autocomplete-input" name="companyname" style="border:1px solid #CCCCCC;margin-top:8px; width: 65%;margin-bottom:6px;height:20px;" type="text">
                                                    </span>
                                                </li>
                                                <li class="clear">
                                                    <label>
                                                        Address
                                                        <span style="font-sixe:16px;font-weight:bold;"></span>
                                                    </label>
                                                    <span>
                                                        <br>
                                                        <label style="padding-left:0;padding-right:0;font-weight:normal;font-size:10px;font-family:arial;">Street Address Line 1</label><br>
                                                        <input id="addressLineOne" name="address[lines][0]" style="border:1px solid #CCCCCC;margin-top:8px; width: 65%;margin-bottom:6px;height:20px;" type="text"><br>
                                                        <label style="padding-left:0;padding-right:0;font-weight:normal;font-size:10px;font-family:arial;">Street Address Line 2</label><br>
                                                        <input id="addressLineTwo" name="address[lines][1]" style="border:1px solid #CCCCCC;margin-top:8px; width: 65%;margin-bottom:6px;height:20px;" type="text">
                                                        <label style="padding-left:0;padding-right:0;margin-right:4%;font-weight:normal;font-size:10px;font-family:arial;width:46%;float:left;">City</label>
                                                        <input id="addressCity" name="address[city]" style="margin-top:5px;width:65%;height:20px;float:left;margin-right:4%;border:1px solid #CCCCCC;" type="text">
                                                        <br>	    
                                                        <label style="padding-left:0;padding-right:0;font-weight:normal;font-size:10px;font-family:arial;width:45%;float:left;">State</label>
                                                        <input id="addressState" name="address[state]" style="margin-top:5px;width:65%;height:20px;float:left;border:1px solid #CCCCCC;" type="text">
                                                        <div style="clear:both"></div>
                                                        <br>
                                                        <label style="padding-left:0;padding-right:0;margin-right:4%;font-weight:normal;font-size:10px;font-family:arial;width:46%;float:left;">Zip/Postal Code</label>
                                                        <input id="addressZipCode" name="address[pin]" style="margin-top:5px;width:65%;height:20px;float:left;margin-right:4%;border:1px solid #CCCCCC;" type="text">
                                                        <br>
                                                        <label style="padding-left:0;padding-right:0;font-weight:normal;font-size:10px;font-family:arial;width:45%;float:left;">Country </label>
                                                        <input id="addressCountry" name="address[country]" style="margin-top:5px;width:65%;height:20px;float:left;border:1px solid #CCCCCC;" type="text">

                                                        <div style="clear:both"></div>
                                                    </span>
                                                </li>
                                                <li>
                                                    <input class="submitnobutton" style="margin-left:156px;cursor: pointer;font-size:12px; padding:1.5px; width: 60px;margin-top:16px;margin-right:15px;; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" value="Submit" type="submit">

                                                </li>
                                            </ul>  

                                        </form>

                                    </div>    

                                </div>
                                <!--- Yes --->


                                <div id="optionyes" style="display:none;margin-left: -20px;margin-top: -37px;">

                                    <div style="margin-top:2px;width:302px;height:230px;background-color:#F9F2DE;padding:5px 34px 0px 34px;">
                                        <img id="closeit1" class="closeit" style="height:15px;margin-left: 305px;margin-top:-30px;" src="SohoRepro-copyshop_files/rr.png"><br><br>
                                        <h2 class="headline-interior orange">
                                            REGISTER
                                        </h2>

                                        <hr style="margin-top:10px;margin-bottom: 4px;" color="#FF7E00">


                                        <form style="padding-top: 5px;" id="chkuserregister" enctype="application/x-www-form-urlencoded" method="post" action="user/sortregistration"> 

                                            <ul style="list-style: none">
                                                <li>
                                                    <input id="status1" name="status" value="short" type="hidden">
                                                </li>
                                                <li>
                                                    <input id="phoneno1" name="phoneno" value="" type="hidden">
                                                </li>
                                                <li>
                                                    <label style="padding:2px 2px 2px 0;">               
                                                        <span style="font-sixe:16px;">Name</span>
                                                    </label><br>
                                                    <span>
                                                        <input id="firstname1" class="ui-autocomplete-input" name="name" style="border:1px solid #CCCCCC;margin-top:8px; width: 65%;margin-bottom:6px;height:20px;" type="text">
                                                    </span>
                                                </li>

                                                <li>
                                                    <label style="padding:2px 2px 2px 0;">               
                                                        <span style="font-sixe:16px;">Email</span>
                                                    </label><br>
                                                    <span>
                                                        <input id="email1" class="ui-autocomplete-input" name="email" style="border:1px solid #CCCCCC;margin-top:8px; width: 65%;margin-bottom:6px;height:20px;" type="text">
                                                    </span>
                                                </li>	    

                                                <li>
                                                    <input class="submityesbutton" style="margin-left:156px;cursor: pointer;font-size:12px; padding:1.5px; width: 60px;margin-top:16px;margin-right:15px;; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" value="Submit" type="submit">

                                                </li>
                                            </ul>  

                                        </form>

                                    </div>    

                                </div>
                                <div style="clear:both;"></div>

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
