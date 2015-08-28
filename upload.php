<?php
include './admin/config.php';
include './admin/db_connection.php';
error_reporting(0);

$output_dir = "uploads/";

if(isset($_FILES["file"]))
{
        $user_id_add_set = $_SESSION['sohorepro_userid'];
        $company_id_view_plot = $_SESSION['sohorepro_companyid'];
    
	$ret = array();

	$error =$_FILES["file"]["error"];
   {
            $ImageName      = str_replace(' ','-',strtolower($_FILES['file']['name']));
            $ImageType      = $_FILES['file']['type']; //"image/png", image/jpeg etc.
         
            $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt       = str_replace('.','',$ImageExt);
            $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            $NewImageName = $ImageName.'.'.$ImageExt;

            move_uploaded_file($_FILES["file"]["tmp_name"],$output_dir. $NewImageName);
            
            $enteredPlotPrimay = EnteredPlotttingPrimary($company_id_view_plot, $user_id_add_set);
            $job_id     = (count($enteredPlotPrimay) == '0') ? '1' : (count($enteredPlotPrimay) + 1);
            $query = "INSERT INTO sohorepro_upload_files_set
			SET     file_name       = '" . $NewImageName . "',
                                comp_id         = '" . $company_id_view_plot . "',
                                user_id         = '" . $user_id_add_set . "',
                                job_id          = '" . $job_id . "' ";
    $sql_result = mysql_query($query);
    }
    echo '1';
 
}

?>