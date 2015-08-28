<?php
include './config.php';
include './auth.php';
$order_id = $_GET['order_id'];
$sets = SetsForOrder($order_id);

//if (isset($_REQUEST['Delete'])) {
//    $cnt = array();
//    $cnt = count($_POST['delete_val']);
//    for ($i = 0; $i < $cnt; $i++) {
//        $id = $_POST['delete_val'][$i];
//        $query = "DELETE FROM sohorepro_favorites WHERE id = '" . $id . "'";
//        $result = mysql_query($query);
//        if ($result) {
//        }
//    }
//}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Sets</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="style/style.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <style>
            .fancybox-inner{ width:288px !important; float:left !important; height:270px !important;}
            .sets{
                list-style: none;                
            }
            .toggle{
                display:none;
            }
        </style>
        <script type="text/javascript">
            function toggle(ID) {
                var slide_up = $("#slide_id").val();
                $("#plotting_details_" + ID).slideToggle();
                if (slide_up != ID) {
                    $("#plotting_details_" + slide_up).slideUp();
                }
                $("#slide_id").val(ID);
            }
        </script>
    </head>
    <body>
        <div style="width:90%;margin: auto;margin-top: 25px;">          
            <table align="center" width="100%">
                <tr align="center" bgcolor="#F99B3E;" style="height: 25px;padding: 5px;font-weight: bold;">
                    <td>Set No</td>
                    <td>Job Option</td>
                    <td>Reference</td>
                </tr>
                <?php
                if (count($sets) > 0) {
                    $i = 1;
                    foreach ($sets as $set) {
                        $rowColor = ($i % 2 != 0) ? '#dfdfdf' : '#eeeeee';
                        $rowColor1 = ($i % 2 != 0) ? '#eeeeee' : '#f6f2f2';
                        $id = $set['id'];
                        $job_option = ($set['plot_arch'] == '1') ? 'Plotting' : 'Architrcture Copies';
                        ?>
                        <tr onclick="return toggle('<?php echo $id; ?>');"  id="<?php echo $id; ?>" align="center" style="height: 25px;padding: 5px;cursor: pointer;">
                            <td bgcolor="<?php echo $rowColor; ?>"><?php echo $i; ?></td>
                            <td bgcolor="<?php echo $rowColor1; ?>"><?php echo $job_option; ?></td>
                            <td bgcolor="<?php echo $rowColor; ?>"><?php echo $set['referece_id']; ?></td>
                        </tr>
                        <input type="hidden" name="slide_id" id="slide_id" value="0" />
                        <tr id="plotting_details_<?php echo $id; ?>" style="display:none;"  align="center">
                            <td colspan="3">
                                <div style="width:98%;border: 2px #F99B3E solid;height:160px;">
                                    <table align="center" width="97%">
                                        <tr>
                                            <td>
                                                <table align="center" width="100%">
                                                    <tr height="30">
                                                        <td style="font-weight: bold;">Originals</td>
                                                        <td><?php echo $set['origininals']; ?></td>
                                                    </tr>
                                                    <tr height="30">
                                                        <td style="font-weight: bold;">Print 0f EA</td>
                                                        <td><?php echo $set['print_ea']; ?></td>
                                                    </tr>
                                                    <tr height="30">
                                                        <td style="font-weight: bold;">Size</td>
                                                        <td><?php echo $set['size']; ?></td>
                                                    </tr>
                                                    <tr height="30">
                                                        <td style="font-weight: bold;">Output</td>
                                                        <td><?php echo $set['output']; ?></td>
                                                    </tr>
                                                    <tr height="30">
                                                        <td style="font-weight: bold;">Media</td>
                                                        <td><?php echo $set['media']; ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table align="center" width="100%">
                                                    <tr height="30">
                                                        <td style="font-weight: bold;">Binding</td>
                                                        <td><?php echo $set['binding']; ?></td>
                                                    </tr>
                                                    <tr height="30">
                                                        <td style="font-weight: bold;">Folding</td>
                                                        <td><?php echo $set['folding']; ?></td>
                                                    </tr>
                                                    <tr height="30">
                                                        <td style="font-weight: bold;">Alternative File Option</td>
                                                        <td><?php echo $set['file_link']; ?></td>
                                                    </tr>
                                                    <tr height="30">
                                                        <td style="font-weight: bold;">Special Instructions</td>
                                                        <td><?php echo $set['spl_instruction']; ?></td>
                                                    </tr>
                                                    <tr height="30">
                                                        <td style="font-weight: bold;">&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table> 
                                </div>                           
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                }
                ?>
            </table>
        </div>
        <?php
//            echo '<pre>';
//            print_r($sets);
//            echo '</pre>';
        ?>
        <script type="text/javascript">
            function toggle(ID) {
                var slide_up = $("#slide_id").val();
                $("#plotting_details_" + ID).slideToggle();
                if (slide_up != ID) {
                    $("#plotting_details_" + slide_up).slideUp();
                }
                $("#slide_id").val(ID);
            }
        </script>
    </body>
</html>

