<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 12/21/14
 * Time: 11:18 PM
 */

// script to download all WPT data from server and store it into the mysql database

require_once '__init.script.php';

use Helpers\DownloadHelper;

$downloadHelper = new DownloadHelper();
$downloadHelper->processDownload();