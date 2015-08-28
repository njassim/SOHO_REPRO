<div style="border: 2px #F99B3E solid;padding-bottom: 20px;margin-bottom : 5px;width: 100%;float: left;" class="shaddows">
<div style="width: 100%;float: left;margin-top: 10px;">
<div style="float: left;width: 48%;margin-left: 10px;font-weight: bold;">RECIPIENT <?php echo $r; ?></div>
<div style="float: right;width: 20%;font-weight: bold;">
<span title="Edit Recipient" alt="Edit Recipient" style="font-weight: bold;cursor: pointer;padding-right: 15px;font-weight: bold;padding-right: 15px;background: #009C58;color: #FFF;padding: 2px 10px;border-radius: 5px;margin-top: 3px;" onclick="return edit_recipient('<?php echo $entered_sets['id']; ?>');">Edit</span>
<span title="Delete Recipient" alt="Delete Recipient" style="font-weight: bold;cursor: pointer;background: #D84B36;color: #FFF;padding: 2px 8px;border-radius: 5px;margin-top: 3px;font-weight: bold;" onclick="return delete_recipient('<?php echo $entered_sets['id']; ?>');">Delete</span>
</div>
<div style="float: left;width: 65%;margin-left: 30px;margin-top: 10px;font-weight: bold;">Send to :</div>
<div style="float: left;width: 33%;margin-left: 30px;">  
<?php
$add_2 = ($shipp_add[0]['address_2'] == '') ? '' : $shipp_add[0]['address_2'] . ',<br>';
echo $shipp_add[0]['company_name'] . '<br>' . $shipp_add[0]['address_1'] . ',<br>' . $add_2 . $shipp_add[0]['city'] . ',&nbsp;' . StateName($shipp_add[0]['state']) . '&nbsp;' . $shipp_add[0]['zip'] . '<br>' . 'Attention To :' . $entered_sets['attention_to'];
?>                   
</div>
<div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>
<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
<table border="1" style="width: 100%;">
<tr bgcolor="#F99B3E">
<td style="font-weight: bold;">Sets</td> 
<td style="font-weight: bold;">Order Type</td>                            
<td style="font-weight: bold;">Size</td>
<td style="font-weight: bold;">Output</td>
<td style="font-weight: bold;">Binding</td>
<td style="font-weight: bold;">Folding</td>
</tr>
<tr bgcolor="#ffeee1">
<td><?php echo $entered_sets['plot_needed']; ?></td>
<td>Plotting on Bond</td>                            
<td><?php echo $entered_sets['size']; ?></td>
<td><?php echo $entered_sets['output']; ?></td>
<td><?php echo $entered_sets['binding']; ?></td>
<td><?php echo $entered_sets['folding']; ?></td>
</tr>
</table>
</div> 
 <?php
if ($entered_sets['size'] == 'Custom') {
?>
<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
<div style="font-weight: bold;width: 100%;float: left;">
Custom Size Details :
</div>
<div style="width: 100%;float: left;">                    
<?php echo $entered_sets['custome_details']; ?>
</div>
</div>
<?php }
if ($entered_sets['output'] == 'Both') {
?>
<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">
<div style="font-weight: bold;width: 100%;float: left;">
Color Pages :
</div>
<div style="width: 100%;float: left;">                    
<?php echo $entered_sets['output_page_number']; ?>
</div>
</div>
<?php } ?>
<div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;">
<?php
$date_asap = ($entered_sets['shipp_time'] != 'ASAP') ? '&nbsp;&nbsp;&nbsp;' . $entered_sets['shipp_time'] : '';
?>
<span style="font-weight: bold;">When Needed : </span><?php echo $entered_sets['shipp_date'] . $date_asap; ?>            
</div>        
<?php
if ($entered_sets['delivery_type'] != '0') {
?>
<div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
<span style="font-weight: bold;">Send Via :</span>
</div>
<div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
<?php
if ($entered_sets['delivery_type'] == '1') {
    $delivery_type = 'Next Day Air';
} elseif ($entered_sets['delivery_type'] == '2') {
    $delivery_type = 'Two Day Air';
} elseif ($entered_sets['delivery_type'] == '3') {
    $delivery_type = 'Three Day Air';
} elseif ($entered_sets['delivery_type'] == '4') {
    $delivery_type = 'Ground';
}

$ship_type_1 = ($entered_sets['shipp_comp_1'] == '0') ? '' : $entered_sets['shipp_comp_1'];
$ship_type_2 = ($entered_sets['shipp_comp_2'] == '0') ? '' : $entered_sets['shipp_comp_2'];
$ship_type_3 = ($entered_sets['shipp_comp_3'] == '0') ? '' : $entered_sets['shipp_comp_3'];

echo $ship_type_1 . $ship_type_2 . $ship_type_3 . ',&nbsp;' . $delivery_type . ',&nbsp;Account # ' . $entered_sets['billing_number'];
?>
</div>
<?php } else { ?>                            
<div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
<span style="font-weight: bold;">Send Via :</span>
</div>
<div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">
SOHO TO ARRANGE DELIVERY
</div>    
<?php } ?>        
</div>
</div>












