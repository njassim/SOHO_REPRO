<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: order_line.class.php,v 1.7 2009/03/10 05:19:36 tredman Exp $
 * User database class
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");

class Order_Line
{
	var $id;
	var $order_id;
	var $originals;
	var $duplicates;
	var $size_id;
	var $ftpurl;
	var $image;
	
	function Order_Line($x = 0)
	{
		$this->id = 0;
		$this->order_id = 0;
		$this->originals = 0;
		$this->duplicates = 0;
		$this->size_id = 0;
		$this->ftpurl = "";
		$this->image = "";
		if ($x > 0) {
			$this->load($x);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select id, order_id, originals, duplicates, size_id, image, ftpurl from order_lines where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->order_id = intval($r["order_id"]);
			$this->originals = intval($r["originals"]);
			$this->duplicates = intval($r["duplicates"]);
			$this->size_id = intval($r["size_id"]);
			$this->image = $r["image"];
			$this->ftpurl = $r["ftpurl"];
		}
	}

	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into order_lines (id, order_id, originals, duplicates, size_id, image, ftpurl) " .
				"values (%d, %d, %d, %d, %d, '%s', '%s') " .
				"on duplicate key update order_id = %d, originals = %d, duplicates = %d, size_id = %d, image = '%s', ftpurl = '%s'",
				$this->id,
				$this->order_id,
				$this->originals,
				$this->duplicates,
				$this->size_id,
				mysql_real_escape_string($this->image),
				$this->ftpurl,
				$this->order_id,
				$this->originals,
				$this->duplicates,
				$this->size_id,
				mysql_real_escape_string($this->image),
				$this->ftpurl);
		} else {
			$sql = sprintf("insert into order_lines (order_id, originals, duplicates, size_id, image, ftpurl) " .
				"values (%d, %d, %d, %d, '%s', '%s')",
				$this->order_id,
				$this->originals,
				$this->duplicates,
				$this->size_id,
				mysql_real_escape_string($this->image),
				$this->ftpurl);
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$this->id = $db->last_id;
	}

	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from order_lines where id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}
}

class Order_Lines
{
	var $items;

	function Order_Lines($arr = array())
	{
		$this->items = array();
		if (is_array($arr)) {
			foreach ($arr as $a) {
				$this->items[] = new Order_Line($a);
			}
		} else {
			$this->items[] = new Order_Line($arr);
		}
	}

}
?>