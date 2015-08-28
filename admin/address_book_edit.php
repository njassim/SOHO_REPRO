<?php
include './config.php';
include './auth.php';
if (isset($_POST['address_book_id']) && $_POST['address_book_id'] != '') {
    
    $address_id     =   $_POST['address_book_id'];
    
    $select_address = SelectIdAddress($address_id);
    
    $company_name   =   ($select_address[0]['company_name'] != '') ? $select_address[0]['company_name'] : $select_address[0]['company_name'];
    $att            =   ($select_address[0]['attention_to'] != '') ? $select_address[0]['attention_to'] : $select_address[0]['attention_to'];
    $add1           =   ($select_address[0]['address_1'] != '') ? $select_address[0]['address_1'] : $select_address[0]['address_1'];
    $add2           =   ($select_address[0]['address_2'] != '') ? $select_address[0]['address_2'] : $select_address[0]['address_2'];
    $add3           =   ($select_address[0]['address_3'] != '') ? $select_address[0]['address_3'] : $select_address[0]['address_3'];
    $phone          =   ($select_address[0]['phone'] != '') ? $select_address[0]['phone'] : $select_address[0]['phone'];
    $csz            =   $select_address[0]['city'].',  '.StateName($select_address[0]['state']).'&nbsp;'.$select_address[0]['zip'];
    $devilery_zip_ext = ($select_address[0]['zip_ext'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $select_address[0]['zip_ext'] ;
    $state          =   StateName($select_address[0]['state']);
    $company_id     =   CompIdFromAddress($address_id);
    if(count($select_address) > 0){  
    ?>
    <?php 
        //echo $company_name.$add1.$add2.$add3.$csz.$phone;
        //echo $company_name.$add1.$add2.$add3.$csz.$phone;
    ?>
    <table width="100%" border="0">
        <?php $company_name = ($select_address[0]['company_name'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $select_address[0]['company_name']; ?>
        <tr>
            <td>
                <span style="float: left;"><strong>C :&nbsp;</strong></span><span class="pointer edit_adb_cn add_book_cn_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>"><?php echo $company_name; ?></span>
                <span style="float:left;" class="none add_book_lbl_<?php echo $address_id; ?>"></span><input style="float:left;width:140px;" type="text" class="none add_book_txt_<?php echo $address_id; ?>" id="add_book_txt_<?php echo $address_id; ?>" value="<?php echo $select_address[0]['company_name']; ?>" />
                <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="cn_adb_update cn_adb_update_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></div>
                <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="cn_adb_cancel cn_adb_cancel_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></div>
            </td>
        </tr>
        
        <?php $att = ($select_address[0]['attention_to'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $select_address[0]['attention_to']; ?>
        <tr>
            <td>
                <span style="float: left;"><strong>Att :&nbsp;</strong></span><span class="pointer edit_adb_att add_book_att_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>"><?php echo $att; ?></span>
                <input style="float:left;width:135px;" type="text" class="none add_book_att_txt_<?php echo $address_id; ?>" id="add_book_att_txt_<?php echo $address_id; ?>" value="<?php echo $att; ?>" />
                <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="cn_att_update cn_att_update_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></div>
                <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="cn_att_cancel cn_att_cancel_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></div>
            </td>
        </tr>
        <?php $add1 = ($select_address[0]['address_1'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $select_address[0]['address_1']; ?>
        <tr>
            <td>
                <strong style="float: left;">A1 :&nbsp;</strong><span class="pointer edit_adb_ad1 add_book_ad1_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>"><?php echo $add1; ?></span>
                <input style="float:left;width:135px;" type="text" class="none add_book_ad1_txt_<?php echo $address_id; ?>" id="add_book_ad1_txt_<?php echo $address_id; ?>" value="<?php echo $select_address[0]['address_1']; ?>" />
                <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="adb_ad1_update adb_ad1_update_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></div>
                <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="adb_ad1_cancel adb_ad1_cancel_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></div>
            </td>
        </tr>
        <?php $add2 = ($select_address[0]['address_2'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $select_address[0]['address_2']; ?>
        <tr>
            <td>                
                <strong style="float: left;">A2 :&nbsp;</strong><span class="pointer edit_adb_ad2 add_book_ad2_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>"><?php echo $add2; ?></span>
                <span style="float:left;" class="none add_book_ad2_lbl_<?php echo $address_id; ?>"></span><input style="float:left;width:135px;" type="text" class="none add_book_ad2_txt_<?php echo $address_id; ?>" id="add_book_ad2_txt_<?php echo $address_id; ?>" value="<?php echo $select_address[0]['address_2']; ?>" />
                <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="adb_ad2_update adb_ad2_update_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></div>
                <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="adb_ad2_cancel adb_ad2_cancel_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></div>
            </td>
        </tr>
       <?php $add3 = ($select_address[0]['address_3'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $select_address[0]['address_3']; ?>
        <tr>
            <td>               
                <strong style="float: left;">A3 :&nbsp;</strong><span class="pointer edit_adb_ad3 add_book_ad3_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>"><?php echo $add3; ?></span>
                <span style="float:left;" class="none add_book_ad3_lbl_<?php echo $address_id; ?>"></span><input style="float:left;width:135px;" type="text" class="none add_book_ad3_txt_<?php echo $address_id; ?>" id="add_book_ad3_txt_<?php echo $address_id; ?>" value="<?php echo $select_address[0]['address_3']; ?>" />
                <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="adb_ad3_update adb_ad3_update_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></div>
                <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="adb_ad3_cancel adb_ad3_cancel_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></div>
            </td>
        </tr>
        
       <?php $select_address_city = ($select_address[0]['city'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $select_address[0]['city']; ?>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                <span class="pointer adb_city_inline adb_city_inline_span_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>"><?php echo $select_address_city; ?></span>,
                <input style="float:left; width: 60px;" type="text" class="none adb_city_inline_txt_<?php echo $address_id; ?>" id="adb_city_inline_txt_<?php echo $address_id; ?>" value="<?php echo $select_address[0]['city']; ?>" />
                <span style="float:left;"><img src="images/like_icon.png" style="display: none;" alt="Update" title="Update" width="22" height="22" class="city_update_abd city_update_abd_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></span>
                <span style="float:left;"><img src="images/cancel_icon.png"  style="display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="city_cancel_abd city_cancel_abd_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></span>
                        </td>
                        <td>
                <span style="cursor: pointer;" class="adb_stat_inline adb_stat_inline_span_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>"><?php echo $state; ?></span>
                <select name="adb_state" id="<?php echo $address_id; ?>" class="none adb_state adb_stat_inline_txt_<?php echo $address_id; ?>" >                    
                    <?php
                    $state_abbr = StateAll();
                    foreach ($state_abbr as $state_val) {
                        if ($state_val['state_abbr'] == $state) {
                            ?>
                            <option value="<?php echo $state_val['state_abbr'] ?>" selected="selected"><?php echo $state_val['state_abbr']; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $state_val['state_abbr']; ?>"><?php echo $state_val['state_abbr']; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>&nbsp;
                </td>
                <td>
                    <?php $select_address_zip = ($select_address[0]['zip'] == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $select_address[0]['zip']; ?>
                <span style="cursor: pointer;margin-left: -5px;" class="adb_zip_inline adb_zip_inline_span_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>"><?php echo $select_address_zip; ?></span>
                <input style="width: 40px;" type="text" class="none adb_zip adb_zip_inline_txt_<?php echo $address_id; ?>" id="adb_zip_inline_txt_<?php echo $address_id; ?>" value="<?php echo $select_address[0]['zip']; ?>" />
                <span style=""><img src="images/cancel_icon.png"  style="display: none;float: right;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_cancel_abd zip_cancel_abd_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></span>
                <span style=""><img src="images/like_icon.png" style="display: none;float: right;" alt="Update" title="Update" width="22" height="22" class="zip_update_abd_ zip_update_abd_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></span>
                 </td>
                <td>
                <span style="cursor: pointer;margin-left: 0px;" class="zip_inline_del_ext_abd zip_inline_span_del_ext_abd_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>"><?php echo '-'.$devilery_zip_ext; ?></span>
                <input style="width: 40px;" type="text" class="none comp_zip_del_ext_abd zip_inline_txt_del_ext_abd_<?php echo $address_id; ?>" id="zip_inline_txt_del_ext_abd_<?php echo $address_id; ?>" value="<?php echo $devilery_zip_ext; ?>" />
                <span style="float:right;"><img src="images/cancel_icon.png"  style="display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="zip_cancel_del_ext_abd zip_cancel_del_ext_abd_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></span>
                <span style="float:right;"><img src="images/like_icon.png" style="display: none;" alt="Update" title="Update" width="22" height="22" class="zip_update_del_ext_abd zip_update_del_ext_abd_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></span>
                 </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
            <td>
                <?php //echo $phone; ?>
                <strong style="float:left;">P :&nbsp;</strong><span style="cursor: pointer;" class="adb_phone_inline adb_phone_inline_span_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>"><?php echo $phone; ?></span>
                <span style="float:left;" class="none adb_phone_inline_lbl_<?php echo $address_id; ?>"></span><input style="width: 80px;" type="text" class="none adb_phone adb_phone_inline_txt_<?php echo $address_id; ?>" id="adb_phone_inline_txt_<?php echo $address_id; ?>" value="<?php echo $select_address[0]['phone']; ?>" />
                <div style="float:left; margin:0 4px"><img src="images/like_icon.png" style="margin-top:-3px;display: none;" alt="Update" title="Update" width="22" height="22" class="phone_adb_update phone_adb_update_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></div>
                <div style="float:left;  margin:0 4px"><img src="images/cancel_icon.png"  style="margin-top:-4px;display: none;"  alt="Cancel" title="Cancel" width="22" height="22" class="phone_adb_cancel phone_adb_cancel_<?php echo $address_id; ?>" id="<?php echo $address_id; ?>" /></div>
            </td>
        </tr>
        
         <tr>
            <td><span onclick="return delete_shipp_add('<?php echo $address_id; ?>','<?php echo $company_id; ?>');"  style="cursor: pointer;display: inline;background: #d3412c;float: left;padding: 2px 5px;color: #FFF;font-weight: bold;font-size: 11px;border-radius: 5px;">Delete Address</span></td>
        </tr>
    </table>
    <?php
    }
    
    
}

?>

<script language="javascript" src="js/address_book_edit.js"></script>
<script language="javascript" src="js/phnovalid.js"></script>
<script language="javascript" src="js/phone.js"></script>