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
.plot_wrap ul > li{
    width:94%;
    float:left;
    line-height: 20px;
    padding:2px 3%; 
}
.plot_wrap ul li label{
    float:left;
    width: 20%;
}
.plot_wrap ul li p{
    float:left;
    text-transform: uppercase;
}

.modal-overlay {
  opacity: 0.7;
  filter: alpha(opacity=0);
  position: fixed;
  top: 0;
  left: 0;
  z-index: 900;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.3) !important;
}
.ref_div_star{
    color:red; margin-top: -5px;font-size: 16px;font-weight: bold;
    }
 </style>
 
<link rel="stylesheet" href="js/jquery-ui.css" />
<script src="js/jquery-ui_service.js"></script>

<script>
$(function() {
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
  $( "#date_for_alt").datepicker({minDate: 0,
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

function date_revele()
{
    $("#date_for_alt").focus();
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
    
   $( "#date_for_alt").datepicker({minDate: 0,
            dateFormat: 'mm/dd/yy',
            inline: true,
            dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            beforeShowDay: disableSpecificDaysAndWeekends}); 
}

function date_picker_jas(ID)
{  
   $("#date_for_alt_"+ID).datepicker({minDate: 0,
            dateFormat: 'mm/dd/yy',
            inline: true,
            dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']});  
 
}

function show_date_picker(ID)
{  
    $('#bar').css('width','0%');
    $('#percent').html('');
    $('#status').html('');
    $("#up_form").slideUp(1000);
    $("#date_for_alt").show();
    $("#date_for_alt").focus();
    $("#date_time").slideDown(1000);
    $("#provide_link").slideUp(1000);
    $("#drop_off").slideUp(1000);
    $("#drop_off_select_val").val('0');
}

function show_date_picker_arch()
{    
    $("#date_time_arch").slideDown(1000);    
    $("#drop_off_arch").slideUp(1000);
}


function drop_sohorepro()
{   
    $('#uploadedfile').val('');   
    //$('#bar_'+ID).css('width','0%');
    $('#percent').html('');
    $('#status').html('');   
    $("#up_form").slideUp(1000);
    $("#date_time").slideUp(1000);
    $("#date_for_alt").hide();
    $("#provide_link").slideUp(1000);
    $("#drop_off").slideDown(1000);
    document.getElementById("drop_val").checked = true;
    $("#drop_off_select_val").val('1');
}


function drop_sohorepro_arch()
{      
    $( "#date_time_arch").slideUp(1000);
    $("#drop_off_arch").slideDown(1000);
    document.getElementById("drop_val_arc").checked = true;
    $("#drop_off_select_val").val('1');    
}


function upload_soho()
{     
    $( "#date_for_alt").hide();
    $("#up_form").slideDown(1000);
    $( "#date_time").slideUp(1000);
    $("#provide_link").slideUp(1000);
    $("#drop_off").slideUp(1000);
    $("#drop_off_select_val").val('0');
}

function provide_link()
{   
    $("#date_for_alt").hide();
    $("#up_form").slideUp(1000);
    $("#date_time").slideUp(1000);
    $("#provide_link").slideDown(1000);
    $("#drop_off").slideUp(1000);
    $("#drop_off_select_val").val('0');
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

function custome_size()
{
    var cus_size = $("#size").val();
    if(cus_size == "Custom"){
        $("#size_custom_div").slideDown(1000);
        //$("#output_both_div").slideUp(1000);
        $("#size").focus;
    }else{
        $("#size_custom_div").slideUp(1000);
    }
}

function custome_output()
{
    var both_out = $("#output").val();
    if(both_out == "Both"){        
        $("#output_both_div").slideDown(1000);
        //$("#size_custom_div").slideUp(1000);
        $("#output").focus;
    }else{
        $("#output_both_div").slideUp(1000);
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
            //alert(data);
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
    <div id="asap_popup" style="display: none;font-size: 15px;position: fixed;top: 35%;left: 35%;padding: 5px;z-index: 10;position: absolute;z-index: 1000;width: 45%;background: white;border-bottom: 1px solid #aaa;border-radius: 4px;box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);border: 1px solid rgba(0, 0, 0, 0.1);background-clip: padding-box;">
        <div style="width: 96%;padding: 2%;float: left;font-size: 14px;line-height: 18px;text-align: justify;">
            All orders placed online are assumed to be for today and available for collection immediately.
        If you wish to place an order for another date and time, or for today but at a later time, 
        please check the box at the left and then enter below a date and time for collection.
        </div>
        <div style="float: right;width: 98%;background-color: #EEE;padding: 1%;">
            <span style="float: left;color: #000;font-weight: bold;margin-top: 5px;margin-left: 15px;">Note: All orders placed after hours will be picked up on the next business day.</span>
            <span style="float: right;border: 1px solid #BBB;padding: 3px 10px;border-radius: 3px;cursor: pointer;" onclick="return close_asap();">Close</span>
        </div>
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

  <h2 class="headline-interior orange" style="text-transform: uppercase;">
	PLOTTING & ARCHITECTURAL COPIES 
        
        
  </h2>
  <div class="bkgd-stripes-orange">
    &nbsp;
  </div>   
    <div id="succ_msg" style="color:#007F2A; text-align:center; padding-bottom:10px;display: none;">Set Added Successfully</div>
  
        <div id="go_set" style="width: 100%;float: left;display: none;">
            <span style="float: right;color: #ff7e00;cursor: pointer;text-decoration: none;" onclick="return go_set_form();">GO FORM</span>
        </div>
        <div id="set_form">
            <div id="plotting" action="" method="post" class="systemForm orderform">
                  <input type="hidden" name="plotting_set" value="0" />
                <ul>
                  <li class="clear">
                    <label style="font-weight: bold;" for="jobref" class="optional">
                      Job Reference<span class="ref_div_star">*</span>
                    </label>
                    <span style="position: relative;">                        
                        <input aria-haspopup="true" aria-autocomplete="list" role="textbox" autocomplete="off" class="ui-autocomplete-input dec" style="padding:3px;width: 195px;text-transform: uppercase;" name="jobref" id="jobref" type="text" value="<?php echo $_SESSION['ref_val']; ?>" />
                        <div id="result_ref">
                        </div>
                        <input type="hidden" name="user_session" id="user_session" value="<?php echo $_SESSION['sohorepro_userid']; ?>" />
                        <input type="hidden" name="user_session_comp" id="user_session_comp" value="<?php echo $_SESSION['sohorepro_companyid']; ?>" />
                        <input type="hidden" name="jobref_id" id="jobref_id" value="" />
                        <input type="hidden" name="company_id" id="company_id" value="" />   
                        <input type="hidden" name="drop_off_select_val" id="drop_off_select_val" value="" />
                        <input type="hidden" name="continue_ok" id="continue_ok" value="0" />
                    </span>
                  </li>
                    <div  id="set">
                        <input type="hidden" name="pri_inc_val" id="pri_inc_val" value="1" />
                  <li class="clear">
                      <!-- FOR EACH START -->  
                    <?php
                    $user_id_add_set        = $_SESSION['sohorepro_userid'];
                    $company_id_view_plot   = $_SESSION['sohorepro_companyid']; 
                    $check_plotting         = PlottingSetWithoutOrderId($company_id_view_plot, $user_id_add_set);
                    $check_plotting_needed  = PlottingNeededSetWithoutOrderId($company_id_view_plot, $user_id_add_set);   
                    
                    if(count($check_plotting) > 0){
                        $delete_empty = "DELETE FROM sohorepro_plotting_set WHERE company_id = '".$company_id_view_plot."' AND user_id = '".$user_id_add_set."' AND order_id = '0'";
                        mysql_query($delete_empty);
                    }
                    
                    if(count($check_plotting_needed) > 0){
                        $delete_empty = "DELETE FROM sohorepro_sets_needed WHERE comp_id = '".$company_id_view_plot."' AND usr_id = '".$user_id_add_set."' AND order_id = '0'";
                        mysql_query($delete_empty);
                    }
                    
//                    if(count($check_plotting) > 0){
//                        echo 'IS THERE';
//                    }  else {
//                        echo 'Not There';
//                    }
                    ?>
                <div  id="sets_all">               
                
                    <div class="serviceOrderSetHolder">
                        <label style="font-weight: bold; margin-bottom: 0px; margin-top: 0px;" for="jo1" class="optional">
                        Job Options 
                        <div style="float:right;font-weight: bold;">
                            Option - 1                           
                        </div>
                        </label>  
                        <div style="background-color:#FFFFFF" class="serviceOrderSetWapper" setindex="0">
                            <div class="serviceOrderSetWapperInternal">
                            <div class="serviceOrderSetDIV">
                            <div style="width: 100%;float: left;padding-top: 10px;">  
                                
                                <!--Check Box Start-->
                                <div style="float:left;width:100%;">
                                    <ul class="arch_radio">
                                        <li><input type="radio" name="plotting_check" id="plotting_check" style="width:2% !important;" value="1" onclick="return active_plot();" /><span style="font-size: 13px;padding-left: 7px;font-weight: bold;">PLOTTING</span></li>
                                        <li><input type="radio" name="plotting_check" id="plotting_check_0" style="width:2% !important;" value="0" onclick="return active_arch();" /><span style="font-size: 13px;padding-left: 7px;font-weight: bold;">ARCHITECTURAL COPIES</span></li>
                                    </ul>
                                    <span id="errmsg"></span>
                                </div>
                                <!--Check Box End-->
                                
                                <!--Originals Start-->
                                <div>
                                    <label>
                                      Originals
                                    </label>
                                        <input class="order_0_set1_0_original k-input kdText " style="width:65px;" id="original" name="original" type="text" value="" />
                                </div>
                                <!--Originals End-->
                                
                                <!--POE Start-->
                                <div>
                                    <label>
                                      Prints of Each<span style="color: red;">*</span>
    <!--                                  <span style="font-weight:bold;color:#cc0000">
                                        *
                                      </span>-->
                                    </label>
                                    <input class="ymlrequired order_0_set1_0_printOfEach k-input kdText " style="width:80px;" id="print_ea" name="print_ea" type="text" value="" />
                                </div>
                                <!--POE End-->
                                
                                <!--Size Start-->
                                <div>
                                  <label>
                                    Size<span style="color: red;">*</span>
                                  </label>
                                  <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                    <div style="float:left;margin-right:0px;">
                                        <select class="order_0_set1_0_size kdSelect" style="width: 135px;" id="size" name="size" onchange="return custome_size();">                            
                                            <option value="FULL">FULL</option>
                                            <option value="HALF">HALF</option>
                                            <option value="Reduce to 11 X 17">Reduce to 11 X 17</option>
                                            <option value="Custom">Custom</option>                          
                                        </select>
                                    </div>
                                    <div class="dropdown_selector">
                                    </div>
                                  </div>
                                </div>
                                <!--Size End-->
                                
                                <!--Output Start-->
                                <div>
                                  <label>
                                    Output<span style="color: red;">*</span>
                                  </label>
                                  <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                    <div style="float:left;margin-right:0px;">
                                      <select class="order_0_set1_0_output kdSelect " style="width: 90px;" id="output" name="output" onchange="return custome_output();">
                                        <option value="B/W">B/W</option>
                                        <option value="Color">Color</option>
                                        <option value="Both">Both</option>
                                      </select>

                                    </div>
                                    <div class="dropdown_selector">
                                    </div>
                                  </div>
                                </div>
                                <!--Size End-->
                                
                                <!--Media Start-->
                                <div>
                                  <label>
                                    Media<span style="color: red;">*</span>
                                  </label>
                                  <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                    <div style="float:left;margin-right:0px;">
                                      <select class="order_0_set1_0_media kdSelect " style="width: 100px;" id="media" name="media">
                                        <option value="Bond">Bond</option>
                                        <option value="Vellum">Vellum</option>
                                        <option value="Mylar">Mylar</option>                          
                                      </select>
                                    </div>
                                    <div class="dropdown_selector">
                                    </div>
                                  </div>
                                </div>
                                <!--Media End-->
                                
                                <!--Binding Start-->
                                <div>
                                  <label>
                                    Binding
                                  </label>
                                  <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                    <div style="float:left;margin-right:0px;">
                                      <select class="order_0_set1_0_binding kdSelect " style="width: 80px;" id="binding" name="binding">
                                        <option value="none">None</option>                                      
                                        <option value="Bind All">Bind All</option>                          
                                        <option value="Bind by Discipline">Bind by Discipline</option>
                                        <option value="Screw Post">Screw Post</option>
                                      </select>
                                    </div>
                                    <div class="dropdown_selector">
                                    </div>
                                  </div>
                                </div>
                                <!--Binding End-->
                                
                                <!--Folding Start-->
                                <div>
                                  <label>
                                    Folding
                                  </label>
                                  <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                    <div style="float:left;margin-right:0px;">
                                      <select class="order_0_set1_0_folding kdSelect " style="width: 100px;" id="folding" name="folding">
                                        <option value="None">None</option>
                                        <option value="Yes">Yes</option>                          
                                      </select>
                                    </div>
                                    <div class="dropdown_selector">
                                    </div>
                                  </div>
                                </div>
                                <!--Folding End-->
                            </div>
                                <!--Custom Details Start-->
                            <div id="size_custom_div" style="border: 1px #FF7E00 solid;width: 100%;padding: 5px;text-align: center;margin-bottom: 10px;display: none;">
                                <label style="font-weight: bold;">Please Specify Custom Details : </label><textarea name="size_custom" id="size_custom" rows="3" cols="18" style="width: 201px;" placeholder="Custom Size"></textarea>
                            </div>
                                <!--Custom Details End-->
                                <!--Page Number Details Start-->
                            <div id="output_both_div" style="border: 1px #FF7E00 solid;width: 100%;padding: 5px;text-align: center;margin-bottom: 10px;display: none;">
                                <label style="font-weight: bold;">Enter page numbers that are in COLOR (separated by a comma) :</label>
                                <input type="text" name="output_both" id="output_both" style="width: 200px;" placeholder="Enter page numbers" />
                            </div>
                                <!--Page Number Details End-->
                                
                <div style="width:730px;border-bottom: 1px solid #CCCCCC;float: left;">
                    <label id="alt_ops" style="font-weight: bold;height:28px">
                      File Options<span style="color: red;">*</span>
                    </label>
                    
                    <label id="pick_ops" style="font-weight: bold;height:28px;display: none;">
                      Pickup Options<span style="color: red;">*</span>
                    </label>
<!--                    <input type="checkbox"  style="display: none;width: 2%;" name="use_same_check" id="use_same_check_box" value="1"  onclick="return use_same_set('1');" />-->
                    <div id="options_plott" class="check" style="width:730px;border-top: 1px solid #FF7E00;margin-top:-13px;">
                    <div class="spl_option" style="float: 100%;">
                            <div>
                                <input class="filetrigger" name="alt_file_option" value="dropOff" id="drop_file"  type="radio" onclick="return upload_soho();" />
                                <label for="drop" >
                                  Upload File
                                </label>                    
                            </div>

                            <div>
                                  <input class="filetrigger" name="alt_file_option" value="dropOff" id="link"  type="radio" onclick="return provide_link();" />
                                <label for="drop" >
                                  Provide Link to File
                                </label>                    
                            </div>   
                        
                            <div>
                                <input class="filetrigger" name="alt_file_option" value="pickUp" id="pick"  type="radio" onclick="return show_date_picker();" />
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
                            <input class="filetrigger" name="alt_file_option" value="dropOff" id="dropoff"  type="radio" onclick="return drop_sohorepro();" />
                          <label for="drop" >
                            Drop off at Soho Repro
                          </label>                    
                        </div>                               
                    </div>
                  <br>
                      
                      <!--File Upload Details Start-->
                      <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="up_form">
                        <input type="hidden" name="uploadedfile" id="uploadedfile" value="" /> 
                        <div id="dragandrophandler">Drag & Drop Files Here</div>
                        <br><br>
                        <div id="status1"></div> 
                      </div>
                      <!--File Upload Details End-->
                      
                      <!--FTP Details Start-->
                      <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="provide_link">
                        <div style="margin: auto;width: 60%;">
                            <div style="margin: auto;width: 60%;float:right;">
                            <!--<textarea name="provide_link" id="provide_link_text" rows="3" cols="18" style="width: 201px;"></textarea>-->
                            <input type="text" name="ftp_link" id="ftp_link" placeholder="FTP Link" />
                            <input type="text" name="user_name" id="user_name" placeholder="User Name" />
                            <input type="text" name="password" id="pass_word" placeholder="Password" />
                            </div>
                            <div style="margin: auto;width: 60%;float:right;padding-top: 5px;">
                            <!--<span>If providing an FTP link, please include username and password.</span> -->
                            </div>
                        </div>   
                      </div>
                      <!--FTP Details Start-->
                      
                      <!--Pickup Details Start-->
                      
                      <div id="date_time" style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;display:none;">
                                <input type="hidden" name="all_exist_date" id="all_exist_date" value="<?php echo $all_date_exist; ?>" />                                
                                <div style="width: 34%;float: left;"> 

                                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;border-bottom: 0px;text-align: center;">
                                        <span style="cursor: pointer;display: inline-block;background: #F99B3E;color: #000;padding: 5px 20px;border-radius: 5px;margin-top: 3px;font-weight: bold;" onclick="return asap();">READY NOW</span>
                                    </div>

                                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                                        <input class="date_for_alt picker_icon" value="" type="text" name="date_needed" id="date_for_alt" style="width: 75px;" onclick="date_reveal();" />
                                        <input id="time_for_alt" value="" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time();" />
                                    </div>

                                </div>
                            </div>
                      
<!--                        <div id="date_time" style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;float: left;width: 30%;padding-bottom: 10px;display:none;">
                            <div style="width: 100%;">
                                <input style="margin-left: 75px;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="button" name="ready_now" value="READY NOW" id="ready_now" onclick="return ready_now();" />
                            </div>                      

                            <div style="border: 1px #CCC solid;width: 95%;margin-left: 5px;margin-bottom: 10px;"></div>
- JASSIM DATE 
                            <div style="padding: 5px;">
                            <input type="hidden" name="all_exist_date" id="all_exist_date" value="<?php echo $all_date_exist; ?>" />
                            <input type="text" name="dahe_for_alt" id="date_for_alt" style="width: 30%;margin-left: 5px;" class="date_for_alt picker_icon" />                        

                            <input id="time_for_alt" type="text" style="width: 30%;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" />
                            </div>                        
                            
                            

                        </div>-->
                      <!--Pickup Details End-->
                      
                      <!--Drop off Details Start Plotting -->
                      <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="drop_off">
                        <div style="margin: auto;width: 60%;">
                            <div style="margin: auto;width: 75%;float:right;">
                                <input style="width: 10% !important;" type="radio" name="drop_val" id="drop_val" value="381 Broome Street" />381 Broome Street
                                <input style="width: 10% !important;margin-left: 35px !important;" type="radio" name="drop_val" id="drop_val_1" value="307 7th Ave, 5th Floor" />307 7th Ave, 5th Floor
                            <!-- <select id="drop_val">
                                    <option value="" selected="selected">Select</option>
                                    <option value="381 Broom">381 Broome St</option>
                                    <option value="307 7th Ave, 5th Floor" >307 7th Ave, 5th Floor</option>
                                </select> -->
                            </div>                            
                        </div>   
                      </div>
                      <!--Drop off Details End-->
                      
                </div> 
                <div id="options_arch" class="check none" style="width:730px;border-top: 1px solid #FF7E00;">
                <div class="spl_option" style="float: 100%;">
                        <div>
                            <input class="filetrigger" name="alt_file_option" value="pickUp" id="pick"  type="radio" onclick="return show_date_picker_arch();" />
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
                        <input class="filetrigger" name="alt_file_option" value="dropOff" id="dropoff"  type="radio" onclick="return drop_sohorepro_arch();" />
                      <label for="drop" >
                        Drop off at Soho Repro
                      </label>                    
                    </div>                               
                </div>
              <br>

                  <!--Pickup Details Start-->

                  <div id="date_time_arch" style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;display:none;">
                            <input type="hidden" name="all_exist_date" id="all_exist_date" value="<?php echo $all_date_exist; ?>" />                                
                            <div style="width: 34%;float: left;"> 

                                <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;border-bottom: 0px;text-align: center;">
                                    <span style="cursor: pointer;display: inline-block;background: #F99B3E;color: #000;padding: 5px 20px;border-radius: 5px;margin-top: 3px;font-weight: bold;" onclick="return asap_arc();">READY NOW</span>
                                </div>

                                <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                                    <input class="date_for_alt picker_icon" value="" type="text" name="date_needed" id="date_for_alt_arc" style="width: 75px;" onclick="date_reveal();" />
                                    <input id="time_for_alt_arc" value="" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time();" />
                                </div>

                            </div>
                        </div>
                  <!--Pickup Details End-->

                  <!--Drop off Details Start-->
                  <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="drop_off_arch">
                    <div style="margin: auto;width: 60%;">
                        <div style="margin: auto;width: 75%;float:right;">
                            <input style="width: 10% !important;" type="radio" name="drop_val" id="drop_val_arc" value="381 Broome Street" />381 Broome Street
                            <input style="width: 10% !important;margin-left: 35px !important;" type="radio" name="drop_val" id="drop_val_arc_1" value="307 7th Ave, 5th Floor" />307 7th Ave, 5th Floor
                        <!-- <select id="drop_val">
                                <option value="" selected="selected">Select</option>
                                <option value="381 Broom">381 Broome St</option>
                                <option value="307 7th Ave, 5th Floor" >307 7th Ave, 5th Floor</option>
                            </select> -->
                        </div>                            
                    </div>   
                  </div>
                  <!--Drop off Details End-->

            </div>
                    
                    
                <!--Special Instruction Start-->
                <div style="float: left;width: 100%;margin-top: 15px;">
                    <div id="sp_inst" style="margin-top:10px;">
                      <label style="font-weight: bold;margin-bottom: -4px; margin-top: -10px;">
                        Special Instructions
                      </label>
                      <br>
                      <textarea name="special_instruction" class="splins" id="special_instruction" rows="4" cols="60" style="margin-top:-5px;margin-bottom:10px;"><?php echo $entered['spl_instruction']; ?></textarea>
                    </div>
                </div>
                 <!--Special Instruction End-->
              </div>
              </div>
                            
              </div>              
                            
              
                            
              
              </div>
              </div>
                    
            </div>    
               
               <!-- FOR EACH END -->     
                  
             
                    
              <div style="float:left;width:100%;text-align:right;margin-top: 10px;">
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
    var jobreference        = document.getElementById("jobref").value;
    
    var check_val           = document.getElementById("plotting_check").checked;
    var check_val_0         = document.getElementById("plotting_check_0").checked;
    var plotting_check      = (check_val == true) ? '1' : '0';
    
    var original            = document.getElementById("original").value;
    var print_ea            = document.getElementById("print_ea").value;
    var size                = document.getElementById("size").value;
    var output              = document.getElementById("output").value;
    var media               = document.getElementById("media").value;
    var binding             = document.getElementById("binding").value;
    var folding             = document.getElementById("folding").value;
    var special_instruction = document.getElementById("special_instruction").value;
    var size_custom         = document.getElementById("size_custom").value;
    var output_both         = document.getElementById("output_both").value;
    
    var date_for_alt        = document.getElementById("date_for_alt").value;
    var date_for_alt_arc    = document.getElementById("date_for_alt_arc").value;
    if(date_for_alt != ''){
        var date_for_alt_val    = date_for_alt;
    }else if(date_for_alt_arc != ''){
        var date_for_alt_val    = date_for_alt_arc;
    }else{
        var date_for_alt_val    = '0';
    }
    
    var time_for_alt        =  document.getElementById("time_for_alt").value;
    var time_for_alt_arc    =  document.getElementById("time_for_alt_arc").value;
    if(time_for_alt != ''){
        var time_for_alt_val    =  time_for_alt;
    }else if(time_for_alt_arc != ''){
        var time_for_alt_val    =  time_for_alt_arc;
    }else{
        var time_for_alt_val    =  '0';
    }
    
    var drop_chk_val_0          =   document.getElementById("drop_val").value;
    var drop_chk_val_1          =   document.getElementById("drop_val_1").value;
    
    var drop_chk_arc_val_0      =   document.getElementById("drop_val_arc").value;
    var drop_chk_arc_val_1      =   document.getElementById("drop_val_arc_1").value;
    
    var drop_chk_1          =   document.getElementById("drop_val").checked;
    var drop_chk_2          =   document.getElementById("drop_val_1").checked;
    var drop_chk_arc_1      =   document.getElementById("drop_val_arc").checked;
    var drop_chk_arc_2      =   document.getElementById("drop_val_arc_1").checked;
    
    var drop_off_select_val =   document.getElementById("drop_off_select_val").value;
    
    if(drop_off_select_val == '1'){
        if(drop_chk_1 == true){
            var drop_val            =   drop_chk_val_0;
        }else if(drop_chk_2 == true){
            var drop_val            =   drop_chk_val_1;
        }else if(drop_chk_arc_1 == true){
            var drop_val            =   drop_chk_arc_val_0;
        }else if(drop_chk_arc_2 == true){
            var drop_val            =   drop_chk_arc_val_1;
        }
    }else{
            var drop_val            =   '0';
    }
    
    var ftp_link            =   document.getElementById("ftp_link").value;
    var user_name           =   document.getElementById("user_name").value;
    var password            =   document.getElementById("pass_word").value;
    
    var ftp_link_val        =   (ftp_link != '') ? ftp_link : '0';
    var user_name_val       =   (user_name != '') ? user_name : '0';
    var password_val        =   (password != '') ? password : '0';
        
    var size_custom_val     =  (size_custom != '') ? size_custom : '0';
    var output_both_val     =  (output_both != '') ? output_both : '0';
    
    var size_custom         = (size == 'Custom') ? document.getElementById("size_custom").value : '0';
    
    if(jobreference == ''){
        alert('Please enter the Job Reference');
        document.getElementById("jobref").focus();
        return false;
    }
    if(print_ea == ''){
        alert('Please enter the Print');
        document.getElementById("print_ea").focus();
        return false;
    }  
//    if(output == 'Both'){
//        if(special_instruction == ''){
//        alert('Please enter the special instructions');
//        document.getElementById("special_instruction").focus();
//        return false;  
//        }      
//    }
    if(size == 'Custom'){
       if(size_custom == ''){
        alert('Please enter the custom size');
        document.getElementById("size_custom").focus();
        return false;  
        }      
    }
    if (jobreference != '')
    {
        $.ajax
                ({
                    type: "POST",
                    url: "add_plotting_sets.php",
                    data: "service_plotting_add=1&job_reference="+encodeURIComponent(jobreference)+
                          "&original="+encodeURIComponent(original)+"&print_ea="+encodeURIComponent(print_ea)+
                          "&size="+encodeURIComponent(size)+"&output="+encodeURIComponent(output)+
                          "&media="+encodeURIComponent(media)+
                          "&binding="+encodeURIComponent(binding)+"&folding="+encodeURIComponent(folding)+
                          "&plot_arch="+encodeURIComponent(plotting_check)+"&special_instruction="+encodeURIComponent(special_instruction)+
                          "&size_custom_val="+encodeURIComponent(size_custom_val)+"&output_both_val="+encodeURIComponent(output_both_val)+
                          "&pickup_date="+encodeURIComponent(date_for_alt_val)+"&pickup_time="+encodeURIComponent(time_for_alt_val)+
                          "&drop_val="+encodeURIComponent(drop_val)+"&ftp_link_val="+encodeURIComponent(ftp_link_val)+
                          "&user_name_val="+encodeURIComponent(user_name_val)+"&password_val="+encodeURIComponent(password_val)+"&size_custom="+encodeURIComponent(size_custom),
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {                           
                        $('#sets_all').slideDown();
                        $('#sets_all').html(option);
                        $('#continue_ok').val('1');
                    }
                });
    }
    
  }   

function validate_plotting_cont()
{
    var jobreference        = document.getElementById("jobref").value;
    var continue_ok         = document.getElementById("continue_ok").value;  
    var check_val           = document.getElementById("plotting_check").checked;
    var check_val_0         = document.getElementById("plotting_check_0").checked;
    var plotting_check      = (check_val == true) ? '1' : '0';
    
    var original            = document.getElementById("original").value;
    var print_ea            = document.getElementById("print_ea").value;
    var size                = document.getElementById("size").value;
    var output              = document.getElementById("output").value;
    var media               = document.getElementById("media").value;
    var binding             = document.getElementById("binding").value;
    var folding             = document.getElementById("folding").value;
    var special_instruction = document.getElementById("special_instruction").value;
    var size_custom         = document.getElementById("size_custom").value;
    var output_both         = document.getElementById("output_both").value;
    
    var date_for_alt        = document.getElementById("date_for_alt").value;
    var date_for_alt_arc    = document.getElementById("date_for_alt_arc").value;
    if(date_for_alt != ''){
        var date_for_alt_val    = date_for_alt;
    }else if(date_for_alt_arc != ''){
        var date_for_alt_val    = date_for_alt_arc;
    }else{
        var date_for_alt_val    = '0';
    }
    
    var time_for_alt        =  document.getElementById("time_for_alt").value;
    var time_for_alt_arc    =  document.getElementById("time_for_alt_arc").value;
    if(time_for_alt != ''){
        var time_for_alt_val    =  time_for_alt;
    }else if(time_for_alt_arc != ''){
        var time_for_alt_val    =  time_for_alt_arc;
    }else{
        var time_for_alt_val    =  '0';
    }
    
    var drop_chk_val_0          =   document.getElementById("drop_val").value;
    var drop_chk_val_1          =   document.getElementById("drop_val_1").value;
    
    var drop_chk_arc_val_0      =   document.getElementById("drop_val_arc").value;
    var drop_chk_arc_val_1      =   document.getElementById("drop_val_arc_1").value;
    
    var drop_chk_1          =   document.getElementById("drop_val").checked;
    var drop_chk_2          =   document.getElementById("drop_val_1").checked;
    var drop_chk_arc_1      =   document.getElementById("drop_val_arc").checked;
    var drop_chk_arc_2      =   document.getElementById("drop_val_arc_1").checked;
    
    var drop_off_select_val =   document.getElementById("drop_off_select_val").value;
    
    if(drop_off_select_val == '1'){
        if(drop_chk_1 == true){
            var drop_val            =   drop_chk_val_0;
        }else if(drop_chk_2 == true){
            var drop_val            =   drop_chk_val_1;
        }else if(drop_chk_arc_1 == true){
            var drop_val            =   drop_chk_arc_val_0;
        }else if(drop_chk_arc_2 == true){
            var drop_val            =   drop_chk_arc_val_1;
        }
    }else{
            var drop_val            =   '0';
    }
    
    var ftp_link            =   document.getElementById("ftp_link").value;
    var user_name           =   document.getElementById("user_name").value;
    var password            =   document.getElementById("pass_word").value;
    
    var ftp_link_val        =   (ftp_link != '') ? ftp_link : '0';
    var user_name_val       =   (user_name != '') ? user_name : '0';
    var password_val        =   (password != '') ? password : '0';
        
    var size_custom_val     =  (size_custom != '') ? size_custom : '0';
    var output_both_val     =  (output_both != '') ? output_both : '0';
    
    var size_custom         = (size == 'Custom') ? document.getElementById("size_custom").value : '0';
    
    if(jobreference == ''){
        alert('Please enter the Job Reference');
        document.getElementById("jobref").focus();
        return false;
    }
    if(continue_ok != '1'){
    if(print_ea == ''){
        alert('Please enter the Print');
        document.getElementById("print_ea").focus();
        return false;
    }  
//    if(output == 'Both'){
//        if(special_instruction == ''){
//        alert('Please enter the special instructions');
//        document.getElementById("special_instruction").focus();
//        return false;  
//        }      
//    }
    if(size == 'Custom'){
       if(size_custom == ''){
        alert('Please enter the custom size');
        document.getElementById("size_custom").focus();
        return false;  
        }      
    }
    }
    if (jobreference != '')
    {
         $.ajax
                ({
                    type: "POST",
                    url: "add_plotting_sets.php",
                    data: "service_plotting_add=1&job_reference="+encodeURIComponent(jobreference)+
                          "&original="+encodeURIComponent(original)+"&print_ea="+encodeURIComponent(print_ea)+
                          "&size="+encodeURIComponent(size)+"&output="+encodeURIComponent(output)+
                          "&media="+encodeURIComponent(media)+
                          "&binding="+encodeURIComponent(binding)+"&folding="+encodeURIComponent(folding)+
                          "&plot_arch="+encodeURIComponent(plotting_check)+"&special_instruction="+encodeURIComponent(special_instruction)+
                          "&size_custom_val="+encodeURIComponent(size_custom_val)+"&output_both_val="+encodeURIComponent(output_both_val)+
                          "&pickup_date="+encodeURIComponent(date_for_alt_val)+"&pickup_time="+encodeURIComponent(time_for_alt_val)+
                          "&drop_val="+encodeURIComponent(drop_val)+"&ftp_link_val="+encodeURIComponent(ftp_link_val)+
                          "&user_name_val="+encodeURIComponent(user_name_val)+"&password_val="+encodeURIComponent(password_val)+"&size_custom="+encodeURIComponent(size_custom),
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
    var use_same = document.getElementById('use_same_check_box').checked;     
    if(use_same == true){
    $("#use_same").slideDown(1000);
    $(".check").slideUp();
    $("#options_arch").slideUp();
    }else{
    $(".check").slideDown();
    $("#options_arch").slideUp();
    }
}

function ready_now(){
    alert("All orders placed online are assumed to be for today and available for collection immediately.  If you wish to       place an order for another date and time, or for today but       at a later time, please check the box at the left and then enter below a date and time for collection.");
}


function delete_added_job(ID)
{
     var ok_to_proceed = confirm('Are you sure?');
    
    if(ok_to_proceed == true){     
    $.ajax
                ({
                    type: "POST",
                    url: "add_plotting_sets.php",
                    data: "service_plotting_add=0&delete_set_id=" + ID,
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {                            
                        $('#sets_all').slideDown();
                        $('#sets_all').html(option);
                    }
                });
            }else{
                return false;
            }
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

function asap()
{
    $("#date_for_alt").val("ASAP");
    $("#time_for_alt").val("ASAP");
    $("#date_for_alt_arc").val("ASAP");
    $("#time_for_alt_arc").val("ASAP");
    $("body").append("<div class='modal-overlay js-modal-close'></div>");
    $("#asap_popup").slideDown("slow");
}

function asap_arc()
{   
    $("#date_for_alt_arc").val("ASAP");
    $("#time_for_alt_arc").val("ASAP");
    $("body").append("<div class='modal-overlay js-modal-close'></div>");
    $("#asap_popup").slideDown("slow");
}

function close_asap()
{
    $(".modal-overlay").fadeOut();
    $("#asap_popup").slideUp("slow"); 
}

function active_plot()
{
    $("#options_plott").slideDown();
    $("#options_arch").slideUp();
    $("#alt_ops").slideDown();
    $("#pick_ops").slideUp();  
    $("#use_same_check_box").slideDown();
    $("#use_same_check_box_spn").slideDown();
}

function active_arch()
{
    $("#options_arch").slideDown();
    $("#options_plott").slideUp();
    $("#alt_ops").slideUp();
    $("#pick_ops").slideDown();
    $("#use_same_check_box").slideUp();
    $("#use_same_check_box_spn").slideUp();
}
 
 
 </script>




 </body>
 <!-- Mirrored from buckart.com/srsite/SoHoRepro-WebsitePages/store/store.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 21 Sep 2013 08:45:26 GMT -->
 </html>