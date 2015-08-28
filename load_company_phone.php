<?php
include './admin/config.php';
include './admin/db_connection.php';

//Retrive the company name using search field
if(isset($_GET['q']))
{
$search = $_GET['q'];

if($_GET['q']!='')
{
$select_company = mysql_query("select * from sohorepro_company where status = '1' AND comp_contact_phone like '$search%' ");
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

$select_company = mysql_query("select * from sohorepro_company where status = '1' AND comp_contact_phone ='$search'  ");

$str_comp='';

$fth_comp=  mysql_fetch_array($select_company);

if(mysql_num_rows($select_company) > 0)
{
$state_comp = StateName($fth_comp['comp_state']);
$str_comp .= ($fth_comp['comp_name'] == '') ? 'NIL^^^^' : $fth_comp['comp_name']."^^^^";
$str_comp .= ($fth_comp['comp_contact_phone'] == '') ? 'NIL^^^^' : "YES-RESULT^^^^";
$str_comp .= ($fth_comp['comp_business_address1'] == '') ? '&nbsp;^^^^' :$fth_comp['comp_business_address1']."^^^^";
$str_comp .= ($fth_comp['comp_business_address2'] == '') ? '^^^^' : $fth_comp['comp_business_address2']."^^^^";
$str_comp .= ($fth_comp['comp_room'] == '') ? '&nbsp;^^^^' : $fth_comp['comp_room']."^^^^";
$str_comp .= ($fth_comp['comp_suite'] == '') ? '&nbsp;^^^^' : $fth_comp['comp_suite']."^^^^";
$str_comp .= ($fth_comp['comp_floor'] == '') ? '&nbsp;^^^^' : $fth_comp['comp_floor']."^^^^";
$str_comp .= ($fth_comp['comp_city'] == '') ? '&nbsp;^^^^' : $fth_comp['comp_city']."^^^^";
$str_comp .= ($fth_comp['comp_state'] == '') ? '&nbsp;^^^^' : $fth_comp['comp_state'].'&nbsp;'."^^^^";
$str_comp .= ($fth_comp['comp_zipcode'] == '') ? '&nbsp;^^^^' :$fth_comp['comp_zipcode']."^^^^";
$str_comp .= ($fth_comp['comp_phone1'] == '') ? '&nbsp;^^^^' : $fth_comp['comp_phone1']."^^^^";
$str_comp .= ($fth_comp['comp_phone2'] == '') ? '&nbsp;^^^^' : $fth_comp['comp_phone2']."^^^^";
$str_comp .= ($fth_comp['comp_phone3'] == '') ? '&nbsp;^^^^' : $fth_comp['comp_phone3']."^^^^";
$str_comp .= ($fth_comp['comp_phone4'] == '') ? '&nbsp;^^^^' : $fth_comp['comp_phone4']."^^^^";
$str_comp .= ($fth_comp['tax_exe'] == '') ? '&nbsp;^^^^' : $fth_comp['tax_exe']."^^^^";
$str_comp .= ($fth_comp['comp_id'] == '') ? '&nbsp;^^^^' : $fth_comp['comp_id']."^^^^";
$str_comp .= companyName($fth_comp['comp_id']);
//$str_comp   =substr($str_comp,0,strlen($str_comp)-4);

echo $str_comp;
}  else {
    echo 'NO-RESULT';    
}

}

?>