<?php
include './admin/config.php';
include './admin/db_connection.php';

//Retrive the company name using search field
if(isset($_GET['q']))
{
$search = $_GET['q'];

if($_GET['q']!='')
{
$select_company = mysql_query("select * from sohorepro_company where comp_status=0 and (comp_name like '$search%' or comp_contact_phone like '$search%' or comp_phone1 like '$search%' or comp_phone2 like '$search%' or comp_phone3 like '$search%' or comp_phone4 like '$search%') ");
if(mysql_num_rows($select_company))
  { 
    echo "<span style='color:#02A05B;padding-left:5px;font-size: 18px;'>Company found</span>";
    echo "<script>load_companyinfo();</script>";
  }
 else 
     {
    echo "<span style='color:#FF0000;padding-left:5px;font-size: 18px;'>Company not found.</span>"; 
    echo "<script>load_companyinfo();</script>";
  }
}

}



//Retrive the company data to load the form
if(isset($_REQUEST['cid']))
{
$search = $_REQUEST['cid'];

$select_company = mysql_query("select * from sohorepro_company where comp_status=0 and (comp_contact_phone ='$search')  ");

$str_comp='';

$fth_comp=  mysql_fetch_array($select_company);

if(mysql_num_rows($select_company))
{
$str_comp .= $fth_comp['comp_name']."^^^^";
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
$str_comp .= $fth_comp['tax_exe']."^^^^";
$str_comp=substr($str_comp,0,strlen($str_comp)-4);

echo $str_comp;
}

}

?>