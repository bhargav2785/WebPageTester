<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 3/12/15
 * Time: 11:47 PM
 */

namespace Helpers;

class Constants
{
	// TESTS parameters
	const REQUEST_PARAM_ID = "id";
	const REQUEST_PARAM_TEST_ID = "test_id";
	const REQUEST_PARAM_STATUS_CODE = "status_code";
	const REQUEST_PARAM_STATUS_TEXT = "status_text";
	const REQUEST_PARAM_REQUEST_TIME = "request_time";
	const REQUEST_PARAM_PROCESSED = "processed";
	const REQUEST_PARAM_SPEC_FILEPATH = "spec_filepath";
	const REQUEST_PARAM_OWNER_KEY = "owner_key";
	const REQUEST_PARAM_JSON_URL = "json_url";
	const REQUEST_PARAM_XML_URL = "xml_url";
	const REQUEST_PARAM_USER_URL = "user_url";
	const REQUEST_PARAM_SUMMARY_CSV_URL = "summary_csv_url";
	const REQUEST_PARAM_DETAIL_CSV_URL = "detail_csv_url";
	const REQUEST_PARAM_URL = "url";
	const REQUEST_PARAM_LABEL = "label";
	const REQUEST_PARAM_LOCATION = "location";
	const REQUEST_PARAM_RUNS = "runs";
	const REQUEST_PARAM_FVONLY = "fvonly";
	const REQUEST_PARAM_DOMELEMENT = "domelement";
	const REQUEST_PARAM_PRIVATE = "private";
	const REQUEST_PARAM_CONNECTIONS = "connections";
	const REQUEST_PARAM_WEB10 = "web10";
	const REQUEST_PARAM_SCRIPT = "script";
	const REQUEST_PARAM_BLOCK = "block";
	const REQUEST_PARAM_LOGIN = "login";
	const REQUEST_PARAM_PASSWORD = "password";
	const REQUEST_PARAM_AUTH_TYPE = "auth_type";
	const REQUEST_PARAM_VIDEO = "video";
	const REQUEST_PARAM_F = "f";
	const REQUEST_PARAM_R = "r";
	const REQUEST_PARAM_NOTIFY = "notify";
	const REQUEST_PARAM_PINGBACK = "pingback";
	const REQUEST_PARAM_BW_DOWN = "bw_down";
	const REQUEST_PARAM_BW_UP = "bw_up";
	const REQUEST_PARAM_LATENCY = "latency";
	const REQUEST_PARAM_PLR = "plr";
	const REQUEST_PARAM_K = "k";
	const REQUEST_PARAM_TCPDUMP = "tcpdump";
	const REQUEST_PARAM_NOOPT = "noopt";
	const REQUEST_PARAM_NOIMAGES = "noimages";
	const REQUEST_PARAM_NOHEADERS = "noheaders";
	const REQUEST_PARAM_PNGSS = "pngss";
	const REQUEST_PARAM_IQ = "iq";
	const REQUEST_PARAM_NOSCRIPT = "noscript";
	const REQUEST_PARAM_CLEARCERTS = "clearcerts";
	const REQUEST_PARAM_MOBILE = "mobile";
	const REQUEST_PARAM_MV = "mv";
	const REQUEST_PARAM_CMDLINE = "cmdline";
	const REQUEST_PARAM_HTMLBODY = "htmlbody";
	const REQUEST_PARAM_TSVIEW_ID = "tsview_id";
	const REQUEST_PARAM_CUSTOM = "custom";
	const REQUEST_PARAM_TESTER = "tester";
	const REQUEST_PARAM_AFFINITY = "affinity";
	const REQUEST_PARAM_TIMELINE = "timeline";
	const REQUEST_PARAM_TIMELINE_STACK = "timeline_stack";
	const REQUEST_PARAM_CREATED_DATE = "created_date";
	const REQUEST_PARAM_UPDATE_DATE = "update_date";

