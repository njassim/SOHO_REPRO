<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);


if (isset($_POST['shipping_id_rp']) && $_POST['shipping_id_rp'] != '') {
    $option_id          =   $_POST['option_id'];
    $shipp_add          = SelectIdAddressService($_POST['shipping_id_rp']);
    $address_book_se    = $_POST['shipping_id_rp'];
    $last_option        = EnteredPlotRecipientsTotalOptions($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $increment_option   = ($last_option[0]['options']);
    if ($shipp_add != '') {
        $add_1 = ($shipp_add[0]['address_1'] == '') ? '' : $shipp_add[0]['address_1'];
        $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'];
        $add_3 = ($shipp_add[0]['address_3'] == '') ? '' : $shipp_add[0]['address_3'];
        ?>
        <div id="show_address_inside_<?php echo $option_id; ?>" style="width: 100%;float: left;border: 1px solid #F99B3E;padding: 6px;">            
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
            
            <?php if($add_3 != ''){?>
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
            
            <div style="width:100%;float: left;font-weight: bold;">
                <span style="font-weight: bold;float: left;cursor: pointer;" id="address_city_span_<?php echo $_POST['shipping_id_rp']; ?>" onclick="return show_address_recipient_city('<?php echo $_POST['shipping_id_rp']; ?>');"><?php echo $shipp_add[0]['city']; ?>,&nbsp;</span>
                <input style="display: none;float: left;width: 65px;" type="text" id="address_city_<?php echo $_POST['shipping_id_rp']; ?>" value="<?php echo $shipp_add[0]['city']; ?>" />
                <div style="display: none;float: left;" id="address_city_buttons_<?php echo $_POST['shipping_id_rp']; ?>">               
                    <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_city('<?php echo $_POST['shipping_id_rp']; ?>');" >
                </div>
                <span style="font-weight: bold;float: left;cursor: pointer;" id="address_state_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_state('<?php echo $address_book_se; ?>');"><?php echo StateName($shipp_add[0]['state']); ?>&nbsp;</span>
                <select name="state" id="address_state_select_<?php echo $address_book_se; ?>" style="display: none;float: left;margin-left: 5px;">
                    <?php
                $state = StateAll();                
                foreach ($state as $state_val) {
                    if ($state_val['state_abbr'] == StateName($shipp_add[0]['state'])) {
                        ?>
                        <option value="<?php echo $state_val['state_abbr'] ?>" selected="selected"><?php echo $state_val['state_abbr']; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $state_val['state_abbr']; ?>"><?php echo $state_val['state_abbr']; ?></option>
                        <?php
                    }
                }
                ?>
                </select>
                
                <span style="font-weight: bold;float: left;cursor: pointer;" id="address_zip_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_zip('<?php echo $address_book_se; ?>');"><?php echo $shipp_add[0]['zip']; ?></span>
                <input style="width: 45px;float: left;margin-bottom: 0px;margin-left: 10px;padding: 2px;display: none;"  type="text" name="address_zip_<?php echo $address_book_se; ?>" id="address_zip_<?php echo $address_book_se; ?>" value="<?php echo $shipp_add[0]['zip']; ?>" />
                <div style="float: left;display: none;" id="address_zip_buttons_<?php echo $address_book_se; ?>">                
                    <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_zip('<?php echo $address_book_se; ?>');" >
                </div>
            </div>
            
            <!-- City Start -->
<!--            <div style="float: left;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_city_span_<?php echo $_POST['shipping_id_rp']; ?>" onclick="return show_address_recipient_city('<?php echo $_POST['shipping_id_rp']; ?>');"><?php echo $shipp_add[0]['city']; ?></span>
            <input style="width: 40% !important;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_city_<?php echo $_POST['shipping_id_rp']; ?>" id="address_city_<?php echo $_POST['shipping_id_rp']; ?>" value="<?php echo $shipp_add[0]['city']; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_city_buttons_<?php echo $_POST['shipping_id_rp']; ?>">               
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_city('<?php echo $_POST['shipping_id_rp']; ?>');" >
            </div>
            </div>-->
            <!-- City End -->
            
            
            <div style="float: left;">
                <!-- State Start -->
<!--                <span style="width: 6%;float: left;font-weight: bold;cursor: pointer;" id="address_state_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_state('<?php echo $address_book_se; ?>');"><?php echo ',&nbsp;'.StateName($shipp_add[0]['state']); ?></span>            
                <select name="state" id="address_state_select_<?php echo $address_book_se; ?>" style="display: none;float: left;">
                    <?php
                $state = StateAll();                
                foreach ($state as $state_val) {
                    if ($state_val['state_abbr'] == StateName($shipp_add[0]['state'])) {
                        ?>
                        <option value="<?php echo $state_val['state_abbr'] ?>" selected="selected"><?php echo $state_val['state_abbr']; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $state_val['state_abbr']; ?>"><?php echo $state_val['state_abbr']; ?></option>
                        <?php
                    }
                }
                ?>
                </select>-->
                <!-- State End -->    
                
                <!-- ZIP Start -->
<!--                <span style="width: 6%;float: left;font-weight: bold;cursor: pointer;margin-left: 22px;" id="address_zip_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_zip('<?php echo $address_book_se; ?>');"><?php echo $shipp_add[0]['zip']; ?></span>
                
                <input style="width: 20%;float: left;margin-bottom: 0px;font-size: 12px !important;margin-left: 10px;display: none;"  type="text" name="address_zip_<?php echo $address_book_se; ?>" id="address_zip_<?php echo $address_book_se; ?>" value="<?php echo $shipp_add[0]['zip']; ?>" />
                <div style="width: 20%;float: left;display: none;" id="address_zip_buttons_<?php echo $address_book_se; ?>">
                    <img src="admin/images/like_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Update" title="Update" width="20" height="20" id="1" onclick="return update_address_city('<?php echo $address_book_se; ?>');" >
                    <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="17" height="17" id="1" onclick="return cancel_address_zip('<?php echo $address_book_se; ?>');" >
                </div>-->
                <!-- ZIP End-->
            </div>
            
            
            <!-- Phone Start -->
            <div style="float: left;width: 100%;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_phone_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_phone('<?php echo $address_book_se; ?>');"><?php echo $shipp_add[0]['phone']; ?></span>
            <input style="width: 35%;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_phone_<?php echo $address_book_se; ?>" id="address_phone_<?php echo $address_book_se; ?>" value="<?php echo $shipp_add[0]['phone']; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_phone_buttons_<?php echo $address_book_se; ?>">                
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_phone('<?php echo $address_book_se; ?>');" >
            </div>
            </div>
            <!-- Phone End -->
            
            
            
            
            </div>
            <div id="show_address_buttons_to_<?php echo $address_book_se; ?>" style="width: 100%;float: left;border: 1px solid #F99B3E;text-align: center;height: 15px !important;padding: 6px;height: 20px;font-weight: bold;background-color: #F99B3E;display: none;">
                <span id="save_only_<?php echo $option_id; ?>" style="border: 1px solid #FFEEE1;font-weight: bold;border-radius: 5px;padding: 3px;background-color: #FFEEE1;cursor: pointer;" onclick="return update_exist_address('<?php echo $address_book_se; ?>');">Save</span>
                <span id="show_save_new_<?php echo $option_id; ?>" style="border: 1px solid #34A853;font-weight: bold;border-radius: 5px;padding: 3px;background-color: #34A853;color: #FFF;cursor: pointer;" onclick="return save_new_address('<?php echo $address_book_se; ?>', '<?php echo $option_id; ?>');">Save as New</span>
                <span id="show_save_new_cancel_<?php echo $option_id; ?>" style="border: 1px solid #D84B36;font-weight: bold;border-radius: 5px;padding: 3px;background-color: #D84B36;color: #FFF;display: none;cursor: pointer;" onclick="return save_new_address_cancel('<?php echo $address_book_se; ?>', '<?php echo $option_id; ?>');">Cancel</span>
                <span id="save_new_<?php echo $option_id; ?>" style="border: 1px solid #34A853;font-weight: bold;border-radius: 5px;padding: 3px;background-color: #34A853;color: #FFF;display: none;cursor: pointer;" onclick="return save_new_record('<?php echo $address_book_se; ?>', '<?php echo $option_id; ?>');">Save as New</span>
            </div>
            
            
            
        <?php
        echo '~'.$shipp_add[0]['attention_to'].'~'.$increment_option;
        //echo $add_1.$add_2.$shipp_add[0]['city'].'<br>'.StateName($shipp_add[0]['state']).',&nbsp;'.$shipp_add[0]['zip'].'~'.$shipp_add[0]['attention_to'];
    }
}
?>
