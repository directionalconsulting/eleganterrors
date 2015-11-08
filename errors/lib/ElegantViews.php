<?php
/**
 * @package ElegantErrors
 * @description  HTTP Status Codes & ErrorDocument directives with customizable templates and built in contact form
 * @author Gordon Hackett
 * @created 2015-10-02 15:03:17
 * @version 0.7.2
 * @updated 2015-11-08 13:38:13
 * @timestamp 1447018698859
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

class ElegantViews extends ElegantErrors {

	function __construct(
		ElegantErrors $elegantErrors
	) {}

	protected function getRoute() {

		// Check the $_SERVER[REQUEST_URI] for a matching $_GET pattern for clean SEO URLs...
		preg_match_all('%/([a-z0-9\-\._+:]{1,})%',$this->env->request,$matches);

		// SEO Friendly matching using .htaccess redirect rules... - >> NO *.php?c=
		if (!isset($_GET['c']) && isset($matches[1]) && is_array($matches[1]) && !empty($matches[1]))
		{
			// Set array of all found SEO params...
			$found = $matches[1];
			$i = 0;

			// Iterate over /baseDir/Code/RedirectURL
			foreach ($found as $match) {

				// Check the first param, base dir match...
				if (preg_match('%'._BASE.'%',$match) && $i == 0) {
				}

				// Check the second param, error code
				if (preg_match('%\d{1,3}%',$match) && $i == 1) {
					$this->code = (int) $match;
				}

				// Check the third param, redirect
				if (preg_match('%[a-z0-9\-+_\./]{1,}%i',$match) && $i == 2) {

					// Self hosted URL match...
					if (preg_match('%^.*?\.\w{2,4}%i',$match)) {
						$this->url = 'http://'.$match;

						// External URL match...
					} else {
						$this->url = 'http://'.$_SERVER['HTTP_HOST']."/".$match;
					}
				}

				// Increment iterations of params...
				$i++;
			}
			// $_GET['c'] found, so let's use those params...
		} else {
			// Set the code if an integer is found...
			if ( isset( $_GET['c'] ) && preg_match( '%\d{1,3}%', $_GET['c'] ) ) {
				$this->code = (int) $_GET['c'];
			}

			// Set the Redirect URL for 3xx codes...
			if ( isset( $_GET['r'] ) && preg_match( '%3\d{2,}%', $this->code ) ) {
				$this->url = $_GET['r'];
			}
		}

		// Convert config->routes to array to loop...
		$routes = ElegantTools::objectToArray($this->config->routes);

		// Search the routes for a matching regex URL pattern to return a template...
		foreach ($routes as $route => $path) {
			// Check the config->routes for a matching REQUEST_URI...
			if (preg_match("%".$path."%",$this->env->request)) {
				$this->route = $route;
			}
		}
	} // end getRoute()

	public function setMeta() {
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

	public function renderView() {

		//@TODO - Implment LESS options for main & side columns + color alerts...
		// Load and execute leafo/lessphp
//		require_once('lessc.inc.php');
//		$less = new lessc;
		// @see - http://leafo.net/lessphp/docs/#setting_variables_from_php
//		$less->setVariables(array(
//			"color" => "red",
//			"base" => "960px"
//		));

//		$less->checkedCompile('assets/css/stlyes.less', 'assets/css/styles.css');

		// Load Smarty class using config file and create $smarty instance...
		require_once('smarty.inc.php');

		// Make certain $smarty is initialized before we compile, if not throw error and abort!
		if (!isset($smarty)) trigger_error('Failed to load '._SMARTY.'smarty.inc.php in '.__FUNCTION__, E_ERROR);

		// The clock is still running...
		$smarty->assign('ElegantTimer', $this->timer);

		// Base directory and site information
		$smarty->assign('base', $this->base);
		$smarty->assign('host', $_SERVER['HTTP_HOST']);
		$smarty->assign('sitename', _SITENAME);

		// Global config and routing...
		$smarty->assign('config',$this->config);
		$smarty->assign('route',$this->route);

		// Status codes and redirects...
		$smarty->assign('status',$this->status);
		$smarty->assign('url',$this->url);
		$smarty->assign('code',$this->code);

		// Credits columns or ... ???
		$smarty->assign('rightcol',ElegantTools::objectToArray($this->config->credits->right));
		$smarty->assign('leftcol',ElegantTools::objectToArray($this->config->credits->left));

		// Form values as key pairs from $_POST...
		if (isset($_POST) and !empty($_POST)) {
			$support = $_POST;
			// Set the Redirect URL if present...
			if (isset($support['redirect']) && !empty($support['redirect'])) {
				$this->url = $support['redirect'];
			}
			if (isset($support['email']) && !empty($support['email'])) {
				$this->mail->email = $support['email'];
			}
			if (isset($support['problem']) && !empty($support['problem'])) {
				//@TODO - Refactor and package ElegantMail properly to checkForm() and sendForm()
				ElegantMail::sendMail();
			}
		} else {
			$support = array();
		}

		// Assign the Form values to the Smarty template...
		foreach ($support as $key => $value) {
			$smarty->assign($key, stripslashes(urldecode($value)));
		}

		// Footer logos and links...
		$smarty->assign('logos',ElegantTools::objectToArray($this->config->credits->logos));

		// Master template with switching for panels
		$smarty->display('index.tpl');

	}

}