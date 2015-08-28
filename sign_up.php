<?php
include './admin/config.php';
include './admin/db_connection.php';

$Super = getSuperCategory();

if(isset($_REQUEST['reg_submit']))
{ 
 //print_r($_REQUEST);
 $fname= mysql_real_escape_string($_POST['reg_fname']);
 $lname= mysql_real_escape_string($_POST['reg_lname']);
 $emailid= mysql_real_escape_string($_POST['reg_email_id']);
 $pass= mysql_real_escape_string($_POST['reg_password']);
 $reg_compname= mysql_real_escape_string($_POST['reg_compname']);
 $reg_contphone= mysql_real_escape_string($_POST['reg_contphone1']);
 $address1= mysql_real_escape_string($_POST['address1']);
 $address2= mysql_real_escape_string($_POST['address2']);
 $reg_busiroom= mysql_real_escape_string($_POST['reg_busiroom']);
 $reg_busisuite= mysql_real_escape_string($_POST['reg_busisuite']);
 $reg_busifloor= mysql_real_escape_string($_POST['reg_busifloor']);
 $reg_busicity= mysql_real_escape_string($_POST['reg_busicity']);
 $state= mysql_real_escape_string($_POST['state']);
 $reg_busizip= mysql_real_escape_string($_POST['reg_busizip']);
 $reg_phone1= mysql_real_escape_string($_POST['reg_phone1']);
 $reg_phone2= mysql_real_escape_string($_POST['reg_phone2']);
 $reg_phone3= mysql_real_escape_string($_POST['reg_phone3']);
 $reg_phone4= mysql_real_escape_string($_POST['reg_phone4']);
 $user_phone= mysql_real_escape_string($_POST['reg_user_phone']);
 $tax= mysql_real_escape_string($_POST['reg_tax']);
 
 $check_user_count = mysql_query("select * from sohorepro_customers where cus_email='".$emailid."' ");
 
 $check_company_count = mysql_query("select * from sohorepro_company where LOWER(comp_name)=LOWER('".$reg_compname."') ");
 

 if(mysql_num_rows($check_user_count)<=0)
 {
 
    if(mysql_num_rows($check_company_count)<=0)
    {
        mysql_query("insert into sohorepro_company(comp_name,comp_contact_phone,comp_business_address1,comp_business_address2,comp_room,comp_suite,comp_floor,comp_city,comp_state,comp_zipcode,comp_phone1,comp_phone2,comp_phone3,comp_phone4) values('$reg_compname','$reg_contphone','$address1','$address2','$reg_busiroom','$reg_busisuite','$reg_busifloor','$reg_busicity','$state','$reg_busizip','$reg_phone1','$reg_phone2','$reg_phone3','$reg_phone4')");
        $company_insertid=  mysql_insert_id();
        $pro = get_spl_prod();
        foreach ($pro as $p)
        {
           $product_id      = $p['sp_product_id'];
           $list_price      = $p['sp_list_price'];
           $discount        = $p['sp_discount'];
           $special_price   = $p['sp_special_price'];

           $query = "INSERT INTO sohorepro_special_pricing SET
                     sp_user_id         = '".$company_insertid."',
                     sp_product_id      = '".$product_id."',
                     sp_list_price      = '".$list_price."',
                     sp_discount        = '".$discount."',
                     sp_special_price   = '".$special_price."'";
                     mysql_query($query); 
        }
    }
    else
    {
        $fth_comp=  mysql_fetch_array($check_company_count);
        $company_insertid=$fth_comp['comp_id'];
    }    
 $check_admin       = checkAdmin($company_insertid);  
 $admin             = (count($check_admin) == 1) ? '0':'1';
 $insert_user       = mysql_query("insert into sohorepro_customers(cus_fname,cus_lname,cus_email,cus_pass,cus_regdate,cus_compname,cus_contact_name,cus_contact_phone,cus_bill_address1,cus_bill_address2,cus_bill_room,cus_bill_suite,cus_bill_floor,cus_bill_city,cus_bill_state,cus_bill_zipcode,cus_phone1,cus_phone2,cus_phone3,cus_phone4,cus_tax_exe,cus_manager,cus_status) values ('$fname','$lname','$emailid','$pass',now(),'$company_insertid','$fname$lname','$user_phone','$address1','$address2','$reg_busiroom','$reg_busisuite','$reg_busifloor','$reg_busicity','$state','$reg_busizip','$reg_phone1','$reg_phone2','$reg_phone3','$reg_phone4','$tax','$admin',1) ");
 $admin_mail        = selectManager($company_insertid);
 if(count($admin_mail) == 1)
 {    
 $Date=date('d-m-Y'); 
 $message = '<link href="mail_css.css" media="screen" rel="stylesheet" type="text/css" />';
 $message .= '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
 $message .= '<table width="550" border="0" cellspacing="0" cellpadding="0">';
 $message .= '<tr bgcolor="#ff7e00">';
 $message .= '<td width="10" height="10" align="left" valign="top"></td>';
 $message .= '<td height="10" align="left" valign="top"></td>';
 $message .= '<td width="10" height="10" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '<tr>';
 $message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
 $message .= '<td align="left" valign="top"><table width="530" border="0" cellspacing="0" cellpadding="0">';
 $message .= '<tr>';
 $message .= '<td width="20" height="20" align="left" valign="top"></td>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '<td width="20" height="20" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '<tr>';
 $message .= '<td width="20" align="left" valign="top"></td>';
 $message .= '<td align="left" valign="top"><table width="490" border="0" cellspacing="0" cellpadding="0">';
 $message .= '<tr>';
 $message .= '<td width="140" align="left" valign="top"><img src="'.$base_url.'/store_files/soho_logo.jpg" width="126" height="115" alt=""/></td>';
 $message .= '<td align="left" valign="top"><table width="200" border="0" cellspacing="0" cellpadding="0">';
 $message .= '<tr>';
 
 $message .= '</table></td>';
 $message .= '</tr>';
 $message .= '</table></td>';
 $message .= '<td width="20" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '<tr>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '<tr>';
 $message .= '<td width="20" align="left" valign="top"></td>';
 $message .= '<td align="left" valign="top">';
 $message .= '<table width="490" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';
 
 $message .="<tr>
 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;'>Dear Admin Manager,</td>
 </tr>";
 $message .="<tr>
 <td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'>You are receiving this email to alert you that staff member, <span style='font-family:Arial, Helvetica, sans-serif;font-weight:bold;'>$fname $lname</span>, established an online account with Soho Reprographics.
If this is not a valid/authorized user, please contact us.</td>
 </tr>";
  
 $message .="<tr><td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444; padding-top:10px;'>Thanks,</td></tr><tr><td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'>The SohoRepro Team</td></tr>";
 
 $message .= '</table></td>';
 $message .= '<td width="20" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '<tr>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= ' </tr>';
 $message .= '</table></td>';
 $message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
 $message .= '</tr>';
 $message .= '<tr bgcolor="#ff7e00">';
 $message .= '<td width="10" height="10" align="left" valign="top"></td>';
 $message .= '<td height="10" align="left" valign="top"></td>';
 $message .= '<td width="10" height="10" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '</table>'; 
 $to        = $admin_mail;
 $subject   = 'SohoRepro - New User Notification';
 $headers   = 'From: "SohoRepro" <no-reply@sohorepro.com>' . "\r\n";
 // Always set content-type when sending HTML email
 $headers  .= "MIME-Version: 1.0" . "\r\n";
 $headers  .= "Content-type:text/html;charset=iso-8859-1" . "\r\n"; 
 mail($to, $subject, $message, $headers); 
 }
 $user_insertid= mysql_insert_id();
 
 $_SESSION['sohorepro_userid']=$user_insertid;
 $_SESSION['sohorepro_username']=$fname." ".$lname;
 
 $Date=date('d-m-Y');
 
 $message = '<link href="mail_css.css" media="screen" rel="stylesheet" type="text/css" />';
 $message .= '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
 $message .= '<table width="550" border="0" cellspacing="0" cellpadding="0">';
 $message .= '<tr bgcolor="#ff7e00">';
 $message .= '<td width="10" height="10" align="left" valign="top"></td>';
 $message .= '<td height="10" align="left" valign="top"></td>';
 $message .= '<td width="10" height="10" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '<tr>';
 $message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
 $message .= '<td align="left" valign="top"><table width="530" border="0" cellspacing="0" cellpadding="0">';
 $message .= '<tr>';
 $message .= '<td width="20" height="20" align="left" valign="top"></td>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '<td width="20" height="20" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '<tr>';
 $message .= '<td width="20" align="left" valign="top"></td>';
 $message .= '<td align="left" valign="top"><table width="490" border="0" cellspacing="0" cellpadding="0">';
 $message .= '<tr>';
 $message .= '<td width="140" align="left" valign="top"><img src="'.$base_url.'/store_files/soho_logo.jpg" width="126" height="115" alt=""/></td>';
 $message .= '<td align="left" valign="top"><table width="200" border="0" cellspacing="0" cellpadding="0">';
 $message .= '<tr>';
 
 $message .= '</table></td>';
 $message .= '</tr>';
 $message .= '</table></td>';
 $message .= '<td width="20" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '<tr>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '<tr>';
 $message .= '<td width="20" align="left" valign="top"></td>';
 $message .= '<td align="left" valign="top">';
 $message .= '<table width="490" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';
 
 $message .="<tr>
 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;'>Dear ".ucfirst($fname." ".$lname).",</td>
 </tr>";
 $message .="<tr>
 <td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'>Thank you for register with us. Please note down the login details below. <span style='color:#0b7abf; text-decoration:underline;'></span></td>
 </tr>";
 
 $message .="<tr>
 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#5f5f5f; font-weight:bold; padding-top:20px;'>Email id : ".($emailid)."</td>
 </tr>";
 
 $message .="<tr>
 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#5f5f5f; font-weight:bold; padding-top:20px; padding-bottom:10px;'>Password : ".$pass."</td>
 </tr>";
 
 $message .="<tr>
 <td height='30' align='left' valign='middle' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'><a href='".$base_url ."/index.php' style='color:#0b7abf; text-decoration:underline;' target='_blank'>Click here </a>to login into our SohoRepro System.</td>
 </tr>";
 
 $message .="<tr><td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444; padding-top:10px;'>Thanks,</td></tr><tr><td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'>The SohoRepro Team</td></tr>";
 
 $message .= '</table></td>';
 $message .= '<td width="20" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '<tr>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= ' </tr>';
 $message .= '</table></td>';
 $message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
 $message .= '</tr>';
 $message .= '<tr bgcolor="#ff7e00">';
 $message .= '<td width="10" height="10" align="left" valign="top"></td>';
 $message .= '<td height="10" align="left" valign="top"></td>';
 $message .= '<td width="10" height="10" align="left" valign="top"></td>';
 $message .= ' </tr>';
 $message .= '</table>';
 
 //echo $message;
 //exit;
 
 
 $to = $emailid;
 $subject = 'SohoRepro - Registration completed';
 $headers = 'From: "SohoRepro" <no-reply@sohorepro.com>' . "\r\n";
 // Always set content-type when sending HTML email
 $headers = "MIME-Version: 1.0" . "\r\n";
 $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
 
 mail($to, $subject, $message, $headers);
 
 header("Location:index.php");
 exit;
 }
 else
 {
 header("Location:sign_up.php?already");
 exit;
 }
}



