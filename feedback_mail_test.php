<?php
include './admin/config.php';
include './admin/db_connection.php';

$id              =  '12';
$select_feedback = SelectFeedback($id);
$user_details       = GetUserDetails($select_feedback[0]['comp_id'], $select_feedback[0]['user_name']);
$user_name          = $user_details[0]['cus_fname'].'&nbsp;'.$user_details[0]['cus_lname'];
$user_email         = $user_details[0]['cus_email']; 
$user_company       = companyName($select_feedback[0]['comp_id']);  

$message .= '<div style="border:3px solid #FF7E00;">';
$message .= '<table border="0" style="width:100%;">';

$message .= '<tr>';
$message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">Name</td>';
$message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">:</td>';
$message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;">'.$user_name.'</td>';
$message .= '</tr>';

$message .= '<tr>';
$message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">Email</td>';
$message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">:</td>';
$message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;">'.$user_email.'</td>';
$message .= '</tr>';

$message .= '<tr>';
$message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">Company</td>';
$message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">:</td>';
$message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;">'.$user_company.'</td>';
$message .= '</tr>';

$message .= '<tr>';
$message .= '<td valign="top" style="padding-top: 10px;padding-left: 10px;color:#000;padding-bottom: 10px;font-weight:bold;">Question</td>';
$message .= '<td valign="top" style="padding-top: 10px;padding-left: 10px;color:#000;padding-bottom: 10px;font-weight:bold;">:</td>';
$message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;padding-bottom: 10px;">'.$select_feedback[0]['feedback'].'</td>';
$message .= '</tr>';

$message .= '</table>';
$message .= '</div>'; 


echo $message;

