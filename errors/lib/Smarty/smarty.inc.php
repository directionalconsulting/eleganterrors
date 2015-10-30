<?php
// Load our Smarty library using our predefined location...
require_once(_SMARTY.'Smarty.class.php');

$smarty = new Smarty;
if (_DEBUG) {
	$smarty->debugging = true;
}
// @TODO - Add Smarty caching options to config file including time to expire and refresh...
$smarty->caching = 0;
$smarty->compile_check = true;
$smarty->cache_modified_check = true;
$smarty->php_handling = SMARTY_PHP_ALLOW;

// Optionally change the deliminters for your templates... - hard wired
$smarty->left_delimiter = '<!--[';
$smarty->right_delimiter = ']-->';

// Directories require read & write permissions by apache / www-data user or suexec... 775
$smarty->template_dir = _SMARTY."templates";
$smarty->compile_dir = _SMARTY."templates_c";
$smarty->cache_dir = _SMARTY."cache";

//$smarty->config_dir = _SMARTY."configs";

?>