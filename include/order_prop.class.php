<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: order_prop.class.php,v 1.3 2007/09/12 02:58:13 tredman Exp $
 * User database class
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");

class Order_Prop
{
	var $id;
	var $order_id;
	var $name;
	var $value;
	var $data;
		
	function Order_Prop($x = 0)
	{
		$this->id = 0;
		$this->order_id = 0;
		$this->name = "";
		$this->value = "";
		$this->data = "";
		if ($x > 0) {
			$this->load($x);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select id, order_id, name, value, data from order_props where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->order_id = intval($r["order_id"]);
			$this->name = stripslashes($r["name"]);
			$this->value = stripslashes($r["value"]);
			$this->data = stripslashes($r["data"]);
		}
	}

	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into order_props (id, order_id, name, value, data) " .
				"values (%d, %d, '%s', '%s', '%s') " .
				"on duplicate key update order_id = %d, name = '%s', value = '%s', data = '%s'",
				$this->id,
				$this->order_id,
				mysql_real_escape_string(strip_tags($this->name)),
				mysql_real_escape_string(strip_tags($this->value)),
				mysql_real_escape_string(strip_tags($this->data)),
				$this->order_id,
				mysql_real_escape_string(strip_tags($this->name)),
				mysql_real_escape_string(strip_tags($this->value)),
				mysql_real_escape_string(strip_tags($this->data)));
		} else {
			$sql = sprintf("insert into order_props (order_id, name, value, data) " .
				"values (%d, '%s', '%s', '%s')",
				$this->order_id,
				mysql_real_escape_string(strip_tags($this->name)),
				mysql_real_escape_string(strip_tags($this->value)),
				mysql_real_escape_string(strip_tags($this->data)));
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$this->id = $db->last_id;
	}

	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from order_props where id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}
}

class Order_Props
{
	var $items;

	function Order_Props($arr = array())
	{
		$this->items = array();
		if (is_array($arr)) {
			foreach ($arr as $a) {
				$this->items[] = new Order_Prop($a);
			}
		} else {
			$this->items[] = new Order_Prop($arr);
		}
	}

}

$collection_list = array(
	"binding" => "Bindings",
	"color" => "Colors",
	"delivery" => "Deliveries",
	"duplex" => "Duplexes",
	"format" => "Formats",
	"laminate" => "Laminates",
	"media" => "Medias",
	"mounting" => "Mountings",
	"paper" => "Papers",
	"paper_color" => "Paper_Colors",
	"scandpi" => "Scandpis",
	"scantype" => "Scantypes",
	"size" => "Sizes",
	"source" => "Sources"
);
?>