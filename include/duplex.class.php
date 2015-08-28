<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: duplex.class.php,v 1.4 2009/03/09 17:39:44 tredman Exp $
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");

class Duplex
{
	var $id;
	var $code;
	var $descr;
	var $listing_order;

	function Duplex($x = 0, $c = "")
	{
		$this->id = 0;
		$this->code = "";
		$this->descr = "";
		$this->listing_order = 0;
		if ($x > 0) {
			$this->load($x);
		} elseif ($c != "") {
			$this->load_by_code($c);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select id, code, descr, listing_order from duplexes where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->code = stripslashes($r["code"]);
			$this->descr = stripslashes($r["descr"]);
			$this->listing_order = intval($r["listing_order"]);
		}
	}

	function load_by_code($x)
	{
		$db = new Database();
		$sql = sprintf("select id, code, descr from duplexes where code = '%s'", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->code = stripslashes($r["code"]);
			$this->descr = stripslashes($r["descr"]);
			$this->listing_order = intval($r["listing_order"]);
		}
	}

	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into duplexes (id, code, descr, listing_order) " .
				"values (%d, '%s', '%s', %d) " .
				"on duplicate key update code = '%s', descr = '%s', listing_order = %d",
				$this->id,
				mysql_real_escape_string(strip_tags($this->code)),
				mysql_real_escape_string(strip_tags($this->descr)),
				$this->listing_order,
				mysql_real_escape_string(strip_tags($this->code)),
				mysql_real_escape_string(strip_tags($this->descr)),
				$this->listing_order);
		} else {
			$sql = sprintf("insert into duplexes (code, descr, listing_order) " .
				"values ('%s', '%s')",
				mysql_real_escape_string(strip_tags($this->code)),
				mysql_real_escape_string(strip_tags($this->descr)),
				$this->listing_order);
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
	}

	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from duplexes where id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}
}

class Duplexes
{
	var $items;

	function Duplexes($arr = array())
	{
		$this->items = array();
		if (is_array($arr)) {
			if (count($arr) == 0) {
				$db = new Database();
				$sql = "select id from duplexes order by listing_order, code";
				$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
				foreach ($db->results as $r) {
					$arr[] = $r["id"];
				}
				$db->close();
			}
			foreach ($arr as $a) {
				$this->items[] = new Duplex($a);
			}
		} else {
			$this->items[] = new Duplex($arr);
		}
	}

}
?>