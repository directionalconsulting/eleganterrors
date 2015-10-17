<?php
/**
 * Created by PhpStorm.
 * User: gman
 * Date: 9/18/15
 * Time: 1:34 PM
 * @author Gordon Hackett - Time Machine 2015 ~ 2004 rewrite in HTML 4.01, CSS 3, PHP 5.1+
 * @package Form Mail Contact Form
 * @note Collected files from WayBackMachine & .git + starting work now as recorded using wakatime
 * @example Begin work with proper tools and APIs @ 2015-09-18 13:46:30
 */
$debug = 'On';
require_once('lib/debug.inc.php');

// Define Globals
define ('_TLDDOMAIN', $_SERVER['HTTP_HOST']);
define ('_DEBUG', false);
define ('_ROOT', dirname(__DIR__));
define ('_BASE', basename(__DIR__));
define ('SMARTY_DIR', _ROOT."/"._BASE."/lib/Smarty/");
define ('_SITENAME', 'Elegant Errors');
define ('_INCLUDES',"lib/");

// Grab requirements for API
require_once( _INCLUDES . 'stopwatch.php' );

// Time it just to make sure it's not being abused or hanging
$stopwatch = new stopwatch;

// Build headers and forms by file loading .htm & .tpl templates using PHP and display
// @TODO - Updated 2015-09-18 16:27:43
// @TODO - convert Smarty.tpl files in folder to boilerplates for Contact Form - update & modify...
// @TODO - deploy and begin debugging, testing, sending emails, verifying headers / spam filters...
$success = 0;
$tryagain = 0;
if (isset($_POST)) {
    if (isset($_POST['cancel'])) {
        $type = '';
        $tryagain = 0;
        $cancel = 1;
        $location = "http://".$_SERVER['HTTP_HOST'];
        unset($_SESSION['captcha_keystring']);
        session_destroy();
        header("Location: $location");
    } else {
        if (count($_POST) > 0) {
            if (isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] == $_POST['keystring']) {
                $tryagain = 0;
                $success = 1;
            } else {
                $tryagain = 1;
            }
        }
    }
}

if ($success == 1) {
    // @TODO - Convert this to boilerplate .tpl & .htm for consistency and security - 2015-09-18 18:22:21
    // @TODO - Priority lowered - provided captcha works with session keys, with can just clean it up as is for now
    // @TODO ---> going to say yes, but first let's test as if I hadn't, then I think it's easy - 2015-09-18 18:41:41
    include_once( _INCLUDES . 'formmail.php' );
    exit(0);

} else {
    $displaytitle = "Contact Us at "._SITENAME;
    $keywords = "Contact "._SITENAME;
    $base = _ROOT;

    ShowEmail($keywords, $displaytitle, $base, $tryagain, $success);
    exit(0);
}

function ShowEmail($keywords, $displaytitle, $base, $tryagain, $success) {

    global $stopwatch;

    $folder = $_SERVER["REMOTE_ADDR"];
    $timestamp = strftime("%m-%d-%y_%H-%M",strtotime("now")) ;

    $time = date("r");

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


    /*
    extract($_POST);
    $email = stripslashes(urldecode($email));
    $first = stripslashes(urldecode($first));
    $last = stripslashes(urldecode($last));
    $address = stripslashes(urldecode($address));
    $city = stripslashes(urldecode($city));
    $state = stripslashes(urldecode($state));
    $file = stripslashes(urldecode($file));
    $file2 = stripslashes(urldecode($file2));
    $file3 = stripslashes(urldecode($file3));
    $message = stripslashes(urldecode($message));
    */
    require_once( SMARTY_DIR . "smarty.inc.php" );
    $smarty->assign('displaytitle', $displaytitle);
    $smarty->assign('folder', $folder);
    $smarty->assign('timestamp', $timestamp);
    $smarty->assign('keywords',$keywords);
    $smarty->assign('time', $time);
    $smarty->assign('base', $base);
    $smarty->assign('tryagain', $tryagain);
    $smarty->assign('success', $success);
    $smarty->assign('sitename', _SITENAME);
    $smarty->assign('elapsed', $stopwatch->get_elapsed());

    $smarty->assign('subject', "INQUIRY");
    foreach ($DATA as $key => $value) {
        $smarty->assign($key, stripslashes(urldecode($value)));
    }

    $smarty->display('contactus_index.tpl');

    return true;

}

?>
