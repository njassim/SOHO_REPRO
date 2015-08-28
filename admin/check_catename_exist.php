<?php

include './config.php';

if (isset($_POST['category_name']) && !empty($_POST['category_name'])) {
    $category_name = strtolower(mysql_real_escape_string($_POST['category_name']));
    $query = "select * from sohorepro_category where category_name = '$category_name' AND parent_id = '0'";
    $res = mysql_query($query);
    $object = mysql_fetch_assoc($res);
    $catg = $object['category_name'];
    echo count($catg);
}


if (isset($_POST['edit_category_name']) && !empty($_POST['edit_category_name'])) {
    $category_name = strtolower(mysql_real_escape_string($_POST['edit_category_name']));
    $id = $_POST['id'];
    $query = "select * from sohorepro_category where category_name = '$category_name' AND id <> '$id' AND parent_id = '0'";
    $res = mysql_query($query);
    $object = mysql_fetch_assoc($res);
    $catg = $object['category_name'];
    echo count($catg);
}


if (isset($_POST['subcategory_name']) && !empty($_POST['subcategory_name'])) {
    $subcategory_name = strtolower(mysql_real_escape_string($_POST['subcategory_name']));
    $query = "select * from sohorepro_category where category_name = '$subcategory_name' AND parent_id != '0'";
    $res = mysql_query($query);
    $object = mysql_fetch_assoc($res);
    $catg = $object['category_name'];
    echo count($catg);
}



if (isset($_POST['edit_subcategory_name']) && !empty($_POST['edit_subcategory_name'])) {
    $category_name = strtolower(mysql_real_escape_string($_POST['edit_subcategory_name']));
    $id = $_POST['id'];
    $query = "select * from sohorepro_category where category_name = '$category_name' AND id <> '$id' AND parent_id != '0'";
    $res = mysql_query($query);
    $object = mysql_fetch_assoc($res);
    $catg = $object['category_name'];
    echo count($catg);
}




?>
