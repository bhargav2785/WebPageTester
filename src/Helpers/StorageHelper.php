<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 3/28/15
 * Time: 10:31 PM
 */

namespace Helpers;

use Helpers\MySqlHelper;
use Helpers\Constants;

class StorageHelper extends CommonHelper
{
	/**
	 * @param array $requestData
	 *
	 * @return bool|int
	 */
	public function saveRequest(array $requestData) {
		$testParams = $this->getConstantsHelperObj()->getConstantsStartsWith('REQUEST_PARAM');

		$colNames = $values = array();
		foreach ($requestData as $key => $value) {
			if (in_array($key, $testParams)) {
				array_push($colNames, $key);
				array_push($values, "'{$value}'");
			}
		}

		$colNames  = join(',', $colNames);
		$colValues = join(',', $values);

		$sql = <<<SQL
INSERT INTO
	`webpagetest`.`tests`({$colNames})
VALUES
	({$colValues});
SQL;

		try {
			$success = $this->getMysqlObj()->getConnection()->exec($sql);
		} catch (\Exception $e) {
			error_log("ERROR ::  {$e->getMessage()}");
			$success = false;
		}

		return $success;
	}

	/**
	 * @param int $limit
	 *
	 * @return array
	 */
	public function findAllNotProcessedUrlTests($limit = 10) {
		$sql = <<<SQL
SELECT
	*
FROM
	`webpagetest`.`tests`
WHERE
	`processed` = 0
ORDER BY
	`id` DESC
LIMIT
	{$limit};
SQL;

		try {
			$statement = $this->getMysqlObj()->getConnection()->query($sql);
			$rows      = $statement->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\Exception $e) {
			error_log("ERROR ::  {$e->getMessage()}");
			$rows = array();
		}

		return $rows;
	}

	/**
	 * @param array $summary
	 *
	 * @return bool|int
	 */
	public function saveSummary(array $summary) {
		$colsArr   = $summary[0];
		$valuesArr = $summary[1];

		$summaryParams = $this->getConstantsHelperObj()->getConstantsStartsWith('SUMMARY_PARAM');

		$colNames = $values = array();
		foreach ($colsArr as $idx => $colName) {
			$formattedColName = $this->_getCleanColumnName($colName);

			if (in_array($formattedColName, $summaryParams) && !in_array($formattedColName, $colNames)) {
				array_push($colNames, $formattedColName);
				array_push($values, "'{$valuesArr[$idx]}'");
			}
		}

		$colNames  = join(',', $colNames);
		$colValues = join(',', $values);

		$sql = <<<SQL
INSERT INTO
	`webpagetest`.`summary`({$colNames})
VALUES
	({$colValues});
SQL;

		try {
			$success = $this->getMysqlObj()->getConnection()->exec($sql);
		} catch (\Exception $e) {
			error_log("ERROR ::  {$e->getMessage()}");
			$success = false;
		}

		return $success;
	}

	/**
	 * @param array $httpRequests
	 *
	 * @return bool|int
	 */
	public function saveHttpRequests(array $httpRequests) {
		$colsArr = $httpRequests[0];

		// remove the first element(column names array)
		array_shift($httpRequests);

		$httpRequestParams = $this->getConstantsHelperObj()->getConstantsStartsWith('HTTP_REQUEST_PARAM');

		// COLUMN names
		$colNames = array();
		foreach ($colsArr as $idx => $colName) {
			$formattedColName = $this->_getCleanColumnName($colName);

			if (in_array($formattedColName, $httpRequestParams) && !in_array($formattedColName, $colNames)) {
				array_push($colNames, $formattedColName);
			}
		}
		$colNames = join(',', $colNames);

		// COLUMN values
		$tmpColValues = array();
		foreach ($httpRequests as $idx => $httpRequest) {
			$tmpValues = array();
			foreach ($httpRequest as $httpRequestValue) {
				array_push($tmpValues, "'{$httpRequestValue}'");
			}
			array_push($tmpColValues, '(' . join(',', $tmpValues) . ')');
		}
		$colValues = join(',', $tmpColValues);

		$sql = <<<SQL
INSERT INTO
	`webpagetest`.`requests`({$colNames})
VALUES
	{$colValues};
SQL;

		try {
			$success = $this->getMysqlObj()->getConnection()->exec($sql);
		} catch (\Exception $e) {
			error_log("ERROR ::  {$e->getMessage()}");
			$success = false;
		}

		return $success;
	}

	/**
	 * @param $testId
	 *
	 * @return bool|int
	 */
	public function updateTestToProcessed($testId) {
		$sql = <<<SQL
UPDATE
	`webpagetest`.`tests`
SET
	`processed` = 1
WHERE
	`test_id` = '{$testId}'
LIMIT
	1;
SQL;

		try {
			$success = $this->getMysqlObj()->getConnection()->exec($sql);
		} catch (\Exception $e) {
			error_log("ERROR ::  {$e->getMessage()}");
			$success = false;
		}

		return $success;
	}

	/**
	 * @param string $columnName
	 *
	 * @return string
	 */
	private function _getCleanColumnName($columnName) {
		return str_replace(array('(', ')', '-', ' ', '\'', '"'), '', strtolower($columnName));
	}
}