<?php
/**
 * @package ElegantErrors
 * @description  HTTP Status Codes & ErrorDocument directives with customizable templates and built in contact form
 * @author Gordon Hackett - Directional-Consulting
 * @created 2015-10-02 15:03:17
 * @version 0.3.1
 * @updated 2015-10-17 09:29:32
 * @timestamp 1445099364139
 **/

// Define global constants used for Smarty templates and loading of templates...
// @TODO - Eventually replace this system with clean autoloading classes and modules ;)
define ('_DOMAIN', $_SERVER['HTTP_HOST']);
define ('_DEBUG', false);
define ('_ROOT', dirname(__DIR__));
define ('_BASE', basename(__DIR__));
define ('_SMARTY', _ROOT."/"._BASE."/lib/Smarty/");
define ('_LIB', "lib/");

ini_set('session.auto_start','On');

require_once(_LIB.'debug.inc.php');

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
	public $code = null;

	/**
	 * @var string URL location of Redirect for 3xx codes
	 */
	public $url = null;

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
	public $yaml_ext;

	/**
	 * @var $config array() of config.yaml values
	 * @TODO - Add remoteAuth to permit remote updates to select config options...
	 **/
	public $config = null;

	private $yaml = array();

	private $route = null;

	public $timestamp, $base, $remoteip, $useragent, $referrer, $redirect, $script, $request = null;

	public $tryagain, $success, $stopwatch = false;

	/**
	 * Construct for class automatically instantiated when a new class instance is created, done one-shot!
	 **/
	function __construct() {

		// Grab requirements for API
		require_once( _LIB . 'stopwatch.php' );

		// Time it just to make sure it's not being abused or hanging
		$this->stopwatch = new stopwatch;

		// Parse config.yaml and preload all status codes, etc...
		$this->loadConfig();

		// Checks msg.php?c=XXX for numerical status code of 1 to 3 digits
		if (isset($_GET['c']) && preg_match('%\d{1,4}%',$_GET['c'])) {
			$this->code = sprintf('%04d',$_GET['c']);
		}

		// Checks msg.php?c=xxxurl=www.example.com for 3xx and redirect
		if (isset($_GET['url']) && preg_match('%3\d{2,}%',$this->code)) {
			$this->url = $_GET['url'];
		} else {
			$this->url = null;
		}

		// Get REQUEST_URI and find a route from config.yaml...
		$this->route = $this->getRoute();

		// Set the XXX code, response, image and reason for the found $this->code
		$this->setStatus();

		// Send the HTTP 1.1/XXX Response
		$this->sendHeaders();

		// @TODO - write render_error function and update Smarty libs...
		$this->renderView($this->route);

	} // end __construct()

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

	/**
	 * Loads Config File using YAML extension
	 */
	protected function loadConfig() {
		// @TODO - Add yaml.so check or PECL YAML local file path include function before next lines of code...
		// return $data as array from lib/config.yaml
		$yaml = file_get_contents(_LIB.'config.yaml');
		if ( extension_loaded ( 'yaml' )) {
			// use YAML extension from PHP ini as detected above
			$this->yaml_found = true;
		} else {
			// load YAML PECL from lib locally
			require_once('');
			$this->yaml_found = false;
		};
		// Load YAML file as array and then convert to object for use by app...
		$this->yaml  = yaml_parse( $yaml, 0 );
		$this->config = $this->arrayToObject($this->yaml);

		// Define _SITENAME used in templates, optionally set it in config file
		(isset($this->config->sitename) && !empty($this->config->sitename)) ?
			define("_SITENAME", $this->config->sitename) : define("_SITENAME", $_SERVER['HTTP_HOST']);
	}

	protected function getRoute() {
		// @TODO - Implement this properly, it was just a test for now...
		$request = $_SERVER['REQUEST_URI'];
		$map = $this->config->routes;
		$urls = array_values($map);
		$routes = array_keys($map);
		if (in_array($request,$urls)) {
			$found = array_intersect_assoc($request,$map);
		} else {
			$found = 'errors';
		}
		return $found;
	}

	/**
	 * Creates $this->status object with response, reason, image and retry values
	 */
	protected function setStatus() {
		$code = (int) $this->code;
		// Check if key exists and return status from YAML $codes[] as object
		if (array_key_exists($code,$this->yaml['codes'])) {
			$this->status = $this->arrayToObject( $this->yaml['codes'][ $code ] );
		} else {
			$this->code = '520';  // Since the key does not exist, 520 - Unknown Reason
			$this->status = $this->arrayToObject( $this->yaml['codes'][ $code ] );
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

		// @TODO --> else send 407 somewhere with proper HTTP/1.1: 407 Response, but where/how... ???
		if (!in_array((int)$this->code,array(407))) {

			// Quick safety check before accidentally sending humorous HTTP header causing actual error...
			if ((int) $this->code < 599 && (int) $this->code > 99) {
				header( "$protocol {$this->code} {$this->status->response}", true, $this->code );

				// Send Retry-After if not empty...
				if (isset($this->status->retry) && !empty($this->status->retry)) {
					header( "Retry-After: " . $this->status->retry );
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

		$this->withClass();

		// Load Smarty class using config file and create $smarty instance...
		require_once( _SMARTY . "smarty.inc.php" );

		// Make certain $smarty is initialized before we compile, if not throw error and abort!
		if (!isset($smarty)) trigger_error('Failed to load '._SMARTY.'/smarty.inc.php in '.__FUNCTION__, E_ERROR);

		if (!isset($this->config->title) || empty($this->config->title)) {
			$this->config->title = __CLASS__." - ".$this->code." ".$this->status->response;
		}

//		$smarty->assign('description', $this->description);
//		$smarty->assign('timestamp', $timestamp);
//		$smarty->assign('keywords',$this->keywords);
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

	protected function withClass() {
		// @TODO - Add (?? PostreSQL / MySQL / InfluxDB / Mongo ??) for data tracking and health monitoring...

		// Save all the posted values as XML for now...
		$posted = $this->arrayToXML($_POST);

		$remoteip = $_SERVER['REMOTE_ADDR'];
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		$referrer  = $_SERVER['HTTP_REFERER'];
		$request = $_SERVER['REQUEST_URI'];
		$time = $_SERVER['REQUEST_TIME'];
		$host = $_SERVER['HTTP_HOST'];

		$json = serialize(array($remoteip,$useragent,$referrer,$request,$time,$host));
		if (!isset($_SESSION['withClass']) && empty($_SESSION['withClass'])) {
			$this->config->json = $json;
			$_SESSION['withClass'] = base64_encode($json);
		} else {
			$this->config->json = base64_decode($_SESSION['withClass']);
		}
	}

	private function arrayToXML($data = null) {
		if (empty($data)) {
			return false;
		}
		$xml = new SimpleXMLElement('<root/>');
		array_walk_recursive($data , array ($xml, 'addChild'));
		return $xml->saveXML();  // content of $_POST array(s) are now an XML content that can used
	}

}
// @TODO --> REPLACE Begin the document with render_error and render_form plus update Smarty API -> [ ]::in-process...
?>