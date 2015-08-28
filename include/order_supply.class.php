<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: order_supply.class.php,v 1.2 2008/05/16 00:07:42 tredman Exp $
 * Order supply line item database class
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");

class Order_Supply
{
	var $id;
	var $order_id;
	var $product_id;
	var $qty;
	var $qty_inv;
	
	function Order_Supply($x = 0)
	{
		$this->id = 0;
		$this->order_id = 0;
		$this->product_id = 0;
		$this->qty = 0;
		$this->qty_inv = 0;
		if ($x > 0) {
			$this->load($x);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select id, order_id, product_id, qty, qty_inv from order_supplies where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->order_id = intval($r["order_id"]);
			$this->product_id = intval($r["product_id"]);
			$this->qty = intval($r["qty"]);
			$this->qty_inv = intval($r["qty_inv"]);
		}
	}

	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into order_supplies (id, order_id, product_id, qty, qty_inv) " .
				"values (%d, %d, %d, %d, %d) " .
				"on duplicate key update order_id = %d, product_id = %d, qty = %d, qty_inv = %d",
				$this->id,
				$this->order_id,
				$this->product_id,
				$this->qty,
				$this->qty_inv,
				$this->order_id,
				$this->product_id,
				$this->qty,
				$this->qty_inv);
		} else {
			$sql = sprintf("insert into order_supplies (order_id, product_id, qty, qty_inv) " .
				"values (%d, %d, %d, %d)",
				$this->order_id,
				$this->product_id,
				$this->qty,
				$this->qty_inv);
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$this->id = $db->last_id;
	}

	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from order_supplies where id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}
}

class Order_Supplies
{
	var $items;

	function Order_Supplies($arr = array())
	{
		$this->items = array();
		if (is_array($arr)) {
			foreach ($arr as $a) {
				$this->items[] = new Order_Supply($a);
			}
		} else {
			$this->items[] = new Order_Supply($arr);
		}
	}

}
?>