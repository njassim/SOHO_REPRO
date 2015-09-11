<?php
include './config.php';
include './auth.php';

$active_category = getSuperCategoryActive();
$active_sub_category = getSubCategoryActive();
$super_category  = getSuperCat();

function AdminAlert($reg_compname,$reg_contactname)
{
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
    $message .='<td height="25" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;">Dear Admin,</br></td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">';
    $message .='<table>';
    $message .='<tr>';
    $message .='<td>New user has been registered</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td>Company Name : '.$reg_compname.'</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td>Contact Name : '.$reg_contactname.'</td>';
    $message .='</tr>';
    $message .='<tr>';
    $message .='<td><a href="http://supply.sohorepro.com/admin/new_accounts.php" target="_blank">http://supply.sohorepro.com/admin/new_accounts.php</a></td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
    $message .='</tr>';    
    $message .='</table>';
    $message .='</td>';
    $message .='</tr>';
    $message .='</table>';
    $message .='</td>';
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
    $final_html = html_entity_decode($message);

    $mail_id  = getActiveEmail();
    foreach ($mail_id as $to){
    $subject = 'New Account Created by '.$reg_compname;
    $headers = 'From: "SohoRepro" <noreply@new-sohorepro.com>' . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $to = $to['email_id'];
    //$mail_id = 'n.mohamedjassim@gmail.com';
    $result_mail = mail($to, $subject, $final_html, $headers);
    }
    if($result_mail){
        return '1';
    }  else {
        return  '0';
    }
}