if(isset($_REQUEST['forgot_submit']))
{ 
 //print_r($_REQUEST);
 $emailid= mysql_real_escape_string($_POST['email_id']);
 
 $check_user_count = mysql_query("select * from sohorepro_customers where cus_email='".$emailid."' ");

 if(mysql_num_rows($check_user_count)>0)
 { 
 $check_fth_user = mysql_fetch_array($check_user_count);
 $message = '<link href="mail_css.css" media="screen" rel="stylesheet" type="text/css" />';
 $message .= '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
 $message .= '<table width="550" border="0" cellspacing="0" cellpadding="0">';
 $message .= '<tr bgcolor="#ff7e00">';
 $message .= '<td width="10" height="10" align="left" valign="top"></td>';
 $message .= '<td height="10" align="left" valign="top"></td>';
 $message .= '<td width="10" height="10" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '<tr>';
 $message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
 $message .= '<td align="left" valign="top"><table width="530" border="0" cellspacing="0" cellpadding="0">';
 $message .= '<tr>';
 $message .= '<td width="20" height="20" align="left" valign="top"></td>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '<td width="20" height="20" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '<tr>';
 $message .= '<td width="20" align="left" valign="top"></td>';
 $message .= '<td align="left" valign="top"><table width="490" border="0" cellspacing="0" cellpadding="0">';
 $message .= '<tr>';
 $message .= '<td width="140" align="left" valign="top"><img src="'.$base_url.'/store_files/soho_logo.jpg" width="126" height="115" alt=""/></td>';
 $message .= '<td align="left" valign="top"><table width="200" border="0" cellspacing="0" cellpadding="0">';
 $message .= '<tr>';
 
 $message .= '</table></td>';
 $message .= '</tr>';
 $message .= '</table></td>';
 $message .= '<td width="20" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '<tr>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '<tr>';
 $message .= '<td width="20" align="left" valign="top"></td>';
 $message .= '<td align="left" valign="top">';
 $message .= '<table width="490" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">';
 
 $message .="<tr>
 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;'>Dear ".ucfirst($check_fth_user['cus_fname']." ".$check_fth_user['cus_lname']).",</td>
 </tr>";
 $message .="<tr>
 <td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'> Please note down the login details for your account. <span style='color:#0b7abf; text-decoration:underline;'></span></td>
 </tr>";
 
 $message .="<tr>
 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#5f5f5f; font-weight:bold; padding-top:20px;'>Email id : ".ucfirst($check_fth_user['cus_email'])."</td>
 </tr>";
 
 $message .="<tr>
 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#5f5f5f; font-weight:bold; padding-top:20px; padding-bottom:10px;'>Password : ".$check_fth_user['cus_pass']."</td>
 </tr>";
 
 $message .="<tr>
 <td height='30' align='left' valign='middle' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'><a href='".$base_url ."/index.php' style='color:#0b7abf; text-decoration:underline;' target='_blank'>Click here </a>to login into our SohoRepro System.</td>
 </tr>";
 
 $message .="<tr><td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444; padding-top:10px;'>Thanks,</td></tr><tr><td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'>The SohoRepro Team</td></tr>";
 
 $message .= '</table></td>';
 $message .= '<td width="20" align="left" valign="top"></td>';
 $message .= '</tr>';
 $message .= '<tr>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= '<td height="20" align="left" valign="top"></td>';
 $message .= ' </tr>';
 $message .= '</table></td>';
 $message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
 $message .= '</tr>';
 $message .= '<tr bgcolor="#ff7e00">';
 $message .= '<td width="10" height="10" align="left" valign="top"></td>';
 $message .= '<td height="10" align="left" valign="top"></td>';
 $message .= '<td width="10" height="10" align="left" valign="top"></td>';
 $message .= ' </tr>';
 $message .= '</table>';
 
 //echo $message;
 // exit;
 
 
 $to = $check_fth_user['cus_email'];
 $subject = 'SohoRepro - Login credentials';
 $headers = 'From: "SohoRepro" <no-reply@sohorepro.com>' . "\r\n";
 // Always set content-type when sending HTML email
 $headers = "MIME-Version: 1.0" . "\r\n";
 $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
 
 mail($to, $subject, $message, $headers);
 
 header("Location:index.php");
 exit;
 }
 else
 {
 header("Location:index.php?err");
 exit;
 }
}




