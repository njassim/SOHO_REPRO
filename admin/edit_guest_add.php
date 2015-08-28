<?php
include './config.php';
include './auth.php';
$id         = $_GET['comp_id'];
$acc_id     = $_GET['acc_id'];
$state_all = StateAll();
$address  = ShippingAddressAllForGuest($id);
//echo '<pre>';
//print_r($address);
//echo '</pre>';

?>
<style>
   /* Supply Login */
.shipp_window{
    width: 260px;   
    padding: 0px 20px;
    float:left; 
    border-right: 2px dotted #999;
}

.shipp_window ul{
    float: left;
    width: 100%;    
    color:#5f5f5f; font-size: 16px; 
    padding: 0px;
}
.shipp_window h1{
    font-size: 18px;
    float: left;
    width: 100%;
    margin: 0px;
}
.shipp_window ul li { list-style: none; float: left;
    width: 100%; margin-top: 10px;  }
.shipp_window ul li label{ color:#5f5f5f; font-size: 16px; float: left; line-height: 30px;
    width: 100%;}

.shipp_window ul li input[type="submit"]{
  background: #a1a1a1; 
  color: #fff;
  padding: 7px 15px;
  float: right;
  text-align: center;
  cursor: pointer;
  -webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;

}
.shipp_window ul li input[type="submit"]:hover{
  background:#ff7e00;   
}

.shipp_window ul li select {
background: #fff;
float: left;
width: 98%;
height: 28px;
border: 1px solid #aeaeae;
-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
}

.shipp_window ul li textarea {
background: #fff;
float: left;
width: 98%;
height: 28px;
border: 1px solid #aeaeae;
-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
}

.text_shipp {
background: #fff;
float: left;
width: 98%;
height: 28px;
border: 1px solid #aeaeae;
-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
}
.shipp_window input[type="submit"]{
  background: #a1a1a1; 
  color: #fff;
  padding: 7px 25px;
  float: left;
  text-align: center;
  cursor: pointer;
  -webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
}
.shipp_window input[type="submit"]:hover{
  background:#ff7e00;   
}

.shipp_window h1{
    font-size: 18px;
    float: left;
    width: 100%;
}
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<div class="shipp_window">
                
            <!--your content start-->
                <h1>Enter the Shipping Address</h1>
                <span id="alert_msg" style="color:#FF0000;font-size: 12px;"></span>
                <input type="hidden" value="<?php echo $id; ?>" name="comp_ID" id="comp_ID" />
                <input type="hidden" value="<?php echo $acc_id; ?>" name="acc_id" id="acc_id" />
                <ul style="margin-top: 45px;">
                    <li><label>Address 1</label>
                        <textarea class="select_text" name="add1" id="add1"><?php echo $address[0]['address_1']; ?></textarea>
                        </li> 
                    <li><label>Address 2</label>
                        <textarea class="select_text" name="add2" id="add2"><?php echo $address[0]['address_2']; ?></textarea>
                        </li>                    
                    <li><label>City</label>
                        <input type="text" class="text_shipp" name="city" id="city" value="<?php echo $address[0]['city']; ?>" />
                        </li>
                    <li><label>State</label>
                        <select name="state" id="state" class="select_text">
                    <option value="0">Select state</option>
               <?php foreach ($state_all as $state) { ?>
                        <?php if($state['state_id'] == '33'){ ?>
                    <option value="<?php echo $state['state_id'] ?>" selected="selected"><?php echo $state['state_abbr']; ?></option>
                        <?php } else{ ?>
                        <option value="<?php echo $state['state_id'] ?>"><?php echo $state['state_abbr']; ?></option>
               <?php } } ?>
               </select>
                        </li>
                    <li><label>Zip</label>
                        <input type="text" class="text_shipp" name="zip" id="zip" value="<?php echo $address[0]['zip']; ?>" />
                        </li>                   
                </ul>
                </div>
            
            
                <div class="shipp_window" style="border-right: 0px;">
                
            <!--your content start-->
                <h1>Enter the Billing Address</h1>
                <span id="alert_msg" style="color:#FF0000;font-size: 12px;"></span>
                <ul>
                    <li><input type="checkbox" name="shipp_check" id="shipp_check" onchange="return clone();"/>&nbsp;Same as Shipping</li>
                    <li><label>Address 1</label>
                        <textarea class="select_text" name="bill_add1" id="bill_add1"></textarea>
                        </li> 
                    <li><label>Address 2</label>
                        <textarea class="select_text" name="bill_add2" id="bill_add2"></textarea>
                        </li>                    
                    <li><label>City</label>
                        <input type="text" class="text_shipp" name="bill_city" id="bill_city" />
                        </li>
                    <li><label>State</label>
                        <select name="bill_state" id="bill_state" class="select_text">
                    <option value="0">Select state</option>
               <?php foreach ($state_all as $state) { ?>                        
                        <option value="<?php echo $state['state_id'] ?>"><?php echo $state['state_abbr']; ?></option>
               <?php }  ?>
               </select>
                        </li>
                    <li><label>Zip</label>
                        <input type="text" class="text_shipp" name="bill_zip" id="bill_zip" />
                        </li>
                    <li><input type="submit" style="margin-top: 5px;" value="SAVE" onclick="return update_shipping_add();" /></li>                     
                </ul>
                </div>


<script>
    function clone()
{
var x = document.getElementById("shipp_check").checked;
var add1 = document.getElementById("add1").value;
var add2 = document.getElementById("add2").value;
var city = document.getElementById("city").value;
var state = document.getElementById("state");
var bill_state = document.getElementById("bill_state");
var shipp_state_val = state.options[state.selectedIndex].value;
var shipp_state_txt = state.options[state.selectedIndex].text;
var zip = document.getElementById("zip").value;
if(x == true)
    {
        document.getElementById("bill_add1").innerHTML = add1;
        document.getElementById("bill_add2").innerHTML = add2;
        document.getElementById("bill_city").value = city;
        bill_state.options[bill_state.selectedIndex].value = shipp_state_val;
        bill_state.options[bill_state.selectedIndex].text = shipp_state_txt;
        document.getElementById("bill_zip").value = zip;        
    }
    else{
        document.getElementById("bill_add1").innerHTML = '';
        document.getElementById("bill_add2").innerHTML = '';
        document.getElementById("bill_city").value = '';
        document.getElementById("bill_state").innerHTML = '';
        document.getElementById("bill_zip").value = '';  
    }

}


function update_shipping_add()
    {           
        var add1        = document.getElementById("add1").value;
        var add2        = document.getElementById("add2").value;
        var city        = document.getElementById("city").value;
        var state       = document.getElementById("state").value;
        var zip         = document.getElementById("zip").value;
        var comp_ID     = document.getElementById("comp_ID").value;
        var acc_id      = document.getElementById("acc_id").value;
        if(comp_ID != '')  
            {                
             $.ajax
             ({
                type: "POST",
                    url: "get_child.php",
                    data: "admin_add1="+add1+
                          "&add2="+add2+
                          "&city="+city+
                          "&state="+state+
                          "&zip="+zip+
                          "&comp_ID="+comp_ID,
                    success: function(option)
                    {
                      if(option == true){ 
                           window.top.location="open_orders.php?ord_id="+acc_id;
                      }
                    }
             });
            }
            
    }

</script>