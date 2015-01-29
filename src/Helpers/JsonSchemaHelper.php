<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 12/22/14
 * Time: 10:49 PM
 */

namespace Helpers;

/**
 * Class JsonSchemaHelper
 *
 * @package Helpers
 */
class JsonSchemaHelper
{
	/**
	 * @param $response
	 * @param $schema
	 *
	 * Validates against json-schema validator
	 *
	 * @return array
	 */
	public function validate($response, $schema) {
		$return  = array(
			'isValid' => true,
			'errors'  => array()
		);
		$results = \Jsv4::validate($response, $schema);

		if (!$results->valid) {
			$errors = array();
			foreach ($results->errors as $key => $error) {
				$errorTextArr               = array();
				$errorTextArr['code']       = $error->code;
				$errorTextArr['dataPath']   = $error->dataPath;
				$errorTextArr['schemaPath'] = $error->schemaPath;
				$errorTextArr['message']    = $error->message;

				array_push($errors, $errorTextArr);
			}

			$return['isValid'] = false;
			$return['errors']  = $errors;
		}

		return $return;
	}
}