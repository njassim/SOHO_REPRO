<?php 
include './config.php';

if(isset($_POST['comp_id']) && $_POST['comp_id'] != '')
{
    $company_id         = $_POST['comp_id'];
    $customer_id        = $_POST['cust_id'];
    $type               = $_POST['account_type'];
    $update_exist_user  = "UPDATE sohorepro_customers SET cus_manager = '0' WHERE cus_compname = '".$company_id."' ";
    mysql_query($update_exist_user);
    $update_new_user    = "UPDATE sohorepro_customers SET cus_manager = '".$type."' WHERE cus_id = '".$customer_id."' ";
    mysql_query($update_new_user);
    $query              = "select * from sohorepro_customers where cus_id ='".$customer_id."' AND cus_compname ='".$company_id."' "; 
    $res                = mysql_query($query);
    $object             = mysql_fetch_assoc($res);
    $cus_type           = $object['cus_manager'];
    echo 'That user settes as a Admin Manager'.'~';
}
?>
<table border="0" width="320" height="70" class="cust_edit_tab">
            <?php if (mysql_num_rows($res) > 0) { ?>
                <tr>
                <span class="main_id" id="<?php echo $company_id; ?>_<?php echo $customer_id; ?>"></span>
                <td class="inf">First Name</td>
                <td align="left" width="170">
                    <span class="cus_fname_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_fname_<?php echo $company_id; ?>_<?php echo $customer_id; ?>"><?php echo $object['cus_fname']; ?></span>
                    <input type="text" class="inline-text-cus none cus_fname_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_fname_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" value="<?php echo $object['cus_fname']; ?>" />
                </td>
                </tr>
                <tr>
                    <td class="inf">Last Name</td>
                    <td align="left" width="170">
                        <span class="cus_lname_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_lname_<?php echo $company_id; ?>_<?php echo $customer_id; ?>"><?php echo $object['cus_lname']; ?></span>
                        <input type="text" class="inline-text-cus none cus_lname_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_lname_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" value="<?php echo $object['cus_lname']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="inf">Email ID</td>
                    <td align="left" width="170">
                        <span class="cus_email_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_email_<?php echo $company_id; ?>_<?php echo $customer_id; ?>"><?php echo $object['cus_email']; ?></span>
                        <input type="text" class="inline-text-cus none cus_email_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_email_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" value="<?php echo $object['cus_email']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="inf">Phone Number</td>
                    <td align="left" width="170">
                        <span class="cus_phone_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_phone_<?php echo $company_id; ?>_<?php echo $customer_id; ?>"><?php echo $object['cus_phone1']; ?></span>
                        <input type="text" class="phone inline-text-cus none cus_phone_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_phone_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" value="<?php echo $object['cus_phone1']; ?>" />
                    </td>
                </tr>
                <tr><span class="copm_id none" id="<?php echo $company_id; ?>"></span>
                <span class="cust_id none" id="<?php echo $customer_id; ?>"></span>
                <td class="inf">Set as Manager</td>
                <td align="left" width="170"><input type="checkbox" <?php if ($cus_type == '1') {
                    echo 'disabled=disabled';
                } ?> name="manager" id="manager" class="manager manager_input" value="1" <?php if ($cus_type == '1') {
                    echo 'checked=checked';
                } ?>></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <span class="edit_cust_dtls cus_btn_edit edit_<?php echo $company_id; ?>_<?php echo $customer_id; ?>">Edit</span>
                        <span class="svae_cus_dtls cus_btn_edit none save_<?php echo $company_id; ?>_<?php echo $customer_id; ?>">Save</span>
                        <span class="delete_cust_dtls cus_btn_edit">Delete</span></td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td class="inf" colspan="2" align="center">Select customer name.</td>        
                </tr>
    <?php } ?>
        </table>


<script language="javascript" src="js/customer.js"></script>