<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);


if ($_POST['service_cutting_add'] == '1') {
    
    
    $user_id_add_set                = $_SESSION['sohorepro_userid'];
    $company_id_view_plot           = $_SESSION['sohorepro_companyid'];

    $job_reference                  = $_POST['job_reference'];
    $_SESSION['ref_val']            = $_POST['job_reference'];
    
    $binding_main_option            = $_POST['binding_main_option'];
    $binding_child_option           = $_POST['binding_child_option'];
    
    $front_main_option              = $_POST['front_main_option'];
    $binding_child_option_front     = $_POST['binding_child_option_front'];
    
    $back_main_option               = $_POST['back_main_option'];
    $binding_child_option_back      = $_POST['binding_child_option_back'];
    
    $nob                            = ucwords(strtolower($_POST['nob']));
    $cutting_option                 = $_POST['cutting_option'];
    $special_instruction_cutting    = $_POST['special_instruction_cutting'];
    $custome_instruction            = $_POST['custome_instruction'];
    $special_instruction            = $_POST['special_instruction'];
    
    $size_1_val                    = $_POST['size_1_val'];
    $size_2_val                    = $_POST['size_2_val'];
    $size_3_val                    = $_POST['size_3_val'];
    $size_4_val                    = $_POST['size_4_val'];
    
    if($size_1_val != '0'){
        $size = $size_1_val;
    }elseif($size_2_val != '0'){
        $size = $size_2_val;
    }elseif($size_3_val != '0'){
        $size = $size_3_val;
    }elseif($size_4_val != '0'){
        $size = $size_4_val;
    }
   
    
    
    $query = "INSERT INTO sohorepro_service_binding
			SET     reference               = '" . $job_reference . "',
                                comp_id                 = '" . $company_id_view_plot . "',
                                user_id                 = '" . $user_id_add_set ."',  
                                binding                 = '" . $binding_main_option . "',
                                binding_option          = '" . $binding_child_option . "',
                                front_cover             = '" . $front_main_option . "',    
                                front_cover_option      = '" . $binding_child_option_front . "',
                                back_cover              = '" . $back_main_option . "',
                                back_cover_option       = '" . $binding_child_option_back . "',
                                number_of_book_bind     = '" . $nob . "',
                                cutting                 = '" . $cutting_option . "',
                                cutting_instruction     = '" . $special_instruction_cutting . "',
                                size                    = '" . $size . "',
                                size_custome            = '" . $custome_instruction . "',
                                special_instruction     = '" . $special_instruction . "' ";
    $sql_result = mysql_query($query);
    if($sql_result){
        echo '1';
    }
}
