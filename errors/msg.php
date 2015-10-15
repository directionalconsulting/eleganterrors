<?php
/**
 * Created by PhpStorm
 * @author Gordon Hackett - Directional-Consulting
 * @date 2015-10-02 15:03:17
 * @version 0.2.2
 * @package ErrorDocuments - Error Message with passed in code value and message / images template redesign
 */

ini_set('display_errors','on');
ini_set('html_errors','on');
ini_set('error_reporting','E_ALL');

/**
 * Class ErrorDocument
 *
 * Error code status as passed by Apache Server using ErrorDocument directives in .htaccess file or PHP by system or user controlled trigger_error statements within try & catch Exception blocks of code
 */
class ErrorDocument {



	/**
	 *  @var int HTTP Status Code
	 * @see https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
	 */
	public $code = null;

	/**
	 * @var string URL location of Redirect for 3xx codes
	 */
	public $url = null;

	/**
	 * @var int
	 */
	public $timeout = 9;

	/**
	 * @var object Contains the Response, Reason, Image and Retry for given status code
	 */
	public $status;

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

	/**
	 * Construct for class automatically instantiated when a new class instance is created, done one-shot!
	 */
	function __construct() {

		$this->load_config();

		// checks msg.php?c=XXX for numerical status code of 1 to 3 digits
		if (isset($_GET['c']) && preg_match('%\d{1,3}%',$_GET['c'])) {
			$this->code = sprintf('%03d',$_GET['c']);
		}

		// checks msg.php?c=xxxurl=www.example.com for 3xx and redirect
		if (isset($_GET['url']) && preg_match('%3\d{2,}%',$this->code)) {
			$this->url = $_GET['url'];
		}

		$this->set_status();

		$this->send_headers();

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
		$yaml = file_get_contents('lib/config.yaml');
		$this->data = yaml_parse($yaml,0); // return $data as array from lib/config.yaml
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
}

$errDoc = new ErrorDocument();
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
