<?php
include './config.php';

function viewOrdersShipp_test($id,$Order_id) {
    $select_orders = "SELECT * FROM sohorepro_product_master WHERE shipping_add_id = '".$id."' AND order_id = '".$Order_id."' " ;
    $details       = mysql_query($select_orders);
    while ($object = mysql_fetch_assoc($details)):
        $value[] = $object;
    endwhile;
    return $value;
}


function MultiShippingAddress($Order_id) {
    $select_orders = "SELECT * FROM sohorepro_multi_shipping WHERE order_id = '".$Order_id."' " ;
    $details       = mysql_query($select_orders);
    while ($object = mysql_fetch_assoc($details)):
        $value[] = $object;
    endwhile;
    return $value;
}


$multi      = MultiShippingAddress(25);


foreach ($multi as $multi_shipp){

$address_multi_pre    = SelectIdAddress($multi_shipp['shipping_id']);

$address_multi_1    =  ($address_multi_pre[0]['address_1'] != '')  ? $address_multi_pre[0]['address_1'].'<br>' : '';
$address_multi_2    =  ($address_multi_pre[0]['address_2'] != '')  ? $address_multi_pre[0]['address_2'].'<br>' : '';
$address_multi_3    =  ($address_multi_pre[0]['address_3'] != '')  ? $address_multi_pre[0]['address_3'].'<br>' : '';
    
$address_for_items_pre[] = '<span style="font-weight:bold;">Item&nbsp;:&nbsp;'.$multi_shipp['item_id'].'<br></span><span style="font-weight:bold;">Shipping Address: </span><br>'.$address_multi_pre[0]['company_name'].'<br>'.$address_multi_1.$address_multi_2.$address_multi_3.$address_multi_pre[0]['city'].',&nbsp;'.StateName($address_multi_pre[0]['state']).'&nbsp;'.$address_multi_pre[0]['zip'].'<br><br><span style="font-weight:bold;">Delivery Date :</span>' . $deleivery_date;
    
}

$message .= '<table align="left">';
for ($m = 0; $m<count($address_for_items_pre); $m+=3)
{
    $message.= '<tr>
                <td>'.$address_for_items_pre[$m].'</td>
                <td>'.$address_for_items_pre[$m+1].'</td>
                <td>'.$address_for_items_pre[$m+2].'</td>
            </tr>';
    $message.= '<tr><td>&nbsp;</td></tr>';
}
$message .= '</table>';


echo $message;