<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 3/11/15
 * Time: 10:30 PM
 */

namespace Helpers;

use Helpers\MySqlPDO;

class MySqlHelper
{
	public $connection = null;

	/**
	 * @return null|\PDO
	 */
	public function getConnection() {
		if (is_null($this->connection)) {
			$this->connection = MySqlPDO::getInstance();
		}

		return $this->connection;
	}

	/**
	 * @param string $dbname
	 *
	 * @return bool
	 */
	public function databaseExist($dbname) {
		$query     = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$dbname}';";
		$statement = $this->getConnection()->query($query);
		$database  = $statement->fetch(\PDO::FETCH_ASSOC);

		return !empty($database) && $database['SCHEMA_NAME'] === $dbname ? true : false;
	}

	/**
	 * @param $filePath
	 *
	 * @return int
	 */
	public function executeSqlFile($filePath) {
		$query = file_get_contents($filePath);
		$rows  = $this->getConnection()->exec($query);

		return $rows;
	}

	/**
	 * @param $schema
	 *
	 * @return array
	 */
	public function getAllTableNamesFromSchema($schema) {
		$sql       = "show tables from `{$schema}`;";
		$statement = $this->getConnection()->query($sql);
		$rows      = $statement->fetchAll(\PDO::FETCH_ASSOC);

		$tables    = array();
		$schemaKey = "Tables_in_{$schema}";
		foreach ($rows as $key => $row) {
			if (isset($schemaKey)) {
				array_push($tables, $row[$schemaKey]);
			}
		}

		return $tables;
	}
}