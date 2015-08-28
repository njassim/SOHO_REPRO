<?php
error_reporting(E_ALL & ~E_NOTICE);

$currhost=1;

if($currhost==1)
{
    
    $link = mysql_connect('localhost', 'root', '');

    $db_selected = mysql_select_db('sohorepro', $link);
    
    $base_url="http://localhost/sohorepro";
}
else 
{    
    $link = mysql_connect('localhost', 'cipldevc_jasim', 'Jasim#123');

    $db_selected = mysql_select_db('cipldevc_soho', $link);
    
    $base_url="http://cipldev.com/soho-repro";
}


if (!$db_selected) {
    die('Database not connected : ' . mysql_error());
}
echo mysql_error();


?>
