<?php
/**
 * @package ElegantErrors
 * @description  HTTP Status Codes & ErrorDocument directives with customizable templates and built in contact form
 * @author Gordon Hackett
 * @created 2015-10-02 15:03:17
 * @version 0.4.1
 * @updated 2015-10-20 14:05:20
 * @timestamp 1445375125617
 * @copyright 2015 Gordon Hackett :: Directional-Consulting.com
 *
 * This file is part of ElegantErrors.
 *
 * ElegantErrors is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ElegantErrors is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ElegantErrors.  If not, see <http://www.gnu.org/licenses/>.
 *
 **/

// Check if constant _DEBUG is true and then set string for php.ini values...
if (defined('_DEBUG')) {
	( _DEBUG == true ) ? $debug = 'On' : $debug = 'Off';
} else if (!isset($debug) || empty($debug)) {
	$debug = 'On';
}

/**
// Set php.ini values and flags for debugging or production...
($debug == 'On') ? $errorlevel = 'E_ALL' : $errorlevel = 'E_ALL && ~E_NOTICE && E_DEPRECATED && ~E_STRICT';
ini_set('error_reporting', $errorlevel);

// Only display errors if $debug is On
ini_set('display_errors', "$debug");
ini_set('html_errors', "$debug");

ini_set('log_errors', 'On');
$errorlog = _BASE.'/php_error.log';
ini_set('error_log',$errorlog);

// This is always true just for log legibility and cleanliness,,,
ini_set('ignore_repeated_source', 'On');
ini_set('ignore_repeated_errors', 'On');
**/