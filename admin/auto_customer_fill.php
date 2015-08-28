<?php
include './config.php';
include './db_connection.php';


$customer_name        =       $_POST['search'];

$auto_customer        =       AutoCustomer($customer_name);
if(count($auto_customer) > 0){
?>   
<ul class="auto_reference">
<?php
foreach ($auto_customer as $ref){
    $cus_name = mysql_real_escape_string($ref['comp_name']);
?>
    <li><span onclick="return get_customer_name('<?php echo $cus_name; ?>');"><?php echo $ref['comp_name']; ?></span></li>
<?php
}
?>
</ul>
<?php
}
