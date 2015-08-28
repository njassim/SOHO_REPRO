<?php
/*
 * (c) 2006 Tim Redman, All Rights Reserved
 * (c) 2003 Matt Wade, Zend Technologies, All Rights Reserved
 * (c) 2002 syberius@tiscali.co.uk
 * $Id: session.class.php,v 1.1 2007/07/12 04:47:06 tredman Exp $
 * Session management wrapper for using a SQL database
 *
 * Original code at http://www.zend.com/zend/spotlight/code-gallery-wade8.php?article=code-gallery-wade8&kind=sl&id=3133&open=1&anc=0&view=1
 * Zend code adapted to use class-based database abstraction.
 *
 * Additions and modifications are allowed as long as this message
 * remains. If you do make changes please contact me at this address.
 *
 * syberius@tiscali.co.uk
 *
 * To inform me of any changes to this file.
 *
 * Create database table with:
 *
 * CREATE TABLE  `session` (
 *   `ses_id` varchar(32) NOT NULL default '',
 *   `ses_time` int(11) NOT NULL default '0',
 *   `ses_start` int(11) NOT NULL default '0',
 *   `ses_value` text NOT NULL,
 *   PRIMARY KEY  (`ses_id`)
 * ) DEFAULT CHARSET=utf8
 */

# define(COOKIE_MAXLIFE, '1800');
 define(GC_MAXLIFE, '3600');
#  
# session_save_path(SESSION_PATH);
 ini_set('session.gc_maxlifetime', GC_MAXLIFE);
# session_set_cookie_params(COOKIE_MAXLIFE, COOKIE_PATH);
# session_start();

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");

$ses_class = new Session();

session_set_save_handler(array(&$ses_class, "_open"),
	array(&$ses_class, "_close"),
	array(&$ses_class, "_read"),
	array(&$ses_class, "_write"),
	array(&$ses_class, "_destroy"),
	array(&$ses_class, "_gc"));

if (isset($_GET["PHPSESSID"])) {
	session_id(substr($_GET["PHPSESSID"], 0, 32));
}

session_start();

class Session
{
	var $db;

	function _open($path, $name)
	{
		$this->db = new Database();
	}

	function _close()
	{
		$this->_gc(0);
		return TRUE;
	}

	function _read($ses_id)
	{
		$sql = sprintf("SELECT * FROM session WHERE ses_id = '%s'", substr($ses_id, 0, 32));
		$this->db->fetchRowObjects($sql, __FILE__, __LINE__, false);
		if ($this->db->rows > 0) {
			return $this->db->results[0]["ses_value"];
		} else {
			return "";
		}
	}

	function _write($ses_id, $data)
	{
		$sql = sprintf("INSERT INTO session (ses_id, ses_time, ses_start, ses_value) " .
			"VALUES ('%s', '%s', '%s', '%s') " .
			"ON DUPLICATE KEY UPDATE ses_time = '%s', ses_value = '%s'",
			substr($ses_id, 0, 32),
			time(),
			time(),
			mysql_real_escape_string($data, $this->db->link),
			time(),
			mysql_real_escape_string($data, $this->db->link));
		$this->db->executeSQL($sql, __FILE__, __LINE__, false);
		return TRUE;
	}

	function _destroy($ses_id)
	{
		$sql = sprintf("DELETE FROM session WHERE ses_id = '%s'", substr($ses_id, 0, 32));
		$this->db->executeSQL($sql, __FILE__, __LINE__, false);
		return TRUE;
	}

	function _gc($life)
	{
		$ses_life = strtotime("-30 minutes");
		$sql = sprintf("DELETE FROM session WHERE ses_time < %s", $ses_life);
		$this->db->executeSQL($sql, __FILE__, __LINE__, false);
		return TRUE;
	}

}
