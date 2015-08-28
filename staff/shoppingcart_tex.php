<?php
include './admin/config.php';
include './admin/db_connection.php';
$_SESSION['job'] = $_REQUEST['jobref'];
echo $user_id = $_SESSION['sohorepro_userid'];

//echo '<pre>';
//print_r($_POST);
//echo '<pre>';
//exit;
for ($i = 0; $i < count($_REQUEST['product_id']); $i++) {
    if ($_REQUEST['quantity'][$i] != '') {
        $chk_pid = checkPid($_REQUEST['product_id'][$i], $user_id);
        if (count($chk_pid) < 1) {
            $query = "INSERT INTO sohorepro_checkout SET product_id     = '" . $_REQUEST['product_id'][$i] . "', quantity = '" . $_REQUEST['quantity'][$i] . "', unit_price = '" . $_REQUEST['price'][$i] . "', user_id = '" . $user_id . "'";
            mysql_query($query);
        }
    }
}
?>


<?php
$checkout_product = checkOut($user_id);
?>
<script src="js/jquery.js" type="text/javascript" ></script>
<style>
    [data-tip] {
	position:relative;
	cursor:pointer;
}
[data-tip]:before {
	content:'';
	/* hides the tooltip when not hovered */
	display:none;
	border:5px solid #1a1a1a;
	/* 4 border technique to create the arrow */
	border-top-color:#1a1a1a;
	border-right-color:transparent;
	border-bottom-color:transparent;
	border-left-color:transparent;
	position:absolute;
	top:-7px;
	left:10px;
	z-index:8;
	font-size:0;
	line-height:0;
	width:0;
	height:0;
}
[data-tip]:after {
	display:none;
	content:attr(data-tip);
	position:absolute;
	top:-35px;
	left:0px;
	padding:5px 8px;
	background:#1a1a1a;
	color:#fff;
	z-index:9;
	font-size: 0.75em;
	height:18px;
	line-height:18px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	white-space:nowrap;
	word-wrap:normal;
}
[data-tip]:hover:before,
[data-tip]:hover:after {
	display:block;
}
.tip-below[data-tip]:after {
	top:23px;
	left:0px;
}
.tip-below[data-tip]:before {
	border-top-color:transparent;
	border-right-color:transparent;
	border-bottom-color:#1a1a1a;
	border-left-color:transparent;
	top:13px;
	left:10px;	
}
.tip-below.success[data-tip]:before {
	border-top-color:transparent;
	border-right-color:transparent;
	border-bottom-color:#51bd6a;
	border-left-color:transparent;
}
</style>
<div style="margin:0px auto; width:600px;" >
    <div style="padding-bottom:10px">
        <h1 align="center">Your Shopping Cart</h1>
        <input type="button" value="Continue Shopping" onclick="window.history.back()" />
    </div>
    <div id="remove_product" style="color:#007F2A; font-size: 13px; alignment-adjust: central;"></div>
    <form name="shopping" method="post">
        <input type="hidden" name="pid" />
        <input type="hidden" name="command" />
        <table border="0" cellpadding="5px" cellspacing="1px" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;" width="100%">
            <tr align="center" style="background-color: #F99B3E;">
                <td>S.No</td>
                <td>SKU ID</td>
                <td>Product Name</td>
                <td>Quantity</td>
                <td>Unit Price</td>
                <td>Line Total</td>
                <td>Address to Ship</td>  
                <td>Option</td>
                              
            </tr>  
            <?php
            $i = 1;
            if (count($checkout_product) > 0) {
                foreach ($checkout_product as $chk) {
                    $super_id = getsuper($chk['product_id']);
                    $cat_id = getcat($chk['product_id']);
                    $sub_id = getsub($chk['product_id']);
                    $super_name = getsuperN($super_id);
                    $cat_name = getcatN($cat_id);
                    $sub_name = getsubN($sub_id);
                    $product_id = $chk['product_id'];
                    $sku_id = getSku($chk['product_id']);
                    $product_name = getProName($chk['product_id']);
                    $quantity = $chk['quantity'];
                    $unit_price = $chk['unit_price'];
                    ?>
                    <tr align="center" style="background-color:#E1E1E1;">
                    <span class="user_id" id="<?php echo $user_id; ?>" style="display: none;"></span>
                    <span class="product_id" id="<?php echo $product_id; ?>" style="display: none;"></span>
                    <td><?php echo $i; ?></td> 
                    <td><?php echo $sku_id; ?></td> 
                    <td><span class="success tip-below" data-tip="<?php echo $super_name; ?>-><?php echo $cat_name; ?>-><?php echo $sub_name; ?>"><?php echo $product_name; ?></span></td> 
                    <td><input type="text" name="qty" class="qty" id="qty" value="<?php echo $quantity; ?>" style="width: 30px; text-align: center;"/></td> 
                    <td><?php echo $unit_price; ?></td>
                    <td><?php echo number_format(($quantity * $unit_price), 2, '.', ''); ?></td> 
                    <td>&nbsp;</td>
                    <td><a onclick="delete_product(<?php echo $product_id; ?>,<?php echo $user_id; ?>);" style="cursor: pointer;">Remove</a></td>                
                    </tr>
                    <?php
                    $i++;
                }
            } else {
                ?>
                <tr align="center" style="background-color:#E1E1E1;">
                    <td colspan="8">There is no product in this cart.</td>
                </tr>
            <?php } ?>
            <tr align="right">
                <td colspan="8"><input type="button" value="Clear Cart" onclick="clear_cart(<?php echo $product_id; ?>,<?php echo $user_id; ?>);"></td>
            </tr>
        </table>
    </form>
