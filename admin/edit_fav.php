<?php
include './config.php';
include './auth.php';
$comp_id = $_GET['comp_id'];
$editfav = ALLFAV($comp_id);

//echo '<pre>';
//print_r($editfav);
//echo '</pre>';


if (isset($_REQUEST['Delete'])) {
    $cnt = array();
    $cnt = count($_POST['delete_val']);
    for ($i = 0; $i < $cnt; $i++) {
        $id = $_POST['delete_val'][$i];
        $query = "DELETE FROM sohorepro_favorites WHERE id = '" . $id . "'";
        $result = mysql_query($query);
        if ($result) {
            ?>
            <script> window.top.location = "edit_fav.php?comp_id=<?php echo $comp_id; ?>";</script>
            <?php
        }
    }
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Soho-repro</title>
        <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="style/pagination.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
        <script src="../js/jquery.js" type="text/javascript" ></script>
        <!--<script src="js/core.js" type="text/javascript"></script>-->
         <script src="js/jquery.tablednd_0_5.js" type="text/javascript"></script>
         
         <script>
             
             function edit_inline(ID)
             {
                 $("#fav_list_spn_"+ID).hide(500);
                 $("#fav_disc_spn_"+ID).hide(500);
                 $("#fav_sell_spn_"+ID).hide(500);
                 $("#delete_chk_"+ID).hide(500);
                 $("#fav_list_txt_"+ID).show(500);
                 $("#fav_disc_txt_"+ID).show(500);
                 $("#fav_sell_txt_"+ID).show(500);
                 $("#update_fav_"+ID).show(500);
             }
             
             function update_faverites(ID)
             {
                var list        = document.getElementById('fav_list_txt_'+ID).value;
                var discount    = document.getElementById('fav_disc_txt_'+ID).value;
                var sell        = document.getElementById('fav_sell_txt_'+ID).value;
                
                if(sell != ''){
                $.ajax
                ({
                    type: "POST",
                    url: "inline_edit_favorites.php",
                    data: "inline_edit_fav=1&list_amount="+list+"&discount_amount="+discount+"&sell_amount="+sell+"&product_id="+ID,
                    beforeSend: loadStart,
                    complete: loadStop,
                    success: function(option)
                    {   
                        $("#fav_list_spn_"+ID).html(list);
                        $("#fav_disc_spn_"+ID).html(option);
                        $("#fav_sell_spn_"+ID).html(sell);
                                                
                        $("#fav_list_spn_"+ID).show(500);
                        $("#fav_disc_spn_"+ID).show(500);
                        $("#fav_sell_spn_"+ID).show(500);
                        $("#delete_chk_"+ID).show(500);
                        
                        $("#fav_list_txt_"+ID).hide(500);
                        $("#fav_disc_txt_"+ID).hide(500);
                        $("#fav_sell_txt_"+ID).hide(500);
                        $("#update_fav_"+ID).hide(500);
                    }
                });
                }else{
                    return false;
                }
             }
                          
             function list_change(ID)
             {                
                var list = document.getElementById('fav_list_txt_'+ID).value;
                var discount = document.getElementById('fav_disc_txt_'+ID).value;
                var discount_price = (discount == '') ? '0' : discount;
                var price = (discount * (list / 100));
                var sell_price = (list - price);
                $("#fav_disc_txt_"+ID).val(discount_price);
                $("#fav_sell_txt_"+ID).val(sell_price.toFixed(2));
             }
             
             function disc_change(ID)
             {                
                var list = document.getElementById('fav_list_txt_'+ID).value;
                var discount = document.getElementById('fav_disc_txt_'+ID).value;
                var price = (discount * (list / 100));
                var sell_price = (list - price);
                $("#fav_disc_txt_"+ID).val(discount);
                $("#fav_sell_txt_"+ID).val(sell_price.toFixed(2));
             }
             
             function sell_change(ID)
             {                
                var list = document.getElementById('fav_list_txt_'+ID).value;
                var selling = document.getElementById('fav_sell_txt_'+ID).value;
                var discount = (((list - selling) / list) * 100);
                $("#fav_disc_txt_"+ID).val(discount);
                $("#fav_sell_txt_"+ID).val(selling.toFixed(2));
             }
             
             
            function loadStart() {
            $('#loading').show();
            }

            function loadStop() {
            $('#loading').hide();
            }

             
             $(document).ready(function() {
                
                 $('.list_list').keydown(function(event) {                  
                    if (event.shiftKey == true) {
                        event.preventDefault();
                    }

                    if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 110) {

                    } else {
                        event.preventDefault();
                    }

                    if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190 && event.keyCode == 110)
                        event.preventDefault();
                });

                $('.disc_disc').keydown(function(event) {

                    if (event.shiftKey == true) {
                        event.preventDefault();
                    }

                    if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 110) {

                    } else {
                        event.preventDefault();
                    }

                    if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190 && event.keyCode == 110)
                        event.preventDefault();
                });

                $('.sell_sell').keydown(function(event) {

                    if (event.shiftKey == true) {
                        event.preventDefault();
                    }

                    if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 110) {

                    } else {
                        event.preventDefault();
                    }

                    if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190 && event.keyCode == 110)
                        event.preventDefault();
                });  
                 
              });
         </script>
         
         <style>
             .none{
                 display: none;
             }
         </style>
    </head>

    <body>
        
        <div id="loading" class="none"  style="position: fixed;top: 35%;left: 48%;padding: 5px;z-index: 10;">
         <img src="images/login_loader.gif" border="0" />
        </div>

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
                                            FAVORITES LIST
                                            <span style="float: right;padding-right: 5px;">Welcome <?php if ($_SESSION['admin_user_type'] == '1') {
                                                echo 'admin';
                                            } if ($_SESSION['admin_user_type'] == '2') {
                                                echo 'Staff User';
                                            } ?> |<a href="logout.php" style="text-decoration:none;color:#fff;">&nbsp;Logout</a></span>
                                        </td>
                                    </tr>

                                    <tr><td></td></tr>
                                    <tr>
                                        <td align="right" valign="top">

                                            <form name="new_email" id="new_email" method="post" action="" onsubmit="return validate()" >
                                                <input type="hidden" name="edi_mail" value="1" />       
                                                <input type="hidden" name="page" id="page" value="<?php echo $_GET['page']; ?>" />
                                                <input type="hidden" name="cus_id" id="cus_id" value="<?php echo $_GET['comp_id']; ?>" />
                                                <input type="hidden" name="comp_id_order" id="comp_id_order" value="<?php echo $comp_id; ?>" />
                                                <input type="hidden" name="comp_name" id="comp_name" value="<?php echo getCompName($comp_id); ?>" />
                                                <div style="float: left;width: 100%;"> 
                                                    <div style="float: left;width: 19%;text-align: left;padding-bottom: 10px;padding-top: 10px;padding-left: 10px;"><input type="button" onclick="return back_to_customer();" name="Back" value="BACK" style="background: #FF7E00;color: #FFF;padding: 5px 10px;border-radius: 6px;font-weight: bold;cursor: pointer;border: 0px;" /></div>
                                                    <div style="float: left;width: 38%;text-align: center;padding-bottom: 10px;padding-top: 10px;"><h2><?php echo getCompName($comp_id); ?></h2></div>                                                    
                                                    
                                                    <div style="float: left;width: 19%;padding-bottom: 10px;padding-top: 10px;padding-left: 10px;margin-top: 5px;"><a href="print_fav_screen.php?comp_id=<?php echo $comp_id; ?>" target="_blank" style="text-decoration: none;"><span style="background: #FF7E00;color: #FFF;padding: 5px 10px;border-radius: 6px;font-weight: bold;cursor: pointer;border: 0px;">PRINT</span></a></div>
                                                    <div style="float: left;width: 19%;text-align: right;padding-bottom: 10px;padding-top: 10px;"><input type="submit" name="Delete" value="REMOVE" style="background: #FF7E00;color: #FFF;padding: 5px 10px;border-radius: 6px;font-weight: bold;cursor: pointer;border: 0px;" /></div>
                                                </div>
                                                <div style="float: left;width: 100%;"><div id="msg" style="color:#007F2A; font-size: 13px;text-align: center;"></div></div>
                                                <table align="left" width="100%">
                                                    <tr bgcolor="#ff7e00">
                                                        <td height="28" width="80" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">S.No</td>
                                                        <td height="28" width="375" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">Product Name</td>
                                                        <td height="28" width="85" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">LIST PRICE</td>
                                                        <td height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">DISCOUNT</td>
                                                        <td height="28" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">SELL PRICE</td>
                                                        <td height="28" width="50" align="center" valign="middle" class="td_brdr" bgcolor="#f99b3e">&nbsp;</td>
                                                    </tr>
                                                </table>
                                                <table align="left" width="100%" class="tbl_repeatpro">
                                                    <?php
                                                    $i = 1;
                                                    foreach ($editfav as $fav) {
                                                        $rowColor = ($i % 2 != 0) ? '#ffeee1' : '#fff6f0';
                                                        $id = $fav['id'];
                                                        $product_name       = getProName($fav['product_id']);
                                                        $list_price         = number_format($fav['list_price'], 2, '.', '');
                                                        $discount_price     = number_format($fav['discount_price'], 2, '.', '');
                                                        $sell_price         = number_format($fav['sell_price'], 2, '.', '');
                                                        $super_id           = getsuper($fav['product_id']);
                                                        $cat_id             = getcat($fav['product_id']);
                                                        $sub_id             = getsub($fav['product_id']);
                                                        $super_name         = (getsuperN($super_id) != '') ? getsuperN($super_id) : '';
                                                        $cat_name_pre       = (getcatN($cat_id) != '') ? getcatN($cat_id) : '';
                                                        $cat_name           = ($cat_name_pre != '') ? '>>' . $cat_name_pre : $cat_name_pre;
                                                        $sub_name_pre       = (getsubN($sub_id) != '') ? getsubN($sub_id) : '';
                                                        $sub_name           = ($sub_name_pre != '') ? '>>' . $sub_name_pre : $sub_name_pre;
                                                        ?>
                                                    <tr  bgcolor="<?php echo $rowColor; ?>" id="order_<?php echo $id; ?>">
                                                            <td height="28" width="80" align="center" valign="middle" class="brdr_1" ><?php echo $i; ?></td>
                                                            <td height="28" width="365" valign="middle" class="brdr_1" style="font-size: 15px;padding-left: 10px;">
                                                                <?php echo $product_name . '<br>'; ?>
                                                                <span class="trail" style="font-size: 11px;color: #2a9be3;"><?php echo $super_name . $cat_name . $sub_name; ?></span>  
                                                            </td>
                                                            <td height="28" valign="middle" width="85" class="brdr_1" align="center" onclick="return edit_inline(<?php echo $id; ?>);">
                                                                <span id="fav_list_spn_<?php echo $id; ?>"><?php echo $list_price; ?></span>
                                                                <input class="none list_list" type="text" id="fav_list_txt_<?php echo $id; ?>" style="width: 40px;" value="<?php echo $list_price; ?>" onkeyup="return list_change('<?php echo $id; ?>');" />
                                                            </td>
                                                            <td height="28" valign="middle" width="73" class="brdr_1" align="center" onclick="return edit_inline(<?php echo $id; ?>);">
                                                                <span id="fav_disc_spn_<?php echo $id; ?>"><?php echo $discount_price; ?></span>
                                                                <input class="none disc_disc" type="text" id="fav_disc_txt_<?php echo $id; ?>" style="width: 40px;" value="<?php echo $discount_price; ?>" onkeyup="return disc_change('<?php echo $id; ?>');" />
                                                            </td>
                                                            <td height="28" valign="middle" class="brdr_1" align="center" onclick="return edit_inline(<?php echo $id; ?>);">
                                                                <span id="fav_sell_spn_<?php echo $id; ?>"><?php echo $sell_price; ?></span>
                                                                <input class="none sell_sell" type="text" id="fav_sell_txt_<?php echo $id; ?>" style="width: 40px;" value="<?php echo $sell_price; ?>" onkeyup="return sell_change('<?php echo $id; ?>');" />
                                                            </td>
                                                            <td height="28" width="50" align="center" valign="middle" >
                                                                <input class="check_val" id="delete_chk_<?php echo $id; ?>" type="checkbox" name="delete_val[]" value="<?php echo $id; ?>" />
                                                                <img class="none" style="cursor:pointer;" src="images/like_icon.png" id="update_fav_<?php echo $id; ?>" onclick="update_faverites(<?php echo $id; ?>);"  alt="Delete Faverites" title="Delete Faverites" width="22" height="22" class="mar_lft"/>
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                        $i++;
                                                        } 
                                                        ?>
                                                </table>
                                            </form>



                                        </td>
                                    </tr>

                                </table></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td style="background:#464646; text-align:center; color:#fff; line-height:30px;" height="30p">© <?php echo date('Y'); ?> sohorepro.com</td>
            </tr>
        </table>
    </body>
