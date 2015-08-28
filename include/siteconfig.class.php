<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: siteconfig.class.php,v 1.1 2007/07/30 02:23:56 tredman Exp $
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");

class SiteConfig
{
	var $config_keyword;
	var $config_type;
	var $config_value;
	var $config_descr;

	function SiteConfig($x = "")
	{
		$this->config_keyword = "";
		$this->config_type = "";
		$this->config_value = "";
		$this->config_descr = "";
		if ($x != "") {
			$this->load($x);
		}
	}

	function load($x)
	{
		$db = new Database();
		$sql = sprintf("select config_keyword, config_type, config_value, config_descr from siteconfig where config_keyword = '%s'", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->config_keyword = stripslashes($r["config_keyword"]);
			$this->config_type = stripslashes($r["config_type"]);
			$this->config_value = stripslashes($r["config_value"]);
			$this->config_descr = stripslashes($r["config_descr"]);
		}
		$db->close();
	}
	function save()
	{
		$db = new Database();
		$sql = sprintf("update siteconfig set config_value = '%s' where config_keyword = '%s'", $this->config_value, $this->config_keyword);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}

}
class SiteConfigs
{
	var $items;

	function SiteConfigs($arr = array())
{	
		$this->items = array();
		if (is_array($arr)) {
			if (count($arr) == 0) {
				$db = new Database();
				$sql = "select config_keyword from siteconfig order by config_keyword";
				$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
				foreach ($db->results as $r) {
					$arr[] = $r["config_keyword"];
				}
				$db->close();
			}
			foreach ($arr as $a) {
				$this->items[] = new SiteConfig($a);
			}
		} else {
			$this->items[] = new SiteConfig($arr);
		}
	}
}
?>