	// SUMMARY parameters
	const SUMMARY_PARAM_ID = "id";
	const SUMMARY_PARAM_TEST_ID = "testid";
	const SUMMARY_PARAM_DATE = "date";
	const SUMMARY_PARAM_TIME = "time";
	const SUMMARY_PARAM_EVENT_NAME = "eventname";
	const SUMMARY_PARAM_URL = "url";
	const SUMMARY_PARAM_LOAD_TIME_MS = "loadtimems";
	const SUMMARY_PARAM_TIME_TO_FIRST_BYTE_MS = "timetofirstbytems";
	const SUMMARY_PARAM_UNUSED = "unused";
	const SUMMARY_PARAM_BYTES_OUT = "bytesout";
	const SUMMARY_PARAM_BYTES_IN = "bytesin";
	const SUMMARY_PARAM_DNS_LOOKUPS = "dnslookups";
	const SUMMARY_PARAM_CONNECTIONS = "connections";
	const SUMMARY_PARAM_REQUESTS = "requests";
	const SUMMARY_PARAM_OK_RESPONSES = "okresponses";
	const SUMMARY_PARAM_REDIRECTS = "redirects";
	const SUMMARY_PARAM_NOT_MODIFIED = "notmodified";
	const SUMMARY_PARAM_NOT_FOUND = "notfound";
	const SUMMARY_PARAM_OTHER_RESPONSES = "otherresponses";
	const SUMMARY_PARAM_ERROR_CODE = "errorcode";
	const SUMMARY_PARAM_TIME_TO_START_RENDER_MS = "timetostartrenderms";
	const SUMMARY_PARAM_SEGMENTS_TRANSMITTED = "segmentstransmitted";
	const SUMMARY_PARAM_SEGMENTS_RETRANSMITTED = "segmentsretransmitted";
	const SUMMARY_PARAM_PACKET_LOSS_OUT = "packetlossout";
	const SUMMARY_PARAM_ACTIVITY_TIME_MS = "activitytimems";
	const SUMMARY_PARAM_DESCRIPTOR = "descriptor";
	const SUMMARY_PARAM_LAB_ID = "labid";
	const SUMMARY_PARAM_DIALER_ID = "dialerid";
	const SUMMARY_PARAM_CONNECTION_TYPE = "connectiontype";
	const SUMMARY_PARAM_CACHED = "cached";
	const SUMMARY_PARAM_EVENT_URL = "eventurl";
	const SUMMARY_PARAM_PAGETEST_BUILD = "pagetestbuild";
	const SUMMARY_PARAM_MEASUREMENT_TYPE = "measurementtype";
	const SUMMARY_PARAM_EXPERIMENTAL = "experimental";
	const SUMMARY_PARAM_DOC_COMPLETE_TIME_MS = "doccompletetimems";
	const SUMMARY_PARAM_EVENT_GUID = "eventguid";
	const SUMMARY_PARAM_TIME_TO_DOM_ELEMENT_MS = "timetodomelementms";
	const SUMMARY_PARAM_INCLUDES_OBJECT_DATA = "includesobjectdata";
	const SUMMARY_PARAM_CACHE_SCORE = "cachescore";
	const SUMMARY_PARAM_STATIC_CDN_SCORE = "staticcdnscore";
	const SUMMARY_PARAM_ONE_CDN_SCORE = "onecdnscore";
	const SUMMARY_PARAM_GZIP_SCORE = "gzipscore";
	const SUMMARY_PARAM_COOKIE_SCORE = "cookiescore";
	const SUMMARY_PARAM_KEEP_ALIVE_SCORE = "keepalivescore";
	const SUMMARY_PARAM_DOCTYPE_SCORE = "doctypescore";
	const SUMMARY_PARAM_MINIFY_SCORE = "minifyscore";
	const SUMMARY_PARAM_COMBINE_SCORE = "combinescore";
	const SUMMARY_PARAM_BYTES_OUT_DOC = "bytesoutdoc";
	const SUMMARY_PARAM_BYTES_IN_DOC = "bytesindoc";
	const SUMMARY_PARAM_DNS_LOOKUPS_DOC = "dnslookupsdoc";
	const SUMMARY_PARAM_CONNECTIONS_DOC = "connectionsdoc";
	const SUMMARY_PARAM_REQUESTS_DOC = "requestsdoc";
	const SUMMARY_PARAM_OK_RESPONSES_DOC = "okresponsesdoc";
	const SUMMARY_PARAM_REDIRECTS_DOC = "redirectsdoc";
	const SUMMARY_PARAM_NOT_MODIFIED_DOC = "notmodifieddoc";
	const SUMMARY_PARAM_NOT_FOUND_DOC = "notfounddoc";
	const SUMMARY_PARAM_OTHER_RESPONSES_DOC = "otherresponsesdoc";
	const SUMMARY_PARAM_COMPRESSION_SCORE = "compressionscore";
	const SUMMARY_PARAM_HOST = "host";
	const SUMMARY_PARAM_IP_ADDRESS = "ipaddress";
	const SUMMARY_PARAM_ETAG_SCORE = "etagscore";
	const SUMMARY_PARAM_FLAGGED_REQUESTS = "flaggedrequests";
	const SUMMARY_PARAM_FLAGGED_CONNECTIONS = "flaggedconnections";
	const SUMMARY_PARAM_MAX_SIMULTANEOUS_FLAGGED_CONNECTION = "maxsimultaneousflaggedconnection";
	const SUMMARY_PARAM_TIME_TO_BASE_PAGE_COMPLETE_MS = "timetobasepagecompletems";
	const SUMMARY_PARAM_BASE_PAGE_RESULT = "basepageresult";
	const SUMMARY_PARAM_GZIP_TOTAL_BYTES = "gziptotalbytes";
	const SUMMARY_PARAM_GZIP_SAVINGS_BYTES = "gzipsavingsbytes";
	const SUMMARY_PARAM_MINIFY_TOTAL_BYTES = "minifytotalbytes";
	const SUMMARY_PARAM_MINIFY_SAVINGS_BYTES = "minifysavingsbytes";
	const SUMMARY_PARAM_IMAGE_TOTAL_BYTES = "imagetotalbytes";
	const SUMMARY_PARAM_IMAGE_SAVINGS_BYTES = "imagesavingsbytes";
	const SUMMARY_PARAM_BASE_PAGE_REDIRECTS = "basepageredirects";
	const SUMMARY_PARAM_OPTIMIZATION_CHECKED = "optimizationchecked";
	const SUMMARY_PARAM_AFT_MS = "aftms";
	const SUMMARY_PARAM_DOM_ELEMENTS = "domelements";
	const SUMMARY_PARAM_PAGESPEED_VERSION = "pagespeedversion";
	const SUMMARY_PARAM_PAGE_TITLE = "pagetitle";
	const SUMMARY_PARAM_TIME_TO_TITLE_MS = "timetotitlems";
	const SUMMARY_PARAM_LOAD_EVENT_START_MS = "loadeventstartms";
	const SUMMARY_PARAM_LOAD_EVENT_END_MS = "loadeventendms";
	const SUMMARY_PARAM_DOM_CONTENT_READY_START_MS = "domcontentreadystartms";
	const SUMMARY_PARAM_DOM_CONTENT_READY_END_MS = "domcontentreadyendms";
	const SUMMARY_PARAM_VISUALLY_COMPLETE_MS = "visuallycompletems";
	const SUMMARY_PARAM_BROWSER_NAME = "browsername";
	const SUMMARY_PARAM_BROWSER_VERSION = "browserversion";
	const SUMMARY_PARAM_BASE_PAGE_SERVER = "basepageserver";
	const SUMMARY_PARAM_BASE_PAGE_SERVER_RIT = "basepageserverrit";
	const SUMMARY_PARAM_BASE_PAGE_CDN = "basepagecdn";
	const SUMMARY_PARAM_ADULT_SITE = "adultsite";
	const SUMMARY_PARAM_RUN = "run";
	const SUMMARY_PARAM_SPEED_INDEX = "speedindex";