</html>

<script type="text/javascript">
    function autosubmit()
    {
        var page = document.getElementById("sortOrder").value;
        if (page != 0)
        {
            window.location = "reports.php?limite=" + document.getElementById("sortOrder").value;
        }
    }
</script>                


<script type="text/javascript">
    $(document).ready(function()
    {
        $("#category_name").change(function()
        {
            var pc_id = $(this).val();
            if (pc_id != '0')
            {
                $.ajax
                        ({
                            type: "POST",
                            url: "get_child.php",
                            data: "pc_id=" + pc_id,
                            success: function(option)
                            {
                                $("#subcategory_name").html(option);
                            }
                        });
            }
            else
            {
                $("#subcategory_name").html("<option value=''>-- No subcategory selected --</option>");
            }
            return false;
        });
    });
</script>

<script language="javascript">
    function validate()
    {

        if (document.filter.category_name.value == '0')
        {
            document.getElementById("msg1").innerHTML = "Select category name";
            return false;
        }
        else
        {
            document.getElementById("msg1").innerHTML = "";
        }

        return true;

    }



    $(function() {
        $(".tbl_repeatpro tbody").tableDnD({            
            onDrop: function(table, row) {
                var orders = $.tableDnD.serialize();
                var comp_id = $("#comp_id_order").val();
                $.post('orderfavpro.php', {orders: orders,comp_id: comp_id});
                if (comp_id != '') {
                    //alert('Products order sorting');
                    $("#msg").html('Favorites products order sorted successfully');
                    window.location = "edit_fav.php?comp_id=<?php echo $comp_id; ?>";
                }
            }
        });

    });

