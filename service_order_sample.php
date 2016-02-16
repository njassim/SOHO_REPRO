<?php
include './admin/config.php';
include './admin/db_connection.php';
//error_reporting(0);

$job_reference_final = ShowOrderedSets($_SESSION['ordere_sequence']);


$mail_id = getActiveEmailOrder();
$entered_needed_sets_final = SetsOrderedFinalize($job_reference_final[0]['id']);
$total_sets = SetsOrderedFinalizeCountOfSets($job_reference_final[0]['id']);
$user_name = UserName($_SESSION['sohorepro_userid']);
$customer_name = getCompName($_SESSION['sohorepro_companyid']);
$user_mail_id_txt = UserMail($_SESSION['sohorepro_userid']);

$phone = CompanyPhoneNumber($user_mail_id_txt);
$Date = date('m-d-Y h:i A', time());
$files_upload_services = UploafFilesServices($job_reference_final[0]['id']);

$service_billing_address = getCustomeInfo($_SESSION['sohorepro_companyid']);
$service_address_1 = ($service_billing_address[0]['comp_business_address1'] != '') ? $service_billing_address[0]['comp_business_address1'] . '<br>' : '';
$service_address_2 = ($service_billing_address[0]['comp_business_address2'] != '') ? $service_billing_address[0]['comp_business_address2'] . '<br>' : '';
$service_address_3 = ($service_billing_address[0]['comp_business_address3'] != '') ? $service_billing_address[0]['comp_business_address3'] . '<br>' : '';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Soho Email</title>
        <style type="text/css">
            div, p, a, li, td { -webkit-text-size-adjust:none; margin:0px; }
        </style>
    </head>

    <body>
