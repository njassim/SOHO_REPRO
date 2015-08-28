<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: company.class.php,v 1.1 2009/03/30 04:31:31 tredman Exp $
 * User database class
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/user.class.php");

class Company
{
	var $id;
	var $descr;
    var $users;
    var $email_domain;

	function Company($x = 0)
	{
		$this->id = 0;
		$this->descr = "";
		if ($x > 0) {
			$this->load($x);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select * from company where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->descr = stripslashes($r["descr"]);
			$this->email_domain = $r["email_domain"];
		}
        //$this->get_users();
	}

	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into company (id, descr, email_domain) " .
				"values (%d, '%s', '%s') " .
				"on duplicate key update descr = '%s', email_domain='%s'",
				$this->id,
				mysql_real_escape_string(strip_tags($this->descr)),
				mysql_real_escape_string(strip_tags($this->email_domain)));
		} else {
			$sql = sprintf("insert into company (descr, email_domain) " .
				"values ('%s', '%s')",
				mysql_real_escape_string(strip_tags($this->descr)),
				mysql_real_escape_string(strip_tags($this->email_domain)));
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
        $this->get_users();
	}

	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from company where id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}

    function get_users()
    {
		$this->users = array();
		$db = new Database();
		$sql = sprintf("select user_id from company_members where company_id = %d", $this->id);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$tmp = new User($r["user_id"]);
			if ($tmp->id > 0) {
				$this->users[] = $tmp;
			}
		}
		$db->close();
    }
    
	function add_user($user_id)
    {
		//$this->users = array();
		$db = new Database();
		$sql = sprintf("insert into company_members (company_id, user_id) values (%d, %d)", $this->id, $user_id);		
		$db->executeSQL($sql);
		$db->close();
    }
}

class Companies
{
	public $items;

	function Companies($arr = array())
	{
		$this->items = array();
		if (is_array($arr)) {
			if (count($arr) == 0) {
				$db = new Database();
				$sql = "select id from company order by descr";
				$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
				foreach ($db->results as $r) {
					$arr[] = $r["id"];
				}
				$db->close();
			}
			foreach ($arr as $a) {
				$this->items[] = new Company($a);
			}
		} else {
			$this->items[] = new Company($arr);
		}
	}
	
	public function search($searchFields)
	{
		$db = new Database();
		$sql = "select * from company ";
		
		foreach ($searchFields as $field => $val) 
		{			
			switch ($field) 
			{	
				default:						
					$where .= "and ( $field = '$val' ) \n";
				break;				
			}
		}		
		
		$where = trim($where, 'and ');
		if (!empty($searchFields)) $where = 'WHERE '.$where;
		
		
		$db->fetchRowObjects($sql.$where, __FILE__, __LINE__, false);
		return $db->results;
	}

}
?>