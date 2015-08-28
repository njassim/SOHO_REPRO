<?php
include './admin/config.php';
include './admin/db_connection.php';

if($_SESSION['sohorepro_companyid']  == '')
{
  header("Location:index.php");
  exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
 <!-- Mirrored from buckart.com/srsite/SoHoRepro-WebsitePages/store/store.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 21 Sep 2013 08:44:50 GMT -->
 <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
 <head>
 <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
 <title> SohoRepro </title>

 <!-- base href="http://soho.thinkdesign.com/" -->

 <link rel="stylesheet" href="store_files/style.css" type="text/css" media="screen"> 
 <link rel="stylesheet" href="store_files/theme.css" type="text/css" media="screen"> 
 <link rel="stylesheet" href="store_files/jquery.css" type="text/css" media="screen"> 
 <link rel="stylesheet" href="store_files/tiptip.css" type="text/css" media="screen"> 
 <link rel="stylesheet" href="store_files/ajaxLoader.css" type="text/css" media="screen"> 
 <link rel="stylesheet" href="store_files/flexigrid.css" type="text/css" media="screen"> 
 <link rel="stylesheet" href="store_files/ui.css" type="text/css" media="screen"> 
 <link rel="stylesheet" href="store_files/slick.css" type="text/css" media="screen"> 
 <link rel="stylesheet" href="store_files/kendo.css" type="text/css" media="screen"> 
 <link rel="stylesheet" href="store_files/kendo_002.css" type="text/css" media="screen"> 
 <link rel="stylesheet" href="store_files/style_002.css" type="text/css" media="screen">

 
 <link href="style/popup_style.css" rel="stylesheet" type="text/css" media="all" />
 <!--<link rel="shortcut icon" href="http://soho.thinkdesign.com/favicon.ico" type="image/x-icon">-->
 <link rel="stylesheet" type="text/css" href="store_files/style_layout.css">
 <!--[if IE 7]>
 <link rel="stylesheet" type="text/css" href="css/ie_7_hacks.css" />
 <![endif]-->
 <script src="store_files/jquery.min.js"></script>
<script> 
function dtls_reveal(ID)
{
    var slide_up = $("#slide_id").val();
    $("#plotting_details_"+ID).slideToggle();
    if(slide_up != ID){
    $("#plotting_details_"+slide_up).slideUp();
    }
    $("#slide_id").val(ID);
}

function delete_plot(ID)
{
    //alert(ID);
}
</script>
 <style>
     #result_ref
{
    background-color: #f3f3f3;
    border-top: 0 none;
    box-shadow: 0 0 5px #ccc;
    display: none;
    margin-top: 0;
    overflow: hidden;
    padding: 10px;
    position: absolute;
    right: 0;
    text-align: left;
    top: 19px;
    width: 185px;
}

.auto_reference{
    cursor: pointer;
    list-style-type: none;
}

.auto_reference li:hover
{
    background:#FF7E00;
    color:#FFF;
    cursor:pointer;
}
.auto_reference li
{
    border-bottom: 1px #999 dashed;
}
.auto_reference span{
    font-size: 18px;
}
.none{
    display: none;
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
<div id="cart_tabl">
    <div id="content_output-navigation">
  <ul class="navigation primary">
    <li class="navPlotting">
        <a href="#" class="" style="font-weight: bold;">
        PLOTTING &amp; ARCHITECTURAL COPIES
      </a>
    </li>
    <li class="navLargeFormat">
      <a href="#" class=" ">
        LARGE FORMAT COLOR &amp; BW
      </a>
    </li>
    <li class="navFineArts">
      <a href="#" class=" ">
        FINE ART PRINTING
      </a>
    </li>
    <li class="navCopyshop">
      <a href="#" class=" ">
        COPY SHOP
      </a>
    </li>
    <li class="navMounting">
      <a href="#" class=" ">
        MOUNTING &amp; LAMINATING
      </a>
    </li>
    <li class="navBinding">
      <a href="#" class=" ">
        BINDING
      </a>
    </li>
    <li class="navScanning">
      <a href="#" class=" ">
        SCANNING
      </a>
    </li>
    <li class="navOffset">
      <a href="#" class=" ">
        OFFSET PRINTING
      </a>
    </li>
  </ul>
  <div style="clear:both">
  </div>
  
</div>
</div>
<div id="orderWapper">
  <!-- 
<div class="orderBreadCrumb">
</div>
-->
<?php 

if($_REQUEST['plotting_set'] == '1'){
    extract($_POST);   
    
    $origininals_1     = mysql_real_escape_string($original);
    $print_ea_1        = mysql_real_escape_string($print_ea);
    $size_1            = mysql_real_escape_string($size);
    $output_1          = mysql_real_escape_string($output);   
    $media_1           = mysql_real_escape_string($media);
    $binding_1         = mysql_real_escape_string($binding);
    $mounting_1        = mysql_real_escape_string($mounting);
    $lamination_1      = mysql_real_escape_string($lamination);
    $folding_1         = mysql_real_escape_string($folding);
    $upload_file_1     = mysql_real_escape_string($folding);
    $pick_up_1         = mysql_real_escape_string($pickupadd);
    $drop_1            = mysql_real_escape_string($dropoffadd);
    $spl_instruction_1 = mysql_real_escape_string($spl_ins);
    $referece_id        = mysql_real_escape_string($jobref_id);
    
    $quert_plottin_insert = "INSERT INTO sohorepro_plotting_set (`origininals`, `print_ea`, `size`, `output`, `media`, `binding`, `mounting`, `lamination`, `folding`, `upload_file`, `pick_up`, `drop`, `spl_instruction`, `referece_id`, `company_id`) VALUES ('$origininals_1', '$print_ea_1', '$size_1', '$output_1', '$media_1', '$binding_1', '$mounting_1', '$lamination_1', '$folding_1', '$folding_1', '$pick_up_1', '$drop_1', '$spl_instruction_1', '$referece_id', '$company_id')";
    
    $result_plotting = mysql_query($quert_plottin_insert);
    if ($result_plotting) {
        $result = "success_plotting";
    } else {
        $result = "failure_plotting";
    }    
}

?>


  <h2 class="headline-interior orange" style="text-transform: uppercase;">
	Plotting 
  </h2>
  <div class="bkgd-stripes-orange">
    &nbsp;
  </div>
    <?php
    if ($result == "success_plotting") {
        ?>
        <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Set Added Successfully</div>
        <script>setTimeout("location.href=\'services.php\'", 1000);</script>
        <?php
    } elseif ($result == "failure_plotting") {
        ?>
        <div style="color:#F00; text-align:center; padding-bottom:10px;">Set Added Not Successfully</div>
        <script>setTimeout("location.href=\'services.php\'", 1000);</script>       
        <?php
    }
    ?>
  <p style="margin-bottom:10px!important;">
	Our high speed electrostatic plotters can quickly process your CAD files. We are able to receive
      electronic AutoCad files from release 14 and up...(more)
      
  </p>

        <div id="view_butt" style="width: 100%;float: left;">
            <span style="float: right;color: #ff7e00;cursor: pointer;text-decoration: none;" onclick="return view_plot_values();">VIEW SETS</span>
        </div>
        <div id="go_set" style="width: 100%;float: left;display: none;">
            <span style="float: right;color: #ff7e00;cursor: pointer;text-decoration: none;" onclick="return go_set_form();">GO FORM</span>
        </div>
        <div id="set_form">
            
                    <form id="plotting" action="" method="post" class="systemForm orderform" onsubmit="return validate_plotting();">
                  <input type="hidden" name="plotting_set" value="1" />
                <ul>
                  <li class="clear">
                    <label style="font-weight: bold;" for="jobref" class="optional">
                      Job Reference Number
                    </label>
                    <span style="position: relative;">
                        <?php
            //            echo '<pre>';
            //            print_r($_SESSION);
            //            echo '</pre>';
                        ?>
                        <input aria-haspopup="true" aria-autocomplete="list" role="textbox" autocomplete="off" class="ui-autocomplete-input dec" style="padding:3px;width: 195px;text-transform: uppercase;" name="jobref" id="jobref" type="text" value="" />
                        <div id="result_ref">
                        </div>
                        <input type="hidden" name="user_session" id="user_session" value="<?php echo $_SESSION['sohorepro_userid']; ?>" />
                        <input type="hidden" name="user_session_comp" id="user_session_comp" value="<?php echo $_SESSION['sohorepro_companyid']; ?>" />
                        <input type="hidden" name="jobref_id" id="jobref_id" value="" />
                        <input type="hidden" name="company_id" id="company_id" value="" />                        
                    </span>
                  </li>
                  <li class="clear">
                    <label style="font-weight: bold; margin-bottom: -4px; margin-top: 0px;" for="jo1" class="optional">
                      Job Options
                    </label>
                    <span>
                      <input name="jo1" value="" style="margin-bottom:-5px;" id="jo1" type="hidden">
                    </span>
                  </li>
                  <li class="clear">
                    <span>
                      <div class="serviceOrderSetHolder">
                        <div style="background-color:#FFFFFF" class="serviceOrderSetWapper" setindex="0">
                          <div class="serviceOrderSetWapperInternal">
                            <div class="serviceOrderSetDIV">
                              <div>
                                <label>
                                  Originals
                                </label>
                                <input class="order_0_set1_0_original k-input kdText " style="width:65px;" id="order_0_set1_0_original" name="original" type="text">
                              </div>
                              <div>
                                <label>
                                  Print of Ea.
                                  <span style="font-weight:bold;color:#cc0000">
                                    *
                                  </span>
                                </label>
                                <input class="ymlrequired order_0_set1_0_printOfEach k-input kdText " style="width:68px;" id="order_0_set1_0_printOfEach" name="print_ea" type="text">
                              </div>
                              <div>
                                <label>
                                  Size
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_size kdSelect " style="width: 90px;" id="order_0_set1_0_size" name="size">                            
                                      <option selected="selected" value="FULL">FULL</option>
                                      <option value="HALF">HALF</option>
                                      <option value="Reduce to 11 X 17">Reduce to 11 X 17</option>
                                      <option value="Custom">Custom</option>                          
                                    </select>
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>
                              <div>
                                <label>
                                  Output
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_output kdSelect " style="width: 90px;" id="order_0_set1_0_output" name="output">
                                      <option selected="selected" value="B/W">B/W</option>
                                      <option value="Color">Color</option></select>
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>
                              <div>
                                <label>
                                  Media
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_media kdSelect " style="width: 150px;" id="order_0_set1_0_media" name="media">
                                      <option selected="selected" value="3378">Plotting-B&amp;W on Bond</option>
                                      <option value="3380">Plotting-B&amp;W on Vellum</option>
                                      <option value="3382">Plotting-B&amp;W on Mylar</option>                          
                                    </select>
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>
                              <div>
                                <label>
                                  Binding
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_binding kdSelect " style="width: 120px;" id="order_0_set1_0_binding" name="binding">
                                      <option value="none" selected="selected">None</option>
                                      <option value="3272">Stapling-Hand</option>
                                      <option value="3288">Screw Post</option>
                                      <option value="3363">Binding Strip</option>                          
                                    </select>
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>
                              <div style="clear:both;">
                                <label>
                                  Mounting
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_mounting kdSelect " style="width: 160px;" id="order_0_set1_0_mounting" name="mounting">
                                      <option value="none" selected="selected">None</option>
                                      <option value="3308">FoamBoard 3/16 White</option>
                                      <option value="3309">FoamBoard 3/16 Black</option>
                                      <option value="3315">FoamBoard 1/2 White</option>
                                      <option value="3316">FoamBoard 1/2 Black</option>
                                      <option value="3311">GatorBoard 3/16 White</option>
                                      <option value="3312">GatorBoard 3/16 Black</option>
                                      <option value="3317">GatorBoard 1/2 White</option>
                                      <option value="3318">GatorBoard 1/2 Black</option>
                                      <option value="3313">Illustration Board 1/8 White</option>
                                      <option value="3319">Plasti-Cor  WHITE</option>

                                    </select>
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>
                              <div>
                                <label>
                                  Lamination
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_lamination kdSelect " style="width: 160px;" id="order_0_set1_0_lamination" name="lamination">
                                      <option value="none" selected="selected">None</option>
                                      <option value="3323">Satin</option>
                                      <option value="3324">Gloss</option>                          
                                    </select>
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>
                              <div>
                                <label>
                                  Folding
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_folding kdSelect " style="width: 160px;" id="order_0_set1_0_folding" name="folding">
                                      <option value="none" selected="selected">None</option>
                                      <option value="3362">Yes</option>                          
                                    </select>
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>
                              <div style="width:728px;">
            <!--                    <br>
                                    <label style="font-weight: bold;">
                                  Upload a File
              </label>


              <div class="uploadfile" style="border-top: 1px solid #FF7E00;width:730px;margin-top:4px;min-height:20px;">

                <div style="border-right: 1px solid #CCCCCC;width:167px; height:110px;float:left;display:none;">

                </div>
                <div style="width: 300px; height: 40px; float: left; margin-left: -5px;">
                  <div id="nn" class="optionwapper">
                    <div>
                      <br>
                      <div class="k-widget k-upload">
                        <div class="k-dropzone">
                          <div class="k-dropzone">
                            <div class="k-button k-upload-button">
                              <input autocomplete="off" multiple="multiple" name="jobfile" id="order_0_set1_0_jobfiles" class="addFileToOrder" type="file">
                              <span>
                                Upload File
                              </span>
                            </div>
                            <em>
                              drop files here to upload
                            </em>
                          </div>
                          <em>
                            drop files here to upload
                          </em>
                          <em>
                            drop files here to upload
                          </em>
                        </div>
                      </div>

            <input name="jobfile" id="" class="addFileToOrder" type="file" />

                                             </div>

                                         </div>

                                        </div>

                                        <div style="clear:both;">
                                        </div>

              </div>-->
              <div style="width:730px;border-bottom: 1px solid #CCCCCC;">
                <label style="font-weight: bold;height:28px">
                  Alternative File Options
                </label>

                <div class="check" style="width:730px;border-top: 1px solid #FF7E00;margin-top:-13px;">
                  <div style="width:222px;">
                    <label for="pick" style="float:left;margin-left:2px;margin-top:10px;height:10px;">
                      Schedule a pick up
                    </label>
                    <input class="filetrigger" name="pickup" value="pickUp" id="pick" style="margin-left: 5px; float: left; width: 10px; margin-top: 10px !important;" type="checkbox">
                  </div>
                  <div style="float:left;">

                    <label for="drop" style="float:left;margin-left:2px;margin-top:10px;height:10px;">
                      Drop off at Soho Repro
                    </label>
                    <input class="filetrigger" name="drop" value="dropOff" id="drop" style="margin-left: 5px; float: left; width: 10px; margin-top: 10px !important;" type="checkbox">
                  </div>
                  <br>
                  <div id="nn1" style="margin-left: 10px; display: none;" class="optionwapper man">

                    <div id="kk" style="margin-top:10px;display:block">
                      <label for="file" style="margin-left: -416px;margin-top:20px;">
                        Pick-up address:
                      </label>
                      <br>
                      <textarea name="pickupadd" id="order_0_set1_0_jobfiles" rows="3" cols="18" style="float:left;margin-left: -417px;margin-top: -13px;">
                      </textarea>

                    </div>

                    <div style="width:600px;margin-bottom:0px;display:none">
                      <div style="margin-bottom:0px;">
                        <div style="float:left;margin-right:0px;">
                          <select class="addressnameselect" name="address_name" style="width:150px;" id="namesel">

                            <option selected="selected">
                              a
                            </option>

                          </select>
                        </div>
                        <div class="dropdown_selector">
                        </div>
                      </div>
                      &nbsp;&nbsp;&nbsp;&nbsp;
                      <div style="margin-bottom:0px;">
                        <div style="float:left;margin-right:0px;">
                          <select class="addressselect" name="address_name" style="width:150px;" id="addsel">                
                            <option selected="selected">b</option>
                          </select>
                        </div>
                        <div class="dropdown_selector">
                        </div>
                      </div>
                      <a href="http://soho.thinkdesign.com/user/addresslist" id="dialogload">
                        add entry
                      </a>
                      &nbsp;to address book
                      <br>
                      <div style="float:left;margin-left: -342px; margin-top: 17px;">
                        <label style="margin-left: -11px; margin-top: 5px;">
                          When needed:
                        </label>
                        &nbsp; &nbsp;
                        <input name="timereq" style="width:120px;height:22px;margin-left:-19px;" value="ASAP" type="text">
                      </div>
                    </div>
                  </div>

                  <div style="margin-bottom:10px;">

                    <div id="nn2" style="display:none" class="optionwapper">
                      <label for="file">
                        Drop-off address:
                      </label>
                      <br>
                      <textarea rows="3" name="dropoffadd" id="order_0_set1_0_jobfiles" cols="20">
                      </textarea>

                    </div>

                  </div>
                </div>
                <br>

                <br>
                <div id="sp_inst" style="margin-top:10px;">
                  <label style="font-weight: bold;margin-bottom: -4px; margin-top: -10px;">
                    Special Instructions
                  </label>
                  <br>
                      <textarea name="spl_ins" class="splins" rows="4" cols="60" style="margin-top:-5px;margin-bottom:10px;">
                  </textarea>
                </div>

              </div>


              </div>
              </div>
              </div>
              <div style="clear:both;">
              </div>
              </div>
              </div>
              <div style="width:auto;text-align:right">
                <input class="addNewOrderSet" value="Add Set" style="float:right;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px;margin-right:130px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="submit">
              </div> 
              </span>
              </li>
              <li class="clear">
                <span>
                  <div style="height:29px;">
                    &nbsp;
                  </div>
                    <input class="addproductActionLink" value="Continue" style="cursor: pointer; float: right; font-size: 12px; padding: 1.5px; width: 100px; margin-right: 14px; margin-top: -84px; border: 1px solid rgb(143, 143, 143);" type="button">
                  <div style="clear:both">
                  </div>
                </span>
              </li>
              </ul>
              </form>
        </div>
        <style>
            .set_ul{
                list-style: none;
                width: 90%;
                margin: 0 auto;
                margin-top: 10px;   
            }
            .set_ul li{               
                width: 100%;
                float: left;
                padding: 5px;                
            }
            .head_plat{
                background: #ff7e00 !important;
                padding: 5px;
            }
            .head_plat span{
                font-size: 14px !important;
                font-weight: bold;           
            }
            .set_ul li span{              
                width: 33%;
                text-align: center;
                float: left;                
            }
        </style>
        <div id="set_values" style="width:100%;height:300px;float: left;display: none;">           
            <?php 
            $set_plotting = AllSetPlottinf($_SESSION['sohorepro_companyid']);
//            echo '<pre>';
//            print_r($set_plotting);
//            echo '</pre>';                    
            ?>
            <ul class="set_ul">
                <li class="head_plat">
                    <span>S.No</span>
                    <span>Reference Name</span>
                    <span>Action</span>                    
                </li>
                <?php 
                $i = 1;
                foreach ($set_plotting as $plotting){
                    $id       = $plotting['id'];
                    $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                    $reference_name = strtoupper(ReferenceName($plotting['referece_id']));
                ?>
                <li style="background: <?php echo $rowColor; ?>;cursor: pointer;" onclick="dtls_reveal('<?php echo $id; ?>');">
                    <span><?php echo $i; ?></span>
                    <span><?php echo $reference_name; ?></span>
                    <span><img src="admin/images/del.png" alt="Delete" title="Delete" onclick="delete_plot('<?php echo $id; ?>')" border="0" /></span>                    
                </li>
                <input type="hidden" name="slide_id" id="slide_id" value="0" />
                <li id="plotting_details_<?php echo $id; ?>" style="background: #FFF;display:none;">
                    <div style="width:100%;border: 2px #ff7e00 solid;height:100px;">
                        <table align="center" style="width:95%;margin: 0 auto;margin-top: 7px;" >
                            <tr>
                                <td style="width:50%;">
<!--                                    <table style="width:100%;">
                                        <tr style="width:50%;"><td>Test 1</td><td style="width:50%;">Test 1</td></tr>                                                                           
                                    </table>                                -->
                                </td>
                                <td style="width:50%;">
<!--                                     <table style="width:100%;">
                                        <tr style="width:50%;"><td>Test 1</td><td style="width:50%;">Test 1</td></tr>
                                    </table>                                   -->
                                </td>
                            </tr>
                        </table>
                    </div>                    
                </li>
                <?php 
                $i++;
                } 
                ?>
            </ul>
        </div>
        
</div>


 <div class="login_loader"></div>
 <div id="backgroundPopup"></div>

<?php
//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>';  
     ?>
     
<!-----TABLE END--->     
 </div>

 <div class="clear"></div>
 </div>
 <div class="clear"></div>

 <div class="footerSRwapper" style="margin:auto;height:61px;">
 <div id="body_footer-inner" class="body_wrapper-inner">
 <ul class="navigation footer">
 <li><a href="#"><span>About SohoRepro</span></a></li>
 <li><a href="#"><span>FAQs</span></a></li>
 <li><a href="#"><span>Privacy Policy</span></a></li>
 <li><a href="#"><span>Security</span></a></li>
 <li><a href="#"><span>Terms of Use</span></a></li>
 <li><a href="#"><span>Contact</span></a></li>
 <div class="clear"></div>
 </ul>
 </div>
 </div>

 </div>
 </div>
 <div class="clear"></div>



 </div>

 <div id="dynamicAppender" style="postion:absolute;top:-5000px"></div>

 
 <script>
     
  function validate_plotting()
  {
    var jobreference = document.getElementById("jobref").value;
    if(jobreference == ''){
        alert('Please enter the Job Reference');
        document.getElementById("jobref").focus();
        return false;
    }
    
  }   
     
     
     
 $(function() {
$("#jobref").keyup(function()
{
    var searchid = $(this).val();
    var user_id = document.getElementById("user_session").value;
    var comp_id = document.getElementById("user_session_comp").value;
    var dataString = 'search=' + searchid + '&user_id=' + user_id + '&comp_id=' + comp_id;
    if (searchid != '')
    {
        $.ajax({
            type: "POST",
            url: "auto_reference_plotting.php",
            data: dataString,
            cache: false,
            success: function(html)
            {
                if (html != '') {
                    $("#result_ref").html(html).show();
                } else {
                    $("#result_ref").hide();
                }
            }
        });
    }
    return false;
});
 });
 
function get_reference(auto_ref,ID,COMP_ID)
    {
        //alert(auto_ref);
        $("#jobref").val(auto_ref);
        $("#jobref_id").val(ID);
        $("#company_id").val(COMP_ID);
        $("#result_ref").hide();
//        $.ajax
//        ({
//        type: "POST",
//        url: "admin/get_child.php",
//        data: "referece_set_fav=" + auto_ref,
//        success: function(option)
//        {
//
//        }
//        });
    }
    
function view_plot_values()
{
    $('#set_form').hide(750);
    $('#set_values').show(750);
    $("#view_butt").hide(150); 
    $("#go_set").show(150); 
}

function go_set_form()
{    
    $("#view_butt").show(150); 
    $("#go_set").hide(150);
    $('#set_form').show(750);
    $('#set_values').hide(750);
}
 </script>




 </body>
 <!-- Mirrored from buckart.com/srsite/SoHoRepro-WebsitePages/store/store.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 21 Sep 2013 08:45:26 GMT -->
 </html>
