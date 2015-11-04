<?php
/**
 * Created by PhpStorm
 * Project: eleganterrors
 * User: gman
 * Date: 11/1/15
 * Time: 12:41 PM
 */
/**
 * Class ElegantErrors
 *
 * Error code status as passed by Apache Server using ElegantErrors directives in .htaccess file or PHP by system or user controlled trigger_error statements within try & catch Exception blocks of code
 */
require('ElegantTimer.php');
require('ElegantTools.php');
require('ElegantViews.php');
require('ElegantCaptcha.php');
require('ElegantMail.php');


class ElegantErrors {

	public $code = 520;

	public $url;

	public $timeout = 5;

	public $status;

	protected $config;

	protected $route = 'errors';

	protected $env;

	protected $timer;

	protected $mail;

	function __construct() {
		// Set the $base for the web references...
		$this->base = "/"._BASE;
		// Time it just to make sure it's not being abused or hanging
		$this->timer = new ElegantTimer();
	}

	public function setConfig($config) {
		$this->config = $config;
	}

	public function getConfig() {
		return $this->config;
	}

	public function withClass() {

//		die("BEGIN... FIGHT!");
		// Parse config.yaml and preload all status codes, etc...
		ElegantTools::loadConfig();

		// Get & Set $_SESSION variables for better error reporting...
		$this->getHistory();

		// Find a route from config file...
		ElegantViews::getRoute();

		// Set the XXX code, response, image and reason for the found $this->code
		$this->setStatus();

		// Set the META tag info for the document
		ElegantViews::setMeta();
		// Send the HTTP 1.1/XXX Response
		$this->sendHeaders();

		ElegantViews::renderView();

	} // end __construct()


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
		$this->status->credits = 0;
		$this->status->form = 0;
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

		if ($this->route === 'credits') {
			$this->status->credits = 1;
		}
		if ($this->route === 'form') {
			$this->status->form = 1;
			ElegantCaptcha::setCaptcha();
			ElegantCaptcha::getKeyString();
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

	protected function getHistory() {
		// @TODO - Add (?? PostreSQL / MySQL / InfluxDB / Mongo ??) for data tracking and health monitoring...

		// Save all the posted values as XML for now...
		// @TODO - FixMe... arrayToXML needs CDATA encapsulation
//		$posted = $this->tools->arrayToXML($_POST);

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


}

?>