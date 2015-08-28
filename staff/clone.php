<html>
    <head>
        <title>
            
        </title>
    </head>
    <body>
<ul>
<li><label>Address 1</label>
    <textarea class="select_text" name="add1" id="add1"></textarea>
    </li> 
<li><label>Address 2</label>
    <textarea class="select_text" name="add2" id="add2"></textarea>
    </li>                    
<li><label>City</label>
    <input type="text" class="text_shipp" name="city" id="city" />
    </li>
<li><label>State</label>
    <input type="text" class="text_shipp" name="state" id="state" />
    </li>
<li><label>Zip</label>
    <input type="text" class="text_shipp" name="zip" id="zip" />
    </li>
<li><input type="submit" value="SKIP" onclick="return goto_test_checkout();" /></li> 
<li><input type="checkbox" name="shipp_check" id="shipp_check" onchange="return myFunction();"/></li>
</ul>
   <ul>
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
    <input type="text" class="text_shipp" name="bill_state" id="bill_state" />
    </li>
<li><label>Zip</label>
    <input type="text" class="text_shipp" name="bill_zip" id="bill_zip" />
    </li>
<li><input type="submit" value="SKIP" onclick="return goto_test_checkout();" /></li>                     
</ul>     
  <script>
function myFunction()
{
var x = document.getElementById("shipp_check").checked;
var add1 = document.getElementById("add1").value;
var add2 = document.getElementById("add2").value;
var city = document.getElementById("city").value;
var state = document.getElementById("state").value;
var zip = document.getElementById("zip").value;
if(x == true)
    {
        document.getElementById("bill_add1").innerHTML = add1;
        document.getElementById("bill_add2").innerHTML = add2;
        document.getElementById("bill_city").value = city;
        document.getElementById("bill_state").value = state;
        document.getElementById("bill_zip").value = zip;        
    }
    else{
        document.getElementById("bill_add1").innerHTML = '';
        document.getElementById("bill_add2").innerHTML = '';
        document.getElementById("bill_city").value = '';
        document.getElementById("bill_state").value = '';
        document.getElementById("bill_zip").value = '';  
    }

}
</script>      
        </body>
</html>
