<?php
$envsoft = $_ENV["OS"];
if (eregi('Win', $envsoft ) || (isset($windows) && $windows == 1)) { define('_WINDOWS', 'TRUE'); } else { define('_WINDOWS', 'FALSE'); }
if (_WINDOWS == 'TRUE') {
//echo "Windows = true<br>\n";
        define('SLASH','\\');
        define('SEPERATOR',';');
//        define('SMARTY_DIR','C:\Program Files\xampp\htdocs\sitereviewboard\includes\Smarty\\');
        define('EXTRAPATH', $_ENV['Path']);
        define('BASE', preg_replace("/\\\\includes/sm", "\\", dirname(__FILE__)));
        define('SMARTY_DIR',BASE.'includes\\Smarty\\');
//        define('BASE','C:\Program Files\xampp\htdocs\sitereviewboard\\' );
} else {
//echo "Linux = true<br>\n";
        define('BASE', preg_replace("%/includes%sm", "/", dirname(__FILE__)));
        define('SMARTY_DIR',BASE.'forms/Smarty/');
        define('EXTRAPATH', $_ENV['PATH']);
        define('SLASH', '/');
        define('SEPERATOR',':'); }

function smarty_function_rss_feed ($params, &$smarty) {

        if (!isset($params['type'])) {
            $params['type'] = 'recent';
        }

        if (empty($params['type'])) {
          die("rss export errors: missing either 'type' parameter");
          return;
        }
require_once (BASE.'includes'.SLASH.'rss_generator.inc.php');

$rss_image = new rssGenerator_image();
$rss_image->url = 'http://www.sitereviewboard/images/srb_sm_review_clear.gif';
$rss_image->title = 'Site Review Board - Look Before You Leap';
$rss_image->link = 'http://www.sitereviewboard/recent/check.html';
$rss_image->width = 125;
$rss_image->height = 30;
$rss_channel->image = $rss_image;


if ($params['type']=='recent') {
require(BASE.SLASH.'includes'.SLASH.'adodb.config.php');
$db =& ADONewConnection($driver); # eg. 'mysql' or 'oci8'
$db->debug = _SITE_DEBUG;
$db->NConnect($server, $user, $password, $database);

$sql = "SELECT `url` , `pagetitle`, `reviews` , `timg` , `metatags` , `link` , `time`
FROM `sites`
WHERE 1
ORDER BY `time` DESC
LIMIT 0 , 25;";

$rs = $db->Execute($sql);
if (_SITE_DEBUG) { echo "<br>&nbsp;<br>\n"; }  //  Break up ADODB debug ouput

if (!$rs->EOF) {

while (!$rs->EOF) {
  $latesturls[]  = array('url' => $rs->fields['url'],
                   'pagetitle' => $rs->fields['pagetitle'],
                   'reviews' => $rs->fields['reviews'],
                   'timg' => $rs->fields['timg'],
                   'metatags' => $rs->fields['metatags'],
                   'link' => preg_replace('%^http://\\w{1,}.\\w{1,}.com(.+)$%si', '$1', $rs->fields['link']),
                   'time' => $rs->fields['time']);
  $rs->MoveNext();
}

} else {

return false;  //  actually need a serious errors dump here since sites database is empty

}

$rss_channel = new rssGenerator_channel();
$rss_channel->title = 'Site Review Board Latest Additions';
$rss_channel->link = 'http://www.sitereviewboard/recent/check.html';
$rss_channel->description = 'The latest news about found sites and tags we are currently crawling on the web.';
$rss_channel->language = 'en-us';
//$rss_channel->generator = 'PHP RSS Feed Generator';
$rss_channel->managingEditor = 'editor@sitereviewboard';
$rss_channel->webMaster = 'webmaster@sitereviewboard';

while(list($key, $val) = each($latesturls)) {
   $displaytitle = '';
   $tagarray = unserialize($val['metatags']);
    if (is_array($tagarray) && !empty($tagarray)) {
       while(list($count, $tag) = each($tagarray)) {
           //echo "$key => $val<br>\n";
           $display = strtolower(preg_replace("/_/", " ", $tag));
           $displaytitle .= $display.", ";
         }
    $displaytitle = preg_replace('/(,\\s$)/sm', '', $displaytitle);
   }
   // $title = $val['url'];
    $title = $val['url']." - ".$val['pagetitle'];
    //$reviewsaz = "reviews-".substr($title,0,2);
    $link = $val['link'];
//    $time = strftime("%B %d %Y %I:%M %p %Z", strtotime($val['time']));
    $time = date("r", strtotime($val['time']));

  $item = new rssGenerator_item();
  $item->title = "$title";
  $item->guid = "http://www.sitereviewboard$link";
  $item->guid_isPermaLink = 1;
  $item->description = "$displaytitle";
  $item->link = "http://www.sitereviewboard$link";
  $item->pubDate = "$time";
  $rss_channel->items[] = $item;
}
} elseif ($params['type']='custom') {

$tag = urldecode($params['q']);
$tag = preg_replace("/\+/", "_", $tag);
$tag = preg_replace("/ /", "_", $tag);

$tagsaz = "tags-".substr($tag, 0, 2);

$rss_channel = new rssGenerator_channel();
$rss_channel->title = 'Site Review Board Latest Additions';
$rss_channel->link = "http://www.sitereviewboard/$tagsaz/$tag/check.html";

$tag = preg_replace("/_/", " ", $tag);

$rss_channel->description = "Custom results found for \"$tag\" while crawling the web.";
$rss_channel->language = 'en-us';
//$rss_channel->generator = 'PHP RSS Feed Generator';
$rss_channel->managingEditor = 'editor@sitereviewboard';
$rss_channel->webMaster = 'webmaster@sitereviewboard';


//define('RECORDS_BY_PAGE', 50);

require(BASE.SLASH.'includes'.SLASH.'adodb.config.php');
//require(BASE.SLASH.'includes'.SLASH.'easypage.php');
$db =& ADONewConnection($driver); # eg. 'mysql' or 'oci8'
$db->debug = _SITE_DEBUG;
$db->NConnect($server, $user, $password, $database);

//$tagfile = $tag;
//$tag = preg_replace("/_/", " ", $tag);

/*
      $sql = "SELECT `url` ,
                     `pagetitle` ,
                     `reviews` ,
                     `timg` ,
                     `pagerank` ,
                     `metatags`,
                     `link` ,
                     `base` ,
                     `time`
                FROM `sites`
                WHERE `metatag` REGEXP ('$tag')
                ORDER BY `time` DESC
                LIMIT 0 , 25;";
*/

$sql = "SELECT `url`, `pagetitle`, `reviews`, `timg`, `pagerank`, `metatags`, `link`, `base`, `time` FROM `sites` WHERE `metatag` REGEXP ('$tag') ORDER BY `time` DESC LIMIT 0, 25;";


$rs =& $db->Execute($sql);
//$rs = $db->PageExecute($sql,RECORDS_BY_PAGE,CURRENT_PAGE);  //$db->PageExecute($sql,RECORDS_BY_PAGE,CURRENT_PAGE);

if (!$rs) {
   //echo "Serious Error the sites database is missing this tag '$tag', yet it exists in tags. Skipping this tag!<br>\n";
   return false;
} else {

//$urls = array();
//$recordsFound = $rs->_maxRecordCount;

while (!$rs->EOF) {
//  $urls[] = $rs->fields;
  $urls[]   = array('url' => $rs->fields['url'],
                   'pagetitle' => $rs->fields['pagetitle'],
                   'reviews' => $rs->fields['reviews'],
                   'timg' => $rs->fields['timg'],
                   'pagerank' => $rs->fields['pagerank'],
                   'metatags' => $rs->fields['metatags'],
                   'link' => $rs->fields['link'],
                   'base' => $rs->fields['base'],
                   'time' => $rs->fields['time']);
  $rs->MoveNext();
      }
  }

reset($urls);

//echo var_dump($urls);

while(list($key, $val) = each($urls)) {
   $displaytitle = '';
   $tagarray = unserialize($val['metatags']);
    if (is_array($tagarray) && !empty($tagarray)) {
       while(list($count, $tag) = each($tagarray)) {
           //echo "$key => $val<br>\n";
           $display = strtolower(preg_replace("/_/", " ", $tag));
           $displaytitle .= $display.", ";
         }
    $displaytitle = preg_replace('/(,\\s$)/sm', '', $displaytitle);
   }
  //  $title = $val['url'];
    $title = $val['url']." - ".$val['pagetitle'];
    $reviewsaz = "reviews-".substr($val['url'],0,2);
    $link = $_SERVER['SERVER_NAME']."/$reviewsaz/".preg_replace("/\./","-",$val['url']).".html";
    $time = date("r", strtotime($val['time']));

  $item = new rssGenerator_item();
  $item->title = "$title";
  $item->guid = "http://$link";
  $item->guid_isPermaLink = 1;
  $item->description = "$displaytitle";
  $item->link = "http://$link";
  $item->pubDate = "$time";
  $rss_channel->items[] = $item;
}

} elseif ($type == 'home') {

$urls = $params['urls'];

while(list($key, $val) = each($urls)) {
   $displaytitle = '';
   $tagarray = unserialize($val['metatags']);
    if (is_array($tagarray) && !empty($tagarray)) {
       while(list($count, $tag) = each($tagarray)) {
           //echo "$key => $val<br>\n";
           $display = strtolower(preg_replace("/_/", " ", $tag));
           $displaytitle .= $display.", ";
         }
    $displaytitle = preg_replace('/(,\\s$)/sm', '', $displaytitle);
   }
  //  $title = $val['url'];
    $title = $val['url']." - ".$val['pagetitle'];
    $reviewsaz = "reviews-".substr($val['url'],0,2);
    $link = $_SERVER['SERVER_NAME']."/$reviewsaz/".preg_replace("/\./","-",$val['url']).".html";
    $time = date("r", strtotime($val['time']));

  $item = new rssGenerator_item();
  $item->title = "$title";
  $item->guid = "http://$link";
  $item->guid_isPermaLink = 1;
  $item->description = "$displaytitle";
  $item->link = "http://$link";
  $item->pubDate = "$time";

}
}

/*
  $item = new rssGenerator_item();
  $item->title = 'Another website launched';
  $item->description = 'Just another website launched.';
  $item->link = 'http://anothersite.com';
  $item->pubDate = 'Wen, 08 Mar 2006 00:00:01 GMT';
  $rss_channel->items[] = $item;
 */

  $rss_feed = new rssGenerator_rss();
  $rss_feed->encoding = 'UTF-8';
  $rss_feed->version = '2.0';
  header('Content-Type: text/xml');
  echo $rss_feed->createFeed($rss_channel);

}
?>