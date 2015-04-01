<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 12/22/14
 * Time: 1:23 AM
 */

namespace Helpers;

use Helpers\Constants as C;

/**
 * Class DownloadHelper
 *
 * @package Helpers
 */
class DownloadHelper extends CommonHelper
{
	/**
	 * @param int $limit
	 */
	public function processDownload($limit = 100) {
		$unProcessedRequests = $this->getStorageHelperObj()->findAllNotProcessedUrlTests($limit);
		$count               = count($unProcessedRequests);

		if ($unProcessedRequests) {
			$this->__debug(str_repeat("v", 200));
			$this->__debug("Downloading test results ({$count})");
			$this->__debug(str_repeat("^", 200));

			foreach ($unProcessedRequests as $unProcessedRequest) {
				$this->processDocument($unProcessedRequest);
			}
		} else {
			$this->__debug("All documents have been processed already.\n");
		}
	}

	/**
	 * @param array $request
	 */
	public function processDocument(array $request) {
		$testId        = $request[C::REQUEST_PARAM_TEST_ID];
		$jsonUrl       = $request[C::REQUEST_PARAM_JSON_URL];
		$summaryCsvUrl = $request[C::REQUEST_PARAM_SUMMARY_CSV_URL];
		$detailsCsvUrl = $request[C::REQUEST_PARAM_DETAIL_CSV_URL];

		$this->__debug("Processing testId: {$testId}");

		$this->_saveCsvToJsonResult($summaryCsvUrl, $testId, 'summaries');
		$this->_saveCsvToJsonResult($detailsCsvUrl, $testId, 'details');
		$this->_markTestAsProcessed($testId);

		echo PHP_EOL;
	}

	/**
	 * @param $url
	 * @param $testId
	 * @param $type
	 */
	private function _saveCsvToJsonResult($url, $testId, $type) {
		$this->__debug(str_repeat(' ', 5) . "saving `{$type}` result...");
		$json  = $this->getCsvToJson($url);
		$array = json_decode($json, true);

		if ('summaries' === $type) {
			// add index `testid` to the column names
			$array[0][] = C::SUMMARY_PARAM_TEST_ID;

			// somehow values array has one extra index in summary response, replace that with the value of `test-id`
			$array[1][count($array[1]) - 1] = $testId;

			// update `Date` to MySQL format
			$array[1][0] = date("Y-m-d", strtotime($array[1][0]));

			// STORE
			$this->getStorageHelperObj()->saveSummary($array);
		} else if ('details' === $type) {
			foreach ($array as $idx => $httpRequest) {
				if ($idx === 0) {
					// add index `testid` to the column names at the end, replacing duplicate `cached` column
					$array[$idx][count($array[$idx]) - 1] = C::HTTP_REQUEST_PARAM_TEST_ID;
				} else {
					$array[$idx][0] = date("Y-m-d", strtotime($array[$idx][0]));

					// there is an extra `,` at the end of each csv line, except the header line, which creates an extra element :(
					unset($array[$idx][count($array[$idx]) - 1]);

					// add the column value for `testid`
					$array[$idx][count($array[$idx]) - 1] = $testId;
				}
			}

			// STORE
			$this->getStorageHelperObj()->saveHttpRequests($array);
		}
	}

	/**
	 * @param $testId
	 */
	private function _markTestAsProcessed($testId) {
		$updated = $this->getStorageHelperObj()->updateTestToProcessed($testId);
		if ($updated) {
			$this->__debug(str_repeat(' ', 5) . "test with testId: {$testId} marked processed successfully");
		} else {
			$this->__debug(str_repeat(' ', 5) . "test with testId: {$testId} could not be marked processed");
		}
	}

	/**
	 * @param array $response
	 *
	 * @return array
	 */
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

	/**
	 * @param string $file
	 *
	 * @return string
	 */
	public function getCsvToJson($file) {
		$csv = array_map('str_getcsv', file($file));

		return json_encode($csv, true);
	}
}