if(isset($_REQUEST['login_submit']))
{ 
 //print_r($_REQUEST);
 //exit;
 $emailid= mysql_real_escape_string($_POST['email_id']);
 $pass= mysql_real_escape_string($_POST['password']);
 $rememberme= mysql_real_escape_string($_POST['rememberme']);
 
 $check_user_count = mysql_query("select * from sohorepro_customers where cus_email='".$emailid."' ");

 if(mysql_num_rows($check_user_count)>0)
 {
 $check_fth_user = mysql_fetch_array($check_user_count);
 $_SESSION['sohorepro_userid']=$check_fth_user['cus_id'];
 $_SESSION['sohorepro_username']=$check_fth_user['cus_fname']." ".$check_fth_user['cus_lname'];
 
 if(isset($_REQUEST['rememberme']) && $rememberme!='')
 {
 setcookie("ck_sohorepro_userid", $check_fth_user['cus_id']);
 setcookie("ck_sohorepro_email", $emailid);
 setcookie("ck_sohorepro_pass", $pass);
 }
 else
 {
 $expire_ck= time()-3600;
 setcookie("ck_sohorepro_userid", "", $expire_ck);
 setcookie("ck_sohorepro_email", "", $expire_ck);
 setcookie("ck_sohorepro_pass", "", $expire_ck);
 }
 
 header("Location:index.php");
 exit;
 }
 else
 {
 header("Location:index.php?err");
 exit;
 }
}


