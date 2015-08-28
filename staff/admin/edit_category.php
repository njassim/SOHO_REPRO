<?php
include './config.php';
include './auth.php';
$Category = getCategory();
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
$editCategory = editCategory($id);

if ($_REQUEST['edi_cat'] == '1') {
    extract($_POST);
    $sql = "UPDATE sohorepro_category
			SET     category_name = '" . $category_name . "',
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
        <title>Soho-repro</title>
        <style type="text/css">
            body {
                margin-left: 0px;
                margin-top: 0px;
                margin-right: 0px;
                margin-bottom: 0px;
                font-family:Gotham, Helvetica, Arial, sans-serif;
                color:#5f5f5f; font-size:14px;
            }
            table, tr, td, th { margin:0px; padding:0px;}
            .add_title{ border:1px solid #cecece; padding-left:10px; text-transform:uppercase; color:#5f5f5f; font-size:16px;}
            .form_bg{ border:1px solid #cecece; border-top:0px !important; color:#5f5f5f; font-size:12px;}
            .td_brdr{ border-bottom:1px solid #fff; color:#fff; font-size:14px; text-transform:uppercase;}
            .mar_lft{ margin-left:10px;}
            .lft_menu{  color:#fff; font-size:16px; text-transform:uppercase;}
            .lft_menu a{ background:url(images/arw_bullets.png) no-repeat 12px 0px; padding-left:46px; text-decoration:none; color:#fff; width:152px; height:40px;}
            .lft_menu:hover{ background:#ff7e00}
            .active{ background:#ff7e00}
            .input_text{ border:1px solid #aeaeae; width:150px; height:30px; float:right; background:#fff; -webkit-border-radius: 5px;
                         -moz-border-radius: 5px;
                         border-radius: 5px;}
            .select_text{ border:1px solid #aeaeae; width:162px; height:30px; float:right; background:#fff; -webkit-border-radius: 5px;
                          -moz-border-radius: 5px; font-size:12px; color:#464646;
                          border-radius: 5px; padding:5px;}
            .add_btn { background:url(images/add_btn.png) no-repeat; width:82px; height:34px; border:0px;}
            .heading
            {
                font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-size:38px;
                color:#fff;
                text-align:center;
                letter-spacing:0.4em;
            }
            .sub_heading
            {
                font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-size:16px;
                color:#fff;
                text-align:center;

            }
        </style>
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
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#aeaeae" class="lft_menu active"><a href="category.php">category</a></td>
                                                </tr>
                                                <tr>
                                                    <td width="198" height="40" align="left" valign="middle" bgcolor="#9d9c9c" class="lft_menu "><a href="subcategory.php">Sub category</a></td>
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
                                            RECENT CATEGORY
                                            <span style="float: right;padding-right: 5px;">Welcome <?php if($_SESSION['admin_user_type'] == '1'){echo 'admin';} if($_SESSION['admin_user_type'] == '2'){echo 'Staff User';}?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="14" align="left" valign="middle"></td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><table width="759" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="38" align="left" valign="middle" class="add_title">Edit category</td>
                                                </tr>
                                                <tr>
                                                    <td height="60" align="left" valign="top" bgcolor="#f6f6f6" class="form_bg">
                                                        <form name="new_category" id="new_category" method="post" action=""  onsubmit="return validate()" >
                                                            <input type="hidden" name="edi_cat" value="1" />       
                                                            <input type="hidden" name="edi_cat_id" id="edi_cat_id" value="<?php echo $editCategory[0]['id']; ?>" />     
                                                            <table width="600" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td width="125" height="60" align="right" style="font-size:12px;" valign="middle">category name</td>
                                                                    <td width="160" height="60" align="right" valign="middle"><input type="text" autocomplete="off" name="category_name" id="category_name" value="<?php echo $editCategory[0]['category_name']; ?>" class="input_text" ></td>
                                                                    <td width="60" height="60" align="right" style="font-size:12px;" valign="middle">status</td>
                                                                    <td width="20" height="60" align="left" valign="middle"><input type="radio" name="status" value="1" <?php if ($editCategory[0]['status'] == '1') echo 'checked'; ?>></td>
                                                                    <td width="50" height="60" align="left" style="font-size:12px;" valign="middle">Active</td>
                                                                    <td width="20" height="60" align="left" valign="middle"><input type="radio" name="status" value="0" <?php if ($editCategory[0]['status'] == '0') echo 'checked'; ?>></td>
                                                                    <td width="70" height="60" align="left" style="font-size:12px;" valign="middle">InActive</td>
                                                                    <td width="90" height="60" align="left" valign="middle"><input type="submit" value=" " class="add_btn"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="9" style="color:#F00; text-align:center; padding-bottom:10px;">
                                                                        <?php
                                                                        if ($result == "success") {
                                                                            ?>
                                                                            <div style="color:#16F20F; text-align:center; padding-bottom:10px;">Updated Successfully</div>
                                                                            <script>setTimeout("location.href=\'category.php\'", 2000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Updated Not Successfully</div>
                                                                            <script>setTimeout("location.href=\'category.php\'", 2000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($result == "success_del") {
                                                                            ?>
                                                                            <div style="color:#16F20F; text-align:center; padding-bottom:10px;">Deleted successfully</div>
                                                                            <script>setTimeout("location.href=\'category.php\'", 2000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_del") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Not deleted</div>
                                                                            <script>setTimeout("location.href=\'category.php\'", 2000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>

                                                                        <div id="msg1" style="color:#FF0000"></div>
                                                                        <div id="msg2" style="color:#FF0000"></div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </form>   
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
                                                    <td width="439" colspan="2" valign="middle" height="28" bgcolor="#f99b3e" align="center" class="td_brdr">category</td>
                                                    <td width="100" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">status</td>
                                                    <td width="140" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                if (count($Category) > 0) {
                                                    foreach ($Category as $Cate) {
                                                        $rowColor = ($i % 2 != 0) ? '#f9f9f9' : '#dfdfdf';
                                                        $id = $Cate['id'];
                                                        $name = $Cate['category_name'];
                                                        $status = ($Cate['status'] == 1) ? 'active' : 'de-active';
                                                        ?>
                                                        <tr bgcolor="<?php echo $rowColor; ?>">
                                                            <td width="80" height="36" align="center" valign="middle"><?php echo $i; ?></td>
                                                            <td width="439" colspan="2" height="36" align="center" valign="middle"><?php echo $name; ?></td>                
                                                            <td width="100" height="36" align="center" valign="middle"><img src="images/<?php echo $status; ?>.png" width="22" height="22"  alt=""/></td>
                                                            <td width="140" height="36" align="center" valign="middle"><a style="text-decoration: none;color:#000;" href="edit_category.php?id=<?php echo $id; ?>"><img src="images/edit.png"  alt="" width="22" height="22"/></a><a style="text-decoration: none;color:#000;" href="category.php?delete_id=<?php echo $id; ?>" onclick="return confirm('Are you delete this category?');"><img src="images/del.png"  alt="" width="22" height="22" class="mar_lft"/></a></td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    ?>
                                                    <tr align="center">
                                                        <td colspan="4">There is no categories</td>
                                                    </tr>
                                                    <?php
                                                }
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

                                                                                if (document.new_category.category_name.value == '')
                                                                                {
                                                                                    document.getElementById("msg1").innerHTML = "Enter the category name";
                                                                                    str = false;
                                                                                }

                                                                                if ((document.new_category.status[0].checked == '') && (document.new_category.status[1].checked == ''))
                                                                                {
                                                                                    document.getElementById("msg2").innerHTML = "Select the status";
                                                                                    str = false;
                                                                                }

                                                                                return str;

                                                                            }
</script>