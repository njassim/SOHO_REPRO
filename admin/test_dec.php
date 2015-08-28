<?php
include './config.php';




function jassim() {
    $select_check = "SELECT * FROM sohorepro_company";
    $check = mysql_query($select_check);
    while ($object = mysql_fetch_assoc($check)):
        $value[] = $object;
    endwhile;
    return $value;
}

$test = jassim();

foreach ($test as $data){
    echo 'company_id:'.$data['comp_id'].'<br>';
    $query="INSERT INTO sohorepro_address SET                            
    comp_id          = '".$data['comp_id']."',
    company_name     = 'Pick up  Soho Reprographics',
    attention_to     = '381 Broome St',   
    zip              = '10013',
    state            = '33',
    city             = 'New York',
    prop             = '1' ";
    mysql_query($query);
}
//foreach ($test as $data){
//    
//$query="INSERT INTO sohorepro_special_pricing SET                            
//sp_user_id          = '20',
//sp_product_id          = '".$data['sp_product_id']."',
//sp_list_price          = '".$data['sp_list_price']."',   
//sp_discount            = '".$data['sp_discount']."',
//sp_special_price       = '".$data['sp_special_price']."'";
//mysql_query($query);
//    
//}

?>
