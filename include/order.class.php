<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: order.class.php,v 1.13 2009-11-08 07:27:57 tredman Exp $
 * User database class
 */

require_once($_SERVER["DOCUMENT_ROOT"] . SOHO_BASE_HREF . "/include/order_prop.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . SOHO_BASE_HREF . "/include/order_line.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . SOHO_BASE_HREF . "/include/order_supply.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . SOHO_BASE_HREF . "/include/address.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . SOHO_BASE_HREF . "/include/delivery_count.class.php");

define("ORDER_OPEN", 0);
define("ORDER_CLOSED", 1);
define("ORDER_CANCELED", 2);

class Order
{
	var $id;
	var $master_id;
	var $service_id;
	var $instructions;
	var $status;
	var $deliver_by;
	var $reference;
	var $lines;
	var $properties;
	var $addresses;
	var $supplies;
	var $delivery_counts;
	
	function Order($x = 0)
	{
		$this->id = 0;
		$this->master_id = 0;
		$this->service_id = 0;
		$this->instructions = "";
		$this->reference = "";
		$this->status = 0;
		$this->deliver_by = "";
		$this->lines = null;
		$this->properties = null;
		$this->addresses = null;
		$this->supplies = null;
		$this->delivery_counts = null;
		if ($x > 0) {
			$this->load($x);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select id, master_id, service_id, instructions, status, deliver_by, reference from orders where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->service_id = intval($r["service_id"]);
			$this->master_id = intval($r["master_id"]);
			$this->instructions = stripslashes($r["instructions"]);
			$this->status = intval($r["status"]);
			$this->deliver_by = stripslashes($r["deliver_by"]);
			$this->reference = stripslashes($r["reference"]);
		}
		$this->get_order_properties();
		$this->get_order_lines();
		$this->get_addresses();
		$this->get_supplies();
		$this->get_delivery_counts();
	}

	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into orders (id, master_id, service_id, instructions, status, deliver_by, reference) " .
				"values (%d, %d, %d, '%s', %d, '%s', '%s') " .
				"on duplicate key update master_id = %d, service_id = %d, instructions = '%s', status = %d, deliver_by = '%s', reference = '%s'",
				$this->id,
				$this->master_id,
				$this->service_id,
				mysql_real_escape_string(strip_tags($this->instructions)),
				$this->status,
				mysql_real_escape_string(strip_tags($this->deliver_by)),
				mysql_real_escape_string(strip_tags($this->reference)),
				$this->master_id,
				$this->service_id,
				mysql_real_escape_string(strip_tags($this->instructions)),
				$this->status,
				mysql_real_escape_string(strip_tags($this->deliver_by)),
				mysql_real_escape_string(strip_tags($this->reference)));
		} else {
			$sql = sprintf("insert into orders (master_id, service_id, instructions, status, deliver_by, reference) " .
				"values (%d, %d, '%s', %d, '%s', '%s')",
				$this->master_id,
				$this->service_id,
				mysql_real_escape_string(strip_tags($this->instructions)),
				$this->status,
				mysql_real_escape_string(strip_tags($this->deliver_by)),
				mysql_real_escape_string(strip_tags($this->reference)));
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$this->id = $db->last_id;
		$this->get_order_properties();
		$this->get_order_lines();
		$this->get_addresses();
		$this->get_supplies();
		$this->get_delivery_counts();
	}

	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from orders where id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}
	
	function get_order_properties()
	{
		$arr = array();
		$db = new Database();
		$sql = sprintf("select id from order_props where order_id = %d", $this->id);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$arr[] = $r["id"];
		}
		$this->properties = new Order_Props($arr);
	}
	
	function get_order_lines()
	{
		$arr = array();
		$db = new Database();
		$sql = sprintf("select id from order_lines where order_id = %d", $this->id);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$arr[] = $r["id"];
		}
		$this->lines = new Order_Lines($arr);
	}
	
	function get_supplies()
	{
		$arr = array();
		$db = new Database();
		$sql = sprintf("select id from order_supplies where order_id = %d", $this->id);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$arr[] = $r["id"];
		}
		$this->supplies = new Order_Supplies($arr);
	}
	
	function change_status($status = ORDER_OPEN)
	{
		$this->status = $status;
	}
	
	function get_addresses()
	{
		$arr = array();
		$db = new Database();
		$sql = sprintf("select id from addresses where order_id = %d", $this->id);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$arr[] = $r["id"];
		}
		$this->addresses = new Addresses($arr);
	}
	
	function get_delivery_counts()
	{
		$arr = array();
		$db = new Database();
		$sql = sprintf("select id from delivery_counts where order_id = %d", $this->id);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$arr[] = $r["id"];
		}
		$this->delivery_counts = new Delivery_Counts($arr);
	}
}

class Orders
{
	var $items;
	var $sort_column;
	var $sort_order;

