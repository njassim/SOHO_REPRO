<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);

if ($_POST['everything_return'] == '1') {

    $current_option = CurrentOption($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $rem_avl_options = AvlOptionsRemaining($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    ?>    
    <div style="width: 100%;float: left;border: 0px #F99B3E solid;margin-bottom: 5px;color: #FA8526;">            
        <div style="width: 96%;float: left;text-align: left;font-weight: bold;font-size: 15px;">ALL OPTIONS</div>        
    </div>
    <input type="hidden" name="tot_avl_options" id="tot_avl_options" value="<?php echo count($number_of_sets); ?>" />
    <input type="hidden" name="rem_avl_options" id="rem_avl_options" value="<?php echo count($rem_avl_options); ?>" />
    <input type="hidden" name="delivery_type_option" id="delivery_type_option" value="1" />
        <div style="border: 1px #F99B3E solid;margin-bottom: 20px;padding-bottom: 20px;width: 100%;float: left;">
            <div style="width: 100%;float: left;margin-top: 10px;">
                <div style="float: left;width: 100%;margin-left: 25px;font-weight: bold;"><span style="text-transform: uppercase;font-weight: bold;">Return everything to my office</span></div>
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
                                
                                if (($entered['spl_instruction'] != '') OR  ($entered['size'] == 'Custom') OR ($entered['output'] == 'Both') OR ($entered['drop_off'] != '0') OR ($entered['pick_up_time'] != '0')){
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
                        }//if ($entered['plot_arch'] == '0') {
                            if ($entered['pick_up_time'] != '0') {
                                if ($entered['pick_up_time'] != 'undefined') { 
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
                            <?php }}if ($entered['drop_off'] != '0') { 
                                    if ($entered['drop_off'] != 'undefined') { 
                                ?>
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
                            }
                        //}
                        ?>
                    </div>
                    <?php
                                }
                                $i++;
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

                <div style="float: left;width: 33%;margin-left: 25px;border: 1px #F99B3E solid;margin-top: 10px;font-weight: bold;padding:3px;">Send to: 
                    <?php 
                    $address_book = AddressBookCompanyPrimary($_SESSION['sohorepro_companyid']);
                    ?>
                    <select  name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return show_address();">                    
                            <option value="<?php echo $address_book[0]['id']; ?>">Return Everything To My Office</option>
                            <option value="P1">Pickup @ 381 Broome St</option>
                            <option value="P2">Pickup @ 307 7th Ave, 5th Flr</option>
                            <option class="select-dash" disabled="disabled">-----------------------------------------</option>
                        <?php                        
                        foreach ($address_book as $address) {
                            ?>                                                                                        
                            <option value="<?php echo $address['id']; ?>" selected="selected"><?php echo $address['company_name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <!-- Address Show Start -->
                <div id="show_address" style="float: left;width: 25%;height: 50px !important;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book[0]['address_1']; ?></div>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book[0]['address_2']; ?></div>
                    <?php if($address_book[0]['address_3'] != ''){?>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book[0]['address_3']; ?></div>
                    <?php } ?>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book[0]['city'].',&nbsp;'.StateName($address_book[0]['state']).'&nbsp;'.$address_book[0]['zip']; ?></div>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book[0]['phone']; ?></div>
                    <?php
                    //echo $address_book[0]['address_1'] . ', ' . $address_book[0]['address_2'] . ', ' . $address_book[0]['city'] . ', ' . StateName($address_book[0]['state']) . ' ' . $address_book[0]['zip'];
                    ?>
                </div>

                <div style="float: left;width: 100%;margin-top: 5px;">   
                    <div style="float: left;width: 38%;">
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
        <div style="float:right;">            
            <input class="all_options" value="Continue" style="cursor: pointer;font-size: 12px; padding: 1.5px; width: 135px; margin-right: 14px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;margin-top: -0px !important;" type="button" onclick="return continue_recipient_everyting_return();" />
        </div>
    <?php
   
} elseif ($_POST['everything_return'] == '1_99') {
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
                    <select  name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return show_address();">                    
                        <?php
                        $address_book = AddressBookCompanyPrimary($_SESSION['sohorepro_companyid']);
                        foreach ($address_book as $address) {
                            ?>                                                                                        
                            <option value="<?php echo $address['id']; ?>" selected="selected"><?php echo $address['company_name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <!-- Address Show Start -->
                <div id="show_address" style="float: left;width: 56%;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">
                    <?php
                    echo $address_book[0]['address_1'] . ', ' . $address_book[0]['address_2'] . ', ' . $address_book[0]['city'] . ', ' . StateName($address_book[0]['state']) . ' ' . $address_book[0]['zip'];
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
} elseif ($_POST['everything_return'] == 'OPTION_1') {
    
    $current_option = CurrentOption($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $rem_avl_options = AvlOptionsRemaining($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    ?>    
    <input type="hidden" name="tot_avl_options" id="tot_avl_options" value="<?php echo count($number_of_sets); ?>" />
    <input type="hidden" name="rem_avl_options" id="rem_avl_options" value="<?php echo count($rem_avl_options); ?>" />
    <input type="hidden" name="delivery_type_option" id="delivery_type_option" value="1" />
        <div style="border: 1px #F99B3E solid;margin-bottom: 20px;padding-bottom: 20px;width: 100%;float: left;">
            <div style="width: 100%;float: left;margin-top: 10px;">
                <div style="float: right;width: 20%;font-weight: bold;cursor: pointer;" title="Update Recipient" alt="Update Recipient" onclick="return update_recipient_dynamic_option_1('<?php echo $edit_id; ?>');"><span style="background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;background: #009C58;">Update</span></div>
                <div style="float: left;width: 100%;margin-left: 25px;font-weight: bold;"><span style="text-transform: uppercase;font-weight: bold;">Return everything to my office</span></div>
                <?php
                $user_id_add_set = $_SESSION['sohorepro_userid'];
                $company_id_view_plot = $_SESSION['sohorepro_companyid'];
                ?>
                <!-- Address Show End -->
                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    <?php
                        $number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid']);
                        $cust_original_order    = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid'], $_SESSION['ref_val']);
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
                            /*
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
                                
                                if (($entered['spl_instruction'] != '') OR  ($entered['size'] == 'Custom') OR ($entered['output'] == 'Both')){
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
                        }if ($entered['plot_arch'] == '0') {
                            if ($entered['pick_up_time'] != '0') {
                                ?>
                                <div style="width: 22%;float: left;border: 1px solid #F99B3E;">
                                    <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                        Schedule a Pickup
                                    </div>
                                    <div style="padding-top: 3px;width: 100%;float: left;">
                                        <input type="hidden" name="pick_up_time" id="pick_up_time" value="<?php echo $entered['pick_up_time']; ?>" />
                                        <?php echo $entered['pick_up'] . ' ' . $entered['pick_up_time']; ?>
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
                        }
                        ?>
                    </div>
                    <?php
                                }
                                $i++;
                            }
                            */
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
                <?php
                    $entered_option_1 = NeededSets($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid']);
//                    echo '<pre>';
//                    print_r($entered_option_1[0]);
//                    echo '</pre>';
                ?>
                <div style="float: left;width: 33%;margin-left: 25px;border: 1px #F99B3E solid;margin-top: 10px;font-weight: bold;padding:3px;">Send to: 
                    <?php 
                    $address_book = AddressBookCompanyPrimary($_SESSION['sohorepro_companyid']);
                    ?>
                    <select  name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return show_address_option_1();">                    
                            <option value="<?php echo $address_book[0]['id']; ?>">Return Everything To My Office</option>
                            <option value="P1" <?php if($entered_option_1[0]['shipp_id'] == "P1"){ ?> selected="selected" <?php } ?>>Pickup @ 381 Broome St</option>
                            <option value="P2" <?php if($entered_option_1[0]['shipp_id'] == "P2"){ ?> selected="selected" <?php } ?>>Pickup @ 307 7th Ave, 5th Flr</option>
                            <option class="select-dash" disabled="disabled">-----------------------------------------</option>
                        <?php                        
                        foreach ($address_book as $address) {
                            ?>                                                                                        
                            <option value="<?php echo $address['id']; ?>" <?php if($entered_option_1[0]['shipp_id'] == $address['id']){ ?> selected="selected" <?php } ?>><?php echo $address['company_name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <!-- Address Show Start -->
                <?php if(($entered_option_1[0]['shipp_id'] != 'P1') || ($entered_option_1[0]['shipp_id'] != "P2")){ ?>
                <div id="show_address" style="float: left;width: 25%;height: 65px !important;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book[0]['address_1']; ?></div>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book[0]['address_2']; ?></div>
                    <?php if($address_book[0]['address_3'] != ''){?>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book[0]['address_3']; ?></div>
                    <?php } ?>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book[0]['city'].',&nbsp;'.StateName($address_book[0]['state']).'&nbsp;'.$address_book[0]['zip']; ?></div>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book[0]['phone']; ?></div>
                    <?php
                    //echo $address_book[0]['address_1'] . ', ' . $address_book[0]['address_2'] . ', ' . $address_book[0]['city'] . ', ' . StateName($address_book[0]['state']) . ' ' . $address_book[0]['zip'];
                    ?>
                </div>
                <?php }  else {
                $pic_address = AddressBookPickupSohoCap($entered_option_1[0]['shipp_id']);  
                ?>
                <div id="show_address" style="float: left;width: 25%;height: 65px !important;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">
                    <?php
                    echo $pic_address[0]['address'];
                    ?>
                </div>  
                <?php } ?>

                <div style="float: left;width: 100%;margin-top: 5px;">   
                    <div style="float: left;width: 38%;">
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
                                    <input type="text" name="shipp_att" id="shipp_att" value="<?php echo $entered_option_1[0]['attention_to']; ?>" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                                    <input type="text" name="contact_ph" id="contact_ph" onclick="return contact_phone();"  value="<?php echo $entered_option_1[0]['contact_ph']; ?>" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Contact Phone End -->
                </div>
                <?php
                $all_days_off = AllDayOff();
                foreach ($all_days_off as $days_off_split) {
                    $all_days_in[] = $days_off_split['date'];
                }
                $all_date = implode(",", $all_days_in);
                $all_date_exist = str_replace("/", "-", $all_date);
                ?>
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
                            <input class="picker_icon" value="<?php echo $entered_option_1[0]['shipp_date']; ?>" type="text" name="date_needed" id="date_needed" style="width: 75px;" onclick="return date_reveal_return();" />
                            <input id="time_picker_icon" value="<?php echo $entered_option_1[0]['shipp_time']; ?>" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time_return();" />
                        </div>

                    </div>
                </div>
                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                    <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">
                        <?php
            $checked        = ($entered_option_1[0]['delivery_type'] != '0') ? '' : 'checked';
            $checked_use    = ($entered_option_1[0]['delivery_type'] == '0') ? '' : 'checked';
            $checked_use_dis = ($entered_option_1[0]['delivery_type'] != '0') ? '' : 'display: none;';
            $display        = ($entered_option_1[0]['delivery_type'] != '0') ? '' : 'display: none;';
            $shipp_comp_1   = ($entered_option_1[0]['shipp_comp_1'] != '0') ? 'checked' : '';
            $shipp_comp_2   = ($entered_option_1[0]['shipp_comp_2'] != '0') ? 'checked' : '';
            $shipp_comp_3   = ($entered_option_1[0]['shipp_comp_3'] != '0') ? 'checked' : '';
            $bill_val       = ($entered_option_1[0]['billing_number'] != '0') ? $entered_option_1[0]['billing_number'] : '';
            ?>
                        <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 200px;">
                        <input type="checkbox" name="arrange_del" id="arrange_del" <?php echo $checked; ?> style="width: 10% !important;margin-bottom: 0px;" onclick="uncheck_delivery();" /><span style="text-transform: uppercase;">Soho to arrange delivery</span>
                    </div>              

                    </div>
                    <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                        <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;float: left;">
                            <input type="checkbox" name="preffer_del" <?php echo $checked_use; ?> id="preffer_del" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="check_prefer_delivery();" /><span style="text-transform: uppercase;">Use My Carrier</span>
                        </div>

                        <div id="preffered_info" style="width: 91%;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;<?php echo $checked_use_dis; ?>">
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery:  </span>
                                    <select  name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address_();">                    
                                        <option value="1" <?php if ($entered_option_1[0]['delivery_type'] == '1') { ?> selected="selected" <?php } ?>>Next Day Air</option> 
                                        <option value="2" <?php if ($entered_option_1[0]['delivery_type'] == '2') { ?> selected="selected" <?php } ?>>Two Day Air</option>
                                        <option value="3" <?php if ($entered_option_1[0]['delivery_type'] == '3') { ?> selected="selected" <?php } ?>>Three Day Air</option>
                                        <option value="4" <?php if ($entered_option_1[0]['delivery_type'] == '4') { ?> selected="selected" <?php } ?>>Ground</option>
                                    </select>
                                </li>                    
                                <li>
                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1" onclick="return field_color();" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx"  <?php echo $shipp_comp_1; ?> /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2" onclick="return field_color();" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" <?php echo $shipp_comp_2; ?> /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3" onclick="return field_color();" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" <?php echo $shipp_comp_3; ?> /><input type="text" name="other_shipp_type" placeholder="Other" id="other_shipp_type" value="<?php echo ($entered_option_1[0]['shipp_comp_3'] != '0') ? $entered_option_1[0]['shipp_comp_3'] : ''; ?>" onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number" value="<?php echo $bill_val; ?>" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>


                <div style="font-weight: bold;width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    Special Instructions:            
                </div>        
                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    <textarea name="spl_recipient" id="spl_recipient" rows="3" cols="18" style="width: 200px;height: 40px;"><?php echo $entered_option_1[0]['spl_inc']; ?></textarea>
                </div>

            </div>
        </div>        
<?php
    
}elseif ($_POST['everything_return'] == 'OPTION_1_UPDATE') {

    $shipping_id_rec                = $_POST['shipping_id_rec'];
    $user_session                   = $_SESSION['sohorepro_userid'];
    $user_session_comp              = $_SESSION['sohorepro_companyid'];
    $date_needed                    = $_POST['date_needed'];
    $time_needed                    = $_POST['time_needed'];
    $spl_recipient                  = $_POST['spl_recipient'];
    
    $delivery_type                  = $_POST['delivery_type'];
    $bill_number                    = $_POST['bill_number'];
    $shipp_comp_1_f                 = $_POST['shipp_comp_1_f'];
    $shipp_comp_2_f                 = $_POST['shipp_comp_2_f'];
    $shipp_comp_3_f                 = $_POST['shipp_comp_3_f'];

    $attention_to                   = $_POST['attention_to'];
    $contact_ph                     = $_POST['contact_ph'];
    
    
    $user_id_add_set                = $_SESSION['sohorepro_userid'];
    $company_id_view_plot           = $_SESSION['sohorepro_companyid'];
    
    
    $query = "UPDATE sohorepro_sets_needed
			SET     shipp_id        = '" . $shipping_id_rec . "',
                                attention_to    = '" . $attention_to . "',   
                                shipp_date      = '" . $date_needed . "',
                                shipp_time      = '" . $time_needed . "',  
                                spl_inc         = '" . $spl_recipient . "',
                                delivery_type   = '" . $delivery_type . "',
                                contact_ph      = '" . $contact_ph ."',  
                                billing_number  = '" . $bill_number . "',
                                shipp_comp_1    = '" . $shipp_comp_1_f . "',
                                shipp_comp_2    = '" . $shipp_comp_2_f . "',
                                shipp_comp_3    = '" . $shipp_comp_3_f . "'  WHERE comp_id = '".$company_id_view_plot."' AND usr_id = '".$user_id_add_set."' AND delivery_type_option = '1' AND order_id = '0' ";

    $sql_result = mysql_query($query);
    if($sql_result){
        $entered_needed_sets     = NeededSets($user_session_comp, $user_session);
    ?>
        <div style="float: left;" class="shaddows">
                            <div class="ribbon" id="ribbon_final"><span>RECIPIENT 1</span></div>
                        <div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;">                            
                            <div style="float: right;">
                                <span title="Edit Recipient" alt="Edit Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;font-weight: bold;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;margin-right: 15px;" onclick="return edit_recipient_option_1('<?php echo $entered_sets['id']; ?>');">Edit</span>                               
                            </div>
                            
                            <div style="float:left;width: 100%;text-align: center;font-weight: bold;">
                                RETURN EVERYTHING TO MY OFFICE
                            </div>
                            
                            <div class="details_div">
                    
                <!-- Customer Details Start -->
                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">Send to: </div>
                
                <div style="float: left;width: 33%;margin-left: 30px;">  
                    <?php 
                    if(($entered_needed_sets[0]['shipp_id'] != 'P1') && ($entered_needed_sets[0]['shipp_id'] != "P2")){
                    $cust_add = getCustomeInfo($entered_needed_sets[0]['shipp_id']);
                    $cust_add_2 = ($cust_add[0]['comp_business_address2'] != '') ? $cust_add[0]['comp_business_address2']. '<br>'  : '';                    
                    echo $cust_add[0]['comp_name'] . '<br>' . $cust_add[0]['comp_business_address1'] . '<br>' . $cust_add_2 . $cust_add[0]['comp_city'] . '&nbsp;' . $cust_add[0]['comp_state'] . '&nbsp;' . $cust_add[0]['comp_zipcode'].'<br>'.$cust_add[0]['comp_contact_phone'];                    
                    }else{
                    $pic_address = AddressBookPickupSohoCap($entered_needed_sets[0]['shipp_id']);
                    echo $pic_address[0]['address'];
                    }
                    ?>                   
                </div>                
                <!-- Customer Details End -->                    
                                
                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST: </div>
                <div style="float: left;width: 92%;margin-left: 30px;margin-top: 5px;">
                    <?php
                    $cust_original_order    = EnteredPlotRecipients($user_session_comp, $user_session);
                    
                    //$cust_needed_originals  = $cust_original_order[0]['origininals'];
                    
                    //$cust_needed_sets       = ($cust_original_order[0]['print_ea'] != '0') ? $cust_original_order[0]['print_ea'] : $cust_original_order[0]['arch_needed'];
                    //$cust_order_type        = ($cust_original_order[0]['plot_arch'] == '0') ? 'Architectural Copies' : 'Plotting on Bond';
                    $option                 = ($cust_original_order[0]['plot_arch'] == '0') ? 'Pickup Options:' : 'File Options:';  
                    ?>
                    <table border="1" style="width: 100%;">
                        <tr bgcolor="#BFC5CD">
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
//                        echo '<pre>';
//                        print_r($cust_original_order);
//                        echo '</pre>';
                        
                        foreach ($cust_original_order as $original){                            
                            $cust_needed_sets       = ($original['print_ea'] != '0') ? $original['print_ea'] : $original['arch_needed'];
                            $cust_order_type        = ($original['plot_arch'] == '0') ? 'Architectural Copies' : 'Plotting on Bond';                               
                            $size         = ($original['size'] == 'undefined') ? $original['arch_size'] : $original['size'];
                            $output       = ($original['output'] == 'undefined') ? $original['arch_output'] : $original['output'];
                            $media        = ($original['media'] == 'undefined') ? $original['arch_media'] : $original['media'];
                            $binding      = ($original['binding'] == 'undefined') ? $original['arch_binding'] : $original['binding'];
                            $folding      = ($original['folding'] == 'undefined') ? $original['arch_folding'] : $original['folding'];                            
                        ?>
                        <tr bgcolor="#F8F8F8">
                            <td><?php echo $original['options']; ?></td>
                            <td><?php echo $original['origininals']; ?></td>
                            <td><?php echo $cust_needed_sets; ?></td>
                            <td><?php echo $cust_order_type; ?></td>                            
                            <td><?php echo $size; ?></td>
                            <td style="text-transform: uppercase;"><?php echo $output; ?></td>
                            <td><?php echo $media; ?></td>
                            <td><?php echo ucfirst($binding); ?></td>
                            <td><?php echo ucfirst($folding); ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                   
                </div>
                
                
                <?php
                            //$enteredPlot = EnteredPlotRecipients($company_id_view_plot, $user_id_add_set);
                            $enteredPlot = EnteredPlotRecipientsMulti($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid'], $_SESSION['ref_val']);
                            /*
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
                                
                                if (($entered['spl_instruction'] != '') OR  ($entered['size'] == 'Custom') OR ($entered['output'] == 'Both')){
                                ?>
                                
                    <div style="float:left;width: 95%;font-weight: bold;color: #000;margin-top: 7px;margin-left: 30px;"> OPTION <?php echo $entered['options']; ?></div>
                    <div style="width: 90%;float: left;border: 1px solid #BFC5CD;padding: 5px;margin-left: 30px;">   
                        <?php
                        if ($entered['size'] == 'Custom') {
                            ?>
                            <div style="width: 22%;float: left;border: 1px solid #BFC5CD;margin-right: 10px;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
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
                            <div style="width: 22%;float: left;border: 1px solid #BFC5CD;margin-right: 10px;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
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
                            <div style="width: 22%;float: left;border: 1px solid #BFC5CD;margin-right: 10px;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
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
                                $pickup_option = ($entered['pick_up'] == "ASAP") ? $entered['pick_up'] : $entered['pick_up'] . ' ' . $entered['pick_up_time'];
                                ?>
                                <div style="width: 22%;float: left;border: 1px solid #BFC5CD;">
                                    <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
                                        Schedule a Pickup
                                    </div>
                                    <div style="padding-top: 3px;width: 100%;float: left;">
                                        <input type="hidden" name="pick_up_time" id="pick_up_time" value="<?php echo $entered['pick_up_time']; ?>" />
                                        <?php echo $pickup_option; ?>
                                    </div>
                                </div>
                            <?php }if ($entered['drop_off'] != '0') { ?>
                                <div style="width: 22%;float: left;border: 1px solid #BFC5CD;">
                                    <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
                                        Drop-off Option
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
                                }
                            }
                            */
                            ?>
                            <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;">
                    <?php
                    $date_asap  = ($entered_needed_sets[0]['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_needed_sets[0]['shipp_time'] : '';
                    ?>
                    <span style="font-weight: bold;">When Needed: </span><?php echo $entered_needed_sets[0]['shipp_date'].$date_asap; ?>            
                </div>        
                <?php
                if ($entered_needed_sets[0]['delivery_type'] != '0') {
                    ?>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Send Via: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <?php
                        if ($entered_needed_sets[0]['delivery_type'] == '1') {
                            $delivery_type = 'Next Day Air';
                        } elseif ($entered_needed_sets[0]['delivery_type'] == '2') {
                            $delivery_type = 'Two Day Air';
                        } elseif ($entered_needed_sets[0]['delivery_type'] == '3') {
                            $delivery_type = 'Three Day Air';
                        } elseif ($entered_needed_sets[0]['delivery_type'] == '4') {
                            $delivery_type = 'Ground';
                        }

                        $ship_type_1 = ($entered_needed_sets[0]['shipp_comp_1'] == '0') ? '' : $entered_needed_sets[0]['shipp_comp_1'];
                        $ship_type_2 = ($entered_needed_sets[0]['shipp_comp_2'] == '0') ? '' : $entered_needed_sets[0]['shipp_comp_2'];
                        $ship_type_3 = ($entered_needed_sets[0]['shipp_comp_3'] == '0') ? '' : $entered_needed_sets[0]['shipp_comp_3'];

                        echo $ship_type_1 . $ship_type_2 . $ship_type_3 . ',&nbsp;' . $delivery_type . ',&nbsp;Account # ' . $entered_needed_sets[0]['billing_number'];
                        ?>
                    </div>
                <?php } else { ?>                            
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Send Via: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        SOHO TO ARRANGE DELIVERY
                    </div>    
                <?php }if($entered_needed_sets[0]['spl_inc'] != ''){ ?>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Special Instructions: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <?php echo $entered_needed_sets[0]['spl_inc']; ?>
                    </div>
                        <?php } ?>
                        </div>
                        </div>
                    </div>
    <?php
    }
    
}elseif ($_POST['everything_return'] == 'OPTION_2') {
    
    $current_option = CurrentOption($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $rem_avl_options = AvlOptionsRemaining($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    ?>    
    <input type="hidden" name="tot_avl_options" id="tot_avl_options" value="<?php echo count($number_of_sets); ?>" />
    <input type="hidden" name="rem_avl_options" id="rem_avl_options" value="<?php echo count($rem_avl_options); ?>" />
    <input type="hidden" name="delivery_type_option" id="delivery_type_option" value="1" />
        <div style="border: 1px #F99B3E solid;margin-bottom: 20px;padding-bottom: 20px;width: 100%;float: left;">
            <div style="width: 100%;float: left;margin-top: 10px;">
                <div style="float: right;width: 20%;font-weight: bold;cursor: pointer;" title="Update Recipient" alt="Update Recipient" onclick="return update_recipient_dynamic_option_2('<?php echo $edit_id; ?>');"><span style="background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;background: #009C58;">Update</span></div>
                <div style="float: left;width: 100%;margin-left: 25px;font-weight: bold;"><span style="text-transform: uppercase;font-weight: bold;">SEND EVERYTHING TO</span></div>
                <?php
                $user_id_add_set = $_SESSION['sohorepro_userid'];
                $company_id_view_plot = $_SESSION['sohorepro_companyid'];
                ?>
                <!-- Address Show End -->
                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    <?php
                        $number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid']);
                        $cust_original_order    = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid'], $_SESSION['ref_val']);
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
                                
                                if (($entered['spl_instruction'] != '') OR  ($entered['size'] == 'Custom') OR ($entered['output'] == 'Both')){
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
                        }if ($entered['plot_arch'] == '0') {
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
                        }
                        ?>
                    </div>
                    <?php
                                }
                                $i++;
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
                <?php
                    $entered_option_1 = NeededSets($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid']);
//                    echo '<pre>';
//                    print_r($entered_option_1[0]);
//                    echo '</pre>';
                ?>
                <div style="float: left;width: 33%;margin-left: 25px;border: 1px #F99B3E solid;margin-top: 10px;font-weight: bold;padding:3px;">Send to: 
                    <?php 
                    $address_book = AddressBookCompanyService($_SESSION['sohorepro_companyid']);
                    ?>
                    <select  name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return show_address_option_2();">                    
                            <option value="<?php echo $address_book[0]['id']; ?>">Return Everything To My Office</option>
                            <option value="P1" <?php if($entered_option_1[0]['shipp_id'] == "P1"){ ?> selected="selected" <?php } ?>>Pickup @ 381 Broome St</option>
                            <option value="P2" <?php if($entered_option_1[0]['shipp_id'] == "P2"){ ?> selected="selected" <?php } ?>>Pickup @ 307 7th Ave, 5th Flr</option>
                            <option class="select-dash" disabled="disabled">-----------------------------------------</option>
                        <?php                        
                        foreach ($address_book as $address) {
                            ?>                                                                                        
                            <option value="<?php echo $address['id']; ?>" <?php if($entered_option_1[0]['shipp_id'] == $address['id']){ ?> selected="selected" <?php } ?>><?php echo $address['company_name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <!-- Address Show Start -->
                <?php if(($entered_option_1[0]['shipp_id'] != 'P1') || ($entered_option_1[0]['shipp_id'] != "P2")){
                    $address_book_2 = AddressBookCompanyService_option2($entered_option_1[0]['shipp_id']);
                    ?>
                <div id="show_address" style="float: left;width: 25%;height: 80px !important;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book_2[0]['address_1']; ?></div>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book_2[0]['address_2']; ?></div>
                    <?php if($address_book[0]['address_3'] != ''){?>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book_2[0]['address_3']; ?></div>
                    <?php } ?>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book_2[0]['city'].',&nbsp;'.StateName($address_book[0]['state']).'&nbsp;'.$address_book[0]['zip']; ?></div>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book_2[0]['phone']; ?></div>
                    <?php
                    //echo $address_book[0]['address_1'] . ', ' . $address_book[0]['address_2'] . ', ' . $address_book[0]['city'] . ', ' . StateName($address_book[0]['state']) . ' ' . $address_book[0]['zip'];
                    ?>
                </div>
                <?php  }  else {                      
                $pic_address = AddressBookPickupSohoCap($entered_option_1[0]['shipp_id']);
                ?>
                    <div id="show_address" style="float: left;width: 25%;height: 80px !important;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">
                    <?php
                    echo $pic_address[0]['address'];
                    ?>
                </div>  
                <?php
                } ?>

                <div style="float: left;width: 100%;margin-top: 5px;">   
                    <div style="float: left;width: 38%;">
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
                                    <input type="text" name="shipp_att" id="shipp_att" value="<?php echo $entered_option_1[0]['attention_to']; ?>" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                                    <input type="text" name="contact_ph" id="contact_ph" onfocus="return contact_phone();"  value="<?php echo $entered_option_1[0]['contact_ph']; ?>" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Contact Phone End -->
                </div>
                <?php
                $all_days_off = AllDayOff();
                foreach ($all_days_off as $days_off_split) {
                    $all_days_in[] = $days_off_split['date'];
                }
                $all_date = implode(",", $all_days_in);
                $all_date_exist = str_replace("/", "-", $all_date);
                ?>
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
                            <input class="picker_icon" value="<?php echo $entered_option_1[0]['shipp_date']; ?>" type="text" name="date_needed" id="date_needed" style="width: 75px;" onclick="return date_reveal_return();" />
                            <input id="time_picker_icon" value="<?php echo $entered_option_1[0]['shipp_time']; ?>" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time_return();" />
                        </div>

                    </div>
                </div>
                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                    <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">
                        <?php
            $checked        = ($entered_option_1[0]['delivery_type'] != '0') ? '' : 'checked';
            $checked_use    = ($entered_option_1[0]['delivery_type'] == '0') ? '' : 'checked';
            $checked_use_dis = ($entered_option_1[0]['delivery_type'] != '0') ? '' : 'display: none;';
            $display        = ($entered_option_1[0]['delivery_type'] != '0') ? '' : 'display: none;';
            $shipp_comp_1   = ($entered_option_1[0]['shipp_comp_1'] != '0') ? 'checked' : '';
            $shipp_comp_2   = ($entered_option_1[0]['shipp_comp_2'] != '0') ? 'checked' : '';
            $shipp_comp_3   = ($entered_option_1[0]['shipp_comp_3'] != '0') ? 'checked' : '';
            $bill_val       = ($entered_option_1[0]['billing_number'] != '0') ? $entered_option_1[0]['billing_number'] : '';
            ?>
                        <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 200px;">
                        <input type="checkbox" name="arrange_del" id="arrange_del" <?php echo $checked; ?> style="width: 10% !important;margin-bottom: 0px;" onclick="uncheck_delivery();" /><span style="text-transform: uppercase;">Soho to arrange delivery</span>
                    </div>              

                    </div>
                    <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                        <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;float: left;">
                            <input type="checkbox" name="preffer_del" <?php echo $checked_use; ?> id="preffer_del" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="check_prefer_delivery();" /><span style="text-transform: uppercase;">Use My Carrier</span>
                        </div>

                        <div id="preffered_info" style="width: 91%;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;<?php echo $checked_use_dis; ?>">
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery:  </span>
                                    <select  name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address_();">                    
                                        <option value="1" <?php if ($entered_option_1[0]['delivery_type'] == '1') { ?> selected="selected" <?php } ?>>Next Day Air</option> 
                                        <option value="2" <?php if ($entered_option_1[0]['delivery_type'] == '2') { ?> selected="selected" <?php } ?>>Two Day Air</option>
                                        <option value="3" <?php if ($entered_option_1[0]['delivery_type'] == '3') { ?> selected="selected" <?php } ?>>Three Day Air</option>
                                        <option value="4" <?php if ($entered_option_1[0]['delivery_type'] == '4') { ?> selected="selected" <?php } ?>>Ground</option>
                                    </select>
                                </li>                    
                                <li>
                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1" onclick="return field_color();" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx"  <?php echo $shipp_comp_1; ?> /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2" onclick="return field_color();" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" <?php echo $shipp_comp_2; ?> /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3" onclick="return field_color();" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" <?php echo $shipp_comp_3; ?> /><input type="text" name="other_shipp_type" placeholder="Other" id="other_shipp_type" value="<?php echo ($entered_option_1[0]['shipp_comp_3'] != '0') ? $entered_option_1[0]['shipp_comp_3'] : ''; ?>" onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number" value="<?php echo $bill_val; ?>" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>


                <div style="font-weight: bold;width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    Special Instructions:            
                </div>        
                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    <textarea name="spl_recipient" id="spl_recipient" rows="3" cols="18" style="width: 200px;height: 40px;"><?php echo $entered_option_1[0]['spl_inc']; ?></textarea>
                </div>

            </div>
        </div>        
<?php
}elseif ($_POST['everything_return'] == 'OPTION_2_UPDATE') {

    $shipping_id_rec                = $_POST['shipping_id_rec'];
    $user_session                   = $_SESSION['sohorepro_userid'];
    $user_session_comp              = $_SESSION['sohorepro_companyid'];
    $date_needed                    = $_POST['date_needed'];
    $time_needed                    = $_POST['time_needed'];
    $spl_recipient                  = $_POST['spl_recipient'];
    
    $delivery_type                  = $_POST['delivery_type'];
    $bill_number                    = $_POST['bill_number'];
    $shipp_comp_1_f                 = $_POST['shipp_comp_1_f'];
    $shipp_comp_2_f                 = $_POST['shipp_comp_2_f'];
    $shipp_comp_3_f                 = $_POST['shipp_comp_3_f'];

    $attention_to                   = $_POST['attention_to'];
    
    $user_id_add_set                = $_SESSION['sohorepro_userid'];
    $company_id_view_plot           = $_SESSION['sohorepro_companyid'];
    
    
    $query = "UPDATE sohorepro_sets_needed
			SET     shipp_id        = '" . $shipping_id_rec . "',
                                attention_to    = '" . $attention_to . "',   
                                shipp_date      = '" . $date_needed . "',
                                shipp_time      = '" . $time_needed . "',  
                                spl_inc         = '" . $spl_recipient . "',
                                delivery_type   = '" . $delivery_type . "',
                                billing_number  = '" . $bill_number . "',
                                shipp_comp_1    = '" . $shipp_comp_1_f . "',
                                shipp_comp_2    = '" . $shipp_comp_2_f . "',
                                shipp_comp_3    = '" . $shipp_comp_3_f . "'  WHERE comp_id = '".$company_id_view_plot."' AND usr_id = '".$user_id_add_set."' AND delivery_type_option = '2' AND order_id = '0' ";

    $sql_result = mysql_query($query);
    if($sql_result){
        $entered_needed_sets     = NeededSets($user_session_comp, $user_session);
    ?>
        <div style="float: left;" class="shaddows">
                            <div class="ribbon" id="ribbon_final"><span>RECIPIENT 1</span></div>
                        <div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;">                            
                            <div style="float: right;">
                                <span title="Edit Recipient" alt="Edit Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;font-weight: bold;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;margin-right: 15px;" onclick="return edit_recipient_option_2('<?php echo $entered_sets['id']; ?>');">Edit</span>                               
                            </div>
                            
                            <div style="float:left;width: 100%;text-align: center;font-weight: bold;">
                                SEND EVERYTHING TO
                            </div>
                            
                            <div class="details_div">
                    
                <!-- Customer Details Start -->
                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">Send to: </div>
                
                <div style="float: left;width: 33%;margin-left: 30px;">  
                    <?php 
                    if(($entered_needed_sets[0]['shipp_id'] != 'P1') && ($entered_needed_sets[0]['shipp_id'] != "P2")){
                    $cust_add = AddressBookCompanyService_option2($shipping_id_rec);        
                    $cust_add_2 = ($cust_add[0]['address_2'] != '') ? $cust_add[0]['address_2']. '<br>'  : '';    
                    $cust_add_3 = ($cust_add[0]['address_3'] != '') ? $cust_add[0]['address_3']. '<br>'  : '';   
                    echo $cust_add[0]['company_name'] . '<br>' .$cust_add[0]['address_1'] . '<br>' . $cust_add_2.$cust_add_2 . $cust_add[0]['city'] . '&nbsp;' . StateName($cust_add[0]['state']) . '&nbsp;' . $cust_add[0]['zip'].'<br>'.$cust_add[0]['phone'];
                    }else{
                    $pic_address = AddressBookPickupSohoCap($entered_needed_sets[0]['shipp_id']);
                    echo $pic_address[0]['address'];
                    }
                    ?>                   
                </div>                
                <!-- Customer Details End -->                    
                                
                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST: </div>
                <div style="float: left;width: 92%;margin-left: 30px;margin-top: 5px;">
                    <?php
                    $cust_original_order    = EnteredPlotRecipients($user_session_comp, $user_session);
                    
                    //$cust_needed_originals  = $cust_original_order[0]['origininals'];
                    
                    //$cust_needed_sets       = ($cust_original_order[0]['print_ea'] != '0') ? $cust_original_order[0]['print_ea'] : $cust_original_order[0]['arch_needed'];
                    //$cust_order_type        = ($cust_original_order[0]['plot_arch'] == '0') ? 'Architectural Copies' : 'Plotting on Bond';
                    $option                 = ($cust_original_order[0]['plot_arch'] == '0') ? 'Pickup Options:' : 'File Options:';  
                    ?>
                    <table border="1" style="width: 100%;">
                        <tr bgcolor="#BFC5CD">
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
//                        echo '<pre>';
//                        print_r($cust_original_order);
//                        echo '</pre>';
                        
                        foreach ($cust_original_order as $original){                            
                            $cust_needed_sets       = ($original['print_ea'] != '0') ? $original['print_ea'] : $original['arch_needed'];
                            $cust_order_type        = ($original['plot_arch'] == '0') ? 'Architectural Copies' : 'Plotting on Bond';                               
                            $size         = ($original['size'] == 'undefined') ? $original['arch_size'] : $original['size'];
                            $output       = ($original['output'] == 'undefined') ? $original['arch_output'] : $original['output'];
                            $media        = ($original['media'] == 'undefined') ? $original['arch_media'] : $original['media'];
                            $binding      = ($original['binding'] == 'undefined') ? $original['arch_binding'] : $original['binding'];
                            $folding      = ($original['folding'] == 'undefined') ? $original['arch_folding'] : $original['folding'];                            
                        ?>
                        <tr bgcolor="#F8F8F8">
                            <td><?php echo $original['options']; ?></td>
                            <td><?php echo $original['origininals']; ?></td>
                            <td><?php echo $cust_needed_sets; ?></td>
                            <td><?php echo $cust_order_type; ?></td>                            
                            <td><?php echo $size; ?></td>
                            <td style="text-transform: uppercase;"><?php echo $output; ?></td>
                            <td><?php echo $media; ?></td>
                            <td><?php echo ucfirst($binding); ?></td>
                            <td><?php echo ucfirst($folding); ?></td>
                        </tr>
                        <?php
                        }
                        ?>
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
                                
                                if (($entered['spl_instruction'] != '') OR  ($entered['size'] == 'Custom') OR ($entered['output'] == 'Both')){
                                ?>
                                
                    <div style="float:left;width: 95%;font-weight: bold;color: #000;margin-top: 7px;margin-left: 30px;"> OPTION <?php echo $entered['options']; ?></div>
                    <div style="width: 90%;float: left;border: 1px solid #BFC5CD;padding: 5px;margin-left: 30px;">   
                        <?php
                        if ($entered['size'] == 'Custom') {
                            ?>
                            <div style="width: 22%;float: left;border: 1px solid #BFC5CD;margin-right: 10px;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
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
                            <div style="width: 22%;float: left;border: 1px solid #BFC5CD;margin-right: 10px;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
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
                            <div style="width: 22%;float: left;border: 1px solid #BFC5CD;margin-right: 10px;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
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
                                $pickup_option = ($entered['pick_up'] == "ASAP") ? $entered['pick_up'] : $entered['pick_up'] . ' ' . $entered['pick_up_time'];
                                ?>
                                <div style="width: 22%;float: left;border: 1px solid #BFC5CD;">
                                    <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
                                        Schedule a Pickup
                                    </div>
                                    <div style="padding-top: 3px;width: 100%;float: left;">
                                        <input type="hidden" name="pick_up_time" id="pick_up_time" value="<?php echo $entered['pick_up_time']; ?>" />
                                        <?php echo $pickup_option; ?>
                                    </div>
                                </div>
                            <?php }if ($entered['drop_off'] != '0') { ?>
                                <div style="width: 22%;float: left;border: 1px solid #BFC5CD;">
                                    <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
                                        Drop-off Option
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
                                }
                            }
                            ?>
                            <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;">
                    <?php
                    $date_asap  = ($entered_needed_sets[0]['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_needed_sets[0]['shipp_time'] : '';
                    ?>
                    <span style="font-weight: bold;">When Needed: </span><?php echo $entered_needed_sets[0]['shipp_date'].$date_asap; ?>            
                </div>        
                <?php
                if ($entered_needed_sets[0]['delivery_type'] != '0') {
                    ?>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Send Via: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <?php
                        if ($entered_needed_sets[0]['delivery_type'] == '1') {
                            $delivery_type = 'Next Day Air';
                        } elseif ($entered_needed_sets[0]['delivery_type'] == '2') {
                            $delivery_type = 'Two Day Air';
                        } elseif ($entered_needed_sets[0]['delivery_type'] == '3') {
                            $delivery_type = 'Three Day Air';
                        } elseif ($entered_needed_sets[0]['delivery_type'] == '4') {
                            $delivery_type = 'Ground';
                        }

                        $ship_type_1 = ($entered_needed_sets[0]['shipp_comp_1'] == '0') ? '' : $entered_needed_sets[0]['shipp_comp_1'];
                        $ship_type_2 = ($entered_needed_sets[0]['shipp_comp_2'] == '0') ? '' : $entered_needed_sets[0]['shipp_comp_2'];
                        $ship_type_3 = ($entered_needed_sets[0]['shipp_comp_3'] == '0') ? '' : $entered_needed_sets[0]['shipp_comp_3'];

                        echo $ship_type_1 . $ship_type_2 . $ship_type_3 . ',&nbsp;' . $delivery_type . ',&nbsp;Account # ' . $entered_needed_sets[0]['billing_number'];
                        ?>
                    </div>
                <?php } else { ?>                            
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Send Via: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        SOHO TO ARRANGE DELIVERY
                    </div>    
                <?php }if($entered_needed_sets[0]['spl_inc'] != ''){ ?>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Special Instructions: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <?php echo $entered_needed_sets[0]['spl_inc']; ?>
                    </div>
                        <?php } ?>
                        </div>
                        </div>
                    </div>
    <?php
    }
    
}elseif ($_POST['everything_return'] == 'OPTION_3') {
    $current_option = CurrentOption($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $rem_avl_options = AvlOptionsRemaining($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $cust_original_order    = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid'], $_SESSION['ref_val']);
    
    
    $shipp_id   =       str_replace("P", "", $_POST['shipp_id']);
    $cust_add   =       AddressBookPickupSohoCap($shipp_id);                    
    
    ?>    
    <input type="hidden" name="tot_avl_options" id="tot_avl_options" value="<?php echo count($number_of_sets); ?>" />
    <input type="hidden" name="rem_avl_options" id="rem_avl_options" value="<?php echo count($rem_avl_options); ?>" />
    <input type="hidden" name="delivery_type_option" id="delivery_type_option" value="1" />
        <div style="border: 1px #F99B3E solid;margin-bottom: 20px;padding-bottom: 20px;width: 100%;float: left;">
            <div style="width: 100%;float: left;margin-top: 10px;">
                <div style="float: right;width: 20%;font-weight: bold;cursor: pointer;" title="Update Recipient" alt="Update Recipient" onclick="return update_recipient_dynamic_option_3('<?php echo $edit_id; ?>');"><span style="background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;background: #009C58;">Update</span></div>
                <div style="float: left;width: 100%;margin-left: 25px;font-weight: bold;"><span style="text-transform: uppercase;font-weight: bold;">WILL PICKUP FROM SOHO REPRO - 
                        <select style="width: 20% !important;" id="pickup_soho_add" name="pickup_soho_add" onchange="return pickup_soho();">
                            <option value="1" <?php if($shipp_id == '1'){ ?> selected="selected" <?php } ?>>381 Broome St</option>
                            <option value="2" <?php if($shipp_id == '2'){ ?> selected="selected" <?php } ?>>307 7th Ave, 5th Floor</option>
                        </select>
                    </span></div>
                <?php
                $user_id_add_set = $_SESSION['sohorepro_userid'];
                $company_id_view_plot = $_SESSION['sohorepro_companyid'];
                ?>
                <!-- Address Show End -->
                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    <?php
                        $number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid']);
                        
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
                            /*
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
                                
                                if (($entered['spl_instruction'] != '') OR  ($entered['size'] == 'Custom') OR ($entered['output'] == 'Both')){
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
                        }if ($entered['plot_arch'] == '0') {
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
                        }
                        ?>
                    </div>
                    <?php
                                }
                                $i++;
                            }
                            */
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
                <?php
                $entered_option_1 = NeededSets($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid']);                
                $all_days_off = AllDayOff();
                foreach ($all_days_off as $days_off_split) {
                    $all_days_in[] = $days_off_split['date'];
                }
                $all_date = implode(",", $all_days_in);
                $all_date_exist = str_replace("/", "-", $all_date);
                ?>
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
                            <input class="picker_icon" value="<?php echo $entered_option_1[0]['shipp_date']; ?>" type="text" name="date_needed" id="date_needed" style="width: 75px;" onclick="return date_reveal_return();" />
                            <input id="time_picker_icon" value="<?php echo $entered_option_1[0]['shipp_time']; ?>" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time_return();" />
                        </div>

                    </div>
                </div>
                <div style="font-weight: bold;width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    Special Instructions:            
                </div>        
                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    <textarea name="spl_recipient" id="spl_recipient" rows="3" cols="18" style="width: 200px;height: 40px;"><?php echo $entered_option_1[0]['spl_inc']; ?></textarea>
                </div>

            </div>
        </div> 
    
<?php
}elseif ($_POST['everything_return'] == 'OPTION_3_UPDATE') {
    
    $pickup_soho_add                = 'P'.$_POST['pickup_soho_add'];
    $date_needed                    = $_POST['date_needed'];
    $time_picker_icon               = $_POST['time_picker_icon'];
    $spl_recipient                  = $_POST['spl_recipient'];
    
    $user_id_add_set                = $_SESSION['sohorepro_userid'];
    $company_id_view_plot           = $_SESSION['sohorepro_companyid'];
    
    $query = "UPDATE sohorepro_sets_needed
			SET     shipp_id        = '" . $pickup_soho_add . "',
                                shipp_date      = '" . $date_needed . "',
                                shipp_time      = '" . $time_picker_icon . "',  
                                spl_inc         = '" . $spl_recipient . "' WHERE comp_id = '".$company_id_view_plot."' AND usr_id = '".$user_id_add_set."' AND delivery_type_option = '3' AND order_id = '0' ";

    $sql_result = mysql_query($query);
    if($sql_result){
    $entered_needed_sets        = NeededSets($company_id_view_plot, $user_id_add_set);
    $cust_add                   = AddressBookPickupSohoCap($entered_needed_sets[0]['shipp_id']);
    ?>
    <div style="float: left;" class="shaddows">
                            <div class="ribbon" id="ribbon_final"><span>RECIPIENT</span></div>
                        <div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;">                            
                            <div style="float: right;">
                                <span title="Edit Recipient" alt="Edit Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;font-weight: bold;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;margin-right: 15px;" onclick="return edit_recipient_option_3('<?php echo $entered_needed_sets[0]['shipp_id']; ?>');">Edit</span>                               
                            </div>
                            
                            <div style="float:left;width: 100%;text-align: center;font-weight: bold;">
                                WILL PICKUP FROM SOHO REPRO - <?php echo $cust_add[0]['caption']; ?>
                            </div>
                            
                            <div class="details_div">
                    
                <!-- Customer Details Start -->
                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">Pickup By: </div>
                
                <div style="float: left;width: 33%;margin-left: 30px;">  
                    <?php
                    
                    //$cust_add_2 = ($cust_add[0]['comp_business_address2'] != '') ? $cust_add[0]['comp_business_address2']. '<br>'  : '';                    
                    echo $cust_add[0]['address'];
                    ?>                   
                </div>                
                <!-- Customer Details End -->                    
                                
                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST: </div>
                <div style="float: left;width: 92%;margin-left: 30px;margin-top: 5px;">
                    <?php
                    $cust_original_order    = EnteredPlotRecipients($company_id_view_plot, $user_id_add_set);
                    
                    //$cust_needed_originals  = $cust_original_order[0]['origininals'];
                    
                    //$cust_needed_sets       = ($cust_original_order[0]['print_ea'] != '0') ? $cust_original_order[0]['print_ea'] : $cust_original_order[0]['arch_needed'];
                    //$cust_order_type        = ($cust_original_order[0]['plot_arch'] == '0') ? 'Architectural Copies' : 'Plotting on Bond';
                    $option                 = ($cust_original_order[0]['plot_arch'] == '0') ? 'Pickup Options:' : 'File Options:';  
                    ?>
                    <table border="1" style="width: 100%;">
                        <tr bgcolor="#BFC5CD">
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
//                        echo '<pre>';
//                        print_r($cust_original_order);
//                        echo '</pre>';
                        
                        foreach ($cust_original_order as $original){                            
                            $cust_needed_sets       = ($original['print_ea'] != '0') ? $original['print_ea'] : $original['arch_needed'];
                            $cust_order_type        = ($original['plot_arch'] == '0') ? 'Architectural Copies' : 'Plotting on Bond';                               
                            $size         = ($original['size'] == 'undefined') ? $original['arch_size'] : $original['size'];
                            $output       = ($original['output'] == 'undefined') ? $original['arch_output'] : $original['output'];
                            $media        = ($original['media'] == 'undefined') ? $original['arch_media'] : $original['media'];
                            $binding      = ($original['binding'] == 'undefined') ? $original['arch_binding'] : $original['binding'];
                            $folding      = ($original['folding'] == 'undefined') ? $original['arch_folding'] : $original['folding'];                            
                        ?>
                        <tr bgcolor="#F8F8F8">
                            <td><?php echo $original['options']; ?></td>
                            <td><?php echo $original['origininals']; ?></td>
                            <td><?php echo $cust_needed_sets; ?></td>
                            <td><?php echo $cust_order_type; ?></td>                            
                            <td><?php echo $size; ?></td>
                            <td style="text-transform: uppercase;"><?php echo $output; ?></td>
                            <td><?php echo $media; ?></td>
                            <td><?php echo ucfirst($binding); ?></td>
                            <td><?php echo ucfirst($folding); ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                   
                </div>
                
                
                <?php
                            //$enteredPlot = EnteredPlotRecipients($company_id_view_plot, $user_id_add_set);
                            $enteredPlot = EnteredPlotRecipientsMulti($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid'], $_SESSION['ref_val']);
                            $i = 1;
                            /*
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
                                
                                if (($entered['spl_instruction'] != '') OR  ($entered['size'] == 'Custom') OR ($entered['output'] == 'Both')){
                                ?>
                                
                    <div style="float:left;width: 95%;font-weight: bold;color: #000;margin-top: 7px;margin-left: 30px;"> OPTION <?php echo $entered['options']; ?></div>
                    <div style="width: 90%;float: left;border: 1px solid #BFC5CD;padding: 5px;margin-left: 30px;">   
                        <?php
                        if ($entered['size'] == 'Custom') {
                            ?>
                            <div style="width: 22%;float: left;border: 1px solid #BFC5CD;margin-right: 10px;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
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
                            <div style="width: 22%;float: left;border: 1px solid #BFC5CD;margin-right: 10px;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
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
                            <div style="width: 22%;float: left;border: 1px solid #BFC5CD;margin-right: 10px;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
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
                                $pickup_option = ($entered['pick_up'] == "ASAP") ? $entered['pick_up'] : $entered['pick_up'] . ' ' . $entered['pick_up_time'];
                                ?>
                                <div style="width: 22%;float: left;border: 1px solid #BFC5CD;">
                                    <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
                                        Schedule a Pickup
                                    </div>
                                    <div style="padding-top: 3px;width: 100%;float: left;">
                                        <input type="hidden" name="pick_up_time" id="pick_up_time" value="<?php echo $entered['pick_up_time']; ?>" />
                                        <?php echo $pickup_option; ?>
                                    </div>
                                </div>
                            <?php }if ($entered['drop_off'] != '0') { ?>
                                <div style="width: 22%;float: left;border: 1px solid #BFC5CD;">
                                    <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
                                        Drop-off Option
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
                                }
                            }
                            */
                            ?>
                            <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;">
                    <?php
                    $date_asap  = ($entered_needed_sets[0]['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_needed_sets[0]['shipp_time'] : '';
                    ?>
                    <span style="font-weight: bold;">When Needed: </span><?php echo $entered_needed_sets[0]['shipp_date'].$date_asap; ?>            
                </div>        
                <?php if($entered_needed_sets[0]['spl_inc'] != ''){ ?>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Special Instructions: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <?php echo $entered_needed_sets[0]['spl_inc']; ?>
                    </div>
                <?php } ?>
                        </div>
                        </div>
                    </div>
    <?php
    }
    
}elseif ($_POST['everything_return'] == 'OPTION_4') {
    $current_option = CurrentOption($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $rem_avl_options = AvlOptionsRemaining($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $option_4_id    = $_POST['option_4_id'];
    $recip_id       = $_POST['recip_id'];
    ?>    
    <input type="hidden" name="tot_avl_options" id="tot_avl_options" value="<?php echo count($number_of_sets); ?>" />
    <input type="hidden" name="rem_avl_options" id="rem_avl_options" value="<?php echo count($rem_avl_options); ?>" />
    <input type="hidden" name="recip_id" id="recip_id" value="<?php echo $recip_id; ?>" />
    <input type="hidden" name="delivery_type_option" id="delivery_type_option" value="1" />
        <div style="border: 0px #F99B3E solid;margin-bottom: 20px;padding-bottom: 20px;width: 100%;float: left;">
            <div style="width: 100%;float: left;margin-top: 10px;">
                <div style="float: right;width: 20%;font-weight: bold;cursor: pointer;" title="Update Recipient" alt="Update Recipient" onclick="return update_recipient_dynamic_option_4('<?php echo $option_4_id; ?>');"><span style="background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;background: #009C58;">Update</span></div>
                <div style="float: left;width: 100%;margin-left: 25px;font-weight: bold;"><span style="text-transform: uppercase;font-weight: bold;">Recipient <?php echo $recip_id; ?></span></div>
                <?php
                $user_id_add_set = $_SESSION['sohorepro_userid'];
                $company_id_view_plot = $_SESSION['sohorepro_companyid'];
                ?>
                <!-- Address Show End -->
                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    <?php
                        $number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid']);
                        $cust_original_order    = Options_4($option_4_id);
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
                                    $cust_needed_sets       = ($original['plot_needed'] != '0') ? $original['plot_needed'] : $original['arch_needed'];
                                    $cust_order_type        = ($original['plot_arch'] == '0') ? 'Architectural Copies' : 'Plotting on Bond';  
                                    $size         = ($original['size'] == 'undefined') ? $original['arch_size'] : $original['size'];
                                    $output       = ($original['output'] == 'undefined') ? $original['arch_output'] : $original['output'];
                                    $media        = ($original['media'] == 'undefined') ? $original['arch_media'] : $original['media'];
                                    $binding      = ($original['binding'] == 'undefined') ? $original['arch_binding'] : $original['binding'];
                                    $folding      = ($original['folding'] == 'undefined') ? $original['arch_folding'] : $original['folding'];    
                                    $option_dtls  = CheckOptionIdwithRec($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid'], $original['option_id'])
                                ?>
                                <tr bgcolor="#ffeee1">
                                    <td><?php echo $original['option_id']; ?></td>
                                    <td><?php echo $option_dtls[0]['origininals']; ?></td>
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
                                
                                if (($entered['spl_instruction'] != '') OR  ($entered['size'] == 'Custom') OR ($entered['output'] == 'Both')){
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
                        }if ($entered['plot_arch'] == '0') {
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
                        }
                        ?>
                    </div>
                    <?php
                                }
                                $i++;
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
                <?php
                    $entered_option_1 = NeededSets_option_4($option_4_id);
//                    echo '<pre>';
//                    print_r($entered_option_1[0]);
//                    echo '</pre>';
                ?>
                <div style="float: left;width: 33%;margin-left: 25px;border: 1px #F99B3E solid;margin-top: 10px;font-weight: bold;padding:3px;">Send to: 
                    <?php 
                    $address_book = AddressBookCompanyService($_SESSION['sohorepro_companyid']);
                    ?>
                    <select  name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return show_address_option_2();">                    
                            <option value="<?php echo $address_book[0]['id']; ?>">Return Everything To My Office</option>
                            <option value="P1" <?php if($entered_option_1[0]['shipp_id'] == "P1"){ ?> selected="selected" <?php } ?>>Pickup @ 381 Broome St</option>
                            <option value="P2" <?php if($entered_option_1[0]['shipp_id'] == "P2"){ ?> selected="selected" <?php } ?>>Pickup @ 307 7th Ave, 5th Flr</option>
                            <option class="select-dash" disabled="disabled">-----------------------------------------</option>
                        <?php                        
                        foreach ($address_book as $address) {
                            ?>                                                                                        
                            <option value="<?php echo $address['id']; ?>" <?php if($entered_option_1[0]['shipp_id'] == $address['id']){ ?> selected="selected" <?php } ?>><?php echo $address['company_name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <!-- Address Show Start -->
                <?php if(($entered_option_1[0]['shipp_id'] != 'P1') || ($entered_option_1[0]['shipp_id'] != "P2")){
                    $address_book_2 = AddressBookCompanyService_option2($entered_option_1[0]['shipp_id']);
                    ?>
                <div id="show_address" style="float: left;width: 25%;height: 80px !important;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book_2[0]['address_1']; ?></div>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book_2[0]['address_2']; ?></div>
                    <?php if($address_book[0]['address_3'] != ''){?>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book_2[0]['address_3']; ?></div>
                    <?php } ?>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book_2[0]['city'].',&nbsp;'.StateName($address_book[0]['state']).'&nbsp;'.$address_book[0]['zip']; ?></div>
                    <div style="float: left;width: 90%;font-weight: bold;"><?php echo $address_book_2[0]['phone']; ?></div>
                    <?php
                    //echo $address_book[0]['address_1'] . ', ' . $address_book[0]['address_2'] . ', ' . $address_book[0]['city'] . ', ' . StateName($address_book[0]['state']) . ' ' . $address_book[0]['zip'];
                    ?>
                </div>
                <?php  }  else {                      
                $pic_address = AddressBookPickupSohoCap($entered_option_1[0]['shipp_id']);
                ?>
                    <div id="show_address" style="float: left;width: 25%;height: 80px !important;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">
                    <?php
                    echo $pic_address[0]['address'];
                    ?>
                </div>  
                <?php
                } ?>

                <div style="float: left;width: 100%;margin-top: 5px;">   
                    <div style="float: left;width: 38%;">
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
                                    <input type="text" name="shipp_att" id="shipp_att" value="<?php echo $entered_option_1[0]['attention_to']; ?>" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                                    <input type="text" name="contact_ph" id="contact_ph" onfocus="return contact_phone();"  value="<?php echo $entered_option_1[0]['contact_ph']; ?>" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Contact Phone End -->
                </div>
                <?php
                $all_days_off = AllDayOff();
                foreach ($all_days_off as $days_off_split) {
                    $all_days_in[] = $days_off_split['date'];
                }
                $all_date = implode(",", $all_days_in);
                $all_date_exist = str_replace("/", "-", $all_date);
                ?>
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
                            <input class="picker_icon" value="<?php echo $entered_option_1[0]['shipp_date']; ?>" type="text" name="date_needed" id="date_needed" style="width: 75px;" onclick="return date_reveal_return();" />
                            <input id="time_picker_icon" value="<?php echo $entered_option_1[0]['shipp_time']; ?>" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time_return();" />
                        </div>

                    </div>
                </div>
                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                    <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">
                        <?php
            $checked        = ($entered_option_1[0]['delivery_type'] != '0') ? '' : 'checked';
            $checked_use    = ($entered_option_1[0]['delivery_type'] == '0') ? '' : 'checked';
            $checked_use_dis = ($entered_option_1[0]['delivery_type'] != '0') ? '' : 'display: none;';
            $display        = ($entered_option_1[0]['delivery_type'] != '0') ? '' : 'display: none;';
            $shipp_comp_1   = ($entered_option_1[0]['shipp_comp_1'] != '0') ? 'checked' : '';
            $shipp_comp_2   = ($entered_option_1[0]['shipp_comp_2'] != '0') ? 'checked' : '';
            $shipp_comp_3   = ($entered_option_1[0]['shipp_comp_3'] != '0') ? 'checked' : '';
            $bill_val       = ($entered_option_1[0]['billing_number'] != '0') ? $entered_option_1[0]['billing_number'] : '';
            ?>
                        <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 200px;">
                        <input type="checkbox" name="arrange_del" id="arrange_del" <?php echo $checked; ?> style="width: 10% !important;margin-bottom: 0px;" onclick="uncheck_delivery();" /><span style="text-transform: uppercase;">Soho to arrange delivery</span>
                    </div>              

                    </div>
                    <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                        <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;float: left;">
                            <input type="checkbox" name="preffer_del" <?php echo $checked_use; ?> id="preffer_del" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="check_prefer_delivery();" /><span style="text-transform: uppercase;">Use My Carrier</span>
                        </div>

                        <div id="preffered_info" style="width: 91%;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;<?php echo $checked_use_dis; ?>">
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery:  </span>
                                    <select  name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address_();">                    
                                        <option value="1" <?php if ($entered_option_1[0]['delivery_type'] == '1') { ?> selected="selected" <?php } ?>>Next Day Air</option> 
                                        <option value="2" <?php if ($entered_option_1[0]['delivery_type'] == '2') { ?> selected="selected" <?php } ?>>Two Day Air</option>
                                        <option value="3" <?php if ($entered_option_1[0]['delivery_type'] == '3') { ?> selected="selected" <?php } ?>>Three Day Air</option>
                                        <option value="4" <?php if ($entered_option_1[0]['delivery_type'] == '4') { ?> selected="selected" <?php } ?>>Ground</option>
                                    </select>
                                </li>                    
                                <li>
                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1" onclick="return field_color();" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx"  <?php echo $shipp_comp_1; ?> /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2" onclick="return field_color();" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" <?php echo $shipp_comp_2; ?> /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3" onclick="return field_color();" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" <?php echo $shipp_comp_3; ?> /><input type="text" name="other_shipp_type" placeholder="Other" id="other_shipp_type" value="<?php echo ($entered_option_1[0]['shipp_comp_3'] != '0') ? $entered_option_1[0]['shipp_comp_3'] : ''; ?>" onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number" value="<?php echo $bill_val; ?>" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>


                <div style="font-weight: bold;width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    Special Instructions:            
                </div>        
                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    <textarea name="spl_recipient" id="spl_recipient" rows="3" cols="18" style="width: 200px;height: 40px;"><?php echo $entered_option_1[0]['spl_inc']; ?></textarea>
                </div>

            </div>
        </div> 
    
<?php
}elseif ($_POST['everything_return'] == 'OPTION_4_UPDATE') {
    $shipping_id_rec                = $_POST['shipping_id_rec'];
    $user_session                   = $_SESSION['sohorepro_userid'];
    $user_session_comp              = $_SESSION['sohorepro_companyid'];
    $date_needed                    = $_POST['date_needed'];
    $time_needed                    = $_POST['time_needed'];
    $spl_recipient                  = $_POST['spl_recipient'];
    
    $delivery_type                  = $_POST['delivery_type'];
    $bill_number                    = $_POST['bill_number'];
    $shipp_comp_1_f                 = $_POST['shipp_comp_1_f'];
    $shipp_comp_2_f                 = $_POST['shipp_comp_2_f'];
    $shipp_comp_3_f                 = $_POST['shipp_comp_3_f'];

    $attention_to                   = $_POST['attention_to'];
    
    $user_id_add_set                = $_SESSION['sohorepro_userid'];
    $company_id_view_plot           = $_SESSION['sohorepro_companyid'];
    $rec_id                         = $_POST['rec_id'];
    $recip_id                       = $_POST['recip_id'];
    
    $query = "UPDATE sohorepro_sets_needed
			SET     shipp_id        = '" . $shipping_id_rec . "',
                                attention_to    = '" . $attention_to . "',   
                                shipp_date      = '" . $date_needed . "',
                                shipp_time      = '" . $time_needed . "',  
                                spl_inc         = '" . $spl_recipient . "',
                                delivery_type   = '" . $delivery_type . "',
                                billing_number  = '" . $bill_number . "',
                                shipp_comp_1    = '" . $shipp_comp_1_f . "',
                                shipp_comp_2    = '" . $shipp_comp_2_f . "',
                                shipp_comp_3    = '" . $shipp_comp_3_f . "'  WHERE comp_id = '".$company_id_view_plot."' AND usr_id = '".$user_id_add_set."' AND id = '".$rec_id."' AND order_id = '0' ";

    $sql_result = mysql_query($query);
    if($sql_result){
        $entered_needed_sets     = NeededSets($user_session_comp, $user_session);
    ?>
        <div style="float: left;" id="option_4_<?php echo $rec_id; ?>">
                            <div class="ribbon" id="ribbon_final"><span>RECIPIENT <?php echo $recip_id; ?></span></div>
                        <div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;">                            
                            <div style="float: right;">
                                <span title="Edit Recipient" alt="Edit Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;font-weight: bold;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;margin-right: 15px;" onclick="return edit_recipient_option_4('<?php echo $rec_id; ?>', '<?php echo $recip_id; ?>');">Edit</span>                               
                            </div>
                            
<!--                            <div style="float:left;width: 100%;text-align: center;font-weight: bold;">
                                SEND EVERYTHING TO
                            </div>-->
                            
                            <div class="details_div">
                    
                <!-- Customer Details Start -->
                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">Send to: </div>
                
                <div style="float: left;width: 33%;margin-left: 30px;">  
                    <?php 
                    if(($entered_needed_sets[0]['shipp_id'] != 'P1') && ($entered_needed_sets[0]['shipp_id'] != "P2")){
                    $cust_add = AddressBookCompanyService_option2($shipping_id_rec);        
                    $cust_add_2 = ($cust_add[0]['address_2'] != '') ? $cust_add[0]['address_2']. '<br>'  : '';    
                    $cust_add_3 = ($cust_add[0]['address_3'] != '') ? $cust_add[0]['address_3']. '<br>'  : '';   
                    echo $cust_add[0]['company_name'] . '<br>' .$cust_add[0]['address_1'] . '<br>' . $cust_add_2.$cust_add_2 . $cust_add[0]['city'] . '&nbsp;' . StateName($cust_add[0]['state']) . '&nbsp;' . $cust_add[0]['zip'].'<br>'.$cust_add[0]['phone'];
                    }else{
                    $pic_address = AddressBookPickupSohoCap($entered_needed_sets[0]['shipp_id']);
                    echo $pic_address[0]['address'];
                    }
                    ?>                   
                </div>                
                <!-- Customer Details End -->                    
                                
                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST: </div>
                <div style="float: left;width: 92%;margin-left: 30px;margin-top: 5px;">
                    <?php
                    //$cust_original_order    = EnteredPlotRecipients($user_session_comp, $user_session);
                    
                    $cust_original_order    = Options_4($rec_id);
                    
                    //$cust_needed_originals  = $cust_original_order[0]['origininals'];
                    
                    //$cust_needed_sets       = ($cust_original_order[0]['print_ea'] != '0') ? $cust_original_order[0]['print_ea'] : $cust_original_order[0]['arch_needed'];
                    //$cust_order_type        = ($cust_original_order[0]['plot_arch'] == '0') ? 'Architectural Copies' : 'Plotting on Bond';
                    $option                 = ($cust_original_order[0]['plot_arch'] == '0') ? 'Pickup Options:' : 'File Options:';  
                    ?>
                    <table border="1" style="width: 100%;">
                        <tr bgcolor="#BFC5CD">
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
//                        echo '<pre>';
//                        print_r($cust_original_order);
//                        echo '</pre>';
                        
                        foreach ($cust_original_order as $original){                            
                            $cust_needed_sets       = ($original['plot_needed'] != '0') ? $original['plot_needed'] : $original['arch_needed'];
                            $cust_order_type        = ($original['plot_arch'] == '0') ? 'Architectural Copies' : 'Plotting on Bond';                               
                            $size         = ($original['size'] == 'undefined') ? $original['arch_size'] : $original['size'];
                            $output       = ($original['output'] == 'undefined') ? $original['arch_output'] : $original['output'];
                            $media        = ($original['media'] == 'undefined') ? $original['arch_media'] : $original['media'];
                            $binding      = ($original['binding'] == 'undefined') ? $original['arch_binding'] : $original['binding'];
                            $folding      = ($original['folding'] == 'undefined') ? $original['arch_folding'] : $original['folding'];                            
                            $option_dtls  = CheckOptionIdwithRec($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid'], $original['option_id'])
                        ?>
                        <tr bgcolor="#F8F8F8">
                            <td><?php echo $original['option_id']; ?></td>
                            <td><?php echo $option_dtls[0]['origininals']; ?></td>
                            <td><?php echo $cust_needed_sets; ?></td>
                            <td><?php echo $cust_order_type; ?></td>                            
                            <td><?php echo $size; ?></td>
                            <td style="text-transform: uppercase;"><?php echo $output; ?></td>
                            <td><?php echo $media; ?></td>
                            <td><?php echo ucfirst($binding); ?></td>
                            <td><?php echo ucfirst($folding); ?></td>
                        </tr>
                        <?php
                        }
                        ?>
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
                                
                                if (($entered['spl_instruction'] != '') OR  ($entered['size'] == 'Custom') OR ($entered['output'] == 'Both')){
                                ?>
                                
                    <div style="float:left;width: 95%;font-weight: bold;color: #000;margin-top: 7px;margin-left: 30px;"> OPTION <?php echo $entered['options']; ?></div>
                    <div style="width: 90%;float: left;border: 1px solid #BFC5CD;padding: 5px;margin-left: 30px;">   
                        <?php
                        if ($entered['size'] == 'Custom') {
                            ?>
                            <div style="width: 22%;float: left;border: 1px solid #BFC5CD;margin-right: 10px;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
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
                            <div style="width: 22%;float: left;border: 1px solid #BFC5CD;margin-right: 10px;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
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
                            <div style="width: 22%;float: left;border: 1px solid #BFC5CD;margin-right: 10px;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
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
                                $pickup_option = ($entered['pick_up'] == "ASAP") ? $entered['pick_up'] : $entered['pick_up'] . ' ' . $entered['pick_up_time'];
                                ?>
                                <div style="width: 22%;float: left;border: 1px solid #BFC5CD;">
                                    <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
                                        Schedule a Pickup
                                    </div>
                                    <div style="padding-top: 3px;width: 100%;float: left;">
                                        <input type="hidden" name="pick_up_time" id="pick_up_time" value="<?php echo $entered['pick_up_time']; ?>" />
                                        <?php echo $pickup_option; ?>
                                    </div>
                                </div>
                            <?php }if ($entered['drop_off'] != '0') { ?>
                                <div style="width: 22%;float: left;border: 1px solid #BFC5CD;">
                                    <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #BFC5CD;color: #5C5C5C;text-align: center;">
                                        Drop-off Option
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
                                }
                            }
                            ?>
                            <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;">
                    <?php
                    $date_asap  = ($entered_needed_sets[0]['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_needed_sets[0]['shipp_time'] : '';
                    ?>
                    <span style="font-weight: bold;">When Needed: </span><?php echo $entered_needed_sets[0]['shipp_date'].$date_asap; ?>            
                </div>        
                <?php
                if ($entered_needed_sets[0]['delivery_type'] != '0') {
                    ?>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Send Via: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <?php
                        if ($entered_needed_sets[0]['delivery_type'] == '1') {
                            $delivery_type = 'Next Day Air';
                        } elseif ($entered_needed_sets[0]['delivery_type'] == '2') {
                            $delivery_type = 'Two Day Air';
                        } elseif ($entered_needed_sets[0]['delivery_type'] == '3') {
                            $delivery_type = 'Three Day Air';
                        } elseif ($entered_needed_sets[0]['delivery_type'] == '4') {
                            $delivery_type = 'Ground';
                        }

                        $ship_type_1 = ($entered_needed_sets[0]['shipp_comp_1'] == '0') ? '' : $entered_needed_sets[0]['shipp_comp_1'];
                        $ship_type_2 = ($entered_needed_sets[0]['shipp_comp_2'] == '0') ? '' : $entered_needed_sets[0]['shipp_comp_2'];
                        $ship_type_3 = ($entered_needed_sets[0]['shipp_comp_3'] == '0') ? '' : $entered_needed_sets[0]['shipp_comp_3'];

                        echo $ship_type_1 . $ship_type_2 . $ship_type_3 . ',&nbsp;' . $delivery_type . ',&nbsp;Account # ' . $entered_needed_sets[0]['billing_number'];
                        ?>
                    </div>
                <?php } else { ?>                            
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Send Via: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        SOHO TO ARRANGE DELIVERY
                    </div>    
                <?php }if($entered_needed_sets[0]['spl_inc'] != ''){ ?>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <span style="font-weight: bold;">Special Instructions: </span>
                    </div>
                    <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                        <?php echo $entered_needed_sets[0]['spl_inc']; ?>
                    </div>
                        <?php } ?>
                        </div>
                        </div>
                    </div> 
    
    
    
<?php
}
}
?>
