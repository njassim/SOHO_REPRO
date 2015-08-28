<?php
include './config.php';

if(isset($_POST['company_id']) && $_POST['company_id'] != '')
{ 
  $company_id        = $_POST['company_id'];
  $comp_id_status    = (CheckStatusCus($company_id) == '1') ? '0' : '1';
  $add_class         = (CheckStatusCus($company_id) == '1') ? 'action_rein' : 'action_sus';
  $remove_class      = ($add_class == 'action_sus') ? 'action_rein' : 'action_sus';
  $text              = (CheckStatusCus($company_id) == '1') ? 'REINSTATE' : 'SUSPEND';
  $query = "UPDATE sohorepro_company SET     status = '".$comp_id_status."' WHERE comp_id= '" . $company_id . "' "; 
  $sql_result = mysql_query($query);    
    if ($sql_result) {
        echo $add_class.'~'.$remove_class.'~'.$text;
    }  
}



if(isset($_POST['status_change_id']) && $_POST['status_change_id'] != '')
{ 
  $status_change_id  = $_POST['status_change_id'];
  $comp_id_status    = (CheckStatusEmailSettings($status_change_id) == '1') ? '0' : '1';  
  $sql = "UPDATE sohorepro_email SET status = '" . $comp_id_status . "' WHERE id = '" . $status_change_id . "'";  
  $sql_result = mysql_query($sql);    
  $image_change      = (CheckStatusEmailSettings($status_change_id) == '1') ? 'images/active.png' : 'images/de-active.png'; 
    if ($sql_result) {
        echo $image_change;
    }  
}
