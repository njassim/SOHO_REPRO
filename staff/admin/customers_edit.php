<?php
include './config.php';
include './auth.php';
if (isset($_POST['cust_id']) && $_POST['cust_id'] != '') {
    $company_id = $_POST['id'];
    $customer_id = $_POST['cust_id'];
    $query = "select * from sohorepro_customers where cus_id ='" . $customer_id . "' AND cus_compname ='" . $company_id . "' ";
    $res = mysql_query($query);
    $object = mysql_fetch_assoc($res);
    $cus_type = $object['cus_manager'];
    $cus_status = $object['cus_status'];
    $id_comp  = $object['cus_id'];
    ?>
    <div id="msg_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" class="cus_adm_succ"></div>
    <div id="user_details_<?php echo $company_id; ?>_<?php echo $customer_id; ?>">
        <table border="0" width="320" height="70" class="cust_edit_tab">
            <?php if (mysql_num_rows($res) > 0) { ?>
                <tr>
                <span class="main_id" id="<?php echo $company_id; ?>_<?php echo $customer_id; ?>"></span>
                <td class="inf">First Name</td>
                <td align="left" width="170">
                    <span class="edit_fname cus_fname_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_fname_<?php echo $company_id; ?>_<?php echo $customer_id; ?>"><?php echo $object['cus_fname']; ?></span>
                    <input type="text" class="inline-text-cus none inline_height cus_fname_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_fname_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" value="<?php echo $object['cus_fname']; ?>" />
                    <div style="float: left; margin-left: 5px;"><img src="images/like_icon.png"  alt="Update" title="Update" width="22" height="22" class="fnupdate fn_update_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" style="display: none;"/></div>
                    <div style="float: left; margin-left: 5px;"><img src="images/cancel_icon.png"  alt="Cancel" title="Cancel" width="22" height="22" class="fncancel fn_cancel_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" style="display: none;"/></div></td>
                </td>
                </tr>
                <tr>
                    <td class="inf">Last Name</td>
                    <td align="left" width="170">
                        <span class="edit_lname cus_lname_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_lname_<?php echo $company_id; ?>_<?php echo $customer_id; ?>"><?php echo $object['cus_lname']; ?></span>
                        <input type="text" class="inline-text-cus none cus_lname_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_lname_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" value="<?php echo $object['cus_lname']; ?>" />
                        <div style="float: left; margin-left: 5px;"><img src="images/like_icon.png"  alt="Update" title="Update" width="22" height="22" class="lnupdate ln_update_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" style="display: none;"/></div>
                        <div style="float: left; margin-left: 5px;"><img src="images/cancel_icon.png"  alt="Cancel" title="Cancel" width="22" height="22" class="lncancel ln_cancel_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" style="display: none;"/></div></td>
                    </td>
                </tr>
                <tr>
                    <td class="inf">Email</td>
                    <td align="left" width="170">
                        <span class="edit_email cus_email_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_email_<?php echo $company_id; ?>_<?php echo $customer_id; ?>"><?php echo $object['cus_email']; ?></span>
                        <input type="text" class="inline-text-cus none cus_email_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_email_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" value="<?php echo $object['cus_email']; ?>" />
                        <div style="float: left; margin-left: 5px;"><img src="images/like_icon.png"  alt="Update" title="Update" width="22" height="22" class="emupdate em_update_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" style="display: none;"/></div>
                        <div style="float: left; margin-left: 5px;"><img src="images/cancel_icon.png"  alt="Cancel" title="Cancel" width="22" height="22" class="emcancel em_cancel_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" style="display: none;"/></div></td>
                    </td>
                </tr>
                <tr>
                    <td class="inf">Phone</td>
                    <td align="left" width="170">
                        <span class="edit_phone cus_phone_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_phone_<?php echo $company_id; ?>_<?php echo $customer_id; ?>"><?php echo $object['cus_contact_phone']; ?></span>
                        <input type="text" class="phone inline-text-cus none cus_phone_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" id="cus_phone_txt_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" value="<?php echo $object['cus_contact_phone']; ?>" />
                        <div style="float: left; margin-left: 5px;"><img src="images/like_icon.png"  alt="Update" title="Update" width="22" height="22" class="phupdate ph_update_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" style="display: none;"/></div>
                        <div style="float: left; margin-left: 5px;"><img src="images/cancel_icon.png"  alt="Cancel" title="Cancel" width="22" height="22" class="phcancel ph_cancel_<?php echo $company_id; ?>_<?php echo $customer_id; ?>" style="display: none;"/></div></td>
                    </td>
                </tr>
                <tr>
                <td class="inf">Admin</td>                
                <td align="left" width="170">
                    <span class="copm_id none" id="<?php echo $company_id; ?>"></span>
                    <span class="customer_id none" id="<?php echo $id_comp; ?>"></span>
                    <input type="checkbox" <?php if ($cus_type == '1') {echo 'disabled=disabled';} ?> name="manager" id="manager" class="manager manager_input" value="1" <?php if ($cus_type == '1') {echo 'checked=checked';} ?>></td>
                </tr>                 
            <?php } else { ?>
                <tr>
                    <td class="inf" colspan="2" align="center">Select customer name.</td>        
                </tr>
    <?php } ?>
        </table>
    </div>
<?php } ?>


<script language="javascript" src="js/phnovalid.js"></script>
<script language="javascript" src="js/customer.js"></script>
<script language="javascript" src="js/phone.js"></script>