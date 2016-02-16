<div style="width:100%;float: left;font-weight: bold;">
                <span style="font-weight: bold;float: left;cursor: pointer;" id="address_city_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_city('<?php echo $address_book_se; ?>');"><?php echo $address_book[0]['city']; ?>,&nbsp;</span>
                <input style="display: none;float: left;width: 65px;" type="text" id="address_city_<?php echo $address_book_se; ?>" value="<?php echo $address_book[0]['city']; ?>" />
                <div style="display: none;float: left;" id="address_city_buttons_<?php echo $address_book_se; ?>">               
                    <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_city('<?php echo $address_book_se; ?>');" >
                </div>
                <span style="font-weight: bold;float: left;cursor: pointer;" id="address_state_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_state('<?php echo $address_book_se; ?>');"><?php echo StateName($address_book[0]['state']); ?>&nbsp;</span>
                <select name="state" id="address_state_select_<?php echo $address_book_se; ?>" style="display: none;float: left;margin-left: 5px;">
                    <?php
                $state = StateAll();                
                foreach ($state as $state_val) {
                    if ($state_val['state_abbr'] == StateName($address_book[0]['state'])) {
                        ?>
                        <option value="<?php echo $state_val['state_abbr'] ?>" selected="selected"><?php echo $state_val['state_abbr']; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $state_val['state_abbr']; ?>"><?php echo $state_val['state_abbr']; ?></option>
                        <?php
                    }
                }
                ?>
                </select>
                
                <span style="font-weight: bold;float: left;cursor: pointer;" id="address_zip_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_zip('<?php echo $address_book_se; ?>');"><?php echo $address_book[0]['zip']; ?></span>
                <input style="width: 45px;float: left;margin-bottom: 0px;margin-left: 10px;padding: 2px;display: none;"  type="text" name="address_zip_<?php echo $address_book_se; ?>" id="address_zip_<?php echo $address_book_se; ?>" value="<?php echo $address_book[0]['zip']; ?>" />
                <div style="float: left;display: none;" id="address_zip_buttons_<?php echo $address_book_se; ?>">                
                    <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_zip('<?php echo $address_book_se; ?>');" >
                </div>
            </div>



