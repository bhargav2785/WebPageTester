<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 12/21/14
 * Time: 8:54 PM
 */

require_once '__init.script.php';

use Helpers\Configs;
use Helpers\TestOptions;

/**
 * -u, -f, -m, -h -s
 *
 * -u   -> direct url testing
 * -f   -> file testing with a list of urls in it
 * -m   -> file testing with multiple file/url references in it. Each of those file/url might have multiple urls in it
 */
$shortOpts = "u:f:m:h::s:";

/**
 * --help, --save, --check, --options
 *
 * --help       -> to display the help about this tool
 * --save       -> to save an initial test request json payload with options used
 * --check      -> to validate the response against json-schema validator
 * --options    -> to provide test options for -u type test when --check is present
 */
$longOpts = array(
	'help',
	'save',
	'check',
	'options:'
);

$opts         = getopt($shortOpts, $longOpts);
$expectedOpts = $opts;
$optsCount    = count($opts);

if ($optsCount > 0) {
	$configs = new Configs();
	$key     = $configs->getApiKey();
	$wpt     = new WebPageTester($key);

	// -h or --help for help
	if (isset($opts['h']) || isset($opts['help'])) {
		printUsage();
		finish(true);
	}

	// --save for downloading and saving response data into the db
	if (isset($opts['save'])) {
		$wpt->setNeedToSave(true);
		$wpt->setNeedToDownload(true);

		if(!isset($opts['check'])){
			debug("Option --save must be used with --check.", 2);
			printUsage();
			finish(true);
		}
	}

	// --check for checking the required fields/criteria based on json-schema
	if (isset($opts['check'])) {
		$wpt->setNeedToCheck(true);
	}

	// -u for any single url
	if (isset($opts['u'])) {
		if (isset($opts['check']) && !isset($opts['s'])) {
			debug("Option -s must be provided while using both -u and --check.", 2);
			printUsage();
			printOptions();
			finish(false);
		} else {
			$specFilePath    = isset($opts['s']) ? $opts['s'] : null;
			$options         = isset($opts['options']) ? $opts['options'] : null;
			$optionsFiltered = array();
			if (!is_null($options)) {
				$optionParts = explode(',', $options);
				foreach ($optionParts as $option) {
					$keyValue                      = explode('=', $option);
					$optionsFiltered[$keyValue[0]] = $keyValue[1];
				}
			}
			$wpt->testUrl($opts['u'], $optionsFiltered, $specFilePath);
		}
	}

	// -f for single file with multiple urls
	if (isset($opts['f'])) {
		$wpt->testFile($opts['f']);
	}

	// -m for single file with multiple file urls
	if (isset($opts['m'])) {
		$wpt->testMasterFile($opts['m']);
	}

	// verify the response, if required
	$testResults = $wpt->getResponsesByTestId();
	if (!empty($testResults)) {
		$wpt->validateResponseCriteria();
	}

	// download the response, if required
	$wpt->downloadResults();
} else {
	debug("No arguments provided, exiting ...");
	printUsage();
	finish(false);
}

///// Functions
function debug($message, $type = null) {
	$text = '';

	if ($type == 1) {
		$text = 'INFO: ';
	} else if ($type == 2) {
		$text = 'ERROR: ';
	}

	print "{$text}$message\n";
}

function printUsage() {
	debug("\nUsage: test.php [-u http://www.example.com] [-f urls.txt] [-m master.txt] [--save --check [--options] ]");
	debug("     use -h or --help for help.");
	debug("     use -u for a single url test");
	debug("     use -f for multiple url test in a single file.");
	debug("     use -m for multiple file test. Each file can have multiple urls.");
	debug("     use -s for spec file location. Only to be used when both (-u and --check) are provided.");
	debug("     use --save to save request results into the database. To be used with --check only");
	debug("     use --check to validate response against json-schema validator.");
	debug("     use --options to supply test options to WebPageTest tool(comma separated key-value pairs).");
}

function finish($success = true) {
	$exitFlag = $success ? 0 : 1;
	exit($exitFlag);
}

function printOptions() {
	$testOptions = new TestOptions();
	$options     = $testOptions->getOptions();
	$message     = "\nWebPageTest Options: (to be used with --options)\n\n";

	$i = 0;
	foreach ($options as $key => $option) {
		$i++;
		$message .= " " . str_pad($i, 2, "0", STR_PAD_LEFT) . ") " . str_pad($key, 15) . str_pad("default:{$option['value']}", 15) . $option['desc'] . "\n";
	}

	print $message;
}