<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);
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
 <script type="text/javascript" src="js/jquery.timepicker.js"></script>
 <link rel="stylesheet" type="text/css" href="js/jquery.timepicker.css" media="screen" />
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
/*.progress { position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
.bar { background-color: #F99B3E; width:0%; height:20px; border-radius: 3px; }
.percent { position:absolute; display:inline-block; top:3px; left:48%; }
.upload_file_prog{
width: 30% !important;
padding: 1.5px;
-webkit-border-radius: 5px;
border: 1px solid #8f8f8f !important;
}*/
.arch_radio li{
list-style: none;
padding: 0px !important;
padding-left: 0px !important;
padding-bottom: 0px !important;
}


#dragandrophandler
{
border:2px dotted #FF7E00;
width: 93%;
color: #92AAB0;
text-align: center;
vertical-align: middle;
padding: 20px 10px;
margin-bottom: 10px;
font-size: 200%;
margin: 5px 2%;
height: 40px;
line-height: 40px;
}
.progressBar {
    width: 200px;
    height: 22px;
    border: 1px solid #ddd;
    border-radius: 5px; 
    overflow: hidden;
    display:inline-block;
    margin:0px 10px 5px 5px;
    vertical-align:top;
}
 
.progressBar div {
    height: 100%;
    color: #fff;
    text-align: right;
    line-height: 22px; /* same as #progressBar height if we want text middle aligned */
    width: 0;
    background-color: #0ba1b5; border-radius: 3px; 
}
.statusbar
{
  /* border-top: 1px solid #A9CCD1; */
  min-height: 25px;
  width: 95%;
  vertical-align: top;
  margin: 0px 2%;
  padding: 5px;
  float: left;
}

.statusbar.even {
  background: rgba(255, 126, 0, 0.1);
}

.statusbar:nth-child(odd){
    background:#EBEFF0;
}
.filename
{
display: inline-block;
vertical-align: top;
width: 250px;
color: #000;
font-size: 16px;
}
.filesize
{
display:inline-block;
vertical-align:top;
color:#30693D;
width:100px;
margin-left:10px;
margin-right:5px;
}
.abort{
    background-color:#A8352F;
    -moz-border-radius:4px;
    -webkit-border-radius:4px;
    border-radius:4px;display:inline-block;
    color:#fff;
    font-family:arial;font-size:13px;font-weight:normal;
    padding:4px 15px;
    cursor:pointer;
    vertical-align:top
    }

.done-progress{
    background-color:#1B71EF;
    -moz-border-radius:4px;
    -webkit-border-radius:4px;
    border-radius:4px;display:inline-block;
    color:#fff;
    font-family:arial;font-size:13px;font-weight:normal;
    padding:4px 15px;
    cursor:pointer;
    vertical-align:top;
    display: none;
    float: right;
    }
    

 .picker_icon{
    background : #FFFFFF url(images/datepicker-20.png) no-repeat 4px 4px;
    padding: 5px 5px 5px 25px;
    height:18px;
    cursor: pointer;
    }
.time_picker_icon {
    background: #FFFFFF url(images/clock.png) no-repeat 4px 4px;
    padding: 5px 5px 5px 30px;
    height: 18px;
    cursor: pointer;
    width: 50px;
}
#errmsg
{
color: red;
}
.spl_option > div
{
   float:left;
   padding:10px 20px;
   margin: 6px 5px 6px 0px;
   background: #EFEFEF;
   border-radius: 3px;
}
.spl_option > div input{
    float:left;
    margin:1px 5px 0px 0px !important;
    width:auto;   
}
.spl_option > div label{
    float:left;
    margin:0px 5px 0px 0px;
    
}
 </style>
 
<link rel="stylesheet" href="js/jquery-ui.css" />
<script src="js/jquery-ui_service.js"></script>

<script>
$(function() {
    var pri_inc_val     = $("#pri_inc_val").val();
    var all_exist_date       = $("#all_exist_date").val();
    var split_element        = all_exist_date.split(","); 
    var disabledSpecificDays = [split_element[0],split_element[1],split_element[2],split_element[3],split_element[4],split_element[5],split_element[6],split_element[7],split_element[8],split_element[8],split_element[9],split_element[10],split_element[11],split_element[12],split_element[13],split_element[14],split_element[15],split_element[16],split_element[17],split_element[18],split_element[19]];

    function disableSpecificDaysAndWeekends(date) {
    var m = date.getMonth();
    var d = date.getDate();
    var y = date.getFullYear();

    for (var i = 0; i < disabledSpecificDays.length; i++) {
    if ($.inArray((m + 1) + '-' + d + '-' + y, disabledSpecificDays) != -1 ) {
    return [false];
    }
    }

    var noWeekend = $.datepicker.noWeekends(date);
    return !noWeekend[0] ? noWeekend : [true];
    }
  $( "#date_for_alt_"+pri_inc_val).datepicker({minDate: 0,
            dateFormat: 'mm/dd/yy',
            inline: true,
            dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            beforeShowDay: disableSpecificDaysAndWeekends}); 
        
   $( ".date_for_alt").datepicker({minDate: 0,
            dateFormat: 'mm/dd/yy',
            inline: true,
            dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            beforeShowDay: disableSpecificDaysAndWeekends}); 
   
   
}); 






//function noSatSunday(date){ 
//          var day = date.getDay(); 
//                      return [(day > 1), '']; 
//      }; 

