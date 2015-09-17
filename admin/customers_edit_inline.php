<?php
include './config.php';
include './mail_template.php';

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
  $id                   = $_POST['id'];   
  $email                = $_POST['email'];
  $check_email_exist    = "SELECT * FROM sohorepro_customers WHERE cus_email = '".$email."' AND cus_id <> '".$id."' ";
  $val_mail = mysql_query($check_email_exist);
  $num_rows = mysql_num_rows($val_mail);
  if($num_rows > 0){
  echo "0";  
  }else{
  $query = "UPDATE sohorepro_customers
			SET     cus_email = '" . $email . "' WHERE cus_id = '".$id."'";
  mysql_query($query);    
  echo $email;     
  }
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


if(isset($_POST['password_value']) && $_POST['password_value'] != '')
{
  $id               = $_POST['id'];   
  $password_value   = $_POST['password_value'];  
  $query = "UPDATE sohorepro_customers
			SET     cus_pass = '" . $password_value . "' WHERE cus_id = '".$id."'";
  mysql_query($query);    
  echo $password_value;    
}


if(isset($_POST['resend_company_id']) && $_POST['resend_company_id'] != '')
{
  $company_id               = $_POST['resend_company_id'];   
  $customer_id              = $_POST['resend_customer_id']; 
  $send_mail                = ResendCredentials($customer_id);
  if($send_mail){
      echo 'User name and Password sent Successfully';
  }  else {
      echo 'User name and Password not sent';
  }
}

