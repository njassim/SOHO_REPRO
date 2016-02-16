<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);


if ($_POST['address_closer'] == '1_1') {
    $address_id = $_POST['address_id'];
    $current_address = SelectIdAddressService($address_id);
    ?>
<div id="add_new_address_block_<?php echo $address_id; ?>" style="width: 100%;float: left;">
        <div style="width: 48%;float: left;">
            <span style="width: 100%;float: left;">Company Name:</span>
            <input style="margin-bottom: 0px !important;" type="text" name="company_name" id="company_name_closer_<?php echo $address_id; ?>" value="<?php echo $current_address[0]['company_name']; ?>" />
        </div>
        <div style="width: 48%;float: left;">
            <span style="width: 100%;float: left;">Attention_To:</span>
            <input style="margin-bottom: 0px !important;" type="text" name="attention_to_closer" id="attention_to_closer_<?php echo $address_id; ?>" value="<?php echo $current_address[0]['attention_to']; ?>" />
        </div>
        <div style="width: 48%;float: left;">
            <span style="width: 100%;float: left;">Address1:</span>
            <input style="margin-bottom: 0px !important;" type="text" name="address_1_closer" id="address_1_closer_<?php echo $address_id; ?>" value="<?php echo $current_address[0]['address_1']; ?>" />
        </div>
        <div style="width: 48%;float: left;">
            <span style="width: 100%;float: left;">Address2:</span>
            <input style="margin-bottom: 0px !important;" type="text" name="address_2_closer" id="address_2_closer_<?php echo $address_id; ?>" value="<?php echo $current_address[0]['address_2']; ?>" />
        </div>
        <div style="width: 48%;float: left;">
            <span style="width: 100%;float: left;">Address3:</span>
            <input style="margin-bottom: 0px !important;" type="text" name="address_3_closer" id="address_3_closer_<?php echo $address_id; ?>" value="<?php echo $current_address[0]['address_3']; ?>" />
        </div>
        <div style="width: 48%;float: left;">
            <span style="width: 100%;float: left;">City:</span>
            <input style="margin-bottom: 0px !important;" type="text" name="city_closer" id="city_closer_<?php echo $address_id; ?>" value="<?php echo $current_address[0]['city']; ?>" />
        </div>
        <div style="width: 20%;float: left;">
            <span style="width: 100%;float: left;">State:</span>
            <select name="state" id="state_closer_<?php echo $address_id; ?>" style="padding: 0px !important;width: 75% !important;">
                <option value="0">--</option>
               <?php 
               $state_all = StateAll();
               foreach ($state_all as $state) { ?>
                        <option value="<?php echo $state['state_id'] ?>" <?php if($current_address[0]['state'] == $state['state_id']){?> selected="selected" <?php } ?>><?php echo $state['state_abbr']; ?></option>
                    <?php } ?>
               </select>
        </div>
        <div style="width: 15%;float: left;margin-right: 10px;">
            <span style="width: 100%;float: left;">Zip:</span>
            <input style="margin-bottom: 0px !important;" type="text" name="company_zip_closer" id="company_zip_closer_<?php echo $address_id; ?>" value="<?php echo $current_address[0]['zip']; ?>" />
        </div>
        <div style="width: 35%;float: left;">
            <span style="width: 100%;float: left;">Phone:</span>
            <input style="margin-bottom: 0px !important;" type="text" name="company_phone_closer" id="company_phone_closer_<?php echo $address_id; ?>" value="<?php echo $current_address[0]['phone']; ?>" />
        </div>
    </div>
    <?php
}
?>
