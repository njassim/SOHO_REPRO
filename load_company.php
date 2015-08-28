<?php
include './admin/config.php';
include './admin/db_connection.php';

//Retrive the company name using search field
if(isset($_GET['q']))
{
$search = $_GET['q'];

$select_company = mysql_query("select * from sohorepro_company where comp_status=0 and (comp_name like '$search%' or comp_contact_phone like '$search%' or comp_phone1 like '$search%' or comp_phone2 like '$search%' or comp_phone3 like '$search%' or comp_phone4 like '$search%') ");


while($fth_comp=  mysql_fetch_array($select_company))
{
    echo $fth_comp['comp_name']."\n";
}

}



//Retrive the company data to load the form
if(isset($_REQUEST['cid']))
{
$search = $_REQUEST['cid'];

$select_company = mysql_query("select * from sohorepro_company where comp_status=0 and (comp_name='$search' or comp_contact_phone ='$search' or comp_phone1 ='$search' or comp_phone2 ='$search' or comp_phone3 ='$search' or comp_phone4 ='$search')  ");

$str_comp='';

$fth_comp=  mysql_fetch_array($select_company);

if(mysql_num_rows($select_company))
{
$str_comp .= $fth_comp['comp_name']."^^^^";
$str_comp .= $fth_comp['comp_contact_name']."^^^^";
$str_comp .= $fth_comp['comp_contact_email']."^^^^";
$str_comp .= $fth_comp['comp_contact_phone']."^^^^";
$str_comp .= $fth_comp['comp_business_address1']."^^^^";
$str_comp .= $fth_comp['comp_business_address2']."^^^^";
$str_comp .= $fth_comp['comp_room']."^^^^";
$str_comp .= $fth_comp['comp_suite']."^^^^";
$str_comp .= $fth_comp['comp_floor']."^^^^";
$str_comp .= $fth_comp['comp_city']."^^^^";
$str_comp .= $fth_comp['comp_state']."^^^^";
$str_comp .= $fth_comp['comp_zipcode']."^^^^";
$str_comp .= $fth_comp['comp_phone1']."^^^^";
$str_comp .= $fth_comp['comp_phone2']."^^^^";
$str_comp .= $fth_comp['comp_phone3']."^^^^";
$str_comp .= $fth_comp['comp_phone4']."^^^^";

$str_comp=substr($str_comp,0,strlen($str_comp)-4);

echo $str_comp;
}

}

?>