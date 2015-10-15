<?php

if (_DEBUG) {
	echo "<br />smarty.inc.php found - ".SMARTY_DIR."cache * templates * templates_c<br />\n";
}
require(SMARTY_DIR.'Smarty.class.php');
$smarty = new Smarty;
$smarty->caching = 0;
$smarty->compile_check = true;
$smarty->cache_modified_check = true;
$smarty->php_handling = SMARTY_PHP_ALLOW;

if (_DEBUG) {
	$smarty->debugging = true;
}

//$smarty->left_delimiter = '<!--[';
//$smarty->right_delimiter = ']-->';

$smarty->template_dir = SMARTY_DIR."templates";
$smarty->compile_dir = SMARTY_DIR."templates_c";
$smarty->cache_dir = SMARTY_DIR."cache";
//$smarty->config_dir = SMARTY_DIR."configs";

?>