<?php
/*
 * Copyright 2007 Tim Redman, All Rights Reserved
 * $Id: db.class.php,v 1.2 2007/07/16 08:27:28 tredman Exp $
 * Database abstraction
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.inc.php");

class Database {

	var $dbuser;
	var $dbpass;
	var $dbhost;
	var $dbname;
	var $results;
	var $link;
	var $err;
	var $rows;
	var $sql;
	var $last_id;
	
	

	function Database($u = DB_USER, $p = DB_PASS, $h = DB_HOST, $n = DB_NAME, $debug = false) {

		$this->dbuser = $u;
		$this->dbpass = $p;
		$this->dbhost = $h;
		$this->dbname = $n;
		$this->rows = 0;
		$this->sql = "";

		$this->link = @mysql_pconnect($this->dbhost, $this->dbuser, $this->dbpass);

		if ($this->link === FALSE) {

			$this->link = @mysql_connect($this->dbhost, $this->dbuser, $this->dbpass);

			if ($this->link === FALSE) {

				$this->results = NULL;
				$this->err = sprintf("*** Cannot connect to MySQL server. ***\n\n%s\n\n", mysql_error());
				$this->error();

			}

		}

		$tmp = @mysql_select_db($this->dbname, $this->link);

		if ($tmp === FALSE) {

			$this->results = NULL;
			$this->err = sprintf("*** Cannot select the database %s. ***\n\n%s\n\n", $this->dbname, mysql_error());
			$this->error();

		}

		$this->results = array();
		$this->err = sprintf("*** The operation was successful. ***");

		if ($debug) {
			printf("<pre style=\"text-align:left\">");
			print_r($this);
			die("</pre>");
		} else {
			return;
		}

	}

	function fetchRowObjects($sql, $caller = "", $line = 0, $debug = false) {

		$this->results = array();
		$this->sql = $sql;

		if(class_exists('MyDB')) $start = MyDB::getTime();   	    //particletree pqp code
		
		$res = @mysql_query($sql, $this->link);
		
		if(class_exists('MyDB')) MyDB::$queryCount += 1;		    //particletree pqp code
		if(class_exists('MyDB')) $this->logQuery($sql, $start);	    //particletree pqp code

		if ($res === FALSE) {
			$this->results = NULL;
			$this->err = sprintf("*** [%s:%d] Cannot query %s with [%s]. ***\n\n%s\n\n", basename($caller), $line, $this->dbname, $sql, mysql_error());
			$this->error();
		}

		while ($row = @mysql_fetch_assoc($res)) {
			$this->results[] = $row;
		}

		$tmp = @mysql_free_result($res);

		if ($tmp === FALSE) {
			$this->results = NULL;
			$this->err = sprintf("*** [%s:%d] Cannot free MySQL resources. ***\n\n%s\n\n", basename($caller), $line, mysql_error());
			$this->error();
		}

		$this->rows = count($this->results);
		$this->err = sprintf("*** [%s:%d] The operation was successful. ***\n\n", basename($caller), $line);

		if ($debug) {
			printf("<pre style=\"text-align:left\">");
			print_r($this);
			die("</pre>");
		} else {
			return;
		}

	}

	function executeSQL($sql, $caller = "", $line = 0, $debug = false) {

		$this->sql = $sql;
		$this->last_id = 0;

		if(class_exists('MyDB')) $start = MyDB::getTime();   	    //particletree pqp code
		
		$res = @mysql_query($sql, $this->link);

		if(class_exists('MyDB')) MyDB::$queryCount += 1;	    //particletree pqp code
		if(class_exists('MyDB')) $this->logQuery($sql, $start);	    //particletree pqp code

		if ($res === FALSE) {
			$this->results = NULL;
			$this->err = sprintf("*** [%s:%d] Cannot query %s with [%s]. ***\n\n%s\n\n", basename($caller), $line, $this->dbname, $sql, mysql_error());
			$this->error();
		}

		$this->results = array();
		$this->last_id = @mysql_insert_id($this->link);
		$this->rows = @mysql_affected_rows($this->link);

		if ($this->results == -1) {
			$this->results = NULL;
			$this->err = sprintf("*** [%s:%d] The SQL execution failed. ***\n\n%s\n\n", basename($caller), $line, mysql_error());
			$this->error();
		}

		$this->err = sprintf("*** [%s:%d] The operation was successful. ***", basename($caller), $line);

		if ($debug) {
			printf("<pre style=\"text-align:left\">");
			print_r($this);
			die("</pre>");
		} else {
			return;
		}

	}

	function close($debug = false) {

		$tmp = @mysql_close($this->link);

		if ($tmp === FALSE) {
			$this->results = NULL;
			$this->err = sprintf("*** Cannot close MySQL connection. ***\n\n%s\n\n", mysql_error());
			return;
		}

		$this->results = array();
		$this->rows = 0;
		$this->err = sprintf("\n\nThe operation was successful. ***\n\n");

		if ($debug) {
			printf("<pre style=\"text-align:left\">");
			print_r($this);
			die("</pre>");
		} else {
			return;
		}

	}

	function error() {

		printf("*** An error has occurred while processing this page. ***\n\n");
		printf("Some errors may be temporary.  A copy of the error has been forwarded to\n");
		printf("our Internet staff, so that we may work to resolve the problem as soon as possible.\n\n");
		printf("Thank you very much for your cooperation and patience.\n\n");

		$error = "";
		$error .= sprintf("*** An error has occurred while processing a page on the web site. ***\n\n");
		$error .= sprintf("[%s]\n\n", $this->err);

		die(sprintf("<pre>%s</pre>", $error));


 		if (SEND_ERROR) {
 			$this->sendAdminMail($error);
 			die();
		} else {
			die(sprintf("<pre>%s</pre>", $error));
		}

	}

	function sendAdminMail($body) {

		$header = sprintf("From: %s", ADM_EMAIL);
		$to = ADM_EMAIL;
		$subject = "Web Site Error Reporting";

		$res = mail($to, $subject, $body, $header);

		if ($res === TRUE) {
			printf("E-mail sent to %s\n\n", htmlentities($to));
		} else {
			printf("Houston, we have a problem...the E-mail was not sent to the webmaster.\n\n");
		}

	}

	function logQuery($sql, $start) {
		$query = array(
				'sql' => $sql,
				'time' => (MyDB::getTime() - $start)*1000
			);
		array_push(MyDB::$queries, $query);
		//MyDB::$queries[] = $query;
	}

	
	

}

?>
