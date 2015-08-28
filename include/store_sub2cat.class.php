<?php
/*
 * (c) 2007 Tim Redman, All Rights Reserved
 * $Id: store_sub2cat.class.php,v 1.2 2007/08/26 20:26:06 tredman Exp $
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/store_subcat.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/store_product.class.php");

class Store_Sub2cat
{
	var $id;
	var $descr;
	var $long_descr;
	var $subcat_id;
	var $subcat;
	var $products;
	
	function Store_Sub2cat($x = 0)
	{
		$this->id = 0;
		$this->descr = "";
		$this->long_descr = "";
		$this->subcat_id = 0;
		$this->subcat = NULL;
		$this->products = NULL;
		if ($x > 0) {
			$this->load($x);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select id, descr, long_descr, subcat_id from store_sub2cat where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->descr = stripslashes($r["descr"]);
			$this->long_descr = stripslashes($r["long_descr"]);
			$this->subcat_id = intval($r["subcat_id"]);
		}
		$db->close();
		$this->get_subcat();
	}
	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into store_sub2cat (id, descr, long_descr, subcat_id) " .
				"values (%d, '%s', '%s', %d) " . 
				"on duplicate key update descr = '%s', long_descr = '%s', subcat_id = %d",
				intval($this->id),
				mysql_real_escape_string(strip_tags($this->descr)),
				mysql_real_escape_string(strip_tags($this->long_descr)),
				intval($this->subcat_id),
				mysql_real_escape_string(strip_tags($this->descr)),
				mysql_real_escape_string(strip_tags($this->long_descr)),
				intval($this->subcat_id));
		} else {
			$sql = sprintf("insert into store_sub2cat (descr, long_descr, subcat_id) " .
				"values ('%s', '%s', %d)",
				mysql_real_escape_string(strip_tags($this->descr)),
				mysql_real_escape_string(strip_tags($this->long_descr)),
				intval($this->subcat_id));
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$this->get_subcat();
	}
	
	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from store_sub2cat where id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}

	function get_subcat()
	{
		$this->subcat = new Store_Subcat($this->subcat_id);
	}
	
	function get_products()
	{
		$this->products = new Store_Products(0);
		$this->products->get_by_sub2cat($this->id);
	}
}
class Store_Sub2cats
{
	var $items;

	function Store_Sub2cats($arr = array())
	{
		$this->items = array();
		if (is_array($arr)) {
			if (count($arr) == 0) {
				$db = new Database();
				$sql = "select id from store_sub2cat order by subcat_id, descr";
				$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
				foreach ($db->results as $r) {
					$arr[] = $r["id"];
				}
				$db->close();
			}
			foreach ($arr as $a) {
				$this->items[] = new Store_Sub2cat($a);
			}
		} else {
			$this->items[] = new Store_Sub2cat($arr);
		}
	}
	
	function get_by_subcategory($x)
	{
		$db = new Database();
		$sql = sprintf("select id from store_sub2cat where subcat_id = %d order by descr", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		$tmp = array();
		foreach ($db->results as $r) {
			$tmp[] = $r["id"];
		}
		$this->items = array();
		foreach ($tmp as $t) {
			$this->items[] = new Store_Sub2cat($t);
		}
	}
}
?>