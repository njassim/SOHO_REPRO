<!DOCTYPE html>
    <html>
    <head>
    <style>
        .shaddows{
            background: white;
            border-radius: 10px;
            -webkit-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
            -moz-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
            box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
            position: relative;
            z-index: 90;
            margin-bottom: 10px;
        }
        #ribbon_final{
            position: absolute !important;
            left: -5px !important; 
            top: -5px !important;
            z-index: 1 !important;
            overflow: hidden !important;
            width: 75px !important;
            height: 75px !important;
            text-align: right !important;  
        }

        .ribbon {
            position: absolute !important;
            left: -5px !important; 
            top: -5px !important;
            z-index: 1 !important;
            overflow: hidden !important;
            width: 75px !important;
            height: 75px !important;
            text-align: right !important;
        }
        .ribbon span {
            font-size: 10px;
            font-weight: bold;
            color: #FFF;
            text-transform: uppercase;
            text-align: center;
            line-height: 20px;
            transform: rotate(-45deg);
            width: 100px;
            display: block;
            background: #79A70A;
            background: linear-gradient(#BFC5CD 0%, #83878C 100%);
            box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
            position: absolute;
            top: 19px; left: -21px;
        }
        .ribbon span::before {
            content: "";
            position: absolute; left: 0px; top: 100%;
            z-index: -1;
            border-left: 3px solid #83878C;
            border-right: 3px solid transparent;
            border-bottom: 3px solid transparent;
            border-top: 3px solid #83878C;
        }
        .ribbon span::after {
            content: "";
            position: absolute; right: 0px; top: 100%;
            z-index: -1;
            border-left: 3px solid transparent;
            border-right: 3px solid #83878C;
            border-bottom: 3px solid transparent;
            border-top: 3px solid #83878C;
        }
    </style></head><body><div style="border:5px solid #FF7E00;width: 90%;float: left;"><table><tr><td colspan="3" align="left" valign="top" style="padding-top: 30px;padding-left: 10px;"><div style="width: 100%;float: left;font-size: 21px;margin-bottom:5px;">Order Completed : ORDER # 900100241</div><div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Customer Reference  :</span> TEST</div><div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Date  :</span> 10-07-2015 02:08 AM</div><div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Name :</span> Riyas</div><div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Company :</span> 138-142 Reade Street</div><div style="width: 100%;float: left;margin-bottom:7px;"><span style="font-weight:bold;">Email :</span> riyas@gmail.com</div><div style="width: 100%;float: left;margin-bottom:7px;"><span style=
 "font-weight:bold;">Phone :</span>452-369-8712</div><div style="width: 100%;float: left;margin-bottom:5px"><span style="font-weight:bold;">Billing Address :</span></div><div style="width: 100%;float: left;margin-bottom:5px">138-142 Reade Street<br>c/o Knucklnee LLC<br>305 Broadway -- 7th Floor<br>New York,&nbsp;NY&nbsp;10013</div></td></tr><td colspan="3" style="padding-top: 20px;padding-left: 10px;padding-bottom: 10px;"><div style="float: left;margin-top: 12px;margin-bottom: 20px;background-image: url("data:image/jpg;base64,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");background-repeat: no-repeat;"><div style="font-weight: bold;padding-top: 3px;">ORIGINAL ORDER</div><div style="border: 2px #F99B3E solid;width: 95%;float: left;margin-top: 10px;margin-bottom: 10px;" class="shaddows"><div class="details_div"><div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">Customer Details :</div><div style="float: left;width: 33%;margin-left: 30px;">138-142 Reade Street<br>c/o Knucklnee LLC,<br>305 Broadway -- 7th Floor,<br>New York,&nb
 sp;NY&nbsp;10013<br></div><div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">User Details :</div><div style="float: left;width: 33%;margin-left: 30px;">&nbsp;Riyas<br>riyas@gmail.com<br>452-369-8712<br>Date :10-07-2015 02:08 AM</div><div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div><div style="float: left;width: 85%;margin-left: 30px;margin-top: 5px;"><table border="0" style="width: 100%;"><tr bgcolor="#F99B3E"><td style="font-weight: bold;">Option</td><td style="font-weight: bold;">Originals</td><td style="font-weight: bold;">Sets</td><td style="font-weight: bold;">Order Type</td><td style="font-weight: bold;">Size</td><td style="font-weight: bold;">Output</td><td style="font-weight: bold;">Media</td><td style="font-weight: bold;">Binding</td><td style="font-weight: bold;">Folding</td></tr><tr bgcolor="#ffeee1"><td>1</td><td>1</td><td>1</td><td>Plotting on Bond</td><td>FULL</td><
 td>B/W</td><td>Bond</td><td>none</td><td>None</td></tr><tr bgcolor="#ffeee1"><td>2</td><td>1</td><td>2</td><td>Plotting on Bond</td><td>FULL</td><td>B/W</td><td>Bond</td><td>none</td><td>none</td></tr></table></div><div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">Special Instructions: </div><div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;">Test 1</div></div></div></div><div style="font-weight: bold;padding-top: 3px;">RECIPIENT 1</div><div style="border: 2px #F99B3E solid;width: 95%;float: left;margin-bottom: 10px;"><div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;"><div style="float: left;width: 65%;margin-left: 30px;margin-top: 10px;font-weight: bold;">Send to: </div><div style="float: left;width: 33%;margin-left: 30px;">Colan Test Co<br>Attention: Jassim Khan<br>Conatct:  <br>No 52st Street,<br>Cross Lane,<br>Chennai,&nbsp;AL&nbsp;55454</div><div style="float: left;width: 65%;margin-left: 
 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div><div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;"><table border="0" style="width: 100%;"><tr bgcolor="#F99B3E"><td style="font-weight: bold;">Option</td><td style="font-weight: bold;">Sets</td><td style="font-weight: bold;">Order Type</td><td style="font-weight: bold;">Size</td><td style="font-weight: bold;">Output</td><td style="font-weight: bold;">Media</td><td style="font-weight: bold;">Binding</td><td style="font-weight: bold;">Folding</td></tr><tr bgcolor="#ffeee1"><td>1</td><td>1</td><td>Plotting on Bond</td><td>FULL</td><td>B/W</td><td>Bond</td><td>NONE</td><td>NONE</td></tr></table></div><div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;"><span style="font-weight: bold;">When Needed:  </span>ASAP</div><div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;"><span style="font-weight: bold;">Send Via: </span></div><div style="width: 100%;float: left;margin
 -left: 30px;margin-top: 7px;">SOHO TO ARRANGE DELIVERY</div></div></div><div style="font-weight: bold;padding-top: 3px;">RECIPIENT 2</div><div style="border: 2px #F99B3E solid;width: 95%;float: left;margin-bottom: 10px;"><div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;"><div style="float: left;width: 65%;margin-left: 30px;margin-top: 10px;font-weight: bold;">Send to: </div><div style="float: left;width: 33%;margin-left: 30px;">Test Wednesday<br>Attention: Wednesday<br>Conatct:  <br>6-90 Mosque Street
Thirumayam,<br>6-90 Mosque Street
Thirumayam,<br>Pudukkottai- Dist,&nbsp;CT&nbsp;62250</div><div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;font-weight: bold;">PACKING LIST:</div><div style="float: left;width: 65%;margin-left: 30px;margin-top: 5px;"><table border="0" style="width: 100%;"><tr bgcolor="#F99B3E"><td style="font-weight: bold;">Option</td><td style="font-weight: bold;">Sets</td><td style="font-weight: bold;">Order Type</td><td style="font-weight: bold;">Size</td><td style="font-weight: bold;">Output</td><td style="font-weight: bold;">Media</td><td style="font-weight: bold;">Binding</td><td style="font-weight: bold;">Folding</td></tr></table></div><div style="float: left;width: 65%;margin-left: 30px;margin-top: 7px;"><span style="font-weight: bold;">When Needed:  </span>ASAP</div><div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;"><span style="font-weight: bold;">Send Via: </span></div><div style="width: 100%;float: left;margin-left: 30px;margin-top: 7px;">S
 OHO TO ARRANGE DELIVERY</div></div></div></td></tr><tr><td style="padding-left: 10px;"></td></tr></table></div></body></html>