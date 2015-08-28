<!DOCTYPE html>
<?php
include './config.php';
include './auth.php';

$company_id = $_GET['comp_id'];

$company_name = getCompName($company_id);
$customer_info = getCustomeInfo($company_id);
?>
<html>
    <head>
        <!--<link rel="stylesheet" type="text/css" href="style/fav_report.css">-->
        <title>Customer Favorites Report</title>
        <script>
            function print_special() {
                var ays = confirm('Are you sure?');
                if (ays == true) {
                    window.print();
                    return true;
                } else {
                    return false;
                }
            }
        </script>
        <style>
            body {
/*                background: #EEEEEE;*/
            }
            .paper{
                height: 842px;
                width: 595px;
                margin-left: auto;
                margin-right: auto;
                border: 0px solid #000;
                background: #FFF;
            }
            .address{
                width: 35%;
                float: left;
                height: 100px;
                height: 100px;
                margin-top: 5px;
            }
            .address span{
                width: 100%; 
                float: left;
            }
            .address span:nth-child(1){
                font-weight: bold;

            }
            .paper_content{
                width: 99.5%;
                float: left;
                /*border: 1px solid #000;*/
                height: 20px;
                margin-top: 10px;
                font-weight: bold;
            }
        </style>
    </head>  
    <body onload="return print_special();">
        <div class="paper">            	
            <div style="width: 99.5%;float: left;border: 1px solid #000;height: 100px;">
                <div style="width: 30%;float: left;height: 100px;">
                    <img src="images/logo.jpg" style="width: 100%;height: 100px;" />
                </div>
                <div style="width: 35%;float: left;height: 100px;padding: 10px;box-sizing: border-box;">
                    <h3><?php echo $customer_info[0]['comp_name']; ?></h3>
                </div>
                <div class="address">
                    <span>Business Info:</span>
                    <span><?php echo $customer_info[0]['comp_business_address1']; ?></span>
                    <span><?php echo $customer_info[0]['comp_business_address2']; ?></span>
                    <span><?php echo $customer_info[0]['comp_city'] . ',&nbsp;' . $customer_info[0]['comp_state'] . '&nbsp;' . $customer_info[0]['comp_zipcode']; ?></span>
                    <span>Phone No : <?php echo $customer_info[0]['comp_contact_phone']; ?></span>
                </div>
            </div>

            <div class="paper_content">
                <div style="width:7%;float: left;">S.No</div>
                <div style="width:12%;float: left;">Super</div>
                <div style="width:12%;float: left;">Category</div>
                <div style="width:12%;float: left;">Sub Cate</div>
                <div style="width:19%;float: left;">Product Name</div>
                <div style="width:12%;float: left;">List Price</div>
                <div style="width:10%;float: left;">%</div>
                <div style="width:15%;float: left;">Selling Price</div>
            </div>
            <?php
            $favorites = ALLFAV($company_id);
            if (count($favorites) > 0) {
                $k = 1;
                foreach ($favorites as $Special_Product) {
                    $super_id = getsuper($Special_Product['product_id']);
                    $cat_id = getcat($Special_Product['product_id']);
                    $sub_id = getsub($Special_Product['product_id']);
                    $super_name = (getsuperN($super_id) == '') ? '--' : getsuperN($super_id);
                    $cat_name = (getcatN($cat_id) == '') ? '--' : getcatN($cat_id);
                    $sub_name = (getsubN($sub_id) == '') ? '--' : getsubN($sub_id);
                    $special_id = $Special_Product['sp_id'];
                    $product_name = (getorderProd($Special_Product['product_id']) == '') ? '--' : getorderProd($Special_Product['product_id']);
                    $list_price = $Special_Product['list_price'];
                    $discount_price = $Special_Product['discount_price'];
                    $sell_price = $Special_Product['sell_price'];
                    ?>
                    <div style="width: 99.5%;float: left;margin-bottom: 5px;">
                        <div style="width:7%;float: left;"><?php echo $k; ?></div>
                        <div style="width:12%;float: left;"><?php echo $super_name; ?></div>
                        <div style="width:12%;float: left;"><?php echo $cat_name; ?></div>
                        <div style="width:12%;float: left;"><?php echo $sub_name; ?></div>
                        <div style="width:19%;float: left;"><?php echo $product_name; ?></div>
                        <div style="width:12%;float: left;"><?php echo $list_price; ?></div>
                        <div style="width:10%;float: left;"><?php echo $discount_price; ?></div>
                        <div style="width:15%;float: left;"><?php echo $sell_price; ?></div>
                    </div>
                    <?php
                    $k++;
                }
            }
            ?>
        </div>        
    </body>
</html>