function date_picker_jas(ID)
{  
   $("#date_for_alt_"+ID).datepicker({minDate: 0,
            dateFormat: 'mm/dd/yy',
            inline: true,
            dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']});  
 
}

function show_date_picker(ID)
{  
   // alert('Jassim');
    $('#uploadedfile_'+ID).val('');
    $('#bar_'+ID).css('width','0%');
    $('#percent_'+ID).html('');
    $('#status_'+ID).html('');
    $("#up_form_"+ID).slideUp(1000);
    $("#date_for_alt_"+ID ).show();
    $("#date_for_alt_"+ID ).focus();
    $("#date_time_"+ID).slideDown(1000);
    $("#provide_link_"+ID).slideUp(1000);
    $("#drop_off_"+ID).slideUp(1000);
}
function drop_sohorepro(ID)
{   
    $('#uploadedfile_'+ID).val('');   
    $('#bar_'+ID).css('width','0%');
    $('#percent_'+ID).html('');
    $('#status_'+ID).html('');   
    $("#up_form_"+ID).slideUp(1000);
    $( "#date_time_"+ID ).slideUp(1000);
    $( "#date_for_alt_"+ID).hide();
    $("#provide_link_"+ID).slideUp(1000);
    $("#drop_off_"+ID).slideDown(1000);
}
function upload_soho(ID)
{
    var pri_inc_val     = $("#pri_inc_val").value;   
    $( "#date_for_alt_"+ID ).hide();
    $("#up_form_"+ID).slideDown(1000);
    $( "#date_time_"+ID ).slideUp(1000);
    $("#provide_link_"+ID).slideUp(1000);
    $("#drop_off_"+ID).slideUp(1000);
}

function provide_link(ID)
{   
    $("#date_for_alt_"+ID ).hide();
    $("#up_form_"+ID).slideUp(1000);
    $("#date_time_"+ID ).slideUp(1000);
    $("#provide_link_"+ID).slideDown(1000);
    $("#drop_off_"+ID).slideUp(1000);
}

$(function() {
    $('.time_picker_icon').timepicker({
        'minTime': '8:00am',
        'maxTime': '7:00pm',
        'showDuration': true
    });
});


</script>
<!--<script src="jquery.js"></script>-->
<script src="jquery.form.js"></script>
<script>
 function upload_file(ID)
{
    
    var upload_val = $('#uploadedfile_'+ID).val();
    if(upload_val != '') {
    var bar = $('#bar_'+ID);
    var percent = $('#percent_'+ID);
    var status = $('#status_'+ID);

    $('#upload_file_'+ID).ajaxForm({
        beforeSend: function() {
            status.empty();
            var percentVal = '0%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        complete: function(xhr) {
            bar.width("100%");
            percent.html("100%");
            status.html(xhr.responseText);
        }
    });
    }else{
        alert("please select the file.");
        return false;
    }
}

function custome_size(ID)
{
    var cus_size = $("#size_"+ID).val();
    if(cus_size == "Custom"){
        $("#size_custom_div_"+ID).slideDown(1000);
        $("#output_both_div_"+ID).slideUp(1000);
        $("#size_"+ID).focus;
    }else{
        $("#size_custom_div_"+ID).slideUp(1000);
    }
}

function custome_output(ID)
{
    var both_out = $("#output_"+ID).val();
    if(both_out == "Both"){        
        $("#output_both_div_"+ID).slideDown(1000);
        $("#size_custom_div_"+ID).slideUp(1000);
        $("#output_"+ID).focus;
    }else{
        $("#output_both_div_"+ID).slideUp(1000);
    }
}

</script>

<script>
function sendFileToServer(formData,status)
{
    var uploadURL ="upload.php"; //Upload URL
    var extraData ={}; //Extra Data.
    var jqXHR=$.ajax({
            xhr: function() {
            var xhrobj = $.ajaxSettings.xhr();
            if (xhrobj.upload) {
                    xhrobj.upload.addEventListener('progress', function(event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        //Set progress
                        status.setProgress(percent);
                    }, false);
                }
            return xhrobj;
        },
    url: uploadURL,
    type: "POST",
    contentType:false,
    processData: false,
        cache: false,
        data: formData,
        success: function(data){
            status.setProgress(100);
 
            //$("#status1").append("File upload Done<br>");         
        }
    }); 
 
    status.setAbort(jqXHR);
    status.setRemove(jqXHR);
}
 
var rowCount=0;
function createStatusbar(obj)
{
     rowCount++;
     var row="odd";
     if(rowCount %2 ==0) row ="even";
     this.statusbar = $("<div class='statusbar "+row+"'></div>");
     this.filename = $("<div class='filename'></div>").appendTo(this.statusbar);
     this.size = $("").appendTo(this.statusbar);
     this.progressBar = $("<div class='progressBar'><div></div></div>").appendTo(this.statusbar);
     this.abort = $("<div class='abort'>Abort</div>").appendTo(this.statusbar);
     this.done = $("<div class='done-progress'>Remove</div>").appendTo(this.statusbar);
     obj.after(this.statusbar);
 
    this.setFileNameSize = function(name,size)
    {
        var sizeStr="";
        var sizeKB = size/1024;
        if(parseInt(sizeKB) > 1024)
        {
            var sizeMB = sizeKB/1024;
            sizeStr = sizeMB.toFixed(2)+" MB";
        }
        else
        {
            sizeStr = sizeKB.toFixed(2)+" KB";
        }
 
        this.filename.html(name);
        this.size.html(sizeStr);
    }
    this.setProgress = function(progress)
    {       
        var progressBarWidth =progress*this.progressBar.width()/ 100;  
        this.progressBar.find('div').animate({ width: progressBarWidth }, 10).html(progress + "% ");
        if(parseInt(progress) >= 100)
        {
            this.abort.hide();
            this.done.show();
        }
    }
    this.setAbort = function(jqxhr)
    {
        var sb = this.statusbar;
        this.abort.click(function()
        {
            jqxhr.abort();
            sb.hide();
        });
    }
    
    this.setRemove = function(jqxhr)
    {
        var sb = this.statusbar;
        this.done.click(function()
        {
            jqxhr.done();
            sb.hide();
        });
    }
}
function handleFileUpload(files,obj)
{
   for (var i = 0; i < files.length; i++) 
   {
        var fd = new FormData();
        fd.append('file', files[i]);
 
        var status = new createStatusbar(obj); //Using this we can set progress.
        status.setFileNameSize(files[i].name,files[i].size);
        sendFileToServer(fd,status);
 
   }
}
$(document).ready(function()
{
var obj = $("#dragandrophandler");
obj.on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
    $(this).css('border', '2px solid #0B85A1');
});
obj.on('dragover', function (e) 
{
     e.stopPropagation();
     e.preventDefault();
});
obj.on('drop', function (e) 
{
 
     $(this).css('border', '2px dotted #0B85A1');
     e.preventDefault();
     var files = e.originalEvent.dataTransfer.files;
 
     //We need to send dropped files to Server
     handleFileUpload(files,obj);
});
$(document).on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
});
$(document).on('dragover', function (e) 
{
  e.stopPropagation();
  e.preventDefault();
  obj.css('border', '2px dotted #0B85A1');
});
$(document).on('drop', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
});
 
});


