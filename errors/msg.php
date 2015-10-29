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

// Define global constants used for Smarty templates and loading of templates...
// @TODO - Eventually replace this system with clean autoloading classes and modules ;)
define ('_DOMAIN', $_SERVER['HTTP_HOST']);
define ('_DEBUG', true);
define ('_ROOT', dirname(__DIR__));
define ('_BASE', basename(__DIR__));
define ('_SMARTY', _ROOT."/"._BASE."/lib/Smarty/");
define ('_LIB', "lib/");

//ini_set('session.auto_start','On');

require_once(_LIB.'debug.inc.php');

// Grab requirements for API
require_once( _LIB . 'stopwatch.php' );

//apache_setenv('EE_DIR', _BASE."/");

$elegance = new ElegantErrors();


/**
 * Class ElegantErrors
 *
 * Error code status as passed by Apache Server using ElegantErrors directives in .htaccess file or PHP by system or user controlled trigger_error statements within try & catch Exception blocks of code
 */
class ElegantErrors {

	/**
	 * @int HTTP Status Code XXX
	 * @see https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
	 *
	 */
	public $code = 520;

	/**
	 * @var string URL location of Redirect for 3xx codes
	 */
	public $url;

	/**
	 * @int Timeout in seconds for redirect when using 3xx codes
	 */
	public $timeout = 5;

	/**
	 * @object Contains the Response, Reason, Image and Retry for given status code
	 */
	public $status;

	/**
	 * @boolean yaml_ext - true / false (bool)
	 */
	private $yaml_ext = false;

	private $config_file;

	/**
	 * @var $config array() of config.yaml values
	 * @TODO - Add remoteAuth to permit remote updates to select config options...
	 **/
	public $config = null;

	private $route = 'errors';

	private $env = null;

	public $tryagain, $success = false;

	public $stopwatch = null;

	/**
	 * Construct for class automatically instantiated when a new class instance is created, done one-shot!
	 **/
	function __construct() {

		// Time it just to make sure it's not being abused or hanging
		$this->stopwatch = new stopwatch;

		$this->base = "/"._BASE;

		// Parse config.yaml and preload all status codes, etc...
		$this->loadConfig();

		// Get & Set $_SESSION variables for better error reporting...
		$this->withClass();

		// Find a route from config file...
		$this->getRoute();

		// Set the XXX code, response, image and reason for the found $this->code
		$this->setStatus();

		// Set the META tag info for the document
		$this->setMeta();

		// Send the HTTP 1.1/XXX Response
		$this->sendHeaders();

		// @TODO - write render_error function and update Smarty libs...
		$this->renderView($this->route);

	} // end __construct()


	/**
	 * Loads Config File using YAML extension
	 */
	protected function loadConfig() {
		// Check if yaml.so is present and use it if possible...
		if ( extension_loaded ( 'yaml' )) {
			$this->yaml_ext = true;
			$this->config_file = _ROOT.'/'._BASE.'/'._LIB . "config.yaml";
			$yaml = file_get_contents( $this->config_file );
			$data = yaml_parse( $yaml, 0 );
		// Load the config.xml file since yaml.so is not available...
		} else {
			$this->yaml_ext = false;
			$this->config_file = _ROOT.'/'._BASE.'/'._LIB . "config.json";
			$contents = file_get_contents( $this->config_file );
			$data = $this->jsonToArray($contents);
		}
		// Convert the $data array to a $config object...
		$this->config = $this->arrayToObject($data);

		// Update and save the config.xml with latest config.yaml settings from development...
		if ($this->config->global->saveJSON == 1) {
			$this->arrayToJSON($data, _LIB.'config.json');
		}
	}

	protected function getRoute() {

		// Check the $_SERVER[REQUEST_URI] for a matching $_GET pattern for clean SEO URLs...
		preg_match_all('%/([a-z0-9\-\._+:]{1,})%',$this->env->request,$matches);

		if (!isset($_GET['c']) && isset($matches[1]) && is_array($matches[1]) && !empty($matches[1]))
		{
			$found = $matches[1];
			$i = 0;
			foreach ($found as $match) {
				if (preg_match('%'._BASE.'%',$match) && $i == 0) {
				}
				if (preg_match('%\d{1,4}%',$match) && $i == 1) {
					$this->code = (int) $match;
				}
				if (preg_match('%[a-z0-9\-+_\./]{1,}%i',$match) && $i == 2) {
					if (preg_match('%^.*?\.\w{2,4}%i',$match)) {
						$this->url = 'http://'.$match;
					} else {
						$this->url = 'http://'.$_SERVER['HTTP_HOST']."/".$match;
					}
				}
				$i++;
			}
		} else {
			// Set the code if an integer is found...
			if ( isset( $_GET['c'] ) && preg_match( '%\d{1,4}%', $_GET['c'] ) ) {
				$this->code = (int) $_GET['c'];
			}

			// Set the Redirect URL for 3xx codes...
			if ( isset( $_GET['r'] ) && preg_match( '%3\d{2,}%', $this->code ) ) {
				$this->url = $_GET['r'];
			}
		}

		$routes = $this->objectToArray($this->config->routes);
		// Search the routes for a matching regex URL pattern to return a template...
		foreach ($routes as $template => $path) {
			if (preg_match("%.+".$path."%i",$this->env->request)) {
				$this->route = $template;
			}
		}
	}

