<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 12/21/14
 * Time: 2:02 AM
 */

namespace Helpers;

/**
 * Class TestOptions
 *
 * @package Helpers
 */
class TestOptions
{
	/**
	 * @var $options
	 * Available input options for test
	 *
	 * @see https://sites.google.com/a/webpagetest.org/docs/advanced-features/webpagetest-restful-apis#TOC-Parameters
	 */
	private $options = array(
		'url'           => array('value' => null, 'desc' => 'required	URL to be tested'),
		'label'         => array('value' => null, 'desc' => 'optional	Label for the test'),
		'location'      => array('value' => null, 'desc' => 'optional	Location to test from	Dulles 5Mbps Cable'),
		'runs'          => array('value' => 1, 'desc' => 'optional	Number of test runs (1-10 on the public instance) 1'),
		'fvonly'        => array('value' => 0, 'desc' => 'optional	Set to 1 to skip the Repeat View test	0'),
		'domelement'    => array('value' => null, 'desc' => 'optional	DOM Element to record for sub-measurement'),
		'private'       => array('value' => 0, 'desc' => 'optional	Set to 1 to keep the test hidden from the test log	0'),
		'connections'   => array('value' => 0, 'desc' => 'optional	Override the number of concurrent connections IE uses (0 to not override)	0'),
		'web10'         => array('value' => 0, 'desc' => 'optional	Set to 1 to force the test to stop at Document Complete (onLoad)	0'),
		'script'        => array('value' => null, 'desc' => 'optional	Scripted test to execute'),
		'block'         => array('value' => null, 'desc' => 'optional	space-delimited list of urls to block (substring match)'),
		'login'         => array('value' => null, 'desc' => 'optional	User name to use for authenticated tests (http authentication)'),
		'password'      => array('value' => null, 'desc' => 'optional	Password to use for authenticated tests (http authentication)'),
		'authType'      => array('value' => 0, 'desc' => 'optional	Type of authentication to use: 0 = Basic Auth, 1 = SNS	0'),
		'video'         => array('value' => 0, 'desc' => 'optional	Set to 1 to capture video (video is required for calculating Speed Index)	0'),
		'f'             => array('value' => 'json', 'desc' => 'optional	Format. Set to "xml" to request an XML response instead of a redirect or "json" for JSON-encoded response'),
		'r'             => array('value' => null, 'desc' => 'optional	When using the xml interface, will echo back in the response'),
		'notify'        => array('value' => null, 'desc' => 'optional	e-mail address to notify with the test results'),
		'pingback'      => array('value' => null, 'desc' => 'optional	URL to ping when the test is complete (the test ID will be passed as an "id" parameter)'),
		'bwDown'        => array('value' => null, 'desc' => 'optional	Download bandwidth in Kbps (used when specifying a custom connectivity profile)'),
		'bwUp'          => array('value' => null, 'desc' => 'optional	Upload bandwidth in Kbps (used when specifying a custom connectivity profile)'),
		'latency'       => array('value' => null, 'desc' => 'optional	First-hop Round Trip Time in ms (used when specifying a custom connectivity profile)'),
		'plr'           => array('value' => null, 'desc' => 'optional	Packet loss rate - percent of packets to drop (used when specifying a custom connectivity profile)'),
		'k'             => array('value' => null, 'desc' => "optional\t(required for public instance) API Key (if assigned) - applies only to runtest.php calls. Contact the site owner for a key if required (pmeenan@webpagetest.org for the public instance)"),
		'tcpdump'       => array('value' => 0, 'desc' => 'optional	Set to 1 to enable tcpdump capture	 0'),
		'noopt'         => array('value' => 0, 'desc' => 'optional	Set to 1 to disable optimization checks (for faster testing)	0'),
		'noimages'      => array('value' => 0, 'desc' => 'optional	Set to 1 to disable screen shot capturing	0'),
		'noheaders'     => array('value' => 0, 'desc' => 'optional	Set to 1 to disable saving of the http headers (as well as browser status messages and CPU utilization)	0'),
		'pngss'         => array('value' => null, 'desc' => 'optional	Set to 1 to save a full-resolution version of the fully loaded screen shot as a png'),
		'iq'            => array('value' => null, 'desc' => 'optional	Specify a jpeg compression level (30-100) for the screen shots and video capture'),
		'noscript'      => array('value' => null, 'desc' => 'optional	Set to 1 to disable javascript (IE, Chrome, Firefox)'),
		'clearcerts'    => array('value' => 0, 'desc' => 'optional	Set to 1 to clear the OS certificate caches (causes IE to do OCSP/CRL checks during SSL negotiation if the certificates are not already cached). Added in 2.11	 0'),
		'mobile'        => array('value' => 0, 'desc' => 'optional	Set to 1 to have Chrome emulate a mobile browser (screen resolution, UA string, fixed viewport).  Added in 2.11	 0'),
		'mv'            => array('value' => 0, 'desc' => 'optional	Set to 1 when capturing video to only store the video from the median run.	 0'),
		'cmdline'       => array('value' => null, 'desc' => 'optional	Custom command-line options (Chrome only)'),
		'htmlbody'      => array('value' => null, 'desc' => 'optional	Set to 1 to save the content of the first response (base page) instead of all of the text responses (bodies=1)'),
		'tsview_id'     => array('value' => null, 'desc' => 'optional	Test name to use when submitting results to tsviewdb (for private instances that have integrated with tsviewdb)'),
		'custom'        => array('value' => null, 'desc' => 'optional	Custom metrics to collect at the end of a test'),
		'tester'        => array('value' => null, 'desc' => 'optional	Specify a specific tester that the test should run on (must match the PC name in /getTesters.php).  If the tester is not available the job will never run.'),
		'affinity'      => array('value' => null, 'desc' => 'optional	Specify a string that will be used to hash the test to a specific test agent.  The tester will be picked by index among the available testers.  If the number of testers changes then the tests will be distributed to different machines but if the counts remain consistent then the same string will always run the tests on the same test machine.  This can be useful for controlling variability when comparing a given URL over time or different parameters against each other (using the URL as the hash string).'),
		'timeline'      => array('value' => 0, 'desc' => 'optional	Set to 1 to have Chrome capture the Dev Tools timeline	 0'),
		'timelineStack' => array('value' => 0, 'desc' => 'optional	Set to between 1 - 5 to have Chrome include the Javascript call stack. Must be used in conjunction with "timeline". 	 0'),
	);
	private $filteredOptions = array();

