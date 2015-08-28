<?php
include './config.php';
include './auth.php';
$comp_id    = $_GET['comp_id'];
$user_id    = $_GET['user_id'];
$acc_id     = $_GET['acc_id'];
$sele_usr = SupplyUsrContShopp($comp_id,$user_id);
$select_company = companyName($comp_id);
//echo '<pre>';
//print_r($sele_usr);
?>
<style>

   /* Supply Login */
.shipp_window{
    width: 265px;   
    padding: 0px 20px;
    float:left;     
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
    <div id="cus_details">
                <h1>Edit Customer</h1>                
                <span id="succ_msg" style="color:#007F2A;font-size: 12px;"></span>
                <span id="alert_msg" style="color:#FF0000;font-size: 12px;"></span>
                <input type="hidden" id="order_id" name="order_id" value="<?php echo $acc_id; ?>" />
                <ul>
                    <li><label>Select Customer</label>
                        <!--<input type="text" class="text_auto" name="customer_auto" id="customer_auto" />-->
                        <input type="text" class="text_shipp" value="<?php echo $select_company; ?>" id="customer_auto" onkeyup="lookup(this.value);" />
                        <div class="suggestionsBox" id="suggestions" style="cursor: pointer;float: right;width: 236px;position: absolute;background-color: #F1F1F1;border: 1px solid #C3C3C3;top: 112px;left: 29px;padding: 10px;height: 100px;overflow-y: scroll;display: none; padding-top: 0px;">                        
                        <div class="suggestionList" id="autoSuggestionsList">
                        &nbsp;
                        </div>
                        </div>
                    </li>
                    <li><label>Select User</label>
                        <?php if($sele_usr != ''){?>                            
                        <select name="user_details" id="user_details" class="select_text" onchange="return user_select();" /> 
                        <?php foreach ($sele_usr as $usr){
                          if($usr['cus_id'] == $user_id){  
                        ?>                        
                        <option value="<?php echo $usr['cus_id']; ?>" selected="selected"><?php echo $usr['cus_contact_name']; ?></option>    
                        <?php }else{ ?>
                        <option value="<?php echo $usr['cus_id']; ?>"><?php echo $usr['cus_contact_name']; ?></option>                            
                        <?php }} ?>
                        <option value="N">New User</option>
                        </select>
                        <?php                       
                        }else{
                        ?>                        
                        <select name="user_details" id="user_details" class="select_text" /> 
                        <option value="0">Select User</option>
                        </select>
                        <?php } ?>
                    </li>                    
                    <li><input type="submit" value="UPDATE" onclick="return update_customer();" /></li>                     
                </ul>
            </div>
    
            <div id="new_user" style="display: none;">
                <h1>Add New User</h1>                
                <span id="succ_msg_new" style="color:#007F2A;font-size: 12px;"></span>
                <span id="alert_msg_new" style="color:#FF0000;font-size: 12px;"></span>
                <input type="hidden" id="order_id" name="order_id" value="<?php echo $acc_id; ?>" />
                <ul>
                    <li><label>Name</label>
                        <input type="text" class="text_shipp" value="" id="user_name" name="user_name"  />
                    </li>
                    <li><label>Email</label>
                        <input type="text" class="text_shipp" value="" id="email" name="email" />
                    </li>                    
                    <li><input type="submit" value="SAVE" onclick="return save_user();" /></li>                     
                </ul>
            </div>
         </div>


<script>  

function lookup(inputString) {
    if(inputString.length == 0) {
    // Hide the suggestion box.
    $('#suggestions').hide();
    } 
    else 
    {
        $.post("rcp.php", {queryString: ""+inputString+""}, function(data){
        if(data.length >0) {
        $('#suggestions').show();
        $('#autoSuggestionsList').html(data);
        }
        });
    }
} // lookup

function fill(thisValue) {
$('#customer_auto').val(thisValue);
if (thisValue != '')
            {
                $.ajax
                        ({
                            type: "POST",
                            url: "get_child.php",
                            data: "customer_id_select=" + thisValue,
                            success: function(option)
                            {
                                $("#user_details").html(option);  
                                setTimeout("$('#suggestions').hide();", 200);
                            }
                        });
            }
            else
            {
                $("#user_details").html("<option value='0'>Select User</option>");                 
            }
}

function update_customer()
{
    var customer    = document.getElementById("customer_auto").value;  
    var user        = document.getElementById("user_details").value;  
    var order_id    = document.getElementById("order_id").value; 
    
    if ((customer != '') && (user != ''))
            {
                $.ajax
                        ({
                            type: "POST",
                            url: "get_child.php",
                            data: "customer_id_edit=" + customer+
                                  "&user_id_edit="+user+
                                  "&order_id_edit="+order_id,
                            success: function(option)
                            {
                                if(option == true){
                                $("#succ_msg").html("Customer has been changed successfully");  
                                window.top.location="open_orders.php?ord_id="+order_id;
                                }
                            }
                        });
            }
            else
            {
                $("#alert_msg").html("Select any customer");                 
            }
}

function user_select()
{    
    var user_details      = $("#user_details").val();
    if(user_details == 'N'){
        $("#cus_details").css('display','none');
        $("#new_user").css('display','inline-block');
    }
    
}

function save_user()
{
    var name        = document.getElementById("user_name").value;  
    var email       = document.getElementById("email").value;  
    var order_id    = document.getElementById("order_id").value; 
    var customer    = document.getElementById("customer_auto").value;  
    if(name == ''){
        $("#alert_msg_new").html("Enter the user name.");
         document.getElementById("user_name").focus();  
        return false;
    }
    if(email == ''){
        $("#alert_msg_new").html("Enter the email.");
         document.getElementById("email").focus();  
        return false;
    }
    if(customer != '')
            {
                        $.ajax
                                ({
                                    type: "POST",
                                    url: "get_child.php",
                                    data: "new_user_cash=" + customer+
                                          "&new_user_cash_name="+name+
                                          "&new_user_cash_email="+email+
                                          "&order_id_edit="+order_id,
                                    success: function(option)
                                    {
                                        if(option == '1'){
                                        $("#succ_msg_new").html("New user added successfully");  
                                        window.top.location="open_orders.php?ord_id="+order_id;
                                        }
                                    }
                                });
                    }
    
}


//function go_back()
//{
//    $("#cus_details").css('display','inline-block');
//    $("#new_user").css('display','none');
//}
</script>