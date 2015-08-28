<?php
include './config.php';
include './auth.php';   
if ($_REQUEST['new_prod'] == '1') {
    
    if($_FILES['excelFile']['name']!="")
		{
			$fileName=uploadFile($_FILES['excelFile'],array(".xls",".xlsx"),"excel_file");
			$data = new Spreadsheet_Excel_Reader();
                        //$data->read('excel_file/sep_11/Large Format Media.xls');
                        //$data->read('excel_file/sep_11/Copy Print Media.xls');
                        //$data->read('excel_file/sep_11/Ink & Toner.xls'); 
                        //$data->read('excel_file/sep_11/Binding Supplies.xls'); 
                        //$data->read('excel_file/sep_11/Display Boards.xls');  
                        //$data->read('excel_file/sep_11/Packaging.xls');                   
                        $data->read('excel_file/sep_11/Sketch Paper.xls'); 
                        
                        //$data->read('excel_file/'.$fileName);
                        $name = explode(".", $fileName);
                        $super          = $name[0];
                        $check_super    = checkSuperCate($super);                        
                       
                        $sql_order_id = mysql_query("SELECT id FROM sohorepro_category ORDER BY id DESC LIMIT 1");
                        $object2 = mysql_fetch_assoc($sql_order_id);
                                    
                            if (count($object2['id']) > 0) {
                            $sort_id_super  = ($object2['id'] + 1);
                            } 
                            else
                            {
                            $sort_id_super  = '1';
                            }
                        
                        
                        if(count($check_super) == 0)
                        {                            
                            $query = "INSERT INTO sohorepro_category SET category_name = '".$super."', status = '1', sort = '".$sort_id_super."' ";
                            mysql_query($query);
                        }
                        $super_cate_id = mysql_insert_id();
                        
			for($i=1;$i<=$data->sheets[0]['numRows'];$i++)
			{
				//$cate_id        = '';
                                //$sup_cat_id     = '';
                                $data1          =       mysql_real_escape_string($data->sheets[0]['cells'][$i][1]);
				$data2          =       mysql_real_escape_string($data->sheets[0]['cells'][$i][2]);
                                $data3          =       mysql_real_escape_string($data->sheets[0]['cells'][$i][3]);
				$data4          =       $data->sheets[0]['cells'][$i][4];
                                $data5          =       $data->sheets[0]['cells'][$i][5];
				$check_cate     =       checkCate($data1);
                                $check_sub      =       checkSubCate($data2);
                                $check_pro      =       getproductName($data3);
                                
                                $sql_order_id = mysql_query("SELECT id FROM sohorepro_category ORDER BY id DESC LIMIT 1");
                                $object2 = mysql_fetch_assoc($sql_order_id);
                                    
                                    if (count($object2['id']) > 0) {
                                    $sort_id = ($object2['id'] + 1);
                                    } 
                                    else
                                    {
                                    $sort_id = '1';
                                    }
                                
                                if(count($check_cate) < 1)
                                {
				$query="INSERT INTO sohorepro_category SET category_name = '".$data1."', super_id = '".$super_cate_id."', status = '1', sort = '".$sort_id."' ";
                                mysql_query($query);
                                $cate_id = mysql_insert_id();
                                }
                                if($data2 != '')
                                {
                                    if(count($check_sub) < 1)
                                    {
                                      $query="INSERT INTO sohorepro_category SET category_name = '".$data2."', super_id = '".$super_cate_id."', parent_id = '".$cate_id."', status = '1', sort = '".$sort_id."'";
                                      mysql_query($query);
                                      $sub_cate_id = mysql_insert_id();
                                    }
                                }
                                
                                if(count($check_pro) < 1)
                                {
                                    $sql_sk = mysql_query("SELECT sku_id FROM sohorepro_products ORDER BY id DESC LIMIT 1");
                                    $object = mysql_fetch_assoc($sql_sk);

                                    if (count($object['sku_id']) > 0) {
                                        $sku = ($object['sku_id'] + 1);
                                    } else {
                                        $sku = "10001";
                                    }
                                    
                                    $sql_order_id = mysql_query("SELECT id FROM sohorepro_products ORDER BY id DESC LIMIT 1");
                                    $object1 = mysql_fetch_assoc($sql_order_id);
                                    
                                    if (count($object1['id']) > 0) {
                                    $sort_id = ($object1['id'] + 1);
                                    } 
                                    else
                                    {
                                    $sort_id = '1';
                                    }
                                    $price                = number_format(($data5 * ($data4/100)), 2, '.', ''); 
                                    $special_price        = ($data4 - $price); 
                                    $special              = number_format(($special_price), 2, '.', ''); 
                                    $query = "INSERT INTO sohorepro_products SET supercategory_id = '".$super_cate_id."', category_id = '".$cate_id."', subcategory_id = '". $sub_cate_id ."', sku_id = '".$sku."', product_name = '". $data3 ."', list_price = '". $data4 ."', discount = '". $data5 ."', price = '".$special."', status = '1', sort = '". $sort_id ."' ";
                                    mysql_query($query);
                                    
                                }
                                
//                                if($data5 != '0')
//                                {
//                                    $price                = number_format(($data5 * ($data4/100)), 2, '.', ''); 
//                                    $special_price        = ($data4 - $price); 
//                                    $special              = number_format(($special_price), 2, '.', ''); 
//                                    $query = "INSERT INTO sohorepro_special_pricing SET sp_list_price = '".$data4."', sp_discount = '".$data5."', sp_special_price = '". $special ."' ";
//                                    mysql_query($query);
//                                }
			}                        
                        $pro = tempProd();
                        foreach ($pro as $PP)
                        {   
                            $product_id      = $PP['id'];
                            $list_price      = $PP['list_price'];
                            $discount        = $PP['discount'];
                            $special_price   = $PP['price'];
                            $id_check        = checkID($product_id);
                            if(count($id_check) < 1)
                            {
                                if($discount != '0.00')
                                    {
                                       // $query = "INSERT INTO sohorepro_special_pricing_excel SET sp_product_id = '".$product_id."', sp_list_price = '".$list_price."', sp_discount = '".$discount."', sp_special_price = '". $special_price ."' ";
                                       // mysql_query($query); 
                                    }
                            }
                            
                        }
                        
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
                                        <td height="38" align="center" valign="middle" bgcolor="#8b8b8b" class="sub_heading">IMPORT PRODUCTS
                                        <span style="float: right;padding-right: 5px;">Welcome <?php if($_SESSION['admin_user_type'] == '1'){echo 'admin';} if($_SESSION['admin_user_type'] == '2'){echo 'Staff User';}?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td height="30" align="center" valign="top">
                                            <?php
                                            if ($result == "success") {
                                                ?>
                                                <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Products Imported Successfully</div>
                                                <script>setTimeout("location.href=\'products.php\'", 1000);</script>
                                                <?php
                                            } elseif ($result == "failure") {
                                                ?>
                                                <div style="color:#F00; text-align:center; padding-bottom:10px;">Products Imported Not Successfully</div>
                                                <script>setTimeout("location.href=\'products.php\'", 1000);</script>       
                                                <?php
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <form name="import_products" id="import_products" method="post" action="" enctype="multipart/form-data" onsubmit="return validate()" >
                                                <input type="hidden" name="new_prod" value="1" />        
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
                                                        document.getElementById("msg2").innerHTML = "";
                                                        document.getElementById("msg3").innerHTML = "";
                                                        document.getElementById("msg4").innerHTML = "";
                                                        document.getElementById("msg5").innerHTML = "";
                                                        document.getElementById("msg6").innerHTML = "";

                                                         if (document.new_products.supercategory_name.value == '0')
                                                        {
                                                            document.getElementById("msg6").innerHTML = "Select the Super Category Name";
                                                            str = false;
                                                        }
//                                                        if (document.new_products.category_name.value == '0')
//                                                        {
//                                                            document.getElementById("msg1").innerHTML = "Select the Category Name";
//                                                            str = false;
//                                                        }
//                                                        if (document.new_products.subcategory_name.value == '0')
//                                                        {
//                                                            document.getElementById("msg2").innerHTML = "Select the Sub-Category Name";
//                                                            str = false;
//                                                        }
                                                        if (document.new_products.product_name.value == '')
                                                        {
                                                            document.getElementById("msg3").innerHTML = "Enter the Product Name";
                                                            str = false;
                                                        }
                                                        if (document.new_products.price.value == '')
                                                        {
                                                            document.getElementById("msg4").innerHTML = "Enter the Price";
                                                            str = false;
                                                        }

                                                        if ((document.new_products.status[0].checked == '') && (document.new_products.status[1].checked == ''))
                                                        {
                                                            document.getElementById("msg5").innerHTML = "Select the Status";
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

    if((ext =="xls" || ext=="XLS") || (ext == "xlsx" || ext == "XLSX"))
    {
        return true;
    }
    else
    {
        //alert("Upload xls file only");
        document.getElementById("msg").innerHTML = "Upload xls file only";
        document.import_products.excelFile.value = ""; 
        return false;
    }
    }
	</script>


