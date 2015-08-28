<?php
include './admin/config.php';
include './admin/db_connection.php';

if($_FILES['uploadedfile']['name'] != ''){
$target_path = "admin/add_set_docs/";
$refe = $_SESSION['ref_val'];
$comp_id    =   $_SESSION['sohorepro_companyid'];
$user_id    =   $_SESSION['sohorepro_userid'];
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
//    $query  = "INSERT INTO sohorepro_add_set_file SET file_name     = '" . $_FILES['uploadedfile']['name'] . "', reference = '".$refe."', copm_id = '".$comp_id."', user_id = '".$user_id."' ";
//    mysql_query($query);
    echo "The file ".  basename( $_FILES['uploadedfile']['name']). " has been uploaded";
    
} else{
    echo "There was an error uploading the file, please try again!";
}
}
?>