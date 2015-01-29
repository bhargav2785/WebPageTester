<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 12/21/14
 * Time: 4:07 AM
 */

namespace Helpers;

use Helpers\Configs;

/**
 * Class MongoHelper
 *
 * @package Helpers
 */
class MongoHelper
{
	const DB_COLLECTION_NAME_TESTS = 'tests';
	const DB_COLLECTION_NAME_TEST_RESULTS = 'results';
	const DB_COLLECTION_NAME_TEST_SUMMARIES = 'summaries';
	const DB_COLLECTION_NAME_TEST_REQUESTS = 'requests';

	private $mongoInstance = null;
	private $mongoConfigs = null;

	/**
	 * @param string $dbName
	 *
	 * @return \MongoDB
	 */
	public function createDb($dbName) {
		return $this->getMongoInstance()->selectDB($dbName);
	}

	/**
	 * @param \MongoDB $dbName
	 * @param string   $collectionName
	 *
	 * @return \MongoCollection
	 */
	public function getCollection(\MongoDB $dbName, $collectionName) {
		return new \MongoCollection($dbName, $collectionName);
	}

	public function saveTest(array $response) {
		$this->_saveCollectionDocument(self::DB_COLLECTION_NAME_TESTS, $response);
	}

	/**
	 * @return \MongoClient|null
	 */
	public function getMongoInstance() {
		if (is_null($this->mongoInstance)) {
			$configs             = $this->_getMongoConfigs();
			$host                = $configs['host'];
			$port                = $configs['port'];
			$this->mongoInstance = new \MongoClient("mongodb://{$host}:{$port}");
		}

		return $this->mongoInstance;
	}

	public function findAllNotProcessedUrlResponses() {
		$configs    = $this->_getMongoConfigs();
		$mongo      = $this->getMongoInstance();
		$db         = $mongo->selectDB($configs['db']);
		$collection = $this->getCollection($db, 'tests');

		$dataSubQuery = array(
			'data' => array('$exists' => true)
		);

		$requestTimeSubQuery = array(
			'requestTime' => array('$exists' => true)
		);

		$processedSubQuery = array(
			'processed' => array(
				'$exists' => true,
				'$in'     => array(false)
			)
		);

		$query = array(
			'$and' => array($dataSubQuery, $requestTimeSubQuery, $processedSubQuery)
		);

		return $collection->find($query);
	}

	public function saveTestResultsDocument(array $results) {
		$this->_saveCollectionDocument(self::DB_COLLECTION_NAME_TEST_RESULTS, $results);
	}

	public function saveTestSummariesDocument(array $results) {
		$this->_saveCollectionDocument(self::DB_COLLECTION_NAME_TEST_SUMMARIES, $results);
	}

	public function saveTestDetailsDocument(array $results) {
		$this->_saveCollectionDocument(self::DB_COLLECTION_NAME_TEST_REQUESTS, $results);
	}

	/**
	 * @param string $collectionName
	 * @param array  $data
	 */
	private function _saveCollectionDocument($collectionName, array $data) {
		$configs    = $this->_getMongoConfigs();
		$mongo      = $this->getMongoInstance();
		$db         = $mongo->selectDB($configs['db']);
		$collection = $this->getCollection($db, $collectionName);

		$collection->insert($data);
	}

	/**
	 * @param string|mixed $testId
	 *
	 * @return bool
	 */
	public function markUrlResponsesDocumentAsProcessed($testId) {
		$configs    = $this->_getMongoConfigs();
		$mongo      = $this->getMongoInstance();
		$db         = $mongo->selectDB($configs['db']);
		$collection = $this->getCollection($db, 'tests');

		$query   = array("data.testId" => $testId);
		$updates = array(
			'$set' => array(
				'processed'  => true,
				'updateTime' => new \MongoDate()
			)
		);
		$options = array(
			'upsert'   => false,
			'multiple' => false,
			'w'        => 1
		);

		return $collection->update($query, $updates, $options);
	}

	/**
	 * @return array|null
	 */
	private function _getMongoConfigs() {
		if (is_null($this->mongoConfigs)) {
			$configs            = new Configs();
			$this->mongoConfigs = $configs->getMongoConnectionConfigs();
		}

		return $this->mongoConfigs;
	}
}