<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: audit_log.class.php,v 1.1 2007/09/12 02:58:34 tredman Exp $
 */

class Audit_Log
{
	public $id;
	public $user_id;
	public $trans_date;
	public $order_id;
	public $table_name;
	public $field_name;
	public $old_value;
	public $new_value;
	
	function __construct($x = 0)
	{
		$this->id = 0;
		$this->user_id = "";
		$this->trans_date = "";
		$this->order_id = 0;
		$this->table_name = "";
		$this->field_name = "";
		$this->old_value = "";
		$this->new_value = "";
		if ($x > 0) {
			$this->load($x);
		}
	}
	
	function load($x) {
		$db = new Database();
		$sql = sprintf("select id, user_id, trans_date, order_id, table_name, field_name, old_value, new_value from audit_log where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->user_id = stripslashes($r["user_id"]);
			$this->trans_date = date("Y-m-d H:i:s", strtotime($r["trans_date"]));
			$this->order_id = intval($r["order_id"]);
			$this->table_name = stripslashes($r["table_name"]);
			$this->field_name = stripslashes($r["field_name"]);
			$this->old_value = stripslashes($r["old_value"]);
			$this->new_value = stripslashes($r["new_value"]);
		}
	}
	
	function save() {
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into audit_log (id, user_id, trans_date, order_id, table_name, field_name, old_value, new_value) " .
				"values (%d, %d, '%s', %d, '%s', '%s', '%s', '%s') " .
				"on duplicate key update user_id = %d, trans_date = '%s', order_id = %d, table_name = '%s', field_name = '%s', " .
				"old_value = '%s', new_value = '%s'",
				$this->id,
				$this->user_id,
				date("Y-m-d H:i:s"),
				$this->order_id,
				mysql_real_escape_string(strip_tags($this->table_name)),
				mysql_real_escape_string(strip_tags($this->field_name)),
				mysql_real_escape_string(strip_tags($this->old_value)),
				mysql_real_escape_string(strip_tags($this->new_value)),
				$this->user_id,
				date("Y-m-d H:i:s"),
				$this->order_id,
				mysql_real_escape_string(strip_tags($this->table_name)),
				mysql_real_escape_string(strip_tags($this->field_name)),
				mysql_real_escape_string(strip_tags($this->old_value)),
				mysql_real_escape_string(strip_tags($this->new_value)));
		} else {
			$sql = sprintf("insert into audit_log (user_id, trans_date, order_id, table_name, field_name, old_value, new_value) " .
				"values (%d, '%s', %d, '%s', '%s', '%s', '%s')",
				$this->user_id,
				date("Y-m-d H:i:s"),
				$this->order_id,
				mysql_real_escape_string(strip_tags($this->table_name)),
				mysql_real_escape_string(strip_tags($this->field_name)),
				mysql_real_escape_string(strip_tags($this->old_value)),
				mysql_real_escape_string(strip_tags($this->new_value)));
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$this->id = $db->last_id;
	}
}

class Audit_Logs
{
	public $items;

	function __construct($arr = array())
	{
		$this->items = array();
		if (is_array($arr)) {
			if (count($arr) == 0) {
				$db = new Database();
				$sql = "select id from audit_log order by id";
				$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
				foreach ($db->results as $r) {
					$arr[] = $r["id"];
				}
				$db->close();
			}
			foreach ($arr as $a) {
				$this->items[] = new Audit_Log($a);
			}
		} else {
			$this->items[] = new Audit_Log($arr);
		}
	}
	
	function get_log_by_user($user_id, $page = 0)
	{
		$this->items = array();
		$db = new Database();
		if ($page == 0) {
			$sql = sprintf("select id from audit_log where user_id = '%s' order by id desc", $user_id, $status);
		} else {
			$sql = sprintf("select id from audit_log where user_id = '%s' order by id desc limit %d offset %d", $user_id, PER_PAGE, ($page - 1) * PER_PAGE);
		}
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->items[] = new Audit_Log($r["id"]);
		}
		$db->close();
	}
	
	function get_log_by_order($order_id, $page = 0)
	{
		$this->items = array();
		$db = new Database();
		if ($page == 0) {
			$sql = sprintf("select id from audit_log where order_id = %d order by id desc", $order_id, $status);
		} else {
			$sql = sprintf("select id from audit_log where order_id = %d order by id desc limit %d offset %d", $order_id, PER_PAGE, ($page - 1) * PER_PAGE);
		}
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->items[] = new Audit_Log($r["id"]);
		}
		$db->close();
	}
	
	function get_log_by_table($table_name, $page = 0)
	{
		$this->items = array();
		$db = new Database();
		if ($page == 0) {
			$sql = sprintf("select id from audit_log where table_name = '%s' order by id desc", $table_name, $status);
		} else {
			$sql = sprintf("select id from audit_log where table_name = '%s' order by id desc limit %d offset %d", $table_name, PER_PAGE, ($page - 1) * PER_PAGE);
		}
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->items[] = new Audit_Log($r["id"]);
		}
		$db->close();
	}
	
}
