<?php
include './admin/config.php';
include './admin/db_connection.php';

$job_reference_id = '41';
?>
<!DOCTYPE html>
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

            // Ribbon Style

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
        </style>   
    </head>   
    <body>
        <?php
        $user_session_comp = $_SESSION['sohorepro_companyid'];
        $user_session = $_SESSION['sohorepro_userid'];
        $entered_needed_sets = SetsOrderedFinalize($job_reference_id);
        $total_sets = SetsOrderedFinalizeCountOfSets($job_reference_id);
        $upload_file_exist = UploadFileExistFinalize($user_session_comp, $user_session, $job_reference_id);
        ?>
        
        <div style="width:60%;float: left;border: 5px #F99B3E solid;padding: 15px;">
        <div style="float: left;margin-top: 12px;margin-bottom: 20px;" class="shaddows">
            <div class="ribbon" id="ribbon_final"><span style="background: #79A70A !important;">ORIGINAL</span></div>
            <div style="width: 100%;float: left;margin-top: 25px;margin-bottom: 10px;">
                <div class="details_div">

                    <!-- Customer Details Start -->
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">Customer Details :</div>

                    <div style="float: left;width: 33%;margin-left: 30px;">  
                        <?php
                        $cust_add = getCustomeInfo($user_session_comp);
                        $cust_add_2 = ($cust_add[0]['comp_business_address2'] != '') ? $cust_add[0]['comp_business_address2'] . ',<br>' : '';
                        echo $cust_add[0]['comp_name'] . '<br>' . $cust_add[0]['comp_business_address1'] . ',<br>' . $cust_add_2 . $cust_add[0]['comp_city'] . ',&nbsp;' . $cust_add[0]['comp_state'] . '&nbsp;' . $cust_add[0]['comp_zipcode'];
                        ?>                   
                    </div>                
                    <!-- Customer Details End -->                    

                    <!-- Customer User Details Start -->
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">User Details :</div>

                    <div style="float: left;width: 33%;margin-left: 30px;">  
                        <?php
                        $cust_user_add = UserLoginDtls($user_session);
                        $cust_user_name = $cust_user_add[0]['cus_fname'] . '&nbsp;' . $cust_user_add[0]['cus_lname'];
                        $cust_mail_id = $cust_user_add[0]['cus_email'];
                        $cust_phone_num = $cust_user_add[0]['cus_contact_phone'];
                        echo $cust_user_name . '<br>' . $cust_mail_id . '<br>' . $cust_phone_num . '<br>Date :' . date('m-d-Y h:i A', time());
                        ?>                   
                    </div>                
                    <!-- Customer User Details End --> 


                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>
                    <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                        <?php
                        $cust_original_order = SetsOrderedFinalize($job_reference_id);
                        $cust_original_order_final = SetsOrderedFinalizeOriginal($job_reference_id);
                        $total_plot_needed = SetsOrderedFinalizeCountOfSets($job_reference_id);
                        $cust_needed_sets = ($cust_original_order[0]['print_ea'] != '0') ? $cust_original_order[0]['print_ea'] : $cust_original_order[0]['arch_needed'];
                        $cust_order_type = ($cust_original_order[0]['arch_needed'] != '0') ? 'Copies' : 'Plotting on Bond';
                        ?>
                        <table border="0" style="width: 100%;">
                            <tr bgcolor="#BFC5CD">
                                <td style="font-weight: bold;">Sets</td> 
                                <td style="font-weight: bold;">Order Type</td>                            
                                <td style="font-weight: bold;">Size</td>
                                <td style="font-weight: bold;">Output</td>
                                <td style="font-weight: bold;">Binding</td>
                                <td style="font-weight: bold;">Folding</td>
                            </tr>
                            <tr bgcolor="#F8F8F8">
                                <td><?php echo $total_plot_needed[0]['total_sets']; ?></td>
                                <td><?php echo $cust_order_type; ?></td>                            
                                <td><?php echo $cust_original_order[0]['size']; ?></td>
                                <td><?php echo $cust_original_order[0]['output']; ?></td>
                                <td><?php echo $cust_original_order[0]['binding']; ?></td>
                                <td><?php echo $cust_original_order[0]['folding']; ?></td>
                            </tr>
                        </table>

                    </div>

                    <?php
                    if ($cust_original_order[0]['size'] == 'Custom') {
                        ?>
                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                            <div style="font-weight: bold;width: 100%;float: left;">
                                Custom Size Details :
                            </div>
                            <div style="padding-top: 3px;">                    
                                <?php echo $cust_original_order[0]['custome_details']; ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php
                    if ($cust_original_order[0]['output'] == 'Both') {
                        ?>
                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                            <div style="font-weight: bold;width: 100%;float: left;">
                                Page Number :
                            </div>
                            <div style="padding-top: 3px;">                    
                                <?php echo $cust_original_order[0]['output_page_number']; ?>  
                            </div>
                        </div>
                    <?php } ?>

                    <?php
                    if (($cust_original_order_final[0]['pick_up'] != '0') || ($cust_original_order_final[0]['drop_off'] != '0') || ($cust_original_order_final[0]['ftp_link'] != '0')) {
                        ?>
                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">File Options :</div>
                        <?php
                    }
                    ?>
                    <?php if ($cust_original_order_final[0]['pick_up'] != '0') { ?>                                          
                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                            Pick up : <?php echo $cust_original_order_final[0]['pick_up']; ?>
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                    if ($cust_original_order_final[0]['drop_off'] != '0') {
                        ?>
                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                            Drop off at Soho Repro : <?php echo $cust_original_order_final[0]['drop_off']; ?>
                        </div>
                        <?php
                    }
                    ?>

                    <?php if ($cust_original_order_final[0]['ftp_link'] != '0') { ?>
                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;font-weight:bold;">
                            Provide Link to File
                        </div>

                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                            FTP Link : <?php echo $cust_original_order_final[0]['ftp_link']; ?>
                        </div>

                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                            User Name : <?php echo $cust_original_order_final[0]['user_name']; ?>
                        </div>

                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                            Password : <?php echo $cust_original_order_final[0]['password']; ?>
                        </div>
                        <?php
                    }
                    ?>

                    <?php if (count($upload_file_exist) > 0) { ?>
                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">File Options :</div>  
                        <?php
                        foreach ($upload_file_exist as $files) {
                            ?>                
                            <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                                <?php echo $files['file_name']; ?>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <?php
                    if ($cust_original_order_final[0]['spl_instruction'] != '') {
                        ?>
                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">Special Instructions :</div>
                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                            <?php echo $cust_original_order_final[0]['spl_instruction']; ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        $r = 1;
        foreach ($entered_needed_sets as $entered_sets) {
            if (($entered_sets['shipp_id'] == 'P1') && ($entered_sets['shipp_id'] == 'P2')) {
                $shipp_add = AddressBookPickupSohoCap($entered_sets['shipp_id']);
            } else {
                $shipp_add = SelectIdAddress($entered_sets['shipp_id']);
            }
            $needed_sets = ($entered_sets['plot_needed'] != '0') ? $entered_sets['plot_needed'] : $entered_sets['arch_needed'];
            $order_type = ($entered_sets['arch_needed'] != '0') ? 'Copies' : 'Plotting on Bond';
            $plot_binding = ($entered_sets['binding'] == '0') ? '' : ',' . $entered_sets['binding'];
            $plot_folding = ($entered_sets['folding'] == '0') ? '' : ',' . $entered_sets['folding'];
            $arch_binding = ($entered_sets['arch_binding'] == '0') ? '' : ',' . $entered_sets['arch_binding'];
            $arch_folding = ($entered_sets['arch_folding'] == '0') ? '' : ',' . $entered_sets['arch_folding'];
            ?> 
            <div style="float: left;" class="shaddows">
                <div class="ribbon" id="ribbon_final"><span>RECIPIENT <?php echo $r; ?></span></div>
                <div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;"> 
                    <div class="details_div">
                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 25px;font-weight: bold;">Send to :</div>
                        <div style="float: left;width: 33%;margin-left: 30px;">  
                            <?php
                            if (($entered_sets['shipp_id'] != 'P1') && ($entered_sets['shipp_id'] != 'P2')) {
                                $add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . ',<br>';
                                echo $shipp_add[0]['company_name'] . '<br>' . $shipp_add[0]['address_1'] . ',<br>' . $add_2 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'] . '<br>' . 'Attention To : ' . $entered_sets['attention_to'];
                            } else {                    //echo $shipp_add[0]['address'];                        
                                $shipp_add_p = AddressBookPickupSohoCap($entered_sets['shipp_id']);
                                echo $shipp_add_p[0]['address'];
                            }
                            ?>                   
                        </div>
                        <!-- Address Show End -->

                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>
                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">

                            <table border="0" style="width: 100%;">
                                <tr bgcolor="#BFC5CD">
                                    <td style="font-weight: bold;">Sets</td> 
                                    <td style="font-weight: bold;">Order Type</td>                            
                                    <td style="font-weight: bold;">Size</td>
                                    <td style="font-weight: bold;">Output</td>
                                    <td style="font-weight: bold;">Binding</td>
                                    <td style="font-weight: bold;">Folding</td>
                                </tr>
                                <tr bgcolor="#F8F8F8">
                                    <td><?php echo $needed_sets; ?></td>
                                    <td><?php echo $order_type; ?></td>                            
                                    <td><?php echo $entered_sets['size']; ?></td>
                                    <td><?php echo $entered_sets['output']; ?></td>
                                    <td><?php echo $entered_sets['binding']; ?></td>
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
                                <div style="padding-top: 3px;">                    
                                    <?php echo $entered_sets['custome_details']; ?>
                                </div>
                            </div>
                        <?php } ?>

                        <?php
                        if ($entered_sets['output'] == 'Both') {
                            ?>
                            <div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
                                <div style="font-weight: bold;width: 100%;float: left;">
                                    Page Number :
                                </div>
                                <div style="padding-top: 3px;">                    
                                    <?php echo $entered_sets['output_page_number']; ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;">
                            <?php
                            $date_asap = ($entered_sets['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_sets['shipp_time'] : '';
                            ?>
                            <span style="font-weight: bold;">When Needed : </span><?php echo $entered_sets['shipp_date'] . $date_asap; ?>            
                        </div>        
                        <?php
                        if ($entered_sets['delivery_type'] != '0') {
                            ?>
                            <div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
                                <span style="font-weight: bold;">Send Via :</span>
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
                                <span style="font-weight: bold;">Send Via :</span>
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
        ?>
</div>
    </body>
</html>
