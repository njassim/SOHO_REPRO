<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);


if (isset($_POST['shipping_id_rp']) && $_POST['shipping_id_rp'] != '') {
      $shipp_add = SelectIdAddressService($_POST['shipping_id_rp']);   
      if($shipp_add != ''){
          $add_1 = ($shipp_add[0]['address_1'] == '') ? '' : $shipp_add[0]['address_1'].', ';
          $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'].', ';
      echo $add_1.$add_2.$shipp_add[0]['city'].', '.StateName($shipp_add[0]['state']).' '.$shipp_add[0]['zip'].'~'.$shipp_add[0]['attention_to'];
      }
} 
?>
