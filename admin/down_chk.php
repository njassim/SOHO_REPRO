<?php
// connect and login to FTP server
$ftp_server = "cipldev.com";
$ftp_username = 'saranya@cipldev.com';
$ftp_userpass = 'Colan#123';
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);

$local_file = "mail_inv.html";
$server_file = 'http://cipldev.com/supply.sohorepro.com/admin/mail_inv.html';

$test = file_get_contents($server_file);

$path = '192.168.1.71/mail_inv.html';

file_put_contents($path, $test);

//
//print_r($test);
//
//exit;
//
//// download server file
//if (ftp_get($ftp_conn, $local_file, $server_file, FTP_ASCII))
//  {
//  echo "Successfully written to $local_file.";
//  }
//else
//  {
//  echo "Error downloading $server_file.";
//  }
//
//// close connection
//ftp_close($ftp_conn);