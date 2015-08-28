<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: delivery_count.class.php,v 1.2 2007/08/28 00:04:29 tredman Exp $
 * User database class
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");

class Delivery_Count
{
	var $id;
	var $order_id;
	var $address_id;
	var $size_id;
	var $copy_count;
	
	function Delivery_Count($x = 0)
	{
		$this->id = 0;
		$this->order_id = 0;
		$this->address_id = 0;
		$this->size_id = 0;
		$this->copy_count = 0;
		if ($x > 0) {
			$this->load($x);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select id, order_id, address_id, size_id, copy_count " .
			"from delivery_counts " .
			"where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->order_id = intval($r["order_id"]);
			$this->address_id = intval($r["address_id"]);
			$this->size_id = intval($r["size_id"]);
			$this->copy_count = intval($r["copy_count"]);
		}
	}

	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into delivery_counts (id, order_id, address_id, size_id, copy_count) " .
				"values (%d, %d, %d, %d, %d) " .
				"on duplicate key update order_id = %d, address_id = %d, size_id = %d, copy_count = %d",
				$this->id,
				$this->order_id,
				$this->address_id,
				$this->size_id,
				$this->copy_count,
				$this->order_id,
				$this->address_id,
				$this->size_id,
				$this->copy_count);
		} else {
			$sql = sprintf("insert into delivery_counts (order_id, address_id, size_id, copy_count) " .
				"values (%d, %d, %d, %d)",
				$this->order_id,
				$this->address_id,
				$this->size_id,
				$this->copy_count);
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$this->id = $db->last_id;
	}

	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from delivery_counts where id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}
}

class Delivery_Counts
{
	var $items;

	function Delivery_Counts($arr = array())
	{
		$this->items = array();
		if (is_array($arr)) {
			foreach ($arr as $a) {
				$this->items[] = new Delivery_Count($a);
			}
		} else {
			$this->items[] = new Delivery_Count($arr);
		}
	}

}
?>