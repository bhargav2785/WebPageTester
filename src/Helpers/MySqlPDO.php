<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 3/11/15
 * Time: 11:32 PM
 */

namespace Helpers;

class MySqlPDO
{
	private static $instance = null;
	private static $mysqlConfigs = null;

	/**
	 * @return null|\PDO
	 */
	public static function getInstance($dbName = null) {
		if (is_null(self::$instance)) {
			$configs = self::_getConfigs();

			$host     = $configs['host'];
			$username = $configs['user'];
			$password = $configs['password'];
			$dbString = is_null($dbName) ? '' : "dbname={$dbName}";

			try {
				self::$instance = new \PDO("mysql:host={$host}{$dbString};charset=utf8", $username, $password);
			} catch (\PDOException $e) {
				$message = $e->getMessage();
				echo $message;
			}
		}

		return self::$instance;
	}

	private static function _getConfigs() {
		if (is_null(self::$mysqlConfigs)) {
			self::$mysqlConfigs = array(
				'host'     => Configs::get('mysqlhost'),
				'port'     => Configs::get('mysqlport'),
				'user'     => Configs::get('mysqluser'),
				'password' => Configs::get('mysqlpassword'),
				'db'       => Configs::get('mysqldb'),
			);
		}

		return self::$mysqlConfigs;
	}
}