if(isset($_POST['delete_ind_cus_id']) && $_POST['delete_ind_cus_id'] != '')
{ 
  $customer_id              = $_POST['delete_ind_cus_id']; 
  $query = "DELETE FROM sohorepro_customers WHERE cus_id = '".$customer_id."'";
  $result = mysql_query($query);
  if($result){
      echo '1';
  }  else {
      echo '0';
  }
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

if(isset($_POST['cust_company_name']) && $_POST['cust_company_name'] != '')
{
  $id                   = $_POST['id'];   
  $bus_company_name     = $_POST['cust_company_name'];  
  $query = "UPDATE sohorepro_company
			SET     cust_id = '" . $bus_company_name . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo $bus_company_name;    
}



if(isset($_POST['del_company_name']) && $_POST['del_company_name'] != '')
{
  $id                   = $_POST['id'];   
  $del_company_name     = $_POST['del_company_name'];  
  $query = "UPDATE sohorepro_address
			SET     company_name = '" . $del_company_name . "' WHERE comp_id = '".$id."' AND type ='1'";
  mysql_query($query);    
  echo $del_company_name;    
}

if(isset($_POST['del_address_1']))
{
  $id                   = $_POST['id'];   
  $empty                = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  $del_address1         = ($_POST['del_address_1'] == '') ? $empty : $_POST['del_address_1']; 
  $check_address        =  CheckDeliveryAddress($id);
  if(count($check_address) == '1'){
  $query = "UPDATE sohorepro_address
			SET     address_1 = '" . $del_address1 . "' WHERE comp_id = '".$id."' AND type ='1'";
  mysql_query($query);    
  }  else {
  $query = "INSERT INTO sohorepro_address
			SET     address_1 = '" . $del_address1 . "', comp_id = '".$id."', type ='1'";
  mysql_query($query);    
  }
  echo $del_address1;    
}


if(isset($_POST['bus_address_1']))
{
  $id                   = $_POST['id'];   
  $empty                = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  $bus_address1         = ($_POST['bus_address_1'] == '') ? $empty : $_POST['bus_address_1'];  
  $query = "UPDATE sohorepro_company
			SET     comp_business_address1 = '" . $bus_address1 . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo $bus_address1;    
}



if(isset($_POST['bus_address_2']) && $_POST['bus_address_2'] != '')
{
  $id                   = $_POST['id'];   
 // $bus_address2         = $_POST['bus_address_2'];  
  $empty                = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  $bus_address2         = ($_POST['bus_address_2'] == '') ? $empty : $_POST['bus_address_2'];  
  
  $query = "UPDATE sohorepro_company
			SET     comp_business_address2 = '" . $bus_address2 . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  
  echo $bus_address2;    
}

if(isset($_POST['bus_address_3']) && $_POST['bus_address_3'] != '')
{
  $id                   = $_POST['id'];   
  $empty                = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  $bus_address3         = ($_POST['bus_address_3'] == '') ? $empty : $_POST['bus_address_3'];
  $query = "UPDATE sohorepro_company
			SET     comp_room = '" . $bus_address3 . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo $bus_address3;    
}


if(isset($_POST['bus_suit']) && $_POST['bus_suit'] != '')
{
  $id                   = $_POST['id'];   
  $empty                = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  $bus_suit             = ($_POST['bus_suit'] == '') ? $empty : $_POST['bus_suit'];
  $query = "UPDATE sohorepro_company
			SET     comp_room = '" . $bus_suit . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo $bus_suit;    
}


if(isset($_POST['del_suit']) && $_POST['del_suit'] != '')
{
  $id                   = $_POST['id'];   
  $empty                = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  $bus_suit             = ($_POST['del_suit'] == '') ? $empty : $_POST['del_suit'];
  $query = "UPDATE sohorepro_address
			SET     suite = '" . $bus_suit . "' WHERE comp_id = '".$id."' AND type ='1'";
  mysql_query($query);    
  echo $bus_suit;    
}


if(isset($_POST['del_address_2']) && $_POST['del_address_2'] != '')
{
  $id                   = $_POST['id'];   
  //$del_address2         = $_POST['del_address_2'];  
  
  $empty                = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  $del_address2         = ($_POST['del_address_2'] == '') ? $empty : $_POST['del_address_2'];  
  $check_address        =  CheckDeliveryAddress($id);
  if(count($check_address) == '1'){
  $query = "UPDATE sohorepro_address
			SET     address_2 = '" . $del_address2 . "' WHERE comp_id = '".$id."' AND type ='1'";
  mysql_query($query);
  }else{
  $query = "INSERT INTO sohorepro_address
			SET     address_2 = '" . $del_address2 . "', comp_id = '".$id."', type ='1'";
  mysql_query($query); 
  }
  echo $del_address2;    
}

if(isset($_POST['del_address_3']) && $_POST['del_address_3'] != '')
{
  $id                   = $_POST['id'];   
  //$del_address3         = $_POST['del_address_3'];  
  
  $empty                = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  $del_address3         = ($_POST['del_address_3'] == '') ? $empty : $_POST['del_address_3']; 
  $check_address        =  CheckDeliveryAddress($id);
  if(count($check_address) == '1'){
  $query = "UPDATE sohorepro_address
			SET     suite = '" . $del_address3 . "' WHERE comp_id = '".$id."' AND type ='1'";
  mysql_query($query);
  }else{
  $query = "INSERT INTO sohorepro_address
			SET     suite = '" . $del_address3 . "', comp_id = '".$id."', type ='1'";
  mysql_query($query);    
  }
  echo $del_address3;    
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


if(isset($_POST['del_city']) && $_POST['del_city'] != '')
{
  $id                   = $_POST['id'];   
  $del_city             = $_POST['del_city'];  
  $check_address        =  CheckDeliveryAddress($id);
  if(count($check_address) == '1'){
  $query = "UPDATE sohorepro_address
			SET     city = '" . $del_city . "' WHERE comp_id = '".$id."' AND type ='1'";
  mysql_query($query);  
  }else{
  $query = "INSERT INTO sohorepro_address
			SET     city = '" . $del_city . "', comp_id = '".$id."', type ='1'";
  mysql_query($query);      
  }
  echo $del_city;    
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

if(isset($_POST['bus_zip_ext']) && $_POST['bus_zip_ext'] != '')
{
  $id                   = $_POST['id'];   
  $bus_zip_ext          = $_POST['bus_zip_ext'];  
  if($bus_zip_ext == 'EMPTY')
  {
  $bus_zip_ext = ($bus_zip_ext == 'EMPTY') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $bus_zip_ext;
  }
  if($bus_zip_ext == '0000')
  {
  $bus_zip_ext = ($bus_zip_ext == '0000') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $bus_zip_ext;
  }
  $query = "UPDATE sohorepro_company
			SET     comp_zipcode_ext = '" . $bus_zip_ext . "' WHERE comp_id = '".$id."'";
  mysql_query($query);    
  echo '-'.$bus_zip_ext;    
}


if(isset($_POST['bus_del_zip']) && $_POST['bus_del_zip'] != '')
{
  $id                   = $_POST['id'];   
  $del_zip              = $_POST['bus_del_zip'];
  $check_address        =  CheckDeliveryAddress($id);
  if(count($check_address) == '1'){
  $query = "UPDATE sohorepro_address
			SET     zip = '" . $del_zip . "' WHERE comp_id = '".$id."' AND type ='1'";
  mysql_query($query); 
  }else{
  $query = "INSERT INTO sohorepro_address
			SET     zip = '" . $del_zip . "', comp_id = '".$id."', type ='1'";
  mysql_query($query);   
  }
  echo $del_zip;    
}

if(isset($_POST['bus_zip_del_ext']) && $_POST['bus_zip_del_ext'] != '')
{
  $id                   = $_POST['id'];   
  $bus_zip_del_ext      = $_POST['bus_zip_del_ext'];
  $check_address        =  CheckDeliveryAddress($id);
   if($bus_zip_del_ext == 'EMPTY')
  {
  $bus_zip_del_ext = ($bus_zip_del_ext == 'EMPTY') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $bus_zip_del_ext;
  }
    if($bus_zip_del_ext == '0000')
  {
  $bus_zip_del_ext = ($bus_zip_del_ext == '0000') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $bus_zip_del_ext;
  }
    if(count($check_address) == '1'){
  $query = "UPDATE sohorepro_address
			SET     zip_ext = '" . $bus_zip_del_ext . "' WHERE comp_id = '".$id."' AND type ='1'";
  mysql_query($query);  
  }  else {
   $query = "INSERT INTO sohorepro_address
			SET     zip_ext = '" . $bus_zip_del_ext . "', comp_id = '".$id."', type ='1'";
  mysql_query($query);    
  }
  echo '-'.$bus_zip_del_ext;    
}


if(isset($_POST['bus_zip_del_ext_adb']) && $_POST['bus_zip_del_ext_adb'] != '')
{
  $id                   = $_POST['id'];   
  $bus_zip_del_ext      = $_POST['bus_zip_del_ext_adb'];  
  $query = "UPDATE sohorepro_address
			SET     zip_ext = '" . $bus_zip_del_ext . "' WHERE id = '".$id."' ";
  mysql_query($query);    
  echo '-'.$bus_zip_del_ext;    
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

if(isset($_POST['del_state_val']) && $_POST['del_state_val'] != '')
{
  $id                   = $_POST['id'];   
  $state                = StateId($_POST['del_state_val']); 
  $check_address        =  CheckDeliveryAddress($id);
  if(count($check_address) == '1'){
  $query = "UPDATE sohorepro_address
			SET     state = '" . $state . "' WHERE comp_id = '".$id."' AND type ='1'";
  mysql_query($query);    
  }else{
  $query = "INSERT INTO sohorepro_address
			SET     state = '" . $state . "', comp_id = '".$id."', type ='1'";
  mysql_query($query);       
  }
  echo $_POST['del_state_val'];    
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


if(isset($_POST['bus_del_phone']) && $_POST['bus_del_phone'] != '')
{
  $id                   = $_POST['id'];   
  $phone                = $_POST['bus_del_phone'];  
  $check_address        =  CheckDeliveryAddress($id);
  if(count($check_address) == '1'){
  $query = "UPDATE sohorepro_address
			SET     phone = '" . $phone . "' WHERE comp_id = '".$id."' AND type ='1'";
  mysql_query($query);   
  }else{
  $query = "INSERT INTO sohorepro_address
			SET     phone = '" . $phone . "', comp_id = '".$id."', type ='1'";
  mysql_query($query);        
  }
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

if(isset($_POST['tax_exempt_number']) && $_POST['tax_exempt_number'] != '')
{
  $id                   = $_POST['id'];   
  $tax_exempt_number    = $_POST['tax_exempt_number'];
  $query = "UPDATE sohorepro_company
			SET     tax_exempt_number = '" . $tax_exempt_number . "' WHERE comp_id = '".$id."'";
  $result = mysql_query($query);    
  if($result){
      echo $tax_exempt_number;    
  }
  
}

if(isset($_POST['adb_company_name']) && $_POST['adb_company_name'] != '')
{
  $id                   = $_POST['id'];   
  $adb_company_name     = str_replace("and", "&", $_POST['adb_company_name']);  
  $query = "UPDATE sohorepro_address
			SET     company_name = '" . $adb_company_name . "' WHERE id = '".$id."' ";
  mysql_query($query);    
  echo $adb_company_name;    
}


if(isset($_POST['adb_address_1']) && $_POST['adb_address_1'] != '')
{
  $id                   = $_POST['id'];   
  $adb_address_1        = str_replace("and", "&", $_POST['adb_address_1']);  
  $query = "UPDATE sohorepro_address
			SET     address_1 = '" . $adb_address_1 . "' WHERE id = '".$id."' ";
  mysql_query($query);    
  echo $adb_address_1;    
}


if(isset($_POST['adb_address_2']) && $_POST['adb_address_2'] != '')
{
  $id                   = $_POST['id'];   
  $adb_address_2        = str_replace("and", "&", $_POST['adb_address_2']);  
  $query = "UPDATE sohorepro_address
			SET     address_2 = '" . $adb_address_2 . "' WHERE id = '".$id."' ";
  mysql_query($query);    
  echo $adb_address_2;    
}

if(isset($_POST['adb_address_3']) && $_POST['adb_address_3'] != '')
{
  $id                   = $_POST['id'];   
  $adb_address_3        = str_replace("and", "&", $_POST['adb_address_3']);  
  $query = "UPDATE sohorepro_address
			SET     address_3 = '" . $adb_address_3 . "' WHERE id = '".$id."' ";
  mysql_query($query);    
  echo $adb_address_3;    
}


if(isset($_POST['adb_city']) && $_POST['adb_city'] != '')
{
  $id                   = $_POST['id'];   
  $adb_city             = $_POST['adb_city'];  
  $query = "UPDATE sohorepro_address
			SET     city = '" . $adb_city . "' WHERE id = '".$id."'";
  mysql_query($query);    
  echo $adb_city;    
}

if(isset($_POST['adb_state_val']) && $_POST['adb_state_val'] != '')
{
  $id                   = $_POST['id'];   
  $state                = $_POST['adb_state_val'];   
  $state_value          = StateId($state);  
  $query = "UPDATE sohorepro_address
			SET     state = '" . $state_value . "' WHERE id = '".$id."'";
  mysql_query($query);    
  echo $state;    
}


if(isset($_POST['adb_zip']) && $_POST['adb_zip'] != '')
{
  $id                   = $_POST['id'];   
  $adb_zip              = $_POST['adb_zip'];  
  $query = "UPDATE sohorepro_address
			SET     zip = '" . $adb_zip . "' WHERE id = '".$id."'";
  mysql_query($query);    
  echo $adb_zip;    
}


if(isset($_POST['adb_phone']) && $_POST['adb_phone'] != '')
{
  $id                   = $_POST['id'];   
  $phone                = $_POST['adb_phone'];  
  $query = "UPDATE sohorepro_address
			SET     phone = '" . $phone . "' WHERE id = '".$id."'";
  mysql_query($query);    
  echo $phone;    
}


if(isset($_POST['attention_to']) && $_POST['attention_to'] != '')
{
  $id                   = $_POST['id'];   
  $attention_to         = $_POST['attention_to'];  
  $query = "UPDATE sohorepro_address
			SET     attention_to = '" . $attention_to . "' WHERE id = '".$id."'";
  mysql_query($query);    
  echo $attention_to;    
}


if(isset($_POST['delete_shipp_id']) && $_POST['delete_shipp_id'] != '')
{
  $id                   = $_POST['delete_shipp_id'];  
  $query = "DELETE FROM sohorepro_address WHERE id = '".$id."'";
  $result = mysql_query($query);
  if($result){
    echo '1';
  }else {
    echo '0';  
  }
}

?>
