<?php
include './admin/config.php';
include './admin/db_connection.php';
$id         = $_GET['id'];
$state_id   = $_GET['state_id'];
$_SESSION['job'] = $_REQUEST['jobref'];
$_SESSION['qty'] = $_REQUEST['quantity'];
$user_id = $_SESSION['sohorepro_userid'];
$id_user = $_SESSION['sohorepro_companyid'];

$updated_address = UpdatedAddress($id);
$user_manager    = CheckManager($user_id);
$mail_ids        = CompanyMember($id_user);
$comp_name       = companyName($id_user);
$phone           = companyphone($id_user); 
$state_abbr      = StateName($state_id); 


$message  = '<link href="mail_css.css" media="screen" rel="stylesheet" type="text/css" />';
$message .= '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
$message .= '<table width="750" border="0" cellspacing="0" cellpadding="0">';
$message .= '<tr bgcolor="#ff7e00">';
$message .= '<td width="10" height="10" align="left" valign="top"></td>';
$message .= '<td height="10" align="left" valign="top"></td>';
$message .= '<td width="10" height="10" align="left" valign="top"></td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td width="10" align="left" valign="top" bgcolor="#ff7e00"></td>';
$message .= '<td align="left" valign="top"><table width="730" border="0" cellspacing="0" cellpadding="0">';
$message .= '<tr>';
$message .= '<td width="20" height="20" align="left" valign="top"></td>';
$message .= '<td height="20" align="left" valign="top"></td>';
$message .= '<td width="20" height="20" align="left" valign="top"></td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td width="20" align="left" valign="top"></td>';
$message .= '<td align="left" valign="top"><table width="690" border="0" cellspacing="0" cellpadding="0">';
$message .= '<tr>';
$message .= '<td width="140" align="left" valign="top"><img src="http://70.32.77.87/store_files/soho_logo.jpg" width="126" height="115"  alt=""/></td>';
$message .= '<td align="left" valign="top"><table width="500" border="0" cellspacing="0" cellpadding="0">';
$message .= '<tr>';
$message .= '<td width="125" align="left" valign="middle" style="font-size:14px; color:#ff9600; text-transform:uppercase;">Copmany Name :</td>';        
$message .= '<td align="left" valign="middle" style="color:#202020;">' . $comp_name . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td width="90" align="left" valign="middle" style="font-size:14px; color:#ff9600; text-transform:uppercase;">Address 1 :</td>';        
$message .= '<td align="left" valign="middle" style="color:#202020;">' . $updated_address[0]['address_1'] . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td width="90" align="left" valign="middle" style="font-size:14px; color:#ff9600; text-transform:uppercase;">Address 2 :</td>';        
$message .= '<td align="left" valign="middle" style="color:#202020;">' . $updated_address[0]['address_2'] . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td width="90" align="left" valign="middle" style="font-size:14px; color:#ff9600; text-transform:uppercase;">Address 3 :</td>';        
$message .= '<td align="left" valign="middle" style="color:#202020;">' . $updated_address[0]['address_3'] . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td width="90" align="left" valign="middle" style="font-size:14px; color:#ff9600; text-transform:uppercase;">City,State,Zip :</td>';        
$message .= '<td align="left" valign="middle" style="color:#202020;">' . $updated_address[0]['city'].','.$state_abbr.','.$updated_address[0]['zip'].'</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td width="90" align="left" valign="middle" style="font-size:14px; color:#ff9600; text-transform:uppercase;">Phone :</td>';        
$message .= '<td align="left" valign="middle" style="color:#202020;">' . $phone . '</td>';
$message .= '</tr>';
$message .= '</table></td>';
$message .= '</tr>';
$message .= '</table></td>';
$message .= '<td width="20" align="left" valign="top"></td>';
$message .= '</tr>';                
$message .= '<tr>';
$message .= '<td width="20" height="20" align="left" valign="top"></td>';
$message .= '<td height="20" align="left" valign="top"></td>';
$message .= '<td width="20" height="20" align="left" valign="top"></td>';
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


foreach ($mail_ids as $to){
$subject = "Primary Shipping Address has been changed-SOHOREPRO";
$headers = 'MIME-Version: 1.0' . "\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
$headers .= "From:admin@sohorepro.com" . "\n";
$to = $to['cus_email'];
//echo $to, $subject, $message, $headers;
$result = mail($to, $subject, $message, $headers);
}

if($result){
    ?>
<script>setTimeout("location.href=\'addressbook.php\'", 500);</script>
<?php
}

?>
