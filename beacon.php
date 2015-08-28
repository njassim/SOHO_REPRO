<?php
include './admin/config.php';
include './admin/db_connection.php';

$user_id                = $_GET['user_id'];
$user_mail              = UserMail($user_id);
$user_name              = UserName($user_id);
$company_name           = companyName($user_id);
$query = "INSERT INTO sohorepro_mail_check
			SET     user_name       = '" . $user_name . "',
                                user_mail       = '".$user_mail."',
                                company_name    = '".$company_name."' ";  
mysql_query($query);    

?>
