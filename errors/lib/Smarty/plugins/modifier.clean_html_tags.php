<?php
// $Id: function.keywords.php,v 1.3 2004/07/20 21:20:01 markwest Exp $
// ----------------------------------------------------------------------
// PostNuke Content Management System
// Copyright (C) 2002 by the PostNuke Development Team.
// http://www.postnuke.com/
// ----------------------------------------------------------------------
// Based on:
// PHP-NUKE Web Portal System - http://phpnuke.org/
// Thatware - http://thatware.org/
// ----------------------------------------------------------------------
// LICENSE
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------

/**
 * Xanthia plugin
 *
 * This file is a plugin for Xanthia, the PostNuke Theme engine
 *
 * @package        Xanthia_Templating_Environment
 * @subpackage     Xanthia
 * @version        $Id: function.keywords.php,v 1.3 2004/07/20 21:20:01 markwest Exp $
 * @author         The PostNuke development team
 * @link           http://www.postnuke.com The PostNuke Home Page
 * @copyright      Copyright (C) 2004 by the PostNuke Development Team
 * @license        http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

/**
 * Xanthia function to get the meta keywords
 *
 * This function will take the contents of the page and transfer it
 * into a keyword list. If stopwords are defined, they are filtered out.
 * The keywords are sorted by cont.
 * As a default, the whole page contents are taken as a base for keyword
 * generation. If set, the contents of "contents" are taken.
 * Beware that the function always returns the site keywords if "generate
 * meta keywords" is turned off.
 * PLEASE NOTE: This function adds additional overhead when dynamic keyword
 * generation is turned on. You should use Xanthia page caching in this case.
 *
 * available parameters:
 *  - contents    if set, this wil be taken as a base for the keywords
 *  - assign      if set, the keywords will be assigned to this variable
 *
 * Example
 * <meta name="KEYWORDS" content="<!--[keywords]-->">
 *
 * @author   Jörg Napp
 * @since    03. Feb. 04
 * @param    array    $params     All attributes passed to this function from the template
 * @param    object   $smarty     Reference to the Smarty object
 * @return   string   the keywords
 */

function smarty_modifier_clean_html_tags($string, $replace_with_space = true) {

    if (empty($string)) {die ("Pagecontent is empty"); }

  $string = html_entity_decode($string);

  return $string;

}


if (!function_exists('html_entity_decode')) {
    /**
     * html_entity_decode()
     *
     * Convert all HTML entities to their applicable characters
     * This function is a fallback if html_entity_decode isn't defined
     * in the PHP version used (i.e. PHP < 4.3.0).
     * Please note that this function doesn't support all parameters
     * of the original html_entity_decode function.
     *
     * @param  string $string the this function converts all HTML entities to their applicable characters from string.
     * @return the converted string
     * @link http://php.net/html_entity_decode The documentation of html_entity_decode
     **/
    function html_entity_decode($string)
    {
        $trans_tbl = get_html_translation_table(HTML_ENTITIES);
        $trans_tbl = array_flip($trans_tbl);
        return (strtr($string, $trans_tbl));
    }
}



?>