$(document).ready(function () {
    
  //called when key is pressed in textbox
  $(".order_0_set1_0_original").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
    
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
   
   $(".order_0_set1_0_printOfEach").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   }); 
   
   $('.order_0_set1_0_printOfEach').bind("cut copy paste",function(e) {
          e.preventDefault();
          $("#errmsg").html("Disable the cut,copy and paste fetures ").show().fadeOut(2000);
   });
   
   $('.order_0_set1_0_original').bind("cut copy paste",function(e) {
          e.preventDefault();
          $("#errmsg").html("Disable the cut,copy and paste fetures ").show().fadeOut(2000);
   });
   
});

</script>

 </head>
 <body>
     <div id="loading" class="none"  style="position: fixed;top: 35%;left: 48%;padding: 5px;z-index: 10;">
         <img src="admin/images/login_loader.gif" border="0" />
    </div>
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
	PLOTTING & ARCHITECTURAL COPIES 
  </h2>
  <div class="bkgd-stripes-orange">
    &nbsp;
  </div>
    <?php
    if ($result == "success_plotting") {
        ?>
        <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Set Added Successfully</div>
        <script>setTimeout("location.href=\'service_plotting.php\'", 1000);</script>
        <?php
    } elseif ($result == "failure_plotting") {
        ?>
        <div style="color:#F00; text-align:center; padding-bottom:10px;">Set Added Not Successfully</div>
        <script>setTimeout("location.href=\'service_plotting.php\'", 1000);</script>       
        <?php
    }  elseif($_GET['save_set'] == "1") { ?>
        <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Set Added Successfully</div>
        <script>setTimeout("location.href=\'service_plotting.php\'", 1000);</script>
    <?php
    }
    ?>
    <div id="succ_msg" style="color:#007F2A; text-align:center; padding-bottom:10px;display: none;">Set Added Successfully</div>
  <p style="margin-bottom:10px!important;">
	Our high speed electrostatic plotters can quickly process your CAD files. We are able to receive
      electronic AutoCad files from release 14 and up...(more)
      
  </p>

        <div id="go_set" style="width: 100%;float: left;display: none;">
            <span style="float: right;color: #ff7e00;cursor: pointer;text-decoration: none;" onclick="return go_set_form();">GO FORM</span>
        </div>
        <div id="set_form">
            <div id="plotting" action="" method="post" class="systemForm orderform">
                    <!--<form id="plotting" action="" method="post" class="systemForm orderform" >-->
                        
                  <input type="hidden" name="plotting_set" value="0" />
                  
                <ul>
                  <li class="clear">
                    <label style="font-weight: bold;" for="jobref" class="optional">
                      Job Reference Number
                    </label>
                      <?php
//                        echo '<pre>';
//                        print_r($_SESSION);
//                        echo '</pre>';
                      ?>
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
                    <div  id="set_1">
                        <input type="hidden" name="pri_inc_val" id="pri_inc_val" value="1" />
                  <li class="clear">
                      <?php
                      $user_id_add_set      = $_SESSION['sohorepro_userid'];
                      $company_id_view_plot = $_SESSION['sohorepro_companyid'];
                      $enteredPlot          = EnteredPlot($company_id_view_plot, $user_id_add_set);                      
