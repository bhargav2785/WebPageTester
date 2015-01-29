<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 12/21/14
 * Time: 1:48 AM
 */

date_default_timezone_set('America/Los_Angeles');

require_once dirname(dirname(__FILE__)) . '/vendor/autoload.php';

use Helpers\CommonHelper;
use Helpers\SpecHelper;

/**
 * Class WebPageTester
 */
class WebPageTester extends CommonHelper
{
	protected $key = null;
	private $needToSave = false;
	private $needToCheck = false;
	private $needToDownload = false;
	private $responsesByTestId = array();
	protected $specHelperObj = null;
	protected $c = 200;

	/**
	 * @param null $key
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct($key = null) {
		if (is_null($key)) {
			throw new InvalidArgumentException("`key` can not be empty|null. Please use your API key.");
		}

		$this->key = $key;
	}

	/**
	 * @param string $url          The url to be tested
	 * @param array  $options      Options for the test
	 * @param null   $specFilePath Path to the spec file for json-schema validation
	 *
	 * Validates the url and options. If all good, makes a WPT request and stores the initial response if required.
	 */
	final public function testUrl($url, array $options = array(), $specFilePath = null) {
		if (empty($url)) {
			throw new InvalidArgumentException("`url` can not be empty|null");
		}

		$this->__debug("Testing url: {$url}");

		$options['k']   = $this->key;
		$options['url'] = $url;

		if ($this->getTestOptionsObj()->isValidRequest($url, $options)) {
			$this->getTestOptionsObj()->setUrlOptions($options);
			$response                 = $this->getTestOptionsObj()->requestTestUrl();
			$response['specFilePath'] = $specFilePath;
			$this->_saveResponseForLater($response);

			if ($this->getNeedToSave()) {
				$this->_saveTest($response);
				$this->__debug("Test saved successfully.");
				$this->__debug(str_repeat("-", $this->c));
			} else {
				$this->__debug("Test requested successfully.");
			}
		} else {
			$this->__debug("Request was not validated, exiting...");
		}
	}

	/**
	 * @param string $file URL or a path for the file
	 *
	 * Reads the URL or file path which contains a list of test URLs, their options and a spec file path for each URL.
	 * Internally calls the testUrl() function.
	 */
	final public function testFile($file) {
		$this->__debug(PHP_EOL . str_repeat("=", $this->c));
		$this->__debug("Parsing the urls file: '{$file}'");
		$this->__debug(str_repeat("=", $this->c));
		$urlRows = $this->getParsedRows($file);

		if (empty($urlRows)) {
			return false;
		}

		foreach ($urlRows as $urlRow) {
			$this->__debug(PHP_EOL . str_repeat("-", $this->c));
			$this->__debug("Parsing line: '{$urlRow}'");
			if (false !== ($data = $this->getProcessedUrlRow($urlRow))) {
				$this->testUrl($data['url'], $data['options'], $data['specFilePath']);
			} else {
				$this->__debug("row '{$urlRow}' failed in parsing. Skipping it ...");
			}
		}
	}

	/**
	 * @param string $path URL or a path for the file
	 *
	 * Reads the URL or file path which contains a list of files/urls each of those contains a multiple test URLs.
	 * Internally calls the testFile() function.
	 */
	final public function testMasterFile($path) {
		$this->__debug(str_repeat("*", $this->c));
		$this->__debug("Parsing the master file at: '{$path}'");
		$this->__debug(str_repeat("*", $this->c));
		$rows = $this->getParsedRows($path);

		if (empty($rows)) {
			$this->__debug("All entries in master file at: '{$path}' are invalid. Please check them and try again.");

			return false;
		}

		foreach ($rows as $row) {
			$this->testFile($row);
		}
	}

	/**
	 * @param array $results
	 *
	 * Wrapper around database save action for the results
	 */
	private function _saveTest(array $results) {
		$this->getMongoObj()->saveTest($results);
	}

	/**
	 * @param array $response
	 *
	 * Cache the response locally for later use
	 */
	private function _saveResponseForLater(array $response) {
		if (!empty($response['data']['testId'])) {
			$testId                           = $response['data']['testId'];
			$this->responsesByTestId[$testId] = $response;
		}
	}

	/**
	 * Checks whether the validation needs to be performed or not. If yes, start the validation process.
	 */
	public function validateResponseCriteria() {
		if (!$this->getNeedToCheck()) {
			$this->__debug("Skipping the response validation check.");

			return true;
		}

		$responses     = $this->getResponsesByTestId();
		$responseCount = count($responses);

		$this->__debug(PHP_EOL . str_repeat("~", $this->c));
		$this->__debug("Begin verification process...({$responseCount})");
		$this->__debug(str_repeat("~", $this->c));

		foreach ($responses as $testId => $testResponse) {
			$this->__debug("Checking the status of testId: {$testId}");
			$this->_validateResponseByTestId($testId);
		}

		$this->__debug("Response validation check done.\n\n");
	}

	/**
	 * @param int $limit
	 *
	 * Download results into the database for future use
	 *
	 * @return bool
	 */
	public function downloadResults($limit = 100) {
		if (!$this->getNeedToDownload()) {
			$this->__debug("Skipping the response download.\n");

			return true;
		}
		$this->getDownloadHelperObj()->processDownload($limit);
	}