$select_company = mysql_query("select comp_name from sohorepro_company where comp_status=0 ");

$comp_array='';
while($th_company=  mysql_fetch_array($select_company))
{
    $comp_array .= "'".$th_company['comp_name']."' ,";
}

$comp_array=substr($comp_array,0,strlen($comp_array)-1);
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
 <script language="javascript" src="store_files/jquery_003.js"></script> 
 <script language="javascript" src="store_files/ui_002.js"></script> 
 <script language="javascript" src="store_files/jgrowl.js"></script> 
 <script language="javascript" src="store_files/jquery_005.js"></script> 
 <script language="javascript" src="store_files/ajaxLoader.js"></script> 
 <script language="javascript" src="store_files/flexigrid.js"></script> 
 <script language="javascript" src="store_files/maskedinput.js"></script> 
 <script language="javascript" src="store_files/gps.js"></script> 
 <script language="javascript" src="store_files/jquery_004.js"></script> 
 <script language="javascript" src="store_files/ui.js"></script> 
 <script language="javascript" src="store_files/slick_010.js"></script> 
 <script language="javascript" src="store_files/slick_008.js"></script> 
 <script language="javascript" src="store_files/slick_003.js"></script> 
 <script language="javascript" src="store_files/slick.js"></script> 
 <script language="javascript" src="store_files/slick_004.js"></script> 
 <script language="javascript" src="store_files/slick_011.js"></script> 
 <script language="javascript" src="store_files/slick_007.js"></script> 
 <script language="javascript" src="store_files/slick_006.js"></script> 
 <script language="javascript" src="store_files/slick_002.js"></script> 
 <script language="javascript" src="store_files/jquery.js"></script> 
 <script language="javascript" src="store_files/slick_009.js"></script> 
 <script language="javascript" src="store_files/slick_005.js"></script> 
 <script language="javascript" src="store_files/jquery_002.js"></script> 
 <script language="javascript" src="store_files/sohorepro.js"></script> 
 <script language="javascript" src="store_files/kendo.js"></script> 
 <script language="javascript" src="store_files/script.js"></script> 
 <script language="javascript" src="store_files/storecart.js"></script> 
 <script language="javascript" src="store_files/interface.js"></script> 



 <script type="text/javascript" src="store_files/scripts.js"></script>
 

 <link rel="shortcut icon" href="http://soho.thinkdesign.com/favicon.ico" type="image/x-icon">
 <link rel="stylesheet" type="text/css" href="store_files/style_layout.css">
 <!--[if IE 7]>
 <link rel="stylesheet" type="text/css" href="css/ie_7_hacks.css" />
 <![endif]-->
<link href="style/popup_style.css" rel="stylesheet" type="text/css" media="all" />
<script src="store_files/jquery.min.js"></script>
<script type="text/javascript" src="js/popup_script.js"></script>
 

<!-- Validation script starts here -->

<style type="text/css">
 label.error{
 color: red !important;
 
 }
 input.error,select.error,textArea.error{
 border: 1px solid red !important;
 }
</style>
<script src="js/jquery.js" type="text/javascript" ></script>
<script src="js/jquery.validate.js" type="text/javascript" ></script>
<script src="js/jquery.maskedinput.js" type="text/javascript" ></script>


