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

function smarty_function_pagemeter($params, &$smarty)
{
$pagebar = $smarty->_tpl_vars['pagerank'];
$base = $smarty->_tpl_vars['base'];

  while ($pagebar > 0) {

  $pagemeter .= '<img src="'.$base.'/images/pixel.gif" alt="" height="10" width="25" class="pagemeter" title="Google Page Rank score '.$pagerank.' out of 10" />';
  $pagebar = $pagebar - 1;
  }
  $smarty->assign('pagemeter', $pagemeter);
}

?>

