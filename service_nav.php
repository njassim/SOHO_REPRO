<?php
$page_names=explode("/",$_SERVER['SCRIPT_NAME']);

$pagename_pos = count($page_names)-1;

$page_name_new= $page_names[$pagename_pos];
$user_id         = $_SESSION['sohorepro_userid'];
$totoal_cart     = totalCart($user_id);
?>
<div id="content_output-navigation">
    <ul class="navigation primary">
        <li class="navPlotting">
            <a href="service_plotting.php" class=" " style="<?php if($page_name_new=='service_plotting.php') { echo "font-weight: bold;"; } ?>">
                PLOTTING &amp; ARCHITECTURAL COPIES
            </a>
        </li>
        <li class="navLargeFormat">
            <a href="service_largeformat.php" class=" " style="<?php if($page_name_new=='service_largeformat.php') { echo "font-weight: bold;"; } ?>">
                LARGE FORMAT COLOR &amp; BW
            </a>
        </li>
        <li class="navFineArts">
            <a href="service_finearts.php" class=" " style="<?php if($page_name_new=='service_finearts.php') { echo "font-weight: bold;"; } ?>">
                FINE ART PRINTING
            </a>
        </li>
        <li class="navCopyshop">
            <a href="service_copyshop.php" class=" " style="<?php if($page_name_new=='service_copyshop.php') { echo "font-weight: bold;"; } ?>">
                COPY SHOP
            </a>
        </li>
        <li class="navMounting">
            <a href="service_lamination.php" class=" " style="<?php if($page_name_new=='service_lamination.php') { echo "font-weight: bold;"; } ?>">
                MOUNTING &amp; LAMINATING
            </a>
        </li>
        <li class="navBinding">
            <a href="service_binding.php" class=" " style="<?php if($page_name_new=='service_binding.php') { echo "font-weight: bold;"; } ?>">
                BINDING
            </a>
        </li>
        <li class="navScanning">
            <a href="service_scanning.php" class=" " style="<?php if($page_name_new=='service_scanning.php') { echo "font-weight: bold;"; } ?>">
                SCANNING
            </a>
        </li>
        <li class="navOffset">
            <a href="service_offset.php" class=" " style="<?php if($page_name_new=='service_offset.php') { echo "font-weight: bold;"; } ?>">
                OFFSET PRINTING
            </a>
        </li>
    </ul>
    <div style="clear:both">
    </div>

</div>