<script type="text/javascript">

 $(document).ready(function() { 
 

 
 var validation_obj = {
 rules: {email_id:{
 
 required:true,
 email:true
 } },
 messages: {
 email_id: {
 required: '',
 email:true
 },
 password : {
 required: ''
 
 }
 
 }
 };
 
 
 $("#login_form").validate(validation_obj);
 
 
 var validation_forgot = {
 rules: {email_id:{
 
 required:true,
 email:true
 } },
 messages: {
 email_id: {
 required: '',
 email:true
 }
 
 }
 };
 
 
 $("#forgot_form").validate(validation_forgot);
 
 
 
 var validation_reg = {
 rules: {reg_email_id:{
 
 required:true,
 email:true
 },
 reg_password:{
 
 required:true,
 rangelength: [6, 15]
 } },
 messages: {
 reg_fname : {
 required: ''
 
 },
 reg_lname : {
 required: ''
 
 },
 reg_email_id: {
 required: '',
 email:true
 },
 reg_password : {
 required: ''
 
 },
 reg_cpassword : {
 required: ''
 
 },
 reg_compname : {
 required: ''
 
 },
 reg_contphone1 : {
 required: ''
 
 },
 address1 : {
 required: ''
 
 },
 address2 : {
 required: ''
 
 },
 reg_busiroom : {
 required: ''
 
 },
 reg_busisuite : {
 required: ''
 
 },
 reg_busifloor : {
 required: ''
 
 },
 reg_busicity : {
 required: ''
 
 },
 reg_busistate : {
 required: ''
 
 },
 reg_busizip : {
 required: ''
 
 }
 
 }
 };
 
 
 $("#reg_form").validate(validation_reg);
 
 });
 
 jQuery(function($){
 $("#reg_contphone").mask("999-999-9999");
 $("#reg_contphone1").mask("999-999-9999");
 $("#reg_phone1").mask("999-999-9999");
 $("#reg_phone2").mask("999-999-9999");
 $("#reg_phone3").mask("999-999-9999");
 $("#reg_phone4").mask("999-999-9999");
 $("#reg_user_phone").mask("999-999-9999x999");        
 $("#reg_busizip").mask("99999");
 });
 
 
 function show_reg(str)
 {
 if(str==0)
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
 if(str==0)
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
 
 
 function change_txt(tid,val)
 {
 var txt_val=$(tid).val();
 //alert(txt_val);
 if(txt_val==val)
 {
 $(tid).val('');
 }
 }
 
 function change_dtxt(tid,val)
 {
 var txt_val=$(tid).val();
 //alert(txt_val);
 
 if(txt_val=='')
 {
 $(tid).val('');
 }
 }
 
</script>
<!-- Validation script ends here --> 

<!-- Auto complete script start here --> 

 <script>
  /*$(function() {
    var availableTags = [<?php echo $comp_array; ?>];
    $( "#reg_compname" ).autocomplete({
      source: availableTags
    });
  });*/
  
  function load_companyinfo()
        {      	
        var cname = $( "#reg_contphone" ).val();
        
        if(cname=='')
            {
                $('.comp_det_view').prop('readonly', false);
                $(".comp_det_view").val("");
                $('#state').removeAttr("disabled");
                $("#reg_contphone").mask("999-999-9999");
                $("#reg_contphone1").mask("999-999-9999");
                $("#reg_phone1").mask("999-999-9999");
                $("#reg_phone2").mask("999-999-9999");
                $("#reg_phone3").mask("999-999-9999");
                $("#reg_phone4").mask("999-999-9999");
                $("#reg_user_phone").mask("999-999-9999x999");        
                $("#reg_busizip").mask("99999");
                $( "#reg_contphone" ).autocomplete({ disabled: true });
            }
        var request = $.ajax({
          url: "load_company_phone.php",
          type: "POST",
          data: { cid : cname },
          dataType: "html"
        });

        request.done(function( msg ) {
          //alert( msg );
          if(msg!='')
              {
                var $newcomp_arr;
                $newcomp_arr=msg.split('^^^^');
                $('.comp_det_view').attr('readonly', true);
                $('#state').prop('disabled', true);
                $("#reg_compname").val($newcomp_arr['0']);
                $("#reg_contphone1").val($newcomp_arr['1']);
                $("#address1").val($newcomp_arr['2']);
                $("#address2").val($newcomp_arr['3']);
                $("#reg_busiroom").val($newcomp_arr['4']);
                $("#reg_busisuite").val($newcomp_arr['5']);
                $("#reg_busifloor").val($newcomp_arr['6']);
                $("#reg_busicity").val($newcomp_arr['7']);
                $("#state_val").val($newcomp_arr['8']);
                $("#state_val").css("display","inline-block"); 
                $("#state").css("display","none"); 
                $("#reg_busizip").val($newcomp_arr['9']);
                $("#reg_phone1").val($newcomp_arr['10']);
                $("#reg_phone2").val($newcomp_arr['11']);
                $("#reg_phone3").val($newcomp_arr['12']);
                $("#reg_phone4").val($newcomp_arr['13']);
                if($newcomp_arr['14'] == '1'){
                $("#reg_tax").css("display","none");
                $("#reg_tax_val").css("display","inline-block");                
                }else{                  
                $("#reg_tax").css("display","none");
                $("#reg_tax_null").css("display","inline-block");                 
                }
                $(".comp_det_view").unmask();
              }
              else
              {
                $('.comp_det_view').prop('readonly', false);
                $(".comp_det_view").val("");
                $('#state').removeAttr("disabled");
                $("#reg_contphone").mask("999-999-9999");
                $("#reg_contphone1").mask("999-999-9999");
                $("#reg_phone1").mask("999-999-9999");
                $("#reg_phone2").mask("999-999-9999");
                $("#reg_phone3").mask("999-999-9999");
                $("#reg_phone4").mask("999-999-9999");
                $("#reg_user_phone").mask("999-999-9999x999");        
                $("#reg_busizip").mask("99999");
              }
        });

        request.fail(function( jqXHR, textStatus ) {
                $('.comp_det_view').prop('readonly', false);
                $(".comp_det_view").val("");
                $('#state').removeAttr("disabled");
                $("#reg_contphone").mask("999-999-9999");
                $("#reg_contphone1").mask("999-999-9999");
                $("#reg_phone1").mask("999-999-9999");
                $("#reg_phone2").mask("999-999-9999");
                $("#reg_phone3").mask("999-999-9999");
                $("#reg_phone4").mask("999-999-9999");
                $("#reg_user_phone").mask("999-999-9999x999");                
                $("#reg_busizip").mask("99999");
        });
    
  }
  
  function move_nextfield(str,currpos)
  {
        var cphone1 = $( "#"+str ).val();
        //alert(cphone1.length);
        if(cphone1.length==12 && cphone1.indexOf('_') == -1)
        {
        if(currpos!='4')
            {
            var newstr="#"+str.replace(currpos, parseInt(currpos)+1);
            //alert(newstr);
            $(newstr).focus();
            }
        }
  }

  </script>
 
 <!-- Auto complete script ends here --> 
 
 </head>
 <body>
 <div id="body_container">
 <div id="body_content" class="body_wrapper">
 <div id="body_content-inner" class="body_wrapper-inner">

<?php include "includes/header_sidebar.php"; ?>
 
 <div id="content_output">

<?php include "includes/top_nav.php"; ?>
 
 <div id="content_output-data" style="margin-bottom:20px;">


 <script type="text/javascript" src="store_files/script.html"></script>
 <script>
 $(document).ready(function() {
 $('.continute_service_shopping_link').click(function() {

 var value = $('#redirect_to').val();
 //alert(value);

 $('#supplystoreform').append('<input type="hidden" value="' + value + '" name="redirect_to" />');
 $('#supplystoreform').submit();

 /* $('#supplystoreform').submit(function(e){
 alert("Submitted");
 }); */

 });
 $('.addstroeproductActionLink').click(function() {
 //alert('hello');

 setInterval(function() {
 if ($('#action').val() == "pp") {
 $('#store').submit();
 }
 }, 250);

 $.post("user/checksignin", function(data) {
 var obj = jQuery.parseJSON(data);
 //console.log(obj.u_id);
 if (obj.u_id != 'unlogged') {
 $('#action').val() == "pp";
 $('#store').submit();
 } else {
 //alert('kk');
 $.post("view/supplystore", $("#store").serialize());
 var url = 'user/signin';
 var holderID = Math.floor(Math.random() * 1000001) + '_dialog';
 //console.log(holderID);
 $('#dynamicAppender').append('<div id="' + holderID + '" class="sdialog-Box"></div>');
 $('#' + holderID).load(url, function() {
 $(".ui-dialog:hidden, .ui-dialog:hidden div").remove();
 $("#" + holderID).dialog("destroy");
 $("#" + holderID).dialog({
 height: 284,
 modal: true,
 width: 348,
 resizable: false
 });
 $(".ui-dialog-content").css({'background-color': '#F9F2DE', 'box-shadow': 'none'});
 $("div.ui-dialog").css('box-shadow', 'none');
 $(".ui-dialog-titlebar").hide();
 $(".ui-widget-content").css('border', 'none');
 $("img#closeit").click(function() {
 $(".sdialog-Box").dialog('close');
 });


 /////new-s/////

 $("#registering").click(function() {
 var url = 'user/userregister';
 var holderID = Math.floor(Math.random() * 1000001) + '_dialog';
 $('#dynamicAppender').append('<div id="' + holderID + '" class="rdialog-Box"></div>');
 $('#' + holderID).load(url, function() {
 $(".ui-dialog:hidden, .ui-dialog:hidden div").remove();
 $("#" + holderID).dialog("destroy");
 $("#" + holderID).dialog({
 height: 415,
 modal: true,
 width: 350,
 resizable: false
 });
 $(".ui-dialog-content").css({'background-color': '#F9F2DE', 'box-shadow': 'none'});
 $("div.ui-dialog").css('box-shadow', 'none');
 $(".ui-dialog-titlebar").hide();
 $(".ui-widget-content").css('border', 'none');
 $("img#closeit").click(function() {
 $(".rdialog-Box").dialog('close');
 });

 $("#registering").click(function() {

 });

 });

 $(".sdialog-Box").dialog('close');
 return false;
 });

 /////new-e/////
 });


 }


 });

 return false;
 });
 return false;
 });

 </script>

 
 <style type="text/css">
 .label_regview
 {
 width: 120px;
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
 </style>
 

 <form id="reg_form" name="reg_form" action="" method="post" onsubmit="return validate()">
 <input type="hidden" name="order_val" value="1" id="order_val" /> 
 <h2 class="headline-interior orange">SIGN UP </h2>
 <div class="bkgd-stripes-orange">&nbsp;</div>
 <h2 style="color: #5C5C5C;">Do you have an account with us? If so, please search by phone number</h2>
 
 <div class="label_regview" style="width:500px; margin-top: 10px; margin-bottom: 15px; padding-left: 150px;" align="center">
     <h2 style="float:left; color: #5C5C5C;">Phone number : </h2><input intvalue="Contact phone" class="reginput" style="width: 220px; height: 18px; font-size: 18px; border:4px solid #FF9000;" name="reg_contphone" id="reg_contphone" type="text" placeholder="Search Phone number" onblur="load_companyinfo();" /></div> 
         
 <div class="reg_head" style="clear: both;">
 Personal Information : 
 </div> 
 <div style="width:700px; margin-left: 50px;"> 
 <div class="label_regview"> First Name :</div> 
 <input intvalue="Name" class="required reginput" name="reg_fname" id="reg_fname" type="text" placeholder="First Name"/> 
 
 <div class="label_regview"> Last Name :</div> 
 <input intvalue="Name" class="required reginput" name="reg_lname" id="reg_lname" type="text" placeholder="Last Name"/> 
 
 <div class="label_regview"> Email ID :</div>
 <input intvalue="Email Address" class="required reginput" name="reg_email_id" id="reg_email_id" type="text" placeholder="Email Address"/>
 
 <div class="label_regview"> Phone :</div>
 <input intvalue="User Phone" class="required reginput" name="reg_user_phone" id="reg_user_phone" type="text" placeholder="Phone"/>

 <div class="label_regview"> Password :</div>
 <input intvalue="Password" class="required reginput" name="reg_password" id="reg_password" type="password" placeholder="Password (6-15 characters)"/>
 
 <div class="label_regview"> Retype Password :</div> 
 <input intvalue="Password" equalto="#reg_password" class="required reginput"  name="reg_cpassword" id="reg_cpassword" type="password" placeholder="Confirm Password"/><br/>
 </div>
 <div class="reg_head" style="clear:both;">
 Billing information : 
 </div>   
 
 <div style="width:700px; margin-left: 50px; margin-top: 10px; clear: both;">      
     
 <div class="label_regview"> Company name :</div> 
 <input intvalue="Company name" class="required reginput comp_det_view" name="reg_compname" id="reg_compname" type="text" placeholder="Company name" />
 
 <div class="label_regview"> Company phone :</div> 
 <input intvalue="Contact phone" class="required reginput comp_det_view" name="reg_contphone1" id="reg_contphone1" type="text" placeholder="Phone number"/>
 

 
 <div class="label_regview"> Business address1 :</div> 
 <textarea class="reginput comp_det_view" name="address1" id="address1" placeholder="Address details"></textarea>
 
 <div class="label_regview"> Business address2 :</div> 
 <textarea class="reginput comp_det_view" name="address2" id="address2" placeholder="Address details"></textarea>
 
 <div class="label_regview"> Room :</div> 
 <input intvalue="Room" class="reginput comp_det_view" name="reg_busiroom" id="reg_busiroom" type="text" placeholder="Room"/>
 
 <div class="label_regview"> Suite :</div> 
 <input intvalue="Suite" class="reginput comp_det_view" name="reg_busisuite" id="reg_busisuite" type="text" placeholder="Suite"/>
 
 <div class="label_regview"> Floor :</div> 
 <input intvalue="Floor" class="reginput comp_det_view" name="reg_busifloor" id="reg_busifloor" type="text" placeholder="Floor"/>
 
 <div class="label_regview"> City :</div> 
 <input intvalue="City" class="required reginput comp_det_view" name="reg_busicity" id="reg_busicity" type="text" placeholder="City name"/>
 
 <div class="label_regview"> State :</div>
 <select name="state" id="state" class="required reginput comp_det_view" style="width: 175px !important;">
 <option value="">Select state</option>
 <?php $sel_state=mysql_query("select * from sohorepro_states");
 while($fth_states= mysql_fetch_array($sel_state)) {
 ?>
 <option value="<?php echo $fth_states['state_id']; ?>"><?php echo $fth_states['state_name']; ?></option>
 <?php } ?>
 </select>
 <input intvalue="state_val" style="display: none;" class="required reginput comp_det_view" name="state_val" id="state_val" type="text" placeholder="state"/>
 <div class="label_regview"> Zip :</div> 
 <input intvalue="Zip" class="required reginput comp_det_view" name="reg_busizip" id="reg_busizip" type="text" placeholder="Zip code"/>
 
 
 <div class="label_regview" style="clear:both;"> Phone 1 :</div> 
 <input intvalue="Phone 1" class="reginput comp_det_view" name="reg_phone1" id="reg_phone1" type="text" placeholder="Phone 1" onkeydown="move_nextfield(this.id,1);"/>
 
 <div class="label_regview"> Phone 2 :</div> 
 <input intvalue="Phone 2" class="reginput comp_det_view"  name="reg_phone2" id="reg_phone2" type="text" placeholder="Phone 2" onkeydown="move_nextfield(this.id,2);"/>
 
 <div class="label_regview" style="clear:both;"> Phone 3 :</div> 
 <input intvalue="Phone 3" class="reginput comp_det_view"  name="reg_phone3" id="reg_phone3" type="text" placeholder="Phone 3" onkeydown="move_nextfield(this.id,3);"/>
 
 <div class="label_regview"> Phone 4 :</div> 
 <input intvalue="Phone 4" class="reginput comp_det_view"  name="reg_phone4" id="reg_phone4" type="text" placeholder="Phone 4" onkeydown="move_nextfield(this.id,4);"/>
 
 <div class="label_regview"> Tax Exemption :</div> 
 <input intvalue="Tax" class="reginput comp_det_view tax_exc"  name="reg_tax" id="reg_tax" type="checkbox" placeholder="Tax" value="1"/>
 <input intvalue="Tax" style="display: none;" class="reginput comp_det_view" disabled="disabled"  name="reg_tax_val" id="reg_tax_val" type="checkbox" checked="checked" placeholder="Tax" value="1"/> 
 <input intvalue="Tax" style="display: none;" class="reginput comp_det_view" disabled="disabled"  name="reg_tax_null" id="reg_tax_null" type="checkbox" placeholder="Tax" value="0"/> 
 <div style="clear: both;"></div>
 <div id="tax_form_1" style="display: none;">
     <table width="600" border="0" cellspacing="0" cellpadding="0" class="resale_table" >
        <tr>
            <td align="center" valign="middle">
                Resale Certificate&nbsp;&nbsp;<a href="download.php?file=st120_fill_in.pdf">Download Form</a></br>
                <a href="#" class="instruction_1">View Instructions</a>
            </td>
            <td align="center" valign="middle">
                Exempt Use Certificate&nbsp;&nbsp;<a href="download.php?file=st121_fill_in.pdf">Download Form</a></br>
                <a href="#" class="instruction_2">View Instructions</a>
            </td>
        </tr>
        <tr>
            <td align="center" colspan="2" style="border-top: 1px solid #ddd;" valign="middle">Upload the filled form: <input type="file" name="exempt_form" id="exempt_form"/></td>            
        </tr>
    </table>     
 </div>
 
  <!--Instruction 1 Start-->
    <div id="instruction_1">    	
        <div class="close"></div>
       	<span class="ecs_tooltip">Press Esc to close <span class="arrow"></span></span>
            <div id="popup_content"> <!--your content start-->
                <p>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                has been the industry's standard dummy text ever since the 1500s, when an unknown printer
                took a galley of type and scrambled it to make a type specimen book. It has survived not 
                only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
                It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
                and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. </p>
                <br />
                <p>
                Donec eu libero sit amet quam egestas semper. Aenean ultricies mi 
                vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, 
                commodo Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. </p>                
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
                <p>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                has been the industry's standard dummy text ever since the 1500s, when an unknown printer
                took a galley of type and scrambled it to make a type specimen book. It has survived not 
                only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
                It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
                and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. </p>
                <br />
                <p>
                Donec eu libero sit amet quam egestas semper. Aenean ultricies mi 
                vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, 
                commodo Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. </p>               
            </div>
    </div>
        <div class="loader"></div>
   	<div id="backgroundPopup"></div>
  <!--Instruction 2  end--> 
 
  
 <input class="reg_submit" value="Sign up" type="submit"  name="reg_submit" />

 <input class="reg_submit" style="margin-left:25px !important;" value="Reset" type="reset" onclick="document.getElementById('state').disabled=false;"/>
 
 <div style="clear:both;">&nbsp;</div>
 
 </div>
 
 
 
 </form>


 <script type="text/javascript">
 $(document).ready(function()
 {
 $(".ui-autocomplete-input").keyup(function()
 {
 var check = $(this).val;
 if (check != '')
 {
 //alert(check);
 $('.addstroeproductActionLink').attr('disabled', false);
 } else {
 $('.addstroeproductActionLink').attr('disabled', true);
 }
 });
 
 
 
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

 function validate()
 {
 if (document.getElementById('jobref').value == '')
 {
 alert("Please enter the job reference number");
 document.getElementById('jobref').focus;
 return false;
 } 
 return true;
 }




 </script>
 <!--<div class="bkgd-stripes-orange">&nbsp;</div>-->
 
 <!--<div style="margin-bottom:0;" class="bkgd-stripes-orange">&nbsp;</div>-->
 <div style="clear:both;"></div>

 
 <!--</form> -->
 <div style="clear:both;"></div>

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






 <div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all ui-helper-hidden-accessible"></div><ul style="z-index: 4; top: 0px; left: 0px; display: none;" aria-activedescendant="ui-active-menuitem" role="listbox" class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all"></ul></body>
 <!-- Mirrored from buckart.com/srsite/SoHoRepro-WebsitePages/store/store.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 21 Sep 2013 08:45:26 GMT -->
 </html>


<script type="text/javascript" src="js/jquery.autocomplete.js"></script>
<link rel="stylesheet" href="js/jquery.autocomplete.css" type="text/css" />
        
<script type="text/javascript">
  function findValue(li) {
  	if( li == null ) return alert("No match!");

  	// if coming from an AJAX call, let's use the CityId as the value
  	if( !!li.extra ) var sValue = li.extra[0];

  	// otherwise, let's just display the value in the text box
  	else var sValue = li.selectValue;

  	//alert("The value you selected was: " + sValue);
  }

  function selectItem(li) {
    	findValue(li);
  }

  function formatItem(row) {
    	return row[0];
  }

  function lookupAjax(){
  	var oSuggest = $("#reg_compname")[0].autocompleter;
    oSuggest.findValue();
  	return false;
  }
   
  
 /*   $("#reg_compname").autocomplete(
      "load_company.php",
      {
  			delay:5,
  			minChars:5,
  			matchSubset:1,
  			matchContains:1,
  			cacheLength:10,
  			onItemSelect:selectItem,
  			onFindValue:findValue,
  			formatItem:formatItem,
  			autoFill:true
  		}
    );
    
    */

$( "#reg_contphone" ).keypress(function() {
 
 var phoneval=$( "#reg_contphone" ).val();
 //var test=phoneval.indexOf('_');
 //console.log( test );
if(phoneval.length==12 && (phoneval.indexOf('_') == 10 || phoneval.indexOf('_') == -1))
{    
//alert(phoneval.length);    
//console.log( phoneval.length );
$("#reg_contphone").autocomplete(
      "load_company_phone.php",
      {
  			delay:5,
  			minChars:5,
  			matchSubset:1,
  			matchContains:1,
  			cacheLength:10,
  			onItemSelect:selectItem,
  			onFindValue:findValue,
  			formatItem:formatItem,
  			autoFill:true
  		}
    );
}
else
    {
        $('#reg_contphone').attr('autocomplete','off');
        //$('#error_alert').html('Company not found.'); 
    }
    
});

  
</script>