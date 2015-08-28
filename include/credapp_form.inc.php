<?php
/*
 * (c) 2009 Gigantic, Inc., All Rights Reserved
 * $Id: credapp_form.inc.php,v 1.5 2009-11-08 07:27:57 tredman Exp $
 */

require_once("include/credapp_fields.inc.php");

?>
<script type="text/javascript">
function sepBilling()
{
	var i = 0;
	var flds = new Array("address", "city", "state", "zip", "phone", "fax");
	if (document.getElementById("ca-sep-billing").checked) {
		for (i = 0; i < flds.length; i++) {
			document.getElementById("ca-company-b"+flds[i]).parentNode.parentNode.style.display = "";
			//document.getElementById("ca-company-b"+flds[i]).style.display = "inline";
		}
	} else {
		for (i = 0; i < flds.length; i++) {
			document.getElementById("ca-company-b"+flds[i]).parentNode.parentNode.style.display = "none";
			//document.getElementById("ca-company-b"+flds[i]).style.display = "none";
		}
	}
}
function validateCreditApp()
{
	var i = 0, alarm = false;
	var e = document.getElementsByTagName("INPUT");
	for (i = 0; i < e.length; i++) {
		if (e[i].className == "ca-required" && e[i].value == "") alarm = true;
	}
	if (alarm) {
		alert("Some required fields were left blank.  Please fill in and re-submit form.");
		return false;
	}
	return true;
}
</script>
<h1>Credit Application</h1>
<p class="bodyWhite">If you would prefer to fill out the application offline, you can download
the <a href="creditapplication.pdf" target="_blank">PDF version here</a>.</p><hr>
<form name="credit_app" method="POST" action="credapp_process.php" onsubmit="return validateCreditApp()">
<table id="ca-table" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<TD style="height:10px;width:10px"><img src="store_images/nw.jpg" height="10" width="10"></TD>
		<TD style="height:10px"><img src="images/spacer.gif"></TD>
		<TD style="height:10px;width:10px"><img src="store_images/ne.jpg" height="10" width="10"></TD>
	</tr>
	<tr>
		<td style="width:10px"><img src="images/spacer.gif"></td>
		<td class="ca-normal">
			<b>Legend:</b>&nbsp;&nbsp;
			<img class="color-swatch" style="background-color:#A7BCD1" src="images/spacer.gif"> Optional&nbsp;&nbsp;
			<img class="color-swatch" style="background-color:#D1A7BC" src="images/spacer.gif"> Required
		</td>
		<td style="width:10px"><img src="images/spacer.gif"></td>
	</tr>
	<tr>
		<td style="width:10px"><img src="images/spacer.gif"></td>
		<td>
			<table border="0" cellpadding="3" cellspacing="0" width="100%">
<?php
foreach ($field_list as $fl) {
	printf("<tr>");
	foreach ($fl as $td) {
		switch ($td[TYPE]) {
			case "heading" :
				printf("<td colspan=\"8\">&nbsp;</td></tr><tr>");
				printf("<td class=\"ca-heading\" colspan=\"%d\"><br>%s</td>", $td[COLSPAN], $td[LABEL]);
				break;
			case "subheading" :
				printf("<td class=\"ca-subheading\" colspan=\"%d\">%s</td>", $td[COLSPAN], $td[LABEL]);
				break;
			case "hr" :
				printf("<td colspan=\"8\"><hr></td></tr><tr>");
				//print "<hr>";
				break;	
			case "checkbox" :
			case "radio" :
				printf("<td class=\"ca-normal\" colspan=\"%d\"><input type=\"%s\" id=\"ca-%s\" name=\"ca-%s\" value=\"%s\" class=\"ca-%s\" onclick=\"%s\">&nbsp;%s</td>", $td[COLSPAN], $td[TYPE], $td[NAME], $td[NAME], $td[VALUE], $td[REQD] ? "required" : "optional", $td[ONCHG], $td[LABEL]);
				break;
			default :
				printf("<td class=\"ca-normal\" colspan=\"%d\">%s<br><input type=\"%s\" id=\"ca-%s\" name=\"ca-%s\" value=\"%s\" class=\"ca-%s\"></td>", $td[COLSPAN], $td[LABEL], $td[TYPE], $td[NAME], $td[NAME], $td[VALUE], $td[REQD] ? "required" : "optional");
		}
	}
	printf("</tr>");
}
?>
				<tr>
					<td width="12%">&nbsp;</td>
					<td width="13%">&nbsp;</td>
					<td width="12%">&nbsp;</td>
					<td width="13%">&nbsp;</td>
					<td width="12%">&nbsp;</td>
					<td width="13%">&nbsp;</td>
					<td width="12%">&nbsp;</td>
					<td width="13%">&nbsp;</td>
				</tr>
			</table>
			<p class="bodyBlack" style="text-align:justify">Please fill out application completely to expedite processing.</p>
			<p class="bodyBlack">&nbsp;</p>
			<p class="bodyBlack" style="text-align:justify">Terms: Net 15 Days</p>
			<p class="bodyBlack">&nbsp;</p>
			<hr>
			<p class="bodyBlack" style="text-align:justify">
				SOHO REPROGRAPHICS IS NOT RESPONSIBLE FOR DIRECT COSTS AND DAMAGES INCURRED BY ITS CUSTOMERS
				AS A RESULT OF LOST OR DAMAGED ORIGINALS WHETHER IN TRANSIT OR IN SOHO REPROGRAPHICS FACILITIES.
				SUBMISSION OF JOBS BY CUSTOMER CONSTITUTES ACCEPTANCE OF THE TERMS AND CONDITIONS SET FORTH BY
				SOHO REPROGRAPHICS. ALL CHARGES ARE DUE WITHIN TERMS. FINANCE CHARGES OF 2% PER MONTH MAY BE
				IMPOSED AT THE DISCRETION OF SOHO REPROGRAPHICS ON BALANCES OWED BEYOND THE TERMS OF SALE. IN
				THE EVENT OF NON-PAYMENT, CUSTOMER AGREES TO PAY ALL REASONABLE ATTORNEY FEES AND COSTS OF
				COLLECTION.
			</p>
			<hr>
			<table border="0" cellpadding="3" cellspacing="0" width="100%">
				<tr>
					<td class="ca-normal">Submitted By<br><input type="text" id="ca-submitted-by" name="ca-submitted-by" value="" class="ca-required"></td>
				</tr>
			</table>
			<p class="bodyBlack">&nbsp;</p>
			<input type="submit" value="SEND">&nbsp;<input type="reset" value="RESET">
		</td>
		<td style="width:10px"><img src="images/spacer.gif"></td>
	</tr>
	<tr>
		<TD style="height:10px;width:10px"><img src="store_images/sw.jpg" height="10" width="10"></TD>
		<TD style="height:10px"><img src="images/spacer.gif"></TD>
		<TD style="height:10px;width:10px"><img src="store_images/se.jpg" height="10" width="10"></TD>
	</tr>
  </table>
</form>
<script type="text/javascript">
var i = 0;
var flds = new Array("address", "city", "state", "zip", "phone", "fax");
for (i = 0; i < flds.length; i++) {
	document.getElementById("ca-company-b"+flds[i]).parentNode.parentNode.style.display = "none";
	//document.getElementById("ca-company-b"+flds[i]).style.display = "none";
}
</script>
