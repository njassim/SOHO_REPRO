<?php
include './config.php';
include './auth.php';
if ($_REQUEST['customer_import'] == '1') {

    if ($_FILES['excelFile']['name'] != "") {
        $fileName = uploadFile($_FILES['excelFile'], array(".xls", ".xlsx"), "excel_file");
        $data = new Spreadsheet_Excel_Reader();
        //$data->read('excel_file/test/customer5.xls');
        //$data->read('excel_file/test/Copier Supplies.xls');
        //$data->read('excel_file/test/Sketch Paper.xls');
        //$data->read('excel_file/test/Packaging.xls');
        //$data->read('excel_file/test/Binding Supplies.xls');
        //$data->read('excel_file/test/Display Boards.xls');
        //$data->read('excel_file/test/Ink&Toner.xls');
        $data->read('customer/customer_6.xls');

        //Company Details Insert --- Start-----
        for ($j = 1; $j <= $data->sheets[0]['numRows']; $j++) {
            $company_name = str_replace('"', '', $data->sheets[0]['cells'][$j][1]);
            $contact_name = str_replace('"', '', $data->sheets[0]['cells'][$j][3]);
            $company_phone_raw = str_replace('"', '', $data->sheets[0]['cells'][$j][10]);
            $contact_phone_1 = substr($company_phone_raw, 0, 3);
            $contact_phone_2 = substr($company_phone_raw, 3, 3);
            $contact_phone_3 = substr($company_phone_raw, 6, 9);
            $company_phone = $contact_phone_1 . '-' . $contact_phone_2 . '-' . $contact_phone_3;
            $companyfax_raw = str_replace('"', '', $data->sheets[0]['cells'][$j][14]);
            $companyfax_1 = substr($companyfax_raw, 0, 3);
            $companyfax_2 = substr($companyfax_raw, 3, 3);
            $companyfax_3 = substr($companyfax_raw, 6, 9);
            $companyfax = $companyfax_1 . '-' . $companyfax_2 . '-' . $companyfax_3;
            $bussines_add1 = str_replace('"', '', $data->sheets[0]['cells'][$j][5]);
            $bussines_add2 = str_replace('"', '', $data->sheets[0]['cells'][$j][6]);
            //$bussines_add3 = str_replace('"', '', $data->sheets[0]['cells'][$j][5]);
            $business_city = str_replace('"', '', $data->sheets[0]['cells'][$j][7]);
            $business_state = str_replace('"', '', $data->sheets[0]['cells'][$j][8]);
            $business_zip = str_replace('"', '', $data->sheets[0]['cells'][$j][9]);
            $check_company_name = checkcomp_rep($company_name);
            $account_status = str_replace('"', '', $data->sheets[0]['cells'][$j][20]);
            $status = ($account_status == 'Y') ? '1' : '0';
            $account_mail = str_replace('"', '', $data->sheets[0]['cells'][$j][29]);
            if (count($check_company_name) < 1) {
                $query = "INSERT INTO sohorepro_company SET
                                comp_name                     = '" . $company_name . "',
                                comp_contact_name             = '" . $contact_name . "',
                                comp_contact_email            = '" . $account_mail . "',
                                comp_contact_phone            = '" . $company_phone . "',
                                comp_contact_fax              = '" . $companyfax . "',
                                comp_business_address1        = '" . $bussines_add1 . "',
                                comp_business_address2        = '" . $bussines_add2 . "',
                                comp_business_address3        = '" . $bussines_add3 . "',
                                comp_city                     = '" . $business_city . "',
                                comp_state                    = '" . $business_state . "',
                                comp_zipcode                  = '" . $business_zip . "',
                                status                        = '" . $status . "'    ";
                mysql_query($query);
            }
        }
        //Company Details Insert ------End-----
        //Address Book Data Insert ---Start---
        for ($k = 1; $k <= $data->sheets[0]['numRows']; $k++) {
            $customer_company_name = str_replace('"', '', $data->sheets[0]['cells'][$k][1]);
            $company_name = str_replace('"', '', $data->sheets[0]['cells'][$k][1]);
            $contact_name = str_replace('"', '', $data->sheets[0]['cells'][$k][3]);
            $comp_name = compName($customer_company_name);
            $address1 = str_replace('"', '', $data->sheets[0]['cells'][$k][21]);
            $address2 = str_replace('"', '', $data->sheets[0]['cells'][$k][22]);
            $city = str_replace('"', '', $data->sheets[0]['cells'][$k][23]);
            $state_val = str_replace('"', '', $data->sheets[0]['cells'][$k][24]);
            $state = State_Val($state_val);
            $zip = str_replace('"', '', $data->sheets[0]['cells'][$k][25]);
            $attention_to = str_replace('"', '', $data->sheets[0]['cells'][$k][3]);
            
            if (count($check_company_name) < 1) {
                $query = "INSERT INTO sohorepro_address SET               comp_id                     = '" . $comp_name . "',
                                                                          company_name                = '" . $company_name . "',
                                                                          contact_name                = '" . $contact_name . "',
                                                                          address_1                   = '" . $address1 . "',
                                                                          address_2                   = '" . $address2 . "',
                                                                          city                        = '" . $city . "',
                                                                          state                       = '" . $state . "',
                                                                          zip                         = '" . $zip . "',    
                                                                          attention_to                = '" . $attention_to . "',
                                                                          type                        = '1'    ";
                mysql_query($query);
                //$last_id = mysql_insert_id();
            }
        }
        //Address Book Data Insert ---End---
        //Customer Data Insert ---Start---
        for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
            $customer_fname = " ";
            $customer_lname = " ";
            $customer_contactname = mysql_real_escape_string($data->sheets[0]['cells'][$i][3]);
            $customer_email = $data->sheets[0]['cells'][$i][29];
            $check_customer_email = checkMail($customer_email);
            $customer_company_name = $data->sheets[0]['cells'][$i][2];
            $comp_name = compName($customer_company_name);
            $companyphone = $data->sheets[0]['cells'][$i][10];
            $companyfax = $data->sheets[0]['cells'][$i][14];
            $billing_add1 = $data->sheets[0]['cells'][$i][5];
            $billing_add2 = $data->sheets[0]['cells'][$i][6];
            $billing_city = $data->sheets[0]['cells'][$i][7];
            $billing_state = $data->sheets[0]['cells'][$i][8];
            $bill_state_val = State_Val($billing_state);
            $billing_zip = $data->sheets[0]['cells'][$i][9];
            $invoice_type = $data->sheets[0]['cells'][$i][18];
            $billing_frequency = $data->sheets[0]['cells'][$i][19];
            $account_status = $data->sheets[0]['cells'][$i][20];
            $status = ($account_status == 'Y') ? '1' : '0';
            $shipping_comp_name = " ";
            $shipping_add1 = $data->sheets[0]['cells'][$i][21];
            $shipping_city = $data->sheets[0]['cells'][$i][22];
            $shipping_state = $data->sheets[0]['cells'][$i][23];
            $shipping_state_val = State_Val($shipping_state);
            $shipping_zip = $data->sheets[0]['cells'][$i][24];
            $password = "123456";
            $mangaer = "1";
            //$password               =       randomPassword();

            if (count($check_customer_email) < 1) {
                $query = "INSERT INTO sohorepro_customers SET cus_fname          = '" . $customer_fname . "',
                                                                                 cus_lname          = '" . $customer_lname . "',
                                                                                 cus_contact_name   = '" . $customer_contactname . "',   
                                                                                 cus_email          = '" . $customer_email . "',
                                                                                 cus_pass           = '" . $password . "',
                                                                                 cus_compname       = '" . $comp_name . "',
                                                                                 cus_contact_email  = '" . $customer_email . "',
                                                                                 cus_contact_phone  = '" . $companyphone . "',
                                                                                 cus_contact_fax    = '" . $companyfax . "',
                                                                                 cus_bill_address1  = '" . $billing_add1 . "',
                                                                                 cus_bill_address2  = '" . $billing_add2 . "',
                                                                                 cus_bill_city      = '" . $billing_city . "',
                                                                                 cus_bill_state     = '" . $bill_state_val . "',
                                                                                 cus_bill_zipcode   = '" . $billing_zip . "',
                                                                                 invoice_type       = '" . $invoice_type . "',
                                                                                 billing_freq       = '" . $billing_frequency . "',
                                                                                 account_status     = '" . $status . "',
                                                                                 cus_status         = '" . $mangaer . "',
                                                                                 shipping_comp_name = '" . $shipping_comp_name . "',
                                                                                 shipping_aad1      = '" . $shipping_add1 . "',
                                                                                 shipping_city      = '" . $shipping_city . "',
                                                                                 shipping_state     = '" . $shipping_state_val . "',
                                                                                 shipping_zip       = '" . $shipping_zip . "' ";
                //mysql_query($query);
                $last_id = mysql_insert_id();
            }
        }
        //Customer Data Insert ---End---
        $query_last = "DELETE FROM sohorepro_customers WHERE cus_email = '' ";
       // mysql_query($query_last);



        $result = "success";
    }
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Soho-repro</title>
        <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="js/jquery.min.js"></script>

    </head>

    <body>
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
                            <td width="759" align="left" valign="top" bgcolor="#FFFFFF"><table width="759" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="48" align="center" valign="middle" bgcolor="#5f5f5f" class="heading">
                                            ADMINISTRATOR PAGE
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="38" align="center" valign="middle" bgcolor="#8b8b8b" class="sub_heading">IMPORT CUSTOMERS
                                            <span style="float: right;padding-right: 5px;">Welcome <?php if ($_SESSION['admin_user_type'] == '1') {
    echo 'admin';
} if ($_SESSION['admin_user_type'] == '2') {
    echo 'Staff User';
} ?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td height="30" align="center" valign="top">
<?php
if ($result == "success") {
    ?>
                                                <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Customers Imported Successfully</div>
                                                <script>setTimeout("location.href=\'customers.php\'", 1000);</script>
    <?php
} elseif ($result == "failure") {
    ?>
                                                <div style="color:#F00; text-align:center; padding-bottom:10px;">Customers Imported Not Successfully</div>
                                                <script>setTimeout("location.href=\'customers.php\'", 1000);</script>       
                                                <?php
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <form name="import_customers" id="import_customers" method="post" action="" enctype="multipart/form-data" onsubmit="return validate()" >
                                                <input type="hidden" name="customer_import" value="1" /> 
                                                <div id="msg1" style="color:#FF0000;float: left;width: 759px;text-align: center;font-size: 13px;line-height: 30px;"></div>
                                                <table width="759" border="0" cellspacing="0" cellpadding="0" class="add_product">
                                                    <tr>
                                                        <td width="180" height="48" align="left" valign="middle" class="add_prod_label">Select Excel File</td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont">
                                                            <input type="file" name="excelFile" id="excelFile" class="input-large" onchange = "return Checkfiles();"><div id="msg" style="color:#FF0000"></div> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="1" align="left" valign="middle"></td>
                                                        <td height="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="180" height="48" align="left" valign="middle" class="add_prod_label">&nbsp;</td>
                                                        <td height="48" align="left" valign="middle" class="add_prod_cont"><input type="submit" value="Import" class="product"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="1" align="left" valign="middle"></td>
                                                        <td height="1"></td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td style="background:#464646; text-align:center; color:#fff; line-height:30px;" height="30p">© 2013 sohorepro.com</td>
            </tr>
        </table>
    </body>
</html>

<script language="javascript">
    function validate()
    {
        var str = true;
        document.getElementById("msg1").innerHTML = "";

        if (document.getElementById('excelFile').value == '')
        {
            document.getElementById("msg1").innerHTML = "Select the customers excel sheet";
            str = false;
        }

        return str;

    }
</script>
<script type="text/javascript">
    function Checkfiles()
    {
        document.getElementById("msg").innerHTML = "";
        var fup = document.getElementById('excelFile');
        var fileName = fup.value;
        var ext = fileName.substring(fileName.lastIndexOf('.') + 1);

        if ((ext == "xls" || ext == "XLS") || (ext == "xlsx" || ext == "XLSX"))
        {
            return true;
        }
        else
        {
            //alert("Upload xls file only");
            document.getElementById("msg").innerHTML = "Upload xls file only";
            document.import_customers.excelFile.value = "";
            return false;
        }
    }
</script>


