<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);

if ($_POST['pickup_from_soho'] == '1') {
    $pickup_from_soho_add = $_POST['pickup_from_soho_add'];
    $if_plotting = EnteredPlotRecipientsCount($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid'], '1');
    $if_arch = EnteredPlotRecipientsCount($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid'], '0');
    if ((count($if_plotting) > 0) && (count($if_arch) > 0)) {
    ?>
    <div style="width: 100%;float: left;height: 20px;margin-bottom: 5px;">
        <div style="width: 5%;float: left;border-bottom: 1px #F99B3E solid;border-left: 0px;border-top: 0px;border-right: 0px;">&nbsp;</div>
        <div style="width: 20%;float: left;text-align: center;border: 1px #F99B3E solid;font-weight: bold;cursor: pointer;" onclick="return everything_return();">Plotting</div>
        <div style="width: 5%;float: left;border-bottom: 1px #F99B3E solid;border-left: 0px;border-top: 0px;">&nbsp;</div>
        <div style="width: 20%;float: left;text-align: center;border: 1px #F99B3E solid;border-bottom: 0px;font-weight: bold;cursor: pointer;" onclick="return everything_return_arch();">Architectural</div>
        <div style="width: 48%;float: left;border: 1px #F99B3E solid;border-left: 0px;border-top: 0px;border-right: 0px;">&nbsp;</div>
    </div>

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
                                $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Copies';
                                $type = ($entered['plot_arch'] == '1') ? '1' : '0';
                                $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1') : EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                                $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeeded($company_id_view_plot, $user_id_add_set) : ArchSetsNeeded($company_id_view_plot, $user_id_add_set);
                                $plot_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1');
                                $copy_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                                ?>                               
                                <?php
                                if ($entered['plot_arch'] == '0') {
                                    ?>
                                    <tr bgcolor="#ffeee1">
                                        <td>Architectural Copies</td>
                                        <td><?php echo $available_order[0]['origininals']; ?></td>
                                        <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_2" class="avl_sets"  value="<?php echo ($available_order[0]['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                        <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_2" class="need_sets" value="<?php echo $available_order[0]['print_ea']; ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo '2'; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo '2'; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
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
                            <?php
                            }
                        }
                        ?>
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
                <select  name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return pickup_soho_p();">                    
                    <?php
                    $address_book_show = AddressBookPickupSoho($pickup_from_soho_add);
                    $address_book = AddressBookPickupSohoAll();
                    foreach ($address_book as $address) {
                        ?>                                                                                        
                    <option value="<?php echo $address['id']; ?>" <?php if($address['id'] == $pickup_from_soho_add){?> selected="selected" <?php } ?> ><?php echo $address['caption']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <!-- Address Show Start -->
            <div id="show_address" style="float: left;width: 56%;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">
                <?php
                echo $address_book_show[0]['address_format'];
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
                                        <span><input type="radio" name="shipp_comp" id="shipp_comp_1" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                        <span><input type="radio" name="shipp_comp" id="shipp_comp_2" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                        <span><input type="radio" name="shipp_comp" id="shipp_comp_3" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" /><input type="text" placeholder="Other" name="other_shipp_type" id="other_shipp_type"  onclick="return other_shipp_type();" style="width: 80px;"></span>
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
    <?php
    }else{
    ?>
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
                            $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Copies';
                            $type = ($entered['plot_arch'] == '1') ? '1' : '0';
                            $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1') : EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                            $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeeded($company_id_view_plot, $user_id_add_set) : ArchSetsNeeded($company_id_view_plot, $user_id_add_set);
                            $plot_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1');
                            $copy_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                            ?>
                            <?php
                            if ($entered['plot_arch'] == '1') {
                                ?>
                                <tr bgcolor="#ffeee1">
                                    <td>Plotting on Bond</td>
                                    <td><?php echo $available_order[0]['origininals']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_1" class="avl_sets"  value="<?php echo ($available_order[0]['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_1" class="need_sets" value="<?php echo $available_order[0]['print_ea']; ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo $i; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo $i; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
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
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_2" class="need_sets" value="<?php echo $available_order[0]['print_ea']; ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('<?php echo '2'; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('<?php echo '2'; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
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
                            //}
                            $i++;
                        }
                        ?>
                    </table>
                </div>
                
                <div style="width: 99%;float: left;margin-top: 5px;">
                        <?php 
                    if($entered['size'] == 'Custom'){
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
                    <?php }
                    if($entered['output'] == 'Both'){
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
                    <?php }
                    if($entered['spl_instruction'] != ''){
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
                    }if($entered['plot_arch'] == '0'){
                        if($entered['pick_up_time'] != '0'){
                    ?>
                        <div style="width: 22%;float: left;border: 1px solid #F99B3E;">
                            <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                Pickup Option
                            </div>
                            <div style="padding-top: 3px;width: 100%;float: left;">
                                <input type="hidden" name="pick_up_time" id="pick_up_time" value="<?php echo $entered['pick_up_time']; ?>" />
                                <?php echo $entered['pick_up'].' '.$entered['pick_up_time']; ?>
                            </div>
                        </div>
                        <?php }if($entered['drop_off'] != '0'){ ?>
                        <div style="width: 22%;float: left;border: 1px solid #F99B3E;">
                            <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                Pickup Option
                            </div>
                            <div style="padding-top: 3px;width: 100%;float: left;">
                                <input type="hidden" name="drop_off" id="drop_off" value="<?php echo $entered['drop_off']; ?>" />
                                <?php echo $entered['drop_off']; ?>
                            </div>
                        </div>
                        <?php } } ?>
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
                <select  name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return pickup_soho_p();">                    
                    <?php
                    $address_book_show = AddressBookPickupSoho($pickup_from_soho_add);
                    $address_book = AddressBookPickupSohoAll();
                    foreach ($address_book as $address) {
                        ?>                                                                                        
                    <option value="<?php echo $address['id']; ?>" <?php if($address['id'] == $pickup_from_soho_add){?> selected="selected" <?php } ?> ><?php echo $address['caption']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <!-- Address Show Start -->
            <div id="show_address" style="float: left;width: 56%;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">
                <?php
                echo $address_book_show[0]['address_format'];
                ?>
            </div>
            
<!--            <div style="float: left;width: 100%;margin-top: 10px;">
                <div style="float: right;width: 61%;font-weight: bold;">Attention to: </div>
            </div>
            <div style="float: left;width: 100%;margin-top: 10px;">
                <div style="float: right;width: 61%;">
                    <div id="show_address_att" style="float: left;width: 50%;border: 1px #F99B3E solid;padding: 5px;height: 25px;">
                        <input type="text" name="shipp_att" id="shipp_att" value="<?php echo $address_book[0]['attention_to']; ?>" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
                    </div>
                </div>
            </div>-->

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
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" /><input type="text" placeholder="Other" name="other_shipp_type" id="other_shipp_type"  onclick="return other_shipp_type();" style="width: 80px;"></span>
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
    <?php }} ?>
