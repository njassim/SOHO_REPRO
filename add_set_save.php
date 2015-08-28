<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);

if (isset($_POST['jobreference_add_set']) && $_POST['jobreference_add_set'] != '') {
    
    $jobreference_add_set = mysql_real_escape_string($_POST['jobreference_add_set']);
    if($_SESSION['ref_val'] == ''){
        $_SESSION['ref_val'] = $jobreference_add_set;
    }    
    $original_add_set = mysql_real_escape_string($_POST['original_add_set']);
    $print_ea_add_set = mysql_real_escape_string($_POST['print_ea_add_set']);
    $size_add_set = mysql_real_escape_string($_POST['size_add_set']);
    $output_add_set = mysql_real_escape_string($_POST['output_add_set']);
    $media_add_set = mysql_real_escape_string($_POST['media_add_set']);
    $binding_add_set = mysql_real_escape_string($_POST['binding_add_set']);
    $folding_add_set = mysql_real_escape_string($_POST['folding_add_set']);
    $pick_add_set = mysql_real_escape_string($_POST['pick_add_set']);
    $date_for_alt_add_set = mysql_real_escape_string($_POST['date_for_alt_add_set']);
    $uploadedfile_add_set = mysql_real_escape_string($_POST['uploadedfile_add_set']);
    $splins_add_set = mysql_real_escape_string($_POST['splins_add_set']);
    $company_id_add_set = mysql_real_escape_string($_POST['company_id_add_set']);
    $user_id_add_set = $_SESSION['sohorepro_userid'];
    $plotting_check_add_set = mysql_real_escape_string($_POST['plotting_check']);
    $time_for_alt_add_set_pre = mysql_real_escape_string($_POST['time_for_alt']);
    $time_for_alt_add_set = ($date_for_alt_add_set != '') ? $time_for_alt_add_set_pre : '';
    $provide_link_add_set = mysql_real_escape_string($_POST['provide_link']);
    $use_same = ($_POST['use_same']);
    $jobref_id = $_POST['jobref_id'];
    
    $check_serial = CheckSerials($company_id_add_set, $user_id_add_set, $set_inc);
        $query = "INSERT INTO sohorepro_plotting_set
			SET     origininals         = '" . $original_add_set . "',
                                print_ea            = '" . $print_ea_add_set . "',
                                size                = '" . $size_add_set . "',
                                output              = '" . $output_add_set . "',
                                media               = '" . $media_add_set . "',
                                binding             = '" . $binding_add_set . "',
                                folding             = '" . $folding_add_set . "',
                                upload_file         = '" . $uploadedfile_add_set . "',
                                pick_up             = '" . $date_for_alt_add_set . "',
                                pick_up_time        = '" . $time_for_alt_add_set . "',   
                                spl_instruction     = '" . $splins_add_set . "',
                                file_link           = '" . $provide_link_add_set . "',
                                referece_id         = '" . $jobref_id . "', 
                                company_id          = '" . $company_id_add_set . "',
                                user_id             = '" . $user_id_add_set . "',
                                plot_arch           = '" . $plotting_check_add_set . "',
                                set_serial          = '" . $_POST['set_inc'] . "',
                                use_same_alt        = '" . $use_same ."',
                                service_type        = '1'  ";
        $sql_result = mysql_query($query);
        if ($sql_result) {
           
            $enteredPlot          = EnteredPlot($company_id_add_set, $user_id_add_set);
            $sql_next_serial    = mysql_query("SELECT id FROM sohorepro_plotting_set WHERE company_id = '".$company_id_add_set."' AND user_id = '".$user_id_add_set."' ORDER BY id DESC LIMIT 1");
            $object_next_serial = mysql_fetch_assoc($sql_next_serial);            
            $set_inc = $object_next_serial['id']+1;
            echo $set_inc.'~';
            
                      $p = 1;
                      if(count($enteredPlot)> 0){
                      foreach ($enteredPlot as $entered){
                      ?>
                      <div class="serviceOrderSetHolder" style="border: 1px #F99B3E solid;margin-bottom: 15px;float: left;width: 100%;padding: 5px;">
                        <label style="font-weight: bold; margin-bottom: 0px; margin-top: 0px;" for="jo1" class="optional">
                            
                        Job Options - <?php echo $p; ?>
                        <div style="float:right;font-weight: bold;">
                            <?php
                            $set_cont_serial    = mysql_query("SELECT set_serial FROM sohorepro_plotting_set ORDER BY set_serial DESC LIMIT 1");
                            $object_serial      = mysql_fetch_assoc($set_cont_serial);
                            $set_initial_serial = ($object_serial['set_serial'] == '0') ? '1' : $object_serial['set_serial']; 
                            ?>                            
                            <span style="cursor: pointer;font-weight: bold;" onclick="return delete_option('<?php echo $entered['id']; ?>');">Delete</span>
                            <input type="hidden" id="set_inc_1" name="set_inc" value="<?php echo $set_initial_serial; ?>" />
                        </div>
                        </label>  
                        <div style="background-color:#FFFFFF" class="" setindex="0">
                            <div class="serviceOrderSetWapperInternal">
                            <div class="serviceOrderSetDIV">
                            <div style="width: 100%;float: left;padding-top: 10px;">            
                                <div style="float:left;width:100%;">
                                    <ul class="arch_radio">
                                        <li><input type="radio" name="plotting_check_<?php echo $p; ?>" id="plotting_check_1_1" style="width:2% !important;" value="1" <?php if($entered['plot_arch'] == '1'){?> checked <?php } ?> /><span style="font-size: 13px;padding-left: 7px;font-weight: bold;">PLOTTING</span></li>
                                        <li><input type="radio" name="plotting_check_<?php echo $p; ?>" id="plotting_check_0_1" style="width:2% !important;" value="0" <?php if($entered['plot_arch'] == '0'){?> checked <?php } ?> /><span style="font-size: 13px;padding-left: 7px;font-weight: bold;">ARCHITECTURAL COPIES</span></li>
                                </ul>
                                </div>                                    
                                <div>
                                <label>
                                  Originals
                                </label>
                                    <input class="order_0_set1_0_original k-input kdText " style="width:65px;" id="original_1" name="original" type="text" value="<?php echo $entered['origininals']; ?>" />
                              </div>
                              <div>
                                <label>
                                  Prints of Each<span style="color: red;">*</span>
<!--                                  <span style="font-weight:bold;color:#cc0000">
                                    *
                                  </span>-->
                                </label>
                                <input class="ymlrequired order_0_set1_0_printOfEach k-input kdText " style="width:68px;" id="print_ea_1" name="print_ea" type="text" value="<?php echo $entered['print_ea']; ?>" />
                              </div>
                              <div>
                                <label>
                                  Size<span style="color: red;">*</span>
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                      <select class="order_0_set1_0_size kdSelect " style="width: 90px;" id="size_1" name="size" onchange="return custome_size();">                            
                                          <option value="FULL" <?php if($entered['print_ea'] == 'FULL'){?> selected="selected" <?php } ?>>FULL</option>
                                      <option value="HALF" <?php if($entered['print_ea'] == 'HALF'){?> selected="selected" <?php } ?>>HALF</option>
                                      <option value="Reduce to 11 X 17" <?php if($entered['print_ea'] == 'Reduce to 11 X 17'){?> selected="selected" <?php } ?>>Reduce to 11 X 17</option>
                                      <option value="Custom" <?php if($entered['print_ea'] == 'Custom'){?> selected="selected" <?php } ?>>Custom</option>                          
                                    </select>
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>
                              <div>
                                <label>
                                  Output<span style="color: red;">*</span>
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_output kdSelect " style="width: 90px;" id="output_1" name="output" onchange="return custome_output();">
                                      <option value="B/W" <?php if($entered['output'] == 'B/W'){?> selected="selected" <?php } ?>>B/W</option>
                                      <option value="Color" <?php if($entered['output'] == 'Color'){?> selected="selected" <?php } ?>>Color</option>
                                      <option value="Both" <?php if($entered['output'] == 'Both'){?> selected="selected" <?php } ?>>Both</option>
                                    </select>
                                      
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>
                              <div>
                                <label>
                                  Media<span style="color: red;">*</span>
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_media kdSelect " style="width: 100px;" id="media_1" name="media">
                                      <option value="Bond" <?php if($entered['media'] == 'Bond'){?> selected="selected" <?php } ?>>Bond</option>
                                      <option value="Vellum" <?php if($entered['media'] == 'Vellum'){?> selected="selected" <?php } ?>>Vellum</option>
                                      <option value="Mylar" <?php if($entered['media'] == 'Mylar'){?> selected="selected" <?php } ?>>Mylar</option>                          
                                    </select>
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>
                              <div>
                                <label>
                                  Binding
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_binding kdSelect " style="width: 80px;" id="binding_1" name="binding">
                                      <option value="none" <?php if($entered['binding'] == 'none'){?> selected="selected" <?php } ?>>None</option>
                                      <option value="Screw Post" <?php if($entered['binding'] == 'Screw Post'){?> selected="selected" <?php } ?>>Screw Post</option>
                                      <option value="Binding Strip" <?php if($entered['binding'] == 'Binding Strip'){?> selected="selected" <?php } ?>>Binding Strip</option>                          
                                    </select>
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>

                              <div>
                                <label>
                                  Folding
                                </label>
                                <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                  <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_folding kdSelect " style="width: 100px;" id="folding_1" name="folding">
                                      <option value="none" <?php if($entered['folding'] == 'none'){?> selected="selected" <?php } ?>>None</option>
                                      <option value="Yes" <?php if($entered['folding'] == 'Yes'){?> selected="selected" <?php } ?>>Yes</option>                          
                                    </select>
                                  </div>
                                  <div class="dropdown_selector">
                                  </div>
                                </div>
                              </div>                              
                        
              </div>
                                <div id="size_custom_div" style="border: 1px #FF7E00 solid;width: 100%;float:left;padding: 5px;display: none;">
                                    <label>Please Specify Custom Details : </label><textarea name="size_custom_<?php echo $entered['id']; ?>" id="size_custom_<?php echo $entered['id']; ?>" rows="3" cols="18" style="width: 201px;" placeholder="Custom Size"></textarea>
                                </div>
                                <div id="output_both_div" style="border: 1px #FF7E00 solid;width: 100%;float:left;padding: 5px;display: none;">
                                    <label>Enter page numbers that are in COLOR (separated by a comma) :</label>
                                    <input type="text" name="output_both" id="output_both" style="width: 200px;" />
                                </div>
                <div>
                <label style="font-weight: bold;height:28px">
                  Alternative File Options<span style="color: red;">*</span>
                </label>
                    <input type="checkbox"  style="display: none;width: 2%;" name="use_same_check" id="use_same_check_box_1" value="1"  onclick="return use_same_set('1');" />
                <div class="check" style="width:730px;border-top: 1px solid #FF7E00;margin-top:-13px;">
                  <div class="spl_option" style="float: 100%;">
                         <div>
                                  <input class="filetrigger" name="alt_file_option" value="dropOff" id="drop"  type="radio" onclick="return upload_soho(<?php echo '1'; ?>);" />
                                <label for="drop" >
                                  Upload File
                                </label>                    
                              </div>

                            <div>
                                  <input class="filetrigger" name="alt_file_option" value="dropOff" id="drop"  type="radio" onclick="return provide_link(<?php echo '1'; ?>);" />
                                <label for="drop" >
                                  Provide Link to File
                                </label>                    
                            </div>   
                        
                        <div>
                                  <input class="filetrigger" name="alt_file_option" value="pickUp" id="pick_1"  type="radio" onclick="return show_date_picker(<?php echo '1'; ?>);" />
                                <label for="pick" >
                                  Schedule a pick up
                                </label></br>
                                <?php 
                                $all_days_off = AllDayOff();                                                        
                                foreach ($all_days_off as $days_off_split){
                                    $all_days_in[]  = $days_off_split['date'];
                                }                                                        
                                $all_date  = implode(",", $all_days_in);                                                        
                                $all_date_exist = str_replace("/", "-", $all_date);
                                ?>

                              </div>
                    
                              <div>
                                  <input class="filetrigger" name="alt_file_option" value="dropOff" id="drop"  type="radio" onclick="return drop_sohorepro(<?php echo '1'; ?>);" />
                                <label for="drop" >
                                  Drop off at Soho Repro
                                </label>                    
                              </div>

                               
                    </div>
                  <br>
                      <div id="date_time_1" style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;float: left;width: 35%;padding-bottom: 10px;display:none;">
                        <input type="hidden" name="all_exist_date" id="all_exist_date" value="<?php echo $all_date_exist; ?>" />
                        <input type="text" name="dahe_for_alt" id="date_for_alt_1" style="width: 50%;" class="date_for_alt" onclick="return date_picker_plot(1);" />                        
                        <select class="" id="time_for_alt_1" name="time_gap" id="time_gap" style="width: 35% !important;">
                                <option value="08:00AM">08:00AM</option>
                                <option value="09:00AM">09:00AM</option>
                                <option value="10:00AM">10:00AM</option>
                                <option value="11:00AM">11:00AM</option>
                                <option value="12:00PM">12:00PM</option>
                                <option value="01:00PM">01:00PM</option>
                                <option value="02:00PM">02:00PM</option>
                                <option value="03:00PM">03:00PM</option>
                                <option value="04:00PM">04:00PM</option>
                                <option value="05:00PM">05:00PM</option>
                                <option value="06:00PM">06:00PM</option>
                                <option value="07:00PM">07:00PM</option>
                            </select>
                        <div style="border: 1px #CCC solid;width: 95%;margin-left: 5px;margin-bottom: 10px;"></div>
                        <div style="width: 100%;">
                        <input style="margin-left: 75px;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="button" name="ready_now" value="READY NOW" id="ready_now" onclick="return ready_now();" />
                        </div>
                    </div>                      
                      <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="up_form_1">
<!--                        <div style="margin: auto;width: 50%;">                            
                        <form action="add_set_upload_form.php" method="post" enctype="multipart/form-data" id="upload_file_1">
                                <input type="file" name="uploadedfile" id="uploadedfile_1"><br>
                                <input type="submit" value="Upload File" class="upload_file_prog"  onclick="return upload_file(<?php echo '1'; ?>)" />
                        </form>
                            <div class="progress" id="progress_1">
                        <div class="bar" id="bar_1"></div >
                        <div class="percent" id="percent_1">0%</div >
                        </div>
                            <div id="status_1"></div>
                         </div>   -->
                        <input type="hidden" name="uploadedfile" id="uploadedfile_1" value="1" /> 
                         <div id="dragandrophandler">Drag & Drop Files Here</div>
                        <br><br>
                        <div id="status1"></div>

                      </div>
                      <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="provide_link_1">
                        <div style="margin: auto;width: 60%;">
                            <div style="margin: auto;width: 60%;float:right;">
                            <textarea name="provide_link" id="provide_link_text_1" rows="3" cols="18" style="width: 201px;"></textarea>                            
                            </div>
                            <div style="margin: auto;width: 60%;float:right;padding-top: 5px;">
                            <span>If providing an FTP link, please include username and password.</span>
                            </div>
                        </div>   
                      </div>
                  <div id="nn1" style="margin-left: 10px; display: none;" class="optionwapper man">

                    <div id="kk" style="margin-top:10px;display:block">
                      <label for="file" style="margin-left: -416px;margin-top:20px;">
                        Pick-up address:
                      </label>
                      <br>
                      <textarea name="pickupadd" id="order_0_set1_0_jobfiles" rows="3" cols="18" style="float:left;margin-left: -417px;margin-top: -13px;">
                      </textarea>

                    </div>

                    <div style="width:600px;margin-bottom:0px;display:none">
                      <div style="margin-bottom:0px;">
                        <div style="float:left;margin-right:0px;">
                          <select class="addressnameselect" name="address_name" style="width:150px;" id="namesel">

                            <option selected="selected">
                              a
                            </option>

                          </select>
                        </div>
                        <div class="dropdown_selector">
                        </div>
                      </div>
                      &nbsp;&nbsp;&nbsp;&nbsp;
                      <div style="margin-bottom:0px;">
                        <div style="float:left;margin-right:0px;">
                          <select class="addressselect" name="address_name" style="width:150px;" id="addsel">                
                            <option selected="selected">b</option>
                          </select>
                        </div>
                        <div class="dropdown_selector">
                        </div>
                      </div>
                      <a href="http://soho.thinkdesign.com/user/addresslist" id="dialogload">
                        add entry
                      </a>
                      &nbsp;to address book
                      <br>
                      <div style="float:left;margin-left: -342px; margin-top: 17px;">
                        <label style="margin-left: -11px; margin-top: 5px;">
                          When needed:
                        </label>
                        &nbsp; &nbsp;
                        <input name="timereq" style="width:120px;height:22px;margin-left:-19px;" value="ASAP" type="text">
                      </div>
                    </div>
                  </div>

                  <div style="margin-bottom:10px;">

                    <div id="nn2" style="display:none" class="optionwapper">
                      <label for="file">
                        Drop-off address:
                      </label>
                      <br>
                      <textarea rows="3" name="dropoffadd" id="order_0_set1_0_jobfiles" cols="20">
                      </textarea>

                    </div>

                  </div>
                </div>
                <br>

                <br>
                    <div style="float: left;width: 100%;">
                <div id="sp_inst" style="margin-top:10px;">
                  <label style="font-weight: bold;margin-bottom: -4px; margin-top: -10px;">
                    Special Instructions
                  </label>
                  <br>
                  <textarea name="spl_ins" class="splins" id="splins_1" rows="4" cols="60" style="margin-top:-5px;margin-bottom:10px;"><?php echo $entered['spl_instruction']; ?></textarea>
                </div>
                </div>
              </div>
              </div>
                            
              </div>              
                            
              
                            
              <div style="clear:both;">
              </div>
              </div>
              </div>
            <?php
                $p++;
                }
                }
                ?>
<!-- New Set Start -->                
<?php 
$current_count = count($enteredPlot)+1;
?>
<div class="serviceOrderSetHolder" style="margin-top: 10px;margin-bottom: 15px;">
            <label style="font-weight: bold; margin-bottom: 0px; margin-top: 0px;" for="jo1" class="optional">
                Job Options 
                <div style="float:right;font-weight: bold;">
                    Option <?php echo $current_count; ?>
                    <input type="hidden" id="set_inc_<?php echo $set_inc; ?>" name="set_inc" value="<?php echo $set_initial_serial; ?>" />
                </div>
            </label> 
            <div style="background-color:#FFFFFF" class="serviceOrderSetWapper" setindex="0">
                <div class="serviceOrderSetWapperInternal">
                    <div class="serviceOrderSetDIV">
                        <div style="float:left;width:100%;">
                            <ul class="arch_radio">
                                <li><input type="radio" name="plotting_check" id="plotting_check_1_<?php echo $set_inc; ?>" style="width:2% !important;" /><span style="font-size: 13px;padding-left: 7px;font-weight: bold;">PLOTTING</span></li>
                                <li><input type="radio" name="plotting_check" id="plotting_check_0_<?php echo $set_inc; ?>" style="width:2% !important;" /><span style="font-size: 13px;padding-left: 7px;font-weight: bold;">ARCHITECTURAL COPIES</span></li>
                            </ul>
                        </div>
                        <div>
                            <label>
                                Originals
                            </label>
                            <input class="order_0_set1_0_original k-input kdText " style="width:65px;" id="original_<?php echo $set_inc; ?>" name="original" type="text">
                        </div>
                        <div>
                            <label>
                                Prints of Each<span style="color: red;">*</span>
        <!--                                <span style="font-weight:bold;color:#cc0000">
                                    *
                                </span>-->
                            </label>
                            <input class="ymlrequired order_0_set1_0_printOfEach k-input kdText " style="width:68px;" id="print_ea_<?php echo $set_inc; ?>" name="print_ea" type="text">
                        </div>
                        <div>
                            <label>
                                Size<span style="color: red;">*</span>
                            </label>
                            <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_size kdSelect " style="width: 90px;" id="size_<?php echo $set_inc; ?>" name="size">                            
                                        <option selected="selected" value="FULL">FULL</option>
                                        <option value="HALF">HALF</option>
                                        <option value="Reduce to 11 X 17">Reduce to 11 X 17</option>
                                        <option value="Custom">Custom</option>                          
                                    </select>
                                </div>
                                <div class="dropdown_selector">
                                </div>
                            </div>
                        </div>
                        <div>
                            <label>
                                Output<span style="color: red;">*</span>
                            </label>
                            <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_output kdSelect " style="width: 90px;" id="output_<?php echo $set_inc; ?>" name="output">
                                        <option selected="selected" value="B/W">B/W</option>
                                        <option value="Color">Color</option>
                                        <option value="Both">Both</option>
                                    </select>
                                </div>
                                <div class="dropdown_selector">
                                </div>
                            </div>
                        </div>
                        <div>
                            <label>
                                Media<span style="color: red;">*</span>
                            </label>
                            <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_media kdSelect " style="width: 100px;" id="media_<?php echo $set_inc; ?>" name="media">
                                        <option selected="selected" value="Bond">Bond</option>
                                        <option value="Vellum">Vellum</option>
                                        <option value="Mylar">Mylar</option>                         
                                    </select>
                                </div>
                                <div class="dropdown_selector">
                                </div>
                            </div>
                        </div>
                        <div>
                            <label>
                                Binding
                            </label>
                            <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_binding kdSelect " style="width: 80px;" id="binding_<?php echo $set_inc; ?>" name="binding">
                                        <option value="none" selected="selected">None</option> 
                                        <option value="Binding Strip">Binding Strip</option>  
                                         <option value="Screw Post">Screw Post</option>
                                    </select>
                                </div>
                                <div class="dropdown_selector">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label>
                                Folding
                            </label>
                            <div class="drop" style="margin-right:0px;margin-left:0px;height:2px;">
                                <div style="float:left;margin-right:0px;">
                                    <select class="order_0_set1_0_folding kdSelect " style="width: 100px;" id="folding_<?php echo $set_inc; ?>" name="folding">
                                        <option value="none" selected="selected">None</option>
                                        <option value="Yes">Yes</option>                          
                                    </select>
                                </div>
                                <div class="dropdown_selector">
                                </div>
                            </div>
                        </div>                              

                    </div>
                    <div style="width:730px;border-bottom: 1px solid #CCCCCC;float: left;">
                        <label style="font-weight: bold;height:28px">
                            Alternative File Options<span style="color: red;">*</span>
                        </label>                       
                        <div class="check" id="use_same_hd" style="width:730px;border-top: 1px solid #FF7E00;margin-top:-13px;">
                            <div id="use_same_check" style="padding-top: 10px;">
                                <input type="checkbox" style="width: 2%;" name="use_same_check" id="use_same_check_box_<?php echo $set_inc; ?>" value="1"  onclick="return use_same_set('<?php echo $set_inc; ?>');" />
                                Use same file from Option <?php echo $_POST['set_inc']; ?>
                            </div>                            
                            <div id="use_same_<?php echo $set_inc; ?>" style="">
                            <div class="spl_option" style="float: 100%;">
                                
                                <div>
                                    <input class="filetrigger" name="alt_file_option" value="dropOff" id="drop"  type="radio" onclick="return upload_soho(<?php echo $set_inc; ?>);" />
                                  <label for="drop" >
                                    Upload File
                                  </label>                    
                                </div>

                                <div>
                                      <input class="filetrigger" name="alt_file_option" value="dropOff" id="drop"  type="radio" onclick="return provide_link(<?php echo $set_inc; ?>);" />
                                    <label for="drop" >
                                      Provide Link to File
                                    </label>                    
                                </div>   
                        
                                <div>
                                    <input class="filetrigger" name="alt_file_option" value="pickUp" id="pick_<?php echo $set_inc; ?>"  type="radio" onclick="return show_date_picker(<?php echo $set_inc; ?>);" />
                                  <label for="pick" >
                                    Schedule a pick up
                                  </label></br>
                                  <?php 
                                  $all_days_off = AllDayOff();                                                        
                                  foreach ($all_days_off as $days_off_split){
                                      $all_days_in[]  = $days_off_split['date'];
                                  }                                                        
                                  $all_date  = implode(",", $all_days_in);                                                        
                                  $all_date_exist = str_replace("/", "-", $all_date);
                                  ?>
                                </div>
                    
                              <div>
                                  <input class="filetrigger" name="alt_file_option" value="dropOff" id="drop"  type="radio" onclick="return drop_sohorepro(<?php echo $set_inc; ?>);" />
                                <label for="drop" >
                                  Drop off at Soho Repro
                                </label>                    
                              </div>
                            </div>
                         
                        <br>
                        
                        
                                </div>
                    <div id="date_time_<?php echo $set_inc; ?>" style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;float: left;width: 30%;padding-bottom: 10px;display:none;">
                        
                        <div style="width: 100%;">
                        <input style="margin-left: 75px;cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:-51px; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;" type="button" name="ready_now" value="READY NOW" id="ready_now" onclick="return ready_now();" />
                        </div>                        
                        
                        <div style="border: 1px #CCC solid;width: 95%;margin-left: 5px;margin-bottom: 10px;"></div>
                         
                        <div style="padding: 5px;">
                        <input type="hidden" name="all_exist_date" id="all_exist_date" value="<?php echo $all_date_exist; ?>" />
                        <input type="text" name="dahe_for_alt" id="date_for_alt_<?php echo $set_inc; ?>" style="width: 30%;margin-left: 5px;" class="date_for_alt picker_icon" />                        
                        
                        <input id="time_for_alt_1" type="text" style="width: 30%;margin-left: 4px;" class="time time_picker_icon" alt="Time Picker" title="Time Picker" />
                        </div>
                        
                    </div>
                      
                      <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="up_form_<?php echo $set_inc; ?>">
                        <input type="hidden" name="uploadedfile" id="uploadedfile_1" value="1" /> 
                        <div id="dragandrophandler">Drag & Drop Files Here</div>
                        <br><br>
                        <div id="status1"></div> 
                      </div>
                      
                      <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="provide_link_<?php echo $set_inc; ?>">
                        <div style="margin: auto;width: 60%;">
                            <div style="margin: auto;width: 60%;float:right;">
                            <textarea name="provide_link" id="provide_link_text_1" rows="3" cols="18" style="width: 201px;"></textarea>                            
                            </div>
                            <div style="margin: auto;width: 60%;float:right;padding-top: 5px;">
                            <span>If providing an FTP link, please include username and password.</span>
                            </div>
                        </div>   
                      </div>
                      
                      <div style="padding-top: 10px;border: 1px #FF7E00 solid;margin-top: 7px;display:none;float: left;width: 100%;padding-bottom: 10px;" id="drop_off_<?php echo $set_inc; ?>">
                        <div style="margin: auto;width: 60%;">
                            <div style="margin: auto;width: 60%;float:right;">
                                <select>
                                    <option value="381 Broom" selected="selected">381 Broome St</option>
                                    <option value="307 7th Ave, 5th Floor" >307 7th Ave, 5th Floor</option>
                                </select>                                
                            </div>                            
                        </div>   
                      </div>

                                <div style="margin-bottom:10px;">

                                    <div id="nn2" style="display:none" class="optionwapper">
                                        <label for="file">
                                            Drop-off address:
                                        </label>
                                        <br>
                                        <textarea rows="3" name="dropoffadd" id="order_0_set1_0_jobfiles" cols="20">
                                        </textarea>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <br>

                        <br>
                        <div style="float: left;width: 100%;">
                            <div id="sp_inst" style="margin-top:10px;">
                                <label style="font-weight: bold;margin-bottom: -4px; margin-top: -10px;">
                                    Special Instructions
                                </label>
                                <br>
                                <textarea name="spl_ins" class="splins" id="splins_<?php echo $set_inc; ?>" rows="4" cols="60" style="margin-top:-5px;margin-bottom:10px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

            </div>              



            <div style="clear:both;">
            </div>
        </div>



<!-- New Set End -->               
<?php
    }
}
?>
<!--<link rel="stylesheet" href="js/jquery-ui.css" />
<script src="store_files/jquery.min.js"></script>
<script src="js/jquery-ui_service.js"></script>-->
<script src="js/reveal_alt.js"></script>