//                      echo '<pre>';
//                      print_r($enteredPlot);
//                      echo '</pre>';
                      ?>
                      <!-- FOR EACH START -->     
                      <?php
                      $p = 1;
                      if(count($enteredPlot)> 0){
                      foreach ($enteredPlot as $entered){
                      ?>
                      <div class="serviceOrderSetHolder" style="border: 1px #F99B3E solid;margin-bottom: 5px;float: left;width: 100%;padding: 5px;">
                        <label style="font-weight: bold; margin-bottom: 0px; margin-top: 0px;" for="jo1" class="optional">
                        Job Options - <?php echo $p; ?>
                        <div style="float:right;font-weight: bold;">
                            <?php
                            $set_cont_serial    = mysql_query("SELECT set_serial FROM sohorepro_plotting_set ORDER BY set_serial DESC LIMIT 1");
                            $object_serial      = mysql_fetch_assoc($set_cont_serial);
                            $set_initial_serial = ($object_serial['set_serial'] == '0') ? '1' : $object_serial['set_serial']; 
                            ?>                            
                            <span style="cursor: pointer;font-weight: bold;" onclick="return delete_option('<?php echo $entered['id']; ?>');">Delete</span>
                            <input type="hidden" id="set_inc_1" name="set_inc" value="<?php echo $set_initial_serial; ?>" />
                        </div>
                        </label>  
                        <div style="background-color:#FFFFFF" class="" setindex="0">
                            <div class="serviceOrderSetWapperInternal">
                            <div class="serviceOrderSetDIV">
                            <div style="width: 100%;float: left;padding-top: 10px;">            
                                <div style="float:left;width:100%;">
                                    <ul class="arch_radio">
                                        <li><input type="radio" name="plotting_check_<?php echo $p; ?>" id="plotting_check_1_1" style="width:2% !important;" value="1" <?php if($entered['plot_arch'] == '1'){?> checked <?php } ?> /><span style="font-size: 13px;padding-left: 7px;font-weight: bold;">PLOTTING</span></li>
                                        <li><input type="radio" name="plotting_check_<?php echo $p; ?>" id="plotting_check_0_1" style="width:2% !important;" value="0" <?php if($entered['plot_arch'] == '0'){?> checked <?php } ?> /><span style="font-size: 13px;padding-left: 7px;font-weight: bold;">ARCHITECTURAL COPIES</span></li>
                                       
                                    </ul>                                    
                                </div>                                
                                <div>                                    
                                <label>                                    
                                  Originals
                                </label>
                                    <input class="order_0_set1_0_original k-input kdText " style="width:65px;" id="original_1" name="original" type="text" value="<?php echo $entered['origininals']; ?>" />
                              </div>
                              <div>
                                <label>
                                  Prints of Each<span style="color: red;">*</span>
<!--                                  <span style="font-weight:bold;color:#cc0000">
                                    *
                                  </span>-->
                                </label>
                                <input class="ymlrequired order_0_set1_0_printOfEach k-input kdText " style="width:68px;" id="print_ea_1" name="print_ea" type="text" value="<?php echo $entered['print_ea']; ?>" />
                              </div>
                              <div>
                                <label>
                                  Size<span style="color: red;">*</span>
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                      <select class="order_0_set1_0_size kdSelect " style="width: 90px;" id="size_1" name="size" onchange="return custome_size();">                            
                                          <option value="FULL" <?php if($entered['print_ea'] == 'FULL'){?> selected="selected" <?php } ?>>FULL</option>
                                      <option value="HALF" <?php if($entered['print_ea'] == 'HALF'){?> selected="selected" <?php } ?>>HALF</option>
                                      <option value="Reduce to 11 X 17" <?php if($entered['print_ea'] == 'Reduce to 11 X 17'){?> selected="selected" <?php } ?>>Reduce to 11 X 17</option>
                                      <option value="Custom" <?php if($entered['print_ea'] == 'Custom'){?> selected="selected" <?php } ?>>Custom</option>                          
                                    </select>
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>
                              <div>
                                <label>
                                  Output<span style="color: red;">*</span>
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_output kdSelect " style="width: 90px;" id="output_1" name="output" onchange="return custome_output();">
                                      <option value="B/W" <?php if($entered['output'] == 'B/W'){?> selected="selected" <?php } ?>>B/W</option>
                                      <option value="Color" <?php if($entered['output'] == 'Color'){?> selected="selected" <?php } ?>>Color</option>
                                      <option value="Both" <?php if($entered['output'] == 'Both'){?> selected="selected" <?php } ?>>Both</option>
                                    </select>
                                      
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>
                              <div>
                                <label>
                                  Media<span style="color: red;">*</span>
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_media kdSelect " style="width: 100px;" id="media_1" name="media">
                                      <option value="Bond" <?php if($entered['media'] == 'Bond'){?> selected="selected" <?php } ?>>Bond</option>
                                      <option value="Vellum" <?php if($entered['media'] == 'Vellum'){?> selected="selected" <?php } ?>>Vellum</option>
                                      <option value="Mylar" <?php if($entered['media'] == 'Mylar'){?> selected="selected" <?php } ?>>Mylar</option>                          
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
                                    <select class="order_0_set1_0_binding kdSelect " style="width: 80px;" id="binding_1" name="binding">
                                      <option value="none" <?php if($entered['binding'] == 'none'){?> selected="selected" <?php } ?>>None</option>
                                      <option value="Screw Post" <?php if($entered['binding'] == 'Screw Post'){?> selected="selected" <?php } ?>>Screw Post</option>
                                      <option value="Binding Strip" <?php if($entered['binding'] == 'Binding Strip'){?> selected="selected" <?php } ?>>Binding Strip</option>                          
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
                                    <select class="order_0_set1_0_folding kdSelect " style="width: 100px;" id="folding_1" name="folding">
                                      <option value="none" <?php if($entered['folding'] == 'none'){?> selected="selected" <?php } ?>>None</option>
                                      <option value="Yes" <?php if($entered['folding'] == 'Yes'){?> selected="selected" <?php } ?>>Yes</option>                          
                                    </select>
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>                              
                        
              </div>
                                <div id="size_custom_div" style="border: 1px #FF7E00 solid;width: 100%;float:left;padding: 5px;display: none;">
                                    <label>Please Specify Custom Details : </label><textarea name="size_custom_<?php echo $entered['id']; ?>" id="size_custom_<?php echo $entered['id']; ?>" rows="3" cols="18" style="width: 201px;" placeholder="Custom Size"></textarea>
                                </div>
                                <div id="output_both_div" style="border: 1px #FF7E00 solid;width: 100%;float:left;padding: 5px;display: none;">
                                    <label>Enter page numbers that are in COLOR (separated by a comma) :</label>
                                    <input type="text" name="output_both" id="output_both" style="width: 200px;" />
                                </div>
                <div>
                <label style="font-weight: bold;height:28px">
                  Alternative File Options<span style="color: red;">*</span>
                </label>
                    <input type="checkbox"  style="display: none;width: 2%;" name="use_same_check" id="use_same_check_box_1" value="1"  onclick="return use_same_set('1');" />
                <div class="spl_option">
                    
                <div>
                     <input class="filetrigger" name="alt_file_option" value="dropOff" id="drop"  type="radio" onclick="return upload_soho(<?php echo '1'; ?>);" />
                   <label for="drop">
                     Upload File
                   </label>                    
                 </div>
                    
                <div>
                    <input class="filetrigger" name="alt_file_option" value="dropOff" id="drop"  type="radio" onclick="return provide_link(<?php echo '1'; ?>);" />
                  <label for="drop">
                    Provide Link to File
                  </label>                    
                </div>
                    
                  <div>
                      <input class="filetrigger picker_icon" name="alt_file_option" value="pickUp" id="pick_1"  type="radio" onclick="return show_date_picker(<?php echo '1'; ?>);" />
                    <label for="pick">
                      Schedule a pick up
                    </label></br>
                    <?php 
                    $all_days_off = AllDayOff();                                                        
                    foreach ($all_days_off as $days_off_split){
                        $all_days_in[]  = $days_off_split['date'];
                    }                                                        
                    $all_date  = implode(",", $all_days_in);                                                        
                    $all_date_exist = str_replace("/", "-", $all_date);
                    ?>
                    
                  </div>
                    
                  <div style="width:175px;float:left;">
                      <input class="filetrigger" name="alt_file_option" value="dropOff" id="drop"  type="radio" onclick="return drop_sohorepro(<?php echo '1'; ?>);" />
                    <label for="drop">
                      Drop off at Soho Repro
                    </label>                    
                  </div>
                    
                    
                    
                    
                </div>
                  <br>
                      <div id="date_time_1" style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;float: left;width: 35%;padding-bottom: 10px;display:none;">
                        <input type="hidden" name="all_exist_date" id="all_exist_date" value="<?php echo $all_date_exist; ?>" />
                        <input type="text" name="dahe_for_alt" id="date_for_alt_1" style="width: 50%;" class="date_for_alt picker_icon" onclick="return date_picker_plot(1);" />                        
                        <select class="" id="time_for_alt_1" name="time_gap" id="time_gap" style="width: 35% !important;">
                                <option value="08:00AM">08:00AM</option>
                                <option value="09:00AM">09:00AM</option>
                                <option value="10:00AM">10:00AM</option>
                                <option value="11:00AM">11:00AM</option>
                                <option value="12:00PM">12:00PM</option>
                                <option value="01:00PM">01:00PM</option>
                                <option value="02:00PM">02:00PM</option>
                                <option value="03:00PM">03:00PM</option>
                                <option value="04:00PM">04:00PM</option>
                                <option value="05:00PM">05:00PM</option>
                                <option value="06:00PM">06:00PM</option>
                                <option value="07:00PM">07:00PM</option>
                            </select>
                        <div style="border: 1px #CCC solid;width: 95%;margin-left: 5px;margin-bottom: 10px;"></div>
                        <div style="width: 100%;">
                        <input style="margin-left: 75px;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="button" name="ready_now" value="READY NOW" id="ready_now" onclick="return ready_now();" />
                        </div>
                    </div>                      
                      <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="up_form_1">
                        <div style="margin: auto;width: 50%;">                            
                        <form action="add_set_upload_form.php" method="post" enctype="multipart/form-data" id="upload_file_1">
                                <input type="file" name="uploadedfile" id="uploadedfile_1"><br>
                                <input type="submit" value="Upload File" class="upload_file_prog"  onclick="return upload_file(<?php echo '1'; ?>)" />
                        </form>
                            <div class="progress" id="progress_1">
                        <div class="bar" id="bar_1"></div >
                        <div class="percent" id="percent_1">0%</div >
                        </div>
                            <div id="status_1"></div>
                         </div>   
                      </div>
                      <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="provide_link_1">
                        <div style="margin: auto;width: 60%;">
                            <div style="margin: auto;width: 60%;float:right;">
                            <!--<textarea name="provide_link" id="provide_link_text_1" rows="3" cols="18" style="width: 201px;"></textarea>-->
                            <input type="text" name="ftp_link" id="provide_link_text_1" placeholder="FTP Link" />
                            <input type="text" name="user_name" id="user_name" placeholder="User Name" />
                            <input type="text" name="password" id="password" placeholder="Password" />                            
                            </div>
                            <div style="margin: auto;width: 60%;float:right;padding-top: 5px;">
                            <span>If providing an FTP link, please include username and password.</span>
                            </div>
                        </div>   
                      </div>
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
                    <div style="float: left;width: 100%;">
                <div id="sp_inst" style="margin-top:10px;">
                  <label style="font-weight: bold;margin-bottom: -4px; margin-top: -10px;">
                    Special Instructions
                  </label>
                  <br>
                  <textarea name="spl_ins" class="splins" id="splins_1" rows="4" cols="60" style="margin-top:-5px;margin-bottom:10px;"><?php echo $entered['spl_instruction']; ?></textarea>
                </div>
                </div>
              </div>
              </div>
                            
              </div>              
                            
              
                            
              <div style="clear:both;">
              </div>
              </div>
              </div>
            <?php
                $p++;
                } 
                }else{
                    
                $set_cont_serial    = mysql_query("SELECT set_serial FROM sohorepro_plotting_set ORDER BY set_serial DESC LIMIT 1");
                $object_serial      = mysql_fetch_assoc($set_cont_serial);
                $set_initial_serial = ($object_serial['set_serial'] == '0') ? '1' : $object_serial['set_serial']+1; 
                ?>
                <div  id="set_2">               
                <div class="serviceOrderSetHolder">
                        <label style="font-weight: bold; margin-bottom: 0px; margin-top: 0px;" for="jo1" class="optional">
                        Job Options 
                        <div style="float:right;font-weight: bold;">
                            Option <?php echo $p; ?>
                            <input type="hidden" id="set_inc_1" name="set_inc" value="<?php echo $set_initial_serial; ?>" />
                        </div>
                        </label>  
                        <div style="background-color:#FFFFFF" class="serviceOrderSetWapper" setindex="0">
                            <div class="serviceOrderSetWapperInternal">
                            <div class="serviceOrderSetDIV">
                            <div style="width: 100%;float: left;padding-top: 10px;">            
                                <div style="float:left;width:100%;">
                                    <ul class="arch_radio">
                                        <li><input type="radio" name="plotting_check" id="plotting_check_1_1" style="width:2% !important;" value="1" <?php if($entered['plot_arch'] == '1'){?> checked <?php } ?> /><span style="font-size: 13px;padding-left: 7px;font-weight: bold;">PLOTTING</span></li>
                                        <li><input type="radio" name="plotting_check" id="plotting_check_0_1" style="width:2% !important;" value="0" <?php if($entered['plot_arch'] == '0'){?> checked <?php } ?> /><span style="font-size: 13px;padding-left: 7px;font-weight: bold;">ARCHITECTURAL COPIES</span></li>
                                    </ul>
                                    <span id="errmsg"></span>
                                </div>                                 
                                <div>
                                <label>
                                  Originals
                                </label>
                                    <input class="order_0_set1_0_original k-input kdText " style="width:65px;" id="original_1" name="original" type="text" value="<?php echo $entered['origininals']; ?>" />
                              </div>
                              <div>
                                <label>
                                  Prints of Each<span style="color: red;">*</span>
<!--                                  <span style="font-weight:bold;color:#cc0000">
                                    *
                                  </span>-->
                                </label>
                                <input class="ymlrequired order_0_set1_0_printOfEach k-input kdText " style="width:68px;" id="print_ea_1" name="print_ea" type="text" value="<?php echo $entered['print_ea']; ?>" />
                              </div>
                              <div>
                                <label>
                                  Size<span style="color: red;">*</span>
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                      <select class="order_0_set1_0_size kdSelect " style="width: 135px;" id="size_1" name="size" onchange="return custome_size(1);">                            
                                          <option value="FULL" <?php if($entered['print_ea'] == 'FULL'){?> selected="selected" <?php } ?>>FULL</option>
                                      <option value="HALF" <?php if($entered['print_ea'] == 'HALF'){?> selected="selected" <?php } ?>>HALF</option>
                                      <option value="Reduce to 11 X 17" <?php if($entered['print_ea'] == 'Reduce to 11 X 17'){?> selected="selected" <?php } ?>>Reduce to 11 X 17</option>
                                      <option value="Custom" <?php if($entered['print_ea'] == 'Custom'){?> selected="selected" <?php } ?>>Custom</option>                          
                                    </select>
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>
                              <div>
                                <label>
                                  Output<span style="color: red;">*</span>
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_output kdSelect " style="width: 90px;" id="output_1" name="output" onchange="return custome_output(1);">
                                      <option value="B/W" <?php if($entered['output'] == 'B/W'){?> selected="selected" <?php } ?>>B/W</option>
                                      <option value="Color" <?php if($entered['output'] == 'Color'){?> selected="selected" <?php } ?>>Color</option>
                                      <option value="Both" <?php if($entered['output'] == 'Both'){?> selected="selected" <?php } ?>>Both</option>
                                    </select>
                                      
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>
                              <div>
                                <label>
                                  Media<span style="color: red;">*</span>
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_media kdSelect " style="width: 100px;" id="media_1" name="media">
                                      <option value="Bond" <?php if($entered['media'] == 'Bond'){?> selected="selected" <?php } ?>>Bond</option>
                                      <option value="Vellum" <?php if($entered['media'] == 'Vellum'){?> selected="selected" <?php } ?>>Vellum</option>
                                      <option value="Mylar" <?php if($entered['media'] == 'Mylar'){?> selected="selected" <?php } ?>>Mylar</option>                          
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
                                    <select class="order_0_set1_0_binding kdSelect " style="width: 80px;" id="binding_1" name="binding">
                                      <option value="none" <?php if($entered['binding'] == 'none'){?> selected="selected" <?php } ?>>None</option>                                      
                                      <option value="Binding Strip" <?php if($entered['binding'] == 'Binding Strip'){?> selected="selected" <?php } ?>>Binding Strip</option>                          
                                      <option value="Screw Post" <?php if($entered['binding'] == 'Screw Post'){?> selected="selected" <?php } ?>>Screw Post</option>
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
                                    <select class="order_0_set1_0_folding kdSelect " style="width: 100px;" id="folding_1" name="folding">
                                      <option value="none" <?php if($entered['folding'] == 'none'){?> selected="selected" <?php } ?>>None</option>
                                      <option value="Yes" <?php if($entered['folding'] == 'Yes'){?> selected="selected" <?php } ?>>Yes</option>                          
                                    </select>
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div> 
                            </div>
                                <div id="size_custom_div_1" style="border: 1px #FF7E00 solid;width: 30%;padding: 5px;margin: auto;margin-left: 145px;display: none;">
                                    <label>Please Specify Custom Details : </label><textarea name="size_custom" id="size_custom_1" rows="3" cols="18" style="width: 201px;" placeholder="Custom Size"></textarea>
                                </div>
                                <div id="output_both_div_1" style="border: 1px #FF7E00 solid;width: 55%;padding: 5px;margin-left: 247px;display: none;">
                                    <label>Enter page numbers that are in COLOR (separated by a comma) :</label>
                                    <input type="text" name="output_both" id="output_both" style="width: 200px;" />
                                </div>
                <div style="width:730px;border-bottom: 1px solid #CCCCCC;float: left;">
                <label style="font-weight: bold;height:28px">
                  Alternative File Options<span style="color: red;">*</span>
                </label>
                    <input type="checkbox"  style="display: none;width: 2%;" name="use_same_check" id="use_same_check_box_1" value="1"  onclick="return use_same_set('1');" />
                <div class="check" style="width:730px;border-top: 1px solid #FF7E00;margin-top:-13px;">
                    <div class="spl_option" style="float: 100%;">
                         <div>
                                  <input class="filetrigger" name="alt_file_option" value="dropOff" id="drop"  type="radio" onclick="return upload_soho(<?php echo '1'; ?>);" />
                                <label for="drop" >
                                  Upload File
                                </label>                    
                              </div>

                            <div>
                                  <input class="filetrigger" name="alt_file_option" value="dropOff" id="drop"  type="radio" onclick="return provide_link(<?php echo '1'; ?>);" />
                                <label for="drop" >
                                  Provide Link to File
                                </label>                    
                            </div>   
                        
                        <div>
                                  <input class="filetrigger" name="alt_file_option" value="pickUp" id="pick_1"  type="radio" onclick="return show_date_picker(<?php echo '1'; ?>);" />
                                <label for="pick" >
                                  Schedule a pick up
                                </label></br>
                                <?php 
                                $all_days_off = AllDayOff();                                                        
                                foreach ($all_days_off as $days_off_split){
                                    $all_days_in[]  = $days_off_split['date'];
                                }                                                        
                                $all_date  = implode(",", $all_days_in);                                                        
                                $all_date_exist = str_replace("/", "-", $all_date);
                                ?>

                              </div>
                    
                              <div>
                                  <input class="filetrigger" name="alt_file_option" value="dropOff" id="drop"  type="radio" onclick="return drop_sohorepro(<?php echo '1'; ?>);" />
                                <label for="drop" >
                                  Drop off at Soho Repro
                                </label>                    
                              </div>

                               
                    </div>
                  <br>
                      
                      <div id="date_time_1" style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;float: left;width: 30%;padding-bottom: 10px;display:none;">
                        
                        <div style="width: 100%;">
                        <input style="margin-left: 75px;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="button" name="ready_now" value="READY NOW" id="ready_now" onclick="return ready_now();" />
                        </div>                        
                        
                        <div style="border: 1px #CCC solid;width: 95%;margin-left: 5px;margin-bottom: 10px;"></div>
                         
                        <div style="padding: 5px;">
                        <input type="hidden" name="all_exist_date" id="all_exist_date" value="<?php echo $all_date_exist; ?>" />
                        <input type="text" name="dahe_for_alt" id="date_for_alt_1" style="width: 30%;margin-left: 5px;" class="date_for_alt picker_icon" />                        
                        
                        <input id="time_for_alt_1" type="text" style="width: 30%;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" />
                        </div>
                        
                    </div>
                      
                      <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="up_form_1">
                        <input type="hidden" name="uploadedfile" id="uploadedfile_1" value="1" /> 
                        <div id="dragandrophandler">Drag & Drop Files Here</div>
                        <br><br>
                        <div id="status1"></div> 
                      </div>
                      
                      <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="provide_link_1">
                        <div style="margin: auto;width: 60%;">
                            <div style="margin: auto;width: 60%;float:right;">
                            <!--<textarea name="provide_link" id="provide_link_text_1" rows="3" cols="18" style="width: 201px;"></textarea>-->
                            <input type="text" name="ftp_link" id="provide_link_text_1" placeholder="FTP Link" />
                            <input type="text" name="user_name" id="user_name" placeholder="User Name" />
                            <input type="text" name="password" id="password" placeholder="Password" />
                            </div>
                            <div style="margin: auto;width: 60%;float:right;padding-top: 5px;">
                            <span>If providing an FTP link, please include username and password.</span>
                            </div>
                        </div>   
                      </div>
                      
                      <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="drop_off_1">
                        <div style="margin: auto;width: 60%;">
                            <div style="margin: auto;width: 60%;float:right;">
                                <select>
                                    <option value="381 Broom" selected="selected">381 Broome St</option>
                                    <option value="307 7th Ave, 5th Floor" >307 7th Ave, 5th Floor</option>
                                </select>                                
                            </div>                            
                        </div>   
                      </div>
                      
                  

                  
                </div>
                <br>

                <br>
                    <div style="float: left;width: 100%;">
                <div id="sp_inst" style="margin-top:10px;">
                  <label style="font-weight: bold;margin-bottom: -4px; margin-top: -10px;">
                    Special Instructions
                  </label>
                  <br>
                  <textarea name="spl_ins" class="splins" id="splins_1" rows="4" cols="60" style="margin-top:-5px;margin-bottom:10px;"><?php echo $entered['spl_instruction']; ?></textarea>
                </div>
                </div>
              </div>
              </div>
                            
              </div>              
                            
              
                            
              <div style="clear:both;">
              </div>
              </div>
              </div>
            </div>    
                <?php } ?>
               <!-- FOR EACH END -->     
                  
             
                    
              <div style="float:left;width:100%;text-align:right;">
                  <input class="addNewOrderSet" value="Add Set" style="float:right;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="button" onclick="return validate_plotting();" />
                  <input class="addproductActionLink" value="Save and Continue" style="cursor: pointer; float: right; font-size: 12px; padding: 1.5px; width: 135px; margin-right: 14px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;margin-top: -0px !important;" type="button" onclick="return validate_plotting_cont();" />
              </div> 
              </span>
              </li>
              <li class="clear">
                <span>
                  <div style="height:29px;">
                    &nbsp;
                  </div>
                    
                  <div style="clear:both">
                  </div>
                </span>
              </li>
              </ul>
              
                </div>
            </div>
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
    var pri_inc_val     = document.getElementById("pri_inc_val").value;     
    var jobreference    = document.getElementById("jobref").value;
    var original        = document.getElementById("original_"+pri_inc_val).value;
    var print_ea        = document.getElementById("print_ea_"+pri_inc_val).value;
    var size            = document.getElementById("size_"+pri_inc_val).value;
    var output          = document.getElementById("output_"+pri_inc_val).value;
    var media           = document.getElementById("media_"+pri_inc_val).value;
    var binding         = document.getElementById("binding_"+pri_inc_val).value;
    var folding         = document.getElementById("folding_"+pri_inc_val).value;
    var pick            = document.getElementById("pick_"+pri_inc_val).value;
    var date_for_alt    = document.getElementById("date_for_alt_"+pri_inc_val).value;
    var uploadedfile    = document.getElementById("uploadedfile_"+pri_inc_val).value;
    var splins          = document.getElementById("splins_"+pri_inc_val).value;
    var jobref_id       = document.getElementById("jobref").value;
    var company_id      = document.getElementById("user_session_comp").value;
    var set_inc         = document.getElementById("set_inc_"+pri_inc_val).value;
    
    var check_val_1     = document.getElementById("plotting_check_1_"+pri_inc_val).checked;
    var check_val_0     = document.getElementById("plotting_check_0_"+pri_inc_val).checked;
    var use_same        = document.getElementById("use_same_check_box_"+pri_inc_val).checked;
    var size_custom     = document.getElementById("size_custom_"+pri_inc_val).value;
    var plotting_check  = (check_val_1 == true) ? '1' : '0';
    
    var time_for_alt    = document.getElementById("time_for_alt_"+pri_inc_val).value;
    var provide_link_pre = document.getElementById("provide_link_text_"+pri_inc_val).value;
    var provide_link    = (provide_link_pre == '') ? 'NIL' : provide_link_pre;
    
    if(jobreference == ''){
        alert('Please enter the Job Reference');
        document.getElementById("jobref").focus();
        return false;
    }
    if(print_ea == ''){
        alert('Please enter the Print');
        document.getElementById("print_ea_"+pri_inc_val).focus();
        return false;
    }  
    if(output == 'Both'){
        if(splins == ''){
        alert('Please enter the special instructions');
        document.getElementById("splins_"+pri_inc_val).focus();
        return false;  
        }      
    }
    if(size == 'Custom'){
       if(size_custom == ''){
        alert('Please enter the custom size');
        document.getElementById("size_custom_"+pri_inc_val).focus();
        return false;  
        }      
    }
    if (jobreference != '')
    {
        $.ajax
                ({
                    type: "POST",
                    url: "add_set_save.php",
                    data: "jobreference_add_set=" + jobreference+"&original_add_set="+encodeURIComponent(original)+"&print_ea_add_set="
                           +encodeURIComponent(print_ea)+"&size_add_set="+encodeURIComponent(size)+"&output_add_set="+encodeURIComponent(output)+"&media_add_set="+encodeURIComponent(media)+"&binding_add_set="+encodeURIComponent(binding)+"&folding_add_set="+encodeURIComponent(folding)+
                           "&pick_add_set="+encodeURIComponent(pick)+"&date_for_alt_add_set="+encodeURIComponent(date_for_alt)+"&uploadedfile_add_set="+encodeURIComponent(uploadedfile)+"&jobref_id="+jobref_id+"&splins_add_set="+splins+"&company_id_add_set="+company_id+"&set_inc="+
                           set_inc+"&plotting_check="+encodeURIComponent(plotting_check)+"&time_for_alt="+encodeURIComponent(time_for_alt)+"&provide_link="+provide_link,
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {   
                        var result = option.split("~");
                        //window.location = "service_plotting.php?save_set=1";
                        $("#succ_msg").show();
                        //$("#succ_msg").hide(1000);
                        $("#set_2").html(result[1]).fadeIn('slow');
                        $("#print_ea_"+result[0]).focus();
                        $("#pri_inc_val").val(result[0]);
                    }
                });
    }
    
  }   

