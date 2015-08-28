<?php
/*
 * (c) 2007 Tim Redman, All Rights Reserved
 * $Id: store_product.class.php,v 1.2 2007/08/26 20:25:43 tredman Exp $
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/store_sub2cat.class.php");

class Store_Product
{
	var $id;
	var $descr;
	var $price;
	var $sub2cat_id;
	var $sub2cat;

	function Store_Product($x = 0)
	{
		$this->id = 0;
		$this->descr = "";
		$this->price = 0.00;
		$this->sub2cat_id = 0;
		if ($x > 0) {
			$this->load($x);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select id, descr, price, sub2cat_id from store_products where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->descr = stripslashes($r["descr"]);
			$this->price = floatval($r["price"]);
			$this->sub2cat_id = intval($r["sub2cat_id"]);
		}
		$db->close();
		$this->get_sub2cat();
	}
	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into store_products (id, descr, price, sub2cat_id) " .
				"values (%d, '%s', %0.2f, %d) " . 
				"on duplicate key update descr = '%s', price = %0.2f, sub2cat_id = %d",
				intval($this->id),
				mysql_real_escape_string(strip_tags($this->descr)),
				floatval($this->price),
				intval($this->sub2cat_id),
				mysql_real_escape_string(strip_tags($this->descr)),
				floatval($this->price),
				intval($this->sub2cat_id));
		} else {
			$sql = sprintf("insert into store_products (descr, price, sub2cat_id) " .
				"values ('%s', %0.2f, %d)",
				mysql_real_escape_string(strip_tags($this->descr)),
				floatval($this->price),
				intval($this->sub2cat_id));
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$this->get_sub2cat();
	}
	
	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from store_products where id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}

	function get_sub2cat()
	{
		$this->sub2cat = new Store_Sub2cat($this->sub2cat_id);
	}
}
class Store_Products
{
	var $items;

	function Store_Products($arr = array())
	{
		$this->items = array();
		if (is_array($arr)) {
			if (count($arr) == 0) {
				$db = new Database();
				$sql = "select id from store_products order by sub2cat_id, descr";
				$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
				foreach ($db->results as $r) {
					$arr[] = $r["id"];
				}
				$db->close();
			}
			foreach ($arr as $a) {
				$this->items[] = new Store_Product($a);
			}
		} else {
			$this->items[] = new Store_Product($arr);
		}
	}
	
	function get_by_sub2cat($x)
	{
		$db = new Database();
		$sql = sprintf("select id from store_products where sub2cat_id = %d order by descr", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		$tmp = array();
		foreach ($db->results as $r) {
			$tmp[] = $r["id"];
		}
		$this->items = array();
		foreach ($tmp as $t) {
			$this->items[] = new Store_Product($t);
		}
	}
}
?>