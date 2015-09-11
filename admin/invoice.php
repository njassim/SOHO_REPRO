<?php
include './config.php';
include './auth.php';

$sort_date = ($_REQUEST['sort'] == 'a') ? 'd' : 'a';
$sort_date_img = ($_REQUEST['sort'] == 'a') ? 'down' : 'up';

$sort_jrn = ($_REQUEST['sort'] == 'jna') ? 'jnd' : 'jna';
$sort_jrn_img = ($_REQUEST['sort'] == 'jna') ? 'down' : 'up';

$sort_prc = ($_REQUEST['sort'] == 'pa') ? 'pd' : 'pa';
$sort_prc_img = ($_REQUEST['sort'] == 'pa') ? 'down' : 'up';


$page = 1; //Default page
$limit = 25; //Records per page
$start = 0; //starts displaying records from 0
if (isset($_GET['page']) && $_GET['page'] != '') {
    $page = $_GET['page'];
}
$start = ($page - 1) * $limit;
if ($_GET['limite']) {
    $limit = $_GET['limite'];
}

$Orders = getOrdersAll($_REQUEST['sort'], $start, $limit);
$rows = count(OrdersCount());


if ($_GET['tax_status']) {

    $tax_id = $_GET['tax_status'];
    $sql = "UPDATE sohorepro_product_master SET tax_status = '0' WHERE order_id = " . $tax_id . " ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_tax";
    } else {
        $result = "failure_tax";
    }
}