	/**
	 * Creates $this->status object with response, reason, image and retry values
	 */
	protected function setStatus() {
		$code = $this->code;
		// Check if key exists and return status from YAML $codes[] as object
		if (is_object($this->config->codes->$code)) {
			$this->status = $this->config->codes->$code;
		} else {
			$this->code = 520;  // Since the key does not exist, 520 - Unknown Reason
			$this->status = $this->config->codes->$code;
		}
		switch (true) {
			case $this->code < 100:
				$this->status->color = 'darkviolet';
				break;
			case $this->code < 200:
				$this->status->color = 'silver';
				break;
			case $this->code < 300:
				$this->status->color = 'yellowgreen';
				break;
			case $this->code < 400:
				$this->status->color = "yellow";
				break;
			case $this->code < 500:
				$this->status->color = 'black';
				break;
			case $this->code < 600:
				$this->status->color = 'red';
				break;
			// TODO - Add more colors for the Alerts based on the service codes...
			case $this->code > 999:
				$this->status->code = 'hotpink';
				break;
			default:
				$this->status->color = 'red';
		}
	}

	/**
	 * Send the HTTP Headers for Status -HTTP/1.1: Code Response & -Retry-After: Seconds
	 * @TODO - Figure out why it works for everything but 407 ???
	 **/
	protected function sendHeaders() {

		// @TODO - See if there's any need or better way to handle this...
		$protocol = "HTTP/1.0";
		if ( "HTTP/1.1" == $_SERVER["SERVER_PROTOCOL"] ) {
			$protocol = "HTTP/1.1";
		}

		$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

		if (!preg_match('%w3%i',$hostname) && !preg_match('%validator%',$hostname)) {

			// @TODO --> else send 407 somewhere with proper HTTP/1.1: 407 Response, but where/how... ???
			if ( ! in_array( (int) $this->code, array( 407 ) ) ) {

				// Quick safety check before accidentally sending humorous HTTP header causing actual error...
				if ( (int) $this->code < 599 && (int) $this->code > 99 ) {
					header( "$protocol {$this->code} {$this->status->response}", true, $this->code );

					// Send Retry-After if not empty...
					if ( isset( $this->status->retry ) && ! empty( $this->status->retry ) ) {
						header( "Retry-After: " . $this->status->retry );
					}
				}
			}
		}
	}

	// @TODO - Convert all template.inc.php's to template.tpl's Smarty && update library API's...
	/**
	 *
	 *
		// Check $_POST for Cancel button, Successful Captcha keystring and some values...
		$this->success  = 0;
		$this->tryagain = 0;
		if ( isset( $_POST ) ) {
			if ( isset( $_POST['cancel'] ) ) {
				$this->tryagain = 0;
				$location       = "http://" . $_SERVER['HTTP_HOST'];
				unset( $_SESSION['captcha_keystring'] );
				session_destroy();
				header( "Location: $location" );
			} else {
				if ( count( $_POST ) > 0 ) {
					if ( isset( $_SESSION['captcha_keystring'] ) && $_SESSION['captcha_keystring'] == $_POST['keystring'] ) {
						$this->tryagain = 0;
						$this->success  = 1;
					} else {
						$this->tryagain = 1;
					}
				}
			}
		}

		 * @package formmail && Smarty
		 * Example of how to set-up static variables embedded into the lib/formmail.php library
		 *
		 * Step 1. extract($_POST) - if it's present and save state for form reloads...
		 *
		 * Step 2. Decode & Sanititize the variables to prevent injection...
	 *
	 * @TODO - Improve upon this from previous work I've done ;)
		 *
		 * // Some built in variables in the formmail package...
		 *
		 * $email = stripslashes(urldecode($email));
		 * $first = stripslashes(urldecode($first));
		 * $last = stripslashes(urldecode($last));
		 * $address = stripslashes(urldecode($address));
		 * $city = stripslashes(urldecode($city));
		 * $state = stripslashes(urldecode($state));
		 * $file = stripslashes(urldecode($file));
		 * $file2 = stripslashes(urldecode($file2));
		 * $file3 = stripslashes(urldecode($file3));
		 * $message = stripslashes(urldecode($message));
		 *
		 * Step 3. Load Smarty Vars, Cache Options, & Filters -> Render View
		 **/

