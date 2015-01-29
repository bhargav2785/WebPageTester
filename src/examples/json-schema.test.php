<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 1/19/15
 * Time: 1:59 PM
 */

require_once '/Users/bvadher/Sites/WebPageTester/vendor/autoload.php';

$return = array(
	'isValid' => true,
	'errors'  => array()
);

$response = json_decode(file_get_contents('/Users/bvadher/Sites/WebPageTester/src/examples/sample_response.json'));
$schema   = json_decode(file_get_contents('/Users/bvadher/Sites/WebPageTester/src/examples/spec2.json'));

// CONVERT data.runs into array from object because that's how it should be otherwise Jsv4 fails
$runs                 = $response->data->runs;
$response->data->runs = null;
$response->data->runs = (array)$runs;

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

print_r($return);