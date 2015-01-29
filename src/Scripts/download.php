<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 12/21/14
 * Time: 11:18 PM
 */

// script to download all WPT data from server and store it into the mongodb

date_default_timezone_set('America/Los_Angeles');
require_once dirname(dirname(dirname(__FILE__))) . '/vendor/autoload.php';

use Helpers\DownloadHelper;

$downloadHelper = new DownloadHelper();
$downloadHelper->processDownload();