	// REQUESTS parameters
	const HTTP_REQUEST_PARAM_ID = "id";
	const HTTP_REQUEST_PARAM_TEST_ID = "testid";
	const HTTP_REQUEST_PARAM_DATE = "date";
	const HTTP_REQUEST_PARAM_TIME = "time";
	const HTTP_REQUEST_PARAM_EVENT_NAME = "eventname";
	const HTTP_REQUEST_PARAM_IP_ADDRESS = "ipaddress";
	const HTTP_REQUEST_PARAM_ACTION = "action";
	const HTTP_REQUEST_PARAM_HOST = "host";
	const HTTP_REQUEST_PARAM_URL = "url";
	const HTTP_REQUEST_PARAM_RESPONSE_CODE = "responsecode";
	const HTTP_REQUEST_PARAM_TIME_TO_LOAD_MS = "timetoloadms";
	const HTTP_REQUEST_PARAM_TIME_TO_FIRST_BYTE_MS = "timetofirstbytems";
	const HTTP_REQUEST_PARAM_START_TIME_MS = "starttimems";
	const HTTP_REQUEST_PARAM_BYTES_OUT = "bytesout";
	const HTTP_REQUEST_PARAM_BYTES_IN = "bytesin";
	const HTTP_REQUEST_PARAM_OBJECT_SIZE = "objectsize";
	const HTTP_REQUEST_PARAM_COOKIE_SIZE_OUT = "cookiesizeout";
	const HTTP_REQUEST_PARAM_COOKIE_COUNTOUT = "cookiecountout";
	const HTTP_REQUEST_PARAM_EXPIRES = "expires";
	const HTTP_REQUEST_PARAM_CACHE_CONTROL = "cachecontrol";
	const HTTP_REQUEST_PARAM_CONTENT_TYPE = "contenttype";
	const HTTP_REQUEST_PARAM_CONTENT_ENCODING = "contentencoding";
	const HTTP_REQUEST_PARAM_TRANSACTION_TYPE = "transactiontype";
	const HTTP_REQUEST_PARAM_SOCKET_ID = "socketid";
	const HTTP_REQUEST_PARAM_DOCUMENT_ID = "documentid";
	const HTTP_REQUEST_PARAM_END_TIME_MS = "endtimems";
	const HTTP_REQUEST_PARAM_DESCRIPTOR = "descriptor";
	const HTTP_REQUEST_PARAM_LAB_ID = "labid";
	const HTTP_REQUEST_PARAM_DIALER_ID = "dialerid";
	const HTTP_REQUEST_PARAM_CONNECTION_TYPE = "connectiontype";
	const HTTP_REQUEST_PARAM_CACHED = "cached";
	const HTTP_REQUEST_PARAM_EVENT_URL = "eventurl";
	const HTTP_REQUEST_PARAM_PAGETEST_BUILD = "pagetestbuild";
	const HTTP_REQUEST_PARAM_MEASUREMENT_TYPE = "measurementtype";
	const HTTP_REQUEST_PARAM_EXPERIMENTAL = "experimental";
	const HTTP_REQUEST_PARAM_EVENT_GUID = "eventguid";
	const HTTP_REQUEST_PARAM_SEQUENCE_NUMBER = "sequencenumber";
	const HTTP_REQUEST_PARAM_CACHE_SCORE = "cachescore";
	const HTTP_REQUEST_PARAM_STATIC_CDN_SCORE = "staticcdnscore";
	const HTTP_REQUEST_PARAM_GZIP_SCORE = "gzipscore";
	const HTTP_REQUEST_PARAM_COOKIE_SCORE = "cookiescore";
	const HTTP_REQUEST_PARAM_KEEP_ALIVE_SCORE = "keepalivescore";
	const HTTP_REQUEST_PARAM_DOCTYPE_SCORE = "doctypescore";
	const HTTP_REQUEST_PARAM_MINIFY_SCORE = "minifyscore";
	const HTTP_REQUEST_PARAM_COMBINE_SCORE = "combinescore";
	const HTTP_REQUEST_PARAM_COMPRESSION_SCORE = "compressionscore";
	const HTTP_REQUEST_PARAM_ETAG_SCORE = "etagscore";
	const HTTP_REQUEST_PARAM_FLAGGED = "flagged";
	const HTTP_REQUEST_PARAM_SECURE = "secure";
	const HTTP_REQUEST_PARAM_DNS_TIME = "dnstime";
	const HTTP_REQUEST_PARAM_CONNECT_TIME = "connecttime";
	const HTTP_REQUEST_PARAM_SSL_TIME = "ssltime";
	const HTTP_REQUEST_PARAM_GZIP_TOTAL_BYTES = "gziptotalbytes";
	const HTTP_REQUEST_PARAM_GZIP_SAVINGS = "gzipsavings";
	const HTTP_REQUEST_PARAM_MINIFY_TOTAL_BYTES = "minifytotalbytes";
	const HTTP_REQUEST_PARAM_MINIFY_SAVINGS = "minifysavings";
	const HTTP_REQUEST_PARAM_IMAGE_TOTAL_BYTES = "imagetotalbytes";
	const HTTP_REQUEST_PARAM_IMAGE_SAVINGS = "imagesavings";
	const HTTP_REQUEST_PARAM_CACHE_TIME_SEC = "cachetimesec";
	const HTTP_REQUEST_PARAM_REAL_START_TIME_MS = "realstarttimems";
	const HTTP_REQUEST_PARAM_FULL_TIME_TO_LOAD_MS = "fulltimetoloadms";
	const HTTP_REQUEST_PARAM_OPTIMIZATION_CHECKED = "optimizationchecked";
	const HTTP_REQUEST_PARAM_CDN_PROVIDER = "cdnprovider";
	const HTTP_REQUEST_PARAM_DNS_START = "dnsstart";
	const HTTP_REQUEST_PARAM_DNS_END = "dnsend";
	const HTTP_REQUEST_PARAM_CONNECT_START = "connectstart";
	const HTTP_REQUEST_PARAM_CONNECT_END = "connectend";
	const HTTP_REQUEST_PARAM_SSL_NEGOTIATION_START = "sslnegotiationstart";
	const HTTP_REQUEST_PARAM_SSL_NEGOTIATION_END = "sslnegotiationend";
	const HTTP_REQUEST_PARAM_INITIATOR = "initiator";
	const HTTP_REQUEST_PARAM_INITIATOR_LINE = "initiatorline";
	const HTTP_REQUEST_PARAM_INITIATOR_COLUMN = "initiatorcolumn";
	const HTTP_REQUEST_PARAM_SERVER_COUNT = "servercount";
	const HTTP_REQUEST_PARAM_SERVER_RTT = "serverrtt";
	const HTTP_REQUEST_PARAM_RUN = "run";

	/**
	 * @param string $prefix
	 *
	 * Returns a list of constants that starts with $prefix
	 *
	 * @return array
	 */
	public function getConstantsStartsWith($prefix = '') {
		$refClass  = new \ReflectionClass(__CLASS__);
		$constants = $refClass->getConstants();

		if (!$constants) {
			return array();
		}

		// COLLECT all const variables keys that starts with `$prefix`
		$filteredKeys = array_filter(array_keys($constants), function ($constantKey) use ($prefix) {
			return stripos($constantKey, $prefix) === 0;
		});

		// UNSET all const that do not start with `$prefix`
		foreach ($constants as $key => $value) {
			if (!in_array($key, $filteredKeys)) {
				unset($constants[$key]);
			}
		}

		return $constants;
	}
}