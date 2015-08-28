<?php
/*
 * $Id: config.inc.php,v 1.5 2009/03/05 04:21:09 tredman Exp $
 * Local configuration file
 */

/* Database credentials */
// define("DB_NAME", "db18534_soho");
// define("DB_USER", "db18534");
// define("DB_PASS", "7VcxMsFX");
// define("DB_HOST", "internal-db.s18534.gridserver.com");

define("DB_NAME", "gigantic");
define("DB_USER", "gigantic_admin");
define("DB_PASS", "Dr0iu99#");
define("DB_HOST", "localhost");

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/db.class.php");

$config = new Database();
$sql = "select config_keyword, config_type, config_value from siteconfig";
$config->fetchRowObjects($sql, __FILE__, __LINE__, false);
foreach ($config->results as $r) {
	switch ($r["config_type"]) {
		case "VARCHAR" :
			define($r["config_keyword"], $r["config_value"]);
			break;
		case "BOOLEAN" :
			define($r["config_keyword"], (intval($r["config_value"]) == 1 ? true : false));
			break;
		case "INTEGER" :
			define($r["config_keyword"], intval($r["config_value"]));
			break;
	}
}
$config->close();

?>
