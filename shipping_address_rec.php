<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);


if (isset($_POST['shipping_id_rp']) && $_POST['shipping_id_rp'] != '') {
    $shipp_add = SelectIdAddressService($_POST['shipping_id_rp']);
    if ($shipp_add != '') {
        $add_1 = ($shipp_add[0]['address_1'] == '') ? '' : $shipp_add[0]['address_1'];
        $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'];
        $add_3 = ($shipp_add[0]['address_3'] == '') ? '' : $shipp_add[0]['address_3'];
        ?>
        <div style="width: 100%;float: left">            
                   <!-- Address 1 Start -->
            <div style="width: 100%;float: left;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_1_span_<?php echo $_POST['shipping_id_rp']; ?>" onclick="return show_address_recipient_1('<?php echo $_POST['shipping_id_rp']; ?>');"><?php echo $add_1; ?></span>
            <input style="width: 70%;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_1_<?php echo $_POST['shipping_id_rp']; ?>" id="address_1_<?php echo $_POST['shipping_id_rp']; ?>" value="<?php echo $add_1; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_1_buttons_<?php echo $_POST['shipping_id_rp']; ?>">
                <!--<img src="admin/images/like_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Update" title="Update" width="20" height="20" id="1" onclick="return update_address_1('<?php echo $_POST['shipping_id_rp']; ?>');" >-->
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_1('<?php echo $_POST['shipping_id_rp']; ?>');" >
            </div>
            </div>
            <!-- Address 1 End -->
            
            <!-- Address 2 Start -->
            <div style="width: 100%;float: left;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_2_span_<?php echo $_POST['shipping_id_rp']; ?>" onclick="return show_address_recipient_2('<?php echo $_POST['shipping_id_rp']; ?>');"><?php echo $add_2; ?></span>
            <input style="width: 70%;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_2_<?php echo $_POST['shipping_id_rp']; ?>" id="address_2_<?php echo $_POST['shipping_id_rp']; ?>" value="<?php echo $add_2; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_2_buttons_<?php echo $_POST['shipping_id_rp']; ?>">
                <!--<img src="admin/images/like_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Update" title="Update" width="20" height="20" id="1" onclick="return update_address_2('<?php echo $_POST['shipping_id_rp']; ?>');" >-->
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_2('<?php echo $_POST['shipping_id_rp']; ?>');" >
            </div>
            </div>
            <!-- Address 2 End -->
            
            <?php if($shipp_add[0]['address_3'] != ''){?>
            <!-- Address 3 Start -->
            <div style="width: 100%;float: left;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_3_span_<?php echo $_POST['shipping_id_rp']; ?>" onclick="return show_address_recipient_3('<?php echo $_POST['shipping_id_rp']; ?>');"><?php echo $add_3; ?></span>
            <input style="width: 70%;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_3_<?php echo $_POST['shipping_id_rp']; ?>" id="address_3_<?php echo $_POST['shipping_id_rp']; ?>" value="<?php echo $add_3; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_3_buttons_<?php echo $_POST['shipping_id_rp']; ?>">
                <!--<img src="admin/images/like_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Update" title="Update" width="20" height="20" id="1" onclick="return update_address_3('<?php echo $_POST['shipping_id_rp']; ?>');" >-->
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_3('<?php echo $_POST['shipping_id_rp']; ?>');" >
            </div>
            </div>
            <!-- Address 3 End -->
            <?php } ?>
            
            <!-- City Startjjj -->
            <div style="float: left;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_city_span_<?php echo $_POST['shipping_id_rp']; ?>" onclick="return show_address_recipient_city('<?php echo $_POST['shipping_id_rp']; ?>');"><?php echo $shipp_add[0]['city']; ?></span>
            <input style="width: 35%;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_city_<?php echo $_POST['shipping_id_rp']; ?>" id="address_city_<?php echo $_POST['shipping_id_rp']; ?>" value="<?php echo $shipp_add[0]['city']; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_city_buttons_<?php echo $_POST['shipping_id_rp']; ?>">
                <!--<img src="admin/images/like_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Update" title="Update" width="20" height="20" id="1" onclick="return update_address_city('<?php echo $_POST['shipping_id_rp']; ?>');" >-->
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_city('<?php echo $_POST['shipping_id_rp']; ?>');" >
            </div>
            </div>
            <!-- City End -->
            
            <!-- State Zip Start -->
            <div style="float: left;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_city_span_<?php echo $_POST['shipping_id_rp']; ?>" onclick="return show_address_recipient_state('<?php echo $_POST['shipping_id_rp']; ?>');"><?php echo ',&nbsp;'.StateName($shipp_add[0]['state']).'&nbsp;'.$shipp_add[0]['zip']; ?></span>            
            </div>
            <!-- State Zip End -->                
            </div>

            
        <?php
        echo '~'.$shipp_add[0]['attention_to'];
        //echo $add_1.$add_2.$shipp_add[0]['city'].'<br>'.StateName($shipp_add[0]['state']).',&nbsp;'.$shipp_add[0]['zip'].'~'.$shipp_add[0]['attention_to'];
    }
}
?>
