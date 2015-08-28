<?php
include './config.php';

if(isset($_POST['off_day_delete_id']) && $_POST['off_day_delete_id'] != '')
{ 
    $off_day_delete_id    = $_POST['off_day_delete_id'];
    
    $sql = "DELETE FROM sohorepro_day_off WHERE id = '" . $off_day_delete_id . "' ";
    $result = mysql_query($sql); 
    if($result){
        echo 'Off day deleted successfully~';
    ?>
    <?php 
        $all_days_off = AllDayOff();
        $i = 1;
        foreach ($all_days_off as $days_off){
        ?>
        <div style="float:left;width:100%;padding-top: 3px;">
            <div style="float: left;width: 5%;"><?php echo $i.'.'; ?></div>
            <div style="float: left;width: 20%;"><?php echo $days_off['date']; ?></div>
            <div style="float: left;width: 20%;"><span style="background: none repeat scroll 0 0 #f99b3e;border-radius: 3px;color: #fff;cursor: pointer;padding: 0px 5px;" onclick="return off_days_delete('<?php echo $days_off['id']; ?>');">Delete</span></div>
        </div>
    <?php 
    $i++;    
    }
    echo '~';
    foreach ($all_days_off as $days_off_split){
        $all_days_in[]  = $days_off_split['date'];
    }                                                        
    $all_date  = implode(",", $all_days_in);                                                        
    $all_date_exist = str_replace("/", "-", $all_date);
    ?>
    <input type="hidden" name="all_exist_date" id="all_exist_date" value="<?php echo $all_date_exist; ?>" />
    <div style="float:left;width:100%;font-weight: bold;">Pick the Date for Off:</div>
    <div style="float:left;width:100%;"><input type="text" name="date_off" id="date_off" class="picker_icon" /></div>
    <div style="float:left;width:100%;margin-top:5px;"><span name="submit_off" style="background: none repeat scroll 0 0 #f99b3e;border-radius: 5px;color: #fff;cursor: pointer;float: left;padding: 2px 8px;" onclick="return set_off_days();" >Set Days Off</span></div>
    <?php
    }  else {
        echo '0';
    }
}
?>
<script src="js/days_off_jquery.js"></script>