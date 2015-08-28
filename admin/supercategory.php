<?php
include './config.php';
include './auth.php';
$sort_c   = ($_REQUEST['sort'] == 'ca') ? 'cd' : 'ca';
$sort_c_img  = ($_REQUEST['sort'] == 'ca') ? 'down' : 'up';

$Category = getSuperCategory($_REQUEST['sort']);

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
if ($_REQUEST['new_cat'] == '1') {
    extract($_POST);
    $sql_order_id = mysql_query("SELECT id FROM sohorepro_category WHERE parent_id = '0' AND super_id = '0' ORDER BY id DESC LIMIT 1");
    $object = mysql_fetch_assoc($sql_order_id);
    if (count($object['id']) > 0) {
    $sort_id = ($object['id'] + 1);
    } 
    else
    {
    $sort_id = '1';
    }
    
    $sql = "INSERT INTO sohorepro_category
			SET     category_name = '" . $category_name . "',
				status = '" . $status . "', sort = '".$sort_id."' ";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success";
    } else {
        $result = "failure";
    }
}
?>
<?php
if ($_GET['status_id']) {

    $change_status = ($_GET['change_id'] == 1) ? '0' : '1';
    $status_id = $_GET['status_id'];
    $sql = "UPDATE sohorepro_category
			SET     status     = '" . $change_status . "' WHERE id= '" . $status_id . "'";

    $sql_result = mysql_query($sql);
    if ($sql_result) {
        $result = "success_status";
    } else {
        $result = "failure_status";
    }
}
?>
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
        <!--End -->       
        <script src="js/jquery.tablednd_0_5.js" type="text/javascript"></script>
        <!--<script src="js/core.js" type="text/javascript"></script>-->
    </head>

    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center" valign="top">
                    <table width="960" border="0" cellspacing="0" cellpadding="0" style="min-width:760px;">
                        <tr>
                            <td width="198" align="left" valign="top" bgcolor="#464646"><table width="198" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="185" align="left" valign="top"><img src="images/logo.jpg" width="198" height="181"  alt=""/></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <?php include "sidebar_menu.php"; ?>
                                        </td>
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
                                            SUPER CATEGORY
                                            <span style="float: right;padding-right: 5px;">Welcome <?php if($_SESSION['admin_user_type'] == '1'){echo 'admin';} if($_SESSION['admin_user_type'] == '2'){echo 'Staff User';}?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="14" align="left" valign="middle"></td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><table width="759" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td height="38" align="left" valign="middle" class="add_title">Add Super category</td>
                                                </tr>
                                                <tr>
                                                    <td height="60" align="left" valign="top" bgcolor="#f6f6f6" class="form_bg">
                                                        <form name="new_supercategory" id="new_supercategory" method="post" action=""  onsubmit="return validate()" >
                                                            <input type="hidden" name="new_cat" value="1" />       
                                                            <table width="600" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td width="200" height="60" align="right" style="font-size:12px;" valign="middle">Enter Super Category</td>
                                                                    <td width="160" height="60" align="right" valign="middle"><input type="text" autocomplete="off" name="category_name" id="category_name" class="input_text" ></td>

                                                                    <td width="60" height="60" align="right" style="font-size:12px;" valign="middle">Status</td>
                                                                    <td width="40" height="60" align="center" valign="middle"><input type="radio" name="status" value="1" checked="checked" ></td>
                                                                    <td width="50" height="60" align="left" style="font-size:12px;" valign="middle">Active</td>
                                                                    <td width="20" height="60" align="left" valign="middle"><input type="radio" name="status" value="0" ></td>
                                                                    <td width="70" height="60" align="left" style="font-size:12px;" valign="middle">InActive</td>
                                                                    <td width="90" height="60" align="left" valign="middle"><input type="submit" id="submit" value=" " class="add_btn"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="9" style="color:#F00; text-align:center; font-size: 12px;">
                                                                        <?php
                                                                        if ($result == "success") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Inserted Successfully</div>
                                                                            <script>setTimeout("location.href=\'supercategory.php\'", 1000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Not Successfully</div>
                                                                            <script>setTimeout("location.href=\'supercategory.php\'", 1000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($result == "success_del") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Deleted Successfully</div>
                                                                            <script>setTimeout("location.href=\'supercategory.php\'", 1000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_del") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Not Deleted</div>
                                                                            <script>setTimeout("location.href=\'supercategory.php\'", 1000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($result == "success_status") {
                                                                            ?>
                                                                            <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Status change successfully</div>
                                                                            <script>setTimeout("location.href=\'supercategory.php\'", 1000);</script>
                                                                            <?php
                                                                        } elseif ($result == "failure_status") {
                                                                            ?>
                                                                            <div style="color:#F00; text-align:center; padding-bottom:10px;">Status change not successfully</div>
                                                                            <script>setTimeout("location.href=\'supercategory.php\'", 1000);</script>       
                                                                            <?php
                                                                        }
                                                                        ?>   
                                                                        <div id="msg1" style="color:#FF0000;padding-left:35px;font-size: 12px;"></div>
                                                                        <div id="msg2" style="color:#FF0000;padding-left:35px;font-size: 12px; display: none;"></div>
                                                                        <div id="msg" style="color:#007F2A; font-size: 13px;"></div>
                                                                        <span class="check" style="color:#FF0000;padding-left:35px;font-size: 12px;"  ></span>
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
                                        <td align="left" valign="top">
                                            <table width="759" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="80" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.no</td>
                                                    <td width="439" colspan="2" valign="middle" height="28" bgcolor="#f99b3e" align="left" class="td_brdr pad_lft"><a style="text-decoration: none; color: #fff;" href="supercategory.php?sort=<?php echo $sort_c; ?>">Super category&nbsp;<img src="images/<?php echo $sort_c_img ; ?>.png"  alt="" width="10px" height="5px"/></a></td>
                                                    <td width="100" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">status</td>
                                                    <td width="140" height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">action</td>
                                                </tr>
                                            </table>
                                             <table width="759" border="0" cellspacing="0" cellpadding="0" class="tbl_repeat">
                                                <?php
                                                $i = 1;
                                                if (count($Category) > 0) {
                                                    foreach ($Category as $Cate) {
                                                        $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                                                        $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                                                        $id = $Cate['id'];
                                                        $name = $Cate['category_name'];
                                                        $status = ($Cate['status'] == 1) ? 'active' : 'de-active';
                                                        ?>
                                                        <tr  style="font-size: 14px;" id="order_<?php echo $id; ?>">
                                                            <td width="80" height="36" align="center" bgcolor="<?php echo $rowColor; ?>" valign="middle"><?php echo $i; ?></td>
                                                            <td width="439" colspan="2" height="36" bgcolor="<?php echo $rowColor1; ?>" align="left" class="pad_lft" valign="middle"><?php echo $name; ?></td>                
                                                            <td width="100" height="36" align="center" bgcolor="<?php echo $rowColor; ?>" valign="middle"><a href="category.php?status_id=<?php echo $id; ?>&change_id=<?php echo $Cate['status']; ?>" onclick="return confirm('Are you change the status in this category?');"><img src="images/<?php echo $status; ?>.png" width="22" height="22"  alt="Status" title="Status"/></a></td>
                                                            <td width="140" height="36" align="center" bgcolor="<?php echo $rowColor1; ?>" valign="middle">
                                                                <a class="fancybox fancybox.iframe" href="edit_cat.php?id=<?php echo $id; ?>"><img src="images/edit.png"  alt="Edit" title="Edit" width="22" height="22"/></a><a style="text-decoration: none;color:#000;" href="supercategory.php?delete_id=<?php echo $id; ?>" onclick="return confirm('Are you delete this category?');"><img src="images/del.png"  alt="Delete" title="Delete" width="22" height="22" class="mar_lft"/></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    ?>
                                                    <tr  bgcolor="<?php echo $rowColor; ?>">
                                                        <td colspan="4" align="center">There is no supercategories</td>
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
                <td style="background:#464646; text-align:center; color:#fff; line-height:30px;" height="30p">© <?php echo date('Y'); ?> sohorepro.com</td>
            </tr>
        </table>
        <?php
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



    </body>
</html>

<script language="javascript">
                                                                                function validate()
                                                                                {
                                                                                    if (document.new_supercategory.category_name.value == '')
                                                                                    {
                                                                                        document.getElementById("msg1").innerHTML = "Enter super category";
                                                                                        return false;
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        document.getElementById("msg1").innerHTML = "";
                                                                                    }

                                                                                    if ((document.new_supercategory.status[0].checked == '') && (document.new_category.status[1].checked == ''))
                                                                                    {
                                                                                        document.getElementById("msg2").innerHTML = "Select the status";
                                                                                        return false;
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        document.getElementById("msg2").innerHTML = "";
                                                                                    }

                                                                                    return true;

                                                                                }
</script>
<script type="text/javascript">
    $(function()
    {
        $('#category_name').bind('keyup', function()
        {
            var category_name = trim($(this).val());
            if (category_name != '')
            {
                var dataString = 'category_name=' + category_name;
                $.ajax({
                    type: "POST",
                    url: "check_catename_exist.php",
                    data: dataString,
                    cache: false,
                    success: function(result)
                    {
                        var result = trim(result);
                        if (result == '1')
                        {
                            $('.check').html('Category name already exist');
                            $('#submit').attr('disabled', true);
                            //$('#submit').attr('value', 'Deactive');
                            $('#titleExist').attr("value", "1");
                        }
                        else
                        {
                            $('#titleExist').attr("value", "0");
                            $('.check').html('');
                            $('#submit').attr('disabled', false);
                            //$('#submit').attr('value', 'Active');
                        }
                    }
                });
            }
        });
    });
    function trim(str) {
        var str = str.replace(/^\s+|\s+$/, '');
        return str;
    }
    
    
    $(function (){
        $(".tbl_repeat tbody").tableDnD({
		onDrop: function(table, row) {
			var orders = $.tableDnD.serialize();
			$.post('superorder.php', { orders : orders });
                        if(true){
                            alert('Supercategory order sorting');
                            $("#msg").html('super category order sorted successfully');
                            window.location = "supercategory.php";
                        }
                }
	});
    
    });
    
</script>