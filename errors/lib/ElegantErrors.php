<?php
/**
 * @package ElegantErrors
 * @description  HTTP Status Codes & ErrorDocument directives with customizable templates and built in contact form
 * @author Gordon Hackett
 * @created 2015-10-02 15:03:17
 * @version 0.8.1
 * @updated 2015-11-08 13:35:20
 * @timestamp 1447018527410
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
require('ElegantTimer.php');
require('ElegantTools.php');
require('ElegantMail.php');
require('ElegantCaptcha.php');
require('ElegantViews.php');

class ElegantErrors {

	public $code = 200;

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

		// Parse config.yaml and preload all status codes, etc...
		ElegantTools::loadConfig();

		// Get & Set $_SESSION variables for better error reporting...
		//@TODO - Implement hooks for WordPress, Drupal & MVCs for ->eventTimeline() aka $_SESSION['HISTORY'] ->withClass()
		$this->eventTimeline();

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
			$this->code = 200;
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

	private function session_valid_id($session_id)
	{
		return preg_match('/^[-,a-zA-Z0-9]{1,128}$/', $session_id) > 0;
	}

	public function eventTimeline() {
		// @TODO - Add (?? PostreSQL / MySQL / InfluxDB / Mongo ??) for data tracking and health monitoring...

		// Save all the posted values as XML for now...
		// @TODO - FixMe... arrayToXML needs CDATA encapsulation
		// $posted = $this->tools->arrayToXML($_POST);

		$this->env->addr = $_SERVER['REMOTE_ADDR'];
		$this->env->agent = $_SERVER['HTTP_USER_AGENT'];
		$this->env->referrer  = $_SERVER['HTTP_REFERER'];
		$this->env->request = $_SERVER['REQUEST_URI'];
		$this->env->time = $_SERVER['REQUEST_TIME'];
		$this->env->host = $_SERVER['HTTP_HOST'];

		if ($this->session_valid_id(session_id()) === false) {
			session_start();
		}

		$sid = session_id();
		$same = session_name();

		// Initialize and add to the history array of URLs visited before the crash...
		if (isset($_SESSION['withClass']) && !empty($_SESSION['withClass'])) {
			$payload = ElegantTools::redCarpet($_SESSION['withClass'],'decode');
			$history = unserialize($payload['HISTORY']);
			array_push($history,array($this->env->time, $this->env->request, $this->env->referrer));
		} else {
			$history = array($this->env->time, $this->env->request, $this->env->referrer);
		}
		// Complete the payload and ready for the redCarpet...
		$payload['HISTORY'] = serialize($history);
		$payload['HTTP_STATUS']  = $this->code;
		$payload['REMOTE_ADDR'] = $this->env->addr;
		$payload['USER_AGENT'] = $this->env->agent;
		$payload['REQUEST_TIME'] = $this->env->time;
		$payload['HTTP_HOST'] = $this->env->host;

		$_SESSION['withClass']  = $withClass = ElegantTools::redCarpet($payload,'encode');
		$this->env->withClass= $withClass;

	}


}

?>