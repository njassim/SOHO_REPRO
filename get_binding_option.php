<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);


if (isset($_POST['binding_main_option']) && $_POST['binding_main_option'] != '') {
    
    $mai_option_id      =   $_POST['binding_main_option'];
    
    if($mai_option_id == "1"){
    ?>
        <option value="10">Black</option>
        <option value="11">White</option>
        <option value="12">Silver</option>        
    <?php
    }elseif ($mai_option_id == "5") {
    ?>
        <option value="13">Booklet - Saddle-Stitch</option>		
        <option value="14">Stapling - 1/staple Top Left</option>		
        <option value="15">Stapling - 1/staple Top Right</option>		
        <option value="16">Stapling - 1/staple Bottom Left</option>		
        <option value="17">Stapling - 1/staple Bottom Right</option>		
        <option value="18">Stapling - 2/staples Left Edge</option>		
        <option value="19">Stapling - 2/staples Right Edge</option>		
        <option value="20">Stapling - 2/staples Top Edge</option>		
        <option value="21">Stapling - 2/staples Bottom Edge</option>
    <?php
    }elseif ($mai_option_id == "6") {
    ?>
        <option value="10">Black</option>
        <option value="11">White</option> 
    <?php
    }elseif ($mai_option_id == "7") {
    ?>
        <option value="10">Black</option>
        <option value="11">White</option>  
        <option value="22">Navy</option>
        <option value="23">Green</option> 
    <?php
    }elseif ($mai_option_id == "8") {
    ?>   
        <option value="10">Black</option>
        <option value="11">White</option>
    <?php
    }elseif ($mai_option_id == "9") {
    ?>
        <option value="10">Black</option> 
    <?php
    }elseif ($mai_option_id == "102") {
    ?>
        <option value="151">Black</option>
        <option value="152">White</option>  
        <option value="153">Dark Gray</option>
        <option value="154">Navy</option>
        <option value="155">Green</option> 
        <option value="156">Maroon</option> 
    <?php  
    }elseif ($mai_option_id == "104") {
    ?>
        <option value="151">Black</option>
        <option value="152">White</option>  
    <?php
    }elseif ($mai_option_id == "202") {
    ?>
        <option value="151">Black</option>
        <option value="152">White</option>  
        <option value="153">Dark Gray</option>
        <option value="154">Navy</option>
        <option value="155">Green</option> 
        <option value="156">Maroon</option> 
    <?php
    }elseif ($mai_option_id == "204") {
    ?>
        <option value="151">Black</option>
        <option value="152">White</option>  
    <?php
    }
}
