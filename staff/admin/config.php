<?php
session_start();
include './db_connection.php';
//include 'Excel/reader.php';
function getSuperCategory($sorting) {
    if($sorting == 'ca'){
    $select_category = "SELECT * FROM sohorepro_category WHERE parent_id = '0' AND super_id = '0' ORDER BY category_name ASC";  
    }elseif($sorting == 'cd'){
    $select_category = "SELECT * FROM sohorepro_category WHERE parent_id = '0' AND super_id = '0' ORDER BY category_name DESC";  
    }else { 
    $select_category = "SELECT * FROM sohorepro_category WHERE parent_id = '0' AND super_id = '0' ORDER BY sort ASC";
    }  
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getCategory($sorting) {
    if($sorting == 'ca'){
    $select_category = "SELECT * FROM sohorepro_category WHERE super_id != '0' AND parent_id = '0' ORDER BY category_name ASC";  
    }elseif($sorting == 'cd'){
    $select_category = "SELECT * FROM sohorepro_category WHERE super_id != '0' AND parent_id = '0' ORDER BY category_name DESC";  
    }else { 
    $select_category = "SELECT * FROM sohorepro_category WHERE super_id != '0' AND parent_id = '0' ORDER BY sort ASC";
    }  
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getSubCategory($sorting) {
    if($sorting == 'sca'){
    $select_category = "SELECT * FROM sohorepro_category WHERE super_id != '0' AND parent_id != '0' ORDER BY category_name ASC";  
    }elseif($sorting == 'scd'){
    $select_category = "SELECT * FROM sohorepro_category WHERE super_id != '0' AND parent_id != '0' ORDER BY category_name DESC";  
    }else { 
    $select_category = "SELECT * FROM sohorepro_category WHERE super_id != '0' AND parent_id != '0' ORDER BY sort ASC";
    }
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getSubCategoryU($s_id) {
    $select_category = "SELECT * FROM sohorepro_category WHERE parent_id = '$s_id' ORDER BY sort ASC";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getCategoryU($c_id) {
    $select_category = "SELECT * FROM sohorepro_category WHERE super_id = '$c_id' AND parent_id ='0' ORDER BY sort ASC";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}

function editCategory($id) {
    $select_category = "SELECT * FROM sohorepro_category WHERE id = '".$id."'";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}

function editSubCategory($id) {
    $select_category = "SELECT * FROM sohorepro_category WHERE id = '".$id."'";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}


function getSuperCategoryActive($start,$limit) {
    $select_category = "SELECT * FROM sohorepro_category WHERE super_id = '0' AND parent_id = '0' AND status = '1' LIMIT $start, $limit";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getSuperCategoryActiveA() {
    $select_category = "SELECT * FROM sohorepro_category WHERE super_id = '0' AND parent_id = '0' AND status = '1'";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}


function SuperCount() {
    $select_category = "SELECT * FROM sohorepro_category WHERE super_id = '0' AND parent_id = '0' AND status = '1'";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}

function CateCount() {
    $select_category = "SELECT * FROM sohorepro_category WHERE super_id != '0' AND parent_id = '0'";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}

function SubCateCount() {
    $select_category = "SELECT * FROM sohorepro_category WHERE super_id != '0' AND parent_id != '0'";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}


function getSuperCate($super_category_id) {
    $select_category = "SELECT * FROM sohorepro_category WHERE id = '".$super_category_id."' AND status = '1'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['category_name']; 
    return $catg;
}

function getCate($category_id) {
    $select_category = "SELECT * FROM sohorepro_category WHERE id = '".$category_id."' AND status = '1'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['category_name']; 
    return $catg;
}

function getSubCate($sub_category_id) {
    $select_category = "SELECT * FROM sohorepro_category WHERE id = '".$sub_category_id."' AND status = '1'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['category_name']; 
    return $catg;
}

function getCategoryActive() {
    $select_category = "SELECT * FROM sohorepro_category WHERE super_id != '0' AND status = '1' AND parent_id = '0'";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}

function CategoryLoad($id) {
    $select_category = "select * from sohorepro_category where (super_id !='0' AND super_id ='".$id."') AND parent_id = '0' ORDER BY category_name ASC ";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}

function SubCategoryLoad($sup_id,$cat_id) {
    $super_category_id = ($sup_id == '') ? '999': $sup_id;
    $category_id = ($cat_id == '') ? '999': $cat_id;
    $select_category = "select * from sohorepro_category WHERE super_id ='".$super_category_id."' AND parent_id = '".$category_id."' ORDER BY category_name ASC ";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getSuperCat() {
    $select_category = "SELECT * FROM sohorepro_category WHERE super_id = '0' AND status = '1' ORDER BY category_name ASC";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}


function getSubCategoryActive($super_id,$ca_id) {
    $select_category = "SELECT * FROM sohorepro_category WHERE super_id = '".$super_id."' AND parent_id = '".$ca_id."' ";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getCategoryName($parent) {
    $select_category = "SELECT category_name FROM sohorepro_category WHERE id = '".$parent."'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['category_name']; 
    return $catg;
}

function getSuperCategoryName($super_id) {
    $select_category = "SELECT category_name FROM sohorepro_category WHERE id = '".$super_id."'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['category_name']; 
    return $catg;
}

function getSubCategoryName($parent) {
    $select_category = "SELECT category_name FROM sohorepro_category WHERE id = '".$parent."'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['category_name']; 
    return $catg;
}

function getSubCategoryActiveE($s_id) {
    $select_category = "SELECT category_name FROM sohorepro_category WHERE id = '".$s_id."'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['category_name']; 
    return $catg;
}



function getAllCategoryActive() {
    $select_category = "SELECT * FROM sohorepro_category WHERE status = '1'";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getProducts($sorting,$start,$limit) {    
    if($sorting == 'pna'){
    $select_products = "SELECT * FROM sohorepro_products ORDER BY product_name ASC LIMIT $start, $limit";  
    }elseif ($sorting == 'pnd') {
    $select_products = "SELECT * FROM sohorepro_products ORDER BY product_name DESC LIMIT $start, $limit";      
    }elseif ($sorting == 'psa') {
    $select_products = "SELECT * FROM sohorepro_products ORDER BY sku_id ASC LIMIT $start, $limit";      
    }elseif ($sorting == 'psd') {
    $select_products = "SELECT * FROM sohorepro_products ORDER BY sku_id DESC LIMIT $start, $limit";      
    }elseif ($sorting == 'ppa') {
    $select_products = "SELECT * FROM sohorepro_products ORDER BY price ASC LIMIT $start, $limit";      
    }elseif ($sorting == 'ppd') {
    $select_products = "SELECT * FROM sohorepro_products ORDER BY price DESC LIMIT $start, $limit";      
    }  else {
    $select_products = "SELECT * FROM sohorepro_products ORDER BY sort ASC LIMIT $start, $limit";   
    }  
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}


function ProductsCount() {    
    $select_products = "SELECT * FROM sohorepro_products"; 
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}


function editPdoructs($id) {
    $select_products = "SELECT * FROM sohorepro_products WHERE id = '".$id."'";
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}

function editPdoructsOrder($id,$ord_id) {
    $select_products = "SELECT * FROM sohorepro_products WHERE id = '".$id."'";
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getProductsU($c_id,$s_id,$su_id) {
    $select_products = "SELECT * FROM sohorepro_products WHERE supercategory_id = '".$c_id."' AND category_id = '".$s_id."' AND subcategory_id = '".$su_id."'ORDER BY sort ASC" ;
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getOrdersAll($sorting) {
    //return $sorting;
    if($sorting == 'a'){
    $select_orders = "SELECT * FROM sohorepro_order_master ORDER BY created_date ASC";  
    }  
    elseif($sorting == 'd') 
    {
    $select_orders = "SELECT * FROM sohorepro_order_master ORDER BY created_date DESC";     
    }
    elseif($sorting == 'jnd') 
    {
    $select_orders = "SELECT * FROM sohorepro_order_master ORDER BY order_id DESC";     
    }
    elseif($sorting == 'jna') 
    {
    $select_orders = "SELECT * FROM sohorepro_order_master ORDER BY order_id ASC";     
    }
    else 
    {
    $select_orders = "SELECT * FROM sohorepro_order_master ORDER BY id DESC";        
    }
    $orders = mysql_query($select_orders);
    while ($object = mysql_fetch_assoc($orders)):
        $value[] = $object;
    endwhile;
   return $value;
}

function getPrice($id) {
    $select_price = "SELECT sum(product_price * product_quantity) as sub_total FROM sohorepro_product_master WHERE order_id = '".$id."'" ;
    $price = mysql_query($select_price);
    while ($object = mysql_fetch_assoc($price)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getTaxStatus($id) {
    $select_tax = "SELECT tax_status FROM sohorepro_product_master WHERE order_id = '".$id."'" ;
    $price = mysql_query($select_tax);
    $object = mysql_fetch_assoc($price);
    $value = $object['tax_status'];
    return $value;
}

function getTaxStatusChk($id) {
    $select_tax = "SELECT tax_exe FROM sohorepro_company WHERE comp_id = '".$id."'" ;
    $price = mysql_query($select_tax);
    $object = mysql_fetch_assoc($price);
    $value = $object['tax_exe'];
    return $value;
}

function getPriceAll($id) {
    $select_price = "SELECT sum(product_quantity),sum(product_price) FROM sohorepro_product_master WHERE order_id = '".$id."'" ;
    $price = mysql_query($select_price);
    $object = mysql_fetch_assoc($price);
    $value = $object['sum(product_quantity)'];    
    return $value;
}

function viewOrders($id) {
    //return $id;
    $select_orders = "SELECT * FROM sohorepro_product_master WHERE order_id = '".$id."'" ;
    $price = mysql_query($select_orders);
    while ($object = mysql_fetch_assoc($price)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getorderProd($id) {
    $select_category = "SELECT product_name FROM sohorepro_products WHERE id = '".$id."'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['product_name']; 
    return $catg;
}


function ProdNameForAdd($id) {
    $select_category = "SELECT product_name FROM sohorepro_products WHERE id = '".$id."'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['product_name']; 
    return $catg;
}

function GetShippforAddProd($id) {
    $select_category = "SELECT shipping_add_id FROM sohorepro_product_master WHERE order_id = '".$id."'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['shipping_add_id']; 
    return $catg;
}

function ProdPriceForAdd($id) {
    $select_category = "SELECT price FROM sohorepro_products WHERE id = '".$id."'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['price']; 
    return $catg;
}

function getorderProdja($id) {
    $select_category = "SELECT id FROM sohorepro_products WHERE id = '".$id."'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['id']; 
    return $catg;
}

function getorderSku($id) {
    $select_category = "SELECT sku_id FROM sohorepro_products WHERE id = '".$id."'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['sku_id']; 
    return $catg;
}

function ExistQuantity($product_id,$order_id) {
    $select_qty = "SELECT product_quantity FROM sohorepro_product_master WHERE product_id = '".$product_id."'  AND order_id = '".$order_id."' ";
    $quantity   = mysql_query($select_qty);
    $object     = mysql_fetch_assoc($quantity);
    $qty        = $object['product_quantity']; 
    return $qty;
}


function ExistQuantityGuest($product_id,$id) {
    $select_qty = "SELECT quantity FROM sohorepro_checkout_guest WHERE product_id = '".$product_id."'  AND ip = '".$id."' ";
    $quantity   = mysql_query($select_qty);
    $object     = mysql_fetch_assoc($quantity);
    $qty        = $object['quantity']; 
    return $qty;
}


function ExistProductOrder($product_id,$order_id) {
    $select_orders = "SELECT * FROM sohorepro_products_order_temp WHERE product_id = '".$product_id."'  AND order_id = '".$order_id."' " ;
    $price = mysql_query($select_orders);
    while ($object = mysql_fetch_assoc($price)):
        $value[] = $object;
    endwhile;
    return $value;
}


function ExistProductOrderGuest($product_id,$ip) {
    $select_orders = "SELECT * FROM sohorepro_checkout_guest WHERE product_id = '".$product_id."'  AND ip = '".$ip."' " ;
    $price = mysql_query($select_orders);
    while ($object = mysql_fetch_assoc($price)):
        $value[] = $object;
    endwhile;
    return $value;
}

function AdditionalProduct($order_id) {
    $select_orders = "SELECT * FROM sohorepro_products_order_temp WHERE order_id = '".$order_id."' " ;
    $price = mysql_query($select_orders);
    while ($object = mysql_fetch_assoc($price)):
        $value[] = $object;
    endwhile;
    return $value;
}


function getProductsFilter($su_file_id,$c_fil_id,$sc_fil_id,$start,$limit) {
    if(($c_fil_id == '0') && ($sc_fil_id == '0')){
    $select_products = "SELECT * FROM sohorepro_products WHERE supercategory_id = '".$su_file_id."' LIMIT $start, $limit";  
    } else {
    $select_products = "SELECT * FROM sohorepro_products WHERE supercategory_id = '".$su_file_id."' AND category_id = '".$c_fil_id."' AND subcategory_id = '".$sc_fil_id."' LIMIT $start, $limit";
    }     
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getProductsFilterS($search_val,$start,$limit) {
    $val = mysql_real_escape_string($search_val);
    $select_products = "SELECT * FROM `sohorepro_products` WHERE `product_name` LIKE '%$val%' LIMIT $start, $limit ";
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}

function SearchUserEnd($search_val) {
    $split_val   = explode("(",$search_val);
    $val = trim(mysql_real_escape_string($split_val[0]));
    $select_products = "SELECT * FROM `sohorepro_products` WHERE `product_name` LIKE '%$val%' ";
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}

function SearchUserEndCat($search_val) {
    $split_val   = explode("(",$search_val);
    $val = trim(mysql_real_escape_string($split_val[0]));
    $select_products = "SELECT * FROM `sohorepro_category` WHERE `category_name` LIKE '%$val%' ";
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}

function SelectCatItem($id) {
    $select_products = "SELECT * FROM `sohorepro_products` WHERE ((supercategory_id = '$id') OR (category_id = '$id') OR (subcategory_id = '$id')) ";
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}


function CountFilter($su_file_id,$c_fil_id,$sc_fil_id) {
    if(($c_fil_id == '0') && ($sc_fil_id == '0')){
    $select_products = "SELECT * FROM sohorepro_products WHERE supercategory_id = '".$su_file_id."' ";  
    } else {
    $select_products = "SELECT * FROM sohorepro_products WHERE supercategory_id = '".$su_file_id."' AND category_id = '".$c_fil_id."' AND subcategory_id = '".$sc_fil_id."' ";
    }    
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}

function CountSearch($search_val) {
    $select_products = "SELECT * FROM `sohorepro_products` WHERE `product_name` LIKE '%$search_val%' ";
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}


function getQty($id,$ord_id) {
    $select_category = "SELECT product_quantity FROM sohorepro_product_master WHERE product_id = '".$id."' AND order_id = '".$ord_id."'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['product_quantity']; 
    return $catg;
}

function getpid($id,$ord_id) {
    $select_category = "SELECT product_id FROM sohorepro_product_master WHERE product_id = '".$id."' AND order_id = '".$ord_id."'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['product_id']; 
    return $catg;
}


function getPriceE($id,$ord_id) {
    $select_category = "SELECT product_price FROM sohorepro_product_master WHERE product_id = '".$id."' AND order_id = '".$ord_id."'";
    $category = mysql_query($select_category);
    $object = mysql_fetch_assoc($category);
    $catg = $object['product_price']; 
    return $catg;
}

function getEmail() {
    $select_products = "SELECT * FROM sohorepro_email";
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getActiveEmail() {
    $select_products = "SELECT * FROM sohorepro_email WHERE status = '1'";
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}

function editEmail($id) {
    $select_email = "SELECT * FROM sohorepro_email WHERE id = '".$id."'";
    $mail = mysql_query($select_email);
    while ($object = mysql_fetch_assoc($mail)):
        $value[] = $object;
    endwhile;
    return $value;
}

function UserMail($id) {
    $select_email = "SELECT cus_email FROM sohorepro_customers WHERE cus_id = '".$id."'";
    $mail = mysql_query($select_email);
    $object = mysql_fetch_assoc($mail);
    $catg = $object['cus_email']; 
    return $catg;
}

function UserName($id) {
    $select_email = "SELECT cus_contact_name FROM sohorepro_customers WHERE cus_id = '".$id."'";
    $mail = mysql_query($select_email);
    $object = mysql_fetch_assoc($mail);
    $catg = $object['cus_contact_name']; 
    return $catg;
}

function getsuperProducts($c_id,$id) {
    $select_products = "SELECT * FROM sohorepro_products WHERE supercategory_id = '".$c_id."' AND (category_id = '' OR category_id = '0') AND (subcategory_id = '' OR subcategory_id = '0') AND id <> '".$id."' ORDER BY sort ASC" ;
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getsuper_subcatProducts($c_id,$s_id) {
    $select_products = "SELECT * FROM sohorepro_products WHERE supercategory_id = '".$c_id."' AND category_id = '".$s_id."' AND (subcategory_id = '' OR subcategory_id = '0') ORDER BY sort ASC" ;
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}


function getusers_list($sorting) {    
    if($sorting == 'pna'){
    $select_users = "SELECT * FROM sohorepro_company ORDER BY comp_name ASC";  
    }elseif ($sorting == 'pnd') {
    $select_users = "SELECT * FROM sohorepro_company ORDER BY comp_name DESC";      
    }elseif ($sorting == 'pea') {
    $select_users = "SELECT * FROM sohorepro_company ORDER BY comp_name ASC";      
    }elseif ($sorting == 'ped') {
    $select_users = "SELECT * FROM sohorepro_company ORDER BY comp_name DESC";      
    }elseif ($sorting == 'pda') {
    $select_users = "SELECT * FROM sohorepro_company ORDER BY comp_name ASC";      
    }elseif ($sorting == 'pdd') {
    $select_users = "SELECT * FROM sohorepro_company ORDER BY comp_name DESC";      
    }  else {
    $select_users = "SELECT * FROM sohorepro_company ORDER BY comp_id ASC";   
    }  
    $users_list = mysql_query($select_users);
    while ($object = mysql_fetch_assoc($users_list)):
        $value[] = $object;
    endwhile;
    return $value;
}


function edituser($id) {
    $select_users = "SELECT * FROM sohorepro_customers WHERE cus_id = '".$id."'";
    $users_details = mysql_query($select_users);
    while ($object = mysql_fetch_assoc($users_details)):
        $value[] = $object;
    endwhile;
    return $value;
}

function get_special_price($id) {
    $select_price = "SELECT sp_id,sp_product_id,sp_special_price,sp_list_price,sp_discount FROM sohorepro_special_pricing WHERE sp_user_id = '".$id."'";
    $price_details = mysql_query($select_price);
    while ($object = mysql_fetch_assoc($price_details)):
        $value[] = $object;
    endwhile;
    return $value;
}

//checked items for staff users
function get_checked_item($id) {
    $select_price = "SELECT (quantity * unit_price) as sub_total,product_id,quantity FROM sohorepro_checkout WHERE staff_id = '".$id."'";
    $price_details = mysql_query($select_price);
    while ($object = mysql_fetch_assoc($price_details)):
        $value[] = $object;
    endwhile;
    return $value;
}

function CheckedOrderProduct($order_id) {
    $select_price = "SELECT product_id,product_quantity FROM sohorepro_products_order_temp WHERE order_id = '".$order_id."'";
    $price_details = mysql_query($select_price);
    while ($object = mysql_fetch_assoc($price_details)):
        $value[] = $object;
    endwhile;
    return $value;
}

function customerProducts($id) {
    $select_products = "SELECT * FROM sohorepro_special_pricing WHERE sp_user_id = '".$id."'" ;
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getProductId($id) {
    $select_email = "SELECT * FROM sohorepro_special_pricing WHERE sp_user_id = '".$id."'";
    $mail = mysql_query($select_email);
    while ($object = mysql_fetch_assoc($mail)):
        $value[] = $object;
    endwhile;
    return $value;
}


function checkSpecial($user_id,$id) {
    $select_check = "SELECT * FROM sohorepro_special_pricing WHERE sp_user_id = '".$user_id."' AND sp_product_id = '".$id."'";
    $check = mysql_query($select_check);
    while ($object = mysql_fetch_assoc($check)):
        $value[] = $object;
    endwhile;
    return $value;
}

function getOrderReport($start,$limit) {
    $select_orders = "SELECT * FROM sohorepro_products ORDER BY id DESC LIMIT $start, $limit";        
    $orders = mysql_query($select_orders);
    while ($object = mysql_fetch_assoc($orders)):
        $value[] = $object;
    endwhile;
   return $value;
}

function companyName($id) {
    $select_company = "SELECT comp_name FROM sohorepro_company WHERE comp_id = '".$id."'";
    $company = mysql_query($select_company);
    $object = mysql_fetch_assoc($company);
    $catg = $object['comp_name']; 
    return $catg;
}

function companyphone($id) {
    $select_company = "SELECT comp_contact_phone FROM sohorepro_company WHERE comp_id = '".$id."'";
    $company = mysql_query($select_company);
    $object = mysql_fetch_assoc($company);
    $catg = $object['comp_contact_phone']; 
    return $catg;
}

function Get_id($id) {
    $select_company = "SELECT id FROM sohorepro_products WHERE category_id = '".$id."'";
    $orders = mysql_query($select_company);
    while ($object = mysql_fetch_assoc($orders)):
        $value[] = $object;
    endwhile;
   return $value;
}



function customerName($id) {
    $select_orders = "SELECT * FROM sohorepro_customers WHERE cus_id = '".$id."'";        
    $orders = mysql_query($select_orders);
    while ($object = mysql_fetch_assoc($orders)):
        $value[] = $object;
    endwhile;
   return $value;
}


function getSpecialProduct($id) {
    $select_check = "SELECT * FROM sohorepro_special_pricing WHERE sp_user_id = '".$id."'";
    //$select_check = "SELECT * FROM sohorepro_special_pricing";
    $check = mysql_query($select_check);
    while ($object = mysql_fetch_assoc($check)):
        $value[] = $object;
    endwhile;
    return $value;
}

function get_spl_prod() {
    $select_check = "SELECT * FROM sohorepro_special_pricing_excel ";
    //$select_check = "SELECT * FROM sohorepro_special_pricing";
    $check = mysql_query($select_check);
    while ($object = mysql_fetch_assoc($check)):
        $value[] = $object;
    endwhile;
    return $value;
}

function get_spl_prod_test() {
    $select_check = "SELECT * FROM sohorepro_special_pricing WHERE sp_user_id = '1' ";
    //$select_check = "SELECT * FROM sohorepro_special_pricing";
    $check = mysql_query($select_check);
    while ($object = mysql_fetch_assoc($check)):
        $value[] = $object;
    endwhile;
    return $value;
}

function checkID($id) {
    $select_check = "SELECT * FROM sohorepro_special_pricing_excel WHERE sp_product_id = '".$id."' ";
    //$select_check = "SELECT * FROM sohorepro_special_pricing";
    $check = mysql_query($select_check);
    while ($object = mysql_fetch_assoc($check)):
        $value[] = $object;
    endwhile;
    return $value;
}

function tempProd() {
    $select_check = "SELECT * FROM sohorepro_products ";
    //$select_check = "SELECT * FROM sohorepro_special_pricing";
    $check = mysql_query($select_check);
    while ($object = mysql_fetch_assoc($check)):
        $value[] = $object;
    endwhile;
    return $value;
}

function checkAdmin($id) {
    $select_check = "SELECT cus_manager FROM sohorepro_customers WHERE cus_compname = '".$id."' AND cus_manager = '1' ";   
    $check = mysql_query($select_check);
    $object = mysql_fetch_assoc($check);
    $catg = $object['cus_manager']; 
    return $catg;
}

function CheckManager($id) {
    $select_check = "SELECT cus_manager FROM sohorepro_customers WHERE cus_id = '".$id."' ";   
    $check = mysql_query($select_check);
    $object = mysql_fetch_assoc($check);
    $catg = $object['cus_manager']; 
    return $catg;
}

//Mail Id's For Company
function CompanyMember($id) {
    $select_check = "SELECT * FROM sohorepro_customers WHERE cus_compname = '".$id."' ";   
    $check = mysql_query($select_check);
    while ($object = mysql_fetch_assoc($check)):
        $value[] = $object;
    endwhile;
    return $value;
}

function Bussunes1($id) {
    $select_check = "SELECT cus_bill_address1 FROM sohorepro_customers WHERE cus_compname = '".$id."'";   
    $check = mysql_query($select_check);
    $object = mysql_fetch_assoc($check);
    $catg = $object['cus_bill_address1']; 
    return $catg;
}

function Bussunes2($id) {
    $select_check = "SELECT cus_bill_address2 FROM sohorepro_customers WHERE cus_compname = '".$id."'";   
    $check = mysql_query($select_check);
    $object = mysql_fetch_assoc($check);
    $catg = $object['cus_bill_address2']; 
    return $catg;
}

function Bussunes3($id) {
    $select_check = "SELECT cus_bill_address3 FROM sohorepro_customers WHERE cus_compname = '".$id."'";   
    $check = mysql_query($select_check);
    $object = mysql_fetch_assoc($check);
    $catg = $object['cus_bill_address3']; 
    return $catg;
}

function company_phone($id) {
    $select_check = "SELECT cus_contact_phone FROM sohorepro_customers WHERE cus_compname = '".$id."'";   
    $check = mysql_query($select_check);
    $object = mysql_fetch_assoc($check);
    $catg = $object['cus_contact_phone']; 
    return $catg;
}

function company_fax($id) {
    $select_check = "SELECT cus_contact_fax FROM sohorepro_customers WHERE cus_compname = '".$id."'";   
    $check = mysql_query($select_check);
    $object = mysql_fetch_assoc($check);
    $catg = $object['cus_contact_fax']; 
    return $catg;
}

function company_city($id) {
    $select_check = "SELECT cus_bill_city FROM sohorepro_customers WHERE cus_compname = '".$id."'";   
    $check = mysql_query($select_check);
    $object = mysql_fetch_assoc($check);
    $catg = $object['cus_bill_city']; 
    return $catg;
}

function company_state($id) {
    $select_check = "SELECT cus_bill_state FROM sohorepro_customers WHERE cus_compname = '".$id."'";   
    $check = mysql_query($select_check);
    $object = mysql_fetch_assoc($check);
    $catg = $object['cus_bill_state']; 
    return $catg;
}

function company_zip($id) {
    $select_check = "SELECT cus_bill_zipcode FROM sohorepro_customers WHERE cus_compname = '".$id."'";   
    $check = mysql_query($select_check);
    $object = mysql_fetch_assoc($check);
    $catg = $object['cus_bill_zipcode']; 
    return $catg;
}


function selectManager($id) {
    $select_check = "SELECT cus_email FROM sohorepro_customers WHERE cus_compname = '".$id."' AND cus_manager = '1' ";   
    $check = mysql_query($select_check);
    $object = mysql_fetch_assoc($check);
    $catg = $object['cus_email']; 
    return $catg;
}

function getsuper($id) {
    $select_company = "SELECT supercategory_id FROM sohorepro_products WHERE id = '".$id."'";
    $company = mysql_query($select_company);
    $object = mysql_fetch_assoc($company);
    $catg = $object['supercategory_id']; 
    return $catg;
}

function getcat($id) {
    $select_company = "SELECT category_id FROM sohorepro_products WHERE id = '".$id."'";
    $company = mysql_query($select_company);
    $object = mysql_fetch_assoc($company);
    $catg = $object['category_id']; 
    return $catg;
}

function getsub($id) {
    $select_company = "SELECT subcategory_id FROM sohorepro_products WHERE id = '".$id."'";
    $company = mysql_query($select_company);
    $object = mysql_fetch_assoc($company);
    $catg = $object['subcategory_id']; 
    return $catg;
}

function getsuperN($id) {
    $select_company = "SELECT category_name FROM sohorepro_category WHERE id = '".$id."'";
    $company = mysql_query($select_company);
    $object = mysql_fetch_assoc($company);
    $catg = $object['category_name']; 
    return $catg;
}

function getcatN($id) {
    $select_company = "SELECT category_name FROM sohorepro_category WHERE id = '".$id."'";
    $company = mysql_query($select_company);
    $object = mysql_fetch_assoc($company);
    $catg = $object['category_name']; 
    return $catg;
}

function getsubN($id) {
    $select_company = "SELECT category_name FROM sohorepro_category WHERE id = '".$id."'";
    $company = mysql_query($select_company);
    $object = mysql_fetch_assoc($company);
    $catg = $object['category_name']; 
    return $catg;
}

//Customers Per Comapny

function custPerComp($id) {
    $select_users = "SELECT * FROM sohorepro_customers WHERE cus_compname = '".$id."'";
    $users_details = mysql_query($select_users);
    while ($object = mysql_fetch_assoc($users_details)):
        $value[] = $object;
    endwhile;
    return $value;
}




//Pagination Function
function Paginations($per_page = 10, $page = 1, $url = '', $total){    
 
        $adjacents = "2";
 
        $page = ($page == 0 ? 1 : $page); 
        $start = ($page - 1) * $per_page;                              
         
        $prev = $page - 1;                         
        $next = $page + 1;
        $lastpage = ceil($total/$per_page);
        $lpm1 = $lastpage - 1;
         
        $pagination = "";
        if($lastpage > 1)
        {  
            $pagination .= "<ul class='pagination'>";
                    $pagination .= "<li class='details'>Page $page of $lastpage</li>";
            if ($lastpage < 7 + ($adjacents * 2))
            {  
                for ($counter = 1; $counter <= $lastpage; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>$counter</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
                }
            }
            elseif($lastpage > 5 + ($adjacents * 2))
            {
                if($page < 1 + ($adjacents * 2))    
                {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<li><a class='current'>$counter</a></li>";
                        else
                            $pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
                    }
                    $pagination.= "<li class='dot'>...</li>";
                    $pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
                    $pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>";     
                }
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                {
                    $pagination.= "<li><a href='{$url}1'>1</a></li>";
                    $pagination.= "<li><a href='{$url}2'>2</a></li>";
                    $pagination.= "<li class='dot'>...</li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<li><a class='current'>$counter</a></li>";
                        else
                            $pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
                    }
                    $pagination.= "<li class='dot'>..</li>";
                    $pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
                    $pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>";     
                }
                else
                {
                    $pagination.= "<li><a href='{$url}1'>1</a></li>";
                    $pagination.= "<li><a href='{$url}2'>2</a></li>";
                    $pagination.= "<li class='dot'>..</li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<li><a class='current'>$counter</a></li>";
                        else
                            $pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
                    }
                }
            }
             
            if ($page < $counter - 1){
                $pagination.= "<li><a href='{$url}$next'>Next</a></li>";
                $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
            }else{
                $pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";
            }
            $pagination.= "</ul>\n";     
        }          
        return $pagination;
    } 		


//Excel File Upload Functions
    function uploadFile($fieldName, $fileType, $folderName, $name = "")
    {
        $flg = 0;
        $MaxID = "";
        $ext = "";
        $uploadfile = "";
        if (isset($fieldName) AND $fieldName['name'] != '')
        {
            $flg = 1;
            $allowed_filetypes = $fileType;
            $max_filesize = 1048576;
            $filename = $fieldName['name'];
            if ($name == "")
                //$MaxID = time() . time() . rand(1, 100);
                $MaxID = $filename;
            else
                $MaxID = $name;
            $ext = substr($filename, strpos($filename, '.'), strlen($filename) - 1);
			if($ext==".xlsx")
				$ext=".xls";
            if (!in_array($ext, $allowed_filetypes))
                echo "<h1>The file you attempted to upload is not allowed...</h1>";
            else if (filesize($fieldName['tmp_name']) > $max_filesize)
                echo "<h1>The file you attempted to upload is too large...</h1>";
            else 
            {
                $uploadfile = $folderName . "/" . $MaxID;
                if (move_uploaded_file($fieldName['tmp_name'], $uploadfile) == FALSE)
                {
                    echo "<h1>Error in Uploading File...</h1>";
                    $MaxID = "";
                }
                else
                    $MaxID = $MaxID;
            }
        }
        return $MaxID;
    }
    
    function checkSuperCate($id) 
    {
    $select_category = "SELECT * FROM sohorepro_category WHERE category_name = '$id' AND super_id = '0' AND parent_id = '0'";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
    }
    
    
    function checkCate($id) 
    {
    $select_category = "SELECT * FROM sohorepro_category WHERE category_name = '$id' AND super_id != '0' AND parent_id = '0'";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
    }
    
    function checkSubCate($id) 
    {
    $select_category = "SELECT * FROM sohorepro_category WHERE category_name = '$id' AND super_id != '0' AND parent_id != '0'";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
    }
    
    function getproductName($id) 
    {
    $select_category = "SELECT * FROM sohorepro_products WHERE product_name = '$id'";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
    }
    
//Checkout Functions
    
function checkOut($id)
{
    $select_checkout = "SELECT * FROM sohorepro_checkout WHERE user_id = '$id'";
    $product = mysql_query($select_checkout);
    while ($object = mysql_fetch_assoc($product)):
        $value[] = $object;
    endwhile;
    return $value;    
}

function checkPid($pid,$uid)
{
    $select_checkout = "SELECT * FROM sohorepro_checkout WHERE product_id = '$pid' AND user_id = '$uid'";
    $product = mysql_query($select_checkout);
    while ($object = mysql_fetch_assoc($product)):
        $value[] = $object;
    endwhile;
    return $value;    
}
 
function checkPIOD($order_id,$product_id)
{
    $select_checkout = "SELECT * FROM sohorepro_product_master WHERE order_id = '$order_id' AND product_id = '$product_id' ";
    $product = mysql_query($select_checkout);
    while ($object = mysql_fetch_assoc($product)):
        $value[] = $object;
    endwhile;
    return $value;    
}

    
function getSku($id) {
    $select_sku = "SELECT sku_id FROM sohorepro_products WHERE id = '".$id."'";
    $company = mysql_query($select_sku);
    $object = mysql_fetch_assoc($company);
    $catg = $object['sku_id']; 
    return $catg;
}

function getProName($id) {
    $select_name = "SELECT product_name FROM sohorepro_products WHERE id = '".$id."'";
    $company = mysql_query($select_name);
    $object = mysql_fetch_assoc($company);
    $catg = $object['product_name']; 
    return $catg;
}

function getPriceCkt($id) {
    $select_price = "SELECT sum(quantity * unit_price) as sub_total FROM sohorepro_checkout WHERE user_id = '".$id."'" ;
    $price = mysql_query($select_price);
    while ($object = mysql_fetch_assoc($price)):
        $value[] = $object;
    endwhile;
    return $value;
}


function totalCart($id) {
    $select_price = "SELECT sum(quantity) as cart FROM sohorepro_checkout WHERE user_id = '".$id."'" ;
    $price = mysql_query($select_price);
    $object = mysql_fetch_assoc($price);
    $catg = $object['cart'];
    return $catg;
}


function checkMail($id) 
    {
    $select_mail = "SELECT * FROM sohorepro_customers WHERE cus_email = '$id' ";
    $mail = mysql_query($select_mail);
    while ($object = mysql_fetch_assoc($mail)):
        $value[] = $object;
    endwhile;
    return $value;
    }
    
function checkcomp($id) 
    {
    $select_mail = "SELECT * FROM sohorepro_company WHERE comp_name = '$id' ";
    $mail = mysql_query($select_mail);
    while ($object = mysql_fetch_assoc($mail)):
        $value[] = $object;
    endwhile;
    return $value;
    }


    
    
    
//Find Company ID    
function compName($company_name) {
    $company_name   =   strtolower(mysql_real_escape_string($company_name));
    $comp_id = "SELECT comp_id FROM sohorepro_company WHERE comp_name = '".$company_name."'";
    $company = mysql_query($comp_id);
    $object = mysql_fetch_assoc($company);
    $catg = $object['comp_id']; 
    return $catg;
}

function COMPID($user_id) {
    $comp_id = "SELECT cus_compname FROM sohorepro_customers WHERE cus_id = '".$user_id."'";
    $company = mysql_query($comp_id);
    $object = mysql_fetch_assoc($company);
    $catg = $object['cus_compname']; 
    return $catg;
}

//Find State ID    
function State_Val($state_name) {
    $state_name   =   strtolower(mysql_real_escape_string($state_name));
    $state_id = "SELECT state_id FROM sohorepro_states WHERE state_abbr = '".$state_name."'";
    $company = mysql_query($state_id);
    $object = mysql_fetch_assoc($company);
    $catg = $object['state_id']; 
    return $catg;
}

function StateName($state_id) {    
    $state_id = "SELECT state_abbr FROM sohorepro_states WHERE state_id = '".$state_id."'";
    $company = mysql_query($state_id);
    $object = mysql_fetch_assoc($company);
    $catg = $object['state_abbr']; 
    return $catg;
}

function StateAll(){
    $select_state = "SELECT * FROM sohorepro_states";
    $state = mysql_query($select_state);
    while ($object = mysql_fetch_assoc($state)):
        $value[] = $object;
    endwhile;
    return $value;
    }

function EmpEntry() {
    $state_id = "SELECT * FROM sohorepro_customers WHERE cus_email = ''";
    $company = mysql_query($state_id);
    $object = mysql_fetch_assoc($company);
    $catg = $object['cus_pass']; 
    return $catg;
}

function company_id($id) {
    $state_id = "SELECT * FROM sohorepro_customers WHERE cus_id = '".$id."' ";
    $company = mysql_query($state_id);
    $object = mysql_fetch_assoc($company);
    $catg = $object['cus_compname']; 
    return $catg;
}

//All Shipping Address
function ShippingAddress($id) 
    {
    $select_mail = "SELECT * FROM sohorepro_address WHERE comp_id = '$id' AND type= '0' AND prop = '0' ";
    $mail = mysql_query($select_mail);
    while ($object = mysql_fetch_assoc($mail)):
        $value[] = $object;
    endwhile;
    return $value;
    }
    
function ShippingAddressAll($id) 
    {
    $select_mail = "SELECT * FROM sohorepro_address WHERE comp_id = '$id'";   
    $mail = mysql_query($select_mail);
    while ($object = mysql_fetch_assoc($mail)):
        $value[] = $object;
    endwhile;
    return $value;
    }
    
function ShipAddNewSup() 
    {
    $select_mail = "SELECT * FROM sohorepro_address WHERE id = '38'";   
    $mail = mysql_query($select_mail);
    while ($object = mysql_fetch_assoc($mail)):
        $value[] = $object;
    endwhile;
    return $value;
    }
    
 function SelectIdAddress($id) 
    {
    $select_mail = "SELECT * FROM sohorepro_address WHERE id = '$id'";
    $mail = mysql_query($select_mail);
    while ($object = mysql_fetch_assoc($mail)):
        $value[] = $object;
    endwhile;
    return $value;
    }   
    
//Primary Shipping Address 
function PrimaryShipping($id) 
    {
    $select_mail = "SELECT * FROM sohorepro_address WHERE comp_id = '$id' AND type ='1' ";
    $mail = mysql_query($select_mail);
    while ($object = mysql_fetch_assoc($mail)):
        $value[] = $object;
    endwhile;
    return $value;
    }
    
function PrimaryShipping_test($id) 
    {
    $select_mail = "SELECT * FROM sohorepro_address WHERE id = '$id' ";
    $mail = mysql_query($select_mail);
    while ($object = mysql_fetch_assoc($mail)):
        $value[] = $object;
    endwhile;
    return $value;
    }
    
//Select Shipping Address
function SelectShippingAddress($id) 
    {
    $select_mail = "SELECT * FROM sohorepro_address WHERE comp_id = '$id' AND type = '0' ";
    $mail = mysql_query($select_mail);
    while ($object = mysql_fetch_assoc($mail)):
        $value[] = $object;
    endwhile;
    return $value;
    }

function editAddress($id) {
    $select_products = "SELECT * FROM sohorepro_address WHERE id = '".$id."'";
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}

function UpdatedAddress($id) {
    $select_products = "SELECT * FROM sohorepro_address WHERE id = '".$id."' AND type = '1' ";
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}

function SelectAllAddress($id) {
    $select_products = "SELECT * FROM sohorepro_address WHERE id = '".$id."'";
    $products = mysql_query($select_products);
    while ($object = mysql_fetch_assoc($products)):
        $value[] = $object;
    endwhile;
    return $value;
}

function CompanyAddress($id) {
    $select_products = "SELECT * FROM sohorepro_address WHERE comp_id = '".$id."'";
    $products = mysql_query($select_products);
    $object = mysql_fetch_assoc($products);
    $catg = $object; 
    return $catg;
}

function CompanyAddressMail($id) {
    $select_products = "SELECT * FROM sohorepro_address WHERE id = '".$id."'";
    $products = mysql_query($select_products);
    $object = mysql_fetch_assoc($products);
    $catg = $object; 
    return $catg;
}

function PropTest($id) {
    $select_products = "SELECT * FROM sohorepro_address WHERE id = '".$id."' AND prop = '1' ";
    $products = mysql_query($select_products);
    $object = mysql_fetch_assoc($products);
    $catg = $object; 
    return $catg;
}

// Random Password Generate:
function randomPassword() {
    $alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 4; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}
 //Login User Functions

//Super Admin Login Function.
function CheckUser($user,$pass) {
    $select_user = "SELECT * FROM sohorepro_users WHERE user_name = '".$user."' AND password = '".$pass."' AND status = '1'";
    $user = mysql_query($select_user);
    while ($object = mysql_fetch_assoc($user)):
        $value[] = $object;
    endwhile;
   return $value;
} 

//User Functions
function AllUsers() {
    $select_user = "SELECT * FROM sohorepro_users WHERE type != '1' ";
    $user = mysql_query($select_user);
    while ($object = mysql_fetch_assoc($user)):
        $value[] = $object;
    endwhile;
   return $value;
} 

//Edit User
function editUsersType($id) {
    $select_user = "SELECT * FROM sohorepro_users WHERE id = '".$id."'";
    $user = mysql_query($select_user);
    while ($object = mysql_fetch_assoc($user)):
        $value[] = $object;
    endwhile;
    return $value;
}

//Staff User Select for Drop Down
function StaffUser() {
    $select_user = "SELECT * FROM sohorepro_users WHERE type = '2' ORDER BY initials ASC ";
    $user = mysql_query($select_user);
    while ($object = mysql_fetch_assoc($user)):
        $value[] = $object;
    endwhile;
    return $value;
}

function StaffDetails($users) {
    $select_user = "SELECT * FROM sohorepro_users WHERE id = '".$users."' AND status = '1' ";
    $user = mysql_query($select_user);
    while ($object = mysql_fetch_assoc($user)):
        $value[] = $object;
    endwhile;
    return $value;
}

//Select Customer for Supply Side

function SupplyCustomer() {
    $select_user = "SELECT * FROM sohorepro_company WHERE status = '1' ";
    $user = mysql_query($select_user);
    while ($object = mysql_fetch_assoc($user)):
        $value[] = $object;
    endwhile;
    return $value;
}


//Select Customer for Supply Side continue shopping

function SupplyUsrContShopp($comp_id,$usr_id) {
    $select_user = "SELECT * FROM sohorepro_customers WHERE cus_compname ='".$comp_id."' AND cus_id = '".$usr_id."' AND cus_status = '1' ";
    $user = mysql_query($select_user);
    while ($object = mysql_fetch_assoc($user)):
        $value[] = $object;
    endwhile;
    return $value;
}

//Select Guest Items
function GuestItems($staff_id) {
    $select_items = "SELECT * FROM sohorepro_checkout_guest WHERE staff_id = '".$staff_id."' ";
    $items = mysql_query($select_items);
    while ($object = mysql_fetch_assoc($items)):
        $value[] = $object;
    endwhile;
    return $value;
}

//Select Temp Items for user side
function ItemsTemp($ip) {
    $select_items = "SELECT * FROM sohorepro_checkout_guest WHERE ip = '".$ip."' ";
    $items = mysql_query($select_items);
    while ($object = mysql_fetch_assoc($items)):
        $value[] = $object;
    endwhile;
    return $value;
}

function OrderCommentShopp($user_id) {
    $select_commt = "SELECT * FROM sohorepro_cust_commt WHERE cus_id = '".$user_id."' " ;
    $commt = mysql_query($select_commt);
    while ($object = mysql_fetch_assoc($commt)):
        $value[] = $object;
    endwhile;
    return $value;
}
?>