function validate_plotting_cont()
{
    var pri_inc_val     = document.getElementById("pri_inc_val").value;    
    var jobreference    = document.getElementById("jobref").value;
    var original        = document.getElementById("original_"+pri_inc_val).value;
    var print_ea        = document.getElementById("print_ea_"+pri_inc_val).value;
    var size            = document.getElementById("size_"+pri_inc_val).value;
    var output          = document.getElementById("output_"+pri_inc_val).value;
    var media           = document.getElementById("media_"+pri_inc_val).value;
    var binding         = document.getElementById("binding_"+pri_inc_val).value;
    var folding         = document.getElementById("folding_"+pri_inc_val).value;
    var pick            = document.getElementById("pick_"+pri_inc_val).value;
    var date_for_alt    = document.getElementById("date_for_alt_"+pri_inc_val).value;
    var uploadedfile    = document.getElementById("uploadedfile_"+pri_inc_val).value;
    var splins          = document.getElementById("splins_"+pri_inc_val).value;
    var jobref_id       = document.getElementById("jobref").value;
    var company_id      = document.getElementById("user_session_comp").value;
    var set_inc         = document.getElementById("set_inc_"+pri_inc_val).value;
    
    var check_val_1     = document.getElementById("plotting_check_1_"+pri_inc_val).checked;
    var check_val_0     = document.getElementById("plotting_check_0_"+pri_inc_val).checked;
    var use_same        = document.getElementById("use_same_check_box_"+pri_inc_val).checked;
    //var size_custom     = document.getElementById("size_custom_"+pri_inc_val).value;
    var plotting_check  = (check_val_1 == true) ? '1' : '0';
    
    var time_for_alt    = document.getElementById("time_for_alt_"+pri_inc_val).value;
    var provide_link_pre = document.getElementById("provide_link_text_"+pri_inc_val).value;
    var provide_link    = (provide_link_pre == '') ? 'NIL' : provide_link_pre;
    
    if(jobreference == ''){
        alert('Please enter the Job Reference');
        document.getElementById("jobref").focus();
        return false;
    }
    if(original == ''){
        alert('Please enter the originals');
        document.getElementById("original_"+pri_inc_val).focus();
        return false;
    }
    if(print_ea == ''){
        alert('Please enter the Print');
        document.getElementById("print_ea_"+pri_inc_val).focus();
        return false;
    }    
    if(output == 'Both'){
        if(splins == ''){
        alert('Please enter the special instructions');
        document.getElementById("splins_"+pri_inc_val).focus();
        return false;  
        }      
    }
    if(size == 'Custom'){
       if(size_custom == ''){
        alert('Please enter the custom size');
        document.getElementById("size_custom_"+pri_inc_val).focus();
        return false;  
        }      
    }
    if (jobreference != '')
    {
        $.ajax
                ({
                    type: "POST",
                    url: "add_set_save.php",
                    data: "jobreference_add_set=" + jobreference+"&original_add_set="+encodeURIComponent(original)+"&print_ea_add_set="
                           +encodeURIComponent(print_ea)+"&size_add_set="+encodeURIComponent(size)+"&output_add_set="+encodeURIComponent(output)+"&media_add_set="+encodeURIComponent(media)+"&binding_add_set="+encodeURIComponent(binding)+"&folding_add_set="+encodeURIComponent(folding)+
                           "&pick_add_set="+encodeURIComponent(pick)+"&date_for_alt_add_set="+encodeURIComponent(date_for_alt)+"&uploadedfile_add_set="+encodeURIComponent(uploadedfile)+"&jobref_id="+jobref_id+"&splins_add_set="+splins+"&company_id_add_set="+company_id+"&set_inc="+
                           set_inc+"&plotting_check="+encodeURIComponent(plotting_check)+"&time_for_alt="+encodeURIComponent(time_for_alt)+"&provide_link="+provide_link,
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {                            
                        window.location = "add_recipients.php";

                    }
                });
    }
}


function loadStart() {
$('#loading').show();
}

function loadStop() {
$('#loading').hide();
}

function use_same_set()
{
    $("#use_same").slideDown(1000);
}

function ready_now(){
    alert("All orders placed online are assumed to be for today and available for collection immediately.  If you wish to       place an order for another date and time, or for today but       at a later time, please check the box at the left and then enter below a date and time for collection.");
}
    
function delete_option(ID)
{
    var ok_to_proceed = confirm('Are you sure?');
    
    if(ok_to_proceed == true){        
    $.ajax
                ({
                    type: "POST",
                    url: "get_recipients.php",
                    data: "recipients=delete_set&delete_set_id=" + ID,
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {                            
                        window.location = "service_plotting.php";

                    }
                });
            }else{
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
