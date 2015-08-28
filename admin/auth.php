<?php
if($_SESSION['admin_user_id']  == '')
{
  header("Location:index.php");
  exit;
}
?>
