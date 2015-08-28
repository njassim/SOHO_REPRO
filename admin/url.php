<?php

echo $company_phone_raw = "2124883119".'<br>';

$contact_phone_1 = substr($company_phone_raw, 0, 3);
$contact_phone_2 = substr($company_phone_raw, 3, 3);
$contact_phone_3 = substr($company_phone_raw, 6, 9);
echo $company_phone = $contact_phone_1 . '-' . $contact_phone_2 . '-' . $contact_phone_3;

//print_r($_REQUEST);
//if($_REQUEST['url'] == '1'){
//    //echo 'JASS';
//$website = $_POST["website"];
//if (!preg_match("/^[a-zA-Z]+[:\/\/]+[A-Za-z0-9\-_]+\\.+[A-Za-z0-9\.\/%&=\?\-_]+$/i",$website))
//  {
//    echo "Invalid URL"; 
//  }  else {
//      echo 'Correct';    
//  }
//}
?>
<form method="post" name="test_url" action="">
    <input type="hidden" name="url" value="1" />
    <input type="text" name="website" id="website" />
    <input type="submit" />
</form>