<table width="650" border="0" cellspacing="0" cellpadding="0" bgcolor="#ff7e00" align="center">
    <tr>
        <td width="1" bgcolor="#ff7e00"></td>
        <td><table width="648" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="1"></td>
                </tr>
                <tr>
                    <td><table width="648" border="0" cellspacing="0" cellpadding="0" bgcolor="#fff">
                            <tr>
                                <td width="10"></td>
                                <td>
                                    <table width="628" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td height="10"></td>
                                        </tr>
                                        <tr>
                                            <td><table width="628" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>
                                                            <table width="628" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#404040; text-align:left; line-height:26px;">
                                                                <tr>
                                                                    <td>
                                                                        <table border="0" cellspacing="0" cellpadding="0" style="font-size:16px;">
                                                                            <tr>
                                                                                <td>Order Completed </td>
                                                                                <td style="padding:0px 10px">:</td>
                                                                                <td>ORDER # 900100241</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td><strong>Customer Reference</strong></td>
                                                                                <td style="padding:0px 10px">:</td>
                                                                                <td>Test</td>
                                                                            </tr>
                                                                        </table>                                                                            
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><table border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td><strong>Date</strong></td>
                                                                                <td style="padding:0px 10px">:</td>
                                                                                <td>10-07-2015 02:08 AM</td>
                                                                            </tr>
                                                                        </table></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td><strong>Name</strong></td>
                                                                                <td style="padding:0px 10px">:</td>
                                                                                <td>Riyas</td>
                                                                            </tr>
                                                                        </table>                                                                            
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td><strong>Company</strong></td>
                                                                                <td style="padding:0px 10px">:</td>
                                                                                <td>138-142 Reade Street</td>
                                                                            </tr>
                                                                        </table>                                                                            
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td><strong>Email</strong></td>
                                                                                <td style="padding:0px 10px">:</td>
                                                                                <td>riyas@gmail.com</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td><strong>Phone</strong></td>
                                                                                <td style="padding:0px 10px">:</td>
                                                                                <td>452-369-8712</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td><strong>Billing Address</strong></td>
                                                                                <td style="padding:0px 10px">:</td> 
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top">
                                                                        <p>138-142 Reade Street</p> 
                                                                        <p>c/o Knucklnee LLC</p>
                                                                        <p>305 Broadway -- 7th Floor</p>
                                                                        <p>New York, NY 10013</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>






                                                    <tr>
                                                        <td height="15"></td>
                                                    </tr>


                                                    <tr>
                                                        <td><table width="628" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#404040; text-align:left; line-height:26px;">
                                                                <tr>
                                                                    <td style="text-transform:uppercase; font-size:16px;"><strong>Original Order</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><table width="628" border="0" cellspacing="0" cellpadding="0" bgcolor="#ff7e00">
                                                                            <tr>
                                                                                <td width="1" bgcolor="#ff7e00"></td>
                                                                                <td><table width="626" border="0" cellspacing="0" cellpadding="0" bgcolor="#fff">
                                                                                        <tr>
                                                                                            <td height="1" bgcolor="#ff7e00"></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><table width="626" border="0" cellspacing="0" cellpadding="0">
                                                                                                    <tr>
                                                                                                        <td width="10"></td>
                                                                                                        <td><table width="606" border="0" cellspacing="0" cellpadding="0">
                                                                                                                <tr>
                                                                                                                    <td height="10"></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td><table width="606" border="0" cellspacing="0" cellpadding="0">
                                                                                                                            <tr>
                                                                                                                                <td><table border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td><strong>Customer Details</strong></td>
                                                                                                                                            <td style="padding:0px 10px">:</td> 
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td valign="top">
                                                                                                                                    <p>138-142 Reade Street</p> 
                                                                                                                                    <p>c/o Knucklnee LLC</p>
                                                                                                                                    <p>305 Broadway -- 7th Floor</p>
                                                                                                                                    <p>New York, NY 10013</p>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td><table border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td><strong>User Details</strong></td>
                                                                                                                                            <td style="padding:0px 10px">:</td> 
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td valign="top">
                                                                                                                                    <p>Riyas</p> 
                                                                                                                                    <p>riyas@gmail.com</p>
                                                                                                                                    <p>452-369-8712</p>
                                                                                                                                    <p>Date :10-07-2015 02:08 AM</p>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td><table border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td><strong>PACKING LIST</strong></td>
                                                                                                                                            <td style="padding:0px 10px">:</td> 
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                                                                            </tr>

                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td><table width="606" border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Option</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Originals	</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Sets	</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Order</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Type</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Size</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Media</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Binding</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Folding</td>
                                                                                                                                        </tr>
                                                                                                                                        <tr>
                                                                                                                                            <td bgcolor="#ffeee1">1</td>
                                                                                                                                            <td bgcolor="#ffeee1">1</td>
                                                                                                                                            <td bgcolor="#ffeee1">1</td>
                                                                                                                                            <td bgcolor="#ffeee1">Plotting</td>
                                                                                                                                            <td bgcolor="#ffeee1">None</td>
                                                                                                                                            <td bgcolor="#ffeee1">None</td>
                                                                                                                                            <td bgcolor="#ffeee1">None</td>
                                                                                                                                            <td bgcolor="#ffeee1">None</td>
                                                                                                                                            <td bgcolor="#ffeee1">None</td>
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td><table border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td><strong>Special Instructions:</strong></td>
                                                                                                                                            <td style="padding:0px 10px">:</td> 
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td valign="top">  <p>Test 1</p> </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>

                                                                                                            </table>
                                                                                                        </td>
                                                                                                        <td width="10"></td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="1" bgcolor="#ff7e00"></td>
                                                                                        </tr>
                                                                                    </table>

                                                                                </td>
                                                                                <td width="1" bgcolor="#ff7e00"></td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>



                                                    <tr>
                                                        <td height="15"></td>
                                                    </tr>

                                                    <tr>
                                                        <td><table width="628" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#404040; text-align:left; line-height:26px;">
                                                                <tr>
                                                                    <td style="text-transform:uppercase; font-size:16px;"><strong>Recipient 1</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><table width="628" border="0" cellspacing="0" cellpadding="0" bgcolor="#ff7e00">
                                                                            <tr>
                                                                                <td width="1" bgcolor="#ff7e00"></td>
                                                                                <td><table width="626" border="0" cellspacing="0" cellpadding="0" bgcolor="#fff">
                                                                                        <tr>
                                                                                            <td height="1" bgcolor="#ff7e00"></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><table width="626" border="0" cellspacing="0" cellpadding="0">
                                                                                                    <tr>
                                                                                                        <td width="10"></td>
                                                                                                        <td><table width="606" border="0" cellspacing="0" cellpadding="0">
                                                                                                                <tr>
                                                                                                                    <td height="10"></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td><table width="606" border="0" cellspacing="0" cellpadding="0">
                                                                                                                            <tr>
                                                                                                                                <td><table border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td><strong>Send to</strong></td>
                                                                                                                                            <td style="padding:0px 10px">:</td> 
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td valign="top">
                                                                                                                                    <p>Colan Test Co</p> 
                                                                                                                                    <p>Attention: Jassim Khan</p>
                                                                                                                                    <p>Conatct: </p>
                                                                                                                                    <p>No 52st Street,</p>
                                                                                                                                    <p>Cross Lane,</p>
                                                                                                                                    <p>Chennai, AL 55454</p>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td><table border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td><strong>PACKING LIST:</strong></td>
                                                                                                                                            <td style="padding:0px 10px">:</td> 
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                                                                            </tr>

                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>

                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td><table width="606" border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Option</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Originals	</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Sets	</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Order</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Type</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Size</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Media</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Binding</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Folding</td>
                                                                                                                                        </tr>
                                                                                                                                        <tr>
                                                                                                                                            <td bgcolor="#ffeee1">1</td>
                                                                                                                                            <td bgcolor="#ffeee1">1</td>
                                                                                                                                            <td bgcolor="#ffeee1">1</td>
                                                                                                                                            <td bgcolor="#ffeee1">Plotting</td>
                                                                                                                                            <td bgcolor="#ffeee1">None</td>
                                                                                                                                            <td bgcolor="#ffeee1">None</td>
                                                                                                                                            <td bgcolor="#ffeee1">None</td>
                                                                                                                                            <td bgcolor="#ffeee1">None</td>
                                                                                                                                            <td bgcolor="#ffeee1">None</td>
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>

                                                                                                                            <tr>
                                                                                                                                <td><table border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td><strong>When Needed</strong></td>
                                                                                                                                            <td style="padding:0px 10px">:</td> 
                                                                                                                                            <td>ASAP</td> 
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td><table border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td><strong>Send Via</strong></td>
                                                                                                                                            <td style="padding:0px 10px">:</td> 
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                                                                            </tr>

                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td valign="top">  <p>S OHO TO ARRANGE DELIVERY</p> </td>
                                                                                                                            </tr>

                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>

                                                                                                            </table>
                                                                                                        </td>
                                                                                                        <td width="10"></td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="1" bgcolor="#ff7e00"></td>
                                                                                        </tr>
                                                                                    </table>

                                                                                </td>
                                                                                <td width="1" bgcolor="#ff7e00"></td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table></td>
                                                    </tr>

                                                    <tr>
                                                        <td height="15"></td>
                                                    </tr>

                                                    <tr>
                                                        <td><table width="628" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#404040; text-align:left; line-height:26px;">
                                                                <tr>
                                                                    <td style="text-transform:uppercase; font-size:16px;"><strong>Recipient 2</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><table width="628" border="0" cellspacing="0" cellpadding="0" bgcolor="#ff7e00">
                                                                            <tr>
                                                                                <td width="1" bgcolor="#ff7e00"></td>
                                                                                <td><table width="626" border="0" cellspacing="0" cellpadding="0" bgcolor="#fff">
                                                                                        <tr>
                                                                                            <td height="1" bgcolor="#ff7e00"></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><table width="626" border="0" cellspacing="0" cellpadding="0">
                                                                                                    <tr>
                                                                                                        <td width="10"></td>
                                                                                                        <td><table width="606" border="0" cellspacing="0" cellpadding="0">
                                                                                                                <tr>
                                                                                                                    <td height="10"></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td><table width="606" border="0" cellspacing="0" cellpadding="0">
                                                                                                                            <tr>
                                                                                                                                <td><table border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td><strong>Send to </strong></td>
                                                                                                                                            <td style="padding:0px 10px">:</td> 
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td valign="top">
                                                                                                                                    <p>Test Wednesday</p> 
                                                                                                                                    <p>Attention: Wednesday</p>
                                                                                                                                    <p>Conatct:</p>
                                                                                                                                    <p>6-90 Mosque Street </p>
                                                                                                                                    <p>Thirumayam,</p>
                                                                                                                                    <p>6-90 Mosque Street </p>
                                                                                                                                    <p>Thirumayam,</p>
                                                                                                                                    <p>Pudukkottai- Dist, CT 62250</p>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td><table border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td><strong>PACKING LIST:</strong></td>
                                                                                                                                            <td style="padding:0px 10px">:</td> 
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                                                                            </tr>

                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>

                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td><table width="606" border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Option</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Originals	</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Sets	</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Order</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Type</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Size</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Media</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Binding</td>
                                                                                                                                            <td bgcolor="#f99b3e" style="font-weight:bold;">Folding</td>
                                                                                                                                        </tr>
                                                                                                                                        <tr>
                                                                                                                                            <td bgcolor="#ffeee1">1</td>
                                                                                                                                            <td bgcolor="#ffeee1">1</td>
                                                                                                                                            <td bgcolor="#ffeee1">1</td>
                                                                                                                                            <td bgcolor="#ffeee1">Plotting</td>
                                                                                                                                            <td bgcolor="#ffeee1">None</td>
                                                                                                                                            <td bgcolor="#ffeee1">None</td>
                                                                                                                                            <td bgcolor="#ffeee1">None</td>
                                                                                                                                            <td bgcolor="#ffeee1">None</td>
                                                                                                                                            <td bgcolor="#ffeee1">None</td>
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>

                                                                                                                            <tr>
                                                                                                                                <td><table border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td><strong>When Needed</strong></td>
                                                                                                                                            <td style="padding:0px 10px">:</td> 
                                                                                                                                            <td>ASAP</td> 
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td><table border="0" cellspacing="0" cellpadding="0">
                                                                                                                                        <tr>
                                                                                                                                            <td><strong>Send Via</strong></td>
                                                                                                                                            <td style="padding:0px 10px">:</td> 
                                                                                                                                        </tr>
                                                                                                                                    </table></td>
                                                                                                                            </tr>

                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td valign="top">  <p>S OHO TO ARRANGE DELIVERY</p> </td>
                                                                                                                            </tr>

                                                                                                                            <tr>
                                                                                                                                <td height="5"></td>
                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>

                                                                                                            </table>
                                                                                                        </td>
                                                                                                        <td width="10"></td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="1" bgcolor="#ff7e00"></td>
                                                                                        </tr>
                                                                                    </table>

                                                                                </td>
                                                                                <td width="1" bgcolor="#ff7e00"></td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table></td>
                                                    </tr>

                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="10"></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="10"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="1"></td>
                </tr>
            </table>
        </td>
        <td width="1" bgcolor="#ff7e00"></td>
    </tr>
</table>
</body>
</html>
