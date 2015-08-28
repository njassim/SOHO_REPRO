<?php
include './config.php';

if(isset($_POST['fname']) && $_POST['fname'] != '')
{
  $id               = $_POST['id'];   
  $fname            = ($_POST['fname'] == '')? ' ': $_POST['fname'];  
  $query = "UPDATE sohorepro_customers
			SET     cus_fname = '" . $fname . "' WHERE cus_id = '".$id."'";
  mysql_query($query);    
  echo $fname;    
}


if(isset($_POST['lname']) && $_POST['lname'] != '')
{
  $id               = $_POST['id'];   
  $lname            = $_POST['lname'];  
  $query = "UPDATE sohorepro_customers
			SET     cus_lname = '" . $lname . "' WHERE cus_id = '".$id."'";
  mysql_query($query);    
  echo $lname;    
}

if(isset($_POST['email']) && $_POST['email'] != '')
{
  $id               = $_POST['id'];   
  $email            = $_POST['email'];  
  $query = "UPDATE sohorepro_customers
			SET     cus_email = '" . $email . "' WHERE cus_id = '".$id."'";
  mysql_query($query);    
  echo $email;    
}

if(isset($_POST['phone']) && $_POST['phone'] != '')
{
  $id               = $_POST['id'];   
  $phone            = $_POST['phone'];  
  $query = "UPDATE sohorepro_customers
			SET     cus_contact_phone = '" . $phone . "' WHERE cus_id = '".$id."'";
  mysql_query($query);    
  echo $phone;    
}

if(isset($_POST['status']) && $_POST['status'] != '')
{
  $id               = $_POST['copmany_id'];   
  $status           = $_POST['status'];  
  $query = "UPDATE sohorepro_company
			SET     status = '" . $status . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo $status;    
}

if(isset($_POST['bus_company_name']) && $_POST['bus_company_name'] != '')
{
  $id                   = $_POST['id'];   
  $bus_company_name     = $_POST['bus_company_name'];  
  $query = "UPDATE sohorepro_company
			SET     comp_name = '" . $bus_company_name . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo $bus_company_name;    
}

if(isset($_POST['bus_address_1']))
{
  $id                   = $_POST['id'];   
  $empty                = '&nbsp;&nbsp;';
  $bus_address1         = ($_POST['bus_address_1'] == '  ') ? $empty : $_POST['bus_address_1'];  
  $query = "UPDATE sohorepro_company
			SET     comp_business_address1 = '" . $bus_address1 . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo $bus_address1;    
}

if(isset($_POST['bus_address_2']) && $_POST['bus_address_2'] != '')
{
  $id                   = $_POST['id'];   
  $bus_address2         = $_POST['bus_address_2'];  
  $query = "UPDATE sohorepro_company
			SET     comp_business_address2 = '" . $bus_address2 . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo $bus_address2;    
}

if(isset($_POST['bus_address_3']) && $_POST['bus_address_3'] != '')
{
  $id                   = $_POST['id'];   
  $bus_address3         = $_POST['bus_address_3'];  
  $query = "UPDATE sohorepro_company
			SET     comp_business_address3 = '" . $bus_address3 . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo $bus_address3;    
}

if(isset($_POST['bus_city']) && $_POST['bus_city'] != '')
{
  $id                   = $_POST['id'];   
  $bus_city             = $_POST['bus_city'];  
  $query = "UPDATE sohorepro_company
			SET     comp_city = '" . $bus_city . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo $bus_city;    
}

if(isset($_POST['bus_zip']) && $_POST['bus_zip'] != '')
{
  $id                   = $_POST['id'];   
  $bus_zip              = $_POST['bus_zip'];  
  $query = "UPDATE sohorepro_company
			SET     comp_zipcode = '" . $bus_zip . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo $bus_zip;    
}

if(isset($_POST['state_val']) && $_POST['state_val'] != '')
{
  $id                   = $_POST['id'];   
  $state              = $_POST['state_val'];  
  $query = "UPDATE sohorepro_company
			SET     comp_state = '" . $state . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo $state;    
}

if(isset($_POST['bus_phone']) && $_POST['bus_phone'] != '')
{
  $id                   = $_POST['id'];   
  $phone                = $_POST['bus_phone'];  
  $query = "UPDATE sohorepro_company
			SET     comp_contact_phone = '" . $phone . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo $phone;    
}

if(isset($_POST['bus_fax']) && $_POST['bus_fax'] != '')
{
  $id                   = $_POST['id'];   
  $fax                = $_POST['bus_fax'];  
  $query = "UPDATE sohorepro_company
			SET     comp_contact_fax = '" . $fax . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo $fax;    
}

if(isset($_POST['tax_val']) && $_POST['tax_val'] != '')
{
  $id                   = $_POST['id'];   
  $tax                  = $_POST['tax_val'];
  $tax_ret              = ($_POST['tax_val'] == '1') ? 'Yes':'No';
  $query = "UPDATE sohorepro_company
			SET     tax_exe = '" . $tax . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo $tax_ret;    
}
?>
