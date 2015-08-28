<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: admin.class.php,v 1.3 2009/03/11 05:07:50 tredman Exp $
 * User database class
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");

class Admin
{
	var $id;
	var $fname;
	var $lname;
	var $login_email;
	var $password;
	var $pwhint;
	var $access_level;
	var $status;
	
	function Admin($x = 0, $e = "")
	{
		$this->id = 0;
		$this->fname = "";
		$this->lname = "";
		$this->login_email = "";
		$this->password = "";
		$this->pwhint = "";
		$this->status = false;
		$this->access_level = 0;
		if ($x > 0) {
			$this->load($x);
		} elseif ($e != "") {
			$this->load_by_email($e);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select id, fname, lname, login_email, password, pwhint, status, access_level from admin where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->fname = stripslashes($r["fname"]);
			$this->lname = stripslashes($r["lname"]);
			$this->login_email = stripslashes($r["login_email"]);
			$this->password = strtoupper($r["password"]);
			$this->pwhint = stripslashes($r["pwhint"]);
			$this->status = ($r["status"] == 1 ? true : false);
			$this->access_level = intval($r["access_level"]);
		}
	}

	function load_by_email($x)
	{
		$db = new Database();
		$sql = sprintf("select id, fname, lname, login_email, password, pwhint, status, access_level from admin where login_email = '%s'",
			mysql_real_escape_string($x));
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->fname = stripslashes($r["fname"]);
			$this->lname = stripslashes($r["lname"]);
			$this->login_email = stripslashes($r["login_email"]);
			$this->password = strtoupper($r["password"]);
			$this->pwhint = stripslashes($r["pwhint"]);
			$this->status = ($r["status"] == 1 ? true : false);
			$this->access_level = intval($r["access_level"]);
		}
	}

	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into admin (id, fname, lname, login_email, password, pwhint, status, access_level) " .
				"values (%d, '%s', '%s', '%s', '%s', '%s', %d, %d) " .
				"on duplicate key update fname = '%s', lname = '%s', login_email = '%s', password = '%s', " .
				"pwhint = '%s', status = %d, access_level = %d",
				$this->id,
				mysql_real_escape_string(strip_tags($this->fname)),
				mysql_real_escape_string(strip_tags($this->lname)),
				mysql_real_escape_string(strip_tags($this->login_email)),
				$this->password,
				mysql_real_escape_string(strip_tags($this->pwhint)),
				($this->status ? 1 : 0),
				$this->access_level,
				mysql_real_escape_string(strip_tags($this->fname)),
				mysql_real_escape_string(strip_tags($this->lname)),
				mysql_real_escape_string(strip_tags($this->login_email)),
				$this->password,
				mysql_real_escape_string(strip_tags($this->pwhint)),
				($this->status ? 1 : 0),
				$this->access_level);
		} else {
			$sql = sprintf("insert into admin (fname, lname, login_email, password, pwhint, status, access_level) " .
				"values ('%s', '%s', '%s', '%s', '%s', %d, %d)",
				mysql_real_escape_string(strip_tags($this->fname)),
				mysql_real_escape_string(strip_tags($this->lname)),
				mysql_real_escape_string(strip_tags($this->login_email)),
				$this->password,
				mysql_real_escape_string(strip_tags($this->pwhint)),
				($this->status ? 1 : 0),
				$this->access_level);
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
	}

	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from admin where id = %d", $this->id);
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

	function is_admin() { return ($this->access_level >= 10 ? true : false); }
	function is_staff() { return ($this->access_level >= 5 ? true : false); }

	function access_string()
	{
		if ($this->access_level >= 10) {
			return "ADMIN";
		} elseif ($this->access_level >= 5) {
			return "STAFF";
		} else {
			return "NONE";
		}
	}
	
}

class Admins
{
	var $items;

	function Admins($arr = array())
	{
		$this->items = array();
		if (is_array($arr)) {
			if (count($arr) == 0) {
				$db = new Database();
				$sql = "select id from admin order by lname, fname";
				$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
				foreach ($db->results as $r) {
					$arr[] = $r["id"];
				}
				$db->close();
			}
			foreach ($arr as $a) {
				$this->items[] = new Admin($a);
			}
		} else {
			$this->items[] = new Admin($arr);
		}
	}

}
?>