<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: order_form.inc.php,v 1.16 2009-11-08 07:27:57 tredman Exp $
 */

function show_select_option($name, $val, $txt, $padding, $default)
{
	printf("<span style=\"padding-right:%dpx\">", $padding);
	if ($_REQUEST[$name] == $val) {
		$selected = "selected";
	} else {
		if ($default == $val && $_REQUEST[$name] == "") {
			$selected = "selected";
		} else {
			$selected = "";
		}
	}
	printf("<option value=\"%s\" %s>%s</option>", $val, $seleced, $txt);
	printf("</span><br>");
}

function show_select_element($name, $arr, $txt, $padding, $default)
{
	printf("\n<select name=\"%s\" id=\"%s\">\n", $name, $name);
	$last_group = "";
	$group_flag = false;
	foreach ($arr->items as $a) {
		if (($default == $a->target->code && $_REQUEST[$name] == "") || $_REQUEST[$name] == $a->target->code) {
			$selected = "selected";
		} else {
			$selected = "";
		}
		list($group, $item) = explode("|", $a->target->descr);
		if ($item == "") {
			$item = $group;
			$group = "";
		}
		if ($last_group != $group && $last_group != "") {
			if ($group_flag) {
				printf("\t</optgroup>\n");
				$group_flag = false;
			}
		}
		if ($last_group != $group && $group != "") {
			printf("\t<optgroup label=\"%s\">\n", $group);
			$group_flag = true;
		}
		printf("\t\t<option label=\"%s\" %s>%s</option>\n", $a->target->code, $selected, $item);
		$last_group = $group;
	}
	if ($group_flag) printf("\t</optgroup>\n");
	printf("</select>\n");
}

function show_radio_option($name, $val, $txt, $padding, $default)
{
	printf("<span style=\"padding-right:%dpx\">", $padding);
	if ($_REQUEST[$name] == $val) {
		$checked = "checked";
	} else {
		if ($default == $val && $_REQUEST[$name] == "") {
			$checked = "checked";
		} else {
			$checked = "";
		}
	}
	printf("<input name=\"%s\" type=\"radio\"  value=\"%s\" %s>&nbsp;&nbsp;%s", $name, $val, $checked, $txt);
	
	//need to add an input field for scanning format fields
	if ($name=='format' && ($val=='DWG' || $val =='PLT'))
	{
		printf("&nbsp;<input name='%s_cad_ver' type='text' value='' class='style4' size=4 >", $val);
	}
	
	printf("</span><br>");
}

function show_check_option($name, $val, $txt, $padding, $default = array())
{
	printf("<span style=\"padding-right:%dpx\">", $padding);
	if ($_REQUEST[$name] == $val || in_array($val, $default)) {
		$checked = "checked";
	} else {
		$checked = "";
	}
	printf("<input name=\"%s[]\" type=\"checkbox\"  value=\"%s\" %s onchange=\"check_for_none(this)\">&nbsp;&nbsp;%s", $name, $val, $checked, $txt);
	printf("</span><br>");
}

function show_order_block($service_table, $service_text, $yesno, $multiple = false, $default = "")
{
	$assocs = new Associations();
	$assocs->load_by_service_and_table($_REQUEST["svc"], $service_table);
	if (count($assocs->items) > 0 || $yesno) 
	{
		if ($service_table == "binding") show_order_block("collate", "Finishing - Collate Options", true, false, "Y");
		printf("<tr><td class=\"order_heading\">%s</td></tr>", $service_text);
		printf("<tr><td class=\"order_detail\" valign=\"middle\">");
		/*if ($service_table == "paper_color") 
		{
			show_select_element($service_table, $assocs, $service_text, 10, $default);
		} 
		else*/if ($yesno) 
		{
			show_radio_option($service_table, "Y", "YES", 10, $default);
			show_radio_option($service_table, "N", "NO", 10, $default);
		} 
		else 
		{
			$other = false;
			foreach ($assocs->items as $a) 
			{
				if ($a->target->code == "O") {
					$other = true;
				} 
				elseif ($a->target->code == "N" && $service_table != "mounting" && $service_table != "laminate") //added mounting to the check because none should be at the top of the list 
				{
					$none = true;
				} 
				else {
					if ($multiple) {
						show_check_option($a->table_name, $a->target->code, $a->target->descr, 15, $default);
					} else {
						show_radio_option($a->table_name, $a->target->code, $a->target->descr, 15, $default);
					}
				}
			}
			
			if ($other) {
				if ($multiple) {
					show_check_option($service_table, "O", "OTHER", 15, $default);
				} else {
					show_radio_option($service_table, "O", "OTHER", 15, $default);
				}
				printf("<input name=\"%sOther\" type=\"text\" class=\"style4\" id=\"%sOther\" value=\"%s\" size=\"50\" maxlength=\"30\" onfocus=\"clearText(this)\"><br>",
					$service_table,
					$service_table,
					$_REQUEST[$service_table . "Other"] == "" ? "OTHER" : $_REQUEST[$service_table . "Other"]);
			}
			if ($none) {
				if ($multiple) {
					show_check_option($service_table, "N", "NONE", 15, $default);
				} else {
					show_radio_option($service_table, "N", "NONE", 15, $default);
				}
			}
		}
		printf("</td></tr>");
	}
}

