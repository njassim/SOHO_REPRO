<?php
include './config.php';

if (isset($_POST['invoice_type']) && !empty($_POST['invoice_type'])) {

    $invoice_type = $_POST['invoice_type'];
    $invoice_order_id = $_POST['invoice_order_id'];
    $invoice_comp_id = $_POST['invoice_comp_id'];

    $selectInvoiceOrder = SelectInvoiceOrder($invoice_order_id, $invoice_comp_id);
    
    $customer_details   = Get_users_add($invoice_comp_id);
    
    //Terms
    if($invoice_type == 'week'){
        $terms = 'Net 7 Days';
    }elseif ($invoice_type == 'semi') {
        $terms = 'Net 15 Days';
    }elseif ($invoice_type == 'month') {
        $terms = 'Net 30 Days';
    }
}
?>
<div style="width: 100%;float: left;">
    <div style="width: 49%;float: left;">&nbsp;</div>
    <div style="width: 50%;float: left;"> 
        <div style="width: 75%;float: right;border: 1px #000 solid;border-bottom: 0px;padding: 5px;text-align: center;">
            <span style="padding-right: 20px;">Invoice Number : <b>98568</b></span><span><b>Page : 1</b></span>
        </div>
        <div style="width: 75%;float: right;border: 1px #000 solid;padding: 5px;text-align: center;font-weight: bold;">
            <span style="padding-right: 10px;">Date : 06/09/2015</span><span>Terms : <?php echo $terms; ?></span>
        </div>
    </div>
</div>
<div style="width: 100%;float: left;margin-top: 40px;">
    <div style="width: 40%;float: left;margin-left: 30px;font-weight: bold;">
        <span style="width: 100%;float: left;"><?php echo $customer_details[0]['comp_name']; ?></span>
        <span style="width: 100%;float: left;"><?php echo $customer_details[0]['comp_business_address1']; ?></span>
        <span style="width: 100%;float: left;"><?php echo $customer_details[0]['comp_business_address2']; ?></span>
        <span style="width: 100%;float: left;"><?php echo $customer_details[0]['comp_business_address3']; ?></span>
        <span style="width: 100%;float: left;"><?php echo $customer_details[0]['comp_city'].','.$customer_details[0]['comp_state'].'&nbsp;'.$customer_details[0]['comp_zipcode']; ?></span>
    </div>
</div>
<div class="inv_desc" style="width: 100%;float: left;margin-top: 40px;border: 1px #000 solid;height: 40px;font-weight: bold;">    
        <span style="padding-left: 10px; width: 14%;">Job Number</span>
        <span style="width: 10%;">Date</span>
        <span style="width: 18%;">Item Description</span>
        <span style="width: 14%;">Quantity</span>
        <span style="width: 14%;">Unit Price</span>
        <span style="width: 14%;">Tax</span>
        <span style="width: 14%;">Total</span>
</div>