?>

 <?php
	include './mpdf/mpdf.php';
	if($_POST['company_id'] != '' && $_POST['invoice_order_id'] != '' )
	{
	
	extract($_POST);
	
	// print_r($invoice_order_id); exit;
	
	$comp_id = getCustomeInfo($company_id);
	// $inv_id = GetInvoice_ID($invoice_order_id);
	$comp_bussiness_add_1 =$comp_id[0]['comp_business_address1'];
    $comp_bussiness_add_2 =$comp_id[0]['comp_business_address2'];
	$company_city = $comp_id[0]['comp_city'];
	$company_state = $comp_id[0]['comp_state'];
	$company_zip = $comp_id[0]['comp_zipcode'];
	$Invoice_Type =$comp_id[0]['invoice_type'];
	$company_name = $comp_id[0]['comp_name'];
	 $comp_name =str_replace(" ","_",$comp_id[0]['comp_name']);
	 $rand_number = rand(10500,25700);
	 $date = date('m-d-Y');
	 
	$sum = getTotalInvoice($company_id);
	foreach($sum as $product)
	{
	 $TotalInvoice_price = $product['grant_total'];
	 $Total_tax_value = TaxValue();
	 $Total_tax_rate = $Total_tax_value;
	 $TotalInvoice_total_tax = ($Total_tax_rate * ($TotalInvoice_price / 100));
	 $TotalInvoice_net_amount = ($TotalInvoice_price +  $TotalInvoice_total_tax);
	 // echo "<pre>";
	 // print_r($TotalInvoice_total_tax);
	 // echo "</pre>";
	}
	// exit;
	
	 
	  $mpdf = new mPDF('utf-8','A4-L','18');
      $pgThree = 'Page {PAGENO}';
	  
      $mpdf->setHTMLFooter('{PAGENO}'); 
	 
	   
	
	$message_header ='<table align ="right" width="65%" style="border:1px solid black;">';

     $message_header .= '<tr>';
	  $message_header .='<td><b>Invoice Number : '.$rand_number.'</b></td>';
	   $message_header .='<td><b>'.$pgThree.'</b></td>';
	   $message_header .= '</tr>';
	   $message_header .= '<tr>';
	  $message_header .='<td><b>Date : '.$date.'</b></td>';
	   $message_header .='<td><b>Terms: Net '.$Invoice_Type.' Days</b></td>';
	   $message_header .= '</tr>';  
	  

    $message_header .='</table>';
	
    $message_header.= '<h3 style="text-align:left; width:100%;">'.$company_name.'<br>'.$comp_bussiness_add_1.'<br>'.$comp_bussiness_add_2.'<br>'.$company_city.",".$company_state."&nbsp;".$company_zip;'</h3>';
	$message_header .='<table>';
	        $message_header .='<tr>';
			$message_header .='<th align="center" style="padding-left:5%;font-size:14px; width: 25%;"> JobNumber </th>';
			$message_header .='<th align="center" style="padding-left:-2 %;font-size:14px; width: 25%;">Date</th>';		
			$message_header .='<th align="center" style="padding:10px;font-size:14px; width: 25%;">Item Description</th>';
			$message_header .='<th align="center" style="padding-left:4%;font-size:14px; width: 25%;">Quantity</th>';
			$message_header .='<th align="center" style="padding-left:4%;font-size:14px; width: 25%;">Unit Price</th>';
			$message_header .='<th align="center" style="padding-left:6%;font-size:14px; width: 25%;">Extended Price</th>';
			$message_header .='<th align="center" style="padding-left:6%;font-size:14px; width: 25%;">Tax</th>';
			$message_header .='<th align="center" style="padding-left:3%;font-size:14px; width: 25%;">Total</th>';
			$message_header .=	'</tr>';
			$message_header .='</table>';
	 
	 $mpdf->SetHTMLHeader($message_header);	
	 
	  
	
	$message = '<tr>';
	$message .= '<td align="left" valign="top">';
	
         	
		 // $message .='<h3 style="text-align:left; width:50%;">'.$comp_bussiness_add_1.'<br>'.$comp_bussiness_add_2.'</h3>';    
		$message .='<table style="width:100%;">';
		

        
		
		$invoice_orders = GetInvoice_ID($company_id);
		
        
		$i=1;
		foreach ($invoice_orders as $invoice){
			$rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
			$company_name = $invoice['customer_company_name'];
			$order          = InvoiceOrders_Reference($invoice['company_name']);
			// $current_date = date("m/d", strtotime($inv_id[0]['created_date']));
           $current_date = date("m/d", strtotime($invoice['created_date']));			
		   // print_r($current_date); exit;
            			 
        
							  
		
			foreach ($order as $inv_prod_invoice){
			$Invoice_products = GetInvoiceviewOrders($inv_prod_invoice['order_id']);
			$sql = mysql_query("SELECT DISTINCT order_sequence,created_date from sohorepro_invoice where order_id = '".$inv_prod_invoice['order_id']."'");
			 $result = mysql_fetch_assoc($sql);
			 $order_sequence = array($result['order_sequence']);
			 $date = array(date("m/d", strtotime($result['created_date'])));
			
			
			// echo 'REFERENCE : '.$inv_prod['order_id'].'<br>';  exit;                                         
			// $GetInvProd = GetOrderIdInvoice($inv_prod['order_id'],$inv_prod['customer_name'],$inv_prod['customer_company']);
			// print_r($GetInvProd);exit;
			// foreach ($GetInvProd as $order_number){ 
			 // $Invoice_products = viewOrders($order_number['id']);
			 
	    
						 
		
			
			
			
			
		  $message .='<tr>';
		  $message .='<th style="text-align:center;width:10%;padding:10px;">Reference:'.$inv_prod_invoice['job_reference'].'</th>';
		  $message .='</tr>';
		  
		        $k=0;
			    $j=1;
				foreach($Invoice_products as $product) {
			   
				$product_name = $product['product_name'];
				$product_price = $product['product_price'];
				$product_quantity = $product['product_qty'];
				$unit_cost = $product['line_cost']; 

				 $tax_value = TaxValue();
				 $tax_rate = $tax_value;
				 $tax = ($tax_rate * ($unit_cost/100));
				 $grand_tot = ($unit_cost + $tax ); 
				 $subtotal_price = getInvoicePrice($product['order_id']);
                   				
				              
						  
		$message .='<tr>';
				 
		$message .= '<td align="center" style="width: 20%;">'.$order_sequence[$k].'</td>';
		$message .= '<td align="center" style="width: 20%;">'.$date[$k].'</td>';
		$message .= '<td align="center" style="width: 20%;">'.$product_name.'</td>';
		$message .=	'<td align="center" style="width: 30%;">'.$product_quantity.'</td>';
		$message .=	'<td align="center" style="width: 20%;">'.'$'.$product_price.'</td>';
		$message .=	'<td align="center" style="width: 30%;">'.'$' . number_format($unit_cost,2, '.', '').'</td>';
					
		$message .=	'<td align="center" style="width: 20%;">'.'$'. number_format($tax,2, '.', '').'</td>';
		$message .=	'<td align="center" style="width: 20%;">'. '$' . number_format($grand_tot,2, '.', '').'</td>';
		$message .='</tr>';
					 $k++;
						  } $j++;
						 
						  
				 
						  
						   
							   $total_tax = ($tax_rate * ($subtotal_price[0]['sub_total'] / 100));
							   $net_amount = ($subtotal_price[0]['sub_total'] +  $total_tax);
							   
							  
							  
						 
						   
					
						 $message .= '<tr>';
						 $message .='<td colspan="4"></td>';
						 
						 $message .='<td style="text-align:center;width: 10%;"><b>Subtotal</b></td>';
						 $message .='<td style="text-align:center;width: 10%;"><b>'.'$' . number_format($subtotal_price[0]['sub_total'],2, '.', '').'<b></td>';
						 $message .='<td style="text-align:center;width: 10%;"><b>'.'$' . number_format($total_tax,2, '.', '').'</b></td>';
						 $message .='<td style="text-align:center;width: 10%;"><b>'.'$' . number_format($net_amount,2, '.', '').'</b></td>';
						  
						  $message .='</tr><br><br>';
						  
						    
						  // } 
						  
						  
						  } 
						
						 $message .= '<tr style="padding:10px;">';
						 
						 $message .='<td colspan="4"></td>';
						 // $message .='<hr style="width:50%;text-align:right;">';
						 $message .='<td style="text-align:center;width: 10%;"><b>Total Invoice</b></td>';
						
						 $message .='<td style="text-align:center;width: 10%;"><b>'.'$' . number_format($TotalInvoice_price,2, '.', '').'<b></td>';
						 $message .='<td style="text-align:center;width: 10%;"><b>'.'$' . number_format($TotalInvoice_total_tax,2, '.', '').'<b></td>';
						 $message .='<td style="text-align:center;width: 10%;"><b>'.'$' . number_format($TotalInvoice_net_amount,2, '.', '').'<b></td>';
						  
						  $message .='</tr>';
						  
						   
						$message .='</table>';
				
				$message .='</td>';
		$message .='</tr>'; 
				
				
			$message .='</td>';
			
	   $message .='</tr>';
	
	$message .='</td>';
$message .='</tr>';

						
	 
	$mpdf->WriteHTML($message);

	
    
	
    //$path = "../admin/PDF/product/".$comp_name.".pdf";
	$mpdf->Output($comp_name.'.pdf','D');
	
	 
				$i++;
				}
		
	exit;
	
	}

?>

<?php
/*
include './mpdf/mpdf.php';
  if (isset($_POST['submit']))
{
extract($_POST);
$mpdf = new mPDF();



$message = '<table style="width:100%;padding:10px;border:1px solid black;">
  <tr style="padding:10px;">
	<th style="padding:10px;">JobNumber</th>
	<th style="padding:10px;">Date</th>		
	<th style="padding:10px;">Item Description</th>
	<th style="padding:10px;">Quantity</th>
	<th style="padding:10px;">Unit Price</th>
	<th style="padding:10px;">Extended Price</th>
	<th style="padding:10px;">Tax</th>
	<th style="padding:10px;">Total</th>
  </tr>
 </table><br>
';
$message .='<h3 style="text-align:left;">'.$company_name_1.'</h3>';
$mpdf->WriteHTML($message);

 

$mpdf->Output('invoice1.pdf','D');

exit;
}

*/
?>




