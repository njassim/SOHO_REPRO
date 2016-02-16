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
    
    $user_session_comp  =   $_SESSION['sohorepro_companyid'];
    $user_session       =   $_SESSION['sohorepro_userid'];
    
    $entered_needed_sets = NeededSets($user_session_comp, $user_session);
    if(count($entered_needed_sets) > 0){ 
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
    }
    ?>

    <?php
    $current_option_all = CurrentOptionAll($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
//    $update_allset      =   "UPDATE sohorepro_plotting_set SET all_sets = '1' WHERE id = '".$current_option_all[0]['id']."'";
//    mysql_query($update_allset);
    $current_option     = CurrentOption($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $number_of_sets     = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $rem_avl_options    = AvlOptionsRemaining($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $remaining_sets     = RemainingSets($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $con_class = 1;
    foreach ($remaining_sets as $current_opt){
        $total_sets_5 = EnteredPlotttingPrimary195($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid'], $current_opt['id']);
    ?>
<div id="optiond_dynamic_<?php echo $current_opt['options']; ?>" style="width:100%;float: left;">
    <div style="width: 100%;float: left;border: 0px #F99B3E solid;margin-bottom: 5px;color: #FA8526;">            
        <div style="width: 15%;float: left;text-align: left;font-weight: bold;font-size: 15px;">OPTION <?php echo $current_opt['options']; ?></div>
        <div style="width: 48%;float: left;text-align: left;font-weight: bold;font-size: 15px;"><?php echo $current_opt['options'] . '&nbsp;of&nbsp;' . count($number_of_sets); ?></div>
    </div>
    <input type="hidden" name="tot_avl_options" id="tot_avl_options" value="<?php echo count($number_of_sets); ?>" />
    <input type="hidden" name="rem_avl_options" id="rem_avl_options" value="<?php echo count($rem_avl_options); ?>" />
    <div style="border: 1px #F99B3E solid;margin-bottom: 20px;padding-bottom: 20px;width: 100%;float: left;">
        <div style="width: 100%;float: left;margin-top: 10px;">
            <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo '1'//$total_sets_5; ?></div>
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
                        $enteredPlot = EnteredPlotRecipientsCurrentOption($current_opt['id']);
//                        echo '<pre>';
//                        print_r($enteredPlot);
//                        echo '</pre>';
                        $i = 1;
                        foreach ($enteredPlot as $entered) {
                            $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                            $binding = $entered['binding'];
                            $folding = $entered['folding'];
                            $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Architectural Copies';
                            $type = ($entered['plot_arch'] == '1') ? '1' : '0';
                            $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1') : EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                            $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']) : ArchSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']);
                            $plot_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1');
                            $copy_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');

                            if ($entered['plot_arch'] == '1') {
                                ?>
                                <input type="hidden" id="option_id_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['options']; ?>" />
                                <input type="hidden" id="option_type_<?php echo $current_opt['options']; ?>" value="<?php echo $type; ?>" />
                                <tr bgcolor="#ffeee1">
                                    <td>Plotting on Bond</td>
                                    <td><?php echo $entered['origininals']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_<?php echo $current_opt['options']; ?>" class="avl_sets"  value="<?php echo ($entered['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1', '<?php echo $current_opt['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>', '<?php echo $current_opt['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_<?php echo $current_opt['options']; ?>" class="need_sets" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_dy('<?php echo $current_opt['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_dy('<?php echo $current_opt['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['size']; ?>" /></td>
                                    <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['output']; ?>" /></td>
                                    <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['media']; ?>" /></td>
                                    <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $binding; ?>" /></td>
                                    <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $folding; ?>" /></td>
                                </tr>
                                <?php
                            }
                            ?>

                            <?php
                            if ($entered['plot_arch'] == '0') {
                                ?>
                                <input type="hidden" id="option_id_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['options']; ?>" />
                                <input type="hidden" id="option_type_<?php echo $current_opt['options']; ?>" value="<?php echo $type; ?>" />
                                <tr bgcolor="#ffeee1">
                                    <td>Architectural Copies</td>
                                    <td><?php echo $available_order[0]['origininals']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_<?php echo $current_opt['options']; ?>" class="avl_sets"  value="<?php echo ($entered['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1', '<?php echo $current_opt['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>', '<?php echo $current_opt['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_<?php echo $current_opt['options']; ?>" class="need_sets" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_dy('<?php echo $current_opt['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_dy('<?php echo $current_opt['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['size']; ?>" /></td>
                                    <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['output']; ?>" /></td>
                                    <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['media']; ?>" /></td>
                                    <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $binding; ?>" /></td>
                                    <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $folding; ?>" /></td>
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
                    }//if ($entered['plot_arch'] == '0') {
                        if ($entered['pick_up_time'] != '0') {
                            if($entered['pick_up_time'] != 'undefined'){
                            ?>
                            <div style="width: 22%;float: left;border: 1px solid #F99B3E;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                    Schedule a Pickup
                                </div>
                                <div style="padding-top: 3px;width: 100%;float: left;">
                                    <input type="hidden" name="pick_up_time" id="pick_up_time" value="<?php echo $entered['pick_up_time']; ?>" />
                            <?php 
                            if($entered['pick_up_time'] == 'ASAP'){
                            echo $entered['pick_up']; 
                            }else{
                            echo $entered['pick_up'] . ' ' . $entered['pick_up_time'];     
                            }
                            ?>
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
    <?php } }
               // } ?>
                </div>
<!--                <div id="edit_address_<?php echo $current_opt['options']; ?>" style="width:98%;float: left;text-align: right;display: none;">
                    <span style="background: #007F2A;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;cursor: pointer;" onclick="return edit_recipient_address('<?php echo $current_opt['options']; ?>');">EDIT</span>
                </div>-->
                <?php
                $all_days_off = AllDayOff();
                foreach ($all_days_off as $days_off_split) {
                    $all_days_in[] = $days_off_split['date'];
                }
                $all_date = implode(",", $all_days_in);
                $all_date_exist = str_replace("/", "-", $all_date);
                ?>

            </div>
            
            <div style="float: left;width: 33%;margin-left: 30px;border: 1px #F99B3E solid;margin-top: 17px;font-weight: bold;padding:3px;">Send to: 
                    <?php 
                    $address_book = AddressBookCompanyService($_SESSION['sohorepro_companyid']);
                    
                    ?>
                <select  name="address_book_rp" id="address_book_rp_<?php echo $current_opt['options']; ?>" style="width: 75% !important;" onclick="return add_prvious('<?php echo ($current_opt['options'] - 1); ?>');" onchange="return show_address_dynamic_nmjk('<?php echo $current_opt['options']; ?>');">
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
                        <option value="NEW-MULTI" style="font-weight: bold;background-color: #CCC;"><span style="font-weight: bold;">Add New Address</span></option>
                </select>
            </div>
            <!-- Address Show Start -->
            <div id="show_address_<?php echo $current_opt['options']; ?>" style="float: left;width: 40%;height: 80px !important;padding: 6px;border: 0px #F99B3E solid;margin-top: 10px;font-weight: bold;">
                
                
                
            
            </div>

            <div id="jumbalakka_nmj_<?php echo $current_opt['options']; ?>" style="float: left;width: 100%;margin-top: 25px;">   
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
                                <input type="text" name="shipp_att" id="shipp_att_<?php echo $current_opt['options']; ?>" value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                                <input type="text" name="contact_ph" id="contact_ph_<?php echo $current_opt['options']; ?>" onfocus="return contact_phone_dynamic('<?php echo $current_opt['options']; ?>');"  value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                        <span id="asap_status_<?php echo $current_opt['options']; ?>" class="asap_orange" onclick="return asap_dynamic('<?php echo $current_opt['options']; ?>');">ASAP</span> 
                    </div>

                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                        <input class="picker_icon" value="" type="text" name="date_needed" id="date_needed_<?php echo $current_opt['options']; ?>" style="width: 75px;" onclick="return date_reveal('<?php echo $current_opt['options']; ?>');" onchange="return update_current_option_jk('<?php echo $current_opt['options']; ?>');" />
                        <input id="time_picker_icon_<?php echo $current_opt['options']; ?>" value="" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time('<?php echo $current_opt['options']; ?>');" />
                    </div>

                </div>
            </div>
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;margin-right: 10px;float: left;">
                        <input type="checkbox" name="arrange_del" id="arrange_del_<?php echo $current_opt['options']; ?>" checked style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="uncheck_delivery_dynamic('<?php echo $current_opt['options']; ?>');" /><span style="text-transform: uppercase;">Soho to arrange delivery</span>
                    </div>

                </div>
                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;float: left;">
                        <input type="checkbox" name="preffer_del" id="preffer_del_<?php echo $current_opt['options']; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="check_prefer_delivery_dynamic('<?php echo $current_opt['options']; ?>');" /><span style="text-transform: uppercase;">Use My Carrier</span>
                    </div>

                    <div id="preffered_info_<?php echo $current_opt['options']; ?>" style="width: 91%;display: none;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;">
                        <ul>                                       
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery:  </span>
                                    <select  name="delivery_comp_<?php echo $current_opt['options']; ?>" id="delivery_comp_<?php echo $current_opt['options']; ?>" style="width: 45% !important;" onchange="return show_address_();">                    
                                        <option value="1">Next Day Air</option>
                                        <option value="2">Two Day Air</option>
                                        <option value="3">Three Day Air</option>
                                        <option value="4">Ground</option>
                                    </select>
                                </li>                    
                                <li id="shipp_collection">
                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1_<?php echo $current_opt['options']; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" onclick="return field_color_dynamic('<?php echo $current_opt['options']; ?>');" /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2_<?php echo $current_opt['options']; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" onclick="return field_color_dynamic('<?php echo $current_opt['options']; ?>');" /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3_<?php echo $current_opt['options']; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" onclick="return field_color_dynamic('<?php echo $current_opt['options']; ?>');" /><input type="text" placeholder="Other" name="other_shipp_type" id="other_shipp_type_<?php echo $current_opt['options']; ?>"  onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number_<?php echo $current_opt['options']; ?>" style="width: 50% !important;margin-bottom: 0px !important;" onkeyup="return update_current_option('<?php echo $current_opt['options']; ?>');"  />
                                </li>
                            </ul>
                            <!--<li>
                                    <span style="font-weight: bold;">Account #  :</span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>-->
                        </ul>
                    </div>

                </div>
            </div>


            
            <div style="float: left;width:100%;margin-top: 10px;">
                <div style="font-weight: bold;float: left;width:55%;margin-left: 25px;">
                    Special Instructions:  
                </div>
                <div style="float: left;width:40%;text-align: right;">
                    <div style="float:right;margin-right: 12px;">
                        <input id="add_recipients" value="Add Recipient" style="margin-left: 5px;float:left;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="button" onclick="return add_recipients_dynamic('<?php echo $current_opt['options']; ?>','<?php echo $current_opt['id']; ?>');"  />
                    </div>                    
                </div>                
            </div>
            
            
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                <textarea name="spl_recipient" id="spl_recipient_<?php echo $current_opt['options']; ?>" rows="3" cols="18" style="width: 200px;height: 40px;" onkeyup="return update_current_option('<?php echo $current_opt['options']; ?>');"></textarea>
            </div>

        </div>
    </div>
    </div>
    <div style="width:100%;float:left;">
        <hr style="border: 0;border-bottom: 3px dashed #ccc;background: #999;margin-bottom: 10px;">
    </div>
    <div style="width:100%;float: left;">         
        <div style="float:right;">            
            <input id="last_sc" class="<?php echo $con_class; ?>" value="Save and Continue" style="<?php if($con_class != count($number_of_sets)){ ?>display: none;<?php } ?>cursor: pointer;font-size: 12px; padding: 1.5px; width: 135px; margin-right: 14px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;margin-top: -0px !important;" type="button" onclick="return continue_recipient();" />
        </div>
    </div>
    
    <?php
    $con_class++;
    }
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
    $upload_file_exist      = UploadFileExistFinalize($user_session_comp, $user_session, $_SESSION['ref_val']);
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
                    <?php }                     
                    if(count($upload_file_exist) > 0){
                    ?>
                
                <div style="float: left;width: 100%;margin-left: 30px;margin-top: 7px;">
                    <span style="font-weight: bold;">Upload File:  </span>
                </div>
                <?php
                    foreach ($upload_file_exist as $files){    
                ?>                
                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                    <a href="http://cipldev.com/supply-new.sohorepro.com/uploads/<?php echo $files['file_name']; ?>" target="_blank"><?php echo $files['file_name']; ?></a>
                </div>
                    <?php }} ?>
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
    $current_option_all = CurrentOptionAll($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $update_allset      =   "UPDATE sohorepro_plotting_set SET all_sets = '1' WHERE id = '".$current_option_all[0]['id']."'";
    mysql_query($update_allset);
    $current_option = CurrentOption($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $number_of_sets = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $rem_avl_options = AvlOptionsRemaining($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $remaining_sets     = RemainingSetsAfter($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $con_class = 1;  
    $recipient_inc = $r;
    foreach ($remaining_sets as $all_sets){
        //$recipient_inc = ($all_sets['options'] != $con_class) ? $r.'J'  : $r;
    ?>
     <div style="width: 100%;float: left;border: 0px #F99B3E solid;margin-bottom: 5px;color: #FA8526;">            
        <div style="width: 48%;float: left;text-align: left;font-weight: bold;font-size: 15px;">OPTION <?php echo ($all_sets['options']); ?></div>
        <div style="width: 48%;float: left;text-align: right;font-weight: bold;font-size: 15px;"><?php echo ($all_sets['options']) . '&nbsp;of&nbsp;' . count($number_of_sets); ?></div>
    </div>
    <input type="hidden" name="tot_avl_options" id="tot_avl_options" value="<?php echo count($number_of_sets); ?>" />
    <input type="hidden" name="rem_avl_options" id="rem_avl_options" value="<?php echo count($rem_avl_options); ?>" />
    <div style="border: 1px #F99B3E solid;margin-bottom: 20px;padding-bottom: 20px;width: 100%;float: left;">
        <div style="width: 100%;float: left;margin-top: 10px;">
            <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo $recipient_inc; ?></div>
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
                        $enteredPlot = EnteredPlotRecipientsCurrentOption($all_sets['id']);
//                        echo '<pre>';
//                        print_r($enteredPlot);
//                        echo '</pre>';
                        $i = 1;
                        foreach ($enteredPlot as $entered) {
                            $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                            $binding = $entered['binding'];
                            $folding = $entered['folding'];
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
                                    <td><?php echo $entered['origininals']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_1" class="avl_sets"  value="<?php echo ($entered['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
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
                                    Drop-off Option
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


            <div style="float: left;width:100%;margin-top: 10px;">
                <div style="font-weight: bold;float: left;width:55%;margin-left: 25px;">
                    Special Instructions:  
                </div>
                <div style="float: left;width:40%;text-align: right;">
                    <div style="float:right;margin-right: 12px;">
                        <input id="add_recipients" value="Add Recipient" style="margin-left: 5px;float:left;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="button" onclick="return add_recipients();" />
                    </div>                    
                </div>                
            </div>
            
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                <textarea name="spl_recipient" id="spl_recipient" rows="3" cols="18" style="width: 200px;height: 40px;"></textarea>
            </div>

        </div>
        
    </div>
		<div style="width:100%;float: left;">             
            <div style="float:right;">            
                <input class="<?php echo $con_class; ?>" value="Continue" style="<?php if($con_class != count($remaining_sets)){ ?>display: none;<?php } ?>cursor: pointer;font-size: 12px; padding: 1.5px; width: 135px; margin-right: 14px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;margin-top: -0px !important;" type="button" onclick="return continue_recipient();" />
            </div>
        </div>
    <?php
    $con_class++;
    $recipient_inc++;
    }

}elseif($_POST['recipients'] == '31'){
    
    $shipping_id_rec_pre                = explode("_", $_POST['shipping_id_rec']);    
    $shipping_id_rec                    = ($shipping_id_rec_pre[0] == "PEVERY") ? $shipping_id_rec_pre[1] : $_POST['shipping_id_rec'];
    $user_session                       = $_POST['user_session'];
    $user_session_comp                  = $_POST['user_session_comp'];
    $date_needed                        = ($_POST['date_needed'] == '') ? 'ASAP' : $_POST['date_needed'];
    $time_needed                        = ($_POST['time_needed'] == '') ? 'ASAP' : $_POST['time_needed']; 
    $spl_recipient                      = $_POST['spl_recipient'];

    $option_type                        =	$_POST['option_type'];
	
    $avl_sets_1                         = $_POST['avl_sets_1'];
    $need_sets_1                        = ($option_type == '1') ? $_POST['need_sets_1'] : '0';
	
    $size_sets_1                        = $_POST['size_sets_1'];
    $output_sets_1                      = $_POST['output_sets_1'];
    $media_sets_1                       = $_POST['media_sets_1'];
    $binding_sets_1                     = $_POST['binding_sets_1'];
    $folding_sets_1                     = $_POST['folding_sets_1'];
	
	
	
    $avl_sets_2                         = $_POST['size_sets_2'];
    $need_sets_2                        = ($option_type == '0') ? $_POST['need_sets_1']: '0';
	
    $size_sets_2                        = $_POST['size_sets_2'];
    $output_sets_2                      = $_POST['output_sets_2'];
    $binding_sets_2                     = $_POST['binding_sets_2'];
    $folding_sets_2                     = $_POST['folding_sets_2'];

    $delivery_type                      = $_POST['delivery_type'];
    $bill_number                        = $_POST['bill_number'];
    $shipp_comp_1_f                     = $_POST['shipp_comp_1_f'];
    $shipp_comp_2_f                     = $_POST['shipp_comp_2_f'];
    $shipp_comp_3_f                     = $_POST['shipp_comp_3_f'];

    $size_custom_details                = $_POST['size_custom_details'];

    $output_page_details                = $_POST['output_page_details'];

    $attention_to                       = $_POST['attention_to'];

    $contact_ph                         = $_POST['contact_ph'];

    $option_id                          = $_POST['option_id'];
    
    $rand_id                            =   randomPassword();
    
    

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
                                shipp_comp_3    = '" . $shipp_comp_3_f . "',
                                rand_id         = '" . $rand_id . "' ";
    
    $check_if_exist =   CheckIfExist($user_session_comp, $user_session, $option_id, $_SESSION['random_id']);
    if(count($check_if_exist) == '0'){
    mysql_query($query);
    $last_insert_id         =   mysql_insert_id();
    $get_last_random_id     =   GetLastRandomId($last_insert_id);
    $_SESSION['random_id']  =   $get_last_random_id;
    }
    
}elseif($_POST['recipients'] == '40'){
    
    $shipping_id_rec_pre                = explode("_", $_POST['shipping_id_rec']);    
    $shipping_id_rec                    = ($shipping_id_rec_pre[0] == "PEVERY") ? $shipping_id_rec_pre[1] : $_POST['shipping_id_rec'];
    $user_session                       = $_POST['user_session'];
    $user_session_comp                  = $_POST['user_session_comp'];
    $date_needed                        = ($_POST['date_needed'] == '') ? 'ASAP' : $_POST['date_needed'];
    $time_needed                        = ($_POST['time_needed'] != '') ? $_POST['time_needed'] : 'ASAP'; 
    $spl_recipient                      = $_POST['spl_recipient'];

    $option_type                        =	$_POST['option_type'];
	
    $avl_sets_1                         = $_POST['avl_sets_1'];
    $need_sets_1                        = ($option_type == '1') ? $_POST['need_sets_1'] : '0';
	
    $size_sets_1                        = $_POST['size_sets_1'];
    $output_sets_1                      = $_POST['output_sets_1'];
    $media_sets_1                       = $_POST['media_sets_1'];
    $binding_sets_1                     = $_POST['binding_sets_1'];
    $folding_sets_1                     = $_POST['folding_sets_1'];
	
	
	
    $avl_sets_2                         = $_POST['size_sets_2'];
    $need_sets_2                        = ($option_type == '0') ? $_POST['need_sets_1']: '0';
	
    $size_sets_2                        = $_POST['size_sets_2'];
    $output_sets_2                      = $_POST['output_sets_2'];
    $binding_sets_2                     = $_POST['binding_sets_2'];
    $folding_sets_2                     = $_POST['folding_sets_2'];

    $delivery_type                      = $_POST['delivery_type'];
    $bill_number                        = $_POST['bill_number'];
    $shipp_comp_1_f                     = $_POST['shipp_comp_1_f'];
    $shipp_comp_2_f                     = $_POST['shipp_comp_2_f'];
    $shipp_comp_3_f                     = $_POST['shipp_comp_3_f'];

    $size_custom_details                = $_POST['size_custom_details'];

    $output_page_details                = $_POST['output_page_details'];

    $attention_to                       = $_POST['attention_to'];

    $contact_ph                         = $_POST['contact_ph'];

    $option_id                          = $_POST['option_id']; 
    
    $query = "UPDATE sohorepro_sets_needed
			SET     spl_inc         = '" . $spl_recipient . "',
                                delivery_type   = '" . $delivery_type . "',
                                billing_number  = '" . $bill_number . "',
                                shipp_time      = '" . $time_needed . "',
                                shipp_comp_1    = '" . $shipp_comp_1_f . "',
                                shipp_comp_2    = '" . $shipp_comp_2_f . "',
                                shipp_comp_3    = '" . $shipp_comp_3_f . "' WHERE rand_id = '" . $_SESSION['random_id'] . "' ";
    mysql_query($query);
}elseif($_POST['recipients'] == '22'){
    
    $shipping_id_rec_pre = explode("_", $_POST['shipping_id_rec']);    
    $shipping_id_rec = ($shipping_id_rec_pre[0] == "PEVERY") ? $shipping_id_rec_pre[1] : $_POST['shipping_id_rec'];
    $user_session = $_POST['user_session'];
    $user_session_comp = $_POST['user_session_comp'];
    $date_needed = $_POST['date_needed'];
    $time_needed = $_POST['time_needed'];
    $spl_recipient = ($_POST['spl_recipient'] == 'undefined') ? '' : $_POST['spl_recipient'];

    $option_type	=	$_POST['option_type'];
	
    $avl_sets_1 = $_POST['avl_sets_1'];
    $need_sets_1 = ($option_type == '1') ? $_POST['need_sets_1'] : '0';
	
    $size_sets_1 = $_POST['size_sets_1'];
    $output_sets_1 = $_POST['output_sets_1'];
    $media_sets_1 = $_POST['media_sets_1'];
    $binding_sets_1 = $_POST['binding_sets_1'];
    $folding_sets_1 = $_POST['folding_sets_1'];
	
	
	
    $avl_sets_2 = $_POST['size_sets_2'];
    $need_sets_2 = ($option_type == '0') ? $_POST['need_sets_1']: '0';
	
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
    
    $rand_id                            =   randomPassword();

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
                                shipp_comp_3    = '" . $shipp_comp_3_f . "',
                                rand_id         = '" . $rand_id . "' ";
    //$sql_result = mysql_query($query);
    
    $check_if_exist =   CheckIfExist($user_session_comp, $user_session, $option_id, $_SESSION['random_id']);
    if(count($check_if_exist) == '0'){
    mysql_query($query);
    $last_insert_id         =   mysql_insert_id();
    $get_last_random_id     =   GetLastRandomId($last_insert_id);
    $_SESSION['random_id']  =   $get_last_random_id;
    }else{
    $update_rand = "UPDATE sohorepro_sets_needed SET rand_id = '1' WHERE rand_id = '" . $_SESSION['random_id'] . "'";
    mysql_query($update_rand);   
    }
    
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
    $entered_needed_sets = NeededSetsDynamic($user_session_comp, $user_session, $option_id);
    $upload_file_exist      = UploadFileExistFinalize($user_session_comp, $user_session, $_SESSION['ref_val']);
    ?>
    <div style="width: 100%;float: left;border: 0px #F99B3E solid;margin-bottom: 5px;color: #FA8526;">            
        <div style="width: 15%;float: left;text-align: left;font-weight: bold;font-size: 15px;">OPTION <?php echo ($option_id); ?></div>
        <div style="width: 48%;float: left;text-align: left;font-weight: bold;font-size: 15px;"><?php echo ($option_id) . '&nbsp;of&nbsp;' . count($number_of_sets); ?></div>
    </div>
    <?php
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
        $dynamic_option_id = $entered_sets['options'];
?>  
    
    <input type="hidden" name="tot_avl_options" id="tot_avl_options" value="<?php echo count($number_of_sets); ?>" />
    <input type="hidden" name="rem_avl_options" id="rem_avl_options" value="<?php echo count($rem_avl_options); ?>" />
    
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
                    <?php }                     
                    if(count($upload_file_exist) > 0){
                    ?>
                
                <div style="float: left;width: 100%;margin-left: 30px;margin-top: 7px;">
                    <span style="font-weight: bold;">Upload File:  </span>
                </div>
                <?php
                    foreach ($upload_file_exist as $files){    
                ?>                
                <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                    <a href="http://cipldev.com/supply-new.sohorepro.com/uploads/<?php echo $files['file_name']; ?>" target="_blank"><?php echo $files['file_name']; ?></a>
                </div>
                    <?php }} ?>
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
        $user_id_add_set = $_SESSION['sohorepro_userid'];
        $company_id_view_plot = $_SESSION['sohorepro_companyid'];
        
        $enteredPlot = EnteredPlotRecipientsCurrentOptionDynamic($company_id_view_plot, $user_id_add_set);        
        
        $sumOfPlot_yd   =   EnteredPlotRecipientsCurrentOptionYnamic($company_id_view_plot, $user_id_add_set, $enteredPlot[0]['options']);  
        
        $sumOfplott_dy = SumOffPlott($enteredPlot[0]['options']);
        $sumOfArch_dy = SumOffArch($enteredPlot[0]['options']);

        $enteredSetsOptionsSets = ($enteredPlot[0]['plot_needed'] != '0') ? $sumOfplott_dy : $sumOfArch_dy;
        
        if($sumOfPlot_yd[0]['print_ea'] != $enteredSetsOptionsSets){        
?>
    <!-- NEW Dynamic Sets Starts -->    
    <div style="border: 1px #F99B3E solid;margin-bottom: 20px;padding-bottom: 20px;width: 100%;float: left;">
        <div style="width: 100%;float: left;margin-top: 10px;">
            <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo $r; ?></div>
            <div style="float: right;width: 20%;font-weight: bold;cursor: pointer;" title="Delete Recipient" alt="Delete Recipient" onclick="return delete_recipient_empty();"><span style="background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;">Delete</span></div>

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
                        
                        //$enteredPlot = EnteredPlotRecipientsCurrentOption($entered_sets['options']);
                        
//                        echo '<pre>';
//                        print_r($enteredPlot);
//                        echo '</pre>';
                        $i = 1;
                        foreach ($enteredPlot as $entered) {
                            $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                            $binding = $entered['binding'];
                            $folding = $entered['folding'];
                            $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Architectural Copies';
                            $type = ($entered['plot_arch'] == '1') ? '1' : '0';
                            $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1') : EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                            $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']) : ArchSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']);
                            $plot_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1');
                            $copy_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');

                            if ($entered['plot_arch'] == '1') {
                                ?>
                                <input type="hidden" id="option_id_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['options']; ?>" />
                                <input type="hidden" id="option_type_<?php echo $current_opt['options']; ?>" value="<?php echo $type; ?>" />
                                <tr bgcolor="#ffeee1">
                                    <td>Plotting on Bond</td>
                                    <td><?php echo $entered['origininals']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_<?php echo $option_id; ?>" class="avl_sets"  value="<?php echo ($entered['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1', '<?php echo $current_opt['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>', '<?php echo $current_opt['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_<?php echo $option_id; ?>" class="need_sets" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_dy('<?php echo $option_id; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_dy('<?php echo $option_id; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
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
                                <input type="hidden" id="option_id_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['options']; ?>" />
                                <input type="hidden" id="option_type_<?php echo $current_opt['options']; ?>" value="<?php echo $type; ?>" />
                                <tr bgcolor="#ffeee1">
                                    <td>Architectural Copies</td>
                                    <td><?php echo $available_order[0]['origininals']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_<?php echo $option_id; ?>" class="avl_sets"  value="<?php echo ($entered['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1', '<?php echo $current_opt['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>', '<?php echo $current_opt['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_<?php echo $option_id; ?>" class="need_sets" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_dy('<?php echo $option_id; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_dy('<?php echo $option_id; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
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
                                    Drop-off Option
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
                <select  name="address_book_rp" id="address_book_rp_<?php echo $option_id; ?>" style="width: 75% !important;" onchange="return show_address_dynamic('<?php echo $option_id; ?>');">
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
            <div id="show_address_<?php echo $option_id; ?>" style="float: left;width: 56%;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">

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
                                <input type="text" name="shipp_att" id="shipp_att_<?php echo $option_id; ?>" value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                                <input type="text" name="contact_ph" id="contact_ph_<?php echo $option_id; ?>" onfocus="return contact_phone_dynamic('<?php echo $option_id; ?>');"  value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                        <span id="asap_status_<?php echo $option_id; ?>" class="asap_orange" onclick="return asap_dynamic('<?php echo $option_id; ?>');">ASAP</span> 
                    </div>

                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                        <input class="picker_icon" value="" type="text" name="date_needed" id="date_needed_<?php echo $option_id; ?>" style="width: 75px;" onclick="date_reveal();" />
                        <input id="time_picker_icon_<?php echo $option_id; ?>" value="" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time();" />
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


            <div style="float: left;width:100%;margin-top: 10px;">
                <div style="font-weight: bold;float: left;width:55%;margin-left: 25px;">
                    Special Instructions:  
                </div>
                <div style="float: left;width:40%;text-align: right;">
                    <div style="float:right;margin-right: 12px;">
                        <input id="add_recipients" value="Add Recipient" style="margin-left: 5px;float:left;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="button" onclick="return add_recipients_dynamic('<?php echo $enteredPlot[0]['options']; ?>');" />
                    </div>                    
                </div>                
            </div>
            
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                <textarea name="spl_recipient" id="spl_recipient" rows="3" cols="18" style="width: 200px;height: 40px;"></textarea>
            </div>

        </div>        
    </div>
        <?php } ?>
    <!-- NEW Dynamic Sets End -->  
<?php
}elseif ($_POST['recipients'] == '8') {
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
        echo $shipp_add[0]['company_name'] . '<br>' . 'Attention:  ' . $entered_sets['attention_to'] . '<br>' . 'Contact:  ' . $entered_sets['contact_ph'] . '<br>' . $shipp_add[0]['address_1'] . ',<br>' . $add_2 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'];
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
                            $binding = $entered['binding'];
                            $folding = $entered['folding'];
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
                                    Drop-off Option
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
                                    $binding = $entered['binding'];
                                    $folding = $entered['folding'];
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
            echo $shipp_add[0]['company_name'] . '<br>' . 'Attention:  ' . $entered_sets['attention_to'] . '<br>' . 'Contact:  ' . $entered_sets['contact_ph'] . '<br>' . $shipp_add[0]['address_1'] . '<br>' . $add_2 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'];
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
        echo $shipp_add[0]['company_name'] . '<br>' . 'Attention:  ' . $entered_sets['attention_to'] . '<br>' . 'Contact:  ' . $entered_sets['contact_ph'] . '<br>' . $shipp_add[0]['address_1'] . ',<br>' . $add_2 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'];
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
                            $binding = $entered['binding'];
                            $folding = $entered['folding'];
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
            $binding = $entered['binding'];
            $folding = $entered['folding'];
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

    $user_session       = $_POST['inc_avl_user_id'];
    $user_session_comp  = $_POST['inc_avl_comp_id'];
    $type               = $_POST['inc_avl_type'];
    $row_id             = $_POST['inc_avl_rec_id'];
    $sets_current_1     = $_POST['need_sets_current_1'];
    $sets_current_2     = $_POST['need_sets_current_2'];
    $decrese_avl_sets   = $_POST['decrese_avl_sets'];
    $option_id          = $_POST['option_id'];
//    $sql_1              =   "DELETE FROM sohorepro_plotting_set WHERE id = '".$row_id."' ";
//    mysql_query($sql_1); 

    $sql_3 = "UPDATE sohorepro_plotting_set SET print_ea = '" . $decrese_avl_sets . "' WHERE company_id = '" . $user_session_comp . "' AND user_id = '" . $user_session . "'  AND options = '".$option_id."' AND order_id = '0'  ";
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
            $binding = $entered['binding'];
            $folding = $entered['folding'];
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

    $user_session       = $_POST['inc_avl_user_id'];
    $user_session_comp  = $_POST['inc_avl_comp_id'];
    $type               = ($_POST['inc_avl_type'] == '1') ? '0' : '1';
    $change_type        = ($_POST['inc_avl_type'] == '1') ? '1' : '0';
    $row_id             = $_POST['inc_avl_rec_id'];
    $option_id          = $_POST['option_id'];
    $available_sets     = $_POST['available_sets'];
    
    
//    $sql_last_id = mysql_query("SELECT id FROM sohorepro_plotting_set ORDER BY id DESC LIMIT 1");
//    $object_last_id = mysql_fetch_assoc($sql_last_id);
//    $last_id = $object_last_id['id'] + 1;
//
//    $sql_1 = "CREATE TEMPORARY TABLE tmp SELECT * FROM sohorepro_plotting_set WHERE plot_arch = '" . $type . "' LIMIT 1 ";
//    mysql_query($sql_1);
//    $sql_2 = "UPDATE tmp SET id = '" . $last_id . "', plot_arch = '" . $change_type . "' WHERE plot_arch = '" . $type . "'";
//    mysql_query($sql_2);
//    $sql_3 = "INSERT INTO sohorepro_plotting_set SELECT * FROM tmp WHERE id = '" . $last_id . "' ";
//    mysql_query($sql_3);
    
    
    $sql_inc = "UPDATE sohorepro_plotting_set SET print_ea = '" . $available_sets . "' WHERE company_id = '" . $user_session_comp . "' AND user_id = '".$user_session."' AND options = '".$option_id."' AND order_id = '0' ";
    mysql_query($sql_inc);
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
            $binding = $entered['binding'];
            $folding = $entered['folding'];
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

    $message .= '<div style="border:1px solid #FF7E00;">';
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

    $message .= '<div style="border:1px solid #FF7E00;">';
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
        $result[] = $to['email_id'] . ',';
    }
    $to_address = implode("", $result);
//    foreach ($mail_id as $to) {
    $subject = "Help Request from Website";
    $headers = 'From: ' . $user_email . "\r\n";
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
                                    $binding = $entered['binding'];
                                    $folding = $entered['folding'];
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
    
    $user_session_comp      = $_SESSION['sohorepro_companyid'];
    $user_session           = $_SESSION['sohorepro_userid'];
    
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
    $message = '<!DOCTYPE html><html>';
    $message .= '<body>';
    $message .= '<div style="border:0px solid #FF7E00;width: 90%;float: left;">';
    $message .= '<table style="width: 100%;">';
    $message .= '<tr>';
    $message .= '<td align="left" valign="top" style="padding-left: 10px;">';
    $message .= '<div style="width: 100%;float: left;font-size: 21px;margin-bottom:5px;">Order Completed: ORDER # ' . $job_reference_final[0]['order_sequence'] . '</div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Customer Reference:</span> ' . $reference . '</div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Date:</span> ' . $Date . '</div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Name:</span> ' . $user_name . '</div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Company:</span> ' . $customer_name . '</div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Email:</span> ' . $user_mail_id_txt . '</div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Phone:</span>&nbsp;' . $phone . '</div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:5px"><span style="font-weight:bold;">Billing Address:</span></div>';
    $message .= '<div style="width: 100%;float: left;margin-bottom:5px">' . $service_billing_address[0]['comp_name'] . '<br>' . $service_address_1 . $service_address_2 . $service_address_3 . $service_billing_address[0]['comp_city'] . ',&nbsp;' . $service_billing_address[0]['comp_state'] . '&nbsp;' . $service_billing_address[0]['comp_zipcode'] . '</div>';
    $message .= '</td></tr><tr>';

    $message .= '<td style="padding-top: 10px;padding-left: 10px;padding-bottom: 10px;">';

    //Original Order Start
    //$message .= '<div style="width: 95%;float: left;height:2px;background-color: #F99B3E;margin-top: 10px;margin-bottom: 10px"></div>';
    $message .= '<div style="float: left;margin-bottom: 20px;width: 100%;">';
    $message .= '<div style="font-weight: bold;padding-top: 3px;width: 95%;float: left;">ORIGINAL ORDER</div>';
    $message .= '<div style="width: 95%;float: left;margin-top: 10px;margin-bottom: 10px;">';
    
    $message .= '<div style="float: left;width: 100%;">';
    if($entered_needed_sets_final[0]['delivery_type_option'] != '1'){  
    $message .= '<div style="float: left;width: 100%;margin-top: 7px;font-weight: bold;">Customer Details:</div>';
    
    $message .= '<div style="float: left;width: 100%;margin-top: 7px;">';
    $cust_add = getCustomeInfo($_SESSION['sohorepro_companyid']);
    $cust_add_2 = ($cust_add[0]['comp_business_address2'] != '') ? $cust_add[0]['comp_business_address2'] . ',<br>' : '';
    $message .= $cust_add[0]['comp_name'] . '<br>' . $cust_add[0]['comp_business_address1'] . ',<br>' . $cust_add_2 . $cust_add[0]['comp_city'] . ',&nbsp;' . $cust_add[0]['comp_state'] . '&nbsp;' . $cust_add[0]['comp_zipcode'].'<br>'.$cust_add[0]['comp_contact_phone'];
    $message .= '</div>';
    
//    $message .= '<div style="float: left;width: 100%;margin-top: 7px;font-weight: bold;">User Details:</div>';
    
//    $message .= '<div style="float: left;width: 100%;">';
//    $cust_user_add = UserLoginDtls($_SESSION['sohorepro_userid']);
//    $cust_user_name = $cust_user_add[0]['cus_fname'] . '&nbsp;' . $cust_user_add[0]['cus_lname'];
//    $cust_mail_id = $cust_user_add[0]['cus_email'];
//    $cust_phone_num = $cust_user_add[0]['cus_contact_phone'];
//    $message .= $cust_user_name . '<br>' . $cust_mail_id . '<br>' . $cust_phone_num . '<br>Date:' . date('m-d-Y h:i A', time());
//    $message .= '</div>';
    
    $message .= '<div style="float: left;width: 100%;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>';    
    }
    $message .= '<div style="float: left;width: 100%;margin-top: 5px;">';
    //$cust_original_order = SetsOrderedFinalize($job_reference_final[0]['id']);
    $cust_original_order = EnteredPlotRecipientsMultiOriginal($user_session_comp, $user_session, $job_reference_final[0]['id']);
    $total_plot_needed = SetsOrderedFinalizeCountOfSets($job_reference_final[0]['id']);
    $cust_original_order_final = SetsOrderedFinalizeOriginal($job_reference_final[0]['id']);
    $upload_file_exist = UploadFileExistFinalize($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid'], $job_reference_final[0]['id']);
    $cust_needed_sets = ($cust_original_order[0]['print_ea'] != '0') ? $cust_original_order[0]['print_ea'] : $cust_original_order[0]['arch_needed'];
    $cust_order_type = ($cust_original_order[0]['arch_needed'] != '0') ? 'Architectural Copies' : 'Plotting on Bond';
    $option          = ($cust_original_order[0]['arch_needed'] != '0') ? 'Pickup Options:' : 'File Options:';  
    $message .= '<table border="0" style="width: 100%;">';
    $message .= '<tr bgcolor="#F99B3E">';
    $message .= '<td style="font-weight: bold;">Option</td>'; 
    $message .= '<td style="font-weight: bold;">Originals</td>';
    $message .= '<td style="font-weight: bold;">Sets</td>';
    $message .= '<td style="font-weight: bold;">Order Type</td>';
    $message .= '<td style="font-weight: bold;">Size</td>';
    $message .= '<td style="font-weight: bold;">Output</td>';
    $message .= '<td style="font-weight: bold;">Media</td>';
    $message .= '<td style="font-weight: bold;">Binding</td>';
    $message .= '<td style="font-weight: bold;">Folding</td>';
    $message .= '</tr>';    
    foreach ($cust_original_order as $original){
        $cust_needed_sets       = ($original['print_ea'] != '0') ? $original['print_ea'] : $original['arch_needed'];
        $cust_order_type        = ($original['plot_arch'] == '0') ? 'Architectural Copies' : 'Plotting on Bond';  
        $size         = ($original['size'] == 'undefined') ? $original['arch_size'] : $original['size'];
        $output       = ($original['output'] == 'undefined') ? $original['arch_output'] : $original['output'];
        $media        = ($original['media'] == 'undefined') ? $original['arch_media'] : $original['media'];
        $binding      = ($original['binding'] == 'undefined') ? $original['arch_binding'] : $original['binding'];
        $folding      = ($original['folding'] == 'undefined') ? $original['arch_folding'] : $original['folding']; 
    $message .= '<tr bgcolor="#ffeee1">';
    $message .= '<td>' . $original['options'] . '</td>';
    $message .= '<td>' . $original['origininals'] . '</td>';
    $message .= '<td>' . $cust_needed_sets . '</td>';
    $message .= '<td>' . $cust_order_type . '</td>';
    $message .= '<td>' . $size . '</td>';
    $message .= '<td style="text-transform: uppercase;">' . $output . '</td>';
    $message .= '<td>' . $media . '</td>';
    $message .= '<td>' . ucfirst($binding) . '</td>';
    $message .= '<td>' . ucfirst($folding) . '</td>';
    $message .= '</tr>'; 
    }
    $message .= '</table>';
    $message .= '</div>';
    $message .= '</div>';
    $enteredPlot    = EnteredPlotRecipientsMultiOriginal($user_session_comp, $user_session, $job_reference_final[0]['id']);
     
    //New Format Start
    
    foreach ($cust_original_order_final as $original){
        $message .= '<div style="float:left;width: 95%;margin-top: 10px;">';  
        $message .= '<div style="float:left;width: 95%;font-weight: bold;color: #000;margin-top: 7px;font-weight:bold;"> OPTION&nbsp;'.$original['options'].'&nbsp;- Details</div>';  
     if ($original['size'] == 'Custom') {
        $message .= '<div style="float:left;width: 95%;color: #000;margin-top: 7px;">Custom Size:&nbsp;'.$original['custome_details'].'</div>';     
     } 
     if ($original['output'] == 'Both') {
        $message .= '<div style="float:left;width: 95%;color: #000;margin-top: 7px;">Color Page Numbers:&nbsp;'.$original['output_both'].'</div>';     
     } 
     if ($original['spl_instruction'] != '') {
        $message .= '<div style="float:left;width: 95%;color: #000;margin-top: 7px;">Special Instructions:&nbsp;'.$original['spl_instruction'].'</div>';     
     } 
     if ($original['ftp_link'] != "0") {
            $link       = ($original['ftp_link'] != '0') ? $original['ftp_link'] : '';
            $user_name  = ($original['user_name'] != '0') ? $original['user_name'] : '';
            $password   = ($original['password'] != '0') ? $original['password'] : '';
        $message .= '<div style="float:left;width: 95%;color: #000;margin-top: 7px;">File Option: Provide Link to a File</div>';     
        $message .= '<div style="float:left;width: 95%;color: #000;margin-top: 7px;">FTP Link:&nbsp;'.$link.'</div>';     
        $message .= '<div style="float:left;width: 95%;color: #000;margin-top: 7px;">User Name:&nbsp;'.$user_name.'</div>';     
        $message .= '<div style="float:left;width: 95%;color: #000;margin-top: 7px;">Password:&nbsp;'.$password.'</div>';     
     }
     
     if ($original['upload_file'] != "") {
        $message .= '<div style="float:left;width: 95%;color: #000;margin-top: 7px;">File Option: Upload a file</div>';     
        $message .= '<div style="float:left;width: 95%;color: #000;margin-top: 7px;"><a href="http://cipldev.com/supply-new.sohorepro.com/uploads/'.$original['upload_file'].'" target="_blank">'.$original['upload_file'].'</a></div>';   
     }
     
     if ($original['drop_off'] != "0") {
        $message .= '<div style="float:left;width: 95%;color: #000;margin-top: 7px;">Drop-Off Option:&nbsp;'.$original['drop_off'].'</div>';
     }
     
     if ($original['pick_up'] != "0") {
         if(($original['pick_up'] == "ASAP") && ($original['pick_up_time'] == "ASAP")){
             $pickup_details = $original['pick_up'];
         }else{
             $pickup_details = $original['pick_up'].'&nbsp;'.$original['pick_up_time'];
         }
        $message .= '<div style="float:left;width: 95%;color: #000;margin-top: 7px;">Pickup Option:&nbsp;'.$pickup_details.'</div>';
     }
     
     $message .= '</div>';  
    }    
    // New Format End
    
    $message .= '</div>';
    $message .= '</div>';
    //Original Order End
    
    if($entered_needed_sets_final[0]['delivery_type_option'] == '1'){    
    $message .= '<div style="float: left;width: 100%;">';
    $message .= '<div style="float: left;width: 100%;margin-top: 7px;font-weight: bold;margin-bottom: 20px;">DELIVERY METHOD: RETURN EVERYTHING TO MY OFFICE</div>';
    $message .= '</div>';
    }elseif($entered_needed_sets_final[0]['delivery_type_option'] == '2'){
    $message .= '<div style="float: left;width: 100%;">';
    $message .= '<div style="float: left;width: 100%;margin-top: 7px;font-weight: bold;margin-bottom: 20px;">DELIVERY METHOD: SEND EVERYTHING TO </div>';
    $message .= '</div>'; 
    }elseif($entered_needed_sets_final[0]['delivery_type_option'] == '3'){
    $message .= '<div style="float: left;width: 100%;">';
    $pickup_from_soho_add = $_SESSION['pickup_from_soho_add'];
    $address_caption    =   AddressBookPickupSoho($pickup_from_soho_add);
    $message .= '<div style="float: left;width: 100%;margin-top: 7px;font-weight: bold;margin-bottom: 20px;">DELIVERY METHOD: WILL PICKUP FROM SOHO REPRO - '.$address_caption[0]['caption'].'</div>';
    $message .= '</div>';  
    }else{
    $message .= '<div style="float: left;width: 100%;">';
    $message .= '<div style="float: left;width: 100%;margin-top: 7px;font-weight: bold;margin-bottom: 20px;">DELIVERY METHOD: DISTRIBUTE TO ONE OR MORE LOCATIONS</div>';
    $message .= '</div>';   
    }
    
    if($entered_needed_sets_final[0]['delivery_type_option'] == '1'){        
    $message .= '<div style="float: left;" class="shaddows">';
    $message .= '<div class="ribbon" id="ribbon_final" style="font-weight: bold;"><span>RECIPIENT:</span></div>';
    $message .= '<div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;">';   
    $message .= '<div class="details_div">';
    $message .= '<div style="float: left;width: 65%;margin-top: 7px;font-weight: bold;">Send to: </div>';                
    $message .= '<div style="float: left;width: 65%;text-align:left;">';
    $cust_add = getCustomeInfo($user_session_comp);
    $cust_add_2 = ($cust_add[0]['comp_business_address2'] != '') ? $cust_add[0]['comp_business_address2']. '<br>'  : '';   
    $attention_ev   =   ($_SESSION['attention_every'] != '') ? 'Attention:&nbsp;'.$_SESSION['attention_every'].'<br>' : '';
    $tel_eve       =   ($_SESSION['tel_every'] != '') ? 'Tel:&nbsp;'.$_SESSION['tel_every'].'<br>' : '';
    $message .= '<div style="float: left;width: 200px;">'.$cust_add[0]['comp_name'] . '<br>'.$attention_ev.$tel_eve. $cust_add[0]['comp_business_address1'] . '<br>' . $cust_add_2 . $cust_add[0]['comp_city'] . '&nbsp;' . $cust_add[0]['comp_state'] . '&nbsp;' . $cust_add[0]['comp_zipcode'].'<br>'.$cust_add[0]['comp_contact_phone'].'</div>';
    $message .= '</div>';    
    }elseif($entered_needed_sets_final[0]['delivery_type_option'] == '2'){
      
        if(($entered_needed_sets_final[0]['shipp_id'] == 'P1') && ($entered_needed_sets_final[0]['shipp_id'] == 'P2')){
            $shipp_add = AddressBookPickupSohoCap($entered_needed_sets_final[0]['shipp_id']);
        }else{
            $shipp_add = editAddressServices($entered_needed_sets_final[0]['shipp_id']);  
        }
    $message .= '<div style="float: left;" class="shaddows">';
    $message .= '<div class="ribbon" style="font-weight: bold;" id="ribbon_final"><span>RECIPIENT</span></div>';
    $message .= '<div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;">';
    $message .= '<div class="details_div">';               
    $message .= '<div style="float: left;width: 65%;margin-top: 7px;font-weight: bold;">Send to: </div>';
    $message .= '<div style="float: left;width: 65%;">';
    if(($entered_needed_sets_final[0]['shipp_id'] != 'P1') && ($entered_needed_sets_final[0]['shipp_id'] != 'P2')){
    $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . '<br>';
    $add_3 = ($shipp_add[0]['address_3'] == '') ? '' : $shipp_add[0]['address_3'] . '<br>';
    $att    = ($entered_needed_sets_final[0]['attention_to'] != "undefined") ? '<br>Attention:  '.$entered_needed_sets_final[0]['attention_to'] : '';
    $phone  = ($entered_needed_sets_final[0]['contact_ph'] != "undefined") ? '<br>'.'Contact:  '.$entered_needed_sets_final[0]['contact_ph'] : '';
    $message .= '<div style="float: left;width: 260px;">'.$shipp_add[0]['company_name'].$att.$phone.'<br>'. $shipp_add[0]['address_1'] . '<br>' . $add_2.$add_3 . $shipp_add[0]['city'] . '&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'].'<br>'.$shipp_add[0]['phone'].'</div>';
    }  else {                    //echo $shipp_add[0]['address'];                        
    $shipp_add_p = AddressBookPickupSohoCap($entered_sets['shipp_id']);
    $message .= '<div style="float: left;">'.$shipp_add_p[0]['address'].'</div>';   
    }               
    $message .= '</div>';
    
    }elseif($entered_needed_sets_final[0]['delivery_type_option'] == '3'){
        
        
        $pickup_from_soho_add = $_SESSION['pickup_from_soho_add'];
        $address_caption    =   AddressBookPickupSoho($pickup_from_soho_add);
                            
        $message .= '<div style="float: left;" class="shaddows">';
        $message .= '<div class="ribbon" id="ribbon_final" style="font-weight: bold;"><span>RECIPIENT</span></div>';
        $message .= '<div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;"><div class="details_div">';
        $message .= '<div style="float: left;width: 65%;margin-top: 7px;font-weight: bold;">Pickup at: </div>';
        $message .= '<div style="float: left;width: 65%;">';        
        $message .= '<div style="float: left;">'. $address_caption[0]['address'].'</div>';
                      
            $message .= '</div>';
            $message .= '<div style="float: left;width: 65%;margin-top: 7px;font-weight: bold;">PACKING LIST: </div>';
            $message .= '<div style="float: left;width: 92%;margin-top: 5px;">';
            $cust_original_order    = EnteredPlotRecipientsMultiOriginal($user_session_comp, $user_session, $job_reference_final[0]['id']);
            $option                 = ($cust_original_order[0]['plot_arch'] == '0') ? 'Pickup Options:' : 'File Options:';
            $message .= '<table border="0" style="width: 100%;">';
            $message .= '<tr bgcolor="#F99B3E">';
            $message .= '<td style="font-weight: bold;">Option</td>';
            $message .= '<td style="font-weight: bold;">Originals</td>';
            $message .= '<td style="font-weight: bold;">Sets</td>'; 
            $message .= '<td style="font-weight: bold;">Order Type</td>';                         
            $message .= '<td style="font-weight: bold;">Size</td>';
            $message .= '<td style="font-weight: bold;">Output</td>';
            $message .= '<td style="font-weight: bold;">Media</td>';
            $message .= '<td style="font-weight: bold;">Binding</td>';
            $message .= '<td style="font-weight: bold;">Folding</td>';
            $message .= '</tr>';
            foreach ($cust_original_order as $original){                            
                $cust_needed_sets       = ($original['print_ea'] != '0') ? $original['print_ea'] : $original['arch_needed'];
                $cust_order_type        = ($original['plot_arch'] == '0') ? 'Architectural Copies' : 'Plotting on Bond';                               
                $size         = ($original['size'] == 'undefined') ? $original['arch_size'] : $original['size'];
                $output       = ($original['output'] == 'undefined') ? $original['arch_output'] : $original['output'];
                $media        = ($original['media'] == 'undefined') ? $original['arch_media'] : $original['media'];
                $binding      = ($original['binding'] == 'undefined') ? $original['arch_binding'] : $original['binding'];
                $folding      = ($original['folding'] == 'undefined') ? $original['arch_folding'] : $original['folding'];                                        
            $message .= '<tr bgcolor="#ffeee1">';
            $message .= '<td>'.$original['options'].'</td>';
            $message .= '<td>'.$original['origininals'].'</td>';
            $message .= '<td>'.$cust_needed_sets.'</td>';
            $message .= '<td>'.$cust_order_type.'</td>';                            
            $message .= '<td>'.$size.'</td>';
            $message .= '<td style="text-transform: uppercase;">'.$output.'</td>';
            $message .= '<td>'.$media.'</td>';
            $message .= '<td>'.ucfirst($binding).'</td>';
            $message .= '<td>'.ucfirst($folding).'</td>';
            $message .= '</tr>';
            }
            $message .= '</table>';       
            $message .= '</div>';
            $enteredPlot    = EnteredPlotRecipientsMultiOriginal($user_session_comp, $user_session, $job_reference_final[0]['id']);
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
            $message .= '<div style="float:left;width: 95%;font-weight: bold;color: #000;margin-top: 7px;"> OPTION&nbsp;'.$entered['options'].'</div>';
            $message .= '<div style="width: 90%;float: left;border: 1px solid #F99B3E;padding: 5px;">';
            if ($entered['size'] == 'Custom') {
            $message .= '<div style="width: 22%;float: left;border: 1px solid #F99B3E;margin-right: 10px;">';
            $message .= '<div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">Custom Size Details</div>';
            $message .= '<div style="padding-top: 3px;width: 100%;float: left;">'.$entered['custome_details'].'</div></div>';
            }
            if ($entered['output'] == 'Both') {
            $message .= '<div style="width: 22%;float: left;border: 1px solid #F99B3E;margin-right: 10px;">';
            $message .= '<div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">Color Page Numbers</div>';
            $message .= '<div style="padding-top: 3px;width: 100%;float: left;">'.$entered['output_both'].'</div></div>';
            }
            if ($entered['spl_instruction'] != '') {
            $message .= '<div style="width: 22%;float: left;border: 1px solid #BFC5CD;margin-right: 10px;">';
            $message .= '<div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">Special Instructions</div>';
            $message .= '<div style="padding-top: 3px;width: 100%;float: left;">'.$entered['spl_instruction'].'</div></div>';
            }if ($entered['plot_arch'] == '0') {
                if ($entered['pick_up_time'] != '0') {
            $message .= '<div style="width: 22%;float: left;border: 1px solid #F99B3E;">';
            $message .= '<div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">Pickup Option</div>';
            $message .= '<div style="padding-top: 3px;width: 100%;float: left;">'.$entered['pick_up'] . ' ' . $entered['pick_up_time'].'</div></div>';
            }if ($entered['drop_off'] != '0') {
            $message .= '<div style="width: 22%;float: left;border: 1px solid #F99B3E;">';
            $message .= '<div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">Drop-off Option</div>';
            $message .= '<div style="padding-top: 3px;width: 100%;float: left;">'.$entered['drop_off'].'</div></div>';
            }
            }
            $message .= '</div>';
            }
            }
            */
            $message .= '<div style="float: left;width: 65%;margin-top: 7px;">';
            $date_asap  = ($entered_needed_sets_final[0]['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_needed_sets_final[0]['shipp_time'] : '';
            $message .= '<span style="font-weight: bold;">When Needed: </span>'.$entered_needed_sets_final[0]['shipp_date'].$date_asap.'</div>';
            if($entered_needed_sets_final[0]['spl_inc'] != ''){
            $message .= '<div style="width: 100%;float: left;margin-top: 7px;">';
            $message .= '<span style="font-weight: bold;">Special Instructions: </span></div>';
            $message .= '<div style="width: 100%;float: left;margin-top: 7px;">'.$entered_needed_sets_final[0]['spl_inc'].'</div></div></div></div>';
            }
    }else{
    
    $r = 1;
    foreach ($entered_needed_sets_final as $entered_sets) {
        if (($entered_sets['shipp_id'] == 'P1') && ($entered_sets['shipp_id'] == 'P2')) {
            $shipp_add = AddressBookPickupSohoCap($entered_sets['shipp_id']);
        } else {
            $shipp_add = SelectIdAddressService($entered_sets['shipp_id']);
        }
        $needed_options  =   $entered_sets['option_id'];
        $needed_sets  = ($entered_sets['plot_needed'] != '0') ? $entered_sets['plot_needed'] : $entered_sets['arch_needed'];
        $order_type   = ($entered_sets['arch_needed'] != '0') ? 'Architectural Copies' : 'Plotting on Bond';
        $plot_binding = ($entered_sets['binding'] == '0') ? '' : ','.$entered_sets['binding'];
        $plot_folding = ($entered_sets['folding'] == '0') ? '' : ','.$entered_sets['folding'];
        $arch_binding = ($entered_sets['arch_binding'] == '0') ? '' : ','.$entered_sets['arch_binding'];
        $arch_folding = ($entered_sets['arch_folding'] == '0') ? '' : ','.$entered_sets['arch_folding'];
        $size         = ($entered_sets['size'] == 'undefined') ? $entered_sets['arch_size'] : $entered_sets['size'];
        $output       = ($entered_sets['output'] == 'undefined') ? $entered_sets['arch_output'] : $entered_sets['output'];
        $media        = ($entered_sets['media'] == 'undefined') ? $entered_sets['arch_media'] : $entered_sets['media'];
        $binding      = ($entered_sets['binding'] == 'undefined') ? $entered_sets['arch_binding'] : $entered_sets['binding'];
        $folding      = ($entered_sets['folding'] == 'undefined') ? $entered_sets['arch_folding'] : $entered_sets['folding'];
        //border: 2px #F99B3E solid;
        //$message .= '<div style="width: 95%;float: left;height:2px;background-color: #F99B3E;margin-top: 10px;margin-bottom: 10px"></div>';
        $message .= '<div style="font-weight: bold;padding-top: 3px;width: 95%;float: left;">RECIPIENT ' . $r . '</div>';
        $message .= '<div style="width: 95%;float: left;margin-bottom: 10px;">';
        $message .= '<div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;">';
        $message .= '<div style="float: left;width: 100%;margin-top: 10px;font-weight: bold;">Send to: </div>';
        $message .= '<div style="float: left;width: 100%">';

        if (($entered_sets['shipp_id'] != 'P1') && ($entered_sets['shipp_id'] != 'P2')) {
            $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . ',<br>';
            $add_3 = ($shipp_add[0]['address_3'] == '') ? '' : $shipp_add[0]['address_3'] . ',<br>';
            $tel   = ($entered_sets['contact_ph'] != '') ? 'Tel:  ' . $entered_sets['contact_ph'] . ',<br>' : '';
            $message .= $shipp_add[0]['company_name'] . '<br>' . 'Attention: ' . $entered_sets['attention_to'] . '<br>' .$tel. $shipp_add[0]['address_1'] . ',<br>' . $add_2.$add_3 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'];
        } else {                    //echo $shipp_add[0]['address'];                        
            $shipp_add_p = AddressBookPickupSohoCap($entered_sets['shipp_id']);
            $message .= $shipp_add_p[0]['address'];
        }


        $message .= '</div>';
        $message .= '<div style="float: left;width: 100%;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>';
        $message .= '<div style="float: left;width: 100%;margin-top: 5px;">';

        $message .= '<table border="0" style="width: 100%;">';
        $message .= '<tr bgcolor="#F99B3E">';
        $message .= '<td style="font-weight: bold;">Option</td>'; 
        $message .= '<td style="font-weight: bold;">Sets</td>';
        $message .= '<td style="font-weight: bold;">Order Type</td>';
        $message .= '<td style="font-weight: bold;">Size</td>';
        $message .= '<td style="font-weight: bold;">Output</td>';
        $message .= '<td style="font-weight: bold;">Media</td>';
        $message .= '<td style="font-weight: bold;">Binding</td>';
        $message .= '<td style="font-weight: bold;">Folding</td>';
        $message .= '</tr>';
        if ($entered_sets['plot_needed'] != '0') {            
        $message .= '<tr bgcolor="#ffeee1">';        
        $message .= '<td>' . $needed_options . '</td>';
        $message .= '<td>' . $needed_sets . '</td>';
        $message .= '<td>' . $order_type . '</td>';
        $message .= '<td>' . $size . '</td>';
        $message .= '<td style="text-transform: uppercase;">' . $output . '</td>';
        $message .= '<td>' . $media . '</td>';
        $message .= '<td>' . ucwords(strtolower($binding)) . '</td>';
        $message .= '<td>' . ucwords(strtolower($folding)) . '</td>';
        $message .= '</tr>';
        }
        if ($entered_sets['plot_needed'] == '0') {            
        $message .= '<tr bgcolor="#ffeee1">';        
        $message .= '<td>' . $needed_options . '</td>';
        $message .= '<td>' . $needed_sets . '</td>';
        $message .= '<td>' . $order_type . '</td>';
        $message .= '<td>' . $size . '</td>';
        $message .= '<td style="text-transform: uppercase;">' . $output . '</td>';
        $message .= '<td>' . $media . '</td>';
        $message .= '<td>' . ucwords(strtolower($binding)) . '</td>';
        $message .= '<td>' . ucwords(strtolower($folding)) . '</td>';
        $message .= '</tr>';
        }
        
        $message .= '</table>';
        $message .= '</div>';

        if ($entered_sets['size'] == 'Custom') {
            $message .= '<div style="float: left;width: 65%;/*margin-left: 30px;*/margin-top: 5px;">';
            $message .= '<div style="font-weight: bold;width: 100%;float: left;">Custom Size Details:</div>';
            $message .= '<div style="padding-top: 3px;">' . $entered_sets['custome_details'] . '</div>';
            $message .= '</div>';
        }

        if ($entered_sets['output'] == 'Both') {
            $message .= '<div style="float: left;width: 65%;/*margin-left: 30px;*/margin-top: 5px;">';
            $message .= '<div style="font-weight: bold;width: 100%;float: left;">Page Number:</div>';
            $message .= '<div style="padding-top: 3px;">' . $entered_sets['output_page_number'] . '</div>';
            $message .= '</div>';
        }

        $message .= '<div style="float: left;width: 65%;/*margin-left: 30px;*/margin-top: 7px;">';
        $date_asap = ($entered_sets['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_sets['shipp_time'] : '';
        $message .= '<span style="font-weight: bold;">When Needed:  </span>' . $entered_sets['shipp_date'] . $date_asap;
        $message .= '</div>';
        if ($entered_sets['delivery_type'] != '0') {
            $message .= '<div style="width: 100%;float: left;/*margin-left: 30px;*/margin-top: 7px;">';
            $message .= '<span style="font-weight: bold;">Send Via: </span>';
            $message .= '</div>';
            $message .= '<div style="width: 100%;float: left;/*margin-left: 30px;*/margin-top: 7px;">';
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
            $message .= '<div style="width: 100%;float: left;/*margin-left: 30px;*/margin-top: 7px;">';
            $message .= '<span style="font-weight: bold;">Send Via: </span>';
            $message .= '</div>';
            $message .= '<div style="width: 100%;float: left;/*margin-left: 30px;*/margin-top: 7px;">';
            $message .= 'SOHO TO ARRANGE DELIVERY</div>';
        }
        $message .= '</div></div>';
        $r++;
    }
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
    //unset($_SESSION['ref_val']);
    echo '1';
}elseif($_POST['delete_upload_files'] == '9'){
    $user_session_comp      = $_SESSION['sohorepro_companyid'];
    $user_session           = $_SESSION['sohorepro_userid'];
    $file_name              = str_replace(' ','-',strtolower($_POST['file_name']));;
    
    $delete_sql = "DELETE FROM sohorepro_upload_files_set WHERE file_name = '" . $file_name . "' AND comp_id = '".$user_session_comp."' AND user_id = '".$user_session."' AND order_id = '0' ";
    mysql_query($delete_sql);
    echo '1';
}elseif($_POST['recipients'] == '19'){

    $user_session_comp  =   $_SESSION['sohorepro_companyid'];
    $user_session       =   $_SESSION['sohorepro_userid'];
    
    $entered_needed_sets = NeededSets($user_session_comp, $user_session);
	
    $number_of_sets_19      = EnteredPlotttingPrimary19($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $rem_avl_options_19     = AvlOptionsRemaining19($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $last_order_id          = LastOrderId($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    
    echo $number_of_sets_19['needed'] . '~' . $rem_avl_options_19['entered'] . '~'. $last_order_id.'~';
	
    if(count($entered_needed_sets) > 0){ 
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
        $number_of_sets     = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
        ?>
		<div style="width: 100%;float: left;border: 0px #F99B3E solid;margin-bottom: 5px;color: #FA8526;">            
			<div style="width: 15%;float: left;text-align: left;font-weight: bold;font-size: 15px;">OPTION <?php echo $entered_sets['option_id']; ?></div>
			<div style="width: 48%;float: left;text-align: left;font-weight: bold;font-size: 15px;"><?php echo $entered_sets['option_id'] . '&nbsp;of&nbsp;' . count($number_of_sets); ?></div>
		</div>
            <div id="dynamic_edit_<?php echo $entered_sets['id']; ?>" style="border: 2px #F99B3E solid;padding-bottom: 20px;margin-bottom : 5px;width: 100%;float: left;" class="shaddows">
            <div style="width: 100%;float: left;margin-top: 10px;">
                <?php
                $recipient_count = ($entered_sets['option_id'] > '1') ? '1' : $r;
                ?>
                <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo $recipient_count; ?></div>
                <div style="float: right;width: 20%;font-weight: bold;">
                    <span title="Edit Recipient" alt="Edit Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;font-weight: bold;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;" onclick="return edit_recipient_dynamic('<?php echo $entered_sets['id']; ?>');">Edit</span>
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
    
    <div style="width:100%;float:left;margin-top: 10px;">
        <hr style="border: 0;border-bottom: 3px dashed #ccc;background: #999;margin-bottom: 10px;">
    </div>
		
		<!-- New Sets -->
		<?php
		$user_id_add_set = $_SESSION['sohorepro_userid'];
		$company_id_view_plot = $_SESSION['sohorepro_companyid'];
		
		$option_id = CheckOptionIdwithRec($company_id_view_plot, $user_id_add_set, $entered_sets['option_id']);	
        
		$sumOfplott_dy = SumOffPlott($option_id[0]['options']);
        $sumOfArch_dy = SumOffArch($option_id[0]['options']);
		
		 		
		$enteredSetsOptionsSets = ($option_id[0]['plot_needed'] != '0') ? $sumOfplott_dy : $sumOfArch_dy;
        if($option_id[0]['print_ea'] != $enteredSetsOptionsSets){  
		?>
		<div style="border: 1px #F99B3E solid;margin-bottom: 20px;padding-bottom: 20px;width: 100%;float: left;">
        <div style="width: 100%;float: left;margin-top: 10px;">
            <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo ($r + 1); ?></div>
            <div style="float: right;width: 20%;font-weight: bold;cursor: pointer;" title="Delete Recipient" alt="Delete Recipient" onclick="return delete_recipient_empty();"><span style="background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;">Delete</span></div>

            <?php
            
            ?>
            <!-- Address Show End -->
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                <div id="sets_grid_new">
                    <table border="1" style="width: 100%;">
                        <tr bgcolor="#F99B3E">
                            <td style="font-weight: bold;">Order Type<?php //echo $entered_sets['option_id']; ?></td>
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
											
                        $enteredPlot = EnteredPlotRecipientsCurrentOption($option_id[0]['id']);
//                        echo '<pre>';
//                        print_r($enteredPlot);
//                        echo '</pre>';
                        $i = 1;
                        foreach ($enteredPlot as $entered) {
                            $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                            $binding = $entered['binding'];
                            $folding = $entered['folding'];
                            $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Architectural Copies';
                            $type = ($entered['plot_arch'] == '1') ? '1' : '0';
                            $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1') : EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                            $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']) : ArchSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']);
                            $plot_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1');
                            $copy_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');

                            if ($entered['plot_arch'] == '1') {
                                ?>
                                <input type="hidden" id="option_id_<?php echo $entered['options']; ?>" value="<?php echo $entered['options']; ?>" />
                                <input type="hidden" id="option_type_<?php echo $entered['options']; ?>" value="<?php echo $type; ?>" />
                                <tr bgcolor="#ffeee1">
                                    <td>Plotting on Bond</td>
                                    <td><?php echo $entered['origininals']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_<?php echo $entered['options']; ?>" class="avl_sets"  value="<?php echo ($entered['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1', '<?php echo $entered['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>', '<?php echo $entered['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_<?php echo $entered['options']; ?>" class="need_sets" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_dy('<?php echo $current_opt['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_dy('<?php echo $entered['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
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
                                <input type="hidden" id="option_id_<?php echo $entered['options']; ?>" value="<?php echo $entered['options']; ?>" />
                                <input type="hidden" id="option_type_<?php echo $entered['options']; ?>" value="<?php echo $type; ?>" />
                                <tr bgcolor="#ffeee1">
                                    <td>Architectural Copies</td>
                                    <td><?php echo $available_order[0]['origininals']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_<?php echo $entered['options']; ?>" class="avl_sets"  value="<?php echo ($entered['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1', '<?php echo $entered['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>', '<?php echo $entered['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_<?php echo $entered['options']; ?>" class="need_sets" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_dy('<?php echo $current_opt['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_dy('<?php echo $entered['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
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
                            <?php 
                            if($entered['pick_up_time'] == 'ASAP'){
                            echo $entered['pick_up']; 
                            }else{
                            echo $entered['pick_up'] . ' ' . $entered['pick_up_time'];     
                            }
                            ?>
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
                <select  name="address_book_rp" id="address_book_rp_<?php echo $entered['options']; ?>" style="width: 75% !important;" onchange="return show_address_dynamic('<?php echo $entered['options']; ?>');">
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
                        <option value="NEW-MULTI" style="font-weight: bold;background-color: #CCC;"><span style="font-weight: bold;">Add New Address</span></option>
                </select>
            </div>
            <!-- Address Show Start -->
            <div id="show_address_<?php echo $entered['options']; ?>" style="float: left;width: 31%;height: 65px !important;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">

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
                                <input type="text" name="shipp_att" id="shipp_att_<?php echo $entered['options']; ?>" value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                                <input type="text" name="contact_ph" id="contact_ph_<?php echo $entered['options']; ?>" onfocus="return contact_phone_dynamic('<?php echo $entered['options']; ?>');"  value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                        <span id="asap_status_<?php echo $entered['options']; ?>" class="asap_orange" onclick="return asap_dynamic('<?php echo $entered['options']; ?>');">ASAP</span> 
                    </div>

                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                        <input class="picker_icon" value="" type="text" name="date_needed" id="date_needed_<?php echo $entered['options']; ?>" style="width: 75px;" onclick="return date_reveal('<?php echo $entered['options']; ?>');" />
                        <input id="time_picker_icon_<?php echo $entered['options']; ?>" value="" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time('<?php echo $entered['options']; ?>');" />
                    </div>

                </div>
            </div>
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;margin-right: 10px;float: left;">
                        <input type="checkbox" name="arrange_del" id="arrange_del_<?php echo $entered['options']; ?>" checked style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="uncheck_delivery_dynamic('<?php echo $entered['options']; ?>');" /><span style="text-transform: uppercase;">Soho to arrange delivery</span>
                    </div>
                </div>
                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;float: left;">
                        <input type="checkbox" name="preffer_del" id="preffer_del_<?php echo $entered['options']; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="check_prefer_delivery_dynamic('<?php echo $entered['options']; ?>');" /><span style="text-transform: uppercase;">Use My Carrier</span>
                    </div>

                    <div id="preffered_info_<?php echo $entered['options']; ?>" style="width: 91%;display: none;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;">
                        <ul>                                       
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery:  </span>
                                    <select  name="delivery_comp" id="delivery_comp_<?php echo $entered['options']; ?>" style="width: 45% !important;" onchange="return show_address_();">                    
                                        <option value="1">Next Day Air</option>
                                        <option value="2">Two Day Air</option>
                                        <option value="3">Three Day Air</option>
                                        <option value="4">Ground</option>
                                    </select>
                                </li>                    
                                <li id="shipp_collection">
                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1_<?php echo $entered['options']; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" onclick="return field_color();" /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2_<?php echo $entered['options']; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" onclick="return field_color();" /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3_<?php echo $entered['options']; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" onclick="return field_color();" /><input type="text" placeholder="Other" name="other_shipp_type" id="other_shipp_type"  onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number_<?php echo $entered['options']; ?>" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>
                            </ul>
                            <!--<li>
                                    <span style="font-weight: bold;">Account #  :</span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>-->
                        </ul>
                    </div>

                </div>
            </div>


            
            <div style="float: left;width:100%;margin-top: 10px;">
                <div style="font-weight: bold;float: left;width:55%;margin-left: 25px;">
                    Special Instructions:  
                </div>
                <div style="float: left;width:40%;text-align: right;">
                    <div style="float:right;margin-right: 12px;">
                        <input id="add_recipients" value="Add Recipient" style="margin-left: 5px;float:left;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="button" onclick="return add_recipients_dynamic('<?php echo $entered['options']; ?>');" />
                    </div>                    
                </div>                
            </div>
            
            
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                <textarea name="spl_recipient" id="spl_recipient_<?php echo $current_opt['options']; ?>" rows="3" cols="18" style="width: 200px;height: 40px;"></textarea>
            </div>

        </div>
    </div>
		<?php } ?>
		
		<!-- New Sets End -->
		<!--<div style="width:100%;float: left;">             
            <div style="float:right;">            
                <input class="<?php echo $con_class; ?>" value="Continue" style="<?php if($con_class != count($remaining_sets)){ ?>display: none;<?php } ?>cursor: pointer;font-size: 12px; padding: 1.5px; width: 135px; margin-right: 14px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;margin-top: -0px !important;" type="button" onclick="return continue_recipient();" />
            </div>
        </div> -->
		
		
		
        <?php
        $r++;
    }
    }
	
	

}elseif($_POST['recipients'] == '4_4'){
    
    $cust_original_order    = EnteredPlotRecipientsMulti($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid'], $_SESSION['ref_val']);
    
//    echo '<pre>';
//    print_r($cust_original_order);
//    echo '</pre>';
    
    
    
    $shipping_id_rec_pre    = explode("_", $_POST['shipping_id_rec']);    
    $shipping_id_rec        = ($shipping_id_rec_pre[0] == "PEVERY") ? $shipping_id_rec_pre[1] : $_POST['shipping_id_rec'];
    
    
    $date_needed            = $_POST['date_needed'];
    $time_needed            = $_POST['time_needed'];
    $spl_recipient          = $_POST['spl_recipient'];

    
    $delivery_type          = $_POST['delivery_type'];
    $bill_number            = $_POST['bill_number'];
    $shipp_comp_1_f         = $_POST['shipp_comp_1_f'];
    $shipp_comp_2_f         = $_POST['shipp_comp_2_f'];
    $shipp_comp_3_f         = $_POST['shipp_comp_3_f'];

    $size_custom_details    = $_POST['size_custom_details'];

    $output_page_details    = $_POST['output_page_details'];

    $attention_to           = $_POST['attention_to'];

    $contact_ph             = $_POST['contact_ph'];
    
    $_SESSION['attention_every']            = $_POST['attention_to'];

    $_SESSION['tel_every']                  = $_POST['contact_ph'];

    $option_id              = $_POST['option_id'];
    
    $delivery_type_option   = $_POST['delivery_type_option'];
    

    foreach ($cust_original_order as $original_order){
        $plot_neede = ($original_order['plot_arch'] == '1') ? $original_order['print_ea'] : '0';
        $arch_neede = ($original_order['plot_arch'] == '1') ? '0' : $original_order['print_ea'];
    $query = "INSERT INTO sohorepro_sets_needed
			SET     comp_id         = '" . $_SESSION['sohorepro_companyid'] . "',
                                usr_id          = '" . $_SESSION['sohorepro_userid'] . "',
                                plot_needed     = '" . $plot_neede . "',
                                size            = '" . $original_order['size'] . "',
                                option_id       = '" . $original_order['options'] . "',  
                                custome_details     = '" . $original_order['custome_details'] . "',
                                output              = '" . $original_order['output'] . "',
                                output_page_number  = '" . $original_order['output_page_number'] . "',
                                media               = '" . $original_order['media'] . "',  
                                binding         = '" . $original_order['binding'] . "',
                                folding         = '" . $original_order['folding'] . "',   
                                arch_needed     = '" . $arch_neede . "',
                                arch_size       = '" . $original_order['size'] . "',
                                arch_output     = '" . $original_order['output'] . "',
                                arch_binding    = '" . $original_order['binding'] . "',
                                arch_folding    = '" . $original_order['folding'] . "',  
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
                                shipp_comp_3    = '" . $shipp_comp_3_f . "',
                                delivery_type_option  = '".$delivery_type_option."' ";
    $sql_result = mysql_query($query);
    }
    
    echo '1';
}elseif($_POST['recipients'] == '77'){    
    $address_book_id    = $_POST['address_book_id'];  
    $option_id          = $_POST['option_id'];
    $get_address = AddressBookCompanySentTo($address_book_id);
    ?>
    <div style="width: 100%;float: left;">
        <ul style="list-style: none;" id="address_container">
            <li><label>Address 1 :</label> <input style="padding:3px;border: 1px solid #000;width: 145px;" type="text" name="address_1" id="address_1" value="<?php echo $get_address[0]['address_1']; ?>" /></li>
            <li><label>Address 2 :</label> <input style="padding:3px;border: 1px solid #000;width: 145px;" type="text" name="address_2" id="address_2" value="<?php echo $get_address[0]['address_2']; ?>" /></li>
            <li><label>Address 3 :</label> <input style="padding:3px;border: 1px solid #000;width: 145px;" type="text" name="address_3" id="address_3" value="<?php echo $get_address[0]['address_3']; ?>" /></li>
            <li><label>City :</label> <input style="padding:3px;border: 1px solid #000;width: 145px;" type="text" name="edit_city" id="edit_city" value="<?php echo $get_address[0]['city']; ?>" /></li>
            <li><label>State :</label> <select name="state" id="edit_state" class="reginput comp_det_view" style="width: 155px;">
                                            <option value="">Select state</option>
                                            <?php
                                            $sel_state = StateAll();
                                            foreach($sel_state as $fth_states) {
                                                ?>
                                            <option <?php if($get_address[0]['state'] == $fth_states['state_id']){ ?> selected="selected" <?php } ?> value="<?php echo $fth_states['state_id']; ?>"><?php echo $fth_states['state_name']; ?></option>
                                            <?php } ?>
                                        </select>
            </li>
            <li><label>Zip :</label> <input style="padding:3px;border: 1px solid #000;width: 145px;" type="text" name="edit_zip" id="edit_zip" value="<?php echo $get_address[0]['zip']; ?>" /></li>
            <input type="hidden" name="edit_address_id" id="edit_address_id" value="<?php echo $address_book_id; ?>" />
            <input type="hidden" name="edit_option_id" id="edit_option_id" value="<?php echo $option_id; ?>" />
        </ul>
    </div>    
<?php
}elseif($_POST['recipients'] == '78'){    
    
    $edit_address_1             =   mysql_real_escape_string($_POST['edit_address_1']);
    $edit_address_2             =   mysql_real_escape_string($_POST['edit_address_2']);
    $edit_address_3             =   mysql_real_escape_string($_POST['edit_address_3']);
    $edit_city                  =   mysql_real_escape_string($_POST['edit_city']);
    $edit_state                 =   mysql_real_escape_string($_POST['edit_state']);
    $edit_zip                   =   mysql_real_escape_string($_POST['edit_zip']);
    $edit_address_id            =   mysql_real_escape_string($_POST['edit_address_id']);    
    $edit_address_option_id     =   mysql_real_escape_string($_POST['edit_address_option_id']);
    
    $query = "UPDATE sohorepro_address_service
			SET     address_1         = '" . $edit_address_1 . "',
                                address_2         = '" . $edit_address_2 . "',
                                address_3         = '" . $edit_address_3 . "',
                                city              = '" . $edit_city . "',
                                state             = '" . $edit_state . "',
                                zip               = '" . $edit_zip . "' WHERE id = '" . $edit_address_id . "' ";

    $sql_result = mysql_query($query);
    
    $shipp_add = SelectIdAddressService($edit_address_id);   
      if($shipp_add != ''){
          $add_1 = ($shipp_add[0]['address_1'] == '') ? '' : $shipp_add[0]['address_1'].', ';
          $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'].', ';
          $add_3 = ($shipp_add[0]['address_3'] == '') ? '' : $shipp_add[0]['address_3'].', ';
      echo $add_1.$add_2.$add_3.$shipp_add[0]['city'].', '.StateName($shipp_add[0]['state']).' '.$shipp_add[0]['zip'];
      }
    
}elseif($_POST['recipients'] == '85'){ 
    
    $edit_address_1_pre             =   mysql_real_escape_string($_POST['address_1']);
    $edit_address_2_pre             =   mysql_real_escape_string($_POST['address_2']);
    $edit_address_3_pre             =   mysql_real_escape_string($_POST['address_3']);
    $edit_city_pre                  =   mysql_real_escape_string($_POST['address_city']);
    $edit_state                     =   mysql_real_escape_string($_POST['address_state_select']);
    $edit_zip_pre                   =   mysql_real_escape_string($_POST['address_zip']);
    $edit_phone_pre                 =   mysql_real_escape_string($_POST['address_phone']);
    $edit_address_id                =   mysql_real_escape_string($_POST['address_id']);  
    
    
    $edit_address_1                 =   ($edit_address_1_pre == 'undefined') ? '' : $edit_address_1_pre;
    $edit_address_2                 =   ($edit_address_2_pre == 'undefined') ? '' : $edit_address_2_pre;
    $edit_address_3                 =   ($edit_address_3_pre == 'undefined') ? '' : $edit_address_3_pre;
    
    $edit_city                      =   ($edit_city_pre == 'undefined') ? '' : $edit_city_pre;
    $edit_zip                       =   ($edit_zip_pre  == 'undefined') ? '' : $edit_zip_pre;
    $edit_phone                     =   ($edit_phone_pre  == 'undefined') ? '' : $edit_phone_pre;
    
    
    $query = "UPDATE sohorepro_address_service
			SET     address_1         = '" . $edit_address_1 . "',
                                address_2         = '" . $edit_address_2 . "',
                                address_3         = '" . $edit_address_3 . "',
                                city              = '" . $edit_city . "',
                                state             = '" . State_Val($edit_state) . "',
                                zip               = '" . $edit_zip . "',
                                phone             = '" . $edit_phone . "'    WHERE id = '" . $edit_address_id . "' ";

    $sql_result = mysql_query($query);
    
    if($sql_result){
        echo '1';
    }
    
}elseif($_POST['recipients'] == '86'){   
        
    $edit_address_1             =   mysql_real_escape_string($_POST['address_1']);
    $edit_address_2             =   mysql_real_escape_string($_POST['address_2']);
    
    $edit_address_3_pre         =   mysql_real_escape_string($_POST['address_3']);
    $edit_address_3             =   ($edit_address_3_pre == '') ? '' : $edit_address_3_pre;
    
    $edit_city                  =   mysql_real_escape_string($_POST['address_city']);
    $edit_state                 =   mysql_real_escape_string($_POST['address_state_select']);
    $edit_zip                   =   mysql_real_escape_string($_POST['address_zip']);
    $company_name               =   mysql_real_escape_string($_POST['company_name']);
    $attention_to               =   mysql_real_escape_string($_POST['attention_to']);
    $phone                      =   mysql_real_escape_string($_POST['phone']);
    
    $edit_address_id            =   mysql_real_escape_string($_POST['address_id']);  
    
    $current_address            =   SelectIdAddressServiceInside($_POST['company_name']);
    
    if(count($current_address) == 0){
    
    $query = "INSERT INTO sohorepro_address_service
			SET     company_name      = '" . $company_name . "',
                                address_1         = '" . $edit_address_1 . "',
                                address_2         = '" . $edit_address_2 . "',
                                address_3         = '" . $edit_address_3 . "',
                                city              = '" . $edit_city . "',
                                state             = '" . $edit_state . "',
                                zip               = '" . $edit_zip . "',
                                attention_to      = '" . $attention_to . "',   
                                phone             = '" . $phone . "',
                                comp_id           = '" . $_SESSION['sohorepro_companyid'] . "' ";

    $sql_result = mysql_query($query);
    
    $address_book_se    = mysql_insert_id();
    
    $select_address     = SelectLastEnteredAddress($address_book_se);
    
    $return_address_1   = ($select_address[0]['address_1'] != '') ? $select_address[0]['address_1'] : '';
    $return_address_2   = ($select_address[0]['address_2'] != '') ? $select_address[0]['address_2'] : '';
    $return_address_3   = ($select_address[0]['address_3'] != '') ? $select_address[0]['address_3'] : '';
    
    $return_address = $return_address_1.$return_address_2.$return_address_3.$select_address[0]['city'].',&nbsp;'.StateName($select_address[0]['state']).'&nbsp;'.$select_address[0]['zip'].'<br>'.$select_address[0]['phone'];
    if($sql_result){
        echo '1~';
        ?>
            <!-- Address 1 Start -->
            <input type="hidden" name="last_entered_add_id" id="last_entered_add_id" value="<?php echo $address_book_se ?>" />
            <div style="width: 100%;float: left;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_1_span_<?php echo $edit_address_id; ?>" onclick="return show_address_recipient_1('<?php echo $edit_address_id; ?>');"><?php echo $return_address_1; ?></span>
            <input style="width: 70%;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_1_<?php echo $edit_address_id; ?>" id="address_1_<?php echo $edit_address_id; ?>" value="<?php echo $return_address_1; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_1_buttons_<?php echo $edit_address_id; ?>">
                <!--<img src="admin/images/like_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Update" title="Update" width="20" height="20" id="1" onclick="return update_address_1('<?php echo $_POST['shipping_id_rp']; ?>');" >-->
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_1('<?php echo $edit_address_id; ?>');" >
            </div>
            </div>
            <!-- Address 1 End -->
            
            <!-- Address 2 Start -->
            <div style="width: 100%;float: left;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_2_span_<?php echo $edit_address_id; ?>" onclick="return show_address_recipient_2('<?php echo $edit_address_id; ?>');"><?php echo $return_address_2; ?></span>
            <input style="width: 70%;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_2_<?php echo $edit_address_id; ?>" id="address_2_<?php echo $edit_address_id ?>" value="<?php echo $return_address_2; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_2_buttons_<?php echo $edit_address_id; ?>">
                <!--<img src="admin/images/like_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Update" title="Update" width="20" height="20" id="1" onclick="return update_address_2('<?php echo $_POST['shipping_id_rp']; ?>');" >-->
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_2('<?php echo $edit_address_id; ?>');" >
            </div>
            </div>
            <!-- Address 2 End -->
            
            <?php if($return_address_3 != ''){?>
            <!-- Address 3 Start -->
            <div style="width: 100%;float: left;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_3_span_<?php echo $edit_address_id ?>" onclick="return show_address_recipient_3('<?php echo $edit_address_id; ?>');"><?php echo $return_address_3; ?></span>
            <input style="width: 70%;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_3_<?php echo $_POST['shipping_id_rp']; ?>" id="address_3_<?php echo $edit_address_id; ?>" value="<?php echo $return_address_3; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_3_buttons_<?php echo $edit_address_id; ?>">
                <!--<img src="admin/images/like_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Update" title="Update" width="20" height="20" id="1" onclick="return update_address_3('<?php echo $edit_address_id; ?>');" >-->
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_3('<?php echo $edit_address_id; ?>');" >
            </div>
            </div>
            <!-- Address 3 End -->
            <?php } ?>
            
            
            
            <div style="width:100%;float: left;font-weight: bold;">
                <span style="font-weight: bold;float: left;cursor: pointer;" id="address_city_span_<?php echo $edit_address_id; ?>" onclick="return show_address_recipient_city('<?php echo $edit_address_id; ?>');"><?php echo $select_address[0]['city']; ?>,&nbsp;</span>
                <input style="display: none;float: left;width: 65px;" type="text" id="address_city_<?php echo $edit_address_id; ?>" value="<?php echo $select_address[0]['city']; ?>" />
                <div style="display: none;float: left;" id="address_city_buttons_<?php echo $edit_address_id; ?>">               
                    <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_city('<?php echo $edit_address_id; ?>');" >
                </div>
                <span style="font-weight: bold;float: left;cursor: pointer;" id="address_state_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_state('<?php echo $address_book_se; ?>');"><?php echo StateName($select_address[0]['state']); ?>&nbsp;</span>
                <select name="state" id="address_state_select_<?php echo $address_book_se; ?>" style="display: none;float: left;margin-left: 5px;">
                    <?php
                $state = StateAll();                
                foreach ($state as $state_val) {
                    if ($state_val['state_abbr'] == StateName($select_address[0]['state'])) {
                        ?>
                        <option value="<?php echo $state_val['state_abbr'] ?>" selected="selected"><?php echo $state_val['state_abbr']; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $state_val['state_abbr']; ?>"><?php echo $state_val['state_abbr']; ?></option>
                        <?php
                    }
                }
                ?>
                </select>
                
                <span style="font-weight: bold;float: left;cursor: pointer;" id="address_zip_span_<?php echo $address_book_se; ?>" onclick="return show_address_recipient_zip('<?php echo $address_book_se; ?>');"><?php echo $select_address[0]['zip']; ?></span>
                <input style="width: 45px;float: left;margin-bottom: 0px;margin-left: 10px;padding: 2px;display: none;"  type="text" name="address_zip_<?php echo $address_book_se; ?>" id="address_zip_<?php echo $address_book_se; ?>" value="<?php echo $select_address[0]['zip']; ?>" />
                <div style="float: left;display: none;" id="address_zip_buttons_<?php echo $address_book_se; ?>">                
                    <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_zip('<?php echo $address_book_se; ?>');" >
                </div>
            </div>
            
            
            
            
            
            
            <!-- City Start -->
<!--            <div style="float: left;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_city_span_<?php echo $edit_address_id; ?>" onclick="return show_address_recipient_city('<?php echo $edit_address_id; ?>');"><?php echo $select_address[0]['city']; ?></span>
            <input style="width: 40% !important;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_city_<?php echo $_POST['shipping_id_rp']; ?>" id="address_city_<?php echo $edit_address_id; ?>" value="<?php echo $select_address[0]['city']; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_city_buttons_<?php echo $edit_address_id; ?>">               
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_city('<?php echo $edit_address_id; ?>');" >
            </div>
            </div>
             City End 
            
            
            <div style="float: left;">
                 State Start 
                <span style="width: 6%;float: left;font-weight: bold;cursor: pointer;" id="address_state_span_<?php echo $edit_address_id; ?>" onclick="return show_address_recipient_state('<?php echo $edit_address_id; ?>');"><?php echo ',&nbsp;'.StateName($select_address[0]['state']); ?></span>            
                <select name="state" id="address_state_select_<?php echo $edit_address_id; ?>" style="width: 40% !important;display: none;float: left;">
                    <?php
                $state = StateAll();                
                foreach ($state as $state_val) {
                    if ($state_val['state_abbr'] == StateName($select_address[0]['state'])) {
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
                <span style="width: 6%;float: left;font-weight: bold;cursor: pointer;margin-left: 22px;" id="address_zip_span_<?php echo $edit_address_id; ?>" onclick="return show_address_recipient_zip('<?php echo $edit_address_id; ?>');"><?php echo $select_address[0]['zip']; ?></span>
                
                <input style="width: 20%;float: left;margin-bottom: 0px;font-size: 12px !important;margin-left: 15px;display: none;"  type="text" name="address_zip_<?php echo $edit_address_id; ?>" id="address_zip_<?php echo $edit_address_id; ?>" value="<?php echo $select_address[0]['zip']; ?>" />
                <div style="width: 20%;float: left;display: none;" id="address_zip_buttons_<?php echo $edit_address_id; ?>">
                    <img src="admin/images/like_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Update" title="Update" width="20" height="20" id="1" onclick="return update_address_city('<?php echo $edit_address_id; ?>');" >
                    <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="17" height="17" id="1" onclick="return cancel_address_zip('<?php echo $edit_address_id; ?>');" >
                </div>
                 ZIP End
            </div>-->
            
            
            <!-- Phone Start -->
            <div style="float: left;width: 100%;">
                <span style="width: 100%;float: left;font-weight: bold;cursor: pointer;" id="address_phone_span_<?php echo $edit_address_id; ?>" onclick="return show_address_recipient_phone('<?php echo $edit_address_id; ?>');"><?php echo $select_address[0]['phone']; ?></span>
            <input style="width: 35%;float: left;margin-top: 4px !important;margin-bottom: 0px;font-size: 12px !important;display: none;"  type="text" name="address_phone_<?php echo $edit_address_id; ?>" id="address_phone_<?php echo $edit_address_id; ?>" value="<?php echo $select_address[0]['phone']; ?>" />
            <div style="width: 20%;float: left;display: none;" id="address_phone_buttons_<?php echo $edit_address_id; ?>">                
                <img src="admin/images/cancel_icon.png" style="float: left;margin-left: 5px;cursor: pointer;" alt="Cancel" title="Cancel" width="20" height="20" id="1" onclick="return cancel_address_phone('<?php echo $edit_address_id; ?>');" >
            </div>
            </div>
            <!-- Phone End -->
        <?php
        echo '~'.$select_address[0]['attention_to'].'~';   
        $address_book_drop = AddressBookCompanyService($_SESSION['sohorepro_companyid']);
        ?>
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
        }      
        
}else{
    echo '0';
}
}elseif($_POST['recipients'] == '501'){
    $edit_id = $_POST['edit_rec_id'];
    ?>
    <div id="optiond_dynamic_<?php echo $edit_id; ?>" style="width:100%;float: left;">
    
    <input type="hidden" name="tot_avl_options" id="tot_avl_options" value="<?php echo count($number_of_sets); ?>" />
    <input type="hidden" name="rem_avl_options" id="rem_avl_options" value="<?php echo count($rem_avl_options); ?>" />
    <div style="margin-bottom: 20px;padding-bottom: 20px;width: 100%;float: left;">
        <div style="width: 100%;float: left;margin-top: 10px;">
            <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo '1'; ?></div>
            <div style="float: right;width: 20%;font-weight: bold;cursor: pointer;" title="Update Recipient" alt="Update Recipient" onclick="return update_recipient_dynamic('<?php echo $edit_id; ?>');"><span style="background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;background: #009C58;">Update</span></div>            
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
                        $enteredPlot = EditNeededSets($company_id_view_plot, $user_id_add_set, $edit_id);
//                        echo '<pre>';
//                        print_r($enteredPlot);
//                        echo '</pre>';
                        $i = 1;
                        foreach ($enteredPlot as $entered) {
                            $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                            $binding = $entered['binding'];
                            $folding = $entered['folding'];
                            $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Architectural Copies';
                            $type = ($entered['plot_arch'] == '1') ? '1' : '0';
                            $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1') : EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                            $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']) : ArchSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']);
                            $plot_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1');
                            $copy_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');

                            
                                ?>
                                <input type="hidden" id="option_id_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['options']; ?>" />
                                <input type="hidden" id="option_type_<?php echo $current_opt['options']; ?>" value="<?php echo $type; ?>" />
                                <tr bgcolor="#ffeee1">
                                    <td>Plotting on Bond</td>
                                    <td><?php echo $entered['origininals']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_<?php echo $current_opt['options']; ?>" class="avl_sets"  value="<?php echo ($entered['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1', '<?php echo $current_opt['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>', '<?php echo $current_opt['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_<?php echo $current_opt['options']; ?>" class="need_sets" value="<?php echo $entered['plot_needed']; ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_dy('<?php echo $current_opt['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_dy('<?php echo $current_opt['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
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
                                <?php echo $entered['output_page_number']; ?>
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
                            <?php 
                            if($entered['pick_up_time'] == 'ASAP'){
                            echo $entered['pick_up']; 
                            }else{
                            echo $entered['pick_up'] . ' ' . $entered['pick_up_time'];     
                            }
                            ?>
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
                    <?php }
                } ?>
                </div>
<!--                <div id="edit_address_<?php echo $current_opt['options']; ?>" style="width:98%;float: left;text-align: right;display: none;">
                    <span style="background: #007F2A;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;cursor: pointer;" onclick="return edit_recipient_address('<?php echo $current_opt['options']; ?>');">EDIT</span>
                </div>-->
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
                <select  name="address_book_rp" id="address_book_rp_<?php echo $edit_id; ?>" style="width: 75% !important;" onclick="return add_prvious_ww('<?php echo $edit_id; ?>');" onchange="return show_address_dynamic('<?php echo $edit_id; ?>');">
                        <option value="0">Address Book</option>
                        <option value="<?php echo $address_book[0]['id']; ?>">Return Everything To My Office</option>
                        <option value="P1">Pickup @ 381 Broome St</option>
                        <option value="P2">Pickup @ 307 7th Ave, 5th Flr</option>
                        <option class="select-dash" disabled="disabled">-----------------------------------------</option>
                    <?php                    
                    foreach ($address_book as $address) {
                        
                        if ($address['id'] == $entered['shipp_id']) {
                                    ?>
                            <option value="<?php echo $address['id']; ?>" selected="selected" ><?php echo $address['company_name']; ?></option>
                            <?php } else {?>
                            <option value="<?php echo $address['id']; ?>" ><?php echo $address['company_name']; ?></option>
                            <?php                             
                            }
                            }
                            ?>
                        <option value="NEW-MULTI" style="font-weight: bold;background-color: #CCC;"><span style="font-weight: bold;">Add New Address</span></option>
                </select>
            </div>
            <!-- Address Show Start -->
            <div id="show_address_<?php echo $edit_id; ?>" style="float: left;width: 40%;height: 80px !important;padding: 6px;border: 1px #F99B3E solid;margin-top: 10px;margin-left: 5px;height: 20px;font-weight: bold;">
                    <?php
            $shipp_add = SelectIdAddressService($entered['shipp_id']);
            $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . ',<br>';
            echo $shipp_add[0]['address_1'] . ',<br>' . $add_2 . $shipp_add[0]['city'] . ',<br>' . StateName($shipp_add[0]['state']) . ' ' . $shipp_add[0]['zip'];
            ?>
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
                                <input type="text" name="shipp_att" id="shipp_att_<?php echo $edit_id; ?>" value="<?php echo $entered['spl_inc'];  ?>" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                                <input type="text" name="contact_ph" id="contact_ph_<?php echo $current_opt['options']; ?>" onfocus="return contact_phone_dynamic('<?php echo $current_opt['options']; ?>');"  value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                        <span id="asap_status_<?php echo $current_opt['options']; ?>" class="asap_orange" onclick="return asap_dynamic('<?php echo $current_opt['options']; ?>');">ASAP</span> 
                    </div>

                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                        <input class="picker_icon" value="<?php echo $entered['shipp_date']; ?>" type="text" name="date_needed" id="date_needed_<?php echo $current_opt['options']; ?>" style="width: 75px;" onclick="return date_reveal('<?php echo $current_opt['options']; ?>');" />
                        <input id="time_picker_icon_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['shipp_time']; ?>" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time('<?php echo $current_opt['options']; ?>');" />
                    </div>

                </div>
            </div>
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;margin-right: 10px;float: left;">
                        <input type="checkbox" name="arrange_del" id="arrange_del_<?php echo $edit_id; ?>" checked style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="uncheck_delivery_dynamic('<?php echo $current_opt['options']; ?>');" /><span style="text-transform: uppercase;">Soho to arrange delivery</span>
                    </div>

                </div>
                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;float: left;">
                        <input type="checkbox" name="preffer_del" id="preffer_del_<?php echo $edit_id; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="check_prefer_delivery_dynamic('<?php echo $current_opt['options']; ?>');" /><span style="text-transform: uppercase;">Use My Carrier</span>
                    </div>

                    <div id="preffered_info_<?php echo $edit_id; ?>" style="width: 91%;display: none;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;">
                        <ul>                                       
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery:  </span>
                                    <select  name="delivery_comp_<?php echo $edit_id; ?>" id="delivery_comp_<?php echo $current_opt['options']; ?>" style="width: 45% !important;" onchange="return show_address_();">                    
                                        <option value="1">Next Day Air</option>
                                        <option value="2">Two Day Air</option>
                                        <option value="3">Three Day Air</option>
                                        <option value="4">Ground</option>
                                    </select>
                                </li>                    
                                <li id="shipp_collection">
                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1_<?php echo $edit_id; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" onclick="return field_color_dynamic('<?php echo $current_opt['options']; ?>');" /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2_<?php echo $edit_id; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" onclick="return field_color_dynamic('<?php echo $current_opt['options']; ?>');" /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3_<?php echo $edit_id; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" onclick="return field_color_dynamic('<?php echo $current_opt['options']; ?>');" /><input type="text" placeholder="Other" name="other_shipp_type" id="other_shipp_type_<?php echo $current_opt['options']; ?>"  onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number_<?php echo $current_opt['options']; ?>" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>
                            </ul>
                            <!--<li>
                                    <span style="font-weight: bold;">Account #  :</span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>-->
                        </ul>
                    </div>

                </div>
            </div>


            
            <div style="float: left;width:100%;margin-top: 10px;">
                <div style="font-weight: bold;float: left;width:55%;margin-left: 25px;">
                    Special Instructions:  
                </div>
                <div style="float: left;width:40%;text-align: right;">
<!--                    <div style="float:right;margin-right: 12px;">
                        <input id="add_recipients" value="Add Recipient" style="margin-left: 5px;float:left;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="button" onclick="return add_recipients_dynamic('<?php echo $current_opt['options']; ?>');" />
                    </div>                    -->
                </div>                
            </div>
            
            
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                <textarea name="spl_recipient" id="spl_recipient_<?php echo $current_opt['options']; ?>" rows="3" cols="18" style="width: 200px;height: 40px;"><?php echo $entered['spl_inc']; ?></textarea>
            </div>

        </div>
    </div>
    </div>  
        
<?php
}elseif($_POST['recipients'] == '502'){
    $shipping_id_rec    = $_POST['shipping_id_rec'];  
    $jumbalakka_id      =   $_POST['jumbalakka_id'];
    $query = "UPDATE sohorepro_sets_needed
			SET     shipp_id        = '" . $shipping_id_rec . "'  WHERE id = '" . $jumbalakka_id . "' ";
    $sql_result = mysql_query($query);    
?>
        <div style="width: 100%;float: left;margin-top: 10px;">
                <?php
                $recipient_count = ($entered_sets['option_id'] > '1') ? '1' : $r;
                ?>
                <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo $recipient_count; ?></div>
                <div style="float: right;width: 20%;font-weight: bold;">
                    <span title="Edit Recipient" alt="Edit Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;font-weight: bold;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;" onclick="return edit_recipient_dynamic('<?php echo $entered_sets['id']; ?>');">Edit</span>
                    <span title="Delete Recipient" alt="Delete Recipient" style="font-weight: bold;cursor: pointer;background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;" onclick="return delete_recipient('<?php echo $entered_sets['id']; ?>');">Delete</span>
                </div>

                <div style="float: left;width: 100%;margin-left: 30px;margin-top: 10px;font-weight: bold;">Send to: </div>
                <div style="float: left;width: 100%;margin-left: 30px;">  
                    <?php
                    $shipp_add = SelectIdAddressService($shipping_id_rec);
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
                        <?php
                        $user_session_comp      =   $_SESSION['sohorepro_companyid'];
                        $user_session           =   $_SESSION['sohorepro_userid'];
                        $entered_needed_sets    =   EditNeededSets($user_session_comp, $user_session, $jumbalakka_id);
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
                                    $number_of_sets     = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
                        ?>
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
                        <?php } ?>
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
        
<?php
}elseif($_POST['recipients'] == '234'){
  
    $user_session_comp  =   $_SESSION['sohorepro_companyid'];
    $user_session       =   $_SESSION['sohorepro_userid'];
    
    $entered_needed_sets = NeededSets($user_session_comp, $user_session);
	
    $number_of_sets_19      = EnteredPlotttingPrimary19($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $rem_avl_options_19     = AvlOptionsRemaining19($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $last_order_id          = LastOrderId($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    
    echo $number_of_sets_19['needed'] . '~' . $rem_avl_options_19['entered'] . '~'. $last_order_id.'~';
	
    if(count($entered_needed_sets) > 0){ 
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
        $number_of_sets     = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
        $total_sets_5 = EnteredPlotttingPrimary1957($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid'], $entered_sets['option_id']);
        $originals      =   CheckOptionIdwithRec($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid'],$entered_sets['option_id']);
        ?>
		<div style="width: 100%;float: left;border: 0px #F99B3E solid;margin-bottom: 5px;color: #FA8526;">            
			<div style="width: 15%;float: left;text-align: left;font-weight: bold;font-size: 15px;">OPTION <?php echo $entered_sets['option_id']; ?></div>
			<div style="width: 48%;float: left;text-align: left;font-weight: bold;font-size: 15px;"><?php echo $entered_sets['option_id'] . '&nbsp;of&nbsp;' . count($number_of_sets); ?></div>
		</div>
    <div id="dynamic_edit_<?php echo $entered_sets['id']; ?>" style="border: 2px #F99B3E solid;padding-bottom: 20px;margin-bottom : 5px;width: 100%;float: left;" class="shaddows">
            <div style="width: 100%;float: left;margin-top: 10px;">
                <?php
                $recipient_count = ($entered_sets['option_id'] > '1') ? '1' : $r;
                ?>
                <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo $recipient_count.'/'.$total_sets_5; ?></div>
                <div style="float: right;width: 20%;font-weight: bold;">
                    <span title="Edit Recipient" alt="Edit Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;font-weight: bold;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;" onclick="return edit_recipient_dynamic('<?php echo $entered_sets['id']; ?>');">Edit</span>
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
                            <td style="font-weight: bold;">Originals</td> 
                            <td style="font-weight: bold;">Order Type</td>                            
                            <td style="font-weight: bold;">Size</td>
                            <td style="font-weight: bold;">Output</td>
                            <td style="font-weight: bold;">Media</td>
                            <td style="font-weight: bold;">Binding</td>
                            <td style="font-weight: bold;">Folding</td>
                        </tr>
                        <tr bgcolor="#ffeee1">
                            <td><?php echo $needen_sets; ?></td>
                            <td><?php echo $originals[0]['origininals']; ?></td>
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
    $test_j_1 =  NeededSetsDynamic($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid'], $entered_sets['option_id']);
    ?>
<!--    <div style="width:100%;float:left;margin-top: 10px;">
        <hr style="border: 0;border-bottom: 3px dashed #ccc;background: #999;margin-bottom: 10px;">        
    </div>-->
    <?php
        $r++;
    }
    }
    
    echo '~';
    
    
    
    

    
   
    $current_option_all = CurrentOptionAll($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
//    $update_allset      =   "UPDATE sohorepro_plotting_set SET all_sets = '1' WHERE id = '".$current_option_all[0]['id']."'";
//    mysql_query($update_allset);
    $current_option     = CurrentOption($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $number_of_sets     = EnteredPlotttingPrimary($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $rem_avl_options    = AvlOptionsRemaining($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $remaining_sets     = RemainingSets($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
    $con_class = 1;
    
    echo $number_of_sets_19['needed'] . '~' . $rem_avl_options_19['entered'] . '~'. $last_order_id.'~';
	$ng = '1';
    foreach ($remaining_sets as $current_opt){
       $rr_options = SumOffPlott($current_opt['options']);
       
       $total_sets_3 = EnteredPlotttingPrimary195($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid'], $current_opt['id']);
       
       if($current_opt['print_ea'] != $rr_options['plott']){
           $serial_new = ($current_opt['recipients_set'] == '0') ? $ng : $r;
           
           $test_j =  NeededSetsDynamic($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid'], $current_opt['options']);
           
           $final_count_jk = (count($test_j) > 0) ? (count($test_j) + 1).'/'.$total_sets_3 : (count($test_j) + 1);
           
       ?>
<?php if(count($test_j) == '0'){ ?>
    <div style="width:100%;float:left;">
        <hr style="border: 0;border-bottom: 3px dashed #ccc;background: #999;margin-bottom: 10px;">
    </div>
<?php } ?>
        <div id="optiond_dynamic_<?php echo $current_opt['options']; ?>" style="width:100%;float: left;">
    <div style="width: 100%;float: left;border: 0px #F99B3E solid;margin-bottom: 5px;color: #FA8526;">            
        <div style="width: 15%;float: left;text-align: left;font-weight: bold;font-size: 15px;">OPTION <?php echo $current_opt['options']; ?></div>
        <div style="width: 48%;float: left;text-align: left;font-weight: bold;font-size: 15px;"><?php echo $current_opt['options'] . '&nbsp;of&nbsp;' . count($number_of_sets); ?></div>
    </div>
    <input type="hidden" name="tot_avl_options" id="tot_avl_options" value="<?php echo count($number_of_sets); ?>" />
    <input type="hidden" name="rem_avl_options" id="rem_avl_options" value="<?php echo count($rem_avl_options); ?>" />
    <div style="border: 1px #F99B3E solid;margin-bottom: 20px;padding-bottom: 20px;width: 100%;float: left;">
        <div style="width: 100%;float: left;margin-top: 10px;">
            <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo $final_count_jk; ?></div>
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
                        $enteredPlot = EnteredPlotRecipientsCurrentOption($current_opt['id']);
//                        echo '<pre>';
//                        print_r($enteredPlot);
//                        echo '</pre>';
                        $i = 1;
                        foreach ($enteredPlot as $entered) {
                            $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                            $binding = $entered['binding'];
                            $folding = $entered['folding'];
                            $order_type = ($entered['plot_arch'] == '1') ? 'Plotting on Bond' : 'Architectural Copies';
                            $type = ($entered['plot_arch'] == '1') ? '1' : '0';
                            $available_order = ($entered['plot_arch'] == '1') ? EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1') : EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');
                            $needed_sets = ($entered['plot_arch'] == '1') ? PlotSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']) : ArchSetsNeededNew($company_id_view_plot, $user_id_add_set, $entered['options']);
                            $plot_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '1');
                            $copy_exist = EnteredPlotRecipientsCount($company_id_view_plot, $user_id_add_set, '0');

                            if ($entered['plot_arch'] == '1') {
                                ?>
                                <input type="hidden" id="option_id_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['options']; ?>" />
                                <input type="hidden" id="option_type_<?php echo $current_opt['options']; ?>" value="<?php echo $type; ?>" />
                                <tr bgcolor="#ffeee1">
                                    <td>Plotting on Bond</td>
                                    <td><?php echo $entered['origininals']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_<?php echo $current_opt['options']; ?>" class="avl_sets"  value="<?php echo ($entered['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1', '<?php echo $current_opt['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>', '<?php echo $current_opt['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_<?php echo $current_opt['options']; ?>" class="need_sets" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_dy('<?php echo $current_opt['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_dy('<?php echo $current_opt['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['size']; ?>" /></td>
                                    <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['output']; ?>" /></td>
                                    <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['media']; ?>" /></td>
                                    <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $binding; ?>" /></td>
                                    <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $folding; ?>" /></td>
                                </tr>
                                <?php
                            }
                            ?>

                            <?php
                            if ($entered['plot_arch'] == '0') {
                                ?>
                                <input type="hidden" id="option_id_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['options']; ?>" />
                                <input type="hidden" id="option_type_<?php echo $current_opt['options']; ?>" value="<?php echo $type; ?>" />
                                <tr bgcolor="#ffeee1">
                                    <td>Architectural Copies</td>
                                    <td><?php echo $available_order[0]['origininals']; ?></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_<?php echo $current_opt['options']; ?>" class="avl_sets"  value="<?php echo ($entered['print_ea'] - $needed_sets); ?>" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '1', '<?php echo $current_opt['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('<?php echo $i; ?>', '<?php echo $user_id_add_set; ?>', '<?php echo $company_id_view_plot; ?>', '<?php echo $type; ?>', '<?php echo $entered['id']; ?>', '<?php echo $current_opt['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_<?php echo $current_opt['options']; ?>" class="need_sets" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_dy('<?php echo $current_opt['options']; ?>');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_dy('<?php echo $current_opt['options']; ?>');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                    <td><?php echo $entered['size']; ?><input type="hidden" name="size_sets_<?php echo $i; ?>" id="size_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['size']; ?>" /></td>
                                    <td><?php echo $entered['output']; ?><input type="hidden" name="output_sets_<?php echo $i; ?>" id="output_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['output']; ?>" /></td>
                                    <td><?php echo $entered['media']; ?><input type="hidden" name="media_sets_<?php echo $i; ?>" id="media_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $entered['media']; ?>" /></td>
                                    <td><?php echo $binding; ?><input type="hidden" name="binding_sets_<?php echo $i; ?>" id="binding_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $binding; ?>" /></td>
                                    <td><?php echo $folding; ?><input type="hidden" name="folding_sets_<?php echo $i; ?>" id="folding_sets_<?php echo $current_opt['options']; ?>" value="<?php echo $folding; ?>" /></td>
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
                    }//if ($entered['plot_arch'] == '0') {
                        if ($entered['pick_up_time'] != '0') {
                            ?>
                            <div style="width: 22%;float: left;border: 1px solid #F99B3E;">
                                <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                    Schedule a Pickup
                                </div>
                                <div style="padding-top: 3px;width: 100%;float: left;">
                                    <input type="hidden" name="pick_up_time" id="pick_up_time" value="<?php echo $entered['pick_up_time']; ?>" />
                            <?php 
                            if($entered['pick_up_time'] == 'ASAP'){
                            echo $entered['pick_up']; 
                            }else{
                            echo $entered['pick_up'] . ' ' . $entered['pick_up_time'];     
                            }
                            ?>
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
                    <?php }
                //} ?>
                </div>
<!--                <div id="edit_address_<?php echo $current_opt['options']; ?>" style="width:98%;float: left;text-align: right;display: none;">
                    <span style="background: #007F2A;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;cursor: pointer;" onclick="return edit_recipient_address('<?php echo $current_opt['options']; ?>');">EDIT</span>
                </div>-->
                <?php
                $all_days_off = AllDayOff();
                foreach ($all_days_off as $days_off_split) {
                    $all_days_in[] = $days_off_split['date'];
                }
                $all_date = implode(",", $all_days_in);
                $all_date_exist = str_replace("/", "-", $all_date);
                ?>

            </div>
            
            <div style="float: left;width: 33%;margin-left: 30px;border: 1px #F99B3E solid;margin-top: 17px;font-weight: bold;padding:3px;">Send to: 
                    <?php 
                    $address_book = AddressBookCompanyService($_SESSION['sohorepro_companyid']);
                    
                    ?>
                <select  name="address_book_rp" id="address_book_rp_<?php echo $current_opt['options']; ?>" style="width: 75% !important;" onclick="return add_prvious('<?php echo ($current_opt['options'] - 1); ?>');" onchange="return show_address_dynamic_nmjk('<?php echo $current_opt['options']; ?>');">
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
                        <option value="NEW-MULTI" style="font-weight: bold;background-color: #CCC;"><span style="font-weight: bold;">Add New Address</span></option>
                </select>
            </div>
            <!-- Address Show Start -->
            <div id="show_address_<?php echo $current_opt['options']; ?>" style="float: left;width: 40%;height: 80px !important;padding: 6px;border: 0px #F99B3E solid;margin-top: 10px;font-weight: bold;">
                
                
                
            
            </div>

            <div id="jumbalakka_nmj_<?php echo $current_opt['options']; ?>" style="float: left;width: 100%;margin-top: 25px;">   
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
                                <input type="text" name="shipp_att" id="shipp_att_<?php echo $current_opt['options']; ?>" value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                                <input type="text" name="contact_ph" id="contact_ph_<?php echo $current_opt['options']; ?>" onfocus="return contact_phone_dynamic('<?php echo $current_opt['options']; ?>');"  value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;" />
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
                        <span id="asap_status_<?php echo $current_opt['options']; ?>" class="asap_orange" onclick="return asap_dynamic('<?php echo $current_opt['options']; ?>');">ASAP</span> 
                    </div>

                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                        <input class="picker_icon" value="" type="text" name="date_needed" id="date_needed_<?php echo $current_opt['options']; ?>" style="width: 75px;" onclick="return date_reveal('<?php echo $current_opt['options']; ?>');" onchange="return update_current_option_jk('<?php echo $current_opt['options']; ?>');" />
                        <input id="time_picker_icon_<?php echo $current_opt['options']; ?>" value="" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time('<?php echo $current_opt['options']; ?>');" />
                    </div>

                </div>
            </div>
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;margin-right: 10px;float: left;">
                        <input type="checkbox" name="arrange_del" id="arrange_del_<?php echo $current_opt['options']; ?>" checked style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="uncheck_delivery_dynamic('<?php echo $current_opt['options']; ?>');" /><span style="text-transform: uppercase;">Soho to arrange delivery</span>
                    </div>

                </div>
                <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                    <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;float: left;">
                        <input type="checkbox" name="preffer_del" id="preffer_del_<?php echo $current_opt['options']; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="check_prefer_delivery_dynamic('<?php echo $current_opt['options']; ?>');" /><span style="text-transform: uppercase;">Use My Carrier</span>
                    </div>

                    <div id="preffered_info_<?php echo $current_opt['options']; ?>" style="width: 91%;display: none;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;">
                        <ul>                                       
                            <ul>
                                <li>
                                    <span style="font-weight: bold;">Delivery:  </span>
                                    <select  name="delivery_comp_<?php echo $current_opt['options']; ?>" id="delivery_comp_<?php echo $current_opt['options']; ?>" style="width: 45% !important;" onchange="return show_address_();">                    
                                        <option value="1">Next Day Air</option>
                                        <option value="2">Two Day Air</option>
                                        <option value="3">Three Day Air</option>
                                        <option value="4">Ground</option>
                                    </select>
                                </li>                    
                                <li id="shipp_collection">
                                    <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_1_<?php echo $current_opt['options']; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx" onclick="return field_color_dynamic('<?php echo $current_opt['options']; ?>');" /><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_2_<?php echo $current_opt['options']; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS" onclick="return field_color_dynamic('<?php echo $current_opt['options']; ?>');" /><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS" /></span>
                                    <span><input type="radio" name="shipp_comp" id="shipp_comp_3_<?php echo $current_opt['options']; ?>" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other" onclick="return field_color_dynamic('<?php echo $current_opt['options']; ?>');" /><input type="text" placeholder="Other" name="other_shipp_type" id="other_shipp_type_<?php echo $current_opt['options']; ?>"  onclick="return other_shipp_type();" style="width: 80px;"></span>
                                </li>
                                <li>
                                    <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number_<?php echo $current_opt['options']; ?>" style="width: 50% !important;margin-bottom: 0px !important;" onkeyup="return update_current_option('<?php echo $current_opt['options']; ?>');" />
                                </li>
                            </ul>
                            <!--<li>
                                    <span style="font-weight: bold;">Account #  :</span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;" />
                                </li>-->
                        </ul>
                    </div>

                </div>
            </div>


            
            <div style="float: left;width:100%;margin-top: 10px;">
                <div style="font-weight: bold;float: left;width:55%;margin-left: 25px;">
                    Special Instructions:  
                </div>
                <div style="float: left;width:40%;text-align: right;">
                    <div style="float:right;margin-right: 12px;">
                        <input id="add_recipients" value="Add Recipient" style="margin-left: 5px;float:left;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="button" onclick="return add_recipients_dynamic('<?php echo $current_opt['options']; ?>','<?php echo $current_opt['id']; ?>');" />
                    </div>                    
                </div>                
            </div>
            
            
            <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                <textarea name="spl_recipient" id="spl_recipient_<?php echo $current_opt['options']; ?>" rows="3" cols="18" style="width: 200px;height: 40px;" onkeyup="return update_current_option('<?php echo $current_opt['options']; ?>');"></textarea>
            </div>

        </div>
    </div>
    </div>

    <?php
    $con_class++;
    }
}
    
}elseif ($_POST['recipients'] == '95') {
    
    $one_more_set_id = $_POST['one_more_set_id'];
    
    $sql_last_id = mysql_query("SELECT print_ea FROM sohorepro_plotting_set WHERE id = '" . $one_more_set_id . "'");
    $object_last_id = mysql_fetch_assoc($sql_last_id);
    $last_id = $object_last_id['print_ea'] + 1;


    $sql_3 = "UPDATE sohorepro_plotting_set SET print_ea = '" . $last_id . "' WHERE id = '" . $one_more_set_id . "' ";
    mysql_query($sql_3);
}elseif($_POST['recipients'] == '786'){
    
    
     $cust_original_order    = EnteredPlotRecipientsMulti($_SESSION['sohorepro_companyid'],$_SESSION['sohorepro_userid'], $_SESSION['ref_val']);
  
     
    
    $shipping_id_rec_pre    = explode("_", $_POST['shipping_id_rec']);    
    $shipping_id_rec        = ($shipping_id_rec_pre[0] == "PEVERY") ? $shipping_id_rec_pre[1] : $_POST['shipping_id_rec'];
    
    $pickup_soho_add        = 'P'.$_POST['pickup_soho_add'];  
    $date_needed            = $_POST['date_needed'];
    $time_needed            = $_POST['time_needed'];
    $spl_recipient          = $_POST['spl_recipient'];    
    
    $delivery_type_option   = $_POST['delivery_type_option'];
    
    $_SESSION['pickup_from_soho_add'] = $_POST['pickup_soho_add'];
    
    foreach ($cust_original_order as $original_order){
        $plot_neede = ($original_order['plot_arch'] == '1') ? $original_order['print_ea'] : '0';
        $arch_neede = ($original_order['plot_arch'] == '1') ? '0' : $original_order['print_ea'];
    $query = "INSERT INTO sohorepro_sets_needed
			SET     comp_id         = '" . $_SESSION['sohorepro_companyid'] . "',
                                usr_id          = '" . $_SESSION['sohorepro_userid'] . "',
                                plot_needed     = '" . $plot_neede . "',
                                size            = '" . $original_order['size'] . "',
                                option_id       = '" . $original_order['options'] . "',  
                                custome_details     = '" . $original_order['custome_details'] . "',
                                output              = '" . $original_order['output'] . "',
                                output_page_number  = '" . $original_order['output_page_number'] . "',
                                media               = '" . $original_order['media'] . "',  
                                binding         = '" . $original_order['binding'] . "',
                                folding         = '" . $original_order['folding'] . "',   
                                arch_needed     = '" . $arch_neede . "',
                                arch_size       = '" . $original_order['size'] . "',
                                arch_output     = '" . $original_order['output'] . "',
                                arch_binding    = '" . $original_order['binding'] . "',
                                arch_folding    = '" . $original_order['folding'] . "',  
                                shipp_id        = '" . $pickup_soho_add . "',
                                attention_to    = '',
                                contact_ph      = '',    
                                shipp_date      = '" . $date_needed . "',
                                shipp_time      = '" . $time_needed . "',    
                                spl_inc         = '" . $spl_recipient . "',
                                delivery_type   = '',
                                billing_number  = '',
                                shipp_comp_1    = '',
                                shipp_comp_2    = '',
                                shipp_comp_3    = '',
                                delivery_type_option  = '".$delivery_type_option."' ";
    $sql_result = mysql_query($query);
    }
    
    echo '1';
}
?>