	/**
	 * @param       $url
	 * @param array $options
	 *
	 * @return bool
	 * @throws \Helpers\TestOptionsException
	 */
	public function isValidRequest($url, array $options = array()) {
		return $this->isValidUrl($url) && $this->hasValidOptions($options);
	}

	/**
	 * @param $url
	 *
	 * @return mixed
	 */
	public function isValidUrl($url) {
		return filter_var($url, FILTER_VALIDATE_URL);
	}

	/**
	 * @param $option
	 *
	 * @return bool
	 */
	public function isValidOption($option) {
		return array_key_exists($option, $this->getOptions());
	}

	/**
	 * @param array $options
	 *
	 * @return bool
	 * @throws \Helpers\TestOptionsException
	 */
	public function hasValidOptions(array $options = array()) {
		$valid = true;

		foreach ($options as $optionKey => $optionValue) {
			if (!$this->isValidOption($optionKey)) {
				throw new TestOptionsException("`{$optionKey}` is not a valid option");
			}
		}

		return $valid;
	}

	/**
	 * @param array $overridedOptions
	 */
	public function setUrlOptions(array $overridedOptions = array()) {
		foreach ($this->getOptions() as $defaultOptionKey => $defaultOptionValue) {
			$this->filteredOptions[$defaultOptionKey] = isset($overridedOptions[$defaultOptionKey])
				? $overridedOptions[$defaultOptionKey]
				: $defaultOptionValue['value'];
		}
	}

	/**
	 * @return array|mixed
	 */
	public function requestTestUrl() {
		$base            = $this->getWptTestUrl();
		$filteredOptions = $this->getFilteredOptions();
		$requestTime     = date("Y-m-d H:i:s");

		$urlParams  = http_build_query($filteredOptions);
		$requestUrl = "{$base}?{$urlParams}";

		try {
			$jsonResponse = file_get_contents($requestUrl);

			if (false === $jsonResponse) {
				echo "\n\nERROR: Something went wrong. No response returned from the host\n";
				exit(1);
			}

			$response = json_decode($jsonResponse, true);

			if (isset($response['statusCode']) && $response['statusCode'] !== 200) {
				echo "\n\nERROR: There was an error in your request. See below for more details\n";
				echo "\nRequest URL: \n";
				echo str_repeat("=", 50) . "\n";
				echo "\n{$requestUrl}\n";
				echo "\nResponse: \n";
				echo str_repeat("=", 50) . "\n";
				print_r($response);
				exit(1);
			}

			$response['options']     = $filteredOptions;
			$response['requestTime'] = $requestTime;
			$response['processed']   = false;
		} catch (\Exception $e) {
			echo "Test request failed with message: {$e->getMessage()}\n";
			$response = array();
		}

		return $response;
	}

	/**
	 * @param $testId
	 *
	 * @return array|mixed
	 */
	public function getStatusByTestId($testId) {
		$base = $this->getWptStatusCheckUrl();
		$url  = "{$base}?test={$testId}&f=json";

		try {
			$jsonResponse = file_get_contents($url);
			$response     = json_decode($jsonResponse, true);
		} catch (\Exception $e) {
			echo "Status request failed for id:{$testId} with message: {$e->getMessage()}\n";
			$response = array();
		}

		return $response;
	}

	public function getOptions() {
		return $this->options;
	}

	public function getFilteredOptions() {
		return $this->filteredOptions;
	}

	public function getWptHost() {
		return Configs::get('wpt.host');
	}

	public function getWptTestUrl() {
		return $this->getWptHost() . "/runtest.php";
	}

	public function getWptStatusCheckUrl() {
		return $this->getWptHost() . "/testStatus.php";
	}
}

class TestOptionsException extends \Exception
{
}