<?php

$message .= '<div style="float: left;margin-top: 12px;margin-bottom: 20px;" class="shaddows">';
$message .= '<div class="ribbon" id="ribbon_final"><span style="background: #79A70A !important;">ORIGINAL</span></div>';  
$message .= '<div style="width: 100%;float: left;margin-top: 25px;margin-bottom: 10px;">';  
$message .= '<div class="details_div">';                      
$message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">Customer Details :</div>';
$message .= '<div style="float: left;width: 33%;margin-left: 30px;">';
$cust_add = getCustomeInfo($user_session_comp);
$cust_add_2 = ($cust_add[0]['comp_business_address2'] != '') ? $cust_add[0]['comp_business_address2']. ',<br>'  : '';                    
$message .= $cust_add[0]['comp_name'] . '<br>' . $cust_add[0]['comp_business_address1'] . ',<br>' . $cust_add_2 . $cust_add[0]['comp_city'] . ',&nbsp;' . $cust_add[0]['comp_state'] . '&nbsp;' . $cust_add[0]['comp_zipcode'];                
$message .= '</div>';  
$message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">User Details :</div>';
$message .= '<div style="float: left;width: 33%;margin-left: 30px;">'; 
$cust_user_add  = UserLoginDtls($user_session);
$cust_user_name = $cust_user_add[0]['cus_fname'].'&nbsp;'.$cust_user_add[0]['cus_lname'];
$cust_mail_id   = $cust_user_add[0]['cus_email'];
$cust_phone_num = $cust_user_add[0]['cus_contact_phone'];
$message .= $cust_user_name . '<br>' . $cust_mail_id . '<br>' . $cust_phone_num. '<br>Date :'. date('m-d-Y h:i A', time());
$message .= '</div>';
$message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div>'; 
$message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">';
$cust_original_order    = EnteredPlotRecipients($user_session_comp, $user_session);
$cust_needed_sets       = ($cust_original_order[0]['print_ea'] != '0') ? $cust_original_order[0]['print_ea'] : $cust_original_order[0]['arch_needed'];
$cust_order_type        = ($cust_original_order[0]['arch_needed'] == '0') ? 'Copies' : 'Plotting on Bond';
$message .= '<table border="1" style="width: 100%;">'; 
$message .= '<tr bgcolor="#BFC5CD">'; 
$message .= '<td style="font-weight: bold;">Sets</td>'; 
$message .= '<td style="font-weight: bold;">Order Type</td>';
$message .= '<td style="font-weight: bold;">Size</td>'; 
$message .= '<td style="font-weight: bold;">Output</td>'; 
$message .= '<td style="font-weight: bold;">Binding</td>'; 
$message .= '<td style="font-weight: bold;">Folding</td>'; 
$message .= '</tr>'; 
$message .= '<tr bgcolor="#F8F8F8">'; 
$message .= '<td>'.$cust_needed_sets.'</td>'; 
$message .= '<td>'.$cust_order_type.'</td>';                             
$message .= '<td>'.$cust_original_order[0]['size'].'</td>'; 
$message .= '<td>'.$cust_original_order[0]['output'].'</td>'; 
$message .= '<td>'.$cust_original_order[0]['binding'].'</td>'; 
$message .= '<td>'.$cust_original_order[0]['folding'].'</td>'; 
$message .= '</tr>'; 
$message .= '</table>'; 
$message .= '</div>';
if($cust_original_order[0]['size'] == 'Custom'){
$message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">'; 
$message .= '<div style="font-weight: bold;width: 100%;float: left;">Custom Size Details :</div>'; 
$message .= '<div style="padding-top: 3px;">'.$cust_original_order[0]['custom_size'].'</div>'; 
$message .= '</div>'; 
}
if($cust_original_order[0]['output'] == 'Both'){
$message .= '<div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">';
$message .= '<div style="font-weight: bold;width: 100%;float: left;">Page Number :</div>';
$message .= '<div style="padding-top: 3px;">'.$cust_original_order[0]['output_both'].'</div>';
$message .= '</div>';
}
$message .= '</div>';
$message .= '</div>';
$message .= '</div>';