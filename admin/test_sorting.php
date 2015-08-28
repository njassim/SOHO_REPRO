<?php
error_reporting(E_ALL & ~E_NOTICE);

   
    $link = mysql_connect('localhost', 'root', '');

    $db_selected = mysql_select_db('supply.sohorepro.com', $link);
    
    $base_url="http://".$_SERVER['SERVER_NAME']."";

if (!$db_selected) {
    die('Database not connected : ' . mysql_error());
}
echo mysql_error();



function getOrdersAllTest($sorting) {
    //return $sorting;
    if ($sorting == 'a') {
        $select_orders = "SELECT * FROM sohorepro_order_master WHERE closed_status = '0'  ORDER BY created_date ASC";
    } elseif ($sorting == 'd') {
        $select_orders = "SELECT * FROM sohorepro_order_master WHERE closed_status = '0' ORDER BY created_date DESC";
    } elseif ($sorting == 'jnd') {
        $select_orders = "SELECT * FROM sohorepro_order_master WHERE closed_status = '0' ORDER BY order_id DESC";
    } elseif ($sorting == 'jna') {
        $select_orders = "SELECT * FROM sohorepro_order_master WHERE closed_status = '0' ORDER BY order_id ASC";
    } elseif ($sorting == 'pd') {
        $select_orders = "SELECT * FROM sohorepro_order_master WHERE closed_status = '0' ORDER BY customer_company_name DESC";
    } elseif ($sorting == 'pa') {
        $select_orders = "SELECT * FROM sohorepro_order_master WHERE closed_status = '0' ORDER BY customer_company_name ASC";
    } else {
        $select_orders = "SELECT * FROM sohorepro_order_master WHERE closed_status = '0' ORDER BY id DESC";
    }
    $orders = mysql_query($select_orders);
    while ($object = mysql_fetch_assoc($orders)):
        $value[] = $object;
    endwhile;
    return $value;
}

$sort_date = ($_REQUEST['sort'] == 'a') ? 'd' : 'a';
$sort_date_img = ($_REQUEST['sort'] == 'a') ? 'down' : 'up';

$sort_jrn = ($_REQUEST['sort'] == 'jna') ? 'jnd' : 'jna';
$sort_jrn_img = ($_REQUEST['sort'] == 'jna') ? 'down' : 'up';

$sort_prc = ($_REQUEST['sort'] == 'pa') ? 'pd' : 'pa';
$sort_prc_img = ($_REQUEST['sort'] == 'pa') ? 'down' : 'up';



$Orders = getOrdersAllTest($_REQUEST['sort']);
?>
<title>ORDERING</title>
<table width="759" border="0" cellspacing="0" cellpadding="0">      
    
    <tr>
        <td align="left" valign="top"><table width="759" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="258" valign="middle" height="28" bgcolor="#f99b3e" align="center" class="td_brdr"><a style="text-decoration: none; color: #fff;" href="test_sorting.php?sort=<?php echo $sort_jrn; ?>">ORDER NUMBER&nbsp;<img src="images/<?php echo $sort_jrn_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>
                    <td width="120" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="test_sorting.php?sort=<?php echo $sort_date; ?>">DATE &nbsp;<img src="images/<?php echo $sort_date_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>                
                    <td width="189" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e"><a style="text-decoration: none; color: #fff;" href="test_sorting.php?sort=<?php echo $sort_prc; ?>">Customer&nbsp;<img src="images/<?php echo $sort_prc_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>
                    <td width="258" valign="middle" height="28" bgcolor="#f99b3e" align="center" class="td_brdr"><a style="text-decoration: none; color: #fff;" href="test_sorting.php?sort=<?php echo $sort_jrn; ?>">JOB REFERENCE&nbsp;<img src="images/<?php echo $sort_jrn_img; ?>.png"  alt="" width="10px" height="5px"/></a></td>                
                </tr>
            <?php
            $i = 1;
            if (count($Orders) > 0) {
                foreach ($Orders as $order) {
                    $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                    $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                    $id = $order['id'];
                    $orderser_id = $order['id'];
                    $order_id = $order['order_id'];
                    $order_numer = $order['order_number'];
                    //$date = date("m-d-Y h:m A", strtotime($order['created_date']));

                    $current_time = $order['created_date'];
                    $datew = new DateTime($current_time, new DateTimeZone('America/New_York'));
                    date_default_timezone_set('America/New_York');
                    $temp_times = date("Y-m-d h:iA", $datew->format('U'));
                    $date = date("m/d/Y", strtotime($order['created_date'])) . ' ' . date("h:iA", strtotime("-0 minutes", strtotime($temp_times)));
                    $customer = ($order['customer_company_name'] != '') ? $order['customer_company_name'] : 'Guest User';
                    //$price = getPrice($id);
                    //$tax_status = getTaxStatusChk($order['customer_company']);
                    $cas_customer = $order['cash_customer'];
                    //$tax_value = TaxValue();
                    if ($tax_status == '1') {
                        $tax_line = '0';
                    }
                    //               elseif($cas_customer == '1')
                    //                {
                    //                 $tax_line = '8.875';      
                    //                 }
                    else {

                        $tax_line = $tax_value;
                    }
                    $tax = ($tax_line * ($price[0]['sub_total'] / 100));
                    $grand_tot = ($price[0]['sub_total'] + $tax);
                    ?>

                        <tr class="trigger"  id="<?php echo $id; ?>"> 
                            <td width="210" height="36" align="center" bgcolor="<?php echo $rowColor; ?>"   valign="middle"><?php echo $order_numer; ?></td>             
                            <td width="176" height="36" align="center" bgcolor="<?php echo $rowColor1; ?>"  valign="middle"><?php echo $date; ?></td>                                    
                            <td width="109" height="36" align="center" bgcolor="<?php echo $rowColor; ?>"   valign="middle"><span id="customer_name_<?php echo $id; ?>"><?php echo $customer; ?></span></td>                
                            <td width="210" height="36" align="center" bgcolor="<?php echo $rowColor1; ?>"  valign="middle"><span class="refj_<?php echo $id; ?>" id="<?php echo $id; ?>"><?php echo $order_id; ?></span></td>
                            </t>
                        <?php
                       // $toggle_id = viewOrders($id);
                        $ord_id = $toggle_id[0]['order_id'];
                        ?>           


                        <?php
                        $i++;
                    }
                } else {
                    ?>
                    <tr  bgcolor="<?php echo $rowColor; ?>">
                        <td colspan="4" align="center">There is no orders</td>
                    </tr>              
                    <?php } ?>

            </table></td>
    </tr>
</table>

