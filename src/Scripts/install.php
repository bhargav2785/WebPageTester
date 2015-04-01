<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 12/21/14
 * Time: 11:15 PM
 */

require_once '__init.script.php';

use Helpers\CommonHelper;
use Helpers\MySqlHelper;
use Helpers\Configs;

$commonHelper = new CommonHelper();
$mysqlHelper  = $commonHelper->getMysqlObj();

// VALIDATE configs
validateConfigs();

// CONNECT to mysql server
$connection = $mysqlHelper->getConnection();
if ($connection instanceof \PDO) {
	echo "connected to the mysql server...\n";
} else {
	echo "could not connect to the mysql server...\n";
	exit(1);
}

// CHECK if db already exist
$dbName = Configs::get('mysqldb');
if ($mysqlHelper->databaseExist($dbName)) {
	echo "database already exist...\n";
	exit(1);
}

// CREATE database
$sqlFilePath = SCRIPTS_PATH . '/webpagetest.sql';
$success     = $mysqlHelper->executeSqlFile($sqlFilePath);
if (false !== $success) {
	echo "database `{$dbName}` created...\n";
} else {
	echo "failed creating the database...\n";
	exit(1);
}

// CHECK if all tables are created
$tableNameTests    = 'tests';
$tableNameSummary  = 'summary';
$tableNameRequests = 'requests';
$tables            = $mysqlHelper->getAllTableNamesFromSchema($dbName);
$allTablesCreated  = in_array($tableNameTests, $tables);
$allTablesCreated  = $allTablesCreated && in_array($tableNameSummary, $tables);
$allTablesCreated  = $allTablesCreated && in_array($tableNameRequests, $tables);

// FINISH
if ($allTablesCreated) {
	echo "installation was successful...\n";
} else {
	echo "installation was partial... Some tables could not be created...\n";
}


// ##################### functions ##################### //
function validateConfigs() {
	$valid = true;

	$host    = Configs::get('mysqlhost');
	$user    = Configs::get('mysqluser');
	$port    = Configs::get('mysqlport');
	$db      = Configs::get('mysqldb');
	$key     = Configs::get('apikey');
	$wptHost = Configs::get('wpt.host');

	if (empty($host) || empty($port) || empty($db) || empty($user) || empty($wptHost)) {
		echo "Please check all five(host,port,db,user,wpt.host) values are set in Config.php. Exiting...\n";
		$valid = false;
	} else if (empty($key) && $wptHost === 'http://www.webpagetest.org') {
		echo "`key` is required for public WPT instance(http://www.webpagetest.org). Exiting...\n";
	} else {
		echo str_pad("Host: ", 6, " ", STR_PAD_LEFT) . $host . "\n";
		echo str_pad("Port: ", 6, " ", STR_PAD_LEFT) . $port . "\n";
		echo str_pad("Db: ", 6, " ", STR_PAD_LEFT) . $db . "\n";
		echo str_pad("Key: ", 6, " ", STR_PAD_LEFT) . $key . "\n";

		$answer = readline("\nPlease confirm the details above. Are those correct?(y/n): ");

		if (strtolower($answer) === 'y' || strtolower($answer) === 'yes') {
			echo "starting the installation...\n";
			$valid = true;
		} else {
			echo "exiting...\n";
			$valid = false;
		}
	}

	if (!$valid) {
		exit(1);
	}
}