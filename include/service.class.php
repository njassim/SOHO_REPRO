<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: service.class.php,v 1.3 2009-11-08 07:27:57 tredman Exp $
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");

class Service
{
	var $id;
	var $title;
	var $subtitle;
	var $cols;
	var $points;
	var $content;
	var $icon_image;
	var $contact_email;

	function Service($x = 0)
	{
		$id = 0;
		$title = "";
		$subtitle = "";
		$cols = "";
		$points = "";
		$content = "";
		$icon_image = "";
		$contact_email = "";
		if ($x > 0) {
			$this->load($x);
		}
	}

	function load($x = 0)
	{
		$db = new Database();
		$sql = sprintf("select id, title, subtitle, cols, points, content, icon_image, contact_email from services where id = %d", $x);
		$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		foreach ($db->results as $r) {
			$this->id = intval($r["id"]);
			$this->title = stripslashes($r["title"]);
			$this->subtitle = stripslashes($r["subtitle"]);
			$this->cols = intval($r["cols"]);
			$this->points = stripslashes($r["points"]);
			$this->content = stripslashes($r["content"]);
			$this->icon_image = stripslashes($r["icon_image"]);
			$this->contact_email = stripslashes($r["contact_email"]);
		}
	}

	function save()
	{
		$db = new Database();
		if ($this->id > 0) {
			$sql = sprintf("insert into services (id, title, subtitle, cols, points, content, icon_image, contact_email) " .
				"values (%d, '%s', '%s', %d, '%s', '%s', '%s', '%s') " .
				"on duplicate key update title = '%s', subtitle = '%s', cols = %d, points = '%s', content = '%s', icon_image = '%s', " .
				"contact_email = '%s'",
				$this->id,
				mysql_real_escape_string(strip_tags($this->title)),
				mysql_real_escape_string(strip_tags($this->subtitle)),
				intval($this->cols),
				mysql_real_escape_string($this->points),
				mysql_real_escape_string($this->content),
				mysql_real_escape_string(strip_tags($this->icon_image)),
				mysql_real_escape_string(strip_tags($this->contact_email)),
				mysql_real_escape_string(strip_tags($this->title)),
				mysql_real_escape_string(strip_tags($this->subtitle)),
				intval($this->cols),
				mysql_real_escape_string($this->points),
				mysql_real_escape_string($this->content),
				mysql_real_escape_string(strip_tags($this->icon_image)),
				mysql_real_escape_string(strip_tags($this->contact_email)));
		} else {
			$sql = sprintf("insert into services (title, subtitle, cols, points, content, icon_image, contact_email) " .
				"values ('%s', '%s', %d, '%s', '%s', '%s')",
				mysql_real_escape_string(strip_tags($this->title)),
				mysql_real_escape_string(strip_tags($this->subtitle)),
				intval($this->cols),
				mysql_real_escape_string($this->points),
				mysql_real_escape_string($this->content),
				mysql_real_escape_string(strip_tags($this->icon_image)),
				mysql_real_escape_string(strip_tags($this->contact_email)));
		}
		$db->executeSQL($sql, __FILE__, __LINE__, false);
	}

	function delete()
	{
		$db = new Database();
		$sql = sprintf("delete from services where id = %d", $this->id);
		$db->executeSQL($sql, __FILE__, __LINE__, false);
		$db->close();
	}
}


class Services
{
	var $items;

	function Services($arr = array())
	{
		$this->items = array();
		if (is_array($arr)) {
			if (count($arr) == 0) {
				$db = new Database();
				$sql = "select id from services order by title";
				$db->fetchRowObjects($sql, __FILE__, __LINE__, false);
				foreach ($db->results as $r) {
					$arr[] = $r["id"];
				}
				$db->close();
			}
			foreach ($arr as $a) {
				$this->items[] = new Service($a);
			}
		} else {
			$this->items[] = new Service($arr);
		}
	}

}
?>