<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: association.class.php,v 1.4 2009-11-08 07:27:57 tredman Exp $
 * User database class
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/service.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/delivery.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/color.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/size.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/paper.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/mounting.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/binding.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/laminate.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/source.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/scantype.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/scandpi.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/format.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/media.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/duplex.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/paper_color.class.php");

class Association
{
	var $service_id;
	var $table_name;
	var $row_id;
	var $service;
	var $target;

	function Association($service_id = 0, $table_name = "", $row_id = 0)
	{
		$this->service_id = 0;
		$this->table_name = "";
		$this->row_id = 0;
		if ($service_id > 0 && $table_name != "" && $row_id > 0) {
			$this->load($service_id, $table_name, $row_id);
		}
	}

	function load($x, $y, $z)
	{
		$db = new Database();
		$sql = sprintf("select service_id, table_name, row_id from associations where service_id = %d and table_name = '%s' and row_id = %d", $x, $y, $z);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->service_id = intval($r["service_id"]);
			$this->table_name = stripslashes($r["table_name"]);
			$this->row_id = intval($r["row_id"]);
		}
		$this->get_service();
		if ($this->table_name != "") $this->get_target();
	}

	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into associations (service_id, table_name, row_id) " .
				"values (%d, '%s', %d) " .
				"on duplicate key update service_id = %d, table_name = '%s', row_id = %d",
				$this->service_id,
				mysql_real_escape_string($this->table_name),
				$this->row_id);
		} else {
			$sql = sprintf("insert into associations (service_id, table_name, row_id) " .
				"values (%d, '%s', %d)",
				$this->service_id,
				mysql_real_escape_string($this->table_name),
				$this->row_id);
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$this->get_service();
		$this->get_target();
	}

	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from associations where service_id = %d and table_name = '%s' and row_id = %d",
			$this->service_id,
			$this->table_name,
			$this->row_id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}

	function get_service()
	{
		$this->service = new Service($this->service_id);
	}

	function get_target()
	{
		$class_name = ucfirst($this->table_name);
		$this->target = new $class_name($this->row_id);
	}
}

class Associations
{
	var $items;
	var $xlat_table;

	function Associations()
	{
		$this->items = array();
		$this->xlat_table = array(
			"binding" => "bindings",
			"color" => "colors",
			"delivery" => "deliveries",
			"duplex" => "duplexes",
			"format" => "formats",
			"laminate" => "laminates",
			"media" => "media",
			"mounting" => "mountings",
			"paper" => "papers",
			"paper_color" => "paper_colors",
			"scandpi" => "scandpis",
			"scantype" => "scantypes",
			"size" => "sizes",
			"source" => "sources"
		);
	}

	function load_by_service($x) {
		$this->items = array();
		$db = new Database();
		$sql = sprintf("select distinct table_name from associations where service_id = %d order by table_name", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		$results = $db->results;
		foreach ($results as $r) {
			$sql = sprintf("select a.row_id from associations a, %s b where b.id = a.row_id and a.service_id = %d and a.table_name = '%s' order by b.listing_order", $this->xlat_table[$r["table_name"]], $x, $r["table_name"]);
			$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
			foreach ($db->results as $r1) {
				$this->items[] = new Association($x, $r["table_name"], $r1["row_id"]);
			}
		}
		$db->close();
	}

	function load_by_service_and_table($x, $y) {
		$this->items = array();
		$db = new Database();
		if ($this->xlat_table[$y] == "") {
			$sql = sprintf("select a.service_id, a.table_name, a.row_id from associations a where a.service_id = %d and a.table_name = '%s' order by a.table_name, a.row_id", $this->xlat_table[$y], $x, $y);
		} else {
			$sql = sprintf("select a.service_id, a.table_name, a.row_id from associations a left join %s b on a.row_id = b.id where a.service_id = %d and a.table_name = '%s' order by a.table_name, b.listing_order", $this->xlat_table[$y], $x, $y);
		}
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		$results = $db->results;
		$db->close();
		foreach ($results as $r) {
			$this->items[] = new Association($r["service_id"], $r["table_name"], $r["row_id"]);
		}
	}

	function load_by_table($x) {
		$this->items = array();
		$db = new Database();
		$sql = sprintf("select service_id, table_name, row_id from associations where table_name = '%s' order by service_id, row_id", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		$results = $db->results;
		$db->close();
		foreach ($results as $r) {
			$this->items[] = new Association($r["service_id"], $r["table_name"], $r["row_id"]);
		}
	}
}
?>