function back_to_customer()
{
   var page         = document.getElementById("page").value;
   var cus_id       = document.getElementById("cus_id").value; 
   //var comp_name    = document.getElementById("comp_name").value; 
   window.location = "customers.php?page="+page+"&cus_id="+cus_id+"&cus_add_id="+cus_id; 
}
</script>

<script type="text/javascript" src="js/jquery.autocomplete.js"></script>
<link rel="stylesheet" href="js/jquery.autocomplete.css" type="text/css" />

<script type="text/javascript">


                        function load_userinfo()
                        {
                            var cname = $("#search_val").val();

                            //alert(cname);
                            var request = $.ajax({
                                url: "load_user.php",
                                type: "POST",
                                data: {cid: cname},
                                dataType: "html"
                            });

                            request.done(function(msg) {
                                //alert( msg );
                                if (msg != '')
                                {
                                    $('#load_userdata').html(msg);
                                }
                                else
                                {
                                    $('#load_userdata').html(msg);
                                }
                            });

                            request.fail(function(jqXHR, textStatus) {

                            });

                        }


                        function findValue(li) {
                            if (li == null)
                                return alert("No match!");

                            // if coming from an AJAX call, let's use the CityId as the value
                            if (!!li.extra)
                                var sValue = li.extra[0];

                            // otherwise, let's just display the value in the text box
                            else
                                var sValue = li.selectValue;

                            //alert("The value you selected was: " + sValue);
                        }

                        function selectItem(li) {
                            findValue(li);
                        }

                        function formatItem(row) {
                            return row[0];
                        }

                        function lookupAjax() {
                            var oSuggest = $("#search_val")[0].autocompleter;
                            oSuggest.findValue();
                            return false;
                        }


                        $("#search_val").keypress(function() {

                            var phoneval = $("#search_val").val();
                            //var test=phoneval.indexOf('_');
                            //console.log( test );

//alert(phoneval.length);    
//console.log( phoneval.length );
                            $("#search_val").autocomplete(
                                    "load_user.php",
                                    {
                                        delay: 5,
                                        minChars: 1,
                                        matchSubset: 1,
                                        matchContains: 1,
                                        cacheLength: 10,
                                        onItemSelect: selectItem,
                                        onFindValue: findValue,
                                        formatItem: formatItem,
                                        autoFill: true
                                    }
                            );


                        });


  

</script>                    