<?php
/*
 * Smarty plugin "ImageText"
 * Purpose: creates graphical headlines
 * Home: http://www.cerdmann.com/imagetext/
 * Copyright (C) 2005 Christoph Erdmann
 *
 * This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; either version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA
 * -------------------------------------------------------------
 * For changelog take a look at shared.imagetext.php
 * -------------------------------------------------------------
 */

if (eregi('Win', $envsoft )) { define('_WINDOWS', 'TRUE'); }
if (_WINDOWS == 'TRUE') { define('SLASH','\\'); } else { define('SLASH', '/'); }

function smarty_prefilter_imagetext($content, &$smarty)
    {
    $ldelim = $smarty->left_delimiter;
    $rdelim = $smarty->right_delimiter;

    require_once $smarty->_get_plugin_filepath('shared','imagetext');
    $path = getcwd;
    $config = readINIfile("textcache/styles.ini",';');
    $keys = array_keys($config);

    if (!function_exists('cleanup'))
        {
        function cleanup($content)
            {
            $content = preg_replace("=\r\n|\r|\n=", '', $content);
            $content = preg_replace("=<br( /)?>=i", "\n", $content);
            $content = str_replace("\t", '', $content);
            $content = stripslashes($content);
            return $content;
            }
        }

    foreach ($keys as $key)
        {
        $content = preg_replace("=<$key( [^>]*)?>(.*?)</$key>=se", "'$ldelim'.'imagetext_block style=\"$key\" '.stripslashes('\\1').'$rdelim'.cleanup('\\2').'$ldelim'.'/imagetext_block'.'$rdelim'", $content);
        }

    return $content;
    }

?>