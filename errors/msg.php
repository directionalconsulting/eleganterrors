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
define ('_SMARTY',  _ROOT."/"._BASE."/lib/Smarty/");
define ('_LIB', "lib/");

ini_set('session.auto_start','On');

require_once(_LIB.'debug.inc.php');

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
	 * @boolean yaml_pecl - true / false (bool)
	 */
	public $yaml_pecl;

	/**
	 * @var string URL to developer's website
	 */
	public $credit_link = 'http://gordonhackett.com/senior-software-engineer/';

	/**
	 * @var string URL for Contact Us Link
	 */
	public $contact_link = 'mailto:ctsdotcom1@aol.com';

	/**
	 * @var string Background Image default image
	 * @TODO - Add directory support for random images, like space, cats, nature, etc.. - include ALL mode: recursive
	 */
	public $bkgd_image = 'bkgd1.jpg';

	/**
	 * @var array
	 */
	private $config = array();

	public $stopwatch = null;

	public $keywords, $displaytitle = null;

	public $time, $base, $remoteip, $useragent, $referrer, $redirect, $script, $request = null;

	public $tryagain, $success = false;

	/**
	 * Construct for class automatically instantiated when a new class instance is created, done one-shot!
	 */
	function __construct() {

		// Grab requirements for API
		require_once( _LIB . 'stopwatch.php' );

		// Time it just to make sure it's not being abused or hanging
		$this->stopwatch = new stopwatch;

		// Parse config.yaml and preload all status codes, etc...
		$this->loadConfig();

		// Checks msg.php?c=XXX for numerical status code of 1 to 3 digits
		if (isset($_GET['c']) && preg_match('%\d{1,3}%',$_GET['c'])) {
			$this->code = sprintf('%03d',$_GET['c']);
		}

		// Checks msg.php?c=xxxurl=www.example.com for 3xx and redirect
		if (isset($_GET['url']) && preg_match('%3\d{2,}%',$this->code)) {
			$this->url = $_GET['url'];
		}

		// Set the XXX code, response, image and reason for the found $this->code
		$this->setStatus();

		// Send the HTTP 1.1/XXX Response
		$this->sendHeaders();

		// @TODO - write render_error function and update Smarty libs...
//		$this->render_error();

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
		$yaml = file_get_contents('lib/config.yaml');
		if ( extension_loaded ( 'yaml' )) {
			// use YAML extension from PHP ini as detected above
			$this->yaml_found = true;
		} else {
			// load YAML PECL from lib locally
			require_once('');
			$this->yaml_found = false;
		};
		$this->config = yaml_parse( $yaml, 0 );
	}

	/**
	 * Creates $this->status object with response, reason, image and retry values
	 */
	protected function setStatus() {
		// Check if key exists and return status from YAML $codes[] as object
		if (array_key_exists($this->code,$this->config['codes'])) {
			$this->status = $this->arrayToObject( $this->config['codes'][ (int) $this->code ] );
		} else {
			$this->code = '520';  // Since the key does not exist, 520 - Unknown Reason
			$this->status = $this->arrayToObject( $this->config['codes'][ (int) $this->code ] );
		}
	}

	/**
	 * Send the HTTP Headers for Status -HTTP/1.1: Code Response & -Retry-After: Seconds
	 * @TODO - Figure out why it works for everything but 407 ???
	 **/
	protected function sendHeaders() {
		$protocol = "HTTP/1.0";
		if ( "HTTP/1.1" == $_SERVER["SERVER_PROTOCOL"] ) {
			$protocol = "HTTP/1.1";
		}
		if (!in_array((int)$this->code,array(407))) {
			header( "$protocol {$this->code} {$this->status->response}", true, $this->code );
			if (isset( $this->status->retry)) {
				header( "Retry-After: " . $this->status->retry );
			}
		} // @TODO --> else send 407 somewhere with proper HTTP/1.1: 407 Response, but where/how... ???
	}

	// @TODO - Convert all template.inc.php's to template.tpl's Smarty && update library API's...

	/**
	 * @return rendered template view
	 * $keywords, $displaytitle, $base, $tryagain, $success
	 **/
	public function actionForm() {

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

		if ( $this->success == 1 ) {
			// @TODO - Convert this to boilerplate .tpl & .htm for consistency and security - 2015-09-18 18:22:21
			// @TODO - Priority lowered - provided captcha works with session keys, with can just clean it up as is for now
			// @TODO ---> going to say yes, but first let's test as if I hadn't, then I think it's easy - 2015-09-18 18:41:41
			include_once( _LIB . 'formmail.php' );
			exit( 0 );

		} else {
			$this->renderForm();
		}
	}

	protected function renderForm() {

		// Load Smarty class using config file and create $smarty instance...
		require_once( _SMARTY . "smarty.inc.php" );
		/**
		 * @package formmail && Smarty
		 * Example of how to set-up static variables embedded into the lib/formmail.php library
		 *
		 * Step 1. extract($_POST) - if it's present and save state for form reloads...
		 *
		 * Step 2. Decode & Sanititize the variables to prevent injection... @TODO - Improve upon this from previous work I've done ;)
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

		if (isset($_SERVER['REMOTE_ADDR']))
		{
			$this->remoteip = $_SERVER["REMOTE_ADDR"];
		}

		// Record the time it was reported to make log inspection easier...
		$timestamp = strftime("%m-%d-%y_%H-%M",strtotime("now")) ;

		// Save the form if we have some $_POST[] Array data, else fill the necessary basic blank fields...
		if (isset($_POST) and !empty($_POST)) {
			$DATA = $_POST;
		} else {
			$DATA = array(
				'first' => '',
				'last' => '',
				'email' => '',
				'message' => ''
			);
		}
		
		// Make certain $smarty is initialized before we compile, if not throw error and abort!
		if (!isset($smarty)) trigger_error('Failed to load '._SMARTY.'/smarty.inc.php in '.__FUNCTION__, E_ERROR);

		$smarty->assign('displaytitle', $this->displaytitle);
		$smarty->assign('timestamp', $timestamp);
		$smarty->assign('keywords',$this->keywords);
		$smarty->assign('base', $this->base);
		$smarty->assign('tryagain', $this->tryagain);
		$smarty->assign('success', $this->success);
		$smarty->assign('sitename', _SITENAME);
		$smarty->assign('elapsed', $this->stopwatch->get_elapsed());

		$smarty->assign('subject', __SUBJECT." - ".$this->code." ".$this->status->response);
		foreach ($DATA as $key => $value) {
			$smarty->assign($key, stripslashes(urldecode($value)));
		}
		$smarty->display('contactus_index.tpl');
		return true;
	}

	/*
	// @TODO - Very similar function to above -#@$!~~~ (^_^) ~~~!$@#-
	protected function render_view() {
	}
	*/
}

