<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 12/23/14
 * Time: 12:37 AM
 */

namespace Helpers;
use Helpers\CommonHelper;

class SpecHelper extends CommonHelper {
	private $specFilePath = null;

	public function __construct($specFilePath=null){
		if(is_null($specFilePath)){
			throw new \InvalidArgumentException("'specFilePath' param can not be null or empty.");
		}

		$this->specFilePath = $specFilePath;
	}

	public function getAllSpecPaths(){
		$specPaths = $this->getParsedRows($this->specFilePath);
		return $specPaths;
	}
}