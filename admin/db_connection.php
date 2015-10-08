<?php
error_reporting(E_ALL ^ E_DEPRECATED);

   error_reporting(0);
//error_reporting(E_ALL & ~E_NOTICE);


   
    $link = mysql_connect('localhost', 'root', '');

    $db_selected = mysql_select_db('supply.sohorepro.com', $link);
    
    $base_url="http://".$_SERVER['SERVER_NAME']."";

if (!$db_selected) {
    die('Database not connected : ' . mysql_error());
}
echo mysql_error();


?>