<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Soho-repro</title>
        <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="style/pagination.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
        <!-- Add fancyBox main JS and CSS files -->
        <!--<script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery.fancybox.css?v=2.1.5" media="screen" />
        <script type="text/javascript" src="js/jquery.fancyboxc.js?v=2.1.5"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery.fancyboxc.css?v=2.1.5" media="screen" />
        <script type="text/javascript">
            $(document).ready(function() {
                /**  Simple image gallery. Uses default settings*/
                $('.fancybox').fancybox();
                $('.fancyboxc').fancyboxc();
                /**  Different effects */
            });
        </script>-->
        <!--End -->
        <link href="../style/popup_style.css" rel="stylesheet" type="text/css" media="all" />
        <style>
            .fancybox-inner{ width:644px !important; float:left !important; height:500px !important;}
            .fancybox-wrap {left: 360px !important;}
            .fancyboxc-inner{ width:300px !important; float:left !important; height:260px !important;}
            .fancyboxc-wrap {left: 360px !important;}
            .fancyboxc-skin {
                border: 3px solid #F99B3E !important;
                -webkit-border-radius: 5px !important;
                -moz-border-radius: 5px !important;
                border-radius: 5px !important;
            }
            .pad_lft_j{ padding-left:20px; }
            .pad_rght_j{ padding-right:15px; }
            .brdr1{ border:1px solid #e1e1e1;}
            .brdr-top_j{ border-top:0px !important;}
            .brdr-lft_j{ border-left:0px !important;}
            .add_pro{font-size: 14px;color: #ff9600;font-weight: bold;text-decoration: none;}
            .close_order {
                -moz-box-shadow: 0px 0px 0px 0px #3dc21b;
                -webkit-box-shadow: 0px 0px 0px 0px #3dc21b;
                box-shadow: 0px 0px 0px 0px #3dc21b;
                background-color:#44c767;
                -moz-border-radius:11px;
                -webkit-border-radius:11px;
                border-radius:11px;
                border:1px solid #18ab29;
                display:inline-block;
                cursor:pointer;
                color:#ffffff;
                font-family:arial;
                font-size:17px;
                font-weight:bold;
                padding:5px 24px;
                text-decoration:none;
                text-shadow:1px 2px 2px #2f6627;
                float: right;
                margin-top: 25px;
            }
            .close_order:hover {
                background-color:#5cbf2a;
            }
            .close_order:active {
                position:relative;
                top:1px;
            }
            .pointer{cursor: pointer;}
            /* .trail:hover {font-size: 16px; cursor: pointer;} */

            .none{display: none;}

            .modal-overlay {
                opacity: 0.7;
                filter: alpha(opacity=0);
                position: fixed;
                top: 0;
                left: 0;
                z-index: 900;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.3) !important;
            }

            .customer_auto { 
                border-color:#cccccc; 
                padding:10px; 
                font-size:20px; 
                border-radius:6px; 
                border-width:2px; 
                border-style:groove; 
                background-color:#ffffff; 
                text-shadow:0px 0px 0px rgba(42,42,42,.75);  
                width: 275px;
            } 
            .customer_auto:focus { outline:none; } 

            .auto_reference{
                cursor: pointer;
                list-style-type: none;
            }

            .auto_reference li:hover
            {
                background:#FF7E00;
                color:#FFF;
                cursor:pointer;
            }
            .auto_reference li
            {
                border-bottom: 1px #999 dashed;
            }
            .auto_reference span{
                font-size: 18px;
            }

            #result_ref
            {
                background-color: #f3f3f3;
                border-top: 0 none;
                box-shadow: 0 0 5px #ccc;
                display: none;
                margin-top: 0;
                overflow: hidden;
                padding: 10px;
                position: fixed;
                /* right: 650px; */
                text-align: left;
                /* top: 186px; */
                width: 260px;
                height: 120px;
                overflow-y: auto;
                left: 45%;
            }
            .inv_desc span{               
                float: left;
                margin-top: 10px;
            }
			.styled-button-1 {
				-webkit-box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
				-moz-box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
				box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
				color:#333;
				background-color:#F99B3E;
				border-radius:5px;
				-moz-border-radius:5px;
				-webkit-border-radius:5px;
				border:none;
				font-family:'Helvetica Neue',Arial,sans-serif;
				font-size:16px;
				font-weight:700;
				height:29px;
				padding:4px 6px;
				text-shadow:#FE6 0 1px 0
				
				
				
						}
        </style>
        <!-- Add fancyBox main JS and CSS files -->
        <script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery.fancybox.css?v=2.1.5" media="screen" />



        <script type="text/javascript">
            $(document).ready(function() {
                /**  Simple image gallery. Uses default settings*/
                $('.fancybox').fancybox();

                /**  Different effects */
            });


            function change_customer(CUS_ID)
            {     
                $("#current_cus_id").val(CUS_ID);
                $("body").append("<div class='modal-overlay js-modal-close'></div>");
                $("#asap_popup").slideDown("slow");
            }

            function close_change_customer()
            {
                $("#current_cus_id").val();
                $(".modal-overlay").fadeOut();
                $("#asap_popup").slideUp("slow");
            }
            
            
            
            
        </script>
        <!--End -->
    </head>
    <body>
        <div id="loading" class="none"  style="position: fixed;top: 35%;left: 48%;padding: 5px;z-index: 9999;">
            <img src="images/login_loader.gif" border="0" />
        </div>

        <div id="asap_popup" style="display: none;font-size: 15px;position: fixed;top: 35%;left: 40%;padding: 5px;z-index: 10;position: absolute;z-index: 1000;width: 30%;background: white;border-bottom: 1px solid #aaa;border-radius: 4px;box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);border: 1px solid rgba(0, 0, 0, 0.1);background-clip: padding-box;">
            <div style="width: 96%;padding: 2%;float: left;font-size: 14px;line-height: 18px;text-align: center;">
                <h1 style="padding-bottom: 7px;">Select Customer</h1>
                <input type="hidden" name="current_cus_id" id="current_cus_id" value="" />
                <input type="text" class="customer_auto" id="customer_auto" value="" placeholder="Customer Name" onkeyup="return autosuggession();">
                <div id="result_ref">
                </div>
            </div>
            <div style="float: right;width: 98%;background-color: #EEE;padding: 1%;">               
                <span style="float: left;border: 1px solid #BBB;padding: 3px 10px;border-radius: 3px;cursor: pointer;" onclick="return assign_customer();">Assign</span>
                <span style="float: right;border: 1px solid #BBB;padding: 3px 10px;border-radius: 3px;cursor: pointer;" onclick="return close_change_customer();">Close</span>
            </div>
        </div>
        
        <div id="invoice_template" style="display: none;height: 485px;font-size: 15px;position: fixed;top: 400px;left: 29%;padding: 5px;z-index: 10;position: absolute;z-index: 1000;width: 56%;background: white;border-bottom: 1px solid #aaa;border-radius: 4px;box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);border: 1px solid rgba(0, 0, 0, 0.1);background-clip: padding-box;">
            <div id="invoice_template_content" style="width: 96%;padding: 2%;float: left;font-size: 14px;line-height: 18px;height: 410px;overflow-y: scroll;">
                
            </div>
            <div style="float: right;width: 98%;background-color: #EEE;padding: 1%;">               
                <span style="float: left;border: 1px solid #BBB;padding: 3px 10px;border-radius: 3px;cursor: pointer;" onclick="return generate_as_pdf();">Generate as PDF</span>
                <span style="float: right;border: 1px solid #BBB;padding: 3px 10px;border-radius: 3px;cursor: pointer;" onclick="return close_invoice_template();">Close</span>
            </div>
        </div>
        

        <?php
        if ($_GET['ord_id'] != '') {
            $order_id = $_GET['ord_id'];
            ?>
            <input type="hidden" name="ord_id" id="ord_id" value="<?php echo $order_id; ?>" />
            <script type="text/javascript">
                $(document).ready(function()
                {
                    var val = document.getElementById('ord_id').value;
                    $(".trigger").next(".test_" + val).fadeToggle('slow').siblings(".test_" + val).hide();
                });
            </script>
            <?php
        }
        ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center" valign="top">
                    <table width="960" border="0" cellspacing="0" cellpadding="0" style="min-width:760px;">
                        <tr>
                            <td width="198" align="left" valign="top" bgcolor="#464646"><table width="198" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="181" align="left" valign="top"><img src="images/logo.jpg" width="198" height="181"  alt=""/></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <?php include "sidebar_menu.php"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle" style="min-height:280px; float:left;"></td>
                                    </tr>
                                </table></td>
                            <td width="3" align="left" valign="top" bgcolor="#FFFFFF"></td>
                            <td width="759" align="left" valign="top" bgcolor="#FFFFFF">
                                <table width="759" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="48" align="center" valign="middle" bgcolor="#5f5f5f" class="heading">
                                            ADMINISTRATOR PAGE
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="38" align="center" valign="middle" bgcolor="#8b8b8b" class="sub_heading">
                                            INVOICE
                                            <span style="float: right;padding-right: 5px;">Welcome <?php
                                                if ($_SESSION['admin_user_type'] == '1') {
                                                    echo 'admin';
                                                } if ($_SESSION['admin_user_type'] == '2') {
                                                    echo 'Staff User';
                                                }
                                                ?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                            if ($_GET['delete_id']) {
                                                $delete_id = $_GET['delete_id'];
                                                $ord_id = $_GET['ord_id'];
                                                $sql = "DELETE FROM sohorepro_product_master WHERE id = " . $delete_id . " ";
                                                $sql_result = mysql_query($sql);
                                                if ($sql_result) {
                                                    $result = "success_del";
                                                } else {
                                                    $result = "failure_del";
                                                }
                                                if ($result == "success_del") {
                                                    ?>
                                                    <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Deleted Successfully</div>
                                                    <script>setTimeout("location.href=\'open_orders.php?ord_id=<?php echo $delete_id; ?>&ord_id=<?php echo $ord_id; ?>\'", 1000);</script>
                                                    <?php
                                                } elseif ($result == "failure_del") {
                                                    ?>
                                                    <div style="color:#F00; text-align:center; padding-bottom:10px;">Not Deleted</div>
                                                    <script>setTimeout("location.href=\'open_orders.php?ord_id=<?php echo $delete_id; ?>&ord_id=<?php echo $ord_id; ?>\'", 1000);</script>       
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            if ($result == "success_tax") {
                                                ?>
                                                <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Tax has been removed in this order</div>
                                                <script>setTimeout("location.href=\'open_orders.php\'", 1000);</script>
                                                <?php
                                            } elseif ($result == "failure_tax") {
                                                ?>
                                                <div style="color:#F00; text-align:center; padding-bottom:10px;">Tax has been not removed in this order</div>
                                                <script>setTimeout("location.href=\'open_orders.php\'", 1000);</script>       
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <div style="float: left;width:100%;background-color: #F99B3E;">
                                                <div style="float: left;width:100%;text-align: center;margin-top: 5px;margin-bottom: 5px;font-weight:bold;text-transform: uppercase;">Company Name</div>
                                            </div>
                                            <?php
                                            $invoice_orders = CheckInvoiceCompanyFilter();

                                            $i=1;
                                            foreach ($invoice_orders as $invoice){
                                                $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                $order          = InvoiceOrders_Reference($invoice['company_name']);
											   
											    $reference = $invoice['job_reference'];
												$order_sequence = $invoice['order_sequence'];
												$current_date = date("m/d", strtotime($invoice['created_date']));												
												$company_name = getCustomeInfo($invoice['customer_id']);
												$company_add_1 =($company_name[0]['comp_business_address1'] != '') ? $company_name[0]['comp_business_address1'] : '';
												$company_add_2 =($company_name[0]['comp_business_address2'] != '') ? $company_name[0]['comp_business_address2'] : '';
												$company_city = $company_name[0]['comp_city'];
												$company_state = $company_name[0]['comp_state'];
												$company_zip = $company_name[0]['comp_zipcode'];
											    $company_id = $company_name[0]['comp_id'];
											
													
                                            ?>
                                          <tr class="trigger"  id="<?php echo $invoice['order_id']; ?>">
						
							<td>
								<div style="width:100%; background-color:<?php echo $rowColor;?>; text-align:center;padding: 10px; box-sizing: border-box;">
								<b><?php echo $invoice['company_name']; ?></b>
								</div>
								
								
					 
         <tr class="toggle test_<?php echo $invoice['order_id'] ; ?>">
		   
					         
				
								<td colspan="4" align="center">  
								<table style="width:100%;border:1px solid black;">
								<tr>
										<th style="padding: 10px;"> JobNumber</th>
										<th style="padding: 10px;">Date</th>		
										<th style="padding: 10px;">Item Description</th>
										<th style="padding: 10px;">Quantity</th>
										<th style="padding: 10px;">Unit Price</th>
										<th style="padding: 10px;">Extended Price</th>
										<th style="padding: 10px;">Tax</th>
										<th style="padding: 10px;">Total</th>
									  </tr>
									  <h3 style="text-align:left;"><?php echo $invoice['company_name'].",".'<br>' .$company_add_1.'<br>'.$company_add_2.'<br>'.$company_city.",".$company_state."&nbsp;".$company_zip; ?>
									  <form name="pdf" id="pdf" method="post">
									    
									  <input type="submit" name="submit" value="Download PDF" class="styled-button-1" >
									  
									  </h3>
									    
									  
									       <?php
									        
                                            foreach ($order as $inv_prod_invoice){
											
                                           // echo 'REFERENCE : '.$inv_prod_invoice['job_reference'].'<br>';                                            
                                          
											  $Invoice_products = GetInvoiceviewOrders($inv_prod_invoice['order_id']);
											    // echo "SELECT DISTINCT order_sequence from sohorepro_invoice_section where order_id = '".$inv_prod_invoice['order_id']."'";
												 $sql = mysql_query("SELECT DISTINCT order_sequence,created_date from sohorepro_invoice where order_id = '".$inv_prod_invoice['order_id']."'");
												 $result = mysql_fetch_assoc($sql);
												 $order_sequence = array($result['order_sequence']);
												 $date = array(date("m/d", strtotime($result['created_date'])));
												        
												 //print_r($order_sequence);
                                                
											?>
													
												
                                           
									
									  
									<input type="hidden" name="company_id" value="<?php echo $company_id;?> " />
									<input type="hidden" name="invoice_order_id" value="<?php echo $invoice['order_id'];?> " />
									</form>
									  
									  <tr>
									  
									  <th style="padding: 10px;">Reference:&nbsp;&nbsp;&nbsp;<?php echo $inv_prod_invoice['job_reference']; ?></th>
									  
									  </tr>
									  
									  <?php    $k = 0;
									           $j=1;
                                                
                  					            foreach($Invoice_products as $product) {
											  	$product_name = $product['product_name'];
											    $product_price = $product['product_price'];
												$product_quantity = $product['product_qty'];
 									            $unit_cost = $product['line_cost']; 
 
                                                 $tax_value = TaxValue();
												 $tax_rate = $tax_value;
												 $tax = ($tax_rate * ($unit_cost/100));
												 $grand_tot = ($unit_cost + $tax ); 
												 $subtotal_price = getInvoicePrice($product['order_id']);
												 
									  ?>
								      
									  <tr>
									 
										<td style="text-align:center;padding: 10px;"><?php echo $order_sequence[$k]; ?></td>
										<td style="text-align:center;padding: 10px;"><?php echo $date[$k]; ?></td>
										<td style="text-align:center;padding: 10px;"><?php echo $product_name;  ?></td>
										<td style="text-align:center;padding: 10px;"><?php echo $product_quantity;  ?></td>
										<td style="text-align:center;padding: 10px;"><?php echo '$'.$product_price;  ?></td>
										<td style="text-align:center;padding: 10px;"><?php echo '$'.$unit_cost;  ?></td>
										
										<td style="text-align:center;padding: 10px;"><?php echo '$' . number_format($tax,2, '.', '');  ?></td>
										<td style="text-align:center;padding: 10px;"><?php echo '$' . number_format($grand_tot,2, '.', ''); ?></td>

										
									  </tr>
									  
									 
									 
									<?php
									$k++;
									   } $j++;
									 
									  ?>
									  
							 
									  
									   <?php
										   $total_tax = ($tax_rate * ($subtotal_price[0]['sub_total'] / 100));
										   $net_amount = ($subtotal_price[0]['sub_total'] +  $total_tax);
									   ?>
									      <?php
									        $sum = getTotalInvoice($company_id);
											foreach($sum as $grant_product)
											{
											 $TotalInvoice_price = $grant_product['grant_total'];
											 $Total_tax_value = TaxValue();
											 $Total_tax_rate = $Total_tax_value;
											 $TotalInvoice_total_tax = ($Total_tax_rate * ($TotalInvoice_price / 100));
											 $TotalInvoice_net_amount = ($TotalInvoice_price +  $TotalInvoice_total_tax);
											 // echo "<pre>";
											 // print_r($TotalInvoice_total_tax);
											 // echo "</pre>";
											}
											?>
									   
								
									  <tr>
										  <td colspan="4"></td>
										  <td style="padding-left:20px;"><b>Subtotal</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
										  <td style="padding-left: 20px;"><b><?php echo '$' . number_format($subtotal_price[0]['sub_total'],2, '.', '');  ?><b></td>
										  <td style="padding-left: 15px;"><b><?php echo '$' . number_format($total_tax,2, '.', '');  ?></b></td>
										  <td style="padding-left: 20px;"><b><?php echo '$' . number_format($net_amount,2, '.', '');  ?></b></td>
									  
									  </tr>
									     <?php
									  // } 
									  // ?>
									   <?php
									  } 
									  ?>
									  
									     <tr style="padding:10px;">
										  <td colspan="4"></td>
										  <td style="padding-left:20px;"><b>Total Invoice</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
										  <td style="padding-left: 20px;"><b><?php echo '$' . number_format($TotalInvoice_price,2, '.', '');  ?><b></td>
										  <td style="padding-left: 15px;"><b><?php echo '$' . number_format($TotalInvoice_total_tax,2, '.', '');  ?></b></td>
										  <td style="padding-left: 20px;"><b><?php echo '$' . number_format($TotalInvoice_net_amount,2, '.', '');  ?></b></td>
									  
									   </tr>
									  
									</table>
							
							 
							 
								   
				
								</td>
					</tr> 
							<?php 
							$i++;
							}
							?>
							
						</td>
						
				   </tr>
				
				</td>
		 </tr>
                                        </td>
                        </tr>
                        <tr align="right">
                            <td><?php echo Paginations($limit, $page, 'open_orders.php?page=', $rows); ?></td>
                        </tr>
                    </table></td>
            </tr>
        </table></td>
</tr>  
<tr>
    <td style="background:#464646; text-align:center; color:#fff; line-height:30px;" height="30p">© <?php echo date('Y'); ?> sohorepro.com</td>
</tr>
</table>



<div id="update_email_order" style="width: 450px; left: 40%; top: 25%;">    	
    <div class="close"></div>
    <span class="ecs_tooltip">Press Esc to close <span class="arrow"></span></span>
    <div id="popup_content_em_upt" >            
        <div style="padding: 10px;text-align: center;font-size: 22px;">Email Updated Order</div>
        <div id="update_mail_dynamic">

        </div>            
    </div>
</div>
<div class="login_loader"></div>
<div id="backgroundPopup"></div>



</body>
</html>
<script type="text/javascript">
   
   // function edit_commt(CUS_ID,ORD_ID)
   // {
       // $(".cus_commt_span_"+CUS_ID+'_'+ORD_ID).hide(); 
       // $(".cus_commt_txt_"+CUS_ID+'_'+ORD_ID).show();  
       // $(".cus_commt_upt_"+CUS_ID+'_'+ORD_ID).show();    
   // }   
   
   // function update_commt(CUS_ID,ORD_ID)
   // {
        // var cus_commt = $("#cus_commt_txt_"+CUS_ID+'_'+ORD_ID).val();  
        // if(cus_commt != '')  
           // {
            // $.ajax
            // ({
               // type: "POST",
                   // url: "get_child.php",
                   // data: "cus_commt="+cus_commt+"&cus_commt_id="+CUS_ID,
                   // beforeSend: loadStart,
                   // complete: loadStop,
                   // success: function(option)
                   // {
                       // if(option == '1'){
                       // $(".cus_commt_span_"+CUS_ID+'_'+ORD_ID).html(cus_commt); 
                       // $(".cus_commt_span_"+CUS_ID+'_'+ORD_ID).show(); 
                       // $(".cus_commt_txt_"+CUS_ID+'_'+ORD_ID).hide();  
                       // $(".cus_commt_upt_"+CUS_ID+'_'+ORD_ID).hide();   
                       // }
                   // }
            // });
           // }
   // }

    function logingAlertPop()
    {
        closeloading(); // fadeout loading
        $("#update_email_order").fadeIn(0500); // fadein popup div
        $("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
        $("#backgroundPopup").fadeIn(0001);
    }

    function loading() {
        $("div.login_loader").show();
    }

    function closeloading() {
        $("div.login_loader").fadeOut('normal');
    }

    function disablePopup()
    {
        $("#update_email_order").fadeOut("normal");
        $("#backgroundPopup").fadeOut("normal");
    }

    $(document).ready(function()
    {
        $('.trigger').click(function()
        {
            var val = $(this).attr('id');
            if ($(this).is(':visible'))
            {
                $(this).next(".test_" + val).fadeToggle('slow').siblings(".test_" + val).hide();
            }
        });

   // $('.inline').click(function()
   // {
       // var ID      =$(this).attr('id'); 
       // $(".product_"+ID).hide(); 
       // $(".quantity_"+ID).hide(); 
       // $(".price_"+ID).hide(); 
       // $(".delete_"+ID).hide();        
       // $(".product_txt_"+ID).show(); 
       // $(".quantity_txt_"+ID).show(); 
       // $(".price_txt_"+ID).show(); 
       // $(".update_"+ID).show();         
       // $(".jass").attr("id",ID);        
   // });
   


   // $(document).mouseup(function()
   // {
       // var ID = $('.jass').attr('id');
       // $(".product_"+ID).show(); 
       // $(".quantity_"+ID).show(); 
       // $(".price_"+ID).show(); 
       // $(".delete_"+ID).show();  
       // $(".product_txt_"+ID).hide(); 
       // $(".quantity_txt_"+ID).hide(); 
       // $(".price_txt_"+ID).hide(); 
       // $(".update_"+ID).hide(); 
   // });

        $('.reference').click(function()
        {
            var OR_ID = $(this).attr('id');
            $(".ref_" + OR_ID).hide();
            $(".reference_txt_" + OR_ID).show();
            $(".ref_update_" + OR_ID).show();
            $(".ref_cancel_" + OR_ID).show();
            $(".jass2").attr("id", OR_ID);
        });

        $('.refcancel').click(function()
        {
            var OR_ID = $('.jass2').attr('id');
            $(".ref_" + OR_ID).show();
            $(".reference_txt_" + OR_ID).hide();
            $(".ref_update_" + OR_ID).hide();
            $(".ref_cancel_" + OR_ID).hide();
        });

        $(function() {
            var ID = $('.jass').attr('id');
            $("#quantity_txt_" + ID).keydown(function(event) {

                if (event.shiftKey == true) {
                    event.preventDefault();
                }

                if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

                } else {
                    event.preventDefault();
                }

                if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                    event.preventDefault();

            });
        });

        $(function() {
            var ID = $('.jass').attr('id');
            $("#price_txt_" + ID).keydown(function(event) {

                if (event.shiftKey == true) {
                    event.preventDefault();
                }

                if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

                } else {
                    event.preventDefault();
                }

                if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                    event.preventDefault();

            });
        });


    });

    function send_mail_update_order(order_id, ship_id)
    {
        var mail_confirm = confirm('Are you sure ?');

        if (mail_confirm == true) {
            if (order_id != '')
            {
                       // loading(); // loading
                         setTimeout(function(){ // then show popup, deley in .5 second
                            logingAlertPop(); // function show popup 
                            }, 500); // .5 second
                $.ajax
                        ({
                            type: "POST",
                            url: "update_mail_content.php",
                            data: "order_id=" + order_id,
                            beforeSend: loadStart,
                            complete: loadStop,
                            success: function(option)
                            {
                                    // var subject_to = option;
                                    // var subject_to_body = option.split("~");
                                    // var body_content            = encodeURIComponent(subject_to_body[1]);
                                    // $("#mail_to_"+order_id).show();
                                    // $(".mail_to_"+order_id).attr("href", subject_to_body[0]+'?body='+subject_to_body[1]);
                                // document.location.href = option;
                                $("#update_mail_dynamic").html(option);
                            }
                        });


                   // $.ajax
                   // ({
                      // type: "POST",
                          // url: "get_child.php",
                          // data: "update_email_ord_id="+order_id+"&update_email_ship_id="+ship_id,
                          // beforeSend: loadStart,
                          // complete: loadStop,
                          // success: function(option)
                          // {
                              // if(option != ''){
                              // $(".confirm_mail_"+order_id).show();               
                              // $(".confirm_mail_"+order_id).fadeOut(2500);               
                              // }
                          // }
                   // });
            }
        }
        else
        {
            return false;
        }

    }


    function view_order_set(ORDER_ID)
    {
        // alert(ORDER_ID);
        if (ORDER_ID != '')
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "update_mail_content.php",
                        data: "order_id=" + order_id,
                        beforeSend: loadStart,
                        complete: loadStop,
                        success: function(option)
                        {
                            document.location.href = option;
                        }
                    });
        }
    }

    function send_upt_mail(order_id)
    {
        var short_msg = document.getElementById('upt_mail_msg').value;
        $.ajax
                ({
                    type: "POST",
                    url: "get_child.php",
                    data: "update_email_ord_id=" + order_id + "&short_msg=" + encodeURIComponent(short_msg),
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {
                        if (option != '') {
                            disablePopup()
                            $(".confirm_mail_" + order_id).show();
                            $(".confirm_mail_" + order_id).fadeOut(2500);
                        }
                    }
                });
    }

    $(document).ready(function()
    {
        $("div.close").hover(
                function() {
                    $('span.ecs_tooltip').show();
                },
                function() {
                    $('span.ecs_tooltip').hide();
                }
        );

        $("div.close").click(function() {
            disablePopup();  // function close pop up
        });

        $(this).keyup(function(event) {
            if (event.which == 27) { // 27 is 'Ecs' in the keyboard
                disablePopup();  // function close pop up
            }
        });

        $("div#backgroundPopup").click(function() {
            disablePopup();  // function close pop up
        });

    });

