<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: address.class.php,v 1.7 2009-11-08 07:27:57 tredman Exp $
 * User database class
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/delivery_count.class.php");

class Address
{
	var $id;
	var $order_id;
	var $customer_id;
	var $company;
	var $attention;
	var $address1;
	var $address2;
	var $city;
	var $state;
	var $zip;
	var $phone;
	var $phonef;
	var $sphone;
	var $delivery_counts;

	function Address($x = 0)
	{
		$this->id = 0;
		$this->order_id = 0;
		$this->customer_id = 0;
		$this->company = "";
		$this->attention = "";
		$this->address1 = "";
		$this->address2 = "";
		$this->city = "";
		$this->state = "";
		$this->zip = "";
		$this->phone = "";
		$this->phonef = $this->format_phone($this->phone);
		$this->sphone = $this->phone_string($this->phonef);
		$this->delivery_counts = null;
		if ($x > 0) {
			$this->load($x);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select id, order_id, customer_id, company, attention, address1, address2, city, state, zip, phone " .
			"from addresses " .
			"where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->order_id = intval($r["order_id"]);
			$this->customer_id = intval($r["customer_id"]);
			$this->company = stripslashes($r["company"]);
			$this->attention = stripslashes($r["attention"]);
			$this->address1 = stripslashes($r["address1"]);
			$this->address2 = stripslashes($r["address2"]);
			$this->city = stripslashes($r["city"]);
			$this->state = stripslashes($r["state"]);
			$this->zip = stripslashes($r["zip"]);
			$this->phone = stripslashes($r["phone"]);
			$this->phonef = $this->format_phone($this->phone);
			$this->sphone= $this->phone_string($this->phone);
		}
		$this->get_delivery_counts();
	}

	function load_default($x)
	{
		$db = new Database();
		$sql = sprintf("select id, order_id, customer_id, company, attention, address1, address2, city, state, zip, phone " .
			"from addresses " .
			"where customer_id = %d " .
			"and order_id = 0", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->order_id = intval($r["order_id"]);
			$this->customer_id = intval($r["customer_id"]);
			$this->company = stripslashes($r["company"]);
			$this->attention = stripslashes($r["attention"]);
			$this->address1 = stripslashes($r["address1"]);
			$this->address2 = stripslashes($r["address2"]);
			$this->city = stripslashes($r["city"]);
			$this->state = stripslashes($r["state"]);
			$this->zip = stripslashes($r["zip"]);
			$this->phone = stripslashes($r["phone"]);
			$this->phonef = $this->format_phone($this->phone);
			$this->sphone = $this->phone_string($this->phonef);
		}
		$this->get_delivery_counts();
	}

	function save()
	{
		$db = new Database();
		$this->phonef = $this->format_phone($this->phone);
		$this->sphone = $this->phone_string($this->phonef);
		if ($this->id > 0) {
			$sql = sprintf("insert into addresses (id, order_id, customer_id, company, attention, address1, address2, city, state, zip, phone) " .
				"values (%d, %d, %d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s') " .
				"on duplicate key update order_id = %d, customer_id = %d, company = '%s', attention = '%s', address1 = '%s', " .
				"address2 = '%s', city = '%s', state = '%s', zip = '%s', phone = '%s'",
				$this->id,
				$this->order_id,
				$this->customer_id,
				mysql_real_escape_string(strip_tags($this->company)),
				mysql_real_escape_string(strip_tags($this->attention)),
				mysql_real_escape_string(strip_tags($this->address1)),
				mysql_real_escape_string(strip_tags($this->address2)),
				mysql_real_escape_string(strip_tags($this->city)),
				mysql_real_escape_string(strip_tags($this->state)),
				mysql_real_escape_string(strip_tags($this->zip)),
				$this->phonef,
				$this->order_id,
				$this->customer_id,
				mysql_real_escape_string(strip_tags($this->company)),
				mysql_real_escape_string(strip_tags($this->attention)),
				mysql_real_escape_string(strip_tags($this->address1)),
				mysql_real_escape_string(strip_tags($this->address2)),
				mysql_real_escape_string(strip_tags($this->city)),
				mysql_real_escape_string(strip_tags($this->state)),
				mysql_real_escape_string(strip_tags($this->zip)),
				$this->phonef);
		} else {
			$sql = sprintf("insert into addresses (order_id, customer_id, company, attention, address1, address2, city, state, zip, phone) " .
				"values (%d, %d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
				$this->order_id,
				$this->customer_id,
				mysql_real_escape_string(strip_tags($this->company)),
				mysql_real_escape_string(strip_tags($this->attention)),
				mysql_real_escape_string(strip_tags($this->address1)),
				mysql_real_escape_string(strip_tags($this->address2)),
				mysql_real_escape_string(strip_tags($this->city)),
				mysql_real_escape_string(strip_tags($this->state)),
				mysql_real_escape_string(strip_tags($this->zip)),
				$this->phonef);
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$this->id = $db->last_id;
	}

	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from addresses where id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}

	function get_delivery_counts()
	{
		$arr = array();
		$db = new Database();
		$sql = sprintf("select id from delivery_counts where order_id = %d and address_id = %d", $this->order_id, $this->id);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$arr[] = $r["id"];
		}
		$this->delivery_counts = new Delivery_Counts($arr);
	}

	function format_phone($phone_number)
	{
		$ac = intval(substr($phone_number, 0, 3));
		$pr = intval(substr($phone_number, 3, 3));
		$su = intval(substr($phone_number, 6, 4));
		$ex = intval(substr($phone_number, 10, 6));
		return sprintf("%03d%03d%04d%06d", $ac, $pr, $su, $ex);
	}

	function phone_string($phone_number)
	{
		$ac = intval(substr($phone_number, 0, 3));
		$pr = intval(substr($phone_number, 3, 3));
		$su = intval(substr($phone_number, 6, 4));
		$ex = intval(substr($phone_number, 10, 6));
		return sprintf("(%03d) %03d-%04d Ext %06d", $ac, $pr, $su, $ex);
	}
}

class Addresses
{
	var $items;

	function Addresses($arr = array())
	{
		$this->items = array();
		if (is_array($arr)) {
			foreach ($arr as $a) {
				$this->items[] = new Address($a);
			}
		} else {
			$this->items[] = new Address($arr);
		}
	}

}
?>