function show_dupe_block($dupes = array())
{
	$assocs = new Associations();
	$delopts = new Associations();
	$assocs->load_by_service_and_table($_REQUEST["svc"], "size");
	$delopts->load_by_service_and_table($_REQUEST["svc"], "delivery");
	if (count($assocs->items) > 0 && count($delopts->items)) {
		printf("<tr><td class=\"order_heading\">Duplicating Options</td></tr>");
		printf("<tr><td class=\"order_detail\">");
		printf("<table id=\"dupe_table\" width=\"100%%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">");
		printf("<thead>");
		printf("<tr>");
		printf("<td align=\"center\" class=\"style20\">ADD ORIGINALS</td>");
		printf("<td align=\"center\" class=\"style20\">FILE/SUBMISSION</td>");
// 		printf("<td align=\"center\" class=\"style20\">ORIGINALS</td>");
		printf("<td align=\"center\" class=\"style20\">PRINTS OF EACH</td>");
		printf("<td align=\"center\" class=\"style20\">SIZES</td>");
		printf("<td align=\"center\" class=\"style20\">ADD SETS</td>");
		printf("</tr>");
		printf("</thead>");
		printf("<tbody>");
		if (count($dupes) > 0) {
			$first = true;
			foreach ($dupes as $k => $v) {
				printf("<tr>");
				if ($v["delivery"] == "X") {
					printf("<td align=\"center\">");
					printf("<input type=\"button\" value=\"+\" onclick=\"repl_dupe_line()\">&nbsp;");
					printf("<input type=\"button\" value=\"-\" onclick=\"rem_dupe_line(this)\" %s>", $first ? "disabled" : "");
					printf("</td>");
					printf("<td align=\"center\">");
					printf("<input type=\"hidden\" name=\"delivery[]\" id=\"delivery%d\" value=\"X\">", $k);
					printf("<p id=\"filewrap%d\"><input type=\"hidden\" name=\"delfile[]\" id=\"delfile%d\" value=\" \"></p>", $k, $k);
					printf("</td>");
					printf("<td align=\"center\">");
					printf("<input name=\"originals[]\" type=\"text\" class=\"style4\" id=\"originals%d\" value=\"1\" size=\"5\" maxlength=\"5\">", $k);
					printf("<input name=\"duplicates[]\" type=\"text\" class=\"style4\" id=\"duplicates%d\" value=\"%s\" size=\"5\" maxlength=\"5\" onFocus=\"clearText(this)\">",
						$k,
						$v["duplicates"]);
					printf("</td>");
					printf("<td align=\"center\">");
					printf("<select name=\"sizes[]\" class=\"style4\" id=\"sizes%d\">", $k);
					foreach ($assocs->items as $a) {
						printf("<option value=\"%s\" %s>%s</option>",
							$a->target->code,
							($v["sizes"] == $a->target->code ? "selected" : ""),
							$a->target->descr);
					}
					printf("</select>");
					printf("</td>");
					printf("<td align=\"center\">");
					printf("<input type=\"button\" value=\"+\" onclick=\"repl_dupe_detail(this.parentNode.parentNode)\">&nbsp;");
					printf("<input type=\"button\" value=\"-\" onclick=\"rem_dupe_detail(this)\" %s>", $first ? "disabled" : "");
					printf("</td>");
					printf("</tr>");
				} else {
					printf("<td align=\"center\" style=\"border-top:solid 1px rgb(83,121,164)\">");
					printf("<input type=\"button\" value=\"+\" onclick=\"repl_dupe_line()\">&nbsp;");
					printf("<input type=\"button\" value=\"-\" onclick=\"rem_dupe_line(this)\" %s>", $first ? "disabled" : "");
					printf("</td>");
					printf("<td align=\"center\" style=\"border-top:solid 1px rgb(83,121,164)\">");
					printf("<select name=\"delivery[]\" class=\"style4\" id=\"delivery%d\" onchange=\"toggleFileBox(this)\">", $k);
					printf("<option value=\"\">*** SELECT ***</option>");
					foreach ($delopts->items as $a) {
						printf("<option value=\"%s\" %s>%s</option>",
							$a->target->code,
							($v["delivery"] == $a->target->code ? "selected" : ""),
							$a->target->descr);
					}
					printf("</select>");
					switch ($v["delivery"]) {
						case "U" :
							printf("<p id=\"filewrap%d\">", $k);
							printf("<input type=\"file\" name=\"delfile[]\" id=\"delfile%d\" class=\"style4\">", $k);
							if ($_REQUEST["attachment"][$k] != "") {
								printf("<br>The file \"%s\" has already been uploaded for this item.  Please use the file picker above to replace it with another file.", $_REQUEST["original"][$k]);
							}
							printf("</p>");
							break;
						case "F" :
							printf("<p id=\"filewrap%d\">", $k);
							printf("<input type=\"hidden\" name=\"delfile[]\" id=\"delfile%d\" value=\"%s\">", $k, $v["ftpurl"]);
							preg_match("/ftp\:\/\/(.*)\:(.*)\@(.*)\/(.*)$/U", $v["ftpurl"], $matches);
							printf("Host (ie ftp.example.com)<br><input type=\"text\" id=\"delhost%d\" value=\"%s\"><br>", $k, $matches[1]);
							printf("User<br><input type=\"text\" id=\"deluser%d\" value=\"%s\"><br>", $k, $matches[2]);
							printf("Password<br><input type=\"text\" id=\"delpass%d\" value=\"%s\"><br>", $k, $matches[3]);
							printf("File Spec (ie /home/user/dwg.dxf)<br><input type=\"text\" id=\"delspec%d\" value=\"%s\">", $k, $matches[4]);
							printf("</p>");
							break;
						default :
							printf("<span id=\"filewrap%d\"><input type=\"hidden\" name=\"delfile[]\" id=\"delfile%d\" value=\" \"></span>", $k, $k);
					}
					printf("</td>");
					printf("<td align=\"center\" style=\"border-top:solid 1px rgb(83,121,164)\">");
					printf("<input name=\"originals[]\" type=\"hidden\" class=\"style4\" id=\"originals%d\" value=\"1\" size=\"5\" maxlength=\"5\">", $k);
					printf("<input name=\"duplicates[]\" type=\"text\" class=\"style4\" id=\"duplicates%d\" value=\"%s\" size=\"5\" maxlength=\"5\" onFocus=\"clearText(this)\">",
						$k,
						$v["duplicates"]);
					printf("</td>");
					printf("<td align=\"center\" style=\"border-top:solid 1px rgb(83,121,164)\">");
					printf("<select name=\"sizes[]\" class=\"style4\" id=\"sizes%d\">", $k);
					foreach ($assocs->items as $a) {
						printf("<option value=\"%s\" %s>%s</option>",
							$a->target->code,
							($v["sizes"] == $a->target->code ? "selected" : ""),
							$a->target->descr);
					}
					printf("</select>");
					printf("</td>");
					printf("<td align=\"center\" style=\"border-top:solid 1px rgb(83,121,164)\">");
					printf("<input type=\"button\" value=\"+\" onclick=\"repl_dupe_detail(this.parentNode.parentNode)\">&nbsp;");
					printf("<input type=\"button\" value=\"-\" onclick=\"rem_dupe_detail(this)\" %s>", $first ? "disabled" : "");
					printf("</td>");
					printf("</tr>");
				}
				$first = false;
			}
		} else {
			printf("<tr>");
			printf("<td align=\"center\" style=\"border-top:solid 1px rgb(83,121,164)\">");
			printf("<input type=\"button\" value=\"+\" onclick=\"repl_dupe_line()\">&nbsp;");
			printf("<input type=\"button\" value=\"-\" onclick=\"rem_dupe_line(this)\" disabled>");
			printf("</td>");
			printf("<td align=\"center\" style=\"border-top:solid 1px rgb(83,121,164)\">");
			printf("<select name=\"delivery[]\" class=\"style4\" id=\"delivery0\" onchange=\"toggleFileBox(this)\">");
			printf("<option value=\"\">*** SELECT ***</option>");
			foreach ($delopts->items as $a) {
				printf("<option value=\"%s\" %s>%s</option>",
					$a->target->code,
					($_REQUEST["sizes"][$i] == $a->target->code ? "selected" : ""),
					$a->target->descr);
			}
			printf("</select>");
			printf("<span id=\"filewrap0\"><input type=\"hidden\" name=\"delfile[]\" id=\"delfile0\" value=\" \"></span>");
			printf("</td>");
			printf("<td align=\"center\" style=\"border-top:solid 1px rgb(83,121,164)\">");
			printf("<input name=\"originals[]\" type=\"hidden\" class=\"style4\" id=\"originals0\" value=\"1\" size=\"5\" maxlength=\"5\">");
			printf("<input name=\"duplicates[]\" type=\"text\" class=\"style4\" id=\"duplicates0\" value=\"%s\" size=\"5\" maxlength=\"5\" onFocus=\"clearText(this)\">",
				($_REQUEST["duplicates"][$i] == "" ? "---" : $_REQUEST["duplicates"][$i]));
			printf("</td>");
			printf("<td align=\"center\" style=\"border-top:solid 1px rgb(83,121,164)\">");
			printf("<select name=\"sizes[]\" class=\"style4\" id=\"sizes0\">");
			foreach ($assocs->items as $a) {
				printf("<option value=\"%s\" %s>%s</option>",
					$a->target->code,
					($_REQUEST["sizes"][$i] == $a->target->code ? "selected" : ""),
					$a->target->descr);
			}
			printf("</select>");
			printf("</td>");
			printf("<td align=\"center\" style=\"border-top:solid 1px rgb(83,121,164)\">");
			printf("<input type=\"button\" value=\"+\" onclick=\"repl_dupe_detail(this.parentNode.parentNode)\">&nbsp;");
			printf("<input type=\"button\" value=\"-\" onclick=\"rem_dupe_detail(this)\" disabled>");
			printf("</td>");
			printf("</tr>");
		}
		printf("</tbody>");
		printf("<tfoot>");
		printf("<tr><td colspan=\"5\">&nbsp;</td></tr>");
		printf("<tr><td colspan=\"5\" style=\"border-top:solid 1px rgb(83,121,164)\">");
		printf("<i>File uploads are limited to 2 megabytes in size. Please make a ZIP file, or create a single PDF document, from multiple files before uploading.</i>");
		printf("</td></tr>");
		printf("<tr><td colspan=\"5\">");
		printf("<i>If your originals are being picked up by Soho, please remember to include a printout of this order with the package.</i>");
		printf("</td></tr>");
		if ($_REQUEST["svc"] == 5) {
			printf("<tr><td colspan=\"5\">");
			printf("<i>For Copy Shop orders, only PDF files may be submitted.  We do not accept Microsoft Word documents.</i>");
			printf("</td></tr>");
		}
		printf("</tfoot>");
		printf("</table>");
		printf("</td></tr>");
	}
}


function show_doc_sub_block($dupes = array())
{
	$assocs = new Associations();
	$delopts = new Associations();
	$assocs->load_by_service_and_table($_REQUEST["svc"], "size");
	$delopts->load_by_service_and_table($_REQUEST["svc"], "delivery");
	if (count($delopts->items)) 
	{
		printf("<tr><td class=\"order_heading\">Document Submission</td></tr>");
		printf("<tr><td class=\"order_detail\">");
		printf("<table id=\"dupe_table\" width=\"100%%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">");
		printf("<thead>");
		printf("<tr>");		
		printf("<td class=\"style20\">FILE SUBMISSION</td>");
		if ($_REQUEST["svc"] != 6) printf("<td align=\"center\" class=\"style20\">SIZES</td>");
		printf("</tr>");
		printf("</thead>");
		printf("<tbody>");
		
		printf("<tr>");
		
		printf("<td style=\"border-top:solid 1px rgb(83,121,164)\">");
		printf("<select name=\"delivery[]\" class=\"style4\" id=\"delivery0\" >");
		printf("<option value=\"\">*** SELECT ***</option>");
		foreach ($delopts->items as $a) {
			printf("<option value=\"%s\" %s>%s</option>",
				$a->target->code,
				($_REQUEST["sizes"][$i] == $a->target->code ? "selected" : ""),
				$a->target->descr);
		}
		printf("</select>");
		printf("<span id=\"filewrap0\"><input type=\"hidden\" name=\"delfile[]\" id=\"delfile0\" value=\" \"></span>");
		printf("</td>");
		
	
		printf("<td align=\"center\" style=\"border-top:solid 1px rgb(83,121,164)\">");
		//don't show sizes for scanning
		if ($_REQUEST["svc"] != 6)
		{
			printf("<select name=\"sizes[]\" class=\"style4\" id=\"sizes0\">");
			foreach ($assocs->items as $a) {
				printf("<option value=\"%s\" %s>%s</option>",
					$a->target->code,
					($_REQUEST["sizes"][$i] == $a->target->code ? "selected" : ""),
					$a->target->descr);
			}
			printf("</select>");		
		}
		printf("</td>");
		printf("</tr>");
		
		printf("</tbody>");
		printf("<tfoot>");
		printf("<tr><td colspan=\"5\">&nbsp;</td></tr>");
		printf("<tr><td colspan=\"5\">");
		printf("<i>If your originals are being picked up by Soho, please remember to include a printout of this order with the package.</i>");
		printf("</td></tr>");
		if ($_REQUEST["svc"] == 5) {
			printf("<tr><td colspan=\"5\">");
			printf("<i>For Copy Shop orders, only PDF files may be submitted.  We do not accept Microsoft Word documents.</i>");
			printf("</td></tr>");
		}
		printf("</tfoot>");
		printf("</table>");
		printf("</td></tr>");
	}
}


function show_text_block($field_name, $header_text, $aux_text, $long_answer = false, $field_value = "")
{
	printf("<tr><td width=\"790\" class=\"order_heading\">%s</td></tr>", $header_text);
	printf("<tr>");
	printf("<td class=\"order_detail\">");
	printf("%s<br>", $aux_text);
	if ($long_answer) {
		if ($_REQUEST[$field_name] != "") {
			printf("<textarea name=\"%s\" cols=\"85\" rows=\"10\">%s</textarea>", $field_name, $_REQUEST[$field_name]);
		} else {
			printf("<textarea name=\"%s\" cols=\"85\" rows=\"10\">%s</textarea>", $field_name, $field_value);
		}
	} else {
		if ($_REQUEST[$field_name] != "") {
			printf("<input name=\"%s\" type=\"text\" size=\"32\" maxlength=\"64\" value=\"%s\">", $field_name, $_REQUEST[$field_name]);
		} else {
			printf("<input name=\"%s\" type=\"text\" size=\"32\" maxlength=\"64\" value=\"%s\">", $field_name, $field_value);
		}
	}
	printf("</td>");
	printf("</tr>");
}

function show_text_literal($field_name, $header_text, $aux_text, $field_value = "")
{
	printf("<tr><td width=\"790\" class=\"order_heading\">%s</td></tr>", $header_text);
	printf("<tr>");
	printf("<td class=\"order_detail\">");
	printf("%s<br>", $aux_text);
	if ($_REQUEST[$field_name] != "") {
		printf("<div><b>%s</b></div>", $_REQUEST[$field_name]);
		printf("<input name=\"%s\" type=\"hidden\" value=\"%s\">", $field_name, $_REQUEST[$field_name]);
	} else {
		printf("<div><b>%s</b></div>", $field_value);
		printf("<input name=\"%s\" type=\"hidden\" value=\"%s\">", $field_name, $field_value);
	}
	printf("</td>");
	printf("</tr>");
}

function package_dupes($idx, $cart, $req = array())
{
	if (count($req["originals"]) == 0) {
		if ($idx == "") return array();
		if (count($cart) == 0) return array();
		$ret = array();
		$cnt = 0;
		for ($i = 0; $i < count($cart[$idx]["originals"]); $i++) {
// 			if (!isset($cart[$idx]["delivery"][$i])) continue;
// 			if (!isset($cart[$idx]["delfile"][$i])) continue;
			if (!isset($cart[$idx]["duplicates"][$i])) continue;
			if (!isset($cart[$idx]["sizes"][$i])) continue;
			$ret[$cnt]["delivery"] = $cart[$idx]["delivery"][$i];
			$ret[$cnt]["delfile"] = $cart[$idx]["delfile"][$i];
			$ret[$cnt]["ftpurl"] = $cart[$idx]["ftpurl"][$i];
			$ret[$cnt]["originals"] = $cart[$idx]["originals"][$i];
			$ret[$cnt]["duplicates"] = $cart[$idx]["duplicates"][$i];
			$ret[$cnt]["sizes"] = $cart[$idx]["sizes"][$i];
			$cnt++;
		}
	} else {
		$ret = array();
		$cnt = 0;
		for ($i = 0; $i < count($req["originals"]); $i++) {
			if (!isset($req["delivery"][$i])) continue;
// 			if (!isset($req["delfile"][$i])) continue;
			if (!isset($req["duplicates"][$i])) continue;
			if (!isset($req["sizes"][$i])) continue;
			$ret[$cnt]["delivery"] = $req["delivery"][$i];
			$ret[$cnt]["delfile"] = $req["delfile"][$i];
			$ret[$cnt]["ftpurl"] = $req["ftpurl"][$i];
			$ret[$cnt]["originals"] = $req["originals"][$i];
			$ret[$cnt]["duplicates"] = $req["duplicates"][$i];
			$ret[$cnt]["sizes"] = $req["sizes"][$i];
			$cnt++;
		}
	}
	return $ret;
}
?>
<script type="text/javascript">
function check_for_none(obj)
{
	var inputs, i;
	inputs = document.getElementsByTagName("input");
	if (obj.value == "N" && obj.checked) {
		for (i = 0; i < inputs.length; i++) {
			if (inputs[i].type == "checkbox" && inputs[i].name == obj.name && inputs[i].value != "N") {
				inputs[i].checked = false;
			}
		}
	} else if (obj.value != "N") {
		for (i = 0; i < inputs.length; i++) {
			if (inputs[i].type == "checkbox" && inputs[i].name == obj.name && inputs[i].value == "N") {
				inputs[i].checked = false;
			}
		}
	}
}

function repl_dupe_line()
{
	var table = document.getElementById("dupe_table");
	var tbody = table.tBodies[0];
	var rows = tbody.rows;
	var master_row = rows[0];
	var tr = master_row.cloneNode(true);
	tbody.appendChild(tr);
	tr.cells[0].childNodes[2].disabled = false;	
	tr.cells[4].childNodes[2].disabled = false;
	renumber_lines();
	toggleFileBox(tbody.lastChild.cells[1].childNodes[0]);
	renumber_lines();
}

function rem_dupe_line(obj)
{
	var td = obj.parentNode;
	var tr = td.parentNode;
	var tbody = tr.parentNode;
	var cand = new Array();
	var i = 0;
	var tmp = tr.nextSibling;
	while (tmp) {
		if (tmp.cells[0].childNodes.length == 0) {
			cand[i++] = tmp;
			tmp = tmp.nextSibling;
		} else {
			break;
		}
	}
	for (i = 0; i < cand.length; i++) {
		tbody.removeChild(cand[i]);
	}
	tbody.removeChild(tr);
	renumber_lines();
}

function repl_dupe_detail(obj)
{
	var table = document.getElementById("dupe_table");
	var tbody = table.tBodies[0];
	var rows = tbody.rows;
	var master_row = rows[0];
	var tr = master_row.cloneNode(true);
	tbody.insertBefore(tr, obj.nextSibling);
	
	
	for (i = tr.cells[0].childNodes.length - 1; i >= 0; i--) {
		n = tr.cells[0].childNodes[i];
		tr.cells[0].removeChild(n);
	}
	for (i = tr.cells[1].childNodes.length - 1; i >= 0; i--) {
		n = tr.cells[1].childNodes[i];
		tr.cells[1].removeChild(n);
	}
	

	tr.cells[4].childNodes[2].disabled = false;
	
	var hidden = document.createElement("INPUT");
	hidden.name = "delivery[]";
	hidden.id = "delivery0";
	hidden.type = "hidden";
	hidden.value = "X";
	tr.cells[1].appendChild(hidden);
	
	var fw = document.createElement("SPAN");
	fw.id = "filewrap0";
	hidden2 = document.createElement("INPUT");
	hidden2.name = "delfile[]";
	hidden2.id = "delfile0";
	hidden2.type = "hidden";
	hidden2.value = " ";
	fw.appendChild(hidden2);
	tr.cells[1].appendChild(fw);
// 	tbody.appendChild(tr);
	//tbody.insertBefore(tr, obj.nextSibling);
	renumber_lines();
	for (i = 0; i < tr.cells.length; i++) {
		tr.cells[i].style.border = "none";
	}
}

function rem_dupe_detail(obj)
{
	var td = obj.parentNode;
	var tr = td.parentNode;
	var tbody = tr.parentNode;
	tbody.removeChild(tr);
	renumber_lines();
}

function renumber_lines()
{
	var originals = document.getElementsByName("originals[]");
	var duplicates = document.getElementsByName("duplicates[]");
	var sizes = document.getElementsByName("sizes[]");
	var delivery = document.getElementsByName("delivery[]");
	var delfile = document.getElementsByName("delfile[]");
	var i, container;
	for (i = 0; i < originals.length; i++) {
		originals[i].id = "originals"+i;
		duplicates[i].id = "duplicates"+i;
		sizes[i].id = "sizes"+i;
		if (delivery[i]) delivery[i].id = "delivery"+i;
		delfile[i].id = "delfile"+i;
		delfile[i].parentNode.id = "filewrap"+i;
	}
}

function toggleFileBox(obj)
{
	var ndx = obj.id.replace(/delivery/, "");
	var delivery = document.getElementById("delivery"+ndx);
	var df = document.createElement("INPUT");
	var ftpFields = ["delhost", "deluser", "delpass", "delspec"];
	var ftpLabels = ["Host (ie ftp.example.com)", "User", "Password", "Directory/File Name (ie. /home/user/dwg.dxf)"]; //(ie /home/user/dwg.dxf)
	var i, br, txt;
	df.id = "delfile"+ndx;
	df.name = "delfile[]";
	switch (delivery.value) {
		case "U" :
			df.type = "FILE";
			df.value = "";
			break;
		case "F" :
			df.type = "HIDDEN";
			df.value = " ";
			break;
		default :
			df.type = "HIDDEN";
			df.value = " ";
	}
	var fw = $("filewrap"+ndx);
	fw.parentNode.removeChild(fw);
	switch (delivery.value) {
		case "U" :
			fw = document.createElement("P");
			for (i = 0; i < ftpFields.length; i++) {
				it = document.createElement("INPUT");
				it.id = ftpFields[i]+ndx;
				it.name = ftpFields[i]+"[]";
				it.type = "HIDDEN";
				fw.appendChild(it);
			}
			break;
		case "F" :
			fw = document.createElement("P");
			for (i = 0; i < ftpFields.length; i++) {
				it = document.createElement("INPUT");
				it.id = ftpFields[i]+ndx;
				it.name = ftpFields[i]+"[]";
				it.type = "TEXT";
				fw.appendChild(document.createTextNode(ftpLabels[i]));
				fw.appendChild(document.createElement("BR"));
				fw.appendChild(it);
				fw.appendChild(document.createElement("BR"));
			}
			break;
		default :
			fw = document.createElement("SPAN");
			for (i = 0; i < ftpFields.length; i++) {
				it = document.createElement("INPUT");
				it.id = ftpFields[i]+ndx;
				it.name = ftpFields[i]+"[]";
				it.type = "HIDDEN";
				fw.appendChild(it);
			}
	}
	fw.id = "filewrap"+ndx;
	fw.appendChild(df);
	delivery.parentNode.appendChild(fw);
}

</script>