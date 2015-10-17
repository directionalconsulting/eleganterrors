<?php
/**
 * Created by PhpStorm
 * Project: eleganterrors
 * User: gman
 * Date: 10/16/15
 * Time: 8:11 AM
 * @created 2015-10-16 08:11:35
 * @author Gordon Hackett
 **/

if (!isset($debug) || empty($debug)) {
	$debug = 'On';
}

($debug == 'On') ? $errorlevel = 'E_ALL' : $errorlevel = 'E_ALL && ~E_NOTICE && E_DEPRECATED && ~E_STRICT';
ini_set('error_reporting', $errorlevel);

ini_set('display_errors', "{$debug}");
ini_set('html_errors', "{$debug}");

ini_set('log_errors', 'On');
$basedir = realpath(dirname(__DIR__));
$errorlog = $basedir.'/php_error.log';
if (!file_exists($errorlog)) {
	touch( $errorlog );
}
ini_set('error_log', $errorlog);

ini_set('ignore_repeated_source', 'On');
ini_set('ignore_repeated_errors', 'On');
