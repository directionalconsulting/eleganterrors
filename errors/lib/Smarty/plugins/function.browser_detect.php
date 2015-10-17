<?php
/*
 * Created on Feb 11, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 *
 * Smarty {browser_detect} function plugin
 *
 * Type:     function
 * Name:     browser_detect
 * Purpose:  return true if the client browser matches supplied description.
 */


/* Usage:
 *
 *     1.   HI! the browser that you are using is <i>{browser_detect}</i> !
 *
 *     2.   The browser you are using is {browser_detect show="version"}
 *
 *     3.   The browser you are using is {browser_detect show="all"}
 *
 *     4.   {browser_detect vendor="ns"} or
 *          {browser_detect vendor="ie" version=4.5 assign=result} or
 *          {browser_detect vendor="ns" minversion=4.5 assign=result} or
 *          {browser_detect vendor="ie" majorversion=4 assign=result} or
 *          {browser_detect vendor="ie" majorversion=5 plattform=windows assign=result} or
 *          {browser_detect vendor="ns" majorversion=4 minorversion=5 assign=result}
 *
 *          {if $result} .... {/if}
 */

function smarty_function_browser_detect($params, &$smarty)
{

  global $_SERVER;
  $agent = $_SERVER['HTTP_USER_AGENT'];
  $result = $params['assign'];

/* A good list of agent strings can be found at
 * http://www.pgts.com.au/pgtsj/pgtsj0208c.html */

  $vendors = array('opera' => 'opera',
                   'googlebot' => 'bot',
                   'slurp' => 'bot',
                   'yahoo' => 'bot',
                   'msnbot' => 'bot',
                   'inktomi' => 'bot',
                   'scooter' => 'bot',
                   'fireball' => 'bot',
                   'fast-webcrawler' => 'bot',
                   'sidewinder' => 'bot',
                   'openbot' => 'bot',
                   'turnitinbot' => 'bot',
                   'infoseek' => 'bot',
                   'nutchorg' => 'bot',
                   'gulliver' => 'bot',
                   'robozilla' => 'bot',
                   'internetseer' => 'bot',
                   'teoma' => 'bot',
                   'zyborg' => 'bot',
                   'webtv' => 'webtv',
                   'mspie' => 'mspie',
                   'konqueror' => 'konqueror',
                   'icab' => 'icab',
                   'omniweb' => 'omniweb',
                   'phoenix' => 'phoenix',
                   'libwww' => 'lynx/amaya',
                   'safari' => 'safari',
                   'galeon' => 'galeon',
                   'compatible. ie' => 'ie',
                   'microsoft internet explorer' => 'ie',
                   'msie' => 'ie',
                   'firebird' => 'ns',
                   'mozilla' => 'ns',
                   'netscape' => 'ns',
                   'muscatferret' => 'bot',
                   'wget' => 'bot');

$plattforms = array(
  		   'windows' => 'windows',
  		   'mac'	  => 'mac',
  		   'linux'	  => 'linux',
  		   'compatible' => 'server'
  );

  while (list($match,$vendor)=each($vendors)) {
//    if (eregi($match.'[ /(v]{0,2}([0-9].[0-9a-zA-Z]{1,6})',$agent,$info)) {
    if (eregi($match,$agent,$info)) {
      if (!empty($info[1])) {
      $version=$info[1];
      $pos=strpos($version,".");
      } else {
      	$pos = ''; $version = '';
      }
      if ($pos>0) {
        $major_version=substr($version,0,$pos);
        $minor_version=substr($version,$pos+1,strlen($version));
      } else {
        $major_version=$version;
        $minor_version=0;
      }
      break;
    }
  }

while (list($match,$plattform) = each($plattforms)) {
  		if (eregi($match,$agent)) {
  			break;
		}
  }

  if (isset($params['vendor'])) {
     if (strcmp($vendor,$params['vendor'])) {
       if (isset($result)) $smarty->assign($result,false);
       return "";
    }
  }

  if (isset($params['plattform'])) {
     if (strcmp($plattform,$params['plattform'])) {
       if (isset($result)) $smarty->assign($result,false);
       return "";
    }
  }

  if (isset($params['version'])) {
     if ($version != $params['version']) {
       if (isset($result)) $smarty->assign($result,false);
       return "";
    }
  }

  if (isset($params['minversion'])) {
     if ((float)$version < (float)$params['minversion']) {
       if (isset($result)) $smarty->assign($result,false);
       return "";
    }
  }

  if (isset($params['majorversion'])) {
     if ($major_version != (int)$params['majorversion']) {
       if (isset($result)) $smarty->assign($result,false);
       return "";
    }
  }

  if (isset($params['minorversion'])) {
     if ($minor_version != (int)$params['minorversion']) {
       if (isset($result)) $smarty->assign($result,false);
       return "";
    }
  }

  if (isset($result)) {
    $smarty->assign($result,true);
    return "";
  }

  if (isset($params['show'])) {
    if (!strcmp($params['show'],"version")) {
      return "$plattform $vendor $version";
    }
  }
  return $vendor;
}
?>
