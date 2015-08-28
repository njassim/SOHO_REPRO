<?php
if(($_SESSION['supply_user_id']  == '') && ($_SESSION['supply_user_name']  == ''))
{
  header("Location:index.php");
  exit;
}
?>
