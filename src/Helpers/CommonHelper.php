<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 12/23/14
 * Time: 12:40 AM
 */

namespace Helpers;

use Helpers\TestOptions;
use Helpers\JsonSchemaHelper;
use Helpers\DownloadHelper;
use Helpers\MySqlHelper;
use Helpers\StorageHelper;
use Helpers\Constants;

/**
 * Class CommonHelper
 *
 * @package Helpers
 */
class CommonHelper
{
	const URL_FILE_PATH_EXTENSION = 'txt';

	private $debug = true;
	protected $testOptionsObj = null;
	protected $mysqlObj = null;
	protected $jsonSchemaHelperObj = null;
	protected $downloadHelperObj = null;
	protected $storageHelperObj = null;
	protected $constantsHelperObj = null;

	/**
	 * @param $path
	 *
	 * @return array
	 */
	public function getParsedRows($path) {
		$isUrl   = filter_var($path, FILTER_VALIDATE_URL);
		$urlRows = array();

		if ($isUrl) {
			$contents = trim(file_get_contents($path));
			$pathInfo = pathinfo($path);
			if (false === $contents || self::URL_FILE_PATH_EXTENSION !== $pathInfo['extension']) {
				$this->__debug("'{$path}' is not a valid .txt url path or it is empty. Please check the url. Skipping ...\n");
			} else {
				$urlRows = explode(PHP_EOL, $contents);
			}
		} else {
			$realPath   = realpath($path);
			$isReadable = is_readable($realPath);
			if (false === $realPath || !$isReadable) {
				$currentPath = trim(`pwd`);
				$this->__debug("'{$path}' is not a valid file path from '{$currentPath}' directory. Absolute path is highly recommended. Skipping ...\n");
			} else {
				$urlRows = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			}
		}

		return $urlRows;
	}

	/**
	 * @param $line
	 *
	 * @return array|bool
	 */
	public function getProcessedUrlRow($line) {
		$itemSeparator = Configs::get('file.test.separator');
		$parts         = explode($itemSeparator, $line);
		$count         = count($parts);
		$url           = '';
		$options       = array();
		$specFilePath  = null;

		// Invalid row
		if ($count > 3) {
			$this->__debug("The line should have at max 3 `{$itemSeparator}` characters.");

			return false;
		} else if ($count == 3) {
			// Valid row with 1) `url` 2) `options` and 3) `spec file path`
			$url             = $parts[0];
			$delimitedParams = $parts[1];
			$specFilePath    = $parts[2];
			$paramParts      = explode(',', $delimitedParams);

			foreach ($paramParts as $paramPart) {
				$singleParamParts = explode('=', $paramPart);
				if (count($singleParamParts) == 2) {
					$options[$singleParamParts[0]] = $singleParamParts[1];
				} else {
					$this->__debug("The param '{$singleParamParts[0]}' does not look right, please check it.");

					return false;
				}
			}
		} else if ($count == 2) {
			// Valid row with 1) `url` 2) `options`
			$url             = $parts[0];
			$delimitedParams = $parts[1];
			$specFilePath    = null;
			$paramParts      = explode(',', $delimitedParams);

			foreach ($paramParts as $paramPart) {
				$singleParamParts = explode('=', $paramPart);
				if (count($singleParamParts) == 2) {
					$options[$singleParamParts[0]] = $singleParamParts[1];
				} else {
					$this->__debug("The param `{$singleParamParts[0]}` does not look right, please check it.");

					return false;
				}
			}
		} else if ($count == 1) {
			// Valid row with `url` only
			$url          = $parts[0];
			$options      = array();
			$specFilePath = null;
		}

		return array(
			'url'          => $url,
			'options'      => $options,
			'specFilePath' => $specFilePath
		);
	}

	/**
	 * @param $message
	 */
	final public function __debug($message) {
		if ($this->debug) {
			echo "\n$message";
		}
	}

	// ######################### Getter/Setter ######################### //

	/**
	 * @return TestOptions
	 */
	public function getTestOptionsObj() {
		if (is_null($this->testOptionsObj)) {
			$this->setTestOptionsObj(new TestOptions());
		}

		return $this->testOptionsObj;
	}

	/**
	 * @param TestOptions $testOptionsObj
	 */
	public function setTestOptionsObj($testOptionsObj) {
		$this->testOptionsObj = $testOptionsObj;
	}

	/**
	 * @return JsonSchemaHelper
	 */
	public function getJsonSchemaHelperObj() {
		if (is_null($this->jsonSchemaHelperObj)) {
			$this->setJsonSchemaHelperObj(new JsonSchemaHelper());
		}

		return $this->jsonSchemaHelperObj;
	}

	/**
	 * @param JsonSchemaHelper $jsonSchemaHelperObj
	 */
	public function setJsonSchemaHelperObj($jsonSchemaHelperObj) {
		$this->jsonSchemaHelperObj = $jsonSchemaHelperObj;
	}

	/**
	 * @return DownloadHelper
	 */
	public function getDownloadHelperObj() {
		if (is_null($this->downloadHelperObj)) {
			$this->setDownloadHelperObj(new DownloadHelper());
		}

		return $this->downloadHelperObj;
	}

	/**
	 * @param DownloadHelper $downloadHelperObj
	 */
	public function setDownloadHelperObj($downloadHelperObj) {
		$this->downloadHelperObj = $downloadHelperObj;
	}

	/**
	 * @return null|MySqlHelper
	 */
	public function getMysqlObj() {
		if (is_null($this->mysqlObj)) {
			$this->setMysqlObj(new MySqlHelper());
		}

		return $this->mysqlObj;
	}

	/**
	 * @param MySqlHelper $mysqlObj
	 */
	public function setMysqlObj($mysqlObj) {
		$this->mysqlObj = $mysqlObj;
	}

	/**
	 * @return StorageHelper
	 */
	public function getStorageHelperObj() {
		if (is_null($this->storageHelperObj)) {
			$this->setStorageHelperObj(new StorageHelper());
		}

		return $this->storageHelperObj;
	}

	/**
	 * @param StorageHelper $storageHelperObj
	 */
	public function setStorageHelperObj($storageHelperObj) {
		$this->storageHelperObj = $storageHelperObj;
	}

	/**
	 * @return Constants
	 */
	public function getConstantsHelperObj() {
		if (is_null($this->constantsHelperObj)) {
			$this->setConstantsHelperObj(new Constants());
		}

		return $this->constantsHelperObj;
	}

	/**
	 * @param Constants $constantsHelperObj
	 */
	public function setConstantsHelperObj($constantsHelperObj) {
		$this->constantsHelperObj = $constantsHelperObj;
	}
} 