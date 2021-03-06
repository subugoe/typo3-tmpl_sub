<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Ingo Pfennigstorf <pfennigstorf@sub.uni-goettingen.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
// add PageTS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:tmpl_sub/Configuration/TypoScript/030_PageTS/setup.txt">');

// RTE
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:tmpl_sub/Configuration/TypoScript/040_Rte/setup.txt">');

// add UserTS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:tmpl_sub/Configuration/TypoScript/020_UserTS/setup.txt">');


// add Rootlinefield for Pictureinheritance
$rootLineFields = &$GLOBALS["TYPO3_CONF_VARS"]['FE']['addRootLineFields'];
if ($rootLineFields != '') {
    $rootLineFields .= ' , ';
}

$rootLineFields .= 'tx_nkwsubmenu_picture_follow,tx_nkwsubmenu_knotheader,tx_nkwsubmenu_knot';

/**
 * Include TypoScript for tt_content before static
 */
$customFluidContentElementTypoScriptConstants = trim('
plugin.tx_tmplsub {
    view {
        templateRootPath = EXT:tmpl_sub/Resources/Private/Templates/
        partialRootPath = EXT:tmpl_sub/Resources/Private/Partials/
        layoutRootPath = EXT:tmpl_sub/Resources/Private/Layouts/
    }
}
');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
        $_EXTKEY,
        'constants',
        $customFluidContentElementTypoScriptConstants
);

/**
 * Include TypoScript for tt_content after static
 */
$customFluidContentElementTypoScriptSetup = trim('
tt_content.tmplsub_socialinfobox = COA
tt_content.tmplsub_socialinfobox {
    10 = < lib.stdheader
    20 = FLUIDTEMPLATE
    20 {
        file = {$plugin.tx_tmplsub.view.templateRootPath}ContentElements/Social.html
        partialRootPath = {$plugin.tx_tmplsub.view.partialRootPath}
        layoutRootPath = {$plugin.tx_tmplsub.view.layoutRootPath}
    }
}
');

$lectureFluidContentElementTypoScriptSetup = trim('
tt_content.tmplsub_lectures = COA
tt_content.tmplsub_lectures {
    10 = < lib.stdheader
    20 = FLUIDTEMPLATE
    20 {
        file = {$plugin.tx_tmplsub.view.templateRootPath}ContentElements/Lectures.html
        partialRootPath = {$plugin.tx_tmplsub.view.partialRootPath}
        layoutRootPath = {$plugin.tx_tmplsub.view.layoutRootPath}
    }
}
');

$openingHoursTypoScriptSetup = trim('
tt_content.tmplsub_openinghours = COA
tt_content.tmplsub_openinghours {
    10 = < lib.stdheader
    20 = FLUIDTEMPLATE
    20 {
        file = {$plugin.tx_tmplsub.view.templateRootPath}ContentElements/OpeningHours.html
        partialRootPath = {$plugin.tx_tmplsub.view.partialRootPath}
        layoutRootPath = {$plugin.tx_tmplsub.view.layoutRootPath}
    }
}
');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
    $_EXTKEY,
    'setup',
    $customFluidContentElementTypoScriptSetup,
    43
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
    $_EXTKEY,
    'setup',
    $lectureFluidContentElementTypoScriptSetup,
    43
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
    $_EXTKEY,
    'setup',
    $openingHoursTypoScriptSetup,
    43
);

$TYPO3_CONF_VARS['FE']['eID_include'][$_EXTKEY] = 'EXT:tmpl_sub/Resources/Private/Scripts/WordCounter.php';


// hook is called after Caching / pages with COA_/USER_INT objects.
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = 'EXT:ext/tmpl_sub/Classes/Hooks/ContentHook.php:&Subugoe\TmplSub\Hooks\ContentHook->noCache';

// hook is called before Caching / pages on their way in the cache.
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] = 'EXT:ext/tmpl_sub/Classes/Hooks/ContentHook.php:&Subugoe\TmplSub\Hooks\ContentHook->cache';
