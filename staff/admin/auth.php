<?php
if(($_SESSION['user_id']  == '') && ($_SESSION['user_name']  == ''))
{
  header("Location:index.php");
  exit;
}
?>
