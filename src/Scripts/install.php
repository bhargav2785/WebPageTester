<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 12/21/14
 * Time: 11:15 PM
 */

date_default_timezone_set('America/Los_Angeles');
require_once dirname(dirname(dirname(__FILE__))) . '/vendor/autoload.php';

use Helpers\CommonHelper;
use Helpers\MongoHelper;
use Helpers\Configs;

$collections = array(
	MongoHelper::DB_COLLECTION_NAME_TESTS,
	MongoHelper::DB_COLLECTION_NAME_TEST_RESULTS,
	MongoHelper::DB_COLLECTION_NAME_TEST_SUMMARIES,
	MongoHelper::DB_COLLECTION_NAME_TEST_REQUESTS
);

$commonHelper = new CommonHelper();
$mongoHelper  = $commonHelper->getMongoObj();

// VALIDATE configs
validateConfigs();

// CONNECT to mongo server
$mongo = $mongoHelper->getMongoInstance();
if ($mongo instanceof MongoClient) {
	echo "connected to the mongo server...\n";
} else {
	echo "could not connect to the mongo server...\n";
	exit(1);
}

// CHECK if db is created or not, if not create one
$dbName = Configs::get('mongodb');
$db     = $mongoHelper->createDb($dbName);
if ($db instanceof MongoDB) {
	echo "database `{$dbName}` created...\n";
} else {
	echo "failed creating the database...\n";
	exit(1);
}

// CHECK if all collections are already created, if not create them
foreach ($collections as $collection) {
	echo "creating collection: `{$collection}`... ";
	$collectionObj = $db->createCollection($collection);
	if ($collectionObj instanceof MongoCollection) {
		echo "done\n";
	} else {
		echo "failed";
		exit(1);
	}
}

// FINISH
echo "installation was successful...\n";

// ##################### functions ##################### //
function validateConfigs() {
	$valid = true;

	$host = Configs::get('mongohost');
	$port = Configs::get('mongoport');
	$db   = Configs::get('mongodb');
	$key  = Configs::get('apikey');

	if (empty($host) || empty($port) || empty($db) || empty($key)) {
		echo "Please check all four(host,port,db,key) values are set in Config.php. Exiting...\n";
		$valid = false;
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