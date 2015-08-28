<?php

include './config.php';

if (isset($_POST['id']) && $_POST['id'] != '') {
    $id = explode("_", $_POST['id']);
    $comp_id = $id[0];
    $cus_id = $id[1];
    $query = "DELETE FROM sohorepro_customers WHERE cus_compname = '".$comp_id."' AND cus_id = '".$cus_id."'";
    mysql_query($query);
    echo 'User deleted successfully'.'~';
}
?>
<?php $customer_per_company = custPerComp($comp_id);?>
<select name="customer_name" id="<?php echo $comp_id; ?>" class="customer_name_<?php echo $comp_id; ?> select_customer">
<option value="0">--Customers--</option>                                                                                                
<?php foreach ($customer_per_company as $customers) { ?>
<option value="<?php echo $customers['cus_id'];?>"><?php echo $customers['cus_contact_name']; ?></option>
    <?php } ?>                                                                                               
</select> 

<?php echo '~'; ?>

<table border="0" width="320" height="70" class="cust_edit_tab">
    <tr>
        <td class="inf"  align="center">Select customer name.</td>        
    </tr>    
</table>

<script language="javascript" src="js/customer.js"></script>