$errDoc = new ElegantErrors();
// @TODO --> REPLACE Begin the document with render_error and render_form plus update Smarty API -> [ ]::in-process...

// Begin the HTML Document
?>
<!DOCTYPE html>
<html>
<?php include_once( 'lib/header.inc.php' ); ?>
<body>
	<div id="canvas">
		<div id="leftpanel">
		</div>
		<div id="rightpanel">
		</div>
		<div id="page">
			<div id="content">
					<?php echo file_get_contents('lib/warning.htm'); ?>
					<div class="row">
						<div id="response">
							<div class="main-icon text-warning"><span class="uxicon uxicon-alert"></span></div>
							<h1><?php echo $errDoc->status->response; ?></h1>
							<img src="assets/img/<?php echo $errDoc->status->image; ?>" alt="<?php echo $errDoc->status->response; ?>">
						</div>
					</div>
					<div class="row">
						<div id="reason">
							<?php if (isset($errDoc->url) && !empty($errDoc->url)): ?>
							<p>Please follow <a href="<?php echo $errDoc->url; ?>">this link</a></p>
							<?php endif; ?>
							<p><?php echo $errDoc->status->reason; ?><br />
								<?php require_once( 'lib/contact.inc.php' ); ?>
							</p>
						</div>
					</div>
				<?php require_once( 'lib/footer.inc.php' ); ?>
			</div>
		</div>
	</div>
</body>
</html>
