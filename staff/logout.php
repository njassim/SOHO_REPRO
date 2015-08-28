<?php
include './admin/config.php';
include './admin/db_connection.php';
$user_id = $_SESSION['supply_user_id'];
$sql = "DELETE FROM sohorepro_checkout_guest WHERE staff_id = " . $user_id . " ";
mysql_query($sql);
$sql_pro = "DELETE FROM sohorepro_checkout WHERE staff_id = " . $user_id . " ";
mysql_query($sql_pro);
session_start();
session_destroy();
header("Location:index.php");
?>