if (isset($_REQUEST['new_company_add']) == '1') {    
    extract($_POST);    
    $comp_name_exist = checkcomp($reg_compname);    
    if (count($comp_name_exist) > 0) {
        $result = 'exist';
    } else {
        move_uploaded_file($_FILES["file"]["tmp_name"], "../tax_form/" . $_FILES["file"]["name"]);
        $tax_file_name = $_FILES["file"]["name"];
        $sql = "INSERT INTO sohorepro_company SET
             comp_contact_name = '" . $reg_contactname . "',
             comp_contact_email = '" . $reg_contactmail . "',
             comp_name = '" . $reg_compname . "',  
             cust_id    = '" . $reg_cus_id . "',
             comp_contact_phone = '" . $reg_contphone1 . "',
             comp_contact_fax   = '".$reg_busifax."',
             comp_business_address1 = '" . $address1 . "',
             comp_business_address2 = '" . $address2 . "',
             comp_business_address3 = '" . $address3 . "',    
             comp_room = '" . $reg_busiroom . "',
             comp_suite = '" . $reg_busisuite . "',
             comp_floor = '" . $reg_busifloor . "',
             comp_city = '" . $reg_busicity . "',
             comp_state = '" . $reg_busistate . "',
             comp_zipcode = '" . $reg_busizip . "',
             comp_zipcode_ext   =   '" .$reg_busizip_ext. "',
             comp_phone1 = '" . $reg_phone1 . "',
             comp_phone2 = '" . $reg_phone2 . "',
             comp_phone3 = '" . $reg_phone3 . "',
             comp_phone4 = '" . $reg_phone4 . "',
             tax_form_resale = '" . $tax_file_name . "',
             tax_exe  = '" . $reg_tax . "',
             cus_type  = '2' ";
        $result = mysql_query($sql);       
            
        //Insert the Primari Billing address for New Company Start

        $comp_id = mysql_insert_id();
        $shipp_state_id = StateId($reg_busistate);
        $shipp_sql = "INSERT INTO sohorepro_address SET
             comp_id = '" . $comp_id . "',
             company_name = '" . $reg_compname . "',
             contact_name = '" . $reg_contactname . "',
             address_1 = '" . $address1 . "',
             address_2 = '" . $address2 . "',
             address_3 = '" . $address3 . "',            
             city = '" . $reg_busicity . "',
             state = '" . $shipp_state_id . "',
             zip = '" . $reg_busizip . "',
             zip_ext = '".$reg_busizip_ext."',
             phone = '" . $reg_contphone1 . "',
             attention_to = '" . $reg_contactname . "',
             type = '1',
             prop = '0'";
        $inserted_val = mysql_query($shipp_sql);  
        
        
        $sql_user = "INSERT INTO sohorepro_customers SET
             cus_email = '" . $reg_contactmail . "',
             cus_pass = '" . $reg_password . "',
             cus_compname = '" . $comp_id . "',      
             cus_contact_name = '" . $reg_contactname . "',
             cus_contact_email   = '".$reg_contactmail."',
             cus_contact_phone = '" . $reg_contphone1 . "',
             cus_manager = '1',
             cus_status = '1' ";
        mysql_query($sql_user); 
        
        
        
        //Insert the Primari Billing address for New Company End

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
        $message .='<td height="25" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;">Dear ' . $reg_contactname . ',</br></td>';
        $message .='</tr>';
        $message .='<tr>';
        $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444">';
        $message .='<table>';
        $message .='<tr>';
        $message .='<td>Thank you for your request, your application is under review. You will be contacted by a representative after your application has been approved.</td>';
        $message .='</tr>';
        $message .='</table>';
        $message .='</td>';
        $message .='</tr>';
        $message .='<tr>';
        $message .='<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444; padding-top:10px;">Thanks</td>';
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

        $subject = 'New Account Created - SohoRepro';
        $headers = 'From: "SohoRepro" <no-reply@sohorepro.com>' . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        $mail_id = $reg_contactmail;
        //$mail_id = 'n.mohamedjassim@gmail.com';
        $result_mail = mail($mail_id, $subject, $message, $headers);
        $admin_alert = AdminAlert($reg_compname,$reg_contactname);
        //echo $admin_alert;
        if ($inserted_val) {
            $result = 'success';
        }else{
            $result = 'failure';
        }
    }
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Soho-repro</title>
        <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="../style/popup_style.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="../js/popup_script.js"></script>
        <script src="../js/jquery.maskedinput.js" type="text/javascript" ></script>
        <script src="../js/jquery.js" type="text/javascript" ></script>
    <script src="../js/jquery.validate.js" type="text/javascript" ></script>
<script src="../js/jquery.maskedinput.js" type="text/javascript" ></script>
<script type="text/javascript">
    $(document).ready(function() {
        var validation_obj = {
            rules: {email_id: {
                    required: true,
                    email: true
                }},
            messages: {
                email_id: {
                    required: '',
                    email: true
                },
                password: {
                    required: ''
                }
            }
        };
        $("#login_form").validate(validation_obj);
        var validation_forgot = {

            rules: {email_id: {
                    required: true,
                    email: true
                    }
            },
            messages: {
                email_id: {
                   required: ''
                }
            }
        };

        $("#forgot_form").validate(validation_forgot);
        var validation_reg = {
            rules: {reg_contactmail: {
                    required: true,
                    email: true,
                    remote: {
                           url: "get_child.php",
                           type: "post",
                                 data: {
                                   email: function() {
                                     return $("#reg_contactmail").val();
                                   }
                                 }
                           }
                },
                reg_password: {
                    required: true,
                    rangelength: [5, 15]
                }},
            messages: {
                reg_fname: {
                    required: ''
                },
                reg_lname: {
                    required: ''
                },
                reg_contactmail: {
                    required: '',
                    remote: jQuery.validator.format("{0} is already in our system.")
                    },
                reg_compname: {
                    required: ''
                },
                reg_cus_id: {
                    required: ''
                },
                reg_contphone1: {
                    required: ''
                },
                address1: {
                    required: ''
                },
                address2: {
                    required: ''
                },
                reg_busiroom: {
                    required: ''
                },
                reg_busisuite: {
                    required: ''
                },
                reg_busifloor: {
                    required: ''
                },
                reg_busicity: {
                    required: ''
                },
                reg_busifax: {
                    required: ''
                },
                reg_busistate: {
                    required: ''
                },
                reg_busizip: {
                    required: ''
                }
            }
        };
    $("#reg_form").validate(validation_reg);
});
jQuery(function($) {
    $("#reg_contphone").mask("999-999-9999");
    $("#reg_contphone1").mask("999-999-9999");
    $("#reg_busifax").mask("999-999-9999");
    $("#reg_phone1").mask("999-999-9999");
    $("#reg_phone2").mask("999-999-9999");
    $("#reg_phone3").mask("999-999-9999");
    $("#reg_phone4").mask("999-999-9999");
    $("#reg_user_phone").mask("999-999-9999x999");
    $("#reg_busizip").mask("99999");
    $("#reg_busizip_ext").mask("9999");
});
function show_reg(str)
{
    if (str == 0)
    {
    $("#reg_form").show();
    $("#login_form").hide();
    }
    else
    {
    $("#reg_form").hide();
    $("#login_form").show();
    }

}
function show_forgot(str)
{
    if (str == 0)
    {
        $("#forgot_form").show();
        $("#login_form").hide();
    }
    else
    {
        $("#forgot_form").hide();
        $("#login_form").show();
    }
}
function change_txt(tid, val)
{
    var txt_val = $(tid).val();
    //alert(txt_val);
    if (txt_val == val)
    {
        $(tid).val('');
    }
}

function change_dtxt(tid, val)
{
    var txt_val = $(tid).val();
    //alert(txt_val);
    if (txt_val == '')
    {
        $(tid).val('');
    }
}
    </script>          
<style type="text/css">
label.error{
    color: red !important;
}
input.error,select.error,textArea.error{
    border: 1px solid red !important;
}
.btn_choose{background:url(../images/choose.png) no-repeat; width:100px; height:22px; cursor:pointer;}
.choose{width:100px; height:22px; opacity:0;}
label.error {
    color: red !important;
    left: 590px;
    margin-top: -20px;
    position: absolute;
    width: 80%;
}
.resale_table{
border:1px solid #ddd; background:#efefef;border-right: 0px;
margin-left:50px; font-size:14px;
text-align:center;
}
.resale_table td{ 
    padding:10px 20px;
    border-right: 1px solid #ddd;
}
.error{
/*border: 1px solid red !important;*/
}
</style>
<style type="text/css">
.label_regview
{
width: 150px;
float: left;
font-weight: bold;
}
.reginput
{
margin: 0 14px;
width: 166px;
border: 1px solid #e4e4e4;
padding: 3.5px;
margin-bottom: 15px;
font-size: 11px;
font-weight: bold;
color: #717171;
float: left;
}
.reg_submit
{
font-size:12px;
padding:1.5px; 
width: 80px;
margin-left:200px;
margin-top:5px; 
-moz-border-radius: 5px; 
-webkit-border-radius: 5px;
border:1px solid #8f8f8f; 
float: left;
}
.reg_head
{
color:#5C5C5C;
font-weight:bold;
font-size:18px;
padding-bottom:10px;
}
.resale_table{
border:1px solid #ddd; background:#efefef;border-right: 0px;
margin-left:50px; font-size:14px;
text-align:center;
/*text-transform: uppercase;*/
}
.resale_table td{ padding:10px 20px;border-right: 1px solid #ddd;}

.add_new_layout{
    width:100%;
    float:left;
}
.add_new_layout li{
    width: 50%;
    float:left;
}
</style>
    </head>

    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center" valign="top">
                    <table width="960" border="0" cellspacing="0" cellpadding="0" style="min-width:760px;">
                        <tr>
                            <td width="198" align="left" valign="top" bgcolor="#464646"><table width="198" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="181" align="left" valign="top"><img src="images/logo.jpg" width="198" height="181"  alt=""/></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <?php include "sidebar_menu.php"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle" style="min-height:280px; float:left;"></td>
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
                                            ADD NEW CUSTOMER
                                        <span style="float: right;padding-right: 5px;">Welcome <?php if($_SESSION['admin_user_type'] == '1'){echo 'admin';} if($_SESSION['admin_user_type'] == '2'){echo 'Staff User';}?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="30" align="center" valign="top">
                                            <?php
                                            if ($result == "success") {
                                                ?>
                                                <div style="color:#007F2A; text-align:center; padding-bottom:10px;">New customer added successfully</div>
                                                <script>setTimeout("location.href=\'add_new_customer.php\'", 1000);</script>
                                                <?php
                                            } elseif ($result == "failure") {
                                                ?>
                                                <div style="color:#F00; text-align:center; padding-bottom:10px;">New customer added not successfully</div>
                                                <script>setTimeout("location.href=\'add_new_customer.php\'", 1000);</script>       
                                                <?php
                                            }elseif ($result == "exist") {
                                                ?>
                                                <div style="color:#F00; text-align:center; padding-bottom:10px;">Customer Name is already exist.</div>
                                                <script>setTimeout("location.href=\'add_new_customer.php\'", 1000);</script>       
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
<td align="left" valign="top">
    <div style="width: 100%;float: left;">
        <div style="width: 50%;float: left;"></div>
        <div style="width: 40%;float: right;"><a  href="customers.php" style="margin-right: 12px;text-decoration: none;cursor: pointer;background: #F99B3E;color: #FFF;float: right;padding: 5px 20px;margin-top: 5px;border-radius: 5px;border: 1px;font-weight: bold;">BACK</a></div>
    </div>
<form id="reg_form" name="reg_form" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="new_company_add" value="1" id="order_val" /> 
<div>&nbsp;</div>
<?php
    if($_GET['for_succ'] == '1'){
    ?>
    <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Password sent successfully.</div> 
    <?php 
    }
    if($_GET['for_err'] == '1'){
    ?>
    <div style="color:#F00; text-align:center; padding-bottom:10px;">Email ID does not exist.</div>
    <?php
    } 
    ?>
            <div class="new_usr_acc" style="margin-left: 45px;"> 
             
                <ul class="add_new_layout">
                <li>
                    <div class="label_regview"> Contact Name<span style="color: red;">*</span> :</div> 
                    <input intvalue="Company name" class="required reginput comp_det_view" name="reg_contactname" id="reg_contactname" type="text" placeholder="Contact Name" />
                </li>
                <li>
                    <div class="label_regview"> Contact Email<span style="color: red;">*</span> :</div> 
                    <input intvalue="Contact Email" class="required reginput comp_det_view" name="reg_contactmail" id="reg_contactmail" type="text" placeholder="Contact Email"  />
                </li>
                <li>
                    <div class="label_regview"> Password :</div>            
                    <input intvalue="Phone 2" class="reginput comp_det_view"  name="reg_password" id="reg_password" type="text" placeholder="Password" style="width:60px;" />
                    <input type="button" name="gen_pass" value="Generate" id="gen_pass" onclick="return generate_password('5');" />
                </li>
                <li>
                    <div class="label_regview"> Company Name<span style="color: red;">*</span> :</div> 
                    <input intvalue="Company name" class="required reginput comp_det_view" name="reg_compname" id="reg_compname" type="text" placeholder="Company Name" />
                </li>
                <li>
                    <div class="label_regview"> Customer ID<span style="color: red;">*</span> :</div> 
                    <input intvalue="Company name" class="required reginput comp_det_view" name="reg_cus_id" id="reg_cus_id" type="text" placeholder="Customer ID" />
                </li>
                <li>
                    <div class="label_regview"> Company Phone<span style="color: red;">*</span> :</div> 
                    <input intvalue="Contact phone" class="required reginput comp_det_view" name="reg_contphone1" id="reg_contphone1" type="text" placeholder="Company Phone"/>
                </li>
                <li>
                    <div class="label_regview"> Address1<span style="color: red;">*</span> :</div> 
                    <input type="text" class="required reginput comp_det_view" name="address1" id="address1" placeholder="Address1" />
                </li>
                <li>
                    <div class="label_regview"> Address2 :</div> 
                    <input type="text" class="reginput comp_det_view" name="address2" id="address2" placeholder="Address2" />
                </li>
                <li>
                    <div class="label_regview"> Address3 :</div> 
                    <input type="text" class="reginput comp_det_view" name="address3" id="address3" placeholder="Address3" />
                </li>
                <!--<li>
                    <div class="label_regview"> Room/Flr/Suite :</div> 
                    <input intvalue="Room" class="reginput comp_det_view" name="reg_busiroom" id="reg_busiroom" type="text" placeholder="Room/Flr/Suite"/>
                </li>-->
                <li>
                    <div class="label_regview"> City<span style="color: red;">*</span> :</div> 
                    <input intvalue="City" class="required reginput comp_det_view" name="reg_busicity" id="reg_busicity" type="text" placeholder="City" value="New York"/>
                </li>
                <li>
                    <div class="label_regview"> Fax :</div> 
                    <input intvalue="City" class="reginput comp_det_view" name="reg_busifax" id="reg_busifax" type="text" placeholder="Fax"/>
                </li>
                <li>                        
                    <div class="label_regview"> State<span style="color: red;">*</span> :</div>
                    <select name="reg_busistate" id="reg_busistate" class="required reginput comp_det_view" style="width: 175px;">
                        <option value="">Select state</option>
                        <?php
                        $sel_state = mysql_query("select * from sohorepro_states");
                        while ($fth_states = mysql_fetch_array($sel_state)) {
                            ?>
                        <option value="<?php echo $fth_states['state_abbr']; ?>" <?php if($fth_states['state_abbr'] == "NY"){ ?> selected="selected" <?php } ?> ><?php echo $fth_states['state_name']; ?></option>
                        <?php } ?>
                    </select>  
                </li>
                <li>
                    <div class="label_regview"> Zip<span style="color: red;">*</span> :</div> 
                    <input intvalue="Zip" class="required reginput comp_det_view" name="reg_busizip" style="width: 50px;" id="reg_busizip" type="text" placeholder="Zip"/>
                    
                     <div class="label_regview"  style="float: left;width: auto;"> +4 :</div> 
                    <input intvalue="Zip" class="reginput comp_det_view" name="reg_busizip_ext" id="reg_busizip_ext" style="width: 40px;margin-left: 7px;" type="text" placeholder="+4"/>
                </li>                
                <li style="float: initial;">
                    <div class="label_regview" style="clear:both;"> Phone 2 :</div> 
                    <input intvalue="Phone 1" class="reginput comp_det_view" name="reg_phone1" id="reg_phone1" type="text" placeholder="Phone 2" onkeydown="move_nextfield_(this.id, 1);"/>
                </li>
                <li>
                    <div class="label_regview"> Phone 3 :</div> 
                    <input intvalue="Phone 2" class="reginput comp_det_view"  name="reg_phone2" id="reg_phone2" type="text" placeholder="Phone 3" onkeydown="move_nextfield_(this.id, 2);"/>
                </li>
                <li>
                    <div class="label_regview" style="clear:both;"> Phone 4 :</div> 
                    <input intvalue="Phone 3" class="reginput comp_det_view"  name="reg_phone3" id="reg_phone3" type="text" placeholder="Phone 4" onkeydown="move_nextfield_(this.id, 3);"/>
                </li>
                <li>
                    <div class="label_regview"> Tax Exemption :</div> 
                    <input intvalue="Tax" class="reginput comp_det_view tax_exc"  name="reg_tax" id="reg_tax" type="checkbox" placeholder="Tax" value="1"/>
                    <input intvalue="Tax" style="display: none;" class="reginput comp_det_view" disabled="disabled"  name="reg_tax_val" id="reg_tax_val" type="checkbox" checked="checked" placeholder="Tax" value="1"/> 
                    <input intvalue="Tax" style="display: none;" class="reginput comp_det_view" disabled="disabled"  name="reg_tax_null" id="reg_tax_null" type="checkbox" placeholder="Tax" value="0"/> 
                </li>
                <li>
            </ul>
            <div style="clear: both;"></div>
            <div id="tax_form_1" style="display: none;">
                <table width="620" border="0" cellspacing="0" cellpadding="0" class="resale_table" >
                    <tr>
                        <td align="center" valign="middle">
                            Resale Certificate&nbsp;(ST-120)&nbsp;&nbsp;<a style="color: #ff7e00;text-decoration: none;font-weight: normal;" href="download.php?file=st120_fill_in.pdf">Download ST-120 Form</a></br>
                            <a href="#" style="color: #ff7e00;text-decoration: none;font-weight: normal;" class="instruction_1">View Instructions</a>
                        </td>
                        <td align="center" valign="middle">
                            Exempt Use Certificate&nbsp;(ST-121 & ST-119.1)&nbsp;&nbsp;<br>
                                <a style="color: #ff7e00;text-decoration: none;font-weight: normal;" href="download.php?file=st121_fill_in.pdf">Download ST-121 Form</a></br>
                            <a style="color: #ff7e00;text-decoration: none;font-weight: normal;" href="download.php?file=ST-119.1_fill_in.pdf">Download ST-119.1 Form</a></br>
                            <a style="color: #ff7e00;text-decoration: none;font-weight: normal;" href="#" class="instruction_2">View Instructions</a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2" style="border-top: 1px solid #ddd;" valign="middle">Upload the filled form: 
                            <!--<input type="file" name="file" id="exempt_form"/>-->
                            <div class="btn_choose">
                                <input type="file" id="exempt_form" class="choose" name="file" />
                            </div>
                        </td> 
                    </tr>
                </table>  
            </div>
            <!--Instruction 1 Start-->
            <div id="instruction_1"> 
                <div class="close"></div>
                <span class="ecs_tooltip">Press Esc to close <span class="arrow"></span></span>
                <div id="popup_content"> <!--your content start-->
                    <p style="padding-top: 20px;margin-left: 10px;font-size: 14px;line-height: 1.5;">
                        Please fill out the downloaded form and rename the file so it includes the name the account will be established under. 
                        Use the "Choose File" button to upload the completed form.</p>
                    <br />  
                </div>
            </div>
            <div class="loader"></div>
            <div id="backgroundPopup"></div>
            <!--Instruction 1  end-->
            <!--Instruction 2 Start-->
            <div id="instruction_2">   
                <div class="close"></div>
                <span class="ecs_tooltip">Press Esc to close <span class="arrow"></span></span>
                <div id="popup_content"> <!--your content start-->
                    <p style="padding-top: 20px;margin-left: 10px;font-size: 14px;line-height: 1.5;">
                        Please fill out the downloaded form and rename the file so it includes the name the account will be established under. 
                        Use the "Choose File" button to upload the completed form.</p>
                    <br /> 
            </div>
            </div>
            <div class="loader"></div>
            <div id="backgroundPopup"></div>
            <!--Instruction 2  end--> 
            <input style="cursor: pointer;background: #F99B3E;color: #FFF;float: left;padding: 5px 20px;margin-top: 5px;border-radius: 5px;border: 1px;margin-left: 200px;font-weight: bold;" value="Create Customer" type="submit"  name="reg_submit" />
            <input style="cursor: pointer;background: #F99B3E;color: #FFF;float: left;padding: 5px 20px;margin-top: 5px;border-radius: 5px;border: 1px;margin-left: 10px;font-weight: bold;" style="margin-left:25px !important;" value="Reset" type="reset" onclick="document.getElementById('state').disabled = false;"/>
            <div style="clear:both;">&nbsp;</div>
    </div>
</form>
                                            
</td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
            <tr>
                <td style="background:#464646; text-align:center; color:#fff; line-height:30px;" height="30p">© 2013 sohorepro.com</td>
            </tr>
        </table>
    </body>
</html>

<script type="text/javascript">
$(document).ready(function()
    {        
    $(".tax_exc").click(function()
    {
    if (document.getElementById('reg_tax').checked)
    {
        $("#tax_form_1").slideToggle("slow");
    }
    else
    {
        $("#tax_form_1").slideToggle("slow");
    }
    });     
});


function generate_password(len)
{
    var text = "";
    var possible = "abcdefghijklmnopqrstuvwxyz";

    for( var i=0; i < 5; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

  $("#reg_password").val(text);
}
</script>


