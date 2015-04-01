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
	private $dbName = null;

	/**
	 * @param null $dbName
	 */
	public function __construct($dbName = null) {
		$this->dbName = $dbName;
	}

	/**
	 * @return null|\PDO
	 */
	public function getConnection() {
		if (is_null($this->connection)) {
			$this->connection = MySqlPDO::getInstance($this->dbName);
		}

		return $this->connection;
	}

	public function resetConnection() {
		$this->connection = null;
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
		$tables    = $statement->fetchAll(\PDO::FETCH_COLUMN);

		return $tables;
	}
}