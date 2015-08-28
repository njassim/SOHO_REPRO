<?php
include './admin/config.php';
include './admin/db_connection.php';

$Super = getSuperCategory();

if(isset($_REQUEST['reg_submit']))
{        
    //print_r($_REQUEST);
    $name=  mysql_real_escape_string($_POST['reg_name']);
    $emailid=  mysql_real_escape_string($_POST['reg_email_id']);
    $pass=  mysql_real_escape_string($_POST['reg_password']);
    $reg_compname=  mysql_real_escape_string($_POST['reg_compname']);
    $reg_contname=  mysql_real_escape_string($_POST['reg_contname']);
    $reg_contemail=  mysql_real_escape_string($_POST['reg_contemail']);
    $reg_contphone=  mysql_real_escape_string($_POST['reg_contphone']);
    $address1=  mysql_real_escape_string($_POST['address1']);
    $address2=  mysql_real_escape_string($_POST['address2']);
    $reg_busiroom=  mysql_real_escape_string($_POST['reg_busiroom']);
    $reg_busisuite=  mysql_real_escape_string($_POST['reg_busisuite']);
    $reg_busifloor=  mysql_real_escape_string($_POST['reg_busifloor']);
    $reg_busicity=  mysql_real_escape_string($_POST['reg_busicity']);
    $state=  mysql_real_escape_string($_POST['state']);
    $reg_busizip=  mysql_real_escape_string($_POST['reg_busizip']);
    
    $check_user_count = mysql_query("select * from sohorepro_customers where cus_email='".$emailid."' ");

    if(mysql_num_rows($check_user_count)<=0)
    {
        $insert_user = mysql_query("insert into sohorepro_customers(cus_name,cus_email,cus_pass,cus_regdate,cus_compname,cus_contact_name,cus_contact_email,cus_contact_phone,cus_bill_address1,cus_bill_address2,cus_bill_room,cus_bill_suite,cus_bill_floor,cus_bill_city,cus_bill_state,cus_bill_zipcode) values ('$name','$emailid','$pass',now(),'$reg_compname','$reg_contname','$reg_contemail','$reg_contphone','$address1','$address2','$reg_busiroom','$reg_busisuite','$reg_busifloor','$reg_busicity','$state','$reg_busizip') ");
        
        $user_insertid=  mysql_insert_id();
        
        $_SESSION['sohorepro_userid']=$user_insertid;
        $_SESSION['sohorepro_username']=$name;
        
        $Date=date('d-m-Y');
        
        $message  = '<link href="mail_css.css" media="screen" rel="stylesheet" type="text/css" />';
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
        $message .= '<td width="140" align="left" valign="top"><img src="'.$base_url.'/store_files/soho_logo.jpg" width="126" height="115"  alt=""/></td>';
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
                 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;'>Dear ".ucfirst($name).",</td>
               </tr>";
        $message .="<tr>
                 <td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#444444'>Thank you for register with us. Please note down the login details below. <span style='color:#0b7abf; text-decoration:underline;'></span></td>
               </tr>";
        
        $message .="<tr>
                 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#5f5f5f; font-weight:bold; padding-top:20px;'>Email id : ".ucfirst($emailid)."</td>
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
         
         	
         $to      = $emailid;
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
    $emailid=  mysql_real_escape_string($_POST['email_id']);
    
    $check_user_count = mysql_query("select * from sohorepro_customers where cus_email='".$emailid."' ");

    if(mysql_num_rows($check_user_count)>0)
    {       
        $check_fth_user = mysql_fetch_array($check_user_count);
        $message  = '<link href="mail_css.css" media="screen" rel="stylesheet" type="text/css" />';
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
        $message .= '<td width="140" align="left" valign="top"><img src="'.$base_url.'/store_files/soho_logo.jpg" width="126" height="115"  alt=""/></td>';
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
                 <td height='25' align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#ff7e00; font-weight:bold;'>Dear ".ucfirst($check_fth_user['cus_name']).",</td>
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
         
         	
         $to      = $check_fth_user['cus_email'];
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
    $emailid=  mysql_real_escape_string($_POST['email_id']);
    $pass=  mysql_real_escape_string($_POST['password']);
    $rememberme=  mysql_real_escape_string($_POST['rememberme']);
    
    $check_user_count = mysql_query("select * from sohorepro_customers where cus_email='".$emailid."' ");

    if(mysql_num_rows($check_user_count)>0)
    {
        $check_fth_user = mysql_fetch_array($check_user_count);
        $_SESSION['sohorepro_userid']=$check_fth_user['cus_id'];
        $_SESSION['sohorepro_username']=$check_fth_user['cus_name'];
        
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
                                                                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
                                                        <script>
                                                            $(document).ready(function(){
                                                             $(".super_cat").click(function(){
                                                                 $(this).next(".sub_cat").toggle().siblings(".sub_cat").hide();
                                                               
                                                             });
                                                           });    
                                                            
                                                        </script>

                                                        <link rel="shortcut icon" href="http://soho.thinkdesign.com/favicon.ico" type="image/x-icon">
                                                            <link rel="stylesheet" type="text/css" href="store_files/style_layout.css">
                                                                <!--[if IE 7]>
                                                                <link rel="stylesheet" type="text/css" href="css/ie_7_hacks.css" />
                                                                <![endif]-->
                                                                <script type="text/javascript" charset="utf-8">

                                                                </script>
                                                                

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
        	        	  

        	  
        	 var validation_obj =  {
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
                
                
                var validation_forgot =  {
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
                
                
                
                var validation_reg =  {
            	  rules: {reg_email_id:{
         	        	  
         	        	  required:true,
         	        	  email:true
         	          },
                          reg_password:{
         	        	  
         	        	  required:true,
         	        	  rangelength: [6, 8]
         	          },
                          reg_contemail:{
         	        	  
         	        	  required:true,
         	        	  email:true
         	          }  },
          		messages: {
        			reg_name : {
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
        			reg_contname : {
        				required: ''
        				
                                },
        			reg_contemail : {
        				required: '',
                                        email:true
        				
                                },
        			reg_contphone : {
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
          $("#reg_contphone").mask("(999) 999-9999");
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

                                                                                                                                /*  $('#supplystoreform').submit(function(e){
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
<?php
$sql_order_id = mysql_query("SELECT order_number FROM sohorepro_order_master ORDER BY id DESC LIMIT 1");
$object = mysql_fetch_assoc($sql_order_id);

if (count($object['order_number']) > 0) {
    $order_id = ($object['order_number'] + 1);
} 
else{
    $order_id = '100';
}

if ($_REQUEST['order_val'] == '1') {   
  
    $job_ref = $_REQUEST['jobref'];
    $sql = "INSERT INTO sohorepro_order_master SET order_number = '".$order_id."', order_id     = '" . $job_ref . "', created_date = now()";
    mysql_query($sql);


    $order_id_pro = mysql_insert_id();
    for ($i = 0; $i < count($_REQUEST['product_id']); $i++) {
        if ($_REQUEST['quantity'][$i] != '') {

            $query = "INSERT INTO sohorepro_product_master SET product_id     = '" . $_REQUEST['product_id'][$i] . "', product_price = '" . $_REQUEST['price'][$i] . "', product_quantity = '" . $_REQUEST['quantity'][$i] . "', product_name = '".$_REQUEST['product_name'][$i]."', order_id = '" .$order_id_pro. "'";
            $result = mysql_query($query);
            if ($result) {
                $result = "success";
            } else {
                $result = "failure";
            }
        }
    }
}
?>

                                                                                                                    
<?php
if ($result == "success") {
    ?>
    <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Your order is placing</div>
    <script>setTimeout("location.href=\'get_order.php\'", 1000);</script>
    <?php
} elseif ($result == "failure") {
    ?>
    <div style="color:#F00; text-align:center; padding-bottom:10px;">Your order is not placing</div>
    <script>setTimeout("location.href=\'get_order.php\'", 1000);</script>       
    <?php
}
?>
    
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
    </style>

                                                                                                                    <form id="reg_form" name="reg_form" action="" method="post" onsubmit="return validate()">
                                                                                                                        <input type="hidden" name="order_val" value="1" id="order_val" /> 
                                                                                                                        <h2 class="headline-interior orange">SIGN UP     </h2>
                                                                                                                        <div class="bkgd-stripes-orange">&nbsp;</div>
                                                                                                                        
   <div class="reg_head">
       Personal infomation : 
   </div>                                                                                                                     
             <div style="width:700px; margin-left: 50px;"> 
             <div class="label_regview"> Name :</div>          
             <input intvalue="Name" class="required reginput" name="reg_name" id="reg_name" type="text" placeholder="Full Name"/>  
             
             <div class="label_regview"> Email ID :</div>
             <input intvalue="Email Address" class="required reginput" name="reg_email_id" id="reg_email_id" type="text" placeholder="Email Address"/>
             
             <div class="label_regview"> Password :</div>
             <input intvalue="Password" class="required reginput" style="font-style:italic;" name="reg_password" id="reg_password" type="password"  placeholder="Password"/>
             
             <div class="label_regview"> Retype Password :</div>             
             <input intvalue="Password" equalto="#reg_password" class="required reginput" style="font-style:italic;" name="reg_cpassword" id="reg_cpassword" type="password"  placeholder="Confirm Password"/><br/>
             </div>
    <div class="reg_head">
       Billing infomation : 
   </div>    
             <div style="width:700px; margin-left: 50px; margin-top: 5px;">                                                                                                                
             <div class="label_regview"> Company name :</div>             
             <input intvalue="Company name" class="required reginput" style="font-style:italic;" name="reg_compname" id="reg_compname" type="text"  placeholder="Company name"/>
             
             <div class="label_regview"> Contact name :</div>             
             <input intvalue="Contact name" class="required reginput" style="font-style:italic;" name="reg_contname" id="reg_contname" type="text"  placeholder="Contact name"/>
             
             <div class="label_regview"> Contact emailid :</div>             
             <input intvalue="Contact emailid" class="required reginput" style="font-style:italic;" name="reg_contemail" id="reg_contemail" type="text"  placeholder="Email address"/>
             
             <div class="label_regview"> Contact phone :</div>             
             <input intvalue="Contact phone" class="required reginput" style="font-style:italic;" name="reg_contphone" id="reg_contphone" type="text"  placeholder="Phone number"/>
             
             <div class="label_regview"> Business address1 :</div>             
             <textarea class="required reginput" style="font-style:italic;" name="address1" id="address1" placeholder="Address details"></textarea>
             
             <div class="label_regview"> Business address2 :</div>             
             <textarea class="required reginput" style="font-style:italic;" name="address2" id="address2" placeholder="Address details"></textarea>
             
             <div class="label_regview"> Room :</div>             
             <input intvalue="Room" class="required reginput" style="font-style:italic;" name="reg_busiroom" id="reg_busiroom" type="text"  placeholder="Room"/>
             
             <div class="label_regview"> Suite :</div>             
             <input intvalue="Suite" class="required reginput" style="font-style:italic;" name="reg_busisuite" id="reg_busisuite" type="text"  placeholder="Suite"/>
             
             <div class="label_regview"> Floor :</div>             
             <input intvalue="Floor" class="required reginput" style="font-style:italic;" name="reg_busifloor" id="reg_busifloor" type="text"  placeholder="Floor"/>
             
             <div class="label_regview"> City :</div>             
             <input intvalue="City" class="required reginput" style="font-style:italic;" name="reg_busicity" id="reg_busicity" type="text"  placeholder="City name"/>
             
             <div class="label_regview"> State :</div>
             <select name="state" id="state" class="required reginput" style="width: 175px !important;">
                 <option value="">Select state</option>
                 <?php $sel_state=mysql_query("select * from sohorepro_states");
                 while($fth_states=  mysql_fetch_array($sel_state)) {
                 ?>
                 <option value="<?php echo $fth_states['state_id']; ?>"><?php echo $fth_states['state_name']; ?></option>
                 <?php } ?>
             </select>
             
             <div class="label_regview"> Zip :</div>             
             <input intvalue="Zip" class="required reginput" style="font-style:italic;" name="reg_busizip" id="reg_busizip" type="text"  placeholder="Zip code"/>
             
             <div style="clear: both;"></div>

            <input class="reg_submit" value="Sign up" type="submit" name="reg_submit" />

            <input class="reg_submit" style="margin-left:25px !important;" value="Reset" type="reset"/>
    
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


