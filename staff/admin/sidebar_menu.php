
<?php
$page_names=explode("/",$_SERVER['SCRIPT_NAME']);

$pagename_pos = count($page_names)-1;

$page_name_new= $page_names[$pagename_pos];

?>

<table width="198" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#7a7878" class="lft_menu <?php if($page_name_new=='open_orders.php') { echo "active"; } ?>"><a href="open_orders.php">Orders</a></td>
                                                </tr>
                                                <?php if($_SESSION['user_type'] == '2'){ ?>
                                                <tr>
                                                <td width="198" height="40" align="left" valign="middle">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                <td width="198" height="40" align="left" valign="middle">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                <td width="198" height="40" align="left" valign="middle">&nbsp;</td>
                                                </tr>
                                                <?php } ?>
<!--                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#7a7878" class="lft_menu <?php if($page_name_new=='open_order.php') { echo "active"; } ?>"><a href="open_order.php">Open Orders</a></td>
                                                </tr>-->
                                                <?php if($_SESSION['user_type'] == '1'){ ?>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#A6A6A6" class="lft_menu <?php if($page_name_new=='supercategory.php') { echo "active"; } ?>"><a href="supercategory.php">Super category</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#aeaeae" class="lft_menu <?php if($page_name_new=='category.php') { echo "active"; } ?>"><a href="category.php">category</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#9d9c9c" class="lft_menu <?php if($page_name_new=='subcategory.php') { echo "active"; } ?>"><a href="subcategory.php">Sub category</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#8b8b8b" class="lft_menu <?php if($page_name_new=='products.php' || $page_name_new=='edit_products.php' || $page_name_new=='add_new_products.php' || $page_name_new=='import_products.php') { echo "active"; } ?>"><a href="products.php">Products</a></td>
                                                </tr> 
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#8b8b8b" class="lft_menu <?php if($page_name_new=='customers.php' || $page_name_new=='edit_user.php' || $page_name_new=='import_customers.php') { echo "active"; } ?>"><a href="customers.php">Customers</a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#7e7e7e" class="lft_menu <?php if($page_name_new=='reports.php') { echo "active"; } ?>"><a href="reports.php">Reports</a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#7e7e7e" class="lft_menu <?php if($page_name_new=='users.php') { echo "active"; } ?>"><a href="users.php">Users</a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#7a7878" class="lft_menu <?php if($page_name_new=='email_settings.php') { echo "active"; } ?>"><a href="email_settings.php">Settings</a></td>
                                                </tr>
                                                <?php } ?>
                                            </table>