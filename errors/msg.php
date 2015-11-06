<?php
/**
 * @package ElegantErrors
 * @description  HTTP Status Codes & ErrorDocument directives with customizable templates and built in contact form
 * @author Gordon Hackett - Directional-Consulting
 * @created 2015-10-02 15:03:17
 * @version 0.4.1
 * @updated 2015-10-20 14:05:20
 * @timestamp 1445375125617
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

// Define global constants used for loading...
// @TODO - Eventually replace this system with clean autoloading classes and modules ;)
define ('_DOMAIN', $_SERVER['HTTP_HOST']);
define ('_DEBUG', false);
define ('_ROOT', dirname(__DIR__));
define ('_BASE', basename(__DIR__));
define ('_LIB', 'lib'.DIRECTORY_SEPARATOR);
define ('_ASSETS', 'assets'.DIRECTORY_SEPARATOR);
define ('_VENDOR', 'vendor'.DIRECTORY_SEPARATOR);
define ('_SMARTY', 'lib'.DIRECTORY_SEPARATOR.'Smarty'.DIRECTORY_SEPARATOR);

require_once(_LIB.'debug.inc.php');

//@TODO - Fix $_SESSION start for older PHP versions...
//ini_set('session.auto_start','On');

//@TODO - Explore more options using Apache SetEnv & GetEnv...
//apache_setenv('EE_DIR', _BASE."/");

function pathfinder() {

//	Optional if PHP is not properly configured... - just add to $paths array()
//	$pear = exec('pear config-get php_dir');

	$libs = explode(PATH_SEPARATOR, get_include_path());
	$dirs = array(_SMARTY,_VENDOR,_LIB);
	$apis = array();
	foreach ($dirs as $dir) {
		$apis[] = _ROOT.DIRECTORY_SEPARATOR.$dir;
	}
	$paths = array();
	$iter    = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator( _ROOT, RecursiveDirectoryIterator::SKIP_DOTS ),
		RecursiveIteratorIterator::SELF_FIRST,
		RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
	);
	foreach ( $iter as $path => $dir ) {
		if ( $dir->isDir() ) {
			foreach ( $apis as $api) {
				if ( preg_match( '%'.$api.'%', $path) ) {
					$paths[] = $path;
				}
			}
		}
	}
	$includes = array_merge($libs,$dirs,$paths);
	$paths = implode(PATH_SEPARATOR,$includes);
	set_include_path($paths);
	spl_autoload_extensions('.php, .inc, .class.php');
	spl_autoload_register();
} // end pathfinder()

// Get/Set the library include paths for SPL Autoloader...
pathfinder();
// Load Elegant Errors libraries...
require('ElegantErrors.php');


//require('Mail.php');
//require('Mail\mime.php');

// GO -->
$elegance = new ElegantErrors();
// Have some class...
$elegance->withClass();
// DONE !
?>