<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);

if ($_POST['everything_return_to'] == '1') {
    $address_book_se = $_POST['address_book_se'];
    $current_option = CurrentOption($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $rem_avl_options = AvlOptionsRemaining($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    ?>   
    <div style="width: 100%;float: left;border: 0px #F99B3E solid;margin-bottom: 5px;color: #FA8526;">            
        <div style="width: 48%;float: left;text-align: left;font-weight: bold;font-size: 15px;">ALL OPTIONS</div>
        <div style="width: 48%;float: left;text-align: right;font-weight: bold;font-size: 15px;"></div>
    </div>
    <input type="hidden" name="delivery_type_option" id="delivery_type_option" value="2" />
    <div style="border: 1px #F99B3E solid;margin-bottom: 20px;padding-bottom: 20px;width: 100%;float: left;">
        <div style="width: 100%;float: left;margin-top: 10px;">
            <div style="float: left;width: 48%;margin-left: 22px;font-weight: bold;">SEND EVERYTHING TO</div>
            

            <?php
            $user_id_add_set = $_SESSION['sohorepro_userid'];
            $company_id_view_plot = $_SESSION['sohorepro_companyid'];
            ?>
            <!-- Address Show End -->
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    <?php
                        $number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid']);
                        $cust_original_order    = EnteredPlotRecipientsMulti($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid'], $_SESSION['ref_val']);
                        ?>
                        <div style="width: 100%;float: left;">                            
                            <table border="1" style="width: 100%;">
                                <tr bgcolor="#F99B3E">
                                    <td style="font-weight: bold;">Option</td> 
                                    <td style="font-weight: bold;">Originals</td> 
                                    <td style="font-weight: bold;">Sets</td> 
                                    <td style="font-weight: bold;">Order Type</td>                            
                                    <td style="font-weight: bold;">Size</td>
                                    <td style="font-weight: bold;">Output</td>
                                    <td style="font-weight: bold;">Media</td>
                                    <td style="font-weight: bold;">Binding</td>
                                    <td style="font-weight: bold;">Folding</td>
                                </tr>
                                <?php
                                foreach ($cust_original_order as $original){
                                    $cust_needed_sets       = ($original['print_ea'] != '0') ? $original['print_ea'] : $original['arch_needed'];
                                    $cust_order_type        = ($original['plot_arch'] == '0') ? 'Architectural Copies' : 'Plotting on Bond';  
                                    $size         = ($original['size'] == 'undefined') ? $original['arch_size'] : $original['size'];
                                    $output       = ($original['output'] == 'undefined') ? $original['arch_output'] : $original['output'];
                                    $media        = ($original['media'] == 'undefined') ? $original['arch_media'] : $original['media'];
                                    $binding      = ($original['binding'] == 'undefined') ? $original['arch_binding'] : $original['binding'];
                                    $folding      = ($original['folding'] == 'undefined') ? $original['arch_folding'] : $original['folding'];    
                                ?>
                                <tr bgcolor="#ffeee1">
                                    <td><?php echo $original['options']; ?></td>
                                    <td><?php echo $original['origininals']; ?></td>
                                    <td><span id="available_<?php echo $original['options']; ?>"><?php echo $cust_needed_sets; ?></span></td>
                                    <td><?php echo $cust_order_type; ?></td>                            
                                    <td><?php echo ucwords(strtolower($size)); ?></td>
                                    <td><?php echo strtoupper($output); ?></td>
                                    <td><?php echo ucfirst($media); ?></td>
                                    <td><?php echo ucfirst($binding); ?></td>
                                    <td><?php echo ucfirst($folding); ?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                
                            <?php
                            //$enteredPlot = EnteredPlotRecipients($company_id_view_plot, $user_id_add_set);
                            $enteredPlot = EnteredPlotRecipientsMulti($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid'], $_SESSION['ref_val']);
                            $i = 1;
                            foreach ($enteredPlot as $entered) {
                                $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                                $binding = strtoupper($entered['binding']);
                                $folding = strtoupper($entered['folding']);
                                $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Copies';
                                $type = ($entered['plot_arch'] == '1') ? '1' : '0';
                                $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1') : EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                                $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']) : ArchSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']);
                                $plot_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1');
                                $copy_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');                           
                            
                                if (($entered['spl_instruction'] != '') OR  ($entered['size'] == 'Custom') OR ($entered['output'] == 'Both') OR ($entered['pick_up_time'] != '0') OR ($entered['drop_off'] != '0')){
                                ?>                  
                   

                    <div style="float:left;width: 100%;font-weight: bold;color: #000;margin-top: 7px;"> OPTION <?php echo $entered['options']; ?></div>
                    <div style="width: 98%;float: left;border: 1px solid #F99B3E;padding: 5px;">     
                        <?php
                        if ($entered['size'] == 'Custom') {
                            ?>
                            <div style="width: 22%;float: left;border: 1px solid #F99B3E;margin-right: 10px;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                    Custom Size Details
                                </div>
                                <div style="padding-top: 3px;width: 100%;float: left;">
                                    <input type="hidden" name="size_custom_details" id="size_custom_details" value="<?php echo $entered['custome_details']; ?>" />
                                    <?php echo $entered['custome_details']; ?>
                                </div>
                            </div>
                            <?php
                        }
                        if ($entered['output'] == 'Both') {
                            ?>
                            <div style="width: 22%;float: left;border: 1px solid #F99B3E;margin-right: 10px;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                    Color Page Numbers
                                </div>
                                <div style="padding-top: 3px;width: 100%;float: left;">
                                    <input type="hidden" name="output_page_details" id="output_page_details" value="<?php echo $entered['output_both']; ?>" />
                                    <?php echo $entered['output_both']; ?>
                                </div>
                            </div>
                            <?php
                        }
                        if ($entered['spl_instruction'] != '') {
                            ?> 
                            <div style="width: 22%;float: left;border: 1px solid #F99B3E;margin-right: 10px;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                    Special Instructions
                                </div>
                                <div style="padding-top: 3px;width: 100%;float: left;">
                                    <input type="hidden" name="spl_instruction" id="spl_instruction" value="<?php echo $entered['spl_instruction']; ?>" />
                                    <?php echo $entered['spl_instruction']; ?>
                                </div>
                            </div>
                            <?php
                        }
                       // if ($entered['plot_arch'] == '0') {
                            if ($entered['pick_up_time'] != '0') {
                                $pickup_option = ($entered['pick_up'] == "ASAP") ? $entered['pick_up'] : $entered['pick_up'] . ' ' . $entered['pick_up_time'];
                                ?>
                                <div style="width: 22%;float: left;border: 1px solid #F99B3E;">
                                    <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                        Schedule a Pickup
                                    </div>
                                    <div style="padding-top: 3px;width: 100%;float: left;">
                                        <input type="hidden" name="pick_up_time" id="pick_up_time" value="<?php echo $entered['pick_up_time']; ?>" />
                                        <?php echo $pickup_option; ?>
                                    </div>
                                </div>
                            <?php }if ($entered['drop_off'] != '0') { ?>
                                <div style="width: 22%;float: left;border: 1px solid #F99B3E;">
                                    <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                        Drop-off Option
                                    </div>
                                    <div style="padding-top: 3px;width: 100%;float: left;">
                                        <input type="hidden" name="drop_off" id="drop_off" value="<?php echo $entered['drop_off']; ?>" />
                                        <?php echo $entered['drop_off']; ?>
                                    </div>
                                </div>
                            <?php
                            }
                       // }
                        ?>
                            </div>
                    <?php
                                }
                            }
                        ?>
                    

                    <?php
                    $all_days_off = AllDayOff();
                    foreach ($all_days_off as $days_off_split) {
                        $all_days_in[] = $days_off_split['date'];
                    }
                    $all_date = implode(",", $all_days_in);
                    $all_date_exist = str_replace("/", "-", $all_date);
                    ?>

                </div>

            <div  style="float: left;width: 33%;margin-left: 30px;border: 1px #F99B3E solid;margin-top: 10px;font-weight: bold;padding:3px;">Send to: 
               <?php
                $address_book = AddressBookCompanySentTo($address_book_se);
                $address_book_drop = AddressBookCompanyService($company_id_view_plot);
               ?>
                <select name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return show_address();">                                           
                        <option value="<?php echo $address_book_drop[0]['id']; ?>">Return Everything To My Office</option>
                        <option value="P1">Pickup @ 381 Broome St</option>
                        <option value="P2">Pickup @ 307 7th Ave, 5th Flr</option>
                        <option class="select-dash" disabled="disabled">-----------------------------------------</option>
                    <?php 
                    foreach ($address_book_drop as $address) {
                    ?>                                                                                        
                        <option value="<?php echo $address['id']; ?>" <?php if ($address['id'] == $address_book_se) { ?> selected="selected" <?php } ?>><?php echo $address['company_name']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <!-- Address Show Start -->
            <div id="show_address" class="everything_return" style="float: left;width: 40%;height: 85px;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;font-weight: bold;">
                    
                    <!-- Address 1 Start -->
            <div style="width: 100%;float: left;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_1_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_1('<?php echo $address_book_se; ?>');"><?php echo $address_book[0]['address_1']; ?></span>
            <input style="width: 70%;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_1_<?php echo $address_book_se; ?>" id="address_1_<?php echo $address_book_se; ?>" value="<?php echo $address_book[0]['address_1']; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_1_buttons_<?php echo $address_book_se; ?>">
                <!--<img src="admin/images/like_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Update" title="Update" width="20" height="20" id="1" onclick="return update_address_1('<?php echo $address_book_se; ?>');" >-->
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_1('<?php echo $address_book_se; ?>');" >
            </div>
            </div>
            <!-- Address 1 End -->
            
            <!-- Address 2 Start -->
            <div style="width: 100%;float: left;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_2_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_2('<?php echo $address_book_se; ?>');"><?php echo $address_book[0]['address_2']; ?></span>
            <input style="width: 70%;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_2_<?php echo $address_book_se; ?>" id="address_2_<?php echo $address_book_se; ?>" value="<?php echo $address_book[0]['address_2']; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_2_buttons_<?php echo $address_book_se; ?>">
                <!--<img src="admin/images/like_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Update" title="Update" width="20" height="20" id="1" onclick="return update_address_2('<?php echo $address_book_se; ?>');" >-->
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_2('<?php echo $address_book_se; ?>');" >
            </div>
            </div>
            <!-- Address 2 End -->
            
            <?php if($address_book[0]['address_2'] != ''){?>
            <!-- Address 3 Start -->
            <div style="width: 100%;float: left;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_3_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_3('<?php echo $address_book_se; ?>');"><?php echo $address_book[0]['address_3']; ?></span>
            <input style="width: 70%;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_3_<?php echo $address_book_se; ?>" id="address_3_<?php echo $address_book_se; ?>" value="<?php echo $address_book[0]['address_3']; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_3_buttons_<?php echo $address_book_se; ?>">
                <!--<img src="admin/images/like_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Update" title="Update" width="20" height="20" id="1" onclick="return update_address_3('<?php echo $address_book_se; ?>');" >-->
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_3('<?php echo $address_book_se; ?>');" >
            </div>
            </div>
            <!-- Address 3 End -->
            <?php } ?>
            
            <!-- City Start -->
<!--            <div style="float: left;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_city_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_city('<?php echo $address_book_se; ?>');"><?php echo $address_book[0]['city']; ?></span>
            <input style="width: 40% !important;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_city_<?php echo $address_book_se; ?>" id="address_city_<?php echo $address_book_se; ?>" value="<?php echo $address_book[0]['city']; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_city_buttons_<?php echo $address_book_se; ?>">                
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_city('<?php echo $address_book_se; ?>');" >
            </div>
            </div>
             City End 
            
            
            <div style="float: left;">
                 State Start 
                <span style="width: 6%;float: left;font-weight: bold;cursor: pointer;" id="address_state_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_state('<?php echo $address_book_se; ?>');"><?php echo ',&nbsp;'.StateName($address_book[0]['state']); ?></span>            
                <select name="state" id="address_state_select_<?php echo $address_book_se; ?>" style="display: none;float: left;">
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
                 State End     
                
                 ZIP Start 
                <span style="width: 6%;float: left;font-weight: bold;cursor: pointer;margin-left: 22px;" id="address_zip_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_zip('<?php echo $address_book_se; ?>');"><?php echo $address_book[0]['zip']; ?></span>
                
                <input style="width: 20%;float: left;margin-bottom: 0px;font-size: 12px !important;margin-left: 10px;display: none;"  type="text" name="address_zip_<?php echo $address_book_se; ?>" id="address_zip_<?php echo $address_book_se; ?>" value="<?php echo $address_book[0]['zip']; ?>" />
                <div style="width: 20%;float: left;display: none;" id="address_zip_buttons_<?php echo $address_book_se; ?>">
                    <img src="admin/images/like_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Update" title="Update" width="20" height="20" id="1" onclick="return update_address_city('<?php echo $address_book_se; ?>');" >
                    <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="17" height="17" id="1" onclick="return cancel_address_zip('<?php echo $address_book_se; ?>');" >
                </div>
                 ZIP End
            </div>-->
            

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

            
            <!-- Phone Start -->
            <div style="float: left;width: 100%;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_phone_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_phone('<?php echo $address_book_se; ?>');"><?php echo $address_book[0]['phone']; ?></span>
            <input style="width: 34%;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_phone_<?php echo $address_book_se; ?>" id="address_phone_<?php echo $address_book_se; ?>" value="<?php echo $address_book[0]['phone']; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_phone_buttons_<?php echo $address_book_se; ?>">
                <!--<img src="admin/images/like_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Update" title="Update" width="20" height="20" id="1" onclick="return update_address_city('<?php echo $address_book_se; ?>');" >-->
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_phone('<?php echo $address_book_se; ?>');" >
            </div>
            </div>
            <!-- Phone End -->
            
            </div>
            <div style="float: left;width: 33%;margin-left: 30px;border: 1px #FFF solid;margin-top: 10px;font-weight: bold;padding:3px;"></div>
            <div id="show_address_buttons_to_<?php echo $address_book_se; ?>" style="float: left;display: none;width: 40%;text-align: center;height: 15px !important;padding: 6px;border: 1px #F99B3E solid;margin-left: 5px;height: 20px;font-weight: bold;background-color: #F99B3E;">
                <span id="save_only" style="border: 1px solid #FFEEE1;font-weight: bold;border-radius: 5px;padding: 3px;background-color: #FFEEE1;cursor: pointer;" onclick="return update_exist_address('<?php echo $address_book_se; ?>');">Save</span>
                <span id="show_save_new" style="border: 1px solid #34A853;font-weight: bold;border-radius: 5px;padding: 3px;background-color: #34A853;color: #FFF;cursor: pointer;" onclick="return save_new_address_to('<?php echo $address_book_se; ?>');">Save as New</span>
                <span id="show_save_new_cancel" style="border: 1px solid #D84B36;font-weight: bold;border-radius: 5px;padding: 3px;background-color: #D84B36;color: #FFF;display: none;cursor: pointer;" onclick="return save_new_address_cancel_to('<?php echo $address_book_se; ?>');">Cancel</span>
                <span id="save_new" style="border: 1px solid #34A853;font-weight: bold;border-radius: 5px;padding: 3px;background-color: #34A853;color: #FFF;display: none;cursor: pointer;" onclick="return save_new_record_to('<?php echo $address_book_se; ?>');">Save as New</span>
            </div>
   
            <div style="float: left;width: 100%;margin-top: 5px;">   
                <div style="float: left;width: 39%;">
                    &nbsp;
                </div>
                <!-- Attention To Start -->
                <div style="float: left;width: 30%;">
                    <div style="float: left;width: 100%;margin-top: 10px;">
                        <div style="float: right;width: 100%;font-weight: bold;">Attention to:   </div>
                    </div>
                    <div style="float: left;width: 100%;margin-top: 10px;">
                        <div style="float: right;width: 100%;">
                            <div id="show_address_att" style="float: left;width: 90%;border: 1px #F99B3E solid;padding: 5px;height: 25px;">
                                <input type="text" name="shipp_att" id="shipp_att" value="<?php echo $address_book[0]['attention_to']; ?>" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Attention To End -->
                <!-- Contact Phone Start -->
                <div style="float: left;width: 30%;">
                    <div style="float: left;width: 100%;margin-top: 10px;">
                        <div style="float: left;width: 61%;font-weight: bold;">Contact Phone:   </div>
                    </div>
                    <div style="float: left;width: 100%;margin-top: 10px;">
                        <div style="float: right;width: 100%;">
                            <div id="show_contact_phone" style="float: left;width: 90%;border: 1px #F99B3E solid;padding: 5px;height: 25px;">
                                <input type="text" name="contact_ph" id="contact_ph" onfocus="return contact_phone();"  value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Contact Phone End -->
            </div>

            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                <input type="hidden" name="all_exist_date" id="all_exist_date" value="<?php echo $all_date_exist; ?>" />
                <div style="float:left;margin-right: 5px;margin-top: 10px;width: 100%;">
                    <span style="font-weight: bold;">When Needed: </span>
                </div>
                <div style="width: 34%;float: left;"> 

                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;border-bottom: 0px;text-align: center;">
                        <span id="asap_status" class="asap_orange" onclick="return asap();">ASAP</span> 
                    </div>

                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                        <input class="picker_icon" value="" type="text" name="date_needed" id="date_needed" style="width: 75px;" onclick="return date_reveal_return();" />
                        <input id="time_picker_icon" value="" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time_return();" />
                    </div>

                </div>
            </div>
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;margin-right: 10px;float: left;">
                        <input type="checkbox" name="arrange_del" id="arrange_del" checked style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="uncheck_delivery();" /><span style="text-transform: uppercase;">Soho to arrange delivery</span>
                    </div>              

                </div>
                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;float: left;">
                        <input type="checkbox" name="preffer_del" id="preffer_del" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="check_prefer_delivery();" /><span style="text-transform: uppercase;">Use My Carrier</span>
                    </div>

                    <div id="preffered_info" style="width: 91%;display: none;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;">
                        <ul>                                       
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery : </span>
                                    <select  name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address();">                    
                                        <option value="1">Next Day Air</option>
                                        <option value="2">Two Day Air</option>
                                        <option value="3">Three Day Air</option>
                                        <option value="4">Ground</option>
                                    </select>
                                </li>                    
                                <li id="shipp_collection">
                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" onclick="return field_color();" /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" onclick="return field_color();" /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" onclick="return field_color();" /><input type="text" placeholder="Other" name="other_shipp_type" id="other_shipp_type"  onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #  :</span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>
                            </ul>                            
                        </ul>
                    </div>

                </div>
            </div>


            <div style="font-weight: bold;width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                Special Instructions:            
            </div>        
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                <textarea name="spl_recipient" id="spl_recipient" rows="3" cols="18" style="width: 200px;height: 40px;"></textarea>
            </div>

        </div>
    </div>
	
<?php } ?>
<div style="float:right;">            
            <input class="all_options" value="Continue" style="cursor: pointer;font-size: 12px; padding: 1.5px; width: 135px; margin-right: 14px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;margin-top: -0px !important;" type="button" onclick="return continue_recipient_everyting_return();" />
     </div>