	protected function renderView($template) {

		// Load Smarty class using config file and create $smarty instance...
		require_once( _SMARTY . "smarty.inc.php" );

		// Make certain $smarty is initialized before we compile, if not throw error and abort!
		if (!isset($smarty)) trigger_error('Failed to load '._SMARTY.'/smarty.inc.php in '.__FUNCTION__, E_ERROR);

//		$smarty->assign('description', $this->description);
//		$smarty->assign('timestamp', $timestamp);
//		$smarty->assign('keywords',$this->keywords);
		$smarty->assign('rightcol',$this->objectToArray($this->config->credits->right));
		$smarty->assign('leftcol',$this->objectToArray($this->config->credits->left));
		$smarty->assign('host', $_SERVER['HTTP_HOST']);
		$smarty->assign('base', $this->base);
		$smarty->assign('sitename', _SITENAME);
		$smarty->assign('url',$this->url);
		$smarty->assign('code',$this->code);
		$smarty->assign('config',$this->config);
		$smarty->assign('status',$this->status);
		$smarty->assign('stopwatch', $this->stopwatch);

		$smarty->display($template.'.tpl');
		return true;
	}

	private function withClass() {
		// @TODO - Add (?? PostreSQL / MySQL / InfluxDB / Mongo ??) for data tracking and health monitoring...

		// Save all the posted values as XML for now...
		$posted = $this->arrayToXML($_POST);

		$this->env->addr = $_SERVER['REMOTE_ADDR'];
		$this->env->agent = $_SERVER['HTTP_USER_AGENT'];
		$this->env->referrer  = $_SERVER['HTTP_REFERER'];
		$this->env->request = $_SERVER['REQUEST_URI'];
		$this->env->time = $_SERVER['REQUEST_TIME'];
		$this->env->host = $_SERVER['HTTP_HOST'];

		// Initialize and add to the history array of URLs visited before the crash...
		$history = array();
		if (isset($_SESSION['withClass']) && !empty($_SESSION['withClass'])) {
			$json = base64_decode($_SESSION['withClass']);
			$payload = unserialize($json);
			$history = unserialize($payload['HISTORY']);
			array_push($history,$this->env->referrer);
		}
		$json = serialize(
			array(
			'HTTP_STATUS'=>$this->code,
			'REMOTE_ADDR'=>$this->env->addr,
			'USER_AGENT'=>$this->env->agent,
			'HISTORY'=>serialize($history),
			'REQUEST_URI'=>$this->env->request,
			'REQUEST_TIME'=>$this->env->time,
			'HTTP_HOST'=>$this->env->host
			)
		);
		$_SESSION['withClass'] = base64_encode($json);
		$this->env->json = $json;
	}

	/**
	 * Recursive Array to Object converter to make arrays OOPS friendly
	 * @param $array
	 *
	 * @return stdClass
	 */
	private function arrayToObject($array) {
		$obj = new stdClass;
		foreach($array as $k => $v) {
			if(strlen($k)) {
				if(is_array($v)) {
					$obj->{$k} = self::arrayToObject($v); //RECURSION
				} else {
					$obj->{$k} = $v;
				}
			}
		}
		return $obj;
	}

	private function arrayToXML($data = null, $newfile = '', $root = 'root') {
		if (empty($data)) {
			return false;
		}
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8" ?>'."<{$root}/>");
		array_walk_recursive($data , array ($xml, 'addChild'));
		$string = dom_import_simplexml($xml);
		$domxml = new DOMDocument('1.0');
		$domxml->preserveWhiteSpace = true;
		$domxml->formatOutput = true;
		$string = $domxml->importNode($string, true);
		$string = $domxml->appendChild($string);
		return $domxml->save($newfile);
//		return $xml->saveXML($newfile);
	}


	private function arrayToJSON ($data = null, $newfile = null) {
		if (empty($data)) return false;
		$json = json_encode($data);
		if (!empty($newfile)) {
			file_put_contents($newfile, $json);
		}
		return $json;
	}

	private function jsonToArray ($contents) {
		return json_decode($contents);
	}

	private function objectToArray($data = null) {

		if (is_array($data) || is_object($data))
		{
			$result = array();
			foreach ($data as $key => $value)
			{
				$result[$key] = self::objectToArray($value);
			}
			return $result;
		}
		return $data;
	}


	private function xmlToArray ( $xmlObject, $out = array () )
	{
		foreach ( (array) $xmlObject as $index => $node )
			$out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

		return $out;
	}

	private function saveXML ($xml = null) {
		if (empty($xml)) return false;

	}

	private function setMeta() {
		// Define _SITENAME used in templates, optionally set it in config file
		(isset($this->config->sitename) && !empty($this->config->sitename)) ?
			define("_SITENAME", $this->config->sitename) : define("_SITENAME", $_SERVER['HTTP_HOST']);

		($this->code > 600 || $this->code < 100) ? $code = '' :  $code = $this->code." ";
		if (!isset($this->config->title) || empty($this->config->title)) {
			$this->config->title = $code.$this->status->response." - ".preg_replace('%,$%','',$this->status->reason)." : ".__CLASS__;
		}

		// Set the META Description if not exists...
		if (!is_object($this->config->meta->description) || empty($this->config->meta->description)) {
			$this->config->meta->description = $this->config->title;
		}

		if (!is_object($this->config->meta->keywords) || empty($this->config->meta->keywords)) {
			$this->config->meta->keywords = __CLASS__." :: ".$this->code." - ".$this->status->response;
		}
	}

}
// @TODO --> REPLACE Begin the document with render_error and render_form plus update Smarty API -> [ ]::in-process...
?>