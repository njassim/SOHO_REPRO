<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);


if ($_POST['use_thesame_file'] == '1') {
    
    $comp_id        =   $_SESSION['sohorepro_companyid'];
    $user_id        =   $_SESSION['sohorepro_userid'];
    
    $last_date      =   LastFileOptionEntered($comp_id, $user_id);
    $use_the_same   =   LastFileOptionEnteredSame($comp_id, $user_id);
    if(count($last_date) != 0){    
    $_SESSION['upload_file']    =   $last_date[0]['upload_file'];
    $_SESSION['pick_up']        =   $last_date[0]['pick_up'];
    $_SESSION['pick_up_time']   =   $last_date[0]['pick_up_time'];
    $_SESSION['drop_off']       =   $last_date[0]['drop_off'];
    $_SESSION['ftp_link']       =   $last_date[0]['ftp_link'];
    $_SESSION['user_name']      =   $last_date[0]['user_name'];
    $_SESSION['password']       =   $last_date[0]['password']; 
    $_SESSION['use_the_same']   =   $use_the_same[0]['options'];
    echo '1';
    }
    
    
}elseif ($_POST['use_thesame_file'] == '2') {
    
    $_SESSION['upload_file']    =   '';
    $_SESSION['pick_up']        =   '';
    $_SESSION['pick_up_time']   =   '';
    $_SESSION['drop_off']       =   '';
    $_SESSION['ftp_link']       =   '';
    $_SESSION['user_name']      =   '';
    $_SESSION['password']       =   '';
    $_SESSION['use_the_same']   =   '';
    echo '1';
    
}

