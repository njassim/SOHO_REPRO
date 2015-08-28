<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: schedule.class.php,v 1.4 2009/03/06 19:04:20 tredman Exp $
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");

define("SCHEDULE_OPEN", 1);
define("SCHEDULE_CLOSED", 2);

class Schedule
{
	var $id;
	var $order_id;
	var $pickup_date;
	var $pickup_asap;
	var $earliest_time;
	var $latest_time;
	var $call_flag;
	var $phone_number;
	var $phonef;
	var $sphone;
	var $status;

	function Schedule($x = 0)
	{
		$this->id = 0;
		$this->order_id = 0;
		$this->pickup_date = date("Y-m-d");
		$this->pickup_asap = false;
		$this->earliest_time = '00:00:00';
		$this->latest_time = '00:00:00';
		$this->call_flag = false;
		$this->phone_number = "";
		$this->phonef = $this->format_phone($this->phone_number);
		$this->sphone = $this->phone_string($this->phonef);
		$this->status = SCHEDULE_OPEN;
		if ($x > 0) {
			$this->load($x);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select id, order_id, pickup_date, pickup_asap, earliest_time, latest_time, call_flag, phone_number, status from schedule where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->order_id = intval($r["order_id"]);
			$this->pickup_date = date("Y-m-d", strtotime($r["pickup_date"]));
			$this->pickup_asap = ($r["pickup_asap"] == 1 ? true : false);
			$this->earliest_time = date("H:i:s", strtotime($r["earliest_time"]));
			$this->latest_time = date("H:i:s", strtotime($r["latest_time"]));
			$this->call_flag = ($r["call_flag"] == 1 ? true : false);
			$this->phone_number = stripslashes($r["phone_number"]);
			$this->phonef = $this->format_phone($this->phone_number);
			$this->status = intval($r["status"]);
		}
		$db->close();
	}

	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into schedule (id, order_id, pickup_date, pickup_asap, earliest_time, latest_time, call_flag," .
				"phone_number, status) " .
				"values (%d, %d, '%s', %d, '%s', '%s', %d, '%s', %d) " .
				"on duplicate key update order_id = %d, pickup_date = '%s', pickup_asap = %d, earliest_time = '%s'," .
				"latest_time = '%s', call_flag = %d, phone_number = '%s', status = %d",
				intval($this->id),
				intval($this->order_id),
				date("Y-m-d", strtotime($this->pickup_date)),
				($this->pickup_asap ? 1 : 0),
				date("H:i:s", strtotime($this->earliest_time)),
				date("H:i:s", strtotime($this->latest_time)),
				($this->call_flag ? 1 : 0),
				$this->phonef,
				intval($this->status),
				intval($this->order_id),
				date("Y-m-d", strtotime($this->pickup_date)),
				($this->pickup_asap ? 1 : 0),
				date("H:i:s", strtotime($this->earliest_time)),
				date("H:i:s", strtotime($this->latest_time)),
				($this->call_flag ? 1 : 0),
				$this->phonef,
				intval($this->status));
		} else {
			$sql = sprintf("insert into schedule (order_id, pickup_date, pickup_asap, earliest_time, latest_time, call_flag," .
				"phone_number, status) " .
				"values (%d, '%s', %d, '%s', '%s', %d, '%s', %d)",
				intval($this->order_id),
				date("Y-m-d", strtotime($this->pickup_date)),
				($this->pickup_asap ? 1 : 0),
				date("H:i:s", strtotime($this->earliest_time)),
				date("H:i:s", strtotime($this->latest_time)),
				($this->call_flag ? 1 : 0),
				$this->phonef,
				intval($this->status));
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
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

class Schedules
{
	var $items;

	function Schedules($arr = array())
{
		$this->items = array();
		if (is_array($arr)) {
			if (count($arr) == 0) {
				$db = new Database();
				$sql = "select id from schedule order by id";
				$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
				foreach ($db->results as $r) {
					$arr[] = $r["id"];
				}
				$db->close();
			}
			foreach ($arr as $a) {
				$this->items[] = new Schedule($a);
			}
		} else {
			$this->items[] = new Schedule($arr);
		}
	}

	function get_pickups_by_status($status = SCHEDULE_OPEN, $page = 0)
	{
		$this->items = array();
		$db = new Database();
		if ($page == 0) {
			$sql = sprintf("select id from schedule where status = %d order by pickup_date", $status);
		} else {
			$sql = sprintf("select id from schedule where status = %d order by pickup_date limit %d offset %d", $status, PER_PAGE, ($page - 1) * PER_PAGE);
		}
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->items[] = new Schedule($r["id"]);
		}
		$db->close();
	}

	function get_pickups_by_order($order_id, $page = 0)
	{
		$this->items = array();
		$db = new Database();
		if ($page == 0) {
			$sql = sprintf("select id from schedule where order_id = %d order by pickup_date", $order_id);
		} else {
			$sql = sprintf("select id from schedule where order_id = %d order by pickup_date limit %d offset %d", $order_id, PER_PAGE, ($page - 1) * PER_PAGE);
		}
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->items[] = new Schedule($r["id"]);
		}
		$db->close();
	}

}
?>