	/**
	 * @param mixed $testId
	 *
	 * Validates a response against json-schema validator. After submitting the WPT request, the test could be in any
	 * three following states
	 *  1) $code >= 100 && $code < 200  ---> test is still pending
	 *  2) $code >= 200 && $code < 400  ---> test is finished, result is ready
	 *  3) $code >= 400                 ---> test is error'ed out
	 */
	private function _validateResponseByTestId($testId) {
		$statusResponse = $this->getTestOptionsObj()->getStatusByTestId($testId);
		$code           = $statusResponse['statusCode'];

		if ($code >= 100 && $code < 200) {
			$this->_handleValidationForRunningTest($code, $testId);
		} else if ($code >= 200 && $code < 400) {
			$this->_handleValidationForFinishedTest($code, $testId);
		} else if ($code >= 400) {
			$this->_handleValidationForFailedTest($code, $testId);
		} else {
			$this->__debug("Could not recognize the statusCode: ({$code}), skipping ...");
		}
	}

	/**
	 * @param \StdClass $response
	 *
	 * CONVERT data.runs into array from object because that's how it should be otherwise Jsv4 fails
	 */
	private function _translateRunsFromObjectToArray(StdClass &$response) {
		$response->data->runs = (array)$response->data->runs;
	}

	/**
	 * @param integer $code
	 * @param mixed   $testId
	 *
	 * Test is still pending, wait for $sleepTime seconds and then poll it again for new status
	 */
	private function _handleValidationForRunningTest($code, $testId) {
		$sleepTime = 5;
		$this->__debug(str_repeat(' ', 5) . "Test is still pending({$code}). Retrying in {$sleepTime} seconds...");
		sleep($sleepTime);
		$this->_validateResponseByTestId($testId);
	}

	/**
	 * @param integer $code
	 * @param mixed   $testId
	 *
	 * Test is finished. Get the results and compare it against the json-schema validator. This is also called
	 * performance budget validation and can be hooked up with CI tools like Jenkins etc.
	 */
	private function _handleValidationForFinishedTest($code, $testId) {
		$this->__debug(str_repeat(' ', 5) . "Test execution finished({$code}).");
		$this->__debug(str_repeat(' ', 10) . "Now validating the response.");
		$responsesByIds = $this->getResponsesByTestId();
		$testResponse   = $responsesByIds[$testId];

		$jsonUrl        = $testResponse['data']['jsonUrl'];
		$apiResponseObj = json_decode(file_get_contents($jsonUrl));
		$this->_translateRunsFromObjectToArray($apiResponseObj);

		$specFile = $testResponse['specFilePath'];
		$isUrl    = filter_var($specFile, FILTER_VALIDATE_URL);

		$schemaJsonResponse = '';
		if ($isUrl) {
			$schemaJsonResponse = file_get_contents($specFile);
		} else {
			$realPath   = realpath($specFile);
			$isReadable = is_readable($realPath);
			if (false === $realPath || !$isReadable) {
				$currentPath = trim(`pwd`);
				$this->__debug(str_repeat(' ', 5) . "'{$specFile}' is not a valid file path from '{$currentPath}' directory. Absolute path is highly recommended. Skipping ...");

				return false;
			} else {
				$schemaJsonResponse = file_get_contents($realPath);
			}
		}
		$schemaResponseObj = json_decode($schemaJsonResponse);

		// RUN the json-schema validator through the Jsv4 library
		$results = $this->getJsonSchemaHelperObj()->validate($apiResponseObj, $schemaResponseObj);

		if ($results['isValid']) {
			$this->__debug(str_repeat(' ', 15) . "Test validated successfully ...");
		} else {
			$errors = $results['errors'];
			$this->__debug(str_repeat(' ', 15) . "Test validation FAILED with results: ");
			$this->__debug(str_repeat(' ', 15) . json_encode($errors, JSON_UNESCAPED_SLASHES));
		}
	}

	/**
	 * @param integer $code
	 * @param mixed   $testId
	 *
	 * The test failed on WPT server, show the related status code.
	 */
	private function _handleValidationForFailedTest($code, $testId) {
		$this->__debug(str_repeat(' ', 5) . "Test failed({$code}), skipping ...");
	}

	// ######################### Getter/Setter ######################### //

	/**
	 * @return boolean
	 */
	public function getNeedToCheck() {
		return $this->needToCheck;
	}

	/**
	 * @param boolean $needToCheck
	 */
	public function setNeedToCheck($needToCheck) {
		$this->needToCheck = $needToCheck;
	}

	/**
	 * @return boolean
	 */
	public function getNeedToSave() {
		return $this->needToSave;
	}

	/**
	 * @param boolean $needToSave
	 */
	public function setNeedToSave($needToSave) {
		$this->needToSave = $needToSave;
	}

	/**
	 * @return array
	 */
	public function getResponsesByTestId() {
		return $this->responsesByTestId;
	}

	/**
	 * @return SpecHelper
	 */
	public function getSpecHelperObj($path) {
		if (is_null($this->specHelperObj)) {
			$this->setSpecHelperObj(new SpecHelper($path));
		}

		return $this->specHelperObj;
	}

	/**
	 * @param SpecHelper $specHelperObj
	 */
	public function setSpecHelperObj($specHelperObj) {
		$this->specHelperObj = $specHelperObj;
	}

	/**
	 * @return boolean
	 */
	public function getNeedToDownload() {
		return $this->needToDownload;
	}

	/**
	 * @param boolean $needToDownload
	 */
	public function setNeedToDownload($needToDownload) {
		$this->needToDownload = $needToDownload;
	}
}