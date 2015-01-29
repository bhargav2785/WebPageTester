<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 12/21/14
 * Time: 4:10 AM
 */

namespace Helpers;

/**
 * Class Configs
 *
 * @package Helpers
 */
class Configs
{

	private static $configs = array();

	public static function load() {
		$iniFilePath   = realpath(dirname(dirname(__FILE__)) . '/config.ini');
		self::$configs = parse_ini_file($iniFilePath);
	}

	public static function get($key) {
		if (empty(self::$configs)) {
			self::load();
		}

		return isset(self::$configs[$key]) ? self::$configs[$key] : null;
	}

	public function getMongoConnectionConfigs() {
		return array(
			'host' => self::get('mongohost'),
			'port' => self::get('mongoport'),
			'db'   => self::get('mongodb'),
		);
	}

	public function getApiKey() {
		return self::get('apikey');
	}
}