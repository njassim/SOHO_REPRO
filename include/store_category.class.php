<?php
/*
 * (c) 2007 Tim Redman, All Rights Reserved
 * $Id: store_category.class.php,v 1.1 2007/07/28 23:09:05 tredman Exp $
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/store_subcat.class.php");

class Store_Category
{
	var $id;
	var $descr;
	var $subcats;

	function Store_Category($x = 0)
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
		$sql = sprintf("select id, descr from store_category where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->descr = stripslashes($r["descr"]);
		}
		$db->close();
	}
	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into store_category (id, descr) " .
				"values (%d, '%s') " . 
				"on duplicate key update descr = '%s'",
				intval($this->id),
				mysql_real_escape_string(strip_tags($this->descr)),
				mysql_real_escape_string(strip_tags($this->descr)));
		} else {
			$sql = sprintf("insert into store_category (descr) " .
				"values ('%s', '%s')",
				mysql_real_escape_string(strip_tags($this->descr)));
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
	}
	
	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from store_category where id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}

	function get_subcats()
	{
		$db = new Database();
		$sql = sprintf("select * from store_subcat where category_id = %d", $this->id);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		$tmp = array();
		foreach ($db->results as $r) {
			$tmp[] = $r["id"];
		}
		$this->subcats = new Store_Subcats($tmp);
	}
}
class Store_Categories
{
	var $items;

	function Store_Categories($arr = array())
{	
		$this->items = array();
		if (is_array($arr)) {
			if (count($arr) == 0) {
				$db = new Database();
				$sql = "select id from store_category order by descr";
				$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
				foreach ($db->results as $r) {
					$arr[] = $r["id"];
				}
				$db->close();
			}
			foreach ($arr as $a) {
				$this->items[] = new Store_Category($a);
			}
		} else {
			$this->items[] = new Store_Category($arr);
		}
	}
}
?>