<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);

// Reference Values
// 9 - Add New Recipients
// 8 - Delete Added Recipients
// 7 - Edit Added Recipients
// 6 - Update Added Recipients
// 
// 5 - Increase the Available Sets
// 4 - Decrease the Available Sets
// Made the Repository 

if ($_POST['recipients'] == '1') {
    $current_option = CurrentOption($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $rem_avl_options = AvlOptionsRemaining($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    ?>
    <div style="width: 100%;float: left;border: 1px #F99B3E solid;margin-bottom: 5px;">            
        <div style="width: 48%;float: left;text-align: left;font-weight: bold;">OPTION <?php echo $current_option[0]['options']; ?></div>
        <div style="width: 48%;float: left;text-align: right;font-weight: bold;"><?php echo $current_option[0]['options'] . '/' . count($number_of_sets); ?></div>
    </div>
    <input type="hidden" name="tot_avl_options" id="tot_avl_options" value="<?php echo count($number_of_sets); ?>" />
    <input type="hidden" name="rem_avl_options" id="rem_avl_options" value="<?php echo count($rem_avl_options); ?>" />
    <div style="border: 1px #F99B3E solid;margin-bottom: 20px;padding-bottom: 20px;width: 100%;float: left;">
        <div style="width: 100%;float: left;margin-top: 10px;">
            <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT 1</div>
            <div style="float: right;width: 20%;font-weight: bold;cursor: pointer;" title="Delete Recipient" alt="Delete Recipient" onclick="return delete_recipient_empty();"><span style="background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;">Delete</span></div>

            <?php
            $user_id_add_set = $_SESSION['sohorepro_userid'];
            $company_id_view_plot = $_SESSION['sohorepro_companyid'];
            ?>
            <!-- Address Show End -->
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                <div id="sets_grid_new">
                    <table border="1" style="width: 100%;">
                        <tr bgcolor="#F99B3E">
                            <td style="font-weight: bold;">Order Type</td>
                            <td style="font-weight: bold;">Originals</td>
                            <td style="font-weight: bold;">Available Sets</td>
                            <td style="font-weight: bold;">Sets Needed</td>
                            <td style="font-weight: bold;">Size</td>
                            <td style="font-weight: bold;">Output</td>
                            <td style="font-weight: bold;">Media</td>
                            <td style="font-weight: bold;">Binding</td>
                            <td style="font-weight: bold;">Folding</td>
                        </tr> 
                        <?php
                        // $enteredPlot = EnteredPlotRecipients($company_id_view_plot, $user_id_add_set);
                        $enteredPlot = EnteredPlotRecipientsCurrentOption($current_option[0]['id']);
//                        echo '<pre>';
//                        print_r($enteredPlot);
//                        echo '</pre>';
                        $i = 1;
                        foreach ($enteredPlot as $entered) {
                            $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                            $binding = strtoupper($entered['binding']);
                            $folding = strtoupper($entered['folding']);
                            $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Architectural Copies';
                            $type = ($entered['plot_arch'] == '1') ? '1' : '0';
                            $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1') : EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                            $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']) : ArchSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']);
                            $plot_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1');
                            $copy_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');

                            if ($entered['plot_arch'] == '1') {
                                ?>
                                <input type="hidden" id="option_id" value="<?php echo $entered['options']; ?>" />
                                <tr bgcolor="#ffeee1">
                                    <td>Plotting on Bond</td>
                                    <td><?php echo $available_order[0]['origininals']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_1" class="avl_sets"  value="<?php echo ($available_order[0]['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_1" class="need_sets" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo $i; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo $i; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $i; ?>" value="<?php echo $entered['size']; ?>" /></td>
                                    <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $i; ?>" value="<?php echo $entered['output']; ?>" /></td>
                                    <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $i; ?>" value="<?php echo $entered['media']; ?>" /></td>
                                    <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $i; ?>" value="<?php echo $binding; ?>" /></td>
                                    <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $i; ?>" value="<?php echo $folding; ?>" /></td>
                                </tr>
                                <?php
                            }
                            ?>

                            <?php
                            if ($entered['plot_arch'] == '0') {
                                ?>
                                <input type="hidden" id="option_id" value="<?php echo $entered['options']; ?>" />
                                <tr bgcolor="#ffeee1">
                                    <td>Architectural Copies</td>
                                    <td><?php echo $available_order[0]['origininals']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_2" class="avl_sets"  value="<?php echo ($available_order[0]['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_2" class="need_sets" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo '2'; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo '2'; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $i; ?>" value="<?php echo $entered['size']; ?>" /></td>
                                    <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $i; ?>" value="<?php echo $entered['output']; ?>" /></td>
                                    <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $i; ?>" value="<?php echo $entered['media']; ?>" /></td>
                                    <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $i; ?>" value="<?php echo $binding; ?>" /></td>
                                    <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $i; ?>" value="<?php echo $folding; ?>" /></td>
                                </tr>
                                <?php
                            }
                            ?>

                            <?php
                            $i++;
                        }
                        ?>
                    </table>
                </div>

                <div style="width: 99%;float: left;margin-top: 5px;">
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
                    }if ($entered['plot_arch'] == '0') {
                        if ($entered['pick_up_time'] != '0') {
                            ?>
                            <div style="width: 22%;float: left;border: 1px solid #F99B3E;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                    Pickup Option
                                </div>
                                <div style="padding-top: 3px;width: 100%;float: left;">
                                    <input type="hidden" name="pick_up_time" id="pick_up_time" value="<?php echo $entered['pick_up_time']; ?>" />
                            <?php echo $entered['pick_up'] . ' ' . $entered['pick_up_time']; ?>
                                </div>
                            </div>
        <?php }if ($entered['drop_off'] != '0') { ?>
                            <div style="width: 22%;float: left;border: 1px solid #F99B3E;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                    Pickup Option
                                </div>
                                <div style="padding-top: 3px;width: 100%;float: left;">
                                    <input type="hidden" name="drop_off" id="drop_off" value="<?php echo $entered['drop_off']; ?>" />
                            <?php echo $entered['drop_off']; ?>
                                </div>
                            </div>
                    <?php }
                } ?>
                </div>

                <?php
                $all_days_off = AllDayOff();
                foreach ($all_days_off as $days_off_split) {
                    $all_days_in[] = $days_off_split['date'];
                }
                $all_date = implode(",", $all_days_in);
                $all_date_exist = str_replace("/", "-", $all_date);
                ?>

            </div>

            <div style="float: left;width: 33%;margin-left: 30px;border: 1px #F99B3E solid;margin-top: 10px;font-weight: bold;padding:3px;">Send to: 
                    <?php 
                    $address_book = AddressBookCompanyService($_SESSION['sohorepro_companyid']);
                    
                    ?>
                <select  name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return show_address();">
                        <option value="0">Address Book</option>
                        <option value="<?php echo $address_book[0]['id']; ?>">Return Everything To My Office</option>
                        <option value="P1">Pickup @ 381 Broome St</option>
                        <option value="P2">Pickup @ 307 7th Ave, 5th Flr</option>
                        <option class="select-dash" disabled="disabled">-----------------------------------------</option>
                    <?php                    
                    foreach ($address_book as $address) {
                        ?>                                                                                        
                        <option value="<?php echo $address['id']; ?>" ><?php echo $address['company_name']; ?></option>
                        <?php
                        }
                        ?>
                </select>
            </div>
            <!-- Address Show Start -->
            <div id="show_address" style="float: left;width: 56%;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">

            </div>

            <div style="float: left;width: 100%;margin-top: 5px;">   
                <div style="float: left;width: 40%;">
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
                                <input type="text" name="shipp_att" id="shipp_att" value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                    <span style="font-weight: bold;">When Needed:  </span>
                </div>
                <div style="width: 34%;float: left;"> 

                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;border-bottom: 0px;text-align: center;">
                        <span id="asap_status" class="asap_orange" onclick="return asap();">ASAP</span> 
                    </div>

                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                        <input class="picker_icon" value="" type="text" name="date_needed" id="date_needed" style="width: 75px;" onclick="date_reveal();" />
                        <input id="time_picker_icon" value="" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time();" />
                    </div>

                </div>
            </div>
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;margin-right: 10px;float: left;">
                        <input type="checkbox" name="arrange_del" id="arrange_del" checked style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="uncheck_delivery();" /><span style="text-transform: uppercase;">Soho to arrange delivery</span>
                    </div>

                    <!--<div id="delivery_info" style="width: 92%;display: none;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;">
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery:  </span>
                                    <select  name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address();">                    
                                        <option value="1">Next Day Air</option>
                                        <option value="2">Two Day Air</option>
                                        <option value="3">Three Day Air</option>
                                        <option value="4">Ground</option>
                                    </select>
                                </li>                    
                                <li id="shipp_collection">
                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" /> FedEx</span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" /> UPS</span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" /><input type="text" name="other_shipp_type" id="other_shipp_type"  onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #  :</span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>
                            </ul>
                        </div>-->

                </div>
                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;float: left;">
                        <input type="checkbox" name="preffer_del" id="preffer_del" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="check_prefer_delivery();" /><span style="text-transform: uppercase;">Use My Carrier</span>
                    </div>

                    <div id="preffered_info" style="width: 91%;display: none;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;">
                        <ul>                                       
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery:  </span>
                                    <select  name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address_();">                    
                                        <option value="1">Next Day Air</option>
                                        <option value="2">Two Day Air</option>
                                        <option value="3">Three Day Air</option>
                                        <option value="4">Ground</option>
                                    </select>
                                </li>                    
                                <li id="shipp_collection">
                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" /><input type="text" placeholder="Other" name="other_shipp_type" id="other_shipp_type"  onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>
                            </ul>
                            <!--<li>
                                    <span style="font-weight: bold;">Account #  :</span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>-->
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
    <?php
} elseif ($_POST['recipients'] == '9') {
    
    $shipping_id_rec_pre = explode("_", $_POST['shipping_id_rec']);    
    $shipping_id_rec = ($shipping_id_rec_pre[0] == "PEVERY") ? $shipping_id_rec_pre[1] : $_POST['shipping_id_rec'];
    $user_session = $_POST['user_session'];
    $user_session_comp = $_POST['user_session_comp'];
    $date_needed = $_POST['date_needed'];
    $time_needed = $_POST['time_needed'];
    $spl_recipient = $_POST['spl_recipient'];

    $avl_sets_1 = $_POST['avl_sets_1'];
    $need_sets_1 = $_POST['need_sets_1'];
    $size_sets_1 = $_POST['size_sets_1'];
    $output_sets_1 = $_POST['output_sets_1'];
    $media_sets_1 = $_POST['media_sets_1'];
    $binding_sets_1 = $_POST['binding_sets_1'];
    $folding_sets_1 = $_POST['folding_sets_1'];

    $avl_sets_2 = $_POST['avl_sets_2'];
    $need_sets_2 = $_POST['need_sets_2'];
    $size_sets_2 = $_POST['size_sets_2'];
    $output_sets_2 = $_POST['output_sets_2'];
    $binding_sets_2 = $_POST['binding_sets_2'];
    $folding_sets_2 = $_POST['folding_sets_2'];

    $delivery_type = $_POST['delivery_type'];
    $bill_number = $_POST['bill_number'];
    $shipp_comp_1_f = $_POST['shipp_comp_1_f'];
    $shipp_comp_2_f = $_POST['shipp_comp_2_f'];
    $shipp_comp_3_f = $_POST['shipp_comp_3_f'];

    $size_custom_details = $_POST['size_custom_details'];

    $output_page_details = $_POST['output_page_details'];

    $attention_to = $_POST['attention_to'];

    $contact_ph = $_POST['contact_ph'];

    $option_id = $_POST['option_id'];

    $query = "INSERT INTO sohorepro_sets_needed
			SET     comp_id         = '" . $user_session_comp . "',
                                usr_id          = '" . $user_session . "',
                                plot_needed     = '" . $need_sets_1 . "',
                                size            = '" . $size_sets_1 . "',
                                option_id       = '" . $option_id . "',  
                                custome_details     = '" . $size_custom_details . "',
                                output              = '" . $output_sets_1 . "',
                                output_page_number  = '" . $output_page_details . "',
                                media               = '" . $media_sets_1 . "',  
                                binding         = '" . $binding_sets_1 . "',
                                folding         = '" . $folding_sets_1 . "',   
                                arch_needed     = '" . $need_sets_2 . "',
                                arch_size       = '" . $size_sets_2 . "',
                                arch_output     = '" . $output_sets_2 . "',
                                arch_binding    = '" . $binding_sets_2 . "',
                                arch_folding    = '" . $folding_sets_2 . "',  
                                shipp_id        = '" . $shipping_id_rec . "',
                                attention_to    = '" . $attention_to . "',
                                contact_ph      = '" . $contact_ph . "',    
                                shipp_date      = '" . $date_needed . "',
                                shipp_time      = '" . $time_needed . "',    
                                spl_inc         = '" . $spl_recipient . "',
                                delivery_type   = '" . $delivery_type . "',
                                billing_number  = '" . $bill_number . "',
                                shipp_comp_1    = '" . $shipp_comp_1_f . "',
                                shipp_comp_2    = '" . $shipp_comp_2_f . "',
                                shipp_comp_3    = '" . $shipp_comp_3_f . "' ";
    $sql_result = mysql_query($query);
    $enteredSetsOptions = EnteredOptionsSet($option_id);
    $current_option = CurrentOption($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $current_option_check = $current_option[0]['print_ea'];
    $sumOfplott = SumOffPlott($option_id);
    $sumOfArch = SumOffArch($option_id);

    $enteredSetsOptionsSets = ($enteredSetsOptions[0]['plot_needed'] != '0') ? $sumOfplott : $sumOfArch;

    if ($current_option_check == $enteredSetsOptionsSets) {
        $update_recipient_set = "UPDATE sohorepro_plotting_set SET recipients_set = '1' WHERE company_id = '" . $user_session_comp . "' AND user_id = '" . $user_session . "' AND order_id = '0' AND recipients_set = '0' ORDER BY options ASC LIMIT 1";
        mysql_query($update_recipient_set);
    }

    $number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $rem_avl_options = AvlOptionsRemaining($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    echo count($number_of_sets) . '~' . count($rem_avl_options) . '~';
    ?>
    <?php
    $entered_needed_sets = NeededSets($user_session_comp, $user_session);
    $r = 1;
    foreach ($entered_needed_sets as $entered_sets) {
        if ($entered_sets['shipp_id'] == "P1") {
            $shipp_add = AddressBookPickupSohoCap("P1");
        } elseif ($entered_sets['shipp_id'] == "P2") {
            $shipp_add = AddressBookPickupSohoCap("P2");
        } else {
            $shipp_add = SelectIdAddressService($entered_sets['shipp_id']);
        }
        $plot_binding = ($entered_sets['binding'] == '0') ? '' : ',' . $entered_sets['binding'];
        $plot_folding = ($entered_sets['folding'] == '0') ? '' : ',' . $entered_sets['folding'];
        $arch_binding = ($entered_sets['arch_binding'] == '0') ? '' : ',' . $entered_sets['arch_binding'];
        $arch_folding = ($entered_sets['arch_folding'] == '0') ? '' : ',' . $entered_sets['arch_folding'];
        $needen_sets = ($entered_sets['plot_needed'] != '0') ? $entered_sets['plot_needed'] : $entered_sets['arch_needed'];
        $type = ($entered_sets['plot_needed'] != '0') ? 'Plotting on Bond' : 'Architectural Copies';
        ?>    
        <div style="border: 2px #F99B3E solid;padding-bottom: 20px;margin-bottom : 5px;width: 100%;float: left;" class="shaddows">
            <div style="width: 100%;float: left;margin-top: 10px;">
                <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo $r; ?></div>
                <div style="float: right;width: 20%;font-weight: bold;">
                    <span title="Edit Recipient" alt="Edit Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;font-weight: bold;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;" onclick="return edit_recipient('<?php echo $entered_sets['id']; ?>');">Edit</span>
                    <span title="Delete Recipient" alt="Delete Recipient" style="font-weight: bold;cursor: pointer;background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;" onclick="return delete_recipient('<?php echo $entered_sets['id']; ?>');">Delete</span>
                </div>

                <div style="float: left;width: 100%;margin-left: 30px;margin-top: 10px;font-weight: bold;">Send to: </div>
                <div style="float: left;width: 100%;margin-left: 30px;">  
                    <?php
                    $comp_name = ($shipp_add[0]['company_name'] == '') ? '' : $shipp_add[0]['company_name'] . '<br>';
                    $add_1 = ($shipp_add[0]['address_1'] == '') ? '' : $shipp_add[0]['address_1'] . '<br>';
                    $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . '<br>';
                    $add_3 = ($shipp_add[0]['address_3'] == '') ? '' : $shipp_add[0]['address_3'] . '<br>';
                    //echo $shipp_add[0]['company_name'] . '<br>' . $shipp_add[0]['address_1'] . ',<br>' . $add_2 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'].'<br>'.'Attention to:  '.$entered_sets['attention_to'];
                    if (($entered_sets['shipp_id'] == "P1") || ($entered_sets['shipp_id'] == "P2")) {
                        echo $shipp_add[0]['address'];
                    } else {
                        ?>                    
                        <span style="width:100%;float: left;"><?php echo $comp_name; ?></span>
                        <span style="width:100%;float: left;">Attention:  <?php echo $entered_sets['attention_to']; ?></span>
                        <?php if ($entered_sets['contact_ph'] != "") { ?>
                            <span style="width:100%;float: left;">Contact:  <?php echo $entered_sets['contact_ph']; ?></span>
                        <?php } ?>
                        <?php if ($add_1 != '') { ?>
                            <span style="width:100%;float: left;"><?php echo $add_1; ?></span>
                        <?php }if ($add_2 != '') { ?>
                            <span style="width:100%;float: left;"><?php echo $add_2; ?></span>
                        <?php }if ($add_3 != '') { ?>
                            <span style="width:100%;float: left;"><?php echo $add_3; ?></span>
            <?php } ?>
                        <span style="width:100%;float: left;"><?php echo $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip']; ?></span>
        <?php } ?>
                </div>
                <!-- Address Show End -->

                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>
                <div style="float: left;width: 90%;margin-left: 30px;margin-top: 5px;">

                    <table border="1" style="width: 100%;">
                        <tr bgcolor="#F99B3E">
                            <td style="font-weight: bold;">Sets</td> 
                            <td style="font-weight: bold;">Order Type</td>                            
                            <td style="font-weight: bold;">Size</td>
                            <td style="font-weight: bold;">Output</td>
                            <td style="font-weight: bold;">Media</td>
                            <td style="font-weight: bold;">Binding</td>
                            <td style="font-weight: bold;">Folding</td>
                        </tr>
                        <tr bgcolor="#ffeee1">
                            <td><?php echo $needen_sets; ?></td>
                            <td><?php echo $type; ?></td>                            
                            <td><?php echo $entered_sets['size']; ?></td>
                            <td><?php echo $entered_sets['output']; ?></td>
                            <td><?php echo $entered_sets['media']; ?></td>
                            <td>
                                <span onclick="return edit_binding('<?php echo $entered_sets['id']; ?>');" id="binding_<?php echo $entered_sets['id']; ?>" style="cursor: pointer;"><?php echo $entered_sets['binding']; ?></span>
                                <select class="binding_select_<?php echo $entered_sets['id']; ?>" id="binding_select_<?php echo $entered_sets['id']; ?>" onchange="return change_binding('<?php echo $entered_sets['id']; ?>');" style="width: 65px;display:none;">
                                    <option value="None" <?php if ($entered_sets['binding'] == 'NONE') { ?> selected="selected" <?php } ?>>None</option>                                      
                                    <option value="Bind All" <?php if ($entered_sets['binding'] == 'BIND ALL') { ?> selected="selected" <?php } ?>>Bind All</option>                          
                                    <option value="Bind by Discipline" <?php if ($entered_sets['binding'] == 'BIND BY DISCIPLINE') { ?> selected="selected" <?php } ?>>Bind by Discipline</option>
                                    <option value="Screw Post" <?php if ($entered_sets['binding'] == 'SCREW POST') { ?> selected="selected" <?php } ?>>Screw Post</option>
                                </select>
                            </td>
                            <td>
                                <span onclick="return edit_folding('<?php echo $entered_sets['id']; ?>');" id="folding_<?php echo $entered_sets['id']; ?>" style="cursor: pointer;"><?php echo $entered_sets['folding']; ?></span>
                                <select id="folding_select_<?php echo $entered_sets['id']; ?>" onchange="return change_folding('<?php echo $entered_sets['id']; ?>');" style="width: 65px;display:none;">
                                    <option value="None" <?php if ($entered_sets['folding'] == 'NONE') { ?> selected="selected" <?php } ?>>None</option>
                                    <option value="Yes" <?php if ($entered_sets['folding'] == 'YES') { ?> selected="selected" <?php } ?>>Yes</option>                          
                                </select>

                            </td>
                        </tr>
                    </table>

        <!--   1. <?php // echo $entered_sets['plot_needed'] . '&nbsp;Sets Plotting on Bond,' . $entered_sets['size'] . ',' . $entered_sets['output'] . $plot_binding . $plot_folding;  ?></br>-->
                    <!--   2. <?php // echo  $entered_sets['arch_needed'].'&nbsp;Sets Plotting on Bond,'. $entered_sets['arch_size'].','.$entered_sets['arch_output'].$arch_binding.$arch_folding;    ?> -->
                </div>   


        <?php
        if ($entered_sets['size'] == 'Custom') {
            ?>
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                        <div style="font-weight: bold;width: 100%;float: left;">
                            Custom Size Details :
                        </div>
                        <div style="width: 100%;float: left;">                    
                    <?php echo $entered_sets['custome_details']; ?>
                        </div>
                    </div>
                <?php } ?>

        <?php
        if ($entered_sets['output'] == 'Both') {
            ?>
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                        <div style="font-weight: bold;width: 100%;float: left;">
                            Color Page Numbers :
                        </div>
                        <div style="width: 100%;float: left;">                    
                    <?php echo $entered_sets['output_page_number']; ?>
                        </div>
                    </div>
                    <?php } ?>


                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;">
        <?php
        $date_asap = ($entered_sets['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_sets['shipp_time'] : '';
        ?>
                    <span style="font-weight: bold;">When Needed:  </span><?php echo $entered_sets['shipp_date'] . $date_asap; ?>            
                </div>        
        <?php
        if ($entered_sets['delivery_type'] != '0') {
            ?>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Send Via: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <?php
                        if ($entered_sets['delivery_type'] == '1') {
                            $delivery_type = 'Next Day Air';
                        } elseif ($entered_sets['delivery_type'] == '2') {
                            $delivery_type = 'Two Day Air';
                        } elseif ($entered_sets['delivery_type'] == '3') {
                            $delivery_type = 'Three Day Air';
                        } elseif ($entered_sets['delivery_type'] == '4') {
                            $delivery_type = 'Ground';
                        }

                        $ship_type_1 = ($entered_sets['shipp_comp_1'] == '0') ? '' : $entered_sets['shipp_comp_1'];
                        $ship_type_2 = ($entered_sets['shipp_comp_2'] == '0') ? '' : $entered_sets['shipp_comp_2'];
                        $ship_type_3 = ($entered_sets['shipp_comp_3'] == '0') ? '' : $entered_sets['shipp_comp_3'];

                        echo $ship_type_1 . $ship_type_2 . $ship_type_3 . ',&nbsp;' . $delivery_type . ',&nbsp;Account # ' . $entered_sets['billing_number'];
                        ?>
                    </div>
        <?php } else { ?>                            
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Send Via: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        SOHO TO ARRANGE DELIVERY
                    </div>    
                <?php } ?>   
        <?php
        if ($entered_sets['spl_inc'] != '') {
            ?>
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">Special Instructions: </div>
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                    <?php echo $entered_sets['spl_inc']; ?>
                    </div>
            <?php
        }
        ?>
            </div>
        </div>
        <?php
        $r++;
    }
    $current_option = CurrentOption($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $rem_avl_options = AvlOptionsRemaining($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    ?>
    <div style="width: 100%;float: left;border: 1px #F99B3E solid;margin-bottom: 5px;">            
        <div style="width: 48%;float: left;text-align: left;font-weight: bold;">OPTION <?php echo $current_option[0]['options']; ?></div>
        <div style="width: 48%;float: left;text-align: right;font-weight: bold;"><?php echo $current_option[0]['options'] . '/' . count($number_of_sets); ?></div>
    </div>
    <input type="hidden" name="tot_avl_options" id="tot_avl_options" value="<?php echo count($number_of_sets); ?>" />
    <input type="hidden" name="rem_avl_options" id="rem_avl_options" value="<?php echo count($rem_avl_options); ?>" />

    <!-- New Recipients Start -->
    <div style="border: 1px #F99B3E solid;margin-top: 5px;margin-bottom: 20px;padding-bottom: 20px;width: 100%;float: left;">
        <div style="width: 100%;float: left;margin-top: 10px;">
            <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo (count($entered_needed_sets) + 1); ?></div>
            <div style="float: right;width: 20%;font-weight: bold;">
                <span title="Delete Recipient" alt="Delete Recipient" style="font-weight: bold;cursor: pointer;background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;" onclick="return delete_recipient_empty();">Delete</span>
            </div>


            <?php
            $user_id_add_set = $_SESSION['sohorepro_userid'];
            $company_id_view_plot = $_SESSION['sohorepro_companyid'];
            ?>
            <!-- Address Show End -->
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                <div id="sets_grid_new">
                    <table border="1" style="width: 100%;">
                        <tr bgcolor="#F99B3E">
                            <td style="font-weight: bold;">Order Type</td>
                            <td style="font-weight: bold;">Originals</td>
                            <td style="font-weight: bold;">Available Sets</td>
                            <td style="font-weight: bold;">Sets Needed</td>
                            <td style="font-weight: bold;">Size</td>
                            <td style="font-weight: bold;">Output</td>
                            <td style="font-weight: bold;">Media</td>
                            <td style="font-weight: bold;">Binding</td>
                            <td style="font-weight: bold;">Folding</td>
                        </tr> 
                        <?php
                        //$enteredPlot = EnteredPlotRecipients($company_id_view_plot, $user_id_add_set);
                        $enteredPlot = EnteredPlotRecipientsCurrentOption($current_option[0]['id']);
                        $setted_option = SettedOptions($company_id_view_plot, $user_id_add_set);
                        $print_ea_tot = $enteredPlot[0]['print_ea'];
//                        echo '<pre>';
//                        print_r($enteredPlot);
//                        echo '</pre>';
                        $i = 1;
                        foreach ($enteredPlot as $entered) {
                            $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                            $binding = strtoupper($entered['binding']);
                            $folding = strtoupper($entered['folding']);
                            $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Architectural Copies';
                            $type = ($entered['plot_arch'] == '1') ? '1' : '0';
                            $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1') : EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                            $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']) : ArchSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']);
                            $needed_all_sets = ($entered['plot_arch'] == '1') ? EnteredSetsAll($entered['options'], $company_id_view_plot, $user_id_add_set) : EnteredSetsAll($entered['options'], $company_id_view_plot, $user_id_add_set);
                            ?>
        <?php
        if ($entered['plot_arch'] == '1') {
            ?>
                                <input type="hidden" id="option_id" value="<?php echo $entered['options']; ?>" />
                                <tr bgcolor="#ffeee1">
                                    <td>Plotting on Bond</td>
                                    <td><?php echo $available_order[0]['print_ea']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_1" class="avl_sets"  value="<?php echo ($entered['print_ea'] - $needed_all_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_1" class="need_sets" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo $i; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo $i; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $i; ?>" value="<?php echo $entered['size']; ?>" /></td>
                                    <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $i; ?>" value="<?php echo $entered['output']; ?>" /></td>
                                    <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $i; ?>" value="<?php echo $entered['media']; ?>" /></td>
                                    <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $i; ?>" value="<?php echo $binding; ?>" /></td>
                                    <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $i; ?>" value="<?php echo $folding; ?>" /></td>
                                </tr>
                                <?php
                            }
                            ?>

        <?php
        if ($entered['plot_arch'] == '0') {
            ?>
                                <input type="hidden" id="option_id" value="<?php echo $entered['options']; ?>" />
                                <tr bgcolor="#ffeee1">
                                    <td>Architectural Copies</td>
                                    <td><?php echo $available_order[0]['print_ea']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_2" class="avl_sets"  value="<?php echo ($available_order[0]['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_2" class="need_sets" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo $i; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo $i; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $i; ?>" value="<?php echo $entered['size']; ?>" /></td>
                                    <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $i; ?>" value="<?php echo $entered['output']; ?>" /></td>
                                    <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $i; ?>" value="<?php echo $entered['media']; ?>" /></td>
                                    <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $i; ?>" value="<?php echo $binding; ?>" /></td>
                                    <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $i; ?>" value="<?php echo $folding; ?>" /></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <?php
                            $i++;
                        }
                        ?>
                    </table>
                </div>

                <div style="width: 99%;float: left;margin-top: 5px;">
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
    }if ($entered['plot_arch'] == '0') {
        if ($entered['pick_up_time'] != '0') {
            ?>
                            <div style="width: 22%;float: left;border: 1px solid #F99B3E;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                    Pickup Option
                                </div>
                                <div style="padding-top: 3px;width: 100%;float: left;">
                                    <input type="hidden" name="pick_up_time" id="pick_up_time" value="<?php echo $entered['pick_up_time']; ?>" />
            <?php echo $entered['pick_up'] . ' ' . $entered['pick_up_time']; ?>
                                </div>
                            </div>
        <?php }if ($entered['drop_off'] != '0') { ?>
                            <div style="width: 22%;float: left;border: 1px solid #F99B3E;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                    Pickup Option
                                </div>
                                <div style="padding-top: 3px;width: 100%;float: left;">
                                    <input type="hidden" name="drop_off" id="drop_off" value="<?php echo $entered['drop_off']; ?>" />
                        <?php echo $entered['drop_off']; ?>
                                </div>
                            </div>
                    <?php }
                } ?> 
                </div>

                <?php
                $all_days_off = AllDayOff();
                foreach ($all_days_off as $days_off_split) {
                    $all_days_in[] = $days_off_split['date'];
                }
                $all_date = implode(",", $all_days_in);
                $all_date_exist = str_replace("/", "-", $all_date);
                ?>

            </div>

            <div style="float: left;width: 33%;margin-left: 30px;border: 1px #F99B3E solid;margin-top: 10px;font-weight: bold;padding:3px;">Send to: 
                <?php
                $address_book = AddressBookCompanyService($_SESSION['sohorepro_companyid']);
                ?>
                <select  name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return show_address();">
                    <option value="0">Address Book</option>
                    <option value="<?php echo $address_book[0]['id']; ?>">Return Everything To My Office</option>
                    <option value="P1">Pickup @ 381 Broome St</option>
                    <option value="P2">Pickup @ 307 7th Ave, 5th Flr</option>
                    <option class="select-dash" disabled="disabled">-----------------------------------------</option>
                    <?php                    
                    foreach ($address_book as $address) {
                        ?>                                                                                        
                        <option value="<?php echo $address['id']; ?>" ><?php echo $address['company_name']; ?></option>
        <?php
    }
    ?>
                </select>
            </div>
            <!-- Address Show Start -->
            <div id="show_address" style="float: left;width: 56%;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">

            </div>

            <div style="float: left;width: 100%;margin-top: 5px;">   
                <div style="float: left;width: 40%;">
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
                                <input type="text" name="shipp_att" id="shipp_att" value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                    <span style="font-weight: bold;">When Needed:  </span>
                </div>
                <div style="width: 34%;float: left;"> 

                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;border-bottom: 0px;text-align: center;">
                        <span id="asap_status" class="asap_orange" onclick="return asap();">ASAP</span>
                    </div>

                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                        <input class="picker_icon" value="" type="text" name="date_needed" id="date_needed" style="width: 75px;" onclick="date_reveal();" />
                        <input id="time_picker_icon" value="" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time();" />
                    </div>

                </div>
            </div>

            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;margin-right: 10px;float: left;">
                        <input type="checkbox" name="arrange_del" id="arrange_del" checked style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="uncheck_delivery();" /><span style="text-transform: uppercase;">Soho to arrange delivery</span>
                    </div>

                    <!--                    <div id="delivery_info" style="width: 92%;display: none;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;">
                                            <ul>
                                                <li>
                                                    <span style="font-weight: bold;">Delivery:  </span>
                                                    <select  name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address();">                    
                                                        <option value="1">Next Day Air</option>
                                                        <option value="2">Two Day Air</option>
                                                        <option value="3">Three Day Air</option>
                                                        <option value="4">Ground</option>
                                                    </select>
                                                </li>                    
                                                <li id="shipp_collection">
                                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" /> FedEx</span>
                                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" /> UPS</span>
                                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" /><input type="text" name="other_shipp_type" id="other_shipp_type"  onclick="return other_shipp_type();" style="width: 80px;"></span>
                                                </li>
                                                <li>
                                                    <span style="font-weight: bold;">Account #  :</span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;" />
                                                </li>
                                            </ul>
                                        </div>                -->
                </div>
                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;float: left;">
                        <input type="checkbox" name="preffer_del" id="preffer_del" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="check_prefer_delivery();" /><span style="text-transform: uppercase;">Use My Carrier</span>
                    </div>

                    <div id="preffered_info" style="width: 91%;display: none;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;">
                        <ul>
                            <li>
                                <span style="font-weight: bold;">Delivery:  </span>
                                <select  name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address_();">                    
                                    <option value="1">Next Day Air</option>
                                    <option value="2">Two Day Air</option>
                                    <option value="3">Three Day Air</option>
                                    <option value="4">Ground</option>
                                </select>
                            </li>                    
                            <li id="shipp_collection">
                                <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                <span><input type="radio" name="shipp_comp" id="shipp_comp_1" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                <span><input type="radio" name="shipp_comp" id="shipp_comp_2" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                <span><input type="radio" name="shipp_comp" id="shipp_comp_3" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" /><input type="text" name="other_shipp_type" placeholder="Other" id="other_shipp_type"  onclick="return other_shipp_type();" style="width: 80px;"></span>
                            </li>
                            <li>
                                <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;" />
                            </li>
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
    <!-- New Recipients End -->

    <?php
} elseif ($_POST['recipients'] == '8') {

    $delete_rec_id = $_POST['delete_rec_id'];
    $user_session = $_POST['user_session'];
    $user_session_comp = $_POST['user_session_comp'];

    $delete_sql = "DELETE FROM sohorepro_sets_needed WHERE id = '" . $delete_rec_id . "' ";
    mysql_query($delete_sql);

    $entered_needed_sets = NeededSets($user_session_comp, $user_session);
    $r = 1;
    foreach ($entered_needed_sets as $entered_sets) {
        $shipp_add = SelectIdAddressService($entered_sets['shipp_id']);
        $plot_binding = ($entered_sets['binding'] == '0') ? '' : ',' . $entered_sets['binding'];
        $plot_folding = ($entered_sets['folding'] == '0') ? '' : ',' . $entered_sets['folding'];
        $arch_binding = ($entered_sets['arch_binding'] == '0') ? '' : ',' . $entered_sets['arch_binding'];
        $arch_folding = ($entered_sets['arch_folding'] == '0') ? '' : ',' . $entered_sets['arch_folding'];
        ?>
        <div style="border: 2px #F99B3E solid;padding-bottom: 20px;margin-bottom : 5px;width: 100%;float: left;" class="shaddows">
            <div style="width: 100%;float: left;margin-top: 10px;">
                <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo $r; ?></div>
                <div style="float: right;width: 20%;font-weight: bold;">
                    <span title="Edit Recipient" alt="Edit Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;font-weight: bold;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;" onclick="return edit_recipient('<?php echo $entered_sets['id']; ?>');">Edit</span>
                    <span title="Delete Recipient" alt="Delete Recipient" style="font-weight: bold;cursor: pointer;background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;" onclick="return delete_recipient('<?php echo $entered_sets['id']; ?>');">Delete</span>
                </div>

                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 10px;font-weight: bold;">Send to: </div>
                <div style="float: left;width: 33%;margin-left: 30px;">  
        <?php
        $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . ',<br>';
        echo $shipp_add[0]['company_name'] . '<br>' . 'Attention:  ' . $entered_sets['attention_to'] . '<br>' . 'Conatct:  ' . $entered_sets['contact_ph'] . '<br>' . $shipp_add[0]['address_1'] . ',<br>' . $add_2 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'];
        ?>                   
                </div>
                <!-- Address Show End -->

                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>
                <div style="float: left;width: 90%;margin-left: 30px;margin-top: 5px;">

                    <table border="1" style="width: 100%;">
                        <tr bgcolor="#F99B3E">
                            <td style="font-weight: bold;">Sets</td> 
                            <td style="font-weight: bold;">Order Type</td>                            
                            <td style="font-weight: bold;">Size</td>
                            <td style="font-weight: bold;">Output</td>
                            <td style="font-weight: bold;">Media</td>
                            <td style="font-weight: bold;">Binding</td>
                            <td style="font-weight: bold;">Folding</td>
                        </tr>
                        <tr bgcolor="#ffeee1">
                            <td><?php echo $entered_sets['plot_needed']; ?></td>
                            <td>Plotting on Bond</td>                            
                            <td><?php echo $entered_sets['size']; ?></td>
                            <td><?php echo $entered_sets['output']; ?></td>
                            <td><?php echo $entered_sets['media']; ?></td>
                            <td>
                                <span onclick="return edit_binding('<?php echo $entered_sets['id']; ?>');" id="binding_<?php echo $entered_sets['id']; ?>" style="cursor: pointer;"><?php echo $entered_sets['binding']; ?></span>
                                <select class="binding_select_<?php echo $entered_sets['id']; ?>" id="binding_select_<?php echo $entered_sets['id']; ?>" onchange="return change_binding('<?php echo $entered_sets['id']; ?>');" style="width: 65px;display:none;">
                                    <option value="None" <?php if ($entered_sets['binding'] == 'NONE') { ?> selected="selected" <?php } ?>>None</option>                                      
                                    <option value="Bind All" <?php if ($entered_sets['binding'] == 'BIND ALL') { ?> selected="selected" <?php } ?>>Bind All</option>                          
                                    <option value="Bind by Discipline" <?php if ($entered_sets['binding'] == 'BIND BY DISCIPLINE') { ?> selected="selected" <?php } ?>>Bind by Discipline</option>
                                    <option value="Screw Post" <?php if ($entered_sets['binding'] == 'SCREW POST') { ?> selected="selected" <?php } ?>>Screw Post</option>
                                </select>                                
                            </td>
                            <td><?php echo $entered_sets['folding']; ?></td>
                        </tr>
                    </table>

                    <!--   1. <?php // echo $entered_sets['plot_needed'] . '&nbsp;Sets Plotting on Bond,' . $entered_sets['size'] . ',' . $entered_sets['output'] . $plot_binding . $plot_folding;  ?></br>-->
                    <!--   2. <?php // echo  $entered_sets['arch_needed'].'&nbsp;Sets Plotting on Bond,'. $entered_sets['arch_size'].','.$entered_sets['arch_output'].$arch_binding.$arch_folding;    ?> -->
                </div>   


        <?php
        if ($entered_sets['size'] == 'Custom') {
            ?>
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                        <div style="font-weight: bold;width: 100%;float: left;">
                            Custom Size Details :
                        </div>
                        <div style="width: 100%;float: left;">                    
                    <?php echo $entered_sets['custome_details']; ?>
                        </div>
                    </div>
        <?php } ?>

        <?php
        if ($entered_sets['output'] == 'Both') {
            ?>
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                        <div style="font-weight: bold;width: 100%;float: left;">
                            Color Page Numbers :
                        </div>
                        <div style="width: 100%;float: left;">                    
                        <?php echo $entered_sets['output_page_number']; ?>
                        </div>
                    </div>
                    <?php } ?>


                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;">
                <?php
                $date_asap = ($entered_sets['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_sets['shipp_time'] : '';
                ?>
                    <span style="font-weight: bold;">When Needed:  </span><?php echo $entered_sets['shipp_date'] . $date_asap; ?>            
                </div>        
                    <?php
                    if ($entered_sets['delivery_type'] != '0') {
                        ?>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Send Via: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <?php
                        if ($entered_sets['delivery_type'] == '1') {
                            $delivery_type = 'Next Day Air';
                        } elseif ($entered_sets['delivery_type'] == '2') {
                            $delivery_type = 'Two Day Air';
                        } elseif ($entered_sets['delivery_type'] == '3') {
                            $delivery_type = 'Three Day Air';
                        } elseif ($entered_sets['delivery_type'] == '4') {
                            $delivery_type = 'Ground';
                        }

                        $ship_type_1 = ($entered_sets['shipp_comp_1'] == '0') ? '' : $entered_sets['shipp_comp_1'];
                        $ship_type_2 = ($entered_sets['shipp_comp_2'] == '0') ? '' : $entered_sets['shipp_comp_2'];
                        $ship_type_3 = ($entered_sets['shipp_comp_3'] == '0') ? '' : $entered_sets['shipp_comp_3'];

                        echo $ship_type_1 . $ship_type_2 . $ship_type_3 . ',&nbsp;' . $delivery_type . ',&nbsp;Account # ' . $entered_sets['billing_number'];
                        ?>
                    </div>
                <?php } else { ?>                            
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Send Via: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        SOHO TO ARRANGE DELIVERY
                    </div>    
        <?php } ?>        
            </div>
        </div>
        <?php
        $r++;
    }
    ?>

    <!-- New Recipients Start -->
    <div style="border: 1px #F99B3E solid;margin-bottom: 20px;padding-bottom: 20px;width: 100%;float: left;">
        <div style="width: 100%;float: left;margin-top: 10px;">
            <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT 1</div>
            <div style="float: right;width: 20%;font-weight: bold;cursor: pointer;" title="Delete Recipient" alt="Delete Recipient" onclick="return delete_recipient_empty();"><span style="background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;">Delete</span></div>

    <?php
    $user_id_add_set = $_SESSION['sohorepro_userid'];
    $company_id_view_plot = $_SESSION['sohorepro_companyid'];
    ?>
            <!-- Address Show End -->
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                <div id="sets_grid_new">
                    <table border="1" style="width: 100%;">
                        <tr bgcolor="#F99B3E">
                            <td style="font-weight: bold;">Order Type</td>
                            <td style="font-weight: bold;">Originals</td>
                            <td style="font-weight: bold;">Available Sets</td>
                            <td style="font-weight: bold;">Sets Needed</td>
                            <td style="font-weight: bold;">Size</td>
                            <td style="font-weight: bold;">Output</td>
                            <td style="font-weight: bold;">Media</td>
                            <td style="font-weight: bold;">Binding</td>
                            <td style="font-weight: bold;">Folding</td>
                        </tr> 
                        <?php
                        $enteredPlot = EnteredPlotRecipients($company_id_view_plot, $user_id_add_set);
                        $i = 1;
                        foreach ($enteredPlot as $entered) {
                            $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                            $binding = strtoupper($entered['binding']);
                            $folding = strtoupper($entered['folding']);
                            $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Architectural Copies';
                            $type = ($entered['plot_arch'] == '1') ? '1' : '0';
                            $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1') : EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                            $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeeded($company_id_view_plot, $user_id_add_set) : ArchSetsNeeded($company_id_view_plot, $user_id_add_set);
                            $plot_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1');
                            $copy_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                            ?>
                            <!-- <tr bgcolor="<?php echo $rowColor; ?>">
                                    <td><?php echo $order_type; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_<?php echo $i; ?>" class="avl_sets" id="avl_sets_<?php echo $i; ?>"  value="<?php echo ($available_order[0]['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_<?php echo $i; ?>" class="need_sets" id="need_sets_<?php echo $i; ?>" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo $i; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo $i; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $i; ?>" value="<?php echo $entered['size']; ?>" /></td>
                                    <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $i; ?>" value="<?php echo $entered['output']; ?>" /></td>
                                    <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $i; ?>" value="<?php echo $binding; ?>" /></td>
                                    <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $i; ?>" value="<?php echo $folding; ?>" /></td>
                                </tr>-->
        <?php
        if ($entered['plot_arch'] == '1') {
            ?>
                                <tr bgcolor="#ffeee1">
                                    <td>Plotting on Bond</td>
                                    <td><?php echo $available_order[0]['origininals']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_1" class="avl_sets"  value="<?php echo ($available_order[0]['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_1" class="need_sets" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo $i; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo $i; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $i; ?>" value="<?php echo $entered['size']; ?>" /></td>
                                    <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $i; ?>" value="<?php echo $entered['output']; ?>" /></td>
                                    <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $i; ?>" value="<?php echo $entered['media']; ?>" /></td>
                                    <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $i; ?>" value="<?php echo $binding; ?>" /></td>
                                    <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $i; ?>" value="<?php echo $folding; ?>" /></td>
                                </tr>
                                <?php
                            }
                            ?>

        <?php
        if ($entered['plot_arch'] == '0') {
            ?>
                                <tr bgcolor="#ffeee1">
                                    <td>Architectural Copies</td>
                                    <td><?php echo $available_order[0]['origininals']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_2" class="avl_sets"  value="<?php echo ($available_order[0]['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_2" class="need_sets" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo '2'; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo '2'; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $i; ?>" value="<?php echo $entered['size']; ?>" /></td>
                                    <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $i; ?>" value="<?php echo $entered['output']; ?>" /></td>
                                    <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $i; ?>" value="<?php echo $entered['media']; ?>" /></td>
                                    <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $i; ?>" value="<?php echo $binding; ?>" /></td>
                                    <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $i; ?>" value="<?php echo $folding; ?>" /></td>
                                </tr>
                                <?php
                            }
                            ?>

        <?php
        $i++;
    }
    ?>
                    </table>
                </div>

                <div style="width: 99%;float: left;margin-top: 5px;">
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
    }if ($entered['plot_arch'] == '0') {
        if ($entered['pick_up_time'] != '0') {
            ?>
                            <div style="width: 22%;float: left;border: 1px solid #F99B3E;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                    Pickup Option
                                </div>
                                <div style="padding-top: 3px;width: 100%;float: left;">
                                    <input type="hidden" name="pick_up_time" id="pick_up_time" value="<?php echo $entered['pick_up_time']; ?>" />
            <?php echo $entered['pick_up_time'] . ' ' . $entered['pick_up_time']; ?>
                                </div>
                            </div>
        <?php }if ($entered['drop_off'] != '0') { ?>
                            <div style="width: 22%;float: left;border: 1px solid #F99B3E;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                    Pickup Option
                                </div>
                                <div style="padding-top: 3px;width: 100%;float: left;">
                                    <input type="hidden" name="drop_off" id="drop_off" value="<?php echo $entered['drop_off']; ?>" />
                        <?php echo $entered['drop_off']; ?>
                                </div>
                            </div>
                    <?php }
                } ?> 
                </div>

    <?php
    $all_days_off = AllDayOff();
    foreach ($all_days_off as $days_off_split) {
        $all_days_in[] = $days_off_split['date'];
    }
    $all_date = implode(",", $all_days_in);
    $all_date_exist = str_replace("/", "-", $all_date);
    ?>

            </div>

            <div style="float: left;width: 33%;margin-left: 30px;border: 1px #F99B3E solid;margin-top: 10px;font-weight: bold;padding:3px;">Send to: 
                <select  name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return show_address();">
                    <option value="0">Address Book</option>
    <?php
    $address_book = AddressBookCompanyService($_SESSION['sohorepro_companyid']);
    foreach ($address_book as $address) {
        ?>                                                                                        
                        <option value="<?php echo $address['id']; ?>" ><?php echo $address['company_name']; ?></option>
        <?php
    }
    ?>
                </select>
            </div>
            <!-- Address Show Start -->
            <div id="show_address" style="float: left;width: 56%;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">

            </div>

            <div style="float: left;width: 100%;margin-top: 5px;">   
                <div style="float: left;width: 40%;">
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
                                <input type="text" name="shipp_att" id="shipp_att" value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                    <span style="font-weight: bold;">When Needed:  </span>
                </div>
                <div style="width: 34%;float: left;"> 

                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;border-bottom: 0px;text-align: center;">
                        <span id="asap_status" class="asap_orange" onclick="return asap();">ASAP</span> 
                    </div>

                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                        <input class="picker_icon" value="" type="text" name="date_needed" id="date_needed" style="width: 75px;" onclick="date_reveal();" />
                        <input id="time_picker_icon" value="" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time();" />
                    </div>

                </div>
            </div>
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;margin-right: 10px;float: left;">
                        <input type="checkbox" name="arrange_del" id="arrange_del" checked style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="uncheck_delivery();" /><span style="text-transform: uppercase;">Soho to arrange delivery</span>
                    </div>

                    <!--<div id="delivery_info" style="width: 92%;display: none;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;">
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery:  </span>
                                    <select  name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address();">                    
                                        <option value="1">Next Day Air</option>
                                        <option value="2">Two Day Air</option>
                                        <option value="3">Three Day Air</option>
                                        <option value="4">Ground</option>
                                    </select>
                                </li>                    
                                <li id="shipp_collection">
                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" /> FedEx</span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" /> UPS</span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" /><input type="text" name="other_shipp_type" id="other_shipp_type"  onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #  :</span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>
                            </ul>
                        </div>-->

                </div>
                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;float: left;">
                        <input type="checkbox" name="preffer_del" id="preffer_del" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="check_prefer_delivery();" /><span style="text-transform: uppercase;">Use My Carrier</span>
                    </div>

                    <div id="preffered_info" style="width: 91%;display: none;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;">
                        <ul>                                       
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery:  </span>
                                    <select  name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address_();">                    
                                        <option value="1">Next Day Air</option>
                                        <option value="2">Two Day Air</option>
                                        <option value="3">Three Day Air</option>
                                        <option value="4">Ground</option>
                                    </select>
                                </li>                    
                                <li id="shipp_collection">
                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" /><input type="text" placeholder="Other" name="other_shipp_type" id="other_shipp_type"  onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>
                            </ul>
                            <!--<li>
                                    <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>-->
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
    <!-- New Recipients End -->

    <?php
} elseif ($_POST['recipients'] == '7') {
    $edit_rec_id = $_POST['edit_rec_id'];
    $user_session = $_POST['user_session'];
    $user_session_comp = $_POST['user_session_comp'];

    $entered_needed_sets = NeededSets($user_session_comp, $user_session);
    $r = 1;
    foreach ($entered_needed_sets as $entered_sets) {
        $shipp_add = SelectIdAddressService($entered_sets['shipp_id']);
        $plot_binding = ($entered_sets['binding'] == '0') ? '' : ',' . $entered_sets['binding'];
        $plot_foldding = ($entered_sets['folding'] == '0') ? '' : ',' . $entered_sets['folding'];
        $arch_binding = ($entered_sets['arch_binding'] == '0') ? '' : ',' . $entered_sets['arch_binding'];
        $arch_folding = ($entered_sets['arch_folding'] == '0') ? '' : ',' . $entered_sets['arch_folding'];
        if ($entered_sets['id'] == $edit_rec_id) {
            $edit_recipients = EditNeededSets($user_session_comp, $user_session, $edit_rec_id);
            ?>
            <div style="border: 1px #F99B3E solid;margin-top: 5px;padding-bottom: 20px;margin-bottom : 10px;width: 100%;float: left;">
                <div style="width: 100%;float: left;margin-top: 10px;">
                    <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo $r; ?></div>
                    <div style="float: right;width: 20%;font-weight: bold;">            
                        <span title="Update Recipient" alt="Update Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;" onclick="return update_recipient('<?php echo $entered_sets['id']; ?>');">Update</span>
                        <span title="Delete Recipient" alt="Delete Recipient" style="font-weight: bold;cursor: pointer;background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;" onclick="return delete_recipient('<?php echo $entered_sets['id']; ?>');">Delete</span>
                        <input type="hidden" name="recipient_edit_id" id="recipient_edit_id" value="<?php echo $edit_rec_id; ?>" />
                    </div>

            <?php
            $user_id_add_set = $_SESSION['sohorepro_userid'];
            $company_id_view_plot = $_SESSION['sohorepro_companyid'];
            ?>
                    <!-- Address Show End -->
                    <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                        <div id="sets_grid_new">
                            <table border="1" style="width: 100%;">
                                <tr bgcolor="#F99B3E">
                                    <td style="font-weight: bold;">Order Type</td>
                                    <td style="font-weight: bold;">Originals</td>
                                    <td style="font-weight: bold;">Available Sets</td>
                                    <td style="font-weight: bold;">Sets Needed</td>
                                    <td style="font-weight: bold;">Size</td>
                                    <td style="font-weight: bold;">Output</td>
                                    <td style="font-weight: bold;">Media</td>
                                    <td style="font-weight: bold;">Binding</td>
                                    <td style="font-weight: bold;">Folding</td>
                                </tr> 
                                <?php
                                $enteredPlot = EnteredPlotRecipients($company_id_view_plot, $user_id_add_set);
                                $i = 1;
                                foreach ($enteredPlot as $entered) {
                                    $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                                    $binding = strtoupper($entered['binding']);
                                    $folding = strtoupper($entered['folding']);
                                    $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Architectural Copies';
                                    $type = ($entered['plot_arch'] == '1') ? '1' : '0';
                                    $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1') : EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                                    $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeeded($company_id_view_plot, $user_id_add_set) : ArchSetsNeeded($company_id_view_plot, $user_id_add_set);
                                    ?>
                                    <tr bgcolor="<?php echo $rowColor; ?>">
                                        <td><?php echo $order_type; ?></td>
                                        <td><?php echo $available_order[0]['print_ea']; ?></td>
                                        <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_<?php echo $i; ?>" id="avl_sets_<?php echo $i; ?>" class="avl_sets"  value="<?php echo ($available_order[0]['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                        <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_<?php echo $i; ?>" id="need_sets_<?php echo $i; ?>" class="need_sets" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo $i; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo $i; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                        <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $i; ?>" value="<?php echo $entered['size']; ?>" /></td>
                                        <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $i; ?>" value="<?php echo $entered['output']; ?>" /></td>
                                        <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $i; ?>" value="<?php echo $entered['media']; ?>" /></td>
                                        <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $i; ?>" value="<?php echo $binding; ?>" /></td>
                                        <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $i; ?>" value="<?php echo $folding; ?>" /></td>
                                    </tr>
                            <?php
                            $i++;
                        }
                        ?>
                            </table>
                        </div>

                            <?php
                            if ($entered['size'] == 'Custom') {

                                $custome_details_size_pre = mysql_escape_string($entered['custome_details']);
                                ?>
                            <div style="padding-top: 5px;font-weight: bold;width: 100%;float: left;">
                                Custom Size Details :
                            </div>
                            <div style="padding-top: 3px;width: 100%;float: left;">
                                <input type="hidden" name="size_custom_details" id="size_custom_details" value="<?php echo $custome_details_size_pre; ?>" />
                            <?php echo $entered['custome_details']; ?>
                            </div>
                        <?php } ?>

            <?php
            $all_days_off = AllDayOff();
            foreach ($all_days_off as $days_off_split) {
                $all_days_in[] = $days_off_split['date'];
            }
            $all_date = implode(",", $all_days_in);
            $all_date_exist = str_replace("/", "-", $all_date);
            ?>
                    </div>

                    <div style="float: left;width: 33%;margin-left: 30px;border: 1px #F99B3E solid;margin-top: 10px;font-weight: bold;padding:3px;">Send to: 
                        <select  name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return show_address();">
                            <option value="0">Address Book</option>
                            <?php
                            $address_book = AddressBookCompanyService($_SESSION['sohorepro_companyid']);
                            foreach ($address_book as $address) {
                                if ($address['id'] == $edit_recipients[0]['shipp_id']) {
                                    ?>
                                    <option value="<?php echo $address['id']; ?>" selected="selected" ><?php echo $address['company_name']; ?></option>
                <?php } else {
                    ?>
                                    <option value="<?php echo $address['id']; ?>" ><?php echo $address['company_name']; ?></option>
                                <?php
                            }
                        }
                        ?>
                        </select>
                    </div>
                    <!-- Address Show Start -->
                    <div id="show_address" style="float: left;width: 56%;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">
            <?php
            $shipp_add = SelectIdAddressService($edit_recipients[0]['shipp_id']);
            $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . ',  ';
            echo $shipp_add[0]['address_1'] . ', ' . $add_2 . $shipp_add[0]['city'] . ', ' . StateName($shipp_add[0]['state']) . ' ' . $shipp_add[0]['zip'];
            ?>
                    </div>
                    <div style="float: left;width: 100%;margin-top: 5px;">   
                        <div style="float: left;width: 40%;">
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
                                        <input type="text" name="shipp_att" id="shipp_att" value="<?php echo $edit_recipients[0]['attention_to']; ?>" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                                        <input type="text" name="contact_ph" id="contact_ph" onfocus="return contact_phone();"  value="<?php echo $edit_recipients[0]['contact_ph']; ?>" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Contact Phone End -->
                    </div>  

                    <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                        <input type="hidden" name="all_exist_date" id="all_exist_date" value="<?php echo $all_date_exist; ?>" />
                        <div style="float:left;margin-right: 5px;margin-top: 10px;width: 100%;">
                            <span style="font-weight: bold;">When Needed:  </span>
                        </div>
                        <div style="width: 34%;float: left;"> 

                            <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;border-bottom: 0px;text-align: center;">
                                <span style="cursor: pointer;display: inline-block;background: #019E59;color: #FFF;padding: 5px 20px;border-radius: 5px;margin-top: 3px;font-weight: bold;" onclick="return asap();">ASAP</span>
                            </div>

                            <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                                <input class="picker_icon" value="<?php echo $entered_sets['shipp_date']; ?>" type="text" name="date_needed" id="date_needed" style="width: 75px;" onclick="date_reveal();" />
                                <input id="time_picker_icon" value="<?php echo $entered_sets['shipp_time']; ?>" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time();" />
                            </div>

                        </div>
                    </div>

                    <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
            <?php
            $checked = ($edit_recipients[0]['delivery_type'] != '0') ? '' : 'checked';
            $display = ($edit_recipients[0]['delivery_type'] != '0') ? '' : 'display: none;';
            $shipp_comp_1 = ($edit_recipients[0]['shipp_comp_1'] != '0') ? 'checked' : '';
            $shipp_comp_2 = ($edit_recipients[0]['shipp_comp_2'] != '0') ? 'checked' : '';
            $shipp_comp_3 = ($edit_recipients[0]['shipp_comp_3'] != '0') ? 'checked' : '';
            $bill_val = ($edit_recipients[0]['billing_number'] != '0') ? $edit_recipients[0]['billing_number'] : '';
            ?>
                        <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 200px;">
                            <input type="checkbox" name="arrange_del" id="arrange_del" <?php echo $checked; ?> style="width: 10% !important;margin-bottom: 0px;" onclick="uncheck_delivery();" /><span style="text-transform: uppercase;">Soho to arrange delivery</span>
                        </div>
                    </div>

                    <div id="delivery_info" style="width: 65%;float: left;margin-left: 45px;margin-top: 10px;<?php echo $display; ?>">
                        <div style="border: 1px #F99B3E solid;width: 50%;margin-left: 20px;padding: 5px;">
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery:  </span>
                                    <select  name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address_();">                    
                                        <option value="1" <?php if ($edit_recipients[0]['delivery_type'] == '1') { ?> selected="selected" <?php } ?>>Next Day Air</option> 
                                        <option value="2" <?php if ($edit_recipients[0]['delivery_type'] == '2') { ?> selected="selected" <?php } ?>>Two Day Air</option>
                                        <option value="3" <?php if ($edit_recipients[0]['delivery_type'] == '3') { ?> selected="selected" <?php } ?>>Three Day Air</option>
                                        <option value="4" <?php if ($edit_recipients[0]['delivery_type'] == '4') { ?> selected="selected" <?php } ?>>Ground</option>
                                    </select>
                                </li>                    
                                <li>
                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" <?php echo $shipp_comp_1; ?> /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" <?php echo $shipp_comp_2; ?> /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" <?php echo $shipp_comp_3; ?> /><input type="text" name="other_shipp_type" placeholder="Other" id="other_shipp_type" value="<?php echo ($edit_recipients[0]['shipp_comp_3'] != '0') ? $edit_recipients[0]['shipp_comp_3'] : ''; ?>" onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number" value="<?php echo $bill_val; ?>" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>
                            </ul>
                        </div>            
                    </div>

                    <div style="font-weight: bold;width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                        Special Instructions:            
                    </div>        
                    <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                        <textarea name="spl_recipient" id="spl_recipient" rows="3" cols="18" style="width: 200px;height: 40px;"><?php echo $edit_recipients[0]['spl_inc']; ?></textarea>
                    </div>

                </div>
            </div>
            <?php
        } else {
            ?>
            <div style="border: 2px #F99B3E solid;padding-bottom: 20px;margin-bottom : 5px;width: 100%;float: left;" class="shaddows">
                <div style="width: 100%;float: left;margin-top: 10px;">
                    <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo $r; ?></div>
                    <div style="float: right;width: 20%;font-weight: bold;">
                        <span title="Edit Recipient" alt="Edit Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;font-weight: bold;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;" onclick="return edit_recipient('<?php echo $entered_sets['id']; ?>');">Edit</span>
                        <span title="Delete Recipient" alt="Delete Recipient" style="font-weight: bold;cursor: pointer;background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;" onclick="return delete_recipient('<?php echo $entered_sets['id']; ?>');">Delete</span>
                    </div>

                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 10px;font-weight: bold;">Send to: </div>
                    <div style="float: left;width: 33%;margin-left: 30px;">  
            <?php
            $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . ',<br>';
            echo $shipp_add[0]['company_name'] . '<br>' . 'Attention:  ' . $entered_sets['attention_to'] . '<br>' . 'Conatct:  ' . $entered_sets['contact_ph'] . '<br>' . $shipp_add[0]['address_1'] . '<br>' . $add_2 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'];
            ?>                   
                    </div>
                    <!-- Address Show End -->

                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">

                        <table border="1" style="width: 100%;">
                            <tr bgcolor="#F99B3E">
                                <td style="font-weight: bold;">Sets</td> 
                                <td style="font-weight: bold;">Order Type</td>                            
                                <td style="font-weight: bold;">Size</td>
                                <td style="font-weight: bold;">Output</td>
                                <td style="font-weight: bold;">Binding</td>
                                <td style="font-weight: bold;">Folding</td>
                            </tr>
                            <tr bgcolor="#ffeee1">
                                <td><?php echo $entered_sets['plot_needed']; ?></td>
                                <td>Plotting on Bond</td>                            
                                <td><?php echo $entered_sets['size']; ?></td>
                                <td><?php echo $entered_sets['output']; ?></td>
                                <td>
                                    <span onclick="return edit_binding('<?php echo $entered_sets['id']; ?>');" id="binding_<?php echo $entered_sets['id']; ?>" style="cursor: pointer;"><?php echo $entered_sets['binding']; ?></span>
                                    <select class="binding_select_<?php echo $entered_sets['id']; ?>" id="binding_select_<?php echo $entered_sets['id']; ?>" onchange="return change_binding('<?php echo $entered_sets['id']; ?>');" style="width: 65px;display:none;">
                                        <option value="None" <?php if ($entered_sets['binding'] == 'NONE') { ?> selected="selected" <?php } ?>>None</option>                                      
                                        <option value="Bind All" <?php if ($entered_sets['binding'] == 'BIND ALL') { ?> selected="selected" <?php } ?>>Bind All</option>                          
                                        <option value="Bind by Discipline" <?php if ($entered_sets['binding'] == 'BIND BY DISCIPLINE') { ?> selected="selected" <?php } ?>>Bind by Discipline</option>
                                        <option value="Screw Post" <?php if ($entered_sets['binding'] == 'SCREW POST') { ?> selected="selected" <?php } ?>>Screw Post</option>
                                    </select>                                        
                                </td>
                                <td><?php echo $entered_sets['folding']; ?></td>
                            </tr>
                        </table>

                                <!--   1. <?php // echo $entered_sets['plot_needed'] . '&nbsp;Sets Plotting on Bond,' . $entered_sets['size'] . ',' . $entered_sets['output'] . $plot_binding . $plot_folding;   ?></br>-->
                        <!--   2. <?php // echo  $entered_sets['arch_needed'].'&nbsp;Sets Plotting on Bond,'. $entered_sets['arch_size'].','.$entered_sets['arch_output'].$arch_binding.$arch_folding;     ?> -->
                    </div>   


            <?php
            if ($entered_sets['size'] == 'Custom') {
                ?>
                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                            <div style="font-weight: bold;width: 100%;float: left;">
                                Custom Size Details :
                            </div>
                            <div style="width: 100%;float: left;">                    
                <?php echo $entered_sets['custome_details']; ?>
                            </div>
                        </div>
                            <?php } ?>

            <?php
            if ($entered_sets['output'] == 'Both') {
                ?>
                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                            <div style="font-weight: bold;width: 100%;float: left;">
                                Color Page Numbers :
                            </div>
                            <div style="width: 100%;float: left;">                    
                            <?php echo $entered_sets['output_page_number']; ?>
                            </div>
                        </div>
                    <?php } ?>


                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;">
            <?php
            $date_asap = ($entered_sets['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_sets['shipp_time'] : '';
            ?>
                        <span style="font-weight: bold;">When Needed:  </span><?php echo $entered_sets['shipp_date'] . $date_asap; ?>            
                    </div>        
                        <?php
                        if ($entered_sets['delivery_type'] != '0') {
                            ?>
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            <span style="font-weight: bold;">Send Via: </span>
                        </div>
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            <?php
                            if ($entered_sets['delivery_type'] == '1') {
                                $delivery_type = 'Next Day Air';
                            } elseif ($entered_sets['delivery_type'] == '2') {
                                $delivery_type = 'Two Day Air';
                            } elseif ($entered_sets['delivery_type'] == '3') {
                                $delivery_type = 'Three Day Air';
                            } elseif ($entered_sets['delivery_type'] == '4') {
                                $delivery_type = 'Ground';
                            }

                            $ship_type_1 = ($entered_sets['shipp_comp_1'] == '0') ? '' : $entered_sets['shipp_comp_1'];
                            $ship_type_2 = ($entered_sets['shipp_comp_2'] == '0') ? '' : $entered_sets['shipp_comp_2'];
                            $ship_type_3 = ($entered_sets['shipp_comp_3'] == '0') ? '' : $entered_sets['shipp_comp_3'];

                            echo $ship_type_1 . $ship_type_2 . $ship_type_3 . ',&nbsp;' . $delivery_type . ',&nbsp;Account # ' . $entered_sets['billing_number'];
                            ?>
                        </div>
            <?php } else { ?>                            
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            <span style="font-weight: bold;">Send Via: </span>
                        </div>
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            SOHO TO ARRANGE DELIVERY
                        </div>    
            <?php } ?>        
                </div>
            </div>
            <?php
        }
        $r++;
    }
    ?>
    <?php
} elseif ($_POST['recipients'] == '6') {

    $edit_recipient_id = $_POST['edit_recipient_id'];

    $shipping_id_rec = $_POST['shipping_id_rec'];
    $user_session = $_POST['user_session'];
    $user_session_comp = $_POST['user_session_comp'];
    $date_needed = $_POST['date_needed'];
    $time_needed = $_POST['time_needed'];
    $spl_recipient = $_POST['spl_recipient'];

    $avl_sets_1 = $_POST['avl_sets_1'];
    $need_sets_1 = $_POST['need_sets_1'];
    $size_sets_1 = $_POST['size_sets_1'];
    $output_sets_1 = $_POST['output_sets_1'];
    $binding_sets_1 = $_POST['binding_sets_1'];
    $folding_sets_1 = $_POST['folding_sets_1'];

    $avl_sets_2 = $_POST['avl_sets_2'];
    $need_sets_2 = $_POST['need_sets_2'];
    $size_sets_2 = $_POST['size_sets_2'];
    $output_sets_2 = $_POST['output_sets_2'];
    $binding_sets_2 = $_POST['binding_sets_2'];
    $folding_sets_2 = $_POST['folding_sets_2'];

    $delivery_type = $_POST['delivery_type'];
    $bill_number = $_POST['bill_number'];
    $shipp_comp_1_f = $_POST['shipp_comp_1_f'];
    $shipp_comp_2_f = $_POST['shipp_comp_2_f'];
    $shipp_comp_3_f = $_POST['shipp_comp_3_f'];

    $attention_to = $_POST['attention_to'];

    $size_custom_details = mysql_real_escape_string($_POST['size_custom_details']);

    $query = "UPDATE sohorepro_sets_needed
			SET     comp_id         = '" . $user_session_comp . "',
                                usr_id          = '" . $user_session . "',
                                plot_needed     = '" . $need_sets_1 . "',
                                size            = '" . $size_sets_1 . "',
                                custome_details  = '" . $size_custom_details . "',   
                                output          = '" . $output_sets_1 . "',
                                binding         = '" . $binding_sets_1 . "',
                                folding         = '" . $folding_sets_1 . "',
                                arch_needed     = '" . $need_sets_2 . "',
                                arch_size       = '" . $size_sets_2 . "',
                                arch_output     = '" . $output_sets_2 . "',
                                arch_binding    = '" . $binding_sets_2 . "',
                                arch_folding    = '" . $folding_sets_2 . "',    
                                shipp_id        = '" . $shipping_id_rec . "',
                                attention_to    = '" . $attention_to . "',   
                                shipp_date      = '" . $date_needed . "',
                                shipp_time      = '" . $time_needed . "',  
                                spl_inc         = '" . $spl_recipient . "',
                                delivery_type   = '" . $delivery_type . "',
                                billing_number  = '" . $bill_number . "',
                                shipp_comp_1    = '" . $shipp_comp_1_f . "',
                                shipp_comp_2    = '" . $shipp_comp_2_f . "',
                                shipp_comp_3    = '" . $shipp_comp_3_f . "'  WHERE id = '" . $edit_recipient_id . "' ";

    $sql_result = mysql_query($query);

    $entered_needed_sets = NeededSets($user_session_comp, $user_session);
    $r = 1;
    foreach ($entered_needed_sets as $entered_sets) {
        $shipp_add = SelectIdAddressService($entered_sets['shipp_id']);
        $plot_binding = ($entered_sets['binding'] == '0') ? '' : ',' . $entered_sets['binding'];
        $plot_folding = ($entered_sets['folding'] == '0') ? '' : ',' . $entered_sets['folding'];
        $arch_binding = ($entered_sets['arch_binding'] == '0') ? '' : ',' . $entered_sets['arch_binding'];
        $arch_folding = ($entered_sets['arch_folding'] == '0') ? '' : ',' . $entered_sets['arch_folding'];
        ?>
        <div style="border: 2px #F99B3E solid;height: 275px;margin-bottom: 5px;" class="shaddows">
            <div style="width: 100%;float: left;margin-top: 10px;">
                <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo $r; ?></div>
                <div style="float: right;width: 20%;font-weight: bold;">
                    <span title="Edit Recipient" alt="Edit Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;font-weight: bold;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;" onclick="return edit_recipient('<?php echo $entered_sets['id']; ?>');">Edit</span>
                    <span title="Delete Recipient" alt="Delete Recipient" style="font-weight: bold;cursor: pointer;background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;" onclick="return delete_recipient('<?php echo $entered_sets['id']; ?>');">Delete</span>
                </div>

                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 10px;font-weight: bold;">Send to: </div>
                <div style="float: left;width: 33%;margin-left: 30px;">  
        <?php
        $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . ',<br>';
        echo $shipp_add[0]['company_name'] . '<br>' . 'Attention:  ' . $entered_sets['attention_to'] . '<br>' . 'Conatct:  ' . $entered_sets['contact_ph'] . '<br>' . $shipp_add[0]['address_1'] . ',<br>' . $add_2 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'];
        ?>                   
                </div>
                <!-- Address Show End -->

                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>
                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">

                    <table border="1" style="width: 100%;">
                        <tr bgcolor="#F99B3E">
                            <td style="font-weight: bold;">Sets</td> 
                            <td style="font-weight: bold;">Order Type</td>                            
                            <td style="font-weight: bold;">Size</td>
                            <td style="font-weight: bold;">Output</td>
                            <td style="font-weight: bold;">Media</td>
                            <td style="font-weight: bold;">Binding</td>
                            <td style="font-weight: bold;">Folding</td>
                        </tr>
                        <tr bgcolor="#ffeee1">
                            <td><?php echo $entered_sets['plot_needed']; ?></td>
                            <td>Plotting on Bond</td>                            
                            <td><?php echo $entered_sets['size']; ?></td>
                            <td><?php echo $entered_sets['output']; ?></td>
                            <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="output_sets_<?php echo $i; ?>" value="<?php echo $entered['media']; ?>" /></td>
                            <td>
                                <span onclick="return edit_binding('<?php echo $entered_sets['id']; ?>');" id="binding_<?php echo $entered_sets['id']; ?>" style="cursor: pointer;"><?php echo $entered_sets['binding']; ?></span>
                                <select class="binding_select_<?php echo $entered_sets['id']; ?>" id="binding_select_<?php echo $entered_sets['id']; ?>" onchange="return change_binding('<?php echo $entered_sets['id']; ?>');" style="width: 65px;display:none;">
                                    <option value="None" <?php if ($entered_sets['binding'] == 'NONE') { ?> selected="selected" <?php } ?>>None</option>                                      
                                    <option value="Bind All" <?php if ($entered_sets['binding'] == 'BIND ALL') { ?> selected="selected" <?php } ?>>Bind All</option>                          
                                    <option value="Bind by Discipline" <?php if ($entered_sets['binding'] == 'BIND BY DISCIPLINE') { ?> selected="selected" <?php } ?>>Bind by Discipline</option>
                                    <option value="Screw Post" <?php if ($entered_sets['binding'] == 'SCREW POST') { ?> selected="selected" <?php } ?>>Screw Post</option>
                                </select>
                            </td>
                            <td><?php echo $entered_sets['folding']; ?></td>
                        </tr>
                    </table>

        <!-- 1. <?php //echo $entered_sets['plot_needed'] . '&nbsp;Sets Plotting on Bond,' . $entered_sets['size'] . ',' . $entered_sets['output'] . $plot_binding . $plot_folding;  ?></br>-->
                    <!-- 2. <?php // echo  $entered_sets['arch_needed'].'&nbsp;Sets Plotting on Bond,'. $entered_sets['arch_size'].','.$entered_sets['arch_output'].$arch_binding.$arch_folding;    ?> -->
                </div>   

                        <?php
                        if ($entered_sets['size'] == 'Custom') {
                            ?>
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                        <div style="font-weight: bold;width: 100%;float: left;">
                            Custom Size Details :
                        </div>
                        <div style="width: 100%;float: left;">
                            <input type="hidden" name="size_custom_details" id="size_custom_details" value="<?php echo $entered_sets['custome_details']; ?>" />
            <?php echo $entered_sets['custome_details']; ?>
                        </div>
                    </div>
                <?php } ?>

                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;">
        <?php
        $date_asap = ($entered_sets['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_sets['shipp_time'] : '';
        ?>
                    <span style="font-weight: bold;">When Needed:  </span><?php echo $entered_sets['shipp_date'] . $date_asap; ?>             
                </div>        
                    <?php
                    if ($entered_sets['delivery_type'] != '0') {
                        ?>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Send Via: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <?php
                        if ($entered_sets['delivery_type'] == '1') {
                            $delivery_type = 'Next Day Air';
                        } elseif ($entered_sets['delivery_type'] == '2') {
                            $delivery_type = 'Two Day Air';
                        } elseif ($entered_sets['delivery_type'] == '3') {
                            $delivery_type = 'Three Day Air';
                        } elseif ($entered_sets['delivery_type'] == '4') {
                            $delivery_type = 'Ground';
                        }

                        $ship_type_1 = ($entered_sets['shipp_comp_1'] == '0') ? '' : $entered_sets['shipp_comp_1'];
                        $ship_type_2 = ($entered_sets['shipp_comp_2'] == '0') ? '' : $entered_sets['shipp_comp_2'];
                        $ship_type_3 = ($entered_sets['shipp_comp_3'] == '0') ? '' : $entered_sets['shipp_comp_3'];

                        echo $ship_type_1 . $ship_type_2 . $ship_type_3 . ',&nbsp;' . $delivery_type . ',&nbsp;Account # ' . $entered_sets['billing_number'];
                        ?>
                    </div>
        <?php } else { ?>                            
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Send Via: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        SOHO TO ARRANGE DELIVERY
                    </div>    
        <?php } ?>        
            </div>
        </div>
        <?php
        $r++;
    }
    ?>

    <!-- New Recipients Start -->
    <div style="border: 1px #F99B3E solid;margin-top: 5px;float: left;padding-bottom: 10px;margin-bottom: 10px;">
        <div style="width: 100%;float: left;margin-top: 10px;">
            <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo (count($entered_needed_sets) + 1); ?></div>
            <div style="float: right;width: 20%;font-weight: bold;">
                <span title="Delete Recipient" alt="Delete Recipient" style="font-weight: bold;cursor: pointer;background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;" onclick="return delete_recipient_empty();">Delete</span>
            </div>


    <?php
    $user_id_add_set = $_SESSION['sohorepro_userid'];
    $company_id_view_plot = $_SESSION['sohorepro_companyid'];
    ?>
            <!-- Address Show End -->
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                <div id="sets_grid_new">
                    <table border="1" style="width: 100%;">
                        <tr bgcolor="#F99B3E">
                            <td style="font-weight: bold;">Order Type</td>
                            <td style="font-weight: bold;">Originals</td>
                            <td style="font-weight: bold;">Available Sets</td>
                            <td style="font-weight: bold;">Sets Needed</td>
                            <td style="font-weight: bold;">Size</td>
                            <td style="font-weight: bold;">Output</td>
                            <td style="font-weight: bold;">Media</td>
                            <td style="font-weight: bold;">Binding</td>
                            <td style="font-weight: bold;">Folding</td>
                        </tr> 
                        <?php
                        $enteredPlot = EnteredPlotRecipients($company_id_view_plot, $user_id_add_set);
                        $i = 1;
                        foreach ($enteredPlot as $entered) {
                            $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                            $binding = strtoupper($entered['binding']);
                            $folding = strtoupper($entered['folding']);
                            $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Architectural Copies';
                            $type = ($entered['plot_arch'] == '1') ? '1' : '0';
                            $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1') : EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                            $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeeded($company_id_view_plot, $user_id_add_set) : ArchSetsNeeded($company_id_view_plot, $user_id_add_set);
                            ?>
                            <tr bgcolor="<?php echo $rowColor; ?>">
                                <td><?php echo $order_type; ?></td>
                                <td><?php echo $available_order[0]['print_ea']; ?></td>
                                <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_<?php echo $i; ?>" class="avl_sets" id="avl_sets_<?php echo $i; ?>"  value="<?php echo ($available_order[0]['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_<?php echo $i; ?>" class="need_sets" id="need_sets_<?php echo $i; ?>" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo $i; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo $i; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $i; ?>" value="<?php echo $entered['size']; ?>" /></td>
                                <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $i; ?>" value="<?php echo $entered['output']; ?>" /></td>
                                <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $i; ?>" value="<?php echo $entered['media']; ?>" /></td>
                                <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $i; ?>" value="<?php echo $binding; ?>" /></td>
                                <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $i; ?>" value="<?php echo $folding; ?>" /></td>
                            </tr>
                    <?php
                    $i++;
                }
                ?>
                    </table>
                </div>

                        <?php
                        if ($entered['size'] == 'Custom') {
                            ?>
                    <div style="float: left;width: 65%;margin-top: 5px;">
                        <div style="font-weight: bold;width: 100%;float: left;">
                            Custom Size Details :
                        </div>
                        <div style="width: 100%;float: left;">
                            <input type="hidden" name="size_custom_details" id="size_custom_details" value="<?php echo $entered['custome_details']; ?>" />
                    <?php echo $entered['custome_details']; ?>
                        </div>
                    </div>
                <?php } ?>

    <?php
    $all_days_off = AllDayOff();
    foreach ($all_days_off as $days_off_split) {
        $all_days_in[] = $days_off_split['date'];
    }
    $all_date = implode(",", $all_days_in);
    $all_date_exist = str_replace("/", "-", $all_date);
    ?>
            </div>

            <div style="float: left;width: 33%;margin-left: 30px;border: 1px #F99B3E solid;margin-top: 10px;font-weight: bold;padding:3px;">Send to: 
                <select  name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return show_address();">
                    <option value="0">Address Book</option>
    <?php
    $address_book = AddressBookCompanyService($_SESSION['sohorepro_companyid']);
    foreach ($address_book as $address) {
        ?>                                                                                        
                        <option value="<?php echo $address['id']; ?>" ><?php echo $address['company_name']; ?></option>
        <?php
    }
    ?>
                </select>
            </div>
            <!-- Address Show Start -->
            <div id="show_address" style="float: left;width: 56%;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">

            </div>

            <div style="float: left;width: 100%;margin-top: 5px;">   
                <div style="float: left;width: 40%;">
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
                                <input type="text" name="shipp_att" id="shipp_att" value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                    <span style="font-weight: bold;">When Needed:  </span>
                </div>
                <div style="width: 34%;float: left;"> 

                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;border-bottom: 0px;text-align: center;">
                        <span id="asap_status" class="asap_orange" onclick="return asap();">ASAP</span>
                    </div>

                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                        <input class="picker_icon" value="" type="text" name="date_needed" id="date_needed" style="width: 75px;" onclick="date_reveal();" />
                        <input id="time_picker_icon" value="" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time();" />
                    </div>

                </div>
            </div>

            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;margin-right: 10px;float: left;">
                        <input type="checkbox" name="arrange_del" id="arrange_del" checked style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="uncheck_delivery();" /><span style="text-transform: uppercase;">Soho to arrange delivery</span>
                    </div>

                    <!--<div id="delivery_info" style="width: 92%;display: none;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;">
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery:  </span>
                                    <select  name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address();">                    
                                        <option value="1">Next Day Air</option>
                                        <option value="2">Two Day Air</option>
                                        <option value="3">Three Day Air</option>
                                        <option value="4">Ground</option>
                                    </select>
                                </li>                    
                                <li id="shipp_collection">
                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" /> FedEx</span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" /> UPS</span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" /><input type="text" name="other_shipp_type" id="other_shipp_type"  onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #  :</span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>
                            </ul>
                        </div>-->

                </div>
                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;float: left;">
                        <input type="checkbox" name="preffer_del" id="preffer_del" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="check_prefer_delivery();" /><span style="text-transform: uppercase;">Use My Carrier</span>
                    </div>

                    <div id="preffered_info" style="width: 91%;display: none;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;">
                        <ul>                                       
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery:  </span>
                                    <select  name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address_();">                    
                                        <option value="1">Next Day Air</option>
                                        <option value="2">Two Day Air</option>
                                        <option value="3">Three Day Air</option>
                                        <option value="4">Ground</option>
                                    </select>
                                </li>                    
                                <li id="shipp_collection">
                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" /><input type="text" placeholder="Other" name="other_shipp_type" id="other_shipp_type"  onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;" />
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
    <!-- New Recipients End -->

    <?php
} elseif ($_POST['recipients'] == '5') {

    $user_session = $_POST['inc_avl_user_id'];
    $user_session_comp = $_POST['inc_avl_comp_id'];
    $type = $_POST['inc_avl_type'];
    $row_id = $_POST['inc_avl_rec_id'];
    $sets_current_1 = $_POST['need_sets_current_1'];
    $sets_current_2 = $_POST['need_sets_current_2'];
    $need_sets_avl_sets = $_POST['need_sets_avl_sets'];

    $sql_last_id = mysql_query("SELECT print_ea FROM sohorepro_plotting_set WHERE company_id = '" . $user_session_comp . "' AND user_id = '" . $user_session . "'");
    $object_last_id = mysql_fetch_assoc($sql_last_id);
    $last_id = $object_last_id['print_ea'] + 1;


    $sql_3 = "UPDATE sohorepro_plotting_set SET print_ea = '" . $last_id . "' WHERE company_id = '" . $user_session_comp . "' AND user_id = '" . $user_session . "'  ";
    mysql_query($sql_3);
    ?>
    <table border="1" style="width: 100%;">
        <tr bgcolor="#F99B3E">
            <td style="font-weight: bold;">Order Type</td>
            <td style="font-weight: bold;">Originals</td>
            <td style="font-weight: bold;">Available Sets</td>
            <td style="font-weight: bold;">Sets Needed</td>
            <td style="font-weight: bold;">Size</td>
            <td style="font-weight: bold;">Output</td>
            <td style="font-weight: bold;">Media</td>
            <td style="font-weight: bold;">Binding</td>
            <td style="font-weight: bold;">Folding</td>
        </tr> 
        <?php
        $enteredPlot = EnteredPlotRecipients($user_session_comp, $user_session);
        $i = 1;
        foreach ($enteredPlot as $entered) {
            $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
            $binding = strtoupper($entered['binding']);
            $folding = strtoupper($entered['folding']);
            $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Architectural Copies';
            $type = ($entered['plot_arch'] == '1') ? '1' : '0';
            $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($user_session_comp, $user_session, '1') : EnteredPlotRecipientsCount($user_session_comp, $user_session, '0');
            $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeeded($user_session_comp, $user_session) : ArchSetsNeeded($user_session_comp, $user_session);
            $need_current = ($entered['plot_arch'] == '1') ? $sets_current_1 : $sets_current_2;
            ?>
            <tr bgcolor="<?php echo $rowColor; ?>">
                <td><?php echo $order_type; ?></td>
                <td><?php echo $available_order[0]['print_ea']; ?></td>
                <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_<?php echo $i; ?>" class="avl_sets" id="avl_sets_<?php echo $i; ?>"  value="<?php echo ($available_order[0]['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl('<?php echo $i; ?>', '<?php echo $user_session; ?>', '<?php echo $user_session_comp; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_session; ?>', '<?php echo $user_session_comp; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_<?php echo $i; ?>" class="need_sets" id="need_sets_<?php echo $i; ?>" value="<?php echo $need_current; ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo $i; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo $i; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $i; ?>" value="<?php echo $entered['size']; ?>" /></td>
                <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $i; ?>" value="<?php echo $entered['output']; ?>" /></td>
                <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $i; ?>" value="<?php echo $entered['media']; ?>" /></td>
                <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $i; ?>" value="<?php echo $binding; ?>" /></td>
                <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $i; ?>" value="<?php echo $folding; ?>" /></td>
            </tr>
        <?php
        $i++;
    }
    ?>
    </table>

    <?php
} elseif ($_POST['recipients'] == '4') {

    $user_session = $_POST['inc_avl_user_id'];
    $user_session_comp = $_POST['inc_avl_comp_id'];
    $type = $_POST['inc_avl_type'];
    $row_id = $_POST['inc_avl_rec_id'];
    $sets_current_1 = $_POST['need_sets_current_1'];
    $sets_current_2 = $_POST['need_sets_current_2'];
    $decrese_avl_sets = $_POST['decrese_avl_sets'];

//    $sql_1              =   "DELETE FROM sohorepro_plotting_set WHERE id = '".$row_id."' ";
//    mysql_query($sql_1); 

    $sql_3 = "UPDATE sohorepro_plotting_set SET print_ea = '" . $decrese_avl_sets . "' WHERE company_id = '" . $user_session_comp . "' AND user_id = '" . $user_session . "'  ";
    mysql_query($sql_3);
    ?>
    <table border="1" style="width: 100%;">
        <tr bgcolor="#F99B3E">
            <td style="font-weight: bold;">Order Type</td>
            <td style="font-weight: bold;">Originals</td>
            <td style="font-weight: bold;">Available Sets</td>
            <td style="font-weight: bold;">Sets Needed</td>
            <td style="font-weight: bold;">Size</td>
            <td style="font-weight: bold;">Output</td>
            <td style="font-weight: bold;">Media</td>
            <td style="font-weight: bold;">Binding</td>
            <td style="font-weight: bold;">Folding</td>
        </tr> 
        <?php
        $enteredPlot = EnteredPlotRecipients($user_session_comp, $user_session);
        $i = 1;
        foreach ($enteredPlot as $entered) {
            $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
            $binding = strtoupper($entered['binding']);
            $folding = strtoupper($entered['folding']);
            $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Architectural Copies';
            $type = ($entered['plot_arch'] == '1') ? '1' : '0';
            $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($user_session_comp, $user_session, '1') : EnteredPlotRecipientsCount($user_session_comp, $user_session, '0');
            $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeeded($user_session_comp, $user_session) : ArchSetsNeeded($user_session_comp, $user_session);
            $need_current = ($entered['plot_arch'] == '1') ? $sets_current_1 : $sets_current_2;
            ?>
            <tr bgcolor="<?php echo $rowColor; ?>">
                <td><?php echo $order_type; ?></td>
                <td><?php echo $available_order[0]['print_ea']; ?></td>
                <td><input style="width: 25px;float: left;padding: 2px;" type="text" class="avl_sets" name="avl_sets_<?php echo $i; ?>" id="avl_sets_<?php echo $i; ?>"  value="<?php echo ($available_order[0]['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl('<?php echo $i; ?>', '<?php echo $user_session; ?>', '<?php echo $user_session_comp; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_session; ?>', '<?php echo $user_session_comp; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                <td><input style="width: 25px;float: left;padding: 2px;" type="text" class="need_sets" name="need_sets_<?php echo $i; ?>" id="need_sets_<?php echo $i; ?>" value="<?php echo $need_current; ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo $i; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo $i; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $i; ?>" value="<?php echo $entered['size']; ?>" /></td>
                <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $i; ?>" value="<?php echo $entered['output']; ?>" /></td>
                <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $i; ?>" value="<?php echo $entered['media']; ?>" /></td>
                <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $i; ?>" value="<?php echo $binding; ?>" /></td>
                <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $i; ?>" value="<?php echo $folding; ?>" /></td>
            </tr>
        <?php
        $i++;
    }
    ?>
    </table>

    <?php
} elseif ($_POST['recipients'] == '55') {

    $user_session = $_POST['inc_avl_user_id'];
    $user_session_comp = $_POST['inc_avl_comp_id'];
    $type = ($_POST['inc_avl_type'] == '1') ? '0' : '1';
    $change_type = ($_POST['inc_avl_type'] == '1') ? '1' : '0';
    $row_id = $_POST['inc_avl_rec_id'];

    $sql_last_id = mysql_query("SELECT id FROM sohorepro_plotting_set ORDER BY id DESC LIMIT 1");
    $object_last_id = mysql_fetch_assoc($sql_last_id);
    $last_id = $object_last_id['id'] + 1;

    $sql_1 = "CREATE TEMPORARY TABLE tmp SELECT * FROM sohorepro_plotting_set WHERE plot_arch = '" . $type . "' LIMIT 1 ";
    mysql_query($sql_1);
    $sql_2 = "UPDATE tmp SET id = '" . $last_id . "', plot_arch = '" . $change_type . "' WHERE plot_arch = '" . $type . "'";
    mysql_query($sql_2);
    $sql_3 = "INSERT INTO sohorepro_plotting_set SELECT * FROM tmp WHERE id = '" . $last_id . "' ";
    mysql_query($sql_3);
    ?>
    <table border="1" style="width: 100%;">
        <tr bgcolor="#F99B3E">
            <td style="font-weight: bold;">Order Type</td>
            <td style="font-weight: bold;">Originals</td>
            <td style="font-weight: bold;">Available Sets</td>
            <td style="font-weight: bold;">Sets Needed</td>
            <td style="font-weight: bold;">Size</td>
            <td style="font-weight: bold;">Output</td>
            <td style="font-weight: bold;">Media</td>
            <td style="font-weight: bold;">Binding</td>
            <td style="font-weight: bold;">Folding</td>
        </tr> 
        <?php
        $enteredPlot = EnteredPlotRecipients($user_session_comp, $user_session);
        $i = 1;
        foreach ($enteredPlot as $entered) {
            $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
            $binding = strtoupper($entered['binding']);
            $folding = strtoupper($entered['folding']);
            $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Architectural Copies';
            $type = ($entered['plot_arch'] == '1') ? '1' : '0';
            $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($user_session_comp, $user_session, '1') : EnteredPlotRecipientsCount($user_session_comp, $user_session, '0');
            $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeeded($user_session_comp, $user_session) : ArchSetsNeeded($user_session_comp, $user_session);
            ?>
            <tr bgcolor="<?php echo $rowColor; ?>">
                <td><?php echo $order_type; ?></td>
                <td><?php echo $available_order[0]['print_ea']; ?></td>
                <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_<?php echo $i; ?>" class="avl_sets" id="avl_sets_<?php echo $i; ?>"  value="<?php echo ($available_order[0]['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl('<?php echo $i; ?>', '<?php echo $user_session; ?>', '<?php echo $user_session_comp; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_session; ?>', '<?php echo $user_session_comp; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_<?php echo $i; ?>" class="need_sets" id="need_sets_<?php echo $i; ?>" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo $i; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo $i; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $i; ?>" value="<?php echo $entered['size']; ?>" /></td>
                <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $i; ?>" value="<?php echo $entered['output']; ?>" /></td>
                <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $i; ?>" value="<?php echo $entered['media']; ?>" /></td>
                <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $i; ?>" value="<?php echo $binding; ?>" /></td>
                <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $i; ?>" value="<?php echo $folding; ?>" /></td>
            </tr>
        <?php
        $i++;
    }
    ?>
    </table>
    <?php
} elseif ($_POST['recipients'] == 'delete_set') {
    $delete_set_id = $_POST['delete_set_id'];

    $sql_1 = "DELETE FROM sohorepro_plotting_set WHERE id = '" . $delete_set_id . "' ";
    $result = mysql_query($sql_1);
    if ($result) {
        echo '1';
    } else {
        echo '0';
    }
} elseif ($_POST['recipients'] == 'feedback_0') {

    $feedback_input = nl2br(htmlentities($_POST['feedback_input'], ENT_QUOTES, 'UTF-8'));
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $user_mail = $_POST['user_mail'];
    $phone = $_POST['phone'];

    //$user_id            =   UserMail($_POST['user_id_logged']);

    $query = "INSERT INTO sohorepro_feedback
			SET     first_name          = '" . $first_name . "',
                                last_name           = '" . $last_name . "',
                                email               = '" . $user_mail . "',
                                phone               = '" . $phone . "',
                                feedback        = '" . $feedback_input . "' ";
    $sql_result = mysql_query($query);

    $feedback_id = mysql_insert_id();

    $select_feedback = SelectFeedback($feedback_id);

    $message .= '<div style="border:3px solid #FF7E00;">';
    $message .= '<table border="0" style="width:100%;">';

    $message .= '<tr>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">Name</td>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">:</td>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;">' . $select_feedback[0]['first_name'] . '&nbsp;' . $select_feedback[0]['last_name'] . '</td>';
    $message .= '</tr>';

    $message .= '<tr>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">Email</td>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">:</td>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;">' . $select_feedback[0]['email'] . '</td>';
    $message .= '</tr>';

    $message .= '<tr>';
    $message .= '<td valign="top" style="padding-top: 10px;padding-left: 10px;color:#000;padding-bottom: 10px;font-weight:bold;">Question</td>';
    $message .= '<td valign="top" style="padding-top: 10px;padding-left: 10px;color:#000;padding-bottom: 10px;font-weight:bold;">:</td>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;padding-bottom: 10px;">' . $select_feedback[0]['feedback'] . '</td>';
    $message .= '</tr>';

    $message .= '</table>';
    $message .= '</div>';

    $mail_id = getActiveEmailHelp();
    foreach ($mail_id as $to) {
        $result[] = $to['email_id'] . ',';
    }
    $to_address = implode("", $result);
//    foreach ($mail_id as $to) {
    $subject = "Help Request from Website";
    $headers = 'From: ' . $user_mail . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\n";
    $headers .= 'Content-Type: text/html; charset=utf-8\r\n' . "X-Mailer: PHP";
    $headers .= 'Content-Transfer-Encoding: 8bit\r\n\r\n';
    $result = mail($to_address, stripslashes($subject), stripslashes($message), $headers);
//    }

    if ($result) {
        echo '1';
    } else {
        echo '0';
    }
} elseif ($_POST['recipients'] == 'feedback_1') {

    $feedback_input = nl2br(htmlentities($_POST['feedback_input_logged'], ENT_QUOTES, 'UTF-8'));
    $comp_id = $_POST['comp_id_logged'];
    $user_id = UserMail($_POST['user_id_logged']);
    $customer_name = getCompName($comp_id);


    $query = "INSERT INTO sohorepro_feedback
			SET     comp_id         = '" . $comp_id . "',
                                user_name       = '" . $user_id . "',
                                feedback        = '" . $feedback_input . "' ";

    $sql_result = mysql_query($query);
    $feedback_id = mysql_insert_id();
    $select_feedback = SelectFeedback($feedback_id);
    $user_details = GetUserDetails($select_feedback[0]['comp_id'], $select_feedback[0]['user_name']);
    $user_name = $user_details[0]['cus_fname'] . '&nbsp;' . $user_details[0]['cus_lname'];
    $user_email = $user_details[0]['cus_email'];
    $user_company = companyName($select_feedback[0]['comp_id']);

    $message .= '<div style="border:3px solid #FF7E00;">';
    $message .= '<table border="0" style="width:100%;">';

    $message .= '<tr>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">Name</td>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">:</td>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;">' . $user_name . '</td>';
    $message .= '</tr>';

    $message .= '<tr>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">Email</td>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">:</td>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;">' . $user_email . '</td>';
    $message .= '</tr>';

    $message .= '<tr>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">Company</td>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;font-weight:bold;">:</td>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;">' . $user_company . '</td>';
    $message .= '</tr>';

    $message .= '<tr>';
    $message .= '<td valign="top" style="padding-top: 10px;padding-left: 10px;color:#000;padding-bottom: 10px;font-weight:bold;">Question</td>';
    $message .= '<td valign="top" style="padding-top: 10px;padding-left: 10px;color:#000;padding-bottom: 10px;font-weight:bold;">:</td>';
    $message .= '<td style="padding-top: 10px;padding-left: 10px;color:#000;padding-bottom: 10px;">' . $select_feedback[0]['feedback'] . '</td>';
    $message .= '</tr>';

    $message .= '</table>';
    $message .= '</div>';


    $mail_id = getActiveEmailHelp();

    foreach ($mail_id as $to) {
        $subject = "Help Request from " . $customer_name;
        $headers = 'From: ' . $user_email . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\n";
        $headers .= 'Content-Type: text/html; charset=utf-8\r\n' . "X-Mailer: PHP";
        $headers .= 'Content-Transfer-Encoding: 8bit\r\n\r\n';
        $result = mail($to['email_id'], stripslashes($subject), stripslashes($message), $headers);
    }

    if ($result) {
        echo '1';
    } else {
        echo '0';
    }
} elseif ($_POST['recipients'] == '7_1') {
    $edit_rec_id = $_POST['edit_rec_id'];
    $user_session = $_POST['user_session'];
    $user_session_comp = $_POST['user_session_comp'];

    $entered_needed_sets = NeededSets($user_session_comp, $user_session);
    $r = 1;
    foreach ($entered_needed_sets as $entered_sets) {
        $shipp_add = SelectIdAddressService($entered_sets['shipp_id']);
        $plot_binding = ($entered_sets['binding'] == '0') ? '' : ',' . $entered_sets['binding'];
        $plot_foldding = ($entered_sets['folding'] == '0') ? '' : ',' . $entered_sets['folding'];
        $arch_binding = ($entered_sets['arch_binding'] == '0') ? '' : ',' . $entered_sets['arch_binding'];
        $arch_folding = ($entered_sets['arch_folding'] == '0') ? '' : ',' . $entered_sets['arch_folding'];
        if ($entered_sets['id'] == $edit_rec_id) {
            $edit_recipients = EditNeededSets($user_session_comp, $user_session, $edit_rec_id);
            ?>
            <div style="border: 1px #F99B3E solid;margin-top: 5px;padding-bottom: 20px;margin-bottom : 5px;width: 100%;float: left;">
                <div style="width: 100%;float: left;margin-top: 10px;">
                    <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo $r; ?></div>
                    <div style="float: right;width: 20%;font-weight: bold;">            
                        <span title="Update Recipient" alt="Update Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;" onclick="return update_recipient_final('<?php echo $entered_sets['id']; ?>');">Update</span>
                        <span title="Delete Recipient" alt="Delete Recipient" style="font-weight: bold;cursor: pointer;background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;" onclick="return cancel_recipient('<?php echo $user_session; ?>', '<?php echo $user_session_comp; ?>');">Cancel</span>
                        <input type="hidden" name="recipient_edit_id" id="recipient_edit_id" value="<?php echo $edit_rec_id; ?>" />
                    </div>


            <?php
            $user_id_add_set = $_SESSION['sohorepro_userid'];
            $company_id_view_plot = $_SESSION['sohorepro_companyid'];
            ?>
                    <!-- Address Show End -->
                    <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                        <div id="sets_grid_new">
                            <table border="1" style="width: 100%;">
                                <tr bgcolor="#F99B3E">
                                    <td style="font-weight: bold;">Order Type</td>
                                    <td style="font-weight: bold;">Originals</td>
                                    <td style="font-weight: bold;">Available Sets</td>
                                    <td style="font-weight: bold;">Sets Needed</td>
                                    <td style="font-weight: bold;">Size</td>
                                    <td style="font-weight: bold;">Output</td>
                                    <td style="font-weight: bold;">Media</td>
                                    <td style="font-weight: bold;">Binding</td>
                                    <td style="font-weight: bold;">Folding</td>
                                </tr> 
                                <?php
                                $enteredPlot = EnteredPlotRecipients($company_id_view_plot, $user_id_add_set);
                                $i = 1;
                                foreach ($enteredPlot as $entered) {
                                    $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                                    $binding = strtoupper($entered['binding']);
                                    $folding = strtoupper($entered['folding']);
                                    $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Architectural Copies';
                                    $type = ($entered['plot_arch'] == '1') ? '1' : '0';
                                    $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1') : EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                                    $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeeded($company_id_view_plot, $user_id_add_set) : ArchSetsNeeded($company_id_view_plot, $user_id_add_set);
                                    ?>
                                    <tr bgcolor="<?php echo $rowColor; ?>">
                                        <td><?php echo $order_type; ?></td>
                                        <td><?php echo $available_order[0]['print_ea']; ?></td>
                                        <td><input style="width: 25px;float: left;padding: 2px;" type="text" class="avl_sets" name="avl_sets_<?php echo $i; ?>" id="avl_sets_<?php echo $i; ?>"  value="<?php echo ($available_order[0]['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                        <td><input style="width: 25px;float: left;padding: 2px;" type="text" class="need_sets" name="need_sets_<?php echo $i; ?>" id="need_sets_<?php echo $i; ?>" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo $i; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo $i; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                        <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $i; ?>" value="<?php echo $entered['size']; ?>" /></td>
                                        <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $i; ?>" value="<?php echo $entered['output']; ?>" /></td>
                                        <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $i; ?>" value="<?php echo $entered['media']; ?>" /></td>
                                        <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $i; ?>" value="<?php echo $binding; ?>" /></td>
                                        <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $i; ?>" value="<?php echo $folding; ?>" /></td>
                                    </tr>
                            <?php
                            $i++;
                        }
                        ?>
                            </table>
                        </div>

            <?php
            $all_days_off = AllDayOff();
            foreach ($all_days_off as $days_off_split) {
                $all_days_in[] = $days_off_split['date'];
            }
            $all_date = implode(",", $all_days_in);
            $all_date_exist = str_replace("/", "-", $all_date);
            ?>
                    </div>

                    <div style="float: left;width: 33%;margin-left: 30px;border: 1px #F99B3E solid;margin-top: 10px;font-weight: bold;padding:3px;">Send to: 
                        <select  name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return show_address();">
                            <option value="0">Address Book</option>
                            <?php
                            $address_book = AddressBookCompanyService($_SESSION['sohorepro_companyid']);
                            foreach ($address_book as $address) {
                                if ($address['id'] == $edit_recipients[0]['shipp_id']) {
                                    ?>
                                    <option value="<?php echo $address['id']; ?>" selected="selected" ><?php echo $address['company_name']; ?></option>
                <?php } else {
                    ?>
                                    <option value="<?php echo $address['id']; ?>" ><?php echo $address['company_name']; ?></option>
                                <?php
                            }
                        }
                        ?>
                        </select>
                    </div>
                    <!-- Address Show Start -->
                    <div id="show_address" style="float: left;width: 56%;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;padding: 6px;">
            <?php
            $shipp_add = SelectIdAddressService($edit_recipients[0]['shipp_id']);
            $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . ',  ';
            echo $shipp_add[0]['address_1'] . ', ' . $add_2 . $shipp_add[0]['city'] . ', ' . StateName($shipp_add[0]['state']) . ' ' . $shipp_add[0]['zip'];
            ?>
                    </div>
                    <div style="float: left;width: 100%;margin-top: 5px;">   
                        <div style="float: left;width: 40%;">
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
                                        <input type="text" name="shipp_att" id="shipp_att" value="<?php echo $edit_recipients[0]['attention_to']; ?>" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                                        <input type="text" name="contact_ph" id="contact_ph" onfocus="return contact_phone();"  value="<?php echo $edit_recipients[0]['contact_ph']; ?>" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Contact Phone End -->
                    </div>   

                    <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                        <input type="hidden" name="all_exist_date" id="all_exist_date" value="<?php echo $all_date_exist; ?>" />
                        <div style="float:left;margin-right: 5px;margin-top: 10px;width: 100%;">
                            <span style="font-weight: bold;">When Needed:  </span>
                        </div>
                        <div style="width: 34%;float: left;"> 

                            <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;border-bottom: 0px;text-align: center;">
                                <span style="cursor: pointer;display: inline-block;background: #019E59;color: #FFF;padding: 5px 20px;border-radius: 5px;margin-top: 3px;font-weight: bold;" onclick="return asap();">ASAP</span>
                            </div>

                            <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                                <input class="picker_icon" value="<?php echo $entered_sets['shipp_date']; ?>" type="text" name="date_needed" id="date_needed" style="width: 75px;" onclick="date_reveal();" />
                                <input id="time_picker_icon" value="<?php echo $entered_sets['shipp_time']; ?>" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time();" />
                            </div>

                        </div>
                    </div>

                    <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
            <?php
            $checked = ($edit_recipients[0]['delivery_type'] != '0') ? '' : 'checked';
            $display = ($edit_recipients[0]['delivery_type'] != '0') ? '' : 'display: none;';
            $shipp_comp_1 = ($edit_recipients[0]['shipp_comp_1'] != '0') ? 'checked' : '';
            $shipp_comp_2 = ($edit_recipients[0]['shipp_comp_2'] != '0') ? 'checked' : '';
            $shipp_comp_3 = ($edit_recipients[0]['shipp_comp_3'] != '0') ? 'checked' : '';
            $bill_val = ($edit_recipients[0]['billing_number'] != '0') ? $edit_recipients[0]['billing_number'] : '';
            ?>
                        <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 200px;">
                            <input type="checkbox" name="arrange_del" id="arrange_del" <?php echo $checked; ?> style="width: 10% !important;margin-bottom: 0px;" onclick="uncheck_delivery();" /><span style="text-transform: uppercase;">Soho to arrange delivery</span>
                        </div>
                    </div>

                    <div id="delivery_info" style="width: 65%;float: left;margin-left: 45px;margin-top: 10px;<?php echo $display; ?>">
                        <div style="border: 1px #F99B3E solid;width: 50%;margin-left: 20px;padding: 5px;">
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery: </span>
                                    <select  name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address_();">                    
                                        <option value="1" <?php if ($edit_recipients[0]['delivery_type'] == '1') { ?> selected="selected" <?php } ?>>Next Day Air</option> 
                                        <option value="2" <?php if ($edit_recipients[0]['delivery_type'] == '2') { ?> selected="selected" <?php } ?>>Two Day Air</option>
                                        <option value="3" <?php if ($edit_recipients[0]['delivery_type'] == '3') { ?> selected="selected" <?php } ?>>Three Day Air</option>
                                        <option value="4" <?php if ($edit_recipients[0]['delivery_type'] == '4') { ?> selected="selected" <?php } ?>>Ground</option>
                                    </select>
                                </li>                   
                                <li>
                                    <label><span style="font-weight: bold;">Shipping Company: </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" <?php echo $shipp_comp_1; ?> /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" <?php echo $shipp_comp_2; ?> /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" <?php echo $shipp_comp_3; ?> /><input type="text" placeholder="Other" name="other_shipp_type" id="other_shipp_type" value="<?php echo ($edit_recipients[0]['shipp_comp_3'] != '0') ? $edit_recipients[0]['shipp_comp_3'] : ''; ?>" onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number" value="<?php echo $bill_val; ?>" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>
                            </ul>
                        </div>            
                    </div>

                    <div style="font-weight: bold;width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                        Special Instructions:            
                    </div>        
                    <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                        <textarea name="spl_recipient" id="spl_recipient" rows="3" cols="18" style="width: 200px;height: 40px;"><?php echo $edit_recipients[0]['spl_inc']; ?></textarea>
                    </div>

                </div>
            </div>
            <?php
        } else {
            ?>
            <div style="border: 2px #F99B3E solid;padding-bottom: 20px;margin-bottom : 5px;width: 100%;float: left;" class="shaddows">
                <div style="width: 100%;float: left;margin-top: 10px;">
                    <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo $r; ?></div>
                    <div style="float: right;width: 20%;font-weight: bold;">
                        <span title="Edit Recipient" alt="Edit Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;font-weight: bold;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;" onclick="return edit_recipient('<?php echo $entered_sets['id']; ?>');">Edit</span>
                        <span title="Delete Recipient" alt="Delete Recipient" style="font-weight: bold;cursor: pointer;background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;" onclick="return delete_recipient('<?php echo $entered_sets['id']; ?>');">Delete</span>
                    </div>

                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 10px;font-weight: bold;">Send to: </div>
                    <div style="float: left;width: 33%;margin-left: 30px;">  
            <?php
            $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . ',<br>';
            echo $shipp_add[0]['company_name'] . '<br>' . $shipp_add[0]['address_1'] . ',<br>' . $add_2 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'];
            ?>                   
                    </div>
                    <!-- Address Show End -->

                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">

                        <table border="1" style="width: 100%;">
                            <tr bgcolor="#F99B3E">
                                <td style="font-weight: bold;">Sets</td> 
                                <td style="font-weight: bold;">Order Type</td>                            
                                <td style="font-weight: bold;">Size</td>
                                <td style="font-weight: bold;">Output</td>
                                <td style="font-weight: bold;">Binding</td>
                                <td style="font-weight: bold;">Folding</td>
                            </tr>
                            <tr bgcolor="#ffeee1">
                                <td><?php echo $entered_sets['plot_needed']; ?></td>
                                <td>Plotting on Bond</td>                            
                                <td><?php echo $entered_sets['size']; ?></td>
                                <td><?php echo $entered_sets['output']; ?></td>
                                <td>
                                    <span onclick="return edit_binding('<?php echo $entered_sets['id']; ?>');" id="binding_<?php echo $entered_sets['id']; ?>" style="cursor: pointer;"><?php echo $entered_sets['binding']; ?></span>
                                    <select class="binding_select_<?php echo $entered_sets['id']; ?>" id="binding_select_<?php echo $entered_sets['id']; ?>" onchange="return change_binding('<?php echo $entered_sets['id']; ?>');" style="width: 65px;display:none;">
                                        <option value="None" <?php if ($entered_sets['binding'] == 'NONE') { ?> selected="selected" <?php } ?>>None</option>                                      
                                        <option value="Bind All" <?php if ($entered_sets['binding'] == 'BIND ALL') { ?> selected="selected" <?php } ?>>Bind All</option>                          
                                        <option value="Bind by Discipline" <?php if ($entered_sets['binding'] == 'BIND BY DISCIPLINE') { ?> selected="selected" <?php } ?>>Bind by Discipline</option>
                                        <option value="Screw Post" <?php if ($entered_sets['binding'] == 'SCREW POST') { ?> selected="selected" <?php } ?>>Screw Post</option>
                                    </select>
                                </td>
                                <td><?php echo $entered_sets['folding']; ?></td>
                            </tr>
                        </table>

            <!--   1. <?php // echo $entered_sets['plot_needed'] . '&nbsp;Sets Plotting on Bond,' . $entered_sets['size'] . ',' . $entered_sets['output'] . $plot_binding; ?></br>-->
                        <!--   2. <?php // echo  $entered_sets['arch_needed'].'&nbsp;Sets Plotting on Bond,'. $entered_sets['arch_size'].','.$entered_sets['arch_output'].$arch_binding;   ?> -->
                    </div>        
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;">
            <?php
            $date_asap = ($entered_sets['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_sets['shipp_time'] : '';
            ?>
                        <span style="font-weight: bold;">When Needed:  </span><?php echo $entered_sets['shipp_date'] . $date_asap; ?>              
                    </div>        
                        <?php
                        if ($entered_sets['delivery_type'] != '0') {
                            ?>
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            <span style="font-weight: bold;">Send Via: </span>
                        </div>
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            <?php
                            if ($entered_sets['delivery_type'] == '1') {
                                $delivery_type = 'Next Day Air';
                            } elseif ($entered_sets['delivery_type'] == '2') {
                                $delivery_type = 'Two Day Air';
                            } elseif ($entered_sets['delivery_type'] == '3') {
                                $delivery_type = 'Three Day Air';
                            } elseif ($entered_sets['delivery_type'] == '4') {
                                $delivery_type = 'Ground';
                            }

                            $ship_type_1 = ($entered_sets['shipp_comp_1'] == '0') ? '' : $entered_sets['shipp_comp_1'];
                            $ship_type_2 = ($entered_sets['shipp_comp_2'] == '0') ? '' : $entered_sets['shipp_comp_2'];
                            $ship_type_3 = ($entered_sets['shipp_comp_3'] == '0') ? '' : $entered_sets['shipp_comp_3'];

                            echo $ship_type_1 . $ship_type_2 . $ship_type_3 . ',&nbsp;' . $delivery_type . ',&nbsp;Account # ' . $entered_sets['billing_number'];
                            ?>
                        </div>
            <?php } else { ?>                            
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            <span style="font-weight: bold;">Send Via: </span>
                        </div>
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            SOHO TO ARRANGE DELIVERY
                        </div>    
            <?php } ?>       
                </div> 
            </div>
            <?php
        }
        $r++;
    }
    ?>
    <?php
} elseif ($_POST['recipients'] == '9_1') {

    $user_session_comp = $_POST['comp_session_id'];
    $user_session = $_POST['user_session_id'];
    $entered_needed_sets = NeededSets($user_session_comp, $user_session);
    $r = 1;
    foreach ($entered_needed_sets as $entered_sets) {
        $shipp_add = SelectIdAddressService($entered_sets['shipp_id']);
        $plot_binding = ($entered_sets['binding'] == '0') ? '' : ',' . $entered_sets['binding'];
        $plot_folding = ($entered_sets['folding'] == '0') ? '' : ',' . $entered_sets['folding'];
        $arch_binding = ($entered_sets['arch_binding'] == '0') ? '' : ',' . $entered_sets['arch_binding'];
        $arch_folding = ($entered_sets['arch_folding'] == '0') ? '' : ',' . $entered_sets['arch_folding'];
        ?>
        <div style="float: left;" class="shaddows">
            <div class="ribbon" id="ribbon_final"><span>RECIPIENT <?php echo $r; ?></span></div>
            <div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;">                            
                <div style="float: right;">
                    <span title="Edit Recipient" alt="Edit Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;font-weight: bold;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;margin-right: 15px;" onclick="return edit_recipient('<?php echo $entered_sets['id']; ?>');">Edit</span>                               
                </div>
                <div class="details_div">
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 10px;font-weight: bold;">Send to: </div>
                    <div style="float: left;width: 33%;margin-left: 30px;">  
        <?php
        $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . ',<br>';
        echo $shipp_add[0]['company_name'] . '<br>' . $shipp_add[0]['address_1'] . ',<br>' . $add_2 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'];
        ?>                   
                    </div>
                    <!-- Address Show End -->

                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">

                        <table border="1" style="width: 100%;">
                            <tr bgcolor="#F99B3E">
                                <td style="font-weight: bold;">Sets</td> 
                                <td style="font-weight: bold;">Order Type</td>                            
                                <td style="font-weight: bold;">Size</td>
                                <td style="font-weight: bold;">Output</td>
                                <td style="font-weight: bold;">Binding</td>
                                <td style="font-weight: bold;">Folding</td>
                            </tr>
                            <tr bgcolor="#ffeee1">
                                <td><?php echo $entered_sets['plot_needed']; ?></td>
                                <td>Plotting on Bond</td>                            
                                <td><?php echo $entered_sets['size']; ?></td>
                                <td><?php echo $entered_sets['output']; ?></td>
                                <td>
                                    <span onclick="return edit_binding('<?php echo $entered_sets['id']; ?>');" id="binding_<?php echo $entered_sets['id']; ?>" style="cursor: pointer;"><?php echo $entered_sets['binding']; ?></span>
                                    <select class="binding_select_<?php echo $entered_sets['id']; ?>" id="binding_select_<?php echo $entered_sets['id']; ?>" onchange="return change_binding('<?php echo $entered_sets['id']; ?>');" style="width: 65px;display:none;">
                                        <option value="None" <?php if ($entered_sets['binding'] == 'NONE') { ?> selected="selected" <?php } ?>>None</option>                                      
                                        <option value="Bind All" <?php if ($entered_sets['binding'] == 'BIND ALL') { ?> selected="selected" <?php } ?>>Bind All</option>                          
                                        <option value="Bind by Discipline" <?php if ($entered_sets['binding'] == 'BIND BY DISCIPLINE') { ?> selected="selected" <?php } ?>>Bind by Discipline</option>
                                        <option value="Screw Post" <?php if ($entered_sets['binding'] == 'SCREW POST') { ?> selected="selected" <?php } ?>>Screw Post</option>
                                    </select>
                                </td>
                                <td><?php echo $entered_sets['folding']; ?></td>
                            </tr>
                        </table>

        <!--1. <?php // echo $entered_sets['plot_needed'] . '&nbsp;Sets Plotting on Bond,' . $entered_sets['size'] . ',' . $entered_sets['output'] . $plot_binding . $plot_folding; ?></br>-->
                        <!-- 2. <?php // echo  $entered_sets['arch_needed'].'&nbsp;Sets Plotting on Bond,'. $entered_sets['arch_size'].','.$entered_sets['arch_output'].$arch_binding.$arch_folding;  ?> -->
                    </div>        
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;">
        <?php
        $date_asap = ($entered_sets['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_sets['shipp_time'] : '';
        ?>
                        <span style="font-weight: bold;">When Needed:  </span><?php echo $entered_sets['shipp_date'] . $date_asap; ?>          
                    </div>
                        <?php
                        if ($entered_sets['delivery_type'] != '0') {
                            ?>
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            <span style="font-weight: bold;">Send Via: </span>
                        </div>
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            <?php
                            if ($entered_sets['delivery_type'] == '1') {
                                $delivery_type = 'Next Day Air';
                            } elseif ($entered_sets['delivery_type'] == '2') {
                                $delivery_type = 'Two Day Air';
                            } elseif ($entered_sets['delivery_type'] == '3') {
                                $delivery_type = 'Three Day Air';
                            } elseif ($entered_sets['delivery_type'] == '4') {
                                $delivery_type = 'Ground';
                            }

                            $ship_type_1 = ($entered_sets['shipp_comp_1'] == '0') ? '' : $entered_sets['shipp_comp_1'];
                            $ship_type_2 = ($entered_sets['shipp_comp_2'] == '0') ? '' : $entered_sets['shipp_comp_2'];
                            $ship_type_3 = ($entered_sets['shipp_comp_3'] == '0') ? '' : $entered_sets['shipp_comp_3'];

                            echo $ship_type_1 . $ship_type_2 . $ship_type_3 . ',&nbsp;' . $delivery_type . ',&nbsp;Account #' . $entered_sets['billing_number'];
                            ?>
                        </div>
        <?php } else { ?>                            
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            <span style="font-weight: bold;">Send Via: </span>
                        </div>
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            SOHO TO ARRANGE DELIVERY
                        </div>    
        <?php } ?>
                </div>
            </div>
        </div>

        <?php
        $r++;
    }
} elseif ($_POST['recipients'] == '6_1') {

    $edit_recipient_id = $_POST['edit_recipient_id'];

    $shipping_id_rec = $_POST['shipping_id_rec'];
    $user_session = $_POST['user_session'];
    $user_session_comp = $_POST['user_session_comp'];
    $date_needed = $_POST['date_needed'];
    $time_needed = $_POST['time_needed'];
    $spl_recipient = $_POST['spl_recipient'];

    $avl_sets_1 = $_POST['avl_sets_1'];
    $need_sets_1 = $_POST['need_sets_1'];
    $size_sets_1 = $_POST['size_sets_1'];
    $output_sets_1 = $_POST['output_sets_1'];
    $binding_sets_1 = $_POST['binding_sets_1'];
    $folding_sets_1 = $_POST['folding_sets_1'];

    $avl_sets_2 = $_POST['avl_sets_2'];
    $need_sets_2 = $_POST['need_sets_2'];
    $size_sets_2 = $_POST['size_sets_2'];
    $output_sets_2 = $_POST['output_sets_2'];
    $binding_sets_2 = $_POST['binding_sets_2'];
    $folding_sets_2 = $_POST['folding_sets_2'];

    $delivery_type = $_POST['delivery_type'];
    $bill_number = $_POST['bill_number'];
    $shipp_comp_1_f = $_POST['shipp_comp_1_f'];
    $shipp_comp_2_f = $_POST['shipp_comp_2_f'];
    $shipp_comp_3_f = $_POST['shipp_comp_3_f'];


    $query = "UPDATE sohorepro_sets_needed
			SET     comp_id         = '" . $user_session_comp . "',
                                usr_id          = '" . $user_session . "',
                                plot_needed     = '" . $need_sets_1 . "',
                                size            = '" . $size_sets_1 . "',
                                output          = '" . $output_sets_1 . "',
                                binding         = '" . $binding_sets_1 . "',
                                folding         = '" . $folding_sets_1 . "',
                                arch_needed     = '" . $need_sets_2 . "',
                                arch_size       = '" . $size_sets_2 . "',
                                arch_output     = '" . $output_sets_2 . "',
                                arch_binding    = '" . $binding_sets_2 . "',
                                arch_folding    = '" . $folding_sets_2 . "',    
                                shipp_id        = '" . $shipping_id_rec . "',
                                shipp_date      = '" . $date_needed . "',
                                shipp_time      = '" . $time_needed . "',  
                                spl_inc         = '" . $spl_recipient . "',
                                delivery_type   = '" . $delivery_type . "',
                                billing_number  = '" . $bill_number . "',
                                shipp_comp_1    = '" . $shipp_comp_1_f . "',
                                shipp_comp_2    = '" . $shipp_comp_2_f . "',
                                shipp_comp_3    = '" . $shipp_comp_3_f . "'  WHERE id = '" . $edit_recipient_id . "' ";

    $sql_result = mysql_query($query);

    $entered_needed_sets = NeededSets($user_session_comp, $user_session);
    $r = 1;
    foreach ($entered_needed_sets as $entered_sets) {
        $shipp_add = SelectIdAddressService($entered_sets['shipp_id']);
        $plot_binding = ($entered_sets['binding'] == '0') ? '' : ',' . $entered_sets['binding'];
        $plot_folding = ($entered_sets['folding'] == '0') ? '' : ',' . $entered_sets['folding'];
        $arch_binding = ($entered_sets['arch_binding'] == '0') ? '' : ',' . $entered_sets['arch_binding'];
        $arch_folding = ($entered_sets['arch_folding'] == '0') ? '' : ',' . $entered_sets['arch_folding'];
        ?>
        <div style="float: left;" class="shaddows">
            <div class="ribbon" id="ribbon_final"><span>RECIPIENT <?php echo $r; ?></span></div>
            <div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;">                            
                <div style="float: right;">
                    <span title="Edit Recipient" alt="Edit Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;font-weight: bold;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;margin-right: 15px;" onclick="return edit_recipient('<?php echo $entered_sets['id']; ?>');">Edit</span>                               
                </div>
                <div class="details_div">
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 10px;font-weight: bold;">Send to: </div>
                    <div style="float: left;width: 33%;margin-left: 30px;">  
        <?php
        $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . ',<br>';
        echo $shipp_add[0]['company_name'] . '<br>' . $shipp_add[0]['address_1'] . ',<br>' . $add_2 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'];
        ?>                   
                    </div>
                    <!-- Address Show End -->

                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">

                        <table border="1" style="width: 100%;">
                            <tr bgcolor="#F99B3E">
                                <td style="font-weight: bold;">Sets</td> 
                                <td style="font-weight: bold;">Order Type</td>                            
                                <td style="font-weight: bold;">Size</td>
                                <td style="font-weight: bold;">Output</td>
                                <td style="font-weight: bold;">Binding</td>
                                <td style="font-weight: bold;">Folding</td>
                            </tr>
                            <tr bgcolor="#ffeee1">
                                <td><?php echo $entered_sets['plot_needed']; ?></td>
                                <td>Plotting on Bond</td>                            
                                <td><?php echo $entered_sets['size']; ?></td>
                                <td><?php echo $entered_sets['output']; ?></td>
                                <td>
                                    <span onclick="return edit_binding('<?php echo $entered_sets['id']; ?>');" id="binding_<?php echo $entered_sets['id']; ?>" style="cursor: pointer;"><?php echo $entered_sets['binding']; ?></span>
                                    <select class="binding_select_<?php echo $entered_sets['id']; ?>" id="binding_select_<?php echo $entered_sets['id']; ?>" onchange="return change_binding('<?php echo $entered_sets['id']; ?>');" style="width: 65px;display:none;">
                                        <option value="None" <?php if ($entered_sets['binding'] == 'NONE') { ?> selected="selected" <?php } ?>>None</option>                                      
                                        <option value="Bind All" <?php if ($entered_sets['binding'] == 'BIND ALL') { ?> selected="selected" <?php } ?>>Bind All</option>                          
                                        <option value="Bind by Discipline" <?php if ($entered_sets['binding'] == 'BIND BY DISCIPLINE') { ?> selected="selected" <?php } ?>>Bind by Discipline</option>
                                        <option value="Screw Post" <?php if ($entered_sets['binding'] == 'SCREW POST') { ?> selected="selected" <?php } ?>>Screw Post</option>
                                    </select>
                                </td>
                                <td><?php echo $entered_sets['folding']; ?></td>
                            </tr>
                        </table>

        <!-- 1. <?php //echo $entered_sets['plot_needed'] . '&nbsp;Sets Plotting on Bond,' . $entered_sets['size'] . ',' . $entered_sets['output'] . $plot_binding . $plot_folding; ?></br>-->
                        <!-- 2. <?php // echo  $entered_sets['arch_needed'].'&nbsp;Sets Plotting on Bond,'. $entered_sets['arch_size'].','.$entered_sets['arch_output'].$arch_binding.$arch_folding;  ?> -->
                    </div>        
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;">
        <?php
        $date_asap = ($entered_sets['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_sets['shipp_time'] : '';
        ?>
                        <span style="font-weight: bold;">When Needed:  </span><?php echo $entered_sets['shipp_date'] . $date_asap; ?>          
                    </div>
                        <?php
                        if ($entered_sets['delivery_type'] != '0') {
                            ?>
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            <span style="font-weight: bold;">Send Via: </span>
                        </div>
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            <?php
                            if ($entered_sets['delivery_type'] == '1') {
                                $delivery_type = 'Next Day Air';
                            } elseif ($entered_sets['delivery_type'] == '2') {
                                $delivery_type = 'Two Day Air';
                            } elseif ($entered_sets['delivery_type'] == '3') {
                                $delivery_type = 'Three Day Air';
                            } elseif ($entered_sets['delivery_type'] == '4') {
                                $delivery_type = 'Ground';
                            }

                            $ship_type_1 = ($entered_sets['shipp_comp_1'] == '0') ? '' : $entered_sets['shipp_comp_1'];
                            $ship_type_2 = ($entered_sets['shipp_comp_2'] == '0') ? '' : $entered_sets['shipp_comp_2'];
                            $ship_type_3 = ($entered_sets['shipp_comp_3'] == '0') ? '' : $entered_sets['shipp_comp_3'];

                            echo $ship_type_1 . $ship_type_2 . $ship_type_3 . ',&nbsp;' . $delivery_type . ',&nbsp;Account #' . $entered_sets['billing_number'];
                            ?>
                        </div>
        <?php } else { ?>                            
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            <span style="font-weight: bold;">Send Via: </span>
                        </div>
                        <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                            SOHO TO ARRANGE DELIVERY
                        </div>    
        <?php } ?>
                </div>
            </div>
        </div>
        <?php
        $r++;
    }
} elseif ($_POST['recipients'] == '0_0') {

    $reference = strtoupper($_SESSION['ref_val']);

    $sql_order_sequence = mysql_query("SELECT id,order_sequence FROM sohorepro_order_master ORDER BY id DESC LIMIT 1");
    $object_order_sequence = mysql_fetch_assoc($sql_order_sequence);
    $sequence_id = $object_order_sequence['id'];
    $sequence = $object_order_sequence['order_sequence'];

    $new_sequence = ($sequence + 1);

    $query_update = "UPDATE sohorepro_order_master
			SET     order_sequence         = '" . $new_sequence . "' WHERE id = '" . $sequence_id . "'";
    mysql_query($query_update);

    //Funcionality for Auto Load Reference Start.
    $chk_reference = CheckReference($_SESSION['sohorepro_companyid'], $reference);
    if (count($chk_reference) == 0) {
        $ref_sql = "INSERT INTO sohorepro_reference SET company_id = '" . $_SESSION['sohorepro_companyid'] . "', user_id = '" . $_SESSION['sohorepro_userid'] . "', reference = '" . $reference . "' ";
        mysql_query($ref_sql);
    }
    //Funcionality for Auto Load Reference End.

    $customer_name = getCompName($_SESSION['sohorepro_companyid']);

    $query = "INSERT INTO sohorepro_order_master_service
			SET     order_sequence          = '" . $new_sequence . "',
                                comp_id                 = '" . $_SESSION['sohorepro_companyid'] . "',
                                user_id                 = '" . $_SESSION['sohorepro_userid'] . "',
                                customer_company_name   = '" . $customer_name . "',
                                reference               = '" . $reference . "',
                                created_date            = now()";
    $sql_result = mysql_query($query);

    $order_id_service = mysql_insert_id();

    $_SESSION['ordere_sequence'] = $order_id_service;

    $select_fav = "UPDATE sohorepro_sets_needed SET order_id = '" . $order_id_service . "', ordered = '1' WHERE comp_id = '" . $_SESSION['sohorepro_companyid'] . "' AND usr_id = '" . $_SESSION['sohorepro_userid'] . "' AND ordered = '0' ";
    mysql_query($select_fav);

    $upload_sql = "UPDATE sohorepro_upload_files_set SET order_id = '" . $order_id_service . "' WHERE comp_id = '" . $_SESSION['sohorepro_companyid'] . "' AND user_id = '" . $_SESSION['sohorepro_userid'] . "' AND order_id = '0' ";
    mysql_query($upload_sql);


    $sql_plot = "UPDATE sohorepro_plotting_set SET order_id = '" . $order_id_service . "' WHERE company_id = '" . $_SESSION['sohorepro_companyid'] . "' AND user_id = '" . $_SESSION['sohorepro_userid'] . "' AND order_id = '0' ";
    mysql_query($sql_plot);

    $job_reference_final = ShowOrderedSets($_SESSION['ordere_sequence']);


    $mail_id = getActiveEmailOrder();
    $entered_needed_sets_final = SetsOrderedFinalize($job_reference_final[0]['id']);
    $total_sets = SetsOrderedFinalizeCountOfSets($job_reference_final[0]['id']);
    $user_name = UserName($_SESSION['sohorepro_userid']);
    $customer_name = getCompName($_SESSION['sohorepro_companyid']);
    $user_mail_id_txt = UserMail($_SESSION['sohorepro_userid']);

    $phone = CompanyPhoneNumber($user_mail_id_txt);
    $Date = date('m-d-Y h:i A', time());
    $files_upload_services = UploafFilesServices($job_reference_final[0]['id']);

    $service_billing_address = getCustomeInfo($_SESSION['sohorepro_companyid']);
    $service_address_1 = ($service_billing_address[0]['comp_business_address1'] != '') ? $service_billing_address[0]['comp_business_address1'] . '<br>' : '';
    $service_address_2 = ($service_billing_address[0]['comp_business_address2'] != '') ? $service_billing_address[0]['comp_business_address2'] . '<br>' : '';
    $service_address_3 = ($service_billing_address[0]['comp_business_address3'] != '') ? $service_billing_address[0]['comp_business_address3'] . '<br>' : '';


//    $message .= '<style>';
//    $message .= '.shaddows{background: white;border-radius: 10px;-webkit-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);-moz-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);box-shadow: 0px 0px 8px rgba(0,0,0,0.3);position: relative;z-index: 90;}';
//    $message .= '</style>';
    $message = '<!DOCTYPE html>
    <html>
    <head>
    <style>
        .shaddows{
            background: white;
            border-radius: 10px;
            -webkit-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
            -moz-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
            box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
            position: relative;
            z-index: 90;
            margin-bottom: 10px;
        }
        #ribbon_final{
            position: absolute !important;
            left: -5px !important; 
            top: -5px !important;
            z-index: 1 !important;
            overflow: hidden !important;
            width: 75px !important;
            height: 75px !important;
            text-align: right !important;  
        }

        .ribbon {
            position: absolute !important;
            left: -5px !important; 
            top: -5px !important;
            z-index: 1 !important;
            overflow: hidden !important;
            width: 75px !important;
            height: 75px !important;
            text-align: right !important;
        }
        .ribbon span {
            font-size: 10px;
            font-weight: bold;
            color: #FFF;
            text-transform: uppercase;
            text-align: center;
            line-height: 20px;
            transform: rotate(-45deg);
            width: 100px;
            display: block;
            background: #79A70A;
            background: linear-gradient(#BFC5CD 0%, #83878C 100%);
            box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
            position: absolute;
            top: 19px; left: -21px;
        }
        .ribbon span::before {
            content: "";
            position: absolute; left: 0px; top: 100%;
            z-index: -1;
            border-left: 3px solid #83878C;
            border-right: 3px solid transparent;
            border-bottom: 3px solid transparent;
            border-top: 3px solid #83878C;
        }
        .ribbon span::after {
            content: "";
            position: absolute; right: 0px; top: 100%;
            z-index: -1;
            border-left: 3px solid transparent;
            border-right: 3px solid #83878C;
            border-bottom: 3px solid transparent;
            border-top: 3px solid #83878C;
        }
    </style>';
    $message .= '</head>';
    $message .= '<body>';
    $message .= '<div style="border:5px solid #FF7E00;">';
    $message .= '<table>';
    $message .= '<tr>';
    $message .= '<td colspan="3" align="left" valign="top" style="padding-top: 30px;padding-left: 10px;">';
    $message .= '<div style="width: 100%;float: left;font-size: 21px;margin-bottom:5px;">Order Completed : ORDER # ' . $job_reference_final[0]['order_sequence'] . '</div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Customer Reference  :</span> ' . $reference . '</div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Date  :</span> ' . $Date . '</div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Name :</span> ' . $user_name . '</div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Company :</span> ' . $customer_name . '</div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Email :</span> ' . $user_mail_id_txt . '</div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Phone :</span>' . $phone . '</div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:5px"><span style="font-weight:bold;">Billing Address :</span></div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:5px">' . $service_billing_address[0]['comp_name'] . '<br>' . $service_address_1 . $service_address_2 . $service_address_3 . $service_billing_address[0]['comp_city'] . ',&nbsp;' . $service_billing_address[0]['comp_state'] . '&nbsp;' . $service_billing_address[0]['comp_zipcode'] . '</div>';
    $message .= '</td></tr>';

    $message .= '<td colspan="3" style="padding-top: 20px;padding-left: 10px;padding-bottom: 10px;">';

    //Original Order Start
    $message .= '<div style="float: left;margin-top: 12px;margin-bottom: 20px;">';
    $message .= '<div style="font-weight: bold;padding-top: 3px;">ORIGINAL ORDER</div>';
    $message .= '<div style="border: 2px #F99B3E solid;width: 95%;float: left;margin-top: 10px;margin-bottom: 10px;" class="shaddows">';
    $message .= '<div class="details_div">';
    $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">Customer Details :</div>';
    $message .= '<div style="float: left;width: 33%;margin-left: 30px;">';
    $cust_add = getCustomeInfo($_SESSION['sohorepro_companyid']);
    $cust_add_2 = ($cust_add[0]['comp_business_address2'] != '') ? $cust_add[0]['comp_business_address2'] . ',<br>' : '';
    $message .= $cust_add[0]['comp_name'] . '<br>' . $cust_add[0]['comp_business_address1'] . ',<br>' . $cust_add_2 . $cust_add[0]['comp_city'] . ',&nbsp;' . $cust_add[0]['comp_state'] . '&nbsp;' . $cust_add[0]['comp_zipcode'];
    $message .= '</div>';
    $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">User Details :</div>';
    $message .= '<div style="float: left;width: 33%;margin-left: 30px;">';
    $cust_user_add = UserLoginDtls($_SESSION['sohorepro_userid']);
    $cust_user_name = $cust_user_add[0]['cus_fname'] . '&nbsp;' . $cust_user_add[0]['cus_lname'];
    $cust_mail_id = $cust_user_add[0]['cus_email'];
    $cust_phone_num = $cust_user_add[0]['cus_contact_phone'];
    $message .= $cust_user_name . '<br>' . $cust_mail_id . '<br>' . $cust_phone_num . '<br>Date :' . date('m-d-Y h:i A', time());
    $message .= '</div>';
    $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>';
    $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">';
    $cust_original_order = SetsOrderedFinalize($job_reference_final[0]['id']);
    $total_plot_needed = SetsOrderedFinalizeCountOfSets($job_reference_final[0]['id']);
    $cust_original_order_final = SetsOrderedFinalizeOriginal($job_reference_final[0]['id']);
    $upload_file_exist = UploadFileExistFinalize($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid'], $job_reference_final[0]['id']);
    $cust_needed_sets = ($cust_original_order[0]['print_ea'] != '0') ? $cust_original_order[0]['print_ea'] : $cust_original_order[0]['arch_needed'];
    $cust_order_type = ($cust_original_order[0]['arch_needed'] != '0') ? 'Architectural Copies' : 'Plotting on Bond';
    $message .= '<table border="0" style="width: 100%;">';
    $message .= '<tr bgcolor="#F99B3E">';
    $message .= '<td style="font-weight: bold;">Sets</td>';
    $message .= '<td style="font-weight: bold;">Order Type</td>';
    $message .= '<td style="font-weight: bold;">Size</td>';
    $message .= '<td style="font-weight: bold;">Output</td>';
    $message .= '<td style="font-weight: bold;">Media</td>';
    $message .= '<td style="font-weight: bold;">Binding</td>';
    $message .= '<td style="font-weight: bold;">Folding</td>';
    $message .= '</tr>';
    $message .= '<tr bgcolor="#ffeee1">';
    $message .= '<td>' . $total_plot_needed[0]['total_sets'] . '</td>';
    $message .= '<td>' . $cust_order_type . '</td>';
    $message .= '<td>' . $cust_original_order[0]['size'] . '</td>';
    $message .= '<td>' . $cust_original_order[0]['output'] . '</td>';
    $message .= '<td>' . $cust_original_order_final[0]['media'] . '</td>';
    $message .= '<td>' . $cust_original_order[0]['binding'] . '</td>';
    $message .= '<td>' . $cust_original_order[0]['folding'] . '</td>';
    $message .= '</tr>';
    $message .= '</table>';
    $message .= '</div>';
    if ($cust_original_order[0]['size'] == 'Custom') {
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">';
        $message .= '<div style="font-weight: bold;width: 100%;float: left;">Custom Size Details :</div>';
        $message .= '<div style="padding-top: 3px;">' . $cust_original_order[0]['custome_details'] . '</div>';
        $message .= '</div>';
    }
    if ($cust_original_order[0]['output'] == 'Both') {
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">';
        $message .= '<div style="font-weight: bold;width: 100%;float: left;">Page Number :</div>';
        $message .= '<div style="padding-top: 3px;">' . $cust_original_order[0]['output_page_number'] . '</div>';
        $message .= '</div>';
    }
    if (($cust_original_order_final[0]['pick_up'] != '0') || ($cust_original_order_final[0]['drop_off'] != '0') || ($cust_original_order_final[0]['ftp_link'] != '0')) {
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">File Options :</div>';
    }
    if ($cust_original_order_final[0]['pick_up'] != '0') {
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">Pick up : ' . $cust_original_order_final[0]['pick_up'] . '</div>';
    }
    if ($cust_original_order_final[0]['drop_off'] != '0') {
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">Drop off at Soho Repro : ' . $cust_original_order_final[0]['drop_off'] . '</div>';
    }
    if ($cust_original_order_final[0]['ftp_link'] != '0') {
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;font-weight:bold;">Provide Link to File</div>';
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">FTP Link : ' . $cust_original_order_final[0]['ftp_link'] . '</div>';
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">User Name : ' . $cust_original_order_final[0]['user_name'] . '</div>';
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">Password : ' . $cust_original_order_final[0]['password'] . '</div>';
    }
    if (count($upload_file_exist) > 0) {
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">File Options :</div>';
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;text-decoration: underline;">Upload File :</div>';
        $f = 1;
        foreach ($upload_file_exist as $files) {
            $message .= '<div style="width: 100%;float: left;margin-top: 10px;margin-left: 30px;">' . $f . '.&nbsp;&nbsp;&nbsp;<a href="http://cipldev.com/supply-new.sohorepro.com/uploads/' . $files['file_name'] . '" target="_blank">' . $files['file_name'] . '</a></div>';
            $f++;
        }
    }
    if ($cust_original_order_final[0]['spl_instruction'] != '') {
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">Special Instructions: </div>';
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">' . $cust_original_order_final[0]['spl_instruction'] . '</div>';
    }
    $message .= '</div>';
    $message .= '</div>';
    $message .= '</div>';
    //Original Order End


    $r = 1;
    foreach ($entered_needed_sets_final as $entered_sets) {
        if (($entered_sets['shipp_id'] == 'P1') && ($entered_sets['shipp_id'] == 'P2')) {
            $shipp_add = AddressBookPickupSohoCap($entered_sets['shipp_id']);
        } else {
            $shipp_add = SelectIdAddressService($entered_sets['shipp_id']);
        }
        $needed_sets = ($entered_sets['plot_needed'] != '0') ? $entered_sets['plot_needed'] : $entered_sets['arch_needed'];
        $order_type = ($entered_sets['arch_needed'] != '0') ? 'Architectural Copies' : 'Plotting on Bond';
        $plot_binding = ($entered_sets['binding'] == '0') ? '' : ',' . $entered_sets['binding'];
        $plot_folding = ($entered_sets['folding'] == '0') ? '' : ',' . $entered_sets['folding'];
        $arch_binding = ($entered_sets['arch_binding'] == '0') ? '' : ',' . $entered_sets['arch_binding'];
        $arch_folding = ($entered_sets['arch_folding'] == '0') ? '' : ',' . $entered_sets['arch_folding'];
        $message .= '<div style="font-weight: bold;padding-top: 3px;">RECIPIENT ' . $r . '</div>';
        $message .= '<div style="border: 2px #F99B3E solid;width: 95%;float: left;margin-bottom: 10px;">';
        $message .= '<div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;">';
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 10px;font-weight: bold;">Send to: </div>';
        $message .= '<div style="float: left;width: 33%;margin-left: 30px;">';

        if (($entered_sets['shipp_id'] != 'P1') && ($entered_sets['shipp_id'] != 'P2')) {
            $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . ',<br>';
            $message .= $shipp_add[0]['company_name'] . '<br>' . 'Attention: ' . $entered_sets['attention_to'] . '<br>' . 'Conatct:  ' . $entered_sets['contact_ph'] . '<br>' . $shipp_add[0]['address_1'] . ',<br>' . $add_2 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'];
        } else {                    //echo $shipp_add[0]['address'];                        
            $shipp_add_p = AddressBookPickupSohoCap($entered_sets['shipp_id']);
            $message .= $shipp_add_p[0]['address'];
        }

//        $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . ',<br>';
//        $message .= $shipp_add[0]['company_name'] . '<br>' . $shipp_add[0]['address_1'] . ',<br>' . $add_2 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'];
        $message .= '</div>';
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>';
        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">';

        $message .= '<table border="0" style="width: 100%;">';
        $message .= '<tr bgcolor="#F99B3E">';
        $message .= '<td style="font-weight: bold;">Sets</td>';
        $message .= '<td style="font-weight: bold;">Order Type</td>';
        $message .= '<td style="font-weight: bold;">Size</td>';
        $message .= '<td style="font-weight: bold;">Output</td>';
        $message .= '<td style="font-weight: bold;">Binding</td>';
        $message .= '<td style="font-weight: bold;">Folding</td>';
        $message .= '</tr>';
        $message .= '<tr bgcolor="#ffeee1">';
        $message .= '<td>' . $needed_sets . '</td>';
        $message .= '<td>' . $order_type . '</td>';
        $message .= '<td>' . $entered_sets['size'] . '</td>';
        $message .= '<td>' . $entered_sets['output'] . '</td>';
        $message .= '<td>' . $entered_sets['binding'] . '</td>';
        $message .= '<td>' . $entered_sets['folding'] . '</td>';
        $message .= '</tr>';
        $message .= '</table>';
        $message .= '</div>';

        if ($entered_sets['size'] == 'Custom') {
            $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">';
            $message .= '<div style="font-weight: bold;width: 100%;float: left;">Custom Size Details :</div>';
            $message .= '<div style="padding-top: 3px;">' . $entered_sets['custome_details'] . '</div>';
            $message .= '</div>';
        }

        if ($entered_sets['output'] == 'Both') {
            $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">';
            $message .= '<div style="font-weight: bold;width: 100%;float: left;">Page Number :</div>';
            $message .= '<div style="padding-top: 3px;">' . $entered_sets['output_page_number'] . '</div>';
            $message .= '</div>';
        }

        $message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;">';
        $date_asap = ($entered_sets['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_sets['shipp_time'] : '';
        $message .= '<span style="font-weight: bold;">When Needed:  </span>' . $entered_sets['shipp_date'] . $date_asap;
        $message .= '</div>';
        if ($entered_sets['delivery_type'] != '0') {
            $message .= '<div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">';
            $message .= '<span style="font-weight: bold;">Send Via: </span>';
            $message .= '</div>';
            $message .= '<div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">';
            if ($entered_sets['delivery_type'] == '1') {
                $delivery_type = 'Next Day Air';
            } elseif ($entered_sets['delivery_type'] == '2') {
                $delivery_type = 'Two Day Air';
            } elseif ($entered_sets['delivery_type'] == '3') {
                $delivery_type = 'Three Day Air';
            } elseif ($entered_sets['delivery_type'] == '4') {
                $delivery_type = 'Ground';
            }
            $ship_type_1 = ($entered_sets['shipp_comp_1'] == '0') ? '' : $entered_sets['shipp_comp_1'];
            $ship_type_2 = ($entered_sets['shipp_comp_2'] == '0') ? '' : $entered_sets['shipp_comp_2'];
            $ship_type_3 = ($entered_sets['shipp_comp_3'] == '0') ? '' : $entered_sets['shipp_comp_3'];
            $message .= $ship_type_1 . $ship_type_2 . $ship_type_3 . ',&nbsp;' . $delivery_type . ',&nbsp;Account # ' . $entered_sets['billing_number'];
            $message .= '</div>';
        } else {
            $message .= '<div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">';
            $message .= '<span style="font-weight: bold;">Send Via: </span>';
            $message .= '</div>';
            $message .= '<div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">';
            $message .= 'SOHO TO ARRANGE DELIVERY</div>';
        }
        $message .= '</div></div>';
        $r++;
    }
    $message .='</td>';
    $message .= '</tr>';
    $message .= '<tr>';
    $message .= '<td style="padding-left: 10px;">';
    $message .= '</td>';
    $message .= '</tr>';
    $message .= '</table>';
    $message .= '</div>';
    $message .= '</body>';
    $message .= '</html>';


    $my_file_open = 'service_invoice.html';
    $handle_new = fopen($my_file_open, 'w') or die('Cannot open file:  ' . $my_file);
    fwrite($handle_new, $message);


    $user_mail = array('email_id' => UserMail($final_usr_id));
//$customer_email = CompanyMail($company_id);
    $customer_email = array('email_id' => CompanyMail($final_comp_id));
    array_push($mail_id, $user_mail, $customer_email);


    foreach ($mail_id as $mails_sent) {
        $pre_filt[] = $mails_sent['email_id'];
    }

    $final_list = array_unique($pre_filt);

    $mail_content = file_get_contents('service_invoice.html');

    foreach ($final_list as $to) {
        $subject = "SERVICE REQUEST for " . $customer_name;
        $headers = 'From: "SohoRepro" <noreply@sohorepro.com>' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\n";
        $headers .= 'Content-Type: text/html; charset=utf-8\r\n' . "X-Mailer: PHP";
        $headers .= 'Content-Transfer-Encoding: 8bit\r\n\r\n';
        $result = mail($to, stripslashes($subject), stripslashes($mail_content), $headers);
    }

    if ($result == TRUE) {
        echo '1';
    } else {
        echo '0';
    }
} elseif ($_POST['recipients'] == '0_1') {

    $comp_id_0_1 = $_POST['comp_id_0_1'];
    $usr_id_0_1 = $_POST['usr_id_0_1'];
    unset($_SESSION['order_number']);
    unset($_SESSION['shipp_selected_id']);
    unset($_SESSION['final_ord_id']);
    unset($_SESSION['ref_val']);
    echo '1';
}
?>