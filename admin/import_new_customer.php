<?php

include './config.php';

function SelectNewCustomer() {
    $select_cus = "SELECT * FROM sohorepro_company_rep";
    $cus = mysql_query($select_cus);
    while ($object = mysql_fetch_assoc($cus)):
        $value[] = $object;
    endwhile;
    return $value;
}

$new_customer = SelectNewCustomer();




//foreach ($new_customer as $customer) {
//    $check_company_name = checkcomp($customer['comp_name']);
//    if (count($check_company_name) < 1) {
//        $query = "INSERT INTO sohorepro_company SET
//                                comp_name                     = '" . $customer['comp_name'] . "',
//                                comp_contact_name             = '" . $customer['comp_contact_name'] . "',
//                                comp_contact_email            = '" . $customer['comp_contact_email'] . "',
//                                comp_contact_phone            = '" . $customer['comp_contact_phone'] . "',
//                                comp_contact_fax              = '" . $customer['comp_contact_fax'] . "',
//                                comp_business_address1        = '" . $customer['comp_business_address1'] . "',
//                                comp_business_address2        = '" . $customer['comp_business_address2'] . "',
//                                comp_business_address3        = '" . $customer['comp_business_address3'] . "',
//                                comp_city                     = '" . $customer['comp_city'] . "',
//                                comp_state                    = '" . $customer['comp_state'] . "',
//                                comp_zipcode                  = '" . $customer['comp_zipcode'] . "',
//                                status                        = '" . $customer['status'] . "'    ";
//        mysql_query($query);
//    }
//    
//}

foreach ($new_customer as $customer) {
    $check_company_name = checkcomp($customer['comp_name']);
    $comp_name = compName($customer['comp_name']);
    if (count($check_company_name) < 1) {
        $query = "INSERT INTO sohorepro_address SET comp_id  = '" . $comp_name . "',
                                    company_name                = '" . $customer['company_name'] . "',
                                    contact_name                = '" . $customer['comp_contact_name'] . "',
                                    address_1                   = '" . $customer['comp_business_address1'] . "',
                                    address_2                   = '" . $customer['comp_business_address1'] . "',
                                    city                        = '" . $customer['status'] . "',
                                    state                       = '" . $customer['status'] . "',
                                    zip                         = '" . $customer['status'] . "',    
                                    attention_to                = '" . $customer['status'] . "',
                                    type                        = '1'    ";
        mysql_query($query);
    }
}