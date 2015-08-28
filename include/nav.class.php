<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: nav.class.php,v 1.3 2009-11-08 07:27:57 tredman Exp $
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.inc.php");

class Nav
{
	var $page;
	var $rows;
	
	function Nav($total_rows, $current_page)
	{
		$this->page = $current_page;
		$this->rows = $total_rows;
	}
	
	function to_string()
	{
		if ($this->rows < PER_PAGE) return;
		printf("\n<DIV CLASS=\"Nav\">JUMP TO PAGE: \n");
		for ($i = 1; $i <= ceil($this->rows / PER_PAGE); $i++) {
			if ($i != $this->page) {
				printf("\t<A HREF=\"%s?page=%d&%s\" CLASS=\"NavLink\">\n" .
					"\t\t<SPAN CLASS=\"NavButton\" ONMOUSEOVER=\"this.className='NavButtonHover'\" ONMOUSEOUT=\"this.className='NavButton'\">%d</SPAN>\n" .
					"\t</A>\n",
					$_SERVER["PHP_SELF"],
					$i,
					preg_replace("/action=.*&/U", "", preg_replace("/page=[0-9]*&/U", "", $_SERVER["QUERY_STRING"])),
					$i);
			} else {
				printf("\t<SPAN CLASS=\"NavButtonCurrent\">%d</SPAN>\n", $i);
			}
		}
		printf("</DIV>\n");
	}
	
}