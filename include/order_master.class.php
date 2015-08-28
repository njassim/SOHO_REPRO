<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: order_master.class.php,v 1.7 2009-11-08 07:27:57 tredman Exp $
 * User database class
 */

require_once($_SERVER["DOCUMENT_ROOT"] . SOHO_BASE_HREF . "/include/order.class.php");

define("ORDER_OPEN", 0);
define("ORDER_CLOSED", 1);
define("ORDER_CANCELED", 2);

class Order_Master
{
	var $id;
	var $customer_id;
	var $order_date;
	var $reference;
	var $orders;

	function Order_Master($x = 0)
	{
		$this->id = 0;
		$this->customer_id = 0;
		$this->order_date = date("Y-m-d H:i:s");
		$this->reference = "";
		$this->orders = null;
		if ($x > 0) {
			$this->load($x);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select id, customer_id, order_date, reference from order_master where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->customer_id = intval($r["customer_id"]);
			$this->order_date = date("Y-m-d H:i:s", strtotime($r["order_date"]));
			$this->reference = $r["reference"];
		}
		$this->get_orders();
	}

	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into order_master (id, customer_id, order_date, reference) " .
				"values (%d, %d, '%s', '%s') " .
				"on duplicate key update customer_id = %d, order_date = '%s', reference = '%s'",
				$this->id,
				$this->customer_id,
				date("Y-m-d H:i:s", strtotime($this->order_date)),
				mysql_real_escape_string($this->reference),
				$this->customer_id,
				date("Y-m-d H:i:s", strtotime($this->order_date)),
				mysql_real_escape_string($this->reference));
		} else {
			$sql = sprintf("insert into order_master (customer_id, order_date, reference) " .
				"values (%d, '%s', '%s')",
				$this->customer_id,
				date("Y-m-d H:i:s", strtotime($this->order_date)),
				mysql_real_escape_string($this->reference));
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$this->id = $db->last_id;
		$this->get_orders();
	}

	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from order_master where id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}
	
	function get_orders()
	{
		$arr = array();
		$db = new Database();
		$sql = sprintf("select id from orders where master_id = %d", $this->id);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$arr[] = $r["id"];
		}
		$this->orders = new Orders($arr);
	}
	
}

class Order_Masters
{
	var $items;
	var $sort_column;
	var $sort_order;

	function Order_Masters($arr = array(), $sc = 1, $so = "DESC")
	{
		$this->items = array();
		$this->sort_column = $sc;
		$this->sort_order = $so;
		if (is_array($arr)) {
			if (count($arr) == 0) {
				$db = new Database();
				$sql = sprintf(
					"select a.id, b.company, b.lname, a.order_date " .
					"from order_master a, users b " .
					"where a.customer_id = b.id " .
					"order by %d %s",
					$this->sort_column,
					$this->sort_order
				);
				$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
				foreach ($db->results as $r) {
					$arr[] = $r["id"];
				}
				$db->close();
			}
			foreach ($arr as $a) {
				$this->items[] = new Order_Master($a);
			}
		} else {
			$this->items[] = new Order_Master($arr);
		}
	}
	
	function get_order_masters_by_client($client = 0, $page = 0)
	{
		$this->items = array();
		$db = new Database();
		if ($client == 0 && $page == 0) {
			$sql = sprintf("select distinct a.master_id, c.company, c.lname, b.order_date from orders a, order_master b, users c where a.master_id = b.id and b.customer_id = c.id and a.service_id > 0 order by %d %s", $this->sort_column, $this->sort_order);
		} elseif ($client == 0 && $page != 0) {
			$sql = sprintf("select distinct a.master_id, c.company, c.lname, b.order_date from orders a, order_master b, users c where a.master_id = b.id and b.customer_id = c.id and a.service_id > 0 order by %d %s limit %d offset %d", $this->sort_column, $this->sort_order, PER_PAGE, ($page - 1) * PER_PAGE);
		} elseif ($client != 0 && $page == 0) {
			$sql = sprintf("select distinct a.master_id, c.company, c.lname, b.order_date from orders a, order_master b, users c where a.master_id = b.id and b.customer_id = c.id and a.service_id > 0 and b.customer_id = %d order by %d %s", $client, $this->sort_column, $this->sort_order);
		} else {
			$sql = sprintf("select distinct a.master_id, c.company, c.lname, b.order_date from orders a, order_master b, users c where a.master_id = b.id and b.customer_id = c.id and a.service_id > 0 and b.customer_id = %d order by %d %s limit %d offset %d", $client, $this->sort_column, $this->sort_order, PER_PAGE, ($page - 1) * PER_PAGE);
		}
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$tmp = new Order_Master($r["master_id"]);
			if ($tmp->id > 0) $this->items[] = $tmp;
		}
		$db->close();
	}

	function get_master_orders_by_status_and_client($status = ORDER_OPEN, $client = 0, $page = 0)
	{
		$this->items = array();
		$db = new Database();
		if ($client == 0 && $page == 0) {
			$sql = sprintf("select om.id, u.company, u.lname, om.order_date from order_master om, orders o, users u where om.id = o.master_id and om.customer_id = u.id and o.status = %d order by %d %s", $status, $this->sort_column, $this->sort_order);
		} elseif ($client == 0 && $page != 0) {
			$sql = sprintf("select om.id, u.company, u.lname, om.order_date from order_master om, orders o, users u where om.id = o.master_id and om.customer_id = u.id and o.status = %d order by %d %s limit %d offset %d", $status, $this->sort_column, $this->sort_order, PER_PAGE, ($page - 1) * PER_PAGE);
		} elseif ($client != 0 && $page == 0) {
			$sql = sprintf("select om.id, u.company, u.lname, om.order_date from order_master om, orders o, users u where om.id = o.master_id and om.customer_id = u.id and o.status = %d and om.customer_id = %d order by %d %s", $status, $client, $this->sort_column, $this->sort_order);
		} else {
			$sql = sprintf("select om.id, u.company, u.lname, om.order_date from order_master om, orders o, users u where om.id = o.master_id and om.customer_id = u.id and o.status = %d and om.customer_id = %d order by %d %s limit %d offset %d", $status, $client, $this->sort_column, $this->sort_order, PER_PAGE, ($page - 1) * PER_PAGE);
		}
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->items[] = new Order_Master($r["id"]);
		}
	}
	
}

class Order_Master_Summary
{
	var $items;

	function Order_Master_Summary()
	{
		$this->items = array();
	}
	
	function get_order_masters_by_client($client = 0)
	{
		$this->items = array();
		$db = new Database();
		if ($client == 0) {
			$sql = sprintf("select distinct master_id from orders where service_id > 0 order by id desc");
		} else {
			$sql = sprintf("select distinct master_id from orders where service_id > 0 and customer_id = %d order by id desc", $client);
		}
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->items[] = $r["master_id"];
		}
		$db->close();
	}
	
}
?>