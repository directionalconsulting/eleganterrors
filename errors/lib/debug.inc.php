<?php
/**
 * Project: ElegantErrors
 * @created 2015-10-16 08:11:35
 * @author Gordon Hackett - Directional-Consulting
 * @updated 1445098440659
 * @package ElegantErrors
 **/

// Check if constant _DEBUG is true and then set string for php.ini values...
if (defined('_DEBUG')) {
	( _DEBUG == true ) ? $debug = 'On' : $debug = 'Off';
} else if (!isset($debug) || empty($debug)) {
	$debug = 'On';
}

// Set php.ini values and flags for debugging or production...
($debug == 'On') ? $errorlevel = 'E_ALL' : $errorlevel = 'E_ALL && ~E_NOTICE && E_DEPRECATED && ~E_STRICT';
ini_set('error_reporting', $errorlevel);

// Only display errors if $debug is On
ini_set('display_errors', "$debug");
ini_set('html_errors', "$debug");

// This is always true just for log legibility and cleanliness,,,
ini_set('ignore_repeated_source', 'On');
ini_set('ignore_repeated_errors', 'On');
