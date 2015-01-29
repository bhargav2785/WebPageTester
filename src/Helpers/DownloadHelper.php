<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 12/22/14
 * Time: 1:23 AM
 */

namespace Helpers;

/**
 * Class DownloadHelper
 *
 * @package Helpers
 */
class DownloadHelper extends CommonHelper
{
	public function processDownload($limit = 100) {
		$cursor = $this->getMongoObj()->findAllNotProcessedUrlResponses();
		$count  = $cursor->count();

		if ($count) {
			$this->__debug(str_repeat("v", 200));
			$this->__debug("Downloading test results ({$count})");
			$this->__debug(str_repeat("^", 200));

			foreach ($cursor as $doc) {
				$this->processDocument($doc);
			}
		} else {
			$this->__debug("All documents have been processed already.\n");
		}
	}

	public function processDocument(array $doc) {
		if (!isset($doc['data'])) {
			$this->__debug("No data attribute found, skipping...");

			return false;
		}

		$testId        = $doc['data']['testId'];
		$jsonUrl       = $doc['data']['jsonUrl'];
		$summaryCsvUrl = $doc['data']['summaryCSV'];
		$detailsCsvUrl = $doc['data']['detailCSV'];

		$this->__debug("Processing testId: {$testId}");

		$this->_saveJsonResult($jsonUrl, $testId);
		$this->_saveCsvToJsonResult($summaryCsvUrl, $testId, 'summaries');
		$this->_saveCsvToJsonResult($detailsCsvUrl, $testId, 'details');
		$this->_markDocumentAsProcessed($testId);

		echo PHP_EOL;
	}

	private function _saveJsonResult($jsonUrl, $testId) {
		$this->__debug(str_repeat(' ', 5) . "saving `full` result...");
		$json  = file_get_contents($jsonUrl);
		$array = json_decode($json, true);

		$response = array(
			'results' => $this->_stripExtraJsonData($array),
			'testId'  => $testId
		);

		$this->getMongoObj()->saveTestResultsDocument($response);
	}

	private function _saveCsvToJsonResult($url, $testId, $type) {
		$this->__debug(str_repeat(' ', 5) . "saving `{$type}` result...");
		$json     = $this->getCsvToJson($url);
		$array    = json_decode($json, true);
		$response = array(
			'results' => $array,
			'testId'  => $testId
		);

		if ('summaries' === $type) {
			$this->getMongoObj()->saveTestSummariesDocument($response);
		} else if ('details' === $type) {
			$this->getMongoObj()->saveTestDetailsDocument($response);
		}
	}

	private function _markDocumentAsProcessed($testId) {
		$updated = $this->getMongoObj()->markUrlResponsesDocumentAsProcessed($testId);
		if ($updated['ok']) {
			$this->__debug(str_repeat(' ', 5) . "test with testId: {$testId} marked processed successfully");
		} else {
			$this->__debug(str_repeat(' ', 5) . "test with testId: {$testId} could not be marked processed");
		}
	}

	private function _stripExtraJsonData(array $response) {
		$filtered = $response;

		$runs        = &$filtered['data']['runs'];
		$medianViews = &$filtered['data']['median'];

		foreach ($runs as $key => &$runViews) {
			if (isset($runViews['firstView'])) {
				$this->__debug(str_repeat(' ', 10) . "removing `requests` from firstView of run:{$key} ...");
				$requestCount                          = count($runViews['firstView']['requests']);
				$runViews['firstView']['requests']     = null;
				$runViews['firstView']['requestCount'] = $requestCount;
			}

			if (isset($runViews['repeatView'])) {
				$this->__debug(str_repeat(' ', 10) . "removing `requests` from repeatView of run:{$key} ...");
				$requestCount                           = count($runViews['repeatView']['requests']);
				$runViews['repeatView']['requests']     = null;
				$runViews['repeatView']['requestCount'] = $requestCount;
			}
		}

		foreach ($medianViews as $name => &$medianView) {
			$this->__debug(str_repeat(' ', 10) . "removing `requests` from {$name} of median...");
			$requestCount               = count($medianView['requests']);
			$medianView['requests']     = null;
			$medianView['requestCount'] = $requestCount;
		}

		return $filtered;
	}

	public function getCsvToJson($file) {
		$csv = array_map('str_getcsv', file($file));

		return json_encode($csv, true);
	}
}