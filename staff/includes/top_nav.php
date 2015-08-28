<?php
$page_names=explode("/",$_SERVER['SCRIPT_NAME']);

$pagename_pos = count($page_names)-1;

$page_name_new= $page_names[$pagename_pos];
$user_id         = $_SESSION['supply_user_id'];
$totoal_cart     = totalCart($user_id);
?>
<?php if (isset($_SESSION['supply_user_id'])) { ?>
    <div >
        <ul class="navigation primary" style="float:right !important;"><li class="navPlotting" style=" border-bottom: none !important;"><a href="#" style="font-weight: bolder;color: #F00 !important;">WELCOME <?php echo strtoupper($_SESSION['supply_user_name']); ?></a></li>
<!--            <li class="navLargeFormat" style=" border-bottom: none !important;"><a href="addressbook.php" style="<?php if($page_name_new=='addressbook.php') { echo "font-weight: bold;"; } ?>">ADDRESS BOOK</a></li>-->
            <li class="navLargeFormat" style=" border-bottom: none !important;"><a href="shoppingcart.php?comp_id=<?php echo $_SESSION['supply_comp_id']; ?>&usr_id=<?php echo $_SESSION['supply_usr_id']; ?>" style="<?php if($page_name_new=='shoppingcart.php') { echo "font-weight: bold;"; } ?>">CART</a></li>
            <li class="navLargeFormat" style=" border-bottom: none !important;"><a href="logout.php">LOGOUT</a></li>
        </ul>
        <div style="clear:both"></div> 
    </div>                                                                                                                    
<?php } ?>                                                                                                                    

<div id="content_output-navigation">
    <div style="clear:both"></div>                                        				
</div>
