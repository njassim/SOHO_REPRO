<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/library/pqp/classes/PhpQuickProfiler.php");
$debug = ($_REQUEST['debug'])? true : false;
class MyPQP{

    private $profiler;
    private $db;
    private $debug;

    public function __construct($debug)
	{
        $this->profiler = new PhpQuickProfiler(PhpQuickProfiler::getMicroTime(), '/library/pqp/');
		$this->debug = $debug;
		$this->db = new MyDB();
    }

    public function __destruct() 
	{
		$tempDB = new tempDB();
		$tempDB->queryCount = MyDB::$queryCount;
		$tempDB->queries = MyDB::$queries;


		//log all the duplicate sql's
		$queries = MyDB::$queries;
		foreach ($queries as $q)
		{
			$sql[] = $q['sql'];
		}
		$dups = array_unique(array_diff_assoc($sql,array_unique($sql)));
		Console::log($dups);

        if ($this->debug) $this->profiler->display($tempDB);
    }

}
class tempDB
{
    public $queryCount = 0;
    public $queries = array();
    function query()
    {
	return false;
    }
}
class MyDB
{
    static $queryCount = 0;
    static $queries = array();

    //static
    static function getTime()
    {
	$time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	$start = $time;
	return $start;
    }

    static function getReadableTime($time)
    {
		$ret = $time;
		$formatter = 0;
		$formats = array('ms', 's', 'm');
		if($time >= 1000 && $time < 60000) {
			$formatter = 1;
			$ret = ($time / 1000);
		}
		if($time >= 60000) {
			$formatter = 2;
			$ret = ($time / 1000) / 60;
		}
		$ret = number_format($ret,3,'.','') . ' ' . $formats[$formatter];
		return $ret;
    }
}
$MyPQP = new MyPQP($debug);
?>
