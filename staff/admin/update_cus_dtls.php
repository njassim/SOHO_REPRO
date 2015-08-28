<?php

include './config.php';

if (isset($_POST['fname']) && $_POST['fname'] != '') {
    $id = explode("_", $_POST['id']);
    $comp_id = $id[0];
    $cus_id = $id[1];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $query = "UPDATE sohorepro_customers SET cus_fname  = '" . $fname . "',                                                          
                                             cus_lname  = '" . $lname . "',
                                             cus_email  = '" . $email . "',
                                             cus_phone1 = '" . $phone . "' WHERE cus_compname = '".$comp_id."' AND cus_id = '".$cus_id."'";
    mysql_query($query);
    echo 'User dedails updated successfully' . '~' . $fname . '~' . $lname . '~' . $email . '~' . $phone;
}
?>