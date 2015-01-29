<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 12/23/14
 * Time: 12:40 AM
 */

namespace Helpers;

use Helpers\TestOptions;
use Helpers\MongoHelper;
use Helpers\JsonSchemaHelper;
use Helpers\DownloadHelper;

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
	protected $mongoObj = null;
	protected $jsonSchemaHelperObj = null;
	protected $downloadHelperObj = null;

	public function getParsedRows($path) {
		$isUrl   = filter_var($path, FILTER_VALIDATE_URL);
		$urlRows = array();

		if ($isUrl) {
			$contents = trim(file_get_contents($path));
			$pathInfo = pathinfo($path);
			if (false === $contents || self::URL_FILE_PATH_EXTENSION !== $pathInfo['extension']) {
				$this->__debug("'{$path}' is not a valid .txt url path. Please check the url. Skipping ...\n");
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

	public function getProcessedUrlRow($line) {
		$parts        = explode(' ', $line);
		$count        = count($parts);
		$url          = '';
		$options      = array();
		$specFilePath = null;

		if ($count > 3) {
			$this->__debug("The line should have at max 3 space characters.");

			return false;
		} else if ($count == 3) {
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
			$url             = $parts[0];
			$delimitedParams = $parts[1];
			$specFilePath    = null;
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
		} else if ($count == 1) {
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
	 * @return MongoHelper
	 */
	public function getMongoObj() {
		if (is_null($this->mongoObj)) {
			$this->setMongoObj(new MongoHelper());
		}

		return $this->mongoObj;
	}

	/**
	 * @param MongoHelper $mongoObj
	 */
	public function setMongoObj($mongoObj) {
		$this->mongoObj = $mongoObj;
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
} 