</div>


<script>
            function delete_product(product_id, user_id)
            {

                var con = confirm("Are you sure you want to remove this product from this cart.");
                if (con == true)
                {
                    $.ajax
                            ({
                                type: "POST",
                                url: "delete_check_prod.php",
                                data: "product_id=" + product_id + "&user_id=" + user_id,
                                success: function(option)
                                {

                                    $('#remove_product').html(option);
                                    location.reload();
                                }
                            });


                }
            }

            function clear_cart(product_id, user_id)
            {

                var con = confirm("Are you sure you want to clear this cart.");
                if (con == true)
                {
                    $.ajax
                            ({
                                type: "POST",
                                url: "delete_check_prod.php",
                                data: "product_id_clear=" + product_id + "&user_id_clear=" + user_id,
                                success: function(option)
                                {

                                    $('#remove_product').html(option);
                                    location.reload();
                                }
                            });


                }
            }

</script>




<?php
//echo '<pre>';
//print_r($_REQUEST['quantity']);
//echo '</pre>';
exit;

$sql_order_id = mysql_query("SELECT order_number FROM sohorepro_order_master ORDER BY id DESC LIMIT 1");
$object = mysql_fetch_assoc($sql_order_id);

if (count($object['order_number']) > 0) {
    $order_id = ($object['order_number'] + 1);
} else {
    $order_id = '101';
}

if ($_REQUEST['order_val'] == '1') {
    for ($j = 0; $j < count($_REQUEST['product_id']); $j++) {
        if ($_REQUEST['quantity'][$j] != '') {
            $place_order = '1';
        }
    }
    if ($place_order == '1') {
        $job_ref = $_REQUEST['jobref'];
        $sql = "INSERT INTO sohorepro_order_master SET order_number = '" . $order_id . "', order_id     = '" . $job_ref . "', customer_company = '" . $_SESSION['sohorepro_companyid'] . "', customer_name = '" . $user_id . "', created_date = now()";
        mysql_query($sql);
    }
    $order_id_pro = mysql_insert_id();
    if ($order_id_pro != '') {
        for ($i = 0; $i < count($_REQUEST['product_id']); $i++) {
            if ($_REQUEST['quantity'][$i] != '') {

                $query = "INSERT INTO sohorepro_product_master SET product_id     = '" . $_REQUEST['product_id'][$i] . "', product_price = '" . $_REQUEST['price'][$i] . "', product_quantity = '" . $_REQUEST['quantity'][$i] . "', product_name = '" . $_REQUEST['product_name'][$i] . "', order_id = '" . $order_id_pro . "'";
                mysql_query($query);
            }
        }
        $result = "success";
    } else {
        $result = "failure";
    }
}
?>
<?php
if ($result == "success") {
    ?>
    <div style="color:#007F2A; text-align:center; padding-bottom:10px;">Your order is placing</div>
    <script>setTimeout("location.href=\'get_order.php\'", 1000);</script>
    <?php
} elseif ($result == "failure") {
    ?>
    <div style="color:#F00; text-align:center; padding-bottom:10px;">Your order is not placing</div>
    <script>setTimeout("location.href=\'get_order.php\'", 1000);</script> 
    <?php
}
?>


