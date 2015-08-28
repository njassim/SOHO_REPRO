<?php
include './config.php';
include './auth.php';
$SubCategory = getSubCategory();
if ($_GET['delete_id']) {

    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM sohorepro_category WHERE id = " . $delete_id . " ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_del";
    } else {
        $result = "failure_del";
    }
}
?>
<?php
$id = $_GET['id'];
$editSubCategory = editCategory($id);
$active_category = getCategoryActive();
if ($_REQUEST['edi_subcat'] == '1') {
    extract($_POST);
    $sql = "UPDATE sohorepro_category
			SET     category_name = '" . $subcategory_name . "',
                                parent_id     = '" . $category_name . "',
				status = '" . $status . "' WHERE id = " . $id . " ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success";
    } else {
        $result = "failure";
    }
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Soho Repro Admin</title>
        
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
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#d3d3d3" class="lft_menu"><a href="index.php">Dashboard</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#aeaeae" class="lft_menu"><a href="category.php">category</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#9d9c9c" class="lft_menu active"><a href="subcategory.php">Sub category</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#8b8b8b" class="lft_menu"><a href="products.php">ProductS</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#7a7878" class="lft_menu"><a href="#">Orders</a></td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle" style="height:280px; float:left;"></td>
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
                                        <td height="38" align="center" valign="middle" bgcolor="#8b8b8b" class="sub_heading">
                                            RECENT SUB CATEGORY
                                            <span style="float: right;padding-right: 5px;">Welcome <?php if($_SESSION['admin_user_type'] == '1'){echo 'admin';} if($_SESSION['admin_user_type'] == '2'){echo 'Staff User';}?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="14" align="left" valign="middle"></td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><table width="759" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="38" align="left" valign="middle" class="add_title">Edit Sub - category</td>
                                                </tr>
                                                <tr>
                                                    <td height="60" align="right" valign="top" bgcolor="#f6f6f6" class="form_bg">
                                                        <div id="toPopup">
                                                        <form name="new_subcategory" id="new_subcategory" method="post" action=""  onsubmit="return validate()" >
                                                            <input type="hidden" name="edi_subcat" value="1" />  
                                                            <input type="hidden" name="edi_sub_cat_id" id="edi_sub_cat_id" value="<?php echo $editSubCategory[0]['id']; ?>" />  
                                                            <table width="759" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td width="125" height="60" align="right" style="font-size:12px;" valign="middle">Sub category name</td>
                                                                    <td width="160" height="60" align="right" valign="middle"><input type="text" autocomplete="off" name="subcategory_name" id="subcategory_name" class="input_text" value="<?php echo $editSubCategory[0]['category_name'];?>" /></td>
                                                                    <td width="172" height="60" align="left" valign="middle">
                                                                        <select name="category_name" id="category_name" class="select_text" >
                                                                            <?php
                                                                            foreach ($active_category as $categ) {
                                                                                if ($categ['id'] == $editSubCategory[0]['parent_id']) {
                                                                                    ?>
                                                                                    <option value="<?php echo $categ['id']; ?>" selected="selected"><?php echo $categ['category_name']; ?></option>
                                                                                <?php } else { ?>
                                                                                    <option value="<?php echo $categ['id']; ?>"><?php echo $categ['category_name']; ?></option>
                                                                                <?php }
                                                                            } ?>
                                                                        </select>
                                                                    </td>
                                                                    <td width="60" height="60" align="right" style="font-size:12px;" valign="middle">status</td>
                                                                    <td width="20" height="60" align="left" valign="middle"><input type="radio" name="status" value="1" <?php if($editSubCategory[0]['status'] =='1') echo 'checked'; ?>></td>
                                                                    <td width="50" height="60" align="left" style="font-size:12px;" valign="middle">Active</td>
                                                                    <td width="20" height="60" align="left"  valign="middle"><input type="radio" name="status" value="0" <?php if($editSubCategory[0]['status'] =='0') echo 'checked'; ?>></td>
                                                                    <td width="70" height="60" align="left" style="font-size:12px;" valign="middle">InActive</td>
                                                                    <td width="90" height="60" align="left" valign="middle"><input type="submit" value="" class="add_btn"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="9" style="text-align:center; padding-bottom:10px;">

                                                                        <?php
                                                                        if ($result == "success") {
                                                                            ?>
                                                                            <div style="color:#16F20F; text-align:center; padding-bottom:10px;">Sub-category updated successfully</div>
                                                                            <script>setTimeout("location.href=\'subcategory.php\'", 2000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Sub-category updated not successfully</div>
                                                                            <script>setTimeout("location.href=\'subcategory.php\'", 2000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($result == "success_del") {
                                                                            ?>
                                                                            <div style="color:#16F20F; text-align:center; padding-bottom:10px;">Deleted successfully</div>
                                                                            <script>setTimeout("location.href=\'subcategory.php\'", 2000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_del") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Not deleted</div>
                                                                            <script>setTimeout("location.href=\'subcategory.php\'", 2000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>

                                                                        <div id="msg1" style="color:#FF0000"></div>
                                                                        <div id="msg2" style="color:#FF0000"></div>
                                                                        <div id="msg3" style="color:#FF0000"></div>

                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                    <tr>
                                        <td height="15" align="left" valign="top"></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top"><table width="759" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="80" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>
                                                    <td width="230" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Sub-category</td>
                                                    <td width="209" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">category</td>
                                                    <td width="100" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">status</td>
                                                    <td width="140" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                if (count($SubCategory) > 0) {
                                                    foreach ($SubCategory as $Cate) {
                                                        $rowColor = ($i % 2 != 0) ? '#f9f9f9':'#dfdfdf'; 
                                                        $id = $Cate['id'];
                                                        $name = $Cate['category_name'];
                                                        $parent = $Cate['parent_id'];
                                                        $status = ($Cate['status'] == 1) ? 'active' : 'de-active';
                                                        ?>
                                                        <tr bgcolor="<?php echo $rowColor; ?>">
                                                            <td width="80" height="36" align="center" valign="middle"><?php echo $i; ?></td>
                                                            <td width="230" height="36" align="center" valign="middle"><?php echo $name; ?></td>
                                                            <td width="209" height="36" align="center" valign="middle"><?php echo $cName = getCategoryName($parent); ?></td>
                                                            <td width="100" height="36" align="center" valign="middle"><img src="images/<?php echo $status; ?>.png" width="22" height="22"  alt=""/></td>
                                                            <td width="140" height="36" align="center" valign="middle"><a style="border: 0;" href="edit_subcategory.php?id=<?php echo $id; ?>"><img src="images/edit.png"  alt="" width="22" height="22"/></a><a href="subcategory.php?delete_id=<?php echo $id; ?>" onclick="return confirm('Are you delete this subcategory?');"><img src="images/del.png"  alt="" width="22" height="22" class="mar_lft"/></a></td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    ?>
                                                    <tr >
                                                        <td colspan="5">There is no sub categories</td>
                                                    </tr>

                                                <?php }
                                                ?>

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
<script language="javascript">
                                                                            function validate()
                                                                            {
                                                                                var str = true;
                                                                                document.getElementById("msg1").innerHTML = "";
                                                                                document.getElementById("msg2").innerHTML = "";
                                                                                document.getElementById("msg3").innerHTML = "";

                                                                                if (document.new_subcategory.category_name.value == '0')
                                                                                {
                                                                                    document.getElementById("msg1").innerHTML = "Select the category name";
                                                                                    str = false;
                                                                                }
                                                                                if (document.new_subcategory.subcategory_name.value == '')
                                                                                {
                                                                                    document.getElementById("msg2").innerHTML = "Enter the sub category name";
                                                                                    str = false;
                                                                                }

                                                                                if ((document.new_subcategory.status[0].checked == '') && (document.new_subcategory.status[1].checked == ''))
                                                                                {
                                                                                    document.getElementById("msg3").innerHTML = "Select the status";
                                                                                    str = false;
                                                                                }

                                                                                return str;

                                                                            }
</script>