</script>

<script type="text/javascript">

    function inline_prod_edit(id_val)
    {
        var ID = id_val.split("_");
        $(".product_" + ID[0] + '_' + ID[1]).hide();
        $(".quantity_" + ID[0] + '_' + ID[1]).hide();
        $(".price_" + ID[0] + '_' + ID[1]).hide();
        $(".delete_" + ID[0] + '_' + ID[1]).hide();
        $(".product_txt_" + ID[0] + '_' + ID[1]).show();
        $(".quantity_txt_" + ID[0] + '_' + ID[1]).show();
        $(".price_txt_" + ID[0] + '_' + ID[1]).show();
        $(".update_" + ID[0] + '_' + ID[1]).show();
        $(".jass").attr("id", ID[0]);
    }

    function update_dedails(ID, ord_id)
    {
        // alert(ID+' '+ord_id);
        var order_id = $('.order_id_t_' + ID).attr('id');
        var IID = document.getElementById('h_' + ID + '_' + ord_id).value;
        var product = document.getElementById('product_txt_' + ID + '_' + ord_id).value;
        var qty = document.getElementById('quantity_txt_' + ID + '_' + ord_id).value;
        var price = document.getElementById('price_txt_' + ID + '_' + ord_id).value;

        if (price != '' && qty != '')
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "get_child.php",
                        data: "product=" + product + "&qty=" + qty + "&price=" + price + "&id=" + ID + "&iid=" + IID + "&order_id=" + order_id,
                        success: function(option)
                        {
                            var myarr = option.split("~");

                            var line = (myarr[1] * myarr[2]);
                            $(".product_" + ID + '_' + ord_id).html(myarr[0]);
                            $(".quantity_" + ID + '_' + ord_id).html(myarr[1]);
                            $(".price_" + ID + '_' + ord_id).html("$" + myarr[2]);
                            $(".tax_" + ord_id).html("$" + myarr[5]);
                            $(".line_cost_" + ID + '_' + ord_id).html(myarr[7]);
                            $(".line_" + ord_id).html("$" + myarr[6]);
                            $(".lineJassim_" + ord_id).html("$" + myarr[4]);
                            $(".jassim_" + order_id).html("$" + myarr[4]);
                            $(".product_" + ID + '_' + ord_id).show();
                            $(".quantity_" + ID + '_' + ord_id).show();
                            $(".price_" + ID + '_' + ord_id).show();
                            $(".delete_" + ID + '_' + ord_id).show();
                            $(".product_txt_" + ID + '_' + ord_id).hide();
                            $(".quantity_txt_" + ID + '_' + ord_id).hide();
                            $(".price_txt_" + ID + '_' + ord_id).hide();
                            $(".update_" + ID + '_' + ord_id).hide();
                        }
                    });
        }
        else
        {
            $(".error").html("Please fill the all fields");
        }
        return false;
    }

    $(document).ready(function()
    {
 // $('.updater').click(function()
   // {
      
       // var ID                   = $('.jass').attr('id');          
       // var order_id             = $('.order_id_t_'+ID).attr('id');
       // var IID                  = document.getElementById('h_'+ID).value;        
       // var product              = document.getElementById('product_txt_'+ID).value;
       // var qty                  = document.getElementById('quantity_txt_'+ID).value;
       // var price                = document.getElementById('price_txt_'+ID).value;
       
           // if(price != '' && qty != '')  
    // {
     // $.ajax
     // ({
        // type: "POST",
            // url: "get_child.php",
            // data: "product="+product+"&qty="+qty+"&price="+price+"&id="+ID+"&iid="+IID+"&order_id="+order_id,
            // success: function(option)
            // {
                // var myarr = option.split("~");

                // var line = (myarr[1] * myarr[2]);
                // $(".product_"+ID).html(myarr[0]); 
                // $(".quantity_"+ID).html(myarr[1]); 
                // $(".price_"+ID).html("$"+myarr[2]); 
                // $(".tax_"+ID).html("$"+myarr[5]); 
                // $(".line_cost_"+ID).html(myarr[7]); 
                // $(".line_"+ID).html("$"+myarr[6]);
                // $(".lineJassim_"+ID).html("$"+myarr[4]); 
                // $(".jassim_"+order_id).html("$"+myarr[4]); 
            // }
     // });
    // }
	 // else
	 // {
	   // $(".error").html("Please fill the all fields"); 
	 // }
	// return false;
       
   // });
        

        $('.refupdate').click(function()
        {
            var ID = $('.jass2').attr('id');
            var reference = document.getElementById('reference_txt_' + ID).value;

            if (reference != '')
            {
                $.ajax
                        ({
                            type: "POST",
                            url: "get_child.php",
                            data: "reference=" + reference + "&id=" + ID,
                            success: function(option)
                            {
                                $(".ref_" + ID).html(option);
                                $(".refj_" + ID).html(option);
                                $(".ref_" + ID).show();
                                $(".reference_txt_" + ID).hide();
                                $(".ref_update_" + ID).hide();
                                $(".ref_cancel_" + ID).hide();
                            }
                        });
            }
            else
            {
                $(".error").html("Please fill the all fields");
            }
            return false;

        });


    });

    

    function autosuggession()
    {
        var searc_name = $("#customer_auto").val();
        var dataString = 'search=' + encodeURIComponent(searc_name);
        if (searc_name != '')
        {
            $.ajax({
                type: "POST",
                url: "auto_customer_fill.php",
                data: dataString,
                cache: false,
                success: function(html)
                {
                    if (html != '') {
                        $("#result_ref").html(html).show();
                    } else {
                        $("#result_ref").hide();
                    }
                }
            });
        } else {
            $("#result_ref").hide();
        }
    }

    function get_customer_name(CUS_NAME)
    {
        $("#customer_auto").val(CUS_NAME);
        var search_val = $("#customer_auto").val();

        if (search_val != '') {
            $("#result_ref").hide();            
        }

    }
    
    function assign_customer()
    {
        var searc_name = $("#customer_auto").val();
        var current_cus_id = $("#current_cus_id").val();
        if(searc_name != ''){
        $.ajax
               ({
                   type: "POST",
                   url: "get_child.php",
                   data: "change_cus_order=1&customer_name="+encodeURIComponent(searc_name)+"&current_cus_id="+current_cus_id,
                   beforeSend: loadStart,
                   complete: loadStop,
                   success: function(option)
                   {
                       if (option != '') {
                           $(".modal-overlay").fadeOut();
                           $("#asap_popup").slideUp("slow");
                           $("#customer_name_"+current_cus_id).html(searc_name);
                       }
                   }
               }); 
        }else{
           $("#customer_auto").focus();
           return false;
        }
    }
    
    function loadStart() {
        $('#loading').show();
    }

    function loadStop() {
        $('#loading').hide();
    }
    
    function open_invoice_type(ORD_ID)
    {
        $('#invoice_section_'+ORD_ID).slideDown();
        $('#invoice_section_'+ORD_ID).addClass("inv_section");
    }   
    
    function gererate_invoice(ORD_ID,COMP_ID)
    {
        $("body").append("<div class='modal-overlay js-modal-close'></div>");
        $("#invoice_template").slideDown('slow');             
        var frequency_value = $('#invoice_freq_'+ORD_ID).val();
        var scrol_pos = $("body").scrollTop();
        var extra_pos = Number(scrol_pos) + Number(10);
        $("#invoice_template").css('top', extra_pos+'px');
        
        if(ORD_ID != ''){
        $.ajax
               ({
                   type: "POST",
                   url: "generate_invoice.php",
                   data: "invoice_type="+frequency_value+"&invoice_order_id="+ORD_ID+"&invoice_comp_id="+COMP_ID,
                   beforeSend: loadStart,
                   complete: loadStop,
                   success: function(option)
                   {
                       $("#invoice_template_content").html(option);
                   }
               }); 
        }
    }
     
     
    function close_invoice_template()
            {                
                $(".modal-overlay").fadeOut();
                $("#invoice_template").slideUp("slow");
                $(".invoice_freq_type").val('0');
            }
            
    function close_order_now(ORD_ID){
        var ays         =  confirm('Are you sure?');
        if(ays == true){
        if(ORD_ID != ''){
        $.ajax
               ({
                   type: "POST",
                   url: "get_child.php",
                   data: "order_closed_now_id="+ORD_ID,
                   beforeSend: loadStart,
                   complete: loadStop,
                   success: function(option)
                   {    
                       // alert(option);
                       if(option == true){
                        $("#close_status_"+ORD_ID).html("Ready to Invoice");
                        $("#close_status_"+ORD_ID).css("background", "#DA4530");                      
                        }else{
                        $("#close_status_"+ORD_ID).html("Close Order");
                        $("#close_status_"+ORD_ID).css("background", "#F99B3E");     
                        }
                   }
               }); 
        }
        }else{
            return false;
        }
    }
	
	function Download_Pdf(id)
	{
		$.ajax({
	
			   type: "POST",
			   url: "get_pdf.php",
			   data: "company_id="+id,
	           beforeSend: loadStart,
               complete: loadStop,
			   success: function(option)
                   {    
                       
					   option = parseInt(option);
					   // alert(option);
                       if(option == 1){
                         alert("Success");                    
                        }else{
                        alert("Failed");    
                        }
                   }
	
	});
	}
	
	
</script>