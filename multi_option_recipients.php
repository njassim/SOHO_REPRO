<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Multi Options Recipients</title>       
        <script src="admin/js/jquery.min.js"></script>
        <script>
            function first_to_last()
            {
                $("#option_1").animate({"z-index": "1", "top": "55px", "left": "40px"});
                $("#option_2").animate({"z-index": "2", "top": "-550px"});
            }
            function last_to_first()
            {                
                $("#option_1").animate({"z-index": "2", "top": "0px", "left": "0px"});
                $("#option_2").animate({"z-index": "1", "top": "-550px", "left": "20px"});
            }
        </script>
    </head>
    <body>
<!--        <div id="option_1" style="position:relative;width: 70%;float: left;cursor: pointer;background-color: green;z-index:2;" onclick="return last_to_first();">
            <div style="width: 100%;float: left;height: 90%;font-size:50px;text-align: center;">PLOTTING</div>
            <div style="width: 100%;float: left;height: 10%;font-size:15px;text-align: right;margin-right: 10px;">OPTION - 1</div>
        </div>
        <div id="option_2" style="position:relative;width: 70%;float: left;cursor: pointer;background-color: red;z-index:1;top: -55px;left: 10px;" onclick="return first_to_last();">
            <div style="width: 100%;float: left;height: 90%;font-size:50px;text-align: center;">ARCHITECTURE
            </div>
            <div style="width: 100%;float: left;height: 10%;font-size:15px;text-align: right;margin-right: 10px;">OPTION - 2</div>            
        </div> -->

        <div id="option_1" style="cursor: pointer;position:relative;border: 1px #F99B3E solid;margin-bottom: 0px;padding-bottom: 0px;width: 90%;background-color:#FFEEE1;float: left;z-index:2;" onclick="return last_to_first();">
            <div style="width: 100%;float: left;margin-top: 10px;">
                <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT 1</div>
                <div style="float: right;width: 20%;font-weight: bold;cursor: pointer;" title="Delete Recipient" alt="Delete Recipient" onclick="return delete_recipient_empty();"><span style="background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;">Delete</span></div>

                <!-- Address Show End -->
                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    <div id="sets_grid_new">
                        <table border="1" style="width: 100%;">
                            <tbody><tr bgcolor="#F99B3E">
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
                                                        <!-- <tr bgcolor="#ffeee1">
                                        <td>Plotting on Bond</td>
                                        <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_1" class="avl_sets" id="avl_sets_1"  value="2" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl('1', '96', '2', '1', '1');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('1', '96', '2', '1', '1');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                        <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_1" class="need_sets" id="need_sets_1" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('1');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('1');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                        <td>Custom<input type="hidden" name="size_sets_1" id="size_sets_1" value="Custom" /></td>
                                        <td>Both<input type="hidden" name="output_sets_1" id="output_sets_1" value="Both" /></td>
                                        <td>SCREW POST<input type="hidden" name="binding_sets_1" id="binding_sets_1" value="SCREW POST" /></td>
                                        <td>YES<input type="hidden" name="folding_sets_1" id="folding_sets_1" value="YES" /></td>
                                    </tr>-->
                                <tr bgcolor="#ffeee1">
                                    <td>Plotting on Bond</td>
                                    <td>1</td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_1" class="avl_sets" value="2"><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '96', '2', '1');" title="Increase Quantity" alt="Increase Quantity"><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('1', '96', '2', '1', '1');" title="Decrease Quantity" alt="Decrease Quantity"></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_1" class="need_sets" value="1"><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('1');" title="Increase Quantity" alt="Increase Quantity"><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('1');" title="Decrease Quantity" alt="Decrease Quantity"></div></td>
                                    <td>Custom<input type="hidden" name="size_sets_1" id="size_sets_1" value="Custom"></td>
                                    <td>Both<input type="hidden" name="output_sets_1" id="output_sets_1" value="Both"></td>
                                    <td>Mylar<input type="hidden" name="media_sets_1" id="media_sets_1" value="Mylar"></td>
                                    <td>SCREW POST<input type="hidden" name="binding_sets_1" id="binding_sets_1" value="SCREW POST"></td>
                                    <td>YES<input type="hidden" name="folding_sets_1" id="folding_sets_1" value="YES"></td>
                                </tr>


                            </tbody></table>
                    </div>

                    <div style="width: 99%;float: left;margin-top: 5px;">
                        <div style="width: 22%;float: left;border: 1px solid #F99B3E;margin-right: 10px;">
                            <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                Custom Size Details
                            </div>
                            <div style="padding-top: 3px;width: 100%;float: left;">
                                <input type="hidden" name="size_custom_details" id="size_custom_details" value="12x12">
                                12x12                            </div>
                        </div>
                        <div style="width: 22%;float: left;border: 1px solid #F99B3E;margin-right: 10px;">
                            <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                Color Page Numbers
                            </div>
                            <div style="padding-top: 3px;width: 100%;float: left;">
                                <input type="hidden" name="output_page_details" id="output_page_details" value="1,2">
                                1,2                            </div>
                        </div>

                        <div style="width: 22%;float: left;border: 1px solid #F99B3E;margin-right: 10px;">
                            <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                Special Instructions
                            </div>
                            <div style="padding-top: 3px;width: 100%;float: left;">
                                <input type="hidden" name="spl_instruction" id="spl_instruction" value="Monday Test">
                                Monday Test                            </div>
                        </div>
                    </div>


                </div>

                <div style="float: left;width: 33%;margin-left: 30px;border: 1px #F99B3E solid;margin-top: 10px;font-weight: bold;padding:3px;">Send to: 
                    <select name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return show_address();">
                        <option value="0">Address Book</option>

                        <option value="2">138-142 Reade Street</option>

                        <option value="1232">Colan Test Co</option>

                        <option value="1236">Soho Repro 1</option>

                        <option value="1240">Jassim Co</option>

                        <option value="1242">Thani Oruvan</option>

                        <option value="1243">Jumbalakk</option>

                        <option value="1244">Toys R Us</option>

                        <option value="1245">Toys R Us</option>
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
                                    <input type="text" name="shipp_att" id="shipp_att" value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;">
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
                                    <input type="text" name="contact_ph" id="contact_ph" onfocus="return contact_phone();" value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Contact Phone End -->
                </div>

                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    <input type="hidden" name="all_exist_date" id="all_exist_date" value="8-27-2015,8-3-2015,3-25-2015,5-25-2015,3-31-2015">
                    <div style="float:left;margin-right: 5px;margin-top: 10px;width: 100%;">
                        <span style="font-weight: bold;">When Needed:  </span>
                    </div>
                    <div style="width: 34%;float: left;"> 

                        <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;border-bottom: 0px;text-align: center;">
                            <span id="asap_status" class="asap_orange" onclick="return asap();">ASAP</span> 
                        </div>

                        <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                            <input class="picker_icon" value="" type="text" name="date_needed" id="date_needed" style="width: 75px;" onclick="date_reveal();">
                            <input id="time_picker_icon" value="" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time();">
                        </div>

                    </div>
                </div>
                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                    <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                        <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;margin-right: 10px;float: left;">
                            <input type="checkbox" name="arrange_del" id="arrange_del" checked="" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="uncheck_delivery();"><span style="text-transform: uppercase;">Soho to arrange delivery</span>
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
                            <input type="checkbox" name="preffer_del" id="preffer_del" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="check_prefer_delivery();"><span style="text-transform: uppercase;">Use My Carrier</span>
                        </div>

                        <div id="preffered_info" style="width: 91%;display: none;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;">
                            <ul>                                       
                                <ul>
                                    <li>
                                        <span style="font-weight: bold;">Delivery:  </span>
                                        <select name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address_();">                    
                                            <option value="1">Next Day Air</option>
                                            <option value="2">Two Day Air</option>
                                            <option value="3">Three Day Air</option>
                                            <option value="4">Ground</option>
                                        </select>
                                    </li>                    
                                    <li id="shipp_collection">
                                        <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                        <span><input type="radio" name="shipp_comp" id="shipp_comp_1" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx"><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx"></span>
                                        <span><input type="radio" name="shipp_comp" id="shipp_comp_2" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS"><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS"></span>
                                        <span><input type="radio" name="shipp_comp" id="shipp_comp_3" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other"><input type="text" placeholder="Other" name="other_shipp_type" id="other_shipp_type" onclick="return other_shipp_type();" style="width: 80px;"></span>
                                    </li>
                                    <li>
                                        <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;">
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
                <div style="width: 100%;float: left;height: 10%;font-size:15px;text-align: right;margin-right: 10px;">PLOTTING OPTION - 1</div>
            </div>
            
        </div>
        <div id="option_2" style="cursor: pointer;position:relative;border: 1px #F99B3E solid;margin-bottom: 0px;padding-bottom: 0px;width: 90%;float: left;background-color: #FFEEE1;z-index:1;top: -550px;left: 20px;" onclick="return first_to_last();">
            <div style="width: 100%;float: left;margin-top: 10px;">
                <div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT 1</div>
                <div style="float: right;width: 20%;font-weight: bold;cursor: pointer;" title="Delete Recipient" alt="Delete Recipient" onclick="return delete_recipient_empty();"><span style="background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;">Delete</span></div>

                <!-- Address Show End -->
                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    <div id="sets_grid_new">
                        <table border="1" style="width: 100%;">
                            <tbody><tr bgcolor="#F99B3E">
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
                                                        <!-- <tr bgcolor="#ffeee1">
                                        <td>Plotting on Bond</td>
                                        <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_1" class="avl_sets" id="avl_sets_1"  value="2" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl('1', '96', '2', '1', '1');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('1', '96', '2', '1', '1');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                        <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_1" class="need_sets" id="need_sets_1" value="1" /><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('1');" title="Increase Quantity" alt="Increase Quantity" /><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('1');" title="Decrease Quantity" alt="Decrease Quantity" /></div></td>
                                        <td>Custom<input type="hidden" name="size_sets_1" id="size_sets_1" value="Custom" /></td>
                                        <td>Both<input type="hidden" name="output_sets_1" id="output_sets_1" value="Both" /></td>
                                        <td>SCREW POST<input type="hidden" name="binding_sets_1" id="binding_sets_1" value="SCREW POST" /></td>
                                        <td>YES<input type="hidden" name="folding_sets_1" id="folding_sets_1" value="YES" /></td>
                                    </tr>-->
                                <tr bgcolor="#ffeee1">
                                    <td>Plotting on Bond</td>
                                    <td>1</td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="avl_sets_8" id="avl_sets_1" class="avl_sets" value="2"><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty_avl_plot('8', '96', '2', '1');" title="Increase Quantity" alt="Increase Quantity"><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty_avl('1', '96', '2', '1', '1');" title="Decrease Quantity" alt="Decrease Quantity"></div></td>
                                    <td><input style="width: 25px;float: left;padding: 2px;" type="text" name="need_sets_8" id="need_sets_1" class="need_sets" value="1"><div class="increse_act"><img src="images/plus_icon.png" style="cursor: pointer;" onclick="return increase_qty('1');" title="Increase Quantity" alt="Increase Quantity"><img src="images/minus_icon.png" style="cursor: pointer;" onclick="return decrease_qty('1');" title="Decrease Quantity" alt="Decrease Quantity"></div></td>
                                    <td>Custom<input type="hidden" name="size_sets_1" id="size_sets_1" value="Custom"></td>
                                    <td>Both<input type="hidden" name="output_sets_1" id="output_sets_1" value="Both"></td>
                                    <td>Mylar<input type="hidden" name="media_sets_1" id="media_sets_1" value="Mylar"></td>
                                    <td>SCREW POST<input type="hidden" name="binding_sets_1" id="binding_sets_1" value="SCREW POST"></td>
                                    <td>YES<input type="hidden" name="folding_sets_1" id="folding_sets_1" value="YES"></td>
                                </tr>


                            </tbody></table>
                    </div>

                    <div style="width: 99%;float: left;margin-top: 5px;">
                        <div style="width: 22%;float: left;border: 1px solid #F99B3E;margin-right: 10px;">
                            <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                Custom Size Details
                            </div>
                            <div style="padding-top: 3px;width: 100%;float: left;">
                                <input type="hidden" name="size_custom_details" id="size_custom_details" value="12x12">
                                12x12                            </div>
                        </div>
                        <div style="width: 22%;float: left;border: 1px solid #F99B3E;margin-right: 10px;">
                            <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                Color Page Numbers
                            </div>
                            <div style="padding-top: 3px;width: 100%;float: left;">
                                <input type="hidden" name="output_page_details" id="output_page_details" value="1,2">
                                1,2                            </div>
                        </div>

                        <div style="width: 22%;float: left;border: 1px solid #F99B3E;margin-right: 10px;">
                            <div style="padding-top: 3px;font-weight: bold;width: 100%;float: left;background-color: #F99B3E;color: #5C5C5C;text-align: center;">
                                Special Instructions
                            </div>
                            <div style="padding-top: 3px;width: 100%;float: left;">
                                <input type="hidden" name="spl_instruction" id="spl_instruction" value="Monday Test">
                                Monday Test                            </div>
                        </div>
                    </div>


                </div>

                <div style="float: left;width: 33%;margin-left: 30px;border: 1px #F99B3E solid;margin-top: 10px;font-weight: bold;padding:3px;">Send to: 
                    <select name="address_book_rp" id="address_book_rp" style="width: 75% !important;" onchange="return show_address();">
                        <option value="0">Address Book</option>

                        <option value="2">138-142 Reade Street</option>

                        <option value="1232">Colan Test Co</option>

                        <option value="1236">Soho Repro 1</option>

                        <option value="1240">Jassim Co</option>

                        <option value="1242">Thani Oruvan</option>

                        <option value="1243">Jumbalakk</option>

                        <option value="1244">Toys R Us</option>

                        <option value="1245">Toys R Us</option>
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
                                    <input type="text" name="shipp_att" id="shipp_att" value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;">
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
                                    <input type="text" name="contact_ph" id="contact_ph" onfocus="return contact_phone();" value="" style="background-color: #F3FA2F; font-weight: bold; font-size: 20px !important;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Contact Phone End -->
                </div>

                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">
                    <input type="hidden" name="all_exist_date" id="all_exist_date" value="8-27-2015,8-3-2015,3-25-2015,5-25-2015,3-31-2015">
                    <div style="float:left;margin-right: 5px;margin-top: 10px;width: 100%;">
                        <span style="font-weight: bold;">When Needed:  </span>
                    </div>
                    <div style="width: 34%;float: left;"> 

                        <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;border-bottom: 0px;text-align: center;">
                            <span id="asap_status" class="asap_orange" onclick="return asap();">ASAP</span> 
                        </div>

                        <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                            <input class="picker_icon" value="" type="text" name="date_needed" id="date_needed" style="width: 75px;" onclick="date_reveal();">
                            <input id="time_picker_icon" value="" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time();">
                        </div>

                    </div>
                </div>
                <div style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;">

                    <div style="width: 265px;margin-right: 10px;float: left;margin-right: 10px;">

                        <div style="padding: 10px 20px;background: #EFEFEF;border-radius: 5px;width: 225px;margin-right: 10px;float: left;">
                            <input type="checkbox" name="arrange_del" id="arrange_del" checked="" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="uncheck_delivery();"><span style="text-transform: uppercase;">Soho to arrange delivery</span>
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
                            <input type="checkbox" name="preffer_del" id="preffer_del" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px;" onclick="check_prefer_delivery();"><span style="text-transform: uppercase;">Use My Carrier</span>
                        </div>

                        <div id="preffered_info" style="width: 91%;display: none;border: 1px #F99B3E solid;padding: 5px;float: left;margin-left: 5px;margin-top: 5px;">
                            <ul>                                       
                                <ul>
                                    <li>
                                        <span style="font-weight: bold;">Delivery:  </span>
                                        <select name="delivery_comp" id="delivery_comp" style="width: 45% !important;" onchange="return show_address_();">                    
                                            <option value="1">Next Day Air</option>
                                            <option value="2">Two Day Air</option>
                                            <option value="3">Three Day Air</option>
                                            <option value="4">Ground</option>
                                        </select>
                                    </li>                    
                                    <li id="shipp_collection">
                                        <label><span style="font-weight: bold;">Shipping Company:  </span></label>
                                        <span><input type="radio" name="shipp_comp" id="shipp_comp_1" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="FedEx"><img src="images/fedex_small.png" style="border:0px;" title="FedEx" alt="FedEx"></span>
                                        <span><input type="radio" name="shipp_comp" id="shipp_comp_2" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="UPS"><img src="images/ups_small.png" style="border:0px;" title="UPS" alt="UPS"></span>
                                        <span><input type="radio" name="shipp_comp" id="shipp_comp_3" style="width: 10% !important;margin-bottom: 0px;margin-bottom: 0px !important;" value="Other"><input type="text" placeholder="Other" name="other_shipp_type" id="other_shipp_type" onclick="return other_shipp_type();" style="width: 80px;"></span>
                                    </li>
                                    <li>
                                        <span style="font-weight: bold;">Account #: </span> <input type="text" name="bill_number" id="bill_number" style="width: 50% !important;margin-bottom: 0px !important;">
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
            <div style="width: 100%;float: left;height: 10%;font-size:15px;text-align: right;margin-right: 10px;">ARCHITECTURAL OPTION - 2</div>
        </div>
    </body>
</html>