	function Orders($arr = array(), $sc = 1, $so = "DESC")
	{
		$this->sort_column = $sc;
		$this->sort_order = $so;
		$this->items = array();
		if (is_array($arr)) {
			if (count($arr) == 0) {
				$db = new Database();
				$sql = sprintf("select o.id, u.company, u.lname, om.order_date from orders o, order_master om, users u where o.master_id = om.id and om.customer_id = u.id order by %d %s", $this->sort_column, $this->sort_order);
				$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
				foreach ($db->results as $r) {
					$arr[] = $r["id"];
				}
				$db->close();
			}
			foreach ($arr as $a) {
				$this->items[] = new Order($a);
			}
		} else {
			$this->items[] = new Order($arr);
		}
	}
	
	function get_orders_by_status($status = ORDER_OPEN, $page = 0)
	{
		$this->items = array();
		$db = new Database();
		if ($page == 0) {
			$sql = sprintf("select o.id, u.company, u.lname, om.order_date from orders o, order_master om, users u where o.master_id = om.id and om.customer_id = u.id and o.service_id >= 0 and o.status = %d order by %d %s", $status, $this->sort_column, $this->sort_order);
		} else {
			$sql = sprintf("select o.id, u.company, u.lname, om.order_date from orders o, order_master om, users u where o.master_id = om.id and om.customer_id = u.id and o.service_id >= 0 and o.status = %d order by %d %s limit %d offset %d", $status, $this->sort_column, $this->sort_order, PER_PAGE, ($page - 1) * PER_PAGE);
		}
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->items[] = new Order($r["id"]);
		}
		$db->close();
	}
	
	function get_orders_by_status_and_client($status = ORDER_OPEN, $client = 0, $page = 0)
	{
		if ($client == 0) return;
		$this->items = array();
		$db = new Database();
		if ($page == 0) {
			$sql = sprintf(
				"select o.id, u.company, u.lname, om.order_date " .
				"from orders o, order_master om, users u " .
				"where o.master_id = om.id " .
				"and om.customer_id = u.id " .
// 				"and o.service_id >= 0 " .
				"and o.status = %d " .
				"and om.customer_id = %d " .
				"order by %d %s",
				$status,
				$client,
				$this->sort_column,
				$this->sort_order);
		} else {
			$sql = sprintf(
				"select o.id, u.company, u.lname, om.order_date " .
				"from orders o, order_master om, users u " .
				"where o.master_id = om.id " .
				"and om.customer_id = u.id " .
// 				"and o.service_id >= 0 " .
				"and o.status = %d " .
				"and om.customer_id = %d " .
				"order by %d %s " .
				"limit %d offset %d",
				$status,
				$client,
				$this->sort_column,
				$this->sort_order,
				PER_PAGE,
				($page - 1) * PER_PAGE);
		}
		Console::log($sql);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->items[] = new Order($r["id"]);
		}
		$db->close();
	}
	
	function get_supply_orders_by_status($status = ORDER_OPEN, $page = 0)
	{
		$this->items = array();
		$db = new Database();
		if ($page == 0) {
			$sql = sprintf("select o.id, u.company, u.lname, om.order_date from orders o, order_master om, users u where o.master_id = om.id and om.customer_id = u.id and o.service_id < 0 and o.status = %d order by %d %s", $status, $this->sort_column, $this->sort_order);
		} else {
			$sql = sprintf("select o.id, u.company, u.lname, om.order_date from orders o, order_master om, users u where o.master_id = om.id and om.customer_id = u.id and o.service_id < 0 and o.status = %d order by %d %s limit %d offset %d", $status, $this->sort_column, $this->sort_order, PER_PAGE, ($page - 1) * PER_PAGE);
		}
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->items[] = new Order($r["id"]);
		}
		$db->close();
	}

	function get_supply_orders_by_client($client, $page = 0)
	{
		$this->items = array();
		$db = new Database();
		if ($page == 0) {
			$sql = sprintf(
				"select o.id, u.company, u.lname, om.order_date " .
				"from orders o, order_master om, users u " .
				"where o.master_id = om.id " .
				"and om.customer_id = u.id " .
 				"and o.service_id < 0 " .
				"and om.customer_id = %d " .
				"order by %d %s",
				$client,
				$this->sort_column,
				$this->sort_order);
		} else {
			$sql = sprintf(
				"select o.id, u.company, u.lname, om.order_date " .
				"from orders o, order_master om, users u " .
				"where o.master_id = om.id " .
				"and om.customer_id = u.id " .
 				"and o.service_id < 0 " .
				"and om.customer_id = %d " .
				"order by %d %s " .
				"limit %d offset %d",
				$client,
				$this->sort_column,
				$this->sort_order,
				PER_PAGE,
				($page - 1) * PER_PAGE);
		}
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->items[] = new Order($r["id"]);
		}
		$db->close();
	}
	
}

class Orders_Summary
{
	var $items;

	function Orders_Summary()
	{
		$this->items = array();
	}
	
	function get_orders_by_status($status = ORDER_OPEN)
	{
		$this->items = array();
		$db = new Database();
		$sql = sprintf("select id from orders where service_id >= 0 and status = %d order by id desc", $status);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->items[] = $r["id"];
		}
		$db->close();
	}
	
	function get_supply_orders_by_status($status = ORDER_OPEN)
	{
		$this->items = array();
		$db = new Database();
		$sql = sprintf("select id from orders where service_id < 0 and status = %d order by id desc", $status);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->items[] = $r["id"];
		}
		$db->close();
	}
	
}
?>