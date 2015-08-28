<?php
error_reporting(E_ALL & ~E_NOTICE);
$link = mysql_connect('localhost', 'cipldevc_jasim', 'Jasim#123');
$db_selected = mysql_select_db('cipldevc_soho', $link);    
$base_url="http://".$_SERVER['SERVER_NAME']."";
if (!$db_selected) {
    die('Database not connected : ' . mysql_error());
}
echo mysql_error();
?>
