<?php
include './admin/config.php';
//include './admin/db_connection.php';

$user_id = $_SESSION['sohorepro_userid'];

$sql = "DELETE FROM sohorepro_checkout WHERE user_id = '" . $user_id . "' ";
mysql_query($sql);

$sql_plot = "TRUNCATE TABLE sohorepro_plotting_set ";
mysql_query($sql_plot);

//$sql_needed_sets = "DELETE FROM sohorepro_sets_needed WHERE usr_id = '" . $user_id . "' ";
//mysql_query($sql_needed_sets);

$ip = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
$sql_ip = "DELETE FROM sohorepro_checkout_guest WHERE ip = '" . $ip . "' ";
mysql_query($sql_ip);

$sql_cmmt = "DELETE FROM sohorepro_cust_commt WHERE cus_id = '". $user_id ."' ";
mysql_query($sql_cmmt);


//session_start();
session_destroy();
header("Location:index.php");
?>