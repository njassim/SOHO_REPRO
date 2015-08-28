<?php
include './config.php';
include './auth.php';
$id_order = $_GET['id'];
$view_orders = viewOrders($id_order);
$id_j = $view_orders[0]['order_id'];

if ($_GET['delete_id']) {

    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM sohorepro_product_master WHERE id = " . $delete_id . " ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_del";
    } else {
        $result = "failure_del";
    }
}

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Soho-repro</title>
        <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />

        <!-- Add fancyBox main JS and CSS files -->
        <script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>

        <!-- Add fancyBox main JS and CSS files -->
        <script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery.fancybox.css?v=2.1.5" media="screen" />



        <script type="text/javascript">
            $(document).ready(function() {
                /**  Simple image gallery. Uses default settings*/
                $('.fancybox').fancybox();

                /**  Different effects */
            });
        </script>
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
                                        <td align="left" valign="top"><table width="198" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#d3d3d3" class="lft_menu active"><a href="index.php">Orders</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#aeaeae" class="lft_menu "><a href="category.php">category</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#9d9c9c" class="lft_menu "><a href="subcategory.php">Sub category</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#8b8b8b" class="lft_menu"><a href="products.php">Products</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#7a7878" class="lft_menu"><a href="email_settings.php">Email Settings</a></td>
                                                </tr>
                                            </table></td>
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
                                        <td height="38" align="center" valign="middle" bgcolor="#8b8b8b" class="sub_heading">ORDERS
                                        <span style="float: right;padding-right: 5px;">Welcome <?php if($_SESSION['admin_user_type'] == '1'){echo 'admin';} if($_SESSION['admin_user_type'] == '2'){echo 'Staff User';}?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td height="30" align="left" valign="top">
                                            <?php
                                            if ($result == "success_del") {
                                                ?>
                                                <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Deleted Successfully</div>
                                                <script>setTimeout("location.href=\'view_orders.php?id=<?php echo $_GET['id']; ?>\'", 1000);</script>
                                                <?php
                                            } elseif ($result == "failure_del") {
                                                ?>
                                                <div style="color:#F00; text-align:center; padding-bottom:10px;">Not Deleted</div>
                                                <script>setTimeout("location.href=\'orders.php\'", 1000);</script>       
                                                <?php
                                            }
                                            ?>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top"><table width="759" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="20" align="left" valign="top"></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top"><table width="500" border="0" cellspacing="0" cellpadding="0">
                                                            <?php
                                                            $sql_id = mysql_query("SELECT id,order_id,created_date FROM sohorepro_order_master WHERE id = '".$id_j."'");
                                                            $object = mysql_fetch_assoc($sql_id);
                                                            $id = $object['id'];
                                                            $Order_id = $object['order_id'];                                                            
                                                            $Date =date("m-d-Y h:m:s", strtotime($object['created_date']));  
                                                            ?>
                                                            <tr>
                                                                <td width="10" align="left" valign="middle" style="font-size:18px; color:#ff9600; text-transform:uppercase;"></td>
                                                                <td width="90" align="left" valign="middle" style="font-size:18px; color:#ff9600; text-transform:uppercase;">Job Ref</td>
                                                                <td width="15" align="left" valign="middle" style="color:#202020;">:</td>
                                                                <td align="left" valign="middle" style="color:#202020;"><?php echo $Order_id; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="10" align="left" valign="middle" style="font-size:18px; color:#ff9600; text-transform:uppercase;"></td>
                                                                <td width="90" align="left" valign="middle" style="font-size:18px; color:#ff9600; text-transform:uppercase;">Date</td>
                                                                <td width="15" align="left" valign="middle" style="color:#202020;">:</td>
                                                                <td align="left" valign="middle" style="color:#202020;"><?php echo $Date; ?></td>
                                                            </tr>
                                                        </table></td>
                                                </tr>
                                                <tr>
                                                    <td height="20" align="left" valign="top"></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" valign="top"><table width="759" border="0" cellspacing="0" cellpadding="0" style="margin-right:-1px;">
                                                            <tr style="color:#fff; text-transform:uppercase;">
                                                                <td width="80" align="center" valign="middle" bgcolor="#f68210" class="brdr">SKU ID</td>
                                                                <td width="319" align="center" valign="middle" bgcolor="#f68210" class="brdr">Product Detail</td>
                                                                <td width="80" align="center" valign="middle" bgcolor="#f68210" class="brdr">Quantity</td>
                                                                <td width="80" align="center" valign="middle" bgcolor="#f68210" class="brdr">Unit Cost</td>
                                                                <td width="80" align="center" valign="middle" bgcolor="#f68210" class="brdr">Line Cost</td>
                                                                <td width="120" align="center" valign="middle" bgcolor="#f68210" class="brdr">Action</td>
                                                            </tr>
                                                            <?php
                                                            $total = 0;
                                                            $i = 0;
                                                            foreach ($view_orders as $ord) {
                                                                $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                                $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                                $prod_id = $ord['product_id'];
                                                                $id = $ord['id'];
                                                                $ord_id = $ord['order_id'];
                                                                $ca_id = $_GET['id'];
                                                                ?>
                                                                <tr>
                                                                    <td width="80" align="left" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="brdr pad_lft"><?php echo getorderSku($prod_id); ?></td>
                                                                    <td width="260" align="left" valign="middle" bgcolor="<?php echo $rowColor1; ?>" class="brdr pad_lft"><?php echo $cName = getorderProd($prod_id); ?></td>
                                                                    <td width="80" align="center" valign="middle" bgcolor="<?php echo $rowColor; ?>"  class="brdr"><?php echo $ord['product_quantity']; ?></td>
                                                                    <td width="80" align="right" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="brdr pad_rght"><?php echo '$' . $ord['product_price']; ?></td>
                                                                    <td width="80" align="right" valign="middle" bgcolor="<?php echo $rowColor; ?>" class="brdr pad_rght"><?php echo '$' . ($ord['product_quantity'] * $ord['product_price']).'.00'; ?></td>
                                                                    <td width="120" align="center" valign="middle" bgcolor="<?php echo $rowColor1; ?>"  class="brdr pad_rght">
                                                                        <a class="fancybox fancybox.iframe" href="edit_order_product.php?id=<?php echo $prod_id; ?>&ord_id=<?php echo $ord_id; ?>&can_id=<?php echo $ca_id; ?>"><img src="images/edit.png"  alt="" width="22" height="22"/></a>
                                                                        <a href="view_orders.php?delete_id=<?php echo $prod_id; ?>" onclick="return confirm('Are you delete this product of this order?');"><img src="images/del.png"  alt="" width="22" height="22" class="mar_lft"/></a></td>
                                                                </tr>
                                                                <?php
                                                                $sub_tot = $ord['product_quantity'] * $ord['product_price'];
                                                                $total = $total + $sub_tot;
                                                                $i++;
                                                            }
                                                            ?>
                                                        </table></td>
                                                </tr>
                                                <tr>
                                                    <td height="20" align="left" valign="top"></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" valign="top"><table width="360" border="0" cellspacing="0" cellpadding="0">

                                                            <tr>
                                                                <td height="30" align="left" valign="middle" class="pad_lft brdr1 brdr-top">Total</td>
                                                                <td width="100" align="right" valign="middle" bgcolor="#FAFAFA" class="pad_rght brdr1 brdr-top brdr-lft"><?php echo '$' . $total.'.00'; ?></td>
                                                                <td width="120" height="30" align="right" valign="middle" bgcolor="#FFFFFF"></td>
                                                            </tr>
                                                        </table></td>
                                                </tr>
                                                <tr>
                                                    <td height="20" align="left" valign="top"></td>
                                                </tr>
                                            </table></td>
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
