<?php
include './config.php';


function CustomersAll() {
    $select_category = "SELECT * FROM sohorepro_company ORDER BY comp_name ASC";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}



$all_customers = CustomersAll();


//echo '<pre>';
//print_r($all_customers);
//echo '</pre>';

foreach ($all_customers as $customers){
    
    $comp_name = mysql_real_escape_string($customers['comp_name']);
    
    $query = "UPDATE sohorepro_company
			SET     cust_id = '" . $comp_name . "' WHERE comp_id = '".$customers['comp_id']."'";
    $result = mysql_query($query);  
    
}

if($result){
        echo 'Updated Successfully';
    }