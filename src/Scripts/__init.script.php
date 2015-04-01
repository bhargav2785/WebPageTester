<?php
/**
 * Created by PhpStorm.
 * User: bvadher
 * Date: 2/26/15
 * Time: 7:51 PM
 */

date_default_timezone_set('America/Los_Angeles');

defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(dirname(dirname(__FILE__)))));
defined('HELPERS_PATH') || define('HELPERS_PATH', realpath(dirname(dirname(dirname(__FILE__)))) . '/src/Helpers');
defined('SCRIPTS_PATH') || define('SCRIPTS_PATH', realpath(dirname(dirname(dirname(__FILE__)))) . '/src/Scripts');

require_once ROOT_PATH . '/vendor/autoload.php';