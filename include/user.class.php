<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: user.class.php,v 1.9 2009-11-08 07:27:57 tredman Exp $
 * User database class
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/address.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/order.class.php");

class User
{
	var $id;
	var $fname;
	var $lname;
	var $login_email;
	var $password;
	var $pwhint;
	var $status;
	var $company;
	var $company_id;
	var $addresses;
	var $open_orders;
	var $open_orders_count;
	var $closed_orders;
	var $closed_orders_count;
	var $all_orders;
	var $default_address;

	
	function User($x = 0, $e = "")
	{
		$this->id = 0;
		$this->fname = "";
		$this->lname = "";
		$this->login_email = "";
		$this->password = "";
		$this->pwhint = "";
		$this->status = false;
		$this->company = "";
		$this->company_id = 0;
		if ($x > 0) {
			$this->load($x);
		} elseif ($e != "") {
			$this->load_by_email($e);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select id, fname, lname, login_email, password, pwhint, status, company from users where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->fname = stripslashes($r["fname"]);
			$this->lname = stripslashes($r["lname"]);
			$this->login_email = stripslashes($r["login_email"]);
			$this->password = $r["password"];
			$this->pwhint = stripslashes($r["pwhint"]);
			$this->status = ($r["status"] == 1 ? true : false);
			$this->company = stripslashes($r["company"]);
		}
		$this->get_company_id();
	}

	function load_by_email($x)
	{
		$db = new Database();
		$sql = sprintf("select id, fname, lname, login_email, password, pwhint, status, company from users where login_email = '%s'",
			mysql_real_escape_string($x));
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->fname = stripslashes($r["fname"]);
			$this->lname = stripslashes($r["lname"]);
			$this->login_email = stripslashes($r["login_email"]);
			$this->password = $r["password"];
			$this->pwhint = stripslashes($r["pwhint"]);
			$this->status = ($r["status"] == 1 ? true : false);
			$this->company = stripslashes($r["company"]);
		}
		$this->get_company_id();
	}

	function load_by_hash($x)
	{
		$db = new Database();
		$sql = sprintf("select id, fname, lname, login_email, password, pwhint, status, company from users where ucase(convert(md5(login_email) using utf8)) = '%s'",
			mysql_real_escape_string(strtoupper($x)));
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->fname = stripslashes($r["fname"]);
			$this->lname = stripslashes($r["lname"]);
			$this->login_email = stripslashes($r["login_email"]);
			$this->password = $r["password"];
			$this->pwhint = stripslashes($r["pwhint"]);
			$this->status = ($r["status"] == 1 ? true : false);
			$this->company = stripslashes($r["company"]);
		}
		$this->get_company_id();
	}

	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into users (id, fname, lname, login_email, password, pwhint, status, company) " .
				"values (%d, '%s', '%s', '%s', '%s', '%s', %d, '%s') " .
				"on duplicate key update fname = '%s', lname = '%s', login_email = '%s', password = '%s', " .
				"pwhint = '%s', status = %d, company = '%s'",
				$this->id,
				mysql_real_escape_string(strip_tags($this->fname)),
				mysql_real_escape_string(strip_tags($this->lname)),
				mysql_real_escape_string(strip_tags($this->login_email)),
				$this->password,
				mysql_real_escape_string(strip_tags($this->pwhint)),
				($this->status ? 1 : 0),
				mysql_real_escape_string(strip_tags($this->company)),
				mysql_real_escape_string(strip_tags($this->fname)),
				mysql_real_escape_string(strip_tags($this->lname)),
				mysql_real_escape_string(strip_tags($this->login_email)),
				$this->password,
				mysql_real_escape_string(strip_tags($this->pwhint)),
				($this->status ? 1 : 0),
				mysql_real_escape_string(strip_tags($this->company)));
		} else {
			$sql = sprintf("insert into users (fname, lname, login_email, password, pwhint, status, company) " .
				"values ('%s', '%s', '%s', '%s', '%s', %d, '%s')",
				mysql_real_escape_string(strip_tags($this->fname)),
				mysql_real_escape_string(strip_tags($this->lname)),
				mysql_real_escape_string(strip_tags($this->login_email)),
				$this->password,
				mysql_real_escape_string(strip_tags($this->pwhint)),
				($this->status ? 1 : 0),
				mysql_real_escape_string(strip_tags($this->company)));
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$this->id = $db->last_id;
		$this->get_company_id();
	}

	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from users where id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$sql = sprintf("delete from company_members where user_id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}
	
	function set_password($x)
	{
		$this->password = strtoupper(md5($x));
	}
	
	function check_password($x)
	{
		if(strtoupper(md5($x)) == $this->password) {
			return true;
		} else {
			return false;
		}
	}
	
	function get_addresses()
	{
		$db = new Database();
		$sql = sprintf("select max(id) as id " .
			"from addresses " .
			"where customer_id = %d " .
			"group by company, attention, address1, address2, city, state, zip, phone", $this->id);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		$tmp = array();
		foreach ($db->results as $r) {
			$tmp[] = $r["id"];
		}
		$this->addresses = new Addresses($tmp);
		$this->default_address();
	}
	
	function default_address()
	{
		foreach ($this->addresses->items as $a) {
			if ($a->order_id == 0) {
				$this->default_address = $a;
			}
		}
	}
	
	function get_open_orders($page = 0)
	{
		$this->open_orders = new Orders();
		$this->open_orders->get_orders_by_status_and_client(ORDER_OPEN, $this->id, $page);
	}


	function get_open_orders_count()
	{
		$db = new Database();
		$sql = "select count(o.id) as total
				from orders o, order_master om, users u
				where o.master_id = om.id
					and om.customer_id = u.id
					and o.status = 0
					and om.customer_id = $this->id ";
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		$this->open_orders_count = $db->results[0]['total'];
		return $db->results[0]['total'];

	}

	function get_closed_orders($page = 0)
	{
		$this->closed_orders = new Orders();
		$this->closed_orders->get_orders_by_status_and_client(ORDER_CLOSED, $this->id, $page);
	}


	function get_closed_orders_count()
	{
		$db = new Database();
		$sql = "select count(o.id) as total
				from orders o, order_master om, users u
				where o.master_id = om.id
					and om.customer_id = u.id
					and o.status = 1
					and om.customer_id = $this->id ";
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		$this->closed_orders_count = $db->results[0]['total'];
		return $db->results[0]['total'];

	}

	function get_orders($page = 0)
	{
		$this->all_orders = new Orders();
		$this->all_orders->get_supply_orders_by_client($this->id, $page);
	}

	function get_company_id()
	{		
		$db = new Database();
		//$sql = sprintf("select company_id from company_members where user_id = %d", $this->id);
		$sql = sprintf("SELECT * FROM company_members c, company c1 WHERE c1.id=c.company_id and user_id=%d", $this->id);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->company_id = intval($r["company_id"]);
		}
	}
}

class Users
{
	var $items;

	function Users($arr = array())
	{
		$this->items = array();
		if (is_array($arr)) {
			if (count($arr) == 0) {
				$db = new Database();
				$sql = "select id from users order by lname, fname";
				$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
				foreach ($db->results as $r) {
					$arr[] = $r["id"];
				}
				$db->close();
			}
			foreach ($arr as $a) {
				$this->items[] = new User($a);
			}
		} else {
			$this->items[] = new User($arr);
		}
	}

}
?>