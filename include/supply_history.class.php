<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: supply_history.class.php,v 1.1 2009/01/12 04:08:33 tredman Exp $
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");

class Supply_History
{
	var $product_id;
	var $descr;
	var $qty;
	var $price;
	var $last_date;
	var $cat_descr;
	
	function Supply_History($x = 0)
	{
		$this->product_id = array();
		$this->descr = array();
		$this->qty = array();
		$this->price = array();
		$this->last_date = array();
		$this->cat_descr = array();
		if ($x > 0) {
			$this->load($x);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf(
			"select d.id as product_id, d.descr, sum(c.qty) as total_qty, d.price, max(a.order_date) as last_date, d.sub2cat_id " .
			"from order_master a, orders b, order_supplies c, store_products d " .
			"where a.id = b.master_id " .
			"and b.id = c.order_id " .
			"and c.product_id = d.id " .
			"and a.customer_id = %d " .
			"and b.service_id = -1 " .
			"group by d.id, d.descr, d.price, d.sub2cat_id " .
			"order by 5 desc, 2",
			$x
		);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		$row = 0;
		foreach ($db->results as $r) {
			$this->product_id[$row] = intval($r["product_id"]);
			$this->descr[$row] = sprintf("<a href=\"javascript:select_category(%d)\" class=\"history_link\">%s</a>", $r["sub2cat_id"], $r["descr"]);
			$this->qty[$row] = intval($r["total_qty"]);
			$this->price[$row] = floatval($r["price"]);
			$this->last_date[$row] = date("Y-m-d H:i:s", strtotime($r["last_date"]));
			$sub2cat = $this->s2c_descr(intval($r["sub2cat_id"]));
			$subcat = $this->sc_descr($sub2cat["subcat_id"]);
			$cat = $this->c_descr($subcat["category_id"]);
			$this->cat_descr[$row] = sprintf("<a href=\"javascript:select_current(%d)\" class=\"history_link\">%s</a>", $cat["id"], $cat["descr"]);
			if ($cat["descr"] != $subcat["descr"]) { $this->cat_descr[$row] .= sprintf(" / <a href=\"javascript:select_current(%d)\" class=\"history_link\">%s</a>", $subcat["category_id"], $subcat["descr"]); }
			if ($subcat["descr"] != $sub2cat["descr"]) { $this->cat_descr[$row] .= sprintf(" / <a href=\"javascript:select_category(%d)\" class=\"history_link\">%s</a>", $sub2cat["id"], $sub2cat["descr"]); }
			$row++;
		}
	}

	function s2c_descr($id)
	{
		$db = new Database();
		$sql = sprintf("select id, descr, subcat_id from store_sub2cat where id = %d", $id);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		$results = $db->results;
		$db->close();
		return array("id" => $results[0]["id"], "descr" => $results[0]["descr"], "subcat_id" => $results[0]["subcat_id"]);
	}

	function sc_descr($id)
	{
		$db = new Database();
		$sql = sprintf("select id, descr, category_id from store_subcat where id = %d", $id);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		$results = $db->results;
		$db->close();
		return array("id" => $results[0]["id"], "descr" => $results[0]["descr"], "category_id" => $results[0]["category_id"]);
	}

	function c_descr($id)
	{
		$db = new Database();
		$sql = sprintf("select id, descr from store_category where id = %d", $id);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		$results = $db->results;
		$db->close();
		return array("id" => $results[0]["id"], "descr" => $results[0]["descr"]);
	}
	
}

?>