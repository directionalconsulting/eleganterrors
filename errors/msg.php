<?php
/**
 * Created by PhpStorm
 * @author Gordon Hackett - Directional-Consulting
 * @date 2015-10-02 15:03:17
 * @version 0.2.2
 * @revised 2015-10-16 19:58:14
 * @timestamp 1445050720084
 * @package ErrorDocuments - Error Message with passed in code value and message / images template redesign
 **/

require_once('lib/debug.inc.php');

// Define Globals
define ('_TLDDOMAIN', $_SERVER['HTTP_HOST']);
define ('_DEBUG', false);
define ('_ROOT', dirname(__DIR__));
define ('_BASE', basename(__DIR__));
define ('SMARTY_DIR', _ROOT."/"._BASE."/lib/Smarty/");
define ('_SITENAME', 'Elegant Errors');
define ('_INCLUDES',"lib/");

/**
 * Class ErrorDocument
 *
 * Error code status as passed by Apache Server using ErrorDocument directives in .htaccess file or PHP by system or user controlled trigger_error statements within try & catch Exception blocks of code
 */
class ErrorDocument {

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
	private $data = array();

	public $stopwatch = null;

	public $keywords, $displaytitle = null;

	public $time, $base, $remoteip, $useragent, $referrer, $redirect, $script, $request = null;

	public $tryagain, $success = false;

	/**
	 * Construct for class automatically instantiated when a new class instance is created, done one-shot!
	 */
	function __construct() {

		// Grab requirements for API
		require_once( _INCLUDES . 'stopwatch.php' );

		// Time it just to make sure it's not being abused or hanging
		$this->stopwatch = new stopwatch;

		// Parse config.yaml and preload all status codes, etc...
		$this->load_config();

		// Checks msg.php?c=XXX for numerical status code of 1 to 3 digits
		if (isset($_GET['c']) && preg_match('%\d{1,3}%',$_GET['c'])) {
			$this->code = sprintf('%03d',$_GET['c']);
		}

		// Checks msg.php?c=xxxurl=www.example.com for 3xx and redirect
		if (isset($_GET['url']) && preg_match('%3\d{2,}%',$this->code)) {
			$this->url = $_GET['url'];
		}

		// Set the XXX code, response, image and reason for the found $this->code
		$this->set_status();

		// Send the HTTP 1.1/XXX Response
		$this->send_headers();

		// @TODO - write render_error function and update Smarty libs...
//		$this->render_error();

	} // end __construct()

	/**
	 * Recursive Array to Object converter to make arrays OOPS friendly
	 * @param $array
	 *
	 * @return stdClass
	 */
	private function array_to_object($array) {
		$obj = new stdClass;
		foreach($array as $k => $v) {
			if(strlen($k)) {
				if(is_array($v)) {
					$obj->{$k} = self::array_to_object($v); //RECURSION
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
	protected function load_config() {
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
		$this->data = yaml_parse( $yaml, 0 );
	}

	/**
	 * Creates $this->status object with response, reason, image and retry values
	 */
	protected function set_status() {
		// Check if key exists and return status from YAML $codes[] as object
		if (array_key_exists($this->code,$this->data['codes'])) {
			$this->status = $this->array_to_object( $this->data['codes'][ (int) $this->code ] );
		} else {
			$this->code = '520';  // Since the key does not exist, 520 - Unknown Reason
			$this->status = $this->array_to_object( $this->data['codes'][ (int) $this->code ] );
		}
	}

	/**
	 * Send the HTTP Headers for Status -HTTP/1.1: Code Response & -Retry-After: Seconds
	 * @TODO - Figure out why it works for everything but 407 ???
	 **/
	protected function send_headers() {
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
	public function render_form() {

		require_once( SMARTY_DIR . "smarty.inc.php" );
		/**
		 * @package formmail && Smarty
		 *
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

		$smarty->assign('displaytitle', $this->displaytitle);
		$smarty->assign('timestamp', $timestamp);
		$smarty->assign('keywords',$this->keywords);
		$smarty->assign('time', $time);
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

$errDoc = new ErrorDocument();
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
