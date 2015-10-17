<?php

/**
 * ________ for
 * PostNuke Application Framework
 *
 * @copyright (c) 2006, Gordon Hackett
 * @link http://www.FireStartR.com
 * @version $Id: _______.php,v 0.1 ghackett September 2006 5:56:06 PM Exp $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @author Gordon Hackett
 * @package PostNuke_3rdParty_Modules
 * @subpackage _______
 * @generator HAPedit 3.1.11.111
 */

function smarty_function_date_now($params, &$smarty)
{
  if(empty($params['format']) || !isset($params['format'])) {
    $format = "%b %e, %Y";
  } else {
    $format = $params['format'];
  }
  return strftime($format,time());
}

?>

