<?php
$page_names=explode("/",$_SERVER['SCRIPT_NAME']);

$pagename_pos = count($page_names)-1;

$page_name_new= $page_names[$pagename_pos];
$user_id         = $_SESSION['sohorepro_userid'];
$totoal_cart     = totalCart($user_id);
$comp_name       = getCompName($_SESSION['sohorepro_companyid']);
?>
<?php if (isset($_SESSION['sohorepro_userid'])) { ?>
<div style="float: left;width: 30%;">
    <ul class="navigation primary" style="float:left !important;width: 100%;">
            <li class="navLargeFormat" style=" border-bottom: none !important;">
                <a href="index.php" style="<?php if($page_name_new=='index.php') { echo "font-weight: bold;"; } ?>">SUPPLIES</a>
            </li>
            <li class="navLargeFormat" style=" border-bottom: none !important;">
                <a href="service_plotting.php" style="<?php if($page_name_new=='service_plotting.php') { echo "font-weight: bold;"; } ?>">SERVICES</a>
            </li>
        </ul>
</div>  
<div style="float: right;width: 70%;">        
        <ul class="navigation primary" style="float:right !important;">
            <li class="navPlotting" style=" border-bottom: none !important;">
                <a href="index.php" style="font-weight: bolder;color: #F00 !important;">WELCOME <?php echo strtoupper($_SESSION['sohorepro_username']); ?></a>
                <div style="float: left;width: 100%;padding: 0px;margin-top: -10px;"><?php echo $comp_name; ?></div>
            </li>
            <li class="navLargeFormat" style=" border-bottom: none !important;"><a href="addressbook.php" style="<?php if($page_name_new=='addressbook.php') { echo "font-weight: bold;"; } ?>">ADDRESS BOOK</a></li>
            <li class="navLargeFormat" style=" border-bottom: none !important;"><a href="shoppingcart.php" style="<?php if($page_name_new=='shoppingcart.php') { echo "font-weight: bold;"; } ?>">CART</a></li>
            <!--<li class="navLargeFormat" style=" border-bottom: none !important;"><a href="help_box_logged.php" style="color:  #007F2A !important;<?php if($page_name_new=='help_box_logged.php') { echo "font-weight: bold;"; } ?>">HELP BOX</a></li>-->            
            <li class="navLargeFormat" style=" border-bottom: none !important;"><a href="logout.php">LOGOUT</a></li>            
        </ul>
        <div style="clear:both"></div> 
    </div>                                                                                                                    
<?php }  else {
 ?>
<div style="float: right;">        
        <ul class="navigation primary" style="float:right !important;width: 100%;">            
            <li class="navLargeFormat" style=" border-bottom: none !important;"><a href="help_box.php" style="cursor: pointer;color:  #007F2A !important;">HELP BOX</a></li>            
        </ul>
        <div style="clear:both"></div> 
</div>   
<?php
} ?>                                                                                                                    

<div id="content_output-navigation">
<!--    <ul class="navigation primary"><li class="navPlotting"><a href="#" class=" ">PLOTTING &amp; ARCHITECTURAL COPIES</a></li>
        <li class="navLargeFormat"><a href="#" class=" ">LARGE FORMAT COLOR &amp; BW</a></li>
        <li class="navFineArts"><a href="#" class=" ">FINE ART PRINTING</a></li>
        <li class="navCopyshop"><a href="#" class=" ">COPY SHOP</a></li>
        <li class="navMounting"><a href="#" class=" ">MOUNTING &amp; LAMINATING</a></li>
        <li class="navBinding"><a href="#" class=" ">BINDING</a></li>
        <li class="navScanning"><a href="#" class=" ">SCANNING</a></li>
        <li class="navOffset"><a href="#" class=" ">OFFSET PRINTING</a></li>
    </ul>-->
    <div style="clear:both"></div>                                        				
</div>
