<?php
/*
 * (c) 2007 Tim Redman, All Rights Reserved
 * $Id: store_subcat.class.php,v 1.2 2007/08/26 20:26:23 tredman Exp $
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/store_category.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/store_sub2cat.class.php");

class Store_Subcat
{
	var $id;
	var $descr;
	var $category_id;
	var $category;
	var $sub2cats;

	function Store_Subcat($x = 0)
	{
		$this->id = 0;
		$this->descr = "";
		$this->category_id = 0;
		if ($x > 0) {
			$this->load($x);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select id, descr, category_id from store_subcat where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->descr = stripslashes($r["descr"]);
			$this->category_id = intval($r["category_id"]);
		}
		$db->close();
		$this->get_category();
	}
	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into store_subcat (id, descr, category_id) " .
				"values (%d, '%s', %d) " . 
				"on duplicate key update descr = '%s', category_id = %d",
				intval($this->id),
				mysql_real_escape_string(strip_tags($this->descr)),
				intval($this->category_id),
				mysql_real_escape_string(strip_tags($this->descr)),
				intval($this->category_id));
		} else {
			$sql = sprintf("insert into store_subcat (descr, category_id) " .
				"values ('%s', %d)",
				mysql_real_escape_string(strip_tags($this->descr)),
				intval($this->category_id));
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$this->get_category();
	}
	
	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from store_subcat where id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}
	
	function get_category()
	{
		$this->category = new Store_Category($this->category_id);
	}

	function get_sub2cats()
	{
		$db = new Database();
		$sql = sprintf("select id from store_sub2cat where subcat_id = %d", $this->id);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		$tmp = array();
		foreach ($db->results as $r) {
			$tmp[] = $r["id"];
		}
		$this->sub2cats = new Store_Sub2cats($tmp);
	}

}
class Store_Subcats
{
	var $items;

	function Store_Subcats($arr = array())
	{
		$this->items = array();
		if (is_array($arr)) {
			if (count($arr) == 0) {
				$db = new Database();
				$sql = "select id from store_subcat order by category_id, descr";
				$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
				foreach ($db->results as $r) {
					$arr[] = $r["id"];
				}
				$db->close();
			}
			foreach ($arr as $a) {
				$this->items[] = new Store_Subcat($a);
			}
		} else {
			$this->items[] = new Store_Subcat($arr);
		}
	}
	
	function get_by_category($x)
	{
		$db = new Database();
		$sql = sprintf("select id from store_subcat where category_id = %d order by descr", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		$tmp = array();
		foreach ($db->results as $r) {
			$tmp[] = $r["id"];
		}
		$db->close();
		$this->items = array();
		foreach ($tmp as $t) {
			$this->items[] = new Store_Subcat($t);
		}
	}
}
?>