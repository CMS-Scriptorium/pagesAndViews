<?php

/**
 * @module  pagesAndView
 * @author  Dietrich Roland Pehlke
 * @license wtfpl
 *
 */

// include secure.php to protect this file and the whole CMS!
if(!defined("SEC_FILE")){define("SEC_FILE",'/framework/secure.php' );}
if (defined('LEPTON_PATH')) {
    include LEPTON_PATH.SEC_FILE;
} else {
    $oneback = "../";
    $root = $oneback;
    $level = 1;
    while (($level < 10) && (!file_exists($root.SEC_FILE))) {
        $root .= $oneback;
        $level += 1;
    }
    if (file_exists($root.SEC_FILE)) {
        include $root.SEC_FILE;
    } else {
        trigger_error(sprintf("[ <b>%s</b> ] Can't include secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
    }
}
// end include secure.php

$module_directory   = 'pagesAndViews';
$module_name        = 'Pages and views';
$module_function    = 'tool';
$module_version     = '0.1.0';
$module_platform    = '7.x';
$module_author      = 'Dietrich Roland Pehlke';
$module_home        = '-';
$module_guid        = 'F277201C-C306-41B8-8365-561B265778AB';
$module_license     = 'wtfpl';
$module_description = 'Private addon to edit viewing groups for pages.';
