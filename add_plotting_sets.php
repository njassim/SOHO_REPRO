<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);


if ($_POST['service_plotting_add'] == '1') {

    $user_id_add_set = $_SESSION['sohorepro_userid'];
    $company_id_view_plot = $_SESSION['sohorepro_companyid'];

    $job_reference = $_POST['job_reference'];
    $original = $_POST['original'];
    $print_ea = $_POST['print_ea'];
    $size = $_POST['size'];
    $output = $_POST['output'];
    $media = $_POST['media'];
    $binding = $_POST['binding'];
    $folding = $_POST['folding'];
    $plot_arch = $_POST['plot_arch'];
    $special_instruction = $_POST['special_instruction'];
    $size_custom_val = $_POST['size_custom_val'];
    $output_both_val = $_POST['output_both_val'];
    $pickup_date = $_POST['pickup_date'];
    $pickup_time = $_POST['pickup_time'];
    $drop_val = $_POST['drop_val'];
    $ftp_link_val = $_POST['ftp_link_val'];
    $user_name_val = $_POST['user_name_val'];
    $password_val = $_POST['password_val'];
    $size_custom = $_POST['size_custom'];
    
    
    $sql_option_id = mysql_query("SELECT options FROM sohorepro_plotting_set WHERE company_id = '".$company_id_view_plot."' AND user_id = '".$user_id_add_set."' AND order_id = '0' ORDER BY options DESC LIMIT 1");
    $object_option = mysql_fetch_assoc($sql_option_id);

        if (count($object_option['options']) > 0) {
            $options = ($object_option['options'] + 1);
        } 
        else{
            $options = '1';
        }
    

    $query = "INSERT INTO sohorepro_plotting_set
			SET     referece_id     = '" . $job_reference . "',
                                origininals     = '" . $original . "',
                                options         = '" . $options ."',  
                                print_ea        = '" . $print_ea . "',
                                size            = '" . $size . "',
                                custome_details = '" . $size_custom . "',    
                                output          = '" . $output . "',
                                media           = '" . $media . "',
                                binding         = '" . $binding . "',
                                folding         = '" . $folding . "',
                                plot_arch       = '" . $plot_arch . "',
                                spl_instruction = '" . $special_instruction . "',
                                custom_size     = '" . $size_custom_val . "',
                                output_both     = '" . $output_both_val . "',
                                pick_up         = '" . $pickup_date . "', 
                                pick_up_time    = '" . $pickup_time . "',
                                drop_off        = '" . $drop_val . "',
                                ftp_link        = '" . $ftp_link_val . "', 
                                user_name       = '" . $user_name_val . "',
                                password        = '" . $password_val . "',
                                company_id      = '" . $company_id_view_plot . "',
                                user_id         = '" . $user_id_add_set . "' ";
    $sql_result = mysql_query($query);
    $enteredPlotPrimay = EnteredPlotttingPrimary($company_id_view_plot, $user_id_add_set);

    $count_option = count($enteredPlotPrimay) + 1;

    $_SESSION['ref_val'] = $_POST['job_reference'];

    $i = 1;
    foreach ($enteredPlotPrimay as $plot) {
        $job_type = ($plot['plot_arch'] == '1') ? 'Plotting' : 'Architecture';
        $file_upload_exist = UploadFileExist($_SESSION['sohorepro_companyid'], $_SESSION['sohorepro_userid']);
        ?>
        <div class="plot_container" style="width: 100%;float: left;border: 1px #FF7E00 solid;margin-bottom: 20px;">
            <div class="plot_wrap" style="padding: 5px;">
                <div style="width: 100%;float: left;margin-bottom: 10px;">
                    <div style="float: left;width: 45%;font-weight: bold;">Job Option - <?php echo $i; ?></div>
                    <div style="float: left;width: 50%;font-weight: bold;text-align: right;cursor: pointer;" onclick="return delete_added_job(<?php echo $plot['id']; ?>);"><span style="background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;">Delete</span></div>
                </div>
                <ul>
                    <li><label>Job Type </label><p>: <?php echo $job_type; ?></p></li>
                    <li><label>Originals</label><p>: <?php echo $plot['origininals']; ?></p></li>
                    <li><label>Prints of Each</label><p>: <?php echo $plot['print_ea']; ?></p></li>
                    <li><label>Size</label><p>: <?php echo $plot['size']; ?></p></li>
                    <?php $output = ($plot['output'] == 'Both') ? $plot['output'].' <b>B&W and COLOR</b>' : $plot['output']; ?>
                    <li><label>Output</label><p>: <?php echo $output; ?></p></li>
                    <li><label>Media</label><p>: <?php echo $plot['media']; ?></p></li>
                    <li><label>Binding</label><p>: <?php echo $plot['binding']; ?></p></li>
                    <li><label>Folding</label><p>: <?php echo $plot['folding']; ?></p></li>
                </ul>
                <ul>
                    <?php
                    if ($plot['size'] == 'Custom') {
                        ?>
                        <li><label>Custom Size Details </label><p>: <?php echo $plot['custome_details']; ?></p></li>
                    <?php }if ($plot['output'] == 'Both') { ?>
                        <li><label>Color Page Number</label><p>: <?php echo $plot['output_both']; ?></p></li>
                    <?php } ?>
                </ul>
                <div style="width: 100%;float: left;margin-top: 5px;">
                    <div style="float: left;width: 100%;margin-top: 5px;font-weight: bold;">Alternative File Options</div>
                    <?php
                    if ($file_upload_exist[0]['job_id'] != '') {
                        ?>
                        <div style="float: left;width: 100%;">
                            <div style="float: left;width: 100%;text-decoration: underline;">Upload File</div>
                            <?php
                            foreach ($file_upload_exist as $upload_exist) {
                                ?>
                                <div style="float: left;width: 100%;"><?php echo $upload_exist['file_name']; ?></div>
                                <?php
                            }
                            ?>
                        </div>
                    <?php } elseif ($plot['ftp_link'] != '0') {
                            $link       = ($plot['ftp_link'] != '0') ? $plot['ftp_link'] : '';
                            $user_name  = ($plot['user_name'] != '0') ? $plot['user_name'] : '';
                            $password   = ($plot['password'] != '0') ? $plot['password'] : '';
                        ?>
                        <div style="float: left;width: 100%;">
                            <div style="float: left;width: 100%;text-decoration: underline;">Provide Link to File</div>
                            <div style="float: left;width: 100%;">FTP Link  : <?php echo $link; ?></div>
                            <div style="float: left;width: 100%;">User Name : <?php echo $user_name; ?></div>
                            <div style="float: left;width: 100%;">Password  : <?php echo $password; ?></div>
                        </div>
                    <?php } elseif ($plot['pick_up'] != '0') { ?>
                        <div style="float: left;width: 100%;">
                            <div style="float: left;width: 100%;text-decoration: underline;">Schedule a pick up</div>
                            <div style="float: left;width: 100%;">Pickup Date : <?php echo $plot['pick_up']; ?></div>
                            <div style="float: left;width: 100%;">Pickup Time  : <?php echo $plot['pick_up_time']; ?></div>
                        </div>
                    <?php } elseif ($plot['drop_off'] != '0') { ?>
                        <div style="float: left;width: 100%;">
                            <div style="float: left;width: 100%;text-decoration: underline;">Drop off at Soho Repro</div>                       
                            <div style="float: left;width: 100%;">Drop off at : <?php echo $plot['drop_off']; ?></div>
                        </div>   
                    <?php } ?>
                </div>

                <div style="width: 100%;float: left;margin-top: 7px;">                    
                    <div style="float: left;width: 100%;margin-top: 5px;font-weight: bold;">Special Instructions</div>
                    <div style="float: left;width: 100%;">                        
                        <div style="float: left;width: 100%;"><?php echo $plot['spl_instruction']; ?></div>
                    </div> 
                </div>

            </div>
        </div>
        <?php
        $i++;
    }
    ?>
    <!--New Job Add Start -->
    <div class="serviceOrderSetHolder">
        <label style="font-weight: bold; margin-bottom: 0px; margin-top: 0px;" for="jo1" class="optional">
            Job Options 
            <div style="float:right;font-weight: bold;">
                Option - <?php echo $count_option; ?>                            
            </div>
        </label>  
        <div style="background-color:#FFFFFF" class="serviceOrderSetWapper" setindex="0">
            <div class="serviceOrderSetWapperInternal">
                <div class="serviceOrderSetDIV">
                    <div style="width: 100%;float: left;padding-top: 10px;">  
                        
                        <!--JASSIM-->                        
                        <input type="checkbox"  style="width: 2%;margin-bottom: 20px;" name="use_same_check" id="use_same_check_box" value="1"  onclick="return use_same_set();" /><span id="use_same_check_box_spn">Use the same File as in Job Option <?php echo ($count_option - 1); ?></span>
                        <!--End-->
                        
                        <!--Check Box Start-->
                        <div style="float:left;width:100%;">
                            <ul class="arch_radio">
                                <li><input type="radio" name="plotting_check" id="plotting_check" style="width:2% !important;" value="1" onclick="return active_plot_new();" /><span style="font-size: 13px;padding-left: 7px;font-weight: bold;">PLOTTING</span></li>
                                <li><input type="radio" name="plotting_check" id="plotting_check_0" style="width:2% !important;" value="0" onclick="return active_arch();" /><span style="font-size: 13px;padding-left: 7px;font-weight: bold;">ARCHITECTURAL COPIES</span></li>
                            </ul>
                            <span id="errmsg"></span>
                        </div>
                        <!--Check Box End-->

                        <!--Originals Start-->
                        <div>
                            <label>
                                Originals
                            </label>
                            <input class="order_0_set1_0_original k-input kdText " style="width:50px;" id="original" name="original" type="text" value="" />
                        </div>
                        <!--Originals End-->

                        <!--POE Start-->
                        <div>
                            <label>
                                Prints of Each<span style="color: red;">*</span>
              <!--                                  <span style="font-weight:bold;color:#cc0000">
                                  *
                                </span>-->
                            </label>
                            <input class="ymlrequired order_0_set1_0_printOfEach k-input kdText " style="width:80px;" id="print_ea" name="print_ea" type="text" value="" />
                        </div>
                        <!--POE End-->

                        <!--Size Start-->
                        <div>
                            <label>
                                Size<span style="color: red;">*</span>
                            </label>
                            <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_size kdSelect" style="width: 135px;" id="size" name="size" onchange="return custome_size();">                            
                                        <option value="FULL">FULL</option>
                                        <option value="HALF">HALF</option>
                                        <option value="Reduce to 11 X 17">Reduce to 11 X 17</option>
                                        <option value="Custom">Custom</option>                          
                                    </select>
                                </div>
                                <div class="dropdown_selector">
                                </div>
                            </div>
                        </div>
                        <!--Size End-->

                        <!--Output Start-->
                        <div>
                            <label>
                                Output<span style="color: red;">*</span>
                            </label>
                            <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_output kdSelect " style="width: 65px;" id="output" name="output" onchange="return custome_output();">
                                        <option value="B/W">B/W</option>
                                        <option value="Color">Color</option>
                                        <option value="Both">Both</option>
                                    </select>

                                </div>
                                <div class="dropdown_selector">
                                </div>
                            </div>
                        </div>
                        <!--Size End-->

                        <!--Media Start-->
                        <div>
                            <label>
                                Media<span style="color: red;">*</span>
                            </label>
                            <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_media kdSelect " style="width: 70px;" id="media" name="media">
                                        <option value="Bond">Bond</option>
                                        <option value="Vellum">Vellum</option>
                                        <option value="Mylar">Mylar</option>                          
                                    </select>
                                </div>
                                <div class="dropdown_selector">
                                </div>
                            </div>
                        </div>
                        <!--Media End-->

                        <!--Binding Start-->
                        <div>
                            <label>
                                Binding
                            </label>
                            <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_binding kdSelect " style="width: 130px;" id="binding" name="binding">
                                        <option value="none">None</option>                                      
                                        <option value="Bind All">Bind All</option>                          
                                        <option value="Bind by Discipline">Bind by Discipline</option>
                                        <option value="Screw Post">Screw Post</option>
                                    </select>
                                </div>
                                <div class="dropdown_selector">
                                </div>
                            </div>
                        </div>
                        <!--Binding End-->

                        <!--Folding Start-->
                        <div>
                            <label>
                                Folding
                            </label>
                            <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_folding kdSelect " style="width: 100px;" id="folding" name="folding">
                                        <option value="none">None</option>
                                        <option value="Yes">Yes</option>                          
                                    </select>
                                </div>
                                <div class="dropdown_selector">
                                </div>
                            </div>
                        </div>
                        <!--Folding End-->
                    </div>
                    <!--Custom Details Start-->
                    <div id="size_custom_div" style="border: 1px #FF7E00 solid;width: 100%;padding: 5px;text-align: center;margin-bottom: 10px;display: none;">
                        <label>Please Specify Custom Details : </label><textarea name="size_custom" id="size_custom" rows="3" cols="18" style="width: 201px;" placeholder="Custom Size"></textarea>
                    </div>
                    <!--Custom Details End-->
                    <!--Page Number Details Start-->
                    <div id="output_both_div" style="border: 1px #FF7E00 solid;width: 100%;padding: 5px;text-align: center;margin-bottom: 10px;display: none;">
                        <label>Enter page numbers that are in COLOR (separated by a comma) :</label>
                        <input type="text" name="output_both" id="output_both" style="width: 200px;" />
                    </div>
                    <!--Page Number Details End-->

                    <div style="width:730px;border-bottom: 1px solid #CCCCCC;float: left;">
<!--                        <label style="font-weight: bold;height:28px">
                            Alternative File Options<span style="color: red;">*</span>
                        </label>
                        <input type="checkbox"  style="width: 2%;margin-bottom: 20px;" name="use_same_check" id="use_same_check_box" value="1"  onclick="return use_same_set();" /><span id="use_same_check_box_spn">Use the same File Option as in Job Option <?php echo ($count_option - 1); ?></span>-->
                        <div id="options_plott" class="check" style="width:730px;border-top: 1px solid #FF7E00;margin-top: 5px;">
                            <div class="spl_option" style="float: 100%;">
                                <div>
                                    <input class="filetrigger" name="alt_file_option" value="dropOff" id="drop_file"  type="radio" onclick="return upload_soho();" />
                                    <label for="drop" >
                                        Upload File
                                    </label>                    
                                </div>

                                <div>
                                    <input class="filetrigger" name="alt_file_option" value="dropOff" id="link"  type="radio" onclick="return provide_link();" />
                                    <label for="drop" >
                                        Provide Link to File
                                    </label>                    
                                </div>   

                                <div>
                                    <input class="filetrigger" name="alt_file_option" value="pickUp" id="pick"  type="radio" onclick="return show_date_picker();" />
                                    <label for="pick" >
                                        Schedule a pick up
                                    </label></br>
                                    <?php
                                    $all_days_off = AllDayOff();
                                    foreach ($all_days_off as $days_off_split) {
                                        $all_days_in[] = $days_off_split['date'];
                                    }
                                    $all_date = implode(",", $all_days_in);
                                    $all_date_exist = str_replace("/", "-", $all_date);
                                    ?>

                                </div>

                                <div>
                                    <input class="filetrigger" name="alt_file_option" value="dropOff" id="dropoff"  type="radio" onclick="return drop_sohorepro();" />
                                    <label for="drop" >
                                        Drop off at Soho Repro
                                    </label>                    
                                </div>                               
                            </div>
                            <br>

                            <!--File Upload Details Start-->
                            <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="up_form">
                                <input type="hidden" name="uploadedfile" id="uploadedfile" value="" /> 
                                <div id="dragandrophandler">Drag & Drop Files Here</div>
                                <br><br>
                                <div id="status1"></div> 
                            </div>
                            <!--File Upload Details End-->

                            <!--FTP Details Start-->
                            <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="provide_link">
                                <div style="margin: auto;width: 60%;">
                                    <div style="margin: auto;width: 60%;float:right;">
                                    <!--<textarea name="provide_link" id="provide_link_text" rows="3" cols="18" style="width: 201px;"></textarea>-->
                                        <input type="text" name="ftp_link" id="ftp_link" placeholder="FTP Link" />
                                        <input type="text" name="user_name" id="user_name" placeholder="User Name" />
                                        <input type="text" name="password" id="pass_word" placeholder="Password" />
                                    </div>
                                    <div style="margin: auto;width: 60%;float:right;padding-top: 5px;">
                                        <span>If providing an FTP link, please include username and password.</span>
                                    </div>
                                </div>   
                            </div>
                            <!--FTP Details Start-->

                            <!--Pickup Details Start-->
                            <div id="date_time" style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;display:none;">
                                <input type="hidden" name="all_exist_date" id="all_exist_date" value="<?php echo $all_date_exist; ?>" />                                
                                <div style="width: 34%;float: left;"> 

                                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;border-bottom: 0px;text-align: center;">
                                        <span id="asap_status" class="asap_orange" onclick="return asap();">READY NOW</span>
                                    </div>

                                    <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                                        <input class="date_for_alt picker_icon" value="" type="text" name="date_needed" id="date_for_alt" style="width: 75px;" onclick="date_reveal();" />
                                        <input id="time_for_alt" value="" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time();" />
                                    </div>

                                </div>
                            </div>
                            <!--Pickup Details End-->

                            <!--Drop off Details Start-->
                            <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="drop_off">
                                <div style="margin: auto;width: 60%;">
                                    <div style="margin: auto;width: 75%;float:right;">
                                        <input style="width: 10% !important;" type="radio" name="drop_val" id="drop_val" value="381 Broome Street" />381 Broome Street
                                        <input style="width: 10% !important;" type="radio" name="drop_val" id="drop_val_1" value="307 7th Ave, 5th Floor" />307 7th Ave, 5th Floor
                                    <!-- <select id="drop_val">
                                            <option value="" selected="selected">Select</option>
                                            <option value="381 Broom">381 Broome St</option>
                                            <option value="307 7th Ave, 5th Floor" >307 7th Ave, 5th Floor</option>
                                        </select> -->
                                    </div>                             
                                </div>   
                            </div>
                            <!--Drop off Details End-->

                        </div>

                        <div id="options_arch" class="check none" style="width:730px;border-top: 1px solid #FF7E00;">
                            <div class="spl_option" style="float: 100%;">
                                <div>
                                    <input class="filetrigger" name="alt_file_option" value="pickUp" id="pick"  type="radio" onclick="return show_date_picker_arch();" />
                                    <label for="pick" >
                                        Schedule a pick up
                                    </label></br>
                                    <?php
                                    $all_days_off = AllDayOff();
                                    foreach ($all_days_off as $days_off_split) {
                                        $all_days_in[] = $days_off_split['date'];
                                    }
                                    $all_date = implode(",", $all_days_in);
                                    $all_date_exist = str_replace("/", "-", $all_date);
                                    ?>

                                </div>

                                <div>
                                    <input class="filetrigger" name="alt_file_option" value="dropOff" id="dropoff"  type="radio" onclick="return drop_sohorepro_arch();" />
                                    <label for="drop" >
                                        Drop off at Soho Repro
                                    </label>                    
                                </div>                               
                            </div>
                            <br>

                            <!--Pickup Details Start-->

                            <div id="date_time_arch" style="width: 95%;float: left;margin-left: 25px;margin-top: 10px;display:none;">
                            <input type="hidden" name="all_exist_date" id="all_exist_date" value="<?php echo $all_date_exist; ?>" />                                
                            <div style="width: 34%;float: left;"> 

                                <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;border-bottom: 0px;text-align: center;">
                                    <span id="asap_status_arch" class="asap_orange" onclick="return asap_arc();">READY NOW</span>
                                </div>

                                <div style="width: 100%;float: left;border: 1px #F99B3E solid;padding: 6px;height: 30px;">
                                    <input class="date_for_alt picker_icon" value="" type="text" name="date_needed" id="date_for_alt_arc" style="width: 75px;" onclick="date_reveal();" />
                                    <input id="time_for_alt_arc" value="" type="text" style="width: 75px;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" onclick="return show_time();" />
                                </div>

                            </div>
                        </div>
                            <!--Pickup Details End-->

                            <!--Drop off Details Start-->
                            <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="drop_off_arch">
                                <div style="margin: auto;width: 60%;">
                                    <div style="margin: auto;width: 75%;float:right;">
                                        <input style="width: 10% !important;" type="radio" name="drop_val" id="drop_val_arc" value="381 Broome Street" />381 Broome Street
                                        <input style="width: 10% !important;margin-left: 35px !important;" type="radio" name="drop_val" id="drop_val_arc_1" value="307 7th Ave, 5th Floor" />307 7th Ave, 5th Floor
                                    <!-- <select id="drop_val">
                                            <option value="" selected="selected">Select</option>
                                            <option value="381 Broom">381 Broome St</option>
                                            <option value="307 7th Ave, 5th Floor" >307 7th Ave, 5th Floor</option>
                                        </select> -->
                                    </div>                            
                                </div>   
                            </div>
                            <!--Drop off Details End-->

                        </div>

                        <!--Special Instruction Start-->
                        <div style="float: left;width: 100%;">
                            <div id="sp_inst" style="margin-top:10px;">
                                <label style="font-weight: bold;margin-bottom: -4px; margin-top: -10px;">
                                    Special Instructions
                                </label>
                                <br>
                                <textarea name="special_instruction" class="splins" id="special_instruction" rows="4" cols="60" style="margin-top:-5px;margin-bottom:10px;"><?php echo $entered['spl_instruction']; ?></textarea>
                            </div>
                        </div>
                        <!--Special Instruction End-->
                    </div>
                </div>

            </div>  
        </div>
    </div>
    <!--New Job Add End-->
    <?php
} elseif ($_POST['service_plotting_add'] == '0') {

    $delete_set_id = $_POST['delete_set_id'];

    $sql = "DELETE FROM sohorepro_plotting_set WHERE id = '" . $delete_set_id . "' ";
    $result = mysql_query($sql);

    $sql_delete_file = "DELETE FROM sohorepro_upload_files_set WHERE order_id = '0' AND comp_id = '" . $_SESSION['sohorepro_companyid'] . "' AND user_id = '" . $_SESSION['sohorepro_userid'] . "' ";
    mysql_query($sql_delete_file);

    $user_id_add_set = $_SESSION['sohorepro_userid'];
    $company_id_view_plot = $_SESSION['sohorepro_companyid'];
    $enteredPlotPrimay = EnteredPlotttingPrimary($company_id_view_plot, $user_id_add_set);
    $count_option = count($enteredPlotPrimay) + 1;
    $i = 1;
    foreach ($enteredPlotPrimay as $plot) {
        $job_type = ($plot['plot_arch'] == '1') ? 'Plotting' : 'Architecture';
        ?>
        <div class="plot_container" style="width: 100%;float: left;border: 1px #FF7E00 solid;margin-bottom: 5px;">
            <div class="plot_wrap" style="padding: 5px;">
                <div style="width: 100%;float: left;margin-bottom: 10px;">
                    <div style="float: left;width: 45%;font-weight: bold;">Job Option - <?php echo $i; ?></div>
                    <div style="float: left;width: 50%;font-weight: bold;text-align: right;cursor: pointer;" onclick="return delete_added_job(<?php echo $plot['id']; ?>);">Delete</div>
                </div>
                <ul>
                    <li><label>Job Type </label><p>: <?php echo $job_type; ?></p></li>
                    <li><label>Originals</label><p>: <?php echo $plot['origininals']; ?></p></li>
                    <li><label>Prints of Each</label><p>: <?php echo $plot['print_ea']; ?></p></li>
                    <li><label>Size</label><p>: <?php echo $plot['size']; ?></p></li>
                    <li><label>Output</label><p>: <?php echo $plot['output']; ?></p></li>
                    <li><label>Media</label><p>: <?php echo $plot['media']; ?></p></li>
                    <li><label>Binding</label><p>: <?php echo $plot['binding']; ?></p></li>
                    <li><label>Folding</label><p>: <?php echo $plot['folding']; ?></p></li>
                </ul>

                <div style="width: 100%;float: left;margin-top: 5px;">
                    <div style="float: left;width: 100%;margin-top: 5px;font-weight: bold;">Alternative File Options</div>
                    <?php
                    if ($file_upload_exist[0]['job_id'] != '') {
                        ?>
                        <div style="float: left;width: 100%;">
                            <div style="float: left;width: 100%;text-decoration: underline;">Upload File</div>
                            <div style="float: left;width: 100%;"><?php echo $file_upload_exist[0]['file_name']; ?></div>
                        </div>
                    <?php } elseif ($plot['ftp_link'] != '0') { ?>
                        <div style="float: left;width: 100%;">
                            <div style="float: left;width: 100%;text-decoration: underline;">Provide Link to File</div>
                            <div style="float: left;width: 100%;">FTP Link  : <?php echo $plot['ftp_link']; ?></div>
                            <div style="float: left;width: 100%;">User Name : <?php echo $plot['user_name']; ?></div>
                            <div style="float: left;width: 100%;">Password  : <?php echo $plot['password']; ?></div>
                        </div>
                    <?php } elseif ($plot['pick_up'] != '0') { ?>
                        <div style="float: left;width: 100%;">
                            <div style="float: left;width: 100%;text-decoration: underline;">Schedule a pick up</div>
                            <div style="float: left;width: 100%;">Pickup Date : <?php echo $plot['pick_up']; ?></div>
                            <div style="float: left;width: 100%;">Pickup Time  : <?php echo $plot['pick_up_time']; ?></div>
                        </div>
                    <?php } elseif ($plot['drop_off'] != '0') { ?>
                        <div style="float: left;width: 100%;">
                            <div style="float: left;width: 100%;text-decoration: underline;">Drop off at Soho Repro</div>                       
                            <div style="float: left;width: 100%;">Drop off at : <?php echo $plot['drop_off']; ?></div>
                        </div>   
                    <?php } ?>
                </div>

                <div style="width: 100%;float: left;margin-top: 7px;">                    
                    <div style="float: left;width: 100%;margin-top: 5px;font-weight: bold;">Special Instructions</div>
                    <div style="float: left;width: 100%;">                        
                        <div style="float: left;width: 100%;"><?php echo $plot['spl_instruction']; ?></div>
                    </div> 
                </div>

            </div>
        </div>
        <?php
        $i++;
    }
    ?>
    <div class="serviceOrderSetHolder">
        <label style="font-weight: bold; margin-bottom: 0px; margin-top: 0px;" for="jo1" class="optional">
            Job Options 
            <div style="float:right;font-weight: bold;">
                Option - <?php echo $count_option; ?>                          
            </div>
        </label>  
        <div style="background-color:#FFFFFF" class="serviceOrderSetWapper" setindex="0">
            <div class="serviceOrderSetWapperInternal">
                <div class="serviceOrderSetDIV">
                    <div style="width: 100%;float: left;padding-top: 10px;">  

                        <!--Check Box Start-->
                        <div style="float:left;width:100%;">
                            <ul class="arch_radio">
                                <li><input type="radio" name="plotting_check" id="plotting_check" style="width:2% !important;" value="1" value="1" checked="checked" /><span style="font-size: 13px;padding-left: 7px;font-weight: bold;">PLOTTING</span></li>
                                <li><input type="radio" name="plotting_check" id="plotting_check_0" style="width:2% !important;" value="0" /><span style="font-size: 13px;padding-left: 7px;font-weight: bold;">ARCHITECTURAL COPIES</span></li>
                            </ul>
                            <span id="errmsg"></span>
                        </div>
                        <!--Check Box End-->

                        <!--Originals Start-->
                        <div>
                            <label>
                                Originals
                            </label>
                            <input class="order_0_set1_0_original k-input kdText " style="width:65px;" id="original" name="original" type="text" value="" />
                        </div>
                        <!--Originals End-->

                        <!--POE Start-->
                        <div>
                            <label>
                                Prints of Each<span style="color: red;">*</span>
              <!--                                  <span style="font-weight:bold;color:#cc0000">
                                  *
                                </span>-->
                            </label>
                            <input class="ymlrequired order_0_set1_0_printOfEach k-input kdText " style="width:80px;" id="print_ea" name="print_ea" type="text" value="" />
                        </div>
                        <!--POE End-->

                        <!--Size Start-->
                        <div>
                            <label>
                                Size<span style="color: red;">*</span>
                            </label>
                            <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_size kdSelect" style="width: 135px;" id="size" name="size" onchange="return custome_size();">                            
                                        <option value="FULL">FULL</option>
                                        <option value="HALF">HALF</option>
                                        <option value="Reduce to 11 X 17">Reduce to 11 X 17</option>
                                        <option value="Custom">Custom</option>                          
                                    </select>
                                </div>
                                <div class="dropdown_selector">
                                </div>
                            </div>
                        </div>
                        <!--Size End-->

                        <!--Output Start-->
                        <div>
                            <label>
                                Output<span style="color: red;">*</span>
                            </label>
                            <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_output kdSelect " style="width: 90px;" id="output" name="output" onchange="return custome_output();">
                                        <option value="B/W">B/W</option>
                                        <option value="Color">Color</option>
                                        <option value="Both">Both</option>
                                    </select>

                                </div>
                                <div class="dropdown_selector">
                                </div>
                            </div>
                        </div>
                        <!--Size End-->

                        <!--Media Start-->
                        <div>
                            <label>
                                Media<span style="color: red;">*</span>
                            </label>
                            <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_media kdSelect " style="width: 100px;" id="media" name="media">
                                        <option value="Bond">Bond</option>
                                        <option value="Vellum">Vellum</option>
                                        <option value="Mylar">Mylar</option>                          
                                    </select>
                                </div>
                                <div class="dropdown_selector">
                                </div>
                            </div>
                        </div>
                        <!--Media End-->

                        <!--Binding Start-->
                        <div>
                            <label>
                                Binding
                            </label>
                            <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_binding kdSelect " style="width: 80px;" id="binding" name="binding">
                                        <option value="none">None</option>                                      
                                        <option value="Bind All">Bind All</option>                          
                                        <option value="Bind by Discipline">Bind by Discipline</option>
                                        <option value="Screw Post">Screw Post</option>
                                    </select>
                                </div>
                                <div class="dropdown_selector">
                                </div>
                            </div>
                        </div>
                        <!--Binding End-->

                        <!--Folding Start-->
                        <div>
                            <label>
                                Folding
                            </label>
                            <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_folding kdSelect " style="width: 100px;" id="folding" name="folding">
                                        <option value="none">None</option>
                                        <option value="Yes">Yes</option>                          
                                    </select>
                                </div>
                                <div class="dropdown_selector">
                                </div>
                            </div>
                        </div>
                        <!--Folding End-->
                    </div>
                    <!--Custom Details Start-->
                    <div id="size_custom_div" style="border: 1px #FF7E00 solid;width: 30%;padding: 5px;margin: auto;margin-left: 145px;display: none;">
                        <label>Please Specify Custom Details : </label><textarea name="size_custom" id="size_custom" rows="3" cols="18" style="width: 201px;" placeholder="Custom Size"></textarea>
                    </div>
                    <!--Custom Details End-->
                    <!--Page Number Details Start-->
                    <div id="output_both_div" style="border: 1px #FF7E00 solid;width: 55%;padding: 5px;margin-left: 247px;display: none;">
                        <label>Enter page numbers that are in COLOR (separated by a comma) :</label>
                        <input type="text" name="output_both" id="output_both" style="width: 200px;" />
                    </div>
                    <!--Page Number Details End-->

                    <div style="width:730px;border-bottom: 1px solid #CCCCCC;float: left;">
                        <label style="font-weight: bold;height:28px">
                            Alternative File Options<span style="color: red;">*</span>
                        </label>
                        <input type="checkbox"  style="display: none;width: 2%;" name="use_same_check" id="use_same_check_box" value="1"  onclick="return use_same_set('1');" />
                        <div class="check" style="width:730px;border-top: 1px solid #FF7E00;margin-top:-13px;">
                            <div class="spl_option" style="float: 100%;">
                                <div>
                                    <input class="filetrigger" name="alt_file_option" value="dropOff" id="drop_file"  type="radio" onclick="return upload_soho();" />
                                    <label for="drop" >
                                        Upload File
                                    </label>                    
                                </div>

                                <div>
                                    <input class="filetrigger" name="alt_file_option" value="dropOff" id="link"  type="radio" onclick="return provide_link();" />
                                    <label for="drop" >
                                        Provide Link to File
                                    </label>                    
                                </div>   

                                <div>
                                    <input class="filetrigger" name="alt_file_option" value="pickUp" id="pick"  type="radio" onclick="return show_date_picker();" />
                                    <label for="pick" >
                                        Schedule a pick up
                                    </label></br>
                                    <?php
                                    $all_days_off = AllDayOff();
                                    foreach ($all_days_off as $days_off_split) {
                                        $all_days_in[] = $days_off_split['date'];
                                    }
                                    $all_date = implode(",", $all_days_in);
                                    $all_date_exist = str_replace("/", "-", $all_date);
                                    ?>

                                </div>

                                <div>
                                    <input class="filetrigger" name="alt_file_option" value="dropOff" id="dropoff"  type="radio" onclick="return drop_sohorepro();" />
                                    <label for="drop" >
                                        Drop off at Soho Repro
                                    </label>                    
                                </div>                               
                            </div>
                            <br>

                            <!--File Upload Details Start-->
                            <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="up_form">
                                <input type="hidden" name="uploadedfile" id="uploadedfile" value="1" /> 
                                <div id="dragandrophandler">Drag & Drop Files Here</div>
                                <br><br>
                                <div id="status1"></div> 
                            </div>
                            <!--File Upload Details End-->

                            <!--FTP Details Start-->
                            <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="provide_link">
                                <div style="margin: auto;width: 60%;">
                                    <div style="margin: auto;width: 60%;float:right;">
                                    <!--<textarea name="provide_link" id="provide_link_text" rows="3" cols="18" style="width: 201px;"></textarea>-->
                                        <input type="text" name="ftp_link" id="ftp_link" placeholder="FTP Link" />
                                        <input type="text" name="user_name" id="user_name" placeholder="User Name" />
                                        <input type="text" name="password" id="pass_word" placeholder="Password" />
                                    </div>
                                    <div style="margin: auto;width: 60%;float:right;padding-top: 5px;">
                                        <span>If providing an FTP link, please include username and password.</span>
                                    </div>
                                </div>   
                            </div>
                            <!--FTP Details Start-->

                            <!--Pickup Details Start-->
                            <div id="date_time" style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;float: left;width: 30%;padding-bottom: 10px;display:none;">
                                <div style="width: 100%;">
                                    <input style="margin-left: 75px;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="button" name="ready_now" value="READY NOW" id="ready_now" onclick="return ready_now();" />
                                </div>                      

                                <div style="border: 1px #CCC solid;width: 95%;margin-left: 5px;margin-bottom: 10px;"></div>

                                <div style="padding: 5px;">
                                    <input type="hidden" name="all_exist_date" id="all_exist_date" value="<?php echo $all_date_exist; ?>" />
                                    <input type="text" name="dahe_for_alt" id="date_for_alt" style="width: 30%;margin-left: 5px;" class="date_for_alt picker_icon" />                        

                                    <input id="time_for_alt" type="text" style="width: 30%;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" />
                                </div>                        
                            </div>
                            <!--Pickup Details End-->

                            <!--Drop off Details Start-->
                            <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="drop_off">
                                <div style="margin: auto;width: 60%;">
                                    <div style="margin: auto;width: 75%;float:right;">
                                        <input style="width: 10% !important;" type="radio" name="drop_val" id="drop_val" value="381 Broom" />381 Broom
                                        <input style="width: 10% !important;" type="radio" name="drop_val" id="drop_val_1" value="307 7th Ave, 5th Floor" />307 7th Ave, 5th Floor
                                    <!-- <select id="drop_val">
                                            <option value="" selected="selected">Select</option>
                                            <option value="381 Broom">381 Broome St</option>
                                            <option value="307 7th Ave, 5th Floor" >307 7th Ave, 5th Floor</option>
                                        </select> -->
                                    </div>                             
                                </div>   
                            </div>
                            <!--Drop off Details End-->

                        </div>

                        <!--Special Instruction Start-->
                        <div style="float: left;width: 100%;">
                            <div id="sp_inst" style="margin-top:10px;">
                                <label style="font-weight: bold;margin-bottom: -4px; margin-top: -10px;">
                                    Special Instructions
                                </label>
                                <br>
                                <textarea name="special_instruction" class="splins" id="special_instruction" rows="4" cols="60" style="margin-top:-5px;margin-bottom:10px;"><?php echo $entered['spl_instruction']; ?></textarea>
                            </div>
                        </div>
                        <!--Special Instruction End-->
                    </div>
                </div>

            </div>  
        </div>
    </div>
    <?php
}
?>

<script src="js/new_set_script.js"></script>